<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//對建立的socket迴圈進行監聽，處理資料


//下面是sock類
class Sock{
    public $sockets; //socket的連線池，即client連線進來的socket標誌
    public $users;   //所有client連線進來的資訊，包括socket、client名字等
    public $master;  //socket的resource，即前期初始化socket時返回的socket資源
    private $sda=array();   //已接收的資料
    private $slen=array();  //資料總長度
    private $sjen=array();  //接收資料的長度
    private $ar=array();    //加密key
    private $n=array();
    public function __construct($address='127.0.0.1', $port='8880'){

        //建立socket並把儲存socket資源在$this->master
        $this->master=$this->WebSocket($address, $port);

        //建立socket連線池
        $this->sockets=array($this->master);
    }
    //對建立的socket迴圈進行監聽，處理資料 
    function run(){
        //死迴圈，直到socket斷開
        while(true){
            $changes=$this->sockets;
            $write=NULL;
            $except=NULL;
            /*
            //這個函數是同時接受多個連線的關鍵，我的理解它是為了阻塞程式繼續往下執行。
            socket_select ($sockets, $write = NULL, $except = NULL, NULL);

            $sockets可以理解為一個陣列，這個陣列中存放的是檔案描述符。當它有變化（就是有新訊息到或者有用戶端連線/斷開）時，socket_select函數才會返回，繼續往下執行。 
            $write是監聽是否有用戶端寫資料，傳入NULL是不關心是否有寫變化。 
            $except是$sockets裡面要被排除的元素，傳入NULL是」監聽」全部。 
            最後一個引數是超時時間 
            如果為0：則立即結束 
            如果為n>1: 則最多在n秒後結束，如遇某一個連線有新動態，則提前返回 
            如果為null：如遇某一個連線有新動態，則返回
            */
            socket_select($changes,$write,$except,NULL);
            foreach($changes as $sock){
                //如果有新的client連線進來，則
                if($sock==$this->master){
                    //接受一個socket連線
                    $client=socket_accept($this->master);

                    //給新連線進來的socket一個唯一的ID
                    $key=uniqid();
                    $this->sockets[]=$client;  //將新連線進來的socket存進連線池
                    $this->users[$key]=array(
                        'socket'=>$client,  //記錄新連線進來client的socket資訊
                        'member_id'=>'',
                        'to_member_id'=>'',
                        'name'=>'',
                        'shou'=>false       //標誌該socket資源沒有完成握手
                    );
                //否則1.為client斷開socket連線，2.client傳送資訊
                }else{
                    $len=0;
                    $buffer='';
                    //讀取該socket的資訊，注意：第二個引數是參照傳參即接收資料，第三個引數是接收資料的長度
                    do{
                        $l=socket_recv($sock,$buf,1000,0);
                        $len+=$l;
                        $buffer.=$buf;
                    }while($l==1000);

                    //根據socket在user池裡面查詢相應的$k,即健ID
                    $k=$this->search($sock);

                    //如果接收的資訊長度小於7，則該client的socket為斷開連線
                    if($len<7){
                        //給該client的socket進行斷開操作，並在$this->sockets和$this->users裡面進行刪除
                        $this->send2($k);
                        continue;
                    }
                    //判斷該socket是否已經握手
                    if(!$this->users[$k]['shou']){
                        //如果沒有握手，則進行握手處理
                        $this->woshou($k,$buffer);
                    }else{
                        //走到這裡就是該client傳送資訊了，對接受到的資訊進行uncode處理
                        // $buffer = $this->uncode($buffer,$k);
                        // if($buffer==false){
                        //     continue;
                        // }
                        $received_text = $this->unmask($buf); //unmask data 解密
                        $tst_msg='';
                        $g = json_decode($received_text,true); //json decode
                        if(!empty($g)&&$g['type']=='join_name'){
                            $this->users[$k]['name']=$g['join_name'];
                            $this->users[$k]['to_member_id']=$g['to_member'];
                            $this->users[$k]['member_id']=$g['member_id'];
                            continue;
                        }
                        //如果不為空，則進行訊息推播操作
                        $this->send1($g);
                    }
                }
            }

        }

    }

    //Unmask incoming framed message
    function unmask($text) {
        $length = ord($text[1]) & 127; //ord() 函数返回字符串的首个字符的 ASCII 值。
        if($length == 126) {
            $masks = substr($text, 4, 4);
            $data = substr($text, 8);
        }
        elseif($length == 127) {
            $masks = substr($text, 10, 4);
            $data = substr($text, 14);
        }
        else {
            $masks = substr($text, 2, 4);
            $data = substr($text, 6);
        }
        $text = "";
        for ($i = 0; $i < strlen($data); ++$i) {
            $text .= $data[$i] ^ $masks[$i%4];
        }
        return $text;
    }
    //指定關閉$k對應的socket
    function close($k){
        //斷開相應socket
        socket_close($this->users[$k]['socket']);
        //刪除相應的user資訊
        unset($this->users[$k]);
        //重新定義sockets連線池
        $this->sockets=array($this->master);
        foreach($this->users as $v){
            $this->sockets[]=$v['socket'];
        }
        //輸出紀錄檔
        $this->e("key:$k close");
    }

    //根據sock在users裡面查詢相應的$k
    function search($sock){
        foreach ($this->users as $k=>$v){
            if($sock==$v['socket'])
            return $k;
        }
        return false;
    }

    //傳相應的IP與埠進行建立socket操作
    function WebSocket($address,$port){
        $server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_set_option($server, SOL_SOCKET, SO_REUSEADDR, 1);//1表示接受所有的封包
        socket_bind($server, $address, $port)or die("socket_bind() 失敗的原因是:" . socket_strerror(socket_last_error()) . "/n");
        socket_listen($server);
        $this->e('Server Started : '.date('Y-m-d H:i:s'));
        $this->e('Listening on   : '.$address.' port '.$port);
        return $server;
    }

    /*
    * 函數說明：對client的請求進行回應，即握手操作
    * @$k clien的socket對應的健，即每個使用者有唯一$k並對應socket
    * @$buffer 接收client請求的所有資訊
    */
    function woshou($k,$buffer,$host='localhost'){

        //擷取Sec-WebSocket-Key的值並加密，其中$key後面的一部分258EAFA5-E914-47DA-95CA-C5AB0DC85B11字串應該是固定的
        $buf  = substr($buffer,strpos($buffer,'Sec-WebSocket-Key:')+18);
        $key  = trim(substr($buf,0,strpos($buf,"\r\n")));
        $new_key = base64_encode(sha1($key."258EAFA5-E914-47DA-95CA-C5AB0DC85B11",true));


        $new_message  = "HTTP/1.1 101 Switching Protocol\r\n" .
             "Upgrade: websocket\r\n" .
             "Connection: Upgrade\r\n" .
             "Sec-WebSocket-Accept: " . $new_key . "\r\n\r\n";  //必须以两个回车结尾
        socket_write($this->users[$k]['socket'],$new_message,strlen($new_message));

        //對已經握手的client做標誌
        $this->users[$k]['shou']=true;
        return true;
    }

    //解碼函數
    function uncode($str,$key){
        $mask = array();  
        $data = '';  
        $msg = unpack('H*',$str);
        $head = substr($msg[1],0,2);  
        if ($head == '81' && !isset($this->slen[$key])) {  
            $len=substr($msg[1],2,2);
            $len=hexdec($len);//把十六進位制的轉換為十進位制
            if(substr($msg[1],2,2)=='fe'){
                $len=substr($msg[1],4,4);
                $len=hexdec($len);
                $msg[1]=substr($msg[1],4);
            }else if(substr($msg[1],2,2)=='ff'){
                $len=substr($msg[1],4,16);
                $len=hexdec($len);
                $msg[1]=substr($msg[1],16);
            }
            $mask[] = hexdec(substr($msg[1],4,2));
            $mask[] = hexdec(substr($msg[1],6,2));
            $mask[] = hexdec(substr($msg[1],8,2));
            $mask[] = hexdec(substr($msg[1],10,2));
            $s = 12;
            $n=0;
        }else if($this->slen[$key] > 0){
            $len=$this->slen[$key];
            $mask=$this->ar[$key];
            $n=$this->n[$key];
            $s = 0;
        }
        $e = strlen($msg[1])-2;
        for ($i=$s; $i<= $e; $i+= 2) {
            $data .= chr($mask[$n%4]^hexdec(substr($msg[1],$i,2)));
            $n++;
        }
        $dlen=strlen($data);

        if($len > 255 && $len > $dlen+intval($this->sjen[$key])){
            $this->ar[$key]=$mask;
            $this->slen[$key]=$len;
            $this->sjen[$key]=$dlen+intval($this->sjen[$key]);
            $this->sda[$key]=$this->sda[$key].$data;
            $this->n[$key]=$n;
            return false;
        }else{
            unset($this->ar[$key],$this->slen[$key],$this->sjen[$key],$this->n[$key]);
            if(!empty($this->sda[$key]))$data=$this->sda[$key].$data;
            unset($this->sda[$key]);
            return $data;
        }

    }

    //與uncode相對
    function code($msg){
        $frame = array();
        $frame[0] = '81';
        $len = strlen($msg);
        if($len < 126){
            $frame[1] = $len<16?'0'.dechex($len):dechex($len);
        }else if($len < 65025){
            $s=dechex($len);
            $frame[1]='7e'.str_repeat('0',4-strlen($s)).$s;
        }else{
            $s=dechex($len);
            $frame[1]='7f'.str_repeat('0',16-strlen($s)).$s;
        }
        $frame[2] = $this->ord_hex($msg);
        $data = implode('',$frame);
        return pack("H*", $data);
    }

    function ord_hex($data)  {
        $msg = '';
        $l = strlen($data);
        for ($i= 0; $i<$l; $i++) {
            $msg .= dechex(ord($data{$i}));
        }
        return $msg;
    }

    //使用者加入或client傳送資訊
    function send($g){
        //將查詢字串解析到第二個引數變數中，以陣列的形式儲存如：parse_str("name=Bill&age=60",$arr)
        // parse_str($msg,$g);
        // $ar=array();
        if($g['type']=='usermsg'){
            $this->e(print_r($g));
            $this->e(print_r($this->users));
        }else{
            //傳送資訊行為，其中$g['key']表示面對大家還是個人，是前段傳過來的資訊
            $ar['nrong']=$g['nr'];
            $key=$g['key'];
        }
        //推播資訊
        //$this->send1($g);
    }
    //對新加入的client推播已經線上的client
    function getusers(){
        $ar=array();
        foreach($this->users as $k=>$v){
            $ar[]=array('code'=>$k,'name'=>$v['name']);
        }
        return $ar;
    }
    //$k 發資訊人的socketID $key接受人的 socketID ，根據這個socketID可以查詢相應的client進行訊息推播，即指定client進行傳送
    function send1($g){
        //對傳送資訊進行編碼處理
        foreach ($this->users as $k => $v) {
            if($v['member_id']==$g['member_id']||$v['member_id']==$g['to_member_id']){
                $g['class']=($v['member_id']==$g['member_id'])?'from':'to';
                $str = $this->code(json_encode($g));
                socket_write($v['socket'],$str,strlen($str));
            }
        }
    }
    //使用者退出向所用client推播資訊
    function send2($k){
        $this->close($k);
        $ar['type']='rmove';
        $ar['nrong']=$k;
        $this->send1(false,$ar,'all');
    }
    //記錄紀錄檔
    function e($str){
        //$path=dirname(__FILE__).'/log.txt';
        $str=$str."\n";
        //error_log($str,3,$path);
        //編碼處理
        echo iconv('utf-8','gbk//IGNORE',$str);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class WebSocket {

    private $socket;

    private $clients;
    private $user;

    private $join_list = array();
    private $host='108.160.128.163';
    private $port='9000';

    public function __construct($max=100) {
    	//Create TCP/IP sream socket (建立socket)
    	$this->socket = $this->Sock();
        $this->clients =[$this->socket] ;
        //create & add listning socket to the list
    }

    //傳相應的IP與埠進行創建socket操作
	function Sock(){

		$server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("socket_create() 失敗的原因是:" . socket_strerror(socket_last_error()) . "/n"); ;
	    socket_set_option($server, SOL_SOCKET, SO_REUSEADDR, 1)or die("socket_set_option() 失敗的原因是:" . socket_strerror(socket_last_error()) . "/n");//1表示接受所有的數據包
	    socket_bind($server, $this->host, $this->port)or die("socket_bind() 失敗的原因是:" . socket_strerror(socket_last_error()) . "/n");
	    socket_listen($server)or die("socket_listen() 失敗的原因是:" . socket_strerror(socket_last_error()) . "/n");
	    //$this->e('Server Started : '.date('Y-m-d H:i:s'));
	    //$this->e('Listening on  : '.$address.' port '.$port);
		return $server;
	}

    public function run() {
    	$null=NULL;
        //start endless loop, so that our script doesn't stop
		while (true) {
			//manage multipal connections
			$changed = $this->clients;
			//returns the socket resources in $changed array 多線程(接受多個socket連接)
			socket_select($changed, $null, $null, 0, 10);
			// print_r($this->socket);
			//check for new socket
			if (in_array($this->socket, $changed)) {
				$socket_new = socket_accept($this->socket); //accpet new socket (接受新的socket，一旦成功建立socket连接，将会返回一个新的socket资源)
				$this->clients[] = $socket_new; //add socket to client array
				$header = socket_read($socket_new, 1024); //read data sent by the socket
				$this->perform_handshaking($header, $socket_new, $this->host, $this->port); //perform websocket handshake (寫數據至socket, 從 HTTP 協定升級為 WebSocket 協定)

				socket_getpeername($socket_new, $ip); //get ip address of connected socket
				$response = $this->mask(json_encode(array('type'=>'system','info'=>'enter', 'message'=>$ip.' 已連線'))); //prepare json data (mask:包裹資料成為二進制字串)
				$this->send_message($response,$socket_new); //notify all users about new connection (發送至每個socket)
				//make room for new socket
				$found_socket = array_search($this->socket, $changed);//搜索socket在changed陣列的index
				unset($changed[$found_socket]);
			}
			//$join_list=[];
			//loop through all connected sockets
			foreach ($changed as $changed_socket) {
				//check for any incomming data
				while(@socket_recv($changed_socket, $buf, 1024, 0) >= 1) //讀取socket數據並存在$buf
				{
					$received_text = $this->unmask($buf); //unmask data 解密
					$tst_msg='';
					$tst_msg = json_decode($received_text); //json decode

					if(!empty($tst_msg)&&$tst_msg->type=='join_name'){
						//名稱輸入
						$join_name = $tst_msg->join_name; //sender name
						$member_id = $tst_msg->member_id;
						$to_member_id = $tst_msg->to_member;
						//找key值
						foreach ($this->join_list as $k => $v) {
							if($v['member_id']==$member_id){
								unset($this->join_list[$k]);
								unset($this->user[$member_id]);
							}
						}
						$this->user[$member_id]=$changed_socket;
						$key = array_keys($this->clients,$changed_socket);
						$this->join_list[$key[0]]['join_name']=$join_name;
						$this->join_list[$key[0]]['member_id']=$member_id;
						$this->join_list[$key[0]]['to_member_id']=$to_member_id;
						$response_text = $this->mask(json_encode(array('type'=>'join_name', 'join_name'=>$join_name,'color'=>'','join_list'=>$this->join_list)));
					}else{
						if(!empty($tst_msg)){
							//訊息輸入
							$user_name = $tst_msg->name; //sender name
							$user_message = $tst_msg->message; //message text
							$member_id = $tst_msg->member_id; //message text
							$user_color = $tst_msg->color; //color
							$to_member_id = $tst_msg->to_member;
							//prepare data to be sent to client (mask 加密轉換)
							$response_text = $this->mask(json_encode(array('type'=>'usermsg', 'name'=>$user_name, 'member_id'=>$member_id, 'message'=>$user_message, 'color'=>$user_color)));
						}
					}
					$this->send_message($response_text,$this->user[$member_id]);
					if(!empty($this->user[$to_member_id]))$this->send_message($response_text,$this->user[$to_member_id]);
					$response_text='';
					break 2; //exist this loop
				}
				$buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);
				if ($buf === false) { // check disconnected client 若socket無連線
					//移除名單
					//找key值
					$key = array_keys($this->clients,$changed_socket);
					$key2 = array_keys($this->clients,$changed_socket);
					// remove client for $clients array 從socket clients陣列移除
					$found_socket = array_search($changed_socket, $this->clients);
					socket_getpeername($changed_socket, $ip);//取得來源socket IP 及 post
					unset($this->clients[$found_socket]);
					if(!empty($this->join_list[$key[0]]['join_name']))$member_id=$this->join_list[$key[0]]['member_id'];
					//notify all users about disconnected connection
					$leave_name =(empty($this->join_list[$key[0]]['join_name']))?'': $this->join_list[$key[0]]['join_name'];
					$to_member_id =(empty($this->join_list[$key[0]]['to_member']))?'': $this->join_list[$key[0]]['to_member'];
					unset($this->join_list[$key[0]]);
					echo $this->user[$to_member_id]."\r\n";
					$response = $this->mask(json_encode(array('type'=>'system', 'info'=>'leave','message'=>$leave_name.' 離線','join_list'=>$this->join_list)));
					$this->send_message($response,$changed_socket);
					if(!empty($this->user[$to_member_id]))$this->send_message($response,$this->user[$to_member_id]);
				}
			}
			//die('1230');
		}
		socket_close($this->socket);
    }

    function send_message($msg,$changed_socket=''){
		//global $clients;
		@socket_write($changed_socket,$msg,strlen($msg));
		return true;
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

	//Encode message for transfer to client.
	function mask($text){
		$b1 = 0x80 | (0x1 & 0x0f);
		$length = strlen($text);
		if($length <= 125)
			$header = pack('CC', $b1, $length);//pack 包裹資料成為二進制字串
		elseif($length > 125 && $length < 65536)
			$header = pack('CCn', $b1, 126, $length);
		elseif($length >= 65536)
			$header = pack('CCNN', $b1, 127, $length);
		return $header.$text;
	}

	//handshake new client. (從 HTTP 協定升級為 WebSocket 協定)
	function perform_handshaking($receved_header,$client_conn, $host, $port){
		//擷取Sec-WebSocket-Key的值並加密，其中$key後面的一部分258EAFA5-E914-47DA-95CA-C5AB0DC85B11字串應該是固定的
        $buf  = substr($receved_header,strpos($receved_header,'Sec-WebSocket-Key:')+18);
        $key  = trim(substr($buf,0,strpos($buf,"\r\n")));
        $new_key = base64_encode(sha1($key."258EAFA5-E914-47DA-95CA-C5AB0DC85B11",true));


        $new_message  = "HTTP/1.1 101 Switching Protocol\r\n" .
             "Upgrade: websocket\r\n" .
             "Connection: Upgrade\r\n" .
             "Sec-WebSocket-Accept: " . $new_key . "\r\n\r\n";  //必须以两个回车结尾
        socket_write($client_conn,$new_message,strlen($new_message));
        /*
		$headers = array();
		$lines = preg_split("/\r\n/", $receved_header);
		foreach($lines as $line)
		{
			$line = chop($line);
			if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
			{
				$headers[$matches[1]] = $matches[2];
			}
		}
		print_r($receved_header);
		print_r($headers);
		$secKey = $headers['Sec-WebSocket-Key'];
		$secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
		//hand shaking header
		$upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
		"Upgrade: websocket\r\n" .
		"Connection: Upgrade\r\n" .
		"WebSocket-Origin: $host\r\n" .
		"WebSocket-Location: ws://$host:$port/demo/shout.php\r\n".
		"Sec-WebSocket-Accept:$secAccept\r\n\r\n";
		socket_write($client_conn,$upgrade,strlen($upgrade));//寫數據至socket*/
	}

	//指定關閉$k對應的socket
	function close($k){
	    //斷開相應socket
	    socket_close($this->users[$k]['socket']);
	    //删除相應的user訊息
	    unset($this->users[$k]);
	    //重新定義sockets連接池
	    $this->sockets=array($this->master);
	    foreach($this->users as $v){
	      $this->sockets[]=$v['socket'];
	    }
	}



}

//$webSocket = new WebSocket('127.0.0.1', 8008, 100);
//$webSocket->start();


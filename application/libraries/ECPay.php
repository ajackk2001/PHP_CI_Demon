<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "third_party/ECPay/ECPay.Payment.Integration.php";				//引用套件
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*//
//-*-*-*-*-*-ECPay-*-*-*-*-*-*//
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*//
abstract class ECPay_Url {

    const serviceUrl        = '/Cashier/AioCheckOut/V5';
    const actionUrl         = '/CreditDetail/DoAction';
    const queryUrl          = '/CreditDetail/QueryTrade/V2';
    const infoUrl           = '/ecpay/paymentInfo';
    const clientInfoUrl     = '';
    const returnUrl         = '/ecpay/callback';
    const clientReturnUrl   = '/final';//導到朋客網結果頁
    const clientBack        = '/member/pointOrder';

}
class ECPay extends ECPay_AllInOne {
    public $ordersTable = 'orders_payment';
    public $WebSocial;
    public $http_host;

    public function __construct() {
        $this->CI = & get_instance();
        parent::__construct();
        $this->CI->load->model('Web_Social');
        $this->CI->load->helper('url');
        $this->WebSocial = $this->CI->Web_Social->GetWebSocial([],['title'=>'ECPay'])[0];

        //服務參數
        $this->ServiceURL  = $this->WebSocial->domain.ECPay_Url::serviceUrl;  //服務位置
        $this->HashKey     = $this->WebSocial->hash_key ;                                          //測試用Hashkey，請自行帶入ECPay提供的HashKey
        $this->HashIV      = $this->WebSocial->hash_iv ;                                          //測試用HashIV，請自行帶入ECPay提供的HashIV
        $this->MerchantID  = $this->WebSocial->client_id;                                         //測試用MerchantID，請自行帶入ECPay提供的MerchantID
        $this->EncryptType = '1'; //CheckMacValue加密類型，請固定填入1，使用SHA256加密
        $this->TradeDesc    = 'TaiHot';
        $this->http_host = "https://".$_SERVER['HTTP_HOST'];
        $this->CreditCheckCode='56293842';//商家檢查碼
    }

    public function Send($data=[],$url='/ecpay/callback') {
        try {
            //ECPay_Url::returnUrl=$url;
            //$data['payment_type']='ALL';
            //基本參數(請依系統規劃自行調整)
            $this->Send['ReturnURL']         = $this->http_host.$url;//付款完成通知回傳的網址
            $this->Send['MerchantTradeNo']   = $data['payment_sn'];//訂單編號
            $this->Send['MerchantTradeDate'] = date('Y/m/d H:i:s',strtotime($data['create_time'])); //交易時間
            $this->Send['TotalAmount']       = $data['paid_amount']; //交易金額
            $this->Send['TradeDesc']         = $this->TradeDesc;//交易描述
            $this->Send['ChoosePayment']     = $data['payment_type']; //付款方式:CVS超商代碼
            $this->Send['ClientBackURL']     = $this->http_host.ECPay_Url::clientBack; //ecpay 結果頁 按鈕url
            //$this->Send['OrderResultURL']    = $this->http_host.ECPay_Url::clientReturnUrl;
            //$this->Send['OrderResultURL']    = $this->http_host.$url;
            //$this->Send['CustomField1']      = $data['viewUrl'];                                        //view頁面
            $this->Send['Items'][] = array('Name' => $data['title'], 'Price' => ((int)$data['paid_amount']),'Currency' => "元", 'Quantity' =>1);

            $this->SendPaymentMethod($data);
            //產生訂單(auto submit至ECPay)
            $this->CheckOut();


        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    private function SendPaymentMethod($data) {
        switch ($data['payment_type']) {
            case 'Credit':
                $this->Send['IgnorePayment']     = ECPay_PaymentMethod::GooglePay ;           //不使用付款方式:GooglePay
                $this->Send['NeedExtraPaidInfo'] ='Y';

                //Credit信用卡分期付款延伸參數(可依系統需求選擇是否代入)
                //以下參數不可以跟信用卡定期定額參數一起設定
                $this->SendExtend['CreditInstallment'] = 0 ;    //分期期數，預設0(不分期)，信用卡分期可用參數為:3,6,12,18,24
                $this->SendExtend['Redeem']            = false ;           //是否使用紅利折抵，預設false
                $this->SendExtend['UnionPay']          = false;          //是否為聯營卡，預設false;
                //以下參數不可以跟信用卡分期付款參數一起設定
                // $this->SendExtend['PeriodAmount'] = '' ;    //每次授權金額，預設空字串
                // $this->SendExtend['PeriodType']   = '' ;    //週期種類，預設空字串
                // $this->SendExtend['Frequency']    = '' ;    //執行頻率，預設空字串
                // $this->SendExtend['ExecTimes']    = '' ;    //執行次數，預設空字串
                break;

            case 'CVS':
                //CVS超商代碼延伸參數(可依系統需求選擇是否代入)
                $this->SendExtend['Desc_1']            = '';      //交易描述1 會顯示在超商繳費平台的螢幕上。預設空值
                $this->SendExtend['Desc_2']            = '';      //交易描述2 會顯示在超商繳費平台的螢幕上。預設空值
                $this->SendExtend['Desc_3']            = '';      //交易描述3 會顯示在超商繳費平台的螢幕上。預設空值
                $this->SendExtend['Desc_4']            = '';      //交易描述4 會顯示在超商繳費平台的螢幕上。預設空值
                $this->SendExtend['PaymentInfoURL']    = $this->http_host.ECPay_Url::infoUrl;      //預設空值
               // $this->SendExtend['ClientRedirectURL'] = $this->http_host.ECPay_Url::clientInfoUrl;      //預設空值
                $this->SendExtend['StoreExpireDate']   = (2*24*60);      //2天 * 1天24小時 * 1小時60分鐘
                break;

            case 'BARCODE':
                //BARCODE超商條碼延伸參數(可依系統需求選擇是否代入)
                $this->SendExtend['Desc_1']            = '';      //交易描述1 會顯示在超商繳費平台的螢幕上。預設空值
                $this->SendExtend['Desc_2']            = '';      //交易描述2 會顯示在超商繳費平台的螢幕上。預設空值
                $this->SendExtend['Desc_3']            = '';      //交易描述3 會顯示在超商繳費平台的螢幕上。預設空值
                $this->SendExtend['Desc_4']            = '';      //交易描述4 會顯示在超商繳費平台的螢幕上。預設空值
                $this->SendExtend['PaymentInfoURL']    = $this->http_host.ECPay_Url::infoUrl;      //預設空值
                $this->SendExtend['ClientRedirectURL'] = $this->http_host.ECPay_Url::clientInfoUrl;      //預設空值
                $this->SendExtend['StoreExpireDate']   = 2;      //2天
                break;

            case 'ATM':
                //ATM 延伸參數(可依系統需求選擇是否代入)
                $this->SendExtend['ExpireDate']        = 2 ;      //繳費期限 (預設3天，最長60天，最短1天)
                $this->SendExtend['PaymentInfoURL']    = $this->http_host.ECPay_Url::infoUrl;      //預設空值
                //$this->SendExtend['ClientRedirectURL'] = $this->http_host.ECPay_Url::clientInfoUrl;      //預設空值
                break;

            default:
                $this->Send['ChoosePayment']     = ECPay_PaymentMethod::ALL ;               //付款方式:ALL
                $this->Send['IgnorePayment']     = 'WebATM#BARCODE#GooglePay#AndroidPay';
                $this->SendExtend['PaymentInfoURL']    = $this->http_host.ECPay_Url::infoUrl;      //預設空值
                $this->SendExtend['ClientRedirectURL'] = $this->http_host.ECPay_Url::clientInfoUrl;      //預設空值
                $this->SendExtend['ExpireDate']        = 2 ;      //繳費期限 (預設3天，最長60天，最短1天)
                $this->SendExtend['StoreExpireDate']   = (2*24*60);      //2天 * 1天24小時 * 1小時60分鐘
                break;
        }
    }
    public function CheckMacValue($arParameters=[]){
        $MacValue = $arParameters['CheckMacValue'];
        foreach ($arParameters as $keys => $value) {
            if ($keys != 'CheckMacValue') {
                if ($keys == 'PaymentType') {
                    $value = str_replace('_CVS', '', $value);
                    $value = str_replace('_BARCODE', '', $value);
                    $value = str_replace('_CreditCard', '', $value);
                }
                if ($keys == 'PeriodType') {
                    $value = str_replace('Y', 'Year', $value);
                    $value = str_replace('M', 'Month', $value);
                    $value = str_replace('D', 'Day', $value);
                }
                $arFeedback[$keys] = $value;
            }
        }
        $CheckMacValue = ECPay_CheckMacValue::generate( $arParameters, $this->HashKey , $this->HashIV ,$this->EncryptType);
        return ($CheckMacValue == $MacValue)?true:false;
        //return $CheckMacValue;
    }

    public function PaymentInfo($return=false){
        try{
            // 收到綠界科技的付款結果訊息，並判斷檢查碼是否相符
            $this->EncryptType = '1';
            $feedback = $this->CheckOutFeedback();
            if($return){
                // 以付款結果訊息進行相對應的處理
                $fields = $this->CI->db->get($this->ordersTable)->list_fields();
                $data = [];
                foreach ($fields as $key):
                    $back_key = ($key == 'sub_id')? 'MerchantTradeNo':$key;
                    $data[$key] = (isset($feedback[$back_key]))? $feedback[$back_key]:null ;
                endforeach;
                // if (!$this->CI->db->insert($this->ordersTable,$data))
                $this->CI->db->update($this->ordersTable,['reply_message'=>json_encode($data)],['payment_sn'=>$feedback['MerchantTradeNo']]);
            }
            return $feedback;
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function make_sign($data) {
        ksort($data);
        $sign_arr = [];
        foreach ($data as $key => $value) {
            if (!in_array($key, ['CheckMacValue'])) {
                $sign_arr[] = "$key=$value";
            }
        }
        $sign_str = "HashKey={$this->HashKey}&" . implode('&', $sign_arr) . "&HashIV={$this->HashIV}";
        $sign_str = urlencode($sign_str);
        $sign_str = $this->replace_data($sign_str);
        $sign_str = strtolower($sign_str);

        $sign = hash('sha256', $sign_str);
        $sign = strtoupper($sign);
        return $sign;
    }
    public function replace_data($str) {
        $str = str_replace('%2d', '-', $str);
        $str = str_replace('%5f', '_', $str);
        $str = str_replace('%2e', '.', $str);
        $str = str_replace('%21', '!', $str);
        $str = str_replace('%2a', '*', $str);
        $str = str_replace('%28', '(', $str);
        $str = str_replace('%29', ')', $str);
        return $str;
    }
    public function PaymentReturn($return=false){
        try{
            // 收到綠界科技的付款結果訊息，並判斷檢查碼是否相符
            $this->EncryptType = '1';
            $feedback = $this->CheckOutFeedback();
            if ($return){
                // 以付款結果訊息進行相對應的處理
                // $fields = $this->CI->db->get($this->ordersTable)->list_fields();
                // $data = [];
                // foreach ($fields as $key):
                //     $back_key = ($key == 'sub_id')? 'MerchantTradeNo':$key;
                //     $data[$key] = (isset($feedback[$back_key]))? $feedback[$back_key]:null ;
                // endforeach;
                // if ($feedback['PaymentType'] == 'Credit'){
                //     $this->CI->db->insert($this->ordersTable,$data);
                // }else{
                //     $this->CI->db->update($this->ordersTable,array('RtnCode'=>$feedback['RtnCode'],'RtnMsg'=>$feedback['RtnMsg'],'SimulatePaid'=>$feedback['SimulatePaid']),array('sub_id'=>$feedback['MerchantTradeNo']));
                // }
                $fields = $this->CI->db->get($this->ordersTable)->list_fields();
                $data = [];
                foreach ($fields as $key):
                    $back_key = ($key == 'sub_id')? 'MerchantTradeNo':$key;
                    $data[$key] = (isset($feedback[$back_key]))? $feedback[$back_key]:null ;
                endforeach;
                // if (!$this->CI->db->insert($this->ordersTable,$data))
                $this->CI->db->update($this->ordersTable,['reply_message'=>json_encode($data)],['payment_sn'=>$feedback['MerchantTradeNo']]);
            }
            return $feedback;
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function queryPay($data){
        $this->ServiceURL  = $this->WebSocial->domain.ECPay_Url::queryUrl;  //服務位置
        $this->Trade = array(
            'CreditRefundId' => $data['CreditRefundId'],
            'CreditAmount' => $data['CreditAmount'],
            'CreditCheckCode' => $this->CreditCheckCode
        );
        $feedback = $this->QueryTrade();
        return $feedback;
    }

    public function do_action($data){
        $this->ServiceURL  = $this->WebSocial->domain.ECPay_Url::actionUrl;  //服務位置
		$this->Action = array(
            'MerchantTradeNo' => $data['MerchantTradeNo'],
            'TradeNo' => $data['TradeNo'],
            'Action' => $data['Action'],
            'TotalAmount' => $data['TotalAmount']
        );
        $feedback = $this->DoAction();
        // $this->CI->db->update($this->ordersTable,array('RtnCode'=>$feedback['RtnCode'],'RtnMsg'=>$feedback['RtnMsg']),array('sub_id'=>$data['sub_id'],'TradeNo'=>$data['TradeNo']));
        return $feedback;
    }

    private function InvoiceState() {
        // # 電子發票參數
        // $this->Send['InvoiceMark'] = ECPay_InvoiceState::Yes;
        // $this->SendExtend['RelateNumber'] = "Test".time();
        // $this->SendExtend['CustomerEmail'] = 'test@ecpay.com.tw';
        // $this->SendExtend['CustomerPhone'] = '0911222333';
        // $this->SendExtend['TaxType'] = ECPay_TaxType::Dutiable;
        // $this->SendExtend['CustomerAddr'] = '台北市南港區三重路19-2號5樓D棟';
        // $this->SendExtend['InvoiceItems'] = array();
        // // 將商品加入電子發票商品列表陣列
        // foreach ($this->Send['Items'] as $info)
        // {
        //     array_push($this->SendExtend['InvoiceItems'],array('Name' => $info['Name'],'Count' =>
        //         $info['Quantity'],'Word' => '個','Price' => $info['Price'],'TaxType' => ECPay_TaxType::Dutiable));
        // }
        // $this->SendExtend['InvoiceRemark'] = '測試發票備註';
        // $this->SendExtend['DelayDay'] = '0';
        // $this->SendExtend['InvType'] = ECPay_InvType::General;
    }

}

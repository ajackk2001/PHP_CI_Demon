<?php

class LINE_login
{
    private $channel_id;
    private $channel_secret;
    private $redirect_uri;
    private $authorization_code;
    private $access_token;
    private $user_token;

    public function __construct(array $auth_info)
    {
        $this->channel_id = $auth_info['channel_id'];
        $this->channel_secret = $auth_info['channel_secret'];
    }

    /**
     * Generate an url for user to login LINE then authorizes rights to your app.
     *
     * This function use session to maintain a CRSF token
     *
     * This function does not include all parameters for authorization request
     *
     * LINE docs:
     * https://developers.line.biz/en/docs/line-login/web/integrate-line-login/#making-an-authorization-request
     *
     * @param array $data
     *                    array(
     *                    'scope' => xxx,
     *                    'bot_prompt' => xxx,
     *                    )
     *
     * @return string
     */
    public function authorization_request_string($data, $append_str = '')
    {
        define('AUTHORIZATION_REQUEST_URL', 'https://access.line.me/oauth2/v2.1/authorize');

        $this->redirect_uri = $data['redirect_uri'];

        if (!isset($_SESSION)) {
            session_start();
        }
        //$_SESSION['LINE_CRSF'] = bin2hex(openssl_random_pseudo_bytes(24)).$append_str;
        $_SESSION['LINE_CRSF'] = $append_str;

        $query = http_build_query(array(
            'response_type' => 'code',
            'client_id' => $this->channel_id,
            'redirect_uri' => $this->redirect_uri,
            'state' => $_SESSION['LINE_CRSF'],
            'scope' => $data['scope'],
            'bot_prompt' => $data['bot_prompt'],
        ));

        $authorization_request_string = AUTHORIZATION_REQUEST_URL.'?'.$query;

        return $authorization_request_string;
    }

    /**
     * Process the callback of authorization request.
     *
     * This function should be called only after user login by
     * authorization_request_string() generated url
     *
     * This function use session to maintain a CRSF token and
     * use $_GET to retrive response data
     *
     * LINE docs:
     * https://developers.line.biz/en/docs/line-login/web/integrate-line-login/#receiving-the-authorization-code
     *
     * @throws Exception
     *                   User denies the premission requested or other error
     *
     * @return string authorization code
     */
    public function check_authorization_response()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        // no LINE_CRSF is set in session
        // if (!isset($_SESSION['LINE_CRSF'])) {
        //     throw new Exception('Fail to check CRSF token');
        // }
        // CRSF token not match
        $state = isset($_GET['state']) ? $_GET['state'] : null;
        // equalty check can be rewrite with hash_equals()
        //if($_SESSION['LINE_CRSF'] !== $state)
        //    throw new Exception('CRSF token not match');

        // user denies the premissions requested
        // NOTICE:
        //     LINE server redirect user who does not have
        //     developer role with following error (in GET data)
        //     error=access_denied
        //     error_description=The+authorization+server+denied+the+request.+This+channel+is+now+developing+status.+User+need+to+have+developer+role
        //     To solve this, go to your LINE Login channel then
        //     click the Developing label on the top right to proceed
        //     publish your channel
        if (isset($_GET['error'])) {
            throw new Exception(json_encode(array(
                'error' => $_GET['error'],
                'error_description' => $_GET['error_description'],
            )));
        }

        $this->authorization_code = $_GET['code'];

        return $this->authorization_code;
    }

    /**
     * Request access token for API calls.
     *
     * This function should be called only after check_authorization_response()
     *
     * LINE docs:
     * https://developers.line.biz/en/docs/line-login/web/integrate-line-login/#getting-an-access-token
     *
     *  @param string $redirect_uri
     *      Callback URL in App settings of LINE Login channel
     *      redirect_uri is record by authorization_request_string()
     *      this parameter can be set if using same instance is not possible
     *
     *  @return string access token
     */
    public function request_access_token($redirect_uri = null)
    {
        // curl is not available
        if (!in_array('curl', get_loaded_extensions())) {
            throw new Exception('Extension curl is not loaded.');
        }
        // should be called only after check_authorization_respone()
        if (empty($this->authorization_code)) {
            throw new Exception('No authorization code is held.');
        }
        // caller provide redirect uri
        if (!empty($redirect_uri)) {
            $this->redirect_uri = $redirect_uri;
        }

        // should be called with $redirect_uri or after request_access_token()
        if (empty($this->redirect_uri)) {
            throw  new Exception('No redirect_uri is held.');
        }
        define('ACCESS_TOKEN_REQUEST_URL', 'https://api.line.me/oauth2/v2.1/token');

        // request
        $curl = curl_init(ACCESS_TOKEN_REQUEST_URL);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array(
            'grant_type' => 'authorization_code',
            'code' => $this->authorization_code,
            'redirect_uri' => $redirect_uri,
            'client_id' => $this->channel_id,
            'client_secret' => $this->channel_secret,
        )));
        $result = curl_exec($curl);
        if ($result === false) {
            throw new Exception('curl error: '.$curl_error($curl));
        }
        $curl_response = json_decode($result);
        curl_close($curl);
        $this->access_token = $curl_response->access_token;

        return $this->access_token;
    }

    public function request_access_token2($redirect_uri = null,$code=null){
        $url="https://api.line.me/oauth2/v2.1/token";
        $aa["grant_type"]="authorization_code";//
        $aa["code"]=$code;
        $aa["redirect_uri"]=$redirect_uri;//
        $aa["client_id"]=$this->channel_id;
        $aa["client_secret"]=$this->channel_secret;//
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($aa));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $obj = json_decode($output,true);
        $this->access_token=$obj['access_token'];
        $this->user_token=$obj['id_token'];
        return $this->user_token;
    }
    public function getuserid(){
       $url="https://api.line.me/v2/profile";
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
       curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $this->access_token));
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
       $output = curl_exec($ch);

       $obj2 = json_decode($output,true);
       curl_close($ch);
       return $obj2;
    }

    public function getuserEmail(){
        $url="https://api.line.me/oauth2/v2.1/verify";
        $aa["id_token"]=$this->user_token;//
        $aa["client_id"]=$this->channel_id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($aa));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $obj = json_decode($output,true);
        return $obj;
    }

    /**
     * Get user profile.
     *
     * You can use this to get LINE userId by retrieve 'userId'
     * of returned array
     * Fields of profile is set when authorization_request_string() called
     *
     * access token is record by request_access_token()
     * this parameter can be set if using same instance is not possible
     *
     * LINE docs:
     * https://developers.line.biz/en/docs/social-api/getting-user-profiles/
     *
     * return array See LINE docs
     */
    public function get_user_profile($access_token = null)
    {
        // caller provide access token
        if (!empty($access_token)) {
            $this->access_token = $access_token;
        }

        // should be called with $access_token or after request_access_token()
        if (empty($this->access_token)) {
            throw  new Exception('No access token is held.');
        }
        define('USER_PROFILE_REQUEST_URL', 'https://api.line.me/v2/profile');

        $curl = curl_init(USER_PROFILE_REQUEST_URL);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array('Authorization: Bearer '.$this->access_token));
        $result = curl_exec($curl);
        if ($result === false) {
            throw new Exception('curl error: '.$curl_error($curl));
        }
        if (($response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE)) != '200') {
            throw new Exception('LINE server response with code: '.$response_code);
        }
        $curl_response = json_decode($result, true);
        curl_close($curl);

        return $curl_response;
    }
}

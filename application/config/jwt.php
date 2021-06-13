<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['jwt_key'] = 'ingDLMRuGe9UKHRNjs7cYckS2yul4lc3';
$config['jwt_algorithm'] = 'HS256';

/*Generated token will expire in 1 minute for sample code
* Increase this value as per requirement for production
*/
$config['token_timeout'] = 1;
$config['jwt_url'] = 'http://punkgo_localhost/';
$config['call_back'] = 'http://playwant';

// $config['jwt_url'] = 'https://punkgo.com.tw/';
// $config['call_back'] = 'https://playwanttest.dinj.co';
//$config['call_back'] = 'https://playwant.dinj.co';
$config['shop'] = 'Uhp2OxEBsYZ7XHFd9EsC339DHS/726hTTF3LZFpM+twtIK0NVS4wB/1kkc0';

/* End of file jwt.php */
/* Location: ./application/config/jwt.php */
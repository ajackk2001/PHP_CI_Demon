 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
// front
    /**前台聯絡我們**/
    'contact/contactAjax' =>  array(
        array(
            'field' => 'name',
            'label' => '姓名',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'phone',
            'label' => '連絡電話',
            'rules' => 'trim'
        ),
        array(
            'field' => 'email',
            'label' => '電子信箱',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'content',
            'label' => '需求說明',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'captcha',
            'label' => '驗證號碼',
            'rules' => 'trim|required|alpha_numeric',
            'errors' => [
                'required' => '請輸入{field}'
            ]
        ),
    ),

    'member/login_ajax'   =>  array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'captcha',
            'label' => '驗證碼',
            'rules' => 'trim|required|alpha_numeric'
        ),
    ),
);
include('form_validation_backend.php');


function is_date($input) {
    return (bool) preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/s', $input);
}
function is_money($input) {
    return (bool) preg_match('/^[0-9]+(\.[0-9]{0,2})?$/', $input);
}
function is_money_i($input) {
    return (bool) preg_match('/^[-]?[0-9]+(\.[0-9]{0,2})?$/', $input);
}
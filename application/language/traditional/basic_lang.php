<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2018, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2018, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

include('backend_lang.php');

$lang['error_register']				=	'註冊失敗請連略管理員';
$lang['error_same_user']			=	'已有相同帳號存在';
$lang['error_username']				=	'帳號不存在';
$lang['error_password']				=	'密碼錯誤';
$lang['error_old_password']			=	'原始密碼不正確';
$lang['register']					=	'註冊';
$lang['success']					=	'成功';
$lang['fail']						=	'失敗';
$lang['success_register']			=	$lang['register'].$lang['success'];
$lang['fail_register']				=	$lang['register'].$lang['fail'];
$lang['Update']						=	'更新';
$lang['password_change']			=	'您的密碼已變更';
$lang['login']						=	'登入';
$lang['mamber_login_true']			=	'登入成功';
$lang['relogin']					=	'請重新'.$lang['login'];
$lang['Update_Info_success']		=	'修改成功';
$lang['Update_Info_fail']			=	'修改失敗';
$lang['Exist_Bind_Account']			=	'該帳號已綁定於其他帳號';
$lang['Unknown_error']				=	'未知的錯誤';
$lang['Bind_success']				=	'綁定'.$lang['success'];
$lang['Bind_fail']					=	'綁定'.$lang['fail'];
$lang['Release']					=	'解除';
$lang['Release_Bind_success']		=	$lang['Release'].$lang['Bind_success'];
$lang['Release_Bind_fail']			=	$lang['Release'].$lang['Bind_fail'];
$lang['Insert']						=	'新增';
$lang['Delete']						=	'刪除';
$lang['Delete_success']				=	$lang['Delete'].$lang['success'];
$lang['Delete_fail']				=	$lang['Delete'].$lang['fail'];
$lang['Insert_success']				=	$lang['Insert'].$lang['success'];
$lang['Insert_fail']				=	$lang['Insert'].$lang['fail'];
$lang['Message_captcha_success']	=	'簡訊驗證碼發送'.$lang['success'];
$lang['Message_captcha_fail']		=	'簡訊驗證碼發送'.$lang['fail'];
$lang['Message_captcha_sent']		=	'簡訊驗證碼已發送過請於{second}秒過後再嘗試';
$lang['Email_captcha_sent']			=	'Email驗證碼已發送過請於{second}秒過後再嘗試';
$lang['carousel_one']				=	'輪播圖不得少於一張';
$lang['Shelf_0']					=	'未上架';
$lang['Shelf_1']					=	'上架';
$lang['Review_0']					=	'等待審核';
$lang['Review_1']					=	'完成審核';
$lang['Review_2']					=	'資料有誤';
$lang['mail_success']				=	'發送成功';

$lang['username']	=	'會員帳號';
$lang['password']	=	'密碼';
$lang['name']		=	'姓名';
$lang['Update_password_success']	=	$lang['Update'].$lang['password'].$lang['success'];
$lang['Update_password_fail']		=	$lang['Update'].$lang['password'].$lang['fail'];
$lang['Operate']					=	'操作';
$lang['Operate_Success']			=	$lang['Operate'].$lang['success'];
$lang['Operate_Fail']				=	$lang['Operate'].$lang['fail'];
$lang['noregister']					=	"該帳號未綁定";
$lang['error_captcha']				=	'驗證碼錯誤';
$lang['error_phone_captcha']		=	'手機驗證碼錯誤';
$lang['error_email_captcha']		=	'Email驗證碼錯誤';
$lang['error_phone']				=	'手機號碼錯誤，請輸入發送驗證的號碼。';
$lang['error_email']				=	'Email錯誤，請輸入發送驗證的Email。';


$lang['advisory']					=	'諮詢';
$lang['success_advisory']			=	'新增' . $lang['advisory'] . $lang['success'];
$lang['success_advisory_reply']		=	'回覆' . $lang['advisory'] . $lang['success'];
$lang['success_score_reply']		=	'新增評分' . $lang['success'];
$lang['error_reply']				=	'已有其他專員回覆' . $lang['advisory'];
$lang['error_updata_profession']	=	'更新專員資訊' . $lang['fail'];
$lang['error_add_profession']		=	'指派專員' . $lang['fail'];
$lang['error_not_score']			=	'尚未有服務專員回覆，無法結束諮詢。';
$lang['error_repeat_score']			=	'請勿重覆評分';
$lang['error_updata_score']			=	'新增評分' . $lang['success'];
$lang['error_advisory_memberid']	=	$lang['Operate'] . '錯誤';
$lang['error_not_login']			=	'請先' . $lang['login'];
$lang['error_no_score']				=	'有尚未評分之諮詢，請先前往評分。';
$lang['error_advisory_id']			=	$lang['advisory'] . '主題不存在，請新刷頁面後再次嘗試。';
$lang['error_not_reply']			=	'已評分的' . $lang['advisory'] . '無法繼續提問(回覆)。';
$lang['error_advisory_reply']		=	'回覆' . $lang['advisory'] . $lang['fail'];
$lang['error_insert_advisory']		=	'新增' . $lang['advisory'] . $lang['fail'];
$lang['error_updata_images']		=	'更新圖片' . $lang['fail'];
$lang['error_insert_images']		=	'新增圖片' . $lang['fail'];
$lang['error_updata_advisory']		=	'更新' . $lang['advisory'] . $lang['fail'];
$lang['success_add_profession']		=	'指派專員成功';
$lang['error_add_profession_1']		=	'諮詢主題不存在，請新刷頁面後再次嘗試。';
$lang['error_add_profession_2']		=	'已評分(待評分)的諮詢，無法更改專員。';
$lang['error_add_profession_3']		=	'指派專員失敗，諮詢已有配屬專員請勿重覆指派。';
$lang['error_add_profession_4']		=	'指派專員失敗，請稍候在嘗試。';
$lang['error_invitation_code']		=	'邀請碼錯誤,請重新輸入。';
$lang['error_same_cellphone']		=	'此手機號碼已有帳號使用。';
$lang['error_invitation_same_code']	=	'推薦人不能是本人,請重新輸入邀請碼。';
$lang['error_same_email']			=	'此Email已有帳號使用。';
$lang['error_email_username']		=	'此Email尚未註冊。';
$lang['error_phone_username']		=	'此手機號碼尚未註冊。';
$lang['mail_captcha_success']		=	'發送成功，驗證碼已傳送到您的新信箱。';
$lang['mail_captcha_success2']		=	'發送成功，驗證碼已傳送到您的信箱。';


$lang['title_ch']					=	"中文網站標題";
$lang['title_en']					=	"英文網站標題";
$lang['icon']						=	"網站標誌";
$lang['address']					=	"公司地址";
$lang['servicetime']				=	"服務時間";
$lang['phone']						=	"聯絡電話";
$lang['fax']						=	"傳真電話";
$lang['line_id']					=	"Line 代號";
$lang['email']						=	"電子郵件";
$lang['siteurl']					=	"公司網址";
$lang['keyword']					=	"關鍵字";
$lang['description']				=	"描述";

$lang['client_id']					=	"串接用-商店代號";
$lang['client_secret']				=	"第三方密鑰";
$lang['redirect_url']				=	"回調地址";
$lang['status']						=	"啟用狀態";
$lang['domain']						=	"串接用-接口域名";
$lang['hash_key']					=	"串接用-HashKey";
$lang['hash_iv']					=	"串接用-HashIV";

$lang['Update_Info_seq']			=	'更新排序成功';
$lang['error_seq']					=	'更新排序失敗';

$lang['Update_Permission_success']	=	'更新權限成功';
$lang['Update_Points_success']		=	'更新Punco點數設定成功';
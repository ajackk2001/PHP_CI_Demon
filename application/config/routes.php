<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


include('routes_backend.php');
$route['lock_website'] = 'lock_website';

/**網頁驗證碼**/
$route['Captcha/Captcha']['GET']			= 'Captcha/Captcha/Front';

/*     article     */
$route['privacy'] 			= 	'front/Article/privacy'; 		//隱私權政策
$route['terms'] 			= 	'front/Article/terms'; 			//使用者條款
$route['faq'] 				= 	'front/Article/faq'; 			//常見問題
$route['over18'] 			= 	'front/Article/over18';

/*     video     */
$route['video'] 			= 	'front/Video/item_list'; 		//視頻

/*     album     */
$route['album'] 					= 	'front/Album/item_list'; 		//寫真
$route['album_json']['POST'] 		= 	'front/Album/item_list_json'; 		//寫真
$route['typeAlbum'] 				= 	'front/Album/onetype_list'; 	//單一類別寫真
$route['album/detail'] 				= 	'front/Album/detail'; 			//寫真Detail
$route['album/detail/(:num)'] 		= 	'front/Album/detail/$1'; 			//寫真Detail


/*     special     */
$route['special'] 			= 	'front/Special/item_list'; 		//特別企劃

/*     artist     */
$route['models'] 						= 	'front/Artist/model'; 		//Girls
$route['models_json']['POST'] 			= 	'front/Artist/model_json'; 	//Girls
$route['creator'] 						= 	'front/Artist/creator'; 	//創作者
$route['creator_json']['POST']			= 	'front/Artist/creator_json'; //創作者
$route['artist/detail'] 				= 	'front/Artist/detail'; 		//Detail
$route['artist/detail/(:num)'] 			= 	'front/Artist/detail/$1'; 	//Detail
$route['artist/add_gift'] 				= 	'front/Artist/add_gift'; 	//贈送禮物
$route['item_json'] 					= 	'front/Artist/item_json'; 	//Girls


/*     point     */
$route['pointPlan'] 			= 	'front/Point/pointPlan'; 	//購買方案
$route['payment'] 				= 	'front/Point/payment'; 		//明細付款


/*     member     */
$route['member'] 					= 	'front/member/memberInfo'; 		//會員中心
$route['member/login'] 				= 	'front/member/login'; 			//登入
$route['member/login_ajax']			=	'front/member/login_ajax';
$route['member/psdChange'] 			= 	'front/member/passwordChange'; 	//密碼變更
$route['member/infoEdit'] 			= 	'front/member/infoEdit'; 		//編輯個人資料
$route['member/edit']['POST'] 		= 	'front/member/edit'; 			//編輯個人資料
$route['member/bank_edit']['POST'] 	= 	'front/member/bank_edit'; 		//編輯銀行帳戶設定
$route['member/banner_edit']['POST']= 	'front/member/banner_edit'; 	//檢視個人資料
$route['member/detail']				= 	'front/member/detail'; 			//編輯個人資料
$route['member/purchasedItem'] 		= 	'front/member/purchasedItem'; 	//購買紀錄-顯示已經購買的商品
$route['member/purchasedItem_json'] = 	'front/member/purchasedItem_json'; 	//購買紀錄-顯示已經購買的商品
$route['member/collection'] 		= 	'front/member/collection'; 		//最愛收藏
$route['member/collection_json'] 	= 	'front/member/collection_json'; 		//最愛收藏
$route['member/pointRecord'] 		= 	'front/member/pointRecord'; 	//點數使用紀錄-消費紀錄
$route['member/chat'] 				= 	'front/member/chat'; 			//聊天管理
$route['member/chat_json'] 			= 	'front/member/chat_json'; 		//聊天管理
$route['member/productShelf'] 		= 	'front/member/productShelf'; 	//商品上架
$route['member/productShelf_json'] 	= 	'front/member/productShelf_json'; //商品上架json
$route['member/product/add'] 		= 	'front/member/productAdd'; 		//新增商品
$route['member/product/edit/(:num)'] = 	'front/member/productEdit/$1'; 	//編輯商品
$route['member/product/check'] 		= 	'front/member/productCheck'; 	//審核商品
$route['member/product/check/(:num)']= 	'front/member/productCheck/$1'; //審核商品
$route['member/pointOrder'] 		= 	'front/member/pointOrder'; 		//訂單紀錄-點數購買紀錄
$route['member/exchangeCash'] 		= 	'front/member/exchangeCash'; 	//點數兌換-點數換現金
$route['member/exchangeCash_json'] 	= 	'front/member/exchangeCash_json'; 	//點數兌換-點數換現金
$route['member/incomeRecord'] 	    = 	'front/member/incomeRecord'; 	// 收入紀錄
$route['member/incomeRecord_json'] 	= 	'front/member/incomeRecord_json'; 	// 收入紀錄
$route['member/logout']				=	'front/member/logout';
$route['member/info']['GET']		=   'front/member/info';
$route['member/orders_json']['POST']=   'front/member/orders_json';
$route['member/point_json']['POST']	=   'front/member/point_json';


$route['member/chat_list'] 		   		= 	'front/member/chat_list';
$route['member/chat_list_json']['POST']	=   'front/member/chat_list_json';
$route['member/chat_point_edit']['POST']= 	'front/member/chat_point_edit'; 		//編輯銀行帳戶設定

//$route['member/test']			=   'front/member/test';

// 通知
$route['notification'] 				= 	'front/notification/index'; 			//通知
$route['notification/show']['POST'] = 	'front/notification/show'; 			//通知

//新增提領紀錄
$route['member/cash_add']['POST']	=   'front/member/cash_add';
//上傳影片
$route['item/upload_video']['POST']	=   'front/item/upload_video';
//上傳圖片
$route['item/fileuploader_image_upload'] = 'front/item/fileuploader_image_upload';
$route['item/fileuploader_image_upload2'] = 'front/item/fileuploader_image_upload2';

//上傳作品
$route['item/add']['POST'] 					= 'front/item/add';
$route['item/edit/(:num)']['POST'] 			= 'front/item/edit/$1';

//購買作品
$route['payment_item'] 					= 	'front/item/payment'; 		//明細付款
$route['point_order']['POST'] 			= 	'front/item/point_order'; 	//點數購買

//新增收藏
$route['item_favorite_add/(:num)']['POST'] 		= 'front/Album/item_favorite_add/$1';
$route['item_favorite_delete/(:num)']['POST'] 	= 'front/Album/item_favorite_delete/$1';

/**金流串接**/
//綠界
$route['createOrder']['POST']		=	'Api/Ec_pay/payment';
$route['createItemOrder']['POST']	=	'Api/Ec_pay/item_payment';
$route['ecpay/callback']			= 	'Api/Ec_pay/ecpay_callback';
$route['ecpay/callback2']			= 	'Api/Ec_pay/ecpay_callback2';
$route['final']						= 	'front/Point/pay_final';

//萬事達
$route['createOrder2']['POST']		=	'Api/PayMent/payment';
$route['payment/callback']			= 	'Api/PayMent/callback';
$route['createItemOrder2']['POST']	=	'Api/PayMent/item_payment';
$route['payment/callback2']			= 	'Api/PayMent/callback2';


/*     contact     */
$route['contact'] 					= 	'front/Contact/form'; 		//聯絡我們
$route['contact/form']['POST']		= 	'front/contact/contactAjax';

/**驗證碼-Email**/
$route['Mail/loginCaptcha']['POST']	= 'Api/Mail/loginCaptcha';

/**兌現現金驗證碼-Email**/
$route['Mail/cashCaptcha']['POST']	= 'Api/Mail/cashCaptcha';

//websocket server
$route['server'] 				= 'front/Chat/server';
//新增聊天聯絡人清單
$route['chat/chat_add/(:num)'] 	= 'front/Chat/chat_add/$1';
$route['chat/chat_list_add'] 	= 'front/Chat/chat_list_add';



$route['chat_get'] 			= 	'front/Chat/chat_get';
$route['chat_get_json'] 	= 	'front/Chat/chat_get_json';


$route['chat/upload_image']['POST']	=   'front/Chat/upload_image';


$route['admin/chat/(:num)'] 		= 	'front/Chat2/chat/$1'; 			//聊天管理
$route['admin/chat_json/(:num)'] 	= 	'front/Chat2/chat_json/$1'; 	//聊天管理
$route['chat_get_json/(:num)'] 		= 	'front/Chat2/chat_get_json/$1';



$route['give_away_points_add'] 			= 	'front/Point/give_away_points_add';




/*     block       */
$route['.*'] = '404';




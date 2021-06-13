<?php

$route['Captcha/Captcha']['GET']			= 'Captcha/Captcha/Front';
$route['Backend/Captcha/Captcha']['GET']	= 'Captcha/Captcha/Backend';

/*      API      */
$route['Facebook/Login']['GET']                         = 'Api/Facebook/Login';
$route['Facebook/ApiLogin']['GET']                      = 'Api/Facebook/Apilogin';
$route['Facebook/CallBack']['GET']                      = 'Api/Facebook/CallBack';
$route['Facebook/Unbind']['POST']                       = 'Api/Facebook/Unbind';
$route['Google/Login']['GET']                           = 'Api/Google/Login';
$route['Google/ApiLogin']['GET']                        = 'Api/Google/Apilogin';
$route['Google/CallBack']['GET']                        = 'Api/Google/CallBack';
$route['Google/Unbind']['POST']                         = 'Api/Google/Unbind';
$route['Mail/Forgot']['POST']                         	= 'Api/Mail/Forgot';
$route['Message/Check']['GET']                         	= 'Api/Message/Check';
$route['Message/Recive']['POST']                        = 'Api/Message/Recive';
$route['test']['GET']                        			= 'Api/Message/test2';

/**Line**/
$route['Line/Login']['GET']								= 'Api/Line/login';
$route['Line/CallBack']['GET']							= 'Api/Line/CallBack';


/*      Backend      */
$backend_path = 'Backend/';
$route['Backend/Captcha/Captcha']['GET']					= 'Captcha/Captcha/Backend';
$route['Backend/Login']['GET']								= $backend_path.'auth/login';
$route['Backend/Login']['POST']								= $backend_path.'auth/login_ajax';
$route['Backend/Dashboard']['GET']							= $backend_path.'dashboard/index';
$route['Backend/Manager']['GET']							= $backend_path.'manager/index';
$route['Backend/Admin/AdminList']['GET']					= $backend_path.'Admin/AdminList';
$route['Backend/Admin/AdminAdd']['POST']					= $backend_path.'Admin/AdminAdd';
$route['Backend/Admin/UpdateAdminStatus/(:num)']['POST']	= $backend_path.'Admin/UpdateAdminStatus/$1';
$route['Backend/Admin/UpdateAdmin/(:num)']['POST']			= $backend_path.'Admin/UpdateAdmin/$1';
$route['Backend/Admin/DeleteAdmin/(:num)']['POST']			= $backend_path.'Admin/DeleteAdmin/$1';
$route['Backend/Admin/Permission/(:num)']['GET']			= $backend_path.'Admin/Permission/$1';
$route['Backend/Admin/LoginRecord']['GET']					= $backend_path.'Admin/LoginRecord';
$route['Backend/Admin/LoginRecord']['POST']					= $backend_path.'Admin/LoginRecordList';
$route['Backend/Admin/ChangePW']['POST']					= $backend_path.'Admin/ChangePW';

$route['Backend/Operation/Record']['GET']					= $backend_path.'Operation/Record';
$route['Backend/Operation/Record']['POST']					= $backend_path.'Operation/RecordList';
$route['Backend/Operation/DeleteRecord']['POST']			= $backend_path.'Operation/DeleteRecord';
$route['Backend/Operation/DeleteRecord/(:num)']['POST']		= $backend_path.'Operation/DeleteRecord/$1';

$route['Backend/Export/ExportAjax']['POST']						= $backend_path.'Export/ExportAjax';


$route['Backend/Contact/ItemList']['GET']						= $backend_path.'Contact/ItemList';
$route['Backend/Contact/Detail/(:num)']['GET']					= $backend_path.'Contact/Detail/$1';
$route['Backend/Contact/ContactList']['GET']					= $backend_path.'Contact/ContactList';
$route['Backend/Contact/ContactUpdate/(:num)']['PUT']			= $backend_path.'Contact/ContactUpdate/$1';
$route['Backend/Contact/ContactDelete/(:num)']['DELETE']		= $backend_path.'Contact/ContactDelete/$1';

$route['Backend/Contact/AskType']['GET']						= $backend_path.'Contact/AskType';
$route['Backend/Contact/AskType']['POST']						= $backend_path.'Contact/AskTypeList';
$route['Backend/Contact/AskTypeinfo/(:num)']['POST']			= $backend_path.'Contact/AskTypeInfo/$1';
$route['Backend/Contact/AddAskType']['POST']					= $backend_path.'Contact/AskTypeAdd';
$route['Backend/Contact/EditAskType/(:num)']['POST']			= $backend_path.'Contact/AskTypeEdit/$1';

$route['Backend/Contact/DeleteAskType/(:num)']['POST']			= $backend_path.'Contact/AskTypeDelete/$1';
$route['Backend/Contact/Contact']['GET']						= $backend_path.'Contact/Contact';
$route['Backend/Contact/Contact/(:num)']['GET']					= $backend_path.'Contact/ContactDetail/$1';
$route['Backend/Contact/Contact']['POST']						= $backend_path.'Contact/ContactList';
$route['Backend/Contact/EditContact/(:num)']['POST']			= $backend_path.'Contact/ContactEdit/$1';
$route['Backend/Contact/DeleteContact/(:num)']['POST']			= $backend_path.'Contact/ContactDelete/$1';
$route['Backend/Contact/Reply/(:num)']['POST']					= $backend_path.'Contact/Reply/$1';
$route['Backend/Contact/Receive']['GET']						= $backend_path.'Contact/Receive';
$route['Backend/Contact/Receive']['POST']						= $backend_path.'Contact/ReceiveList';
$route['Backend/Contact/ReceiveAdd']['POST']				    = $backend_path.'Contact/ReceiveAdd';
$route['Backend/Contact/ReceiveEdit/(:num)']['POST']			= $backend_path.'Contact/ReceiveEdit/$1';
$route['Backend/Contact/ReceiveDelete/(:num)']['POST']			= $backend_path.'Contact/ReceiveDelete/$1';

$route['Backend/Management/Setting']['GET']						= $backend_path.'Management/Setting';
$route['Backend/Management/EditSetting/(:num)']['POST']			= $backend_path.'Management/SettingEdit/$1';
$route['Backend/Management/Mail']['GET']						= $backend_path.'Management/Mail';
$route['Backend/Management/MailEdit/(:num)']['POST']			= $backend_path.'Management/MailEdit/$1';
$route['Backend/Management/MailSend']['GET']					= 'Api/Mail/Send';
$route['Backend/Management/MailSend']['POST']					= 'Api/Mail/Send';
$route['Backend/Management/Social']['GET']						= $backend_path.'Management/Social';
$route['Backend/Management/SocialEdit/(:num)']['POST']			= $backend_path.'Management/SocialEdit/$1';

$route['Backend/Message/Setting']['GET']						= $backend_path.'Message/Setting';
$route['Backend/Message/Setting']['POST']						= $backend_path.'Message/SettingList';
$route['Backend/Message/AddSetting']['POST']					= $backend_path.'Message/SettingAdd';
$route['Backend/Message/EditSetting/(:num)']['GET']				= $backend_path.'Message/SettingInfo/$1';
$route['Backend/Message/EditSetting/(:num)']['POST']			= $backend_path.'Message/SettingEdit/$1';
$route['Backend/Message/DeleteSetting/(:num)']['POST']			= $backend_path.'Message/SettingDelete/$1';
$route['Backend/Message/Send']['GET']							= $backend_path.'Message/Send';
$route['Backend/Message/Send']['POST']							= 'Api/Message/SendMessage';
$route['Backend/Message/Record']['GET']							= $backend_path.'Message/Record';
$route['Backend/Message/Record']['POST']						= $backend_path.'Message/RecordList';

$route['Backend/Mail/Setting']['GET']							= $backend_path.'Mail/Setting';
$route['Backend/Mail/Setting']['PUT']							= $backend_path.'Mail/SettingAjax';
$route['Backend/Mail/Setting']['POST']							= $backend_path.'Mail/SettingList';
$route['Backend/Mail/AddSetting']['POST']						= $backend_path.'Mail/SettingAdd';
$route['Backend/Mail/EditSetting/(:num)']['GET']				= $backend_path.'Mail/SettingInfo/$1';
$route['Backend/Mail/EditSetting/(:num)']['POST']				= $backend_path.'Mail/SettingEdit/$1';
$route['Backend/Mail/DeleteSetting/(:num)']['POST']				= $backend_path.'Mail/SettingDelete/$1';
$route['Backend/Mail/Send']['GET']								= $backend_path.'Mail/Send';
$route['Backend/Mail/Send']['POST']								= 'Api/Mail/SendMail';
$route['Backend/Mail/Record']['GET']							= $backend_path.'Mail/Record';
$route['Backend/Mail/Record']['POST']							= $backend_path.'Mail/RecordList';

$route['Backend/Broadcast/Setting']['GET']						= $backend_path.'Broadcast/Setting';
$route['Backend/Broadcast/Setting']['POST']						= $backend_path.'Broadcast/SettingList';
$route['Backend/Broadcast/SettingAdd']['POST']					= $backend_path.'Broadcast/SettingAdd';
$route['Backend/Broadcast/SettingEdit/(:num)']['GET']			= $backend_path.'Broadcast/SettingInfo/$1';
$route['Backend/Broadcast/SettingEdit/(:num)']['POST']			= $backend_path.'Broadcast/SettingEdit/$1';
$route['Backend/Broadcast/SettingDelete/(:num)']['POST']		= $backend_path.'Broadcast/SettingDelete/$1';
$route['Backend/Broadcast/Record']['GET']						= $backend_path.'Broadcast/Record';
$route['Backend/Broadcast/Record']['POST']						= $backend_path.'Broadcast/RecordList';

//形象圖片routes
$route['Backend/Banner/Item']['GET']					= $backend_path.'Banner/Item';
$route['Backend/Banner/ItemList']['POST']				= $backend_path.'Banner/ItemList';
$route['Backend/Banner/AddBanner']['POST']				= $backend_path.'Banner/AddBanner';
$route['Backend/Banner/BannerInfo/(:num)']['GET']		= $backend_path.'Banner/BannerInfo/$1';
$route['Backend/Banner/EditBanner/(:num)']['POST']		= $backend_path.'Banner/BannerEdit/$1';
$route['Backend/Banner/DeleteBanner/(:num)']['POST']	= $backend_path.'Banner/BannerDelete/$1';
$route['Backend/Banner/UpdateBannerStatus/(:num)']['POST'] = $backend_path.'Banner/UpdateBannerStatus/$1';
$route['Backend/Banner/UpdateSeq']['POST'] 				= $backend_path.'Banner/UpdateSeq';
$route['Backend/Banner/GetSeq']['POST'] 				= $backend_path.'Banner/GetSeq';

//活動商情routes
// $route['Backend/Activity']['GET']						= $backend_path.'Activity/Item';
// $route['Backend/Activity']['POST']						= $backend_path.'Activity/ItemList';
// $route['Backend/Activity/Add']['POST']					= $backend_path.'Activity/Add';
// $route['Backend/Activity/Info/(:num)']['GET']			= $backend_path.'Activity/Info/$1';
// $route['Backend/Activity/UpdateStatus/(:num)']['POST']	= $backend_path.'Activity/UpdateStatus/$1';
// $route['Backend/Activity/Edit/(:num)']['POST']			= $backend_path.'Activity/Edit/$1';
// $route['Backend/Activity/Delete/(:num)']['POST']		= $backend_path.'Activity/Delete/$1';
// $route['Backend/Activity/GetSeq']['POST'] 				= $backend_path.'Activity/GetSeq';

//相關連結routes
$route['Backend/Link']['GET']							= $backend_path.'Link/Item';
$route['Backend/Link']['POST']							= $backend_path.'Link/ItemList';
$route['Backend/Link/Add']['POST']						= $backend_path.'Link/Add';
$route['Backend/Link/Info/(:num)']['GET']				= $backend_path.'Link/Info/$1';
$route['Backend/Link/UpdateStatus/(:num)']['POST']		= $backend_path.'Link/UpdateStatus/$1';
$route['Backend/Link/Edit/(:num)']['POST']				= $backend_path.'Link/Edit/$1';
$route['Backend/Link/Delete/(:num)']['POST']			= $backend_path.'Link/Delete/$1';
$route['Backend/Link/UpdateSeq']['POST'] 				= $backend_path.'Link/UpdateSeq';
$route['Backend/Link/GetSeq']['POST'] 					= $backend_path.'Link/GetSeq';

//關於我們總管routes
$route['Backend/About/AboutList']['GET']				= $backend_path.'About/Item';
$route['Backend/About/AboutList']['POST']				= $backend_path.'About/ItemList';
$route['Backend/About/Add']['POST']						= $backend_path.'About/Add';
$route['Backend/About/Info/(:num)']['GET']				= $backend_path.'About/Info/$1';
$route['Backend/About/UpdateStatus/(:num)']['POST']		= $backend_path.'About/UpdateStatus/$1';
$route['Backend/About/Edit/(:num)']['POST']				= $backend_path.'About/Edit/$1';
$route['Backend/About/Delete/(:num)']['POST']			= $backend_path.'About/Delete/$1';
$route['Backend/About/UpdateSeq']['POST'] 				= $backend_path.'About/UpdateSeq';
$route['Backend/About/GetSeq']['POST'] 					= $backend_path.'About/GetSeq';
$route['Backend/About/Form']['GET'] 					= $backend_path.'About/Form';
$route['Backend/About/EditForm']['POST'] 				= $backend_path.'About/EditForm/';

//網站文宣總管
$route['Backend/About/WebInfo']['GET']					= $backend_path.'About/WebInfo';
$route['Backend/About/WebInfoEdit']['POST']				= $backend_path.'About/WebInfoEdit';


//常見問題總管
$route['Backend/Faq']['GET']							= $backend_path.'Faq/Index';
$route['Backend/Faq']['POST']							= $backend_path.'Faq/Show';
$route['Backend/Faq/Add']['POST']						= $backend_path.'Faq/Add';
$route['Backend/Faq/GetSeq']['POST']					= $backend_path.'Faq/GetSeq';
$route['Backend/Faq/Info/(:num)']['GET']				= $backend_path.'Faq/Info/$1';
$route['Backend/Faq/Edit/(:num)']['POST']				= $backend_path.'Faq/Edit/$1';
$route['Backend/Faq/Delete/(:num)']['POST']				= $backend_path.'Faq/Delete/$1';
$route['Backend/Faq/UpdateStatus/(:num)']['POST']   	= $backend_path.'Faq/UpdateStatus/$1';
$route['Backend/Faq/UpdateSeq']['POST'] 				= $backend_path.'Faq/UpdateSeq';

//行程分類總管routesroutes
$route['Backend/News/NewsType']['GET']					= $backend_path.'News/NewsType';
$route['Backend/News/NewsType']['POST']					= $backend_path.'News/NewsTypeList';
$route['Backend/News/AddNewsType']['POST']				= $backend_path.'News/NewsTypeAdd';
$route['Backend/News/DeleteNewsType/(:num)']['POST']	= $backend_path.'News/NewsTypeDelete/$1';
$route['Backend/News/GetSeq']['POST']						= $backend_path.'News/GetSeq';
$route['Backend/News/EditNewsType/(:num)']['POST']		= $backend_path.'News/NewsTypeEdit/$1';
$route['Backend/News/UpdateNewsTypeSeq']['POST'] 		= $backend_path.'News/UpdateNewsTypeSeq';
$route['Ckfinder/Uploads']['POST'] 							= 'Api/Ckfinder/Uploads';

//最新消息routes
$route['Backend/News']['GET']							= $backend_path.'News/Index';
$route['Backend/News']['POST']							= $backend_path.'News/ItemList';
$route['Backend/News/AddNews']['POST']					= $backend_path.'News/AddNews';
$route['Backend/News/NewsInfo/(:num)']['GET']			= $backend_path.'News/NewsInfo/$1';
$route['Backend/News/UpdateNewsStatus/(:num)']['POST']	= $backend_path.'News/UpdateNewsStatus/$1';
$route['Backend/News/EditNews/(:num)']['POST']			= $backend_path.'News/NewsEdit/$1';
$route['Backend/News/DeleteNews/(:num)']['POST']		= $backend_path.'News/NewsDelete/$1';


//會員管理
$route['Backend/Member/ItemList']['GET']				= $backend_path.'Member/ItemList';
$route['Backend/Member/Behaviour/(:num)']				= $backend_path.'Member/Behaviour/$1';
$route['Backend/Member/PersonalRank/(:num)']			= $backend_path.'Member/PersonalRank/$1';
$route['Backend/Member/TeamRank/(:num)']				= $backend_path.'Member/TeamRank/$1';
$route['Backend/Member/ItemList']['POST']				= $backend_path.'Member/Show';


$route['Backend/Member/Delete/(:num)']['POST']			= $backend_path.'Member/Delete/$1';
$route['Backend/Member/Edit2/(:num)']['POST']			= $backend_path.'Member/UpdateMemberStatus/$1';



$route['Backend/Member/MemberAdd']['POST']					= $backend_path.'Member/Add';
$route['Backend/Member/Info/(:num)']					= $backend_path.'Member/Info/$1';
$route['Backend/Member/MemberEdit/(:num)']['POST']		= $backend_path.'Member/Edit/$1';



//設備分類總管routesroutes
$route['Backend/Equipment/EquipmentType']['GET']					= $backend_path.'Equipment/EquipmentType';
$route['Backend/Equipment/EquipmentType']['POST']					= $backend_path.'Equipment/EquipmentTypeList';
$route['Backend/Equipment/AddEquipmentType']['POST']				= $backend_path.'Equipment/EquipmentTypeAdd';
$route['Backend/Equipment/DeleteEquipmentType/(:num)']['POST']	    = $backend_path.'Equipment/EquipmentTypeDelete/$1';
$route['Backend/Equipment/GetSeq']['POST']							= $backend_path.'Equipment/GetSeq';
$route['Backend/Equipment/EditEquipmentType/(:num)']['POST']		= $backend_path.'Equipment/EquipmentTypeEdit/$1';
$route['Backend/Equipment/UpdateEquipmentTypeSeq']['POST'] 			= $backend_path.'Equipment/UpdateEquipmentTypeSeq';
$route['Ckfinder/Uploads']['POST'] 									= 'Api/Ckfinder/Uploads';

//廠商設備routes
$route['Backend/Equipment']['GET']									= $backend_path.'Equipment/Index';
$route['Backend/Equipment']['POST']									= $backend_path.'Equipment/ItemList';
$route['Backend/Equipment/AddEquipment']['POST']					= $backend_path.'Equipment/AddEquipment';
$route['Backend/Equipment/EquipmentInfo/(:num)']['GET']				= $backend_path.'Equipment/EquipmentInfo/$1';
$route['Backend/Equipment/UpdateEquipmentStatus/(:num)']['POST']	= $backend_path.'Equipment/UpdateEquipmentStatus/$1';
$route['Backend/Equipment/EditEquipment/(:num)']['POST']			= $backend_path.'Equipment/EquipmentEdit/$1';
$route['Backend/Equipment/DeleteEquipment/(:num)']['POST']			= $backend_path.'Equipment/EquipmentDelete/$1';

//老師專長總管routes
$route['Backend/Teacher/TeacherType']['GET']						= $backend_path.'Teacher/TeacherType';
$route['Backend/Teacher/TeacherType']['POST']						= $backend_path.'Teacher/TeacherTypeList';
$route['Backend/Teacher/AddTeacherType']['POST']					= $backend_path.'Teacher/TeacherTypeAdd';
$route['Backend/Teacher/DeleteTeacherType/(:num)']['POST']	    	= $backend_path.'Teacher/TeacherTypeDelete/$1';
$route['Backend/Teacher/GetSeq']['POST']							= $backend_path.'Teacher/GetSeq';
$route['Backend/Teacher/EditTeacherType/(:num)']['POST']			= $backend_path.'Teacher/TeacherTypeEdit/$1';
$route['Backend/Teacher/UpdateTeacherTypeSeq']['POST'] 				= $backend_path.'Teacher/UpdateTeacherTypeSeq';

$route['Backend/Teacher/TeacherTypeInfo/(:num)']['GET']				= $backend_path.'Teacher/TeacherTypeInfo/$1';


//老師管理
$route['Backend/Teacher/ItemList']['GET']							= $backend_path.'Teacher/Index';
$route['Backend/Teacher']['POST']									= $backend_path.'Teacher/ItemList';

$route['Backend/Teacher/UpdateTeacherStatus/(:num)']['POST']	= $backend_path.'Teacher/UpdateTeacherStatus/$1';

$route['Backend/Teacher/DeleteTeacher/(:num)']['POST']			= $backend_path.'Teacher/TeacherDelete/$1';

$route['Backend/Teacher/TeacherAdd']['GET']						= $backend_path.'Teacher/Create';
$route['Backend/Teacher/TeacherAdd']['POST']					= $backend_path.'Teacher/Add';

$route['Backend/Teacher/EditTeacher/(:num)']['GET']				= $backend_path.'Teacher/Update/$1';
$route['Backend/Teacher/EditTeacher']['GET']					= $backend_path.'Teacher/Update';
$route['Backend/Teacher/EditTeacher/(:num)']['POST']			= $backend_path.'Teacher/EditTeacher/$1';
$route['Backend/Teacher/EditTeacherAction/(:num)']['POST']		= $backend_path.'Teacher/EditTeacherAction/$1';
$route['Backend/Teacher/EditTeacherCost/(:num)']['POST']		= $backend_path.'Teacher/EditTeacherCost/$1';

$route['Backend/Teacher/Acts/(:num)']['GET']					= $backend_path.'Teacher/Acts/$1';



$route['Backend/Teacher/fileuploader_image_upload'] 			= $backend_path.'Teacher/fileuploader_image_upload';


//老師班表routes
$route['Backend/Schedule/ItemList']['GET']							= $backend_path.'Schedule/Index';
$route['Backend/Schedule']['POST']									= $backend_path.'Schedule/ItemList';

$route['Backend/Schedule/AddSchedule']['POST']						= $backend_path.'Schedule/AddSchedule';

$route['Backend/Schedule/Calendar/(:any)']['GET']					= $backend_path.'Schedule/Calendar/$1';
$route['Backend/Schedule/Calendar_info/(:num)']['GET']				= $backend_path.'Schedule/Calendar_info/$1';

$route['Backend/Schedule/Info/(:num)']['GET']						= $backend_path.'Schedule/Info/$1';

$route['Backend/Schedule/EditSchedule/(:num)']['POST']				= $backend_path.'Schedule/ScheduleEdit/$1';
$route['Backend/Schedule/DeleteSchedule/(:num)']['POST']			= $backend_path.'Schedule/ScheduleDelete/$1';
$route['Backend/Schedule/NO_list']['POST']							= $backend_path.'Schedule/NO_list';


//活動類型總管routes
$route['Backend/ActivityType/ItemList']['GET']							= $backend_path.'ActivityType/Index';
$route['Backend/ActivityType/ActivityType']['POST']						= $backend_path.'ActivityType/ActivityTypeList';
$route['Backend/ActivityType/AddActivityType']['POST']					= $backend_path.'ActivityType/ActivityTypeAdd';
$route['Backend/ActivityType/DeleteActivityType/(:num)']['POST']	    = $backend_path.'ActivityType/ActivityTypeDelete/$1';
$route['Backend/ActivityType/GetSeq']['POST']							= $backend_path.'ActivityType/GetSeq';
$route['Backend/ActivityType/EditActivityType/(:num)']['POST']			= $backend_path.'ActivityType/ActivityTypeEdit/$1';
$route['Backend/ActivityType/UpdateActivityTypeSeq']['POST'] 			= $backend_path.'ActivityType/UpdateActivityTypeSeq';

$route['Backend/ActivityType/ActivityTypeInfo/(:num)']['GET']			= $backend_path.'ActivityType/ActivityTypeInfo/$1';


//場地設定總管routes
$route['Backend/Site/Item']['GET']						= $backend_path.'Site/Item';
$route['Backend/Site/ItemList']['POST']					= $backend_path.'Site/ItemList';
$route['Backend/Site/Add']['POST']						= $backend_path.'Site/Add';
$route['Backend/Site/Info/(:num)']['GET']				= $backend_path.'Site/Info/$1';
$route['Backend/Site/Edit/(:num)']['POST']				= $backend_path.'Site/Edit/$1';
$route['Backend/Site/Delete/(:num)']['POST']			= $backend_path.'Site/Delete/$1';
$route['Backend/Site/UpdateStatus/(:num)']['POST']		= $backend_path.'Site/UpdateStatus/$1';

//加購商品routes
$route['Backend/Purchase/Item']['GET']							= $backend_path.'Purchase/Item';
$route['Backend/Purchase/ItemList']['POST']						= $backend_path.'Purchase/ItemList';
$route['Backend/Purchase/Add']['POST']							= $backend_path.'Purchase/Add';
$route['Backend/Purchase/Info/(:num)']['GET']					= $backend_path.'Purchase/Info/$1';
$route['Backend/Purchase/Edit/(:num)']['POST']					= $backend_path.'Purchase/Edit/$1';
$route['Backend/Purchase/Delete/(:num)']['POST']				= $backend_path.'Purchase/Delete/$1';
$route['Backend/Purchase/UpdateStatus/(:num)']['POST'] 			= $backend_path.'Purchase/UpdateStatus/$1';
$route['Backend/Purchase/UpdateSeq']['POST'] 					= $backend_path.'Purchase/UpdateSeq';
$route['Backend/Purchase/GetSeq']['POST'] 						= $backend_path.'Purchase/GetSeq';



//附加選項總管routes
$route['Backend/Option/Item']['GET']								= $backend_path.'Option/Index';
$route['Backend/Option/Item']['POST']								= $backend_path.'Option/ItemList';

$route['Backend/Option/Add']['POST']								= $backend_path.'Option/Add';
$route['Backend/Option/Delete/(:num)']['POST']	    				= $backend_path.'Option/Delete/$1';
$route['Backend/Option/GetSeq']['POST']								= $backend_path.'Option/GetSeq';
$route['Backend/Option/Edit/(:num)']['POST']						= $backend_path.'Option/Edit/$1';
$route['Backend/Option/UpdateSeq']['POST'] 							= $backend_path.'Option/UpdateSeq';

$route['Backend/Option/Info/(:num)']['GET']							= $backend_path.'Option/Info/$1';



//好活動管理
$route['Backend/Activity/Item']['GET']							= $backend_path.'Activity/Index';
$route['Backend/Activity/Item']['POST']							= $backend_path.'Activity/ItemList';

$route['Backend/Activity/Add']['GET']							= $backend_path.'Activity/Create';
$route['Backend/Activity/Add']['POST']							= $backend_path.'Activity/Add';

$route['Backend/Activity/Edit/(:num)']['GET']					= $backend_path.'Activity/Update/$1';
$route['Backend/Activity/Edit']['GET']							= $backend_path.'Activity/Update';
$route['Backend/Activity/Edit/(:num)']['POST']					= $backend_path.'Activity/Edit/$1';

$route['Backend/Activity/check_teacher']['POST']				= $backend_path.'Activity/check_teacher';
$route['Backend/Activity/check_teacher/(:num)']['POST']				= $backend_path.'Activity/check_teacher/$1';
$route['Backend/Activity/UpdateStatus/(:num)']['POST']			= $backend_path.'Activity/UpdateStatus/$1';
$route['Backend/Activity/Delete/(:num)']['POST']				= $backend_path.'Activity/Delete/$1';
$route['Backend/Activity/fileuploader_image_upload'] 			= $backend_path.'Activity/fileuploader_image_upload';

$route['Backend/Activity/Detail/(:num)']['GET']					= $backend_path.'Activity/Detail/$1';

$route['Backend/Activity/OrderShow/(:num)']['POST']				= $backend_path.'Activity/OrderShow/$1';
$route['Backend/Activity/ReturnShow/(:num)']['GET']				= $backend_path.'Activity/ReturnShow/$1';

$route['Backend/Activity/DeleteActivitySession/(:num)']['POST']	= $backend_path.'Activity/DeleteActivitySession/$1';

//熱門輪播routes
$route['Backend/Popular/Item']['GET']					= $backend_path.'Popular/Item';
$route['Backend/Popular/ItemList']['POST']				= $backend_path.'Popular/ItemList';
$route['Backend/Popular/Add']['POST']					= $backend_path.'Popular/Add';
$route['Backend/Popular/Info/(:num)']['GET']			= $backend_path.'Popular/Info/$1';
$route['Backend/Popular/Edit/(:num)']['POST']			= $backend_path.'Popular/Edit/$1';
$route['Backend/Popular/Delete/(:num)']['POST']			= $backend_path.'Popular/Delete/$1';
$route['Backend/Popular/UpdateStatus/(:num)']['POST'] 	= $backend_path.'Popular/UpdateStatus/$1';
$route['Backend/Popular/UpdateSeq']['POST'] 			= $backend_path.'Popular/UpdateSeq';
$route['Backend/Popular/GetSeq']['POST'] 				= $backend_path.'Popular/GetSeq';


//訂單系統
$route['Backend/Orders/Record']['GET']					= $backend_path.'Orders/Index';
$route['Backend/Orders/Record']['POST']					= $backend_path.'Orders/Show';
$route['Backend/Orders/PlayOrders']['GET']				= $backend_path.'Orders/Index2';
$route['Backend/Orders/Record2']['POST']				= $backend_path.'Orders/Show2';
$route['Backend/Orders/Detail/(:num)']['GET']			= $backend_path.'Orders/Detail/$1';
$route['Backend/Orders/PlayDetail/(:num)']['GET']		= $backend_path.'Orders/Detail/$1';
//退款操作
$route['Backend/Orders/ActivityReturn/(:num)']['GET']	= $backend_path.'Orders/Return/$1';
$route['Backend/Orders/PlayReturn/(:num)']['GET']		= $backend_path.'Orders/Return/$1';
$route['Backend/Orders/AddReturn']['POST']				= $backend_path.'Orders/AddReturn';
$route['Backend/Orders/orderDelete/(:num)']['GET']		= $backend_path.'Orders/orderDelete/$1';

//退款管理
$route['Backend/Orders/OrdersReturn']['GET']			= $backend_path.'Orders/OrdersReturn';
$route['Backend/Orders/OrdersReturn']['POST']			= $backend_path.'Orders/orderReturnAjax';
$route['Backend/ReturnEdit/(:num)']['POST']				= $backend_path.'Orders/ReturnEdit/$1';
$route['Backend/Orders/ReturnDetail/(:num)']['GET']		= $backend_path.'Orders/ReturnDetail/$1';

$route['Backend/Mail/mailTemplate']						= $backend_path.'Mail/mailTemplate';

//老師日行程表
$route['Backend/Teacher/dayItemList']['GET']			= $backend_path.'Teacher/dayItemList';
$route['Backend/Teacher/dayItemList']['POST']			= $backend_path.'Teacher/dayItemList_ajax';



//活動類型總管routes
$route['Backend/FaqType/ItemList']['GET']						= $backend_path.'FaqType/Index';
$route['Backend/FaqType/FaqType']['POST']						= $backend_path.'FaqType/FaqTypeList';
$route['Backend/FaqType/AddFaqType']['POST']					= $backend_path.'FaqType/FaqTypeAdd';
$route['Backend/FaqType/DeleteFaqType/(:num)']['POST']	    	= $backend_path.'FaqType/FaqTypeDelete/$1';
$route['Backend/FaqType/GetSeq']['POST']						= $backend_path.'FaqType/GetSeq';
$route['Backend/FaqType/EditFaqType/(:num)']['POST']			= $backend_path.'FaqType/FaqTypeEdit/$1';
$route['Backend/FaqType/UpdateFaqTypeSeq']['POST'] 				= $backend_path.'FaqType/UpdateFaqTypeSeq';

$route['Backend/FaqType/FaqTypeInfo/(:num)']['GET']				= $backend_path.'FaqType/FaqTypeInfo/$1';
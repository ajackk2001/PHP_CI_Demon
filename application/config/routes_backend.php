<?php

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
$route['Backend/Captcha/Captcha']['GET']					    = 'Captcha/Captcha/Backend';
$route['Backend/Logout']								        = $backend_path.'Auth/logout';
$route['Backend/Login']['GET']								    = $backend_path.'Auth/login';
$route['Backend/Login']['POST']								    = $backend_path.'Auth/login_ajax';
$route['Backend/Dashboard']['GET']							    = $backend_path.'Dashboard/index';

$route['Backend/Admin']                                         = $backend_path.'Admin/Index';
$route['Backend/Admin/AdminList']['GET']					    = $backend_path.'Admin/AdminList';
$route['Backend/Admin/AdminAdd']['POST']					    = $backend_path.'Admin/AdminAdd';
$route['Backend/Admin/AdminUpdateStatus/(:num)']['POST']	    = $backend_path.'Admin/AdminUpdateStatus/$1';
$route['Backend/Admin/AdminUpdate/(:num)']['POST']			    = $backend_path.'Admin/AdminUpdate/$1';
$route['Backend/Admin/AdminDelete/(:num)']['POST']			    = $backend_path.'Admin/AdminDelete/$1';
$route['Backend/Admin/Permission/(:num)']['GET']			    = $backend_path.'Admin/Permission/$1';
$route['Backend/Admin/LoginRecord']['GET']					    = $backend_path.'Admin/LoginRecord';
$route['Backend/Admin/LoginRecord']['POST']					    = $backend_path.'Admin/LoginRecordList';
$route['Backend/Admin/ChangePW']['POST']					    = $backend_path.'Admin/ChangePW';

$route['Backend/Operation/Record']['GET']					    = $backend_path.'Operation/Record';
$route['Backend/Operation/Record']['POST']					    = $backend_path.'Operation/RecordList';
$route['Backend/Operation/RecordDelete']['POST']			    = $backend_path.'Operation/RecordDelete';
// $route['Backend/Operation/RecordDelete/(:num)']['POST']		    = $backend_path.'Operation/RecordDelete/$1';

$route['Backend/Export/ExportAjax']['POST']						= $backend_path.'Export/ExportAjax';

$route['Backend/Contact/UpdateStatus/(:any)/(:num)']            = $backend_path.'Contact/UpdateStatus/$1/$2';
$route['Backend/Contact/UpdateSeq']['POST']			            = $backend_path.'Contact/UpdateSeq';
$route['Backend/ContactType']['GET']						    = $backend_path.'Contact/TypeIndex';
$route['Backend/ContactType']['POST']						    = $backend_path.'Contact/TypeList';
$route['Backend/ContactType/Add']['POST']					    = $backend_path.'Contact/TypeAdd';
$route['Backend/ContactType/Edit/(:num)']['GET']			    = $backend_path.'Contact/TypeInfo/$1';
$route['Backend/ContactType/Edit/(:num)']['POST']			    = $backend_path.'Contact/TypeEdit/$1';
$route['Backend/ContactType/Delete/(:num)']['POST']			    = $backend_path.'Contact/TypeDelete/$1';
$route['Backend/Contact']['GET']						        = $backend_path.'Contact/Index';
$route['Backend/Contact']['POST']						        = $backend_path.'Contact/List';
$route['Backend/Contact/Edit/(:num)']['GET']				    = $backend_path.'Contact/Detail/$1';
$route['Backend/Contact/Edit/(:num)']['POST'] 			        = $backend_path.'Contact/Edit/$1';
$route['Backend/Contact/Delete/(:num)']['POST']			        = $backend_path.'Contact/Delete/$1';
$route['Backend/Contact/Reply/(:num)']['POST']					= $backend_path.'Contact/Reply/$1';

$route['Backend/Management/Setting']['GET']						= $backend_path.'Management/Setting';
$route['Backend/Management/EditSetting/(:num)']['POST']			= $backend_path.'Management/SettingEdit/$1';
$route['Backend/Management/Mail']['GET']						= $backend_path.'Management/Mail';
$route['Backend/Management/MailEdit/(:num)']['POST']			= $backend_path.'Management/MailEdit/$1';
$route['Backend/Management/MailSend']['GET']					= 'Api/Mail/Send';
$route['Backend/Management/MailSend']['POST']					= 'Api/Mail/Send';
$route['Backend/Management/TestSend']['POST']					= 'Api/Mail/TestSend';
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
$route['Backend/Mail/Receive']['GET']						    = $backend_path.'Mail/Receive';
$route['Backend/Mail/Receive']['POST']						    = $backend_path.'Mail/ReceiveList';
$route['Backend/Mail/ReceiveAdd']['POST']				        = $backend_path.'Mail/ReceiveAdd';
$route['Backend/Mail/ReceiveEdit/(:num)']['GET']			    = $backend_path.'Mail/ReceiveInfo/$1';
$route['Backend/Mail/ReceiveEdit/(:num)']['POST']			    = $backend_path.'Mail/ReceiveEdit/$1';
$route['Backend/Mail/ReceiveDelete/(:num)']['POST']			    = $backend_path.'Mail/ReceiveDelete/$1';

$route['Backend/Broadcast/Setting']['GET']						= $backend_path.'Broadcast/Setting';
$route['Backend/Broadcast/Setting']['POST']						= $backend_path.'Broadcast/SettingList';
$route['Backend/Broadcast/SettingAdd']['POST']					= $backend_path.'Broadcast/SettingAdd';
$route['Backend/Broadcast/SettingEdit/(:num)']['GET']			= $backend_path.'Broadcast/SettingInfo/$1';
$route['Backend/Broadcast/SettingEdit/(:num)']['POST']			= $backend_path.'Broadcast/SettingEdit/$1';
$route['Backend/Broadcast/SettingDelete/(:num)']['POST']		= $backend_path.'Broadcast/SettingDelete/$1';
$route['Backend/Broadcast/Record']['GET']						= $backend_path.'Broadcast/Record';
$route['Backend/Broadcast/Record']['POST']						= $backend_path.'Broadcast/RecordList';

$route['Backend/Articles/UpdateSeq']['POST']			        = $backend_path.'Articles/UpdateSeq';
$route['Backend/WebInfo']['GET']							    = $backend_path.'Articles/WebInfo';
$route['Backend/WebInfo/Edit/(:num)']['POST']				    = $backend_path.'Articles/Edit/$1';
$route['Backend/About']['GET']								    = $backend_path.'Articles/About';
$route['Backend/About']['POST']								    = $backend_path.'Articles/Show';
$route['Backend/About/Add']['POST']							    = $backend_path.'Articles/Add';
$route['Backend/About/Info/(:num)']				                = $backend_path.'Articles/Info/$1';
$route['Backend/About/Edit/(:num)']['POST']					    = $backend_path.'Articles/Edit/$1';
$route['Backend/About/Delete/(:num)']['POST']				    = $backend_path.'Articles/Delete/$1';

$route['Backend/RelationsWebsite']['GET']				            = $backend_path.'Relations_website/Index';
$route['Backend/RelationsWebsite/List']['GET']						= $backend_path.'Relations_website/Show';
$route['Backend/RelationsWebsite/Add']['POST']						= $backend_path.'Relations_website/Add';
$route['Backend/RelationsWebsite/Info/(:num)']['GET']				= $backend_path.'Relations_website/Info/$1';
$route['Backend/RelationsWebsite/Edit/(:num)']['POST']				= $backend_path.'Relations_website/Edit/$1';
$route['Backend/RelationsWebsite/Delete/(:num)']['POST']			= $backend_path.'Relations_website/Delete/$1';
$route['Backend/RelationsWebsite/UpdateSeq']['POST']			    = $backend_path.'Relations_website/UpdateSeq';
$route['Backend/RelationsWebsite/UpdateStatus/(:num)']['POST']	    = $backend_path.'Relations_website/UpdateStatus/$1';
$route['Backend/RelationsWebsite/LastSeq']                          = $backend_path.'Relations_website/lastSeq';

$route['Backend/RelationsFile']['GET']				                = $backend_path.'Relations_file/Index';
$route['Backend/RelationsFile/List']['GET']						    = $backend_path.'Relations_file/Show';
$route['Backend/RelationsFile/Add']['POST']						    = $backend_path.'Relations_file/Add';
$route['Backend/RelationsFile/Info/(:num)']['GET']				    = $backend_path.'Relations_file/Info/$1';
$route['Backend/RelationsFile/Edit/(:num)']['POST']				    = $backend_path.'Relations_file/Edit/$1';
$route['Backend/RelationsFile/Delete/(:num)']['POST']			    = $backend_path.'Relations_file/Delete/$1';
$route['Backend/RelationsFile/UpdateSeq']['POST']			        = $backend_path.'Relations_file/UpdateSeq';
$route['Backend/RelationsFile/UpdateStatus/(:num)']['POST']	        = $backend_path.'Relations_file/UpdateStatus/$1';

$route['Backend/News']['GET']				                = $backend_path.'News/Index';
$route['Backend/News/List']['GET']						    = $backend_path.'News/Show';
$route['Backend/News/Add']['POST']						    = $backend_path.'News/Add';
$route['Backend/News/Info/(:num)']['GET']				    = $backend_path.'News/Info/$1';
$route['Backend/News/Edit/(:num)']['POST']				    = $backend_path.'News/Edit/$1';
$route['Backend/News/Delete/(:num)']['POST']			    = $backend_path.'News/Delete/$1';
$route['Backend/NewsType']['GET']				            = $backend_path.'News/TypeIndex';
$route['Backend/NewsType/List']['GET']						= $backend_path.'News/TypeShow';
$route['Backend/NewsType/Add']['POST']						= $backend_path.'News/TypeAdd';
$route['Backend/NewsType/Info/(:num)']['GET']		        = $backend_path.'News/TypeInfo/$1';
$route['Backend/NewsType/Edit/(:num)']['POST']			    = $backend_path.'News/TypeEdit/$1';
$route['Backend/NewsType/Delete/(:num)']['POST']		    = $backend_path.'News/TypeDelete/$1';
$route['Backend/News/LastSeq/(:any)']                       = $backend_path.'News/lastSeq/$1';
$route['Backend/News/UpdateSeq/(:any)']                     = $backend_path.'News/UpdateSeq/$1';
$route['Backend/News/UpdateStatus/(:any)/(:num)']           = $backend_path.'News/UpdateStatus/$1/$2';

$route['Backend/Albums']['GET']				                = $backend_path.'Albums/Index';
$route['Backend/Albums/List']['GET']						= $backend_path.'Albums/Show';
$route['Backend/Albums/Add']['POST']						= $backend_path.'Albums/Add';
$route['Backend/Albums/Info/(:num)']['GET']				    = $backend_path.'Albums/Info/$1';
$route['Backend/Albums/Edit/(:num)']['POST']				= $backend_path.'Albums/Edit/$1';
$route['Backend/Albums/Delete/(:num)']['POST']			    = $backend_path.'Albums/Delete/$1';
$route['Backend/AlbumsType']['GET']				            = $backend_path.'Albums/TypeIndex';
$route['Backend/AlbumsType/List']['GET']					= $backend_path.'Albums/TypeShow';
$route['Backend/AlbumsType/Add']['POST']					= $backend_path.'Albums/TypeAdd';
$route['Backend/AlbumsType/Info/(:num)']['GET']		        = $backend_path.'Albums/TypeInfo/$1';
$route['Backend/AlbumsType/Edit/(:num)']['POST']			= $backend_path.'Albums/TypeEdit/$1';
$route['Backend/AlbumsType/Delete/(:num)']['POST']		    = $backend_path.'Albums/TypeDelete/$1';
$route['Backend/Albums/LastSeq/(:any)']                     = $backend_path.'Albums/lastSeq/$1';
$route['Backend/Albums/UpdateSeq/(:any)']                   = $backend_path.'Albums/UpdateSeq/$1';
$route['Backend/Albums/UpdateStatus/(:any)/(:num)']         = $backend_path.'Albums/UpdateStatus/$1/$2';
$route['Backend/Albums/Photos']                             = $backend_path.'Albums/photoAbout';
$route['Backend/Albums/Photos/(:num)']                      = $backend_path.'Albums/photoAbout/$1';
$route['Backend/Albums/fileuploader_image_upload/(:num)']   = $backend_path.'Albums/fileuploader_image_upload/$1';
$route['Backend/Albums/save_images/(:num)']                 = $backend_path.'Albums/save_images/$1';

$route['Backend/Banner']['GET']				                = $backend_path.'Banner/Index';
$route['Backend/Banner/List']['GET']						= $backend_path.'Banner/Show';
$route['Backend/Banner/Add']['POST']						= $backend_path.'Banner/Add';
$route['Backend/Banner/Info/(:num)']['GET']				    = $backend_path.'Banner/Info/$1';
$route['Backend/Banner/Edit/(:num)']['POST']				= $backend_path.'Banner/Edit/$1';
$route['Backend/Banner/Delete/(:num)']['POST']			    = $backend_path.'Banner/Delete/$1';
$route['Backend/Banner/UpdateSeq']['POST']			        = $backend_path.'Banner/UpdateSeq';
$route['Backend/Banner/UpdateStatus/(:num)']['POST']	    = $backend_path.'Banner/UpdateStatus/$1';
$route['Backend/Banner/LastSeq']                            = $backend_path.'Banner/lastSeq';


$route['Backend/Zipcode']['GET'] = $backend_path.'Zipcode/index';
$route['Backend/Zipcode/Import']['POST'] = $backend_path.'Zipcode/import';

$route['Backend/Template'] = $backend_path.'Template/index';
$route['Backend/Template/fileuploader_image_upload'] = $backend_path.'Template/fileuploader_image_upload';
$route['Backend/Template/save_images'] = $backend_path.'Template/save_images';
$route['Backend/Template/ImportZipcode'] = $backend_path.'Template/import_zipcode';

//國籍總管
$route['Backend/Country/Item']['GET']				        = $backend_path.'Country/Index';
$route['Backend/Country/Item']['POST']						= $backend_path.'Country/Show';
$route['Backend/Country/Add']['POST']						= $backend_path.'Country/Add';
$route['Backend/Country/Info/(:num)']['GET']				= $backend_path.'Country/Info/$1';
$route['Backend/Country/Edit/(:num)']['POST']				= $backend_path.'Country/Edit/$1';
$route['Backend/Country/Delete/(:num)']['POST']			    = $backend_path.'Country/Delete/$1';
$route['Backend/Country/UpdateSeq']['POST']			        = $backend_path.'Country/UpdateSeq';
$route['Backend/Country/UpdateStatus/(:num)']['POST']	    = $backend_path.'Country/UpdateStatus/$1';
$route['Backend/Country/LastSeq']                           = $backend_path.'Country/lastSeq';


//會員資訊總管
$route['Backend/Member/Itemlist']['GET']					= $backend_path.'Member/Index';
$route['Backend/Member/Itemlist']['POST']					= $backend_path.'Member/Show';
$route['Backend/Member/Info/(:num)']['GET']					= $backend_path.'Member/Info/$1';
$route['Backend/Member/Edit/(:num)']['POST']				= $backend_path.'Member/Edit/$1';
$route['Backend/Member/Edit2/(:num)']['POST']				= $backend_path.'Member/Edit/$1';
$route['Backend/Member/Chat_point']['GET']					= $backend_path.'Member/Chat_point';
$route['Backend/Member/Chat_point']['POST']					= $backend_path.'Member/Chat_point_show';

//提示訊息總管
$route['Backend/About/Form']['GET'] 					= $backend_path.'Articles/Form';
$route['Backend/About/EditForm']['POST'] 				= $backend_path.'Articles/EditForm';

//首頁廣告總管
$route['Backend/Add_img/Item']['GET']				        = $backend_path.'Advertising_img/Index';
$route['Backend/Add_img/List']['GET']						= $backend_path.'Advertising_img/Show';
$route['Backend/Add_img/Add']['POST']						= $backend_path.'Advertising_img/Add';
$route['Backend/Add_img/Info/(:num)']['GET']					= $backend_path.'Advertising_img/Info/$1';
$route['Backend/Add_img/Edit/(:num)']['POST']				= $backend_path.'Advertising_img/Edit/$1';
$route['Backend/Add_img/Delete/(:num)']['POST']			    = $backend_path.'Advertising_img/Delete/$1';
$route['Backend/Add_img/UpdateSeq']['POST']			        = $backend_path.'Advertising_img/UpdateSeq';
$route['Backend/Add_img/UpdateStatus/(:num)']['POST']	    = $backend_path.'Advertising_img/UpdateStatus/$1';
$route['Backend/Add_img/LastSeq']                            = $backend_path.'Advertising_img/lastSeq';



//主題圖片總管
$route['Backend/Banner_img/Item']['GET']				        = $backend_path.'Banner_img/Index';
$route['Backend/Banner_img/List']['GET']						= $backend_path.'Banner_img/Show';
$route['Backend/Banner_img/Add']['POST']						= $backend_path.'Banner_img/Add';
$route['Backend/Banner_img/Info/(:num)']['GET']				    = $backend_path.'Banner_img/Info/$1';
$route['Backend/Banner_img/Edit/(:num)']['POST']				= $backend_path.'Banner_img/Edit/$1';
$route['Backend/Banner_img/Delete/(:num)']['POST']			    = $backend_path.'Banner_img/Delete/$1';
$route['Backend/Banner_img/UpdateSeq']['POST']			        = $backend_path.'Banner_img/UpdateSeq';
$route['Backend/Banner_img/UpdateStatus/(:num)']['POST']	    = $backend_path.'Banner_img/UpdateStatus/$1';
$route['Backend/Banner_img/LastSeq']                            = $backend_path.'Banner_img/lastSeq';


//常見問題總管
$route['Backend/Faq/Item']['GET']				        = $backend_path.'Faq/Index';
$route['Backend/Faq/List']['GET']						= $backend_path.'Faq/Show';
$route['Backend/Faq/Add']['POST']						= $backend_path.'Faq/Add';
$route['Backend/Faq/Info/(:num)']['GET']				    = $backend_path.'Faq/Info/$1';
$route['Backend/Faq/Edit/(:num)']['POST']				= $backend_path.'Faq/Edit/$1';
$route['Backend/Faq/Delete/(:num)']['POST']			    = $backend_path.'Faq/Delete/$1';
$route['Backend/Faq/UpdateSeq']['POST']			        = $backend_path.'Faq/UpdateSeq';
$route['Backend/Faq/UpdateStatus/(:num)']['POST']	    = $backend_path.'Faq/UpdateStatus/$1';
$route['Backend/Faq/LastSeq']                            = $backend_path.'Faq/lastSeq';



//分類總管
$route['Backend/ItemType/Item']['GET']						= $backend_path.'Item_type/index';
$route['Backend/ItemType/Item']['POST']						= $backend_path.'Item_type/show';
$route['Backend/ItemType/Add']['POST']						= $backend_path.'Item_type/add';
$route['Backend/ItemType/Edit/(:num)']['GET']				= $backend_path.'Item_type/info/$1';
$route['Backend/ItemType/Edit/(:num)']['POST']				= $backend_path.'Item_type/edit/$1';
$route['Backend/ItemType/Delete/(:num)']['POST']			= $backend_path.'Item_type/delete/$1';
$route['Backend/ItemType/Edit2/(:num)']['POST']				= $backend_path.'Item_type/updateStatus/$1';
$route['Backend/ItemType/updateSeq']['POST']				= $backend_path.'Item_type/updateSeq';
$route['Backend/ItemType/LastSeq']                          = $backend_path.'Item_type/lastSeq';

//次分類總管
$route['Backend/ItemCategory/Item']['GET']					= $backend_path.'Item_category/index';
$route['Backend/ItemCategory/Item']['POST']					= $backend_path.'Item_category/show';
$route['Backend/ItemCategory/Add']['POST']					= $backend_path.'Item_category/add';
$route['Backend/ItemCategory/Edit/(:num)']['GET']			= $backend_path.'Item_category/info/$1';
$route['Backend/ItemCategory/Edit/(:num)']['POST']			= $backend_path.'Item_category/edit/$1';
$route['Backend/ItemCategory/Delete/(:num)']['POST']		= $backend_path.'Item_category/delete/$1';
$route['Backend/ItemCategory/Edit2/(:num)']['POST']			= $backend_path.'Item_category/updateStatus/$1';
$route['Backend/ItemCategory/updateSeq']['POST']			= $backend_path.'Item_category/updateSeq';


//尺度分類總管
$route['Backend/ItemScale/Item']['GET']						= $backend_path.'Item_scale/index';
$route['Backend/ItemScale/Item']['POST']					= $backend_path.'Item_scale/show';
$route['Backend/ItemScale/Add']['POST']						= $backend_path.'Item_scale/add';
$route['Backend/ItemScale/Edit/(:num)']['GET']				= $backend_path.'Item_scale/info/$1';
$route['Backend/ItemScale/Edit/(:num)']['POST']				= $backend_path.'Item_scale/edit/$1';
$route['Backend/ItemScale/Delete/(:num)']['POST']			= $backend_path.'Item_scale/delete/$1';
$route['Backend/ItemScale/Edit2/(:num)']['POST']			= $backend_path.'Item_scale/updateStatus/$1';
$route['Backend/ItemScale/updateSeq']['POST']				= $backend_path.'Item_scale/updateSeq';
$route['Backend/ItemScale/LastSeq']                         = $backend_path.'Item_scale/lastSeq';

//金額點數換算
$route['Backend/SetPoint']['GET']                      		= $backend_path.'SetPoint/index';
$route['Backend/SetPoint']['POST']                      	= $backend_path.'SetPoint/Edit';

//點數方案總管
$route['Backend/PointsProgram/Item']['GET']                 = $backend_path.'PointsProgram/index';
$route['Backend/PointsProgram/Show']['POST']                = $backend_path.'PointsProgram/show';
$route['Backend/PointsProgram/Add']['POST']                 = $backend_path.'PointsProgram/add';
$route['Backend/PointsProgram/Info/(:num)']['GET']			= $backend_path.'PointsProgram/info/$1';
$route['Backend/PointsProgram/Edit/(:num)']['POST']			= $backend_path.'PointsProgram/edit/$1';
$route['Backend/PointsProgram/Delete/(:num)']['POST']		= $backend_path.'PointsProgram/delete/$1';
$route['Backend/PointsProgram/UpdateStatus/(:num)']['POST']	= $backend_path.'PointsProgram/updateStatus/$1';

//訂單紀錄
$route['Backend/Orders/Item']['GET']  = $backend_path.'Orders/Index';
$route['Backend/Orders/Item']['POST'] = $backend_path.'Orders/Show';


// 作品審核總管
$route['Backend/Item/ItemReview']['GET'] 		 = $backend_path.'Item/itemReview';
$route['Backend/Item/ItemReview']['POST'] 		 = $backend_path.'Item/reviewRecordList';
$route['Backend/Item/ItemReview/(:num)']['POST'] = $backend_path.'Item/itemReviewEdit/$1';


// 作品總管
$route['Backend/Item/Item']['GET'] 		 		  = $backend_path.'Item/index';
$route['Backend/Item/Item']['POST'] 		 	  = $backend_path.'Item/show';
$route['Backend/Item/UpdateStatus/(:num)']['POST']= $backend_path.'Item/UpdateStatus/$1';

$route['Backend/Item/Item/(:num)']['GET'] 		 	  = $backend_path.'Item/index2/$1';
$route['Backend/Item/Item/(:num)']['POST'] 		 	  = $backend_path.'Item/show2/$1';

//主題連結總管
$route['Backend/Theme/Item']['GET']				        = $backend_path.'Theme/Index';
$route['Backend/Theme/List']['GET']						= $backend_path.'Theme/Show';
$route['Backend/Theme/Add']['POST']						= $backend_path.'Theme/Add';
$route['Backend/Theme/Info/(:num)']['GET']				= $backend_path.'Theme/Info/$1';
$route['Backend/Theme/Edit/(:num)']['POST']				= $backend_path.'Theme/Edit/$1';
$route['Backend/Theme/Delete/(:num)']['POST']			= $backend_path.'Theme/Delete/$1';
$route['Backend/Theme/UpdateSeq']['POST']			    = $backend_path.'Theme/UpdateSeq';
$route['Backend/Theme/UpdateStatus/(:num)']['POST']	    = $backend_path.'Theme/UpdateStatus/$1';
$route['Backend/Theme/LastSeq']                         = $backend_path.'Theme/lastSeq';


//熱門分類總管
$route['Backend/Popular/Item']['GET']				        = $backend_path.'Popular/Index';
$route['Backend/Popular/List']['GET']						= $backend_path.'Popular/Show';
$route['Backend/Popular/Add']['POST']						= $backend_path.'Popular/Add';
$route['Backend/Popular/Info/(:num)']['GET']				= $backend_path.'Popular/Info/$1';
$route['Backend/Popular/Edit/(:num)']['POST']				= $backend_path.'Popular/Edit/$1';
$route['Backend/Popular/Delete/(:num)']['POST']			    = $backend_path.'Popular/Delete/$1';
$route['Backend/Popular/UpdateSeq']['POST']			        = $backend_path.'Popular/UpdateSeq';
$route['Backend/Popular/UpdateStatus/(:num)']['POST']	    = $backend_path.'Popular/UpdateStatus/$1';
$route['Backend/Popular/LastSeq']                           = $backend_path.'Popular/lastSeq';


//點數總管
$route['Backend/Points']['GET']								= $backend_path.'Points/index';
$route['Backend/Points']['POST']							= $backend_path.'Points/show';
$route['Backend/Points/Add']['GET']							= $backend_path.'Points/create';
$route['Backend/Points/Add']['POST']						= $backend_path.'Points/add';


//提領待處理總管
$route['Backend/Cash/redeemcash_exchange_pending']['GET'] 	= $backend_path.'Cash/redeemcash_exchange_pending';
$route['Backend/Cash/redeemcash_exchange_pending']['POST']	= $backend_path.'Cash/redeemcash_exchange_pending_show';
$route['Backend/Cash/redeemcash_exchange_pending_edit/(:num)']['POST']= $backend_path.'Cash/redeemcash_exchange_pending_edit/$1';
$route['Backend/Cash/redeemcash_exchange_pending_edit2']['POST']= $backend_path.'Cash/redeemcash_exchange_pending_edit2';
$route['Backend/Cash/bank_info/(:num)']['GET']				= $backend_path.'Cash/bank_info/$1';


//收入提領紀錄
$route['Backend/Cash/Item']['GET'] 		 		= $backend_path.'Cash/index';
$route['Backend/Cash/Item']['POST'] 		 	= $backend_path.'Cash/show';
$route['Backend/Cash/income/(:num)']['GET'] 	= $backend_path.'Cash/income/$1';
$route['Backend/Cash/income/(:num)']['POST'] 	= $backend_path.'Cash/income_show/$1';



//禮物總管
$route['Backend/Gift/Item']['GET']				        = $backend_path.'Gift/Index';
$route['Backend/Gift/List']['GET']						= $backend_path.'Gift/Show';
$route['Backend/Gift/Add']['POST']						= $backend_path.'Gift/Add';
$route['Backend/Gift/Info/(:num)']['GET']				= $backend_path.'Gift/Info/$1';
$route['Backend/Gift/Edit/(:num)']['POST']				= $backend_path.'Gift/Edit/$1';
$route['Backend/Gift/Delete/(:num)']['POST']			= $backend_path.'Gift/Delete/$1';
$route['Backend/Gift/UpdateSeq']['POST']			    = $backend_path.'Gift/UpdateSeq';
$route['Backend/Gift/UpdateStatus/(:num)']['POST']	    = $backend_path.'Gift/UpdateStatus/$1';
$route['Backend/Gift/LastSeq']                          = $backend_path.'Gift/lastSeq';

$route['Backend/Gift/Record']['GET']				    = $backend_path.'Gift/Record';
$route['Backend/Gift/Record']['POST']					= $backend_path.'Gift/Record_Show';


//金流設定
$route['Backend/Orders/Pay']['GET']						= $backend_path.'Orders/Pay';
$route['Backend/Orders/PayUpdate/(:num)']['POST']		= $backend_path.'Orders/PayUpdate/$1';


//每日簽到
$route['Backend/Give_away_point/Item']['GET']				        = $backend_path.'Give_away_point/Index';
$route['Backend/Give_away_point/List']['GET']						= $backend_path.'Give_away_point/Show';
$route['Backend/Give_away_point/Add']['POST']						= $backend_path.'Give_away_point/Add';
$route['Backend/Give_away_point/Info/(:num)']['GET']				= $backend_path.'Give_away_point/Info/$1';
$route['Backend/Give_away_point/Edit/(:num)']['POST']				= $backend_path.'Give_away_point/Edit/$1';
$route['Backend/Give_away_point/Delete/(:num)']['POST']				= $backend_path.'Give_away_point/Delete/$1';
$route['Backend/Give_away_point/UpdateSeq']['POST']			    	= $backend_path.'Give_away_point/UpdateSeq';
$route['Backend/Give_away_point/UpdateStatus']['POST']	    		= $backend_path.'Give_away_point/UpdateStatus';
$route['Backend/Give_away_point/LastSeq']                           = $backend_path.'Give_away_point/lastSeq';


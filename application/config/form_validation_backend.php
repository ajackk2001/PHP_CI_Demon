<?php

$config_backend = array(
    //首頁宣傳
    //提示宣傳

    'Articles/EditForm' =>  array(
        array(
            'field' => 'content',
            'label' => '內容',
            'rules' => 'trim'
        ),
    ),
    'Theme/Edit' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'type_id',
            'label' => '主分類',
            'rules' => 'trim|required'
        ),
    ),
    'Theme/Add' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'type_id',
            'label' => '主分類',
            'rules' => 'trim|required'
        ),
    ),
    // backend
    'Operation/RecordDelete' =>  array(
        array(
            'field' => 'id[]',
            'label' => '檔案',
            'rules' => 'trim'
        ),
    ),

    'Admin/ChangePW' =>  array(
        array(
            'field' => 'oldpw',
            'label' => '舊密碼',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'newpw',
            'label' => '新密碼',
            'rules' => 'trim|required|min_length[6]|max_length[12]'
        ),
        array(
            'field' => 'confirmpw',
            'label' => '確認密碼',
            'rules' => 'trim|required|min_length[6]|max_length[12]|matches[newpw]'
        ),
    ),
    'Admin/AdminAdd' =>  array(
        array(
            'field' => 'username',
            'label' => '管理員帳號',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'password',
            'label' => '管理員密碼',
            'rules' => 'trim|required|min_length[6]|max_length[12]'
        ),
        array(
            'field' => 'passwords',
            'label' => '再次確認密碼',
            'rules' => 'trim|required|min_length[6]|max_length[12]|matches[password]'
        ),
        array(
            'field' => 'name',
            'label' => '管理員名稱',
            'rules' => 'trim|required'
        ),
    ),
    'Admin/AdminUpdate' =>  array(
        array(
            'field' => 'username',
            'label' => '管理員帳號',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'password',
            'label' => '管理員密碼',
            'rules' => 'trim|min_length[6]|max_length[12]'
        ),
        array(
            'field' => 'passwords',
            'label' => '再次確認密碼',
            'rules' => 'trim|min_length[6]|max_length[12]|matches[password]'
        ),
        array(
            'field' => 'name',
            'label' => '管理員名稱',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'permission',
            'label' => '權限',
            'rules' => 'trim'
        ),
    ),
    'Admin/AdminUpdateStatus' =>  array(
        array(
            'field' => 'status',
            'label' => '狀態',
            'rules' => 'trim|required|numeric'
        ),
    ),
    'Admin/AdminDelete' =>  array(
        array(
            'field' => 'id',
            'label' => '狀態',
            'rules' => 'trim'
        ),
    ),

    'Management/MailEdit' =>  array(
        array(
            'field' => 'host',
            'label' => '主機位址',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'port',
            'label' => '端口',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'port_type',
            'label' => '端口類型',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'username',
            'label' => 'Email帳號',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'password',
            'label' => '密碼',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'from_to',
            'label' => '發信名稱',
            'rules' => 'trim|required'
        ),
    ),
    'Management/SettingEdit' =>  array(
        array(
            'field' => 'title_ch',
            'label' => '中文網站標題',
            'rules' => 'trim'
        ),
        array(
            'field' => 'title_en',
            'label' => '英文網站標題',
            'rules' => 'trim'
        ),
        array(
            'field' => 'address',
            'label' => '公司地址',
            'rules' => 'trim'
        ),
        array(
            'field' => 'servicetime',
            'label' => '服務時間',
            'rules' => 'trim'
        ),
        array(
            'field' => 'phone',
            'label' => '聯絡電話',
            'rules' => 'trim'
        ),
        array(
            'field' => 'fax',
            'label' => '傳真電話',
            'rules' => 'trim'
        ),
        array(
            'field' => 'line_id',
            'label' => 'Line 代號',
            'rules' => 'trim'
        ),
        array(
            'field' => 'email',
            'label' => '電子郵件',
            'rules' => 'trim|valid_email'
        ),
        array(
            'field' => 'siteurl',
            'label' => '網站網址',
            'rules' => 'trim'
        ),
        array(
            'field' => 'keyword',
            'label' => '關鍵字',
            'rules' => 'trim'
        ),
        array(
            'field' => 'description',
            'label' => '描述',
            'rules' => 'trim'
        ),
    ),
    'Management/SocialEdit' =>  array(
        array(
            'field' => 'client_id',
            'label' => '第三方應用程式編號',
            'rules' => 'trim|required'
        ),
    ),

    'Articles/Add' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'content',
            'label' => '內容',
            'rules' => 'trim|required'
        ),
    ),
    'Articles/Edit' =>  array(
        array(
            'field' => 'id',
            'label' => '編號',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'content',
            'label' => '內容',
            'rules' => 'trim|required'
        ),
    ),

    'About/ContactAjax' =>  array(
        array(
            'field' => 'type_id',
            'label' => '問題分類',
            'rules' => 'trim|required',
            'errors' => [
                'required' => '請選擇{field}'
            ]
        ),
        array(
            'field' => 'name',
            'label' => '姓名',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'company',
            'label' => '連絡電話',
            'rules' => 'trim'
        ),
        array(
            'field' => 'phone',
            'label' => '行動電話',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'email',
            'label' => '電子信箱',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'content',
            'label' => '內容',
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

    'Broadcast/SettingAdd' =>  array(
        array(
            'field' => 'title',
            'label' => '常見問題標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'content',
            'label' => '常見問題內容',
            'rules' => 'trim'
        ),
    ),
    'Broadcast/SettingEdit' =>  array(
        array(
            'field' => 'title',
            'label' => '常見問題標題',
            'rules' => 'trim'
        ),
        array(
            'field' => 'content',
            'label' => '常見問題內容',
            'rules' => 'trim'
        ),
    ),
    'Broadcast/SettingDelete' =>  array(
        array(
            'field' => 'status',
            'label' => '狀態',
            'rules' => 'trim'
        ),
    ),

    'Message/SettingAdd' =>  array(
        array(
            'field' => 'title',
            'label' => '簡訊標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'content',
            'label' => '簡訊內容',
            'rules' => 'trim'
        ),
    ),
    'Message/SettingEdit' =>  array(
        array(
            'field' => 'title',
            'label' => '簡訊標題',
            'rules' => 'trim'
        ),
        array(
            'field' => 'content',
            'label' => '簡訊內容',
            'rules' => 'trim'
        ),
    ),
    'Message/SettingDelete' =>  array(
        array(
            'field' => 'status',
            'label' => '狀態',
            'rules' => 'trim'
        ),
    ),
    'Message/Captcha' =>  array(
        array(
            'field' => 'cellphone',
            'label' => '手機號碼',
            'rules' => 'trim|required|numeric'
        ),
    ),
    'Message/SendMessage' =>  array(
        array(
            'field' => 'content',
            'label' => '內容',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'push_time_type',
            'label' => '發送時間',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'send_type',
            'label' => '發送類型',
            'rules' => 'trim|required'
        ),
    ),

    'Mail/SettingAdd' =>  array(
        array(
            'field' => 'title',
            'label' => '郵件標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'content',
            'label' => '郵件內容',
            'rules' => 'trim'
        ),
    ),
    'Mail/SettingEdit' =>  array(
        array(
            'field' => 'title',
            'label' => '郵件標題',
            'rules' => 'trim'
        ),
        array(
            'field' => 'content',
            'label' => '郵件內容',
            'rules' => 'trim'
        ),
    ),
    'Mail/SettingDelete' =>  array(
        array(
            'field' => 'status',
            'label' => '狀態',
            'rules' => 'trim'
        ),
    ),
    'Mail/SendMail' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'content',
            'label' => '內容',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'push_time_type',
            'label' => '發送時間',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'send_type',
            'label' => '發送類型',
            'rules' => 'trim|required'
        ),
    ),
    'Mail/Forgot' =>  array(
        array(
            'field' => 'email',
            'label' => 'lang:email',
            'rules' => 'trim|required|valid_email'
        ),
        array(
            'field' => 'captcha',
            'label' => 'lang:captcha',
            'rules' => 'trim|required|alpha_numeric'
        ),
    ),
    'Mail/ReceiveAdd' =>  array(
        array(
            'field' => 'type_id',
            'label' => '收件類型',
            'rules' => 'trim|required|numeric'
        ),
        array(
            'field' => 'title',
            'label' => '收件人姓名',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'email',
            'label' => '收件人信箱',
            'rules' => 'trim|required|valid_email'
        ),
    ),
    'Mail/ReceiveEdit' =>  array(
        array(
            'field' => 'type_id',
            'label' => '收件類型',
            'rules' => 'trim|required|numeric'
        ),
        array(
            'field' => 'title',
            'label' => '收件人姓名',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'email',
            'label' => '收件人信箱',
            'rules' => 'trim|required|valid_email'
        ),
    ),
    'Mail/captchaSend' =>  array(
        array(
            'field' => 'email',
            'label' => '電子郵件',
            'rules' => 'trim|required|valid_email'
        ),
    ),
    'Mail/forgetSend' =>  array(
        array(
            'field' => 'email',
            'label' => '電子郵件',
            'rules' => 'trim|required|valid_email'
        ),
    ),
    'Mail/Send' =>  array(
        array(
            'field' => 'email',
            'label' => '電子郵件',
            'rules' => 'trim|required|valid_email'
        ),
    ),

    'Contact/TypeAdd' =>  array(
        array(
            'field' => 'title',
            'label' => '詢問類型名稱',
            'rules' => 'trim|required'
        ),
    ),
    'Contact/TypeEdit' =>  array(
        array(
            'field' => 'id',
            'label' => '編號',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'title',
            'label' => '詢問類型名稱',
            'rules' => 'trim|required'
        ),
    ),
    'Contact/Edit' =>  array(
        array(
            'field' => 'id',
            'label' => '編號',
            'rules' => 'trim|required'
        ),
    ),
    'Contact/Reply' =>  array(
        array(
            'field' => 'content',
            'label' => '回覆內容',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'email',
            'label' => '客戶端信箱',
            'rules' => 'trim|required|valid_email'
        ),
    ),

    'News/TypeAdd' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'seq',
            'label' => '排序',
            'rules' => 'trim|required'
        ),
    ),
    'News/TypeEdit' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'seq',
            'label' => '排序',
            'rules' => 'trim|required'
        ),
    ),
    'News/Add' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'type_id',
            'label' => '分類',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'content',
            'label' => '內容',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'publish_time',
            'label' => '發佈日期',
            'rules' => 'trim|required'
        ),
    ),
    'News/Edit' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'type_id',
            'label' => '分類',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'content',
            'label' => '內容',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'publish_time',
            'label' => '發佈日期',
            'rules' => 'trim|required'
        ),
    ),

    'Albums/TypeAdd' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'seq',
            'label' => '排序',
            'rules' => 'trim|required'
        ),
    ),
    'Albums/TypeEdit' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'seq',
            'label' => '排序',
            'rules' => 'trim|required'
        ),
    ),
    'Albums/Add' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'type_id',
            'label' => '分類',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'content',
            'label' => '內容',
            'rules' => 'trim'
        ),
        array(
            'field' => 'publish_time',
            'label' => '發佈日期',
            'rules' => 'trim|required'
        ),
    ),
    'Albums/Edit' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'type_id',
            'label' => '分類',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'content',
            'label' => '內容',
            'rules' => 'trim'
        ),
        array(
            'field' => 'publish_time',
            'label' => '發佈日期',
            'rules' => 'trim|required'
        ),
    ),

    'Banner/Add' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'weblink',
            'label' => '連結網址',
            'rules' => 'trim'
        ),
        array(
            'field' => 'seq',
            'label' => '排序',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'slim',
            'label' => 'img',
            'rules' => 'required'
        ),
    ),
    'Banner/Edit' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'weblink',
            'label' => '連結網址',
            'rules' => 'trim'
        ),
        array(
            'field' => 'seq',
            'label' => '排序',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'slim',
            'label' => 'img',
            'rules' => 'required'
        ),
    ),

    'Popular/Add' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'type_id',
            'label' => '主分類',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'slim',
            'label' => 'img',
            'rules' => 'required'
        ),
    ),
    'Popular/Edit' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'type_id',
            'label' => '主分類',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'slim',
            'label' => 'img',
            'rules' => 'required'
        ),
    ),

    'Relations_file/Add' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'file',
            'label' => '檔案上傳',
            'rules' => 'trim'
        ),
        array(
            'field' => 'publish_time',
            'label' => '發佈日期',
            'rules' => 'trim|required'
        ),
    ),
    'Relations_file/Edit' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'file',
            'label' => '檔案上傳',
            'rules' => 'trim'
        ),
        array(
            'field' => 'publish_time',
            'label' => '發佈日期',
            'rules' => 'trim|required'
        ),
    ),

    'Relations_website/Add' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'weblink',
            'label' => '網址',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'seq',
            'label' => '排序',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'slim',
            'label' => 'logo',
            'rules' => 'required'
        ),
    ),
    'Relations_website/Edit' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'weblink',
            'label' => '網址',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'seq',
            'label' => '排序',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'slim',
            'label' => 'logo',
            'rules' => 'required'
        ),
    ),

    //國籍
    'Country/Add' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'seq',
            'label' => '排序',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'slim',
            'label' => 'img',
            'rules' => 'required'
        ),
    ),
    'Country/Edit' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'seq',
            'label' => '排序',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'slim',
            'label' => 'img',
            'rules' => 'required'
        ),
    ),

    //主題圖片
    'Banner_img/Add' =>  array(
        array(
            'field' => 'weblink',
            'label' => '連結網址',
            'rules' => 'trim'
        ),
        array(
            'field' => 'slim',
            'label' => 'img',
            'rules' => 'required'
        ),
    ),
    'Banner_img/Edit' =>  array(
        array(
            'field' => 'weblink',
            'label' => '連結網址',
            'rules' => 'trim'
        ),
        array(
            'field' => 'slim',
            'label' => 'img',
            'rules' => 'required'
        ),
    ),

    //常見問題
    'Faq/Add' =>  array(
        array(
            'field' => 'seq',
            'label' => '排序',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'content',
            'label' => '內容',
            'rules' => 'trim|required'
        ),
    ),
    'Faq/Edit' =>  array(
        array(
            'field' => 'seq',
            'label' => '排序',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'content',
            'label' => '內容',
            'rules' => 'trim|required'
        ),
    ),

    //主分類總管
    'Item_type/add' =>  array(
        array(
            'field' => 'title',
            'label' => '主分類標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'status',
            'label' => '分類狀態',
            'rules' => 'trim'
        ),
    ),
    'Item_type/edit' =>  array(
        array(
            'field' => 'title',
            'label' => '主分類標題',
            'rules' => 'trim|required'
        ),
    ),
    'Item_type/updateStatus' =>  array(
        array(
            'field' => 'status',
            'label' => '狀態',
            'rules' => 'trim|required'
        ),
    ),
    'Item_type/delete' =>  array(
        array(
            'field' => 'status',
            'label' => '狀態',
            'rules' => 'trim'
        ),
    ),
    'Item_type/updateSeq' =>  array(
        array(
            'field' => 'seq[]',
            'label' => '編號',
            'rules' => 'trim|required|numeric'
        ),
    ),

    //次分類總管
    'Item_category/add' =>  array(
        array(
            'field' => 'title',
            'label' => '次分類標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'type_id',
            'label' => '所屬主分類',
            'rules' => 'trim|required'
        ),
    ),
    'Item_category/edit' =>  array(
        array(
            'field' => 'title',
            'label' => '次分類標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'type_id',
            'label' => '所屬主分類',
            'rules' => 'trim|required'
        ),
    ),
    'Item_category/updateStatus' =>  array(
        array(
            'field' => 'status',
            'label' => '狀態',
            'rules' => 'trim|required'
        ),
    ),
    'Item_category/delete' =>  array(
        array(
            'field' => 'status',
            'label' => '狀態',
            'rules' => 'trim'
        ),
    ),
    'Item_category/updateSeq' =>  array(
        array(
            'field' => 'seq[]',
            'label' => '編號',
            'rules' => 'trim|required|numeric'
        ),
    ),

    //尺度分類總管
    'Item_scale/add' =>  array(
        array(
            'field' => 'title',
            'label' => '尺度分類標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'status',
            'label' => '分類狀態',
            'rules' => 'trim'
        ),
    ),
    'Item_scale/edit' =>  array(
        array(
            'field' => 'title',
            'label' => '尺度分類標題',
            'rules' => 'trim|required'
        ),
    ),
    'Item_scale/updateStatus' =>  array(
        array(
            'field' => 'status',
            'label' => '狀態',
            'rules' => 'trim|required'
        ),
    ),
    'Item_scale/delete' =>  array(
        array(
            'field' => 'status',
            'label' => '狀態',
            'rules' => 'trim'
        ),
    ),
    'Item_scale/updateSeq' =>  array(
        array(
            'field' => 'seq[]',
            'label' => '編號',
            'rules' => 'trim|required|numeric'
        ),
    ),

    //禮物總管
    'Gift/Add' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'points',
            'label' => '點數',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'slim',
            'label' => 'img',
            'rules' => 'required'
        ),
    ),
    'Gift/Edit' =>  array(
        array(
            'field' => 'title',
            'label' => '標題',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'points',
            'label' => '點數',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'slim',
            'label' => 'img',
            'rules' => 'required'
        ),
    ),

    //新增會員點數
    'Points/add/all' =>  array(
        array(
            'field' => 'type',
            'label' => '類型',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'points',
            'label' => '點數',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'remark',
            'label' => '備註',
            'rules' => 'trim|required'
        ),
    ),
    'Points/add/select' =>  array(
        array(
            'field' => 'member_select[]',
            'label' => '會員',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'type',
            'label' => '類型',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'points',
            'label' => '點數',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'remark',
            'label' => '備註',
            'rules' => 'trim|required'
        ),
    ),


);

$config     =   array_merge($config,$config_backend);
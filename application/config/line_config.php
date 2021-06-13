<?php
// LINE login
$config['LINE_login_channel_info'] = array(
    'channel_id' => '1655192873',
    'channel_secret' => '88fa74c8df5f07017bb5760bdae419cd',
);

$config['LINE_authorization_request_param'] = array(
    // make sure this uri is set in App settings of LINE Login channel
    'redirect_uri' => 'https://global-hot.com/Line/CallBack',
    'scope' => 'profile%20openid%20email',
    'bot_prompt' => 'aggressive',
);

// Message API
$config['Messaging_API_info'] = array(
    'channel_secret' => 'e3301b82d6ea81f64fc56c386d90c6ec',
    'channel_access_token' => 'NlISD1nM04sdCo3bxOY01VfNu05fiKRrIpmhpBC3tixPx6gfohAewWVQ/kf97aRz/8kPzeFscn0SjC33umI7Gx/NOyR4Ud4C7L1Tgf1+zkCkPbnBbimv6OJGKVKM6sjlr7wwjUSI9KWDUvatrmkWNQdB04t89/1O/w1cDnyilFU=',
);

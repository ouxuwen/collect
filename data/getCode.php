<?php

require_once('base.php');
session_start();
@$mobile = $_REQUEST['mobile'] or die('TYPEID REQUIRED');

if (isset($_SESSION[$mobile])) {
    if (time() - $_SESSION[$mobile] < 120) {
        echo json_encode([
            "code" => 2,
            "msg" => '您的手机号码发送过于频繁，请2分钟后再试~',
            "time"=>time() - $_SESSION[$mobile]
        ]);
        return;
    }
}

//修改为您的apikey. apikey可在官网（https://www.dingdongcloud.com)登录后获取
$apikey = "";


$ch = curl_init();

/* 设置验证方式 */
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));

/* 设置返回结果为流 */
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

/* 设置超时时间*/
curl_setopt($ch, CURLOPT_TIMEOUT, 60);

/* 设置通信方式 */
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


/***************************************************************************************/
 //获得账户
function get_user($ch, $apikey)
{
    curl_setopt($ch, CURLOPT_URL, 'https://api.dingdongcloud.com/v1/sms/userinfo');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('apikey' => $apikey)));
    return curl_exec($ch);
}

//验证码
function send_yzm($ch, $data)
{
    curl_setopt($ch, CURLOPT_URL, 'https://api.dingdongcloud.com/v1/sms/sendyzm');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    return curl_exec($ch);
}

//语音验证码
function send_yyyzm($ch, $data)
{
    curl_setopt($ch, CURLOPT_URL, 'https://api.dingdongcloud.com/v1/sms/sendyyyzm');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    return curl_exec($ch);
}

//通知
function send_tz($ch, $data)
{
    curl_setopt($ch, CURLOPT_URL, 'https://api.dingdongcloud.com/v1/sms/sendtz');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    return curl_exec($ch);
}

//营销
function send_yx($ch, $data)
{
    curl_setopt($ch, CURLOPT_URL, 'https://api.dingdongcloud.com/v1/sms/sendyx');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    return curl_exec($ch);
}


// 取得用户信息
$json_data = get_user($ch, $apikey);
$array = json_decode($json_data, true);



// 发送单条短信
// 修改为您要发送的短信内容,需要对content进行编码
$code = rand(1111, 9999);
$yzmcontent = "【地理视界】你的验证码是" . $code . "，请在10分钟内输入。请勿告诉其他人。";
$data = array('content' => urlencode($yzmcontent), 'apikey' => $apikey, 'mobile' => $mobile);
$json_data = send_yzm($ch, $data);
$array = json_decode($json_data, true);
if ($array['code'] == 1) {
    // store session data
    $_SESSION['code'] = $code;
    $_SESSION[$mobile] = time();
}
echo $json_data;




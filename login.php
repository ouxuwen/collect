<?php

require_once('./base.php');

session_start();

@$username = $_REQUEST['username'] or die('TYPEID REQUIRED');
@$mobile = $_REQUEST['mobile'] or die('TYPEID REQUIRED');
@$code = $_REQUEST['code'];

if ($code && isset( $_SESSION['code'])) {
    if ($_SESSION['code'] != $code) {
        echo json_encode(
            [
                "status" => 0,
                "msg" => '验证码错误',
                "data" => '',
                "code"=>$_SESSION['code'],
                "time"=>$_SESSION[$mobile]
            ]
        );
        return;
    }else{
        $sql = "update user set mobile=$mobile WHERE username='$username' ";
        $result = mysqli_query($conn, $sql);
    };
}else{
    unset($_SESSION['code']);
    unset($_SESSION['mobile']);
}

$sql = "SELECT * FROM user WHERE username='$username' ";
$result = mysqli_query($conn, $sql);

//DQL: false或结果集描述对象
if ($result === false) {
    echo "SELECT ERR: $sql";
} else {
	//SQL执行成功，读取所有记录行
    $list = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if ($list) {
        $sql = "SELECT * FROM user WHERE username='$username' and mobile = $mobile ";
        $result = mysqli_query($conn, $sql);
        if ($result === false) {
            echo "SELECT ERR: $sql";
        } else {
            //SQL执行成功，读取所有记录行
            $list = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $date = date("Y-m-d H:i:s"); 
            $sql = "update user set login_time='$date' WHERE mobile='$mobile' and username='$username' ";
            $result = mysqli_query($conn, $sql);

            if ($list) {
                echo json_encode(
                    [
                        "status" => 1,
                        "msg" => '',
                        "data" => $list[0],
                    ]
                );
            } else {
                echo json_encode([
                    "status" => 2,
                    "msg" => '检测到你的手机号码更新了，需要填写验证码哦~'
                ]);
            }
        }
    } else {
        echo json_encode([
            "status" => 0,
            "msg" => '你好像不是我们班的人哦~'
        ]);
    }

}
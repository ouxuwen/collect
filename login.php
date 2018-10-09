<?php

require_once('./base.php');

@$username = $_REQUEST['username'] or die('TYPEID REQUIRED');
@$mobile = $_REQUEST['mobile'] or die('TYPEID REQUIRED');


$sql = "SELECT * FROM user WHERE username='$username' ";
$result = mysqli_query($conn,$sql);

//DQL: false或结果集描述对象
if($result===false){
	echo "SELECT ERR: $sql";
}else {
	//SQL执行成功，读取所有记录行
	$list = mysqli_fetch_all($result, MYSQLI_ASSOC);	
	if($list){
        $sql = "SELECT * FROM user WHERE username='$username' and mobile = $mobile ";
        $result = mysqli_query($conn,$sql);
        if($result===false){
            echo "SELECT ERR: $sql";
        }else {
            //SQL执行成功，读取所有记录行
            $list = mysqli_fetch_all($result, MYSQLI_ASSOC);	
            if($list){
                echo json_encode(
                    [
                        "status"=>1,
                        "msg"=>'',
                        "data"=> $list[0]
                    ]
                   );
            }else{
                echo json_encode([
                    "status"=>0,
                    "msg"=>'检测到你的手机号码更新了，需要填写验证码哦~'
                ]);
            }
        }
	}else{
		echo json_encode([
            "status"=>0,
            "msg"=>'你好像不是我们班的人哦~'
        ]);
	}
	
}
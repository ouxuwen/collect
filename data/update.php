<?php

require_once('base.php');

@$mobile = $_REQUEST['mobile'];
@$username = $_REQUEST['username'];
@$email = $_REQUEST['email'];
@$job = $_REQUEST['job'];
@$major = $_REQUEST['major'];
@$address = $_REQUEST['address'];
@$sex = $_REQUEST['sex'];
@$notice = $_REQUEST['notice'];
@$city = $_REQUEST['city'];
$date = date("Y-m-d H:i:s"); 
$sql = "update user set email='$email',job='$job',major='$major',address='$address',notice='$notice' ,sex='$sex',city='$city',update_time='$date' WHERE mobile='$mobile' and username='$username' ";
$result = mysqli_query($conn, $sql);

//DQL: false或结果集描述对象
if ($result === false) {
	echo "SELECT ERR: $sql";
} else {
	//SQL执行成功，读取所有记录行

	if ($result == 1) {
       
		$sql = "SELECT * FROM user WHERE username='$username' and mobile = $mobile ";
		$result = mysqli_query($conn, $sql);
		
        if ($result === false) {
            echo "SELECT ERR: $sql";
        } else {
            //SQL执行成功，读取所有记录行
			$list = mysqli_fetch_all($result, MYSQLI_ASSOC);
			echo json_encode(
				[
					"status" => 1,
					"msg" => '更新成功，非常感谢您的支持~',
					"data" => $list[0],
	
				]
			);
		}
		
	} else {
		echo json_encode(
			[
				"status" => 0,
				"msg" => '更新失败',
				"data" => $result,

			]
		);
	}

}
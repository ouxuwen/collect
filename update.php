<?php

require_once('base.php');

@$mobile = $_REQUEST['mobile'] or die('TYPEID REQUIRED');
@$password = $_REQUEST['username'] or die('TYPEID REQUIRED');
@$email = $_REQUEST['email'] or die('TYPEID REQUIRED');
@$job = $_REQUEST['job'] or die('TYPEID REQUIRED');
@$major = $_REQUEST['major'] or die('TYPEID REQUIRED');
@$address = $_REQUEST['address'] or die('TYPEID REQUIRED');


$sql = "SELECT * FROM user WHERE mobile='$mobile' and password='$password' ";
$result = mysqli_query($conn,$sql);

//DQL: false或结果集描述对象
if($result===false){
	echo "SELECT ERR: $sql";
}else {
	//SQL执行成功，读取所有记录行
	$list = mysqli_fetch_all($result, MYSQLI_ASSOC);	
	if($list){
		echo json_encode($list[0]);
	}else{
		echo json_encode('error');
	}
	
}
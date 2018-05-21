<?php 
require_once "autoload.php";
$phone = isset($_POST['phone'])?$_POST['phone']:null;
$phoneInfo = app\Queryphone::query($phone);
var_dump($phoneInfo);//一定要输出  之前不小心把这个删掉了   index.html里面的console.log(response);不显示数据
 ?>
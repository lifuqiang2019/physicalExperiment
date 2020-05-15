<?php
session_start();
include("conn/conn.php");

$loginName = $_POST['username'];
$passWord = $_POST['userpwd'];
$passWord2 = $_POST['userpwd2'];

$code = $_POST["code"];
//if (strtoupper($_SESSION['code']) != strtoupper($_POST['code'])) {
//    echo "<script>alert('验证码不正确');</script>";
//    exit;
//}
if(!isset($loginName) || $loginName == ''){
    echo "<script>alert('用户名不能为空'); </script>";
}
if($passWord=='' || $passWord2==''){
    echo "<script>alert('密码不能为空'); </script>";
    exit;
}
if($passWord !=  $passWord2){
    echo "<script>alert('两次密码不一致'); </script>";
    exit;
}
$passMd5 = md5($passWord);

$sql = "UPDATE users SET userpwd = '$passMd5', userpwd1 = '$passMd5' WHERE username = '$loginName'";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<script>alert('新密码更新成功'); window.location.href='./login.php';</script>";
} else {
    echo "<script>alert('密码更新失败'); window.hostory.go(-1);</script>";
}
?>
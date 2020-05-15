<?php
session_start();
include("conn/conn.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $loginName = $_POST['username'];
    $passWord = $_POST['userpwd'];
    $passWord2 = $_POST['userpwd2'];

    $code = $_POST["code"];
    //if (strtoupper($_SESSION['code']) != strtoupper($_POST['code'])) {
    //    echo "<script>alert('验证码不正确');</script>";
    //    exit;
    //}
    if (!isset($loginName) || $loginName == '') {
        echo "<script>alert('用户名不能为空'); </script>";
    }else if ($passWord == '' || $passWord2 == '') {
        echo "<script>alert('密码不能为空'); </script>";
    }else if ($passWord != $passWord2) {
        echo "<script>alert('两次密码不一致'); </script>";
    }else{
        $sqlfind ="SELECT * FROM users WHERE username = '$loginName'";
        $resultfind = mysqli_query($conn, $sqlfind) ;
        $rows = array();
        while($row = mysqli_fetch_array($resultfind)) {
            $rows[] = $row;
        }
        if(count($rows)==0){
            echo "<script>alert('用户不存在'); </script>";
        }else{
            $passMd5 = md5($passWord);
            $user = "SELECT * FROM users WHERE username = '$loginName'";

            $sql = "UPDATE users SET userpwd = '$passMd5' WHERE username = '$loginName'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>alert('新密码更新成功'); window.location.href='./login.php';</script>";
            } else {
                echo "<script>alert('密码更新失败'); window.hostory.go(-1);</script>";
            }
        }
    }

}
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>考试星</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <script type="text/javascript">
        function foo() {
            if (myform.name.value == "") {
                alert("请输入用户名");

                myform.username.focus();
                exit();
                return false;

            }
            if (myform.userpwd.value == "") {
                alert("请输入密码");
                myform.pwd.focus();
                exit();
                return false;

            }
            if (myform.code.value == "") {
                alert("请输入验证码");
                myform.code.focus();
                exit();
                return false;

            }
        }
    </script>
</head>
<body>
<form method="post" action="getPassword.php" name="myform" onsubmit="return foo()">
    <div id="mainbody">
        <div class="mainbox">
            <div class="top">
                <div class="image"></div>
                <div class="total"><p style="color:#0ef2fa">考试系统</p></div>
            </div>
            <input type="text" name="username" class="xuehao" placeholder="学号" style="margin-top:50px">
            <input type="password" name="userpwd" class="xuehao" placeholder="请输入新密码">
            <input type="password" name="userpwd2" class="xuehao" placeholder="再次确认密码">

            <input type="text" class="xuehao" name="code" placeholder="验证码" id="validate"
                   style="margin-top:20px;margin-left:75px">

            <!-- <div class="image2" style="cursor: hand" src="code.php" onclick="this.src='code.php?'+Math.random()"></div> -->
            <img class="yzm" style="cursor: hand" src="includes/code.php"
                 onclick="this.src='includes/code.php?'+Math.random()" style="margin-top:40px" width="130px"
                 height="60px">

            <button id="begin"
                    style="margin-top:25px;width:250px;height:40px;border:1px solid rgb(62,118,177);background:rgb(62,118,177);border-radius: 5px;color:white;">
                找回密码
            </button>
            <span><input type="hidden" name="hidden" value="hidden"></span>
        </div>
    </div>
</form>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="css/index.css">
  <title>在線考試系統後台管理</title>
</head>
<body>
  <div class="homepage">
      <div class="top">
      </div>
      <div class="nexttop">
          <div class="leftnexttop">
                <p>在线考试后台管理系统</p>
          </div>
          <ul>

            <?php
            error_reporting(E_ALL || ~E_NOTICE);
            include('adlogin/cookie.php');
            //$username = $_SESSION['username'] 
            //var_dump($_SESSION['name']);
            // echo $_SESSION['type'].$_SESSION['name'];
            // echo var_dump($_SESSION);
            if($_SESSION['name']==""){
              echo "<script>alert('请登陆');history.go(-1);</script>"; 
           }
             if(isset($_SESSION['name']) && isset($_SESSION['type']) && $_SESSION['type']=='1'){
                echo "<li>管理员 ".$_SESSION['name']."</li>";
              } else if(isset($_SESSION['name']) && isset($_SESSION['type']) && $_SESSION['type']=='0') {
                echo "<li>老师 ".$_SESSION['name']."</li>";
              } else {
                echo '<li><a href="adlogin/login.php">管理员登录</li>';
              }
           
              if(isset($_SESSION['name'])){
                echo "<li><a href='adlogin/logout.php'>退出</a></li>";
              }
              ?>
          </ul>
      </div>
      <?php  include('./left.php') ?>
  </div>
</body>
</html>
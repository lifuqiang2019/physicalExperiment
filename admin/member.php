<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="css/index.css">
  <script type="text/javascript">
      function del(){

      var msg=confirm("你确定删除此记录吗？");

      if(msg==true){

       return true;

      }else{

       return false;

 }

}
  </script>
  <title>在线考试后台管理系统</title>
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
            session_start();
            error_reporting(E_ALL || ~E_NOTICE);
            include('adlogin/cookie.php');
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
              ?>    
              <?php
             error_reporting(E_ALL || ~E_NOTICE);
              if(isset($_SESSION['name'])){
                echo "<li><a href='adlogin/logout.php'>退出</a></li>";
              }
              ?>

          </ul>
      </div>
      <?php include('./left.php')?>
      
      <div class="right">
      			<?php
          session_start();
      		if($_SESSION['name']==""){
           		echo "<script>alert('请登录');history.go(-1);</script>"; 
           }
	include ("conn.php");
	error_reporting(E_ALL || ~E_NOTICE);
	mysqli_query($conn,"set names utf8");
	mysqli_select_db($conn,"users");
	$sql = "SELECT * from users order by id";
	$result = mysqli_query($conn,$sql) or die("false");

	if($_GET['id']){
		$sql = "DELETE  from users where id='{$_GET['id']}'";
		 echo $sql;
	   		mysqli_query($conn,$sql) or die("false1");
		
		echo "<script>alert('删除成功')</script>";
		echo "<script>window.location.href='member.php'</script>";

	}

	echo '<table border="1" width="900" align="center" class="table" style="width: 201%;margin: 0 6%;">';
	echo '<br>';
	echo '<caption class="h1"><h1>考生信息</h1></caption>';
	echo '<br>';
	echo '<tr>';
	echo '<th>学号</th>';
	echo '<th>姓名</th>';
	echo '<th>性別</th>';
	echo '<th>邮箱</th>';
	echo '<th>学校</th>';
	echo '<th>操作</th>';
	echo '</tr>';
	
	while($array=mysqli_fetch_array($result)){
		// $temp[] = $array['name'];
		// var_dump($array);
		echo '<tr>';
		echo "<td align='center'>{$array['username']}</td>";
		echo "<td align='center'>{$array['zsname']}</td>";
		echo "<td align='center'>{$array['sex']}</td>";
		echo "<td align='center'>{$array['email']}</td>";
		echo "<td align='center'>{$array['school']}</td>";
		echo "<td align='center'><a href='member.php?&id={$array['id']}' onclick='return del()'>删除</a></td>";
		echo '</tr>';						
	}

?>

      </div>
</body>
</html>
<?php
    session_start();
    include('conn.php');
    include('page.class.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>上传</title>
 <link rel="stylesheet" type="text/css" href="css/add.css">
 <link rel="stylesheet" type="text/css" href="css/index.css">
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
      

    <div class="main">
<fieldset>
  <form action="./interface/check-experiment.php" method="post">

    <table class="bg">

      <tr class="tr">
        <td width="200px" height="10px">
           <center>实验类型<input type="text" name="experimental_type" class="kslx"/></center>
        </td>
        <td >
          <!-- <center>实验类型
            <select name="ktlx">
              <option value="单选题">单选题</option>
              <option value="多选题">多选题</option>
              <option value="判断题">判断题</option>
              <option value="简答题">简答题</option>
          </select> -->
          分数
          <select name="max_nums">
            <?php for ($i=5; $i<45 ; $i=$i+5) {  ?>

            <option value="<?php echo $i;?>"><?php echo $i;?></option>
          <?php  }?>
           </select>
           </center>
        </td>
      </tr>
      <tr class="tr">
        <td width="100px" height="100px">
          <center>实验内容</center>
        </td>
        <td width="200px" height="100px">
          <textarea class="srk" name="experimental_content">
          </textarea>
        </td
      </tr>
      <!-- <tr class="tr">
        <td>
          <center>标准答案</center>

        </td>
        <td width="200px" height="100px">
          <textarea class="srk" name="kqda">
          </textarea>
        </td
      </tr> -->
      <tr class="tr">
        <td>
          <center>实验数据数目</center>

        </td>
        <td width="200px" height="100px">
          <!-- <textarea class="srk" name="kqda">
          </textarea> -->
          <input type="number" name="asks_nums" id="">
        </td
      </tr>
      <tr class="tr">
        <td>
          <center>正确答案</center>

        </td>
        <td width="200px" height="100px">
          <textarea class="srk" name="experimental_standard">
          </textarea>
        </td>
      </tr>
      <tr class="tr">
        <td>
          <center>考题解析</center>

        </td>
        <td width="200px" height="100px">
          <textarea class="srk" name="experimental_jx">
          </textarea>
        </td>
      </tr>
      <td class="anniu">
        <center><input type="submit" name="submit" value="添加试题"></center>
      </td>
      <table>
  </form>
</fieldset>
      </div>
  </body>
</html>

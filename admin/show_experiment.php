<?php
    session_start();
    include('conn.php');
    include('page.class.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>考题信息管理</title>
 <link rel="stylesheet" type="text/css" href="css/add.css">
 <link rel="stylesheet" type="text/css" href="css/index.css">
 <style>
   .main {
     margin-left: 9%;
   }
 </style>
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
          
                   <?php
                   if(isset($_GET['action']) && $_GET['action']=='ser'){
                      $tmp = !empty($_POST) ? $_POST : $_GET;
    
                         $whr=array();
                      if(!empty($tmp['experiment_name'])){
                        $whr[] = "experiment_name like '%{$tmp['experiment_name']}%'";
                      }
                      if(!empty($tmp['ask_content'])){
                        $whr[] = "ask_content like '%{$tmp['ask_content']}%'";
                      }
                      
                      if(!empty($whr)){
                        $where ="where".' '.implode("and", $whr);
                        //echo $where;
                      }else{
                        $where = "";
                      }
                     
                   }

                   
                   
                    //獲取總記錄數
                    $sql = "SELECT count(*) as total from experiment {$where}";
                    //echo $sql."<br>";
                    $res = mysqli_query($conn,$sql);
                    $data = mysqli_fetch_assoc($res);

                    $num = 5;
                    //創建分頁對象
                    $page = new Page($data['total'],$num);



                      $sql = "SELECT * from experiment  {$where} order by id {$page->limit}";
                      //var_dump($sql);
                    //   echo $sql."<br>";
                      $result = mysqli_query($conn,$sql) or die("gg");

                      echo "搜索实验<br>";
                      echo '<form action="./show_experiment.php?action=ser" method="post" name="form1">';
                      
                      echo '輸入内容';
                      echo '　<input type="text" name="ask_content" size=20 >　　';
                      echo '<input type="submit" name="sersubmit" size=12 value="搜索" >';
                      echo '</form><br/>';
                    // echo var_dump(mysqli_fetch_array($result));
                    // exit();
                     while(list($id,$experiment_name, $asks_nums, $standard_answer, $ask_content, $max_nums, $experimental_jx) = mysqli_fetch_row($result)) {
                       

                        echo '<form action="./interface/modify-experimental.php" method="post" name="form1" >';
                        echo '<table width="682" height="168" border="0"  bgcolor="#5D554A">';
                        echo '<tr>';
                        echo '<td width="112" height="27" align="center" bgcolor="#DDDDDD" class="STYLE1">';
                        echo '实验類型';
                        echo '</td>';
                        echo' <td width="117" align="center" bgcolor="#DDDDDD" class="STYLE1">
                          '.$experiment_name.'</td>';
                        echo '<td width="180" align="center" bgcolor="#DDDDDD" class="STYLE1">';
                        echo  '考题类型　　';
                        echo "实验";
                        echo '</td>';
                        echo '<td width="148" align="center" bgcolor="#DDDDDD" class="STYLE1">';
                        echo '分数　　';
                        echo "{$max_nums}";
                        
                        echo '</td>';
                        echo '<td width="99" rowspan="5" align="center" bgcolor="#FFFFFF" class="STYLE1">';
                        echo '<input type="hidden" name="id" value="'.$id.'">';

                        echo '<input type="submit" name="submit2" value="修改">';
                        echo '/';
                        echo '<input type="submit" name="submit3" value="删除" onclick="return del()">';
                        echo '</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td height="43" align="center" bgcolor="#DDDDDD">';
                    echo '实验內容';
                    echo '</td>';
                    echo '<td colspan="3" align="center" bgcolor="#FFFFFF" class="STYLE1">';
                    echo '<textarea name="ask_content" cols="60" rows="5">'.$ask_content.'</textarea>';
                    echo '</td>';
                    echo '</tr>';
                     echo '<tr>';
                    echo '<td height="43" align="center" bgcolor="#DDDDDD">';
                    echo '选项个数';
                    echo '</td>';
                    echo '<td colspan="3" align="center" bgcolor="#FFFFFF" class="STYLE1">';
                    echo "<input name='asks_nums' type='number' value='$asks_nums'/>";
                    echo '</td>';
                    echo '</tr>';
                     echo '<tr>';
                    echo '<td height="43" align="center" bgcolor="#DDDDDD">';
                    echo '正确答案';
                    echo '</td>';
                    echo '<td colspan="3" align="center" bgcolor="#FFFFFF" class="STYLE1">';
                    echo '<textarea name="standard_answer" cols="60" rows="5">'.$standard_answer.'</textarea>';
                    echo '</td>';
                    echo '</tr>';
                    echo '<tr>';
                     echo '<td height="43" align="center" bgcolor="#DDDDDD">';
                    echo '解析';
                    echo '</td>';
                    echo '<td colspan="3" align="center" bgcolor="#FFFFFF" class="STYLE1">';
                    echo '<textarea name="experimental_jx" cols="60" rows="5">'.$experimental_jx.'</textarea>';
                    echo '</td>';
                    echo '</tr>';
                        echo '</table>'; 
                        echo '</form>';

                      }
                                           
                
                      echo '<tr><td colspan="10" align="right">'.$page->fpage().'</td></tr>';
                 ?>
         
      </div>
      </div>
  </body>
</html>
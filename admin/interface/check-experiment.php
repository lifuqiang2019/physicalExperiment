<?php
header("Content-Type: text/html; charset=utf-8");
include_once '../includes/global.func.php';
include_once '../conn.php';
$experimental_type=$_POST['experimental_type'];
$experimental_content=$_POST['experimental_content'];
$max_nums=$_POST['max_nums'];
$asks_nums = $_POST['asks_nums'];
$experimental_standard=$_POST['experimental_standard'];
$experimental_jx=$_POST['experimental_jx'];

$str= mb_ereg_replace('^(　| )+', '', $experimental_standard);

if(isset($_POST['submit'])){
    $check_sql = "SELECT COUNT(*) from experiment WHERE experiment_name = '$experimental_type';";
    // echo $check_sql;
    // exit();
    $result = mysqli_query($conn,$check_sql);
    if($result) {
        $sql =  "insert into experiment (experiment_name,asks_nums,standard_answer,ask_content,max_nums,experimental_jx) values('$experimental_type','$asks_nums','$str','$experimental_content','$max_nums','$experimental_jx')";
        echo $sql;
        if (!mysqli_query($conn,$sql)) {
        die ('Error: ' .mysqli_error());
        }
        _alert_back('提交试题成功');
    } else {
        _alert_back('实验题目已存在');
    }
    
   mysqli_close($conn);
}
?>

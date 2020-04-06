<?php 
	header ( "Content-type: text/html; charset=utf-8" );  	
session_start();
	include ("../conn.php");
	if(isset($_SESSION['name'])){
		if(isset($_SESSION['name']) && $_POST['submit2']){
				
				mysqli_select_db($conn,"experiment");

				if(isset($_POST['submit2'])){
			

				$sql = "UPDATE `experiment` SET ask_content='".$_POST['ask_content']."',asks_nums='".$_POST['asks_nums']."',standard_answer='".$_POST['standard_answer']."',experimental_jx='".$_POST['experimental_jx']."' WHERE id='".$_POST['id']."'";
				}
			$result = mysqli_query($conn,$sql) or die("gg");
			if($result){
			echo "<script>alert('修改成功');location.href='../show_experiment.php';</script>";
		}else{
			echo "<script>alert('修改');history.go(-1);</script>";
			exit();
			}
		}
		if(isset($_POST['submit3'])){
			mysqli_select_db($conn,"experiment");
			$sql = "DELETE from experiment WHERE id='".$_POST['id']."'";
			$result = mysqli_query($conn,$sql) or die("链接失败");
			if(mysqli_affected_rows($conn)){
				echo "<script>alert('刪除成功');history.go(-1);</script>";
			}else{
				echo "<script>alert('刪除失敗');history.go(-1);</script>";
			}
		}	
	}else
		{
			echo "<script>alert('请登录');history.go(-1);</script>";
		}
?>
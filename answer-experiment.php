<?php
session_start();
include_once 'includes/global.func.php';
include_once 'conn/conn.php';

$sd=$_SESSION['gesu'];
$aa=$_POST['submit0'];

for ($i=0; $i <$sd ; $i++) { 
	if ($_POST['submit'.$i]) {
		$rrr=$_POST['submit'.$i];
	}
}

if($rrr) {
	$_SESSION['rrr']=$rrr;
}



	

// if (!$rrr) {
// 	_alert_eo(操作错误);
// }


		
$sql = "SELECT * FROM experiment where experiment_name='".$_SESSION["rrr"]."'";

$result = mysqli_query($conn,$sql);
// $row = mysqli_fetch_array($result);

$temp=mysqli_fetch_array($result);


$sql_search_check_top = "SELECT COUNT(*) FROM stu_experiment WHERE stu_name = '{$_SESSION['username']}' and experiment_name = '{$_SESSION["rrr"]}' and status='1';";
$result_search_check_top =  mysqli_query($conn,$sql_search_check_top) or die('连接失败');

if($size = mysqli_fetch_all($result_search_check_top)[0][0]>0) {
	
	$_SESSION['status'] = 1;
} else {
	$_SESSION['status'] = 0;
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $_SESSION["rrr"];?>实验中</title>
	<link rel="stylesheet" type="text/css" href="css/answer.css">
	<style>
		.experiment_title {
			color: blueviolet;
			margin: 15px 0;
			width: 100%;
		}

		.experiment_content {
			margin: 0 auto;
			width: 96.6%;
			padding: 15px;
			border: 1px dotted blueviolet;
			background: wheat;
		}

		.experiment_item {
			text-align: center;
			/* margin-right: 15px; */
			border: 1px solid #ccc;
			border-right: 0;
			padding: 3px 15px;
		}

		.experiment_item:last-child {
			border-right: 1px solid #ccc;
		}

		.experiment_item_index {
			text-align: center;
		}

		.experiment_item_yours {
			text-align: center;
		}
	</style>
	<script src="./js/Chart.min.js"></script>
	<script type="text/javascript">
		var initial_fontsize = 15;
		function setFontsize(type,objname){
		    var oDiv = document.getElementById('wholepage_two');
		    if (oDiv!=null) {
		        if (type==1){
		            if(initial_fontsize<20){
		                oDiv.style.fontSize=(++initial_fontsize)+'px';
		            };
		        }
		        else {
		            if(initial_fontsize>12){
		                oDiv.style.fontSize=(--initial_fontsize)+'px';
		            }
		        }
		    }
		}

		// function Change(HourSurplus,MinuteSurplus,SecondSurplus)
		// {

		//  SecondSurplus = SecondSurplus - 1;
		//  if (SecondSurplus<0)
		//  {
		//  SecondSurplus=60+SecondSurplus;
		//  MinuteSurplus=MinuteSurplus-1;
		//  }
		//  if (MinuteSurplus<0)
		//  {
		//  MinuteSurplus=60+MinuteSurplus;
		//  HourSurplus=HourSurplus-1;
		//  }
		//  document.getElementById("time_con").innerHTML=""+ HourSurplus +":"+ MinuteSurplus +":"+ SecondSurplus +"";
		//  setTimeout(function() {
		//  Change(HourSurplus,MinuteSurplus,SecondSurplus);
		//  },1000);
		//   if(SecondSurplus>=0&&MinuteSurplus>=0&&HourSurplus<0){
		//  	alert("时间到,请点击提交");
		//  }
		// }
	</script>
</head>
<body>
    <form action="answer-experiment.php?action=in" method="post">
		<div class="wholepage">
			<div class="logo">
				<div class="font-art">
					<a href="./startteam.php">
					<span class="art">JWroom</span><span class="art_two">考试系统</span>
					</a>
				</div>
				<!-- 头像名字 -->
				<?php
					include ('conn.php');
					$username = $_SESSION['username'];
					mysqli_select_db($conn,"topic");
					if(isset($_SESSION['username'])){
					$sql = "SELECT * from users where username = '{$_SESSION['username']}'";

					$result = mysqli_query($conn,$sql) or die('连接失败');
					if($html = mysqli_fetch_array($result)){
				// echo $html['face'];
				// print_r($html);
					$cores = 0;
				if($_GET['action'] == "in") {
					$result_str = "";
					// echo $_POST['yours_'.1];
					// 		exit();
					for($i=1;$i<=$temp['asks_nums'];$i++) {
						if($_POST['yours_'.$i]) {
							
							$result_str=$result_str.$_POST['yours_'.$i]."|";
						} else {
							echo "<script>alert('请输入完成数据');window.location.href='http://localhost/test/test1/answer-experiment.php';</script>";
							exit();
						}
					}
					$result_str = substr($result_str,0, strlen($result_str)-1);
				
					
					$sql_search_check = "SELECT * FROM stu_experiment WHERE stu_name = '{$_SESSION['username']}' and experiment_name = '{$_SESSION["rrr"]}';";
					$result_search_check =  mysqli_query($conn,$sql_search_check) or die('连接失败');

					if($len_check = sizeof(mysqli_fetch_all($result_search_check))<5) {
						$_SESSION['status'] = 0;
						$sql_result = "INSERT INTO `stu_experiment` (`status`, `experiment_id`, `experiment_name`, `experiment_standard`, `stu_id`, `stu_name`, `stu_result`, `cores`) VALUES
						('0',".$temp['id'].", '".$temp['experiment_name']."', '".$temp['standard_answer']."', {$html['id']}, '".$_SESSION['username']."', '".$result_str."', '".$cores."')";
				
						if($len_check==4){
							$_SESSION['status'] = 1;
							$sql_result = "INSERT INTO `stu_experiment` (`status`, `experiment_id`, `experiment_name`, `experiment_standard`, `stu_id`, `stu_name`, `stu_result`, `cores`) VALUES
						('1',".$temp['id'].", '".$temp['experiment_name']."', '".$temp['standard_answer']."', {$html['id']}, '".$_SESSION['username']."', '".$result_str."', '".$cores."')";
				
						}
						
						$result_in = mysqli_query($conn,$sql_result) or die('连接失败');
						if($result_in) {
							echo "<script>alert('数据录入成功')</script>";
						}
					} else {
						$_SESSION['status'] = 1;
						echo "<script>alert('您已录入实验数据5次，实验结束')</script>";
					}
					
			}
		}
	}
		else{
			echo "<script>alert('请登录');history.go(-1);</script>";
		}
				?>
				<div class="head_pic ">
					
					<img class="pic_logo" src="<?php echo $html['face']?>" >
					<div class="pic_font"><?php echo $html['username']?> </div>
				<?php
					if (isset($_SESSION['username'])) {
						echo "<li class='exit'><a href='startteam.php'>退出&nbsp&nbsp</a></li>";
					} else {
						echo "<li class='exit'>{$_SESSION['username']}</li>";
					}
		
						?>
				</div>

			</div>
			<!-- 实验题目 -->
			<div id="wholepage_two">
				<div class="backg"></div>
				<div class="time">
					<div class="team_name">
						<ul>
							<li><span><?php echo $_SESSION["rrr"];echo isset($_SESSION['status'])&&$_SESSION['status']==1 ? "(已完成)" : "";?></span></li>
							<li><div id="time_con"></div></li>
						</ul>
					</div>
					<div class="submit_one">
						<ul>
							<li>
								<div id="size">
									<div id="jia"><input type="button" value="+" onclick="setFontsize(1,'Content')"></div>
									<span style="float:left;font-weight: lighter;font-size:110%;">A</span>
									<div id="jian"><input onclick="setFontsize(0,'Content')"  type="button" value="-"></div>
								</div>
							</li>
							<li><div id="enter"><a href="#" style="text-decoration:none;"><input type="submit" name="submit" value="提交"></a></div></li>
						</ul>
					</div>
				</div>
				<div class="content">
					<h3 class="experiment_title">实验内容</h3>
					<p class="experiment_content">
						<?php 
							echo $temp["ask_content"];
						?>
					</p>

					<h3 class="experiment_title">填写数据</h3>

					<p class="experiment_content">
						<?php 
							for($i=1;$i<=$temp["asks_nums"];$i++) {
								echo "数据$i <input type='number' name='yours_$i'/>"."   ";
							}
						?>
					</p>

					<h3 class="experiment_title">数据表格</h3>

					<div class="experiment_content" style="display: flex;justify-content: center;">
						<?php 
							$sql_search = "SELECT * FROM stu_experiment WHERE stu_name = '{$_SESSION['username']}' and experiment_name = '{$_SESSION["rrr"]}';";
							// echo $sql_search;
							$result_search = mysqli_query($conn,$sql_search) or die('数据库链接失败');

							if($result_search) {
								// $result_search_array = mysqli_fetch_array($result_search);
								// print_r($result_search_array);
								// echo sizeof($result_search_array);
								$index = 0;
								echo "<script>
									var echarts_arr = [];
								";
								$echarts = array();
								// $len = sizeof(mysqli_fetch_all($result_search));
								for($i=0; $i<$temp['asks_nums']; $i++) {
									array_push($echarts, []);
									echo "echarts_arr.push([]);";
								}
								echo "</script>";
								while(list($id,$experiment_id, $experiment_name, $experiment_standard, $stu_id, $stu_name, $stu_result, $cores) = mysqli_fetch_row($result_search)) {
								// for ($i=0;$i<count($result_search_array);$i++) {
									$index++;
									?>
										<div class="experiment_item">
											<div calss="experiment_item_index">第<?php echo $index;?>次数据</div>
											<div calss="experiment_item_yours">
											<?php 
												$your_result = explode("|", $stu_result);

												for($i=1;$i<=$temp["asks_nums"];$i++) {
													echo "<script>
														echarts_arr[".($i-1)."].push({$your_result[$i-1]});
													
													</script>";
													array_push($echarts[$i-1], $your_result[$i-1]);
													echo "<span>{$your_result[$i-1]} </span>"."   ";
												}
											?>
											</div>
										</div>
									<?php
								// }
											}
							}
							

						?>
						
					</div>

					<h3 class="experiment_title">数据曲线</h3>

					<p class="experiment_content">
					<canvas id="line" height="300" width="500"></canvas>
					<canvas id="radar" height="300" width="200"></canvas>
					</p>
				</div>
			</div>
		</div>
		<script>
		console.log(echarts_arr);
			//折线图绘制
		var lineChartData = {
			labels : ["1","2","3","4","5"],
			datasets : [
				{
					fillColor : "rgba(220,60,220,0.5)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					data : echarts_arr[0] ? echarts_arr[0] : []
				},
				{
					fillColor : "rgba(151,187,205,0.5)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					data : echarts_arr[1] ? echarts_arr[1] : []
				},
				{
					fillColor : "rgba(186,187,66,0.5)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					data : echarts_arr[2] ? echarts_arr[2] : []
				},
				{
					fillColor : "rgba(151,33,66,0.5)",
					strokeColor : "rgba(151,66,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					data : echarts_arr[3]? echarts_arr[3] : []
				},
				{
					fillColor : "rgba(151,166,66,0.5)",
					strokeColor : "rgba(99,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					data : echarts_arr[4]? echarts_arr[4] : []
				}
			]
			
		};


	new Chart(document.getElementById("line").getContext("2d")).Line(lineChartData);
	
	</script>
		<script language="javascript">
			// Change(00,20,00);
		</script>
	</form>
</body>
</html>

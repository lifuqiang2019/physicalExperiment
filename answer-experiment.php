<?php
session_start();
include_once 'includes/global.func.php';
include_once 'conn/conn.php';

$sd = $_SESSION['gesu'];
$aa = $_POST['submit0'];

for ($i = 0; $i < $sd; $i++) {
    if ($_POST['submit' . $i]) {
        $rrr = $_POST['submit' . $i];
    }
}

if ($rrr) {
    $_SESSION['rrr'] = $rrr;
}

$sql = "SELECT * FROM experiment where experiment_name='" . $_SESSION["rrr"] . "'";

$result = mysqli_query($conn, $sql);

$temp = mysqli_fetch_array($result);


$sql_search_check_top = "SELECT COUNT(*) FROM stu_experiment WHERE stu_name = '{$_SESSION['username']}' and experiment_name = '{$_SESSION["rrr"]}' and status='1';";
$result_search_check_top = mysqli_query($conn, $sql_search_check_top) or die('连接失败');

if ($size = mysqli_fetch_all($result_search_check_top)[0][0] > 0) {

    $_SESSION['status'] = 1;
} else {

    $_SESSION['status'] = 0;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $_SESSION["rrr"]; ?>实验中</title>
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

        function setFontsize(type, objname) {
            var oDiv = document.getElementById('wholepage_two');
            if (oDiv != null) {
                if (type == 1) {
                    if (initial_fontsize < 20) {
                        oDiv.style.fontSize = (++initial_fontsize) + 'px';
                    }
                    ;
                } else {
                    if (initial_fontsize > 12) {
                        oDiv.style.fontSize = (--initial_fontsize) + 'px';
                    }
                }
            }
        }
    </script>
</head>
<body>
<form action="answer-experiment.php?action=in" method="post">
    <div class="wholepage">
        <div class="logo">
            <div class="font-art">
                <a href="./startteam.php">
                    <span class="art"></span><span class="art_two">考试系统</span>
                </a>
            </div>
            <!-- 头像名字 -->
            <?php
            include('conn.php');
            $username = $_SESSION['username'];
            mysqli_select_db($conn, "topic");

            if (isset($_SESSION['username'])) {
                $sql = "SELECT * from users where username = '{$_SESSION['username']}'";
                $result = mysqli_query($conn, $sql) or die('连接失败');
                if ($html = mysqli_fetch_array($result)) {
                    $cores = 0;
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if ($_GET['action'] == "in") {
                            $experimentStandardArr = explode("|", $temp['standard_answer']);
                            $your_result = [$_POST['yours_1'], $_POST['yours_2'], $_POST['yours_3']];
                            $nums_item = round($temp['max_nums'] / $temp['asks_nums'], 2);
                            for ($i = 1; $i <= $temp["asks_nums"]; $i++) {
                                $item_standard = $experimentStandardArr[$i - 1];
                                $item_your = $your_result[$i - 1];

                                if ($item_your >= $item_standard * 0.96 && $item_your <= $item_standard) {
                                    $item_score = $nums_item;
                                } else if ($item_your >= $item_standard * 0.9 && $item_your <= $item_standard * 0.95) {
                                    $item_score = $nums_item * 0.9;
                                } else {
                                    $item_score = 0;
                                }

                                $cores += $item_score;
                            }

                            $result_str = "";
                            for ($i = 1; $i <= $temp['asks_nums']; $i++) {
                                if ($_POST['yours_' . $i]) {
                                    $result_str = $result_str . $_POST['yours_' . $i] . "|";
                                } else {
                                    echo "<script>alert('请输入完成数据');window.location.href='http://localhost/test/test1/answer-experiment.php';</script>";
                                    exit();
                                }
                            }
                            $result_str = substr($result_str, 0, strlen($result_str) - 1);
                            $sql_search_check = "SELECT * FROM stu_experiment WHERE stu_name = '{$_SESSION['username']}' and experiment_name = '{$_SESSION["rrr"]}';";
                            $result_search_check = mysqli_query($conn, $sql_search_check) or die('连接失败');
                            if (($len_check = sizeof(mysqli_fetch_all($result_search_check))) < 5) {
                                if ($len_check == 4) {
                                    $_SESSION['status'] = 1;
                                    $sql_result = "INSERT INTO `stu_experiment` (`zsname`, `status`, `experiment_id`, `experiment_name`, `experiment_standard`, `stu_id`, `stu_name`, `stu_result`, `cores`) VALUES
								('" . $_SESSION['reallyname'] . "','1'," . $temp['id'] . ", '" . $temp['experiment_name'] . "', '" . $temp['standard_answer'] . "', {$html['id']}, '" . $_SESSION['username'] . "', '" . $result_str . "', '" . $cores . "')";

                                } else {
                                    $_SESSION['status'] = 0;
                                    $sql_result = "INSERT INTO `stu_experiment` (`zsname`, `status`, `experiment_id`, `experiment_name`, `experiment_standard`, `stu_id`, `stu_name`, `stu_result`, `cores`) VALUES
								('" . $_SESSION['reallyname'] . "','0'," . $temp['id'] . ", '" . $temp['experiment_name'] . "', '" . $temp['standard_answer'] . "', 
								{$html['id']}, '" . $_SESSION['username'] . "', '" . $result_str . "', '" . $cores . "')";
                                }

                                $result_in = mysqli_query($conn, $sql_result) or die('连接失败');

                                if ($result_in) {
                                    echo "<script>alert('数据录入成功')</script>";
                                }

                            } else {

                                $_SESSION['status'] = 1;
                                echo "<script>alert('您已录入实验数据5次，实验结束')</script>";
                            }

                        }
                    }

                }
            } else {
                echo "<script>alert('请登录');history.go(-1);</script>";
            }
            ?>
            <div class="head_pic ">
                <img class="pic_logo" src="<?php echo $html['face'] ?>">
                <div class="pic_font"><?php echo $html['username'] ?> </div>
            </div>
        </div>
        <!-- 实验题目 -->
        <div id="wholepage_two">
            <div class="backg"></div>
            <div class="time">
                <div class="team_name">
                    <ul>
                        <li><span><?php echo $_SESSION["rrr"];
                                echo isset($_SESSION['status']) && $_SESSION['status'] == 1 ? "(已完成)" : ""; ?></span>
                        </li>
                        <li>
                            <div id="time_con"></div>
                        </li>
                    </ul>
                </div>
                <div class="submit_one">
                    <ul>
                        <li>
                            <div id="size">
                                <div id="jia"><input type="button" value="+" onclick="setFontsize(1,'Content')"></div>
                                <span style="float:left;font-weight: lighter;font-size:110%;">A</span>
                                <div id="jian"><input onclick="setFontsize(0,'Content')" type="button" value="-"></div>
                            </div>
                        </li>
                        <li>
                            <div id="enter"><a href="#" style="text-decoration:none;"><input type="submit" name="submit"
                                                                                             value="提交"></a></div>
                        </li>
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
                    for ($i = 1; $i <= $temp["asks_nums"]; $i++) {
                        echo "数据 $i <input type='text' name='yours_$i'/>" . "   ";
                    }
                    ?>
                </p>

                <h3 class="experiment_title">数据表格</h3>

                <div class="experiment_content" style="display: flex;justify-content: center;">
                    <?php
                    $sql_search = "SELECT * FROM stu_experiment WHERE stu_name = '{$_SESSION['username']}' and experiment_name = '{$_SESSION["rrr"]}';";

                    $result_search = mysqli_query($conn, $sql_search) or die('数据库链接失败');

                    if ($result_search) {

                        $index = 0;
                        echo "<script>var echarts_arr = [];";
                        $echarts = array();

                        for ($i = 0; $i < $temp['asks_nums']; $i++) {
                            array_push($echarts, []);
                            echo "echarts_arr.push([]);";
                        }
                        echo "</script>";

                        $nums_item = round($temp['max_nums'] / $temp['asks_nums'], 2);
                        $experimentStandardArr = explode("|", $temp['standard_answer']);
                        $scores = array();
                        $analysis = '';
                        $result_your_input = array();
                        // echo $nums_item;
                        // var_dump($experimentStandardArr);
                        // exit();
                        ?>
                        <div class="experiment_item">
                            <div class="experiment_item_index">
                                数据项次
                            </div>
                            <div class="experiment_item_yours">
                                您的数据
                            </div>
                            <?php
                            if ($_SESSION['status'] == 1) {
                                ?>
                                <div class="experiment_item_cores">
                                    数据项得分
                                </div>
                                <?php
                            };
                            ?>
                        </div>
                        <?php
                        while (list($id, $experiment_id, $experiment_name, $experiment_standard, $stu_id, $stu_name, $stu_result, $cores) = mysqli_fetch_row($result_search)) {

                            $index++;
                            ?>
                            <div class="experiment_item">
                                <div calss="experiment_item_index">第<?php echo $index; ?>次数据</div>
                                <div calss="experiment_item_yours">
                                    <?php
                                    $your_result = explode("|", $stu_result);
                                    array_push($result_your_input, $your_result);

                                    for ($i = 1; $i <= $temp["asks_nums"]; $i++) {
                                        echo "<script>echarts_arr[" . ($i - 1) . "].push({$your_result[$i-1]});</script>";
                                        array_push($echarts[$i - 1], $your_result[$i - 1]);
                                        echo "<span>{$your_result[$i-1]} </span>" . "   ";
                                    }
                                    ?>
                                </div>
                                <?php
                                if ($_SESSION['status'] == 1) {
                                    ?>
                                    <div class="experiment_item_cores">
                                        <?php
                                        $this_item_score = 0;
                                        for ($i = 1; $i <= $temp["asks_nums"]; $i++) {
                                            $item_standard = $experimentStandardArr[$i - 1];
                                            $item_your = $your_result[$i - 1];

                                            if ($item_your >= $item_standard * 0.96 && $item_your <= $item_standard) {
                                                $item_score = $nums_item;
                                            } else if ($item_your >= $item_standard * 0.9 && $item_your <= $item_standard * 0.95) {
                                                $item_score = $nums_item * 0.9;
                                            } else {
                                                $item_score = 0;
                                            }

                                            $this_item_score += $item_score;
                                            echo "<span>{$item_score}</span>" . "   ";
                                        }
                                        array_push($scores, $this_item_score);
                                        ?>
                                    </div>
                                <?php }; ?>
                            </div>
                            <?php
                        }
                        if ($_SESSION['status'] == 1) {
                            ?>
                            <div class="experiment_item">
                                <div class="experiment_item_index">
                                    标准答案
                                </div>
                                <div class="experiment_item_yours" style="margin-top: 9px;">
                                    <?php
                                    for ($i = 1; $i <= $temp["asks_nums"]; $i++) {
                                        echo "<span>{$experimentStandardArr[$i-1]} </span>" . "   ";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="experiment_item">
                                <div class="experiment_item_index">
                                    得分
                                </div>
                                <div class="experiment_item_yours" style="margin-top: 9px;">
                                    <?php
                                    echo max($scores);
                                    ?>
                                </div>
                            </div>
                            <?php
                        };
                    }
                    ?>

                </div>
                <?php
                if ($_SESSION['status'] == 1) {
                    ?>
                    <h3 class="experiment_title">误差分析</h3>

                    <div class="experiment_content" style="display: flex;height: 270px;">
                        <div style="height: 210px;padding: 30px 81px;border-right: 2px dotted #ccc;">
                            学生输入的数据在标准答案范围的：<br><br>
                            96% ~ 100% => 得分 100%,<br>
                            90% ~ 95% &nbsp;&nbsp;=> 得分 90%,<br>
                            其他 &emsp; &emsp;&emsp;&nbsp;&nbsp;&nbsp;=> 不得分
                        </div>
                        <div style="width: 57%;height: 300px;padding-left: 6px;padding-top: 66px;vertical-align: middle;">
                            <?php
                            $analyStr = '';

                            for ($i = 1; $i <= sizeof($result_your_input[$max_core - 1]); $i++) {
                                $item_standard = $experimentStandardArr[$i - 1];
                                $item_your_result = $result_your_input[$max_core - 1][$i - 1];
                                $nums_item9 = 0.9 * $nums_item;

                                if ($item_your_result >= $item_standard * 0.96 && $item_your_result <= $item_standard) {
                                    $analyStr .= "您输入的第{$i}项数据{$item_your_result}在标准数据{$item_standard},值的96%~100%之间,得分100%为 {$nums_item9}。";
                                    echo "<span>您输入的第{$i}项数据{$item_your_result}在标准数据{$item_standard},值的96%~100%之间,得分100%为 {$nums_item9}</span><br>";
                                } else if ($item_your_result >= $item_standard * 0.9 && $item_your_result <= $item_standard * 0.95) {
                                    $analyStr .= "您输入的第{$i}项数据{$item_your_result}在标准数据{$item_standard},值的90%~95%之间,得分90%为 {$nums_item9}。";
                                    echo "<span>您输入的第{$i}项数据{$item_your_result}在标准数据{$item_standard},值的90%~95%之间,得分90%为 {$nums_item9}</span><br>";
                                } else {
                                    $analyStr .= "您输入的第{$i}项数据{$item_your_result}在标准数据{$item_standard},值不在90%~100%之内,不得分为 0 。";
                                    echo "<span>您输入的第{$i}项数据{$item_your_result}在标准数据{$item_standard},值不在90%~100%之内,不得分为 0 </span><br>";
                                }
                            }

                            $sql_analy = "UPDATE stu_experiment SET error_analysis = '$analyStr' WHERE stu_name = '{$_SESSION['username']}' and experiment_name = '{$_SESSION["rrr"]}';";
                            // echo $sql_analy;
                            $result_search = mysqli_query($conn, $sql_analy) or die('数据库链接失败');
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <h3 class="experiment_title">数据曲线</h3>

                <div class="experiment_content">
                    <div style="margin: 0 auto; text-align: center;">
                        <canvas id="line" height="300" width="500"></canvas>
                        <!-- <canvas id="radar" height="300" width="200"></canvas> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        console.log(echarts_arr);
        //折线图绘制
        var lineChartData = {
            labels: ["1", "2", "3", "4", "5"],
            datasets: [
                {
                    fillColor: "rgba(220,60,220,0.5)",
                    strokeColor: "rgba(220,220,220,1)",
                    pointColor: "rgba(220,220,220,1)",
                    pointStrokeColor: "#fff",
                    data: echarts_arr[0] ? echarts_arr[0] : []
                },
                {
                    fillColor: "rgba(151,187,205,0.5)",
                    strokeColor: "rgba(151,187,205,1)",
                    pointColor: "rgba(151,187,205,1)",
                    pointStrokeColor: "#fff",
                    data: echarts_arr[1] ? echarts_arr[1] : []
                },
                {
                    fillColor: "rgba(186,187,66,0.5)",
                    strokeColor: "rgba(151,187,205,1)",
                    pointColor: "rgba(151,187,205,1)",
                    pointStrokeColor: "#fff",
                    data: echarts_arr[2] ? echarts_arr[2] : []
                },
                {
                    fillColor: "rgba(151,33,66,0.5)",
                    strokeColor: "rgba(151,66,205,1)",
                    pointColor: "rgba(151,187,205,1)",
                    pointStrokeColor: "#fff",
                    data: echarts_arr[3] ? echarts_arr[3] : []
                },
                {
                    fillColor: "rgba(151,166,66,0.5)",
                    strokeColor: "rgba(99,187,205,1)",
                    pointColor: "rgba(151,187,205,1)",
                    pointStrokeColor: "#fff",
                    data: echarts_arr[4] ? echarts_arr[4] : []
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

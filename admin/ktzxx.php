<?php
session_start();
include("conn.php");
include('cookie.php');
include('session2.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>考题信息管理</title>
    <link rel="stylesheet" type="text/css" href="css/add.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <style>
        .scroll_hidden {
            width: 108%;
            margin: -18% -27%;
            overflow-x: hidden;
        }

        .table_container {
            height: 600px;
            /* margin: -12% -33%; */
            width: 93%;
            padding: 27px;
            overflow-y: auto;
            overflow-x: auto;
        }

        .table {
            margin: 0;
        }
    </style>
    <script type="text/javascript">
        function del() {

            var msg = confirm("你确定删除此记录吗？");

            if (msg == true) {

                return true;

            } else {

                return false;

            }

        }
    </script>
</head>
<body>


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
        if ($_SESSION['name'] == "") {
            echo "<script>alert('请登陆');history.go(-1);</script>";
        }
        if (isset($_SESSION['name']) && isset($_SESSION['type']) && $_SESSION['type'] == '1') {
            echo "<li>管理员 " . $_SESSION['name'] . "</li>";
        } else if (isset($_SESSION['name']) && isset($_SESSION['type']) && $_SESSION['type'] == '0') {
            echo "<li>老师 " . $_SESSION['name'] . "</li>";
        } else {
            echo '<li><a href="adlogin/login.php">管理员登录</li>';
        }
        ?>
        <?php
        error_reporting(E_ALL || ~E_NOTICE);
        if (isset($_SESSION['name'])) {
            echo "<li><a href='adlogin/logout.php'>退出</a></li>";
        }
        ?>

    </ul>
</div>
<?php include('./left.php') ?>


<div class="main">

    <form name="form1" action="ktxx.php" method="post">


        <?php
        include('../conn/conn.php');

        $sql = "SELECT a.reallyname,a.testname,a.report,b.experiment_name,b.stu_name,b.cores FROM report AS a,(SELECT MAX(cores) AS cores,stu_name,experiment_name FROM `stu_experiment` GROUP BY stu_name,experiment_name) AS b ";
        $result = mysqli_query($conn, $sql) ;
        $rows = array();
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        ?>
        <div class="scroll_hidden">
            <div class="table_container">
                <?php
                echo '<table border="1" align="center" class="table" style="width: 100%;">';
                echo '<br>';
                echo '<caption class="h1"><h1>考试总成绩</h1></caption>';
                echo '<br>';
                echo '<tr>';
                echo '<th>真实姓名</th>';
                echo '<th>学号</th>';
                echo '<th>实验名称</th>';
                echo '<th>实验成绩</th>';
                echo '<th>考试名称</th>';
                echo '<th>考试成绩</th>';
                echo '<th>总成绩</th>';
                echo '</tr>';
                foreach ($rows as $array) {
                    $result = $array['cores'] * 0.4 + $array['report'] * 0.6;
                    echo '<tr>';
                    echo "<td align='center'>{$array['reallyname']}</td>";
                    echo "<td align='center'>{$array['stu_name']}</td>";
                    echo "<td align='center'>{$array['experiment_name']}</td>";
                    echo "<td align='center'>{$array['cores']}</td>";
                    echo "<td align='center'>{$array['testname']}</td>";
                    echo "<td align='center'>{$array['report']}</td>";
                    echo "<td align='center'>{$result}</td>";
                    echo '</tr>';
                }
                ?>
            </div>
        </div>
    </form>


    <form name="form1" action="modify.php" method="post">


    </form>

</div>

<div class="fenye">


</div>

</body>
</html>

<?php 
include('heade.php');
session_start();
?>
        <div class="content">
      
            <div id="my_sc" class="hide a">
                <ul>
                    <?php
                    include ("includes/page.class.php");
                    $cookie=$html['username'];
                    $sql = "SELECT a.reallyname,a.testname,a.report,b.experiment_name,b.stu_name,b.cores FROM report AS a,(SELECT MAX(cores) AS cores,stu_name,experiment_name FROM `stu_experiment` WHERE stu_name='{$_SESSION['username']}' GROUP BY stu_name,experiment_name) AS b WHERE RIGHT(a.testname,1)=RIGHT(b.experiment_name,1) and a.stunum=b.stu_name ";


                    $result = mysqli_query($conn, $sql) ;
                    $rows = array();
                    while($row = mysqli_fetch_array($result)) {
                        $rows[] = $row;
                    }

                    ?>

                    <div class="table_container" style="background: #fff">
                        <?php
                        echo '<table border="1" align="center" class="table" style="width: 100%;">';
                        echo '<br>';
                        echo '<br>';
                        echo '<tr>';
                        echo '<th>实验名称</th>';
                        echo '<th>实验成绩</th>';
                        echo '<th>考试名称</th>';
                        echo '<th>考试成绩</th>';
                        echo '<th>总成绩</th>';
                        echo '</tr>';
                        foreach ($rows as $array) {
                            $result = $array['cores'] * 0.4 + $array['report'] * 0.6;
                            echo '<tr>';
                            echo "<td align='center'>{$array['experiment_name']}</td>";
                            echo "<td align='center'>{$array['cores']}</td>";
                            echo "<td align='center'>{$array['testname']}</td>";
                            echo "<td align='center'>{$array['report']}</td>";
                            echo "<td align='center'>{$result}</td>";
                            echo '</tr>';
                        }
                        ?>
                    </div>
                </ul>

                <div class="fenye">
                    <?php
                    // echo '<form action="shoucang.php?action=del&page='.$page->page.'">';
                    // echo '<table border="0" width="900">';
                    // echo '<tr><td colspan="9" align="left" >'.$page->fpage().'</td></tr>';
                    // echo '</table>';
                    // echo '</form>';
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
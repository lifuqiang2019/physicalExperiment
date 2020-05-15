<div class="left">
    <dt class="#">管理中心</dt>
    <?php echo isset($_SESSION['type']) && $_SESSION['type']=='1' ?  
        '<dd><a href="member.php">学生信息管理</a></dd>' : null ;?>
    <?php echo isset($_SESSION['type']) && $_SESSION['type']=='1' ?  
        '<dd><a href="add.php">考题信息添加</a></dd>' : null ;?>
        
        <dd><a href="ktlb.php">考试类别管理</a></dd>
    <?php echo isset($_SESSION['type']) && $_SESSION['type']=='1' ?  
        '<dd><a href="add_experiment.php">实验信息添加</a></dd>' : null ;?>  
        <dd><a href="show_experiment.php">实验类别管理</a></dd>
        <dd><a href="cores_experiment.php">考生实验成绩</a></dd>
        <dd><a href="ktxx.php">考生考试成绩</a></dd>
        <dd><a href="ktzxx.php">考生总成绩</a></dd>
</div>
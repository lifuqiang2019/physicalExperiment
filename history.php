<?php include('heade.php')?>
        <div class="content">
            <div id="history" class="hide a">
                
                <ul>
                <?php
                    include ("includes/page.class.php");
                    $cookie=$html['username'];
                    $query200 = mysqli_query($conn,"select * from transfer where kt_user='$cookie'");
                    
                    $total = mysqli_num_rows($query200);

                    //echo $total;
                    //echo "+++++";
                    $i=1;
                    //创建分页对象    
                    $num=5;
                    $page=new Page($total,$num);

                    $query = mysqli_query($conn,"select * from transfer where kt_user='$cookie' order by id asc {$page->limit}");
                    //$array = mysqli_fetch_array($query);
                    //echo "select * from transfer {$page->limit}";
                     
                    $x=0;
                    while ($array = mysqli_fetch_array($query)) {

                    $query1 = mysqli_query($conn,"select * from topic where id=$array[kt_id]");
                    //echo $array[kt_id];
                    //echo $array[ks_da];
                    $array1 = mysqli_fetch_array($query1);
                    if($array1["ks_nr"]!=""){
                     
                ?>
                
                    <li>
                        <span style="display:block;width:100%;height:40px;position: relative;top:0px;background:rgb(120,170,240);"><?php echo $i.".".$array1["ks_nr"]; ?></span>
                    <div style="background:white;padding:10px 0px;opacity:0.8;">
                    <?php
                        $array2=explode("*",$array1["kq_da"]);
                        for($a=0;$a<count($array2);$a++){
                            if($array2[$a]!=""){
                                if(trim($array2[$a])==$array1[zq_da]){

                    ?> 
                   
                        <span style="display:block;background:rgba(120,170,240,0.6);width:96.3%;border-radius:5px;padding:0px 20px;"><?php echo $array2[$a]; echo "(正确答案)";?></span>
                        
                    <?php
                                }else{
                    ?>
                        <span style="margin-left:20px;"><?php echo $array2[$a]; ?></span><br/>
                    <?php       
                            }
                            }
                        }
                    ?>
                    </div>
                    <div style="width:100%;background:rgba(120,170,240,0.5);">
                        <span  style="margin-left:20px">考生答案：</span><span ><?php echo $array["ks_da"]; ?></span><br/>
                        <span  style="margin-left:20px;">答案解析：<?php echo $array1["kt_jx"]; ?></span>
                    </div>
                    </li>
                
                <?php
                    }
                    $i++;
                    $x++;
                    }
                ?>
                </ul>
                <div class="fenye">
                <?php
                echo '<form action="history.php?action=del&page='.$page->page.'">';
                echo '<table border="0" width="900">';
                echo '<tr><td colspan="9" align="left" >'.$page->fpage().'</td></tr>';
                echo '</table>';
                echo '</form>';
                ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
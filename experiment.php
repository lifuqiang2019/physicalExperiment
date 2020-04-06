<?php include('heade.php')?>
        <div class="content">
            <div id="team" >
              <form action="answer-experiment.php" method="post">
                <ul class="list_top">
                    <?php 
                    $r=0;
                    while ($ww3[$r]) {  

                    ?>
                    <li style="width: 300px;"><input  style="width: 100%;"
                     type="submit" name=<?php echo"submit".$r;?> value=<?php echo $ww3[$r];?>  class="team_o">                                           
                    </span></li>
                    <?php
                    $r++;
                    }?>
                </ul>
                <ul class="list_bottom">
                    
                </ul>
              </form>
            </div>
    </div>
</body>     
</html>


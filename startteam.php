<?php include('heade.php')?>
        <div class="content">
            <div id="team" >
              <form action="answer.php" method="post">
                <ul class="list_top">
                    <?php 
                    $r=0;
                    while ($ww[$r]) {  

                    ?>
                    <li><input   type="submit" name=<?php echo "submit".$r;?> value=<?php echo $ww[$r];?>  class="team_o">                                           
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


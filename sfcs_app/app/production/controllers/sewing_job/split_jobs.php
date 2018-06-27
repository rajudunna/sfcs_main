<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    $has_permission=haspermission($_GET['r']);
    include(getFullURLLevel($_GET['r'],'common/config/header_scripts.php',2,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/menu_content.php',2,'R'));
?> 

<div class="panel panel-primary">
    <div class="panel-heading">Sewing Jobs Split</div>
    <div class="panel-body">

        <?php 
            // include("menu_content.php"); 
            $i = 0;
            $schedule=$_GET['sch']; 
            $job_no=$_GET['job']; 
             $url_s = getFullURLLevel($_GET['r'],'input_job_split.php',0,'N');
            //echo $schedule.' '.$job_no; 
            echo '<h4><b>Schedule : <a href="#" class="btn btn-success">'.$schedule.'</a></b></h4>'; 
            echo '<a href="'.$url_s.'" class="btn btn-primary pull-right">Click here to go Back</a>'; 
            echo '<h4><b>Sewing Job No : <a href="#" class="btn btn-warning">'.$job_no.'</a></b></h4><hr>';
            $sql="SELECT *, UPPER(size_code) as size_code FROM $bai_pro3.packing_summary_input where order_del_no='$schedule' AND input_job_no='$job_no'"; 
            $result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        ?> 
        <table class='table table-bordered table-striped'> 
            <tr><th>Style</th><th>Schedule</th><th>Color</th><th>Size</th><th>Job No</th><th>Total Job Qty</th><th>Enter Qty to be Split</th><th></th></tr> 
            <?php 
                while($row=mysqli_fetch_array($result)){ 
                $i++;
                $input_job_no_random=$row['input_job_no_random']; 
                $style=$row['order_style_no']; 
                $schedule=$row['order_del_no']; 
                $color=$row['order_col_des']; 
                $size=$row['size_code']; 
                $qty=$row['carton_act_qty']; 
                $tid=$row['tid']; 
                echo '<form action='.getFullURLLevel($_GET['r'],'split_success.php',0,'N').' method="post">'; 
                echo "<input type='hidden' name='tid' value='$tid'>"; 
                echo "<input type='hidden' id='qty$i' value='$qty'>";
                echo '<tr><td>'.$style.'</td><td>'.$schedule.'</td><td>'.$color.'</td><td>'.$size.'</td><td>'.$job_no.'</td><td>'.$qty."</td>
                        <td><input type='text' width='20' name='qty' id='$i' onkeyup='verify_split(this)' class='integer form-control'></td>
                        <td><input type='submit' width='20' name='submit' class='btn btn-primary' value='Split'></td>
                      </tr>"; 
                echo '</form>'; 
                } 
            ?> 
        </table> 
    </div>
</div>
    <script>
        function verify_split(t){
            var id = t.id;
            var st_id = 'qty'+id;
            var ent = document.getElementById(id).value;
            var qty = document.getElementById(st_id).value;
            if(Number(ent) >= Number(qty) ){
                sweetAlert('Error','The quantity to be splitted is more than Total Job Quantity','warning');
                document.getElementById(id).value = 0;
            }
        }
    </script>
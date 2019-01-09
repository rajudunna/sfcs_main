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
            $job_no_ran=$_GET['rand_no']; 
            $url_s = getFullURLLevel($_GET['r'],'input_job_split.php',0,'N');
            //echo $schedule.' '.$job_no; 
            echo '<h4><b>Schedule : <a href="#" class="btn btn-success">'.$schedule.'</a></b></h4>'; 
            echo '<a href="'.$url_s.'&schedule='.$schedule.'" class="btn btn-primary pull-right">Click here to go Back</a>'; 
			$sql1="SELECT * FROM $bai_pro3.plan_dashboard_input where input_job_no_random_ref='$job_no_ran'"; 
            $result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql2="SELECT * FROM $bai_pro3.ims_combine where input_job_rand_no_ref='$job_no_ran'"; 
            $result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($result1)==0 && mysqli_num_rows($result2)==0)
			{				
				echo '<h4><b>Sewing Job No : <a href="#" class="btn btn-warning">'.$job_no.'</a></b></h4><hr>';
				$sql="SELECT *, UPPER(size_code) as size_code FROM $bai_pro3.packing_summary_input where order_del_no='$schedule' AND input_job_no='$job_no' order by input_job_no*1"; 
				$result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				echo '<form action='.getFullURLLevel($_GET['r'],'split_success.php',0,'N').' method="post" onsubmit="return verify_qty()">'; 
				echo "<table class='table table-bordered table-striped'> 
                <tr><th>Style</th><th>Schedule</th><th>Color</th><th>Size</th><th>Job No</th><th>Total Job Qty</th><th>Enter Qty to be Split</th><th><input type='submit' width='20' name='submit' id='split_btn' class='btn btn-primary' value='Split'></th></tr> ";
                while($row=mysqli_fetch_array($result))
                { 
                    $i++;
                    $input_job_no_random=$row['input_job_no_random']; 
                    $input_job_no=$row['input_job_no']; 
                    $style=$row['order_style_no']; 
                    $schedule=$row['order_del_no']; 
                    $color=$row['order_col_des']; 
                    $size=$row['size_code']; 
                    $qty=$row['carton_act_qty']; 
                    $tid=$row['tid'];
                    $display = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$job_no,$link);

                    //echo '<form action='.getFullURLLevel($_GET['r'],'split_success.php',0,'N').' method="post">'; 
                    echo "<input type='hidden' name='tid[]' value='$tid'>"; 
                    echo "<input type='hidden' name='input_job_no_random' value='$input_job_no_random'>"; 
                    echo "<input type='hidden' name='input_job_no' value='$input_job_no'>"; 
                    echo "<input type='hidden' id='qty$i' value='$qty'>";
                    echo '<tr><td>'.$style.'</td><td>'.$schedule.'</td><td>'.$color.'</td><td>'.$size.'</td><td>'.$display.'</td><td>'.$qty."</td><td><input type='text' width='20' name='qty[]' id='$i' onkeyup='verify_split(this)' class='integer form-control'></td></tr>"; 
                    //echo '</form>'; 
                } 
				echo "<input type='hidden' id='total' value='$i'>";
                echo '</form>';
			}
			else
			{
				 echo "<script>sweetAlert('Error','Input job is planned or input Updated.','warning');</script>";
				 $url_s=getFullURL($_GET['r'],'input_job_split.php','N');
					echo "<script> 
                    setTimeout('Redirect()',1000); 
                    function Redirect() {  
                        location.href = '$url_s'; 
                    }
                </script>"; 
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
            if(Number(ent) > Number(qty) ){
                sweetAlert('Error','The quantity to be splitted is more than Total Job Quantity','warning');
                document.getElementById(id).value = 0;
            }
        }
		function verify_qty()
		{           
			var tot = Number(document.getElementById('total').value);
			var n=0;
			for(var j=1;j<=tot;j++)
			{
				n=n+Number(document.getElementById(j).value);
			}
			if(n>0)
			{
				return true;
			}
			else
			{
				 sweetAlert('Error','Please update the quantity for any Bundle','warning');
				 return false;
			}	
		}
    </script>
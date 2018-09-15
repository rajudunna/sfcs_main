<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    $has_permission=haspermission($_GET['r']);
    include(getFullURLLevel($_GET['r'],'common/config/header_scripts.php',2,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/menu_content.php',2,'R'));
?> 

<div class="panel panel-primary">
    <div class="panel-heading">Carton Split</div>
    <div class="panel-body">

        <?php 
            // include("menu_content.php"); 
            $i = 0;
            $schedule=$_GET['schedule']; 
            $carton_no=$_GET['cartonno']; 
            $seq_no=$_GET['seq_no']; 
			$style=$_GET['style'];
			$packmethod=$_GET['packmethod'];
			
            $url_s = getFullURLLevel($_GET['r'],'carton_split.php',0,'N');
            //echo $schedule.' '.$job_no; 
            echo '<h4><b>Schedule : <a class="btn btn-success">'.$schedule.'</a></b></h4>'; 
            echo '<a href="'.$url_s.'&schedule='.$schedule.'&style='.$style.'" class="btn btn-primary pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;&nbsp;Click here to go Back</a>'; 
			
            $sql2="SELECT carton_qty FROM $bai_pro3.pac_stat WHERE schedule='$schedule' AND carton_no = '$carton_no' AND pac_seq_no = '$seq_no'";
            // echo $sql2.'<br>';
			// $sql2="SELECT carton_act_qty FROM $bai_pro3.pac_stat_log where schedule='$schedule' AND carton_no='$carton_no' AND style='$style' AND pack_method='$packmethod'"; 
            $result2=mysqli_query($link, $sql2) or exit("Sql Error1 ".mysqli_error($GLOBALS["___mysqli_ston"]));
			if($cartqty=mysqli_fetch_array($result2))
			{
				$cartq=$cartqty['carton_qty'];
			}

			if($cartq>0)
			{				
				echo '<h4><b>Carton No : <a class="btn btn-warning">'.$carton_no.'</a></b></h4>';
				echo '<h4><b>Pack Method : <a class="btn btn-warning">'.$operation[$packmethod].'</a></b></h4><hr>';
                // $sql="SELECT tid,style,schedule,color,size_tit,carton_no,carton_act_qty,pac_seq_no FROM bai_pro3.`pac_stat_log` WHERE schedule='$schedule' AND carton_no='$carton_no' AND style='$style' AND pack_method='$packmethod'";
				$sql="SELECT psl.tid,ps.style,ps.schedule,psl.color,psl.size_tit,ps.carton_no,psl.carton_act_qty 
                        FROM $bai_pro3.`pac_stat_log` psl LEFT JOIN $bai_pro3.`pac_stat` ps ON ps.`id`=psl.`pac_stat_id`
                        WHERE ps.schedule='$schedule' AND ps.pac_seq_no='$seq_no' AND ps.carton_no='$carton_no'";
                // echo $sql;
				$result=mysqli_query($link, $sql) or exit("Sql Error2 ".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				echo '<form action='.getFullURLLevel($_GET['r'],'split_success.php',0,'N').' method="post" onsubmit="return verify_qty()">'; 
				echo "<table class='table table-bordered table-striped'> 
                <tr class='info'><th>Style</th><th>Schedule</th><th>Color</th><th>Size</th><th>Carton No</th><th>Quantity</th><th>Enter Qty to be Split</th><th><input type='submit' width='20' name='submit' id='split_btn' class='btn btn-primary' value='Split'></th></tr> ";
                while($row=mysqli_fetch_array($result))
                { 
                    $i++;
                    $style=$row['style']; 
                    $schedule=$row['schedule']; 
                    $color=$row['color']; 
                    $size=$row['size_tit']; 
                    $cartonno=$row['carton_no']; 
                    $qty=$row['carton_act_qty']; 
					$seqno=$row['pac_seq_no']; 
					$tid=$row['tid'];
                    // $display = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$job_no,$link);

                    //echo '<form action='.getFullURLLevel($_GET['r'],'split_success.php',0,'N').' method="post">'; 
                    echo "<input type='hidden' name='tid[]' value='$tid'>";
					echo "<input type='hidden' name='style' value='$style'>";
					echo "<input type='hidden' name='schedule' value='$schedule'>";
                    echo "<input type='hidden' name='cartonno' value='$cartonno'>"; 
                    echo "<input type='hidden' name='pack_method' value='$packmethod'>"; 
                    echo "<input type='hidden' id='qty$i' value='$qty'>";
                    echo '<tr><td>'.$style.'</td><td>'.$schedule.'</td><td>'.$color.'</td><td>'.$size.'</td><td>'.$cartonno.'</td><td>'.$qty."</td><td><input type='text' width='20' name='qty[]' id='$i' onkeyup='verify_split(this)' class='integer form-control'></td></tr>"; 
                    //echo '</form>'; 
                } 
				echo "<input type='hidden' id='total' value='$i'>";
                echo '</form>';
			}
			else
			{
				 echo "<script>sweetAlert('Carton Qty is Zero','','warning');</script>";
				 $url_s=getFullURL($_GET['r'],'carton_split.php','N');
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
				 sweetAlert('Error','Please update the quantity for any Carton','warning');
				 return false;
			}	
		}
    </script>
<?php

include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions_dashboard.php");

echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />';

if ($_GET['style']) {
	$style=style_decode($_GET['style']);
	$schedule=$_GET['schedule'];
	$color=color_decode($_GET['color']);
}


?>

<script>


function firstbox()
{
	window.location.href ="<?= 'index.php?r='.$_GET['r']; ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))
}

function secondbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))+"&schedule="+document.test.schedule.value;
	window.location.href = uriVal;
}

function thirdbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))+"&schedule="+document.test.schedule.value+"&color="+window.btoa(unescape(encodeURIComponent(document.test.color.value)));
	window.location.href = uriVal;
}
$(document).ready(function() {
	$('#schedule').on('click',function(e){
		var style = $('#style').val();
		if(style == ''){
			sweetAlert('Please Select Style','','warning');
		}
	});
	$('#color').on('click',function(e){
		var style = $('#style').val();
		var schedule = $('#schedule').val();
		if(style == '' && schedule == ''){
			sweetAlert('Please Select Style and Schedule','','warning');
		}
		else if(schedule == ''){
			sweetAlert('Please Select Schedule','','warning');
			document.getElementById("submit").disabled = true;
		}
		else {
			document.getElementById("submit").disabled = false;
		}
	});
});

</script>
<body >
	<div class="container-fluid">
		<div class="panel panel-primary">
			<div class="panel-heading">Wrong Order Details</div>
			<div class="panel-body">
				<div class='row'>
					<div class="form-inline col-sm-10">
						<?php	echo "<form name=\"test\" action=\"?r=".$_GET["r"]."\" class=\"form-inline\" method=\"post\" >";?>

							<label><font size="2">Style: </font></label>
							<select  name="style" class="form-control" id="style" onchange="firstbox();" required>
								<option value="">Select Style</option>

								<?php
								$get_style="select distinct order_style_no from bai_orders_db";
								$result1 = $link->query($get_style);
		                        while($sql_row = $result1->fetch_assoc())
		                       {

									if( trim($sql_row['order_style_no'])==trim($style))
									{
									    echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
									}
									else
									{
										 echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
									}

								}

								?>
							</select>
							
							<label><font size="2">Schedule: </font></label>
							<select  name="schedule" class="form-control"  id="schedule" onchange="secondbox();" required>
		                     	<option value="">Select Schedule</option>
		                     	<?php
		                     	$get_schedule="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style\"";	
	                            $result2 = $link->query($get_schedule);
		                        while($sql_row = $result2->fetch_assoc())               
								{
									if( trim($sql_row['order_del_no'])==trim($schedule))
									{
											echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
									}
									else
									{
										echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
									}
								}
	                            ?>
							</select>

							<label><font size="2">Color: </font></label>
							<select  name="color" class="form-control"  id="color" required>
		                     	<option value="">Select Color</option>
		                     	<?php
		                     	$get_color="select distinct order_col_des from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_joins<'4'";
	                            $result3 = $link->query($get_color);
		                        while($sql_row = $result3->fetch_assoc())
								{
									if(trim($sql_row['order_col_des'])==trim($color))
									{
										echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
									}else
									{
										echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
									}
								}
	                            ?>
							</select>
	               
					        <input type="submit"  class="btn btn-success" value="Delete" name="submit" id="submit">
					    </form>
					</div>
				</div>
				<?php
					if (isset($_POST['submit']))
					{
						$schdule=$_POST['schedule'];
						$style=$_POST['style'];
						$color=$_POST['color'];
						// $order_tid = echo_title("$bai_pro3.bai_orders_db","order_del_no = $schdule and order_style_no = $style and order_col_des",$color,$link);

                        
                        $get_orderid="select * from $bai_pro3.bai_orders_db where order_del_no = '$schdule' and order_style_no = '$style' and order_col_des = '$color'";
                        $result5 = $link->query($get_orderid);
                        while($row1 = $result5->fetch_assoc())
                        {
                               $order_tid = $row1['order_tid'];
                        }

						$check_layplan="select * from $bai_pro3.plandoc_stat_log where order_tid = '$order_tid'";
						$result4 = $link->query($check_layplan);
                        if(mysqli_num_rows($result4) > 0)
                        {
						 echo "<script>swal('','Already Lay-Plan Genereated','warning') </script>";
                        }
                        else
                        {
	                        //To get Mo's
	                        $mo=array();
	                        $get_mos="select monumber from $m3_inputs.mo_details where style='$style' and schedule='$schdule' and colourdesc='$color'";
	                        //echo $get_mos;
	                        $result6 = $link->query($get_mos);
	                        while($row2 = $result6->fetch_assoc())
	                        {
	                            $mo[] = $row2['monumber'];
	                        }
	                        	
	                        // $mos = implode(",", $mo);
	                        $del_bom_details="DELETE FROM $m3_inputs.bom_details where mo_no in('".implode("','",$mo)."')";
	                        $result7 = $link->query($del_bom_details);

	                        $del_order_details="DELETE FROM $m3_inputs.order_details WHERE style='$style' AND SCHEDULE='$schdule' AND GMT_Color='$color'";
	                        $result8 = $link->query($del_order_details);
	                       

	                        $del_shipment_plan="DELETE FROM $m3_inputs.shipment_plan WHERE style_no='$style' AND schedule_no='$schdule' AND colour='$color'";
	                        $result9 = $link->query($del_shipment_plan);
	                         
	                        $del_m3_mo_details="DELETE FROM $m3_inputs.mo_details WHERE style='$style' and schedule='$schdule' and colourdesc='$color'";
	                        $result10 = $link->query($del_m3_mo_details);
							
							$del_order_original="DELETE FROM $m3_inputs.order_details_original WHERE style='$style' AND SCHEDULE='$schdule' AND GMT_color='$color'";
							$result17 = $link->query($del_order_original);
							

                            $del_shipment_original="DELETE FROM $m3_inputs.shipment_plan_original WHERE style_no='$style' AND schedule_no='$schdule' AND colour='$color'";
							$result18 = $link->query($del_shipment_original);
							

	                        $del_mo_details="DELETE FROM $bai_pro3.mo_details where style='$style' and schedule='$schdule' and color='$color'";
	                        $result11 = $link->query($del_mo_details);

	                        $del_bai_orders="DELETE FROM $bai_pro3.bai_orders_db WHERE order_style_no='$style' AND order_del_no='$schdule' AND order_col_des='$color'";
	                        $result12 = $link->query($del_bai_orders);
	                        

	                        $del_bai_orders_confirm="DELETE FROM $bai_pro3.bai_orders_db_confirm WHERE order_style_no='$style' AND order_del_no='$schdule' AND order_col_des='$color'";
	                        $result13 = $link->query($del_bai_orders_confirm);
	                     

	                        $del_cat_stat_log ="DELETE FROM $bai_pro3.cat_stat_log WHERE order_tid = '$order_tid'";
	                        $result14 = $link->query($del_cat_stat_log);

	                        $del_schedule_operation="DELETE FROM $bai_pro3.schedule_oprations_master WHERE Style='$style' AND Description ='$color' AND ScheduleNumber='$schdule'";  
							$result15 = $link->query($del_schedule_operation);

							$user1=getrbac_user()['uname'];
	                        $delete_track="insert into $brandix_bts.delete_log (user,style,schedule,color) values('$user1','$style','$schdule','$color')";
	                        $result16 = $link->query($delete_track);
							
							$bai_orders_confirm="SELECT * FROM $bai_pro3.bai_orders_db_confirm WHERE order_style_no='$style' AND order_col_des='$color' ";
							$result18 = $link->query($bai_orders_confirm);

							if(mysqli_num_rows($result18) > 0)
							{
								// var_dump($result18);
								echo "<script>swal('','Except style operation masters All records Deleted Successfully','warning') </script>";

							}
							else
							{
								$tbl_style_ops_master="DELETE FROM $brandix_bts.tbl_style_ops_master WHERE Style='$style' AND color ='$color'";  
								$result17 = $link->query($tbl_style_ops_master);
								echo "<script>swal('','Records Deleted Successfully','warning') </script>";
							}

	                        
	                         
                        }	
					}
				?>
			</div>
		</div>
	</div>
		
</body>


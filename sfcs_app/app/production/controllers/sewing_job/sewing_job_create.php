
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- <script type="text/javascript" src="js/jquery.min.js"></script> -->
<!-- <script type="text/javascript" src="js/datetimepicker_css.js"></script> -->
<!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
<!-- <link rel="stylesheet" type="text/css" href="table.css"> -->
<?php
	if($_GET['msg']==1){
		echo "<script>sweetAlert('Sewing Job Not Generated ! There are No Size Codes for the Selected Style and Schedule','','info');</script>";
	}
?>
<style type="text/css">
#div-1a {
 position:absolute;
 top:65px;
 right:0;
 width:auto;
float:right;
table {
    float:left;
    width:33%;
}
</style>
<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
/* @import "TableFilter_EN/filtergrid.css"; */

/*====================================================
	- General html elements
=====================================================*/
/* body{ 
	/* margin:15px; padding:15px; border:1px solid #666; */
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
} */
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px;  padding:5px; background-color:#f4f4f4; solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; outset #f4f4f4; margin:2px; }
.mytable th{ background-color:#29759c; color:#FFF; padding:2px; solid #ccc; white-space: nowrap;}
td{ padding:2px; white-space: nowrap;}
</style>
<!-- <script language="javascript" type="text/javascript" src="TableFilter_EN/actb.js"></script>External script -->
<!-- <script language="javascript" type="text/javascript" src="TableFilter_EN/tablefilter.js"></script> -->



<script language="javascript" type="text/javascript">
	
	var url1 = '<?= getFullURL($_GET['r'],'sewing_job_create.php','N'); ?>';
	function myFunction() {
		document.getElementById("generate").style.visibility = "hidden";
	}

	function firstbox()
	{
		//alert("report");
		window.location.href =url1+"&style="+document.mini_order_report.style.value
	}

	function secondbox()
	{
		//alert('test');
		window.location.href =url1+"&style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
	}

	function tot_sum()
	{

	}
	function check_val()
	{
		//alert('dfsds');
		var style=document.getElementById("style").value;
		var schedule=document.getElementById("schedule").value;
		
		if(style == 'NIL' || schedule == 'NIL')
		{
			sweetAlert('Please select the values','','warning');
			// document.getElementById('submit').style.display=''
			// document.getElementById('msg').style.display='none';
			return false;
		}
		return true;	
	}
	function check_val1()
	{
		var cart_method=document.getElementById("cart_method").value;
		var bundle_size=document.getElementById("bundle_plies").value;
		var bundle_per_size=document.getElementById("bundle_per_size").value;
		var mini_order_qty=document.getElementById("mini_order_qty").value;
		if(cart_method=="0")
		{
			sweetAlert('Please Select Carton Method','','warning');
			document.getElementById('msg1').style.display='none';
			document.getElementById('generate').style.display='';
			return false;
		}
		else 
		{
			if(bundle_size>=1 && mini_order_qty>=1)
			{
				//alert('Ok');
			}
			else
			{
				sweetAlert('Please Check the values','','warning');
				document.getElementById('generate').style.display='';
				document.getElementById('msg1').style.display='none';
				return false;
			}
			
			if(confirm("Sewing Order Quantity :"+mini_order_qty+"\nAre you Sure to continue with this Sewing Order Quantity???") == true )
			{
				return true;	
			}
			else
			{
				//alert("No");
				document.getElementById('msg1').style.display='none';
				document.getElementById('generate').style.display='';
				return false;
			}
		}
	}
	
	
	function openWin() {
		//window.open("http://baidevsrv1:8080/projects/beta/bundle_tracking_system/brandix_bts/mini_order_report/bundle_alloc_save.php");
	}
	function validate()
	{
		//alert("test");
		var bundle_plies=document.getElementById("bundle_plies").value;
		var bundle_per_size=document.getElementById("bundle_per_size").value;
		var carton_qty=document.getElementById("carton_qty").value;
		mini_order_qty=document.getElementById("mini_order_qty").value=bundle_plies*bundle_per_size*carton_qty;
	}
	function validateQty(event) 
	{


		event = (event) ? event : window.event;
		var charCode = (event.which) ? event.which : event.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	};

	$(document).ready(function(){
		$('#generate').on('click',function(event, redirect=true){
			var cart_method  = document.getElementById("cart_method").value;
			var bundle_size  = document.getElementById("bundle_plies").value;
			var bundle_per_size = document.getElementById("bundle_per_size").value;
			var mini_order_qty  = document.getElementById("mini_order_qty").value;
			if(cart_method=="0")
			{
				sweetAlert('Please Select Carton Method','','warning');
				document.getElementById('msg1').style.display='none';
				document.getElementById('generate').style.display='';
				return false;
			}else {
				if(bundle_size>=1 && mini_order_qty>=1)
				{
					
				}else{
					sweetAlert('Please Check the values','','warning');
					document.getElementById('generate').style.display='';
					document.getElementById('msg1').style.display='none';
					return false;
				}
			}

			if(redirect != false){
				event.preventDefault();
				submit_form($(this));
			}
		});

		function submit_form(submit_btn){
			var qty = $('#mini_order_qty').val();
			sweetAlert({
				title: "Sewing Order Quantity: "+qty,
				text: "Are you sure to continue with this Quantity?",
				icon: "warning",
				buttons: true,
				dangerMode: true,
				buttons: ["No, Cancel It!", "Yes, I am Sure!"],
			}).then(function(isConfirm){
				if (isConfirm) {
						$('#'+submit_btn.attr('id')).trigger('click',false);
				} else {
					sweetAlert("Request Cancelled",'','error');
					return;
				}
			});
			return;
		}
	});
	
</script>


<?php 
	$authorized=array('bhargavg');
	// include("../../../common/config/dbconf.php");
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	$view_access=user_acl("SFCS_0245",$username,1,$group_id_sfcs);

	error_reporting(0);
	// Report simple running errors
	error_reporting(E_ERROR | E_WARNING | E_PARSE);

	if(isset($_POST['style']))
	{
	    $style=$_POST['style'];
	    $schedule=$_POST['schedule'];
	}
	else
	{
		$style=$_GET['style'];
		$schedule=$_GET['schedule'];
	}
?>



<div class="panel panel-primary">
	<div class="panel-heading"><b>Create Sewing Jobs</b></div>
	<div class="panel-body">
			
			<div class="col-md-12">
				<?php
				echo "<form name=\"mini_order_report\" action=\"?r=".$_GET["r"]."\" class=\"form-inline\" method=\"post\" >";
				?>
					Style:
					<?php
						// Style
						echo "<select name=\"style\" id=\"style\" class='form-control' onchange=\"firstbox();\" >";
						$sql="select * from $brandix_bts.tbl_orders_style_ref order by product_style";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result);
						echo "<option value=\"NIL\" selected>Select Style</option>";
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$style))
							{
								echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['product_style']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['id']."\">".$sql_row['product_style']."</option>";
							}
						}
						echo "</select>";
					?>

					&nbsp;Schedule:
					<?php
						// Schedule
						echo "<select class='form-control' name=\"schedule\" id=\"schedule\"  >";
						$sql="select * from $brandix_bts.tbl_orders_master where ref_product_style='".$style."'";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result);
						echo "<option value=\"NIL\" selected>Select Schedule</option>";
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$schedule))
							{
								echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['product_schedule']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['id']."\">".$sql_row['product_schedule']."</option>";
							}
						}
						echo "</select>";
					?>
					&nbsp;&nbsp;
					<input type="submit" name="submit" id="submit" class="btn btn-success " onclick="return check_val();" value="Submit">
				</form>
			</div>

			<div class="col-md-12">
				
				<?php
				if(isset($_POST['submit']) or ($_GET['style'] and $_GET['schedule']))
				{	
					if ($_GET['style'] and $_GET['schedule']) {
						$style_id=$_GET['style'];
						$sch_id=$_GET['schedule'];
					} else if ($_POST['style'] and $_POST['schedule']){
						$style_id=$_POST['style'];
						$sch_id=$_POST['schedule'];	
					}
					if ($style_id =='NIL' or $sch_id =='NIL') 
					{						
						echo " ";
					}else{
						$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link);
						$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$sch_id,$link);
						
						$mini_order_ref = echo_title("$brandix_bts.tbl_min_ord_ref","id","ref_crt_schedule",$sch_id,$link);
						$bundle = echo_title("$brandix_bts.tbl_miniorder_data","count(*)","mini_order_ref",$mini_order_ref,$link);
						$c_ref = echo_title("$brandix_bts.tbl_carton_ref","id","ref_order_num",$sch_id,$link);
						$carton_qty = echo_title("$brandix_bts.tbl_carton_size_ref","sum(quantity)","parent_id",$c_ref,$link);
						$carton_qty=1;

					
						$validation_query = "SELECT * FROM $brandix_bts.`tbl_carton_ref` WHERE style_code=".$style_id." AND ref_order_num=".$sch_id."";
						$sql_result=mysqli_query($link, $validation_query) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($sql_result)>0)
						{
							// echo "carton props added, You can proceed";
							if($bundle==0)
							{		
								$sql="select * from $brandix_bts.tbl_min_ord_ref where ref_crt_schedule='".$sch_id."' and ref_product_style='".$style_id."'";
								$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
								if(mysqli_num_rows($sql_result)>0)
								{
									while($row=mysqli_fetch_array($sql_result))
									{
										$bundle_size=$row['miximum_bundles_per_size'];
										$bundle_plie=$row['max_bundle_qnty'];
										$mini_qty=$row['mini_order_qnty'];
									}
								}
								else
								{
									$bundle_size=1;
									$bundle_plie=0;
									$mini_qty=$bundle_size*$bundle_plie*$carton_qty;
								}
								$o_colors = echo_title("$bai_pro3.bai_orders_db","group_concat(distinct order_col_des order by order_col_des)","bai_orders_db.order_joins NOT IN ('1','2') AND order_del_no",$schedule,$link);	
								$p_colors = echo_title("$brandix_bts.tbl_orders_sizes_master","group_concat(distinct order_col_des order by order_col_des)","parent_id",$sch_id,$link);
								$order_colors=explode(",",$o_colors);	
								$planned_colors=explode(",",$p_colors);
								$val=sizeof($order_colors);
								$val1=sizeof($planned_colors);
								// echo $val."--".$val1."<br>";
								$ii=0;
								if($val==$val1 )
								{
									$ii=1;
								}
								if($bundle==0)
								{
									$status='';
								}
								else
								{
									$status='readonly';
								}

								echo '<form name="input" method="post" action="'.getFullURL($_GET['r'],'sewing_job_create.php','N').'">';
								echo  "<input type=\"hidden\" value=\"$style_id\" id=\"style_id\" name=\"style_id\">";
								echo  "<input type=\"hidden\" value=\"$sch_id\" id=\"sch_id\" name=\"sch_id\">";
					
								echo " <br><div class='col-md-12'>
									<table class='table table-bordered'>
										<thead class=\"primary\">
											<tr>
												<th >Schedule</th><th>Total Colors</th><th>Planned Colors</th><th>Carton Method</th><th >Pack Quantity</th><th style=\"display:none;\">Sewing Job Multiples</th><th>Sewing Job Quantity</th><th>Control</th>
											</tr>
										</thead>";
											echo "<tr><td rowspan=$val>$schedule</td>";
											for($i=0;$i<sizeof($order_colors);$i++)
											{
												if($i!=0)
												{
													echo "<tr>";
												}
												echo "<td>".$order_colors[$i]."</td>";
												echo "<td>".$planned_colors[$i]."</td>";
												if($i==0)
												{
													echo "<td rowspan=$val class='col-md-3'><select id=\"cart_method\" class='form-control' name=\"cart_method\" >";
													for($j=0;$j<sizeof($operation);$j++)
													{
														$disabled='';
														if ($val>1)
														{
															if ($j == '1' or $j == '4' or $j == '5')
															{
																$disabled='disabled';
															}
														} elseif ($val == 1) {
															if ($j == '2' or $j == '3')
															{
																$disabled='disabled';
															}
														}
														echo "<option value=\"".$j."\" $disabled>".$operation[$j]."</option>";
													}
													echo "</select></td>";
											
													
													echo "<td rowspan=$val><input type=\"hidden\" value=\"$carton_qty\" id=\"carton_qty\" name=\"carton_qty\" ><input type=\"text\" class='integer form-control' value=\"$bundle_plie\" id=\"bundle_plies\" name=\"bundle_plies\" onkeyup=\"validate();\" $status></td>
													<td style=\"display:none;\" rowspan=$val><input type=\"text\" class='integer form-control' value=\"$bundle_size\" id=\"bundle_per_size\" name=\"bundle_per_size\" onkeyup=\"validate();\" $status></td>
													<td rowspan=$val><input type=\"text\" class='integer form-control' value=\"$mini_qty\" id=\"mini_order_qty\" name=\"mini_order_qty\" onkeyup=\"tot_sum()\" readonly></td>";
													if($ii==1)
													{
														if($bundle>0)
														{
															echo "<td rowspan=$val>Sewing Job generation Completed.</td>";
														}
														else
														{
															echo "<td rowspan=$val><input type=\"submit\" class=\"btn btn-success\" value=\"Generate\" name=\"generate\" id=\"generate\" />";
															echo "<span id=\"msg1\" style=\"display:none;\"><h5>Please Wait..Sewing Job Generating.<h5></span></td>";
														}
													}
													else
													{
														echo "<td rowspan=$val>Some colors are Pending.</td>";
													}			
													echo "</tr>";
														
												}
												else
												{
													echo "</tr>";
												}
											}
									echo "</table>";
								echo "</div>";
								echo "</form>";
							}
														
							if($bundle > 0)
							{									
								include("input_job_mix_ch_report.php");
							}
						}
						else
						{							
							echo "<script>sweetAlert('Please Update Carton Details ','Before Creating Sewing Jobs!','warning');</script>";
						}	
					}
				}
				if(isset($_POST['generate']))
				{
					$style=$_POST['style_id'];
					$operation=$_POST['cart_method'];
					$scheudle=$_POST['sch_id'];
					$mini_order_ref =echo_title("$brandix_bts.tbl_min_ord_ref","id","ref_crt_schedule",$scheudle,$link);
					$carton_qty=$_POST['carton_qty'];
					$bundle_plies=$_POST['bundle_plies'];
					$bundle_per_size=$_POST['bundle_per_size'];
					$mini_order_qty=$_POST['mini_order_qty'];
					

					// echo $style."--".$operation."--".$schedule."==".$mini_order_ref."==".$carton_qty."==".$bundle_plies."==".$bundle_per_size."==".$mini_order_qty;
					
					if($bundle_plies!=0 && $bundle_per_size!=0 && $mini_order_qty!=0)
					{
						if($mini_order_ref>0)
						{
							$sql="update $brandix_bts.`tbl_min_ord_ref` set max_bundle_qnty='".$bundle_plies."',carton_method=".$operation.",miximum_bundles_per_size='".$bundle_per_size."',mini_order_qnty='".$mini_order_qty."' where id='".$mini_order_ref."'";
							// echo $sql."<br>";
							$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
							$id=$mini_order_ref;
						}
						else
						{
							$sql="insert into $brandix_bts.`tbl_min_ord_ref` (`ref_product_style`, `ref_crt_schedule`, `carton_quantity`, `max_bundle_qnty`, `miximum_bundles_per_size`, `mini_order_qnty`,`carton_method`) values ('".$style."', '".$scheudle."', '".$carton_qty."', '".$bundle_plies."', '".$bundle_per_size."', '".$mini_order_qty."',".$operation.")";
							//echo $sql."<br>";
							$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
							$id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
						}
					}
					else
					{
						echo "<h2>Please Fill Correct values</h2>";
					}
					//echo "<a href=\"mini_order_gen.php?id=$id\">Generate Mini Orders</a>";
					echo "<h2>Sewing orders Generation under process Please wait.....<h2>";
					// header("Location:mini_order_gen.php?id=$id");
					$url5 = getFullURLLevel($_GET['r'],'mini_order_gen.php',0,'N');
					echo("<script>location.href = '".$url5."&id=$id&style=$style&schedule=$scheudle';</script>");
				}
				?> 
		</div>
	</div>
</div>


<style>
#table1 {
  display: inline-table;
  width: 100%;
}


div#table_div {
    width: 30%;
}
#test{
margin-left:8%;
margin-bottom:2%;
}
</style>

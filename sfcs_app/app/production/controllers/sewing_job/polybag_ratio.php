
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=6; IE=5; IE=EDGE" />

<script language="javascript" type="text/javascript">
	function enableButton() 
	{
		if(document.getElementById('option').checked)
		{
			document.getElementById('submit').disabled='';
		} 
		else 
		{
			document.getElementById('submit').disabled='true';
		}
	}

	function button_disable()
	{
		document.getElementById('process_message').style.hidden="false";
		document.getElementById('submit').style.disabled='true';
	}

	function firstbox()
	{
		var url1 = '<?= getFullUrl($_GET['r'],'polybag_ratio.php','N'); ?>';
		window.location.href =url1+"&style="+document.mini_order_report.style.value;
	}

	// function secondbox()
	// {
	// 	var url2 = '<?= getFullUrl($_GET['r'],'carton_ratio.php','N'); ?>';
		// window.location.href =url2+"&style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value;
	// }

	function check_val()
	{

		var style=document.getElementById("style").value;
		var schedule=document.getElementById("schedule").value;
		var pack_method=document.getElementById("pack_method").value;

		if(style=='NIL' || schedule=='NIL' || pack_method=='0')
		{
			sweetAlert('Please Select the Values','','warning');
			
			return false;
		}
		else
		{
			return true;
		}

	}

	function check_val1()
	{
		//alert('Test');
		var carton_tot=document.getElementById("carton_tot").value;
		var barcode=document.getElementById("barcode").value;
		//var mini_order_qty=document.getElementById("mini_order_qty").value;
		var count=document.getElementById("total_cnt").value;
		//alert(count);
		var total_val=0;
		for(i=0;i<count;i++)
		{
			if(Number(document.getElementById("ratio["+i+"]").value)<=0)
			{
				sweetAlert('Fill all the Ratios','','info');
				return false;
			}
		}
		if(carton_tot>=0 && barcode>0)
		{
			//alert('Ok');
		}
		else
		{
			alert('Please Check the values.');
			document.getElementById('save').style.display=''
			document.getElementById('msg1').style.display='none';
			return false;
		}
	}

	function check_sum1()
	{
		//alert('okaeypress');
		var count=document.getElementById("total_cnt").value;
		//alert(count);
		var total_val=0;
		for(i=0;i<count;i++)
		{
			total_val+=Number(document.getElementById("ratio["+i+"]").value);
		}
		//alert(total_val);
		document.getElementById('carton_tot').value=total_val;
	}


</script>

<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	$has_permission=haspermission($_GET['r']);

	if(isset($_POST['style']))
	{
		$style=$_POST['style'];
		$schedule=$_POST['schedule'];
		$pack_method=$_POST['pack_method'];
	}
	else
	{
		$style=$_GET['style'];
		$schedule=$_GET['schedule'];
		$pack_method=$_GET['pack_method'];
	}
?>

	
<div class="panel panel-primary">
	<div class="panel-heading"><strong>Poly Bag Ratios</strong></div>
	<div class="panel-body">
	
		<div class="col-md-12">
			<form method="POST" class="form-inline" name="mini_order_report" action="index.php?r=<?php echo $_GET['r']; ?>">
				Style:
				<?php
					// Style
					echo "<select name=\"style\" id=\"style\"  class='form-control' onchange=\"firstbox();\">";
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
				&nbsp;&nbsp;
				Schedule:
				<?php
					echo "<select class='form-control' name='schedule' id='schedule'>";
					$sql="select id,product_schedule as schedule from $brandix_bts.tbl_orders_master where ref_product_style=\"$style\" group by schedule";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_result);
					echo "<option value=\"NIL\" selected>Select Schedule</option>";
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$schedule))
						{
							echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['schedule']."</option>";
						}
						else
						{
							echo "<option value=\"".$sql_row['id']."\">".$sql_row['schedule']."</option>";
						}
					}
					echo "</select>";
				?>
				&nbsp;&nbsp;
				Pack Method: 
				<?php 
				echo "<select id=\"pack_method\" class='form-control' name=\"pack_method\" >";
				for($j=0;$j<sizeof($operation);$j++)
				{
					$selected='';
					if ($pack_method == $j)
					{
						$selected='selected';
					}
					echo "<option value=\"".$j."\" $selected>".$operation[$j]."</option>";
				}
				echo "</select>";
				?>
				<input type="submit" name="submit" id="submit" class="btn btn-success" onclick="return check_val();" value="Submit">
				</form>
		</div>

				
			<?php
				if (isset($_POST["submit"]) or ($_GET['style'] and $_GET['schedule'] and $_GET['pack_method']))
				{
					if ($_GET['style'] and $_GET['schedule']) {
						$style_code=$_GET['style'];
						$schedule=$_GET['schedule'];
						$pack_method=$_GET['pack_method'];
					} else if ($_POST['style'] and $_POST['schedule']){
						$style_code=$_POST['style'];
						$schedule=$_POST['schedule'];	
						$pack_method=$_POST['pack_method'];	
					}

					$schedule_original = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
					$o_colors = echo_title("$bai_pro3.bai_orders_db","group_concat(distinct order_col_des order by order_col_des)","bai_orders_db.order_joins NOT IN ('1','2') AND order_del_no",$schedule_original,$link);	
					$p_colors = echo_title("$brandix_bts.tbl_orders_sizes_master","group_concat(distinct order_col_des order by order_col_des)","parent_id",$schedule,$link);
					$order_colors=explode(",",$o_colors);	
					$planned_colors=explode(",",$p_colors);
					$size_of_ordered_colors=sizeof($order_colors);
					$size_of_planned_colors=sizeof($planned_colors);
					// echo 'order_colors: '.$size_of_ordered_colors.'<br>planned: '.$size_of_planned_colors;

					if ($size_of_ordered_colors!=$size_of_planned_colors)
					{
						echo "<script>sweetAlert('Please prepare Lay Plan for all Colors in this Schedule - $schedule_original','','warning')</script>";
					}
					else
					{
						$schedule_original = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
						$o_colors = echo_title("$bai_pro3.bai_orders_db","group_concat(distinct order_col_des order by order_col_des)","bai_orders_db.order_joins NOT IN ('1','2') AND order_del_no",$schedule_original,$link);	
						$p_colors = echo_title("$brandix_bts.tbl_orders_sizes_master","group_concat(distinct order_col_des order by order_col_des)","parent_id",$schedule,$link);
						$order_colors=explode(",",$o_colors);	
						$planned_colors=explode(",",$p_colors);
						$size_of_ordered_colors=sizeof($order_colors);
						$size_of_planned_colors=sizeof($planned_colors);
						// if ($size_of_ordered_colors!=$size_of_planned_colors)
						{
							$sewing_jobratio_sizes_query = "SELECT parent_id,GROUP_CONCAT(DISTINCT color) AS color, GROUP_CONCAT(DISTINCT ref_size_name) AS size FROM $brandix_bts.tbl_carton_size_ref WHERE parent_id IN (SELECT id FROM $brandix_bts.tbl_carton_ref WHERE ref_order_num=$schedule AND style_code=$style_code)";
							$sewing_jobratio_sizes_result=mysqli_query($link, $sewing_jobratio_sizes_query) or exit("Error while getting Job Ratio Details");
							while($sewing_jobratio_color_details=mysqli_fetch_array($sewing_jobratio_sizes_result)) 
							{
								$parent_id = $sewing_jobratio_color_details['parent_id'];
								$color = $sewing_jobratio_color_details['color'];
								$size = $sewing_jobratio_color_details['size'];
								$color1 = explode(",",$color);
								$size1 = explode(",",$size);
								// var_dump($size);
							}
							switch ($pack_method)
							{
								case 1:
									echo "SS";
									include 'single_color_single_size.php';
									break;

								case 2:
									echo "MS";
									include 'multi_color_single_size.php';
									break;

								case 3:
									echo "MM";
									include 'multi_color_multi_size.php';
									break;

								case 4:
									include 'single_color_multi_size.php';
									break;
								
								default:
									echo "Please Select Pack Method";
									break;
							}
						}
					}
				}

		?>
		
	</div>
</div>
</div>
	


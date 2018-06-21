
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
		var url1 = '<?= getFullUrl($_GET['r'],'carton_ratio.php','N'); ?>';
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

		if(style=='NIL' || schedule=='NIL')
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
	}
	else
	{
		$style=$_GET['style'];
		$schedule=$_GET['schedule'];
	}
?>

	
<div class="panel panel-primary">
	<div class="panel-heading"><strong>Sewing Job Ratios</strong></div>
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
				<input type="submit" name="submit" id="submit" class="btn btn-success" onclick="return check_val();" value="Submit">
				</form>
		</div>

				
			<?php
				if (isset($_POST["submit"]) or ($_GET['style'] and $_GET['schedule']))
				{
					if ($_GET['style'] and $_GET['schedule']) {
						$style_code=$_GET['style'];
						$schedule=$_GET['schedule'];
					} else if ($_POST['style'] and $_POST['schedule']){
						$style_code=$_POST['style'];
						$schedule=$_POST['schedule'];	
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
						// echo "<br><br><br><div class='alert alert-danger'>Please prepare Lay Plan for all Colors in this Schedule - $schedule_original</div>";
					}
					else
					{
						$miniord_ref = echo_title("$brandix_bts.tbl_min_ord_ref","max(id)","ref_crt_schedule='".$schedule."' and ref_product_style",$style_code,$link);
						$bundles = echo_title("$brandix_bts.tbl_miniorder_data","count(*)","mini_order_ref",$miniord_ref,$link);
						$check = echo_title("$brandix_bts.tbl_carton_ref","id","ref_order_num='".$schedule."' and style_code",$style_code,$link);
						$stylecode = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_code,$link);
						//getting schedule
						$schedule_result = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
						if($check>0)
						{
							$carton_qty = echo_title("$brandix_bts.tbl_carton_size_ref","sum(quantity)","parent_id",$check,$link);
							$barcode_num = echo_title("$brandix_bts.tbl_carton_ref","carton_barcode","ref_order_num='".$schedule."' and style_code",$style_code,$link);
						}
						else
						{
							$sql="SELECT tcs.id,tcs.parent_id,COUNT(tcs.id) AS cnt  FROM $brandix_bts.tbl_carton_ref AS tc LEFT JOIN $brandix_bts.tbl_carton_size_ref AS tcs ON tcs.parent_id=tc.id WHERE tc.style_code='".$style_code."' GROUP BY tc.ref_order_num HAVING cnt>0 ORDER BY cnt DESC LIMIT 1 ";
							$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($row1=mysqli_fetch_array($sql_result))
							{
								$carton_id=$row1['parent_id'];
								$barcode_num=echo_title("$brandix_bts.tbl_carton_ref","carton_barcode","id",$check,$link);
							}
						}

						if($carton_qty>0)
						{
							echo "<br><br><br><div class='alert alert-success'>Carton Properties Already Created</div>";
						}

						$sql="select * from $brandix_bts.tbl_orders_sizes_master where parent_id='".$schedule."' order by order_col_des,ref_size_name";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$i=0;
						
						echo "<form name=\"input\" class=\"form-inline\" method=\"post\" action='".$url1."' >";?>		
							<div class='col-md-6'>
								<table class='table table-bordered'>
									<thead class=\"primary\">
										<tr>
											<th >Schedule:</th>
											<?php
												if ($carton_qty>0) {
													$value_barcode = 'readonly=true value='.$barcode_num.'';
													$value_carton_qty='value='.$carton_qty.'';
												} else {
													$value_barcode = '  value='.$schedule_result.'';
													$value_carton_qty='value=0';
												}

												echo "<th ><input type=\"text\"  required class=\"form-control integer\" id=\"barcode\" name=\"barcode\" ".$value_barcode."></th>";								
												echo "
												<th >Ratio Total:</th>
												<th ><input type=\"text\"  oncopy='return false' onpaste='return false' class=\"form-control\" ".$value_carton_qty." id=\"carton_tot\" readonly=true name=\"carton_tot\" onmouseover=\"check_sum1();\"> </th>";
									
											?>
										</tr><br>
										<tr><th>Sl.No</th><th>Color</th><th>Size</th><th>Ratio</th></tr>
									</thead>
									<tbody>
										<?php
											while($row=mysqli_fetch_array($sql_result))
											{
												if($check>0)
												{
													$carton=echo_title("$brandix_bts.tbl_carton_size_ref","quantity","color='".$row['order_col_des']."' and ref_size_name='".$row['ref_size_name']."' and parent_id",$check,$link);
												}
												else
												{
													$ratio=echo_title("$brandix_bts.tbl_carton_size_ref","quantity","color='".$row['order_col_des']."' and ref_size_name='".$row['ref_size_name']."' and parent_id",$carton_id,$link);
													if($ratio>0){	$carton=$ratio;	}
													else{	$carton=0;	}
												}
												if($carton_qty>0){	$read_only="value='$carton' readonly=true";	}
												else{	$read_only="value='0'";	}
												if(in_array($authorized,$has_permission)){ $ratio_textBox = ''; } else { $ratio_textBox = 'readonly'; }
												echo "<tr>
														<td>".($i+1)."</td>
														<td><input type=\"hidden\" name=\"color_code[".$i."]\" value='".$row['order_col_des']."'>".$row['order_col_des']."</td>
														<td><input type=\"hidden\" name=\"size[".$i."]\" value='".$row['ref_size_name']."'><input type=\"hidden\" name=\"size_tit[".$i."]\" value='".$row['size_title']."'>".$row['size_title']."</td>
														<td><input class=\"form-control integer\" type=\"text\" ".$ratio_textBox." oncopy='return false' onpaste='return false' id=\"ratio[".$i."]\" onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value='0';}\" name=\"ratio[".$i."]\"  required ".$read_only."  onkeyup='check_sum1();' ></td>
													</tr>";
												$carton=0;
												$i++;
											}
											echo "<input type=\"hidden\" name=\"total_cnt\" id=\"total_cnt\" value=\"$i\">";
											echo "<input type=\"hidden\" name=\"style\" value=\"$style_code\">";
											echo "<input type=\"hidden\" name=\"schedule\" value=\"$schedule\">";
										?>
									</tbody>
								</table>
								<br>
								<?php
								if($carton_qty>0)
								{
								
								}
								else
								{
									if(in_array($authorized,$has_permission))
									{
										?>
										<input type="submit" class="btn btn-success" name="save" value="Save" id="save" onclick="return check_val1();">
										<?php
									} else {
										echo "<div class='alert alert-danger'>You are Not Authorized to Add Sewing Job Ratio</div>";
									}
								}
							echo "</div>
						</form>";
						
					}
				}
			if(isset($_POST['save']))
			{
				// echo "string";
				$style_id=$_POST['style'];
				$schedule_id=$_POST['schedule'];
				$barcode=trim($_POST['barcode']);
				$carton_tot=$_POST['carton_tot'];
				$color=$_POST['color_code'];
				$size=$_POST['size'];
				$size_tit=$_POST['size_tit'];
				$ratio=$_POST['ratio'];
				$total_ratio=array_sum($ratio);
				$style=echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link);
				$schedule=echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
				$check=echo_title("$brandix_bts.tbl_carton_ref","id","style_code=\"$style_id\" and ref_order_num",$schedule_id,$link);
				if($check>0)
				{
					$id=$check;
					$sql="update $brandix_bts.tbl_carton_ref set carton_barcode='".$barcode."',carton_tot_quantity='".$carton_tot."' where id='".$id."'";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error--".mysqli_error($GLOBALS["___mysqli_ston"]));

				}
				else
				{
					$sql1="insert ignore into $brandix_bts.tbl_carton_ref (carton_barcode,carton_tot_quantity,ref_order_num,style_code) values('".$barcode."','".$carton_tot."','".$schedule_id."','".$style_id."')";
					$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
				}
				//echo sizeof($color);
				for($i=0;$i<sizeof($color);$i++)
				{
					$check_c=echo_title("$brandix_bts.tbl_carton_size_ref","id","parent_id=\"$id\" and color=\"$color[$i]\" and ref_size_name",$size[$i],$link);
					if($check_c>0)
					{
						$sql2="update $brandix_bts.tbl_carton_size_ref set quantity='".$ratio[$i]."' where id='".$check_c."'";
						$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error--2".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql4="insert ignore into $brandix_bts.tbl_carton_size_ref (parent_id,color,ref_size_name,quantity) values('".$id."','".$color[$i]."','".$size[$i]."','".$ratio[$i]."')";
						$sql_result2=mysqli_query($link, $sql4) or exit("Sql Error--2".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}

				$carton_ratio = getFullURLLevel($_GET['r'],'carton_ratio.php',0,'N');
				// echo "<br><br><br><br><div class='alert alert-success'>Data Saved Successfully</div>";
				echo "<script>sweetAlert('Data Saved Successfully','','success')</script>";
					echo "<script>
						setTimeout(redirect(),3000);
						function redirect(){
							location.href = '".$carton_ratio."&style=$style_id&schedule=$schedule_id';
						}</script>";	
			}
		?>
		
	</div>
</div>
</div>
	


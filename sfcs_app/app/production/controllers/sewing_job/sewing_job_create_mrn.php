<style>
#loading-image{
	position:fixed;
	top:0px;
	right:0px;
	width:100%;
	height:100%;
	background-color:#666;
	/* background-image:url('ajax-loader.gif'); */
	background-repeat:no-repeat;
	background-position:center;
	z-index:10000000;
	opacity: 0.4;
	filter: alpha(opacity=40); /* For IE8 and earlier */
}
</style>
<script language="javascript" type="text/javascript">
	
	var url1 = '<?= getFullURL($_GET['r'],'sewing_job_create_mrn.php','N'); ?>';

	function firstbox()
	{
		//alert("report");
		window.location.href =url1+"&style="+document.mini_order_report.style.value
	}

	function check_val()
	{
		//alert('dfsds');
		$("#loading-image").show();

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

	$(document).ready(function(){
		$('#generate').on('click',function(event, redirect=true)
		{
			if(redirect != false){
				event.preventDefault();
				submit_form($(this));
			}

			// $(".generate_btn").click(function()
			// {
			// 	alert('hi');
			// 	$("#loading-image").show();
			// });

		});

		function submit_form(submit_btn)
		{
			var split_tot = 0;
			var comboSize=document.getElementById("comboSize").value;
			for(var combo_size=1;combo_size <= comboSize; combo_size++)
			{
				var split=document.getElementById("split_qty_"+combo_size).value;
				// confirm("split_qty_"+combo_size+" => "+split);
				if (split == -1 || split == '')
				{
					sweetAlert('Enter valid Garments Per Bundle','','warning');
					return;
				}
				split_tot = split_tot + split;
			}
			// var exces_from=document.getElementById("exces_from").value;
			var mix_jobs=document.getElementById("mix_jobs").value;
			// alert(mix_jobs);
			if (mix_jobs == '')
			{
				sweetAlert('Please Select Mix Jobs','','warning');
			}
			else
			{
				// if (exces_from == 0)
				// {
				// 	sweetAlert('Please Select Excess From','','warning');
				// }
				// else
				// {
					if (split_tot > 0)
					{
						title_to_show = "";
					}
					else
					{
						title_to_show = "Bundle Size not defined, Deafult bundle size will be applied";
					}
					sweetAlert({
						title: "Are you sure to generate Sewing Jobs?",
						text: title_to_show,
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
				// }
			}
		}
	});
	
	function pack_method_1_4_fun(sizeofsizes,combo_no)
	{
		for(var size=0;size < sizeofsizes; size++)
		{
			var GarPerCart=document.getElementById('GarPerCart_'+size+'_'+combo_no).value;
			var no_of_cartons=document.getElementById('no_of_cartons_'+combo_no).value;
			var SewingJobQty = GarPerCart*no_of_cartons;
			document.getElementById('SewingJobQty_'+size+'_'+combo_no).value=SewingJobQty;
		}
	}

	function pack_method_2_3_fun(sizeofsizes,combo_no,val)
	{
		for (var i = 0; i < val; i++)
		{
			for(var size=0;size < sizeofsizes; size++)
			{
				var GarPerCart=document.getElementById('GarPerCart_'+size+'_'+combo_no+'_'+i).value;
				var no_of_cartons=document.getElementById('no_of_cartons_'+combo_no).value;
				var SewingJobQty = GarPerCart*no_of_cartons;
				document.getElementById('SewingJobQty_'+size+'_'+combo_no+'_'+i).value=SewingJobQty;
			}
		}	
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
<div class="ajax-loader" id="loading-image" style="display: none">
    <center><img src='<?= getFullURLLevel($_GET['r'],'common/images/ajax-loader.gif',2,'R'); ?>' class="img-responsive" style="padding-top: 250px"/></center>
</div>
<div class="panel panel-primary">
	<div class="panel-heading"><b>MRN Integration</b></div>
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
				<input type="submit" name="submit" id="submit" class="btn btn-success generate_btn" onclick="return check_val();" value="Submit">
			</form>
		</div>

		<div class="col-md-12">
			<?php
				if(isset($_POST['submit']) or ($_GET['style'] and $_GET['schedule']))
				{	
					if ($_GET['style'] and $_GET['schedule'])
					{
						$style_id=$_GET['style'];
						$sch_id=$_GET['schedule'];
					} 
					else if ($_POST['style'] and $_POST['schedule'])
					{
						$style_id=$_POST['style'];
						$sch_id=$_POST['schedule'];	
					}
					if ($style_id =='NIL' or $sch_id =='NIL') 
					{						
						echo " ";
					}
					else
					{
						 //echo "Style= ".$style_id."<br>Schedule= ".$sch_id.'<br>';
						$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link);
						$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$sch_id,$link);
						
						$pac_stat_input_check = echo_title("$bai_pro3.pac_stat_input","count(*)","schedule",$schedule,$link);
						$packing_summary_input_check = echo_title("$bai_pro3.packing_summary_input","count(*)","order_del_no",$schedule,$link);
						$pack_size_ref_check = echo_title("$bai_pro3.tbl_pack_ref","count(*)","schedule",$schedule,$link);

						if ($packing_summary_input_check > 0)
						{
							if ($pac_stat_input_check > 0)
							{
								// echo '<br><div class="alert alert-danger">
								//   <strong>Warning!</strong>
								//   <br>You have already created sewing jobs based on pack method, So You should go with the same process.';
								// echo "&nbsp;&nbsp;&nbsp;&nbsp;<a class='btn btn-primary' href = '".getFullURLLevel($_GET['r'],'create_sewing_job_packlist.php',0,'N')."'>Click Here to Go</a>
								// </div>";
							}
							else
							{
								$display_check = 1;
							}
						}
						else
						{
							$display_check = 1;
						}	
						
						if ($display_check == 1)
						{
							$c_ref = echo_title("$brandix_bts.tbl_carton_ref","id","ref_order_num",$sch_id,$link);
							$bundle = echo_title("$brandix_bts.tbl_miniorder_data","count(*)","mini_order_ref",$c_ref,$link);
							$carton_qty = echo_title("$brandix_bts.tbl_carton_size_ref","sum(quantity)","parent_id",$c_ref,$link);
							$pack_method = echo_title("$brandix_bts.tbl_carton_ref","carton_method","carton_barcode",$schedule,$link);
							$tbl_carton_ref_check = echo_title("$brandix_bts.tbl_carton_ref","count(*)","style_code='".$style_id."' AND ref_order_num",$sch_id,$link);
							$o_colors = echo_title("$bai_pro3.bai_orders_db_confirm","group_concat(distinct order_col_des order by order_col_des)","bai_orders_db_confirm.order_joins NOT IN ('1','2') AND order_del_no",$schedule,$link);	
							$p_colors = echo_title("$brandix_bts.tbl_orders_sizes_master","group_concat(distinct order_col_des order by order_col_des)","parent_id",$sch_id,$link);
							$order_colors=explode(",",$o_colors);	
							$planned_colors=explode(",",$p_colors);
							$val=sizeof($order_colors);
							$val1=sizeof($planned_colors);
							// echo '<h4>Pack Method: <span class="label label-info">'.$operation[$pack_method].'</span></h4>';
								// echo "carton props added, You can proce			
								//echo $bundle;				
								if($bundle > 0)
								{									
									include("input_job_mix_ch_report_mrn.php");
								}
							
						}

					}
				}
				
			?> 
		</div>
	</div>
</div>
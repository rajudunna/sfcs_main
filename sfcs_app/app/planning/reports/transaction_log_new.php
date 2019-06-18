
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));

// $view_access=user_acl("SFCS_0046",$username,1,$group_id_sfcs); 
?>

<html>
<head>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R')?>"></script>
<link href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R'); ?>" rel="stylesheet" type="text/css" />
<link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',3,'R'); ?>" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R')?>"></script>
<script type="text/javascript" src="../<?= getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R') ?>" ></script>
</head>

<body>
<?php
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	$shift=$_POST['shift'];
	$module=$_POST['module'];
	$hour_from=$_POST['hour_from'];
	$hour_to=$_POST['hour_to'];
?>
<!--<div id="page_heading"><span style="float"><h3>Daily Production Status Report</h3></span><span style="float: right; margin-top: -20px"><b>?</b>&nbsp;</span></div>-->
<div class="panel panel-primary">
<div class="panel-heading">Production Status Report (Sewing Out)</div>
<div class="panel-body">
<div class="form-group">
<form name="text" method="post" action="index.php?r=<?php echo $_GET['r']; ?>">
<div class="col-md-12">
<div class="col-md-2">
<label valign="top">Start: </label><input data-toggle="datepicker" class="form-control" type="text" id="demo1" name="sdate" value="<?php  if($sdate==""){ echo date("Y-m-d"); } else { echo $sdate; } ?>" size="10" required> 
</div>
<div class="col-md-2">
<label valign="top">End: </label> <input data-toggle="datepicker"  class="form-control" type="text" id="demo2" name="edate" value="<?php  if($edate==""){ echo date("Y-m-d"); } else { echo $edate; } ?>" size="10" required>
</div>
<div class="col-md-1">
<label valign="top">Section: </label> <select name="module" id="myModule" class="form-control">
<option value="0" <?php  if($module=="All")?>selected>All</option>
<?php
$sql_mods=array();
$sql_name=array();
$sql="SELECT * FROM $bai_pro3.sections_master";
$result7=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($result7))
{
	$sql_mods[]=$sql_row["sec_name"];
	$sql_name[]=$sql_row["section_display_name"];
}
for($i=0;$i<sizeof($sql_mods);$i++)
{
	if($sql_mods[$i]==$module)
	{
		echo "<option value=\"".$sql_mods[$i]."\" selected>".$sql_name[$i]."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_mods[$i]."\" >".$sql_name[$i]."</option>";
	}
}	
	
?>
</select></div>
<div class="col-md-1">
<label valign="top">Shift Hour: </label> <select name="shift" id="myshift" class="form-control">
<option value='All' <?php if($shift=="All"){ echo "selected"; } ?> >All</option>
<?php 
for ($i=0; $i < sizeof($shifts_array); $i++) {
	if($shifts_array[$i]==$shift)
	{
	?>
<option  <?php echo 'value="'.$shifts_array[$i].'"'; ?> selected><?php echo $shifts_array[$i] ?></option>
	<?php
		}
		else {
	?>
	<option  <?php echo 'value="'.$shifts_array[$i].'"'; ?>><?php echo $shifts_array[$i] ?></option>
<?php }
}
?>
<!-- <option  value="<?= $sf ?>" selected><?php echo 'ALL'; ?></option> -->
</select></div>

<div class="col-md-2">

<label for="hour_filter" valign="top">From Hour: </label>
<?php
	echo "<select name=\"hour_from\" id='hour_from' class=\"form-control\" >";
	$sql22="SELECT time_value FROM $bai_pro3.tbl_plant_timings order by time_value*1"; 
	$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rows=mysqli_fetch_array($sql_result22))
	{
		if($hour_from==$rows['time_value'])
		{
			echo "<option value=\"".$rows['time_value']."\" selected>".$rows['time_value']."</option>";
		}
		else
		{
			echo "<option value=\"".$rows['time_value']."\" >".$rows['time_value']."</option>";
		}		
	}  
    echo "</select>"; 
   // echo $sql; 
?>
</select>
</div>
<div class="col-md-2">
<label for="hour_filter" valign="top">To Hour: </label>
<?php
	echo "<select name=\"hour_to\" id='hour_to' class=\"form-control\" >";
	$sql221="SELECT time_value FROM $bai_pro3.tbl_plant_timings  order by time_value*1"; 
	$sql_result221=mysqli_query($link, $sql221) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rows1=mysqli_fetch_array($sql_result221))
	{		
		if($hour_to==$rows1['time_value'])
		{
			echo "<option value=\"".$rows1['time_value']."\" selected>".$rows1['time_value']."</option>";
		}
		else
		{
			echo "<option value=\"".$rows1['time_value']."\" >".$rows1['time_value']."</option>";
		} 
	}  
    echo "</select>"; 
   // echo $sql; 
?>
</select>
</div>


<input type="submit" value="submit" class="btn btn-info" name="submit" style="margin-top:18px" onclick="return verify_date()" >
</form>
</div>

<br>

<?php

if(isset($_POST['submit']))
{
	
echo '<form action="'.getFullURL($_GET["r"],"export_excel.php",'R').'" method ="post" > 

<input type="hidden" id="csv_text" name="csv_text" >
<input type="submit" id="exp_exc" class="btn btn-info" value="Export to Excel" onclick="getData()">
</form><br>';
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	$shift_new=$_POST['shift'];
	$module=$_POST['module'];
	$hour_from=$_POST["hour_from"];
	$hour_to=$_POST["hour_to"];
	if($shift_new!='All')
	{
		$shift_value="and bac_shift in ('".$shift_new."')";
	}
	else 
	{
		$shift_value="";
	}
	if($module!=0)
	{
		$section_value="and bac_sec =$module";
	}
	else 
	{
		$section_value="";
	}
	foreach($sizes_array as $key=>$size)
	{
		$append.= " SUM(size_$size) as size_$size,";
	}
	$sql22121="SELECT start_time,end_time FROM $bai_pro3.tbl_plant_timings where time_value='$hour_from'"; 
	$sql_result22121=mysqli_query($link, $sql22121) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rows1231=mysqli_fetch_array($sql_result22121))
	{
		$start_check=$rows1231['start_time'];
	}
	$sql25="SELECT start_time,end_time FROM $bai_pro3.tbl_plant_timings where time_value='$hour_to'"; 
	$sql_result25=mysqli_query($link, $sql25) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rows125=mysqli_fetch_array($sql_result25))
	{
		$end_check=$rows125['end_time'];
	}
	$sql="select tid from $bai_pro.bai_log where bac_date between \"$sdate\" and \"$edate\" ".$shift_value." ".$section_value." and time(log_time) BETWEEN ('".$start_check."') and ('".$end_check."')";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error311".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result)>0)
	{
		echo "<div>";
		echo "<div  class ='table-responsive'>";
		echo "<table id=\"table1\"  border=1 class=\"table\" cellpadding=\"0\" cellspacing=\"0\" style='margin-top:10pt;'><thead><tr class='tblheading' style='color:white;'><th>Date</th><th>Time<th>Module</th><th>Section</th><th>Shift</th><th>Style</th><th>Schedule</th><th>Color</th><th>Cut No</th><th>Input Job No</th><th>Size</th><th>Quantity</th></tr></thead><tbody>";
		$total_qty=0;
		do{
			for($ii=$hour_from;$ii<=$hour_to;$ii++)
			{
				$sql2212="SELECT start_time,end_time,time_display,day_part FROM $bai_pro3.tbl_plant_timings where time_value='$ii'"; 
				$sql_result2212=mysqli_query($link, $sql2212) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($rows12=mysqli_fetch_array($sql_result2212))
				{
					$time_display=$rows12['time_display'];
					$day_part=$rows12['day_part'];
					$start_hour=$rows12['start_time'];
					$end_hour=$rows12['end_time'];
					$time_query=" AND TIME(log_time) BETWEEN ('".$rows12['start_time']."') and ('".$rows12['end_time']."')";
				}
				$sql1="select smv,nop,bac_no,delivery,bac_sec,bac_date,bac_shift, jobno,sum(bac_Qty) as bac_Qty,bac_lastup,bac_style,ims_doc_no,$append log_time from $bai_pro.bai_log where bac_date='".$sdate."' $time_query $shift_value $section_value  GROUP BY bac_sec,bac_no,bac_style,delivery,jobno,color,ims_doc_no ORDER BY bac_style,delivery,bac_shift,jobno*1";
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_result1)>0)
				{
					while($sql_row=mysqli_fetch_array($sql_result1))
					{
						$module=$sql_row['bac_no'];
						$section=$sql_row['bac_sec'];
						$date=$sql_row['bac_date'];
						$shift=$sql_row['bac_shift'];
						$qty=$sql_row['bac_Qty'];
						$lastup=$sql_row['bac_lastup'];
						$style=$sql_row['bac_style'];
						$doc_no=$sql_row['ims_doc_no'];
						$log_time=$sql_row['log_time'];
						$schedule=$sql_row['delivery'];
						$color=$sql_row['color'];
						$smv=$sql_row['smv'];
						$nop=$sql_row['nop'];
						for($i=0;$i<sizeof($sizes_array);$i++)
						{
							if($sql_row["size_".$sizes_array[$i].""]>0)
							{						
								$sizes[$sizes_array[$i]]=$sql_row["size_".$sizes_array[$i].""];
								$sizes_val[]=$sizes_array[$i];								
							}
						}
						$input_job = $sql_row['jobno'];
						$sql112="select * from $bai_pro3.plandoc_stat_log where doc_no=$doc_no";
						//echo $sql1."<br>";
						$sql_result2=mysqli_query($link, $sql112) or exit("Sql Error4--".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row1=mysqli_fetch_array($sql_result2))
						{
							$order_tid=$sql_row1['order_tid'];
							$cutno=$sql_row1['acutno'];
						}
						if(mysqli_num_rows($sql_result2)==0){
							$sql15="select * from $bai_pro3.plandoc_stat_log_archive where doc_no=$doc_no";
							$sql_result1212=mysqli_query($link, $sql15) or exit("Sql Error5--".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row112=mysqli_fetch_array($sql_result1212))
							{
								$order_tid=$sql_row112['order_tid'];
								$cutno=$sql_row112['acutno'];
							}
						}					
						$sql12="select order_style_no,order_del_no,order_col_des,color_code,style_id from $bai_pro3.bai_orders_db where order_del_no=\"".$schedule."\" and order_tid=\"".$order_tid."\"";
						$sql_result122=mysqli_query($link, $sql12) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_no_rows=mysqli_num_rows($sql_result122);
						$table="$bai_pro3.bai_orders_db";
						if($sql_no_rows == 0)
						{
							$table="$bai_pro3.bai_orders_db_archive";
						}
						$sql143="select order_style_no,order_del_no,order_col_des,color_code,style_id from $table where order_del_no=\"".$schedule."\" and order_tid=\"".$order_tid."\" ";
						$sql_result132=mysqli_query($link, $sql143) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row132=mysqli_fetch_array($sql_result132))
						{
							$style=$sql_row132['order_style_no'];
							$schedule=$sql_row132['order_del_no'];
							$color=$sql_row132['order_col_des'];
							$color_code=$sql_row132['color_code'];
							$style_id=$sql_row132['style_id'];
						}
						$bgcolor="";	
						if($smv==0 and $nop==0)
						{
							$bgcolor="WHITE";
						} 
						for($k=0;$k<sizeof($sizes_val);$k++)
						{
							$finalized_size_qty = $sizes[$sizes_val[$k]];
							$getting_title_size = "select title_size_".$sizes_val[$k]." as size from $table where order_del_no=\"".$schedule."\" and order_tid=\"".$order_tid."\"";
							$sql_result001=mysqli_query($link, $getting_title_size) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_result_fetch = mysqli_fetch_array($sql_result001)){
								$finalized_title_size_value = $sql_result_fetch["size"];
							}
							$display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$input_job,$link);
							echo "<tr bgcolor=\"$bgcolor\"><td>$sdate</td><td>".$time_display." ".$day_part."</td><td>$module</td><td>$section</td><td>$shift</td><td>$style</td><td>".$schedule."</td><td>$color</td><td>".chr($color_code).leading_zeros($cutno,3)."</td><td>$display_prefix1</td><td>$finalized_title_size_value</td><td >".$sizes[$sizes_val[$k]]."</td></tr>";
							$total_qty=$total_qty+$sizes[$sizes_val[$k]];							
						}				
						unset($sizes_val);
						unset($sizes);				
					}
				}
				$time_query='';
			}			
			$sdate = date ("Y-m-d", strtotime("+1 days", strtotime($sdate)));			
		}
		while (strtotime($sdate) <= strtotime($edate)); 
		echo "<tr style='background-color:#FFFFCC;' class='total_excel'><td colspan=11>Total</td><td id='table1Tot1'>$total_qty</td></tr></tbody></table></div></div>";
	}
	else
	{
		echo "<div class='alert alert-danger' style='width:1000px';>No Data Found</div>";
		echo "<script>$(document).ready(function(){
				 $('#table1').css('display','none');
			 });</script>";
	}
}
 
?>
<script>
var fnsFilters = {
	
	rows_counter: true,
	sort_select: true,
		on_change: true,
		display_all_text: " [ Show all ] ",
		loader_text: "Filtering data...",  
	loader: true,
	loader_text: "Filtering data...",
	col_0: 'select',
	col_1: 'select',
	col_2: 'select',
	col_3: 'select',
	col_4: 'select',
	col_5: 'select',
	col_6: 'select',
	col_7: 'select',
	col_8: 'select',
	col_9: 'select',
	col_10: 'select',
	col_11: 'select',
	
	btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear",
	col_operation: {						
						id: ["table1Tot1"],
						col: [11],  
						operation: ["sum"],
						decimal_precision: [1],
						write_method: ["innerHTML"] 
					},
	rows_always_visible: [grabTag(grabEBI('table1'),"tr").length]
		
	};
	
	 setFilterGrid("table1",fnsFilters);
	

</script>
<script language="javascript">

function getData(){
	var dummytable = $('.fltrow').html();
	var dummytotal = $('.total_excel').html();
	$('.fltrow').html('');
	$('.total_excel').html('');
	var csv_value= $("#table1").table2CSV({delivery:'value',excludeRows: '.fltrow .total_excel'});
	$("#csv_text").val(csv_value);	
	$('.fltrow').html(dummytable);
	$('.total_excel').html(dummytotal);
}
</script>
<script type="text/javascript">
	function verify_hour()
	{
		var val1 = $('#hour').val();
		var val2 = $('#hour1').val();

		
		if(val1 > val2){
			sweetAlert('Start Hour Should  be less than End Hour','','warning');
			return false;
		}
		else
		{
			return true;
		}
    }

</script>
<script type="text/javascript">
	function verify_date()
	{
		var val1 = $('#demo1').val();
		var val2 = $('#demo2').val();
		var h1 = $('#hour_from').val();
		var h2 = $('#hour_to').val();
		var h1_num = h1*1;
		var h2_num = h2*1;
		if(h1_num > h2_num){
			sweetAlert('To Hour must be greater than From Hour','','warning');
			return false;
			setTimeout(function(){
              location.href = "<?= getFullURL($_GET['r'],'transaction_log_new.php','N') ?>"
			},10000);
		}
		if(val1 > val2){
			sweetAlert('Start Date Should  be less than End Date','','warning');
			return false;
		}
		else
		{
			return true;
		}
    }

</script>
<style>
.flt{
	width:100%;
}
</style>
</div>
</div>
</body>
</html>

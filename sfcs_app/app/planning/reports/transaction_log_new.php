
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
	else {
		$shift_value="";
	}
	if($module!=0)
	{
		$section_value="and bac_sec =$module";
	}
	else {
		$section_value="";
	}
	$sql2212="SELECT start_time FROM $bai_pro3.tbl_plant_timings where time_value='$hour_from'"; 
	$sql_result2212=mysqli_query($link, $sql2212) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rows12=mysqli_fetch_array($sql_result2212))
	{
		$start_hour=$rows12['start_time'];
	}
	$sql2212="SELECT end_time FROM $bai_pro3.tbl_plant_timings where time_value='$hour_to'"; 
	$sql_result2212=mysqli_query($link, $sql2212) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rows12=mysqli_fetch_array($sql_result2212))
	{
		$end_hour=$rows12['end_time'];
	}
	
	foreach($sizes_array as $key=>$size){
		$append.= " SUM(size_$size) as size_$size,";
	}
	$append = rtrim($append,',');

	$sql="select tid,bac_no,delivery,bac_sec,bac_date,bac_shift, jobno,sum(bac_Qty) as bac_Qty,bac_lastup,bac_style,ims_doc_no,ims_tid,ims_table_name,log_time,smv,nop,$append from $bai_pro.bai_log where bac_date between \"$sdate\" and \"$edate\" ".$shift_value." ".$section_value." and TIME(log_time) BETWEEN ('".$start_hour."') and ('".$end_hour."') GROUP BY bac_date,HOUR(log_time),bac_no,bac_shift,ims_doc_no,jobno,SIGN(bac_Qty) ORDER BY bac_date,HOUR(log_time),bac_no*1,ims_doc_no*1,jobno*1";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result)>0)
{
	echo "<div>";
	echo "<div  class ='table-responsive'>";
	echo "<table id=\"table1\"  border=1 class=\"table\" cellpadding=\"0\" cellspacing=\"0\" style='margin-top:10pt;'><thead>";
	echo "<tr class='tblheading' style='color:white;'><th>Date</th><th>Time<th>Module</th><th>Section</th><th>Shift</th><th>User Style</th><th>Movex Style</th><th>Schedule</th><th>Color</th><th>Cut No</th>";
	//echo "<th>SMV</th><th>NOP</th>";
	echo "<th>Input Job No</th><th>Size</th><th>Quantity</th></tr></tbody>";
	// var_dump(mysqli_num_rows($sql_result));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$tid=$sql_row['tid'];
		$module=$sql_row['bac_no'];
		$section=$sql_row['bac_sec'];
		$date=$sql_row['bac_date'];
		$shift=$sql_row['bac_shift'];
		$qty=$sql_row['bac_Qty'];
		$lastup=$sql_row['bac_lastup'];
		$userstyle=$sql_row['bac_style'];
		$doc_no=$sql_row['ims_doc_no'];
		$ims_tid=$sql_row['ims_tid'];
		$ims_table_name=$sql_row['ims_table_name'];
		$log_time=$sql_row['log_time'];
		$smv=$sql_row['smv'];
		$nop=$sql_row['nop'];
		$schedules=$sql_row['delivery'];
		
		$s01=$sql_row['size_s01'];
		$s02=$sql_row['size_s02'];
		$s03=$sql_row['size_s03'];
		$s04=$sql_row['size_s04'];
		$s05=$sql_row['size_s05'];
		$s06=$sql_row['size_s06'];
		$s07=$sql_row['size_s07'];
		$s08=$sql_row['size_s08'];
		$s09=$sql_row['size_s09'];
		$s10=$sql_row['size_s10'];
		$s11=$sql_row['size_s11'];
		$s12=$sql_row['size_s12'];
		$s13=$sql_row['size_s13'];
		$s14=$sql_row['size_s14'];
		$s15=$sql_row['size_s15'];
		$s16=$sql_row['size_s16'];
		$s17=$sql_row['size_s17'];
		$s18=$sql_row['size_s18'];
		$s19=$sql_row['size_s19'];
		$s20=$sql_row['size_s20'];
		$s21=$sql_row['size_s21'];
		$s22=$sql_row['size_s22'];
		$s23=$sql_row['size_s23'];
		$s24=$sql_row['size_s24'];
		$s25=$sql_row['size_s25'];
		$s26=$sql_row['size_s26'];
		$s27=$sql_row['size_s27'];
		$s28=$sql_row['size_s28'];
		$s29=$sql_row['size_s29'];
		$s30=$sql_row['size_s30'];
		$s31=$sql_row['size_s31'];
		$s32=$sql_row['size_s32'];
		$s33=$sql_row['size_s33'];
		$s34=$sql_row['size_s34'];
		$s35=$sql_row['size_s35'];
		$s36=$sql_row['size_s36'];
		$s37=$sql_row['size_s37'];
		$s38=$sql_row['size_s38'];
		$s39=$sql_row['size_s39'];
		$s40=$sql_row['size_s40'];
		$s41=$sql_row['size_s41'];
		$s42=$sql_row['size_s42'];
		$s43=$sql_row['size_s43'];
		$s44=$sql_row['size_s44'];
		$s45=$sql_row['size_s45'];
		$s46=$sql_row['size_s46'];
		$s47=$sql_row['size_s47'];
		$s48=$sql_row['size_s48'];
		$s49=$sql_row['size_s49'];
		$s50=$sql_row['size_s50'];

		$input_job = $sql_row['jobno'];

		$sizes = array($s01,$s02,$s03,$s04,$s05,$s06,$s07,$s08,$s09,$s10,$s11,$s12,$s13,$s14,$s15, $s16,$s17, $s18,$s19, $s20, $s21,$s22,$s23, $s24,$s25, $s26,$s27, $s28,$s29, $s30,$s31, $s32,$s33, $s34,$s35,$s36,$s37, $s38, $s39,$s40, $s41,$s42,$s43, $s44,$s45, $s46,$s47,$s48, $s49, $s50);
		$filtered_sizes = array_filter($sizes);
		$title_sizes = array('title_size_s01','title_size_s02','title_size_s03','title_size_s04','title_size_s05','title_size_s06','title_size_s07', 'title_size_s08', 'title_size_s09', 'title_size_s10', 'title_size_s11','title_size_s12', 'title_size_s13','title_size_s14','title_size_s15', 'title_size_s16','title_size_s17', 'title_size_s18', 'title_size_s19','title_size_s20', 'title_size_s21','title_size_s22','title_size_s23', 'title_size_s24','title_size_s25','title_size_s26', 'title_size_s27','title_size_s28','title_size_s29', 'title_size_s30','title_size_s31','title_size_s32','title_size_s33','title_size_s34','title_size_s35','title_size_s36','title_size_s37','title_size_s38','title_size_s39','title_size_s40','title_size_s41','title_size_s42','title_size_s43','title_size_s44','title_size_s45','title_size_s46','title_size_s47','title_size_s48','title_size_s49','title_size_s50');

		$sql1="select * from $bai_pro3.plandoc_stat_log where doc_no=$doc_no";
		// echo $sql1."<br>";
		$sql_result2=mysqli_query($link, $sql1) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result2))
		{
			$order_tid=$sql_row1['order_tid'];
			$cutno=$sql_row1['acutno'];
		}
		
		if(mysqli_num_rows($sql_result2)==0){
			$sql1="select * from $bai_pro3.plandoc_stat_log_archive where doc_no=$doc_no";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$order_tid=$sql_row1['order_tid'];
				$cutno=$sql_row1['acutno'];
			}
		}
			
		//date:2012-06-26
		//added new code for getting data from archive table of orders
		$sql12="select order_style_no,order_del_no,order_col_des,color_code,style_id from $bai_pro3.bai_orders_db where order_del_no=\"".$schedules."\" and order_tid=\"".$order_tid."\"";
		// echo $sql12."<br>";
		$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_no_rows=mysqli_num_rows($sql_result12);
		
		$table="$bai_pro3.bai_orders_db";
		if($sql_no_rows == 0)
		{
			$table="$bai_pro3.bai_orders_db_archive";
		}
		
		$sql1="select order_style_no,order_del_no,order_col_des,color_code,style_id from $table where order_del_no=\"".$schedules."\" and order_tid=\"".$order_tid."\" ";
		//echo $sql1."<br>";

		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$style=$sql_row1['order_style_no'];
			$schedule=$sql_row1['order_del_no'];
			$color=$sql_row1['order_col_des'];
			$color_code=$sql_row1['color_code'];
			$style_id=$sql_row1['style_id'];
		}
		
		$bgcolor="";	
		if($smv==0 and $nop==0)
		{
			$bgcolor="WHITE";
		} 
		//var_dump($filtered_sizes);
		foreach( $filtered_sizes as $key => $value)
		{
			$finalized_size_qty = $value;
			$finalized_title_size = $title_sizes[$key];
			$getting_title_size = "select $finalized_title_size from $bai_pro3.bai_orders_db where order_del_no=\"".$schedules."\" and order_tid=\"".$order_tid."\"";
			// echo $getting_title_size;
			// mysqli_query($link11, $getting_title_size) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result001=mysqli_query($link, $getting_title_size) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_result_fetch = mysqli_fetch_array($sql_result001)){
				$finalized_title_size_value = $sql_result_fetch[$finalized_title_size];
			}
			// 

			$display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedules,$color,$input_job,$link);
			echo "<tbody><tr bgcolor=\"$bgcolor\">";
			$time = explode(" ",$log_time);
			//echo "<td>$tid</td>";
			echo "<td>$date</td>";
			echo "<td>".$time[1]."</td>";
			echo "<td>$module</td>";
			echo "<td>$section</td>";
			echo "<td>$shift</td>";
			echo "<td>$style_id</td>";
			echo "<td>$style</td>";
			echo "<td>".$schedules."</td>";
			echo "<td>$color</td>";
			echo "<td>".chr($color_code).leading_zeros($cutno,3)."</td>";
			echo "<td>$display_prefix1</td>";
			echo "<td>$finalized_title_size_value</td>";
			echo "<td>$finalized_size_qty</td>";
			echo "</tr></tbody>";
		}


	}
	echo "</table></div></div>";
}
else{
	echo "<div class='alert alert-danger' style='width:1000px';>No Data Found</div>";
	echo "<script>$(document).ready(function(){
			 $('#table1').css('display','none');
		 });</script>";
}
}
 
?>
<script>

	var table3Filters = {
	rows_counter: true,
	rows_counter_text: "Total rows: ",
	btn_reset: true,
	sort_select: true,
	display_all_text: "Display all"
	}
	setFilterGrid("table1",table3Filters);
	$('#reset_table1').addClass('btn btn-warning btn-xs');
	
</script>
<script language="javascript">

function getData(){
 var csv_value=$('#table1').table2CSV({delivery:'value'});
 $("#csv_text").val(csv_value);	
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

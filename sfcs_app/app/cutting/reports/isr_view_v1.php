<?php
ini_set('max_execution_time', 0); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/menu_content.php',1,'R'));
$table_csv = getFullURLLevel($_GET['r'],'common/js/table2CSV.js',1,'R');
$excel_form_action = getFullURL($_GET['r'],'export_excel1.php','R');
function get_size($table_name,$field,$compare,$key,$link)
{
	//GLOBAL $menu_table_name;
	//GLOBAL $link;
	$sql="select $field as result from $table_name where $compare='$key'";
	$sql_result=mysqli_query($link, $sql) or exit($sql."Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		return $sql_row['result'];
	}
	((mysqli_free_result($sql_result) || (is_object($sql_result) && (get_class($sql_result) == "mysqli_result"))) ? true : false);
}

?>
<!-- <script src="js/jquery-1.4.2.min.js"></script>
<script src="js/jquery-ui-1.8.1.custom.min.js"></script>
<script src="js/cal.js"></script>
<link href="js/calendar.css" rel="stylesheet" type="text/css" /> -->

<script type="text/javascript">

		function verify_date(){
		var val1 = $('#from_date').val();
		var val2 = $('#to_date').val();
	
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
/*body
{
	font-family:calibri;
	color:black;
}

 table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td.lef
{
	border: 1px solid black;
	text-align: left;
	white-space:nowrap; 
}
table th
{
	border: 1px solid black;
	text-align: center;
    background-color: BLUE;
	color: WHITE;
	white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
} */

</style>

<script type="text/javascript" src="<?php echo $table_csv ?>" ></script>	

<?php 
$from_date=$_POST['from_date'];
$to_date=$_POST['to_date'];
$section=$_POST['section'];
$shift=$_POST['shift'];
$reptype=$_POST['reptype'];
?>
<div class="panel panel-primary">
	<div class="panel-heading">Input Status Report</div>
	<div class="panel-body">
		<form class="form-inline" method="post" name="input" action="<?php echo "index.php?r=".$_GET['r']; ?>">
			<div class="form-group">
				<label>From Date:</label>
				<input type="text" class="form-control" data-toggle="datepicker" id="from_date" name="from_date" value="<?php if($from_date=="") {echo  date("Y-m-d"); } else {echo $from_date;}?>">
			</div>
			<div class="form-group">
				<label for="to">To Date:</label>
				<input type="text" class="form-control" data-toggle="datepicker" id="to_date" name="to_date" onchange="return verify_date();" value="<?php if($to_date=="") {echo  date("Y-m-d"); } else {echo $to_date;}?>">
			</div>
<!-- Section: <input type="text" name="section" size=12 value="">  
Section: <select name="section">
<option value='1,2,3,4' <?php if($section=="1,2,3,4"){ echo "selected"; } ?> >All</option>
<option value='1' <?php if($section=="1"){ echo "selected"; } ?>>Section - 1</option>
<option value='2' <?php if($section=="2"){ echo "selected"; } ?>>Section - 2</option>
<option value='3' <?php if($section=="3"){ echo "selected"; } ?>>Section - 3</option>
<option value='4' <?php if($section=="4"){ echo "selected"; } ?>>Section - 4</option>
</select>

Shift: <input type="text" name="shift" size=12 value=""> 

Shift: <select name="shift">
<option value="'A', 'B'" <?php if($shift=='"A", "B"'){ echo "selected"; } ?> >All</option>
<option value="'A'" <?php if($shift=='"A"'){ echo "selected"; } ?>>A</option>
<option value="'B'" <?php if($shift=='"B"'){ echo "selected"; } ?>>B</option>
</select>

Report: <select name="reptype">
<option value=1 <?php if($reptype==1){ echo "selected"; } ?> >Detailed</option>
<option value=2 <?php if($reptype==2){ echo "selected"; } ?>>Summary</option>
</select>
-->

			<button type="submit" id="submit" class="btn btn-primary" name="submit" onclick='return verify_date()'>Show</button>
		</form>
<?php
if(isset($_POST['submit']))
{
	
	$from_date=$_POST['from_date'];
	$to_date=$_POST['to_date'];
//	$from_date="2010-05-27";
//	$to_date="2010-05-27";
//	$section=$_POST['section'];
	//$shift=$_POST['shift'];
	//$reptype=$_POST['reptype'];

// echo "<span class='pull-right'><strong><a href=".getFullURL($_GET['r'],'isr_view_v1_excel.php','N')."&from_date=$from_date&to_date=$to_date class='btn btn-sm btn-success'>Export to Excel</a></strong></span>	";
	echo '<span class="pull-right">
			<form action="'.$excel_form_action.'" method ="post" > 
				<input type="hidden" name="csv_text" id="csv_text">
				<input class="btn btn-info btn-sm" type="submit" value="Export to Excel" onclick="getCSVData()">
			</form></span>
		';	
echo "<div class='col-sm-12' style='overflow-y:scroll;max-height:600px;'>";
	echo "<table class='table table-hover table-bordered'  id='report'>";
	echo "<tr class='danger'>";
	echo "<th>Date</th>";
	echo "<th>Style</th>";
	echo "<th>Schedule</th>";
	echo "<th>Color</th>";
	echo "<th>Module</th>";
	echo "<th>Docket</th>";
	echo "<th>Cut Job</th>";
	echo "<th>Input Job</th>";
	echo "<th>Size</th>";
	echo "<th>Quantity</th>";
	echo "</tr>";
	
	//$sql="select ims_date,ims_doc_no,ims_mod_no,ims_shift,ims_size,ims_qty,ims_style,ims_schedule,ims_color from ims_log where ims_date between \"$from_date\" and \"$to_date\"and ims_mod_no>0 group by ims_style,ims_schedule,ims_color,ims_doc_no,ims_mod_no,ims_shift,ims_size,ims_date";
	
	//sql="select ims_date,ims_doc_no,ims_mod_no,ims_shift,ims_size,ims_qty,ims_style,ims_schedule,ims_color from ims_log where ims_date between \"$from_date\" and \"$to_date\" and ims_mod_no>0 ORDER BY ims_style,ims_schedule,ims_color,ims_doc_no,ims_mod_no,ims_shift,ims_size,ims_date";  
	$sql="select ims_date,ims_doc_no,ims_mod_no,ims_shift,ims_size,ims_qty,ims_style,ims_schedule,ims_color,input_job_no_ref from $bai_pro3.ims_log where ims_date between \"$from_date\" and \"$to_date\"and ims_mod_no>0 order by ims_date DESC,ims_style,ims_schedule,ims_color,ims_doc_no,ims_mod_no,ims_shift,ims_size";
	//group by changed as a order by - Changed By Chathuranga
 	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		echo "<tr>";
		echo "<td>".$sql_row['ims_date']."</td>";
		echo "<td>".$sql_row['ims_style']."</td>";
		echo "<td>".$sql_row['ims_schedule']."</td>";
		echo "<td>".$sql_row['ims_color']."</td>";
		echo "<td>".$sql_row['ims_mod_no']."</td>";
		echo "<td>".$sql_row['ims_doc_no']."</td>";
		
		$sql111="select order_div from $bai_pro3.bai_orders_db where order_del_no=".$sql_row['ims_schedule'];
		//echo $sql1;
	 	$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error Buyer Divisionsss".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row111=mysqli_fetch_array($sql_result111))
		{						
			$division=$sql_row111['order_div'];
		}
		
		//$size_db_base=array("a_xs","a_s","a_m","a_l","a_xl","a_xxl","a_xxxl","a_s06","a_s08","a_s10","a_s12","a_s14","a_s16","a_s18","a_s20","a_s22","a_s24","a_s26","a_s28","a_s30");
		$size_db_base=array("a_xs","a_s","a_m","a_l","a_xl","a_xxl","a_xxxl","a_s01","a_s02","a_s03","a_s04","a_s05","a_s06","a_s07","a_s08","a_s09","a_s10","a_s11","a_s12","a_s13","a_s14","a_s15","a_s16","a_s17","a_s18","a_s19","a_s20","a_s21","a_s22","a_s23","a_s24","a_s25","a_s26","a_s27","a_s28","a_s29","a_s30","a_s31","a_s32","a_s33","a_s34","a_s35","a_s36","a_s37","a_s38","a_s39","a_s40","a_s41","a_s42","a_s43","a_s44","a_s45","a_s46","a_s47","a_s48","a_s49","a_s50");
		$sql1="select color_code,acutno,order_div from $bai_pro3.plandoc_stat_log_cat_log_ref where doc_no=".$sql_row['ims_doc_no'];
		//echo $sql1;
	 	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			echo "<td>".chr($sql_row1['color_code']).leading_zeros($sql_row1['acutno'],3)."</td>";			
			//$division=$sql_row1['order_div'];			
		}
				
		//********************************* Edited by chathuranga
		$xs="xs";
		$s="s";
		$m="m";
		$l="l";
		$xl="xl";
		$xxl="xxl";
		$xxxl="xxxl";
		$s01="01";
		$s02="02";
		$s03="03";
		$s04="04";
		$s05="05";
		$s06="06";
		$s07="07";
		$s08="08";
		$s09="09";
		$s10="10";
		$s11="11";
		$s12="12";
		$s13="13";
		$s14="14";
		$s15="15";
		$s16="16";
		$s17="17";
		$s18="18";
		$s19="19";
		$s20="20";
		$s21="21";
		$s22="22";
		$s23="23";
		$s24="24";
		$s25="25";
		$s26="26";
		$s27="27";
		$s28="28";
		$s29="29";
		$s30="30";
		$s31="31";
		$s32="32";
		$s33="33";
		$s34="34";
		$s35="35";
		$s36="36";
		$s37="37";
		$s38="38";
		$s39="39";
		$s40="40";
		$s41="41";
		$s42="42";
		$s43="43";
		$s44="44";
		$s45="45";
		$s46="46";
		$s47="47";
		$s48="48";
		$s49="49";
		$s50="50";

		
		
		
$div=trim($division);
//echo $div;
$sql3311="SELECT * FROM $bai_pro3.tbl_size_lable WHERE tbl_size_lable.buyer_devision=\"$div\" ";
//echo $sql3311;
	mysqli_query($link, $sql3311) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result3311=mysqli_query($link, $sql3311) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row3311=mysqli_fetch_array($sql_result3311))
	{
		$test_buyer=$sql_row3311['buyer_devision'];
		
		$xs="a_".strtolower($sql_row3311['xs']);
		$s="a_".strtolower($sql_row3311['s']);
		$m="a_".strtolower($sql_row3311['m']);
		$l="a_".strtolower($sql_row3311['l']);
		$xl="a_".strtolower($sql_row3311['xl']);
		$xxl="a_".strtolower($sql_row3311['xxl']);
		$xxxl="a_".strtolower($sql_row3311['xxxl']);
		$s01="a_".strtolower($sql_row3311['s01']);
		$s02="a_".strtolower($sql_row3311['s02']);
		$s03="a_".strtolower($sql_row3311['s03']);
		$s04="a_".strtolower($sql_row3311['s04']);
		$s05="a_".strtolower($sql_row3311['s05']);
		$s06="a_".strtolower($sql_row3311['s06']);
		$s07="a_".strtolower($sql_row3311['s07']);
		$s08="a_".strtolower($sql_row3311['s08']);
		$s09="a_".strtolower($sql_row3311['s09']);
		$s10="a_".strtolower($sql_row3311['s10']);
		$s11="a_".strtolower($sql_row3311['s11']);
		$s12="a_".strtolower($sql_row3311['s12']);
		$s13="a_".strtolower($sql_row3311['s13']);
		$s14="a_".strtolower($sql_row3311['s14']);
		$s15="a_".strtolower($sql_row3311['s15']);
		$s16="a_".strtolower($sql_row3311['s16']);
		$s17="a_".strtolower($sql_row3311['s17']);
		$s18="a_".strtolower($sql_row3311['s18']);
		$s19="a_".strtolower($sql_row3311['s19']);
		$s20="a_".strtolower($sql_row3311['s20']);
		$s21="a_".strtolower($sql_row3311['s21']);
		$s22="a_".strtolower($sql_row3311['s22']);
		$s23="a_".strtolower($sql_row3311['s23']);
		$s24="a_".strtolower($sql_row3311['s24']);
		$s25="a_".strtolower($sql_row3311['s25']);
		$s26="a_".strtolower($sql_row3311['s26']);
		$s27="a_".strtolower($sql_row3311['s27']);
		$s28="a_".strtolower($sql_row3311['s28']);
		$s29="a_".strtolower($sql_row3311['s29']);
		$s30="a_".strtolower($sql_row3311['s30']);
		$s31="a_".strtolower($sql_row3311['s31']);
		$s32="a_".strtolower($sql_row3311['s32']);
		$s33="a_".strtolower($sql_row3311['s33']);
		$s34="a_".strtolower($sql_row3311['s34']);
		$s35="a_".strtolower($sql_row3311['s35']);
		$s36="a_".strtolower($sql_row3311['s36']);
		$s37="a_".strtolower($sql_row3311['s37']);
		$s38="a_".strtolower($sql_row3311['s38']);
		$s39="a_".strtolower($sql_row3311['s39']);
		$s40="a_".strtolower($sql_row3311['s40']);
		$s41="a_".strtolower($sql_row3311['s41']);
		$s42="a_".strtolower($sql_row3311['s42']);
		$s43="a_".strtolower($sql_row3311['s43']);
		$s44="a_".strtolower($sql_row3311['s44']);
		$s45="a_".strtolower($sql_row3311['s45']);
		$s46="a_".strtolower($sql_row3311['s46']);
		$s47="a_".strtolower($sql_row3311['s47']);
		$s48="a_".strtolower($sql_row3311['s48']);
		$s49="a_".strtolower($sql_row3311['s49']);
		$s50="a_".strtolower($sql_row3311['s50']);

		
		//$size_db_base2=array($xs,$s,$m,$l,$xl,$xxl,$xxxl,$s06,$s08,$s10,$s12,$s14,$s16,$s18,$s20,$s22,$s24,$s26,$s28,$s30);  // implemented by chathuranga
		$size_db_base2=array($xs,$s,$m,$l,$xl,$xxl,$xxxl,$s01,$s02,$s03,$s04,$s05,$s06,$s07,$s08,$s09,$s10,$s11,$s12,$s13,$s14,$s15,$s16,$s17,$s18,$s19,$s20,$s21,$s22,$s23,$s24,$s25,$s26,$s27,$s28,$s29,$s30,$s31,$s32,$s33,$s34,$s35,$s36,$s37,$s38,$s39,$s40,$s41,$s42,$s43,$s44,$s45,$s46,$s47,$s48,$s49,$s50);
	}
	
		if(mysqli_num_rows($sql_result1)==0)
		{
			echo "<td></td>";
		}
		//echo $sql_row['ims_size'];
		//echo sizeof($size_db_base);
		$scode= str_replace("a_","",$sql_row['ims_size']);
		//echo $AAA;
		//echo strtoupper(str_replace("a_","",$size_db_base[$AAA]));
		//echo "<td>'".strtoupper(str_replace("a_","",$size_db[array_search($sql_row['ims_size'],$size_db_base)]))."</td>";
		
		
		echo "<td>J".leading_zeros($sql_row['input_job_no_ref'],3)."</td>";
		$act_size=get_size("$bai_pro3.bai_orders_db_confirm","title_size_".$scode."","order_del_no='".$sql_row['ims_schedule']."' and order_col_des",$sql_row['ims_color'],$link);
	//	echo $act_size."<br>";
		echo "<td>".strtoupper($act_size)."</td>";		
		echo "<td>".$sql_row['ims_qty']."</td>";
		echo "</tr>";
	}
	
	//$sql="select ims_date,ims_doc_no,ims_mod_no,ims_shift,ims_size,ims_qty,ims_style,ims_schedule,ims_color from ims_log_backup where ims_date between \"$from_date\" and \"$to_date\"and ims_mod_no>0 group by ims_style,ims_schedule,ims_color,ims_doc_no,ims_mod_no,ims_shift,ims_size,ims_date";
	
	$sql="select ims_date,ims_doc_no,ims_mod_no,ims_shift,ims_size,ims_qty,ims_style,ims_schedule,ims_color,input_job_no_ref from $bai_pro3.ims_log_backup where ims_date between \"$from_date\" and \"$to_date\"and ims_mod_no>0 order by ims_style,ims_schedule,ims_color,ims_doc_no,ims_mod_no,ims_shift,ims_size,ims_date";
	//group by changed as a order by - Changed By Chathuranga
 	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		echo "<tr>";
		echo "<td>".$sql_row['ims_date']."</td>";
		echo "<td>".$sql_row['ims_style']."</td>";
		echo "<td>".$sql_row['ims_schedule']."</td>";
		echo "<td>".$sql_row['ims_color']."</td>";
		echo "<td>".$sql_row['ims_mod_no']."</td>";
		echo "<td>".$sql_row['ims_doc_no']."</td>";
		
		//$size_db=array("a_xs","a_s","a_m","a_l","a_xl","a_xxl","a_xxxl","a_s06","a_s08","a_s10","a_s12","a_s14","a_s16","a_s18","a_s20","a_s22","a_s24","a_s26","a_s28","a_s30");
		$size_db=$size_db_base;
		
		$sql111="select order_div from $bai_pro3.bai_orders_db where order_del_no=".$sql_row['ims_schedule'];
		//echo $sql1;
	 	$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error Buyer Divisions111".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row111=mysqli_fetch_array($sql_result111))
		{						
			$division=$sql_row111['order_div'];
		}

		$sql1="select color_code,acutno,order_div from $bai_pro3.plandoc_stat_log_cat_log_ref where doc_no=".$sql_row['ims_doc_no'];
		//echo $sql1;
	 	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			echo "<td>".chr($sql_row1['color_code']).leading_zeros($sql_row1['acutno'],3)."</td>";
			
			//$division=$sql_row1['order_div'];
			
		
		}
		
		//********************************* Edited by chathuranga
	
		$xs="xs";
		$s="s";
		$m="m";
		$l="l";
		$xl="xl";
		$xxl="xxl";
		$xxxl="xxxl";
		$s01="01";
		$s02="02";
		$s03="03";
		$s04="04";
		$s05="05";
		$s06="06";
		$s07="07";
		$s08="08";
		$s09="09";
		$s10="10";
		$s11="11";
		$s12="12";
		$s13="13";
		$s14="14";
		$s15="15";
		$s16="16";
		$s17="17";
		$s18="18";
		$s19="19";
		$s20="20";
		$s21="21";
		$s22="22";
		$s23="23";
		$s24="24";
		$s25="25";
		$s26="26";
		$s27="27";
		$s28="28";
		$s29="29";
		$s30="30";
		$s31="31";
		$s32="32";
		$s33="33";
		$s34="34";
		$s35="35";
		$s36="36";
		$s37="37";
		$s38="38";
		$s39="39";
		$s40="40";
		$s41="41";
		$s42="42";
		$s43="43";
		$s44="44";
		$s45="45";
		$s46="46";
		$s47="47";
		$s48="48";
		$s49="49";
		$s50="50";
		
$div=trim($division);
//echo $div;
$sql3311="SELECT * FROM $bai_pro3.tbl_size_lable WHERE tbl_size_lable.buyer_devision=\"$div\"";
	mysqli_query($link, $sql3311) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result3311=mysqli_query($link, $sql3311) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row3311=mysqli_fetch_array($sql_result3311))
	{
		
		$xs="a_".strtolower($sql_row3311['xs']);
		$s="a_".strtolower($sql_row3311['s']);
		$m="a_".strtolower($sql_row3311['m']);
		$l="a_".strtolower($sql_row3311['l']);
		$xl="a_".strtolower($sql_row3311['xl']);
		$xxl="a_".strtolower($sql_row3311['xxl']);
		$xxxl="a_".strtolower($sql_row3311['xxxl']);
		$s01="a_".strtolower($sql_row3311['s01']);
		$s02="a_".strtolower($sql_row3311['s02']);
		$s03="a_".strtolower($sql_row3311['s03']);
		$s04="a_".strtolower($sql_row3311['s04']);
		$s05="a_".strtolower($sql_row3311['s05']);
		$s06="a_".strtolower($sql_row3311['s06']);
		$s07="a_".strtolower($sql_row3311['s07']);
		$s08="a_".strtolower($sql_row3311['s08']);
		$s09="a_".strtolower($sql_row3311['s09']);
		$s10="a_".strtolower($sql_row3311['s10']);
		$s11="a_".strtolower($sql_row3311['s11']);
		$s12="a_".strtolower($sql_row3311['s12']);
		$s13="a_".strtolower($sql_row3311['s13']);
		$s14="a_".strtolower($sql_row3311['s14']);
		$s15="a_".strtolower($sql_row3311['s15']);
		$s16="a_".strtolower($sql_row3311['s16']);
		$s17="a_".strtolower($sql_row3311['s17']);
		$s18="a_".strtolower($sql_row3311['s18']);
		$s19="a_".strtolower($sql_row3311['s19']);
		$s20="a_".strtolower($sql_row3311['s20']);
		$s21="a_".strtolower($sql_row3311['s21']);
		$s22="a_".strtolower($sql_row3311['s22']);
		$s23="a_".strtolower($sql_row3311['s23']);
		$s24="a_".strtolower($sql_row3311['s24']);
		$s25="a_".strtolower($sql_row3311['s25']);
		$s26="a_".strtolower($sql_row3311['s26']);
		$s27="a_".strtolower($sql_row3311['s27']);
		$s28="a_".strtolower($sql_row3311['s28']);
		$s29="a_".strtolower($sql_row3311['s29']);
		$s30="a_".strtolower($sql_row3311['s30']);
		$s31="a_".strtolower($sql_row3311['s31']);
		$s32="a_".strtolower($sql_row3311['s32']);
		$s33="a_".strtolower($sql_row3311['s33']);
		$s34="a_".strtolower($sql_row3311['s34']);
		$s35="a_".strtolower($sql_row3311['s35']);
		$s36="a_".strtolower($sql_row3311['s36']);
		$s37="a_".strtolower($sql_row3311['s37']);
		$s38="a_".strtolower($sql_row3311['s38']);
		$s39="a_".strtolower($sql_row3311['s39']);
		$s40="a_".strtolower($sql_row3311['s40']);
		$s41="a_".strtolower($sql_row3311['s41']);
		$s42="a_".strtolower($sql_row3311['s42']);
		$s43="a_".strtolower($sql_row3311['s43']);
		$s44="a_".strtolower($sql_row3311['s44']);
		$s45="a_".strtolower($sql_row3311['s45']);
		$s46="a_".strtolower($sql_row3311['s46']);
		$s47="a_".strtolower($sql_row3311['s47']);
		$s48="a_".strtolower($sql_row3311['s48']);
		$s49="a_".strtolower($sql_row3311['s49']);
		$s50="a_".strtolower($sql_row3311['s50']);
		
		//$size_db_base=array($xs,$s,$m,$l,$xl,$xxl,$xxxl,$s06,$s08,$s10,$s12,$s14,$s16,$s18,$s20,$s22,$s24,$s26,$s28,$s30);  // implemented by chathuranga
		$size_db_base=array($xs,$s,$m,$l,$xl,$xxl,$xxxl,$s01,$s02,$s03,$s04,$s05,$s06,$s07,$s08,$s09,$s10,$s11,$s12,$s13,$s14,$s15,$s16,$s17,$s18,$s19,$s20,$s21,$s22,$s23,$s24,$s25,$s26,$s27,$s28,$s29,$s30,$s31,$s32,$s33,$s34,$s35,$s36,$s37,$s38,$s39,$s40,$s41,$s42,$s43,$s44,$s45,$s46,$s47,$s48,$s49,$s50);
	}
		//$size_db_actual=array("a_xs","a_s","a_m","a_l","a_xl","a_xxl","a_xxxl","a_s06","a_s08","a_s10","a_s12","a_s14","a_s16","a_s18","a_s20","a_s22","a_s24","a_s26","a_s28","a_s30");
		$size_db_actual=array("a_xs","a_s","a_m","a_l","a_xl","a_xxl","a_xxxl","a_s01","a_s02","a_s03","a_s04","a_s05","a_s06","a_s07","a_s08","a_s09","a_s10","a_s11","a_s12","a_s13","a_s14","a_s15","a_s16","a_s17","a_s18","a_s19","a_s20","a_s21","a_s22","a_s23","a_s24","a_s25","a_s26","a_s27","a_s28","a_s29","a_s30","a_s31","a_s32","a_s33","a_s34","a_s35","a_s36","a_s37","a_s38","a_s39","a_s40","a_s41","a_s42","a_s43","a_s44","a_s45","a_s46","a_s47","a_s48","a_s49","a_s50");
		
		//$size_db_base10=array("a_xs","a_s","a_m","a_l","a_xl","a_xxl","a_xxxl","a_s06","a_s08","a_s10","a_s12","a_s14","a_s16","a_s18","a_s20","a_s22","a_s24","a_s26","a_s28","a_s30");
		
		if(mysqli_num_rows($sql_result1)==0)
		{
			echo "<td></td>";
		}
		echo "<td>J".leading_zeros($sql_row['input_job_no_ref'],3)."</td>";
		$scode= str_replace("a_","",$sql_row['ims_size']);
		//$AAA=$size_db_base[array_search($sql_row12['ims_size'],$size_db_actual)];
		$act_size=get_size("$bai_pro3.bai_orders_db_confirm","title_size_".$scode."","order_del_no='".$sql_row['ims_schedule']."' and order_col_des",$sql_row['ims_color'],$link);
		echo "<td>".strtoupper($act_size)."</td>";
		//echo "<td>'".strtoupper(str_replace("a_","",$size_db[array_search($sql_row['ims_size'],$size_db_base)]))."</td>";
		echo "<td>".$sql_row['ims_qty']."</td>";
		echo "</tr>";
	}
	
	echo "</table>
	</div>";
}
?>
</div>
</div>
<script>
function getCSVData(){
 var csv_value=$('#report').table2CSV({delivery:'value'});
 $("#csv_text").val(csv_value);	
}
</script>
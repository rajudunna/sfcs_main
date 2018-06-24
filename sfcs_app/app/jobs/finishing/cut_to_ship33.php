<html>
<head>

<?php  
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');

error_reporting(0);
$cache_date="previous_week";
$cachefile = $cache_date."html";

/* if (file_exists($cachefile)) {

	include($cachefile);

	exit;

} */
ob_start();
?>

<script type="text/javascript" src="/sfcs_app/common/js/jquery.min.js" ></script>

<script type="text/javascript" src="/sfcs_app/common/js/table2CSV.js" ></script>

<script>
	function downloadFile(fileName, urlData) {
	    var aLink = document.createElement('a');
	    aLink.download = fileName;
	    aLink.href = urlData;
	    var event = new MouseEvent('click');
	    aLink.dispatchEvent(event);
	   }
	function getCSVData() {
		var data = $('#example').table2CSV({delivery: 'value',filename: 'previous_week.csv'});
        downloadFile('previous_week.csv', 'data:text/csv;charset=UTF-8,' + encodeURIComponent(data));

	}
</script>
<style>
body
{
	font-family:calibri;
	font-size:12px;
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
}


}

}
</style>


</head>
<body>
<div class="panel panel-primary">
<div class="panel-heading"></diV>
<div class="panel-body">
<?php

// $username_list=explode('\\',$_SERVER['REMOTE_USER']);
// $username=strtolower($username_list[1]);



// if(in_array($username,$author_id_db))


//if(isset($_POST['filter']) or isset($_POST['filter2']))
{
	
	$start_date_w=time();
	
	while((date("N",$start_date_w))!=1) {
	$start_date_w=$start_date_w-(60*60*24); // define monday
	}
	$end_date_w=$start_date_w+(60*60*24*6); // define sunday 

	$start_date_w=date("Y-m-d",$start_date_w);
	$end_date_w=date("Y-m-d",$end_date_w);
	
	$sdate=date("Y-m-d",strtotime("-7 days",strtotime($start_date_w)));
	$edate=date("Y-m-d",strtotime("-7 days",strtotime($end_date_w)));
	
	//$sdate="2012-11-26";
	//$edate="2012-12-01";
	
	echo "<h2><b>LU:".date("Y-m-d H:i:s")."</b></h2>";
	echo '<form action="export_excel1.php" method ="post" > 
<input type="hidden" name="csv_text" id="csv_text">
<input type="button" class="btn btn-xs btn-success" value="Export to Excel" onclick="getCSVData()">
</form>';
	echo "<div  class=\"table-responsive\"><table id=\"example\" table align=\"left\" class=\"table table-bordered\">";
	echo "<tr>
	<th>Division</th>
	<th>FG Status</th>
	<th>Ex-Factory</th>
	<th>Style</th>
	<th>Schedule</th>
	<th>Color</th>
	<th>Section</th>
	<th>Size</th>
	<th>Total Order <br/>Quantity</th>
	<th>Total Cut <br/>Quantity</th>
	<th>Total Input <br/>Quantity</th>
	<th>Total Sewing Out <br/>Quantity</th>
	<th>Total FG <br/>Quantity</th>
	<th>Total FCA <br/>Quantity</th>";
	//echo "<th>Total MCA <br/>Quantity</th>";
	
	echo "<th>Total Shipped <br/>Quantity</th>
	<th>Rejected <br/>Quantity</th>
	<th>Sample <br/>Quantity</th>
	<th>Good Panel <br/>Quantity</th>
	<th>Out of Ratio <br/>Quantity</th>
	<th>Total Missing<br/>Panels</th>
	<th class=\"total\">Sewing <br/>Missing</th>
	<th class=\"total\">Panel Room <br/>Missing</th>
	<th class=\"total\">Cutting <br/>Missing</th>
</tr>";
	
	// if(isset($_POST['filter2']))
	// {
	// 	$sch_db=$_POST['schedule'];
	// 	$sql="select style,schedule_no,color,ssc_code_new,priority,buyer_division,ex_factory_date_new,sections from bai_pro4.bai_cut_to_ship_ref where schedule_no=\"$sch_db\" order by ex_factory_date_new";
	// }
	// else
	// {
		$sql="select style,schedule_no,color,ssc_code_new,priority,buyer_division,ex_factory_date_new,sections from $bai_pro4.bai_cut_to_ship_ref where ex_factory_date_new between \"$sdate\" and \"$edate\" order by ex_factory_date_new";
	// }
	//echo $sql;	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
			$status=$sql_row['priority'];
			$ssc_code_new=$sql_row['ssc_code_new'];
			$order_qtys=array();
			$out_qtys=array();
			
			$sizes_db=array("XS","S","M","L","XL","XXL","XXXL","s01","s02","s03","s04","s05","s06","s07","s08","s09","s10","s11","s12","s13","s14","s15","s16","s17","s18","s19","s20","s21","s22","s23","s24","s25","s26","s27","s28","s29","s30","s31","s32","s33","s34","s35","s36","s37","s38","s39","s40","s41","s42","s43","s44","s45","s46","s47","s48","s49","s50");
			
			$sql1="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"".$sql_row['style']."\" and order_del_no=\"".$sql_row['schedule_no']."\" and order_col_des=\"".$sql_row['color']."\"";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$order_qtys[]=$sql_row1['order_s_xs'];
				$order_qtys[]=$sql_row1['order_s_s'];
				$order_qtys[]=$sql_row1['order_s_m'];
				$order_qtys[]=$sql_row1['order_s_l'];
				$order_qtys[]=$sql_row1['order_s_xl'];
				$order_qtys[]=$sql_row1['order_s_xxl'];
				$order_qtys[]=$sql_row1['order_s_xxxl'];
				$order_qtys[]=$sql_row1['order_s_s01'];
				$order_qtys[]=$sql_row1['order_s_s02'];
				$order_qtys[]=$sql_row1['order_s_s03'];
				$order_qtys[]=$sql_row1['order_s_s04'];
				$order_qtys[]=$sql_row1['order_s_s05'];
				$order_qtys[]=$sql_row1['order_s_s06'];
				$order_qtys[]=$sql_row1['order_s_s07'];
				$order_qtys[]=$sql_row1['order_s_s08'];
				$order_qtys[]=$sql_row1['order_s_s09'];
				$order_qtys[]=$sql_row1['order_s_s10'];
				$order_qtys[]=$sql_row1['order_s_s11'];
				$order_qtys[]=$sql_row1['order_s_s12'];
				$order_qtys[]=$sql_row1['order_s_s13'];
				$order_qtys[]=$sql_row1['order_s_s14'];
				$order_qtys[]=$sql_row1['order_s_s15'];
				$order_qtys[]=$sql_row1['order_s_s16'];
				$order_qtys[]=$sql_row1['order_s_s17'];
				$order_qtys[]=$sql_row1['order_s_s18'];
				$order_qtys[]=$sql_row1['order_s_s19'];
				$order_qtys[]=$sql_row1['order_s_s20'];
				$order_qtys[]=$sql_row1['order_s_s21'];
				$order_qtys[]=$sql_row1['order_s_s22'];
				$order_qtys[]=$sql_row1['order_s_s23'];
				$order_qtys[]=$sql_row1['order_s_s24'];
				$order_qtys[]=$sql_row1['order_s_s25'];
				$order_qtys[]=$sql_row1['order_s_s26'];
				$order_qtys[]=$sql_row1['order_s_s27'];
				$order_qtys[]=$sql_row1['order_s_s28'];
				$order_qtys[]=$sql_row1['order_s_s29'];
				$order_qtys[]=$sql_row1['order_s_s30'];
				$order_qtys[]=$sql_row1['order_s_s31'];
				$order_qtys[]=$sql_row1['order_s_s32'];
				$order_qtys[]=$sql_row1['order_s_s33'];
				$order_qtys[]=$sql_row1['order_s_s34'];
				$order_qtys[]=$sql_row1['order_s_s35'];
				$order_qtys[]=$sql_row1['order_s_s36'];
				$order_qtys[]=$sql_row1['order_s_s37'];
				$order_qtys[]=$sql_row1['order_s_s38'];
				$order_qtys[]=$sql_row1['order_s_s39'];
				$order_qtys[]=$sql_row1['order_s_s40'];
				$order_qtys[]=$sql_row1['order_s_s41'];
				$order_qtys[]=$sql_row1['order_s_s42'];
				$order_qtys[]=$sql_row1['order_s_s43'];
				$order_qtys[]=$sql_row1['order_s_s44'];
				$order_qtys[]=$sql_row1['order_s_s45'];
				$order_qtys[]=$sql_row1['order_s_s46'];
				$order_qtys[]=$sql_row1['order_s_s47'];
				$order_qtys[]=$sql_row1['order_s_s48'];
				$order_qtys[]=$sql_row1['order_s_s49'];
				$order_qtys[]=$sql_row1['order_s_s50'];
				$order_tid=$sql_row1['order_tid'];
				$schedule=$sql_row1['order_del_no'];
				$color=$sql_row1['order_col_des'];
				$style=$sql_row1['order_style_no'];
			}
			
			
			$sql2="select bac_sec, coalesce(sum(bac_Qty),0) as \"qty\", coalesce(sum(size_xs),0) as \"size_xs\", coalesce(sum(size_s),0) as \"size_s\", coalesce(sum(size_m),0) as \"size_m\", coalesce(sum(size_l),0) as \"size_l\", coalesce(sum(size_xl),0) as \"size_xl\", coalesce(sum(size_xxl),0) as \"size_xxl\", coalesce(sum(size_xxxl),0) as \"size_xxxl\", coalesce(sum(size_s01),0) as \"size_s01\", coalesce(sum(size_s02),0) as \"size_s02\", coalesce(sum(size_s03),0) as \"size_s03\", coalesce(sum(size_s04),0) as \"size_s04\", coalesce(sum(size_s05),0) as \"size_s05\", coalesce(sum(size_s06),0) as \"size_s06\", coalesce(sum(size_s07),0) as \"size_s07\", coalesce(sum(size_s08),0) as \"size_s08\", coalesce(sum(size_s09),0) as \"size_s09\", coalesce(sum(size_s10),0) as \"size_s10\", coalesce(sum(size_s11),0) as \"size_s11\", coalesce(sum(size_s12),0) as \"size_s12\", coalesce(sum(size_s13),0) as \"size_s13\", coalesce(sum(size_s14),0) as \"size_s14\", coalesce(sum(size_s15),0) as \"size_s15\", coalesce(sum(size_s16),0) as \"size_s16\", coalesce(sum(size_s17),0) as \"size_s17\", coalesce(sum(size_s18),0) as \"size_s18\", coalesce(sum(size_s19),0) as \"size_s19\", coalesce(sum(size_s20),0) as \"size_s20\", coalesce(sum(size_s21),0) as \"size_s21\", coalesce(sum(size_s22),0) as \"size_s22\", coalesce(sum(size_s23),0) as \"size_s23\", coalesce(sum(size_s24),0) as \"size_s24\", coalesce(sum(size_s25),0) as \"size_s25\", coalesce(sum(size_s26),0) as \"size_s26\", coalesce(sum(size_s27),0) as \"size_s27\", coalesce(sum(size_s28),0) as \"size_s28\", coalesce(sum(size_s29),0) as \"size_s29\", coalesce(sum(size_s30),0) as \"size_s30\", coalesce(sum(size_s31),0) as \"size_s31\", coalesce(sum(size_s32),0) as \"size_s32\", coalesce(sum(size_s33),0) as \"size_s33\", coalesce(sum(size_s34),0) as \"size_s34\", coalesce(sum(size_s35),0) as \"size_s35\", coalesce(sum(size_s36),0) as \"size_s36\", coalesce(sum(size_s37),0) as \"size_s37\", coalesce(sum(size_s38),0) as \"size_s38\", coalesce(sum(size_s39),0) as \"size_s39\", coalesce(sum(size_s40),0) as \"size_s40\", coalesce(sum(size_s41),0) as \"size_s41\", coalesce(sum(size_s42),0) as \"size_s42\", coalesce(sum(size_s43),0) as \"size_s43\", coalesce(sum(size_s44),0) as \"size_s44\", coalesce(sum(size_s45),0) as \"size_s45\", coalesce(sum(size_s46),0) as \"size_s46\", coalesce(sum(size_s47),0) as \"size_s47\", coalesce(sum(size_s48),0) as \"size_s48\", coalesce(sum(size_s49),0) as \"size_s49\", coalesce(sum(size_s50),0) as \"size_s50\" from $bai_pro.bai_log_buf where delivery=\"".$sql_row['schedule_no']."\" and color=\"".$color."\"";
			//echo $sql2."<br/>";
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$out_qtys[]=$sql_row2['size_xs'];
				$out_qtys[]=$sql_row2['size_s'];
				$out_qtys[]=$sql_row2['size_m'];
				$out_qtys[]=$sql_row2['size_l'];
				$out_qtys[]=$sql_row2['size_xl'];
				$out_qtys[]=$sql_row2['size_xxl'];
				$out_qtys[]=$sql_row2['size_xxxl'];
				$out_qtys[]=$sql_row2['size_s01'];
				$out_qtys[]=$sql_row2['size_s02'];
				$out_qtys[]=$sql_row2['size_s03'];
				$out_qtys[]=$sql_row2['size_s04'];
				$out_qtys[]=$sql_row2['size_s05'];
				$out_qtys[]=$sql_row2['size_s06'];
				$out_qtys[]=$sql_row2['size_s07'];
				$out_qtys[]=$sql_row2['size_s08'];
				$out_qtys[]=$sql_row2['size_s09'];
				$out_qtys[]=$sql_row2['size_s10'];
				$out_qtys[]=$sql_row2['size_s11'];
				$out_qtys[]=$sql_row2['size_s12'];
				$out_qtys[]=$sql_row2['size_s13'];
				$out_qtys[]=$sql_row2['size_s14'];
				$out_qtys[]=$sql_row2['size_s15'];
				$out_qtys[]=$sql_row2['size_s16'];
				$out_qtys[]=$sql_row2['size_s17'];
				$out_qtys[]=$sql_row2['size_s18'];
				$out_qtys[]=$sql_row2['size_s19'];
				$out_qtys[]=$sql_row2['size_s20'];
				$out_qtys[]=$sql_row2['size_s21'];
				$out_qtys[]=$sql_row2['size_s22'];
				$out_qtys[]=$sql_row2['size_s23'];
				$out_qtys[]=$sql_row2['size_s24'];
				$out_qtys[]=$sql_row2['size_s25'];
				$out_qtys[]=$sql_row2['size_s26'];
				$out_qtys[]=$sql_row2['size_s27'];
				$out_qtys[]=$sql_row2['size_s28'];
				$out_qtys[]=$sql_row2['size_s29'];
				$out_qtys[]=$sql_row2['size_s30'];
				$out_qtys[]=$sql_row2['size_s31'];
				$out_qtys[]=$sql_row2['size_s32'];
				$out_qtys[]=$sql_row2['size_s33'];
				$out_qtys[]=$sql_row2['size_s34'];
				$out_qtys[]=$sql_row2['size_s35'];
				$out_qtys[]=$sql_row2['size_s36'];
				$out_qtys[]=$sql_row2['size_s37'];
				$out_qtys[]=$sql_row2['size_s38'];
				$out_qtys[]=$sql_row2['size_s39'];
				$out_qtys[]=$sql_row2['size_s40'];
				$out_qtys[]=$sql_row2['size_s41'];
				$out_qtys[]=$sql_row2['size_s42'];
				$out_qtys[]=$sql_row2['size_s43'];
				$out_qtys[]=$sql_row2['size_s44'];
				$out_qtys[]=$sql_row2['size_s45'];
				$out_qtys[]=$sql_row2['size_s46'];
				$out_qtys[]=$sql_row2['size_s47'];
				$out_qtys[]=$sql_row2['size_s48'];
				$out_qtys[]=$sql_row2['size_s49'];
				$out_qtys[]=$sql_row2['size_s50'];
	
			}
			

			$recut_qty_db=array();
			$recut_req_db=array();
			
			
			
			$sql1="select coalesce(sum(a_xs*a_plies),0) as \"a_xs\", coalesce(sum(a_s*a_plies),0) as \"a_s\", coalesce(sum(a_m*a_plies),0) as \"a_m\", coalesce(sum(a_l*a_plies),0) as \"a_l\", coalesce(sum(a_xl*a_plies),0) as \"a_xl\", coalesce(sum(a_xxl*a_plies),0) as \"a_xxl\", coalesce(sum(a_xxxl*a_plies),0) as \"a_xxxl\", coalesce(sum(a_s01*a_plies),0) as \"a_s01\", coalesce(sum(a_s02*a_plies),0) as \"a_s02\", coalesce(sum(a_s03*a_plies),0) as \"a_s03\", coalesce(sum(a_s04*a_plies),0) as \"a_s04\", coalesce(sum(a_s05*a_plies),0) as \"a_s05\", coalesce(sum(a_s06*a_plies),0) as \"a_s06\", coalesce(sum(a_s07*a_plies),0) as \"a_s07\", coalesce(sum(a_s08*a_plies),0) as \"a_s08\", coalesce(sum(a_s09*a_plies),0) as \"a_s09\", coalesce(sum(a_s10*a_plies),0) as \"a_s10\", coalesce(sum(a_s11*a_plies),0) as \"a_s11\", coalesce(sum(a_s12*a_plies),0) as \"a_s12\", coalesce(sum(a_s13*a_plies),0) as \"a_s13\", coalesce(sum(a_s14*a_plies),0) as \"a_s14\", coalesce(sum(a_s15*a_plies),0) as \"a_s15\", coalesce(sum(a_s16*a_plies),0) as \"a_s16\", coalesce(sum(a_s17*a_plies),0) as \"a_s17\", coalesce(sum(a_s18*a_plies),0) as \"a_s18\", coalesce(sum(a_s19*a_plies),0) as \"a_s19\", coalesce(sum(a_s20*a_plies),0) as \"a_s20\", coalesce(sum(a_s21*a_plies),0) as \"a_s21\", coalesce(sum(a_s22*a_plies),0) as \"a_s22\", coalesce(sum(a_s23*a_plies),0) as \"a_s23\", coalesce(sum(a_s24*a_plies),0) as \"a_s24\", coalesce(sum(a_s25*a_plies),0) as \"a_s25\", coalesce(sum(a_s26*a_plies),0) as \"a_s26\", coalesce(sum(a_s27*a_plies),0) as \"a_s27\", coalesce(sum(a_s28*a_plies),0) as \"a_s28\", coalesce(sum(a_s29*a_plies),0) as \"a_s29\", coalesce(sum(a_s30*a_plies),0) as \"a_s30\", coalesce(sum(a_s31*a_plies),0) as \"a_s31\", coalesce(sum(a_s32*a_plies),0) as \"a_s32\", coalesce(sum(a_s33*a_plies),0) as \"a_s33\", coalesce(sum(a_s34*a_plies),0) as \"a_s34\", coalesce(sum(a_s35*a_plies),0) as \"a_s35\", coalesce(sum(a_s36*a_plies),0) as \"a_s36\", coalesce(sum(a_s37*a_plies),0) as \"a_s37\", coalesce(sum(a_s38*a_plies),0) as \"a_s38\", coalesce(sum(a_s39*a_plies),0) as \"a_s39\", coalesce(sum(a_s40*a_plies),0) as \"a_s40\", coalesce(sum(a_s41*a_plies),0) as \"a_s41\", coalesce(sum(a_s42*a_plies),0) as \"a_s42\", coalesce(sum(a_s43*a_plies),0) as \"a_s43\", coalesce(sum(a_s44*a_plies),0) as \"a_s44\", coalesce(sum(a_s45*a_plies),0) as \"a_s45\", coalesce(sum(a_s46*a_plies),0) as \"a_s46\", coalesce(sum(a_s47*a_plies),0) as \"a_s47\", coalesce(sum(a_s48*a_plies),0) as \"a_s48\", coalesce(sum(a_s49*a_plies),0) as \"a_s49\", coalesce(sum(a_s50*a_plies),0) as \"a_s50\" ,coalesce(sum(p_xs),0) as \"p_xs\", coalesce(sum(p_s),0) as \"p_s\", coalesce(sum(p_m),0) as \"p_m\", coalesce(sum(p_l),0) as \"p_l\", coalesce(sum(p_xl),0) as \"p_xl\", coalesce(sum(p_xxl),0) as \"p_xxl\", coalesce(sum(p_xxxl),0) as \"p_xxxl\", coalesce(sum(p_s01),0) as \"p_s01\", coalesce(sum(p_s02),0) as \"p_s02\", coalesce(sum(p_s03),0) as \"p_s03\", coalesce(sum(p_s04),0) as \"p_s04\", coalesce(sum(p_s05),0) as \"p_s05\", coalesce(sum(p_s06),0) as \"p_s06\", coalesce(sum(p_s07),0) as \"p_s07\", coalesce(sum(p_s08),0) as \"p_s08\", coalesce(sum(p_s09),0) as \"p_s09\", coalesce(sum(p_s10),0) as \"p_s10\", coalesce(sum(p_s11),0) as \"p_s11\", coalesce(sum(p_s12),0) as \"p_s12\", coalesce(sum(p_s13),0) as \"p_s13\", coalesce(sum(p_s14),0) as \"p_s14\", coalesce(sum(p_s15),0) as \"p_s15\", coalesce(sum(p_s16),0) as \"p_s16\", coalesce(sum(p_s17),0) as \"p_s17\", coalesce(sum(p_s18),0) as \"p_s18\", coalesce(sum(p_s19),0) as \"p_s19\", coalesce(sum(p_s20),0) as \"p_s20\", coalesce(sum(p_s21),0) as \"p_s21\", coalesce(sum(p_s22),0) as \"p_s22\", coalesce(sum(p_s23),0) as \"p_s23\", coalesce(sum(p_s24),0) as \"p_s24\", coalesce(sum(p_s25),0) as \"p_s25\", coalesce(sum(p_s26),0) as \"p_s26\", coalesce(sum(p_s27),0) as \"p_s27\", coalesce(sum(p_s28),0) as \"p_s28\", coalesce(sum(p_s29),0) as \"p_s29\", coalesce(sum(p_s30),0) as \"p_s30\", coalesce(sum(p_s31),0) as \"p_s31\", coalesce(sum(p_s32),0) as \"p_s32\", coalesce(sum(p_s33),0) as \"p_s33\", coalesce(sum(p_s34),0) as \"p_s34\", coalesce(sum(p_s35),0) as \"p_s35\", coalesce(sum(p_s36),0) as \"p_s36\", coalesce(sum(p_s37),0) as \"p_s37\", coalesce(sum(p_s38),0) as \"p_s38\", coalesce(sum(p_s39),0) as \"p_s39\", coalesce(sum(p_s40),0) as \"p_s40\", coalesce(sum(p_s41),0) as \"p_s41\", coalesce(sum(p_s42),0) as \"p_s42\", coalesce(sum(p_s43),0) as \"p_s43\", coalesce(sum(p_s44),0) as \"p_s44\", coalesce(sum(p_s45),0) as \"p_s45\", coalesce(sum(p_s46),0) as \"p_s46\", coalesce(sum(p_s47),0) as \"p_s47\", coalesce(sum(p_s48),0) as \"p_s48\", coalesce(sum(p_s49),0) as \"p_s49\", coalesce(sum(p_s50),0) as \"p_s50\" from $bai_pro3.recut_v2_summary where order_tid=\"$order_tid\"";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result1))
			{
				$recut_qty_db[]=$sql_row2['a_xs'];
				$recut_qty_db[]=$sql_row2['a_s'];
				$recut_qty_db[]=$sql_row2['a_m'];
				$recut_qty_db[]=$sql_row2['a_l'];
				$recut_qty_db[]=$sql_row2['a_xl'];
				$recut_qty_db[]=$sql_row2['a_xxl'];
				$recut_qty_db[]=$sql_row2['a_xxxl'];
				$recut_qty_db[]=$sql_row2['a_s01'];
				$recut_qty_db[]=$sql_row2['a_s02'];
				$recut_qty_db[]=$sql_row2['a_s03'];
				$recut_qty_db[]=$sql_row2['a_s04'];
				$recut_qty_db[]=$sql_row2['a_s05'];
				$recut_qty_db[]=$sql_row2['a_s06'];
				$recut_qty_db[]=$sql_row2['a_s07'];
				$recut_qty_db[]=$sql_row2['a_s08'];
				$recut_qty_db[]=$sql_row2['a_s09'];
				$recut_qty_db[]=$sql_row2['a_s10'];
				$recut_qty_db[]=$sql_row2['a_s11'];
				$recut_qty_db[]=$sql_row2['a_s12'];
				$recut_qty_db[]=$sql_row2['a_s13'];
				$recut_qty_db[]=$sql_row2['a_s14'];
				$recut_qty_db[]=$sql_row2['a_s15'];
				$recut_qty_db[]=$sql_row2['a_s16'];
				$recut_qty_db[]=$sql_row2['a_s17'];
				$recut_qty_db[]=$sql_row2['a_s18'];
				$recut_qty_db[]=$sql_row2['a_s19'];
				$recut_qty_db[]=$sql_row2['a_s20'];
				$recut_qty_db[]=$sql_row2['a_s21'];
				$recut_qty_db[]=$sql_row2['a_s22'];
				$recut_qty_db[]=$sql_row2['a_s23'];
				$recut_qty_db[]=$sql_row2['a_s24'];
				$recut_qty_db[]=$sql_row2['a_s25'];
				$recut_qty_db[]=$sql_row2['a_s26'];
				$recut_qty_db[]=$sql_row2['a_s27'];
				$recut_qty_db[]=$sql_row2['a_s28'];
				$recut_qty_db[]=$sql_row2['a_s29'];
				$recut_qty_db[]=$sql_row2['a_s30'];
				$recut_qty_db[]=$sql_row2['a_s31'];
				$recut_qty_db[]=$sql_row2['a_s32'];
				$recut_qty_db[]=$sql_row2['a_s33'];
				$recut_qty_db[]=$sql_row2['a_s34'];
				$recut_qty_db[]=$sql_row2['a_s35'];
				$recut_qty_db[]=$sql_row2['a_s36'];
				$recut_qty_db[]=$sql_row2['a_s37'];
				$recut_qty_db[]=$sql_row2['a_s38'];
				$recut_qty_db[]=$sql_row2['a_s39'];
				$recut_qty_db[]=$sql_row2['a_s40'];
				$recut_qty_db[]=$sql_row2['a_s41'];
				$recut_qty_db[]=$sql_row2['a_s42'];
				$recut_qty_db[]=$sql_row2['a_s43'];
				$recut_qty_db[]=$sql_row2['a_s44'];
				$recut_qty_db[]=$sql_row2['a_s45'];
				$recut_qty_db[]=$sql_row2['a_s46'];
				$recut_qty_db[]=$sql_row2['a_s47'];
				$recut_qty_db[]=$sql_row2['a_s48'];
				$recut_qty_db[]=$sql_row2['a_s49'];
				$recut_qty_db[]=$sql_row2['a_s50'];

				
				$recut_req_db[]=$sql_row2['p_xs'];
				$recut_req_db[]=$sql_row2['p_s'];
				$recut_req_db[]=$sql_row2['p_m'];
				$recut_req_db[]=$sql_row2['p_l'];
				$recut_req_db[]=$sql_row2['p_xl'];
				$recut_req_db[]=$sql_row2['p_xxl'];
				$recut_req_db[]=$sql_row2['p_xxxl'];
				$recut_req_db[]=$sql_row2['p_s01'];
				$recut_req_db[]=$sql_row2['p_s02'];
				$recut_req_db[]=$sql_row2['p_s03'];
				$recut_req_db[]=$sql_row2['p_s04'];
				$recut_req_db[]=$sql_row2['p_s05'];
				$recut_req_db[]=$sql_row2['p_s06'];
				$recut_req_db[]=$sql_row2['p_s07'];
				$recut_req_db[]=$sql_row2['p_s08'];
				$recut_req_db[]=$sql_row2['p_s09'];
				$recut_req_db[]=$sql_row2['p_s10'];
				$recut_req_db[]=$sql_row2['p_s11'];
				$recut_req_db[]=$sql_row2['p_s12'];
				$recut_req_db[]=$sql_row2['p_s13'];
				$recut_req_db[]=$sql_row2['p_s14'];
				$recut_req_db[]=$sql_row2['p_s15'];
				$recut_req_db[]=$sql_row2['p_s16'];
				$recut_req_db[]=$sql_row2['p_s17'];
				$recut_req_db[]=$sql_row2['p_s18'];
				$recut_req_db[]=$sql_row2['p_s19'];
				$recut_req_db[]=$sql_row2['p_s20'];
				$recut_req_db[]=$sql_row2['p_s21'];
				$recut_req_db[]=$sql_row2['p_s22'];
				$recut_req_db[]=$sql_row2['p_s23'];
				$recut_req_db[]=$sql_row2['p_s24'];
				$recut_req_db[]=$sql_row2['p_s25'];
				$recut_req_db[]=$sql_row2['p_s26'];
				$recut_req_db[]=$sql_row2['p_s27'];
				$recut_req_db[]=$sql_row2['p_s28'];
				$recut_req_db[]=$sql_row2['p_s29'];
				$recut_req_db[]=$sql_row2['p_s30'];
				$recut_req_db[]=$sql_row2['p_s31'];
				$recut_req_db[]=$sql_row2['p_s32'];
				$recut_req_db[]=$sql_row2['p_s33'];
				$recut_req_db[]=$sql_row2['p_s34'];
				$recut_req_db[]=$sql_row2['p_s35'];
				$recut_req_db[]=$sql_row2['p_s36'];
				$recut_req_db[]=$sql_row2['p_s37'];
				$recut_req_db[]=$sql_row2['p_s38'];
				$recut_req_db[]=$sql_row2['p_s39'];
				$recut_req_db[]=$sql_row2['p_s40'];
				$recut_req_db[]=$sql_row2['p_s41'];
				$recut_req_db[]=$sql_row2['p_s42'];
				$recut_req_db[]=$sql_row2['p_s43'];
				$recut_req_db[]=$sql_row2['p_s44'];
				$recut_req_db[]=$sql_row2['p_s45'];
				$recut_req_db[]=$sql_row2['p_s46'];
				$recut_req_db[]=$sql_row2['p_s47'];
				$recut_req_db[]=$sql_row2['p_s48'];
				$recut_req_db[]=$sql_row2['p_s49'];
				$recut_req_db[]=$sql_row2['p_s50'];
			}
			
			$act_cut_new_db=array();
			$sql1="select coalesce(sum(a_xs*a_plies),0) as \"a_xs\", coalesce(sum(a_s*a_plies),0) as \"a_s\", coalesce(sum(a_m*a_plies),0) as \"a_m\", coalesce(sum(a_l*a_plies),0) as \"a_l\", coalesce(sum(a_xl*a_plies),0) as \"a_xl\", coalesce(sum(a_xxl*a_plies),0) as \"a_xxl\", coalesce(sum(a_xxxl*a_plies),0) as \"a_xxxl\", coalesce(sum(a_s01*a_plies),0) as \"a_s01\", coalesce(sum(a_s02*a_plies),0) as \"a_s02\", coalesce(sum(a_s03*a_plies),0) as \"a_s03\", coalesce(sum(a_s04*a_plies),0) as \"a_s04\", coalesce(sum(a_s05*a_plies),0) as \"a_s05\", coalesce(sum(a_s06*a_plies),0) as \"a_s06\", coalesce(sum(a_s07*a_plies),0) as \"a_s07\", coalesce(sum(a_s08*a_plies),0) as \"a_s08\", coalesce(sum(a_s09*a_plies),0) as \"a_s09\", coalesce(sum(a_s10*a_plies),0) as \"a_s10\", coalesce(sum(a_s11*a_plies),0) as \"a_s11\", coalesce(sum(a_s12*a_plies),0) as \"a_s12\", coalesce(sum(a_s13*a_plies),0) as \"a_s13\", coalesce(sum(a_s14*a_plies),0) as \"a_s14\", coalesce(sum(a_s15*a_plies),0) as \"a_s15\", coalesce(sum(a_s16*a_plies),0) as \"a_s16\", coalesce(sum(a_s17*a_plies),0) as \"a_s17\", coalesce(sum(a_s18*a_plies),0) as \"a_s18\", coalesce(sum(a_s19*a_plies),0) as \"a_s19\", coalesce(sum(a_s20*a_plies),0) as \"a_s20\", coalesce(sum(a_s21*a_plies),0) as \"a_s21\", coalesce(sum(a_s22*a_plies),0) as \"a_s22\", coalesce(sum(a_s23*a_plies),0) as \"a_s23\", coalesce(sum(a_s24*a_plies),0) as \"a_s24\", coalesce(sum(a_s25*a_plies),0) as \"a_s25\", coalesce(sum(a_s26*a_plies),0) as \"a_s26\", coalesce(sum(a_s27*a_plies),0) as \"a_s27\", coalesce(sum(a_s28*a_plies),0) as \"a_s28\", coalesce(sum(a_s29*a_plies),0) as \"a_s29\", coalesce(sum(a_s30*a_plies),0) as \"a_s30\", coalesce(sum(a_s31*a_plies),0) as \"a_s31\", coalesce(sum(a_s32*a_plies),0) as \"a_s32\", coalesce(sum(a_s33*a_plies),0) as \"a_s33\", coalesce(sum(a_s34*a_plies),0) as \"a_s34\", coalesce(sum(a_s35*a_plies),0) as \"a_s35\", coalesce(sum(a_s36*a_plies),0) as \"a_s36\", coalesce(sum(a_s37*a_plies),0) as \"a_s37\", coalesce(sum(a_s38*a_plies),0) as \"a_s38\", coalesce(sum(a_s39*a_plies),0) as \"a_s39\", coalesce(sum(a_s40*a_plies),0) as \"a_s40\", coalesce(sum(a_s41*a_plies),0) as \"a_s41\", coalesce(sum(a_s42*a_plies),0) as \"a_s42\", coalesce(sum(a_s43*a_plies),0) as \"a_s43\", coalesce(sum(a_s44*a_plies),0) as \"a_s44\", coalesce(sum(a_s45*a_plies),0) as \"a_s45\", coalesce(sum(a_s46*a_plies),0) as \"a_s46\", coalesce(sum(a_s47*a_plies),0) as \"a_s47\", coalesce(sum(a_s48*a_plies),0) as \"a_s48\", coalesce(sum(a_s49*a_plies),0) as \"a_s49\", coalesce(sum(a_s50*a_plies),0) as \"a_s50\" from $bai_pro3.order_cat_doc_mix where order_tid=\"$order_tid\" and category in (\"Body\",\"Front\") and act_cut_status=\"DONE\"";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result1))
			{
				$act_cut_new_db[]=$sql_row2['a_xs'];
				$act_cut_new_db[]=$sql_row2['a_s'];
				$act_cut_new_db[]=$sql_row2['a_m'];
				$act_cut_new_db[]=$sql_row2['a_l'];
				$act_cut_new_db[]=$sql_row2['a_xl'];
				$act_cut_new_db[]=$sql_row2['a_xxl'];
				$act_cut_new_db[]=$sql_row2['a_xxxl'];
				$act_cut_new_db[]=$sql_row2['a_s01'];
				$act_cut_new_db[]=$sql_row2['a_s02'];
				$act_cut_new_db[]=$sql_row2['a_s03'];
				$act_cut_new_db[]=$sql_row2['a_s04'];
				$act_cut_new_db[]=$sql_row2['a_s05'];
				$act_cut_new_db[]=$sql_row2['a_s06'];
				$act_cut_new_db[]=$sql_row2['a_s07'];
				$act_cut_new_db[]=$sql_row2['a_s08'];
				$act_cut_new_db[]=$sql_row2['a_s09'];
				$act_cut_new_db[]=$sql_row2['a_s10'];
				$act_cut_new_db[]=$sql_row2['a_s11'];
				$act_cut_new_db[]=$sql_row2['a_s12'];
				$act_cut_new_db[]=$sql_row2['a_s13'];
				$act_cut_new_db[]=$sql_row2['a_s14'];
				$act_cut_new_db[]=$sql_row2['a_s15'];
				$act_cut_new_db[]=$sql_row2['a_s16'];
				$act_cut_new_db[]=$sql_row2['a_s17'];
				$act_cut_new_db[]=$sql_row2['a_s18'];
				$act_cut_new_db[]=$sql_row2['a_s19'];
				$act_cut_new_db[]=$sql_row2['a_s20'];
				$act_cut_new_db[]=$sql_row2['a_s21'];
				$act_cut_new_db[]=$sql_row2['a_s22'];
				$act_cut_new_db[]=$sql_row2['a_s23'];
				$act_cut_new_db[]=$sql_row2['a_s24'];
				$act_cut_new_db[]=$sql_row2['a_s25'];
				$act_cut_new_db[]=$sql_row2['a_s26'];
				$act_cut_new_db[]=$sql_row2['a_s27'];
				$act_cut_new_db[]=$sql_row2['a_s28'];
				$act_cut_new_db[]=$sql_row2['a_s29'];
				$act_cut_new_db[]=$sql_row2['a_s30'];
				$act_cut_new_db[]=$sql_row2['a_s31'];
				$act_cut_new_db[]=$sql_row2['a_s32'];
				$act_cut_new_db[]=$sql_row2['a_s33'];
				$act_cut_new_db[]=$sql_row2['a_s34'];
				$act_cut_new_db[]=$sql_row2['a_s35'];
				$act_cut_new_db[]=$sql_row2['a_s36'];
				$act_cut_new_db[]=$sql_row2['a_s37'];
				$act_cut_new_db[]=$sql_row2['a_s38'];
				$act_cut_new_db[]=$sql_row2['a_s39'];
				$act_cut_new_db[]=$sql_row2['a_s40'];
				$act_cut_new_db[]=$sql_row2['a_s41'];
				$act_cut_new_db[]=$sql_row2['a_s42'];
				$act_cut_new_db[]=$sql_row2['a_s43'];
				$act_cut_new_db[]=$sql_row2['a_s44'];
				$act_cut_new_db[]=$sql_row2['a_s45'];
				$act_cut_new_db[]=$sql_row2['a_s46'];
				$act_cut_new_db[]=$sql_row2['a_s47'];
				$act_cut_new_db[]=$sql_row2['a_s48'];
				$act_cut_new_db[]=$sql_row2['a_s49'];
				$act_cut_new_db[]=$sql_row2['a_s50'];
			}
			
			$rejected_db=array();
			$replaced_panels_new_db=array();
			$sample_room_new_db=array();
			$or_ratio_db=array();
			$good_panels=array();
			$sql1="select sum(rejected) as \"rejected\", sum(replaced) as \"replaced\", sum(sample_room) as \"sample_room\", sum(good_garments) as \"or_ratio\",  sum(good_panels) as \"good_panels\", qms_size  from $bai_pro3.bai_qms_day_report where qms_schedule=\"".$sql_row['schedule_no']."\" and qms_color=\"".$color."\" group by qms_size";
//echo $sql1."<br/>";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$l=array_search($sql_row1['qms_size'],$sizes_db);
				$rejected_db[$l]=$sql_row1['rejected'];
				$replaced_panels_new_db[$l]=$sql_row1['replaced'];
				$sample_room_new_db[$l]=$sql_row1['sample_room'];
				$or_ratio_db[$l]=$sql_row1['or_ratio'];
				$good_panels[$l]=$sql_row1['good_panels'];
				//echo $rejected."<br/>";
			}
			
			$act_in_new_db=array();
			for($m=0;$m<sizeof($sizes_db);$m++)
			{
				$act_in_new_db[$m]=0;
			}
			$sqlx1="select SUM(ims_qty) as \"ims_qty\", ims_size from $bai_pro3.ims_log where ims_schedule=\"$schedule\" and ims_color=\"$color\" and ims_mod_no>0 group by ims_size";
			//echo $sqlx1."<br/>";
			$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
			{
				$l=array_search(str_replace("a_","",$sql_rowx1['ims_size']),$sizes_db);
				//echo $l;
				$act_in_new_db[$l]+=$sql_rowx1['ims_qty'];
			}
			
			$sqlx1="select SUM(ims_qty) as \"ims_qty\", ims_size from $bai_pro3.ims_log_backup where ims_schedule=\"$schedule\" and ims_color=\"$color\" and ims_mod_no>0 group by ims_size";
			//echo $sqlx1."<br/>";
			$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
			{
				$l=array_search(str_replace("a_","",$sql_rowx1['ims_size']),$sizes_db);
				//echo $l;
				$act_in_new_db[$l]+=$sql_rowx1['ims_qty'];
			}
			
			$act_fg_new_db=array();
			$act_fca_new_db=array();
			
			for($m=0;$m<sizeof($sizes_db);$m++)
			{
				$act_fg_new_db[$m]=0;
				$act_fca_new_db[$m]=0;
			}
			
			if(substr($style,0,1)=="M")
			{
				//$sqlx1="select sum(carton_act_qty) as scanned,size_code from packing_summary where order_del_no=\"$schedule\" and order_col_des=\"".$color."\" and status=\"DONE\" group by size_code";
 				$sqlx1="select sum(carton_act_qty) as scanned,size_code from $bai_pro3.packing_summary where order_del_no=\"$schedule\" and trim(both from order_col_des)=\"".trim($color)."\" and status=\"DONE\" group by size_code";
				//echo $sqlx1."<br/>";
				$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
				{
					$l=array_search($sql_rowx1['size_code'],$sizes_db);
					$act_fg_new_db[$l]=$sql_rowx1['scanned'];
					$act_fca_new_db[$l]=$sql_rowx1['scanned'];
					$tot_ship_new_db[$l]=$sql_rowx1['scanned'];
				}
			}
			else
			{
			$sqlx1="select scanned,fca_app,size_code from $bai_pro3.disp_mix_size where order_del_no=\"$schedule\"";
			//echo $sqlx1."<br/>";
			$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
			{
				$l=array_search($sql_rowx1['size_code'],$sizes_db);
				$act_fg_new_db[$l]=$sql_rowx1['scanned'];
				$act_fca_new_db[$l]=$sql_rowx1['fca_app'];
			}
			
			$tot_ship_new_db=array();
			$sql1="select coalesce(sum(ship_s_xs),0) as \"ship_s_xs\", coalesce(sum(ship_s_s),0) as \"ship_s_s\", coalesce(sum(ship_s_m),0) as \"ship_s_m\", coalesce(sum(ship_s_l),0) as \"ship_s_l\", coalesce(sum(ship_s_xl),0) as \"ship_s_xl\", coalesce(sum(ship_s_xxl),0) as \"ship_s_xxl\", coalesce(sum(ship_s_xxxl),0) as \"ship_s_xxxl\", coalesce(sum(ship_s_s01),0) as \"ship_s_s01\", coalesce(sum(ship_s_s02),0) as \"ship_s_s02\", coalesce(sum(ship_s_s03),0) as \"ship_s_s03\", coalesce(sum(ship_s_s04),0) as \"ship_s_s04\", coalesce(sum(ship_s_s05),0) as \"ship_s_s05\", coalesce(sum(ship_s_s06),0) as \"ship_s_s06\", coalesce(sum(ship_s_s07),0) as \"ship_s_s07\", coalesce(sum(ship_s_s08),0) as \"ship_s_s08\", coalesce(sum(ship_s_s09),0) as \"ship_s_s09\", coalesce(sum(ship_s_s10),0) as \"ship_s_s10\", coalesce(sum(ship_s_s11),0) as \"ship_s_s11\", coalesce(sum(ship_s_s12),0) as \"ship_s_s12\", coalesce(sum(ship_s_s13),0) as \"ship_s_s13\", coalesce(sum(ship_s_s14),0) as \"ship_s_s14\", coalesce(sum(ship_s_s15),0) as \"ship_s_s15\", coalesce(sum(ship_s_s16),0) as \"ship_s_s16\", coalesce(sum(ship_s_s17),0) as \"ship_s_s17\", coalesce(sum(ship_s_s18),0) as \"ship_s_s18\", coalesce(sum(ship_s_s19),0) as \"ship_s_s19\", coalesce(sum(ship_s_s20),0) as \"ship_s_s20\", coalesce(sum(ship_s_s21),0) as \"ship_s_s21\", coalesce(sum(ship_s_s22),0) as \"ship_s_s22\", coalesce(sum(ship_s_s23),0) as \"ship_s_s23\", coalesce(sum(ship_s_s24),0) as \"ship_s_s24\", coalesce(sum(ship_s_s25),0) as \"ship_s_s25\", coalesce(sum(ship_s_s26),0) as \"ship_s_s26\", coalesce(sum(ship_s_s27),0) as \"ship_s_s27\", coalesce(sum(ship_s_s28),0) as \"ship_s_s28\", coalesce(sum(ship_s_s29),0) as \"ship_s_s29\", coalesce(sum(ship_s_s30),0) as \"ship_s_s30\", coalesce(sum(ship_s_s31),0) as \"ship_s_s31\", coalesce(sum(ship_s_s32),0) as \"ship_s_s32\", coalesce(sum(ship_s_s33),0) as \"ship_s_s33\", coalesce(sum(ship_s_s34),0) as \"ship_s_s34\", coalesce(sum(ship_s_s35),0) as \"ship_s_s35\", coalesce(sum(ship_s_s36),0) as \"ship_s_s36\", coalesce(sum(ship_s_s37),0) as \"ship_s_s37\", coalesce(sum(ship_s_s38),0) as \"ship_s_s38\", coalesce(sum(ship_s_s39),0) as \"ship_s_s39\", coalesce(sum(ship_s_s40),0) as \"ship_s_s40\", coalesce(sum(ship_s_s41),0) as \"ship_s_s41\", coalesce(sum(ship_s_s42),0) as \"ship_s_s42\", coalesce(sum(ship_s_s43),0) as \"ship_s_s43\", coalesce(sum(ship_s_s44),0) as \"ship_s_s44\", coalesce(sum(ship_s_s45),0) as \"ship_s_s45\", coalesce(sum(ship_s_s46),0) as \"ship_s_s46\", coalesce(sum(ship_s_s47),0) as \"ship_s_s47\", coalesce(sum(ship_s_s48),0) as \"ship_s_s48\", coalesce(sum(ship_s_s49),0) as \"ship_s_s49\", coalesce(sum(ship_s_s50),0) as \"ship_s_s50\" from $bai_pro3.ship_stat_log where ship_schedule=\"$schedule\" and disp_note_no>0";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result1))
			{
				$tot_ship_new_db[]=$sql_row2['ship_s_xs'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s'];
				$tot_ship_new_db[]=$sql_row2['ship_s_m'];
				$tot_ship_new_db[]=$sql_row2['ship_s_l'];
				$tot_ship_new_db[]=$sql_row2['ship_s_xl'];
				$tot_ship_new_db[]=$sql_row2['ship_s_xxl'];
				$tot_ship_new_db[]=$sql_row2['ship_s_xxxl'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s01'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s02'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s03'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s04'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s05'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s06'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s07'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s08'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s09'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s10'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s11'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s12'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s13'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s14'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s15'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s16'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s17'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s18'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s19'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s20'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s21'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s22'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s23'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s24'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s25'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s26'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s27'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s28'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s29'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s30'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s31'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s32'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s33'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s34'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s35'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s36'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s37'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s38'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s39'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s40'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s41'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s42'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s43'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s44'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s45'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s46'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s47'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s48'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s49'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s50'];
			}
			}
			
			for($i=0;$i<sizeof($order_qtys);$i++)
			{
				if($order_qtys[$i]>0)
				{
					
						$recut_qty=$recut_qty_db[$i];
						$recut_req=$recut_req_db[$i];
					
					
					$excess=0;
					
						$excess=$act_cut_new_db[$i]-$order_qtys[$i];
						$act_cut_new=$act_cut_new_db[$i];
				
					
					$rejected=0;
					$replaced_panels_new=0;
					$sample_room_new=0;
					
						$rejected=$rejected_db[$i];
						$replaced_panels_new=$replaced_panels_new_db[$i];
						$sample_room_new=$sample_room_new_db[$i];
						$or_ratio=$or_ratio_db[$i];
						
						$act_in_new=0;
					$act_in_new=$act_in_new_db[$i];
					
						$act_fg_new=$act_fg_new_db[$i];
						$act_fca_new=$act_fca_new_db[$i];
					
					
						$tot_ship_new=$tot_ship_new_db[$i];
					
					
					$missing_panels_new=0;
					$excess_panels_new=0;
					
					//calculation part
					
					$field_1=$act_cut_new+$recut_qty; //total cut qty
					$field_2=($act_in_new+$replaced_panels_new+($recut_qty-($recut_qty-$recut_req)));
					$field_3=$rejected;
					$field_4=$recut_req;
					$field_5=$recut_qty;
					$field_6=$sample_room_new;
					$field_7=$or_ratio;
					$field_8=$replaced_panels_new;
					$field_9=$good_panels[$i];
					$field_10=$tot_ship_new_db[$i];
					
					if($field_4==0)
					{
						$excess_panels_new=$field_9-$field_8;
					}
					else
					{
						$excess_panels_new=$field_5-$field_4;
					}
					
					if($field_4==0)
					{
						$missing_panels_new=$field_1-(($field_3+$field_6+$field_7+$field_10)+($field_9-$field_8));
					}
					else
					{
						$missing_panels_new=$field_1-($field_3+$field_6+$field_7+$field_10);
					}
					
					$sw_missing=$field_2-($field_3+$field_7+$field_10);
					if($field_4!=0)
					{
						$pr_missing=$field_9-$field_8;
					}
					
					$ct_missing=$field_1-(($field_2-$field_8)+($field_6+$field_9));
					//$sw_missing=$field_1."-".$field_2."-".$field_3."-".$field_4."-".$field_5."-".$field_6."-".$field_7."-".$field_8."-".$field_9."-".$field_10;
					
					//calculation part
					
					
					
					
					$status=6; //RM
					if($act_cut_new==0)
					{
						$status=6; //RM
					}
					else
					{
						if($act_cut_new>0 and $act_in_new==0)
						{
							$status=5; //Cutting
						}
						else
						{
							if($act_in_new>0)
							{
								$status=4; //Sewing
							}
						}
					}
					if($out_qtys[$i]>=$act_fg_new and $out_qtys[$i]>0 and $act_fg_new==$order_qtys[$i])
					{
						$status=2; //FG
						if($act_fca_new==$act_fg_new)
						{
							$status=1;
						}
					} 
					if($out_qtys[$i]>=$order_qtys[$i] and $out_qtys[$i]>0 and $act_fg_new<$order_qtys[$i])
					{
						$status=3; //packing
					}
					
					$status_title="Nil";
					switch($status)
					{
						case 6:
						{
							$status_title="RM";
							break;
						}
						case 5:
						{
							$status_title="Cutting";
							break;
						}
						case 4:
						{
							$status_title="Sewing";
							break;
						}
						case 3:
						{
							$status_title="Packing";
							break;
						}
						case 2:
						{
							$status_title="FG";
							break;
						}
						default:
						{
							$status_title="Nil";
						}
					}
					
					
					if(($status_title=="Nil" or $status_title=="FG") and $tot_ship_new>0)
					{
						if($tot_ship_new>=$order_qtys[$i])
						{
							$status_title="Shipped";
						}
						else
						{
							$status_title="Part Shipped";
						}
					}
					
					$style=$sql_row['style'];
					$schedule=$sql_row['schedule_no'];
					$color=$sql_row['color'];
					echo "<tr>";
					echo "<td class=\"lef\">".$sql_row['buyer_division']."</td>";
					echo "<td class=\"lef\">".$status_title."</td>";
					echo "<td>".$sql_row['ex_factory_date_new']."</td>";
					echo "<td class=\"lef\"><a href='pop_report.php?style='$style'&schedule='$schedule'&color='$color'>".$sql_row['style']."</a></td>";
					echo "<td>".$sql_row['schedule_no']."</td>";
					echo "<td class=\"lef\">".$sql_row['color']."</td>";
					echo "<td>".substr($sql_row['sections'],0,-1)."</td>";
					echo "<td>".$sizes_db[$i]."</td>";
					echo "<td>".$order_qtys[$i]."</td>";
					echo "<td>".($act_cut_new+$recut_qty)."</td>";
					echo "<td>".($act_in_new+$replaced_panels_new+($recut_qty-($recut_qty-$recut_req)))."</td>";
					echo "<td>".$out_qtys[$i]."</td>";
					echo "<td>".$act_fg_new."</td>";
					echo "<td>".$act_fca_new."</td>";
					//echo "<td>".$act_mca."</td>";
					echo "<td>".$tot_ship_new."</td>";
					echo "<td>".$rejected."</td>";
					echo "<td>".$sample_room_new."</td>";
					echo "<td>".($excess_panels_new)."</td>";
					echo "<td>".$or_ratio."</td>";
					echo "<td>".$missing_panels_new."</td>";
					echo "<td>".$sw_missing."</td>";
					echo "<td>".$pr_missing."</td>";
					echo "<td>".$ct_missing."</td>";
					echo "</tr>";
					
					$display_total_good_panels+=abs($excess_panels_new);
					$display_total_missing_panels+=abs($missing_panels_new);
					$display_total_rejected_panels+=abs($rejected);
				}
			}
		
	
			unset($order_qtys);
			unset($out_qtys);
			unset($recut_qty_db);
			unset($recut_req_db);
			unset($act_cut_new_db);
			unset($rejected_db);
			unset($replaced_panels_new_db);
			unset($sample_room_new_db);
			unset($or_ratio_db);
			unset($good_panels);
			unset($act_in_new_db);
			unset($act_fg_new_db);
			unset($act_fca_new_db);
			unset($tot_ship_new_db);
			
	} 

}
echo "</table></div>";

?>





<?php

$cachefile = $path."/packing/reports/".$cache_date.'.html';
// open the cache file "cache/home.html" for writing
$fp = fopen($cachefile, 'w');
// save the contents of output buffer to the file
fwrite($fp, ob_get_contents());
// close the file
fclose($fp);
// Send the output to the browser
ob_end_flush();


$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>
</div></div>
</body>
</html>
<html>
<?php  


//SFCS_PRO_FG_Stock_Summary_Report
// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$start_timestamp = microtime(true);
include('C:\xampp\htdocs\sfcs_main\sfcs_app\common\config\config_jobs.php');

function ims_sizes($order_tid,$ims_schedule,$ims_style,$ims_color,$ims_size2,$link11)
{
	$ims = substr($ims_size2,1);
	error_reporting(0);
	
	if($ims>=01 && $ims<=50)
	{
		
		if($order_tid=='')
		{
			$sql23="select title_size_$ims_size2 as size_val,title_flag from bai_pro3.bai_orders_db_confirm where order_style_no=\"$ims_style\" and order_del_no=\"$ims_schedule\" ";
		}
		else
		{
			$sql23="select title_size_$ims_size2 as size_val,title_flag from bai_pro3.bai_orders_db_confirm where order_tid=\"".$order_tid."\"";
		}
		$sql_result=mysqli_query($link, $sql23);
		while($sql_row=mysqli_fetch_array($sql_result))
		{
				$size_val=$sql_row['size_val'];
				$flag = $sql_row['title_flag'];
	    }
			
		if($flag==1)
		{
			return $size_val;
		}
		else
		{
			return $ims_size2;
		}		
	}
	else
	{
		return $ims_size2;
	}
					
}



// set_time_limit(60000);
$cache_date="stock_report";


/* if (file_exists($cachefile)) {

	include($cachefile);

	exit;

} */
ob_start();
function div_by_zero($arg)
{
	$arg1=1;
	if($arg==0 or $arg=='0' or $arg=='')
	{
		$arg1=1;
	}
	else
	{
		$arg1=$arg;
	}
	return $arg1;
}
?>


<title>BEK FG Stock Summary</title>
<head>

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
	<div class="panel-heading">FG Stock Summary</div>
	<div class="panel-body">

<?php

/*
$fg_wh_report_summary="temp_pool_db.fg_wh_report_summary".date("YmdHis");
$sql="CREATE TABLE $fg_wh_report_summary ENGINE=MyISAM as (select * from fg_wh_report_summary where (total_qty-fn_act_ship_qty(order_del_no))<>0 order by order_date) ";
mysql_query($sql,$link) or exit("Sql Error".mysql_error());

$packing_summary="temp_pool_db.packing_summary".date("YmdHis");
$sql="CREATE TABLE $packing_summary ENGINE=MyISAM as (select * from packing_summary)";
mysql_query($sql,$link) or exit("Sql Error".mysql_error());
*/
$fg_wh_report_summary="bai_pro3.fg_wh_report_summary";
$packing_summary="bai_pro3.packing_summary";

{
	echo "<br/><br/><br/><br/><br/><br/><h3>LU:".date("Y-m-d H:i:s")."</h3>";
	
	echo "<div class=\"table-responsive\"><table id=\"example1\" class=\"table table-bordered\">";
	echo "<tr class='tblheading'>
	<th>Ex-Factory Date</th>
	<th>Delivery</th>
	<th>Style</th>
	<th>Color / Assortment</th>
	<th>Order Qty</th>
	<th>Packing <br/>List Qty</th>
	<th>Scanned</th>
	<th>Un-Scanned</th>
	<th>Embellishment</th>
	<th>Shipped</th>
	<th>Balance <br/>to Ship</th><th>In FG</th><th>Title</th>";
	
	
	$sizes_db=array("s01","s02","s03","s04","s05","s06","s07","s08","s09","s10","s11","s12","s13","s14","s15","s16","s17","s18","s19","s20","s21","s22","s23","s24","s25","s26","s27","s28","s29","s30","s31","s32","s33","s34","s35","s36","s37","s38","s39","s40","s41","s42","s43","s44","s45","s46","s47","s48","s49","s50");
	
	for($i=0;$i<sizeof($sizes_db);$i++)
	{
		echo "<th>".strtoupper($sizes_db[$i])."</th>";
	}
	  echo  "<th>Min percentage</th><th>Category</th>
	<th>status</th></tr>";
	
	$pink_stock=0;
	$logo_stock=0;
	$mns_stock=0;
	$balance=0;
	
	$auth_usr=array("kirang","baiadmn","baisysadmin","baischtasksvc","baiictintern2","kirang","sfcsproject1","sfcsproject2");
	if(in_array($username,$auth_usr))
	{
			
		$sql="select *,bai_pro3.fn_act_ship_qty(order_del_no) as rev_shipped from bai_pro3.fg_wh_report_summary where (total_qty-bai_pro3.fn_act_ship_qty(order_del_no))<>0 order by order_date";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$order_del_no=$sql_row['order_del_no'];
			
			$order_qtys=array();
			$out_qtys=array();
			
				
			$sql1="select COALESCE(SUM(IF(size_code='xs',carton_act_qty,0)),0) as xs, COALESCE(SUM(IF(size_code='s',carton_act_qty,0)),0) as s, COALESCE(SUM(IF(size_code='m',carton_act_qty,0)),0) as m, COALESCE(SUM(IF(size_code='l',carton_act_qty,0)),0) as l, COALESCE(SUM(IF(size_code='xl',carton_act_qty,0)),0) as xl, COALESCE(SUM(IF(size_code='xxl',carton_act_qty,0)),0) as xxl, COALESCE(SUM(IF(size_code='xxxl',carton_act_qty,0)),0) as xxxl, COALESCE(SUM(IF(size_code='s01',carton_act_qty,0)),0) as s01, COALESCE(SUM(IF(size_code='s02',carton_act_qty,0)),0) as s02, COALESCE(SUM(IF(size_code='s03',carton_act_qty,0)),0) as s03, COALESCE(SUM(IF(size_code='s04',carton_act_qty,0)),0) as s04, COALESCE(SUM(IF(size_code='s05',carton_act_qty,0)),0) as s05, COALESCE(SUM(IF(size_code='s06',carton_act_qty,0)),0) as s06, COALESCE(SUM(IF(size_code='s07',carton_act_qty,0)),0) as s07, COALESCE(SUM(IF(size_code='s08',carton_act_qty,0)),0) as s08, COALESCE(SUM(IF(size_code='s09',carton_act_qty,0)),0) as s09, COALESCE(SUM(IF(size_code='s10',carton_act_qty,0)),0) as s10, COALESCE(SUM(IF(size_code='s11',carton_act_qty,0)),0) as s11, COALESCE(SUM(IF(size_code='s12',carton_act_qty,0)),0) as s12, COALESCE(SUM(IF(size_code='s13',carton_act_qty,0)),0) as s13, COALESCE(SUM(IF(size_code='s14',carton_act_qty,0)),0) as s14, COALESCE(SUM(IF(size_code='s15',carton_act_qty,0)),0) as s15, COALESCE(SUM(IF(size_code='s16',carton_act_qty,0)),0) as s16, COALESCE(SUM(IF(size_code='s17',carton_act_qty,0)),0) as s17, COALESCE(SUM(IF(size_code='s18',carton_act_qty,0)),0) as s18, COALESCE(SUM(IF(size_code='s19',carton_act_qty,0)),0) as s19, COALESCE(SUM(IF(size_code='s20',carton_act_qty,0)),0) as s20, COALESCE(SUM(IF(size_code='s21',carton_act_qty,0)),0) as s21, COALESCE(SUM(IF(size_code='s22',carton_act_qty,0)),0) as s22, COALESCE(SUM(IF(size_code='s23',carton_act_qty,0)),0) as s23, COALESCE(SUM(IF(size_code='s24',carton_act_qty,0)),0) as s24, COALESCE(SUM(IF(size_code='s25',carton_act_qty,0)),0) as s25, COALESCE(SUM(IF(size_code='s26',carton_act_qty,0)),0) as s26, COALESCE(SUM(IF(size_code='s27',carton_act_qty,0)),0) as s27, COALESCE(SUM(IF(size_code='s28',carton_act_qty,0)),0) as s28, COALESCE(SUM(IF(size_code='s29',carton_act_qty,0)),0) as s29, COALESCE(SUM(IF(size_code='s30',carton_act_qty,0)),0) as s30, COALESCE(SUM(IF(size_code='s31',carton_act_qty,0)),0) as s31, COALESCE(SUM(IF(size_code='s32',carton_act_qty,0)),0) as s32, COALESCE(SUM(IF(size_code='s33',carton_act_qty,0)),0) as s33, COALESCE(SUM(IF(size_code='s34',carton_act_qty,0)),0) as s34, COALESCE(SUM(IF(size_code='s35',carton_act_qty,0)),0) as s35, COALESCE(SUM(IF(size_code='s36',carton_act_qty,0)),0) as s36, COALESCE(SUM(IF(size_code='s37',carton_act_qty,0)),0) as s37, COALESCE(SUM(IF(size_code='s38',carton_act_qty,0)),0) as s38, COALESCE(SUM(IF(size_code='s39',carton_act_qty,0)),0) as s39, COALESCE(SUM(IF(size_code='s40',carton_act_qty,0)),0) as s40, COALESCE(SUM(IF(size_code='s41',carton_act_qty,0)),0) as s41, COALESCE(SUM(IF(size_code='s42',carton_act_qty,0)),0) as s42, COALESCE(SUM(IF(size_code='s43',carton_act_qty,0)),0) as s43, COALESCE(SUM(IF(size_code='s44',carton_act_qty,0)),0) as s44, COALESCE(SUM(IF(size_code='s45',carton_act_qty,0)),0) as s45, COALESCE(SUM(IF(size_code='s46',carton_act_qty,0)),0) as s46, COALESCE(SUM(IF(size_code='s47',carton_act_qty,0)),0) as s47, COALESCE(SUM(IF(size_code='s48',carton_act_qty,0)),0) as s48, COALESCE(SUM(IF(size_code='s49',carton_act_qty,0)),0) as s49, COALESCE(SUM(IF(size_code='s50',carton_act_qty,0)),0) as s50 from $packing_summary where status=\"DONE\" and order_del_no=\"$order_del_no\"";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				
				$order_qtys[]=$sql_row1['s01'];
$order_qtys[]=$sql_row1['s02'];
$order_qtys[]=$sql_row1['s03'];
$order_qtys[]=$sql_row1['s04'];
$order_qtys[]=$sql_row1['s05'];
$order_qtys[]=$sql_row1['s06'];
$order_qtys[]=$sql_row1['s07'];
$order_qtys[]=$sql_row1['s08'];
$order_qtys[]=$sql_row1['s09'];
$order_qtys[]=$sql_row1['s10'];
$order_qtys[]=$sql_row1['s11'];
$order_qtys[]=$sql_row1['s12'];
$order_qtys[]=$sql_row1['s13'];
$order_qtys[]=$sql_row1['s14'];
$order_qtys[]=$sql_row1['s15'];
$order_qtys[]=$sql_row1['s16'];
$order_qtys[]=$sql_row1['s17'];
$order_qtys[]=$sql_row1['s18'];
$order_qtys[]=$sql_row1['s19'];
$order_qtys[]=$sql_row1['s20'];
$order_qtys[]=$sql_row1['s21'];
$order_qtys[]=$sql_row1['s22'];
$order_qtys[]=$sql_row1['s23'];
$order_qtys[]=$sql_row1['s24'];
$order_qtys[]=$sql_row1['s25'];
$order_qtys[]=$sql_row1['s26'];
$order_qtys[]=$sql_row1['s27'];
$order_qtys[]=$sql_row1['s28'];
$order_qtys[]=$sql_row1['s29'];
$order_qtys[]=$sql_row1['s30'];
$order_qtys[]=$sql_row1['s31'];
$order_qtys[]=$sql_row1['s32'];
$order_qtys[]=$sql_row1['s33'];
$order_qtys[]=$sql_row1['s34'];
$order_qtys[]=$sql_row1['s35'];
$order_qtys[]=$sql_row1['s36'];
$order_qtys[]=$sql_row1['s37'];
$order_qtys[]=$sql_row1['s38'];
$order_qtys[]=$sql_row1['s39'];
$order_qtys[]=$sql_row1['s40'];
$order_qtys[]=$sql_row1['s41'];
$order_qtys[]=$sql_row1['s42'];
$order_qtys[]=$sql_row1['s43'];
$order_qtys[]=$sql_row1['s44'];
$order_qtys[]=$sql_row1['s45'];
$order_qtys[]=$sql_row1['s46'];
$order_qtys[]=$sql_row1['s47'];
$order_qtys[]=$sql_row1['s48'];
$order_qtys[]=$sql_row1['s49'];
$order_qtys[]=$sql_row1['s50'];

			}
			
			$sql2="select coalesce(sum(ship_s_xs),0) as \"ship_s_xs\", coalesce(sum(ship_s_s),0) as \"ship_s_s\", coalesce(sum(ship_s_m),0) as \"ship_s_m\", coalesce(sum(ship_s_l),0) as \"ship_s_l\", coalesce(sum(ship_s_xl),0) as \"ship_s_xl\", coalesce(sum(ship_s_xxl),0) as \"ship_s_xxl\", coalesce(sum(ship_s_xxxl),0) as \"ship_s_xxxl\", coalesce(sum(ship_s_s01),0) as \"ship_s_s01\", coalesce(sum(ship_s_s02),0) as \"ship_s_s02\", coalesce(sum(ship_s_s03),0) as \"ship_s_s03\", coalesce(sum(ship_s_s04),0) as \"ship_s_s04\", coalesce(sum(ship_s_s05),0) as \"ship_s_s05\", coalesce(sum(ship_s_s06),0) as \"ship_s_s06\", coalesce(sum(ship_s_s07),0) as \"ship_s_s07\", coalesce(sum(ship_s_s08),0) as \"ship_s_s08\", coalesce(sum(ship_s_s09),0) as \"ship_s_s09\", coalesce(sum(ship_s_s10),0) as \"ship_s_s10\", coalesce(sum(ship_s_s11),0) as \"ship_s_s11\", coalesce(sum(ship_s_s12),0) as \"ship_s_s12\", coalesce(sum(ship_s_s13),0) as \"ship_s_s13\", coalesce(sum(ship_s_s14),0) as \"ship_s_s14\", coalesce(sum(ship_s_s15),0) as \"ship_s_s15\", coalesce(sum(ship_s_s16),0) as \"ship_s_s16\", coalesce(sum(ship_s_s17),0) as \"ship_s_s17\", coalesce(sum(ship_s_s18),0) as \"ship_s_s18\", coalesce(sum(ship_s_s19),0) as \"ship_s_s19\", coalesce(sum(ship_s_s20),0) as \"ship_s_s20\", coalesce(sum(ship_s_s21),0) as \"ship_s_s21\", coalesce(sum(ship_s_s22),0) as \"ship_s_s22\", coalesce(sum(ship_s_s23),0) as \"ship_s_s23\", coalesce(sum(ship_s_s24),0) as \"ship_s_s24\", coalesce(sum(ship_s_s25),0) as \"ship_s_s25\", coalesce(sum(ship_s_s26),0) as \"ship_s_s26\", coalesce(sum(ship_s_s27),0) as \"ship_s_s27\", coalesce(sum(ship_s_s28),0) as \"ship_s_s28\", coalesce(sum(ship_s_s29),0) as \"ship_s_s29\", coalesce(sum(ship_s_s30),0) as \"ship_s_s30\", coalesce(sum(ship_s_s31),0) as \"ship_s_s31\", coalesce(sum(ship_s_s32),0) as \"ship_s_s32\", coalesce(sum(ship_s_s33),0) as \"ship_s_s33\", coalesce(sum(ship_s_s34),0) as \"ship_s_s34\", coalesce(sum(ship_s_s35),0) as \"ship_s_s35\", coalesce(sum(ship_s_s36),0) as \"ship_s_s36\", coalesce(sum(ship_s_s37),0) as \"ship_s_s37\", coalesce(sum(ship_s_s38),0) as \"ship_s_s38\", coalesce(sum(ship_s_s39),0) as \"ship_s_s39\", coalesce(sum(ship_s_s40),0) as \"ship_s_s40\", coalesce(sum(ship_s_s41),0) as \"ship_s_s41\", coalesce(sum(ship_s_s42),0) as \"ship_s_s42\", coalesce(sum(ship_s_s43),0) as \"ship_s_s43\", coalesce(sum(ship_s_s44),0) as \"ship_s_s44\", coalesce(sum(ship_s_s45),0) as \"ship_s_s45\", coalesce(sum(ship_s_s46),0) as \"ship_s_s46\", coalesce(sum(ship_s_s47),0) as \"ship_s_s47\", coalesce(sum(ship_s_s48),0) as \"ship_s_s48\", coalesce(sum(ship_s_s49),0) as \"ship_s_s49\", coalesce(sum(ship_s_s50),0) as \"ship_s_s50\" from bai_pro3.ship_stat_log where ship_schedule=\"$order_del_no\" and disp_note_no>0";
			//echo $sql2."<br/>";
			
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				
				$out_qtys[]=$sql_row2['ship_s_s01'];
$out_qtys[]=$sql_row2['ship_s_s02'];
$out_qtys[]=$sql_row2['ship_s_s03'];
$out_qtys[]=$sql_row2['ship_s_s04'];
$out_qtys[]=$sql_row2['ship_s_s05'];
$out_qtys[]=$sql_row2['ship_s_s06'];
$out_qtys[]=$sql_row2['ship_s_s07'];
$out_qtys[]=$sql_row2['ship_s_s08'];
$out_qtys[]=$sql_row2['ship_s_s09'];
$out_qtys[]=$sql_row2['ship_s_s10'];
$out_qtys[]=$sql_row2['ship_s_s11'];
$out_qtys[]=$sql_row2['ship_s_s12'];
$out_qtys[]=$sql_row2['ship_s_s13'];
$out_qtys[]=$sql_row2['ship_s_s14'];
$out_qtys[]=$sql_row2['ship_s_s15'];
$out_qtys[]=$sql_row2['ship_s_s16'];
$out_qtys[]=$sql_row2['ship_s_s17'];
$out_qtys[]=$sql_row2['ship_s_s18'];
$out_qtys[]=$sql_row2['ship_s_s19'];
$out_qtys[]=$sql_row2['ship_s_s20'];
$out_qtys[]=$sql_row2['ship_s_s21'];
$out_qtys[]=$sql_row2['ship_s_s22'];
$out_qtys[]=$sql_row2['ship_s_s23'];
$out_qtys[]=$sql_row2['ship_s_s24'];
$out_qtys[]=$sql_row2['ship_s_s25'];
$out_qtys[]=$sql_row2['ship_s_s26'];
$out_qtys[]=$sql_row2['ship_s_s27'];
$out_qtys[]=$sql_row2['ship_s_s28'];
$out_qtys[]=$sql_row2['ship_s_s29'];
$out_qtys[]=$sql_row2['ship_s_s30'];
$out_qtys[]=$sql_row2['ship_s_s31'];
$out_qtys[]=$sql_row2['ship_s_s32'];
$out_qtys[]=$sql_row2['ship_s_s33'];
$out_qtys[]=$sql_row2['ship_s_s34'];
$out_qtys[]=$sql_row2['ship_s_s35'];
$out_qtys[]=$sql_row2['ship_s_s36'];
$out_qtys[]=$sql_row2['ship_s_s37'];
$out_qtys[]=$sql_row2['ship_s_s38'];
$out_qtys[]=$sql_row2['ship_s_s39'];
$out_qtys[]=$sql_row2['ship_s_s40'];
$out_qtys[]=$sql_row2['ship_s_s41'];
$out_qtys[]=$sql_row2['ship_s_s42'];
$out_qtys[]=$sql_row2['ship_s_s43'];
$out_qtys[]=$sql_row2['ship_s_s44'];
$out_qtys[]=$sql_row2['ship_s_s45'];
$out_qtys[]=$sql_row2['ship_s_s46'];
$out_qtys[]=$sql_row2['ship_s_s47'];
$out_qtys[]=$sql_row2['ship_s_s48'];
$out_qtys[]=$sql_row2['ship_s_s49'];
$out_qtys[]=$sql_row2['ship_s_s50'];

	
			}
			
			$sqlx="select * from bai_pro3.bai_orders_db_confirm where order_del_no=\"".$order_del_no."\" and order_col_des=\"".$sql_row['color']."\"";
			$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_confirmx=mysqli_num_rows($sql_resultx);

			if($sql_num_confirmx>0)
			{
				$sqlxx="select * from bai_pro3.bai_orders_db_confirm where order_del_no=\"".$order_del_no."\" and order_col_des=\"".$sql_row['color']."\"";
				$sqlxx="select * from bai_pro3.bai_orders_db_confirm where order_del_no=\"".$order_del_no."\"";
			}
			else
			{
				$sqlxx="select * from bai_pro3.bai_orders_db where order_del_no=\"".$order_del_no."\" and order_col_des=\"".$sql_row['color']."\"";
				$sqlxx="select * from bai_pro3.bai_orders_db where order_del_no=\"".$order_del_no."\"";
			}
			//echo $sqlxx."<br/>";
			$order_total=0;
			$sql_resultxx=mysqli_query($link, $sqlxx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_numxx=mysqli_num_rows($sql_resultxx);
			while($sql_rowxx=mysqli_fetch_array($sql_resultxx))
			{
						
				$o_s01=$sql_rowxx['old_order_s_s01'];
$o_s02=$sql_rowxx['old_order_s_s02'];
$o_s03=$sql_rowxx['old_order_s_s03'];
$o_s04=$sql_rowxx['old_order_s_s04'];
$o_s05=$sql_rowxx['old_order_s_s05'];
$o_s06=$sql_rowxx['old_order_s_s06'];
$o_s07=$sql_rowxx['old_order_s_s07'];
$o_s08=$sql_rowxx['old_order_s_s08'];
$o_s09=$sql_rowxx['old_order_s_s09'];
$o_s10=$sql_rowxx['old_order_s_s10'];
$o_s11=$sql_rowxx['old_order_s_s11'];
$o_s12=$sql_rowxx['old_order_s_s12'];
$o_s13=$sql_rowxx['old_order_s_s13'];
$o_s14=$sql_rowxx['old_order_s_s14'];
$o_s15=$sql_rowxx['old_order_s_s15'];
$o_s16=$sql_rowxx['old_order_s_s16'];
$o_s17=$sql_rowxx['old_order_s_s17'];
$o_s18=$sql_rowxx['old_order_s_s18'];
$o_s19=$sql_rowxx['old_order_s_s19'];
$o_s20=$sql_rowxx['old_order_s_s20'];
$o_s21=$sql_rowxx['old_order_s_s21'];
$o_s22=$sql_rowxx['old_order_s_s22'];
$o_s23=$sql_rowxx['old_order_s_s23'];
$o_s24=$sql_rowxx['old_order_s_s24'];
$o_s25=$sql_rowxx['old_order_s_s25'];
$o_s26=$sql_rowxx['old_order_s_s26'];
$o_s27=$sql_rowxx['old_order_s_s27'];
$o_s28=$sql_rowxx['old_order_s_s28'];
$o_s29=$sql_rowxx['old_order_s_s29'];
$o_s30=$sql_rowxx['old_order_s_s30'];
$o_s31=$sql_rowxx['old_order_s_s31'];
$o_s32=$sql_rowxx['old_order_s_s32'];
$o_s33=$sql_rowxx['old_order_s_s33'];
$o_s34=$sql_rowxx['old_order_s_s34'];
$o_s35=$sql_rowxx['old_order_s_s35'];
$o_s36=$sql_rowxx['old_order_s_s36'];
$o_s37=$sql_rowxx['old_order_s_s37'];
$o_s38=$sql_rowxx['old_order_s_s38'];
$o_s39=$sql_rowxx['old_order_s_s39'];
$o_s40=$sql_rowxx['old_order_s_s40'];
$o_s41=$sql_rowxx['old_order_s_s41'];
$o_s42=$sql_rowxx['old_order_s_s42'];
$o_s43=$sql_rowxx['old_order_s_s43'];
$o_s44=$sql_rowxx['old_order_s_s44'];
$o_s45=$sql_rowxx['old_order_s_s45'];
$o_s46=$sql_rowxx['old_order_s_s46'];
$o_s47=$sql_rowxx['old_order_s_s47'];
$o_s48=$sql_rowxx['old_order_s_s48'];
$o_s49=$sql_rowxx['old_order_s_s49'];
$o_s50=$sql_rowxx['old_order_s_s50'];

				
				
$old_order1[]=$sql_rowxx['old_order_s_s01'];
$old_order1[]=$sql_rowxx['old_order_s_s02'];
$old_order1[]=$sql_rowxx['old_order_s_s03'];
$old_order1[]=$sql_rowxx['old_order_s_s04'];
$old_order1[]=$sql_rowxx['old_order_s_s05'];
$old_order1[]=$sql_rowxx['old_order_s_s06'];
$old_order1[]=$sql_rowxx['old_order_s_s07'];
$old_order1[]=$sql_rowxx['old_order_s_s08'];
$old_order1[]=$sql_rowxx['old_order_s_s09'];
$old_order1[]=$sql_rowxx['old_order_s_s10'];
$old_order1[]=$sql_rowxx['old_order_s_s11'];
$old_order1[]=$sql_rowxx['old_order_s_s12'];
$old_order1[]=$sql_rowxx['old_order_s_s13'];
$old_order1[]=$sql_rowxx['old_order_s_s14'];
$old_order1[]=$sql_rowxx['old_order_s_s15'];
$old_order1[]=$sql_rowxx['old_order_s_s16'];
$old_order1[]=$sql_rowxx['old_order_s_s17'];
$old_order1[]=$sql_rowxx['old_order_s_s18'];
$old_order1[]=$sql_rowxx['old_order_s_s19'];
$old_order1[]=$sql_rowxx['old_order_s_s20'];
$old_order1[]=$sql_rowxx['old_order_s_s21'];
$old_order1[]=$sql_rowxx['old_order_s_s22'];
$old_order1[]=$sql_rowxx['old_order_s_s23'];
$old_order1[]=$sql_rowxx['old_order_s_s24'];
$old_order1[]=$sql_rowxx['old_order_s_s25'];
$old_order1[]=$sql_rowxx['old_order_s_s26'];
$old_order1[]=$sql_rowxx['old_order_s_s27'];
$old_order1[]=$sql_rowxx['old_order_s_s28'];
$old_order1[]=$sql_rowxx['old_order_s_s29'];
$old_order1[]=$sql_rowxx['old_order_s_s30'];
$old_order1[]=$sql_rowxx['old_order_s_s31'];
$old_order1[]=$sql_rowxx['old_order_s_s32'];
$old_order1[]=$sql_rowxx['old_order_s_s33'];
$old_order1[]=$sql_rowxx['old_order_s_s34'];
$old_order1[]=$sql_rowxx['old_order_s_s35'];
$old_order1[]=$sql_rowxx['old_order_s_s36'];
$old_order1[]=$sql_rowxx['old_order_s_s37'];
$old_order1[]=$sql_rowxx['old_order_s_s38'];
$old_order1[]=$sql_rowxx['old_order_s_s39'];
$old_order1[]=$sql_rowxx['old_order_s_s40'];
$old_order1[]=$sql_rowxx['old_order_s_s41'];
$old_order1[]=$sql_rowxx['old_order_s_s42'];
$old_order1[]=$sql_rowxx['old_order_s_s43'];
$old_order1[]=$sql_rowxx['old_order_s_s44'];
$old_order1[]=$sql_rowxx['old_order_s_s45'];
$old_order1[]=$sql_rowxx['old_order_s_s46'];
$old_order1[]=$sql_rowxx['old_order_s_s47'];
$old_order1[]=$sql_rowxx['old_order_s_s48'];
$old_order1[]=$sql_rowxx['old_order_s_s49'];
$old_order1[]=$sql_rowxx['old_order_s_s50'];
				
				$order_total+=$o_s01+$o_s02+$o_s03+$o_s04+$o_s05+$o_s06+$o_s07+$o_s08+$o_s09+$o_s10+$o_s11+$o_s12+$o_s13+$o_s14+$o_s15+$o_s16+$o_s17+$o_s18+$o_s19+$o_s20+$o_s21+$o_s22+$o_s23+$o_s24+$o_s25+$o_s26+$o_s27+$o_s28+$o_s29+$o_s30+$o_s31+$o_s32+$o_s33+$o_s34+$o_s35+$o_s36+$o_s37+$o_s38+$o_s39+$o_s40+$o_s41+$o_s42+$o_s43+$o_s44+$o_s45+$o_s46+$o_s47+$o_s48+$o_s49+$o_s50;
			
				
			} 
			for($i=0;$i<sizeof($order_qtys);$i++)
			{
				$val1=($order_qtys[$i]/div_by_zero($old_order1[$i]))*100;
				if($val1 > 0)
				{
					$order_per[]=$val1;
				}
				
				//$order_qtys[$i]=$order_qtys[$i]-$out_qtys[$i];
				$order_qtys[$i]=$order_qtys[$i]-$out_qtys[$i];
			}			

			if(($sql_row['scanned']-$sql_row['rev_shipped']) != 0)
			{			
				$current_time=strtotime(date("Y-m-d"));
				$order_time=strtotime($sql_row['order_date']);
				//future shipment
				if($current_time < $order_time)
				{
				  $colour="#1dc804";
				}
				//present shipment
				else if($current_time == $order_time)
				{
				  $colour="#f2ec00";
				}
				//past shipment
				else if($order_time <$current_time)
				{
				  $colour="#e10c00";
				}
				if($order_per)
				{
					if(number_format((min($order_per)),2) < 100)
					{
						$colour=""; 
					}	
				}			 
				echo "<tr>";
				
				//CR#773 / kirang / 2015-03-17 / FG Stock summary report. - Ex - Factory Taken From Weekly Delivery Reference if ex factory revises, Track the Past, Present and Future shipments in FG Warehouse. 
				
				$ex_factory=$sql_row['order_date'];
				
				$sql_rev_ex="select * from bai_pro4.week_delivery_plan_ref where schedule_no=\"".$sql_row['order_del_no']."\" and color=\"".$sql_row['color']."\" and style=\"".$sql_row['order_style_no']."\"";
				$sql_rev_exx=mysqli_query($link, $sql_rev_ex) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_rev_ex_numxx=mysqli_num_rows($sql_rev_exx);
				if($sql_rev_ex_numxx > 0)
				{
					while($sql_rowxx1=mysqli_fetch_array($sql_rev_exx))
					{
						$rev_ex_fact=$sql_rowxx1["rev_exfactory"];
					}
				}
				else
				{
					$rev_ex_fact="0000-00-00";
				}
				
				if($rev_ex_fact != "0000-00-00")
				{
					$ex_factory=$rev_ex_fact;
				}
				
				//echo "<td class=\"lef\">".$ex_factory."</td>";
				echo "<td class=\"lef\">".$ex_factory."</td>";
				//Service Request #605496 / kirang / 2015-05-13 / Schedule has added in the FG stock summary Report.
				if($color == "#e10c00" )
				{
					echo "<td class=\"lef\" bgcolor='$colour' style='color:#FFFFFF;'>".$sql_row['order_del_no']."</td>";
				}
				else
				{
					echo "<td class=\"lef\" bgcolor='$colour'>".$sql_row['order_del_no']."</td>";
				}
				echo "<td class=\"lef\">".$sql_row['order_style_no']."</td>";
				echo "<td class=\"lef\">".$sql_row['color']."</td>";
				echo "<td class=\"lef\">".$order_total."</td>";
				echo "<td class=\"lef\">".$sql_row['total_qty']."</td>";
				echo "<td class=\"lef\">".$sql_row['scanned']."</td>";
				echo "<td class=\"lef\">".$sql_row['unscanned']."</td>";
				echo "<td class=\"lef\">".$sql_row['embellish']."</td>";
				echo "<td class=\"lef\">".$sql_row['rev_shipped']."</td>";				
				echo "<td class=\"lef\">".($sql_row['total_qty']-$sql_row['rev_shipped'])."</td>";
				echo "<td class=\"lef\">".($sql_row['scanned']-$sql_row['rev_shipped'])."</td>";
				echo "<td class=\"lef\">Size<hr>Qty</td>";
				for($i=0;$i<sizeof($sizes_db);$i++)
				{
					if($order_qtys[$i]>0)
					{
						$size_title=ims_sizes('',$sql_row['order_del_no'],$sql_row['order_style_no'],'',$sizes_db[$i],$link);
						echo "<td>".$size_title."<hr>".$order_qtys[$i]."</td>";
					}
					else
					{
						echo "<td></td>";
					}
					
				}
				
				echo "<td class=\"lef\">".number_format((min($order_per)),2)."</td>";
				
				//CR#773 / kirang / 2015-03-17 / FG Stock summary report. - Ex - Factory Taken From Weekly Delivery Reference if ex factory revises, Track the Past, Present and Future shipments in FG Warehouse. 
				
				if(number_format((min($order_per)),2) < 100)
				{
					$category="<100"; 
				}
				else if(number_format((min($order_per)),2) == 100)
				{
					$category="100";
				}
				else if((100 < number_format((min($order_per)),2)) && (number_format((min($order_per)),2) < 102))
				{
					$category="100+";
				}
				else if(102 <= number_format((min($order_per)),2))
				{
					$category="102";
				}
			
			    echo "<td class=\"lef\">".$category."</td>";
			
				if($current_time < $order_time)
				{
					echo "<td class=\"lef\">Future shipment</td>";
				}
			    else if($current_time == $order_time)
				{
					echo "<td class=\"lef\">current shipment</td>";
				}
				else if($order_time < $current_time)
				{
					echo "<td class=\"lef\">Past shipment</td>";
				}
						
				//CR#773 / kirang / 2015-03-17 / FG Stock summary report. - Ex - Factory Taken From Weekly Delivery Reference if ex factory revises, Track the Past, Present and Future shipments in FG Warehouse. 		
						
				echo "</tr>";
			}
			
			switch(substr($sql_row['order_style_no'],0,1))
			{
				case "L":
				{
					$logo_stock+=($sql_row['scanned']-$sql_row['rev_shipped']);
					break;
				}
				case "G":
				{
					$logo_stock+=($sql_row['scanned']-$sql_row['rev_shipped']);
					break;
				}
				case "O":
				{
					$logo_stock+=($sql_row['scanned']-$sql_row['rev_shipped']);
					break;
				}
				case "P":
				{
					$pink_stock+=($sql_row['scanned']-$sql_row['rev_shipped']);
					break;
				}
				case "K":
				{
					$pink_stock+=($sql_row['scanned']-$sql_row['rev_shipped']);
					break;
				}
				case "I":
				{
					$pink_stock+=($sql_row['scanned']-$sql_row['rev_shipped']);
					break;
				}
				case "S":
				{
					$pink_stock+=($sql_row['scanned']-$sql_row['rev_shipped']);
					break;
				}
				case "M":
				{
					$mns_stock+=($sql_row['scanned']-$sql_row['rev_shipped']);
					break;
				}
			} 
			$balance+=($sql_row['scanned']-$sql_row['rev_shipped']);
			
			unset($order_qtys);
			unset($out_qtys);
			unset($old_order1);
			unset($order_per);
	}																																																																																																																																																																									
	}
}


echo "</table></div>";

echo "<div class='col-md-4 col-sm-offset-8' style='margin-top:-530px;position:relative'><u>Quick Stats</u><table class=\"table table-bordered\"><tr><td>Pink </td><td>$pink_stock</td></tr><tr><td>Logo</td><td>$logo_stock</td></tr><tr><td>M&S</td><td>$mns_stock</td></tr><tr><td><strong>Total</strong></td><td><strong>$balance</strong></td></tr></table></div>";
?>
</div></div>



<?php
$cachefile1 =$path."/packing/reports/".$cache_date.'.html';
// $cachefile = $cache_date.'.html';
// open the cache file "cache/home.html" for writing
$fp = fopen($cachefile1, 'w');
// save the contents of output buffer to the file
fwrite($fp, ob_get_contents());
// close the file
fclose($fp);
// Send the output to the browser
ob_end_flush();

	$write='<?php $fg_wip='.$balance.'; ?>';
	//To Write File
	$myFile = 'fg_wip.php';
	$cachefile2 =$path."/packing/reports/".$myFile;

	$fh = fopen($cachefile2, 'w') ;
	$stringData = $write;
	fwrite($fh, $stringData);
	fclose($fh);
	//To Write File
	
	//Drop TEMP Tables	
	/*
	$sql="DROP TABLE $fg_wh_report_summary";
	mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	
	$sql="DROP TABLE $packing_summary";
	mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	*/

//echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
echo "Execution took ".$duration." milliseconds.";
?>
</body>
</html>
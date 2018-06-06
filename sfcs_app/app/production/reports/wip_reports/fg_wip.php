
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',4,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',4,'R'); ?>"></script>
<style>
table {	
	text-align:center;
	font-size:12px;
	width:100%;
	padding: 1em 1em 1em 1em;
	margin-top:-1em;
	color:black;
}
th{
	background-color:#003366;
	color:white;
	text-align:center;
}

.fltrow{
	color:#FFFFFF;
	text-align:center;
}
.rdiv{
	color: black;
    display: inline-block;
    background-color: #52e56b;
    padding: 0.5em 0.5em 0.5em 0.5em;
    margin-bottom: 1em;
    text-align: right;
    margin-left: 70em;
	margin-top:-6em;
}
.ldiv{
	color: black;
    display: inline-block;
    background-color: #dbd4d4;
    padding: 0.3em 0.3em 0.3em 0.3em;
    margin-bottom: 1em;
    margin-top: -6em;
    text-align: right;
    margin-left: 0em;
}


</style>

<?php
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
	$view_access=user_acl("SFCS_0018",$username,1,$group_id_sfcs);//1
?>
<title>FG WIP</title>
<div class="panel panel-primary">
	<div class="panel-heading">FG WIP</div>
	<div class="panel-body">
	<br/>
		<?php
			set_time_limit(6000000);
			//$msg="<table border='1px' class='mytable' id='table1'><tr><th>Schedule No</th><th>Doc No</th><th>Cut No</th><th>Scanned Qty</th><th>Unscanned Qty</th><th>Input</th><th>Output</th></tr>";
			$msg="
			<div class='col-sm-12' style='max-height:800px;overflow-y:scroll;'><table class='table table-bordered table-striped' id='table1'>
			<thead><tr><th>Buyer Division</th><th>Style</th><th>Schedule</th><th>Color</th><th>FG WIP</th><th>EX-Factory</th></tr></thead>";
			$sqlw="select distinct order_del_no as del_no FROM $bai_pro3.packing_summary WHERE date(lastup) >= \"2015-01-01\"";
			$resultw=mysqli_query($link, $sqlw) or die("Sql error--1".$sql.mysqli_errno($GLOBALS["___mysqli_ston"]));
			//echo $sqlw;
			while($roww=mysqli_fetch_array($resultw))
			{
				$schedule_ref=$roww['del_no'];
				$sql="select order_style_no,order_col_des,order_del_no,doc_no,acutno,size_code from $bai_pro3.packing_summary WHERE order_del_no =\"".$schedule_ref."\" and STATUS=\"DONE\" group by order_del_no order by order_del_no, doc_no,size_code";
				$result=mysqli_query($link, $sql) or die("Sql error--1".$sql.mysqli_errno($GLOBALS["___mysqli_ston"]));
				//echo $sql;
				while($row=mysqli_fetch_array($result))
				{
					$schedule=$row['order_del_no'];
					$color_ref=$row['order_col_des'];
					$style_ref=$row['order_style_no'];
					$doc_no=$row['doc_no'];	

					$sql1="select * from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$schedule."\"";
					//echo $sql1;
					$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_num_rows($result1)==0)
					{
						$sql1="select * from $bai_pro3.bai_orders_db_confirm_archive where order_del_no=\"".$schedule."\"";
					}
					$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row1=mysqli_fetch_array($result1))
					{
						$order_tid=$row1["order_tid"];
					}
					
					$sql1="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"".$order_tid."\"";
					$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_num_rows($result1)==0)
					{
						$sql1="select * from $bai_pro3.bai_orders_db_confirm_archive where order_tid=\"".$order_tid."\"";
					}
					$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row1=mysqli_fetch_array($result1))
					{
						$buyer=$row1["order_div"];
						$order_style_no=$row1["order_style_no"];
						$order_del_no=$row1["order_del_no"];
						$order_col_des=$row1["order_col_des"];
						$order_date=$row1["order_date"];
					}
					$ship_total=0;
					$sql_ship="select sum(ship_s_xs),sum(ship_s_s),sum(ship_s_m),sum(ship_s_l),sum(ship_s_xl),sum(ship_s_xxl),sum(ship_s_xxxl),sum(ship_s_s06),
					sum(ship_s_s08),sum(ship_s_s10),sum(ship_s_s12),sum(ship_s_s14),sum(ship_s_s16),sum(ship_s_s18),sum(ship_s_s20),sum(ship_s_s22),sum(ship_s_s24),
					sum(ship_s_s26),sum(ship_s_s28),sum(ship_s_s30) from $bai_pro3.ship_stat_log where ship_schedule=\"".$order_del_no."\"";
					$result_ship=mysqli_query($link, $sql_ship) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row3=mysqli_fetch_array($result_ship))
					{
						$ship_s_xs=$row3["sum(ship_s_xs)"];
						$ship_s_s=$row3["sum(ship_s_s)"];
						$ship_s_m=$row3["sum(ship_s_m)"];
						$ship_s_l=$row3["sum(ship_s_l)"];
						$ship_s_xl=$row3["sum(ship_s_xl)"];
						$ship_s_xxl=$row3["sum(ship_s_xxl)"];
						$ship_s_xxxl=$row3["sum(ship_s_xxxl)"];
						$ship_s_s06=$row3["sum(ship_s_s06)"];
						$ship_s_s08=$row3["sum(ship_s_s08)"];
						$ship_s_s10=$row3["sum(ship_s_s10)"];
						$ship_s_s12=$row3["sum(ship_s_s12)"];
						$ship_s_s14=$row3["sum(ship_s_s14)"];
						$ship_s_s16=$row3["sum(ship_s_s16)"];
						$ship_s_s18=$row3["sum(ship_s_s18)"];
						$ship_s_s20=$row3["sum(ship_s_s20)"];
						$ship_s_s22=$row3["sum(ship_s_s22)"];
						$ship_s_s24=$row3["sum(ship_s_s24)"];
						$ship_s_s26=$row3["sum(ship_s_s26)"];
						$ship_s_s28=$row3["sum(ship_s_s28)"];
						$ship_s_s30=$row3["sum(ship_s_s30)"];
					}
					
					$ship_total=$ship_s_xs+$ship_s_s+$ship_s_m+$ship_s_l+$ship_s_xl+$ship_s_xxl+$ship_s_xxxl+$ship_s_s06+$ship_s_s08+$ship_s_s10+$ship_s_s12+$ship_s_s14+$ship_s_s16+$ship_s_s18+$ship_s_s20+$ship_s_s22+$ship_s_s24+$ship_s_s26+$ship_s_s28+$ship_s_s30;
				
					//SR#58668468 / kirang / 2016-04-11 / Packing WIP Report. - Changed the query to refer the values scanned Quantities.
				
					//$scanned_qty=$row['carton'];
					$sql_scan="select sum(carton_act_qty) as qty from $bai_pro3.packing_summary where order_del_no=\"".$schedule."\" and status=\"DONE\"";
					$result_scan=mysqli_query($link, $sql_scan) or die("Sql error--3".$sql_scan.mysqli_errno($GLOBALS["___mysqli_ston"]));
					while($row_scan=mysqli_fetch_array($result_scan))
					{
						$scanned_qty=$row_scan["qty"];
					}
					
					$shipped_qty=$ship_total;
					$fg_wip=$scanned_qty-$shipped_qty;
					//echo $scanned_qty."-".$shipped_qty;
					if($fg_wip > 0)
					{	 
						$msg.="<tr><td style='text-align:left;'>".$buyer."</td><td>".$order_style_no."</td><td>".$order_del_no."</td><td style='text-align:left;'>".$order_col_des."</td><td>".$fg_wip."</td><td>".$order_date."</td></tr>";
					}	 
				}
			}
			$msg.="</table></div>";
			echo $msg;
		?>
	</div>
</div>
<script language="javascript" type="text/javascript">
// <![CDATA[
	// var table6_Props = 	{
							// rows_counter: true,
							// btn_reset: true,
							// loader: true,
							// loader_text: "Filtering data..."
						// };
	// setFilterGrid( "table1",table6_Props );
//]]>
</script>
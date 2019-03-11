
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',4,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',4,'R'); ?>"></script>
<style>
table {	
	text-align:center;
	font-size:12px;
	width:100%;
	color:black;
}
th{
	background-color:#29759c;
	color:white;
	text-align:center;
}

.fltrow{
	color:#FFFFFF;
	text-align:center;
}
.table-responsive{
	margin-top:-40pt;
}
/* .rdiv{
	color: black;
    display: inline-block;
    background-color: #52e56b;
    padding: 0.5em 0.5em 0.5em 0.5em;
    margin-bottom: 1em;
    text-align: right;
    margin-left: 70em;
	margin-top:-6em;
} */
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
	$view_access=user_acl("SFCS_0018",$username,1,$group_id_sfcs);
?>
<title>FG WIP</title>
<div class="panel panel-primary">
	<div class="panel-heading">FG WIP</div>
	<div class="panel-body">
	<br/>
		<?php
			set_time_limit(6000000);
			$msg="
			<div class='table-responsive'><table class='table table-bordered table-striped' id='table1'>
			<thead><tr><th>Buyer Division</th><th>Style</th><th>Schedule</th><th>Color</th><th>FG WIP</th><th>EX-Factory</th></tr></thead>";
			$sqlw="select distinct order_del_no as del_no FROM $bai_pro3.packing_summary WHERE date(lastup) >= '2015-01-01' and order_del_no is not null";
			$resultw=mysqli_query($link, $sqlw) or die("Sql error--1".$sql.mysqli_errno($GLOBALS["___mysqli_ston"]));
			while($roww=mysqli_fetch_array($resultw))
			{
				$schedule_ref=$roww['del_no'];
				$sql="select order_style_no,order_col_des,order_del_no,doc_no,size_code from $bai_pro3.packing_summary WHERE order_del_no =\"".$schedule_ref."\" and STATUS=\"DONE\" group by order_del_no order by order_del_no, doc_no,size_code";
				$result=mysqli_query($link, $sql) or die("Sql error--1".$sql.mysqli_errno($GLOBALS["___mysqli_ston"]));
				while($row=mysqli_fetch_array($result))
				{
					$schedule=$row['order_del_no'];
					$color_ref=$row['order_col_des'];
					$style_ref=$row['order_style_no'];
					$doc_no=$row['doc_no'];	

					$sql1="select * from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$schedule."\"";
					//echo $sql1;
					$result1=mysqli_query($link, $sql1) or die("Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_num_rows($result1)==0)
					{
						$sql1="select order_tid from $bai_pro3.bai_orders_db_confirm_archive where order_del_no=\"".$schedule."\"";
					}
					$result1=mysqli_query($link, $sql1) or die("Error2=".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row1=mysqli_fetch_array($result1))
					{
						$order_tid=$row1["order_tid"];
					}
					
					$sql1="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"".$order_tid."\"";
					$result1=mysqli_query($link, $sql1) or die("Error3=".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_num_rows($result1)==0)
					{
						$sql1="select order_div,order_style_no,order_del_no,order_col_des,order_date from $bai_pro3.bai_orders_db_confirm_archive where order_tid=\"".$order_tid."\"";
					}
					$result1=mysqli_query($link, $sql1) or die("Error4=".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row1=mysqli_fetch_array($result1))
					{
						$buyer=$row1["order_div"];
						$order_style_no=$row1["order_style_no"];
						$order_del_no=$row1["order_del_no"];
						$order_col_des=$row1["order_col_des"];
						$order_date=$row1["order_date"];
					}
					$ship_total=0;
					$sql_ship="select sum(ship_s_xs),sum(ship_s_s),sum(ship_s_m),sum(ship_s_l),sum(ship_s_xl),sum(ship_s_xxl),sum(ship_s_xxxl),sum(ship_s_s01),sum(ship_s_s02),sum(ship_s_s03),sum(ship_s_s04),sum(ship_s_s05),sum(ship_s_s06),sum(ship_s_s07),sum(ship_s_s08),sum(ship_s_s09),sum(ship_s_s10),sum(ship_s_s11),sum(ship_s_s12),sum(ship_s_s13),sum(ship_s_s14),sum(ship_s_s15),sum(ship_s_s16),sum(ship_s_s17),sum(ship_s_s18),sum(ship_s_s19),sum(ship_s_s20),sum(ship_s_s21),sum(ship_s_s22),sum(ship_s_s23),sum(ship_s_s24),sum(ship_s_s25),sum(ship_s_s26),sum(ship_s_s27),sum(ship_s_s28),sum(ship_s_s29),
					sum(ship_s_s30),sum(ship_s_s31),sum(ship_s_s32),sum(ship_s_s33),sum(ship_s_s34),sum(ship_s_s35),sum(ship_s_s36),sum(ship_s_s37),sum(ship_s_s38),
					sum(ship_s_s39),sum(ship_s_s40),sum(ship_s_s41),sum(ship_s_s42),sum(ship_s_s43),sum(ship_s_s44),sum(ship_s_s45),sum(ship_s_s46),sum(ship_s_s47),sum(ship_s_s48),sum(ship_s_s49),sum(ship_s_s50) from $bai_pro3.ship_stat_log where ship_schedule=\"".$order_del_no."\"";
					//echo $sql_ship;
					$result_ship=mysqli_query($link, $sql_ship) or die("Error5=".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row3=mysqli_fetch_array($result_ship))
					{

						$ship_s_xs=$row3["sum(ship_s_xs)"];
						$ship_s_s=$row3["sum(ship_s_s)"];
						$ship_s_m=$row3["sum(ship_s_m)"];
						$ship_s_l=$row3["sum(ship_s_l)"];
						$ship_s_xl=$row3["sum(ship_s_xl)"];
						$ship_s_xxl=$row3["sum(ship_s_xxl)"];
						$ship_s_xxxl=$row3["sum(ship_s_xxxl)"];

                        $ship_s_s01=$row3["sum(ship_s_s01)"];
						$ship_s_s02=$row3["sum(ship_s_s02)"];
						
						$ship_s_s03=$row3["sum(ship_s_s03)"];
						$ship_s_s04=$row3["sum(ship_s_s04)"];
						$ship_s_s05=$row3["sum(ship_s_s05)"];
						$ship_s_s06=$row3["sum(ship_s_s06)"];
						$ship_s_s07=$row3["sum(ship_s_s07)"];
						$ship_s_s08=$row3["sum(ship_s_s08)"];
						$ship_s_s09=$row3["sum(ship_s_s09)"];
						$ship_s_s10=$row3["sum(ship_s_s10)"];
						$ship_s_s11=$row3["sum(ship_s_s11)"];
						$ship_s_s12=$row3["sum(ship_s_s12)"];
						$ship_s_s13=$row3["sum(ship_s_s13)"];
						$ship_s_s14=$row3["sum(ship_s_s14)"];
						$ship_s_s15=$row3["sum(ship_s_s15)"];
						$ship_s_s16=$row3["sum(ship_s_s16)"];
						$ship_s_s17=$row3["sum(ship_s_s17)"];
						$ship_s_s18=$row3["sum(ship_s_s18)"];
						$ship_s_s19=$row3["sum(ship_s_s19)"];
						$ship_s_s20=$row3["sum(ship_s_s20)"];
						$ship_s_s21=$row3["sum(ship_s_s21)"];
						$ship_s_s22=$row3["sum(ship_s_s22)"];
						$ship_s_s23=$row3["sum(ship_s_s23)"];
						$ship_s_s24=$row3["sum(ship_s_s24)"];
						$ship_s_s25=$row3["sum(ship_s_s25)"];
						$ship_s_s26=$row3["sum(ship_s_s26)"];
						$ship_s_s27=$row3["sum(ship_s_s27)"];
						$ship_s_s28=$row3["sum(ship_s_s28)"];
						$ship_s_s29=$row3["sum(ship_s_s29)"];
						$ship_s_s30=$row3["sum(ship_s_s30)"];
						$ship_s_s31=$row3["sum(ship_s_s31)"];
						$ship_s_s32=$row3["sum(ship_s_s32)"];
						$ship_s_s33=$row3["sum(ship_s_s33)"];
						$ship_s_s34=$row3["sum(ship_s_s34)"];
						$ship_s_s35=$row3["sum(ship_s_s35)"];
						$ship_s_s36=$row3["sum(ship_s_s36)"];
						$ship_s_s37=$row3["sum(ship_s_s37)"];
						$ship_s_s38=$row3["sum(ship_s_s38)"];
						$ship_s_s39=$row3["sum(ship_s_s39)"];
						$ship_s_s40=$row3["sum(ship_s_s40)"];
						$ship_s_s41=$row3["sum(ship_s_s41)"];
						$ship_s_s42=$row3["sum(ship_s_s42)"];
						$ship_s_s43=$row3["sum(ship_s_s43)"];
						$ship_s_s44=$row3["sum(ship_s_s44)"];
						$ship_s_s45=$row3["sum(ship_s_s45)"];
						$ship_s_s46=$row3["sum(ship_s_s46)"];
						$ship_s_s47=$row3["sum(ship_s_s47)"];
						$ship_s_s48=$row3["sum(ship_s_s48)"];
						$ship_s_s49=$row3["sum(ship_s_s49)"];
						$ship_s_s50=$row3["sum(ship_s_s50)"];


					}
					
					$ship_total=$ship_s_xs+$ship_s_s+$ship_s_m+$ship_s_l+$ship_s_xl+$ship_s_xxl+$ship_s_xxxl+
					$ship_s_s01+$ship_s_s02+$ship_s_s03+$ship_s_s04+$ship_s_s05+$ship_s_s06+$ship_s_s07
					+$ship_s_s08+$ship_s_s09+$ship_s_s10+$ship_s_s11+$ship_s_s12+$ship_s_s13+$ship_s_s14+$ship_s_s15+$ship_s_s16+$ship_s_s17+$ship_s_s18+$ship_s_s19+$ship_s_s20+$ship_s_s21+$ship_s_s22+$ship_s_s23+$ship_s_s24+$ship_s_s25+$ship_s_s26+$ship_s_s27+$ship_s_s28+$ship_s_s29+$ship_s_s30+$ship_s_s31+$ship_s_s32+$ship_s_s33+$ship_s_s34+$ship_s_s35+$ship_s_s36+$ship_s_s37+$ship_s_s38+$ship_s_s39+$ship_s_s40+$ship_s_s41+$ship_s_s42+$ship_s_s43+$ship_s_s44+$ship_s_s45+$ship_s_s46+$ship_s_s47+$ship_s_s48+$ship_s_s49+$ship_s_s50;
				
					$sql_scan="select sum(carton_act_qty) as qty from $bai_pro3.packing_summary where order_del_no=\"".$schedule."\" and status='DONE'";
					$result_scan=mysqli_query($link, $sql_scan) or die("Sql error--3".$sql_scan.mysqli_errno($GLOBALS["___mysqli_ston"]));
					while($row_scan=mysqli_fetch_array($result_scan))
					{
						$scanned_qty=$row_scan["qty"];
					}
					
					$shipped_qty=$ship_total;
					$fg_wip=$scanned_qty-$shipped_qty;
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
	$('#reset_table1').addClass('btn btn-warning');
// <![CDATA[
	var table6_Props = 	{
							rows_counter: true,
							btn_reset: true,
							btn_reset_text: "Clear",
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "table1",table6_Props );
	$(document).ready(function(){
		$('#reset_table1').addClass('btn btn-warning btn-xs');
	});
// ]]>
</script>
<style>
.flt{
	color:black;
}
#reset_table1{
	width : 80px;
	color : #fff;
	margin-top : 80px;
	margin-left : -110px;
	margin-bottom:15pt;
}
</style>
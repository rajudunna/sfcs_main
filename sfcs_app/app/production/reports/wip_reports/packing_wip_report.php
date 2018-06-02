
<?php
include("../".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include("../".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
$view_access=user_acl("SFCS_0019",$username,1,$group_id_sfcs);
?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.min.js',4,'R') ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/datetimepicker_css.js',4,'R') ?>"></script>

<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/style.css',4,'R'); ?>">

<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/css/table.css',4,'R'); ?>">
<!---<style type="text/css">
#div-1a {
 position:absolute;
 top:65px;
 right:0;
 width:auto;
 float:right;
</style>
<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{ 
	/* margin:15px; padding:15px; border:1px solid #666; */
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
}


h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px;  padding:5px; background-color:#f4f4f4; solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; outset #f4f4f4; margin:2px; }
.mytable th{ background-color:#29759c; color:#FFF; width: 100px; padding:2px; solid #ccc; white-space: nowrap;}
td{ padding:2px; width: 100px; white-space: nowrap;}

</style>--->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'TableFilter_EN/actb.js',1,'R') ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',4,'R') ?>"></script>
<script language="javascript" type="text/javascript"></script>

<!---<div id="page_heading"><span style="float:"><h3>Packing WIP</h3></span><span style="float: right">&nbsp;</span></div>--->

<div class="panel panel-primary">
<div class="panel-heading">Packing WIP</div>
<div class="panel-body">

<?php
    set_time_limit(6000000);
	//$msg="<table border='1px' class='mytable' id='table1'><tr><th>Schedule No</th><th>Doc No</th><th>Cut No</th><th>Scanned Qty</th><th>Unscanned Qty</th><th>Input</th><th>Output</th></tr>";
	$msg="<table class='table table-bordered'  id='table1'><tr><th class='text-center'>Buyer Division</th><th class='text-center'>Style</th><th class='text-center'>CO</th><th class='text-center'>Schedule</th><th class='text-center'>Color</th><th class='text-center'>Packing WIP</th><th class='text-center'>EX-Factory</th></tr>";
$sqlw="select distinct order_del_no as del_no FROM $bai_pro3.packing_summary WHERE date(lastup) >= \"2015-01-01\"";
//echo $sqlw;
$resultw=mysqli_query($link, $sqlw) or die("Sql error--1".$sql.mysqli_errno($GLOBALS["___mysqli_ston"]));
while($roww=mysqli_fetch_array($resultw))
{
	$schedule_ref=$roww['del_no'];	
    $sql="select order_style_no,order_col_des,order_del_no,doc_no,acutno,size_code from $bai_pro3.packing_summary WHERE order_del_no=\"".$schedule_ref."\" group by order_del_no order by order_del_no,doc_no,size_code";
	//echo $sql."<br>";
	$result=mysqli_query($link, $sql) or die("Sql error--1".$sql.mysqli_errno($GLOBALS["___mysqli_ston"]));
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
		
		
		$sql1="select * from $bai_pro3.ims_log where ims_mod_no > 0 and ims_remarks!='Sample' and ims_schedule=\"".$schedule."\" and ims_style=\"".$style_ref."\"";
		$result1=mysqli_query($link, $sql1) or die("Sql error--2".$sql1.mysqli_errno($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($result1) > 0)
		{
			$sql2="select sum(ims_qty) as input1,sum(ims_pro_qty) as output1 from $bai_pro3.ims_log where ims_schedule=\"".$schedule."\" and ims_style=\"".$style_ref."\" and ims_mod_no > 0 and ims_remarks!='Sample'";
			$result2=mysqli_query($link, $sql2) or die("Sql error--3".$sql2.mysqli_errno($GLOBALS["___mysqli_ston"]));
			while($row2=mysqli_fetch_array($result2))
			{
				$input1=$row2['input1'];
				$output1=$row2['output1'];
			}
		}
		else
		{
			$input1=0;
			$output1=0;
		}
		
		$sql3="select * from $bai_pro3.ims_log_backup where ims_mod_no > 0 and ims_remarks!='Sample' and ims_schedule=\"".$schedule."\" and ims_style=\"".$style_ref."\"";
		$result3=mysqli_query($link, $sql3) or die("Sql error--2".$sql3.mysqli_errno($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($result3) > 0)
		{
			$sql4="select sum(ims_qty) as input1,sum(ims_pro_qty) as output1 from $bai_pro3.ims_log_backup where ims_schedule=\"".$schedule."\" and ims_style=\"".$style_ref."\" and ims_mod_no > 0 and ims_remarks!='Sample'";
			$result4=mysqli_query($link, $sql4) or die("Sql error--3".$sql4.mysqli_errno($GLOBALS["___mysqli_ston"]));
			while($row4=mysqli_fetch_array($result4))
			{
				$input2=$row4['input1'];
				$output2=$row4['output1'];
			}
		}
		else
		{
			$input2=0;
			$output2=0;
		}
		 
		$input=$input1+$input2;	 
		$output=$output1+$output2; 
		$egs_qty=0;
		$egr_qty=0;
				
		//SR#58668468 / kirang / 2016-04-11 / Packing WIP Report. - Changed the query to refer the values scanned, EGS,EGR quantities.
		
		$sql_scan="select sum(carton_act_qty) as qty from $bai_pro3.packing_summary where order_del_no=\"".$schedule."\" and status=\"DONE\"";
		$result_scan=mysqli_query($link, $sql_scan) or die("Sql error--3".$sql_scan.mysqli_errno($GLOBALS["___mysqli_ston"]));
		while($row_scan=mysqli_fetch_array($result_scan))
		{
			$scanned_qty=$row_scan["qty"];
		}
		
		$sql_egr="select sum(carton_act_qty) as qty from $bai_pro3.packing_summary where order_del_no=\"".$schedule."\" and status=\"EGR\"";
		$result_egr=mysqli_query($link, $sql_egr) or die("Sql error--3".$sql_egr.mysqli_errno($GLOBALS["___mysqli_ston"]));
		while($row_egr=mysqli_fetch_array($result_egr))
		{
			$egr_qty=$row_egr["qty"];
		}
		
		$sql_egs="select sum(carton_act_qty) as qty from $bai_pro3.packing_summary where order_del_no=\"".$schedule."\" and status=\"EGS\"";
		$result_egs=mysqli_query($link, $sql_egs) or die("Sql error--3".$sql_egs.mysqli_errno($GLOBALS["___mysqli_ston"]));
		while($row_egs=mysqli_fetch_array($result_egs))
		{
			$egs_egs=$row_egs["qty"];
		}
		
		
		//$scanned_qty=$row['carton'];
		//$egr_qty=$row['carton1'];
		//$egs_qty=$row['carton2'];
		//echo "Qty=".$output."-".$scanned_qty."-".$egr_qty."-".$egs_qty."<br>";
		$packing_wip=$output-$scanned_qty-$egr_qty-$egs_qty;
		if($packing_wip > 0)
		{	 
			//$msg.="<tr><td>".$row['order_del_no']."</td><td>".$row['doc_no']."</td><td>".$row['acutno']."</td><td>".$row['carton']."</td><td>".$row['carton1']."</td><td>".$input."</td><td>".$output."</td></tr>";
			$msg.="<tr><td>".$buyer."</td><td>".$order_style_no."</td><td></td><td>".$order_del_no."</td><td>".$order_col_des."</td><td>".$packing_wip."</td><td>".$order_date."</td></tr>";
		}	 
	}
}
	$msg.="</table>";
	echo $msg;
?>
<script language="javascript" type="text/javascript">
//<![CDATA[
	var table6_Props = 	{
							rows_counter: true,
							btn_reset: true,
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "table1",table6_Props );
//]]>
</script>

</div>
</div>
</div>
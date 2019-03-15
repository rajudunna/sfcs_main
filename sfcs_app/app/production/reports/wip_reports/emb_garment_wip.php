
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.min.js',4,'R') ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/datetimepicker_css.js',4,'R') ?>"></script>

<link rel="stylesheet" type="text/css" href="table.css">

<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',4,'R'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',4,'R'); ?>"></script>
<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
 
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	
?>
</head>
<body>
<style>
th{
	background-color:#29759c;
	color:white;
	text-align:center;
}
</style>
<br/>

<div class="panel panel-primary">
<div class="panel-heading">Embellishment Garment WIP</div>
<div class="panel-body">

<?php
    set_time_limit(6000000);
	$msg="<table id='table1' class='table table-bordered'><tr><th>Buyer Division</th><th>Style</th><th>CO</th><th>Schedule</th><th>Color</th><th>EMB GARMENT WIP</th><th>EX-Factory</th></tr>";
    $sql="select order_style_no,order_col_des,order_del_no,doc_no,size_code,if(status ='DONE',sum(carton_act_qty),0) as carton,if(status='EGR',sum(carton_act_qty),0) as carton1,if(status='EGS',sum(carton_act_qty),0) as carton2 from $bai_pro3.packing_summary WHERE date(lastup) >= \"2015-01-01\" and STATUS IN (\"EGR\",\"EGS\") group by order_del_no order by order_del_no, doc_no,size_code";
	//echo $sql."<br>";
	$result=mysqli_query($link, $sql) or die("Sql error--1".$sql.mysqli_errno($GLOBALS["___mysqli_ston"]));
	if(mysqli_fetch_array($result)>0){
		while($row=mysqli_fetch_array($result))
		{
			$schedule=$row['order_del_no'];
			$color_ref=$row['order_col_des'];
			$style_ref=$row['order_style_no'];
			$doc_no=$row['doc_no'];	

			$sql1="select co_no from $bai_pro3.bai_orders_db where order_tid=\"".$order_tid."\"";
			$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row1=mysqli_fetch_array($result1))
			{
				$co_no=$row1["co_no"];
			}	

			$sql1="select * from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$schedule."\" and order_col_des=\"".$color_ref."\"";

			$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($result1)==0)
			{
				$sql1="select * from $bai_pro3.bai_orders_db_confirm_archive where order_del_no=\"".$schedule."\" and order_col_des=\"".$color_ref."\"";
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
			
			$scanned_qty=$row['carton'];
			$egr_qty=$row['carton1'];
			$egs_qty=$row['carton2'];
			$packing_wip=$egr_qty+$egs_qty;
			if($packing_wip > 0)
			{	 
			
				$msg.="<tr><td>".$buyer."</td><td>".$order_style_no."</td><td>".$co_no."</td><td>".$order_del_no."</td><td>".$order_col_des."</td><td>".$packing_wip."</td><td>".$order_date."</td></tr>";
			}	 
		}
	} else {
			$msg.="<tr style='text-align:center;color:red;font-weight:bold;'><td colspan=7>No Data Found!</td></tr>";
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
	$('#reset_table2').addClass('btn btn-warning btn-xs');
//]]>
</script>

</div>
</div>
</div>

</body>
</html>

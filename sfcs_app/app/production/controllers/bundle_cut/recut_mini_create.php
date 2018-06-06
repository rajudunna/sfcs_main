<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.min.js',4,'R')?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/datetimepicker_css.js',4,'R')?>"></script>
<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/style.css',4,'R')?>">
<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/table.css',4,'R')?>">
<!---<style type="text/css">
#div-1a {
 position:absolute;
 top:65px;
 right:0;
 width:auto;
float:right;
table {
    float:left;
    width:33%;
}
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
.mytable th{ background-color:#29759c; color:#FFF; padding:2px; solid #ccc; white-space: nowrap;}
td{ padding:2px; white-space: nowrap;}
</style>--->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',4,'R')?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',4,'R')?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/filtergrid.css',4,'R')?>"></script>



<script language="javascript" type="text/javascript">
function firstbox()
{
	//alert("report");
	window.location.href ="../mini_order_report/mini_order_create.php?style="+document.mini_order_report.style.value
}

function secondbox()
{
	//alert('test');
	window.location.href ="../mini_order_report/mini_order_create.php?style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
}

function tot_sum()
{
	//alert('Test');
	var bundle_size=document.getElementById("bundle_size").value;
	var bundle_per_size=document.getElementById("bundle_per_size").value;
	var carton_qty=document.getElementById("carton_qty").value;
	mini_order_qty=document.getElementById("mini_order_qty").value=bundle_size*bundle_per_size*carton_qty;
	
	
	//return false;
}
function check_val()
{
	//alert('dfsds');
	var style=document.getElementById("style").value;
	var schedule=document.getElementById("schedule").value;
	
	if(style == 'NIL' || schedule == 'NIL' || mini_order == 'NIL')
	{
		alert('Please select the values');
		return false;
	}	
}
function check_val1()
{
	//alert('Test');
	var bundle_size=document.getElementById("bundle_size").value;
	var bundle_per_size=document.getElementById("bundle_per_size").value;
	var mini_order_qty=document.getElementById("mini_order_qty").value;
	
	if(bundle_size>1 && mini_order_qty>1)
	{
		//alert('Ok');
	}
	else
	{
		alert('Please Check the values.');
		return false;
	}
	
	
	//return false;
}

function openWin() {
    //window.open("http://baidevsrv1:8080/projects/beta/bundle_tracking_system/brandix_bts/mini_order_report/bundle_alloc_save.php");
}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="panel panel-primary">
<div class="panel-heading">Re-cut Mini Order Creation</div>
<div class="panel-body">
<!---<div id="page_heading"><span style="float: left"><h3>Re-cut Mini Order Creation</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>--->
<?php 


include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'session_track.php',0,'R'));
$view_access=user_acl("SFCS_0276",$username,1,$group_id_sfcs);
?>

<?php
error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);
// include("dbconf.php");

?>

<form name="mini_order_report" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post" onsubmit=" return check_val();">
<br>
<?php
	
	
	$sql="select * from $brandix_bts.view_extra_recut order by order_tid";
	$result=mysqli_query($link, $sql) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	//$layPlanResult=$db->loadAssocList();
	//echo count($layPlanResult);
	//print_r($layPlanResult);exit;
	if(mysqli_num_rows($result)>0)
	{
		
		$rowc=1;
		echo "<table class='table table-bordered'>";
		echo "<tr><th colspan='8'> Recuts to be bundle numbers generated</th></tr>";
		echo "<tr><th>S.No</th><th>Doc.No</th><th>Style</th><th>Schedule</th><th>Color</th><th>Ply.Height</th><th>Generate bundles</th></tr>";
		while($l=mysqli_fetch_array($result))
		{
			$doc_num=$l['doc_no'];
			$cut_num=$l['acutno'];
			$tid=$l['tid'];
			$cut_status=$l['act_cut_status'];
			$planned_module=$l['plan_module'];
			if($planned_module==NULL)
			{
				$planned_module=0;
			}
			$request_time=$l['rm_date'];
			$issued_time=$l['date'];
			$planned_plies=$l['p_plies'];
			$actual_plies=$l['a_plies'];
			$plan_date=$l['date'];
			$cat_ref=$l['cat_ref'];
			$mk_ref=$l['mk_ref'];
			$cuttable_ref=$l['cuttable_ref'];
			$product_schedule=$l['order_del_no'];
			$color_code=$l['order_col_des'];
			$style_code=$l['order_style_no'];
			
			$orders_query="select id,ref_product_style from $brandix_bts.tbl_orders_master where product_schedule='$product_schedule' order by id limit 0,1";
			$result1=mysqli_query($link, $orders_query) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row=mysqli_fetch_array($result1))
			{
				$order_id=$row['id'];
				$style_id=$row['ref_product_style'];
			}
			
			//get orders table row id
			$url=getFullURLLevel($_GET['r'],'recut_mini_gen.php',0,'N');
			echo "<tr><td>".$rowc++."</td><td>".$doc_num."</td><td>".$style_code."</td><td>".$product_schedule."</td><td>".$color_code."</td><td>".$actual_plies."</td><td><a href='$url&style=$style_id&schedule=$order_id&col=$color_code'>Generate </a></td></tr>";
		}
				
		//sync completed in cut master and cut sizes masters
		echo "</table>";
	}
	else
	{
		echo "<script>swal('No Lay plan found for order','','warning');</script></br>";
	}
	

?>
</div>
</div>
</body> 
<!---<style>

#table1 {
  display: inline-table;
  width: 100%;
}


div#table_div {
    width: 30%;
}
#test{
margin-left:8%;
margin-bottom:2%;
}
</style>--->
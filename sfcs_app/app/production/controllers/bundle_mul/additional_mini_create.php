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
	wvar ajax_url ="../mini_order_report/mini_order_create.php?style="+document.mini_order_report.style.value;Ajaxify(ajax_url);

}

function secondbox()
{
	//alert('test');
	var ajax_url ="../mini_order_report/mini_order_create.php?style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value;
	Ajaxify(ajax_url);

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
<div class="panel-heading">Additional Cut Mini order</div>
<div class="panel-body">
<!---<div id="page_heading"><span style="float: left"><h3>Additional Cut Mini order</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>--->
<?php 

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
$view_access=user_acl("SFCS_0277",$username,1,$group_id_sfcs);
$authorized_ex=user_acl("SFCS_0277",$username,7,$group_id_sfcs);
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
	$query11="SELECT order_del_no as schedule,group_concat(distinct trim(order_col_des) order by order_col_des) as planned_color,count(distinct order_col_des) as col_count FROM $brandix_bts.view_extra_cut group by order_del_no order by style_id,order_del_no";
	$result=mysqli_query($link, $query11) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$layPlanResult=mysqli_num_rows($result);
	// echo $query11."<br>";
	//print_r($layPlanResult);exit;
	if($layPlanResult>0)
	{
		$ii=1;
		echo "<table class='table table-bordered'>";
		echo "<tr><th colspan='8'> Mini order generation for Additional Cut</th></tr>";
		echo "<tr><th>S.No</th><th>Style</th><th>Schedule</th><th>Actual Colors</th><th>Planned Colors</th><th>Control</th></tr>";
		while($l=mysqli_fetch_array($result))
		{
			//$style=$l['style_id'];
			$schedule=$l['schedule'];
			$colors_planned=$l['planned_color'];
			$col_count_planned=$l['col_count'];
			//$planned_module=$l['plan_module'];
			$query2="select group_concat(distinct trim(order_col_des) order by order_col_des) as colors, count(distinct order_col_des) as cnt from $brandix_bts.tbl_orders_sizes_master where parent_id in (select id from tbl_orders_master where product_schedule=".$schedule."  order by id asc)";
			//echo $query2."<br>";exit;
			$result1=mysqli_query($link, $query2) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($l1=mysqli_fetch_array($result1))
			{
				$color_cod_act=	$l1['colors'];		
				$color_cnt_act=	$l1['cnt'];		
			}
			
			$orders_query="select p.id as id,p.ref_product_style,s.product_style from $brandix_bts.tbl_orders_master as p left join tbl_orders_style_ref as s on s.id=p.ref_product_style where p.product_schedule=".$schedule." order by id limit 0,1";
			//echo $orders_query."</br>";
			$result1=mysqli_query($link, $orders_query) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($orders_result=mysqli_fetch_array($result1))
			{
				$schedule_id=$orders_result['id'];
				$style_id=$orders_result['ref_product_style'];
				$style=$orders_result['product_style'];
				//echo $style_code."--".$orders_result['product_style']."<br>";
			}
			
			//echo $style_id."---".$orders_query."</br>";
			$col_check_act=explode(",", $color_cod_act);
			$col_check_plan=explode(",", $colors_planned);
			//echo sizeof($col_check_act)."<br>";
			//echo sizeof($col_check_plan)."<br>";
			echo "<tr><td rowspan=".$color_cnt_act.">".$ii."</td><td rowspan=".$color_cnt_act.">".$style."</td><td rowspan=".$color_cnt_act.">".$schedule."</td>";
			for($j=0;$j<sizeof($col_check_act);$j++)
			{
				if($j==0)
				{
					//echo "Test1";
					echo "<td>".$col_check_act[$j]."</td>";
					if($col_check_act[$j]!='')
					{
						echo "<td>".$col_check_plan[$j]."</td>";
					}
					else				
					{
						echo "<td>".$col_count_planned."</td>";
					}
					
					echo "<td rowspan=".$color_cnt_act.">";
					if($color_cnt_act==$col_count_planned)
					{
						//echo "<a href='http://bai3net:8080/projects/beta/bundle_tracking_system/brandix_bts_uat/phpscripts/extra_ship_gen.php?style_id=$style_id&schedule=$schedule&sch_id=$schedule_id'>Generate</a>";
						$url=getFullURLLevel($_GET['r'],'additional_mini_gen.php',0,'N');
						echo "<a href='$url&style_id=$style_id&schedule=$schedule&sch_id=$schedule_id' target='_blank'>Generate</a>";
					}
					else	
					{
						
						if(in_array($username,$authorized_ex))	
						{
							$url=getFullURLLevel($_GET['r'],'additional_mini_gen.php',0,'N');
							echo "<a href='$url&style_id=$style_id&schedule=$schedule&sch_id=$schedule_id' target='_blank'>Generate</a>";
							//echo "<br>";
							//echo "Pending";
						}
						else
						{
							// echo "Lay plan Pending for colors";
							echo "<script>swal('Lay plan Pending for colors','','warning');</script>";
						}
					}
					echo "</td></tr>";
				}
				else
				{
					echo "<tr><td>".$col_check_act[$j]."</td>";
					if($col_check_act[$j]!='')
					{
						echo "<td>".$col_check_plan[$j]."</td></tr>";
					}
					else				
					{
						echo "<td>".$col_count_planned."</td></tr>";
					}
				
				}
				
			}
			
		$ii++;
			
		}
		
		echo "</table>";
	}
	else
	{
		echo "<script>swal('No Lay plan found for order','','warning');</script>";
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
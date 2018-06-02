<html>
<head>
<title>Product Wise Summary Report</title>
<script type="text/javascript" src="jquery.min.js"></script>
<script language="JavaScript" src="FusionCharts.js"></script>
<script type="text/javascript" language="JavaScript" src="FusionChartsExportComponent.js"></script>
<style type="text/css" media="screen">

/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{ 
	margin:0px; padding:0px; border:0px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:12px; 
}

caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable1{
	font-size:12px;
}
th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;}
</style>
</head>
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>
<body>
<div id="page_heading"><span style="float: left"><h3>Last 5 Days Performance Report</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>
<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions.php");

$dates_array=array();

$r=5;

$dates_array[]=date("Y-m-d");

for($i=1;$i<=$r;$i++)
{
	$date=date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-$i, date("Y")));
	$weekday = strtolower(date('l', strtotime($date)));
	//echo $i."-".$date."-".$weekday."<br>";
	if($weekday == "sunday")
	{
		$i=$i+1;
		$r=5;
		$date=date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-$i, date("Y")));
		$weekday = strtolower(date('l', strtotime($date)));
		//echo $i."-".$date."-".$weekday."<br>";
	}
	$dates_array[]=$date;
}

//$dates_array=array("2017-05-02","2017-05-03","2017-05-04","2017-05-05","2017-05-06");
$cut_qty_array=array();
$recut_cut_qty_array=array();
$bundle_in_qty_array=array();
$bundle_out_qty_array=array();
$sewing_in_qty_array=array();
$sewing_out_qty_array=array();
$rejection_qty_array=array();
$cpk_qty_array=array();

//echo implode(",",$dates_array);

echo "<table cellspacing=\"0\" class=\"mytable1\" align=\"center\">";
echo "<tr><th>Date</th><th>Cut Qty</th><th>Recut Cut Qty</th><th>Total Cut Qty</th><th>Bundle In Qty</th><th>Bundle Out Qty</th><th>Sewing In Qty</th><th>Sewing Out Qty</th><th>Rejections</th><th>FG Qty</th></tr>";

for($i=0;$i<sizeof($dates_array);$i++)
{
	$date_ref=$dates_array[$i];
	
	$cut_qty=0;
	$recut_cut_qty=0;
	$bundle_in_qty=0;
	$bundle_out_qty=0;
	$sewing_in_qty=0;
	$sewing_out_qty=0;
	$rejection_qty=0;
	$cpk_qty=0;
	
	

	$style=$row["style"];
	$color=$row["color"];
	$order_qty=$row["qty"];
	$smv=$row["smv"];
	
	$doc_nos=array();
	$doc_nos[]=0;
	
	$sql2="SELECT doc_no from $bai_pro3.act_cut_status WHERE date=\"".$date_ref."\"";
	//echo $sql2."<br><br>";
	$result2=mysqli_query($link, $sql2) or die("Error=".$sql2."=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row2=mysqli_fetch_array($result2))
	{
		$doc_nos[]=$row2["doc_no"];
	}
			
	$sql2="SELECT doc_no,COALESCE(SUM(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s06+p_s08+p_s10+p_s12+p_s14+p_s16+p_s18+p_s20+p_s22+p_s24+p_s26+p_s28+p_s30)*p_plies) AS doc_qty FROM $bai_pro3.plandoc_stat_log WHERE doc_no in (".implode(",",$doc_nos).") group by doc_no";
	//echo $sql2."<br><br>";
	$result2=mysqli_query($link, $sql2) or die("Error=".$sql2."=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row2=mysqli_fetch_array($result2))
	{
		$cut_qty=$cut_qty+$row2["doc_qty"];
	}
	$cut_qty_array[]=$cut_qty;
	
	$recut_doc_nos=array();
	$recut_doc_nos[]=0;
	$sql2="SELECT doc_no from $bai_pro3.act_cut_status_recut_v2 WHERE date=\"".$date_ref."\"";
	//echo $sql2."<br><br>";
	$result2=mysqli_query($link, $sql2) or die("Error=".$sql2."=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row2=mysqli_fetch_array($result2))
	{
		$recut_doc_nos[]=$row2["doc_no"];
	}
	
	$sql3="SELECT doc_no,COALESCE(SUM(a_xs+a_s+a_m+a_l+a_xl+a_xxl+a_xxxl+a_s06+a_s08+a_s10+a_s12+a_s14+a_s16+a_s18+a_s20+a_s22+a_s24+a_s26+a_s28+a_s30)*a_plies) AS doc_qty FROM $bai_pro3.recut_v2 WHERE doc_no in (".implode(",",$recut_doc_nos).") group by doc_no";
	//echo $sql3."<br>";
	$result3=mysqli_query($link, $sql3) or die("Error=".$sql3."=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row3=mysqli_fetch_array($result3)) 
	{
		$recut_cut_qty=$recut_cut_qty+$row3["doc_qty"];
	}
	$recut_cut_qty_array[]=$recut_cut_qty;
	
	$total_cut_qty=$cut_qty+$recut_cut_qty;
	
	$sql4="select COALESCE(sum(bundle_transactions_20_repeat_quantity)) as qty from $brandix_bts_uat.view_set_snap_1_tbl where date(bundle_transactions_date_time)=\"".$date_ref."\" and bundle_transactions_20_repeat_operation_id=1";
	//echo $sql4."<br>";
	$result4=mysqli_query($link, $sql4) or die("Error4=".$sql4."=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row4=mysqli_fetch_array($result4))
	{
		//$bundle_in_qty=$row4["qty"];
		if($row4["qty"]>0)
		{
			$bundle_in_qty=$row4["qty"];
		}
		else
		{
			$bundle_in_qty=0;
		}
	}
	$bundle_in_qty_array[]=$bundle_in_qty;
	
	$sql4="select COALESCE(sum(bundle_transactions_20_repeat_quantity)) as qty from $brandix_bts_uat.view_set_snap_1_tbl where date(bundle_transactions_date_time)=\"".$date_ref."\" and bundle_transactions_20_repeat_operation_id=2";
	$result4=mysqli_query($link, $sql4) or die("Error=".$sql3."=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row4=mysqli_fetch_array($result4))
	{
		//$bundle_out_qty=$row4["qty"];
		if($row4["qty"]>0)
		{
			$bundle_out_qty=$row4["qty"];
		}
		else
		{
			$bundle_out_qty=0;
		}
	}
	
	$bundle_out_qty_array[]=$bundle_out_qty;
	
	$sql4="select COALESCE(sum(bundle_transactions_20_repeat_quantity)) as qty from $brandix_bts_uat.view_set_snap_1_tbl where date(bundle_transactions_date_time)=\"".$date_ref."\" and bundle_transactions_20_repeat_operation_id=3";
	$result4=mysqli_query($link, $sql4) or die("Error=".$sql3."=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row4=mysqli_fetch_array($result4))
	{
		//$sewing_in_qty=$row4["qty"];
		if($row4["qty"]>0)
		{
			$sewing_in_qty=$row4["qty"];
		}
		else
		{
			$sewing_in_qty=0;
		}
	}
	
	$sewing_in_qty_array[]=$sewing_in_qty;
	
	$sql4="select COALESCE(sum(bundle_transactions_20_repeat_quantity)) as qty from $brandix_bts_uat.view_set_snap_1_tbl where date(bundle_transactions_date_time)=\"".$date_ref."\" and bundle_transactions_20_repeat_operation_id=4";
	$result4=mysqli_query($link, $sql4) or die("Error=".$sql3."=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row4=mysqli_fetch_array($result4))
	{
		//$sewing_out_qty=$row4["qty"];
		if($row4["qty"]>0)
		{
			$sewing_out_qty=$row4["qty"];
		}
		else
		{
			$sewing_out_qty=0;
		}
	}
	
	$sewing_out_qty_array[]=$sewing_out_qty;
	
	$sql4="select COALESCE(sum(bundle_transactions_20_repeat_rejection_quantity)) as qty from $brandix_bts_uat.view_set_snap_1_tbl where date(bundle_transactions_date_time)=\"".$date_ref."\"";
	$result4=mysqli_query($link, $sql4) or die("Error=".$sql3."=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row4=mysqli_fetch_array($result4))
	{
		//$rejection_qty=$row4["qty"];
		if($row4["qty"]>0)
		{
			$rejection_qty=$row4["qty"];
		}
		else
		{
			$rejection_qty=0;
		}
	}
	
	$rejection_qty_array[]=$rejection_qty;
	
	$sql4="select COALESCE(sum(cpk_qty)) as qty from $brandix_bts_uat.view_set_6_snap where date=\"".$date_ref."\"";
	$result4=mysqli_query($link, $sql4) or die("Error=".$sql3."=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row4=mysqli_fetch_array($result4))
	{
		if($row4["qty"]>0)
		{
			$cpk_qty=$row4["qty"];
		}
		else
		{
			$cpk_qty=0;
		}
	}
	
	$cpk_qty_array[]=$cpk_qty;
	
	$x=$x+1;
	echo "<tr>";
	echo "<td>".$date_ref."</td>";
	echo "<td>".$cut_qty."</td>";
	echo "<td>".$recut_cut_qty."</td>";
	echo "<td>".$total_cut_qty."</td>";
	echo "<td>".round($bundle_in_qty,0)."</td>";
	echo "<td>".round($bundle_out_qty,0)."</td>";
	echo "<td>".round($sewing_in_qty,0)."</td>";
	echo "<td>".round($sewing_out_qty,0)."</td>";
	echo "<td>".round($rejection_qty,0)."</td>";
	echo "<td>".round($cpk_qty,0)."</td>";
	echo "</tr>";
}



$dates_list="'".implode("','",$dates_array)."'"; 
$cpk_qty_array_list=implode(",",$cpk_qty_array); 
$rejection_qty_array_list=implode(",",$rejection_qty_array); 
$sewing_out_qty_array_list=implode(",",$sewing_out_qty_array); 
$sewing_in_qty_array_list=implode(",",$sewing_in_qty_array); 
$bundle_out_qty_array_list=implode(",",$bundle_out_qty_array); 
$cut_qty_array_list=implode(",",$cut_qty_array); 
$recut_cut_qty_array_list==implode(",",$recut_cut_qty_array); 
$bundle_in_qty_array_list=implode(",",$bundle_in_qty_array); 

//echo $dates_list."-".$cpk_qty_array_list;

echo "<script type=\"text/javascript\">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'line'
            },
            title: {
			    align: 'left',
                text: 'Last 5 Days Performance'
            },
            xAxis: {
                categories: [".$dates_list."]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'PCS'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
			exporting: {
            enabled: false
       		},
            legend: {
                align: 'left',
				layout: 'horizontal',
                x: 305,
                verticalAlign: 'top',
                y: -10,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
					this.series.name +': '+ this.y +'<br/>'+
					'Total: '+ this.point.stackTotal;
                }
            },
			plotOptions: {			
                column: {
			    pointPadding: 0.0,
			    borderWidth: 2,
				dataLabels: {
					enabled: true
				}
                }
            },
            series: [{
                name: 'Cut Qty',
                data: [".$cut_qty_array_list."]
            },
			{
                name: 'Recut Qty',
                data: [".$recut_cut_qty_array_list."]
            },
			{
                name: 'Bundle In',
                data: [".$bundle_in_qty_array_list."]
            },
			{
                name: 'Bundle Out',
                data: [".$bundle_out_qty_array_list."]
            },
			{
                name: 'Sewing In',
                data: [".$sewing_in_qty_array_list."]
            },
			{
                name: 'Sewing Out',
                data: [".$sewing_out_qty_array_list."]
            },
			{
                name: 'Rejection Qty',
                data: [".$rejection_qty_array_list."]
            },{
                name: 'CPK Qty',
                data: [".$cpk_qty_array_list."]
            }]
        });
    });
    
});
		</script>
	
<script src=\"highcharts.js\"></script>
<script src=\"exporting.js\"></script>

<div id=\"container\" style=\"width: 1100px; height: 400px; margin: 0 auto\"></div>";

	
echo "</table>";
?>
<body>
</html>
<?php
error_reporting(0);
$week_qty=array();
$week_no=array();
if($period==1)
{
	$period_ref="Day";
	$sql1="SELECT distinct log_date as weekno FROM $bai_pro3.bai_qms_db_reason_track WHERE log_date between \"".$sdate."\" and \"".$edate."\" GROUP BY log_date order by log_date";
	
}
if($period==2)
{
	$period_ref="Week";
	$sql1="SELECT distinct week(log_date)+1 as weekno FROM $bai_pro3.bai_qms_db_reason_track WHERE log_date between \"".$sdate."\" and \"".$edate."\" GROUP BY week(log_date) order by week(log_date)";
}
if($period==3)
{
	$period_ref="Month";
	$sql1="SELECT distinct month(log_date) as weekno FROM $bai_pro3.bai_qms_db_reason_track WHERE log_date between \"".$sdate."\" and \"".$edate."\" GROUP BY month(log_date) order by month(log_date)";
}

//$sql1="SELECT distinct week(log_date)+1 as weekno FROM bai_qms_db_reason_track WHERE log_date between \"".$sdate."\" and \"".$edate."\" ".$suppliers_list_ref_query."  GROUP BY week(log_date) order by  week(log_date)";
//echo $sql1."<br>"; 
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	//echo $sql_row1["weekno"]."<br>";
	if($period==3)
	{
		$monthName = date('F', mktime(0, 0, 0, $sql_row1["weekno"], 10));
		$week_no1[]=$monthName;
		$week_no[]=$sql_row1["weekno"];
		//echo date('M',$sql_row1["weekno"])."-".$sql_row1["weekno"]."<br>";
	}
	else
	{
		$week_no[]=$sql_row1["weekno"];
	}
	
}

if($period==3)
{
	$week_implode="'".implode("','",$week_no1)."'";
}
else
{
	$week_implode="'".implode("','",$week_no)."'";
}
//echo $week_implode."<br>";

$ix=0;

for($j12=0;$j12<sizeof($reason_desc);$j12++)
{	
	$qty_total22=array();
	$qty_total=array();
	
	$qty_total2=0;
	for($i12=0;$i12<sizeof($week_no);$i12++)
	{	
		$qty=0;
		
		if($period==1)
		{
			$sql11="SELECT * FROM $bai_pro3.bai_qms_db_reason_track WHERE qms_reason in (".$reason_code[$j12].") and log_date=\"".($week_no[$i12])."\" ".$suppliers_list_ref_query." and log_date between \"".$sdate."\" and \"".$edate."\"";
			if($rejval!=1)
			{
				//$sql_out="select sum(bac_qty) as qty from bai_pro.bai_log_buf where bac_date=\"".($week_no[$i12])."\" and bac_date between \"".$sdate."\" and \"".$edate."\"";
				
				$sql_out="select COALESCE(sum(act_out),0) as qty from bai_pro.grand_rep where date=\"".($week_no[$i12])."\" and date between \"".$sdate."\" and \"".$edate."\"";
				
			}
		}
		if($period==2)
		{
			$sql11="SELECT * FROM $bai_pro3.bai_qms_db_reason_track WHERE qms_reason in (".$reason_code[$j12].") and week(log_date)=\"".($week_no[$i12]-1)."\" ".$suppliers_list_ref_query." and log_date between \"".$sdate."\" and \"".$edate."\"";
			if($rejval!=1)
			{
				//$sql_out="select sum(bac_qty) as qty from bai_pro.bai_log_buf where week(bac_date)=\"".($week_no[$i12]-1)."\" and bac_date between \"".$sdate."\" and \"".$edate."\"";
				
				$sql_out="select COALESCE(sum(act_out),0) as qty from bai_pro.grand_rep where week(date)=\"".($week_no[$i12]-1)."\" and date between \"".$sdate."\" and \"".$edate."\"";
			}
		}
		if($period==3)
		{
			$sql11="SELECT * FROM $bai_pro3.bai_qms_db_reason_track WHERE qms_reason in (".$reason_code[$j12].") and month(log_date)=\"".($week_no[$i12])."\" ".$suppliers_list_ref_query." and log_date between \"".$sdate."\" and \"".$edate."\"";
			if($rejval!=1)
			{
				//$sql_out="select sum(bac_qty) as qty from bai_pro.bai_log_buf where month(bac_date)=\"".($week_no[$i12])."\" and bac_date between \"".$sdate."\" and \"".$edate."\"";
				
				$sql_out="select COALESCE(sum(act_out),0) as qty from $bai_pro.grand_rep where month(date)=\"".($week_no[$i12])."\" and date between \"".$sdate."\" and \"".$edate."\"";
			}
		}			
		//echo $sql_out."<br>";
		if($rejval!=1)
		{
			$sql_result_out=mysqli_query($link, $sql_out) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row_out=mysqli_fetch_array($sql_result_out))
			{
				$output=$sql_row_out["qty"];
			}
		}
		
		//echo $sql11."<br>";
		$qty=0;			
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result11) > 0)
		{
			while($sql_row11=mysqli_fetch_array($sql_result11))
			{	
				$qty=$qty+$sql_row11["qms_qty"];
			}
			//$qty_total[]=$qty;
			if($rejval==1)
			{
				$qty_total[]=$qty;
				$qty_total2=$qty_total2+$qty;
				//echo "<br>Qty=".$qty_total2."<br>";
			}
			else
			{
				$qty_total[]=round(($qty*100)/$output,2);
				$qty_total2=$qty_total2+round(($qty*100)/$output,2);
				//echo "<br>Qty=".$qty_total2."<br>";
			}
		}
		else
		{
			$qty=0;
			$qty_total[]=$qty;
			$qty_total2=$qty_total2+$qty;
			//echo "<br>Qty=".$qty_total2."<br>";
		}
		$qty_total22[]=$qty_total2;
	}
	
	//echo implode(",",$qty_total22)."<br>";
	if($j12==0)
	{
		$series_ref1="{name: '".($reason_desc[$j12])."',isIntermediateSum: true,data: [".implode(",",$qty_total)."]}";
	}
	else
	{	
		$series_ref1.=",{name: '".($reason_desc[$j12])."',isIntermediateSum: true,data: [".implode(",",$qty_total)."]}";
		if($j12==(sizeof($reason_desc)-1))
		{
			//$series_ref1.=",{name: 'All',isIntermediateSum: true,data: [".implode(",",$qty_total22)."]}";
		}
	}
}	


for($i121=0;$i121<sizeof($week_no);$i121++)
{	
	$qty1=0;
	$qty_total21=0;
	if($period==1)
	{
		$sql111="SELECT * FROM $bai_pro3.bai_qms_db_reason_track WHERE qms_reason in (".implode(",",$reason_code).") and log_date=\"".($week_no[$i121])."\" ".$suppliers_list_ref_query." and log_date between \"".$sdate."\" and \"".$edate."\"";
		
		if($rejval!=1)
		{
			//$sql_out1="select sum(bac_qty) as qty from bai_pro.bai_log_buf where bac_date=\"".($week_no[$i121])."\" and bac_date between \"".$sdate."\" and \"".$edate."\"";
			
			$sql_out1="select COALESCE(sum(act_out),0) as qty from $bai_pro.grand_rep where date=\"".($week_no[$i121])."\" and date between \"".$sdate."\" and \"".$edate."\"";
		}
	}
	if($period==2)
	{
		$sql111="SELECT * FROM $bai_pro3.bai_qms_db_reason_track WHERE qms_reason in (".implode(",",$reason_code).") and week(log_date)=\"".($week_no[$i121]-1)."\" ".$suppliers_list_ref_query." and log_date between \"".$sdate."\" and \"".$edate."\"";
		if($rejval!=1)
		{
			//$sql_out1="select sum(bac_qty) as qty from bai_pro.bai_log_buf where week(bac_date)=\"".($week_no[$i121]-1)."\" and bac_date between \"".$sdate."\" and \"".$edate."\"";
			
			$sql_out1="select COALESCE(sum(act_out),0) as qty from $bai_pro.grand_rep where week(date)=\"".($week_no[$i121]-1)."\" and date between \"".$sdate."\" and \"".$edate."\"";
		}
	}
	if($period==3)
	{
		$sql111="SELECT * FROM $bai_pro3.bai_qms_db_reason_track WHERE qms_reason in (".implode(",",$reason_code).") and month(log_date)=\"".($week_no[$i121])."\" ".$suppliers_list_ref_query." and log_date between \"".$sdate."\" and \"".$edate."\"";
		if($rejval!=1)
		{
			//$sql_out1="select sum(bac_qty) as qty from bai_pro.bai_log_buf where month(bac_date)=\"".($week_no[$i121])."\" and bac_date between \"".$sdate."\" and \"".$edate."\"";
			
			$sql_out1="select COALESCE(sum(act_out),0) as qty from $bai_pro.grand_rep where month(date)=\"".($week_no[$i121])."\" and date between \"".$sdate."\" and \"".$edate."\"";
		}
	}			
	//echo $sql_out1."<br>";
	if($rejval!=1)
	{
		$sql_result_out1=mysqli_query($link, $sql_out1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row_out1=mysqli_fetch_array($sql_result_out1))
		{
			$output1=$sql_row_out1["qty"];
		}
	}
	
	//echo $sql11."<br>";
	$qty1=0;			
	$sql_result111=mysqli_query($link, $sql111) or exit("Data Not Found".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result111) > 0)
	{
		while($sql_row111=mysqli_fetch_array($sql_result111))
		{	
			$qty1=$qty1+$sql_row111["qms_qty"];
			// echo $qty1."HIHIHIHIIIIIIIii";
		}
		//$qty_total[]=$qty;
		if($rejval==1)
		{
			$qty_total21=$qty_total21+$qty1;
			//echo "<br>Qty1=".$qty_total21."<br>";
		}
		else
		{
			$qty_total21=$qty_total21+round(($qty1*100)/$output1,2);
			//echo "<br>Qty=".$qty_total21."<br>";
		}
	}
	else
	{
		$qty1=0;
		$qty_total21=$qty_total21+$qty1;
		// echo "<br>Qty=".$qty_total21."<br>";
	}
	$qty_total221[]=$qty_total21;
}
if ($qty_total221 == 0) {
	echo "<br>No data in Database<br>";
} else {
	$series_ref1.=",{name: 'All',isIntermediateSum: true,data: [".implode(",",$qty_total221)."]}";
}

//$series_ref1.=",{name: 'All',data: [".implode(",",$qty_total22)."]}";

//echo "<br>".$series_ref1;
//echo $suppliers_list_ref_query;
echo "<br><br><br><script type=\"text/javascript\">
$(function () {
	var chart;
	$(document).ready(function() {
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'containerx',
				borderColor: '#000000',
				borderWidth: 3,
				spacingBottom: 55,
				type: '".$mode_ref."',
				style: {
                        fontWeight: 'bold',
						color: '#000000',
						connectorColor: '#000000',
						fontSize: '15px'
                    }
			},
			title: {
				align: 'left',
				text: 'Supplier Wise Rejection Quantity(".str_replace("'","",$suppliers_list_ref).") ".$add_string."'
			},
			xAxis: {
				categories: [".$week_implode."],
				style: {
                        fontWeight: 'bold',
						color: '#000000',
						connectorColor: '#000000',
						fontSize: '25px'
                    },
				title: {
					text: '".$period_ref."',
					style: {
                        fontWeight: 'bold',
						color: '#000000',
						connectorColor: '#000000',
						fontSize: '15px'
                    }
				}
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Rejection Qty',
					style: {
                        fontWeight: 'bold',
						color: '#000000',
						connectorColor: '#000000',
						fontSize: '15px'
                    }
				}
			},
			exporting: {
			enabled: false
			},
			legend: {
				align: 'center',
				layout: 'horizontal',
				x: 105,
				verticalAlign: 'bottom',
				y: 30,
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
			  '".$mode_ref."': {
			   pointPadding: 0.0,
			   style: {
                        fontWeight: 'bold',
						color: '#000000',
						connectorColor: '#000000',
						fontSize: '25px'
                    },
			   borderWidth: 2,
					dataLabels: {
						enabled: true
						";
						if($rejval==2)
						{
						echo ",
						formatter: function() {
						return this.y +'%';
						}";
						}
						echo "
					}
				}
			},
			series: [".$series_ref1."]
		});
	});
	
});
</script>

<div class=\"table-responsive\">
	<div id=\"containerx\" style=\"width: 1200px; height: 600px; margin: 0 auto\"></div></div>";



?>
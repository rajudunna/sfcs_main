<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php  
include("../".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 

?>

<html>
<title>Supplier Wise Performance Charts</title>
<head>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/FusionCharts.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/FusionChartsExportComponent.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/highcharts.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/highcharts-3d.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/exporting.js',3,'R'); ?>"></script>

<style>
body
{
	font-family:calibri;
	font-size:12px;
}

table tr
{
	text-align: right;
	white-space:nowrap;
}

table td
{
	text-align: right;
	white-space:nowrap;
}

table td.lef
{
	text-align: left;
	white-space:nowrap; 
}
table th
{
	text-align: center;
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

<?php

//if(isset($_POST['filter']))
{
  
	$sdate=$_GET['sdate'];
	$edate=$_GET['edate'];	
	$suppliers_list_ref_query=str_replace("*","'",$_GET["suppliers"]);
	echo "<br>";
	$mon1=date('F(Y)', strtotime($sdate));
    $mon2=date('F(Y)', strtotime($edate));
	
	$sql_sup_ref="select * from $bai_rm_pj1.inspection_supplier_db WHERE PRODUCT_CODE=\"Fabric\" order by seq_no";
	$sql_result_ref=mysqli_query($link, $sql_sup_ref) or exit("Sql Error".$sql_sup_ref.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row_ref=mysqli_fetch_array($sql_result_ref))
	{
		$sup_ref_x[]=$sql_row_ref["supplier_m3_code"];
	}
	
	$sup_ref_x_fin="(supplier,'".implode("','",$sup_ref_x)."')";
	
	//echo $mon1."-".$mon2;
	if($mon1==$mon2)
	{
		$month_name=$mon1;
	}
	else
	{   
	   $month_name=$mon1." to ".$mon2;
	}
	//echo $mon1."-".$mon2."=".date("F",'3');
    //echo  preg_grep('/^$mon1.*/', $array);
 	$supplier=array();
	$rec_qty=array();
	$sql="select ROUND(SUM(rec_qty),0) AS qty,supplier FROM $bai_rm_pj1.sticker_report WHERE DATE(grn_date) BETWEEN \"".$sdate."\" AND \"".$edate."\" AND product_group=\"Fabric\"  ".$suppliers_list_ref_query." GROUP BY supplier ORDER BY field ".$sup_ref_x_fin."";
	//echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$rec_qty[]=$sql_row["qty"];
		$sql_sup="select * from $bai_rm_pj1.inspection_supplier_db where supplier_m3_code=\"".$sql_row["supplier"]."\" and product_code=\"Fabric\"";
		$sql_result_sup=mysqli_query($link, $sql_sup) or exit("Sql Error".$sql_sup.mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result_sup) > 0)
		{
			while($sql_row_sup=mysqli_fetch_array($sql_result_sup))
			{
				$supplier_name_ref=$sql_row_sup["supplier_code"];
			}
		}
		else
		{
			$supplier_name_ref=$sql_row["supplier"];
		}
		$supplier[]=$supplier_name_ref;
		
		$sql_col1="select * FROM $bai_rm_pj1.inspection_supplier_db where supplier_code=\"".$supplier_name_ref."\" and product_code=\"Fabric\""; 
		//echo $sql_col."<br>";
		$sql_result_col1=mysqli_query($link, $sql_col1) or exit("Sql Error".$sql_col1.mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result_col1) > 0)
		{
			while($sql_row_col1=mysqli_fetch_array($sql_result_col1))
			{
				$color_ref_array1[]=$sql_row_col1["color_code"];
			}
		}
		else
		{
			$color_ref_array1[]="#000000";
		}
	}
	
	$string_code1="";
	for($ix1=0;$ix1<sizeof($color_ref_array1);$ix1++)
	{
		if($ix1==0)
		{
			$string_code1.="{ name:'".$supplier[$ix1]."' ,y:".$rec_qty[$ix1].", color: '".$color_ref_array1[$ix1]."'}"; 
		}
		else
		{
			$string_code1.=",{ name:'".$supplier[$ix1]."' ,y:".$rec_qty[$ix1].", color: '".$color_ref_array1[$ix1]."'}"; 
		}	
	}
	//echo $string_code1."<br>";
	
	if(sizeof($supplier) > 0)
	{
		$string_con="";
		for($i=0;$i<sizeof($supplier);$i++)
		{
			$string_con.="['".$supplier[$i]."',".$rec_qty[$i]."]";
			if($i!=(sizeof($supplier)-1))
			{
				$string_con.=",";
			}
		}

		//echo $string_con;

		echo "<script type=\"text/javascript\">
			$(function () {
		$('#container').highcharts({
        chart: {
		    renderTo: 'container',
		    borderWidth: 3,
			fontSize: '30px',
            borderColor: '#000000',
			plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: '<b><h3>Supplier Wise Received Quantity     - ".$month_name."<h3><b>',
			align: 'left',
            x: 10
        },
        tooltip: {
            pointFormat: '<b>{series.name}</b>: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
					color: '#000000',
                    connectorColor: '#000000',
					style: {
                    fontSize: '20px'
					},
                    format: '<b>{point.name}</b>: <b>{point.percentage:.1f}<b> %'
                },
				showInLegend: true
            }
        },
		legend: {
                enabled: true,
                layout: 'vertical',
                align: 'right',
                useHTML: true,
				style: {
                    fontSize: '90px'
					},
                verticalAlign: 'middle'
         },
        series: [{
            type: 'pie',
			fontSize: '55px',
            name: 'Received Qty',
			color: '#000000',
			style: {
			fontSize: '55px'
			},
            data:  [".$string_code1."]
        }]
    });
});
		</script>
			
	

		<div id=\"container\" style=\"width: 1225px; height: 450px; margin: 0 auto\"></div>";
	}
	else
	{
		echo "<H2>There is no data to display in the selected period.</H2>";
	}
	
	$complaint_reason=array();
	$comaplint_sno=array();
	
	$supplier_array=array();
	$color_ref_array=array();
	$performance_array=array();
	
	$text="";
	
	$sql2="select sno,complaint_reason FROM $bai_rm_pj1.inspection_complaint_reasons WHERE complaint_category=\"Fabric\" ORDER BY sno";
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".$sql2.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$complaint_reason[]=$sql_row2["complaint_reason"];
		$comaplint_sno[]=$sql_row2["sno"];
	}
	
	$text.="<table border=1 width=\"100%\">";
	$text.="<tr><td>Supplier</td><td>Batch Count</td>";
	//echo "<td>Batch</td>";
	for($i=0;$i<sizeof($complaint_reason);$i++)
	{
		//echo "<td>".$complaint_reason[$i]."</td>";
	}
	//echo "<td>Status</td>";
	$text.="<td>Performance %</td></tr>";
	$sql="select distinct supplier as sup from $bai_rm_pj1.sticker_report WHERE DATE(grn_date) BETWEEN \"".$sdate."\" AND \"".$edate."\" AND product_group=\"Fabric\" ".$suppliers_list_ref_query." and length(supplier) > 0 ORDER BY field ".$sup_ref_x_fin."";
	//echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$supplier_name=$sql_row["sup"];
		$sql_sup1="select * from $bai_rm_pj1.inspection_supplier_db where supplier_m3_code=\"".$sql_row["sup"]."\" and product_code=\"Fabric\"";
		$sql_result_sup1=mysqli_query($link, $sql_sup1) or exit("Sql Error".$sql_sup1.mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result_sup1) > 0)
		{
			while($sql_row_sup1=mysqli_fetch_array($sql_result_sup1))
			{
				$supplier_name_ref1=$sql_row_sup1["supplier_code"];
			}
		}
		else
		{
			$supplier_name_ref1=$sql_row["sup"];
		}
		
		$sql_col="select * FROM $bai_rm_pj1.inspection_supplier_db where supplier_code=\"".$supplier_name_ref1."\" and product_code=\"Fabric\""; 
		//echo $sql_col."<br>";
		$sql_result_col=mysqli_query($link, $sql_col) or exit("Sql Error".$sql_col.mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result_col) > 0)
		{
			while($sql_row_col=mysqli_fetch_array($sql_result_col))
			{
				$color_ref_array[]=$sql_row_col["color_code"];
				$color_refx=$sql_row_col["color_code"];
			}
		}
		else
		{
			$color_ref_array[]="#000000";
			$color_refx="#000000";
		}
		
		//echo $color_refx."<br>";
		$supplier[]=$supplier_name_ref1;
		$supplier_array[]=$supplier_name_ref1;
		$sql1="select count(distinct batch_no) as batch_no from $bai_rm_pj1.sticker_report WHERE DATE(grn_date) BETWEEN \"".$sdate."\" AND \"".$edate."\" AND product_group=\"Fabric\" and supplier=\"".$supplier_name."\"";
		//echo $sql1."<br>";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$batch_count=$sql_row1["batch_no"];
		}	
		$j=0;
		$t=0;
		$text.="<tr>";
		$text.="<td>".$supplier_name."</td>";
	    $text.="<td>".$batch_count."</td>";
		$sql1x="select distinct batch_no as batch_no from $bai_rm_pj1.sticker_report WHERE DATE(grn_date) BETWEEN \"".$sdate."\" AND \"".$edate."\" AND product_group=\"Fabric\" and supplier=\"".$supplier_name."\"";
		//echo $sql1."<br>";
		$sql_result1x=mysqli_query($link, $sql1x) or exit("Sql Error".$sql1x.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1x=mysqli_fetch_array($sql_result1x))
		{	
			$j++;			
			$batch_ref=$sql_row1x["batch_no"];
			//echo "<td>".$batch_ref."</td>";
			$x=0;
			
			for($i1=0;$i1<sizeof($complaint_reason);$i1++)
			{
				$rej_lots=array();
				
				$sql5="select * FROM $bai_rm_pj1.inspection_complaint_db a,$bai_rm_pj1.inspection_complaint_db_log b WHERE a.complaint_no=b.complaint_track_id AND a.supplier_name=\"".$supplier_name."\" AND b.complaint_reason='".$comaplint_sno[$i1]."' AND a.reject_batch_no='".$batch_ref."'";
				$sql_result5=mysqli_query($link, $sql5) or exit("Sql Error".$sql5.mysqli_error($GLOBALS["___mysqli_ston"]));
				//echo mysql_num_rows($sql_result5)."-".$sql5."<br>";
				if(mysqli_num_rows($sql_result5) > 0)
				{
					$sql3="select GROUP_CONCAT(CONCAT(\"'\",a.reject_lot_no,\"'\")) as lots FROM $bai_rm_pj1.inspection_complaint_db a,$bai_rm_pj1.inspection_complaint_db_log b WHERE a.complaint_no=b.complaint_track_id AND a.supplier_name=\"".$supplier_name."\" AND a.reject_batch_no='".$batch_ref."' AND b.complaint_reason='".$comaplint_sno[$i1]."' GROUP BY b.complaint_track_id";
					//echo $sql3."</br>";
					$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".$sql3.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row3=mysqli_fetch_array($sql_result3))
					{
						$rej_lots[]=$sql_row3["lots"];
					}
				}
				else
				{
					$rej_lots[]=0;
				}
				
				if(strlen(implode(",",$rej_lots)) > 2)
				{				
					$sql4="select count(distinct batch_no) as batch_no from $bai_rm_pj1.sticker_report WHERE DATE(grn_date) BETWEEN \"".$sdate."\" AND \"".$edate."\" AND product_group=\"Fabric\" and supplier=\"".$supplier_name."\" AND batch_no='".$batch_ref."' and lot_no in (".implode(",",$rej_lots).")";
					//echo $sql4."<br>";
					$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error".$sql4.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row4=mysqli_fetch_array($sql_result4))
					{
						//echo "<td>Fail</td>";	
						$x=$x+1;
					}
				}
				else
				{
					//echo "<td>Pass</td>";	
				}
			}
			if($x==0)
			{
				//echo "<td>Pass</td>";
				$t=$t+1;
			}	
			else
			{
				//echo "<td>Fail</td>";
			}				
		}
		$text.="<td>".round(($t*100/$batch_count),0)."%</td>";
		$performance_array[]=round(($t*100/$batch_count),0);
		$text.="</tr>"; 	
		
	}
	$text.="</table>";
	$color_ref_array_implode="'".implode("','",$color_ref_array)."'";
	$supplier_array_implode="'".implode("','",$supplier_array)."'";
	$performance_array_implode=implode(",",$performance_array);
	$string_code="";
	for($ix=0;$ix<sizeof($color_ref_array);$ix++)
	{
		if($ix==0)
		{
			$string_code.="{ y:".$performance_array[$ix].", color: '".$color_ref_array[$ix]."'}"; 
		}
		else
		{
			$string_code.=",{ y:".$performance_array[$ix].", color: '".$color_ref_array[$ix]."'}"; 
		}	
	}
	//echo $supplier_array_implode."<br>".$performance_array_implode."<br>".$color_ref_array_implode."<br>".$string_code."<br>";	
	if(sizeof($performance_array) > 0)
	{
	//echo "<table><tr><td>".$text."</td><td>";
	echo "<table align='center' width=\"100%\"><tr><td>";	
	echo "<script type=\"text/javascript\">
	$(function () {
		var chart;
		$(document).ready(function() {
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'container1',
					borderColor: '#000000',
					borderWidth: 3,
					type: 'column',
					color: '#000000',
					fontSize: '55px',
					margin: 75,
					style: {
                    fontSize: '35px',
					color: '#000000',
					fontWeight: 'bold'					
					}
				},
						
				title: {
					x: 10,
					align: 'left',
					text: '<b><h3>Supplier Wise Performance Report  - ".$month_name."</h3><b>'
				},
				xAxis: {					
					title: {
						text: 'Suppliers',
						color: '#000000',	
						style: {
						fontSize: '25px',
						color: '#000000',	
						fontWeight: 'bold'					
						}
					},
					labels: {
						style: {
							fontSize: '20px',
							color: '#000000',	
							fontWeight: 'bold'
							},
						formatter: function() {
							return (this.isLast ? this.value + '%' : this.value);
						}
					},
					categories: [".$supplier_array_implode."]
				},
				yAxis: {					
					title: {
						text: 'Performance',
						color: '#000000',	
						style: {
						fontSize: '20px',
						color: '#000000',
						fontWeight: 'bold'					
						}
					},
					stackLabels: {
						enabled: true,
						color: '#000000',	
						style: {
							fontSize: '20px',
							fontWeight: 'bold',
							color: (Highcharts.theme && Highcharts.theme.textColor) || 'green'
						}
					},
					labels: {
						style: {
							fontSize: '10px',
							color: '#000000',	
							fontWeight: 'bold'
							},
						formatter: function() {
							return (this.isLast ? this.value + '%' : this.value);
						}
					}
				},
				exporting: {
				enabled: true
				},
				tooltip: {
					formatter: function() {
						return '<b>Supplier : '+ this.x +'</b><br/>'+
							this.series.name +': '+ this.y +'%<br/>';
					}
				},
				plotOptions: {			
				   column: {
				
				   colorByPoint: true,
				   dataLabels: {
							enabled: true,
							color: '#000000',
							style: {
							fontSize: '25px'
							}
						}
					},
					series: {
					shadow:false,
					borderWidth:0,
					dataLabels:{
					enabled:true,
					color: '#000000',
					style: {
                    fontSize: '20px',	
					fontWeight: 'bold',
					color: '#000000'					
					},
					formatter: function() {
                    return this.y +'%';
                }
            }
        }
				},
				legend: {
				align: 'right',
				x: -30,
				verticalAlign: 'top',
				y: 25,
				floating: true,
				fontWeight: 'bold',
				backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
				borderColor: '#CCC',
				color: '#000000',	
				borderWidth: 1,
				style: {
                    fontSize: '25px',
					fontWeight: 'bold',
					color: '#000000'					
					},
				shadow: false
			},
				series: [{
					data: [".$string_code."],
					pointWidth: 30,
					color: '#000000',	
					style: {
                    fontSize: '20px',
					fontWeight: 'bold'					
					}
				}]
			});
		});
		
	});
	</script>
		
	

	<div id=\"container1\" style=\"width: 1225px; height: 450px; margin: 0 auto\"></div></td></tr></table>";
	}
	else
	{
		echo "<H2>There is no data to display in the selected period.</H2>";
	}
	
}
?>

</body>
</html>
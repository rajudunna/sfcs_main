<html>
<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions.php");

$view_access=user_acl("SFCS_0242",$username,1,$group_id_sfcs); 
?>
<head>
<title>Product Wise Summary Report</title>
<script type="text/javascript" src="jquery.min.js"></script>
<script language="JavaScript" src="FusionCharts.js"></script>
<script type="text/javascript" language="JavaScript" src="FusionChartsExportComponent.js"></script>
<script type="text/javascript" src="datetimepicker_css.js"></script>
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
<div id="page_heading"><span style="float: left"><h3>Day & Module Wise Performance Report</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>

<form action="product_wise_summary_report_module.php" method="post">
Date&nbsp;&nbsp;<input type="text" size="8" name="dat1" id="demo1" value="<?php echo date("Y-m-d"); ?>"/>
<?php 
	echo "<a href="."\"javascript:NewCssCal('demo1','yyyymmdd','dropdown')\">";
	echo "<img src='images/cal.gif' width='16' height='16' alt='Pick a date'></a>";
?>&nbsp;&nbsp;&nbsp;&nbsp;

Shift <select name="shift">
<option value="'A','B'">All</option>
<option value="'A'">A</option>
<option value="'B'">B</option>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;
Product <select name="product">
<?php
$sql_source="SELECT buyer_div FROM $bai_pro3.plan_modules GROUP BY buyer_div";
//echo $sql_source."<br><br>";
$result_source=mysqli_query($link, $sql_source) or die("Error=".$sql."=".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row_source=mysqli_fetch_array($result_source))
{
	$buyer_name_ref[]=$row_source["buyer_div"];
}
$buyer_name_ref_implode="'".implode("','",$buyer_name_ref)."'";
echo "<option value=\"".$buyer_name_ref_implode."\">ALL</option>";
for($i=0;$i<sizeof($buyer_name_ref);$i++)
{
	echo "<option value=\"'".$buyer_name_ref[$i]."'\">".$buyer_name_ref[$i]."</option>";
}

?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" name="submit" value="Show" onclick="document.getElementById('submit').style.display='none'; document.getElementById('msg').style.display='';"/> <!--Adding the please wait option -->

</form>

<?php

if(isset($_POST["submit"]))
{
	$sdate=$_POST["dat1"];
	$shift=$_POST["shift"];
	$product=$_POST["product"];	
	
	//echo $sdate."-".$edate."-".$shift."-".$product."<br>";
	
	echo "<table cellspacing=\"0\" class=\"mytable1\">";
	echo "<tr><th>Team No</th><th>Running Style</th><th>Plan PCS</th><th>Actual PCS</th><th>Variation</th><th>Achievement%</th></tr>";
	$buyer_name_ref=array();
	$acheivement_per=array();
	//$sql_source="SELECT buyer_id,GROUP_CONCAT(\"'\",MOVEX_STYLE,\"'\") as styles FROM bai_pro2.movex_styles WHERE LENGTH(buyer_id)>0 and buyer_id in (".$product.") GROUP BY buyer_id";
	$sql_source="SELECT buyer_div as buyer_id,GROUP_CONCAT(\"'\",module_id,\"'\") as modules FROM $bai_pro3.plan_modules WHERE LENGTH(buyer_div)>0 and buyer_div in (".$product.") group by buyer_div";
	//echo $sql_source."<br><br>";
	$result_source=mysqli_query($link, $sql_source) or die("Error=".$sql_source."=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row_source=mysqli_fetch_array($result_source))
	{
		$buyer_name=$row_source["buyer_id"];
		$buyer_name_ref[]=$buyer_name;
		//$styles=$row_source["styles"];
		$modules=$row_source["modules"];
		$total_plan=0;
		$total_act=0;	
		
		//$sql1="select * from bai_pro.grand_rep where date=\"".$sdate."\" and styles in (".$styles.") and shift in (".$shift.") group by module order by module*1";
		$sql1="select module,sum(plan_out) as plan_out,group_concat(distinct styles) as styles,sum(act_out) as act_out from $bai_pro.grand_rep where date=\"".$sdate."\" and module in (".$modules.") and shift in (".$shift.") group by module order by module*1";
		//echo $sql1."<br>";
		$result1=mysqli_query($link, $sql1) or die("Error=".$sql_source."=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row1=mysqli_fetch_array($result1))
		{
			echo "<tr>";
			echo "<td>".$row1["module"]."</td>";
			echo "<td>".$row1["styles"]."</td>";
			echo "<td>".$row1["plan_out"]."</td>";
			
			$total_plan=$total_plan+$row1["plan_out"];
			
			echo "<td>".$row1["act_out"]."</td>";
			
			$total_act=$total_act+$row1["act_out"];
			
			echo "<td>".($row1["plan_out"]-$row1["act_out"])."</td>";
			if($row1["plan_out"] > 0)
			{
				if(round($row1["act_out"]*100/$row1["plan_out"],0) <= 75)
				{
					$color="#FF0000";
				}
				else if(round($row1["act_out"]*100/$row1["plan_out"],0) >= 76 and round($row1["act_out"]*100/$row1["plan_out"],0) <= 90 )
				{
					$color="#FFFF00";
				}
				else
				{
					$color="#008000";
				}
			
				echo "<td bgcolor=\"".$color."\">".round($row1["act_out"]*100/$row1["plan_out"],0)."%</td>";
			}
			else
			{
				echo "<td bgcolor=\"#FF0000\">0%</td>";
			}
			
			echo "</tr>";
		}
		
		echo "<tr>";
		echo "<th colspan=2 align=\"center\">".$buyer_name."</th>";
		echo "<td>".$total_plan."</td>";
		$grand_total_plan=$grand_total_plan+$total_plan;
		echo "<td>".$total_act."</td>";
		$grand_total_act=$grand_total_act+$total_act;
		echo "<td>".($total_plan-$total_act)."</td>";
		if($total_plan > 0)
		{
			if(round($total_act*100/$total_plan,0) <= 75)
			{
				$color1="#FF0000";
			}
			else if(round($total_act*100/$total_plan,0) >= 76 and round($total_act*100/$total_plan,0) <= 90 )
			{
				$color1="#FFFF00";
			}
			else
			{
				$color1="#008000";
			}
			echo "<td bgcolor=\"".$color1."\">".round($total_act*100/$total_plan,0)."%</td>";
			$acheivement_per[]=round($total_act*100/$total_plan,0);
		}
		else
		{
			echo "<td bgcolor=\"#FF0000\">0%</td>";
			$acheivement_per[]=0;
		}
		echo "</tr>";
	}
	
	echo "<tr>";
	echo "<th colspan=2>Grand Total</th>";
	echo "<td>".$grand_total_plan."</td>";
	echo "<td>".$grand_total_act."</td>";
	echo "<td>".($grand_total_plan-$grand_total_act)."</td>";
	
	if($grand_total_plan > 0)
	{
		if(round($grand_total_act*100/$grand_total_plan,0) <= 75)
		{
			$color1="#FF0000";
		}
		else if(round($grand_total_act*100/$grand_total_plan,0) >= 76 and round($grand_total_act*100/$grand_total_plan,0) <= 90 )
		{
			$color1="#FFFF00";
		}
		else
		{
			$color1="#008000";
		}
		echo "<td bgcolor=\"".$color1."\">".round($grand_total_act*100/$grand_total_plan,0)."%</td>";
		$acheivement_per[]=round($grand_total_act*100/$grand_total_plan,0);
	}
	else
	{
		echo "<td bgcolor=\"#FF0000\">0%</td>";
		$acheivement_per[]=0;
	}
	
	echo "</tr>";
	
	
	
	$buyer_name_ref[]="Factory";
	
	$buyer_name_ref_implode="'".implode("','",$buyer_name_ref)."'";
	$acheivement_per_implode="".implode(",",$acheivement_per)."";
	
	//echo $buyer_name_ref_implode."-".$acheivement_per_implode."<br>";
	
	echo "<script type=\"text/javascript\">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'bar'
            },
            title: {
			    align: 'left',
                text: 'Product Wise Performance'
            },
            xAxis: {
                categories: [".$buyer_name_ref_implode."]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Achievement%'
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
                name: 'Achievement%',
                data: [".$acheivement_per_implode."]
            }]
        });
    });
    
});
		</script>
	
<script src=\"highcharts.js\"></script>
<script src=\"exporting.js\"></script>

<div id=\"container\" style=\"width: 1100px; height: 400px; margin: 0 auto\"></div>";
echo "</table>";
}

?>
<body>
</html>
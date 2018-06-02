<html>
<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions.php");

$view_access=user_acl("SFCS_0245",$username,1,$group_id_sfcs); 
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
<div id="page_heading"><span style="float: left"><h3>Day Wise Performance Report</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>

<form action="product_wise_summary_report_day.php" method="post">
Start Date&nbsp;&nbsp;<input type="text" size="8" name="dat1" id="demo1" value="<?php echo date("Y-m-d"); ?>"/>
<?php 
	echo "<a href="."\"javascript:NewCssCal('demo1','yyyymmdd','dropdown')\">";
	echo "<img src='images/cal.gif' width='16' height='16' alt='Pick a date'></a>";
?>&nbsp;&nbsp;&nbsp;&nbsp;
End Date&nbsp;&nbsp;<input type="text" size="8" name="dat2" id="demo2" value="<?php echo date("Y-m-d"); ?>"/>
<?php 
	echo "<a href="."\"javascript:NewCssCal('demo2','yyyymmdd','dropdown')\">";
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
	$edate=$_POST["dat2"];
	$shift=$_POST["shift"];
	$product=$_POST["product"];	
	
	$dates_ref=array();
	$plan_out_ref=array();
	$act_out_ref=array();
	$dif_out_ref=array();
	
	/*$sql_source="SELECT buyer_id,GROUP_CONCAT(\"'\",MOVEX_STYLE,\"'\") as styles FROM bai_pro2.movex_styles WHERE LENGTH(buyer_id)>0 and buyer_id in (".$product.") GROUP BY buyer_id";
	//echo $sql_source."<br><br>";
	$result_source=mysql_query($sql_source,$link) or die("Error=".$sql_source."=".mysql_error());
	while($row_source=mysql_fetch_array($result_source))
	{
		$buyer_name=$row_source["buyer_id"];
		$styles=$row_source["styles"];
	}*/	
	
	$sql_source="SELECT buyer_div,GROUP_CONCAT(\"'\",module_id,\"'\") as modules FROM $bai_pro3.plan_modules WHERE LENGTH(buyer_div)>0 and buyer_div in (".$product.")";
	//echo $sql_source."<br><br>";
	$result_source=mysqli_query($link, $sql_source) or die("Error=".$sql_source."=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row_source=mysqli_fetch_array($result_source))
	{
		$buyer_name=$row_source["buyer_id"];
		$modules=$row_source["modules"];
	}	
	
	$sql1="select distinct date as date from $bai_pro.grand_rep where date between \"".$sdate."\" and \"".$edate."\" order by date";
	//echo $sql1."<br>";
	$result1=mysqli_query($link, $sql1) or die("Error=".$sql1."=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$dates_ref[]=$row1["date"];
	}	
	
	echo "<table cellspacing=\"0\" class=\"mytable1\">";
	echo "<tr><th>Dates</th>";
	for($i=0;$i<sizeof($dates_ref);$i++)
	{
		echo "<th>".$dates_ref[$i]."</th>";
	}
	echo "</tr>";
	
	echo "<tr><th>Plan</th>";
	for($i=0;$i<sizeof($dates_ref);$i++)
	{
		//$sql1="select sum(plan_out) as plan_out from bai_pro.grand_rep where date=\"".$dates_ref[$i]."\" and styles in (".$styles.") and shift in (".$shift.")";
		$sql1="select sum(plan_out) as plan_out from $bai_pro.grand_rep where date=\"".$dates_ref[$i]."\" and module in (".$modules.") and shift in (".$shift.")";
		//echo $sql1."<br>";
		$result1=mysqli_query($link, $sql1) or die("Error=".$sql1."=".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($result1) > 0)
		{
			while($row1=mysqli_fetch_array($result1))
			{
				echo "<td>".round($row1["plan_out"],0)."</td>";
				$plan_out_ref[]=round($row1["plan_out"],0);
			}
		}
		else
		{
			echo "<td>0</td>";
			$plan_out_ref[]=0;
		}
	}
	echo "</tr>";
	
	echo "<tr><th>Actual</th>";
	for($i=0;$i<sizeof($dates_ref);$i++)
	{
		//$sql1="select sum(act_out) as act_out from bai_pro.grand_rep where date=\"".$dates_ref[$i]."\" and styles in (".$styles.") and shift in (".$shift.")";
		$sql1="select sum(act_out) as act_out from $bai_pro.grand_rep where date=\"".$dates_ref[$i]."\" and  module in (".$modules.") and shift in (".$shift.")";
		//echo $sql1."<br>";
		$result1=mysqli_query($link, $sql1) or die("Error=".$sql1."=".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($result1) > 0)
		{
			while($row1=mysqli_fetch_array($result1))
			{
				echo "<td>".round($row1["act_out"],0)."</td>";
				$act_out_ref[]=round($row1["act_out"],0);
			}
		}
		else
		{
			echo "<td>0</td>";
			$act_out_ref[]=0;
		}
	}
	echo "</tr>";
	
	echo "<tr><th>Difference</th>";
	for($i=0;$i<sizeof($dates_ref);$i++)
	{
		//$sql1="select sum(plan_out) as plan_out from bai_pro.grand_rep where date=\"".$dates_ref[$i]."\" and styles in (".$styles.") and shift in (".$shift.")";
		$sql1="select sum(plan_out) as plan_out from $bai_pro.grand_rep where date=\"".$dates_ref[$i]."\" and module in (".$modules.") and shift in (".$shift.")";
		//echo $sql1."<br>";
		$result1=mysqli_query($link, $sql1) or die("Error=".$sql1."=".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($result1) > 0)
		{
			while($row1=mysqli_fetch_array($result1))
			{
				//echo "<td>".round($row1["plan_out"],0)."</td>";
				$plan_out=round($row1["plan_out"],0);
			}
		}
		else
		{
			//echo "<td>0</td>";
			$plan_out=0;
		}
		
		//$sql1="select sum(act_out) as act_out from bai_pro.grand_rep where date=\"".$dates_ref[$i]."\" and styles in (".$styles.") and shift in (".$shift.")";
		$sql1="select sum(act_out) as act_out from $bai_pro.grand_rep where date=\"".$dates_ref[$i]."\" and  module in (".$modules.") and shift in (".$shift.")";
		//echo $sql1."<br>";
		$result1=mysqli_query($link, $sql1) or die("Error=".$sql1."=".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($result1) > 0)
		{
			while($row1=mysqli_fetch_array($result1))
			{
				//echo "<td>".round($row1["act_out"],0)."</td>";
				$act_out=round($row1["act_out"],0);
			}
		}
		else
		{
			//echo "<td>0</td>";
			$act_out=0;
		}
		
		echo "<td>".($plan_out-$act_out)."</td>";
		$dif_out_ref[]=($plan_out-$act_out);
	}
	echo "</tr>";
	
	$dates_ref_val="'".implode("','",$dates_ref)."'";
	$plan_out_ref_val="".implode(",",$plan_out_ref)."";
	$act_out_ref_val="".implode(",",$act_out_ref)."";
	$dif_out_ref_val="".implode(",",$dif_out_ref)."";
	
	//echo $dates_ref_val."<br>".$dif_out_ref_val."<br>".$plan_out_ref_val."<br>".$act_out_ref_val."<br>";
	
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
                text: 'Day Wise Performance'
            },
            xAxis: {
                categories: [".$dates_ref_val."]
            },
            yAxis: {
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
            enabled: true
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
               line: {
			   pointPadding: 0.0,
			   borderWidth: 2,
                    dataLabels: {
                        enabled: true
                    }
                },
				enableMouseTracking: false
            },
            series: [{
                name: 'Plan',
                data: [".$plan_out_ref_val."]
            },{
                name: 'Actual',
                data: [".$act_out_ref_val."]
            },{
                name: 'Difference',
                data: [".$dif_out_ref_val."]
            }]
        });
    });
    
});
		</script>
	
<script src=\"highcharts1.js\"></script>
<script src=\"exporting.js\"></script>



<div id=\"container\" style=\"width: 1100px; height: 400px; margin: 0 auto\"></div>";
echo "</table>";
}

?>
<body>
</html>
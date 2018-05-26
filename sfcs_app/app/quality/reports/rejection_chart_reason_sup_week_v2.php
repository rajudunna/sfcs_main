<?php 

// Service Request #356672  / RameshK / 2015-01-29 / Q:Week Number Showing starting from 0 instead of 1 / S:Added 1 to Week number for,since mysql starting the week from zero

?>

<style>
table {
    border: 3px solid black;
}
</style>

<?php
$week_qty1=array();
$week_no1=array();

$sql3="SELECT GROUP_CONCAT(reason_code) AS res_code FROM $bai_pro3.bai_qms_rejection_reason WHERE reason_cat=\"FABRIC\"";
//echo $sql3."<br>";
$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".$sql3.mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row3=mysqli_fetch_array($sql_result3))
{
	$reason_codes=$sql_row3["res_code"];
}
if($reason_codes == ''){
    $reason_codes = '" "';
}
$sql131="SELECT distinct supplier as supplier FROM $bai_pro3.bai_qms_db_reason_track WHERE qms_reason IN ($reason_codes) and length(supplier) > 0 and log_date between \"$sdate\" and \"$edate\"";
//echo $sql131."<br>";
$sql_result131=mysqli_query($link, $sql131) or exit("Sql Error".$sql131.mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row131=mysqli_fetch_array($sql_result131))
{

$supplier_name=$sql_row131["supplier"];

$i1=2;
$j=0;
$k=0;
$colors_array=array("#4775A3","#D175A3","#33FFD6","#FFD119","#52CC52","#CC2900","#7575A3");

echo "<br><br>";

echo "<div class='table table-responsive'><table cellpadding='5' border='2px solid black' bgcolor='#FFDB4D'>";

$sql2="SELECT DISTINCT qms_reason as def FROM $bai_pro3.bai_qms_db_reason_track WHERE qms_reason IN ($reason_codes) and supplier=\"".$supplier_name."\" and log_date between \"$sdate\" and \"$edate\" order by qms_reason";
//echo $sql2."<br>";
$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".$sql2.mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row2=mysqli_fetch_array($sql_result2))
{ 

$defect=$sql_row2["def"];

$sql4="select reason_desc as des from $bai_pro3.bai_qms_rejection_reason where reason_code=\"".$defect."\"";
$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error".$sql4.mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row4=mysqli_fetch_array($sql_result4))
{ 
	$defect_name=$sql_row4["des"];
}

$j=$j+1;


if($j==1)
{
	echo "<tr>";
}

$sql121="select distinct week(log_date) as wkno from $bai_pro3.bai_qms_db_reason_track WHERE QMS_TID IN (SELECT QMS_TID FROM bai_qms_db WHERE log_date between \"$sdate\" and \"$edate\" AND qms_tran_type=3 AND SUBSTRING_INDEX(SUBSTRING_INDEX(remarks,'-',2),'-',-1) in ($team)) AND qms_reason IN ($reason_codes) and log_date between \"$sdate\" and \"$edate\"";
$sql_result121=mysqli_query($link, $sql121) or exit("Sql Error".$sql121.mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row121=mysqli_fetch_array($sql_result121))
{
$wkno=$sql_row121['wkno'];

$sql12="SELECT SUM(qms_qty) as qty,WEEK(log_date)+1 as wkno FROM $bai_pro3.bai_qms_db_reason_track WHERE QMS_TID IN (SELECT QMS_TID FROM bai_qms_db WHERE log_date between \"$sdate\" and \"$edate\" AND qms_tran_type=3 AND SUBSTRING_INDEX(SUBSTRING_INDEX(remarks,'-',2),'-',-1) in (".$team.")) AND qms_reason IN ($reason_codes) and week(log_date)=\"$wkno\" and qms_reason=\"$defect\" and supplier=\"".$supplier_name."\" and log_date between \"$sdate\" and \"$edate\" GROUP BY WEEK(log_date) order by WEEK(log_date)+0";
//echo $sql12."<br>"; 
$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".$sql12.mysqli_error($GLOBALS["___mysqli_ston"]));
//echo $wkno."-".mysql_num_rows($sql_result12)."-".$defect."<br>";
	if(mysqli_num_rows($sql_result12) > 0)
	{
		while($sql_row12=mysqli_fetch_array($sql_result12))
		{
			$week_no1[]=$sql_row12["wkno"];
			$week_qty1[]=$sql_row12["qty"];
		}
	}
	else
	{
		$week_no1[]=$wkno+1;
		$week_qty1[]=0;
	}
}
$week_no_implode1="'".implode("','",$week_no1)."'";
$week_qty_implode1=implode(",",$week_qty1);

//echo $week_qty_implode1."-".$week_no_implode1;
if(sizeof($week_no1) > 0)
{
echo "<script type=\"text/javascript\">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container$supplier_name".$i1."',
                type: 'line',
				borderColor: '#190707',
				borderWidth: 3
            },
            title: {
			    align: 'left',
                text: '".$supplier_name."'
            },
            xAxis: {
				title: {
                    text: 'Week'
                },
				gridLineWidth: 0,
				minorGridLineWidth: 0,
                categories: [".$week_no_implode1."]
            },
			colors: ['".$colors_array[$k]."'],
            yAxis: {
                min: 0,
				gridLineWidth: 0,
				gridLineColor: '#FFFFFF',
				minorGridLineWidth: 0,
                title: {
                    text: 'Rejection Qty'
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
                y: 5,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                formatter: function() {
                    return '<b>Week : '+ this.x +'</b><br/>'+
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
                }
            },
            series: [{
                name: '".$defect_name."',
                data: [".$week_qty_implode1."]
            }]
        });
    });
    
});
</script>
<script src=\"highcharts.js\"></script>
<th><div id=\"container$supplier_name".$i1."\" style=\"width: 450px; height: 250px; margin: 0 auto\"></div></th>";

if($j==3)
{
	$j=0;
	echo "</tr>";
}	

unset($week_no1);
unset($week_qty1);

$k=$k+1;

$i1=$i1+1;
}
else
{
	echo "<H2>There is not data to display in the selected period.</H2>";
}
}
echo "</table></div>";
}

?>
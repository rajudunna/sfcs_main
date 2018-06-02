<?php

$week_qty2=array();
$week_no2=array();


$sql3="SELECT GROUP_CONCAT(reason_code) AS res_code FROM $bai_pro3.bai_qms_rejection_reason WHERE reason_cat=\"FABRIC\"";
// var_dump($link);
// echo $sql3."<br>";
$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".$sql3.mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row3=mysqli_fetch_array($sql_result3))
{
	$reason_codes=$sql_row3["res_code"];
}
if($reason_codes == ''){
    $reason_codes = '" "';
}
$sql13="SELECT SUM(qms_qty) as qty,supplier as supplier FROM $bai_pro3.bai_qms_db_reason_track WHERE QMS_TID IN (SELECT QMS_TID FROM bai_qms_db WHERE log_date between \"$sdate\" and \"$edate\" AND qms_tran_type=3 AND SUBSTRING_INDEX(SUBSTRING_INDEX(remarks,'-',2),'-',-1) in ($team)) AND qms_reason IN ($reason_codes) and length(supplier) > 0 and log_date between \"$sdate\" and \"$edate\" GROUP BY supplier order by supplier";
//echo $sql13."<br>"; 
$sql_result13=mysqli_query($link, $sql13) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row13=mysqli_fetch_array($sql_result13))
{
	$supplier_name2[]=$sql_row13["supplier"];
	$week_qty2[]=$sql_row13["qty"];
	//echo $sql_row1["qty"]."<br>";
}

if(sizeof($supplier_name2) > 0)
{
$supplier_name2_implode2="'".implode("','",$supplier_name2)."'";
$week_qty_implode2=implode(",",$week_qty2);

//echo $week_qty_implode;
echo "<br><br>";

echo "<script type=\"text/javascript\">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container1',
				borderColor: '#000000',
				borderWidth: 3,
                type: 'column'
            },
            title: {
				x: 325,
				y:30,
			    align: 'left',
                text: 'Supplier Wise Rejection'
            },
            xAxis: {
				title: {
                    text: 'Supplier'
                },
                categories: [".$supplier_name2_implode2."]
            },
            yAxis: {
                min: 0,
				gridLineWidth: 0,
				gridLineColor: '#FFFFFF',
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
            enabled: false
       		},
            legend: {
                align: 'left',
				layout: 'horizontal',
                x: 705,
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
                    return '<b>Date : '+ this.x +'</b><br/>'+
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
                name: 'Rejection Qty',
				color:'#9AFE2E',
                data: [".$week_qty_implode2."]
            }]
        });
    });
    
});
</script>
	
<script src=\"../common/js/highcharts.js\"></script>
<script src=\"../common/js/exporting.js\"></script>

<div id=\"container1\" style=\"width: 900px; height: 400px; margin: 0 auto\"></div>";
}
else
{
	echo "<div class='alert alert-danger'>There is not data to display in the selected period.</div>";
}

?>
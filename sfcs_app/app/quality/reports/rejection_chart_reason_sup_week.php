
<?php

$week_qty2=array();
$week_no2=array();

$i1=0;
$j=0;
$k=0;

$colors_array=array("#4775A3","#D175A3","#33FFD6","#FFD119","#52CC52","#CC2900","#7575A3","#4775A3","#D175A3","#33FFD6","#FFD119","#52CC52","#CC2900","#7575A3");

echo "<table cellpadding='5' border='2px solid black' bgcolor='#0000FF'>";

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
$row_count = 0;
$sql131="SELECT distinct supplier as supplier FROM $bai_pro3.bai_qms_db_reason_track WHERE QMS_TID IN (SELECT QMS_TID FROM $bai_pro3.bai_qms_db WHERE log_date between \"$sdate\" and \"$edate\" AND qms_tran_type=3 AND SUBSTRING_INDEX(SUBSTRING_INDEX(remarks,'-',2),'-',-1) in ($team)) AND qms_reason IN ($reason_codes) and length(supplier) > 0 and log_date between \"$sdate\" and \"$edate\"";
//echo $sql131."<br>";
$sql_result131=mysqli_query($link, $sql131) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row131=mysqli_fetch_array($sql_result131))
{
    $row_count++;
    $i1=$i1+1;
    $j=$j+1;

    if($j==1)
    {
    	echo "<tr>";
    }
    $sql121="select distinct week(log_date) as wkno from $bai_pro3.bai_qms_db_reason_track WHERE QMS_TID IN (SELECT QMS_TID FROM $bai_pro3.bai_qms_db WHERE log_date between \"$sdate\" and \"$edate\" AND qms_tran_type=3 AND SUBSTRING_INDEX(SUBSTRING_INDEX(remarks,'-',2),'-',-1) in ($team)) AND qms_reason IN ($reason_codes) and length(supplier) > 0 and log_date between \"$sdate\" and \"$edate\"";
    //echo $sql121;
    $sql_result121=mysqli_query($link, $sql121) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row121=mysqli_fetch_array($sql_result121))
    {
    	$wkno=$sql_row121['wkno'];
    	$sql13="SELECT SUM(qms_qty) as qty,WEEK(log_date)+1 as wkno FROM $bai_pro3.bai_qms_db_reason_track WHERE QMS_TID IN (SELECT QMS_TID FROM $bai_pro3.bai_qms_db WHERE log_date between \"$sdate\" and \"$edate\" AND qms_tran_type=3 AND SUBSTRING_INDEX(SUBSTRING_INDEX(remarks,'-',2),'-',-1) in (".$team.")) AND qms_reason IN ($reason_codes) and length(supplier) > 0 and supplier=\"".$sql_row131["supplier"]."\" and week(log_date)=\"$wkno\" and log_date between \"$sdate\" and \"$edate\" GROUP BY WEEK(log_date) order by WEEK(log_date)+0";
    	//echo $sql13."<br>"; 
    	$sql_result13=mysqli_query($link, $sql13) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    	if(mysqli_num_rows($sql_result13) > 0)
    	{
    		while($sql_row13=mysqli_fetch_array($sql_result13))
    		{
    			$week_no2[]=$sql_row13["wkno"];
    			$week_qty2[]=$sql_row13["qty"];
    			//echo $sql_row1["qty"]."<br>";
    		}
    	}
    	else
    	{
    		$week_no2[]=$wkno+1;
    		$week_qty2[]=0;
    	}
    }
    $week_no_implode2="'".implode("','",$week_no2)."'";
    $week_qty_implode2=implode(",",$week_qty2);

    //echo $week_qty_implode;
    echo "<br>";
    if(sizeof($week_no2) > 0)
    {
        echo "
        <script type=\"text/javascript\">
            $(function () {
                var chart;
                $(document).ready(function() {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'container1$i1',
            				borderColor: '#000000',
            				borderWidth: 3,
                            type: 'line'
                        },
                        title: {
            			    align: 'left',
                            text: '".$sql_row131["supplier"]."'
                        },
                        xAxis: {
            				title: {
                                text: 'Week'
                            },
                            categories: [".$week_no_implode2."]
                        },
            			colors: ['".$colors_array[$k]."'],
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
                            name: 'Rejection',
                            data: [".$week_qty_implode2."]
                        }]
                    });
                });
                
            });
        </script>";

        echo "<th><div id=\"container1$i1\" style=\"width: 450px; height: 250px; margin: 0 auto\">
              </div></th>";

        if($j==3)
        {
        	$j=0;
        	echo "</tr>";
        }	
        $k=$k+1;

        unset($week_no2);
        unset($week_qty2);
    }
    else
    {
    	echo "<H2>There is not data to display in the selected period.</H2>";
    }
}
echo "</table>";

if($row_count==0){
    echo "<b><font color='red' size='4'>No Data Found</font></b>";
}
// if(sizeof($week_no2) == 0){
//     echo "<div class='alert alert-danger'>There is no data to display in the selected period.</div>";
// }
?>
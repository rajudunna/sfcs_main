<?php

$week_qty=array();
$week_no=array();
$sql1z="SELECT distinct supplier as supplier FROM $bai_pro3.bai_qms_db_reason_track WHERE qms_reason in (".$reasons_list_ref.") ".$suppliers_list_ref_query." and log_date between \"".$sdate."\" and \"".$edate."\" GROUP BY supplier";
$sql_result1z=mysqli_query($link, $sql1z) or exit("bai_qms_db_reason_track Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1z=mysqli_fetch_array($sql_result1z))
{
	$supplier_namez[]=$sql_row1z["supplier"];
}

$qtyz=array();	
$qtyz2=array();	

for($iz1=0;$iz1<sizeof($supplier_namez);$iz1++)
{
	$sql11z="SELECT * FROM $bai_pro3.bai_qms_db_reason_track WHERE supplier='".$supplier_namez[$iz1]."' AND qms_reason in (".$reasons_list_ref.") and log_date   between \"".$sdate."\" and \"".$edate."\"";
	// echo $sql11z."<br>";
	$qtyz1=0;	
	$sql_result11z=mysqli_query($link, $sql11z) or exit("bai_qms_db_reason_track inner Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result11z) > 0)
	{
		while($sql_row11z=mysqli_fetch_array($sql_result11z))
		{	
			$qtyz1=$qtyz1+$sql_row11z["qms_qty"];
		}
		if($rejval==1)
		{
			$qtyz[]=$qtyz1;
		}
		else
		{
			$qtyz[]=round(($qtyz1*100)/$output,2);
		}
	}
	else
	{
		$qtyz[]=0;
		$qtyz2[]=0;
	}
	
	if($iz1==0)
	{
		$series_refz="{name: '".$supplier_namez[$iz1]."',data: [".implode(",",$qtyz)."]}";
	}
	else
	{
		$series_refz.=",{name: '".$supplier_namez[$iz1]."',data: [".implode(",",$qtyz)."]}";
	}	 
}
$series_refz.=",{name: 'ALL',data: [".implode(",",$qtyz)."]}";

$qtyz[]=array_sum($qtyz); 

//echo $series_refz."<br>";

$supplier_namez[]="ALL";

$supplier_name_implodez="'".implode("','",$supplier_namez)."'";


// var_dump($qtyz);
$week_qty_implodez=implode(",",$qtyz);
echo "<br><br><br><script type=\"text/javascript\">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'containerxx',
				borderColor: '#000000',
				borderWidth: 3,
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
                text: 'Supplier Wise Rejection Quantity ".$add_string."'
            },
            xAxis: {
                categories: [".$supplier_name_implodez."]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Rejection Qty'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
						color: '#000000',
						connectorColor: '#000000',
						fontSize: '15px',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
			exporting: {
            enabled: false
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
            series: [{
				fontSize: '55px',
				style: {
				fontSize: '55px',
				color: '#000000'
				},
                name: 'Rejection Qty',
                data: [".$week_qty_implodez."]
            }]
        });
    });
    
});

</script>

<div class=\"table-responsive\">
<div id=\"containerxx\" style=\"width: 1200px; height: 500px; margin: 0 auto\"></div></div>";
?>
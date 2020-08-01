<?php

for($j12=0;$j12<sizeof($supplier_code);$j12++)
{
	$qty=0;
	$sql11="SELECT * FROM $bai_pro3.bai_qms_db_reason_track WHERE qms_reason in(".implode(",",$reasons_list).") and log_date between \"".$sdate."\" and \"".$edate."\" and supplier=\"".$supplier_code[$j12]."\"";
	//echo $sql11."<br>";
	$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result11) > 0)
	{
		while($sql_row11=mysqli_fetch_array($sql_result11))
		{	
			$qty=$qty+$sql_row11["qms_qty"];
		}
		//$qty_total[]=$qty;
	}
	else
	{
		$qty=0;
		//$qty_total[]=$qty;
	}

	if($j12==0)
	{
		$series_ref1x="['".($supplier_code[$j12])."',".$qty."]";
	}
	else
	{
		$series_ref1x.=",['".($supplier_code[$j12])."',".$qty."]";
	}	
}
//echo $series_ref1x."<br>";
echo "<script type=\"text/javascript\">
			$(function () {
		$('#containerw').highcharts({
        chart: {
		    renderTo: 'container',
		    borderWidth: 3,
            borderColor: '#000000',
			plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: '<b><h3>Supplier Wise Rejection Quantity<h3><b>',
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
                    fontSize: '15px'
					},
                    format: '<b>{point.name}</b>: <b>{point.percentage:.1f}<b> %'
                },
				showInLegend: true
            }
        },
		legend: {
                enabled: true,
                layout: 'horizontal',
                align: 'bottom',
                useHTML: true,
				style: {
                    fontSize: '55px'
					},
                verticalAlign: 'bottom'
         },
        series: [{
            type: 'pie',
			fontSize: '25px',
            name: 'Received Qty',
			color: '#000000',
			style: {
			fontSize: '25px'
			},
            data:  [".$series_ref1x."]
        }]
    });
});
</script>

<div class=\"table-responsive\">

<div id=\"containerw\" style=\"width: 1200px; height: 650px; margin: 0 auto\"></div></div>";

?>
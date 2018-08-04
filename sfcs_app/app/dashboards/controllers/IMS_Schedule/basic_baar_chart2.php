
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); ?>
<?php  
$section=$_GET['id'];
$sqlx="select * from $bai_pro3.sections_db where sec_id=$section";

	$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error1.1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	while($sql_rowx=mysqli_fetch_array($sql_resultx))     //section Loop -start
	{
		$range=$sql_rowx['sec_mods'];
	}


$sql_module_data="SELECT SUM(ims_qty-ims_pro_qty) AS WIP   FROM $bai_pro3.ims_log WHERE ims_mod_no IN ($range) GROUP BY ims_mod_no";

	$sql_result_module_data=mysqli_query($link, $sql_module_data) or exit("Sql Error1.2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	while($sql_row_module_data=mysqli_fetch_array($sql_result_module_data))
	{
		$chart_data.=$sql_row_module_data['WIP'].",";
	}

?>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>WIP Chart</title>

		<script type="text/javascript" src="../../../../common/js/jquery.js"></script>
		<!-- <script src="../../common/js/highcharts.js"></script> -->
        <script src="https://code.highcharts.com/highcharts.js"></script>
        
        <script type="text/javascript">

        $(document).ready(function(){
              Highcharts.chart('container1',{
                chart: {
                    type: 'column',
                    margin: [ 50, 50, 100, 80]
                },
                title: {
                    text: 'Section <?php echo $section; ?> WIP Variation'
                },
                xAxis: {
                    categories: [
                       <?php echo $range; ?>
                    ],
                    labels: {
                        rotation: -45,
                        align: 'right',
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Pieces'
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    formatter: function() {
                        return '<b>'+ this.x +'</b><br/>'+
                            ' '+ Highcharts.numberFormat(this.y, 0) +
                            ' pieces';
                    }
                },
                series: [{
                    name: 'Population',
                    data: [<?php echo $chart_data; ?>],
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#FFFFFF',
                        align: 'right',
                        x: 4,
                        y: 10,
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                }]
            });

        })
       
    

		</script>
        

<div id="container1" style="min-width: 400px; height: 400px; margin: 0 auto"></div>




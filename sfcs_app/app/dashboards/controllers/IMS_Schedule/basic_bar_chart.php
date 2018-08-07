<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript">
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Modulewise WIP'
            },
            subtitle: {
                text: 'Source: BEKNET(Shop Floor System - BEK)'
            },
            xAxis: {
                categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9'],
                title: {
                    text: ['Module Numbers']
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'No of Pieces ',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' pieces'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -100,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: true
            },
            series: [ {
                name: 'Section 1',
                data: [2884,	5713,	1642,	1119,	404,	769,	2762,	4064,	2247]
            }]
        });
    });
    

		</script>
        
        <script type="text/javascript">
$(function () {
        $('#container2').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Modulewise WIP'
            },
            subtitle: {
                text: 'Source: BEKNET(Shop Floor System - BEK)'
            },
            xAxis: {
                categories: [ '10', '11', '12', '13', '14', '15', '16', '17', '18'],
                title: {
                    text: ['Module Numbers']
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'No of Pieces ',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' pieces'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -100,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [ {
                name: 'Section 2',
                data: [	2399,	2655,	1143,	2766,	2178,	2298,	649,	1104,	1339]
            }]
        });
    });
    

		</script>
	</head>
	<body>
<script src="js/highcharts.js"></script>
<script src="js/modules/exporting.js"></script>

<div id="container" style="width: 500px; height: 500px; margin: 0 auto;float:left;margin:50px;"></div>
<div id="container2" style="width: 500px; height: 500px; margin: 0 auto;float:left;margin:50px;"></div>

	</body>
</html>

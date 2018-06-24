<html>
    <head>
	<?php 
	set_time_limit(90000000);
	?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Plan SAH and Actual SAH</title>
		<!--   add scripts -->
        <script src="js/jquery.min1.7.1.js"></script>
        <script src="js/highcharts.js"></script>
		<script src="js/modules/exporting.js"></script>
		<script src="js/echarts-all.js"></script>
		<script type='text/javascript' src='js/datetimepicker_css.js'></script>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<style>
			li{
				float:left;
				padding: 10px;
				
				margin:2px;
			}
			#tableone thead.Fixed
			{
			     position: absolute; 
			}
		</style>

		<style>
		
			body
			{
				font-family:calibri;
				font-size:12px;
			}

			table tr
			{
				border: 1px solid black;
				text-align: right;
				white-space:nowrap; 
			}
			table td
			{
				border: 1px solid black;
				text-align: center;
				white-space:nowrap; 
			}

			table th
			{
				border: 1px solid black;
				text-align: center;
			    	background-color: BLUE;
				color: WHITE;
			white-space:nowrap; 
				padding-left: 5px;
				padding-right: 5px;
				background: #29759C;
			}
			table{
				white-space:nowrap; 
				border-collapse:collapse;
				font-size:12px;
				background-color: white;
			}
			#cont {
				    height: 300px;
				    width: 100px;
				    margin: 1em auto;
				}
			#tbl_id
			{
				position:absolute;
				left:0px;
				top:58px;
				z-index: 1;
			}
			#header
			{
				float: left;
				background-color:BLUE;
				color: WHITE;
				white-space:nowrap;
				background: #29759C;
				width:12.5em;
			}
			
			#section1
			{
				float: left;
				color: WHITE;
				white-space:nowrap;
				width:12.5em;
				position: absolute;
				top:36%;
				bottom:0;
				left:0.8%;
				right:0;
			}
			
			
			#section3
			{
				position: absolute;
				top:10%;
				bottom:0;
				left:13%;
				right:0;
			}
			#data_part
			{
				position: absolute;
				top:11%;
				bottom:0;
				left:0.8%;
				right:0;
				
			}
			#month
			{
				position: absolute;
				top:7%;
				bottom:0;
				left:0.8%;
				right:0;
			}
			.pie_chart
			{
				position: absolute;
				top:47%;
				bottom:0;
				left:-7%;
				right:0;
				
			}
			#sect
			{
				position: absolute;
				top:30%;
				bottom:0;
				left:0.8%;
				right:0;
				
			}
			#view
			{
				
				position: absolute;
				top:13%;
				bottom:0;
				left:12.3%;
				right:0;
			}
			
			
			
			#page_heading
			{
			    	width: 100%;
				    height: 25px;
			    	color: WHITE;
			    	background-color: #29759c;
			    	z-index: -999;
			    	font-family:Arial;
			    	font-size:15px;  
			    	margin-bottom: 10px;
			}

			#page_heading h3
			{
				vertical-align: middle;
				margin-left: 15px;
				margin-bottom: 0;	
				padding: 0px;
			}

			#page_heading a
			{
				color: WHITE;
			}

			#page_heading img
			{
				margin-top: 2px;
			    	margin-right: 15px;
			}

			body
			{
				background-color: white;
				font-family:arial;
			}

			.tblheading th
			{
				background-color:#29759C;
			}

			table{
				white-space:nowrap; 
				border-collapse:collapse;
				font-size:12px;
				background-color: white;
			}
			input,select,textarea{
			border-color:black; border-style: solid;
			border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px;}
			
		</style>
	</head>
	<body background="white">
	<?php
include('C:\xampp\htdocs\sfcs_main\sfcs_app\common\config\config_jobs.php');
include('C:\xampp\htdocs\sfcs_main\sfcs_app\app\dashboards\controllers\PLD_Dashboard\sah_monthly_status\data.php');

		

			error_reporting(0);
			error_reporting(E_ERROR | E_WARNING | E_PARSE);
			if($_POST['module'])
			{
				$var=$_POST['module'];
			}
			else
			{
				$var=0;
			}
			
echo '<div id="page_heading"><span style="float: left"><h3>SAH Countdown Report</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>';
			
			$from = date("Y-m-1");
			$todate = date("Y-m-d");
			$day_year = date("Y",strtotime($from));
			//echo "<br/>year is:".$todaydate;
			$day_month= date("F",strtotime($from));
			//echo "<br/>month is:".$todaydate;
			$lastday= date('Y-m-d', strtotime($todate .' -1 day'));
			$name_arr[] = "$day_year-$day_month";
			$sql = "SELECT left(date,7) as 'month', right(date,2) as date FROM $bai_pro.grand_rep where date between '$from' and '$todate' group by date";
			$query = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($r = mysqli_fetch_array($query))
			{
				$category[] = $r['date'];
			}
	?>	
		<!-- Load the Graph -->
	<script type="text/javascript">
	$(function ()
	{
		init();
	});
	function init()
	{	
		$('#containe').highcharts({
    	chart:
		{
        	type: 'spline'
        },
        subtitle:
		{
            text: ''		// Subtitle for chart
        },
		title: {
			text: 'Plan vs Actual SAH  <?php echo $name_arr[0]; ?>'
			},
	    xAxis:[{
		    	categories: [<?php				// Generate X axis using php array
								for($counter = 0;$counter <count($category);$counter++ )
								{ 
									echo "'".$category[$counter]."',";
								}	
								?>],
				title: {
			    	   	text: "Date",
						style: {
				        	     color: '#043322'
				           		}
						},
				labels: {
					      rotation: 0
				        }
			}],
		yAxis: {
			        min: -5000, 
					
					tickInterval: 1000,
					title: {
		                	text: "SAH",
							style: {
		                        		color: '#000000'
		                    		}
		                	},
					labels: {
					            formatter: function ()
								{
					                 return Highcharts.numberFormat(this.value,0);
					            }
				        	},
		        reserved: true
				},
				
				tooltip: {
	                crosshairs: true,
	                shared: false,
					headerFormat: '<span style="font-size: 10px">{point.key}</span><br/>',
					pointFormat: '<span style="color:{series.color}"></span> {series.name}: <b>{point.y:.0f}</b><br/>'
					
	            },
				
		<?php
		
			$sql = "SELECT date,sum(plan_sth) as 'plan', sum(act_sth) as 'act',(sum(act_sth)-sum(plan_sth)) as Different FROM $bai_pro.grand_rep where date between '$from' and '$todate' group by date";
			$chk = 0;			//echo $sql;
			$query = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($r = mysqli_fetch_array($query)) 
			{$chk = 1;
							//Series array for Actual
				$res1[] = $r['plan'];			//Series array for Actual
				$res2[] = $r['act'];
				$res3[] = $r['Different'];			//Series array for Actual
			}
			$result = array();					 
			
			$result[] = "{
				name: 'PLAN SAH',
				color: 'red',
				
				visible: true,
				data: [".implode(',',$res1)."]
			}";
			$result[] = "{
				name: 'ACTUAL SAH',
				color: 'green',
				
				visible: true,
				data: [".implode(',',$res2)."]
			}";
			$result[] = "{
				name: 'Different',
				color: 'blue',
				
				visible: true,
				data: [".implode(',',$res3)."]
			}";
			unset($res1);
			//unset($res);
			unset($res2);
			unset($res3);
		?>
       	series: [ <?php echo implode(",",$result); unset($result); ?>] // Generate series here
		
	});
	$('#cont').highcharts({
		    chart: {
		        marginBottom: 50
		    },
			 title: {
		        text: 'Plan Hit'
		    },
			xAxis: {
		        labels: {
		            enabled: false
		        },
		        lineWidth: 0,
		        tickWidth: 0
		    },
			yAxis: {
		        min: 0,
		        max: 100,
		        minPadding: 0,
		        maxPadding: 0,
		        startOnTick: false,
		        endOnTick: false,
		        title: {
		            text: ''
		        },
		        tickInterval: 5,
		        minorTickInterval: 1,
		        gridLineWidth: 0,
		        minorGridLineWidth: 0,
		        tickWidth: 1,
		        minorTickWidth: 1
		    },
			credits: {
			        enabled: false
			    },
			    legend: {
			        enabled: false
			    },
				plotOptions:
				{
		            series:
					{
                        borderWidth: 10,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.0f}%'
                        }
		             }
				},
		    series: [{
				
		        data: [<?php 
					$plan_tot_val = 0;
					$act_tot_val = 0;
					$plan_tot = 0;
					$act_tot = 0;
					$sql = "SELECT date,sum(plan_sth) as 'plan', sum(act_sth) as 'act',(sum(act_sth)-sum(plan_sth)) as Different FROM $bai_pro.grand_rep where date between '$from' and '$todate' group by date";
					$query = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					while($r = mysqli_fetch_array($query)) 
					{
						 // start code for total plan hit%
						$plan_tot = $plan_tot+$r['plan'];
						$act_tot = $act_tot+$r['act'];
			
					}
					$x = ($act_tot/$plan_tot)*100;echo round($x);  ?>],
				type: 'column',
		        pointWidth: 30,
		        threshold: 0,
		        borderWidth: 0,
		        name: 'Plan Hit'
		        
		    }]
		    
		    
		    
		   

		}, function (chart) {
		    // Draw the shape
		    var series = chart.series[0],
		        point = series.points[0],
		        radius = 0;
		    chart.renderer.circle(
		        chart.plotLeft + point.shapeArgs.x + (point.shapeArgs.width / 2), 
		        chart.plotTop + series.yAxis.len + radius - 0, 
		        35
		    )
		    .attr({
		        fill: series.color
		    })
		    .add();
		    
		});
}
</script>
<div style="width: 40%; position:absolute; height: 480px; float:right; top:40%; bottom: 0; left: 57%; right: 0">
	<table cellpadding="4" cellspacing="5" style="font size='15';" >
		<tr><td>Plan Hit</td></tr>
		<tr><td><?php echo round($x);?>%</td></tr>
	</table>
</div>
	<div id = "month">
		<table>
		<col width="78">
  		<col width="65">
			<tr >
				<th >Month</th>
				<td ><?php echo $day_month; ?></td>
			</tr>
		</table>
	</div><br/>
	<br/>
	
<div id="cont" style="width: 10%; position:absolute; height: 480px; float:right; top:5%; bottom: 0; left: 47%; right: 0"></div>
<div class = "img" id="containe" style="width: 38%; position:absolute; height: 480px; float:right; top:8%; bottom: 0; left: 62%; right: 0"></div>
<div id = "sect">
	<table>
	<col width="78">
  		<col width="65">
			<tr>
				<th>Average Eff %</th>
				<td><?php
						$sql = "SELECT ((sum(act_sth))/(sum(act_clh)))*100 as 'Act_eff' FROM $bai_pro.grand_rep where date between '$from' and '$todate'";
						$query = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						while($r = mysqli_fetch_array($query)) 
						{
							$act_eff = $r['Act_eff'];
						}
						echo round($act_eff)."%";
					?></td>
			</tr>
	</table>
</div>


<div id = "section1">
	<div>
		<table>
			<tr>
				<th>Section</th><th>Plan</th><th>Actual</th><th>Different</th>
			</tr>
			<?php 
			
				$sql1 = "SELECT section,sum(plan_sth) as 'plan', sum(act_sth) as 'act',(sum(act_sth)-sum(plan_sth)) as Diff FROM $bai_pro.grand_rep where date between '$from' and '$todate' group by section";
				$query1 = mysqli_query($GLOBALS["___mysqli_ston"], $sql1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				while($r1 = mysqli_fetch_array($query1)) 
				{
					$sec_id=$r1['section'];
					$sql2 = "SELECT sec_id,sec_head FROM $bai_pro3.sections_db where sec_id=$sec_id";
					$query2 = mysqli_query($GLOBALS["___mysqli_ston"], $sql2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					while($r2 = mysqli_fetch_array($query2)) 
					{
						$plantotal=$plantotal+$r1['plan'];
						$acttotal=$acttotal+$r1['act'];
						$diff=$diff+$r1['Diff'];
						if(round($r1['Diff'],0)>=0)
							{
								$bgcolor=" bgcolor=green ";
							}
							
							else
							{
								$bgcolor=" bgcolor=red";
							}
						echo "<tr>
								<td>".$r2['sec_id']."</td><td>".round($r1['plan'],0)."</td><td>".round($r1['act'],0)."</td><td class=\"BG\" $bgcolor style='color:white'>".round($r1['Diff'],0)."</td>
							</tr>";
					}
					
						
				}
				echo "<tr>
						<th colspan=1>Grand Total</th><th>".round($plantotal,0)."</th><th>".round($acttotal,0)."</th><th>".round($diff,0)."</th>
					</tr>";
			?>
		</table>
	</div>
</div>
		<?php
			echo "<div id = 'tbl' style='width: 10%; float:right; position:absolute; height: 480px; top:8%; bottom: 0; left: 25%; right: 0'><table border = '1'>";
				echo "<tr class = 'tblheading'>";
					echo "<th>Date</th>";	
					echo "<th>Plan SAH</th>";	
					echo "<th>Actual SAH</th>";	
					echo "<th>SAH Variation </th>";	
				echo "</tr>";
			$sql = "SELECT date,sum(plan_sth) as 'plan', sum(act_sth) as 'act',(sum(act_sth)-sum(plan_sth)) as Different FROM $bai_pro.grand_rep where date between '$from' and '$todate' group by date";
			$query = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($r = mysqli_fetch_array($query)) 
			{
				echo "<tr>";
					
					$plan_tot_val = $plan_tot_val+$r['plan'];
					$act_tot_val = $act_tot_val+$r['act'];
					$var_sah_val = $var_sah_val + $r['Different'];
					echo"<td>".$r['date']."</td>";					
					echo"<td>".round($r['plan'],0)."</td>";			
					echo"<td>".round($r['act'],0)."</td>";			
					echo"<td>".round($r['Different'],0)."</td>";			
						
				echo "</tr>";			
			}
			$query = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$r = mysqli_fetch_array($query);
			echo "<tr class = 'tblheading'>";
				echo"<td style='background: #29759C; color:white;'>Grand Total</td>";					
				echo"<td style='background: #29759C; color:white;'>".round($plan_tot_val,0)."</td>";			
				echo"<td style='background: #29759C; color:white;'>".round($act_tot_val,0)."</td>";	
				echo"<td style='background: #29759C; color:white;'>".round($var_sah_val,0)."</td>";			
			 echo "</tr>";
		echo "</table></div>";
		?>
		<div class="pie_chart" ><div  id="main" style="width: 60%;height: 400px;"></div></div>
	
	<script type="text/javascript">
	var myChart = echarts.init(document.getElementById('main')); 
        
        var	option = {
    tooltip : {
        formatter: "{a} <br/>{b} : {c}%"
    },
    
    series : [
        {
            name:'Efficiency',
            type:'gauge',
			min:0,
            max:140,
			startAngle:180,
            endAngle:0,
            splitNumber:14,
			axisLine: {            
                show: true,        
                lineStyle: {       
                    color: [[0.217, 'red'],[0.57, 'blue'],[1, 'green']], 
                    width: 20
                }
            },
			title : {
                show : true,
                offsetCenter: ['10%', -70],       
                textStyle: {       
                    color: '#333',
                    fontSize : 15
                }
            },
            detail : {height:-60,offsetCenter: ['7%', 60], formatter:'{value}%'},
            data:[{value: <?php echo round($act_eff); ?>, name: 'Efficiency'}]
        }
    ]
};


       myChart.setOption(option);              
	</script>
		
		<div id="data_part">
		<table>
		<col width="78">
  		<col width="65">
			<tr>
				<th>Planed SAH</th>
				<td><?php echo $fac_plan; ?></td>
			</tr>
			<tr>
				<th>Actual SAH</th>
				<td><?php echo round($act_tot,0); ?></td>
			</tr>
			<tr>
				<th>Balance</th>
				<td><?php echo (round($fac_plan,0)-round($act_tot,0)); ?></td>
			</tr>
			<tr>
				<th>Balance Days</th>
				<td><?php
						$arr=array();
						$arr = $date;
						$d = date('d');
						$count=0;
						for($i=0;$i<count($arr);$i++)
						{
							$d1 = date('d',strtotime($arr[$i]));
							if($d<=$d1)
							{
								$count++;
							}
							else{
								continue;
							}
						}
						echo ($count-1);
					?></td>
			</tr>
			<tr>
				<th>Req. Per Day</th>
				<td><?php
						$y=$count-1;
						$x=(round($fac_plan,0)-round($act_tot,0));
						if($y==0)
						{
						  $z=0;	
						}
						else
						{
						  $z=$x/$y;
						}
						echo round($z);
					?></td>
			</tr>
		</table> <br/>
	
	<div>
		<table>
		<col width="78">
  		<col width="65">
			<tr>
				<th>Last Day</th>
				<td><?php 
				
						if($from==$todate)
						{
							echo "0";
						}			
						else
						{
						$date_array= array();
						$sql = "SELECT date FROM $bai_pro.grand_rep where date between '$from' and '$todate' group by date";
						$query = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						
						while($r = mysqli_fetch_array($query))
						{
							$categ[] = $r['date'];
						}
						$c=count($categ)-2;
						$sql = "SELECT sum(act_sth) as act FROM $bai_pro.grand_rep where date = '$categ[$c]'";
						$query = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$r = mysqli_fetch_array($query);
						echo round($r['act']);
						}
					 ?></td>
			</tr>
		</table>
	</div>
	</div>
	<div id = "view">
		<table cellpadding="4" cellspacing="5" style="font size='15';">
			<tr >
				<td >Balance</td><td><?php echo (round($fac_plan,0)-round($act_tot,0)); ?></td>
			</tr>
			<tr>
			<td>Balance Days</td><td><?php
						$arr=array();
						$arr = $date;
						$d = date('d');
						$count=0;
						for($i=0;$i<count($arr);$i++)
						{
							$d1 = date('d',strtotime($arr[$i]));
							if($d<=$d1)
							{
								$count++;
							}
							else
							{
								continue;
							}
						}
						echo ($count-1);
					?></td>
			</tr>
			<tr>
				<td>Req.Per Day</td>
				<td><?php
						$y=$count-1;
						$x=(round($fac_plan,0)-round($act_tot,0));
						if($y==0)
						{
							$z=0;	
						}
						else
						{
							$z=$x/$y;
						}
						echo round($z);
					?></td>
			</tr>
		</table>
	</div>
	
	
</body>
</html>
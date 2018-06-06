<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
//$url1 = getURL(getBASE($_GET['r'])['base'].'/'.csr_view_V2.php)['url'];

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R'));

?>

<style>
th,td{
	color : #000;
}
table, tr, td {
    border: 1px solid black;
	text-align:center;
	color:black;
}
table th
{
	text-align:center;	
	color:black;
}

</style>

	
</head>
<?php
if(isset($_POST['submit']))
{
	$from_date=$_POST['from_date'];
}
?>
<body>
<div class="panel panel-primary">
	<div class="panel-heading">Hourly Cutting Production Report</div>
	<div class="panel-body">
		<form method="post" class="form-inline" name="input" action="index.php?r=<?php echo $_GET['r']; ?>">
			<div class="form-group">
				<label for="date">Enter Date:</label>
				<input type="text" data-toggle="datepicker" id="from_date" class="form-control" name="from_date" size=12 value="<?php if($from_date=="") {echo  date("Y-m-d"); } else {echo $from_date;}?>"> 
			</div>
			<button type="submit" name="submit" class="btn btn-primary">Show</button>
		</form>
	
<?php

if(isset($_POST['submit']))
{
$from_date=$_POST['from_date'];
/*
$from_time = strtotime("2015-01-01 07:30:00");
echo '7.30 --------- '.round(abs($from_time) / 60,2). " minute<br>";

$from_time1 = strtotime("2015-01-01 8.30:59");
echo '8.30.59 --------- '.round(abs($from_time1) / 60,2). " minute<br>";

$from_time2 = strtotime("2015-01-01 8.31:00");
echo '8.31 ----------- '.round(abs($from_time2) / 60,2). " minute<br>";

$from_time3 = strtotime("2015-01-01 9.30:59");
echo '9.30.59 ----------- '.round(abs($from_time3) / 60,2). " minute<br>";

$from_time4 = strtotime("2015-01-01 9.31:00");
echo '9.31 ------------- '.round(abs($from_time4) / 60,2). " minute<br>";

$from_time5 = strtotime("2015-01-01 10.30:59");
echo '10.30.59 ------------- '.round(abs($from_time5) / 60,2). " minute<br>";

$from_time6 = strtotime("2015-01-01 10.31:00");
echo '10.31 ---------- '.round(abs($from_time6) / 60,2). " minute<br>";

$from_time7 = strtotime("2015-01-01 11.30:59");
echo '11.30.59 ------------- '.round(abs($from_time7) / 60,2). " minute<br>";

$from_time8 = strtotime("2015-01-01 11.31:00");
echo '11.31 ------------ '.round(abs($from_time8) / 60,2). " minute<br>";

$from_time9 = strtotime("2015-01-01 12.30:59");
echo '12.30.59 -------------- '.round(abs($from_time9) / 60,2). " minute<br>";

$from_time10 = strtotime("2015-01-01 12.31:00");
echo '12.31 --------- '.round(abs($from_time10) / 60,2). " minute<br>";


$from_time11 = strtotime("2015-01-01 13.30:59");
echo '13.30.59 ------------ '.round(abs($from_time11) / 60,2). " minute<br>";

$from_time12 = strtotime("2015-01-01 13.31:00");
echo '13.31 ------------- '.round(abs($from_time12) / 60,2). " minute<br>";

$from_time13 = strtotime("2015-01-01 14.30:59");
echo '14.30.59 ------------ '.round(abs($from_time13) / 60,2). " minute<br>";

$from_time14 = strtotime("2015-01-01 14.31:00");
echo '14.31 ------------- '.round(abs($from_time14) / 60,2). " minute<br>";

$from_time15 = strtotime("2015-01-01 15.30:59");
echo '15.30.59 ------------- '.round(abs($from_time15) / 60,2). " minute<br>";

$from_time16 = strtotime("2015-01-01 15.31:00");
echo '15.31 --------------'.round(abs($from_time16) / 60,2). " minute<br>";

$from_time17 = strtotime("2015-01-01 16.30:59");
echo '16.30.59 -------------- '.round(abs($from_time17) / 60,2). " minute<br>";

$from_time18 = strtotime("2015-01-01 16.31:00");
echo '16.31 -------------- '.round(abs($from_time18) / 60,2). " minute<br>";

$from_time19 = strtotime("2015-01-01 17.30:59");
echo '17.30.59 ------------- '.round(abs($from_time19) / 60,2). " minute<br>";

$from_time20 = strtotime("2015-01-01 17.31:00");
echo '17.31 ----------- '.round(abs($from_time20) / 60,2). " minute<br>";

$from_time21 = strtotime("2015-01-01 18.30:59");
echo '18.30.59 ------------ '.round(abs($from_time21) / 60,2). " minute<br>";

$from_time22= strtotime("2015-01-01 18.31:00");
echo '18.31 ------------- '.round(abs($from_time22) / 60,2). " minute<br>";

$from_time23= strtotime("2015-01-01 19.30:59");
echo '19.30.59 ------------- '.round(abs($from_time23) / 60,2). " minute<br>";

*/
		?>
		<div class="panel panel-info">
			<div class="panel-heading"><center><h4><strong>Hourly Cutting Production Report - <?php echo $from_date;?></strong></h4></center></div>
			<div class="panel-body">
		<?php
		echo "<table class='table table-hover'><tr class='danger'><th rowspan=2>Section</th><th colspan=11>Time</th><th rowspan=2>Cut Qty</th><th rowspan=2>Yards</th><th rowspan=2># of Docket</th></tr>";
		//echo "";
		echo "<tr class='warning'><th>8.30 am</th><th>9.30 am</th><th>10.30 am</th><th>11.30 am</th><th>12.30 pm</th><th>1.30 pm</th><th>2.30 pm</th><th>3.30 pm</th><th>4.30 pm</th><th>5.30 pm</th><th>6.30 pm</th></tr>";
		$no_of_doc=$grand_tot_no_of_doc=0;
		$tot_cut_qty=$grand_tot_cut_qty=0;
		
		$h8=$h9=$h10=$h11=$h12=$h1=$h2=$h3=$h4=$h5=$h6=$yards=$tot_yards=0;
		$sql2="SELECT * FROM $bai_pro3.cut_dept_report WHERE DATE= \"$from_date\" and section=1";
		//echo $sql2;
		// mysqli_query($link, $sql2) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$doc_ref_no=$sql_row2['doc_no'];
			$no_of_doc++;
			$section=$sql_row2['section'];
			$category=$sql_row2['category'];
			if($category=="Body") { $tot_cut_qty=$tot_cut_qty+$sql_row2['tot_cut_qty']; }
			//$remarks=$sql_row2['remarks'];
			$fab_received=$sql_row2['fab_received'];
			$damages=$sql_row2['damages'];
			$shortages=$sql_row2['shortages'];
			$yards=$yards+($fab_received-($damages+$shortages));
			//$tot_cut_qty=$sql_row2['tot_cut_qty'];
			$log_time=$sql_row2['log_time'];
			
			$start_time = $sql_row2['log_time'];
			$log_time1 = strtotime("2015-01-01 ". $start_time);
			$log_time= round(abs($log_time1) / 60,2)."<br>";
			
			//7.30am to 8.30.59am
			if($log_time>"23667960" and $log_time<="23668020.98")   
			{
				if($category=="Body") { $h8=$h8+$sql_row2['tot_cut_qty']; }
			}
			//8.31.00am to 9.30.59am
			else if($log_time>"23668021" and $log_time<="23668080.98")
			{
				if($category=="Body") { $h9=$h9+$sql_row2['tot_cut_qty']; }
			}
			//9.31.00am to 10.30.59am
			else if($log_time>"23668081" and $log_time<="23668140.98")
			{
				if($category=="Body") { $h10=$h10+$sql_row2['tot_cut_qty']; }
			}
			//10.31.00am to 11.30.59am
			else if($log_time>"23668141" and $log_time<="23668200.98")
			{
				if($category=="Body") { $h11=$h11+$sql_row2['tot_cut_qty']; }
			}
			//11.31.00am to 12.30.59am
			else if($log_time>"23668201" and $log_time<="23668260.98")
			{
				if($category=="Body") { $h12=$h12+$sql_row2['tot_cut_qty']; }
			}
			//12.31.00am to 1.30.59am
			else if($log_time>"23668261" and $log_time<="23668320.98 ")
			{
				if($category=="Body") { $h1=$h1+$sql_row2['tot_cut_qty']; }
			}
			//1.31.00pm to 2.30.59pm
			else if($log_time>"23668321" and $log_time<="23668380.98")
			{
				if($category=="Body") { $h2=$h2+$sql_row2['tot_cut_qty']; }
			}
			//2.31.00pm to 3.30.59pm
			else if($log_time>"23668381" and $log_time<="23668440.98")
			{
				if($category=="Body") { $h3=$h3+$sql_row2['tot_cut_qty']; }
			}
			//3.31.00pm to 4.30.59pm
			else if($log_time>"23668441" and $log_time<="23668500.98")
			{
				if($category=="Body") { $h4=$h4+$sql_row2['tot_cut_qty']; }
			}
			//4.31.00pm to 5.30.59pm
			else if($log_time>"23668501" and $log_time<="23668560.98")
			{
				if($category=="Body") { $h5=$h5+$sql_row2['tot_cut_qty']; }
			}
			//5.31.00pm to 6.30.59pm
			else if($log_time>"23668561" and $log_time<="23668620.98")
			{
				if($category=="Body") { $h6=$h6+$sql_row2['tot_cut_qty']; }
			}
			//6.31.00pm to 7.30.59pm
			else if($log_time>"23668621" and $log_time<="23668680.98")
			{
				if($category=="Body") { $h7=$h7+$sql_row2['tot_cut_qty']; }
			}
			
		//echo "<tr><td>$section</td><td>$h8</td><td>9.30 am</td><td>10.30 am</td><td>11.30 am</td><td>12.30 am</td><td>1.30 pm</td><td>2.30 pm</td><td>3.30 pm</td><td>4.30 pm</td><td>5.30 pm</td><td>6.30 pm</td><td>$tot_cut_qty</td><td>$no_of_doc</td></tr>";

		}
		echo "<tr><td>A</td><td>$h8</td><td>$h9</td><td>$h10</td><td>$h11</td><td>$h12</td><td>$h1</td><td>$h2</td><td>$h3</td><td>$h4</td><td>$h5</td><td>$h6</td><td>$tot_cut_qty</td><td>$yards</td><td>$no_of_doc</td></tr>";
		$grand_tot_cut_qty=$grand_tot_cut_qty+$tot_cut_qty;
		$grand_tot_no_of_doc=$grand_tot_no_of_doc+$no_of_doc;
		$tot_yards=$tot_yards+$yards;
		
		$no_of_doc=0;
		$tot_cut_qty=0;
		$h8=$h9=$h10=$h11=$h12=$h1=$h2=$h3=$h4=$h5=$h6=$yards=0;
		$sql2="SELECT * FROM $bai_pro3.cut_dept_report WHERE DATE= \"$from_date\" and section=2";
		//echo $sql2;
		mysqli_query($link, $sql2) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$doc_ref_no=$sql_row2['doc_no'];
			$no_of_doc++;
			$section=$sql_row2['section'];
			$category=$sql_row2['category'];
			if($category=="Body") { $tot_cut_qty=$tot_cut_qty+$sql_row2['tot_cut_qty']; }
			//$remarks=$sql_row2['remarks'];
			$fab_received=$sql_row2['fab_received'];
			$damages=$sql_row2['damages'];
			$shortages=$sql_row2['shortages'];
			$yards=$yards+($fab_received-($damages+$shortages));
			//$tot_cut_qty=$sql_row2['tot_cut_qty'];
			$log_time=$sql_row2['log_time'];
			
			$start_time = $sql_row2['log_time'];
			$log_time1 = strtotime("2015-01-01 ". $start_time);
			$log_time= round(abs($log_time1) / 60,2)."<br>";
			
			//7.30am to 8.30.59am
			if($log_time>"23667960" and $log_time<="23668020.98")   
			{
				if($category=="Body") { $h8=$h8+$sql_row2['tot_cut_qty']; }
			}
			//8.31.00am to 9.30.59am
			else if($log_time>"23668021" and $log_time<="23668080.98")
			{
				if($category=="Body") { $h9=$h9+$sql_row2['tot_cut_qty']; }
			}
			//9.31.00am to 10.30.59am
			else if($log_time>"23668081" and $log_time<="23668140.98")
			{
				if($category=="Body") { $h10=$h10+$sql_row2['tot_cut_qty']; }
			}
			//10.31.00am to 11.30.59am
			else if($log_time>"23668141" and $log_time<="23668200.98")
			{
				if($category=="Body") { $h11=$h11+$sql_row2['tot_cut_qty']; }
			}
			//11.31.00am to 12.30.59am
			else if($log_time>"23668201" and $log_time<="23668260.98")
			{
				if($category=="Body") { $h12=$h12+$sql_row2['tot_cut_qty']; }
			}
			//12.31.00am to 1.30.59am
			else if($log_time>"23668261" and $log_time<="23668320.98 ")
			{
				if($category=="Body") { $h1=$h1+$sql_row2['tot_cut_qty']; }
			}
			//1.31.00pm to 2.30.59pm
			else if($log_time>"23668321" and $log_time<="23668380.98")
			{
				if($category=="Body") { $h2=$h2+$sql_row2['tot_cut_qty']; }
			}
			//2.31.00pm to 3.30.59pm
			else if($log_time>"23668381" and $log_time<="23668440.98")
			{
				if($category=="Body") { $h3=$h3+$sql_row2['tot_cut_qty']; }
			}
			//3.31.00pm to 4.30.59pm
			else if($log_time>"23668441" and $log_time<="23668500.98")
			{
				if($category=="Body") { $h4=$h4+$sql_row2['tot_cut_qty']; }
			}
			//4.31.00pm to 5.30.59pm
			else if($log_time>"23668501" and $log_time<="23668560.98")
			{
				if($category=="Body") { $h5=$h5+$sql_row2['tot_cut_qty']; }
			}
			//5.31.00pm to 6.30.59pm
			else if($log_time>"23668561" and $log_time<="23668620.98")
			{
				if($category=="Body") { $h6=$h6+$sql_row2['tot_cut_qty']; }
			}
			//6.31.00pm to 7.30.59pm
			else if($log_time>"23668621" and $log_time<="23668680.98")
			{
				if($category=="Body") { $h7=$h7+$sql_row2['tot_cut_qty']; }
			}
			
		//echo "<tr><td>$section</td><td>$h8</td><td>9.30 am</td><td>10.30 am</td><td>11.30 am</td><td>12.30 am</td><td>1.30 pm</td><td>2.30 pm</td><td>3.30 pm</td><td>4.30 pm</td><td>5.30 pm</td><td>6.30 pm</td><td>$tot_cut_qty</td><td>$no_of_doc</td></tr>";

		}
		echo "<tr><td>B</td><td>$h8</td><td>$h9</td><td>$h10</td><td>$h11</td><td>$h12</td><td>$h1</td><td>$h2</td><td>$h3</td><td>$h4</td><td>$h5</td><td>$h6</td><td>$tot_cut_qty</td><td>$yards</td><td>$no_of_doc</td></tr>";
		$grand_tot_cut_qty=$grand_tot_cut_qty+$tot_cut_qty;
		$grand_tot_no_of_doc=$grand_tot_no_of_doc+$no_of_doc;
		$tot_yards=$tot_yards+$yards;
		
		$no_of_doc=0;
		$tot_cut_qty=0;
		$h8=$h9=$h10=$h11=$h12=$h1=$h2=$h3=$h4=$h5=$h6=$yards=0;
		$sql2="SELECT * FROM $bai_pro3.cut_dept_report WHERE DATE= \"$from_date\" and section=3";
		//echo $sql2;
		mysqli_query($link, $sql2) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$doc_ref_no=$sql_row2['doc_no'];
			$no_of_doc++;
			$section=$sql_row2['section'];
			$category=$sql_row2['category'];
			if($category=="Body") { $tot_cut_qty=$tot_cut_qty+$sql_row2['tot_cut_qty']; }
			//$remarks=$sql_row2['remarks'];
			$fab_received=$sql_row2['fab_received'];
			$damages=$sql_row2['damages'];
			$shortages=$sql_row2['shortages'];
			$yards=$yards+($fab_received-($damages+$shortages));
			//$tot_cut_qty=$sql_row2['tot_cut_qty'];
			$log_time=$sql_row2['log_time'];
			//echo $log_time."<br>";
			
			$start_time = $sql_row2['log_time'];
			$log_time1 = strtotime("2015-01-01 ". $start_time);
			$log_time= round(abs($log_time1) / 60,2)."<br>";
			

			
			//7.30am to 8.30.59am
			if($log_time>"23667960" and $log_time<="23668020.98")   
			{
				if($category=="Body") { $h8=$h8+$sql_row2['tot_cut_qty']; }
			}
			//8.31.00am to 9.30.59am
			else if($log_time>"23668021" and $log_time<="23668080.98")
			{
				if($category=="Body") { $h9=$h9+$sql_row2['tot_cut_qty']; }
			}
			//9.31.00am to 10.30.59am
			else if($log_time>"23668081" and $log_time<="23668140.98")
			{
				if($category=="Body") { $h10=$h10+$sql_row2['tot_cut_qty']; }
			}
			//10.31.00am to 11.30.59am
			else if($log_time>"23668141" and $log_time<="23668200.98")
			{
				if($category=="Body") { $h11=$h11+$sql_row2['tot_cut_qty']; }
			}
			//11.31.00am to 12.30.59am
			else if($log_time>"23668201" and $log_time<="23668260.98")
			{
				if($category=="Body") { $h12=$h12+$sql_row2['tot_cut_qty']; }
			}
			//12.31.00am to 1.30.59am
			else if($log_time>"23668261" and $log_time<="23668320.98 ")
			{
				if($category=="Body") { $h1=$h1+$sql_row2['tot_cut_qty']; }
			}
			//1.31.00pm to 2.30.59pm
			else if($log_time>"23668321" and $log_time<="23668380.98")
			{
				if($category=="Body") { $h2=$h2+$sql_row2['tot_cut_qty']; }
			}
			//2.31.00pm to 3.30.59pm
			else if($log_time>"23668381" and $log_time<="23668440.98")
			{
				if($category=="Body") { $h3=$h3+$sql_row2['tot_cut_qty']; }
			}
			//3.31.00pm to 4.30.59pm
			else if($log_time>"23668441" and $log_time<="23668500.98")
			{
				if($category=="Body") { $h4=$h4+$sql_row2['tot_cut_qty']; }
			}
			//4.31.00pm to 5.30.59pm
			else if($log_time>"23668501" and $log_time<="23668560.98")
			{
				if($category=="Body") { $h5=$h5+$sql_row2['tot_cut_qty']; }
			}
			//5.31.00pm to 6.30.59pm
			else if($log_time>"23668561" and $log_time<="23668620.98")
			{
				if($category=="Body") { $h6=$h6+$sql_row2['tot_cut_qty']; }
			}
			//6.31.00pm to 7.30.59pm
			else if($log_time>"23668621" and $log_time<="23668680.98")
			{
				if($category=="Body") { $h7=$h7+$sql_row2['tot_cut_qty']; }
			}
			
		//echo "<tr><td>$section</td><td>$h8</td><td>9.30 am</td><td>10.30 am</td><td>11.30 am</td><td>12.30 am</td><td>1.30 pm</td><td>2.30 pm</td><td>3.30 pm</td><td>4.30 pm</td><td>5.30 pm</td><td>6.30 pm</td><td>$tot_cut_qty</td><td>$no_of_doc</td></tr>";

		}
		echo "<tr><td>C</td><td>$h8</td><td>$h9</td><td>$h10</td><td>$h11</td><td>$h12</td><td>$h1</td><td>$h2</td><td>$h3</td><td>$h4</td><td>$h5</td><td>$h6</td><td>$tot_cut_qty</td><td>$yards</td><td>$no_of_doc</td></tr>";
		$grand_tot_cut_qty=$grand_tot_cut_qty+$tot_cut_qty;
		$grand_tot_no_of_doc=$grand_tot_no_of_doc+$no_of_doc;
		$tot_yards=$tot_yards+$yards;
		
		$no_of_doc=0;
		$tot_cut_qty=0;
		$h8=$h9=$h10=$h11=$h12=$h1=$h2=$h3=$h4=$h5=$h6=$yards=0;
		$sql2="SELECT * FROM $bai_pro3.cut_dept_report WHERE DATE= \"$from_date\" and section=4";
		//echo $sql2;
		mysqli_query($link, $sql2) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$doc_ref_no=$sql_row2['doc_no'];
			$no_of_doc++;
			$section=$sql_row2['section'];
			$category=$sql_row2['category'];
			if($category=="Body") { $tot_cut_qty=$tot_cut_qty+$sql_row2['tot_cut_qty']; }
			//$remarks=$sql_row2['remarks'];
			$fab_received=$sql_row2['fab_received'];
			$damages=$sql_row2['damages'];
			$shortages=$sql_row2['shortages'];
			$yards=$yards+($fab_received-($damages+$shortages));
			//$tot_cut_qty=$sql_row2['tot_cut_qty'];
			$log_time=$sql_row2['log_time'];
			
			$start_time = $sql_row2['log_time'];
			$log_time1 = strtotime("2015-01-01 ". $start_time);
			$log_time= round(abs($log_time1) / 60,2)."<br>";
			
			
			
			//7.30am to 8.30.59am
			if($log_time>"23667960" and $log_time<="23668020.98")   
			{
				if($category=="Body") { $h8=$h8+$sql_row2['tot_cut_qty']; }
			}
			//8.31.00am to 9.30.59am
			else if($log_time>"23668021" and $log_time<="23668080.98")
			{
				if($category=="Body") { $h9=$h9+$sql_row2['tot_cut_qty']; }
			}
			//9.31.00am to 10.30.59am
			else if($log_time>"23668081" and $log_time<="23668140.98")
			{
				if($category=="Body") { $h10=$h10+$sql_row2['tot_cut_qty']; }
			}
			//10.31.00am to 11.30.59am
			else if($log_time>"23668141" and $log_time<="23668200.98")
			{
				if($category=="Body") { $h11=$h11+$sql_row2['tot_cut_qty']; }
			}
			//11.31.00am to 12.30.59am
			else if($log_time>"23668201" and $log_time<="23668260.98")
			{
				if($category=="Body") { $h12=$h12+$sql_row2['tot_cut_qty']; }
			}
			//12.31.00am to 1.30.59am
			else if($log_time>"23668261" and $log_time<="23668320.98 ")
			{
				if($category=="Body") { $h1=$h1+$sql_row2['tot_cut_qty']; }
			}
			//1.31.00pm to 2.30.59pm
			else if($log_time>"23668321" and $log_time<="23668380.98")
			{
				if($category=="Body") { $h2=$h2+$sql_row2['tot_cut_qty']; }
			}
			//2.31.00pm to 3.30.59pm
			else if($log_time>"23668381" and $log_time<="23668440.98")
			{
				if($category=="Body") { $h3=$h3+$sql_row2['tot_cut_qty']; }
			}
			//3.31.00pm to 4.30.59pm
			else if($log_time>"23668441" and $log_time<="23668500.98")
			{
				if($category=="Body") { $h4=$h4+$sql_row2['tot_cut_qty']; }
			}
			//4.31.00pm to 5.30.59pm
			else if($log_time>"23668501" and $log_time<="23668560.98")
			{
				if($category=="Body") { $h5=$h5+$sql_row2['tot_cut_qty']; }
			}
			//5.31.00pm to 6.30.59pm
			else if($log_time>"23668561" and $log_time<="23668620.98")
			{
				if($category=="Body") { $h6=$h6+$sql_row2['tot_cut_qty']; }
			}
			//6.31.00pm to 7.30.59pm
			else if($log_time>"23668621" and $log_time<="23668680.98")
			{
				if($category=="Body") { $h7=$h7+$sql_row2['tot_cut_qty']; }
			}
			
		//echo "<tr><td>$section</td><td>$h8</td><td>9.30 am</td><td>10.30 am</td><td>11.30 am</td><td>12.30 am</td><td>1.30 pm</td><td>2.30 pm</td><td>3.30 pm</td><td>4.30 pm</td><td>5.30 pm</td><td>6.30 pm</td><td>$tot_cut_qty</td><td>$no_of_doc</td></tr>";

		}
		echo "<tr><td>D</td><td>$h8</td><td>$h9</td><td>$h10</td><td>$h11</td><td>$h12</td><td>$h1</td><td>$h2</td><td>$h3</td><td>$h4</td><td>$h5</td><td>$h6</td><td>$tot_cut_qty</td><td>$yards</td><td>$no_of_doc</td></tr>";
		$grand_tot_cut_qty=$grand_tot_cut_qty+$tot_cut_qty;
		$grand_tot_no_of_doc=$grand_tot_no_of_doc+$no_of_doc;
		$tot_yards=$tot_yards+$yards;
		
		echo "<tr><th colspan=12></th><th>$grand_tot_cut_qty</th><th>$tot_yards</th><th>$grand_tot_no_of_doc</th></tr>";

		echo "</table>
		</div>";
		}
		?>
			</div>
		</div>
	</div>
</div>

</body>

</html>

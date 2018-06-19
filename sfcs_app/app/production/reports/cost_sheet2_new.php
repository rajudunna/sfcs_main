
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
 
$view_access=user_acl("SFCS_0071",$username,1,$group_id_sfcs); 
?>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R'); ?>"></script>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		
		
		
		<script type="text/javascript" src="<?= getFullURL($_GET['r'],'common/js/highcharts.js',1,'R'); ?>"></script>
		


<style>
.borderless td, .borderless th,.borderless tr {
    border: none;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
	border-top: 0px;
}
</style>
<script>
	function verify(e){
    var date1 = document.getElementById('demo1').value;
       var date2 = document.getElementById('demo2').value;
       if(date1 > date2){
          sweetAlert('Start Date Should  be less than End Date','','warning');
    e.preventDefault();
      }
       var style = document.getElementById('sty').value;
       var btn = document.getElementById('sub');
       if(style == 0){
          sweetAlert('Please select Style','','warning');
          btn.disabled = true;
       }else{
       	  btn.disabled = false;
       }
       
	}
</script>	


<body  >
<div class="panel panel-primary">
<div class="panel-heading">Style Downtime</div>
<div class="panel-body">
<!--<div id="page_heading"><span style="float:"><h3>Style wise by Department Downtime Report</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>-->

<form method="POST" action="<?php echo getFullURL($_GET['r'],'cost_sheet2_new.php','N');?>">

<div class="row">
<div class="col-md-3">
<label>Start Date: </label><input id="demo1" class="form-control" data-toggle="datepicker" type="text" size="8" name="dat" value=<?php echo date("Y-m-d"); ?>>
</div>
<div class="col-md-3">
<label>End Date: </label><input id="demo2" class="form-control" data-toggle="datepicker" type="text" size="8" name="dat2" value=<?php echo date("Y-m-d"); ?>>
</div>
<div class="col-md-3">
<label>Style Code: </label>
<?php

echo "<select name=\"style\" id='sty' onchange='verify(event)' class='form-control'>";
echo "<option value='0'>Select</option>";
$sql2="select distinct style from $bai_pro.pro_style where style in(SELECT DISTINCT style FROM $bai_pro.down_log where style<>'')";
//mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

while($sql_row2=mysqli_fetch_array($sql_result2))
{
	echo "<option value=\"".$sql_row2['style']."\">".$sql_row2['style']."</option>";

}		
if(isset($_POST['style'])){
	echo "<option value=".$_POST['style']." selected>".$_POST['style']."</option>";
}
echo "</select>";

?>
</div>
<div class="col-md-3">
<input type=submit name="submit" id='sub' disabled onclick='verify(event)' class="btn btn-primary" value="Show" style="margin-top:22px;">
</div>
</div>

</form>
<?php


if(isset($_POST['submit']))
{ 
	
	    $sdate=$_POST['dat'];
		$edate=$_POST['dat2'];
		$style=$_POST['style'];



	//echo "<alert class='alert alert-info'>For the period: ".$sdate." to ".$edate.'</alert>';

echo "<hr/><div class=\"table-responsive\"><table class='table borderless'><tr><td>";
		echo "<table class=\"table table-bordered\" >";

		echo "<tr><th style='background-color:#337ab7;color:#FFF'><center>Department ID</center></th><th style='background-color:#337ab7;color:#FFF'><center>Department</center></th><th style='background-color:#337ab7;color:#FFF'><center>Shift A</center></th><th style='background-color:#337ab7;color:#FFF'><center>Shift B</center></th><th style='background-color:#337ab7;color:#FFF'><center>Total HRS</center></th></tr>";
		
		$sql="select dep_id, dep_name from $bai_pro.down_deps order by dep_id";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$dep_id=$sql_row['dep_id'];
			$dep_name=$sql_row['dep_name'];

			echo "<tr><td>".$dep_id."</td><td>".$dep_name."</td>";
			
			$sql2="select (sum(dtime)/60) as \"dtime\" from $bai_pro.down_log where department=$dep_id and shift=\"A\" and style=\"$style\" and date between \"$sdate\" and \"$edate\"";
			//echo $sql2.";</br>";
            mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				echo "<td>".round($sql_row2['dtime'],2)."</td>";
			}

			$sql2="select (sum(dtime)/60) as \"dtime\" from $bai_pro.down_log where department=$dep_id and shift=\"B\" and style=\"$style\" and date between \"$sdate\" and \"$edate\"";
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				echo "<td>".round($sql_row2['dtime'],2)."</td>";
			}

			$sql2="select (sum(dtime)/60) as \"dtime\" from $bai_pro.down_log where department=$dep_id and style=\"$style\" and date between \"$sdate\" and \"$edate\"";
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				echo "<td>".round($sql_row2['dtime'],2)."</td></tr>";
			}

		}

		echo "<tr class=\"total\"><td colspan=2>Total</td>";

		$sql="select (sum(dtime)/60) as \"dtime\" from $bai_pro.down_log where shift=\"A\" and style=\"$style\" and date between \"$sdate\" and \"$edate\"";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			echo "<td>".round($sql_row['dtime'],2)."</td>";
		}

		$sql="select (sum(dtime)/60) as \"dtime\" from $bai_pro.down_log where shift=\"B\" and style=\"$style\" and date between \"$sdate\" and \"$edate\"";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			echo "<td>".round($sql_row['dtime'],2)."</td>";
		}

		$sql="select (sum(dtime)/60) as \"dtime\" from $bai_pro.down_log where style=\"$style\" and date between \"$sdate\" and \"$edate\"";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			echo "<td>".round($sql_row['dtime'],2)."</td>";
		}
		echo "</tr></table>";

		
 




echo "</td><td>";


		echo "<script type=\"text/javascript\">
		$(document)"."."."ready(function() {
			var chart = new Highcharts"."."."Chart({
				chart: {
					renderTo: \"container\",
					defaultSeriesType: \"bar\"
				},

				title: {
					text: \"Department Level DOWNTIME Chart\"
				},
				subtitle: {
					text: \"Source: IE Department\"
				},
				xAxis: {
					categories: [";

		$sql="select dep_id, dep_name from $bai_pro.down_deps order by dep_id";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$dep_id=$sql_row['dep_id'];
			$dep_name=$sql_row['dep_name'];
			echo "\"".$dep_id."\",";
		}



echo "],
					title: {
						text: \"Month\"
					}
				},
				yAxis: {
					title: {
						text: \"OFF STD"."."." HOURS \"
					}
				},
				legend: {
					layout: \"vertical\",
					backgroundColor: \"#FFFFFF\",
					style: {
						left: \"auto\",
						top: \"100px\",
						right: \"100px\",
						bottom: \"auto\"
					}
				},

				tooltip: {
					enabled: false,
					formatter: function() {
						return \"<b>\"+ this"."."."series"."."."name +\"</b><br/>\"+
							this"."."."x +\": \"+ this"."."."y +\"�C\";
					}
				},
				plotOptions: {
					line: {
						dataLabels: {
							enabled: true
						}
					}
				},
				series: [{

					name: \"SHIFT-A\",
					data: ["; 

		$sql="select dep_id, dep_name from $bai_pro.down_deps order by dep_id";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$dep_id=$sql_row['dep_id'];
			$dep_name=$sql_row['dep_name'];


			$sql2="select (sum(dtime)/60) as \"dtime\" from $bai_pro.down_log where department=$dep_id and shift=\"A\" and style=\"$style\" and date between 			\"$sdate\" and \"$edate\"";
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				echo round($sql_row2['dtime'],2).",";
			}
		}


echo "]
				}, {
					name: \"SHIFT-B\",
					data: [";




		$sql="select dep_id, dep_name from $bai_pro.down_deps order by dep_id";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$dep_id=$sql_row['dep_id'];
			$dep_name=$sql_row['dep_name'];


			$sql2="select (sum(dtime)/60) as \"dtime\" from $bai_pro.down_log where department=$dep_id and shift=\"B\" and style=\"$style\" and date between 			\"$sdate\" and \"$edate\"";
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				echo round($sql_row2['dtime'],2).",";
			}
		}


echo "]
				}, {
					name: \"Total\",
					data: [";




		$sql="select dep_id, dep_name from $bai_pro.down_deps order by dep_id";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$dep_id=$sql_row['dep_id'];
			$dep_name=$sql_row['dep_name'];


			$sql2="select (sum(dtime)/60) as \"dtime\" from $bai_pro.down_log where department=$dep_id and style=\"$style\" and date between \"$sdate\" and \"$edate\"";
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				echo round($sql_row2['dtime'],2).",";
			}
		}


echo"]
				}]
			});
			
			
		});
		</script>";




}


?>
</td><td>
<div id="container" style="width: 800px; height: 700px; margin: 0 auto"></div>
</td></tr></table></div>
</div></div>
</body>

<?php ((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res); ?>


<?php 
    include("..".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include("..".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
//$view_access=user_acl("SFCS_0064",$username,1,$group_id_sfcs);//1
?>
	<title>First Hour Output</title>
	<style>
		#ad{
			padding-top:220px;
			padding-left:10px;
		}
		
		body
		{
			font-size:12px;
		}
		
		.report tr
		{
			border: 1px solid black;
			text-align: right;
			white-space:nowrap; 
		}
		
		.report td
		{
			border: 1px solid black;
			text-align: right;
			white-space:nowrap; 
		}
		
		.report th
		{
			border: 1px solid black;
			text-align: center;
		    background-color: BLUE;
			color: WHITE;
			white-space:nowrap; 
			padding-left: 5px;
			padding-right: 5px;
			font-size: 14px;
		}
		
		.report {
			white-space:nowrap; 
			border-collapse:collapse;
			font-size:12px;
		}

	</style>

<!---<div id="page_heading"><span style="float:"><h3>First Hour Production Report</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>--->
<div class="panel panel-primary">
<div class="panel-heading">First Hour Production Report</div>
<div class="panel-body">

<form name="test" method="post" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>">
<div class='col-md-3 col-sm-3 col-xs-12'>
From Date: <input type="text" data-toggle="datepicker" name="fdate" id="dat1" size="8" class="form-control" value="<?php  if(isset($_POST['fdate'])) { echo $_POST['fdate']; } else { echo date("Y-m-d"); } ?>" onclick="displayCalendar(document.test.fdate,'yyyy-mm-dd',this)">
</div>
<div class='col-md-3 col-sm-3 col-xs-12'> 
 To Date: <input type="text" data-toggle="datepicker" name="tdate" id="dat2"size="8" class="form-control" value="<?php  if(isset($_POST['tdate'])) { echo $_POST['tdate']; } else { echo date("Y-m-d"); } ?>" onclick="displayCalendar(document.test.tdate,'yyyy-mm-dd',this)">
</div>
<!--<input type="submit" name="submit" value="Show">-->

<?php

echo "<input type=\"submit\" value=\"Show\" name=\"submit\" id=\"submit\" onclick =\"return verify_date()\" style=\"margin-top: 17px;\" class=\"btn btn-success\" onclick=\"document.getElementById('submit').style.display='none'; document.getElementById('msg1').style.display='';\"/>";

?>
</form>


<?php

if(isset($_POST['submit']))
{
	// include("../dbconf.php");
	
	//Responsible Persons Text-Database Reference
	{
		$resp_list['1A']="Shiva";
		$resp_list['2A']="Hyma";
		$resp_list['3A']="Anil";
		$resp_list['4A']="Shyam";
		$resp_list['5A']="Senavi";
		$resp_list['6A']="Vara";
		$resp_list['7A']="Madhavi";
		$resp_list['8A']="Indika";
		$resp_list['9A']="Malkanthi";
		$resp_list['10A']="Umar";
		$resp_list['12A']="Poornima";
		$resp_list['13A']="Devi";
		$resp_list['14A']="Kusuma";
		$resp_list['15A']="Ganesh";
		$resp_list['16A']="Swathi";
		$resp_list['17A']="Venu";
		$resp_list['18A']="Prasad";
		$resp_list['19A']="Naidu";
		$resp_list['20A']="Suba";
		$resp_list['21A']="Rajesh";
		$resp_list['22A']="Rama Rao";
		$resp_list['23A']="Hari";
		$resp_list['24A']="Maha";
		$resp_list['25A']="Santhosh";
		$resp_list['26A']="Kranthi";
		$resp_list['27A']="Vara";
		$resp_list['28A']="Anand";
		$resp_list['29A']="Babuji";
		$resp_list['30A']="Suresh";
		$resp_list['31A']="Raj ";
		$resp_list['32A']="Ruwan";
		$resp_list['33A']="Kanaka";
		$resp_list['34A']="Kala";
		$resp_list['35A']="Ajith";
		$resp_list['36A']="Lalitha";
		$resp_list['37A']="Ganesh";
		$resp_list['38A']="Aravind";
		$resp_list['39A']="Sathish";
		$resp_list['40A']="Rama & Roy";
		$resp_list['41A']="Dimantha";
		$resp_list['42A']="Laxman";
		$resp_list['43A']="Srikanth";
		$resp_list['44A']="Gowrish & Ruwan";
		$resp_list['45A']="Madhu";
		$resp_list['46A']="Swaraj";
		$resp_list['47A']="Srinu";
		$resp_list['48A']="Santhoshi";
		$resp_list['61A']="Gayan";
		$resp_list['64A']="Gayan";
		$resp_list['49A']="Uma ";
		$resp_list['50A']="Pushpa";
		$resp_list['51A']="Shoba Rani";
		$resp_list['52A']="Srinivas";
		$resp_list['53A']="Jeewantha";
		$resp_list['55A']="Sasi";
		$resp_list['56A']="Santhosh";
		$resp_list['57A']="Adhi Lakshmi";
		$resp_list['58A']="Revathi";
		$resp_list['59A']="Deepthi";
		$resp_list['60A']="Prasad";
		$resp_list['62A']="Raja";
		$resp_list['63A']="Sanyasi Rao";
		$resp_list['65A']="Ramesh";
		$resp_list['66A']="Lalith ";
		$resp_list['67A']="Vara";
		$resp_list['68A']="Koti";
		$resp_list['69A']="Shekar";
		$resp_list['70A']="Nirmala";
		$resp_list['71A']="Mahesh";
		$resp_list['72A']="Shyam";
		$resp_list['1B']="Chakri";
		$resp_list['2B']="Devi";
		$resp_list['3B']="Ramesh";
		$resp_list['4B']="Kumar";
		$resp_list['5B']="Sirisha";
		$resp_list['6B']="Naidu";
		$resp_list['7B']="Shekar";
		$resp_list['8B']="Lokesh";
		$resp_list['9B']="Sujith";
		$resp_list['10B']="Hema";
		$resp_list['12B']="Nalaka";
		$resp_list['13B']="Srinu";
		$resp_list['14B']="Srinivas";
		$resp_list['15B']="Vamsi";
		$resp_list['16B']="Satya";
		$resp_list['17B']="Susila";
		$resp_list['18B']="Gowri";
		$resp_list['19B']="Naveena";
		$resp_list['20B']="Chandra";
		$resp_list['21B']="Piyari";
		$resp_list['22B']="Balaji";
		$resp_list['23B']="Lakshmi & Ramanamma";
		$resp_list['24B']="venu";
		$resp_list['25B']="Nuwan";
		$resp_list['26B']="Padma";
		$resp_list['27B']="Krishna";
		$resp_list['28B']="Syamala";
		$resp_list['29B']="Devid";
		$resp_list['30B']="Thushara";
		$resp_list['31B']="Abdul";
		$resp_list['32B']="Lakshmi ";
		$resp_list['33B']="Aravind";
		$resp_list['34B']="Raj";
		$resp_list['35B']="Rajulamma";
		$resp_list['36B']="Sulthana";
		$resp_list['37B']="Hyma";
		$resp_list['38B']="Santhoo";
		$resp_list['39B']="Phani";
		$resp_list['40B']="Ranjith";
		$resp_list['41B']="Mamatha";
		$resp_list['42B']="Sunny";
		$resp_list['43B']="Ganesh";
		$resp_list['44B']="Mahesh";
		$resp_list['45B']="Deepa";
		$resp_list['46B']="Sirisha";
		$resp_list['47B']="Nishantha";
		$resp_list['48B']="Surya";
		$resp_list['61B']="Asela";
		$resp_list['64B']="Asela";
		$resp_list['49B']="Vijaya";
		$resp_list['50B']="O.Lakshmi";
		$resp_list['51B']="Prasad";
		$resp_list['52B']="Madhavi Latha";
		$resp_list['53B']="Ruwan";
		$resp_list['55B']="Raju";
		$resp_list['56B']="Rama Krishna";
		$resp_list['57B']="Sridevi";
		$resp_list['58B']="Nooka Ratnam";
		$resp_list['59B']="Ajith";
		$resp_list['60B']="Kumar";
		$resp_list['62B']="Surya";
		$resp_list['63B']="Shiva";
		$resp_list['65B']="Santhosh";
		$resp_list['66B']="Noori";
		$resp_list['67B']="Karthik";
		$resp_list['68B']="Srinivas";
		$resp_list['69B']="Rama Krishna";
		$resp_list['70B']="Sundar";
		$resp_list['71B']="Uma";
		$resp_list['72B']="Srinu";

	}
	
	$fdate=$_POST['fdate'];
	$tdate=$_POST['tdate'];
	
	echo "<hr/><br/><div class='table-responsive'>";
	echo "<table class=\"table table-bordered\">";
	echo "<tr style='background-color:#286090;color:white;'>";
	echo "<th>Date</th>";
	echo "<th>Section</th>";
	echo "<th>Team</th>";	
	echo "<th>Module</th>";
	echo "<th>Responsible</th>";
	echo "<th>Style</th>";
	echo "<th>SMO</th>";
	echo "<th>Plan Eff%</th>";
	echo "<th>Actual Eff%</th>";
	echo "<th>Plan Output</th>";
	echo "<th>Actual Output</th>";
	echo "<th>SAH</th>";
	echo "</tr>";
	
	$sql="SELECT bac_date,bac_sec,bac_no,bac_shift,nop,SUM(bac_qty) AS bac_qty, GROUP_CONCAT(DISTINCT bac_style) AS bac_style, ROUND(SUM((bac_qty*smv)/60),2) AS sah, (nop*1) AS clh  FROM $bai_pro.bai_log_buf WHERE bac_qty>0 AND HOUR(bac_lastup) IN (6,14) AND bac_date BETWEEN \"$fdate\" AND \"$tdate\" GROUP BY bac_date,bac_no,bac_shift ORDER BY bac_date,bac_shift,bac_no";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		echo "<tr>";
		echo "<td>".$sql_row['bac_date']."</td>";
		echo "<td>".$sql_row['bac_sec']."</td>";
		echo "<td>".$sql_row['bac_shift']."</td>";	
		echo "<td>".$sql_row['bac_no']."</td>";
		echo "<td>".$resp_list[$sql_row['bac_no'].$sql_row['bac_shift']]."</td>";
		echo "<td>".$sql_row['bac_style']."</td>";
		echo "<td>".$sql_row['nop']."</td>";
		
		
		$sql1="select plan_eff, round(plan_pro/act_hours,0) as plan_out from $bai_pro.pro_plan where date=\"".$sql_row['bac_date']."\" and mod_no=\"".$sql_row['bac_no']."\" and shift=\"".$sql_row['bac_shift']."\"";
		//echo $sql1;
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$plan_eff=$sql_row1['plan_eff'];
			$plan_out=$sql_row1['plan_out'];
		}
		echo "<td>$plan_eff</td>";
		
		
		
		$act_eff=round((round(($sql_row['sah']/$sql_row['clh'])*100,0)/$plan_eff)*100,2);
		if($act_eff>=100)
		{
			$color="#66FF88";
		}
		else
		{
			if($act_eff>=90 and $act_eff<100)
			{
				$color="#FFBB44";
			}
			else
			{
				$color="#FF6655";
			}
		}
		echo "<td bgcolor=\"$color\" style=\"color:black;\">".round(($sql_row['sah']/$sql_row['clh'])*100,0)."</td>";
		echo "<td>".$plan_out."</td>";
		echo "<td>".$sql_row['bac_qty']."</td>";
		echo "<td>".round($sql_row['sah'],0)."</td>";
		echo "</tr>";
	}
	echo "</table>";
	echo "</div>";
}

// echo "</table>";

?>
</div>
</div>  
<script >
function verify_date()
{
	var val1 = $('#dat1').val();
	var val2 = $('#dat2').val();
	// d1 = new Date(val1);
	// d2 = new Date(val2);
	if(val1 > val2){
		sweetAlert('Start Date Should  be less than End Date','','warning');
		return false;
	}
	else
	{
	    return true;
	}
}
</script>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript" type="text/javascript" src="../styles/dropdowntabs.js"></script>
<link rel="stylesheet" href="../styles/ddcolortabs.css" type="text/css" media="all" />
	
<meta http-equiv="cache-control" content="no-cache">
<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "../TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{
	margin:15px; padding:15px; border:1px solid #666;
	font-family:Trebuchet MS, sans-serif; font-size:88%;
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	border:1px solid #ccc;
}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; border:2px outset #f4f4f4; margin:2px; }
th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; }
table{	background-color: white;}
</style>
<script language="javascript" type="text/javascript" src="../TableFilter_EN/actb.js"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="../TableFilter_EN/tablefilter.js"></script>

<Link rel='alternate' media='print' href=null>
<Script Language=JavaScript>

function setPrintPage(prnThis){

prnDoc = document.getElementsByTagName('link');
prnDoc[0].setAttribute('href', prnThis);
window.print();
}

</Script>

<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>
</head>

<body onload="dodisable();">

<?php
error_reporting(0);
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');		
// echo $prod_status_driver_name."-".$bel_wisdom_username."-".$bel_wisdom_password."<br>";
$con = odbc_connect("$prod_status_driver_name;Server=$bel_wisdom_server_name;Database=$bel_wisdom_database;", $bel_wisdom_username,$bel_wisdom_password);
// $con=odbc_connect('down_time_dnss','SFCS_User','yhnmko@987');
if(!$con)
{
	echo "Not Connected";
}
else
{
	echo "Connected";
}

// $plant_name="Test";

echo '<div>
<table id="table1" class="mytable">';

echo "<tr class='tblheading'>
<th>Plant</th><th>Date</th><th>Buyer</th><th>Style</th><th>Line</th><th>Reason</th><th>Reason Sub1</th><th>Reason Sub2</th><th>Lost Pieces</th><th>Lost SAH</th><th>Lost Clock Hrs</th></tr>";
$sql_max="select max(date) as max_date from $bai_pro.grand_rep where date < \"".date("Y-m-d")."\"";
// echo "<br/>".$sql_max;
$sql_result_max=mysqli_query($link,$sql_max) or exit("Sql Error".mysqli_error());
while($sql_row_max=mysqli_fetch_array($sql_result_max))
{
	$max_date=$sql_row_max["max_date"];
}

if(strlen($_GET["date"])==0)
{
	$report_date=$max_date;
}
else
{
	$report_date=$_GET["date"];
}

$sql="select * from $bai_pro.down_log where date='".$report_date."' or (date>='2019-05-18' and flag=0)  order by date, shift, mod_no";
// echo "<br/>".$sql;
$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysqli_error());
while($sql_row=mysqli_fetch_array($sql_result))
{
	$tid=$sql_row['tid'];
	$date=$sql_row['date'];
	$module=$sql_row['mod_no'];
	$buyer=$sql_row['customer'];
	$date=$sql_row['date'];
	$style=$sql_row['style'];
	$module=$sql_row['mod_no'];
	$remarks=$sql_row['remarks'];
	$updated_by=$sql_row['updated_by'];
	$shift=$sql_row['shift'];
	$schedule=$sql_row['schedule'];
	
	echo "<tr>";
	echo "<td>".$plant_name."</td>";
	echo "<td>".$date."</td>";
	echo "<td>".$buyer."</td>";
	echo "<td>".$style."</td>";
	echo "<td>".$module."</td>";
	
	$sql1x="select * from $bai_pro.down_deps where dep_id=".$sql_row['department'];
	//mysqli_query($sql1x) or exit("Sql Errorx".mysqli_error());
	$sql_result1x=mysqli_query($link,$sql1x) or exit("Sql Errorx".mysqli_error());
	while($sql_row1x=mysqli_fetch_array($sql_result1x))
	{
		$dep_name=$sql_row1x['dep_name'];
	}
	
	$down_time=(number_format(round($sql_row['dtime']/60,2),2,".",""));
	
	$sql1="select * from $bai_pro.down_reason where sno=".$sql_row['reason_code'];
	$sql_result1=mysqli_query($link,$sql1) or exit("Sql Error".mysqli_error());
	if(mysqli_num_rows($sql_result1) > 0)
	{
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$down_machine=$sql_row1['down_machine'];
			$down_problem=$sql_row1['down_problem'];
			$down_reason=$sql_row1['down_reason'];
		}
	}
	else
	{
		$down_machine="Nil";
		$down_problem="Nil";
		$down_reason="Nil";
	}
	
	echo "<td>".$down_machine."</td>";
	echo "<td>".$down_problem."</td>";
	echo "<td>".$down_reason."</td>";
	
	if($sql_row['plan_eff'] == 0)
	{	
		/*if(strtolower($sql_row['remarks']) == "speed open capacity" or strtolower($sql_row['remarks']) == "open capacity")
		{*/
			$sql2="SELECT MAX(DATE) as max_date FROM $bai_pro.pro_plan WHERE plan_eff > 0 AND DATE <= \"".$date."\"  and mod_no=\"$module\" and shift=\"$shift\"";
			// echo $sql2;
			$sql_result2=mysqli_query($link,$sql2) or die("Sql Error = ".mysqli_error());
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$max_date=$sql_row2["max_date"];
				$sql21="SELECT plan_eff FROM $bai_pro.pro_plan WHERE plan_eff > 0 AND DATE=\"".$max_date."\"  and mod_no=\"$module\" and shift=\"$shift\"";
				//echo $sql2;
				$sql_result21=mysqli_query($link,$sql21) or die("Sql Error = ".mysqli_error());
				while($sql_row21=mysqli_fetch_array($sql_result21))
				{
					$plan_eff=$sql_row21["plan_eff"];
					//echo "<td>".$plan_eff."%</td>";
				}
			}		
	}
	else
	{
		$plan_eff=$sql_row['plan_eff'];
		//echo "<td>".$plan_eff."%</td>";
	}
	
	//added newly based on anu's requirement
	$sah_loss=round($down_time*$plan_eff,2);
	
	$smv=0;
	$sql22="select smv from $bai_pro.grand_rep where module=\"".$sql_row['mod_no']."\" and date=\"".$sql_row['date']."\" and shift=\"".$sql_row['shift']."\"";
	$sql_result22=mysqli_query($link,$sql22) or die("Sql Error = ".$sql22."-".mysqli_error());
	
	while($sql_row22=mysqli_fetch_array($sql_result22))
	{
		$smv=$sql_row22["smv"];
	}
	
	if($smv > 0)
	{
		$lost_pcs=round(($sah_loss*60)/($smv*100),0);
		echo "<td>".$lost_pcs."</td>";
	}
	else
	{
		$lost_pcs=0;
		echo "<td>".$lost_pcs."</td>";
	}
	
	echo "<td>".(number_format(round($sah_loss/100,2),2,".",""))."</td>";
	
	echo "<td align=right>".(number_format(round($sql_row['dtime']/60,2),2,".",""))."</td>";
	
	$count=0;
	$mssql_select="SELECT * FROM [$bel_wisdom_database].[dbo].[$bel_wisdom_table] where TID='".$tid."' and plant2='".$plant_name."'";
	$mssql_result=odbc_exec($con,$mssql_select) or exit(odbc_errormsg($con));
	
	
	echo "<br/> mssql_select ".$mssql_select."<br/>";	
	
	
	$count=odbc_num_rows($mssql_result);
	
	echo "<br/>count".$count;
	
	if($count>0)
	{
		$sql_update="UPDATE [$bel_wisdom_database].[dbo].[$bel_wisdom_table] 
		SET [reason] = '".$down_machine."'
      ,[reasonby] = '".$dep_name."'
      ,[buyer] = '".$buyer."'
      ,[style] = '".$style."'
      ,[lossHrs] = '".round($sah_loss/100,0)."'
      ,[date2] = '".$date."'
      ,[costType2] = 'Cost of Lost SAH ($)'
      ,[color] = ''
      ,[RMtype] = ''
      ,[reasonDetailed] = '".$remarks."'
      ,[lineNumber] = '".$module."'
      ,[pieces] = '".$lost_pcs."'
      ,[reason1] = '".$down_problem."'
      ,[reason2] = '".$down_reason."'
      ,[lostClkHrs] = '".round($sql_row['dtime']/60,0)."'
	  ,[schedule] = '".$schedule."'
 WHERE  [TID] = '".$tid."' and [plant2] = '".$plant_name."'";
		
		 echo "<br/> sql_update ".$sql_update."<br/>";	
		 $res=odbc_exec($con,$sql_update);
		 
		
	}
	else
	{
		$sql_insert="insert into [$bel_wisdom_database].[dbo].[$bel_wisdom_table] (reason,reasonby,buyer,style,lossHrs,date2,plant2,costType2,color,RMtype,reasonDetailed,lineNumber,pieces,reason1,reason2,lostClkHrs,TID,Schedule) values('".$down_machine."','".$dep_name."','".$buyer."','".$style."','".round($sah_loss/100,0)."','".$date."','".$plant_name."','Cost of Lost SAH ($)','','','".$remarks."','".$module."','".$lost_pcs."','".$down_problem."','".$down_reason."','".round($sql_row['dtime']/60,0)."','".$tid."','".$schedule."')";
		  echo "<br/> sql_insert ".$sql_insert."<br/>";
		$res=odbc_exec($con,$sql_insert);
			
		
	}

	$check=odbc_num_rows($res);
	
	if($check>0)
	{
		 
		 $sql_status_update="update $bai_pro.down_log set flag=1 where tid='".$tid."'";
		echo "<br/> sql_status_update ".$sql_status_update;
		$sql_result_update=mysqli_query($link,$sql_status_update) or die("<br/>Sql Error update = ".$sql_status_update."-".mysqli_error());
		
	}
	
	if (!$res) 
	{
		print("SQL statement failed with error:\n");
		print(odbc_error($con).": ".odbc_errormsg($con)."\n");
	} 
	else 
	{
		//print("One data row inserted.\n");
	}  
	
	echo "</tr>";
}
echo "</table>";


$sql_delete_log="select * from $bai_pro.down_log_deleted where flag=1";

echo "<br/> sql_delete_log ".$sql_delete_log;

$result_delete_log=mysqli_query($link,$sql_delete_log) or exit("<br/>Sql Error delete log = ".$sql_delete_log."-".mysqli_error());
while($delete_row=mysqli_fetch_array($result_delete_log))
{
	$delete_tid=$delete_row['tid'];
	$mssql_select1="SELECT * FROM [$bel_wisdom_database].[dbo].[$bel_wisdom_table] where TID='".$delete_tid."' and plant2='".$plant_name."'";
	
	echo "<br/> mssql_select1 ".$mssql_select1;
	
	$mssql_result1=odbc_exec($con,$mssql_select1);
	
	$count1=odbc_num_rows($mssql_result1);
	
	echo "<br/>count".$count1;
	
	if($count1>0)
	{
		$mssql_delete="DELETE FROM [$bel_wisdom_database].[dbo].[$bel_wisdom_table] 
		WHERE TID='".$delete_tid."' and plant2='".$plant_name."'";
		
		echo "<br/> mssql_delete   ".$mssql_delete;
		
		$mssql_result=odbc_exec($con,$mssql_delete);
	
		$check_del=odbc_num_rows($mssql_result);
		if($check_del>0)
		{
			$sql_status_update="update $bai_pro.down_log_deleted set flag=2 where tid='".$tid."'";
			
			echo "<br/>".$sql_status_update;
			
			$sql_result_update=mysqli_query($link,$sql_status_update) or die("<br/>Sql Error update = ".$sql_status_update."-".mysqli_error());
		
		}
	
	}
	

}

odbc_close($con); 
?>

</div>

<script language="javascript" type="text/javascript">
//<![CDATA[
var MyTableFilter = {  exact_match: false }
	setFilterGrid( "table1", MyTableFilter );
//]]>
</script>

<script language="javascript"> setTimeout("CloseWindow()",0); function CloseWindow() { window.open('','_self',''); window.close(); }  </script> 

</body>
</html>
<!--
Add columns in that table like start time and end time
-->
<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

//$view_access=user_acl("SFCS_0063",$username,1,$group_id_sfcs); //1
//Date:04-04-2016/SR#23509616/kirang/code changed to get access from central administration 
//$authorised_access=user_acl("SFCS_0063",$username,7,$group_id_sfcs); //2
?>

<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/css/styles/dropdowntabs.js',3,'R');?>"></script>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/styles/ddcolortabs.css',3,'R');?>" type="text/css" media="all" />
	
<!-- <meta http-equiv="cache-control" content="no-cache"> -->
 <style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/


/*====================================================
	- General html elements
=====================================================*/
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable{
	width:110%; font-size:12px;
	border:1px solid #ccc;
}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; border:2px outset #f4f4f4; margin:2px; }
th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; }
table{	background-color: white;}
</style> 
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R');?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R');?>"></script>

<Link rel='alternate' media='print' href=null>
<Script Language=JavaScript>

function setPrintPage(prnThis){

prnDoc = document.getElementsByTagName('link');
prnDoc[0].setAttribute('href', prnThis);
window.print();
}

</Script>


<body onload="dodisable();">


<?php

	echo '<div class="panel panel-primary">';
if(isset($_GET['date']))
{
	$date=$_GET['date'];
	echo '<div class="panel-heading">Downtime Log : '.date("M-Y",strtotime($date)).'</div>';
	echo '<div class="panel-body">';
	echo '<a class="btn btn-info btn-sm" href="'.getFullURL($_GET['r'],'down_time_log_V2.php','N').'&date='.date("Y-m-d",strtotime("-1 month", strtotime($date))).'"> Last Month</a>  |  ';
	echo '<a class="btn btn-info btn-sm" href="'.getFullURL($_GET['r'],'down_time_log_V2.php','N').'&date='.date("Y-m-d",strtotime("+1 month", strtotime($date))).'"> Next Month</a>';
	// if($username=="kirang")
	{
	echo '  |  <a href="'.getFullURLLevel($_GET['r'],'workstudy/controllers/down_time_update_V2.php','2','N').'" class="btn btn-primary btn-sm"> Insert</a>';
	}
}
else
{
	$date=date("Y-m-d");
	echo '<div class="panel-heading">Downtime Log : '.date("M-Y",strtotime($date)).'</div>';
	echo '<div class="panel-body">';
	echo '<a class="btn btn-info btn-sm" href="'.getFullURL($_GET['r'],'down_time_log_V2.php','N').'&date='.date("Y-m-d",strtotime("-1 month")).'"> Last Month</a>  |  ';
	echo '<a href="'.getFullURLLevel($_GET['r'],'workstudy/controllers/down_time_update_V2.php','2','N').'" class="btn btn-primary btn-sm"> Insert</a>';
}

echo '<div class="table-responsive">
<table id="table1" class="mytable table-bordered">';





echo "<tr style='background-color:#337ab7;color:white;'>
<th style='text-align:center;'>Date</th>	<th style='text-align:center;'>Section</th>	<th style='text-align:center;'>Shift</th>	<th style='text-align:center;'>Line</th>	<th style='text-align:center;'>Customer</th>	<th style='text-align:center;'>Style</th>	<th style='text-align:center;'>Sch no</th><th style='text-align:center;'>From</th><th style='text-align:center;'>To</th>	<th style='text-align:center;'>Hours open</th>	<th style='text-align:center;'>Department</th>	<th style='text-align:center;'>Reason</th>	<th style='text-align:center;'>Source</th>	<th style='text-align:center;'>Plan Eff%</th><th style='text-align:center;'>SAH Loss</th><th style='text-align:center;'> Lost Pieces </th><th style='text-align:center;'>Controls</th></tr>";


$sql="select * from $bai_pro.down_log where month(date)=month(\"$date\") and year(date)=year(\"$date\") order by date, shift, mod_no*1";
//echo $sql;

$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$tid=$sql_row['tid'];
	$date=$sql_row['date'];
	$module=$sql_row['mod_no'];
	$reason_code=$sql_row["reason_code"];
	
	$down_machine="";
	$down_reason="";
	
	if($reason_code > 0)
	{
		$sql3="select * from $bai_pro.down_reason where sno=$reason_code";
		$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error2".$sql3.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row3=mysqli_fetch_array($sql_result3))
		{
			$down_machine=$sql_row3["down_machine"];
			$down_reason=$sql_row3["down_reason"];
		}
	}
	
	$shift=$sql_row['shift'];
	echo "<tr>";
	echo "<td>".$sql_row['date']."</td>";
	echo "<td>".$sql_row['section']."</td>";
	echo "<td>".$sql_row['shift']."</td>";
	/*if(strtolower($sql_row['remarks']) == "speed open capacity" or strtolower($sql_row['remarks']) == "open capacity")
	{
		//$module="Factory";
		echo "<td>Factory</td>";
	}
	else
	{
		echo "<td>".$sql_row['mod_no']."</td>";
	}*/
	$schedule=$sql_row['schedule'];
	$style=$sql_row['style'];
	echo "<td>".$sql_row['mod_no']."</td>";
			$sql_buyer="SELECT order_div FROM $bai_pro3.bai_orders_db where order_style_no ='$style'";
			$sql_result_buyer=mysqli_query($link, $sql_buyer) or exit($sql_buyer."Sql Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row_buyer=mysqli_fetch_array($sql_result_buyer))
			{
				$buyer=$sql_row_buyer["order_div"];
			}
	echo"<td >".wordwrap($buyer,4,"<br>\n")."</td>";
	
	echo "<td>".$style."</td>";
	echo "<td>".$schedule."</td>";
	
	$down_time=(number_format(round($sql_row['dtime']/60,2),2,".",""));
	
	
	//added newly based on anu's requirement
	$sql1="select * from $bai_pro.down_deps where dep_id=".$sql_row['department'];
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$dep_name=$sql_row1['dep_name'];
	}
	
	$start_time=$sql_row['start_time'];
	$end_time=$sql_row['end_time'];
	
	if($start_time <13)
	{
		echo "<td>".$start_time." AM</td>";
	}
	else
	{
		echo "<td>".$start_time." PM</td>";
	}
	
	if($end_time <13)
	{
		echo "<td>".$end_time." AM</td>";
	}
	else
	{
		echo "<td>".$end_time." PM</td>";
	}
	echo "<td align=right>".(number_format(round($sql_row['dtime']/60,2),2,".",""))."</td>";
	echo "<td>".$dep_name."</td>";
	
	if($reason_code > 0)
	{
		echo "<td>".$down_reason."</td>";
	}
	else
	{
		echo "<td>".$sql_row['remarks']."</td>";
	}
	
	if($sql_row['source']==0)
	{		
		echo "<td>Internal</td>";	
	}	
	else	
	{		
		echo "<td>External</td>";	
	}
	
	if($sql_row['plan_eff'] == 0)
	{	
		/*if(strtolower($sql_row['remarks']) == "speed open capacity" or strtolower($sql_row['remarks']) == "open capacity")
		{*/
			$sql2="SELECT MAX(DATE) as max_date FROM $bai_pro.pro_plan WHERE plan_eff > 0 AND DATE <= \"".$date."\"  and mod_no=\"$module\" and shift=\"$shift\"";
			//echo $sql2;
			$sql_result2=mysqli_query($link, $sql2) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$max_date=$sql_row2["max_date"];
				$sql21="SELECT plan_eff FROM $bai_pro.pro_plan WHERE plan_eff > 0 AND DATE=\"".$max_date."\"  and mod_no=\"$module\" and shift=\"$shift\"";
				//echo $sql2;
				$sql_result21=mysqli_query($link, $sql21) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row21=mysqli_fetch_array($sql_result21))
				{
					$plan_eff=$sql_row21["plan_eff"];

				}
			}		
					if($plan_eff=='')
					{
						$plan_eff='0';
						echo "<td>".$plan_eff."%</td>";
					}
					else
					{
					echo "<td>".$plan_eff."%</td>";
					}
	}
	else
	{
		$plan_eff=$sql_row['plan_eff'];
		echo "<td>".$plan_eff."%</td>";
	}
	$smv=0;
	$sah_loss1=0;
	//$sql22="select smv FROM $bai_pro.bai_log_buf where delivery=\"$schedule\" and bac_no=\"$module\" and bac_shift=\"$shift\" limit 1";
	if($style!="")
	{
			$sql22="select max(smv) as smv FROM $bai_pro.bai_log_buf where bac_style like '%$style%' and bac_no=\"$module\" and bac_shift=\"$shift\"  limit 1";
			//echo $sql22."<br/>"; 
			$sql_result22=mysqli_query($link, $sql22) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result22)>0)
			{
				while($sql_row22=mysqli_fetch_array($sql_result22))
				{
					$smv=$sql_row22["smv"];
				}
				if($smv=='' || $smv==0)
				{
					$sql22="select max(smv) as smv FROM $bai_pro.bai_log_buf where bac_style like '%$style%' limit 1";
					//echo $sql22."<br/>"; 
					$sql_result22=mysqli_query($link, $sql22) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_num_rows($sql_result22)>0)
					{
						while($sql_row22=mysqli_fetch_array($sql_result22))
						{
							$smv=$sql_row22["smv"];
						}
					}
				}
			}
			else
			{
				$smv=0;
				$sql22="select max(smv) as smv FROM $bai_pro.bai_log_buf where bac_style like '%$style%' limit 1";
				//echo $sql22."<br/>"; 
				$sql_result22=mysqli_query($link, $sql22) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_result22)>0)
				{
					while($sql_row22=mysqli_fetch_array($sql_result22))
					{
						$smv=$sql_row22["smv"];
					}
				}
			}
			
	}
	else
	{
		$smv=0;
	}
	//added newly based on anu's requirement
	$sah_loss=round($down_time*$plan_eff,2);
	$sah_loss1=(number_format(round($sah_loss/100,2),2,".",""));
	
	echo "<td>".(number_format(round($sah_loss/100,2),2,".",""))."</td>";
	echo "<td>".(number_format(round(($sah_loss1*60)/$smv,0),0,".",""))."</td>";
	//old code
	//if($username=="senthoorans" or $username=="kirang" or $username=="arunag" or $username=="pavanir" or $username=="kirang" or $username=="kirang")
	//Date:04-04-2016/kirang/code changed to get access from central administration machanism
	// if(in_array($username,$authorised_access))
	// {
		$link_delete=getFullURL($_GET['r'],'delete_transaction.php','N');
		$link_edit=getFullURL($_GET['r'],'edit_transaction.php','N');
		echo "<td><a class='btn btn-danger btn-xs confirm-submit' id='delete' href='$link_delete&tid=$tid'>Delete</a>&nbsp";
		echo "<a class='btn btn-warning btn-xs' onclick=\"return popitupnew('$link_edit&tid=$tid')\" href='$link_edit&tid=$tid'>Edit</a></td>";
	// }
	// else
	// {
	// 	echo "<td>N/A</td>";
	// }
	echo "</tr>";
}
echo "</table>";


?>

</div>

<script language="javascript" type="text/javascript">
	var table3Filters = {
	sort_select: true,
	display_all_text: "Display all",
	loader: true,
	loader_text: "Filtering data...",
	sort_select: true,
	exact_match: false,
	alternate_rows: true,  
    col_width:30,//prevents column width variations  
	rows_counter: true,
	btn_reset: true
	}
	setFilterGrid("table1",table3Filters);
</script>


</div>
</div>
</div>
<script language="javascript" type="text/javascript">

	function popitupnew(url) {
		newwindow=window.open(url,'name','height=500,width=1200,resizable=yes,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
		if (window.focus) {newwindow.focus()}
		return false;
	}

</script>

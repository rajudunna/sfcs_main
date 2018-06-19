<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
//KiranG 2015-10-12 : Added the validation at header level to close the page when it's in process state.
//KiranG 2015-10-12 : Added the validation at header level to close the page when it's in process state.
if(isset($_GET['createcsv'])){

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'m3_process_ses_track.php',0,'R'));



$time_diff=(int)date("YmdH")-$log_time;

if($log_time==0 or $time_diff>1)
{
	
}
else{
	echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
}
}
?>

<!-- <style>
	body
	{
		font-family: arial;
	}
	table, tr, td
	{
		border: 1px solid black;
		border-collapse: collapse;
	}
	tr
	{
		border: 1px solid black;
		border-collapse: collapse;
	}
	td
	{
		border: 1px solid black;
		border-collapse: collapse;
	}
	th
	{
		border: 1px solid black;
		border-collapse: collapse;
	}
	
</style> -->

<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
/* @import "TableFilter_EN/filtergrid.css"; */

/*====================================================
	- General html elements
=====================================================*/
/* body{ 
	/* margin:15px; padding:15px; border:1px solid #666; */
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
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
.mytable th{ background-color:#29759c; color:#FFF; padding:2px; border:1px solid #ccc; white-space: nowrap;}
.mytable td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space: nowrap;} */

</style>
<!-- <script language="javascript" type="text/javascript" src="TableFilter_EN/actb.js"></script>
<script language="javascript" type="text/javascript" src="TableFilter_EN/tablefilter.js"></script> -->

<div class="panel panel-primary">

<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'m3_bulk_or_proc.php',0,'R'));

//Multi User Filter
$filter_query_add="";
$auth_users=array("baischtasksvc","fazlulr","himapriyag","kirang","baischtasksvc","sfcsproject1");
$admin_users=array("kirang"); //Admin users who is having access
$super_users=array("kirang","baischtasksvc"); //allowing user to update fail archive
$admin_base_flag=0; //Flag 0-Yes, 1-No

$auto_confirm=1; //1-yes 0-No
$auto_confirm_failed_records=1; //1-yes 0-No

if(isset($_REQUEST['m3_op_filter']) or isset($_POST['submit']))
{
	$m3_op_filter=trim($_REQUEST['m3_op_filter']);
	
	$filter_query_add=" and m3_op_des='".$m3_op_filter."' and sfcs_reason=''";

	//New Version 20160523
}else{
		$m3_op_filter=trim($_GET['m3_op_filter']);
}

if(!in_array($username,$auth_users))
{
	//header("location: restricted.php");
}

// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$link_secure_m3or=construct_connection();


/*
Processing Steps

1) To update M3 related details against each row (Items status where status is 0)
2) List the status wise items.
3) Process the confirmed entries.
4) SFCS Tool Input Creation and upload.
5) To update the error and success files.

*/

//Step 1:
if(($username=="baischtasksvc") and ($log_time==0 or $time_diff>1))
{
	
	$sql="select sfcs_style,sfcs_tid,m3_op_des,sfcs_schedule,sfcs_color,m3_size,sfcs_size,sfcs_doc_no,sfcs_job_no from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_date>'2017-10-11' and sfcs_status in (0,16) and m3_op_des not in ('LAY','MRN_RE01') and sfcs_log_user<>'baischtasksvc@localhost' and sfcs_schedule>0 limit 500";
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$m3_size_code=know_m3_size_code($sql_row['sfcs_schedule'],$sql_row['sfcs_size'],$sql_row['sfcs_color']);
		if(strlen($sql_row['sfcs_job_no'])>0)
		{
			$job_no=$sql_row['sfcs_job_no'];
		}
		else
		{
			$job_no=know_sfcs_job_no($sql_row['sfcs_doc_no']);
		}
		$sql_new="update $m3_bulk_ops_rep_db.m3_sfcs_tran_log set m3_size='$m3_size_code',sfcs_job_no='$job_no' where sfcs_tid=".$sql_row['sfcs_tid']." and sfcs_status in (0,16)";
		mysqli_query($link, $sql_new) or exit("Sql Error2 $sql_new".mysqli_error($GLOBALS["___mysqli_ston"]));
	}

	//KiranG: Added on 20150728 filter code for reconfired line items with the status 16.
	$sql="select sfcs_style,sfcs_tid,m3_op_des,sfcs_schedule,sfcs_color,m3_size,sfcs_size,sfcs_doc_no,sfcs_job_no from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_date>='2017-11-03' and sfcs_status in (0,16) and sfcs_log_user<>'baischtasksvc@localhost' and sfcs_schedule>0 and m3_op_des not in ('LAY','MRN_RE01') ORDER BY SFCS_TID*1";
	// echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$m3_size_code=know_m3_size_code($sql_row['sfcs_schedule'],$sql_row['sfcs_size'],$sql_row['sfcs_color']);
		echo "M3.size=".$m3_size_code."<br>";
		if($username=="baischtasksvc") { echo  $sql_row['sfcs_schedule']."-".$sql_row['sfcs_size']."-".$m3_size_code."<br/>"; }
		$m3_color_code=m3_color_code($sql_row['sfcs_color']);
		//20151113 mssql_mdm_value -> mssql_mdm_value_sfcs
		//$mo_number=mssql_mdm_value("select QCI_M3_DB_LINK.dbo.know_mo_number('".know_my_config('facility')."',".$sql_row['sfcs_schedule'].",'".$m3_color_code."','".$m3_size_code."')");
		$mo_number=mssql_mdm_value_sfcs_mo($sql_row['sfcs_schedule'],$m3_color_code,$sql_row['sfcs_size'],"select QCI_M3_DB_LINK.dbo.know_mo_number('".know_my_config('facility')."',".$sql_row['sfcs_schedule'].",'".$m3_color_code."','".$m3_size_code."')");
		echo "MO=".know_my_config('facility')."-".$mo_number."<br>";
		//echo know_m3_size_code($sql_row['sfcs_size']);
		//echo "select QCI_M3_DB_LINK.dbo.know_mo_number(".$sql_row['sfcs_schedule'].",'".$sql_row['sfcs_color']."',".strtoupper($sql_row['sfcs_size']).")";
		if($username=="kiran") { echo $m3_color_code."-".$mo_number."<br/>"; echo "select QCI_M3_DB_LINK.dbo.know_mo_number('".know_my_config('facility')."',".$sql_row['sfcs_schedule'].",'".$m3_color_code."','".$m3_size_code."')"; }
		
		if(strlen($sql_row['sfcs_job_no'])>0)
		{
			$job_no=$sql_row['sfcs_job_no'];
		}
		else
		{
			$job_no=know_sfcs_job_no($sql_row['sfcs_doc_no']);
		}
		
		if($mo_number>0) //Validation to proceed when operation code is available.
		{
			//Disabled this to take from standard table
			//$m3_op_code=mssql_mdm_value("select QCI_M3_DB_LINK.dbo.know_op_number('".know_my_config('facility')."',".$mo_number.",'".$sql_row['m3_op_des']."')");
			
			//KiranG20170929
			$sqlxs="select m3operationid from $m3_bulk_ops_rep_db.m3_operation_master where sfcsm3operation='".$sql_row['m3_op_des']."' limit 1";
			//echo $sql."<br>";
			$sql_resultxs=mysqli_query($link, $sqlxs) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowxs=mysqli_fetch_array($sql_resultxs))
			{
				$m3_op_code=$sql_rowxs['m3operationid'];
			}
			
			//echo "<br>select QCI_M3_DB_LINK.dbo.know_op_number('".know_my_config('facility')."',".$mo_number.",'".know_my_config('facility').$sql_row['m3_op_des']."')<br>";
			echo "<br>select QCI_M3_DB_LINK.dbo.know_op_number('".know_my_config('facility')."',".$mo_number.",'".$sql_row['m3_op_des']."')<br>";
			//Kirang: Added on 20150728 to update smv value against the schedule and color.
			//$smv=mssql_mdm_value("select QCI_M3_DB_LINK.dbo.know_smv_value('".know_my_config('facility')."',".$mo_number.",".$m3_op_code.")");
			
			//20151113 mssql_mdm_value -> mssql_mdm_value_sfcs
			$smv=mssql_mdm_value_sfcs_smv($sql_row['sfcs_schedule'],$m3_color_code,$sql_row['sfcs_size'],"select QCI_M3_DB_LINK.dbo.know_smv_value('".know_my_config('facility')."',".$mo_number.",".$m3_op_code.")");
			//$smv=0;
			if($smv>0)
			{
				//$sql_new="update bai_pro3.bai_orders_db_confirm set smv=$smv where order_del_no='".$sql_row['sfcs_schedule']."' and order_col_des='".$sql_row['sfcs_color']."' and smv<>$smv";
				$sql_new="INSERT IGNORE INTO $bai_pro3.tbl_product_master (order_tid, order_style_no, order_del_no,order_col_des,smv) VALUES ('".$sql_row['sfcs_style'].$sql_row['sfcs_schedule'].$sql_row['sfcs_color']."','".$sql_row['sfcs_style']."','".$sql_row['sfcs_schedule']."','".$sql_row['sfcs_color']."',$smv) ON DUPLICATE KEY UPDATE smv=$smv";
				//echo $sql_new."<br>";
				mysqli_query($link, $sql_new) or exit("Sql Error $sql_new".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		
			echo "MP=".$sql_row['sfcs_tid']."-".$mo_number."-".$m3_op_code."<br>";
			if($mo_number>0 and $m3_op_code>0)
			{
				$sql_new="update $m3_bulk_ops_rep_db.m3_sfcs_tran_log set m3_size='$m3_size_code', m3_mo_no=$mo_number, m3_op_code=$m3_op_code,sfcs_job_no='$job_no', sfcs_status=10 where sfcs_tid=".$sql_row['sfcs_tid']." and sfcs_status in (0,16)";
				//echo $sql_new."<br>";
				$sql_result_new=mysqli_query($link, $sql_new) or exit("Sql Error2 $sql_new".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		
	}
}

//Step 3:
if(isset($_POST['add']))
{
	$status_filter=$_POST['status_filter'];
	$new_status=$_POST['new_status'];
	
	$choos=$_POST['choos'];
	$val=$_POST['val'];
	
	
	//echo sizeof($choos);
	
	for($i=0;$i<sizeof($val);$i++)
	{
		if($choos[$i]==1)
		{
			$sql_new="update $m3_bulk_ops_rep_db.m3_sfcs_tran_log set sfcs_status=$new_status where sfcs_tid=".$val[$i]." and sfcs_status=$status_filter";
			//echo $sql_new;
			mysqli_query($link, $sql_new) or exit("Sql Error3 $sql_new".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
}

if(isset($_POST['stat50']))
{
	$status_filter=$_POST['status_filter'];
	$new_status=50; //Manully Updated
	
	$choos=$_POST['choos'];
	$val=$_POST['val'];
	
	
	//echo sizeof($choos);
	
	for($i=0;$i<sizeof($val);$i++)
	{
		if($choos[$i]==1)
		{
			$sql_new="update $m3_bulk_ops_rep_db.m3_sfcs_tran_log set sfcs_status=$new_status where sfcs_tid=".$val[$i]." and sfcs_status=$status_filter";
			//echo $sql_new;
			mysqli_query($link, $sql_new) or exit("Sql Error4 $sql_new".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
}

if(isset($_POST['stat70']))
{
	$status_filter=$_POST['status_filter'];
	$new_status=70; //Failed Archived
	
	$choos=$_POST['choos'];
	$val=$_POST['val'];
	
	
	//echo sizeof($choos);
	
	for($i=0;$i<sizeof($val);$i++)
	{
		if($choos[$i]==1)
		{
			$sql_new="update $m3_bulk_ops_rep_db.m3_sfcs_tran_log set sfcs_status=$new_status where sfcs_tid=".$val[$i]." and sfcs_status=$status_filter";
			//echo $sql_new;
			mysqli_query($link, $sql_new) or exit("Sql Error5 $sql_new".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
}

if(isset($_POST['stat60']))
{
	$status_filter=$_POST['status_filter'];
	$new_status=60; //Failed Archived
	
	$choos=$_POST['choos'];
	$val=$_POST['val'];
	
	
	//echo sizeof($choos);
	
	for($i=0;$i<sizeof($val);$i++)
	{
		if($choos[$i]==1)
		{
			$sql_new="update $m3_bulk_ops_rep_db.m3_sfcs_tran_log set sfcs_status=$new_status where sfcs_tid=".$val[$i]." and sfcs_status=$status_filter";
			//echo $sql_new;
			mysqli_query($link, $sql_new) or exit("Sql Error6 $sql_new".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
}

if(isset($_POST['stat90']))
{
	$status_filter=$_POST['status_filter'];
	$new_status=90; //Failed Archived
	
	$choos=$_POST['choos'];
	$val=$_POST['val'];
	
	
	//echo sizeof($choos);
	
	for($i=0;$i<sizeof($val);$i++)
	{
		if($choos[$i]==1)
		{
			$sql_new="update $m3_bulk_ops_rep_db.m3_sfcs_tran_log set sfcs_status=$new_status where sfcs_tid=".$val[$i]." and sfcs_status=$status_filter";
			//echo $sql_new;
			mysqli_query($link, $sql_new) or exit("Sql Error7 $sql_new".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
}

//Step 2:

if(isset($_GET['filter_code']))
{
	$status_filter=$_GET['filter_code'];
}
else
{
	$status_filter=40; //Pending to Confirm
}


$title="M3 Bulk Upload Status -";
switch ($status_filter)
{
	case 0:
	{
		$title.="In Queue";
		break;
	}
	case 10:
	{
		$title.="Pending to Approve";
		break;
	}
	case 15:
	{
		$title.="Confirmed";
		break;
	}
	case 16:
	{
		$title.="Re-Confirmed";
		break;
	}
	case 20:
	{
		$title.="Work in Progress";
		break;
	}
	case 30:
	{
		$title.="Success Records";
		break;
	}
	case 40:
	{
		$title.="Failed Records";
		break;
	}
	case 50:
	{
		$title.="Manually Updated Records";
		break;
	}
	case 60:
	{
		$title.="Success Archived";
		break;
	}
	case 70:
	{
		$title.="Failed Archived";
		break;
	}
	case 90:
	{
		$title.="Ignore";
		break;
	}
}

if($auto_confirm==1) //1- Yes and 0- No
{
	$sql_new="update $m3_bulk_ops_rep_db.m3_sfcs_tran_log set sfcs_status=15 where sfcs_status=10 and sfcs_date>='2017-10-12'";
	//echo $sql_new;
	mysqli_query($link, $sql_new) or exit("Sql Error8 $sql_new".mysqli_error($GLOBALS["___mysqli_ston"]));
}

echo "<div class='panel-heading'>$title - $m3_op_filter</div><div class='panel-body'>";
?>
<form id="select_interface" name="select_interface" action="index.php?r=<?= $_GET['r']; ?>" method="POST" class="form-inline">
	
	Select: 
	<select id="m3_op_filter" name="m3_op_filter" class="form-control">
		<?php
			
			$drop_down_qry = "SELECT DISTINCT m3_op_des FROM $m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE LENGTH(m3_op_des)>0 ORDER BY m3_op_code*1";
			$sql_result=mysqli_query($link, $drop_down_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				if($m3_op_filter == trim($sql_row['m3_op_des'])){
					echo "<option value='".$sql_row['m3_op_des']."' selected>".$sql_row['m3_op_des']."</option>";
				}else{
					echo "<option value='".$sql_row['m3_op_des']."'>".$sql_row['m3_op_des']."</option>";
				}
			}
		?>
	</select>
	<input type="submit" name="submit" id="submit" value="Filter" class="btn btn-primary">
</form><br>
<?php
echo "<form method=\"post\" name=\"input\" action='?r=".$_GET['r']."'>";
echo "<input type=\"hidden\" name=\"m3_op_filter\" value=\"$m3_op_filter\">";
if($status_filter==10 or  $status_filter==40 or $status_filter==30)
{
	echo "<input type=\"hidden\" name=\"status_filter\" value=\"$status_filter\">";
	echo '<span id="msg" style="display:none;">Please Wait...</span>';
	$button_title="";
	if($status_filter==10)
	{
		if($admin_base_flag==0)
		{		
		
			if(in_array($username,$admin_users)) {
			echo "<input type=\"hidden\" name=\"new_status\" value=\"15\">";	
			$button_title="Confirm";
			echo "&nbsp;<input type=\"submit\" class='btn btn-primary' name=\"add\" id=\"add\" value=\"$button_title\" onclick=\"document.getElementById('stat90').style.display='none'; document.getElementById('add').style.display='none'; document.getElementById('msg').style.display='';\">";	
			
			//Static Coding
			/*$button_title="Ignore";
			echo "&nbsp;<input type=\"submit\" name=\"stat90\" id=\"stat90\" value=\"$button_title\" onclick=\"document.getElementById('stat90').style.display='none'; document.getElementById('add').style.display='none'; document.getElementById('msg').style.display='';\">"; */
			
			//Static Coding
			$button_title="Manullay Updated";
			echo "&nbsp;<input type=\"submit\" class='btn btn-primary' name=\"stat50\" id=\"stat50\" value=\"$button_title\" onclick=\"document.getElementById('stat50').style.display='none'; document.getElementById('add').style.display='none'; document.getElementById('stat70').style.display='none'; document.getElementById('msg').style.display='';\">";
			}
		}	
	}
	if($status_filter==40)
	{
		echo "<input type=\"hidden\" name=\"new_status\" value=\"16\">";
		$button_title="Re-Confirm";
		echo "<input type=\"submit\" class='btn btn-primary' name=\"add\" id=\"add\" value=\"$button_title\" onclick=\"document.getElementById('add').style.display='none'; document.getElementById('msg').style.display='';\">";
		
		if($admin_base_flag==0)
		{
			if(in_array($username,$admin_users) or in_array($username,$super_users))
			{
				//Static Coding
				$button_title="Manullay Updated";
				echo "&nbsp;<input type=\"submit\" class='btn btn-primary' name=\"stat50\" id=\"stat50\" value=\"$button_title\" onclick=\"document.getElementById('stat50').style.display='none'; document.getElementById('add').style.display='none'; document.getElementById('stat70').style.display='none'; document.getElementById('msg').style.display='';\">";
				$button_title="Transfer to Fail Archive";
				echo "&nbsp;<input type=\"submit\" class='btn btn-primary' name=\"stat70\" id=\"stat70\" value=\"$button_title\" onclick=\"document.getElementById('stat50').style.display='none'; document.getElementById('add').style.display='none'; document.getElementById('stat70').style.display='none'; document.getElementById('msg').style.display='';\">";
			}
		}
	}
	
	if($status_filter==30)
	{
		//Static Coding
		$button_title="Transfer to Success Archive";
		echo "&nbsp;<input type=\"submit\" class='btn btn-primary' name=\"stat60\" id=\"stat60\" value=\"$button_title\" onclick=\"document.getElementById('stat60').style.display='none'; document.getElementById('msg').style.display='';\">";
	}
}

if(!isset($_GET['createcsv'])){

$url = getFullURLLevel($_GET['r'],'m3_bulk_or_ui.php',0,'N'); 
echo "<br/><br/>";
echo "<a class='btn btn-info btn-xs' href=\"$url&filter_code=10&m3_op_filter=$m3_op_filter\">Pending to Approve</a>";
echo "&nbsp;&nbsp; | &nbsp; &nbsp; <a href=\"$url&filter_code=15&m3_op_filter=$m3_op_filter\" class='btn btn-info btn-xs'>Confirmed</a>";
echo "&nbsp;&nbsp; | &nbsp; &nbsp; <a href=\"$url&filter_code=16&m3_op_filter=$m3_op_filter\" class='btn btn-info btn-xs'>Re-Confirmed</a>";
echo "&nbsp;&nbsp; | &nbsp; &nbsp; <a href=\"$url&filter_code=20&m3_op_filter=$m3_op_filter\" class='btn btn-info btn-xs'>Work in Progress</a>";
echo "&nbsp;&nbsp; | &nbsp; &nbsp; <a href=\"$url&filter_code=30&m3_op_filter=$m3_op_filter\" class='btn btn-info btn-xs'>Success Records</a>";
echo "&nbsp;&nbsp; | &nbsp; &nbsp; <a href=\"$url&filter_code=40&m3_op_filter=$m3_op_filter\" class='btn btn-info btn-xs'>Failed Records</a>";


echo "&nbsp;&nbsp; | &nbsp; &nbsp; <a href=\"$url&filter_code=50&m3_op_filter=$m3_op_filter\" class='btn btn-info btn-xs'>Manually Updated Records</a>"; //Status 40 Can be turned into this status
echo "&nbsp;&nbsp; | &nbsp; &nbsp; <a href=\"$url&filter_code=60&m3_op_filter=$m3_op_filter\" class='btn btn-info btn-xs'>Success Archived</a>"; //Status 30 can be turned into this status
echo "&nbsp;&nbsp; | &nbsp; &nbsp; <a href=\"$url&filter_code=70&m3_op_filter=$m3_op_filter\" class='btn btn-info btn-xs'>Failed Archived</a>"; //Status 40 Can be turned into this status
echo "&nbsp;&nbsp; | &nbsp; &nbsp; <a href=\"$url&filter_code=90&m3_op_filter=$m3_op_filter\" class='btn btn-info btn-xs'>Ignored</a>";
echo "&nbsp;&nbsp; | &nbsp; &nbsp; <a class='btn btn-info btn-xs' href=\"$url&filter_code=0&m3_op_filter=$m3_op_filter\" title=\"List of records Not Validated by System. This list will turn in to Pending to Approve after validation.\">In Queue</a>";

echo "<br/><br/>";

//Loading Message
echo "<div id=\"loading\" class='alert alert-warning' role='alert' align='center'>Please wait while preparing report...</div>";
	
	ob_end_flush();
	flush();
	usleep(10);
	
echo "<div class='table-responsive'><table class=\"mytable\" id=\"table1\">";
echo "<thead><tr>";
echo "
<th>Control <input type=\"checkbox\" name=\"selectall\" onclick=\"checkAll();\" id=\"selectall\"/> <font color=\"yellow\">Select All</font></th>
<th>Style</th>
<th>Schedule</th>
<th>Color</th>
<th>Size</th>
<th>Quantity</th>
<th>Operation</th>
<th>Reason</th>
<th>TID</th>
<th>Job#</th>
<th>Module</th>
<th>Shift</th>
<th>M3 Message</th>
";
echo "</tr></thead><tbody>";
$i=0;
$x=2;

$sql="select sfcs_date,sfcs_tid,sfcs_style, sfcs_schedule,sfcs_color,m3_size,sfcs_qty,m3_op_des,m3_op_des,m3_error_code, sfcs_status,sfcs_reason,sfcs_tid_ref,sfcs_job_no from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_log_user<>'baischtasksvc@localhost' and sfcs_status=$status_filter and sfcs_tid>0 $filter_query_add";
// echo $sql."<br>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	echo "<tr class=\"foo\" id=\"rowchk$x\">";
		//KiranG 20150718 added a validation to avoid read time out issue and duplicate confirmation.
		$chooseval=1;
		$choosetle="";
		$chooseview="checkbox";
		if(strpos($sql_row['m3_error_code'],'Read timed out-')==true)
		{
			$chooseval=0;
			$choosetle="Please contact ICT...";
			$chooseview="hidden";
		}
		echo "<td><input type=\"$chooseview\" name=\"choos[$i]\" id=\"chk[$x]\" value=\"$chooseval\">$choosetle<input type=\"hidden\" name=\"val[$i]\" value=\"".$sql_row['sfcs_tid']."\">".$sql_row['sfcs_date']."</td>";
		echo "<td>".$sql_row['sfcs_style']."</td>";
		echo "<td>".$sql_row['sfcs_schedule']."</td>";
		echo "<td>".$sql_row['sfcs_color']."</td>";
		echo "<td>".$sql_row['m3_size']."</td>";
		echo "<td>".$sql_row['sfcs_qty']."</td>";
		echo "<td>".$sql_row['m3_op_des']."</td>";
		echo "<td>".$sql_row['sfcs_reason']."</td>";
		echo "<td>".$sql_row['sfcs_tid_ref']."</td>";
		echo "<td>".$sql_row['sfcs_job_no']."</td>";
		echo "<td>".$sql_row['sfcs_mod_no']."</td>";
		echo "<td>".$sql_row['sfcs_shift']."</td>";
		if($sql_row['sfcs_status']>=40)
		{
			echo "<td>".$sql_row['m3_error_code']."</td>";
		}
		else
		{
			echo "<td></td>";
		}		
	echo "</tr>";
	$i++;
	$x++;
}
echo "</tbody></table></div>";
echo "</form>";

}

//Step 4:

if(isset($_GET['createcsv'])){

include("m3_process_ses_track.php");

$time_diff=(int)date("YmdH")-$log_time;

if($log_time==0 or $time_diff>1)
{
	// $myFile = "m3_process_ses_track.php";
	$myFile = $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'m3_process_ses_track.php',0,'R');
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php $"."log_time=".(int)date("YmdH")."; ?>";
	fwrite($fh, $stringData);
	fclose($fh);

	$facility_code=know_my_config("facility");

	$operations=array("SFCSGoodPositive","SFCSGoodNegative","SFCSScrapPositive","SFCSScrapNegative");
	$filepart="_".date("Y-m-d")."_".rand(0,99999)."_".date("His");
	
	$add_filter_qry="IF(m3_op_des in ('ASPS','ASPR','BSPS','BSPR'),'1',IF(m3_op_des in ('SIN','PS','PR','CUT','LAY'),'01',IF(sfcs_mod_no>0,LPAD(CAST(sfcs_mod_no as SIGNED),2,0),'01')))";
	
	//$query_list=array(	"select sfcs_tid,'SFCSGoodPositive','Actual','$facility_code',m3_op_code,concat('$facility_code',m3_op_des,$add_filter_qry),sfcs_job_no,sfcs_shift,DATE_FORMAT(sfcs_date,'%Y%m%d'),concat('SFCS-','$facility_code'),sfcs_schedule,sfcs_style,m3_mo_no,sfcs_qty,sfcs_reason,sfcs_color,m3_size from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_tid in (32,33) and sfcs_log_user<>'baischtasksvc@localhost' and sfcs_status in (15,16) and sfcs_reason='' and sfcs_qty>0",	"select sfcs_tid,'SFCSGoodNegative','Reversal','$facility_code',m3_op_code,concat('$facility_code',m3_op_des,$add_filter_qry),sfcs_job_no,sfcs_shift,DATE_FORMAT(sfcs_date,'%Y%m%d'),concat('SFCS-','$facility_code'),sfcs_schedule,sfcs_style,m3_mo_no,sfcs_qty,sfcs_reason,sfcs_color,m3_size from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_tid in (32,33) and sfcs_log_user<>'baischtasksvc@localhost' and sfcs_status in (15,16) and sfcs_reason='' and sfcs_qty<0 ",	"select sfcs_tid,'SFCSScrapPositive','Actual','$facility_code',m3_op_code,concat('$facility_code',m3_op_des,$add_filter_qry),sfcs_job_no,sfcs_shift,DATE_FORMAT(sfcs_date,'%Y%m%d'),concat('SFCS-','$facility_code'),sfcs_schedule,sfcs_style,m3_mo_no,sfcs_qty,sfcs_reason,sfcs_color,m3_size from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_tid in (32,33) and  sfcs_log_user<>'baischtasksvc@localhost' and sfcs_status in (15,16) and sfcs_reason<>'' and sfcs_qty>0 ",	"select sfcs_tid,'SFCSScrapNegative','Reversal','$facility_code',m3_op_code,concat('$facility_code',m3_op_des,$add_filter_qry),sfcs_job_no,sfcs_shift,DATE_FORMAT(sfcs_date,'%Y%m%d'),concat('SFCS-','$facility_code'),sfcs_schedule,sfcs_style,m3_mo_no,sfcs_qty,sfcs_reason,sfcs_color,m3_size from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_tid in (32,33) and sfcs_log_user<>'baischtasksvc@localhost' and sfcs_status in (15,16) and sfcs_reason<>'' and sfcs_qty<0 "	);
	
	/* $query_list=array(	
	"select sfcs_tid,'SFCSGoodPositive','Actual','$facility_code',m3_op_code,know_m3_wkcenter(m3_op_des,sfcs_mod_no,sfcs_shift),concat(sfcs_job_no,'-',sfcs_tid),sfcs_shift,DATE_FORMAT(sfcs_date,'%Y%m%d'),concat('SFCS-','$facility_code'),sfcs_schedule,sfcs_style,m3_mo_no,sfcs_qty,sfcs_reason,sfcs_color,m3_size from m3_bulk_ops_rep_db.m3_sfcs_tran_log where  sfcs_date>='2017-11-03' and sfcs_log_user<>'baischtasksvc@localhost' and sfcs_status in (15,16) and m3_op_des not in ('LAY','MRN_RE01') and sfcs_reason='' and sfcs_qty>0 limit 500",	
	"select sfcs_tid,'SFCSGoodNegative','Reversal','$facility_code',m3_op_code,know_m3_wkcenter(m3_op_des,sfcs_mod_no,sfcs_shift),concat(sfcs_job_no,'-',sfcs_tid),sfcs_shift,DATE_FORMAT(sfcs_date,'%Y%m%d'),concat('SFCS-','$facility_code'),sfcs_schedule,sfcs_style,m3_mo_no,sfcs_qty,sfcs_reason,sfcs_color,m3_size from m3_bulk_ops_rep_db.m3_sfcs_tran_log where   sfcs_date>='2017-11-03' and  sfcs_log_user<>'baischtasksvc@localhost' and sfcs_status in (15,16) and m3_op_des not in ('LAY','MRN_RE01') and sfcs_reason='' and sfcs_qty<0  limit 500",	
	"select sfcs_tid,'SFCSScrapPositive','Actual','$facility_code',m3_op_code,know_m3_wkcenter(m3_op_des,sfcs_mod_no,sfcs_shift),concat(sfcs_job_no,'-',sfcs_tid),sfcs_shift,DATE_FORMAT(sfcs_date,'%Y%m%d'),concat('SFCS-','$facility_code'),sfcs_schedule,sfcs_style,m3_mo_no,sfcs_qty,sfcs_reason,sfcs_color,m3_size from m3_bulk_ops_rep_db.m3_sfcs_tran_log where   sfcs_date>='2017-11-03' and  sfcs_log_user<>'baischtasksvc@localhost' and sfcs_status in (15,16) and m3_op_des not in ('LAY','MRN_RE01') and sfcs_reason<>'' and sfcs_qty>0  limit 500",	
	"select sfcs_tid,'SFCSScrapNegative','Reversal','$facility_code',m3_op_code,know_m3_wkcenter(m3_op_des,sfcs_mod_no,sfcs_shift),concat(sfcs_job_no,'-',sfcs_tid),sfcs_shift,DATE_FORMAT(sfcs_date,'%Y%m%d'),concat('SFCS-','$facility_code'),sfcs_schedule,sfcs_style,m3_mo_no,sfcs_qty,sfcs_reason,sfcs_color,m3_size from m3_bulk_ops_rep_db.m3_sfcs_tran_log where   sfcs_date>='2017-11-03' and  sfcs_log_user<>'baischtasksvc@localhost' and sfcs_status in (15,16) and m3_op_des not in ('LAY','MRN_RE01') and sfcs_reason<>'' and sfcs_qty<0  limit 500"	); */
	
	 $query_list=array(	
	"select sfcs_tid,'SFCSGoodPositive','Actual','$facility_code',m3_op_code,know_m3_wkcenter(m3_op_des,sfcs_mod_no,sfcs_shift),sfcs_job_no,sfcs_shift,DATE_FORMAT(sfcs_date,'%Y%m%d'),concat('SFCS-','$facility_code'),sfcs_schedule,sfcs_style,m3_mo_no,sfcs_qty,sfcs_reason,sfcs_color,m3_size from m3_bulk_ops_rep_db.m3_sfcs_tran_log where  sfcs_date>='2017-11-03' and sfcs_log_user<>'baischtasksvc@localhost' and sfcs_status in (15,16) and m3_op_des not in ('LAY','MRN_RE01') and sfcs_reason='' and sfcs_qty>0 limit 500",	
	"select sfcs_tid,'SFCSGoodNegative','Reversal','$facility_code',m3_op_code,know_m3_wkcenter(m3_op_des,sfcs_mod_no,sfcs_shift),sfcs_job_no,sfcs_shift,DATE_FORMAT(sfcs_date,'%Y%m%d'),concat('SFCS-','$facility_code'),sfcs_schedule,sfcs_style,m3_mo_no,sfcs_qty,sfcs_reason,sfcs_color,m3_size from m3_bulk_ops_rep_db.m3_sfcs_tran_log where   sfcs_date>='2017-11-03' and  sfcs_log_user<>'baischtasksvc@localhost' and sfcs_status in (15,16) and m3_op_des not in ('LAY','MRN_RE01') and sfcs_reason='' and sfcs_qty<0  limit 500",	
	"select sfcs_tid,'SFCSScrapPositive','Actual','$facility_code',m3_op_code,know_m3_wkcenter(m3_op_des,sfcs_mod_no,sfcs_shift),sfcs_job_no,sfcs_shift,DATE_FORMAT(sfcs_date,'%Y%m%d'),concat('SFCS-','$facility_code'),sfcs_schedule,sfcs_style,m3_mo_no,sfcs_qty,sfcs_reason,sfcs_color,m3_size from m3_bulk_ops_rep_db.m3_sfcs_tran_log where   sfcs_date>='2017-11-03' and  sfcs_log_user<>'baischtasksvc@localhost' and sfcs_status in (15,16) and m3_op_des not in ('LAY','MRN_RE01') and sfcs_reason<>'' and sfcs_qty>0  limit 500",	
	"select sfcs_tid,'SFCSScrapNegative','Reversal','$facility_code',m3_op_code,know_m3_wkcenter(m3_op_des,sfcs_mod_no,sfcs_shift),sfcs_job_no,sfcs_shift,DATE_FORMAT(sfcs_date,'%Y%m%d'),concat('SFCS-','$facility_code'),sfcs_schedule,sfcs_style,m3_mo_no,sfcs_qty,sfcs_reason,sfcs_color,m3_size from m3_bulk_ops_rep_db.m3_sfcs_tran_log where   sfcs_date>='2017-11-03' and  sfcs_log_user<>'baischtasksvc@localhost' and sfcs_status in (15,16) and m3_op_des not in ('LAY','MRN_RE01') and sfcs_reason<>'' and sfcs_qty<0  limit 500"	); 
	
	$title_list = array
	(
	"RN","Application","Action","FactoryCode ","Type","DeviationWorkCenter","JobNumber","ShiftCode","TransactionDate","UserName","SchelduleCode","StyleCode","MONumber","Quantity","ScrapReason","ColorCode","SizeCode"
	);
	
	for($i=0;$i<sizeof($operations);$i++)
	{
		
		$sql_result=mysqli_query($link, $query_list[$i]) or exit("Sql Error10".$query_list[$i].mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo $query_list[$i]."***********".mysql_num_rows($sql_result)."<br/>";
		if(mysqli_num_rows($sql_result)>0)
		{

			$file_name="input\\".$operations[$i].$filepart."_$facility_code.csv";
			$file = fopen($file_name,"w");

		 	fputcsv($file,$title_list);
		 	
		 	while ($row = mysqli_fetch_assoc($sql_result)) 
		 	{
		 		//echo $row["sfcs_tid"];
		 		mysqli_query($link, "update m3_bulk_ops_rep_db.m3_sfcs_tran_log set sfcs_status=20 where sfcs_status in (15,16) and sfcs_tid=".$row["sfcs_tid"]) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
		 		
		 		if(mysqli_affected_rows($link)>0)
		 		{
					fputcsv($file, $row);	
				}		
		 	}
		 	
			fclose($file); 
		}
		
		
	}

/*	Disabled to complete task in single shot.
}


//Step 5:
if(isset($_GET['updatecsv']))
{
*/
	$folders_list=array("error","successed");
	$folder_status=array(40,30);
	
	for($i=0;$i<sizeof($folders_list);$i++)
	{
		//$files=glob("./".$folders_list[$i]."/*_$facility_code"."_*.csv");
		//modified the file path from _* due to change in APID 2017-05-06 KiranG
		$files=glob("./".$folders_list[$i]."/*_$facility_code".".csv");
		//echo "./".$folders_list[$i]."/$facility_code"."_"."*.csv";
		foreach($files as $filepath)
		{
			//echo basename($filepath);
			$filename=basename($filepath);
			//echo $filename;
			//Move to processed zone.
			if(mysqli_num_rows(mysqli_query($link, "select * from m3_bulk_ops_rep_db.file_process_log where file_folder_name='".$filepath."'"))>0)
			{
				rename("./".$folders_list[$i]."/$filename","./".$folders_list[$i]."_processed/$filename");	
			}
			else
			{
				$handle=fopen($filepath,"r");
				while(($data=fgetcsv($handle,1000,","))!==FALSE)
				{
					
					mysqli_query($link, "update  m3_bulk_ops_rep_db.m3_sfcs_tran_log set sfcs_status=".$folder_status[$i].", m3_error_code='".addslashes($data[1])."-".addslashes($data[9])."' where sfcs_tid='".$data[0]."' and sfcs_status in (20) ") or exit("Sql Error12"."update  m3_bulk_ops_rep_db.m3_sfcs_tran_log set sfcs_status=".$folder_status[$i].", m3_error_code='".addslashes($data[1])."-".addslashes($data[9])."' where sfcs_tid='".$data[0]."' and sfcs_status in (20) ".mysqli_error($GLOBALS["___mysqli_ston"]));
					
				}
				
				//TO update file completion log.
				mysqli_query($link, "insert into m3_bulk_ops_rep_db.file_process_log (file_name,file_folder_name) values ('$filename','$filepath')") or exit("Sql Error13".$query_list[$i].mysqli_error($GLOBALS["___mysqli_ston"]));
				
				fclose($handle);
			}
			
			
		}
	}
	
	$myFile = "m3_process_ses_track.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php $"."log_time=0; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
	
	echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
	
}
else
{
	echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
}

//Auto Confirm Failed Records (kirang - 20171018)
if($auto_confirm_failed_records==1) //1- Yes and 0- No
{
	$sql_new="update m3_bulk_ops_rep_db.m3_sfcs_tran_log set sfcs_status=16 where sfcs_status=40 and sfcs_date='".date("Y-m-d")."'";
	//$sql_new="update m3_bulk_ops_rep_db.m3_sfcs_tran_log set sfcs_status=16 where sfcs_status=40";
	//echo $sql_new;
	mysqli_query($link, $sql_new) or exit("Sql Error8 $sql_new".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql_new_delete="delete from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_qty=0 and sfcs_date>='2017-10-12'";
	//echo $sql_new;
	//mysql_query($sql_new_delete,$link_secure_m3or) or exit("Sql Error9 $sql_new_delete".mysql_error());
}
	
}

//@mysql_close($link_secure_m3or);
//@mysql_close($link_secure_m3or_update);
?>

</div>
</div>
<script language="javascript" type="text/javascript">
//<![CDATA[
	var table6_Props = 	{
							rows_counter: true,
							btn_reset: true,
							loader: true,
							sort_select: true,
							btn: true,
							btn_text: "  >  ",
							 enter_key: false,
							loader_text: "Filtering data...",
							display_all_text: "All",
							col_6: "select",
							col_7: "select"
						};
	setFilterGrid( "table1",table6_Props );
//]]>
</script>



<script>

function checkAll()
{
    var checkboxes = document.getElementsByTagName('input'), val = null;    
    for (var i = 0; i < checkboxes.length; i++)
    {
        if (checkboxes[i].type == 'checkbox')
        {
            if (val === null) val = checkboxes[i].checked;
            checkboxes[i].checked = val;
        }
    }
}

// $("#table1 thead tr th:first input:checkbox").click(function() {
    // var checkedStatus = document.getElementById("selectall").checked;

    // td = document.getElementsByTagName('tr');
    // for (var  i = 0; i < td.length; i++) {
	
       // if(td[i].className == "foo")
	   // {
	   		
			// if(td[i].style.display=="block" || td[i].style.display=="")
			// {
				// document.getElementById('chk['+i+']').checked=checkedStatus;
				// if(checkedStatus==true)
				// {
					// document.getElementById('rowchk'+i).style.background="#00FF22";
				// }
				// else
				// {
					// document.getElementById('rowchk'+i).style.background="white";
				// }
			// }
	
	   // }
           
    // }

// });

function selectind(x)
{
	var checkedStatus = document.getElementById('chk['+x+']').checked;
	if(checkedStatus==true)
	{
		document.getElementById('rowchk'+x).style.background="#00FF22";
	}
	else
	{
		document.getElementById('rowchk'+x).style.background="white";
	}
}


function autofill()
{
	var val=document.getElementById("autofillval").value;
	var td = document.getElementsByTagName('tr');
	
	for (var  i = 0; i < td.length; i++) {
       if(td[i].className == "foo")
	   {
	   		if(td[i].style.display=="block" || td[i].style.display=="")
			{
				if(document.getElementById('chk['+i+']').checked==true)
				{
					document.getElementById('val['+i+']').value=val;
				}
			}
	   }
           
    }
}

</script>

<script>
	document.getElementById("loading").style.display="none";		
</script>
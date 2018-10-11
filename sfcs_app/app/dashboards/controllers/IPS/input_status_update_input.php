<!-- 2013-11-25/DharaniD/Ticket #988194
Revised CSS files for interface standardization,Add the Validation on trims status.-->
<?php
include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');
$php_self = explode('/',$_SERVER['PHP_SELF']);
//var_dump($php_self);
array_pop($php_self);
$url_r = base64_encode(implode('/',$php_self)."/input_status_update_input.php");
$has_permission=haspermission($url_r);  
?>
<script type="text/javascript" src="sweetalert.min.js"></script>
<script>	
	function pop_test(e)
	{
		var count = 0;
		var items = document.getElementsByName('input_qty[]');
		// alert(items.length);
		for(var i=0;i<items.length;i++){

			if( isNaN(items[i].value) ){
				items[i].value = '';
				sweetAlert('Please Enter only Numbers','','warning');
				
			}
		}
		return only_num(e);
	}
	function only_num(e){
		if(e.keyCode == 189 || e.keyCode== 187 || e.keyCode== 45 || e.keyCode== 69 || e.keyCode== 107 || e.keyCode== 109  || e.keyCode== 187 || e.keyCode == 110 || e.keyCode == 190 ){
			return false;
		}else{
			return true;
		}
	}

</script>
<?php
include("../../../../common/config/config.php");
include("../../../../common/config/functions.php");
error_reporting(0);
$has_permission = haspermission($_GET['r']);
// $username_list=explode('\\',$_SERVER['REMOTE_USER']);
// $username=strtolower($username_list[1]);
$username="sfcsproject1";
$special_users=array("sfcsproject1"); // users for all access in trims status
$trim_warehouse_users=array("sfcsproject1");   //User for access Trim part :RameshK
$input_update_users=array("sfcsproject1");   //User for access Inputs :RameshK
$view_users=array("sfcsproject1");   //User users :RameshK

$ims_special_input_access_for_4job=array("sfcsproject1"); 
$ims_special_input_access_full=array("sfcsproject1"); 


$job_color_status=$_GET['job_status'];
//echo $job_color_status;
if($job_color_status=='blue')
{
	$display_job_color_status="Job is ready to issue<br/>(Blue Color)";
}
else if($job_color_status=='yellow')
{
	$display_job_color_status="Cutting not Completed<br/>(Yellow Color)";
}
else if($job_color_status=='lgreen')
{
	$display_job_color_status="Fabric not receive yet<br/>(Dark Green Color)";
}
else 
{
	$display_job_color_status="Job not ready to issue";
}

//$isinput=$_GET['isinput'];

//function to extract input informat



function doc_in_status($link,$result_type,$size,$doc_no,$input_ref)
{
	//$result_type : CUTQTY, INPUTQTY (as per input job reference), IMSINPUTQTY (as per docket)
	//$doc_no: Docket #
	//$input_refere: Input job reference random
	include("../../../../common/config/config.php");
	$ret=0;
	switch($result_type)
	{
		case 'CUTQTY':
		{
			$sql="select (a_$size*a_plies) as cutqty from $bai_pro3.plandoc_stat_log where doc_no=$doc_no";
			//echo $sql."<br>";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$ret=$sql_row['cutqty'];
			}

			break;
		}
		
		case 'INPUTQTY':
		{
			$sql="SELECT COALESCE(SUM(in_qty),0) as input FROM ((SELECT SUM(ims_qty) AS in_qty FROM $bai_pro3.ims_log_backup WHERE ims_doc_no='$doc_no'  and input_job_rand_no_ref='$input_ref'  and ims_size='a_$size') UNION (SELECT SUM(ims_qty) AS in_qty FROM $bai_pro3.ims_log WHERE ims_doc_no='$doc_no' and input_job_rand_no_ref='$input_ref' and ims_size='a_$size')) AS tmp";
			//echo $sql."<br>";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$ret=$sql_row['input'];
			}
			break;
		}
		
		case 'IMSINPUTQTY':
		{
			//echo $doc_no;
			$sql="SELECT COALESCE(SUM(in_qty),0) as input FROM ((SELECT SUM(ims_qty) AS in_qty FROM $bai_pro3.ims_log_backup WHERE ims_doc_no='$doc_no'  and ims_size='a_$size') UNION (SELECT SUM(ims_qty) AS in_qty FROM $bai_pro3.ims_log WHERE ims_doc_no='$doc_no' and ims_size='a_$size')) AS tmp";
			//echo $sql."<br>";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$ret=$sql_row['input'];
			}
			break;
		}
		
	}
	
	return $ret;
	
}

//Function to Validate M3 Entries

function m3_validate_ims($inserid,$link,$style,$schedule,$color,$size,$doc_no,$qty,$operation)
{
	include("../../../../common/config/config.php");
	$sql111="select sfcs_tid from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_style='$style' and sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size=REPLACE('$size','a_','') and sfcs_doc_no='$doc_no' and sfcs_qty=".$qty." and sfcs_log_user=USER() and LEFT(sfcs_log_time,13)='".date("Y-m-d H")."' and m3_op_des='$operation' and sfcs_tid_ref='$inserid'";
	$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	return mysqli_num_rows($sql_result111);
}

?>
<html>

<head>
<title>Input Status Update Form</title>
<script>
function popitup(url) {
newwindow=window.open(url,'name','scrollbars=1,menubar=1,resizable=1,location=0,toolbar=0');
if (window.focus) {newwindow.focus();}
return false;
}

function popitup_new(url) {

newwindow=window.open(url,'name','scrollbars=1,menubar=1,resizable=1,location=0,toolbar=0');
if (window.focus) {newwindow.focus();}
return false;
}
</script>
<style type="text/css" media="screen">

/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/


/*====================================================
	- General html elements
=====================================================*/
body{ 
	margin:15px; padding:15px; border:0px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:12px; 
	background-color:#EEE; 
}
a {
	margin:0px; padding:0px;
}
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable1{
	font-size:12px;
}
th{ background-color:#29759C; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;background-color: #FFF}
</style>
</head>
<body>
<form action="input_status_update_input.php" method="POST">


<?php

//$table_name="fabric_priorities";
$table_name="$bai_pro3.plan_dashboard_input";

if(isset($_POST["doc"]) or isset($_POST["section"]))
{
	$doc=$_POST["doc"];
	$section=$_POST["section"];
	$style=$_POST["style"];
	$schedule=$_POST["schedule"];
	$jobno=$_POST["jobno"];
	$module_no=$_POST["moduleno"];
	//echo $module_no."<br>";
}
else
{
	$doc=$_GET["doc_no"];
	$section=$_GET["section"];
	$style=$_GET["style"];
	$schedule=$_GET["schedule"];
	$jobno=$_GET["jobno"];
	$module_no=$_GET["module"];
	//echo $module_no."<br>";
}

//echo $doc;

$sql3="select input_trims_status as stat from $table_name where input_job_no_random_ref='$doc'";
$result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row3=mysqli_fetch_array($result3))
{
	$trims_statusx=$row3["stat"];
}

// Start - To take club schedule number and  list of original schedules  -  11-11-2014 - Added by ChathurangaD
$ssql33="SELECT order_joins from $bai_pro3.bai_orders_db_confirm where order_del_no='$schedule'";
//echo $ssql33;
$result33=mysqli_query($link, $ssql33) or exit("Sql Error33".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row33=mysqli_fetch_array($result33))
{
	$join_sch=$row33["order_joins"];
	$join_sch1=$row33["order_joins"];
}

if($join_sch1=="0")
{
	$join_sch=$schedule;
	$org_schs=$schedule;
}
else if($join_sch1=="1")
{
	$ssql333="SELECT GROUP_CONCAT(order_del_no) as org_schs FROM $bai_pro3.bai_orders_db_confirm WHERE order_joins='j$schedule'";
	//echo $ssql333;
	$result333=mysqli_query($link, $ssql333) or exit("Sql Error333".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row333=mysqli_fetch_array($result333))
	{
		$org_schs=$row333["org_schs"];
		//echo $org_schs;
	}
	
	$join_sch=$schedule;
}
else if($join_sch1=="2")
{
	$ssql333="SELECT GROUP_CONCAT(order_del_no) as org_schs FROM $bai_pro3.bai_orders_db_confirm WHERE order_joins='j$schedule'";
	//echo $ssql333;
	$result333=mysqli_query($link, $ssql333) or exit("Sql Error333".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row333=mysqli_fetch_array($result333))
	{
		$org_schs=$row333["org_schs"];
		//echo $org_schs;
	}
	
	$join_sch=$schedule;
	
	
}
else
{
	$ssql333="SELECT GROUP_CONCAT(order_del_no) as org_schs FROM $bai_pro3.bai_orders_db_confirm WHERE order_joins='$join_sch'";
	//echo $ssql333;
	$result333=mysqli_query($link, $ssql333) or exit("Sql Error333".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row333=mysqli_fetch_array($result333))
	{
		$org_schs=$row333["org_schs"];
		//echo $org_schs;
	}
	$join_sch=substr($join_sch, 1);
	
}
//echo $org_schs;

// End - To take club schedule number and list of original schedules  -  11-11-2014 - Added by ChathurangaD

// Start  ---------  03-Nov-2014 -  Added by Chathurangad

if(in_array($update,$has_permission))
{
	echo "<h2>Line Input Update Status</h2>";
	$textbox_disable="";
	$dropdown_disable="disabled=\"disabled\"";
}
else if(in_array($view,$has_permission))
{
	echo "<h2>Line Input View Form</h2>";
	$textbox_disable="disabled=\"disabled\"";
	$dropdown_disable="disabled=\"disabled\"";
}
else
{
	header("Location:restrict.php");
	$textbox_disable="";
	$dropdown_disable="disabled=\"disabled\"";
}
// End  ---------  03-Nov-2014 -  Added by Chathurangad

echo "<h3>Style:$style / Schedule:$join_sch / Input Job#: J".leading_zeros($jobno,3)."</h3>";

$sql="SELECT GROUP_CONCAT(CONCAT(\"'\",order_col_des,\"'\")) AS colorset,GROUP_CONCAT(sizegroup) AS size_group FROM ( SELECT DISTINCT order_col_des,GROUP_CONCAT(sizeset SEPARATOR '*') AS sizegroup FROM ( SELECT order_col_des,CONCAT(m3_size_code,'$',SUM(carton_act_qty)) AS sizeset FROM $bai_pro3.packing_summary_input WHERE input_job_no_random='$doc' GROUP BY order_col_des,size_code) AS a GROUP BY order_col_des) AS b";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))

{
	$colorset=$sql_row['colorset'];
	$size_group=$sql_row['size_group'];
}

$seq_no=echo_title("$bai_pro3.packing_summary_input","pac_seq_no","input_job_no_random",$doc,$link);

//echo "<h4>Ratio Sheet</h4>";

 echo "<a class='btn btn-info btn-sm' href=\"../../../production/controllers/sewing_job/print_input_sheet.php?schedule=$org_schs&seq_no=$seq_no\" onclick=\"return popitup('../../../production/controllers/sewing_job/print_input_sheet.php?schedule=$org_schs&seq_no=$seq_no')\">Print Input Job Sheet - Job Wise</a><br>";
	
 //echo "<br><a class='btn btn-info btn-sm' href=\"print_input_sheet_dest.php?schedule=$org_schs\" onclick=\"return popitup_new('print_input_sheet_dest.php?schedule=$org_schs')\">Print Input Job Sheet - Destination Wise</a><br>";

// $production_review_sheet_users=array("chathurangad","beracut","nizzarm","sureshr","gayancha","kumuduv","gayanbu","udenim","samanthikaw","dulanjalik","ayomis","dinushag");
if(in_array($authorized,$has_permission))
{
	$sql11="SELECT order_col_des FROM $bai_pro3.bai_orders_db where order_del_no=\"$join_sch\"";
	//echo $sql."<br>";	
    $sql_result11=mysqli_query($link, $sql11) or exit("Sql Error898 $sql11".mysqli_error($GLOBALS["___mysqli_ston"]));
	$i=0;
	while($sql_row11=mysqli_fetch_array($sql_result11))	
	{		
		$color= $sql_row11['order_col_des'];
	}
}

echo "<br>";
if($job_color_status=="blue")
if(true)
{
	echo "<a class='btn btn-info btn-sm' href=\"../../../production/controllers/sewing_job/new_job_sheet3.php?jobno=$jobno&style=$style&schedule=$schedule&module=$module_no&section=$section&doc_no=$doc\" onclick=\"return popitup_new('../../../production/controllers/sewing_job/new_job_sheet3.php?jobno=$jobno&style=$style&schedule=$schedule&module=$module_no&section=$section&doc_no=$doc')\">Job Sheet</a><br>";
}
// $production_reviewss_sheet_users=array("chathurangad","dinushapre","buddhikam");
if(in_array($authorized,$has_permission))
{
	$sql11="SELECT order_col_des FROM $bai_pro3.bai_orders_db where order_del_no=\"$join_sch\"";
	//echo $sql."<br>";	
	$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error898 $sql11".mysqli_error($GLOBALS["___mysqli_ston"]));
	$i=0;
	while($sql_row11=mysqli_fetch_array($sql_result11))
	{
		$color= $sql_row11['order_col_des'];
	}
}
//end test link -------------------------------------------------------	

echo "<br>";

$balance_tot=0;
echo "<table class='table'>";
	echo "<tr>";
	echo "<th>TID</th>";
	echo "<th>Schedule </th>";
	echo "<th>Color </th>";
	echo "<th>Cut Job</th>";
	echo "<th>Input Job</th>";
	echo "<th>Destination</th>";
	echo "<th>Size</th>";
	echo "<th>Job Quantity</th>";
	// echo "<th>Issued Quantity</th>";
	// echo "<th>Balance to Issue Quantity</th>";
	// echo "<th>Allowed Quantity</th>";
	// echo "<th COLSPAN=2>Input Quantity</th>";
	//echo "<th>TID</th>";
	//echo "<th>Doc# Ref</th>";
	echo "</tr>";
	//echo $doc;
$sql="SELECT destination,cat_ref,acutno,order_del_no,doc_no,input_job_no,GROUP_CONCAT(DISTINCT tid ORDER BY tid) AS tid,GROUP_CONCAT(DISTINCT doc_no_ref ORDER BY doc_no) AS doc_no_ref,GROUP_CONCAT(DISTINCT size_code) AS size_code,GROUP_CONCAT(DISTINCT order_col_des) AS order_col_des,GROUP_CONCAT(DISTINCT CONCAT(acutno,'-',order_col_des,'-',size_code,'-',carton_act_qty) ORDER BY doc_no SEPARATOR '<br/>' ) AS a_cutno,SUM(carton_act_qty) AS carton_act_qty FROM (SELECT cat_ref,order_del_no,input_job_no,input_job_no_random,tid,doc_no,doc_no_ref,size_code,order_col_des,acutno,destination,SUM(carton_act_qty) AS carton_act_qty FROM $bai_pro3.packing_summary_input WHERE input_job_no_random='$doc' GROUP BY order_col_des,input_job_no_random,acutno,size_code,destination) AS t GROUP BY doc_no,size_code ORDER BY order_del_no,acutno,input_job_no";
//echo $sql."<br>";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));

	$i=0;
	while($sql_row=mysqli_fetch_array($sql_result))
	
	{
		
		/* LogicException
		balance to issue: allocated qty-inputqty
		allow only if
		cutqty-imsinputqty is grater or equal to than balance to issue
		*/

		$size_code_qry="select * from $bai_pro3.pac_stat_log_input_job where tid=".$sql_row['tid']."";
		//echo $size_code_qry."<br>";
		$size_code_res=mysqli_query($link, $size_code_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));				
		while($size_res=mysqli_fetch_array($size_code_res))
		{
			$size_code=$size_res['old_size'];
		}
		
		$cutqty=doc_in_status($link,'CUTQTY',$size_code,$sql_row['doc_no'],'');
		//echo  $sql_row['size_code']."<br>";
		$inputqty=doc_in_status($link,'INPUTQTY',$size_code,$sql_row['doc_no'],$doc);
		$imsinputqty=doc_in_status($link,'IMSINPUTQTY',$sql_row['size_code'],$sql_row['doc_no'],'');
		$balance=($sql_row['carton_act_qty']-$inputqty);
		$allowedqty=0;
	  // echo $cutqty."-".$inputqty."-".$imsinputqty."-".$sql_row['carton_act_qty']."<br>";
		$color_code=echo_title("$bai_pro3.bai_orders_db_confirm","color_code","order_col_des='".$sql_row['order_col_des']."' and order_del_no",$sql_row['order_del_no'],$link);
		if(($cutqty-$imsinputqty)>=$balance)
		{
			$allowedqty=$balance;
			
		}
		else
		{
			$allowedqty=$balance;
            //$allowedqty=($cutqty-$imsinputqty);
			
		}
		
		echo "<tr>";
		echo "<td>".$sql_row['tid']."</td>";
		echo "<input type=\"hidden\" name=\"pac_tid[]\" value=\"".$sql_row['tid']."\">";
		//echo "<td>".$sql_row['order_del_no']."</td>";
		echo "<td><input type=\"hidden\" name=\"order_del_no[]\" value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</td>";
		echo "<td><input type=\"hidden\" name=\"input_color[]\" value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</td>";
		echo "<td><input type=\"hidden\" name=\"input_cat_ref[]\" value=\"".$sql_row['cat_ref']."\"><input type=\"hidden\" name=\"input_cut_no_ref[]\" value=\"".$sql_row['acutno']."\"><input type=\"hidden\" name=\"input_doc_no[]\" value=\"".$sql_row['doc_no']."\">".chr($color_code).leading_zeros($sql_row['acutno'],3)."</td>";
		echo "<td><input type=\"hidden\" name=\"input_job_no_ref[]\" value=\"".$sql_row['input_job_no']."\">".$sql_row['input_job_no']."</td>";
		//echo "<td>".$sql_row['destination']."</td>";
		echo "<td><input type=\"hidden\" name=\"destination[]\" value=\"".$sql_row['destination']."\">".$sql_row['destination']."</td>";
		echo "<td><input type=\"hidden\" name=\"input_size[]\" value=\"".$sql_row['size_code']."\">".strtoupper($sql_row['size_code'])."</td>";
		echo "<td>".$sql_row['carton_act_qty']."</td>";
		// echo "<td>".$inputqty."</td>";
		// echo "<td>".$balance."</td>";
	
		// echo "<td><input type=\"hidden\" name='allowed' id='allowedq$i' value='$allowedqty'>".$allowedqty."</td>";
		// if(in_array($username,$input_update_users))
		// {
		// 	echo "<td><input type=\"text\" class=\"float\" onkeypress=\"return pop_test()\" name=\"input_qty[]\" id='inputq$i' $textbox_disable value=\"$balance\" onkeyup='displayname()' ></td>";
		// }
		// else
		// {
		// 	echo "<td><input type=\"text\" class=\"float\" name=\"input_qty[]\" $textbox_disable value=\"0\" ></td>";
		// }
		
		// echo "<td style='background-color:#FFFFFF' id='demo$i'>  </td>";
		// echo "</tr>";
		
		// $i++;
		// $balance_tot=$balance_tot+$balance;   //Total balance qty in selected Input Job#  - 03-11-2014  - ChathurangaD
	}
	echo "</table>";
	//echo $balance_tot;
?>

<table>
<tr>
<th>Trims Status</th>
<td>
<div class="form-inline">
<div class="form-group">
<?php
$sql4="select input_trims_status as t_status from $table_name where input_job_no_random_ref='$doc'";
$result4=mysqli_query($link, $sql4) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row4=mysqli_fetch_array($result4))
{
	$t_status=$row4["t_status"];
}

$status=array("","Under Transit","Stock In Pool","Partial Issued","Issued To Module");

echo "<input type=\"hidden\" name=\"doc\" value=\"$doc\" />";
echo "<input type=\"hidden\" name=\"section\" value=\"$section\" />";
echo "<input type=\"hidden\" name=\"style\" value=\"$style\" />";
echo "<input type=\"hidden\" name=\"schedule\" value=\"$schedule\" />";
echo "<input type=\"hidden\" name=\"jobno\" value=\"$jobno\" />";
echo "<input type=\"hidden\" name=\"moduleno\" value=\"$module_no\" />";
echo "<select name=\"status\" class=\"form-control\" $dropdown_disable>";
if(in_array($authorized,$has_permission))
{
		for($i=0;$i<sizeof($status);$i++)
		{	
			if($trims_statusx == $i)
			{
				echo "<option value=\"$i\" selected>".$status[$i]."</option>";
			}
			else
			{
				echo "<option value=\"$i\">".$status[$i]."</option>";
			}
			//echo "sa =" .$sta."<br>";
		}
		echo "</select>";
		$pvalue=$_POST['status'];
//		echo "pres value=".$pvalue;
}
else
{
		for($i=$t_status;$i<sizeof($status);$i++)
		{	
			if($trims_statusx == $i)
			{
				echo "<option value=\"$i\" selected>".$status[$i]."</option>";
			}
			else
			{
				echo "<option value=\"$i\">".$status[$i]."</option>";
			}
			//echo "sa =" .$sta."<br>";
		}
		echo "</select>";
		$pvalue=$_POST['status'];
//		echo "pres value=".$pvalue;
	
}
echo "</td>";
?>
</div>
</div>
<?php
$checkCount=0;
$sqlcheck="select * from $bai_pro3.plan_dashboard_input where input_trims_status in ('3','4') and input_job_no_random_ref=\"".$doc."\"";
$resultcheck=mysqli_query($link, $sqlcheck) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row4=mysqli_fetch_array($resultcheck))
{
	$checkCount++;
}

// To take number of JOBs in IMS dashboard
$sqlcheckims="SELECT COUNT(DISTINCT input_job_rand_no_ref) AS Job_Count FROM $bai_pro3.ims_log WHERE ims_mod_no=\"$module_no\"";
//echo $sqlcheckims; 
//$sqlcheckims="SELECT COUNT(DISTINCT input_job_no_random_ref) AS Job_Count FROM bai_pro3.plan_dash_doc_summ_input WHERE (input_trims_status!=4 OR input_trims_status IS NULL OR input_panel_status!=2 OR input_panel_status IS NULL) AND input_module='$module_no'";
$resultcheckims=mysqli_query($link, $sqlcheckims) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row5=mysqli_fetch_array($resultcheckims))
{
	$no_of_ims_job=$row5["Job_Count"];
}

if($no_of_ims_job<3)
{	
 	// echo $checkCount;
	echo "<br/><div style=\"Color:Blue;font-size:18px;text-weight:bold;\">Total No of JOBs in module ".$module_no." are ".$no_of_ims_job."</div><br/>";
	echo "<br/><div style=\"Color:Blue;font-size:16px;text-weight:bold;\">".$display_job_color_statusdisplay_job_color_status."</div><br/>";
	if($checkCount>0)
	//if(true)
	{
		//if($job_color_status=="blue")
		if(true)
		{
		//echo '<td><input type="submit" name="submit" value="Submit" id="sub" /></td>';
			?>
			<td><input type="hidden" name="submit" class="btn btn-primary" value="Submit" id="sub" onclick="document.getElementById('sub').style.display='none'; document.getElementById('msg').style.display='';"></td>
			
			<?php
		}
		else
		{
			echo '<td></td>';
		}
	}
	else
	{
		echo '<td></td>';
	}
}
else
{	//echo 'test';
	echo "<br/><div style=\"Color:red;font-size:18px;text-weight:bold;\">Total No of JOBs in module: ".$module_no." are ".$no_of_ims_job."</div><br/>";
	echo "<br/><div style=\"Color:red;font-size:16px;text-weight:bold;\">".$display_job_color_status."</div><br/>";
	if(in_array($authorized,$has_permission))
	{
		if($no_of_ims_job<4)
		{
			//if($checkCount>0)
			if(true)
			{
				if($job_color_status=="blue")
				//if(true)
				{
					//echo '<td><input type="submit" name="submit" value="Submit" id="sub"/></td>';
					?>
			<td><input type="submit" name="submit" class="btn btn-primary" value="Submit" id="sub" onclick="document.getElementById('sub').style.display='none'; document.getElementById('msg').style.display='';"></td>
			
			<?php
				}
				else
				{
					echo '<td></td>';
				}
			}
			else
			{
				echo '<td></td>';
			}
		}
	}
	else if(in_array($authorized,$has_permission))
	{
		
			if($checkCount>0)
			//if(true)
			{
				if($job_color_status=="blue")
				//if(true)
				{
					//echo '<td><input type="submit" name="submit" value="Submit" id="sub" /></td>';
					?>
			<td><input type="submit" name="submit" value="Submit" class="btn btn-primary" id="sub" onclick="document.getElementById('sub').style.display='none'; document.getElementById('msg').style.display='';"></td>
			
			<?php
				}
				else
				{
					echo '<td></td>';
				}
			}
			else
			{
				echo '<td></td>';
			}
		
	}
	else
	
	{
		echo '<td></td>';
	}
	
	
}

echo "</tr></table>";
?>
</form>
<span id="msg" style="display:none;"><h1><font color="Blue">Please wait while updating the Input Quantities into IMS...</font></h1></span>
<?php

if(isset($_POST["submit"]))
{
	$pac_tid=$_POST["pac_tid"];
	$order_del_no=$_POST["order_del_no"];
	$destination=$_POST["destination"];
	$up_status=$_POST["status"];
	$doc_ref_job=$_POST["doc"];
	$section_sec=$_POST["section"];
	$style_code=$_POST["style"];
	$schedule_code=$_POST["schedule"];
	$color_code=$_POST["input_color"];
	$input_qty=$_POST["input_qty"];
	$cat_ref=$_POST["input_cat_ref"];
	$doc_ref=$_POST["input_doc_no"];
	$jobno_code=$jobno;
	$module_ref=$_POST["moduleno"];
	$size_ref=$_POST["input_size"];
	$input_qty_tot=0;
	$input_job_no_ref=$_POST['input_job_no_ref'];
	$cut_no_ref=$_POST['input_cut_no_ref'];
	
	$input_module=$module_ref;
	$job_no="J".leading_zeros($jobno_code, 3);
	
	$sql_in_ex="select * from $bai_pro3.ims_log where ims_schedule=\"$order_del_no[0]\" and input_job_no_ref=\"$input_job_no_ref[0]\" and input_job_rand_no_ref=\"$doc_ref_job\"";
	$result_in_ex=mysqli_query($link, $sql_in_ex) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	//if(mysqli_num_rows($result_in_ex) == 0)
	{
	
		for($j=0;$j<sizeof($input_qty);$j++)
		{
			if($input_qty[$j] > 0)
			{
				$input_qty_tot=$input_qty_tot+$input_qty[$j];
			
				$size_code_qry="select * from $bai_pro3.pac_stat_log_input_job where tid=$pac_tid[$j]";
				//echo $size_code_qry."<br>";
				$size_code_res=mysqli_query($link, $size_code_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));				
				while($size_res=mysqli_fetch_array($size_code_res))
				{
					$size_code=$size_res['old_size'];
				}
				
				$sql1="insert into $bai_pro3.ims_log(ims_date,ims_cid,ims_doc_no,ims_mod_no,ims_shift,ims_size,ims_qty,ims_style,ims_schedule,ims_color,rand_track,input_job_rand_no_ref,input_job_no_ref,destination,pac_tid) values('".date("Y-m-d")."','".$cat_ref[$j]."','".$doc_ref[$j]."','".$module_ref."','A','a_".$size_code."','".$input_qty[$j]."','".$style_code."','".$order_del_no[$j]."','".$color_code[$j]."','".$doc_ref_job."','".$doc_ref_job."','".$input_job_no_ref[$j]."','".$destination[$j]."','".$pac_tid[$j]."')";

				//echo $sql1."<br>";
				mysqli_query($link, $sql1) OR die("Error=".$sql1."-".mysqli_error($GLOBALS["___mysqli_ston"]));
				//To update in M3 BULK OR
				$inserid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
				
				if($input_module=="-1")
				{
					if(m3_validate_ims($inserid,$link,$style_code,$order_del_no[$j],$color_code[$j],$size_ref[$j],$doc_ref[$j],$input_qty[$j],'PS')==0)
					{
						$sql="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no) values (NOW(),'$style_code','$order_del_no[$j]','$color_code[$j]',REPLACE('".$size_ref[$j]."','a_',''),$doc_ref[$j],".$input_qty[$j].",USER(),'PS',$inserid,'$input_module','A','$job_no')";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
					}
				}
				else
				{
					if($input_module=="0" and $input_remarks=="EMB")
					{
						if(m3_validate_ims($inserid,$link,$style_code,$order_del_no[$j],$color_code[$j],$size_ref[$j],$doc_ref[$j],$input_qty[$j],'PS')==0)
						{
							$sql="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no) values (NOW(),'$style_code','$order_del_no[$j]','$color_code[$j]',REPLACE('".$size_ref[$j]."','a_',''),$doc_ref[$j],".$input_qty[$j].",USER(),'PS',$inserid,'$input_module','A','$job_no')";
							mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
					}
					else
					{
						if(m3_validate_ims($inserid,$link,$style_code,$order_del_no[$j],$color_code[$j],$size_ref[$j],$doc_ref[$j],$input_qty[$j],'SIN')==0 and $input_module>0)
						{
							$sql="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no) values (NOW(),'$style_code','$order_del_no[$j]','$color_code[$j]',REPLACE('".$size_ref[$j]."','a_',''),$doc_ref[$j],".$input_qty[$j].",USER(),'SIN',$inserid,'$input_module','A','$job_no')";
							
							if($input_remarks=="SAMPLE")
							{
								$sql="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no) values (NOW(),'$style_code','$order_del_no[$j]','$color_code[$j]',REPLACE('".$size_ref[$j]."','a_',''),$doc_ref[$j],".$input_qty[$j].",USER(),'SIN',$inserid,'$input_module','A','SAMPLE')";
							}
							
							mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
					}
					
				}
		
				
				// Start - Input logs for temp table -ChathurangaD			
				$sql123="INSERT INTO $bai_pro3.temp_line_input_log (`schedule_no`, `style`, `input_job_no`, `username`, `date_n_time`, `page_name`	) VALUES
				('".$order_del_no[$j]."','".$style_code."','".$input_job_no_ref[$j]."','".$username."','".date("Y-m-d H:i:s")."','line Input')";

				//echo $sql123."<br>";
				mysqli_query($link, $sql123) OR die("Error=".$sql123."-".mysqli_error($GLOBALS["___mysqli_ston"]));
						
				// END - Input logs for temp table -ChathurangaD
				
				$ims_in=0;
				$ims_in1=0;
				
				$sql_pac="select sum(carton_act_qty) as qty,order_joins as orderjoin,SUBSTRING_INDEX(order_joins,'J',-1) AS order_joins from $bai_pro3.packing_summary_input where doc_no=\"".$doc_ref[$j]."\"";
				//echo $sql_pac."<br>";
				$result_pac=mysqli_query($link, $sql_pac) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));				
				while($row_pac=mysqli_fetch_array($result_pac))
				{
					$ims_pac=$row_pac["qty"];
					$clubbed_sch=$row_pac["orderjoin"];
					$clubbed_sch_ref=$row_pac["order_joins"];
				}
				//echo $clubbed_sch_ref."<br>";
				$docket_no_ref=$doc_ref[$j];
				
				if($clubbed_sch_ref>0)
				{
					$sql_pac1="select sum(carton_act_qty) as qty,group_concat(distinct doc_no) as doc_no from $bai_pro3.packing_summary_input where order_joins=\"".$clubbed_sch."\" and acutno=\"".$cut_no_ref[$j]."\"";
					//echo $sql_pac1."<br>";
					$result_pac1=mysqli_query($link, $sql_pac1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));				
					while($row_pac1=mysqli_fetch_array($result_pac1))
					{
						$ims_pac=$row_pac1["qty"];
						$docket_no_ref=$row_pac1["doc_no"];
					}
				}	
				
				$sql_in_if="select * from $bai_pro3.ims_log where ims_doc_no in (".$docket_no_ref.")";
				//echo $sql_in_if."<br>";
				$result_in_if=mysqli_query($link, $sql_in_if) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($result_in_if) > 0)
				{
					$sql_in="select sum(ims_qty) as inp from $bai_pro3.ims_log where ims_doc_no in (".$docket_no_ref.")";
					$result_in=mysqli_query($link, $sql_in) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));				
					while($row_in=mysqli_fetch_array($result_in))
					{
						$ims_in=$row_in["inp"];
					}				
				}
				else
				{
					$ims_in=0;
				}
				
				$sql_in_if1="select * from $bai_pro3.ims_log_backup where ims_doc_no in (".$docket_no_ref.")";
				$result_in_if1=mysqli_query($link, $sql_in_if1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($result_in_if1) > 0)
				{
					$sql_in1="select sum(ims_qty) as inp from $bai_pro3.ims_log where ims_doc_no in (".$docket_no_ref.")";
					$result_in1=mysqli_query($link, $sql_in1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));				
					while($row_in1=mysqli_fetch_array($result_in1))
					{
						$ims_in1=$row_in1["inp"];
					}				
				}
				else
				{
					$ims_in1=0;
				}	
				
				//echo "Pac=".$ims_pac."<br>Inp=".$ims_in."-".$ims_in1."-".($ims_in+$ims_in1)."<br>";
				
				if($ims_pac==($ims_in+$ims_in1))
				{
					$sql_up="update $bai_pro3.plandoc_stat_log set act_cut_status=\"DONE\",act_cut_issue_status=\"DONE\" where doc_no in (".$doc_ref[$j].")";
					//echo $sql_up."<br>";
					mysqli_query($link, $sql_up) OR die("Error=".$sql_up."-".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					if($clubbed_sch_ref > 0)
					{
						$sql_up1="update $bai_pro3.plandoc_stat_log set act_cut_status=\"DONE\",act_cut_issue_status=\"DONE\" where order_tid like \"% ".$clubbed_sch_ref."%\" and acutno=\"".$cut_no_ref[$j]."\"";
						//echo $sql_up1."<br>";
						mysqli_query($link, $sql_up1) OR die("Error=".$sql_up1."-".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}
				
			}
		}

		if(($balance_tot-$input_qty_tot)==0)
		{
			$sql5="update $table_name set input_panel_status=\"2\" where input_job_no_random_ref=\"".$doc."\"";
			//echo $sql5;
			mysqli_query($link, $sql5);
		}	
	}
	// else
	// {
	//   echo "<h1><font color='RED'>Input Quantities Already Updated in IMS...</font></h1>";
	// }
	echo "<script type=\"text/javascript\"> window.close(); </script>";	
}

?>
		
<!--  Validation Part Added Hasithada    30/11/2016  -->		
<script>
function displayname() {

 for (i = 0; i < 8; i++) {
 var a="inputq"+i;
 var b="allowedq"+i;
 var c="demo"+i;
var x=document.getElementById(a).value;
var y=document.getElementById(b).value;
x1=parseFloat(x);
y1=parseFloat(y);
if(x1 >= 0)
{
	if(y1==x1){
	//document.getElementById("sub").disabled = false; 
	document.getElementById(c).innerHTML = "";
	document.getElementById(c).style.backgroundColor = "#eeeeee";
	
	}
	else if(y1>x1){
	document.getElementById(c).innerHTML = "";
	document.getElementById(c).style.backgroundColor = "#eeeeee";
	document.getElementById("sub").disabled = false; 
	
	}else if(y1<x1){
	document.getElementById(c).style.backgroundColor = "red";
	document.getElementById(c).innerHTML = "over quantity";
	
	document.getElementById("sub").disabled = true; 
	
	}
}
else
{
	document.getElementById(c).style.backgroundColor = "red";
	document.getElementById(c).innerHTML = "Negative Quantity Not Accepted";	
	document.getElementById("sub").disabled = true; 
}

}



}

</script>
</body>
</html>
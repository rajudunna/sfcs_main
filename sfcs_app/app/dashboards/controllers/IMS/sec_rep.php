<head>
	<link rel="stylesheet" type="text/css" href="../../../../common/css/bootstrap.min.css">
	<title></title>
</head>
<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');
$php_self = explode('/',$_SERVER['PHP_SELF']);
array_pop($php_self);
$url_r = base64_encode(implode('/',$php_self)."/sec_rep.php");
$has_permission=haspermission($url_r);
error_reporting(0);
?>
<?php
//To find time days difference between two dates

function dateDiff($start, $end) {

$start_ts = strtotime($start);

$end_ts = strtotime($end);

$diff = $end_ts - $start_ts;

return round($diff / 86400);

}

function dateDiffsql($link,$start,$end)
{
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); 
	$sql="select distinct bac_date from $bai_pro.bai_log_buf where bac_date<='$start' and bac_date>='$end'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	return mysqli_num_rows($sql_result);
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Section IMS Report</title>
<style>
	body{ font-family:calibri; }
</style>

<style>

a {text-decoration: none;}

.atip
{
	color:black;
}

table
{
	border-collapse:collapse;
}
.new td
{
	border: 1px solid #337ab7;
	white-space:nowrap;
	border-collapse:collapse;
}

.new th
{
	border: 1px solid #337ab7;
	white-space:nowrap;
	border-collapse:collapse;
}

.bottom
{
	border-bottom: 3px solid white;
	padding-bottom: 5px;
	padding-top: 5px;
}

.panel-heading
{
	text-align:center;
	border-bottom: 3px solid black;
}


select{
    margin-top: 16px;
	margin-right: 5px;
}

.panel-primary{
	margin-right: -50px;
}

</style>

<script type="text/javascript" src="../../../../common/js/jquery.js"></script> 

<script>

function update_comm(x)
{
	var valu=document.getElementById("M"+x).innerHTML;
	document.getElementById("M"+x).style.display="none";
	document.getElementById("I"+x).style.display="";
	document.getElementById("I"+x).innerHTML="<input type='text' value='"+valu+"' id='"+x+"' onblur='update_fin("+x+");' style='border:none; background-color: yellow; width:100%'>";
	document.getElementById(x).focus();
}

function update_fin(x)
{
	var val=document.getElementById(x).value;
	document.getElementById("I"+x).style.display="none";
	document.getElementById("M"+x).style.display="";
	document.getElementById("M"+x).innerHTML="<img src='saving.gif'>";
	
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var result=xmlhttp.responseText;
			if(result!=0)
			{
				document.getElementById("M"+x).innerHTML="<font color='red'>Failed</font>";				
			}
		}
	}

	xmlhttp.open("GET","ajax_save.php?tid="+x+"&val="+val+"&rand="+Math.random(),true);
	xmlhttp.send();
	document.getElementById("M"+x).innerHTML=val;
}

</script>

</head>

<body>


<?php

//To update onscreen comments update
if(isset($_GET['val']))
{
	$tid=$_GET['tid'];
	$val=$_GET['val'];
	return 0;
}

?>

<?php	 
		if(isset($_POST['submit']))
		{
			$input_selection=$_POST['input_selection'];
			if($input_selection=='bundle_wise'){
				$bundlenum_header="<th>Bundle No</th>";
				$report_header="BundleWise";
			}else{
				$bundlenum_header="";
				$report_header="Sewing Job Wise";
			}
			
		}else{
			$bundlenum_header="<th>Bundle No</th>";
			$report_header="BundleWise";
		}

		$section=$_GET['section'];
		echo "<div class='panel panel-primary'>";
		echo "<div class='panel-heading'>Summary of <b>SECTION -" .$section." ( ".$report_header." )</b></div>";
		echo "</br>";
		echo "<table>
		<tr>
		<th>Select Your Choice : </th>
		<td>
		<div class='form-inline'>
		<div class='form-group'>";

		echo "<form method='post'>";
		echo "<select name='input_selection' id='input_selection' class=\"form-control\">";
		echo "<option value='bundle_wise' selected>Bundle Wise</option>";	
		echo "<option value='input_wise'>Sewing Job Wise</option>";
		echo "</select>";
		echo "</td>";

		echo "</div></div>";

		echo '<td><input type="submit" id="submit" class="btn btn-primary" name="submit" value="Submit" /></td>';
		echo "</tr></table>";

		echo "</form>";

		echo "<div class='panel-body'>";
		$sql="SELECT GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` WHERE section=$section GROUP BY section ORDER BY section + 0";
		// echo $sql;
		//mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$sec_mods=$sql_row['sec_mods'];
		}
		
		$modules=array();
		$modules=explode(",",$sec_mods);
		echo '<div><table style="color:black; border: 1px solid #337ab7;" class="table table-bordered">';
		echo "<tr class=\"new\" style='background-color:#337ab7'><th>Module</th>";
		echo $bundlenum_header;
		//echo "<th>CID</th><th>DOC#</th>";
		echo "<th>Style</th><th>Schedule</th><th>Color</th><th>Input Job No</th><th>Cut No</th><th>Size</th><th>Input</th><th>Output</th><th>Rejected</th><th>Balance</th><th>Input Remarks</th><th>Ex-Factory</th><th width='150'>Remarks</th><th>Age</th><th>WIP</th></tr>";
		
		$toggle=0;
		$j=1;
		for($i=0; $i<sizeof($modules); $i++)
		{
		
		$module_ref=$modules[$i];
		$rowcount_check=0;

			$sql12="select sum(ims_qty-ims_pro_qty) as balance, count(*) as count from $bai_pro3.ims_log where ims_mod_no='$module_ref' and ims_status<>'DONE' and ims_doc_no in (select doc_no from bai_pro3.plandoc_stat_log)";
			if(isset($_POST['submit']))
			{
				$input_selection=$_POST['input_selection'];
				if($input_selection=='input_wise'){
					$sql12.=" GROUP BY input_job_rand_no_ref,ims_size,rand_track ";
				}

				if($input_selection=='bundle_wise'){
					$sql12.=" GROUP BY pac_tid ";
				}
				
			}else{
				$sql12.=" GROUP BY pac_tid ";
			}
			//echo "</br>For Count : ".$sql12."</br>";
			//mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=0;
			$balance=0;
			while($sql_row12=mysqli_fetch_array($sql_result12))
			{
				$balance=$balance+$sql_row12['balance'];
				$sql_num_check=$sql_num_check+1;
			}
			//echo "</br>num : ".$sql_num_check."</br>";
			
			if($sql_num_check>0)
			{
				if($toggle==0)
				{
					$tr_color="#66DDAA";
					$toggle=1;
				}
				else if($toggle==1)
				{
					$tr_color="white";
					$toggle=0;
				}
				echo "<tr bgcolor=\"$tr_color\" class=\"new\"><td rowspan=$sql_num_check>$module_ref</td>";
				$rowcount_check=1;
			}
		
		$sql="select distinct input_job_rand_no_ref,rand_track from $bai_pro3.ims_log where ims_mod_no='$module_ref'  and ims_status<>'DONE' and ims_doc_no in (select doc_no from bai_pro3.plandoc_stat_log) order by ims_doc_no";
		//mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$rand_track=$sql_row['rand_track'];
			$input_job_rand_no_ref=$sql_row['input_job_rand_no_ref'];
			
			$sql12="select ims_date,ims_cid,ims_doc_no,ims_mod_no,ims_shift,ims_size,sum(ims_qty) as ims_qty,sum(ims_pro_qty) as ims_pro_qty,ims_status,bai_pro_ref,ims_log_date,ims_remarks,ims_style,ims_schedule,ims_color,tid,rand_track,team_comm,input_job_rand_no_ref,destination,pac_tid,operation_id,input_job_no_ref from $bai_pro3.ims_log where ims_mod_no=$module_ref and input_job_rand_no_ref='$input_job_rand_no_ref' and rand_track=$rand_track  and ims_status<>'DONE'";

			//getting selection and apend result to query
			if(isset($_POST['submit']))
			{
				$input_selection=$_POST['input_selection'];
				if($input_selection=='input_wise'){
					$sql12.=" GROUP BY input_job_rand_no_ref,ims_size,rand_track ";
				}

				if($input_selection=='bundle_wise'){
					$sql12.=" GROUP BY pac_tid ";
				}
				
			}else{
				$sql12.=" GROUP BY pac_tid ";
			}  

			$sql12.="  order by ims_schedule, ims_size DESC";
			//echo "</br>For Details : ".$sql12."</br>";
			
			$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row12=mysqli_fetch_array($sql_result12))
			{
				
				$ims_schedule=$sql_row12['ims_schedule'];
				$ims_style=$sql_row12['ims_style'];
				$ims_color=$sql_row12['ims_color'];
				$ims_doc_no=$sql_row12['ims_doc_no'];
				$ims_size=$sql_row12['ims_size'];
				$ims_size2=substr($ims_size,2);
				$inputjobno=$sql_row12['input_job_no_ref'];
				$ims_remarks=$sql_row12['ims_remarks'];
				$pac_tid=$sql_row12['pac_tid'];
				$display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$ims_schedule,$ims_color,$inputjobno,$link);
				//echo "Hello".$display_prefix1;
				$sql22="select * from $bai_pro3.plandoc_stat_log where doc_no=$ims_doc_no and a_plies>0";
				$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				while($sql_row22=mysqli_fetch_array($sql_result22))
				{
					$order_tid=$sql_row22['order_tid'];
					
					$sql33="select color_code,order_date from $bai_pro3.bai_orders_db_confirm where order_tid='$order_tid'";
					mysqli_query($link, $sql33) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row33=mysqli_fetch_array($sql_result33))
					{
						$color_code=$sql_row33['color_code']; //Color Code
						$ex_factory=$sql_row33['order_date'];
					}
					$cutno=$sql_row22['acutno'];
				}
	
				$size_value=ims_sizes($order_tid,$ims_schedule,$ims_style,$ims_color,$ims_size2,$link);

				$sql33="select style_id from $bai_pro2.movex_styles where movex_style like \"%".$sql_row12['ims_style']."%\"";
				$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row33=mysqli_fetch_array($sql_result33))
				{
					$user_style=$sql_row33['style_id']; //Color Code
				}				
				
				$rejected=0;
				$good_garments=0;
				$sql33="select COALESCE(SUM(IF(qms_tran_type=3,qms_qty,0)),0) AS rejected, COALESCE(SUM(IF(qms_tran_type=5,qms_qty,0)),0) AS good_garments from $bai_pro3.bai_qms_db where qms_schedule='".$sql_row12['ims_schedule']."' and qms_color='".$sql_row12['ims_color']."' and qms_size='".strtoupper($size_value)."' and qms_style='".$sql_row12['ims_style']."' and input_job_no='".$sql_row12['input_job_rand_no_ref']."' and qms_remarks='".$sql_row12['ims_remarks']."'and operation_id=130 ";

				//getting selection and apend result to query
				if(isset($_POST['submit']))
				{
					$input_selection=$_POST['input_selection'];
					if($input_selection=='input_wise'){
					$sql33.=" GROUP BY input_job_no,qms_size ";
					}

					if($input_selection=='bundle_wise'){
					$sql33.=" and bundle_no=".$sql_row12['pac_tid'];
					}
				}else{
					$sql33.=" and bundle_no=".$sql_row12['pac_tid'];
				}
				
				//mysqli_query($link, $sql33) or exit("Sql Error".$sql33.mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row33=mysqli_fetch_array($sql_result33))
				{
					$rejected=$sql_row33['rejected']; 
					$good_garments=$sql_row33['good_garments']; 
				}
				
				
				
				//Ex-Factory
				$sql33="select ex_factory from $m3_inputs.shipment_plan where schedule_no='".$sql_row12['ims_schedule']."'";
				$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error7 =$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row33=mysqli_fetch_array($sql_result33))
				{
					$ex_factory=$sql_row33['ex_factory'];
				}
				
				$quality_log_row="";
				$quality_log_row="<td>".$sql_row12['ims_remarks']."</td><td>$ex_factory</td>";
				
				
				if($rowcount_check==1)
				{	
					if(isset($_POST['submit']))
					{
						$input_selection=$_POST['input_selection'];
						if($input_selection=='bundle_wise'){
							echo "<td>".$sql_row12['pac_tid']."</td>";
						}

					}else{
						echo "<td>".$sql_row12['pac_tid']."</td>";
					}
					//echo "<td>".$sql_row12['ims_cid']."</td><td>".$sql_row12['ims_doc_no']."</td>";
					echo "<td>".$sql_row12['ims_style']."</td><td>".$sql_row12['ims_schedule']."</td><td>".$sql_row12['ims_color']."</td><td>".$display_prefix1."</td><td>".chr($color_code).leading_zeros($cutno,3)."</td><td>".strtoupper($size_value)."</td><td>".$sql_row12['ims_qty']."</td><td>".$sql_row12['ims_pro_qty']."</td><td>$rejected</td>";				
					echo "<td>".($sql_row12['ims_qty']-($sql_row12['ims_pro_qty']+$rejected))."</td>";
					//echo "<td>".($sql_row12['ims_qty']-($sql_row12['ims_pro_qty']))."</td>";
					echo $quality_log_row;
					if(in_array($edit,$has_permission))
					{
						echo "<td><span id='I".$sql_row12['tid']."'></span><span id='M".$sql_row12['tid']."' style='width:100%' onclick='update_comm(".$sql_row12['tid'].");'>".$sql_row12['team_comm']."</span></td><td>".dateDiffsql($link,date("Y-m-d"),$sql_row12['ims_date'])."</td>";
					}
					else
					{
						echo "<td>".$sql_row12['team_comm']."</td><td>".dateDiffsql($link,date("Y-m-d"),$sql_row12['ims_date'])."</td>";
					}
					if($rowcount_check==1)
					{
						echo "<td rowspan=$sql_num_check>$balance</td>";						
					}
					$rowcount_check=0;
					
					
				}
				else
				{	
					if(isset($_POST['submit']))
					{
						$input_selection=$_POST['input_selection'];
						if($input_selection=='bundle_wise'){
							echo "<tr bgcolor=\"$tr_color\" class=\"new\"><td>".$sql_row12['pac_tid']."</td>";
							echo "<td>".$sql_row12['ims_style']."</td>";
						}
						if($input_selection=='input_wise'){
							echo "<tr bgcolor=\"$tr_color\" class=\"new\"><td>".$sql_row12['ims_style']."</td>";
						}

					}else{
						echo "<tr bgcolor=\"$tr_color\" class=\"new\"><td>".$sql_row12['pac_tid']."</td>";
						echo "<td>".$sql_row12['ims_style']."</td>";
					}
					//echo "<td>".$sql_row12['ims_cid']."</td><td>".$sql_row12['ims_doc_no']."</td>";
					echo"<td>".$sql_row12['ims_schedule']."</td><td>".$sql_row12['ims_color']."</td><td>".$display_prefix1."</td><td>".chr($color_code).leading_zeros($cutno,3)."</td><td>".strtoupper($size_value)."</td><td>".$sql_row12['ims_qty']."</td><td>".$sql_row12['ims_pro_qty']."</td><td>$rejected</td>";
					echo "<td>".($sql_row12['ims_qty']-($sql_row12['ims_pro_qty']+$rejected))."</td>";
					//echo "<td>".($sql_row12['ims_qty']-($sql_row12['ims_pro_qty']))."</td>";
					echo $quality_log_row;
				
					if(in_array($edit,$haspermission))
					{
						echo "<td><span id='I".$sql_row12['tid']."'></span><span id='M".$sql_row12['tid']."' style='width:100%' onclick='update_comm(".$sql_row12['tid'].");'>".$sql_row12['team_comm']."</span></td><td>".dateDiffsql($link,date("Y-m-d"),$sql_row12['ims_date'])."</td>";
					}
					else
					{
						echo "<td>".$sql_row12['team_comm']."</td><td>".dateDiffsql($link,date("Y-m-d"),$sql_row12['ims_date'])."</td>";
					}
				}
				
				// For module status updation
				
				
				
				// For module status updation
				echo "</tr>";
				$j++;
				
				
			}
				
		}
	
		}
		echo "</table></div></div>";
?>


</body>
</html>

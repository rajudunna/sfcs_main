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
				$bundlenum_header="<th rowspan=2>Bundle No</th>";
				$report_header="BundleWise";
			}else{
				$bundlenum_header="";
				$report_header="Sewing Job Wise";
			}
			
		}
		else
		{
			$bundlenum_header="<th rowspan=2>Bundle No</th>";
			$report_header="BundleWise";
		}

		$section=$_GET['section'];

		$qry_section="SELECT section_display_name FROM sections_master WHERE sec_name=".$section;
		$qry_section_result=mysqli_query($link, $qry_section) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($qry_section_row=mysqli_fetch_array($qry_section_result))
		{
			$section_name=$qry_section_row['section_display_name'];
		}
		echo "<div class='panel panel-primary'>
				<div class='panel-heading'>Summary of <b>" .$section_name." ( ".$report_header." )</b>
				</div>
				</br>
				<table>
					<tr>
						<th>Select Your Choice : </th>
						<td>
							<div class='form-inline'>
								<form method='post'>
									<select name='input_selection' id='input_selection' class=\"form-control\">
										<option value='bundle_wise' selected>Bundle Wise</option>
										<option value='input_wise'>Sewing Job Wise</option>
									</select>
							</div></div>
						</td>";
						echo '
						<td>.
							<input type="submit" id="submit" class="btn btn-primary" name="submit" value="Submit" />
						</td>
					</tr>
				</table>';
		echo "</form>";

		echo "<div class='panel-body'>";
				$sql="SELECT GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` WHERE section=$section GROUP BY section ORDER BY section + 0";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$sec_mods=$sql_row['sec_mods'];
				}

				//To get sewing operations 
		        $sewing_master="select operation_code from $brandix_bts.tbl_orders_ops_ref where category ='sewing'";
		        $sql_result3=mysqli_query($link,$sewing_master) or exit("Sql Error_cut_master".mysqli_error());
				while($row=mysqli_fetch_array($sql_result3))
				{
					$operations[] = $row['operation_code'];
				}
				$sewing_operations = "'" . implode ( "', '", $operations) . "'";
				
				

				//To Get style
				$get_style="select DISTINCT(style) from $brandix_bts.bundle_creation_data where assigned_module in ($sec_mods) and operation_id in ($sewing_operations)";
				//echo $get_style;
				$style_result=mysqli_query($link, $get_style) or die("Error-".$get_style."-".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1=mysqli_fetch_array($style_result))
				{
				  $disStyle[]=$sql_row1['style'];
				}
				$styles = "'" . implode ( "', '", $disStyle ) . "'";

				//To get operations
				$get_operations_sql="select DISTINCT(operation_code) from $brandix_bts.tbl_style_ops_master where style in ($styles) and operation_code  in ($sewing_operations)";
				//echo $get_operations_sql;
				$ops_result=mysqli_query($link, $get_operations_sql) or die("Error-".$get_operations_sql."-".mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($row1=mysqli_fetch_array($ops_result))
				{
				  $operation_code[]=$row1['operation_code'];
				}
				$opertions = implode(',',$operation_code);

				$get_ops_query = "SELECT operation_name,operation_code FROM $brandix_bts.tbl_orders_ops_ref where operation_code in ($opertions)  ";
				//echo $get_ops_query;
				$ops_query_result=$link->query($get_ops_query);
				while ($row2 = $ops_query_result->fetch_assoc())
				{
				  $ops_get_code[$row2['operation_code']] = $row2['operation_name'];
				}
				$col_span = count($ops_get_code);

				$modules=array();
				$modules=explode(",",$sec_mods);
				echo "<div class='table-responsive'>
						<table class=\"table table-bordered\">
							<tr>
								<th rowspan=2>Module</th>";
								echo $bundlenum_header;
								echo "<th rowspan=2>Style</th>
								<th rowspan=2>Schedule</th>
								<th rowspan=2>Color</th>
								<th rowspan=2>Input Job No</th>
								<th rowspan=2>Cut No</th>
								<th rowspan=2>Size</th>
								<th rowspan=2>Input</th>
								<th rowspan=2>Output</th>
								<th colspan=$col_span style=text-align:center>Rejected Qty</th>
								<th rowspan=2>Balance</th>
								<th rowspan=2>Input Remarks</th>
								<th rowspan=2>Ex-Factory</th>
								<th width='150'>Remarks</th>
								<th>Age</th>
								<th>WIP</th>
							</tr>
							<tr>";             
								foreach ($operation_code as $op_code) 
								{
									if(strlen($ops_get_code[$op_code]) > 0)
									{
										echo "<th>$ops_get_code[$op_code]</th>";
									}
								}
							echo "</tr>";
		$toggle=0;
		$j=1;
		for($i=0; $i<sizeof($modules); $i++)
		{
			$module_ref=$modules[$i];
			$new_module = $module_ref;
			$rowcount_check=0;

			$sql12="select sum(send_qty-recevied_qty) as balance, count(*) as count from $brandix_bts.bundle_creation_data where assigned_module='$module_ref' and  send_qty > 0 and original_qty != recevied_qty";
			if(isset($_POST['submit']))
			{
				$input_selection=$_POST['input_selection'];
				if($input_selection=='input_wise'){
					$sql12.=" GROUP BY input_job_no_random_ref,size_title,operation_id ";
				}
				if($input_selection=='bundle_wise'){
					$sql12.=" GROUP BY bundle_number,operation_id ";
				}
			}
			else
			{
				$sql12.=" GROUP BY bundle_number,operation_id ";
			}
			$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=0;
			$balance=0;
			while($sql_row12=mysqli_fetch_array($sql_result12))
			{
			  $balance=$balance+$sql_row12['balance'];
			  $sql_num_check=$sql_num_check+1;
			}
			// echo "</br>num : ".$sql_num_check."</br>";
			
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
	
				//echo "<tr bgcolor=\"$tr_color\" class=\"new\"><td>$module_ref</td>";
				$rowcount_check=1;
			}

			//To get input operation
			$application='IPS';

			$scanning_query="select operation_name,operation_code from $brandix_bts.tbl_ims_ops where appilication='$application'";
			$scanning_result=mysqli_query($link, $scanning_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1111=mysqli_fetch_array($scanning_result))
			{
			  $operation_name=$sql_row1111['operation_name'];
			  $input_code=$sql_row1111['operation_code'];
			} 

			//To get output operation
			$application='IMS_OUT';

			$scanning_query1="select operation_name,operation_code from $brandix_bts.tbl_ims_ops where appilication='$application'";
			$scanning_result1=mysqli_query($link, $scanning_query1)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row111=mysqli_fetch_array($scanning_result1))
			{
			  $operation_name=$sql_row111['operation_name'];
			  $output_code=$sql_row111['operation_code'];
			}
			
		$row_counter = 0;
		$get_job="select distinct input_job_no_random_ref from $brandix_bts.bundle_creation_data where style in ($styles)  and original_qty != recevied_qty and  send_qty > 0 and operation_id in($input_code)";
		//echo $get_job;
		$sql_result=mysqli_query($link, $get_job) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$input_job=$sql_row['input_job_no_random_ref'];

			$get_details="select style,schedule,color,size_title,size_id,cut_number,input_job_no,bundle_number,remarks,docket_number,sum(if(operation_id = 100,recevied_qty,0)) as input,sum(if(operation_id = 130,recevied_qty,0)) as output From $brandix_bts.bundle_creation_data where assigned_module=$module_ref and input_job_no_random_ref = '$input_job' and operation_id in ($input_code,$output_code) and (recevied_qty >0 or rejected_qty >0) and original_qty != recevied_qty";	

			if(isset($_POST['submit']))
			{
				$input_selection=$_POST['input_selection'];
				if($input_selection=='input_wise'){
					$get_details.=" GROUP BY input_job_no_random_ref,size_title ";
				}

				if($input_selection=='bundle_wise'){
					$get_details.=" GROUP BY bundle_number ";
				}
			}else{
				$get_details.=" GROUP BY bundle_number ";
			}  
			$get_details.="  order by schedule, size_id DESC";
			//echo $get_details;
			$sql_result12=mysqli_query($link, $get_details) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row12=mysqli_fetch_array($sql_result12))
			{
				
                $style=$row12['style'];
                $schedule=$row12['schedule'];
                $color=$row12['color'];
                $bundle_number=$row12['bundle_number'];
                $cut_number=$row12['cut_number'];
				$size=$row12['size_id'];
				$size_title=$row12['size_title'];
                $remarks=$row12['remarks'];
				$docket=$row12['docket_number'];
				$job=$row12['input_job_no'];

                $display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$input_job,$link);


				$sql22="select * from $bai_pro3.plandoc_stat_log where doc_no=$docket and a_plies>0";
				//echo $sql22;
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
				}
	
				$rejected1=array();
				$rejected=array();
                $get_rejected_qty="select sum(rejected_qty) as rejected,operation_id from $brandix_bts.bundle_creation_data where assigned_module=$module_ref and input_job_no_random_ref = '$input_job'";
                //getting selection and apend result to query
				if(isset($_POST['submit']))
				{
					$input_selection=$_POST['input_selection'];
					if($input_selection=='input_wise'){
						$get_rejected_qty.=" GROUP BY input_job_no_random_ref,size_title,operation_id ";
					}

					if($input_selection=='bundle_wise'){
						$get_rejected_qty.=" and bundle_number= $bundle_number group by operation_id";
					}
				}else{
					$get_rejected_qty.=" and bundle_number= $bundle_number group by operation_id";
				}
				//echo  $get_rejected_qty;
				$sql_result33=mysqli_query($link, $get_rejected_qty) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row33=mysqli_fetch_array($sql_result33))
				{
					$rejected1[$sql_row33['operation_id']] = $sql_row33['rejected'];
					if($sql_row33['operation_id'] == $output_code)
					{
					 $rejected = $sql_row33['rejected'];
				    }
				}
				
                //Ex-Factory
				$get_exfactory="select ex_factory from $m3_inputs.shipment_plan where schedule_no=$schedule";
				$sql_result3=mysqli_query($link, $get_exfactory) or exit("Sql Error7 =$get_exfactory".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row33=mysqli_fetch_array($sql_result3))
				{
					$ex_factory=$row33['ex_factory'];
				}

				//To get Age from ims_log
				$get_detais_ims="select tid,team_comm,ims_date From $bai_pro3.ims_log where ims_mod_no=$module_ref and input_job_rand_no_ref='$input_job' and ims_status<>'DONE'";
				$sql_result31=mysqli_query($link, $get_detais_ims) or exit("Sql Error7111 =$get_detais_ims".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row32=mysqli_fetch_array($sql_result31))
				{
					$tid=$row32['tid'];
					$team_comm=$row32['team_comm'];
					$ims_date=$row32['ims_date'];
				}

				
				$quality_log_row="";
				$quality_log_row="<td>$remarks</td><td>$ex_factory</td>";
    
				if($rowcount_check==1)
				{	
					if($row_counter == 0)
						echo "<tr bgcolor=\"$tr_color\" class=\"new\">
						<td style='border-top:1.5pt solid #fff;'>$module_ref</td>";
					else 
						echo "<tr bgcolor=\"$tr_color\" class=\"new\"><td style='border-top:0px'></td>";
					
					// if($new_module == $old_module)
					//     echo "<td></td>";
					
					if(isset($_POST['submit']))
					{
						$input_selection=$_POST['input_selection'];
						if($input_selection=='bundle_wise'){
							echo "<td>$bundle_number</td>";
						}
					}else{
						echo "<td>$bundle_number</td>";
					}
					
					echo "<td>$style</td>
					<td>$schedule</td>
					<td>$color</td>
					<td>".$display_prefix1."</td>
					<td>".chr($color_code).leading_zeros($cut_number,3)."</td>
					<td>$size_title</td>
					<td>".$row12['input']."</td>
					<td>".$row12['output']."</td>";
				
					foreach ($operation_code as $key => $value) 
					{
						if(strlen($ops_get_code[$value]) > 0){
							if($rejected1[$value] == '')
								echo "<td>0</td>";
							else    
								echo"<td>".$rejected1[$value]."</td>";
						}
					}  
                          			
					echo "<td>".($row12['input']-($row12['output']+$rejected))."</td>";
					//echo "<td>".($sql_row12['ims_qty']-($sql_row12['ims_pro_qty']))."</td>";
					echo $quality_log_row;
					if(in_array($edit,$has_permission))
					{
						echo "<td><span id='I".$tid."'></span><span id='M".$tid."' style='width:100%' onclick='update_comm(".$tid.");'>".$team_comm."</span></td><td>".dateDiffsql($link,date("Y-m-d"),$ims_date)."</td>";
					}
					else
					{
						echo "<td>".$team_comm."</td><td>".dateDiffsql($link,date("Y-m-d"),$ims_date)."</td>";
					}
					if($rowcount_check==1)
					{
						echo "<td style='border-top:1.5pt solid #fff;'>$balance</td>";
					}
					$rowcount_check=0;
					$row_counter++;
					echo "</tr>";
				}
				else
				{	
					if($row_counter == 0)
						echo "<tr bgcolor=\"$tr_color\" class=\"new\"><td>$module_ref</td>";
					else 
						echo "<tr bgcolor=\"$tr_color\" class=\"new\"><td style='border-top:1px solid $tr_color;border-bottom:1px solid $tr_color;'></td>";
					$row_counter++;
					// if($new_module == $old_module)
				    //     echo "<td></td>";

					if(isset($_POST['submit']))
					{
						$input_selection=$_POST['input_selection'];
						if($input_selection=='bundle_wise'){
							echo "<td>$bundle_number</td>";
							echo "<td>$style</td>";
						}
						if($input_selection=='input_wise'){
							echo "<td>$style</td>";
						}
					}else{
						echo "<td>$bundle_number</td>";
						echo "<td>$style</td>";
					}
					echo"<td>$schedule</td>
					<td>$color</td>
					<td>".$display_prefix1."</td>
					<td>".chr($color_code).leading_zeros($cut_number,3)."</td>
					<td>$size_title</td>
					<td>".$row12['input']."</td>
					<td>".$row12['output']."</td>";
					foreach ($operation_code as $key => $value) 
					{
						if(strlen($ops_get_code[$value]) > 0){
							if($rejected1[$value] == '')
								echo "<td>0</td>";
							else    
								echo"<td>".$rejected1[$value]."</td>";
						}
					}  
					echo "<td>".($row12['input']-($row12['output']+$rejected))."</td>";
					//echo "<td>".($sql_row12['ims_qty']-($sql_row12['ims_pro_qty']))."</td>";
					echo $quality_log_row;
					if(in_array($edit,$has_permission))
					{
						echo "<td><span id='I".$tid."'></span><span id='M".$tid."' style='width:100%' onclick='update_comm(".$tid.");'>".$team_comm."</span></td><td>".dateDiffsql($link,date("Y-m-d"),$ims_date)."</td>";
					}
					else
					{
						echo "<td>".$team_comm."</td><td>".dateDiffsql($link,date("Y-m-d"),$ims_date)."</td>";
					}
					//if($row_counter > 0)
						echo "<td bgcolor='$tr_color' style='border-top:1px solid $tr_color;border-bottom:1px solid $tr_color;'></td>";
					
					echo "</tr>";
				}
				
				$j++;
				$old_module = $module_ref;				
			}
		}
	}
	    echo "</table></div></div>";
?>


</body>
</html>
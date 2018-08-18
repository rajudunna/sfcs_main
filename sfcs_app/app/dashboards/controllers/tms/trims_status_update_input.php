<!-- 2013-11-25/DharaniD/Ticket #988194
Revised CSS files for interface standardization,Add the Validation on trims status.-->

<?php
error_reporting(0);
//include("header.php");
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
// include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');

$php_self = explode('/',$_SERVER['PHP_SELF']);
array_pop($php_self);
$url_r = base64_encode(implode('/',$php_self)."/trims_status_update_input.php");
$has_permission=haspermission($url_r); 
//$username_list=explode('\\',$_SERVER['REMOTE_USER']);
//$username=strtolower($username_list[1]);
//$username="sfcsproject1";
//$special_users=array("kirang","buddhikam","chathurangad","minuram","sfcsproject1","sfcsproject2","aseemmo","jeyakugananthinij","menujar","saroasa"); // users for all access in trims status
//$trim_warehouse_users=array("sfcsproject1","chathurangad","minuram","buddhikam","nizzarm","rangac","asankaj","chamilama","kalpanib","sandyaw","subodhaw","preshilas","nishanthak","tharinduba","keerthik","dilhanis","gayanbu","neilja","sfcsproject1","sfcsproject2","aseemmo","jeyakugananthinij","menujar","saroasa","pirabothenys","thiviyadast","rimoess","ashokw","jeganathanj","ber_databasesvc","sudathra");   //User for access Trim part :ChathurangD
//$input_update_users=array("chathurangad","minuram","buddhikam","nizzarm","rangac","asankaj","chamilama","tharinduba","sfcsproject1","sfcsproject2","saroasa","pirabothenys","thiviyadast","rimoess","ashokw","jeganathanj","ber_databasesvc","sudathra");   //User for access Inputs :ChathurangD
//$view_users=array("ruwank","beracut","berafloor","gayancha","sfcsproject1","sfcsproject2","saroasa","pirabothenys","thiviyadast","rimoess","ashokw","jeganathanj","ber_databasesvc","sudathra");   //User users :ChathurangD
//$trims_special_user_access=array("sfcsproject1","chathurangad","sfcsproject2","gayancha","sudathra","saroasa","buddhikara","samilac");
$isinput=$_GET['isinput'];

//function to extract input informat
 
function doc_in_status($link,$result_type,$size,$doc_no,$input_ref)
{
	//$result_type : CUTQTY, INPUTQTY (as per input job reference), IMSINPUTQTY (as per docket)
	//$doc_no: Docket #
	//$input_refere: Input job reference random
	
	$ret=0;
	if($size='2xl') {$size='s08';}
	if($size='3xl') {$size='s10';}
	if($size='4xl') {$size='s12';}
	switch($result_type)
	{
		case 'CUTQTY':
		{
			$sql="select (a_$size*a_plies) as cutqty from $bai_pro3.plandoc_stat_log where doc_no=$doc_no";
			//echo "Qry :".$sql."<br>";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error87 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
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
			$sql="SELECT COALESCE(SUM(in_qty),0) as input FROM ((SELECT SUM(ims_qty) AS in_qty FROM $bai_pro3.ims_log_backup WHERE ims_doc_no='$doc_no'  and ims_size='a_$size') UNION (SELECT SUM(ims_qty) AS in_qty FROM $bai_pro3.ims_log WHERE ims_doc_no='$doc_no' and ims_size='a_$size')) AS tmp";
			//echo $sql."<br>";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error89 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$ret=$sql_row['input'];
			}
			break;
		}
		
	}
	
	return $ret;
	
}


?>
<title>Trims Status Update Form</title>
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
<link rel="stylesheet" href="styles/bootstrap.min.css">
<style type="text/css" media="screen">

/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

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
 thead{ background-color:#29759C; color:#FFF; padding:2px; border:1px solid #ccc; } 
tbody{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;background-color: #FFF} 
</style>
</head>
<body>
<!-- <form action="trims_status_update_input.php" method="POST"> -->
<form action=<?= getFullURLLevel($_GET['r'],'trims_status_update_input.php',0,'N'); ?> method="POST">
<?php 
include("functions.php");?>

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
	//echo $doc."<br>";
}
else
{
	$doc=$_GET["doc_no"];
	$section=$_GET["section"];
	$style=$_GET["style"];
	$schedule=$_GET["schedule"];
	$jobno=$_GET["jobno"];
	$module_no=$_GET["module"];
	//echo $doc."<br>";
}

//echo $doc;
$sql131="select * FROM $bai_pro3.plan_dashboard_input where input_trims_status=4 and input_panel_status=2";
$result131=mysqli_query($link, $sql131) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
$no_of_rows131=mysqli_num_rows($result131);
if($no_of_rows131>0)
{
	$sql13="DELETE FROM $bai_pro3.plan_dashboard_input where input_trims_status=4 and input_panel_status=2";
	//echo "<br/>".$sql13."<br/>";
	mysqli_query($link, $sql13) OR die("Error=".$sql13."-".mysqli_error($GLOBALS["___mysqli_ston"]));
}

$sql3="select input_trims_status as stat from $table_name where input_job_no_random_ref='$doc'";
$result3=mysqli_query($link, $sql3) or exit("Sql Error1111".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row3=mysqli_fetch_array($result3))
{
	$trims_statusx=$row3["stat"];
}

// Start - To take club schedule number and  list of original schedules  -  11-11-2014 - Added by ChathurangaD
$ssql33="SELECT order_joins from $bai_pro3.bai_orders_db where order_del_no='$schedule'";
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
	$result333=mysqli_query($link, $ssql333) or exit("Sql Error3332".mysqli_error($GLOBALS["___mysqli_ston"]));
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
	$result333=mysqli_query($link, $ssql333) or exit("Sql Error3334".mysqli_error($GLOBALS["___mysqli_ston"]));
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
	$result333=mysqli_query($link, $ssql333) or exit("Sql Error3335".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row333=mysqli_fetch_array($result333))
	{
		$org_schs=$row333["org_schs"];
		//echo "A";
	}
	$join_sch=substr($join_sch, 1);
}

// End - To take club schedule number and list of original schedules  -  11-11-2014 - Added by ChathurangaD

// Start  ---------  03-Nov-2014 -  Added by Chathurangad
if(in_array($authorized,$has_permission))
{
	echo "<h2>Trims Status Update Form</h2>";
	$textbox_disable="disabled=\"disabled\"";
}
else if(in_array($view,$has_permission))
{
	echo "<h2>Trims Status View Form</h2>";
	$textbox_disable="disabled=\"disabled\"";
	$dropdown_disable="disabled=\"disabled\"";
}
else
{
	header("Location:restrict.php");
}
// End  ---------  03-Nov-2014 -  Added by Chathurangad

echo "<h3>Style:$style / Schedule:$join_sch / Input Job#: J".leading_zeros($jobno,3)."</h3>";

$sql="SELECT GROUP_CONCAT(CONCAT(\"'\",order_col_des,\"'\")) AS colorset,GROUP_CONCAT(sizegroup) AS size_group FROM (
SELECT DISTINCT order_col_des,GROUP_CONCAT(sizeset SEPARATOR '*') AS sizegroup FROM (
SELECT order_col_des,CONCAT(m3_size_code,'$',SUM(carton_act_qty)) AS sizeset FROM $bai_pro3.packing_summary_input WHERE input_job_no_random='$doc' GROUP BY order_col_des,size_code
) AS a GROUP BY order_col_des
) AS b";
	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error887 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))

{
	$colorset=$sql_row['colorset'];
	$size_group=$sql_row['size_group'];
}

// echo "<h4>Ratio Sheet</h4>";
// echo "<a class='btn btn-info btn-sm' href=\"print_input_sheet.php?schedule=$org_schs\" onclick=\"return popitup_new('print_input_sheet.php?schedule=$org_schs')\">Print Input Job Sheet - Job Wise</a><br>";
$popup_url = getFullURLLevel($_GET['r'],'sheet_v2.php',0,'R');

echo "<h4>Consumption Report </h4>";
echo "<a class='btn btn-info btn-sm' href=\"#\" onclick=\"return popitup_new('$popup_url?schedule=$org_schs&style=$style&input_job=$jobno')\">Print Input Job Sheet - Sewing / Packing Requirement</a><br><br>";

$sql4="select input_trims_status as t_status from $table_name where input_job_no_random_ref='$doc'";
//echo $sql4;
$result4=mysqli_query($link, $sql4) or exit("Sql Error1234".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row4=mysqli_fetch_array($result4))
{
	$t_status=$row4["t_status"];
}
if($t_status==1)
{
	$popup_url = getFullURLLevel($_GET['r'],'new_job_sheet3.php',0,'R');
echo "<a class='btn btn-info btn-sm' href='#' onclick=\"return popitup_new('$popup_url?jobno=$jobno&style=$style&schedule=$schedule&module=$module_no&section=$section&doc_no=$doc')\">Job Sheet</a>";
}
echo "<br><br>";
	
$balance_tot=0;
echo "<table class='table table-bordered'>";
echo "<thead>";
echo "<tr>";
// echo "<th>Schedule </th>";
echo "<th>Color </th>";
echo "<th>Cut Job</th>";
// echo "<th>Input Job</th>";
echo "<th>Destination</th>";
echo "<th>Size</th>";
echo "<th>Allocated Quantity</th>";
// echo "<th>Issued Quantity</th>";
// echo "<th>Balance to Issue Quantity</th>";
// echo "<th>Allowed Quantity</th>";
// echo "<th>Bundle Stickers</th>";
// echo "<th>Input Quantity</th>";
//echo "<th>TID</th>";
//echo "<th>Doc# Ref</th>";
echo "</tr></thead>";
$sql121="SELECT GROUP_CONCAT(DISTINCT(doc_no) ORDER BY doc_no) AS docket_ref FROM $bai_pro3.packing_summary_input WHERE input_job_no_random='$doc'";
$sql_result121=mysqli_query($link, $sql121) or exit("Sql Error8832 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row121=mysqli_fetch_array($sql_result121))
{
	$docket_ref=$sql_row121['docket_ref'];
}
	
$sql="SELECT destination,cat_ref,acutno,order_del_no,doc_no,input_job_no,GROUP_CONCAT(DISTINCT tid ORDER BY tid) AS tid,GROUP_CONCAT(DISTINCT doc_no_ref ORDER BY doc_no) AS doc_no_ref,GROUP_CONCAT(DISTINCT size_code) AS size_code,GROUP_CONCAT(DISTINCT order_col_des) AS order_col_des,GROUP_CONCAT(DISTINCT CONCAT(acutno,'-',order_col_des,'-',size_code,'-',carton_act_qty) ORDER BY doc_no SEPARATOR '<br/>' ) AS a_cutno,SUM(carton_act_qty) AS carton_act_qty FROM (SELECT cat_ref,order_del_no,input_job_no,input_job_no_random,tid,doc_no,doc_no_ref,size_code,order_col_des,acutno,destination,SUM(carton_act_qty) AS carton_act_qty FROM $bai_pro3.packing_summary_input WHERE input_job_no_random='$doc' GROUP BY order_col_des,input_job_no_random,acutno,size_code,destination) AS t GROUP BY doc_no,size_code ORDER BY order_del_no,acutno,input_job_no";
//echo $sql."<br>";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error8832 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));

	$i=0;
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		
		$cutqty=doc_in_status($link,'CUTQTY',$sql_row['size_code'],$sql_row['doc_no'],'');
		$inputqty=doc_in_status($link,'INPUTQTY',$sql_row['size_code'],$sql_row['doc_no'],$doc);
		$imsinputqty=doc_in_status($link,'IMSINPUTQTY',$sql_row['size_code'],$sql_row['doc_no'],'');
		$balance=($sql_row['carton_act_qty']-$inputqty);
		$allowedqty=0;
		//echo $cutqty."-".$inputqty."-".$imsinputqty."-".$sql_row['carton_act_qty']."<br>";
		if(($cutqty-$imsinputqty)>=$balance)
		{
			$allowedqty=$balance;
			
		}
		else
		{
			$allowedqty=($cutqty-$imsinputqty);
			
		}
		
		echo "<tbody><tr>";
		// echo "<td>".$sql_row['order_del_no']."</td>";
		echo "<td><input type=\"hidden\" name=\"input_color[]\" value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</td>";
		echo "<td><input type=\"hidden\" name=\"input_cat_ref[]\" value=\"".$sql_row['cat_ref']."\"><input type=\"hidden\" name=\"input_cut_no_ref[]\" value=\"".$sql_row['acutno']."\"><input type=\"hidden\" name=\"input_doc_no[]\" value=\"".$sql_row['doc_no']."\"><input type=\"hidden\" name=\"input_job_no_ref[]\" value=\"".$sql_row['input_job_no']."\">".$sql_row['acutno']."<input type=\"hidden\" name=\"input_qty[]\" $textbox_disable value=\"0\" onchange=\"if(this.value<0 || this.value>$allowedqty) { this.value=0; }\"></td>";
		// echo "<td><input type=\"hidden\" name=\"input_job_no_ref[]\" value=\"".$sql_row['input_job_no']."\">".$sql_row['input_job_no']."</td>";
		echo "<td>".$sql_row['destination']."</td>";
		echo "<td><input type=\"hidden\" name=\"input_size[]\" value=\"".$sql_row['size_code']."\">".strtoupper($sql_row['size_code'])."</td>";
		echo "<td>".$sql_row['carton_act_qty']."</td>";
		// echo "<td>".$inputqty."</td>";
		// echo "<td>".$balance."</td>";
		// echo "<td>".$allowedqty."</td>";
		//echo "<td>Print</td>";
		?>
		<!--<td><a class='btn btn-info btn-sm' href="http://localhost/sfcs/projects/beta/packing/labels/mpdf50/examples/sawing_out_labels.php?job_no=1&schedule=<?php echo $org_schs; ?>&color=<?php echo $sql_row['order_col_des']; ?>&size=<?php echo $sql_row['size_code']; ?>" onclick="return popitup_new('http://localhost/projects/beta/packing/labels/mpdf50/examples/sawing_out_labels.php?job_no=1&schedule=<?php echo $org_schs; ?>&color=<?php echo $sql_row['order_col_des']; ?>&size=<?php echo $sql_row['size_code']; ?>)">Print</a></td>-->
		<!--<td><a class='btn btn-info btn-sm' href="http://localhost/sfcs/projects/beta/packing/labels/mpdf50/examples/sawing_out_labels.php?job_no=1&schedule=<?php echo $org_schs; ?>&color=<?php echo $sql_row['order_col_des']; ?>&size=<?php echo $sql_row['size_code']; ?>" onclick="return popitup_new('http://localhost/projects/beta/packing/labels/mpdf50/examples/sawing_out_labels.php?job_no=1&schedule=<?php echo $org_schs; ?>&color=<?php echo $sql_row['order_col_des']; ?>&size=<?php echo $sql_row['size_code']; ?>)">Print</a></td>-->
		<!--<td><a class='btn btn-info btn-sm' href="/sfcs/projects/Beta/production_planning/mpdf7/sawing_out_labels.php?job_no=1&schedule=<?php echo $org_schs; ?>&color=<?php echo $sql_row['order_col_des']; ?>&size=<?php echo $sql_row['size_code']; ?>" onclick="return popitup_new('/sfcs/projects/Beta/production_planning/mpdf7/sawing_out_labels.php?job_no=1&schedule=<?php echo $org_schs; ?>&color=<?php echo $sql_row['order_col_des']; ?>&size=<?php echo $sql_row['size_code']; ?>)">Print</a></td>-->
		
		<?php 
		 if(in_array($update,$has_permission)  and $isinput==1)
		 {
		 	echo "<td><input type=\"text\" name=\"input_qty[]\" $textbox_disable value=\"$balance\" onchange=\"if(this.value<0 || this.value>$allowedqty) { this.value=0; }\"></td>";
		 }
		 else
		 {
		 	echo "<td><input type=\"text\" name=\"input_qty[]\" $textbox_disable value=\"0\" onchange=\"if(this.value<0 || this.value>$allowedqty) { this.value=0; }\"></td>";
		 }
		echo "</tr></tbody>";
		
		$i++;
		$balance_tot=$balance_tot+$balance;   //Total balance qty in selected Input Job#  - 03-11-2014  - ChathurangaD
	}
	echo "</table>";
	//echo $balance_tot;
?>


<table>
<tr>
<thead>
<th>Trims Status</th>
</thead>
<td>
<div class="form-inline">
<div class="form-group">
<?php
$status=array("","Preparing material","Material ready for Production (in Pool)","Partial Issued","Issued To Module");
echo "<input type=\"hidden\" name=\"doc\" value=\"$doc\" />";
echo "<input type=\"hidden\" name=\"docket_no\" value=\"$docket_no\" />";
echo "<input type=\"hidden\" name=\"section\" value=\"$section\" />";
echo "<input type=\"hidden\" name=\"style\" value=\"$style\" />";
echo "<input type=\"hidden\" name=\"schedule\" value=\"$schedule\" />";
echo "<input type=\"hidden\" name=\"jobno\" value=\"$jobno\" />";
echo "<input type=\"hidden\" name=\"moduleno\" value=\"$module_no\" />";
echo "<input type=\"hidden\" name=\"docket_ref\" value=\"$docket_ref\" />";
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
	//echo "pres value=".$pvalue;
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
	//echo "pres value=".$pvalue;
	
}
echo "</td>";
?>
</div>
</div>
<?php
echo '<td><input type="submit" class="btn btn-primary" name="submit" value="Submit" /></td>';
echo "</tr></table>";
?>
</form>

<?php

if(isset($_POST["submit"]))
{
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
	$input_qty_tot="";
	$input_job_no_ref=$_POST['input_job_no_ref'];
	$cut_no_ref=$_POST['input_cut_no_ref'];
	$docket_ref=$_POST['docket_ref'];
		
	$sql4="update $table_name set input_trims_status=\"".$up_status."\" where input_job_no_random_ref=\"".$doc."\"";
	//echo $sql4;
	mysqli_query($link, $sql4);
			
	$sql123="INSERT INTO `$bai_pro3`.`temp_line_input_log` (`schedule_no`, `style`, `input_job_no`, `username`, `date_n_time`, `page_name`	) VALUES
	('".$schedule_code."','".$style_code."','".$input_job_no_ref[0]."','".$username."','".date("Y-m-d H:i:s")."','Trim Issue$up_status')";
	mysqli_query($link, $sql123) OR die("Error=".$sql123."-".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	echo "<script type=\"text/javascript\"> window.close(); </script>";	
}

?>
</body>
</html>
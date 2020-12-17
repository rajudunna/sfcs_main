
<head>
	<link rel="stylesheet" type="text/css" href="../../../../common/css/bootstrap.min.css">
	<title></title>
</head>
<?php
error_reporting(0);
//include("header.php");
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/enums.php');
include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/server_urls.php');

$php_self = explode('/',$_SERVER['PHP_SELF']);
array_pop($php_self);
$url_r = base64_encode(implode('/',$php_self)."/input_status_update_input.php");
// $has_permission=haspermission($url_r); 
$isinput=$_GET['isinput'];
$plant_code=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
?>
<div class='panel panel-primary'>
	<div class='panel-heading'>Line Input Update Status</div>
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
th{ background-color:#29759C; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;background-color: #FFF}
</style>
</head>
<body>
<form action="input_status_update_input.php" method="POST">
<?php 
include("functions.php");?>

<?php

if(isset($_POST["doc"]) or isset($_POST["section"]))
{
	$doc=$_POST["doc"];
	$section=$_POST["section"];
	$style=$_POST["style"];
	$schedule=$_POST["schedule"];
	$jobno=$_POST["jobno"];
	$module_no=$_POST["moduleno"];
	$prefix=$_POST['prefix'];
	$jm_jg_header_id=$_POST['jm_jg_header_id'];
	$color=$_POST['color'];
	$plant_code=$_POST['plant_code'];
	$username=$_POST['username'];
    $job_color_status=$_GET['job_status'];
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
	$prefix=$_GET['prefix'];
    $jm_jg_header_id=$_GET['jm_jg_header_id'];
	$color=$_GET['color'];
	$plant_code=$_GET['plant_code'];
	$username=$_GET['username'];
	$job_color_status=$_GET['job_status'];
}
    $textbox_disable="disabled=\"disabled\"";
	// $dropdown_disable="disabled=\"disabled\"";


echo "<h4>Style:$style / Schedule:$schedule / Input Job#: $prefix".$jobno."</h4>";
//$path=$DOCKET_SERVER_IP."/printJobSheet/";
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
$seq1=-1;
// echo "<a class='btn btn-info btn-sm' href=\"$path$jobno\" onclick=\"return popitup_new('$path$jobno')\"><button class='equal btn btn-success'>Job Sheet</button></a>";

// echo "<a class='btn btn-info btn-sm' href=\"../../../production/controllers/sewing_job/new_job_sheet3.php?jobno=$jobno&style=$style&schedule=$schedule&module=$module_no&section=$section&doc_no=$doc\" onclick=\"return popitup_new('../../../production/controllers/sewing_job/new_job_sheet3.php?jobno=$jobno&style=$style&schedule=$schedule&module=$module_no&section=$section&doc_no=$doc&plant_code=$plant_code')\"><button class='equal btn btn-success'>Job Sheet</button></a>";

echo "<u><b><a class='btn btn-info btn-sm' href=\"../../../production/controllers/sewing_job/print_input_sheet.php?schedule=$schedule&seq_no=$seq1\" onclick=\"return popitup('../../../production/controllers/sewing_job/print_input_sheet.php?schedule=$schedule&seq_no=$seq1&jm_jg_header_id=$jm_jg_header_id&plant_code=$plant_code')\"><button class='equal btn btn-success'>Print Input Job Sheet - Job Wise</button></a></b></u><br>";

echo "<br><br>";


// $url5 = getFullURLLevel($_GET['r'],'sfcs_app/app/production/controllers/sewing_job/barcode_new.php',5,'R');
//         echo "<td><a class='btn btn-info btn-sm' href='$url5?input_job=".$jobno."&schedule=".$schedule."' onclick=\"return popitup2('$url5?input_job=".$jobno."&schedule=".$schedule."')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Print Bundle Barcode</a></td>";

	
$balance_tot=0;
echo "<table class='table'>";
echo "<tr>";
echo "<th>Schedule</th>";
echo "<th>Color </th>";
echo "<th>Cut Job</th>";
echo "<th>Destination</th>";
echo "<th>Size</th>";
echo "<th>Job Quantity</th>";
echo "</tr>";

//To get cut job id
$tasktype=TaskTypeEnum::SEWINGJOB;
$qry_get_task_job="SELECT task_jobs_id FROM $tms.task_jobs WHERE task_job_reference='$jm_jg_header_id' AND plant_code='$plant_code' AND task_type='$tasktype'";
$qry_get_task_job_result = mysqli_query($link_new, $qry_get_task_job) or exit("Sql Error at qry_get_task_job" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($row21 = mysqli_fetch_array($qry_get_task_job_result)) {
	$task_job_id = $row21['task_jobs_id'];
}
//TO GET STYLE AND COLOR FROM TASK ATTRIBUTES USING TASK JOB ID
$job_detail_attributes = [];
$qry_toget_style_sch = "SELECT attribute_name,attribute_value FROM $tms.task_attributes where task_jobs_id='$task_job_id' and plant_code='$plant_code'";
$qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("Sql Error at toget_style_sch" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {
  $job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
}
$cutjobno = $job_detail_attributes[$sewing_job_attributes['cutjobno']];
$docket_no = $job_detail_attributes[$sewing_job_attributes['docketno']];
$sql="SELECT sum(jm_job_bundles.quantity) as quantity,jm_job_bundles.size as size FROM $pps.`jm_job_bundles` LEFT JOIN $pps.`jm_product_logical_bundle` ON jm_job_bundles.`jm_pplb_id`=jm_product_logical_bundle.jm_pplb_id WHERE jm_jg_header_id='".$jm_jg_header_id."'  AND jm_job_bundles.fg_color='".$color."' AND  jm_job_bundles.plant_code='$plant_code' group by size";
//AND schedule='".$schedule."'
$sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($sql_result))
{
	$size_code=strtoupper($row['size']);
	$size_code_qty=$row['quantity'];

	//to get destination
	$get_destination="SELECT destination FROM $oms.oms_mo_details WHERE schedule='".$schedule."' AND plant_code='$plant_code'";
    $sql_result1=mysqli_query($link, $get_destination) or die("Error".$get_destination.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($sql_result1))
	{
      $destination=$row1['destination'];
	}
	echo "<tr>";
	echo "<td>".$schedule."</td>";
	echo "<td>".$color."</td>";	
	echo "<td>".$cutjobno."</td>";
	echo "<td>".$destination."</td>";
	echo "<td>".$size_code."</td>";
	echo "<td>".$size_code_qty."</td>";	
	echo "</tr>";
}
echo "</table>";
echo "<br/><div style=\"Color:red;font-size:16px;text-weight:bold;\">".$display_job_color_status."</div><br/>";
//get trim status
$get_trims_status="SELECT trim_status FROM $tms.job_trims WHERE task_job_id= '$task_job_id'";
$get_trims_status_result = mysqli_query($link_new, $get_trims_status) or exit("Sql Error at get_trims_status" . mysqli_error($GLOBALS["___mysqli_ston"]));
  while ($row2 = mysqli_fetch_array($get_trims_status_result)) {
	 $trim_status=$row2['trim_status'];
  }
?>

<table>
<tr>
<th>Trims Status</th>
<td>
<div class="form-inline">
<div class="form-group">
<?php
$status=array("OPEN"=>TrimStatusEnum::OPEN,"PREPARINGMATERIAL"=>TrimStatusEnum::PREPARINGMATERIAL,"MATERIALREADYFORPRODUCTION"=>TrimStatusEnum::MATERIALREADYFORPRODUCTION,"PARTIALISSUED"=>TrimStatusEnum::PARTIALISSUED,"ISSUED"=>TrimStatusEnum::ISSUED);
echo "<input type=\"hidden\" name=\"doc\" value=\"$doc\" />";
echo "<input type=\"hidden\" name=\"docket_no\" value=\"$docket_no\" />";
echo "<input type=\"hidden\" name=\"section\" value=\"$section\" />";
echo "<input type=\"hidden\" name=\"style\" value=\"$style\" />";
echo "<input type=\"hidden\" name=\"schedule\" value=\"$schedule\" />";
echo "<input type=\"hidden\" name=\"jobno\" value=\"$jobno\" />";
echo "<input type=\"hidden\" name=\"moduleno\" value=\"$module_no\" />";
echo "<input type=\"hidden\" name=\"task_job_id\" value=\"$task_job_id\" />";
echo "<input type=\"hidden\" name=\"plant_code\" value=\"$plant_code\" />";
echo "<input type=\"hidden\" name=\"username\" value=\"$username\" />";
echo "<select name=\"status\" class=\"form-control\" $dropdown_disable>";

  foreach($status as $key => $value)
  { 
    if($trim_status == $value)
    {
      echo "<option value='".$value."' selected>".$value."</option>";
    }
    // else
    // {
    //   echo "<option value='".$value."'>".$value."</option>";
    // }
    //echo "sa =" .$sta."<br>";
  }
  echo "</select>";
echo "</td>";
?>
</div>
</div>
<?php
//echo '<td><input type="submit" id="submit" class="btn btn-primary" name="submit" value="Submit" /></td>';
echo "</tr></table>";
?>
</form>
</body>
</div>
<style>
.equal{
		width : auto;
		text-align:center;
		color:
	}
	a{
		text-decoration:none;
	}
	#print_label{
		margin-left:-4pt;
		color: white;
		background-color:#F0AD4E;
	}
	#submit{
		color: white;
		background-color:green;
	}
	#job_sheet{
		color: white;
		background-color:#57ea4f;
	}
	h3{
		background-color:#99ccff;
		color:white;
		width:50%;
		padding-top:5px;
		padding-bottom:5px;
	}
</style>


<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>

<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_v2.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/group_def.php');

include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');
$dash=0;
if (isset($_GET['dash'])) {
	$dash=1;
}

$php_self = explode('/',$_SERVER['HTTP_HOST']);
array_pop($php_self);
$url_r = base64_encode(implode('/',$php_self)."/sfcs_app/app/cutting/controllers/seperate_docket.php");
$url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index.php?r=".$url_r;
$has_permission=haspermission($url_r); 
?>
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs_app/app/dashboards/common/css 	/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<?php 

?>
<br/>
<div class='row'>
		<div class='col-md-2 pull-left'>
			<a class='btn btn-primary' href = '<?= $url1 ?>'> Back </a>
		</div>
		<div class='col-md-10 pull-right'>
			<p style='color:red'>Note : Please Print "Docket Print" Before Update Fabric Status</p>
		</div>
</div>
<br/>
<script src="../../../../common/js/sweetalert.min.js"></script>
<script type="text/javascript">


function check_validate()
{
	var print_valid=document.getElementById("print_validation").value;
	var num_check=document.getElementById("sql_num_check").value;
	var checkBox = document.getElementById("validate");
	console.log(print_valid);
	console.log(num_check);
	if(Number(print_valid)==Number(num_check)){
		if (checkBox.checked == true){	
		var total_req=parseInt(document.getElementById("tot_req").value);
		var allocation=parseInt(document.getElementById("alloc_qty").value);
		var selection=document.getElementById("issue_status").value;
		var doc_tot=document.getElementById("doc_tot").value;
		var alloc_doc=document.getElementById("alloc_doc").value;
		if(0<allocation)
			{
				document.getElementById("submit").disabled=false;
				if(total_req == allocation)
				{
					document.getElementById("submit").disabled=false;
					document.getElementById('dvremark').style.display = "none";
				}
				else if(total_req < allocation)
				{
					var diff=(allocation-total_req);
					var numb = diff.toFixed(2);
					if(confirm("You are sending morethan required quantity :"+numb+"Yrds. \n Are you Sure,You want to proceed..?"))
					{
						document.getElementById('dvremark').style.display = "block";
					}
					else
					{
						document.getElementById("validate").checked=false;
						document.getElementById("submit").disabled=true;
						document.getElementById("remarks").value="";
						document.getElementById('dvremark').style.display = "none";
					}
					
				}
				else if(allocation < total_req)
				{
					var diff=total_req-allocation;
					numb = diff.toFixed(2);
					if(confirm("You are sending lessthan required quantity :" +numb+ " Yrds. \n Are you Sure,You want to proceed..?"))
					{
						
						document.getElementById('dvremark').style.display = "block";
					}
					else
					{
					
						document.getElementById("validate").checked=false;
						document.getElementById("submit").disabled=true;
						document.getElementById("remarks").value="";
						document.getElementById('dvremark').style.display = "none";
					}
				}
			}
			else if(allocation==0 && doc_tot==alloc_doc)
			{
				
				sweetAlert("You have allocated \"STOCK\" for some of the dockets ","","warning");
				document.getElementById('dvremark').style.display = "block";
				document.getElementById("submit").disabled=false;
			}
			else
			{
				sweetAlert("Please allocate the material to the Docket"," ","warning");
				document.getElementById("validate").checked=false;
				document.getElementById("submit").disabled=true;
				document.getElementById("remarks").value="";
				document.getElementById('dvremark').style.display = "none";
				return false;
			}
		}else{
			document.getElementById("submit").disabled=true;
		}

	}else{

		sweetAlert("You should print docket print Before Update Staus","","warning");
		document.getElementById("validate").checked=false;
		document.getElementById("submit").disabled=true;
		document.getElementById("remarks").value="";
		document.getElementById('dvremark').style.display = "none";
		return false;

	}
	

}

function validate_but()
{
		var total_require=parseInt(document.getElementById("tot_req").value);
		var allocation_require=parseInt(document.getElementById("alloc_qty").value);
		console.log("Total Req : " +total_require);
		console.log(allocation_require);
		var str_text=document.getElementById("remarks").value;
		var ii=str_text.length;
		if(total_require==allocation_require)
		{

		}
		else
		{
			if(ii < 8)
			{
				sweetAlert("Please fill the remark...!","","warning");
				return false;
			}
			else
			{
			
			}
		}
		
}

</script>

<?php
error_reporting(0);
set_time_limit(20000);
$plant_code = $_GET['plantcodename'];
$username = $_GET['username'];
$doc_no=$_GET['doc_no'];
//getting docket number to get 
$binding_query = "select p.id,p.tot_bindreq_qty,c.doc_no from $pps.binding_consumption_items as c LEFT JOIN $pps.binding_consumption p ON p.id=c.parent_id where c.parent_id='".$doc_no."' and c.plant_code='".$plant_code."'";
$binding_query_result=mysqli_query($link_new, $binding_query) or exit("Sql Errorat_jm_cut_job".mysqli_error($GLOBALS["___mysqli_ston"]));
	$binding_num=mysqli_num_rows($binding_query_result);
	if($binding_num>0){
		while($binding_row=mysqli_fetch_array($binding_query_result))
		{
			$tot_bindreq_qty = $binding_row['tot_bindreq_qty'];
			$doc_num = $binding_row['doc_no'];
			$id = $binding_row['id'];
		}
	}
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="../../../../common/css/page_style.css" />
<link rel="stylesheet" href="../../../../common/css/bootstrap.min.css">
<script src="../../../../common/js/jquery.min.js"></script>
<script src="../../../../common/js/bootstrap.min.js"></script>


<style>
body
{
	font-family: Trebuchet MS;
}
</style>

<style>
body
{
	background-color:#ffffff;
	color: #000000;
	font-family: Trebuchet MS;
}
a {text-decoration: none;}

table
{
	border: 1px solid #000000;
	border-collapse:collapse;
	border-color:#000000;
}
td
{
	border: 1px solid #000000;
	white-space:nowrap;
	border-collapse:collapse;
}

th
{
	border: 1px solid #000000;
	white-space:nowrap;
	border-collapse:collapse;
	color:#ffffff;
	background:#29759c;
	font-size:14;
}

.bottom th,td
{
	border-bottom: 1px solid white; 
	padding-bottom: 1px;
	padding-top: 1px;
	font-size:14;
}

.input
{
	background-color:yellow;
}

</style>
<script>
 function button_disable()
{
	document.getElementById('process_message').style.visibility="visible";
	document.getElementById('allocate').style.visibility="hidden";
}
 

function dodisable()
{
document.getElementById('process_message').style.visibility="hidden"; 

}
</script>
</head>
<body onload="dodisable()">
<div class="panel panel-primary">
<div class="panel-heading">Fabric Status</div>
<div class="panel-body">

<?php
	ob_end_flush();
	flush();
	usleep(10);
	$style='';
	$schedule='';
include("fab_detail_track_include.php");
echo "<table class='table table-bordered'>";
echo "<tr>";
echo "<th>Style</th>";
echo "<th>Schedule</th>";
echo "<th>Color</th>";
echo "</tr>";

	if($doc_num!=" " && $plant_code!=' '){
		//this is function to get style,color,and cutjob
		$result_jmdockets=getJmDockets($doc_num,$plant_code);
		$style =$result_jmdockets['style'];
		$fg_color =$result_jmdockets['fg_color'];
		$plies =$result_jmdockets['plies'];
		$jm_cut_job_id =$result_jmdockets['jm_cut_job_id'];
		$ratio_comp_group_id =$result_jmdockets['ratio_comp_group_id'];
		$length =$result_jmdockets['length'];
		$width =$result_jmdockets['width'];
		$efficiency =$result_jmdockets['efficiency'];
		$marker_version =$result_jmdockets['marker_version'];
		$marker_type_name =$result_jmdockets['marker_type_name'];
		$pattern_version =$result_jmdockets['pattern_version'];
		$perimeter =$result_jmdockets['perimeter'];
		$remark1 =$result_jmdockets['remark1'];
		$remark2 =$result_jmdockets['remark2'];
		$remark3 =$result_jmdockets['remark3'];
		$remark4 =$result_jmdockets['remark4'];
		$material_required_qty=$plies*$length;
	}

	//to get component po_num and ratio id from
	$qry_jm_cut_job="SELECT ratio_id,po_number FROM $pps.jm_cut_job WHERE jm_cut_job_id='$jm_cut_job_id' AND plant_code='$plant_code'";
	$jm_cut_job_result=mysqli_query($link_new, $qry_jm_cut_job) or exit("Sql Errorat_jm_cut_job".mysqli_error($GLOBALS["___mysqli_ston"]));
	$jm_cut_job_num=mysqli_num_rows($jm_cut_job_result);
	if($jm_cut_job_num>0){
		while($sql_row1=mysqli_fetch_array($jm_cut_job_result))
		{
			$ratio_id = $sql_row1['ratio_id'];
			$po_number=$sql_row1['po_number'];
		}
	}
	//this is function to get schedule
	if($po_number!=" " & $plant_code!=' '){
		$result_mp_mo_qty=getMpMoQty($po_number,$plant_code);
		$schedule =$result_mp_mo_qty['schedule'];
	}

	//this is a function to get component group id and ratio id
	if($ratio_comp_group_id!=' '){
		$result_ratio_component_group=getRatioComponentGroup($ratio_comp_group_id,$plant_code);
		$fabric_category =$result_ratio_component_group['fabric_category'];
		$material_item_code =$result_ratio_component_group['material_item_code'];
		$master_po_details_id =$result_ratio_component_group['master_po_details_id'];
	}
	//this is a function to get descrip and rm color from mp_fabric
	if($material_item_code!='' && $master_po_details_id!=''){
		$result_mp_fabric=getMpFabric($material_item_code,$master_po_details_id,$plant_code);
		$rm_description =$result_mp_fabric['rm_description'];
		$rm_color =$result_mp_fabric['rm_color'];

	}

	
if($style!='' && $fg_color!=''){
	echo "<tr>";
	echo "<td>".$style."</td>";
	echo "<td>".implode(",",$schedule)."</td>";
	echo "<td>".$fg_color."</td>";
	echo "</tr>";
}
echo "</table>";
//NEW Implementation for Docket generation from RMS
echo "<h2>Cut Docket Print</h2>";
echo "<form name=\"ins\" method=\"post\" action=\"allocation.php\">"; //new_Version
echo "<input type=\"hidden\" value=\"1\" name=\"process_cat\">"; //this is to identify recut or normal processing of docket (1 for normal 2 for recut)
echo "<input type=\"hidden\" value=\"$style\" name=\"style_ref\">";  
echo "<input type=\"hidden\" value=\"$schedule\" name=\"schedule\">";  
echo "<input type=\"hidden\" value=\"$dash\" name=\"dashboard\">";  
echo "<input type=\"hidden\" value=\"$plant_code\" name=\"plant_codename\">"; 
echo "<input type=\"hidden\" value=\"$username\" name=\"username\">"; 
echo "<input type=\"hidden\" name=\"row_id\" value=\"".$id."\">";


echo "<table class='table table-bordered'><tr><th>Category</th><th>Item Code</th><th>Color Desc. - Docket No</th><th>Required<br/>Qty</th><th>Control</th></tr>";
$enable_allocate_button=0;
$comp_printed=array();
$docket_num=array();
$total=0;$allc_doc=0;


$style_flag=0;
$Disable_allocate_flag=0;
$print_validation=0;
$print_status=1;
if($fabric_category!='')
{	

		//$docno_lot=$sql_row1['doc_no'];
		$seperated_lots='';
		//function to get lot numbers based on component and style
		$result_lots=getStickerData($material_item_code,$style,$plantcode);
		$lotnos =$result_lots['lotnos'];	
		if(sizeof($lotnos)>0)
		{
			$seperated_lots= trim(implode(",", $lotnos));	
		}
		
	echo "<tr><td>".$fabric_category."</td>";
	echo "<td>".$material_item_code."</td>";
	echo "<td>".$rm_description.'-'.$doc_num."</td>";
	$extra=0;
	echo "<td>".$tot_bindreq_qty."</td>";
	$doc_cat=$fabric_category;
	$doc_com=$material_item_code;
	$doc_mer=$tot_bindreq_qty;
	$cat_ref='B';
	$total = $tot_bindreq_qty;
	$docket_num[]=$doc_num;
	{	
		echo "<td><input type=\"hidden\" name=\"doc[]\" value=\"".$doc_num."\">";
		//For New Implementation
		echo "<input type=\"hidden\" name=\"doc_cat[]\" value=\"".$doc_cat."\">";
		echo "<input type=\"hidden\" name=\"doc_com[]\" value=\"".$doc_com."\">";
		echo "<input type=\"hidden\" name=\"doc_mer[]\" value=\"".$doc_mer."\">";
		echo "<input type=\"hidden\" name=\"cat_ref[]\" value=\"".$cat_ref."\">";
		echo "<input type=\"hidden\" name=\"width[]\" value=\"".$width."\">";
		//For New Implementation
		
		if($style_flag==0){
			if(sizeof($lotnos_array) ==''){
				$Disable_allocate=1;
			}
			echo "Please Provide Lot Numbers: <textarea class=\"form-control\" name=\"pms".$doc_num."\" id='address' 
			      onkeyup='return verify_num(this,event)' onchange='return verify_num(this,event)' cols=12 rows=10 placeholder='No Lot Number Found, Please Enter Lot Number'>".$seperated_lots."</textarea><br/>";

		}else{

			echo "Please Provide Lot Numbers: <textarea class=\"form-control\" id='address' onkeyup='return verify_num(this,event)'
			     onchange='return verify_num(this,event)' name=\"pms".$doc_num."\" cols=12 rows=10 ></textarea><br/>";

		}		
		echo "</td>";		
		$enable_allocate_button=1;
	}
echo "</tr>";
unset($lotnos_array);	
}
echo "<tr><td colspan=3><center>Total Required Material</center></td><td>$total</td><td></td></tr>";
echo "</table>";
if($enable_allocate_button==1)
{	
	
		echo "<input type=\"submit\" name=\"allocate\" value=\"Allocate\" class=\"btn btn-success\" onclick=\"button_disable()\">";
	
	
}
echo "</form>";		
?>

<?php

if(isset($_POST['allocate']))
{

	$doc=$_POST['doc'];
	
	for($i=0;$i<sizeof($doc);$i++)
	{
		$temp='lot'.$doc[$i];
		$lot=$_POST[$temp];		
		
	}
	
}


?>


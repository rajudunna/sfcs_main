<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>

<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
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
$doc_no=$_GET['doc_no'];
$doc_num = substr($doc_no,1);
if (!isset($_GET['pop_restriction'])) {
	$_GET['pop_restriction']=0;
}
if (!isset($_GET['group_docs'])) {
	$_GET['group_docs']=0;
}
$pop_restriction=$_GET['pop_restriction'];
$group_docs=$_GET['group_docs'];
?>

<?php
if(!(in_array($authorized,$has_permission)))
{
	header($_GET['r'],'restrict.php?group_docs=$group_docs','N');

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

	//function to get data from jn_dockets
	function getdata_jm_dockets($doc_num,$plant_code){
		$qry_jm_dockets="SELECT `style`,`fg_color`,`plies`,`jm_cut_job_id`,`ratio_comp_group_id` FROM $pps.jm_dockets WHERE WHERE plant_code='$plant_code' AND docket_number=$doc_num";
		$jm_dockets_result=mysqli_query($link_v2, $qry_jm_dockets) or exit("Sql Errorat_jmdockets".mysqli_error($GLOBALS["___mysqli_ston"]));
		$jm_dockets_num=mysqli_num_rows($jm_dockets_result);
		if($jm_dockets_num>0){
			while($sql_row1=mysqli_fetch_array($jm_dockets_result))
			{
				$style = $sql_row1['style'];
				$fg_color=$sql_row1['fg_color'];
				$plies=$sql_row1['plies'];
				$jm_cut_job_id=$sql_row1['jm_cut_job_id'];
				$ratio_comp_group_id=$sql_row1['ratio_comp_group_id'];
			}

			return array(
			'style' => $style,
			'fg_color' => $fg_color,
			'plies' => $plies,
			'jm_cut_job_id' => $jm_cut_job_id,
			'ratio_comp_group_id' => $ratio_comp_group_id
			);
		}
	}

	//function to get schedule from mp_mo_qty
	function getdata_mp_mo_qty($po_number,$plant_code){
		$qry_mp_sub_mo_qty="SELECT GROUP_CONCAT(master_po_details_mo_quantity_id) AS master_po_details_mo_quantity_id FROM $pps.mp_sub_mo_qty WHERE po_number='$po_number' AND plant_code='$plant_code'";
		$mp_sub_mo_qty_result=mysqli_query($link_v2, $qry_mp_sub_mo_qty) or exit("Sql Errorat_mp_sub_mo_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
			$mp_sub_mo_qty_num=mysqli_num_rows($mp_sub_mo_qty_result);
			if($mp_sub_mo_qty_num>0){
				while($sql_row1=mysqli_fetch_array($mp_sub_mo_qty_result))
				{
					$master_po_details_mo_quantity_id = $sql_row1['master_po_details_mo_quantity_id'];
				}
				//qry to get schedules wrt master_po_details_mo_quantity_id from mp_mo_qty
				$qry_mp_mo_qty="SELECT GROUP_CONCAT(SCHEDULE) AS SCHEDULE FROM $pps.mp_mo_qty WHERE `master_po_details_mo_quantity_id` IN ('$master_po_details_mo_quantity_id') AND plant_code='$plant_code'";
				$qry_mp_mo_qty_result=mysqli_query($link_v2, $qry_mp_mo_qty) or exit("Sql Errorat_mp_mo_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
					$qry_mp_mo_qty_num=mysqli_num_rows($qry_mp_mo_qty_result);
					if($qry_mp_mo_qty_num>0){
						while($sql_row1=mysqli_fetch_array($qry_mp_mo_qty_result))
						{
							$SCHEDULE = $sql_row1['SCHEDULE'];
						}
						return $SCHEDULE;
					}
			}
	}


	//function to get component group id and ratio id
	function getdata_ratio_component_group($ratio_comp_group_id,$plant_code){
		$qry_ratio_component_group="SELECT ratio_id,component_group_id FROM $pps.lp_ratio_component_group WHERE ratio_wise_component_group_id='$ratio_comp_group_id' AND plant_code='$plant_code'";
		$ratio_component_group_result=mysqli_query($link_v2, $qry_ratio_component_group) or exit("Sql Errorat_ratio_component_group".mysqli_error($GLOBALS["___mysqli_ston"]));
			$ratio_component_group_num=mysqli_num_rows($ratio_component_group_result);
			if($ratio_component_group_num>0){
				while($sql_row1=mysqli_fetch_array($ratio_component_group_result))
				{
					$ratio_id = $sql_row1['ratio_id'];
					$component_group_id = $sql_row1['component_group_id'];
				}
				//qry to get category  amd material item code and po details id
				$qry_component_group="SELECT fabric_category,material_item_code,master_po_details_id FROM $pps.lp_component_group WHERE master_po_component_group_id='$component_group_id' AND plant_code='$plant_code'";
				$qry_component_group_result=mysqli_query($link_v2, $qry_component_group) or exit("Sql Errorat_component_group".mysqli_error($GLOBALS["___mysqli_ston"]));
				$component_group_num=mysqli_num_rows($qry_component_group_result);
				if($component_group_num>0){
					while($sql_row1=mysqli_fetch_array($qry_component_group_result))
					{
						$fabric_category = $sql_row1['fabric_category'];
						$material_item_code = $sql_row1['material_item_code'];
						$master_po_details_id = $sql_row1['master_po_details_id'];

					}

					return array(
						'fabric_category' => $fabric_category,
						'material_item_code' => $material_item_code,
						'master_po_details_id' => $master_po_details_id,
						'master_po_details_id' => $master_po_details_id
					);
				}
			}
	}

	//this is function to get rm sku and rm color descript from mp_fabric
	function getdata_mp_fabric($material_item_code,$master_po_details_id,$plant_code){
		$qry_mp_fabric="SELECT rm_description,rm_color FROM $pps.mp_fabric WHERE master_po_details_id='$master_po_details_id' AND rm_sku='$material_item_code' AND plant_code='$plant_code'";
			$qry_mp_fabric_result=mysqli_query($link_v2, $qry_mp_fabric) or exit("Sql Errorat_component_group".mysqli_error($GLOBALS["___mysqli_ston"]));
			$mp_fabric_num=mysqli_num_rows($qry_mp_fabric_result);
			if($mp_fabric_num>0){
				while($sql_row1=mysqli_fetch_array($qry_mp_fabric_result))
				{
					$rm_description = $sql_row1['rm_description'];
					$rm_color = $sql_row1['rm_color'];
				}
				return array(
					'rm_description' => $rm_description,
					'rm_color' => $rm_color
				);
			}
	}

	//this is function to get size wise ratio's
	function getdata_size_ratios($ratio_id,$plant_code){
		$qry_ratio_size="SELECT SUM(size_ratio) AS size_ratios FROM lp_ratio_size WHERE ratio_id='' AND plant_code=''";
		$qry_ratio_size_result=mysqli_query($link_v2, $qry_ratio_size) or exit("Sql Errorat_size_ratios".mysqli_error($GLOBALS["___mysqli_ston"]));
			$qry_ratio_size_num=mysqli_num_rows($qry_ratio_size_result);
			if($qry_ratio_size_num>0){
				while($sql_row1=mysqli_fetch_array($qry_ratio_size_result))
				{
					$size_ratios = $sql_row1['size_ratios'];
				}

				return array(
					'size_ratios' => $size_ratios
				);
			}
	
	}
	
	
	
	if($doc_num!=" " && $plant_code!=' '){
		//this is function to get style,color,and cutjob
		$result_jmdockets=getdata_jm_dockets($doc_num,$plant_code);
		$style =$result_jmdockets['style'];
		$fg_color =$result_jmdockets['fg_color'];
		$plies =$result_jmdockets['plies'];
		$jm_cut_job_id =$result_jmdockets['jm_cut_job_id'];
		$ratio_comp_group_id =$result_jmdockets['ratio_comp_group_id'];
	}

	//to get component po_num and ratio id from
	$qry_jm_cut_job="SELECT ratio_id,po_number FROM $pps.jm_cut_job WHERE jm_cut_job_id=$jm_cut_job_id AND plant_code='$plant_code'";
	$jm_cut_job_result=mysqli_query($link_v2, $qry_jm_cut_job) or exit("Sql Errorat_jmdockets".mysqli_error($GLOBALS["___mysqli_ston"]));
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
		$result_mp_mo_qty=getdata_mp_mo_qty($po_number,$plant_code);
	}

	//this is a function to get component group id and ratio id
	if($ratio_comp_group_id!=' '){
		$result_ratio_component_group=getdata_ratio_component_group($ratio_comp_group_id,$plant_code);
		$fabric_category =$result_ratio_component_group['fabric_category'];
		$material_item_code =$result_ratio_component_group['material_item_code'];
		$master_po_details_id =$result_ratio_component_group['master_po_details_id'];
	}

	//this is a function to get descrip and rm color from mp_fabric
	if($material_item_code!='' && $master_po_details_id!=''){
		$result_mp_fabric=getdata_mp_fabric($material_item_code,$master_po_details_id,$plant_code);
		$rm_description =$result_mp_fabric['rm_description'];
		$rm_color =$result_mp_fabric['rm_color'];

	}

	//this is function to get sizes ratio based on ratio id
	if($ratio_id!=' ' && $plant_code!=''){
		$result_size_ratios=getdata_size_ratios($ratio_id,$plant_code);
		$size_ratios =$result_mp_fabric['size_ratios'];
	} 


	
	


$sql1= "SELECT * from $bai_pro3.binding_consumption where id=$doc_num";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result1);
$sizes_table ='';
while($sql_row1=mysqli_fetch_array($sql_result1))
{
    $id = $sql_row1['id'];
	$style=$sql_row1['style'];
	$schedule=$sql_row1['schedule'];
	$color=$sql_row1['color'];
	$binding_consumption_qty=$sql_row1['tot_bindreq_qty'];
	echo "<tr>";
	echo "<td>".$sql_row1['style']."</td>";
	echo "<td>".$sql_row1['schedule']."</td>";
	echo "<td>".$sql_row1['color']."</td>";
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
echo "<input type=\"hidden\" name=\"row_id\" value=\"".$doc_num."\">";


echo "<table class='table table-bordered'><tr><th>Category</th><th>Item Code</th><th>Color Desc. - Docket No</th><th>Required<br/>Qty</th><th>Control</th></tr>";
$sql2 = "SELECT *,GROUP_CONCAT(doc_no) AS dockets_list from $bai_pro3.binding_consumption_items where parent_id=$id group by parent_id";
$sql_result1=mysqli_query($link, $sql2) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
$enable_allocate_button=0;
$comp_printed=array();
$docket_num=array();
$total=0;$allc_doc=0;


$style_flag=0;
$Disable_allocate_flag=0;
$print_validation=0;
$print_status=1;
while($sql_row1=mysqli_fetch_array($sql_result1))
{	
	{
		$docno_lot=$sql_row1['doc_no'];
		$componentno_lot=$sql_row1['compo_no'];
		
		// $clubbing=$sql_row1['clubbing'];
		$qry_lotnos="SELECT p.order_tid,p.doc_no,c.compo_no,s.style_no,s.lot_no,s.batch_no FROM $bai_pro3.plandoc_stat_log p LEFT JOIN bai_pro3.cat_stat_log c ON 
		c.order_tid=p.order_tid LEFT JOIN bai_rm_pj1.sticker_report s ON s.item=c.compo_no WHERE style_no='$style' and item='$componentno_lot' and s.product_group='Fabric' group by s.lot_no";
		$sql_lotresult=mysqli_query($link, $qry_lotnos) or exit("lot numbers Sql Error ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_lotrow=mysqli_fetch_array($sql_lotresult))
		{
		
			$lotnos_array[]=$sql_lotrow['lot_no'];
		}
	
		if(sizeof($lotnos_array) =='')
		{
			
		}
		else 
		{
			$seperated_lots= trim(implode(",", $lotnos_array));
		}
	}
	echo "<tr><td>Binding</td>";
	echo "<td>".$sql_row1['compo_no']."</td>";
	echo "<td>".$color.'-'.$sql_row1['dockets_list']."</td>";
	$extra=0;
	echo "<td>".$binding_consumption_qty."</td>";
	$doc_cat=$sql_row1['category'];
	$doc_com=$sql_row1['compo_no'];
	$doc_mer=$binding_consumption_qty;
	$cat_ref='B';
	$total = $binding_consumption_qty;
	$docket_num[]=$sql_row1['doc_no'];
	{	
		echo "<td><input type=\"hidden\" name=\"doc[]\" value=\"".$sql_row1['doc_no']."\">";
		//For New Implementation
		echo "<input type=\"hidden\" name=\"doc_cat[]\" value=\"".$doc_cat."\">";
		echo "<input type=\"hidden\" name=\"doc_com[]\" value=\"".$doc_com."\">";
		echo "<input type=\"hidden\" name=\"doc_mer[]\" value=\"".$doc_mer."\">";
		echo "<input type=\"hidden\" name=\"cat_ref[]\" value=\"".$cat_ref."\">";
		//For New Implementation
		
		if($style_flag==0){
			if(sizeof($lotnos_array) ==''){
				$Disable_allocate=1;
			}
			echo "Please Provide Lot Numbers: <textarea class=\"form-control\" name=\"pms".$sql_row1['doc_no']."\" id='address' 
			      onkeyup='return verify_num(this,event)' onchange='return verify_num(this,event)' cols=12 rows=10 placeholder='No Lot Number Found, Please Enter Lot Number'>".$seperated_lots."</textarea><br/>";

		}else{

			echo "Please Provide Lot Numbers: <textarea class=\"form-control\" id='address' onkeyup='return verify_num(this,event)'
			     onchange='return verify_num(this,event)' name=\"pms".$sql_row1['doc_no']."\" cols=12 rows=10 ></textarea><br/>";

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


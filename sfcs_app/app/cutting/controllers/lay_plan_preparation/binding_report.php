<?php
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/functions.php',4,'R'));
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',4,'R'));
?>

<script>
var url = '<?= getFullURLLevel($_GET['r'],'binding_report.php',0,'N'); ?>';
function firstbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value 
} 

function secondbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value 
} 

function thirdbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value 
}
function forthbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value 
}
function fifthbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value+"&sub_po="+document.test.sub_po.value 
}

$(document).ready(function() {
	$('#schedule').on('click',function(e){
		var style = $('#style').val();
		if(style == null){
			sweetAlert('Please Select Style','','warning');
		}
	});
	$('#color').on('click',function(e){
		var style = $('#style').val();
		var schedule = $('#schedule').val();
		if(style == null && schedule == null){
			sweetAlert('Please Select Style and Schedule','','warning');
		}
		else if(schedule == null){
			sweetAlert('Please Select Schedule','','warning');
			document.getElementById("submit").disabled = true;
		}
		else {
			document.getElementById("submit").disabled = false;
		}
	});
});

//use this function for check all the boxes
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
</script>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<?php
	$get_style=$_GET['style'];
	$get_schedule=$_GET['schedule']; 
	$get_color=$_GET['color'];
	$get_mpo=$_GET['mpo'];
	$get_sub_po=$_GET['sub_po'];

?>

<div class = "panel panel-primary">
<div class = "panel-heading">Binding Request Form</div>
<div class = "panel-body">
<form name="test" action="<?php echo getFullURLLevel($_GET['r'],'binding_report.php','0','N'); ?>" method="post">
<?php
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
//function to get style from mp_color_details
if($plantcode!=''){
	$result_mp_color_details=getMpColorDetail($plantcode);
	$style=$result_mp_color_details['style'];
}
echo "<div class='row'>"; 
echo "<div class='col-sm-3'><label>Select Style: </label><select name=\"style\" onchange=\"firstbox();\" class='form-control' required>"; 
echo "<option value=\"\" selected>NIL</option>";
foreach ($style as $style_value) {
	if(str_replace(" ","",$style_value)==str_replace(" ","",$get_style)) 
	{ 
		echo '<option value=\''.$style_value.'\' selected>'.$style_value.'</option>'; 
	} 
	else 
	{ 
		echo '<option value=\''.$style_value.'\'>'.$style_value.'</option>'; 
	}
} 
echo "</select></div>";
//qry to get schedules form mp_mo_qty based on master_po_details_id 
if($get_style!=''&& $plantcode!=''){
	$result_bulk_schedules=getBulkSchedules($get_style,$plantcode);
	$bulk_schedule=$result_bulk_schedules['bulk_schedule'];
}  
echo "<div class='col-sm-3'><label>Select Schedule: </label><select name=\"schedule\" onchange=\"secondbox();\" class='form-control' required>";  
echo "<option value=\"\" selected>NIL</option>";
foreach ($bulk_schedule as $bulk_schedule_value) {
	if(str_replace(" ","",$bulk_schedule_value)==str_replace(" ","",$get_schedule)) 
	{ 
		echo '<option value=\''.$bulk_schedule_value.'\' selected>'.$bulk_schedule_value.'</option>'; 
	} 
	else 
	{ 
		echo '<option value=\''.$bulk_schedule_value.'\'>'.$bulk_schedule_value.'</option>'; 
	}
} 
echo "</select></div>";

//function to get color form mp_mo_qty based on schedules and plant code from mp_mo_qty
if($get_schedule!='' && $plantcode!=''){
	$result_bulk_colors=getBulkColors($get_schedule,$plantcode);
	$bulk_color=$result_bulk_colors['color_bulk'];
}
echo "<div class='col-sm-3'><label>Select Color: </label>";  
echo "<select name=\"color\" onchange=\"thirdbox();\" class='form-control' >
		<option value=\"NIL\" selected>NIL</option>";
			foreach ($bulk_color as $bulk_color_value) {
				if(str_replace(" ","",$bulk_color_value)==str_replace(" ","",$get_color)) 
				{ 
					echo '<option value=\''.$bulk_color_value.'\' selected>'.$bulk_color_value.'</option>'; 
				} 
				else 
				{ 
					echo '<option value=\''.$bulk_color_value.'\'>'.$bulk_color_value.'</option>'; 
				}
			} 
echo "</select></div>";

//function to get master po's from mp_mo_qty based on schedule and color
if($get_schedule!='' && $get_color!='' && $plantcode!=''){
	$result_bulk_MPO=getMpos($get_schedule,$get_color,$plantcode);
	$master_po_description=$result_bulk_MPO['master_po_description'];
}
echo "<div class='col-sm-3'><label>Select Master PO: </label>";  
echo "<select name=\"mpo\" onchange=\"forthbox();\" class='form-control' >
		<option value=\"NIL\" selected>NIL</option>";
			foreach ($master_po_description as $key=>$master_po_description_val) {
				if(str_replace(" ","",$master_po_description_val)==str_replace(" ","",$get_mpo)) 
				{ 
					echo '<option value=\''.$master_po_description_val.'\' selected>'.$key.'</option>'; 
				} 
				else 
				{ 
					echo '<option value=\''.$master_po_description_val.'\'>'.$key.'</option>'; 
				}
			} 
echo "</select></div>";

//function to get sub po's from mp_mo_qty based on master PO's
if($get_mpo!='' && $plantcode!=''){
	$result_bulk_subPO=getBulkSubPo($get_mpo,$plantcode);
	$sub_po_description=$result_bulk_subPO['sub_po_description'];
}
echo "<div class='col-sm-3'><label>Select Sub PO: </label>";  
echo "<select name=\"sub_po\" onchange=\"fifthbox();\" class='form-control' >
		<option value=\"NIL\" selected>NIL</option>";
			foreach ($sub_po_description as $key=>$sub_po_description_val) {
				if(str_replace(" ","",$sub_po_description_val)==str_replace(" ","",$get_sub_po)) 
				{ 
					echo '<option value=\''.$sub_po_description_val.'\' selected>'.$key.'</option>'; 
				} 
				else 
				{ 
					echo '<option value=\''.$sub_po_description_val.'\'>'.$key.'</option>'; 
				}
			} 
echo "</select></div>";

/* function to get binding dockets
	In below function is_binding=1 then it is binding docket
*/
	$bindingtype="1";
	if($get_sub_po!=''){
		$result_bindingdockets=getDocketDetails($get_sub_po,$plantcode,$bindingtype);
		$binding_dockets=$result_bindingdockets['docket_lines'];
	}
    echo "</br><div class='col-sm-3'>"; 
    if(sizeof($binding_dockets)>0)
    {
	  echo "Binding Dockets Available:"."<font color=GREEN class='label label-success'>YES</font>";
      echo "<input type=\"submit\" class=\"btn btn-primary\" value=\"Submit\" name=\"submit\" id='submit'>";
    }
    else
    {
      echo "Binding Dockets Available: <font color=RED size=5>No</font>"; 
    }		
	echo "</div>";	
echo "</div>"
?>

</form>
</br>
<?php
if(isset($_POST['submit']) && short_shipment_status($_POST['style'],$_POST['schedule'],$link_new))
{
	$style=$_POST['style']; 
    $color=$_POST['color']; 
	$schedule=$_POST['schedule']; 
	$mpo=$_POST['mpo'];
	$sub_po=$_POST['sub_po'];
	
	/**function to get po details
	 * @params:po_number
	 * @returns:po_description
	*/
	if($sub_po!=''){
		$resultPoDetails=getPoDetaials($sub_po,$plantcode);
		$po_description=$resultPoDetails['po_description'];
	}else{
		$po_description="No Description";
	}

	/**
	 * function to get dockets
	 * @param:po_number,plantcode,docket_type(norma-false,Binding-true)
	 * @return:docket_number
	 */
	if($sub_po!=''){
		$result_bindingdockets=getDocketDetails($sub_po,$plantcode,$bindingtype);
		$binding_dockets=$result_bindingdockets['docket_lines'];
	}
	//var_dump($binding_dockets);
	echo "<div class='col-sm-3'>
	<b>Style : </b> <h4><span class='label label-primary'>".$style."</span></h4>";
	echo "</div>";
	
	echo "<div class='col-sm-3'>
	<b>Schedule : </b> <h4><span class='label label-warning'>".$schedule."</span></h4>";
	echo "</div>";

	echo "<div class='col-sm-3'>
	<b>Color : </b> <h4><span class='label label-success'>".$color."</span></h4>";
	echo "</div>";
	
	echo "<div class='col-sm-3'>
	<b>PO : </b> <h4><span class='label label-info'>".$po_description."</span></h4>";
	echo "</div>";

	echo "<table class='table table-bordered'>";
	echo "<tr>
	<th>Fab Code</th>
	<th>Category</th>
	<th>Cut No-Docket No</th>";
	//echo"<th>Required Qty</th>";
	echo"<th>Category</th>
	<th>Binding Required Qty</th>
	<form action='".getFullURLLevel($_GET['r'],'binding_report.php','0','N')."' name='print' method='POST'>
	<th><input type='checkbox' onClick='checkAll()' />Select All</th>
	</tr>";
	$finalbindingqty=0;
	foreach($binding_dockets as $key=> $value){
		$docno=$key;
		/**function to get docket info 
		 * @params:docket_cumber
		 * @returns:ratio_component_group_id
		*/
		if($key!=''){
			$resultDocketInfo=getJmDockets($key,$plantcode);
			$ratio_comp_group_id=$resultDocketInfo['ratio_comp_group_id'];
			//echo "</br>Ratio Com :".$ratio_comp_group_id;
			$plies=$resultDocketInfo['plies'];
			$length=$resultDocketInfo['length'];
			$jm_cut_job_id=$resultDocketInfo['jm_cut_job_id'];
			//$style=$resultDocketInfo['style'];
			$fg_color=$resultDocketInfo['fg_color'];
			//for thr particular docket required qty will calculate marker_length*plies
			$finalbindingqty=$finalbindingqty+$material_required_qty;
			$material_required_qty=$plies*$length;

			/*
				function to get component group id and ratio id
				@params:ratio_comp_group_id,plant_code
				@returns:fabric_category,material_item_code and master_po_details_id information only
			*/
			$resultRatioComponentDetails=getRatioComponentGroup($ratio_comp_group_id,$plantcode);
			$fabric_category=$resultRatioComponentDetails['fabric_category'];
			$material_item_code=$resultRatioComponentDetails['material_item_code'];

			/**
			 * Function to get cut number wrt cutjobid
			 * @param:jm_cut_job_id
			 * @return:cut_number
			 */
			$resultCutNumber=getCutNumber($jm_cut_job_id);
			$cut_number=$resultCutNumber['cut_number'];
		}
		
		$gettingexistdata="select * from $pps.binding_consumption_items where compo_no='$material_item_code' and cutno='$cut_number' and doc_no='$docno' and plant_code='".$plantcode."'";
		$sql_result=mysqli_query($link_new, $gettingexistdata) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_confirm=mysqli_num_rows($sql_result);
		
		$gettingparentid="select parent_id from $pps.binding_consumption_items where compo_no='$material_item_code' and cutno='$cut_number' and doc_no='$docno' and plant_code='".$plantcode."'";
		$sql_result_parent=mysqli_query($link_new, $gettingparentid) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result_parent))
		{
			$parentid=$sql_row['parent_id'];
		}
		
		$printqry="select status from $pps.binding_consumption where id='$parentid' and plant_code='".$plantcode."'";
		$sql_result_print=mysqli_query($link_new, $printqry) or exit("Sql Error23".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result_print))
		{
			$printstatus=$sql_row['status'];
		}
		
		if($printstatus=='Open')
		{
			$status='Already Requested';
		}
		else
		{
			$status=$printstatus;
		}
		
		echo "<tr>";
		echo "<td>".$material_item_code."</td>";
		echo "<td>".$fabric_category."</td>";
		echo "<td>".$cut_number." - ".$docno."</td>";
		//echo "<td>".round($finalqtyexcludingbind,2)."</td>";
		echo "<td>Binding</td>";
		echo "<td>".round($material_required_qty,2)."</td>";
		if($sql_num_confirm<1)
		{
			echo "<td><input type='checkbox'  name='bindingdata[]' value='".$material_item_code.'#'.$fabric_category.'#'.$cut_number.'#0#0#'.$material_required_qty.'#'.$docno.'#'.$style.'#'.$schedule.'#'.$color.'#'.$sub_po.'#'.$plantcode.'#'.$username."'></td>";
		}
		else
		{
			echo"<td>".$status."</td>";
		}
		echo "</tr>";
	}
	echo "<tr>";
	echo "<td colspan=3 style='text-align: center;'> <b>Total :</b></td>";
	//echo "<td>".round($totordqty,2)."</td>";
	echo "<td></td>";
	echo "<td>".round($finalbindingqty,2)."</td>";
	echo "<td></td>";	
	echo "</tr>";
	echo "</table>";
	echo "<input type='submit'  value='Confirm To Request' class='btn btn-primary'></form>";
	
}

if(isset($_POST['bindingdata']))
{
	$binddetails=$_POST['bindingdata'];
	$count1=count($binddetails);
	$totordqty=0;
	$finalbindingqty=0;
	if($count1>0)
	{
		for($j=0;$j<$count1;$j++)
		{
			$id = $binddetails[$j];
			$exp=explode("#",$id);
			$compono=$exp[0];
			$category=$exp[1];
			$cutno=$exp[2];
			$bindingconsqty=$exp[3];
			$reqqty=$exp[4];
			$bindreqqty=$exp[5];
			$docno=$exp[6];
			$style=$exp[7];
			$schedule=$exp[8];
			$color=$exp[9];
			$po_number=$exp[10];
			$plantcode=$exp[11];
			$username=$exp[12];
			
			$totordqty=$totordqty+$reqqty;
			$finalbindingqty=$finalbindingqty+$bindreqqty;			
		}
			$insertqry="INSERT INTO $pps.binding_consumption(style,schedule,color,category,tot_req_qty,tot_bindreq_qty,po_number,status,plant_code,created_user,created_at,updated_user,updated_at) VALUES ('".$style."','".$schedule."','".$color."','".$category."',".$totordqty.",".$finalbindingqty.",'".$po_number."','Open','".$plantcode."','".$username."',NOW(),'".$username."',NOW())";
			mysqli_query($link_new, $insertqry) or exit("Sql Error25".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$parent_id = mysqli_insert_id($link_new);
			for($j=0;$j<$count1;$j++)
			{
				$id = $binddetails[$j];
				$exp=explode("#",$id);
				$compono=$exp[0];
				$category=$exp[1];
				$cutno=$exp[2];
				$bindingconsqty=$exp[3];
				$reqqty=round($exp[4],2);
				$bindreqqty=$exp[5];
				$docno=$exp[6];
				
				$insertbinditems="INSERT INTO $pps.binding_consumption_items(parent_id,compo_no,category,cutno,req_qty,bind_category,bind_req_qty,doc_no,plant_code,created_user,created_at,updated_user,updated_at) VALUES (".$parent_id.",'".$compono."','".$category."','".$cutno."',".$reqqty.",'Binding',".$bindreqqty.",".$docno.",'".$plantcode."','".$username."',NOW(),'".$username."',NOW())";
				mysqli_query($link_new, $insertbinditems) or exit("Sql Error26".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			echo "<script>swal('Binding Fabric Requested','Successfully','success')</script>";
		
	}
	else
	{
		echo "<script>swal('Please select','Check Box','warinig')</script>";
	}
	
}


?>  


   </div>
   </div>
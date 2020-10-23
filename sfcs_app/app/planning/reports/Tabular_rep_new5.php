<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',3,'R')); 
$plant_code=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
?>
<?php
error_reporting(0);
set_time_limit(6000000);
?>
<html>
<head>
<!--<link rel="stylesheet" type="text/css" media="all" href="<?= getFullURLLevel($_GET['r'],'common/js/jsdatepick-calendar/jsDatePick_ltr.min.css',1,'R'); ?>" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'reports/jsdatepick-calendar/jsDatePick.min.1.3.js',0,'R'); ?>"></script>-->
<script>

//<form name="test" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">

function firstbox()
{
	var cpo_value=document.test.cpo.value;
	if(cpo_value!='all'){
		window.location.href ="<?= 'index-no-navi.php?r='.$_GET['r']; ?>&cpo="+cpo_value;
		
	}else{
		window.location.href ="<?= 'index-no-navi.php?r='.$_GET['r']; ?>&cpo="+'all';
	}
	
}

function secondbox()
{
	var uriVal = "<?= 'index-no-navi.php?r='.$_GET['r']; ?>&cpo="+document.test.cpo.value+"&buyer_div="+document.test.buyer_div.value;
	window.location.href = uriVal;
}

function thirdbox()
{
	var uriVal = "<?= 'index-no-navi.php?r='.$_GET['r']; ?>&cpo="+document.test.cpo.value+"&buyer_div="+document.test.buyer_div.value+"&style="+document.test.style.value;
	window.location.href = uriVal;
}
// function fourthbox()
// {
// 	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&cpo="+document.test.cpo.value+"&buyer_div="+document.test.buyer_div.value+"&style="+document.test.style.value+"&style_id="+document.test.style_id.value;
// 	window.location.href = uriVal;
// }
function fifthbox()
{
	var uriVal = "<?= 'index-no-navi.php?r='.$_GET['r']; ?>&cpo="+document.test.cpo.value+"&buyer_div="+document.test.buyer_div.value+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value;
	window.location.href = uriVal;
}
function sixthbox()
{
	var uriVal = "<?= 'index-no-navi.php?r='.$_GET['r']; ?>&cpo="+document.test.cpo.value+"&buyer_div="+document.test.buyer_div.value+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+encodeURIComponent(document.test.color.value);
	window.location.href = uriVal;
}
function seventhbox()
{
	var uriVal = "<?= 'index-no-navi.php?r='.$_GET['r']; ?>&cpo="+document.test.cpo.value+"&buyer_div="+document.test.buyer_div.value+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+encodeURIComponent(document.test.color.value)+"&mpo="+document.test.mpo.value;
	window.location.href = uriVal;
}
$(document).ready(function() {
	$('#buyer_div').on('click',function(e){
		var style = $('#cpo').val();
		if(style == null){
			sweetAlert('Please Select CPO','','warning');
		}
		
	});
	$('#style').on('click',function(e){
		var cpo = $('#cpo').val();
		var buyer_div = $('#buyer_div').val();
		if(cpo == null && buyer_div == null){
			sweetAlert('Please Select CPO and Buyer Division','','warning');
		}
		else if(buyer_div == null){
			sweetAlert('Please Select Buyer Division','','warning');
			document.getElementById("submit").disabled = true;
		}
		else {
			document.getElementById("submit").disabled = false;
		}
	});

	$('#style_id').on('click',function(e){
		var cpo = $('#cpo').val();
		var buyer_div = $('#buyer_div').val();
		var style = $('#style').val();
		if(cpo == null && buyer_div == null && style == null){
			sweetAlert('Please Select CPO,Buyer Division and Style','','warning');
		}
	});
	$('#schedule').on('click',function(e){
		var cpo = $('#cpo').val();
		var buyer_div = $('#buyer_div').val();
		var style = $('#style').val();
		var style_id = $('#style_id').val();
		if(cpo == null && buyer_div == null && style == null && style_id == null){
			sweetAlert('Please Select CPO,Buyer Division Style and User Style ID','','warning');
		}
	});
	$('#color').on('click',function(e){
		var cpo = $('#cpo').val();
		var buyer_div = $('#buyer_div').val();
		var style = $('#style').val();
		var style_id = $('#style_id').val();
		var schedule = $('#schedule').val();
		if(cpo == null && buyer_div == null && style == null && style_id == null && schedule == null){
			sweetAlert('Please Select CPO,Buyer Division Style,User Style ID and Schedule','','warning');
		}
	});
});
</script>
<script type="text/javascript">
	window.onload = function()
	{
		
		new JsDatePick({
			useMode:2,
			target:"demo1",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"demo2",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
<script language="javascript" type="text/javascript" src="<?= '../'.getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R') ?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<link rel="stylesheet" href="<?= '../'.getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R') ?>" type="text/css" media="all" />
<!--<link href="<?= '../'.getFullURLLevel($_GET['r'],'common/css/table_style.css',3,'R') ?>" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?= '../'.getFullURL($_GET['r'],'jquery-1.3.2.js','R') ?>" ></script>
<link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',3,'R'); ?>" rel="stylesheet" type="text/css" />-->
<script type="text/javascript" src="<?= '../'.getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R') ?>" ></script>


</head>

<div class='panel panel-primary'><div class='panel-heading'>Order Status Report</div><div class='panel-body'>
<form method="POST" name="test" action="?r=<?php echo $_GET['r'];?>">

<?php
if(isset($_POST['submit1']))
{
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
	$cpo=$_POST['cpo'];
	$buyer_div=$_POST['buyer_div'];
	$style_id=$_POST['style_id'];
	$date_filter=$_POST['date_filter'];
	$from_date=$_POST['from_date'];
	$to_date=$_POST['to_date'];
	$get_mpo=$_POST['mpo']; 
	
}else{
	$style=$_GET['style'];
	$schedule=$_GET['schedule'];
	$color=$_GET['color'];
	$cpo=$_GET['cpo'];
	$buyer_div=$_GET['buyer_div'];
	$buyer_div1=$_POST['buyer_div'];
	$style_id=$_GET['style_id'];
	$from_date=$_GET['from_date'];
	$to_date=$_GET['to_date'];
	$get_mpo=$_GET['mpo'];
}
?>
<form name="test" action="<?php echo getFullURLLevel($_GET['r'],'tabular_rep_new5.php','0','N'); ?>" method="post">
<?php
	$sql="select distinct cpo from $oms.oms_mo_details where plant_code='$plant_code' order by cpo";	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);
	echo "<div class=\"row\"><div class=\"col-sm-2\"><label>Select CPO:</label><select class='form-control' name=\"cpo\"  id=\"cpo\" onchange=\"firstbox();\" required>";
	echo "<option value='' disabled selected>Please Select</option>";
	// if($cpo=="all") {
	// 	echo "<option value='all' selected>All</option>";
	// }else{
	// echo "<option value='all'>All</option>";
	// }
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		
		if(str_replace(" ","",$sql_row['cpo'])==str_replace(" ","",$cpo))
	    {
			echo "<option value=\"".$sql_row['cpo']."\" selected>".$sql_row['cpo']."</option>";	
		}
		else{
			echo "<option value=\"".$sql_row['cpo']."\" >".$sql_row['cpo']."</option>";
		}

	}

    echo "  </select>
	</div>";

	$sql_buyer="select distinct buyer_desc from $oms.oms_mo_details where plant_code='$plant_code' and cpo='$cpo' order by buyer_desc";
	$sql_result1=mysqli_query($link, $sql_buyer) or exit("Sql Error1a".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check1=mysqli_num_rows($sql_result1);
	echo "<div class=\"col-sm-3\"><label>Select Buyer Division:</label><select class='form-control' name=\"buyer_div\"  id=\"buyer_div\" onchange=\"secondbox();\" required>";
	
	echo "<option value='' disabled selected>Please Select</option>";
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{

		if(str_replace(" ","",$sql_row1['buyer_desc'])==str_replace(" ","",$buyer_div))
		 {
			echo "<option value=\"".$sql_row1['buyer_desc']."\" selected>".$sql_row1['buyer_desc']."</option>";
		}
	
		elseif(str_replace(" ","",$sql_row1['buyer_desc'])==str_replace(" ","",$buyer_div1)){
			echo "<option value=\"".$sql_row1['buyer_desc']."\" selected>".$sql_row1['buyer_desc']."</option>";
		}
		else{
			echo "<option value=\"".$sql_row1['buyer_desc']."\">".$sql_row1['buyer_desc']."</option>";
		}
	}
	echo "  </select>
	</div>";
	$sql_style="SELECT distinct style FROM $oms.oms_products_info LEFT JOIN $oms.oms_mo_details ON oms_mo_details.mo_number=oms_products_info.mo_number WHERE cpo='$cpo' AND buyer_desc='$buyer_div' AND oms_mo_details.plant_code='$plant_code' order by style";
	$sql_result2=mysqli_query($link, $sql_style) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	echo "<div class=\"col-sm-2\"><label>Select Style:</label><select class='form-control' name=\"style\"  id=\"style\" onchange=\"thirdbox();\" required>";
	echo "<option value='' disabled selected>Please Select</option>";
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{	

		if(str_replace(" ","",$sql_row2['style'])==str_replace(" ","",$style)){
			echo "<option value=\"".$sql_row2['style']."\" selected>".$sql_row2['style']."</option>";
		
		}else{
			echo "<option value=\"".$sql_row2['style']."\">".$sql_row2['style']."</option>";
		
		}	


	}
	echo "  </select>
    </div>";
	$sql_schedule="SELECT distinct schedule FROM $oms.oms_products_info LEFT JOIN $oms.oms_mo_details ON oms_mo_details.mo_number=oms_products_info.mo_number WHERE cpo='$cpo' AND buyer_desc='$buyer_div' AND style='$style' AND oms_mo_details.plant_code='$plant_code'";
	$sql_result4=mysqli_query($link, $sql_schedule) or exit("Sql Error1333".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check4=mysqli_num_rows($sql_result4);
	echo "<div class=\"col-sm-2\"><label>Select Schedule:</label><select class='form-control' name=\"schedule\"  id=\"schedule\" onchange=\"fifthbox();\" required>";
	
	echo "<option value='' disabled selected>Please Select</option>";
	while($sql_row4=mysqli_fetch_array($sql_result4))
	{
		$schedule1=$sql_row4['schedule'];
		//if(($_GET["schedule"])=="$schedule1")
		if(str_replace(" ","",$sql_row4['schedule'])==str_replace(" ","",$schedule))
		{
			echo "<option value=\"".$sql_row4['schedule']."\" selected>".$sql_row4['schedule']."</option>";

		}
	    else{
			echo "<option value=\"".$sql_row4['schedule']."\">".$sql_row4['schedule']."</option>";
		}
	
	}
	echo "  </select>
	</div>";

	$sql2="SELECT distinct color_desc as color FROM $oms.oms_products_info LEFT JOIN $oms.oms_mo_details ON oms_mo_details.mo_number=oms_products_info.mo_number WHERE cpo='$cpo' AND buyer_desc='$buyer_div' AND style='$style' AND schedule='$schedule' AND oms_mo_details.plant_code='$plant_code' order by color_desc";	
	$sql_result5=mysqli_query($link, $sql2) or exit("Sql Error122".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check5=mysqli_num_rows($sql_result5);
	echo "<div class=\"col-sm-3\"><label>Select Color:</label><select class='form-control' name=\"color\"  id=\"color\" onchange=\"sixthbox();\" required>";
	
	echo "<option value='' disabled selected>Please Select</option>";
	while($sql_row5=mysqli_fetch_array($sql_result5))
	{
		$color1=$sql_row5['color'];
		//if(($_GET["color"])=="$color1")
		if(str_replace(" ","",$sql_row5['color'])==str_replace(" ","",$color))
		{
			echo "<option value=\"".$sql_row5['color']."\" selected>".$sql_row5['color']."</option>";
	
		}else{
			echo "<option value=\"".$sql_row5['color']."\">".$sql_row5['color']."</option>";
		}
	
	}
	echo "  </select>
	</div>";
	
	/*function to get mpo from getdata_MPOs
	@params : plantcode,schedule,color
	@returns: mpo
	*/
	if($schedule!='' && $color!='' && $plant_code!=''){
		$result_bulk_MPO=getMpos($schedule,$color,$plant_code);
		$master_po_description=$result_bulk_MPO['master_po_description'];
	}
	echo "<div class='col-sm-3'><label>Select Master PO: </label>";  
	echo "<select style='min-width:100%' name=\"mpo\" onchange=\"seventhbox();\" class='form-control'>
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
	
	echo "<div class=\"col-sm-3\"><label> Exfactory From:</label>";
	
	echo'<input type="text" data-toggle="datepicker" class="form-control"  name="from_date" value="';if($from_date==""){ echo date("Y-m-d"); } else { echo $from_date; } echo '">';
	echo"</div>";
	echo "<div class=\"col-sm-3\"><label> Exfactory To:</label>";
	
	echo'<input type="text" data-toggle="datepicker" class="form-control"  name="to_date" value="';if($to_date==""){ echo date("Y-m-d"); } else { echo $to_date; }  echo '">';
	echo"</div>";
    echo '<input type="submit" name="submit1" value="Submit" class="btn btn-success" style="margin-top: 22px;">';
	echo"</div>";       
?>
</form>

<?php


if(isset($_POST['submit1']))
{
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
	$cpo=$_POST['cpo'];
	$buyer_div=$_POST['buyer_div'];
	$date_filter=$_POST['date_filter'];
	$from_date=str_replace("-", "", $_POST['from_date']);
	$to_date=str_replace("-", "", $_POST['to_date']);
	$mpo=$_POST['mpo'];



	// if($cpo=='all'){
	// 	$sql11="select * from  $oms.oms_mo_details where plant_code='$plant_code' and planned_delivery_date between \"$from_date\" and \"$to_date\"";
	// }
	// else{
		$sql11="select customer_order_no,planned_delivery_date from  $oms.oms_mo_details where po_number='$mpo' AND plant_code='$plant_code' and planned_delivery_date between \"$from_date\" and \"$to_date\"";
	// }
	//echo $sql11."<br>";
	$sql_result1122=mysqli_query($link, $sql11) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result11_count=mysqli_num_rows($sql_result1122);
	while($mo_row=mysqli_fetch_array($sql_result1122))
	{
		$cust_order=$mo_row['customer_order_no'];
		$exfact_date=$mo_row['planned_delivery_date'];
	}
	if($sql_result11_count>0)
	{
        //To get mpo description
		$qry_toget_podescri="SELECT master_po_description FROM $pps.mp_order WHERE master_po_number ='$mpo'";
		$toget_podescri_result=mysqli_query($link_new, $qry_toget_podescri) or exit("Sql Error at mp_order".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($mo_desc=mysqli_fetch_array($toget_podescri_result))
		{
		 $mpo_desc=$mo_desc['master_po_description'];
		}	
		
		echo '<form action="'."../".getFullURL($_GET['r'],"export_excel1.php",'R').'" method ="post" > 
		<input type="hidden" name="csv_123" id="csv_123">
		<input class="pull-right btn btn-info" type="submit" id="excel" value="Export to Excel" onclick="getCSVData()">
		</form>';

		//To get Total order qty
		$sql2="SELECT mo_quantity AS quantity FROM $oms.`oms_mo_details` WHERE schedule='$schedule' AND plant_code='$plant_code'";
		$sql_result2=mysqli_query($link, $sql2) or die("Error".$sql2.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row2=mysqli_fetch_array($sql_result2))
		{
			$total_order_qty=$row2['quantity'];
		}
		//To get finished_good_id
		$get_details="SELECT finished_good_id FROM $pts.finished_good WHERE style='$style' AND schedule='$schedule' AND color='$color' AND master_po='$mpo' AND plant_code='$plant_code' limit 1";
		$sql_result11=mysqli_query($link, $get_details) or exit("Sql Error get_details".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row_main=mysqli_fetch_array($sql_result11))
		{
			$fg_good_id= $row_main['finished_good_id'];   
		}
		//get operations
		$operations=array();
		$get_operations="SELECT DISTINCT operation_code FROM $pts.fg_operation WHERE finished_good_id='$fg_good_id'  AND plant_code='$plant_code' ORDER BY operation_code*1";
		$sql_result12=mysqli_query($link, $get_operations) or exit("Sql Error get_operations".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row1=mysqli_fetch_array($sql_result12))
		{
		  $operations[]=$row1['operation_code'];
		}
		echo "<div class='table-responsive'><table id=\"table1\"  class=\" table table-bordered\"><thead>";
		echo "<tr class='info'>";
		echo "<th>Customer Order</th>";
		echo "<th>MPO</th>";	
		echo "<th>CPO</th>";
		echo "<th>Buyer Division</th>";
		echo "<th>Style</th>";
		echo "<th>Schedule</th>";
		echo "<th>Color</th>";
		echo "<th>Ex-Factory Date</th>";
		echo "<th>Order Qty</th>";
		foreach ($operations as $key => $value)
		{
			echo "<th>Operation-$value</th>";
			echo "<th>Operation-$value Completed %</th>";
		}
		// echo "<th>Ship Qty</th>";
		// echo "<th>Shipping Completed %</th>";
		echo "</tr></thead><tbody>";

		$count=0;
		echo "<tr>";
		echo "<td>$cust_order</td>";
		echo "<td>$mpo_desc</td>";
		echo "<td>$cpo</td>";
		echo "<td>$buyer_div</td>";
		echo "<td>$style</td>";
		echo "<td>$schedule</td>";
		echo "<td>$color</td>";
		echo "<td>$exfact_date</td>";
		echo "<td>$total_order_qty</td>";
		$tot_qty=0;

		foreach($operations as $operation => $value)
		{
			$tot_qty=0;

			//To get finished_good_id
			$get_details1="SELECT finished_good_id FROM $pts.finished_good WHERE style='$style' AND schedule='$schedule' AND color='$color' AND master_po='$mpo' AND plant_code='$plant_code'";
			$sql_result111=mysqli_query($link, $get_details1) or exit("Sql Error get_details1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row2=mysqli_fetch_array($sql_result111))
			{
				$fg_id=$row2['finished_good_id'];
				
				//To get qty for operations
				$get_qty="SELECT fg_operation_id FROM $pts.fg_operation WHERE finished_good_id ='$fg_id' AND operation_code='$value' AND required_components = completed_components AND plant_code='$plant_code'";
				$sql_result112=mysqli_query($link, $get_qty) or exit("Sql Error get_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
				$result_num=mysqli_num_rows($sql_result112);
				if($result_num>0){

					$tot_qty++;
				}		 	
				
			}
			echo "<td>$tot_qty</td>";
			echo "<td>".round(($tot_qty/$total_order_qty)*100,0)."%</td>";
			
		}
		
		// echo  "<td>$ship_qty</td>";
		// if($order_qty>0 && $ship_qty>0)
		// {
		// 	echo "<td>".round(($ship_qty/$order_qty)*100,0)."%</td>";
		// }
		// else
		// {
		// 	echo "<td>0%</td>";
		// }
		echo "</tr>";
		$count++;	
		echo "</tbody></table></div>"; 
		// if($count==0){
		// 	echo "<div class=' col-sm-12'><p class='alert alert-danger'>No Data Found</p></div><script>$('#main_content').hide();</script>";
		// }
	}
	else
	{
		echo "<div class=' col-sm-12'><p class='alert alert-danger'>No Data Found</p></div><script>$('#main_content').hide();</script>";
	}
	
}

?>	

<script language="javascript">
function getCSVData(){
 var csv_value=$('#table1').table2CSV({delivery:'value'});
 $("#csv_123").val(csv_value);	
}
//<![CDATA[
	$('#reset_table1').addClass('btn btn-warning');
	var table6_Props = 	{
							rows_counter: true,
							btn_reset: true,
							// btn_reset_text: "Clear",
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "table1",table6_Props );
	$(document).ready(function(){
		$('#reset_table1').addClass('btn btn-warning btn-xs');
	});
	//]]>
</script>

</div></div>
</html>


	














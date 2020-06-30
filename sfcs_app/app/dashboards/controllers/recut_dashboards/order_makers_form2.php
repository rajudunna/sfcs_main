<!--
Change Log:
1. CR: 193 / kirang / 2014-2-19 : modify the user_style_id>0 as user_style_id not in (0,'') in marker_ref_matrix_view condition for displaying the 'MV' styles.
2. Service Request #716897/ kirang / 2015-5-16:  Add the User Style ID and Packing Method validations at Cut Plan generation 
-->

<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/php/functions.php',4,'R'));
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',4,'R'));
?>

<style>
	div.block
	{
		float: left;	
		padding: 30 px;
	}
</style>

<script type="text/javascript">
	function validateFloatKeyPress(el, evt)
	{
		var charCode = (evt.which) ? evt.which : event.keyCode;
		var number = el.value.split('.');
		if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
		{
			return false;
		}
		//just one dot
		if(number.length>1 && charCode == 46)
		{
			return false;
		}
		//get the carat position
		var caratPos = getSelectionStart(el);
		var dotPos = el.value.indexOf(".");
		if( caratPos > dotPos && dotPos>-1 && (number[1].length > 1))
		{
			return false;
		}
		return true;
	}

	function getSelectionStart(o)
	{
		if (o.createTextRange)
		{
			var r = document.selection.createRange().duplicate()
			r.moveEnd('character', o.value.length)
			if (r.text == '') return o.value.length
			return o.value.lastIndexOf(r.text)
		}
		else
		{
			return o.selectionStart
		}
	}
</script>

<script type="text/javascript" src="<?= '../'.getFullURLLevel($_GET['r'],'common/js/check.js',2,'R')?>"></script>
<!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->

<?php	
$tran_order_tid=order_tid_decode($_GET['tran_order_tid']);
$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
	$color=$sql_row['order_col_des'];
	$style=$sql_row['order_style_no'];
	$schedule=$sql_row['order_del_no'];
	$serial_no=$_GET['serial_no'];
}
//To get Encoded Color & style
$main_style = style_encode($style);
$main_color = color_encode($color);
?>

<div class="panel panel-primary">
<div class="panel-heading">Marker Form</div>
<div class="panel-body">
<?php echo "<a class=\"btn btn-xs btn-warning\" href=\"".getFullURLLevel($_GET['r'], "recut_lay_plan.php", "0", "N")."&color=$main_color&style=$main_style&schedule=$schedule&serial_no=$serial_no\"><i class=\"fas fa-arrow-left\"></i>&nbsp; Click here to Go Back</a>";?>	
<FORM method="post" name="input" action="<?php echo getFullURL($_GET['r'], "order_maker_process.php", "N"); ?>">
<?php

$cat_ref=$_GET['cat_ref'];
$tran_order_tid=order_tid_decode($_GET['tran_order_tid']);
$cuttable_ref=$_GET['cuttable_ref'];
$allocate_ref=$_GET['allocate_ref'];
$serial_no=$_GET['serial_no'];

echo "<input type='hidden' name='cat_ref' value='$cat_ref'>";
echo "<input type='hidden' name='tran_order_tid' value='$tran_order_tid'>";
echo "<input type='hidden' name='cuttable_ref' value='$cuttable_ref'>";
echo "<input type='hidden' name='allocate_ref' value='$allocate_ref'>";
echo "<input type='hidden' name='serial_no' value='$serial_no'>";


echo "<div class=block>";
echo "<input type=\"hidden\" name=\"tran_order_tid\" value=\"".$tran_order_tid."\">";
echo "<br/>";

echo '<div class="table-responsive"><table class="table table-bordered" id = "table-data">';
echo "<tr bgcolor= #ffffff; color= white; ><th>Marker Type</th><th>Marker Version</th><th>Shrinkage Group</th><th>Width</th><th>Marker Length</th><th>Marker Name</th><th>Pattern Name</th><th>Marker Eff.</th><th>Perimeters</th><th>Remarks 1</th><th>Remarks 2</th><th>Remarks 3</th><th>Remarks 4</th></tr>";
echo '<tbody id = "body-data">';
for ($i=0; $i < 5; $i++) { 
	
	echo '<tr>
		<td><input class="form-control"  type="text" name="in_mktype['.$i.']" id="mk_type_'.$i.'"  title="please enter numbers and decimals"></td>
		<td><input class="form-control"  type="text" name= "in_mkver['.$i.']" id= "mk_ver_'.$i.'" onchange="validate_data('.$i.',this)" title="please enter numbers and decimals"></td>
		<td><input class="form-control"  type="text" name= "in_skgrp['.$i.']" id= "sk_grp_'.$i.'" onchange="validate_data('.$i.',this)" title="please enter numbers and decimals"></td>
		<td><input class="form-control"  type="text" name= "in_width['.$i.']" id= "width_'.$i.'" onchange="validate_data('.$i.',this)" title="please enter numbers and decimals"></td>
		<td><input class="form-control"  type="text" name= "in_mklen['.$i.']" id= "mk_len_'.$i.'" onchange="validate_data('.$i.',this)" title="please enter numbers and decimals"></td>
		<td><input class="form-control"  type="text" name= "in_mkname['.$i.']" id="mk_name_'.$i.'" onchange="mk_name_validate('.$i.',this)" title="please enter numbers and decimals"></td>
		<td><input class="form-control"  type="text" name= "in_ptrname['.$i.']" id="ptr_name_'.$i.'" title="please enter numbers and decimals"></td>
		<td><input class="form-control"  type="text" name= "in_mkeff['.$i.']" id= "mk_eff_'.$i.'" title="please enter numbers and decimals"></td>
		<td><input class="form-control"  type="text" name= "in_permts['.$i.']" id= "permts_'.$i.'" title="please enter numbers and decimals"></td>
		<td><input class="form-control"  type="text" name= "in_rmks1['.$i.']" id= "rmks1_'.$i.'" title="please enter numbers and decimals"></td>
		<td><input class="form-control"  type="text" name= "in_rmks2['.$i.']" id= "rmks2_'.$i.'" title="please enter numbers and decimals"></td>
		<td><input class="form-control"  type="text" name= "in_rmks3['.$i.']" id= "rmks3_'.$i.'" title="please enter numbers and decimals"></td>
		<td><input class="form-control"  type="text" name= "in_rmks4['.$i.']" id= "rmks4_'.$i.'" title="please enter numbers and decimals"></td>
		</tr>';
		/*
		<td><input class="btn btn-sm btn-danger" onclick="deleteRow('.$i.')" type = "button" id="delete" name = "delete" value = "Delete Row"></td>
		</tr>';
		*/
}
// echo "<input class='form-control'  type='text' name= 'rows' id= 'rows' value =".$j.">";
echo '<tbody>';
echo "</table>";
echo '<input class="btn btn-sm btn-success pull-right" onclick="add_input_row()" type = "add" id="add_row" name = "update" value = " + Add Row"></div>';

//echo "<div class="col-md-offset-8\"><input type=\"checkbox\" name=\"option\"  id=\"option\" onclick=\"javascript:enableButton();\">Enable&nbsp;&nbsp;&nbsp;";
echo "<input class=\"btn btn-sm btn-success\" onclick='return verify_null()' type = \"submit\" id=\"create\" name = \"update\" value = \"Create\"></div>";
echo "</form>";
echo "</div>";
echo "<br/>";





?>
</div></div>

<script type="text/javascript">
Array.prototype.diff = function(arr2) {
    var ret = [];
    for(var i in this) {   
		if(this[i] != ''){
			if(arr2.indexOf(this[i]) > -1){
            	ret.push(this[i]);
        	}
		}

    }
    return ret;
};

function compareArrays(arr1, arr2){
	console.log(arr1.toString());
	console.log(arr2.toString());
	if(arr1.toString() == arr2.toString()){
		return true;
	}else{
		return false;
	}
}

function mk_name_validate(b,id_name){
	if($("#mk_name_"+b).val() != ''){
		var rowData=[];
		var CurData=[];
		var table = $("#body-data");
		CurData = [$("#mk_name_"+b).val()];
		var tr_length= table.find('tr').length;
		for (let index = 0; index <= tr_length; index++) {
			if(index!= b && $("#mk_name_"+index).val()){
				for (let index1 = 1; index1 <= 4; index1++) {
					rowData = [$("#mk_name_"+index).val()];
					if(compareArrays(CurData, rowData)){
						swal('Marker Name Must be Unique','Warning !','warning');
						$("#"+id_name.id).val('');
						return true;
					}
				}
			}
		}
	}
}

function validate_data(b, id_name) {
	if($("#mk_ver_"+b).val() != '' && $("#sk_grp_"+b).val() != '' && $("#width_"+b).val() != '' && $("#mk_len_"+b).val()){
		var rowData=[];
		var CurData=[];
		var table = $("#body-data");
		CurData = [$("#mk_ver_"+b).val(), $("#sk_grp_"+b).val(), $("#width_"+b).val(), $("#mk_len_"+b).val()];
		var tr_length= table.find('tr').length;
		
		for (let index = 0; index <= tr_length; index++) {
			if(index!= b && $("#mk_ver_"+index).val() != '' && $("#sk_grp_"+index).val() != '' && $("#width_"+index).val() != '' && $("#mk_len_"+index).val()){
				for (let index1 = 1; index1 <= 4; index1++) {
					rowData = [$("#mk_ver_"+index).val(), $("#sk_grp_"+index).val(), $("#width_"+index).val(), $("#mk_len_"+index).val()];
					if(compareArrays(CurData, rowData)){
					swal('Using Same combinations...','Please Check.','warning');
						$("#"+id_name.id).val('');
						return true;
					}

				}
			}
		}
	}
}
function validateQty(event) 
{
	event = (event) ? event : window.event;
	var charCode = (event.which) ? event.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}
function validate_remarks(){
	console.log($('#remarks_id').val());
	var reg1 = /"/g;
	var reg2 = /'/g;


	if($('#remarks_id').val().match(reg1) || $('#remarks_id').val().match(reg2)){
		$('#remarks_id').val('');
	}
	// console.log($('#remarks_id').val().match(reg) );
}


function verify_null(){
	// var ver = document.getElementById('mk_ver').value;
	// var eff =  document.getElementById('sk_grp').value;
	// var width = document.getElementById('width').value;
	// var mklen = document.getElementById('mk_len').value;

	// console.log(ver);
	// console.log(eff);
	// console.log(width);
	// console.log(mklen);
	// if(ver == ''){
		// sweetAlert('Please enter valid Marker Version','','warning');
		// return false;
	// }
	// if(eff == ''){
		// sweetAlert('Please enter valid Marker Eff','','warning');
		// return false;
	// }
	// if(mklen <=0)
	// {
		// sweetAlert('Please enter valid Marker Length','','warning');
		// return false;
	// }
	// if(width <=0){
		// sweetAlert('Please enter valid Marker Width','','warning');
		// return false;
	// }
	// if(mklen == ''|| mklen <=0){
		// sweetAlert('Please enter valid Marker Length','','warning');
		// return false;
	// }
	// if(eff == '')
	// {
		// eff = 0;
	// }
	// if(eff>100){
		// sweetAlert('Please enter valid Marker Efficiency','','warning');
		// return false;
	// }
	// if(ver <=0 || ver ==''){
		// sweetAlert('Please enter valid Marker Version','','warning');
		// return false;
	// }
	
	var flag1=1;
	var table = $("#body-data");
	var tr_length= table.find('tr').length;
	console.log(tr_length);
	for (let index = 0; index < tr_length; index++) {
		if($("#mk_ver_"+index).val() != '' && $("#sk_grp_"+index).val() != '' && $("#width_"+index).val() != '' && $("#mk_len_"+index).val())
		{
			flag1 = 0;
		}
	}	
	if(flag1 == 0)
	{		
		//sweetAlert('Please enter valid Marker','','warning');
		//document.getElementById('create').style.display="none";
		return true;	
	}
	else
	{
		sweetAlert('Please enter valid Marker Group','','warning');
		//document.getElementById('create').style.display="none";
		return false;
	}
	
}

function add_input_row() {
	var flag = 0;
	var table = $("#body-data");
	var tr_length= table.find('tr').length;
		for (let index = 0; index < tr_length; index++) {
			if($("#mk_ver_"+index).val() != '' && $("#sk_grp_"+index).val() != '' && $("#width_"+index).val() != '' && $("#mk_len_"+index).val()){
				flag = 0;
			}
			else{
				flag = 1;
			}

		}
	if(flag == 0)
	{
		var row = $('#table-data >tbody >tr').length;
		var rowCount = row -1;
		var table = document.getElementById("table-data");
		var row = table.insertRow();
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		var cell3 = row.insertCell(2);
		var cell4 = row.insertCell(3);
		var cell5 = row.insertCell(4);
		var cell6 = row.insertCell(5);
		var cell7 = row.insertCell(6);
		var cell8 = row.insertCell(7);
		var cell9 = row.insertCell(8);
		var cell10 = row.insertCell(9);
		var cell11 = row.insertCell(10);
		var cell12 = row.insertCell(11);
		var cell13 = row.insertCell(12);
		cell1.innerHTML = "<input class='form-control float'  name='in_mktype["+rowCount+"]' id='mk_type_"+rowCount+"' type='text' title='Please enter numbers and decimals'>";
		cell2.innerHTML = "<input class='form-control float'  name='in_mkver["+rowCount+"]' id='mk_ver_"+rowCount+"' type='text' onchange='validate_data("+rowCount+",this)' title='Please enter numbers and decimals'>";
		cell3.innerHTML = "<input class='form-control float'  name='in_skgrp["+rowCount+"]' id='sk_grp_"+rowCount+"' type='text' onchange='validate_data("+rowCount+",this)' title='Please enter numbers and decimals'>";
		cell4.innerHTML = "<input class='form-control float'  name='in_width["+rowCount+"]' id='width_"+rowCount+"' type='text' onchange='validate_data("+rowCount+",this)' title='Please enter numbers and decimals'>";
		cell5.innerHTML = "<input class='form-control float'  name='in_mklen["+rowCount+"]' id='mk_len_"+rowCount+"' type='text' onchange='validate_data("+rowCount+",this)' title='Please enter numbers and decimals'>";
		cell6.innerHTML = "<input class='form-control float'  name='in_mkname["+rowCount+"]' id='mk_name_"+rowCount+"' onchange='mk_name_validate("+rowCount+",this)' type='text' title='Please enter numbers and decimals'>";
		cell7.innerHTML = "<input class='form-control float'  name='in_ptrname["+rowCount+"]' id='ptr_name_"+rowCount+"' type='text' title='Please enter numbers and decimals'>";
		cell8.innerHTML = "<input class='form-control float'  name='in_mkeff["+rowCount+"]' id='mk_eff_"+rowCount+"' type='text' title='Please enter numbers and decimals'>";
		cell9.innerHTML = "<input class='form-control float'  name='in_permts["+rowCount+"]' id='permts_"+rowCount+"' type='text' title='Please enter numbers and decimals'>";
		cell10.innerHTML = "<input class='form-control float'  name='in_rmks1["+rowCount+"]' id='rmks_1"+rowCount+"'  type='text' title='Please enter numbers and decimals'>";
		cell11.innerHTML = "<input class='form-control float'  name='in_rmks2["+rowCount+"]' id='rmks_2"+rowCount+"'  type='text' title='Please enter numbers and decimals'>";
		cell12.innerHTML = "<input class='form-control float'  name='in_rmks3["+rowCount+"]' id='rmks_3"+rowCount+"'  type='text' title='Please enter numbers and decimals'>";
		cell13.innerHTML = "<input class='form-control float'  name='in_rmks4["+rowCount+"]' id='rmks_4"+rowCount+"'  type='text' title='Please enter numbers and decimals'>";
		}
	else{
		sweetAlert('Please fill the previous rows','','warning');
	}
}
function deleteRow(row) {
    document.getElementById('table-data').deleteRow(row+1);
}
// function delete_row(id) {
// 	console.log($(this).closest("tr"));
// 	 $(this).closest("tr").remove();
// 	// console.log();
// }
</script>
 
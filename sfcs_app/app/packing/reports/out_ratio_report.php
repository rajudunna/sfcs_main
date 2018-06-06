<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	      ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R') );  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R') );  ?>

<?php

$view_access=user_acl("SFCS_0037",$username,1,$group_id_sfcs);
$form_action = getFullURL($_GET['r'],'out_ratio_report_data.php','N');

?>

<script language="javascript" type="text/javascript">

function popitup(url) {
	newwindow=window.open(url,'name','height=1200,width=1050');
	if (window.focus) {newwindow.focus()}
	return false;
}

function verify(e){
	if($('#cat').val() == 0){		
		sweetAlert('Please Select Criteria','','warning');
		e.preventDefault();
		return false;
	}
}

function verify_date(){
	var from_date = $('#sdate').val();
	var to_date   = $('#edate').val();

	if(from_date.length > 2 || to_date.length > 2){
		$('#sdate').val(from_date.substr(0,2));
		$('#edate').val(to_date.substr(0,2));
		sweetAlert('Only 2 digits are allowed','','info');
	}

	if(to_date < from_date){
		$('#edate').val($('#sdate').val());
		sweetAlert('End Week must not be less than Start Week','','warning');
		return false;
	}
	if(to_date > 53 || from_date > 53){
		$('#sdate').val(0);
		$('#edate').val(0);
		sweetAlert('Week should not exceed 53','','warning');
		return false;
	}
	if(to_date <0 || from_date<0){
		sweetAlert('Weeks Must not be negative','','warning');
		$('#sdate').val(1);
		$('#edate').val(1);
		return false;
	}

}

function limit_date(e){
	var k = e.which;
	if(k == 187 || k == 189 || k==43 || k==45){
		sweetAlert('No special characters','','danger');
		e.preventDefault();
		return false;
	}
 	var from_date = $('#sdate').val();
 	var to_date = $('#edate').val();
		if(from_date.length > 2 || to_date.length > 2){
			sweetAlert('Only 2 digits are allowed','','info');
			e.preventDefault();
			$('#sdate').val(from_date.substr(0,2));
			$('#edate').val(to_date.substr(0,2));
			return false;
		}

}

function verify_year(){
	var year = $('#year').val();
	if(year < 2000 || year > 2030){
		sweetAlert('Please enter a valid year','','warning');
		$('#year').val(2017);
	}
}

</script>

<title>Out Of Ratio Report</title>
<style>
	th,td { color : #000;}
</style>

<body>
<div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Out Of Ratio Reported</b>
	</div>
	<div class='panel-body'>
		<form action="<?php echo $form_action ?>" method="POST">
			<div class='col-sm-2 form-group'>
				<label for='sdat'>Week Start </label>
				<input class='form-control integer' type="text" id='sdate' name="sdat"  onkeydown='return limit_date(event)' placeholder='00' >
			</div>
			<div class='col-sm-2 form-group'>
				<label for='edat'>Week End </label>
				<input class='form-control integer' type="text" id='edate' name="edat"  onkeydown='return limit_date(event)'placeholder='00' >
			</div>
			<div class='col-sm-2 form-group'>
				<label for='year'>Year </label>
				<input required class='form-control' id='year' onchange=verify_year() type="number" size="4" placeholder='2017' name="year" value="<?php echo date("Y"); ?> ">
			</div>
			<div class='col-sm-2 form-group'>
				<label for='cat'>Criteria </label>
				<select class='form-control' name="cat" id='cat' required>
					<option value="0">Select</option>
					<option value="1">Reported Date</option>
					<option value="2">Ex-Factory Date</option>
				</select>
			</div>
			<div class='col-sm-2 form-group'>
				<label for='sche'>Schedule </label>
				<input required class='form-control' type="number" name="sche" size="8" value=""/>
			</div>
			<div class='col-sm-1'>
				<br>
				<input class='btn btn-success' type="submit" id='submit' name="submit" value="submit" 
				     onclick="return verify_date()" >
			</div>
		</form>
<?php
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);
if($username=="amulyap" or $username=="kirang")
{
	echo "<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href='".getFullURL($_GET['r'],'out_of_ratio_report.xls','N')."'>Export To Excel</a> | 
		  <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href='out_ratio_report_data.php'>Destroy Interface</a>";
}

?>
  </div>
</div>

<span id="msg" style="display:none;"><h4>Please Wait.. While Processing The Data..<h4></span>

 </div>
 </div>
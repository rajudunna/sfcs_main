<?php 
    include("..".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include("..".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
//$view_access=user_acl("SFCS_0062",$username,1,$group_id_sfcs);//1 
?>

<!--<script language="javascript" type="text/javascript" src="../styles/dropdowntabs.js"></script>
<link rel="stylesheet" href="../styles/ddcolortabs.css" type="text/css" media="all" />
--><!--IMPORT CSS STYLE SHEET FOR APPLYING FORMATING SETTINGS-->
<!--<link rel="stylesheet" type="text/css" href="test.css" />-->


<!---<div id="page_heading"><div id="page_heading"><span style="float:"><h3>Department Wise Down Time Report</h3></span><span style="float: right"> </span></div></div>--->
<!--<h2 align="center" style="color:red;">Department Wise Down Time Report </h2>-->
<script >
function verify_date()
{
	var val1 = $('#dat1').val();
	var val2 = $('#dat2').val();
	// d1 = new Date(val1);
	// d2 = new Date(val2);
	if(val1 > val2){
		sweetAlert('Start Date Should  be less than End Date','','warning');
		return false;
	}
	else
	{
	    return true;
	}
}
</script>


<?php 
?>
<form action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">
<div class='panel panel-primary'>
	<div class='panel-heading'>Department DownTime</div>
	<div class='panel-body'>
		<div class='row'>
			<div class="col-md-3">
				<label>Start Date</label>
				<input type="text" data-toggle="datepicker" name="dat" id="dat1" size="8" class="form-control" value="<?php print(date("Y-m-01")); ?>"/>
			</div>
			<div class="col-md-3">
				<label>End Date</label>
				<input type="text" data-toggle="datepicker" name="dat1" id="dat2" size="8" class="form-control" value="<?php print(date("Y-m-d")); ?>"/>
			</div>
			<div class="col-md-3">
				<label>Select Category</label>
				<select name="cat" class="select2_single form-control"> 
					<option>Please Select</option>
					<option>Section</option>
					<option>Date</option>
				</select>
			</div>
			<div class="col-md-3">
			<input type="submit" value="Show" class="btn btn-success" name="submit" onclick ="return verify_date()" style="margin-top:22px;"/>
			</div>
		</div>

</form>


<?php

if(isset($_POST["submit"]))
{
	if($_POST["cat"] == "Section")
	{
		header("Location:".getFullURL($_GET['r'],'downtime_section.php','N')."&sdat=".$_POST['dat']."&edat=".$_POST['dat1']."");
	}
	else if($_POST["cat"] == "Date")
	{
		header("Location:".getFullURL($_GET['r'],'downtimeperperiode_data.php','N')."&sdat=".$_POST['dat']."&edat=".$_POST['dat1']."");
	}
	else
	{
		echo "<script>sweetAlert('Oops!','Please Select Correct Category','warning');</script>";
	}
}

?>
</div>
</div>



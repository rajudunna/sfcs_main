<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));
$view_access=user_acl("SFCS_0055",$username,1,$group_id_sfcs);
?>
<?php  

$reasons=array("Miss Yarn","Fabric Holes","Slub","Foreign Yarn","Stain Mark","Color Shade","Panel Un-Even","Stain Mark","Strip Match","Cut Dmg","Stain Mark","Heat Seal","M ment Out","Shape Out","Emb Defects");

?>
<script src="https://cdn.ovo.ua/pub/fusioncharts/fusioncharts.js"></script> 
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<script>
function verify_date(e){
	var from = document.getElementById('demo1').value;
	var to =   document.getElementById('demo2').value;
	if(from > to){
		sweetAlert('From date should not be greater than To Date','','warning');
		e.preventDefault();
		return false;
	}
	return true;
}

</script>

<!---<style>
body
{
	font-family:calibri;
	font-size:12px;
}

table tr
{
	text-align: right;
	white-space:nowrap;
}

table td
{
	text-align: right;
	white-space:nowrap;
}

table td.lef
{
	text-align: left;
	white-space:nowrap; 
}
table th
{
	text-align: center;
	color: WHITE;
	white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}


}

}
</style>--->



	<div class='panel panel-primary'>
	<div class='panel-heading'>
		<b style='font-size:15px'>Rejection Analysis Charts - Supplier Wise</b>
	</div>
	<div class='panel-body'>
		<form name="input" method="POST" action="?r=<?= $_GET['r'] ?>">
			<div class='col-sm-2'>
				<label>Start Date</label>
				<input class='form-control' id="demo1" data-toggle='datepicker' type="text" name="sdate" size="8" value="<?php if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>"> 
			</div>
			<div class='col-sm-2'>
				<label>End Date</label> 
				<input class='form-control' id="demo2" data-toggle='datepicker' type="text" size="8" name="edate" value="<?php if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>">
			</div>
			<div class='col-sm-2'> 
				Team: <select name="team" class="form-control">
				<?php 
				for ($i=0; $i < sizeof($shifts_array); $i++) {?>
				<option <?php echo 'value="'.$shifts_array[$i].'"'; if($shift==$shifts_array[$i]){ echo "selected";} ?>><?php echo $shifts_array[$i] ?></option>
				<?php }
				?>
				</select>
			</div>
			<div class='col-sm-2'>
				<br/><br/>
				<input type="radio" name="check_list[]" <?php if ($_POST['check_list'] === '1') echo "checked";?> value="1">
				<label>Supplier Wise</label>&nbsp;&nbsp; 
			</div>
			<div class='col-sm-2'>
				<br/><br/>
				<input type="radio" name="check_list[]" <?php if (isset($_POST['check_list']) && $_POST['check_list']=="2") echo "checked"; ?> value="2">
				<label>Supplier Reason Wise</label>&nbsp;&nbsp;
			</div>
			<div class='col-sm-2'>
				<label></label><br/>
				<input type="submit" class='btn btn-success' onclick='return verify_date(event)' name="filter" value="Filter">
			</div>
		</form>

<!-- </div> -->

<?php

if(isset($_POST['filter']))
{
	// echo 'AHI ';

	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	$team=$_POST['team'];
	
	if(!empty($_POST['check_list']))
	{
		// Loop to store and display values of individual checked checkbox.
		foreach($_POST['check_list'] as $selected)
		{
			if($selected==1)
			{	
				 //echo 'welcome 1';
				include("rejection_chart_reason_sup.php");
			}

			if($selected==2)
			{
				 //echo 'welcome 2';
				include("rejection_chart_reason_sup_week.php");
				include("rejection_chart_reason_sup_week_v2.php");
			}
		}
	}
}

?>

	</div>
</div>


<script>
function getCSVData(){
 var csv_value=$('#example1').table2CSV({delivery:'value'});
 $("#csv_text").val(csv_value);	
}


	
}
</script>




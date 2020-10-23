<?php


    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
	//$view_access=user_acl("SFCS_0245",$username,1,$group_id_sfcs); 
	$plantcode=$_SESSION['plantCode'];
	$username=$_SESSION['userName'];
?>

<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>

</script>
		
<style>
table {	
	text-align:center;
	font-size:12px;
	width:100%;
	padding: 1em 1em 1em 1em;
	color:black;
}
th{
	background-color:#29759c;
	color:white;
	text-align:center;
}
</style>

<div class="panel panel-primary">
<div class="panel-heading">IMS Module Transfer Report</div>
<div class="panel-body">
<div id="page_heading" class="form-group">
	<form name="input" method="post" action="?r=<?php echo $_GET['r']; ?>">
	<div class="col-md-3">
	<label>Start Date</label> <input type="text" data-toggle='datepicker' id="dat1" name="sdate" size="10" value="" class="form-control"> 
	</div>
	<input type="submit" name="submit" value="submit" class="btn btn-success" style = "margin-top:18px">
	</form>


<?php
if(isset($_POST['submit']))
{
	
	$sdate=$_POST['sdate'];



$sql="select *,count(*) as bundle_count,date(created_at) as created_at1 from $tms.bundle_transfer_log where plant_code='$plantcode' and date(created_at) = '$sdate' group by job_no_ref";
// echo $sql."<br>";
 $result=mysqli_query($link, $sql) or exit("Problem in getting section".mysqli_error($GLOBALS["___mysqli_ston"]));

$x=0;
if(mysqli_num_rows($result) > 0)
{
	echo "<div class='table-responsive'><table class='table table-bordered' id='table2'><thead><tr><th>Sno</th><th>From Module</th><th>To Module</th><th>Bundles Count</th><th>User</th><th>Control</th></tr><thead>";
	while($row=mysqli_fetch_array($result))
    {
		$from_module=$row['from_resource'];
		$to_module=$row['to_resource'];
		$bundle_count=$row['bundle_count'];
		$job_no_ref=$row['job_no_ref'];
		$created_user=$row['created_user'];
		$created_at= $row['created_at1'];

		$query = "select workstation_code from $pms.workstation where plant_code='$plant_code' and workstation_id = '$from_module'";
		$sql_res = mysqli_query($link_new, $query) or exit("Sql Error at Section details" . mysqli_error($GLOBALS["___mysqli_ston"]));
		$workstation_rows_num = mysqli_num_rows($sql_res);
		if($workstation_rows_num > 0) {
			while ($workstation_row = mysqli_fetch_array($sql_res)) {
				$from_module_data = $workstation_row['workstation_code'];
			}
		}

		$query = "select workstation_code from $pms.workstation where plant_code='$plant_code' and workstation_id = '$to_module'";
		$sql_res = mysqli_query($link_new, $query) or exit("Sql Error at Section details" . mysqli_error($GLOBALS["___mysqli_ston"]));
		$workstation_rows_num = mysqli_num_rows($sql_res);
		if($workstation_rows_num > 0) {
			while ($workstation_row = mysqli_fetch_array($sql_res)) {
				$to_module_data = $workstation_row['workstation_code'];
			}
		}

		$x++;
		$sidemenu=true;
		$print_sheet=getFullURLLevel($_GET["r"],"ims_mod_report.php",0,"N");

		echo "<tr>";
		echo "<td>".$x."</td>";
		echo "<td>".$from_module_data."</td>";
		echo "<td>".$to_module_data."</td>";
		echo "<td>".$bundle_count."</td>";
		echo "<td>".$created_user."</td>";
		echo "<td><input type='button' class='btn btn-primary' href=\"?r=$print_sheet&job_no_ref=$job_no_ref&created_date=$created_date&plantcode=$plantcode&sidemenu=$sidemenu\" onclick=\"return popitup_new('$print_sheet&job_no_ref=$job_no_ref&created_at=$created_at&plantcode=$plantcode&sidemenu=$sidemenu')\" name='submit' id='submit' value='View'></input></td>";
		echo "</tr>";
	}
echo "</table></div>";
}
else {
		echo "<script>sweetAlert('Oops!','No Data Found','error')</script>";
	}
}
?>
</div></div>
<script> 


function popitup_new(url) { 

newwindow=window.open(url,'name','scrollbars=1,menubar=1,resizable=1,location=0,toolbar=0'); 
if (window.focus) {newwindow.focus();} 
return false; 
} 
</script> 
<script language="javascript" type="text/javascript">
//<![CDATA[
	$('#reset_table2').addClass('btn btn-warning');
	var table6_Props = 	{
							rows_counter: true,
							btn_reset: true,
							btn_reset_text: "Clear",
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "table2",table6_Props );
	$('#reset_table2').addClass('btn btn-warning btn-xs');
//]]>
</script>
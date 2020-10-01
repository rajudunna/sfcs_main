<?php


    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
	$view_access=user_acl("SFCS_0245",$username,1,$group_id_sfcs); 
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

echo "<div class='table-responsive'><table class='table table-bordered' id='table2'><thead><tr><th>Sno</th><th>From Module</th><th>To Module</th><th>Total Bundles</th><th>User</th><th>Control</th></tr><thead>";

$sql="select from_module,to_module,count(bundle_number) as bundle_count,created_user,date(created_at) as created_date from $pts.module_bundle_track where plant_code='$plantcode' and date(created_at) = '$sdate' group by from_module,to_module";
// echo $sql."<br>";
$result=mysqli_query($link, $sql) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));

$x=0;
if(mysqli_num_rows($result) > 0)
{
	while($row=mysqli_fetch_array($result))
	{
		$from_module=$row['from_module'];
		$to_module=$row['to_module'];
		$bundle_count=$row['bundle_count'];
		$created_user=$row['created_user'];
		$created_date=$row['created_date'];

		$x++;
		$sidemenu=true;
		$print_sheet=getFullURLLevel($_GET["r"],"ims_mod_report.php",0,"N");

		echo "<tr>";
		echo "<td>".$x."</td>";
		echo "<td>".$from_module."</td>";
		echo "<td>".$to_module."</td>";
		echo "<td>".$bundle_count."</td>";
		echo "<td>".$created_user."</td>";
		echo "<td><input type='button' class='btn btn-primary' href=\"?r=$print_sheet&from_module=$from_module&to_module=$to_module&created_date=$created_date&plantcode=$plantcode&sidemenu=$sidemenu\" onclick=\"return popitup_new('$print_sheet&from_module=$from_module&to_module=$to_module&created_date=$created_date&plantcode=$plantcode&sidemenu=$sidemenu')\" name='submit' id='submit' value='View'></input></td>";
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
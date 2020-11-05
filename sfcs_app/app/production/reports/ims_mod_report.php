<script>
	function printPage(printContent) { 
		var display_setting="toolbar=yes,menubar=yes,scrollbars=yes,width=1050, height=600"; 
		var printpage=window.open("","",display_setting); 
		printpage.document.open(); 
		printpage.document.write('<html><head><title>Print Page</title></head>'); 
		printpage.document.write('<body onLoad="self.print()" align="center">'+ printContent +'</body></html>'); 
		printpage.document.close(); 
		printpage.focus(); 
	}
</script>
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
<br><center><a href="javascript:void(0);" onClick="printPage(printsection.innerHTML)" class="btn btn-warning">Print</a></center><br>
<div id="printsection">
	<style>
		table, th, td
		{
			border: 1px solid black;
			border-collapse: collapse;
			
		}
		body
		{
			font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
		}
	</style>
<div class="panel panel-primary">
<div class="panel-heading">IMS Module Transfer Report</div>
<div class="panel-body">

<?php
$job_no_ref=$_GET['job_no_ref'];
$created_at=$_GET['created_at'];
$plantcode=$_GET['plantcode'];

echo "<div class='table-responsive'><table class='table table-bordered' id='table2'><thead><tr><th>Sno</th><th>Barcode</th><th>Style</th><th>Schedule</th><th>Job No</th><th>Color</th><th>Module</th><th>Bundle Number</th><th>Size</th><th>Quantity</th></tr><thead>";

$sql="select bundle_number,to_resource,quantity,job_no_ref,style,schedule,color,size from $tms.bundle_transfer_log where plant_code='$plantcode' and job_no_ref = '$job_no_ref' and date(created_at) = '$created_at'";
// echo $sql;
$result=mysqli_query($link, $sql) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
$x=0;
while($row=mysqli_fetch_array($result))
{
	$bundle_number=$row['bundle_number'];
	$to_module=$row['to_resource'];
	$quantity=$row['quantity'];
	$job_no=$row['job_no_ref'];
	$style=$row['style'];
	$schedule=$row['schedule'];
	$color=$row['color'];
	$size=$row['size'];
	$x++;

	$query = "select workstation_code from $pms.workstation where plant_code='$plantcode' and workstation_id = '$to_module'";
	$sql_res = mysqli_query($link_new, $query) or exit("Sql Error at Section details" . mysqli_error($GLOBALS["___mysqli_ston"]));
	$workstation_rows_num = mysqli_num_rows($sql_res);
	if($workstation_rows_num > 0) {
		while ($workstation_row = mysqli_fetch_array($sql_res)) {
			$to_module_date = $workstation_row['workstation_code'];
		}
	}

	echo "<tr>";
	echo "<td>".$x."</td>";
	echo "<td>".$bundle_number."</td>";
	echo "<td>".$style."</td>";
	echo "<td>".$schedule."</td>";
	echo "<td>".$job_no."</td>";
	echo "<td>".$color."</td>";
	echo "<td>".$to_module_date."</td>";
	echo "<td>".$bundle_number."</td>";
	echo "<td>".$size."</td>";
	echo "<td>".$quantity."</td>";
	echo "</tr>";
}
echo "</table></div>";

?>
</div></div>
<script> 


function popitup_new(url) { 

newwindow=window.open(url,'name','scrollbars=1,menubar=1,resizable=1,location=0,toolbar=0'); 
if (window.focus) {newwindow.focus();} 
return false; 
} 
</script> 
<?php
if(isset($_GET['sidemenu'])){

	echo "<style>
          .left_col,.top_nav{
          	display:none !important;
          }
          .right_col{
          	width: 100% !important;
    margin-left: 0 !important;
          }
	</style>";
}
?>
<!-- <script language="javascript" type="text/javascript">
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
</script> -->
</div>



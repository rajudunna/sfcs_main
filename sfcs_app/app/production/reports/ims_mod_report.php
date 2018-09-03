<?php


    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
	$view_access=user_acl("SFCS_0245",$username,1,$group_id_sfcs); 
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
<div class="panel panel-primary">
<div class="panel-heading">IMS Module Transfer Report</div>
<div class="panel-body">

<?php

echo "<div class='table-responsive'><table class='table table-bordered' id='table2'><thead><tr><th>Sno</th><th>Style</th><th>Schedule</th><th>Job No</th><th>Color</th><th>Module</th><th>Bundle Number</th><th>Size</th><th>Quantity</th><th>Control</th></tr><thead>";

$sql="select * from $brandix_bts.module_bundle_track order by tran_id DESC";
//echo $sql."<br>";
$result=mysqli_query($link, $sql) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
$x=0;
while($row=mysqli_fetch_array($result))
{
	$bundle_number=$row['bundle_number'];
	$module=$row['module'];
	$quantity=$row['quantity'];
	$job_no=$row['job_no'];
	


	$sql1="select ims_style,ims_schedule,ims_color,ims_doc_no,ims_size from $bai_pro3.ims_log where pac_tid='$bundle_number'";

	$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$ims_style=$row1['ims_style'];
		$ims_schedule=$row1['ims_schedule'];
		$ims_color=$row1['ims_color'];
		$docket_no=$row1['ims_doc_no'];
        $ims_size=$row1['ims_size'];
        $ims_size2=substr($ims_size,2);
	

	 $sql22="select * from $bai_pro3.plandoc_stat_log where doc_no='$docket_no' and a_plies>0";
      //echo $sql22;
      $sql_result22=mysqli_query($link, $sql22) or exit("Sql Error1222".mysqli_error($GLOBALS["___mysqli_ston"]));      
      while($sql_row22=mysqli_fetch_array($sql_result22))
      {
        $order_tid=$sql_row22['order_tid'];
      } 
      
      
      $size_value=ims_sizes($order_tid,$ims_schedule,$ims_style,$ims_color,$ims_size2,$link);

	$x++;
	

	$print_sheet=getFullURLLevel($_GET["r"],"ims_barcode.php",0,"R");

	echo "<tr>";
	echo "<td>".$x."</td>";
	echo "<td>".$ims_style."</td>";
	echo "<td>".$ims_schedule."</td>";
	echo "<td>".$job_no."</td>";

	echo "<td>".$ims_color."</td>";
	echo "<td>".$module."</td>";
	echo "<td>".$bundle_number."</td>";
	echo "<td>".$size_value."</td>";
	echo "<td>".$quantity."</td>";
	echo "<td><input type='button' class='btn btn-primary' href=\"$print_sheet?input_job=$job_no&quantity=$quantity&module=$module&style=$ims_style&schedule=$ims_schedule&color=$ims_color&size=$size_value\" onclick=\"return popitup_new('$print_sheet?input_job=$job_no&quantity=$quantity&module=$module&style=$ims_style&schedule=$ims_schedule&color=$ims_color&size=$size_value')\" name='submit' id='submit' value='Print'></input></td>";
	echo "</tr>";
	}	
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
</div>



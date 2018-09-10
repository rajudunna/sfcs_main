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
$id=$_GET['id'];

echo "<div class='table-responsive'><table class='table table-bordered' id='table2'><thead><tr><th>Sno</th><th>Barcode</th><th>Style</th><th>Schedule</th><th>Job No</th><th>Color</th><th>Module</th><th>Bundle Number</th><th>Size</th><th>Quantity</th></tr><thead>";

$sql="select * from $brandix_bts.module_bundle_track where ref_no = '$id'";
//echo $sql."<br>";
$result=mysqli_query($link, $sql) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
$x=0;
while($row=mysqli_fetch_array($result))
{
	$bundle_number=$row['bundle_number'];
	$module=$row['module'];
	$quantity=$row['quantity'];
	$job_no=$row['job_no'];
	


	$sql1="SELECT order_style_no,order_del_no,order_col_des,size_code FROM bai_pro3.`packing_summary_input` WHERE tid='$bundle_number' AND input_job_no='$job_no'";		
    $result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$style=$row1['order_style_no'];
		$schedule=$row1['order_del_no'];
		$color=$row1['order_col_des'];
        $size=$row1['size_code'];
     
	

	$x++;
	

	//$print_sheet=getFullURLLevel($_GET["r"],"ims_barcode.php",0,"R");

	echo "<tr>";
	echo "<td>".$x."</td>";
	echo "<td>".$bundle_number."</td>";
	echo "<td>".$style."</td>";
	echo "<td>".$schedule."</td>";
	echo "<td>".$job_no."</td>";

	echo "<td>".$color."</td>";
	echo "<td>".$module."</td>";
	echo "<td>".$bundle_number."</td>";
	echo "<td>".$size."</td>";
	echo "<td>".$quantity."</td>";
	// echo "<td>" ."<a href='javascript:void(0);' onClick='printPage(printsection.innerHTML)' class='btn btn-warning'>Print</a>".
	// "</td>";
	
	// echo "<td><input type='button' class='btn btn-primary' href=\"$print_sheet?input_job=$job_no&quantity=$quantity&module=$module&style=$ims_style&schedule=$ims_schedule&color=$ims_color&size=$size_value\" onclick=\"return popitup_new('$print_sheet?input_job=$job_no&quantity=$quantity&module=$module&style=$ims_style&schedule=$ims_schedule&color=$ims_color&size=$size_value')\" name='submit' id='submit' value='Print'></input></td>";
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



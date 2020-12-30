<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>

<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_v2.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/enums.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_dashboard.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/server_urls.php');
include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');
$dash=0;
if (isset($_GET['dash'])) {
	$dash=1;
}
$php_self = explode('/',$_SERVER['PHP_SELF']);
array_pop($php_self);
$url_r = base64_encode(implode('/',$php_self)."/fab_pps_dashboard_v2.php");
// $has_permission=haspermission($url_r); 
$php_self = explode('/',$_SERVER['PHP_SELF']);
$ctd =array_slice($php_self, 0, -2);
$get_url=implode('/',$ctd)."/Cut_table_dashboard/marker_length_popup.php";

$get_url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."".$get_url;

?>
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs_app/app/dashboards/common/css 	/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<?php 
if($dash==1){
 	$php_self = explode('/',$_SERVER['PHP_SELF']);
	$ctd =array_slice($php_self, 0, -2);
	$url_rr=base64_encode(implode('/',$ctd)."/cut_table_dashboard/cut_table_dashboard.php");
	$url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index-no-navi.php?r=".$url_rr;
}
else{
	$php_self = explode('/',$_SERVER['PHP_SELF']);
	array_pop($php_self);
	$url_r = base64_encode(implode('/',$php_self)."/fab_priority_dashboard.php");
	$url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index-no-navi.php?r=".$url_r;
}

?>

<br/>
<div class='row'>
		<div class='col-md-2 pull-left'>
			<a class='btn btn-primary' href = '<?= $url1 ?>'> Back </a>
		</div>
		<div class='col-md-10 pull-right'>
			<p style='color:red'>Note : Please Print "Docket Print" Before Update Fabric Status</p>
		</div>
</div>
<br/>
<script src="../../../../common/js/sweetalert.min.js"></script>
<script type="text/javascript">

function check_validate()
{
	var print_valid=document.getElementById("print_validation").value;
	var num_check=document.getElementById("sql_num_check").value;
	var checkBox = document.getElementById("validate");
	console.log(print_valid);
	console.log(num_check);
	if(Number(print_valid)==Number(num_check)){
		if (checkBox.checked == true){	
			//var docket=document.getElementById("doc_no").value;
		var total_req=parseInt(document.getElementById("tot_req").value);
		var allocation=parseInt(document.getElementById("alloc_qty").value);
		var selection=document.getElementById("issue_status").value;
		var doc_tot=document.getElementById("doc_tot").value;
		var alloc_doc=document.getElementById("alloc_doc").value;
		// console.log(total_req);
		if(0<allocation)
			{
				document.getElementById("submit").disabled=false;
				if(total_req == allocation)
				{
					document.getElementById("submit").disabled=false;
					document.getElementById('dvremark').style.display = "none";
					//console.log("Total and alloc eq");
				}
				else if(total_req < allocation)
				{
					var diff=(allocation-total_req);
					var numb = diff.toFixed(2);
					if(confirm("You are sending morethan required quantity :"+numb+"Yrds. \n Are you Sure,You want to proceed..?"))
					{
						document.getElementById('dvremark').style.display = "block";
					}
					else
					{
						document.getElementById("validate").checked=false;
						document.getElementById("submit").disabled=true;
						document.getElementById("remarks").value="";
						document.getElementById('dvremark').style.display = "none";
					}
					
				}
				else if(allocation < total_req)
				{
					var diff=total_req-allocation;
					numb = diff.toFixed(2);
					if(confirm("You are sending lessthan required quantity :" +numb+ " Yrds. \n Are you Sure,You want to proceed..?"))
					{
						document.getElementById('dvremark').style.display = "block";
					}
					else
					{
						document.getElementById("validate").checked=false;
						document.getElementById("submit").disabled=true;
						document.getElementById("remarks").value="";
						document.getElementById('dvremark').style.display = "none";
					}
				}
			}
			else if(allocation==0 && doc_tot==alloc_doc)
			{
				
				sweetAlert("You have allocated \"STOCK\" for some of the dockets ","","warning");
				document.getElementById('dvremark').style.display = "block";
				document.getElementById("submit").disabled=false;
			}
			else
			{
				//alert(allocation);
				sweetAlert("Please allocate the material to the Docket"," ","warning");
				document.getElementById("validate").checked=false;
				document.getElementById("submit").disabled=true;
				document.getElementById("remarks").value="";
				document.getElementById('dvremark').style.display = "none";
				return false;
			}
		}else{
			document.getElementById("submit").disabled=true;
		}

	}else{

		sweetAlert("You should print docket print Before Update Staus","","warning");
		document.getElementById("validate").checked=false;
		document.getElementById("submit").disabled=true;
		document.getElementById("remarks").value="";
		document.getElementById('dvremark').style.display = "none";
		return false;

	}
	

}

function validate_but()
{
		//alert('check');
		var total_require=parseInt(document.getElementById("tot_req").value);
		var allocation_require=parseInt(document.getElementById("alloc_qty").value);
		console.log("Total Req : " +total_require);
		console.log(allocation_require);
		var str_text=document.getElementById("remarks").value;
		var ii=str_text.length;
		//alert(str_text.trim());
		if(total_require==allocation_require)
		{

		}
		else
		{
			if(ii < 8)
			{
				sweetAlert("Please fill the remark...!","","warning");
				return false;
			}
			else
			{
				
			}
		}

}

</script>
<style>
#loading-image{
  position:fixed;
  top:0px;
  right:0px;
  width:100%;
  height:100%;
  background-color:#666;
  /* background-image:url('ajax-loader.gif'); */
  background-repeat:no-repeat;
  background-position:center;
  z-index:10000000;
  opacity: 0.4;
  filter: alpha(opacity=40); /* For IE8 and earlier */
}
th,td{
    color: black;
}
</style>
<div class="ajax-loader" id="loading-image" style="display: none">
    <center><img src='ajax-loader.gif' class="img-responsive" style="padding-top: 250px"/></center>
</div>



<?php
error_reporting(0);
set_time_limit(20000);
$doc_no=$_GET['doc_no'];
if (!isset($_GET['pop_restriction'])) {
	$_GET['pop_restriction']=0;
}
if (!isset($_GET['group_docs'])) {
	$_GET['group_docs']=0;
}
$pop_restriction=$_GET['pop_restriction'];
$group_docs=$_GET['group_docs'];
//echo $group_docs;
?>



<html>
<head>

<link rel="stylesheet" type="text/css" href="../../../../common/css/page_style.css" />
<link rel="stylesheet" href="../../../../common/css/bootstrap.min.css">
<script src="../../../../common/js/jquery1.min.js"></script>
<script src="../../../../common/js/bootstrap1.min.js"></script>

<style>
body
{
	font-family: Trebuchet MS;
}
</style>

<style>
body
{
	background-color:#ffffff;
	color: #000000;
	font-family: Trebuchet MS;
}
a {text-decoration: none;}

table
{
	border: 1px solid #000000;
	border-collapse:collapse;
	border-color:#000000;
}
td
{
	border: 1px solid #000000;
	white-space:nowrap;
	border-collapse:collapse;
}

th
{
	border: 1px solid #000000;
	white-space:nowrap;
	border-collapse:collapse;
	color:#ffffff;
	background:#29759c;
	font-size:14;
}

.bottom th,td
{
	border-bottom: 1px solid white; 
	padding-bottom: 1px;
	padding-top: 1px;
	font-size:14;
}

.input
{
	background-color:yellow;
}

</style>
<script>
 function button_disable()
{
	// document.getElementById('process_message').style.visibility="visible";
	document.getElementById('allocate').style.visibility="hidden";
}
 
 </script>
 <script>
function dodisable()
{

}
</script>
</head>
<body onload="dodisable()">
<div class="panel panel-primary">
<div class="panel-heading">Fabric Status</div>
<div class="panel-body">

<?php
$plant_code=$_GET['plantcode_name'];
$username=$_GET['username'];
$doc_no=$_GET['doc_no'];
echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color=\"red\">Please wait while preparing data...</font></h1></center></div>";
	
	ob_end_flush();
	flush();
	usleep(10);
	$style='';
	$schedule='';
include("fab_detail_track_include.php");
echo "<table class='table table-bordered'>";
echo "<tr>";
echo "<th>Style</th>";
echo "<th>Schedule</th>";
echo "<th>Color</th>";
echo "<th>Job No</th>";
echo "</tr>";

$check_sql = "SELECT * from $pps.fabric_prorities left join $pps.jm_dockets on jm_dockets.jm_docket_id=fabric_prorities.jm_docket_id where fabric_prorities.jm_docket_id='$doc_no' and fabric_prorities.plant_code='$plant_code'";
$sql_result1=mysqli_query($link, $check_sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result1);
$sizes_table ='';
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$sql11x11="SELECT docket_number FROM $pps.jm_dockets where plant_code='$plant_code' and jm_docket_id='$doc_no'";
	$sql_result11x11=mysqli_query($link, $sql11x11) or die("Error10 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row111x11=mysqli_fetch_array($sql_result11x11))
	{
	  $docket_line_no=$row111x11["docket_number"];

	}  
    if($docket_line_no!='' && $plant_code!=''){
		$result_docketinfo=getDocketInformation($docket_line_no,$plant_code);
		$style =$result_docketinfo['style'];
		$colorx =$result_docketinfo['fg_color'];
		$cut_no =$result_docketinfo['cut_no'];
		$cat_refnce =$result_docketinfo['category'];
		$cat_compo =$result_docketinfo['rm_sku'];
		$fabric_required =$result_docketinfo['required_qty'];
		$length =$result_docketinfo['length'];
		$shrinkage =$result_docketinfo['shrinkage'];
		$width =$result_docketinfo['width'];
		$marker_version_id =$result_docketinfo['marker_version_id'];
		$schedule_bulk =$result_docketinfo['schedule_bulk'];
		
	}
	//var_dump($schedule_bulk);
	echo "<tr>";
	echo "<td>".$style."</td>";
	echo "<td>".implode(', ',$schedule_bulk)."</td>";
	echo "<td>".$colorx."</td>";
	echo "<td>".$cut_no."</td>";
	echo "</tr>";
	 $style_ref=$style;

}

echo "</table>";

//echo $sizes_table;




//NEW Implementation for Docket generation from RMS

echo "<h2>Cut Docket Print</h2>";

echo "<form name=\"ins\" method=\"post\" action=\"fab_pop_allocate_v5.php\">"; //new_Version

echo "<input type=\"hidden\" value=\"1\" name=\"process_cat\">";

 //this is to identify recut or normal processing of docket (1 for normal 2 for recut)
echo "<input type=\"hidden\" value=\"$style_ref\" name=\"style_ref\">";  
echo "<input type=\"hidden\" value=\"$dash\" name=\"dashboard\">";  
echo "<input type=\"hidden\" id=\"username\" value=\"$username\" name=\"username\">"; 
echo "<input type=\"hidden\" id=\"plantcode1\"  value=\"$plant_code\" name=\"plantcode1\">"; 
echo "<input type=\"hidden\" name=\"doc_mer\" value=\"".$fabric_required."\">";
echo "<input type=\"hidden\" id=\"doc_no\" name=\"doc_no\" value=\"".$doc_no."\">";

echo "<div class='table-responsive'><table class='table table-bordered'><tr><th>Category</th><th>Item Code</th><th>Color Desc. - Docket No</th><th>Marker Update</th><th>Required<br/>Qty</th><th>Reference</th>
<th>Shrinkage</th><th>Width</th><th>Control</th><th>Print Status</th><th>Roll Details</th></tr>";
$sql1="select * from $pps.fabric_prorities left join $pps.jm_dockets on jm_dockets.jm_docket_id=fabric_prorities.jm_docket_id where fabric_prorities.jm_docket_id='$doc_no' and fabric_prorities.plant_code='$plant_code'";
//echo "getting req qty : ".$sql1."</br>";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result1);
$for_Staus_dis=$sql_num_check;
// echo "Rows:".$sql_num_check;
$enable_allocate_button=0;
$comp_printed=array();
$docket_num=array();
$total=0;$allc_doc=0;

//By ram Date:14032018
//this is flag for style automatic/manual 
$style_flag=0;
$Disable_allocate_flag=0;
$print_validation=0;
$print_status=1;
while($sql_row1=mysqli_fetch_array($sql_result1))
{	
	
	if($style_flag==0)
	{
        $docno_lot=$sql_row1['jm_docket_id'];
        if($docket_line_no!='' && $plant_code!=''){
            $result_docketinfo=getDocketInformation($docket_line_no,$plant_code);
            $style =$result_docketinfo['style'];
            
        }
		$path=$DOCKET_SERVER_IP."/printDocket/";

		$qry_lotnos="select* from $wms.sticker_report left join $pps.requested_dockets on requested_dockets.plan_lot_ref=sticker_report.lot_no where sticker_report.product_group='Fabric' and sticker_report.plant_code='$plant_code' and requested_dockets.jm_docket_id='$doc_no'";
		// echo "<br>LOt qry : ".$qry_lotnos;
		$sql_lotresult=mysqli_query($link, $qry_lotnos) or exit("lot numbers Sql Error ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_lotrow=mysqli_fetch_array($sql_lotresult))
		{
			//echo "</br>lot numbers :".$sql_lotrow['lot_no'];
			$lotnos_array[]=$sql_lotrow['lot_no'];
		}

		if(sizeof($lotnos_array) =='')
		{

		}
		else 
		{
			$seperated_lots= trim(implode(",", $lotnos_array));
		}
    }
}

 	$marker_id='';
	$sql007="select reference from $pps.requested_dockets where jm_docket_id=\"".$doc_no."\"";
	$sql_result007=mysqli_query($link, $sql007) or die("Error2 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row007=mysqli_fetch_array($sql_result007))
	{
		$reference=$row007["reference"];
	}	
	 
    if($docket_line_no!='' && $plant_code!=''){
                $result_docketinfo=getDocketInformation($docket_line_no,$plant_code);
                $style =$result_docketinfo['style']; 
                $marker_version_id =$result_docketinfo['marker_version_id'];  
    }
                
            
	$sql11x1321="select shrinkage,width,length,marker_version_id from $pps.lp_markers where marker_version_id='$marker_version_id' and plant_code='$plant_code'";
	$sql_result11x11211=mysqli_query($link, $sql11x1321) or die("Error15 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row111x2112=mysqli_fetch_array($sql_result11x11211)) 
	{
		$shrinkaage=$row111x2112['shrinkage_group'];
		$mwidt=$row111x2112['width'];
		$marker_id=$row111x2112['marker_version_id'];
	}
    if($docket_line_no!='' && $plant_code!=''){
		$result_docketinfo=getDocketInformation($docket_line_no,$plant_code);
		$style =$result_docketinfo['style'];
		$colorx =$result_docketinfo['fg_color'];
		$cut_no =$result_docketinfo['cut_no'];
        $cat_refnce =$result_docketinfo['category'];
        $length =$result_docketinfo['length'];
		$shrinkage =$result_docketinfo['shrinkage'];
        $width =$result_docketinfo['width'];
        $cat_compo =$result_docketinfo['rm_sku'];
		$fabric_required =$result_docketinfo['required_qty'];
		$docket_number =$result_docketinfo['docket_number'];
		$ratio_comp_group_id =$result_docketinfo['ratio_comp_group_id'];
		$po_number=$result_docketinfo['sub_po'];
		
	}
	echo "<tr><td>".$cat_refnce."</td>";
	echo "<td>".$cat_compo."</td>";
    echo "<td>".$colorx.'-'.$docket_number."</td>";
    // echo "<td>".($marker)."</td>";
    
	$maker_update="select * from $pps.requested_dockets where plant_code='$plant_code' and jm_docket_id='".$doc_no."'";
	$maker_update_result=mysqli_query($link, $maker_update) or exit("Sql Error--12".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($maker_update_result))
	{
		$plan_lot_ref = $row['plan_lot_ref'];
		$print_status=$row['print_status'];       
    }
	echo "<td>";
	$sql11x11="SELECT marker_version_id FROM $pps.jm_dockets where plant_code='$plant_code' and jm_docket_id='$doc_no'";
	$sql_result11x11=mysqli_query($link, $sql11x11) or die("Error10 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row111x11=mysqli_fetch_array($sql_result11x11))
	{
		$marker_version1=$row111x11["marker_version_id"];
	}
	$sql11x1="SELECT marker_version_id,marker_version FROM $pps.lp_markers where plant_code='$plant_code' and lp_ratio_cg_id='$ratio_comp_group_id'";
	$sql_result11x1=mysqli_query($link, $sql11x1) or die("Error10 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	//$username,$plant_code,$doc_no,
	if($plan_lot_ref==NULL || $plan_lot_ref==0)
	{
		echo "Select Marker :";	
		echo "<SELECT name='marker_version'  id='marker_version' style='height: 30px;' onchange='call_marker_update();' >";	
		while($row111x1=mysqli_fetch_array($sql_result11x1))
		{
			$marker_version=$row111x1["marker_version"];
			
			if($row111x1['marker_version_id']==$marker_version1)
			{
				echo "<option value=\"".$row111x1['marker_version_id']."\" selected>".$row111x1['marker_version']."</option>";
			}
			else
			{
				echo "<option value=\"".$row111x1['marker_version_id']."\">".$row111x1['marker_version']."</option>";
			}
			
		}
		echo "</select>	
		<div id ='dynamic_table1' style='width: 350px;'>";
	}
	else
	{
		$sql11x12="SELECT marker_version FROM $pps.lp_markers where plant_code='$plant_code' and marker_version_id='$marker_version1'";
		$sql_result11xw1=mysqli_query($link, $sql11x12) or die("Error10 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row111x1qw=mysqli_fetch_array($sql_result11xw1))
		{
			$marker_version=$row111x1qw["marker_version"];
		}
		echo $marker_version;
	}
	echo "</div";
	echo "</td>";
	echo"</br></br>";
	$extra=0;
	$percentage_query="select percentage FROM $pps.mp_additional_qty where plant_code='$plant_code' and po_number='$po_number' and order_quantity_type='CUTTING_WASTAGE'";
	$percentage_query_result=mysqli_query($link, $percentage_query) or die("Error10 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row111x111=mysqli_fetch_array($percentage_query_result))
	{
		$percentage=$row111x111["percentage"];

	}
	$value=$fabric_required*($percentage/100);
	$total_required_qty=$value+$fabric_required;
    echo "<td>".$total_required_qty."</td>";
	echo "<td>".$reference."</td>";
	echo "<td>".$shrinkage."</td>";
    echo "<td>".$width."</td>";
	$temp_tot=$material_requirement_orig+$extra;
	$total+=$total_required_qty;
	$temp_tot=0;
	$doc_cat=$cat_refnce;
	$docket_num[]=$doc_no;

if($print_status=='0000-00-00 00:00:00'){
	$print_status=0;
	$print_status1=0;
}else{
	$print_status=$print_status;
	$print_status1=1;
}
	
	if($plan_lot_ref!='')
	{
		$plan_lot_ref=$plan_lot_ref;		
		$allc_doc++;
		if($clubbing>0)
		{
			if(!in_array($sql_row1['category'],$comp_printed))
			{
				echo "<td><a href='$path$doc_no'  onclick=\"Popup1=window.open('$path$doc_no','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Print</a></td>";
				$comp_printed[]=$sql_row1['category'];
			}
			else
			{
				echo "<td>Clubbed</td>";
			}
		}
		else
		{
			echo "<td><a href='$path$doc_no' onclick=\"Popup1=window.open('$path$doc_no','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Print</a></td>";
		}	
		$Disable_allocate_flag=$Disable_allocate_flag+1;
		
	}
	else
	{
		echo "<td><input type=\"hidden\" name=\"doc[]\" value=\"".$doc_no."\">";
		
		//For New Implementation
		echo "<input type=\"hidden\" name=\"doc_cat[]\" value=\"".$doc_cat."\">";
		echo "<input type=\"hidden\" name=\"doc_com[]\" value=\"".$doc_com."\">";
		echo "<input type=\"hidden\" name=\"doc_mer[]\" value=\"".$fabric_required."\">";
		echo "<input type=\"hidden\" name=\"cat_ref[]\" value=\"".$cat_ref."\">";
		//For New Implementation
		
		if($style_flag==0){
			if(sizeof($lotnos_array) ==''){
				// $seperated_lots="No lot Number Found";
				$Disable_allocate=1;
			}
			echo "Please Provide Lot Numbers: <textarea class=\"form-control\" name=\"pms".$doc_no."\" id='address' 
			      onkeyup='return verify_num(this,event)' onchange='return verify_num(this,event)' cols=12 rows=10 placeholder='No Lot Number Found, Please Enter Lot Number'>".$seperated_lots."</textarea><br/>";

		}else{

			echo "Please Provide Lot Numbers: <textarea class=\"form-control\" id='address' onkeyup='return verify_num(this,event)'
			     onchange='return verify_num(this,event)' name=\"pms".$doc_no."\" cols=12 rows=10 ></textarea><br/>";

		}

		echo "</td>";
	
		$enable_allocate_button=1;
	} 
	
if($print_status>0)
{
	echo "<td><img src=\"correct.png\"></td>";
	$print_validation=$print_validation+1;	
}
else
{
	echo "<td><img src=\"wrong.png\"></td>";
}

	

echo "<td>";	
	getDetails($doc_no,$plant_code);
	echo "</td>";

unset($lotnos_array);
unset($seperated_lots);	
echo "<tr><td colspan=4><center>Total Required Material</center></td><td>$total</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
echo "</table></div>";
//echo $Disable_allocate_flag;
if($enable_allocate_button==1)
{	
	//disable allocate button
	// if($Disable_allocate_flag==0){
		echo "<input type=\"submit\" name=\"allocate\" value=\"Allocate\" class=\"btn btn-success\" onclick=\"button_disable()\">";
	// echo '<div id="process_message"><h2><font color="red">Please wait while updating data!!!</font><br/><font color="blue">After update, this window will close automatically!</font></h2></div>';
	// }
	
}
echo "</form>";
//NEW Implementation for Docket generation from RMS

$sql1="SELECT fabric_status from $pps.requested_dockets where plant_code='$plant_code' and jm_docket_id='$doc_no'";

//mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error567".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result1);
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$fabric_status=$sql_row1['fabric_status'];
}

if($sql_num_check == 0){
	if($doc_no > 0){
		$fab_status_query = "SELECT fabric_status from $pps.requested_dockets where plant_code='$plant_code' and jm_docket_id='$doc_no'";
		$fab_status_result = mysqli_query($link,$fab_status_query);
		while($row = mysqli_fetch_array($fab_status_result)){
			$fabric_status=$row['fabric_status'];
		}
	}
}
//echo "TEst"."<br>";
//echo sizeof($docket_num)."<br>";
if($fabric_status=="1")
{
	echo '<div class="alert alert-info"><strong>Fabric Status:</strong><br>Ready For Issuing: <font color="green">Completed</font><br>Issue to Module: <font color="red">Pending</font></div>';
}
// $docket_num1 = "'" . implode ( "', '", $docket_num ) . "'";
$sql111="select ROUND(SUM(allocated_qty),2) AS alloc,count(distinct doc_no) as doc_count from $wms.fabric_cad_allocation where doc_no='$doc_no'  and plant_code='$plant_code'";
// echo $sql111."<br>";
$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row111=mysqli_fetch_array($sql_result111))
	{
		if($sql_row111['alloc']!='')
		{
			$alloc_qty=$sql_row111['alloc'];
		}
		else
		{
			$alloc_qty=0;
		}		
		//$allc_doc=$sql_row111['doc_count'];
	}
		
?>

<?php
// if($Disable_allocate_flag==0){
     $Disable_allocate_flag=1;
if($Disable_allocate_flag==$for_Staus_dis){
?>
<form method="post" onsubmit=" return validate_but();">
<table class="table table-bordered"><tr><th>Fabric Issue Status:</th><td> <select name="issue_status" id="issue_status" class="select2_single form-control">

<option value="1" <?php if($fabric_status=="1") { echo " selected"; }?>>Ready For Issuing</option>
<option value="5" <?php if($fabric_status=="5") { echo " selected"; }?>>Issue to Cutting</option>
</select></td><td>
<input type="checkbox" name="validate" id="validate" onclick="check_validate()"/><td>
<input type="hidden" value="<?php echo round($total,2); ?>" name="tot_req" id="tot_req"/>
<input type="hidden" value="<?php echo $dash; ?>" name="dashboard" id="dashboard"/>
<input type="hidden" value="<?php echo $alloc_qty; ?>" name="alloc_qty" id="alloc_qty"/>
<input type="hidden" value="<?php echo $style; ?>" name="style" id="style"/>
<input type="hidden" value="<?php echo $schedule; ?>" name="schedule" id="schedule"/>
<input type="hidden" value="<?php echo $allc_doc; ?>" name="alloc_doc" id="alloc_doc"/>
<input type="hidden" value="<?php echo sizeof($docket_num); ?>" name="doc_tot" id="doc_tot"/>
<input type="hidden" value="<?php echo $print_validation; ?>" name="print_validation" id="print_validation"/>
<input type="hidden" value="<?php echo $for_Staus_dis; ?>" name="sql_num_check" id="sql_num_check"/>
<td>
<div id="dvremark" style="display: none">
 <center>Remark:</center>
<textarea id="remarks" rows="4" cols="50" name="remarks" placeholder="Please fill the remarks">
  
</textarea>	

</div>
</td><td>
<?php
//echo "Fabric status :".$fabric_status;
if($pop_restriction==0)
{
	echo '<input type="submit" name="submit" id="submit" class="btn btn-success" value="Update" disabled="disabled">';
}
else
{
	echo "<font color=red>It's too early to issue to module.</font>";
}
echo "<input type=\"hidden\" name=\"group_docs\" value=".$doc_no.">";
?>
</td></tr></table>
</form>
<?php
	}
// }
?>

<script>
	document.getElementById("msg").style.display="none";		
</script>

</div>
</div>

</body>

</html>

<?php

if(isset($_POST['submit']))
{
	
	$alloc_docket=$_POST['alloc_doc'];
	$doc_tot=$_POST['doc_tot'];
	$issue_status=$_POST['issue_status'];	
	$group_docs=$_POST['group_docs'];
	$reason=$_POST['remarks'];
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$marker_version=$_POST['marker_version'];
	$doc_num=explode(",",$group_docs);
	for($i=0;$i<sizeof($doc_num);$i++)
	{	
		$sql2="update $pps.requested_dockets set fabric_status='$issue_status',updated_user='$username',updated_at=NOW() where jm_docket_id='".$doc_no."'";
		
		mysqli_query($link, $sql2) or exit("Sql Error----5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql111="select roll_id,allocated_qty from $wms.fabric_cad_allocation where doc_no='".$doc_no."' and status=1 and plant_code='$plant_code'";
		//echo $sql111."</br>";
		$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error--121".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result111)>0)
		{
			while($row2=mysqli_fetch_array($sql_result111))
			{
				$code=$row2['roll_id'];
				$sql1="select ref1,qty_rec,qty_issued,qty_ret,partial_appr_qty,qty_allocated,status from $wms.store_in where roll_status in (0,2) and tid=\"$code\" and plant_code='$plant_code'";
				//echo "Qry :".$sql1."</br>";
				$sql_result=mysqli_query($link, $sql1) or exit("Sql Error--15".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$qty_rec=$sql_row['qty_rec']-$sql_row['partial_appr_qty'];
					$qty_issued=$sql_row['qty_issued'];
					$qty_ret=$sql_row['qty_ret'];
					$qty_allocate=$sql_row['qty_allocated'];
					$status_exist=$sql_row['status'];
				}
				//echo "</br>Qty Rec from store:".$qty_rec."</br>";
				$qty_iss=$row2['allocated_qty'];
				$validate_qty_status=$qty_allocate-$qty_iss;
				//echo "Qty Issued :".$qty_iss."</br>";
				$balance=$qty_rec-$qty_issued+$qty_ret;	
				$balance1=$qty_rec+$qty_ret-($qty_issued+$qty_iss);
				if($validate_qty_status>0)
				{
					$status=$status_exist;
				}
				else
				{	
					if($balance1==0)
					{
						$status=2;
					}
					else
					{
						$status=0;
					}
				}
				$condi1=(($qty_rec+$qty_ret)-($qty_iss+$qty_issued));
				//echo "BAl:".$condi1."</br>";
				if((($qty_rec-($qty_iss+$qty_issued))+$qty_ret)>=0 && $qty_iss > 0)
				{
					
					if($issue_status==5)
					{	
						$sql22="update $wms.store_in set qty_issued=".($qty_issued+$qty_iss).",qty_allocated=qty_allocated-".$qty_iss.", status=$status, allotment_status=$status,updated_user='$username', updated_at=NOW() where tid=\"$code\" and plant_code='$plant_code'";
						mysqli_query($link, $sql22) or exit("Sql Error----3".mysqli_error($GLOBALS["___mysqli_ston"]));

						$sql211="select * from $wms.store_out where tran_tid='".$code."' and qty_issued='".$qty_iss."' and Style='".$style."' and Schedule='".$schedule."' and cutno='".$doc_no_loc."' and date='".date("Y-m-d")."' and updated_by='".$username."' and remarks='".$reason."' and log_stamp='".date("Y-m-d H:i:s")."' and plant_code='$plant_code' ";
						$sql_result211=mysqli_query($link, $sql211) or exit("Sql Error--211: $sql211".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result211);
						if($sql_num_check==0)
						{
							$sql23="insert into $wms.store_out (tran_tid,qty_issued,Style,Schedule,cutno,date,updated_by,remarks,log_stamp) values ('".$code."', '".$qty_iss."','".$style."','".$schedule."','".$doc_no_loc."','".date("Y-m-d")."','".$username."','".$reason."','".date("Y-m-d H:i:s")."')";
							//echo "Sql :".$sql23."</br>"; 
							//Uncheck this
							mysqli_query($link, $sql23) or exit("Sql Error----4".mysqli_error($GLOBALS["___mysqli_ston"]));
						}

						$sql24="update $wms.fabric_cad_allocation set status=2,updated_user='$username',updated_at=NOW() where doc_no='".$doc_no."' and plant_code='$plant_code'";
						mysqli_query($link, $sql24) or exit("Sql Error----3111".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					
				}
			
			}
		}	
	
	}
	if($issue_status==5)
	{
		
		$sql1="update $pps.requested_dockets set fabric_status=$issue_status,updated_user='$username',updated_at=NOW() where plant_code='$plant_code' and jm_docket_id in ('$doc_no')";
		//Uncheck this
		mysqli_query($link, $sql1) or exit("Sql Error---5".mysqli_error($GLOBALS["___mysqli_ston"]));
	
		$sql1="update $pps.requested_dockets set fabric_status=$issue_status,updated_user='$username',updated_at=NOW() where plant_code='$plant_code' and jm_docket_id in ('$doc_no')";
		//Uncheck this
		mysqli_query($link, $sql1) or exit("Sql Error---6".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//if($issue_status==5)
		//{
		$sql3="update $pps.fabric_prorities set issued_time='".date("Y-m-d H:i:s")."',updated_user='$username',updated_at=NOW() where jm_docket_id in ('$doc_no') and plant_code='$plant_code'";
		//Uncheck this	
		mysqli_query($link, $sql3) or exit("Sql Error----7".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql1="INSERT INTO `$pps`.`log_rm_ready_in_pool` (`doc_no`, `date_n_time`, `username`,created_at,created_user,plant_code) VALUES ('$doc_no', '".date("Y-m-d H:i:s")."','$username',NOW(),'$username','$plant_code')";
		 //echo $sql1;
		mysqli_query($link, $sql1) or exit("Sql Error33".mysqli_error($GLOBALS["___mysqli_ston"]));
	}

	if($issue_status==1)
	{
		$sql1="update $pps.requested_dockets set fabric_status=$issue_status,updated_user='$username',updated_at=NOW() where plant_code='$plant_code' and jm_docket_id in ('$doc_no')";
		//Uncheck this
		mysqli_query($link, $sql1) or exit("Sql Error---5.1".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	if($dash==1){
		$php_self = explode('/',$_SERVER['PHP_SELF']);
		$ctd =array_slice($php_self, 0, -2);
		$url_rr=base64_encode(implode('/',$ctd)."/cut_table_dashboard/cut_table_dashboard.php");
		$url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index-no-navi.php?r=".$url_rr;
	}
	else{
		$php_self = explode('/',$_SERVER['PHP_SELF']);
		array_pop($php_self);
		$url_r = base64_encode(implode('/',$php_self)."/fab_priority_dashboard.php");
		$url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index-no-navi.php?r=".$url_r;
	}
	echo"<script>location.href = '".$url1."';</script>"; 
		
}

if(isset($_POST['allocate']))
{

	// echo "test";
	$doc=$_POST['doc'];
	$marker_version=$_POST['marker_version'];
	
	for($i=0;$i<sizeof($doc);$i++)
	{
		$temp='lot'.$doc[$i];
		$lot=$_POST[$temp];		
		// echo $lot[$i].">".$doc[$i].">".sizeof($lot[$i])."<br/>";
	}
	
}

?>	
}
<script type="text/javascript">

function call_marker_update()
{
	var plant_code = $("#plantcode1").val();
	var username = $("#username").val();
	var doc_no = $("#doc_no").val();
	var marker_version = $("#marker_version").val();
	$("#loading-image").show();
	var function_text = "marker_length_update.php";
	$.ajax({
			url: function_text,
			dataType: "json", 
			type: "GET",
			data: {plant_code:plant_code,username:username,doc_no:doc_no,marker_version:marker_version},    
			cache: false,
			success: function (response) 
			{
				if(response['status']==1)
				{ 
					$("#loading-image").hide();
					swal("success","Marker updation Successfully done.","success");
					location.reload();			
				}
				else
				{
					$("#loading-image").hide();
					swal("warning","Marker updation Fail/Already exist.","warning");
					location.reload();
				}
			},
			error: function(res){
				$('#loading-image').hide();
				swal('Error',' While trying to update the marker','error');
			}
	})
}	
</script>
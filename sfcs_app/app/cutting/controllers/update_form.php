<?php
$has_permission=haspermission($_GET['r']);

?>
<!-- <script language="javascript" type="text/javascript" src="../styles/dropdowntabs.js"></script> -->
<!-- <link rel="stylesheet" href="../styles/ddcolortabs.css" type="text/css" media="all" /> -->
	
<meta http-equiv="cache-control" content="no-cache">
<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
/* @import "TableFilter_EN/filtergrid.css"; */

/*====================================================
	- General html elements
=====================================================*/
body{
	/* margin:15px; padding:15px; border:1px solid #666;
	font-family:Trebuchet MS, sans-serif; font-size:88%; */
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	border:1px solid #ccc;
	overflow:scroll;
}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; border:2px outset #f4f4f4; margin:2px; }
th{ background-color:#29759C; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ background-color:#FFF; padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; }

</style>
<!-- <script language="javascript" type="text/javascript" src="TableFilter_EN/actb.js"></script><!-- External script -->
<!-- <script language="javascript" type="text/javascript" src="TableFilter_EN/tablefilter.js"></script> -->	

<Link rel='alternate' media='print' href=null>
	<script type="text/javascript">
jQuery(document).ready(function($){
    $('#availa,#bal').keypress(function (e) {
        var regex = new RegExp("^[0-9\]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });
});


</script>
<Script Language=JavaScript>
function closepopup()
   {
      if(false == window.closed)
      {
         window.close ();
      }
      else
      {
         alert('Window already closed!');
      }
   }

function DataCheck()
{
	var chks = document.getElementsByName('issqty[]');  
	var chks1 = document.getElementsByName('lotbal[]'); 
	var tot=0;       
	for (var i = 0; i < chks.length; i++) 
	{         
			if(parseFloat(chks1[i].value) < parseFloat(chks[i].value))
			{
				swal('Please Enter Correct Value','','warning');
				chks[i].value=0;
			}
			if(chks[i].value=="")
			{
				tot=parseFloat(tot)+0;
			}
			else
			{
				tot=parseFloat(tot)+parseFloat(chks[i].value);
			}
	} 		
	var avail=document.getElementById("avail").value;
	if(parseFloat(tot) > parseFloat(avail))
	{
		document.getElementById("tot").value=0;
		for (var i = 0; i < chks.length; i++) 
		{
			chks[i].value=0;
		}
	}
	else
	{
		document.getElementById("tot").value=parseFloat(tot);
		document.getElementById("bal").value=parseFloat(avail)-parseFloat(tot);
	}

}

function setPrintPage(prnThis){

prnDoc = document.getElementsByTagName('link');
prnDoc[0].setAttribute('href', prnThis);
window.print();
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

</Script>
</head>

<body onload="dodisable();">

<div class="panel panel-primary">
	<div class="panel-heading"><b>MR Approve/Reject Form</b></div>
	<div class="panel-body">

		<?php 
        include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/menu_include.php',1,'R'));
        //common/php/menu_include.php
		include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
		include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config_splitting_function.php',3,'R'));
		?>
		<?php //list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2);?>

<?php
if(isset($_GET['level']))
{
$ref=$_GET['ref'];
$level=$_GET['level'];
$product=$_GET['product'];
$reason_code=$_GET['reason_code'];
$ref_tid=$_GET['ref_tid'];
//echo $level;	

if($level==8)
{
	$sql="update $bai_rm_pj2.mrn_track set status=9,issued_by=\"$username\",issued_date=\"".date("Y-m-d H:i:s")."\" where tid=$ref_tid";
	//echo $sql."<br>";
	mysqli_query($link, $sql) or exit("Sql Error9=".mysqli_error($GLOBALS["___mysqli_ston"]));
	//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"mrn_form_log.php\"; }</script>";
	echo "<h3><font color=green>Issued.</font></h3>";
	echo "<br/><br/><h3><font color=Red>Please Refresh the page after Updation....</font></h3>";
	//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"mrn_form_log.php\"; }</script>";
	
	// echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",1000); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
}

if($level==3)
{
	echo "<form action=\"?r=".$_GET["r"]."\" method=\"post\">";
	echo "<div class='col-md-4'>Enter Lots Here:<input type=\"textarea\" onkeypress='return validateQty(event);' rows=5 name=\"lots\" class='form-control' value=\"\" required></div>";
	echo "&nbsp;&nbsp;<input type=\"submit\" style=\"margin-top: 18px;\" value=\"Submit\" class='btn btn-success' name=\"submitlot\" />";
	echo "<input type=\"hidden\" name=\"ref\" value=\"$ref\" />";
	echo "<input type=\"hidden\" name=\"product\" value=\"$product\" />";
	echo "<input type=\"hidden\" name=\"level\" value=\"$level\" />";
	echo "<input type=\"hidden\" name=\"reasoncode\" value=\"$reason_code\" />";
	echo "<input type=\"hidden\" name=\"ref_tid\" value=\"$ref_tid\" />";
	echo "</form>";
}

/*if($_GET["lots"] > 0)
{
	//echo "Hello";
	echo "<table class=\"mytable\">";
	echo "<tr><th>LableId</th><th>LotNo</th><th>Recived Qty</th><th>Issued Qty</th><th>Return Qty</th><th>Balance</th><th>Issue Qty</th></tr>";
	$lots_no=$_GET["lots"];
	$sql1="select tid,lot_no,qty_rec,qty_issued,qty_ret from bai_rm_pj1.store_in where lot_no in ($lots_no)";
	//echo $sql1;
	$result1=mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
	while($sql_row1=mysql_fetch_array($result1))
	{
		echo "<tr>";
		echo "<td><input type=\"hidden\" value=\"".$sql_row1["tid"]." name=\"lblids[]\">".$sql_row1["tid"]."</td>";
		echo "<td>".$sql_row1["lot_no"]."</td>";
		echo "<td>".$sql_row1["qty_rec"]."</td>";
		echo "<td>".$sql_row1["qty_issued"]."</td>";
		echo "<td>".$sql_row1["qty_ret"]."</td>";
		echo "<td><input type=\"hidden\" value=\"".($sql_row1["qty_rec"]+$sql_row1["qty_ret"]-$sql_row1["qty_issued"])."\" name=\"lotbal[]\" />".($sql_row1["qty_rec"]+$sql_row1["qty_ret"]-$sql_row1["qty_issued"])."</td>";
		echo "<td><input type=\"text\" value=\"0\" onkeyup=\"DataCheck();\" name=\"issqty[]\" /></td>";
		echo "</tr>";
	}
	echo "</table>";
}*/

// $pgeurl = getFullURL($_GET['r'],'restricted.php','N');

switch($level)
{
	case 1:
	{
		//$tmp=$username."@brandix.com";
		//echo $tmp;
		//To allow Inspection team to approve fabric MRN request
		//$auth_new=array();
		if(trim($product)=="FAB")
		{
			//$auth_new=array_merge($app_team,$inspection_team);
			$check=$authorizeLevel_1;	
		}
		else
		{
		//	$auth_new=$app_team;
			$check=$authorized;
		}
		
		//For Cad Saving Approval
		if($reason_code==30)
		{
			//$auth_new=array_merge($auth_new,$cad_savings);
			$check=$authorizeLevel_2;
		}
		
		if(!in_array($check,$has_permission))
		{
			header("Location:".$pgeurl);
		}
		echo "<h3><center>MR Approve/Reject Form</center></h3>";
		break;
	}
	case 2:
	{
		//$tmp=$username."@brandix.com";
		
		//To allow Inspection team to approve fabric MRN request (as sourcing)
		//$auth_new=array();
		if(trim($product)=="FAB")
		{
			//$auth_new=array_merge($pink_team,$logo_team,$dms_team,$inspection_team);
			$checks=$authorizeLevel_1;
		}
		else
		{
			//$auth_new=array_merge($pink_team,$logo_team,$dms_team);
			$checks=$authorizeLevel_3;
		}
		
		//For Cad Saving Approval
		if($reason_code==30)
		{
			$checks=$authorizeLevel_2;
		}
		
		if(!in_array($checks,$has_permission))
		{
			header("Location:".$pgeurl);
		}
		echo "<h3><center>MR Update Form</center></h3>";
		break;
	}
	case 4:
	{
		//$tmp=$username."@brandix.com";
		if(!in_array($authorizeLevel_3,$has_permission))
		{
			header("Location:".$pgeurl);
		}
		echo "<h3><center>MR Update Form</center></h3>";
		break;
	}
	case 5:
	{
		//$tmp=$username."@brandix.com";
		if(!in_array($authorizeLevel_4,$has_permission))
		{
			header("Location:".$pgeurl);
		}
		echo "<h3><center>Material Issue Form</center></h3>";
		break;
	}
	default:
	{
		echo "<h3><center>MRN Request Details</center></h3>";
	}
}	

$updurl = getFullURL($_GET['r'],'update_form.php','N');
echo "<form name=\"test\" method=\"post\" action=".$updurl.">";

if($_GET["lots"] > 0)
{
	//echo "Hello";
	$ref_tid=$_GET["tid"];

	$sql1="select product from $bai_rm_pj2.mrn_track where tid=$ref_tid";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{	
		$product_code=$sql_row1['product'];
	}

	echo "<div>";
	$row_count = 0;
	$lots_no=$_GET["lots"];
	$sql1="select tid,lot_no,qty_rec,qty_issued,qty_allocated,qty_ret,ref4,barcode_number from $bai_rm_pj1.store_in where lot_no in ($lots_no)";
	// echo $host."-".$sql1;
	$result1=mysqli_query($link, $sql1) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));

	if(mysqli_num_rows($result1)>0){
		echo "<table class='table table-bordered'>";
		echo "<tr><th>LableId</th><th>Barcode</th><th>LotNo</th><th>Shade</th><th>Received Qty</th><th>Issued Qty</th><th>Return Qty</th><th>Balance</th><th>Issue Qty</th></tr>";
	}else{
		echo "<script>sweetAlert('Inavlid Lot Number','','warning')</script>";
	}
	while($sql_row1=mysqli_fetch_array($result1))
	{
		if(($sql_row1["qty_rec"]+$sql_row1["qty_ret"]-$sql_row1["qty_issued"]-$sql_row1["qty_allocated"]) > 0)
		{	
		$readonly="readonly";	
		if(strlen($sql_row1["ref4"]) > 0)
		{
			$readonly="";
		}
		if($product_code=='FAB')
		{
			$readonly=$readonly;
		}
		else {
			$readonly='';
		}
		echo "<tr>";
		echo "<td><input type=\"hidden\" name=\"ref_tid[]\" value=\"".$ref_tid."\" /><input type=\"hidden\" name=\"lblids[]\" value=\"".$sql_row1["tid"]."\" >".$ref_tid."-".$sql_row1["tid"]."</td>";
		echo "<td>".$sql_row1["barcode_number"]."</td>";
		echo "<td><input type=\"hidden\" name=\"lotnos[]\" value=\"".$sql_row1["lot_no"]."\" >".$sql_row1["lot_no"]."</td>";
		echo "<td>".$sql_row1["ref4"]."</td>";
		echo "<td><input type=\"hidden\" name=\"receivedqty[]\" value=\"".$sql_row1["qty_rec"]."\" >".$sql_row1["qty_rec"]."</td>";
	//	echo "<td>".$sql_row1["qty_rec"]."</td>";
		$bgcolor="#dfgfd";
		if($sql_row1["qty_issued"] > 0)
		{
			$bgcolor="#dgffdf";
		}
		echo "<td bgcolor=\"$bgcolor\">".$sql_row1["qty_issued"]."</td>";
		echo "<td>".$sql_row1["qty_ret"]."</td>";
		echo "<td><input type=\"hidden\" name=\"lotbal[]\" value=\"".($sql_row1["qty_rec"]+$sql_row1["qty_ret"]-$sql_row1["qty_issued"])."\"  />".($sql_row1["qty_rec"]+$sql_row1["qty_ret"]-$sql_row1["qty_issued"])."</td>";
		echo "<td><input type=\"text\"  name=\"issqty[]\" class='float' value=\"0\" $readonly onkeyup=\"DataCheck();\"/></td>";
		echo "</tr>";
		}
	}
	echo "</table></div>";
}

echo '<div style=\"overflow:scroll;\" class="table-responsive">
<table id="table1" class="mytable">';


echo "<tr><th>Date</th>	<th>Style</th>	<th>Schedule</th>	<th>Color</th>	<th>Product</th><th>M3 Item Code</th><th>M3 Item Description</th><th>Color/Size</th><th>Reason</th>"	;

switch($level)
{
	case 2:
	{
		echo"<th>Requested Qty</th><th>UOM</th><th>Approved Qty</th>";
		break;
	}
	
	case 3:
	{
		echo"<th>Approved Qty</th><th>UOM</th><th>Issued Qty</th><th>Balance Qty</th>";
		break;
	}
	default:
	{
		echo "<th>Requested Qty</th><th>UOM</th>";
	}
}


echo "<th>Req. From</th><th>Section</th>";
// Add the other remarks column at all Controls App/rej, update, allocate and issue.
switch($level)
{
	case 1:
	{
		echo "<th>Other Remarks</th>";
		break;
	}
	case 2:
	{
		echo "<th>Other Remarks</th>";
		break;
	}
	case 3:
	{
		echo "<th>Other Remarks</th>";
		break;
	}
}

echo "</tr>";	

if($level==3)
{
	$sql="select * from $bai_rm_pj2.mrn_track where rand_track_id=\"$ref\" and tid=\"$ref_tid\" and status=5";
}
else
{
	$sql="select * from $bai_rm_pj2.mrn_track where rand_track_id=\"$ref\" and tid=\"$ref_tid\"";
}
// echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{	
	$row_count++;
	$tid=$sql_row['tid'];
	echo "<tr>";
	echo "<td>".$sql_row['req_date']."</td>";
	echo "<td>".$sql_row['style']."</td>";
	echo "<td>".$sql_row['schedule']."</td>";
	echo "<td>".$sql_row['color']."</td>";
	echo "<td>".$sql_row['product']."</td>";
	echo "<td>".$sql_row['item_code']."</td>";
	echo "<td>".$sql_row['item_desc']."</td>";
	
	$sql1="select item_desc from $bai_rm_pj1.sticker_report where item like \"%".$sql_row['item_code']."%\"";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error23".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$item_desc=$sql_row1['item_desc'];
	}

	echo "<td>".$item_desc."</td>";
	// echo "<td>".$reason_code_db[array_search($sql_row['reason_code'],$reason_id_db)]."</td>";
	$reason_code = $sql_row['reason_code'];
	$sql_reason = "SELECT * FROM $bai_rm_pj2.mrn_reason_db WHERE reason_tid = \"$reason_code\"";
	$result_reason = mysqli_query($link,$sql_reason);
	$reason_row = mysqli_fetch_assoc($result_reason);
	echo "<td>".$reason_row['reason_code']."-".$reason_row['reason_desc']."</td>";
	switch($level)
	{
		case 2:
		{
			echo "<td>".$sql_row['req_qty']."</td>";
			echo "<td>".$sql_row['uom']."</td>";
   			break;
		}
		case 3:
		{
			echo "<td><input type=\"hidden\" id=\"avail\" value=\"".$sql_row['avail_qty']."\" />".$sql_row['avail_qty']."</td>";
			echo "<td>".$sql_row['uom']."</td>";
   			break;
		}
		default:
		{
			echo "<td>".$sql_row['req_qty']."</td>";
			echo "<td>".$sql_row['uom']."</td>";
		}
	}
	switch($level)
	{
		case 2:
		{
			echo "<td><input type=\"text\" class='float' name=\"available[]\" value=\"0\" onchange=\"if(this.value<0 || this.value>".$sql_row['req_qty'].") {  this.value=0; alert('Please enter correct value.');}\"  onfocus=\"this.focus();
   this.select();\" ></td>";
   			break;
		}
		case 3:
		{
			if(strlen($_GET["lots"]) > 0)
			{
				echo "<td><input type=\"text\" id=\"tot\" class='float' name=\"available[]\" value=\"0\" onchange=\"if(this.value<0 || this.value>".$sql_row['avail_qty'].") {  this.value=0; alert('Please enter correct value.');}\" onkeyup=\"DataCheck();\"  onfocus=\"this.focus(); this.select();\" ></td>";
				echo "<td><input type=\"text\" id=\"bal\" name=\"balneed[]\" value=\"0\"></td>";
				break;
			}
			else
			{
				echo "<td></td>";		
				echo "<td></td>";			
   				break;
			}
		}
	}
	
	echo "<td>".$sql_row['req_user']."<input type=\"hidden\" class='form-control' name=\"tid[]\" value=\"$tid\" ></td>";
	echo "<td>".$sql_row['section']."</td>";
	// Add the other remarks column at all Controls App/rej, update, allocate and issue.
	switch($level)
	{
		case 1:
			{
				echo "<td><input type=\"text\"  name=\"ins_rem\" value=\"0\"></td>";
	   			break;
			}
		case 2:
		{
			echo "<td><input type=\"text\"  name=\"ins_rem\" value=\"0\"></td>";
   			break;
		}
		case 3:
		{
			echo "<td><input type=\"text\"  name=\"ins_rem\" value=\"0\"></td>";
   			break;
		}
	}	
	echo "</tr>";
}

echo "</table>";
if($row_count == 0){
	echo "<b><font color='red'>No data Found</font></b>";
}
echo "<br/>";


switch($level)
{
	case 1:
	{
		echo "<input type=\"submit\" class='btn btn-success' name=\"approve\" value=\"Approve\">     <input type=\"submit\" class='btn btn-danger' name=\"reject\" value=\"Reject\">";
		break;
	}
	case 2:
	{
		echo "<input type=\"submit\" class='btn btn-success' name=\"update\" value=\"Update\">";
		break;
	}
	case 3:
	{
		if(strlen($_GET["lots"]) > 0)
		{
			echo "<input type=\"submit\" class='btn btn-success' name=\"issue\" value=\"Allocate\">";
			break;
		}
	}
	default:
	{
		echo "";
	}
}

echo "</form>";
}
?>

</div>

<script language="javascript" type="text/javascript">
//<![CDATA[
var MyTableFilter = {  exact_match: false,
col_4: "select" }
	setFilterGrid( "table1", MyTableFilter );
//]]>



$(document).ready(function(){
	$('#tot').on('change',function(e){
		//alert('hi');
	});
});


</script>


</div>
</div>


	<?php

	//APPROVE
	if(isset($_POST['approve']))
	{
		$tid=$_POST['tid'];
		$ins_rem=$_POST['ins_rem'];
		
		//echo "ins remarks= ".$ins_rem;
		$sql="update $bai_rm_pj2.mrn_track set status=2, app_by=\"$username\",app_date=\"".date("Y-m-d H:i:s")."\" where tid in (".implode(",",$tid).")";
		//echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error24".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql1="insert into $bai_rm_pj2.remarks_log (tid,remarks,username,date,level)values (".implode(",",$tid).",\"".$ins_rem."\",\"".$username."\",\"".date("Y-m-d H:i:s")."\",\"Approved\")";
		//echo $sql1;
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error25".mysqli_error($GLOBALS["___mysqli_ston"]));
		// echo "<h3><font color=green>Successfully Updated.</font></h3>";
		echo "<script>sweetAlert('Approved Successfully','','success')</script>";
		// echo "<br/><br/><h3><font color=Red>Please Refresh the page after Updation....</font></h3>";
		//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"mrn_form_log.php\"; }</script>";
		
		echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",4000); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
	}

	//REJECT
	if(isset($_POST['reject']))
	{
		$tid=$_POST['tid'];
		$ins_rem=$_POST['ins_rem'];
		$sql="update bai_rm_pj2.mrn_track set status=3, app_by=\"$username\",app_date=\"".date("Y-m-d H:i:s")."\" where tid in (".implode(",",$tid).")";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error26".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql1="insert into $bai_rm_pj2.remarks_log (tid,remarks,username,date,level)values (".implode(",",$tid).",\"".$ins_rem."\",\"".$username."\",\"".date("Y-m-d H:i:s")."\",\"Rejected\")";
		//echo $sql1;
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error27".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		// echo "<h3><font color=green>Successfully Updated.</font></h3>";
		echo "<script>sweetAlert('Rejected Successfully','','success')</script>";
		// echo "<br/><br/><h3><font color=Red>Please Refresh the page after Updation....</font></h3>";
		//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"mrn_form_log.php\"; }</script>";
		echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",4000); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
	}

	//UPDATE
	if(isset($_POST['update']))
	{
		$tid=$_POST['tid'];
		$ins_rem=$_POST['ins_rem'];
		$available=$_POST['available'];
		
		for($i=0;$i<sizeof($tid);$i++)
		{
			if($available[$i]>0)
			{
				$sql="update $bai_rm_pj2.mrn_track set status=5, updated_by=\"$username\",updated_date=\"".date("Y-m-d H:i:s")."\",avail_qty=".$available[$i]."  where tid=".$tid[$i];
			}
			else
			{
				$sql="update $bai_rm_pj2.mrn_track set status=6, updated_by=\"$username\",updated_date=\"".date("Y-m-d H:i:s")."\",avail_qty=0  where tid=".$tid[$i];
			}
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error28".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
		$sql1="insert into $bai_rm_pj2.remarks_log (tid,remarks,username,date,level)values (".implode(",",$tid).",\"".$ins_rem."\",\"".$username."\",\"".date("Y-m-d H:i:s")."\",\"Updated\")";
		//echo $sql1;
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error29".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		// echo "<h3><font color=green>Successfully Updated.</font></h3>";
		echo "<script>sweetAlert('Updated Successfully','','success')</script>";
		// echo "<br/><br/><h3><font color=Red>Please Refresh the page after Updation....</font></h3>";
		//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"mrn_form_log.php\"; }</script>";
		echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",4000); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
	}
	if(isset($_POST["submitlot"]))
	{
		$lots=$_POST["lots"];
		$ref=$_POST["ref"];
		$product=$_POST["product"];
		$reason_code=$_POST["reasoncode"];
		$level=$_POST["level"];
		$ref_tid=$_POST["ref_tid"];
		$updurl = getFullURL($_GET['r'],'update_form.php','N');
		header("Location:".$updurl."&ref=$ref&level=$level&product=$product&reason_code=$reason_code&lots=$lots&tid=$ref_tid");
	}
	//ISSUE
	if(isset($_POST['issue']))
	{		
		$tid=$_POST['tid'];
		$ins_rem=$_POST['ins_rem'];
		$available=$_POST['available'];
		//$val_ref=$_POST["receivedqty"];
		$val_ref=$_POST["lotbal"];
		$tid_ref=$_POST["lblids"];
		$issued_qty=$_POST["issqty"];
		$lot_nos=$_POST["lotnos"];
		$ref_tids=$_POST["ref_tid"];
		//echo sizeof($lable_ids);
		for($j=0;$j<sizeof($tid);$j++)
		{
			//if($available[$i]>0)
			{
				$sql="update $bai_rm_pj2.mrn_track set status=7, issued_by=\"$username\",issued_date=\"".date("Y-m-d H:i:s")."\",issued_qty=".$available[$j]."  where tid=".$tid[$j];
				//echo $sql."<br>";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		$host_name=str_replace(".brandixlk.org","",gethostbyaddr($_SERVER['REMOTE_ADDR']));
		for($j=0;$j<sizeof($issued_qty);$j++)
		{
			if($issued_qty[$j]>0)
			{
				$sql1="insert into $bai_rm_pj2.mrn_out_allocation(mrn_tid,lable_id,lot_no,iss_qty,updated_user) values(\"".$ref_tids[$j]."\",\"".$tid_ref[$j]."\",\"".$lot_nos[$j]."\",\"".$issued_qty[$j]."\",\"".$username."^".$host_name."\")";
				//echo $sql1."</br>";
				mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			

				if($issued_qty[$j]<=$val_ref[$j]){

			
					$issued_ref[$j]=$issued_qty[$j];
					$roll_splitting = roll_splitting_function($tid_ref[$j],$val_ref[$j],$issued_ref[$j]);

				}

				$sql3="update bai_rm_pj1.store_in set qty_issued=qty_issued+".$issued_qty[$j]." where tid=\"".$tid_ref[$j]."\"";
				//echo $sql3."</br>";
				mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

			}
			
		}
		
		$sql1="insert into $bai_rm_pj2.remarks_log (tid,remarks,username,date,level)values (".implode(",",$tid).",\"".$ins_rem."\",\"".$username."\",\"".date("Y-m-d H:i:s")."\",\"Allocate\")";
		//echo $sql1;
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
		// echo "<h3><font color=green>Successfully Updated.</font></h3>";
		echo "<script>sweetAlert('Allocated Successfully','','success')</script>";
		// echo "<br/><br/><h3><font color=Red>Please Refresh the page after Updation....</font></h3>";
		
		//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"mrn_form_log.php\"; }</script>";
		echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",4000); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
	}

	?>

		</div>
	</div>
</body>

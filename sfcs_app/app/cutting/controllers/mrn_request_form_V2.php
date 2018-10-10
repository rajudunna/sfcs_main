<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/rest_api_calls.php',3,'R'));
//$view_access=user_acl("SFCS_0166",$username,1,$group_id_sfcs); 
//var_dump(haspermission($_GET['r']));
?>

<?php

//echo $_SERVER['SERVER_NAME'];

$validation_ref_select="";
$validation_ref_text="";

if($flag==0)
{
	$validation_ref_select="onchange=\"checkqty($z1)\"";
	$validation_ref_text="onkeyup=\"checkqty($z1)\"";
}

?>

<script>

	var pgurl = '<?= getFullURL($_GET['r'],'mrn_request_form_V2.php','N'); ?>';
	function firstbox()
	{
		window.location.href = pgurl+"&style="+document.test.style.value
	}

	function secondbox()
	{
		window.location.href = pgurl+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value
	}

	function thirdbox()
	{
		

		window.location.href = pgurl+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
	}

	function fourthbox()
	{
		
		window.location.href = pgurl+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&cutno="+document.test.cutno.value
	}

	function fifthbox()
	{
		window.location.href = pgurl+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&cutno="+document.test.cutno.value+"&batchno="+document.test.batchno.value
	}

	//CR# 376 // kirang // 2015-05-05 // Referred the Batch number details to restrict the request of quantity requirement.
	function checkqty(rows)
	{
		var trows=document.getElementById("trows").value;
		//alert(trows);
		var avl_qty=document.getElementById("avl_qty").value;
		var tot=0;
		for(var row=1;row<=trows;row++)
		{
			var code=document.getElementById("resaon_"+row).value;
			if(document.getElementById("product_"+row).value == "FAB  ")
			{
				if(code==25 || code==29 || code==32 || code==31)
				{
					tot=tot+parseFloat(document.getElementById("qty_"+row).value);
					//alert(tot+"-"+avl_qty+"-"+document.getElementById("qty_"+row).value);
					if(parseFloat(avl_qty) < parseFloat(tot))
					{
						alert("Requested Quantity Is Exceeding The Available Quantity");
						document.getElementById("qty_"+row).value=0;
						document.getElementById("trowst").value=0;
					}
				}
			}
		}	
		document.getElementById("trowst").value=tot;
	}

</script>

<style>
body
{
	/* font-family:calibri;
	font-size:12px; */
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align: right;
white-space:nowrap; 
}

table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: BLUE;
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
</style>


<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R');?>"></script>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R');?>" type="text/css" media="all" />
	
<meta http-equiv="cache-control" content="no-cache">
<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "<?= getFullURLLevel($_GET['r'],'common/css/filtergrid.css',3,'R');?>";

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
th{ background-color:#29759c; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; }
table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
	background-color: white;
}
</style>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/actb.js',3,'R');?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/tablefilter.js',3,'R');?>"></script>

<Link rel='alternate' media='print' href=null>
<Script Language=JavaScript>

function setPrintPage(prnThis){

prnDoc = document.getElementsByTagName('link');
prnDoc[0].setAttribute('href', prnThis);
window.print();
}

</Script>

<style>

input
{
	border:none;
}

#table1 td{
	text-align:left;
}
</style>

<script>

function dodisable()
{
	//enableButton();

document.getElementById('process_message').style.visibility="hidden";
}


function enableButton() 
{
	var ele = document.getElementsByClassName('quantities');

	for(var i=0;i<ele.length;i++){
		if(ele[i].value > 0){
			var clr = document.getElementById('item_color'+i).value;
			var desc = document.getElementById('item_desc'+i).value;
			var code = document.getElementById('item_code'+i).value;
			var rem = document.getElementById('remarks'+i).value;
			if( clr=='' || desc =='' || code =='' || rem==''){
				swal('Fill all the Fields','','warning');
				document.getElementById('update').disabled=true;
				return false;
			}
			
		}
	}
	if(document.getElementById('option').checked == true)
		document.getElementById('update').disabled=false;
	else
		document.getElementById('update').disabled=true;
}

function button_disable()
{
	document.getElementById('process_message').style.visibility="visible";
	document.getElementById('option').style.visibility="hidden";
	document.getElementById('update').style.visibility="hidden";
}
</script>
<body>

<div class="panel panel-primary">
	<div class="panel-heading"><b>MRN Request Form</b></div>
	<div class="panel-body">
		<?php $pgurl = getFullURL($_GET['r'],'mrn_request_form_V2.php','N'); ?>
		<form name="test" action="<?= $pgurl ?>" method="post">

			<?php
			include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/menu_include.php',1,'R'));

			$style=$_GET['style'];
			$schedule=$_GET['schedule']; 
			$color=$_GET['color'];
			$cutno=$_GET["cutno"];
			$batch=$_GET["batchno"];
			//echo $cutno."<br>";
			//echo $style.$schedule.$color;
			?>

			<?php
			if(!isset($_POST['submit']))
			{
				

			echo "<div class='col-md-2'>Select Style: <select name=\"style\" onchange=\"firstbox();\" class='form-control'>";

			//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
			//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			//{
				$sql="select distinct order_style_no from $bai_pro3.bai_orders_db";	
				//Removed the condition " IN $global_style_codes"  array in the query 
			//}
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);

			echo "<option value=\"NIL\" selected>NIL</option>";
			while($sql_row=mysqli_fetch_array($sql_result))
			{

			if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
			{
				echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
			}
			else
			{
				echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
			}

			}

			echo "</select></div>";
			?>

			<?php

			echo "<div class='col-md-2'>Select Schedule: <select name=\"schedule\" onchange=\"secondbox();\" class='form-control'>";

			//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
			//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			//{
				$sql="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style\"";	
			//}
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);

			echo "<option value=\"NIL\" selected>NIL</option>";
			while($sql_row=mysqli_fetch_array($sql_result))
			{

			if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule))
			{
				echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
			}
			else
			{
				echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
			}

			}


			echo "</select></div>";
			?>

			<?php
			echo "<div class='col-md-2'>Select Color: <select name=\"color\" onchange=\"thirdbox();\" class='form-control'>";

			//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log) and order_style_no=\"$style\" and order_del_no=\"$schedule\"";
			//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			//{
				$sql="select distinct order_col_des from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
			//}
			
			// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);

			echo "<option value=\"NIL\" selected>NIL</option>";
				
			while($sql_row=mysqli_fetch_array($sql_result))
			{

			if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color))
			{
				echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
			}
			else
			{
				echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
			}

			}
			echo "</select></div>";

			?>

			<?php

			$sql="select distinct pcutno as cutno from $bai_pro3.plandoc_stat_log where order_tid like \"%$schedule$color%\"";
			// echo $sql;
			echo "<div class='col-md-2'>Select Cutno: <select name=\"cutno\" onchange=\"fourthbox();\" class='form-control'>";

			//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log) and order_style_no=\"$style\" and order_del_no=\"$schedule\"";
			//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			//{
			$sql="select distinct pcutno as cutno from $bai_pro3.plandoc_stat_log where order_tid like \"%$schedule$color%\"";
			//}
			//echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);

			echo "<option value=\"NIL\" selected>NIL</option>";
				
			while($sql_row=mysqli_fetch_array($sql_result))
			{

			if(str_replace(" ","",$sql_row['cutno'])==str_replace(" ","",$cutno))
			{
				echo "<option value=\"".$sql_row['cutno']."\" selected>".$sql_row['cutno']."</option>";
			}
			else
			{
				echo "<option value=\"".$sql_row['cutno']."\">".$sql_row['cutno']."</option>";
			}

			}
			echo "</select></div>";

			?>

			<?php

			//Fetching the batch number against to the lot issued to docket(cutno)
			echo "<div class='col-md-2'>Select Batch No: <select name=\"batchno\" onchange=\"fifthbox();\" class='form-control'>";

			echo "<option value=\"0\" selected>NIL</option>";

			$sql11="select order_tid from $bai_pro3.bai_orders_db where order_del_no=\"".$schedule."\" and order_col_des=\"".$color."\"";
			//echo "<option value=\"0\" selected>".$sql11."</option>";
			$sql_result11=mysqli_query($link, $sql11) or die("Error".$sql11.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row11=mysqli_fetch_array($sql_result11))
			{
				$order_tid_new=$sql_row11["order_tid"];
			}

			//echo $order_tid_new."<br>";

			//$sql12="select group_concat(plan_lot_ref) as plan_lot_ref from plandoc_stat_log where order_tid=\"$order_tid_new\" and acutno=\"".$cutno."\"";
			//echo $sql12."<br>";
			$sql12="select group_concat(plan_lot_ref) as plan_lot_ref,doc_no from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid_new\" and acutno=\"".$cutno."\" AND (fabric_status=5 or LENGTH(plan_lot_ref) > 0)";
			//echo "<option value=\"0\" selected>".$sql12."</option>";
			$sql_result12=mysqli_query($link, $sql12) or die("Error".$sql12.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row12=mysqli_fetch_array($sql_result12))
			{
				$lot_ref=$sql_row12["plan_lot_ref"];
				$doc_no=$sql_row12["doc_no"];
			}

			if(strlen($doc_no) > 0)
			{
				//$sql_doc="SELECT group_concat(tran_pin) as tid FROM bai_rm_pj1.fabric_cad_allocation where doc_no=".$doc_no." group by doc_no";
				$sql_doc="SELECT group_concat(roll_id) as tid FROM $bai_rm_pj1.fabric_cad_allocation where doc_no=".$doc_no." group by doc_no";
				//echo "<option value=\"0\" selected>".$sql_doc."</option>";
				$sql_result_doc=mysqli_query($link, $sql_doc) or die("Error".$sql_doc.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row_doc=mysqli_fetch_array($sql_result_doc))
				{
					$tid=$sql_row_doc['tid'];
				}

				if(strlen($tid) > 0)
				{
					$sql_tid="SELECT distinct(lot_no) FROM $bai_rm_pj1.store_in where tid in (".$tid.")";
					//echo "<option value=\"0\" selected>".$sql_tid."</option>";
					$sql_result_tid=mysqli_query($link, $sql_tid) or die("Error".$sql_tid.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row_tid=mysqli_fetch_array($sql_result_tid))
					{
						$lot_no=$sql_row_tid['lot_no'];
					}
				}

				//echo "<option value=\"0\" selected>".$lot_no."</option>";
				if(strlen($lot_no) > 0)
				{
					$lot_ref=$lot_ref.",".$lot_no;
				}

				if(strlen($lot_ref) > 0)
				{
					$sql13="select distinct batch_no as batch from $bai_rm_pj1.sticker_report where lot_no in (".str_replace(";",",",$lot_ref).") group by batch_no";
					$sql_result13=mysqli_query($link, $sql13) or die("Error".$sql13.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row13=mysqli_fetch_array($sql_result13))
					{
						$batch_ref[]=$sql_row13["batch"];
						if(str_replace(" ","",$sql_row13["batch"])==str_replace(" ","",$batch))
						{
							echo "<option value=\"".$sql_row13["batch"]."\" selected>".$sql_row13["batch"]."</option>";
						}
						else
						{
							echo "<option value=\"".$sql_row13["batch"]."\">".$sql_row13["batch"]."</option>";
						}
					}
				}
				else
				{
					//echo "<option value=\"0\">0</option>";
				}
			}
			echo "</select></div>";

			//echo "<br/>".$sql13;

			//To check the supplier approved quantity for issue availability 
			//CR# 376 // kirang // 2015-06-18 // Supplier Agreed Quantity Formula Has revised as per the discussion.
			$sql14="select COALESCE(SUM(supplier_replace_approved_qty))+COALESCE(SUM(supplier_claim_approved_qty)) as qty from $bai_rm_pj1.inspection_complaint_db where reject_batch_no=\"".$batch."\""; 

			//echo "<br/>".$sql14."<br/>";


			$sql_result14=mysqli_query($link, $sql14) or die("Error".$sql14.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row14=mysqli_fetch_array($sql_result14))
			{
				$available_qty=$sql_row14["qty"];
			}
			//To check the applied quantity is exceeds the available quantity
			//OLD ISSUE QUERY KK 20160721 $sql141="select COALESCE(sum(issued_qty)) as qty from bai_rm_pj2.mrn_track where batch_ref='".$batch."' AND reason_code IN (25,29,31,32)";

			$sql141="select COALESCE(sum(avail_qty)) as qty from $bai_rm_pj2.mrn_track where batch_ref='".$batch."' AND reason_code IN (25,29,31,32)";

			//echo "<br/>".$sql141."<br/>";

			$sql_result141=mysqli_query($link, $sql141) or die("Error".$sql141.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row141=mysqli_fetch_array($sql_result141))
			{
				$issued_qty=$sql_row141["qty"];
			}


			$requested_qty=0;

			$sql_requested_qty="select COALESCE(sum(req_qty)) as requested_qty from $bai_rm_pj2.mrn_track where batch_ref='".$batch."' AND reason_code IN (25,29,31,32) and status in (1,2,5)";
			//echo "<br/>".$sql_requested_qty."<br/>";

			$sql_result_requested_qty=mysqli_query($link, $sql_requested_qty) or die("Error".$sql_requested_qty.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row_requested_qty=mysqli_fetch_array($sql_result_requested_qty))
			{
				$requested_qty=$sql_row_requested_qty["requested_qty"];
			}


			if($issued_qty < 0 or $issued_qty=="" )
			{
				$issued_qty=0;
			}


			//echo $_GET["cutno"]."<br>";

			if($_GET["cutno"] > 0)
			{
				echo " <div class='col-md-1'><input type=\"submit\" class='btn btn-success' style='margin-top:18px;' value=\"Show\" name=\"submit\" id=\"add\" onclick=\"document.getElementById('add').style.display='none'; document.getElementById('msg').style.display='';\"></div><div class='col-md-12'><br><span id=\"msg\" style=\"display:none;\">&nbsp;&nbsp;Please Wait...</span> ";
			}
		
			if($available_qty > 0)
			{
				echo "<br><div class='col-md-12'>";
				echo "<h3>Available Qty = ".round(($available_qty-($issued_qty+$requested_qty)),3)."<br><br>To Request Fabric Under Below Categories.</h3>";
				echo "<h4>1. BEL Length Shortages <br>2. BEL RM Damages<br>3. BEL Width Shortages<br>4. BEL Closed Markers</h4>";
				echo "</div>";
			}
			else
			{
				echo "<br><div class='col-md-12'>";
				echo "<h3>Available Qty = 0<br><br>To Request Fabric Under Below Categories.</h3>";
				echo "<h4>1. BEL Length Shortages <br>2. BEL RM Damages<br>3. BEL Width Shortages<br>4. BEL Closed Markers</h4>";
				echo "</div>";
			}
			}

			if(isset($_GET['msg']))
			{
				if($_GET['msg']==1)
				{
					echo "<h3>Message: <font color=\"green\">Your request is successfully processed and Ref.#- ".$_GET['ref']."</font></h3>";
				}
				else
				{
					echo "<h3>Message: <font color=\"red\">No request submitted properly.</font></h3>";
				}	
			}
			?>
			</form>
			<?php
			if(isset($_POST['submit']))
			{
			$inp_1=$_POST['style'];
			$inp_2=$_POST['schedule'];
			$inp_3=str_replace("^","&",$_POST['color']);
			$inp_4=$_POST["cutno"];
			$count_ref=0;
			//CR# 376 // kirang // 2015-05-05 // Referred the Batch number details to restrict the request of quantity requirement.
			$inp_5=$_POST["batchno"];
			$post_color = $_POST['color'];
			$sql = "SELECT mo_no FROM $bai_pro3.mo_details WHERE style=\"$inp_1\" AND SCHEDULE=\"$inp_2\" AND color=\"$post_color\"";
			
			$sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
			$MIRecords = array();
			$MIRecords_color = array();
			while($sql_result_32=mysqli_fetch_array($sql_result)){
				 
				$url = $api_hostname.":".$api_port_no."/m3api-rest/execute/PMS100MI/SelMaterials?CONO=".$company_no."&FACI=".$global_facility_code."&MFNO=".$sql_result_32['mo_no'];
				$response_result = $obj->getCurlAuthRequest($url);
				$response_result = json_decode($response_result);
				
				$MIRecords[] = $response_result->MIRecord;

			}
			$FromMO = array();
			foreach($MIRecords as $key=>$value){
				foreach($value as $key1=>$value1){
					foreach($value1->NameValue as $res){
						$FromMO[$key][$key1][$res->Name] = $res->Value;
					}
				}
			}
			// echo count($MIRecords);
			$finalrecords = array();
			foreach($FromMO as $key=>$value){
				foreach($value as $key1=>$value1){
					$finalrecords[] = $value1;
				}
			}

			foreach($finalrecords as $key=>$value){

				$mtno = urlencode($value['MTNO']);
				$url = $api_hostname.":".$api_port_no."/m3api-rest/execute/MDBREADMI/GetMITMAHX1?CONO=".$company_no."&ITNO=".$mtno;
				
				$response_result1 = $obj->getCurlAuthRequest($url);
				$response_result1 = json_decode($response_result1);
				
				$MIRecords_color[] = $response_result1->MIRecord;
			}
			
			$FromMO_color = array();
			foreach($MIRecords_color as $key=>$value){
				foreach($value as $key1=>$value1){
					foreach($value1->NameValue as $res){
						$FromMO_color[$key][$key1][$res->Name] = $res->Value;
					}
				}
			}

			$finalrecords_color = array();
			foreach($FromMO_color as $key=>$value){
				foreach($value as $key1=>$value1){
					$finalrecords_color[] = $value1;
				}
			}
		
			// var_dump($finalrecords_color);
			// die();
			//echo "Cut=".$inp_4."<br>";

			//echo "<br/>Batch no".$inp_5."<br/>";

			$z1=0;

			$appr_qty=0;
			//CR# 376 // kirang // 2015-06-18 // Supplier Agreed Quantity Formula Has revised as per the discussion.
			//$sql14="select sum(supplier_replace_approved_qty) as qty from bai_rm_pj1.inspection_complaint_db where reject_batch_no in (".$batch_ref_implode.")";
			$sql14="select COALESCE(SUM(supplier_replace_approved_qty))+COALESCE(SUM(supplier_claim_approved_qty)) as qty from $bai_rm_pj1.inspection_complaint_db where reject_batch_no in ('".$inp_5."')";

			//echo "<br/>".$sql14."<br>";

			$sql_result14=mysqli_query($link, $sql14) or die("Error".$sql14.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row14=mysqli_fetch_array($sql_result14))
			{
				$appr_qty=$sql_row14["qty"];
			}

			if($appr_qty < 0 or $appr_qty=="")
			{
				$appr_qty=0;
			}

			//$sql141="select COALESCE(sum(issued_qty)) as qty from bai_rm_pj2.mrn_track where batch_ref='".$inp_5."' AND reason_code IN (25,29,31,32)";

			$sql141="select COALESCE(sum(avail_qty)) as qty from $bai_rm_pj2.mrn_track where batch_ref='".$inp_5."' AND reason_code IN (25,29,31,32)";
			//echo "<br/>".$sql141."<br/>";

			$sql_result141=mysqli_query($link, $sql141) or die("Error".$sql141.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row141=mysqli_fetch_array($sql_result141))
			{
				$issued_qty=$sql_row141["qty"];
			}

			$requested_qty=0;

			$sql_requested_qty="select COALESCE(sum(req_qty)) as requested_qty from $bai_rm_pj2.mrn_track where batch_ref='".$inp_5."' AND reason_code IN (25,29,31,32) and status in (1,2,5)";
			//echo "<br/>".$sql_requested_qty."<br/>";

			$sql_result_requested_qty=mysqli_query($link, $sql_requested_qty) or die("Error".$sql_requested_qty.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row_requested_qty=mysqli_fetch_array($sql_result_requested_qty))
			{
				$requested_qty=$sql_row_requested_qty["requested_qty"];
			}



			$available_qty_req=0;

			if(round(($appr_qty-$issued_qty),3) > 0)
			{
				$available_qty_req=round(($appr_qty-($issued_qty+$requested_qty)),3);
			}

			//echo $lot_ref."<br>";
			//When M3 offline comment this
			$sql="select rand_track_id from $bai_rm_pj2.mrn_track where style='$inp_1' and schedule='$inp_2' 
				   group by rand_track_id";
			//echo $sql;
			$sql_res = mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($sql));
			$cnt = mysqli_num_rows($sql_res);
			echo "Style: <b>$inp_1</b> | Schedule: <b>$inp_2</b> | Total requests from this schedule: <b>".$cnt."</b><br/>";

			echo "<br><br>Available Quantity To Apply Under Fabric Requirement=".$available_qty_req."<input type=\"hidden\" id='avl_qty' size=5 value=\"".$available_qty_req."\"/><br><br>Reserved Qty=<input type=\"text\" name=\"trowst\" size=5 id=\"trowst\" value=\"0\">";

			echo "<h3><center>Additional Material Request Form</center></h3>";

			$pageurl = getFullURL($_GET['r'],'mrn_request_form_update_V2.php','N');
			echo "<form name=\"test\" method=\"post\" action='".$pageurl."'>";
			echo '<div style=\"overflow:scroll;\" class="table-responsive">
			<table id="table1" class="table table-bordered">';
			echo "<tr class='tblheading'>
				<th>Product Group</th>
				<th>Item</th>
				<th>Item Description</th>
				<th>Color</th>
				<th bgcolor=\"red\">Price</th>
				<th>BOM Qty</th>
				<th>Issued Qty</th>
				<th>Required Qty</th>
				<th>UOM</th>
				<th>Reason</th>
				<th>Remarks</th>
			</tr>";
			$check=0;

			//When M3 offline comment this

			if($count_ref==0)
			{
			$reason_id_db = array();
			$reason_code_db = array();
			$sql_reason="select * from $bai_rm_pj2.mrn_reason_db where status=0 order by reason_order";
			$sql_result=mysqli_query($link, $sql_reason) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$count = mysqli_num_rows($sql_result);
			
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				
				$reason_id_db[]=$sql_row['reason_tid'];
				$reason_code_db[]=$sql_row['reason_code']."-".$sql_row['reason_desc'];
			}

			if(count($finalrecords) > 0){
				
			for($x=0;$x<count($finalrecords);$x++)
			{
			
				$z1=$z1+1;	
				$check=1;
				echo "<input type=\"hidden\" name=\"price[]\" value=\"0\">";
				echo "<tr bgcolor='$bgcolor'>";
				
				//echo "<td>$proc_grp</td>";
				//echo "<td>$material_item</td>";
				//echo "<td>$item_description</td>";
				
				//When M3 offline uncomment this
				$opno = (int)$finalrecords[$x]['OPNO'];
				// echo "<td><select name=\"product[]\"><option value='STRIM' selected>STRIM</option><option value='PRTIM'>PTRIM</option><option value='FAB'>FAB</option></select></td>";
				if($opno === 15){
					echo "<td><input type=\"hidden\" name=\"product[]\" value=\"FAB\">FAB</td>";
				}
				if($opno > 15 && $opno < 100){
					echo "<td><input type=\"hidden\" name=\"product[]\" value=\"ETRIM\">ETRIM</td>";
				}
				if($opno === 200){
					echo "<td><input type=\"hidden\" name=\"product[]\" value=\"PTRIM\">PTRIM</td>";
				}

				if($opno >= 100 && $opno < 200){
					echo "<td><input type=\"hidden\" name=\"product[]\" value=\"STRIM\">STRIM</td>";
				}
				

				$item_code = $finalrecords[$x]['MTNO'];
				echo "<td><input type=\"hidden\" name=\"item_code[]\" id='item_code$x' value=\"$item_code\" style=\"background-color:#66FFCC;\" readonly='true'>$item_code</td>";
				$item_des = $finalrecords[$x]['ITDS'];
				echo "<td><input type=\"hidden\" name=\"item_desc[]\" id='item_desc$x' value=\"$item_des\" style=\"background-color:#66FFCC;\" readonly='true'>$item_des</td>";

				foreach($finalrecords_color as $key=>$value){
					if($finalrecords[$x]['MTNO'] === $value['ITNO']){
						$color = $value['OPTY'];
						break;
					}else{
						$color = '';
					}
				}
				echo "<td><input type=\"hidden\" name=\"co[]\" id='item_color$x' value=\"$color\" style=\"background-color:#66FFCC;\">$color</td>"; 

				echo "<td></td>";
				$bom_qty = $finalrecords[$x]['REQT'];
				echo "<td>".$bom_qty."</td>";
				$alloc_qty = $finalrecords[$x]['ALQT'];
				echo "<td>".$alloc_qty."</td>";
				//echo "<td>".round($req_qty,2)."</td>";
				//echo "<td>".round($iss_qty,2)."</td>";
				echo "<td><input style=\"background-color:#66FFCC;\" class='integer quantities' type=\"text\" size=\"5\" value=\"0\" onchange=\"if(this.value<0) { this.value=0; alert('Please enter correct value.'); }\" ".$validation_ref_text." id=\"qty_$z1\"  onfocus=\"this.focus();this.select();\" name=\"qty[]\"></td>";
			
			//When M3 offline comment this (Key word: When M3)
				/* echo "<input type=\"hidden\" id=\"product_$z1\" name=\"product[]\" value=\"$proc_grp\">
				<input type=\"hidden\" name=\"item_code[]\" value=\"$material_item\">
				<input type=\"hidden\" name=\"item_desc[]\" value=\"$item_description\">
				<input type=\"hidden\" name=\"uom[]\" value=\"$uom\">
				<input type=\"hidden\" name=\"co[]\" value=\"$co\">"; */
				
				//When M3 offline comment this (Key word: When M3)
				$uom = $finalrecords[$x]['PEUN'];
				echo "<td><input type=\"hidden\" name=\"uom[]\" value=\"$uom\">".$uom."</td>";
				// echo "<td><select name=\"uom[]\"  disabled='true'>
				// 		<option value='PCS' ";
				// 		if($uom == 'PCS'){
				// 			echo 'selected';
				// 		}
				// 		echo ">PCS</option>
				// 		<option value='$fab_uom' ";
				// 		if($uom == 'YRD'){
				// 			echo 'selected';
				// 		}
				// 		echo ">$fab_uom</option>
				// 		</select>
				// 	</td>";

					
				//echo "<td>$uom</td>";
				// $reason_id_db = array();
				// $reason_code_db = array();
				// $sql_reason="select * from $bai_rm_pj2.mrn_reason_db where status=0 order by reason_order";
				// $sql_result=mysqli_query($link, $sql_reason) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				// while($sql_row=mysqli_fetch_array($sql_result))
				// {
				// 	$reason_id_db[]=$sql_row['reason_tid'];
				// 	$reason_code_db[]=$sql_row['reason_code']."-".$sql_row['reason_desc'];
				// }

				echo "<td><select name=\"reason[]\" id=\"resaon_$z1\" ".$validation_ref_select." >";
				for($i=0;$i<sizeof($reason_code_db);$i++)
				{
					echo "<option value=\"".$reason_id_db[$i]."\">".$reason_code_db[$i]."</option>";
				}
				echo "</select></td>";
				echo "<td><input type=\"text\" value=\"\" name=\"remarks[]\" id='remarks$x' style=\"background-color:#66FFCC;\"></td>";
				echo "</tr>";
			}
		}
		if(count($finalrecords) == 0){
			
			for($x=0;$x<10;$x++)
			{
			
				$z1=$z1+1;	
				$check=1;
				echo "<input type=\"hidden\" name=\"price[]\" value=\"0\">";
				echo "<tr bgcolor='$bgcolor'>";
				
				//echo "<td>$proc_grp</td>";
				//echo "<td>$material_item</td>";
				//echo "<td>$item_description</td>";
				
				//When M3 offline uncomment this
				echo "<td><select name=\"product[]\"><option value='STRIM' selected>STRIM</option><option value='PRTIM'>PTRIM</option><option value='FAB'>FAB</option></select></td>";
				echo "<td><input type=\"text\" name=\"item_code[]\" id='item_code$x' value=\"\" style=\"background-color:#66FFCC;\" ></td>";
				echo "<td><input type=\"text\" name=\"item_desc[]\" id='item_desc$x' value=\"\" style=\"background-color:#66FFCC;\" ></td>";
				echo "<td><input type=\"text\" name=\"co[]\" id='item_color$x' value=\"\" style=\"background-color:#66FFCC;\"></td>"; 
				
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				//echo "<td>".round($req_qty,2)."</td>";
				//echo "<td>".round($iss_qty,2)."</td>";
				echo "<td><input style=\"background-color:#66FFCC;\" class='integer quantities' type=\"text\" size=\"5\" value=\"0\" onchange=\"if(this.value<0) { this.value=0; alert('Please enter correct value.'); }\" ".$validation_ref_text." id=\"qty_$z1\"  onfocus=\"this.focus();this.select();\" name=\"qty[]\"></td>";
			
			//When M3 offline comment this (Key word: When M3)
				/* echo "<input type=\"hidden\" id=\"product_$z1\" name=\"product[]\" value=\"$proc_grp\">
				<input type=\"hidden\" name=\"item_code[]\" value=\"$material_item\">
				<input type=\"hidden\" name=\"item_desc[]\" value=\"$item_description\">
				<input type=\"hidden\" name=\"uom[]\" value=\"$uom\">
				<input type=\"hidden\" name=\"co[]\" value=\"$co\">"; */
				
				//When M3 offline comment this (Key word: When M3)
				$uom = $finalrecords[$x]['PEUN'];
				echo "<td><select name=\"uom[]\"  >
						<option value='PCS'>PCS</option>
						<option value='$fab_uom'>$fab_uom</option>
						</select>
					</td>";
				//echo "<td>$uom</td>";
				
				echo "<td><select name=\"reason[]\" id=\"resaon_$z1\" ".$validation_ref_select." >";
				for($i=0;$i<sizeof($reason_code_db);$i++)
				{
					echo "<option value=\"".$reason_id_db[$i]."\">".$reason_code_db[$i]."</option>";
				}
				echo "</select></td>";
				echo "<td><input type=\"text\" value=\"\" name=\"remarks[]\" id='remarks$x' style=\"background-color:#66FFCC;\"></td>";
				echo "</tr>";
			}
		}

			}

			echo "</table>";
			echo "<input type=\"hidden\" name=\"style\" value=\"$inp_1\"><input type=\"hidden\" name=\"schedule\" value=\"$inp_2\"><input type=\"hidden\" name=\"color\" value=\"$inp_3\"><input type=\"hidden\" name=\"cutno\" value=\"$inp_4\"><input type=\"hidden\" name=\"batch_ref\" value=\"$inp_5\"><input type=\"hidden\" name=\"trows\" id=\"trows\" value=\"$z1\">";
			echo "<br/>";
			if($check==1)
			{
			echo "<div class='col-md-3'>Section: <select name=\"section\" class='form-control'>";
				$sql="SELECT sec_id as secid FROM $bai_pro3.sections_db WHERE sec_id NOT IN (0,-1) ORDER BY sec_id";
				$result17=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($result17))
				{
					$sql_sec=$sql_row["secid"];
					echo "<option value=\"".$sql_sec."\">Section - ".$sql_sec."</option>";
						
				}
				echo "</select></div>";

			echo '<div class="col-md-3"><input type="checkbox" name="option"  id="option" 
					onclick="return enableButton();">Enable';
			echo "&nbsp;&nbsp;<input type=\"submit\" style='margin-top:18px;' disabled class='btn btn-success' id=\"update\" name=\"update\" value=\"Submit Request\" onclick=\"javascript:button_disable();\">";
			echo "</div></form><br>";	
			//echo '<div id="process_message"><h2><font color="red">Please wait while updating data!!!</font></h2></div>';
			}
			//When M3 offline uncomment this
			//odbc_close($connect); 
			}
			?> 


			<script language="javascript" type="text/javascript">
				var MyTableFilter = {  
					exact_match: false,
					//col_0:'select'
				}
				setFilterGrid( "table1", MyTableFilter );
				// $(document).ready(function(){
				// 	$('#flt0_table1').append('<option value="STRIM">STRIM</option>');
				// 	$('#flt0_table1').append('<option value="PTRIM">TRIM</option>');
				// 	$('#flt0_table1').append('<option value="FAB">TRIM</option>');
				// });
			</script>
			</div>
		</div>
	</div>
</body>




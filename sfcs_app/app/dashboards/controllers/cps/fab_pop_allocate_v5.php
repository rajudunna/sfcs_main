<!DOCTYPE html>
<html>
<head>

</head>
<body>
<style>
.fade{
	width:100%;
}
/* .loader {
   position: absolute;
   left: 50%;
   top: 50%;
   height:60px;
   width:60px;
   margin:0px auto;
   -webkit-animation: rotation .6s infinite linear;
   -moz-animation: rotation .6s infinite linear;
   -o-animation: rotation .6s infinite linear;
   animation: rotation .6s infinite linear;
   border-left:6px solid rgba(0,174,239,.15);
   border-right:6px solid rgba(0,174,239,.15);
   border-bottom:6px solid rgba(0,174,239,.15);
   border-top:6px solid rgba(0,174,239,.8);
   border-radius:100%;
}

@-webkit-keyframes rotation {
   from {-webkit-transform: rotate(0deg);}
   to {-webkit-transform: rotate(359deg);}
}
@-moz-keyframes rotation {
   from {-moz-transform: rotate(0deg);}
   to {-moz-transform: rotate(359deg);}
}
@-o-keyframes rotation {
   from {-o-transform: rotate(0deg);}
   to {-o-transform: rotate(359deg);}
}
@keyframes rotation {
   from {transform: rotate(0deg);}
   to {transform: rotate(359deg);}
} */
</style>

<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs_app/app/dashboards/common/css 	/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>
<?php 

$php_self = explode('/',$_SERVER['PHP_SELF']);
array_pop($php_self);
$url_r = base64_encode(implode('/',$php_self)."/fab_priority_dashboard.php");
$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index.php?r=".$url_r;
?>
<br/>
<div class='row'>
	<div class='col-md-2 pull-left'>
		<a class='btn btn-primary' href = '<?= $url ?>'> << Back</a>
	</div>
</div>
<br/>
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>
<?php
    //error_reporting(0);
	include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');
	$php_self = explode('/',$_SERVER['PHP_SELF']);
	array_pop($php_self);
	$url_r = base64_encode(implode('/',$php_self)."/fab_pop_allocate_v5.php");
	$has_permission=haspermission($url_r);
?>
	<!-- <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=11; IE=10;IE=9; IE=8; IE=7; IE=EDGE" /> -->


		<style>
		
		/* input#allocate_new {
		display: none;
		} */

		/* .dataTables_filter {
		display: none; 
		} */

		body
		{
			font-family: Trebuchet MS;
			/* font-size: 14px; */
		}
		.btnflt{
			width:100%;
		}
		#chk11770{
			width:60%;
		}
		table
		{
		border-collapse:collapse;
		white-space:nowrap;
		font-size:12px;
		}
		tr.total
		{
		font-weight: bold;
		white-space:nowrap; 
		}

		/* table
		{
		border-collapse:collapse;
		white-space:nowrap;
		font-size: 12pt; 
		}
		*/
		th
		{
			/* font-size:14px; */
			text-align: center;
			width:100%;

			color: WHITE;
		border: 1px solid #660000;
			padding: 10px;
		white-space:nowrap; 

		}

		td
		{
			/* font-size:14px; */
			/* text-align: center; */
			/* width:100%; */
			color: BLACK;
		border: 1px solid #660000;
			padding: 1px;
		white-space:nowrap; 
		}

		td.date
		{
			
			color: BLACK;
		border: 1px solid #660000;
			padding: 5px;
		white-space:nowrap;
		text-align:center;
		}


		td.style
		{
			
			color: BLACK;
		border: 1px solid #660000;
			padding: 2px;
		white-space:nowrap; 
		font-weight: bold;
		}
		</style>

<script src="../../../../common/js/jquery-1.12.4.js"></script>

<link rel='stylesheet' href="../../../../common/css/bootstrap.min.css">
<!-- <link rel='stylesheet' href="../../common/css/tablefilter.css"> -->
<script src="../../../../common/js/sweetalert.min.js"></script>
<!-- <link rel="stylesheet" href="../../../../common/css/jquery.dataTables.min.css">  -->
 <!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/tablefilter/2.5.0/tablefilter_min.js'></script> -->

<!-- <script language="javascript" type="text/javascript" src="../../../../common/js/TableFilter_EN/actb.js"></script>
<script language="javascript" type="text/javascript" 
src="../../../../common/js/TableFilter_EN/tablefilter.js"></script> -->
<script src="../../common/js/tablefilter.js"></script>

<script>


			// $(document).keypress(
			// 		function(event){
			// 		if (event.which == '13')
			// 		{
			// 			event.preventDefault();
			// 		}
			// });
	

function button_disable()
{
	document.getElementById('process_message').style.visibility="visible";
	document.getElementById('allocate_new').style.visibility="hidden";
}
 
</script>
<script>

function dodisable()
{
//enableButton();
document.getElementById('process_message').style.visibility="hidden"; 
//OK document.getElementById('allocate_new').style.visibility="hidden";

}
</script>

<script>
function check_qty(x)
{
	var check=0;
	
	for(i=0;i<x;i++)
	{
		var doc_ref=document.input["doc_ref["+i+"]"].value;
		var mat_req=document.input["mat_req["+i+"]"].value;
		var no_ele=document.input["chk"+doc_ref+"[]"];
		no_ele=(parseInt(no_ele.length));
		
		var selc=0;
		for(j=0;j<no_ele;j++)
		{
			
			var tx="chk"+doc_ref+j;
			if(document.getElementById(tx).checked)
			{
				selc=selc+parseFloat((document.input["val"+doc_ref+"["+j+"]"].value));	
			}
		}
		
		if(selc<mat_req)
		{
			check=0;
			//break;
		}
		else
		{
			check=1;
		}
		
	}
	if(check==1)
	{
		document.getElementById('validate').style.visibility="hidden";
		document.getElementById('allocate_new').style.visibility="";
		
	}
	else
	{
		alert("Please select sufficient qty");
		document.getElementById('validate').checked=false;
	}
}
function none(){
	//console.log('incoming = '+m);
	// alert(x+m+n);
	//chk1910;
	//srgp1910;

	//var chks = document.getElementsByName('chk19');
	// for(var i=0;i<lenght(chks);i++){
	// 	var clicked = document.getElementById();
	// 	if()
	// }
	
	// if(Number(check_count) >= 1){
	// 	var chks = document.getElementsByName('chk19[]');
	// 	for(var i=0;i<chks.length;i++){
	// 		if(chks[i].checked){
	// 			//console.log('checked'+chks[i].id);
	// 			//console.log(chks[i].id);
	// 			var srid = (chks[i].id).substr(5);
				
	// 			//console.log(srid);
	// 			var srgp = document.getElementById('srgp19'+srid).value;
	// 			console.log('pre_id = '+previous_id);
	// 			var previous_grp = document.getElementById(previous_id).value;
	// 			if(srgp == previous_grp){
	// 				swal('Shrinkage groups must be unique','','warning');
	// 			}
	// 			console.log('group '+srgp);
	// 			previous_id = srid;
	// 		}
	// 	}
	// }
}

var initial_count=0
var check_count = 0;
var srgp;
var srgp1;
var doc_count = 0;
var verifier = 0;
var doc_flag=0;
function check_qty2(x,m,n,doc)
{	
//PLEASE DO NOT MODIFY THE ORDER OF ANY OF THE BELOW STATEMENTS OF THIS FUNCTION
	////  code for shrinkage validation
	if(doc_count==0){
		old_doc = doc;
		doc_count++;
	}
	if(old_doc != doc){
		initial_count = 0;
		doc_count = 0;
		verifier = 0;
		sr_id1 = m.substr(3);
		srgp1 = document.getElementById('srgp'+sr_id1).value; 
		console.log('Not equal '+doc+' new doc'+old_doc);
	}
	
	if(initial_count == 0){
		console.log('entered');
		var chks = document.getElementsByName('chk'+doc+'[]');
		for(var i=0;i<chks.length;i++){
			if(chks[i].checked){
				verifier++;
				var sr_id2 = chks[i].id.substr(3);
				srgp = document.getElementById('srgp'+sr_id2).value;
			}
			console.log('old = '+srgp+' new = '+srgp1);
			if(verifier>1){
				verifier=0;
				if(srgp != srgp1){
					swal('Shrinkage group is not unique','','error');
					document.getElementById(m).checked = false;
					var xx="tr"+m;
					document.getElementById(xx).style.backgroundColor = '#fff';
					return;
				}
			}
		}
	
	}
	////  code for shrinkage validation

	if(document.getElementById(m).checked)
	{
		//////  code for shrinkage validation
		if(Number(initial_count)==1){
			// console.log('innnnn');
			var sr_id1 = m.substr(3);
			srgp1 = document.getElementById('srgp'+sr_id1).value;
			// console.log('now = '+srgp1);
			// console.log('old = '+srgp);
			// console.log('len '+srgp.length);
			if(srgp.length > 0){
				if(srgp != srgp1){
					swal('Shrinkage group is not unique','','error');
					document.getElementById(m).checked = false;
					return;
				}else{
					srgp = srgp1;
				}
			}else{
				// console.log('lesser');
			}
		}
		check_count++;
		//////  code for shrinkage validation ends
		var xx="tr"+m;
		document.getElementById(xx).style.backgroundColor = "#99CCFF";
	}
	else
	{
		////  code for shrinkage validation
		srgp='';
		check_count--;
		verifier=0;
		////  code for shrinkage validation
		var xx="tr"+m;
		document.getElementById(xx).style.backgroundColor = n;
	}
	////  code for shrinkage validation
	if(initial_count == 0){
		initial_count++;
	}
	//var doc_chk = document.getElementById('doc_chk').value;
	//console.log(doc_chk+' docket');
	var chks = document.getElementsByName('chk'+doc+'[]');
	var coun = 0;
	for(var i=0;i<chks.length;i++){
		if(chks[i].checked){
			var sr_id2 = chks[i].id.substr(3);
			srgp = document.getElementById('srgp'+sr_id2).value;
		}else{
			coun++;
		}
	}
	if(coun == chks.length){
		initial_count = 0;
	}	
	// console.log('check_count '+check_count);
	////  code for shrinkage validation
///////////////////////SHRINKAGE VALIDATION ENDS	
	var check=0;
	var alloc_disab=0;
	for(i=0;i<x;i++)
	{
		var doc_ref=document.input["doc_ref["+i+"]"].value;
		var mat_req=document.input["mat_req["+i+"]"].value;
		var no_ele=document.input["chk"+doc_ref+"[]"];
		no_ele=(parseInt(no_ele.length));
		var selc=0;
		var widt=0;
		var issued_qty=0;
		var round_val=0;
		var alloc_qty=0;
		for(j=0;j<no_ele;j++)
		{
			
			var tx="chk"+doc_ref+j;
			widt=0;
			//console.log("chk"+doc_ref+j);
			if(document.getElementById(tx).checked)
			{
				
				issued_qty=document.input["val"+doc_ref+"["+j+"]"].value;
				if(widt<=parseFloat((document.input["width"+doc_ref+"["+j+"]"].value)))
				{	
					selc=selc+parseFloat((document.input["val"+doc_ref+"["+j+"]"].value));
					widt=parseFloat((document.input["width"+doc_ref+"["+j+"]"].value));
					document.input["min_width["+i+"]"].value=widt;
					
					if(selc<=mat_req){
						document.getElementById("issued"+doc_ref+"["+j+"]").innerHTML=issued_qty;
						document.getElementById("issued_new"+doc_ref+"["+j+"]").value=issued_qty;
						alloc_qty=alloc_qty+parseFloat(issued_qty);
					}else{
						if((mat_req-selc)<0){
							round_val=(parseFloat(mat_req)-parseFloat(selc)+parseFloat(issued_qty));
								if(round_val>0){
									document.getElementById("issued"+doc_ref+"["+j+"]").innerHTML=round_val.toFixed(2);
									document.getElementById("issued_new"+doc_ref+"["+j+"]").value=round_val.toFixed(2);
									alloc_qty=alloc_qty+parseFloat(round_val.toFixed(2));
								}else{
									//alert("Dear user...You already completed required Quantity");
									sweetAlert("User...You already completed required Quantity"," ","warning");
									document.getElementById("issued"+doc_ref+"["+j+"]").innerHTML="";
									if(document.getElementById("issued_new"+doc_ref+"["+j+"]").value){
										//console.log("true"+ "chk"+doc_ref+j);
										document.getElementById(m).checked = true;
										document.getElementById("chk"+doc_ref+j).checked = false;
									}else{
										//console.log("false"+"chk"+doc_ref+j);
										document.getElementById(m).checked = false;
									}
								}
						}
						
						
					}
				}else{
					// console.log('test');
					console.log(widt+"<="+parseFloat((document.input["width"+doc_ref+"["+j+"]"].value))+" J = "+j);
				}
			}else{
					document.getElementById("issued"+doc_ref+"["+j+"]").innerHTML="0";
				}

		}
		
		//validation for allocate button for component
		if(doc_flag!=doc_ref){
			if(alloc_qty>0){
				check=1;
				alloc_disab=Number(alloc_disab)+Number(check);
				doc_flag=doc_ref;
			}
			
		}
		

		if(selc<mat_req)
		{
			check=0;
			document.getElementById(doc_ref).style.backgroundColor = "RED";
			//OK document.getElementById('validate').style.visibility="";
			//document.getElementById('allocate_new').style.visibility="hidden";
			
			//To show stats
			document.getElementById('alloc'+doc_ref).innerHTML=parseFloat(alloc_qty.toFixed(2));
			document.getElementById('balal'+doc_ref).innerHTML=parseFloat((mat_req-selc).toFixed(2));
			//break;
		}
		else
		{
			check=1;
			alloc_disab=Number(alloc_disab)+Number(check);
			document.getElementById(doc_ref).style.backgroundColor = "GREEN";
			//To show stats
			document.getElementById('alloc'+doc_ref).innerHTML=parseFloat(alloc_qty.toFixed(2));
			//document.getElementById('balal'+doc_ref).innerHTML=Math.round((mat_req-selc),2);
			if((mat_req-selc)<=0){
				round_val=(parseFloat(mat_req)-parseFloat(selc)+parseFloat(issued_qty));
				//document.getElementById("issued"+doc_ref+"["+j+"]").innerHTML=Math.round((round_val),2);
				document.getElementById('balal'+doc_ref).innerHTML=0;
			}
		}
	}

	//alert(x);
	//alert(alloc_disab);
	//new condition added for allocated button enabled/disabled based on quantity
	// if(x<=alloc_disab){
	// 	document.getElementById("allocate_new").style.display = "block";
	// }else{	
	// 	document.getElementById("allocate_new").style.display = "none";
	// }


	if(check==0)
	{
		//alert("Please select sufficient qty.");
		//OK document.getElementById('validate').checked=false;
	}	
	//NEW
	//document.getElementById('allocate_new').style.visibility="";
}

</script>

<div class="panel panel-primary">
	<div class="panel-heading"><b><font size="4">Fabric Allocation Panel</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div>
	<font color="red">Note:</font>Please select atleast one roll for allocation in every component</b>
		<div class="panel-body">
			<!-- <div class="loader"></div> -->

<?php
//Auto Selecting Based on Manual Decision.

/*list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2);
$authorized=array("kirang","herambaj","kishorek","sarojiniv","ravipu","ramanav","sekhark","lovakumarig","ganeshb","pithanic");
if(!(in_array(strtolower($username),$authorized)))
{
	header("Location:restrict.php");
}
*/
if((in_array($authorized,$has_permission)))
{
	header($_GET['r'],'restrict.php','N');
}

echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color=\"red\">Please wait while preparing data...</font></h1></center></div>";
	
	ob_end_flush();
	flush();
	usleep(10);

?>

<?php
set_time_limit(2000);
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
?>



<?php

if(isset($_POST['allocate_new']))
{
	$doc_ref=$_POST['doc_ref']; //array
	$min_width=$_POST['min_width'];	//array
	$lot_db=$_POST['lot_db']; //array
	$process_cat=$_POST['process_cat'];
	
	for($i=0;$i<sizeof($doc_ref);$i++)
	{
		$temp="lable".$doc_ref[$i];
		$tid_ref_base=$_POST[$temp];
		$temp="width".$doc_ref[$i];
		$width_ref_base=$_POST[$temp];
		$temp="val".$doc_ref[$i];
		$val_ref_base=$_POST[$temp];
		$temp="issued_new".$doc_ref[$i];
		$issued_ref_base=$_POST[$temp];
		
		
		$temp="chk".$doc_ref[$i];
		$chk_ref=$_POST[$temp];
		
		unset($tid_ref);
		unset($width_ref);
		unset($val_ref);
		unset($issued_ref);
		
		$tid_ref=array();
		$width_ref=array();
		$val_ref=array();
		$issued_ref=array();
		
		for($j=0;$j<sizeof($chk_ref);$j++)
		{
			$x=$chk_ref[$j];
			$tid_ref[]=$tid_ref_base[$x];
			$width_ref[]=$width_ref_base[$x];
			$val_ref[]=$val_ref_base[$x];
			$issued_ref[]=$issued_ref_base[$x];
		}
		//var_dump($issued_ref);
		
		if(strpos(strtolower($lot_db[$i]),"stock"))
		{
			$tid_ref[]=0;
		}
		
		if(sizeof($tid_ref)>0)
		{
		
		//To extrac required information to find marker length for the docket.
		unset($allo_c);
		$allo_c=array();
	
		$sql="select cat_patt_ver,doc_no,material_req,mk_ref,cat_ref,allocate_ref,style_id,mk_ver,category,p_xs,p_s,p_m,p_l,p_xl,p_xxl,p_xxxl,p_s06,p_s08,p_s10,p_s12,p_s14,p_s16,p_s18,p_s20,p_s22,p_s24,p_s26,p_s28,p_s30,strip_match,gmtway,fn_savings_per_cal(DATE,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix where doc_no=\"".$doc_ref[$i]."\"";
		//echo $sql."<br/>";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error1 :$sql ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$extra=0;
			//if(substr($style_ref,0,1)=="M")
			{
				$extra=round(($sql_row['material_req']*$sql_row['savings']),2);
			}
			$material_req1=$sql_row['material_req']+$extra;
			$mk_ref=$sql_row['mk_ref'];
			$cat_ref=$sql_row['cat_ref'];
			$allocate_ref=$sql_row['allocate_ref'];
			$style_code=$sql_row['style_id'];
			$buyer_code=substr($style_ref,0,1);
			$mk_ver=$sql_row['mk_ver'];
			$category=$sql_row['category'];
			$strip_match=$sql_row['strip_match'];
			$gmtway=$sql_row['gmtway'];
			
			$allo_c[]="xs=".$sql_row['p_xs'];
			$allo_c[]="s=".$sql_row['p_s'];
			$allo_c[]="m=".$sql_row['p_m'];
			$allo_c[]="l=".$sql_row['p_l'];
			$allo_c[]="xl=".$sql_row['p_xl'];
			$allo_c[]="xxl=".$sql_row['p_xxl'];
			$allo_c[]="xxxl=".$sql_row['p_xxxl'];
			$allo_c[]="s06=".$sql_row['p_s06'];
			$allo_c[]="s08=".$sql_row['p_s08'];
			$allo_c[]="s10=".$sql_row['p_s10'];
			$allo_c[]="s12=".$sql_row['p_s12'];
			$allo_c[]="s14=".$sql_row['p_s14'];
			$allo_c[]="s16=".$sql_row['p_s16'];
			$allo_c[]="s18=".$sql_row['p_s18'];
			$allo_c[]="s20=".$sql_row['p_s20'];
			$allo_c[]="s22=".$sql_row['p_s22'];
			$allo_c[]="s24=".$sql_row['p_s24'];
			$allo_c[]="s26=".$sql_row['p_s26'];
			$allo_c[]="s28=".$sql_row['p_s28'];
			$allo_c[]="s30=".$sql_row['p_s30'];
		}
		
		$sql="update bai_rm_pj1.store_in set allotment_status=1 where tid in (".implode(",",$tid_ref).")";

		//Uncheck this
		mysqli_query($link, $sql) or exit("Sql Error3: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//To update allocated roll details in docket/label reference table.
		for($j=0;$j<sizeof($tid_ref);$j++)
		{
			if($tid_ref[$j]>0)
			{
				if($process_cat==1)
				{
					$sql="insert into bai_rm_pj1.fabric_cad_allocation(doc_no,roll_id,roll_width,doc_type,allocated_qty,status) values(".$doc_ref[$i].",".$tid_ref[$j].",".$width_ref[$j].",'normal',".$issued_ref[$j].",'1')";
				}
				else
				{
					$sql="insert into bai_rm_pj1.fabric_cad_allocation(doc_no,roll_id,roll_width,doc_type,allocated_qty,status) values(".$doc_ref[$i].",".$tid_ref[$j].",".$width_ref[$j].",'recut',".$issued_ref[$j].",'1')";
				}
				
				//Uncheck this
				mysqli_query($link, $sql) or exit("Sql Error4: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				
				//this is for new rolls allocation for remaing qty
				if($val_ref[$j]>$issued_ref[$j]){
					
					//balanced qty
					$balance_qty=(($val_ref[$j])-($issued_ref[$j]));
					//current date in php
					$current_date=date("Y-m-d");

					//getting new rolls details
					$qry_rolldetails="SELECT lot_no,ref1,ref2,ref3,remarks,log_user, status, ref4, ref5, ref6, roll_status, shrinkage_length, shrinkage_width, shrinkage_group, rejection_reason FROM $bai_rm_pj1.store_in WHERE tid=".$tid_ref[$j];
					$result__rolldetials=mysqli_query($link, $qry_rolldetails);
					$row_rolldetials=mysqli_fetch_assoc($result__rolldetials);
					if($is_chw=='yes'){
						$qry_newroll="insert into bai_rm_pj1.store_in(lot_no,ref1,ref2,ref3,qty_rec, date, remarks, log_user, status, ref4, ref5, ref6, roll_status, shrinkage_length, shrinkage_width, shrinkage_group, rejection_reason, split_roll) values('".$row_rolldetials["lot_no"]."','".$row_rolldetials["ref1"]."','".$row_rolldetials["ref2"]."','".$row_rolldetials["ref3"]."','".$balance_qty."','".$current_date."','".$row_rolldetials["remarks"]."','".$row_rolldetials["log_user"]."','".$row_rolldetials["status"]."','".$row_rolldetials["ref4"]."','".$row_rolldetials["ref5"]."','".$row_rolldetials["ref6"]."','".$row_rolldetials["roll_status"]."','".$row_rolldetials["shrinkage_length"]."','".$row_rolldetials["shrinkage_width"]."','".$row_rolldetials["shrinkage_group"]."','".$row_rolldetials["rejection_reason"]."','".$tid_ref[$j]."')";
						mysqli_query($cwh_link, $qry_newroll) or exit("Sql Error3: $qry_newroll".mysqli_error($GLOBALS["___mysqli_ston"]));	
						$last_id= mysqli_insert_id($cwh_link);
						$qry_get_data_fm_cwh = "select * from $bai_rm_pj1.store_in where tid=".$last_id;
						//echo $qry_get_data_fm_cwh."<br/>";
						$res_get_data_fm_cwh = $cwh_link->query($qry_get_data_fm_cwh);
						$barcode_data = array();
						$sticker_data1= array();
						if ($res_get_data_fm_cwh->num_rows == 1) 
						{
							while($row = $res_get_data_fm_cwh->fetch_assoc()) 
							{
								$barcode_data = $row;
								break;
							}
							if(count($barcode_data)>0)
							{
								//$actual_quentity_present = $barcode_data['qty_rec']-$barcode_data['qty_issued']+$barcode_data['qty_ret'];
								$actual_quentity_present = $barcode_data['qty_rec']-$barcode_data['qty_issued'];
								
									
							if($actual_quentity_present>0)
							{
					
						//=================== check rmwh db with present tid ==================
						$qry_check_rm_db = "select * from $bai_rm_pj1.store_in where tid=".$last_id;
						//echo $qry_check_rm_db."<br/>";
						$res_check_rm_db = $link->query($qry_check_rm_db);
						if($res_check_rm_db->num_rows == 0)
						{
							//=============== Insert Data in rmwh ==========================
							$qry_insert_update_rmwh_data = "INSERT INTO $bai_rm_pj1.`store_in`(`tid`,`lot_no`, `qty_rec`, `qty_issued`, `qty_ret`, `date`, `remarks`, `log_stamp`, `status`,`ref2`,`ref3`,`ref4`,`ref5`,`ref6`,`log_user`) VALUES ('".$last_id."','".$barcode_data['lot_no']."','".$actual_quentity_present."','0','0','".date('Y-m-d')."','Directly came from CWH','".date('Y-m-d H:i:s')."','".$barcode_data['status']."','".$barcode_data['ref2']."','".$barcode_data['ref3']."','".$barcode_data['ref4']."','".$barcode_data['ref5']."','".$barcode_data['ref6']."','".$username."-".$plant_name."^".date('Y-m-d H:i:s')."^BEB Manual Interface')";	
							//echo $qry_insert_update_rmwh_data."<br/>";
							$res_insert_update_rmwh_data = $link->query($qry_insert_update_rmwh_data);
							
							$sticker_report = "select * from $bai_rm_pj1.`sticker_report` where lot_no=".$lot_no."";
							//echo $sticker_report."<br/>";
							$res_sticker_report_cwh = $cwh_link->query($sticker_report);
							while($row1 = $res_sticker_report_cwh->fetch_assoc()) 
							{
								$sticker_data = $row1;
								break;
							}
							
							$sticker_report1 = "select * from $bai_rm_pj1.`sticker_report` where lot_no=".$barcode_data['lot_no']."";
							//echo $sticker_report1."<br/>";
							$res_sticker_report_cwh1 = $link->query($sticker_report1);
							while($row12 = $res_sticker_report_cwh1->fetch_assoc()) 
							{
								$sticker_data1 = $row12;
								break;
							}
							//echo "<br/>No of rows:".$row12."<br/>";
							//echo "<br/>result:".count($sticker_data1)."<br/>";
						$qry_get_data_fm_cwh1 = "select * from $bai_rm_pj1.sticker_report  where lot_no=".$barcode_data['lot_no']."";
						//echo $qry_get_data_fm_cwh."<br/>";
						$res_get_data_fm_cwh1 = $link->query($qry_get_data_fm_cwh1);
						 while($row15 = $res_get_data_fm_cwh1->fetch_assoc()) 
							{
								$sticker_data3 = $row15;
								break;
							}
							$qty_rec_store_report1 = "select sum(qty_rec)as qty_rec from $bai_rm_pj1.`store_in` where lot_no=".$lot_no."";
							//echo $qty_rec_store_report1."<br/>";
							$qty_rec_store_report2 = $cwh_link->query($qty_rec_store_report1);
							while($row7 = $qty_rec_store_report2->fetch_assoc()) 
							{
								$rec_qty = $row7;
								break;
							}
							$total=$sticker_data3['rec_qty']-$rec_qty['qty_rec'];
	
							if(count($sticker_data)==0){
								//$total=$sticker_data3['rec_qty']-$rec_qty['qty_rec'];
								$total=$sticker_data3['rec_qty'];
								$sticker_data_query="INSERT INTO $bai_rm_pj1.`sticker_report` (`item`,`item_name`,`item_desc`,`inv_no`,`po_no`,`rec_no`,`lot_no`,`batch_no`,`buyer`,`product_group`,`doe`,`pkg_no`,`grn_date`,`allocated_qty`,`backup_status`,`supplier`,`uom`,`grn_location`,rec_qty) VALUES ('".$sticker_data3['item']."','".$sticker_data3['item_name']."','".$sticker_data3['item_desc']."','".$sticker_data3['inv_no']."','".$sticker_data3['po_no']."','".$sticker_data3['rec_no']."','".$sticker_data3['lot_no']."','".$sticker_data3['batch_no']."','".$sticker_data3['buyer']."','".$sticker_data3['product_group']."','".$sticker_data3['doe']."','".$sticker_data3['pkg_no']."','".$sticker_data3['grn_date']."','".$sticker_data3['allocated_qty']."','".$sticker_data3['backup_status']."','".$sticker_data3['supplier']."','".$sticker_data3['uom']."','".$sticker_data3['grn_location']."','".$total."')";
								$sticker_data_result = $cwh_link->query($sticker_data_query);
							
							}
							if(count($sticker_data1)==0)
							{
								$qry_insert_sticker_report_data = "INSERT INTO $bai_rm_pj1.`sticker_report` (`item`,`item_name`,`item_desc`,`inv_no`,`po_no`,`rec_no`,`lot_no`,`batch_no`,`buyer`,`product_group`,`doe`,`pkg_no`,`grn_date`,`allocated_qty`,`backup_status`,`supplier`,`uom`,`grn_location`) VALUES ('".$sticker_data['item']."','".$sticker_data['item_name']."','".$sticker_data['item_desc']."','".$sticker_data['inv_no']."','".$sticker_data['po_no']."','".$sticker_data['rec_no']."','".$sticker_data['lot_no']."','".$sticker_data['batch_no']."','".$sticker_data['buyer']."','".$sticker_data['product_group']."','".$sticker_data['doe']."','".$sticker_data['pkg_no']."','".$sticker_data['grn_date']."','".$sticker_data['allocated_qty']."','".$sticker_data['backup_status']."','".$sticker_data['supplier']."','".$sticker_data['uom']."','".$sticker_data['grn_location']."')";
								//echo $qry_insert_sticker_report_data."<br/>";
								$qry_insert_sticker_report_data1 = $link->query($qry_insert_sticker_report_data);
							}
							
							$qty_rec_store_report = "select sum(qty_rec)as qty_rec from $bai_rm_pj1.`store_in` where lot_no=".$barcode_data['lot_no']."";
							//echo $qty_rec_store_report."<br/>";
							$qty_rec_store_report1 = $link->query($qty_rec_store_report);
							while($row2 = $qty_rec_store_report1->fetch_assoc()) 
							{
								$rec_qty = $row2;
								break;
							}
							
							$qry_insert_sticker_report1_data = "update $bai_rm_pj1.`sticker_report` set rec_qty=\"".$rec_qty['qty_rec']."\",rec_no=\"".$sticker_data['rec_no']."\",inv_no=\"".$sticker_data['inv_no']."\",batch_no=\"".$sticker_data['batch_no']."\" where lot_no=\"".$sticker_data['lot_no']."\"";
							//echo $qry_insert_sticker_report1_data."<br/>";
							
							$qry_insert_sticker_report1_data1 = $link->query($qry_insert_sticker_report1_data);
							
						}
						else
						{
							//=============== Update Data in rmwh ==========================
							$qry_insert_update_rmwh_data = "update $bai_rm_pj1.store_in set qty_rec=qty_rec+".$actual_quentity_present." where tid=".$last_id;
							//echo $qry_insert_update_rmwh_data."<br/>";
							$res_insert_update_rmwh_data = $link->query($qry_insert_update_rmwh_data);
							//echo "<h3>Status: <font color=orange>already updated</font> $_POST['barcode']</h3>";
							
							$sticker_report = "select * from $bai_rm_pj1.`sticker_report` where lot_no=".$barcode_data['lot_no']."";
							//echo $sticker_report."<br/>";
							$res_sticker_report_cwh = $cwh_link->query($sticker_report);
							while($row1 = $res_sticker_report_cwh->fetch_assoc()) 
							{
								$sticker_data = $row1;
								break;
							}
							
							$sticker_report1 = "select * from $bai_rm_pj1.`sticker_report` where lot_no=".$barcode_data['lot_no']."";
							//echo $sticker_report1."<br/>";
							$res_sticker_report_cwh1 = $link->query($sticker_report1);
							while($row12 = $res_sticker_report_cwh1->fetch_assoc()) 
							{
								$sticker_data1 = $row12;
								break;
							}
							
							// if(count($sticker_data1)==0)
							// {
							// 	$qry_insert_sticker_report_data = "INSERT INTO $bai_rm_pj1.`sticker_report` (`item`,`item_name`,`item_desc`,`inv_no`,`po_no`,`rec_no`,`rec_qty`,`lot_no`,`batch_no`,`buyer`,`product_group`,`doe`,`pkg_no`,`grn_date`,`allocated_qty`,	`backup_status`,`supplier`,`uom`,`grn_location`) VALUES ('".$sticker_data['item']."','".$sticker_data['item_name']."','".$sticker_data['item_desc']."','".$sticker_data['inv_no']."','".$sticker_data['po_no']."','".$sticker_data['rec_no']."','".$sticker_data['lot_no']."','".$sticker_data['batch_no']."','".$sticker_data['buyer']."','".$sticker_data['product_group']."','".$sticker_data['doe']."','".$sticker_data['pkg_no']."','".$sticker_data['grn_date']."','".$sticker_data['allocated_qty']."','".$sticker_data['backup_status']."','".$sticker_data['supplier']."','".$sticker_data['uom']."','".$sticker_data['grn_location']."')";
							// 	//echo $qry_insert_sticker_report_data."<br/>";
							// 	$qry_insert_sticker_report_data1 = $link->query($qry_insert_sticker_report_data);
							// }
							
							$qty_rec_store_report = "select sum(qty_rec)as qty_rec from $bai_rm_pj1.`store_in` where lot_no=".$barcode_data['lot_no']."";
							//echo $qty_rec_store_report."<br/>";
							$qty_rec_store_report1 = $link->query($qty_rec_store_report);
							while($row2 = $qty_rec_store_report1->fetch_assoc()) 
							{
								$rec_qty = $row2;
								break;
							}
							
							
							$qry_insert_sticker_report1_data = "update $bai_rm_pj1.`sticker_report` set rec_qty=\"".$rec_qty['qty_rec']."\",rec_no=\"".$sticker_data['rec_no']."\",inv_no=\"".$sticker_data['inv_no']."\",batch_no=\"".$sticker_data['batch_no']."\" where lot_no=\"".$sticker_data['lot_no']."\"";
							//echo $qry_insert_sticker_report1_data."<br/>";
							$qry_insert_sticker_report1_data1 = $link->query($qry_insert_sticker_report1_data);	
						}
												
						$qry_ins_stockout = "INSERT INTO $bai_rm_pj1.`store_out`(tran_tid,qty_issued,date,updated_by) VALUES (".$last_id.",".$actual_quentity_present.",'".date('Y-m-d')."','".$username."-".$plant_name."^BEB Manual Interface')";
						//echo $qry_ins_stockout."<br/>";
						$res_ins_stockout = $cwh_link->query($qry_ins_stockout);
						
						$update_qty_store_in = "update $bai_rm_pj1.store_in set qty_ret=0,qty_issued=qty_issued+".$actual_quentity_present." where tid=".$last_id;
						//echo $update_qty_store_in."<br/>";
						$res_update_qty_store_in = $cwh_link->query($update_qty_store_in);
						//echo "<h3>Status: <font color=Green>Quantity ".$actual_quentity_present." Transferred successfully for Item ID : ".$last_id." and Lot Number : ".$barcode_data['lot_no']."</font></h3>";
						//=====================================================================
					
				}
				
			}
			
		} 
					}
					else{
					$qry_newroll="insert into bai_rm_pj1.store_in(lot_no,ref1,ref2,ref3,qty_rec, date, remarks, log_user, status, ref4, ref5, ref6, roll_status, shrinkage_length, shrinkage_width, shrinkage_group, rejection_reason, split_roll) values('".$row_rolldetials["lot_no"]."','".$row_rolldetials["ref1"]."','".$row_rolldetials["ref2"]."','".$row_rolldetials["ref3"]."','".$balance_qty."','".$current_date."','".$row_rolldetials["remarks"]."','".$row_rolldetials["log_user"]."','".$row_rolldetials["status"]."','".$row_rolldetials["ref4"]."','".$row_rolldetials["ref5"]."','".$row_rolldetials["ref6"]."','".$row_rolldetials["roll_status"]."','".$row_rolldetials["shrinkage_length"]."','".$row_rolldetials["shrinkage_width"]."','".$row_rolldetials["shrinkage_group"]."','".$row_rolldetials["rejection_reason"]."','".$tid_ref[$j]."')";
					mysqli_query($link, $qry_newroll) or exit("Sql Error3: $qry_newroll".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}

				//To update Allocated Qty
				$sql="update bai_rm_pj1.store_in set qty_allocated=qty_allocated+".$issued_ref[$j]." where tid=".$tid_ref[$j];

				// $sql="update bai_rm_pj1.store_in set qty_rec=".$issued_ref[$j].",qty_allocated=qty_allocated+".$issued_ref[$j]." where tid=".$tid_ref[$j];
				//Uncheck this
				mysqli_query($link, $sql) or exit("Sql Error3: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		
		
		//To confirm docket as allocated
		if($process_cat==1)
		{
			$sql1="update plandoc_stat_log set plan_lot_ref=\"".$lot_db[$i]."\" where doc_no=\"".$doc_ref[$i]."\"";
		}
		else
		{
			$sql1="update recut_v2 set plan_lot_ref=\"".$lot_db[$i]."\" where doc_no=\"".$doc_ref[$i]."\"";
		}
		
		mysqli_query($link, $sql1) or exit("Sql Error5: $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//TO update Marker Matrix
		if($process_cat==1)
		{
			//Search Valid Marker is available or not
			//New version to verify style/ratio/pattern/width based algorith to identify new marker length
			
			$sql="select marker_length from $bai_pro3.marker_ref_matrix_view where strip_match='$strip_match' and gmtway='$gmtway' and style_code='$style_code' and buyer_code='$buyer_code' and lower(pat_ver)='".strtolower($mk_ver)."' and SUBSTRING_INDEX(marker_width,'.',1)='".$min_width[$i]."' and category='$category' and ".implode(" and ",$allo_c);
			//echo $sql."<br/>";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error1x: $sql ".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$mk_length=$sql_row['marker_length'];
			}
			
			if(mysqli_num_rows($sql_result)!=0)
			{
				$sql="insert into bai_pro3.maker_stat_log(DATE,cat_ref,cuttable_ref,allocate_ref,order_tid,mklength,mkeff,lastup,remarks,mk_ver) select DATE,cat_ref,cuttable_ref,allocate_ref,order_tid,mklength,mkeff,lastup,remarks,mk_ver from $bai_pro3.maker_stat_log where tid='$mk_ref'";
				//echo $sql."<br/>";
				
				mysqli_query($link, $sql) or exit("Sql Error1x: $sql ".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$ilast_id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
				
				$sql="update bai_pro3.maker_stat_log set mklength=$mk_length where tid='$ilast_id'";
				
				mysqli_query($link, $sql) or exit("Sql Error1x: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql="update bai_pro3.plandoc_stat_log set lastup=\"".date("Y-m-d")."\", mk_ref=$ilast_id where doc_no=".$doc[$i];
				
				mysqli_query($link, $sql) or exit("Sql Error: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
				
			}
			
			//Search Valid Marker is available or not
		}
			
		}
		
	}
	
	//Exit Code
	
	echo "<h2>Successfully Updated.</h2>";
	//this is for after allocating article redirect to cps dashboard.removed sfcsui
	$php_self = explode('/',$_SERVER['PHP_SELF']);
	array_pop($php_self);
	$url_r = base64_encode(implode('/',$php_self)."/fab_priority_dashboard.php");
	$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index.php?r=".$url_r;
	echo"<script>swal('Successfully Updated.','','success')</script>";
	echo"<script>location.href = '".$url."';</script>"; 

	// if($process_cat==1)
	// {
	// 	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"fab_pop_details.php?doc_no=".$doc_ref[0]."\"; }</script>";
	// }
	// else
	// {
	// 	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"fab_pop_details_recut_v2.php?doc_no=".$doc_ref[0]."\"; }</script>";
	// }	
}

?>


<?php

if(isset($_POST['allocate']))
{
	echo "<form name='input' method='post' action='fab_pop_allocate_v5.php' onkeypress='return event.keyCode != 13'>";
	$doc=$_POST['doc'];
	//$lot_db_2 = $_POST["pms$doc[0]"];
	//var_dump($doc);
	// echo "DOC : ".sizeof($doc);exit;
	$doc_cat=$_POST['doc_cat'];
	$doc_com=$_POST['doc_com'];
	$doc_mer=$_POST['doc_mer'];
	$cat_ref=$_POST['cat_ref'];
	
	$process_cat=$_POST['process_cat'];
	$style_ref=$_POST['style_ref'];
	$size_doc=sizeof($doc);
	$note="";
	echo "<input type='hidden' id='size_doc' value=\"$size_doc\"></>";
	for($i=0;$i<sizeof($doc);$i++)
	{
		$lot=$doc[$i];
		$doc_ref=$doc[$i];
		$mat_req=$doc_mer[$i];
		
		if(isset($_POST["manual".$doc[$i]])){
			$temp=$_POST["manual".$doc[$i]];
			$manual_lot=$temp;
		}
		if(isset($_POST["pms".$doc[$i]])){
			$temp=$_POST["pms".$doc[$i]];
			$pms_lot=array();
		}

		if(strlen($temp)>0)
		{
			$pms_lot=explode(",",$temp);
		}
			
		
		$lot_ref="";
		
		unset($lot_db);
		unset($lot_db_2);
		
		$lot_db=array();
		$lot_db_2=array(); //For extracking Filtered Data
		
		if(sizeof($pms_lot)>0)
		{
			for($x=0;$x<sizeof($pms_lot);$x++)
			{
				if(strlen($pms_lot[$x])>0)
				{
					$lot_db[]="'".trim($pms_lot[$x])."'";
					$lot_db_2[]="'".trim(current(explode(">",trim($pms_lot[$x]))))."'";
					
					if(strpos(strtolower($pms_lot[$x]),"stock"))
					{
						$lot_db_2[]=0;
					}
				}
			}
		}
		
		if(sizeof($manual_lot)>0)
		{
			for($x=0;$x<sizeof($manual_lot);$x++)
			{
				if(strlen($manual_lot[$x])>0)
				{
					$lot_db[]="'".$manual_lot[$x]."'";
					$lot_db_2[]="'".trim(current(explode(">",$manual_lot[$x])))."'";
					
					if(strpos(strtolower($manual_lot[$x]),"stock"))
					{
						$lot_db_2[]=0;
					}
				}
			}
		}
		
		if(sizeof($lot)>0)
		{
			for($x=0;$x<sizeof($lot);$x++)
			{
				if(strlen($lot[$x])>0)
				{
					$lot_db[]="'".$lot[$x]."'";
					$lot_db_2[]="'".trim(current(explode(">",$lot[$x])))."'";
					
					if(strpos(strtolower($lot[$x]),"stock"))
					{
						$lot_db_2[]=0;
					}
				}
			}
		}
		$sql = "SELECT SUM(purwidth) AS pur_width FROM bai_pro3.cat_stat_log WHERE compo_no='".$doc_com[$i]."'";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error 13 :$sql ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$pur_width =round($sql_row['pur_width'],2);
		}
		//Table to show all list of available items
		if(sizeof($lot_db_2)>0)
		{
		
		echo "<input type=\"hidden\" name=\"doc_ref[$i]\" value=\"".$doc_ref."\">";
		echo "<input type=\"hidden\" name=\"process_cat\" value=\"".$process_cat."\">";
		echo "<input type=\"hidden\" name=\"mat_req[$i]\" value=\"".$mat_req."\">";
		echo "<input type=\"hidden\" name=\"lot_db[$i]\" value=\"".implode(";",$lot_db)."\">";
		echo "<input type=\"hidden\" name=\"min_width[$i]\" value=\"\">";
		
		echo "<h3><font color=blue>".$doc_cat[$i]."-".$doc_com[$i]." /width: ".$pur_width."</font></h3>";
		
		//To show stats
		echo "<h4>Required: ".round($mat_req,2)." / Allocated: <span id=\"alloc$doc_ref\"></span> / Balance to Allocate: <span id=\"balal$doc_ref\">".round($mat_req,2)."</span></h4>";
		echo "<div class='table-responsive'><table id='example".$i."' class='table table-bordered' cellspacing='0'>";
		
		echo "<thead><tr id=\"$doc_ref\" bgcolor=\"RED\">";
		echo "<th>Invoice No</th>";	
		echo "<th>GRN Date</th>";	
		echo "<th>Batch No</th>";	
		echo "<th id='col1'>Item Code</th>";	
		echo "<th id='col2'>Lot No</th>";	
		echo "<th>Shade</th>";
		echo "<th id='col'>Shrinkage<br/>Group</th>";
		echo "<th id='col'>Shrinkage<br/>Width</th>";	
		echo "<th id='col'>Shrinkage<br/>Length</th>";
		echo "<th>Roll No</th>";	
		echo "<th id='col'>Location</th>";	
		echo "<th>Group</th>";	
		echo "<th>Tkt<br/>Width</th>";	
		echo "<th>Ctx Width</th>";	
		echo "<th>Tkt<br/></th>";	
		echo "<th>Ctx<br/>Length</th>";		
		// echo "<th id='col'>Allocated</th>";
		echo "<th>Issued Qty</th>";
		echo "<th>Select</th>";
		//echo "<th>Allocated Qnty</th>";
		echo "</tr></thead><tbody>";
		
		


		//Current Version
		$sql="select * from $bai_rm_pj1.fabric_status_v3 where lot_no in (".implode(",",$lot_db_2).") AND allotment_status='0' order by shade";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error12: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
		$row_count=mysqli_num_rows($sql_result);
		$j=0;
		
		$inv_no=0;
		$bg_color="#99CCFF";
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			if(strcmp($inv_no,trim($sql_row['inv_no'])))
			{
				if($bg_color=="#99CCFF")
				{
					$bg_color="white";
					$inv_no=trim($sql_row['inv_no']);
				}
				else
				{
					$bg_color="#99CCFF";
					$inv_no=trim($sql_row['inv_no']);
				}
			}
			
			
			$temp_var='';
			if($sql_row['allotment_status']==0 and strlen($sql_row['shade'])>0)
			{
				$temp_var.="<td><input type=\"checkbox\" id=\"chk$doc_ref$j\" name=\"chk".$doc_ref."[]\" value=\"".$j."\" onclick=\"check_qty2(".sizeof($doc).",'chk$doc_ref$j','$bg_color','$doc_ref')\">";
				$temp_var.="<input type=\"hidden\" name=\"val".$doc_ref."[$j]\" value=\"".$sql_row['balance']."\">";
				$temp_var.="<input type=\"hidden\" name=\"width".$doc_ref."[$j]\" value=\"".$sql_row['width']."\">";
				$temp_var.="<input type=\"hidden\" name=\"lable".$doc_ref."[$j]\" value=\"".$sql_row['tid']."\">";
				$temp_var.="<input type=\"hidden\" name=\"issued_new".$doc_ref."[$j]\" id=\"issued_new".$doc_ref."[$j]\">";
				$temp_var.="</td>";
				
			}
			else
			{
				$temp_var.="<td>";
				
				$sql1="select max(log_time),doc_type,doc_no from $bai_rm_pj1.fabric_cad_allocation where roll_id=".$sql_row['tid'];
				// $temp_var.="</br>Qry : ".$sql1."</br>";
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error13: $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1=mysqli_fetch_array($sql_result1))
				{
					$tag=" ";
					if($sql_row1['doc_type']=="normal")
					{
						$tag="D".$sql_row1['doc_no'];
						
					}
					else
					{
						// $temp_var.='doc r';
						$tag="R".$sql_row1['doc_no'];
					}
					$valid_check="display:none";
				}

				if(strlen($sql_row['shade'])==0)
				{
					$tag="Insp. <br/>Pending";
					$valid_check="display:none";
				}
				// $temp_var.=$tag.'---<br/>';
				//To release for some time
				$temp_var.="<input style='$valid_check' type=\"checkbox\" id=\"chk$doc_ref$j\" name=\"chk".$doc_ref."[]\" value=\"".$j."\" onclick=\"check_qty2(".sizeof($doc).",'chk$doc_ref$j','$bg_color','$doc_ref')\">";
				//$temp_var.="<input type=\"hidden\" id=\"chk$doc_ref$j\" name=\"chk".$doc1_ref."[]\" value=\"0\" onclick=\"check_qty2(".sizeof($doc).",'chk$doc_ref$j','$bg_color')\">";
				$temp_var.="<input type=\"hidden\" name=\"val".$doc_ref."[$j]\" value=\"".$sql_row['balance']."\">";
				$temp_var.="<input type=\"hidden\" name=\"width".$doc_ref."[$j]\" value=\"".$sql_row['width']."\">";
				$temp_var.="<input type=\"hidden\" name=\"lable".$doc_ref."[$j]\" value=\"".$sql_row['tid']."\">";
				$temp_var.="<input type=\"hidden\" name=\"issued_new".$doc_ref."[$j]\" id=\"issued_new".$doc_ref."[$j]\">";
				
				if(strlen($tag)>0)
				{
					$temp_var.="<img src=\"lock.png\"> $tag";
				}
				$temp_var.="</td>";
				
			}
			$result='Insp.';
			// if($result == substr($tag, 0, 5)) 
			{
			echo "<input type='hidden' id='srgp$doc_ref$j' value='".$sql_row['shrinkage_group']."'>";
			echo "<tr bgcolor=\"$bg_color\" id=\"trchk$doc_ref$j\">";
			$sql3="select tid,split_roll from $bai_rm_pj1.store_in where tid=".$sql_row['tid'];
			$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error22 :$sql ".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result3)>0)
			{
				while($sql_row2=mysqli_fetch_array($sql_result3))
				{
					if($sql_row2['split_roll'] != '') {
						echo "<td><center><a data-toggle='modal' id='btn$doc_ref$j' data-target='#modalbtn$doc_ref$j' class='label label-warning label-lg'>".$sql_row['inv_no']."(Splitted Roll)</a></center></td>";
					} else {
						echo "<td>".$sql_row['inv_no']."</td>";
					}
				}
			}
			
			
			/* Added new code to track allocated quantities 20140621*/
			
			$sql1="SELECT GROUP_CONCAT(CONCAT(IF(doc_type='normal','D','R'),doc_no)) AS doc_nos,ROUND(SUM(allocated_qty),2) AS allocated_qty FROM $bai_rm_pj1.fabric_cad_allocation WHERE roll_id=".$sql_row['tid']." AND bai_rm_pj1.fn_roll_id_fab_scan_status(doc_no,doc_type,roll_id)=0";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error13: $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				
					$tag=$sql_row1['doc_nos'];
					$allocated_qty=$sql_row1['allocated_qty'];
			}
			echo "<td>".$sql_row['grn_date']."</td>";
			echo "<td>".$sql_row['batch_no']."</td>";
			echo "<td id='col1'>".$sql_row['item']."</td>";
			echo "<td id='col1'>".$sql_row['lot_no']."</td>";
			echo "<td>".$sql_row['shade']."</td>";
			echo "<td>".$sql_row['shrinkage_group']."</td>";
			echo "<td>".$sql_row['shrinkage_width']."</td>";
			echo "<td>".$sql_row['shrinkage_length']."</td>";
			echo "<td>".$sql_row['ref2']."</td>";
			echo "<td>".$sql_row['ref1']."</td>";
			echo "<td>".$sql_row['shade']."</td>";
			echo "<td>".$sql_row['ref6']."</td>";
			echo "<td>".$sql_row['ref3']."</td>";
			echo "<td>".$sql_row['qty_rec']."</td>";
			echo "<td>".$sql_row['ref5']."</td>";
			// echo "<td>".$allocated_qty."</td>";
			echo "<td><span id=\"issued".$doc_ref."[$j]\"></span></td>";
			
			//echo "</br>Allotment Status".$sql_row['allotment_status']."</br>";

			echo $temp_var;			
			echo "</tr>";
		}
			$tid = $sql_row['tid'];
			$n = 1; 
			$modaldisplay.="<div id='modalbtn".$doc_ref.$j."' class='modal fade' role='dialog'>
				<div class='modal-dialog'>
			
				<!-- Modal content-->
				<div class='modal-content'>
					<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal'>&times;</button>
					<h4 class='modal-title'> Roll Splitted From :</h4>
					</div>
					<div class='modal-body'>
					<div class='table-responsive'>
					<table class='table'>
					<tr style=''background-color:'#337ab7'>
					<th style='color:black;'>Invoice<br/>No</th>
					<th style='color:black;'>GRN Date</th>
					<th style='color:black;'>Batch<br/>No</th>
					<th style='color:black;'>Item Code</th>
					<th style='color:black;'>Lot No</th>
					<th style='color:black;'>Shade</th>
					<th style='color:black;'>Shrinkage<br/>Group</th>
					<th style='color:black;'>Shrinkage<br/>Width</th>
					<th style='color:black;'>Shrinkage<br/>Length</th>
					<th style='color:black;'>Roll<br/>No</th>
					<th style='color:black;'>Location</th>
					<th style='color:black;'>Group</th>
					<th style='color:black;'>Tkt<br/>Width</th>
					<th style='color:black;'>Ctx<br/>Width</th>
					<th style='color:black;'>Tkt<br/>Length</th>
					<th style='color:black;'>Ctx<br/>Length</th>	
					<th style='color:black;'>Issued<br/>Qty</th>
					</tr>";
			for($m=0; $m < $n; $m++) {
				$sql3="select tid,split_roll from $bai_rm_pj1.store_in where tid=".$tid;
				$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error22 :$sql ".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_result3)>0)
				{
					while($sql_row2=mysqli_fetch_array($sql_result3))
					{
						$tid =$sql_row2['split_roll'];
						if($sql_row2['split_roll'] != '') {
							$sql_query ="SELECT * FROM bai_rm_pj1.fabric_status_v3 WHERE lot_no IN (SELECT lot_no FROM bai_rm_pj1.store_in WHERE tid IN (".$sql_row2['split_roll'].")) AND tid IN(".$sql_row['tid'].")";
							$sql_result_new=mysqli_query($link, $sql_query) or exit("Sql Error22 :$sql ".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_result_new=mysqli_fetch_array($sql_result_new))
								{
									$tid =$sql_row2['split_roll'];
									$modaldisplay.="<tr>
										<td>".$sql_result_new['inv_no']."</td>
										<td>".$sql_result_new['grn_date']."</td>
										<td>".$sql_result_new['batch_no']."</td>
										<td>".$sql_result_new['item']."</td>
										<td>".$sql_result_new['lot_no']."</td>
										<td>".$sql_result_new['shade']."</td>
										<td>".$sql_result_new['shrinkage_group']."</td>
										<td>".$sql_result_new['shrinkage_width']."</td>
										<td>".$sql_result_new['shrinkage_length']."</td>
										<td>".$sql_result_new['ref2']."</td>
										<td>".$sql_result_new['ref1']."</td>
										<td>".$sql_result_new['shade']."</td>
										<td>".$sql_result_new['ref6']."</td>
										<td>".$sql_result_new['ref3']."</td>
										<td>".$sql_result_new['qty_rec']."</td>
										<td>".$sql_result_new['ref5']."</td>
										<td><span id=\"issued".$doc_ref."[$j]\"></span></td>
										</tr>";
										
								}
						}
					}
				}
				
				}
				$modaldisplay.="</table>
				</div>
					</div>
					<div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
					</div>
				</div>
			
				</div>
				</div>";
			$j++;
		}
		echo "</tbody></table></div>";
		echo $modaldisplay;
		}//Allow only for selected lots/docs
		
		//Table to show all list of available items
		echo "<input type='hidden' value='$doc_ref' id='doc_chk'><br/>";
	}
	//OK echo "Validate: <input type=\"checkbox\" name=\"validate\" onclick=\"check_qty(".sizeof($doc).")\">";
	//OK echo "Validate: <input type=\"checkbox\" name=\"validate\">";
	if ($row_count == '') {
		echo "<input type=\"submit\" id=\"allocate_new\" name=\"allocate_new\" value=\"Allocate\" onclick=\"button_disable()\" class='btn btn-success'>";
	}
	else {
		echo "<input type=\"submit\" id=\"allocate_new\" name=\"allocate_new\" value=\"Allocate\" onclick=\"button_disable()\" class='btn btn-success'>";
	}
	// echo '<div id="process_message"><h2><font color="red">Please wait while updating data!!!</font><br/><font color="blue">After update, this window will close automatically!</font></h2></div>';
	
	echo "</form>";
}
?>
</div>
<script>
	document.getElementById("msg").style.display="none";	
	// $(document).ready(function() {
	// 	// Setup - add a text input to each footer cell
	// 	$('#example1 th').each( function (i) {
	// 		var title = $('#example thead th').eq( $(this).index() ).text();
	// 		$(this).html( '<input type="text" placeholder="'+title+'" data-index="'+i+'" />');
	// 	} );
	// 		var table = $('.stripe').dataTable( {
	// 			//scrollY:        "300px",
	// 			"bPaginate": false,
	// 			//scrollX:        true,
	// 			scrollCollapse: true,
	// 			paging:         false,
	// 			fixedColumns:   true
	// 		} );
	// 	// DataTable
	// 	var table = $('#example1').dataTable( {
	// 		scrollY:        "300px",
	// 		"bPaginate": false,
	// 		scrollX:        true,
	// 		scrollCollapse: true,
	// 		paging:         false,
	// 		fixedColumns:   true
	// 	} );

	// 	// Filter event handler
	// 	$( table.table().container() ).on( 'keyup', 'thead input', function () {
	// 		table
	// 			.column( $(this).data('index') )
	// 			.search( this.value )
	// 			.draw();
	// 	} );
	// } );
</script>
<style>
th{
	text-align:center;
}
   /* th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 2000px;
        margin: 0 auto;
    }
 
    th input {
        width: 90%;
    } */
	/* table{
		table-layout:fixed;
	} */
	/* th{
		white-space:pre-wrap;
	}
	td{
		white-space:pre-wrap;
		/* word-wrap:break-word */
	/* } 
	#col {
		padding :5px;
	}
	#col1 {
		width:8%;
		padding :0px;
	}
	#col2 {
		width:5%;
		padding :0px;
	} */
	.btn-primary{
		background-color:#337ab7;
		color:white;
		font-weight:bold;
		padding:4px;
		text-decoration:none;
	}
	.btn-success{
		background-color:#5cb85c;
		color:white;
		font-weight:bold;
		padding:4px;
		text-decoration:none;
		borde: 1 px solid #5cb85c;
	}
	h4{
		background-color:#f4a82e;
		width:36%;
		color:white;
		padding:2pt;
		font-size:14px;
	}
	

	#reset_example{
		width : 80px;
		color : #fff;
		margin : 10px;
	}
	.flt{
		width:100%;
	}
</style>

</body>
</html>
	<script language="javascript" type="text/javascript">
	
	// var MyTableFilter = 
	// 		{  
	// 			exact_match: false,
	// 			alternate_rows: true,
	// 			sort_select: true,
	// 			loader_text: "Filtering data...",
	// 			loader: true,
	// 			// display_all_text: "Show All",
	// 			// onchange:true,
	// 			// btn: true,
	// 			// enter_key: false,
	// 			on_change: false,
	// 			btn: true,
	// 			enter_key: false,
	// 			// col_20:false,
	// 			// public_methods: true
	// 			col_18:false,
	// 			rows_counter: true,
	// 			rows_counter_text: "Total rows: ",
	// 			btn_reset: true,
	// 			bnt_reset_text: "Clear all ",
				
	// 		};


	// 		var i;
	// 		var len=document.getElementById('size_doc').value;
	// 		for (i = 0; i <=len; i++) { 
	// 			setFilterGrid( 'example'+i, MyTableFilter );
	// 		}
	// 		$(document).ready(function(){
	// 			var len=document.getElementById('size_doc').value;
	// 			$('.loader').hide();
	// 				var i;
	// 				var len=document.getElementById('size_doc').value;
	// 				for (i = 0; i <=len; i++) { 
	// 				$('#reset_example'+i).addClass('btn btn-warning btn-xs');
	// 				$('#btn18_example'+i).addClass('btn btn-success btn-xs');
	// 				$('#reset_example'+i).click(function(){ 
	// 					// document.getElementById('btn19_example0').value = "GO";
	// 					// document.getElementById('btn19_example1').value = "GO";
	// 					// document.getElementById('btn19_example2').value = "GO";
	// 				});
	// 				$("#btn18_example"+i).before('<label>Go</label><br>');
	// 				$("#btn18_example"+i).val('');
					
	// 				}
				
					
	// 		});
			// var i;
			// var len=document.getElementById('size_doc').value;
			// for (i = 0; i <=len; i++) {
			// 	var tf = new TableFilter(document.querySelector('#example'+i));
			// 	tf.init();
			// 	$('#flt17_example'+i).hide();
			// }
			var filtersConfig = {
				exact_match: false,
				alternate_rows: true,
				sort_select: true,
				loader_text: "Filtering data...",
				loader: true,
				// col_17:false,
				rows_counter: true,
				rows_counter_text: "Total rows: ",
				btn_reset: true,
			};
			var i;
			var len=document.getElementById('size_doc').value;
			for (i = 0; i <=len; i++) {
				var tf = new TableFilter(document.querySelector('#example'+i), filtersConfig);
				tf.init();
				$('.helpCont').hide();
				$('.helpBtn').hide();
				$('.reset').val('reset');
				$('.reset').addClass('btn btn-warning btn-xs');
				$('#flt17_example'+i).hide();
			}
		
	</script>
	<!-- <script>
	$(document).ready( function () {
    $('#example0').DataTable();
} );
	</script> -->
<script src="../../../../common/js/bootstrap1.min.js"></script>

<!-- <script src="../../../../common/js/jquery.dataTables.min.js"></script> -->

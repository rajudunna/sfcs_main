<!--

Ticket #: 252392-Kirang/2014-02-07
This amendement was done based on the confirmation to issue excess (1%) material depending on the savings.

-->

<!--
Core Module:In this interface we can update the fabric allocatio details.

Description:In this interface we can update the fabric allocatio details.

Changes Log:
-->

<!--

Ticket #: #684040-RameshK/2014-05-26 : To raise compalint for rejected RM material

-->

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=11; IE=10;IE=9; IE=8; IE=7; IE=EDGE" />



		<style>
		.dataTables_filter {
		display: none; 
		}

		body
		{
			font-family: Trebuchet MS;
			font-size: 14px;
		}

		table
		{
		border-collapse:collapse;
		white-space:nowrap;
		tr.total
		{
		font-weight: bold;
		white-space:nowrap; 
		}

		table
		{
		border-collapse:collapse;
		white-space:nowrap;
		font-size: 12pt; 
		}
		}

		th
		{
			color: WHITE;
		border: 1px solid #660000;
			padding: 10px;
		white-space:nowrap; 

		}

		td
		{
			
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

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.2.4/js/dataTables.fixedColumns.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.2.4/css/fixedColumns.dataTables.min.css">
<link rel="stylesheet" href="../../../../common/css/bootstrap.css">

<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/sweetalert.min.js',4,'R'); ?>"></script>
<script>
/* 	$(document).ready(function() {
		$('#example').DataTable( {
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			]
		} );
	} ); */

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


function check_qty2(x,m,n)
{	
	// alert(x+m+n);
	if(document.getElementById(m).checked)
	{
		var xx="tr"+m;
		document.getElementById(xx).style.backgroundColor = "#99CCFF";
	}
	else
	{
		var xx="tr"+m;
		document.getElementById(xx).style.backgroundColor = n;
	}
	
	var check=0;
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
					
					if(selc<mat_req){
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
					console.log('test');
					console.log(widt+"<="+parseFloat((document.input["width"+doc_ref+"["+j+"]"].value))+" J = "+j);
				}
			}else{
					document.getElementById("issued"+doc_ref+"["+j+"]").innerHTML="0";
				}

		}
		
		if(selc<mat_req)
		{
			check=0;
			document.getElementById(doc_ref).style.backgroundColor = "RED";
			//OK document.getElementById('validate').style.visibility="";
			//OK document.getElementById('allocate_new').style.visibility="hidden";
			
			//To show stats
			document.getElementById('alloc'+doc_ref).innerHTML=parseFloat(alloc_qty.toFixed(2));
			document.getElementById('balal'+doc_ref).innerHTML=parseFloat((mat_req-selc).toFixed(2));
			//break;
		}
		else
		{
			check=1;
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
	<div class="panel-heading"><b>Fabric Allocation Panel</b></div>
		<div class="panel-body">
			
<?php
//Auto Selecting Based on Manual Decision.

/*list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2);
$authorized=array("kirang","herambaj","kishorek","sarojiniv","ravipu","ramanav","sekhark","lovakumarig","ganeshb","pithanic");
if(!(in_array(strtolower($username),$authorized)))
{
	header("Location:restrict.php");
}*/

echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color=\"red\">Please wait while preparing data...</font></h1></center></div>";
	
	ob_end_flush();
	flush();
	usleep(10);

?>

<?php
set_time_limit(2000);
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
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
		
		$sql="update $bai_rm_pj1.store_in set allotment_status=1 where tid in (".implode(",",$tid_ref).")";
		//echo $sql."<br/>";
		
		mysqli_query($link, $sql) or exit("Sql Error3: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//To update allocated roll details in docket/label reference table.
		for($j=0;$j<sizeof($tid_ref);$j++)
		{
			if($tid_ref[$j]>0)
			{
				if($process_cat==1)
				{
					$sql="insert into $bai_rm_pj1.fabric_cad_allocation(doc_no,roll_id,roll_width,doc_type,allocated_qty,status) values(".$doc_ref[$i].",".$tid_ref[$j].",".$width_ref[$j].",'normal',".$issued_ref[$j].",'1')";
				}
				else
				{
					$sql="insert into $bai_rm_pj1.fabric_cad_allocation(doc_no,roll_id,roll_width,doc_type,allocated_qty,status) values(".$doc_ref[$i].",".$tid_ref[$j].",".$width_ref[$j].",'recut',".$issued_ref[$j].",'1')";
				}
				
				
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
					
					$qry_newroll="insert into $bai_rm_pj1.store_in(lot_no,ref1,ref2,ref3,qty_rec, date, remarks, log_user, status, ref4, ref5, ref6, roll_status, shrinkage_length, shrinkage_width, shrinkage_group, rejection_reason, split_roll) values('".$row_rolldetials["lot_no"]."','".$row_rolldetials["ref1"]."','".$row_rolldetials["ref2"]."','".$row_rolldetials["ref3"]."','".$balance_qty."','".$current_date."','".$row_rolldetials["remarks"]."','".$row_rolldetials["log_user"]."','".$row_rolldetials["status"]."','".$row_rolldetials["ref4"]."','".$row_rolldetials["ref5"]."','".$row_rolldetials["ref6"]."','".$row_rolldetials["roll_status"]."','".$row_rolldetials["shrinkage_length"]."','".$row_rolldetials["shrinkage_width"]."','".$row_rolldetials["shrinkage_group"]."','".$row_rolldetials["rejection_reason"]."','".$tid_ref[$j]."')";
					// echo $qry_newroll."<br>";
					mysqli_query($link, $qry_newroll) or exit("Sql Error3: $qry_newroll".mysqli_error($GLOBALS["___mysqli_ston"]));
				}

				//To update Allocated Qty
				$sql="update $bai_rm_pj1.store_in set qty_allocated=qty_allocated+".$issued_ref[$j]." where tid=".$tid_ref[$j];
				mysqli_query($link, $sql) or exit("Sql Error3: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		
		
		//To confirm docket as allocated
		if($process_cat==1)
		{
			$sql1="update $bai_pro3.plandoc_stat_log set plan_lot_ref=\"".$lot_db[$i]."\" where doc_no=\"".$doc_ref[$i]."\"";
		}
		else
		{
			$sql1="update $bai_pro3.recut_v2 set plan_lot_ref=\"".$lot_db[$i]."\" where doc_no=\"".$doc_ref[$i]."\"";
		}
		//echo $sql1."<br/>";
		
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
				$sql="insert into $bai_pro3.maker_stat_log(DATE,cat_ref,cuttable_ref,allocate_ref,order_tid,mklength,mkeff,lastup,remarks,mk_ver) select DATE,cat_ref,cuttable_ref,allocate_ref,order_tid,mklength,mkeff,lastup,remarks,mk_ver from bai_pro3.maker_stat_log where tid='$mk_ref'";
				//echo $sql."<br/>";
				
				mysqli_query($link, $sql) or exit("Sql Error1x: $sql ".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$ilast_id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
				
				$sql="update $bai_pro3.maker_stat_log set mklength=$mk_length where tid='$ilast_id'";
				
				mysqli_query($link, $sql) or exit("Sql Error1x: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql="update $bai_pro3.plandoc_stat_log set lastup=\"".date("Y-m-d")."\", mk_ref=$ilast_id where doc_no=".$doc[$i];
				
				mysqli_query($link, $sql) or exit("Sql Error: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
				
			}
			
			//Search Valid Marker is available or not
		}
			
		}
		
	}
	
	//Exit Code
	
	echo "<h2>Successfully Updated.</h2>";
	
	if($process_cat==1)
	{
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"fab_pop_details.php?doc_no=".$doc_ref[0]."\"; }</script>";
	}
	else
	{
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"fab_pop_details_recut_v2.php?doc_no=".$doc_ref[0]."\"; }</script>";
	}
}

?>


<?php

if(isset($_POST['allocate']))
{

	
	echo "<form name='input' method='post' action='fab_pop_allocate_v5.php'>";
	$doc=$_POST['doc'];
	//echo "DOC : ".sizeof($doc);exit;
	$doc_cat=$_POST['doc_cat'];
	$doc_com=$_POST['doc_com'];
	$doc_mer=$_POST['doc_mer'];
	$cat_ref=$_POST['cat_ref'];
	
	$process_cat=$_POST['process_cat'];
	$style_ref=$_POST['style_ref'];
	
	$note="";
	for($i=0;$i<sizeof($doc);$i++)
	{
		$lot=$_POST[$doc[$i]];
		
		$doc_ref=$doc[$i];
		$mat_req=$doc_mer[$i];
		
		$temp="manual".$doc[$i];
		$manual_lot=$_POST[$temp];
		
		$temp="pms".$doc[$i];
		$pms_lot=array();
		if(strlen($_POST[$temp])>0)
		{
			$pms_lot=explode(",",$_POST[$temp]);
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
		
		//Table to show all list of available items
		if(sizeof($lot_db_2)>0)
		{
		
		echo "<input type=\"hidden\" name=\"doc_ref[$i]\" value=\"".$doc_ref."\">";
		echo "<input type=\"hidden\" name=\"process_cat\" value=\"".$process_cat."\">";
		echo "<input type=\"hidden\" name=\"mat_req[$i]\" value=\"".$mat_req."\">";
		echo "<input type=\"hidden\" name=\"lot_db[$i]\" value=\"".implode(";",$lot_db)."\">";
		echo "<input type=\"hidden\" name=\"min_width[$i]\" value=\"\">";
		
		echo "<h2><font color=blue>".$doc_cat[$i]."-".$doc_com[$i]."</font></h2>";
		
		//To show stats
		echo "<h3>Required: ".round($mat_req,2)." / Allocated: <span id=\"alloc$doc_ref\"></span> / Balance to Allocate: <span id=\"balal$doc_ref\">".round($mat_req,2)."</span></h3>";
		echo '<div class="table-responsive"><table id="example" class="stripe row-border order-column" cellspacing="0" width="100%">';
		
		echo "<thead><tr id=\"$doc_ref\" bgcolor=\"RED\">";
		echo "<th>Invoice No</th>";	
		echo "<th>GRN Date</th>";	
		echo "<th>Batch No</th>";	
		echo "<th>Item Code</th>";	
		echo "<th>Lot No</th>";	
		echo "<th>Shade</th>";
        echo "<th>Shrinkage Length</th>";	
		echo "<th>Shrinkage Width</th>";	
		echo "<th>Shrinkage Group</th>";		
		echo "<th>Roll No</th>";	
		echo "<th>Location</th>";	
		echo "<th>Group</th>";	
		echo "<th>Tkt Width</th>";	
		echo "<th>Ctx Width</th>";	
		echo "<th>Tkt Length</th>";	
		echo "<th>Ctx Length</th>";		
		echo "<th>Balance</th>";
		echo "<th>Allocated</th>";
		echo "<th>Issued Qty</th>";
		echo "<th>Select</th>";
		//echo "<th>Allocated Qnty</th>";
		echo "</tr></thead><tbody>";
		
		//$sql="select * from bai_rm_pj1.fabric_status_v2 where inv_no in (select inv_no from bai_rm_pj1.sticker_report where lot_no in (".implode(",",$lot_db_2)."))";

		//Current Version
		$sql="select * from $bai_rm_pj1.fabric_status_v3 where lot_no in (".implode(",",$lot_db_2).") order by shade";
		//$sql="select * from bai_rm_pj1.fabric_status_v3 where lot_no in (".implode(",",$lot_db_2).") order by inv_no,shade,width";
		//2012-06-12 New implementation to get fabric detail based on invoce/batch
		/////////////////XXXXXXXXXXXXXXXXXXXXXXXXXXX//////////////////////
		//TEMP Disabled due to execution issue at material code.
		/*
		$inv_batch=array();
		$sql="select distinct concat(trim(both from inv_no),'$',trim(both from batch_no)) as inv_batch from bai_rm_pj1.sticker_report where lot_no in (".implode(",",$lot_db_2).")";
		//echo $sql."<br>";
		$sql_result=mysql_query($sql,$link) or exit("Sql Error11".mysql_error());
		while($sql_row=mysql_fetch_array($sql_result))
		{
			$inv_batch[]="'".$sql_row['inv_batch']."'";		
		}
		
		$sql="select * from bai_rm_pj1.fabric_status_v3 where concat(trim(both from inv_no),'$',trim(both from batch_no)) in (".implode(",",$inv_batch).") order by inv_no,shade,width";
		*/
		/////////////////XXXXXXXXXXXXXXXXXXXXXXXXXXX//////////////////////
		//2012-06-12 New implementation to get fabric detail based on invoce/batch
		
		//echo "</br>Roll Details :".$sql."<br>";
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
			
			echo "<tr bgcolor=\"$bg_color\" id=\"trchk$doc_ref$j\">";
			echo "<td>".$sql_row['inv_no']."</td>";
			echo "<td>".$sql_row['grn_date']."</td>";
			echo "<td>".$sql_row['batch_no']."</td>";
			echo "<td>".$sql_row['item']."</td>";
			echo "<td>".$sql_row['lot_no']."</td>";
			echo "<td>".$sql_row['shade']."</td>";
			echo "<td>".$sql_row['shrinkage_length']."</td>";
			echo "<td>".$sql_row['shrinkage_width']."</td>";
			echo "<td>".$sql_row['shrinkage_group']."</td>";
			echo "<td>".$sql_row['ref2']."</td>";
			echo "<td>".$sql_row['ref1']."</td>";
			echo "<td>".$sql_row['shade']."</td>";
			echo "<td>".$sql_row['ref6']."</td>";
			echo "<td>".$sql_row['ref3']."</td>";
			echo "<td>".$sql_row['qty_rec']."</td>";
			echo "<td>".$sql_row['ref5']."</td>";
			echo "<td>".$sql_row['balance']."</td>";
			
			/* Added new code to track allocated quantities 20140621*/
			
			$sql1="SELECT GROUP_CONCAT(CONCAT(IF(doc_type='normal','D','R'),doc_no)) AS doc_nos,ROUND(SUM(allocated_qty),2) AS allocated_qty FROM $bai_rm_pj1.fabric_cad_allocation WHERE roll_id=".$sql_row['tid']." AND bai_rm_pj1.fn_roll_id_fab_scan_status(doc_no,doc_type,roll_id)=0";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error13: $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				
					$tag=$sql_row1['doc_nos'];
					$allocated_qty=$sql_row1['allocated_qty'];
			}
			
			echo "<td>".$allocated_qty."</td>";
			echo "<td><span id=\"issued".$doc_ref."[$j]\"></span></td>";
			
			//echo "</br>Allotment Status".$sql_row['allotment_status']."</br>";


			if($sql_row['allotment_status']==0 and strlen($sql_row['shade'])>0)
			{
				echo "<td><input type=\"checkbox\" id=\"chk$doc_ref$j\" name=\"chk".$doc_ref."[]\" value=\"".$j."\" onclick=\"check_qty2(".sizeof($doc).",'chk$doc_ref$j','$bg_color')\">";
				echo "<input type=\"hidden\" name=\"val".$doc_ref."[$j]\" value=\"".$sql_row['balance']."\">";
				echo "<input type=\"hidden\" name=\"width".$doc_ref."[$j]\" value=\"".$sql_row['width']."\">";
				echo "<input type=\"hidden\" name=\"lable".$doc_ref."[$j]\" value=\"".$sql_row['tid']."\">";
				echo "<input type=\"hidden\" name=\"issued_new".$doc_ref."[$j]\" id=\"issued_new".$doc_ref."[$j]\">";
				echo "</td>";
				
			}
			else
			{
				echo "<td>";
				
				$sql1="select max(log_time),doc_type,doc_no from $bai_rm_pj1.fabric_cad_allocation where roll_id=".$sql_row['tid'];
				// echo "</br>Qry : ".$sql1."</br>";
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
						$tag="R".$sql_row1['doc_no'];
					}
					$valid_check="display:none";
				}

				if(strlen($sql_row['shade'])==0)
				{
					$tag="Insp. Pending";
					$valid_check="display:none";
				}
				
				//To release for some time
				echo "<input style='$valid_check' type=\"checkbox\" id=\"chk$doc_ref$j\" name=\"chk".$doc_ref."[]\" value=\"".$j."\" onclick=\"check_qty2(".sizeof($doc).",'chk$doc_ref$j','$bg_color')\">";
				//echo "<input type=\"hidden\" id=\"chk$doc_ref$j\" name=\"chk".$doc1_ref."[]\" value=\"0\" onclick=\"check_qty2(".sizeof($doc).",'chk$doc_ref$j','$bg_color')\">";
				echo "<input type=\"hidden\" name=\"val".$doc_ref."[$j]\" value=\"".$sql_row['balance']."\">";
				echo "<input type=\"hidden\" name=\"width".$doc_ref."[$j]\" value=\"".$sql_row['width']."\">";
				echo "<input type=\"hidden\" name=\"lable".$doc_ref."[$j]\" value=\"".$sql_row['tid']."\">";
				echo "<input type=\"hidden\" name=\"issued_new".$doc_ref."[$j]\" id=\"issued_new".$doc_ref."[$j]\">";
				
				if(strlen($tag)>0)
				{
					echo "<img src=\"images/lock.png\"> $tag";
				}
				echo "</td>";
				
			}			
			echo "</tr>";
			$j++;
			
		}
		echo "</tbody></table></div>";
				
		}//Allow only for selected lots/docs
		
		//Table to show all list of available items
		
	}
	
	//OK echo "Validate: <input type=\"checkbox\" name=\"validate\" onclick=\"check_qty(".sizeof($doc).")\">";
	//OK echo "Validate: <input type=\"checkbox\" name=\"validate\">";
	echo "<input type=\"submit\" name=\"allocate_new\" value=\"Allocate\" onclick=\"button_disable()\" class='btn btn-success'>";
	// echo '<div id="process_message"><h2><font color="red">Please wait while updating data!!!</font><br/><font color="blue">After update, this window will close automatically!</font></h2></div>';
	
	echo "</form>";
}
?>

<script>
	document.getElementById("msg").style.display="none";	
	$(document).ready(function() {
		// Setup - add a text input to each footer cell
		$('#example1 th').each( function (i) {
			var title = $('#example thead th').eq( $(this).index() ).text();
			$(this).html( '<input type="text" placeholder="'+title+'" data-index="'+i+'" />');
		} );
			var table = $('.stripe').DataTable( {
				//scrollY:        "300px",
				"bPaginate": false,
				//scrollX:        true,
				scrollCollapse: true,
				paging:         false,
				fixedColumns:   true
			} );
		
		// DataTable
		// var table = $('#example').DataTable( {
			// scrollY:        "300px",
			// "bPaginate": false,
			// scrollX:        true,
			// scrollCollapse: true,
			// paging:         false,
			// fixedColumns:   true
		// } );

		// Filter event handler
		$( table.table().container() ).on( 'keyup', 'thead input', function () {
			table
				.column( $(this).data('index') )
				.search( this.value )
				.draw();
		} );
	} );
</script>
<style>
   th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 2000px;
        margin: 0 auto;
    }
 
    th input {
        width: 90%;
    }
</style>
</body>
</html>
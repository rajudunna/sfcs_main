<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 

$username="sfcsproject1";
// $view_access=user_acl("SFCS_0148",$username,1,$group_id_sfcs); 
//Ticket #995389 - KiranG 2014-04-26
//Added necessary validation to avoid docket editing after plot job. This is based on the lastup field on plandoc_stat_log table.
// $authorized_to_change=user_acl("SFCS_0148",$username,78,$group_id_sfcs);  // docket edit access

// $authorized_docket_change=user_acl("SFCS_0148",$username,79,$group_id_sfcs); // Authorized docket change after plot preparation
// $authorized_recut_docket_change=user_acl("SFCS_0148",$username,80,$group_id_sfcs); // Authorized recut docket change after plot preparation
$authorized_to_change=array("sfcsproject1");
$authorized_docket_change=array("sfcsproject1");
$authorized_recut_docket_change=array("sfcsproject1");
?>

<script>


	function edit(c)
	{
		if (window.XMLHttpRequest)
	    {// code for IE7+, Firefox, Chrome, Opera, Safari
	  		xmlhttp=new XMLHttpRequest();
	  	}
		else
	  	{// code for IE6, IE5
	  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  	}
		xmlhttp.onreadystatechange=function()
	  	{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    	{
		    	document.getElementById("txtHint2").innerHTML=xmlhttp.responseText;
		    }
	 	}
		var r="<?= $_GET['r'] ?>";
		var url="<?= getFullURL($_GET['r'],'ajax_fab_issue_track_v2.php','R'); ?>";	
		xmlhttp.open("GET", url+"?s="+c+"&rand="+Math.random()+"&r="+r,true);
		xmlhttp.send(); 
	}
	function validate_qty_2()
	{
		var bal_qty=parseFloat(document.getElementById("bal_qty").value);
		var qty_issued=parseFloat(document.getElementById("qty_issued").value);
		var qty_issued_chk=parseFloat(document.getElementById("qty_issued_chk").value);
		
		if(qty_issued <= bal_qty)
		{
			//alert("Test2");
			
		}
		else
		{
			//alert("Test3");
			document.getElementById("qty_issued").value=qty_issued_chk;
		}
	}
</script>

<script>

function numbersOnly(event)
{
   var charCode = event.keyCode;

            if ((charCode > 47 && charCode < 58) || charCode == 8 || charCode == 46 )
				{
					return true;
				}
				else
				{
					return false;
				}
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

function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
	{
		return false;
	}
	return true;
}
</script>
<!-- <style>
th{
	background-color:#d9534f;
	color:white;
	text-align:center;
	font-size:12px;
}

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
	background:#ffcccc;
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

</style> -->
<!-- <?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?> -->


<body>
<div class="panel panel-primary">
<div class="panel-heading">Fabric Issue Track Details</div>
<div class="panel-body">


<!---<div id="page_heading"><span style="float: left"><h3>Fabric Issue Track Details </h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>-->
<form name="text" method="post" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>">

<?php
include("dbconf.php");
// include(getFullURLLevel($_GET['r'],'dbconf.php',0,'R')); 
$cat="";
if(isset($_GET['delete']))
{
	if($_GET['delete']==1)
	{

		$tran_pin=$_GET['tran_pin'];
		$sql1="insert into $bai_rm_pj1.fabric_cad_allocation_deleted select * from $bai_rm_pj1.fabric_cad_allocation where tran_pin=$tran_pin";
		mysqli_query($link, $sql1) or exit("Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql12="select * from $bai_rm_pj1.fabric_cad_allocation where tran_pin=$tran_pin";
		$result12=mysqli_query($link, $sql12) or die("Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
	    while($row12=mysqli_fetch_array($result12))
		{
			$roll_id=$row12["roll_id"];
			$allocated_qty=$row12["allocated_qty"];
			$doc_no=$row12["doc_no"];
			$doc_type=$row12["doc_type"];
		}
		
		//echo "<br/> value=".$roll_id."-".$allocated_qty;
		
		$sql13="update $bai_rm_pj1.store_in set qty_allocated=(qty_allocated - \"$allocated_qty\"),allotment_status='0' where tid=\"$roll_id\" ";
		mysqli_query($link, $sql13) or exit("Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql14="delete from $bai_rm_pj1.fabric_cad_allocation where tran_pin=$tran_pin";
		mysqli_query($link, $sql14) or exit("Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		echo "<script>sweetAlert('Successfully','deleted','success')</script>";
		$url=getFullURL($_GET['r'],'fab_issue_track_V2.php','N');
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"$url&doc_no=$doc_no&doc_type=$doc_type\"; }</script>";
	}
}
if(isset($_GET['doc_no']))
{
		$flag=1;
		if($_GET['doc_type'] == "normal")
		{
			$cat="D";
		}
		else
		{
			$cat="R";
		}
		$docket001=$_GET["doc_no"];
}
else
{
	$flag=0;
}
if(isset($_POST['submit']))
{
	$cat=$_POST['cat'];
	$docket001=$_POST["doc"];
}
?>
<div class='col-md-3 col-sm-3 col-xs-12'>
Please Select : <select name="cat" class="select2_single form-control">
<option value="D" <?php if($cat=="D") { echo "selected"; } ?>>Docket</option>
<option value="R" <?php if($cat=="R") { echo "selected"; } ?>>Recut</option>
</select>
</div>
<div class='col-md-3 col-sm-3 col-xs-12'>
Docket/Recut Number:<i style="color:red"></i><input type="text"  name="doc" onkeypress="return validateQty(event);" class="form-control" value="<?= $docket001 ?>" size="6"/ required> 
</div>
<div class='col-md-3 col-sm-3 col-xs-12'>
<input type="submit" class="btn btn-success confirm-submit" value="Search" id="submit" name="submit" style="margin-top: 19px;"/>
</div>
</form>

<?php

if(isset($_POST['update']))
{
	$section=$_POST['section'];
	$picking_list=$_POST['picking_list'];
	$delivery_no=$_POST['delivery_no'];
	$issued_by=$_POST['issued_by'];
	$movex=$_POST['movex'];
	$manual=$_POST['manual'];
	$product=$_POST['product'];
	$doc_ref=$_POST['doc_ref'];
	
	$dock_type=$_POST['dock_type'];
	$docket_num=$_POST['docket_num'];
	if($dock_type == "D")
		{
			$docket_type="normal";
		}
		else
		{
			$docket_type="recut";
		}
	
	$sql1="insert into $bai_rm_pj1.m3_fab_issue_track(doc_ref,section,picking_list,delivery_no,issued_by,movex_update,manual_issue) values ('$doc_ref',$section,'$picking_list','$delivery_no','$issued_by',$movex,$manual)";
	//echo $sql1;
	mysqli_query($link, $sql1) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	echo "<script>sweetAlert('Successfully','Updated','success')</script>";
	$url=getFullURL($_GET['r'],'fab_issue_track_V2.php','N');
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",200); function Redirect() {  location.href = \"$url&doc_no=$docket_num&doc_type=$docket_type\"; }</script>";
	
}

?>

<?php
if(isset($_POST["submit"]) or $flag==1)
{
	
	function status_code($x)
	{
		if($x==1)
		{
			return "Yes";
		}
		else
		{
			return "No";
		}
	}

	
	if($flag==1)
	{
		$docket=$_GET['doc_no'];
		if($_GET['doc_type'] == "normal")
		{
			$cat="D";
		}
		else
		{
			$cat="R";
		}
	}
	else
	{
		$docket=$_POST["doc"];
		$cat=$_POST["cat"];	
	}
	
	//echo $docket."<br>";
	
	if(strlen($docket)>0)
	{
		if($cat == "D")
		{
			$docket_type="normal";
		}
		else
		{
			$docket_type="recut";
		}
	
		
		if($cat == "D")
		{
			$table="$bai_pro3.plandoc_stat_log";
		}
		else
		{
			$table="$bai_pro3.recut_v2";
		}
		
		$sql1="select doc_no,plan_lot_ref,lastup from $table where doc_no=\"".$docket."\"";
		// echo $sql1;
		$result1=mysqli_query($link, $sql1) or die("Error1234 ".mysqli_error($GLOBALS["___mysqli_ston"]));
		$doc_rows = mysqli_num_rows($result1);
		
		if($doc_rows > 0){
			 //echo $doc_rows;
			echo "<br/><div clas==row''><div class='col-md-4'><table class='table table-bordered table-striped'>";
			echo "<tr><th>".ucwords($docket_type)." Docket No</th><td>".$docket."</td></tr>";
			echo "</table></div></div><br/><br/><br/>";
			while($row1=mysqli_fetch_array($result1))
			{
				$lot_no=$row1["plan_lot_ref"];
				$lastup=$row1["lastup"];
			}
			if($lot_no){
			$lot_nos=explode(";",$lot_no);
			}
			$lot_no_finals[]=0;
			for($i=0;$i<sizeof($lot_nos);$i++)
			{
				if($lot_nos[$i]!="")
				{
					$lot_no_final=explode(">",$lot_nos[$i]);
					$lot_no_finals[]=$lot_no_final[0];
				}
			}
			
			$sqlw="select * from $bai_rm_pj1.fabric_cad_allocation where doc_no=\"".$docket."\"";
			// echo $sqlw."<br>";
			$result1w=mysqli_query($link, $sqlw) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowsw=mysqli_num_rows($result1w);
			echo '<div>';
			// if($rowsw > 0)
			{
			echo "<div class='panel panel-primary'>";	
			echo "<div class='panel-heading'>New Entry</div>";
			echo "<div class='panel-body'>";
			echo "<table class='table table-bordered table-striped'>";
			echo "<tr><th>Docket No</th><th>Label ID<i style='color:red'>*</i></th><th>Docket Type</th><th>Allocated Qty<i style='color:red'>*</i></th><th>Control</th></tr>";
			//echo "<tr><th>Docet No</th><th>Label ID</th><th>Roll Width</th><th>Docet Type</th><th>Allocated Qty</th><th>Control</th></tr>";
			echo '<form method="POST" name="form" action="'.getFullURL($_GET['r'],'fab_issue_track_V2.php','N').'">';
			echo "<tr><td><input type='hidden' name='doc_no'  value='".$docket."' size=4>".$docket."</td>";
			echo "<td><input type='text' name='roll_id2'  id='label_id' value='' size=4 class='form-control integer'  required/></td>";
			//echo "<td><input type='text' name='roll_width' value='' size=6 class='input'></td>"; 
			echo '<td><select name="cat" class="form-control">';
			if($cat=='D')
			{
				echo '<option value="normal" selected>Docket</option>';
			}
			else
			{
				echo '<option value="recut" selected >Recut</option> </select></td>'; 
			}
			
			echo "<td><input type='text' name='alloc_qty' id='alloc_qty' value='' size=10 class='form-control float' required/></td>"; 
			
				$sql121="select store_out.log_stamp,store_out.qty_issued,sticker_ref.inv_no,sticker_ref.batch_no,sticker_ref.ref2 as rollno,sticker_ref.ref4 as shade,store_out.updated_by from $bai_rm_pj1.store_out left join $bai_rm_pj1.sticker_ref on store_out.tran_tid=sticker_ref.tid where cutno='".$cat.$docket."' order by tran_tid ";
				//echo $sql121."<br>";
				$result121=mysqli_query($link, $sql121) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($result121);
				//echo "no of rows=".$sql_num_check."<br/>";
				if((in_array(strtolower($username),$authorized_to_change)))
				{
					if(($lastup=="0000-00-00 00:00:00")  and ($sql_num_check==0))
					{
						echo "<td><input type='submit' value='New Entry' name='new_entry' id='new_entry' class='btn btn-success btn-xs' ></td>";
					}
					else if($lastup!="0000-00-00 00:00:00" and ($sql_num_check==0) )
					{
						if($cat=='D' and (in_array(strtolower($username),$authorized_docket_change)) and ($sql_num_check==0))
						{
							echo "<td><input type='submit' value='New Entry' name='new_entry' id='new_entry' class='btn btn-success btn-xs' ></td>";
						}
						else if($cat=='R' and (in_array(strtolower($username),$authorized_recut_docket_change)) and ($sql_num_check==0) )
						{
							echo "<td><input type='submit' value='New Entry' class='btn btn-success btn-xs' name='new_entry' id='new_entry' ></td>";
						}
						else
						{
							echo "<td>N/A : Plot Job Completed</td>";
						}
					}
					else
					{
						echo "<td>N/A : Plot Job Completed</td>";
					}
				}
				else
				{
						echo "<td>N/A </td>"; 
				}
			echo "</tr>";
			
			echo "</table><br/><br/>";
			}
			//else
				echo "</div></div>";
			// $total_quantity=0;
			$sql1="select allocated_qty as qty from $bai_rm_pj1.docket_ref where doc_no=\"".$docket."\" and doc_type=\"".$docket_type."\" order by tid ";
			// echo $sql1;
			$result1=mysqli_query($link, $sql1) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$total_rows=mysqli_num_rows($result1);
			if($total_rows>0)
			{
				echo "<h2 style='color:green'>Allocated Material For This Docket</h2>";
			}
			else
			{
				echo "<h2 style='color:red'>Please Allocate Material For This Docket</h2>";
				
			}
			echo "<div>";
			$total_qty=0;
			echo "<div class='panel panel-primary'>";
			echo "<div class='panel-heading'>Allocated</div>";
			echo "<div class='panel-body'>";
			
			echo "<table class='table table-bordered table-striped'>";
			echo "<tr><th>Inv No</th><th>Batch No</th><th>Shade</th><th>Roll No</th><th>Label ID</th><th>Roll Width</th><th>Allocated Qty</th><th>Time</th><th>Control</th></tr>";
		
			$sql1="select tran_pin,inv_no,batch_no,lot_no,roll_id,ref2 as rollno,ref4 as shade,roll_width,allocated_qty as qty,log_time from $bai_rm_pj1.docket_ref where doc_no=\"".$docket."\" and doc_type=\"".$docket_type."\" order by tid ";
			// echo $sql1."<br>";
			$result1=mysqli_query($link, $sql1) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row1=mysqli_fetch_array($result1))
			{
				$tran_pin=$row1["tran_pin"];
				$inv_no=$row1["inv_no"];
				$batch_no_no=$row1["batch_no"];
				$lot_no=$row1["lot_no"];
				$rollno=$row1["rollno"];
				$roll_id=$row1['roll_id'];
				$roll_width=$row1['roll_width'];
				$shade=$row1["shade"];
				$qty=$row1["qty"];
				$total_qty=$total_qty+$qty;
				$sql121="select store_out.log_stamp,store_out.qty_issued,sticker_ref.inv_no,sticker_ref.batch_no,sticker_ref.ref2 as rollno,sticker_ref.ref4 as shade,store_out.updated_by from $bai_rm_pj1.store_out left join $bai_rm_pj1.sticker_ref on store_out.tran_tid=sticker_ref.tid where cutno='".$cat.$docket."' order by tran_tid ";
				// echo $sql121."<br>";
				$result121=mysqli_query($link, $sql121) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($result121);
				// echo "no of rows=".$sql_num_check."<br/>";
				echo "<tr><td>$inv_no</td><td>$batch_no_no</td><td>$shade</td><td>$rollno</td><td>$roll_id</td><td>$roll_width</td><td>$qty</td><td>".$row1['log_time']."</td>";
				if((in_array(strtolower($username),$authorized_to_change)))
				{
					if(($tran_pin!="") and ($lastup=="0000-00-00 00:00:00") and ($sql_num_check==0))
					{
						echo '<td><input type="hidden" value="'.$roll_id.'" name="roll_id" id="roll_id"><a class="btn btn-warning btn-xs href="#" value="'.$tran_pin.'" onclick="edit('.$tran_pin.')">Edit</a>';
						$url=getFullURL($_GET['r'],'fab_issue_track_V2.php','N');
						$path="$url&doc_no=".$docket."&doc_type=".$docket_type."&tran_pin=".$tran_pin."&delete=1";
						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id='del_$tran_pin' class='btn btn-danger btn-xs confirm-submit'  href='$path'  value='".$tran_pin."'>Delete</a></td>";			
					}
					else if($tran_pin!="" and $lastup!="0000-00-00 00:00:00" and ($sql_num_check==0))
					{
						if($cat=='D' and (in_array(strtolower($username),$authorized_docket_change)) and ($sql_num_check==0))
						{
							echo '<td><input type="hidden" value="'.$roll_id.'" name="roll_id" id="roll_id"><a class="btn btn-warning btn-xs" href="#" value="'.$tran_pin.'" onclick="edit('.$tran_pin.')">Edit</a>';
							$url=getFullURL($_GET['r'],'fab_issue_track_V2.php','N');
							$path="$url&doc_no=".$docket."&doc_type=".$docket_type."&tran_pin=".$tran_pin."&delete=1";
							echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id='del_$tran_pin' class='btn btn-danger btn-xs confirm-submit'  href='$path'  value='".$tran_pin."'>Delete</a></td>";
						}
						else if($cat=='R'  and (in_array(strtolower($username),$authorized_recut_docket_change)) and ($sql_num_check==0))
						{

							echo '<td><input type="hidden" value="'.$roll_id.'"  name="roll_id" id="roll_id"><a class="btn btn-warning btn-xs href="#" value="'.$tran_pin.'" onclick="edit('.$tran_pin.')">Edit</a>';
							$url=getFullURL($_GET['r'],'fab_issue_track_V2.php','N');
							$path="$url&doc_no=".$docket."&doc_type=".$docket_type."&tran_pin=".$tran_pin."&delete=1";
							echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id='del_$tran_pin'class='btn btn-danger btn-xs confirm-submit'  href='$path'  value='".$tran_pin."'>Delete</a></td>";
						}
						else
						{
							echo "<td>N/A : Plot Job Completed</td>";
						}
					}
					else
					{
						echo "<td>N/A : Plot Job Completed</td>";
					}				
									
				}
				else
				{
					echo "<td>N/A</td>";
				}
			}	
			
			echo "<tr><td colspan=6 align='center' style='color:#FFFFFF;background:#11569b;font-size:14;font-weight: bold;
	'>Total Qty</td><td>$total_qty</td><td colspan=2></td>";
			
				
				echo "</table></form>";	
	echo "</div></div>";			
					echo "<div id=\"shead\">";
				echo "<span id=\"txtHint2\">";	
				echo '<b></b></span></div>';
			

		
			echo "<div>";
			
			echo "<div class='panel panel-primary'>";
			echo "<div class='panel-heading'>Actual Issued</div>";
			echo "<div class='panel-body'>";
			
			echo "<table class='table table-bordered table-striped'>";
			echo "<tr><th>Inv No</th><th>Batch No</th><th>Shade</th><th>Roll No</th><th>Issued Qty</th><th>Time</th><th>Issued by</th></tr>";
		
			$total_qty=0;
			$sql1="select store_out.log_stamp,store_out.qty_issued,sticker_ref.inv_no,sticker_ref.batch_no,sticker_ref.ref2 as rollno,sticker_ref.ref4 as shade,store_out.updated_by from $bai_rm_pj1.store_out left join $bai_rm_pj1.sticker_ref on store_out.tran_tid=sticker_ref.tid where cutno='".$cat.$docket."' order by tran_tid ";
			//echo $sql1."<br>";
			$result1=mysqli_query($link, $sql1) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row1=mysqli_fetch_array($result1))
			{
				$inv_no=$row1["inv_no"];
				$batch_no_no=$row1["batch_no"];
				$lot_no=$row1["lot_no"];
				$rollno=$row1["rollno"];
				//$roll_id=$row1['roll_id'];
				$shade=$row1["shade"];
				$qty=$row1["qty_issued"];
				$updated_by=$row1['updated_by'];
				if($updated_by=='')
				{
				$updated_by='Through Barcode Scanning';
				}
				$total_qty=$total_qty+$qty;
				echo "<tr><td>$inv_no</td><td>$batch_no_no</td><td>$shade</td><td>$rollno</td><td>$qty</td><td>".$row1['log_stamp']."</td><td>".$updated_by."</td></tr>";		
			}	
			
			//echo "<tr><td colspan=2></td><th colspan=2>Total Qty</th><td>$total_qty</td></tr>";
			echo "<tr><td colspan=4 align='center' style='color:#FFFFFF;background:#11569b;font-size:14;font-weight: bold;
	'>Total Qty</td><td>$total_qty</td><td colspan=2></td>";
			
			echo "</table><br/><br/>";
			
			echo "</div></div>";
			
			
			echo "<div>";
			echo "</div>";
			echo "<div class='panel panel-primary'><div class='panel-heading'>M3 Update Track</div>";
			echo "<div class='panel-body'>";
			echo "<table class='table table-bordered table-striped'>";
			echo "<tr><th>Section</th><th>Picking List</th><th>Delivery</th><th>Issued By</th><th>M3 Update</th> <th>Manual Tran</th></tr>";
		
			$sql1="select * from $bai_rm_pj1.m3_fab_issue_track where doc_ref='".$cat.$docket."'";
			//echo $sql1."<br>";
			$result1=mysqli_query($link, $sql1) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row1=mysqli_fetch_array($result1))
			{
				echo "<tr>";
				echo "<td>".$row1['section']."</td>";
				echo "<td>".$row1['picking_list']."</td>";
				echo "<td>".$row1['delivery_no']."</td>";
				echo "<td>".$row1['issued_by']."</td>";
				echo "<td>".status_code($row1['movex_update'])."</td>";
				echo "<td>".status_code($row1['manual_issue'])."</td>";
				echo "</tr>";
			}
			echo "</table>";
			
			// echo "</div>";
			echo "</div>";
			echo "</div>";
			
			//echo "<table width=100%><tr><td width=50%>1</td><td>2</td><td>3</td></tr></table>";
			echo "<table width=100%><tr><td width=40%><div>";
				echo "<div style='float:top;margin-top:-196.5pt;position:static; clear:both;'>";
				echo "<div class='panel panel-primary'>";
				echo "<div class='panel-heading'>Lot Numbers</div>";
				echo "<div class='panel-body'>";
				echo "<table class='table table-bordered table-striped'>";
				echo "<tr><th>Lot Numbers</th><td colspan='5'>".implode(",",array_unique($lot_no_finals))."</tr>";	
				echo "</table>";
				echo '</div></div></div></td>';
				echo '<span id="error" style="color: Red; display: none"></span>';
				echo "<td width=5%></td><td width=55%><div style='position:static;'>";
				echo "<div class='panel panel-primary'>";
				echo "<div class='panel-heading'>M3 Update Form</div>";
				echo "<div class='panel-body'>";
				echo "<form name='update' id='delete_form' method='post' action='".getURL(getBASE($_GET['r'])['path'])['url']."'>";
				echo "<table class='table table-bordered table-striped'>";
				echo "<tr><th>Section</th>
					<td><select name='section' class='form-control' required>
					<option value='1'>Section-1</option>
					<option value='2'>Section-2</option>
					<option value='3'>Section-3</option>
					</select>
					</td></tr>";
				echo "<tr><th>Picking List</th><td><input type='text'  name='picking_list' value='' class='form-control alpha' required></td></tr>";
				echo "<tr><th>Delivery No</th><td><input type='text' name='delivery_no' value='' class='form-control alpha' required></td></tr>";
				echo "<tr><th>Issued By</th><td><input type='text'  name='issued_by' value='' class='form-control alpha' required></td></tr>";
				echo "<tr><th>Movex</th>
					<td><select name='movex' class='form-control'>
					<option value='0'>Not Updated</option>
					<option value='1'>Updated</option>
					</select>
					</td></tr>";
				echo "<tr><th>Manual</th>
					<td><select name='manual' class='form-control'>
					<option value='0'>No</option>
					<option value='1'>Yes</option>
					</select>
					</td></tr>";
				echo "<tr><th>Product</th>
					<td><select name='product'  class='form-control'>
					<option value='Fabric'>Fabric</option>
					</select>
					</td></tr>";
				echo "<tr><td colspan='2'><input type='hidden' name='doc_ref' value='".$cat.$docket."'>
				<input type='hidden' name='docket_num' value='".$docket."'>
				<input type='hidden' name='dock_type' value='".$cat."'>

					  <input type='submit' class='btn btn-success' name='update' value='Update'></td></tr>";
				echo "</table>";
				echo "</form>";
				echo '</div></div></div></td></tr></table>';
				
			echo '</div>';
			echo '</div>';
		}else{
			echo "<script>sweetAlert('error','No records found for this docket number','warning')</script>";
		}
	}
	else
	{
		echo "Please enter valid details.";
	}
}





if(isset($_POST['update_ajax']))
{
	$tran_pin=$_POST['tran_pin'];
	$qty_issued=$_POST['qty_issued'];
	$doc_type=$_POST['doc_type'];
	$roll_id=$_POST['roll_id'];
	$roll_width=$_POST['roll_width'];
	$doc_no=$_POST['doc_no'];	

	//$sql="update bai_rm_pj1.fabric_cad_allocation set  allocated_qty=\"$qty_issued\",roll_id=\"$roll_id\",roll_width=\"$roll_width\" where tran_pin=\"$tran_pin\"";
	$sql="update $bai_rm_pj1.fabric_cad_allocation set  allocated_qty=\"$qty_issued\",roll_id=\"$roll_id\" where tran_pin=\"$tran_pin\"";
	//echo $sql;
	mysqli_query($link, $sql) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql1="update $bai_rm_pj1.store_in set qty_allocated=\"$qty_issued\",allotment_status='1' where tid=\"$roll_id\" ";
	//echo $sql1;
	mysqli_query($link, $sql1) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	echo "<script>sweetAlert('Successfully','Updated','success')</script>";
	$url=getFullURL($_GET['r'],'fab_issue_track_V2.php','N');
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",200); function Redirect() {  location.href = \"$url&doc_no=$doc_no&doc_type=$doc_type\"; }</script>";
}

if(isset($_POST['new_entry']))
{
	$doc_no=$_POST['doc_no'];
	$roll_id=$_POST['roll_id2'];
	//$roll_width=$_POST['roll_width'];
	$doc_type=$_POST['cat'];
	$alloc_qty=$_POST['alloc_qty'];
	$row_id_old = "select roll_id from $bai_rm_pj1.docket_ref where doc_no='".$doc_no."'";
	$result_old=mysqli_query($link, $row_id_old) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$i=0;
	$temp_status = 0;
	while($row_old=mysqli_fetch_array($result_old)){
		$temp = $row_old['roll_id'];
		if($row_old['roll_id'] == $roll_id){
			echo "<script>swal('Enter Unique Lable ID','','warning')</script>";
			$temp_status = 1;
		}
	}
	$sql="select * from $bai_rm_pj1.store_in where tid='".$roll_id."'"; 
	$result1=mysqli_query($link, $sql) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$label_rows = mysqli_num_rows($result1);
	if($label_rows > 0){
		while($row12=mysqli_fetch_array($result1))
		{
			if($row12['allotment_status']==0)
			{				
			$balance=$row12['qty_rec']+$row12['qty_ret']-($row12['qty_issued']+$row12['partial_appr_qty']);
			}
			else
			{
			$balance=$row12['qty_rec']+$row12['qty_ret']-($row12['qty_issued']+$row12['partial_appr_qty']+$row12['qty_allocated']);
			}
			
		}
	if($temp_status==0) {
		if($alloc_qty<=$balance)
		{
				//$sql="insert into bai_rm_pj1.fabric_cad_allocation(doc_no,roll_id,roll_width,doc_type,allocated_qty) values (\"$doc_no\",\"$roll_id\",\"$roll_width\",\"$doc_type\",\"$alloc_qty\")";
				$sql="insert into $bai_rm_pj1.fabric_cad_allocation(doc_no,roll_id,doc_type,allocated_qty,status) values (\"$doc_no\",\"$roll_id\",\"$doc_type\",\"$alloc_qty\",'1')";
				//echo $sql;
				mysqli_query($link, $sql) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql1="update $bai_rm_pj1.store_in set qty_allocated=(qty_allocated+\"$alloc_qty\"),allotment_status='1' where tid=\"$roll_id\" ";
				//echo $sql1;
				mysqli_query($link, $sql1) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql="select ref3,ref6 from $bai_rm_pj1.store_in WHERE tid=$roll_id";
				$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1=mysqli_fetch_array($result1))
				{
					$ctx_width=$row1["ref3"];
					$act_width=$row1["ref6"];
				}
				
				if($ctx_width == 0)
				{
					$ctx_width=$act_width;
				}
				
				$sql="update $bai_rm_pj1.fabric_cad_allocation set roll_width=\"$ctx_width\" where roll_id=\"$roll_id\"";
				// echo $sql."<br>";
				mysqli_query($link, $sql) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				echo "<script>sweetAlert('Successfully','Updated','success')</script>";
		}
		else
		{
			// $url=getFullURL($_GET['r'],'fab_issue_track_V2.php','N');
			// $total_url = $url.'&doc_no='.$doc_no.'&doc_type='.$doc_type;
			// echo '<script>sweetAlert("Insufficient Quantity for this label id: '.$roll_id.'").then((value) => { if(value){location.href = \''.$total_url.'\';}});</script>';
				// echo "<h2 style='color:RED;'>Insufficient Quantity for this label id: <h2/>".$roll_id;
				echo "<script>sweetAlert('Insufficient Quantity for this label id:$roll_id','','warning')</script>";
		}
	}
	}else{
		// $url=getFullURL($_GET['r'],'fab_issue_track_V2.php','N');
		// $total_url = $url.'&doc_no='.$doc_no.'&doc_type='.$doc_type;
		// echo '<script>sweetAlert("No records found for Roll id: '.$roll_id.'").then((value) => { if(value){location.href = \''.$total_url.'\';}});</script>';
				echo "<script>sweetAlert('No records found for Label id:$roll_id','','warning')</script>";
		
	}
	$url=getFullURL($_GET['r'],'fab_issue_track_V2.php','N');
	
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1200); function Redirect() {  location.href = \"$url&doc_no=$doc_no&doc_type=$doc_type\"; }</script>";


}



?>
</div>
</div>
</div>
</body>
<script>

	$('#label_id').on('change',function(){

		var c = $('#label_id').val();
		var url="<?= getFullURL($_GET['r'],'ajax_alloc_qty_label.php','R'); ?>";	
		$.ajax({
			url:url,
			data:{label:c},
			method:'POST',
			dataType: "text",
			success:function(response){
				if(response!='false')
				{
					// console.log(response);
					$('#alloc_qty').val(response);
					
				}
				else
				{
					
					sweetAlert('This Label Id Does Not exists','','warning');
					$('#label_id').val('');
					$('#alloc_qty').val('');

				}
			
			}
		});
	});
	</script>
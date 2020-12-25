
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
//include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));
//$view_access=user_acl("SFCS_0156",$username,1,$group_id_sfcs); 
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
// $plantcode="AIP"
?>


<?php 
//include("functions.php"); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<!-- <script type='text/javascript' src="<?= '../'.getFullURL($_GET['r'],'ajax-autocomplete/jquery.autocomplete.js','R') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?= '../'.getFullURL($_GET['r'],'ajax-autocomplete/jquery.autocomplete.css','R') ?>" /> -->

<!-- <script type="text/javascript">
$().ready(function() {
	$("#course").autocomplete("<?= '../'.getFullURL($_GET['r'],'ajax-autocomplete/get_course_list.php','R') ?>", {
		width: 260,
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
});
</script> -->
<title>Stock In Edit Form</title>
<link rel="stylesheet" href="<?= '../'.getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R'); ?>" type="text/css" media="all" />
  <script type="text/javascript" src="<?= '../'.getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R'); ?>"></script>
  
<script type="text/javascript" src="<?= '../'.getFullURLLevel($_GET['r'],'common/js/check.js',1,'R');?>"></script>
<script type="text/javascript">
jQuery(document).ready(function($){
   $('#course').keypress(function (e) {
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
<?php 

echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />';
 ?>	

<body onload="dodisable();">
	<div class='panel panel-primary'>
		<div class='panel-heading '><h3  class='panel-title'>Stock Edit Form</h3></div>
		<div class='panel-body table-responsive'>

			<?php include("menu_content.php"); ?>


			<FORM method="post" name="input2" action="?r=<?= $_GET['r'] ?>" class="form-inline">
			<label>Enter Lot No: </label>
			<div class="form-group">
			<input type="text" id="course" name="lot_no" class="form-control">
			</div>
			<input type="submit" name="submit" class='btn btn-success' value="Search">
			</form>
			<hr/>

			<?php
			if(isset($_POST['submit']))
			{
				$lot_no=$_POST['lot_no'];
				
			}
			else
			{
				$lot_no=$_GET['lot_no'];
				$plantcode=$_GET['plantcode'];
			}
			// $plantcode = 'EKG';
			// var_dump($plantcode);

			?>



			<?php
			if(strlen($lot_no)>0)
			{

			$sql="select product_group,item,item_name,item_desc,inv_no,po_no,rec_no,rec_qty,batch_no,buyer,pkg_no,grn_date from $wms.sticker_report where plant_code='$plantcode' and lot_no=\"".trim($lot_no)."\"";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error-b".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);

			// var_dump($sql);
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				
				$product_group=$sql_row['product_group'];
				$item=$sql_row['item'];
				$item_name=$sql_row['item_name'];
				$item_desc=$sql_row['item_desc'];
				$inv_no=$sql_row['inv_no'];
				$po_no=$sql_row['po_no'];
				$rec_no=$sql_row['rec_no'];
				$rec_qty=$sql_row['rec_qty'];
				$batch_no=$sql_row['batch_no'];
				$buyer=$sql_row['buyer'];
				$pkg_no=$sql_row['pkg_no'];
				$grn_date=$sql_row['grn_date'];
				
				//NEW SYSTEM IMPLEMENTATION RESTRICTION
				$new_ref_date=substr($grn_date,0,4)."-".substr($grn_date,4,2)."-".substr($grn_date,6,2);
				if($new_ref_date>"2011-05-12")
				{
				
				}
				else
				{
					//header("Location:restrict.php");
				}
				//NEW SYSTEM IMPLEMENTATION RESTRICTION
			}

			$sql="select sum(qty_rec) as \"qty_rec\" from $wms.store_in where plant_code='$plantcode' and lot_no=\"".trim($lot_no)."\"";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error-b".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$qty=$sql_row['qty_rec'];
			}

			$diff=$rec_qty-$qty;
			echo "<div class='col-sm-6'>";
			echo "<table class='table table-striped table-bordered'>";
			echo "<tr><th>Lot No</th><td>$lot_no</td></tr>";
			echo "<tr><th>Batch</th><td>$batch_no</td></tr>";
			echo "<tr><th>Item Description</th><td>$item_desc</td></tr>";
			echo "<tr><th>Item Name</th><td style = 'word-break: break-word;'>$item_name</td></tr>";
			echo "<tr><th>Product</th><td>$product_group</td></tr>";
			echo "<tr><th>GRN Date</th><td>$grn_date</td></tr>";
			echo "</table>";
			echo "</div><div class='col-sm-6'>";

			echo '<form id="myForm" name="input" action="?r='.$_GET['r'].'" method="post">';
			echo "<table class='table table-striped table-bordered '>";
			echo "<thead><tr><th>Label ID</th><th>Location</th><th>Box/Roll No</th><th>IN Qty</th><th>Available Qty</th>";
			if(trim($product_group)=="Fabric")
			{
				echo "<th>Shade Group</th><th>Measured Width (Inches)</th><th>Measured Length ($fab_uom)</th>";
			}
			echo "</thead></tr>";

			$shades=array("","A","B","C","D","E","F","G");


			$sql="select tid,ref1,ref2,qty_rec,status,qty_issued,qty_ret,ref4,ref3,ref5,barcode_number from $wms.store_in where plant_code='$plantcode' and lot_no=\"".trim($lot_no)."\"";
			// echo $sql."<br>";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error-c".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);
			$MRN_tid = array();
			echo "<tbody>";
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$MRN_tid[] = $sql_row['tid'];
				$tid=$sql_row['tid'];
				$barcode_number=$sql_row['barcode_number'];
				$location=$sql_row['ref1'];
				$box=$sql_row['ref2'];
				$qty_rec=$sql_row['qty_rec'];
				$status=$sql_row['status'];
				$available=$qty_rec-$sql_row['qty_issued']+$sql_row['qty_ret'];
				$ref4=$sql_row['ref4'];
				$ref3=$sql_row['ref3'];
				$ref5=$sql_row['ref5'];
				
				echo "<tr>";
				
				if($status==0)
				{	
					echo '<td>'.leading_zeros($barcode_number,8).'</td>';
					if($location=="")
					{
						echo '<td><select name="ref1[]">';
						$sql1="select location_id from $wms.location_db where plant_code='$plantcode' and status=1 order by sno";
						// echo $sql1."<br>";
						$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error-d".mysqli_error($GLOBALS["___mysqli_ston"]));
						echo "<option value=\"\" selected></option>";
						while($sql_row1=mysqli_fetch_array($sql_result1))
						{
							if($sql_row1['location_id']==$location)
							{
								echo "<option value=\"".$sql_row1['location_id']."\" selected>".$sql_row1['location_id']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row1['location_id']."\">".$sql_row1['location_id']."</option>";
							}
						}
						echo '</select></td>';
					}
					else
					{
						echo "<td>$location<input type=\"hidden\" value=\"$location\" name=\"ref1[]\"</td>";
					}
					

					echo "<td>$box</td><td>$qty_rec</td><td>$available";		
					echo '<input type="hidden" name="tid[]" value="'.$tid.'"><input type="hidden" name="available[]" value="'.$available.'"></td>';
					
					if(trim($product_group)=="Fabric")
					{
						if($ref4=="")
						{
								echo '<td><select name="ref4[]">';
								for($i=0;$i<sizeof($shades);$i++)
								{
									if($shades[$i]==$ref4)
									{
										echo "<option value=\"".$shades[$i]."\" selected>".$shades[$i]."</option>";
									}
									else
									{
										echo "<option value=\"".$shades[$i]."\">".$shades[$i]."</option>";
									}
								}
								echo '</select></td>';
						}
						else
						{
							echo "<td>$ref4<input type=\"hidden\" value=\"$ref4\" name=\"ref4[]\"</td>";
						}
						

					
						echo "<td><input type=\"text\" class='form-control' value=\"".$ref3."\" readonly  name=\"ref3[]\"></td>";
						echo "<td><input type=\"text\" class='form-control' value=\"".$ref5."\" readonly name=\"ref5[]\"></td>";
					}
					
				}
				else
				{
					echo '<td>'.leading_zeros($tid,8).'</td>';
					echo "<td>$location</td><td>$box</td><td>$qty_rec</td><td>$available</td>";
				}
				
				
				echo "</tr>";	
			}

			echo "</tbody></table></div>";
			echo '<input type="hidden" name="lot_no" value="'.$lot_no.'">';

			echo '<input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();">Enable &nbsp;<input type="submit" value="Submit" class="btn btn-info" name="put" id="put" onclick="javascript:button_disable();"/></form>';
			echo "<div class='col-md-12'>";
			echo "<h2>Docket Transaction Log:</h2>";


			echo "<table class='table table-striped table-bordered'>";
			echo "<thead><tr class=''><th>date</th><th>Qty</th><th>Box/Roll Number</th><th>Style</th><th>Schedule</th><th>Job No</th><th>Remarks</th><th>User</th></tr></thead>";
			$sql="select store_out.date as date1,store_out.qty_issued as qty,store_in.ref2 as ref2,store_out.style as style,store_out.schedule as schedule,store_out.cutno as jobno, store_out.remarks as remarks,store_out.updated_by as user from $wms.store_out left join $wms.store_in on store_out.tran_tid = store_in.tid where store_out.plant_code='$plantcode' and tran_tid in (select tid from $wms.store_in where store_in.plant_code='$plantcode' and lot_no='".trim($lot_no)."') order by store_in.date";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
			echo "<tbody>";
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$date=$sql_row['date1'];
				$qty=$sql_row['qty'];
				//$style=$sql_row['style'];
				$schedule=$sql_row['schedule'];
				$cutno=$sql_row['jobno'];
				$doc_no = preg_replace('/[^0-9]+/', '', $cutno);
				$doc_str = preg_replace('/[^a-zA-Z]+/', '', $cutno);
				$schedule_no = 0;
				$style_no = 0;
				$remarks=$sql_row['remarks'];
				$user=$sql_row['user'];
				$box_number=$sql_row['ref2'];
				
				echo "<tr><td>$date</td><td>$qty</td><td>$box_number</td><td>$style_no</td><td>$schedule_no</td><td>$cutno</td><td>$remarks</td><td>$user</td></tr>";
				
			}

			echo "</tbody></table></div>";
			echo "<div class='col-md-12'>";
			echo "<h2>MRN Transaction Log:</h2>";
			echo "<table class='table table-striped table-bordered '>";
			echo "<thead><tr class=''><th>Date</th><th>Time</th><th>Style</th><th>Schedule</th><th>Qty</th><th>Box/Roll Number</th><th>Label ID</th><th>Remarks</th><th>User</th><th>Host</th></tr></thead>";
			$mr_tid = implode(',',$MRN_tid);
			if($mr_tid!='')
			{
				$sql2="SELECT DATE(mrn_out_allocation.log_time) as dat,TIME(mrn_out_allocation.log_time) as tim,mrn_out_allocation.mrn_tid as tid,mrn_out_allocation.lot_no as lot,mrn_out_allocation.lable_id as label,mrn_out_allocation.iss_qty as qty,SUBSTRING_INDEX(mrn_out_allocation.updated_user,'^',1) AS username,SUBSTRING_INDEX(mrn_out_allocation.updated_user,'^',-1) AS hostname,store_in.ref2 FROM $wms.mrn_out_allocation left join $wms.store_in on mrn_out_allocation.lable_id = store_in.tid WHERE mrn_out_allocation.plant_code='$plantcode' AND mrn_out_allocation.lable_id in (select tid from $wms.store_in where tid in ($mr_tid))";
				// echo $sql2."<br>";
				$sql_result=mysqli_query($link, $sql2) or exit("No Data In MRN Transaction Log".mysqli_error($GLOBALS["___mysqli_ston"]));

			echo "<tbody>";
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$mrn_date=$sql_row['dat'];	
				$mrn_time=$sql_row['tim'];	
				$mrn_tid=$sql_row['tid'];	
				$mrn_lot=$sql_row['lot'];	
				$mrn_label=$sql_row['label'];	
				$mrn_qty=$sql_row['qty'];	
				$mrn_user=$sql_row['username'];	
				$mrn_host=$sql_row['hostname'];	
				$mrn_ref2 = $sql_row['ref2'];
				
				$sql3="select style,schedule,remarks from $wms.mrn_track where plant_code='$plantcode' and tid=".$mrn_tid."";
				$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error-f".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row3=mysqli_fetch_array($sql_result3))
				{
					$style_val=$sql_row3['style'];
					$schedule_val=$sql_row3["schedule"];
					$remarks=$sql_row3["remarks"];
				}
				
				echo "<tr><td>".$mrn_date."</td><td>".$mrn_time."</td><td>".$style_val."</td><td>".$schedule_val."</td><td>".$mrn_qty."</td><td>".$mrn_ref2."</td><td>".$mrn_label."</td><td>".$remarks."</td><td>".$mrn_user."</td><td>".$mrn_host."</td></tr>";
			}
			echo "</tbody></table></div>";
			}
			}



			?>

			</div>
		</div>
	</div>
</body>
			

<?php

	if(isset($_POST['put']))
	{
		$ref1=$_POST['ref1'];
		$ref4=$_POST['ref4'];
		$ref3=$_POST['ref3'];
		$ref5=$_POST['ref5'];
		$tid=$_POST['tid'];
		$lot_no_new=$_POST['lot_no'];
		$user_name=$_SESSION['SESS_MEMBER_ID'];
		
		for($i=0; $i<sizeof($ref1); $i++)
		{
					
				//Changed to update only locations.	
				$sql="update $wms.store_in set ref1=\"".$ref1[$i]."\",updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plantcode' and tid=".$tid[$i];
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error-g".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			
		}
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = '".getFullURL($_GET['r'],'stock_in_edit_v1.php','N')."&lot_no=".$lot_no_new."'; }</script>";
		
	}

?>
<!-- <script>
$(function() {
  $('#course').on('keydown',function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||(/65|67|86|88/.test(e.keyCode)&&(e.ctrlKey===true||e.metaKey===true))&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
})
</script> -->



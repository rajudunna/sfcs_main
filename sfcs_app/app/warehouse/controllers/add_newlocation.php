<body style="overflow-x:scroll;">
<?php
// for testing
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R')); 
//echo "DB : ".$bai_rm_pj1;exit;
	//getting Location name
	if(isset($_GET['loc_id'])){
		echo "<script>
		$('#form').show();
		</script>";
		$qry_getloc="SELECT location_id FROM $bai_rm_pj1.location_db WHERE sno=".$_GET['loc_id'];
		//echo $qry_getloc;
		$sql_result=mysqli_query($link, $qry_getloc);
		while($sql_row=mysqli_fetch_array($sql_result))
		{
				$loc_id=$sql_row['location_id'];
				$flag_status=$_GET['loc_id'];
		}
		}else{
				$loc_id="";
				$flag_status=0;
		}


		//insetred or updated records

		if(isset($_POST['formsbmt'])){
				
			// echo "Location :".$_POST['loc_name']."</br>";
			// echo "Status :".$_POST['loc_status']."</br>";
			// echo "Flag Status :".$_POST['flag_status']."</br>";
			$location_name=$_POST['loc_name'];
			$location_status=$_POST['loc_status'];
			$product=$_POST['product'];
			if($_POST['flag_status']!=0){
					//validation for existing record
					$qry_valid="SELECT * FROM $bai_rm_pj1.location_db WHERE location_id='$location_name' and status='$location_status'";
					//echo "</br>".$qry_valid."</br>";exit
					$update_qry_valid=mysqli_query($link, $qry_valid);
					$rowcount=mysqli_num_rows($update_qry_valid);
					
					if($rowcount>0){
						//Alert Message for fail
						echo "<script>sweetAlert('Warning','Location Already Existed..','error')</script>";
					}else{
						
						//validating inactive action 
						$qry_validateaction="SELECT SUM(qty_rec) as qty_rec,SUM(qty_issued) as qty_issue,SUM(qty_ret) as qty_ret FROM store_in where ref1='$location_name'";
						$qry_valid_result=mysqli_query($link, $qry_validateaction);
						while($qry_valid_row=mysqli_fetch_array($qry_valid_result))
						{
							$qty_rec=$qry_valid_row['qty_rec'];
							$qty_iss=$qry_valid_row['qty_issue'];
							$qty_ret=$qry_valid_row['qty_ret'];
						}
						//qty validatiion for record editing
						$tot_qty=($qty_rec+$qty_ret-$qty_iss);
						if($tot_qty!='0'){
						
							echo "<script>sweetAlert('Warning','You cant edit this Location...','error')</script>";	

						}else{

							//update qry here
							$sno=$_POST['flag_status'];
							$qry_updateloc="UPDATE $bai_rm_pj1.location_db SET location_id=\"$location_name\",status=\"$location_status\",product=\"$product\" WHERE sno=".$sno;
							$update_locations=mysqli_query($link, $qry_updateloc) or exit("update_buyer_code_qry Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							// $url = getFullURL($_GET['r'],'add_newlocation.php','N');
							// header("Location: ".$url);
							echo "<script>sweetAlert('UPDATE','Location Updated Successfully..','success')</script>";
								
						}

					}
					
			}else{
				
				//validation for existing record
				$qry_valid="SELECT * FROM $bai_rm_pj1.location_db WHERE location_id='$location_name'";
				$update_qry_valid=mysqli_query($link, $qry_valid) or exit("update_buyer_code_qry Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$rowcount=mysqli_num_rows($update_qry_valid);
				
				if($rowcount>0){
					//Alert Message for fail
					echo "<script>sweetAlert('Warning','Location Already Existed..','error')</script>";
				}else{
					//insert qry here
					$qry_insertloc="INSERT INTO $bai_rm_pj1.location_db (location_id,STATUS,product) VALUES ('$location_name','$location_status','$product')";
					$update_locations=mysqli_query($link, $qry_insertloc) or exit("update_buyer_code_qry Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					//$url = getFullURL($_GET['r'],'add_newlocation.php','N');
					//header("Location: ".$url);
					echo "<script>sweetAlert('Success','Location Inserted Successfully..','success')
						$('#table').show();
						$('#form').hide();
					</script>";
				}
				
			}

		}
$url=  getFullURLLevel($_GET['r'],'common/lib/mpdf7/locationlables.php',3,'R');
	echo '<div class="panel panel-primary">';
			echo "<div class='panel-heading'>";
				echo"<span style=\"float\"><strong>Fabric/Trims Locations</strong></a></span>";
			
				echo"<button class='btn btn-success btn-xs pull-right' id='add'>Add Location</button>&nbsp;&nbsp;&nbsp;<a class='btn btn-info btn-xs pull-right' target='_blank' href='$url'><i class='fas fa-file-pdf'></i> Generate Barcodes</a>";
					
			echo"</div>";
			echo '<div class="panel-body">';
				echo'<form method="post" action="?r='.$_GET["r"].'" name="buyer-form">';
				echo "<div class='col-sm-12'>";
					
					if($_GET['product'] == "Fabric"){
						$fabric = "selected";
					}
					if($_GET['product'] == "Trim"){
						$trim = "selected";
					}
					if($_GET['status'] == "Active"){
						$active = "selected";
					}
					if($_GET['status'] == "In Active"){
						$inactive = "selected";
					}
					echo "<div class='pull-left' id='form'>";
						echo'<div class="form-inline">';
							echo'<div class="form-group">';
								echo '<b>Category : </b><select class="form-control" name="product" id="product" required>
									<option></option>
									<option value="Fabric" '.$fabric.'>Fabric</option>
									<option value="Trim" '.$trim.'>Trim</option>
								</select>&nbsp;&nbsp;';
								echo '<b>Location : </b><input type="text" id="loc_name" name="loc_name" class="form-control" size="15" placeholder="Location Name" value="'.$loc_id.'" required>&nbsp;&nbsp;&nbsp;';
								echo '<input type="text" id="flag_status" name="flag_status" value="'.$flag_status.'" /hidden>';
							echo "</div>";
							echo'<div class="form-group">';
								echo "<b>Status : </b>";
								echo'<select name="loc_status" id="loc_status" class="form-control">';
								echo '<option value="1" '.$active.'>Active</option>';
								echo '<option value="0" '.$inactive.'>In Active</option>';
								echo"</select>";
								if($_GET['action'] !== null){
									$type = "Update";
								}else{
									$type = "Add";
								}
							echo"</div>&nbsp;&nbsp;&nbsp;";
								echo '<input type="submit" name="formsbmt" class="btn btn-primary submitbtn" value='.$type.'>';
						echo "</div>";
					echo "</div>";
				echo "</div>";
				echo "<br><br>";
				if($type == "Update"){
					echo "<hr/>";
				}
				echo "</br>";
				echo '<div class="col-sm-12" id="table">';
					echo '<table id="table1" class="table table-bordered">';
						echo "<thead>";
							echo"<tr class='info'>";
								echo"<th>Sl No</th>
								<th>Category</th>
								<th>Location Name</th>
								<th>Status</th>
								<th>Action</th>";                 
							echo"</tr>";
						echo"</thead>";
						echo"<tbody>";
						
						//getting data from locaytion_db in bai rm pj1
						$qry_locations=" select * from $bai_rm_pj1.location_db";
						//echo $qry_locations;
						//mysqli_query($link11, $qry_locations) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_result=mysqli_query($link, $qry_locations);

						while($sql_row=mysqli_fetch_array($sql_result))
						{
							$buyer_data[] = $sql_row;
						}
						foreach ($buyer_data as $key => $value) {
							
							$s_no=($key + 1);
							if($value['status']!=0){
									$loc_status="Active";
									$color="#2cd80d63";
							}else{
								$loc_status="In Active";
								$color="#c30e0e57";
							}
							$product = $value['product'];
							echo "<tr>";
								echo"<td>".$s_no."</td>";
								echo"<td>".$value['product']."</td>";
								echo"<td>".$value['location_id']."</td>";
								echo"<td style='background:".$color."'>".$loc_status."</td>";								
								echo"<td><a style='color:white' href='".getFullURL($_GET['r'],'add_newlocation.php','N')."&action=Update&product=$product&status=$loc_status&loc_id=".$value['sno']."' class='btn btn-primary submitbtn'><i class='fa fa-edit'></i> Edit</a></td>";
							echo"</tr>";
						}
						echo"</tbody>";
					echo "</table>";
				echo"</div>";
			echo"</form>";
			echo "</div>";
	echo "</div>";

?>
</div>
</body>
<style>
td,th{
	color : #000;
}
</style>
<script>
var action = "<?= $_GET['action'] ;?>";

if(action == ""){
	$("#form").hide();
}
$("#add").click(function(){
	$("#form").show();
	$("#table").hide();
});
</script>




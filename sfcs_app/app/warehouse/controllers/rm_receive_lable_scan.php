<html>
	<head>
		<?php 
			include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
			$username_list=explode('\\',$_SERVER['REMOTE_USER']);
			$username=strtolower($username_list[1]);
		?>
	</head>
<?php
if(isset($_POST['check2']))
{
	$plant_name2=$_POST['plant_name'];
	
	
}
else
{
	$plant_name2=$_GET['plant_name'];
	
}
?>	
<body>
<h3 style="font-family:Helvetica Neue,Roboto,Arial,Droid Sans,sans-serif;"><b>RM Warehouse Material Receive</b></h3>
	<form name="input" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form data">
		<?php
			
			$query="SELECT * FROM $bai_pro3.plant_details where plant_code !='$facility_code'";
			$query_result=mysqli_query($link, $query) or exit("Error getting Plant Details");
			echo "<tr>
					<td>Sender Plant Name</td><td>:</td></br>
					<td>
					<select name=\"plant_name\" id='plant_name' required>";
			echo "<option value='' selected disabled>Select Plant Name</option>";
			
			while($row=mysqli_fetch_array($query_result))
			{
				if(str_replace(" ","",$row['plant_code'])==str_replace(" ","",$plant_name2))
				{
					echo "<option value=\"".$row['plant_code']."\" selected>".$row['plant_name']."</option>";
				}
				else
				{
					echo "<option value=\"".$row['plant_code']."\">".$row['plant_name']."</option>";
				}
				// echo "<option value='".$row['plant_code']."'>".$row['plant_name']."</option>";
			}
			echo "</select>
				</td></tr>"; 
		?>
		
		<br/><br/><textarea name="barcode" id='barcode' rows="2" cols="15" onkeydown="document.input.submit();"></textarea>
		
		<br/>
		<br/>
		<input type='text' name='barcode1' placeholder="Label Id" size=13><br/>
		<br/>
		<!-- <input type='text' name='barcode'  onkeypress='return numbersOnly(event)'> -->
		<input type="submit" name="check2" onclick="clickAndDisable(this);" value="Check Out" >
	</form></br>



		<?php
		
			if((isset($_POST['barcode']) && $_POST['barcode']!='') || (isset($_POST['barcode1']) && $_POST['barcode1']!='')){
				
				if($_POST['barcode']!=''){
					$bar_code_new = $_POST['barcode'];
				}else {
					$bar_code_new = $_POST['barcode1'];
				}
				$plant_name1=$_POST['plant_name'];
			
				$query = "select ip_address,port_number,database_type,username,password from $bai_pro3.plant_details where plant_code='".$plant_name1."'";
				$res = mysqli_query($link, $query) or exit($sql."<br/>Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($rm = mysqli_fetch_array($res)){
					$ip_address = $rm['ip_address'];
					$port_number = $rm['port_number'];
					$database_type = $rm['database_type'];
					$user_name = $rm['username'];
					$password = $rm['password'];
					
					
				}
			$host_new=$ip_address.":".$port_number;
			if($database_type=='new'){
					$link_new= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host_new, $user, $pass)) or die("Please Check Plant Details: ".mysqli_error($GLOBALS["___mysqli_ston"]));	 
			}else{	
				$link_new= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host_new, $user_name, $password)) or die("Please Check Plant Details:".mysqli_error($GLOBALS["___mysqli_ston"]));
			}

			

				// $res_get_data_fm_cwh = $link_new->query($qry_get_data_fm_cwh);
			
				//================ get barcode details from CWH DB =============
				if($database_type=='new'){
				$qry_get_data_fm_cwh = "select * from $bai_rm_pj1.store_in where barcode_number='".$bar_code_new."'";
				// echo '<br/>'.$qry_get_data_fm_cwh."<br/>";
				}
				else{
					$qry_get_data_fm_cwh = "select * from $bai_rm_pj1.store_in where tid='".$bar_code_new."'";
	
				}
				$res_get_data_fm_cwh = $link_new->query($qry_get_data_fm_cwh);
				$barcode_data = array();
				$sticker_data1= array();
				if($res_get_data_fm_cwh->num_rows == 0)
				{
					echo "<div class='alert alert-danger'>Sorry!! No Label ID(".$bar_code_new.") found..</div>";
				}
				else if ($res_get_data_fm_cwh->num_rows == 1) 
				{
					while($row = $res_get_data_fm_cwh->fetch_assoc()) 
					{
						$barcode_data = $row;
						$tid_new = $row['tid'];
						break;
					}
					if(count($barcode_data)>0)
					{
						$actual_quentity_present = ($barcode_data['qty_rec']-$barcode_data['qty_issued'])+$barcode_data['qty_ret'];
						//$actual_quentity_present = $barcode_data['qty_rec']-$barcode_data['qty_issued'];
						// echo $actual_quentity_present.'if';
						if (is_numeric($barcode_data['ref5'])) {
							$ref5=$barcode_data['ref5'];
						}
						else{
							$ref5='0';
						}
						if (is_numeric($barcode_data['ref6'])) {
							$ref6=$barcode_data['ref6'];
						}
						else{
							$ref6='0';
						}
						if (is_numeric($barcode_data['ref3'])) {
							$ref3=$barcode_data['ref3'];
						}
						else{
							$ref3='0';
						}
						
						if($actual_quentity_present>0)
						{							
								//=================== check rmwh db with present tid ==================
					
								$qry_check_rm_db = "select * from $bai_rm_pj1.store_in where barcode_number='".$bar_code_new."'";
								$res_check_rm_db = $link->query($qry_check_rm_db);
								if($res_check_rm_db->num_rows == 0)
								{
									// echo $res_check_rm_db->num_rows.'aaaaa';
									//=============== Insert Data in rmwh ==========================
									$qry_insert_update_rmwh_data = "INSERT INTO $bai_rm_pj1.`store_in`(`lot_no`, `qty_rec`, `qty_issued`, `qty_ret`, `date`, `remarks`, `log_stamp`, `status`,`ref2`,`ref3`,`ref4`,`ref5`,`ref6`,`log_user`,`barcode_number`,`ref_tid`) VALUES ('".$barcode_data['lot_no']."','".$actual_quentity_present."','0','0','".date('Y-m-d')."','Directly came from ".$plant_name1."','".date('Y-m-d H:i:s')."','".$barcode_data['status']."','".$barcode_data['ref2']."','$ref3','".$barcode_data['ref4']."','$ref5','$ref6','".$username."^".date('Y-m-d H:i:s')."','".$bar_code_new."','".$tid_new."')";	
									// echo $qry_insert_update_rmwh_data."<br/>";
	
									$res_insert_update_rmwh_data = $link->query($qry_insert_update_rmwh_data);
									
									
									$sticker_report = "select * from $bai_rm_pj1.`sticker_report` where lot_no=".$barcode_data['lot_no']."";
									//echo $sticker_report."<br/>";
									$res_sticker_report_cwh = $link_new->query($sticker_report);
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
									if(count($sticker_data1)==0)
									{
										//these are single culumn replaces
										$pkg_no=str_replace('"','""',$sticker_data['pkg_no']);
										$item_desc=str_replace('"','""',$sticker_data['item_desc']);
										$item_name=str_replace('"','""',$sticker_data['item_name']);
										$qry_insert_sticker_report_data = "INSERT INTO $bai_rm_pj1.`sticker_report` (`item`,`item_name`,`item_desc`,`inv_no`,`po_no`,`rec_no`,`lot_no`,`batch_no`,`buyer`,`product_group`,`doe`,`pkg_no`,`grn_date`,`allocated_qty`,`backup_status`,`supplier`,`uom`,`grn_location`) VALUES (\"".$sticker_data['item']."\",\"".$item_name."\",\"".$item_desc."\",\"".$sticker_data['inv_no']."\",\"".$sticker_data['po_no']."\",\"".$sticker_data['rec_no']."\",\"".$sticker_data['lot_no']."\",\"".$sticker_data['batch_no']."\",\"".$sticker_data['buyer']."\",\"".$sticker_data['product_group']."\",\"".$sticker_data['doe']."\",\"".$pkg_no."\",\"".$sticker_data['grn_date']."\",\"".$sticker_data['allocated_qty']."\",\"".$sticker_data['backup_status']."\",\"".$sticker_data['supplier']."\",\"".$sticker_data['uom']."\",\"".$sticker_data['grn_location']."\")";
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

									
									//echo $qry_insert_update_rmwh_data."<br/>";
									//$res_insert_update_rmwh_data = $conn1->query($qry_insert_update_rmwh_data);
									//=============== insert store_out & update store_in in cwh======================
														
									$qry_ins_stockout = "INSERT INTO $bai_rm_pj1.`store_out`(tran_tid,qty_issued,date,updated_by,remarks) VALUES (".$tid_new.",".$actual_quentity_present.",'".date('Y-m-d')."','".$username."','Send to ".$plant_name."')";
									// echo $qry_ins_stockout."<br/>";
									$res_ins_stockout = $link_new->query($qry_ins_stockout);
									if($database_type=='new'){
									$update_qty_store_in = "update $bai_rm_pj1.store_in set qty_ret=0,qty_issued=".$actual_quentity_present." where barcode_number='".$bar_code_new."'";
									}else{
										$update_qty_store_in = "update $bai_rm_pj1.store_in set qty_ret=0,qty_issued=".$actual_quentity_present." where tid='".$bar_code_new."'";
		
									}
									//echo $update_qty_store_in."<br/>";
									$res_update_qty_store_in = $link_new->query($update_qty_store_in);
									echo "<h3>Status: <font color=Green>Quantity ".$actual_quentity_present." Transferred successfully for Item ID : ".$bar_code_new." and Lot Number : ".$barcode_data['lot_no']."</font></h3>";
									//=====================================================================
									
								}
								else {
									// echo $res_check_rm_db->num_rows.'aaaaa';
									//=============== Insert Data in rmwh ==========================
									// $qry_insert_update_rmwh_data = "INSERT INTO $bai_rm_pj1.`store_in`(`lot_no`, `qty_rec`, `qty_issued`, `qty_ret`, `date`, `remarks`, `log_stamp`, `status`,`ref2`,`ref3`,`ref4`,`ref5`,`ref6`,`log_user`,`barcode_number`,`ref_tid`) VALUES ('".$barcode_data['lot_no']."','".$actual_quentity_present."','0','0','".date('Y-m-d')."','Directly came from ".$plant_name1."','".date('Y-m-d H:i:s')."','".$barcode_data['status']."','".$barcode_data['ref2']."','".$barcode_data['ref3']."','".$barcode_data['ref4']."','".$barcode_data['ref5']."','".$barcode_data['ref6']."','".$username."^".date('Y-m-d H:i:s')."','".$bar_code_new."','".$tid_new."')";	
									// // echo $qry_insert_update_rmwh_data."<br/>";
	
									// $res_insert_update_rmwh_data = $link->query($qry_insert_update_rmwh_data);
									$qry_insert_update_rmwh_data1 = "update $bai_rm_pj1.`store_in` set qty_issued=0,remarks='Directly came from ".$plant_name1."',log_user='".$username."^".date('Y-m-d H:i:s')."' where barcode_number='$bar_code_new'";	
									
										$res_insert_update_rmwh_data1 = $link->query($qry_insert_update_rmwh_data1);
									
									$sticker_report = "select * from $bai_rm_pj1.`sticker_report` where lot_no=".$barcode_data['lot_no']."";
									//echo $sticker_report."<br/>";
									$res_sticker_report_cwh = $link_new->query($sticker_report);
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
									
									$qry_check_rm_db1 = "select * from $bai_rm_pj1.store_in where barcode_number='".$bar_code_new."'";
									$res_check_rm_db1 = $link->query($qry_check_rm_db1);
									
									
									
									while($row1 = $res_check_rm_db1->fetch_assoc()) 
									{
										$tid_old=$row1['tid'];
										$delete_qry= "delete from $bai_rm_pj1.store_out where tran_tid=$tid_old";
										$delete_qry_result = $link->query($delete_qry);
									}
									
									//echo "<br/>No of rows:".$row12."<br/>";
									//echo "<br/>result:".count($sticker_data1)."<br/>";
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
									
									$qry_ins_stockout = "INSERT INTO $bai_rm_pj1.`store_out`(tran_tid,qty_issued,date,updated_by,remarks) VALUES (".$tid_new.",".$actual_quentity_present.",'".date('Y-m-d')."','".$username."','Send to ".$plant_name."')";
									// echo $qry_ins_stockout."<br/>";
									$res_ins_stockout = $link_new->query($qry_ins_stockout);
									if($database_type=='new'){
									$update_qty_store_in = "update $bai_rm_pj1.store_in set qty_ret=0,qty_issued=".$actual_quentity_present." where barcode_number='".$bar_code_new."'";
									}else{
										$update_qty_store_in = "update $bai_rm_pj1.store_in set qty_ret=0,qty_issued=".$actual_quentity_present." where tid='".$bar_code_new."'";
		
									}
									//echo $update_qty_store_in."<br/>";
									$res_update_qty_store_in = $link_new->query($update_qty_store_in);
									echo "<h3>Status: <font color=Green>Quantity ".$actual_quentity_present." Transferred successfully for Item ID : ".$bar_code_new." and Lot Number : ".$barcode_data['lot_no']."</font></h3>";
									//=====================================================================
								}
							
						}
						else
						{
						
							echo "<h3>Status: <font color=Red>Insufficient Quantity.</font></h3>";
						}
					}
					else
					{
						echo "<h3>Status: <font color=Red>Sorry!! No Label ID found..</font></h3>";
					}
				} 
				else 
				{
					echo "<h3>Status: <font color=red>There are multiple Label Ids. System Can't pick the value. Please Contact Central RM Warehouse Team.</font></h3>";
				}

			}
		?>
</body>

<script>
		window.onload = function() 
		{
		document.getElementById("barcode").focus();
		};
		</script>
		<script>
			function test(){
				if($('#plant_name').val() != null){
					document.input.submit();
				}else {
					sweetAlert('','Select Plant Name','Warning');
				}
			}
		function numbersOnly()
		{
		   var charCode = event.keyCode;

					if (charCode >= 48 && charCode < 58)

						return true;
					else
						return false;
		}
		</script>
</html>
<script> 
   function clickAndDisable(link) {
     // disable subsequent clicks
     link.onclick = function(event) {
        event.preventDefault();
     }
   }   
</script>
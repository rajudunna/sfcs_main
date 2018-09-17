
<?php 
$url = getFullURLLevel($_GET['r'],'common/config/config.php',3,'R');
include($_SERVER['DOCUMENT_ROOT'].'/'.$url); 

?>


<?php
/* $sql="select * from cuttable_stat_log where order_tid=\"$tran_order_tid\"";
mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_num_check=mysql_num_rows($sql_result); */

// $database="bai_rm_pj1";
// $user=$host_adr_un;
// $password=$host_adr_pw;
// $host=$host_adr;
//$database="bainet33";
//$user="bainet";
//$password="bainet";
//$host="localhost";
error_reporting(0);
// $link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
//  mysqli_select_db($link, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

 
//NOTE: MAKE SURE YOU DO YOUR OWN APPROPRIATE SERVERSIDE ERROR CHECKING HERE!!!
if(!empty($_POST['put']) && isset($_POST['put']))
{
	$lot_no=$_POST['lot_no'];
	$query="SELECT uom FROM $bai_rm_pj1.sticker_report where lot_no='$lot_no'";
	$query_result=mysqli_query($link, $query) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$uom = mysqli_fetch_row($query_result);
	$uom = $uom[0];
	
	if($_FILES['file']['name'])
	{		
		$query="SELECT DISTINCT upload_file FROM $bai_rm_pj1.store_in";
		$query_result=mysqli_query($link, $query) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		// echo $query_result;
	
		while($query_result1=mysqli_fetch_array($query_result))
		{
			$file_name[].=$query_result1['upload_file'];
		}
		$url = getFullURL($_GET['r'],'insert_v1.php','N');
		$convert=$_POST['convert'];
		$date=$_POST['date'];
		$ref1=$_POST['ref1'];
		$ref2=$_POST['ref2'];
		$ref3=$_POST['ref3'];
		$qty=$_POST['qty'];
		$lot_no=$_POST['lot_no'];
		$remarks=$_POST['remarks'];
		$user_name=$_SESSION['SESS_MEMBER_ID'];
		$available=$_POST['available'];
		$username=getrbac_user()['uname'];		
		$filename = explode(".",$_FILES['file']['name']);		
		$upload_file= $filename[0];
		//echo $upload_file;	
		//die();
		if (in_array($upload_file, $file_name))
		{
			echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color='red'>Upload File Name : (".$upload_file.") Already Existed</font></h1></center></div>";
			echo "<div id=\"msg\"><a href='".getFullURL($_GET['r'],'insert_v1.php','N')."'><center><br/><br/><br/><h3><font color='blue'>Back to Stock In Screen</font></h3></center></a></div>";
			//echo .getFullURL($_GET['r'],'insert_v1.php').;
			//die();
		}
		else
		{	
			try{
				if($filename[1]=='csv')
				{
					
						$handle = fopen($_FILES['file']['tmp_name'],"r");
						$flag = true;
						$sql1 = "insert into $bai_rm_pj1.store_in (lot_no, ref1, ref2, qty_rec, date, remarks, log_user) values ";
						$values = array();
						$total_qty=0;
						$iro_cnt = 0;
						while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
						{
							if($flag) { $flag = false; continue; }
							$item1 = $data[0];
							$item2 = $data[1];	
								//if the entry from excel file is not an nummeric or is -ve then quitting process	
								if(!is_numeric($item2)){
									throw new Exception('Error');
								}
								if($item2 < 0){
									throw new Exception('Error');
								}
							if($convert==1)
							{
								if($fab_uom == "meters"){
									if($uom == "YRD"){
										$item2=round($item2*0.9144,2);
									}
								}
								if($fab_uom == "yards"){
									if($uom == "MTR"){
										$item2=round($item2*1.09361,2);
									}
								}
								
							
							}
						
							// $sql1 = "insert into bai_rm_pj1.store_in (lot_no, ref1, ref2, qty_rec, date, remarks, log_user,upload_file) values ( '$lot_no','$ref1', '$item1','$item2', '$date','$remarks','$user_name','$upload_file')";
							
							array_push($values, "('" . $lot_no . "','" . $ref1 . "','" . $item1 . "','" . $item2 . "','" . $date . "','" . $remarks . "','".$username."-".$plant_name."')");
							$total_qty=$total_qty+$item2;
							$iro_cnt++;
						}
						if($convert==1)
						{
							if($fab_uom == "meters"){
								if($uom == "YRD"){
									$total_qty=round($total_qty*0.9144,2);
								}
							}
							if($fab_uom == "yards"){
								if($uom == "MTR"){
									$total_qty=round($total_qty*1.09361,2);
								}
							}
						}
							
						if($total_qty>$available)
						{
							echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color='red'>input qty(".$total_qty.") more than balance qty</font></h1></center></div>";
							$url = getFullURL($_GET['r'],'insert_v1.php','N');
							echo "<a class='btn btn-primary' href='$url&lot_no=$lot_no'><center><br/><br/><br/><h3><font color='blue'>Back to Stock In Screen</font></h3></center></a>";
						}
						else
						{
							
							if($is_chw=='yes'){
								$sql_result1=mysqli_query($cwh_link, $sql1 . implode(', ', $values)) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
								$last_id_ref = mysqli_insert_id($cwh_link);
							//echo $last_id;
							$for_last_val = $last_id_ref+$iro_cnt;
							for($last_id=$last_id_ref;$last_id<$for_last_val;$last_id++){
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
								$qry_insert_update_rmwh_data = "INSERT INTO $bai_rm_pj1.`store_in`(`tid`,`lot_no`, `qty_rec`, `qty_issued`, `qty_ret`, `date`, `remarks`, `log_stamp`, `status`,`ref2`,`ref3`,`ref4`,`ref5`,`ref6`,`log_user`) VALUES ('".$last_id."','".$barcode_data['lot_no']."','".$actual_quentity_present."','0','0','".date('Y-m-d')."','Directly came from CWH','".date('Y-m-d H:i:s')."','".$barcode_data['status']."','".$barcode_data['ref2']."','".$barcode_data['ref3']."','".$barcode_data['ref4']."','".$barcode_data['ref5']."','".$barcode_data['ref6']."','".$username."-".$plant_name."^".date('Y-m-d H:i:s')."')";	
								//echo $qry_insert_update_rmwh_data."<br/>";
								$res_insert_update_rmwh_data = $link->query($qry_insert_update_rmwh_data);
								
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
									
									if(count($sticker_data)==0){
										//$total=$sticker_data3['rec_qty']-$rec_qty['qty_rec'];
										$total=$rec_qty['qty_rec'];
										$sticker_data_query="INSERT INTO $bai_rm_pj1.`sticker_report` (`item`,`item_name`,`item_desc`,`inv_no`,`po_no`,`rec_no`,`lot_no`,`batch_no`,`buyer`,`product_group`,`doe`,`pkg_no`,`grn_date`,`allocated_qty`,`backup_status`,`supplier`,`uom`,`grn_location`,rec_qty) VALUES ('".$sticker_data3['item']."','".$sticker_data3['item_name']."','".$sticker_data3['item_desc']."','".$sticker_data3['inv_no']."','".$sticker_data3['po_no']."','".$sticker_data3['rec_no']."','".$sticker_data3['lot_no']."','".$sticker_data3['batch_no']."','".$sticker_data3['buyer']."','".$sticker_data3['product_group']."','".$sticker_data3['doe']."','".$sticker_data3['pkg_no']."','".$sticker_data3['grn_date']."','".$sticker_data3['allocated_qty']."','".$sticker_data3['backup_status']."','".$sticker_data3['supplier']."','".$sticker_data3['uom']."','".$sticker_data3['grn_location']."','".$total."')";
										$sticker_data_result = $cwh_link->query($sticker_data_query);
									
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
								$qty_rec_store_report1 = $cwh_link->query($qty_rec_store_report);
								while($row2 = $qty_rec_store_report1->fetch_assoc()) 
								{
									$rec_qty = $row2;
									break;
								}
								
								 $qry_insert_sticker_report1_data = "update $bai_rm_pj1.`sticker_report` set rec_qty=\"".$rec_qty['qty_rec']."\" where lot_no=\"".$sticker_data['lot_no']."\"";
								//echo $qry_insert_sticker_report1_data."<br/>";
								
								$qry_insert_sticker_report1_data1 = $cwh_link->query($qry_insert_sticker_report1_data);
								
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
								
								
								
								$qty_rec_store_report = "select sum(qty_rec)as qty_rec from $bai_rm_pj1.`store_in` where lot_no=".$barcode_data['lot_no']."";
								//echo $qty_rec_store_report."<br/>";
								$qty_rec_store_report1 = $link->query($qty_rec_store_report);
								while($row2 = $qty_rec_store_report1->fetch_assoc()) 
								{
									$rec_qty = $row2;
									break;
								}
								
								
								
							}
													
							$qry_ins_stockout = "INSERT INTO $bai_rm_pj1.`store_out`(tran_tid,qty_issued,date,updated_by) VALUES (".$last_id.",".$actual_quentity_present.",'".date('Y-m-d')."','".$username."-".$plant_name."')";
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
				
							}else{
								$sql_result1=mysqli_query($link, $sql1 . implode(', ', $values)) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
							fclose($handle);
							// echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color='red'>Stock Updated Successfully.... Please Wait</font></h1></center></div>";
							  
							$ext = $filename[1]; // get the extension of the file
							$newname = "$upload_file"."."."$ext";
							$path_new=$_SERVER['DOCUMENT_ROOT'].getFullURL($_GET['r'],"Upload_files/$newname","R");
							 //echo $path_new;
							move_uploaded_file($_FILES["file"]["tmp_name"],$path_new);
							
				
			}  
						//	echo "<script>sweetAlert('Stock Updated Successfully...','Please Wait','success')</script>";
						echo "<script>
							swal({
								title: 'Stock Updated Successfully',
								text: 'please wait...',
								type: 'warning',
								buttons:false,
							  })
							</script>";
	
							echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url&lot_no=$lot_no\"; }</script>";
							// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"insert_v1.php?lot_no=$lot_no\"; }</script>";
						


					

				}else{
					echo "<script>sweetAlert('File format not supported','please upload .csv format','warning')</script>";
				}
			}catch(Exception $e){
				echo "<script>sweetAlert('Uploaded File has invalid quantities','please verify','warning'); </script>";
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"$url&lot_no=$lot_no\"; }</script>";
			}
		}				
	}
	else
	{
		$convert=$_POST['convert'];
		$date=$_POST['date'];
		$ref1=$_POST['ref1'];
		$ref2=$_POST['ref2'];
		$ref3=$_POST['ref3'];
		$qty=$_POST['qty'];
		$lot_no=$_POST['lot_no'];
		$remarks=$_POST['remarks'];
		$user_name=$_SESSION['REMOTE_USER'];
		$available=$_POST['available'];
		$username=getrbac_user()['uname'];
		$total_qty=array_sum($qty);


		if($convert==1)
		{
			if($fab_uom == "meters"){
				if($uom == "YRD"){
					$total_qty=round($total_qty*0.9144,2);
				}
			}
			if($fab_uom == "yards"){
				if($uom == "MTR"){
					$total_qty=round($total_qty*1.09361,2);
				}
			}
		}




		if($total_qty>$available)
		{
			//echo $total_qty;
			//echo "<font color=red>input qty :".$total_qty." more than available</font>";
			echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color='red'>input qty(".$total_qty.") more than available</font></h1></center></div>";
			$url = getFullURL($_GET['r'],'insert_v1.php','N');
			echo "<a href='$url&lot_no=$lot_no'><center><br/><br/><br/><h3><font color='blue'>Back to Stock In Screen</font></h3></center></a>";
		}
		else
		{
			$qty_count = 0;
			for($i=0;$i<100;$i++)
			{
				if($qty[$i]>0)
				{
					//query to insert data into table
					if($convert==1)
					{
						if($fab_uom == "meters"){
							if($uom == "YRD"){
								$qty[$i]=round($qty[$i]*0.9144,2);
							}
						}
						if($fab_uom == "yards"){
							if($uom == "MTR"){
								$qty[$i]=round($qty[$i]*1.09361,2);
							}
						}
					}
					if($is_chw == 'yes'){
						$sql="insert into $bai_rm_pj1.store_in (lot_no, ref1, ref2, ref3, qty_rec, date, remarks, log_user) values ('$lot_no', '$ref1', '$ref2[$i]', '$ref3[$i]', $qty[$i], '$date', '$remarks','$username')";
					$sql_result=mysqli_query($cwh_link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$qty_count += 1;
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
						$qry_insert_update_rmwh_data = "INSERT INTO $bai_rm_pj1.`store_in`(`tid`,`lot_no`, `qty_rec`, `qty_issued`, `qty_ret`, `date`, `remarks`, `log_stamp`, `status`,`ref2`,`ref3`,`ref4`,`ref5`,`ref6`,`log_user`) VALUES ('".$last_id."','".$barcode_data['lot_no']."','".$actual_quentity_present."','0','0','".date('Y-m-d')."','Directly came from CWH','".date('Y-m-d H:i:s')."','".$barcode_data['status']."','".$barcode_data['ref2']."','".$barcode_data['ref3']."','".$barcode_data['ref4']."','".$barcode_data['ref5']."','".$barcode_data['ref6']."','".$username."-".$plant_name."^".date('Y-m-d H:i:s')."')";	
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
						//$total=$rec_qty['qty_rec'];

						if(count($sticker_data)==0){
							//$total=$sticker_data3['rec_qty']-$rec_qty['qty_rec'];
							$total=$rec_qty['qty_rec'];
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
						$qty_rec_store_report1 = $cwh_link->query($qty_rec_store_report);
						while($row2 = $qty_rec_store_report1->fetch_assoc()) 
						{
							$rec_qty = $row2;
							break;
						}
						
						 $qry_insert_sticker_report1_data = "update $bai_rm_pj1.`sticker_report` set rec_qty=\"".$rec_qty['qty_rec']."\" where lot_no=\"".$sticker_data['lot_no']."\"";
						//echo $qry_insert_sticker_report1_data."<br/>";
						
						$qry_insert_sticker_report1_data1 = $cwh_link->query($qry_insert_sticker_report1_data);
						
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
						
						if(count($sticker_data1)==0)
						{
							$qry_insert_sticker_report_data = "INSERT INTO $bai_rm_pj1.`sticker_report` (`item`,`item_name`,`item_desc`,`inv_no`,`po_no`,`rec_no`,`rec_qty`,`lot_no`,`batch_no`,`buyer`,`product_group`,`doe`,`pkg_no`,`grn_date`,`allocated_qty`,	`backup_status`,`supplier`,`uom`,`grn_location`) VALUES ('".$sticker_data['item']."','".$sticker_data['item_name']."','".$sticker_data['item_desc']."','".$sticker_data['inv_no']."','".$sticker_data['po_no']."','".$sticker_data['rec_no']."','".$sticker_data['lot_no']."','".$sticker_data['batch_no']."','".$sticker_data['buyer']."','".$sticker_data['product_group']."','".$sticker_data['doe']."','".$sticker_data['pkg_no']."','".$sticker_data['grn_date']."','".$sticker_data['allocated_qty']."','".$sticker_data['backup_status']."','".$sticker_data['supplier']."','".$sticker_data['uom']."','".$sticker_data['grn_location']."')";
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
						
						
						// $qry_insert_sticker_report1_data = "update $bai_rm_pj1.`sticker_report` set rec_qty=\"".$rec_qty['qty_rec']."\",rec_no=\"".$sticker_data['rec_no']."\",inv_no=\"".$sticker_data['inv_no']."\",batch_no=\"".$sticker_data['batch_no']."\" where lot_no=\"".$sticker_data['lot_no']."\"";
						// //echo $qry_insert_sticker_report1_data."<br/>";
						$qry_insert_sticker_report1_data1 = $link->query($qry_insert_sticker_report1_data);	
					}
											
					$qry_ins_stockout = "INSERT INTO $bai_rm_pj1.`store_out`(tran_tid,qty_issued,date,updated_by) VALUES (".$last_id.",".$actual_quentity_present.",'".date('Y-m-d')."','".$username."-".$plant_name."')";
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
									
					}else{
						$sql="insert into $bai_rm_pj1.store_in (lot_no, ref1, ref2, ref3, qty_rec, date, remarks, log_user) values ('$lot_no', '$ref1', '$ref2[$i]', '$ref3[$i]', $qty[$i], '$date', '$remarks','".$username."-".$plant_name."')";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$qty_count += 1;
					}
					
				}

				// if(!$sql_result)
				// {
				// 	echo "Failed to insert record<br/>";
				// }
				// else
				// {
				// 	echo "Record inserted successfully<br/>";
				// } 
			}
			if($qty_count > 0){
				echo "<script>
						swal({
							title: 'Stock Updated Successfully',
							text: 'please wait...',
							type: 'warning',
							buttons:false,
						  })
						</script>";
				//echo "<script>sweetAlert('Stock Updated Successfully....','Please Wait','success');</script>";
			}else{
				echo "<script>sweetAlert('Please fill atleast one roll','','error');</script>";
			}
			//echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color='green'>Stock Updated Successfully.... Please Wait</font></h1></center></div>";
			$url = getFullURL($_GET['r'],'insert_v1.php','N');
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() { location.href = \"$url&lot_no=$lot_no\"; }</script>";
		}	
	}
}
?>

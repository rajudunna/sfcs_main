<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
$plant_code = $_SESSION['plantCode'];
$username = $_SESSION['userName'];
if(!empty($_POST['put']) && isset($_POST['put']))
{
	$lot_no=$_POST['lot_no'];
	$query="SELECT uom FROM $wms.sticker_report where plant_code='$plant_code' AND lot_no='$lot_no'";
	$query_result=mysqli_query($link, $query) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$uom = mysqli_fetch_row($query_result);
	$uom = $uom[0];
	
	if($_FILES['file']['name'])
	{		
		$query="SELECT DISTINCT upload_file FROM $wms.store_in where plant_code='$plant_code'";
		$query_result=mysqli_query($link, $query) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		// echo $query_result;
	
		while($query_result1=mysqli_fetch_array($query_result))
		{
			$file_name[].=$query_result1['upload_file'];
		}
		$url = getFullURL($_GET['r'],'insert_v1.php','N');
		//echo $url;
		//die();
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
				  
		$filename = explode(".",$_FILES['file']['name']);		
		$upload_file= $filename[0];
			
		if (in_array($upload_file, $file_name))
		{
			echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color='red'>Upload File Name : (".$upload_file.") Already Existed</font></h1></center></div>";
			echo "<div id=\"msg\"><a href='".getFullURL($_GET['r'],'insert_v1.php')."'><center><br/><br/><br/><h3><font color='blue'>Back to Stock In Screen</font></h3></center></a></div>";
		}
		else
		{	
			try{
				if($filename[1]=='csv')
				{
					$handle = fopen($_FILES['file']['tmp_name'],"r");
					$flag = true;
					$sql1 = "insert into $wms.store_in (tid,lot_no, ref1, ref2, qty_rec, date, remarks, log_user,upload_file,plant_code,created_user,updated_user) values ";
					$values = array();
					$total_qty=0;

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
							if($uom == "MTR"){
								$item2=round($item2*1.09361,2);
							}
						
						}
					
						// $sql1 = "insert into bai_rm_pj1.store_in (lot_no, ref1, ref2, qty_rec, date, remarks, log_user,upload_file) values ( '$lot_no','$ref1', '$item1','$item2', '$date','$remarks','$user_name','$upload_file')";
						$select_uuid="SELECT UUID() as uuid";
                        $uuid_result=mysqli_query($link_new, $select_uuid) or exit("Sql Error at select_uuid".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($uuid_row=mysqli_fetch_array($uuid_result))
                        {
                            $uuid=$uuid_row['uuid'];
                        
                        }
						array_push($values, "('" . $uuid . "','" . $lot_no . "','" . $ref1 . "','" . $item1 . "','" . $item2 . "','" . $date . "','" . $remarks . "','" . $user_name . "','" . $upload_file . "','" . $plant_code . "','" . $created_user . "','" . $created_user . "')");
						$total_qty=$total_qty+$item2;
					}
					if($convert==1)
					{
						if($uom == "MTR"){
							$total_qty=round($total_qty*1.09361,2);
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
						$sql_result1=mysqli_query($link, $sql1 . implode(', ', $values)) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						fclose($handle);
						// echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color='red'>Stock Updated Successfully.... Please Wait</font></h1></center></div>";

						$ext = $filename[1]; // get the extension of the file
						$newname = "$upload_file"."."."$ext";
						$path_new="../".getFullURL($_GET['r'],"Upload_files/$newname","R");
						move_uploaded_file($_FILES["file"]["tmp_name"],$path_new);

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
					}	
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
		$user_name=$_SESSION['SESS_MEMBER_ID'];
		$available=$_POST['available'];

		$total_qty=array_sum($qty);


		if($convert==1)
		{
			if($uom == "MTR"){
				$total_qty=round($total_qty*1.09361,2);
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
						if($uom == "MTR"){
							$qty[$i]=round($qty[$i]*1.09361,2);
						}
					}

					$select_uuid="SELECT UUID() as uuid";
					$uuid_result=mysqli_query($link_new, $select_uuid) or exit("Sql Error at select_uuid".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($uuid_row=mysqli_fetch_array($uuid_result))
					{
						$uuid=$uuid_row['uuid'];
					
					} 

					$sql="insert into $wms.store_in (tid,lot_no, ref1, ref2, ref3, qty_rec, date, remarks, log_user,plant_code,created_user,updated_user) values ('$uuid','$lot_no', '$ref1', '$ref2[$i]', '$ref3[$i]', $qty[$i], '$date', '$remarks','$user_name','$plant_code','$username','$username')";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$qty_count += 1;
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

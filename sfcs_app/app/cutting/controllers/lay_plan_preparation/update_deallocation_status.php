<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/global_error_function.php',4,'R'));
	$main_url=getFullURL($_GET['r'],'update_deallocation_status.php','R');
    $id=$_GET['id'];
    $plant_code=$_GET['plant_code'];
    $username=$_GET['username'];

    $is_requested="SELECT doc_no FROM $wms.material_deallocation_track WHERE id=$id and plant_code='".$plant_code."'";
    $is_requested_result=mysqli_query($link, $is_requested) or exit("Sql Error0: fabric_status_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
	log_statement('debug',$is_requested,$main_url,__LINE__);
	log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
    while($sql_row1=mysqli_fetch_array($is_requested_result))
    {
        $doc_no=$sql_row1['doc_no'];
		$fab_qry1="SELECT fabric_status FROM $pps.requested_dockets WHERE doc_no=$doc_no and plant_code='".$plant_code."'";
        $fab_qry_result1=mysqli_query($link, $fab_qry1) or exit("Sql Error1: fabric_cad_allocation".mysqli_error($GLOBALS["___mysqli_ston"]));
		log_statement('debug',$fab_qry1,$main_url,__LINE__);
		log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
        if(mysqli_num_rows($fab_qry_result1)>0)
        {
			while($sql_row12=mysqli_fetch_array($fab_qry_result1))
			{
				$fstatus=$sql_row12['fabric_status'];
			}
		}
		
		if($fstatus<5)
		{
			$fab_qry="SELECT allocated_qty,roll_id FROM $wms.fabric_cad_allocation WHERE doc_no='$doc_no' plant_code='".$plant_code."'";
			// echo $fab_qry."<br>";
			$fab_qry_result=mysqli_query($link, $fab_qry) or exit("Sql Error1: fabric_cad_allocation".mysqli_error($GLOBALS["___mysqli_ston"]));
			log_statement('debug',$fab_qry,$main_url,__LINE__);
			log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
			if(mysqli_num_rows($fab_qry_result)>0)
			{
				while($sql_row1=mysqli_fetch_array($fab_qry_result))
				{
					$allocated_qty=$sql_row1['allocated_qty'];
					$roll_id=$sql_row1['roll_id'];
											   
					$sql="update $wms.store_in set qty_allocated=qty_allocated-".$allocated_qty.",updated_user='$username',updated_at='NOW()' where tid=".$roll_id." and plant_code='".$plant_code."'";
					mysqli_query($link, $sql) or exit("Sql Error2: delete fabric_cad_allocation".mysqli_error($GLOBALS["___mysqli_ston"]));
					log_statement('debug',$sql,$main_url,__LINE__);
					log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
					$query_status="SELECT qty_rec,qty_issued,qty_ret,qty_allocated FROM $wms.store_in WHERE tid='$roll_id' and plant_code='".$plant_code."'";
					//echo $query_status;
					$query_status_res=mysqli_query($link, $query_status) or exit("Sql Error6: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
					log_statement('debug',$query_status,$main_url,__LINE__);
					log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
					while($qry_status_result=mysqli_fetch_array($query_status_res))
					{
						$qty_allocated=$qry_status_result['qty_allocated'];
					}
					if($qty_allocated==0)
					{
						$status_new=0;
						$sql44="update $wms.store_in set status=$status_new, allotment_status=$status_new,updated_user='$username',updated_at='NOW()' where tid='$roll_id' and plant_code='".$plant_code."'";
						//echo $sql44."</br>";
						mysqli_query($link, $sql44) or exit("Sql Error44".mysqli_error($GLOBALS["___mysqli_ston"]));
						log_statement('debug',$sql44,$main_url,__LINE__);
						log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
					}
				}
				
				$delete_fab="delete from $wms.fabric_cad_allocation WHERE doc_no='$doc_no' and plant_code='".$plant_code."'";
				$delete_fab_result=mysqli_query($link, $delete_fab) or exit("Sql Error2: delete fabric_cad_allocation".mysqli_error($GLOBALS["___mysqli_ston"]));
				log_statement('debug',$delete_fab,$main_url,__LINE__);
				log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
				
				$update_plan_qry="update $pps.requested_dockets set plan_lot_ref='',print_status='',fabric_status=0,updated_user='$username',updated_at='NOW()' where doc_no=".$doc_no." and plant_code='".$plant_code."'";
				$update_plan_qry_fab_result=mysqli_query($link, $update_plan_qry) or exit("Sql Error5: update plan".mysqli_error($GLOBALS["___mysqli_ston"]));
				log_statement('debug',$update_plan_qry,$main_url,__LINE__);
				log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
				
				// $update_plan_qry_p="update $bai_pro3.plan_dashboard set fabric_status=0 where doc_no=".$doc_no;
				// $update_plan_qry_fab_resultp=mysqli_query($link, $update_plan_qry_p) or exit("Sql Error51: update plan".mysqli_error($GLOBALS["___mysqli_ston"]));

				$username = getrbac_user()['uname'];
				$approve_at = date("Y-m-d H:i:s");

				$update_req_qry = "update $wms.material_deallocation_track set approved_by='".$username."',approved_at='".$approve_at."',status='Deallocated',updated_user='$username',updated_at='NOW()' where id=".$id." and plant_code='".$plant_code."'";
				$update_req_qry_result=mysqli_query($link, $update_req_qry) or exit("Sql Error2: material_deallocation_track".mysqli_error($GLOBALS["___mysqli_ston"]));
				log_statement('debug',$update_req_qry,$main_url,__LINE__);
				log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);

				echo "<script>swal('sucess','Material De-Allocated Successfully','success')</script>";
				
				$url = getFullUrlLevel($_GET['r'],'material_deallocation.php',0,'N');
				echo "<script>setTimeout(function(){
							location.href='$url' 
						},2000);
						</script>";
				exit();
			}
        }
		else 
		{			
			// $username = getrbac_user()['uname'];
			$approve_at = date("Y-m-d H:i:s");

			$update_req_qry = "update $wms.material_deallocation_track set approved_by='".$username."',approved_at='".$approve_at."',status='closed by system',updated_user='$username',updated_at='NOW()' where id=".$id." and plant_code='".$plant_code."'";
			$update_req_qry_result=mysqli_query($link, $update_req_qry) or exit("Sql Error2: material_deallocation_track".mysqli_error($GLOBALS["___mysqli_ston"]));
			log_statement('debug',$update_req_qry,$main_url,__LINE__);
			log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
            echo "<script>swal('Error','Material is Issued to Cutting','error')</script>";
            $url = getFullUrlLevel($_GET['r'],'material_deallocation.php',0,'N');
            echo "<script>setTimeout(function(){
                        location.href='$url' 
                    },2000);
                    </script>";
            exit();
        }
    }
    
?>
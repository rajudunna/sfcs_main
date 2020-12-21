<?php
function exception($sql_result)
{
	throw new Exception($sql_result);
}
?>
<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/global_error_function.php',4,'R'));
	$main_url=getFullURL($_GET['r'],'update_deallocation_status.php','R');
    $id=$_GET['id'];
    $plant_code=$_GET['plant_code'];
    $username=$_GET['username'];
try
{
	$is_requested="SELECT doc_no FROM $wms.material_deallocation_track WHERE id=$id and plant_code='".$plant_code."'";

    $is_requested_result=mysqli_query($link, $is_requested) or die(exception($is_requested));
    while($sql_row1=mysqli_fetch_array($is_requested_result))
    {
		$doc_no=$sql_row1['doc_no'];
		$docket_qry="SELECT jm_docket_id FROM $pps.jm_dockets WHERE docket_number='$doc_no' and plant_code='".$plant_code."'";
		$docket_qry_result=mysqli_query($link, $docket_qry) or die(exception($docket_qry));
		while($sql_row01=mysqli_fetch_array($docket_qry_result))
		{
			$jm_docket_id = $sql_row01['jm_docket_id'];
		}
		$fab_qry1="SELECT fabric_status FROM $pps.requested_dockets WHERE plant_code='".$plant_code."' and jm_docket_id='$jm_docket_id'";

        $fab_qry_result1=mysqli_query($link, $fab_qry1) or die(exception($fab_qry1));
        if(mysqli_num_rows($fab_qry_result1)>0)
        {
			while($sql_row12=mysqli_fetch_array($fab_qry_result1))
			{
				$fstatus=$sql_row12['fabric_status'];
			}
		}
		
		if($fstatus<5)
		{
			$fab_qry="SELECT allocated_qty,roll_id FROM $wms.fabric_cad_allocation WHERE doc_no='$doc_no' and plant_code='".$plant_code."'";
			//  echo $fab_qry."<br>";
			$fab_qry_result=mysqli_query($link, $fab_qry) or die(exception($fab_qry));
			$sql_num_check=mysqli_num_rows($fab_qry_result);
			
			if($sql_num_check>0)
			{
				while($sql_row1=mysqli_fetch_array($fab_qry_result))
				{
					
					$allocated_qty=$sql_row1['allocated_qty'];
					$roll_id=$sql_row1['roll_id'];
											   
					$sql="update $wms.store_in set qty_allocated=qty_allocated-".$allocated_qty.",updated_user='$username',updated_at=NOW() where tid=".$roll_id." and plant_code='".$plant_code."'";
					mysqli_query($link, $sql)or die(exception($sql));
					$query_status="SELECT qty_rec,qty_issued,qty_ret,qty_allocated FROM $wms.store_in WHERE tid='$roll_id' and plant_code='".$plant_code."'";
					//echo $query_status;
					$query_status_res=mysqli_query($link, $query_status) or die(exception($query_status));
					while($qry_status_result=mysqli_fetch_array($query_status_res))
					{
						$qty_allocated=$qry_status_result['qty_allocated'];
					}
					if($qty_allocated==0)
					{
						$status_new=0;
						$sql44="update $wms.store_in set status=$status_new, allotment_status=$status_new,updated_user='$username',updated_at=NOW() where tid='$roll_id' and plant_code='".$plant_code."'";
						//echo $sql44."</br>";
						mysqli_query($link, $sql44) or die(exception($sql44));
					}
				}
				
				$delete_fab="delete from $wms.fabric_cad_allocation WHERE doc_no='$doc_no' and plant_code='".$plant_code."'";
				$delete_fab_result=mysqli_query($link, $delete_fab)or die(exception($delete_fab));

				
				$update_plan_qry="update $pps.requested_dockets set plan_lot_ref='',print_status=NOW(),fabric_status=0,updated_user='$username',updated_at=NOW() where plant_code='".$plant_code."' and jm_docket_id='".$jm_docket_id."'";
				// $update_plan_qry_fab_result=mysqli_query($link, $update_plan_qry) or die(exception($update_plan_qry));
				
				// $update_plan_qry_p="update $bai_pro3.plan_dashboard set fabric_status=0 where doc_no=".$doc_no;
				 $update_plan_qry_fab_resultp=mysqli_query($link, $update_plan_qry) or exit("Sql Error51: update plan".mysqli_error($GLOBALS["___mysqli_ston"]));

				$username = getrbac_user()['uname'];
				$approve_at = date("Y-m-d H:i:s");

				$update_req_qry = "update $wms.material_deallocation_track set approved_by='".$username."',approved_at='".$approve_at."',status='Deallocated',updated_user='$username',updated_at=NOW() where id=".$id." and plant_code='".$plant_code."'";
				// echo $update_req_qry;
				$update_req_qry_result=mysqli_query($link, $update_req_qry) or die(exception($update_req_qry));
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

			$update_req_qry = "update $wms.material_deallocation_track set approved_by='".$username."',approved_at='".$approve_at."',status='closed by system',updated_user='$username',updated_at=NOW() where id=".$id." and plant_code='".$plant_code."'";
			$update_req_qry_result=mysqli_query($link, $update_req_qry) or die(exception($update_req_qry));
            echo "<script>swal('Error','Material is Issued to Cutting','error')</script>";
            $url = getFullUrlLevel($_GET['r'],'material_deallocation.php',0,'N');
            echo "<script>setTimeout(function(){
                        location.href='$url' 
                    },2000);
                    </script>";
            exit();
        }
    }
}
catch(Exception $e) 
{
  $msg=$e->getMessage();
  log_statement('error',$msg,$main_url,__LINE__);
}
    
?>
<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 

    $id=$_GET['id'];

    $is_requested="SELECT doc_no FROM $wms.material_deallocation_track WHERE id=$id";
    $is_requested_result=mysqli_query($link, $is_requested) or exit("Sql Error0: fabric_status_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row1=mysqli_fetch_array($is_requested_result))
    {
        $doc_no=$sql_row1['doc_no'];
		$fab_qry1="SELECT fabric_status FROM $pps.requested_dockets WHERE doc_no=$doc_no";
        $fab_qry_result1=mysqli_query($link, $fab_qry1) or exit("Sql Error1: fabric_cad_allocation".mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($fab_qry_result1)>0)
        {
			while($sql_row12=mysqli_fetch_array($fab_qry_result1))
			{
				$fstatus=$sql_row12['fabric_status'];
			}
		}
		
		if($fstatus<5)
		{
			$fab_qry="SELECT allocated_qty,roll_id FROM $wms.fabric_cad_allocation WHERE doc_no='$doc_no'";
			// echo $fab_qry."<br>";
			$fab_qry_result=mysqli_query($link, $fab_qry) or exit("Sql Error1: fabric_cad_allocation".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($fab_qry_result)>0)
			{
				while($sql_row1=mysqli_fetch_array($fab_qry_result))
				{
					$allocated_qty=$sql_row1['allocated_qty'];
					$roll_id=$sql_row1['roll_id'];
											   
					$sql="update $wms.store_in set qty_allocated=qty_allocated-".$allocated_qty." where tid=".$roll_id;
					mysqli_query($link, $sql) or exit("Sql Error2: delete fabric_cad_allocation".mysqli_error($GLOBALS["___mysqli_ston"]));
					$query_status="SELECT qty_rec,qty_issued,qty_ret,qty_allocated FROM $wms.store_in WHERE tid='$roll_id' ";
					//echo $query_status;
					$query_status_res=mysqli_query($link, $query_status) or exit("Sql Error6: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($qry_status_result=mysqli_fetch_array($query_status_res))
					{
						$qty_allocated=$qry_status_result['qty_allocated'];
					}
					if($qty_allocated==0)
					{
						$status_new=0;
						$sql44="update $wms.store_in set status=$status_new, allotment_status=$status_new where tid='$roll_id' ";
						//echo $sql44."</br>";
						mysqli_query($link, $sql44) or exit("Sql Error44".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}
				
				$delete_fab="delete from $wms.fabric_cad_allocation WHERE doc_no='$doc_no'";
				$delete_fab_result=mysqli_query($link, $delete_fab) or exit("Sql Error2: delete fabric_cad_allocation".mysqli_error($GLOBALS["___mysqli_ston"]));

				$update_plan_qry="update $pps.requested_dockets set plan_lot_ref='',print_status='',fabric_status=0 where doc_no=".$doc_no;
				$update_plan_qry_fab_result=mysqli_query($link, $update_plan_qry) or exit("Sql Error5: update plan".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				// $update_plan_qry_p="update $bai_pro3.plan_dashboard set fabric_status=0 where doc_no=".$doc_no;
				// $update_plan_qry_fab_resultp=mysqli_query($link, $update_plan_qry_p) or exit("Sql Error51: update plan".mysqli_error($GLOBALS["___mysqli_ston"]));

				$username = getrbac_user()['uname'];
				$approve_at = date("Y-m-d H:i:s");

				$update_req_qry = "update $wms.material_deallocation_track set approved_by='".$username."',approved_at='".$approve_at."',status='Deallocated' where id=".$id;
				$update_req_qry_result=mysqli_query($link, $update_req_qry) or exit("Sql Error2: material_deallocation_track".mysqli_error($GLOBALS["___mysqli_ston"]));


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
			$username = getrbac_user()['uname'];
			$approve_at = date("Y-m-d H:i:s");

			$update_req_qry = "update $wms.material_deallocation_track set approved_by='".$username."',approved_at='".$approve_at."',status='closed by system' where id=".$id;
			$update_req_qry_result=mysqli_query($link, $update_req_qry) or exit("Sql Error2: material_deallocation_track".mysqli_error($GLOBALS["___mysqli_ston"]));
			
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
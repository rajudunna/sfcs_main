<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 

    $id=$_GET['id'];

    $is_requested="SELECT doc_no FROM $bai_rm_pj1.material_deallocation_track WHERE id=$id";
    $is_requested_result=mysqli_query($link, $is_requested) or exit("Sql Error0: fabric_status_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row1=mysqli_fetch_array($is_requested_result))
    {
        $doc_no=$sql_row1['doc_no'];
		$fab_qry1="SELECT fabric_status FROM $bai_pro3.plandoc_stat_log WHERE doc_no=$doc_no";
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
			$fab_qry="SELECT allocated_qty,roll_id FROM $bai_rm_pj1.fabric_cad_allocation WHERE doc_no='$doc_no'";
			// echo $fab_qry."<br>";
			$fab_qry_result=mysqli_query($link, $fab_qry) or exit("Sql Error1: fabric_cad_allocation".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($fab_qry_result)>0)
			{
				while($sql_row1=mysqli_fetch_array($fab_qry_result))
				{
					$allocated_qty=$sql_row1['allocated_qty'];
					$roll_id=$sql_row1['roll_id'];
					// echo $allocated_qty."<bR>";
					// echo $roll_id."<bR>";
				
					// $store_in_qry="SELECT * FROM $bai_rm_pj1.store_in WHERE tid = ".$sql_row1['roll_id'];
					// $store_in_qry_result=mysqli_query($link, $store_in_qry) or exit("Sql Error2: store_in".mysqli_error($GLOBALS["___mysqli_ston"]));
					// while($sql_row2=mysqli_fetch_array($store_in_qry_result))
					// {
						// $tid=$sql_row2['tid'];
						// $rec_old=$sql_row2['qty_rec'];
						// $temp =0 ;
			
						// $find_duplicate_in_qry="SELECT * FROM $bai_rm_pj1.store_in WHERE split_roll=".$tid;
						// $find_duplicate_in_qry_result=mysqli_query($link, $find_duplicate_in_qry) or exit("Sql Error3: dup store_in".mysqli_error($GLOBALS["___mysqli_ston"]));
						// while($sql_row3=mysqli_fetch_array($find_duplicate_in_qry_result))
						// {
							// $rec_new =$sql_row3['qty_rec'];
							// $tid_new=$sql_row3['tid'];
							// $delete_in_qry="DELETE FROM $bai_rm_pj1.store_in WHERE tid=".$tid_new;
							// $delete_in_qry_result=mysqli_query($link, $delete_in_qry) or exit("Sql Error4: dup store_in".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							// $temp =1;
			
						// }
						// if($temp!=1){
							// $update_qry1="UPDATE $bai_rm_pj1.store_in set qty_allocated=0,status=0,allotment_status=0 WHERE tid=".$tid;
							// $update_qry1_result=mysqli_query($link, $update_qry1) or exit("Sql Error6: dup store_in".mysqli_error($GLOBALS["___mysqli_ston"]));
						// } else {
							// $update_qry="UPDATE $bai_rm_pj1.store_in set qty_rec=$rec_new+$rec_old,qty_allocated=0,status=0,allotment_status=0  WHERE tid=".$tid;
							// $update_qry_result=mysqli_query($link, $update_qry) or exit("Sql Error5: dup store_in".mysqli_error($GLOBALS["___mysqli_ston"]));
						// }
					// }
						   
							$sql="update bai_rm_pj1.store_in set qty_allocated=qty_allocated-".$allocated_qty.",status=1,allotment_status=1 where tid=".$roll_id;
							mysqli_query($link, $sql) or exit("Sql Error2: delete fabric_cad_allocation".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				// die();
				$delete_fab="delete from $bai_rm_pj1.fabric_cad_allocation WHERE doc_no='$doc_no'";
				$delete_fab_result=mysqli_query($link, $delete_fab) or exit("Sql Error2: delete fabric_cad_allocation".mysqli_error($GLOBALS["___mysqli_ston"]));

				$update_plan_qry="update $bai_pro3.plandoc_stat_log set plan_lot_ref='',print_status='',fabric_status=0 where doc_no=".$doc_no;
				$update_plan_qry_fab_result=mysqli_query($link, $update_plan_qry) or exit("Sql Error5: update plan".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$update_plan_qry_p="update $bai_pro3.plan_dashboard set fabric_status=0 where doc_no=".$doc_no;
				$update_plan_qry_fab_resultp=mysqli_query($link, $update_plan_qry_p) or exit("Sql Error51: update plan".mysqli_error($GLOBALS["___mysqli_ston"]));

				$username = getrbac_user()['uname'];
				$approve_at = date("Y-m-d H:i:s");

				$update_req_qry = "update $bai_rm_pj1.material_deallocation_track set approved_by='".$username."',approved_at='".$approve_at."',status='Deallocated' where id=".$id;
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

			$update_req_qry = "update $bai_rm_pj1.material_deallocation_track set approved_by='".$username."',approved_at='".$approve_at."',status='closed by system' where id=".$id;
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
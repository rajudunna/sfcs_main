<?php
$new_tid=array();
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
//this is for new rolls allocation for remaing qty
function roll_splitting_function($roll_id,$total_roll_qty,$issued_qty)
{
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
    $roll_id = $roll_id;
    $total_roll_qty = $total_roll_qty;
    $issued_qty = $issued_qty;
    $sql="update bai_rm_pj1.store_in set allotment_status=1 where tid=".$roll_id;
    mysqli_query($link, $sql) or exit("Sql Error3: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
    if(strtolower($roll_splitting) == 'yes')
    {
        
        if($total_roll_qty>=$issued_qty)
        { 
            //balanced qty
            $balance_qty=(($total_roll_qty)-($issued_qty));
            //current date in php
            $current_date=date("Y-m-d");

            if($balance_qty>0){
                //getting new rolls details
                $qry_rolldetails="SELECT lot_no,ref1,ref2,ref3,remarks,log_user, status, ref4, ref5, ref6, roll_status, shrinkage_length, shrinkage_width, shrinkage_group, rejection_reason,barcode_number,ref_tid FROM $bai_rm_pj1.store_in WHERE tid=".$roll_id;
                $result__rolldetials=mysqli_query($link, $qry_rolldetails);
                $row_rolldetials=mysqli_fetch_assoc($result__rolldetials);
                $qry_newroll="insert into bai_rm_pj1.store_in(lot_no,ref1,ref2,ref3,qty_rec, date, remarks, log_user, status, ref4, ref5, ref6, roll_status, shrinkage_length, shrinkage_width, shrinkage_group, rejection_reason, split_roll,ref_tid,barcode_number) values('".$row_rolldetials["lot_no"]."','".$row_rolldetials["ref1"]."','".$row_rolldetials["ref2"]."','".$row_rolldetials["ref3"]."','".$balance_qty."','".$current_date."','".$row_rolldetials["remarks"]."','".$row_rolldetials["log_user"]."','".$row_rolldetials["status"]."','".$row_rolldetials["ref4"]."','".$row_rolldetials["ref5"]."','".$row_rolldetials["ref6"]."','".$row_rolldetials["roll_status"]."','".$row_rolldetials["shrinkage_length"]."','".$row_rolldetials["shrinkage_width"]."','".$row_rolldetials["shrinkage_group"]."','".$row_rolldetials["rejection_reason"]."','".$roll_id."','".$row_rolldetials["ref_tid"]."','".$row_rolldetials["barcode_number"]."')";
                mysqli_query($link, $qry_newroll) or exit("Sql Error3: $qry_newroll".mysqli_error($GLOBALS["___mysqli_ston"]));
                $new_tid=mysqli_insert_id($link);
                $sql22="update bai_rm_pj1.store_in set barcode_number='".$facility_code."-".$new_tid."' where tid=".$new_tid;
                //Uncheck this
                mysqli_query($link, $sql22) or exit("Sql Error3: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
            }
            $sql="update bai_rm_pj1.store_in set qty_rec=".$issued_qty.",qty_allocated=qty_allocated+".$issued_qty." where tid=".$roll_id;
            //Uncheck this
            mysqli_query($link, $sql) or exit("Sql Error3: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
        }

        $sql="update $bai_rm_pj1.store_in set status=2, allotment_status=2 where tid=".$roll_id;
			  $sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysqli_error());
    }
    else
    {
       
        if($total_roll_qty==$issued_qty)
        {
           
            $sql="update bai_rm_pj1.store_in set qty_allocated=qty_allocated+".$issued_qty.",status=2,allotment_status=2 where tid=".$roll_id;
        }
        else{
        
            $sql="update bai_rm_pj1.store_in set qty_allocated=qty_allocated+".$issued_qty.",status=0,allotment_status=0 where tid=".$roll_id;
        }
        
        //Uncheck this
        mysqli_query($link, $sql) or exit("Sql Error3: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
}
//To update Allocated Qty
// $sql="update $bai_rm_pj1.store_in set qty_allocated=".$issued_qty." where tid=".$roll_id;
?>
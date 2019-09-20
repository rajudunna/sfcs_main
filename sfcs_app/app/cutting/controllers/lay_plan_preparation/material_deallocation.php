<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
    
?>
<div class="panel panel-primary"> 
    <div class="panel-heading">Material Deallocation</div>
        <div class='panel-body'>
            <form method="post" name="form1" action="?r=<?php echo $_GET['r']; ?>">
                <div class="row">
                    <div class="col-md-3">
                        <label>Docket Number</label>
                        <input type="text" class='integer form-control' id="docket_number" name="docket_number" size=8 required>
                    </div>
                    <br/>
                    <div class="col-md-3">
                        <input type="submit" id="material_deallocation" class="btn btn-primary" name="formSubmit" value="Submit">
                    </div>
                    <img id="loading-image" class=""/>  
                </div>
            </form>
        </div>
    </div>
    <?php

if(isset($_POST['formSubmit']))
{
    $doc_no = $_POST['docket_number'];
    $fabric_status_qry="SELECT * FROM $bai_pro3.plandoc_stat_log WHERE doc_no=$doc_no";
    $fabric_status_qry_result=mysqli_query($link, $fabric_status_qry) or exit("Sql Error0: fabric_status_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
    if(mysqli_num_rows($fabric_status_qry_result)>0){
        while($sql_row0=mysqli_fetch_array($fabric_status_qry_result))
        {
            $fabric_status = $sql_row0['fabric_status'];
        }
        if($fabric_status != 5){
          
            $fab_qry="SELECT * FROM $bai_rm_pj1.fabric_cad_allocation WHERE doc_no=$doc_no";
            $fab_qry_result=mysqli_query($link, $fab_qry) or exit("Sql Error1: fabric_cad_allocation".mysqli_error($GLOBALS["___mysqli_ston"]));
            if(mysqli_num_rows($fab_qry_result)>0){
                while($sql_row1=mysqli_fetch_array($fab_qry_result))
                {
                    $store_in_qry="SELECT * FROM $bai_rm_pj1.store_in WHERE tid = ".$sql_row1['roll_id'];
                    $store_in_qry_result=mysqli_query($link, $store_in_qry) or exit("Sql Error2: store_in".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($sql_row2=mysqli_fetch_array($store_in_qry_result))
                    {
                        $tid=$sql_row2['tid'];
                        $rec_old=$sql_row2['qty_rec'];
                        $temp =0 ;
            
                        $find_duplicate_in_qry="SELECT * FROM $bai_rm_pj1.store_in WHERE split_roll=".$tid;
                        $find_duplicate_in_qry_result=mysqli_query($link, $find_duplicate_in_qry) or exit("Sql Error3: dup store_in".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($sql_row3=mysqli_fetch_array($find_duplicate_in_qry_result))
                        {
                            $rec_new =$sql_row3['qty_rec'];
                            $tid_new=$sql_row3['tid'];
                            $delete_in_qry="DELETE FROM $bai_rm_pj1.store_in WHERE tid=".$tid_new;
                            $delete_in_qry_result=mysqli_query($link, $delete_in_qry) or exit("Sql Error4: dup store_in".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            $temp =1;
            
                        }
                        if($temp!=1){
                            $update_qry1="UPDATE $bai_rm_pj1.store_in set qty_allocated=0,status=0,allotment_status=0 WHERE tid=".$tid;
                            $update_qry1_result=mysqli_query($link, $update_qry1) or exit("Sql Error6: dup store_in".mysqli_error($GLOBALS["___mysqli_ston"]));
                        } else {
                            $update_qry="UPDATE $bai_rm_pj1.store_in set qty_rec=$rec_new+$rec_old,qty_allocated=0,status=0,allotment_status=0  WHERE tid=".$tid;
                            $update_qry_result=mysqli_query($link, $update_qry) or exit("Sql Error5: dup store_in".mysqli_error($GLOBALS["___mysqli_ston"]));
                        }
                        $delete_fab="delete from $bai_rm_pj1.fabric_cad_allocation WHERE doc_no=$doc_no";
                        $delete_fab_result=mysqli_query($link, $delete_fab) or exit("Sql Error2: delete fabric_cad_allocation".mysqli_error($GLOBALS["___mysqli_ston"]));
            
                        $update_plan_qry="update $bai_pro3.plandoc_stat_log set plan_lot_ref='',print_status='' where doc_no=".$doc_no;
                        $update_plan_qry_fab_result=mysqli_query($link, $update_plan_qry) or exit("Sql Error5: update plan".mysqli_error($GLOBALS["___mysqli_ston"]));
                        echo "<script>swal('sucess','Material De-Allocated Successfully','success')</script>";
                
                    }
                }
            } else {
                echo "<script>swal('Error','Material is Not Yet Allocated','error')</script>";
            }
        }   else {
            echo "<script>swal('Error','Material is Issued to Cutting','error')</script>";
        }
    } else {
        echo "<script>swal('Error','Enter Valid Docket Number','error')</script>";
    }
}

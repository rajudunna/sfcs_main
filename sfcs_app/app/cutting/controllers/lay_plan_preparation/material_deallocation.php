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
                        <input type="submit" id="material_deallocation" class="btn btn-primary" name="formSubmit" value="Ready to Deallocate">
                    </div>
                    <img id="loading-image" class=""/>  
                </div>
            </form>
        </div>
        <ul id="rowTab" class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab_a"><b><span class='label label-default' style='font-size:15px'>Deallocate Requests</span></b></a></li>
            <li><a data-toggle="tab" href="#tab_b"><b><span class='label label-default' style='font-size:15px'>Allocated </span></b></a></li>
        </ul>
        <div class="tab-content">
            <div id="tab_a" class="tab-pane fade active in">
                <div style='overflow:scroll;' class='table-responsive'>
                    <table id='table1' class='table table-bordered'>
                        <thead>
                            <tr>
                                <th>SNo.</th>
                                <th>Docket Number</th>
                                <th>Qty</th>
                                <th>Requested By</th>
                                <th>Requested At</th>
                                <th>Status</th>
                                <th>Control</th>

                            </tr>
                        </thead>
                        <?php
                            $query = "select * from $bai_rm_pj1.material_deallocation_track where status='Open'";
                            $sql_result = mysqli_query($link,$query);
                            // echo $query;
                            while($sql_row=mysqli_fetch_array($sql_result))
                            {
                                $table1_rows++;
                                $i = $sql_row['id'];
                                $index+=1;
                                echo "<tr><td>".$index."</td>";
                                echo "<td>".$sql_row['doc_no']."</td>";
                                echo "<td>".$sql_row['qty']."</td>";
                                echo "<td>".$sql_row['requested_by']."</td>";
                                echo "<td>".$sql_row['requested_at']."</td>";
                                echo "<td><select name='issue_status$i' id='issue_status-$i' class='select2_single form-control' onchange='IssueAction($i);'>";
                                echo "<option value=''>Please Select</option>";
                                echo "<option value='Approve'>Approve</option>";
                                echo "</select></td>";
                                echo "<td><input type='submit' name='submit$i' id='submit-$i' class='btn btn-info' value='Deallocate' disabled='disabled' onclick='UpdateDamageStatus($i);'></td>";
                                echo "</tr>";
                            }
                        ?>
                    </table>
                </div>
            </div>
            <div id="tab_b" class="tab-pane fade">
                <div style='overflow:scroll;' class='table-responsive'>
                    <table id='table1' class='table table-bordered'>
                        <thead>
                            <tr>
                                <th>SNo.</th>
                                <th>Docket Number</th>
                                <th>Qty</th>
                                <th>Requested By</th>
                                <th>Requested At</th>
                            </tr>
                        </thead>
                        <?php
                            $query = "select * from $bai_rm_pj1.material_deallocation_track where status='Approved'";
                            $sql_result = mysqli_query($link,$query);
                            // echo $query;
                            while($sql_row=mysqli_fetch_array($sql_result))
                            {
                                $table1_rows++;
                                $i = $sql_row['id'];
                                $index+=1;
                                echo "<tr><td>".$index."</td>";
                                echo "<td>".$sql_row['doc_no']."</td>";
                                echo "<td>".$sql_row['qty']."</td>";
                                echo "<td>".$sql_row['requested_by']."</td>";
                                echo "<td>".$sql_row['requested_at']."</td>";
                                echo "</tr>";
                            }
                        ?>
                    </table>
                </div>
            </div>
            
            
        </div>
    </div>
    <?php

if(isset($_POST['formSubmit']))
{
    $doc_no = $_POST['docket_number'];
   
    $fabric_status_qry="SELECT * FROM $bai_pro3.plandoc_stat_log WHERE doc_no=$doc_no";
    // echo $fabric_status_qry;
    $fabric_status_qry_result=mysqli_query($link, $fabric_status_qry) or exit("Sql Error0: fabric_status_qry".mysqli_error($GLOBALS["___mysqli_ston"]));

    if(mysqli_num_rows($fabric_status_qry_result)>0){
        while($sql_row0=mysqli_fetch_array($fabric_status_qry_result))
        {
            $fabric_status = $sql_row0['fabric_status'];
        }
        $fab_qry="SELECT * FROM $bai_rm_pj1.fabric_cad_allocation WHERE doc_no=$doc_no";
        $fab_qry_result=mysqli_query($link, $fab_qry) or exit("Sql Error1: fabric_cad_allocation".mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($fab_qry_result)>0){     
            if($fabric_status != 5)
            {

                $is_requested="SELECT * FROM $bai_rm_pj1.material_deallocation_track WHERE doc_no=$doc_no and status='Open'";
                $is_requested_result=mysqli_query($link, $is_requested) or exit("Sql Error0: fabric_status_qry".mysqli_error($GLOBALS["___mysqli_ston"]));

                if(mysqli_num_rows($is_requested_result)==0)
                {
                    // if($doc_no != ''){
                    $fab_qry="SELECT * FROM $bai_rm_pj1.fabric_cad_allocation WHERE doc_no=$doc_no";
                    $fab_qry_result=mysqli_query($link, $fab_qry) or exit("Sql Error1: fabric_cad_allocation".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $allocated_qty=0;
                    while($sql_row1=mysqli_fetch_array($fab_qry_result))
                    {
                        $allocated_qty+=$sql_row1['allocated_qty'];  
                    }
                    $req_at = date("Y-m-d H:i:s");
                    $insert_req_qry = "INSERT INTO $bai_rm_pj1.material_deallocation_track(doc_no,qty,requested_by,requested_at,status) values ($doc_no,$allocated_qty,'$username','$req_at','Open')";
                    $insert_req_qry_result=mysqli_query($link, $insert_req_qry) or exit("Sql Error2: material_deallocation_track".mysqli_error($GLOBALS["___mysqli_ston"]));
                    echo "<script>swal('success','Request Sent Successfully','success')</script>";
                    $url = getFullUrlLevel($_GET['r'],'material_deallocation.php',0,'N');
                    echo "<script>setTimeout(function(){
                                location.href='$url' 
                            },2000);
                            </script>";
                    exit();
                            // $req_no_qry="SELECT * FROM $bai_rm_pj1.material_deallocation_track";
                            // $req_no_qry_result=mysqli_query($link, $req_no_qry) or exit("Sql Error3: material_deallocation_track".mysqli_error($GLOBALS["___mysqli_ston"]));
                            // $sno = 0;
                            // var_dump($req_no_qry);

                            // while($sql_row2=mysqli_fetch_array($req_no_qry_result))
                            // {
                            //     // var_dump($sql_row2);
                            //     $sno++;
                            //     echo "<table><tr><th>Sno.</th><th>Doc No</th><th>Qty.</th><th>Requested By</th><th>Requested At</th><th>Status</th></tr>";
                            //     echo "<tr><td>".$sno."</td><td>".$sql_row2['doc_no']."</td><td>".$sql_row2['qty']."</td><td>".$sql_row2['requested_by']."</td><td>".$sql_row2['requested_at']."</td><td></td></tr>";
                            //     echo "</table>";
                            // }
                    // }
                } 
                else 
                {
                    echo "<script>swal('Warning','Material Deallocation Request is Already Sent','warning')</script>";
                }
            }else 
            {
                echo "<script>swal('Error','Material is Issued to Cutting','error')</script>";
            }
        } else {
            echo "<script>swal('Error','Material is Not Yet Allocated','error')</script>";
        }
        // while($sql_row0=mysqli_fetch_array($fabric_status_qry_result))
        // {
        //     $fabric_status = $sql_row0['fabric_status'];
        // }
           
        // if($fabric_status != 5){
          
        //     $fab_qry="SELECT * FROM $bai_rm_pj1.fabric_cad_allocation WHERE doc_no=$doc_no";
        //     $fab_qry_result=mysqli_query($link, $fab_qry) or exit("Sql Error1: fabric_cad_allocation".mysqli_error($GLOBALS["___mysqli_ston"]));
        //     if(mysqli_num_rows($fab_qry_result)>0){
        //         while($sql_row1=mysqli_fetch_array($fab_qry_result))
        //         {
        //             $store_in_qry="SELECT * FROM $bai_rm_pj1.store_in WHERE tid = ".$sql_row1['roll_id'];
        //             $store_in_qry_result=mysqli_query($link, $store_in_qry) or exit("Sql Error2: store_in".mysqli_error($GLOBALS["___mysqli_ston"]));
        //             while($sql_row2=mysqli_fetch_array($store_in_qry_result))
        //             {
        //                 $tid=$sql_row2['tid'];
        //                 $rec_old=$sql_row2['qty_rec'];
        //                 $temp =0 ;
            
        //                 $find_duplicate_in_qry="SELECT * FROM $bai_rm_pj1.store_in WHERE split_roll=".$tid;
        //                 $find_duplicate_in_qry_result=mysqli_query($link, $find_duplicate_in_qry) or exit("Sql Error3: dup store_in".mysqli_error($GLOBALS["___mysqli_ston"]));
        //                 while($sql_row3=mysqli_fetch_array($find_duplicate_in_qry_result))
        //                 {
        //                     $rec_new =$sql_row3['qty_rec'];
        //                     $tid_new=$sql_row3['tid'];
        //                     $delete_in_qry="DELETE FROM $bai_rm_pj1.store_in WHERE tid=".$tid_new;
        //                     $delete_in_qry_result=mysqli_query($link, $delete_in_qry) or exit("Sql Error4: dup store_in".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
        //                     $temp =1;
            
        //                 }
        //                 if($temp!=1){
        //                     $update_qry1="UPDATE $bai_rm_pj1.store_in set qty_allocated=0,status=0,allotment_status=0 WHERE tid=".$tid;
        //                     $update_qry1_result=mysqli_query($link, $update_qry1) or exit("Sql Error6: dup store_in".mysqli_error($GLOBALS["___mysqli_ston"]));
        //                 } else {
        //                     $update_qry="UPDATE $bai_rm_pj1.store_in set qty_rec=$rec_new+$rec_old,qty_allocated=0,status=0,allotment_status=0  WHERE tid=".$tid;
        //                     $update_qry_result=mysqli_query($link, $update_qry) or exit("Sql Error5: dup store_in".mysqli_error($GLOBALS["___mysqli_ston"]));
        //                 }
        //                 $delete_fab="delete from $bai_rm_pj1.fabric_cad_allocation WHERE doc_no=$doc_no";
        //                 $delete_fab_result=mysqli_query($link, $delete_fab) or exit("Sql Error2: delete fabric_cad_allocation".mysqli_error($GLOBALS["___mysqli_ston"]));
            
        //                 $update_plan_qry="update $bai_pro3.plandoc_stat_log set plan_lot_ref='',print_status='' where doc_no=".$doc_no;
        //                 $update_plan_qry_fab_result=mysqli_query($link, $update_plan_qry) or exit("Sql Error5: update plan".mysqli_error($GLOBALS["___mysqli_ston"]));
        //                 echo "<script>swal('sucess','Material De-Allocated Successfully','success')</script>";
                
        //             }
        //         }
        //     } else {
        //         echo "<script>swal('Error','Material is Not Yet Allocated','error')</script>";
        //     }
        // }   else {
        //     echo "<script>swal('Error','Material is Issued to Cutting','error')</script>";
        // }
    } else {
        echo "<script>swal('Error','Enter Valid Docket Number','error')</script>";
    }
}
?>
<script>
function IssueAction(i)
    {
        document.getElementById('submit-'+i).disabled = false;
    }
function UpdateDamageStatus(i) {
    if($('#submit-'+i).val()) {
        var status = $('#issue_status-'+i).val();
        var row_id = i;

        if(status=='Approve') {
            url_path = "<?php echo getFullURL($_GET['r'],'update_deallocation_status.php','N'); ?>";
            window.open(url_path+"&id="+row_id+"&status="+status);
        }
    }
    
}
</script>
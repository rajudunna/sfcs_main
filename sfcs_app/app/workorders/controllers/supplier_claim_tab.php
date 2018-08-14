

<table class="table table-bordered">
    <thead>
        <tr>
            <th>S.no</th>
            <th>Supplier Name</th>
            <th>Product</th>
            <th>Lot No</th>
            <th>Batch No</th>
            <th>PO No</th>
            <th>Roll Qty</th>
            <th>Length Qty</th>
            <th>Uom</th>
            <th>Complaint Category</th>
            <th width="40%">Actions</th>
        </tr>
    </thead>
    <tbody>

        <?php

            // $style = $_GET['style'];
            // $schedule = $_GET['schedule'];

            $style = 'JJP316F8';
            $schedule = '520178';
        
            include($_SERVER['DOCUMENT_ROOT'].'/template/dbconf.php');

            $sql_select_query = "select supplier_name,product_categoy,reject_lot_no,reject_batch_no,reject_po_no,reject_roll_qty,reject_len_qty,uom,complaint_category from bai_pro3.bai_orders_db left join bai_pro3.cat_stat_log on cat_stat_log.order_tid = bai_orders_db.order_tid left join bai_rm_pj1.stock_report on bai_rm_pj1.stock_report.item = bai_pro3.cat_stat_log.compo_no right join bai_rm_pj1.inspection_complaint_db  on bai_rm_pj1.inspection_complaint_db.reject_lot_no = lot_no where order_style_no='$style' and order_del_no='$schedule'";
            $query_result = mysqli_query($link_ui, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

            if ($query_result->num_rows > 0) {

                $i=0;
                while($row = $query_result->fetch_assoc()) {
                    $i++;
                    $sno = $i;
                    $supplier_name = $row["supplier_name"];
                    $product_categoy = $row["product_categoy"];
                    $reject_lot_no = $row["reject_lot_no"];
                    $reject_batch_no = $row["reject_batch_no"];
                    $reject_po_no = $row["reject_po_no"];
                    $reject_roll_qty = $row["reject_roll_qty"];
                    $reject_len_qty = $row["reject_len_qty"];
                    $uom = $row["uom"];
                    $complaint_category = $row["complaint_category"];
                    
                    // $url = $_SERVER['DOCUMENT_ROOT'].'/ui/role_creation_ui?uname='.$row["user_name"];
                    // $url1 = getFullURL($_GET['r'],'user_name_updation.php','N');
                    // $url2 = getFullURL($_GET['r'],'user_assigned_role_updation.php','N');

                    echo "<tr>
                            <td>".$sno."</td>
                            <td>".$supplier_name."</td>
                            <td>".$product_categoy."</td>
                            <td>".$reject_lot_no."</td>
                            <td>".$reject_batch_no."</td>
                            <td>".$reject_po_no."</td>
                            <td>".$reject_roll_qty."</td>
                            <td>".$reject_len_qty."</td>
                            <td>".$uom."</td>
                            <td>".$complaint_category."</td>
                            <td class='btn-group'>
                                <a href='#' class='btn btn-primary btn-sm'>Update</a>
                                <a href='#' class='btn btn-success btn-sm'>Print</a>
                                <a href='#' class='btn btn-info btn-sm'>Mail Status</a>
                                <a href='#' class='btn btn-danger btn-sm'>Delete</a>
                            </td>
                        </tr>";
                }
               
            } else {
                echo "<div class='alert alert-info' align='center'>No Data Found</div>";
            }
            
            $link_ui->close();

        ?>
    </tbody>
</table>

      



   

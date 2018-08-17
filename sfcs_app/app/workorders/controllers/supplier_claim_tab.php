

<table class="table table-bordered" id='table_ajax_2'>
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
            <th style="width:40% !important">Actions</th>
        </tr>
    </thead>
    <tbody>

        <?php
            include($_SERVER['DOCUMENT_ROOT'].'/template/dbconf.php');
            // $style = $_GET['style'];
            // $schedule = $_GET['schedule'];

            $style = 'JJP316F8';
            $schedule = '520178';
            $start = 0;
            $limit = 15;
            $total = 0;
           
            $sql_count_query = "select count(*) as total from bai_pro3.bai_orders_db 
                                 left join bai_pro3.cat_stat_log on cat_stat_log.order_tid = bai_orders_db.order_tid left join bai_rm_pj1.stock_report on bai_rm_pj1.stock_report.item = bai_pro3.cat_stat_log.compo_no right join bai_rm_pj1.inspection_complaint_db  on bai_rm_pj1.inspection_complaint_db.reject_lot_no = lot_no where order_style_no='$style' and order_del_no='$schedule'";
            $count_result = mysqli_query($link_ui, $sql_count_query) or exit("Sql Error In getting total count");
            if(mysqli_num_rows($count_result)>0){
                $row = mysqli_fetch_array($count_result); 
                $total = $row['total'];
            }else{
                $total = 0;
            }
           
            
            $query =  "select supplier_name,product_categoy,reject_lot_no,reject_batch_no,reject_po_no,reject_roll_qty,reject_len_qty,uom,complaint_category from bai_pro3.bai_orders_db left join bai_pro3.cat_stat_log on cat_stat_log.order_tid = bai_orders_db.order_tid left join bai_rm_pj1.stock_report on bai_rm_pj1.stock_report.item = bai_pro3.cat_stat_log.compo_no right join bai_rm_pj1.inspection_complaint_db  on bai_rm_pj1.inspection_complaint_db.reject_lot_no = lot_no";
            $query_last = '';
            $sql_select_query = $query.$query_last." where order_style_no='$style' and order_del_no='$schedule' 
                                LIMIT $limit offset $start";
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
                            <td><div class='btn-group'>
                                <a href='#' class='btn btn-primary btn-sm'>Update</a>
                                <a href='#' class='btn btn-success btn-sm'>Print</a>
                                <a href='#' class='btn btn-info btn-sm'>Mail Status</a>
                                <a href='#' class='btn btn-danger btn-sm'>Delete</a>
                                </div>
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

<script>
    $(document).ready(function() {
        var url = "<?php  echo base64_encode('/sfcs_app/app/workorders/controllers/server_processing.php'); ?>";
        var fields = {'supplier_name':'supplier_name','product_categoy':'product_categoy','reject_batch_no':'reject_batch_no','reject_lot_no':'reject_lot_no','reject_po_no':'reject_po_no','reject_roll_qty':'reject_roll_qty','reject_len_qty':'reject_len_qty','uom':'uom','complaint_category':'complaint_category'};
        var values = {'order_del_no':'<?= $schedule ?>','order_style_no':'<?= $style ?>'};
        var query = "<?= $query ?>";
        var href_attr = {'reject_lot_no':'reject_lot_no'};

        var table = $('#table_ajax_2').DataTable({
            "bSort":false,
            "processing": true,
            "serverSide": true,
            "lengthChange": true,
            "dataSrc": "",
            "ajax": {
                url: 'ajax_calls.php?r='+url,
                method:'GET',
                data:{'fields':fields,'values':values,'limit':'<?= $limit ?>','total':'<?= $total ?>','query':query,'query_last':'<?= $query_last ?>','href_attr':href_attr},
            }, 
            "pageLength": 15,
            "deferLoading": <?= $total ?>           
        });
    });

    function afterAjax(){
        $('.append_something').each(function(){
            var lot = $(this).find('input')[0].value;
            $(this).find('p').after("<div  class='btn-group'><a href='#' class='btn btn-primary btn-sm'>Update</a><a href='#' class='btn btn-success btn-sm'>Print</a><a href='#' class='btn btn-info btn-sm'>Mail Status</a><a href='#' class='btn btn-danger btn-sm'>Delete</a></div>");
            $('.act').css('width','400px');
        });
    }
</script>      



   

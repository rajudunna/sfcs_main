

<table class="table table-bordered" id='table4'>
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
            $up_url = base64_encode('/sfcs_app/app/inspection/controllers/Supplier_Claim_Request_Form.php');
            $print_url = base64_encode('/sfcs_app/app/inspection/reports/Supplier_Print_PDF.php');
            $del_url = base64_encode('/sfcs_app/app/inspection/reports/request_delete.php');

            $query =  "select supplier_name,product_categoy,reject_lot_no,reject_batch_no,reject_po_no,reject_roll_qty,reject_len_qty,uom,complaint_category,reject_inv_no,ref_no,complaint_no from bai_pro3.bai_orders_db left join bai_pro3.cat_stat_log on cat_stat_log.order_tid = bai_orders_db.order_tid left join bai_rm_pj1.stock_report on bai_rm_pj1.stock_report.item = bai_pro3.cat_stat_log.compo_no right join bai_rm_pj1.inspection_complaint_db  on bai_rm_pj1.inspection_complaint_db.reject_lot_no = lot_no";
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
                    $inv_no = $row['reject_inv_no'];
                    $complaint_no = $row['complaint_no'];
                    $uom = $row["uom"];
                    $complaint_category = $row["complaint_category"];
                    $ref_no = $row['ref_no'];
                    
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
                                <a href='?r=$up_url&lot=$reject_lot_no&batch=$reject_batch_no' class='btn btn-primary btn-sm' onclick='anchortag(event,this.href)'>Update</a>
                                <a href='?r=$print_url&sno=$complaint_no&status=1' class='btn btn-success btn-sm' onclick='anchortag(event,this.href)'>Print</a>
                                <a href='#' class='btn btn-info btn-sm'>Mail Status</a>
                                <a href='?r=$del_url&complaint_no=$complaint_no&tid=$ref_no' class='btn btn-danger btn-sm'>Delete</a>
                                </div>
                            </td>
                        </tr>";
                }
               
            } else {
                echo "<tr><td colspan=11><div class='alert alert-danger' align='center'>No Data Found</div></td></tr>";
            }
            
            $link_ui->close();

        ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
    
        var url = "<?php  echo base64_encode('/sfcs_app/app/workorders/controllers/server_processing.php'); ?>";
        var fields = {'supplier_name':'supplier_name','product_categoy':'product_categoy','reject_batch_no':'reject_batch_no','reject_lot_no':'reject_lot_no','reject_po_no':'reject_po_no','reject_roll_qty':'reject_roll_qty','reject_inv_no':'reject_inv_no','complaint_no':'complaint_no','ref_no':'ref_no','reject_len_qty':'reject_len_qty','uom':'uom','complaint_category':'complaint_category'};
        var values = {'order_del_no':'<?= $schedule ?>','order_style_no':'<?= $style ?>'};
        var query = "<?= $query ?>";
        var href_attr = {'reject_lot_no':'reject_lot_no','reject_batch_no':'reject_batch_no','complaint_no':'complaint_no',
                        'ref_no':'ref_no'};
        var format = {'6':'nil','7':'nil','8':'nil'}; 

        var table = $('#table4').DataTable({
            "bSort":false,
            "processing": true,
            "serverSide": true,
            "lengthChange": true,
            "dataSrc": "",
            "ajax": {
                url: 'ajax_calls.php?r='+url,
                method:'GET',
                data:{'fields':fields,'values':values,'limit':'<?= $limit ?>','total':'<?= $total ?>','query':query,'query_last':'<?= $query_last ?>','format':format,'href_attr':href_attr},
            }, 
            "pageLength": 15,
            "deferLoading": <?= $total ?>           
        });
    });

    function afterAjax(){
        $('.append_something').each(function(){
            var lot = $(this).find('input')[0].value;
            var batch = $(this).find('input')[1].value;
            var complaint_no =  $(this).find('input')[2].value;
            var ref_no =  $(this).find('input')[3].value;
            
            var up_url = "<?= $up_url ?>";
            var print_url = "<?= $print_url ?>";
            var del_url = "<?= $del_url ?>";

            $(this).find('p').after("<div  class='btn-group'><a href='?r="+up_url+"&lot="+lot+"&batch="+batch+"' class='btn btn-primary btn-sm' onclick='anchortag(event,this.href)'>Update</a><a href='?r="+print_url+"&sno="+complaint_no+"&status=1' class='btn btn-success btn-sm' onclick='anchortag(event,this.href)'>Print</a><a href='#' class='btn btn-info btn-sm'>Mail Status</a><a href='"+del_url+"&complaint_no="+complaint_no+"&tid="+ref_no+"' class='btn btn-danger btn-sm'>Delete</a></div>");
            $('.act').css('width','400px');
        });
    }
</script>      



   

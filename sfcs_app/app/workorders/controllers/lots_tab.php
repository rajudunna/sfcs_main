
<link rel='stylesheet' href='https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css'>
<table class="table table-bordered" id='table_ajax_1'>
    <thead>
        <tr>
            <th>S.no</th>
            <th>Lot Number</th>
            <th>Batch Number</th>
            <th>Quantity</th>
            <th>Prodct Group</th>
            <th style='width:40% !important'>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $style = $_GET['style'];
            $schedule = $_GET['schedule'];

            // $style = 'JJP316F8';
            // $schedule = '520178';
            $start = 0;
            $limit = 15;
            include($_SERVER['DOCUMENT_ROOT'].'/template/dbconf.php');

            //getting total records count 
            $sql_count_query = "select count(*) as total 
                                from bai_pro3.bai_orders_db 
                                left join bai_pro3.cat_stat_log on cat_stat_log.order_tid = bai_orders_db.order_tid 
                                left join bai_rm_pj1.stock_report on bai_rm_pj1.stock_report.item = bai_pro3.cat_stat_log.compo_no where order_style_no='$style' and order_del_no='$schedule'";
            $count_result = mysqli_query($link_ui, $sql_count_query) or exit("Sql Error In getting total count");
            if(mysqli_num_rows($count_result)>0){
                $row = mysqli_fetch_array($count_result); 
                $total = $row['total'];
            }else{
                $total = 0;
            }
            
            $query = "select order_style_no as style,order_del_no as shedule,bai_orders_db.order_tid,compo_no,lot_no,batch_no,product_group,qty_rec as qty from bai_pro3.bai_orders_db left join bai_pro3.cat_stat_log on cat_stat_log.order_tid = bai_orders_db.order_tid left join bai_rm_pj1.stock_report on bai_rm_pj1.stock_report.item = bai_pro3.cat_stat_log.compo_no"; 
            $query_last = '';
            $sql_select_query = $query.$query_last." where order_style_no='$style' and order_del_no='$schedule' 
                                LIMIT $limit offset $start";
            // echo $sql_select_query;
            $query_result = mysqli_query($link_ui, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

            if ($query_result->num_rows > 0) {

                $i=0;
                while($row = $query_result->fetch_assoc()) {
                    $i++;
                    $sno = $i;
                    $lot_number = $row["lot_no"];
                    $batch_number = $row["batch_no"];
                    $qty = $row["qty"];
                    $product_group = $row["product_group"];
                    // $url = $_SERVER['DOCUMENT_ROOT'].'/ui/role_creation_ui?uname='.$row["user_name"];
                    // $url1 = getFullURL($_GET['r'],'user_name_updation.php','N');
                    // $url2 = getFullURL($_GET['r'],'user_assigned_role_updation.php','N');
                    echo "<tr>
                            <td>".$sno."</td>
                            <td>".$lot_number."</td>
                            <td>".$batch_number."</td>
                            <td>".$qty."</td>
                            <td>".$product_group."</td>
                            <td class='append_buttons' id='column$i'><div class='btn-group'>
                                <a href='?r=".base64_encode('/sfcs_app/app/warehouse/controllers/insert_v1.php')."&lot=$lot_number&batch=$batch_number' class='btn btn-primary btn-sm' onclick='anchortag(event,this.href);' data_toggle='anil'>Receive</a>
                                <a href='?r=".base64_encode('/sfcs_app/app/warehouse/controllers/entry_delete.php')."&lot=$lot_number&batch=$batch_number' class='btn btn-danger btn-sm' onclick='anchortag(event,this.href);'>Delete</a>
                                <a href='?r=".base64_encode('/sfcs_app/app/warehouse/controllers/location_transfer.php')."&lot=$lot_number&batch=$batch_number' class='btn btn-info btn-sm' onclick='anchortag(event,this.href);'>Transfer</a>
                                <div class='btn-group' role='group'>
                                    <button type='button' class='btn btn-warning btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                    Inspect
                                    <span class='caret'></span>
                                    </button>
                                    <ul class='dropdown-menu'>
                                    <li><a href='?r=".base64_encode('/sfcs_app/app/inspection/controllers/C_Tex_Index.php')."&lot=$lot_number&batch=$batch_number' onclick='anchortag(event,this.href);'>Fabric</a></li>
                                    <li><a href='?r=".base64_encode('/sfcs_app/app/inspection/controllers/trims_inspection_update.php')."&lot=$lot_number&batch=$batch_number' onclick='anchortag(event,this.href);'>Trims</a></li>
                                    </ul>
                                </div>
                                <a href='?r=".base64_encode('/sfcs_app/app/inspection/controllers/Supplier_Claim_Request_Form.php')."&lot=$lot_number&batch=$batch_number' class='btn btn-success btn-sm' onclick='anchortag(event,this.href);'>Claim</a> </div>   
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
        var fields = {'lot_no':'lot_no','batch_no':'batch_no','qty_rec':'qty','product_group':'product_group'};
        var values = {'order_del_no':'<?= $schedule ?>','order_style_no':'<?= $style ?>'};
        var query = "<?= $query ?>";
        var href_attr = {'lot_no':'lot_no', 'batch_no':'batch_no'};
        var table = $('#table_ajax_1').DataTable({
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
        // $('#table2_filter input').unbind();
        // $('#table2_filter input').bind('keyup', function(e){
        //     if(e.keyCode == 13) {
        //         console.log(table);
        //         table.fnFilter( this.value, $(this).attr('id') );
        //     }
        // });
    });

    function afterAjax(){
        $('.append_something').each(function(){
            $(this).find('#add_some').html("");
            var lot = $(this).find('input')[0].value;
            var batch = $(this).find('input')[1].value;
            var receive = '<?= '?r='.base64_encode('/sfcs_app/app/warehouse/controllers/insert_v1.php'); ?>&lot='+lot+'&batch='+batch;
            var delete1 = '<?= '?r='.base64_encode('/sfcs_app/app/warehouse/controllers/entry_delete.php'); ?>&lot='+lot+'&batch='+batch;
            var transfer = '<?= '?r='.base64_encode('/sfcs_app/app/warehouse/controllers/location_transfer.php'); ?>&lot='+lot+'&batch='+batch;
            var inspect_fabric = '<?= '?r='.base64_encode('/sfcs_app/app/inspection/controllers/C_Tex_Index.php'); ?>&lot='+lot+'&batch='+batch;
            var inspect_trims = '<?= '?r='.base64_encode('/sfcs_app/app/inspection/controllers/trims_inspection_update.php'); ?>&lot='+lot+'&batch='+batch;
            var claim = '<?= '?r='.base64_encode('/sfcs_app/app/inspection/controllers/Supplier_Claim_Request_Form.php'); ?>&lot='+lot+'&batch='+batch;
            $(this).find('#add_some').html("<div class='btn-group'><a href='"+receive+"' class='btn btn-primary btn-sm' onclick='anchortag(event,this.href);'>Receive</a><a href='"+delete1+"' class='btn btn-danger btn-sm' onclick='anchortag(event,this.href);'>Delete</a><a href='"+transfer+"' class='btn btn-info btn-sm' onclick='anchortag(event,this.href);'>Transfer</a><div class='btn-group' role='group'><button type='button' class='btn btn-warning btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Inspect<span class='caret'></span></button><ul class='dropdown-menu'><li><a href='"+inspect_fabric+"' onclick='anchortag(event,this.href);'>Fabric</a></li><li><a href='"+inspect_trims+"' onclick='anchortag(event,this.href);'>Trims</a></li></ul></div><a href='"+claim+"' class='btn btn-success btn-sm' onclick='anchortag(event,this.href);'>Claim</a> </div>");
        });
    }
    
</script>

<style>
.current{
    background: linear-gradient(120deg, #00e4d0, #5983e8);
}
</style>





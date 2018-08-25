<table class="table table-bordered" id='table6'>
    <thead>
        <tr>
            <th>S.no</th>
            <th>Color</th>
            <th>Lot No</th>
            <th>Docket No</th>
            <th>Cut No</th>
            <th style='width:40%' class='act'>Actions</th>
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

    $sql_count_query = "SELECT count(*) as total 
                        FROM bai_pro3.bai_orders_db 
                        LEFT JOIN bai_pro3.cat_stat_log     ON cat_stat_log.order_tid = bai_orders_db.order_tid 
                        LEFT JOIN bai_rm_pj1.stock_report   ON bai_rm_pj1.stock_report.item = bai_pro3.cat_stat_log.compo_no 
                        LEFT JOIN bai_pro3.plandoc_stat_log ON bai_pro3.plandoc_stat_log.order_tid = bai_orders_db.order_tid
                        RIGHT JOIN bai_rm_pj1.inspection_complaint_db  ON bai_rm_pj1.inspection_complaint_db.reject_lot_no = lot_no WHERE order_style_no = '$style' AND order_del_no='$schedule'"; 
    $count_result = mysqli_query($link_ui, $sql_count_query) or exit("Sql Error In getting total count");
        if(mysqli_num_rows($count_result)>0){
            $row = mysqli_fetch_array($count_result); 
            $total = $row['total'];
        }else{
            $total = 0;
        }


    $query =  "select order_col_des,bai_orders_db.order_tid,cat_ref,doc_no,lot_no,acutno,color_code FROM bai_pro3.bai_orders_db LEFT JOIN bai_pro3.cat_stat_log ON cat_stat_log.order_tid = bai_orders_db.order_tid LEFT JOIN bai_rm_pj1.stock_report ON bai_rm_pj1.stock_report.item = bai_pro3.cat_stat_log.compo_no LEFT JOIN bai_pro3.plandoc_stat_log ON bai_pro3.plandoc_stat_log.order_tid = bai_orders_db.order_tid RIGHT JOIN bai_rm_pj1.inspection_complaint_db  ON bai_rm_pj1.inspection_complaint_db.reject_lot_no = lot_no";    
    $query_last = '';
    $sql_select_query = $query.$query_last." WHERE order_style_no = '$style' AND order_del_no='$schedule' 
                                            limit $limit offset $start";    
    $query_result=mysqli_query($link_ui, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
    if ($query_result->num_rows > 0) {
        $i=0;
        while($row = $query_result->fetch_assoc()) {
            $i++;
            $sno = $i;
            $cut_no = $row['acutno'];
            $docket_no = $row['doc_no'];
            $lot_no = $row['lot_no'];
            $color_code = $row['color_code'];
            $color = $row['order_col_des'];

            echo "<tr>
                    <td>".$sno."</td>
                    <td>".$color."</td>
                    <td>".$lot_no."</td>
                    <td>".$docket_no."</td>
                    <td>".chr($color_code).'00'.$cut_no."</td>  
                    <td><div class='btn-group'>
                        <a href='#' class='btn btn-primary btn-sm'>View</a>
                        </div>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan=6><div class='alert alert-danger' align='center'>No Data Found</div></td></tr>";
    }    
    $link_ui->close();

?>



<script>
    $(document).ready(function() {
        var url = "<?php  echo base64_encode('/sfcs_app/app/workorders/controllers/server_processing.php'); ?>";
       
        var values = {'order_del_no':'<?= $schedule ?>','order_style_no':'<?= $style ?>'};
        var query = "<?= $query ?>";
        var fields = {'order_col_des':'order_col_des','lot_no':'lot_no','doc_no':'doc_no','acutno':'acutno',
                      'color_code':'color_code'};
        var format = {'3':"chr($color_code).'00'.$acutno",'4':'nil'};
        var href_attr = {'order_tid':'order_tid','cat_ref':'cat_ref','doc_no':'doc_no','acutno':'acutno'};
            
        var table = $('#table6').DataTable({
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
            var order_tid = $(this).find('input')[0].value;
            var cat_ref = $(this).find('input')[1].value;
            var doc_no = $(this).find('input')[2].value;
            var acutno = $(this).find('input')[3].value;    
            
            var url = '<?= base64_encode("\sfcs_app\app\cutting\controllers\lay_plan_preparation\Book3_Print.php") ?>&order_tid='+order_tid+'&cat_ref='+cat_ref+'&doc_id='+doc_no+'&cut_no='+acutno;
            $(this).find('p').after("<div  class='btn-group'><a href='?r="+url+"' onclick='anchortag(event,this.href)' class='btn btn-primary btn-sm'>View</a></div>");
        });
    }
</script>      
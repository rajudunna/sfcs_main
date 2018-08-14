<table class="table table-bordered" id=''>
    <thead>
        <tr>
            <th>S.no</th>
            <th>Style</th>
            <th>Schedule</th>
            <th>Color</th>
            <th>Order Qty</th>
            <th>Revised(Y/N)</th>
            <th>Revised Qty</th>
        </tr>
    </thead>
    <tbody>

<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/template/dbconf.php');
    // $style = $_GET['style'];
    // $schedule = $_GET['schedule'];

    $style = 'A0023SS9       ';
    $schedule = '547289';
    $start = 0;
    $limit = 15;
    $total = 0;
    $sum = '';
    for($i=1;$i<=50;$i++){
        if($i<10)
            $sum.= "order_s_s0$i+";
        else
            $sum.= "order_s_s$i+";
    }     
    $sum = rtrim($sum,'+');
    $sql_count_query = "select count(*) as total from bai_pro3.bai_orders_db 
                        WHERE order_style_no = '$style' AND order_del_no='$schedule'"; 
    $count_result = mysqli_query($link_ui, $sql_count_query) or exit("Sql Error In getting total count");
        if(mysqli_num_rows($count_result)>0){
            $row = mysqli_fetch_array($count_result); 
            $total = $row['total'];
        }else{
            $total = 0;
        }

    $query =  "select SUM($sum) as order_qty,order_col_des from bai_pro3.bai_orders_db";    
    $query_last = 'group by order_col_des';
    $sql_select_query = $query." WHERE order_style_no = '$style' AND order_del_no='$schedule' $query_last 
                                            limit $limit offset $start";    
    $query_result=mysqli_query($link_ui, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
    if ($query_result->num_rows > 0) {
        $i=0;
        while($row = $query_result->fetch_assoc()) {
            $i++;
            $sno = $i;
            $order_qty = $row['order_qty'];
            $order_col_des = $row['order_col_des'];

            $query =  "select SUM($sum) as revised_qty from bai_pro3.bai_orders_db_confirm";    
            $query_last = 'group by order_col_des';
            $sql_select_query = $query." WHERE order_style_no = '$style' AND order_del_no='$schedule' 
                                         AND order_col_des ='".$row['order_qty']."'".$query_last;    
            $query_result1=mysqli_query($link_ui, $sql_select_query) or exit("Sql Error2=".mysqli_error($GLOBALS["___mysqli_ston"]));

            $revised_qty = 0;
            $status = "<label class='label label-danger label-sm'>NO</label>";
            if(mysqli_num_rows($query_result1)>0){
                $row = msqli_fetch_array($query_result1);
                $revised_qty = $row['revised_qty'];
                $status = "<label class='label label-success label-sm'>YES</label>";
            }
            echo "<tr>
                    <td>".$sno."</td>
                    <td>".$style."</td>
                    <td>".$schedule."</td>
                    <td>".$order_col_des."</td>
                    <td>".$order_qty."</td>
                    <td>".$status."</td>
                    <td>".$revised_qty."</td>
                </tr>";
        }
    } else {
        echo "<div class='alert alert-info' align='center'>No Data Found</div>";
    }    
    $link_ui->close();

?>
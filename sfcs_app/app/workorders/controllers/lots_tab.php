

<table class="table table-bordered">
    <thead>
        <tr>
            <th>S.no</th>
            <th>Lot Number</th>
            <th>Batch Number</th>
            <th>Qyantity</th>
            <th>Prodct Group</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

        <?php

            // $style = $_GET['style'];
            // $shedule = $_GET['shedule'];

            $style = 'JJP316F8';
            $shedule = '520178';
        
            include($_SERVER['DOCUMENT_ROOT'].'/template/dbconf.php');

            $sql_select_query = "select order_style_no as style,order_del_no as shedule,bai_orders_db.order_tid,compo_no,lot_no,batch_no,product_group,qty_rec as qty from bai_pro3.bai_orders_db left join bai_pro3.cat_stat_log on cat_stat_log.order_tid = bai_orders_db.order_tid left join bai_rm_pj1.stock_report on bai_rm_pj1.stock_report.item = bai_pro3.cat_stat_log.compo_no where order_style_no='$style' and order_del_no='$shedule'";
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
                            <td><a href='#' class='btn btn-primary btn-xs'>Receive</a> |
                                <a href='#' class='btn btn-danger btn-xs'>Delete</a> |
                                <a href='#' class='btn btn-info btn-xs'>Transfer</a> |
                                <a href='#' class='btn btn-warning btn-xs'>Inspect</a> |
                                <a href='#' class='btn btn-success btn-xs'>Claim</a>    
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
      



   

<?php
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    if(isset($_POST['formSubmit']))
    {
       $ids=$_POST['ids'];
       $recutval = $_POST['recutval'];
       $cat = $_POST['cat'];
       $bcd_id = $_POST['bcd_ids'];
       $size = $_POST['size'];
       $sizes_val_array = array();
       $sizes = '';
       $values = '';
       $sizes_a = '';
       $bcd = $bcd_id[0];
    //    echo $bcd;
    //    die();
      //retreaving style,schedule,color and size wise cumulative quantities to store in plan_doc_stat_log and recut_v2
        $qry_details = "SELECT style,SCHEDULE,color FROM `bai_pro3`.`rejections_log` r LEFT JOIN `bai_pro3`.`rejection_log_child` rc ON rc.`parent_id` = r.`id` 
        WHERE rc.`bcd_id` = $bcd";
        // echo $qry_details;
        // die();
        $qry_details_res = $link->query($qry_details);
        while($row_row = $qry_details_res->fetch_assoc()) 
        {
            $style = $row_row['style'];
            $scheule = $row_row['SCHEDULE'];
            $color = $row_row['color'];
        }
        //getting order tid
        $qry_order_tid = "SELECT order_tid FROM `bai_pro3`.`bai_orders_db` WHERE order_style_no = '$style' AND order_del_no ='$scheule' AND order_col_des = '$color'";
        // echo $qry_order_tid;
        $res_qry_order_tid = $link->query($qry_order_tid);
        while($row_row_row = $res_qry_order_tid->fetch_assoc()) 
        {
            $order_tid = $row_row_row['order_tid'];
        }
        // echo 'Hi'.$order_tid;
        $recutval_sizes = array();
        foreach($recutval as $key=>$value)
        {
            $size_act = $size[$key];
            $recutval_sizes[$size_act][] = $recutval[$key];
        }
        foreach($recutval_sizes as $key=>$value)
        {
            foreach($value as $val)
            {
                $sizes_val_array[$key] += $val;
            }
        }
        // var_dump($sizes_val_array);
        foreach($sizes_val_array as $key=>$value)
        {
            $sizes .= 'p_'.$key.',';
            $sizes_a .= 'a_'.$key.',';
            $values .= $value.','; 
        }
        $sizes_p = rtrim($sizes,",");
       $sizes_a = rtrim($sizes_a,",");
        $values = rtrim($values,",");
        // echo $sizes;
        // die();  
        // var_dump($cat);
        //getting cat stat log
        
        $date=date("Y-m-d", mktime(0,0,0,date("m") ,date("d"),date("Y")));
        foreach($cat as $key=>$value)
        {
            //$qry_to_get = "SELECT * FROM  `bai_pro3`.`cat_stat_log` WHERE  order_tid = \"$order_tid\" and category = '$value'";
            $qry_to_get = "SELECT * FROM  `bai_pro3`.`cat_stat_log` WHERE  order_tid = 'CA3428F8       540734415 5GXBlue Granite           ' and category = 'Body'";
            $res_qry_to_get = $link->query($qry_to_get);
            while($row_cat_ref = $res_qry_to_get->fetch_assoc()) 
            {
                // var_dump($row_cat_ref);
                $cat_ref =$row_cat_ref['tid'];

            }
            // echo $cat_ref;
            $sql2="select count(pcutdocid) as \"count\" from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref";
            // echo $sql2;
            mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

            while($sql_row2=mysqli_fetch_array($sql_result2))
            {
                $count=$sql_row2['count'];
            }

            if($count==NULL)
            {
                $count=0;
            }
            //$sql="select * from $bai_pro3.allocate_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and mk_status!=9 ORDER BY tid DESC LIMIT 0,1";
            $sql="select * from $bai_pro3.allocate_stat_log where order_tid= 'CA3428F8       540734415 5GXBlue Granite           ' and cat_ref=$cat_ref and mk_status!=9 ORDER BY tid DESC LIMIT 0,1";
            // echo $sql."<br>";
            $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            // var_dump($sql_result);
            while($sql_row=mysqli_fetch_array($sql_result))
            {
                $cuttable_ref=$sql_row['cuttable_ref'];
                $allocate_ref = $sql_row['tid'];
                $ratio  = $sql_row['ratio'];
            }
            $mk_ref = '0';
            $ratio = 1;
            $pliespercut = 1;
            $remarks = 'Recut';
            $pcutdocid=$order_tid."/".$allocate_ref."/".$count;
            $sql_plandoc="insert into $bai_pro3.plandoc_stat_log(pcutdocid, date, cat_ref, cuttable_ref, allocate_ref, mk_ref, order_tid, pcutno, ratio,a_plies,p_plies,remarks,$sizes_p,$sizes_a)values  (\"$pcutdocid\", \"$date\", $cat_ref, $cuttable_ref, $allocate_ref, $mk_ref, \"$order_tid\", $count, $ratio,$pliespercut,$pliespercut,\"$remarks\",$values,$values)";
            //mysqli_query($link,$sql_plandoc) or exit("While inserting into the plan doc stat log".mysqli_error($GLOBALS["___mysqli_ston"]));
            $insert_id=mysqli_insert_id($link);
            $sql_recut_v2="insert into $bai_pro3.recut_v2 (date,cat_ref,order_tid,pcutno,acutno,remarks,$sizes_p,$sizes_a,a_plies,p_plies,doc_no) values (\"".date("Y-m-d")."\",".$cat_ref.",\"$order_tid\",$count,$count,\"".$remarks."\",$values,$values,$pliespercut,$pliespercut,$insert_id)";
            //mysqli_query($link,$sql_recut_v2) or exit("While inserting into the recut v2".mysqli_error($GLOBALS["___mysqli_ston"]));
        }
        // var_dump($size);
        foreach($bcd_id as $key=>$act_id)
        {
            $recut_allowing_qty = $recutval[$key];
            // $rejected_qty = 
            $retreaving_bcd_data = "SELECT * FROM `brandix_bts`.`bundle_creation_data` WHERE id IN ($act_id) ORDER BY barcode_sequence";
            $retreaving_bcd_data_res = $link->query($retreaving_bcd_data);
            while($row_bcd = $retreaving_bcd_data_res->fetch_assoc()) 
            {
                $bcd_act_id = $row_bcd['id'];
                $bundle_number = $row_bcd['bundle_number'];
                $operation_id = $row_bcd['operation_id'];
                $child_id = $ids[$bcd_act_id];
                $retreaving_rej_qty = "SELECT * FROM `bai_pro3`.`rejection_log_child` where id = $child_id";
                $retreaving_rej_qty_res = $link->query($retreaving_rej_qty);
                while($child_details = $retreaving_rej_qty_res->fetch_assoc()) 
                {
                    $actual_allowing_to_recut = $child_details['rejected_qty']-($child_details['recut_qty']+$child_details['replaced_qty']);
                    // $recut_allowing_qty = 
                    if($actual_allowing_to_recut <= $recut_allowing_qty)
                    {
                        $to_add = $actual_allowing_to_recut;
                        $recut_allowing_qty = $recut_allowing_qty - $actual_allowing_to_recut;
                    }
                    else
                    {
                        $to_add = $recut_allowing_qty;
                        $recut_allowing_qty = 0;
                    }
                    $inserting_into_recut_v2_child = "INSERT INTO `bai_pro3`.`recut_v2_child` (`parent_id`,`bcd_id`,`bundle_number`,`opertion_id`,`rejected_qty`,`recut_qty`,`recut_reported_qty`,`issued_qty`)
                    VALUES($insert_id,$bcd_act_id,$bundle_number,$operation_id,$actual_allowing_to_recut,$to_add,0,0)";
                    //mysqli_query($link,$inserting_into_recut_v2_child) or exit("While inserting into the recut v2 childe".mysqli_error($GLOBALS["___mysqli_ston"]));

                    $update_rejection_log_child = "update $bai_pro3.rejection_log_child set recut_qty = recut_qty+$to_add where bcd_id = $bcd_act_id";
                    //mysqli_query($link,$update_rejection_log_child) or exit("While updating rejection log child".mysqli_error($GLOBALS["___mysqli_ston"]));

                    $update_rejection_log = "update $bai_pro3.rejection_log set recut_qty = recut_qty+$to_add,remaining_qty = remaining_qty - $to_add where style = '$style' and schedule = '$scheule' and color = '$color'";
                    //mysqli_query($link,$update_rejection_log) or exit("While updating rejection log".mysqli_error($GLOBALS["___mysqli_ston"]));
                }
            }
        }    
    }
?>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header">Recut Detailed View
                <button type="button" class="close"  id = "cancel" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id='main-content'>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog" style="width: 80%;  height: 100%;">
        <div class="modal-content">
            <div class="modal-header">Recut Raise form
                <button type="button" class="close"  id = "cancel" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="index.php?r=<?php echo $_GET['r']?>" name= "smartform" method="post" id="smartform">
                    <div class='panel-body' id="dynamic_table_panel">	
                            <div id ="dynamic_table1"></div>
                    </div>
                    <div class="pull-right"><input type="submit" class="btn btn-primary disable-btn smartbtn submission" value="Submit" name="formSubmit" id="smartbtn" onclick="validating();"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog" style="width: 80%;  height: 100%;">
        <div class="modal-content">
            <div class="modal-header">Rejection Replace form
                <button type="button" class="close"  id = "cancel" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="index.php?r=<?php echo $_GET['r']?>" name= "smartformreplace" method="post" id="smartform">
                    <div class='panel-body' id="dynamic_table_panel">	
                            <div id ="dynamic_table2"></div>
                    </div>
                    <div class="pull-right"><input type="button" class="btn btn-primary disable-btn smartbtn submission" value="Submit" name="formSubmit1" id="smartbtn" onclick="validationreplace();"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class='row'>
    <div class='panel panel-primary'>
        <div class='panel-heading'>
            <b>RECUT DASHBOARD - View</b>
        </div>
        <div class='panel-body'>
           <table class = 'col-sm-12 table-bordered table-striped table-condensed'><thead><th>S.No</th><th>Style</th><th>Schedule</th><th>Color</th><th>Rejected quantity</th><th>Recut Allowed Quantity</th><th>Replaced Quantity</th><th>Eligibility to allow recut</th><th>View</th><th>Recut</th><th>Replace</th>
            </thead>
            <?php  
            $s_no = 1;
            $blocks_query  = "SELECT id,style,schedule,color,rejected_qty,recut_qty,remaining_qty,replaced_qty FROM $bai_pro3.rejections_log WHERE remaining_qty <> 0 and rejected_qty > 0";
            // echo $blocks_query;
            $blocks_result = mysqli_query($link,$blocks_query) or exit('Rejections Log Data Retreival Error');        
            while($row = mysqli_fetch_array($blocks_result))
            {  

                echo "<tr><td>$s_no</td>";
                $id = $row['id'];
                echo "<td>".$row['style']."</td>";
                echo "<td>".$row['schedule']."</td>";
                echo "<td>".$row['color']."</td>";
                echo "<td>".$row['rejected_qty']."</td>";
                echo "<td>".$row['recut_qty']."</td>";
                echo "<td>".$row['replaced_qty']."</td>";
                echo "<td>".$row['remaining_qty']."</td>";
                echo "<td><button type='button'class='btn btn-primary' onclick='viewrecutdetails(".$id.")'>View</button></td>";
                echo "<td><button type='button'class='btn btn-danger' onclick='editrecutdetails(".$id.")'>Recut</button></td>"; 
                echo "<td><button type='button'class='btn btn-success' onclick='editreplacedetails(".$id.")'>Replace</button></td>"; 
                echo "</tr>";
                $s_no++;
            }
            ?>
             </table>
        </div>
    </div>
</div>
<style>
    .container{
        border : 1px solid #e5e5e5;
        border-radius : 3px;
        min-height : 500px;
    }
    .block{
        color  : #000;
        background : #fff;
        padding : 22px;
        font-size : 16px; 
    }
    .inner-block{
        height : 120px;
        border : 1px solid #3c3c3c;
        border-radius : 5px;
        padding : 15px;
    }
    .label{
        color : #2D2D2D;
        font-size : 15px;
    }
    d{
        font-size : 15px;
    }
    .blue{
        background : #0D8F79;
    }

    @-webkit-keyframes blinker {
        from { opacity: 1.0; }
        to { opacity: 0.0; }
    }
    .blink{
        text-decoration: blink;
        -webkit-animation-name: blinker;
        -webkit-animation-duration: 0.5s;
        -webkit-animation-iteration-count:infinite;
        -webkit-animation-timing-function:ease-in-out;
        -webkit-animation-direction: alternate;
    }
    .modal{
        width : auto;
    }
    .modal-body{
	    max-height: calc(100vh - 200px);
	    overflow-y: auto;
	}
	.modal{
	 	opacity : 0.1;
	}
	.modal-header{
		background : #0D8DE2;
		color : #fff;
	}
    .modal-lg{
        width : 1200px;
    }
    .modal-content{
        height : 650px;
    }
    .modal-body{
        height : 600px;
    }
    .block a{
        color : #fff;
        padding : 15px;
        height : 100px;
        font-weight : bold;
    }
    a:hover{
        cursor : pointer;
        text-decoration : none;
    }
    v{
        color : #fff;
        text-align : left; 
        display : block;
        font-size : 12px;
    }
    c{
        color : #FFFF55;
        text-align : left;   
    }

    //Tool tip break
    .tooltip{
        width : 150px;
    }
    .tooltip-inner {
        max-width: 300px;
        white-space: nowrap;
        margin:0;
        padding:5px;
    }
</style>


<script>
function viewrecutdetails(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $.ajax({

			type: "POST",
			url: function_text+"?recut_id="+id,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('main-content').innerHTML = response;
                $('#myModal').modal('toggle');
            }

    });
}
function editrecutdetails(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $.ajax({

			type: "POST",
			url: function_text+"?recut_id_edit="+id,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('dynamic_table1').innerHTML = response;
                $('#myModal1').modal('toggle');
            }

    });
}
function editreplacedetails(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $.ajax({

			type: "POST",
			url: function_text+"?replace_id_edit="+id,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('dynamic_table2').innerHTML = response;
                $('#myModal2').modal('toggle');
            }

    });
}
function validationreplace()
{
    var total_rows = $('#no_of_rows').val();
    var sizes = [];
    var values =[];
    var sizes_value = {};
    for(var i=1; i<=total_rows;i++)
    {
        var size_id = i+"size";
        sizes.push(document.getElementById(size_id).innerHTML);
        values.push(Number(document.getElementById(i).value)); 
    }
    for (var i = 0; i < sizes.length; i++)
    {
        sizes_value[sizes[i]] = 0;
        // console.log(sizes_value);
    }
    for (var i = 0; i < sizes.length; i++)
    {
        sizes_value[sizes[i]] = Number(sizes_value[sizes[i]])+Number(values[i]);
    }
    $.each(sizes_value, function( key, value )
    {
        var id = key;
        var max_replacable_qty = document.getElementById(id).innerHTML;
        if(max_replacable_qty < value)
        {
            alert("work");
        }
        else
        {
            alert("notwork");
        }

    });
}
</script>
<style>
.modal-body {
    max-height:600px; 
    overflow-y: auto;
}

</style>
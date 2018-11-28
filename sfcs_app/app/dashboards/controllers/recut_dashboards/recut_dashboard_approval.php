<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
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
            <div class="modal-header">Markers view
                <button type="button" class="close"  id = "cancel" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="index.php?r=<?php echo $_GET['r']?>" name= "smartform" method="post" id="smartform">
                    <div class='panel-body' id="dynamic_table_panel">	
                            <div id ="dynamic_table1"></div>
                    </div>
                    <div class="pull-right"><input type="submit" class="btn btn-primary" value="Submit" name="formSubmit"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class='row'>
    <div class='panel panel-primary'>
        <div class='panel-heading'>
            <b>Re Cut Approval Dashboard - View</b>
        </div>
        <div class='panel-body'>
           <table class = 'col-sm-12 table-bordered table-striped table-condensed'><thead><th>S.No</th><th>Docket Number</th><th>Style</th><th>Schedule</th><th>Color</th><th>Rejected quantity</th><th>Recut Allowed Quantity</th><th>Replaced Quantity</th><th>Eligibility to allow recut</th><th>View recut</th><th>Markers view</th><th>Approval</th>
            </thead>
            <?php  
            $s_no = 1;
            $blocks_query  = "SELECT SUM(rejected_qty)as rejected_qty,parent_id as doc_no,SUM(recut_qty)as recut_qty,SUM(recut_reported_qty) as recut_reported_qty,SUM(issued_qty)as issued_qty,r.`mk_ref`,b.`style_id`AS style,b.`order_col_des` AS color,b.`order_del_no` as schedule
            FROM `bai_pro3`.`recut_v2_child` rc 
            LEFT JOIN bai_pro3.`recut_v2` r ON r.doc_no = rc.`parent_id`
            LEFT JOIN bai_pro3.`bai_orders_db` b ON b.order_tid = r.`order_tid`
            WHERE r.mk_ref != '0'
            GROUP BY parent_id";
            $blocks_result = mysqli_query($link,$blocks_query) or exit('Rejections Log Data Retreival Error');        
            while($row = mysqli_fetch_array($blocks_result))
            {
                $id = $row['doc_no'];
                if($row['act_cut_status'] == '1')
                {
                    $button_html = "Approved";
                }
                else
                {
                    $button_html = "<button type='button'class='btn btn-danger' onclick='viewmarkerdetails(".$id.",1)'>Approve</button>";
                }
                echo "<tr><td>$s_no</td>";
                echo "<td>".$row['doc_no']."</td>";
                echo "<td>".$row['style']."</td>";
                echo "<td>".$row['schedule']."</td>";
                echo "<td>".$row['color']."</td>";
                echo "<td>".$row['rejected_qty']."</td>";
                echo "<td>".$row['recut_qty']."</td>";
                echo "<td>".$row['recut_reported_qty']."</td>";
                echo "<td>".$row['issued_qty']."</td>";
                echo "<td><button type='button'class='btn btn-primary' onclick='viewrecutdetails(".$id.")'>Recut View</button></td>";
                echo "<td><button type='button'class='btn btn-success' onclick='viewmarkerdetails(".$id.",2)'>Marker View</button></td>";
                echo "<td>$button_html</td>"; 
                echo "</tr>";
                $s_no++;
            }
            ?>
             </table>
        </div>
    </div>
</div>
<script>
function viewrecutdetails(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $.ajax({

			type: "POST",
			url: function_text+"?recut_doc_id="+id,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('main-content').innerHTML = response;
                $('#myModal').modal('toggle');
            }

    });

}
function viewmarkerdetails(id,flag)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    var id_array = [id,flag];
    $.ajax({

			type: "POST",
			url: function_text+"?markers_view_docket="+id_array,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('dynamic_table1').innerHTML = response;
                $('#myModal1').modal('toggle');
            }

    });

}
</script>
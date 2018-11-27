<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
?>
<?php
if(isset($_POST['formSubmit']))
{
	$cat=$_POST['cat'];
	$mklen=$_POST['mklen'];
	$plies=$_POST['plies'];
	$order_tid=$_POST['order_tid'];
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
	$module=$_POST['module'];
	$cat_name=$_POST['cat_name'];
    $doc_nos=$_POST['doc_no_ref'];
    $size = $_POST['size'];
    $ratioval =$_POST['ratioval'];
	$codes='2';
    $docket_no = '';
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/mo_filling.php',4,'R'));
    $query="SELECT* FROM $bai_pro3.`cuttable_stat_log` WHERE order_tid='$order_tid'";
    $sql_result111=mysqli_query($link, $query) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row111=mysqli_fetch_array($sql_result111))
    {
        $tid=$sql_row111['tid'];
    }
    $sql1="insert into $bai_pro3.maker_stat_log(date,cat_ref,order_tid,mklength) values (\"".date("Y-m-d")."\",".$cat[$i].",\"$order_tid\",".$mklen[$i].")";
    mysqli_query($link, $sql1) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
    $ilastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);


    $sql1="update $bai_pro3.recut_v2 set p_plies=".$plies[$i].",a_plies=".$plies[$i].",mk_ref=$ilastid where doc_no=".$doc_nos;
    // echo $sql1;
    mysqli_query($link, $sql1) or exit("Sql Error45".mysqli_error($GLOBALS["___mysqli_ston"]));


    for($j=0;$j<sizeof($size);$j++)
    {
        $qty_act = array_sum($ratioval[$size[$j]])*$plies;
        $qty_ind_ratio  =  array_sum($ratioval[$size[$j]]);
        $a_string = 'a_'.$size[$j];
        $p_string = 'p_'.$size[$j];
        $sql="insert into $bai_pro3.bai_qms_db (qms_style,qms_schedule,qms_color,log_date,qms_size,qms_qty,qms_tran_type,remarks) values (\"$style\",\"$schedule\",\"$color\",\"".date("Y-m-d")."\",\"".str_replace("a_","",$size[$j])."\",".($qty_act).",9,\"$module-".$doc_nos."\")";
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
        $update_qry = "update  $bai_pro3.recut_v2 set $a_string=$qty_ind_ratio,$p_string=$qty_ind_ratio where doc_no = $doc_nos";
        mysqli_query($link, $update_qry) or exit("while updating into recut v2".mysqli_error($GLOBALS["___mysqli_ston"]));
    }

    $sql="insert into $bai_pro3.recut_track(doc_no,username,sys_name,log_time,level,status) values(\"".$doc_nos."\",\"".$username."\",\"".$hostname[0]."\",\"".date("Y-m-d H:i:s")."\",\"".$codes."\",\"".$status."\")";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        
    //calling the function to insert to bundle craetion data and cps log
    // $inserted = doc_size_wise_bundle_insertion_recut($docno[$i]);
    // if($inserted){
    // 	//Inserted Successfully
    // }
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
            <div class="modal-header">Markers Update Form
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
            <b>Re Cut Issue Dashboard - View</b>
        </div>
        <div class='panel-body'>
           <table class = 'col-sm-12 table-bordered table-striped table-condensed'><thead><th>S.No</th><th>Docket Number</th><th>Style</th><th>Schedule</th><th>Color</th><th>Rejected quantity</th><th>Recut Allowed Quantity</th><th>Replaced Quantity</th><th>Eligibility to allow recut</th><th>View</th><th>Recut</th>
            </thead>
            <?php  
            $s_no = 1;
            $blocks_query  = "SELECT SUM(rejected_qty)as rejected_qty,parent_id as doc_no,SUM(recut_qty)as recut_qty,SUM(recut_reported_qty) as recut_reported_qty,SUM(issued_qty)as issued_qty,r.`mk_ref`,b.`style_id`AS style,b.`order_col_des` AS color,b.`order_del_no` as schedule
            FROM `bai_pro3`.`recut_v2_child` rc 
            LEFT JOIN bai_pro3.`recut_v2` r ON r.doc_no = rc.`parent_id`
            LEFT JOIN bai_pro3.`bai_orders_db` b ON b.order_tid = r.`order_tid`
            GROUP BY parent_id";
            $blocks_result = mysqli_query($link,$blocks_query) or exit('Rejections Log Data Retreival Error');        
            while($row = mysqli_fetch_array($blocks_result))
            {
                $id = $row['doc_no'];
                if($row['mk_ref'] == '0')
                {
                    $button_html = "<button type='button'class='btn btn-danger' onclick='editmarkers(".$id.")'>Update Markers</button>";
                }
                else if($row['approval_status'] == '0')
                {
                    $button_html = "Markers updated and Waiting for Approval";
                }
                else
                {
                    $button_html = "<button type='button'class='btn btn-danger' onclick='issuemodule(".$id.")'>Issue To Module</button>";
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
                echo "<td><button type='button'class='btn btn-primary' onclick='viewrecutdetails(".$id.")'>View</button></td>";
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
function editmarkers(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $.ajax({

			type: "POST",
			url: function_text+"?markers_update_doc_id="+id,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('dynamic_table1').innerHTML = response;
                $('#myModal1').modal('toggle');
            }

    });

}
</script>
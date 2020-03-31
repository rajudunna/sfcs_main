<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
?>
<?php

?>
</br></br>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header">Recut Detailed View
                <button type="button" class="btn btn-danger" value="Close" id = "cancel" data-dismiss="modal" style="float: right;">Close</button>
            </div>
            <div class="modal-body" id='main-content'>
                <div class="ajax-loader" class="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;display:none;">
                                <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog" style="width: 80%;  height: 100%;">
        <div class="modal-content">
            <div class="modal-header">Issuing to Module Form
                <button type="button" class="btn btn-danger" value="Close" id = "cancel" data-dismiss="modal" style="float: right;">Close</button>
            </div>
            <div class="modal-body">
                <form action="index.php?r=<?php echo $_GET['r']?>" name= "smartform" method="post" id="smartform" onsubmit='return validationfunctionissue();'>
                    <div id='pre_pre'>
                        <div class='panel-body' id="dynamic_table_panel">
                            <div class="ajax-loader" class="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;display:none;">
                                <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
                            </div>  
                                <div id ="dynamic_table2"></div>
                        </div>
                        <div class="pull-right"><input type="submit" class="btn btn-primary" value="Submit" name="formIssue"></div>
                    </div>
                    <div id='post_post'>
                        <div class='panel-body'>    
                             <b style='color:red'>Please wait while Issuing To Module!!!</b>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class='row'>
    <div class='panel panel-primary'>
        <div class='panel-heading'>
            <b>ReCut Detail Report</b>
        </div>
        <div class='panel-body'>
		<form method="post" name="input" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>">
			<div class="col-sm-2 form-group">
				<label for='sdate'>Start Date  </label>
				<input  type='text' class="form-control" id="sdate" data-toggle="datepicker" name="sdate" size="8" value="<?php if(isset($_REQUEST['sdate'])) { echo $_REQUEST['sdate']; } else { echo date("Y-m-d"); } ?>"> 
			</div>
			<div class="col-sm-2 form-group">
				<label for='edate'>End Date  </label>
				<input  type='text' class="form-control" data-toggle="datepicker" id="edate"  size="8" name="edate"  onchange="return verify_date();" value="<?php if(isset($_REQUEST['edate'])) { echo $_REQUEST['edate']; } else { echo date("Y-m-d"); } ?>">
			</div>	
			<div class="col-sm-2 form-group">
				<label for='schedule'>Schedule </label>
				<input  class="form-control integer" type="text"  onchange='verify_schedule()' name="schedule" id="sch" value="<?php if(isset($_REQUEST['schedule'])) { echo $_REQUEST['schedule']; } ?>">
			</div>
			<div class='col-sm-1'>
				<br>
				<input class="btn btn-success" type="submit" name="filter" value="Filter" onclick="return verify_date();">
			</div>
			
		</form>
		<hr>

           <table class = 'col-sm-12 table-bordered table-striped table-condensed' id='myTable'><thead><th>S.No</th><th>Recut Docket Number</th><th>Style</th><th>Schedule</th><th>Color</th><th>Category</th><th>Rejected quantity</th><th>Recut Raised Quantity</th><th>Recut Reported Quantity</th><th>Issued Quantity</th><th>Remaining Quantity</th><th>View</th><th>Issue</th>
            </thead>
			<?php
			if(isset($_REQUEST['filter']))
			{

			$sdate=$_REQUEST['sdate'];
			$edate=$_REQUEST['edate'];
			$schedule=$_REQUEST['schedule'];
			echo "$sdate";
            $s_no = 1;
            $blocks_query  = "SELECT SUM(rejected_qty)as rejected_qty,parent_id as doc_no,SUM(recut_qty)as recut_qty,SUM(recut_reported_qty) as recut_reported_qty,SUM(issued_qty)as issued_qty,r.`mk_ref`,b.`order_style_no` AS style,b.`order_col_des` AS color,b.`order_del_no` as schedule,fabric_status,remarks as category
            FROM `$bai_pro3`.`recut_v2_child` rc 
            LEFT JOIN $bai_pro3.`recut_v2` r ON r.doc_no = rc.`parent_id`
            LEFT JOIN $bai_pro3.`bai_orders_db` b ON b.order_tid = r.`order_tid`
			WHERE r.short_shipment_status=0 and r.date between \"$sdate\" and \"$edate\"";
			if($schedule!=0){
				$blocks_query.=" and b.order_del_no=\"$schedule\"";
			}
						
			$blocks_query.=" GROUP BY parent_id";
			//echo $blocks_query;
            $blocks_result = mysqli_query($link,$blocks_query) or exit('Rejections Log Data Retreival Error');
            if($blocks_result->num_rows > 0)
            {
                while($row = mysqli_fetch_array($blocks_result))
                {
                    $id = $row['doc_no'];
                    //chekcing this docket planned or not
                    $dock_checking_flag = 0;
                    $checking_docket_planned_qry = "SELECT * FROM `$bai_pro3`.`cutting_table_plan` WHERE doc_no = $id";
                    $result_checking_docket_planned_qry = $link->query($checking_docket_planned_qry);
                    if($result_checking_docket_planned_qry->num_rows > 0)
                    {
                        $dock_checking_flag = 1;
                    }
                    $rem_qty = $row['recut_reported_qty'] - $row['issued_qty'];

                    if($row['fabric_status'] == '98' && $row['mk_ref'] == '0')
                    {
                        $button_html = "<button type='button' style='border-color: #f4d142;border-width: 4px;' class='btn btn-danger' onclick='editmarkers(".$id.")'>Markers Rejected</button>";
                        $html_hiding = "MarkersRejected";
                    }
                    else if($row['mk_ref'] == '0')
                    {
                        $button_html = "<button type='button'class='btn btn-danger' onclick='editmarkers(".$id.")'>Update Markers</button>";
                        $html_hiding = "UpdateMarkers";
                    }
                    else if($row['fabric_status'] == '0')
                    {
                        $button_html = "Markers updated and Waiting for Approval";
                        $html_hiding = "WaitingForApproval";
                    }
                    else if($row['fabric_status'] == '99' && $dock_checking_flag == 0)
                    {
                        $button_html = "<b style='color:blue;'>Approved and Planning Pending!!!</b>";
                        $html_hiding = "Planning Pending";
                    }
                    else if($row['recut_reported_qty'] <= 0)
                    {
                        $button_html = "<b style='color:red;'>Report Pending!!!</b>";
                        $html_hiding = "ReportPending";
                    }
                    else if($rem_qty == 0)
                    {
                        $button_html = "<b style='color:red;'>Already issued</b>";
                        $html_hiding = "AlreadyIssued";
                    }
                    else
                    {
                        $button_html = "<b style='color:green;'>Ready for Issueing</b>";
                        $html_hiding = "Ready for Issueing";
                    }
                    if($html_hiding == "ReportPending")
                    {
                        if(strtolower($row['category'])=='body' or strtolower($row['front']))
                        {
                            echo "<tr><td>$s_no</td>";
                            echo "<td>".$row['doc_no']."</td>";
                            echo "<td>".$row['style']."</td>";
                            echo "<td>".$row['schedule']."</td>";
                            echo "<td>".$row['color']."</td>";
                            echo "<td>".$row['category']."</td>";
                            echo "<td>".$row['rejected_qty']."</td>";
                            echo "<td>".$row['recut_qty']."</td>";
                            echo "<td>".$row['recut_reported_qty']."</td>";
                            echo "<td>".$row['issued_qty']."</td>";
                            echo "<td>".$rem_qty."</td>";
                            echo "<td><button type='button'class='btn btn-primary' onclick='viewrecutdetails(".$id.")'>View</button></td>";
                            echo "<td style='display:none'>$html_hiding</td>"; 
                            echo "<td>$button_html</td>"; 
                            echo "</tr>";
                            $s_no++;
                        }
                    }
                    else
                    {
                        echo "<tr><td>$s_no</td>";
                        echo "<td>".$row['doc_no']."</td>";
                        echo "<td>".$row['style']."</td>";
                        echo "<td>".$row['schedule']."</td>";
                        echo "<td>".$row['color']."</td>";
                        echo "<td>".$row['category']."</td>";
                        echo "<td>".$row['rejected_qty']."</td>";
                        echo "<td>".$row['recut_qty']."</td>";
                        echo "<td>".$row['recut_reported_qty']."</td>";
                        echo "<td>".$row['issued_qty']."</td>";
                        echo "<td>".$rem_qty."</td>";
                        echo "<td><button type='button'class='btn btn-primary' onclick='viewrecutdetails(".$id.")'>View</button></td>";
                        echo "<td style='display:none'>$html_hiding</td>"; 
                        echo "<td>$button_html</td>"; 
                        echo "</tr>";
                        $s_no++;
                    }
                }
            }
            else
            {
                echo "<tr><td colspan='12' style='color:red;text-align: center;'><b>No Details Found!!!</b></td></tr>";
			}
		}else{
			echo "<tr><td colspan='12' style='color:red;text-align: center;'><b>Please select filters to get report</b></td></tr>";
		}
            ?>
             </table>
             <div id='myTable1'>
                <b style='color:red'>No Records Found</b>
             </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() 
{
    $('#myTable1').hide();
    $('#post').hide();
    $('#post_post').hide();
    // myFunction();
});
function viewrecutdetails(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $('.loading-image').show();
    $('#myModal').modal('toggle');
    $.ajax({

            type: "POST",
            url: function_text+"?recut_doc_id="+id,
            //dataType: "json",
            success: function (response) 
            {
                document.getElementById('main-content').innerHTML = response;
                $('.loading-image').hide();
            }

    });

}

function verify_date(){
	var from_date = $('#sdate').val();
	var to_date =  $('#edate').val();
	var schedule = $('#sch').val();
	if(to_date < from_date){
		sweetAlert('End Date must not be less than Start Date','','warning');
		return false;
	}
	else
	{
		return true;
	}
}

function isInt(t)
{
    if(Number(t.value) < 0 || t.value =='e' || t.value == 'E' || t.value == null)
    { 
        t.value = 0;
        return false;
    }
}
</script>

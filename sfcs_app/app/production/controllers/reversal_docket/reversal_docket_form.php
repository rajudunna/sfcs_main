
<?php
    $url = include(getFullURLLevel($_GET['r'],'/common/config/config.php',4,'R'));
    // $has_permission=haspermission($_GET['r']); 
    include(getFullURLLevel($_GET['r'],'/common/config/functions_v2.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/server_urls.php');
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/enums.php');
        
    $plantcode=$_SESSION['plantCode'];
    $username=$_SESSION['userName'];
    $good_report = '';
    $job_type = OperationCategory::CUTTING;

    if (isset($_POST['formSubmit'])) {
        $docket_number = $_POST['docket_number'];
        $components = [];
        $size_ratios = [];
        $unsorted_size_ratios = [];
        $lay_info_query = "SELECT lay.plies AS lay_plies, lay.shift, lay.lp_lay_id, dl.plies AS docket_plies, cut_report_status, dl.jm_docket_line_id, dl.jm_docket_id 
                FROM $pps.jm_docket_lines dl 
                LEFT JOIN $pps.lp_lay lay ON lay.jm_docket_line_id = dl.jm_docket_line_id 
                WHERE docket_line_number = $docket_number ORDER BY lay.created_at";
        $layInfo = mysqli_query($link,$lay_info_query);
        if($layInfo->num_rows == 0)
        {
            echo "<script>sweetAlert('In-valid docket number given Or Lay not yet reported for this docket','warning');</script>";
        } else {
            $doc_id_query = "SELECT jm_docket_id FROM $pps.jm_docket_lines where docket_line_number = $docket_number ";
            $doc_id_result = mysqli_query($link, $doc_id_query);
            while($row = mysqli_fetch_array($doc_id_result)){
                $docket_id = $row['jm_docket_id'];
            }
            // get the sizes involved in the docket
            $doc_info_query = "SELECT fg_color, doc.plies, ratio_comp_group_id, ratio_id FROM $pps.jm_dockets doc
            LEFT JOIN  $pps.jm_cut_job cut ON cut.jm_cut_job_id = doc.jm_cut_job_id
            WHERE doc.jm_docket_id = '$docket_id' ";
            $doc_info_result = mysqli_query($link, $doc_info_query);
            while ($row1 = mysqli_fetch_array($doc_info_result)) {   
                $fg_color = $row1['fg_color'];
                $doc_plies = $row1['plies'];
                $ratio_cg_id = $row1['ratio_comp_group_id'];
                $ratio_id = $row1['ratio_id'];
            }
            
            // get the size ratios involved in the docket
            $doc_sizes_query = "SELECT size, size_ratio FROM $pps.lp_ratio_size WHERE ratio_id = '$ratio_id' ";
            $doc_size_result = mysqli_query($link, $doc_sizes_query);
            while ($row2 = mysqli_fetch_array($doc_size_result)) {   
                $size = $row2['size']; 
                $size_ratio = $row2['size_ratio'];
                $unsorted_size_ratios[$size] = $size_ratio;
            }
            // sort the size ratios w.r.t the prescribed order
            foreach($sizes_order as $size) {
                if ($unsorted_size_ratios[$size]) {
                    $size_ratios[$size] = $unsorted_size_ratios[$size];
                }
            }
            // get the mul factor of the docket
            $mul_factor_query = "SELECT multiplication_factor, lp_ratio_cg_id, component_group_id FROM $pps.lp_ratio_component_group WHERE lp_ratio_cg_id = '$ratio_cg_id' ";
            $mul_factor_result = mysqli_query($link, $mul_factor_query);
            // echo "$mul_factor_query";
            while ($row3 = mysqli_fetch_array($mul_factor_result)) {   
                $mul_factor = $row3['multiplication_factor'];
                $cg_id = $row3['component_group_id'];
            }
            // get the components involved in the docket
            $components_query = "SELECT component_name FROM $pps.lp_product_component WHERE component_group_id = '$cg_id' ";
            // echo $components_query;
            $components_result = mysqli_query($link, $components_query);
            while ($row4 = mysqli_fetch_array($components_result)) {   
                $components[] = $row4['component_name'];
            }
            var_dump($components);
        }
    }
?>

<body>
<div class="panel panel-primary"> 
    <div class="panel-heading">Cutting Reversal</div>
        <div class='panel-body'>
            <div id='post_post'>
                <div class='panel-body'>    
                    <h2 style='color:red'>Please wait while Processing Your Request!!!</h2>
                </div>
            </div>
            <form method="post" name="form1" action="?r=<?php echo $_GET['r']; ?>">
                <div class="row">
                    <div class="col-md-3">
                        <label>Docket Number</label>
                        <input type="text" class='integer form-control' id="docket_number" name="docket_number" size=8 required>
                    </div>
                    </br>
                    <div class="col-md-3">
                        <input type="submit" id="delete_reversal_docket" class="btn btn-primary" name="formSubmit" value="GetLayDetails">
                    </div>
                    <img id="loading-image" class=""/>  
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog" style="width: 80%;">
            <div class="modal-content">
                <div class="modal-header">Reverse Lay
                <button type="button" class="btn btn-danger" value="Close" id = "cancel" data-dismiss="modal" style="float: right;">Close</button>
                </div>
                <div class="modal-body">
                    <form action="index-no-navi.php?r=<?php echo $_GET['r']?>" name= "smartform" method="post" id="smartform">
                        <div id ="dynamic_table1">
                        </div>
                        <div class="pull-right"><input type="submit" id='reverse' class="btn btn-primary" value="Submit" name="reversesubmit" onclick = 'hiding()'></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
	<?php
		$reasons = getRejectionReasons($job_type);
	?>
    <div class="modal hideMe" tabindex="-1" role="dialog" id="rejections-modal">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content" style="overflow:scroll; max-height:85vh">
				<div class="modal-header">
					<h5 class="modal-title">Component Level Rejections</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
                <div class='col-sm-12'>
                    <b>Docket size level quantities</b>
                    <table id='rejections_size_table' class='table table-bordered'>
                        <thead id='rejections_size_table_head'>
                            <tr>
                                <?php 
                                    foreach($size_ratios as $size => $size_ratio) {
                                        echo "<td>$size</td>";
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody id='rejections_size_table_body'>
                            <tr>
                                <?php 
                                    foreach($size_ratios as $size => $size_ratio) {
                                        echo "<td>
                                            <input id='size_ratio_$size' type='hidden' value=$size_ratio readonly />
                                            <input class='hidden_size hidden_size_act_qty' id='actual_size_qty_$size' type='number' value=$size_ratio readonly />
                                            <input class='hidden_size rej' id='rejected_size_qty_$size' type='number' value=0 readonly />
                                        </td>";
                                    }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
				<div class="modal-body col-sm-12">
                    <div class='col-sm-3'>
						<label for='rejection_code'>Size</label> 
						<select class="form-control" palceholder='Please Select' name='rejection_size' id='rejection_size' style='width:100%'>
						<option disabled selected>Please Select</option>
						<?php
                            foreach($size_ratios as $size => $size_ratio) {
                                echo "<option valiue='$size'>$size</option>";
                            }
						?>
						</select>
					</div>
					<div class='col-sm-3'>
						<label for='rejection_code'>Reason</label> 
						<select class="form-control" palceholder='Please Select' name='rejection_code' id='rejection_code' style='width:100%'>
						<option disabled selected>Please Select</option>
						<?php
							foreach($reasons as $reason) {
								$reason_id = $reason['reason_id'];
								$reason_code = $reason['internal_reason_code'];
								$reason_desc = $reason['internal_reason_description'];
								echo "<option value='$reason_id'>$reason_code - $reason_desc</option>";
							}
						?>
						</select>
					</div>
					<div class='col-sm-3'>
						<label for='component'>Component</label> 
						<select class="form-control" palceholder='Please Select' name='component' id='component' style='width:100%'>
							<option disabled selected>Please Select</option>
                            <?php
                                foreach($components as $component) {
                                    echo "<option valiue='$component'>$component</option>";
                                }
						    ?>
						</select>
					</div>
					<div class='col-sm-2'>
						<label for='quantity' class='col-sm-4'>Quantity</label> 
						<input class="form-control" type='number' name='component_rej_qty' id='component_rej_qty' style='width:100%'/>
					</div>
					<div class='col-sm-1'>
						<label><br/></label>
						<button class='form-control btn btn-sm btn-info'  style='width:100%'
							onclick="pushRejReasonQty($('#rejection_size').val(), $('#rejection_code').val(), $('#rejection_code option:selected').text(), $('#component').val(), $('#component_rej_qty').val())">+ Add</button>
					</div>
				</div>
				<div class='col-sm-12'>
					<b>Summary</b>
					<table class='table table-bordered col-sm-10' id='rejection_summary_table'>
						<thead>
							<tr>
                                <th>Size</th>
								<th>Component</th>
								<th>Reason</th>
								<th>quantity</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id='rejection_summary_table_body'>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" onclick="validateAndSaveRejections()">Save</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="cancelRejectionsModal()">Cancel</button>
				</div>
			</div>
		</div>
	</div>
<?php
if(isset($_POST['formSubmit']))
{ 
    if($layInfo)
    {
        echo "<div class='row'>
            <div class='panel panel-primary'>
                <div class='panel-heading'>
                    <b>Lay Details</b>
                </div>
                <div class='panel-body'>
                    <table class = 'col-sm-12 table-bordered table-striped table-condensed' id='myTable'>
                        <thead>
                            <th>Docket No</th>
                            <th>Lay No</th>
                            <th>Shift</th>
                            <th>Docket Plies</th>
                            <th>Lay Plies</th>
                            <th>Reverse Lay</th>
                            <th>Report Cut</th>
                            <th>Delete Cut</th>
                        </thead>";
                        $s_no = 1;
                        while($row = mysqli_fetch_array($layInfo)){
                            $docket_id = $row['jm_docket_id'];
                            $lay_id = '"'.$row['lp_lay_id'].'"';
                            $plies = $row['lay_plies'];
                            echo "<tr><td>$docket_number</td>";
                            echo "<td>$s_no</td>";
                            echo "<td>".$row['shift']."</td>";
                            echo "<td>".$row['docket_plies']."</td>";
                            echo "<td>".$row['lay_plies']."</td>";
                            if ($row['cut_report_status'] == 'OPEN' && $row['lay_plies'] > 0) {
                                echo "<td><button type='button'class='btn btn-danger'  onclick='reverseLay($lay_id)'>Reverse Lay</button></td>";
                                echo "<td><button type='button'class='btn btn-primary' id='reportcut' onclick='reportCut($lay_id)'>Report Cut</button>";
                                echo "<button type='button'class='btn btn-warning' id='addRejections' onclick='showRejectionsModalForIndex($lay_id, $plies)'>Add Rejections</button></td>";
                                // echo "<button type='button'class='btn btn-sm btn-warning' id='addRejections' onclick='cancelRejections($lay_id)'>Cancel Rejection</button></td>";
                            } else {
                                echo "<td><button type='button'class='btn btn-danger disabled'>Reverse Lay</button></td>";
                                echo "<td><button type='button'class='btn btn-primary disabled'>Report Cut</button></td>";
                            }
                            if ($row['cut_report_status'] == 'DONE') {
                                echo "<td><button type='button'class='btn btn-danger' id = 'deletecut' onclick='deleteCut($lay_id)'>Delete Cut</button></td>";
                            } else {
                                echo "<td><button type='button'class='btn btn-danger disabled'>Delete Cut</button></td>";
                            }
                            
                            $s_no++;
                        }
                echo "</div>
            </div>
        </div>";

            // echo "<script>
            //     $(document).ready(function() {
            //         $('#rejections_size_table_head').html(\"<tr>$sizes_header</tr>\");
            //         $('#rejections_size_table_body').html(\"<tr>$sizes_qtys</tr>\");
            //     });
            // </script>";
    }
}

if(isset($_POST['reversesubmit']))
{
   $reverseRollIds = $_POST['roll_ids'];
   $reverseVal = $_POST['reverseVal'];
   $lay_id = $_POST['lay_id'];
   $docket_number = $_POST['docket_number'];
   $lay_plies = 0;
   foreach($reverseRollIds as $key=>$value)
   {
       $reversalPlies = $reverseVal[$key];
       $lay_plies += $reversalPlies;
       $updateQry = "UPDATE $pps.lp_roll set plies = plies - $reversalPlies where lp_roll_id = $value";
       mysqli_query($link, $updateQry) or exit("updateQry".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
   $updateLayQty = "UPDATE $pps.lp_lay set plies = plies - $lay_plies where lp_lay_id = '$lay_id'";
   mysqli_query($link, $updateLayQty) or exit("updateQry".mysqli_error($GLOBALS["___mysqli_ston"]));

   $updateDocketQty = "UPDATE $pps.jm_docket_lines set lay_status = 'OPEN' where jm_docket_line_id = '$docket_number'";
   mysqli_query($link, $updateDocketQty) or exit("updateQry".mysqli_error($GLOBALS["___mysqli_ston"]));
   $url = '?r='.$_GET['r'].'&sidemenu=false';
   echo "<script> sweetAlert('Lay Reversed Successfully!!!','','success'); setTimeout(window.location = '$url', 2000); </script>"; 
}

?>
<?php
if(isset($_GET['sidemenu'])){
	echo "<style>
          .left_col,.top_nav{
          	display:none !important;
          }
          .right_col{
          	width: 100% !important;
            margin-left: 0 !important;
          }
	</style>";
}
?>

<style>
    .hidden_size {
        text-align: center;
        border: none;
        width: 60px;
    }   
    .rej {
        padding: 4px;
        border-radius: 2px;
        text-align: center;
        background: #DD4400;
        color: white;
    }
</style>

<script>

////////////////////////////////////////////////////////////////////////////////////////////////
    var globalRejectionQtysArray = [];
    // here selected index represents a lay id
    var currentSelectedRejIndex = null;
    const summaryRowKey = '_summary_record';
    var sizesArray = <?= json_encode($size_ratios) ?>;

    $(document).ready(function() {
        $('#post_post').hide();
    });


    // show the rejection modal for an lay 
    function showRejectionsModalForIndex(index, plies) {
		// validate if the index is not null i.e enable rejections only when click on rejections button
		if (index.trim()) {
			currentSelectedRejIndex = index;
            if (globalRejectionQtysArray[currentSelectedRejIndex]) {
                // construct the table accordingly to the already existing rejections
                constructExistingRejections(globalRejectionQtysArray[currentSelectedRejIndex]);
            } else {
                globalRejectionQtysArray[currentSelectedRejIndex] = [];
            }
			// ensure all the rejections captured under the current index are pushed appropriately to the savable object
			toggleModal(true);
            updateActualSizeQtys(plies);
		}
	}

    function constructExistingRejections(rejectionsInfo) {
        const sizes = Object.keys(rejectionsInfo);
        sizes.forEach(size => {
            $('#rejected_size_qty_'+size).val(0);
            const sizeRejsInfo = rejectionsInfo[size].rejectionDetails;
            const sizeRejQty = sizeLevelRejQty(sizeRejsInfo);
            setTotalSizeRejQty(sizeRejQty, size);
            if (sizeRejsInfo) {
                sizeRejsInfo.forEach((rejInfo,index) => {
                    const component = rejInfo.component;
                    const quantity = rejInfo.reasonQty;
                    const reason = rejInfo.reasonCode;
                    const summaryRow = `<tr id='${size+''+index+''+summaryRowKey}'><td>${size}</td><td>${component}</td><td>${reason}</td><td>${quantity}</td> \
                            <td><button onclick='popRejReasonQty("${size}","${index}")' class='btn btn-xs btn-danger'> X </button></td> \
                        </tr>`;
                    $('#rejection_summary_table_body').append(summaryRow);
                });
            } 
        });
    }

    function sizeLevelRejQty(sizeRejectionDetails) {
        const componentQty = new Map();
        let totalRejSizeQty = 0;
        sizeRejectionDetails.forEach((rejInfo,index) => {
            const component = rejInfo.component;
            const quantity = rejInfo.reasonQty;
            if(!componentQty.has(component)) {
                componentQty.set(component, 0);
            }
            const preQty = componentQty.get(component);
            componentQty.set(component, preQty + quantity);
        });
        componentQty.forEach(qty => {
            totalRejSizeQty = Math.max(totalRejSizeQty, qty);
        });
        return totalRejSizeQty;
    }

    function updateActualSizeQtys(plies) {
        const sizes = Object.keys(sizesArray);
        sizes.forEach(size => {
            const ratio = Number($('#size_ratio_'+size).val());
            $('#actual_size_qty_'+size).val(ratio * plies);
        });
    }

    function setTotalSizeRejQty(rejQty, size) {
        $('#rejected_size_qty_'+size).val(rejQty);
    }

    function updateAllRejqtysToZero() {
        const sizes = Object.keys(sizesArray);
        sizes.forEach(size => {
            $('#rejected_size_qty_'+size).val(0);
        });
    }

	// close the rejection modal
	function cancelRejectionsModal() {
		// remove all the stored rejections under the current index
		delete(globalRejectionQtysArray[currentSelectedRejIndex]);
        resetCurrentSelectedRejIndex();
		// close the modal
		toggleModal(false);
        updateAllRejqtysToZero();
		removeSummaryTable();
	}

	// reset the current selected rejection index to -1
	function resetCurrentSelectedRejIndex() {
		currentSelectedRejIndex = null;
	}


	// show or hide the modal
	function toggleModal(show) {
		if (show) {
			$('#rejections-modal').show();
		} else {
			$('#rejections-modal').hide();
		}
	}

	// validate the entered rejections and save if the info is valid
	function validateAndSaveRejections() {
        const keys = Object.keys(globalRejectionQtysArray[currentSelectedRejIndex]); 
        if(!keys.length) {
            getAlert('error', 'Select size, rejection reason, compnent and quantity');
            return;
        }
		toggleModal(false);
		removeSummaryTable();
	}

	// push the rejection ,reason and qty to the global rejections capturing object
	function pushRejReasonQty(rej_size, rej_code, rej_text, component, quantity) {
        const actualRejSizeQty = $('#actual_size_qty_'+rej_size).val();
		if (quantity <= 0 || !rej_code || !component || !rej_size) {
			getAlert('error', 'Select size, rejection reason, compnent and quantity');
			return false;
		}
        if (!globalRejectionQtysArray[currentSelectedRejIndex][rej_size]) {
            globalRejectionQtysArray[currentSelectedRejIndex][rej_size] = {
                size: rej_size,
                rejectionDetails: []
            };
        }
        const rejDetails = globalRejectionQtysArray[currentSelectedRejIndex][rej_size].rejectionDetails;
		const lastIndexOfCurrSizeRejs = rejDetails.length;
		rejDetails[lastIndexOfCurrSizeRejs] = {
			reasonCode: rej_code,
			reasonQty: Number(quantity),
			component: component,
		}
        const sizeRejQty = sizeLevelRejQty(rejDetails);
        if (sizeRejQty > actualRejSizeQty) {
            getAlert('error', 'Component rejection quantity cannot exceed eligible size quantity');
            rejDetails.pop();
            return false;
        }
        removeSummaryTable();
		constructExistingRejections(globalRejectionQtysArray[currentSelectedRejIndex]);
	}

	// remove the rejection, reason and qty from the table and also form the request object
	function popRejReasonQty(rej_size, summaryTableRowIndex) {
        let rejDontExistFlag = true;
		delete(globalRejectionQtysArray[currentSelectedRejIndex][rej_size].rejectionDetails[summaryTableRowIndex]);
        globalRejectionQtysArray[currentSelectedRejIndex][rej_size].rejectionDetails.forEach(rejInfo => {
            if (rejInfo) {
                rejDontExistFlag = false;
            }
        });
        if(rejDontExistFlag) {
            delete(globalRejectionQtysArray[currentSelectedRejIndex][rej_size]);
        }
        removeSummaryTable();
		constructExistingRejections(globalRejectionQtysArray[currentSelectedRejIndex]);
	}

	function removeSummaryTable() {
		$('#rejection_summary_table_body').html('');
	}


	// validtae if the sum(good + rej) is less than or equal to the eligible qty
	function validateEligibilityReportQty(index, key) {
		const goodQty = Number($(`#${index}reporting`).val());
		const rejQty = Number($(`#${index}rejections`).val());
		const eligibleQty = Number($(`#${index}eligible_to_report`).val());
		if ( (goodQty + rejQty) > eligibleQty) {
			getAlert('error', 'Good qty and rejection qty should not exceed eligible qty');
			$(`#${index}${key}`).val(0);
			return false;
		}
		return true;
	}

	function getAlert(mode, message) {
		sweetAlert('', message, mode);
	}

///////////////////////////////////////////////////////////////////////////////////////////////

function reverseLay(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_reverse_docket.php','R'); ?>";
    $('#myModal').modal('toggle');
    $.ajax({
            type: "POST",
            url: function_text+"?lay_id="+id,
            //dataType: "json",
            success: function (response) 
            {
                document.getElementById('dynamic_table1').innerHTML = response;
            }

    });
}

function reportCut(id) {
    $('#post_post').show();
    $('#reportcut').hide();
    var reportData = new Object();
    reportData.layId = id;
    reportData.createdUser = '<?= $username ?>';
    reportData.plantCode = '<?= $plantcode ?>';
    reportData.sizeRejections = [];
    if (globalRejectionQtysArray[id]) {
        const keys = Object.keys(globalRejectionQtysArray[currentSelectedRejIndex]);
        keys.forEach(size => {
            const sizeRejs = globalRejectionQtysArray[id][size];
            if (sizeRejs) {
                reportData.sizeRejections.push(sizeRejs);
            }
        });
    }
        }
    let bearer_token;
    const creadentialObj = {
        grant_type: 'password',
        client_id: 'pps-back-end',
        client_secret: '1cd2fd2f-ed4d-4c74-af02-d93538fbc52a',
        username: 'bhuvan',
        password: 'bhuvan'
    }
    $.ajax({
            method: 'POST',
            url: "<?php echo $KEY_LOCK_IP?>",
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            xhrFields: { withCredentials: true },
            contentType: "application/json; charset=utf-8",
            transformRequest: function (Obj) {
                var str = [];
                for (var p in Obj)
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(Obj[p]));
                return str.join("&");
            },
            data: creadentialObj
        }).then(function (result) {
            console.log(result);
            bearer_token = result['access_token'];
            $.ajax({
                    type: "POST",
                    url: "<?php echo $PPS_SERVER_IP?>/cut-reporting/cutReporting",
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded','Authorization': 'Bearer ' +  bearer_token },
                    data:  reportData,
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function (res) {            
                        //console.log(res.data);
                        console.log(res.status);
                        if(res.status)
                        {
                            $('#post_post').hide();
                            $('#reportcut').show();
                            sweetAlert('Cut Reported Successfully!!!','','success');
                            setTimeout(window.location = " <?='?r='.$_GET['r'] ?>", 2000);
                        }
                        else
                        {
                            $('#post_post').hide();
                            $('#reportcut').show();
                            swal(res.internalMessage);
                        }                       
                    },
                    error: function(res){
                        $('#loading-image').hide(); 
                        // alert('failure');
                        // console.log(response);
                        swal('Error in Reporting Cut');
                        $('#post_post').hide();
                        $('#reportcut').show();
                    }
                }); 
        }).fail(function (result) {
            console.log(result);
        }) ;
}

function deleteCut(id) {
    $('#post_post').show();
    $('#deletecut').hide();
    var reportData = new Object();
    reportData.layId = id;
    reportData.createdUser = '<?= $username ?>';
    reportData.plantCode = '<?= $plantcode ?>';
    var bearer_token;
    const creadentialObj = {
    grant_type: 'password',
    client_id: 'pps-back-end',
    client_secret: '1cd2fd2f-ed4d-4c74-af02-d93538fbc52a',
    username: 'bhuvan',
    password: 'bhuvan'
    }
    $.ajax({
        method: 'POST',
        url: "<?php echo $KEY_LOCK_IP?>",
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        xhrFields: { withCredentials: true },
        contentType: "application/json; charset=utf-8",
        transformRequest: function (Obj) {
            var str = [];
            for (var p in Obj)
                str.push(encodeURIComponent(p) + "=" + encodeURIComponent(Obj[p]));
            return str.join("&");
        },
        data: creadentialObj
    }).then(function (result) {
        console.log(result);
        bearer_token = result['access_token'];
        $.ajax({
            type: "POST",
            url: "<?php echo $PPS_SERVER_IP?>/cut-reporting/deleteCutReporting",
            headers: { 'Content-Type': 'application/x-www-form-urlencoded','Authorization': 'Bearer ' +  bearer_token },
            data:  reportData,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (res) {            
                //console.log(res.data);
                console.log(res.status);
                if(res.status)
                {
                    $('#post_post').hide();
                    $('#deletecut').show();
                    sweetAlert('Cut deleted Successfully!!!','','success');
                    setTimeout(window.location = " <?='?r='.$_GET['r'] ?>", 2000);
                }
                else
                {
                    $('#post_post').hide();
                    $('#deletecut').show();
                    swal(res.internalMessage);
                }                       
            },
            error: function(res){
                $('#loading-image').hide(); 
                // alert('failure');
                // console.log(response);
                swal('Error in Reporting Cut');
                $('#post_post').hide();
                $('#deletecut').show();
            }
        });    
    }).fail(function (result) {
        console.log(result);
    }) ;
}

function validatingReverseQty(id) {
    var size_id = id+"rems";
    var max_rem = Number(document.getElementById(size_id).innerHTML);
    var present_rep = Number(document.getElementById(id).value);
    if(max_rem < present_rep)
    {
        swal('You are reversing more than roll quantity.','','error');
        document.getElementById(id).value = 0;
    } 
}

function hiding() {
    $('#reverse').hide();
}
</script>
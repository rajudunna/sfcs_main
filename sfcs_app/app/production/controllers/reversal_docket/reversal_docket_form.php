<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=11; IE=9; IE=8; IE=7; IE=6; IE=5; IE=EDGE" />
<?php
    $url = include(getFullURLLevel($_GET['r'],'/common/config/config.php',4,'R'));
    // $has_permission=haspermission($_GET['r']); 
    include(getFullURLLevel($_GET['r'],'/common/config/m3Updations.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/server_urls.php');
    //hardcode for temp purpose
    // $operation_code = 15;
    // $access_report = $operation_code.'-G';
    // $access_qry=" select * from $central_administration_sfcs.rbac_permission where permission_name = '$access_report' and status='active'";
    // $result = $link->query($access_qry);
    // if($result->num_rows > 0){
    //     if (in_array($$access_report,$has_permission))
    //     {
    //         $good_report = '';
    //     }
    //     else
    //     {
    //         $good_report = 'readonly';
    //     }
        
    // } else {
    //     $good_report = '';
    // }

    $good_report = '';
   
?>

<style>
            /* #loading-image {
              border: 16px solid #f3f3f3;
              border-radius: 50%;
              border-top: 16px solid #3498db;
              width: 120px;
              height: 120px;
              margin-left: 40%;
              -webkit-animation: spin 2s linear infinite; /* Safari */
              animation: spin 2s linear infinite;
            }

            /* Safari */
            @-webkit-keyframes spin {
              0% { -webkit-transform: rotate(0deg); }
              100% { -webkit-transform: rotate(360deg); }
            }

            @keyframes spin {
              0% { transform: rotate(0deg); }
              100% { transform: rotate(360deg); }
            }
            #delete_reversal_docket{
                margin-top:3pt;
            } */
        </style>
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
if(isset($_POST['formSubmit']))
{ 
    if($good_report != 'readonly')
    {
        $docket_number_post = $_POST['docket_number'];
        $get_order_tid = "SELECT lay.plies AS lay_plies, lay.shift, lay.lp_lay_id, dl.plies AS docket_plies, cut_report_status FROM $pps.jm_docket_lines dl 
        LEFT JOIN $pps.lp_lay lay ON lay.jm_docket_line_id = dl.jm_docket_line_id 
        WHERE docket_line_number = $docket_number_post ORDER BY lay.created_at";
        $docketLineDetails = mysqli_query($link,$get_order_tid);
        if($docketLineDetails->num_rows == 0)
        {
            echo "<script>sweetAlert('In Valid Docket Number Given Or Lay Not Yet reported for this docket','warning');</script>";
        } else {
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
                            while($row = mysqli_fetch_array($docketLineDetails)){
                                $id = '"'.$row['lp_lay_id'].'"';
                                echo "<tr><td>$docket_number_post</td>";
                                echo "<td>$s_no</td>";
                                echo "<td>".$row['shift']."</td>";
                                echo "<td>".$row['docket_plies']."</td>";
                                echo "<td>".$row['lay_plies']."</td>";
                                if ($row['cut_report_status'] == 'OPEN' && $row['lay_plies'] > 0) {
                                    echo "<td><button type='button'class='btn btn-danger'  onclick='reverseLay(".$id.")'>Reverse Lay</button></td>";
                                    echo "<td><button type='button'class='btn btn-primary' id='reportcut' onclick='reportCut(".$id.")'>Report Cut</button></td>";
                                } else {
                                    echo "<td><button type='button'class='btn btn-danger disabled'>Reverse Lay</button></td>";
                                    echo "<td><button type='button'class='btn btn-primary disabled'>Report Cut</button></td>";
                                }
                                if ($row['cut_report_status'] == 'DONE') {
                                    echo "<td><button type='button'class='btn btn-danger' id = 'deletecut' onclick='deleteCut(".$id.")'>Delete Cut</button></td>";
                                } else {
                                    echo "<td><button type='button'class='btn btn-danger disabled'>Delete Cut</button></td>";
                                }
                                
                                $s_no++;
                            }
                    echo "</div>
                </div>
            </div>";
        }
    } else {
        echo "<script>sweetAlert('UnAuthorized','You are not allowed to reverse.','warning');</script>";
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
   echo "<script>sweetAlert('Lay Reversed Successfully!!!','','success');
   window.location = '".$url."'</script>"; 
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
<script>
$(document).ready(function() 
{
    $('#post_post').hide();
});
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
    reportData.createdUser = '';
    reportData.plantCode = '';
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
                    url: "<?php echo $PPS_SERVER_IP?>/cut-reporting/cutReporting",
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded','Authorization': 'Bearer ' +  bearer_token },
                    data:  JSON.stringify(reportData),
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
                            window.location = " <?='?r='.$_GET['r'] ?>";
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
    reportData.createdUser = '';
    reportData.plantCode = '';
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
            data:  JSON.stringify(reportData),
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
                    window.location = " <?='?r='.$_GET['r'] ?>";
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
    console.log(max_rem);
    console.log(present_rep);
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
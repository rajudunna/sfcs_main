<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'template/helper.php');

$link11 = $link; 
$sql="SELECT * FROM $bai_pro3.tbl_fabric_request_time";
$sql_result=mysqli_query($link11, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$total_records=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
    $fabric_data[] = $sql_row;
}
$rvalue = $_GET['r'];
?>


<div class="panel panel-info">
    <div class="panel-heading"><b>Fabric Request Time</b></div>
    <div class="panel-body">
        <form method="post" action="?r=<?php echo $rvalue ?>" name="buyer-form">
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered">
                    <thead  >
                        <tr>
                            <th>S No.</th>
                            <th>Date</th>
                            <th>Fabric Request Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                if($total_records=='0'){
                    $date = date('Y-m-d h:m:s');
                    echo "<tr>";
                    echo"<td>1</td>";
                    echo"<td>".$date."</td>";
                    echo"<td><input type='number' name='request_time' id='request_time' class='form-control integer' value='' min='0' max='24'></td>";
                    echo"<td></td>";

                   echo"</tr>";
                }
                    else{
                    foreach ($fabric_data as $key => $value) {                    
                ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $value['date_time'] ?></td>
                            <td>
                                <input type="number" name="request_time" id="request_time" class="form-control integer" value="<?php echo $value['request_time']?>" min='0' max='24' readonly>
                            </td>                      
                            <td><input type="checkbox" class="chkbox" value="<?php //echo $value['id']?>"></td>
                        </tr>
                <?php
                    }
                }
                ?>
                    </tbody>
                </table>
            </div>
            <div class="form-group">
                <div class="col-md-4">
                    <input type="submit" name="formsbmt" class="btn btn-primary submitbtn"><br><br>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
th {
    background-color: #337ab7;
    color: white;
} 
</style>
<?php
    if(isset($_POST['formsbmt'])){
        $sql="SELECT * FROM $bai_pro3.tbl_fabric_request_time";
        $sql_result=mysqli_query($link11, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        $total_records=mysqli_num_rows($sql_result);
        $request_time_new = $_POST['request_time'];
        $date_time_new = $_POST['date_time'];
        echo  $request_time_new;
        if($total_records=='0'){
            $date = date('Y-m-d h:m:s');
            $user_name = getrbac_user()['uname'];
            $tbl_fabric_request_time = "INSERT INTO $bai_pro3.tbl_fabric_request_time (request_time,date_time,modified_by)
            VALUES ('$request_time_new','$date','$user_name')";
            $tbl_fabric_request_time1=mysqli_query($link11, $tbl_fabric_request_time) or exit("tbl_fabric_request_time_log1 Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            $sbmtmsg = "Successfully Inserted";
            $url = 'index.php?r='.$_GET['r'];
            echo '<script>swal("'.$sbmtmsg.'")
                .then((value) => {
                    if(value){
                        window.location = "'.$url.'";
                        // location.reload(); 
                    }
                });</script>';

        }else{
           
        if(sizeof($request_time_new) > 0){
            $date = date('Y-m-d h:m:s');
            $user_name = getrbac_user()['uname'];
            $update_request_time_qry = "update $bai_pro3.tbl_fabric_request_time SET request_time ='".$request_time_new."', date_time='".$date."', modified_by='".$user_name."'";
            $update_request_time=mysqli_query($link11, $update_request_time_qry) or exit("update_request_time_qry Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            if($update_request_time != ''){
                $tbl_fabric_request_time_log = "INSERT INTO $bai_pro3.tbl_fabric_request_time_log (request_time,date_time,modified_by)
                VALUES ('$request_time_new','$date','$user_name')";        
                $tbl_fabric_request_time_log1=mysqli_query($link11, $tbl_fabric_request_time_log) or exit("tbl_fabric_request_time_log1 Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                $sbmtmsg = "Successfully updated";
            }
        } else{
            $sbmtmsg = "Error occured while submitting form. Please try again later.";
        }
        $url = 'index.php?r='.$_GET['r'];
        echo '<script>swal("'.$sbmtmsg.'")
            .then((value) => {
                if(value){
                    window.location = "'.$url.'";
                    // location.reload(); 
                }
            });</script>';
        }
    }
    
?>
<script language="JavaScript">
    $('.chkbox').change(function(){
        var bool = false;


        $(".chkbox").each(function(){
            if($(this).is(':checked')){
                bool = true;
            }
        });
        if(bool){
            $('.submitbtn').attr("disabled", !bool);
        }else{
            $('.submitbtn').attr("disabled", !bool);
        }
        if($(this).is(':checked')){
            $("#request_time").attr("readonly", !$(this).is(':checked'));
        }else{
            var defaultvalue = $("#request_time")[0].defaultValue;
            $("#request_time").val(defaultvalue);
            $("#request_time").attr("readonly", !$(this).is(':checked'));
        }
    })
</script>
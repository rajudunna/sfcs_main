<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
$link11 = $link; 

$sql="SELECT * FROM $bai_pro2.buyer_codes";
$sql_result=mysqli_query($link11, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
    // $max_allowed_date=$sql_row['bac_date'];
    $buyer_data[] = $sql_row;
}

$rvalue = $_GET['r'];
?>


<div class="panel panel-info">
    <div class="panel-heading"><b>Buyer Code Generation</b></div>
    <div class="panel-body">
        <form method="post" action="?r=<?php echo $rvalue ?>" name="buyer-form">
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered">
                    <thead  >
                        <tr>
                            <th>Sl No</th>
                            <th>Buyer Name</th>
                            <th>Buyer Code</th>
                            <th>Action</th>                 
                        </tr>
                    </thead>
                    <tbody>
                <?php
                    foreach ($buyer_data as $key => $value) {
                ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $value['buyer_name'] ?></td>
                            <td>
                                <input type="text" name="buyer_code[<?php echo $value['id'] ?>]" id="text_<?php echo $value['id']; ?>" class="form-control text_box" value="<?php echo $value['buyer_code']?>" readonly>
                            </td>
                            <td style='display: none;'>
                                <input type="hidden" name="org_buyer_code[<?php echo $value['id'] ?>]" id="text_<?php echo $value['id']; ?>" class="form-control text_box" value="<?php echo $value['buyer_code']?>" readonly>
                            </td>
                            <!-- <td class="hide"></td> -->
                            <td><input type="checkbox" name="chkbox[]" class="chkbox" value="<?php echo $value['id']?>"></td>
                        </tr>
                <?php
                    }
                ?>
                    </tbody>
                </table>
            </div>
            <div class="form-group">
                <div class="col-md-4">
                    <input type="submit" name="formsbmt" class="btn btn-primary submitbtn" disabled="true"><br><br>
                    <div><b>Note:</b>Select atleast one buyer to submit Form.</div>
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
        // var_dump($_POST['buyer_code']);
        // var_dump($_POST['org_buyer_code']);

        $buyer_codes = $_POST['buyer_code'];
        $buyer_ids = $_POST['chkbox'];
        if(sizeof($buyer_codes) > 0 && sizeof($buyer_ids) > 0){
            // for ($i=0; $i < sizeof($buyer_ids); $i++) { 
            foreach ($buyer_ids as $key => $id) {
                $update_buyer_code_qry = "update bai_pro2.buyer_codes SET buyer_code =\"$buyer_codes[$id]\" where id=".$id;
                $update_buyer_code=mysqli_query($link11, $update_buyer_code_qry) or exit("update_buyer_code_qry Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            }
            $sbmtmsg = "Successfully updated";
            
        } else{
            $sbmtmsg = "Error occured while submitting form. Please try again later.";
        }
        $url = 'index.php?r='.$_GET['r'];
        echo '<script>swal("'.$sbmtmsg.'")
            .then((value) => {
                if(value){
                    // window.location = "'.$url.'";
                    // location.reload(); 
                }
            });</script>';
        // $_POST = array();
        // echo '';
    }
?>
<script language="JavaScript">
// console.log('hello');
    // $(".submitbtn").attr("disabled", false);
    $('.chkbox').change(function(){
        var bool = false;
        $(".chkbox").each(function(){
            if($(this).is(':checked')){
                bool = true;
            }
        });
        // console.log(bool);
        if(bool){
            $('.submitbtn').attr("disabled", !bool);
        }else{
            $('.submitbtn').attr("disabled", !bool);
        }
        if($(this).is(':checked')){
            // var defaultvalue = $("#text_"+$(this).val())[0].defaultValue;
            $("#text_"+$(this).val()).attr("readonly", !$(this).is(':checked'));
        }else{
            var defaultvalue = $("#text_"+$(this).val())[0].defaultValue;
            $("#text_"+$(this).val()).val(defaultvalue);
            $("#text_"+$(this).val()).attr("readonly", !$(this).is(':checked'));
        }
    })
</script>
<title>Add New Packing Method</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />

<body>
</body>
<?php 
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/rest_api_calls.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
    $action_url = getFullURL($_GET['r'],'save_packing.php','N');
    if(isset($_REQUEST['row_id'])){
		$row_id=$_REQUEST['row_id'];
		$packing_method_code = $_REQUEST['packing_method_code'];
		$packing_description = $_REQUEST['packing_description'];
		$smv = $_REQUEST['smv'];
		$status=$_REQUEST['status'];
	}else{
		$row_id=0;
	}
    
?>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">Packing Method</div>
        <div class="panel-body">
        <form name="test" action="<?= $action_url ?>" method="POST" id='form_submt'>
            <div class="row">
                <div class="col-md-3">
        			<input type='hidden' id='row_id' name='row_id' value=<?php echo $row_id; ?> >
                    <b>Packing Method Code<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'></font></span></b><input type="text" onkeyup="return validateCodeLength(this)" class="form-control" id="packing_method_code" maxlength="16" name="packing_method_code" value="<?php echo $packing_method_code; ?>" required>
                </div>
				<div class="col-md-3">
                    <b>Packing Method Description<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'></font></span></b>
                    <textarea type="text" onkeyup="return validateLength(this)" class="form-control" id="packing_description" maxlength="31" name="packing_description" required><?php echo $packing_description; ?></textarea>
                </div>
                <div class="col-md-3">
                    <b>SMV<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'></font></span></b><input type="text" class="form-control float" id="smv" name="smv" maxlength="10" value="<?php echo $smv; ?>" required>
                </div>
                <div class="col-md-3">
                    <div class="dropdown">
                        <b>Status</b> <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'></font></span>
                        <select class="form-control" id="status" name="status" required>
                       <?php
                        if($status=='Active'){
                            echo '<option value="1" selected>Active</option>';
                            echo '<option value="2">In-Active</option>';
                        }else if($status=='In-Active'){
                            echo '<option value="1">Active</option>';
                            echo '<option value="2" selected>In-Active</option>';
                        }else{
                             echo '<option value="1" selected>Active</option>';
                            echo '<option value="2">In-Active</option>';
                        }
                        
                        ?>
                        </select>    
                    </div>
                </div>                
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <button type="submit"  class="btn btn-primary" style="margin-top:18px;">Save</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>

<?php include('view_packing.php'); ?>
<script>
function validateCodeLength(t){
    if (t.value) {
            if (t.value.length > 15) {
                t.value =  t.value.substr(0,15);
                swal("Code must be lessthan 15 Characters");
                return false;
            }
        }
    }
function validateLength(t){
    if (t.value) {
            if (t.value.length > 30) {
                t.value =  t.value.substr(0,30);
                swal("Description must be lessthan 30 Characters");
                return false;
            }
        }
    }
</script>

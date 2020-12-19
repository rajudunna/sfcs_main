<title>Add New Packing Method</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
<script src="<?= getFullURLLevel($_GET['r'],'common/js/jquery-2.1.3.min.js',3,'R'); ?>"></script>
  <script src="<?= getFullURLLevel($_GET['r'],'common/js/sweetalert-dev.js',3,'R'); ?>"></script>
  <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/sweetalert.css',3,'R'); ?>">
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
        <form name="test" role="form" method="POST" id='form_submt' data-parsley-validate novalidate>
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
                <div class="col-sm-12">
                <div class="col-sm-2">
                    <button type="submit"  class="btn btn-primary" style="margin-top:18px;">Save</button>
                </div>
                <div class="col-sm-2">
                    <input type='reset' class="btn btn-danger" value="Clear">
                </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>

<?php include('view_packing.php'); ?>
<script>
$("#form_submt").submit(function(event){
		submitForm();
		return false;
	});
    function submitForm(){
        var row_id = '<?=$row_id?>';
        var op ='Create';
        if(row_id!=0){
            op ='Update';
        }
        swal({
					title: "Are you sure?",
					text: "Do You Want To "+op+" packing method",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, I Want To "+op+" packing method",
					cancelButtonText: "No, Cancel!",
					closeOnConfirm: false,
					closeOnCancel: false }, 
				 function(isConfirm){ 
					if (isConfirm) {
                        swal("Continue", "Your Continue To "+op+" packing method", "success");
                                        var urls = '<?=$action_url?>'
                                        $.ajax({
                                            type: "POST",
                                            url: urls,
                                            cache:false,
                                            data: $('form#form_submt').serialize(),
                                            // success: function(response){
                                            //     $("#contact").html(response)
                                            // },
                                            error: function(e){
                                                console.log(e);
                                            }
                                        });
                                        location.reload();
					} else {
						swal("Cancelled!", "You Cancelled To "+op+" packing method", "error");
					}
				 });
    }
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

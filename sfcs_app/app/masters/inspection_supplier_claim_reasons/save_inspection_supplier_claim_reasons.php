

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<script src="<?= getFullURLLevel($_GET['r'],'common/js/jquery-2.1.3.min.js',3,'R'); ?>"></script>
  <script src="<?= getFullURLLevel($_GET['r'],'common/js/sweetalert-dev.js',3,'R'); ?>"></script>
  <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/sweetalert.css',3,'R'); ?>">
</head>

<body>
    <?php

        if(isset($_GET['tid'])){
            $complaint_reason =$_GET['complaint_reason'];
            $tid =$_GET['tid'];
            $rowid = $_GET['tid'];
            $complaint_clasification=$_GET['complaint_clasification'];
            $status = $_GET['status'];
            $complaint_category = $_GET['complaint_category'];  
        }else{
            $supplier_code='';
            //$packing_method="";
            //$status="";
        }
        $action_url = getFullURL($_GET['r'],'insert_inspection_supplier_claim_reasons.php','N');
	?> 

<div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Inspection Supplier Claim Reasons</b>
	</div>
	<div class='panel-body'>
        <form  id="formentry" name="supplierform" class="form-horizontal" role="form" method="POST" data-parsley-validate novalidate>
        <input type='hidden' id='tid' name='tid' value=<?php echo $tid; ?> >
        <div class="container-fluid shadow">
            <div class="row">
                <div id="valErr" class="row viewerror clearfix hidden">
                    <div class="alert alert-danger">Oops! Seems there are some errors..</div>
                </div>
                <div id="valOk" class="row viewerror clearfix hidden">
                    <div class="alert alert-success">Yay! ..</div>
                </div>
                <div class="row">              
                    <div class="col-md-6">     
                        <div class="form-group">
                            <label class="control-label control-label-left col-sm-5"  for="complaint_reason">Complaint Reason:<span><font color='red'>*</font></span></label>
                            <div class="controls col-sm-7">        
                                <input id="complaint_reason" type="text" onkeyup="return validateLength(this)" class="form-control" data-role="text" maxlength="50" required="required"  name="complaint_reason" value="<?php echo $complaint_reason; ?>"  data-parsley-errors-container="#errId1">
                                <span id="errId1" class="error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label control-label-left col-sm-5" for="complaint_clasification" >Complaint Classification:<span><font color='red'>*</font></span></label>
                            <div class="controls col-sm-7">
                                <input id="complaint_clasification" type="text" onkeyup="return validateLength(this)" class="form-control k-textbox" maxlength="50" data-role="text" required="required" name="complaint_clasification" value="<?php echo $complaint_clasification; ?>"  data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span>
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="row">    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label control-label-left col-sm-5" for="complaint_category" >Complaint Category:<span><font color='red'>*</font></span></label>
                            <div class="controls col-sm-7">
                                <input id="complaint_category" type="text" class="form-control k-textbox alpha" maxlength="50" data-role="text" onkeyup="return validateLength(this)" required="required" name="complaint_category" value="<?php echo $complaint_category; ?>"  data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label control-label-left col-sm-5" for="active_status">Status:<span><font color='red'>*</font></span></label>
                            <div class="controls col-sm-7">
                                <select id="active_status" class="form-control" data-role="select" selected="selected" required="required" name="status"  data-parsley-errors-container="#errId4">
                                    <?php
                                    if($status=="Active"){
                                        echo '<option value="0" selected>Active</option>';
                                        echo '<option value="1">In-Active</option>';
                                    }else if($status=="In-Active"){
                                        echo '<option value="0">Active</option>';
                                        echo '<option value="1" selected>In-Active</option>';
                                    }else {
                                        echo '<option value="0" selected>Active</option>';
                                        echo '<option value="1">In-Active</option>';
                                    }
                                    ?>
                                </select>
                                <span id="errId4" class="error"></span>
                            </div>         
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group btn-group pull-right">
                            <button id="btn_save" type="submit" class="btn btn-primary" name="btn_save">Save</button>
                            <input type='reset' class="btn btn-danger" value="Clear">
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </form>
</div>
     
                <?php
                include('view_inspection_supplier_claim_reasons.php');
                ?>
          
                
</body>
</html>
<script>
$("#formentry").submit(function(event){
		submitForm();
		return false;
	});
    function submitForm(){
        var rowid = '<?=$rowid?>';
        var op ='Create';
        if(rowid!=0){
            op ='Update';
        }
        swal({
					title: "Are you sure?",
					text: "Do You Want To "+op+" inspection supplier claim reason",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, I Want To "+op+" inspection supplier claim reason",
					cancelButtonText: "No, Cancel!",
					closeOnConfirm: false,
					closeOnCancel: false }, 
				 function(isConfirm){ 
					if (isConfirm) {
                        swal("Continue", "Your Continue To "+op+" inspection supplier claim reason", "success");
                                        var urls = '<?=$action_url?>'
                                        $.ajax({
                                            type: "POST",
                                            url: urls,
                                            cache:false,
                                            data: $('form#formentry').serialize(),
                                            // success: function(response){
                                            //     $("#contact").html(response)
                                            // },
                                            error: function(e){
                                                console.log(e);
                                            }
                                        });
                                        location.reload();
					} else {
						swal("Cancelled!", "You Cancelled To "+op+" inspection supplier claim reason", "error");
					}
				 });
    }
function validateLength(t){
    if (t.value) {
            if (t.value.length > 30) {
                t.value =  t.value.substr(0,30);
                swal("Length must be lessthan 30 Characters");
                t.value ='';
                return false;
            }
        }
    }
</script>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
</head>
<body>
    <?php
	if(isset($_GET['team_id'])){
        $jj='readonly';
        //echo "Row id".$_REQUEST['supplier_code'];
        $team_id =$_GET['team_id'];
		$emp_id =$_GET['emp_id'];
		$emp_call_name=$_GET['emp_call_name'];
		//$selected_user = $_GET['selected_user'];
        //$lastup = $_GET['lastup'];
        $emp_status = $_GET['emp_status'];
       
		
		//echo $color_code;
       
		

	}else{
        $team_id=0;
        $jj='';
		//$packing_method="";
		//$status="";
	}
	$action_url = getFullURL($_GET['r'],'insert_handover_team_list.php','N');
	?> 
    <div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Team List</b>
	</div>
	<div class='panel-body'>
              <form action="<?= $action_url ?>" id="formentry" class="form-horizontal" role="form" method="POST" data-parsley-validate novalidate>
			        <input type='hidden' id='tid' name='team_id' value=<?php echo $team_id; ?> >
                    <div class="container-fluid shadow">
                            <div class="row">
                                <div id="valErr" class="row viewerror clearfix hidden">
                                    <div class="alert alert-danger">Oops! Seems there are some errors..</div>
                                </div>
                                <div id="valOk" class="row viewerror clearfix hidden">
                                    <div class="alert alert-success">Yay! ..</div>
                                </div>
                            </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label class="control-label"  for="complaint_reason"><font color='red'>*</font>Employee Ids:</label>
                                    <input id="emp_id" type="text" class="form-control k-textbox alpha" maxlength="16" onkeyup="return validateEmpIdNum(this)" data-role="text" <?= $jj ?>  name="emp_id" value="<?php echo $emp_id; ?>"  data-parsley-errors-container="#errId1" />
                                    <span id="errId1" class="error"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label" for="complaint_clasification" ><font color='red'>*</font>Employee Name:</label>
                                    <input id="emp_call_name" type="text" class="form-control k-textbox alpha" maxlength="21" onkeyup="return validateEmpNameLength(this)" data-role="text" name="emp_call_name" value="<?php echo $emp_call_name; ?>"  data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span>
                            </div>
                            <div class="col-md-4">
                                    <label class="control-label" for="active_status"><font color='red'>*</font>Status:</label>
                                    <select id="active_status" class="form-control" data-role="select" selected="selected" required="required" name="emp_status"  data-parsley-errors-container="#errId4">
                                    <?php
                                        if($emp_status=="Active"){
                                        echo '<option value="0" selected>Active</option>';
                                        echo '<option value="1">In-Active</option>';
                                        }else if($emp_status=="In-Active"){
                                            echo '<option value="0">Active</option>';
                                            echo '<option value="1" selected>In-Active</option>';
                                        }else {
                                            echo '<option value="0" selected>Active</option>';
                                            echo '<option value="1">In-Active</option>';
                                        }

                                    ?>
                                    </select><span id="errId4" class="error"></span>
                            </div>
                        </div>
                        </br>
                        <div class = 'row'>
                            <div class="col-md-12">
                                <div class="form-group btn-group pull-right">
                                <button id="btn_save" type="submit" class="btn btn-primary btn-sm" name="btn_save">Save</button>
                            </div>
                        </div>
                    </div>
            </form>
    </div>
    
	<?php
        include('view_handover_team_list.php');
    ?>
    </div>
</body>

</html>


<script>
    function validateEmpIdNum(t){
    if(t.value == '')
        return false;
        var emp_id = t.value;
        var emp_id_pattern = /^[1-9][0-9]*$/;
        var found = emp_id.match(emp_id_pattern);
        if (t.value.length > 15) {
                //emp_id =  emp_id.substr(0,15);
                swal("ID must be lessthan 15 Characters");
                t.value ='';
                return false;
               
            }
        if(found) {
        return true;
        } else {
            swal("ID is not valid");
            t.value ='';
            return false;
        }  
    }
    function validateEmpNameLength(t){
    if (t.value) {
            if (t.value.length > 20) {
                t.value =  t.value.substr(0,20);
                swal("Name must be lessthan 20 Characters");
                t.value ='';
                return false;
            }
        }
    }

</script>

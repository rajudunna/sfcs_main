

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

                        <div class="row">
            
            <div class="col-md-4">
                
                <div class="form-group">
                <label class="control-label control-label-left col-sm-3"  for="complaint_reason">Employee Id:</label>
                <div class="controls col-sm-9">
                    
                <input id="emp_id" type="text" class="form-control k-textbox alpha" data-role="text" required="required" <?= $jj ?>  name="emp_id" value="<?php echo $emp_id; ?>"  data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span></div>
                
        </div></div>
            <div class="col-md-4"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="complaint_clasification" >Employee Name:</label>
			    <div class="controls col-sm-9">
                    
                <input id="emp_call_name" type="text" class="form-control k-textbox alpha" data-role="text" required="required" name="emp_call_name" value="<?php echo $emp_call_name; ?>"  data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span></div>
                
		</div></div>
        
        
        <div class="col-md-4"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="active_status">Status:</label>
			    <div class="controls col-sm-9">
                    
                <select id="active_status" class="form-control" data-role="select" selected="selected" required="required" name="emp_status"  data-parsley-errors-container="#errId4">
                <?php
                    if($emp_status=="Active"){
                        echo '<option value="0" selected>Active</option>';
                        echo '<option value="1">In-Active</option>';
                    }else{
                        echo '<option value="0">Active</option>';
                        echo '<option value="1" selected>In-Active</option>';
                    }

                ?>
                </select><span id="errId4" class="error"></span></div>
                
		</div></div>
        <div class="col-md-12">
            <div class="form-group btn-group pull-right">
		<button id="btn_save" type="submit" class="btn btn-primary" name="btn_save">Save</button>
    </div></div></div>


                    </div>
                </div>
            </form>
        </div>
    
    

   
	<?php
include('view_handover_team_list.php');
?>
</body>
<!-- <script>
    $('#datetimepicker').datetimepicker();
</script> -->

</html>

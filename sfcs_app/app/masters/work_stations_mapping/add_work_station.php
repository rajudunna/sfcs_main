

<!DOCTYPE html>
<html lang="en">
<head>


    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
            


</head>
<?php include('/template/header.php'); ?>
<body>
     <?php
     if(isset($_REQUEST['rowid']))
    {
        $id=$_REQUEST['rowid'];
        $short_cut_code1=$_REQUEST['operation_code'];
		$module=$_REQUEST['module'];
		$work_station_id=$_REQUEST['work_station_id'];
		//echo $short_cut_code1;
    }else
    {
        $id=0;
    } 
    $action_url = getFullURL($_GET['r'],'save_work_stations.php','N'); 
    ?>
    <div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Work Stations Mapping</b>
	</div>
	<div class='panel-body'>

            <form  id="formentry" name="formentry" class="form-horizontal" role="form"  method="POST" action="<?= $action_url ?>">
                <input type='hidden' id='id' name='id' value="<?php echo $id; ?>" >
                <div class="container-fluid shadow">
                    <div class="row">
                        <div id="valErr" class="row viewerror clearfix hidden">
                            <div class="alert alert-danger">Oops! Seems there are some errors..</div>
                        </div>
                        <div id="valOk" class="row viewerror clearfix hidden">
                            <div class="alert alert-success">Yay! ..</div>
                        </div>

                        
                                    <div class="row">
                                        <div class="col-md-12"><div class="row">
											
													
						
				<div class="col-md-4">
				<div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="module" id="required">Operation Code</label>
			    <div class="controls col-sm-9">
                 
   <?php 
   include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
   $conn=$link;
		echo "<select id='operation_code' class='form-control' data-role='select'  name='operation_code' data-parsley-errors-container='#errId2'>";
		if($id!=''){
			echo "<option value='".$short_cut_code1."' ".$selected.">$short_cut_code1</option>";
		}else{
		echo "<option value=''>Please Select</option><br/>\r\n";
		}
		$query = "SELECT id,operation_name,operation_code,short_cut_code FROM $brandix_bts.tbl_orders_ops_ref where work_center_id IS NULL or LENGTH(work_center_id)=0 ";
		$result = $conn->query($query);
		while($row = $result->fetch_assoc()) 
		{
			$operation_id=$row['id'];
			$short_cut_code=$row['short_cut_code'];
			echo "<option value='".$short_cut_code."' ".$selected.">$short_cut_code</option>";
			
		}
		echo "</select>";
	?>      </div>
				</div>
				</div>
				
				
				
				
				
				
							<div class="col-md-4">
				<div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="module" id="required">Module</label>
			    <div class="controls col-sm-9">
                 
   <?php 
   include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
   $conn=$link;
		echo "<select id='module_name' class='form-control' data-role='select'  name='module_name' data-parsley-errors-container='#errId2'>";
		if($id!=''){
			echo "<option value='".$module."' ".$selected.">$module</option>";
		}else{
		echo "<option value=''>Please Select</option><br/>\r\n";
		}
		$query = "SELECT id,module_name FROM $bai_pro3.module_master";
		$result = $conn->query($query);
		while($row = $result->fetch_assoc()) 
		{
			$module_id=$row['id'];
			$module_name=$row['module_name'];
			echo "<option value='$module_name' $selected>$module_name</option>";
		}
		echo "</select>";
	?>      </div>
				</div>
				</div>
				
				
		<div class="col-md-4"><div class="form-group">
                <label class="control-label control-label-left col-sm-3" for="work_station_id" id="required" name="workstat">Work Station Id</label>
                <div class="controls col-sm-9">
                    
                <input id="work_station_id" type="text"  maxlength="8" size="8" class="form-control k-textbox" data-role="text" placeholder="Enter max 8 characters" name="work_station_id" 
               
                value="<?php echo $work_station_id; ?>" required="required" data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span></div>
                </div>
</div>				
            
		    <div class="col-md-4" style="visibility:hidden;"><div class="form-group">
       
            <div class='input-group date'  >
                <input type='text' class="form-control" name='datetimepicker11' id='datetimepicker11'/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar">
                    </span>
                </span>
            </div>
        </div>
    </div>
    <script>
        $(function () {
			// alert();
            $('#datetimepicker11').datetimepicker({
				format: 'YYYY-MM-DD HH:mm:ss',
                daysOfWeekDisabled: [0, 6]
            });
        });
    </script>					
		</br>					
							
		<div class="col-md-4"><div class="form-group">      
		<input type="submit" id="btn_save"  style="margin-left: -300px;"  class="btn btn-primary btn-lg" name="btn_save" value="Save" onclick="return validateInputs()"></div></div></div></div>
                                    </div>
                                


                    </div>
                </div>
            </form>
        </div>
    </div>
	
	<?php include('view_work_stations.php'); ?>
   </body> 
   </html>


<style>
label#required:after {content: " *"; color: red;}

</style>

<script>
    $('formentry').on('submit', function() { 
        alert("ringing");
     });
            

    function validateInputs() {
        var input_module = $('#module_name').val();
        var workstation = $('#work_station_id').val();
        var operation = $('#operation_code').val();

        if ( input_module == '' || workstation == '' || operation == '') {
            swal('Warning', 'Please provide required information to proceed', 'warning');
            return false;
        }
        return true;
    }

</script>


<!DOCTYPE html>
<html lang="en">
<head>
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
   
	<?php include('/template/header.php'); ?>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Fav and touch icons -->
    
</head>

<body>
     <?php
    if(isset($_REQUEST['rowid']))
    {
        $id=$_REQUEST['rowid'];
        $module=$_REQUEST['module_name'];
        $description=$_REQUEST['module_description'];
		$section=$_REQUEST['section'];
        $status=$_REQUEST['status'];
    }else
    {
        $id=0;
    }
    $action_url = getFullURL($_GET['r'],'save_module.php','N'); 
    ?>
    <div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Modules</b>
	</div>
	<div class='panel-body'>

            <form action="<?= $action_url ?>" id="formentry" class="form-horizontal" role="form" method="POST" data-parsley-validate novalidate>
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
			    <label class="control-label control-label-left col-sm-3" for="module">Module</label>
			    <div class="controls col-sm-9">
                    
                <input id="module" type="text" class="form-control k-textbox float" data-role="text" placeholder="Module" name="module" value="<?php echo $module; ?>" required="required" data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span></div>
                
				</div>
				</div>
						
				<div class="col-md-4">
				<div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="module" id="required">Section</label>
			    <div class="controls col-sm-9">
                 
   <?php 
   include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
   $conn=$link;
		echo "<select id='sections' class='form-control' data-role='select'  name='sections' data-parsley-errors-container='#errId2'>";
		if($id!=''){
			echo "<option value='".$section."' ".$selected.">$section</option>";
		}else{
		echo "<option value='Please Select'>Please Select</option><br/>\r\n";
		}
		$query = "SELECT sec_id,sec_name FROM $bai_pro3.sections_master";
		$result = $conn->query($query);
		while($row = $result->fetch_assoc()) 
		{
			$operation_id=$row['id'];
			$sec_name=$row['sec_name'];
			echo "<option value='".$sec_name."' ".$selected.">$sec_name</option>";
			
		}
		echo "</select>";
	?>      </div>
				</div>
				</div>			
				
		<div class="col-md-4"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="description">Module Description</label>
			    <div class="controls col-sm-9">
				<textarea id="description" type="text" class="form-control k-textbox" data-role="text" placeholder="Module Description" name="description" data-parsley-errors-container="#errId1"><?php echo htmlspecialchars($description); ?></textarea><span id="errId1" class="error"></span>
				</div>
                
		</div></div>
		<div class="col-md-4"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="table_status">Status</label>
			    <div class="controls col-sm-9">
                    
                <select id="table_status" class="form-control" data-role="select" selected="selected" name="table_status" data-parsley-errors-container="#errId2">
		  <?php
				if($status=='In-Active'){
					
				echo '<option value="1">Active</option>';
					echo '<option value="2" selected>In-Active</option>';
					
				}else{
					
					
						echo '<option value="1" selected>Active</option>';
					echo '<option value="2">In-Active</option>';
					
					
				}
				
				?>
  
		</select><span id="errId2" class="error"></span></div>
                
		</div></div>
		
		
		

    <div class="col-md-4" style="visibility:hidden;"><div class="form-group">
       
            <div class='input-group date' id='datetimepicker11' >
                <input type='text' class="form-control" name='datetimepicker11'/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar">
                    </span>
                </span>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('#datetimepicker11').datetimepicker({
				format: 'YYYY-MM-DD HH:mm:ss',
                daysOfWeekDisabled: [0, 6]
            });
        });
    </script>

		
		
		
		
		
		
		

		<div class="col-md-4"><div class="form-group" style="margin-top: 0px;">
			    
			    
                
		<button id="btn_save" type="submit" class="btn btn-primary btn-lg" name="btn_save" style="margin-top: 57px;margin-left: -640px;">Save</button></div></div></div></div>
                                    </div>
                                


                    </div>
                </div>
            </form>
        </div>
    </div>
    
<?php include('view_modules.php'); ?>
</body>
</html>













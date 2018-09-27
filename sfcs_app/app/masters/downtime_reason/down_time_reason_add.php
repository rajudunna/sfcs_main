

<!DOCTYPE html>
<html lang="en">
<head>
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
        $dr_id=$_REQUEST['rowid'];
        $code=$_REQUEST['code'];
        $department=$_REQUEST['department'];
        $reason=$_REQUEST['reason'];
        
    }else
    {
        $dr_id=0;
    }
    $action_url = getFullURL($_GET['r'],'down_time_reason_save.php','N');
    ?>
    <div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Downtine Reasons</b>
	</div>
	<div class='panel-body'>

            <form action="<?= $action_url ?>" id="formentry" class="form-horizontal" role="form" method="POST" data-parsley-validate novalidate>
                <input type='hidden' id='dr_id' name='dr_id' value="<?php echo $dr_id; ?>" >
                <div class="container-fluid shadow">
                    <div class="row">
                        <div id="valErr" class="row viewerror clearfix hidden">
                            <div class="alert alert-danger">Oops! Seems there are some errors..</div>
                        </div>
                        <div id="valOk" class="row viewerror clearfix hidden">
                            <div class="alert alert-success">Yay! ..</div>
                        </div>

                        
                                    <div class="row">
                                        <div class="col-md-12"><div class="row"><div class="col-md-4"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="code">Code<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
                    
                <input id="code" type="text" class="form-control k-textbox" data-role="text" placeholder="Code" name="code" value="<?php echo $code; ?>" required="required" data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span></div>
                
				</div></div>
		<div class="col-md-4"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="department">Department</label>
			    <div class="controls col-sm-9">
				<input id="department" type="text" class="form-control k-textbox" data-role="text" placeholder="Department" name="department" value="<?php echo $department; ?>" required="required" data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span>
				</div>
                
		</div></div>
		<div class="col-md-4"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="reason">Reason</label>
			    <div class="controls col-sm-9">
				<textarea id="reason" type="text" class="form-control k-textbox" data-role="text" placeholder="Reason" name="reason" required="required" data-parsley-errors-container="#errId1"><?php echo htmlspecialchars($reason); ?></textarea><span id="errId1" class="error"></span>
				</div>
                
		</div></div>
		<div class="col-md-4"><div class="form-group">
			    
			    
                
		<button id="btn_save" type="submit" class="btn btn-primary btn-lg" name="btn_save">Save</button></div></div></div></div>
                                    </div>
                                


                    </div>
                </div>
            </form>
        </div>
    </div>
    
<?php include('view_down_time_reason.php'); ?>
</body>
</html>

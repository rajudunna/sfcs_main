

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- <title>Qms Location</title> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

     <!-- <h1>QMS Location</h1></br> -->
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
        $q_id = $_REQUEST['rowid'];
        $qms_location_id=$_REQUEST['qms_location_id'];
        $qms_location=$_REQUEST['qms_location'];
        $qms_location_cap=$_REQUEST['qms_location_cap'];
        $qms_cur_qty = $_REQUEST['qms_cur_qty'];
        $active_status = $_REQUEST['active_status'];
       

    }else
    {
        $q_id=0;
    }
    $action_url = getFullURL($_GET['r'],'qms_location_save.php','N');
    ?>
    <div class="container-fluid">
        <div class="row">

            <form action="<?= $action_url ?>" id="formentry" class="form-horizontal" role="form" method="POST" data-parsley-validate novalidate>
                <input type='hidden' id='q_id' name='q_id' value="<?php echo $q_id; ?>" >
                <div class="container-fluid shadow">
                    <div class="row">
                        <div id="valErr" class="row viewerror clearfix hidden">
                            <div class="alert alert-danger">Oops! Seems there are some errors..</div>
                        </div>
                        <div id="valOk" class="row viewerror clearfix hidden">
                            <div class="alert alert-success">Yay! ..</div>
                        </div>

                        
                                    
                                <div id="panel3" class="panel panel-primary" data-role="panel" style="display: block;">
        <div class="panel-heading">QMS Location</div>
        <div class="panel-body">
            
        <div class="row">
            <div class="col-md-4"><div class="form-group">
                <label class="control-label control-label-left col-sm-3" for="qms_location_id">Location Id<span class="req"> *</span></label>
                <div class="controls col-sm-9">
                    
                <input id="qms_location_id" type="text" class="form-control k-textbox" data-role="text" required="required" name="qms_location_id" value="<?php echo $qms_location_id; ?>" placeholder="Enter Location Id" data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span></div>
                
        </div></div>
            <div class="col-md-4"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="qms_location">Location<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
                    
                <input id="qms_location" type="text" class="form-control k-textbox" data-role="text" required="required" name="qms_location" value="<?php echo $qms_location; ?>" placeholder="Enter Location of carton/container" data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span></div>
                
		</div></div>
                <div class="col-md-4"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="qms_location_cap">Capacity<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
                    
                <input id="qms_location_cap" type="text" class="form-control k-textbox" data-role="text" required="required" placeholder="Enter Capacity of carton/container" name="qms_location_cap" value="<?php echo $qms_location_cap; ?>" data-parsley-errors-container="#errId2"><span id="errId2" class="error"></span></div>
                
		</div></div>
        <div class="col-md-4"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="qms_cur_qty">Quantity<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
                    
                <input id="qms_cur_qty" type="text" class="form-control k-textbox" data-role="text" name="qms_cur_qty" value="<?php echo $qms_cur_qty; ?>" placeholder="Enter Quantity" required="required" data-parsley-errors-container="#errId3"><span id="errId3" class="error"></span></div>
                
		</div></div>
        <div class="col-md-4"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="active_status">Status<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
                    
                <select id="active_status" class="form-control" data-role="select" selected="selected" required="required" name="active_status" data-parsley-errors-container="#errId4">
                <?php
                    if($active_status=="Active"){
                        echo '<option value="0" selected>Active</option>';
                        echo '<option value="1">Inactive</option>';
                    }else{
                        echo '<option value="0">Active</option>';
                        echo '<option value="1" selected>Inactive</option>';
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
    </div>
    



<?php include('view_qms_location.php'); ?> 
</body>
</html>

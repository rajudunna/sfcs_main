

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
   
	<?php include('/template/header.php'); ?>
    
    
</head>

<body>
     <?php
    if(isset($_GET['tid']))
    {
        $dr_id=$_GET['tid'];
        $transport_modes=$_GET['transport_mode'];
       
    }else
    {
        $dr_id=0;
    }
    $action_url = getFullURL($_GET['r'],'transport_modes_save.php','N');

    ?>
    <div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Transport Modes</b>
	</div>
	<div class='panel-body'>
 
            <form action="<?= $action_url ?>" id="formentry" class="form-horizontal" role="form" method="POST" data-parsley-validate novalidate>
                <input type='hidden' id='dr_id' name='dr_id' value="<?php echo $dr_id; ?>"  >
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
			    <label class="control-label control-label-left col-sm-3" id="code"   required="required" for="code">Transport Mode<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
                <input id="department" type="text" class="form-control k-textbox alpha" data-role="text"  name="transport_mode" value="<?php echo $transport_modes; ?>"   data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span>

</div>
				</div></div>
		
		

		<div class="col-md-3"><div class="form-group">
			             
		<button id="btn_save" type="submit" class="btn btn-primary btn-lg" name="btn_save">Save</button></div></div></div></div>
                                    </div>
                                


                    </div>
                </div>
            </form>
        </div>
    </div>

<?php include('view_transport_modes.php'); ?>
</body>

</html>

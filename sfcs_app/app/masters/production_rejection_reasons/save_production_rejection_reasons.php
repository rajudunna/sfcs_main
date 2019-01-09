

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	
	
	


    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Fav and touch icons -->
    
</head>

<body>
    <?php
	if(isset($_GET['sno'])){
		$jj='readonly';
		$reason_cat =$_GET['reason_cat'];
		$sno =$_GET['sno'];
		$reason_desc =$_GET['reason_desc'];
		$reason_code =$_GET['reason_code'];
		$reason_order =$_GET['reason_order'];
		$form_type = $_GET['form_type'];
        $m3_reason_code=$_GET['m3_reason_code'];
		

	}else{
		$sno=0;
		$jj='';
		//$packing_method="";
		//$status="";
	}
	$action_url = getFullURL($_GET['r'],'insert_production_rejection_reasons.php','N');
	?> 
    <div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Production Rejection Reasons</b>
	</div>
	<div class='panel-body'>

              <form action="<?= $action_url ?>" id="formentry" class="form-horizontal" role="form" method="POST" data-parsley-validate novalidate>
			  <input type='hidden' id='sno' name='sno' value=<?php echo $sno; ?> >
                <div class="container-fluid shadow">
                    <div class="row">
                        <div id="valErr" class="row viewerror clearfix hidden">
                            <div class="alert alert-danger">Oops! Seems there are some errors..</div>
                        </div>
                        <div id="valOk" class="row viewerror clearfix hidden">
                            <div class="alert alert-success">Yay! ..</div>
                        </div>

                        
                                    
                                <div class="row"><div class="col-md-6"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="reason_cat">Reason Catagory:</label>
			    <div class="controls col-sm-9">
				<select id="reason_cat" class="form-control" data-role="select" selected="selected" name="reason_cat" value=<?php echo $reason_cat; ?>  data-parsley-errors-container="#errId2">
					<option <?php if ($reason_cat == 'fabric' ) echo 'selected' ; ?>  value="fabric" >Fabric</option>
					<option <?php if ($reason_cat == 'cutting' ) echo 'selected' ; ?>  value="cutting">cutting</option>
					<option <?php if ($reason_cat == 'sewing' ) echo 'selected' ; ?>  value="sewing" >sewing</option>
					<option <?php if ($reason_cat == 'machine damages' ) echo 'selected' ; ?>  value="machine damages">machine damages</option>
                    <option <?php if ($reason_cat == 'emblishment' ) echo 'selected' ; ?>  value="emblishment" >emblishment</option></select>
                
                <!-- <input id="product_code" type="text" class="form-control k-textbox" data-role="text" required="required" placeholder="Product Code" name="product_code" > -->
				<span id="errId1" class="error"></span></div>
                
		</div></div><div class="col-md-6"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="reason_desc">Reason Description:</label>
			    <div class="controls col-sm-9">
                    
                <input id="reason_desc" type="text" class="form-control k-textbox alpha" data-role="text"  required="required" name="reason_desc" value=<?php echo $reason_desc; ?> ><span id="errId2" class="error"></span></div>
                
		</div></div></div><div class="row"><div class="col-md-6"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="reason_code">Reason Code:</label>
			    <div class="controls col-sm-9">
                    
                <input id="reason_code" type="text" class="form-control k-textbox integer" data-role="text"  name="reason_code" required="required" <?= $jj ?> value=<?php echo $reason_code; ?> ><span id="errId3" class="error"></span></div>
                
		</div></div><div class="col-md-6"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="reason_order">Reason Order:</label>
			    <div class="controls col-sm-9">
                    
                <input id="reason_order" type="text" class="form-control k-textbox integer" data-role="text" name="reason_order" required="required" value="<?php echo $reason_order; ?>" ><span id="errId4" class="error"></span></div>
                
		</div></div></div><div class="row"><div class="col-md-6"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3 " for="form_type">Form Type:</label>
			    <div class="controls col-sm-9">
                    
                <input id="form_type" type="text" class="form-control k-textbox alpha " data-role="text"  name="form_type" required="required" value=<?php echo $form_type; ?> ><span id="errId5" class="error"></span></div>
                
		</div></div><div class="col-md-6"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="m3_reason_code">M3 Reason Code:</label>
			    <div class="controls col-sm-9">
                    
                <input id="m3_reason_code" type="text" class="form-control k-textbox alpha" data-role="text"  name="m3_reason_code" required="required" <?= $jj ?> value=<?php echo $m3_reason_code; ?> ><span id="errId6" class="error"></span></div>
                
		</div></div></div><div class="row"><div class="col-md-12"><div class="form-group">
			    
			    
                
		<button id="btn_save" type="submit" class="btn btn-primary btn-lg" name="btn_save">Save</button></div></div></div>


                    </div>
                </div>
            </form>
        </div>
    </div>
     
<?php
include('view_production_rejection_reasons.php');
?>
</body>

</html>

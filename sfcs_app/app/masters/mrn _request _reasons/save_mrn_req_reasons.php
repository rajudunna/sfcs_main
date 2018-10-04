

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
	if(isset($_REQUEST['reason_tid'])){
		//echo "Row id".$_REQUEST['supplier_code'];
		$rejct_code =$_GET['reason_code'];
		$tid =$_GET['reason_tid'];
		$rejct_desc=$_GET['reason_desc'];
		$status = $_GET['status'];
		
		
		
		//echo $color_code;
       
		

	}else{
		$supplier_code='';
		//$packing_method="";
		//$status="";
	}
	$action_url = getFullURL($_GET['r'],'insert_mrn_req_reasons.php','N');
	?> 
    <div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>MRN Request Reasons</b>
	</div>
	<div class='panel-body'>

              <form action="<?= $action_url ?>" id="formentry" class="form-horizontal" role="form" method="POST" data-parsley-validate novalidate>
			  <input type='hidden' id='tid' name='reason_tid' value=<?php echo $tid; ?> >
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
                <label class="control-label control-label-left col-sm-3"  for="reason_code">Reason Code:</label>
                <div class="controls col-sm-9">
                    
                <input id="reason_code" type="text" class="form-control k-textbox alpha" data-role="text" required="required"  name="reason_code" value="<?php echo $rejct_code; ?>"  data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span></div>
                
        </div></div>
            <div class="col-md-4"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="reason_desc" >Reason Description:</label>
			    <div class="controls col-sm-9">
                    
                <input id="reason_desc" type="text" class="form-control k-textbox" data-role="text" required="required" name="reason_desc" value="<?php echo $rejct_desc; ?>"  data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span></div>
                
		</div></div>
        
        <div class="col-md-4"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="active_status">Status</label>
			    <div class="controls col-sm-9">
                    
                <select id="active_status" class="form-control" data-role="select" selected="selected" required="required" name="status"  data-parsley-errors-container="#errId4">
                <?php
                    if($status=="Active"){
                        echo '<option  value="0" selected>Active</option>';
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
include('view_mrn_req_reasons.php');
?>
</body>

</html>

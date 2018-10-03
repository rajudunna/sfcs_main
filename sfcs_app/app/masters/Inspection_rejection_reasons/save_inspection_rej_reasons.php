

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
	if(isset($_REQUEST['tid'])){
		$jj='readonly';
		$tid =$_GET['tid'];

		//echo "Row id".$_REQUEST['supplier_code'];
		$rejct_code =$_GET['reject_code'];
		$rejct_desc=$_GET['reject_desc'];
		
		
		
		//echo $color_code;
       
		

	}else{
		$tid=0;
        $jj='';
	}
	$action_url = getFullURL($_GET['r'],'insert_inspection_rej_reasons.php','N');
	?> 
    <div class='panel panel-primary'>
		<div class='panel-heading'>
			<b>Inspection Rejection Reasons</b>
		</div>
		<div class='panel-body'>

			<form action="<?= $action_url ?>" id="formentry" class="form-horizontal" role="form" method="POST" data-parsley-validate novalidate>
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
                <div class="col-md-12"><div class="row"><div class="col-md-4"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="table_name">	Reject Code<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
                    
				<input id="reject_code" type="text" class="form-control k-textbox alpha" data-role="text"  name="reject_code" required="required" <?= $jj ?> value="<?php echo $rejct_code; ?>" ><span id="errId1" class="error"></span></div>
                
				</div></div>
		
		       <div class="col-md-4"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="table_status">Reject description</label>
			    <div class="controls col-sm-9">
                    
	
                <input id="reject_desc" type="text" class="form-control k-textbox " data-role="text"  name="reject_desc" required="required" value="<?php echo $rejct_desc; ?>" ><span id="errId1" class="error"></span></div>
	
                
		</div></div>
		
		     <div class="col-md-4"><div class="form-group">
			    
			    
                
		<button id="btn_save" type="submit" class="btn btn-primary btn-lg" name="btn_save">Save</button>
		</div></div></div></div>
                                    </div>
                                


                    </div>
                </div>
            </form>
        </div>
    </div>
   
	<?php
include('view_inspection_rej_reasons.php');
?>
</body>

</html>

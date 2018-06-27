

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
	if(isset($_REQUEST['rowid'])){
		//echo "Row id".$_REQUEST['rowid'];
		$pack_id=$_REQUEST['rowid'];
		$packing_method=$_REQUEST['pack_method_name'];
		$status=$_REQUEST['status'];
	}else{
		$pack_id=0;
		//$packing_method="";
		//$status="";
	}
	?>
    <div class="container-fluid">
        <div class="row">

            <form action="index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL3BhY2tfbWV0aG9kcy9zYXZlX3BhY2tpbmdfbWV0aG9kLnBocA==" id="formentry" class="form-horizontal" role="form" method="POST" data-parsley-validate novalidate>
			<input type='hidden' id='pack_id' name='pack_id' value=<?php echo $pack_id; ?> >
                <div class="container-fluid shadow">
                    <div class="row">
						<div class="row">
							<div class="col-md-12"><div class="row"><div class="col-md-4"><div class="form-group">
							<label class="control-label control-label-left col-sm-3" for="pack_method_name">Packing Method<span class="req"> *</span></label>
							<div class="controls col-sm-9">
								
							<input id="pack_method_name" type="text" class="form-control k-textbox" data-role="text" required="required"  name="pack_method_name" value=<?php echo $packing_method; ?> >
							<span id="errId1" class="error"></span>
						</div>
                
					</div>
					</div>
				<div class="col-md-4"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="packing_status">Status<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
                    
                <select id="packing_status" class="form-control" data-role="select" required="required" selected="selected" name="packing_status" data-parsley-errors-container="#errId2">
				<?php
				if($status==1){
					echo '<option value="1" selected>Active</option>';
					echo '<option value="2">In-Active</option>';
				}else{
					echo '<option value="1">Active</option>';
					echo '<option value="2" selected>In-Active</option>';
				}
				
				?>
		  		
				
				</select>
		<span id="errId2" class="error"></span></div>
                
		</div></div><div class="col-md-4"><div class="form-group">
			    
			    
                
		<button id="btn_save" type="submit" class="btn btn-default" name="btn_save">Save</button></div></div></div></div>
                                    </div>
                                


                    </div>
                </div>
            </form>
        </div>
    </div>

<?php
include('view_packing_methods.php');
?>
	
</body>
</html>

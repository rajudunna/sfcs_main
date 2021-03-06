

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
    if(isset($_REQUEST['rowid'])){
		//echo "Row id".$_REQUEST['rowid'];
		$tbl_id=$_REQUEST['rowid'];
		//$tbl_name=$_REQUEST['tbl_name'];
		$tbl_name = $_REQUEST['tbl_name'];
      
		//echo $tbl_name;
		$status=$_REQUEST['status'];
	}else{
		$tbl_id=0;
		//$packing_method="";
		//$status="";
	}
	$action_url = getFullURL($_GET['r'],'cutting_table_save.php','N');
	?>
    <div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Cutting Tables</b>
	</div>
	<div class='panel-body'>

            <form action="<?= $action_url ?>" id="formentry" class="form-horizontal" role="form" method="POST" data-parsley-validate novalidate>
			<input type='hidden' id='tbl_id' name='tbl_id' value=<?php echo $tbl_id; ?> >
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
			    <label class="control-label control-label-left col-sm-3" for="table_name">Table Name<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
                    
                <input id="table_name" type="text" class="form-control k-textbox" data-role="text" placeholder="Table Name" name="table_name" required="required" value="<?php echo $tbl_name; ?>" ><span id="errId1" class="error"></span></div>
                
		</div></div><div class="col-md-4"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="table_status">Status</label>
			    <div class="controls col-sm-9">
                    
                <select id="table_status" class="form-control" data-role="select" selected="selected" name="table_status" data-parsley-errors-container="#errId2">
		  <?php
				if($status=='active'){
					echo '<option value="1" selected>Active</option>';
					echo '<option value="2">In-Active</option>';
				}else{
					echo '<option value="1">Active</option>';
					echo '<option value="2" selected>In-Active</option>';
				}
				
				?>
		  
		  
		  
		  
		</select><span id="errId2" class="error"></span></div>
                
		</div></div><div class="col-md-4"><div class="form-group">
			    
			    
                
		<button id="btn_save" type="submit" class="btn btn-primary btn-lg" name="btn_save">Save</button></div></div></div></div>
                                    </div>
                                


                    </div>
                </div>
            </form>
        </div>
    </div>
    
<?php include('view_cutting_table.php'); ?>
</body>
</html>

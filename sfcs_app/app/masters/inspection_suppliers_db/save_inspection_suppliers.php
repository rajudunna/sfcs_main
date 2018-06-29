

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
		//echo "Row id".$_REQUEST['supplier_code'];
		$product_code =$_REQUEST['product_code'];
		$tid =$_REQUEST['tid'];
		$supplier_code =$_REQUEST['supplier_code'];
		$complaint_no =$_REQUEST['complaint_no'];
		$supplier_m3_code =$_REQUEST['supplier_m3_code'];
		$color_code = str_replace(" ","#",$_REQUEST['color_code']);
		
		
		//echo $color_code;
        $seq_no=$_REQUEST['seq_no'];
		

	}else{
		$supplier_code='';
		//$packing_method="";
		//$status="";
	}
	$action_url = getFullURL($_GET['r'],'insert_inspection_suppliers.php','N');
	?> 
    <div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Inspection Suppliers</b>
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

                        
                                    
                                <div class="row"><div class="col-md-6"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="product_code">Product Code<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
				<select id="product_code" class="form-control" data-role="select" selected="selected" name="product_code" data-parsley-errors-container="#errId2">
					<option value="fabric" selected>Fabric</option>
					<option value="Trim">Trim</option></select>
                <!-- <input id="product_code" type="text" class="form-control k-textbox" data-role="text" required="required" placeholder="Product Code" name="product_code" value=<?php echo $product_code; ?> > -->
				<span id="errId1" class="error"></span></div>
                
		</div></div><div class="col-md-6"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="supplier_code">Supplier Code<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
                    
                <input id="supplier_code" type="text" class="form-control k-textbox" data-role="text" placeholder="Supplier Code" required="required" name="supplier_code" value=<?php echo $supplier_code; ?> ><span id="errId2" class="error"></span></div>
                
		</div></div></div><div class="row"><div class="col-md-6"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="complaint_no">Complaint No<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
                    
                <input id="complaint_no" type="text" class="form-control k-textbox" data-role="text" placeholder="Complaint No" name="complaint_no" required="required" value=<?php echo $complaint_no; ?> ><span id="errId3" class="error"></span></div>
                
		</div></div><div class="col-md-6"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="supplier_m3_code">Supplier M3Code<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
                    
                <input id="supplier_m3_code" type="text" class="form-control k-textbox" data-role="text" placeholder="Supplier M3Code" name="supplier_m3_code" required="required" value="<?php echo $supplier_m3_code; ?>" ><span id="errId4" class="error"></span></div>
                
		</div></div></div><div class="row"><div class="col-md-6"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="color_code">Color Code<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
                    
                <input id="color_code" type="text" class="form-control k-textbox" data-role="text" placeholder="Color Code" name="color_code" required="required" value=<?php echo $color_code; ?> ><span id="errId5" class="error"></span></div>
                
		</div></div><div class="col-md-6"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="seq_no">Sequence No<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
                    
                <input id="seq_no" type="text" class="form-control k-textbox" data-role="text" placeholder="Sequence No" name="seq_no" required="required" value=<?php echo $seq_no; ?> ><span id="errId6" class="error"></span></div>
                
		</div></div></div><div class="row"><div class="col-md-12"><div class="form-group">
			    
			    
                
		<button id="btn_save" type="submit" class="btn btn-primary btn-lg" name="btn_save">Save</button></div></div></div>


                    </div>
                </div>
            </form>
        </div>
    </div>
    



   
	<?php
include('view_inspection_suppliers.php');
?>
</body>

</html>

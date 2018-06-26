<?php include($_SERVER["DOCUMENT_ROOT"].'/template/header.php');  ?>
<body>
<div class="container-fluid">
        <div class="row">

            <form action="save_packing_method.php" id="formentry" class="form-horizontal" role="form" method="POST" data-parsley-validate novalidate>
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
			    <label class="control-label control-label-left col-sm-3" for="pack_method_name">Packing Method<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
                    
                <input id="pack_method_name" type="text" class="form-control k-textbox" data-role="text" required="required" placeholder="Packing Method" name="pack_method_name" data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span></div>
                
		</div></div><div class="col-md-4"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="packing_status">Status<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
                    
                <select id="packing_status" class="form-control" data-role="select" required="required" selected="selected" name="packing_status" data-parsley-errors-container="#errId2">
		  
		  
		  
		  
		  
		<option value="">Active</option><option value="Option 4">In-Active</option></select><span id="errId2" class="error"></span></div>
                
		</div></div><div class="col-md-4"><div class="form-group">
			    
			    
                
		<button id="btn_save" type="submit" class="btn btn-default" name="btn_save">Save</button></div></div></div></div>
                                    </div>
                                


                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
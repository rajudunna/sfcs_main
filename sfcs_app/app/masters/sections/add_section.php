

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <h1>Sections</h1></br>


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
		$sec_id=$_REQUEST['rowid'];
		$sec_head=$_REQUEST['sec_head'];
		$sec_mods=$_REQUEST['sec_mods'];
		$ims_priority_boxes=$_REQUEST['ims_priority_boxes'];
		
		//echo 	$sec_head;
	}else{
		$sec_id=0;
		//$packing_method="";
		//$status="";
	}
	?>
    <div class="container-fluid">
        <div class="row">

           
			 <form action="index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL3NlY3Rpb25zL2luc2VydF9zZWN0aW9ucy5waHA=" id="formentry" class="form-horizontal" role="form" method="POST" data-parsley-validate novalidate>
			 <input type='hidden' id='sec_id' name='sec_id' value=<?php echo $sec_id; ?> >
                <div class="container-fluid shadow">
                    <div class="row">
                        <div id="valErr" class="row viewerror clearfix hidden">
                            <div class="alert alert-danger">Oops! Seems there are some errors..</div>
                        </div>
                        <div id="valOk" class="row viewerror clearfix hidden">
                            <div class="alert alert-success">Yay! ..</div>
                        </div>

                        
                                    <div class="row">
                                        <div class="col-md-12"><div class="row"><div class="col-md-6"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="sec_head">Section<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
                    
                <input id="sec_head" type="text" class="form-control k-textbox" data-role="text" required="required" placeholder="Section" name="sec_head" value="<?php echo $sec_head; ?>" ><span id="errId1" class="error"></span></div>
                
		</div></div><div class="col-md-6"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="sec_mods">Section Modules<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
                    
                <textarea id="sec_mods" rows="3" class="form-control k-textbox" data-role="textarea" required="required" name="sec_mods"  ><?php echo $sec_mods; ?></textarea><span id="errId2" class="error"></span></div>
                
		</div></div></div><div class="row"><div class="col-md-6"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="ims_priority_boxes">IMS Priority Boxes<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
                    
                <input id="ims_priority_boxes" type="text" class="form-control k-textbox" data-role="text" required="required" name="ims_priority_boxes" placeholder="IMS Priority Box" value="<?php echo $ims_priority_boxes; ?>" ><span id="errId3" class="error"></span></div>
                
		</div></div><div class="col-md-6"><div class="form-group">
			    
			    
                
		<button id="btn_save" type="submit" class="btn btn-default" name="btn_save">Save</button></div></div></div></div>
                                    </div>
                                


                    </div>
                </div>
            </form>
        </div>
    </div>
  
<?php include('view_sections.php'); ?>
</body>
</html>

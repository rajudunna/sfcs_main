


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!--<h1>Categories</h1></br>-->
    

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
        $c_id=$_REQUEST['rowid'];
        $cat_name=$_REQUEST['cat_name'];
        $status=$_REQUEST['status'];
        $cat_selection=$_REQUEST['cat_selection'];
        
    }else
    {
        $c_id=0;
    }
    $action_url = getFullURL($_GET['r'],'save_categories.php','N');
    // echo $cat_name;
    ?>
    <!--<div class="container-fluid">
        <div class="row">-->
        <div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Categories</b>
	</div>
	<div class='panel-body'>

            <form action="<?= $action_url ?>" id="formentry" method="POST" class="form-horizontal" role="form" data-parsley-validate novalidate>
                <input type='hidden' id='c_id' name='c_id' value="<?php echo $c_id; ?>" >
                <div class="container-fluid shadow">
                    <div class="row">
                        <div id="valErr" class="row viewerror clearfix hidden">
                            <div class="alert alert-danger">Oops! Seems there are some errors..</div>
                        </div>
                        <div id="valOk" class="row viewerror clearfix hidden">
                            <div class="alert alert-success">Yay! ..</div>
                        </div>

                        
                                    
                                <div class="row"><div class="col-md-6"><div class="form-group">
                <label class="control-label control-label-left col-sm-3" for="category_name">Category Name<span class="req"> *</span></label>
                <div class="controls col-sm-9">
                    
                <input id="category_name" type="text" class="form-control k-textbox" data-role="text" placeholder="Category name" name="category_name"  value="<?php echo $cat_name; ?>" required="required" data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span></div>
                
        </div></div><div class="col-md-6"><div class="form-group">
                <label class="control-label control-label-left col-sm-3" for="category_status">Select Status</label>
                <div class="controls col-sm-9">
                    
                <select id="category_status" class="form-control" data-role="select" selected="selected" name="category_status" data-parsley-errors-container="#errId2">
                <?php
                    if($status==1){
                        echo '<option value="1" selected>Active</option>';
                        echo '<option value="2">In-Active</option>';
                    }else{
                        echo '<option value="1">Active</option>';
                        echo '<option value="2" selected>In-Active</option>';
                    }
                
                ?>
                </select><span id="errId2" class="error"></span></div>
                
                </div></div></div><div class="row"><div class="col-md-6"><div class="form-group">
                <label class="control-label control-label-left col-sm-3" for="cat_selection">Select Category</label>
                <div class="controls col-sm-9">
                    
                <select id="cat_selection" class="form-control" data-role="select" selected="selected" name="cat_selection"  data-parsley-errors-container="#errId3">
                     <?php
                    if($cat_selection=="Yes"){
                        echo '<option value="Yes" selected>Yes</option>';
                        echo '<option value="No">No</option>';
                    }else{
                        echo '<option value="Yes">Yes</option>';
                        echo '<option value="No" selected>No</option>';
                    }
                
                ?>
                </select><span id="errId3" class="error"></span></div>
                        
                </div></div><div class="col-md-6"><div class="form-group">
                        
                        
                        
                <button id="save_btn" type="submit" class="btn btn-primary btn-lg" name="save_btn">Save</button></div></div></div>


                    </div>
                </div>
            </form>
        </div>
    </div>
<?php include('view_categories.php'); ?>
</body>
</html>

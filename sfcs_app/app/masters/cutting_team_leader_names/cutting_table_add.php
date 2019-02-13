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
    if(isset($_GET['tid'])){
        $jj='readonly';
        //echo "Row id".$_REQUEST['rowid'];
        $tbl_id=$_GET['tid'];
        //$tbl_name=$_REQUEST['tbl_name'];
        $emp_id = $_GET['emp_id'];
        //echo $tbl_name;
        $emp_name=$_GET['emp_name'];
    }else{
        $tbl_id=0;
        $jj='';
    }

    $action_url = getFullURL($_GET['r'],'cutting_table_save.php','N');
    ?>
    <div class='panel panel-primary'>
    <div class='panel-heading'>
        <b>Leader Names</b>
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
                <label class="control-label control-label-left col-sm-3" for="table_name">  Employee Id:</label>
                <div class="controls col-sm-9">
                    
                <input id="table_name" type="text" class="form-control k-textbox integer" data-role="text"  name="emp_id" required="required" <?= $jj ?>  value="<?php echo $emp_id; ?>" ><span id="errId1" class="error"></span></div>
                
        </div></div><div class="col-md-4"><div class="form-group">
                <label class="control-label control-label-left col-sm-3" for="table_status">Employee Name:</label>
                <div class="controls col-sm-9">
                    
               <input id="emp_name" type="text" class="form-control k-textbox alpha " data-role="text" pattern="[A-Za-z0-9]" name="emp_name" required="required" value="<?php echo $emp_name; ?>" ><span id="errId1" class="error"></span></div>
    
                
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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="http://wenzhixin.net.cn/p/bootstrap-table/src/bootstrap-table.css" rel="stylesheet" type="text/css" />

    <link href="http://cdn.kendostatic.com/2014.1.318/styles/kendo.common.min.css" rel="stylesheet" />
    <link href="http://cdn.kendostatic.com/2014.1.318/styles/kendo.bootstrap.min.css" rel="stylesheet" />
    <link href="http://protostrap.com/Assets/gv/css/gv.bootstrap-form.css" rel="stylesheet" type="text/css" /> -->

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Fav and touch icons -->
    
</head>

<body>
        <?php
        $emp_id;
        $emp_name;
        $c_id;
        if(isset($_REQUEST['short_key_code']))
        {
            $c_id=$_REQUEST['rowid'];
            $short_key_code=$_REQUEST['short_key_code'];
        }else
        {
            $c_id=0;
        }
            $action_url =  getFullURL($_GET['r'],'save_short_key_code.php','N');
        ?>
<div  class="panel panel-primary" data-role="panel"  >
    <div style="font-size:18px" class="panel-heading">Create Short Key Code</div>
        <div class="panel-body">
    <div class="container-fluid">
        <div class="row">

            <form action="<?= $action_url ?>" id="formentry" class="form-horizontal" method = "POST" role="form" data-parsley-validate novalidate>
            <input type='hidden' id='c_id' name='c_id' value="<?php echo $c_id; ?>" >
            <div class="container-fluid shadow">
                    <div class="row">
                        <div id="valErr" class="row viewerror clearfix hidden">
                            <div class="alert alert-danger">Oops! Seems there are some errors..</div>
                        </div>
                        <div id="valOk" class="row viewerror clearfix hidden">
                            <div class="alert alert-success">Yay! ..</div>
                        </div>
                                    
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group" rel="popover" data-trigger="hover" data-content="Short Key Code" data-original-title="" style="display: block;">
                    <label class="control-label control-label-left" for="short_key_code" >
                       Short Key Code<span class="req"> </span>
                    </label>    
                    <input id="short_key_code" type="text" class="form-control k-textbox alpha" data-role="text" placeholder="Enter Short Key Code" name="short_key_code"  value = "<?php echo $short_key_code ?>" required="required" data-parsley-errors-container="#errId1">
                    <span id="errId1" class="error"></span>
                    </div>
                </div>
                <div class="col-sm-1">
                    <label><br/></label><br/>
                    <input  id="save_btn" type="submit" value='Save' class="btn btn-primary btn-sm" name="save_btn">
                </div>
            </div>
        </div>


                    </div>
                </div>
            </form>
        </div>
    </div>
    
 
    
    </div>
    </div> 



    <!-- <script src="http://cdn.kendostatic.com/2014.1.318/js/jquery.min.js"></script>
    <script src="http://protostrap.com/Assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="http://wenzhixin.net.cn/p/bootstrap-table/src/bootstrap-table.js" type="text/javascript"></script>

    <script src="http://protostrap.com/Assets/inputmask/js/jquery.inputmask.js" type="text/javascript"></script>
    <script src="http://cdn.kendostatic.com/2014.1.318/js/kendo.all.min.js"></script>
    <script src="http://protostrap.com/Assets/parsely/parsley.extend.js" type="text/javascript"></script>
    <script src="http://protostrap.com/Assets/parsely/2.0/parsley.js" type="text/javascript"></script>
    <script src="http://protostrap.com/Assets/download.js" type="text/javascript"></script>
    <script src="http://protostrap.com/Assets/protostrap.js" type="text/javascript"></script> -->
   <br>
   <br>
   
   <?php
include('view_short_key_code.php');

?>

</body>
</html>

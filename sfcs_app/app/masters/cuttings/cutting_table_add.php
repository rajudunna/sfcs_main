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
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$plant_code=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
// $plant_code='N02';

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

            <form action="<?= $action_url ?>" method="POST" data-parsley-validate novalidate>
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
                          <div class="col-md-12">
                                    <div class="col-md-5">
                                            <label class="control-label" for="table_name"><span style='color:red'>*</span> Employee Id:</label>
                                                <input  id="table_name" type="text" class="form-control k-textbox integer"   onkeyup="return validateEmpIdNum(this)" maxlength="21" data-role="text"  name="emp_id"  <?= $jj ?>  value="<?php echo $emp_id; ?>" >
                                                    <span id="errId1" class="error" style = 'color:red;'></span>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="control-label" for="table_status"><span style='color:red'>*</span>Employee Name:</label>
                                            <input  id="emp_name" type="text" class="form-control k-textbox alpha " onkeyup="return validateEmpNameLength(this)"  maxlength="21" data-role="text" pattern="[A-Za-z0-9]" name="emp_name"  value="<?php echo $emp_name; ?>" >
                                                <span id="errId2" class="error"  style = 'color:red;'></span>
                                    </div>
                                    <div class="col-md-2">
                                            <div style='padding-top:23px;'>
                                                <button id="btn_save" type="submit" class="btn btn-primary btn-sm" name="btn_save">Save</button>
                                            </div>
                                    </div>
                             </div>
                     </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
<?php include('view_cutting_table.php'); ?>
</body>

<script>
    function validateEmpIdNum(t){
        if(t.value == '')
            return false;
        var emp_id = t.value;
        var emp_id_pattern = /^[1-9][0-9]*$/;
        var found = emp_id.match(emp_id_pattern);
        if (t.value.length > 20) {
                swal("Length must be lessthan 20 Characters");
                $("#errId1").text("Employee Id must be lessthan 20 Characters");
                t.value ='';
                return false;
            }
        if(found) {
            $("#errId1").text("");
            return true;
        } else {
            swal("ID is not valid");
            t.value = '';
            return false;
        }  
    }
    function validateEmpNameLength(t){
    if (t.value) {
            if (t.value.length > 20) {
                t.value =  t.value.substr(0,20);
                swal("Name must be lessthan 20 Characters");
                $("#errId2").text("Employee Name must be lessthan 20 Characters");
                t.value ='';
                return false;
            }else{
                $("#errId2").text("");
            }
        }
    }

</script>


</html>
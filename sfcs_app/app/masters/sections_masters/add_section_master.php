

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
    if(isset($_REQUEST['rowid']))
    {
        $id=$_REQUEST['rowid'];
        $sec_name=$_REQUEST['sec_name'];
        $ims_priority_boxs=$_REQUEST['ims_priority_boxs'];
        $section_display_name=$_REQUEST['section_display_name'];
        $section_head=$_REQUEST['section_head'];
    }else
    {
        $id=0;
    }
    $action_url = getFullURL($_GET['r'],'save_section_master.php','N'); 
    ?>
    <div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Sections</b>
	</div>
	<div class='panel-body'>
        <form action="<?= $action_url ?>" id="formentry" class="form-horizontal" role="form" method="POST" data-parsley-validate novalidate>
            <input type='hidden' id='id' name='id' value="<?php echo $id; ?>" >
            <div class="container-fluid shadow">
            <div class="row">
                <div id="valErr" class="row viewerror clearfix hidden">
                    <div class="alert alert-danger">Oops! Seems there are some errors..</div>
                </div>
                <div id="valOk" class="row viewerror clearfix hidden">
                    <div class="alert alert-success">Yay! ..</div>
                </div>
                <div class="row">
                    <div class="col-md-12"><div class="row">
				<div class="col-md-4">
				<div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="module">Section<span class="req"> *</span></label>
			    <div class="controls col-sm-9">
				<?php
                if($sec_name!=''){
                echo"<input id='section_name' type='text' class='form-control k-textbox float' data-role='text' placeholder='Section Name' name='section_name' value='$sec_name' required='required' data-parsley-errors-container='#errId1' readonly><span id='errId1' class='error'></span></div>";
                }else{
				echo"<input id='section_name' type='text' class='form-control k-textbox float' data-role='text' placeholder='Section ID' name='section_name' value='' required='required' data-parsley-errors-container='#errId1'><span id='errId1' class='error'></span></div>";
				}
				?>
				</div>
				</div>
            <div class="col-md-4">
				<div class="form-group">
                    <label class="control-label control-label-left col-sm-5" for="section_display_name">Section Name<span class="req"> *</span></label>
                        <div class="controls col-sm-7">
                            <input id="section_display_name" type="text" class="form-control k-textbox" data-role="text" placeholder="Section Name" name="section_display_name" value="<?php echo $section_display_name; ?>"  data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span>
                        </div>
				</div>
            </div>
            <div class="col-md-4">
				<div class="form-group">
                    <label class="control-label control-label-left col-sm-5" for="section_head">Section Head<span class="req"> *</span></label>
                        <div class="controls col-sm-7">
                            <input id="section_head" type="text" class="form-control k-textbox" data-role="text" placeholder="Section Head" name="section_head" value="<?php echo $section_head; ?>"  data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span>
                        </div>
				</div>
			</div>
            <div class="col-md-4">
				<div class="form-group">
                    <label class="control-label control-label-left col-sm-5" for="ims_priority">IMS Priority Boxs<span class="req"> *</span></label>
                        <div class="controls col-sm-7">
                            <input id="ims_priority" type="text" class="form-control k-textbox" data-role="text" placeholder="IMS Priority Box" name="ims_priority" value="<?php echo $ims_priority_boxs; ?>"  data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span>
                        </div>
				</div>
            </div>
            
    <div class="col-md-4" style="visibility:hidden;"><div class="form-group">
       
            <div class='input-group date' id='datetimepicker11' >
                <input type='text' class="form-control" name='datetimepicker11'/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar">
                    </span>
                </span>
            </div>
        </div>
    </div>


		<div class="col-md-4"><div class="form-group" style="margin-top: 0px;">
			    
			    
                
		<button id="btn_save" type="submit" class="btn btn-primary btn-md" name="btn_save" style="margin-left: -315px;">Save</button></div></div></div></div>
                                    </div>
                                


                    </div>
                </div>
            </form>
        </div>
    </div>
    
<?php include('view_section_master.php'); ?>
</body>
</html>












    <script>
        $(function () {
            $('#datetimepicker11').datetimepicker({
				format: 'YYYY-MM-DD HH:mm:ss',
                daysOfWeekDisabled: [0, 6]
            });
        });
    </script>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
   
	<?php include('/template/header.php'); ?>
    
    
</head>

<body onload='assigncmb()'>
    <?php
    $colors = ['white','yellow','red','blue','orange','green','pink','black'];
    if(isset($_GET['id']))
    {
        $dr_id=$_GET['id'];
        $code=$_GET['prefix_name'];
        $department=$_GET['prefix'];
        $reason=$_GET['type_of_sewing'];
        $type=$_GET['bg_color'];
    }else
    {
        $dr_id=0;
    }
    $action_url = getFullURL($_GET['r'],'sewing_jobs_prefix_save.php','N');

    ?>
    <div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Sewing Jobs Prefix</b>
	</div>
	<div class='panel-body'>

            <form action="<?= $action_url ?>" id="formentry" class="form-horizontal" role="form" method="POST" data-parsley-validate novalidate>
                <input type='hidden' id='dr_id' name='dr_id' value="<?php echo $dr_id; ?>" >
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
			    <label class="control-label control-label-left col-sm-3" id="code"   required="required" for="code" >Prefix Name<span class="req" > </span></label>
			    <div class="controls col-sm-9">
                <div class="dropdown" >
                                        
                                        <select class="form-control" name="prefix_name" id="prefix_name"  value="<?php echo $code; ?>" onchange='assigncmb()'>
                                            
                                            <option <?php if ($code == 'Normal' ) echo 'selected' ; ?>  value='Normal'>Normal</option>
                                            <option <?php if ($code == 'Excess' ) echo 'selected' ; ?>  value='Excess'>Excess</option>
                                            <option <?php if ($code == 'Sample' ) echo 'selected' ; ?>  value='Sample' >Sample</option>
                                        </select>   
                                    </div>
</div>
				</div></div>
		<div class="col-md-4"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="department">Prefix</label>
			    <div class="controls col-sm-9">
				<input id="department" type="text" class="form-control k-textbox" data-role="text"  name="prefix" value="<?php echo $department; ?>"  data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span>
				</div>
                
        </div></div>
        <div class="col-md-4"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" for="department">Type Of Prefix</label>
			    <div class="controls col-sm-9">
				<input id="type_of_sewing" type="text" class="form-control k-textbox" data-role="text"  name="type_of_sewing" value="<?php echo $reason; ?>"  data-parsley-errors-container="#errId1" readonly><span id="errId1" class="error"></span>
				</div>
		</div></div>
		<div class="col-md-4"><div class="form-group">
            <label class="control-label control-label-left col-sm-3" for="reason">Back Ground Color</label>
            <div class="controls col-sm-9">
                <select class='form-control' id="reason" name="bg_color">
                    <option>Please Select</option>
                <?php
                    foreach($colors as $color)
                        echo "<option value='$color'>$color</option>";
                ?>
                </select>
            </div>      
		    </div>
        </div>
		<div class="col-md-4"><div class="form-group">
			    
			    
                
		<button id="btn_save" type="submit" class="btn btn-primary btn-lg" name="btn_save">Save</button></div></div></div></div>
                                    </div>
                                
                    </div>
                </div>
            </form>
        </div>
    </div>
    
<?php include('view_sewing_jobs_prefix.php'); ?>
</body>
<script>
   function assigncmb(){
        var v1 = document.getElementById("prefix_name").value;
       
        if(v1=='Normal'){
            document.getElementById("type_of_sewing").value = "1";

        }else if(v1=='Excess'){
            document.getElementById("type_of_sewing").value = "2";

        }else{
            document.getElementById("type_of_sewing").value = "3";

        }

    }
    
</script>        
</html>

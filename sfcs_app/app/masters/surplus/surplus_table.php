<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- <title>Qms Location</title> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

     <!-- <h1>QMS Location</h1></br> -->
    <?php include('/template/header.php'); ?>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Fav and touch icons -->
    
</head>

<body onload='assigncmb()'>
     <?php
    if(isset($_GET['rowid']))
    {
        $jj='readonly';
        
        $q_id = $_GET['rowid'];
        $qms_location_id=$_GET['qms_location_id'];
        $qms_location=$_GET['qms_location'];
        $qms_location_cap=$_GET['qms_location_cap'];
        $qms_cur_qty = $_GET['qms_cur_qty'];
        $active_status = $_GET['active_status'];
        $str=explode("-",$qms_location_id);
        $cmbitems=$str[0];
        $sur_alpha=$str[1];
        $sur_num=$str[2];
    }else
    {
        $q_id=0;
        $jj='';
    }
    $action_url = getFullURL($_GET['r'],'surplus_location_save.php','N');
    ?>
         <div id="panel3" class="panel panel-primary" data-role="panel" style="display: block;">
        <div class="panel-heading">Surplus Locations</div>
        <div class="panel-body">
    <div class="container-fluid">
        <div class="row">
        <div name="sur_drop">
        <div class="form-group form-control " >
            <select name="cmbitems" id="cmbitems"  onchange='assigncmb()'>
                <option <?php if ($cmbitems == 'INT' ) echo 'selected' ; ?> value='INT' >INT</option>
                <option <?php if ($cmbitems == 'SUR' ) echo 'selected' ; ?> value='SUR' >SUR</option>
                <option <?php if ($cmbitems == 'RES' ) echo 'selected' ; ?> value='RES' >RES</option>
            </select>
    </div>
    <div class="form-group form-control" >
        <select name="sur_alpha" id="sur_alpha" onchange='assigncmb()' >
    <?php   
    foreach(range('A','Z') as $char){
            ?>
            <option  <?php if ($sur_alpha == $char ) echo 'selected' ; ?> value="<?php echo $char;?>"><?php echo $char;?></option>
        <?php
    }
?>
    </select>
    </div>

         
              <div class="form-group form-control" >
              <select name="sur_num" id="sur_num" onchange='assigncmb()'>
                    <?php
                        for ($i=1; $i<=999; $i++)
                        {
                            if($i<10){
                                ?>
                                    <option <?php if ($sur_num ==  "00".$i ) echo 'selected' ; ?> value="<?= "00".$i;?>"><?= "00".$i;?></option>
                                <?php
                            }
                            elseif($i<100){
                                ?>
                                    <option  <?php if ($sur_num ==  "0".$i ) echo 'selected' ; ?> value="<?= "0".$i;?>"><?= "0".$i;?></option>
                                <?php
                            }
                            else {
                                ?>
                                    <option <?php if ($sur_num == $i ) echo 'selected' ; ?> value="<?= $i;?>"><?= $i;?></option>
                                <?php
                            }
                            
                        }
                    ?>
                </select></div>
                    </div>
                    &nbsp;&nbsp;
            

            <form action="<?= $action_url ?>" id="formentry" class="form-horizontal" role="form" method="POST" data-parsley-validate novalidate>
                <input type='hidden' id='q_id' name='q_id' value="<?php echo $q_id; ?>" >
                <div class="container-fluid shadow">
                    <div class="row">
                        <div id="valErr" class="row viewerror clearfix hidden">
                            <div class="alert alert-danger">Oops! Seems there are some errors..</div>
                        </div>
                        <div id="valOk" class="row viewerror clearfix hidden">
                            <div class="alert alert-success">Yay! ..</div>
                        </div>

        <div class="row">
            
            <div class="col-md-4">
                
                <div class="form-group">
                <label class="control-label control-label-left col-sm-3"  for="qms_location_id">Qms Location Id:<span class="req"> *</span></label>
                <div class="controls col-sm-9">
            
                <input id="qms_location_id" type="text" class="form-control k-textbox" data-role="text" required="required" name="qms_location_id"  value="<?php echo $qms_location_id; ?>"  data-parsley-errors-container="#errId1" readonly><span id="errId1" class="error"></span></div>
                
        </div></div>
            <div class="col-md-4"><div class="form-group">
                <label class="control-label control-label-left col-sm-3" for="qms_location" >Qms Location:<span class="req"> *</span></label>
                <div class="controls col-sm-9">
                    
                <input id="qms_location" type="text" class="form-control k-textbox" data-role="text" <?= $jj ?> required="required" name="qms_location" value="<?php echo $qms_location; ?>"  data-parsley-errors-container="#errId1" readonly><span id="errId1" class="error"></span></div>
                
        </div></div>
                <div class="col-md-4"><div class="form-group integer">
                <label class="control-label control-label-left col-sm-3 " for="qms_location_cap">Qms Location Capacity:<span class="req"> *</span></label>
                <div class="controls col-sm-9">
                    
                <input id="qms_location_cap" type="text" class="form-control k-textbox " data-role="text" required="required"  name="qms_location_cap" value="<?php echo $qms_location_cap; ?>" data-parsley-errors-container="#errId2"><span id="errId2" class="error"></span></div>
                
        </div></div>
        <div class="col-md-4"><div class="form-group">
                <label class="control-label control-label-left col-sm-3" for="active_status">Status<span class="req"> *</span></label>
                <div class="controls col-sm-9">
                    
                <select id="active_status" class="form-control" data-role="select" selected="selected" required="required" name="active_status" data-parsley-errors-container="#errId4">
                <?php
                    if($active_status=="Active"){
                        echo '<option value="0" selected>Active</option>';
                        echo '<option value="1">In-Active</option>';
                    }else{
                        echo '<option value="0">Active</option>';
                        echo '<option value="1" selected>In-Active</option>';
                    }

                ?>
                </select><span id="errId4" class="error"></span></div>
                
        </div></div>
        <div class="col-md-12">
            <div class="form-group btn-group pull-right">
        <button id="btn_save" type="submit" class="btn btn-primary" name="btn_save">Save</button>
    </div></div></div>


                    </div>
                </div>
            </form>
        </div>
    </div>
    



<?php include('surplus_location_view.php'); ?> 
</body>
<script>
    function assigncmb(){
        var qty = document.getElementById("qms_location_cap").value;
        
        if (qty != '' ) {
         
        }
        else {
            var v1 = document.getElementById("cmbitems").value;
        var v2 = document.getElementById("sur_alpha").value;
        var v3 = document.getElementById("sur_num").value;
        document.getElementById("qms_location_id").value = v1+'-'+v2+'-'+v3;
        if(v1=='RES'){
            document.getElementById("qms_location").value = "Surplus Room for Reserver";

        }else if(v1=='INT'){
            document.getElementById("qms_location").value = "Internal Destroy";

        }else{
            document.getElementById("qms_location").value = "Surplus Room ";

        }
        }

        

    }

</script>
</html>
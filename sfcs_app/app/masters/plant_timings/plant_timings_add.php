
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

<body>
     <?php
    if(isset($_REQUEST['time_id']))
    {
        // var_dump($_GET);
        // die();
        $dr_id=$_GET['time_id'];
        $code=$_GET['time_value'];
        $time=$_GET['time_display'];
        $times = explode('-',$time);

        // $st = $times[0];
        $xx = explode(':',$times[0]);
        $x1=$xx[0];
        $x2=$xx[1];
        $h1 = str_pad($x1,2,'0',STR_PAD_LEFT);
        $m1 = str_pad($x2,2,'0',STR_PAD_LEFT);
        $st="$h1:$m1";
        $yy = explode(':',$times[1]);
        $y1=$yy[0];
        $y2=$yy[1];
        $h2 = str_pad($y1,2,'0',STR_PAD_LEFT);
        $m2 = str_pad($y2,2,'0',STR_PAD_LEFT);
        $et="$h2:$m2";
        $day_part=$_GET['day_part'];
    }else
    {
        $dr_id=0;
    }
    $action_url = getFullURL($_GET['r'],'plant_timings_save.php','N');

    ?>
    <div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Plant Timings</b>
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
			    <label class="control-label control-label-left col-sm-3" id="code"  value="" required="required" for="code">Time Value<span class="req"> </span></label>
			    <div class="controls col-sm-9">
                <input id="department" type="text" class="form-control k-textbox" data-role="text"  name="time_value" value="<?php echo $code; ?>"  data-parsley-errors-container="#errId1" readonly><span id="errId1" class="error"></span>

</div>
                </div></div>
                
		<div class="col-md-3"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" value="" for="department">Start Time</label>
			    <div class="controls col-sm-9">
                <div class="dropdown">
                    <!-- <input placeholder="Selected time" type="time" id="start" class="form-control timepicker" onchange="calculate()"> -->
                <SELECT name="time_display" id="start" value="<?php echo $start_time ; ?>" class="form-control" onchange="calculate()">
                <option value='' selected>Please Select</option>

                <?php 
                for($hours=1; $hours<13; $hours++)
                {
                    for($mins=0; $mins<60; $mins+=60)
                    { 
                        $h = str_pad($hours,2,'0',STR_PAD_LEFT);
                        $m = str_pad($mins,2,'0',STR_PAD_LEFT);
                        $time = "$h:$m";
                        if($time==$st)
                            echo "<option value='$h:$m' selected>$time</option>";
                        else
                            echo "<option value='$h:$m'>$time</option>";    
                    }
                }
                ?>

</SELECT>
            </div>
</div>
        </div></div>
        <div class="col-md-3"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" value="" for="department">End Time</label>
			    <div class="controls col-sm-9">
				<div class="dropdown">
                 <!-- <input placeholder="Selected time" type="time" id="start1" class="form-control timepicker" onchange="calculate()"> -->
                <SELECT name="time_display1" id="start1" value="<?php echo $end_time; ?>" class="form-control">
                <option value='' selected>Please Select</option>
                
                <?php 
                    for($hours=1; $hours<13; $hours++)
                    {
                        for($mins=0; $mins<60; $mins+=60)
                        { 
                            $h = str_pad($hours,2,'0',STR_PAD_LEFT);
                            $m = str_pad($mins,2,'0',STR_PAD_LEFT);
                            $time = "$h:$m";
                            if($time==$et)
                            echo "<option value='$h:$m' selected >$time</option>";
                        else
                            echo "<option value='$h:$m'>$time</option>";    
                    }
                          
                    }
                ?>

                </SELECT>
            </div>			</div>
                
        </div></div>
        
                <div class="col-md-3"><div class="form-group">
			    <label class="control-label control-label-left col-sm-3" id="code"  value="" required="required" for="code">Day Part<span class="req"> </span></label>
			    <div class="controls col-sm-9">
                <div class="dropdown">
                    <select name="day_part" id='day_part' onchange="calculate()">
                    <option value='' selected>Please Select</option>
                    <?php
                        if($day_part!=''){ 
                            if($day_part == 'AM'){
                                echo "<option value='AM' selected>AM</option>";
                                echo "<option value='PM'>PM</option>"; 
                            }else{
                                echo "<option value='PM' selected>PM</option>"; 
                                echo "<option value='AM'>AM</option>"; 
                            } 
                        }else {
                    ?>
                        <option value='AM' >AM</option>
                        <option value='PM' >PM</option>
                    <?php
                        }
                    ?>
                    </select>
                </div>
        </div>
				</div></div>
		

		<div class="col-md-3"><div class="form-group">
			             
		<button id="btn_save" type="submit" class="btn btn-primary btn-lg"  onclick="return time_diff();" name="btn_save">Save</button></div></div></div></div>
                                    </div>
                                


                    </div>
                </div>
            </form>
        </div>
    </div>

<?php include('view_plant_timings.php'); ?>
</body>
<script>
// $(document).ready(function() {
//     $('#input_starttime').pickatime({});
// });

    function calculate(){
        var v1 = document.getElementById("start").value;
        var v2 = document.getElementById("start1").value;
  
       var day_time = document.getElementById("day_part").value;
       if(day_time=='AM' || day_time==''){
      
        var sh = v1.substr(0,2);

        var sm = v1.substr(0,2);
           var new1 = sh;
           
        document.getElementById("department").value = new1;
       } else if(day_time=='PM') {
        var sh = v1.substr(0,2);
        var sm = v1.substr(2,4);
        var new1 = parseInt(sh)+12;
        document.getElementById("department").value = new1;
       }

    }
    
    function time_diff(){
         var v1 = document.getElementById("start").value;
        var v2 = document.getElementById("start1").value;
        var sh = v1.substr(0,2);
        var sm = v1.substr(2,4);
        var eh = v2.substr(0,2);
        var em = v2.substr(2,4);
        if(sh == eh){
            swal('start time and end time should not equal','','warning');
            return false;
        }else{
            return true;
        }
    }


</script>
</html>
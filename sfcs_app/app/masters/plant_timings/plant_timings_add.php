
<body>
     <?php
    if(isset($_REQUEST['time_id']))
    {
        $dr_id = $_GET['time_id'];
        $end_time_str = '';
        $code=$_GET['time_value'];
        $start_time = $_GET['start_time'];
        $end_time = $_GET['end_time'];
       
        $end_time_split = explode(':',$end_time);
        $eh = $end_time_split[0];
        $em = $end_time_split[1];
        if($end_time_split[2] == 0)
            $end_time_str = "$eh:$em";
        else{
            $em++;
            $end_time_str = "$eh:$em";
        }
        echo "<script>
            $(document).ready(function(){
                $('#start_time').val('$start_time');
                $('#end_time').val('$end_time_str');
            });
            </script>";
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
        <form action="<?= $action_url ?>" id="formentry" class="form-horizontal" role="form" method="POST"  onsubmit="return time_diff();">
            <input type='hidden' id='dr_id' name='dr_id' value="<?php echo $dr_id; ?>" >
            <div class="container-fluid shadow">
                <div class="row">
                    <div id="valErr" class="row viewerror clearfix hidden">
                        <div class="alert alert-danger">Oops! Seems there are some errors..</div>
                    </div>
                    <div id="valOk" class="row viewerror clearfix hidden">
                        <div class="alert alert-success">Yay! ..</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label for="code">Time Value<span class="req"></label>
                        <input id="t_value" type="text" class="form-control" name="time_value" value="<?= $code; ?>" name='code' readonly>
                    </div>
                    <div class="col-md-2">
                        <label for='start_time'>Start Time</label>
                        <input type='time' value='Satrt Time' class='form-control without_ampm' name='start_time' id='start_time'>
                        <!-- <input placeholder="Selected time" type="time" id="start" class="form-control timepicker" onchange="calculate()"> -->
                        <!-- <SELECT name="time_display" id="start" value="<?php echo $start_time ; ?>" class="form-control" onchange="calculate()">
                        <option value='' selected>Please Select</option> -->
                        <?php 
                        // for($hours=1; $hours<13; $hours++)
                        // {
                        //     for($mins=0; $mins<60; $mins+=60)
                        //     { 
                        //         $h = str_pad($hours,2,'0',STR_PAD_LEFT);
                        //         $m = str_pad($mins,2,'0',STR_PAD_LEFT);
                        //         $time = "$h:$m";
                        //         if($time==$st)
                        //             echo "<option value='$h:$m' selected>$time</option>";
                        //         else
                        //             echo "<option value='$h:$m'>$time</option>";    
                        //     }
                        // }
                        ?>
                    </div>
                    <div class="col-md-2">
                        <label for='end_time'>End Time</label>
                        <input type='time' value='End Time' class='form-control without_ampm' name='end_time' id='end_time'>
                        <!-- <input placeholder="Selected time" type="time" id="start1" class="form-control timepicker" onchange="calculate()"> -->
                        <!--
                        <SELECT name="time_display1" id="start1" value="<?php echo $end_time; ?>" class="form-control">
                        <option value='' selected>Please Select</option>
                        -->
                        <?php 
                            // for($hours=1; $hours<13; $hours++)
                            // {
                            //     for($mins=0; $mins<60; $mins+=60)
                            //     { 
                            //         $h = str_pad($hours,2,'0',STR_PAD_LEFT);
                            //         $m = str_pad($mins,2,'0',STR_PAD_LEFT);
                            //         $time = "$h:$m";
                            //         if($time==$et)
                            //         echo "<option value='$h:$m' selected >$time</option>";
                            //     else
                            //         echo "<option value='$h:$m'>$time</option>";    
                            // }
                                
                            // }
                        ?>
                    </div>
                    <div class="col-md-2">
                        <label for='day_part'>Day Part</label>
                        <select class='form-control' name="day_part" id='day_part' onchange="calculate()" required>
                            <option value>Please Select</option>
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
                    <div class='col-sm-1'>
                        <label>&nbsp;<br/></label><br/>
                        <input id="btn_save" type="submit" class="btn btn-primary btn-sm"    name="btn_save" value='Save'>                    
                    </div>
                </div>      
               
            </div>
        </form>
    </div>
<div class='col-sm-12'>
    <br/><br/>
    <?php include('view_plant_timings.php'); ?>
</div>
</body>
<script>
    // $(document).ready(function() {
    //     $('#input_starttime').pickatime({});
    // });

    function calculate(){
        var v1 = document.getElementById("start_time").value;
        var v2 = document.getElementById("end_time").value;
       
       
        var sh = v1.substr(0,2);
        if(sh == 0)
            sh = 24;
        document.getElementById("t_value").value = sh;
        //    if(day_time=='AM' || day_time==''){
        //         var sh = v1.substr(0,2);
        //         var sm = v1.substr(0,2);
        //         var new1 = sh;
        //         document.getElementById("t_value").value = new1;
        //    }else if(day_time=='PM') {
        //         var sh = v1.substr(0,2);
        //         var sm = v1.substr(2,4);
        //         var new1 = parseInt(sh)+12;
        //         document.getElementById("t_value").value = new1;
        //    }
    }
    
    function time_diff(){
        var day_time = document.getElementById("day_part").value;
        console.log('YES'+day_time.length);
        if(day_time.length == 0){
            swal('Please Select AM/PM','','warning');
            return false;
        }

        var v1 = document.getElementById("start_time").value;
        var v2 = document.getElementById("end_time").value;
        console.log('V! == '+v1);
        if(v1.length==0 || v2.length==0 ){
            swal('Please Enter Satrt and End Time','','warning');
            return false;
        }
        var sh = v1.substr(0,2);
        var sm = v1.substr(2,4);
        var eh = v2.substr(0,2);
        var em = v2.substr(2,4);
        console.log(sh+' - '+eh);
        
        if(sh == eh){
            swal('start time and end time should not equal','','warning');
            return false;
        }else{
            return true;
        }
    }


</script>
</html>

<style>

.without_ampm::-webkit-datetime-edit-ampm-field {
   display: none;
 }
 input[type=time]::-webkit-clear-button {
   -webkit-appearance: none;
   -moz-appearance: none;
   -o-appearance: none;
   -ms-appearance:none;
   appearance: none;
   margin: -10px; 
 }
</style>
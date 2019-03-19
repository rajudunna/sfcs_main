<script>
    function validate_hours(t){
        if(Number(t.value) > 12){
            t.value = 12;
            var st = $('#start_hour').val();
            $('#time_value').val(st);
            return false;
        }
        var st = $('#start_hour').val();
        $('#time_value').val(st);
    }
    function validate_mins(t){
        if(Number(t.value) > 59){
            t.value = 59;
            return false;
        } 
    }

    function calculate(){
        var sh = $("#start_hour").val();
        var eh = $("#end_hour").val();
        console.log(sh+' -  '+eh);
        if(sh == eh){
            swal('Hours are equal','','warning');    
            return false;
        }
    }
    
    function time_diff(){
       var day_time = document.getElementById("day_part").value;
       if(day_time.length == 0){
           swal('Please Select AM/PM','','warning');
           return false;
       }

       if(sh.length==0 || sm.length==0 || eh.length==0 || em.length==0 ){
           swal('Please Enter Start and End Time','','warning');
           return false;
       }
       var sh = v1;
       var sm = v11;
       var eh = v2;
       var em = v21;
       console.log(sh+' - '+eh);
       
       if(sh == eh){
           swal('start time and end time should not equal','','warning');
           return false;
       }else{
           return true;
       }
    }
</script>


<?php
    if(isset($_REQUEST['id']))
    {
        $exist_id = $_GET['id'];
        
        $start_time = $_GET['start_time'];
        $end_time = $_GET['end_time'];
        $time_value = $_GET['time_value'];

        $start_time_split = explode(':',$start_time);
        $sh = $start_time_split[0];
        $sm = $start_time_split[1];
        $end_time_split = explode(':',$end_time);
        $eh = (int)$end_time_split[0];
        $em = (int)$end_time_split[1];

        if($em == 59){
            $eh++;
            $em = 0;
        }else{
            $em++;
        }
        echo "<script>
            $(document).ready(function(){
                $('#start_hour').val($sh);
                $('#end_hour').val($eh);
                $('#start_min').val($sm);
                $('#end_min').val($em);
                $('#time_value').val($time_value);
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
            <form action = "<?= $action_url ?>" onsubmit="return calculate()" method='POST'>
                <input type='hidden' value='<?= $exist_id ?>' name='id'>
                <div class='col-sm-2'>
                    <label>Time Display</label>
                    <input type='text' class='integer form-control' name='time_value' id='time_value' readonly>
                </div>
                <div class='col-sm-1'>
                </div>
                <div class='col-sm-3'>
                    <label style='text-align:center'>Start Time</label><br/>
                    <input type='text' class='integer form-control ele' name='start_hour' id='start_hour' onkeyup='return validate_hours(this)' required>
                    &nbsp;:&nbsp;
                    <input type='text' class='integer form-control ele' name='start_min'  id='start_min'  onkeyup='return validate_mins(this)' required>
                    &nbsp;&nbsp;
                    <select class='form-control eles' name='start_m' required>
                        <option disabled></option><option value='AM'>AM</option><option value='PM'>PM</option>
                    </select>
                </div>
                <div class='col-sm-3'>
                    <label style='text-align:center'>End Time</label><br/>
                    <input type='text' class='integer form-control ele' name='end_hour' id='end_hour' onkeyup='return validate_hours(this)' required>
                    &nbsp;:&nbsp;
                    <input type='text' class='integer form-control ele' name='end_min'  id='end_min'  onkeyup='return validate_mins(this)' required>
                    &nbsp;&nbsp;
                    <select class='form-control eles' name='end_m' required>
                        <option disabled></option><option value='AM'>AM</option><option value='PM'>PM</option>
                    </select>
                </div>
                <div class='col-sm-1'>
                    <label><br/></label>
                    <input type='submit' class='btn btn-success form-control' name='save' value='Save'>
                </div>
            </form>
        </div>
        <div class='col-sm-12'>
            <br/><br/>
            <?php include('view_plant_timings.php');   ?>
        </div>
    </div>


<style>

.without_ampm::-webkit-datetime-edit-ampm-field {
   display: none;
}
.ele{
    max-width : 60px;
}
.eles{
    max-width : 80px;
}
</style>
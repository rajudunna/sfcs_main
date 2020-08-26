<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    $plant_code = $_SESSION['plantCode'];
?> 

<div class="panel panel-primary">
    <div class="panel-heading">Sewing Jobs Split</div>
    <div class="panel-body">
        <form name="input" method="post" action="?r=<?= $_GET['r'] ?>">
            <div class="row">
                <div class="col-md-4">       
                    <label>Enter Schedule No : </label>
                    <input type="text" class="integer form-control" required name="schedule" id='schedule' value="">
                    <input type="hidden" name="plant_code" id='plant_code' value="<?php echo $plant_code;?>">
                </div><br/>
                <div clas="col-md-4">
                    <input type="submit" name="submit" value="Submit" class="btn btn-success">
                </div>
            </div>
        </form>

        <?php
        if(isset($_POST['submit']) || isset($_GET['schedule']))
        {
            $schedule=$_POST['schedule'];
            $poNumbers = ['PO01','PO12','PO77','PO01','PO09'];
            echo '<h4><b>Schedule : <a class="btn btn-success">'.$schedule.'</a><input type="hidden" name="schedule1" id="schedule1" value='.$schedule.'></b></h4>';
            $split_jobs = getFullURL($_GET['r'],'split_jobs.php','N');
            foreach($poNumbers as $po_number){
                echo "<input type='button' class='btn btn-warning' onclick=getSewingJobs(this.value) value=$po_number>";
            }
        }
        ?>
        <br/>
        <div id ="dynamic_table">
		</div>
    </div>
</div>

<script>
    function getSewingJobs(po_number){
        var po = po_number;
        var plant_code = $('#plant_code').val();
        var inputObj = {poNumber:po,plantCode:plant_code};
        var function_text = "<?php echo getFullURL($_GET['r'],'scanning_ajax.php','R'); ?>";
        var split_jobs = "<?php echo getFullURL($_GET['r'],'split_jobs.php','R'); ?>";
        $.ajax({
            type: "POST",
            url: function_text+"?inputObj="+inputObj,
            success: function(response) 
            {
                var data = JSON.parse(response);
				var sewing_job_list ='';
                $.each(data.sewingJobNumbers, function( index, sewing_job ) {
                    sewing_job_list = sewing_job_list + '<input type="button" class="btn btn-info" onclick=sendData(this.value,"'+po+'") value='+sewing_job+'>';
                });
                $('#dynamic_table').html(sewing_job_list);
            }
        });
    }
    function sendData(sewing_job,po){
        var schedule = $('#schedule1').val();
        var plant_code = $('#plant_code').val();
        var function_text = "<?php echo getFullURL($_GET['r'],'split_jobs.php','N'); ?>";
        window.location.href = function_text+'&sewing_job='+sewing_job+'&po_number='+po+'&schedule='+schedule+'&plant_code='+plant_code ;

    }
    
    function verify_split(t){
        var id = t.id;
        var st_id = 'qty'+id;
        var ent = document.getElementById(id).value;
        var qty = document.getElementById(st_id).value;
        if(Number(ent) > Number(qty) ){
            sweetAlert('Error','The quantity to be splitted is more than Total Job Quantity','warning');
            document.getElementById(id).value = 0;
        }
    }
    function verify_qty()
    {           
        var tot = Number(document.getElementById('total').value);
        var n=0;
        for(var j=1;j<=tot;j++)
        {
            n=n+Number(document.getElementById(j).value);
        }
        if(n>0)
        {
            return true;
        }
        else
        {
                sweetAlert('Error','Please update the quantity for any Bundle','warning');
                return false;
        }	
    }
</script>
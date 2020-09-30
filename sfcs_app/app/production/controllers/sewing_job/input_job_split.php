<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
    include(getFullURLLevel($_GET['r'],'common/config/server_urls.php',4,'R'));
    $plant_code = $_SESSION['plantCode'];
    // $plant_code = 'AIP';
    $username=$_SESSION['userName'];
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
            //get mp_mo_qty details wrt schedule
            $mp_mo_details_id=array();
            $po_number_id=array();
            $qry_MpMoQty="SELECT mp_mo_qty_id FROM $pps.mp_mo_qty WHERE schedule='$schedule' AND plant_code='$plant_code'";
            $MpMoQty_result=mysqli_query($link_new, $qry_MpMoQty) or exit("Sql Error at mp_color_detail".mysqli_error($GLOBALS["___mysqli_ston"]));
            $MpMoQty_num=mysqli_num_rows($MpMoQty_result);
            if($MpMoQty_num>0){
                while($MpMoQty_row=mysqli_fetch_array($MpMoQty_result))
                    {        
                        $mp_mo_details_id[]=$MpMoQty_row["mp_mo_qty_id"];
                    }
                    $mp_mo_details_id = implode("','", $mp_mo_details_id);
                    
                    //qry to get po_numbers wrt master po details qty id
                    $qry_MpSubMoQty="SELECT po_number FROM $pps.mp_sub_mo_qty WHERE mp_mo_qty_id IN ('$mp_mo_details_id') AND plant_code='$plant_code'";
                    $MpSubMoQty_result=mysqli_query($link_new, $qry_MpSubMoQty) or exit("Sql Error at mp_color_detail".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $MpSubMoQty_num=mysqli_num_rows($MpSubMoQty_result);
                    if($MpSubMoQty_num>0){
                        while($MpSubMoQty_row=mysqli_fetch_array($MpSubMoQty_result))
                        {        
                            $po_number_id[]=$MpSubMoQty_row["po_number"];
                        }
                        $po_number_id = implode("','", $po_number_id);

                        //qry to get po and description wrt po number
                        $qry_MpSubOrder="SELECT po_number,po_description FROM $pps.mp_sub_order WHERE po_number IN ('$po_number_id') AND plant_code='$plant_code'";
                        $MpSubOrder_result=mysqli_query($link_new, $qry_MpSubOrder) or exit("Sql Error at mp_color_detail".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $MpSubOrder_num=mysqli_num_rows($MpSubOrder_result);
                        if($MpSubOrder_num>0){
                            while($MpSubOrder_row=mysqli_fetch_array($MpSubOrder_result))
                            {
                                $PoDescription[$MpSubOrder_row["po_description"]]=$MpSubOrder_row["po_number"];
                            }
                        }
                    }
            }
            if(sizeof($PoDescription)>0){

                    echo '<h4><b>Schedule : <a class="btn btn-success">'.$schedule.'</a><input type="hidden" name="schedule1" id="schedule1" value='.$schedule.'></b></h4>';
                    $split_jobs = getFullURL($_GET['r'],'split_jobs.php','N');
                    echo "<h5><b><u>Select Sub PO :</u></b></h5>";
                    foreach($PoDescription as $key=>$poDesc){
                        ?>
                        <input type='button' class='btn btn-warning' onClick="return getSewingJobs('<?php echo $poDesc ?>', '<?php echo $key ?>')" value='<?= $key; ?>'>
                        <?php
                    }
            }else{
                echo "</br></br><center><h4 style='color:red;'>No PO's Found on this <b>' ".$schedule." '</b> Schedule,Please Check Once</h4></center>";
            }

        }
        ?>
        <br/>
        <div id ="dynamic_table">
		</div>
    </div>
</div>

<script>
    function getSewingJobs(po_number,po_name){
        var po = po_number;
        var po_desc = po_name;
        var plant_code = $('#plant_code').val();
        var inputObj = {"poNumber":po,"plantCode":plant_code};
        var split_jobs = "<?php echo getFullURL($_GET['r'],'split_jobs.php','R'); ?>";
        $.ajax({
			type: "POST",
			url: "<?php echo $PPS_SERVER_IP?>/jobs-generation/getJobNumbersByPo",
			data: inputObj,
			success: function (res) {            
				console.log(res);
				if(res.status)
				{
					var data = res.data;
                    console.log(data);
					var sewing_job_list ='<h5><b><u>Select Sewing Job :</u></b></h5>';
	                $.each(data.job_number, function( index, sewing_job ) {
	                    sewing_job_list = sewing_job_list + '<input type="button" class="btn btn-info" onclick=sendData(this.value,"'+po_desc+'") value='+sewing_job+'>';
	                });
                    console.log(sewing_job_list);
                    $('#dynamic_table').html(sewing_job_list);
				}
				else
				{
					swal(res.internalMessage);
				}                       
			},
			error: function(res){
				swal('Error in getting data');
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
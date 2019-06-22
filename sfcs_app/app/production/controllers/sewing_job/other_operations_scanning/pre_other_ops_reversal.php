<script type="text/javascript">
	function validateQty(e,t) 
	{
		if(e.keyCode == 13)
				return;
			var p = String.fromCharCode(e.which);
			var c = /^[0-9]+$/;
			var v = document.getElementById(t.id);
			
			if( !(v.value.match(c)) && v.value!=null ){
				v.value = '';
				return false;
			}
			return true;
	}
	function validateQty1(e,t) 
	{
        //alert('hello');
			var c = /^[0-9]*\.?[0-9]*$/;
			var v = document.getElementById(t.id);
			if( !(v.value.match(c)) && v.value!=null ){
				v.value = '';
				return false;
			}
			return true;
	}
</script>
<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
?>

<script>
function firstbox()
{
	window.location.href ="<?= 'index.php?r='.$_GET['r']; ?>&category="+document.getElementById('category').value
}

$(document).ready(function() {
	$('#operation_code').on('click',function(e){
		var category = $('#category').val();
		if(category == null){
			sweetAlert('Please Select category','','warning');
		}
	});
	$('#shift').on('click',function(e){
		var category = $('#category').val();
		var operation_code = $('#operation_code').val();
		if(category == null && operation_code == null){
			sweetAlert('Please Select category and operation','','warning');
		}
		// else if(operation_code == null){
		// 	sweetAlert('Please Select operation','','warning');
		// 	document.getElementById("submit").disabled = true;
		// }
		// else {
		// 	document.getElementById("submit").disabled = false;
		// }
	});
});

</script>
<!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<?php
	//include("menu_content.php");
if($_GET['category'])
{
    $category=$_GET['category'];
	$operation_code=$_GET['operation_code']; 
	$shift=$_GET['shift'];
	$doc_no=$_GET['doc_no'];

	if ($category == 'packing') {
		$display_name = "Carton";
	} else {
		$display_name = "Docket";
	}
	
}
else
{
  $shift=$_POST['shift'];
  $operation_code=$_POST['operation_code'];
  $post_ops=$_POST['post_ops'];
}
	

	
?>

<div class = "panel panel-primary">
<div class = "panel-heading">Other Operation Reversal</div>
<div class = "panel-body">
<form name="other_operation_report" method="post">
	<input type="hidden" name="scan_type" id="scan_type" value=<?= $display_name ?>>
<?php

$sql = "SELECT DISTINCT category FROM $brandix_bts.tbl_orders_ops_ref WHERE restricted='no'";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
echo "<div class=\"row\"><div class=\"col-sm-2\"><label>Select category:</label>
<select class='form-control' name=\"category\"  id=\"category\" onchange=\"firstbox();\" >";

echo "<option value=''  selected>Please Select</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{
	$main_category = $sql_row['category'];

	if(str_replace(" ","",$sql_row['category'])==str_replace(" ","",$category))
	{
		echo "<option value=\"".$sql_row['category']."\" selected>".$sql_row['category']."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_row['category']."\">".$sql_row['category']."</option>";
	}

}
echo "  </select>
	</div>";
?>
<?php
	 $query_get_schedule_data= "SELECT tm.operation_code,tm.operation_name FROM $brandix_bts.tbl_orders_ops_ref tm
		WHERE tm.operation_code  
		AND category IN ('$category')  AND display_operations='yes'
	    GROUP BY tm.operation_code ORDER BY tm.operation_code";
	    //echo $query_get_schedule_data;
		$result = $link->query($query_get_schedule_data);
		while($row = mysqli_fetch_array($result))
		{
			$ops_array[$row['operation_code']] = $row['operation_name'];
		}
?>
			<div class="col-sm-2">
                <label for="title">Select Operation:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
                <select class="form-control select2"  name="operation_code" id="operation_code" required>
                    <option value="">Select Operation</option>
                    <?php
                        foreach($ops_array as $key=>$value)
                        {
                            echo "<option value='$key'>$value - $key</option>"; 
                        }
                    ?>
                </select>
            </div>
            
			<div class="col-sm-2">
                <label>Shift:<span style="color:red">*</span></label>
                <select class="form-control shift"  name="shift" id="shift" style="width:100%;" required>
                    <option value="">Select Shift</option>
                    <?php 
                        for ($i=0; $i < sizeof($shifts_array); $i++) {?>
                            <option  <?php echo 'value="'.$shifts_array[$i].'"'; if($_GET['shift']==$shifts_array[$i]){ echo "selected";}   ?>><?php echo $shifts_array[$i] ?></option>
                        <?php }
                    ?>
                </select>
            </div>

            <div class="col-sm-2">
            <label><?= $display_name ?> Number</label>
                <input type="text"  name="doc_no" id="doc_no"  class="number form-control" required>
            </div>
        </div>

         <div class="form-group col-lg-6 col-sm-12">
         	<br><br>

                <div class="progress progress-striped active" hidden='true' id='progressbar'>
                    <div class="progress-bar"  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                <div  class='panel panel-primary' id="pre_pre_data" hidden='true'>
                    <div class='panel-heading'>Previous Transaction</div>
                    <div style='overflow-x:scroll' class='panel-body' id="pre_data"></div>
                </div>
            </div>
 
    </div>
</div>
</form>
<div class='panel panel-primary'  id="maindiv">
   
			<div class='panel-heading'>Data</div>
			<div class="ajax-loader" id="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;">
                <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
            </div>
			<form name= "smartform" method="post" id="smartform">
				<input type="hidden" name="style" id="style" value=<?=$style?>>
                 <input type="hidden" name="schedule" id="schedule" value=<?=$schedule?>>
				 <input type="hidden" name="shifts" id='shifts' value="<?php echo $shift;?>">
				 <input type="hidden" name="operation_id" id='operation_id' value="<?php echo $operation_code;?>">
				 <input type="hidden" name="post_code" id="post_code" value="<?php echo $post_ops?>">
				<div class='panel-body' id="dynamic_table_panel">	
					<div id ="dynamic_table1">
				    </div>
				</div>
			</form>
</div>

<script>
$(document).ready(function() 
{
    $('#doc_no').focus();
    $('#dynamic_table1').html('');
    $('#loading-image').hide();
    $("#doc_no").change(function(){
	    $('#loading-image').show();
	    var function_text = "<?php echo getFullURL($_GET['r'],'functionallity_scanning.php','R'); ?>";
	    var doc_no = $('#doc_no').val();
	    var operation_code = $('#operation_code').val();
	    var shift = $('#shift').val();
	    var scan_type = $('#scan_type').val();
	    // var assign_module = $('#module').val();
	    // var style = $('#style').val();
	    // var schedule = $('#schedule').val();
	    // var color = $('#mapped_color').val();
	    if (doc_no && operation_code && shift)
	    {
	    	var array = [doc_no,operation_code,shift];
			$.ajax({
				type: "POST",
				url: function_text+"?reversal="+array+"&type="+scan_type,
				dataType: "json",
				success: function (response) 
				{	
	                s_no = 0;
					var data = response['table_data'];
	                if(response['status']){
						sweetAlert('',response['status'],'error');
						$('#dynamic_table1').html('No Data Found');
						document.getElementById('doc_no').value = '';
					}else if(data){
						$('#dynamic_table1').html('');
						document.getElementById('style').value = response['style'];
	                    // document.getElementById('style').innerHTML = response['style'];
						 document.getElementById('schedule').value = response['schedule'];
	                    //document.getElementById('schedule').innerHTML = response['schedule'];
						// document.getElementById('mapped_color').value = response['color'];
						document.getElementById('shifts').value = shift;
						document.getElementById('operation_id').value = operation_code;
						 document.getElementById('post_code').value = response['post_ops'];
	                 
	                    var btn = '<div class="pull-right" id="smart_btn_arear"><input type="button" class="btn btn-primary submission" value="Submit" name="formSubmit" id="smartbtn" onclick="return check_pack();"><input type="hidden" id="count_of_data" value='+data.length+'></div>';
	                    console.log(btn);
	                    console.log(data.length);
						$("#dynamic_table1").append(btn);

	                    for(var i=0;i<data.length;i++){
	                        if(i==0){
	                            var markup = "<div class='container'><div class='row'><div id='no-more-tables'><table class = 'col-sm-12 table-bordered table-striped table-condensed cf' id='dynamic_table'><thead class='cf'><tr><th>S.No</th><th>Size</th><th>Cut Job Qty</th><th>Cumulative Reported Quantity</th><th>Eligibility To Reverse</th><th>Reversing Quantity</th></tr></thead><tbody>";
	                            $("#dynamic_table1").append(markup);
	                            $("#dynamic_table1").append(btn);
	                        }
	                        var readonly ='';
	                        var temp_var_bal = data[i].balance_to_report;
	                        s_no++;
	                        var markup1 = "<tr><td data-title='S.No'>"+s_no+"</td><td data-title='Size'>"+data[i].size_code.toUpperCase()+"</td><td data-title='Input Job Quantity'>"+data[i].carton_act_qty+"</td><input type='hidden' name='old_size[]' value = '"+data[i].old_size+"'><td  data-title='Cumulative Reported Quantity'>"+data[i].reported_qty+"</td><td id='"+i+"remarks_validate_html'  data-title='Eligibility To Report'>"+temp_var_bal+"</td><td data-title='Reporting Qty'><input type='text' onkeyup='validateQty(event,this)'  class='form-control input-md twotextboxes' id='"+i+"reporting' onfocus='if($(this).val() == 0){$(this).val(``)}' onfocusout='if($(this).val() > 0){}else{$(this).val(0)}' value='"+temp_var_bal+"' required name='reporting_qty[]' onchange = 'validate_reporting_report("+i+") '"+readonly+"></td><td class='hide'><input type='hidden' name='qty_data["+data[i].tid+"]' id='"+i+"qty_data'></td><td class='hide'><input type='hidden' name='doc_no[]' id='"+i+"doc_no' value='"+data[i].doc_no+"'></td><td class='hide'><input type='hidden' name='colors[]' id='"+i+"colors' value='"+data[i].order_col_des+"'></td><td class='hide'><input type='hidden' name='sizes[]' id='"+i+"sizes' value='"+data[i].size_code+"'></td><td class='hide'><input type='hidden' name='job_qty[]' id='"+i+"job_qty' value='"+data[i].carton_act_qty+"'></td><td class='hide'><input type='hidden' name='tid[]' id='"+i+"tid' value='"+data[i].tid+"'></td><td class='hide'><input type='hidden' name='inp_job_ref[]' id='"+i+"inp_job_no' value='"+data[i].input_job_no+"'></td><td class='hide'><input type='hidden' name='a_cut_no[]' id='"+i+"a_cut_no' value='"+data[i].acutno+"'></td><td class='hide'><input type='hidden' name='old_rep_qty[]' id='"+i+"old_rep_qty' value='"+data[i].reported_qty+"'></td><td class='hide'></td><input type='hidden' name='bundle_numbers[]' id='"+i+"bundle_number' value='"+data[i].tid+"'></td></tr>";
	                        $("#dynamic_table").append(markup1);
	                        $("#dynamic_table").hide();
						}
						var markup99 = "</tbody></table></div></div></div>";
						$("#dynamic_table").append(markup99);
						$("#dynamic_table").show();
						//$('#docket_number').val(doc_no);
	                }
	                $('#loading-image').hide();	
	            }
			});
	    }
	    else
	    {
	    	sweetAlert('Select All Required Fields','','warning');
	    } 	
    });
});



function validate_reporting_report(val)
{
	var reporting_id = val+"reporting";
	var reporting = document.getElementById(reporting_id).value;
	var max_var = val+"remarks_validate_html";
	var max = document.getElementById(max_var).innerHTML;
	if(Number(max) < Number(reporting))
	{
		sweetAlert('','You are Reporting more than balance to report quantity.','error');
		$('#'+reporting_id).val(0);
	}
}

$('input[type=submit]').click(function() {
    $(this).attr('disabled', 'disabled');
    $(this).parents('form').submit()
})

function check_pack()
{
	var count = document.getElementById('count_of_data').value;
	// var qty = document.getElementById('pack').value;
	// var status = document.getElementById('status').value;
	var tot_qty = 0;
	for(var i=0; i<count; i++)
	{
		var variable = i+"reporting";
		var qty_cnt = document.getElementById(variable).value;
		tot_qty += Number(qty_cnt);
	}
	
	if(Number(tot_qty) <= 0)
	{
		sweetAlert("Please enter atleast one size quantity","","warning");
		//swal('Please Enter Any size quantity','','warning');
		return false;
	}
	else
	{   
		$('.submission').hide();
		$('#progressbar').show();
		$('.progress-bar').css('width', 30+'%').attr('aria-valuenow', 20); 
		$('.progress-bar').css('width', 50+'%').attr('aria-valuenow', 30); 

		var bulk_data =  $("#smartform").serialize();
		var function_text = "<?php echo getFullURL($_GET['r'],'functionallity_scanning.php','R'); ?>";
		$('.progress-bar').css('width', 80+'%').attr('aria-valuenow', 40); 
		document.getElementById('maindiv').style.display = 'none';
		document.getElementById('dynamic_table1').innerHTML = '';
		// document.getElementById('docket_number').value = '';
  //       document.getElementById('style').innerHTML = '';
  //       document.getElementById('schedule').innerHTML = '';
  //       document.getElementById('mapped_color').innerHTML = '';
		document.getElementById('pre_data').innerHTML ='';
		$('#smart_btn_arear').hide();
		
		console.log(bulk_data);
        $.ajax
        ({
        	type: "POST",
        	//url: function_text,
        	url: function_text+"?get_details=1",
        	data : {bulk_data: bulk_data},
        	success: function (response) 
        	{	
        		$('#pre_pre_data').show();
        		document.getElementById('pre_data').innerHTML = response;
        		$('.progress-bar').css('width', 100+'%').attr('aria-valuenow', 80);
        		$('.progress').hide();
        		$('#smart_btn_arear').show();
        	}
            
        });
	}
}		
		
		//var bulk_data =  $("#smartform").serialize();  


</script>


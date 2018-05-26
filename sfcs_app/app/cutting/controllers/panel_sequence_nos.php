		<style>
			#loading-image {
			  border: 16px solid #f3f3f3;
			  border-radius: 50%;
			  border-top: 16px solid #3498db;
			  width: 120px;
			  height: 120px;
			  margin-left: 40%;
			  -webkit-animation: spin 2s linear infinite; /* Safari */
			  animation: spin 2s linear infinite;
			}

			/* Safari */
			@-webkit-keyframes spin {
			  0% { -webkit-transform: rotate(0deg); }
			  100% { -webkit-transform: rotate(360deg); }
			}

			@keyframes spin {
			  0% { transform: rotate(0deg); }
			  100% { transform: rotate(360deg); }
			}
		</style>
	<script type="text/javascript">

    function check_style()
	{
		
		var style=document.getElementById('style').value;
		if(style=='')
		{
			sweetAlert('Please Select Style First','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}
	
	function check_style_sch()
	{
		
		var style=document.getElementById('style').value;
		var sch=document.getElementById('schedule').value;
	
		if(style=='')
		{
			sweetAlert('Please Select Style First','','warning');
			return false;
		}
		else if(sch=='')
		{

			sweetAlert('Please Select schedule','','warning');
			return false;
		
		}
		else
		{
			return true;
		}
	}
		</script>	

		<?php			
			include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	
		?>
		<?php 			
            error_reporting(0);
			$styles="SELECT DISTINCT order_style_no FROM  $bai_pro3.bai_orders_db_confirm WHERE order_tid IN (SELECT DISTINCT order_tid FROM $bai_pro3.plandoc_stat_log)";	
			$styles_result=mysqli_query($link, $styles) or exit("Error at getting style no's".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($styles_result);

		?>				
			<div class="panel panel-primary"> 
            	<div class="panel-heading"><strong>Panels Sequence No's Generation - Report</strong></div>
                <div class="panel-body">
                    <form action="#" method="POST" class="form-inline" id="panelform">
                        <div class="form-group">
                            <label>Style:</label>
                            <select class="form-control" name="style" id="style" >
								<option value=''>Select Style</option>
								<?php				    	
									if ($sql_num_check > 0) {
										while($row = mysqli_fetch_array($styles_result)) {											
											echo "<option value='".$row['order_style_no']."'>".$row['order_style_no']."</option>";
										}
									} else {
										echo "<option value=''>No Data Found..</option>";
									}
								?>
							</select>
                        </div>
                        <div class="form-group">
                            <label>Schedule Number:</label>
                            <select name="schedule" class="form-control test123" id='schedule' disabled>
								<option value=''>Select Schedule</option>
							</select>
                        </div>
                        <div class="form-group">
                            <label>Color:</label>
                            <select name="color" class="form-control" id='color' disabled>
								<option value=''>Select Color</option>
							</select>
                        </div>
                        <div class="form-group" id="mostatus">
                            <label>MO Status:</label>
                            <label><strong><span id="mo_status"></span></strong></label>
                        </div>
                        <input type="text" hidden name="submit" value="submit"/>
                        <button type="button" class="btn btn-primary" id="submit">Generate</button>
                    </form>
                	<img id="loading-image" class=""/>  
                	<br/>
                	<div class="tabledata" >
                		<table class="table table-striped">
                			<thead>
                				<tr>
                					<th>Sl.No</th>
                					<th>Doc No.</th>
                					<th>Planned Plies</th>
                					<th>Actual Plies</th>
                					<th>Actual Cut No.</th>
                					<th>Cut Status</th>
                					<th>Cut Issue Status</th>
                				</tr>
                			</thead>
                			<tbody id="tablebody">
                			</tbody>
                		</table>
                	</div>             	
                </div>
            </div>

            <div id="printdata"></div>	
	</div>
<script>
$(document).ready(function() {
	$(".tabledata").hide();
    $('#style').select2();
    $('#schedule').select2();
    $('#color').select2();
    $('#mostatus').hide();
    $('#submit').hide();
    $('#loading-image').hide();


    $("#style").change(function(){
    	var style = $('#style').val();
    	$("#tablebody").html("");
    	$("#schedule").empty().append('<option value="">Select Schedule</option>').val('').trigger('change');
    	$("#color").empty().append('<option value="">Select Color</option>').val('').trigger('change');
		if(style != ''){
    		$('#loading-image').show();
			var url = "<?= getFullURLLevel($_GET['r'],'common/php/apicalls.php',1,'R'); ?>";
			$.ajax({
			    type: "get",
			    url: url+"?style="+style,
			    dataType: "json",
			    success: function (data) {
			    	$('#schedule').prop('disabled',false);
			    	$('#loading-image').hide();
			        $.each(data, function(key, value) {
						$('select[name="schedule"]').append('<option value="'+ key +'">'+ value +'</option>');
					});        
			    }
			});
		}else{
			$('#loading-image').hide();
		}
		
	});

	$("#schedule").change(function(){
		$(".tabledata").hide();
    	var style = $('#style').val();
    	var schedule = $('#schedule').val(); 
    	$("#tablebody").html("");  	
    	$("#color").empty().append('<option value="">Select Color</option>').val('').trigger('change');	
    	if(style != '' && schedule !=''){
    		$('#loading-image').show();  
			var url = "<?= getFullURLLevel($_GET['r'],'common/php/apicalls.php',1,'R'); ?>";  
	    	$.ajax({
			    type: "get",
			    url: url+"?schedule="+schedule+"&style="+style,
			    dataType: "json",
			    success: function (data) {
			    	$('#color').prop('disabled',false);
			    	$('#loading-image').hide();
			        $.each(data, function(key, value) {
						$('select[name="color"]').append('<option value="'+ key +'">'+ value +'</option>');
					});        
			    }		    
			});	
    	}else{
			$('#loading-image').hide();
		}
	});


	$("#color").change(function(){
		$(".tabledata").hide();
    	$('#loading-image').show();
    	var style = $('#style').val();
    	var schedule = $('#schedule').val();
    	$("#tablebody").html("");
    	var color = $('#color').val();
    	if(style !='' && schedule!= '' && color != ''){
    		$('#loading-image').show();
			var url = "<?= getFullURLLevel($_GET['r'],'common/php/apicalls.php',1,'R'); ?>";  
    		$.ajax({
			    type: "get",
			    url: url+"?schedule="+schedule+"&style="+style+"&color="+color,
			    dataType: "json",
			    success: function (data) {
			    	$('#loading-image').hide();
			    	$('#mostatus').show();		    	
			    	if(data == 'Yes'){
			    		$('#submit').show();
			    		$('#mo_status').css('color','green');
			    	}else{
			    		$('#submit').hide();
			    		$('#mo_status').css('color','red');
			    	}		    	
			    	$('#mo_status').html(data);
			    }
			});
    	}else{
			$('#loading-image').hide();
		}
	});


	//submitting form
	$('#submit').click( function() {
		var style = $('#style').val();
    	var schedule = $('#schedule').val();
    	var color = $('#color').val();
    	var order_tid = style.concat(schedule, color);
    	//var order_tid = style+schedule+color;
		var urlSubmit = "<?= getFullURLLevel($_GET['r'],'common/php/apicalls.php',1,'R'); ?>";  
		var urlSubmit1 = "<?= getFullURLLevel($_GET['r'],'/common/php/panel_sequence_print.php',1,'R'); ?>"; 
	    $.ajax({
	        url: urlSubmit,
	        type: 'post',
	        dataType: 'json',
	        data: $('form#panelform').serialize(),
	        success: function(data) {
               if(data.length > 0){
				   $(".tabledata").show();
               		$("#tablebody").html("");
					for(i = 0; i < data.length ; i++){
						var tr = $("<tr></tr>");
						var td1 = $("<td></td>").text( i + 1 + "");
						if(data[i].act_cut_status == "DONE"){
							var td2 = $("<td></td>").html('<strong><a href='+urlSubmit1+'?doc_no='+data[i].doc_no+'&order_tid='+encodeURI(order_tid)+' target=_blank>'+data[i].doc_no+'</a></strong>');}
						else{ 
							var td2 = $("<td></td>").html("<strong>"+data[i].doc_no+"</strong>");
						}
						var td3 = $("<td></td>").text(data[i].p_plies);
						var td4 = $("<td></td>").text(data[i].a_plies);
						var td5 = $("<td></td>").text(data[i].acutno);
						var td6 = (data[i].act_cut_status)?$("<td style='color:green;'></td>").text(data[i].act_cut_status):$("<td></td>").text('Not Done');
						var td7 = (data[i].act_cut_issue_status)?$("<td style='color:green;'></td>").text(data[i].act_cut_issue_status):$("<td></td>").text('Not Done');
						tr.append(td1, td2, td3, td4, td5, td6, td7);
						$("#tablebody").append(tr);
					}
               }else{
               	 alert('some issue occured please try again');
               }
             }
	    });
	});
});
</script>
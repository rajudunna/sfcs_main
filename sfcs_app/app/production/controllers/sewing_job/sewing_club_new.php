<html>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',4,'R'); ?>"></script>
<?php 
include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include(getFullURLLevel($_GET['r'],'common/config/server_urls.php',4,'R'));
include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
include(getFullURLLevel($_GET['r'],'common/config/functions_v2.php',4,'R'));
$table_filter = getFullURL($_GET['r'],'TableFilter_EN/tablefilter.js','R');

$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
// $plantcode='AIP';
// $username='Mounika';
?>
<script>
var url = '<?= getFullURLLevel($_GET['r'],'sewing_club_new.php',0,'N'); ?>';
function firstbox() 
{ 
	window.location.href =url+"&style="+document.test.style.value 
} 

function secondbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value 
} 

function thirdbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value 
}
function forthbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value 
}
// function fifthbox() 
// { 
//     window.location.href =url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value+"&sub_po="+document.test.sub_po.value 
// }

//use this function for check all the boxes
function checkAll()
{
     var checkboxes = document.getElementsByTagName('input'), val = null;    
     for (var i = 0; i < checkboxes.length; i++)
     {
         if (checkboxes[i].type == 'checkbox')
         {
             if (val === null) val = checkboxes[i].checked;
             checkboxes[i].checked = val;
         }
     }
}

var table3Filters = {
	sort_select: true,
	display_all_text: "Display all",
	loader: true,
	loader_text: "Filtering data...",
	sort_select: true,
	exact_match: false,
	rows_counter: true,
	btn_reset: true
}
setFilterGrid("dynamic_table",table3Filters);
</script>
<head>
<?php
	$get_style=$_GET['style'];
	$get_schedule=$_GET['schedule']; 
	$get_color=$_GET['color'];
	$get_mpo=$_GET['mpo'];
	$get_sub_po=$_GET['sub_po'];

?>
<div class="ajax-loader" id="loading-image" style="display: none">
    <center><img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" style="padding-top: 250px"/></center>
</div>
<div class = "panel panel-primary">
<div class = "panel-heading">Sewing Job Clubbing</div>
<div class = "panel-body">
<form name="test" action="<?php echo getFullURLLevel($_GET['r'],'sewing_club_new.php','0','N'); ?>" method="post">
<?php

//function to get style from mp_color_details
if($plantcode!=''){
	$result_mp_color_details=getMpColorDetail($plantcode);
	$style=$result_mp_color_details['style'];
}
echo "<div class='row'>"; 
echo "<div class='col-sm-4'><label>Select Style: </label><select name=\"style\" onchange=\"firstbox();\" class='form-control' required>"; 
echo "<option value=\"\" selected>NIL</option>";
foreach ($style as $style_value) {
	if(str_replace(" ","",$style_value)==str_replace(" ","",$get_style)) 
	{ 
		echo '<option value=\''.$style_value.'\' selected>'.$style_value.'</option>'; 
	} 
	else 
	{ 
		echo '<option value=\''.$style_value.'\'>'.$style_value.'</option>'; 
	}
} 
echo "</select></div>";
//qry to get schedules form mp_mo_qty based on master_po_details_id 
if($get_style!=''&& $plantcode!=''){
	$result_bulk_schedules=getBulkSchedules($get_style,$plantcode);
	$bulk_schedule=$result_bulk_schedules['bulk_schedule'];
}  
echo "<div class='col-sm-4'><label>Select Schedule: </label><select name=\"schedule\" onchange=\"secondbox();\" class='form-control' required>";  
echo "<option value=\"\" selected>NIL</option>";
foreach ($bulk_schedule as $bulk_schedule_value) {
	if(str_replace(" ","",$bulk_schedule_value)==str_replace(" ","",$get_schedule)) 
	{ 
		echo '<option value=\''.$bulk_schedule_value.'\' selected>'.$bulk_schedule_value.'</option>'; 
	} 
	else 
	{ 
		echo '<option value=\''.$bulk_schedule_value.'\'>'.$bulk_schedule_value.'</option>'; 
	}
} 
echo "</select></div>";

//function to get color form mp_mo_qty based on schedules and plant code from mp_mo_qty
if($get_schedule!='' && $plantcode!=''){
	$result_bulk_colors=getBulkColors($get_schedule,$plantcode);
	$bulk_color=$result_bulk_colors['color_bulk'];
}
echo "<div class='col-sm-4'><label>Select Color: </label>";  
echo "<select name=\"color\" onchange=\"thirdbox();\" class='form-control' >
		<option value=\"NIL\" selected>NIL</option>";
			foreach ($bulk_color as $bulk_color_value) {
				if(str_replace(" ","",$bulk_color_value)==str_replace(" ","",$get_color)) 
				{ 
					echo '<option value=\''.$bulk_color_value.'\' selected>'.$bulk_color_value.'</option>'; 
				} 
				else 
				{ 
					echo '<option value=\''.$bulk_color_value.'\'>'.$bulk_color_value.'</option>'; 
				}
			} 
echo "</select></div>";

//function to get master po's from mp_mo_qty based on schedule and color
if($get_schedule!='' && $get_color!='' && $plantcode!=''){
	$result_bulk_MPO=getMpos($get_schedule,$get_color,$plantcode);
	$master_po_description=$result_bulk_MPO['master_po_description'];
}
	echo "<div class='col-sm-4'><label>Select Master PO: </label>";  
	echo "<select name=\"mpo\" onchange=\"forthbox();\" class='form-control' >
			<option value=\"NIL\" selected>NIL</option>";
				foreach ($master_po_description as $key=>$master_po_description_val) {
					if(str_replace(" ","",$master_po_description_val)==str_replace(" ","",$get_mpo)) 
					{ 
						echo '<option value=\''.$master_po_description_val.'\' selected>'.$key.'</option>'; 
					} 
					else 
					{ 
						echo '<option value=\''.$master_po_description_val.'\'>'.$key.'</option>'; 
					}
				} 
	echo "</select></div>";

	//function to get sub po's from mp_mo_qty based on master PO's
	if($get_mpo!='' && $plantcode!=''){
		$result_bulk_subPO=getBulkSubPo($get_mpo,$plantcode);
		$sub_po_description=$result_bulk_subPO['sub_po_description'];
	}
	echo "<div class='col-sm-4'><label>Select Sub PO: </label>";  
	echo "<select name=\"sub_po\" id=\"sub_po\" class='form-control' >
			<option value=\"NIL\" selected>NIL</option>";
				foreach ($sub_po_description as $key=>$sub_po_description_val) {
					if(str_replace(" ","",$sub_po_description_val)==str_replace(" ","",$get_sub_po)) 
					{ 
						echo '<option value=\''.$sub_po_description_val.'\' selected>'.$key.'</option>'; 
					} 
					else 
					{ 
						echo '<option value=\''.$sub_po_description_val.'\'>'.$key.'</option>'; 
					}
				} 
	echo "</select></div>";

	echo "</div>";
?>
		<input type="hidden" id="plant_code" name="plant_code" value='<?= $plantcode; ?>'>
		<input type="hidden" id="username" name="username" value='<?= $username; ?>'>
	</form>
</br>
<div id ="dynamic_table1">

</div>
	<div id='alert-box' class='deliveryChargeDetail'></div>
		<form method='post'>
			<input type='hidden' id='myval' name='myval'>
			<input type="button" class="btn btn-primary btn-md pull-right" id="submit" name="Merge Jobs" value="Merge Jobs" style='display:none;'>
		</form>
	</div>
</div>
<script>
$(document).ready(function() 
{
	
	$('#loading-image').hide();
	$('#schedule').on('click',function(e){
		var style = $('#style').val();
		if(style == null){
			sweetAlert('Please Select Style','','warning');
		}
	});
	$('#color').on('click',function(e){
		var style = $('#style').val();
		var schedule = $('#schedule').val();
		if(style == null && schedule == null){
			sweetAlert('Please Select Style and Schedule','','warning');
		}
		else if(schedule == null){
			sweetAlert('Please Select Schedule','','warning');
			document.getElementById("submit").disabled = true;
		}
		else {
			document.getElementById("submit").disabled = false;
		}
	});
	$('#sub_po').on('change', function(){
		$('#dynamic_table1').html('');
		$('#loading-image').show();
		
		var plant_code = $('#plant_code').val();
		var username = $('#username').val();
		var subpo = $('#sub_po').val();
		var inputObj = {"poNumber":subpo, "plantCode":plant_code};
		var bearer_token;
        const creadentialObj = {
									grant_type: 'password',
									client_id: 'pps-back-end',
									client_secret: '1cd2fd2f-ed4d-4c74-af02-d93538fbc52a',
									username: 'bhuvan',
									password: 'bhuvan'
								}
        $.ajax({
            method: 'POST',
            url: "<?php echo $KEY_LOCK_IP?>",
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            xhrFields: { withCredentials: true },
            contentType: "application/json; charset=utf-8",
            transformRequest: function (Obj) {
                var str = [];
                for (var p in Obj)
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(Obj[p]));
                return str.join("&");
            },
            data: creadentialObj
        }).then(function (result) {
            console.log(result);
            bearer_token = result['access_token'];
            $.ajax({
				type: "POST",
				url: '<?= $PPS_SERVER_IP.'/jobs-generation/getJobDetailsByPo' ?>',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded','Authorization': 'Bearer ' +  bearer_token },
				data: inputObj,
				success: function(response) 
				{
					if (response.status) {
						var jobsInfo = response;
						if(jobsInfo.data.length > 0){
							tableConstruction(jobsInfo.data);
							$('#submit').show();
						} else {
							$('#loading-image').hide();
							swal('','No Jobs found for this Sub Po', 'error');
							return;
						}
					} else {
						$('#loading-image').hide();
						swal('',response.internalMessage, 'error');
						return;
					}
				}, error: function() {
					$('#loading-image').hide();
					swal('','Unable to get jobs for the production order',error);
				}
			}); 
        }).fail(function (result) {
            console.log(result);
        }) ;
	});
});

function tableConstruction(jobsInfo){
    s_no = 0;
    if(jobsInfo)
    {
        $('#dynamic_table1').html('');
        $('#dynamic_table').html('');
        for(var i=0;i<jobsInfo.length;i++)
        {
            var hidden_class='';
            if(i==0)
            {
                var markup = "<div class='container'><div class='row'><div id='no-more-tables'><table class = 'col-sm-12 table-bordered table-striped table-condensed cf' id='dynamic_table'><thead class='cf'><tr><th>Schedule</th><th>Cut Number</th><th>Input Job#</th><th>Quantity</th><th>Clubbing Details</th></tr></thead><tbody>";
                $("#dynamic_table1").append(markup);
            }
            s_no++;
            var markup1 = "<tr class="+hidden_class+"><td data-title='schedule'>"+jobsInfo[i].schedule.toString()+"</td><td data-title='cutJob'>"+jobsInfo[i].cutNumber+"</td>\
            <td><button type='button' id='inpjob' name='inpjob' class='btn btn-primary btn-sm' value="+jobsInfo[i].jobNumbers+" \
			onclick='showdet(this,\""+jobsInfo[i].jobNumbers+'\",\"'+jobsInfo[i].schedule.toString()+"\");'>"+jobsInfo[i].jobNumbers+"</button></td><td data-title='quantity'>"+jobsInfo[i].quantity+"</td>";
			if(jobsInfo[i].plannedStatus){
				markup1 += "<td>Already Job Planned</td></tr>";
			} else {
				markup1 += "<td><input type='checkbox' id='club' name='club[]' value="+jobsInfo[i].jobNumbers+"></td></tr>";
			}
            $("#dynamic_table").append(markup1);
            $("#dynamic_table").hide();
		}
		
    }
    var markup99 = "</tbody></table></div></div></div>";
	$("#dynamic_table").append(markup99);
	$('#loading-image').hide();
    $("#dynamic_table").show();
    $("#dynamic_table").DataTable();
    $('#schedule').val('');
    
    
}

function showdet(btn,inpjob,schedule)
{
	var inputjob=inpjob;
	var schedule=schedule;
	var plant_code = $('#plant_code').val();
	window.open('/sfcs_app/app/production/controllers/sewing_job/small_popup_new.php?schedule='+schedule+'&inputjob='+inputjob+'&plantcode='+plant_code+'_blank');
}


$(document).ready(function() 
{
	$('#submit').on('click', function(){
		$('#loading-image').show();
		var numberOfChecked = $('input:checkbox:checked').length;
		var bearer_token;
		const creadentialObj = {
		grant_type: 'password',
		client_id: 'pps-back-end',
		client_secret: '1cd2fd2f-ed4d-4c74-af02-d93538fbc52a',
		username: 'bhuvan',
		password: 'bhuvan'
		}
		$.ajax({
			method: 'POST',
			url: "<?php echo $KEY_LOCK_IP?>",
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			xhrFields: { withCredentials: true },
			contentType: "application/json; charset=utf-8",
			transformRequest: function (Obj) {
				var str = [];
				for (var p in Obj)
					str.push(encodeURIComponent(p) + "=" + encodeURIComponent(Obj[p]));
				return str.join("&");
			},
			data: creadentialObj
		}).then(function (result) {
			console.log(result);
			bearer_token = result['access_token'];
			if(numberOfChecked > 1) {
			var jobIds = [];
			$('input[type="checkbox"]').each((key, element) => {
				if (element.checked) {
					jobIds.push(element.value);
				}
			});
			var plant_code="<?= $_SESSION['plantCode'] ;?>";
			var schedule="<?= $_GET['schedule'] ;?>";
			var checkarr = $('#myval').val();
			var inputObj = {"jobNumbers":jobIds, "plantCode":plant_code};
			$.ajax({
				type: "POST",
				url: "<?= $PPS_SERVER_IP ?>/jobs-generation/JobClubbing",
				headers: { 'Content-Type': 'application/x-www-form-urlencoded','Authorization': 'Bearer ' +  bearer_token },
				data: inputObj,
				success: function(response) 
				{
					if (response.status) {
						$('#loading-image').hide();
						swal('','Sewing jobs clubbed successfully','success');
					} else {
						$('#loading-image').hide();
						swal('',response.internalMessage,'error');
					}
					$("#sub_po").val(document.test.sub_po.value).change();
					$('#sub_po').trigger('change');
				}
			});	
		}else {
			$('#loading-image').hide();
			swal('','Please Select More than One Sewing Job to Club','error');
		}
		}).fail(function (result) {
			console.log(result);
		}) ;
	});
});		
</script>	

<script>
	$(document).ready(function() {
    var tableUsers =  $('#dynamic_table').DataTable();
	var rows = tableUsers.rows({ 'search': 'applied' }).nodes();
		$('input[type="checkbox"]', rows).each(function(i,e){				
			$(e).change(function(){
				var checkBoxC = [];
				var club = new Array();
				var idsp = '';
				$('input[type="checkbox"]:checked', rows).each(function(o,a){
					checkBoxC[checkBoxC.length]=$(a).val();
						$.each(checkBoxC, function(h, el){
						if($.inArray(el, club) === -1) club.push(el);			
						
					});
					if(club.length>0)
					{
						idsp = '<p>List Of Sewing Jobs to be Clubbed :</p><ul class = list-group >';
						for(var i=0;i<club.length;i++){
							idsp+="<li class='label label-success' style='font-size:15px;'>J"+club[i]+"</li>&nbsp;";
						}
						idsp+='</ul>';
					}
				});
				//$(".deliveryChargeDetail ul").addClass('list-group');
				$('#myval').val(club);
				$('#alert-box').html(idsp);
			});
		});
	
     });
</script>
<style>
table th
{
border: 1px solid grey;
text-align: center;
   background-color: #003366;
color: WHITE;
white-space:nowrap; 
padding-left: 5px;
padding-right: 5px;
}
table{
white-space:nowrap; 
border-collapse:collapse;
font-size:12px;
background-color: white;
}
table tr
{
border: 1px solid grey;
text-align: right;
white-space:nowrap; 
}

table td
{
border: 1px solid grey;
text-align: center;
white-space:nowrap;
color:black;
}
div#example_filter {
    display: none;
}
.lastActive {
    background-color: red;
} 
#loading-image{
  position:fixed;
  top:0px;
  right:0px;
  width:100%;
  height:100%;
  background-color:#666;
  /* background-image:url('ajax-loader.gif'); */
  background-repeat:no-repeat;
  background-position:center;
  z-index:10000000;
  opacity: 0.4;
  filter: alpha(opacity=40); /* For IE8 and earlier */
}
</style>
</body>

</html>



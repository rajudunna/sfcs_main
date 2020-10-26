<link rel="stylesheet" type="text/css" href="../../../../common/css/bootstrap.min.css">
<script type="text/javascript" src="/sfcs_app/common/js/jquery_new.min.js"></script>
<?php

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/server_urls.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
// error_reporting(0);
?>
<div class="panel panel-primary">
<div class = "panel-heading">Input Job Wise Details</div>
<div class = "panel-body">
<div id ="dynamic_table1">
</div>
</div>
<script>
$(document).ready(function() 
{
		// url: 'http://192.168.0.155:3336​/jobs-generation​/getJobColorSizeDetails',

	$('#dynamic_table1').html('');
	var schedule="<?= $_GET['schedule'] ;?>";
	var inputjob="<?= $_GET['inputjob'] ;?>";
	var plant_code="<?= $_GET['plantcode'] ;?>";
	var inputObj = {"jobNumber":inputjob, "plantCode":plant_code};
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
		console.log(result+'res');
		bearer_token = result['access_token'];
		$.ajax({
			type: "POST",
			url: '<?= $PPS_SERVER_IP.'/jobs-generation/getJobColorSizeDetails' ?>',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded','Authorization': 'Bearer ' +  bearer_token },
			data: inputObj,
			success: function(response) 
			{
				var bundet = response;
				tableConstruction(bundet);
			},error: function(e) {
				console.log(e);
				alert();
			}
		});	
	}).fail(function (result) {
		console.log(result);
	}) ;
});

function tableConstruction(bundet){
    console.log(bundet);
	s_no = 0;
    if(bundet)
    {
		$('#dynamic_table1').html('');
		for(var i=0;i<bundet.data.length;i++)
        {
			var hidden_class='';
			if(i==0)
            {
                var markup = "<div class='container'><div class='row'><div id='no-more-tables'><table class = 'col-sm-12 table-bordered table-striped table-condensed cf' id='dynamic_table'><thead class='cf'><tr><th>Size</th><th>Color</th><th>Quantity</th></tr></thead><tbody>";
                $("#dynamic_table1").append(markup);
            }
            s_no++;
			
			var markup1 = "<tr class="+hidden_class+"><td data-title='size'>"+bundet.data[i].size+"</td><td data-title='color'>"+bundet.data[i].color+"</td><td data-title='quantity'>"+bundet.data[i].quantity+"</td></tr>";
            $("#dynamic_table").append(markup1);
            $("#dynamic_table").hide();

		}
	}
	var markup99 = "</tbody></table></div></div></div>";
    $("#dynamic_table").append(markup99);
    $("#dynamic_table").show();
    
	
}
</script>
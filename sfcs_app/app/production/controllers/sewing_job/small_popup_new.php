<div class="panel panel-primary">
<div class = "panel-heading">Input Job Wise Details</div>
<div class = "panel-body">
<div id ="dynamic_table1">
</div>
</div>
<script>
$(document).ready(function() 
{
	$('#dynamic_table1').html('');
	var schedule="<?= $_GET['schedule'] ;?>";
	var inputjob="<?= $_GET['inputjob'] ;?>";
	var plant_code="<?= $_GET['plantcode'] ;?>";
	var inputObj = {"jobNumber":inputjob, "plantCode":plant_code};
	$.ajax({
		type: "POST",
		url: "<?php echo $PPS_SERVER_IP?>​/jobs-generation​/getJobColorSizeDetails",
		data: inputObj,
		success: function(response) 
		{
			var bundet = JSON.parse(response);
			tableConstruction(bundet);
		}
	});
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
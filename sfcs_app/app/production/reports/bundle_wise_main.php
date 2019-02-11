
<html>
<head>
	<script type="text/javascript" src="sfcs_app/common/js/tablefilter.js" ></script>
	<title>Bundle Wise Report</title>
	<?php
		include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
		include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions.php");
		$url1 = getFullURLLevel($_GET['r'],'style_wip_ajax.php',0,'R');		
	?>
	<link rel="stylesheet" type="text/css" href="../../common/css/bootstrap.css">
	<script src="../../common/js/jquery.min.js"></script>
	<script src="../../common/js/sweetalert.min.js"></script>
	 
</head>
<body>
	<div class="container-fluid">
		<div class="panel panel-primary">
			<div class="panel-heading">Bundle Wise Report</div>
			<div class="panel-body">
				<div class='row'>
					<div class="form-inline col-sm-10">

						<label><font size="2">Bundle Number: </font></label>
						<input type="text" class="form-control integer" id="bundle" name="bundle">
						<input type="button"  class="btn btn-success" value="Submit" onclick="getbundle()"> 
					</div>
				</div>
				<br>
				<div  class='panel panel-primary' id="dynamic_table1" hidden='true'>
						<div class='panel-heading'>Bundle Wise Report</div>
						<div style='overflow-y:scroll' class='panel-body' id="dynamic_table">
							
						</div>
			    </div>
			</div>
				
		</div>
	</div>
	<style>
		table, th, td {
			text-align: center;
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

	<div class="ajax-loader" id="loading-image" style="display: none">
		<center><img src="<?= getFullURLLevel($_GET['r'],'common/images/ajax-loader.gif',1,'R'); ?>" class="img-responsive" style="padding-top: 250px"/></center>
	</div>
		
</body>

<script type="text/javascript">
	function getbundle()
	{
		$('#loading-image').show();	
		var bundle = $("#bundle").val();
		if(bundle == '' || bundle == null)
		{
			$('#loading-image').hide();
			sweetAlert('Please Enter Bundle','','warning');
		}
		else
		{
			$.ajax({
				type: "GET",
				url: '<?= $url1 ?>?bundle='+bundle+'&some=bundle_no',
				success: function(response) 
				{
					$('#loading-image').hide();
					$('#dynamic_table1').show();
					document.getElementById('dynamic_table').innerHTML = response;
				}
			});
		}
	}
	
</script>
</html>
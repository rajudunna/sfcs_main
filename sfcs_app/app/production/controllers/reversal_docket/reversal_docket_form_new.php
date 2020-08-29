<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=11; IE=9; IE=8; IE=7; IE=6; IE=5; IE=EDGE" />
<?php
    $url = include(getFullURLLevel($_GET['r'],'/common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'/common/config/m3Updations.php',4,'R'));
	$plantcode=$_SESSION['plantCode'];
	$username=$_SESSION['userName'];
    $operation_code = 15;   
?>

<style>
            /* #loading-image {
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
            #delete_reversal_docket{
                margin-top:3pt;
            } */
        </style>
<body>


<div class="panel panel-primary"> 
    <div class="panel-heading">Cutting Reversal</div>
        <div class='panel-body'>
            <form method="post" name="form1" action="?r=<?php echo $_GET['r']; ?>">
                <div class="row">
                    <div class="col-md-3">
                        <label>Docket Number</label>
                        <input type="text" class='integer form-control' id="docket_number" name="docket_number" size=8 required>
                    </div>
                    <div class="col-md-2">
                        <label>Plies</label>
                        <input type="text" class='integer form-control' id="plies" name="plies" size=5 required>
                    </div><br/>
					<input type="hidden" id="plant_code" name="plant_code" value='<?= $plantcode; ?>'>
					<input type="hidden" id="username" name="username" value='<?= $username; ?>'>
					<input type="hidden" id="operation_code" name="operation_code" value='<?= $operation_code; ?>'>
                    <div class="col-md-3">
                        <input type="submit" class="btn btn-danger" name="formSubmit" id="delete_reversal_docket" value="Delete">
                    </div>
                    <img id="loading-image" class=""/>  
                </div>
            </form>
        </div>
    </div>

<script>
$(document).ready(function() 
{
	$('#delete_reversal_docket').on('click', function(){
		var plant_code = $('#plant_code').val();
		var username = $('#username').val();
		var operation_id = $('#operation_code').val();
		var docket_number = $('#docket_number').val();
		var plies = $('#plies').val();
		var inputObj = {docketNumber:docket_number, plantCode:plant_code, operationCode:operation_id, userName:username, plies:plies};
		var function_text = "<?php echo getFullURL($_GET['r'],'scanning_ajax_new.php','R'); ?>";
        $.ajax({
            type: "POST",
            url: function_text+"?inputObj="+inputObj,
            success: function(response) 
            {
                var bundet = JSON.parse(response);
                var msg=bundet.status;
				swal({
				 title: "",
				 text: msg,
				 type: "",
				 timer: 10000
				 });
            }
        });
	});
});	
</script>
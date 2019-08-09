<title>Add New Packing Method</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />

<body>
</body>
<?php 
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/rest_api_calls.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
    $action_url = getFullURL($_GET['r'],'save_team.php','N');
    if(isset($_REQUEST['row_id'])){
		$row_id=$_REQUEST['row_id'];
		$packing_team = $_REQUEST['packing_team'];
		$team_leader = $_REQUEST['team_leader'];
		$status=$_REQUEST['status'];
	}else{
		$row_id=0;
	}
?>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">Packing Team</div>
        <div class="panel-body">
        <form name="test" action="<?= $action_url ?>" method="POST" id='form_submt'>
            <div class="row">
                <div class="col-md-3">
        			<input type='hidden' id='row_id' name='row_id' value=<?php echo $row_id; ?> >
                    <b>Packing Team<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'></font></span></b><input type="text" class="form-control" id="packing_team" name="packing_team" value="<?php echo $packing_team; ?>" required>
                </div>
                <div class="col-md-3">
                    <b>Team Leader<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'></font></span></b><input type="text" class="form-control" id="team_leader" name="team_leader" value="<?php echo $team_leader; ?>" required>
                </div>
                <div class="col-md-3">
                    <div class="dropdown">
                        <b>Status</b> <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span>
                        <select class="form-control" id="status" name="status" required>
                        <option value="">Please Select</option>
                        <option value='Active' selected>Active</option>
                        <option value='In-Active' >In-Active</option>
                        </select>    
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <button type="submit"  class="btn btn-primary" style="margin-top:18px;">Save</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>

<?php include('view_team.php'); ?>

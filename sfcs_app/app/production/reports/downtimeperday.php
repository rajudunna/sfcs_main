<?php 
    include("..".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include("..".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
//$view_access=user_acl("SFCS_0061",$username,1,$group_id_sfcs); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- <html>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Down Time Report</title>
<head> -->
<!-- <script language="javascript" type="text/javascript" src="../styles/dropdowntabs.js"></script>
<link rel="stylesheet" href="../styles/ddcolortabs.css" type="text/css" media="all" /> -->
<!--IMPORT CSS STYLE SHEET FOR APPLYING FORMATING SETTINGS-->
<!-- <link rel="stylesheet" type="text/css" href="test.css" /> -->
<!-- <?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>	 -->

<div class="panel panel-primary">
<div class="panel-heading">Day DownTime Report</div>
<div class="panel-body">


<form action="<?= getFullURL($_GET['r'],'downtimeperday_data_new.php','N')?>" method="post" id="non-printable">
	<div class="row">
		<div class="col-md-3">
			<label>Start Date</label>
			<input type="text" data-toggle="datepicker" name="dat" id="demo1" size="8" value="<?php print(date("Y-m-d")); ?>"  class="form-control"/></td>
		</div>
		<div class="col-md-3">
			<label>End Date</label>
			<input type="text" name="dat1" data-toggle="datepicker" size="8" id="demo2" value="<?php print(date("Y-m-d")); ?>"  class="form-control"/></td>
		</div>
		<div class="col-md-3">
			<label>Select Team</label>
			<select name="team" class="form-control">
				<option value='"A","B"'>All</option>
				<option value='"A"'>A</option>
				<option value='"B"'>B</option>
			</select> 
		</div>
		<div class="col-md-3">
			<input type="submit" value="Show" class="btn btn-primary" onclick="return verify_date()" style="margin-top:22px;"/>
		</div>
	</div>
</form>
</div>
</div>
<script type="text/javascript">
	function verify_date(){
		var val1 = $('#demo1').val();
		var val2 = $('#demo2').val();
		// d1 = new Date(val1);
		// d2 = new Date(val2);
		if(val1 > val2){
			sweetAlert('Start Date Should  be less than End Date','','warning');
			return false;
		}
		else
		{
			return true;
		}
    }

</script>
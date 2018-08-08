<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R') );  ?>
<?php //include("menu_content.php");   This file has no content that was beign used ?>

<div class="panel panel-primary">
	<div class="panel-heading">Packing List View(Sewing Job)</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-6">
				<form name="test" action="<?php echo '?r='.$_GET['r']; ?>" method="post">
					<div class="row">
						<div class="col-sm-6">
							<label>Enter Schedule : </label><input type='text' id='sch' name='schedule' width=30 class="form-control integer" >
						</div>
						<div class="col-sm-3">
							<input type="submit" value="View" name="submit" id='sub' class="btn btn-info" style='margin-top:22px;' 
								   onclick="return check_sch_1();" >
						</div>
					</div>
				</form>
			</div>
			<!-- <div class="col-md-6">
				<h2><b>For Other Schedules</b></h2>
				<form name="test" action="<?php echo '?r='.$_GET['r']; ?>" method="post">
					<div class="row">
						<div class="col-sm-6">
							<label>Enter Schedule : </label>
							<input type='text' id='schedule' name='schedule' width=30 class="form-control" >
						</div>
						<div class="col-sm-3">
							<input type="submit" value="View" name="submit2" id='sub' class="btn btn-info" style='margin-top:22px;'
						     onclick="return check_sch();">
						</div>
					</div>
				</form>
			</div> -->
		</div>
	</div>
</div>

<?php
if(isset($_POST['submit']))
{
	echo "<hr>";
	$schedule=$_POST['schedule'];
	
	$quer="SELECT * FROM $bai_pro3.pac_stat_log WHERE schedule='$schedule'";
	// echo $quer;
	$quer_result=mysqli_query($link, $quer) or exit("Sql Error98 $quer".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rowq=mysqli_fetch_array($quer_result);
	
	if($rowq){
		$url = getFullURL($_GET['r'],'sawing_out_list.php','N');
		echo '<script type="text/javascript">
					var ajax_url = "'.$url.'&schedule='.$schedule.'";
					Ajaxify(ajax_url);
		  	  </script>'; 
	}
	else{
		echo '<div class="alert alert-danger" role="alert">Schedule Not Processed Yet</div>';
	}
}
	
	
if(isset($_POST['submit2']))
{
	echo "<hr>";
	$schedule=$_POST['schedule'];
	//echo $schedule;

	$quer="SELECT * FROM $bai_pro3.pac_stat_log WHERE schedule='$schedule'";
	//echo $quer;
	$quer_result=mysqli_query($link, $quer) or exit("Sql Error98 $quer".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rowq=mysqli_fetch_array($quer_result);

	if($rowq){
		$url = getFullURL($_GET['r'],'sawing_out_list_1.php','N');
		//echo $url;
		echo '<script type="text/javascript">
				var ajax_url = "'.$url.'&schedule='.$schedule.'"; Ajaxify(ajax_url);
		  	  </script>'; 
	}else{
		echo '<div class="alert alert-danger" role="alert">Schedule Not Processed Yet</div>';
	}

}
?>

<script type="text/javascript">
	
	function check_sch()
    {
		var int = document.getElementById("schedule").value;
		if(int=='')
		{
			sweetAlert("Please Enter Schedule","","warning");
			return false;
		}
		else
		{
			return true;
		}
    }
    function check_sch_1()
    {
		var int1 = document.getElementById("sch").value;

		if(int1=='')
		{
			sweetAlert("Please Enter Schedule","","warning");
			return false;
		}
		else
		{
			return true;
		}
    }
</script>


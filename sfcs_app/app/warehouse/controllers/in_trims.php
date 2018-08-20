<?php 
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/user_acl_v1.php");
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
$url = '/sfcs_app/app/warehouse/controllers/in_trims.php';
$out_trims_scanner = '/sfcs_app/app/warehouse/controllers/out_trims_scanner.php';
?>

<script>
function focus_box()
{
	document.input.cartonid.focus();
}
function check_docket(e){
	var d = document.getElementById('cartonid').value;
	var m = document.getElementById('cartonid2').value;
	if(m=='' && d ==''){
		sweetAlert('Please Enter Location ','','warning');
		e.preventDefault();
		return false;
	}
	return true;
}
</script>

<style>
body
{
	font-family:arial;
}
</style>

<body onload="focus_box()">
<div class='panel panel-primary'>
	<div class='panel-body'>
		<!--<div class=' text-left'><h4><span class="label label-success">In</span></h4></div>-->
		<?php

		if(isset($_GET['location']))
		{
			$location=$_GET['location'];
			
			$sql="select * from $bai_rm_pj1.location_db where location_id=\"$location\" and sno>0 and status=1";
			//echo "$sql";
			$sql_result=mysqli_query($link, $sql);
			if(mysqli_num_rows($sql_result)>0)
			{
				echo "<h2><label class='label1'>Location  : </label>&nbsp;&nbsp;<span class='label label-success' id='location'>$location</span></h2>";
			}
			else
			{
				echo "<h2><label class='label1'>Location  : </label>&nbsp;&nbsp;<span class='label label-danger'>Scan Valid Location !</span></h2>";
				$location="";
			}
			
			
		}
		else
		{
			echo "<h2><label>Location  : </label>&nbsp;&nbsp;<span class='label label-danger'>Scan Location !</span></h2>";
			$location="";
		}
    
		?>

		<form name="input" method="post" action="?r=<?= $url ?>" enctype="multipart/form data" id="form">
		<div class="row">
		<div class="form-group col-md-3">
		<input type="text" name="cartonid" id="cartonid" class="form-control" onkeyup="document.input.submit();"  value="">
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-3">
		<br/>Enter Lable ID:<br/>
		<input type="text" class="form-control" size="19" value="" id='cartonid2' name="cartonid2">
		</div>
		<input type="submit" id="check_in" name="check2" value="Check In" onclick='return check_docket(event)' class="btn btn-primary">
		<input type="hidden" name="location" value="<?php echo $location; ?>">
		<input type="hidden" name="check" value="check">
		</div>
		</form>
		
		<?php
echo "<br><div>
<div><h4>
	<a href=$url>
		<button class='equal btn btn-success'>In</button></a><Br/>
	<a href=$out_trims_scanner>
		<button class='equal btn btn-danger'>T-Out</button></a> </h4>
</div>
</div>";
		//Normal Process
		if(isset($_POST['cartonid']) or isset($_POST['check']))
		{
			
			$code=$_POST['cartonid'];
			$location=$_POST['location'];
			if(is_numeric(substr($code,0,1)))
			{
				$sql="select * from $bai_rm_pj1.location_db where location_id=\"$location\" and sno>0";
				//echo "<br/>".$sql."<br/>";
				$sql_result=mysqli_query($link, $sql);
				if(mysqli_num_rows($sql_result)>0)
				{
					$code=ltrim($code,"0");
					$sql1="update $bai_rm_pj1.store_in set ref1=\"$location\", status=0, allotment_status=0 where tid=\"$code\"";
					//echo "<br/>".$sql1."<br/>";
					$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_affected_rows($link)>0)
					{
						echo "<div id='status'>Status: <span class='label label-success'>Success!</span> $code</div>";
						echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"in_trims.php?location=$location\"; }</script>";
					}else{
						$sql1="select * from $bai_rm_pj1.store_in_deleted where tid=\"$code\" ";
						$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($sql_result1)>0)
						{
						echo "<h3>Status  : $code-<span class='label label-warning'>Label Deleted</span> </h3>";

						}
						else
						{
							$sql2="select * from $bai_rm_pj1.store_in where tid=\"$code\" ";
							$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							if(mysqli_num_rows($sql_result2)>0)
							{
								echo "<h3>Status  : $code-<span class='label label-info'>Label Already Scanned</span> </h3>";
							}
							else
							{

							echo "<h3>Status  :$code- <span class='label label-warning'>Label Not Found</span> </h3>";

							}
						}
						// echo "<h2>Status: <span class='label label-warning'>Failed (or) already updated</span> $code</h2>";
						//echo "<button id='back' onclick='back()' class='btn btn-warning'><< Go back</button>";
						echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"in_trims.php?location=$location&code=$code\"; }</script>";
						
					}
					
				}
				else
				{
					echo "<h3>Status: <span class='label label-danger'>Scan Location!</span></h3>";
				}
			}
			else
			{
				
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"in_trims.php?location=$code\"; }</script>";
			}
		}

		//Manual Lable Entry
		if(isset($_POST['check2']))
		{
			// echo "<hr/>";
			$code=$_POST['cartonid2'];
			$location=$_POST['location'];
			
			if(is_numeric(substr($code,0,1)))
			{
				$sql="select * from $bai_rm_pj1.location_db where location_id=\"$location\" and sno>0";
				$sql_result=mysqli_query($link, $sql);
				if(mysqli_num_rows($sql_result)>0)
				{
					$code=ltrim($code,"0");
					$sql1="update $bai_rm_pj1.store_in set ref1=\"$location\", status=0, allotment_status=0 where tid=\"$code\"";
					$sql_result1=mysqli_query($link, $sql1);
					if(mysqli_affected_rows($link)>0)
					{
						echo "<div id='status'>Status  : <span class='label label-success'>Success!</span> $code</div>";
						echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"in_trims.php?location=$location\"; }</script>";
					}
					else
					{
						$sql1="select * from $bai_rm_pj1.store_in_deleted where tid=\"$code\" ";
						$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($sql_result1)>0)
						{
						echo "<h3>Status  : $code-<span class='label label-warning'>Label Deleted</span> </h3>";

						}
						else
						{
							$sql2="select * from $bai_rm_pj1.store_in where tid=\"$code\" ";
							$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							if(mysqli_num_rows($sql_result2)>0)
							{
								echo "<h3>Status  : $code-<span class='label label-info'>Label Already Scanned</span> </h3>";
							}
							else
							{

							echo "<h3>Status  :$code- <span class='label label-warning'>Label Not Found</span> </h3>";

							}
						}
						// echo "<h2>Status  : <span class='label label-warning'>Failed (or) already updated</span> $code</h2>";
						// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"".getFullURL($_GET['r'],'return.php','N')."&location=$location&code=$code\"; }</script>";
						echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"in_trims.php?location=$location&code=$code\"; }</script>";
					}
					
				}
				else
				{
					echo "<h2>Status  : <span class='label label-danger'>Scan Location!</span></h2>";
				}
			}
			else
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = 'in_trims.php?location=".$code."'; }</script>";
			}
		}

		//echo "<div class='pull-right text-right'><div ><h2><font color=\"green\">In</font></h2><br/><h2><a href='$url'><button class='btn btn-primary'>In</button></a> <Br/><a href='".getFullURL($_GET['r'],'out.php','N')."'><button class='btn btn-primary'>F-Out</button></a><Br/><a href='".getFullURL($_GET['r'],'out_trims_scanner.php','N')."'><button class='btn btn-primary'>T-Out</button></a> </h2></div></div>";
		?>
	</div>
</div>
</body>

</div>

<?php 
include("../".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include("../".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
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
		sweetAlert('Please fill docket or label no ','','warning');
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
<!-- <?php 
echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />';
 ?>
</head> -->
<body onload="focus_box()">
<div class='panel panel-primary'>
	<div class='panel-heading'>
		Online Barcode Scanning
	</div>
	<div class='panel-body'>
		<div class=' text-left '><h4><span class="label label-success">In</span></h4></div>
		<?php
			echo "<br><div class='pull-right '>
				<div><h2>
					<a href='".getFullURL($_GET['r'],'index.php','N')."'>
						<button class='equal btn btn-success'>In</button></a><Br/>
					<a href='".getFullURL($_GET['r'],'out_trims.php','N')."'>
						<button class='equal btn btn-danger'>T-Out</button></a> </h2>
				</div>
			 </div>";
		

		if(isset($_GET['location']))
		{
			$location=$_GET['location'];
			
			$sql="select * from $bai_rm_pj1.location_db where location_id=\"$location\" and sno>0 and status=1";
			$sql_result=mysqli_query($link, $sql);
			if(mysqli_num_rows($sql_result)>0)
			{
				echo "<h2><label>Location  : </label>&nbsp;&nbsp;<span class='label label-success'>$location</span></h2>";
			}
			else
			{
				echo "<h2><label>Location  : </label>&nbsp;&nbsp;<span class='label label-danger'>Scan Valid Location !</span></h2>";
				$location="";
			}
			
			
		}
		else
		{
			echo "<h2><label>Location  : </label>&nbsp;&nbsp;<span class='label label-danger'>Scan Location !</span></h2>";
			$location="";
		}


		?>

	<!-- onkeydown="document.input.submit();" -->
		<form name="input" method="post" action="?r=<?= $_GET['r'] ?>" enctype="multipart/form data">
		<div class="row">
		<div class="form-group col-md-3">
		<input type="text" name="cartonid" id="cartonid" class="form-control" onkeyup="document.input.submit();"  value="">
		</div>
		</div>
		<!-- <input type="text" size="19" value="" name="cartonid" onkeyup='check(this)' id="cartonid"> -->
		<div class="row">
		<div class="form-group col-md-3">
		<label>Manual Entry: </label>
		<input type="text" class="form-control" size="19" value="" id='cartonid2' name="cartonid2">
		</div>
		<input type="submit" name="check2" value="Check In" onclick='return check_docket(event)' class="btn btn-primary" style="margin-top:22px;">
		<input type="hidden" name="location" value="<?php echo $location; ?>">
		<input type="hidden" name="check" value="check">
		</div>
		</form>
		
		<?php

		//Normal Process
		if(isset($_POST['cartonid']) or isset($_POST['check']))
		{
			
			$code=$_POST['cartonid'];
			$location=$_POST['location'];

			if(is_numeric(substr($code,0,1)))
			{
				$sql="select * from $bai_rm_pj1.location_db where location_id=\"$location\" and sno>0";
				echo "<br/>".$sql."<br/>";
				$sql_result=mysqli_query($link, $sql);
				if(mysqli_num_rows($sql_result)>0)
				{
					$code=ltrim($code,"0");
					$sql1="update $bai_rm_pj1.store_in set ref1=\"$location\", status=0, allotment_status=0 where tid=\"$code\"";
					//echo "<br/>".$sql1."<br/>";
					$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_affected_rows($link)>0)
					{
						echo "<h2>Status: <span class='label label-success'>Success!</span> $code</h2>";
						echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"?r=".$_GET['r']."&location=$location\"; }</script>";
					}else{
						echo "<h2>Status: <span class='label label-warning'>Failed (or) already updated</span> $code</h2>";
						//echo "<button id='back' onclick='back()' class='btn btn-warning'><< Go back</button>";
						echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"".getFullURL($_GET['r'],'index.php','N')."&location=$location&code=$code\"; }</script>";
						
					}
					
				}
				else
				{
					echo "<h2>Status: <span class='label label-danger'>Scan Location!</span></h2>";
				}
			}
			else
			{
				
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"?r=".$_GET['r']."&location=$code\"; }</script>";
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
						echo "<h2>Status  : <span class='label label-success'>Success!</span> $code</h2>";
						echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"?r=".$_GET['r']."&location=$location\"; }</script>";
					}
					else
					{
						echo "<h2>Status  : <span class='label label-warning'>Failed (or) already updated</span> $code</h2>";
						// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"".getFullURL($_GET['r'],'return.php','N')."&location=$location&code=$code\"; }</script>";
						echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"".getFullURL($_GET['r'],'index.php','N')."&location=$location&code=$code\"; }</script>";
					}
					
				}
				else
				{
					echo "<h2>Status  : <span class='label label-danger'>Scan Location!</span></h2>";
				}
			}
			else
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = '". getFullURL($_GET['r'],'index.php','N')."&location=".$code."'; }</script>";
			}
		}

		//echo "<div class='pull-right text-right'><div ><h2><font color=\"green\">In</font></h2><br/><h2><a href='".getFullURL($_GET['r'],'index.php','N')."'><button class='btn btn-primary'>In</button></a> <Br/><a href='".getFullURL($_GET['r'],'out.php','N')."'><button class='btn btn-primary'>F-Out</button></a><Br/><a href='".getFullURL($_GET['r'],'out_trims.php','N')."'><button class='btn btn-primary'>T-Out</button></a> </h2></div></div>";
	
		?>
	</div>
</div>
</body>

</div>

<style>
	.equal{
		width : 80px;
		text-align:center;
	}
</style>



<html>
<head>
<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/user_acl_v1.php");
 ?>
<script>

function focus_box()
{
	document.input.cartonid.focus();
}
</script>
<style>
body
{
	font-family:arial;
}

</style>
<?php 
// echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; 
?>
</head>
<body onload="focus_box()">
<!-- <div id="page_heading"><span style="float: left"><h3>Online Barcode Scanning </h3></span></div> -->

<?php


if(isset($_GET['location']))
{
	$location=$_GET['location'];
	$sql="select * from $bai_rm_pj1.location_db where location_id=\"$location\" and sno>0  and status=1";
	$sql_result=mysqli_query($link, $sql);
	if(mysqli_num_rows($sql_result)>0)
	{
		echo "<h3>Location: <font color=green>$location</font></h3>";
	}
	else
	{
		echo "<h3>Location: <font color=red>Unknown Scan Location!</font></h3>";
		$location="";
	}
	
	// die();
}
else
{
	echo "<h3>Location: <font color=red>Scan Location!</font></h3>";
	$location="";
}


?>

<!-- <h2><font color="green">IN</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo "<a href=\"in_trims_new.php\">In</a>   |   <a href=\"out.php\">Out</a></h2>"; ?> -->
<form name="input" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form data">
<!-- <input type="text" value="" name="cartonid"> -->
<textarea name="cartonid" id='cartonid' rows="2" cols="15" onkeydown="document.input.submit();" value=""></textarea>
<br/>Enter Lable ID:<br/><input type="text" size="19" value="" name="cartonid2"><br/><input type="submit" name="check2" value="Check In">
<input type="hidden" name="location" value="<?php echo $location; ?>">
<input type="hidden" name="check4" value="check">
</form>

<?php

//Normal Process
if(isset($_POST['cartonid']) && $_POST['cartonid']!='')
{
	$code=$_POST['cartonid'];
	$location=$_POST['location'];
	//echo "Location :".$code;
	//if(is_numeric(substr($code,0,1)))
		$sql="select * from $bai_rm_pj1.location_db where location_id=\"$code\" and sno>0";
		$sql_result=mysqli_query($link,$sql) or exit("Sql Error3".mysqli_error());
		if(mysqli_num_rows($sql_result)<=0)
		{
			//$code=ltrim($code,"0");
			$sql1="update $bai_rm_pj1.store_in set ref1=\"$location\", status=0, allotment_status=0 where barcode_number=\"$code\"";
			//echo $sql1;
			$sql_result1=mysqli_query($link,$sql1);
			if(mysqli_affected_rows($link)>0)
			{
				echo "<h3>Status: <font color=green>Success!</font> $code</h3>";
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"in_trims_new.php?location=$location\"; }</script>";
			}
			else
			{
				echo "<h3>Status: <font color=orange>Failed (or) already updated</font> $code</h3>";
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"in_trims_new.php?location=$location\"; }</script>";
				
			}
			
		}
		else
		{
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"in_trims_new.php?location=$code\"; }</script>";
		}
	
}

//Manual Lable Entry
if(isset($_POST['check2']))
{
	$code=$_POST['cartonid2'];
	$location=$_POST['location'];
	$qry_validateloc="select * from $bai_rm_pj1.location_db where location_id=\"$code\" and sno>0";
	$qry_validateloc=mysqli_query($link, $qry_validateloc);
	if(mysqli_num_rows($qry_validateloc)<=0)
	{
				$sql="select * from $bai_rm_pj1.location_db where location_id=\"$location\" and sno>0";
				//echo "<br/>".$sql."<br/>";
				$sql_result=mysqli_query($link, $sql);
				if(mysqli_num_rows($sql_result)>0)
				{
					$code=ltrim($code,"0");
					$sql1="update $bai_rm_pj1.store_in set ref1=\"$location\", status=0, allotment_status=0 where barcode_number=\"$code\"";
					
					$sql_result1=mysqli_query($link, $sql1);
					if(mysqli_affected_rows($link)>0)
					{
						echo "<h3>Status: <font color=green>Success!</font> $code</h3>";
						echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",2000); function Redirect() {  location.href = \"in_trims_new.php?location=$location\"; }</script>";
					}else{
						$sql1="select * from $bai_rm_pj1.store_in_deleted where barcode_number=\"$code\"";
						$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						if(mysqli_num_rows($sql_result1)>0)
						{
						echo "<h3>Status  : $code-<span class='label label-warning'>Label Deleted</span> </h3>";

						}
						else
						{
							$sql2="select * from $bai_rm_pj1.store_in where barcode_number=\"$code\"";
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
						echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"in_trims_new.php?location=$location&code=$code\"; }</script>";
						
					}
					
				}
				else
				{
					echo "<h3>Status: <span class='label label-danger'>Scan Location!</span></h3>";
				}
	}
	else
	{
		echo "<h3>Status  :$code- <span class='label label-warning'>Label Not Found</span> </h3>";
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",2000); function Redirect() {  location.href = \"in_trims_new.php?location=$code\"; }</script>";
	}
}

echo "<div style=\"position: absolute; top:0px;right:5px; text-align:right;\"><h2><!--<font color=\"gree\">In</font></h2>--><br/><h2><a href=\"in_trims_new.php\">In</a> <Br/><a href=\"out_trims_scanner.php\">T-Out</a> </h2></div>";

?>

</body>
</html>







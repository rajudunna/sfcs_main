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

//gettinh location here
if(isset($_GET['location']))
{
	$location=$_GET['location'];
	$result_status=$_GET['status'];
	if($result_status<4)
	{		
		echo "<h3>Location: <font color=green>$location</font></h3>";
		$code=$_GET['code'];
		if($code){
			echo "<h3>Previous Scanned Barcode:<font color=green>- ".$code."</font></h3>";
		}
		switch($result_status){
			case "0":
				echo "<h3>Previous Scanned Status :<font color=orange>- Already Scanned</font></h3>";
				break;
			case "1":
				echo "<h3>Previous Scanned Status :<font color=green>- Successful</font></h3>";
				break;
			case "2":
				echo "<h3>Previous Scanned Status :<font color=red>- UnSuccessful</font></h3>";
				break;
			default :
			    echo "<h3>Previous Scanned Status :<font color=red>- Barcode Invalid</font></h3>";
			
		}
		//var_dump($_GET);
	}
	else
	{
		if($result_status==4)
		{
			echo "<h3>Location: <font color=green>$location</font></h3>";
		}
		else
		{
			echo "<h3>Location: <font color=red>Unknown Scan Location!</font></h3>";
			$location="";
		}			
	}
}

?>

<!-- <h2><font color="green">IN</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo "<a href=\"in_trims_new.php\">In</a>   |   <a href=\"out.php\">Out</a></h2>"; ?> -->
<form name="input" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form data">
<!-- <input type="text" value="" name="cartonid"> -->
<textarea name="cartonid" id='cartonid' rows="2" cols="15" onkeydown="document.input.submit();" value=""></textarea>
<br/>Enter Barcode:<br/>
<input type="text" size="19" value="" name="cartonid2" placeholder="manual entry..">
<input type="submit" name="check2" value="Scan" >

<input type="hidden" name="barcode" value="<?php echo $code; ?>">
<input type="hidden" name="location" value="<?php echo $location; ?>">
<input type="hidden" name="status" value="<?php echo $status; ?>">
<input type="hidden" name="check4" value="check">
</form>

<?php

//Normal Process
if(isset($_POST['cartonid']) && $_POST['cartonid']!='')
{
	$code=$_POST['cartonid'];
	$location=$_POST['location'];
	if($location=='')
	{
		$location=$code;
		$sql="select * from $bai_rm_pj1.location_db where location_id=\"$location\" and sno>0";
		$sql_result=mysqli_query($link, $sql);
		if(mysqli_num_rows($sql_result)>0)
		{
			$status=4;
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",70); function Redirect() {  location.href = \"in_trims_new.php?location=$location&status=$status\"; }</script>";

		}
		else
		{
			$status=5;
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",70); function Redirect() {  location.href = \"in_trims_new.php?location=$location&&status=$status\"; }</script>";
		}	
	}
	else
	{	
		$sql12="select * from $bai_rm_pj1.location_db where location_id='".$code."' and status=1";
		$sql_result12=mysqli_query($link, $sql12);
		if(mysqli_num_rows($sql_result12))
		{
			$status=4;
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",70); function Redirect() {  location.href = \"in_trims_new.php?location=$code&status=$status\"; }</script>";
		}
		else
		{	
			$sql="select * from $bai_rm_pj1.location_db where location_id=\"$location\"  and status=1";
			$sql_result=mysqli_query($link, $sql);
			$sql2="select * from $bai_rm_pj1.store_in where barcode_number=\"$code\"";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));				
			if(mysqli_num_rows($sql_result)>0 && mysqli_num_rows($sql_result2)>0)
			{ 
				while($row=mysqli_fetch_array($sql_result2))
				{
					$existing_location=$row['ref1'];
				}
				// $code=ltrim($code,"0");
				if($location==$existing_location)
				{
					$status=0;
				}
				else
				{
					$sql1="update $bai_rm_pj1.store_in set ref1=\"$location\" where barcode_number=\"$code\"";
					$sql_result1=mysqli_query($link, $sql1);					
					if(mysqli_affected_rows($link)>0)
					{
						$status=1;
					} 
					else 
					{
						$status=2;
					}
				}				
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",70); function Redirect() {  location.href = \"in_trims_new.php?location=$location&code=$code&status=$status\"; }</script>";			
			}
			else
			{
				$status=3;
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",70); function Redirect() {  location.href = \"in_trims_new.php?location=$location&code=$code&status=$status\"; }</script>";
			}
		}
	}	
}
//Manual Lable Entry
if(isset($_POST['check2']))
{
	$code=$_POST['cartonid2'];
	$location=$_POST['location'];
	if($location=='')
	{
		$location=$code;
		$sql="select * from $bai_rm_pj1.location_db where location_id=\"$location\" and status=1";
		$sql_result=mysqli_query($link, $sql);
		if(mysqli_num_rows($sql_result)>0)
		{
			$status=4;
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",100); function Redirect() {  location.href = \"in_trims_new.php?location=$location&status=$status\"; }</script>";

		}
		else
		{
			$status=5;
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",100); function Redirect() {  location.href = \"in_trims_new.php?location=$location&&status=$status\"; }</script>";
		}	
	}
	else
	{		
		$sql12="select * from $bai_rm_pj1.location_db where location_id='".$code."' and status=1";
		$sql_result12=mysqli_query($link, $sql12);
		if(mysqli_num_rows($sql_result12))
		{
			$status=4;
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",70); function Redirect() {  location.href = \"in_trims_new.php?location=$code&status=$status\"; }</script>";
		}
		else
		{		
			$sql="select * from $bai_rm_pj1.location_db where location_id=\"$location\" and status=1";
			$sql_result=mysqli_query($link, $sql);
			$sql2="select * from $bai_rm_pj1.store_in where barcode_number=\"$code\"";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(mysqli_num_rows($sql_result)>0 && mysqli_num_rows($sql_result2)>0)
			{ 
				while($row=mysqli_fetch_array($sql_result2))
				{
					$existing_location=$row['ref1'];
				}
				// $code=ltrim($code,"0");
				if($location==$existing_location)
				{
					$status=0;
				}
				else
				{
					$sql1="update $bai_rm_pj1.store_in set ref1=\"$location\" where barcode_number=\"$code\"";
					$sql_result1=mysqli_query($link, $sql1);				
					if(mysqli_affected_rows($link)>0)
					{
						$status=1;
					} 
					else 
					{
						$status=2;
					}
				}				
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",70); function Redirect() {  location.href = \"in_trims_new.php?location=$location&code=$code&status=$status\"; }</script>";		
			}
			else
			{
				$status=3;
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",70); function Redirect() {  location.href = \"in_trims_new.php?location=$location&code=$code&status=$status\"; }</script>";
			}
		}
	}
}

?>

</body>
</html>







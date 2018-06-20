<?php 
// $username = "sfcsproject1";
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
// include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/user_acl_v1.php");
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php"); 
// $view_access=user_acl("SFCS_0128",$username,1,$group_id_sfcs);
?>
<html>
<head>				 
<script language="javascript" type="text/javascript" src='<?php echo getFullURLLevel($_GET['r'], "common/js/dropdowntabs.js", 3, "R"); ?>'></script>

<script type="text/javascript">
function check_sch()
{
	var sch=document.getElementById('file').value;
	if(sch=='')
	{
		sweetAlert('Please Enter Correct File','','warning')
		return false;

	}
	return true;
} 	


</script>


<!-- <link rel="stylesheet" href='<?php echo getFullURLLevel($_GET['r'], "common/css/ddcolortabs.css", 3, "R"); ?>' type="text/css" media="all" /> -->

<!-- <link rel="stylesheet" href='<?php echo getFullURLLevel($_GET['r'], "common/css/table_style.css", 3, "R"); ?>' type="text/css" media="all" /> -->
<!-- <link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',3,'R'); ?>" rel="stylesheet" type="text/css" /> -->
</head>
<body>
<?php 
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/db_hosts.php");
 ?>

<?php 
error_reporting(E_ALL ^ E_NOTICE);
?>

<?php 
if(!isset($_SESSION)) { session_start(); }
?>
<div class = "panel panel-primary">
<div class = "panel-heading">Visionair Fastreact Plan Update</div>
<div class = "panel-body">

<form name="upload" enctype="multipart/form-data" method="POST" action="index.php?r=<?= $_GET['r']; ?>"> 
<div class="row">
<div class="col-sm-3">
<label>Choose File Location: </label>
<input type="file" name="file" size="25" id="file" value="" accept=".txt" class="form-control" required><br>
<label class="label label-danger">Note :</label>&nbsp;<label class="label label-primary">Upload only .txt format files.</label>
</div>

<div class="col-sm-3">
<input type="submit" name="upload" value="Upload" class="btn btn-primary" style="margin-top: 22px;"> 
</div>
</div>
</form> 
<?php
if(isset($_POST['upload'])) 
{ 
			// 	$yourdomain = 'localhost'; 
			// $uploaddir = ''; 
			
			$fname = $_FILES["file"]["name"];			
			$ext = end((explode(".", $fname))); # extra () to prevent notice

			//echo $ext;
			if ($ext!='txt') {
				echo "<script>sweetAlert('Please Enter Correct File','','warning') </script>";
			} else {
				

			$chk_ext1 = explode(".",$fname);
			$filename = $_FILES['file']['name']; 
			$filesize = $_FILES['file']['size']; 
			$tmpname_file = $_FILES['file']['tmp_name']; 	
			
			if($filesize > '5000000') 
			{ 
				echo "Way too big!!"; 
			} 
			else 
			{ 
				$new_filename=$chk_ext1[0].".".$chk_ext1[1];
				$path_new="../".getFullURL($_GET['r'],"weekly_delivery_plan/$new_filename","R");
				
				move_uploaded_file($_FILES["file"]["tmp_name"],$path_new);

				echo "<div class='alert alert-success'>File Upload is Successful.</div>";
				echo $filename;
?>
				
				<form name="update" method="POST" action="<?php echo getFullURLLevel($_GET['r'], "dbupdate.php", 0,"N"); ?>"> 
				File ID: <input type="text" name="id" size="25" value='<?=$filename; ?>'>
				<input type="submit" name="update" value="Update" class="btn btn-primary"> 
				</form>
<?php
			}
}	



}

?>
</div>
</div>
</body>
</html>
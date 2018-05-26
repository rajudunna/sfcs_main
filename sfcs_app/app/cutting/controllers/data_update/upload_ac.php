<!--
Code Module:M3 to SFS data upload

Description:uploading the order details or shipment plan details.

Changes Log:
-->
<?php 
// echo getFullURLLevel($_GET['r'],'/styles/sfcs_styles.css',4,'N');

// include('../'.getFullURLLevel($_GET['r'],'/common/config/user_acl_v1.php',4,'R'));
// include('../'.getFullURLLevel($_GET['r'],'/common/config/group_def.php',4,'R')); 
// $view_access=user_acl("SFCS_0090",$username,1,$group_id_sfcs); 
?>

<style>
/* body{
	font-family: "calibri";
} */

</style>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',4,'R');?>"></script>
<body>
<!--<div id="page_heading"><span style="float: left"><h3>Data Upload</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>-->
<?php 
include('../'.getFullURLLevel($_GET['r'],'/common/config/config.php',4,'R'));
//echo getFullURLLevel($_GET['r'],'/common/config/config.php',4,'R');
include("../".getFullURLLevel($_GET['r'],'/common/config/menu_content.php',4,'R')); ?>

<?php 
error_reporting(E_ALL ^ E_NOTICE);
?>

<?php 
if(!isset($_SESSION)) { session_start(); }

if(!isset($_POST['upload'])) { 
echo ' <form name="upload" enctype="multipart/form-data" method="POST" action="index.php?r='.$_GET['r'].'"> 
<div class="panel panel-primary" style="height:150px;">
	<div class="panel-heading">Data Upload</div>
	<div class="panel-body">
			<div class="row">
				<div class="col-sm-3" style="padding-left: 35px;">
					<br/>
					<label>Choose File Location:</label> <input type="file" class="form-control-file" name="file" size="25" value="" required></input>
				</div>
				<div class="col-sm-3">
					<br/><br/>
					<input type="submit" class="btn btn-primary" name="upload" value="Upload"> 
				</div>
			</div>
		</div>
	</div>
</div>
</form> '; 
} 
else { 

$yourdomain = 'localhost'; 
$uploaddir = ''; 
$filename = $_FILES['file']['name']; 
$filesize = $_FILES['file']['size']; 
$tmpname_file = $_FILES['file']['tmp_name']; 
if($filesize > '500000000') { 
echo "Way too big!!"; 
} 
else { 
move_uploaded_file($tmpname_file, "$uploaddir$filename"); 

echo "<div class='alert alert-info alert-dismissible'>
<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
<strong>File Uploaded is Successful.</strong></div>"; 
echo ' <form name="update" method="POST" action="'.getFullURL($_GET["r"],"dbupdate.php","N").'"> 
<div class="panel panel-primary" style="height:150px;">
	<div class="panel-heading">Data Upload</div>
		<div class="panel-body">
			<dv class="row">
				<div class="col-sm-3" style="padding-left: 35px;">
					<label><strong>File ID:</strong></label> <input type="text" class="form-control" name="id" size="25" value='.$filename.'>
				</div>
				<div class="col-sm-3">
					<br/>
					<input type="submit" class="btn btn-primary" name="update" value="Update"> 
				</div>
			</div>
		</div>
	</div>
</div>
</form> '; 

}
} 



?>
</body>
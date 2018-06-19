
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));

$view_access=user_acl("SFCS_0236",$username,1,$group_id_sfcs); //view
$view_access=user_acl("SFCS_0236",$username,3,$group_id_sfcs);  //upload

?>
<html>
<head>
<!-- <style>
body{
	font-family: "calibri";
}
</style> -->

<link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',3,'R'); ?>" rel="stylesheet" type="text/css" />
</head>
<body>
<!-- <div id="page_heading"><span style="float"><h3>Free Plan Data Upload</h3></span><span style="float: right; margin-top: -20px"><b>?</b>&nbsp;</span></div> -->
<?php  ?>
<div class="panel panel-primary">
<div class="panel-heading">
<h5 class="panel-title pull-right"><a href="<?= getFullURLLevel($_GET['r'],'template.csv',0,'R'); ?>" title="Download Upload File Template"><i class="glyphicon glyphicon-download-alt"></i></a></h5>
Free Plan Data Upload</div>
<div class="panel-body">
<?php 
error_reporting(E_ALL ^ E_NOTICE);
$sql="select max(yer_mon) as yer_mon from $bai_pro.tbl_freez_plan_track where track_status<>0";

$sql_result=mysqli_query($link, $sql);
while($sql_row=mysqli_fetch_array($sql_result))
{	
	$date=$sql_row['yer_mon'];
}
//echo $date."<br>";
if($date=='')
{
	$date=date("Y-m-d");
	echo "<div class='row'><div class='col-sm-12'><div class='alert alert-info'>You are going to upload Freez Plan for: ".date('Y-M', strtotime('+1 month', strtotime($date)))."</div></div>";	
}
else
{
	echo "<div class='row'><div class='col-sm-12'><div class='alert alert-info'><font style='color:white'><strong>Info!</strong>      You are going to upload Freez Plan for: ".date('Y-M', strtotime('+1 month', strtotime($date)))."</font></div></div>";	
}

echo '</div><hr>';


	
?>

<?php 
if(!isset($_SESSION)) { session_start(); }

if(!isset($_POST['upload'])) { 
echo ' <form name="upload" enctype="multipart/form-data" method="POST" action="index.php?r='.$_GET['r'].'"> 
<div class="row">
<div class="col-sm-4">
<label>Choose File: </label> <input type="file" name="file" class="form-control" size="25" value="" accept=".csv" required> (Only CSV files and file name without spaces. Example: Plan_2016_Nov.csv)
</div></br><div class="col-sm-4"><input type="submit" class="btn btn-primary" name="upload" value="Upload" ';
echo " id=\"add\" onclick=\"hide()\"";
echo ' > </div></div>
</form> '; 
} 
else { 

// $yourdomain = 'localhost'; 
// echo getFullURL($_GET['r'],'dbupdate.php','R');
$action_var = getFullURL($_GET['r'],'dbupdate.php','N');

$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'uploads',0,'R'); 
$filename = $_FILES['file']['name']; 
$filesize = $_FILES['file']['size']; 

$file_ext = pathinfo($filename, PATHINFO_EXTENSION);
// echo $file_ext;
// die();
if($file_ext == 'csv'){
	
$tmpname_file = $_FILES['file']['tmp_name']; 
if($filesize > '500000000') { 
echo "Way too big!!"; 
} 
else { 
move_uploaded_file($tmpname_file, "$uploaddir/$filename"); 

if(strlen($filename)>0)
{
	echo "<br/>File Upload is Successful.<br />"; 
	$redirect = explode('?r=',$action_var);
	echo ' <form name="update" method="GET" action="index.php"> 
	<input type="hidden" name="r" value='.$redirect[1].'>
	<div class="row"><div class="col-sm-3"><label>Process File ID: </label><input type="text" class="form-control" name="id" size="25" value='.$filename.' id="ile">
	<input type="hidden" name="date" value="'.date('Y-m-d', strtotime('+1 month', strtotime($date))).'">
	<input type="submit" name="update" class="btn btn-primary" value="Update" id="add" onclick="hide()">';	
	echo '> </div></div>
	</form> ';
}
else
{
	echo '<scirpt>sweetAlert("no file to process","","info")</script>';
}
 

}


echo '<span id="msg" style="display:none;"><h2>Please Wait...</h2></span>';

}else{
	echo "<script>sweetAlert('Uploaded File should be in CSV format');</script>";
}
}

?>
</div></div>
</body>
</html>

<script>
    function hide(){
        if(document.getElementById('file').value == NULL){
                
        }else{
            document.getElementById('add').display = 'none';
        }
    }
</script>


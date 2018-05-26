<?php
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
$view_access=user_acl("SFCS_0291",$username,1,$group_id_sfcs);
?>
<form action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">
<br>

 <?php
 
	echo "<input type=\"submit\" value=\"Session Restore\" class=\"btn btn-primary\" name=\"submit\" onclick=\"document.getElementById('submit').style.display='none'; document.getElementById('msg').style.display='';\"/>";
	echo "<span id=\"msg\" style=\"display:none;\"><h5>Please Wait...<h5></span>";

?>


</form>
<?php
if(isset($_POST['submit']))
{
	$data_sym="$";
	$File = "session_track.php";
	$fh = fopen($File, 'w') or die("can't open file");
	$stringData = "<?php ".$data_sym."status=\"\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
	echo "<script>swal('Session Restored successfully','','success');</script>";
}
?>
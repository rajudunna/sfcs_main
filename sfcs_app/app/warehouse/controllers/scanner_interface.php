<?php
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
?>
<html>
<form name="input" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="plantcode" id="plantcode" value="<?php echo $plantcode; ?>">
<input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
<input type="submit" name="submit" value="Click Here to go Scanning Screen" id="submit" class="btn btn-success">
</form>
</html>

<?php
if(isset($_POST['submit']))
{
	$plant_code=$_POST['plantcode'];
	$user_name=$_POST['username'];
	$url="/sfcs_app/app/warehouse/controllers/in_trims_new.php?plantcode=".$plant_code."&username=".$user_name;
	echo "<script>
	window.open('$url', '_blank');
	</script>";
}
?>
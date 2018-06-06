<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	 $style_id=$_GET['style_id']; 
	 $mod_count=$_GET['mod_count'];
?>

<script>
function verify(e){
	var k = e.which;
	if(isNaN($('#mod_count').val()) || k == 69 ){
		sweetAlert('Only Numerics are allowed','','warning');
		$('#mod_count').val('');
	}
}
</script>
<script>
function check_mod()
{

var mod=document.getElementById('mod_count').value;
if(mod=='')
{
sweetAlert('Please Enter Module','','warning');
return false;
}
else
{
return true;
}

}
</script>

<script type="text/javascript">

function enableButton() 
{
	if(document.getElementById('option').checked)
	{
		document.getElementById('update').disabled='';
	} 
	else 
	{
		document.getElementById('update').disabled='true';
	}
}

jQuery(document).ready(function($){
   $('#mod_count').keypress(function (e) {
       var regex = new RegExp("^[0-9a-zA-Z\]+$");
       var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
       if (regex.test(str)) {
           return true;
       }
       e.preventDefault();
       return false;
   });
});


</script>

<script type="text/javascript">
function pop_check(){
var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";

for (var i = 0; i < document.input2.lot_no.value.length; i++) {
   if (iChars.indexOf(document.input2.lot_no.value.charAt(i)) != -1) {
      sweetAlert('Please Enter Valid Batch Number','','warning')
       return false;
   }

}
}
</script>


<!--
<link href="<?= getFullURLLevel($_GET['r'],'common/css/style2.css',3,'R'); ?>" rel="stylesheet" type="text/css" />-->
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/check2.js',1,'R'); ?>"></script>
<!--<link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_style.css',3,'R'); ?>" rel="stylesheet" type="text/css" /> -->
<br/>

<div class="panel panel-primary">
<div class="panel-heading">Master Entry Form</div>
<div class="panel-body">

<form method="post" name="input" enctype="multipart/form-data" action="index.php?r=<?= $_GET['r']; ?>" >
	<table class="table table-bordered">
		<tr><td style="background-color: #EEE;"><b>User Define Style</b></td><td style="background-color: #EEE;">:</td><td style="background-color: #EEE;"> <?php echo $style_id; ?></td></tr>
		<tr><td style="background-color: #EEE;"><b>Module Count</b></td><td style="background-color: #EEE;">:</td><td style="background-color: #EEE;"><input type="text" class="integer" onkeyup='verify(event)' style="border:1px solid #999999;" id='mod_count' name="mod_count" size="8" value="<?php echo $mod_count; ?>"></td></tr>
		<tr><td style="background-color: #EEE;"><input type="checkbox" name="option"  id="option" onclick="enableButton();">Enable</td><td style="background-color: #EEE;"></td><td style="background-color: #EEE;">
		<input type = "Submit" class="btn btn-success" Name = "update" id ="update" onclick ="return check_mod()"  VALUE = "Update" disabled></td></tr>
		<input type="hidden" name="style_id" value="<?php echo $style_id; ?>">
	</table>
</form>


<?php

if(isset($_POST['update']))
{

$style_id=$_POST['style_id'];
$mod_count=$_POST['mod_count'];

$sql= "update $bai_pro2.movex_styles set mod_count=$mod_count where style_id=\"$style_id\"";

mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	$sql="select * from $bai_pro2.shipment_plan where style_id is NULL";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$style_no=$sql_row['style_no'];
		$tid=$sql_row['tid'];
		$sql2="update $bai_pro2.shipment_plan set style_id=(select style_id from movex_styles where movex_style=\"$style_no\") where tid=$tid";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}	
	
	
	$sql="select * from $bai_pro2.shipment_plan_summ where style_id is NULL";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$ssc_code=$sql_row['ssc_code'];
		$style_no=$sql_row['style_no'];
		$sql2="update $bai_pro2.shipment_plan_summ set style_id=(select style_id from movex_styles where movex_style=\"$style_no\") where ssc_code=\"$ssc_code\"";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	$sql="select * from $bai_pro2.style_status_summ where style_id is NULL";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$ssc_code=$sql_row['ssc_code'];
		$style_no=$sql_row['style'];
		$sql2="update $bai_pro2.style_status_summ set style_id=(select style_id from movex_styles where movex_style=\"$style_no\") where ssc_code=\"$ssc_code\"";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
$url=getFullURL($_GET['r'],'module_count.php','N');
echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url\"; }</script>";

}

?>

</div>
</div>
</div>

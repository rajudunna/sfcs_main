<?php

//Date: 2013-12-12; Ticket#100152; TO iddntify the buyer codes of styles.

?>
<?php 
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
 $style=$_GET['style']; 
	  $buyer_id=$_GET['buyer_id'];
	$sql="select * from $bai_pro2.movex_styles where movex_style=\"$style\"";
	// echo $sql."1<br>";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$style_id=$sql_row['style_id'];
	}
	
?>




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





</script>

<script type="text/javascript">
function pop_check(){
var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";

for (var i = 0; i < document.input.lot_no.value.length; i++) {
   if (iChars.indexOf(document.input.lot_no.value.charAt(i)) != -1) {
      sweetAlert('Please Enter Valid User Define Style','','warning')
       return false;
   }

}
}
</script>



<!-- <link href="<?= getFullURL($_GET['r'],'style2.css','R'); ?>" rel="stylesheet" type="text/css" /> -->
<!-- <script type="text/javascript" src="<?= getFullURL($_GET['r'],'check2.js','R'); ?>"></script> -->
<!-- <?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?> -->
<body  onload="javascript:dodisable()">
<br/>
<div class="panel panel-primary">
<div class="panel-heading">Master Edit Form</div>
<div class="panel-body">

<form  method="post" name="input"  action="index.php?r=<?= $_GET['r']; ?>">
<table class="table table-bordered">
<tr><td><b>Movex Style</b></td><td>:</td><td><?php echo $style; ?></td></tr>
<tr>
<td><b>User Define Style</b></td>
<td>:</td>
<td> <input type="text" name="style_id" size="20" class="alpha" value="<?php echo $style_id; ?>" id='userdefinedstyle'></td>
</tr>
<!--Added select criteria for buyer idetity of movex style updatig-->
<!-- <tr><td>Buyer Style</td><td>:</td><td>
	<select name="bsty" id="bsty">
		<option value="0" <?php if($buyer_id=="Select") echo "selected"; ?>>Select</option>
		<option value="VS Logo" <?php if($buyer_id=="VS Logo") echo "selected"; ?>>VS Logo</option>
		<option value="VS Pink" <?php if($buyer_id=="VS Pink") echo "selected"; ?>>VS Pink</option>
		<option value="Glamour" <?php if($buyer_id=="Glamour") echo "selected"; ?>>Glamour</option>
		<option value="LBI" <?php if($buyer_id=="LBI") echo "selected"; ?>>LBI</option>
		<option value="MS-T14" <?php if($buyer_id=="MS-T14") echo "selected"; ?>>MS-T14</option>
		<option value="MS-T61" <?php if($buyer_id=="MS-T61") echo "selected"; ?>>MS-T61</option>
	</select>
</td></tr> -->
<?php
$sql="SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$buyer_code[]=$sql_row["buyer_div"];
	$buyer_name[]=$sql_row["buyer_name"];
}

?>
			
<tr><td>Buyer Style</td><td>:</td><td>
	<select name="bsty" id="bsty">
	<option value="0" <?php if($buyer_id=="Select") echo "selected"; ?>>Select</option>

<?php
	for($i=0;$i<sizeof($buyer_code);$i++)
	{
		if($buyer_code[$i]==$buyer_id) 
		{ 
			echo "<option value=\"".($buyer_code[$i])."\" selected>".$buyer_code[$i]."</option>";	
		}
		else
		{
			echo "<option value=\"".($buyer_code[$i])."\"  >".$buyer_code[$i]."</option>";			
		}
	}
?>
</select>
</td></tr>
<tr><td><input type="checkbox" name="option"  id="option" onclick="enableButton();">Enable</td><td></td>
<td>
<INPUT type = "Submit" Name = "update" id = "update" class="btn btn-success" VALUE = "Update" disabled ></td></tr>
<tr><input type="hidden" name="style" value="<?php echo $style; ?>"></tr>


</table>
</form>


<?php

if(isset($_POST['update']))
{

$style_id=$_POST['style_id'];
$style=$_POST['style'];

//Take the updated values of buyer identity of a movex_style
$buyer_id=$_POST['bsty'];


//TO IDENTIFY THE FIRST LETTER OF STYLE
// $style_letter=substr($style,0,1);

// //TO IDENTIFY THE VS PINK STYLES WITH STARTING LETTER P,K
// if($style_letter == "P" or $style_letter == "K")
// {
// 	$buyer_id="VS Pink";
// }

// //TO IDENTIFY THE VS LOGO STYLES WITH STARTING LETTER L,O
// if($style_letter == "L" or $style_letter == "O")
// {
// 	$buyer_id="VS Logo";
// }	

// //TO IDENTIFY THE GLAMOUR STYLES WITH STARTING LETTER G,U
// if($style_letter == "G" or $style_letter == "U")
// {
// 	$buyer_id="Glamour";
// }	

// //TO IDENTIFY THE LBI STYLES WITH STARTING LETTER Y
// if($style_letter == "Y")
// {
// 	$buyer_id="LBI";
// }	

// //TO IDENTIFY THE M&S STYLES WITH BUYER DIVISION IDENTIFICATION
// if($style_letter == "M")
// {
// 	//$buyer_id="M&S";
// 	$sql="select * from BAI_PRO3.bai_orders_db where order_style_no=\"".$style."\" AND order_div LIKE \"%T61%\"";
// 	echo $sql."2<br>";
// 	$result=mysqli_query($link, $sql) or mysqli_error("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
// 	//IF COUNT OF T61 STYLE > 0 STYLE CODE IS MS-T61 ELSE STYLE CODE IS MS-T14
// 	if(mysqli_num_rows($result) > 0)
// 	{
// 		$buyer_id="MS-T61";	
// 	}
// 	else
// 	{
// 		$buyer_id="MS-T14";
// 	}
// }		

$host_name=str_replace(".brandixlk.org","",gethostbyaddr($_SERVER['REMOTE_ADDR']));
$note=date("Y-m-d H:i:s")."_".$username."_".$host_name."<br/>";

$sql= "update $bai_pro2.movex_styles set style_id=\"$style_id\",buyer_id=\"$buyer_id\" where movex_style=\"$style\"";
// echo $sql."3<br>";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$note.=$sql."<br/>";

	$sql="select * from $bai_pro2.shipment_plan where style_id is NULL  OR style_no=\"$style\"";
	// echo $sql."4<br>";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$style_no=$sql_row['style_no'];
		$tid=$sql_row['tid'];
		$sql2="update $bai_pro2.shipment_plan set style_id=(select style_id from movex_styles where movex_style=\"$style_no\") where tid=$tid";
		// echo $sql2."6<br>";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}	
	
	
	$sql="select * from $bai_pro2.shipment_plan_summ where style_id is NULL OR style_no=\"$style\"";
	// echo $sql."7<br>";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$ssc_code=$sql_row['ssc_code'];
		$style_no=$sql_row['style_no'];
		$sql2="update $bai_pro2.shipment_plan_summ set style_id=(select style_id from movex_styles where movex_style=\"$style_no\") where ssc_code=\"$ssc_code\"";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	$sql="select * from $bai_pro2.style_status_summ where style_id is NULL OR style=\"$style\"";
	// echo $sql."8<br>";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$ssc_code=$sql_row['ssc_code'];
		$style_no=$sql_row['style'];
		$sql2="update $bai_pro2.style_status_summ set style_id=(select style_id from movex_styles where movex_style=\"$style_no\") where ssc_code=\"$ssc_code\"";
		// echo $sql2."9<br>";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	$sql3="update $bai_pro3.bai_orders_db set style_id=\"$style_id\" where order_style_no=\"$style\"";
	// echo $sql3."10<br>";
	mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$note.=$sql3."<br/>";
	
	//To Track All Transactions
	//Writing file
	$url2='../'.getFullURL($_GET['r'],'log','R');
	$myFile = "$url2/".date("Y_m_d")."_style_buyer_update_track.html";
	$fh = fopen($myFile, 'a') or die("can't open file");
	$stringData = $note;
	fwrite($fh, $stringData);
	//Writing file
	$url1=getFullURL($_GET['r'],'movex_styles.php','N');
echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url1\"; }</script>";

}

?>
</div>
</div>
</body>


<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
$style=$_GET['style']; ?>

<html>
<head>
<link href="<?= getFullURLLevel($_GET['r'],'common/css/style2.css',3,'R'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/check2.js',1,'R'); ?>"></script>
<?php //echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>
</head>
<body  onload="javascript:dodisable()">
<div class="panel panel-primary">
<div class="panel-heading">Master Entry Form</div>
<div class="panel-body">
<!-- <div id="page_heading"><span style="float: left"><h3>Master Entry Form</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div> -->

<form  method="post" name="input" enctype="multipart/form-data" action="index.php?r=<?= $_GET['r']; ?>">
<table class="table table-bordered">
<tr><td >Movex Style</td><td >:</td><td ><?php echo $style; ?></td></tr>
<tr><td >User Define Style</td><td >:</td><td > <input type="text" required name="style_id" id="style_id" size="7" value=""></td></tr>

<tr><td ><input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();">Enable</td><td s></td><td >
<input TYPE = "Submit"  Name = "Update" id = "update" VALUE = "Update" class="btn btn-success"></td></tr>
<input type="hidden"  name="style" value="<?php echo $style; ?>">


</table>
</form>


<?php

if(isset($_POST['Update']))
{

$style_id=$_POST['style_id'];

$style=$_POST['style'];

$sql="SELECT buyer_code FROM $bai_pro2.buyer_codes WHERE buyer_name=(SELECT DISTINCT order_div FROM bai_pro3.bai_orders_db WHERE order_style_no='$style')";
// echo $sql."<br>";
$result=mysqli_query($link, $sql) or mysqli_error("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($result))
{
	$buyer_id=$sql_row['buyer_code'];
}

	
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

// if($style_letter == "M")
// {
// 	//$buyer_id="M&S";
// 	$sql="select * from bai_pro3.bai_orders_db where order_style_no=\"".$style."\" AND order_div LIKE \"%T61%\"";
// 	// echo $sql."<br>";
// 	$result=mysqli_query($link, $sql) or mysqli_error("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
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
// echo $note."<br>";
$sql= "update $bai_pro2.movex_styles set style_id=\"$style_id\",buyer_id=\"$buyer_id\" where movex_style=\"$style\"";
// echo $sql."<br>";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$note.=$sql."<br/>";
// echo $note."<br>";

    $sql="select * from $bai_pro2.shipment_plan where style_id is NULL";
    // echo $sql."<br>";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$style_no=$sql_row['style_no'];
		$tid=$sql_row['tid'];
		$sql2="update $bai_pro2.shipment_plan set style_id=(select style_id from movex_styles where movex_style=\"$style_no\") where tid=$tid";
		// echo $sql2."<br>";

		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}	
	
	
	$sql="select * from $bai_pro2.shipment_plan_summ where style_id is NULL";
	// echo $sql."<br>";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$ssc_code=$sql_row['ssc_code'];
		$style_no=$sql_row['style_no'];
		$sql2="update $bai_pro2.shipment_plan_summ set style_id=(select style_id from movex_styles where movex_style=\"$style_no\") where ssc_code=\"$ssc_code\"";
		// echo $sql2."<br>";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}

	$sql="select * from $bai_pro2.style_status_summ where style_id is NULL";
	// echo $sql."<br>";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$ssc_code=$sql_row['ssc_code'];
		$style_no=$sql_row['style'];
		$sql2="update $bai_pro2.style_status_summ set style_id=(select style_id from movex_styles where movex_style=\"$style_no\") where ssc_code=\"$ssc_code\"";
		// echo $sql2."<br>";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	$sql3="update $bai_pro3.bai_orders_db set style_id=\"$style_id\" where order_style_no=\"$style\"";
	// echo $sql3."<br>";
	mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$note.=$sql3."<br/>";
	
	//To Track All Transactions
	//Writing file
	// $url2= getFullURLLevel($_GET['r'],'log',0,'R');
	// $myFile = "$url2/".date("Y_m_d")."_style_buyer_update_track.html";
	// $fh = fopen($myFile, 'a') or die("can't open file");
	// $stringData = $note;
	// fwrite($fh, $stringData);
	//Writing file
	
	$url1=getFullURL($_GET['r'],'movex_styles.php','N');
echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url1\"; }</script>";

}

?>

</div>
</div>
</body>



</html>


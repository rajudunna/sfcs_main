<?php
// Increase max_execution_time. If a large pdf fails, increase it even more.
ini_set('max_execution_time', 240);
// Increase this for old PHP versions (like 5.3.3). If a large pdf fails, increase it even more.
ini_set('pcre.backtrack_limit', 10000000);
	include("../../config/config.php");
	include("../../config/functions.php");
	require_once 'vendor/autoload.php';
	$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => [50, 80],'orientation' => 'L']);
?>

<?php $lot_no=$_GET['lot_no']; ?>

<?php
$html ='
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>

body {
	//font-family: arial;
	font-size: 20px;
}

tr {
	margin-left:0px;
	margin-right:0px;
	margin-top:0px;
	margin-bottom:0px;
}

td {
	overflow: hidden;
}

@page {
margin-top: 5px;
margin-bottom: 5px;
}

.barcode {  
    margin: 0;
    vertical-align: top;
	color: #000044;
	height: 0mm;
}

.barcodecell {
    text-align: center;
	vertical-align: middle;
	height:0mm;
}



</style>
</head>
<body>';
$sql="SELECT * FROM $bai_rm_pj1.location_db where status=1 order by sno ASC";

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$tot_labels=mysqli_num_rows($sql_result);
$x=1;
while($sql_row=mysqli_fetch_array($sql_result))
{	
	$html.='<table><tr><td><center><barcode code="'.$sql_row['location_id'].'" type="C39"/ class="barcode" height="2.5"></center></td></tr></table>';
	//$html.="</br></br>";
	$html.='<table style="font-size: 52px"><tr><td><b><center>'.$sql_row['location_id']."</center></b></td></tr></table>";
	$x++;
	if($tot_labels==$x){
		$html.='<pagebreak />';
	}
}

$html.='</body></html>';

// echo $html;

//==============================================================
//==============================================================

$mpdf->WriteHTML($html); 
$mpdf->Output();
//exit();
?>
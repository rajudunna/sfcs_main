<?php
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

// body {
// 	font-family: arial;
// 	font-size: 10px;
// }

table {
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
	$html.='<table><tr><td><barcode code="'.$sql_row['location_id'].'" type="C39"/ class="barcode" height="2" size="1" width="5" text="1"></td></tr>';
	$html.='<tr><td></br><center><h1>'.$sql_row['location_id']."</h1></center></td></tr></table>";
	$html.='<pagebreak />';		
}

$html.='</body></html>';

// echo $html;

//==============================================================
//==============================================================

$mpdf->WriteHTML($html); 
$mpdf->Output();
//exit();
?>
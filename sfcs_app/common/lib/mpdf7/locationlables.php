<?php
	include("../../config/config.php");
	include("../../config/functions.php");
	require_once 'vendor/autoload.php';
	$mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8', 
        'format' => [50, 80], 
        'orientation' => 'L'
]);
?>

<?php $lot_no=$_GET['lot_no']; ?>

<?php
$html ='
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;"/>
<style>

body {
	font-family: arial;
	font-size: 15px;
}

b {
	font-size:20px;
}

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
	height: 50mm;
}
.barcodecell {
    text-align: center;
	vertical-align: middle;
	height:10mm;
}


</style>
</head>
<body>';

$sql="SELECT * FROM $bai_rm_pj1.location_db where status='1' order by sno ASC";

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$tot_labels=mysqli_num_rows($sql_result);
$x=1;
while($sql_row=mysqli_fetch_array($sql_result))
{	
	$location_name=$sql_row['location_id'];
	//$location_name1="N0-525JMLK";
	$html.= '<div><table>';
				//$html.= '<tr><td><barcode code="'.str_pad($location_name,20,"0",STR_PAD_LEFT).'" type="C93"/ class="barcode" height="3" /></tr>';
				$html.= '<tr><td><barcode code="'.$location_name.'" type="C93"/ class="barcode" height="1.5" /></tr>';
				$html.= '<tr><td></td></tr>';
				$html.= '<tr><td></td></tr>';
				$html.= '<tr><td id="loca_prop"><center><b>'.$location_name.'</b></center></td></tr>';
				// $html.= "<tr><td>ITEM  NAME : <strong>$item_name</strong></td></tr>";  
				// $html.= "<tr><td>COLOR : <strong>$item_desc</strong> / Shade : <strong>$ref4</strong></td></tr>";
				// $html.= "<tr><td>PO No : <strong>$po_no</strong> / Loc # : <b>$ref1</b>  / REF NO : <strong>$remarks</strong></td></tr>";
				// $html.= "<tr><td>LOT No : <b>$lot_no </b></td></tr>";
				// $html.= "<tr><td>REC # : <strong>$rec_no </strong>/ GRN Date : <strong>$grn_date</strong>/ Qty (".$uom_ref.") : <strong>$qty_rec</strong></td></tr>";
				// $html.= "<tr><td>BATCH # : <b>$batch_no</b> / BOX # : <b>$ref2</b> </td></td></tr>";
				// $html.= "<tr><td>".'<barcode code="'.leading_zeros($tid,8).'" type="C39"/ height="0.60" size="0.90" text="1">       '."<strong>".leading_zeros($tid,8)."</strong></tr>";

	$html.= '</table></div>';

		if($x!=$tot_labels)
		{
			
		$html.='<pagebreak />';
		}
		$x++;
		
}

$html.='</body></html>';
// echo $html;

//==============================================================
//==============================================================

$mpdf->WriteHTML($html); 
$mpdf->Output();
exit();
?>
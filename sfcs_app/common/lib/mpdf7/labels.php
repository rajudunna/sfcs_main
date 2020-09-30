<?php
    // $url = getFullURLLevel($_GET['r'],'config/config.php',1,'');
    include("../../config/config.php");
    include("../../config/functions.php");
    require_once 'vendor/autoload.php';
    // echo __DIR__ . '\vendor\autoload.php';
    // die();
    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8', 
        'format' => [50, 100], 
        'orientation' => 'L'
]);
function clean($string) {
	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 }
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
    font-size: 10px;
}

b {
    font-size:15px;
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
margin-top: 3px;
margin-bottom: 3px;
margin-left: 10px;
margin-right: 10px;
}


</style>
</head>
<body>';


$sql="select product_group,item,item_name,item_desc,inv_no,po_no,rec_no,rec_qty,batch_no,buyer,pkg_no,grn_date,uom,style_no from $bai_rm_pj1.sticker_report where lot_no like \"%".trim($lot_no)."%\"";
// echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
    $product_group=$sql_row['product_group'];
    $item=$sql_row['item'];
    $item_name=str_replace("?","",utf8_decode($sql_row['item_name']));
    $item_desc=str_replace("?","",utf8_decode($sql_row['item_desc']));
	$inv_no=$sql_row['inv_no'];
	$ref_inv_no=str_replace("'","",str_replace('"','',$sql_row['inv_no']));
    $po_no=$sql_row['po_no'];
    $rec_no=$sql_row['rec_no'];
    $rec_qty=$sql_row['rec_qty'];
	$batch_no=$sql_row['batch_no'];
	$ref_batch_no=str_replace("'","",str_replace('"','',$sql_row['batch_no']));
    $buyer=$sql_row['buyer'];
    $pkg_no=$sql_row['pkg_no'];
    $grn_date=$sql_row['grn_date'];
	$uom_ref=$sql_row['uom'];
	$style_no=clean($sql_row['style_no']);
}


/*if($uom_ref=='MTR')
{
    $uom_ref='YRD';
}*/

$child_lots="";
$symbol='"';

$sql="select group_concat(right(lot_no,4) SEPARATOR \" /\") as child_lots from $bai_rm_pj1.sticker_report where REPLACE(REPLACE(batch_no,".$symbol."'".$symbol.",".$symbol."".$symbol."),'".$symbol."','')=\"".$ref_batch_no."\" and REPLACE(REPLACE(inv_no,".$symbol."'".$symbol.",".$symbol."".$symbol."),'".$symbol."','')=\"".$ref_inv_no."\" and item=\"".$item."\" and lot_no not in ('$lot_no')";
// echo $sql."<br>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
    $child_lots=$sql_row['child_lots'];
}

$sql="select * from $bai_rm_pj1.store_in where lot_no like \"%".trim($lot_no)."%\"";
//echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
$tot_labels=mysqli_num_rows($sql_result);
$x=1;
//$sql_row=mysqli_fetch_array($sql_result)
while($sql_row=mysqli_fetch_array($sql_result))
{
	$tid=$sql_row['tid'];
	$barcode_number=$sql_row['barcode_number'];
	$lot_no=$sql_row['lot_no'];
	$ref1=$sql_row['ref1'];
	$ref2=$sql_row['ref2'];
	$ref3=$sql_row['ref3'];
	$ref4=$sql_row['ref4'];
	$qty_rec=round($sql_row['qty_rec'],2);
	$qty_issued=$sql_row['qty_issued'];
	$qty_ret=$sql_row['qty_ret'];
	$date=$sql_row['date'];
	$log_user=$sql_row['log_user'];
	$remarks=$sql_row['remarks'];
	$log_stamp=$sql_row['log_stamp'];
	$sno=$sql_row['supplier_no'];
	$item_name_len = strlen($item_name);
	$item_name1 = '';
	$item_name2 ='';

	if(strlen($item_name)>=44)
	{
		$item_name1=substr($item_name,0,40)."";
		if(strlen($item_name)<=90)
		{
			$item_name2=substr($item_name,40,$item_name_len);
		}
		else
		{
			$item_name2=substr($item_name,40,50)."..,";
			
		}
	}
	else
	{
		$item_name1 = $item_name;
	}

	$html.= '<div><table>';
		switch (trim($product_group))
		{
			case "Elastic":	
			{	
				$html.= '<tr><td>ITEM CODE :<b> '.str_pad($item, 15, " ", STR_PAD_RIGHT).'</b> / Buy. : '.str_pad(substr($buyer,0,7), 6, " ", STR_PAD_RIGHT).''.'</td></tr>';
				 $html.= "<tr><td>ITEM  NAME : <strong>".str_pad($item_name1, 41, " ", STR_PAD_RIGHT)."</strong></td></tr>";  
				  if(strlen($item_desc)>30){
					$item_color=substr($item_desc, 0, 30)."..";
				}else{
					$item_color=$item_desc;
				}
				$html.= "<tr><td>COLOR : <strong>".str_pad($item_color, 21, " ", STR_PAD_RIGHT)."</strong> / <strong>Shade </strong>: <strong>$ref4</strong></td></tr>";
				//$html.= "<tr><td>PO No : <strong>$po_no</strong> / Loc # : <b>$ref1</b>  / REF NO : <strong>$remarks</strong></td></tr>";
 				$html.= "<tr><td>PO No : <strong>".str_pad($po_no, 7, " ", STR_PAD_RIGHT)."</strong>/ REF NO : <strong>$remarks</strong> / PKG # : <b>$pkg_no</b> </td></tr>";
				$html.= "<tr><td>LOT No : <b>".str_pad($lot_no, 10, " ", STR_PAD_RIGHT)."</b>/$child_lots  / Loc # : <b>".str_pad($ref1, 6, " ", STR_PAD_RIGHT)."</b> / SRoll # : <b>".$sno."</b> </td></tr>";
				//$html.= "<tr><td>REC # : <strong>$rec_no </strong>/ GRN D: <strong>$grn_date</strong> /Qty (YDS) : <strong> $qty_rec</strong></td></tr>";
				$html.= "<tr><td>REC # : <strong>".str_pad($rec_no, 11, " ", STR_PAD_RIGHT)."</strong> / GRN D: <strong>$grn_date</strong> / Qty (".$uom_ref.") : <strong> $qty_rec</strong></td></tr>";
				$html.= "<tr><td>Style :<strong>".str_pad($style_no, 7, " ", STR_PAD_RIGHT)."</strong> / BATCH # : <b>".str_pad($batch_no, 12, " ", STR_PAD_RIGHT)."</b> / BOX # : <span style='font-size: 12px;'><strong>$ref2<strong></span>   </td></td></tr>";
				$html.= "<tr><td>".'<barcode code="'.leading_zeros($barcode_number,8).'" type="C39"/ height="0.60" size="0.90" text="1">       '."<strong>".str_pad(leading_zeros($barcode_number,8), 10, " ", STR_PAD_RIGHT)."</strong></tr>";
				break;
			}	
			case "Lace":	
			{	
				$html.= '<tr><td >ITEM CODE :<b> '.str_pad($item, 15, " ", STR_PAD_RIGHT).'</b> / Buy. : '.str_pad(substr($buyer,0,7), 6, " ", STR_PAD_RIGHT).''.'</td></tr>';
				 $html.= "<tr><td>ITEM  NAME : <strong>".str_pad($item_name1, 41, " ", STR_PAD_RIGHT)."</strong></td></tr>";  
				  if(strlen($item_desc)>30){
					$item_color=substr($item_desc, 0, 30)."..";
				}else{
					$item_color=$item_desc;
				}
				$html.= "<tr><td>COLOR : <strong>".str_pad($item_color, 21, " ", STR_PAD_RIGHT)."</strong> / <strong>Shade </strong> : <strong>$ref4</strong></td></tr>";
				$html.= "<tr><td>PO No : <strong>".str_pad($po_no, 7, " ", STR_PAD_RIGHT)."</strong>  / REF NO : <strong>$remarks</strong> / PKG # : <b>$pkg_no</b> </td></tr>";
				$html.= "<tr><td>LOT No : <b>".str_pad($lot_no, 10, " ", STR_PAD_RIGHT)."</b> /  Loc # : <b>".str_pad($ref1, 6, " ", STR_PAD_RIGHT)."/ </b>/ SRoll # : <b>".$sno."</b> </td></tr>";
				$html.= "<tr><td>REC # : <strong>".str_pad($rec_no, 11, " ", STR_PAD_RIGHT)." </strong>/ GRN D: <strong>$grn_date</strong> / Qty (".$uom_ref.") : <strong> $qty_rec</strong></td></tr>";
				$html.= "<tr><td>Style :<strong>".str_pad($style_no, 7, " ", STR_PAD_RIGHT)."</strong> / BATCH # : <b>".str_pad($batch_no, 12, " ", STR_PAD_RIGHT)."</b> / BOX # : <span style='font-size: 12px;'><strong>$ref2<strong></span>  </td></td></tr>";
				$html.= "<tr><td>".'<barcode code="'.leading_zeros($barcode_number,8).'" type="C39"/ height="0.60" size="0.90" text="1">       '."<strong>".str_pad(leading_zeros($barcode_number,8), 10, " ", STR_PAD_RIGHT)."</strong></tr>";
				break;
			}	
			case "Fabric":	
			{	
				
				//changes due to #3118 conern.
				$uom_ref=strtoupper($fab_uom);
				
				$html.= '<tr><td >ITEM CODE :<b> '.str_pad($item, 15, " ", STR_PAD_RIGHT).'</b> / Buy. : '.str_pad(substr($buyer,0,7), 6, " ", STR_PAD_RIGHT).''.'</td></tr>';
				$html.= "<tr><td>ITEM  NAME : <strong>".str_pad($item_name1, 41, " ", STR_PAD_RIGHT).$item_name2."</strong></td></tr>"; 
				 if(strlen($item_desc)>30){
					$item_color=substr($item_desc, 0, 30)."..";
				}else{
					$item_color=$item_desc;
				}
				$html.= "<tr><td>COLOR : <strong>".str_pad($item_color, 21, " ", STR_PAD_RIGHT)."</strong> / <strong>Shade </strong> : <strong>$ref4</strong></td></tr>";
				//$html.= "<tr><td>PO No : <strong>$po_no</strong> / REF NO # : <strong>$remarks</strong> / PKG # : <b>$pkg_no</b> </td></tr>";
				$html.= "<tr><td>PO No : <strong>".str_pad($po_no, 7, " ", STR_PAD_RIGHT)."</strong> / REF NO # : <strong>$remarks</strong>/ PKG # : <b>$pkg_no</b>   </td></tr>";
				$html.= "<tr><td>LOT No : <b>".str_pad($lot_no, 10, " ", STR_PAD_RIGHT)."</b>/$child_lots / Loc # : <b>".str_pad($ref1, 6, " ", STR_PAD_RIGHT)."</b> / SRoll # : <b>".$sno."</b>  </td></tr>";
				$html.= "<tr><td>REC # : <strong>$rec_no </strong> / GRN D: <strong>$grn_date</strong> /Qty (".$uom_ref.") : <strong> $qty_rec</strong></td></tr>";
				//$html.= "<tr><td>REC # : <strong>$rec_no </strong> / GRN D: <strong>$grn_date</strong> /Qty ($fab_uom) : <strong> $qty_rec</strong></td></tr>";
				//$html.= "<tr><td>REC # : <strong>".str_pad($rec_no, 11, " ", STR_PAD_RIGHT)." </strong>/ Qty (".$uom_ref.") : <strong> $qty_rec</strong></td></tr>";
				$html.= "<tr><td>Style :<strong>".str_pad($style_no, 7, " ", STR_PAD_RIGHT)."</strong> / BATCH # : <b>".str_pad($batch_no, 12, " ", STR_PAD_RIGHT)."</b> / ROLL # : <span style='font-size: 12px;'><strong>$ref2<strong></span>   </td></tr>";
				$html.= "<tr><td>".'<barcode code="'.leading_zeros($barcode_number,8).'" type="C39"/ height="0.60" size="0.90" text="1">       '."<strong>".str_pad(leading_zeros($barcode_number,8), 10, " ", STR_PAD_RIGHT)."</strong></tr>";
				break;

				
			}	
			case "Thread":	
			{	
				$html.= '<tr><td >ITEM CODE :<b> '.str_pad($item, 15, " ", STR_PAD_RIGHT).'</b> / Buy. : '.str_pad(substr($buyer,0,7), 6, " ", STR_PAD_RIGHT).''.'</td></tr>';
				 $html.= "<tr><td>ITEM  NAME : <strong>".str_pad($item_name1, 41, " ", STR_PAD_RIGHT)."</strong></td></tr>";  
				  if(strlen($item_desc)>30){
					$item_color=substr($item_desc, 0, 30)."..";
				}else{
					$item_color=$item_desc;
				}
				$html.= "<tr><td>COLOR : <strong>".str_pad($item_color, 21, " ", STR_PAD_RIGHT)."</strong> / Shade : <strong>$ref4</strong></td></tr>";
				$html.= "<tr><td>PO No : <strong>".str_pad($po_no, 7, " ", STR_PAD_RIGHT)."</strong> / REF NO : <strong>$remarks</strong> / PKG # : <b>$pkg_no</b></td></tr>";
				$html.= "<tr><td>LOT No : <b>".str_pad($lot_no, 10, " ", STR_PAD_RIGHT)."</b> / Loc # : <b>".str_pad($ref1, 6, " ", STR_PAD_RIGHT)."</b> / SRoll # : <b>".$sno."</b> </td></tr>";
				$html.= "<tr><td>REC # : <strong>".str_pad($rec_no, 11, " ", STR_PAD_RIGHT)." </strong> / GRN D: <strong>$grn_date</strong>/ Qty (".$uom_ref.") : <strong>$qty_rec</strong></td></tr>";
				$html.= "<tr><td>Style :<strong>".str_pad($style_no, 7, " ", STR_PAD_RIGHT)."</strong> / BATCH # : <b>".str_pad($batch_no, 12, " ", STR_PAD_RIGHT)." </b>/ BOX # : <span style='font-size: 12px;'><strong>$ref2<strong></span>  </td></td></tr>";
				$html.= "<tr><td>".'<barcode code="'.leading_zeros($barcode_number,8).'" type="C39"/ height="0.60" size="0.90" text="1">       '."<strong>".str_pad(leading_zeros($barcode_number,8), 10, " ", STR_PAD_RIGHT)."</strong></tr>";
				break;
			}	
			default:	
			{	
				$html.= '<tr><td >ITEM CODE :<b> '.str_pad($item, 15, " ", STR_PAD_RIGHT).'</b> / Buy. : '.str_pad(substr($buyer,0,7), 6, " ", STR_PAD_RIGHT).''.'</td></tr>';
				$html.= "<tr><td>ITEM  NAME : <strong>".str_pad($item_name1, 41, " ", STR_PAD_RIGHT)."</strong></td></tr>";  
				 if(strlen($item_desc)>30){
					$item_color=substr($item_desc, 0, 30)."..";
				}else{
					$item_color=$item_desc;
				}
				$html.= "<tr><td>COLOR : <strong>".str_pad($item_color, 21, " ", STR_PAD_RIGHT)."</strong> / Shade : <strong>$ref4</strong></td></tr>";
				$html.= "<tr><td>PO No : <strong>".str_pad($po_no, 7, " ", STR_PAD_RIGHT)."</strong>  / REF NO : <strong>$remarks</strong> / PKG # : <b>$pkg_no</b> </td></tr>";
				$html.= "<tr><td>LOT No : <b>".str_pad($lot_no, 10, " ", STR_PAD_RIGHT)."</b> / Loc # : <b>".str_pad($ref1, 6, " ", STR_PAD_RIGHT)."</b> / SRoll # : <b>".$sno."</b> </td></tr>";
				$html.= "<tr><td>REC # : <strong>".str_pad($rec_no, 11, " ", STR_PAD_RIGHT)." </strong>/ GRN Date : <strong>$grn_date</strong>/ Qty (".$uom_ref.") : <strong>$qty_rec</strong></td></tr>";
				$html.= "<tr><td>Style :<strong>".str_pad($style_no, 7, " ", STR_PAD_RIGHT)."</strong> / BATCH # : <b>".str_pad($batch_no, 12, " ", STR_PAD_RIGHT)."</b> / BOX # : <span style='font-size: 12px;'><strong>$ref2<strong></span>  </td></td></tr>";
				$html.= "<tr><td>".'<barcode code="'.leading_zeros($barcode_number,8).'" type="C39"/ height="0.60" size="0.90" text="1">       '."<strong>".str_pad(leading_zeros($barcode_number,8), 10, " ", STR_PAD_RIGHT)."</strong></tr>";
				break;
			}
	
		}

		$html.= '</table></div>';

		if($x!=$tot_labels)
		{
			
		$html.='<pagebreak />';
		}
		$x++;
		
}

$html.='</body></html>';
//echo $html;

//==============================================================
//==============================================================

//include("../../mpdf7/mpdf.php");
//$mpdf= new \mPDF('',array(101.6,50.8),0,'',3,0,0,0,0,0,'P');
// echo $html;
$mpdf->WriteHTML($html); 
$mpdf->Output();


// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'mpdf.php',1,'R'));
// $mpdf=new mPDF('',array(101.6,50.8),0,'',3,0,0,0,0,0,'P');
// $mpdf->WriteHTML($html);
// $mpdf->Output(); 
// exit;

?>
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


$sql="select * from $bai_rm_pj1.sticker_report where lot_no like \"%".trim($lot_no)."%\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
    $product_group=$sql_row['product_group'];
    $item=$sql_row['item'];
    $item_name=str_replace("?","",utf8_decode($sql_row['item_name']));
    $item_desc=str_replace("?","",utf8_decode($sql_row['item_desc']));
    $inv_no=$sql_row['inv_no'];
    $po_no=$sql_row['po_no'];
    $rec_no=$sql_row['rec_no'];
    $rec_qty=$sql_row['rec_qty'];
    $batch_no=$sql_row['batch_no'];
    $buyer=$sql_row['buyer'];
    $pkg_no=$sql_row['pkg_no'];
    $grn_date=$sql_row['grn_date'];
    $uom_ref=$sql_row['uom'];
}
if($uom_ref=='MTR')
{
    $uom_ref='YRD';
}

$child_lots="";

$sql="select group_concat(right(lot_no,4) SEPARATOR \" /\") as child_lots from $bai_rm_pj1.sticker_report where batch_no=\"$batch_no\" and inv_no=\"$inv_no\" and item=\"$item\" and lot_no not in ($lot_no)";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
    $child_lots=$sql_row['child_lots'];
}

$sql="select * from $bai_rm_pj1.store_in where lot_no like \"%".trim($lot_no)."%\"";
//echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
    
    $html.= '<div><table>';
        switch (trim($product_group))
        {
            case "Elastic": 
            {   
                $html.= '<tr><td>ITEM CODE :<b> '.str_pad($item, 15, " ", STR_PAD_RIGHT).'</b> / Buy. : '.str_pad(substr($buyer,0,7), 6, " ", STR_PAD_RIGHT).''.'</td></tr>';
                $html.= "<tr><td>ITEM  NAME : <strong>".str_pad($item_name, 41, " ", STR_PAD_RIGHT)."</strong></td></tr>";  
                $html.= "<tr><td>COLOR : <strong>".str_pad($item_desc, 21, " ", STR_PAD_RIGHT)."</strong> / <strong>Shade </strong>: <strong>$ref4</strong></td></tr>";
                //$html.= "<tr><td>PO No : <strong>$po_no</strong> / Loc # : <b>$ref1</b>  / REF NO : <strong>$remarks</strong></td></tr>";
                $html.= "<tr><td>PO No : <strong>".str_pad($po_no, 7, " ", STR_PAD_RIGHT)."</strong>/ REF NO : <strong>$remarks</strong> / PKG # : <b>$pkg_no</b> </td></tr>";
                $html.= "<tr><td>LOT No : <b>".str_pad($lot_no, 10, " ", STR_PAD_RIGHT)."</b>/$child_lots  / Loc # : <b>".str_pad($ref1, 6, " ", STR_PAD_RIGHT)."</b> </td></tr>";
                //$html.= "<tr><td>REC # : <strong>$rec_no </strong>/ GRN D: <strong>$grn_date</strong> /Qty (YDS) : <strong> $qty_rec</strong></td></tr>";
                $html.= "<tr><td>REC # : <strong>".str_pad($rec_no, 11, " ", STR_PAD_RIGHT)."</strong> / GRN D: <strong>$grn_date</strong> / Qty (".$uom_ref.") : <strong> $qty_rec</strong></td></tr>";
                $html.= "<tr><td>BATCH # : <b>".str_pad($batch_no, 12, " ", STR_PAD_RIGHT)."</b> / BOX # : <b>$ref2</b>  </td></td></tr>";
                $html.= "<tr><td>".'<barcode code="'.leading_zeros($barcode_number,8).'" type="C39"/ height="0.60" size="0.90" text="1">       '."<strong>".str_pad(leading_zeros($barcode_number,8), 10, " ", STR_PAD_RIGHT)."</strong></tr>";
                break;
            }   
            case "Lace":    
            {   
                $html.= '<tr><td >ITEM CODE :<b> '.str_pad($item, 15, " ", STR_PAD_RIGHT).'</b> / Buy. : '.str_pad(substr($buyer,0,7), 6, " ", STR_PAD_RIGHT).''.'</td></tr>';
                $html.= "<tr><td>ITEM  NAME : <strong>".str_pad($item_name, 41, " ", STR_PAD_RIGHT)."</strong></td></tr>";  
                $html.= "<tr><td>COLOR : <strong>".str_pad($item_desc, 21, " ", STR_PAD_RIGHT)."</strong> / <strong>Shade </strong> : <strong>$ref4</strong></td></tr>";
                $html.= "<tr><td>PO No : <strong>".str_pad($po_no, 7, " ", STR_PAD_RIGHT)."</strong>  / REF NO : <strong>$remarks</strong> / PKG # : <b>$pkg_no</b> </td></tr>";
                $html.= "<tr><td>LOT No : <b>".str_pad($lot_no, 10, " ", STR_PAD_RIGHT)."</b> /  Loc # : <b>".str_pad($ref1, 6, " ", STR_PAD_RIGHT)."/ </b>  /</td></tr>";
                $html.= "<tr><td>REC # : <strong>".str_pad($rec_no, 11, " ", STR_PAD_RIGHT)." </strong>/ GRN D: <strong>$grn_date</strong> / Qty (".$uom_ref.") : <strong> $qty_rec</strong></td></tr>";
                $html.= "<tr><td>BATCH # : <b>".str_pad($batch_no, 12, " ", STR_PAD_RIGHT)."</b> / BOX # : <b>$ref2</b> </td></td></tr>";
                $html.= "<tr><td>".'<barcode code="'.leading_zeros($barcode_number,8).'" type="C39"/ height="0.60" size="0.90" text="1">       '."<strong>".str_pad(leading_zeros($barcode_number,8), 10, " ", STR_PAD_RIGHT)."</strong></tr>";
                break;
            }   
            case "Fabric":  
            {   
                $html.= '<tr><td >ITEM CODE :<b> '.str_pad($item, 15, " ", STR_PAD_RIGHT).'</b> / Buy. : '.str_pad(substr($buyer,0,7), 6, " ", STR_PAD_RIGHT).''.'</td></tr>';
                $html.= "<tr><td>ITEM  NAME : <strong>".str_pad($item_name, 41, " ", STR_PAD_RIGHT)."</strong></td></tr>";  
                $html.= "<tr><td>COLOR : <strong>".str_pad($item_desc, 21, " ", STR_PAD_RIGHT)."</strong> / <strong>Shade </strong> : <strong>$ref4</strong></td></tr>";
                //$html.= "<tr><td>PO No : <strong>$po_no</strong> / REF NO # : <strong>$remarks</strong> / PKG # : <b>$pkg_no</b> </td></tr>";
                $html.= "<tr><td>PO No : <strong>".str_pad($po_no, 7, " ", STR_PAD_RIGHT)."</strong> / REF NO # : <strong>$remarks</strong>/ PKG # : <b>$pkg_no</b>   </td></tr>";
                $html.= "<tr><td>LOT No : <b>".str_pad($lot_no, 10, " ", STR_PAD_RIGHT)."</b>/$child_lots / Loc # : <b>".str_pad($ref1, 6, " ", STR_PAD_RIGHT)."</b> </td></tr>";
                $html.= "<tr><td>REC # : <strong>$rec_no </strong> / GRN D: <strong>$grn_date</strong> /Qty (YDS) : <strong> $qty_rec</strong></td></tr>";
                //$html.= "<tr><td>REC # : <strong>".str_pad($rec_no, 11, " ", STR_PAD_RIGHT)." </strong>/ Qty (".$uom_ref.") : <strong> $qty_rec</strong></td></tr>";
                $html.= "<tr><td>BATCH # : <b>".str_pad($batch_no, 12, " ", STR_PAD_RIGHT)."</b> / ROLL # : <b>$ref2</b>  </td></tr>";
                $html.= "<tr><td>".'<barcode code="'.leading_zeros($barcode_number,8).'" type="C39"/ height="0.60" size="0.90" text="1">       '."<strong>".str_pad(leading_zeros($barcode_number,8), 10, " ", STR_PAD_RIGHT)."</strong></tr>";
                break;

                
            }   
            case "Thread":  
            {   
                $html.= '<tr><td >ITEM CODE :<b> '.str_pad($item, 15, " ", STR_PAD_RIGHT).'</b> / Buy. : '.str_pad(substr($buyer,0,7), 6, " ", STR_PAD_RIGHT).''.'</td></tr>';
                $html.= "<tr><td>ITEM  NAME : <strong>".str_pad($item_name, 41, " ", STR_PAD_RIGHT)."</strong></td></tr>";  
                $html.= "<tr><td>COLOR : <strong>".str_pad($item_desc, 21, " ", STR_PAD_RIGHT)."</strong> / Shade : <strong>$ref4</strong></td></tr>";
                $html.= "<tr><td>PO No : <strong>".str_pad($po_no, 7, " ", STR_PAD_RIGHT)."</strong> / REF NO : <strong>$remarks</strong> / PKG # : <b>$pkg_no</b></td></tr>";
                $html.= "<tr><td>LOT No : <b>".str_pad($lot_no, 10, " ", STR_PAD_RIGHT)."</b> / Loc # : <b>".str_pad($ref1, 6, " ", STR_PAD_RIGHT)."</b> </td></tr>";
                $html.= "<tr><td>REC # : <strong>".str_pad($rec_no, 11, " ", STR_PAD_RIGHT)." </strong> / GRN D: <strong>$grn_date</strong>/ Qty (".$uom_ref.") : <strong>$qty_rec</strong></td></tr>";
                $html.= "<tr><td>BATCH # : <b>".str_pad($batch_no, 12, " ", STR_PAD_RIGHT)." </b>/ BOX # : <b>$ref2</b> </td></td></tr>";
                $html.= "<tr><td>".'<barcode code="'.leading_zeros($barcode_number,8).'" type="C39"/ height="0.60" size="0.90" text="1">       '."<strong>".str_pad(leading_zeros($barcode_number,8), 10, " ", STR_PAD_RIGHT)."</strong></tr>";
                break;
            }   
            default:    
            {   
                $html.= '<tr><td >ITEM CODE :<b> '.str_pad($item, 15, " ", STR_PAD_RIGHT).'</b> / Buy. : '.str_pad(substr($buyer,0,7), 6, " ", STR_PAD_RIGHT).''.'</td></tr>';
                $html.= "<tr><td>ITEM  NAME : <strong>".str_pad($item_name, 41, " ", STR_PAD_RIGHT)."</strong></td></tr>";  
                $html.= "<tr><td>COLOR : <strong>".str_pad($item_desc, 21, " ", STR_PAD_RIGHT)."</strong> / Shade : <strong>$ref4</strong></td></tr>";
                $html.= "<tr><td>PO No : <strong>".str_pad($po_no, 7, " ", STR_PAD_RIGHT)."</strong>  / REF NO : <strong>$remarks</strong> / PKG # : <b>$pkg_no</b> </td></tr>";
                $html.= "<tr><td>LOT No : <b>".str_pad($lot_no, 10, " ", STR_PAD_RIGHT)."</b> / Loc # : <b>".str_pad($ref1, 6, " ", STR_PAD_RIGHT)."</b> </td></tr>";
                $html.= "<tr><td>REC # : <strong>".str_pad($rec_no, 11, " ", STR_PAD_RIGHT)." </strong>/ GRN Date : <strong>$grn_date</strong>/ Qty (".$uom_ref.") : <strong>$qty_rec</strong></td></tr>";
                $html.= "<tr><td>BATCH # : <b>".str_pad($batch_no, 12, " ", STR_PAD_RIGHT)."</b> / BOX # : <b>$ref2</b> </td></td></tr>";
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

$mpdf->WriteHTML($html); 
$mpdf->Output();


// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'mpdf.php',1,'R'));
// $mpdf=new mPDF('',array(101.6,50.8),0,'',3,0,0,0,0,0,'P');
// $mpdf->WriteHTML($html);
// $mpdf->Output(); 
// exit;

?>
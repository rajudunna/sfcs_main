<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="refresh" content="36000" />
<title>Delivery Schedule</title>
<?php include("dbconf.php"); 

$test="0";
$status_cut="Cut Finish";
//$today= date('Y-m-d');
$endday=Date('Y:m:d', strtotime("+7 days"));
$today=Date('Y:m:d', strtotime("-3 days"));

//$today= "2013-03-06";
//$endday="2013-03-06";

?>
<link href="main.css" rel="stylesheet" type="text/css" />


</head>

<body style="margin:0px;">
<div class="main_outer1" style="overflow: hidden;display:block;position:fixed;top:0px; right:auto;left:0px;padding-top:0px;width:1080px;">
<table width="1060px"  border="0"  >
    <tr  style="height:30px;background-color:#606;color:#FFF;font-weight:bold;">
      <td style="width:50px;">Stat.</td>
      
      <td style="width:50px;">Buyer</td>
      <td style="width:90px;" >PO</td>
      
      
      <td style="width:80px;" >Style</td>
      <td  style="width:70px;">Schd</td>
      <td  style="width:50px;">Date</td>
      
      <td style="width:50px;">Des.</td>
      <td style="width:60px;"> Qty</td>
      
      <td style="width:60px;">Cut Qty</td>
      <td style="width:60px;">In</td>
      <td style="width:60px;">Out </td>
      <td style="width:60px;">Folding</td>
     <td style="width:30px;">FCA </td>
      <td style="width:30px;">CIF </td>
      
      <td style="width:120px;">Team NO </td>
      
    </tr>
    </table>
</div>

<div class="main_outer1" style="overflow:auto;padding-top:0px;width:1080px;margin-left:0px;padding-left:0px;text-align:left;">
  
  
  <table width="1060px" border="0" style="margin-top:50px;margin-left:0px;padding-left:0px;" align="left">
    <?php

//$sql_schedule="SELECT b.order_style_no,b.order_del_no, SUM(b.`order_s_xs`+ b.`order_s_s`+ b.`order_s_m`+b.`order_s_l`+b. `order_s_xl`+ b.`order_s_xxl`+ b.`order_s_xxxl`+ b.`order_s_s06`+ 	b.`order_s_s08`+ b.`order_s_s10`+ b.`order_s_s12`+b.`order_s_s14`+b.`order_s_s16`+b.`order_s_s18`+b.`order_s_s20`+b.`order_s_s22`+ b.`order_s_s24`+ b.`order_s_s26`+ b.`order_s_s28`+ b.`order_s_s30` ) AS QTY , SUM(b.`old_order_s_xs`+ b.`old_order_s_s`+ b.`old_order_s_m`+b.`old_order_s_l`+b. `old_order_s_xl`+ b.`old_order_s_xxl`+ b.`old_order_s_xxxl`+ b.`old_order_s_s06`+ 	b.`old_order_s_s08`+ b.`old_order_s_s10`+ b.`old_order_s_s12`+b.`old_order_s_s14`+b.`old_order_s_s16`+b.`old_order_s_s18`+b.`old_order_s_s20`+b.`old_order_s_s22`+ b.`old_order_s_s24`+ b.`old_order_s_s26`+ b.`old_order_s_s28`+ b.`old_order_s_s30` ) AS QTY_old ,b.order_date	FROM 	`bai_pro3`.`bai_orders_db` b 	WHERE   order_date BETWEEN \"2013-02-07\" and \"2013-02-14\" and order_del_no NOT IN (\"0\",\"\") and order_joins NOT IN (\"1\",\"2\")	GROUP BY order_date ,order_del_no ORDER BY order_date ASC	";
$sql_schedule="SELECT b.order_style_no,b.order_del_no, b.order_date,b.order_po_no,order_div	FROM 	`bai_pro3`.`bai_orders_db` b 	WHERE   order_date BETWEEN \"$today\" and \"$endday\" and order_del_no NOT IN (\"0\",\"\") and order_joins NOT IN (\"1\",\"2\")	GROUP BY order_date ,order_del_no ORDER BY order_date ASC	";
//echo $sql_schedule;
	mysqli_query($link, $sql_schedule) or exit ("Sql Error in Order QTY1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_schedule_result=mysqli_query($link, $sql_schedule) or exit ("Sql Error in Order QTY2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_schedule_result);
	while($sql_row=mysqli_fetch_array($sql_schedule_result))
	{ 
	$ex_date=$sql_row['order_date'];
	$style_no=$sql_row['order_style_no'];
	$schedule_no=$sql_row['order_del_no'];
	$po_no=$sql_row['order_po_no'];
	$order_div=$sql_row['order_div'];
	//$new_qty=$sql_row['QTY'];
	//$old_qty=$sql_row['QTY_old'];
	$status_cut="Cut Finish";	
		
		//////////////////////////////////////////////////////////////////////////////////////Sipment plan details - Start ///////////////
		$sql_shipment="SELECT 	 `destination` FROM `bai_pro4`.`shipment_plan` 	WHERE schedule_no=\"$schedule_no\" AND ex_factory_date=\"$ex_date\" ";
		//echo $sql_shipment;
		mysqli_query($link, $sql_shipment) or exit ("Sql Error in shipment1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_shipment_result=mysqli_query($link, $sql_shipment) or exit ("Sql Error in shipment2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_shipment_result);
		while($sql_row_shipment=mysqli_fetch_array($sql_shipment_result))
		{ 
			//$order_qty=$sql_row_shipment['order_qty'];
			$destination=$sql_row_shipment['destination'];
		}
		
		
		////////////////////////////////////////////////// order qty /////////////
		
		$sql_order_qty="SELECT (SUM(order_s_xs)+SUM(order_s_s)+SUM(order_s_m)+SUM(order_s_l)+SUM(order_s_xl)+SUM(order_s_xxl)+SUM(order_s_xxxl)+SUM(order_s_s06)+SUM(order_s_s08)+SUM(order_s_s10)+SUM(order_s_s12)+SUM(order_s_s14)+SUM(order_s_s16)+SUM(order_s_s18)+SUM(order_s_s20)+SUM(order_s_s22)+SUM(order_s_s24)+SUM(order_s_s26)+SUM(order_s_s28)+SUM(order_s_s30)) AS TOTAL,(SUM(old_order_s_xs)+SUM(old_order_s_s)+SUM(old_order_s_m)+SUM(old_order_s_l)+SUM(old_order_s_xl)+SUM(old_order_s_xxl)+SUM(old_order_s_xxxl)+SUM(old_order_s_s06)+SUM(old_order_s_s08)+SUM(old_order_s_s10)+SUM(old_order_s_s12)+SUM(old_order_s_s14)+SUM(old_order_s_s16)+SUM(old_order_s_s18)+SUM(old_order_s_s20)+SUM(old_order_s_s22)+SUM(old_order_s_s24)+SUM(old_order_s_s26)+SUM(old_order_s_s28)+SUM(old_order_s_s30)) AS old_TOTAL FROM bai_orders_db WHERE order_del_no = \"$schedule_no\" ";
		mysqli_query($link, $sql_order_qty) or exit ("Sql Error in order_qty1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_order_qty_result=mysqli_query($link, $sql_order_qty) or exit ("Sql Error in order_qty2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_order_qty_result);
		while($sql_row_order_qty=mysqli_fetch_array($sql_order_qty_result))
		{ 
			$order_qty=$sql_row_order_qty['old_TOTAL'];
		}
		
		
		
		/////////////////////////////////// color wse order details /////////////////////////
		
		$color_wise_order_detail=array();     ////////////////////////////////order_tid is store in here///////////////
		//unset($color_wise_order_detail);
		$sql_order_detail="SELECT 	`order_tid`	FROM `bai_pro3`.`bai_orders_db`	WHERE `order_del_no`=\"$schedule_no\" ";
		$count="0";
		$cut_qty=0;
		mysqli_query($link, $sql_order_detail) or exit ("Sql Error in order_detail1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_order_detail_result=mysqli_query($link, $sql_order_detail) or exit ("Sql Error in order_detail2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_order_detail_result);
		while($sql_row_order_detail=mysqli_fetch_array($sql_order_detail_result))
		{ 
			$color_wise_order_detail[$count]=$sql_row_order_detail['order_tid'];
			
			//echo $count."-".$color_wise_order_detail[$count]." ;  ";
			
			
				//////////////////////////////////////////  Cut qty //////////////////////////////////
				$sql_plandoc="SELECT SUM((p.a_xs+p.a_s+p.a_m+p.a_l+p.a_xl+p.a_xxl+p.a_xxxl+p.a_s06+p.a_s08+p.a_s10+p.a_s12+p.a_s14+p.a_s16+p.a_s18+p.a_s20+p.a_s22+p.a_s24+p.a_s26+p.a_s28+p.a_s30)*p.a_plies) AS ratio FROM plandoc_stat_log p, cat_stat_log c WHERE p.order_tid=\"$color_wise_order_detail[$count]\" AND p.cat_ref=c.tid AND c.category=\"Body\" AND p.act_cut_status=\"DONE\" GROUP BY c.category ";
				//echo $sql_plandoc."<br>";
				mysqli_query($link, $sql_plandoc) or exit ("Sql Error in plandoc1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_plandoc_result=mysqli_query($link, $sql_plandoc) or exit ("Sql Error in plandoc2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_plandoc_result);
				while($sql_row_plandoc=mysqli_fetch_array($sql_plandoc_result))
				{ 
					$cut_qty=$cut_qty+$sql_row_plandoc['ratio'];
				}
				
				
				
				/////////////////////////check cut status ////////////////////////////////////
				$sql_cut_status="SELECT p.act_cut_status FROM plandoc_stat_log p WHERE p.order_tid=\"$color_wise_order_detail[$count]\"";
				//echo $sql_cut_status;
				mysqli_query($link, $sql_cut_status) or exit ("Sql Error in cut_status".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_cut_status_result=mysqli_query($link, $sql_cut_status) or exit ("Sql Error in cut_status2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_cut_status_result);
				while($sql_row_cut_status=mysqli_fetch_array($sql_cut_status_result))
				{ 
					if($sql_row_cut_status[act_cut_status]=="")
					{
						$status_cut="Cutting";
					}
					
				
				}
				
				
				
				
				
				
				
				
			$count++;
			
		}
		
		$ims_in_qty=0;
		$ims_out_qty=0;
		$module_no=array();
				$sql_ims="SELECT SUM(ims_qty) as line_in,SUM(ims_pro_qty) as line_out,ims_mod_no FROM ims_log WHERE ims_schedule=\"$schedule_no\" group by ims_mod_no "; //echo $sql_ims;
				mysqli_query($link, $sql_ims) or exit ("Sql Error in plandoc1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_ims_result=mysqli_query($link, $sql_ims) or exit ("Sql Error in plandoc2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_ims_result);
				while($sql_row_ims=mysqli_fetch_array($sql_ims_result))
				{ 
					$ims_in_qty=$ims_in_qty+$sql_row_ims['line_in'];
					$ims_out_qty=$ims_out_qty+$sql_row_ims['line_out'];
					//echo "A".array_search($sql_row_ims['ims_mod_no'],$module_no)." - ";
					if((array_search($sql_row_ims['ims_mod_no'],$module_no))=="")
					{
						$module_no[]=$sql_row_ims['ims_mod_no'];
					}
				}
				
				$sql_ims2="SELECT SUM(ims_qty) as line_in,SUM(ims_pro_qty) as line_out,ims_mod_no FROM ims_log_backup WHERE ims_schedule=\"$schedule_no\" group by ims_mod_no";
				mysqli_query($link, $sql_ims2) or exit ("Sql Error in plandoc1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_ims2_result=mysqli_query($link, $sql_ims2) or exit ("Sql Error in plandoc2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_ims2_result);
				while($sql_row_ims2=mysqli_fetch_array($sql_ims2_result))
				{ 
					$ims_in_qty=$ims_in_qty+$sql_row_ims2['line_in'];
					$ims_out_qty=$ims_out_qty+$sql_row_ims2['line_out'];
					//echo "B".array_search($sql_row_ims2['ims_mod_no'],$module_no)." - ";
					if((array_search($sql_row_ims2['ims_mod_no'],$module_no))=="")
					{
						$module_no[]=$sql_row_ims2['ims_mod_no'];
					}
					
				}
				
				
				
				///////////////////////////////////////     Folding   ////////////////
				$folding_qty="0";
				$sql_folding="SELECT 	SUM(`f_qty`) as fqty FROM `bai_pro3`.`tbl_folding` WHERE `f_schedule`=\"$schedule_no\"";
				mysqli_query($link, $sql_folding) or exit ("Sql Error in folding".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_folding_result=mysqli_query($link, $sql_folding) or exit ("Sql Error in folding".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_folding_result);
				while($sql_row_folding=mysqli_fetch_array($sql_folding_result))
				{ 
					$folding_qty=$sql_row_folding['fqty'];
					
				}
				
				$folding_com="0";
				$sql_folding_com="SELECT 	`f_schedule`, 	`f_time` FROM 	`bai_pro3`.`tbl_folding_complete`  WHERE `f_schedule`=\"$schedule_no\"";
				mysqli_query($link, $sql_folding_com) or exit ("Sql Error in plandoc1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_folding_com_result=mysqli_query($link, $sql_folding_com) or exit ("Sql Error in folding".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_folding_com_result);
				while($sql_row_folding_com=mysqli_fetch_array($sql_folding_com_result))
				{ 
					$folding_com="1";
					
				}
				
				
				
				///////////////////////////////////carton///////////////////
				
				$carton_qty="0";
				$sql_carton="SELECT 	SUM(cr_qty) AS carton_qty FROM 	`bai_pro3`.`tbl_carton` WHERE `cr_schedule`=\"$schedule_no\"";
				//echo $sql_carton;
				mysqli_query($link, $sql_carton) or exit ("Sql Error in carton_qty1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_carton_result=mysqli_query($link, $sql_carton) or exit ("Sql Error in carton_qty2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_carton_result);
				while($sql_row_carton=mysqli_fetch_array($sql_carton_result))
				{ 
					$carton_qty=$sql_row_carton['carton_qty'];
				}
				
				
				$carton_com="0";
				$sql_carton_com="SELECT 	`cr_schedule`, 	`cr_time` FROM 	`bai_pro3`.`tbl_carton_complete`  WHERE `cr_schedule`=\"$schedule_no\"";
				mysqli_query($link, $sql_carton_com) or exit ("Sql Error in carton1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_carton_com_result=mysqli_query($link, $sql_carton_com) or exit ("Sql Error in carton".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_carton_com_result);
				while($sql_row_carton_com=mysqli_fetch_array($sql_carton_com_result))
				{ 
					$carton_com="1";
					
				}
				
				
				///////////////////////////////////fca///////////////////
				
				$sql_fca="SELECT * from bai_pro2.fca_status WHERE order_del_no='$schedule_no'";
				$sql_fca_result=mysqli_query($link, $sql_fca) or exit ("Sql Error in fca_qty2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$fcas="";
				if($sql_row_fca=mysqli_fetch_array($sql_fca_result))
				{ 
					$fca_status=$sql_row_fca['status'];
					if($fca_status=="Approved"){
						$fcas="Pass";
					}else if($fca_status=="Rejected"){
						$fcas="Fail";
					}
					}
				
				
				
				
				$fa_qty="0";
				$sql_fa="SELECT MAX(fca_id),fca_qty as fa_qty  FROM `bai_pro3`.`tbl_fca` WHERE `fca_schedule`=\"$schedule_no\"";
				//echo $sql_carton;
				mysqli_query($link, $sql_fa) or exit ("Sql Error in fa_qty1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_fa_result=mysqli_query($link, $sql_fa) or exit ("Sql Error in fa_qty2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_fa_result);
				while($sql_row_fa=mysqli_fetch_array($sql_fa_result))
				{ 
					$fa_qty=$sql_row_fa['fa_qty'];
				}
				
				
				$fa_com="0";
				$sql_fa_com="SELECT 	`fca_schedule`, 	`fca_time` FROM 	`bai_pro3`.`tbl_fca_complete`  WHERE `fca_schedule`=\"$schedule_no\"";
				mysqli_query($link, $sql_fa_com) or exit ("Sql Error in fa".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_fa_com_result=mysqli_query($link, $sql_fa_com) or exit ("Sql Error in fa".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_fa_com_result);
				while($sql_row_fa_com=mysqli_fetch_array($sql_fa_com_result))
				{ 
					$fa_com="1";
					
				}
				
				
				///////////////////////////////////  CIF ///////////////////
				
				$cif_qty="0";
				$sql_cif="SELECT MAX(cif_id),cif_qty as cif_qty  FROM 	`bai_pro3`.`tbl_cif` WHERE `cif_schedule`=\"$schedule_no\"";
				//echo $sql_carton;
				mysqli_query($link, $sql_cif) or exit ("Sql Error in cif_qty1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_cif_result=mysqli_query($link, $sql_cif) or exit ("Sql Error in cif_qty2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_cif_result);
				while($sql_row_cif=mysqli_fetch_array($sql_cif_result))
				{ 
					$cif_qty=$sql_row_cif['cif_qty'];
				}
				
				
				$cif_com="0";
				$sql_cif_com="SELECT 	`cif_schedule`, 	`cif_time` FROM 	`bai_pro3`.`tbl_cif_complete`  WHERE `cif_schedule`=\"$schedule_no\"";
				mysqli_query($link, $sql_cif_com) or exit ("Sql Error in cif".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_cif_com_result=mysqli_query($link, $sql_cif_com) or exit ("Sql Error in cif".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_cif_com_result);
				while($sql_row_cif_com=mysqli_fetch_array($sql_cif_com_result))
				{ 
					$cif_com="1";
					
				}
				
				
				
		
		
		if($test=="0")
		{
			$test="1";
		}else if($test=="1")
		{
			$test="0";
		}
		
		
		if($cut_qty=="0")
		{
			$org_status="1";
			$status_cut="Cut Pending";
		}else if($status_cut=="Cutting")
		{
			$org_status="2";
		}else if($status_cut=="Cut Finish" and $cut_qty=="0" )
		{
			$org_status="3";
			$status_cut="Sewing Pending";
		}else if($ims_in_qty!="0" and ($order_qty>$ims_out_qty))
		{
			$org_status="4";
			$status_cut="Sewing";
		}else if($cif_com=="1")
		{
			$org_status="8";
			$status_cut="CIF";
		}else if($carton_com=="1")
		{
			$org_status="7";
			$status_cut="FA";
		}else if($folding_com=="1")
		{
			$org_status="6";
			$status_cut="Carton";
		}else if($order_qty<=$ims_out_qty)
		{
			$org_status="5";
			$status_cut="Folding";
		}
		
		
		
	?>
		
    
		
		
    <tr class="<?php if($test=="0"){ ?> hlight<?php } ?> m_over <?php if($fa_qty=="Fail" or $cif_qty=="Fail" ){ ?> fca_fail <?php } else if($fa_qty=="Pass1" or $cif_qty=="Pass1"){ ?> fca_pass <?php } ?>"  style="font-size:13px;font-weight:bold;" >
    <td style="width:50px;font-size:10px;"><?php echo $status_cut; ?></td>
    <td style="width:50px;"><?php //echo substr($order_div,0,3);
	  
	  switch(trim($order_div))
	  {
		  case "T71 - Boys Underwear - Outstanding Value":
		  echo "T71";
		  break;
		  
		  case "T71 - Girls Underwear - Authentic":
		  echo "T71";
		  break;
		  
		  case "T71 - Boys Underwear - Autograph":
		  echo "T71";
		  break;
		  
		  case "M&S T71 Kids Underwear":
		  echo "T71";
		  break;
		  
		  case "M&S/T61 - Ladies' Underwear Authentic":
		  echo "T61";
		  break;
		  
		  case "M&S/T61 - Ladies Underwear Authentic":
		  echo "T61";
		  break;
		  
		  case "M&S/T61 - Ladies' Underwear Outstanding":
		  echo "T61";
		  break;
		  
		  case "M&S/T14 - Men's /Authentic":
		  echo "T14";
		  break;
		  
		  case "M&S/T14 - Men's /Autograph":
		  echo "T14";
		  break;
		  
		  case "M&S/T14 - Men's /Outstanding Value":
		  echo "T14";
		  break;
		  
		  case "M&S/T14 - Men's Underwear /Classic Brief":
		  echo "T14";
		  break;
		  
		  
		  case "M&S/T14 - Mens /Autograph":
		  echo "T14";
		  break;
		  
		  
		  case "M&S/T14 - Mens /Authentic":
		  echo "T14";
		  break;
		  
		  case "DBA/ LOVABLE/ FILA/ MENS":
		  echo "DIM";
		  break;
		  
		  case "H&M /Ladies 1337":
		  echo "H&M";
		  break;
		  
		  case "H&M /Ladies 1338":
		  echo "H&M";
		  break;
		  
		  case "H&M /Ladies 3706":
		  echo "H&M";
		  break;
		  
		  case "H&M /Ladies 3707":
		  echo "H&M";
		  break;
		  
		  case "H & M /Mens  - 7988":
		  echo "H&M";
		  break;
		  
		  
		  
		  case "H&M /Divided 3937/LADIES":
		  echo "H&M";
		  break;
		  
		  case "VSS/VSI/Young Glamour":
		  echo "VS";
		  break;
		  
		  case "VSD/VSI/Young Glamour":
		  echo "VS";
		  break;
	  }
	  
	  
	  ?></td>
      <td style="font-size:10px;width:90px;"><?php echo $po_no; ?></td>
    
     
      <td style="width:80px;font-size:12px;" ><?php echo $style_no; ?></td>
      <td style="width:70px;font-size:12px;"><?php echo $schedule_no; ?></td>
       <td style="width:50px;font-size:12px;"><?php echo date('m-d', strtotime($ex_date)); ?></td>
      
      
      <td style="font-size:10px;width:50px;"><?php echo $destination; ?></td>
      <td style="width:60px;"><?php echo $order_qty; ?></td>
      <td style="width:60px;" <?php if($org_status=="1" || $org_status=="2"){ ?>class="del_dashboard_red" <?php } ?> ><?php echo $cut_qty; ?></td>
      <td style="width:60px;" <?php if($org_status=="4" || $org_status=="3"){ ?>class="del_dashboard_red" <?php } ?> ><?php echo $ims_in_qty; ?></td>
      <td style="width:60px;" <?php if($org_status=="4" ){ ?>class="del_dashboard_red" <?php } ?> ><?php echo $ims_out_qty; ?></td>
      <td style="width:60px;" <?php if($org_status=="5"){ ?>class="del_dashboard_red" <?php } ?> ><?php echo $folding_qty; ?></td>
  
     <!-- <td style="width:30px;" <?php if($org_status=="7"){ ?>class="del_dashboard_red" <?php } ?> >
	  <?php 
	 // if($fa_qty=="Pending"){ ?>
       <img src="images/pending2.png" height="30px" width="30px" />
       <?php// } else if($fa_qty=="Fail") {  ?>
       <img src="images/fail.png"  height="30px" width="30px"/>
       <?php// } else if($fa_qty=="Pass") {  ?>
       <img src="images/Pass.png" height="30px" width="30px" />
       <?php// } ?>
	  
	  
	  </td>-->
	  
	  <td style="width:30px;"><?php echo $fcas; ?></td>
      <td style="width:30px;font-size:10px;" <?php if($org_status=="8"){ ?>class="del_dashboard_red" <?php } ?> >
      <?php
      if($cif_qty=="Pending"){ ?>
       <img src="images/pending2.png" height="30px" width="30px" />
       <?php } else if($cif_qty=="Fail") {  ?>
       <img src="images/fail.png"  height="30px" width="30px"/>
       <?php } else if($cif_qty=="Pass") {  ?>
       <img src="images/Pass.png" height="30px" width="30px" />
       <?php } ?>
	 </td>
      
      <td style="width:120px;font-size:10px;" align="left">
	  <?php  
	  for($abc="0";$abc<sizeof($module_no);$abc++)
	  {
		  if($abc=="0")
		  {	echo $module_no[$abc];	}
		  else
		  {	echo ",".$module_no[$abc];	}
	  }
	  
	  
	  ?></td>
    </tr>
    
    <?php  } ?>
  </table>
	
    


</div>



</body>
</html>
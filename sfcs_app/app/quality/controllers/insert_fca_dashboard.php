

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include("dbconf.php");
$test="0";
$status_cut="Cut Finish";
?>
<link href="main.css" rel="stylesheet" type="text/css" />
<link href="back_end_style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="jquery-ui.css" />
<script src="js/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
  <script>
  $(function() {
    $( "#from" ).datepicker({
      defaultDate: "+0w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+0w",
      changeMonth: true,
      numberOfMonths: 2,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
  </script>


<script type="text/javascript">



function complate_update(test)
{
	//if(isNaN(str))      // validate Numeric or not????

	var test3="qqq"+test;
	//var test2="q"+test;
	var r=confirm("Please confirm that fca is completed for schedule number = "+test+"?????");
	if (r==false)
	  {
 		return;
 	}

/*if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
  if (test=="")
  {
  document.getElementById("txtHint").innerHTML="chathuranga rimesh";
  return;
  }*/
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	//alert('A');
    document.getElementById(test3).innerHTML=xmlhttp.responseText;

    }
	else{
		//alert('B');
			 document.getElementById(test3).innerHTML='<img src="<?= getFullURL($_GET['r'],'loader.gif','R') ?>" width="16" height="16" align="top"  text-align:center"/><br/><br/>';
		}
  }
	var link = <?= getFullURL($_GET['r'],'fca_complated.php','N'); ?>
	xmlhttp.open("GET",link+"&sch="+test,true);
	xmlhttp.send();
}
</script>


<script type="text/javascript">
function showUser(str,test)
{

	var test1="qq"+test;
	var test2="q"+test;
	//alert(test1);
/*if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
  if (test=="")
  {
  document.getElementById("txtHint").innerHTML="chathuranga rimesh";
  return;
  }*/
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		//document.getElementById(test1).innerHTML="AA";
    document.getElementById(test1).innerHTML=xmlhttp.responseText;
	document.getElementById(test2).value="";
    }
	else{
			 document.getElementById(test1).innerHTML='<img src="<?php getFullURL($_GET['r'],'loader.gif','R'); ?>" width="16" height="16" align="top"  text-align:center"/><br/><br/>';
		}
  }
xmlhttp.open("GET","update_fca.php?qty="+str+"&sch="+test,true);
xmlhttp.send();
}



</script>

<div class="panel panel-primary">
	<div class="panel-heading"><b>Update FCA</b></div>
	<div class="panel-body">

		<div class="main_outer" style="overflow: hidden;display:block;top:0px; right:auto;left:auto;padding-top:0px;padding-bottom:0px;width:910px;background-color:#FFF;border-top:1px solid #652901;">
				<div class="main_outer" style="overflow: hidden;display:block;top:0px; right:auto;left:auto;padding-top:0px;padding-bottom:0px;width:910px;background-color:#FFF;border-top:1px solid #013065;">
					<div class="heading_h1_fca" > FA Details </div>
					<?php $today= date('Y-m-d'); ?>

					<form action="" method="post">
						<div class="col-md-12">
							<div class="col-md-2">
								Select Date range :
							</div>
							<div class="col-md-3">
								<label for="from">From</label>
								<input type="date" class="form-control" id="from" name="from" value="<?php echo $today; ?>" />
							</div>
							<div class="col-md-3">
									<label for="to">To</label>
									<input type="date" class="form-control" id="to" name="to" value="<?php echo $today; ?>"  />
							</div>
							<div class="col-md-1">
								&nbsp;&nbsp;<input type="submit" class="btn btn-success" name="button" id="button" value="Submit" />
							</div>
						</div>
					</form>

					
					<br><table width="900px"  border="0"  class="table table-bordered">
						<tr  style="height:30px;background-color:#012246;color:#FFF;font-weight:bold;">
							<td width="124"  style="width:110px;">Date</td>
							<td width="166" style="width:110px;" >Style</td>
							<td width="93"  style="width:110px;">Schedule</td>
							<td width="119" style="width:110px;" >PO</td>
							<td width="80" style="width:70px;">Des.</td>
							<td width="93" style="width:110px;" > Qty</td>
							<!--<td style="width:70px;">Cut Qty</td>
						<td>In</td>
						<td>Out </td>-->
							<td width="93" style="width:200px;">FCA status</td>
							<td width="96" style="width:60px;">Status </td>
						</tr>
					</table>
				</div>
			</div>
			<div class="main_outer" style="overflow:auto;padding-top:0px;width:910px;padding-left:20px;">
				<table width="900px" border="0" style="margin-top:150px;">
					<?php

			//$sql_schedule="SELECT b.order_style_no,b.order_del_no, SUM(b.`order_s_xs`+ b.`order_s_s`+ b.`order_s_m`+b.`order_s_l`+b. `order_s_xl`+ b.`order_s_xxl`+ b.`order_s_xxxl`+ b.`order_s_s06`+ 	b.`order_s_s08`+ b.`order_s_s10`+ b.`order_s_s12`+b.`order_s_s14`+b.`order_s_s16`+b.`order_s_s18`+b.`order_s_s20`+b.`order_s_s22`+ b.`order_s_s24`+ b.`order_s_s26`+ b.`order_s_s28`+ b.`order_s_s30` ) AS QTY , SUM(b.`old_order_s_xs`+ b.`old_order_s_s`+ b.`old_order_s_m`+b.`old_order_s_l`+b. `old_order_s_xl`+ b.`old_order_s_xxl`+ b.`old_order_s_xxxl`+ b.`old_order_s_s06`+ 	b.`old_order_s_s08`+ b.`old_order_s_s10`+ b.`old_order_s_s12`+b.`old_order_s_s14`+b.`old_order_s_s16`+b.`old_order_s_s18`+b.`old_order_s_s20`+b.`old_order_s_s22`+ b.`old_order_s_s24`+ b.`old_order_s_s26`+ b.`old_order_s_s28`+ b.`old_order_s_s30` ) AS QTY_old ,b.order_date	FROM 	`bai_pro3`.`bai_orders_db` b 	WHERE   order_date BETWEEN \"2013-02-07\" and \"2013-02-14\" and order_del_no NOT IN (\"0\",\"\") and $order_joins_not_in	GROUP BY order_date ,order_del_no ORDER BY order_date ASC	";
			if(isset($_POST['from'])){
				$from=$_POST['from'];
				$to=$_POST['to'];
			//$sql_schedule="SELECT b.order_style_no,b.order_del_no, b.order_date,b.order_po_no	FROM 	`bai_pro3`.`bai_orders_db` b,`bai_pro3`.`tbl_carton` c 	WHERE   order_date BETWEEN \"$from\" and \"$to\" and order_del_no NOT IN (\"0\",\"\") and $order_joins_not_in AND order_del_no=cr_schedule		GROUP BY order_date ,order_del_no ORDER BY order_date ASC	";

			$sql_schedule="SELECT b.order_style_no,b.order_del_no, b.order_date,b.order_po_no	FROM 	`bai_pro3`.`bai_orders_db` b WHERE  order_date BETWEEN \"$from\" and \"$to\" and order_del_no NOT IN (\"0\",\"\") GROUP BY order_date ,order_del_no ORDER BY order_date ASC	";

			}
			else
			{
			//	$sql_schedule="SELECT b.order_style_no,b.order_del_no, b.order_date,b.order_po_no	FROM 	`bai_pro3`.`bai_orders_db` b ,`bai_pro3`.`tbl_carton` c	WHERE   order_date BETWEEN \"$today\" and \"$today\" and order_del_no NOT IN (\"0\",\"\") and $order_joins_not_in AND order_del_no=cr_schedule		GROUP BY order_date ,order_del_no ORDER BY order_date ASC	";

				$sql_schedule="SELECT b.order_style_no,b.order_del_no, b.order_date,b.order_po_no	FROM 	`bai_pro3`.`bai_orders_db` b WHERE   order_date BETWEEN \"$today\" and \"$today\" and order_del_no NOT IN (\"0\",\"\") 	GROUP BY order_date ,order_del_no ORDER BY order_date ASC	";


			}
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
				//$new_qty=$sql_row['QTY'];
				//$old_qty=$sql_row['QTY_old'];
				$status_cut="Cut Finish";
				$fca_qty="0";

					//////////////////////////////////////////////////////////////////////////////////////Sipment plan details - Start ///////////////
					//$sql_shipment="SELECT 	 SUM(`ord_qty`) AS order_qty,`destination` FROM `bai_pro4`.`shipment_plan` 	WHERE schedule_no=\"$schedule_no\" AND ex_factory_date=\"$ex_date\" ";
					$sql_shipment="SELECT 	 `destination` FROM `bai_pro4`.`shipment_plan` 	WHERE schedule_no=\"$schedule_no\" AND ex_factory_date=\"$ex_date\" ";
					//echo $sql_shipment;
					mysqli_query($link, $sql_shipment) or exit ("Sql Error in shipment1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_shipment_result=mysqli_query($link, $sql_shipment) or exit ("Sql Error in shipment2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_shipment_result);
					while($sql_row_shipment=mysqli_fetch_array($sql_shipment_result))
					{
						$order_qty="0";
						$destination=$sql_row_shipment['destination'];
					}


					////////////////////////////////////////////////// order qty /////////////
					$order_s_size='';$old_order_s_size='';
					for($j=0;$j<sizeof($sizes_array);$j++)
					{
						$order_s_size.="SUM(order_s_".$sizes_array[$j].")+";
						$old_order_s_size.="SUM(old_order_s_".$sizes_array[$j].")+";
					}
					$query1=substr($order_s_size,0,-1);
					$query2=substr($old_order_s_size,0,-1);

					$sql_order_qty="SELECT ($query1) AS TOTAL, ($query2) AS old_TOTAL FROM bai_pro3.bai_orders_db WHERE order_del_no = \"$schedule_no\" ";
					// echo $sql_order_qty;
					mysqli_query($link, $sql_order_qty) or exit ("Sql Error in order_qty1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_order_qty_result=mysqli_query($link, $sql_order_qty) or exit ("Sql Error in order_qty2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_order_qty_result);
					while($sql_row_order_qty=mysqli_fetch_array($sql_order_qty_result))
					{
						$order_qty=$sql_row_order_qty['old_TOTAL'];
					}


					/////////////////////////////////// color wse order details /////////////////////////

				/*  $color_wise_order_detail=array();     ////////////////////////////////order_tid is store in here///////////////
					//unset($color_wise_order_detail);
					$sql_order_detail="SELECT 	`order_tid`	FROM `bai_pro3`.`bai_orders_db`	WHERE `order_del_no`=\"$schedule_no\" ";
					$count="0";
					$cut_qty=0;
					mysql_query($sql_order_detail,$link) or exit ("Sql Error in order_detail1".mysql_error());
					$sql_order_detail_result=mysql_query($sql_order_detail,$link) or exit ("Sql Error in order_detail2".mysql_error());
					$sql_num_check=mysql_num_rows($sql_order_detail_result);
					while($sql_row_order_detail=mysql_fetch_array($sql_order_detail_result))
					{
						$color_wise_order_detail[$count]=$sql_row_order_detail['order_tid'];

						//echo $count."-".$color_wise_order_detail[$count]." ;  ";


							//////////////////////////////////////////  Cut qty //////////////////////////////////
							$sql_plandoc="SELECT SUM((p.a_xs+p.a_s+p.a_m+p.a_l+p.a_xl+p.a_xxl+p.a_xxxl+p.a_s06+p.a_s08+p.a_s10+p.a_s12+p.a_s14+p.a_s16+p.a_s18+p.a_s20+p.a_s22+p.a_s24+p.a_s26+p.a_s28+p.a_s30)*p.a_plies) AS ratio FROM plandoc_stat_log p, cat_stat_log c WHERE p.order_tid=\"$color_wise_order_detail[$count]\" AND p.cat_ref=c.tid AND c.category=\"Body\" AND p.act_cut_status=\"DONE\" GROUP BY c.category ";
							//echo $sql_plandoc;
							mysql_query($sql_plandoc,$link) or exit ("Sql Error in plandoc1".mysql_error());
							$sql_plandoc_result=mysql_query($sql_plandoc,$link) or exit ("Sql Error in plandoc2".mysql_error());
							$sql_num_check=mysql_num_rows($sql_plandoc_result);
							while($sql_row_plandoc=mysql_fetch_array($sql_plandoc_result))
							{
								$cut_qty=$cut_qty+$sql_row_plandoc['ratio'];
							}



							/////////////////////////check cut status ////////////////////////////////////
							$sql_cut_status="SELECT p.act_cut_status FROM plandoc_stat_log p WHERE p.order_tid=\"$color_wise_order_detail[$count]\"";
							//echo $sql_cut_status;
							mysql_query($sql_cut_status,$link) or exit ("Sql Error in cut_status".mysql_error());
							$sql_cut_status_result=mysql_query($sql_cut_status,$link) or exit ("Sql Error in cut_status2".mysql_error());
							$sql_num_check=mysql_num_rows($sql_cut_status_result);
							while($sql_row_cut_status=mysql_fetch_array($sql_cut_status_result))
							{
								if($sql_row_cut_status[act_cut_status]=="")
								{
									$status_cut="Cutting";
								}


							}








						$count++;

					}
					*/
					/*$ims_in_qty=0;
					$ims_out_qty=0;
							$sql_ims="SELECT SUM(ims_pro_qty) as line_out FROM ims_log WHERE ims_schedule=\"$schedule_no\"";
							mysql_query($sql_ims,$link) or exit ("Sql Error in plandoc1".mysql_error());
							$sql_ims_result=mysql_query($sql_ims,$link) or exit ("Sql Error in plandoc2".mysql_error());
							$sql_num_check=mysql_num_rows($sql_ims_result);
							while($sql_row_ims=mysql_fetch_array($sql_ims_result))
							{
								//$ims_in_qty=$ims_in_qty+$sql_row_ims['line_in'];
								$ims_out_qty=$ims_out_qty+$sql_row_ims['line_out'];
							}

							$sql_ims2="SELECT SUM(ims_pro_qty) as line_out FROM ims_log_backup WHERE ims_schedule=\"$schedule_no\"";
							mysql_query($sql_ims2,$link) or exit ("Sql Error in plandoc1".mysql_error());
							$sql_ims2_result=mysql_query($sql_ims2,$link) or exit ("Sql Error in plandoc2".mysql_error());
							$sql_num_check=mysql_num_rows($sql_ims2_result);
							while($sql_row_ims2=mysql_fetch_array($sql_ims2_result))
							{
								//$ims_in_qty=$ims_in_qty+$sql_row_ims2['line_in'];
								$ims_out_qty=$ims_out_qty+$sql_row_ims2['line_out'];
							}*/


					///////////////////////////////////fca/////////////////
					$fca_qty="0";
							$sql_fca="SELECT 	MAX(fca_id),fca_qty as fa_qty FROM 	`bai_pro3`.`tbl_fca` WHERE `fca_schedule`=\"$schedule_no\" ";
							//echo $sql_fca;
							mysqli_query($link, $sql_fca) or exit ("Sql Error in fca_qty1".mysqli_error($GLOBALS["___mysqli_ston"]));
							$sql_fca_result=mysqli_query($link, $sql_fca) or exit ("Sql Error in fca_qty2".mysqli_error($GLOBALS["___mysqli_ston"]));
							$sql_num_check=mysqli_num_rows($sql_fca_result);
							while($sql_row_fca=mysqli_fetch_array($sql_fca_result))
							{
								$fca_qty=$sql_row_fca['fa_qty'];
							}


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
					}else if($order_qty<=$ims_out_qty)
					{
						$org_status="5";
						$status_cut="fca";
					}


					$fca_com="0";
					$fca_com_time="";
					$sql_fca_com="SELECT 	`fca_schedule`, `fca_time` FROM `bai_pro3`.`tbl_fca_complete` 	WHERE `fca_schedule`=\"$schedule_no\"";
							//echo $sql_fca;
							mysqli_query($link, $sql_fca_com) or exit ("Sql Error in fca_qty1".mysqli_error($GLOBALS["___mysqli_ston"]));
							$sql_fca_com_result=mysqli_query($link, $sql_fca_com) or exit ("Sql Error in fca_qty2".mysqli_error($GLOBALS["___mysqli_ston"]));
							$sql_num_check=mysqli_num_rows($sql_fca_com_result);
							while($sql_row_fca_com=mysqli_fetch_array($sql_fca_com_result))
							{
								$fca_com="1";
								$fca_com_time=$sql_row_fca_com['fca_time'];
							}


				?>
					<tr class="<?php if($test=="0"){ ?> hlight_fca<?php } ?> m_over_fca"  >
						<td style="width:110px;"><?php echo $ex_date; ?></td>
						<td style="width:110px;"><?php echo $style_no; ?></td>
						<td style="width:110px;"><?php echo $schedule_no; ?></td>
						<td style="font-size:10px;width:110px;"><?php echo $po_no; ?></td>
						<td style="font-size:10px;width:70px;"><?php echo $destination; ?></td>
						<td style="width:110px;"><?php echo $order_qty; ?></td>
						<!--<td style="width:70px;"><?php echo $cut_qty; ?></td>
						<td><?php echo $ims_in_qty; ?></td>
						<td><?php echo $ims_out_qty; ?></td>-->
						<?php $pgeurl = getFullURL($_GET['r'],'insert_fca.php','N');?>
						<?php $imgurl = getFullURL($_GET['r'],'images/detail.png','R');?>
						<td style="width:200px;text-align:left;" align="left" valign="middle"><a target="_blank" href="<?= $pgeurl?>&style=<?php echo $style_no; ?>&schedule=<?php echo $schedule_no; ?>" onclick="Popup=window.open('<?= $pgeurl?>&style=<?php echo $style_no; ?>&schedule=<?php echo $schedule_no; ?>"."','Popup','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;"><img src="<?=$imgurl?>" width="32px" height="32px"  border="0"    /></a>
						<label>  <!--<input style="width:60px;text-align:center;" type="text" name="q<?php echo $schedule_no; ?>" id="q<?php echo $schedule_no; ?>" onchange="return showUser(q<?php echo $schedule_no; ?>.value,<?php echo $schedule_no; ?>)" <?php if($fca_com=="1"){ ?>disabled="disabled" <?php } ?> />-->
							<select size="1" class="form-control" name="q<?php echo $schedule_no; ?>" id="q<?php echo $schedule_no; ?>" onchange="return showUser(q<?php echo $schedule_no; ?>.value,<?php echo $schedule_no; ?>)" <?php if($fca_com=="1"){ ?>disabled="disabled" <?php } ?>>
								<option>Select...</option>
								<option value="Pending">Pending</option>
								<option value="Pass">Pass</option>
								<option value="Fail">Fail</option>
							</select>
						</label>

							<span id="qq<?php echo $schedule_no; ?>"> <?php echo $fca_qty; ?></span></td>
						<td style="width:60px;" ><div id="<?php echo $schedule_no; ?>">
							<?php
					if($fca_com=="0")
					{
						?>
							<!--   <form name="form1" method="post" action="" onSubmit="return complate_update(sch_no.value)">
								<input name="sch_no" id="sch_no" type="hidden" value="<?php echo $schedule_no; ?>" />
								<input type="image" name="submit1" id="submit1" value="Submit" src="images/pending.png" >
								</form>-->
							<?php $imgurl1 = getFullURL($_GET['r'],'images/pending.png','R'); ?>
							<img src="<?=$imgurl1 ?>" width="30px" height="30px" onclick="return complate_update(<?php echo $schedule_no; ?>)" />
							<?php
					}
					else if($fca_com=="1")
					{
						?>
							<?php $imgurl2 = getFullURL($_GET['r'],'images/finish.png','R'); ?>
							<img src="<?= $imgurl2 ?>" width="35px" height="35px" />
							<?php
					}
					?>
						</div></td>
					</tr>
					<?php  } ?>
				</table>
			</div>


</div>
</div>

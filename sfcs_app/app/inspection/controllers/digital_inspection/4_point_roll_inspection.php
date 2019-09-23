<?php
if(isset($_GET['parent_id'])){
	$parent_id=$_GET['parent_id'];
   	}
 include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
 $lot_number = $_GET['lot_no'];

  //$lot_number = ['5231799003','5231799002'];
 $get_details="select * from `bai_rm_pj1`.`inspection_population` where lot_no in($lot_number) and parent_id=$parent_id and status in(1,2)";
//  echo $get_details;
 $details_result=mysqli_query($link,$get_details) or exit("get_details Error".mysqli_error($GLOBALS["___mysqli_ston"]));
 while($row1=mysqli_fetch_array($details_result))
 {
 	$lot_num[]= $row1['lot_no']; 
 	$lot = $row1['lot_no'];
    $invoice = $row1['supplier_invoice'];
    $color = $row1['rm_color'];
    $batch = $row1['supplier_batch'];
    $po = $row1['supplier_po'];
    $item_code[$lot]= $row1['item_code'];
    $item_desc[$lot] = $row1['item_desc'];
 }
 $get_parent_id ="select id from $bai_rm_pj1.roll_inspection where batch_no='$batch' and po_no='$po'";
 echo $get_parent_id;
 $get_parent_id_result=mysqli_query($link,$get_parent_id) or exit("get_parent_id Error".mysqli_error($GLOBALS["___mysqli_ston"]));
 while($row12=mysqli_fetch_array($get_parent_id_result))
 {
 	$id_no = $row12['id'];
 }

 $path= getFullURLLevel($_GET['r'], "fabric_inspection_report.php", "0", "R")."?id=$id_no&color=$color&batch=$batch";
 $lot_details = implode("','",$lot_num);
  $inspection_details = "select * from $bai_rm_pj1.roll_inspection_child where lot_no in('".$lot_details."')";
//   echo $inspection_details;
  $inspection_details_result=mysqli_query($link,$inspection_details) or exit("inspection_details Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  while($row4=mysqli_fetch_array($inspection_details_result))
  {
     $fabric = $row4['fabric_composition'];
     $width = $row4['spec_width'];
     $status = $row4['inspection_status'];
     $weight = $row4['spec_weight'];
     $length = $row4['repeat_length'];
     $testing = $row4['lab_testing'];
     $tolerance = $row4['tolerance'];
     $item_code1 = $row4['item_code'];
     $roll_no = $row4['roll_no'];
     $rolls[] = $row4['roll_no']; 
     $inspected_per = $row4['inspected_per'];
     $inspected_qty = $row4['inspected_qty'];
     $invoice_qty = $row4['invoice_qty'];
     $s = $row4['width_s'];
     $m = $row4['width_m'];
     $e = $row4['width_e'];
     $actual_height = $row4['actual_height'];
     $actual_repeat_height = $row4['actual_repeat_height'];
     $skw = $row4['skw'];
     $bow = $row4['bow'];
     $ver = $row4['ver'];
     $gsm = $row4['gsm'];
     $comment = $row4['comment'];
     $marker_type = $row4['marker_type'];
  }

?>

<div class="container-fluid">
		<div class="panel panel-primary">
			<div class="panel-heading">4 Point Roll Inspection Update</div>
			<div class="panel-body">
				<div class="container">
					<div class="table-responsive col-sm-12">
					    <table class="table table-bordered">
					      <tbody>
					      <tr style="background-color: antiquewhite;">
					      	<th>Invoice #</th>
					      	<th>Color</th>
					      	<th>Batch</th>
					      	<th>PO#</th>
					      </tr>
					      <tr>
					      	<?php
						      	echo "<td>$invoice</td>
						      	<td>$color</td>
						      	<td>$batch</td>
						      	<td>$po</td>";
					      	?>
					      </tr>
					      </tbody>
					    </table>
					</div>
					<form id='myForm' method='post' name='input_main' action="?r=<?= $_GET['r']."&lot_no=".$lot_number."&parent_id=".$parent_id ?>">
					  <div class="table-responsive col-sm-12">
					  	<table class="table table-bordered">
					  	    <tbody>
						  		<tr>
						  			<td></td>
						  			<td></td>
		                            <td colspan="3">Tolerance</td>
						  		</tr>		
					  			<tr>	
					  				<td>Fabric Composition</td>
					  				<td><input type="text" id="fabric_composition" name="fabric_composition" class="float" autocomplete="off"></td>
					  				<td rowspan="2"><input type="text" id="tolerance" name="tolerance" class="float" autocomplete="off"></td>
					  			</tr>
					  			<tr>	
					  				<td>Inspection Status</td>
					  				<td>
					  					<select  name="inspection_status" id="inspection_status">
				                     	<option value="" disabled selected>Select Status</option>
				                     	<option value="approval">Aprroval</option>
				                     	<option value="rejected">Rejected</option>
				                     	<option value="partial rejected">Partial Rejected</option>
									</select>
					  				</td>
					  			</tr>
					  			<tr style="background-color: antiquewhite;">	
					  				<th style=text-align:center colspan="3">Spec Details</th>
					  			</tr>	
					  			<tr>
					  				<td>Spec Width</td>
					  				<td><input type="text" id="spec_width" name="spec_width" class="float" autocomplete="off"></td>
					  				<!-- <td><input type="text" id="tolerance" name="tolerance"></td> -->
					  			</tr>
					  			<tr>
					  				<td>Spec Weight</td>
					  				<td><input type="text" id="spec_weight" name="spec_weight" class="float" autocomplete="off"></td>
					  				<!-- <td><input type="text" id="tolerance" name="tolerance"></td> -->
					  			</tr>
					  			<tr>
					  				<td>Repeat Length</td>
					  				<td><input type="text" id="repeat_length" name="repeat_length" class="float" autocomplete="off"></td>
					  				<!-- <td><input type="text" id="tolerance" name="tolerance"></td> -->
					  			</tr>
					  			<tr style="background-color: antiquewhite;">
					  				<th style=text-align:center colspan=3>Inspection Summary</th>
					  			</tr>
					  			<tr>
					  				<td>Lab Testing</td>
					  				<td><input type="text" id="lab_testing" name="lab_testing" class="float" autocomplete="off"></td>
					  				<!-- <td rowspan="2"><input type="text" id="tolerance" name="tolerance"></td> -->
					  			</tr>	
					  		</tbody>	
					  	</table>	
					  </div> 
					  <div class="table-responsive col-sm-12">
					    <table class="table table-bordered">
					      <tbody>
					      	<tr style="background-color: antiquewhite;">
					      		<th>Supplier Roll No</th>
					      		<th>SFCS Roll No</th>
					      		<th>Ticket Length</th>
					      		<th>Ticket Width</th>
					      		<th>Item Code</th>
					      		<th>Color</th>
					      		<th>Description</th>
					      		<th>Lot No</th>
					      		<th>Qty</th>
					      		<th>Num of Points</th>
					      		<th>Roll Inspection Status</th>
					      	</tr>
					      	<!-- <tr> -->
					      	<?php
							   $url = getFullURLLevel($_GET['r'],'4_point_roll_inspection_child.php',0,'N');
							   
							  $get_details1="select supplier_no,ref2 as roll_no,ref5 as ctex_length,ref3 as ctex_width,qty_issued,lot_no from $bai_rm_pj1.store_in where lot_no in('".$lot_details."')";
							
							 $details1_result=mysqli_query($link,$get_details1) or exit("get_details1 Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							 
                             while($row2=mysqli_fetch_array($details1_result))
                             {

                              $roll_id = $row2['roll_no'];
                              $supplier_id = $row2['supplier_no'];	
                              $lot_id = $row2['lot_no'];
                              $lotids[]=$row2['lot_no'];
					      	  echo 
					      	  "<tr data-href='$url&supplier=$supplier_id&roll=$roll_id&lot=$lot_id&parent_id=$parent_id'>
					      	    <td>".$row2['supplier_no']."</td>
					      		<td>".$row2['roll_no']."</td>
					      		<td>".$row2['ctex_length']."</td>
					      		<td>".$row2['ctex_width']."</td>
					      		<td>".$item_code[$lot_id]."</td>
					      		<td>".$color."</td>
	                            <td>".$item_desc[$lot_id]."</td>
	                            <td>".$lot_id."</td>
	                            <td>".$row2['qty_issued']."</td>";
	                             $get_status_details="select SUM(1_points) as 1_points,SUM(2_points) as 2_points,SUM(3_points) as 3_points,SUM(4_points) as 4_points,supplier_roll_no,inspection_status from $bai_rm_pj1.roll_inspection_child where supplier_roll_no = '$roll_id'";
	                             //echo $get_status_details;
						      	 $status_details_result=mysqli_query($link,$get_status_details) or exit("get_status_details Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	                             while($row5=mysqli_fetch_array($status_details_result))
	                             { 
	                               $roll=$row5['supplier_roll_no']; 
	                               $status=$row5['inspection_status'];
	                               $point1=$row5['1_points']*1;
								   $point2=$row5['2_points']*2;
								   $point3=$row5['3_points']*3;
								   $point4=$row5['4_points']*4;
								   $main_points =  $point1+$point2+$point3+$point4;
		                            echo"
		                            <td>".$main_points."</td>
		                            <td>".$status."</td>
						      	   </tr>";
                                }
                             }
                             ?>	
					      </tbody>
					    </table>
					  </div>
					<div class="table-responsive col-sm-12">
					    <table class="table table-bordered">
					      <tbody>
					      	<tr style="background-color: antiquewhite;">
					      		<th>Item Code</th>
					      		<th>Roll No</th>
					      		<th>Inspected %</th>
					      		<th>Inspected Qty</th>
					      		<th>Invoice Qty</th>
					      		<th style=text-align:center colspan=3>Width(cm)</th>
					      		<th>Actual Height</th>
					      		<th>Actual Repeat Height</th>
					      		<th>SKW</th>
					      		<th>BOW</th>
					      		<th>Ver</th>
					      		<th>GSM(s/sqm)</th>
					      		<th>Comments</th>
					      		<th>Marker Type</th>
					      	</tr>
					      	<tr>
                                <td><input type="text" id="item_code1" name="item_code1" autocomplete="off"></td>
					      		<td><input type="text" id="roll_no1" name="roll_no1" autocomplete="off"></td>
					      		<td><input type="text" id="inspected_per" name="inspected_per" class="float" autocomplete="off"></td>
					      		<td><input type="text" id="inspected_qty" name="inspected_qty" class="float" autocomplete="off"></td>
					      		<td><input type="text" id="invoice_qty" name="invoice_qty" class="float" autocomplete="off"></td>
					      		<td><center>S</center><input type="text" id="s" name="s" colspan=3 class="float" autocomplete="off"></td>
					      		<td><center>M</center><input type="text" id="m" name="m" colspan=3 class="float" autocomplete="off"></td>
					      		<td><center>E</center><input type="text" id="e" name="e" colspan=3 class="float" autocomplete="off"></td>
					      		<td><input type="text" id="actual_height" name="actual_height" class="float" autocomplete="off"></td>
					      		<td><input type="text" id="actual_repeat_height" name="actual_repeat_height" class="float" autocomplete="off"></td>
					      		<td><input type="text" id="skw" name="skw" autocomplete="off"></td>
					      		<td><input type="text" id="bow" name="bow" autocomplete="off"></td>
					      		<td><input type="text" id="ver" name="ver" autocomplete="off"></td>
					      		<td><input type="text" id="gsm" name="gsm" autocomplete="off"></td>
					      		<td><input type="text" id="comment" name="comment" autocomplete="off"></td>
					      		<td><input type="text" id="marker_type" name="marker_type" autocomplete="off"></td>
					      	</tr>	
					     </tbody>
					    </table>
					</div>
					<div class="form-inline col-sm-12">
							<div class="table-responsive col-sm-3">
						     <table class="table table-bordered" style="margin-top: 48px;">
						       <tbody>
						      	<tr style="background-color: antiquewhite;">
						      		<th>CODE</th>
						      		<th>DAMAGE DESCRIPTION</th>
						      	</tr>
						      	<tr>
						      	  <td>C-1</td>
						      	  <td>Hole</td>
						      	</tr>
						      	<tr>
						      	  <td>C-2</td>
						      	  <td>Stain Mark</td>
						      	</tr>
						      	<tr>
						      	  <td>C-3</td>
						      	  <td>Knot</td>
						      	</tr>
						      	<tr>
						      	  <td>C-4</td>
						      	  <td>Mark</td>
						      	</tr>
						       </tbody>
						     </table>
						    </div>
						    <div class="form-horizontal col-sm-2">
							    <div>
							     <table class="table table-bordered" style="margin-top: 56px;">
							       <tbody>
							      	<tr>
							      	<?php
							      		echo "<td><a class='btn btn-sm btn-primary' href='$path' onclick='return popitup("."'".$path."'".")'>Print Report</a></td>";
							      	?>
							      	</tr>
							      	<tr>	
							      		<td><button type="sumbit" class='btn btn-sm btn-primary' name="save" id="save">Save</button></td>
							      	</tr>
							      	<tr>	
							      		<td><button type="sumbit" class='btn btn-sm btn-primary' name="confirm" id="confirm">Confirm</button></td>
							      	</tr>
							      </tbody>
							     </table>
							    </div> 
							 </div> 
                             <div class="table-responsive col-sm-7" style="margin-top:42px;">
						     <table class="table table-bordered">
						       <tbody>
						      	<tr style="background-color: antiquewhite;">
						      		<th>Code</th>
						      		<th>Damage Des</th>
						      		<th>1 Points</th>
						      		<th>2 Points</th>
						      		<th>3 Points</th>
						      		<th>4 Points</th>
						      		<th>Control</th>
						      	</tr>
						      	<?php 
						      	    for($i=0;$i<4;$i++){
						      	?>
						      	<tr>
						      		<td><input type="text" id="code" name="code[]" autocomplete="off"></td>
						      		<td><input type="text" id="damage" name="damage[]" autocomplete="off"></td>
						      		<td><input type="text" id="point1_<?= $i ?>" name="point1[]" onchange="sample(<?= $i ?>,1)" autocomplete="off"></td>
						      		<td><input type="text" id="point2_<?= $i ?>" name="point2[]" onchange="sample(<?= $i ?>,2)" autocomplete="off"></td>
						      		<td><input type="text" id="point3_<?= $i ?>" name="point3[]" onchange="sample(<?= $i ?>,3)" autocomplete="off"></td>
						      		<td><input type="text" id="point4_<?= $i ?>" name="point4[]" onchange="sample(<?= $i ?>,4)" autocomplete="off"></td>
						      		<td><button type="button" class="btn btn-primary btn-sm" id='clear' onclick='clearValues(<?= $i ?>)' value='<?= $i ?>'>Clear</button></td>
						      	</tr>
						      	<?php
						            }
						      	?>
						      </tbody>
						     </table>
						    </div>
                    </div>
                    <?php $implot=implode(',',$lot_num); ?>
                    <input type="hidden" name="lot_nos" value='<?=  $implot ?>'>
                    <input type="hidden" name="po" value='<?=  $po ?>'> 
                    <input type="hidden" name="batch" value='<?=  $batch ?>'> 
                    <input type="hidden" name="color" value='<?=  $color ?>'>     
				   </form>      	  	
				</div>
			</div>
        </div>
</div>

<?php
if(isset($_POST['save']))
{ 
  $fabric_composition = $_POST['fabric_composition'];
  $spec_width = $_POST['spec_width'];
  $inspection_status = $_POST['inspection_status'];
  $spec_weight = $_POST['spec_weight'];
  $repeat_length = $_POST['repeat_length'];
  $lab_testing = $_POST['lab_testing'];
  $lot_nums = $_POST['lot_nos'];
  $tolerance = $_POST['tolerance'];
  $item_code1 = $_POST['item_code1'];
  $roll_no1 = $_POST['roll_no1'];
  $inspected_per = $_POST['inspected_per'];
  $inspected_qty = $_POST['inspected_qty'];
  $invoice_qty = $_POST['invoice_qty'];
  $s = $_POST['s'];
  $m = $_POST['m'];
  $e = $_POST['e'];
  $actual_height = $_POST['actual_height'];
  $actual_repeat_height = $_POST['actual_repeat_height'];
  $skw = $_POST['skw'];
  $bow = $_POST['bow'];
  $ver = $_POST['ver'];
  $gsm = $_POST['gsm'];
  $comment = $_POST['comment'];
  $marker_type = $_POST['marker_type'];
  $po_no = $_POST['po'];
  $batch_no = $_POST['batch'];
  $color = $_POST['color'];

    if(isset($_POST['code']))
    {
		 $code = $_POST['code'];
		 echo
	 	$count=count($code);
	 	$damage = $_POST['damage'];
		  $insert_roll_details = "insert into $bai_rm_pj1.roll_inspection(po_no,batch_no,color) values ('$po_no','$batch_no','$color')";
		  echo "</br>".$insert_roll_details."</br/>";
		 mysqli_query($link, $insert_roll_details) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"]));
         $id = mysqli_insert_id($link);
	 	for($i=0;$i<$count;$i++)
	  	{	
	  		  $code1 = $_POST['code'][$i];
	  		  $damage1 = $_POST['damage'][$i];
		  	  $point1 = $_POST['point1'][$i];
		  	  $point2 = $_POST['point2'][$i];
		  	  $point3 = $_POST['point3'][$i];
		  	  $point4 = $_POST['point4'][$i];

		  	   if($point1 != 0 || $point2 != 0 || $point3 != 0 || $point4 != 0)
		  	   {
		  	   	
                   $get_lot_details="select supplier_no,ref2 as roll_no,lot_no from $bai_rm_pj1.store_in where lot_no in($lot_nums)";
				//    echo $get_lot_details."</br/>";
				   $lot_details_result=mysqli_query($link,$get_lot_details) or exit("get_lot_details Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				   while($row3=mysqli_fetch_array($lot_details_result))
				   {
				      $roll_no = $row3['roll_no'];
				      $supplier_no = $row3['supplier_no'];
				      $lots = $row3['lot_no'];

				       
					  $insert_query="insert into $bai_rm_pj1.roll_inspection_child(lot_no,supplier_roll_no,sfcs_roll_no,fabric_composition,spec_width,inspection_status,spec_weight,repeat_length,lab_testing,tolerance,item_code,roll_no,inspected_per,inspected_qty,invoice_qty,width_s,width_m,width_e,actual_height,actual_repeat_height,skw,bow,ver,gsm,comment,marker_type,code,damage_desc,1_points,2_points,3_points,4_points,parent_id) values ('$lot_num','$supplier_no','$roll_no',$fabric_composition,$spec_width,'$inspection_status',$spec_weight,$repeat_length,$lab_testing,$tolerance,'$item_code1','$roll_no1','$inspected_per',$inspected_qty,$invoice_qty,$s,$m,$e,'$actual_height','$actual_repeat_height','$skw','$bow','$ver','$gsm','$comment','$marker_type','$code1','$damage1','$point1','$point2','$point3','$point4','$id')";
				 	//   echo $insert_query."</br/>";
					  $result_query = $link->query($insert_query) or exit('query1 error in inserting1111');

					  $update_status = "update $bai_rm_pj1.inspection_population SET status=2 where supplier_roll_no='$supplier_no' and sfcs_roll_no='$roll_no' and lot_no='$lots'";
					  $result_query_update = $link->query($update_status) or exit('query2 error in updating');
				    }
					echo "<script>sweetAlert('Data Saved Sucessfully','','info');</script>";
					die();
		  	    }
		  	    else
		  	    {
		  	    	echo "<script>sweetAlert('Please fill Reason Code','','error');</script>";
		  	    }	
	  	}
	}
	
}
?>

<?php
if(isset($_POST['confirm']))
{
  $fabric_composition = $_POST['fabric_composition'];
  if($fabric_composition==''){ $fabric_composition=0; }else{$fabric_composition;}
  
  $spec_width = $_POST['spec_width'];
  if($spec_width==''){ $spec_width=0; }else{$spec_width;}

  $inspection_status = $_POST['inspection_status'];
  if($inspection_status==''){ $inspection_status=0; }else{$inspection_status;}

  $spec_weight = $_POST['spec_weight'];
  if($spec_weight==''){ $spec_weight=0; }else{$spec_weight;}

  $repeat_length = $_POST['repeat_length'];
  if($repeat_length==''){ $repeat_length=0; }else{$repeat_length;}

  $lab_testing = $_POST['lab_testing'];
  if($lab_testing==''){ $lab_testing=0; }else{$lab_testing;}

  $lot_nums = $_POST['lot_nos'];
  if($lot_nums==''){ $lot_nums=0; }else{$lot_nums;}

  $tolerance = $_POST['tolerance'];
  if($tolerance==''){ $tolerance=0; }else{$tolerance;}

  $item_code1 = $_POST['item_code1'];
  if($item_code1==''){ $item_code1=0; }else{$item_code1;}

  $roll_no1 = $_POST['roll_no1'];
  if($roll_no1==''){ $roll_no1=0; }else{$roll_no1;}

  $inspected_per = $_POST['inspected_per'];
  if($inspected_per==''){ $inspected_per=0; }else{$inspected_per;}

  $inspected_qty = $_POST['inspected_qty'];
  if($inspected_qty==''){ $inspected_qty=0; }else{$inspected_qty;}

  $invoice_qty = $_POST['invoice_qty'];
  if($invoice_qty==''){ $invoice_qty=0; }else{$invoice_qty;}

  $s = $_POST['s'];
  if($s==''){ $s=0; }else{$s;}

  $m = $_POST['m'];
  if($m==''){ $m=0; }else{$m;}

  $e = $_POST['e'];
  if($e==''){ $e=0; }else{$e;}

  $actual_height = $_POST['actual_height'];
  if($actual_height==''){ $actual_height=0; }else{$actual_height;}

  $actual_repeat_height = $_POST['actual_repeat_height'];
  if($actual_repeat_height==''){ $actual_repeat_height=0; }else{$actual_repeat_height;}

  $skw = $_POST['skw'];
  if($skw==''){ $skw=0; }else{$skw;}

  $bow = $_POST['bow'];
  if($bow==''){ $bow=0; }else{$bow;}

  $ver = $_POST['ver'];
  if($ver==''){ $ver=0; }else{$ver;}

  $gsm = $_POST['gsm'];
  if($gsm==''){ $gsm=0; }else{$gsm;}

  $comment = $_POST['comment'];
  if($comment==''){ $comment=0; }else{$comment;}

  $marker_type = $_POST['marker_type'];
  if($marker_type==''){ $marker_type=0; }else{$marker_type;}

  $po_no = $_POST['po'];
  if($po_no==''){ $po_no=0; }else{$po_no;}

  $batch_no = $_POST['batch'];
  if($batch_no==''){ $batch_no=0; }else{$batch_no;}

  $color = $_POST['color'];
  if($color==''){ $color=0; }else{$color;}

    if(isset($_POST['code']))
    {
		 $code = $_POST['code'];
		
	 	$count=count($code);
		$damage = $_POST['damage'];
	 	$insert_roll_details = "insert into $bai_rm_pj1.roll_inspection(po_no,batch_no,color) values ('$po_no','$batch_no','$color')";
		mysqli_query($link, $insert_roll_details) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"]));
        $id = mysqli_insert_id($link);
	 	for($i=0;$i<$count;$i++)
	  	{
			  
			  $code1 = $_POST['code'][$i];
			  if($code1==''){ $code1=0; }else{$code1;}

			  $damage1 = $_POST['damage'][$i];
			  if($damage1==''){ $damage1=0; }else{$damage1;}

			  $point1 = $_POST['point1'][$i];
			  if($point1==''){ $point1=0; }else{$point1;}

			  $point2 = $_POST['point2'][$i];
			  if($point2==''){ $point2=0; }else{$point2;}

			 $point3 = $_POST['point3'][$i];
			 if($point3==''){ $point3=0; }else{$point3;}

		  	  $point4 = $_POST['point4'][$i];
			  if($point4==''){ $point4=0; }else{$point4;}

		  	   if($point1 != 0 || $point2 != 0 || $point3 != 0 || $point4 != 0)
		  	   {
				  $insert_roll_details = "insert into $bai_rm_pj1.roll_inspection(po_no,batch_no,color) values (po_no,batch_no,color) ";
				  
		  	  	  $get_lot_details="select supplier_no,ref2 as roll_no, lot_no from $bai_rm_pj1.store_in where lot_no in($lot_nums)";

				   $lot_details_result=mysqli_query($link,$get_lot_details) or exit("get_lot_details Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				   while($row3=mysqli_fetch_array($lot_details_result))
				   {
				      $roll_no = $row3['roll_no'];
					  $supplier_no = $row3['supplier_no'];
					  if($supplier_no=='') { $supplier_no=0; } else { $supplier_no; };
					  $lots = $row3['lot_no'];
					  
					  $insert_query="insert into $bai_rm_pj1.roll_inspection_child(lot_no,supplier_roll_no,sfcs_roll_no,fabric_composition,spec_width,inspection_status,spec_weight,repeat_length,lab_testing,tolerance,item_code,roll_no,inspected_per,inspected_qty,invoice_qty,width_s,width_m,width_e,actual_height,actual_repeat_height,skw,bow,ver,gsm,comment,marker_type,code,damage_desc,1_points,2_points,3_points,4_points,parent_id) values ('$lots','$supplier_no','$roll_no',$fabric_composition,'$spec_width','$inspection_status','$spec_weight','$repeat_length','$lab_testing','$tolerance','$item_code1','$roll_no1','$inspected_per','$inspected_qty','$invoice_qty','$s','$m','$e','$actual_height','$actual_repeat_height','$skw','$bow','$ver','$gsm','$comment','$marker_type','$code1','$damage1',$point1,$point2,$point3,$point4,$id)";
					  
					  $result_query = $link->query($insert_query) or exit('query error in inserting2222');

					  $update_status = "update $bai_rm_pj1.inspection_population SET status=3 where supplier_roll_no=$supplier_no and sfcs_roll_no=$roll_no and lot_no='$lots'";
					  $result_query_update = $link->query($update_status) or exit('query error in updating');
				    }
					echo "<script>sweetAlert('Updated Sucessfully','','info');</script>";
					die();
		  	    }
		  	    else
		  	    {
		  	    	echo "<script>sweetAlert('Please fill Reason Code','','error');</script>";
		  	    }	
	  	}
	}
}
?>

<script>
	function clearValues(i){
		alert();
		var id = i;
        $('#point1_'+id).val('');$('#point2_'+id).val('');
        $('#point3_'+id).val('');$('#point4_'+id).val('');
	}

	$(document).ready(function(){

		

		$('#clear1').click(function(){
			alert();
	        var id = $(this).val();
	        $('#point1_'+id).val('');$('#point2_'+id).val('');
	        $('#point3_'+id).val('');$('#point4_'+id).val('');
	        alert();
	    });
	})
	
</script>

<script type="text/javascript">
	jQuery(document).ready(function($) {
    $('*[data-href]').on('click', function() {
        window.location = $(this).data("href");
    });
});

	function sample(row,column)
	{
	 if($('#point'+column+'_'+row).val()) {
       for(var i=1;i<=4;i++)
       {
       	if(column != i)
       	 $('#point'+i+'_'+row).attr("readonly","true");
       }
   } else {
   	for(var i=1;i<=4;i++)
       {
       	 $('#point'+i+'_'+row).attr("readonly",false);
       }
   }
	}
</script>
<style type="text/css">
	[data-href] {
    cursor: pointer;
}
</style>
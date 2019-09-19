<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
 $parent_id = $_GET['id'];
 $batch_no = $_GET['batch'];
 $color = $_GET['color'];
 $get_table_details = "select * from $bai_rm_pj1.roll_inspection_child where parent_id=$parent_id";
  $table_details_result=mysqli_query($link,$get_table_details) or exit("get_table_details Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  while($row1=mysqli_fetch_array($table_details_result))
  {
     $fabric = $row1['fabric_composition'];
     $width = $row1['spec_width'];
     $status = $row1['inspection_status'];
     $weight = $row1['spec_weight'];
     $length = $row1['repeat_length'];
     $testing = $row1['lab_testing'];
     $fabric = $row1['fabric_composition'];
     $width = $row1['spec_width'];
     $status = $row1['inspection_status'];
     $weight = $row1['spec_weight'];
     $length = $row1['repeat_length'];
     $testing = $row1['lab_testing'];
     $tolerance = $row1['tolerance'];
     $rolls[] = $row1['supplier_roll_no'];
  }
  $roll_details = implode(',',$rolls);
  $get_details1="select ref5 as ctex_length,ref2 as roll_id from $bai_rm_pj1.store_in where ref2 in($roll_details)";
  //echo $get_details1;
 $details1_result=mysqli_query($link,$get_details1) or exit("get_details1 Error".mysqli_error($GLOBALS["___mysqli_ston"]));
 while($row2=mysqli_fetch_array($details1_result))
 {
     $roll_id = $row2['roll_id'];
     $ticket_length[$roll_id] = $row2['ctex_length'];
 }
 $get_sticker_report = "select style_no,inv_no,sum(rec_qty) as invoice_qty,supplier,buyer from $bai_rm_pj1.sticker_report where batch_no='$batch_no'";
 //echo $get_sticker_report;
 $sticker_report_details=mysqli_query($link,$get_sticker_report) or exit("get_sticker_report Error".mysqli_error($GLOBALS["___mysqli_ston"]));
 while($row3=mysqli_fetch_array($sticker_report_details))
 {
   $style = $row3['style_no'];
   $invoice = $row3['inv_no'];
   $invoice_qty = $row3['invoice_qty'];
   $supplier = $row3['supplier'];
   $buyer = $row3['buyer'];
 }
?>
<link rel="stylesheet" type="text/css" href="../../../../common/css/page_style.css" />
<link rel="stylesheet" href="../../../../common/css/bootstrap.min.css">
<div class="container-fluid">
    <div class="panel panel-primary">
      <div class="panel-heading">Brandix Apparel Solution</div>
      <div class="panel-body">
        <div class="container">
          <h3>Fabric Inspection Division</h3>
          <h6><u>Material Inspection Report</u></h6>
          <hr>
          <div class="form-inline col-sm-12">
             
                 <table class="table table-bordered">
                   <tbody>
                    <tr>
                      <th>Date Time</th>
                      <th>OTT Date</th>
                      <th>Style No</th>
                      <th>color</th>
                      <th>GRN Number</th>
                      <th>Invoice Number</th>
                      <th>Invoice Quantity</th>
                    </tr> 
                    <tr>
                      <?php
                      echo"<td></td>
                      <td></td>
                      <td>".$style."</td>
                      <td>".$color."</td>
                      <td></td>
                      <td>".$invoice."</td>
                      <td>".$invoice_qty."</td>";
                      ?>
                    </tr> 
                   </tbody>
                  </table>
              </div>
              <div class="table-responsive col-sm-12">
                 <table class="table table-bordered">
                   <tbody>
                    <tr>
                      <th>Fabric Quantity</th>
                      <th>Composition</th>
                      <th>Supplier</th>
                      <th>Buyer</th>
                    </tr>
                    <tr>
                      <?php
                      echo "<td></td>
                      <td></td>
                      <td>".$supplier."</td>
                      <td>".$buyer."</td>";
                      ?>
                    </tr>  
                   </tbody>
                 </table>
              </div>
             </div>
             <div class="table-responsive col-sm-12">
                 <div class="table-responsive col-sm-6">
                 <table class="table table-bordered">
                  <thead>
                    <tr>Spec Details<tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th>Spec. Width(cm)</th>
                      <th>Spec. Weight(cm)</th>
                      <th>Actual Weight(g/sqm)</th>
                      <th>Repeat Length</th>
                      <th>Act. Rpt. Length</th>
                    </tr>
                    <tr>
                      <?php                       
                      echo "<td>".$width."</td>
                      <td>".$weight ."</td>
                      <td></td>
                      <td>".$length."</td>
                      <td></td>
                    </tr>"; 
                    ?>
                  </tbody> 
                 </table>
                </div>
                <div class="table-responsive col-sm-6">
                 <table class="table table-bordered">
                  <thead>
                    <tr>Inspection Summary<tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th>Checked</th>
                      <th>No of Rolls</th>
                      <th>Rolls Inspected</th>
                      <th>Average Points</th>
                      <th>Length Shortage</th>
                      <th>Lab Testing</th>
                    </tr>
                    <?php
                    echo "<tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>".$testing."</td>
                    </tr>";
                    ?> 
                  </tbody> 
                 </table>
                </div>
           </div> 
           <div class="table-responsive col-sm-12">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <th>BLI Roll No / Sup</th>
                  <th>Batch Number</th>
                  <th>Ticket Length(M)</th>
                  <th>Actual Length</th>
                  <th style=text-align:center colspan=3>Usable Width(cm)</th>
                  <th style=text-align:center colspan=4>Total Point</th>
                  <th>Total Points</th>
                  <th>Point Rate</th>
                  <th>Comments</th>
                  <th>Damage</th>
                  <th>GSM</th>
                  <th>SK</th>
                  <th>BO</th>
                  <th>VE</th>
                </tr> 
                <tr>
                  <?php
                  $get_main_details = "select GROUP_CONCAT(damage_desc) as damage_desc,SUM(1_points) as 1_points,SUM(2_points) as 2_points,SUM(3_points) as 
                  3_points,SUM(4_points) as 4_points,supplier_roll_no,width_s,width_m,width_e,COMMENT,gsm,skw,bow,ver from $bai_rm_pj1.roll_inspection_child where Supplier_roll_no in ($roll_details)";
                  //echo $get_main_details;
                  $main_details_result=mysqli_query($link,$get_main_details) or exit("get_main_details Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($row3=mysqli_fetch_array($main_details_result))
                  {
                    $point1=$row3['1_points']*1;
                    $point2=$row3['2_points']*2;
                    $point3=$row3['3_points']*3;
                    $point4=$row3['4_points']*4;
                    $main_points =  $point1+$point2+$point3+$point4;
                  echo "
                  <td>".$row3['supplier_roll_no']."</td>
                  <td></td>
                  <td>".$ticket_length[$roll_id]."</td>
                  <td></td>
                  <td><center>S</center>".$row3['width_s']."</td>
                  <td><center>M</center>".$row3['width_m']."</td>
                  <td><center>E</center>".$row3['width_e']."</td>
                  <td><center>1 Points</center>".$row3['1_points']."</td>
                  <td><center>2 Points</center>".$row3['2_points']."</td>
                  <td><center>3 Points</center>".$row3['3_points']."</td>
                  <td><center>4 Points</center>".$row3['4_points']."</td>
                  <td>".$main_points."</td>
                  <td></td>
                  <td>".$row3['comment']."</td>
                  <td>".$row3['damage_desc']."</td>
                  <td>".$row3['gsm']."</td>
                  <td>".$row3['skw']."</td>
                  <td>".$row3['bow']."</td>
                  <td>".$row3['ver']."</td>
                </tr>"; 
                }
                ?>
              </tbody> 
            </table>
           </div> 
            <h6>Total Inspected Qty - <?= $ticket_length[$roll_id]?><u></u></h6><h6>Actual Points Counted - <?= $main_points?><u></u></h6> 
            <hr>    
        </div>
      </div>
    </div>
</div>
         
<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
 $parent_id = $_GET['id'];
 $batch_no = $_GET['batch'];
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
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
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
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
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
                      $get_table_details = "select * from $bai_rm_pj1.roll_inspection_child where parent_id=$parent_id";
                      $table_details_result=mysqli_query($link,$get_table_details) or exit("get_table_details Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                      while($row1=mysqli_fetch_array($table_details_result))
                      {
                        $lot_number = $row1['lot_no'];
                       
                      echo "<td>".$row1['spec_width']."</td>
                      <td>".$row1['spec_weight']."</td>
                      <td></td>
                      <td>".$row1['repeat_length']."</td>
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
                      <td>".$row1['lab_testing']."</td>
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
                  echo "
                  <td>".$row1['supplier_roll_no']."</td>
                  <td>".$batch_no."</td>
                  <td></td>
                  <td></td>
                  <td rowspan=3><center>S</center>1</td>
                  <td><center>M</center>2</td>
                  <td><center>E</center>3</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>";
                 } 
                ?>
              </tbody> 
            </table>
           </div> 
            <h6>Total Inspected Qty - <u></u></h6><h6>Actual Points Counted - <u></u></h6>     
        </div>
      </div>
    </div>
</div>
         
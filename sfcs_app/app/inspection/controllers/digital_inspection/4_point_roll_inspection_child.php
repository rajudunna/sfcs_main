<head>
<script>
		
		$(document).ready(function() {
			if (screen.width <= 1070) 
            {
                $BODY.toggleClass('nav-md nav-sm');
            }
		});
</script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'], 'common/js/openbundle_report.min.js', 4, 'R'); ?>"></script>	

<style>
        .tableBodyScroll::-webkit-scrollbar 
        {
            width: 5px;
        /* height: 12px */
        }
        .tableBodyScroll::-webkit-scrollbar-button 
        {
            background: #ccc
        }
        .tableBodyScroll::-webkit-scrollbar-track-piece 
        {
            background: #eee
        }
        .tableBodyScroll::-webkit-scrollbar-thumb 
        {
            background: #888
        }​
        .tableFixHead {
            overflow-y: auto; height: 100px; 
         }
        .tableFixHead thead th { 
            position: sticky; top: 0; 
        }

        .tableFixHead table  {
             border-collapse: collapse; width: 100%; 
        }
     
        th { background:antiquewhite; }

        table tr th,td 
        {
            text-align: center;
        }
        #check_true
        {
            cursor:pointer;
        }
        .selected 
        {
         background-color: yellow;  
        }
         .activate_code {
         background-color: green;  
         color: whitesmoke;
         }
        .tableBodyScroll
        {
            display: block;
            max-height: 300px;
            overflow-y: scroll;
        }
        .tableBodyScroll tbody tr
        {
            cursor: pointer;
        }
        button.close 
        {
            background: #d73e4d;
            background: rgba(215, 62, 77, 0.75);
            border: 0 none !important;
            color: #fff7cc;
            display: inline-block;
            float: none;
            font-size: 31px;
            height: 30px;
            line-height: 1;
            margin: 0px 1px;
            opacity: 1;
            text-align: center;
            text-shadow: none;
            -webkit-transition: background 0.2s ease-in-out;
            transition: background 0.2s ease-in-out;
            vertical-align: top;
            width: 30px;
            border-radius: 15px;
        }
    </style>

 <script type='text/javascript'>
  function addFourPoints(points_id){
    let point_value=points_id.split("_")[1];
         if($(".activate_code").text()){
        let code_value=$(".activate_code").text();
               let target_value=code_value+'_point_'+point_value;
           if($('#'+target_value).val() !=0 ){
             let present_target_value=parseInt($('#'+target_value).val())+1;
                 $('#'+target_value).val(present_target_value);
        }else{
              let present_target_value=1;
            $('#'+target_value).val(present_target_value);
        }
    }else{
        swal('warning','Please Select Code Before add points','warning');

    }
  }
  function deletePoints(points_id){
     let point_value=points_id.split("_")[1];
    if($(".activate_code").text()){
        let code_value=$(".activate_code").text();
            let target_value=code_value+'_point_'+point_value;
             if($('#'+target_value).val() !=0 ){
           let present_target_value=parseInt($('#'+target_value).val())-1;
           $('#'+target_value).val(present_target_value);
              }else{
            let ponts_array=[1,2,3,4];
                let new_array=ponts_array.filter((elem)=>{if(elem!=point_value)return elem;}  );
            sum=0;
                    new_array.forEach(element => {
                let target_value=code_value+'_point_'+element;
                   sum=parseInt($('#'+target_value).val())+sum;
                   });
               if(sum==0){
                   let table_row_id_tobe_removed="output_newrow_"+code_value;
               $('table#points_tbl tr#'+table_row_id_tobe_removed).remove();
                  $("table#rejection_code_table tbody tr#"+code_value+" td:first-child").removeClass("activate_code");
                      $("table#rejection_code_table tbody tr#"+code_value+" td:eq(1)").removeClass("selected");
                    }else{
              swal('warning','Please Clear All Other points if You want to delete it','warning');
            }   
                 }
    }   else{
        
        swal('warning','Please Select Code Before Remove points','warning');
    }
  }
  
</script>
</head>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/config.php', 4, 'R'));
include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/functions.php', 4, 'R'));
$plant_code = $_SESSION['plantCode'];
$username = $_SESSION['userName'];
echo "<input type='hidden' name='reject_reasons' id='reject_reasons'>";
if (isset($_GET['parent_id']) or isset($_POST['parent_id'])) {
    $parent_id = $_GET['parent_id'] or $_POST['parent_id'];
    $store_id = $_GET['store_id'] or $_POST['store_id'];
    $plant_code = $_GET['plant_code'] or $_POST['plant_code'];
    $username = $_GET['username'] or $_POST['username'];
   echo "<input type='hidden' value= $store_id id='four_point_store_id'>";
}
$sno_points = $store_id;
$get_inspection_population_info = "select * from $wms.`roll_inspection_child` where store_in_tid=$store_id and plant_code='".$plant_code."'";

$info_result = mysqli_query($link, $get_inspection_population_info) or exit("get_details Error--1" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($row22 = mysqli_fetch_array($info_result)) {

    
    $inspected_per = $row22['inspected_per'];
    $inspected_qty = $row22['inspected_qty'];
    $width_s = $row22['width_s'];
    $width_m = $row22['width_m'];
    $width_e = $row22['width_e'];
    $actual_height = $row22['actual_height'];
    $actual_repeat_height = $row22['actual_repeat_height'];
    $skw = $row22['skw'];
    $bow = $row22['bow'];
    $ver = $row22['ver'];
    $gsm = $row22['gsm'];
    $comment = $row22['comment'];
    $marker_type = $row22['marker_type'];
    $inspection_status = $row22['inspection_status'];
}

$get_details = "select * from $wms.`inspection_population` where store_in_id=$store_id and plant_code='".$plant_code."'";

$details_result = mysqli_query($link, $get_details) or exit("get_details Error--2" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($row1 = mysqli_fetch_array($details_result)) {
    $invoice = $row1['supplier_invoice'];
    $batch = $row1['supplier_batch'];
    $po = $row1['supplier_po'];
    $item_code = $row1['item_code'];
    $item_desc = $row1['item_desc'];
    $item_name = $row1['item_name'];
    $color = $row1['rm_color'];
    $sfcs_roll = $row1['sfcs_roll_no'];
    $supp_roll = $row1['supplier_roll_no'];
    $lot_no = $row1['lot_no'];
    $invoice_qty = $row1['rec_qty'];    
    if($row1['status']==1)
    {
        $status='Pending';
    }
    elseif($row1['status']==2)
    {
        $status='In Progress';
    }    
    elseif($row1['status']==3)
    {
        $status='Completed';
    }       
}

$get_details1 = "select * from $wms.`main_population_tbl` where id=$parent_id and plant_code='".$plant_code."'";
$details_result1 = mysqli_query($link, $get_details1) or exit("get_details Error--3" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($row111 = mysqli_fetch_array($details_result1)) 
{
    $fabric_composition = $row111['fab_composition'];
    $spec_width = $row111['s_width'];   
    $repeat_length = $row111['repeat_len'];
    $spec_weight = $row111['s_weight'];
    $lab_testing = $row111['lab_testing'];
    $tolerance = $row111['tolerence'];
    $remarks = $row111['remarks'];
}

$get_supplier_name = "select supplier from $wms.sticker_report where batch_no='$batch' and plant_code='".$plant_code."'";
$supplier_result = mysqli_query($link, $get_supplier_name) or exit("get_supplier_name Error--4" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($row1112 = mysqli_fetch_array($supplier_result))
{
   $supplier = $row1112['supplier'];
}

?>
<div class="container-fluid">
    <div class="panel panel-primary">
        <div class="panel-heading">4 Point Roll Inspection Update</div>
         <div class="panel-body">
            <div class="container">
                <div style="float: right;">
                    <?php
                    echo "<a class=\"btn btn-xs btn-warning pull-left\" href=\"" . getFullURLLevel($_GET['r'], "4_point_roll_inspection.php", "0", "N") . "&parent_id=$parent_id\"><<<< Click here to Go Back</a>";
                    ?>
                </div>
                <form id='myForm' method='post' name='input_main'>
                <div class="table-responsive col-sm-12">
                <div class="panel panel-primary">
                <div class="panel-heading">4 Point Header Information</div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr style="background-color: antiquewhite;">
                                <th>Invoice #</th>
                                <th>Color</th>
                                <th>Batch</th>
                                <th>PO#</th>
                                <th>Lot No</th>
                            </tr>
                            <tr>
                                <?php
                            echo "<td>$invoice</td> 
                                <td>$color</td>
                                <td>$batch</td>
                                <td>$po</td>
                                <td>$lot_no</td>";
                                ?>
                            </tr>
                        </tbody>
                    </table>
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
                                    <td><input type="text" id="fabric_composition" name="fabric_composition" autocomplete="off" autocomplete="off" value="<?= $fabric_composition ?>" <?php if ($fabric_composition)   ?>></td>
                                    <td rowspan="2"><input type="text" id="tolerance" name="tolerance" value="<?= $tolerance ?>" <?php if ($tolerance)   ?>></td>
                                </tr>
                                <tr>
                                    <td>Inspection Status</td>
                                    <td>
                                        <!-- <select name="inspection_status" id="inspection_status">
                                            <option value="" selected>Select Status</option>
                                            <option value="Approved" <?php if ($inspection_status == "Approved") echo "selected" ?>>Approved</option>
                                            <option value="Rejected" <?php if ($inspection_status == "Rejected") echo "selected" ?>>Rejected</option>
                                            <option value="Partial Rejected" <?php if ($inspection_status == "Partial Rejected") echo "selected" ?>>Partial Rejected</option>
                                        </select> -->
                                        <?php 
                                        echo '<b>'.$status.'</b>';
                                        echo '<input type="hidden" id="status"  name="status" value="'.$status.'">';
                                        ?>
                                    </td>
                                </tr>
                                <tr style="background-color: antiquewhite;">
                                    <th style=text-align:center colspan="3">Spec Details</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="3">Remarks</td>
                                </tr>
                                <tr>
                                   <td>Supplier Name</td>
                                    <td> <?php echo $supplier?></td> 
                                </tr>   
                                <tr>
                                    <td>Spec Width</td>
                                    <td><input type="text" id="spec_width" name="spec_width" autocomplete="off" value="<?= $spec_width ?>" <?php if ($spec_width)   ?> class="float"></td>

                                   <td rowspan="2"><textarea id="remarks" name="remarks" class="form-control" style="min-width: 100%;min-height: 80px" ><?php echo $remarks ?> <?php if ($remarks)?></textarea>
                                </tr>
                                <tr>
                                    <td>Spec Weight</td>
                                    <td><input type="text" id="spec_weight" name="spec_weight" autocomplete="off" value="<?= $spec_weight ?>" <?php if ($spec_weight)  ?> class="float"></td>
                                    <!-- <td><input type="text" id="tolerance" name="tolerance"></td> -->
                                </tr>
                                <tr>
                                    <td>Repeat Length</td>
                                    <td><input type="text" id="repeat_length" name="repeat_length" autocomplete="off" value="<?= $repeat_length ?>" <?php if ($repeat_length)   ?> class="float"></td>
                                    <!-- <td><input type="text" id="tolerance" name="tolerance"></td> -->
                                </tr>
                                <tr style="background-color: antiquewhite;">
                                    <th style=text-align:center colspan=3>Inspection Summary</th>
                                </tr>
                                <tr>
                                    <td>Lab Testing</td>
                                    <td><input type="text" id="lab_testing" name="lab_testing" autocomplete="off" value="<?= $lab_testing ?>" <?php if ($lab_testing)   ?>></td>
                                    <!-- <td rowspan="2"><input type="text" id="tolerance" name="tolerance"></td> -->
                                </tr>
                            </tbody>
                        </table>
                            </div>
                        </div>
                    </div>
            <div class="table-responsive col-sm-12">
            <div class="panel panel-primary">
              <div class="panel-heading">4 Point Roll Information</div>
                <div class="panel-body">
				<div class="table-responsive col-sm-12">
                        <table class="table table-bordered">
                            <tbody>
                                <tr style="background-color: antiquewhite;">
                                    <th>Supplier Roll No</th>
                                    <th>SFCS Roll No</th>
                                    <th>Item Code</th>
                                    <th>Color</th>
                                    <th>Description</th>
                                    <th>Item Name</th>
                                    <th>Lot No</th>
                                    <th>Qty</th>
                                    <th>Num of Points</th>
                                    <th>Roll Inspection Status</th>
                                </tr>

                                <?php

                                echo
                                    "<tr>
                                <td>" . $supp_roll . "</td>
                                <td>" . $sfcs_roll . "</td>
                                <td>" . $item_code . "</td>
                                <td>" . $color . "</td>
                                <td>" . $item_desc . "</td>
                                <td>" . $item_name . "</td>
                                <td>" . $lot_no . "</td>
                                <td>" . $invoice_qty . "</td>";
                                if($sno_points>0)
                                {
                                    $get_status_details = "select sum(points) as points from $wms.four_points_table where insp_child_id = ".$sno_points." and plant_code='".$plant_code."'";
                                    //echo $get_status_details;
                                    $status_details_result = mysqli_query($link, $get_status_details) or exit("get_status_details Error--5" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                    if(mysqli_num_rows($status_details_result)>0)
                                    {
                                        while ($row5 = mysqli_fetch_array($status_details_result)) 
                                        {
                                            $main_points = $row5['points'];
                                        }
                                    }
                                    else
                                    {
                                        $main_points=0; 
                                    }   
                                }
                                else
                                {
                                    $main_points=0; 
                                }   
                                echo "
                                <td>" . $main_points . "</td>
                                <td>" . $status . "</td>
                               </tr>";
                                
                                ?>
                            </tbody>
                        </table>
                       </div>
                    <div class="table-responsive col-sm-12">
                        <table class="table table-bordered">
                            <tbody>

                                <tr style="background-color: antiquewhite;">
                                    <th rowspan="2">Item Code</th>
                                    <th rowspan="2">Roll No</th>
                                    <th rowspan="2">Inspected %</th>
                                    <th rowspan="2">Inspected Qty</th>
                                    <th rowspan="2">Ticket Length</th>
                                    <th style=text-align:center colspan=3>Width(cm)</th>
                                    <th rowspan="2">Actual Weight</th>
                                    <th rowspan="2">Actual Repeat Length</th>
                                    <th rowspan="2">SKW</th>
                                    <th rowspan="2">BOW</th>
                                    <th rowspan="2">Ver</th>
                                    <th rowspan="2">GSM(s/sqm)</th>
                                    <th rowspan="2">Comments</th>
                                    <th rowspan="2">Marker Type</th>
                                </tr>
                                <tr style="background-color: antiquewhite;">
                                <th><center>S</center></th>
                                <th><center>M</center></th>
                                <th><center>E</center></th>
                                </tr>
                                <tr>
                                    <td><input type="hidden" id="item_code" name="item_code" autocomplete="off" value="<?= $item_code ?>"><?php echo $item_code; ?></td>
                                    <td><input type="hidden" id="roll_no" name="roll_no" autocomplete="off" value="<?= $sfcs_roll ?>"><?php echo $sfcs_roll; ?></td>
                                    <td><input type="text" id="inspected_per" name="inspected_per" size="4" autocomplete="off" value="<?= $inspected_per ?>" <?php if ($inspected_per)   ?> class="float"></td>
                                    <td><input type="text" id="inspected_qty" name="inspected_qty" size="4" autocomplete="off" value="<?= $inspected_qty ?>" <?php if ($inspected_qty)   ?> class="float"></td>
                                    <td><input type="hidden" id="invoice_qty" name="invoice_qty" autocomplete="off" value="<?= $invoice_qty ?>" class="float"><?php echo $invoice_qty; ?></td><td>
                                       <input type="text" id="s" size="4" name="s" id="s" colspan=3 autocomplete="off" value="<?= $width_s ?>" <?php if ($width_s)   ?> class="float" required>
                                    </td>
                                    <td>
                                       <input type="text" id="m" size="4" name="m" id="m" colspan=3 autocomplete="off" value="<?= $width_m ?>" <?php if ($width_m)   ?> class="float" required>
                                    </td>
                                    <td>
                                        <input type="text" id="e" size="4" name="e" id="e" colspan=3 autocomplete="off" value="<?= $width_e ?>" <?php if ($width_e)   ?> class="float" required>
                                    </td>
                                    <td><input type="text" id="actual_height" size="4" name="actual_height" autocomplete="off" value="<?= $actual_height ?>" <?php if ($actual_height)   ?> class="float"></td>
                                    <td><input type="text" id="actual_repeat_height" size="4" autocomplete="off" name="actual_repeat_height" value="<?= $actual_repeat_height ?>" <?php if ($actual_repeat_height)   ?> class="float"></td>
                                    <td><input type="text" id="skw" size="4" name="skw" autocomplete="off" value="<?= $skw ?>" <?php if ($skw)   ?>></td>
                                    <td><input type="text" id="bow" size="4"  name="bow" autocomplete="off" value="<?= $bow ?>" <?php if ($bow)   ?>></td>
                                    <td><input type="text" id="ver" size="4" name="ver" autocomplete="off" value="<?= $ver ?>" <?php if ($ver)   ?>></td>
                                    <td><input type="text" id="gsm" size="4" name="gsm" autocomplete="off" value="<?= $gsm ?>" <?php if ($gsm)   ?>></td>
                                    <td><input type="text" id="comment" name="comment" autocomplete="off" value="<?= $comment ?>" <?php if ($comment)   ?>></td>
                                    <td><input type="text" id="marker_type" name="marker_type" autocomplete="off" value="<?= $marker_type ?>" <?php if ($marker_type)   ?>></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
    <div class="form-inline col-sm-12">
        <div class="table-responsive col-sm-5">
            <div class="col-sm-8">
            <input id="myInput" type="text" placeholder="Search.." autocomplete="off" style="margin-top:18px;">
            <div class="tableFixHead">
            <table class="tableBodyScroll table table-bordered" id="rejection_code_table" style="margin-top:2px;">
                <thead>
                    <tr style="background-color: antiquewhite;">
                        <th>Code</th>
                        <th>Damage Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $select_resons = "select * from $wms.`reject_reasons`";
                        $get_reasons = mysqli_query($link, $select_resons) or exit("get_parent_id Error--6" .mysqli_error($GLOBALS["___mysqli_ston"]));

                        while ($row122 = mysqli_fetch_array($get_reasons)) 
                        {
                            $reject_code = $row122['reject_code'];
                            $reject_desc = $row122['reject_desc'];
                            $num_rows = mysqli_num_rows($get_reasons);
                            if($num_rows>=1)
                            {
                                echo '<tr id="'.$reject_code.'"><td>'.$reject_code.'</td>
                                <td>'.$reject_desc.'</td></tr>';        
                            }
                        }
                    ?>
                </tbody>
            </table>  
            </div>
        </div>     
    <div class="table-responsive col-sm-4">
            <table class="table table-bordered" id="add_remove_button_table" style="margin-top: 48px;">
                <thead>
                    <tr style="background-color: antiquewhite;">
                        <th>Controlles</th>    
                    </tr>
                </thead>
                <tbody>
                    <?php for($i=1;$i<=4;$i++)
                    {
                        echo '<tr><td>
                        <div style="display:flex"><span class="btn btn-xs btn-default" data-toggle="tooltip" title="Click here to delete '.$i.' Point" id="delete_'.$i.'" onclick="deletePoints(this.id);"><span class="glyphicon glyphicon-remove-circle" style="color:red"></span></span>
                        <span class="btn btn-xs btn-default" id="adding_'.$i.'" onclick="addFourPoints(this.id);">
                        <span class="badge" style="background-color:blue;color:white">'.$i.'</span><span class="glyphicon glyphicon-share-alt"></span>
                        </span>
                        </div>                                  
                        </td></tr>';
                    }
                    ?>
                </tbody>
            </table>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                      <td><button type="sumbit" class="btn btn-xs btn-primary save-confirm-data" name="save" id="save">Save</button></td>
                    </tr>
                    <tr>
                        <td><input type = "checkbox" id="check_true">
                        <button type="sumbit" class="btn btn-xs btn-primary save-confirm-data" name="confirm" id="confirm"  disabled = 'disabled'>Confirm</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
            <div class="table-responsive col-sm-7">
                <table class="table table-bordered" id="points_tbl" style="margin-top: 48px;">
                    <thead>
                        <tr style="background-color: antiquewhite;">
                            <th>Code</th>
                            <th>Damage Des</th>
                            <th>1 Point</th>
                            <th>2 Point</th>
                            <th>3 Point</th>
                            <th>4 Point</th>
                        </tr>
                    </thead>
                    <tbody>
                    <input type="hidden" value="" name="hidenMaxCount" id="hidenMaxCount">
                    <?php
                        $select_four_points = "SELECT GROUP_CONCAT(selected_point) AS selcted_points,GROUP_CONCAT(points) AS points,code,description  FROM $wms.`four_points_table` WHERE insp_child_id='". $sno_points."' and plant_code='".$plant_code."' GROUP BY CODE ";
                        $fourpoints_result = mysqli_query($link, $select_four_points) or exit("get_parent_id Error--12" . mysqli_error($GLOBALS["___mysqli_ston"]));
                        $num_rows = mysqli_num_rows($fourpoints_result);

                        if($num_rows > 0) 
                        {
                            $tr='';
                            while ($row44 = mysqli_fetch_assoc($fourpoints_result)) 
                            { 
                                $code=$row44['code'];
                                $description=$row44['description'];
                                $selected_points_array=explode(",",$row44['selcted_points']);
                                $order_array=array("1"=>"1","2"=>"2","3"=>"3","4"=>"4");
                                $points_array=explode(",",$row44['points']);
                                
                                $tr.='<tr id="output_newrow_'.$code.'"><td><input type="hidden" value="0" name="submit_value_point[]"><input type="text" size="2" class="code" name="code[]" id="code_'.$code.'" value="'.$code.'" readonly></td><td><input type="text" class="damage" value="'.$description.'" name="damage[]" size="11" readonly></td>';
                                foreach ($order_array as $key => $value) 
                                {
                                   $selected_points_index=array_search($value,$selected_points_array);
                                
                                   if(gettype($selected_points_index)!=boolean)
                                    {
                                        $point_value=$points_array[$selected_points_index]/$selected_points_array[$selected_points_index];
                                        
                                        $tr.='<td><input id="'.$code.'_point_'.$value.'" value="'.$point_value.'" type="text" name="point_'.$value.'" size="2" readonly></td>';
                                    }
                                    else
                                    {
                                      $tr.='<td><input id="'.$code.'_point_'.$value.'" value="0" type="text"            name="point_'.$value.'" size="2" readonly></td>';
                                    }
                                }
                                $tr.='</tr>';
                            }
                            echo $tr;
                        }
                       
                    ?>
                    <tr></tr>
                    </tbody>
                </table>
            </div>
        </div>  
                 <input type="hidden" name="parent_id" value='<?= $parent_id ?>'>
                </form>
                    </div>
                </div>
                            </div>
                      </div>
                  </div>
             </div>
        </div> 
    </div>
</div>
<?php
    $path = getFullURLLevel($_GET['r'], "submit.php", "0", "R");
?>

<?php
if (isset($_POST['confirm'])) {
    
    $parent_id = $_POST['parent_id'];
    $fabric_composition = $_POST['fabric_composition'];
    if ($fabric_composition == '') {
        $fabric_composition = 0;
    } else {
        $fabric_composition;
    }

    $spec_width = $_POST['spec_width'];
    if ($spec_width == '') {
        $spec_width = 0;
    } else {
        $spec_width;
    }

    $inspection_status = $_POST['status'];

    $spec_weight = $_POST['spec_weight'];
    if ($spec_weight == '') {
        $spec_weight = 0;
    } else {
        $spec_weight;
    }

    $repeat_length = $_POST['repeat_length'];
    if ($repeat_length == '') {
        $repeat_length = 0;
    } else {
        $repeat_length;
    }

    $lab_testing = $_POST['lab_testing'];
    if ($lab_testing == '') {
        $lab_testing = 0;
    } else {
        $lab_testing;
    }

    $tolerance = $_POST['tolerance'];
    if ($tolerance == '') {
        $tolerance = 0;
    } else {
        $tolerance;
    }

    $remarks = $_POST['remarks'];
    if ($remarks == '') {
        $remarks = 'null';
    } else {
        $remarks;
    }

    $inspected_per = $_POST['inspected_per'];
    if ($inspected_per == '') {
        $inspected_per = 0;
    } else {
        $inspected_per;
    }

    $inspected_qty = $_POST['inspected_qty'];
    if ($inspected_qty == '') {
        $inspected_qty = 0;
    } else {
        $inspected_qty;
    }
    
    $s = $_POST['s'];
    if ($s == '') {
        $s = 0;
    } else {
        $s;
    }

    $m = $_POST['m'];
    if ($m == '') {
        $m = 0;
    } else {
        $m;
    }

    $e = $_POST['e'];
    if ($e == '') {
        $e = 0;
    } else {
        $e;
    }

    $actual_height = $_POST['actual_height'];
    if ($actual_height == '') {
        $actual_height = 0;
    } else {
        $actual_height;
    }

    $actual_repeat_height = $_POST['actual_repeat_height'];
    if ($actual_repeat_height == '') {
        $actual_repeat_height = 0;
    } else {
        $actual_repeat_height;
    }

    $skw = $_POST['skw'];
    if ($skw == '') {
        $skw = 0;
    } else {
        $skw;
    }

    $bow = $_POST['bow'];
    if ($bow == '') {
        $bow = 0;
    } else {
        $bow;
    }

    $ver = $_POST['ver'];
    if ($ver == '') {
        $ver = 0;
    } else {
        $ver;
    }

    $gsm = $_POST['gsm'];
    if ($gsm == '') {
        $gsm = 0;
    } else {
        $gsm;
    }

    $comment = $_POST['comment'];
    if ($comment == '') {
        $comment = 0;
    } else {
        $comment;
    }

    $marker_type = $_POST['marker_type'];
    if ($marker_type == '') {
        $marker_type = 0;
    } else {
        $marker_type;
    }

    if (isset($_POST['code'])!='' || isset($_POST['code'])=='') {
        $code = $_POST['code'];
        $count = count($code);
        $damage = $_POST['damage'];
        
        $sql_rows="update $wms.main_population_tbl set fab_composition='" . $fabric_composition . "',s_width='" . $spec_width . "',s_weight='" . $spec_weight . "',repeat_len='" . $repeat_length . "',lab_testing='" . $lab_testing . "',tolerence='" . $tolerance . "',remarks='" . $remarks . "',updated_user= '".$username."',updated_at=NOW() where id=".$parent_id." and plant_code='".$plant_code."'";
        mysqli_query($link, $sql_rows) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));
        
        $id_parent = $parent_id;

        $check_store_tid = "select sno from $wms.roll_inspection_child where store_in_tid='" . $store_id . "' and plant_code='".$plant_code."'";
        $details_check_store_tid = mysqli_query($link, $check_store_tid) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $row_sid = mysqli_num_rows($details_check_store_tid);
        $row_store_tid = mysqli_fetch_array($details_check_store_tid);
        if ($row_sid == 1) 
        {            
            $update_status_insp = "update $wms.roll_inspection_child SET inspection_status='" . $status . "',inspected_per='" . $inspected_per . "',inspected_qty='" . $inspected_qty . "',width_s='" . $s . "',width_m='" . $m . "',width_e='" . $e . "',actual_height='" . $actual_height . "',actual_repeat_height='" . $actual_repeat_height . "',skw='" . $skw . "',bow='" . $bow . "',ver='" . $ver . "',gsm='" . $gsm . "',comment='" . $comment . "',marker_type='" . $marker_type . "',status = '3',updated_user= '".$username."',updated_at=NOW() where store_in_tid='".$store_id."' and plant_code='".$plant_code."'";
            $roll_inspection_update = $link->query($update_status_insp) or exit('query error in updating222');
            
            $update_status = "update $wms.inspection_population SET status=3,updated_user= '".$username."',updated_at=NOW() where store_in_id='" . $store_id . "' and plant_code='".$plant_code."'";
            $result_query_update = $link->query($update_status) or exit('query error in updating2221');
            
            $roll_id = $store_id;
           
            $array_point_size=sizeof($_POST['submit_value_point']);
            if($array_point_size>0)
            {
                $arraVal = [];
                $i=0;
                for($points=0;$points<=$_POST['hidenMaxCount'];$points++)
                {                    
                    if(array_key_exists("point_".$points."", $_POST))
                    {
                        $flag_var = $_POST["point_".$points.""];
                        $arraVal[] = $flag_var;
                        if($flag_var!='')
                        {
                            $insert_four_points = "insert ignore into $wms.four_points_table(insp_child_id,code,description,points,plant_code,created_user) values('$roll_id','".$code[$i]."','".$damage[$i]."',$flag_var,'".$plant_code."','".$username."')";
                            mysqli_query($link, $insert_four_points) or exit("third ErrorError-2" . mysqli_error($GLOBALS["___mysqli_ston"]));
                            $i++;
                        }
                        $flag_var=0;
                    }
                }    
            }                 
        }
        else 
        {
            $insert_query = "insert into $wms.roll_inspection_child(inspection_status,inspected_per,inspected_qty,width_s,width_m,width_e,actual_height,actual_repeat_height,skw,bow,ver,gsm,comment,marker_type,parent_id,status,store_in_tid,plant_code,created_user) values ('$status','$inspected_per','$inspected_qty','$s','$m','$e','$actual_height','$actual_repeat_height','$skw','$bow','$ver','$gsm','$comment','$marker_type','$id_parent','3','$store_id','".$plant_code."','".$username."')";
            $result_query = $link->query($insert_query) or exit('query error in inserting111112');
            $roll_id = $store_id;
            
            $array_point_size=sizeof($_POST['submit_value_point']);
            if($array_point_size>0)
            {
                $arraVal = [];
                $i=0;
                for($points=0;$points<=$_POST['hidenMaxCount'];$points++)
                {                    
                    if(array_key_exists("point_".$points."", $_POST))
                    {
                        $flag_var = $_POST["point_".$points.""];
                        $arraVal[] = $flag_var;
                        if($flag_var!='')
                        {
                            $insert_four_points = "insert ignore into $wms.four_points_table(insp_child_id,code,description,points,plant_code,created_user) values('$roll_id','".$code[$i]."','".$damage[$i]."',$flag_var,'".$plant_code."','".$username."')";
                            mysqli_query($link, $insert_four_points) or exit("third ErrorError-2" . mysqli_error($GLOBALS["___mysqli_ston"]));
                            $i++;
                        }
                        $flag_var=0;
                    }
                }    
            }
            $update_status = "update $wms.inspection_population SET status=3,updated_user= '".$username."',updated_at=NOW() where store_in_id='" . $store_id . "' and plant_code='".$plant_code."'";
            $result_query_update = $link->query($update_status) or exit('query error in updating222');
        }
        echo "<script>swal('Confirmation Updated..','Successfully','success')</script>";
        $url = getFullURLLevel($_GET['r'], '4_point_roll_inspection.php', 0, 'N');
        echo "<script>location.href = '" . $url . "&parent_id=$parent_id'</script>";
    }
}

?>
<?php
if (isset($_POST['save'])) {
    
    $code = $_POST['code'];
    $count = count($code);
    
    $parent_id = $_POST['parent_id'];
    $fabric_composition = $_POST['fabric_composition'];
    if ($fabric_composition == '') {
        $fabric_composition = 0;
    } else {
        $fabric_composition;
    }

    $spec_width = $_POST['spec_width'];
    if ($spec_width == '') {
        $spec_width = 0;
    } else {
        $spec_width;
    }

    $inspection_status = $_POST['status'];

    $spec_weight = $_POST['spec_weight'];
    if ($spec_weight == '') {
        $spec_weight = 0;
    } else {
        $spec_weight;
    }

    $repeat_length = $_POST['repeat_length'];
    if ($repeat_length == '') {
        $repeat_length = 0;
    } else {
        $repeat_length;
    }

    $lab_testing = $_POST['lab_testing'];
    if ($lab_testing == '') {
        $lab_testing = 0;
    } else {
        $lab_testing;
    }

    $remarks = $_POST['remarks'];
    if ($remarks == '') {
        $remarks = 'null';
    } else {
        $remarks;
    }

    $tolerance = $_POST['tolerance'];
    if ($tolerance == '') {
        $tolerance = 0;
    } else {
        $tolerance;
    }

    $inspected_per = $_POST['inspected_per'];
    if ($inspected_per == '') {
        $inspected_per = 0;
    } else {
        $inspected_per;
    }

    $inspected_qty = $_POST['inspected_qty'];
    if ($inspected_qty == '') {
        $inspected_qty = 0;
    } else {
        $inspected_qty;
    }
    
    $s = $_POST['s'];
    if ($s == '') {
        $s = 0;
    } else {
        $s;
    }

    $m = $_POST['m'];
    if ($m == '') {
        $m = 0;
    } else {
        $m;
    }

    $e = $_POST['e'];
    if ($e == '') {
        $e = 0;
    } else {
        $e;
    }

    $actual_height = $_POST['actual_height'];
    if ($actual_height == '') {
        $actual_height = 0;
    } else {
        $actual_height;
    }

    $actual_repeat_height = $_POST['actual_repeat_height'];
    if ($actual_repeat_height == '') {
        $actual_repeat_height = 0;
    } else {
        $actual_repeat_height;
    }

    $skw = $_POST['skw'];
    if ($skw == '') {
        $skw = 0;
    } else {
        $skw;
    }

    $bow = $_POST['bow'];
    if ($bow == '') {
        $bow = 0;
    } else {
        $bow;
    }

    $ver = $_POST['ver'];
    if ($ver == '') {
        $ver = 0;
    } else {
        $ver;
    }

    $gsm = $_POST['gsm'];
    if ($gsm == '') {
        $gsm = 0;
    } else {
        $gsm;
    }

    $comment = $_POST['comment'];
    if ($comment == '') {
        $comment = 0;
    } else {
        $comment;
    }

    $marker_type = $_POST['marker_type'];
    if ($marker_type == '') {
        $marker_type = 0;
    } else {
        $marker_type;
    }

    if (isset($_POST['code'])!='' || isset($_POST['code'])=='') {
        $code = $_POST['code'];
        $count = count($code);
        
        $damage = $_POST['damage'];
        
        $sql_rows="update $wms.main_population_tbl set fab_composition='" . $fabric_composition . "',s_width='" . $spec_width . "',s_weight='" . $spec_weight . "',repeat_len='" . $repeat_length . "',lab_testing='" . $lab_testing . "',tolerence='" . $tolerance . "',remarks='" . $remarks . "',updated_user= '".$username."',updated_at=NOW() where id=".$parent_id." and plant_code='".$plant_code."'";
        mysqli_query($link, $sql_rows) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));
        
        $id_parent = $parent_id;

        $check_store_tid = "select sno from $wms.roll_inspection_child where store_in_tid='" . $store_id . "' and plant_code='".$plant_code."'";
        $details_check_store_tid = mysqli_query($link, $check_store_tid) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $row_sid = mysqli_num_rows($details_check_store_tid);
        $row_store_tid = mysqli_fetch_array($details_check_store_tid);
        if ($row_sid >0) 
        {   
            $update_status_insp = "update $wms.roll_inspection_child SET inspection_status='" . $status . "',inspected_per='" . $inspected_per . "',inspected_qty='" . $inspected_qty . "',width_s='" . $s . "',width_m='" . $m . "',width_e='" . $e . "',actual_height='" . $actual_height . "',actual_repeat_height='" . $actual_repeat_height . "',skw='" . $skw . "',bow='" . $bow . "',ver='" . $ver . "',gsm='" . $gsm . "',comment='" . $comment . "',marker_type='" . $marker_type . "',status = '2',updated_user= '".$username."',updated_at=NOW() where store_in_tid='".$store_id."' and plant_code='".$plant_code."'";
            $roll_inspection_update = $link->query($update_status_insp) or exit('query error in updating222---3');
            
            $update_status = "update $wms.inspection_population SET status=2,updated_user= '".$username."',updated_at=NOW() where store_in_id='" . $store_id . "' and plant_code='".$plant_code."'";
            $result_query_update = $link->query($update_status) or exit('query error in updating2221---21');
            $roll_id = $store_id;
        
            $array_point_size=sizeof($_POST['submit_value_point']);
          
            if($array_point_size>0)
            {   
                $arraVal = [];
                $i=0;
                for($points=0;$points<=$_POST['hidenMaxCount'];$points++)
                {
                    if(array_key_exists("point_".$points."", $_POST))
                    {                      
                        $flag_var = $_POST["point_".$points.""];                
                        $arraVal[] = $flag_var;                
                        if($flag_var!='')
                        {
                            $insert_four_points = "insert ignore into $wms.four_points_table(insp_child_id,code,description,points,plant_code,created_user) values('$roll_id','".$code[$i]."','".$damage[$i]."',$flag_var,'".$plant_code."','".$username."')";
                            mysqli_query($link, $insert_four_points) or exit("third ErrorError-2" . mysqli_error($GLOBALS["___mysqli_ston"]));
                            $i++;
                        }
                        $flag_var=0;                
                    }                
                }        
        }
        }
        else 
        {
            $insert_query = "insert into $wms.roll_inspection_child(inspection_status,inspected_per,inspected_qty,width_s,width_m,width_e,actual_height,actual_repeat_height,skw,bow,ver,gsm,comment,marker_type,parent_id,status,store_in_tid,plant_code,created_user) values ('$status','$inspected_per','$inspected_qty','$s','$m','$e','$actual_height','$actual_repeat_height','$skw','$bow','$ver','$gsm','$comment','$marker_type','$id_parent','2','$store_id','".$plant_code."','".$username."')";
            // echo $insert_query;
            $result_query = $link->query($insert_query) or exit('query error in inserting111113');
            $roll_id = $store_id;
            $array_point_size=sizeof($_POST['submit_value_point']);
            if($array_point_size>0)
            {
                $arraVal = [];
                $i=0;
                for($points=0;$points<=$_POST['hidenMaxCount'];$points++)
                {                    
                    if(array_key_exists("point_".$points."", $_POST))
                    {
                    $flag_var = $_POST["point_".$points.""];
                    $arraVal[] = $flag_var;
                    if($flag_var!='')
                    {
                        $insert_four_points = "insert ignore into $wms.four_points_table(insp_child_id,code,description,points,plant_code,created_user) values('$roll_id','".$code[$i]."','".$damage[$i]."',$flag_var,'".$plant_code."','".$username."')";
                        mysqli_query($link, $insert_four_points) or exit("third ErrorError-2" . mysqli_error($GLOBALS["___mysqli_ston"]));
                        $i++;
                    }
                    $flag_var=0;
                    }
                }    
            }
            $update_status = "update $wms.inspection_population SET status=2,updated_user= '".$username."',updated_at=NOW() where store_in_id='" . $store_id . "' and plant_code='".$plant_code."'";
            $result_query_update = $link->query($update_status) or exit('query error in updating222---');
        }
    
        echo "<script>swal('Data Updated..','Successfully','success')</script>";
        $url = getFullURLLevel($_GET['r'], '4_point_roll_inspection.php', 0, 'N');
        echo "<script>location.href = '" . $url . "&parent_id=$parent_id'</script>";
        die();
    }
    
}

?>

<script type='text/javascript'>

$(document).ready(function() {

  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#rejection_code_table tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  $("#s").keyup(function(){
       var x=$("#s").val();
       if(x==0&x!='')
       {
        swal('warning','S Value should be greater than zero','warning');
        $("#s").val('');
       }
     });

     $("#m").keyup(function(){
       var x=$("#m").val();
       if(x==0&x!='')
       {
        swal('warning','M Value should be greater than zero','warning');
        $("#m").val('');
       }
     });

     $("#e").keyup(function(){
       var x=$("#e").val();
       if(x==0&x!='')
       {
        swal('warning','E Value should be greater than zero','warning');
        $("#e").val('');
       }
    });
    $('#check_true').click(function() {
        if ($(this).is(':checked')) 
        {
            $('#confirm').removeAttr('disabled');
        } else 
        {
             $('#confirm').attr('disabled', 'disabled');
        }
        });

        $('#inspected_per').keyup(function(){
			  if ($(this).val() > 100)
              {
				swal('warning','Enter only below 100%','warning');
				$(this).val('');
			  }
			});

			$('#inspected_qty').change(function(){
				
				var invoice_q= $("#invoice_qty").val();
				if (invoice_q < $(this).val()){
					swal('warning','Inspected Qty Should be less than Ticket Length','warning');
					$(this).val('');
				 }
			});

$("#rejection_code_table tbody tr").click(function() {
        if($(this).find('td:eq(1)').hasClass('selected')){
            $("#rejection_code_table tbody tr td:first-child").removeClass("activate_code");
              $(this).find('td:first').addClass("activate_code");
        }else{
            $(this).find('td:eq(1)').addClass('selected');
               $("#rejection_code_table tbody tr td:first-child").removeClass("activate_code");
            $(this).find('td:first').addClass("activate_code");
        }
        let code_id=$(this).find('td:first').html();
           let code_desc=$(this).find('td:eq(1)').html();
              addTableRow(code_id,code_desc);
//}

});   
   
function addTableRow(codeId,codeDesc){
        let new_row='<tr id="output_newrow_'+ codeId+'"><td><input type="hidden" value="0" name="submit_value_point[]" readonly><input type="text" size="2" class="code" name="code[]" id="code_'+ codeId+'" value="'+codeId+'" readonly></td><td><input type="text" class="damage" size="11" value="'+codeDesc+'" name="damage[]" readonly></td><td><input id="'+codeId+'_point_1" value="0" type="text" name="point_1" size="2" readonly></td><td><input type="text" name="point_2" id="'+codeId+'_point_2" size="2" value="0" readonly></td><td><input id="'+codeId+'_point_3" type="text" name="point_3" size="2" value="0" readonly></td><td><input type="text" id="'+codeId+'_point_4" name="point_4" size="2" value="0" readonly></td></tr>';
         if(isExist(codeId)){
             //alert('')
            }else {
              $('#points_tbl tbody tr:last').after(new_row);
            }
    }
function isExist(newEntry){
    id='#code_'+newEntry;
    return $(id).val();
}

$(function() {
    let tbl = $('#points_tbl tr:has(td)').map(function(i, v) {
        let $td =  $('td input', this);
        return  $td.eq(1).val()           
            }).get();
    tbl.forEach((element, index) => {
        if(index==tbl.length-1){
            $("table#rejection_code_table tbody tr#"+element+" td:first-child").addClass("activate_code");
        }
        $("table#rejection_code_table tbody tr#"+element+" td:eq(1)").addClass("selected");
    })
});

$(function() {
    $(".save-confirm-data").click(function(e) {
        // var inputVal = $(this).closest('tr').find("td:eq(x) input").val();
        var tbl = $('#points_tbl tr:has(td)').map(function(i, v) {
        var $td =  $('td input', this);
        return {
                 code: $td.eq(1).val(),
                 desc: $td.eq(2).val(),
                 point_1: $td.eq(3).val(),
                 point_2: $td.eq(4).val(),
                 point_3: $td.eq(5).val(),
                 point_4: $td.eq(6).val()               
               }
            }).get();
               let store= $("#four_point_store_id").val();
            // console.log(tbl);
            var url = "<?php echo getFullURL($_GET['r'], 'submit.php', 'R'); ?>"
            var postData = JSON.stringify(tbl);
            $.ajax({
                url: url,
                dataType: 'json',
                type: 'post',
                // contentType: 'applicatoin/x-www-form-urlencoded',
                data: {'data':postData,'store_id':store},
                success: function(data) 
                {
                    var data = $.parseJSON(data);
                    if (data.status == 200)
                        console.log('success');
                    else {
                        console.log('error');
                    }
                },
                error: function(jqXhr, textStatus, errorThrown) 
                {
                    console.log(errorThrown);
                }
            });
        });
    });
});
</script>


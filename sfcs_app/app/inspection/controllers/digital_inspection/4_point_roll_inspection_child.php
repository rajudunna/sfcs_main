<head>
    <style>
        table tr th,td 
        {
            text-align: center;
        }
        #check_true
        {
            cursor:pointer;
        }
        .tableBodyScroll tbody 
        {
            display: block;
            max-height: 300px;
            overflow-y: scroll;
        }
    
    </style>
</head>
<?php
echo "<input type='hidden' name='reject_reasons' id='reject_reasons'>";
include($_SERVER['DOCUMENT_ROOT'] . "/sfcs_app/common/config/config.php");

if (isset($_GET['parent_id']) or isset($_POST['parent_id'])) {
    $parent_id = $_GET['parent_id'] or $_POST['parent_id'];
    $store_id = $_GET['store_id'] or $_POST['store_id'];
}
$sno_points = $store_id;
$get_inspection_population_info = "select * from $bai_rm_pj1.`roll_inspection_child` where store_in_tid=$store_id";

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

$get_details = "select * from $bai_rm_pj1.`inspection_population` where store_in_id=$store_id";

$details_result = mysqli_query($link, $get_details) or exit("get_details Error--2" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($row1 = mysqli_fetch_array($details_result)) {
    $invoice = $row1['supplier_invoice'];
    $batch = $row1['supplier_batch'];
    $po = $row1['supplier_po'];
    $item_code = $row1['item_code'];
    $item_desc = $row1['item_desc'];
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

$get_details1 = "select * from $bai_rm_pj1.`main_population_tbl` where id=$parent_id";
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
                                    <td>Spec Width</td>
                                    <td><input type="text" id="spec_width" name="spec_width" autocomplete="off" value="<?= $spec_width ?>" <?php if ($spec_width)   ?> class="float"></td>

                                    <td rowspan="2"><textarea id="remarks" name="remarks" class="form-control" style="min-width: 100%;min-height: 80px" ><?php echo $remarks ?> <?php if ($remarks)?></textarea>
                                    </td>
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
              <div class="panel-heading">4Points Roll Information</div>
                <div class="panel-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr style="background-color: antiquewhite;">
                                    <th>Supplier Roll No</th>
                                    <th>SFCS Roll No</th>
                                    <th>Item Code</th>
                                    <th>Color</th>
                                    <th>Description</th>
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
                                <td>" . $lot_no . "</td>
                                <td>" . $invoice_qty . "</td>";
                                if($sno_points>0)
                                {
                                    $get_status_details = "select sum(points) as points from $bai_rm_pj1.four_points_table where insp_child_id = ".$sno_points."";
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
                                       <input type="text" id="s" size="4" name="s" id="s" colspan=3 autocomplete="off" value="<?= $width_s ?>" <?php if ($width_s)   ?> class="float">
                                    </td>
                                    <td>
                                       <input type="text" id="m" size="4" name="m" id="m" colspan=3 autocomplete="off" value="<?= $width_m ?>" <?php if ($width_m)   ?> class="float">
                                    </td>
                                    <td>
                                        <input type="text" id="e" size="4" name="e" id="e" colspan=3 autocomplete="off" value="<?= $width_e ?>" <?php if ($width_e)   ?> class="float">
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
                        <div class="table-responsive col-sm-3">
                            <table class="tableBodyScroll table table-bordered" style="margin-top: 48px;">
                                <tbody>
                                    <tr style="background-color: antiquewhite;">
                                        <th>Code</th>
                                        <th>Damage Description</th>
                                    </tr>
                                
                                    <?php 
                                        $select_resons = "select * from $bai_rm_pj1.`reject_reasons`";
                                        $get_reasons = mysqli_query($link, $select_resons) or exit("get_parent_id Error--6" .mysqli_error($GLOBALS["___mysqli_ston"]));
                                        
                                        while ($row122 = mysqli_fetch_array($get_reasons)) {
                                            $reject_code = $row122['reject_code'];
                                            $reject_desc = $row122['reject_desc'];
                                            $num_rows = mysqli_num_rows($get_reasons);
                                            if($num_rows=10){
                                                echo "<tr><td>$reject_code</td>
                                                <td>$reject_desc</td></tr>";        
                                            }
                                        
                                        }
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="form-horizontal col-sm-2">
                            <div>
                                <table class="table table-bordered" style="margin-top: 56px;">
                                    <tbody>
                                         <tr>
                                             <?php
                                            // $pop_up_path="../sfcs_app/app/inspection/reports/4_point_inspection_report.php";
                                            // echo "<td><a class='btn btn-primary' href=\"$pop_up_path?parent_id=$parent_id\" onclick=\"Popup1=window.open('$pop_up_path?parent_id=$parent_id','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Get Report</a></td>";
                                            ?>
                                        </tr> 
                                            <td colspan="2"><button type="sumbit" class="btn btn-sm btn-primary" name="save" id="save">Save</button></td>
                                        </tr>
                                        <tr>
                                        <td><input type = "checkbox" id="check_true"></td>
                                            <td><button type="sumbit" class="btn btn-sm btn-primary" name="confirm" id="confirm"  disabled = 'disabled'>Confirm</button></td>
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
                                        <th>1 Points</th>
                                        <th>2 Points</th>
                                        <th>3 Points</th>
                                        <th>4 Points</th>
                                        <th><a href="javascript:void(0);" style="font-size:18px;" id="clear" title="Add More points"><span class="glyphicon glyphicon-plus"></span></a><input type = "hidden" id="clicks"></th>
                                    
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" value="" name="hidenMaxCount" id="hidenMaxCount">
                                    <?php
                                        $select_four_points = "select * from $bai_rm_pj1.`four_points_table` where insp_child_id = $sno_points";
                                        $fourpoints_result = mysqli_query($link, $select_four_points) or exit("get_parent_id Error--12" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $num_rows = mysqli_num_rows($fourpoints_result);
                                        if($num_rows > 0) {
                                        $i = 0;
                                        while ($row44 = mysqli_fetch_array($fourpoints_result)) {
                                            $code = $row44['code'];
                                            $description = $row44['description'];
                                            $first_point = $row44['points'];
                                            
                                            
                                        echo '<tr>
                                        <td><input type="hidden" value = '.$i.' name="submit_value_point[]" ><input type="text" class="code" id="code_' . $i . '" name="code[]" size="4" autocomplete="off" value = "' . $code . '"></td>
                                        <td><input type="text" class="damage" value = "' . $description . '" id="damage_' . $i . '" name="damage[]" readonly></td>';
                                            if ($first_point == 1) {
                                                echo '<td><input type="radio" value="1" id="point1_' . $i . '" name="point_'.$i.'" checked="checked"></td>';
                                            } else {
                                                echo '<td><input type="radio" value="1" id="point1_' . $i . '" name="point_'.$i.'"></td>';
                                            }

                                            if ($first_point == 2) {
                                                echo '<td><input type="radio" value="2" id="point2_' . $i . '" name="point_'.$i.'" checked="checked"></td>';
                                            } else {
                                                echo '<td><input type="radio" value="2" id="point2_' . $i . '" name="point_'.$i.'"></td>';
                                            }
                                            if ($first_point == 3) {
                                                echo '<td><input type="radio" value="3" id="point3_' . $i . '" name="point_'.$i.'" checked="checked"></td>';
                                            } else {
                                                echo '<td><input type="radio" value="3" id="point3_' . $i . '" name="point_'.$i.'"></td>';
                                            }
                                            if ($first_point == 4) {
                                                echo '<td><input type="radio" value="4" id="point4_' . $i . '" name="point_'.$i.'" checked="checked"></td>';
                                            } else {
                                                echo '<td><input type="radio" value="4" id="point4_' . $i . '" name="point_'.$i.'"></td>';
                                            }

                                            echo '<td><a href="javascript:void(0);" class="remove" ><span class="glyphicon glyphicon-remove"></span></td>
                                    </tr>';
                                            $i++;
                                        }
                                    } else {

                                        for ($i = 0; $i < 1; $i++)
                                        {
                                            ?>
                                            <tr>
                                                <td><input type="hidden" value='0' name="submit_value_point[]" >
                                                <input type="text" size="4" class="code" id="code_<?php echo $i; ?>" name="code[]" autocomplete="off"></td>
                                                <td><input type="text" class="damage" id="damage_<?php echo $i; ?>" name="damage[]" readonly></td>
                                                <td><input type="radio" value="1" id="point1_<?= $i ?>" name="point_0"></td>
                                                <td><input type="radio" value="2" id="point2_<?= $i ?>" name="point_0"></td>
                                                <td><input type="radio" value="3" id="point3_<?= $i ?>" name="point_0"></td>
                                                <td><input type="radio" value="4" id="point4_<?= $i ?>" name="point_0"></td>
                                                <td><a href='javascript:void(0);' class='remove'><span class='glyphicon glyphicon-remove'></span></a></td>
                                            </tr>
                                        <?php
                                        }
                                    }
                                        ?>
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

    $inspection_status = $_POST['inspection_status'];

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
        
        $sql_rows="update $bai_rm_pj1.main_population_tbl set fab_composition='" . $fabric_composition . "',s_width='" . $spec_width . "',s_weight='" . $spec_weight . "',repeat_len='" . $repeat_length . "',lab_testing='" . $lab_testing . "',tolerence='" . $tolerance . "',remarks='" . $remarks . "' where id=".$parent_id."";
        mysqli_query($link, $sql_rows) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));
        
        $id_parent = $parent_id;

        $check_store_tid = "select sno from $bai_rm_pj1.roll_inspection_child where store_in_tid='" . $store_id . "'";
        $details_check_store_tid = mysqli_query($link, $check_store_tid) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $row_sid = mysqli_num_rows($details_check_store_tid);
        $row_store_tid = mysqli_fetch_array($details_check_store_tid);
        if ($row_sid == 1) 
        {            
            $update_status_insp = "update $bai_rm_pj1.roll_inspection_child SET inspected_per='" . $inspected_per . "',inspected_qty='" . $inspected_qty . "',width_s='" . $s . "',width_m='" . $m . "',width_e='" . $e . "',actual_height='" . $actual_height . "',actual_repeat_height='" . $actual_repeat_height . "',skw='" . $skw . "',bow='" . $bow . "',ver='" . $ver . "',gsm='" . $gsm . "',comment='" . $comment . "',marker_type='" . $marker_type . "',status = '3' where store_in_tid='".$store_id."'";
            $roll_inspection_update = $link->query($update_status_insp) or exit('query error in updating222');
            
            $update_status = "update $bai_rm_pj1.inspection_population SET status=3 where store_in_id='" . $store_id . "'";
            $result_query_update = $link->query($update_status) or exit('query error in updating2221');
			
            $roll_id = $store_id;
            $check_val = "select insp_child_id from $bai_rm_pj1.four_points_table where insp_child_id='" . $store_id . "'";
            $check_val_ref = mysqli_query($link, $check_val) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));
            $rows_id = mysqli_num_rows($check_val_ref);
            if($rows_id>0)
            {
                $delete_child = "Delete from  $bai_rm_pj1.four_points_table where insp_child_id='" .$store_id. "'";
                $roll_inspection_update = $link->query($delete_child) or exit('query error in deleteing222---2');
            }
           
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
							$insert_four_points = "insert ignore into $bai_rm_pj1.four_points_table(insp_child_id,code,description,points) values('$roll_id','".$code[$i]."','".$damage[$i]."',$flag_var)";
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
            $insert_query = "insert into $bai_rm_pj1.roll_inspection_child(inspected_per,inspected_qty,width_s,width_m,width_e,actual_height,actual_repeat_height,skw,bow,ver,gsm,comment,marker_type,parent_id,status,store_in_tid) values ('$inspected_per','$inspected_qty','$s','$m','$e','$actual_height','$actual_repeat_height','$skw','$bow','$ver','$gsm','$comment','$marker_type','$id_parent','3','$store_id')";
            $result_query = $link->query($insert_query) or exit('query error in inserting11111');
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
							$insert_four_points = "insert ignore into $bai_rm_pj1.four_points_table(insp_child_id,code,description,points) values('$roll_id','".$code[$i]."','".$damage[$i]."',$flag_var)";
							mysqli_query($link, $insert_four_points) or exit("third ErrorError-2" . mysqli_error($GLOBALS["___mysqli_ston"]));
							$i++;
						}
						$flag_var=0;
					}
				}    
			}
            $update_status = "update $bai_rm_pj1.inspection_population SET status=3 where store_in_id='" . $store_id . "'";
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

    $inspection_status = $_POST['inspection_status'];

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
        
        $sql_rows="update $bai_rm_pj1.main_population_tbl set fab_composition='" . $fabric_composition . "',s_width='" . $spec_width . "',s_weight='" . $spec_weight . "',repeat_len='" . $repeat_length . "',lab_testing='" . $lab_testing . "',tolerence='" . $tolerance . "',remarks='" . $remarks . "' where id=".$parent_id."";
        mysqli_query($link, $sql_rows) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));
        
        $id_parent = $parent_id;

        $check_store_tid = "select sno from $bai_rm_pj1.roll_inspection_child where store_in_tid='" . $store_id . "'";
        $details_check_store_tid = mysqli_query($link, $check_store_tid) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $row_sid = mysqli_num_rows($details_check_store_tid);
        $row_store_tid = mysqli_fetch_array($details_check_store_tid);
        if ($row_sid >0) 
        {   
            $update_status_insp = "update $bai_rm_pj1.roll_inspection_child SET inspected_per='" . $inspected_per . "',inspected_qty='" . $inspected_qty . "',width_s='" . $s . "',width_m='" . $m . "',width_e='" . $e . "',actual_height='" . $actual_height . "',actual_repeat_height='" . $actual_repeat_height . "',skw='" . $skw . "',bow='" . $bow . "',ver='" . $ver . "',gsm='" . $gsm . "',comment='" . $comment . "',marker_type='" . $marker_type . "',status = '2' where store_in_tid='".$store_id."'";
            $roll_inspection_update = $link->query($update_status_insp) or exit('query error in updating222---3');
            
            $check_val = "select insp_child_id from $bai_rm_pj1.four_points_table where insp_child_id='" . $store_id . "'";
            $check_val_ref = mysqli_query($link, $check_val) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));
            $rows_id = mysqli_num_rows($check_val_ref);
            if($rows_id>0)
            {
                $delete_child = "Delete from  $bai_rm_pj1.four_points_table where insp_child_id='" .$store_id. "'";
               $roll_inspection_update = $link->query($delete_child) or exit('query error in deleteing222---2');
            }
            $update_status = "update $bai_rm_pj1.inspection_population SET status=2 where store_in_id='" . $store_id . "'";
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
							$insert_four_points = "insert ignore into $bai_rm_pj1.four_points_table(insp_child_id,code,description,points) values('$roll_id','".$code[$i]."','".$damage[$i]."',$flag_var)";
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
            $insert_query = "insert into $bai_rm_pj1.roll_inspection_child(inspected_per,inspected_qty,width_s,width_m,width_e,actual_height,actual_repeat_height,skw,bow,ver,gsm,comment,marker_type,parent_id,status,store_in_tid) values ('$inspected_per','$inspected_qty','$s','$m','$e','$actual_height','$actual_repeat_height','$skw','$bow','$ver','$gsm','$comment','$marker_type','$id_parent','2','$store_id')";
            $result_query = $link->query($insert_query) or exit('query error in inserting11111');
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
						$insert_four_points = "insert ignore into $bai_rm_pj1.four_points_table(insp_child_id,code,description,points) values('$roll_id','".$code[$i]."','".$damage[$i]."',$flag_var)";
						mysqli_query($link, $insert_four_points) or exit("third ErrorError-2" . mysqli_error($GLOBALS["___mysqli_ston"]));
						$i++;
					}
					$flag_var=0;
					}
				}    
			}
            $update_status = "update $bai_rm_pj1.inspection_population SET status=2 where store_in_id='" . $store_id . "'";
            $result_query_update = $link->query($update_status) or exit('query error in updating222---');
        }
        echo "<script>swal('Data Updated..','Successfully','success')</script>";
        $url = getFullURLLevel($_GET['r'], '4_point_roll_inspection.php', 0, 'N');
        echo "<script>location.href = '" . $url . "&parent_id=$parent_id'</script>";
        die();
    }
    
}

?>

<script>
    $(document).ready(function() {
         $("#s").keyup(function()
         {
           var x=$("#s").val();
           if(x==0&x!='')
           {
            swal('warning','S Value should be greater than zero','warning');
            $("#s").val('');
           }
         });

         $("#m").keyup(function()
         {
           var x=$("#m").val();
           if(x==0&x!='')
           {
            swal('warning','M Value should be greater than zero','warning');
            $("#m").val('');
           }
         });

         $("#e").keyup(function()
         {
           var x=$("#e").val();
           if(x==0&x!='')
           {
            swal('warning','E Value should be greater than zero','warning');
            $("#e").val('');
           }
         });

        $('#check_true').click(function() {
        if ($(this).is(':checked')) {
         $('#confirm').removeAttr('disabled');
          
        } else {
             $('#confirm').attr('disabled', 'disabled');
        }
        });

		    $('#inspected_per').keyup(function(){
			  if ($(this).val() > 100){
				swal('warning','Enter only bellow 100%','warning');
				$(this).val('');
			  }
			});

			$('#inspected_qty').change(function(){
				
				var invoice_q= $("#invoice_qty").val();
				if (parseInt(invoice_q) < $(this).val()){
					swal('warning','Inspected Qty Should be less than Ticket Length','warning');
					$(this).val('');
				 }
			});

        var table_length = $('#points_tbl > tbody > tr').length;
        var clicks = table_length-1;
        $('#hidenMaxCount').val(table_length)
        $('#clear').on('click', function() {

            clicks += 1;
            var xxx = clicks;
            //  && $(`input:radio[name=${point}]`).not(':checked')
            $('#hidenMaxCount').val(xxx);
            for(var j=0;j<xxx;j++){
              var cx=  $("#code_"+j).val();
              var point = 'point_'+j;
              if(cx==""){
                swal('warning','Please Fill Empty Row or Remove Empty Row','warning');
               return;
              }
            }
         
            
            // console.log(xxx);
            // var count_tr = "<tr><td><input type='hidden' value='"+xxx+"' name='submit_value_point[]' ><input type='text' class='code' id='code_"+xxx+"' name='code[]' autocomplete='off'></td><td><input type='text' class='damage' id='damage_"+xxx+"' name='damage[]' readonly></td><td><input type='radio' value='1' id='point1_"+xxx+"' name='point_"+xxx+"'></td><td><input type='radio' value='2' id='point2_"+xxx+"' name='point_"+xxx+"'></td><td><input type='radio' value='3' id='point3_"+xxx+"' name='point_"+xxx+"'></td><td><input type='radio' value='4' id='point4_"+xxx+"' name='point_"+xxx+"'></td><td><a href='javascript:void(0);' class='remove'><span class='glyphicon glyphicon-remove'></span></a></td></tr>";
            
            var count_tr = "<tr><td><input type='hidden' value='"+xxx+"' name='submit_value_point[]' ><input type='text' class='code' size='4' id='code_"+xxx+"' name='code[]' autocomplete='off'></td><td><input type='text' class='damage' id='damage_"+xxx+"' name='damage[]' readonly></td><td><input type='radio' value='1' id='point1_"+xxx+"' name='point_"+xxx+"'></td><td><input type='radio' value='2' id='point2_"+xxx+"' name='point_"+xxx+"'></td><td><input type='radio' value='3' id='point3_"+xxx+"' name='point_"+xxx+"'></td><td><input type='radio' value='4' id='point4_"+xxx+"' name='point_"+xxx+"'></td><td><a href='javascript:void(0);' class='remove'><span class='glyphicon glyphicon-remove'></span></a></td></tr>";
        //    var count_row = 0;
        //    var b = 0;
        //    var rowCount_1 = $('#points_tbl >tbody >tr').length;
        //     for(var j=(xxx-1);j>=0;j--){
        //       var point = 'point_'+j;
        //       alert(point);
        //       if(!$(`input:radio[name=${point}]`).is(':checked')){
        //           count_row++;
        //           alert("ji")
        //         //   alert(count_row);
        //            }
        //       else{
        //         //   alert(count_row);
        //         b++;
        //       }
        //     }
        //    alert(count_row + "-" + b);
        //     if(count_row==0){
        //         $("#points_tbl").append(count_tr);
        //         count_row=0;
        //     }else{
        //         swal('warning','Please check point','warning');
        //         // return;
        //     }
    // if(table_length<0){
        var table_length = $('#points_tbl tbody > tr').length;
        // alert(table_length);
        if(table_length==0){
            $("#points_tbl").append(count_tr); 
            return;
        }else{
            
            var tr_radio=$('#points_tbl tbody tr').last().find('input[type=radio]').is(':checked'); 
            if(tr_radio){
            $("#points_tbl").append(count_tr);
        }
        else{
            swal('warning','Please check point','warning');
        //         // return;
        }
        }
        //  clicks=xxx;
        // alert(tr_radio);
       
          });
          
          $(document).on('click', '.remove', function() {
            var table_length = $('#points_tbl tbody > tr').length;
            $('#hidenMaxCount').val(table_length)
              var trIndex = $(this).closest("tr").index();
                  if(trIndex>0) {
                  $(this).closest("tr").remove();
                
                } else {
                  swal('warning','Sorry!! Cannot remove first row!','warning');
                }
            });

        $(document).on( 'change', 'input.code', function(e){
            // alert("haiii");
            var url = "<?php echo getFullURL($_GET['r'], 'submit.php', 'R'); ?>"
            const target_id = "damage_" + (e.target.id).split("_")[1];
        
            $.ajax({
                url: url,
                dataType: 'text',
                type: 'post',
                // contentType: 'applicatoin/x-www-form-urlencoded',
                data: {
                    getalldata: e.target.value
                },
                success: function(data, textStatus, jQxhr) {
                    var data = $.parseJSON(data);
                    if (data.status == 200)
                        $('#' + target_id).val(data.message);
                    else {
                        swal('warning',data.message,'warning');
                        $('#' + e.target.id).val('');
                    }
                },
                error: function(jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
            console.log(e.target.id + "-->" + e.target.value)
    
        
        $('input[type="checkbox"]').on('change', function() {
      var checkedValue = $(this).prop('checked');
        // uncheck sibling checkboxes (checkboxes on the same row)
        $(this).closest('tr').find('input[type="checkbox"]').each(function(){
           $(this).prop('checked',false);
        });
        $(this).prop("checked",checkedValue);

        });
    })

    $(function() {

        $("#save").click(function(e) {
            // var rowCount = $('#points_tbl >tbody >tr').length;
            // alert(rowCount);
            // // e.preventDefault();
            // for(var j=0;j<=rowCount;j++){
            //   var cx=  $("#code_"+j).val();
            //   if(cx==""){
            //     swal('warning','Please Fill Empty Row or Remove Empty Row','warning');
            //     e.preventDefault();
            //   }
            // }
            var t=$('#points_tbl tbody tr').size();
        if(t>1){
            var tr_radio_1=$('#points_tbl tbody tr').last().find('input[type=text]').val(); 
          
            if(tr_radio_1==''){
                 swal('warning','Please Fill Empty Row or Remove Empty Row','warning');
                 e.preventDefault();
                 }
               
                    var tr_radio=$('#points_tbl tbody tr').last().find('input[type=radio]').is(':checked');
                //  clicks=xxx;
        // alert(tr_radio);
           if(tr_radio){
            $("#points_tbl").append(count_tr);
        }
        else{
            swal('warning','Please check point','warning');
            e.preventDefault();
        }
            for (let i = 0; i < 4; i++) {
                let point1_value = point2_value = point3_value = point4_value = 0;
                if ($("#point1_" + i).prop("checked")) {
                    point1_value = $("#point1_" + i).val();
                }
                if ($("#point2_" + i).prop("checked")) {
                    point2_value = $("#point2_" + i).val();
                }
                if ($("#point3_" + i).prop("checked")) {
                    point3_value = $("#point3_" + i).val();
                }
                if ($("#point4_" + i).prop("checked")) {
                    point4_value = $("#point4_" + i).val();
                }
                let x = $("#code_" + i).val() + "$" + $("#damage_" + i).val() + "$" + point1_value + "$" + point2_value + "$" + point3_value + "$" + point4_value;
                $('#submit_value_' + i).val(x)
            }
            var inspected_per = $("#inspected_per").val();
            var ddlFruits = $("#inspection_status");    
            if (inspected_per > 100) {
                swal('warning','Enter only bellow 100%','warning');
                return false;
            } else if (ddlFruits.val() == "") {
                swal('warning','Please select Inspection Status!','warning');
                return false;
            }
            return true;
        }
        });
    });
    $(function() {
        $("#confirm").click(function(e) {
            // e.preventDefault();
            // var rowCount = $('#points_tbl >tbody >tr').length;
            // for(var j=0;j<rowCount;j++){
            //   var cx=  $("#code_"+j).val();
            //   if(cx==""){
            //     swal('warning','Please Fill Empty Row or Remove Empty Row','warning');
            //     e.preventDefault();
            //   }
            // }
            
            var t=$('#points_tbl tbody tr').size();
        if(t>1){
            var tr_radio_1=$('#points_tbl tbody tr').last().find('input[type=text]').val(); 
            if(tr_radio_1==''){
                 swal('warning','Please Fill Empty Row or Remove Empty Row','warning');
                 e.preventDefault();
                 }
                else{
                 $("#points_tbl").append(count_tr);
                //         // return;
                }
            
            var tr_radio=$('#points_tbl tbody tr').last().find('input[type=radio]').is(':checked');
        //  clicks=xxx;
        // alert(tr_radio);
           if(tr_radio){
            $("#points_tbl").append(count_tr);
        }
        else{
            swal('warning','Please check point','warning');
            e.preventDefault();
        }
            for (let i = 0; i < 4; i++) {
                let point1_value = point2_value = point3_value = point4_value = 0;
                if ($("#point1_" + i).prop("checked")) {
                    point1_value = $("#point1_" + i).val();
                }
                if ($("#point2_" + i).prop("checked")) {
                    point2_value = $("#point2_" + i).val();
                }
                if ($("#point3_" + i).prop("checked")) {
                    point3_value = $("#point3_" + i).val();
                }
                if ($("#point4_" + i).prop("checked")) {
                    point4_value = $("#point4_" + i).val();
                }
                let x = $("#code_" + i).val() + "$" + $("#damage_" + i).val() + "$" + point1_value + "$" + point2_value + "$" + point3_value + "$" + point4_value;
                $('#submit_value_' + i).val(x)
            }
            var inspected_per = $("#inspected_per").val();
            var ddlFruits = $("#inspection_status");
            if (inspected_per > 100) {
                swal('warning','Enter only bellow 100%','warning');
                return false;
            } else if (ddlFruits.val() == "") {
                swal('warning','Please select Inspection Status!','warning');
                return false;
            }
            return true;
        }
        });
    });
});

$(document).ready(function(){
 

});
</script>

<!-- <SCRIPT language=Javascript>

      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
   </SCRIPT> -->
<!--    <script type="text/javascript">
        $('s').keypress(function(e){ 
        if (this.value.length == 0 && e.which == 48 )
        {
          return false;
        }
});
   </script> -->
<script>

</script>

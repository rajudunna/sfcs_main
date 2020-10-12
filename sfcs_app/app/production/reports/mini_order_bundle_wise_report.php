<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R')?>"></script>
<script>
function firstbox()
{
	var url1 = '<?= getFullUrl($_GET['r'],'mini_order_bundle_wise_report.php','N'); ?>';
	window.location.href =url1+"&style="+document.input.style.value;
}
function secondbox()
{
	var url1 = '<?= getFullUrl($_GET['r'],'mini_order_bundle_wise_report.php','N'); ?>';
	window.location.href =url1+"&style="+document.input.style.value+"&mpo="+document.input.mpo.value;
}
</script>
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/sms_api_calls.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',3,'R'));
$plant_code = $_SESSION['plantCode'];
$username =  $_SESSION['userName'];
$style=$_POST['style'];
$master_po=$_POST['mpo'];
$style=$_GET['style'];
$mpo=$_GET['mpo'];
$reptype=$_POST['reptype'];
if($_POST['reptype'] == NULL){
    $reptype=1;
}
if($reptype == 1) { 
    $r_name = 'Bundle Wise ';
} else {
    $r_name = 'Sewing Job Wise';
}

?>
<div class="panel panel-primary">
	<div class="panel-heading"><b> <?= $r_name; ?> Performance Report</b></div>
	<div class="panel-body">
        <div class="row">
            <form method="post" name="input" action="?r=<?php echo $_GET['r']; ?>">
            <div class="row">
                <div class="col-md-2">
                    <label for='style'>Style</label>
                    <?php
                    //geting style
                    $sql="SELECT DISTINCT style FROM $pts.transaction_log where style != '' AND plant_code='$plant_code' AND is_active=1";	
                    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                    echo "<select class='form-control' name=\"style\"  id=\"style\" id='style' onchange='firstbox();' required>";
    
                    echo "<option value='' disabled selected>Please Select</option>";
                    while($sql_row=mysqli_fetch_array($sql_result))
                    {
    
                        if($sql_row['style']==$style)
                        {
                            echo "<option value=\"".$sql_row['style']."\" selected>".$sql_row['style']."</option>";
                        }
                        else
                        {
                            echo "<option value=\"".$sql_row['style']."\">".$sql_row['style']."</option>";
                        }
    
                    }
                    echo "  </select>";
                    ?>
                </div>
                <div class="col-md-3">
                    <label for='style'>Master Po</label>
                    <?php
                    //geting style
                    $sql="SELECT master_po_description,mp_order.master_po_number AS mpo FROM $pps.`mp_order` LEFT JOIN $pps.mp_color_detail ON mp_color_detail.`master_po_number` = mp_order.`master_po_number` where style = '$style' AND mp_order.plant_code='$plant_code' AND mp_order.is_active=1";
                    //echo  $sql;	
                    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                    echo "<select class='form-control' name=\"mpo\"  id=\"mpo\" id='mpo' onchange='secondbox();' required>";
    
                    echo "<option value='' disabled selected>Please Select</option>";
                    while($sql_row=mysqli_fetch_array($sql_result))
                    {
    
                        if($sql_row['mpo']==$mpo)
                        {
                            echo "<option value=\"".$sql_row['mpo']."\" selected>".$sql_row['master_po_description']."</option>";
                        }
                        else
                        {
                            echo "<option value=\"".$sql_row['mpo']."\">".$sql_row['master_po_description']."</option>";
                        }
    
                    }
                    echo "  </select>";
                    ?>
                </div>
                <div class="col-md-4">
                    <label for='reptype'>Report Type: </label>
                    <select class='form-control' name="reptype" id='reptype' onchange=verify(event)>
                    <option value='' selected disabled>Please select</option>
                    <option value=1>Bundle Level Report</option>
                    <option value=2 selected>Sewing Job Level Report</option>
                    </select>
                </div>
                <div class="col-md-3"><br/>
                    <input class="btn btn-success" type="submit" value="Show" id='show' onclick="verify();" name="submit">
                    
                </div>
               
            </div>
            </form>
        </div>
        <br/>
        <div class="row">
            <?php
            echo $master_po;
                if($style !='' && $reptype !=''){
       
                    $operation_code = [];	
                    $operations_yes = [];
                    $operations_no = [];
                    $over_all_operations = [];
                    $opertion_names = [];	
                    $total_data = [];
                    $main_result = [];
                    
                    //get style and color operations
                    $get_details="SELECT schedule,color FROM $pts.transaction_log WHERE style='$style' AND plant_code='$plant_code' AND is_active=1 GROUP BY schedule,color";
                    echo $get_details;
                    $result1 = $link->query($get_details);
                    while($row1 = $result1->fetch_assoc())
                    {
                      $schedule=$row1['schedule'];
                      $color=$row1['color'];
                      //get operations_version_id
                      $get_operations_version_id="SELECT operations_version_id FROM $pps.mp_color_detail WHERE style='$style' AND color='$color' AND master_po_number='$master_po' AND plant_code='$plant_code' AND is_active=1";
                      $version_id_result=mysqli_query($link_new, $get_operations_version_id) or exit("Sql Error at get_operations_version_id".mysqli_error($GLOBALS["___mysqli_ston"]));
                      while($row14=mysqli_fetch_array($version_id_result))
                      {
                        $operations_version_id = $row14['operations_version_id'];
                      }
                      //Function to get operations for style,color
                      $result_mrn_operation=getJobOpertions($style,$color,$plant_code,$operations_version_id);
					  $operations=$result_mrn_operation;

                    }
                    $category=DepartmentTypeEnum::SEWING;
                    foreach($operations as $key =>$mpo_operations){
                        if($key['operationCategory'] == $category)
                        {
                            $operation_codes[]=$key['operationCode'];
                            $operation_names[]=['op_name'=>$key['operationName'],'op_code'=>$key['operationCode']];
                        }
                    }
                    
                    $main_result['columns'] = $opertion_names;

                    
                    if(count($operation_codes)>0){
                        $operation_codes_no = implode(',',$operation_codes);
                        //columns Data
                        if($reptype == 1){
                            $get_data_transaction= "SELECT style,schedule,color,parent_job,size,sum(good_quantity) as good_qty,sum(rejected_quantity) as rejected_qty,parent_barcode,resource_id,operation as op_code FROM $pts.`transaction_log` WHERE style='".$style."' AND operation in ($operation_codes_no) AND plant_code='$plant_code' AND is_active=1 GROUP BY parent_barcode,operation order by parent_barcode,operation";
                        } 
                        else{
                            $get_data_transaction= "SELECT style,schedule,color,parent_job,size,sum(good_quantity) as good_qty,sum(rejected_quantity) as rejected_qty,parent_barcode,resource_id,operation as op_code FROM $pts.`transaction_log` WHERE style='".$style."' AND operation_id in ($operation_codes_no) AND plant_code='$plant_code' AND is_active=1 GROUP BY schedule,parent_job,color,size,operation order by parent_job,size,operation";
                        }
               
                  
                        $result5 = $link->query($get_data_transaction);
                        $operation_array = explode(",", $operation_codes_no);
                        $op_count1 = mysqli_num_rows($result5);
                        if($op_count1>0){
                            while($row5 = $result5->fetch_assoc()){
                                $rec_qty = (int)$row5['good_qty'];
                                $rej_qty = (int)$row5['rejected_qty'];
                                $data = ['style'=>trim($row5['style']),'schedule'=>$row5['schedule'],'job_number'=>$row5['parent_job'],'bundle_number'=>$row5['parent_barcode'],'color'=>trim($row5['color']),'size'=>trim($row5['size']),'rej'=>$rej_qty,$row5['op_code']=>$rec_qty, 'rec_qty' => $rec_qty,'op_code'=>$row5['op_code'],'resource_id'=>$row5['resource_id']];

                                $bundle_data[$row5['parent_barcode']][] = $data;
                                $sewing_data[$row5['parent_job']][$row5['size']][$row5['size']][] = $data;
                            }
                            $all_bundles = array_keys($bundle_data);
                            
                        } else {
                            echo "<script>sweetAlert('No Data Found','','warning');</script>";
                            echo "<script type=\"text/javascript\"> 
                                setTimeout(\"Redirect()\",0); 
                                function Redirect(){	 
                                        location.href = \"".getFullURL($_GET['r'], "mini_order_bundle_wise_report.php","N")."\"; 
                                    }
                            </script>";
                        }
                    }
                   
                   
                    $main_result['data'] = $total_data;
                    echo '<div class="row">';
                        echo '<div class="col-md-5">';
                        
                        echo "<h3>&nbsp; $r_name <span> for <b>Style :</b>".$style."</span></h3>";
                        echo '</div>';
                        echo '<div class="col-md-6">';
                        echo '</div>';
                        echo '<div class="col-md-1">';
                            echo '<form action="'.getFullURL($_GET['r'],'export_excel1.php','R').'" method ="post" > 
                            <input type="hidden" name="csv_text" id="csv_text">
                            <input type="hidden" name="csvname" id="csvname" value="'.$r_name.'">
                            <input type="submit" class="btn btn-info btn-xs" id="expexc" name="expexc" value="Export Excel" onclick="getCSVData()">
                            </form>';
                        echo '</div>';
                    echo '</div>';

                     ?>
                     
                    <div  id="table-scroll" class="table-scroll" style='height:600px;overflow-y: scroll;'>
                    <table class="report" id='report' name='report'>
                    <thead>
                    <tr  id='myHeader' class='info' style='color:white'><th>Style</th><th>Schedule</th><th>Color</th><th>Sewing Job Number</th>
                     <?php
                     // Bundle Wise Report
                     if($reptype == 1){ ?>
                    <th>Bundle Number</th><th>Bundle Qty</th><th>Module</th>
                     <?php  }
					else
					{
						echo  "<th>Sewing Job Qty</th>";
					}
	                ?>
                    <th>Size</th>
                    <?php
                    $op_count=sizeof($main_result['columns']);
                    foreach($main_result['columns'] as $key1=>$value1){
                    ?>
                        <th style='text-align:center'><?= $value1['op_name']."[".$value1['op_code']."] -Good"; ?></th>
                        <th style='text-align:center'><?= $value1['op_name']."[".$value1['op_code']."] -Reject"; ?></th>
                    <?php
                    }
                    ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $job_num= '';
                    $bundle_num= '';
                    $size= '';
                    if($reptype == 1){
                        foreach($all_bundles as $key => $value){ 
                            ?>
                        <tr>
                            <td><?= $bundle_data[$value][0]['style']  ?></td>
                            <td><?= $bundle_data[$value][0]['schedule']  ?></td>
                            <td><?= $bundle_data[$value][0]['color']  ?></td>
                            <td><?= $bundle_data[$value][0]['job_number']  ?></td>
							<td><?= $value ?></td>
                            <?php
                             //To get bundle original qty
                             $org_qty=0;
                             $barcode_type=BarcodeType::PPLB;
                             $get_qty="SELECT quantity FROM $pts.barcode WHERE barcode='$value' AND barcode_type='$barcode_type' AND plant_code='$plant_code' AND is_active=1";
                             $result2 = $link->query($get_qty);
                             while($row2 = $result2->fetch_assoc())
                             {
                                $org_qty=$row2['quantity'];
                             }
                            ?>
							<td><?=  $org_qty  ?></td> 
                            <?php
                                //To get workstation description
                                $query_get_workdes = "select workstation_code from $pms.workstation where plant_code='$plant_code' and workstation_id = '$bundle_data[$value][0]['resource_id']'  AND is_active=1";
                                $result3 = $link->query($query_get_workdes);
                                while($des_row = $result3->fetch_assoc())
                                {
                                    $workstation_code = $des_row['workstation_code'];
                                }                             
                             ?>
                            <td><?= $workstation_code  ?></td>
							<td><?= $bundle_data[$value][0]['size']  ?></td>
                            <?php
                                foreach($operation_array as $main_op_key => $main_op_value ) {
                                    if(in_array($main_op_value, array_column($bundle_data[$value], 'op_code'))){
                                        $filter = array_search($main_op_value, array_column($bundle_data[$value], 'op_code'));
                                        if($filter >= 0){
                                            echo "<td>".$bundle_data[$value][$filter]['rec_qty']."</td>";
                                            echo "<td>".$bundle_data[$value][$filter]['rej']."</td>";
                                        }else{
                                            echo "<td>". 0 ."</td>";
                                            echo "<td>". 0 ."</td>";     
                                        }
                                    }else{
                                        echo "<td>". 0 ."</td>";
                                        echo "<td>". 0 ."</td>";       
                                    }
                                }
                            ?>
                        </tr>
                        
                        <?php
                        }

                    }
                    // for Report Type Sewing Number
                    if($reptype == 2){
                        foreach($sewing_data as $sew_key => $sew_values){ 

                            foreach($sew_values as $size_key => $size_values){
                            ?>
                            <tr>
                                <td><?= $size_values[$size_key][0]['style']  ?></td>
                                <td><?= $size_values[$size_key][0]['schedule']  ?></td>
                                <td><?= $size_values[$size_key][0]['color']  ?></td>
                                <td><?= $size_values[$size_key][0]['job_number']  ?></td>
                                <?php
                                //To get taskjob_id
                                $get_task_id="SELECT task_jobs_id FROM $tms.`task_attributes` WHERE attribute_value='$size_values[$size_key][0]['job_number']' AND plant_code='$plant_code'
                                 AND is_active=1";
                                $result4 = $link->query($get_task_id);
                                while($task_row = $result4->fetch_assoc())
                                {
                                    $task_id=$task_row['task_jobs_id'];
                                }
                                $tasktype = TaskTypeEnum::SEWINGJOB;
                                //to get task_refrence from task_jobs
                                $get_task_ref="SELECT task_job_reference FROM $tms.task_jobs WHERE task_jobs_id='$task_id' AND plant_code='$plant_code' AND task_type='$tasktype' AND is_active=1";
                                $result5 = $link->query($get_task_ref);
                                while($ref_row = $result5->fetch_assoc())
                                {
                                   $task_ref=$ref_row['task_job_reference'];
                                }
                                //to get qty from jm job lines
                                $toget_qty_qry="SELECT sum(quantity) as qty from $pps.jm_job_bundles where jm_jg_header_id ='$task_ref' and plant_code='$plant_code' AND is_active=1";
                                $result6 = $link->query($toget_qty_qry);
                                $toget_qty=mysqli_num_rows($result6);
                                if($toget_qty>0){
                                    while($toget_qty_det=mysqli_fetch_array($result6))
                                    {
                                      $sew_qty = $toget_qty_det['qty'];
                                    }
                                }
                                ?>
								<td><?= $sew_qty  ?></td>
                                <td><?= $size_values[$size_key][0]['size']  ?></td>


                                <?php
                                    foreach($operation_array as $main_op_key => $main_op_value ) {
                                        if(in_array($main_op_value, array_column($size_values[$size_key], 'op_code'))){
                                            $filter = array_search($main_op_value, array_column($size_values[$size_key], 'op_code'));
                                            if($filter >= 0){
                                                echo "<td>". $size_values[$size_key][$filter]['rec_qty'] ."</td>";
                                                echo "<td>". $size_values[$size_key][$filter]['rej'] ."</td>";
                                            }else{
                                                echo "<td>". 0 ."</td>";
                                                echo "<td>". 0 ."</td>";     
                                            }
                                        }else{
                                            echo "<td>". 0 ."</td>";
                                            echo "<td>". 0 ."</td>";       
                                        }
                                    }
                                    
                                ?>
                            </tr>

                        <?php
                            }
                        }
                    }
                    ?>
                    </tbody>
                    </table>
                    </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
$('#style').select2();

function getCSVData(){
//  var csv_value=$('#report').table2CSV({delivery:'value'});
//  $("#csv_text").val(csv_value);	
 var dummytable = $('.fltrow').html();
	var dummytotal = $('.total_excel').html();
	$('.fltrow').html('');
	$('.total_excel').html('');
	var csv_value= $("#report").table2CSV({delivery:'value',excludeRows: '.fltrow .total_excel'});
	$("#csv_text").val(csv_value);	
	$('.fltrow').html(dummytable);
	$('.total_excel').html(dummytotal);
}

$(document).ready(function(){
    document.getElementById('reptype').value = "<?php echo $_POST['reptype'];?>";
    $('#reset').addClass('btn btn-warning btn-xs');
    // var btn = document.getElementById('show');
    // // var btn1 = document.getElementById('excel');
    // btn.disabled = true;
    // btn1.disabled = true;
});

$('#reset').addClass('btn btn-warning');
	var table6_Props = 	{
                            // col_0: "select", 
                             col_1: "select", 
                             col_2: "select", 
                             col_3: "select", 
                            // col_4: "select", 
							rows_counter: true,
							btn_reset: true,
							// btn_reset_text: "Clear",
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "report",table6_Props );
	
function verify(){
    var mpo = $('#mpo').val();
    var reptype = $('#reptype').val();
    
    if(mpo == null && reptype ==null){
        swal('Warning','Please Select Style,masterpo & Report Type','warning');
        var btn = document.getElementById('show');
        btn.disabled = true;
    }
    else if(mpo != null && (reptype == 1 || reptype == 2)) {
        var btn = document.getElementById('show');
        btn.disabled = false;
    } else {
        var btn = document.getElementById('show');
        // var btn1 = document.getElementById('excel');
        btn.disabled = true;
    }
    
    
    //  else{
    //     sweetAlert('Style and Report Type','Should not be Empty!','warning');

    // }
}

// // When the user scrolls the page, execute myFunction
// window.onscroll = function() {myFunction()};

// // Get the header
// var header = document.getElementById("myHeader");

// // Get the offset position of the navbar
// var sticky = header.offsetTop;

// // Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
// function myFunction() {
//   if (window.pageYOffset > sticky) {
//     header.classList.add("sticky");
//   } else {
//     header.classList.remove("sticky");
//   }
// }
$(function(){
  $('#report').stickyTable({
    copyTableClass: true,
    copyEvents: false
  });
});
$(function(){
  $('#report').stickyTable({
    overflowy: true
  });
});
</script>
<style>
/* .sticky {
  position: fixed;
  top: 100px;
  width: auto;
} */

table
{
	font-family:calibri;
	font-size:15px;
    width:100%;
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td.lef
{
	border: 1px solid black;
	text-align: left;
	white-space:nowrap; 
}
h3{
    background-color: #221572;
    color:white; 
}
table th
{
	border: 1px solid black;
	text-align: center;
	/* background-color: #337ab7;
	border-color: #337ab7;
	color: WHITE;
	white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px; */
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:15px;
    
}
#reset{
	width : 50px;
	color : #ec971f;
	margin-top : 10px;
	margin-left : 0px;
	margin-bottom:15pt;
}



/* html {
  box-sizing: border-box;
} */
/* *,
*:before,
*:after {
  box-sizing: inherit;
} */
/* .intro {
  max-width: 1280px;
  margin: 1em auto;
} */
.table-scroll {
  position: relative;
  width:100%;
  z-index: 1;
  margin: auto;
  overflow: auto;
  height: 350px;
}
.table-scroll table {
  width: 100%;
  min-width: 1280px;
  margin: auto;
  border-collapse: separate;
  border-spacing: 0;
}
.table-wrap {
  position: relative;
}
.table-scroll th,
.table-scroll td {
  padding: 5px 10px;
  border: 1px solid #000;
  background: #fff;
  vertical-align: top;
}
.table-scroll thead th {
  background: #2687ad;
  color: #fff;
  position: -webkit-sticky;
  position: sticky;
  top: 0;
}
/* safari and ios need the tfoot itself to be position:sticky also */
.table-scroll tfoot,
.table-scroll tfoot th,
.table-scroll tfoot td {
  position: -webkit-sticky;
  position: sticky;
  bottom: 0;
  background: #666;
  color: #fff;
  z-index:4;
}

/* a:focus {
  background: red;
} testing links */

/* th:first-child {
  position: -webkit-sticky;
  position: sticky;
  left: 0;
  z-index: 2;
  background: #ccc;
} */
/* thead th:first-child,
tfoot th:first-child {
  z-index: 5;
} */

</style>
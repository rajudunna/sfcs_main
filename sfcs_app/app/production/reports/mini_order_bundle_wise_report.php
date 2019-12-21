<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R')?>"></script>
<?php 

/*
	********* Create By Mounika *********
	Created at : 17-12-2019
	Input : Style & Type Of Report(Bundle Wise / Mini Order Wise Report).
	Output : Get Performance Report Of All Sewing Operations.
*/
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
$style=$_POST['style'];
$reptype=$_POST['reptype'];
if($_POST['reptype'] == NULL){
    $reptype=1;
}

?>
<div class="panel panel-primary">
	<div class="panel-heading"><b>Performance Report</b></div>
	<div class="panel-body">
        <div class="row">
            <form method="post" name="input" action="?r=<?php echo $_GET['r']; ?>">
            <div class="row">
                <div class="col-md-2">
                    <label for='style'>Style</label>
                    <?php
                    //geting style of sewing operation only so used packing_summary_input to retrive
                    $sql="SELECT DISTINCT order_style_no FROM $bai_pro3.packing_summary_input where order_style_no != ''";	
                    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                    echo "<select class='form-control' name=\"style\"  id=\"style\" id='style' onchange='verify(event)'>";
    
                    echo "<option value='' disabled selected>Please Select</option>";
                    while($sql_row=mysqli_fetch_array($sql_result))
                    {
    
                        if($sql_row['order_style_no']==$style)
                        {
                            echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
                        }
                        else
                        {
                            echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
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
                    <input class="btn btn-success" type="submit" value="Show" id='show' onclick="verify_input();" name="submit">
                    
                </div>
               
            </div>
            </form>
        </div>
        <br/>
        <div class="row">
            <?php
                if($style !='' && $reptype !=''){
       
                    $operation_code = [];	
                    $operations_yes = [];
                    $operations_no = [];
                    $over_all_operations = [];
                    $opertion_names = [];	
                    $total_data = [];
                    $main_result = [];
                    
                    //To get all the operations	
                    //To get default Operations
                    $get_operations_workflow= "select DISTINCT(operation_code),default_operration from $brandix_bts.default_operation_workflow where operation_code IN (SELECT operation_code FROM $brandix_bts.tbl_orders_ops_ref WHERE category='sewing') order by operation_order";
                    $result1 = $link->query($get_operations_workflow);
                    $op_count = mysqli_num_rows($result1);
                    if($op_count>0){
                        while($row1 = $result1->fetch_assoc())
                        {
                            $operation_code[] = ['op_code'=>$row1['operation_code'],'def_op'=>$row1['default_operration']];
                        }
                    }
                    
                    if(count($operation_code)>0){
                        foreach ($operation_code as $key => $value) {	
                            //columns
                            $get_operations_no= "select DISTINCT(operation_id) from $brandix_bts.bundle_creation_data_temp where style = '$style' and operation_id =".$value['op_code']."";
                            // echo $get_operations_no.'<br/>';
                            $result4 = $link->query($get_operations_no);
                            $op_count = mysqli_num_rows($result4);
                            if($op_count){
                                while($row3 = $result4->fetch_assoc()){
                                    $over_all_operations[] = $row3['operation_id'];
                                    $operations_no[] = $row3['operation_id'];
                                }
                            }
                        }
                    }
                    $operation_codes_str = implode(',',$over_all_operations);
                    //To get operation names
                    $get_ops_query = "SELECT operation_name,operation_code FROM $brandix_bts.tbl_orders_ops_ref where operation_code in ($operation_codes_str) and category='sewing' order by field(operation_code,$operation_codes_str) ";
                    $ops_query_result=$link->query($get_ops_query);
                    $op_count = mysqli_num_rows($ops_query_result);
                    if($op_count >0){		
                        while ($row3 = $ops_query_result->fetch_assoc())
                        {
                            $opertion_names[]= ['op_name'=>$row3['operation_name'],'op_code'=>$row3['operation_code']];
                        }
                    }
                    $main_result['columns'] = $opertion_names;

                    
                    if(count($over_all_operations)>0){
                        $operation_codes_no = implode(',',$over_all_operations);
                        //columns Data
                        if($reptype == 1){
                            $get_data_bcd_temp= "SELECT style,SCHEDULE,color,input_job_no_random_ref,size_title,sum(original_qty) as job_qty,sum(recevied_qty) as recevied_qty,sum(rejected_qty) as rejected_qty,bundle_number,assigned_module,input_job_no,operation_id as op_code,remarks FROM brandix_bts.`bundle_creation_data_temp` WHERE style='".$style."' AND operation_id in ($operation_codes_no) GROUP BY bundle_number,operation_id order by bundle_number,operation_id";
                        } 
                        else{
                            $get_data_bcd_temp= "SELECT style,SCHEDULE,color,input_job_no_random_ref,size_title,sum(original_qty) as job_qty,sum(recevied_qty) as recevied_qty,sum(rejected_qty) as rejected_qty,bundle_number,assigned_module,input_job_no,operation_id as op_code,remarks FROM brandix_bts.`bundle_creation_data_temp` WHERE style='".$style."' AND operation_id in ($operation_codes_no) GROUP BY SCHEDULE,input_job_no_random_ref,color,size_title,operation_id order by input_job_no_random_ref,size_title,operation_id";
                        }
               
                  
                        $result5 = $link->query($get_data_bcd_temp);
                        $operation_array = explode(",", $operation_codes_no);
                        $op_count1 = mysqli_num_rows($result5);
                        if($op_count1>0){
                            while($row5 = $result5->fetch_assoc()){
                                $rec_qty = (int)$row5['recevied_qty'];
                                $rej_qty = (int)$row5['rejected_qty'];
                                $data = ['style'=>trim($row5['style']),'schedule'=>$row5['SCHEDULE'],'input_job_no_random_ref'=>$row5['input_job_no_random_ref'],'input_job_no'=>$row5['input_job_no'],'bundle_number'=>$row5['bundle_number'],'color'=>trim($row5['color']),'size'=>trim($row5['size_title']),'rej'=>$rej_qty,$row5['op_code']=>$rec_qty, 'rec_qty' => $rec_qty,'op_code'=>$row5['op_code'],'org_qty'=>$row5['job_qty'],'assigned_module'=>$row5['assigned_module'],'remarks'=>$row5['remarks']];

                                $bundle_data[$row5['bundle_number']][] = $data;
                                $sewing_data[$row5['input_job_no_random_ref']][$row5['size_title']][] = $data;
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
                        if($reptype == 1) { 
                            $r_name = 'Bundle Wise Report';
                        } else {
                            $r_name = 'Sewing Job Wise Report';
                        }
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
                     
                    <div class='table-responsive' style='height:500px;overflow-y: scroll;'>
                    <table class='table table-bordered table-responsive' id='report' name='report'>
                    <tr class='info'><th>Style</th><th>Schedule</th><th>Color</th><th>Sewing Job Number</th>
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
                   
                    <?php
                    $job_num= '';
                    $bundle_num= '';
                    $size= '';
                    if($reptype == 1){
                        foreach($all_bundles as $key => $value){ 
                            $prefix = echo_title("$brandix_bts.tbl_sewing_job_prefix","prefix","prefix_name",$bundle_data[$value][0]['remarks'],$link);
							$job_number = $prefix.leading_zeros($bundle_data[$value][0]['input_job_no'],3);
                            ?>
                        <tr>
                            <td><?= $bundle_data[$value][0]['style']  ?></td>
                            <td><?= $bundle_data[$value][0]['schedule']  ?></td>
                            <td><?= $bundle_data[$value][0]['color']  ?></td>
                            <td><?= $job_number  ?></td>
							<td><?= $value ?></td>
							<td><?= $bundle_data[$value][0]['org_qty']  ?></td>                            
                            <td><?= $bundle_data[$value][0]['assigned_module']  ?></td>
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
                                $prefix = echo_title("$brandix_bts.tbl_sewing_job_prefix","prefix","prefix_name",$size_values[0]['remarks'],$link);
								$job_number = $prefix.leading_zeros($size_values[0]['input_job_no'],3);
                            ?>
                            <tr>
                                <td><?= $size_values[0]['style']  ?></td>
                                <td><?= $size_values[0]['schedule']  ?></td>
                                <td><?= $size_values[0]['color']  ?></td>
                                <td><?= $job_number  ?></td>
								<td><?= $size_values[0]['org_qty']  ?></td>
                                <td><?= $size_values[0]['size']  ?></td>


                                <?php
                                    foreach($operation_array as $main_op_key => $main_op_value ) {
                                        if(in_array($main_op_value, array_column($size_values, 'op_code'))){
                                            $filter = array_search($main_op_value, array_column($size_values, 'op_code'));
                                            if($filter >= 0){
                                                echo "<td>". $size_values[$filter]['rec_qty'] ."</td>";
                                                echo "<td>". $size_values[$filter]['rej'] ."</td>";
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
                    </table>
                    </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">

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
// function getCSVData() {
//     var reptype = $('#reptype').val();
//   $('table').attr('border', '1');
//   $('table').removeClass('table-bordered');
//   var uri = 'data:application/vnd.ms-excel;base64,'
//     , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
//     , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
//     , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  
//     var table = document.getElementById('report').innerHTML;
//     // $('thead').css({"background-color": "blue"});
//     if(reptype == 1){
//         var report_name = 'Bundle Wise Report';
//     } else {
//         var report_name = 'Sewing Job Wise Report';
//     }
//     var ctx = {worksheet: name || report_name, table : table}
//     //window.location.href = uri + base64(format(template, ctx))
//     var link = document.createElement("a");
//     link.download = report_name+".xls";
//     link.href = uri + base64(format(template, ctx));
//     link.click();
//     $('table').attr('border', '0');
//     $('table').addClass('table-bordered');
// }
$(document).ready(function(){
    document.getElementById('reptype').value = "<?php echo $_POST['reptype'];?>";
    $('#reset').addClass('btn btn-warning btn-xs');
    var btn = document.getElementById('show');
    // var btn1 = document.getElementById('excel');
    btn.disabled = true;
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
    var style = $('#style').val();
    var reptype = $('#reptype').val();
    // alert(style);
    // alert(reptype);
    if(style != '' && reptype != null) {
        var btn = document.getElementById('show');
        // var btn1 = document.getElementById('excel');
        btn.disabled = false;
        // btn1.disabled = false;
    }
    
    //  else{
    //     sweetAlert('Style and Report Type','Should not be Empty!','warning');

    // }
}
</script>
<style>
	table
{
	font-family:calibri;
	font-size:15px;
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
</style>
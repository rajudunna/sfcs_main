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
                    $sql="SELECT DISTINCT order_style_no FROM $bai_pro3.packing_summary_input";	
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
                    <option value=1>Bundle Level Report</option>
                    <option value=2 selected>Sewing Job Level Report</option>
                    </select>
                </div>
                <div class="col-md-1"><br/>
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
                    $get_operations_workflow= "select DISTINCT(operation_code),default_operration from $brandix_bts.default_operation_workflow where operation_code IN (SELECT operation_code FROM $brandix_bts.tbl_orders_ops_ref WHERE category='sewing') order by operation_order*1";
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
                            $get_operations_no= "select DISTINCT(operation_id) from $brandix_bts.bundle_creation_data_temp where style = '$style' and operation_id ='".$value['op_code']."'";
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
                            $get_data_bcd_temp= "SELECT style,SCHEDULE,color,input_job_no_random_ref,size_title,sum(recevied_qty) as recevied_qty,sum(rejected_qty) as rejected_qty,bundle_number,input_job_no,operation_id as op_code FROM brandix_bts.`bundle_creation_data_temp` WHERE style='".$style."' AND operation_id in ($operation_codes_no) GROUP BY style,SCHEDULE,color,size_title,bundle_number,operation_id order by bundle_number,operation_id";
                        } 
                        else{
                            $get_data_bcd_temp= "SELECT style,SCHEDULE,color,input_job_no_random_ref,size_title,sum(recevied_qty) as recevied_qty,sum(rejected_qty) as rejected_qty,bundle_number,input_job_no,operation_id as op_code FROM brandix_bts.`bundle_creation_data_temp` WHERE style='".$style."' AND operation_id in ($operation_codes_no) GROUP BY style,SCHEDULE,color,input_job_no_random_ref,size_title,operation_id order by input_job_no_random_ref,size_title,operation_id";
                        }
               
                  
                        $result5 = $link->query($get_data_bcd_temp);
                        $operation_array = explode(",", $operation_codes_no);
                        $op_count1 = mysqli_num_rows($result5);
                        function myfunction($job_num_old,$size_old,$total_data, $all_operations)
                        {
                            $response['status'] = false;
                            $old_operations = array_column($total_data, "op_code");
                            $diff_operations = array_diff($all_operations, $old_operations);
                            if(sizeof($diff_operations) > 0){
                                $response['status'] = true;
                                $response['diff_operations'] = $diff_operations;
                            }
                            return $response;
                        }
                        function myfunction1($job_num_old,$bun_num_old,$size_old,$total_data, $all_operations)
                        {
                            $response['status'] = false;
                            $old_operations = array_column($total_data, "op_code");
                            $diff_operations = array_diff($all_operations, $old_operations);
                            if(sizeof($diff_operations) > 0){
                                $response['status'] = true;
                                $response['diff_operations'] = $diff_operations;
                            }
                            return $response;
                        }
                        if($op_count1>0){
                            $job_num_old = null;
                            $bun_num_old = null;
                            $size_old = null;
                            $total_data_current=[];
                            while($row5 = $result5->fetch_assoc()){
                               
                                if($row5['recevied_qty'])
                                {
                                    if($reptype == 1){
                                        // to get null values of non existing operations of bundle numbers
                                        if($bun_num_old == null && $size_old == null) {
                                            $bun_num_old = $row5['bundle_number'];
                                            $size_old = trim($row5['size_title']);
                                        }else {
                                            if(($bun_num_old != $row5['bundle_number'])) {
                                                $fun_add_missed = myfunction1($job_num_old,$bun_num_old,$size_old,$total_data_current, $operation_array);
                                                if($fun_add_missed['status']){
                                                  
                                                    foreach($fun_add_missed['diff_operations'] as $key => $value){
                                                        $data = ['style'=>trim($row5['style']),'schedule'=>$row5['SCHEDULE'],'input_job_no_random_ref'=>$job_num_old,'bundle_number'=>$bun_num_old,'color'=>trim($row5['color']),'size'=>$size_old,$value=>0,'rej'=>0,'op_code'=>$value];
                                                        array_push($total_data,$data);
                                                    }
                                                }
                                                $total_data_current = [];
                                            }
                                        }
                                    }
                                    if($reptype == 2){
                                        if($job_num_old == null && $size_old == null) {
                                            $job_num_old = $row5['input_job_no_random_ref'];
                                            $size_old = trim($row5['size_title']);
                                        }else {
                                            
                                            if(($job_num_old == $row5['input_job_no_random_ref'] || $job_num_old != $row5['input_job_no_random_ref'])  && $size_old != trim($row5['size_title'])) {
                                                $fun_add_missed = myfunction($job_num_old,$size_old, $total_data_current, $operation_array);
                                                if($fun_add_missed['status']){
                                                    foreach($fun_add_missed['diff_operations'] as $key => $value){
                                                        $data = ['style'=>trim($row5['style']),'schedule'=>$row5['SCHEDULE'],'input_job_no_random_ref'=>$job_num_old,'bundle_number'=>$row5['bundle_number'],'color'=>trim($row5['color']),'size'=>$size_old,$value=>0,'rej'=>0,'op_code'=>$value];
                                                        array_push($total_data,$data);
                                                    }
                                                }
                                                $total_data_current = [];
                                            }
                                        }
                                    }
                                    $job_num_old = $row5['input_job_no_random_ref'];
                                    $bun_num_old = $row5['bundle_number'];
                                    $size_old = trim($row5['size_title']);
                                    

                                   
                                    $rec_qty = (int)$row5['recevied_qty'];
                                    $rej_qty = (int)$row5['rejected_qty'];
                                    $data = ['style'=>trim($row5['style']),'schedule'=>$row5['SCHEDULE'],'input_job_no_random_ref'=>$row5['input_job_no_random_ref'],'input_job_no'=>$row5['input_job_no'],'bundle_number'=>$row5['bundle_number'],'color'=>trim($row5['color']),'size'=>trim($row5['size_title']),'rej'=>$rej_qty,$row5['op_code']=>$rec_qty,'op_code'=>$row5['op_code']];
                                   
                                    array_push($total_data,$data);
                                    array_push($total_data_current,$data);
                                    
                                }
                            }
                        }
                    }
                   
                   
                    $main_result['data'] = $total_data;
                    // var_dump($main_result['data']);die();
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
                            <input type="submit" class="btn btn-info" id="expexc" name="expexc" value="Export Excel" onclick="getCSVData()">
                            </form>';
                        echo '</div>';
                    echo '</div>';

                     ?>
                     
                    <div class='table-responsive'>
                    <table class='table table-bordered table-responsive' id='report' name='report'>
                    <tr class='info'><td>Style</td><td>Schedule</td><td>Color</td><td>Sewing Job Number</td>
                     <?php
                     // Bundle Wise Report
                     if($reptype == 1){ ?>
                     <td>Bundle Number</td>
                     <?php  } ?>
                    <td>Size</td>
                    <?php
                    $op_count=sizeof($main_result['columns']);
                    foreach($main_result['columns'] as $key1=>$value1){
                    ?>
                        <td style='text-align:center'><?= $value1['op_name']."-".$value1['op_code']; ?></td>
                        <td></td>
                    <?php
                    }
                    ?>
                    </tr>
                    <tr class='warning'><td></td><td></td><td></td><td></td>
                     <?php
                     // Bundle Wise Report
                     if($reptype == 1){ ?>
                     <td></td>
                     <?php  } ?>
                    <td></td>
                    <?php
                    $op_count=sizeof($main_result['columns']);
                    foreach($main_result['columns'] as $key1=>$value1){
                    ?>
                        <td>Good</td>
                        <td>Rejected</td>
                    <?php
                    }
                    $job_num= '';
                    $bundle_num= '';
                    $size= '';
                    
                    if($reptype == 1){
                        foreach($main_result['data'] as $key=>$value){
                            if($bundle_num != $value['bundle_number']) {
                                ?></tr><?php
                            }
                            if($bundle_num != $value['bundle_number']){ 
                                $job_number = get_sewing_job_prefix_inp("prefix","$brandix_bts.tbl_sewing_job_prefix",$value['input_job_no'],$value['input_job_no_random_ref'],$link);
                            ?>
                                <tr>
                                <td><?=$value['style']; ?></td>
                                <td><?=$value['schedule']; ?></td>
                                <td><?=$value['color']; ?></td>
                                <td><?=$job_number; ?></td>
                                <?php if($reptype == 1){ ?>
                                    <td><?=$value['bundle_number']; ?></td>
                                <?php  } ?>
                                <td><?=$value['size']; ?></td>
                                <td><?=$value[$value['op_code']]; ?></td>
                                <td><?=$value['rej']; ?></td>
                            <?php } else { ?>
                                <td><?=$value[$value['op_code']]; ?></td>
                                <td><?=$value['rej']; ?></td>
                                <?php }
                                $bundle_num = $value['bundle_number'];
                        }

                    }
                    // var_dump($main_result['data']);
                    // die();
                        // for Report Type Sewing Number
                    if($reptype == 2){
                        foreach($main_result['data'] as $key1=>$value1){
                            // var_dump($value1);
                            // die();
                            if($job_num != $value1['input_job_no_random_ref'] || $size != $value1['size']) {
                                ?>
                              </tr> <?php
                            }
                            if($job_num != $value1['input_job_no_random_ref'] || $size != $value1['size'])
                            {
                                $job_number = get_sewing_job_prefix_inp("prefix","$brandix_bts.tbl_sewing_job_prefix",$value1['input_job_no'],$value1['input_job_no_random_ref'],$link);
                                ?>
                                <tr>
                                <td><?=$value1['style']; ?></td>
                                <td><?=$value1['schedule']; ?></td>
                                <td><?=$value1['color']; ?></td>
                                <td><?=$job_number; ?></td>
                                <td><?=$value1['size']; ?></td>
                                <td><?=$value1[$value1['op_code']]; ?></td>
                                <td><?=$value1['rej']; ?></td>
                            <?php
                            } else { ?> 
                                <td><?=$value1[$value1['op_code']]; ?></td>
                                <td><?=$value1['rej']; ?></td>
                            <?php
                            }
                            $job_num = $value1['input_job_no_random_ref'];
                            $size = $value1['size'];
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
 var csv_value=$('#report').table2CSV({delivery:'value'});
 $("#csv_text").val(csv_value);	
}
$(document).ready(function(){
    document.getElementById('reptype').value = "<?php echo $_POST['reptype'];?>";
    $('#reset').addClass('btn btn-warning btn-xs');
    var btn = document.getElementById('show');
    btn.disabled = true;
});

$('#reset').addClass('btn btn-warning');
	var table6_Props = 	{
                            // col_0: "select", 
                            // col_1: "select", 
                            // col_2: "select", 
                            // col_3: "select", 
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
        btn.disabled = false;
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
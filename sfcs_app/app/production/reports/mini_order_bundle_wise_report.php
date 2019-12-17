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
$style=$_POST['style'];
$reptype=$_POST['reptype'];

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
                    echo "<select class='form-control' name=\"style\"  id=\"style\" id='style'>";
    
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
                    <label for='reptype'>Report : </label>
                    <select class='form-control' name="reptype" id='reptype'>
                    <option value=1>Bundle Level Report</option>
                    <option value=2 selected>Sewing Job Level Report</option>
                    </select>
                </div>
                <div class="col-md-1"><br/>
                    <input class="btn btn-success" type="submit" value="Show" onclick="verify_input();" name="submit">
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
                   
                    if(count($over_all_operations)>0){
                        $operation_codes_no = implode(',',$over_all_operations);
                        //columns Data
                        if($reptype == 1){
                            $get_data_bcd_temp= "SELECT style,SCHEDULE,color,input_job_no_random_ref,size_title,sum(recevied_qty) as recevied_qty,bundle_number,operation_id as op_code FROM brandix_bts.`bundle_creation_data_temp` WHERE style='".$style."' AND operation_id in ($operation_codes_no) GROUP BY style,SCHEDULE,color,size_title,bundle_number,operation_id order by bundle_number,operation_id";
                        } 
                        else{
                            $get_data_bcd_temp= "SELECT style,SCHEDULE,color,input_job_no_random_ref,size_title,sum(recevied_qty) as recevied_qty,bundle_number,operation_id as op_code FROM brandix_bts.`bundle_creation_data_temp` WHERE style='".$style."' AND operation_id in ($operation_codes_no) GROUP BY style,SCHEDULE,color,input_job_no_random_ref,size_title,operation_id order by input_job_no_random_ref,size_title,operation_id";
                        }
               
                    //    echo $get_data_bcd_temp;
                    //    die();
                        $result5 = $link->query($get_data_bcd_temp);
                        $op_count1 = mysqli_num_rows($result5);
                        if($op_count1>0){
                            while($row5 = $result5->fetch_assoc()){
                                if($row5['recevied_qty'])
                                {
                                    $rec_qty = (int)$row5['recevied_qty'];
                                    $data = ['style'=>trim($row5['style']),'schedule'=>$row5['SCHEDULE'],'input_job_no_random_ref'=>$row5['input_job_no_random_ref'],'bundle_number'=>$row5['bundle_number'],'color'=>trim($row5['color']),'size'=>trim($row5['size_title']),$row5['op_code']=>$rec_qty,'op_code'=>$row5['op_code']];
                                    array_push($total_data,$data);
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
                    $main_result['data'] = $total_data;
                    echo '<div class="row">';
                        echo '<div class="col-md-4">';
                        if($reptype == 1) { 
                            $r_name = 'Bundle Wise Report';
                        } else {
                            $r_name = 'Mini Order Wise Report';
                        }
                        echo "<h3>&nbsp; $r_name <span><b>Style :</b>".$style."</span></h3>";
                        echo '</div>';
                        echo '<div class="col-md-7">';
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
                    <tr class='info'><th>Style</th><th>Schedule</th><th>Color</th><th>Sewing Job Number</th>
                     <?php
                     // Bundle Wise Report
                     if($reptype == 1){ ?>
                     <th>Bundle Number</th>
                     <?php  } ?>
                    <th>Size</th>
                    <?php
                    $op_count=sizeof($main_result['columns']);
                    foreach($main_result['columns'] as $key1=>$value1){
                    ?>
                        <th><?= $value1['op_name']; ?></th>
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
                            if($bundle_num != $value['bundle_number']){ ?>
                                <tr>
                                <td><?=$value['style']; ?></td>
                                <td><?=$value['schedule']; ?></td>
                                <td><?=$value['color']; ?></td>
                                <td><?=$value['input_job_no_random_ref']; ?></td>
                                <?php if($reptype == 1){ ?>
                                    <td><?=$value['bundle_number']; ?></td>
                                <?php  } ?>
                                <td><?=$value['size']; ?></td>
                                <td><?=$value[$value['op_code']]; ?></td>
                            <?php } else { ?>
                                <td><?=$value[$value['op_code']]; ?></td>
                                <?php }
                                $bundle_num = $value['bundle_number'];
                        }

                    }
                    // var_dump($main_result['data']);
                    // die();
                        // for Report Type Sewing Number
                    if($reptype == 2){
                        foreach($main_result['data'] as $key1=>$value1){
                            if($job_num != $value1['input_job_no_random_ref'] || $size != $value1['size']) {
                                ?>
                              </tr> <?php
                            }
                            if($job_num != $value1['input_job_no_random_ref'] || $size != $value1['size']){ ?>
                                <tr>
                                <td><?=$value1['style']; ?></td>
                                <td><?=$value1['schedule']; ?></td>
                                <td><?=$value1['color']; ?></td>
                                <td><?=$value1['input_job_no_random_ref']; ?></td>
                                <td><?=$value1['size']; ?></td>
                                <td><?=$value1[$value1['op_code']]; ?></td>
                            <?php
                            } else { ?> 
                                <td><?=$value1[$value1['op_code']]; ?></td> <?php
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
	
function verify_input(){
    var style = $('#style').val();
    var reptype = $('#reptype').val();

    if(style == '' && reptype == '') {
        sweetAlert('Style and Report Type','Should not be Empty!','warning');
    }
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
/* table th
{
	border: 1px solid black;
	text-align: center;
	background-color: #337ab7;
	border-color: #337ab7;
	color: WHITE;
	white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
} */

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
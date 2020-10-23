
<?php include $_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/config.php', 3, 'R');
include $_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/enums.php', 3, 'R');
$sawing_out_excel = '' . getFullURL($_GET['r'], 'sawing_out_excel.php', 'R');?>
<style>
	th{
		background-color: #003366;
		color: WHITE;
		border-bottom: 5px solid white;
		border-top: 5px solid white;
		padding: 5px;
		white-space:nowrap;
		border-collapse:collapse;
		text-align:center;
		font-family:Calibri;
		font-size:110%;
	}
	table{
		white-space:nowrap;
		border-collapse:collapse;
		font-size:12px;
		background-color: white;
	}
	td {
		color:black;
		font-size:12px;
		font-weight:bold;
		text-align:center;
	}
	a {
		color:white;
	}
</style>

<script type="text/javascript" src="<?=getFullURLLevel($_GET['r'], 'common/js/TableFilter_EN/actb.js', 3, 'R');?>"></script>
<script type="text/javascript" src="<?=getFullURLLevel($_GET['r'], 'common/js/TableFilter_EN/tablefilter.js', 3, 'R');?>"></script>

<script type="text/javascript">
	function check_sch()
	{
		var sch =document.getElementById('sch').value;
		if(sch=='')
		{
			sweetAlert('Please Enter Schedule Number','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}


jQuery(document).ready(function($){
    $('#sch').keypress(function (e) {
        var regex = new RegExp("^[0-9\]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });
});

function pop_check()
{
var iChars = "!@#$%^&*()+=-a-zA-Z[]\\\';,./{}|\":<>?";

for (var i = 0; i < document.input2.sch.value.length; i++)
 {
    if (iChars.indexOf(document.input2.sch.value.charAt(i)) != -1)
     {
       sweetAlert('Please Enter Valid Schedule Number','','warning')
       document.input2.sch.value='';
        return false;
    }

}
}
</script>
<script type="text/javascript">
function verify_date()
{
	var val1 = $('#dat1').val();
	var val2 = $('#dat2').val();

	if(val1 > val2)
	{
		sweetAlert('Start Date Should  be less than End Date','','warning');
		return false;
	}
	else
	{
	return true;
	}

}
</script>

<div class="panel panel-primary">
<div class="panel-heading">Carton Out Report</div>
<div class="panel-body">

<?php $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
$dattime = $date->format('Y-m-d');
$date1 = date('Y-m-d', (strtotime('-1 day', strtotime($dattime))));?>
<form name="input2" method="post" class="form_inline" action=<?php getFullURLLevel($_GET['r'], 'sawing_out_report.php', 0, 'N')?>>
<div class="row">
	<!-- date1=2018-02-15;date1=2018-02-20;-example -->
	<div class="col-md-3"><label>Start Date </label>
		<?php echo '<input type="text" data-toggle="datepicker" onchange="return verify_date();"  class="form-control" id="dat1" name="dat1" value="' . $date1 . '">'; ?>
		<!-- <input type='date' class="form-control" id='int' value="<?=$date1;?>" name='dat1' width=30 required> -->
	</div>
	<div class="col-md-3"><label>End Date </label>
		<!-- <input type='date' class="form-control" id='int' value="<?=$dattime;?>" name='dat2' width=30 required> -->
		<?php echo '<input type="text" data-toggle="datepicker" class="form-control" id="dat2" name="dat2" onchange="return verify_date();" value="' . $dattime . '">'; ?>
	</div>
	<div class="col-md-3"><label>Schedule </label><input type='text' class="form-control" id='sch'
	     name='sch' width=30  onchange="return pop_check()"></div>
	<div class="col-md-2"><br/><input type="submit" id='btn'  class="btn btn-primary" value="View" name="submit" id='sub'></div>
</div>
</form>
<br>
<?php
if (isset($_POST['submit'])) {
    $dat1 = $_POST['dat1'];
    $dat2 = $_POST['dat2'];
    $sch = $_POST['sch'];

    // if($sch=="")
    // {
    $psj = TaskTypeEnum::PLANNEDSEWINGJOB;
    $psej = TaskTypeEnum::PLANNEDSEWEMBELLISHMENTJOB;
    $sql = "SELECT barcode,parent_job,shift,created_at as date FROM $pts.`transaction_log` WHERE plant_code='$plant_code' AND DATE(created_at) BETWEEN '$dat1' AND '$dat2' AND parent_job_type IN ('$psj','$psej')";
    $sql = $sch ? $sql . " AND schedule='$sch'" : $sql;
    // }
    // else if($sch !="")
    // {
    // $sql="SELECT tl.barcode_id as barcode_id,tl.parent_ext_ref_id as parent_ext_ref_id,tl.created_at as created_at FROM $pts.`transaction_log` tl
    // LEFT JOIN $pts.`fg_barcode` fb ON fb.`barcode_id`=tl.`barcode_id`
    // LEFT JOIN $pts.`finished_good` fg ON fg.`finished_good_id`=fb.`finished_good_id`
    // WHERE DATE(tl.`created_at`) BETWEEN '$dat1' AND '$dat2' AND fg.`schedule`='$sch'";
    // }
    // echo $sql;
    $sql_result = mysqli_query($link, $sql) or exit("Error While Getting transaction log" . $sql . mysqli_error($GLOBALS["___mysqli_ston"]));

    if (mysqli_num_rows($sql_result) > 0) {
        ?>
			<?="<div class='btn btn-success pull-right' style='font-weight:bold;color:WHITE;'><a href='$sawing_out_excel?sdate=$dat1&edate=$dat2'>Export to Excel</a></div>";?>
			<div class="col-md-12 table-responsive" style="max-height:900px;overflow-y:scroll;">
				<table id="table5" class="table table-bordered">
					<tr>
					    <th>Barcode ID</th>
						<th>Date and Time</th>
						<th>Style</th>
						<th>Schedule</th>
						<th>Color</th>
						<th>Size</th>
						<th>Qty</th>
					</tr>
					<?php
while ($sql_row = mysqli_fetch_array($sql_result)) {
            $barcode = $sql_row['barcode'];
            $parent_job = $sql_row['parent_job'];
            $shift = $sql_row['shift'];
            $date = $sql_row['date'];
            //getting barcode id
            $sql_barcode_qry = "Select barcode_id from $pts.barcode where barcode='$barcode' AND plant_code='$plant_code'";
            $sql_result_det = mysqli_query($link, $sql_barcode_qry) or exit("Sql Error getting barcode id" . $sql_barcode_qry . mysqli_error($GLOBALS["___mysqli_ston"]));
            while ($sql_row_id = mysqli_fetch_array($sql_result_det)) {
                $barcode_id = $sql_row_id['barcode_id'];
            }
            //getting parent_ext_ref_id
            $sql_ext_ref_qry = "select jm_jg_header_id from $pps.jm_jg_header where job_number='$parent_job' AND plant_code='$plant_code'";
            $sql_result_data = mysqli_query($link, $sql_ext_ref_qry) or exit("Sql Error getting jm_jg_header_id" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while ($sql_row_ref = mysqli_fetch_array($sql_result_data)) {
                $parent_ext_ref_id = $sql_row_ref['jm_jg_header_id'];
            }

            //getting finished good id
            $get_finshgood_qry = "SELECT finished_good_id FROM $pts.`fg_barcode` WHERE barcode_id='$barcode_id' AND plant_code='$plant_code'";
            $get_finshgood_qry_result = mysqli_query($link, $get_finshgood_qry) or exit("Sql Error finished_good_id" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while ($get_finshgood_qry_row = mysqli_fetch_array($get_finshgood_qry_result)) {
                $finished_good_id = $get_finshgood_qry_row['finished_good_id'];
                //getting style,schedule,color,size
                $get_det_qry = "SELECT style,schedule,color,size FROM $pts.`finished_good` WHERE finished_good_id='$finished_good_id' AND plant_code='$plant_code'";
                $get_det_qry_result = mysqli_query($link, $get_det_qry) or exit("Sql Error getting details" . mysqli_error($GLOBALS["___mysqli_ston"]));
                while ($get_det_qry_row = mysqli_fetch_array($get_det_qry_result)) {
                    $style = $get_det_qry_row['style'];
                    $schedule = $get_det_qry_row['schedule'];
                    $color = $get_det_qry_row['color'];
                    $size = $get_det_qry_row['size'];
                    //getting task job id
                    $get_taskjobid_qry = "SELECT task_jobs_id FROM $tms.`task_jobs` WHERE task_job_reference='$parent_ext_ref_id' AND plant_code='$plant_code'";
                    $get_taskjobid_qry_result = mysqli_query($link, $get_taskjobid_qry) or exit("Sql Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while ($get_taskjobid_qry_result_row = mysqli_fetch_array($get_taskjobid_qry_result)) {
                        $task_jobs_id = $get_taskjobid_qry_result_row['task_jobs_id'];
                    }
                    //getting max operation
                    $qrytoGetMaxOperation = "SELECT operation_code FROM $tms.`task_job_transaction` WHERE task_jobs_id='" . $task_jobs_id . "' AND plant_code='$plant_code' AND is_active=1 ORDER BY operation_seq DESC LIMIT 0,1";
                    $maxOperationResult = mysqli_query($link_new, $qrytoGetMaxOperation) or exit('Problem in getting operations data for job');
                    if (mysqli_num_rows($maxOperationResult) > 0) {
                        while ($minOperationResultRow = mysqli_fetch_array($maxOperationResult)) {
                            $maxOperation = $minOperationResultRow['operation_code'];
                        }
                    }

                    //getting quantity
                    $get_quant_qry = "select sum(good_quantity) as quantity from $tms.`task_job_transaction` WHERE task_jobs_id='" . $task_jobs_id . "' AND plant_code='$plant_code' AND is_active=1 and operation_code=$maxOperation";
                    $get_quant_qry_result = mysqli_query($link_new, $get_quant_qry) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
                    while ($get_quant_qry_row = mysqli_fetch_array($get_quant_qry_result)) {
                        $quantity = $get_quant_qry_row['quantity'];
                    }

                    echo "<tr>";
                    echo "<td>" . $barcode . "</td>";
                    echo "<td>" . $date . "</td>";
                    echo "<td>" . $style . "</td>";
                    echo "<td>" . $schedule . "</td>";
                    echo "<td>" . $color . "</td>";
                    echo "<td>" . $size . "</td>";
                    echo "<td>" . $quantity . "</td>";
                    echo "</tr>";

                }
            }

        }
        echo "</table>
			</div>";
    } else {
        echo "<script>sweetAlert('No data Found','','warning')</script>";
    }
}
?>
</div>
</div>
<script language="javascript" type="text/javascript">

var table3Filters = {
		btn: true,
		display_all_text: "All",
		col_1: "select",
		col_2: "select",
		col_3: "select",
		col_4: "select",
		exact_match: true,
		alternate_rows: true,
		loader: true,
		loader_text: "Filtering data...",
		loader: true,
		btn_reset_text: "Clear",

		btn_text: "Filter"
	}
	setFilterGrid("table5",table3Filters);
</script>
</div>
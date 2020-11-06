
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
    $PCRT = BarcodeType::PCRT;
    $psej = TaskTypeEnum::PLANNEDSEWEMBELLISHMENTJOB;
    if($sch == '')
    {
        $sql = "SELECT barcode,parent_job,shift,style,schedule,color,size,sum(good_quantity) as quantity,created_at as date FROM $pts.`transaction_log` WHERE plant_code='Q01' AND DATE(created_at) BETWEEN '$dat1' AND '$dat2' AND parent_job_type='$PCRT' GROUP BY style,schedule,color,size";
    } else
    {
        $sql = "SELECT barcode,parent_job,shift,style,schedule,color,size,sum(good_quantity) as quantity,created_at as date FROM $pts.`transaction_log` WHERE plant_code='Q01' AND DATE(created_at) BETWEEN '$dat1' AND '$dat2' AND parent_job_type='$PCRT' AND schedule='$sch' GROUP BY style,schedule,color,size";
    }

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
                if($sql_row['quantity'] > 0)
                {
                    echo "<tr>";
                    echo "<td>" . $sql_row['barcode'] . "</td>";
                    echo "<td>" . $sql_row['date'] . "</td>";
                    echo "<td>" . $sql_row['style'] . "</td>";
                    echo "<td>" . $sql_row['schedule'] . "</td>";
                    echo "<td>" . $sql_row['color'] . "</td>";
                    echo "<td>" . $sql_row['size'] . "</td>";
                    echo "<td>" . $sql_row['quantity'] . "</td>";
                    echo "</tr>";
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

<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R') );  ?>

<style>
	.flt{
		width:100%;
	}
	
</style>

<?php
$plant_code = $_SESSION['plantCode'];
$username = $_SESSION['userName'];
// $plant_code = 'AIP';
?>

<script>
function verify_date(e){
	var from = document.getElementById('sdate').value;
	var to =   document.getElementById('edate').value;
	var h1 = document.getElementById('h1').value;
	var h2 =   document.getElementById('h2').value;
	if(from > to){
		sweetAlert('From date should not be greater than To Date','','warning');
		e.preventDefault();
		return false;
	}
	if(Number(h1) > Number(h2)){
		sweetAlert('Start Hour should not be greater than End Hour','','warning');
		e.preventDefault();
		return false;
	}
	return true;
}
</script>



</style>

<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/actb.js',3,'R'); ?>"></script><!-- External script -->
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<!-- </head> -->
<body onload="javascript:dodisable()">
<div class="panel panel-primary">
<div class="panel-heading">Carton Flow Report</div>
<div class="panel-body">
<form action="<?= '?r='.$_GET['r']; ?>" method="post">
<div class="row">
<div class="col-md-3">
<label>From Date</label>
<input type="text" data-toggle='datepicker' id='sdate'  name="dat" class="form-control" size="8" value="<?php  if(isset($_POST['dat'])) { echo $_POST['dat']; } else { echo date("Y-m-d"); } ?>" required/>
</div>
<div class="col-md-3">
<label>To Date</label>
<input type="text"  data-toggle='datepicker' id='edate' name="dat1" size="8" class="form-control" value="<?php  if(isset($_POST['dat1'])) { echo $_POST['dat1']; } else { echo date("Y-m-d"); } ?>" required/>
</div>
<div class="col-md-2">
<label>Hour From: </label>
<select id='h1' name="hour" class="form-control">
	<?php
		for($i=0;$i<=23;$i++)
		{
			$j=$i+1;
			if($i<13)
			{
				$suffix="";
				if($i<10)
				{
					$suffix=0;
				}				
				echo "<option value=\"".$i."\">".$suffix."".$i." AM</option>";
			}
			else
			{
				$i1=$i-12;
				$suffix1="";
				if($i1<10)
				{
					$suffix1=0;
				}	
				echo "<option value=\"".$i."\">".$suffix1."".$i1." PM</option>";
			}
			
		}	
	?>
</select>
</div>
<div class="col-md-2" class="form-control">
<label>Hour To:</label> 
<select id='h2' name="hour1" class="form-control">
	<?php	
		for($i=0;$i<=23;$i++)
		{
			if($i<13)
			{
				$suffix="";
				if($i<10)
				{
					$suffix=0;
				}				
				echo "<option value=\"".$i."\">".$suffix."".$i." AM</option>";
			}
			else
			{
				$i1=$i-12;
				$suffix1="";
				if($i1<10)
				{
					$suffix1=0;
				}	
				echo "<option value=\"".$i."\">".$suffix1."".$i1." PM</option>";
			}
			
		}	
	?>
</select>
</div>
<div class="col-md-2">
<?php echo "<input type=\"submit\" value=\"submit\" class='btn btn-success' name=\"submit\" id=\"submit\" style='margin-top:22px;' onclick='return verify_date(event)'>";
    ?>
</div>
</div>
<br>
<?php  echo "<div class='alert alert-info' role='alert' id='msg1'style='display:none;'>Please Wait...!</div>";?>
</form>


<?php
if(isset($_POST["submit"]))
{

	$sdate=$_POST["dat"];
	$edate=$_POST["dat1"];
	$hour_from=$_POST["hour"];
	$hour_to=$_POST["hour1"];
	
	set_time_limit(10000000);
	
	$size = $sizes_array;

	$day=0;
	$sdate_split=explode("-",$sdate);
	
	$mtime="$hour_from:00:00";
	$hr_dif=($hour_to-1);
	
	if($hr_dif < 0)
	{
		$hr_dif=0;
	}
	
	$aftime1="".($hr_dif).":59:59";
	
	do
	{
		$dates[]=date("Y-m-d",mktime(0, 0, 0, $sdate_split[1]  , $sdate_split[2]+$day, $sdate_split[0]));
		$test_date=date("Y-m-d",mktime(0, 0, 0, $sdate_split[1]  , $sdate_split[2]+$day, $sdate_split[0]));
		$day=$day+1;
	}while($test_date!=$edate);	
	
	$time_stamp="AM";
	$time_stamp1="AM";
	
	if($hour_from >= 12)
	{
		$time_stamp="PM";
		$hour_from=$hour_from-12;
	}
	
	if($hour_to >= 12)
	{
		$time_stamp1="PM";
		$hour_to=$hour_to-12;
	}

	echo "<div id='report'>";
	echo "<h2><label>Selected Period :-</label> From : <span class='label label-success'>".$hour_from."".$time_stamp."</span> To : <span class='label label-success'>".$hour_to."".$time_stamp1."</h2></span>";
	echo "<div class='table-responsive col-md-12' style='max-height:600px;overflow-y:scroll'>";
	echo "<table id=\"table1\" class=\"table table-bordered\" style='width:100%'>";
	echo "<tr class='danger'><th>TID</th><th>Size</th><th>Status</th><th>Last Updated</th><th>Carton Reported Qty</th><th>Style</th><th>Schedule</th><th>Color</th></tr>";
	$packing_tid_list=array();
	$sql="select barcode,size,updated_at,style,color,schedule,good_quantity from $pts.transaction_log where created_at between \"".$sdate." ".$mtime."\" and \"".$edate." ".$aftime1."\" and plant_code='$plant_code' order by created_at";
	
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysqli_error());
	if(mysqli_num_rows($sql_result))
	{

		while($sql_row=mysqli_fetch_array($sql_result))
		{

			$barcode=$sql_row['barcode'];
			$size=$sql_row['size'];
			$status='DONE';
			$updated_at=$sql_row['updated_at'];
			$style=$sql_row['style'];
			$schedule=$sql_row['schedule'];
			$color=$sql_row['color'];
			$good_quantity=$sql_row['good_quantity'];

			echo "<tr><td>".$barcode."</td><td>".$size."</td><td>".$status."</td><td>".$updated_at."</td><td>".$good_quantity."</td><td>".$style."</td><td>".$schedule."</td><td>".$color."</td></tr>";
		}
		echo '<tr><th colspan=4 style="text-align:right">Total:</th><td id="table1Tot1" style="background-color:#FFFFCC; color:red;"></td><td colspan=3></td></tr>';
		echo "</table>";
	
	}
	else
	{
		echo "<script>sweetAlert('No Data Found','','info')
			    $('#report').hide();
		 	  </script>";
	}

}
echo "</div>
	</div>";


?>

<script language="javascript" type="text/javascript">
$('#reset_table1').addClass('btn btn-warning');
var fnsFilters = {
	
	rows_counter: true,
	sort_select: true,
	btn_reset: true,
	alternate_rows: true,
	btn_reset_text: "Clear",
	col_operation: { 
						id: ["table1Tot1"],
						col: [4],  
						operation: ["sum"],
						decimal_precision: [1],
						write_method: ["innerHTML"] 
					},
	rows_always_visible: [grabTag(grabEBI('table1'),"tr").length]
	};
	
	 setFilterGrid("table1",fnsFilters);
	$(document).ready(function(){
		$('#reset_table1').addClass('btn btn-warning btn-xs');
	});
</script>

</div>
</div>
</div>
</div>
<style>
#reset_table1{
	width : 80px;
	color : #fff;
	margin : 10px;
}
</style>
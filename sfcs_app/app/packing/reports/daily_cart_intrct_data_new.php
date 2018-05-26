
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	      ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/php/header.php',1,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/php/ims_size.php',1,'R') );  ?>

<style>
th,td{ color : #000;}
</style>

<?php

if(isset($_POST['division']))
{
	$division=$_POST['division'];
}
else
{
	$division="All";
}
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
<script language="javascript" type="text/javascript" 
		src="<?= getFullURLLevel($_GET['r'],'common/js/tablefilter_en/table_filter.js', 3, 'R');?>" ></script>
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
	echo "<hr/>";
	$sdate=$_POST["dat"];
	$edate=$_POST["dat1"];
	//$shift=$_POST["division"];
	$hour_from=$_POST["hour"];
	$hour_to=$_POST["hour1"];
	
	//echo "<h3>From ".$_POST['dat']."&nbsp;&nbsp;&nbsp;To ".$_POST['dat1']."<br><br><h3>";
	set_time_limit(10000000);
	
	$sql_del="truncate table $bai_pro3.$table2";
	if(!mysqli_query($link,$sql_del))
	{
		die('Error'.mysqli_error());
	}
	
	$sql_insrt="INSERT INTO $bai_pro3.$table2 SELECT * FROM $bai_pro3.$table1 WHERE lastup between '$_POST[dat] 00:00:00' and '$_POST[dat1] 23:59:59'";
	//echo $sql_insrt;
	if(!mysqli_query($link,$sql_insrt))
	{
		die('Error'.mysqli_error());
	}
	
	//$size=array("XS","S","M","L","XL","XXL","S06","S08","S10","S12","S14","S16","S18","S20","S22","S24","S26","S28","S30"); 
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
	
	echo "<h2><label>Selected Period :-</label> From : <span class='label label-success'>".$hour_from."".$time_stamp."</span> To : <span class='label label-success'>".$hour_to."".$time_stamp1."</h2></span>";
	
	echo "<div class='table-responsive' style='max-height:600px;overflow-y:scroll'>";
	echo "<table id=\"table1\" class=\"table table-bordered\">";
	echo "<tr class='danger'><th>Docket</th><th>Docket Ref</th><th>TID</th><th>Size</th><th>Remarks</th><th>Status</th><th>Last Updated</th><th>Carton Act Qty</th><th>Style</th><th>Schedule</th><th>Color</th></tr>";
	$packing_tid_list=array();
	$sql="select * from bai_pro3.packing_summary where tid in (select tid from bai_pro3.pac_stat_log where scan_date between \"".$sdate." ".$mtime."\" and \"".$edate." ".$aftime1."\" and status=\"DONE\" order by scan_date)";
	// echo "<br>".$sql."<br>";
	// mysqli_query($link,$sql) or exit("Sql Error".mysqli_error());
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysqli_error());
	if(mysqli_num_rows($sql_result))
	{

	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$doc_no=$sql_row['doc_no'];
		$doc_no_ref=$sql_row['doc_no_ref'];
		$tid=$sql_row['tid'];
		$packing_tid_list[]=$sql_row['tid'];
		$size_code=$sql_row['size_code'];
		$remarks=$sql_row['remarks'];
		$status=$sql_row['status'];
		$lastup=$sql_row['lastup'];
		$container=$sql_row['container'];
		$disp_carton_no=$sql_row['disp_carton_no'];
		$disp_id=$sql_row['disp_id'];
		$carton_act_qty=$sql_row['carton_act_qty'];
		$audit_status=$sql_row['audit_status'];
		$order_style_no=$sql_row['order_style_no'];
		$order_del_no=$sql_row['order_del_no'];
		$order_col_des=$sql_row['order_col_des'];
		
		$size_value=ims_sizes('',$sql_row['order_del_no'],$sql_row['order_style_no'],$sql_row['order_col_des'],strtoupper(substr("a_".$sql_row['size_code'],2)),$link);
					

		echo "<tr><td>".$sql_row['doc_no']."</td><td>".$sql_row['doc_no_ref']."</td><td>".$sql_row['tid']."</td><td>".$size_value."</td><td>".$sql_row['remarks']."</td><td>".(strlen($sql_row['status'])==0?"Pending":$sql_row['status'])."</td><td>".$sql_row['lastup']."</td><td>".$sql_row['carton_act_qty']."</td><td>".$sql_row['order_style_no']."</td><td>".$sql_row['order_del_no']."</td><td>".$sql_row['order_col_des']."</td></tr>";
	}
	echo '<tr><td>Total:</td><td id="table2" style="background-color:#FFFFCC; color:red;"></td></tr>';
	}
	else
	{
		echo "<script>sweetAlert('No Data Found','','info')</script>";
	}
	echo "</table>
	</div>";
}


?>

<script language="javascript" type="text/javascript">
//<![CDATA[
	//setFilterGrid( "table1111" );

var fnsFilters = {
	
	rows_counter: true,
	sort_select: true,
		on_change: true,
		display_all_text: " [ Show all ] ",
		loader_text: "Filtering data...",  
	loader: true,
	loader_text: "Filtering data...",
	btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear",
	col_operation: { 
						id: ["table2"],
						 col: [7],  
						operation: ["sum"],
						 decimal_precision: [1],
						write_method: ["innerHTML"] 
					},
	rows_always_visible: [grabTag(grabEBI('table1'),"tr").length]
							
	
		
	};
	
	 setFilterGrid("table1",fnsFilters);
//]]>
</script>

</div>
</div>
</div>
</div>
<?php
	//chnages for recommit
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));	
	// $view_access=user_acl("SFCS_0173",$username,1,$group_id_sfcs);
	$has_permission=haspermission($_GET['r']);

	if(in_array($authorized,$has_permission))
	{
		
	}
	else
	{
		$url = getFullURLLevel($_GET['r'],'common/restricted.php',1,'N');
		header("Location:$url");
	}
?>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>

<script>

function location_ref(x)
{
	var rows=parseInt(document.getElementById("total_rows").value);
	var total_qty=0;
	for(var i=0;i<=rows;i++)
	{
		var location=document.getElementById("location["+i+"]").value;
		var n=parseInt(location.length);
		if(n > 0)
		{
				total_qty=total_qty+parseInt(document.getElementById("qty["+i+"]").value);
		}		
		else
		{
			total_qty=total_qty+0;
		}
		var output = document.getElementById('output');
		output.innerHTML = total_qty;
	}
}

function enable_button()
{
	var checkedStatus = document.getElementById("enable").checked;
	var month=document.getElementById("month").value; 
	var year=document.getElementById("year").value; 
	if(checkedStatus===true)
	{
		if(month!=0 && year!=0)
		{
			document.getElementById("add").disabled=false;
		}
		else
		{
			alert("Please Select All Fileds");
			document.getElementById("enable").checked=false;
			document.getElementById("add").disabled=true;
		}
	}
	else
	{
		document.getElementById("add").disabled=true;	
	}
}
</script>
<body onload="location_ref(1)">
<div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Confirm Destroy (Offered)</b>
	</div>
	<div class='panel-body'>
		<form name="filter" method="post" action="?r=<?= $_GET['r'] ?>">
			<div class="row">
				<div class='col-sm-3'>
					<label for='schlist'>Schedule</label>
					<input type="text" value="" class="form-control" id="schedule" name="schlist" onchange='schedulenumber()'/>
				</div>
				<div class='col-sm-3'>
					<br>
					<input type="checkbox" name="showall" value="1">(Y/N)Show all schedules.
				</div>
					<input type="submit" name="schsbt" value="Filter" class='btn btn-success' style="margin-top:22px;">
			</div>
		</form>
<?php
	if(isset($_POST['confirm'])) {
		
		$tid=$_POST['tid'];
		$location=$_POST['location'];
		$qty=$_POST['qty'];
		$style=$_POST['style'];
		$schedule=$_POST['schedule'];
		$color=$_POST['color'];
		$size=$_POST['size'];
		$mer_month=$_POST["month"];
		$mer_year=$_POST["year"];
		$mer_remarks=$_POST["txt_rem"];
		$mer_no=$mer_month."-".$mer_year;
		$check=0;

		for($i=0;$i<sizeof($tid);$i++) {
			if(strlen($location[$i])>0) {
				//To store the reserve locations cartons in remarks column in bai_qms_db details before destory not confirmation
				$sql="update $bai_pro3.bai_qms_db set remarks=location_id where qms_tid in (".$tid[$i].")";
				//echo $sql;
				mysqli_query($link, $sql) or exit("Sql Error:$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			
				$sql="update $bai_pro3.bai_qms_db set location_id='DESTROYED-".$location[$i]."' where qms_tid in (".$tid[$i].")";
				//echo $sql;
				mysqli_query($link, $sql) or exit("Sql Error:$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql="insert into $bai_pro3.bai_qms_db(qms_style,qms_schedule,qms_color,log_user,log_date,qms_size,qms_qty,qms_tran_type) values('".$style[$i]."','".$schedule[$i]."','".$color[$i]."','".$username."','".date("Y-m-d")."','".$size[$i]."','".$qty[$i]."',7)";
				//echo $sql;
				mysqli_query($link, $sql) or exit("Sql Error$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
				$iLastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
				$sql="update $bai_pro3.bai_qms_db set location_id='".$location[$i]."' where qms_tid=$iLastid";
				mysqli_query($link, $sql) or exit("Sql Error$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
				$check=1;
			}
		}
		if($check==1)
		{
			$sql="insert into $bai_pro3.bai_qms_destroy_log (qms_log_user,mer_month_year,mer_remarks) values ('$username',\"".$mer_no."\",\"".$mer_remarks."\")";
			// echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		echo "<script>sweetAlert('Successfully Updated ','','success')</script>";
	}

	if(isset($_POST['schsbt'])) {
		
		$schlist=$_POST['schlist'];
		$showall=$_POST['showall'];
		$row_count = 0;
		$row_count2 = 0;
		$addfilter="qms_schedule in ('$schlist') and ";
		if($showall=="1")
		{
			$addfilter="";
		}
		if(strlen($schlist)>0 or $showall=="1")
		{
			$x=0;
			$location_id=array();
			$location_title=array();
			$location_id[]="";
			$location_title[]="";
			$sql="select * from $bai_pro3.bai_qms_location_db where active_status=0 and qms_cur_qty<qms_location_cap order by qms_cur_qty desc,order_by desc";
			//echo $sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{	
				$location_id[]=$sql_row['qms_location_id'];
				$location_title[]=$sql_row['qms_location_id']."-".$sql_row['qms_cur_qty'];
			}
			$note_no=1;
			$sql="select max(qms_des_note_no) as qms_des_note_no from $bai_pro3.bai_qms_destroy_log";
			//echo $sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$note_no=$sql_row['qms_des_note_no']+1;
			}
	    ?>
		<form name="update" method="post" action="?r=<?= $_GET['r'] ?>">
			<?php
				$sql="select ( SUM(IF((qms_tran_type= 12 and location_id<>'DESTROYED'),qms_qty,0))
			   -SUM(IF((qms_tran_type= 7 and length(location_id)>0),qms_qty,0))) as qms_qty,qms_style,qms_schedule,qms_color,qms_size,group_concat(qms_tid) as qms_tid, group_concat(concat(location_id,'-',qms_qty,' PCS<br/>')) as existing_location from $bai_pro3.bai_qms_db where $addfilter left(location_id,9)<>'DESTROYED' and location_id<>'PAST_DATA' and qms_tran_type in (12,7) and log_date > \"2014-10-25\"  GROUP BY CONCAT(qms_schedule,qms_color,qms_size),location_id order by qms_schedule,qms_color,qms_size ";
			   //echo $sql;
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				echo"<table id='table2'>";
					echo"<br/><tr>";
					echo"<td>Select Month&nbsp;&nbsp;</td>";
					echo"<td><select id='month' name='month' class='form-control'>";
					echo"<option value='0'>Select</option>";
					echo"<option value='January' <?php if($month=='January') {echo 'selected'; } ?>January</option>";
					echo"<option value='February' <?php if($month=='February') {echo 'selected'; } ?>February</option>";
					echo"<option value='March' <?php if($month=='March') {echo 'selected'; } ?>March</option>";
					echo"<option value='April' <?php if($month=='April') {echo 'selected'; } ?>April</option>";
					echo"<option value='May' <?php if($month=='May') {echo 'selected'; } ?>May</option>";
					echo"<option value='June' <?php if($month=='June') {echo 'selected'; } ?>June</option>";
					echo"<option value='July' <?php if($month=='July') {echo 'selected'; } ?>July</option>";
					echo"<option value='August' <?php if($month=='August') {echo 'selected'; } ?>August</option>";
					echo"<option value='September' <?php if($month=='September') {echo 'selected'; } ?>September</option>";
					echo"<option value='October' <?php if($month=='October') {echo 'selected'; } ?>October</option>";
					echo"<option value='November' <?php if($month=='November') {echo 'selected'; } ?>November</option>";
					echo"<option value='December' <?php if($month=='December') {echo 'selected'; } ?>December</option>";
					echo"</select></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
					echo"<td>Year&nbsp;&nbsp;</td>";
					echo"<td>";
					echo"<select id='year' name='year' class='form-control'>";
					echo"<option value='0'>Select</option>";
					$year=date("Y");
					for($i=$year-1;$i<=$year;$i++)
					{
						echo "<option value='".$i."'>$i</option>";
					}
					echo"</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";	

					echo"<td>Remarks&nbsp;&nbsp;</td>";
					echo"<td><input type='text' class='form-control' name='txt_rem' id='txt_rem' value='' /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
					echo"<td><input type='checkbox' name='enable' id='enable' onclick='enable_button()'>Enable</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type='submit' name='confirm' class='btn btn-info' value='Confirm Destroy' id='add' disabled='true' onclick='enable_button()'></td>";
					echo"</tr>";
					echo"</table><br/>";
					// echo"<br/><h4><span>Reserved Quantity=<div id='output'></div></span></h4>";
					if(mysqli_num_rows($sql_result)>0)
					{
						$row_count2++;
						$table="<div class='table-responsive' style='overflow:scroll;max-height:700px' id='table'><table class='table table-bordered' id='table1'>";
						$table.="<thead>";
						$table.="<tr>";
						$table.='<th>SNo</th>';
						$table.="<th>Style</th>";
						$table.="<th>Schedule</th>";
						$table.="<th>Color</th>";
						$table.="<th>Size</th>";
						$table.="<th>Available Quantity</th>";
						$table.="<th>Existing Locations</th>";
						$table.="<th>Note #</th>";
						$table.="</tr>";
						$table.="</thead><tbody>";
						echo $table;
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							
							if($sql_row['qms_qty']>0)
							{
								$row_count++;
								$table="<tr class=\"foo\" id=\"rowchk$x\">";
								$table.="<td>".($x+1)."</td>";
								$table.="<td>".$sql_row['qms_style']."</td>";
								$table.="<td>".$sql_row['qms_schedule']."</td>";
								$table.="<td>".$sql_row['qms_color']."</td>";
								$table.="<td>".$sql_row['qms_size']."</td>";
								
								$table.="<td style='text-align: center;'>".$sql_row['qms_qty']."<input type=\"hidden\" name=\"qty[$x]\" id=\"qty[$x]\" value=\"".$sql_row['qms_qty']."\" onchange='if(this.value<0 || this.value>".$sql_row['qms_qty'].") { this.value=0; alert(\"Please enter correct value\"); }'></td>";
								
								$table.="<td>".$sql_row['existing_location']."</td>";
								$table.="<td><select name=location[] id=location[$x] onchange=\"location_ref($x);\">";
								$table.="<option value=''></option>";
										$table.="<option value='DEST#$note_no' SELECTED>DEST#".$note_no."</option>";

								$table.="</select><input type='hidden' name='tid[$x]' value='".$sql_row['qms_tid']."'>
									<input type=\"hidden\" name=\"style[$x]\" value=\"".$sql_row['qms_style']."\">
									<input type=\"hidden\" name=\"schedule[$x]\" value=\"".$sql_row['qms_schedule']."\">
									<input type=\"hidden\" name=\"color[$x]\" value=\"".$sql_row['qms_color']."\">
									<input type=\"hidden\" name=\"size[$x]\" value=\"".$sql_row['qms_size']."\">
								</td>";
								
								$table.="</tr>";
							
								echo $table;
								$x++;
							}
						}
						echo '<tr><td colspan=5>Total Reserved Quantity:</td><td id="table1Tot1" style="background-color:#FFFFCC; color:red;text-align:right"></td></tr>';
							$table='</tbody></table></div>';
					}
		echo $table;
		echo "<input type=\"hidden\" name=\"total_rows\" id=\"total_rows\" value=\"".$x."\">";

		echo '</form>';

		if($row_count2 == 0) {
			echo '<script>
			$("#table").css({"display":"none"})</script>';
		}
		if($row_count == 0) {
			echo '<script>
			$("#table2").css({"display":"none"});
			$("#table1").css({"display":"none"});
			sweetAlert("No Data found for the Entered Schedule/s","","warning");</script>';
		}
	}
}

?>
</form>
</div>
</div>
</body>
<script language="javascript" type="text/javascript">
//<![CDATA[
	$('#reset_table1').addClass('btn btn-warning');
	var fnsFilters = {
	rows_counter: true,
	sort_select: true,
	btn_reset: true,
	alternate_rows: true,
	btn_reset_text: "Clear",
	col_operation: { 
					id: ["table1Tot1"],
					col: [5],  
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
	//]]>
</script>
<style type="text/css">
	th {
		text-align: center;
	}
</style>
<script>
function schedulenumber(){
var pattern = /[0-9]/;
var txtValue=document.getElementById('schedule').value;
if(txtValue.match(pattern))
{

}

else
{
	sweetAlert("Please Enter Correct Schedule Number","","warning");
document.getElementById('schedule').value='';
}
}
</script>
<?php 
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);
?>

<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
$view_access=user_acl("SFCS_0011",$username,1,$group_id_sfcs); 
?>
<style>
/* #pch{
	width : 30px;
	height : 30px;
} */
td{ color : #000; }
th{color : #000; }
</style>

<script>
function verify_date(){
	var from_date = $('#sdate').val();
	var to_date =  $('#edate').val();
	var schedule = $('#sch').val();
	if(to_date < from_date){
		sweetAlert('End Date must not be less than Start Date','','warning');
		return false;
	}
	else
	{
		return true;
	}
}
// function verify_schedule(){
// 	var schedule = $('#sch').val();
// 	if(schedule < 0){
// 		sweetAlert('Please enter Valid Schedule','','warning');
// 		$('#sch').val('');
// 	}
// }
</script>

<div class='panel panel-primary'>
	<div class="panel-heading">
		<b>Recut Detail Report</b>
	</div>
	<div class="panel-body">
		<form method="post" name="input" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>">
			<div class="col-sm-2 form-group">
				<label for='sdate'>Start Date  </label>
				<input  type='text' class="form-control" id="sdate" data-toggle="datepicker" name="sdate" size="8" value="<?php if(isset($_REQUEST['sdate'])) { echo $_REQUEST['sdate']; } else { echo date("Y-m-d"); } ?>"> 
			</div>
			<div class="col-sm-2 form-group">
				<label for='edate'>End Date  </label>
				<input  type='text' class="form-control" data-toggle="datepicker" id="edate"  size="8" name="edate"  onchange="return verify_date();" value="<?php if(isset($_REQUEST['edate'])) { echo $_REQUEST['edate']; } else { echo date("Y-m-d"); } ?>">
			</div>	
			<div class="col-sm-2 form-group">
				<label for='schedule'>Schedule </label>
				<input  class="form-control integer" type="text"  onchange='verify_schedule()' name="schedule" id="sch" value="<?php if(isset($_REQUEST['schedule'])) { echo $_REQUEST['schedule']; } ?>">
			</div>
			<div class="col-sm-3">
				<br>
				<input type="checkbox" name="pch" id='pch' value="1" <?php if($_REQUEST['pch']==1) { echo "checked"; } ?>>&nbsp;&nbsp;<b>Show Only PCH items</b>
			</div>
			<div class='col-sm-1'>
				<br>
				<input class="btn btn-success" type="submit" name="filter" value="Filter" onclick="return verify_date();">
			</div>
			
		</form>
		<hr>
<?php

if(isset($_REQUEST['filter']) or isset($_GET['doc_no']))
{
	
	if(isset($_GET['doc_no']) and $_GET['doc_no']>0)
	{
		$doc_no=$_GET['doc_no'];
		$qms_tid=$_GET['qms_tid'];
		$sql="update $bai_pro3.recut_v2 set plan_module=0 where fabric_status<>5 and act_cut_status<>\"DONE\" and doc_no=\"$doc_no\"";
		//echo $sql."<br/>";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		if(mysqli_affected_rows($link)>0)
		{
			$sql="insert ignore into $bai_pro3.bai_qms_db_deleted select * from $bai_pro3.bai_qms_db where qms_tid=$qms_tid";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql="delete from $bai_pro3.bai_qms_db where qms_tid=$qms_tid";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}

	
	$sdate=$_REQUEST['sdate'];
	$edate=$_REQUEST['edate'];
	$pch=$_REQUEST['pch'];
	$schedule=$_REQUEST['schedule'];
	$row_count = 0;

	$module_db=array();
	$section_db=array();
	$author_db=array();
	$sql="select * from $bai_pro3.sections_db where sec_id>0";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$temp=array();
		$temp=explode(",",$sql_row['sec_mods']);
		for($i=0;$i<sizeof($temp);$i++)
		{
			$module_db[]=$temp[$i];
			$section_db[]=$sql_row['sec_id'];
			$author_db[]=strtolower($sql_row['user_id']);
			$author_db1[]=strtolower($sql_row['user_id2']);
		}
	}
	

	
	
	$sql="select * from $bai_pro3.qms_vs_recut where log_date between \"$sdate\" and \"$edate\"";
	
	if($pch==1)
	{
		$sql.=" and act_cut_status=\"\" and plan_module<>0 and fabric_status<>5";
	}
	
	if($schedule>0)
	{
		$sql.=" and qms_schedule='$schedule'";
	}
	$sql .= " and raised > 0";
	$sql.=" order by log_date,module";
	
	if($pch==1){
		//$sql="select * from qms_vs_recut where log_date between \"$sdate\" and \"$edate\" and act_cut_status=\"\" and plan_module<>0 and fabric_status<>5 order by log_date,module";
	}
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result)>0)
	{
		echo "
	<div class='col-sm-12' style='max-height:600px;overflow-y:scroll'>
		<table class='table table-bordered table-responsive'>
			<tr class='danger'>
				<th>Date</th>
				<th>Module</th>
				<th>Section</th>
				<th>Docket ID</th>
				<th>Style</th>
				<th>Schedule</th>
				<th>Color</th>
				<th>Size</th>
				<th>Recut Requested</th>
				<th>Plan to Recut</th>
				<th>Actual Recut</th>
				<th>Special Requested</th>
				<th>Recut App/Rej By</th>
				<th>ReCut Status</th>
				<th>Actual Cut Status</th>
			</tr>";
	while($sql_row=mysqli_fetch_array($sql_result))
	{	
			$row_count++;
			$qms_tid=$sql_row['qms_tid'];
			$recut_doc_no=$sql_row['doc_no'];
			echo "<tr>";
			echo "<td>".$sql_row['log_date']."</td>";
			echo "<td>".$sql_row['module']."</td>";
			echo "<td>".$section_db[array_search($sql_row['module'],$module_db)]."</td>";
			echo "<td>".$sql_row['doc_no']."</td>";
			echo "<td>".$sql_row['qms_style']."</td>";
			echo "<td>".$sql_row['qms_schedule']."</td>";
			echo "<td class=\"lef\">".$sql_row['qms_color']."</td>";
			echo "<td>".ims_sizes('',$sql_row['qms_schedule'],$sql_row['qms_style'],$sql_row['qms_color'],$sql_row['qms_size'],$link)."</td>";
			echo "<td>".$sql_row['raised']."</td>";
			
			$sql="select status,username from $bai_pro3.recut_track where doc_no=$recut_doc_no and level=2";
			$result=mysqli_query($link, $sql) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
			$count=mysqli_num_rows($result);
			while($row=mysqli_fetch_array($result))
			{
				$status=$row["status"];
				$recut_username=$row["username"];
			}

			if($sql_row['act_cut_status']=="" and $sql_row['plan_module']!=0)
			{
				echo "<td>".$sql_row['actual']."</td>";
				echo "<td>0</td>";
			}
			else
			{
				echo "<td>".$sql_row['actual']."</td>";
				echo "<td>".$sql_row['actual']."</td>";
			}
			
			echo "<td>".$sql_row['ref1']."</td>";
			
			if($count==0)
			{
				echo "<td>N/A</td>";
				echo "<td>N/A</td>";
			}
			else
			{
				if($status==1)
				{
					echo "<td>$recut_username</td>";
					echo "<td>Approved</td>";	
				}
				if($status==2)
				{
					echo "<td>$recut_username</td>";
					echo "<td>Not Approved</td>";
				}
			}
			 
			
			if($sql_row['act_cut_status']=="" and $sql_row['plan_module']!=0)
			{
				if($sql_row['fabric_status']==5)
				{
					echo "<td>Fabric Issued.</td>";
				}
				else
				{
					if($author_db[array_search($sql_row['module'],$module_db)]==$username or $author_db1[array_search($sql_row['module'],$module_db)]==$username or $username=="kirang" or $username=="kirang")
					{
						echo "<td><a onmouseover=\"window.status='BAINet'; return true\" href=\"recut_details_v2.php?doc_no=".$sql_row['doc_no']."&qms_tid=$qms_tid&pch=$pch&schedule=$schedule&sdate=$sdate&edate=$edate\" onmouseover=\"window.status='BAINet'; return true\" onmouseout=\"window.status='';return true\">Cancel</a></td>";
					}
					else
					{
						echo "<td>PCH</td>";
					}	
				}
			}
			else
			{
				if($sql_row['plan_module']==0)
				{
					echo "<td>Canceled</td>";
				}
				else
				{
					echo "<td>".$sql_row['act_cut_status']."</td>";
				}
				
			}
			
			echo "</tr>";
	} 
	echo "</table>
	</div>";
}
else
{
echo "<h4 style='color:red'>No Data Found</h4>";

}
}
?>

</div><!-- panel body -->
</div><!--  panel -->
</div>
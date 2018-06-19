<?php
//This interface is used to transfer material from one schedule to another.
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
   

	$view_access=user_acl("SFCS_0138",$username,1,$group_id_sfcs); 
	$issue_rights=user_acl("SFCS_0138",$username,37,$group_id_sfcs); 
	$delete_rights=user_acl("SFCS_0138",$username,4,$group_id_sfcs); 
?>

<script>
	function dodisable()
	{
	//enableButton();
		document.input.update.style.visibility="hidden"; 

	}

	function check1(x) 
	{
		if(x==" ")
		{
			document.input.update.style.visibility="hidden"; 
		} 
		else 
		{
			
			document.input.update.style.visibility=""; 
		}
	}
</script>
<?php
	$material_transfer= getFullURL($_GET['r'],'material_transfer.php','N');
?>
<script>

function firstbox()
{
	window.location.href =$material_transfer+"&style="+document.test.style.value;
}

function secondbox()
{
	window.location.href =$material_transfer+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value;
}

function thirdbox()
{
	window.location.href =$material_transfer+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value;
}
</script>
<style>
	body
	{
		font-family: arial;
	}
	table
	{
		text-align:center;
	}
	td
	{
		border: 1px solid #29759c;
		white-space:nowrap;
		color:black;
		text-weight:bold;
	}
	th
	{
		background-color:#003366;
		color:white;
		text-weight:bold;
	}
</style>

<body onload="dodisable()">
<?php

if(isset($_POST['issue']) or isset($_POST['cancel']))
{
	$traf_tran_id=$_POST['traf_tran_id'];
	$check=$_POST['check'];
	
	if(isset($_POST['issue'])){
	
		for($i=0;$i<sizeof($traf_tran_id);$i++){
			if($check[$i]==1){
				$sql="insert into $bai_pro3.ims_log(ims_date,ims_mod_no,ims_shift,ims_size,ims_qty,ims_style,ims_schedule,ims_color,rand_track) select '".date("Y-m-d")."',module,team,concat('a_',size),req_qty,style,desti_sch,color,module from bai_qms_transfers_log where traf_tran_id=".$traf_tran_id[$i];
				//echo $sql;
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				//
				$sql="update $bai_pro3.bai_qms_transfers_log set status=4, issue_by='$username',issue_time='".date("Y-m-d H:i:s")."',issued_qty=req_qty where traf_tran_id=".$traf_tran_id[$i];
				//echo $sql;
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	}
	
	if(isset($_POST['cancel'])){
		for($i=0;$i<sizeof($traf_tran_id);$i++){
			if($check[$i]==1){
				$sql="delete from $bai_pro3.bai_qms_db where remarks='TRN$".$traf_tran_id[$i]."'";
				//echo $sql;
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql="update $bai_pro3.bai_qms_transfers_log set status=3, cancel_by='$username',cancel_time='".date("Y-m-d H:i:s")."' where traf_tran_id=".$traf_tran_id[$i];
				//echo $sql;
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	}
}
//echo $style.$schedule.$color;
?>
<div class="panel panel-primary">
<div class="panel-heading">Module Input (Additional Panel) Update Form</div>
<div class="panel-body">
	<form name="request" method="post" action="?r=<?= $_GET['r']; ?>">
	<?php
		echo "<div style='max-height:800px;overflow-y:scroll;'><table class='table table-bordered table-striped'>";
		echo "<tr>";
		echo "<th>Check</th>";
		echo "<th>Style</th>";
		echo "<th>Schedule</th>";
		echo "<th>Color</th>";
		echo "<th>Size</th>";
		echo "<th>Module</th>";
		echo "<th>Team</th>";
		echo "<th>Requested on</th>";
		echo "<th>Requested by</th>";
		echo "<th>Requested Qty</th>";
		echo "</tr>";
		$sql="select * from $bai_pro3.bai_qms_transfers_log where status in (1,2)";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			echo "<tr>";
				echo "<td><input type='checkbox' name='check[]' value='1'></td>";
				echo "<td>".$sql_row['style']."</td>";
				echo "<td>".$sql_row['source_sch']."</td>";
				echo "<td style='text-align:left;'>".$sql_row['color']."</td>";
				echo "<td>".$sql_row['size']."</td>";
				echo "<td>".$sql_row['module']."</td>";
				echo "<td>".$sql_row['team']."</td>";
				echo "<td>".$sql_row['req_time']."</td>";
				echo "<td>".$sql_row['req_by']."</td>";
				echo "<td>".$sql_row['req_qty'];
				echo "<input type='hidden' name='traf_tran_id[]' value='".$sql_row['traf_tran_id']."'></td>";
			echo "</tr>";
		}
		echo '</table></div>';
		echo '<br/><br/>';
		echo '<div class="row"><div class="col-md-4"></div><div class="col-md-2">';
		if(in_array($username,$issue_rights)){
			echo '<input class="btn btn-primary" type="submit" name="issue" value="Issue to Module">&nbsp;&nbsp;</div><div class="col-md-2">';	
		}
			
		if(in_array($username,$delete_rights)){
			echo '<input class="btn btn-danger" type="submit" name="cancel" value="Delete Request"></div></div>';
		}
	
	echo '</form>';
?>
</div>
</div>
</div></div>
</body>

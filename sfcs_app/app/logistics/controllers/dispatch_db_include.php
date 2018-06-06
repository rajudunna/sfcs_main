<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	 
?>
<style>
td,th{ color : #000 }
</style>

<script type="text/javascript" language="javascript">
    window.onload = function () {
        noBack();
    }
    window.history.forward();
    function noBack() {
        window.history.forward();
    }
</script>

 <script language="JavaScript">

	var version = navigator.appVersion;

	function showKeyCode(e) {
		var keycode = (window.event) ? event.keyCode : e.keyCode;

		if ((version.indexOf('MSIE') != -1)) {
			if (keycode == 116) {
				event.keyCode = 0;
				event.returnValue = false;
				return false;
			}
		}
		else {
			if (keycode == 116) {
				return false;
			}
		}
	}

</script>
    
   
<table class='table table-responsive table-bordered'>
	<tr class='info'>
		<th colspan='6'><center><font size=3>Pending to Check Out List</font></center></th>
	</tr>	
	<tr class='danger'>
		<th>Dispatch No</th>
		<th>Date</th>
		<th>Party</th>
		<th>Status</th>
		<th>Exit Time</th>
		<th>Controls</th>
	</tr>


<?php
$sql="select * 
	  from $bai_pro3.disp_db 
	  left join party_db on disp_db.party=party_db.pid 
	  where disp_db.create_date >'2011-12-31' and disp_db.status='2' 
	  order by disp_db.disp_note_no DESC";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$num_sch=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
	$disp_note_no = $sql_row['disp_note_no'];
	$url = $_GET['r']."&disp_id=".$disp_note_no;
	$popup_url = '..'.getFullURL($_GET['r'],"dispatch_note.php",'R');
	echo "<tr>
			<td>
				<a href='index.php?r=$url' 
				   onclick = \"popup = window.open('$popup_url?disp_id=$disp_note_no','popup',
							 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23') 
								if (window.focus){
									popup.focus();
								} 
							  return false;\"
							 
				  class='btn btn-warning' >$disp_note_no</a>
			</td>";
	//<a href=\"dispatch_note.php?disp_id=".$sql_row['disp_note_no']."\" target=\"_blank\">".$sql_row['disp_note_no']."</a></td>";
	echo "<td>".$sql_row['create_date']."</td>";
	echo "<td>".$sql_row['party_name']."</td>";
	$status = $sql_row['status']; 
	switch($status)
	{
		case 1:
		{
			echo "<td>Prepared</td>";
			break;
		}
		case 2:
		{
			echo "<td>Printed</td>";
			break;
		}
		case 3:
		{
			echo "<td>Dispatched</td>";
			break;
		}
	}
	echo "<td>".$sql_row['exit_date']."</td>";

	if($status == 2){
		echo "<td><a class='btn btn-warning btn-xs' href='index.php?r=".$_GET['r']."&note_no=".$sql_row['disp_note_no']."'>Confirm Exit</a></td>";
	}else if($status==3){
		echo "<td></td>";
	}else{
		echo "<td></td>";
	}
	
	echo "</tr>";
}
?>

</table>

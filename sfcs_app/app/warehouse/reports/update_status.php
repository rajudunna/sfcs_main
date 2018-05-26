<?php
// include("security1.php");

$username_list=array();
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=$username_list[1];

$url = getFullURLLevel($_GET['r'],'common/config/config.php',3,'R');
include('../'.$url);

$tid=$_GET['tid'];
$check=$_GET['check'];

if($check==1 and in_array(strtolower($username),$app_users))
{
	$checkx=1;
	$item_list=array("Applied","Approve","Reject");
	$item_id=array("1","2","3");
}
else
{
	
	if($check==2 or $check==4 or $check==5)
	{
		
		switch($check)
		{
			case 2:
			{
				$item_list=array("Approved","Manually Issued");
				$item_id=array("2","4");
				break;
			}
			case 4:
			{
				$item_list=array("Manually Issued","Sourcing Cleared");
				$item_id=array("4","5");
				break;
			}
			case 5:
			{
				$item_list=array("Sourcing Cleared","Closed");
				$item_id=array("5","6");
				break;
			}
			default:
			{
				header("Location:restricted.php");
			}
		}

		$checkx=2;
	}
}



?>
<form name="input" method="post" action="update_status_process.php">

<?php

$sql="select * from $bai_rm_pj2.manual_form where rand_track=$tid and status=$check";
//echo $sql;
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

if(mysqli_num_rows($sql_result)>0)
{
	if($checkx==1)
	{
		echo "<h2>Status Update Form: </h2><input type=\"submit\" name=\"submit1\" value=\"Update\">";
	}
	if($checkx==2)
	{
		echo "<h2>Status Update Form: </h2><input type=\"submit\" name=\"submit2\" value=\"Update\">";
	}
	
	echo '<table id="table1" class="mytable">';
	
	echo "<tr class='tblheading'><th>Date</th>	<th>Style</th>	<th>Schedule</th>	<th>Color</th>	<th>Buyer</th>	<th>M3 Item Code</th>	<th>Reason</th>	<th>Qty</th><th>Status</th><th>Req. From</th><th>Approved By</th></tr>";
	
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$tid=$sql_row['tid'];
		echo "<tr>";
		echo "<td>".$sql_row['log_date']."</td>";
		echo "<td>".$sql_row['style']."</td>";
		echo "<td>".$sql_row['schedule']."</td>";
		echo "<td>".$sql_row['color']."</td>";
		echo "<td>".$sql_row['buyer']."</td>";
		echo "<td>".$sql_row['item']."</td>";
		echo "<td>".$sql_row['reason']."</td>";
		echo "<td>".$sql_row['qty']."</td>";
		echo "<td>";
		echo "<select name=\"status[]\">";
		for($i=0;$i<sizeof($item_list);$i++)
		{
			echo "<option value=\"".$item_id[$i]."\">".$item_list[$i]."</option>";
		}
		echo "</select>";
		echo "</td>";
		echo "<td>".$sql_row['req_from']."</td>";
		echo "<td><input type=\"hidden\" name=\"tid[]\" value=\"$tid\">".$sql_row['app_by']."</td>";
		echo "</tr>";
	}

}
else
{
	echo "<h2>This request was already processed.</h2>";
}


?>
</form>




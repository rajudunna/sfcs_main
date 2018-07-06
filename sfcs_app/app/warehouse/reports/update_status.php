<?php
// include("security1.php");

//$username_list=array();
//$username_list=explode('\\',$_SERVER['REMOTE_USER']);
//$username=$username_list[1];


include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
$has_permission=haspermission($_GET['r']);
$tid=$_GET['tid'];
$check=$_GET['check'];

if($check==1 and in_array($authorized,$has_permission))

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
				$url=getFullURLLevel($_GET['r'],'controllers/restrict.php',1,'N');
	            header("Location: $url");
			}
		}

		$checkx=2;
	}
}



?>
<div class="panel panel-primary">
<div class="panel-heading">Status Update Form
</div>
<div class="panel-body">
<form name="input" method="post" action= "<?=getFullURL($_GET['r'],'update_status_process.php','N') ?>" >

<?php

$sql="select * from $bai_rm_pj2.manual_form where rand_track=$tid and status=$check";
//echo $sql;
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

if(mysqli_num_rows($sql_result)>0)
{
	if($checkx==1)
	{
		echo "<input type=\"submit\" name=\"submit1\" class=\"btn btn-primary\" value=\"Update\">";
	}
	if($checkx==2)
	{
		echo "<input type=\"submit\" name=\"submit2\" class=\"btn btn-primary\" value=\"Update\">";
	}
	echo "<div class='table table-responsive'>";
	echo "<table class='table table-bordered'>";
	echo "<thead>";
	echo "<tr class='success'><th>Date</th>	<th>Style</th>	<th>Schedule</th>	<th>Color</th>	<th>Buyer</th>	<th>M3 Item Code</th>	<th>Reason</th>	<th>Qty</th><th>Status</th><th>Req. From</th><th>Approved By</th></tr></thead>";
	echo "<tbody>";
	
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
	echo "</tbody>";

	echo "</table>";
	echo "</div>";


}
else
{
	echo "<h2>This request was already processed.</h2>";
}


?>
</form>
</div>
</div>





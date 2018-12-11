<?php
	$url = getFullURLLevel($_GET['r'],'common/config/config.php',3,'R');
	include($_SERVER['DOCUMENT_ROOT'].'/'.$url);
	ob_start();
	$has_permission = haspermission($_GET['r']);
?>


 <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R'); ?>" type="text/css" media="all" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R'); ?>"></script>

 <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/filtergrid.css',3,'R'); ?>" type="text/css" media="all" />

<meta http-equiv="cache-control" content="no-cache">
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/tablefilter.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/actb.js',3,'R'); ?>"></script>

<Link rel='alternate' media='print' href=null>
<Script Language=JavaScript>

function setPrintPage(prnThis){

prnDoc = document.getElementsByTagName('link');
prnDoc[0].setAttribute('href', prnThis);
window.print();
}

</Script>

<div class="panel panel-primary">
<div class="panel-heading">Item Allocation Log :
	<?php 
	$date=$_GET['date']; 
	if($date)
		echo date('M-Y',strtotime($date));
	else
		echo date('M-Y');?>
	
</div>
<div class="panel-body">
<div class="table-responsive">

<body onload="dodisable();">
<?php //list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2);?>



<?php
	
	{
$url=getFullURL($_GET['r'],'manual_form_log.php','N');
$urlform=getFullURL($_GET['r'],'test.php','N');
if(isset($_GET['date']))
{
	$date=$_GET['date'];
	echo '<a href='.$url.'&date='.date("Y-m-d",strtotime("-1 month", strtotime($date))).'> Last Month</a>  |  ';
	echo '<a href='.$url.'&date='.date("Y-m-d",strtotime("+1 month", strtotime($date))).'> Next Month</a>  |  ';
	echo '<a href='.$urlform.'>Manual Item Allocation Form</a>';

}
else
{
	$date=date("Y-m-d");
	echo '<a href='.$url.'&date='.date("Y-m-d",strtotime("-1 month")).'> Last Month</a>  |  ';
	echo '<a href='.$urlform.'>Manual Item Allocation Form</a>';
}


echo '<div style=\"overflow:scroll;\">
<table id="table1" class="table table-bordered">';





echo "<tr>
<th>Date</th>	<th>Style</th>	<th>Schedule</th>	<th>Color</th>	<th>Buyer</th>	<th>M3 Item Code</th>	<th>Reason</th>	<th>Requested Qty</th><th>Status</th><th>Point Person</th><th>Req. From</th><th>App./Rej. By</th><th>App./Rej. Date</th><th>Reference</th><th>Category</th><th>Manually Issued Date</th></tr>";


$sql="select * from $bai_rm_pj2.manual_form where month(log_date)=month(\"$date\") and year(log_date)=year(\"$date\") order by status";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$tid=$sql_row['rand_track'];
	echo "<tr>";
	echo "<td>".$sql_row['log_date']."</td>";
	echo "<td>".$sql_row['style']."</td>";
	echo "<td>".$sql_row['schedule']."</td>";
	echo "<td>".$sql_row['color']."</td>";
	echo "<td>".$sql_row['buyer']."</td>";
	echo "<td>".$sql_row['item']."</td>";
	echo "<td>".$sql_row['reason']."</td>";
	echo "<td>".$sql_row['qty']."</td>";
	
	$category=$sql_row['category'];
	$style=$sql_row['style'];
	$team=array();
	$team2=array();
	if($category==1)
	{
		$team=$acc_team;
	}
	else
	{
		$team=$fab_team;
	}
	$tmp_username=strtolower($username)."@brandix.com";
		$team2=array_merge($pink_team,$logo_team,$dms_team);
	
	switch($sql_row['status'])
	{
		case 1:
		{
			echo "<td>Applied</td>";
			break;
		}
		case 2:
		{
		
			if(in_array($view,$has_permission))
			{
				echo "<td><a href=\"update_status.php?tid=$tid&check=2\">Approved</a></td>";
			}
			else
			{
				echo "<td>Approved</td>";
			}
			break;
		}
		case 3:
		{
			echo "<td>00 Rejected</td>";
			break;
		}
		
		case 4:
		{
			if(in_array($view,$has_permission))
			{
				echo "<td><a href=\"update_status.php?tid=$tid&check=4\">Manually Issued</a></td>";
			}
			else
			{
				echo "<td>Manually Issued</td>";
			}
			break;
		}
		case 5:
		{
			if(in_array($view,$has_permission))
			{
				echo "<td><a href=\"update_status.php?tid=$tid&check=5\">Sourcing Cleared </a></td>";
			}
			else
			{
				echo "<td>Sourcing Cleared </td>";
			}
			break;
		}
		case 6:
		{
			echo "<td>Closed </td>";
			break;
		}
	}
	echo "<td>".$sql_row['spoc']."</td>";
	echo "<td>".$sql_row['req_from']."</td>";
	echo "<td>".$sql_row['app_by']."</td>";
	
	if($sql_row['app_date']=="0000-00-00 00:00:00" and $sql_row['status']==1 and in_array($view,$has_permission))
	{
		echo "<td><a href=\"update_status.php?tid=$tid&check=1\">Update</a></td>";
	}
	else
	{
		if($sql_row['app_date']=="0000-00-00 00:00:00")
		{
			echo "<td>-</td>";
		}
		else
		{
			echo "<td>".$sql_row['app_date']."</td>";
		}
	}
	
	echo "<td>".$sql_row['rand_track']."</td>";
	
	if($category==1)
	{
		echo "<td>Accessories</td>";
	}
	else
	{
		echo "<td>Fabric</td>";
	}
	
	if($sql_row['issue_closed']=="0000-00-00 00:00:00")
	{
		echo "<td>-</td>";
	}
	else
	{
		echo "<td>".$sql_row['issue_closed']."</td>";
	}
	

	echo "</tr>";
}
echo "</table>";

}
?>

</div>

<script language="javascript" type="text/javascript">
//<![CDATA[
var MyTableFilter = {  exact_match: false }
	setFilterGrid( "table1", MyTableFilter );
//]]>
</script>


</body>

</div>
</div>
</div>

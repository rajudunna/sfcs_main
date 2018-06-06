<?php
	$url = getFullURLLevel($_GET['r'],'common/config/config.php',3,'R');
	include($_SERVER['DOCUMENT_ROOT'].'/'.$url);
	// require_once('phplogin/auth.php');
	ob_start();
	// require_once "ajax-autocomplete/config.php";
	$url = getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R');
	include($_SERVER['DOCUMENT_ROOT'].'/'.$url);
	$url = getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R');
	include($_SERVER['DOCUMENT_ROOT'].'/'.$url); 
	$view_access=user_acl("SFCS_0158",$username,1,$group_id_sfcs);
?>


 <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R'); ?>" type="text/css" media="all" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R'); ?>"></script>

 <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/filtergrid.css',3,'R'); ?>" type="text/css" media="all" />

<meta http-equiv="cache-control" content="no-cache">
<!---<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{
	margin:15px; padding:15px; border:1px solid #666;
	font-family:Trebuchet MS, sans-serif; font-size:88%;
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	border:1px solid #ccc;
	overflow:scroll;
}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; border:2px outset #f4f4f4; margin:2px; }
th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; }
table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
	background-color: white;
}
</style>--->

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
	
	
	//if($username=="SenthooranS" or $username=="KiranG" or $username=="baiworkstudy" or $username=="kirang")
	{
$url=getFullURL($_GET['r'],'manual_form_log.php','N');
$urlform=getFullURL($_GET['r'],'test.php','N');
if(isset($_GET['date']))
{
	$date=$_GET['date'];

	// echo "<div id='page_heading'><span style='float: left'><h3>Item Allocation Log : ".date("M-Y",strtotime($date))."</h3></span><span style='float: right'><b>?</b>&nbsp;</span></div>";
	echo '<a href='.$url.'&date='.date("Y-m-d",strtotime("-1 month", strtotime($date))).'> Last Month</a>  |  ';
	echo '<a href='.$url.'&date='.date("Y-m-d",strtotime("+1 month", strtotime($date))).'> Next Month</a>  |  ';
	echo '<a href='.$urlform.'>Manual Item Allocation Form</a>';

}
else
{
	$date=date("Y-m-d");
	// echo "<div id='page_heading'><span style='float: left'><h3>Item Allocation Log : ".date("M-Y",strtotime($date))."</h3></span><span style='float: right'><b>?</b>&nbsp;</span></div>";
	echo '<a href='.$url.'&date='.date("Y-m-d",strtotime("-1 month")).'> Last Month</a>  |  ';
	echo '<a href='.$urlform.'>Manual Item Allocation Form</a>';
}

//echo $_GET['date'];

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
	// echo $tmp_username;
	// if(substr($style,0,1)=="P" or substr($style,0,1)=="K")
	// {
	// 	$team2=$pink_team;
	// }
	// if(substr($style,0,1)=="L" or substr($style,0,1)=="O")
	// {
	// 	$team2=$logo_team;
	// }
	// if(substr($style,0,1)=="D" or substr($style,0,1)=="M")
	// {
	// 	$team2=$dms_team;
	// }
		$team2=array_merge($pink_team,$logo_team,$dms_team);
	
	switch($sql_row['status'])
	{
		case 1:
		{
			// echo "<td>10 Applied</td>";
			echo "<td>Applied</td>";
			break;
		}
		case 2:
		{
		
			if(in_array($tmp_username,$team))
			{
				// echo "<td><a href=\"update_status.php?tid=$tid&check=2\">20 Approved</a></td>";
				echo "<td><a href=\"update_status.php?tid=$tid&check=2\">Approved</a></td>";
			}
			else
			{
				// echo "<td>20 Approved</td>";
				echo "<td>Approved</td>";
			}
			break;
		}
		case 3:
		{
			echo "<td>00 Rejected</td>";
			// echo "<td>Rejected</td>";
			break;
		}
		
		case 4:
		{
			if(in_array($tmp_username,$team2))
			{
				// echo "<td><a href=\"update_status.php?tid=$tid&check=4\">40 Manually Issued</a></td>";
				echo "<td><a href=\"update_status.php?tid=$tid&check=4\">Manually Issued</a></td>";
			}
			else
			{
				echo "<td>Manually Issued</td>";
				// echo "<td>40 Manually Issued</td>";
			}
			break;
		}
		case 5:
		{
			if(in_array($tmp_username,$team))
			{
				// echo "<td><a href=\"update_status.php?tid=$tid&check=5\">50 Sourcing Cleared </a></td>";
				echo "<td><a href=\"update_status.php?tid=$tid&check=5\">Sourcing Cleared </a></td>";
			}
			else
			{
				echo "<td>Sourcing Cleared </td>";
				// echo "<td>50 Sourcing Cleared </td>";
			}
			break;
		}
		case 6:
		{
			echo "<td>Closed </td>";
			// echo "<td>60 Closed </td>";
			break;
		}
	}
	echo "<td>".$sql_row['spoc']."</td>";
	echo "<td>".$sql_row['req_from']."</td>";
	echo "<td>".$sql_row['app_by']."</td>";
	
	if($sql_row['app_date']=="0000-00-00 00:00:00" and $sql_row['status']==1 and in_array($username,$app_users))
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
	
	/*else
	{
		echo "<h2><font color=red>You are not authorised to use this interface.</font></h2>";
	} */
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

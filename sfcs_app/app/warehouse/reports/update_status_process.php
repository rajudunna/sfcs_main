
<?php
// include("security1.php");
$plant_code = $_SESSION['plantCode'];
$username = $_SESSION['userName'];

$url = getFullURLLevel($_GET['r'],'common/config/config.php',3,'R');
include($_SERVER['DOCUMENT_ROOT'].'/'.$url);

if(isset($_POST['submit2']))
{
	$status=$_POST['status'];
	$tid=$_POST['tid'];
	
	for($i=0;$i<sizeof($status);$i++)
	{
		if($status[$i]==4)
		{
			$sql="update $wms.manual_form set status=".$status[$i].", issue_closed=\"".date("Y-m-d H:i:s")."\",updated_user= '".$username."',updated_at=NOW()  where tid=".$tid[$i]." and plant_code='".$plant_code."'";
			
		}
		else
		{
			$sql="update $wms.manual_form set status=".$status[$i].", remarks=\"$username\", updated_user= '".$username."',updated_at=NOW() where tid=".$tid[$i]." and plant_code='".$plant_code."'";
		}
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	echo "<h2><font color=\"green\">Successfully Updated.</font></h2>";
	$url = getFullURL($_GET['r'],'manual_form_log.php','N');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"$url\"; }</script>";
}


if(isset($_POST['submit1']))
{
	$status=$_POST['status'];
	$tid=$_POST['tid'];
	
	$item_db=array();
	$reason_db=array();
	$qty_db=array();
	$sql="select * from $wms.manual_form where status=1 and plant_code='".$plant_code."' and tid in (".implode(",",$tid).")";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$style=$sql_row['style'];
		$schedule=$sql_row['schedule'];
		$color=$sql_row['color'];
		$category=$sql_row['category'];
		$req_by=$sql_row['req_from'];
		$item_db[]=$sql_row['item'];
		$reason_db[]=$sql_row['reason'];
		$qty_db[]=$sql_row['qty'];
		$rand=$sql_row['rand_track'];
	}
	
	$table="Dear All, <br/><br/> Please find below details of manual request for RM.<br/><br/>";
	$table.="Style:$style<br/>Schedule:$schedule<br/>Color:$color<br/>Requested By:$req_by<br/>Approved By:$username<br/><br/>";
	$table.="<table><tr><th>Item</th><th>Reason</th><th>Qty</th></tr>";
	$count=0;
	
	for($i=0;$i<sizeof($status);$i++)
	{

		if($status[$i]==2 or $status[$i]==3)
		{
			$sql="update $wms.manual_form set status=".$status[$i].", app_date=\"".date("Y-m-d H:i:s")."\", app_by=\"$username\",updated_user= '".$username."',updated_at=NOW()  where tid=".$tid[$i]." and plant_code='".$plant_code."'";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if($status[$i]==2)
			{
				$count=1;
				
				$sql="update $wms.manual_form set comm_status=1,updated_user= '".$username."',updated_at=NOW() where tid=".$tid[$i]." and plant_code='".$plant_code."'";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
				$table.="<tr><td>".$item_db[$i]."</td><td>".$reason_db[$i]."</td><td>".$qty_db[$i]."</td></tr>";
			}
		}
	}
	$table.="</table>";
	$message= '<html><head><style type="text/css">
	body
	{
		font-family: arial;
		font-size:12px;
		color:black;
	}
	table
	{
		border-collapse:collapse;
		white-space:nowrap; 
	}
	th
	{
		color: black;
	 	border: 1px solid #660000; 
		white-space:nowrap; 
		padding-left: 10px;
		padding-right: 10px;
	}
	
	td
	{
		color: BLACK;
	 	border: 1px solid #660000; 
		padding: 1px;
		white-space:nowrap; 
		text-align:center;
	}
	
	.green
	{
		border: 0;
	
	}
	
	.red
	{
		border: 0;
	
	}
	
	.yash
	{
		border: 0;
	
	}
	</style></head><body>';
	$message_f="<br/>Message Sent Via:".$plant_name."  </body></html>";
	$message.=$table.$message_f;
	
	
	
	if($category==1)
	{
		if(substr($style,0,1)=="P" or substr($style,0,1)=="K")
		{
			$recipients=array_merge($pink_team,$acc_team);
		}
		if(substr($style,0,1)=="L" or substr($style,0,1)=="O")
		{
			$recipients=array_merge($logo_team,$acc_team);
		}
		if(substr($style,0,1)=="D" or substr($style,0,1)=="M")
		{
			$recipients=array_merge($dms_team,$acc_team);
		}
	}
	else
	{
		if(substr($style,0,1)=="P" or substr($style,0,1)=="K")
		{
			$recipients=array_merge($pink_team,$fab_team);
		}
		if(substr($style,0,1)=="L" or substr($style,0,1)=="O")
		{
			$recipients=array_merge($logo_team,$fab_team);
		}
		if(substr($style,0,1)=="D" or substr($style,0,1)=="M")
		{
			$recipients=array_merge($dms_team,$fab_team);
		}
	}

	$to  = implode(", ",$recipients);
	$subject = 'BAI RM - Manual Form Ref. '.$rand. ' (Approved)';
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Additional headers
	$headers .= 'To: '.$to. "\r\n";
	$headers .= 'From: Shop Floor System Alert <ictsysalert@brandix.com>'. "\r\n";
	
	if($count==1)
	{
		mail($to, $subject, $message, $headers);
	}
	
	echo "<h2><font color=\"green\">Successfully Updated.</font></h2>";
	$url = getFullURL($_GET['r'],'manual_form_log.php','N');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"$url\"; }</script>";
}
?>

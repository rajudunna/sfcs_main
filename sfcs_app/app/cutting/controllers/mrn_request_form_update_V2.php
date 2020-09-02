<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
$mrn_request_mail= $conf1->get('mrn_request_mail');
$mrn_request_mail= $conf1->get('mrn_request_mail');
$plant_code = $_SESSION['plantCode'];
$username = $_SESSION['userName'];

if(isset($_POST['dataset']))
{   
  
	$arryData = $_POST['dataset'];
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];	
	$cutno=$_POST['cutnum'];
	$section=$_POST['section'];
	$plant_code=$_POST['plantcode'];
	$username=$_POST['username'];
    $batch_ref=$_POST['batch_refer'];
	$rand=rand(1000,10000).date("Hs");
	$table="Dear All, <br/><br/> Please find the below details of additional material request and as per given below remarks.<br/><br/>";
	$table.="Style:$style<br/>Schedule:$schedule<br/>Color:$color<br/>Requested By:$username<br/><br/>";
	$table.="<table><tr><th>Product</th><th>M3 Item Code</th><th>Reason</th><th>Qty</th><th>Remarks</th></tr>";
	$cost=0;
	$reason_id_db = array();
    $reason_code_db = array();
	$sql_reason="select * from $wms.mrn_reason_db where status=0 and plant_code='".$plant_code."' order by reason_order";
	$sql_result=mysqli_query($link, $sql_reason) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$count = mysqli_num_rows($sql_result);
	
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$reason_id_db[]=$sql_row['reason_tid'];
		$reason_code_db[]=$sql_row['reason_code']."-".$sql_row['reason_desc'];
	}
    for($i=0;$i<sizeof($arryData);$i++)
	{ 
		$sql="insert into $wms.mrn_track (style,schedule,color,product,item_code,item_desc,co_ref,unit_cost,uom,req_qty,status,req_user,section,rand_track_id,req_date,reason_code,remarks,batch_ref,plant_code,created_user,updated_user,updated_at) values (\"".$style."\",\"".$schedule."\",\"".$color."^".$cutno."\",\"".$arryData[$i]['products']."\",\"".$arryData[$i]['item']."\",\"".$arryData[$i]['itemdesc']."\",\"".$arryData[$i]['colr']."\",\"".$arryData[$i]['price']."\",\"".$arryData[$i]['uom']."\",\"".$arryData[$i]['qty']."\",1,\"".$username."\",\"".$section."\",\"".$rand."\",\"".date("Y-m-d H:i:s")."\",\"".$arryData[$i]['reason']."\",\"".$arryData[$i]['rem']."\",\"".$batch_ref."\",'".$plant_code."','".$username."','".$username."',NOW())";
		echo $sql."<br>";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$test=1;
		$cost+=($arryData[$i]['qty']*$arryData[$i]['price']);
		echo $reason_code_db[array_search($arryData[$i]['reason'],$reason_id_db)].'-'.'</br>';
		$table.="<tr><td>".$arryData[$i]['products']."</td><td>".$arryData[$i]['item']."</td><td>".$reason_code_db[array_search($arryData[$i]['reason'],$reason_id_db)]."</td><td>".$arryData[$i]['qty']."</td><td>".$arryData[$i]['rem']."</td></tr>";

	}
	$table.="</table>";
	$table.="<br/><br/><h3>Total Cost: <font color=red>$ $cost </font></h3>";
	$message.=$table.$message_f;
	if($test==1)
	{
		
		//mail($to, $subject, $message, $headers); (Enable to send mail to requester and RM Team)
		
		$to  = $mrn_request_mail;
		//$cc=implode(", ",$rm_team);
		//$to_new=implode(", ",array_merge($app_team,$rm_team));
		$subject = 'BEK PRO - Additional Material Request Note Ref. '.$rand. ' (Request)';
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$headers .= 'To: '.$to. "\r\n";
		$headers .= 'Cc: '.$cc. "\r\n";
		$headers .= 'From: Shop Floor System Alert <ictsysalert@brandix.com>'. "\r\n";
		
		mail($to, $subject, $message, $headers);
		
		//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"$pageurl&msg=1&ref=$rand\"; }</script>";
	}
	else
	
	{
		//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"$pageurl&msg=2\"; }</script>";
	}
	
}

?>
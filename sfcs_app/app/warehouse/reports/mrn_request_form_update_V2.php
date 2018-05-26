<?php
include("../".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 
if(isset($_POST['update']))
{
	echo "Update";
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
	$cutno=$_POST['cutno'];
	$qty=$_POST['qty'];
	$product=$_POST['product'];
	$item_code=$_POST['item_code'];
	$item_desc=$_POST['item_desc'];
	$uom=$_POST['uom'];
	$co=$_POST['co'];
	$price=$_POST['price'];
	$reason=$_POST['reason'];
	$remarks=$_POST['remarks'];
	$section=$_POST['section'];

	$batch_ref=$_POST['batch_ref'];
	
	$rand=rand().date("Hs");
	$test=0;
	
	$table="Dear All, <br/><br/> Please find the below details of additional material request and as per given below remarks.<br/><br/>";
	$table.="Style:$style<br/>Schedule:$schedule<br/>Color:$color<br/>Requested By:$username<br/><br/>";
	$table.="<table><tr><th>Product</th><th>M3 Item Code</th><th>Reason</th><th>Qty</th><th>Remarks</th></tr>";
	
	$cost=0;
	for($i=0;$i<sizeof($qty);$i++)
	{
		if($qty[$i]>0)
		{
			//CR# 376 // kirang // 2015-05-05 // Referred the Batch number details to restrict the request of quantity requirement.
			$sql="insert into $bai_rm_pj2.mrn_track (style,schedule,color,product,item_code,item_desc,co_ref,unit_cost,uom,req_qty,status,req_user,section,rand_track_id,req_date,reason_code,remarks,batch_ref) values (\"".$style."\",\"".$schedule."\",\"".$color."^".$cutno."\",\"".$product[$i]."\",\"".$item_code[$i]."\",\"".$item_desc[$i]."\",\"".$co[$i]."\",\"".$price[$i]."\",\"".$uom[$i]."\",\"".$qty[$i]."\",1,\"".$username."\",\"".$section."\",\"".$rand."\",\"".date("Y-m-d H:i:s")."\",\"".$reason[$i]."\",\"".$remarks[$i]."\",\"".$batch_ref."\")";
			// echo $sql."<br>";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$test=1;
			$cost+=($qty[$i]*$price[$i]);
			
			$table.="<tr><td>".$product[$i]."</td><td>".$item_code[$i]."</td><td>".$reason_code_db[array_search($reason[$i],$reason_id_db)]."</td><td>".$qty[$i]."</td><td>".$remarks[$i]."</td></tr>";
		}
	}
	$table.="</table>";
	$table.="<br/><br/><h3>Total Cost: <font color=red>$ $cost </font></h3>";
	$message.=$table.$message_f;
	
	$pageurl = getFullURL($_GET['r'],'mrn_request_form_V2.php','N');
	//MAIL
	if($test==1)
	{
		
		//mail($to, $subject, $message, $headers); (Enable to send mail to requester and RM Team)
		
		$to  = implode(", ",$app_team);
		$cc=implode(", ",$rm_team);
		$to_new=implode(", ",array_merge($app_team,$rm_team));
		$subject = 'BEK PRO - Additional Material Request Note Ref. '.$rand. ' (Request)';
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$headers .= 'To: '.$to. "\r\n";
		$headers .= 'Cc: '.$cc. "\r\n";
		$headers .= 'From: Shop Floor System Alert <ictsysalert@brandix.com>'. "\r\n";
		
		mail($to_new, $subject, $message, $headers);
		
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"$pageurl&msg=1&ref=$rand\"; }</script>";
	}
	else
	
	{
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"$pageurl&msg=2\"; }</script>";
	}
	
}

?>
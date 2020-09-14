<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/functions.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));
//$view_access=user_acl("SFCS_0153",$username,1,$group_id_sfcs); 
$plantcode = $_SESSION['plantCode'];
$username = $_SESSION['userName'];
?>

<link href="table_style.css" rel="stylesheet" type="text/css" />

<?php //include("header_scripts.php"); ?>
<script type="text/javascript">
	function check_all(e)
	{
		//alert(e);
		var style=document.getElementById('style').value;
		var schedule=document.getElementById('schedule').value;
		var color=document.getElementById('color').value;
		var mpo=document.getElementById('mpo').value;
		var sub_po=document.getElementById('sub_po').value;
		if(style=='NIL')
		{
			sweetAlert('Please Select Style','','warning');
			return false;
		}
		if(schedule=='NIL'){
			sweetAlert('Please Select Schedule','','warning');
			return false;
		}
		if(color=='NIL'){
			sweetAlert('Please Select Color','','warning');
			return false;
		}
		if(mpo=='NIL')
		{
			sweetAlert('Please Select MPO','','warning');
			return false;
		}
		if(sub_po=='NIL')
		{
			sweetAlert('Please Select Sub PO','','warning');
			return false;
		}
		
		if(style !=='NIL' && schedule !=='NIL' && color !=='NIL' && mpo !=='NIL' && sub_po !=='NIL'){
			var count = 0;
			for (var i = 0; i<20; i++) {
				var item=document.getElementById('item'+i).value;
				var qty=document.getElementById('qty'+i).value;
				if(item == ''  || qty == ''){
					count +=1;
				}
			}
			if(count == 20){
				swal('please enter atleast one row of data','','warning');
				e.preventDefault();
			}
		}

	}
</script>
<script>

function firstbox()
{
	window.location.href ="index-no-navi.php?r=<?= $_GET['r'] ?>&style="+document.test.style.value
}

function secondbox()
{
	window.location.href ="index-no-navi.php?r=<?= $_GET['r'] ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value
}

function thirdbox()
{
	window.location.href ="index-no-navi.php?r=<?= $_GET['r'] ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
}
function forthbox() 
{ 
	
    window.location.href ="index-no-navi.php?r=<?= $_GET['r'] ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value 
}
function fifthbox() 
{ 
    window.location.href ="index-no-navi.php?r=<?= $_GET['r'] ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value+"&sub_po="+document.test.sub_po.value 
}

</script>
<!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->	

<div class="panel panel-primary">
<div class="panel-heading">Manual Item Allocation Form</div>
<div class="panel-body">
<div class="table-responsive">

<body>


<?php
	$get_style=$_GET['style'];
	$get_schedule=$_GET['schedule']; 
	$get_color=$_GET['color'];
	$get_mpo=$_GET['mpo'];
	$get_sub_po=$_GET['sub_po'];

?>

<form name="test" action="<?php echo getFullURLLevel($_GET['r'],'test.php','0','N'); ?>" method="post">
<?php


//function to get style from mp_color_details
if($plantcode!=''){
	$result_mp_color_details=getMpColorDetail($plantcode);
	$style=$result_mp_color_details['style'];
}
echo "<table class=\"table table-bordered\" align=\"center\"><tr><td width=\"800\">";
if(sizeof($get_sub_po)>0)
{
	echo "<table align=\"center\" class=\"table table-bordered\"><tr><th>Sno</th><th>M3 Item Code</th><th>Reason</th><th>Quantity</th></tr>";
	for($i=0;$i<20;$i++)
	{
		echo "<tr><td>".($i+1)."</td><td><input type=\"text\" size=\"30\" name=\"item[]\" id=\"item$i\" value=\"\" class='notallow'></td>";
		echo "<td><select  name=\"reason[]\" >
		<option value=\"01 Error in item code in BOM\">01 Error in item code in BOM</option>
		<option value=\"02 Invoice not received for GRN\">02 Invoice not received for GRN</option>
		<option value=\"03 Item code not entered to BOM\">03 Item code not entered to BOM</option>
		<option value=\"04 M3 System down\">04 M3 System down</option>
		<option value=\"05 Pending to receive Claim note for rejected goods hence GRN pending for replacement\">05 Pending to receive Claim note for rejected goods hence GRN pending for replacement</option>
		<option value=\"06 Re-classification pending\">06 Re-classification pending</option>
		<option value=\"07 Thread issuing extra for line minimums\">07 Thread issuing extra for line minimums</option>
		</select></td>";
		echo "<td><input type=\"text\" name=\"qty[]\" value=\"\" id='qty$i' class='integer swal'></td></tr>";
		
	}
	echo '</table>';
	
	
	
}
else
{
	echo "Please select correct criteria.";
}
echo "</td><td valign=\"top\">";

echo "Style&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select name=\"style\" id=\"style\"   onchange=\"firstbox();\" >";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{


echo "<option value=\"NIL\" selected>NIL</option>";
foreach ($style as $style_value) {
	if(str_replace(" ","",$style_value)==str_replace(" ","",$get_style)) 
	{ 
		echo '<option value=\''.$style_value.'\' selected>'.$style_value.'</option>'; 
	} 
	else 
	{ 
		echo '<option value=\''.$style_value.'\'>'.$style_value.'</option>'; 
	}
} 

echo "</select><br/><br/>";
?>

<?php

if($get_style!=''&& $plantcode!=''){
	
	$result_bulk_schedules=getBulkSchedules($get_style,$plantcode);
	$bulk_schedule=$result_bulk_schedules['bulk_schedule'];
}  
echo "Schedule <select name=\"schedule\" id=\"schedule\" onchange=\"secondbox();\" >";



echo "<option value=\"NIL\" selected>NIL</option>";
foreach ($bulk_schedule as $bulk_schedule_value) {
	if(str_replace(" ","",$bulk_schedule_value)==str_replace(" ","",$get_schedule)) 
	{ 
		echo '<option value=\''.$bulk_schedule_value.'\' selected>'.$bulk_schedule_value.'</option>'; 
	} 
	else 
	{ 
		echo '<option value=\''.$bulk_schedule_value.'\'>'.$bulk_schedule_value.'</option>'; 
	}
}


echo "</select><br/><br/>";
?>

<?php
if($get_schedule!='' && $plantcode!=''){
	$result_bulk_colors=getBulkColors($get_schedule,$plantcode);
	$bulk_color=$result_bulk_colors['color_bulk'];
}
echo "Color&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name=\"color\" id=\"color\" onchange=\"thirdbox();\" >";




echo "<option value=\"NIL\" selected>NIL</option>";
	
foreach ($bulk_color as $bulk_color_value) {
	if(str_replace(" ","",$bulk_color_value)==str_replace(" ","",$get_color)) 
	{ 
		echo '<option value=\''.$bulk_color_value.'\' selected>'.$bulk_color_value.'</option>'; 
	} 
	else 
	{ 
		echo '<option value=\''.$bulk_color_value.'\'>'.$bulk_color_value.'</option>'; 
	}
} 


echo "</select><br/><br/>";
//function to get master po's from mp_mo_qty based on schedule and color
if($get_schedule!='' && $get_color!='' && $plantcode!=''){
	$result_bulk_MPO=getMpos($get_schedule,$get_color,$plantcode);
	$master_po_description=$result_bulk_MPO['master_po_description'];
}
echo "Master PO&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name=\"mpo\" id=\"mpo\" onchange=\"forthbox();\" >";

		echo"<option value=\"NIL\" selected>NIL</option>";
			foreach ($master_po_description as $key=>$master_po_description_val) {
				if(str_replace(" ","",$master_po_description_val)==str_replace(" ","",$get_mpo)) 
				{ 
					echo '<option value=\''.$master_po_description_val.'\' selected>'.$key.'</option>'; 
				} 
				else 
				{ 
					echo '<option value=\''.$master_po_description_val.'\'>'.$key.'</option>'; 
				}
			} 
echo "</select></br></br>";

//function to get sub po's from mp_mo_qty based on master PO's
if($get_mpo!='' && $plantcode!=''){
	$result_bulk_subPO=getBulkSubPo($get_mpo,$plantcode);
	$sub_po_description=$result_bulk_subPO['sub_po_description'];
	
}
echo "Sub PO&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name=\"sub_po\" id=\"sub_po\" onchange=\"fifthbox();\" >";
		echo"<option value=\"NIL\" selected>NIL</option>";
			foreach ($sub_po_description as $key=>$sub_po_description_val) {
				if(str_replace(" ","",$sub_po_description_val)==str_replace(" ","",$get_sub_po)) 
				{ 
					echo '<option value=\''.$sub_po_description_val.'\' selected>'.$key.'</option>'; 
				} 
				else 
				{ 
					echo '<option value=\''.$sub_po_description_val.'\'>'.$key.'</option>'; 
				}
			} 
echo "</select></br></br>";
echo "Trims&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<select name=\"category\" id=\"category\" >";
echo "<option value=\"1\">Accessories</option>";
echo "<option value=\"2\">Fabric</option>";
echo "</select><br/><br/>";


echo "<font color=red>Point Person</font><br/><select id=\"spoc\"  name=\"spoc\">";

// switch(substr($style,0,1))
// {
	// case "P":
	// {
		echo "<option value=\"Asanka T\">Asanka T</option><option value=\"Chameen D\">Chameen D</option><option value=\"Dulari W\">Dulari W</option><option value=\"Sampath P\">Sampath P</option>";
	// 	break;
	// }
	// case "K":
	// {
		echo "<option value=\"Asanka T\">Asanka T</option><option value=\"Chameen D\">Chameen D</option><option value=\"Dulari W\">Dulari W</option><option value=\"Sampath P\">Sampath P</option>";
	// 	break;
	// }
	// case "L":
	// {
		echo "<option value=\"Chathura A\">Chathura A</option><option value=\"Demian K\">Demian K</option><option value=\"Dilanthine D\">Dilanthine D</option><option value=\"Mahesha W\">Mahesha W</option><option value=\"Sameera K\">Sameera K</option><option value=\"Yoshika D\">Yoshika D</option>";

	// 	break;
	// }
	// case "O":
	// {
		echo "<option value=\"Chathura A\">Chathura A</option><option value=\"Demian K\">Demian K</option><option value=\"Dilanthine D\">Dilanthine D</option><option value=\"Mahesha W\">Mahesha W</option><option value=\"Sameera K\">Sameera K</option><option value=\"Yoshika D\">Yoshika D</option>";
	// 	break;
	// }
	// case "M":
	// {
		echo "<option value=\"Hasitha M\">Hasitha M</option><option value=\"Malika S\">Malika S</option><option value=\"Ratheesh K\">Ratheesh K</option><option value=\"Roshan Pr\">Roshan Pr</option><option value=\"Ruwanthi A\">Ruwanthi A</option><option value=\"Sajid H\">Sajid H</option><option value=\"SureshKa w\">SureshKa w</option><option value=\"Tharanga De\">Tharanga De</option>";
		// break;

	// }
// }

echo "</select><br/><br/><br/><br/><br/>";



echo "<p align=\"right\"><input type=\"hidden\" name=\"division\" value=\"$customer\"><input type=\"submit\" class=\"btn btn-success\" value=\"Submit\" name=\"submit\" onclick=\"return check_all(event);\"></p>";
echo "</td></tr></table>";

?>


</form>


</body>

</div>
</div>
</div>


<?php
if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	$mpo=$_POST['mpo'];
	$sub_po=$_POST['sub_po'];	
	
	$rand=date("Hi").rand();
	$item=$_POST['item'];
	$reason=$_POST['reason'];
	$qty=$_POST['qty'];
	$category=$_POST['category'];
	$spoc=$_POST['spoc'];

	
	//echo sizeof($item);
	$table="Dear All, <br/><br/> Please find below details of manual request for RM.<br/><br/>";
	$table.="Style:$style<br/>Schedule:$schedule<br/>Color:$color<br/>Requested By:$username<br/><br/>";
	$table.="<table><tr><th>M3 Item Code</th><th>Reason</th><th>Qty</th></tr>";
	$count=0;
	for($i=0;$i<20;$i++)
	{
		if(strlen($item[$i])>0)
		{
			$count=1;
			$sql="insert into $wms.manual_form(style,schedule,color,item,reason,qty,req_from,status,rand_track,category,spoc,plant_code,created_user,updated_user,updated_at) values (\"$style\",\"$schedule\",\"$color\",\"".$item[$i]."\",\"".$reason[$i]."\",\"".$qty[$i]."\",\"$username\",1,$rand,$category,\"$spoc\",'".$plantcode."','".$username."','".$username."',NOW())";
			//echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$table.="<tr><td>".$item[$i]."</td><td>".$reason[$i]."</td><td>".$qty[$i]."</td></tr>";
		}
	}
	
	$table.="</table>";
	$url = getFullURLLevel($_GET['r'],'reports/update_status.php',1,'N');
	$app_message=$message.$table."<br/><br/> <a href=\"$url&tid=$rand&check=1\"><strong>Click here to update the status.</strong></a><br/><br/>".$message_f;
	$message.=$table.$message_f;
	
	
	
	if(substr($style,0,1)=="P" or substr($style,0,1)=="K")
	{
		$recipients=array_merge($pink_team,$rm_team);
	}
	if(substr($style,0,1)=="L" or substr($style,0,1)=="O")
	{
		$recipients=array_merge($logo_team,$rm_team);
	}
	if(substr($style,0,1)=="D" or substr($style,0,1)=="M")
	{
		$recipients=array_merge($dms_team,$rm_team);
	}
	if(strlen($recipients))
	{
	$to  = implode(", ",$recipients);
	}
	$subject = 'BAI RM - Manual Form Ref. '.$rand. ' (Request)';
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Additional headers
	$headers .= 'To: '.$to. "\r\n";
	$headers .= 'From: BAINet - Alert <baiict@brandix.com>'. "\r\n";
	
	if($count==1)
	{
		//mail($to, $subject, $message, $headers); (Enable to send mail to requester and RM Team)
		
		$to  = implode(", ",$app_team);
		$subject = 'BAI RM - Manual Form Ref. '.$rand. ' (Request)';
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$headers .= 'To: '.$to. "\r\n";
		$headers .= 'From: Shop Floor System Alert <ictsysalert@brandix.com>'. "\r\n";
		
		// mail($to, $subject, $app_message, $headers);
	}
	
	
	echo "<script>sweetAlert('Successfully','Updated','success')</script>";
	$url=getFullURLLevel($_GET['r'],'reports/manual_form_log.php',1,'N');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"$url\"; }</script>";
}
?> 
<script type="text/javascript">
	
$('.notallow').keyup(function()
{
	var yourInput = $(this).val();
	re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
	var isSplChar = re.test(yourInput);
	if(isSplChar)
	{
		var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
		$(this).val(no_spl_char);
	}
});
</script>
<?php
$url = getFullURL($_GET['r'],'mrn_request_form_V2.php','N');
header("Location: ".$url);

?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); ?>
<html>
<head>

<script>

function firstbox()
{
	window.location.href ="mrn_request_form.php?style="+document.test.style.value
}

function secondbox()
{
	window.location.href ="mrn_request_form.php?style="+document.test.style.value+"&schedule="+document.test.schedule.value
}

function thirdbox()
{
	window.location.href ="mrn_request_form.php?style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
}
</script>

<style>
body
{
	font-family:calibri;
	font-size:12px;
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align: right;
white-space:nowrap; 
}

table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: BLUE;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}


}

}
</style>


<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R');?>"></script>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R');?>" type="text/css" media="all" />
	
<meta http-equiv="cache-control" content="no-cache">
<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "<?= getFullURLLevel($_GET['r'],'common/css/filtergrid.css',3,'R');?>";

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

</style>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/actb.js',3,'R');?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/tablefilter.js',3,'R');?>"></script>

<Link rel='alternate' media='print' href=null>
<Script Language=JavaScript>

function setPrintPage(prnThis){

prnDoc = document.getElementsByTagName('link');
prnDoc[0].setAttribute('href', prnThis);
window.print();
}

</Script>

<style>

input
{
	border:none;
}

#table1 td{
	text-align:left;
}
</style>

<script>

function dodisable()
{
enableButton();
document.getElementById('process_message').style.visibility="hidden";
}


function enableButton() 
{
	if(document.getElementById('option').checked)
	{
		document.getElementById('update').disabled='';
	} 
	else 
	{
		document.getElementById('update').disabled='true';
	}
}

function button_disable()
{
	document.getElementById('process_message').style.visibility="visible";
	document.getElementById('option').style.visibility="hidden";
	document.getElementById('update').style.visibility="hidden";
}
</script>
</head>

<body onload="dodisable();">


<form name="test" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/menu_include.php',1,'R'));

$style=$_GET['style'];
	$schedule=$_GET['schedule']; 
	$color=$_GET['color'];

?>

<?php

if(!isset($_POST['submit']))
{
	

echo "Select Style: <select name=\"style\" onchange=\"firstbox();\" >";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_style_no from $bai_pro3.bai_orders_db where left(order_style_no,1) in (".$global_style_codes.")";	
//}
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
{
	echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
}

}

echo "</select>";
?>

<?php

echo "Select Schedule: <select name=\"schedule\" onchange=\"secondbox();\" >";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style\"";	
//}
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule))
{
	echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
}

}


echo "</select>";
?>

<?php

echo "Select Color: <select name=\"color\" onchange=\"thirdbox();\" >";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log) and order_style_no=\"$style\" and order_del_no=\"$schedule\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_col_des from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
//}
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
	
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color))
{
	echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
}

}
echo "</select>";

echo "<span id=\"msg\" style=\"display:none;\">&nbsp;&nbsp;Please Wait...</span>  <input type=\"submit\" value=\"Filter\" name=\"submit\" id=\"add\" onclick=\"document.getElementById('add').style.display='none'; document.getElementById('msg').style.display='';\">";
}
if(isset($_GET['msg']))
{
	if($_GET['msg']==1)
	{
		echo "<h3>Message: <font color=\"green\">Your request is successfully processed and Ref.#- ".$_GET['ref']."</font></h3>";
	}
	else
	{
		echo "<h3>Message: <font color=\"red\">No request submitted properly.</font></h3>";
	}
	
}
?>


</form>

<?php
if(isset($_POST['submit']))
{
$inp_1=$_POST['style'];
$inp_2=$_POST['schedule'];
$inp_3=str_replace("^","&",$_POST['color']);

$sql="select distinct rand_track_id from $bai_rm_pj2.mrn_track where style=\"$inp_1\" and schedule=\"$inp_2\" and color=\"$inp_3\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

echo "Style: <b>$inp_1</b> | Schedule: <b>$inp_2</b> | Total requests from this schedule: <b>".mysqli_num_rows($sql_result)."</b><br/>";

echo "<h3><center>Additional Material Request Form</center></h3>";
$connect = odbc_connect("bcimovsms01_bai", "brandix_india_user1", "styleRM123");
$query = "STYLE_WISE_RM_INDIA_REQUIREMENT '$inp_1', '$inp_2', '$inp_3'";
//echo $query;
$result = odbc_exec($connect, $query);
echo "<form name=\"test\" method=\"post\" action=\"mrn_request_form.php\">";
echo '<div style=\"overflow:scroll;\">
<table id="table1" class="mytable">';
echo "<tr>
<th>Product Group</th>
<th>Item</th>
<th>Item Description</th>
<th>Color</th>
<th bgcolor=\"red\">Price</th>
<th>BOM Qty</th>
<th>Issued Qty</th>
<th>Required Qty</th>
<th>UOM</th>
<th>Reason</th>
<th>Remarks</th>
</tr>";
$check=0;
while(odbc_fetch_row($result))
{ 

	$style = odbc_result($result, 3); 
	$gmt_colour = odbc_result($result, 4); 
	$proc_grp = odbc_result($result, 5); 
	$material_item = odbc_result($result, 6); 
	$item_description = odbc_result($result, 7);
	$co=odbc_result($result, 13);
	$schedule=odbc_result($result, 15);
	$uom=odbc_result($result, 20);
	$req_qty=odbc_result($result, 22);
	$iss_qty=odbc_result($result, 23);
	$price=odbc_result($result, 19);
	$color=odbc_result($result,8).odbc_result($result,9);
	
	$bgcolor="";
	if(trim($proc_grp)=="FAB")
	{
		$bgcolor="#66BBFF";
	}
	
//if($schedule==$inp_2 and trim($proc_grp)!="FAB")
if($schedule==$inp_2)
{
	$check=1;
	echo "<tr bgcolor='$bgcolor'>";
	
	echo "<td>$proc_grp</td>";
	echo "<td>$material_item</td>";
	echo "<td>$item_description</td>";
	echo "<td>$color</td>";
	echo "<td>$price</td>";
	echo "<td>".round($req_qty,2)."</td>";
	echo "<td>".round($iss_qty,2)."</td>";
	echo "<td><input type=\"text\" size=\"5\" value=\"0\" onchange=\"if(this.value<0) { this.value=0; alert('Please enter correct value.'); }\"  onfocus=\"this.focus();
   this.select();\" name=\"qty[]\">
	<input type=\"hidden\" name=\"product[]\" value=\"$proc_grp\">
	<input type=\"hidden\" name=\"item_code[]\" value=\"$material_item\">
	<input type=\"hidden\" name=\"item_desc[]\" value=\"$item_description\">
	<input type=\"hidden\" name=\"uom[]\" value=\"$uom\">
	<input type=\"hidden\" name=\"co[]\" value=\"$co\">
	<input type=\"hidden\" name=\"price[]\" value=\"$price\">
	</td>";
	echo "<td>$uom</td>";
	echo "<td><select name=\"reason[]\">";
	for($i=0;$i<sizeof($reason_code_db);$i++)
	{
		echo "<option value=\"".$reason_id_db[$i]."\">".$reason_code_db[$i]."</option>";
	}
	echo "</select></td>";
	echo "<td><input type=\"text\" value=\"\" name=\"remarks[]\"></td>";
	echo "</tr>";
}
}
echo "</table>";
echo "<input type=\"hidden\" name=\"style\" value=\"$inp_1\"><input type=\"hidden\" name=\"schedule\" value=\"$inp_2\"><input type=\"hidden\" name=\"color\" value=\"$inp_3\">";
echo "<br/>";
if($check==1)
{
echo "Section: <select name=\"section\">";

echo "<option value=\"0\"></option>";
echo "<option value=\"1\">Section -1 </option>";
echo "<option value=\"2\">Section -2 </option>";
echo "<option value=\"3\">Section -3 </option>";
echo "<option value=\"4\">Section -4 </option>";
echo "<option value=\"5\">Section -5 </option>";
echo "<option value=\"6\">Section -6 </option>";
echo "</select>";

echo '<input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();">Enable';
echo "<input type=\"submit\" name=\"update\" value=\"Submit Request\" onclick=\"javascript:button_disable();\">";
echo "</form>";	
echo '<div id="process_message"><h2><font color="red">Please wait while updating data!!!</font></h2></div>';
}

odbc_close($connect); 
}
?> 


<script language="javascript" type="text/javascript">
//<![CDATA[
var MyTableFilter = {  exact_match: false,
 col_0: "select"}
	setFilterGrid( "table1", MyTableFilter );
//]]>
</script>


</body>

</html>

<?php

if(isset($_POST['update']))
{
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
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
	
	$rand=rand().date("Hs");
	$test=0;
	
	$table="Dear All, <br/><br/> Please find below details of additional material request for PRODUCTION.<br/><br/>";
	$table.="Style:$style<br/>Schedule:$schedule<br/>Color:$color<br/>Requested By:$username<br/><br/>";
	$table.="<table><tr><th>Product</th><th>M3 Item Code</th><th>Reason</th><th>Qty</th><th>Remarks</th></tr>";
	
	$cost=0;
	for($i=0;$i<sizeof($qty);$i++)
	{
		if($qty[$i]>0)
		{
			$sql="insert into $bai_rm_pj2.mrn_track (style,schedule,color,product,item_code,item_desc,co_ref,unit_cost,uom,req_qty,status,req_user,section,rand_track_id,req_date,reason_code,remarks) values (\"".$style."\",\"".$schedule."\",\"".$color."\",\"".$product[$i]."\",\"".$item_code[$i]."\",\"".$item_desc[$i]."\",\"".$co[$i]."\",\"".$price[$i]."\",\"".$uom[$i]."\",\"".$qty[$i]."\",1,\"".$username."\",\"".$section."\",\"".$rand."\",\"".date("Y-m-d H:i:s")."\",\"".$reason[$i]."\",\"".$remarks[$i]."\")";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$test=1;
			$cost+=($qty[$i]*$price[$i]);
			
			$table.="<tr><td>".$product[$i]."</td><td>".$item_code[$i]."</td><td>".$reason_code_db[array_search($reason[$i],$reason_id_db)]."</td><td>".$qty[$i]."</td><td>".$remarks[$i]."</td></tr>";
		}
	}
	$table.="</table>";
	$table.="<br/><br/><h3>Total Cost: <font color=red>$ $cost </font></h3>";
	$message.=$table.$message_f;
	
	
	//MAIL
	if($test==1)
	{
		
		//mail($to, $subject, $message, $headers); (Enable to send mail to requester and RM Team)
		
		$to  = implode(", ",$app_team);
		$cc=implode(", ",$rm_team);
		$to_new=implode(", ",array_merge($app_team,$rm_team));
		$subject = 'BAI PRO - Additional Material Request Note Ref. '.$rand. ' (Request)';
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$headers .= 'To: '.$to. "\r\n";
		$headers .= 'Cc: '.$cc. "\r\n";
		$headers .= 'From: Shop Floor System Alert <ictsysalert@brandix.com>'. "\r\n";
		
		mail($to_new, $subject, $message, $headers);
		
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"mrn_request_form.php?msg=1&ref=$rand\"; }</script>";
	}
	else
	{
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"mrn_request_form.php?msg=2\"; }</script>";
	}
	
}

?>


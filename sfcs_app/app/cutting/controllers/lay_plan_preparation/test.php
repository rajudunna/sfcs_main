<!--
Service request #882040 / kirang/ 2015-01-23  :  Add New buyer T57 for Cut Plan generation
Service Request #861761 / kirang/ 2015-03-17  :  Add New buyer CK for Cut Plan generation
 
-->
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
?>
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
$view_access=user_acl("SFCS_0215",$username,1,$group_id_sfcs);
?>


<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/menu_content.php',4,'R')); ?>

<script>

//<form name="test" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">

function firstbox()
{
	window.location.href ="<?= 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value
}

function secondbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value;
	window.location.href = uriVal;
}

function thirdbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+encodeURIComponent(document.test.color.value);
	window.location.href = uriVal;
}
$(document).ready(function() {
	$('#schedule').on('click',function(e){
		var style = $('#style').val();
		if(style == null){
			sweetAlert('Please Select Style','','warning');
		}
	});
	$('#color').on('click',function(e){
		var style = $('#style').val();
		var schedule = $('#schedule').val();
		if(style == null && schedule == null){
			sweetAlert('Please Select Style and Schedule','','warning');
		}
		else if(schedule == null){
			sweetAlert('Please Select Schedule','','warning');
			document.getElementById("submit").disabled = true;
		}
		else {
			document.getElementById("submit").disabled = false;
		}
	});
});

</script>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<?php
	//include("menu_content.php");
	$style=$_GET['style'];
	$schedule=$_GET['schedule']; 
	$color=$_GET['color'];
?>

<div class = "panel panel-primary">
<div class = "panel-heading">Lay Plan Preparation</div>
<div class = "panel-body">
<form name="test" action="<?php echo getFullURLLevel($_GET['r'],'main_interface.php','0','N'); ?>" method="post">
<?php
include('dbconf.php');
//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	//$sql="select distinct order_style_no from bai_orders_db where left(order_style_no,1) in (".$global_style_codes.")";	
	$sql="select distinct order_style_no from bai_orders_db";	
//}
//echo $sql;exit;

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
echo "<div class=\"row\"><div class=\"col-sm-3\"><label>Select Style:</label><select class='form-control' name=\"style\"  id=\"style\" onchange=\"firstbox();\" id='style'>";

echo "<option value='' disabled selected>Please Select</option>";
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
echo "  </select>
	</div>";
?>

<?php
// $sql_update='UPDATE bai_orders_db SET order_tid=REPLACE(order_tid,"é","e"),order_col_des=REPLACE(order_col_des,"é","e")';
// mysqli_query($link, $sql_update) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

// $sql_update1='UPDATE bai_orders_db_confirm SET order_tid=REPLACE(order_tid,"é","e"),order_col_des=REPLACE(order_col_des,"é","e")';
// mysqli_query($link, $sql_update1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

// $sql_update2='UPDATE cat_stat_log SET order_tid=REPLACE(order_tid,"é","e"),order_tid2=REPLACE(order_tid2,"é","e"),col_des=REPLACE(col_des,"é","e")';
// //echo $sql_update2;

// mysqli_query($link, $sql_update2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

echo "<div class='col-sm-3'><label>Select Schedule:</label> 
	  <select class='form-control' name=\"schedule\" id=\"schedule\" onchange=\"secondbox();\" id='schedule'>";
//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style\"";	
//}

mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value='' disabled selected>Please Select</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{
	if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule)){
			echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
		}
	else{
		echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
	}
}

echo "	</select>
	 </div>";
?>

<?php

echo "<div class='col-sm-3'><label>Select Color:</label><select class='form-control' name=\"color\" onchange=\"thirdbox();\" id='color'>";
//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log) and order_style_no=\"$style\" and order_del_no=\"$schedule\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_col_des from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_joins<'4'";
//}
// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value='' disabled selected>Please Select</option>";
	
while($sql_row=mysqli_fetch_array($sql_result))
{
	if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color)){
		echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
	}else{
		echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
	}
}

echo "</select>
	</div>";

$sql="select order_tid from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des='$color'";
// echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$order_tid=$sql_row['order_tid'];
}



$sql="select mo_status from $bai_pro3.cat_stat_log where order_tid='$order_tid'";
// echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$mo_status=$sql_row['mo_status'];
}



if($mo_status=="Y")
{
	echo "<div class='col-sm-3'> 
			<br/>
			<b>MO Status  :</b>&nbsp;<span class='label label-success'>&nbsp;".$mo_status."es&nbsp;</span>&nbsp;&nbsp;";
	echo "<input class='btn btn-success' type=\"submit\" value=\"Submit\" name=\"submit\" id='submit'>
		  </div>";	
}
else
{
	echo "<div class='col-sm-3'>
			<br/>
			<b>MO Status : </b> <span class='label label-danger'>&nbsp;No&nbsp;</span>
		 ";
	echo "</div>";
		  // <input class='btn btn-danger' type=\"submit\" value=\"Submit\" name=\"submit\">
}
echo "</div>"
?>

</form>

<hr/>
	<div class="row">
		<div class="col-md-4">
			<form method="post" name="input" action="<?php echo getFullURL($_GET['r'], "test.php", "N"); ?>">
			<div class="row">
				<div class="col-md-8">
				<label>Enter Docket Reference:</label>
				<input class="form-control" type="text" name="docket_id" size=15>
				</div>
				<input class="btn btn-primary" type="submit" value="Search" name="submit2" style="margin-top:22px;">
			</div>
			</form>
		</div>
		<div class="col-sm-4">
			<form method="post" name="input" action="<?php echo getFullURL($_GET['r'], "test.php", "N"); ?>">
			<div class="row">
				<div class="col-md-8">
				<label>Enter CID :</label>
				<input class="form-control" type="text" name="cid_id" size=15>
				</div>
				<input class="btn btn-primary" type="submit" value="Search" name="submit3" style="margin-top:22px;">
			</div>
			</form>
		</div>
		<div class="col-md-4">
		</div>
		
	</div>

<?php
if(isset($_POST['submit']))
{
	$base_path = getBASE($_GET['r'])['base'];
	$s = explode('/',$basepath);
	unset($s[count($s)-1]);
	$s1 = implode('/',$s);

	//include($_SERVER['DOCUMENT_ROOT'].$base_path.'/dbconf.php');
	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	
	$sql="select order_div,title_flag from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$customer=$sql_row['order_div'];
		$customer_div=$sql_row['order_div'];
		$flag = $sql_row['title_flag'];
	}
	$customer = 'hello';
	$customer=substr($customer,0,((strlen($customer)-2)*-1));
	switch ($customer)
	{
		// case "VS":
		// {
			// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			// {
				// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			// }
			// else
			// {
				// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			// }
			// break;
		// }
		
		// case "LB":
		// {
			// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			// {
				// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			// }
			// else
			// {
				// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			// }
			// break;
		// }
		
		// case "DB":
		// {
			// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			// {
				// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			// }
			// else
			// {
				// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			// }
			// break;
		// }
		
		// case "M&":
		// {
			
			// if($flag==1)
			// {
				// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// else
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
			
			// }
			// else
			// {
				// if(strpos($customer_div,"- Men")) //NEW Implementation for M&S as Men Wear having size codes different. 20110428
													// {
				// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// else
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
			// }
				// else
													// {
				// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// else
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
			// }
			// }
				
			// break;
		// }
		
		// case "T5":
		// {
			
			// if($flag==1)
			// {
				// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// else
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
			
			// }
			// else
			// {
			// if(strpos($customer_div,"- Men")) //NEW Implementation for M&S as Men Wear having size codes different. 20110428
			// {
				// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// else
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
			// }
			// else
			// {
				// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// else
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
			// }
			// }
			// break;
		// }
		// case "CK":
		// {
			// if($flag==1)
			// {
				// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// else
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
			
			// }
			// else
			// {
				// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// else
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
			// }
			// break;	
		// }
		
		default:
		{
			if($flag==1)
			{
				if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				{
					print_r($s1);
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect(){  location.href = \"".getFullURLLevel($_GET['r'], "main_interface.php", "1", "N")."&color=$color&style=$style&schedule=$schedule\";}</script>"; 
				}else{
					print_r($s1);
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"".getFullURLLevel($_GET['r'], "main_interface.php", "1", "N")."&color=$color&style=$style&schedule=$schedule\"; }</script>";
    			}
			}
			else
			{
				if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				{
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = ".getFullURL($_GET['r'], 'main_interface.php', 'N')."&color=$color&style=$style&schedule=$schedule\"; }</script>";
				}
				else
				{
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = ".getFullURL($_GET['r'], 'main_interface.php', 'N')."&color=$color&style=$style&schedule=$schedule\"; }</script>";
				}
			}
			break;	
		}
	}
	
	
}


if(isset($_POST['submit2']))
{
	$docket_id=$_POST['docket_id'];
	//echo $docket_id;
	
	if($docket_id>0)
	{    
	$sql="select * from $bai_pro3.plandoc_stat_log where doc_no=$docket_id";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$cat_ref=$sql_row['cat_ref']; 
		$order_tid=$sql_row['order_tid'];
	}
	
	if($cat_ref>0)
	{
		$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";	
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$style=$sql_row['order_style_no'];
			$color=$sql_row['order_col_des'];
			$schedule=$sql_row['order_del_no'];
			$customer=$sql_row['order_div'];
			$customer_div=$sql_row['order_div'];
			$flag = $sql_row['title_flag'];
		}
		
		$customer=substr($customer,0,((strlen($customer)-2)*-1));
		switch ($customer)
		{
			// case "VS":
			// {
				// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// else
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// break;
			// }
			
			// case "LB":
			// {
				// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// else
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// break;
			// }
			
			// case "DB":
			// {
				// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// else
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// break;
			// }
			
			// case "M&":
			// {
				
				// if($flag==1)
				// {
					// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
					// {
						// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
					// }
					// else
					// {
						// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
					// }
				
				// }
				// else
				// {
					// if(strpos($customer_div,"- Men")) //NEW Implementation for M&S as Men Wear having size codes different. 20110428
														// {
					// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
					// {
						// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
					// }
					// else
					// {
						// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
					// }
				// }
					// else
														// {
					// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
					// {
						// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
					// }
					// else
					// {
						// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
					// }
				// }
				// }
					
				// break;
			// }
			
			// case "T5":
			// {
				
				// if($flag==1)
				// {
					// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
					// {
						// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
					// }
					// else
					// {
						// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
					// }
				
				// }
				// else
				// {
				// if(strpos($customer_div,"- Men")) //NEW Implementation for M&S as Men Wear having size codes different. 20110428
				// {
					// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
					// {
						// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
					// }
					// else
					// {
						// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
					// }
				// }
				// else
				// {
					// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
					// {
						// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
					// }
					// else
					// {
						// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
					// }
				// }
				// }
				// break;
			// }
			
			// case "CK":
			// {
				// if($flag==1)
				// {
					// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
					// {
						// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
					// }
					// else
					// {
						// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
					// }
				
				// }
				// else
				// {
					// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
					// {
						// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
					// }
					// else
					// {
						// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
					// }
				// }
				// break;	
			// }
			default:
			{
				if($flag==1)
				{
					
					if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
					{
						echo "<script> 
								setTimeout(\"Redirect()\",0); 
								function Redirect() {  
									location.href = '".getFullURLLevel($_GET['r'], 'main_interface.php', '0', 'N')."&color=$color&style=$style&schedule=$schedule'; 
								}
							</script>";
					}
					else
					{
						echo "<script> 
								setTimeout(\"Redirect()\",0); 
								function Redirect() {  
									location.href = '".getFullURLLevel($_GET['r'], 'main_interface.php', '0', 'N')."&color=$color&style=$style&schedule=$schedule'; 
								}
							</script>";
					}
				
				}
				else
				{
					
					if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
					{
						echo "<script> 
								setTimeout(\"Redirect()\",0); 
								function Redirect() {  
									location.href = '".getFullURL($_GET['r'],'main_interface.php', 'N')."&color=$color&style=$style&schedule=$schedule'; 
								}
							</script>";
					}
					else
					{
						echo "<script> 
								setTimeout(\"Redirect()\",0); 
								function Redirect() {  
									location.href = '".getFullURL($_GET['r'],'main_interface.php', 'N')."&color=$color&style=$style&schedule=$schedule'; 
								}
							</script>";
					}
				}
				break;	
			}
		}
	}else{
		echo "<script>sweetAlert('Requested Docket doesnt exist.Please Contact your planner','','warning')</script>";
		// echo "<div class='col-sm-12'>";
		// echo "<div class='alert alert-danger'><b>Requested Docket doesnot exist. Please contact your planner.</b></div>";
		// echo "</div>";
    }
}else{
		echo "<script>sweetAlert('Please enter valid Docket reference','','warning')</script>";
		// echo "<div class='col-sm-12'>";
		// echo "<div class='alert alert-danger'><b>Please enter valid Docket Reference</b></div>";
		// echo "</div>";
}

}
   
   
if(isset($_POST['submit3']))
{
	$cid_id=$_POST['cid_id'];
	//echo $docket_id;
	
	if($cid_id>0)
	{
	
	$sql="select * from $bai_pro3.plandoc_stat_log where cat_ref=$cid_id";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$order_tid=$sql_row['order_tid'];
	}
	
	$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
	//echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$style=$sql_row['order_style_no'];
		$color=$sql_row['order_col_des'];
		$schedule=$sql_row['order_del_no'];
		$customer=$sql_row['order_div'];
		$customer_div=$sql_row['order_div']; //NEW Implementation for M&S as Men Wear having size codes different. 20110428
		$flag = $sql_row['title_flag'];
	}
		if($schedule>0)
{
		$customer=substr($customer,0,((strlen($customer)-2)*-1));
	//echo "Customer".$customer;
	switch ($customer)
	{
		// case "VS":
		// {
			// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			// {
				// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			// }
			// else
			// {
				// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			// }
			// break;
		// }
		
		// case "DB":
		// {
			// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			// {
				// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			// }
			// else
			// {
				// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			// }
			// break;
		// }
		
		// case "LB":
		// {
			// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			// {
				// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			// }
			// else
			// {
				// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			// }
		// }
		
		// case "M&":
		// {
			
			// if($flag==1)
			// {
				// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// else
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
			
			// }
			// else
			// {
				// if(strpos($customer_div,"- Men")) //NEW Implementation for M&S as Men Wear having size codes different. 20110428
													// {
				// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// else
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
			// }
				// else
													// {
				// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// else
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
			// }
			// }
				
			// break;
		// }
		
		// case "T5":
		// {
			
			// if($flag==1)
			// {
				// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// else
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
			
			// }
			// else
			// {
			// if(strpos($customer_div,"- Men")) //NEW Implementation for M&S as Men Wear having size codes different. 20110428
			// {
				// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// else
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
			// }
			// else
			// {
				// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// else
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
			// }
			// }
			// break;
		// }
		
		// case "CK":
		// {
			// if($flag==1)
			// {
				// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// else
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
			
			// }
			// else
			// {
				// if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
				// else
				// {
					// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				// }
			// }
			// break;	
		// }
		
		default:
		{
			if($flag==1)
			{
				if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				{
					echo "<script> 
							setTimeout(\"Redirect()\",0); 
							function Redirect() {  
								location.href = '".getFullURLLevel($_GET['r'],'main_interface.php','0','N')."&color=$color&style=$style&schedule=$schedule'; 
							}
						</script>";
				}
				else
				{
					echo "<script type=\"text/javascript\"> 
							setTimeout(\"Redirect()\",0); 
							function Redirect() {  
								location.href = '".getFullURLLevel($_GET['r'],'main_interface.php','0','N')."&color=$color&style=$style&schedule=$schedule'; 
							}
						</script>";
				}
			
			}
			else
			{
				if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				{
					echo "<script> 
							setTimeout(\"Redirect()\",0); function Redirect() {  
								location.href = '".getFullURL($_GET['r'],'main_interface.php','N')."&color=$color&style=$style&schedule=$schedule'; 
							}
						</script>";
				}
				else
				{
					echo "<script> 
							setTimeout(\"Redirect()\",0); function Redirect() {  
								location.href = '".getFullURL($_GET['r'],'main_interface.php','N')."&color=$color&style=$style&schedule=$schedule'; 
							}
						</script>";
				}
			}
			break;	
		}
		
	}
}else{
		echo "<script>sweetAlert('CID number doesnt exist','','warning')</script>";
		// echo "<div class='col-sm-12'>";
		// echo "<div class='alert alert-danger'><b>Please enter valid Docket Reference.</b></div>";
		// echo "</div>";
	}
		
}else
    {
		echo "<script>sweetAlert('Please enter valid CID','','warning')</script>";
    	// echo "<div class='col-sm-12'>";
		// echo "<div class='alert alert-danger'><b>Requested Docket doesnot exist. Please contact your planner.</b></div>";
		// echo "</div>";
    }
}
   ?> 
   </div>
   </div>
   </div>
   </div>
  
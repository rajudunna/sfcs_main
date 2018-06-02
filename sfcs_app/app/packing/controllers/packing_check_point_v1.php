
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'session_track.php',0,'R') );    ?>
<?php

include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/m3_bulk_or_proc.php"); 
$view_access=user_acl("SFCS_0116",$username,1,$group_id_sfcs);
$special_users=user_acl("SFCS_0116",$username,22,$group_id_sfcs);
$authorised=user_acl("SFCS_0116",$username,7,$group_id_sfcs);
?>
<?php //include("functions.php"); 
//To validate the output entries

?>

<?php
//CR# 285 : KiranG - 2015-02-06
// New logic change has been deployed to handle extra shipment and multi color logic for M&S
$username="ber_databasesvc";
//New Code
$ims_log_packing_v3="$bai_pro3.ims_log_packing_v3";
$packing_summary_tmp_v3="$bai_pro3.packing_summary_tmp_v3";

$ims_log_packing_v3="$temp_pool_db.ims_log_packing_v3_$username";
$packing_summary_tmp_v3="$temp_pool_db.packing_summary_tmp_v3_$username";

$sql="select count(*) from $ims_log_packing_v3";
$result=mysqli_query($link, $sql) or mysqli_error("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
$row_count1=mysqli_num_rows($result);

$sql="select count(*) from $packing_summary_tmp_v3";
$result=mysqli_query($link, $sql) or mysqli_error("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
$row_count2=mysqli_num_rows($result);

include("sesssion_track.php");

//Exemption Handling
if($session_login_fg_carton_scan==1)
{
	$current_session_user=$username;
}
//Exemption Handling

if($row_count1==0 or $row_count2==0 or $current_session_user!=$username)
{
	//header("Location: packing_check_point_gateway.php");
	//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",100); function Redirect() {  window.close(); }</script>";
}

//New Code
?>

<title>POP-Carton Check In</title>
<!-- <META HTTP-EQUIV="refresh" content="300; URL=../PHPLogin/logout.php"> -->

<?php

//list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2);
/*$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);

$sql="select * from menu_index where list_id=94";
$result=mysql_query($sql,$link) or mysql_error("Error=".mysql_error());
while($row=mysql_fetch_array($result))
{
	$users=$row["auth_members"];
}

$username_access=explode(",",$users);
if(in_array($username,$username_access))
{
	
}
else
{
	header("Location: restricted.php");
}
*/
//if($username=="amulyap" or $username=="kirang" or $username=="lilanku" or $username=="sasidharch" or $username=="kirang" or $username=="baifg" or $username=="sureshn" or $username=="edwinr")
//{
	
//}
//else
//{
	
//	echo "<h2>You are not authorised to use this inteface!!</h2>";
//	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",200); function Redirect() {  location.href = \"../index.php\"; }</script>";
//}

?>

<?php

//$username_list=explode('\\',$_SERVER['REMOTE_USER']);
//$username=strtolower($username_list[1]);
//$special_users=array("kirang");
//$authorised=array("kirang","amulyap","narasimharaop","sureshn","edwinr","eswarammae","nagashivan","prasadms");


if(!in_array($username,$special_users))
{
	echo '<script>
	var ctrlPressed = false;
	$(document).keydown(function(evt) {
	  if (evt.which == 17) { // ctrl
	    ctrlPressed = true;
		alert("This key has been disabled.");
	  }
	}).keyup(function(evt) {
	  if (evt.which == 17) { // ctrl
	    ctrlPressed = false;
	  }
	});
	
	$(document).click(function() {
	  if (ctrlPressed) {
	    // do something
		//alert("Test");
	  } else {
	    // do something else
	  }
	});
	</script>';

}

?>

<script>
function focus_box()
{
	document.input.cartonid.focus();
}

function scan_this(x)
{
	var length=x.length;
	if(length==8)
	{
		document.input.submit();
	}
}

//Function to allow only numbers to textbox
function validate(key)
{
//getting key code of pressed key
var keycode = (key.which) ? key.which : key.keyCode;
var phn = document.getElementById('txtPhn');
//comparing pressed keycodes
if ((keycode < 48 || keycode > 57) && (keycode<46 || keycode>47))
{
return false;
}
else
{
//Condition to check textbox contains ten numbers or not
if (phn.value.length <10)
{
return true;
}
else
{
return false;
}
}
}
</script>

</head>
<body onload="focus_box()" onkeypress="return validate(event)">

<?php 
{
  //if(isset($_GET['trigger'])==1)
	echo '<bgsound src="done.mp3" loop="false">';
}

?>
<div class="panel panel-primary">
<div class="panel-heading">Carton Check Point</div>
<div class="panel-body">
<?php

$sql="select emp_id,emp_call_name from $bai_pro3.tbl_fg_crt_handover_team_list where selected_user=user() order by lastup desc limit 1";
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error19=".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result)>0){
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$emp_id=$sql_row['emp_id'];
			echo "<h2>You have selected <font color=\"blue\">".$sql_row['emp_call_name']."-".$emp_id."</font> as handover person</h2><hr>";
		}
	}
	else{
		$emp_id=0;
		echo "<font color=\"red\"><h2>Please select handover person.</h2></font>";
	}
	
	
		
		

?>
<div class="row">
<div class="col-md-6">
<form name="input" method="post" action=" <?php getFullURL($_GET['r'],'packing_check_point_v1.php','N'); ?>" enctype="multipart/form data">
<div class="row form-group"><div class="col-md-8"><label>Enter Sticker Number: </label><!-- <input type="text" value="" name="cartonid"> -->
<!--  Blocked by KiranG to avoid manual entry.
<textarea name="cartonid" rows="3" cols="15" onkeydown="scan_this(this.value)" onkeypress="return validate(event)"></textarea> -->
<input type="text" name="cartonid" onkeydown="document.input.submit();" class="form-control"></input>
</div></div>
<?php

$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);


if(in_array($username,$authorised)) {

echo '<div class="row form-group"><div class="col-md-8"><label>Enter Sticker Number Manually: (optional)</label><input type="text" name="cartonid_new" class="form-control"></div></div><input type="submit" name="check" value="check" class="btn btn-primary">';
}
?>

</form>
</div>
<div class="col-md-6">
<?php
error_reporting(0);
if(isset($_POST['cartonid']) or isset($_REQUEST['cartonid_new']))
{
	$cartonid=ltrim($_POST['cartonid'],"0");
	if(ltrim($_REQUEST['cartonid_new'],"0")>0)
{
$cartonid=ltrim($_REQUEST['cartonid_new'],"0");
}
$count_query = "select count(*) as count from $bai_pro3.pac_stat_log where tid="."'".$cartonid."'";
$count_result = mysqli_query($link,$count_query);
while($count_row=mysqli_fetch_array($count_result)){
	$count = $count_row['count'];
}

if($count>0){

	$sql="select plandoc_stat_log.doc_no as \"doc_no\",plandoc_stat_log.order_tid as \"order_tid\",plandoc_stat_log.acutno as \"acutno\",pac_stat_log.carton_act_qty as \"carton_act_qty\", pac_stat_log.status as \"status\", pac_stat_log.size_code as \"size_code\",pac_stat_log.doc_no_ref as \"doc_no_ref\" 
	    from $bai_pro3.plandoc_stat_log,$bai_pro3.pac_stat_log where plandoc_stat_log.doc_no=pac_stat_log.doc_no 
	    and tid=$cartonid";
	//echo $sql;
	
	//mysql_query($sql,$link) or exit("Please user Barcode Scanner to update from this interface.".mysql_error());
	$sql_result=mysqli_query($link, $sql) or exit("<div class='alert alert-danger' role='alert'>Please use Barcode Scanner to update from this interface.".mysqli_error($GLOBALS["___mysqli_ston"])."</div>");
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$doc_no=$sql_row['doc_no'];
		$doc_no_ref=$sql_row['doc_no_ref'];//
		$carton_qty=$sql_row['carton_act_qty'];//
		$order_tid=$sql_row['order_tid'];
		$cutno=$sql_row['acutno'];
		$status=$sql_row['status'];//
		$size=$sql_row['size_code'];//
	}
	$cartonid=$doc_no_ref;
	$sql="select order_style_no,order_del_no,order_col_des,color_code,(order_embl_e+order_embl_f) as emb_status,ratio_packing_method from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
	//echo $sql."<br>";
	//mysql_query($sql,$link) or exit("Sql Error1".mysql_error());
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$style=$sql_row['order_style_no'];
		$schedule=$sql_row['order_del_no'];
		$color=$sql_row['order_col_des'];
		$color_code=$sql_row['color_code'];
		$emb_status=$sql_row['emb_status'];
		$ratio_packing_method=$sql_row['ratio_packing_method'];
	}
	$emb_status=0;
	//echo "carton act quantity= ".$carton_qty."<br/>";
	if($doc_no!=$doc_no_ref)
	{
		//Need to generate based on color breakup
		$filter_color_codes=array();
		$filter_cart_qty=array();
		
		// to display total carton quantiy
		if($ratio_packing_method=='multiple')
		{
			$sql123="SELECT sum(carton_act_qty) as \"carton_act_qty\" FROM $bai_pro3.pac_stat_log WHERE doc_no IN (SELECT doc_no FROM bai_pro3.packing_summary WHERE order_del_no=$schedule) AND doc_no_ref LIKE '%$cartonid%' ";
		}
		else		
		{
			$sql123="select sum(carton_act_qty) as \"carton_act_qty\" from $bai_pro3.pac_stat_log where doc_no_ref=\"$doc_no_ref\"";
		}
		//echo "Test--".$sql123."<br/>";
		//mysql_query($sql1,$link) or exit("Sql Error3".mysql_error());
		$sql_result123=mysqli_query($link, $sql123) or exit("Sql Error2. $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo mysql_num_rows($sql_result123)."<br>";
		while($sql_row123=mysqli_fetch_array($sql_result123))
		{
			$carton_qty=$sql_row123['carton_act_qty'];
			//echo "carton 111act quantity1= ".$sql_row123['carton_act_qty']."<br/>";
		}
		//echo "carton 1act quantity1= ".$carton_qty."<br/>";
		if($ratio_packing_method=='multiple')
		{
			$sql="select sum(carton_act_qty) as \"carton_act_qty\", order_col_des from $bai_pro3.packing_summary where doc_no IN (SELECT doc_no FROM bai_pro3.plandoc_stat_log WHERE order_tid LIKE \"% $schedule%\") AND doc_no_ref LIKE \"%$cartonid%\" group by order_col_des";
		}
		else
		{
			$sql="select sum(carton_act_qty) as \"carton_act_qty\", order_col_des from $bai_pro3.packing_summary where doc_no_ref=\"$doc_no_ref\" group by order_col_des";
		}
		//echo $sql."<br/>";
		//mysql_query($sql,$link) or exit("Sql Error2".mysql_error());
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			//$carton_qty=$sql_row['carton_act_qty'];
			$filter_color_codes[]=$sql_row['order_col_des'];
			$filter_cart_qty[]=$sql_row['carton_act_qty'];
		}
	}
	
	//NEW
	$style_code=substr($style,0,1);
	//echo "<br/> style code: ".$style_code."<br/>";
	/* Disabled due to available conditions KiranG - SR# 682004 // 20150514
	if($style_code=="")
	//Disabled - KiranG -2014-08-05 to accept carton based on M&S logic (TO meet the extra ship quantities from other jobs)
	//if($style_code=="K" or $style_code=="P" or $style_code=="L" or $style_code=="O" or $style_code=="G")
	{
		//$sql="select coalesce(ims_pro_qty_cumm,0) as \"completed\" from $ims_log_packing_v3 where ims_style=\"$style\" and ims_schedule=$schedule and ims_color=\"$color\" and ims_size=\"a_$size\"";
$sql="select coalesce(ims_pro_qty_cumm,0) as \"completed\" from $ims_log_packing_v3 where ims_style=\"$style\" and ims_schedule=$schedule and ims_color=\"$color\" and ims_size=\"a_$size\" and ims_doc_no=\"$doc_no\"";
		//echo $sql;
		mysql_query($sql,$link) or exit("Sql Error3".mysql_error());
		$sql_result=mysql_query($sql,$link) or exit("Sql Error3".mysql_error());
		while($sql_row=mysql_fetch_array($sql_result))
		{
			$carton_qty_completed=$sql_row['completed'];
		}
		
		//$sql="select coalesce(sum(ims_pro_qty),0) as \"completed\" from ims_log where ims_style=\"$style\" and ims_schedule=$schedule and ims_color=\"$color\" and ims_size=\"a_$size\"";
$sql="select coalesce(sum(ims_pro_qty),0) as \"completed\" from ims_log where ims_style=\"$style\" and ims_schedule=$schedule and ims_color=\"$color\" and ims_size=\"a_$size\" and ims_doc_no=\"$doc_no\"";
 //echo $sql;
		mysql_query($sql,$link) or exit("Sql Error4".mysql_error());
		$sql_result=mysql_query($sql,$link) or exit("Sql Error4".mysql_error());
		while($sql_row=mysql_fetch_array($sql_result))
		{
			$carton_qty_completed+=$sql_row['completed'];
		}
		
		/* //$sql="select coalesce(sum(ims_pro_qty),0) as \"completed\" from ims_log_backup where ims_style=\"$style\" and ims_schedule=$schedule and ims_color=\"$color\" and ims_size=\"a_$size\"";
echo $sql;
		mysql_query($sql,$link) or exit("Sql Error".mysql_error());
		$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
		while($sql_row=mysql_fetch_array($sql_result))
		{
			$carton_qty_completed+=$sql_row['completed'];
		} */
		/* Disabled due to available conditions KiranG - SR# 682004 // 20150514
		//$sql="select coalesce(sum(carton_act_qty),0) as \"received\" from packing_summary where order_style_no=\"$style\" and order_del_no=$schedule and order_col_des=\"$color\" and status=\"DONE\" and size_code=\"$size\"";
		$sql="select coalesce(sum(carton_act_qty),0) as \"received\" from $packing_summary_tmp_v3 where order_style_no=\"$style\" and order_del_no=$schedule and order_col_des=\"$color\" and status=\"DONE\" and size_code=\"$size\" and doc_no=\"$doc_no\"";
		mysql_query($sql,$link) or exit("Sql Error5".mysql_error());
		$sql_result=mysql_query($sql,$link) or exit("Sql Error5".mysql_error());
		while($sql_row=mysql_fetch_array($sql_result))
		{
			$received_qty=$sql_row['received'];
		}
//echo $sql;

//NEW
	
		echo "<table>";
		echo "<tr><td>Style:</td><td>$style</td></tr>";
		echo "<tr><td>Schedule:</td><td>$schedule</td></tr>";
		echo "<tr><td>Color:</td><td>$color</td></tr>";
		echo "<tr><td>Job:</td><td>".chr($color_code).leading_zeros($cutno,3)."</td></tr>";
		echo "<tr><td>Size:</td><td>".strtoupper($size)."</td></tr>";
		echo "<tr><td>Carton Qty</td><td>$carton_qty</td></tr>";
		if($status=="DONE")
		{
			echo "<tr><td>Status</td><td><font color=green>Received</font></td></tr>";
			echo '<bgsound src="air_horn.wav" loop="false">';
		}
		else
		{
			//echo "Total Output Reported:$carton_qty_completed"."<br/>";
			//echo "Carton Qty Received sofar:$received_qty"."<br/>";
			//echo "Carton Qty :$carton_qty"."<br/>";
			if($carton_qty_completed>=($carton_qty+$received_qty))
			{
				echo '<tr><td>Status</td><td><form name="input" method="post" action="'; echo $_SERVER['php_self']; echo '?>">
				<input type="hidden" value="'.$cartonid.'" name="cartonid">
				<input type="hidden" value="'.$doc_no.'" name="doc_no">
				<input type="hidden" value="'.$doc_no_ref.'" name="doc_no_ref">
				<input type="hidden" value="'.$size.'" name="size">
				<input type="hidden" value="'.$schedule.'" name="schedule">
				
				<input type="submit" name="update" value="update">
				</form></td></tr>';
	
				echo "<script>document.getElementById('update').click();</script>";
			}
			else
			{
				//NEW TO Track No Sufficient Qty
				$sql="update pac_stat_log set disp_id=1 where tid=$cartonid";
				mysql_query($sql,$link) or exit("Sql Error".mysql_error());
				//NEW To Track No Sufficient Qty
				//echo "NEW To Track No Sufficient Qty";
				echo "<tr><td>Status</td><td><font color=red>No Sufficient Qty</font></td></tr>";
				echo '<bgsound src="red_alert.wav" loop="false">';
			}
		}
		echo "</table>";

	}
	else */
	{
		
		$flag=0; //Default OK and flag=1 is not OK
		
		
		//looping for individual color
		
		for($m=0;$m<sizeof($filter_color_codes);$m++)
		{
			$carton_qty_completed=0;
			$received_qty=0;
			//echo "pack=".$ratio_packing_method."<br>";
			if($ratio_packing_method=='multiple')
			{
				//$sql="select coalesce(sum(ims_pro_qty_cumm),0) as \"completed\" from $ims_log_packing_v3 where ims_style=\"$style\" and ims_schedule=$schedule and ims_color=\"".$filter_color_codes[$m]."\" and ims_size=\"a_$size\" ";
				$sql="select coalesce(sum(ims_pro_qty_cumm),0) as \"completed\" from $ims_log_packing_v3 where ims_style=\"$style\" and ims_schedule=$schedule";
				// echo  "<br/>".$sql."<br/>";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$carton_qty_completed=$sql_row['completed'];
				}
				
				//echo "carton_qty_completed_ims_log_v3: ".$carton_qty_completed."<br/>";
				
				//$sql="select coalesce(sum(ims_pro_qty),0) as \"completed\" from ims_log where ims_style=\"$style\" and ims_schedule=$schedule and ims_color=\"".$filter_color_codes[$m]."\" and ims_size=\"a_$size\" ";
				$sql="select coalesce(sum(ims_pro_qty),0) as \"completed\" from $bai_pro3.ims_log where ims_style=\"$style\" and ims_schedule=$schedule";
				//echo  "<br/>".$sql."<br/>";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$carton_qty_completed+=$sql_row['completed'];
				}
				
				//echo "carton_qty_completed_ims_log: ".$carton_qty_completed."<br/>";
				
				//$sql="select coalesce(sum(carton_act_qty),0) as \"received\" from $packing_summary_tmp_v3 where order_style_no=\"$style\" and order_del_no=$schedule and order_col_des=\"".$filter_color_codes[$m]."\" and status=\"DONE\" and size_code=\"$size\"";
				//Disabled due to available conditions KiranG - SR# 682004 // 20150514
				//$sql="select COALESCE(SUM(IF(STATUS='EGI',carton_act_qty,0)),0) as \"emb_received\",COALESCE(SUM(IF(STATUS='DONE',carton_act_qty,0)),0) as \"received\", SUM(carton_act_qty) AS \"pac_qty\" from $packing_summary_tmp_v3 where order_style_no=\"$style\" and order_del_no=$schedule and order_col_des=\"".$filter_color_codes[$m]."\" and size_code=\"$size\"";
				$sql="select COALESCE(SUM(IF(STATUS='EGI',carton_act_qty,0)),0) as \"emb_received\",COALESCE(SUM(IF(STATUS='DONE',carton_act_qty,0)),0) as \"received\", SUM(carton_act_qty) AS \"pac_qty\" from $packing_summary_tmp_v3 where order_style_no=\"$style\" and order_del_no=$schedule";
				//echo  "<br/>".$sql."<br/>";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error81".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$received_qty=$sql_row['received'];
					$pac_qty=$sql_row['pac_qty'];
					$emb_received=$sql_row['emb_received'];
				}
				
				//echo "<br/>data=".$carton_qty_completed>=($filter_cart_qty[$m]+$received_qty);
				//echo "<br/>emb carton_qty_completed:".$carton_qty_completed."<br/>";
				//echo "<br/>pac qty:".$pac_qty."<br/>";
				//echo "<br/>received qty:".$received_qty."<br/>";
				
				//Validation added to avoid scan out more than the output quantity - KiranG 20150527
				$sout=0;
				
				//$sql="select COALESCE(SUM(size_s06+size_s08+size_s10+size_s12+size_s14+size_s16+size_s18+size_s20+size_s22+size_s24+size_s26+size_s28+size_s30),0) as sout from bai_pro.bai_log_buf where delivery=$schedule and color=\"".$filter_color_codes[$m]."\"";
				$sql="select COALESCE(SUM(size_s01+size_s02+size_s03+size_s04+size_s05+size_s06+size_s07+size_s08+size_s09+size_s10+size_s11+size_s12+size_s13+size_s14+size_s15+size_s16+size_s17+size_s18+size_s19+size_s20+size_s22+size_s24+size_s26+size_s28+size_s30+size_s31+size_s32+size_s33+size_s34+size_s35+size_s36+size_s37+size_s38+size_s39+size_s40+size_s41+size_s42+size_s43+size_s44+size_s45+size_s46+size_s47+size_s48+size_s49+size_s50),0) as sout from $bai_pro.bai_log_buf where delivery=$schedule";
				//echo  "<br/>".$sql."<br/>";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error82".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$sout=$sql_row['sout'];
				}

			}
			else
			{		
				$sql="select coalesce(sum(ims_pro_qty_cumm),0) as \"completed\" from $ims_log_packing_v3 where ims_style=\"$style\" and ims_schedule=$schedule and ims_color=\"".$filter_color_codes[$m]."\" and ltrim(ims_size)=\"a_".trim($size)."\"";
				// echo  "<br/>".$sql."<br/>";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$carton_qty_completed=$sql_row['completed'];
				}
				
				//echo "carton_qty_completed_ims_log_v3: ".$carton_qty_completed."<br/>";
				
				$sql="select coalesce(sum(ims_pro_qty),0) as \"completed\" from $bai_pro3.ims_log where ims_style=\"$style\" and ims_schedule=$schedule and ims_color=\"".$filter_color_codes[$m]."\" and ims_size=\"a_$size\"";
				//echo  "<br/>".$sql."<br/>";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$carton_qty_completed+=$sql_row['completed'];
				}
				
				//echo "carton_qty_completed_ims_log: ".$carton_qty_completed."<br/>";
				
				//$sql="select coalesce(sum(carton_act_qty),0) as \"received\" from $packing_summary_tmp_v3 where order_style_no=\"$style\" and order_del_no=$schedule and order_col_des=\"".$filter_color_codes[$m]."\" and status=\"DONE\" and size_code=\"$size\"";
				//Disabled due to available conditions KiranG - SR# 682004 // 20150514
				$sql="select COALESCE(SUM(IF(STATUS='EGI',carton_act_qty,0)),0) as \"emb_received\",COALESCE(SUM(IF(STATUS='DONE',carton_act_qty,0)),0) as \"received\", SUM(carton_act_qty) AS \"pac_qty\" from $packing_summary_tmp_v3 where order_style_no=\"$style\" and order_del_no=$schedule and order_col_des=\"".$filter_color_codes[$m]."\" and size_code=\"$size\"";
				// echo  "<br/>".$sql."<br/>";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error83".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$received_qty=$sql_row['received'];
					$pac_qty=$sql_row['pac_qty'];
					$emb_received=$sql_row['emb_received'];
				}
				
				//echo "<br/>data=".$carton_qty_completed>=($filter_cart_qty[$m]+$received_qty);
				
				
				//Validation added to avoid scan out more than the output quantity - KiranG 20150527
				$sout=0;
				$sql="select COALESCE(SUM(size_$size),0) as sout from $bai_pro.bai_log_buf where delivery=$schedule and color=\"".$filter_color_codes[$m]."\"";
				//echo  "<br/>".$sql."<br/>";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error84".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$sout=$sql_row['sout'];
				}
			}
			
			//echo "<br/> sewing out=".$sout."-- carton_qty_completed:".$carton_qty_completed."-".$emb_status."<br/>";
			
			if($sout<$carton_qty_completed)
			{
				$carton_qty_completed=$sout;
			}
			//Validation added to avoid scan out more than the output quantity - KiranG 20150527
			
			//To Track Embellishment (Garment Form) Schedules // Kirang 20150516
			// if($emb_status>0)
			// {
				// $carton_qty_completed=0;
				// $carton_qty_completed=$received_qty+$emb_received;
			// }
			
			//echo "<br/>emb carton_qty_completed:".$flag."-".$carton_qty_completed."<br/>";
			//echo "<br/>pac qty:".$pac_qty."<br/>";
			//echo "<br/>received qty:".$received_qty."<br/>";
			//echo "<br/> result: ".$carton_qty_completed."--".$filter_cart_qty[$m]."--".$received_qty;
			//
			//echo "<br/>data=".$carton_qty_completed."--".$filter_cart_qty[$m]."--".$received_qty."--".$carton_qty_completed."--".$pac_qty."--".$flag."<br/>";
			//
			//added additional conditions KiranG - SR# 682004 // 20150514
			if($carton_qty_completed>=($filter_cart_qty[$m]+$received_qty) and $carton_qty_completed>0 and $pac_qty>0 and $flag==0)
			{
				$flag=0;
				//echo "<br/>success: Flag value= ".$flag."<br/>";
				//to check embellishment completion status of carton //SR# 744925 - KiranG 20150617
				// if($flag==0 and $emb_status>0)
				// {
					// if($status=="EGI")
					// {
						// $flag=0;
					// }
					// else
					// {
						// $flag=1;
						// break;
					// }
				// }
				//to check embellishment completion status of carton
			}
			else
			{
				$flag=1;
				//echo "<br/>Fail: Flag value= ".$flag."<br/>";
				break;
			}
		}
		
		/* OLD VERSION where its not covering color wise details 
		$sql="select coalesce(sum(ims_pro_qty_cumm),0) as \"completed\" from $ims_log_packing_v3 where ims_style=\"$style\" and ims_schedule=$schedule and ims_size=\"a_$size\"";
		//echo $sql;
		$sql_result=mysql_query($sql,$link) or exit("Sql Error6".mysql_error());
		while($sql_row=mysql_fetch_array($sql_result))
		{
			$carton_qty_completed=$sql_row['completed'];
		}
		
		$sql="select coalesce(sum(ims_pro_qty),0) as \"completed\" from ims_log where ims_style=\"$style\" and ims_schedule=$schedule and ims_size=\"a_$size\"";
		$sql_result=mysql_query($sql,$link) or exit("Sql Error7".mysql_error());
		while($sql_row=mysql_fetch_array($sql_result))
		{
			$carton_qty_completed+=$sql_row['completed'];
		}
		
		/*$sql="select coalesce(sum(ims_pro_qty),0) as \"completed\" from ims_log_backup where ims_style=\"$style\" and ims_schedule=$schedule and ims_size=\"a_$size\"";
		mysql_query($sql,$link) or exit("Sql Error".mysql_error());
		$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
		while($sql_row=mysql_fetch_array($sql_result))
		{
			$carton_qty_completed+=$sql_row['completed'];
		}
		
		$sql="select coalesce(sum(carton_act_qty),0) as \"received\" from $packing_summary_tmp_v3 where order_style_no=\"$style\" and order_del_no=$schedule and status=\"DONE\" and size_code=\"$size\"";
		$sql_result=mysql_query($sql,$link) or exit("Sql Error8".mysql_error());
		while($sql_row=mysql_fetch_array($sql_result))
		{
			$received_qty=$sql_row['received'];
		}
		*/
	
		echo "<div class='col-md-8'><table class='table table-bordered'>";
		echo "<tr><td><b>Style</b></td><td>$style</td></tr>";
		echo "<tr><td><b>Schedule</b></td><td>$schedule</td></tr>";
		echo "<tr><td><b>Color</b></td><td>$color</td></tr>";
		echo "<tr><td><b>Job</b></td><td>".chr($color_code).leading_zeros($cutno,3)."</td></tr>";
		$sql="SELECT title_size_".$size." FROM $bai_pro3.bai_orders_db WHERE order_style_no=\"$style\" AND order_del_no=\"$schedule\" AND order_col_des=\"$color\"";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$title_size = mysqli_fetch_row($sql_result);
		echo "<tr><td><b>Size</b></td><td>".strtoupper($title_size[0])."</td></tr>";
		echo "<tr><td><b>Carton Qty</b></td><td>$carton_qty</td></tr>";
		
		if($status=="DONE")
		{
			echo "<tr><td><b>Status</b></td><td><span class='label label-success'>Received</span></td></tr>";
			echo '<bgsound src="air_horn.wav" loop="false">';
		}
		else
		{
			//Additional validation to check with M3
			$flag2=0;
			$sql="select (order_embl_e+order_embl_f) as emb_status from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\"";
			//mysql_query($sql,$link) or exit("Sql Error1".mysql_error());
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$emb_status=$sql_row['emb_status'];
			}
			$emb_status=0;
			if($emb_status>0)
			{
				$op_code='ASPR';
			}
			else
			{
				$op_code='SOT';
			}
			
			if(trim($doc_no)==trim($doc_no_ref))
			{
				$sql1="SELECT order_col_des,sum(carton_act_qty) as scanned from $bai_pro3.packing_summary where order_del_no='$schedule' and tid=$cartonid group by order_col_des";
				//echo "1 query of flag2:".$sql1."<br/>";
			}
			else
			{
				if($ratio_packing_method=='multiple')
				{
					$sql1="SELECT order_col_des,sum(carton_act_qty) as scanned from $bai_pro3.packing_summary where order_del_no='$schedule' and doc_no IN (SELECT doc_no FROM bai_pro3.plandoc_stat_log WHERE order_tid LIKE '% $schedule%') AND doc_no_ref LIKE '%$doc_no_ref%' group by order_col_des";
				}
				else
				{	
					$sql1="SELECT order_col_des,sum(carton_act_qty) as scanned from $bai_pro3.packing_summary where order_del_no='$schedule' and doc_no_ref=\"$doc_no_ref\" group by order_col_des";
				}
				//echo "2 query of flag2:".$sql1."<br/>";
			}
			
			// $sql_result1=mysql_query($sql1,$link) or exit("Sql Error2".mysql_error());
			// while($sql_row1=mysql_fetch_array($sql_result1))
			// {
				
				// if($ratio_packing_method=='multiple')
				// {
					// echo $op_code."-,".$schedule."-,".$sql_row1['order_col_des']."-,".$sql_row1['scanned']."<br>";
					// if($flag2==0 and m3_cpk_validation_multi_color('CPK',$op_code,$schedule,$sql_row1['order_col_des'],$cartonid,$sql_row1['scanned'])=="FALSE")
					// {
						// $flag2=1;
						// break;
					// }
				// }
				// else
				// {
					// if($flag2==0 and m3_cpk_validation('CPK',$op_code,$schedule,$sql_row1['order_col_des'],$size,$sql_row1['scanned'])=="FALSE")
					// {
						// $flag2=1;
						// break;
					// }
				// }
				
			// }
			//echo "<br/> Flag2 Value1: ".$flag."=".$flag2."<br/>";
			// if(mysql_num_rows($sql_result1)==0)
			// {
				// $flag2=1;
			// }
			// $flag=0;
			// $flag2=0;
			//echo "<br/> Flag2 Value2: ".$flag."-".$flag2."<br/>";
			//echo "Total Output Reported:$carton_qty_completed"."<br/>";
			//echo "Carton Qty Received sofar:$received_qty"."<br/>";
			//echo "Carton Qty :$carton_qty"."<br/>";
			//if($carton_qty_completed>=($carton_qty+$received_qty))
			if($flag==0 and $flag2==0)
			{
				echo '<form name="input" method="post" action="'; echo $_SERVER['php_self']; echo '?>">
				<input type="hidden" value="'.$cartonid.'" name="cartonid">
				<input type="hidden" value="'.$doc_no.'" name="doc_no">
				<input type="hidden" value="'.$doc_no_ref.'" name="doc_no_ref">
				<input type="hidden" value="'.$size.'" name="size">
				<input type="hidden" value="'.$schedule.'" name="schedule">';
				
				//echo '<input type="submit" name="update" value="update">'; 2011-06-01
				echo '</form>';
	
				//echo "<script>document.getElementById('update').click();</script>"; 2011-06-01
				
				//2011-06-01
				if(trim($doc_no)==trim($doc_no_ref))
				{
					
						$sql1="SELECT sfcs_tid_ref FROM $m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE sfcs_schedule=$schedule and m3_op_des='CPK' and sfcs_remarks='' and sfcs_tid_ref in (".$cartonid.")";
						$sql1_res=mysqli_query($link, $sql1) or exit("<div class='alert alert-danger' role='alert'>M3 Error1: Carton was already scanned!".mysqli_error($GLOBALS["___mysqli_ston"]).'</div>');
						$m3_val_chk=mysqli_num_rows($sql1_res);					
					
						//if(mysql_affected_rows($link)>0)
						if($schedule>0 and $m3_val_chk==0)
						{
							/* $sql="update pac_stat_log set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where tid=$cartonid";
							//echo $sql;
							mysql_query($sql,$link) or exit("Sql Error".mysql_error());
							
							$sql="update  $packing_summary_tmp_v3 set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where tid=$cartonid";
							//echo $sql;
							mysql_query($sql,$link) or exit("Sql Error".mysql_error()); */
							
							//M3 Bulk Upload
							$sql1="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref) SELECT NOW(),order_style_no,order_del_no,order_col_des,size_code,doc_no,carton_act_qty,concat(user(),'-','$emp_id'),'CPK',tid FROM $bai_pro3.packing_summary WHERE tid in (".$cartonid.") AND tid NOT IN (SELECT sfcs_tid_ref FROM $m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE sfcs_schedule=$schedule and m3_op_des='CPK' and sfcs_remarks='')";
							//$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref) SELECT NOW(),order_style_no,order_del_no,order_col_des,size_code,doc_no,carton_act_qty,concat(user(),'-','$emp_id'),'CPK',tid FROM bai_pro3.packing_summary WHERE tid in (".$cartonid.")";
							mysqli_query($link, $sql1) or exit("<div class='alert alert-danger' role='alert'>M3 Error2: Carton was already scanned!".mysqli_error($GLOBALS["___mysqli_ston"]).'</div>');
						
						
							$sql="update $bai_pro3.pac_stat_log set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where tid=$cartonid";
							//echo $sql;
							mysqli_query($link, $sql) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							$sql="update  $packing_summary_tmp_v3 set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where tid=$cartonid";
							//echo $sql;
							mysqli_query($link, $sql) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						if($m3_val_chk>0)
						{
							$sql="update $bai_pro3.pac_stat_log set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where tid=$cartonid";

							$sql="update $bai_pro3.pac_stat_log set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where tid=$cartonid";
							//echo $sql;
							mysqli_query($link, $sql) or exit("Sql Error15".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							$sql="update  $packing_summary_tmp_v3 set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where tid=$cartonid";
							//echo $sql;
							mysqli_query($link, $sql) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
					}
				}
				else
				{
					
						//echo "Ramesh";
						//M3 operation reporting
						//if(mysql_affected_rows($link)>0)
						{
							$tid_ref_array=array();
							if($ratio_packing_method=='multiple')
							{
								$sql1="select tid from Vpac_stat_log where doc_no IN (SELECT doc_no FROM 
									$bai_pro3.plandoc_stat_log WHERE order_tid LIKE \"% $schedule%\") AND doc_no_ref LIKE \"%$cartonid%\" ";
							}
							else
							{
								$sql1="SELECT tid from $bai_pro3.pac_stat_log where doc_no_ref='$doc_no_ref'";
							}	
							$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row1=mysqli_fetch_array($sql_result1))
							{
								$tid_ref_array[]=$sql_row1['tid'];
							}
						
							
							$sql1="SELECT sfcs_tid_ref FROM $m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE sfcs_schedule=$schedule and  m3_op_des='CPK' and sfcs_remarks='' and sfcs_tid_ref in (".implode(",",$tid_ref_array).")";
							$sql1_res=mysqli_query($link, $sql1) or exit("<div class='alert alert-danger' role='alert'>M3 Error3: Carton was already scanned! $sql1".mysqli_error($GLOBALS["___mysqli_ston"]).'</div>');
							$m3_val_chk=mysqli_num_rows($sql1_res);
						
						
							if(sizeof($tid_ref_array)>0 and $schedule>0 and $m3_val_chk==0)
							{
								// echo "SR=1<br>";
								/* $sql="update pac_stat_log set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where doc_no_ref=\"$doc_no_ref\"";
								//echo $sql;
								mysql_query($sql,$link) or exit("Sql Error".mysql_error());
									
								
								$sql="update $packing_summary_tmp_v3 set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where doc_no_ref=\"$doc_no_ref\"";
								//echo $sql;
								mysql_query($sql,$link) or exit("Sql Error".mysql_error()); */
								
								//M3 Bulk Upload
								$sql1="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref) SELECT NOW(),order_style_no,order_del_no,order_col_des,size_code,doc_no,carton_act_qty,concat(user(),'-','$emp_id'),'CPK',tid FROM $bai_pro3.packing_summary WHERE tid in (".implode(",",$tid_ref_array).") AND tid NOT IN (SELECT sfcs_tid_ref FROM 
									$m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE sfcs_schedule=$schedule and  m3_op_des='CPK' and sfcs_remarks='')";
								//$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref) SELECT NOW(),order_style_no,order_del_no,order_col_des,size_code,doc_no,carton_act_qty,concat(user(),'-','$emp_id'),'CPK',tid FROM bai_pro3.packing_summary WHERE tid in (".implode(",",$tid_ref_array).")";
								mysqli_query($link, $sql1) or exit("<div class='alert alert-danger' role='alert'>M3 Error4: Carton was already scanned!".mysqli_error($GLOBALS["___mysqli_ston"]).'</div>');	
								
						
								if($ratio_packing_method=='multiple')
								{
									//$sql="update pac_stat_log set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where doc_no_ref=\"$doc_no_ref\"";
									$sql="update $bai_pro3.pac_stat_log set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where doc_no IN (SELECT doc_no FROM $bai_pro3.plandoc_stat_log WHERE order_tid LIKE '% $schedule%') AND doc_no_ref LIKE '%$cartonid%'";
									//echo "<br/> else:".$sql."<br/>";
									mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
										
									
									//$sql="update $packing_summary_tmp_v3 set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where doc_no_ref=\"$doc_no_ref\"";
									$sql="update $packing_summary_tmp_v3 set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where doc_no IN (SELECT doc_no FROM $bai_pro3.plandoc_stat_log WHERE order_tid LIKE '% $schedule%') AND doc_no_ref LIKE '%$cartonid%'";
									//echo "<br/> else:".$sql."<br/>";
									mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
								}
								else
								{
									$sql="update $bai_pro3.pac_stat_log set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where doc_no_ref=\"$doc_no_ref\"";
									//$sql="update pac_stat_log set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where doc_no IN (SELECT doc_no FROM bai_pro3.plandoc_stat_log WHERE order_tid LIKE '% $schedule%') AND doc_no_ref LIKE '%$cartonid%'";
									//echo "<br/> else:".$sql."<br/>";
									mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
										
									
									$sql="update $packing_summary_tmp_v3 set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where doc_no_ref=\"$doc_no_ref\"";
									//$sql="update $packing_summary_tmp_v3 set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where doc_no IN (SELECT doc_no FROM bai_pro3.plandoc_stat_log WHERE order_tid LIKE '% $schedule%') AND doc_no_ref LIKE '%$cartonid%'";
									//echo "<br/> else:".$sql."<br/>";
									mysqli_query($link, $sql) or exit("Sql Error85".mysqli_error($GLOBALS["___mysqli_ston"]));
								}
							}
							else
							{
								echo "SR=2<br>";
								if($m3_val_chk>0)
								{
									if($ratio_packing_method=='multiple')
									{
										//$sql="update pac_stat_log set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where doc_no_ref=\"$doc_no_ref\"";
										$sql="update $bai_pro3.pac_stat_log set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where doc_no IN (SELECT doc_no FROM $bai_pro3.plandoc_stat_log WHERE order_tid LIKE '% $schedule%') AND doc_no_ref LIKE '%$cartonid%'";
										//echo "<br/> else1:".$sql."<br/>";
										mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
									
								
										//$sql="update $packing_summary_tmp_v3 set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where doc_no_ref=\"$doc_no_ref\"";
										$sql="update $packing_summary_tmp_v3 set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where doc_no IN (SELECT doc_no FROM 
											$bai_pro3.bai_pro3.plandoc_stat_log WHERE order_tid LIKE '% $schedule%') AND doc_no_ref LIKE '%$cartonid%'";
										//echo "<br/> else1:".$sql."<br/>";
										mysqli_query($link, $sql) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
									}
									else
									{
										$sql="update $bai_pro3.pac_stat_log set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where doc_no_ref=\"$doc_no_ref\"";
										//$sql="update pac_stat_log set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where doc_no IN (SELECT doc_no FROM bai_pro3.plandoc_stat_log WHERE order_tid LIKE '% $schedule%') AND doc_no_ref LIKE '%$cartonid%'";
										//echo "<br/> else1:".$sql."<br/>";
										mysqli_query($link, $sql) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
									
								
										$sql="update $packing_summary_tmp_v3 set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where doc_no_ref=\"$doc_no_ref\"";
										//$sql="update $packing_summary_tmp_v3 set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\" where doc_no IN (SELECT doc_no FROM bai_pro3.plandoc_stat_log WHERE order_tid LIKE '% $schedule%') AND doc_no_ref LIKE '%$cartonid%'";
										//echo "<br/> else1:".$sql."<br/>";
										mysqli_query($link, $sql) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
									}
								}
							}
									
							
							
						}
				}
				echo "<tr><td>Status</td><td><span class='label label-success'>Successfully Updated.</span></td></tr>";
				//echo "<h2>Successfully Updated.</h2>";
				echo '<bgsound src="done.mp3" loop="false">';
				
				//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"packing_check_point_v1.php?trigger=1\"; }</script>";
				//2011-06-01
			}
			else
			{
				//NEW TO Track No Sufficient Qty
				$sql="update $bai_pro3.pac_stat_log set disp_id=1 where tid='$cartonid' or doc_no_ref='$cartonid'";
				mysqli_query($link, $sql) or exit("Sql Error25".mysqli_error($GLOBALS["___mysqli_ston"]));
				//NEW To Track No Sufficient Qty
				//echo "NEW To Track No Sufficient Qty1";
				echo "<tr><td>Status</td><td><span class='label label-danger'>No Sufficient Qty</span></td></tr>";
				echo '<bgsound src="red_alert.wav" loop="false">';
			}
		}
		echo "</table></div>";
	}
	
}else{
	echo "<script>sweetAlert('Invalid Carton Id to checkIn','','info');</script>";
}
	
}

?>
</div>
</div>
</div>
</div>




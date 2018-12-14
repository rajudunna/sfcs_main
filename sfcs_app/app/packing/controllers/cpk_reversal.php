
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'], "common/config/user_acl_v1.php", 3, "R"));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'], "common/config/group_def.php", 3, "R"));

?>

<script>

  
</script>

<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php', 3,'R')); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'], 'common/config/functions.php', 3, 'R')); 
include("../".getFullURL($_GET['r'], 'sesssion_track.php', 'R'));

//Exemption Handling
if($session_login_fg_carton_scan==1)
{
	$current_session_user='';
}

?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R') ); ?>
	<script>
	function checkx(x,y)
	{

		if(x<0)
		{
			alert("Enter Correct Value");
			//document.getElementById("submit").style.display="none";
			return 1010;
		}
		if(x>=y)
		{
			alert("Enter Correct Value");
			//document.getElementById("submit").style.display="none";
			return 1010;
		}
	}

	function validateQty(event) 
	{
		event = (event) ? event : window.event;
		var charCode = (event.which) ? event.which : event.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}
</script>
<script type="text/javascript">
	function check_sticker() {	
		var sticker=document.getElementById('cartonid').value;
		if(sticker=='')
		{
			sweetAlert('Please Enter Sticker Number','','info')
			return false;
		}
		else
		{
			return true;
		}
	}
</script>
<body>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php', 3,'R')); ?>

<div class="panel panel-primary">
<div class="panel-heading">FG Stock Reversal Form</div>
<div class="panel-body">

<form name="input" method="post" action="<?php echo getFullURL($_GET['r'],'cpk_reversal.php','N'); ?>" enctype="multipart/form data" class="form-inline">
<div class="form-group">
<label>Enter Sticker Number: </label>&nbsp;&nbsp;
<input type="text" onkeypress="return validateQty(event);" name="cartonid" id="cartonid" size=10 value="" class="form-control integer" />
</div>&nbsp;&nbsp;
<input type="submit" name="check" value="Check" class="btn btn-success" onclick="return check_sticker()">
</form>


<?php

if(isset($_POST['cartonid']))
{
	$cartonid=$_POST['cartonid'];
	echo "<hr>";
	$sql="select * from $bai_pro3.packing_summary where tid=$cartonid";
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error11".mysqli_error());
	$count=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$status=$sql_row['status'];
		$style=$sql_row['order_style_no'];
		$doc_no_ref=$sql_row['doc_no_ref'];
		$doc_no=$sql_row['doc_no'];
		$carton_act_qty=$sql_row['carton_act_qty'];
		$size_code=$sql_row['size_code'];
		$schedule=$sql_row['order_del_no'];
	}
	
	if(strlen($schedule)==0)
	{
		echo "<script>sweetAlert('No data available to process this label','','warning')</script>";

		exit();
	}
	else
	{
		$sql="update $bai_pro3.bai_orders_db_confirm set carton_print_status=NULL where order_del_no=\"$schedule\"";
		mysqli_query($link,$sql) or exit("Sql Error7 $sql".mysqli_error());	
	}
	

	$check_control=0;
	if($count==0)
	{
		echo "<script>sweetAlert('Carton label doesnt exist with this ID ','Please destroy the label','warning')</script>";


		exit();
	
		$check_control=1;
	}
	
	if(strlen($current_session_user)>0 and $status!="DONE")
	{		
		$packing_summary_tmp_v3="temp_pool_db.packing_summary_tmp_v3_$current_session_user";
		$sql="select status from $packing_summary_tmp_v3 where tid=$cartonid";
		$sql_result=mysqli_query($link,$sql) or exit("Sql Error11 $sql".mysqli_error($link));
		
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$status=$sql_row['status'];
		}
	}
	
	
	if($status!="DONE" or $check_control==1)
	{
		echo "<script>sweetAlert('Carton is not eligible for reversal','','warning')</script>";

		$check_control=1;
		exit();
		
	}
	
	$buyer_div=substr($style,0,1);
	// echo $buyer_div;
	//ADDED GLAMOUR BUYER ON 2012-03-29
	//REASON: BUYER NOT ASSIGNED HERE FOR GLAMOUR
	if(($buyer_div=="K" or $buyer_div=="P" or $buyer_div=="L" or $buyer_div=="O" or $buyer_div=="I" or $buyer_div=="S") and $check_control==0)
	{
		echo '<form name="input" method="post" action="'.getFullURL($_GET['r'],'cpk_reversal_process.php','N').'" class="form-inline">
		<input type="hidden" value="'.$cartonid.'" name="cartonid">
		<input type="hidden" value="'.$doc_no.'" name="doc_no">
		<input type="hidden" value="'.$doc_no_ref.'" name="doc_no_ref">
		<input type="hidden" value="'.$carton_act_qty.'" name="act_qty">
		<input type="hidden" value="'.$size_code.'" name="size_code">
		<label>Availabe Qty: <span class="label label-success">'.$carton_act_qty.'</span></label><br/>
		<label>Enter  Partial Qty :<label>&nbsp;&nbsp;<input type="text" name="part" size=10  onkeyup="if(checkx(this.value,'.$carton_act_qty.')==1010) {this.value=0;} class="form-control integer"/>
		&nbsp;&nbsp;<input type="submit" name="update" value="update" id="submit" class="btn btn-primary" required>
		</form>';
	}
	
	if(($buyer_div=="D" or $buyer_div=="M") and $check_control==0)
	{
	
		$sql="select group_concat(tid) as \"tid\", remarks, sum(carton_act_qty) as \"carton_act_qty\" from $bai_pro3.packing_summary where doc_no_ref=\"$doc_no_ref\"";
		//echo $sql;
		$sql_result=mysqli_query($link,$sql) or exit("Sql Error10".mysqli_error());
		$count=mysqli_num_rows($sql_result);
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$tid=$sql_row['tid'];
			$remarks=$sql_row['remarks'];
			$carton_act_qty=$sql_row['carton_act_qty'];
		}
		$temp=array();
		$temp=explode("*",$remarks);
		$temp1=array();
		$temp1=explode("$",$temp[0]);
		$assort_pcs=array_sum($temp1);
		$total_packs=$carton_act_qty/$assort_pcs;
		
		echo '<form name="input" method="post" action="'.getFullURL($_GET['r'],'cpk_reversal_process.php','N').'" class="form-inline">
		<input type="hidden" value="'.$cartonid.'" name="cartonid">
		<input type="hidden" value="'.$doc_no.'" name="doc_no">
		<input type="hidden" value="'.$doc_no_ref.'" name="doc_no_ref">
		<input type="hidden" value="'.$total_packs.'" name="act_qty">
		<input type="hidden" value="'.$size_code.'" name="size_code">
		<input type="hidden" value="'.$tid.'" name="tid">
		<input type="hidden" value="'.$remarks.'" name="remarks">
		<label>Available Packs : <span class="label label-success">'.$total_packs.'&nbsp;</label><br>
		<label>Enter Partial Packs : </label>&nbsp;&nbsp;<input type="text" name="part" size=10  onkeyup="if(checkx(this.value,'.$total_packs.')==1010) {this.value=0;}" class="form-control integer">
		&nbsp;&nbsp;<input type="submit" name="update1" value="update" id="submit" class="btn btn-primary" required/>
		</form>';
	}

}

?>
</div>
</div>

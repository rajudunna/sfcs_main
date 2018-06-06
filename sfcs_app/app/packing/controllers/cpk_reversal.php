
<?php
include("../".getFullURLLevel($_GET['r'], "common/config/user_acl_v1.php", 3, "R"));
include("../".getFullURLLevel($_GET['r'], "common/config/group_def.php", 3, "R"));

?>

<script>

  
</script>

<?php include("../".getFullURLLevel($_GET['r'],'common/config/config.php', 3,'R')); ?>
<?php include("../".getFullURLLevel($_GET['r'], 'common/config/functions.php', 3, 'R')); 
include("../".getFullURL($_GET['r'], 'sesssion_track.php', 'R'));

//Exemption Handling
if($session_login_fg_carton_scan==1)
{
	$current_session_user='';
}

?>

<?php //echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>
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
<?php //include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'menu_content.php','R') );  ?>

<?php include("../".getFullURLLevel($_GET['r'],'common/config/config.php', 3,'R')); ?>

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
	// echo $sql;
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
	
	// echo $schedule;
	if(strlen($schedule)==0)
	{
		// echo '<div class="alert alert-danger" role="alert">No data available to process this label.</div>';
		echo "<script>sweetAlert('No data available to process this label','','warning')</script>";

		exit();
		//echo "<table class='table table-bordered'><tr class='danger'><td align='center'>No data available to process this label.</td></tr></table>";
	}
	else
	{
		$sql="update $bai_pro3.bai_orders_db_confirm set carton_print_status=NULL where order_del_no=$schedule";
		mysqli_query($link,$sql) or exit("Sql Error7 $sql".mysqli_error());	
	}
	

	$check_control=0;
	if($count==0)
	{
		// echo '<div class="alert alert-warning" role="alert">Carton label doesnt exist with this ID, Please destroy the lable</div>';
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
		// echo '<div class="alert alert-danger" role="alert">Carton is not eligible for reversal.</div>';
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

<?php
/*
if(isset($_POST['update']))
{
	$cartonid_x=$_POST['cartonid'];
	$doc_no_x=$_POST['doc_no'];
	$act_qty_x=$_POST['act_qty'];
	$size_code_x=$_POST['size_code'];
	$part=$_POST['part'];
	
	if($part>0 and $part<$act_qty_x)
	{
		$sql="insert into pac_stat_log (doc_no,size_code,carton_no,carton_mode,carton_act_qty) values (\"$doc_no_x\",\"$size_code_x\",1,\"P\",$part)";
		mysqli_query($link,$sql) or exit("Sql Error1".mysqli_error());
		$ilastid=mysqli_insert_id($link);
		$sql="update pac_stat_log set doc_no_ref=\"$doc_no_x-$ilastid\", disp_id=NULL, disp_carton_no=NULL, status=NULL where tid=$ilastid";
		mysqli_query($link,$sql) or exit("Sql Error2".mysqli_error());
		
		$sql="insert into pac_stat_log (doc_no,size_code,carton_no,carton_mode,carton_act_qty) values (\"$doc_no_x\",\"$size_code_x\",2,\"P\",".($act_qty_x-$part).")";
		mysqli_query($link,$sql) or exit("Sql Error3".mysqli_error());
		$ilastid=mysqli_insert_id($link);
		$sql="update pac_stat_log set doc_no_ref=\"$doc_no_x-$ilastid\", disp_id=NULL, disp_carton_no=NULL, status=NULL where tid=$ilastid";
		mysqli_query($link,$sql) or exit("Sql Error4".mysqli_error());
		
		$sql="insert into pac_stat_log_deleted select * from pac_stat_log where tid=$cartonid_x";
		mysqli_query($link,$sql) or exit("Sql Error5".mysqli_error());
		$sql="delete from pac_stat_log where tid=$cartonid_x";
		mysqli_query($link,$sql) or exit("Sql Error6".mysqli_error());
		echo '<h2><font color="green">Successfully Completed</h2>';
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",30); function Redirect() {  location.href = \"partial_breakup.php\"; }</script>";
	}
	else
	{
		echo "<h2>Enter Correct Qty</h2>";
	}
	

}

*/
?>

<?php
/*
if(isset($_POST['update1']))
{
	$cartonid_x=$_POST['cartonid'];
	$doc_no_x=$_POST['doc_no'];
	$act_qty_x=$_POST['act_qty'];
	$size_code_x=$_POST['size_code'];
	$part=$_POST['part'];
	$tid_x=$_POST['tid'];
	$remarks_x=$_POST['remarks'];
	
	if($part>0 and $part<$act_qty_x)
	{
		$temp=array();
		$temp=explode("*",$remarks_x);
		$assortment=array();
		$assortment=explode("$",$temp[0]);
		$assort_color=array();
		$assort_color=explode("$",$temp[1]);
		
		$pcs_deduct=array();
		for($i=0;$i<sizeof($assortment);$i++)
		{
			$pcs_deduct[]=$assortment[$i]*($act_qty_x-$part);
		}
		
		$new_tids=array();
		$new_tids_ref=array();
		$new_tids_p1=array();
		$new_tids_p1_ref=array();
		for($i=0;$i<sizeof($pcs_deduct);$i++)
		{
			$sql="select * from packing_summary where tid in ($tid_x) and order_col_des=\"$assort_color[$i]\" and carton_act_qty>=".$pcs_deduct[$i]." limit 1";
			mysqli_query($link,$sql) or exit("Sql Error12".mysqli_error());
			$sql_result=mysqli_query($link,$sql) or exit("Sql Error13".mysqli_error());
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$tid_new=$sql_row['tid'];
				$doc_no_new=$sql_row['doc_no'];
				$existing_cart_qty=$sql_row['carton_act_qty'];
				
				$sql="insert into pac_stat_log (doc_no,size_code,carton_no,carton_mode,carton_act_qty) values (\"$doc_no_new\",\"$size_code_x\",1,\"P\",$pcs_deduct[$i])";
				mysqli_query($link,$sql) or exit("Sql Error14".mysqli_error());
				$new_tids[]=mysqli_insert_id($link);
				$new_tids_ref[]=$doc_no_new."-".mysqli_insert_id($link);
				
				$sql="insert into pac_stat_log (doc_no,size_code,carton_no,carton_mode,carton_act_qty) values (\"$doc_no_new\",\"$size_code_x\",2,\"P\",".($existing_cart_qty-$pcs_deduct[$i]).")";
				mysqli_query($link,$sql) or exit("Sql Error15".mysqli_error());
				$new_tids_p1[]=mysqli_insert_id($link);
				$new_tids_p1_ref[]=$doc_no_new."-".mysqli_insert_id($link);
			}
		}
		
		$sql="update pac_stat_log set doc_no_ref=\"".implode(",",$new_tids_ref)."\", remarks=\"$remarks_x\", disp_id=NULL, disp_carton_no=NULL, status=NULL where tid in (".implode(",",$new_tids).")";
		mysqli_query($link,$sql) or exit("Sql Error16".mysqli_error());
		
		$sql="update pac_stat_log set doc_no_ref=\"".implode(",",$new_tids_p1_ref)."\", remarks=\"$remarks_x\", disp_id=NULL, disp_carton_no=NULL, status=NULL where tid in (".implode(",",$new_tids_p1).")";
		mysqli_query($link,$sql) or exit("Sql Error17".mysqli_error());
		
		$sql="insert into pac_stat_log_deleted select * from pac_stat_log where tid in ($tid_x)";
		mysqli_query($link,$sql) or exit("Sql Error18".mysqli_error());
		$sql="delete from pac_stat_log where tid in ($tid_x)";
		mysqli_query($link,$sql) or exit("Sql Error19".mysqli_error());
		
		echo '<h2><font color="green">Successfully Completed</h2>';
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",30); function Redirect() {  location.href = \"partial_breakup.php\"; }</script>";
	}
	else
	{
		echo "<h2>Enter Correct Qty</h2>";
	}
}
*/	
?>
</div>
</div>

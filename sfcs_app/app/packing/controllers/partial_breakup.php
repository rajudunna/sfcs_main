<?php
	include("../".getFullURLLevel($_GET['r'], "common/config/user_acl_v1.php", 3, "R"));
	include("../".getFullURLLevel($_GET['r'], "common/config/group_def.php", 3, "R"));
	// $view_access=user_acl("SFCS_0123",$username,1,$group_id_sfcs); 
?>
<?php include("../".getFullURLLevel($_GET['r'],'common/config/config.php', 3,'R')); ?>
<?php include("../".getFullURLLevel($_GET['r'], 'common/config/functions.php', 3, 'R')); 
include("../".getFullURL($_GET['r'], "sesssion_track.php", 'R'));
//Exemption Handling
if($session_login_fg_carton_scan==1)
{
	$current_session_user='';
}
//Exemption Handling
$current_session_user = 'appalarajun';
$packing_summary_tmp_v3="temp_pool_db.packing_summary_tmp_v3_$current_session_user";
?>

	<?php include("../".getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R')); ?>
	<!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->
	<script>
	function checkx(x,y)
	{
		//document.getElementById("submit").style.display="";

		if(x<0)
		{
			
			sweetAlert('Enter Correct Value','','warning');
			//document.getElementById("submit").style.display="none";
			return 1010;
		}
		if(x>=y)
		{
			sweetAlert('Enter Correct Value','','warning');
			//document.getElementById("submit").style.display="none";
			return 1010;
		}
	}
	
	function check_sticker()
	{
		var sticker=document.getElementById('cartonid').value;
		if(sticker=='')
		{
			sweetAlert('Please Enter Sticker Number','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}
	</script>
</head>
<body>
<?php //include("../".getFullURLLevel($_GET['r'],'menu_content.php',1,'R')); ?>

<?php include("../".getFullURLLevel($_GET['r'],'common/config/config.php', 3,'R')); ?>

<div class="panel panel-primary">
<div class="panel-heading">Partial Carton Lable Creation Form</div>
<div class="panel-body">

<form name="input" method="post" action="<?php echo getFullURL($_GET['r'],'partial_breakup.php','N'); ?>" enctype="multipart/form data" class="form-inline">
<div class="form-group"><label>Enter Sticker Number  : </label>&nbsp;&nbsp;
<input type="text" name="cartonid" id="cartonid"  size=10 value="" class="form-control integer" />
</div>&nbsp;&nbsp;
<input type="submit" name="check" value="check" class="btn btn-success" onclick="return check_sticker();">
</form>
<div class="row">


<?php

if(isset($_POST['cartonid']))
{
	$cartonid=$_POST['cartonid'];
	
	$sql="select * from $bai_pro3.packing_summary where tid='$cartonid'";
	// echo $sql;
	mysqli_query($link,$sql) or exit("Sql Error8".mysqli_error());
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
		echo "";
	}
	else
	{
		$sql="update $bai_pro3.bai_orders_db_confirm set carton_print_status=NULL where order_del_no=$schedule";
		mysqli_query($link,$sql) or exit("Sql Error7 $sql".mysqli_error());	
	}
	$check_control=0;
	if($count==0)
	{
		echo "<hr><div class='alert alert-danger' role='alert'>Carton label doesnt exist with this ID, Please destroy the lable</div><br>";
		$check_control=1;
		exit();
	}
	//echo $status;
	if(strlen($current_session_user)>0 and $status!="DONE")
	{
		$current_session_user = 'appalarajun';
		$packing_summary_tmp_v3="temp_pool_db.packing_summary_tmp_v3_$current_session_user";
		$sql="select status from $bai_pro3.packing_summary_tmp_v3 where tid=$cartonid";
		$sql_result=mysqli_query($link,$sql) or exit("Sql Error11 $sql".mysqli_error());
		
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$status=$sql_row['status'];
		}
	}
	
	
	if($status=="DONE" or $status=="CHECK" or $check_control==1)
	{
		echo "<hr><div class='alert alert-warning' role='alert'>Carton label was already scanned!</div><br>";
		$check_control=1;
		exit();
		//$check_control=0; // This is enabled to take control on scanned labels too.
	}
	
	$buyer_div=substr($style,0,1);
	//echo $buyer_div;
	
	// echo '<hr><div class="col-md-6"><form name="input" method="post" action="'.getFullURL($_GET['r'],'partial_breakup_process.php','N').'">
	// 	<input type="hidden" value="'.$cartonid.'" name="cartonid">
	// 	<input type="hidden" value="'.$doc_no.'" name="doc_no">
	// 	<input type="hidden" value="'.$doc_no_ref.'" name="doc_no_ref">
	// 	<input type="hidden" value="'.$carton_act_qty.'" name="act_qty">
	// 	<input type="hidden" value="'.$size_code.'" name="size_code">
	// 	<label>Availabe Qty  : </label>&nbsp;&nbsp;<span class="label label-success">'.$carton_act_qty.'</span><br/>
	// 	<div class="row"><div class="col-md-6"><label>Enter  Partial Qty :</label><input type="text" name="part" size=10 onkeyup="if(checkx(this.value,'.$total_packs.')==1010) {this.value=0;}" class="form-control" required/></div>
	// <div class="col-md-3"><input type="submit" name="update" value="update" id="submit" class="btn btn-primary" style="margin-top:22px;"></div></div>
		
	// 	</form></div>';
	
	//ADDED GLAMOUR BUYER ON 2012-03-29
	//REASON: BUYER NOT ASSIGNED HERE FOR GLAMOUR
	if(($buyer_div=="K" or $buyer_div=="P" or $buyer_div=="L" or $buyer_div=="O" or $buyer_div=="G" or $buyer_div=="S") and $check_control==0)  // For BAI1 Buyers
	{
		echo '<div class="col-md-6"><form name="input" method="post" action="'.getFullURL($_GET['r'],'partial_breakup.php','N').'">
		<input type="hidden" value="'.$cartonid.'" name="cartonid">
		<input type="hidden" value="'.$doc_no.'" name="doc_no">
		<input type="hidden" value="'.$doc_no_ref.'" name="doc_no_ref">
		<input type="hidden" value="'.$carton_act_qty.'" name="act_qty">
		<input type="hidden" value="'.$size_code.'" name="size_code">
		<label>Availabe Qty : </label>&nbsp;&nbsp;<span class="label label-success">'.$carton_act_qty.'</span><br/>
		<div class="row"><div class="col-md-6"><label>Enter Partial Qty :</label><input type="text" name="part" class="form-control float" size=10 onkeyup="if(checkx(this.value,'.$total_packs.')==1010) {this.value=0;}" required/></div>
		<div class="col-md-3"><input type="submit" name="update" value="update" id="submit" class="btn btn-primary" style="margin-top:22px;"></div></div>
		</form></div><br><br>';
	}
	if(($buyer_div=="D" or $buyer_div=="M" or $buyer_div=="C" or $buyer_div=="T" or $buyer_div=="E") and $check_control==0)  // For BAI2 Buyers
	{
	
		$sql="select group_concat(tid) as \"tid\", remarks, sum(carton_act_qty) as \"carton_act_qty\" from $bai_pro3.packing_summary where doc_no_ref=\"$doc_no_ref\"";
		//echo $sql;
		mysqli_query($link,$sql) or exit("Sql Error9".mysqli_error());
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
		
		echo '<div class="col-md-6"><form name="input" method="post" action="'.getFullURL($_GET['r'],'partial_breakup.php','N').'">
		<input type="hidden" value="'.$cartonid.'" name="cartonid">
		<input type="hidden" value="'.$doc_no.'" name="doc_no">
		<input type="hidden" value="'.$doc_no_ref.'" name="doc_no_ref">
		<input type="hidden" value="'.$total_packs.'" name="act_qty">
		<input type="hidden" value="'.$size_code.'" name="size_code">
		<input type="hidden" value="'.$tid.'" name="tid">
		<input type="hidden" value="'.$remarks.'" name="remarks">
		<label>Available Packs :</label><span class="label label-success">'.$total_packs.'</span><br>
		<div class="row"><div class="col-md-6"><label>Enter  Partial Packs: </label><input type="text" class="form-control" name="part" size=10 onkeyup="if(checkx(this.value,'.$total_packs.')==1010) {this.value=0;}" required/></div>
		<div class="col-md-3"><input type="submit" name="update1" value="update" id="submit" class="btn btn-primary" style="margin-top:22px;"></div></div>
		</form></div><br><br>';
	}


//End of editing Kiran A//
	

}

?>

<?php
if(isset($_POST['update']))
{
	$cartonid_x=$_POST['cartonid'];
	$doc_no_x=$_POST['doc_no'];
	$act_qty_x=$_POST['act_qty'];
	$size_code_x=$_POST['size_code'];
	$part=$_POST['part'];
	
	$sql1="SELECT sfcs_tid_ref FROM $m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE  m3_op_des='CPK' and sfcs_remarks='' and sfcs_tid_ref in (".$cartonid_x.")";
	// echo $sql1;
	$sql1_res=mysqli_query($link,$sql1) or exit("M3 Error5: Carton was already scanned!".mysqli_error());
	$m3_val_chk=mysqli_num_rows($sql1_res);	
	$sql="select group_concat(tid) as \"tid\", remarks, sum(carton_act_qty) as \"carton_act_qty\", status from $bai_pro3.pac_stat_log where tid=$cartonid_x";
	// echo $sql;
	// die();
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error10".mysqli_error());
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$carton_act_qty=$sql_row['carton_act_qty'];
		$status=$sql_row['status'];
	}
	if($part>0 and $part<$act_qty_x and $status!="DONE" and $m3_val_chk==0)
	{
		$sql="insert into $bai_pro3.pac_stat_log (doc_no,size_code,carton_no,carton_mode,carton_act_qty,status) values (\"$doc_no_x\",\"$size_code_x\",1,\"P\",$part,'$status')";
		mysqli_query($link,$sql) or exit("Sql Error1 $sql".mysqli_error());
		$ilastid=mysqli_insert_id($link);
		$sql="update $bai_pro3.pac_stat_log set doc_no_ref=\"$doc_no_x-$ilastid\", disp_id=NULL, disp_carton_no=NULL where tid=$ilastid";
		mysqli_query($link,$sql) or exit("Sql Error2".mysqli_error());
		
		$sql="insert into $bai_pro3.pac_stat_log (doc_no,size_code,carton_no,carton_mode,carton_act_qty,status) values (\"$doc_no_x\",\"$size_code_x\",2,\"P\",".($act_qty_x-$part).",'$status')";
		mysqli_query($link,$sql) or exit("Sql Error3".mysqli_error());
		$ilastid=mysqli_insert_id($link);
		$sql="update $bai_pro3.pac_stat_log set doc_no_ref=\"$doc_no_x-$ilastid\", disp_id=NULL, disp_carton_no=NULL where tid=$ilastid";
		mysqli_query($link,$sql) or exit("Sql Error4".mysqli_error());
		
		$sql="insert into $bai_pro3.pac_stat_log_deleted select * from $bai_pro3.pac_stat_log where tid=$cartonid_x";
		mysqli_query($link,$sql) or exit("Sql Error5".mysqli_error());
		
		$sql="delete from $bai_pro3.pac_stat_log where tid=$cartonid_x";
		mysqli_query($link,$sql) or exit("Sql Error6".mysqli_error());
		
		if(strlen($current_session_user)>0)
		{
			$val=mysqli_query($link,"select * from $packing_summary_tmp_v3");
			if($val== TRUE)
			{
				$sql="delete from $packing_summary_tmp_v3 where tid=$cartonid_x";
				mysqli_query($link,$sql) or exit("Sql Error78".mysqli_error());
			}
		}
		
		
		echo "<br><br><br><br><div class='alert alert-success' role='alert'>Successfully Completed</div><br>";
		$url = getFullURL($_GET['r'],'partial_breakup.php','N');
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",30); function Redirect() {  location.href = \"$url\"; }</script>";
	}
	else
	{
		echo "<br><br><br><br><div class='alert alert-danger' role='alert'>Enter Correct Qty</div><br>";
	}
	

}

?>

<?php
if(isset($_POST['update1']))
{
	$cartonid_x=$_POST['cartonid'];
	$doc_no_x=$_POST['doc_no'];
	$act_qty_x=$_POST['act_qty'];
	$size_code_x=$_POST['size_code'];
	$part=$_POST['part'];
	$tid_x=$_POST['tid'];
	$remarks_x=$_POST['remarks'];
	$doc_no_ref=$_POST['doc_no_ref'];
	
	$tid_ref_array=array();
	$sql1="SELECT tid from pac_stat_log where doc_no_ref='$doc_no_ref'";
	//echo $sql1;
	$sql_result1=mysqli_query($link,$sql1) or exit("Sql Error".mysqli_error());
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$tid_ref_array[]=$sql_row1['tid'];
	}
	
	$sql1="SELECT sfcs_tid_ref FROM $m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE m3_op_des='CPK' and sfcs_remarks='' and sfcs_tid_ref in (".implode(",",$tid_ref_array).")";
	//echo $sql1;
	$sql1_res=mysqli_query($link,$sql1) or exit("M3 Error7: Carton was already scanned!".mysqli_error());
	$m3_val_chk=mysqli_num_rows($sql1_res);
	
	$sql="select group_concat(tid) as \"tid\", remarks, sum(carton_act_qty) as \"carton_act_qty\", status from $bai_pro3.pac_stat_log where doc_no_ref=\"$doc_no_ref\"";
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error10".mysqli_error());
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$carton_act_qty=$sql_row['carton_act_qty'];
		$status=$sql_row['status'];
	}
	
	if($part>0 and $part<$act_qty_x and $status!="DONE" and $m3_val_chk==0)
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
			//echo $assort_color[$i]."-".$pcs_deduct[$i]."<br/>";
            
            $sql="select * from $bai_pro3.packing_summary where tid in ($tid_x) and order_col_des=\"$assort_color[$i]\" ";
			mysqli_query($link,$sql) or exit("Sql Error12".mysqli_error());
			$sql_result=mysqli_query($link,$sql) or exit("Sql Error13".mysqli_error());
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$tid_new=$sql_row['tid'];
				$doc_no_new=$sql_row['doc_no'];
				$existing_cart_qty=$sql_row['carton_act_qty'];


                if($pcs_deduct[$i]>0)
                {
                    if($existing_cart_qty>=$pcs_deduct[$i])
                    {
                        //Actual Query
				        $sql="insert into $bai_pro3.pac_stat_log (doc_no,size_code,carton_no,carton_mode,carton_act_qty,status) values (\"$doc_no_new\",\"$size_code_x\",1,\"P\",".$pcs_deduct[$i].",'$status')";
				        mysqli_query($link,$sql) or exit("Sql Error14".mysqli_error());
	
				        $new_tids[]=mysqli_insert_id($link);
				        $new_tids_ref[]=$doc_no_new."-".mysqli_insert_id($link);
				
                        if(($existing_cart_qty-$pcs_deduct[$i])>0)
                        {
				            //Actual Query
				            $sql="insert into $bai_pro3.pac_stat_log (doc_no,size_code,carton_no,carton_mode,carton_act_qty,status) values (\"$doc_no_new\",\"$size_code_x\",2,\"P\",".($existing_cart_qty-$pcs_deduct[$i]).",'$status')";
				            mysqli_query($link,$sql) or exit("Sql Error15".mysqli_error());
				
				            $new_tids_p1[]=mysqli_insert_id($link);
				            $new_tids_p1_ref[]=$doc_no_new."-".mysqli_insert_id($link);

                        }
                        $pcs_deduct[$i]=0;
                    }
                    else
                    {
                        //Actual Query
				        $sql="insert into $bai_pro3.pac_stat_log (doc_no,size_code,carton_no,carton_mode,carton_act_qty,status) values (\"$doc_no_new\",\"$size_code_x\",1,\"P\",".$existing_cart_qty.",'$status')";
				        mysqli_query($link,$sql) or exit("Sql Error14".mysqli_error());
	
				        $new_tids[]=mysqli_insert_id($link);
				        $new_tids_ref[]=$doc_no_new."-".mysqli_insert_id($link);
                        
                        $pcs_deduct[$i]=$pcs_deduct[$i]-$existing_cart_qty;
                    }
                }
                else
                {
                    //Actual Query
				    $sql="insert into $bai_pro3.pac_stat_log (doc_no,size_code,carton_no,carton_mode,carton_act_qty,status) values (\"$doc_no_new\",\"$size_code_x\",2,\"P\",".$existing_cart_qty.",'$status')";
				    mysqli_query($link,$sql) or exit("Sql Error15".mysqli_error());
				
				    $new_tids_p1[]=mysqli_insert_id($link);
				    $new_tids_p1_ref[]=$doc_no_new."-".mysqli_insert_id($link);
                }
				
				
			}
		}
		
		
		
		$sql="update $bai_pro3.pac_stat_log set doc_no_ref=\"".implode(",",$new_tids_ref)."\", remarks=\"$remarks_x\", disp_id=NULL, disp_carton_no=NULL where tid in (".implode(",",$new_tids).")";
		mysqli_query($link,$sql) or exit("Sql Error16".mysqli_error());
			
		$sql="update $bai_pro3.pac_stat_log set doc_no_ref=\"".implode(",",$new_tids_p1_ref)."\", remarks=\"$remarks_x\", disp_id=NULL, disp_carton_no=NULL where tid in (".implode(",",$new_tids_p1).")";
		mysqli_query($link,$sql) or exit("Sql Error17".mysqli_error());
		
		$sql="insert into $bai_pro3.pac_stat_log_deleted select * from pac_stat_log where tid in ($tid_x)";
		mysqli_query($link,$sql) or exit("Sql Error18".mysqli_error());
		$sql="delete from $bai_pro3.pac_stat_log where tid in ($tid_x)";
		mysqli_query($link,$sql) or exit("Sql Error19".mysqli_error());
		
		if(strlen($current_session_user)>0)
		{
			$sql="delete from $packing_summary_tmp_v3 where tid in ($tid_x)";
			mysqli_query($link,$sql) or exit("Sql Error19".mysqli_error());
		}
		
		echo "<br><br><br><br><div class='alert alert-success' role='alert'>Successfully Completed</div><br>";
		$url = getFullURL($_GET['r'],'partial_breakup.php','N');
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",30); function Redirect() {  location.href = \"$url\"; }</script>";
	}
	else
	{
		echo "<br><br><br><br><div class='alert alert-danger' role='alert'>Enter Correct Qty</div><br>";
	}
}
		
?>
</div>
</div>
</div>

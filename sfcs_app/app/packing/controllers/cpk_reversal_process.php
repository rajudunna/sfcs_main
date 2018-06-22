<?php
//KiranG-20150522 (Status code will applied to split cartons when its in embellishment.)
//dummy commit

?>

<?php include("../".getFullURLLevel($_GET['r'],'common/config/config.php', 3,'R')); ?>
<?php include("../".getFullURLLevel($_GET['r'], 'common/config/functions.php', 3, 'R')); 
include("../".getFullURL($_GET['r'], 'sesssion_track.php', 'R'));

//Exemption Handling
if($session_login_fg_carton_scan==1)
{
	$current_session_user='';
}
//Exemption Handling
//$current_session_user = 'appalarajun';
$packing_summary_tmp_v3="temp_pool_db.packing_summary_tmp_v3_$current_session_user";
?>

<?php include('../'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R') ); ?>
	<!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->
	<script>
	function checkx(x,y)
	{
		//document.getElementById("submit").style.display="";

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
	
	function focus_box()
	{
		//document.getElementById("submit").style.display="none";
	}
	</script>
<body onload="focus_box()" style="background-color: #EEEEEE;"  >
<?php include('../'.getFullURLLevel($_GET['r'],'menu_content.php',1,'R') ); ?>

<?php 
//list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2);
/*
$sql="select * from menu_index where list_id=98";
$result=mysqli_query($link,$sql) or mysqli_error("Error=".mysqli_error($link));
while($row=mysqli_fetch_array($result))
{
	$users=$row["auth_members"];
}
*/
$username_access=user_acl("SFCS_0232",$username,7,$group_id_sfcs); 
//if($username=="amulyap" or $username=="kirang" or $username=="lilanku" or $username=="sasidharch" or $username=="kirang" or $username=="baifg" or $username=="sureshn" or $username=="edwinr")
//{
	
//}
//else
//{
	
//	echo "<h2>You are not authorised to use this inteface!!</h2>";
//	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",200); function Redirect() {  location.href = \"../index.php\"; }</script>";
//}

?>
<div class="panel panel-primary">
<div class="panel-heading">Partial Carton Lable Creation Form</div>
<div class="panel-body">
<?php
/*
<form name="input" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form data">
Enter Sticker Number: <!-- <input type="text" value="" name="cartonid"> -->
<input type="text" name="cartonid" size=10 value="">
<input type="submit" name="check" value="check"> 
</form>

*/

//echo "<center><br/><br/><br/><h1><font color=\"blue\">Please wait while splitting label...</font></h1></center>";
	
	ob_end_flush();
	flush();
	usleep(10);


?>

<?php
/*
if(isset($_POST['cartonid']))
{
	$cartonid=$_POST['cartonid'];
	
	$sql="select * from packing_summary where tid=$cartonid";
	//echo $sql;
	mysqli_query($link,$sql) or exit("Sql Error8".mysqli_error($link));
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error11".mysqli_error($link));
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
	
	$sql="update bai_orders_db_confirm set carton_print_status='$status' where order_del_no=$schedule";
	mysqli_query($link,$sql) or exit("Sql Error7".mysqli_error($link));

	$check_control=0;
	if($count==0)
	{
		echo "<h2>Carton label doesnt exist with this ID, Please destroy the lable</h2>";
		$check_control=1;
	}
	
	if($status=="DONE" or $status=="CHECK")
	{
		echo "<h2>Carton label was already scanned!</h2>";
		$check_control=1;
		//$check_control=0; // This is enabled to take control on scanned labels too.
	}
	
	$buyer_div=substr($style,0,1);
	//echo $buyer_div;
	//ADDED GLAMOUR BUYER ON 2012-03-29
	//REASON: BUYER NOT ASSIGNED HERE FOR GLAMOUR
	if(($buyer_div=="K" or $buyer_div=="P" or $buyer_div=="L" or $buyer_div=="O" or $buyer_div=="G") and $check_control==0)
	{
		echo '<form name="input" method="post" action="'; echo $_SERVER['php_self']; echo '?>">
		<input type="hidden" value="'.$cartonid.'" name="cartonid">
		<input type="hidden" value="'.$doc_no.'" name="doc_no">
		<input type="hidden" value="'.$doc_no_ref.'" name="doc_no_ref">
		<input type="hidden" value="'.$carton_act_qty.'" name="act_qty">
		<input type="hidden" value="'.$size_code.'" name="size_code">
		Availabe Qty: '.$carton_act_qty.'<br/>
		Enter  Partial Qty :<input type="text" name="part" size=10 onkeyup="if(checkx(this.value,'.$total_packs.')==1010) {this.value=0;}">
		<input type="submit" name="update" value="update" id="submit">
		</form>';
	}
	
	if(($buyer_div=="D" or $buyer_div=="M") and $check_control==0)
	{
	
		$sql="select group_concat(tid) as \"tid\", remarks, sum(carton_act_qty) as \"carton_act_qty\" from packing_summary where doc_no_ref=\"$doc_no_ref\"";
		//echo $sql;
		mysqli_query($link,$sql) or exit("Sql Error9".mysqli_error($link));
		$sql_result=mysqli_query($link,$sql) or exit("Sql Error10".mysqli_error($link));
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
		
		echo '<form name="input" method="post" action="'; echo $_SERVER['php_self']; echo '?>">
		<input type="hidden" value="'.$cartonid.'" name="cartonid">
		<input type="hidden" value="'.$doc_no.'" name="doc_no">
		<input type="hidden" value="'.$doc_no_ref.'" name="doc_no_ref">
		<input type="hidden" value="'.$total_packs.'" name="act_qty">
		<input type="hidden" value="'.$size_code.'" name="size_code">
		<input type="hidden" value="'.$tid.'" name="tid">
		<input type="hidden" value="'.$remarks.'" name="remarks">
		Available Packs:'.$total_packs.'
		Enter  Partial Packs: <input type="text" name="part" size=10 onkeyup="if(checkx(this.value,'.$total_packs.')==1010) {this.value=0;}">
		<input type="submit" name="update1" value="update1" id="submit">
		</form>';
	}

}
*/
?>


<?php
if(isset($_POST['update1']) or isset($_POST['update']))
{
	
	$cartonid_x=$_POST['cartonid'];
	$part=$_POST['part'];
	
	$sql="select *,IF(remarks IS NULL,CONCAT('1*',order_col_des),remarks) as remks from $bai_pro3.packing_summary where tid=$cartonid_x";
	//echo "query".$sql;
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error11".mysqli_error($link));
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
		$remks=$sql_row['remks'];
		$size=$sql_row['size_code'];
	}
	
	$temp=array();
	$temp=explode("*",$remks);
	$assortment=array();
	$assortment=explode("$",$temp[0]);
	$assort_color=array();
	$assort_color=explode("$",$temp[1]);
	
	$pcs_deduct=array();
	for($i=0;$i<sizeof($assortment);$i++)
	{
		$pcs_deduct[]=$assortment[$i]*($part);
	}
	
	$deduct_qty=array_sum($pcs_deduct);
	
	$flag=0; //Default OK and flag=1 is not OK
	
	
	//looping for individual color	
	{
		$order_qty=0;
		$sent_qty=0;
		$received_qty=0;
		
		$sql="select sum(order_s_$size) as \"order_qty\" from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
		//echo $schedule;
		$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysqli_error($link));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$order_qty=$sql_row['order_qty'];
		}
		
		$sql="select sum(ship_s_$size) as \"sent_qty\"  from $bai_pro3.ship_stat_log where ship_style=\"$style\" and ship_schedule=$schedule";
		//echo $sql;
		$sql_result=mysqli_query($link,$sql) or exit("Sql Error7".mysqli_error($link));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$sent_qty=$sql_row['sent_qty'];
		}
		
		$sql="select sum(carton_act_qty) as \"received_qty\" from $bai_pro3.packing_summary where order_style_no=\"$style\" and order_del_no=$schedule and size_code='$size' and status='DONE'";
		//echo $sql;
		$sql_result=mysqli_query($link,$sql) or exit("Sql Error6".mysqli_error($link));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$received_qty=$sql_row['received_qty'];
		}
		
		echo '<div class="row"><div class="col-md-4"><ul class="list-group">
				<li class="list-group-item"><b>Sent      :  </b>'.$sent_qty.'</li>
				<li class="list-group-item"><b>Received  :  </b>'.$received_qty.'</li>
				<li class="list-group-item"><b>Deducted  :  </b>'.$deduct_qty.'</li>
			</ul></div></div>';
		// echo "Sent:".$sent_qty."<br/>";
		// echo "Received:".$received_qty."<br/>";
		// echo "Deducted:".$deduct_qty."<br/>";
		//added additional conditions KiranG - SR# 682004 // 20150514
		if($sent_qty<=($received_qty-$deduct_qty))
		{
			$flag=0;
				
		}
		else
		{
			$flag=1;
			echo '<div class="alert alert-danger" role="alert">This carton split is invalid.</div>';
			//echo "<h2>This carton split is invalid</h2>";
		}
	}
}
?>

<?php
if(isset($_POST['update']) and $flag==0)
{
	$cartonid_x=$_POST['cartonid'];
	$doc_no_x=$_POST['doc_no'];
	$act_qty_x=$_POST['act_qty'];
	$size_code_x=$_POST['size_code'];
	$part=$_POST['part'];
	
	$sql="select group_concat(tid) as \"tid\", remarks, sum(carton_act_qty) as \"carton_act_qty\", status from $bai_pro3.pac_stat_log where tid=$cartonid_x";
	
	//echo "<br/>".$sql;
	
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error10".mysqli_error($link));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$carton_act_qty=$sql_row['carton_act_qty'];
		$status=$sql_row['status'];
	}
	
	if($part>0 and $part<$act_qty_x and $status=="DONE")
	{
		
		$sql_m3_log="SELECT m3_op_des as 'status' FROM $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_tid_ref='".$cartonid_x."' and m3_op_code<200 order by m3_op_code desc limit 1";
		
		//echo "<br/> m3_log<br/>".$sql_m3_log;
		
		$sql_result_m3_log=mysqli_query($link,$sql_m3_log) or exit("Sql Error $sql_m3_log".mysqli_error($link));
		
		while($sql_row_m3_log=mysqli_fetch_array($sql_result_m3_log))
		{
			$m3_status=$sql_row_m3_log['status'];
		}
		
		if($m3_status=='ASPS')
		{
			$packing_status='EGR';
		}
		else if($m3_status=='ASPR')
		{
			$packing_status='EGI';
		}
		else
		{
			$packing_status='';
		}
		
		
		$sql="insert into $bai_pro3.pac_stat_log (doc_no,size_code,carton_no,carton_mode,carton_act_qty,status) values (\"$doc_no_x\",\"$size_code_x\",1,\"P\",$part,'".$packing_status."')";
		
		//echo "<br/>partial<br/>".$sql;
		
		mysqli_query($link,$sql) or exit("Sql Error1 $sql".mysqli_error($link));
		
		//M3 Required
		
		
		$ilastid=mysqli_insert_id($link);
		
		
			//M3 Bulk Upload
			$sql1="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_remarks) SELECT NOW(),order_style_no,order_del_no,order_col_des,size_code,doc_no,-1*CAST(carton_act_qty AS SIGNED),USER(),'CPK',tid,'REVERSED' FROM bai_pro3.packing_summary WHERE tid in (".$ilastid.")";
			
			//echo "<br/>partial<br/>".$sql1;
			
			mysqli_query($link,$sql1) or exit("Sql Error $sql1".mysqli_error($link));
							
							
		$sql="update $bai_pro3.pac_stat_log set doc_no_ref=\"$doc_no_x-$ilastid\", disp_id=NULL, disp_carton_no=NULL where tid=$ilastid";
		
		//echo "<br/>partial<br/>".$sql;
		
		mysqli_query($link,$sql) or exit("Sql Error2".mysqli_error($link));
		
		$sql="insert into $bai_pro3.pac_stat_log (doc_no,size_code,carton_no,carton_mode,carton_act_qty,status) values (\"$doc_no_x\",\"$size_code_x\",2,\"P\",".($act_qty_x-$part).",'$status')";
		
		//echo "<br/>partial<br/>".$sql;
		
		mysqli_query($link,$sql) or exit("Sql Error3".mysqli_error($link));
		$ilastid=mysqli_insert_id($link);
		
		//M3 Required
		//Ignore list
		
		$sql="update $bai_pro3.pac_stat_log set doc_no_ref=\"$doc_no_x-$ilastid\", disp_id=NULL, disp_carton_no=NULL where tid=$ilastid";
		//echo "<br/>partial<br/>".$sql;
		
		mysqli_query($link,$sql) or exit("Sql Error4".mysqli_error($link));
		
		$sql="insert into $bai_pro3.pac_stat_log_deleted select * from pac_stat_log where tid=$cartonid_x";
		
		//echo "<br/>partial<br/>".$sql;
		
		mysqli_query($link,$sql) or exit("Sql Error5".mysqli_error($link));
		
		$sql="delete from $bai_pro3.pac_stat_log where tid=$cartonid_x";
		
		//echo "<br/>partial<br/>".$sql;
		
		mysqli_query($link,$sql) or exit("Sql Error64".mysqli_error($link));
		
		if(strlen($current_session_user)>0)
		{
			$sql="delete from $packing_summary_tmp_v3 where tid=$cartonid_x";
			//echo "<br/>partial<br/>".$sql;
			
			mysqli_query($link,$sql) or exit("Sql Error64.1".mysqli_error($link));
		}
		echo '<div class="alert alert-success" role="alert">Successfully Reversed.</div>';
		//echo '<h2><font color="green">Successfully Reversed</h2>';
		$url = getFullURL($_GET['r'],'cpk_reversal.php','N');
		echo "<script type=\"text/javascript\">alert('Successfully Reversed'); setTimeout(\"Redirect()\",100); function Redirect() {  location.href = \"$url\"; }</script>";
	}
	else
	{
		
		
		$sql_m3_log="SELECT m3_op_des as 'status' FROM $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_tid_ref='".$cartonid_x."' and m3_op_code<200 order by m3_op_code desc limit 1";
		$sql_result_m3_log=mysqli_query($sql_m3_log,$link) or exit("Sql Error $sql_m3_log".mysqli_error($link));
		
		while($sql_row_m3_log=mysqli_fetch_array($sql_result_m3_log))
		{
			$m3_status=$sql_row_m3_log['status'];
		}
		
		if($m3_status=='ASPS')
		{
			$packing_status='EGR';
		}
		else if($m3_status=='ASPR')
		{
			$packing_status='EGI';
		}
		else
		{
			$packing_status='';
		}
		
		$sql="update $bai_pro3.pac_stat_log set status='".$packing_status."' where tid=$cartonid_x";
		
		//echo "<br/>".$sql;
		
		mysqli_query($link,$sql) or exit("Sql Error61".mysqli_error($link));
		
			//M3 Bulk Upload
			$sql1="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_remarks) SELECT NOW(),order_style_no,order_del_no,order_col_des,size_code,doc_no,-1*CAST(carton_act_qty AS SIGNED),USER(),'CPK',tid,'REVERSED' FROM bai_pro3.packing_summary WHERE tid in (".$cartonid_x.")";
			
			
			//echo "<br/>".$sql1;
			
			mysqli_query($link,$sql1) or exit("Sql Error $sql1".mysqli_error($link));
			echo '<div class="alert alert-success" role="alert">Successfully Resettled.</div>';
		
		//M3 Required
	}
	

}


?>

<?php
if(isset($_POST['update1']) and $flag==0)
{
	$cartonid_x=$_POST['cartonid'];
	$doc_no_x=$_POST['doc_no'];
	$act_qty_x=$_POST['act_qty'];
	$size_code_x=$_POST['size_code'];
	$part=$_POST['part'];
	$tid_x=$_POST['tid'];
	$remarks_x=$_POST['remarks'];
	$doc_no_ref=$_POST['doc_no_ref'];
	
	
	$sql="select group_concat(tid) as \"tid\", remarks, sum(carton_act_qty) as \"carton_act_qty\", status from $bai_pro3.pac_stat_log where doc_no_ref=\"$doc_no_ref\"";
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error10".mysqli_error($link));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$carton_act_qty=$sql_row['carton_act_qty'];
		$status=$sql_row['status'];
	}
	
	
	
	if($part>0 and $part<$act_qty_x and $status=="DONE")
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
			
			//echo "<br/>partial<br/>".$sql;
			
			mysqli_query($link,$sql) or exit("Sql Error12".mysqli_error($link));
			$sql_result=mysqli_query($link,$sql) or exit("Sql Error13".mysqli_error($link));
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
				        $sql="insert into $bai_pro3.pac_stat_log (doc_no,size_code,carton_no,carton_mode,carton_act_qty,status) values (\"$doc_no_new\",\"$size_code_x\",1,\"P\",".$pcs_deduct[$i].",'')";
						
					//	echo "<br/>partial<br/>".$sql;
						
				        mysqli_query($link,$sql) or exit("Sql Error14".mysqli_error($link));
						//M3 Required
						
						//M3 Bulk Upload
						$sql1="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_remarks) SELECT NOW(),order_style_no,order_del_no,order_col_des,size_code,doc_no,-1*CAST(carton_act_qty AS SIGNED),USER(),'CPK',tid,'REVERSED' FROM bai_pro3.packing_summary WHERE tid in (".mysqli_insert_id($link).")";
						mysqli_query($link,$sql1) or exit("Sql Error $sql1".mysqli_error($link));
						
				        $new_tids[]=mysqli_insert_id($link);
				        $new_tids_ref[]=$doc_no_new."-".mysqli_insert_id($link);
				
                        if(($existing_cart_qty-$pcs_deduct[$i])>0)
                        {
				            //Actual Query
				            $sql="insert into $bai_pro3.pac_stat_log (doc_no,size_code,carton_no,carton_mode,carton_act_qty,status) values (\"$doc_no_new\",\"$size_code_x\",2,\"P\",".($existing_cart_qty-$pcs_deduct[$i]).",'$status')";
							
						//	echo "<br/>partial<br/>".$sql;
							
				            mysqli_query($link,$sql) or exit("Sql Error15".mysqli_error($link));
				
				            $new_tids_p1[]=mysqli_insert_id($link);
				            $new_tids_p1_ref[]=$doc_no_new."-".mysqli_insert_id($link);

                        }
                        $pcs_deduct[$i]=0;
                    }
                    else
                    {
                        //Actual Query
				        $sql="insert into $bai_pro3.pac_stat_log (doc_no,size_code,carton_no,carton_mode,carton_act_qty,status) values (\"$doc_no_new\",\"$size_code_x\",1,\"P\",".$existing_cart_qty.",'')";
						
					//	echo "<br/>partial<br/>".$sql;
						
				        mysqli_query($link,$sql) or exit("Sql Error14".mysqli_error($link));
						//M3 Required
						
						
						//M3 Bulk Upload
						$sql1="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_remarks) SELECT NOW(),order_style_no,order_del_no,order_col_des,size_code,doc_no,-1*CAST(carton_act_qty AS SIGNED),USER(),'CPK',tid,'REVERSED' FROM bai_pro3.packing_summary WHERE tid in (".mysqli_insert_id($link).")";
						mysqli_query($link,$sql1) or exit("Sql Error $sql1".mysqli_error($link));
						
				        $new_tids[]=mysqli_insert_id($link);
				        $new_tids_ref[]=$doc_no_new."-".mysqli_insert_id($link);
                        
                        $pcs_deduct[$i]=$pcs_deduct[$i]-$existing_cart_qty;
                    }
                }
                else
                {
                    //Actual Query
				    $sql="insert into $bai_pro3.pac_stat_log (doc_no,size_code,carton_no,carton_mode,carton_act_qty,status) values (\"$doc_no_new\",\"$size_code_x\",2,\"P\",".$existing_cart_qty.",'')";
				    mysqli_query($link,$sql) or exit("Sql Error15".mysqli_error($link));
					//M3 Required
					
					//M3 Bulk Upload
						$sql1="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_remarks) SELECT NOW(),order_style_no,order_del_no,order_col_des,size_code,doc_no,-1*CAST(carton_act_qty AS SIGNED),USER(),'CPK',tid,'REVERSED' FROM bai_pro3.packing_summary WHERE tid in (".mysqli_insert_id($link).")";
						mysqli_query($link,$sql1) or exit("Sql Error $sql1".mysqli_error($link));
						
						
				    $new_tids_p1[]=mysqli_insert_id($link);
				    $new_tids_p1_ref[]=$doc_no_new."-".mysqli_insert_id($link);
                }
				
				
			}
		}
		
		
		
		$sql="update $bai_pro3.pac_stat_log set doc_no_ref=\"".implode(",",$new_tids_ref)."\", remarks=\"$remarks_x\", disp_id=NULL, disp_carton_no=NULL where tid in (".implode(",",$new_tids).")";
		mysqli_query($link,$sql) or exit("Sql Error16".mysqli_error($link));
		
		//M3 Required
		//Ignore list
			
		$sql="update $bai_pro3.pac_stat_log set doc_no_ref=\"".implode(",",$new_tids_p1_ref)."\", remarks=\"$remarks_x\", disp_id=NULL, disp_carton_no=NULL where tid in (".implode(",",$new_tids_p1).")";
		mysqli_query($link,$sql) or exit("Sql Error17".mysqli_error($link));
		
		//M3 Required
		//Ignore list
		
		$sql="insert into $bai_pro3.pac_stat_log_deleted select * from pac_stat_log where tid in ($tid_x)";
		mysqli_query($link,$sql) or exit("Sql Error18".mysqli_error($link));
		$sql="delete from pac_stat_log where tid in ($tid_x)";
		mysqli_query($link,$sql) or exit("Sql Error19".mysqli_error($link));
	
		if(strlen($current_session_user)>0)
		{
			$sql="delete from $packing_summary_tmp_v3 where tid in ($tid_x)";
			mysqli_query($link,$sql) or exit("Sql Error19".mysqli_error($link));
		}
		echo '<div class="alert alert-success" role="alert">Successfully Reversed.</div>';
		$url = getFullURL($_GET['r'],'cpk_reversal.php','N');
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url\"; }</script>";
	}
	else
	{
		//echo "<h2>Successfully Resettled .</h2>";
		echo '<div class="alert alert-success" role="alert">Successfully Resettled.</div>';
		$sql="update $bai_pro3.pac_stat_log set status='' where doc_no_ref=\"$doc_no_ref\"";
		
		//echo "<br/>".$sql;
		
		mysqli_query($link,$sql) or exit("Sql Error62".mysqli_error($link));
		
		//M3 Required
	}
}
	
?>
</div>
</div>

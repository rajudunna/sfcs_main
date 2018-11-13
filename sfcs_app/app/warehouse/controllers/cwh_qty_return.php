<html>
	<head>
		<style>
		body
		{
			font-family:arial;
		}

		</style>
		<script>
		window.onload = function() 
		{
		document.getElementById("barcode").focus();
		};
		</script>
		<script>

		function numbersOnly()
		{
		   var charCode = event.keyCode;

					if (charCode >= 48 && charCode < 58)

						return true;
					else
						return false;
		}
		</script>
		<?php 
		$username_list=explode('\\',$_SERVER['REMOTE_USER']);
		$username=strtolower($username_list[1]);
		echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />';
 ?>
	</head>
<body>
<div class="panel panel-primary">
<div class="panel-heading"><h3 style="font-family:Helvetica Neue,Roboto,Arial,Droid Sans,sans-serif;font-size: 14px;"><b>RM Warehouse Material Return</b></h3></div>
		
		
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

if(isset($_POST['barcode']) && $_POST['barcode']!=''){
	//================ get barcode details from CWH DB =============
	$qry_get_data_fm_cwh = "select * from $bai_rm_pj1.store_in where tid=".$_POST['barcode'];
	//echo $qry_get_data_fm_cwh."<br/>";
   // $res_get_data_fm_cwh = $cwh_link->query($qry_get_data_fm_cwh);
    $res_get_data_fm_cwh = $link->query($qry_get_data_fm_cwh);
	$barcode_data = array();
	$sticker_data1= array();
	if($res_get_data_fm_cwh->num_rows == 0)
	{
		echo "<div class='alert alert-danger'>Sorry!! No Label ID(".$_POST['barcode'].") found..</div>";
	}
	else if ($res_get_data_fm_cwh->num_rows == 1) 
	{
		while($row = $res_get_data_fm_cwh->fetch_assoc()) 
		{
			$barcode_data = $row;
			break;
		}
		if(count($barcode_data)>0)
		{
			$actual_quentity_present = $barcode_data['qty_rec']+$barcode_data['qty_issued']+$barcode_data['qty_ret'];
			
				
			if($actual_quentity_present>0)
			{
				
					//=================== check rmwh db with present tid ==================
					$qry_check_rm_db = "select * from $bai_rm_pj1.store_in where tid=".$_POST['barcode'];
					//echo $qry_check_rm_db."<br/>";
					$res_check_rm_db = $cwh_link->query($qry_check_rm_db);
					if($res_check_rm_db->num_rows>0)
					{
					//=============== Update Data in rmwh ==========================
					$qry_insert_update_rmwh_data = "update $bai_rm_pj1.store_in set qty_issued=0;qty_ret=qty_ret+".$actual_quentity_present." where tid=".$_POST['barcode'];
					//echo $qry_insert_update_rmwh_data."<br/>";
					$res_insert_update_rmwh_data = $cwh_link->query($qry_insert_update_rmwh_data);
					//echo "<h3>Status: <font color=orange>already updated</font> $_POST['barcode']</h3>";
					
					$sticker_report = "select * from $bai_rm_pj1.`sticker_report` where lot_no=".$barcode_data['lot_no']."";
					//echo $sticker_report."<br/>";
					$res_sticker_report_cwh = $link->query($sticker_report);
					while($row1 = $res_sticker_report_cwh->fetch_assoc()) 
					{
						$sticker_data = $row1;
						break;
					}
					
					$sticker_report1 = "select * from $bai_rm_pj1.`sticker_report` where lot_no=".$barcode_data['lot_no']."";
					//echo $sticker_report1."<br/>";
					$res_sticker_report_cwh1 = $cwh_link->query($sticker_report1);
					while($row12 = $res_sticker_report_cwh1->fetch_assoc()) 
					{
						$sticker_data1 = $row12;
						break;
					}

					$qty_rec_store_report = "select sum(qty_rec)as qty_rec from $bai_rm_pj1.`store_in` where lot_no=".$barcode_data['lot_no']."";
				//echo $qty_rec_store_report."<br/>";
					$qty_rec_store_report1 = $cwh_link->query($qty_rec_store_report);
					while($row2 = $qty_rec_store_report1->fetch_assoc()) 
					{
						$rec_qty = $row2;
						break;
					}

					
					
					$qry_insert_sticker_report1_data = "update $bai_rm_pj1.`sticker_report` set rec_qty=\"".$rec_qty['qty_rec']."\",rec_no=\"".$sticker_data['rec_no']."\",inv_no=\"".$sticker_data['inv_no']."\",batch_no=\"".$sticker_data['batch_no']."\" where lot_no=\"".$sticker_data['lot_no']."\"";
					//echo $qry_insert_sticker_report1_data."<br/>";
					$qry_insert_sticker_report1_data1 = $cwh_link->query($qry_insert_sticker_report1_data);	
					$qry_get_data_fm_cwh1 = "select * from $bai_rm_pj1.store_in where lot_no=".$barcode_data['lot_no']."";
					$res_get_data_fm_cwh1 = $link->query($qry_get_data_fm_cwh1);
												
					$qry_ins_stockout = "delete from $bai_rm_pj1.`store_out` where tran_tid=".$_POST['barcode'];
					//echo $qry_ins_stockout."<br/>";
					$res_ins_stockout = $cwh_link->query($qry_ins_stockout);
					
					$update_qty_store_in = "update $bai_rm_pj1.store_in set qty_issued=0,qty_ret=qty_ret+".$actual_quentity_present." where tid=".$_POST['barcode'];
					//echo $update_qty_store_in."<br/>";
					$res_update_qty_store_in = $cwh_link->query($update_qty_store_in);
					$store_in = "delete from $bai_rm_pj1.store_in where tid=".$_POST['barcode'];
					$res_store_in = $link->query($store_in);
					//echo $update_qty_store_in."<br/>";
					
	
							

					
					echo "<h3>Status: <font color=Green>Quantity ".$actual_quentity_present." Transferred successfully for Item ID : ".$_POST['barcode']." and Lot Number : ".$barcode_data['lot_no']."</font></h3>";
					
					}
					$qty_rec_store_report8 = "select sum(qty_rec)as qty_rec from $bai_rm_pj1.`store_in` where lot_no=".$barcode_data['lot_no']."";
					
						$qty_rec_store_report18 = $link->query($qty_rec_store_report8);
						while($row8 = $qty_rec_store_report18->fetch_assoc()) 
						{
							$rec_qty1 = $row8;
							break;
						}
	
					if($qty_rec_store_report18->num_rows ==0)
						{
						
							$sticker_report = "delete from $bai_rm_pj1.sticker_report where lot_no=".$barcode_data['lot_no']."";
							//echo $update_qty_store_in."<br/>";
							$res_store_in1 = $link->query($sticker_report);
						}
						else{
							
							$sticker_report = "update $bai_rm_pj1.`sticker_report` set rec_qty=\"".$rec_qty1['qty_rec']."\" where lot_no=\"".$sticker_data['lot_no']."\"";
							
							$res_store_in1 = $link->query($sticker_report);	
						}		
					
			}
			else
			{
			
				echo "<h3>Status: <font color=Red>Sorry!! This Label ID Already Scanning Completed..".$actual_quentity_present."--".$flag."</font></h3>";
			}
		}
		else
		{
			echo "<h3>Status: <font color=Red>Sorry!! No Label ID found..</font></h3>";
		}
	} 
	else 
	{
		echo "<h3>Status: <font color=red>There are multiple Label Ids. System Can't pick the value. Please Contact Central RM Warehouse Team.</font></h3>";
	}
	
	
}
?>
		
		<form name="input" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form data" style="margin-left:29px;">
			<br/><textarea name="barcode" id='barcode' rows="2" cols="15" onkeydown="document.input.submit();"></textarea>
		</form></br>
		<form name="input1" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form data"  style="margin-left:29px;margin-bottom: 36px;">
			<b>Enter Lable ID:</b><br/>
			<input type='text' name='barcode'  onkeypress='return numbersOnly(event)'>
			<input type="submit" name="check2" value="Return" class="btn btn-success">
		</form>
        </div>
	</body>
</html>
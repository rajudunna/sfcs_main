<html>
	<head>
	<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/check.js',2,'R'); ?>"></script>

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
			function test(){
				if($('#plant_name').val() != null){
					document.input.submit();
				}else {
					sweetAlert('','Select Plant Name','Warning');
				}
			}
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
		echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />';
 ?>
	</head>
<body>
<div class="panel panel-primary">
<div class="panel-heading"><h3 style="font-family:Helvetica Neue,Roboto,Arial,Droid Sans,sans-serif;font-size: 14px;"><b>RM Ware House Material Receive</b></h3></div>
		
		
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
$username=getrbac_user()['uname'];	

	//============= CWH DB Credentials =============
	// $database="bai_rm_pj1";
	// $host="bekasfcs02";
	// $user="baiall";
	// $password="Beka@Max";

	// $conn = new mysqli($host, $user, $password,$database);

	// // Check connection
	// if ($conn->connect_error) {
	// 	die("Connection failed: " . $conn->connect_error);
	// } 

	// //===============================================
	// //=============== RMWH DB Credentials ==========
	// $database1="bai_rm_pj1";
	// $host1="bebsfcs02";
	// $user1="baiall";
	// $password1="Beb@Max";

	// $conn1 = new mysqli($host1, $user1, $password1,$database1);

	// // Check connection
	// if ($conn1->connect_error) {
	// 	die("Connection failed: " . $conn1->connect_error);
	// } 
	// //===============================================
if((isset($_POST['barcode']) && $_POST['barcode']!='') || (isset($_POST['barcode1']) && $_POST['barcode1']!='')){
	// echo $_POST['barcode'].'hh';
	// die();
	if($_POST['barcode']!=''){
		$bar_code_new = $_POST['barcode'];
	}else {
		$bar_code_new = $_POST['barcode1'];
	}
	$plant_name1=$_POST['plant_name'];

	$query = "select ip_address,port_number from $bai_pro3.plant_details where plant_code='".$plant_name1."'";
	$res = mysqli_query($link, $query) or exit($sql."<br/>Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rm = mysqli_fetch_array($res)){
		$ip_address = $rm['ip_address'];
		$port_number = $rm['port_number'];
		
	}
	$host_new=$ip_address.":".$port_number;

	
	$link_new= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host_new, $user, $pass)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));

	// $res_get_data_fm_cwh = $link_new->query($qry_get_data_fm_cwh);

	//================ get barcode details from CWH DB =============
	$qry_get_data_fm_cwh = "select * from $bai_rm_pj1.store_in where barcode_number='".$bar_code_new."'";
	// echo '<br/>'.$qry_get_data_fm_cwh."<br/>";
	$res_get_data_fm_cwh = $link_new->query($qry_get_data_fm_cwh);
	$barcode_data = array();
	$sticker_data1= array();
	if($res_get_data_fm_cwh->num_rows == 0)
	{
		echo "<div class='alert alert-danger'>Sorry!! No Label ID(".$bar_code_new.") found..</div>";
	}
	else if ($res_get_data_fm_cwh->num_rows == 1) 
	{
		while($row = $res_get_data_fm_cwh->fetch_assoc()) 
		{
			$barcode_data = $row;
			$tid_new = $row['tid'];
			break;
		}
		if(count($barcode_data)>0)
		{
			//$actual_quentity_present = $barcode_data['qty_rec']-$barcode_data['qty_issued']+$barcode_data['qty_ret'];
			$actual_quentity_present = $barcode_data['qty_rec']-$barcode_data['qty_issued'];
			// echo $actual_quentity_present.'if';

			if($actual_quentity_present>0)
			{
				
					//=================== check rmwh db with present tid ==================
					$qry_check_rm_db = "select * from $bai_rm_pj1.store_in where barcode_number='".$bar_code_new."'";
					$res_check_rm_db = $link->query($qry_check_rm_db);
					if($res_check_rm_db->num_rows == 0)
					{
						// echo $res_check_rm_db->num_rows.'aaaaa';
						//=============== Insert Data in rmwh ==========================
						$qry_insert_update_rmwh_data = "INSERT INTO $bai_rm_pj1.`store_in`(`tid`,`lot_no`, `qty_rec`, `qty_issued`, `qty_ret`, `date`, `remarks`, `log_stamp`, `status`,`ref2`,`ref3`,`ref4`,`ref5`,`ref6`,`log_user`,`barcode_number`,`ref_tid`) VALUES ('".$bar_code_new."','".$barcode_data['lot_no']."','".$actual_quentity_present."','0','0','".date('Y-m-d')."','Directly came from ".$plant_name1."','".date('Y-m-d H:i:s')."','".$barcode_data['status']."','".$barcode_data['ref2']."','".$barcode_data['ref3']."','".$barcode_data['ref4']."','".$barcode_data['ref5']."','".$barcode_data['ref6']."','".$username."^".date('Y-m-d H:i:s')."','".$bar_code_new."','".$tid_new."')";	
						// echo $qry_insert_update_rmwh_data."<br/>";
						$res_insert_update_rmwh_data = $link->query($qry_insert_update_rmwh_data);
						
						$sticker_report = "select * from $bai_rm_pj1.`sticker_report` where lot_no=".$barcode_data['lot_no']."";
						//echo $sticker_report."<br/>";
						$res_sticker_report_cwh = $link_new->query($sticker_report);
						while($row1 = $res_sticker_report_cwh->fetch_assoc()) 
						{
							$sticker_data = $row1;
							break;
						}
						
						$sticker_report1 = "select * from $bai_rm_pj1.`sticker_report` where lot_no=".$barcode_data['lot_no']."";
						//echo $sticker_report1."<br/>";
						$res_sticker_report_cwh1 = $link->query($sticker_report1);
						while($row12 = $res_sticker_report_cwh1->fetch_assoc()) 
						{
							$sticker_data1 = $row12;
							break;
						}
						//echo "<br/>No of rows:".$row12."<br/>";
						//echo "<br/>result:".count($sticker_data1)."<br/>";
						if(count($sticker_data1)==0)
						{
							$qry_insert_sticker_report_data = "INSERT INTO $bai_rm_pj1.`sticker_report` (`item`,`item_name`,`item_desc`,`inv_no`,`po_no`,`rec_no`,`lot_no`,`batch_no`,`buyer`,`product_group`,`doe`,`pkg_no`,`grn_date`,`allocated_qty`,`backup_status`,`supplier`,`uom`,`grn_location`) VALUES ('".$sticker_data['item']."','".$sticker_data['item_name']."','".$sticker_data['item_desc']."','".$sticker_data['inv_no']."','".$sticker_data['po_no']."','".$sticker_data['rec_no']."','".$sticker_data['lot_no']."','".$sticker_data['batch_no']."','".$sticker_data['buyer']."','".$sticker_data['product_group']."','".$sticker_data['doe']."','".$sticker_data['pkg_no']."','".$sticker_data['grn_date']."','".$sticker_data['allocated_qty']."','".$sticker_data['backup_status']."','".$sticker_data['supplier']."','".$sticker_data['uom']."','".$sticker_data['grn_location']."')";
							//echo $qry_insert_sticker_report_data."<br/>";
							$qry_insert_sticker_report_data1 = $link->query($qry_insert_sticker_report_data);
						}
						
						$qty_rec_store_report = "select sum(qty_rec)as qty_rec from $bai_rm_pj1.`store_in` where lot_no=".$barcode_data['lot_no']."";
						//echo $qty_rec_store_report."<br/>";
						$qty_rec_store_report1 = $link->query($qty_rec_store_report);
						while($row2 = $qty_rec_store_report1->fetch_assoc()) 
						{
							$rec_qty = $row2;
							break;
						}
						
						$qry_insert_sticker_report1_data = "update $bai_rm_pj1.`sticker_report` set rec_qty=\"".$rec_qty['qty_rec']."\",rec_no=\"".$sticker_data['rec_no']."\",inv_no=\"".$sticker_data['inv_no']."\",batch_no=\"".$sticker_data['batch_no']."\" where lot_no=\"".$sticker_data['lot_no']."\"";
						//echo $qry_insert_sticker_report1_data."<br/>";
						
						$qry_insert_sticker_report1_data1 = $link->query($qry_insert_sticker_report1_data);
						
					}
					else
					{
						// echo 'hio';
						//=============== Update Data in rmwh ==========================
						$qry_insert_update_rmwh_data = "update $bai_rm_pj1.store_in set qty_rec=qty_rec+".$actual_quentity_present." where barcode_number='".$bar_code_new."'";
						// echo $qry_insert_update_rmwh_data."<br/>";
						$res_insert_update_rmwh_data = $link->query($qry_insert_update_rmwh_data);
						//echo "<h3>Status: <font color=orange>already updated</font> $_POST['barcode']</h3>";
						
						$sticker_report = "select * from $bai_rm_pj1.`sticker_report` where lot_no=".$barcode_data['lot_no']."";
						//echo $sticker_report."<br/>";
						$res_sticker_report_cwh = $link_new->query($sticker_report);
						while($row1 = $res_sticker_report_cwh->fetch_assoc()) 
						{
							$sticker_data = $row1;
							break;
						}
						
						$sticker_report1 = "select * from $bai_rm_pj1.`sticker_report` where lot_no=".$barcode_data['lot_no']."";
						//echo $sticker_report1."<br/>";
						$res_sticker_report_cwh1 = $link->query($sticker_report1);
						while($row12 = $res_sticker_report_cwh1->fetch_assoc()) 
						{
							$sticker_data1 = $row12;
							break;
						}
						
						if(count($sticker_data1)==0)
						{
							$qry_insert_sticker_report_data = "INSERT INTO $bai_rm_pj1.`sticker_report` (`item`,`item_name`,`item_desc`,`inv_no`,`po_no`,`rec_no`,`rec_qty`,`lot_no`,`batch_no`,`buyer`,`product_group`,`doe`,`pkg_no`,`grn_date`,`allocated_qty`,	`backup_status`,`supplier`,`uom`,`grn_location`) VALUES ('".$sticker_data['item']."','".$sticker_data['item_name']."','".$sticker_data['item_desc']."','".$sticker_data['inv_no']."','".$sticker_data['po_no']."','".$sticker_data['rec_no']."','".$sticker_data['lot_no']."','".$sticker_data['batch_no']."','".$sticker_data['buyer']."','".$sticker_data['product_group']."','".$sticker_data['doe']."','".$sticker_data['pkg_no']."','".$sticker_data['grn_date']."','".$sticker_data['allocated_qty']."','".$sticker_data['backup_status']."','".$sticker_data['supplier']."','".$sticker_data['uom']."','".$sticker_data['grn_location']."')";
							//echo $qry_insert_sticker_report_data."<br/>";
							$qry_insert_sticker_report_data1 = $link->query($qry_insert_sticker_report_data);
						}
						
						$qty_rec_store_report = "select sum(qty_rec)as qty_rec from $bai_rm_pj1.`store_in` where lot_no=".$barcode_data['lot_no']."";
						//echo $qty_rec_store_report."<br/>";
						$qty_rec_store_report1 = $link->query($qty_rec_store_report);
						while($row2 = $qty_rec_store_report1->fetch_assoc()) 
						{
							$rec_qty = $row2;
							break;
						}
						
						
						$qry_insert_sticker_report1_data = "update $bai_rm_pj1.`sticker_report` set rec_qty=\"".$rec_qty['qty_rec']."\",rec_no=\"".$sticker_data['rec_no']."\",inv_no=\"".$sticker_data['inv_no']."\",batch_no=\"".$sticker_data['batch_no']."\" where lot_no=\"".$sticker_data['lot_no']."\"";
						//echo $qry_insert_sticker_report1_data."<br/>";
						$qry_insert_sticker_report1_data1 = $link->query($qry_insert_sticker_report1_data);
						
						
						//$qry_insert_sticker_report1_data = "update `sticker_report` set rec_qty=rec_qty+".$actual_quentity_present." where lot_no=".$sticker_data['lot_no']."";
						//echo $qry_insert_sticker_report1_data."<br/>";
						//$qry_insert_sticker_report1_data1 = $conn1->query($qry_insert_sticker_report1_data);
						
					}
					
					//echo $qry_insert_update_rmwh_data."<br/>";
					//$res_insert_update_rmwh_data = $conn1->query($qry_insert_update_rmwh_data);
					//=============== insert store_out & update store_in in cwh======================
										
					$qry_ins_stockout = "INSERT INTO $bai_rm_pj1.`store_out`(tran_tid,qty_issued,date,updated_by,remarks) VALUES (".$tid_new.",".$actual_quentity_present.",'".date('Y-m-d')."','".$username."','Send to ".$plant_name."')";
					// echo $qry_ins_stockout."<br/>";
					$res_ins_stockout = $link_new->query($qry_ins_stockout);
					
					$update_qty_store_in = "update $bai_rm_pj1.store_in set qty_ret=0,qty_issued=qty_issued+".$actual_quentity_present." where barcode_number='".$bar_code_new."'";
					//echo $update_qty_store_in."<br/>";
					$res_update_qty_store_in = $link_new->query($update_qty_store_in);
					echo "<h3>Status: <font color=Green>Quantity ".$actual_quentity_present." Transferred successfully for Item ID : ".$bar_code_new." and Lot Number : ".$barcode_data['lot_no']."</font></h3>";
					//=====================================================================
				
			}
			else
			{
			
				echo "<h3>Status: <font color=Red>Sorry!! This Label ID Scanning is Already Completed..</font></h3>";
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
		<?php 
			// echo $link;
		?>
		<form name="input" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form data" style="margin-left:29px;">
			<br/>
			<?php
				$query="SELECT * FROM $bai_pro3.plant_details";
				$query_result=mysqli_query($link, $query) or exit("Error getting Plant Details");
				echo "<tr>
						<td>Plant Name</td><td>:</td>
						<td><div class='row'><div class='col-sm-3'>
						<select name=\"plant_name\" id='plant_name' class='form-control' required>";
				echo "<option value='' selected disabled>Select Plant Name</option>";
				while($row=mysqli_fetch_array($query_result))
				{
					echo "<option value='".$row['plant_code']."'>".$row['plant_name']."</option>";
				}
				echo "</select></div></div>
					</td></tr>"; 
			?>
			<br/><textarea name="barcode" id='barcode' rows="2" cols="15" onchange="test();"></textarea>
			<br/>
			<input type='text' name='barcode1'>
			<!-- <input type='text' name='barcode'  onkeypress='return numbersOnly(event)'> -->
			<input type="submit" name="check2" value="Check Out" class="btn btn-success">
		</form></br>
		
        </div>
	</body>
</html>

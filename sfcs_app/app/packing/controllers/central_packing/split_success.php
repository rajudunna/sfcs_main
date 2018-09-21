<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/header_scripts.php',2,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/menu_content.php',2,'R')); 
    $has_permission=haspermission($_GET['r']);
?> 



<body> 
<div class="panel panel-primary">
<!-- <div class="panel-heading">Sewing Job Split</div> -->
<div class="panel-body">

<?php

    $username_list=explode('\\',$_SERVER['REMOTE_USER']); 
    $username=strtolower($username_list[1]); 
    $tids=$_POST['tid'];  
    $qtys=$_POST['qty']; 
	$schedule=$_POST['schedule'];
	$style=$_POST['style'];
	//$cartonno=$_POST['cartonno'];
	//$packmethod=$_POST['pack_method'];
    $seq_no=$_POST['seq_no'];
	$query_check = "SELECT MAX(status) as status,pac_stat_id FROM $bai_pro3.`pac_stat_log` WHERE tid in (".implode(",",$tids).")";
	//echo $query_check."<br>";
	$res_query_check=mysqli_query($link,$query_check);
	while($result = mysqli_fetch_array($res_query_check))
	{
		$status = $result['status'];
		$pac_stat_id = $result['pac_stat_id'];
	}
	if($status=='DONE')
	{
		$url_s = getFullURLLevel($_GET['r'],'split_jobs.php',0,'N');
		echo "<script>sweetAlert('Warning','For this Carton, Scanning is Performed.So, you cannot split this Carton  Anymore.','warning');</script>";
	}
	else
	{	
		$maxcartno="SELECT MAX(carton_no)+1 AS cartno FROM $bai_pro3.`pac_stat` WHERE schedule='$schedule' AND pac_seq_no='$seq_no'";
		$maxcartrslt=mysqli_query($link,$maxcartno);
		if($row=mysqli_fetch_array($maxcartrslt))
		{
			$maxcartonno=$row['cartno'];
		}
		$sql1q="INSERT INTO `$bai_pro3`.`pac_stat` (`style`, `schedule`, `pac_seq_no`, `carton_no`, `carton_mode`, `carton_qty`) VALUES ('$style', '$schedule', '$seq_no', '$maxcartonno', 'P', '".array_sum($qtys)."')";
		//echo $sql1q."<br>";
		mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$parent_id=mysqli_insert_id($link);
		$sql1q1="update `$bai_pro3`.`pac_stat` set `carton_mode`= 'P',carton_qty=(carton_qty-".array_sum($qtys).") where id='$pac_stat_id'";
		mysqli_query($link, $sql1q1) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo $sql1q1."<br>";
		$ops_id=array();
		$ops_name=array();
		$ops_idsql = "SELECT operation_code,operation_description FROM $brandix_bts.`tbl_orders_ops_ref` WHERE category='PACKING'";
		//echo $ops_idsql."<br>";
		$ops_id_check=mysqli_query($link,$ops_idsql);
		while($result_ops = mysqli_fetch_array($ops_id_check))
		{
			$ops_id[] = $result_ops['operation_code'];
			$ops_name[] = $result_ops['operation_description'];
		}
		for ($ii=0; $ii <sizeof($tids); $ii++)
		{ 
			$tid=$tids[$ii]; 
			$qty=$qtys[$ii]; 
		
			$sql="SELECT * FROM $bai_pro3.pac_stat_log where tid = '$tid'"; 
			// echo $sql.'<br>';
			$result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($row=mysqli_fetch_array($result))
			{ 
				//$doc_no=$row['doc_no']; 
				$size_code=$row['size_code'];
				//$cartonno=$row['carton_no'];
				//$cartonmode=$row['carton_mode'];	
				$carton_act_qty=$row['carton_act_qty']; 
				$status=$row['status']; 
				$doc_no_ref=$row['doc_no_ref'];
				$container=$row['container']; 	
				$input_job_no=$row['input_job_number']; 
				$input_job_random=$row['input_job_random']; 
				$ordertid=$row['order_tid']; 
				$color=$row['color']; 
				$size_tit=$row['size_tit']; 
				$seq_no=$row['seq_no']; 
				$pacseqno=$row['pac_seq_no']; 
				$newdoc_no_ref=$schedule."-".$seq_no."-".$newcartno;			
				$url_s = getFullURLLevel($_GET['r'],'carton_split.php',0,'N');
				if($qty > 0)  
				{
					if ($carton_act_qty == $qty) 
					{
						$sql2="UPDATE $bai_pro3.pac_stat_log SET pac_stat_id='$parent_id' WHERE tid='$tid'"; 
						mysqli_query($link, $sql2) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
						//echo $sql2."<br>";
					}
					else
					{
						$nqty=$carton_act_qty-$qty;
						if($nqty>0)
						{
							$sql1q="INSERT INTO `$bai_pro3`.`pac_stat_log` (`size_code`, `carton_act_qty`, `status`, `style`, `schedule`, `color`,`size_tit`, `pac_stat_id`) VALUES ('".$size_code."', '".$qty."', NULL, '".$style."', '".$schedule."', '".$color."','".$size_tit."','".$parent_id."')";
							$result231=mysqli_query($link, $sql1q) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));		
							$new_ref_id=mysqli_insert_id($link);
							//echo $sql1q."<br>";
							//echo $new_ref_id."---<br>";
							$date_rev=date("Y-m-d H:i:s");
							for($i=0;$i<sizeof($ops_id);$i++)
							{
								$sql23="SELECT * FROM $bai_pro3.mo_operation_quantites where ref_no = '$tid' and op_code='$ops_id[$i]'";
								$result23=mysqli_query($link, $sql23) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"])); 
								if(mysqli_num_rows($result23)==1)
								{
									while($row23=mysqli_fetch_array($result23))
									{ 
										$sql22="UPDATE $bai_pro3.mo_operation_quantites SET bundle_quantity='$nqty' WHERE ref_no='$tid' and op_code='$ops_id[$i]'";
										//echo $sql22.'<br>'; 
										mysqli_query($link, $sql22) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
										
										$sql21="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`, `bundle_quantity`, `good_quantity`, `rejected_quantity`, `op_code`, `op_desc`) VALUES ('".$date_rev."', '".$row23['mo_no']."', '$new_ref_id', '$qty', '0', '0', '$ops_id[$i]', '$ops_name[$i]')";
										//echo $sql21."<br>";
										mysqli_query($link, $sql21) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
									}
								}
								else
								{	
									while($row23=mysqli_fetch_array($result23))
									{ 
										if($qty>0)
										{	
											$qty_tm=0;
											if($qty<$row23['bundle_quantity'])
											{
												$qty_tm=$row23['bundle_quantity']-$qty;
												$sql221="UPDATE $bai_pro3.mo_operation_quantites SET bundle_quantity='$qty_tm' WHERE ref_no='$tid' and op_code='$ops_id[$i]'";
												//echo $sql221.'<br>'; 
												mysqli_query($link, $sql221) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
												
												$sql212="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`, `bundle_quantity`, `good_quantity`, `rejected_quantity`, `op_code`, `op_desc`) VALUES ('".$date_rev."', '".$row23['mo_no']."', '$new_ref_id', '$qty', '0', '0', '$ops_id[$i]', '$ops_name[$i]')";
												mysqli_query($link, $sql212) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
												$qty=0;
												//echo $sql212."<br>";
											}
											else
											{
												$sql223="UPDATE $bai_pro3.mo_operation_quantites SET ref_no='$new_ref_id' WHERE ref_no='$tid' and op_code='$ops_id[$i]'";
												//echo $sql223.'<br>'; 
												mysqli_query($link, $sql223) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
												$qty=$qty-$row23['bundle_quantity'];
											}	
										}	
									}
								}	
							}	
							$sql2="UPDATE $bai_pro3.pac_stat_log SET carton_act_qty='$nqty' WHERE tid='$tid'";
							//echo $sql2.'<br>'; 
							mysqli_query($link, $sql2) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
					}                        
				}
			}
		}
	}
	echo '<h4><b>New Carton No : <a class="btn btn-warning">'.$maxcartonno.'</a></b></h4>';	
    echo "<script>sweetAlert('Success','Successfully Splitted your Carton.','success');</script>";
    echo "<script> 
                    setTimeout('Redirect()',1000); 
                    function Redirect() {  
                        location.href = '$url_s&schedule=$schedule&style=$style'; 
                    }
                </script>"; 
?> 
</div></div>
</body> 
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R') );  ?>
<div class="panel panel-primary">
	<div id="page_heading"><Sawing out Reporting Process</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-6">
					<form name="test" action="<?php echo '?r='.$_GET['r']; ?>" method="post">
						<div class="row">
							<div class="col-sm-6">
								Enter Schedule : <input type='text' id='int' name='schedule' size=8 class="form-control integer">
							</div>
							<div class="col-sm-6">										
								Carton Quantity : <input type='text' id='int' name='qty' value='120' size=8 class="form-control integer">
							</div>
							<div class="col-sm-3">	
								<input type="submit" value="Process" name="submit" id='sub' style='margin-top:22px;' class="btn btn-info" />
							</div>
						</div>	
					</form>
				</div>	
			</div>		
		</div>	
<?php
if(isset($_POST['submit']))
{
	
	$schedule=$_POST['schedule'];
	$qty=$_POST['qty'];
	
	$quer="SELECT * FROM $bai_pro3.packing_summary WHERE order_del_no='$schedule'";
	// echo $quer."<br>";
	$quer_result=mysqli_query($link,$quer) or exit("Sql Error1 $quer".mysql_error());
	$rowq=mysqli_fetch_array($quer_result);
	
	if(!$rowq){

	$sql="SELECT $bai_pro3.pac_stat_log_input_job.doc_no AS doc_no,$bai_pro3.pac_stat_log_input_job.input_job_no AS input_job_no,$bai_pro3.pac_stat_log_input_job.input_job_no_random AS input_job_no_random,$bai_pro3.pac_stat_log_input_job.old_size AS size_code,SUM($bai_pro3.pac_stat_log_input_job.carton_act_qty) AS tqty,$bai_pro3.bai_orders_db_confirm.order_style_no AS order_style_no,$bai_pro3.bai_orders_db_confirm.order_tid AS order_tid,$bai_pro3.bai_orders_db_confirm.order_del_no AS order_del_no,$bai_pro3.bai_orders_db_confirm.order_col_des AS order_col_des  FROM (($bai_pro3.pac_stat_log_input_job LEFT JOIN $bai_pro3.plandoc_stat_log ON(($bai_pro3.pac_stat_log_input_job.doc_no = $bai_pro3.plandoc_stat_log.doc_no))) LEFT JOIN $bai_pro3.bai_orders_db_confirm ON(($bai_pro3.bai_orders_db_confirm.order_tid = $bai_pro3.plandoc_stat_log.order_tid))) WHERE order_del_no='$schedule' GROUP BY input_job_no,size_code,order_col_des";
	// echo $sql."<br><br>";
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error2 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($sql_result))
	{
	$doc_no=$row['doc_no'];
	$random_job=$row['input_job_no_random'];
	$job_no=$row['input_job_no'];
	$size_code=$row['size_code'];
	
	$style=$row['order_style_no'];
	$schedule=$row['order_del_no'];
	$color=$row['order_col_des'];
	$otid=$row['order_tid'];
	
	$ss="SELECT input_module FROM $bai_pro3.plan_dashboard_input where input_job_no_random_ref='$random_job'";
	$ss_result=mysqli_query($link,$ss) or exit("Sql Error3 $ss".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rs=mysqli_fetch_array($ss_result);
	
	$ss1="SELECT ims_mod_no FROM $bai_pro3.ims_log WHERE input_job_rand_no_ref='$random_job'";
	$ss1_result=mysqli_query($link,$ss1) or exit("Sql Error4 $ss1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rs1=mysqli_fetch_array($ss1_result);
	
	$ss11="SELECT ims_mod_no FROM $bai_pro3.ims_log WHERE input_job_rand_no_ref='$random_job'";
	$ss1_result1=mysqli_query($link,$ss11) or exit("Sql Error4 $ss11".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rs11=mysqli_fetch_array($ss1_result1);
	
	if($rs){
	$module=$rs['input_module'];
	}else if(!$rs && $rs1){
	$module=$rs1['ims_mod_no'];
	}else if(!$rs1 && !$rs && $rs11){
	$module=$rs11['ims_mod_no'];
	}else if(!$rs && !$rs1 && !$rs11){
	$module='Not Processed';
	}
	$i=1;
	$tqty=$row['tqty'];
	$pac_count=$tqty/$qty;
	$pac_rest=$tqty%$qty;
	if($pac_rest==0){
	
	$pac_count=$tqty/$qty;
	
	}else{
	$pac_count=floor($tqty/$qty);
	}

	while($i<=$pac_count){
	
	// echo $row['doc_no'].' === '.$row['input_job_no'].' === '.$random_job.' === '.$otid.' === '.$row['size_code'].' === '.$qty.' ===  '.$style.' === '.$schedule.' === '.$color.'.<br><br>';
	$query ="INSERT into $bai_pro3.pac_stat_log(input_job_random,input_job_number,doc_no,order_tid,size_code,carton_act_qty,module,style,schedule,color,carton_no,carton_mode,container) VALUES ('$random_job','$job_no','$doc_no','$otid','$size_code','$qty','$module','$style','$schedule','$color',1,'P',1)";
	// echo $query."<br><br>";
	mysqli_query($link,$query) or exit("Sql Error5 $query".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$i++; 
	}
	if($pac_rest!=0){
	// echo $row['doc_no'].' === '.$row['input_job_no'].' === '.$random_job.' === '.$otid.' === '.$row['size_code'].' === '.$pac_rest.' ===  '.$style.' === '.$schedule.' === '.$color.'.<br><br>';
	$query1 ="INSERT into $bai_pro3.pac_stat_log(input_job_random,input_job_number,doc_no,order_tid,size_code,carton_act_qty,module,style,schedule,color,carton_no,carton_mode,container) VALUES ('$random_job','$job_no','$doc_no','$otid','$size_code','$pac_rest','$module','$style','$schedule','$color',1,'P',1)";
	// echo $query1."<br><br>";
	mysqli_query($link,$query1) or exit("Sql Error6 $query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	}
	
	
	
	
	}
	
	$doc_ref_update="update $bai_pro3.pac_stat_log set doc_no_ref=concat(doc_no,'-',tid) where schedule=".$schedule."";
	mysqli_query($link,$doc_ref_update) or exit("Sql Error7 $query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$url = getFullURL($_GET['r'],'sawing_out_list.php','N');
	//echo $url;
	echo '<script type="text/javascript">
			window.location = "'.$url.'&schedule='.$schedule.'"
		  </script>'; 
	// echo '<script type="text/javascript">window.location = "sawing_out_list.php&schedule='.$schedule.'"</script>'; 
	
	}
	else{
	echo '<script>swal("Schedule Already Processed","","warning")</script>';
	
	}
	}
	
	


?>
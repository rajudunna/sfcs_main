<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=11; IE=9; IE=8; IE=7; IE=6; IE=5; IE=EDGE" />
<link rel="stylesheet" href="cssjs/bootstrap.min.css">
<link rel="stylesheet" href="cssjs/select2.min.css">
<script type="text/javascript" src="cssjs/jquery.min.js"></script>
<script type="text/javascript" src="cssjs/select2.min.js"></script>
<script src="cssjs/bootstrap.min.js"></script>

<?php

$has_permission=haspermission($_GET['r']);
//generate_bundles('QCIFG001','426935','BLACK',1); 

	
		function generate_bundles($style,$schedule,$color,$cut_num){
			
		ini_set('max_execution_time', 500);
		
		 // include("dbconf.php");
		 include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
		 /*Check whether barcodes are already generations generated for this style,schedule,color and cut*/
		 $bundls_cnt_qry='select count(*) as cnt from $brandix_bts.bundle_creation_data where trim(style)="'.$style.'" and trim(schedule)="'.$schedule.'" and trim(color)="'.$color.'" and cut_number="'.$cut_num.'"';
		 // echo "Qry : ".$bundls_cnt_qry;exit;
		 $bundle_cnt_qry_res=mysqli_query($link,$bundls_cnt_qry);
		
		 $bundle_cnt_res=mysqli_fetch_object($bundle_cnt_qry_res);
		 
		if($bundle_cnt_res->cnt==0){
			/*Get the operations list for the given style and color*/
			/*Check whether operations are updated or not*/
			/*Below logic is used to generate the bundles which excludes dependent operations*/
			/*$sewing_orders_qry='SELECT GROUP_CONCAT(DISTINCT ops_dependency) AS operation_code FROM $brandix_bts.$brandix_bts.tbl_style_ops_master where barcode="Yes" and trim(style)="'.$style.'" and trim(color)="'.$color.'" and ops_dependency<>0 order by ops_sequence';
			$sewing_orders_res=mysqli_query($link,$sewing_orders_qry);
			if(mysqli_num_rows($sewing_orders_res)>0){
				while($ops_dependencies = mysqli_fetch_array($sewing_orders_res)){
					$ops_dependency=$ops_dependencies['operation_code'];
				}
			}else{
				echo "Sewing orders not found";die();
			}
			$operations_master_qry='select * from $brandix_bts.$brandix_bts.tbl_style_ops_master where barcode="Yes" and trim(style)="'.$style.'" and trim(color)="'.$color.'" and operation_code not in('.$ops_dependency.') order by ops_sequence';*/
			$operations_master_qry='select * from $brandix_bts.tbl_style_ops_master where barcode="Yes" and trim(style)="'.$style.'" and trim(color)="'.$color.'" order by ops_sequence,id';
			$operations_master_res=mysqli_query($link,$operations_master_qry);
			if(mysqli_num_rows($operations_master_res)>0){
				while($row = mysqli_fetch_array($operations_master_res)){
					$operation_code[]=$row['operation_code'];
					$operation_order[]=$row['ops_sequence'];
					$depend_operation[]=$row['ops_dependency'];
					$component[]=$row['component'];
					$sfcs_smv[]=$row['smv'];
					//echo $row['operation_code']."\r".$row['operation_order']."</br>";
					//$operations_master_qry="select * from $brandix_bts.$brandix_bts.tbl_style_ops_master where trim(style)='$style' and trim(color)='$color'";
				}
				/*query to get the ratios for the given style, schedule, color and cut number*/
			}else{
				// echo $operations_master_qry;
				// echo "</br>Sorry no operations found for the given style : $style and Color : $color";
			}
			$bundle_number_qry="select max(bundle_number) as bundle_number from $brandix_bts.bundle_creation_data";
			$bundle_number_result=mysqli_query($link,$bundle_number_qry);
			if(mysqli_num_rows($bundle_number_result)>0){
				while($row = mysqli_fetch_array($bundle_number_result)){
					$bundle_number=$row['bundle_number']+1;
				}
			}else{
				$bundle_number=1;
			}
			
			//$plandoc_stat_log_qry="select * from $bai_pro3.plandoc_stat_log where pcutno=$cut_num and order_tid=(select order_tid from $bai_pro3.bai_orders_db_confirm where trim(order_style_no)='$style' and trim(order_del_no)='$schedule' and trim(order_col_des)='$color')";
			// $plandoc_stat_log_qry="SELECT bai_orders_db_confirm.*,plandoc_stat_log.*,cat_stat_log.* FROM $bai_pro3.bai_orders_db_confirm LEFT JOIN $bai_pro3.plandoc_stat_log ON bai_orders_db_confirm.order_tid=plandoc_stat_log.order_tid
			// LEFT JOIN $bai_pro3.plandoc_stat_log ON cat_stat_log.order_tid=plandoc_stat_log.order_tid AND cat_stat_log.tid=plandoc_stat_log.cat_ref
			// WHERE trim(bai_orders_db_confirm.order_style_no)='$style' and trim(bai_orders_db_confirm.order_del_no)='$schedule' and trim(bai_orders_db_confirm.order_col_des)='$color' and plandoc_stat_log.acutno=$cut_num and cat_stat_log.category in ('Body','Front')";
			$plandoc_stat_log_qry="SELECT * FROM $bai_pro3.order_cat_doc_mix WHERE TRIM(order_style_no)='$style' AND TRIM(order_del_no)='$schedule' AND TRIM(order_col_des)='$color' and acutno=$cut_num and category in ($in_categories)";
			//echo $plandoc_stat_log_qry."<br>";
					
			$query = mysqli_query($link,$plandoc_stat_log_qry);
			if(mysqli_num_rows($query)>0){
				$sno=1;
				$queries='';
				$ops_sequence=$operation_order[$operation_counter];
				echo "<table class='table table-striped header-fixed'>";
				echo "<thead class='thead-inverse'><tr class='table-active'><th>S.NO</th><th>Style</th><th>Schedule</th><th>Color</th><th>Cut Number</th><th>Size</th><th>Quantity</th><th>Bundle Number</th>";
				echo "<th>Op Code</th><th> Sequence</th></tr></thead>";
				//$insert_query="";
				while($result = mysqli_fetch_array($query))
				{					
					//print_r($plies);
					//print_r($sizes_array);
					
				  for($size_counter=0;$size_counter<sizeof($sizes_array);$size_counter++){
					$size_code="a_$sizes_array[$size_counter]";					  
					$size_title="title_size_$sizes_array[$size_counter]";
					
					 // echo "a_$sizes_array[$size_counter]"."  ".$result[$size_code]."</br>";
						if($result[$size_code]>0){
							//get size code from sizes master
							$size_id_qry="select id from $brandix_bts.tbl_orders_size_ref where size_name='$sizes_array[$size_counter]'";
							$size_id_result= mysqli_query($link,$size_id_qry);
							$size_id_res=mysqli_fetch_object($size_id_result);
							$size_id=$size_id_res->id;
							if(sizeof($operation_code)>0){
								for($operation_counter=0;$operation_counter<sizeof($operation_code);$operation_counter++){
									//echo $operation_counter."</br>";
									if($sno==1){
											$ops_sequence=$operation_order[$operation_counter];
											$docket_number=$result[doc_no];
											$fab_cad_query="SELECT shade,SUM(plies) AS plies FROM $bai_rm_pj1.fabric_cad_allocation WHERE doc_no=$docket_number AND (plies<>'NULL' OR shade<>'NULL') GROUP BY shade";
											// echo $fab_cad_query."</br>";
											// die();
											$fab_cad_qry_result= mysqli_query($link,$fab_cad_query);
											if(count($fab_cad_qry_result)>0){
												while($fab_res= mysqli_fetch_array($fab_cad_qry_result)){
													$shade[]=$fab_res[shade];
													$shade1=$fab_res[shade];
													if($fab_res[plies]=='NULL'){
														$plie_height=0;
														
													}else{
														$plie_height=$fab_res[plies];
													}
													$plies[]=$plie_height;
												}
												//print_r($plies);
											}else{
												echo "Cut quantity not updated";
											}
										}
										/*
											Below commented code will be used to generate bundles based on sequence
											Here based on the sequence and operation code the below logic will generate individual barcode for each sequence
																			
										*/
									/*if($ops_sequence!=$operation_order[$operation_counter]){
										//echo "<tr><td>".$ops_sequence."!=".$operation_order[$operation_counter]."   ".$bundle_number_new."</td></tr>";
										$bundle_number=$bundle_number_new;
										
									}else{
										//echo "<tr><td>".$ops_sequence."==".$operation_order[$operation_counter]."   ".$bundle_number_new."</td></tr>";
										$bundle_number_new=$bundle_number;
									}*/
									/*
										Below logic will be used to generate the bundles based on sequence
										//$bundle_number_new=$bundle_number;
									*/
									$bundle_number_new=$bundle_number;
									if($result[$size_code]>0){
										for($ratio_count=0;$ratio_count<$result[$size_code];$ratio_count++){
											//echo $result[$size_code]."</br>";
											//get size query
											$sizequery = "select $size_title from $bai_pro3.bai_orders_db_confirm where order_style_no='$style' and order_del_no=$schedule and order_col_des='$color'";
											$size_qry_exe = mysqli_query($link,$sizequery);
											$size_title_value = mysqli_fetch_row($size_qry_exe);
											//$size_title_value=$result[$size_title];
											if(sizeof($shade)>0){
												for($shade_counter=0;$shade_counter<sizeof($shade);$shade_counter++){
													//$sno++;
													echo "<tr><td>".$sno++."</td><td>".$style."</td><td>".$schedule."</td><td>".$color."</td><td>".$cut_num."</td><td>".$result[$size_title]."</td><td>".$plies[$shade_counter]."</td><td>".$bundle_number_new."</td><td>".$operation_code[$operation_counter]."</td><td>".$operation_order[$operation_counter]."</td></tr>";
													$insert_query="INSERT INTO $brandix_bts.bundle_creation_data (style,SCHEDULE,color,size_id,size_title,cut_number,docket_number,shade,bundle_number,operation_id,operation_sequence,ops_dependency,original_qty,send_qty,sfcs_smv,sync_status,component) values ('$style','$schedule','$color',$size_id,'$size_title_value[0]',$cut_num,$result[doc_no],'$shade1',$bundle_number_new,$operation_code[$operation_counter],$operation_order[$operation_counter],$depend_operation[$operation_counter],$plies[$shade_counter],$plies[$shade_counter],$sfcs_smv[$operation_counter],'0','".$component[$operation_counter]."')";
													$queries.=$insert_query." Shade ".$shade_check.";</br>";
													mysqli_query($link,$insert_query);
													$bundle_number_new++;
												}
											}else{
												 echo "<div class='alert alert-danger'>Cut reporting shade not updated properly</div>";
												 //echo $fab_cad_query;
												die();
											}
											
											
										}
									}else{
										 echo "<div class='alert alert-danger'>Sizes concern</div>";
										die();
									}
								
									
									$ops_sequence=$operation_order[$operation_counter];
										
								}
								/*The below logic will be used to generate the new bundle number if new size will occur*/
								$bundle_number=$bundle_number_new;
							}else{
								echo "<div class='alert alert-danger'>Operations not found</div>";
								die();
							}
							
						}
					}
				}
				echo "</table>";
				//echo $queries;
				//update assigned_module for the embellishment barcodes
				$update_module_qry='UPDATE $brandix_bts.bundle_creation_data SET assigned_module="Emb" WHERE TRIM(style)="'.$style.'" AND TRIM(SCHEDULE)="'.$schedule.'"  AND TRIM(color)="'.$color.'" AND cut_number="'.$cut_num.'"  AND operation_id IN(SELECT operation_code FROM $brandix_bts.tbl_orders_ops_ref WHERE operation_type="Yes")';
				mysqli_query($link,$update_module_qry);
				$update_bundle_sewing="UPDATE $brandix_bts.bundle_creation_data SET is_sewing_order='Yes' WHERE TRIM(style)='".$style."' AND TRIM(SCHEDULE)='".$schedule."'  AND TRIM(color)='".$color."' AND cut_number='".$cut_num."'  AND operation_id IN(SELECT DISTINCT ops_dependency FROM $brandix_bts.tbl_style_ops_master WHERE style='".$style."' AND color='".$color."' AND ops_dependency<>'NULL')";
				mysqli_query($link,$update_bundle_sewing);
				//echo $update_module_qry;
			}else{
				 echo "<div class='alert alert-danger'>Cut quantity not updated</div>";
				
			} 
		 }else{
			 echo "<div class='alert alert-danger'>Bundles are already Generated.<strong>Bundles ".$bundle_cnt_res->cnt."</strong><a href='../sewing_orders/form.php'>   Click me</a></div>";
			 $bundles_query='select * from $brandix_bts.bundle_creation_data where trim(style)="'.$style.'" and trim(schedule)="'.$schedule.'" and trim(color)="'.$color.'" and cut_number="'.$cut_num.'" order by bundle_number,operation_sequence';
			$bundle_qry_res=mysqli_query($link,$bundles_query);
			//echo count($bundle_qry_res);
			if(count($bundle_qry_res)>0){
				echo "<div class='alert alert-success'>Style :<strong>".$style." </strong>Schedule : <strong>".$schedule." </strong>  Color :<strong>".$color." </strong></div>";
				$sno=1;
				echo "<table class='table table-striped header-fixed'>";
				echo "<thead class='thead-inverse'><tr class='table-active'><th>S.NO</th><th>Cut Number</th><th>Size</th><th>Operation Code</th><th>Bundle Number</th><th>Sequence</th><th>Component</th>";
				echo "<th>Bundle Qnty</th></thead></tr>";
				while($result = mysqli_fetch_array($bundle_qry_res)){
					echo "<tr><td>".$sno++."</td><td>".$result[cut_number]."</td><td>".$result[size_title]."</td><td>".$result[operation_id]."</td><td>".$result[bundle_number]."</td><td>".$result[operation_sequence]."</td><td>".$result[component]."</td><td>".$result[original_qty]."</td></tr>";
				}
				echo "</table>";
				
			 }
		 }
		
	}
	function delete_bundles($style,$schedule,$color,$cut_num)
	{
		include("dbconf.php");
		 /*Check whether barcodes are already generations generated for this style,schedule,color and cut*/
		 $bundls_cnt_qry='select count(*) as cnt from $brandix_bts.bundle_creation_data where trim(style)="'.$style.'" and trim(schedule)="'.$schedule.'" and trim(color)="'.$color.'" and cut_number="'.$cut_num.'"';
		 //echo $bundls_cnt_qry;
		 $bundle_cnt_qry_res=mysqli_query($link,$bundls_cnt_qry);
		 $bundle_cnt_res=mysqli_fetch_object($bundle_cnt_qry_res);
		 if($bundle_cnt_res->cnt>0){
			 $delete_query='delete from $brandix_bts.bundle_creation_data where trim(style)="'.$style.'" and trim(schedule)="'.$schedule.'" and trim(color)="'.$color.'" and cut_number="'.$cut_num.'"';
			 mysqli_query($link,$delete_query);
		 }else{
			echo "No Bundles to deleted";
			echo "</br><a href='../sewing_orders/form.php'>Click me</a>";
		 }
	}
	 function view_bundles($style,$schedule,$color,$cut_num){
		//echo 'hello';
		/* include("dbconf.php");
		 $bundles_query='select * from $brandix_bts.$brandix_bts.bundle_creation_data where trim(style)="'.$style.'" and trim(schedule)="'.$schedule.'" and trim(color)="'.$color.'" and cut_number="'.$cut_num.'"';
		$bundle_qry_res=mysqli_query($link,$bundles_query);
		if(count($bundle_qry_res)>0){
			$sno=1;
			echo "<table class='table table-striped header-fixed'>";
			echo "<thead class='thead-inverse'><tr class='table-active'><th>S.NO</th><th>Style</th><th>Schedule</th><th>Color</th><th>Cut Number</th><th>Size</th><th>No.Of Bundles</th><th>Bundle Number</th>";
			echo "<th>Operation Code</th></tr></thead>";
			while($result = mysqli_fetch_array($bundle_qry_res)){
				//echo "<tr><td>".$sno++."</td><td>".$result[style]."</td><td>".$result[schedule]."</td><td>".$result[color]."</td><td>".$result[cut_number]."</td><td>".$result[$size_title]."</td><td>".$result[$operation_id]."/".$result[$size_code]."</td><td>".$result[bundle_number]."</td><td>".$result[a_plies]."</td></tr>";
			}
			echo "</table>";
			
		 }
		echo 'test view'; */
		
	}

?>
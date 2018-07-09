<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<style type="text/css"> 
#div-1a { 
 position:absolute; 
 top:65px; 
 right:0; 
 width:auto; 
float:right; 
table { 
    float:left; 
    width:33%; 
} 
body{ 
	/* margin:15px; padding:15px; border:1px solid #666; */
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px;  padding:5px; background-color:#f4f4f4; solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; outset #f4f4f4; margin:2px; }
.mytable th{ background-color:#29759c; color:#FFF; padding:2px; solid #ccc; white-space: nowrap;}
td{ padding:2px; white-space: nowrap;}
</style> 

<body> 
<div class="panel panel-primary">
<div class="panel-heading">Sewing Job Generation</div>
<div class="panel-body">
<!--<div id="page_heading"><span style="float"><h3>Sewing Job Generation</h3></span><span style="float: right"><b></b>&nbsp;</span></div> -->
<?php 
	set_time_limit(30000000); 
	include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	$has_permission=haspermission($_GET['r']);
	$carton_id=$_GET["id"]; 
	$carton_method=$_GET["mode"];
	if($carton_method==1)
	{
		echo "<h2>Single Color & Single Size Carton Method</h2>";
	}
	else if($carton_method==2)
	{
		echo "<h2>Multi Color & Single Size  Carton Method</h2>";
	}
	else if($carton_method==3)
	{
		echo "<h2>Multi Color & Multi Size Carton Method</h2>";
	}
	if($carton_method==4)
	{
		echo "<h2>Single Color & Multi Size Carton Method</h2>";
	}
	echo "<table class='table table-striped table-bordered'>";
	echo "<thead><th>Docket Number</th><th>Color</th><th>Size</th><th>Size Title</th><th>Input Job Number</th><th>Rand No Number</th><th>Quantity</th></thead>";
	$sql12="SELECT split_qty,style_code,ref_order_num,GROUP_CONCAT(DISTINCT COLOR) AS cols FROM brandix_bts.tbl_carton_ref 
	LEFT JOIN brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id WHERE COMBO_NO>0 and tbl_carton_ref.id='".$carton_id."' GROUP BY COMBO_NO";
	//echo $sql12."<br>";
	$cols_tot_tmp=array();
	$result121=mysqli_query($link, $sql12) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row121=mysqli_fetch_array($result121))
	{
		$cols_tot_tmp[]=$row121['cols'];
		$style_id=$row121['style_code'];
		$schedule_id=$row121['ref_order_num'];
		$split_qty=$row121['split_qty'];
	}
	$cols_tot=array();	
	$split_qty=echo_title("$brandix_bts.tbl_carton_ref","split_qty","id",$carton_id,$link);
	$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link); 
	$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
	/*
	if($carton_method==1)
	{
		$input_job_no=1;
		for($kk=0;$kk<sizeof($cols_tot_tmp);$kk++)
		{
			$cols_tot=explode(",",$cols_tot_tmp[$kk]);
			for($ii=0;$ii<sizeof($cols_tot);$ii++)
			{			
				$sql1="SELECT * FROM $brandix_bts.tbl_carton_ref LEFT JOIN $brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id where tbl_carton_ref.id='".$carton_id."' and color='".$cols_tot[$ii]."'";
				$result1=mysqli_query($link, $sql1) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1=mysqli_fetch_array($result1))
				{
					$rand=$schedule.date("ymd").$input_job_no;
					$input_job_quantiy_tmp=0;
					$color_code=$row1['color'];
					$size_ref=$row1['ref_size_name'];
					$size_tit=$row1['size_title'];
					$carton_method=$row1['carton_method'];
					$garments_per_carton=$row1['garments_per_carton'];
					$destination=echo_title("$bai_pro3.bai_orders_db","UPPER(destination)","order_del_no=\"".$schedule."\" and order_col_des",$color_code,$link); 
					$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num > 0 and color='".$color_code."' and size='".$size_ref."' group BY cut_num order by cut_num*1"; 
					//echo $input_job_no."p----".$schedule."<br>";
					$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($row12=mysqli_fetch_array($result12)) 
					{ 
						$docket_number=$row12["docket_number"]; 
						$qty=$row12["quantity"]; 
						if($qty>0)
						{												
							do
							{	
								if(($garments_per_carton-$input_job_quantiy_tmp)<=$qty)
								{
									if($input_job_no<>'1')
									{	
										$input_job_no++;
									}
									$qty_new=$garments_per_carton-$input_job_quantiy_tmp;
									$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
									//mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
									echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."-A-".$garments_per_carton."--".$input_job_quantiy_tmp."</td><td>".$qty_new."</td></tr>";
									$qty=$qty-$qty_new;
									$rand=$schedule.date("ymd").$input_job_no;
									$input_job_quantiy_tmp=0;
								}
								else
								{
									$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
									//mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
									echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."-B-".$garments_per_carton."--".$input_job_quantiy_tmp."</td><td>".$qty."</td></tr>";
									$input_job_quantiy_tmp=+$qty;
									$qty=0;
								} 
							}while($qty>0);	
						}
						
					}	
				}					
			}
			//$input_job_no=0;
			$input_job_no= echo_title("$bai_pro3.packing_summary_input","max(input_job_no)+1","order_col_des='".implode(",",$cols_tot)."' and order_del_no",$schedule,$link);
			$rand=$schedule.date("ymd").$input_job_no;
			//Excess Pieces Execution
			$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =0 and color in ('".implode(",",$cols_tot)."') group BY cut_num order by cut_num*1"; 
			$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($row12=mysqli_fetch_array($result12)) 
			{ 
				$docket_number=$row12["docket_number"]; 
				$qty=$row12["quantity"]; 
				$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$row12["size_tit"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
				//mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
				echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_ref"]."</td><td>".$row12["size_tit"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
			}
			$input_job_no++;
			$rand=$schedule.date("ymd").$input_job_no;
			unset($cols_tot);
		}
		
	}
	else 
	*/
	if($carton_method==1 || $carton_method==2)
	{
		$status_check=1;
		//echo sizeof($cols_tot_tmp)."<br>";
		for($kk=0;$kk<sizeof($cols_tot_tmp);$kk++)
		{
			$cols_tot=explode(",",$cols_tot_tmp[$kk]);
			// echo sizeof($cols_tot)."<br>";
			// echo $cols_tot[0]."<br>";
			$sql1y="SELECT size_title FROM brandix_bts.tbl_carton_ref 
			LEFT JOIN brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id WHERE 
			tbl_carton_ref.id='".$carton_id."' and color in ('".implode("','",$cols_tot)."') GROUP BY size_title ORDER BY ref_size_name*1";
			//echo $sql12."<br>";
			$resulty=mysqli_query($link, $sql1y) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row1y=mysqli_fetch_array($resulty))
			{				
				//echo $row1y['size_title']."<br>";
				$input_job_no_tmp= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and order_del_no",$schedule,$link);
				//echo str_replace("','",",",implode(",",$cols_tot_tmp))."=====".implode("','",$cols_tot)."-----".$input_job_no_tmp."<br>";
				for($ii=0;$ii<sizeof($cols_tot);$ii++)
				{			
					if($status_check=='1')
					{
						$input_job_no=1;
					}
					else
					{
						$input_job_no=$input_job_no_tmp;
					}
					$rand=$schedule.date("ymd").$input_job_no;
					$sql1="SELECT * FROM $brandix_bts.tbl_carton_ref LEFT JOIN $brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id where tbl_carton_ref.id='".$carton_id."' and color='".$cols_tot[$ii]."' and size_title='".$row1y['size_title']."'";
					//echo $sql1."<br>";
					$result1=mysqli_query($link, $sql1) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row1=mysqli_fetch_array($result1))
					{
						$input_job_quantiy_tmp=0;
						$color_code=$row1['color'];
						$size_ref=$row1['ref_size_name'];
						$size_tit=$row1['size_title'];
						$carton_method=$row1['carton_method'];
						$garments_per_carton=$row1['garments_per_carton']*$row1['no_of_cartons'];
						$destination=echo_title("$bai_pro3.bai_orders_db","UPPER(destination)","order_del_no=\"".$schedule."\" and order_col_des",$color_code,$link); 
						$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref='".$carton_id."' AND mini_order_num > 0 and color='".$color_code."' and size='".$size_ref."' group BY cut_num order by cut_num*1"; 
						//echo $input_job_no."p----".$schedule."<br>";
						$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						while($row12=mysqli_fetch_array($result12)) 
						{ 
							$docket_number=$row12["docket_number"]; 
							$qty=$row12["quantity"]; 
							if($qty>0)
							{												
								do
								{	
									if(($garments_per_carton-$input_job_quantiy_tmp)<=$qty)
									{
										$qty_new=$garments_per_carton-$input_job_quantiy_tmp;
										
										if($split_qty>0)
										{	
											do
											{
												if($qty_new<$split_qty)
												{
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
													mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
													echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."-A-".$garments_per_carton."--".$input_job_quantiy_tmp."</td><td>".$qty_new."</td></tr>";
												}
												else
												{
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
													mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
													echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."-A-".$garments_per_carton."--".$input_job_quantiy_tmp."</td><td>".$$split_qty."</td></tr>";
													$qty_new=$qty_new-$split_qty;
												}
												
											}while($qty_new>0);
										}
										else
										{
											$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
											mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
											echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."-A-".$garments_per_carton."--".$input_job_quantiy_tmp."</td><td>".$qty_new."</td></tr>";
										}
										$input_job_no++;
										$rand=$schedule.date("ymd").$input_job_no;
										$qty=$qty-$qty_new;
										$input_job_quantiy_tmp=0;
									}
									else
									{
										if($split_qty>0)
										{	
											do
											{
												if($qty<$split_qty)
												{
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
													mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
													echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."-A-".$garments_per_carton."--".$input_job_quantiy_tmp."</td><td>".$qty."</td></tr>";
												}
												else
												{
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
													mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
													echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."-B-".$garments_per_carton."--".$input_job_quantiy_tmp."</td><td>".$split_qty."</td></tr>";
													$qty=$qty-$split_qty;
												}
												
											}while($qty>0);
										}
										else
										{
											$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
											mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
											echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."-B-".$garments_per_carton."--".$input_job_quantiy_tmp."</td><td>".$qty."</td></tr>";
										}
										$input_job_quantiy_tmp+=$qty;
										$qty=0;										
									} 
								}while($qty>0);	
							}
							
						}	
					}					
				}				
				$status_check=0;
			}			
			//$input_job_no=0;
			$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and order_del_no",$schedule,$link);
			$rand=$schedule.date("ymd").$input_job_no;
			//Excess Pieces Execution
			$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =0 and color in ('".implode("','",$cols_tot)."') group BY cut_num order by cut_num*1"; 
			$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($row12=mysqli_fetch_array($result12)) 
			{ 
				$docket_number=$row12["docket_number"]; 
				$qty=$row12["quantity"]; 
				$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing) values(\"".$docket_number."\",\"".$row12["size_tit"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",'2')";
				mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
				echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_ref"]."</td><td>".$row12["size_tit"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
			}
			unset($cols_tot);
		}
	}
	else if($carton_method==3 || $carton_method==4)
	{
		for($kk=0;$kk<sizeof($cols_tot_tmp);$kk++)
		{
			$cols_tot=explode(",",$cols_tot_tmp[$kk]);
			$input_job_no_tmp= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and order_del_no",$schedule,$link);
			$sql1232="SELECT color FROM brandix_bts.tbl_carton_ref 
			LEFT JOIN brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id WHERE 
			tbl_carton_ref.id='".$carton_id."' and color in ('".implode("','",$cols_tot)."') GROUP BY color ORDER BY color*1";
			//echo $sql12."<br>";
			$result12132=mysqli_query($link, $sql1232) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row12132=mysqli_fetch_array($result12132))
			{				
				$color_code=$row12132['color'];
				$sql1="SELECT * FROM $brandix_bts.tbl_carton_ref LEFT JOIN $brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id where tbl_carton_ref.id='".$carton_id."' and color='".$color_code."' GROUP BY size_title ORDER BY ref_size_name*1;";
				//echo $sql1."<br>";
				$result1=mysqli_query($link, $sql1) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1=mysqli_fetch_array($result1))
				{						
					if($kk==0)
					{
						$input_job_no=1;
					}
					else
					{
						$input_job_no=$input_job_no_tmp;
						//$input_job_no=201;
					}
					$rand=$schedule.date("ymd").$input_job_no;	
					$input_job_quantiy_tmp=0;
					$size_ref=$row1['ref_size_name'];
					$size_tit=$row1['size_title'];
					$carton_method=$row1['carton_method'];
					$garments_per_carton=$row1['garments_per_carton']*$row1['no_of_cartons'];
					$destination=echo_title("$bai_pro3.bai_orders_db","UPPER(destination)","order_del_no=\"".$schedule."\" and order_col_des",$color_code,$link); 
					$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num > 0 and color='".$color_code."' and size='".$size_ref."' group BY cut_num order by cut_num*1"; 
					//echo $input_job_no."p----".$schedule."<br>";
					$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($row12=mysqli_fetch_array($result12)) 
					{ 
						$docket_number=$row12["docket_number"]; 
						$qty=$row12["quantity"]; 
						if($qty>0)
						{												
							do
							{	
								if(($garments_per_carton-$input_job_quantiy_tmp)<=$qty)
								{
									$qty_new=$garments_per_carton-$input_job_quantiy_tmp;
									if($split_qty>0)
									{	
										do
										{
											if($qty_new<$split_qty)
											{
												$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
												mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
												echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."-ASP".$garments_per_carton."--".$input_job_quantiy_tmp."</td><td>".$qty_new."</td></tr>";
											}
											else
											{
												$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
												mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
												echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."-ASPP-".$garments_per_carton."--".$input_job_quantiy_tmp."</td><td>".$$split_qty."</td></tr>";
												$qty_new=$qty_new-$split_qty;
											}
											
										}while($qty_new>0);
									}
									else
									{
										$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
										mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
										echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."-A-".$garments_per_carton."--".$input_job_quantiy_tmp."</td><td>".$qty_new."</td></tr>";
									}
									$input_job_no++;
									$rand=$schedule.date("ymd").$input_job_no;
									$qty=$qty-$qty_new;										
									$input_job_quantiy_tmp=0;
								}
								else
								{
									if($split_qty>0)
									{	
										do
										{
											if($qty<$split_qty)
											{
												$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
												mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
												echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."-BSP-".$garments_per_carton."--".$input_job_quantiy_tmp."</td><td>".$qty."</td></tr>";
											}
											else
											{
												$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
												mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
												echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."-BSPP-".$garments_per_carton."--".$input_job_quantiy_tmp."</td><td>".$split_qty."</td></tr>";
												$qty=$qty-$split_qty;
											}
											
										}while($qty>0);
									}
									else
									{
										$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
										mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
										echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."-B-".$garments_per_carton."--".$input_job_quantiy_tmp."</td><td>".$qty."</td></tr>";
									}
									$input_job_quantiy_tmp+=$qty;
									$qty=0;
								} 
							}while($qty>0);	
						}
						
					}	
				}			
			}
			$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and order_del_no",$schedule,$link);
			$rand=$schedule.date("ymd").$input_job_no;
			//Excess Pieces Execution
			$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =0 and color in ('".implode("','",$cols_tot)."') group BY cut_num order by cut_num*1"; 
			$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($row12=mysqli_fetch_array($result12)) 
			{ 
				$docket_number=$row12["docket_number"]; 
				$qty=$row12["quantity"]; 
				$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing) values(\"".$docket_number."\",\"".$row12["size_tit"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",'2')";
				mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
				echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_ref"]."</td><td>".$row12["size_tit"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
			}
			unset($cols_tot);
		}
	}
	

// echo "<script>sweetAlert('Data Saved Successfully','','success')</script>";
		// echo "<script>
			// setTimeout(redirect(),5000);
			// function redirect(){
		        // location.href = '".$btn_url."&style=$style_ori&schedule=$schedule_ori';
			// }</script>";
?> 
</div></div>
</body>
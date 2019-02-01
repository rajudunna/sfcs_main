<?php

	//Ticket #941086 / Date : 2014-03-21 / Due to color changing from yellow to green due to removing the job from fabric_priorities

	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'functions.php',1,'R')); 	
	$userName = getrbac_user()['uname'];
	$list=$_POST['listOfItems'];
	//echo $list;
	$list_db=array();
	$list_db=explode(";",$list);
	
	$x=1;
	
	for($i=0;$i<sizeof($list_db);$i++)
	{
		$items=array();
		$items=explode("|",$list_db[$i]);
		//module-doc_no
		
		if($items[0]=="allItems")
		{
			$sql312="select doc_no FROM bai_pro3.plandoc_stat_log WHERE org_doc_no=".$items[1]."";
			// echo "<br>4=".$sql3."<br>";
			$sql_result312=mysqli_query($link,$sql312) or exit("Sql Error3".mysql_error());
			if(mysqli_num_rows($sql_result312)>0)
			{	
				while($sql_row312=mysqli_fetch_array($sql_result312))
				{
					$sql34="DELETE from $bai_pro3.embellishment_plan_dashboard where doc_no=".$sql_row312['doc_no'];
					mysqli_query($link,$sql34) or exit("Sql Error6".mysqli_error());
				}
			}
			else
			{
				$sql34="DELETE from $bai_pro3.embellishment_plan_dashboard where doc_no=".$items[1];
				mysqli_query($link,$sql34) or exit("Sql Error6".mysqli_error());
			}			
			$sql1="DELETE from $bai_pro3.cutting_table_plan where doc_no=".$items[1];
			// echo "<br>1=".$sql1."<br>";
			mysqli_query($link,$sql1) or exit("Sql Error6".mysqli_error());
			
		}
		else
		{
			$verify_parent_query = "SELECT doc_no from $bai_pro3.plandoc_stat_log where org_doc_no = ".$items[1]."";
			if(mysqli_num_rows(mysqli_query($link,$verify_parent_query)) > 0){
				$sql1="select order_style_no as style,order_col_des as color 
					from $bai_pro3.plan_doc_summ where org_doc_no='".$items[1]."'";
			}else{
				$sql1="select order_style_no as style,order_col_des as color 
					from $bai_pro3.plan_doc_summ where doc_no='".$items[1]."'";
			}
			$sql_result1=mysqli_query($link,$sql1) or exit("Sql Error11".mysql_error());
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$style=$sql_row1['style'];
				$color=$sql_row1['color'];
			}
			$doc_qty=0;
			$sql3="select (p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies as qty from $bai_pro3.plandoc_stat_log where doc_no='".$items[1]."'";
			$sql_result3=mysqli_query($link,$sql3) or exit("Sql Error33".mysql_error());
			while($sql_row3=mysqli_fetch_array($sql_result3))
			{
				$doc_qty=$sql_row3['qty'];
			}

			$sql2="select operation_code,operation_order FROM brandix_bts.tbl_style_ops_master WHERE style='".$style."' AND color='".$color."' AND operation_code IN (SELECT operation_code FROM brandix_bts.tbl_orders_ops_ref WHERE category IN ('Send PF'))";
			// echo $sql2;
			$sql_result2=mysqli_query($link,$sql2) or exit("Sql Error2".mysql_error());
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$send_operation=$sql_row2["operation_code"];
				$operation_order=$sql_row2["operation_order"];
				// echo $send_operation."-".$operation_order."<br>";
				$sql3="select operation_code FROM brandix_bts.tbl_style_ops_master WHERE style='".$style."' AND color='".$color."' AND operation_order> '".$operation_order."' ORDER BY operation_order*1 LIMIT 1";
				// echo "<br>4=".$sql3."<br>";
				$sql_result3=mysqli_query($link,$sql3) or exit("Sql Error3".mysql_error());
				while($sql_row3=mysqli_fetch_array($sql_result3))
				{
					$receive_operation=$sql_row3["operation_code"];
					// echo $receive_operation."<br>";
				}
				$doc_nos=array();
				$sql31="select doc_no FROM bai_pro3.plandoc_stat_log WHERE org_doc_no=".$items[1]."";
				// echo "<br>4=".$sql3."<br>";
				$sql_result31=mysqli_query($link,$sql31) or exit("Sql Error3".mysql_error());
				if(mysqli_num_rows($sql_result31)>0)
				{	
					while($sql_row31=mysqli_fetch_array($sql_result31))
					{
						$doc_nos[]=$sql_row31["doc_no"];
					}
				}
				else
				{
					$doc_nos[]=$items[1];
				}
				for($ii=0;$ii<sizeof($doc_nos);$ii++)
				{
					$sql="insert ignore into $bai_pro3.embellishment_plan_dashboard (doc_no,send_op_code,receive_op_code) values ('".$doc_nos[$ii]."','".$send_operation."','".$receive_operation."')";
					// echo "<br>2=".$sql."<br>";
					mysqli_query($link,$sql) or exit("Sql Error8".mysqli_error());

					if(mysqli_insert_id($link)>0)
					{
						$sql="update $bai_pro3.embellishment_plan_dashboard set priority=$x, module=".$items[0].", log_time=\"".date("Y-m-d H:i:s")."\",orginal_qty='".$doc_qty."' where doc_no='".$doc_nos[$ii]."' and send_op_code='".$send_operation."' and receive_op_code='".$receive_operation."'";
						// echo "<br>2=".$sql."<br>";
						mysqli_query($link,$sql) or exit("Sql Error9".mysqli_error());
					}
					else
					{
						$sql="update $bai_pro3.embellishment_plan_dashboard set priority=$x, module=".$items[0].",orginal_qty='".$doc_qty."' where doc_no='".$doc_nos[$ii]."'  and send_op_code='".$send_operation."' and receive_op_code='".$receive_operation."'";
						// echo "<br>3=".$sql."<br>";
						mysqli_query($link,$sql) or exit("Sql Error10".mysqli_error());
					}
				}
				unset($doc_nos);
				$sql12="select * from $bai_pro3.cutting_table_plan where doc_no='$items[1]'";
				$resultr112=mysqli_query($link, $sql12) or exit("Sql Error5 == ".$sql12.' == '.mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($resultr112)==0)
				{
					$sql_map_table="select * from $bai_pro3.tbl_emb_table where emb_table_id=".$items[0]." and emb_table_status='active'";
					$sql_map_table_res=mysqli_query($link, $sql_map_table) or exit("Sql error sql_map_table".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_num_rows($sql_map_table_res)>0)
					{
							while($sql_map_table_res_row=mysqli_fetch_array($sql_map_table_res))
							{
								$mapped_cut_table=$sql_map_table_res_row["cut_table_name"];
							}
						
							if($mapped_cut_table != NULL)
							{
								$sql12="select * from $bai_pro3.tbl_cutting_table where tbl_name='$mapped_cut_table'";
								$resultr112=mysqli_query($link, $sql12) or exit("Sql Error5 == ".$sql12.' == '.mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row12=mysqli_fetch_array($resultr112))
								{
									$tbl_id=$sql_row12["tbl_id"];
								}
								$insert_log_query="INSERT INTO $bai_pro3.cutting_table_plan (doc_no,priority,dashboard_ref,cutting_tbl_id,doc_no_ref,username, log_time) VALUES('".$items[1]."', '".$x."','EMB','".$tbl_id."',  '".$items[1]."','".$userName."', NOW())";
								// echo $insert_log_query."<br>";
								mysqli_query($link, $insert_log_query) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
					}
				}				
				$x++;
			}		
			
		}
	}
		
	$url1 = getFullURLLevel($_GET['r'],'dashboards/controllers/EMS_Dashboard/embellishment_dashboard_send_operation.php',3,'N');
		
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url1\"; }</script>";

?>


<?php
$schedules_to_update=array();

$schedules_to_update=array_diff($sch_to_process,$schedule_db);

if(sizeof($schedules_to_update)>0){

$sql="select order_tid as ssc_code_new, order_del_no as schedule_no, order_style_no as style, order_col_des as color from $bai_pro3.bai_orders_db where order_del_no in (".implode(",",$schedules_to_update).")";

	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		//$ssc_code=substr($sql_row['ssc_code'],0,-9);
		$ssc_code=$sql_row['ssc_code_new'];
		$schedule=$sql_row['schedule_no'];
		$style=$sql_row['style'];
		$color=$sql_row['color'];
		
		//LOG
		fwrite($fh1, ",".$sql_row['schedule_no']);
		
		//New to get 1% extra order qty 
		$sql1="select (order_s_xs+order_s_s+order_s_m+order_s_l+order_s_xl+order_s_xxl+order_s_xxxl+order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50) as order_qty from $bai_pro3.bai_orders_db_confirm where order_tid=\"$ssc_code\"";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result1)>0)
		{
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$order=$sql_row1['order_qty'];
			}
		}
		//New to get 1% extra order qty 
				
		//$sql1="select doc_no from plandoc_stat_log where order_tid=\"$ssc_code\"";
		$sql1="select doc_no from $bai_pro3.plandoc_stat_log_cat_log_ref where order_tid=\"$ssc_code\"";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$count_check=mysqli_num_rows($sql_result1);
		if($count_check>0)
		{

		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$arr[]=$sql_row1['doc_no'];
		}
		$search_string=implode(",",$arr);
		unset($arr);
		
		$qty_temp=0;

		//echo date("H:i:s");	
		$sql2="select bac_sec, coalesce(sum(bac_Qty),0) as \"qty\" from $bai_pro.bai_log where ims_doc_no in ($search_string)  and bac_sec<>0 group by bac_sec";
		//echo $sql2."<br/>";
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$bac_sec=$sql_row2['bac_sec'];
			$qty=$sql_row2['qty'];
			$qty_temp+=$sql_row2['qty'];

		}
		
		$cut_total=0;
		$input_total=0;

		//SPEED - Online Status updates
		//echo "-".date("H:i:s");
		$sqlx1="select SUM(IF(act_cut_status=\"DONE\",doc_total,0)) AS \"cut_total\", SUM(IF(act_cut_issue_status=\"DONE\",doc_total,0)) AS \"input_total\" from $bai_pro3.plandoc_stat_log_cat_log_ref where order_tid=\"$ssc_code\"";
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$cut_total=$sql_rowx1['cut_total'];
			$input_total=$sql_rowx1['input_total'];
		}
		
		//Recut
		
		$sqlx1="select SUM(IF(act_cut_status=\"DONE\",actual_cut_qty,0)) AS \"cut_total\" from $bai_pro3.recut_v2_summary where order_tid=\"$ssc_code\"";
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$cut_total=$cut_total+$sql_rowx1['cut_total'];
		}
		
		//new for input to consider only given to module
		$input_total=0;
		$counter_check=0;
		$sqlx1="select coalesce(SUM(ims_qty),0) AS \"ims_qty\" from $bai_pro3.ims_log where ims_style=\"$style\" and ims_schedule=\"$schedule\" and ims_color=\"$color\" and ims_mod_no>0";
		//echo $sql1."<br/>";
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
		$counter_check+=mysqli_num_rows($sql_resultx1);
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$input_total+=$sql_rowx1['ims_qty'];
		}
		
		$sqlx1="select coalesce(SUM(ims_qty),0) AS \"ims_qty\" from $bai_pro3.ims_log_backup where ims_style=\"$style\" and ims_schedule=\"$schedule\" and ims_color=\"$color\" and ims_mod_no>0";
		//echo $sql1."<br/>";
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
		$counter_check+=mysqli_num_rows($sql_resultx1);
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$input_total+=$sql_rowx1['ims_qty'];
		}
		//new for input to consider only given to module
		
		$fcamca=0;
		$fgqty=0;
		$internal_audited=0;
		$pendingcarts=0;
		
		//echo "-".date("H:i:s");
		$sqlx1="select fca_app,app,scanned from $bai_pro3.disp_mix_temp where order_del_no=$schedule";
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
		// echo $sqlx1."<br>";

		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$fcamca=$sql_rowx1['app'];
			$fgqty=$sql_rowx1['scanned'];
			$internal_audited=$sql_rowx1['fca_app'];	
		}
		
		//Exception to check M&S
		// if(substr($style,0,1)=="M")
		// {
		// 	//$sqlx1="select coalesce(sum(carton_act_qty),0) as scanned from $packing_summary where doc_no in ($search_string) and status=\"DONE\"";
		// 	$sqlx1="select coalesce(sum(carton_act_qty),0) as scanned from $bai_pro3.packing_summary where trim(BOTH from order_del_no)=\"".trim($schedule)."\" and trim(BOTH from order_col_des)=\"".trim($color)."\" and status=\"DONE\"";
		// 	echo "test:".$sqlx1."<br/>";
		// 	$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
		// 	while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		// 	{
		// 		$fgqty=$sql_rowx1['scanned'];
		// 	}
		// }
		
		//echo "-".date("H:i:s");
		$sqlx1="select sum(if(status is null and disp_carton_no=1,1,0)) as \"pendingcarts\" from $bai_pro3.packing_summary where order_del_no=$schedule and container=1";
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
		// echo $sqlx1."<br>";

		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$pendingcarts=$sql_rowx1['pendingcarts'];		
		}
		
		//echo "-".date("H:i:s")."<br/";
		$sqlx1="select distinct container, sum(if(status is null and disp_carton_no=1,1,0)) as \"pendingcarts\" from $bai_pro3.packing_summary where order_del_no=$schedule and container>1";
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error15".mysqli_error($GLOBALS["___mysqli_ston"]));
		echo $sqlx1."<br>";

		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$pendingcarts+=$sql_rowx1['pendingcarts'];		
		}
		
				
		//SPEED - Online Status updates
		
		// echo $schedule."-".$status."-";
		
		$status=6; //RM
		if($cut_total==0)
		{
			$status=6; //RM
		}
		else
		{
			if($cut_total>0 and $input_total==0)
			{
				$status=5; //Cutting
			}
			else
			{
				if($input_total>0)
				{
					$status=4; //Sewing
				}
			}
		}
		//Exception to check M&S
		// if(substr($style,0,1)=="M")
		// {
		// 	if($qty_temp>=$fgqty and $qty_temp>0 and $fgqty>=$order) //due to excess percentage of shipment over order qty
		// 	{
		// 		$status=2; //FG
		// 		if($internal_audited>=$fgqty)
		// 		{
		// 			$status=1;
		// 		}
		// 	} 
		// 	if($qty_temp>=$order and $qty_temp>0 and $fgqty<$order)
		// 	{
		// 		$status=3; //packing
		// 	}
		// }
		// else
		// {
			if($qty_temp>=$fgqty and $qty_temp>0 and $fgqty>=$order) //due to excess percentage of shipment over order qty
			{
				$status=2; //FG
				if($internal_audited==$fgqty)
				{
					$status=1;
				}
			} 
			if($qty_temp>=$order and $qty_temp>0 and $fgqty<$order)
			{
				$status=3; //packing
			}
		// }
		
		//Exception to check M&S
		
		/*
		Earlier Version before M&S issue
		if($qty_temp>=$fgqty and $qty_temp>0 and $fgqty>=$order) //due to excess percentage of shipment over order qty
		{
			$status=2; //FG
			if($internal_audited==$fgqty)
			{
				$status=1;
			}
		} 
		if($qty_temp>=$order and $qty_temp>0 and $fgqty<$order)
		{
			$status=3; //packing
		}
		*/
		
		
		//to update dispatch status (as per internal system)
		$sqlx1="select COALESCE(sum(shipped),0) as \"shipped\" from $bai_pro3.bai_ship_cts_ref where ship_style=\"$style\" and ship_schedule=\"$schedule\"";
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
		// echo $sqlx1."<br>";
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$shipped=$sql_rowx1['shipped'];		
		}
		
		if($shipped>=$order and $status==1)
		{
			$status=-1;
		}
		
		echo $order."-".$cut_total."-".$input_total."-".$qty_temp."-".$fgqty."-".$internal_audited."-".$status."<br/>";
		
	/*	$status=6;
		if($fgqty>=$order and $internal_audited==$order)
		{
			$status=1; //FCA Completed
		}
		else
		{
			if($fgqty>0 and $fgqty>=$order)
			{
				$status=2; //FG Completed
			}
			else
			{
				if($qty>=$order)
				{
					$status=3; //Sewing Completed
				}
				else
				{
					if($qty>0)
					{
						$status=4; //Not Yet done Sewing
					}
					else
					{
						if($cut_total>0)
						{
							$status=5;//Not Yet done cutting
						}
						else
						{
							$status=6;//Not Yet done rm
						}
					}
				}
			}
		}
		*/
		$query_add="";
		if($counter_check>0)
		{
			$query_add=", act_in=$input_total";
		}
		
		
		//TO Update Orders_db
		$sql31="update $table_ref2 set act_cut=$cut_total".$query_add.", act_fca=$internal_audited, act_mca=$fcamca, act_fg=$fgqty, act_ship=$shipped, cart_pending=$pendingcarts, priority=$status, output=$qty_temp where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
		//echo $sql31."<br/>-C";
		mysqli_query($link, $sql31) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql3="update $table_ref3 set act_cut=$cut_total".$query_add.", act_fca=$internal_audited, act_mca=$fcamca, act_fg=$fgqty, act_ship=$shipped, cart_pending=$pendingcarts, priority=$status, output=$qty_temp where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
		// echo $sql3."<br/>-C";
		mysqli_query($link, $sql3) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
		//To Update Orders_db
		
		}
		else
		{
			//TO Update Orders_db
			$sql3="update $table_ref2 set priority=6 where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
			// echo $sql3."<br/>-D";
			mysqli_query($link, $sql3) or exit("Sql Error19".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql3="update $table_ref3 set priority=6 where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
			// echo $sql3."<br/>-D";
			mysqli_query($link, $sql3) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
			//To Update Orders_db
		}
			
	}
	
}
//echo date("H:i:s");
//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"report.php\"; }</script>";

//To Write File
	$myFile = "time_stamp.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = $write;
	fwrite($fh, $stringData);
	if(fclose($fh)) 
	{
		//fclose($fh);
	}
	if(fclose($fh1)) 
	{
		//fclose($fh1);
	}
	//To Write File
	echo date("Y-m-d H:i:s");

	
?>

	
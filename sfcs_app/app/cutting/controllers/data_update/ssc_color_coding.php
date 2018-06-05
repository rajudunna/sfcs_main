<?php
include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
set_time_limit(6000000);
?>

<html>
<head>
</head>
<body>

<?php
	$sql1="select distinct order_style_no from $bai_pro3.bai_orders_db where color_code=0";
	// echo $sql1."<br>";
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$style_no=$sql_row1['order_style_no'];

		$sql2="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style_no\" and color_code=0";
		// echo $sql2."<br/>";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$sch_no=$sql_row2['order_del_no'];
			$sql32="select * from $bai_pro3.bai_orders_db where order_style_no=\"$style_no\" and order_del_no=\"$sch_no\" and color_code=0";
	
			// echo $sql32."<br/>";
			mysqli_query($link, $sql32) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result32=mysqli_query($link, $sql32) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row32=mysqli_fetch_array($sql_result32))
			{
			
				$maxcolor=0;
				$sql3="select max(color_code) as maxcolor from $bai_pro3.bai_orders_db where order_style_no=\"$style_no\" and order_del_no=\"$sch_no\"";
				//echo $sql3."<br/>";
				mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row3=mysqli_fetch_array($sql_result3))
				{
					$maxcolor=$sql_row3['maxcolor'];
				}
				
				if($maxcolor>0)
				{
					$startcolor=$maxcolor+1;	
				}
				else
				{
					$startcolor=65;
				}
				
				$order_tid=$sql_row32['order_tid'];
				//echo $order_tid;
				$sql33="update $bai_pro3.bai_orders_db set color_code=$startcolor where order_tid=\"$order_tid\"";
				// echo $sql33."<br/>";
				mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$startcolor=$startcolor+1;
			}	
		}				
	}
				
	$sql3="insert into $bai_pro3.db_update_log (date, operation) values (\"".date("Y-m-d")."\",\"COLOR1\")";
	$res=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($res)
	{
		// echo "<div class='alert alert-info alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
		// 		<strong>Inserted Successfully</strong></div>";
		echo "<h2>Data Integrated Successfully<h2>";
	}
			
	$sql33="select schedule,op_desc from $bai_pro3.bai_emb_db where mo_type=\"MO\"";
	$sql33="SELECT MAX(emb_tid), schedule,op_desc FROM $bai_pro3.bai_emb_db WHERE mo_type='MO' GROUP BY schedule"; 

	$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row33=mysqli_fetch_array($sql_result33))
	{
		$schedule=$sql_row33['schedule'];
		$op_desc=$sql_row33['op_desc'];
		if(strpos($op_desc," GF"))
		{
			$sql3="update $bai_pro3.bai_orders_db set order_embl_e=1,order_embl_f=1,order_embl_a=0,order_embl_b=0,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0 where order_del_no=\"$schedule\"";
			mysqli_query($link, $sql3) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql31="update $bai_pro3.bai_orders_db_confirm set order_embl_e=1,order_embl_f=1,order_embl_a=0,order_embl_b=0,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0 where order_del_no=\"$schedule\"";
			mysqli_query($link, $sql31) or exit("Sql Error122".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		else
		{
			if(strpos($op_desc," PF"))
			{
				$sql3="update $bai_pro3.$bai_pro3.bai_orders_db set order_embl_a=1,order_embl_b=1,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0,order_embl_e=0,order_embl_f=0 where order_del_no=\"$schedule\"";
				mysqli_query($link, $sql3) or exit("Sql Error23".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql31="update $bai_pro3.bai_orders_db_confirm set order_embl_a=1,order_embl_b=1,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0,order_embl_e=0,order_embl_f=0 where order_del_no=\"$schedule\"";
				mysqli_query($link, $sql31) or exit("Sql Error24".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else
			{
				$sql3="update $bai_pro3.bai_orders_db set order_embl_a=0,order_embl_b=0,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0,order_embl_e=0,order_embl_f=0 where order_del_no=\"$schedule\"";
				mysqli_query($link, $sql3) or exit("Sql Error25".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql31="update $bai_pro3.bai_orders_db_confirm set order_embl_a=0,order_embl_b=0,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0,order_embl_e=0,order_embl_f=0 where order_del_no=\"$schedule\"";
				mysqli_query($link, $sql31) or exit("Sql Error26".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}	
	}
	
	$myFile = "m3_process_ses_track.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php $"."log_time=".(int)date("YmdH")."; ?>";
	fwrite($fh, $stringData);
	fclose($fh);

	echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";		
?>
</body>
</html>


	
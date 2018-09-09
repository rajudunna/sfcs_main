<?php

	//Ticket #941086 / Date : 2014-03-21 / Due to color changing from yellow to green due to removing the job from fabric_priorities

	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'functions.php',1,'R')); 	
	
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
			$sql="DELETE from $bai_pro3.embellishment_plan_dashboard where doc_no=".$items[1];
			echo "<br>1=".$sql."<br>";
			mysqli_query($link,$sql) or exit("Sql Error6".mysqli_error());			
		}
		else
		{
			
			$sql1="select order_style_no as style,order_col_des as color,total as qty from $bai_pro3.plan_dash_doc_summ_embl where doc_no='".$items[1]."'";
			$sql_result1=mysqli_query($link,$sql1) or exit("Sql Error11".mysql_error());
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$style=$sql_row1['style'];
				$color=$sql_row1['color'];
				$doc_qty=$sql_row1['qty'];
			}

			$sql2="select operation_code,operation_order FROM brandix_bts.tbl_style_ops_master WHERE style='".$style."' AND color='".$color."' AND operation_code IN (SELECT operation_code FROM brandix_bts.tbl_orders_ops_ref WHERE category IN ('Send PF'))";
			$sql_result2=mysqli_query($link,$sql2) or exit("Sql Error2".mysql_error());
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$send_operation=$sql_row2["operation_code"];
				$operation_order=$sql_row2["operation_order"];
				// echo $send_operation."-".$operation_order."<br>";
				$sql3="select operation_code FROM brandix_bts.tbl_style_ops_master WHERE style='".$style."' AND color='".$color."' AND operation_order> '".$operation_order."' LIMIT 1";
				echo "<br>4=".$sql3."<br>";
				$sql_result3=mysqli_query($link,$sql3) or exit("Sql Error3".mysql_error());
				while($sql_row3=mysqli_fetch_array($sql_result3))
				{
					$receive_operation=$sql_row3["operation_code"];
					// echo $receive_operation."<br>";
				}
				
				$sql="insert ignore into $bai_pro3.embellishment_plan_dashboard (doc_no,send_op_code,receive_op_code) values ('".$items[1]."','".$send_operation."','".$receive_operation."')";
				echo "<br>2=".$sql."<br>";
				mysqli_query($link,$sql) or exit("Sql Error8".mysqli_error());

				if(mysqli_insert_id($link)>0)
				{
					$sql="update $bai_pro3.embellishment_plan_dashboard set priority=$x, module=".$items[0].", log_time=\"".date("Y-m-d H:i:s")."\",orginal_qty='".$doc_qty."' where doc_no='".$items[1]."' and send_op_code='".$send_operation."' and receive_op_code='".$receive_operation."'";
					echo "<br>2=".$sql."<br>";
					mysqli_query($link,$sql) or exit("Sql Error9".mysqli_error());
				}
				else
				{
					$sql="update $bai_pro3.embellishment_plan_dashboard set priority=$x, module=".$items[0].",orginal_qty='".$doc_qty."' where doc_no='".$items[1]."'  and send_op_code='".$send_operation."' and receive_op_code='".$receive_operation."'";
					echo "<br>3=".$sql."<br>";
					mysqli_query($link,$sql) or exit("Sql Error10".mysqli_error());
				}			
				$x++;
			}		
			
		}
	}
		
	$url1 = getFullURLLevel($_GET['r'],'dashboards/controllers/EMS_Dashboard/embellishment_dashboard_send_operation.php',3,'N');
		
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url1\"; }</script>";

?>
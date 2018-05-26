<?php
		include("dbconf.php");
		echo $host;
		if(isset($_POST['docket_no'])){
			include('dbconf.php');
			echo $host;
			$docket_num=$_POST['docket_no'];
			$plandocstat_qry="SELECT TRIM(order_style_no) AS order_style_no,TRIM(order_del_no) AS order_del_no,TRIM(order_col_des) as order_col_des,TRIM(plandoc_stat_log.pcutno) AS pcutno FROM bai_pro3.bai_orders_db_confirm LEFT JOIN bai_pro3.plandoc_stat_log ON bai_orders_db_confirm.order_tid=plandoc_stat_log.order_tid WHERE TRIM(plandoc_stat_log.doc_no)='$docket_num'";
			
			echo "Qry :".$plandocstat_qry."</br>";
			//echo "Plandoc qry : ".$plandocstat_qry."</br>";
			$plandocstat_result=mysqli_query($link,$plandocstat_qry);
			
			echo "Docket rows :".mysqli_num_rows($plandocstat_result)."</br>";
			
			if(mysqli_num_rows($schedule_result)>0){
					while($styles = mysqli_fetch_array($plandocstat_result)) {
						$order_del_no=$styles['order_del_no'];
						echo $order_del_no;
					}
			}else{
				echo "Dockect Number : ".$docket_num." NOT FOUND";
			}
		}
	?>	
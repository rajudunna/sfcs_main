
<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    if(isset($_POST["submit"])) 
    { 
       
        $cut1 = $_POST['cut1'];
		  if($cut1 != ''){
            $excess_cut = $_POST['cut1'];
            $order_joins = $_POST['order_joins_no'];
            $schedule = $_POST['schedule'];
            $style = $_POST['style'];
            $color = $_POST['color'];
            $user = $_POST['user'];
			if($order_joins<>0)
			{
				$order_del_no[]=$_POST['schedule'];
				$order_col_des[]=$_POST['color'];
				$query_check = "select * from $bai_pro3.bai_orders_db_confirm where order_joins='J".$schedule."'";
				$query_result_check = mysqli_query($link,$query_check) or exit("schedule Clubbing check".mysqli_error ($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($query_result_check)>0)
				{				
					while($sql_rows=mysqli_fetch_array($query_result_check))
					{
						$order_del_no[]=$sql_rows['order_del_no'];
						$order_col_des[]=$sql_rows['order_col_des'];
					}
				}
				else
				{
					$orders_join='J'.substr($_POST["color"],-1);
					$query_check1 = "select * from $bai_pro3.bai_orders_db_confirm where order_joins='".$orders_join."'";
					$query_result_check1 = mysqli_query($link,$query_check1) or exit("schedule Clubbing check".mysqli_error ($GLOBALS["___mysqli_ston"]));
					while($sql_rows1=mysqli_fetch_array($query_result_check1))
					{
						$order_del_no[]=$sql_rows1['order_del_no'];
						$order_col_des[]=$sql_rows1['order_col_des'];
					}
				}	
			}
			else
			{
				$order_del_no[]=$_POST['schedule'];
				$order_col_des[]=$_POST['color'];
			}
		    $query = "select * from $bai_pro3.excess_cuts_log where schedule_no='".$schedule."' and color='".$color."'";
            // echo $query;
            $query_result = mysqli_query($link,$query) or exit(" Error78".mysqli_error ($GLOBALS["___mysqli_ston"]));
            if(mysqli_num_rows($query_result)>0){
				
				for($i=0;$i<sizeof($order_col_des);$i++)
				{
					$query1 = "update $bai_pro3.excess_cuts_log set excess_cut_qty='".$_POST['cut1']."' where schedule_no='".$order_del_no[$i]."' and color='".$order_col_des[$i]."'";
					$query_result1 = mysqli_query($link,$query1) or exit(" Error7".mysqli_error ($GLOBALS["___mysqli_ston"]));
				}
                echo "<script type=\"text/javascript\"> 
                sweetAlert('Excess Cut Updated','','success');
                setTimeout(\"Redirect()\",0); 
                function Redirect(){	 
                        location.href = \"".getFullURL($_GET['r'], "main_interface.php","N")."&color=$color&style=$style&schedule=$schedule&excess_cut=$excess_cut\"; 
                    }
                </script>";	
            }
            
        }else {
            $excess_cut = $_POST['excess_cut'];
            $schedule = $_POST['schedule'];
            $style = $_POST['style'];
            $color = $_POST['color'];
            $user = $_POST['user'];
			$order_joins = $_POST['order_joins_no'];
			
			if($order_joins<>0)
			{
				$order_del_no[]=$_POST['schedule'];
				$order_col_des[]=$_POST['color'];
				$query_check = "select * from $bai_pro3.bai_orders_db_confirm where order_joins='J".$schedule."'";
				$query_result_check = mysqli_query($link,$query_check) or exit("schedule Clubbing check".mysqli_error ($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($query_result_check)>0)
				{				
					while($sql_rows=mysqli_fetch_array($query_result_check))
					{
						$order_del_no[]=$sql_rows['order_del_no'];
						$order_col_des[]=$sql_rows['order_col_des'];
					}
				}
				else
				{
					$orders_join='J'.substr($_POST["color"],-1);
					$query_check1 = "select * from $bai_pro3.bai_orders_db_confirm where order_joins='".$orders_join."'";
					$query_result_check1 = mysqli_query($link,$query_check1) or exit("schedule Clubbing check".mysqli_error ($GLOBALS["___mysqli_ston"]));
					while($sql_rows1=mysqli_fetch_array($query_result_check1))
					{
						$order_del_no[]=$sql_rows1['order_del_no'];
						$order_col_des[]=$sql_rows1['order_col_des'];
					}
				}	
			}
			else
			{
				$order_del_no[]=$_POST['schedule'];
				$order_col_des[]=$_POST['color'];
			}
	
			for($i=0;$i<sizeof($order_col_des);$i++)
			{
				$excess_cut_log_qry = "insert into $bai_pro3.excess_cuts_log(schedule_no,color,excess_cut_qty,date,user) values('".$order_del_no[$i]."','".$order_col_des[$i]."',".$excess_cut.",NOW(),'".$user."')";
				$excess_cut_log_result = mysqli_query($link,$excess_cut_log_qry) or exit(" Error7".mysqli_error ($GLOBALS["___mysqli_ston"]));
			}
                echo "<script type=\"text/javascript\"> 
                sweetAlert('Excess Cut Inserted','','success');
                setTimeout(\"Redirect()\",0); 
                function Redirect(){	 
                        location.href = \"".getFullURL($_GET['r'], "main_interface.php","N")."&color=$color&style=$style&schedule=$schedule&excess_cut=$excess_cut\"; 
                    }
            </script>";	
        }
       
    }
?>
<?php
 include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

?> 

<div class="panel panel-primary">
    <div class="panel-heading">Digital Inspection Transaction Report</div>
        <div class="panel-body">
            <div class="form-group">
                <form name="test" id="test" method="post" action="index.php?r=<?php echo $_GET['r']; ?>">
                    <div class="row">
                                    <div class='col-lg-2'>
                                        <label >Select Date: </label>
                                        <input type="date" class="form-control" data-toggle="datepicker" style=" display: inline-block;" id="demo1" name="date" value="<?php 
                                        if(isset($_POST['date'])) { echo $_POST['date']; } else { echo date("Y-m-d "); } ?>" />  
                                    </div>
                                    <div class='col-lg-2'>
                                        <label >Select Batch: </label>
                                        <input type="text" class="form-control" style=" display: inline-block;" id="demo2" name="batch" value="<?php if(isset($_POST['batch'])) { echo $_POST['batch']; }?>"/>  
                                    </div>
                                    <div class='col-lg-2'>
                                        <label >Select Lot No: </label>
                                        <input type="text" class="form-control" style=" display: inline-block;" id="demo3" name="lot_no" value="<?php if(isset($_POST['lot_no'])) { echo $_POST['lot_no']; }?>"/>  
                                    </div>
                                    <div class='col-lg-2'>
                                        <input type="submit" class="btn btn-success" style='margin-top: 25px'  value="submit" name="submit" />
                                    </div>
                     </div>
                </form>
            
              
<?php
    if(isset($_POST['submit']))
    {   
		if($date=$_POST['date']);
		{
			$sql = "SELECT * FROM `$bai_rm_pj1`.`main_population_tbl` WHERE DATE(date_time)= DATE('$date')";
		}
		if($batch=$_POST['batch']);
		{
           $sql = "SELECT * FROM `$bai_rm_pj1`.`main_population_tbl` WHERE batch= '".$batch."'";
		}
		if($lot_no=$_POST['lot_no'])
		{
           $sql = "SELECT * FROM `$bai_rm_pj1`.`main_population_tbl` WHERE lot_no = $lot_no";
		}
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$no_of_rows = mysqli_num_rows($sql_result);
		if($no_of_rows == 0)
		{
			echo "<script>sweetAlert('No Data Found','','warning');
			$('#main_div').hide()</script>";
		}
		else
		{
			echo "<div class='panel-body'>";
			echo "<div id='main_div'>";
			echo "<div class='table-responsive col-sm-12'>";
			echo "<table id='table1' class = 'table table-striped jambo_table bulk_action table-bordered' width='100'><thead>";
			echo "<tr class='headings'>";
			echo "<th>S No</th>";
			echo "<th>Lot No</th>";
			echo "<th>Suppliers Po</th>";
			echo "<th>Supplier Batch</th>";
			echo "<th>Invoice</th>";
			echo "<th>RM Color</th>";
			echo "<th>Total Rolls</th>";
			echo "<th>Total Quantity</th>";
			echo "<th>Control Step 1</th>";
			echo "<th>Control Step 2</th>";
			echo "<th>Report</th>";
			echo "</tr>";
			echo "</thead>";
			$s_no=1;
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$id=$sql_row['id'];                 	
				$sql121="SELECT * FROM $bai_rm_pj1.`roll_inspection_child` WHERE parent_id=$id";
				$sql_result121=mysqli_query($link, $sql121) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$rows=mysqli_num_rows($sql_result121);
				
				$lots=explode(",",$sql_row['lot_no']);
				$suppliers=explode(",",$sql_row['supplier']);
				$batchs=explode(",",$sql_row['batch']);
				$invoice_nos=explode(",",$sql_row['invoice_no']);
				
				$get_details_points = "select sum(rec_qty) as qty from $bai_rm_pj1.`inspection_population` where parent_id=$id and status=3";
				$details_result_points = mysqli_query($link, $get_details_points) or exit("get_details--1Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row522=mysqli_fetch_array($details_result_points))
				{ 					
					if($row522['qty']>0)
					{
						$invoice_qty=$row522['qty'];
						if($fab_uom == "meters"){
							$invoice_qty=round($invoice_qty*1.09361,2);
						}else
						{
							$invoice_qty;
						}				
						$back_color="";		
						$four_point_count = "select sum(points) as pnt from $bai_rm_pj1.four_points_table where insp_child_id in (select store_in_id from $bai_rm_pj1.`inspection_population` where parent_id=$id)";	
						$status_details_result2=mysqli_query($link,$four_point_count) or exit("get_status_details Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($status_details_result2)>0)
						{	
							while($row52=mysqli_fetch_array($status_details_result2))
							{ 
								$point=$row52['pnt'];
								$main_points=((($row52['pnt']/$invoice_qty)*(36/49.21))*100);
								$main_points = round($main_points,2);
							}
							
							if($point>0 && $rows>0)
							{	
								if($main_points<28)
								{
									$back_color="style='background: green;color:white;'";
								}
								else
								{
									$back_color="style='background: red;color:white;'";
								}
							}
							else
							{
								$back_color="";
							}	
						}
						else
						{
							$back_color="";
						}
					}else
					{
						$back_color="";
					}						
				}
				
				echo "<tr $back_color>";
				echo "<td>$s_no</td>";
				if(sizeof($lots)>1)
				{
					echo "<td>";
					for($i=0;$i<sizeof($lots);$i++)
					{
						echo $lots[$i]."<br>";
					}
					echo "</td>";
				}
				else
				{
					echo "<td>".$sql_row['lot_no']."</td>";
				}
				
				if(sizeof($suppliers)>1)
				{
					echo "<td>";
					for($i=0;$i<sizeof($suppliers);$i++)
					{
						echo $suppliers[$i]."<br>";
					}
					echo "</td>";
				}
				else
				{
					echo "<td>".$sql_row['supplier']."</td>";
				}
				
				if(sizeof($batchs)>1)
				{
					echo "<td>";
					for($i=0;$i<sizeof($batchs);$i++)
					{
						echo $batchs[$i]."<br>";
					}
					echo "</td>";
				}
				else
				{
					echo "<td>".$sql_row['batch']."</td>";
				}
				
				if(sizeof($invoice_nos)>1)
				{
					echo "<td>";
					for($i=0;$i<sizeof($invoice_nos);$i++)
					{
						echo $invoice_nos[$i]."<br>";
					}
					echo "</td>";
				}
				else
				{
					echo "<td>".$sql_row['invoice_no']."</td>";
				}
				
				echo "<td>".$sql_row['rm_color']."</td>";
				echo "<td>".$sql_row['no_of_rolls']."</td>";
				echo "<td>".$sql_row['qty']."</td>";
				
				$pop_up_path="../sfcs_app/app/inspection/reports/4_point_inspection_report.php";
				
				$sql1="SELECT * FROM $bai_rm_pj1.`inspection_population` WHERE parent_id='$id' AND status<>0";
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				// echo $sql1;
				if(mysqli_num_rows($sql_result1)==0)
				{					
					echo "<td><div class='col-sm-4' id='populate_div'>
					<center><a class=\"btn btn-xs btn-warning pull-left\" href=\"" . getFullURLLevel($_GET['r'], "controllers/digital_inspection/digital_inspection_report_v1.php", "1", "N") . "&parent_id=$id\">Set Inspection Population</a></center>
					</div></td>";
									
				}	
				else
				{
					echo '<td><div class="col-sm-4" id="populate_div">
					<center><a class="btn btn-primary"> Complete </a></center>
					</div><br><br>';
					
					echo "<div class='col-sm-4' id='populate_div'>
					<center><a class=\"btn btn-xs btn-warning pull-left\" href=\"" . getFullURLLevel($_GET['r'], "controllers/digital_inspection/digital_inspection_report_v1.php", "1", "N") . "&parent_id=$id&status=1\">Click to Inspection Population</a></center>
					</div></td>";
				}						

				$sql12="SELECT * FROM $bai_rm_pj1.`inspection_population` WHERE parent_id='$id' AND (status<>3 && status<>0)";
				$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_result12)>0)
				{					
					echo "<td><div class='col-sm-4' id='populate_div'>
						<center><a class=\"btn btn-xs btn-warning pull-left\" href=\"" . getFullURLLevel($_GET['r'], "controllers/digital_inspection/4_point_roll_inspection.php", "1", "N") . "&parent_id=$id\">Proceed 4 Point Inspection</a></center>
						</div></td>";
				}
				else
				{
					echo '<td><div class="col-sm-4" id="populate_div">
					<center><a class="btn btn-primary"	> Complete </a></center>
					</div></td>';
				}						
				
				$sql121="SELECT * FROM $bai_rm_pj1.`inspection_population` WHERE parent_id='$id' AND status=3";
				$sql_result121=mysqli_query($link, $sql121) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_result121)==0)
				{
					echo "<td><a class='btn btn-primary' href=\"$pop_up_path?parent_id=$id\" onclick=\"Popup1=window.open('$pop_up_path?parent_id=$id','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Get Report</a>
					   <br><br>
                         <a class='btn btn-xs btn-warning pull-left' href=\"" . getFullURLLevel($_GET['r'], "controllers/digital_inspection/C_Tex_Interface_V6.php", "1", "N") . "&parent_id=$id\">Color Contunity Report</a>
					</td>";
				}
				else
				{
					echo '<td><div class="col-sm-4" id="populate_div">
					<center><input type="submit" class="btn btn-md btn-primary" id="disable_id" name="set_insp_pop" value="Pending"> </center>
					</div>';
					echo "<br><br>
                         <a class='btn btn-xs btn-warning pull-left' href=\"" . getFullURLLevel($_GET['r'], "controllers/digital_inspection/C_Tex_Interface_V6.php", "1", "N") . "&parent_id=$id\">Color Contunity Report</a>
					</td>";
				}
					echo "</tr>";
					$s_no++;
			}
		}                     
            echo "</div></table></div></div>";
    }       
    
                          
?>
    </div>  
</div>
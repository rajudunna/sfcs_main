<script>
		
		$(document).ready(function() {
			$( function() {
  			  $( "#demo1" ).datepicker();
  } );
			if (screen.width <= 1070) 
            {
                $BODY.toggleClass('nav-md nav-sm');
			}
			$("#demo1").change(function(){
				$("#demo2").val('');
				$("#demo3").val('');
				
			});
			$("#demo2").change(function(){
				$("#demo1").val('');
				$("#demo3").val('');
				
			});
			$("#demo3").change(function(){
				$("#demo2").val('');
				$("#demo1").val('');
				
			});
		});
</script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'], 'common/js/openbundle_report.min.js', 4, 'R'); ?>"></script>	
	
<?php
 include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
 $plant_code = $_SESSION['plantCode'];
 $username = $_SESSION['userName'];
?> 

<div class="panel panel-primary">
    <div class="panel-heading">Digital Inspection Transaction Report</div>
        <div class="panel-body">
            <div class="form-group">
                <form name="test" id="test" method="post" action="index.php?r=<?php echo $_GET['r']; ?>">
                    <div class="row">
                                    <div class='col-lg-2'>
                                        <label >Select Date: </label>
                                        <input type="text" class="form-control" data-toggle="datepicker" style=" display: inline-block;" id="demo1" name="date" value="<?php 
                                        if($_POST['date']) { echo $_POST['date']; } ?>" />  
                                    </div>
                                    <div class='col-lg-2'>
                                        <label >Select Batch: </label>
                                        <input type="text" class="form-control" style=" display: inline-block;" id="demo2" name="batch" value="<?php 
                                        if($_POST['batch']) { echo $_POST['batch']; }?>"/>  
                                    </div>
                                    <div class='col-lg-2'>
                                        <label >Select Lot No: </label>
                                        <input type="text" class="form-control" style=" display: inline-block;" id="demo3" name="lot_no" value="<?php 
                                        if($_POST['lot_no']) { echo $_POST['lot_no']; }?>"/>  
                                    </div>
                                    <div class='col-lg-2'>
                                        <input type="submit" class="btn btn-success" style='margin-top: 25px'  value="submit" name="submit" />
                                    </div>
                     </div>
                </form>
            
              
<?php
    if(isset($_POST['submit']))
    {   
    	if($_POST['date'] == '' && $_POST['batch'] == '' &&  $_POST['lot_no'] == '')
		{
			echo "<script>sweetAlert('Please Select Any One Column','','warning');
			$('#main_div').hide()</script>";
		}
		else
		{
			if($_POST['date'])
			{
				$date=$_POST['date'];
				$sql = "SELECT * FROM `$wms`.`main_population_tbl` WHERE plant_code='$plantcode' and DATE(date_time)= '".$date."'";
			}
			if($_POST['batch'])
			{
				$batch=$_POST['batch'];
	           $sql = "SELECT * FROM `$wms`.`main_population_tbl` WHERE plant_code='$plantcode' and batch= '".$batch."'";
			}
			if($_POST['lot_no'])
			{
				$lot_no=$_POST['lot_no'];
	           $sql = "SELECT * FROM `$wms`.`main_population_tbl` WHERE plant_code='$plantcode' and lot_no = '".$lot_no."'";
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
				echo "<th>Status for Inspection Population</th>";
				echo "<th>Status for 4 Point Population</th>";
				echo "<th>Reports</th>";
				echo "</tr>";
				echo "</thead>";
				$s_no=1;
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$id=$sql_row['id'];                 	
					$sql121="SELECT * FROM $wms.`roll_inspection_child` WHERE plant_code='$plantcode' and parent_id=$id";
					$sql_result121=mysqli_query($link, $sql121) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$rows=mysqli_num_rows($sql_result121);
					
                    $main_lot[] = $sql_row['lot_no'];
					$lots=explode(",",$sql_row['lot_no']);
					$suppliers=explode(",",$sql_row['supplier']);
					$batchs=explode(",",$sql_row['batch']);
					$invoice_nos=explode(",",$sql_row['invoice_no']);
					
					$get_details_points = "select sum(rec_qty) as qty from $wms.`inspection_population` where plant_code='$plantcode' and parent_id=$id and status=3";
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
							$get_min_value = "select width_s,width_m,width_e from $wms.roll_inspection_child where plant_code='$plantcode' and store_in_tid in (select store_in_id from $wms.`inspection_population` where plant_code='$plantcode' and parent_id=$id)";
							$min_value_result=mysqli_query($link,$get_min_value) or exit("get_min_value Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($row_min=mysqli_fetch_array($min_value_result))
							{
                               $width_s = $row_min['width_s'];
                               $width_m = $row_min['width_m'];
                               $width_e = $row_min['width_e'];
							}
                            $min_value = min($width_s,$width_m,$width_e);
                            $inch_value=round($min_value/(2.54),2);				
							$back_color="";		
							$four_point_count = "select sum(points) as pnt from $wms.four_points_table where  insp_child_id in (select store_in_id from $wms.`inspection_population` where parent_id=$id and plant_code='".$plant_code."')";	
							$status_details_result2=mysqli_query($link,$four_point_count) or exit("get_status_details Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							if(mysqli_num_rows($status_details_result2)>0)
							{	
								while($row52=mysqli_fetch_array($status_details_result2))
								{ 
									$point=$row52['pnt'];
									$main_points=((($row52['pnt']/$invoice_qty)*(36/$inch_value))*100);
									$main_points = round($main_points,2);
								}
								
								if($rows>0)
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
					$lotsString = '';
					if(sizeof($lots)>1)
					{
						echo "<td>";
						for($i=0;$i<sizeof($lots);$i++)
						{
							$lotsString .= "'".$lots[$i]."',";
							echo $lots[$i]."<br>";
						}
						$lotsString = rtrim($lotsString,',');
						echo "</td>";
					}
					else
					{
						$lotsString = "'".$sql_row['lot_no']."'";
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
					$pop_up_path1="../sfcs_app/app/inspection/controllers/digital_inspection/c_tex_report_print.php";
					
					// second Process
					$sql1="SELECT * FROM $wms.`inspection_population` WHERE plant_code='$plantcode' and parent_id='$id' AND status<>0";
					$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					// echo $sql1;
					$check=mysqli_num_rows($sql_result1);
					if(mysqli_num_rows($sql_result1)==0)
					{					
						echo "<td><div class='col-sm-12' id='populate_div'>
						<center><a class=\"btn btn-xs btn-warning pull-left\" href=\"" . getFullURLLevel($_GET['r'], "controllers/digital_inspection/digital_inspection_report_v1.php", "1", "N") . "&parent_id=$id\">Set Inspection Population</a></center>
						</div></td>";
										
					}	
					else
					{
						echo '<td><div class="col-sm-12" id="populate_div">
						<center><label class="label label-primary" style="font-size:12px"> Completed </label></center>
						</div><br><br>';
						
						echo "<div class='col-sm-4' id='populate_div'>
						<center><a class=\"btn btn-xs btn-warning pull-left\" href=\"" . getFullURLLevel($_GET['r'], "controllers/digital_inspection/digital_inspection_report_v1.php", "1", "N") . "&parent_id=$id&status=1\">Click to Inspection Population</a></center>
						</div>";

						echo "<br><br>
						     <div class='col-sm-4' id='populate_div'>
	                         <center><a class='btn btn-xs btn-warning pull-left' href=\"" . getFullURLLevel($_GET['r'], "controllers/digital_inspection/c_tex_interface_v6.php", "1", "N") . "&parent_id=$id\">Click to Color Contunity Report</a></center>
						</div></td>";
					}
	
					// Third Process
					if($check==0)
					{
						echo '<td><div class="col-sm-12" id="populate_div">
							<center><label class="label label-primary" style="font-size:12px"> Pending to set Inspection Population </label></center>
							</div></td>';
					}
					else
					{
						$sql12="SELECT * FROM $wms.`inspection_population` WHERE plant_code='$plantcode' and parent_id=$id AND (status<>3 && status<>0)";
						$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($sql_result12)>0)
						{					
							echo "<td><div class='col-sm-12' id='populate_div'>
								<center><a class=\"btn btn-xs btn-warning pull-left\" href=\"" . getFullURLLevel($_GET['r'], "controllers/digital_inspection/4_point_roll_inspection.php", "1", "N") . "&parent_id=$id\">Click to Proceed </a></center>
								</div></td>";
						}
						else
						{
							echo '<td><div class="col-sm-12" id="populate_div">
							<center><label class="label label-primary" style="font-size:12px"> Completed </label></center>
							</div></td>';
						}
					}

					
					$get_status=0;
					$sql121="SELECT min(status) as status FROM $wms.`inspection_population` WHERE plant_code='$plantcode' and parent_id='$id' AND status<>0";
					$sql_result121=mysqli_query($link, $sql121) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_num_rows($sql_result121)>0)
					{
						while($row521=mysqli_fetch_array($sql_result121))
						{
						   $get_status = $row521['status'];
						   if($get_status == 3)
						   {
							  $val2=1;
						   }
						   else
						   {
							   $val2=0;
						   } 
						}
					}
					else
					{
						 $val2=0;
					}
					
					//To get color contunity report
					$get_store_in_id= "select store_in_id FROM $wms.`inspection_population` WHERE plant_code='$plantcode' and parent_id='$id'";
					$sql_result1212=mysqli_query($link, $get_store_in_id) or exit("Sql Error2.111".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row5212=mysqli_fetch_array($sql_result1212))
					{
                       $store_in_id[] = $row5212['store_in_id'];
					}
					$store_id = implode(",",$store_in_id);
					$get_color_report = "select * from $wms.store_in where plant_code='$plantcode' and ref4='' and  lot_no in ($lotsString) AND tid in ($store_id)";
					$result_color_report=mysqli_query($link, $get_color_report) or exit("Sql Error2.1".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_num_rows($result_color_report)>0)
					{
                        while($row215=mysqli_fetch_array($result_color_report))
						{
                           // if($row215['print_check']==0)
							// {
							    $color_report =0;
							// }
                            // else
                            // {
                           	  // $color_report =0;
                            // }
						}	
					}
					else
					{
                      $color_report =1;
					}	
					if($val2==1 && $get_status == 3)
					{
						echo "<td><center><a class=\"btn btn-xs btn-warning \" style='font-size:12px' href=\"$pop_up_path?parent_id=$id\" onclick=\"Popup1=window.open('$pop_up_path?parent_id=$id','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Get 4 Point Report</a></center>
						   <br><br>";
                        
                        if($color_report ==1)
                        {

	                      echo" <center><a class=\"btn btn-xs btn-warning \" style='font-size:12px' href=\"$pop_up_path1?parent_id=$id\" onclick=\"Popup1=window.open('$pop_up_path1?parent_id=$id','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Color Contunity Report</a></center>";
                        }
                        else
                        {
                        	echo '<div class="col-sm-12" id="populate_div">
							<center><label class="label label-primary" style="font-size:12px">Color Contunity Report Pending</label></center>
							</div>';
                        }
						echo "</td>";
					}
					else
					{
						echo '<td><div class="col-sm-12" id="populate_div">
						<center><label class="label label-primary" style="font-size:12px">4 Point Report Pending</label></center>
						</div>';
						echo "<br><br>";
	                    if($color_report ==1)
                        {

	                      echo" <center><a class=\"btn btn-xs btn-warning \" style='font-size:12px' href=\"$pop_up_path1?parent_id=$id\" onclick=\"Popup1=window.open('$pop_up_path1?parent_id=$id','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Color Contunity Report</a></center>";
                        }
                        else
                        {
                        	
							echo '<div class="col-sm-12" id="populate_div">
							<center><label class="label label-primary" style="font-size:12px">Color Contunity Report Pending</label></center>
							</div>';
                        }
						echo "</td>";
					}
					echo "</tr>";
					$s_no++;
					
					
				}
			}                     
            echo "</div></table></div></div>";
		}	

    }       
    
                          
?>
    </div>  
</div>
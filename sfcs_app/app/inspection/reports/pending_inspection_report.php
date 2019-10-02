<?php
 include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
?> 

<div class="panel panel-primary">
    <div class="panel-heading">Pending  Inspection Report</div>
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
                                        <input type="submit" class="btn btn-success" style='margin-top: 25px'  value="submit" name="submit" />
                                    </div>
                     </div>
                </form>
            
              
<?php
    if(isset($_POST['submit']))
    {   
		$date=$_POST['date'];
		$sql = "SELECT * FROM `$bai_rm_pj1`.`main_population_tbl` WHERE DATE(date_time)= DATE('$date')";
		echo $sql;
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
			echo "<table id='table1' class = 'table table-striped jambo_table bulk_action table-bordered'><thead>";
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
				echo "<tr>";
				echo "<td>$s_no</td>";
				echo "<td>".$sql_row['lot_no']."</td>";
				echo "<td>".$sql_row['supplier']."</td>";
				echo "<td>".$sql_row['batch']."</td>";
				echo "<td>".$sql_row['invoice_no']."</td>";
				echo "<td>".$sql_row['rm_color']."</td>";
				echo "<td>".$sql_row['no_of_rolls']."</td>";
				echo "<td>".$sql_row['qty']."</td>";
				$sql1="SELECT * FROM $bai_rm_pj1.`inspection_population` WHERE parent_id='$id' AND status<>0";
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_result1)==0)
				{
					echo '<td><div class="col-sm-4" id="populate_div">
									<center><input type="submit" class="btn btn-md btn-primary" id="disable_id" name="set_insp_pop" value="Set Inspection Population"> </center>
									</div></td>';
				}	
				else
				{
					echo '<td><div class="col-sm-4" id="populate_div">
									<center><input type="submit" class="btn btn-md btn-primary" id="disable_id" name="set_insp_pop" value="Not Available"> </center>
									</div></td>';
				}						

				$sql12="SELECT * FROM $bai_rm_pj1.`inspection_population` WHERE parent_id='$id' AND (status<>3 && status<>0)";
				$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_result12)>0)
				{
					echo '<td><div class="col-sm-4" id="populate_div">
					<center><input type="submit" class="btn btn-md btn-primary" id="disable_id" name="set_insp_pop" value="Proceed for Inspection"> </center>
					</div></td>';
				}
				else
				{
					echo '<td><div class="col-sm-4" id="populate_div">
					<center><input type="submit" class="btn btn-md btn-primary" id="disable_id" name="set_insp_pop" value="Not Available"> </center>
					</div></td>';
				}						
				$path1= "<a class=\"btn btn-xs btn-warning pull-left\" href=\"" . getFullURLLevel($_GET['r'], "4_point_roll_inspection.php", "0", "N") . "&parent_id=$parent_id\">Get Inspection Report</a>";
				$path1=
				$path1=
				$sql121="SELECT * FROM $bai_rm_pj1.`inspection_population` WHERE parent_id='$id' AND (status<>0 && status<>3)";
				$sql_result121=mysqli_query($link, $sql121) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_result121)==0)
				{
					echo '<td><div class="col-sm-4" id="populate_div">
					<center>$path1</center>
					</div></td>';
				}
				else
				{
					echo '<td><div class="col-sm-4" id="populate_div">
					<center><input type="submit" class="btn btn-md btn-primary" id="disable_id" name="set_insp_pop" value="Not Available"> </center>
					</div></td>';
				}
					echo "</tr>";
					$s_no++;
				}
			}
                     
            echo "</div></table></div>";
    }       
    
                          
?>
    </div>  
</div>
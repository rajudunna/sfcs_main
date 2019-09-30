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
             </div>
          </div> 
              
<?php
    if(isset($_POST['submit']))
    {                   
        
            $date=$_POST['date'];
            
            $sql = "SELECT id,date_time FROM `$bai_rm_pj1`.`main_population_tbl` WHERE DATE(date_time)= DATE('$date')";
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
                echo "<th>Date Time</th>";
                echo "<th>Lot No</th>";
                echo "<th>Suppliers Po</th>";
                echo "<th>Supplier Batch</th>";
                echo "<th></th>";
                echo "</tr>";
                echo "</thead>";
                $s_no=1;
                while($sql_row=mysqli_fetch_array($sql_result))
                {
                    $id=$sql_row['id'];
                    $date=$sql_row['date_time'];
                 
                $sql1="SELECT lot_no,supplier_invoice,supplier_batch FROM $bai_rm_pj1.`inspection_population` WHERE parent_id='$id' AND STATUS='1'";
                $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
                echo $sql1;
                while($sql_row1=mysqli_fetch_array($sql_result1))
                {
                    $lot_no=$sql_row1['lot_no'];
                    $supplier_invoice=$sql_row1['supplier_invoice'];
                    $supplier_batch=$sql_row1['supplier_batch'];
                
                    
                    echo "<tr>";
                    echo "<td>$s_no</td>";
                    echo "<td>$date</td>";
                    echo "<td>$lot_no</td>";
                    echo "<td>$supplier_invoice</td>";
                    echo "<td>$supplier_batch</td>";     
                    echo "<td>"; 
                    ?>
                    <input type="submit" class="btn btn-success" value="print " name="submit">
                    <input type="submit" class="btn btn-success" value="Inspection " name="submit">
                    <?php
                    echo "</td>";
                    echo "</tr>";
                    $s_no++;
                }
              }
            }
           
            echo "</div></table></div>";
            
    }
                          
?>
    </div>  
</div>
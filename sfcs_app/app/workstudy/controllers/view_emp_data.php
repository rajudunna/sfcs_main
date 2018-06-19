
<?php 
  
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
   // include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'header_scripts.php',0,'R'));
   // $edit_emp_data = getFullURL($_GET['r'],'edit_emp_data.php','N'); 
	$edit_emp_data = getFullURLLevel($_GET['r'],'edit_emp_data.php',0,'N');	

?>

<script type="text/javascript"> 
    function validateForm()
    {
        var x=document.getElementById('qty_value').value;
        if (x==null || x=="" || x=="Enter Cartoned Qty")
        {
            alert("First name must be filled out");
            return false;
        }
    }
</script>
<style>
    th,td {
		text-align:center;
	}
	table{
		white-space:nowrap; 
		border-collapse:collapse;
		font-size:12px;
		background-color: white;
	}
</style>
<div class="panel panel-primary">
<div class="panel-heading">View Employee Attendance</div>
<div class="panel-body">
    <?php $dat = $_GET['date'];?>
    <div style="float: right;"><b><a href="<?= $edit_emp_data.'&date='.$dat;  ?>" class='btn btn-primary'>Update Attendance >></a></b></div>
        <!-- <form method="GET" action="<?= '?r='.$_GET['r']; ?>" >
            <div class="row">
                <div class="col-md-2"><label>Select Date : </label>
                <input type="date" name="date" class="form-control" value="<?php echo $dat; ?>">
                </div><br/>
                <div class="col-md-1" ><input type="submit" name="submit" class="btn btn-primary" value="Search"></div>
            </div>
        </form> -->
        <br/><hr/><br/>
        <h2>You are viewing attendance for the date: <?php echo $dat; ?></h2>
        <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8" style='max-height:600px;overflow-y:scroll;'>   
            <table class="table table-bordered">
                <tr>
                    <th> Module </th>
                    <th> Present Emp </th>
                    <th> Absent Emp (Forcast)</th>
                    <th> Absent Emp (Nonforcast)</th>
                    <th> Jumpers</th>
                </tr>
                <?php
                    $availcount = 0;
                    $absentcount = 0;
                    $module='';
                    $module_query="SELECT module_id FROM $bai_pro3.`plan_modules` ORDER BY module_id*1";
                    $module_result=mysqli_query($link, $module_query) or exit("Error Finding Modules");
                    while($sql_row=mysqli_fetch_array($module_result))
                    {
                        $modules[]=$sql_row['module_id'];
                    }
                    for ($i = 0; $i <sizeof($modules); $i++) 
                    {
                        // $mod = $modules[$i];

                        $sql = "SELECT * FROM $bai_pro.pro_atten WHERE date='$dat' AND module='$modules[$i]'";
                        $result = mysqli_query($link, $sql) or exit("Sql Error4" . mysqli_error($GLOBALS["___mysqli_ston"]));
                        $sql_row = mysqli_fetch_array($result);
                        $avail = $sql_row['avail_A'];
                        
                        $absentf = $sql_row['absent_A'];
                        $absentnf = $sql_row['absent_B'];
                        $jumpers = $sql_row['jumpers']; 
                        $avail1= (24+$jumpers)-($absentnf+ $absentf);
                        $availcount = $availcount + $avail1;
                        
                        $absentfcount = $absentfcount + $absentf;
                        $absentnfcount = $absentnfcount + $absentnf;
                        $jumperscount = $jumperscount + $jumpers;
                ?>
                    <tr>
                        <td>
                            <input type="hidden" value="<?php echo $modules[$i]; ?>" name="mod<?php echo $i; ?>">
                            <?php echo $modules[$i]; ?>
                        </td>
                        <td><?php echo $avail1; ?> </td>
                        <td><?php echo  $absentf ; ?></td>
                        <td><?php echo $absentnf; ?></td>
                        <td><?php echo $jumpers; ?></td>
                    </tr>
            <?php  } ?>
                    <tr style='background-color:grey;color:white'>
                        <td><b>Total</b></td>
                        <td><b><?php echo $availcount; ?></b></td>
                        <td><b><?php echo $absentfcount; ?></b></td>
                        <td><b><?php echo $absentnfcount; ?></b></td>
                        <td><b><?php echo $jumperscount; ?></b></td>
                    </tr>
            </table>
        </div>
    </div> 
</div>
</div>
</div>
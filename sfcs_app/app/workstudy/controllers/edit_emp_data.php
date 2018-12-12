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

    function validateQty(event) 
    {
        event = (event) ? event : window.event;
        var charCode = (event.which) ? event.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
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
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	$view_emp_data = getFullURLLevel($_GET['r'],'view_emp_data.php',0,'N');	
     
?>

<div class="panel panel-primary">
<div class="panel-heading">Edit Employee Attendance</div>
<div class="panel-body">
    <?php $dat = $_GET['date'];    ?>
    <div style="float: right;"><b> 
        <a href="<?= $view_emp_data.'&date='.$dat;  ?>" class='btn btn-primary'>View Attendance >></a></b>
    </div><br/>
    <h2>You are Editing attendance for the date: <?php echo $dat; ?></h2>
<br/><br/>
        <form method="POST" action="<?= getFullURL($_GET['r'],'update_atten.php','N') ?>">
            <input type="hidden" name="dat" value="<?php echo $dat; ?>">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-8" style='max-height:600px;overflow-y:scroll;'>
                    <table class="table table-bordered">
                        <tr>
                            <th> Module </th>
                            <th style='display:none;'> Present Emp </th>
                            <th> Absent (Forcasted) </th>
                            <th> Absent (Non Forcasted) </th>
                            <th> Jumpers </th>
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
                            for ($i = 0; $i < sizeof($modules); $i++) 
                            {
                                $mod = $modules[$i];

                                $sql = "SELECT * FROM $bai_pro.pro_atten WHERE date='$dat' AND module='$modules[$i]'";
                                $result = mysqli_query( $link, $sql) or exit("Sql Error4" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                $sql_row = mysqli_fetch_array($result);
                                    $avail = $sql_row['avail_A'];
                                    $absentf = $sql_row['absent_A'];
                                    $absentnf = $sql_row['absent_B'];
                                    $jumpers = $sql_row['jumpers']; 
                                    $availcount = $availcount + $avail;
                                    $absentfcount = $absentfcount + $absentf;
                                    $absentnfcount = $absentnfcount + $absentnf;
                                    $jumperscount = $jumperscount + $jumpers;
                            ?>
                            <tr>
                                <td>
                                    <input type="hidden" value="<?php echo $modules[$i]; ?>" name="mod<?php echo $i; ?>">
                                        <?php echo $modules[$i]; ?>
                                </td>
                                <td style='display:none;'>
                                    <input type="text" class="form-control" onkeypress="return validateQty(event);" value="<?php echo $sql_row['avail_A']; ?>" name="pr<?php echo $i; ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" onkeypress="return validateQty(event);" value="<?php echo $absentf; ?>" name="abf<?php echo $i; ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" onkeypress="return validateQty(event);" value="<?php echo $absentnf; ?>" name="abnf<?php echo $i; ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" onkeypress="return validateQty(event);" value="<?php echo $jumpers; ?>" name="jump<?php echo $i; ?>">
                                </td>
                            </tr>
                    <?php  } ?>
                            <tr>
                                <td><b>Total</b></td>
                                <td style='display:none'><b><?php echo $availcount; ?></b></td>
                                <td><b><?php echo $absentfcount; ?></b></td>
                                <td><b><?php echo $absentnfcount; ?></b></td>
                                <td><b><?php echo $jumperscount; ?></b></td>
                            </tr>
                            </table>
                        </div>
                    </div>
                <div class="row">
                <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <tr>
                            <th ><input type="submit" class="btn btn-success" value="Update" class="form-control"> </th>
                        </tr>
                    </div>
              
            </div>
        <form>
</div>
</div>
</div>
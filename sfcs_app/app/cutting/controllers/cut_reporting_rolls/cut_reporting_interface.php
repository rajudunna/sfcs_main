<?php

$cut_tables   = array();
$team_leaders = array();

$cut_table_query = "SELECT * from $bai_pro3.tbl_cutting_table";
$cut_table_result = mysqli_query($link,$cut_table_query);
while($row = mysqli_fetch_array($cut_table_result)){
    $cut_tables[$row['tbl_id']] = $row['tbl_name'];
}

$team_leaders_query = "SELECT * from $bai_pro3.tbl_cutting_table";
$team_leaders_result = mysqli_query($link,$team_leaders_query);
while($row = mysqli_fetch_array($team_leaders_result)){
    $team_leaders[$row['id']] = $row['emp_name'];
}

?>

<div class='panel panel-primary'>
    <div class='panel-heading'>
        <b>Cut Quantity Reporting Without Rolls</b>
    </div>
    <div class='panel-body'>  
        <div class='row'>  
            <div class='col-sm-2'>
                <label for='shift'>Shift</label>
                <select class='form-control' name='shift'>
                    <option value='' disabaled selected>Select Shift</option>
                <?php
                foreach($shifts_array as $shift){
                    echo "<option value='$shift'>$shift</option>";
                }
                ?>
                </select>
            </div>
        </div><br/><br/>
        <div class='row'>       
            <div class='col-sm-6'>
                <table class='table table-bordered'>
                    <tr><td>Style</td>   <td id='style'></td>    </tr>
                    <tr><td>Schedule</td><td id='schedule'></td> </tr>
                    <tr><td>Color</td>   <td id='color'></td>    </tr>
                </table>
            </div>
        </div>
        <div class='row'>
            <div class='col-sm-3'>
                <b>Enter Docket Number</b>
                <input type='text' class='form-control integer' value='' name='doc_no'> 
            </div>
        </div>
        <hr/>
        <div class='row' id='hide_details'>
            <div class='col-sm-2'>
               <label for='cut_table'>Cutting Table</label>
               <select class='form-control' id='cut_table'>
                    <option value='' disabled selected>Select Table</option>
                <?php
                    foreach($cut_tables as $id => $cut_table){
                        echo "<option value='$id'>$cut_table</option>";
                    }
                ?>
               </select>
            </div>
            <div class='col-sm-2'>
                <label for='cut_table'>Team Leader</label>
                <select class='form-control' id='team_leader'>
                    <option value='' disabled selected>Select Leader</option>
                <?php
                    foreach($team_leaders as $id => $leader_name){
                        echo "<option value='$id'>$leader_name</option>";
                    }
                ?>
                </select>
            </div><br/><br/>  

            <div class='row'>
                <table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>Docket</th>
                            <th>Cut Status</th>
                            <th>Planned Plies</th>
                            <th>Reported Plies</th>
                            <th>Report able Plies</th>
                            <th>Fabric Received</th>
                            <th></th>
                            <th></th><th></th><th></th><th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>  
            </div>
        </div>

        <div class='col-sm-12'>
           
        </div>
    </div>
</div>



<script>
    $(document).ready(function(){
        $('#hide_details').css({'display':'none'});
    });
</script>
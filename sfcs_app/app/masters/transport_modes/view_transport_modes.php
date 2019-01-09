<?php
    
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    
    

    $sql = "SELECT * FROM $bai_pro3.transport_modes order by sno";
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    $norows = mysqli_num_rows($sql_result);
    $sno = 1;
        if ($norows > 0) {
        echo "<table id='downtime_reason' class='table'><thead><tr><th>S.No</th><th>Transport Modes</th><th> Edit / Delete </th></tr></thead><tbody>";
        // output data of each row
        while($row=mysqli_fetch_array($sql_result)) {
            $rowid=$row["sno"];
            $code=$row["transport_mode"];
             

 
            $url=getFullURL($_GET['r'],'transport_modes_add.php','N');
            $url1=getFullURL($_GET['r'],'delete_transport_modes.php','N');
            
            echo "<tr><td>".$sno++."</td><td>".$row["transport_mode"]."</td>
            <td><a href='$url&tid=$rowid&transport_mode=$code' class='btn btn-warning btn-xs editor_edit'>Edit</a> / 
            <a href='$url1&tid=$rowid&transport_mode=$code'class='btn btn-danger btn-xs' onclick='return confirm_delete(event,this);'>Delete</a></td></tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "0 results";
    }
    ?>

 
<script>
$(document).ready(function() {
    $('#downtime_reason').DataTable();
} );

function confirm_delete(e,t)
    {
        e.preventDefault();
        var v = sweetAlert({
        title: "Are you sure to Delete the Record?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        buttons: ["No, Cancel It!", "Yes, I am Sure!"],
        }).then(function(isConfirm){
        if (isConfirm) {
        window.location = $(t).attr('href');
        return true;
        } else {
        sweetAlert("Request Cancelled",'','error');
        return false;
        }
        });
    }
</script>
<style>
table th
{
    border: 1px solid grey;
    text-align: center;
    background-color: #003366;
    color: WHITE;
    white-space:nowrap; 
    padding-left: 5px;
    padding-right: 5px;
}
table{
    white-space:nowrap; 
    border-collapse:collapse;
    font-size:12px;
    background-color: white;
}
table tr
{
    border: 1px solid grey;
    text-align: right;
    white-space:nowrap; 
}

table td
{
    border: 1px solid grey;
    text-align: center;
    white-space:nowrap;
    color:black;
}
</style>
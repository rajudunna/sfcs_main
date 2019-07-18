<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>

<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM $brandix_bts.`packing_team_master`";
$result = $conn->query($sql);
$sno =1;
$url=getFullURL($_GET['r'],'create_team.php','N');
if ($result->num_rows > 0) {
    echo "<div class='panel panel-primary'><div class='panel-heading'>View Packing Team Details</div><div class='panel-body'><form name ='delete'>";
    echo "<table id='table_one' class='table'><thead><tr><th>S.No</th><th>Packing Team</th><th>Team Leader</th><th>Status</th><th>Control</th></tr></thead><tbody>";
    while($row = $result->fetch_assoc()) {
		$rowid=$row["id"];
        $packing_team=$row["packing_team"];
        $team_leader=$row["team_leader"];
        $status=$row["status"];
      
        echo "<tr><td>".$sno++."</td><td>".$row["packing_team"]." </td><td>".$row["team_leader"]."</td><td>".$row["status"]."</td><td><a href='$url&row_id=$rowid&packing_team=$packing_team&team_leader=$team_leader&status=$status' class='btn btn-warning btn-xs editor_edit'>Edit</a></td></tr>";
    }
    echo "</tbody></table></form></div></div>";
} else {
    echo "0 results";
}
$conn->close();
?>

<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $('#table_one').DataTable();
});
    
</script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$plant_code = $_SESSION['plantCode'];
    $username = $_SESSION['userName'];
$sql = "SELECT id,packing_method_code,packing_description,smv,status FROM $mdm.`packing_method_master` order by id desc";
$result = $conn->query($sql);
$sno =1;
$url=getFullURL($_GET['r'],'create_packing.php','N');
if ($result->num_rows > 0) {
    echo "<div class='panel panel-primary'><div class='panel-heading'>View Packing Method Details</div><div class='panel-body'><form name ='delete'>";
    echo "<table id='table_one' class='table'><thead><tr><th>S.No</th><th>Packing Method Code</th><th>Packing Method Description</th><th>SMV</th><th>Status</th><th>Control</th></tr></thead><tbody>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$rowid=$row["id"];
        $packing_method_code=$row["packing_method_code"];
        $packing_description=$row["packing_description"];
        $smv=$row["smv"];
        $status=$row["status"];
        // if($status == 'active'){
        //     $cat_status = "Active";
        // }else{
        //     $cat_status = "In-Active";
        // }
        echo "<tr><td>".$sno++."</td><td>".$row["packing_method_code"]." </td><td>".$row["packing_description"]."</td><td>".$row["smv"]."</td><td>".$row["status"]."</td><td><a href='$url&row_id=$rowid&packing_method_code=$packing_method_code&packing_description=$packing_description&smv=$smv&status=$status' class='btn btn-warning btn-xs editor_edit'>Edit</a></td></tr>";
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
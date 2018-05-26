<?PHP
// include("dbconf.php");

$bai_rm_pj1="bai_rm_pj1";
$host="192.168.0.110:3326";

$user="baiall";
$password="baiall";


$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect1: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link, $bai_rm_pj1) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

// echo 'hai';
$label_id=$_POST["label"];
$sql="SELECT qty_allocated FROM $bai_rm_pj1.store_in WHERE tid='".$label_id."'";
$result1=mysqli_query($link, $sql);
$sql_rows=mysqli_num_rows($result1);
if($sql_rows>0)
while($row1=mysqli_fetch_array($result1))
{
	echo $qty_allocated=$row1["qty_allocated"];
	
}
else
{
	echo 'false';
}

?>

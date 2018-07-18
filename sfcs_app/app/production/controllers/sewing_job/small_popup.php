<head>
	<link rel="stylesheet" type="text/css" href="../../../../common/css/bootstrap.min.css">
	<title></title>
</head>
<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');

error_reporting(0);

$schedule=$_GET['schedule'];
$jobno=$_GET['jobno'];

$details="select * from $bai_pro3.packing_summary_input where input_job_no_random like '%$schedule%' and input_job_no='$jobno'";
$finaldet=mysqli_query($link, $details) or exit("Sql Error2");

echo "<div class='panel panel-primary'>";
echo "<div class='panle-heading'>Input Job Wise Details</div>";
echo "<div class='panel-body'>";

echo "<table class=\"table table-bordered\">";
echo "
<thead>
<tr>
<th>Size</th>
<th>Color</th>
<th>Quantity</th>
</tr>
</thead>";

		while($sql_row=mysqli_fetch_array($finaldet))
		{
			echo "<tr>";
			echo "<td>".$sql_row['size_code']."</td>";
			echo "<td>".$sql_row['order_col_des']."</td>";
			echo "<td>".$sql_row['carton_act_qty']."</td>";
			echo "</tr>";	
		}

echo "</table>";

echo "</div></div>";

?>
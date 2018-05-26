<html>
<head>
	 <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
  <link rel="stylesheet" href="cssjs/bootstrap.min.css">
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<body>
<?php
	include("..".getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
	include("..".getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
	$query_select = "select * from $brandix_bts.tbl_orders_ops_ref";
	$res_do_num=mysqli_query($link,$query_select);
	echo "<div class='container'><div class='panel panel-primary'><div class='panel-heading'>Operations List</div><div class='panel-body'>";
	echo "<table class='table table-bordered'>";
	echo "<thead><tr><th>S.No</th><th>Operation Name</th><th>Default Operation</th><th> Operation Code</th><th>Action</th></tr></thead><tbody>";
	$i=1;
	$url = getFullURLLevel($_GET['r'],'operations_master_edit.php',0,'N');
	while($res_result = mysqli_fetch_array($res_do_num)){
		//var_dump($res_result);
		
		echo "<tr>
		<td>".$i++."</td>
		<td>".$res_result['operation_name']."</td>
		<td>".$res_result['default_operation']."</td>
		<td>".$res_result['operation_code']."</td>";
		echo "<td><a href='$url&id=".$res_result['id']."' class='btn btn-info'>Edit</a></td>";
		echo "</tr>";
		
	}
	echo "</tbody></table></div></div></div>";
	
	
	?>
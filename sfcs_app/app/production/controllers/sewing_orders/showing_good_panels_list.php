<html>
<head>
	<title>Showing good panels list</title>
  <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
<!--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
   <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<!-- Latest compiled and minified CSS -->
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" href="cssjs/bootstrap.min.css">
<link rel="stylesheet" href="cssjs/select2.min.css">
<link rel="stylesheet" href="cssjs/font-awesome.min.css">
<script type="text/javascript" src="cssjs/jquery.min.js"></script>
<script type="text/javascript" src="cssjs/select2.min.js"></script>
<script src="cssjs/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
	<script>
	function reload_styles(){
        // console.log('welcome');
        var style_id=document.getElementById('style_id').value;
        var ajax_url ="showing_good_panels_list.php?style_id="+style_id;Ajaxify(ajax_url);

    }
	function reload_schedule(){
        var schedule_num=document.getElementById('schedule_id').value;
		var style_id=document.getElementById('style_id').value;
        var ajax_url ="showing_good_panels_list.php?style_id="+style_id+"&schedule="+schedule_num;Ajaxify(ajax_url);

    }
	function reload_color(){
		var style_id=document.getElementById('style_id').value;
        var schedule_num=document.getElementById('schedule_id').value;
		var color_num=document.getElementById('color_id').value;
        var ajax_url ="showing_good_panels_list.php?style_id="+style_id+"&schedule="+schedule_num+"&color="+color_num;
		Ajaxify(ajax_url);

    }
    function reload_cut_number(){
		var style_id=document.getElementById('style_id').value;
        var schedule_num=document.getElementById('schedule_id').value;
		var color_num=document.getElementById('color_id').value;
		var cut_num=document.getElementById('cut_id').value;
        var ajax_url ="showing_good_panels_list.php?style_id="+style_id+"&schedule="+schedule_num+"&color="+color_num+"&cut_num="+cut_num;
		Ajaxify(ajax_url);

    }
    function reload_size(){
		var style_id=document.getElementById('style_id').value;
        var schedule_num=document.getElementById('schedule_id').value;
		var color_num=document.getElementById('color_id').value;
		var cut_num=document.getElementById('cut_id').value;
		var size=document.getElementById('size_id').value;
        var ajax_url ="showing_good_panels_list.php?style_id="+style_id+"&schedule="+schedule_num+"&color="+color_num+
        "&cut_num="+cut_num+"&size="+size;Ajaxify(ajax_url);

    }

    </script>
	



<?php

include("dbconf.php");
$has_permission=haspermission($_GET['r']);

	$style = $_GET['style_id'];
	$schedule = $_GET['schedule'];
	$color = $_GET['color'];
	$cut_num = $_GET['cut_num'];
	$size = $_GET['size'];
	// echo $style;
	if($style!=''){
		$schedule_codes="select distinct trim(schedule) as schedule from tbl_emblishment_recover_panels where trim(style)='$style'";
	}else{
		$schedule_codes="select distinct trim(schedule) as schedule from tbl_emblishment_recover_panels";
	}
	$schedule_result=mysqli_query($link,$schedule_codes);

	/*getting color codes*/
	if(($style != '')&&($schedule != '')){
		$color_codes="select distinct trim(color) as color from tbl_emblishment_recover_panels where trim(style)='$style' and trim(schedule) = '$schedule' and bundle_generate = 'no'";
		// echo $color_codes;
	}else{
		$color_codes="select distinct trim(color) as color from tbl_emblishment_recover_panels where bundle_generate = 'no'";
	}
	$color_result=mysqli_query($link,$color_codes);

	if(($style != '')&&($schedule != '')&&($color != '')){
		
		
		$pcutno_qry="select distinct trim(cut_no) as cut_no from tbl_emblishment_recover_panels where trim(style)='$style' and trim(schedule) = '$schedule' and trim(color) = '$color' and bundle_generate = 'no'";
	}
	$cut_result=mysqli_query($link,$pcutno_qry);

	/*getting Size codes */
	if(($style != '')&&($schedule != '')&&($color != '')&&($cut_num != '')){
		
		
		$size_codes_query="select distinct trim(size) as size from tbl_emblishment_recover_panels where trim(style)='$style' and trim(schedule) = '$schedule' and trim(color) = '$color' and trim(cut_no) = '$cut_num'  and bundle_generate = 'no'";
	}
	$size_result=mysqli_query($link,$size_codes_query);

	/*getting Data */
	if(($style != '')&&($schedule != '')&&($color != '')&&($cut_num != '')&&($size != '') ){
		
		
		$sql_total_data = "select * from tbl_emblishment_recover_panels where trim(style)='$style' and trim(schedule) = '$schedule' and trim(color) = '$color' and trim(cut_no) = '$cut_num' and trim(size) = '$size'  and bundle_generate = 'no'";
	}
	//echo $ops_codes_query."</br>";
	// echo $sql_total_data;
	$total_data =mysqli_query($link,$sql_total_data);

	// var_dump($total_data);


?>


<body>
	<div class="bs-example">
		<div class="panel panel-primary">
		<div class="panel-heading"><strong>Creating Bundle : </strong></div>
		<div class="panel-body">
			<div class="bs-example">
		<form class="form-inline" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
			Style:
			<?php
						$query1 = 'select DISTINCT(style) as style from tbl_emblishment_recover_panels where bundle_generate = "no"';
						$style_result = mysqli_query($link,$query1); 
														// var_dump($style_result);
								// die();
						echo '<select class="form-control selectpicker" id="style_id" name="style_id" onchange="reload_styles();" data-live-search="true">
						      <option value="">Please Select</option>';
						if(mysqli_num_rows($style_result)>0){
							while($styles = mysqli_fetch_array($style_result)) {

								$style=$styles['style'];
								if(trim($style)==$_GET['style_id']){
								   echo "<option value=".$style." selected>".$style."</option>";
								}else{
									echo "<option value=".$style.">".$style."</option>";
								}
							}
							if(isset($_GET['style'])){
										$redirect_check1=1;
									}else{
										$redirect_check1=0;
									}
								if(mysqli_num_rows($style_result)==1 && $redirect_check1==0){
									// echo "<script>reload_styles();</script>";
								}
						}else{
							echo "No Styles Found";
						}
						echo "</select>";
			?>


			<div class="form-group">
					Schedule  : 
					<!--<input type="text" class="form-control" id="color_id" name="color_id" required>-->
					<?php
						echo '<select class="form-control selectpicker" id="schedule_id" name="schedule_id" onchange="reload_schedule();" data-live-search="true">
						      <option value="">Please Select</option>';

						if(mysqli_num_rows($schedule_result)>0){
							while($schedules = mysqli_fetch_array($schedule_result)) {
								$schedule_number=$schedules['schedule'];
							   // $style_id=$style_number;
								if(trim($schedule_number)==$_GET['schedule']){
								   echo "<option value=".$schedule_number." selected>".$schedule_number."</option>";
								}else{
									echo "<option value=".$schedule_number.">".$schedule_number."</option>";
								}
							}
							if(isset($_GET['schedule'])){
									$redirect_check=1;
								}else{
									$redirect_check=0;
								}
							if(mysqli_num_rows($schedule_result)==1 && $redirect_check==0){
								// echo "<script>reload_schedule();</script>";
							}
						}else{
							echo "No Styles Found";
						}
						echo "</select>";
					?>
			</div>


			<div class="form-group">
					Color  : 
					<!--<input type="text" class="form-control" id="color_id" name="color_id" required>-->
					<?php
						echo '<select class="form-control selectpicker" id="color_id" name="color_id" onchange="reload_color();" data-live-search="true">
						      <option value="">Please Select</option>';
						if(mysqli_num_rows($color_result)>0){
							while($colors = mysqli_fetch_array($color_result)) {
								$color_number=$colors['color'];
							   // $style_id=$style_number;
								if(trim($color_number)==$_GET['color']){
								   echo "<option value=".$color_number." selected>".$color_number."</option>";
								}else{
									echo "<option value=".$color_number.">".$color_number."</option>";
								}
							}
							if(isset($_GET['color'])){
									$redirect_check=1;
								}else{
									$redirect_check=0;
								}
							if(mysqli_num_rows($color_result)==1 && $redirect_check==0){
								// echo "<script>reload_color();</script>";
							}
						}else{
							echo "No Styles Found";
						}
						echo "</select>";
					?>
			</div>

			<div class="form-group">
					Cut Number  : 
					<!--<input type="text" class="form-control" id="color_id" name="color_id" required>-->
					<?php
						echo '<select class="form-control selectpicker" id="cut_id" name="cut_id" onchange="reload_cut_number();" data-live-search="true">
						      <option value="">Please Select</option>';
						if(mysqli_num_rows($cut_result)>0){
							while($cuts = mysqli_fetch_array($cut_result)) {
								$cut_number=$cuts['cut_no'];
							   // $style_id=$style_number;
								if(trim($cut_number)==$_GET['cut_num']){
								   echo "<option value=".$cut_number." selected>".$cut_number."</option>";
								}else{
									echo "<option value=".$cut_number.">".$cut_number."</option>";
								}
							}
							if(isset($_GET['cut_num'])){
									$redirect_check=1;
								}else{
									$redirect_check=0;
								}
							if(mysqli_num_rows($cut_result)==1 && $redirect_check==0){
								// echo "<script>reload_cut();</script>";
							}
						}else{
							echo "No Styles Found";
						}
						echo "</select>";
					?>
			</div>


			<div class="form-group">
					Size  : 
					<!--<input type="text" class="form-control" id="color_id" name="color_id" required>-->
					<?php
						echo '<select class="form-control selectpicker" id="size_id" name="size_id" onchange="reload_size();" data-live-search="true">
						      <option value="">Please Select</option>';
						if(mysqli_num_rows($size_result)>0){
							while($sizes = mysqli_fetch_array($size_result)) {
								$size_number=$sizes['size'];
							   // $style_id=$style_number;
								if(trim($size_number)==$_GET['size']){
								   echo "<option value=".$size_number." selected>".$size_number."</option>";
								}else{
									echo "<option value=".$size_number.">".$size_number."</option>";
								}
							}
							if(isset($_GET['size'])){
									$redirect_check=1;
								}else{
									$redirect_check=0;
								}
							if(mysqli_num_rows($size_result)==1 && $redirect_check==0){
								// echo "<script>reload_size();</script>";
							}
						}else{
							echo "No Styles Found";
						}
						echo "</select>";
					?>
			</div>
	</div>
	</div>
	
	</form>

<?php 
	if(isset($size) && $size != '' && isset($schedule) && $schedule != '' && isset($color) && $color != '' && isset($style) && $style != '' && isset($cut_num) && $cut_num != ''){


?>
	<form name="form2" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">

		<table id='table1' class="table table-bordered">
			<thead>
				<tr>
					<th>S.No</th>
					<th>Bundle Number</th>
					<th>Operation Code</th>
					<th>Style</th>
					<th>Schedue</th>
					<th>Color</th>
					<th>Good Panels</th>
					<th>Check</th>
			   </tr>
			</thead>
			<tbody>
			<?php 
				//$sql = 'select * from tbl_emblishment_recover_panels';
				$count = 0;
				// $resultset = mysqli_query($link,$sql);
				// var_dump(mysqli_num_rows($resultset));
				if(mysqli_num_rows($total_data)>0){
					while($row = mysqli_fetch_array($total_data))
					{
						$data = '<tr><td>'.++$count.'</td>';
						$data.='<td>'.$row['bundle_number'].'</td>';
						$data.='<td>'.$row['operation_code'].'</td>';
						$data.='<td>'.$row['style'].'</td>';
						$data.='<td>'.$row['schedule'].'</td>';
						$data.='<td>'.$row['color'].'</td>';
						$data.='<td>'.$row['good_panels'].'</td>';
						$data.='<td><input type="checkbox" name="chk['.$row['id'].']" ></td>';
						echo $data.'</tr>';
						// echo '<input type="hidden" value="'.$row['bundle_number'].'*'.$row['opeartion_code'].'" id="count[]" name="count">';
					
					}
				}else{
					echo 'Error no data found';
				}
			?>
			<!-- <tr><td colspan=8> -->
			<!-- </tr> -->
			</tbody>
		</table>
		<input type="submit" value="submit" id="submit" name="submit">
		
	</form>
<?php } ?>
</body>


</html>

<?php
	if (isset($_POST['submit'])) {
		
		$checked_ids = $_POST['chk'];
		// var_dump($checked_ids);
		foreach ($checked_ids as $key => $value) {
			$bundle_creation_sql = "select * from tbl_emblishment_recover_panels where id= '$key'";

			$bundle_creation_data =mysqli_query($link,$bundle_creation_sql);

			// $good_panels = 0;
			$main_ids[] = $key;
			while ($row_data = mysqli_fetch_array($bundle_creation_data)) {
				// var_dump($row_data);
				// die();
				$style = $row_data['style'];
				$schedule = $row_data['schedule'];
				$color = $row_data['color'];
				$cut_num = $row_data['cut_no'];
				$size = $row_data['size'];
				$bundle_number_id = $row_data['bundle_number'];
				$operation_code = $row_data['operation_code'];

				$good_panels += $row_data['good_panels'];
			}
		}
		$new_bundle_number = "select max(bundle_number)+1 as bundle_number from bundle_creation_data";
		$new_bundle_number =mysqli_query($link,$new_bundle_number);

		while ($row_data1 = mysqli_fetch_array($new_bundle_number)) {
			
			$new_bundle_num = $row_data1['bundle_number'];
		}

		$old_bundle_data = "select * from bundle_creation_data where bundle_number = '$bundle_number_id' and operation_id = '$operation_code'";

		$old_bundle_data1 =mysqli_query($link,$old_bundle_data);

		while ($row_data2 = mysqli_fetch_array($old_bundle_data1)) {
			// var_dump($row_data2);
			$size_id = $row_data2['size_id'];
			$op_sequence = $row_data2['operation_sequence'];
			$ops_dependency = $row_data2['ops_dependency'];
			$docket_number = $row_data2['docket_number'];
		}
		// var_dump($good_panels);
		// var_dump($new_bundle_num);

		$sql_update_old_bundle_status = "UPDATE tbl_emblishment_recover_panels SET bundle_generate='yes' WHERE id IN (".implode(",",$main_ids).") ";

		// echo $sql_update_old_bundle_status;
		$data_save001 =mysqli_query($link,$sql_update_old_bundle_status);
		$data_save = false;
		if($data_save001){

		$old_bundle_op_data = "select operation_id from bundle_creation_data where bundle_number = '$bundle_number_id' and operation_id >= '$operation_code'";

		$old_bundle_op_data1 =mysqli_query($link,$old_bundle_op_data);

			while ($row_op_data2 = mysqli_fetch_array($old_bundle_op_data1)) {

				$sql_new_bundle_add = "INSERT INTO bundle_creation_data(cut_number, style, schedule, color, size_id, size_title, bundle_number,  original_qty, send_qty, recevied_qty,operation_id, operation_sequence, ops_dependency, docket_number, bundle_status, sewing_order_status) values('".$cut_num."', '".$style."', '".$schedule."', '".$color."', '".$size_id."', '".$size."', '".$new_bundle_num."', 0, '".$good_panels."', 0, '".$row_op_data2['operation_id']."', '".$op_sequence."', '".$ops_dependency."', '".$docket_number."', 'OPEN', 'No')";

				// echo $sql_new_bundle_add;

				$data_save =mysqli_query($link,$sql_new_bundle_add);
			}
		}

		// var_dump($data_save);
		if($data_save){
			header("Location: showing_good_panels_list.php?Message=true");
			// echo "Data Saved Successfully.....";
		}else {
			header("Location: showing_good_panels_list.php?Message=false");

			echo "Error! Data Not Saved";
		}
		// }
	}

?>
<?php
	if (isset($_GET['Message'])) {
		// echo $_GET['Message'];
		if($_GET['Message'] == 'true'){
			// echo "<p>Data Saved Successfully.....</p>";
			echo '<div class="alert alert-success">
			  <strong>Success!</strong> Data Saved Successfully.....
			</div>';
		}elseif($_GET['Message'] == 'false') {
			// echo "Error! Data Not Saved, Contact IT Team..";
			echo '<div class="alert alert-danger">
			  <strong>Error!</strong> Data Not Saved, Contact IT Team..
			</div>';
		}
	}
?>
<style>
table{
	align : center;
	width : 80%;
	height : auto;
	border : 1px solid black;
}
td{
	text-align : center;
}
tr{
	border : 1px solid black;
}
#push{
	float : right;
	display : block;
	background: orange;
	width : 50px;
	border-radius : 2px;
	height : 25px;

}
</style>

	<title>Add New Operation</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
	<!-- <link rel="stylesheet" href="cssjs/bootstrap.min.css"> -->
	<!-- <script src="js/jquery-3.2.1.min.js"></script> -->
	<!-- <script src="js/bootstrap.min.js"></script> -->
  	<script type="text/javascript">
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
	<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'Alpha/anu/incentives/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'Alpha/anu/incentives/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>

  <!--<link rel="stylesheet" href="cssjs/bootstrap.min.css">
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>-->
<body>
<!--Added 	(1)Delete button for every operation 
			(2)semi-garment form
	by Theja on 07-02-2018
-->     
<?php 
	include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
	$has_permission=haspermission($_GET['r']);
	$qry_short_codes = "SELECT * from $brandix_bts.ops_short_cuts";
	$result_oper = $link->query($qry_short_codes);
?>
<div class="container">
	<?php 
		if(in_array($authorized,$has_permission))
		{ ?>
			<div class="panel panel-primary">
				<div class="panel-heading">
					 Add Bundle Operation
				</div>
				<div class="panel-body">
					<div class="alert alert-danger" style="display:none;">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Info! </strong><span class="sql_message"></span>
					</div>
					<div class="form-group">
						<form name="test" action="index.php?r=<?php echo $_GET['r']; ?>" method="POST" id='form_submt'>
							<div class="row">
								<div class="col-sm-2">
									<b>Operation Name<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'></font></span></b><input type="text" class="form-control" id="opn" name="opn" required>
								</div> 
								<div class="col-sm-2">
									<b>Operation code<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'></font></span></b><input type="number" onkeypress="return validateQty(event);" min="400" class="form-control" id="opc" name="opc" required>
								</div>
								<div class='col-sm-2'>
									 <div class="dropdown">
										<b>Type</b>
										<select class="form-control" id="sel" name="sel" required>
											<option value='Panel' selected>Panel</option>
											<option value='SGarment' >Semi Garment</option>
											<option value='Garment' >Garment</option>
										</select>	
									</div>
								</div>
								<div class="col-sm-2">
									<b>Sewing Order Code</b><input type="text" class="form-control" id="sw_cod" name="sw_cod">
								</div>
								<div class = "col-sm-2">
								<label for="style">Short Key Code<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>			
									<select id="short_key_code" style="width:100%;" name="short_key_code" class="form-control">
									<option value='0'>Select Short Code</option>
									<?php				    	
										if ($result_oper->num_rows > 0) {
											while($row = $result_oper->fetch_assoc()) {
											$row_value = $row['short_key_code'];
												echo "<option value='".$row['short_key_code']."'>".$row_value."</option>";
											}
										} else {
											echo "<option value=''>No Data Found..</option>";
										}
									?>
								</select>

								</div>
								<div class="col-sm-2">
									<button type="submit"  class="btn btn-primary" style="margin-top:18px;">Save</button>
								</div>
								<div class="col-sm-2">
									 <div class="dropdown" hidden='true'>
										<b>Report To ERP</b>
										<select class="form-control" id="sel1" name="sel1" required>
										<option value="">Please Select</option><option value='yes'>Yes</option><option value='No' selected>No</option></select>	
									</div>
								</div>
								 
							</div>
						</form>
					</div>	
				</div>
			</div>	<?php	
		}
	?>
</div>
<?php
	$operation_name = "";
	$default_operation = "";
	$operation_code = "";
	$sw_cod="";

	if(isset($_POST["opn"])){
		$operation_name= $_POST["opn"];
	}
	if(isset($_POST["sel1"])){
		$default_operation= $_POST["sel1"];
	}
	if(isset($_POST["opc"])){
		$operation_code= $_POST["opc"];
	}
	if(isset($_POST["sel"])){
		$type = $_POST["sel"];
	}
	if(isset($_POST["sw_cod"])){
		$sw_cod = $_POST["sw_cod"];
	}
	if(isset($_POST["short_key_code"])){
		$short_key_code = $_POST["short_key_code"];
	}
	
	/* $servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "brandix";
	// $conn = new mysqli($servername, $username, $password, $dbname);
	$conn = mysql_connect($servername, $username, $password);
	mysql_select_db($dbname,$conn);
	if (!$conn) {
		die("Connection failed: " . mysql_error());
	} */
	if($operation_name!="" && $operation_code!="" && $short_key_code != "")
	{
		$checking_qry = "select count(*)as cnt from $brandix_bts.tbl_orders_ops_ref where operation_code = $operation_code";
		$res_checking_qry = mysqli_query($link,$checking_qry);
		while($res_res_checking_qry = mysqli_fetch_array($res_checking_qry))
		{
			$cnt = $res_res_checking_qry['cnt'];
		}
		$short_key_code_check_qry = "select count(*) as cnt from $brandix_bts.tbl_orders_ops_ref where short_cut_code = '$short_key_code'";
		$res_short_key_code_check_qry = mysqli_query($link,$short_key_code_check_qry);
		while($res_res_res_short_key_code_check_qry = mysqli_fetch_array($res_short_key_code_check_qry))
		{
			$cnt_short = $res_res_res_short_key_code_check_qry['cnt'];
		}
		if($cnt == 0 && $cnt_short == 0)
		{
			$qry_insert = "INSERT INTO $brandix_bts.tbl_orders_ops_ref ( operation_name, default_operation,operation_code, type, operation_description,short_cut_code)VALUES('$operation_name','$default_operation','$operation_code', '$type', '$sw_cod','$short_key_code')";
			$res_do_num = mysqli_query($link,$qry_insert);
			echo "<script>sweetAlert('Saved Successfully','','success')</script>";
		}
		else if($cnt != 0)
		{
			$sql_message = 'Operation Code Already in use. Please give other.';
			echo '<script>$(".sql_message").html("'.$sql_message.'");$(".alert").show();</script>';
		}
		else if($cnt_short != 0)
		{
			$sql_message = 'Short Cut Key Code Already in use. Please give other.';
			echo '<script>$(".sql_message").html("'.$sql_message.'");$(".alert").show();</script>';
		}
		else if($cnt_short != 0 && $cnt != 0)
		{
			$sql_message = 'Short Key Code and Operation Code Already in use. Please give other.';
			echo '<script>$(".sql_message").html("'.$sql_message.'");$(".alert").show();</script>';
			die();
		}
	}
	$query_select = "select * from $brandix_bts.tbl_orders_ops_ref";
	$res_do_num=mysqli_query($link,$query_select);
	echo "<div class='container'><div class='panel panel-primary'><div class='panel-heading'>Operations List</div><div class='panel-body'>";
	echo "<div class='table-responsive'><table class='table table-bordered' id='table_one'>";
	echo "<thead><tr><th style='text-align:  center;'>S.No</th><th style='text-align:  center;'>Operation Name</th><th style='text-align:  center;'>Report To ERP</th><th style='text-align:  center;'>Operation Code</th><th style='text-align:  center;'>Form</th><th>Short Key Code</th><th style='text-align:  center;'>Action</th></tr></thead><tbody>";
	$i=1;
	while($res_result = mysqli_fetch_array($res_do_num)){
		//var_dump($res_result);
		//checking the operation scanned or not
		$ops_code = $res_result['operation_code'];
		$query_check = "select count(*)as cnt from $brandix_bts.tbl_style_ops_master where operation_code = $ops_code";
		$res_query_check=mysqli_query($link,$query_check);
		while($result = mysqli_fetch_array($res_query_check))
		{
			$count = $result['cnt'];
		}
		if($count == 0)
		{
			$flag = 1;
		}
		else
		{
			$flag = 0;
		}
		echo "<tr>
			<td>".$res_result['id']."</td>
			<td>".$res_result['operation_name']."</td>
			<td>".$res_result['default_operation']."</td>
			<td>".$res_result['operation_code']."</td>
			<td>".$res_result['type']."</td>
			<td>".$res_result['short_cut_code']."</td>";
			if($res_result['default_operation'] == 'No' && $flag == 1)
			{
				$eurl = getFullURLLevel($_GET['r'],'operations_master_edit.php',0,'N');
				$url_delete = getFullURLLevel($_GET['r'],'operations_master_delete.php',0,'N').'&del_id='.$res_result['id'];
				if(in_array($edit,$has_permission)){ echo "<td><a href='$eurl&id=".$res_result['id']."' class='btn btn-info'>Edit</a>"; } 
				if(in_array($delete,$has_permission)){ 
					echo "<a href='$url_delete' class='btn btn-danger confirm-submit' id='del' >Delete</a></td>";
				}
			}
			else
			{
				echo "<td></td>";
			}
		echo "</tr>";
	}
	echo "</tbody></table></div></div></div></div>";
?>
</body>
</div>
<script language="javascript" type="text/javascript">
//<![CDATA[	
	var table2_Props = 	{					
					display_all_text: " [ Show all ] ",
					btn_reset: true,
					bnt_reset_text: "Clear all ",
					rows_counter: true,
					rows_counter_text: "Total Rows: ",
					alternate_rows: true,
					sort_select: true,
					loader: true
				};
	setFilterGrid( "table_one",table2_Props );
//]]>		
</script>
<script>
 function deleting_confirm(id){
	var url = "<?php echo getFullURLLevel($_GET['r'],'operations_creation.php',0,'N');?>&del_id="+id;
	 console.log("working");
     sweetAlert({
         title: "Are you sure?",
         text: "You will not be able to recover this imaginary file!",
         icon: "warning",
         buttons: [
           'No, cancel it!',
           'Yes, I am sure!'
         ],
         dangerMode: true,
       }).then(function(isConfirm) {
         if (isConfirm) {
           sweetAlert({
             title: 'Shortlisted!',
             text: 'Candidates are successfully shortlisted!',
             icon: 'success',
           })
		   window.location.href=url;
		   //.then(function() {
             // form.submit();
           // });
         // } else {
           // sweetAlert("Cancelled", "Your imaginary file is safe :)", "error");
         // }
       }
	});
 }
 </script>
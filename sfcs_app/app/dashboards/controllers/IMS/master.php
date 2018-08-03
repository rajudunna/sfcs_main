
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
	include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	$has_permission=haspermission($_GET['r']);
?>
<?php
if (isset($_GET['del_id'])) 
	    {
		    echo "<h3 style='color:red;text-align:center;'>Please Wait!!!  While Redirecting to page !!!</h3>";
			$id = $_GET['del_id'];
			$deleteQuery = "DELETE FROM $brandix_bts.tbl_ims_ops WHERE id=".$id;
			$deleteReply = mysqli_query($link,$deleteQuery);
			// mysql_query($deleteQuery, $link) or exit("Problem Deleting the Operation/".mysql_error());
			if ($deleteReply==1) {?>
				<script type="text/javascript">
					sweetAlert("Sucessfully Deleted the Operation","","success");
					window.location.href="<?= getFullURLLevel($_GET['r'],'master.php',0,'N'); ?>";
					exit();
				</script>
			<?php	}else{	?>
				<script type="text/javascript">
					alert("Falied to delete the Operation");
					window.location.href="<?= getFullURLLevel($_GET['r'],'master.php',0,'N'); ?>";						
				</script>
			<?php }
	    }
?>
<?php
if(isset($_POST['submit']))
{
	//var_dump($_POST['opn']);
	$details=explode('|',$_POST['opn']);
	//var_dump($details);
	$operation_name=$details[1];
	$operation_code=$details[0];

	// echo $operation_name."<br>";
	// echo $operation_code."<br>";
	
	$already_query = "delete from $brandix_bts.tbl_ims_ops ";
	$already_result = mysqli_query($link,$already_query);
	
	    $insert_query = "INSERT INTO $brandix_bts.tbl_ims_ops (operation_name,operation_code) VALUES('$operation_name','$operation_code')";
	    $res_do_num = mysqli_query($link,$insert_query);

	echo "<script>sweetAlert('Saved Successfully','','success')</script>";
}

?>

<div class="container">

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
						<form name="test" class="form-inline" action="index.php?r=<?php echo $_GET['r']; ?>" method="POST" id='form_submt'>
							<!-- <div class="row"> -->
								<div class="form-group">
									<b>Operation Name<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'></font></span></b>
									<select class="form-control" id="opn" name="opn" required>
										<option value="">Select</option>
									
									<?php
										$get_operations="SELECT operation_code,operation_name FROM $brandix_bts.tbl_orders_ops_ref where operation_code not in (10,15,129,200) group by operation_code order by operation_code";
										$result=mysqli_query($link,$get_operations);
										while ($test = mysqli_fetch_array($result))
										{
											echo '<option value="'.$test['operation_code'].'|'.$test['operation_name'].'">'.$test['operation_name'].' - '.$test['operation_code'].'</option>';
										}
									?>
									</select>
									<!-- <input type="text" class="form-control" id="opn" name="opn" required> -->
								</div> 
								<!-- <div class="col-sm-2">
									<b>Operation code<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'></font></span></b>
									<input type="text" onkeypress="return validateQty(event);" class="form-control integer" id="opc" name="opc" required>
								</div> -->
								<div class="form-group">
									<!-- <br> -->
									<input type="submit" name="submit" id="submit" class="btn btn-success" value="Save">
								</div>		
							<!-- </div> -->
						</form>
					</div>	
				</div>
			</div>	
</div>
<?php


	$query_select = "select * from $brandix_bts.tbl_ims_ops";
	$res_do_num=mysqli_query($link,$query_select);
	echo "<div class='container'><div class='panel panel-primary'><div class='panel-heading'>Operations List</div><div class='panel-body'>";
	echo "<div class='table-responsive'><table class='table table-bordered' id='table_one'>";
	echo "<thead><tr><th style='text-align:  center;'>S.No</th><th style='text-align:  center;'>Operation Name</th><th style='text-align:  center;'>Operation Code</th></tr></thead><tbody>";
	$i=1;
	while($res_result = mysqli_fetch_array($res_do_num))
	{
		//var_dump($res_result);
		//checking the operation scanned or not
		// $ops_code = $res_result['operation_code'];
		// $query_check = "select count(*)as cnt from $brandix_bts.tbl_style_ops_master where operation_code = $ops_code";
		// $res_query_check=mysqli_query($link,$query_check);
		// while($result = mysqli_fetch_array($res_query_check))
		// {
		// 	$count = $result['cnt'];
		// }
		
		echo "<tr>
			<td>".$i++."</td>
			<td>".$res_result['operation_name']."</td>
			<td>".$res_result['operation_code']."</td>";

				// $eurl = getFullURLLevel($_GET['r'],'edit_delete.php',0,'N');
				// $url_delete = getFullURLLevel($_GET['r'],'master.php',0,'N').'&del_id='.$res_result['id'];
				// if(in_array($edit,$has_permission)){ echo "<td><a href='$eurl&id=".$res_result['id']."' class='btn btn-info'>Edit</a></td>"; } 
				// if(in_array($delete,$has_permission)){ 
				// 	echo "<td><a href='$url_delete' class='btn btn-danger confirm-submit' id='del' >Delete</a></td>";
				// }
			
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
	var url = "<?php echo getFullURLLevel($_GET['r'],'master.php',0,'N');?>&del_id="+id;
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


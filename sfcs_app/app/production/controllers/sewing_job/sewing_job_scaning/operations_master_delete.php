<?php
	include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
	
	if (isset($_GET['del_id'])) 
	{
        echo "<h3 style='color:red;text-align:center;'>Please Wait!!!  While Redirecting to page !!!</h3>";
		$id = $_GET['del_id'];
		$deleteQuery = "DELETE FROM $brandix_bts.tbl_orders_ops_ref WHERE id=".$id;
		$deleteReply = mysqli_query($link,$deleteQuery);
		// mysql_query($deleteQuery, $link) or exit("Problem Deleting the Operation/".mysql_error());
		if ($deleteReply==1) {?>
			<script type="text/javascript">
				sweetAlert("Sucessfully Deleted the Operation","","success");
				window.location.href="<?= getFullURLLevel($_GET['r'],'operations_creation.php',0,'N'); ?>";
				exit();
			</script>
		<?php	}else{	?>
			<script type="text/javascript">
				alert("Falied to delete the Operation");
				window.location.href="<?= getFullURLLevel($_GET['r'],'operations_creation.php',0,'N'); ?>";						
			</script>
		<?php }
	}


?>
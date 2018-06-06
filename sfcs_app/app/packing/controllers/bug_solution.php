<?php
include("../".getFullURLLevel($_GET['r'],'common/config/config.php', 3,'R'));

?>
<script>
	function check_sch() {
		var sch = document.getElementById('schedule').value;
		if(sch=='')
		{
			sweetAlert('Please Enter Schedule Number','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}
</script>
<?php

function check_style($string)
{
	$check=0;
	for ($index=0;$index<strlen($string);$index++) {
    	if(isNumber($string[$index]))
		{
			$nums .= $string[$index];
		}
     	else    
		{
			$chars .= $string[$index];
			$check=$check+1;
			if($check==2)
			{
				break;
			}
		}
       		
			
	}
	return $nums;
}

?> 



<link href="style.css" rel="stylesheet" type="text/css" />  
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R') ); ?>

<div class="panel panel-primary">
<div class="panel-heading">Enable Print Labels</div>
<div class="panel-body">
<?php //include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'menu_content.php','R') ); ?>

<?php


echo '<form name="input" method="post" action="'.getFullURL($_GET['r'],'bug_solution.php','N').'">
<div class="form-group"><div class="col-md-2"><label>Enter Schedule No: </label><input type="text" name="schedule" id="schedule" value="" class="form-control integer" ></div></div><input type="submit" name="submit" value="Enable Print Labels" onclick="return check_sch();" class="btn btn-danger" style="margin-top:22px;"></form>';
?>

<?php

if(isset($_POST['submit']))
{
	$schedule=$_POST['schedule'];
	
	$sql="insert ignore into $bai_pro3.bai_orders_db_confirm select * from $bai_pro3.bai_orders_db where order_del_no=$schedule";
	//echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="update $bai_pro3.bai_orders_db_confirm set carton_print_status=NULL where order_del_no=$schedule";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="select order_style_no, order_del_no from $bai_pro3.bai_orders_db_confirm where style_id=\"\" and order_del_no=$schedule";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$sql1="update $bai_pro3.bai_orders_db_confirm set style_id=\"".check_style($sql_row['order_style_no'])."\" where order_del_no=\"".$sql_row['order_del_no']."\"";
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	echo "<br><div class='alert alert-success' role='alert'>Successfully Updated!!</div>";
}

?>
</div>
</div>

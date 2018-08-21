
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));?> 
<?php  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R')); 	  
$view_access=user_acl("SFCS_0092",$username,1,$group_id_sfcs); 
?> 

<script>

	function firstbox()
	{
		var ajax_url ="<?= getFullURLLevel($_GET['r'],'mix_jobs_delete.php',0,'N'); ?>&style="+document.test.style.value;Ajaxify(ajax_url);

	}

	function secondbox()
	{
		var ajax_url ="<?= getFullURLLevel($_GET['r'],'mix_jobs_delete.php',0,'N'); ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value;
		Ajaxify(ajax_url);

	}

	function thirdbox()
	{
		var ajax_url ="<?= getFullURLLevel($_GET['r'],'mix_jobs_delete.php',0,'N'); ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value;
		Ajaxify(ajax_url);

	}
	</script>

<div class="panel panel-primary">
	<div class="panel-heading">Mixed Schedule : Job Segregation Panel (PO Level)</div>
	<div class="panel-body">
	<form name="test" method="post" action="<?= getFullURLLevel($_GET['r'],'mix_jobs_delete.php',0,'N') ?>">

	<?php
		$style=$_GET['style'];
		$schedule=$_GET['schedule']; 
		$color=$_GET['color'];
		$po=$_GET['po'];

		if(isset($_POST['submit']))
		{
			$style=$_POST['style'];
			$schedule=$_POST['schedule']; 
			$color=$_POST['color'];
			$po=$_POST['po'];
		}
		echo "<div class='row'><div class='col-md-3'>";
		echo "Select Style: <select class=\"form-control\" name=\"style\" onchange=\"firstbox();\" required>";
		//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
		//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
		//{
			$sql="select distinct order_style_no from $bai_pro3.bai_orders_db_confirm where order_joins ='2' order by order_style_no";	
		//}
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);
		echo "<option value=''>Please Select</option>";
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
			{
				echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
			}
			else
			{
				echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
			}
		}

		echo "</select></div>";
	?>
	<?php
		echo"<div class='col-md-3'>";
		echo "Select Schedule: <select name=\"schedule\" class=\"form-control\" onchange=\"secondbox();\" required>";

		//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
		//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
		//{
			$sql="select distinct order_del_no from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_joins ='2' order by order_date";	
		//}
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);
		echo "<option value=''>Please Select</option>";
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule))
			{
				echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
			}
			else
			{
				echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
			}
		}
		echo "</select></div>";
		echo"<div class='col-md-3'>";

		echo "Select Color: <select class=\"form-control\" name=\"color\" onchange=\"thirdbox();\" required>";
		$sql="select distinct order_col_des from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_joins ='2'";
		//}
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);
		echo "<option value=''>Please Select</option>";
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color))
			{
				echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
			}
			else
			{
				echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
			}
		}
		echo "</select></div>";
		echo"<div class='col-md-3'>";
			echo "<label></label><br/><input type=\"submit\"  class='btn btn-success' value=\"Clear\" name=\"clear\"  id=\"clear\"/>";
	?>
	</form>
</div>

<?php

if(isset($_POST['clear']))
{
	$order_del_no=$_POST['schedule'];
	$order_joins='J'.$order_del_no;
	$style=$_POST['style'];
	$color=$_POST['color'];
	$docs=array();
	$sql="select * from $bai_pro3.plandoc_stat_log where order_tid like \"%".$schedule."%\"";
	$sql_result451=mysqli_query($link, $sql) or die("Error 1 ".$sql451.mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result451)>0)
	{
		while($sql_row457=mysqli_fetch_array($sql_result451))
		{		
			$docs[]=$sql_row457["doc_no"];
		}
		$sql4533="select order_tid from $bai_pro3.bai_orders_db_confirm where order_joins='".$order_del_no."' and order_col_des=\"".$color."\"";
		$sql_result4533=mysqli_query($link, $sql4533) or die("Error 2".$sql4533.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row4533=mysqli_fetch_array($sql_result4533))
		{
			$order_tids[]=$sql_row4533["order_tid"];
		}
		$sql32="select * from $brandix_bts.tbl_miniorder_data where docket_number in (select doc_no from $bai_pro3.plandoc_stat_log where org_doc_no in (".implode(",",$docs)."))";
		$sql_result451=mysqli_query($link, $sql32) or die("Error 3".$sql451.mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result451)==0)
		{
			$sql4536="delete from $bai_pro3.allocate_stat_log where order_tid in ('".implode("','",$order_tids)."')";
			//echo $sql4536."<br>";
			$sql_result4536=mysqli_query($link,$sql4536) or die("Error 4".$sql4533.mysqli_error($GLOBALS["___mysqli_ston"]));
			
			// $sql323="slect * from brandix_bts.tbl_cut_size_master where preant_id in (slect id from brandix_bts.tbl_cut_master where doc_no in (slect doc_no from bai_pro3.plando_stat_log where org_doc_no in (".implode(",",$docs).")))";
			// $sql_result4513=mysql_query($sql323,$link) or die("Error".$sql451.mysql_error());
						
			// $sql43="slect * from brandix_bts.tbl_cut_master where doc_no in (slect doc from bai_pro3.plando_stat_log where org_doc_no in (".implode(",",$docs)."))";
			// $sql_result4514=mysql_query($sql43,$link) or die("Error".$sql451.mysql_error());
			
			$sql1="delete from $bai_pro3.plandoc_stat_log where org_doc_no in (".implode(",",$docs).")";
			//echo $sql1."<br>";
			$sql_result4513=mysqli_query($link,$sql1) or die("Error 4".$sql4533.mysqli_error($GLOBALS["___mysqli_ston"]));

			$sql1="update $bai_pro3.plandoc_stat_log set org_doc_no ='0' where doc_no in (".implode(",",$docs).")";
			//echo $sql1."<br>";
			$sql_result4513=mysqli_query($link,$sql1) or die("Error 4".$sql4533.mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql45331="update $bai_pro3.bai_orders_db set order_joins='1' where order_del_no='".$order_del_no."' and order_col_des=\"".$color."\"";
			$sql_result45313=mysqli_query($link, $sql45331) or die("Error 4".$sql4533.mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql45331="update $bai_pro3.bai_orders_db_confirm set order_joins='1' where order_del_no='".$order_del_no."' and order_col_des=\"".$color."\"";
			$sql_result45313=mysqli_query($link, $sql45331) or die("Erro 5r".$sql4533.mysqli_error($GLOBALS["___mysqli_ston"]));

			echo "<script>swal('Sewing Jobs are Deleted.Please split Jobs again','','warning');</script>";
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
			function Redirect() {
				location.href = \"".getFullURLLevel($_GET['r'], 'mix_jobs_delete.php',0,'N')."\";
				}
			</script>";
						
		}
		else
		{
			echo "<script>swal('Sewing Jobs are preapred please delete and try again.','','warning');</script>";
		}
	}
}
?>
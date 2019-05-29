<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));  

  ?>

<script type="text/javascript">
	function pop_check()
	{
		if($('#course').val() == '' )
		{
			sweetAlert('Please enter Recut Docket Number','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}

</script>


<title>Recut Docket</title>

<script type="text/javascript">
	function goFurther(){
		if (document.getElementById("option").checked == true)
		{
			document.getElementById("put").disabled = false;
		}else{
			document.getElementById("put").disabled = true;
		}
	}
</script>


<body>
<?php 
?>

<div class="panel panel-primary">
<div class="panel-heading">Recut Docket </div>
<div class="panel-body">

<form method="post" name="input2" action="index.php?r=<?php echo $_GET['r']; ?>">
<div class="row">
<div class="col-md-3">
<label>Enter Recut Docket: </label>
<input type="text" id="course" name="recut" class="form-control textbox alpha" />
</div>
<input type="submit" id="submit" style="margin-top:22px;" name="submit" class="btn btn-success"  onclick='return pop_check();' value="Search">
</div>
</form>

<?php


if(isset($_POST['submit']))
{
	$recut=$_POST['recut'];
}
else
{
	$recut=$_GET['recut'];
}


if(isset($_POST['submit']))
{
	$recut=$_POST['recut'];
	$check_status=1;
    $sql_query="select recut_id,status from $bai_pro3.recut_v2_child_issue_track where recut_id=\"".$recut."\" order by status";
    $sql_query_result=mysqli_query($link, $sql_query) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num_rows=mysqli_num_rows($sql_query_result);
	if($num_rows !='0')
	{
		while($sql_row_value=mysqli_fetch_array($sql_query_result))
		{
			if($check_status==1)
			{
				$sql="select order_tid from $bai_pro3.plandoc_stat_log where doc_no=\"".$recut."\" ";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num_rows=mysqli_num_rows($sql_result);
				echo "<table class='table table-bordered'>";
				echo "<tr><th>Style</th><th>Schedule</th><th>Color</th></tr>";
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$order_tid=$sql_row['order_tid'];
				
				}
				$sql1="select * from $bai_pro3.bai_orders_db where order_tid=\"".$order_tid."\"";
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2=".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1=mysqli_fetch_array($sql_result1))
				{
					$order_style_no=$sql_row1['order_style_no'];
					$order_del_no=$sql_row1['order_del_no'];
					$order_col_des=$sql_row1['order_col_des'];
					
				}
				echo "<tr><td>".$order_style_no."</td><td>".$order_del_no."</td><td>".$order_col_des."</td></tr>";
				echo "</table>";
				$check_status=2;
			}	
			echo "<table class='table table-bordered'><tr><th>".$sql_row_value['status']."</th><th rospan=3>You are going to take bundle print</th>";
			if($barcode_4x2=='yes')
			{
				$url = getFullURLLevel($_GET['r'],'sewing_job/recut_prints/barcode_4_2.php',2,'R');
				$url = getFullURLLevel($_GET['r'],'sewing_job/recut_prints/barcode_4_2.php',2,'R');
				echo "<td><a class='btn btn-info btn-sm' href='$url?recut_id=".$recut."&sticker_type=1&sequence=".$sql_row_value['status']."' onclick=\"return popitup2('$url?recut_id=".$recut."&sticker_type=1')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Print With Operation 4*2</a></td>";
				$url2 = getFullURLLevel($_GET['r'],'sewing_job/reprint_tagwithout_operation.php',2,'R');
				echo "<td><a class='btn btn-info btn-sm' href='$url?recut_id=".$recut."&sticker_type=2sequence=".$sql_row_value['status']."' onclick=\"return popitup2('$url?recut_id=".$recut."&sticker_type=2')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Print With Out Operation 4*2</a></td>";
				echo "</tr>";
			}
			else if($barcode_2x1=='yes')
			{
				$url1 = getFullURLLevel($_GET['r'],'sewing_job/recut_prints/barcode_2_1.php',2,'R');
				$url1 = getFullURLLevel($_GET['r'],'sewing_job/recut_prints/barcode_2_1.php',2,'R');
				echo "<td><a class='btn btn-info btn-sm' href='$url1?recut_id=".$recut."&sticker_type=1sequence=".$sql_row_value['status']."' onclick=\"return popitup2('$url1?recut_id=".$recut."&sticker_type=1')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Print With Operation 2*1</a></td>";
				$url2 = getFullURLLevel($_GET['r'],'sewing_job/reprint_tagwithout_operation.php',2,'R');
				echo "<td><a class='btn btn-info btn-sm' href='$url1?recut_id=".$recut."&sticker_type=2sequence=".$sql_row_value['status']."' onclick=\"return popitup2('$url1?recut_id=".$recut."&sticker_type=2')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Print With Out Operation 2*1</a></td>";
				echo "</tr>";
			}
			echo "</table>";
		}
    }
	else
	{
        echo "<script>sweetAlert('Recut Docket No Does Not Exist','','warning')</script>";
    }  
}
?>
</div>
</div>
</body>


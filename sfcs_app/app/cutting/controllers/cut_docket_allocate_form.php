<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
$path="".getFullURLLevel($_GET['r'], "bundle_guide_print.php", "0", "r")."";
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R')); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',3,'R')); ?>

<script>

//<form name="test" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">

function firstbox()
{
	window.location.href ="<?= 'index.php?r='.$_GET['r']; ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))
}

function secondbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))+"&schedule="+document.test.schedule.value;
	window.location.href = uriVal;
}

function thirdbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))+"&schedule="+document.test.schedule.value+"&color="+window.btoa(unescape(encodeURIComponent(document.test.color.value)));
	window.location.href = uriVal;
}
$(document).ready(function() {
	$('#schedule').on('click',function(e){
		var style = $('#style').val();
		if(style == null){
			sweetAlert('Please Select Style','','warning');
		}
	});
	$('#color').on('click',function(e){
		var style = $('#style').val();
		var schedule = $('#schedule').val();
		if(style == null && schedule == null){
			sweetAlert('Please Select Style and Schedule','','warning');
		}
		else if(schedule == null){
			sweetAlert('Please Select Schedule','','warning');
			document.getElementById("submit").disabled = true;
		}
		else {
			document.getElementById("submit").disabled = false;
		}
	});
});

</script>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<?php
	//include("menu_content.php");
	$style=style_decode($_GET['style']);
	$schedule=$_GET['schedule']; 
    $color=color_decode($_GET['color']);
    if(isset($_POST['submit']))
    {
        $style=$_POST['style'];
        $color=$_POST['color'];
        $schedule=$_POST['schedule'];
    }
?>

<div class = "panel panel-primary">
<div class = "panel-heading">Cut Docket Allocation Form</div>
<div class = "panel-body">
<form name="test" action="?r=<?php echo $_GET['r']; ?>" method="post">
<?php
$sql="select order_style_no from $bai_pro3.bai_orders_db_confirm where $order_joins_not_in group by order_style_no ";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
echo "<div class=\"row\"><div class=\"col-sm-2\"><label>Select Style:</label><select class='form-control' name=\"style\"  id=\"style\" onchange=\"firstbox();\" id='style' required>";
echo "<option value='' disabled selected>Please Select</option>";
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
echo "  </select>
	</div>";
?>

<?php
echo "<div class='col-sm-2'><label>Select Schedule:</label> 
	  <select class='form-control' name=\"schedule\" id=\"schedule\" onchange=\"secondbox();\" id='schedule' required>";
	$sql="select distinct order_del_no from $bai_pro3.bai_orders_db_confirm where order_style_no='".$style."' and $order_joins_not_in";	

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
echo "<option value='' disabled selected>Please Select</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{
	if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule)){
			echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
		}
	else{
		echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
	}
}

echo "	</select>
	 </div>";
?>

<?php

echo "<div class='col-sm-2'><label>Select Color:</label><select class='form-control' name=\"color\" onchange=\"thirdbox();\" id='color' required>";
$sql="select distinct order_col_des from $bai_pro3.bai_orders_db_confirm where order_style_no='".$style."' and order_del_no='".$schedule."' and $order_joins_not_in ";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
echo "<option value='' disabled selected>Please Select</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{
	if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color)){
		echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
	}else{
		echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
	}
}

echo "</select>
	</div>";

	echo "<div class='col-sm-3' style='padding-top:23px;'>"; 
	echo "<input class='btn btn-success' type=\"submit\" value=\"Submit\" name=\"submit\" id='submit'>
	 </div>";	
echo "</div>";
?>

</form>

<hr/>

<?php
if(isset($_POST['submit']))
{

	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	$sno=1;	
	$sql="select * from $bai_pro3.bai_orders_db_confirm  where order_del_no='".$schedule."' and order_col_des='".$color."'";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql_num_check=mysqli_num_rows($sql_result);
    while($sql_row=mysqli_fetch_array($sql_result))
	{
        $orde_tid=$sql_row['order_tid'];
        $vpo=$sql_row['vpo'];
        for($s=0;$s<sizeof($sizes_code);$s++)
        {
            if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
            {
                $s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
                $s_code[]=$sizes_code[$s];
            }	
        }
    }
	
	$doc_no=array();
	$cut_no=array();
	$doc_no_yards=array();
	$doc_no_ratio=array();
	$doc_full=array();
	$sewing_jobs=array();
	$sql12="select * from $bai_pro3.order_cat_doc_mk_mix  where order_del_no='".$schedule."' and order_col_des='".$color."' and category in ($in_categories)";
	$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row12=mysqli_fetch_array($sql_result12))
	{
	   $doc_no[]=$sql_row12['doc_no']; 
	   $tot_val=0;
	   $cut_no[$sql_row12['doc_no']]=chr($sql_row12['color_code']).leading_zeros($sql_row12['acutno'],3); 
	   for($s=0;$s<sizeof($s_tit);$s++)
       {
            $doc_no_ratio[$sql_row12['doc_no']][$sizes_code[$s]]=$sql_row12["p_s".$sizes_code[$s].""];
			$tot_val=$tot_val+$sql_row12["p_s".$sizes_code[$s].""];
			$doc_no_plies[$sql_row12['doc_no']]=$sql_row12['p_plies'];            	
        }
		$doc_full[$sql_row12['doc_no']]=array_sum($doc_no_qty)+($tot_val*$sql_row12['p_plies']);
		$doc_no_qty[$sql_row12['doc_no']]=$tot_val*$sql_row12['p_plies'];
		$doc_no_yards[$sql_row12['doc_no']]=$sql_row12['material_req'];
		$temp='';
		$sql32="select input_job_no,type_of_sewing from $bai_pro3.pac_Stat_log_input_job where doc_no=".$sql_row12['doc_no']." group by input_job_no";
		$sql_result1232=mysqli_query($link, $sql32) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1223=mysqli_fetch_array($sql_result1232))
		{
			$sql322="select prefix from $brandix_bts.tbl_sewing_job_prefix where id=".$sql_row1223['type_of_sewing']."";
			$sql_result12321=mysqli_query($link, $sql322) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row12213=mysqli_fetch_array($sql_result12321))
			{				
				$temp .= $sql_row12213['prefix'].leading_zeros($sql_row1223['input_job_no'],3)."<br>";				
			}			
		}	
		$sewing_jobs[$sql_row12['doc_no']] = substr($temp,0,-1);
		$temp='';
    }
	
	if(sizeof($doc_no)>0)
	{
		echo "<div class='alert alert-info' style='text-align:center; font-size: 20px;'><b>Style Code : ".$style."</b>Schedule : <b>".$schedule."</b> VPO No : <b>".$vpo."</b></div>";
		
		echo "<div class='col-sm-12 table-responsive'>
		<table width='100%' class='table table-bordered info'><thead>
		<tr><th>S No</th><th>Color</th><th>Sewing Job No</th><th>Cut Job No</th><th>Cut Docket No</th>";
		for($s=0;$s<sizeof($s_tit);$s++)
		{
			echo "<th>".$s_tit[$sizes_code[$s]]."</th>";
			
		}
		echo "<th>Plies</th><th>Quantity</th><th>Cumulative Quantity</th><th>Yards</th></tr></thead>";
		for($i=0;$i<sizeof($doc_no);$i++)
		{
			echo "<tr><td>".$sno."</td><td>".$color."</td><td>".$sewing_jobs[$doc_no[$i]]."</td><td>".$cut_no[$doc_no[$i]]."</td><td>".$doc_no[$i]."</td>";
			for($s=0;$s<sizeof($s_tit);$s++)
			{
				echo "<td>".$doc_no_ratio[$doc_no[$i]][$sizes_code[$s]]."</td>";
				
			}
			echo "<td>".$doc_no_plies[$doc_no[$i]]."</td>";
			echo "<td>".$doc_no_qty[$doc_no[$i]]."</td>";
			echo "<td>".$doc_full[$doc_no[$i]]."</td>";
			echo "<td>".$doc_no_yards[$doc_no[$i]]."</td></tr>";
			$sno++;
		}
		echo "</table></div>";
	}
	else
	{
		
	}	
}

	
   ?> 
   </div>
   </div>
   </div>
   </div>
  
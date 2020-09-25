<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
//$path=$_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'bundle_guide_print.php',0,'R');
$path="".getFullURLLevel($_GET['r'], "bundle_guide_print.php", "0", "r")."";
//$path="../../sfcs_app/cutting/controllers/cut_reporting_without_rolls/bundle_guide_print.php";
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',4,'R'));?>

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
<div class = "panel-heading">Generate Bundle Guide</div>
<div class = "panel-body">
<form name="test" action="?r=<?php echo $_GET['r']; ?>" method="post">
<?php
include('dbconf.php');
//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	//$sql="select distinct order_style_no from bai_orders_db where left(order_style_no,1) in (".$global_style_codes.")";	
	$sql="select distinct order_style_no from bai_orders_db";	
//}
//echo $sql;exit;

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
echo "<div class=\"row\"><div class=\"col-sm-2\"><label>Select Style:</label><select class='form-control' name=\"style\"  id=\"style\" onchange=\"firstbox();\" id='style'>";

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
// $sql_update='UPDATE bai_orders_db SET order_tid=REPLACE(order_tid,"é","e"),order_col_des=REPLACE(order_col_des,"é","e")';
// mysqli_query($link, $sql_update) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

// $sql_update1='UPDATE bai_orders_db_confirm SET order_tid=REPLACE(order_tid,"é","e"),order_col_des=REPLACE(order_col_des,"é","e")';
// mysqli_query($link, $sql_update1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

// $sql_update2='UPDATE cat_stat_log SET order_tid=REPLACE(order_tid,"é","e"),order_tid2=REPLACE(order_tid2,"é","e"),col_des=REPLACE(col_des,"é","e")';
// //echo $sql_update2;

// mysqli_query($link, $sql_update2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

echo "<div class='col-sm-2'><label>Select Schedule:</label> 
	  <select class='form-control' name=\"schedule\" id=\"schedule\" onchange=\"secondbox();\" id='schedule'>";
//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style\"";	
//}

mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

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

echo "<div class='col-sm-2'><label>Select Color:</label><select class='form-control' name=\"color\" onchange=\"thirdbox();\" id='color'>";
//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log) and order_style_no=\"$style\" and order_del_no=\"$schedule\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_col_des from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_joins<'4'";
//}
// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

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

$sql="select order_tid from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des='$color'";
// echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$order_tid=$sql_row['order_tid'];
}



$sql="select mo_status from $bai_pro3.cat_stat_log where order_tid='$order_tid'";
// echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$mo_status=$sql_row['mo_status'];
}

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

	//include($_SERVER['DOCUMENT_ROOT'].$base_path.'/dbconf.php');
	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	
	$sql="select * from $bai_pro3.bai_orders_db_confirm  where order_style_no='".$style."' and order_del_no='".$schedule."' and order_col_des='".$color."'";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql_num_check=mysqli_num_rows($sql_result);
    while($sql_row=mysqli_fetch_array($sql_result))
	{
        $orde_tid=$sql_row['order_tid'];
        for($s=0;$s<sizeof($sizes_code);$s++)
        {
            if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
            {
                $s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
                $s_code[]=$sizes_code[$s];
            }	
        }
    }
    echo "<div class='col-sm-12 table-responsive'><table width='100%' class='table table-bordered info'><thead><tr><th>Cut No</th><th>Docket No</th>";
  
    for($s=0;$s<sizeof($s_tit);$s++)
        {
            echo "<th>".$s_tit[$sizes_code[$s]]."</th>";
            
        }
        echo "<th>Plies</th><th>Control</th></tr></thead>";
       
       
		$sql="select * from $bai_pro3.order_cat_doc_mk_mix where order_tid='".$orde_tid."' and category in ($in_categories)";
        mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
       // $sql_num_check=mysqli_num_rows($sql_result);
            while($sql_row=mysqli_fetch_array($sql_result))
            {
            echo "<tr><td>".chr($sql_row['color_code']).leading_zeros($sql_row['acutno'],3)."</td><td>".$sql_row['doc_no']."</td>"; 
            for($s=0;$s<sizeof($s_tit);$s++)
            {
               // $code="p_s".$sizes_code[$s];
                //echo "<th>".$s_tit[$sizes_code[$s]]."</th>";
                echo "<td>".$sql_row["p_s".$sizes_code[$s].""]."</td>";
            }
            echo "<td>".$sql_row["a_plies"]."</td>";
            $sql12="select * from $bai_pro3.docket_number_info where doc_no=".$sql_row['doc_no'];
            $sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check12=mysqli_num_rows($sql_result12);
            if($sql_num_check12>0)
            {

                echo "<td><a href=\"$path?doc_no=".$sql_row['doc_no']."\" onclick=\"Popup1=window.open('$path?doc_no=".$sql_row['doc_no']."','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\" class='btn btn-sm btn-primary'>Print</a></td>";
                //echo "<td><a href='".$url."?doc_no=".$sql_row['doc_no']."' class='btn btn-sm btn-primary'>Print</a></td>";
            }
            else
            {
                echo "<td> N / A</td>";
            }
          
            echo "</tr>";
            }
	
	echo "</table></div>";
	
}

	
   ?> 
   </div>
   </div>
   </div>
   </div>
  
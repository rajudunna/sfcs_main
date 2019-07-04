<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/menu_content.php',4,'R')); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/functions.php',4,'R'));?>

<script>
function firstbox()
{
	window.location.href ="<?= 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value
}

function secondbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value;
	window.location.href = uriVal;
}

function thirdbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+encodeURIComponent(document.test.color.value);
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

//use this function for check all the boxes
function checkAll()
{
     var checkboxes = document.getElementsByTagName('input'), val = null;    
     for (var i = 0; i < checkboxes.length; i++)
     {
         if (checkboxes[i].type == 'checkbox')
         {
             if (val === null) val = checkboxes[i].checked;
             checkboxes[i].checked = val;
         }
     }
}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<?php
	$style=$_GET['style'];
	$schedule=$_GET['schedule']; 
	$color=$_GET['color'];
?>

<div class = "panel panel-primary">
<div class = "panel-heading">Binding Consumption Report</div>
<div class = "panel-body">
<form name="test" action="<?php echo getFullURLLevel($_GET['r'],'binding_report.php','0','N'); ?>" method="post">
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
echo "<div class=\"row\"><div class=\"col-sm-3\"><label>Select Style:</label><select class='form-control' name=\"style\"  id=\"style\" onchange=\"firstbox();\" id='style'>";

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

echo "<div class='col-sm-3'><label>Select Schedule:</label> 
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

echo "<div class='col-sm-3'><label>Select Color:</label><select class='form-control' name=\"color\" onchange=\"thirdbox();\" id='color'>";
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


$sql="select seperate_docket from $bai_pro3.cat_stat_log where order_tid='$order_tid' and seperate_docket='Yes'";
// echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$seperate_docket=$sql_row['seperate_docket'];
}



if($seperate_docket=="Yes")
{
	echo "<div class='col-sm-3'> 
			<br/>
			<b>Separate Docket  :</b>&nbsp;<span class='label label-success'>&nbsp;".$seperate_docket."&nbsp;</span>&nbsp;&nbsp;";
	echo "<input class='btn btn-success' type=\"submit\" value=\"Submit\" name=\"submit\" id='submit'>
		  </div>";	
}
else
{
	echo "<div class='col-sm-3'>
			<br/>
			<b>Seperate Docket : </b> <span class='label label-danger'>&nbsp;No&nbsp;</span>
		 ";
	echo "</div>";
		  // <input class='btn btn-danger' type=\"submit\" value=\"Submit\" name=\"submit\">
}
echo "</div>"
?>

</form>
</br>



<?php
if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	
	echo "<div class='col-sm-3'>
	<b>Style : </b> <h4><span class='label label-primary'>".$style."</span></h4>";
	echo "</div>";
	
	echo "<div class='col-sm-3'>
	<b>Schedule : </b> <h4><span class='label label-warning'>".$schedule."</span></h4>";
	echo "</div>";

	echo "<div class='col-sm-3'>
	<b>Color : </b> <h4><span class='label label-success'>".$color."</span></h4>";
	echo "</div>";
	
	$sql="select order_tid from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des='$color'";
	// echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$order_tid=$sql_row['order_tid'];
	}
	
	$sql33="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
	mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row33=mysqli_fetch_array($sql_result33))
	{
		$color_code=$sql_row33['color_code']; //Color Code
	}
	
	$bindingqty="select binding_consumption from $bai_pro3.cat_stat_log where order_tid='$order_tid' and seperate_docket='Yes'";
	// mysqli_query($link, $bindingqty) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result33=mysqli_query($link, $bindingqty) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row33=mysqli_fetch_array($sql_result33))
	{
		$bindingconsqty=$sql_row33['binding_consumption']; //Color Code
	}
	
	$details_qry="select compo_no,category,pcutno,SUM(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies*mklength as qty,SUM(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies*$bindingconsqty as bindreqqty,doc_no from $bai_pro3.order_cat_doc_mk_mix where order_tid='$order_tid' and category in ('Body','Front') group by pcutno";
	// echo $details_qry;
	$sql_result_det=mysqli_query($link, $details_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	echo "<table class='table table-bordered'>";
	echo "<tr>
	<th>Fab Code</th>
	<th>Category</th>
	<th>Cut No</th>
	<th>Required Qty</th>
	<th>Category</th>
	<th>Binding Required Qty</th>
	<form action='".getFullURLLevel($_GET['r'],'binding_report.php','0','N')."' name='print' method='POST'>
	<th><input type='checkbox' onClick='checkAll()' />Select All</th>
	</tr>";
	$totordqty=0;
	$finalbindingqty=0;

	while($sql_row=mysqli_fetch_array($sql_result_det))
	{
		$compono=$sql_row['compo_no'];
		$category=$sql_row['category'];
		$cutno=$sql_row['pcutno'];
		$orderqty=$sql_row['qty'];
		$bindreqqty=$sql_row['bindreqqty'];
		$docno=$sql_row['doc_no'];	
		
		$gettingexistdata="select * from $bai_pro3.binding_consumption_items where compo_no='$compono' and cutno='$cutno' and doc_no='$docno'";
		$sql_result=mysqli_query($link, $gettingexistdata) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_confirm=mysqli_num_rows($sql_result);
		
		
		$finalqtyexcludingbind = $orderqty - $bindingconsqty;
		$finalbindingqty=$finalbindingqty+$bindreqqty;
		$totordqty = $totordqty+$finalqtyexcludingbind;
		echo "<tr>";
		echo "<td>".$compono."</td>";
		echo "<td>".$category."</td>";
		echo "<td>".chr($color_code).leading_zeros($cutno,3)."</td>";
		echo "<td>".round($finalqtyexcludingbind,2)."</td>";
		echo "<td>Binding</td>";
		echo "<td>".$bindreqqty."</td>";
		if($sql_num_confirm<1)
		{
			echo "<td><input type='checkbox'  name='bindingdata[]' value='".$compono.'/'.$category.'/'.$cutno.'/'.$bindingconsqty.'/'.$finalqtyexcludingbind.'/'.$bindreqqty.'/'.$docno.'/'.$style.'/'.$schedule.'/'.$color."'></td>";
		}
		else
		{
			echo"<td>Already Requested</td>";
		}
		echo "</tr>";
		
		
	}
	echo "<tr>";
	echo "<td colspan=3 style='text-align: center;'> <b>Total :</b></td>";
	echo "<td>".round($totordqty,2)."</td>";
	echo "<td></td>";
	echo "<td>".$finalbindingqty."</td>";
	echo "<td></td>";	
	echo "</tr>";
	echo "</table>";
	echo "<input type='submit'  value='Save' class='btn btn-primary'></form>";
	
}

if(isset($_POST['bindingdata']))
{
	$binddetails=$_POST['bindingdata'];
	$count1=count($binddetails);
	$totordqty=0;
	$finalbindingqty=0;
	if($count1>0)
	{
		for($j=0;$j<$count1;$j++)
		{
			$id = $binddetails[$j];
			$exp=explode("/",$id);
			$compono=$exp[0];
			$category=$exp[1];
			$cutno=$exp[2];
			$bindingconsqty=$exp[3];
			$reqqty=$exp[4];
			$bindreqqty=$exp[5];
			$docno=$exp[6];
			$style=$exp[7];
			$schedule=$exp[8];
			$color=$exp[9];
			
			$totordqty=$totordqty+$reqqty;
			$finalbindingqty=$finalbindingqty+$bindreqqty;
			
			
			//getting order tid 
			$ordertidqry="select order_tid from $bai_pro3.order_cat_doc_mk_mix where compo_no='$compono' and category='$category' and pcutno='$cutno'";
			$sql_result=mysqli_query($link, $ordertidqry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$order_tid=$sql_row['order_tid'];
			}
			
					
		}

		$insertqry="INSERT INTO $bai_pro3.binding_consumption(style,schedule,color,tot_req_qty,tot_bindreq_qty,status) VALUES (\"".$style."\",\"".$schedule."\",\"".$color."\",\"".$totordqty."\",\"".$finalbindingqty."\",'Open')";
		mysqli_query($link, $insertqry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$parent_id = mysqli_insert_id($link);

		for($j=0;$j<$count1;$j++)
		{
			$id = $binddetails[$j];
			$exp=explode("/",$id);
			$compono=$exp[0];
			$category=$exp[1];
			$cutno=$exp[2];
			$bindingconsqty=$exp[3];
			$reqqty=round($exp[4],2);
			$bindreqqty=$exp[5];
			$docno=$exp[6];
			
			$insertbinditems="INSERT INTO $bai_pro3.binding_consumption_items(parent_id,compo_no,category,cutno,req_qty,bind_category,bind_req_qty,doc_no) VALUES (\"".$parent_id."\",\"".$compono."\",\"".$category."\",\"".$cutno."\",\"".$reqqty."\",'Binding',\"".$bindreqqty."\",\"".$docno."\")";
			mysqli_query($link, $insertbinditems) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		echo "<script>swal('Binding Fabric Requested','Successfully','success')</script>";
	}
	else
	{
		echo "<script>swal('Please select','Check Box','warinig')</script>";
	}
	
}
?>  


   </div>
   </div>
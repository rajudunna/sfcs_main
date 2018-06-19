<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="js/style.css">
<link rel="stylesheet" type="text/css" href="table.css">
<style type="text/css">
#div-1a {
 position:absolute;
 top:65px;
 right:0; 
 width:auto;
float:right;
table {
    float:left;
    width:33%;
}
</style>
<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px;  padding:5px; background-color:#f4f4f4; solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; outset #f4f4f4; margin:2px; }
.mytable th{ background-color:#29759c; color:#FFF; padding:2px; solid #ccc; white-space: nowrap;}
td{ padding:2px; white-space: nowrap;}
</style>
<script language="javascript" type="text/javascript" src="TableFilter_EN/actb.js"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="TableFilter_EN/tablefilter.js"></script>



<script language="javascript" type="text/javascript">
function firstbox()
{
	//swal("test");
	var url1 = '<?= getFullUrl($_GET['r'],'bundle_allocation.php','N'); ?>';
	
	window.location.href = url1+"&style_id="+document.mini_order_report.style_id.value
}

function secondbox()
{
	//swal('test');
	var url1 = '<?= getFullUrl($_GET['r'],'bundle_allocation.php','N'); ?>';
	
	window.location.href = url1+"&style_id="+document.mini_order_report.style_id.value+"&sch_id="+document.mini_order_report.sch_id.value
}

function thirdbox()
{
	//swal('test');
	var url1 = '<?= getFullUrl($_GET['r'],'bundle_allocation.php','N'); ?>';
	
	window.location.href = url1+"&style_id="+document.mini_order_report.style_id.value+"&sch_id="+document.mini_order_report.sch_id.value+"&mini_order_num="+document.mini_order_report.mini_order_num.value
}

function check_val1()
{
	//swal('Test');
	var tot_cnt=document.getElementById("tot_cnt").value;
	var tot_bund=document.getElementById("bundle_tot").value;
	var total=0;
	//swal(tot_cnt);
	//swal(tot_bund);
	for(var i=1;i<tot_cnt;i++)
	{
		var total=parseInt(document.getElementById("total["+i+"]").value)+parseInt(total);
	}
	if(total==tot_bund)
	{
		//swal('Ok');
	}
	else
	{
		swal('Allocation Pending/Exceed for some Colors.');
		return false;
	}
	
	
	//return false;
}
function check_val()
{
	//swal('dfsds');
	var style=document.getElementById("style_id").value;
	var schedule=document.getElementById("sch_id").value;
	var mini_order=document.getElementById("mini_order_num").value;
	var mini_order=document.getElementById("mini_order_num").value;
	var col_code=document.getElementById("color_code").value;
	if(style == 'NIL' || schedule == 'NIL' || mini_order == 'NIL')
	{
		swal('Please select the values');
		return false;
	}	
	//return false;
}
function validate(key)
{
//getting key code of pressed key
var keycode = (key.which) ? key.which : key.keyCode;
var phn = document.getElementById('txtPhn');
//comparing pressed keycodes
if ((keycode < 48 || keycode > 57) && (keycode<46 || keycode>47))
{
return false;
}
else
{
//Condition to check textbox contains ten numbers or not
if (phn.value.length <10)
{
return true;
}
else
{
return false;
}
}
}

function validateQty(event) {
    var key = window.event ? event.keyCode : event.which;
	//swal(key);
if (event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 45) {
    return true;
}
else if ( key < 48 || key > 57 ) {
    return false;
}
else 
{
return true;

}
};
function validate_bundles(val,sno,rowid,lines_count,mini_order_rows)
{
	var total_qnty=0;
	var qnty=0;
	var total_available=Number(document.getElementById('bundles_count['+sno+']').value);
	var val=0;
	for(var j=1;j<=sno;j++)
	{
		val+=Number(document.getElementById('mod['+j+']['+rowid+']').value);
	}
	document.getElementById('mod['+rowid+']').value=val;	
		
	for(var i=0;i<=lines_count;i++)
	{
		qnty=document.getElementById('mod['+sno+']['+i+']').value;
		//console.log('mod['+sno+']['+i+']');
		if(qnty!='')
		{
			qnty=Number(qnty);
		}
		else
		{
			qnty=Number(0);
		}
		//console.log('mod['+rowid+']['+sno+']');
		total_qnty+=Number(qnty);
		//console.log(total_qnty);
		if(total_qnty>total_available)
		{
			document.getElementById('total['+sno+']').value=total_qnty-document.getElementById('mod['+sno+']['+rowid+']').value;
			document.getElementById('mod['+sno+']['+rowid+']').value='0';
			document.getElementById('row'+sno).style.backgroundColor='#ff0000';
		}
		else
		{
			document.getElementById('total['+sno+']').value=total_qnty;
			if(total_qnty==total_available)
			{
				document.getElementById('row'+sno).style.backgroundColor='#00cc00';
			}
			else
			{
				document.getElementById('row'+sno).style.backgroundColor='';
			}
			
		}
		//qnty=0;
	}
	calculate_totals(lines_count,mini_order_rows);
	
}
function calculate_totals(lines_count,mini_order_rows)
{
	var total_bundles=0;
	var bund_qnty='';
	var total_bundles_available=0;
	for(var i=0;i<=mini_order_rows;i++)
	{
		bundle_count=document.getElementById('bundles_count['+i+']').value;
		total_bundles_available+=Number(bundle_count);
		for(var j=0;j<=lines_count;j++)
		{
			bund_qnty=document.getElementById('mod['+i+']['+j+']').value;
			total_bundles+=Number(bund_qnty);
		}
	}
	if(total_bundles_available==total_bundles)
	{
		document.getElementById('submit').style.display='block';
	}
}

function count_qty(x,div_id,mo,mi,sno,module,total_rows,i)
{

	var color=document.getElementById('color['+sno+']').value;
	var size=document.getElementById('size_id['+sno+']').value;
	var total_col=document.getElementById('total_cols').value;
	var total_available=Number(document.getElementById('bundles_count['+sno+']').value);
	var tot_row=0;
	for(var k=0;k<total_rows;k++)
	{
		tot_row=parseInt(tot_row)+parseInt(document.getElementById("mod["+sno+"]["+k+"]").value);
	}
	if(tot_row<=total_available)
	{
		if (window.XMLHttpRequest)
		{
			xmlhttp=new XMLHttpRequest();
		}
		else
		{
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById(div_id).value=xmlhttp.responseText;
				var tot_col=0;var min_total=0;var tot_row_1=0;
				for(var j=1;j<total_col;j++)
				{
					var cols_cnt=String(j) + String(module)  + String(i);
					tot_col=parseInt(tot_col)+parseInt(document.getElementById(cols_cnt).value);
				}
				document.getElementById('mod_tot['+i+']').value=tot_col;
				
				for(var kk=0;kk<total_rows;kk++)
				{
					min_total=parseInt(min_total)+parseInt(document.getElementById('mod_tot['+kk+']').value);
					tot_row_1=parseInt(tot_row_1)+parseInt(document.getElementById("mod["+sno+"]["+kk+"]").value);
				}
				document.getElementById('mini_total').value=min_total;	
				document.getElementById('total['+sno+']').value=tot_row_1;	
				
				if(tot_row==total_available)
				{
					document.getElementById('row'+sno).style.backgroundColor='#00cc00';
				}
				else
				{
					document.getElementById('row'+sno).style.backgroundColor='';
				}
			}
		}
		var url2 = '<?= getFullUrl($_GET['r'],'count_check.php','N'); ?>';
		
		xmlhttp.open("GET", url2+"&count="+x+"&color="+color+"&size="+size+"&mno="+mo+"&mi="+mi+"&module="+module+"&rand="+Math.random(),true);
		xmlhttp.send(); 
	}
	else
	{
		//document.getElementById('total['+sno+']').value=total_qnty-document.getElementById('mod['+sno+']['+i+']').value;
		document.getElementById('mod['+sno+']['+i+']').value='0';
		document.getElementById('row'+sno).style.backgroundColor='#ff0000';
	}
}	
function back_color(row_id,val)
{
	//swal("Test");
	if(val==1)
	{
		document.getElementById('row'+row_id).style.backgroundColor='#00cc00';
	}
	else if(val==2)
	{
		document.getElementById('row'+row_id).style.backgroundColor='#3498DB';
	}
	else if(val==3)
	{
		document.getElementById('row'+row_id).style.backgroundColor='#ff0000';
	}	
}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="panel panel-primary">
	<div class="panel-heading">Bundle Allocation</div>
	<div class='panel-body'>
<?php 
$global_path = getFullURLLevel($_GET['r'],'',4,'R');
include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'dbconf.php',0,'R'));
include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/user_acl_v1.php");
$view_access=user_acl("SFCS_0290",$username,1,$group_id_sfcs);
?>

<?php
error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$module_num=array();
$color_check=array();

if(isset($_POST['style_id']))
{
    $style=$_POST['style_id'];
    $schedule=$_POST['sch_id'];
	$mini_order_ref=echo_title("$brandix_bts.tbl_min_ord_ref","id","ref_crt_schedule",$schedule,$link);
	$mini_order_num=$_POST['mini_order_num'];
	$color_check[]=$_POST['color_code']; 
	$module_num=$_POST['module_num']; 
	
}
if($_GET['style_id']<>'')
{
	$style=$_GET['style_id'];
	if($_GET['sch_id']<>'')
	{
		$schedule=$_GET['sch_id'];
		$mini_order_ref=echo_title("$brandix_bts.tbl_min_ord_ref","id","ref_crt_schedule",$schedule,$link);
		$mini_order_num=$_GET['mini_order_num'];
		$color_check[]=$_GET['color_code'];
	}
}
//echo $style."--".$schedule."--".$mini_order_num."--".$color_check."--".$module_num."<br>";
?>

<form name="mini_order_report" action="?r=<?php echo $_GET['r']; ?>" method="post" onsubmit=" return check_val();">
<br>
<div class='row'>
<div class="col-lg-2 form-group">
	<label>Select Style:</label>
<?php
// echo "<table><tr><td>";

echo "<select id=\"style_id\" class='form-control' name=\"style_id\" onchange=\"firstbox();\" >";

//$sql="select distinct style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select * from $brandix_bts.tbl_orders_style_ref";	
//}
// mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

	if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$style))
	{
		echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['product_style']."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_row['id']."\">".$sql_row['product_style']."</option>";
	}

}

echo "</select>";
?>
</div>
<div class="col-lg-2 form-group">
	<label>Select Schedule:</label>
<?php

echo "<select id=\"sch_id\" class='form-control' name=\"sch_id\" onchange=\"secondbox();\">";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select id,product_schedule as schedule from $brandix_bts.tbl_orders_master where ref_product_style=\"$style\" group by schedule order by product_schedule";	
	//$sql="select product_schedule as schedule,id from tbl_orders_master where ref_product_style=$style group by schedule";
//}
//echo $sql;
// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
/*
if(str_replace(" ","",0)==str_replace(" ","",$c_block))
{
echo "<option value=\"0\" selected>All Country blocks</option>";
}
else
{
	echo "<option value=\"0\">All Country block</option>";
}*/
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$schedule))
{
	echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['schedule']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['id']."\">".$sql_row['schedule']."</option>";
}

}


echo "</select>";
?>
</div>
<div class="col-lg-2 form-group">
	<label>Select Mini Order:</label>
<?php

echo "<select id=\"mini_order_num\" class='form-control' name=\"mini_order_num\" onchange=\"thirdbox();\">";

//$sql="select distinct style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct mini_order_num from $brandix_bts.tbl_miniorder_data where mini_order_ref='".$mini_order_ref."' order by mini_order_num";	
//}
// mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

	if($sql_row['mini_order_num']==$mini_order_num)
	{
		echo "<option value=\"".$sql_row['mini_order_num']."\" selected>".$sql_row['mini_order_num']."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_row['mini_order_num']."\">".$sql_row['mini_order_num']."</option>";
	}

}

echo "</select>";
?>
</div>
<div class="col-lg-2 form-group">
	<label>Select Color: </label>
<?php

echo "<select id=\"color_code\" class='form-control' name=\"color_code[]\" size='9' multiple>";

//$sql="select distinct style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct color from $brandix_bts.tbl_miniorder_data where mini_order_ref='".$mini_order_ref."' and mini_order_num='".$mini_order_num."' order by color";	
//}
// mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"Z\" selected>ALL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

	if(in_array("Z",$color_check))
	{
		echo "<option value=\"".$sql_row['color']."\" selected>".$sql_row['color']."</option>";
	}
	else if(in_array($sql_row['color'],$color_check))
	{
		echo "<option value=\"".$sql_row['color']."\" selected>".$sql_row['color']."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_row['color']."\">".$sql_row['color']."</option>";
	}

}

echo "</select>";
?>
</div>
<div class="col-lg-2 form-group">
	<label>Select Module Number:</label>
<?php

$sql="select id from $brandix_bts.tbl_module_ref";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
$i=0;
echo "<table border=1px class='table table-bordered'><tr>";
while($sql_row=mysqli_fetch_array($sql_result))
{
	
	
	if($i==10)
	{
		$i=0;
		if(in_array($sql_row['id'],$module_num))
		{
			echo "<td><input type=\"checkbox\" name=\"module_num[]\" value=".$sql_row['id']." checked>".$sql_row['id']."</td>";
		}
		else
		{
			echo "<td><input type=\"checkbox\" name=\"module_num[]\" value=".$sql_row['id'].">".$sql_row['id']."</td>";
		}
	}
	else
	{
		if(in_array($sql_row['id'],$module_num))
		{
			echo "<td><input type=\"checkbox\" name=\"module_num[]\" value=".$sql_row['id']." checked>".$sql_row['id']."</td>";
		}
		else
		{
			echo "<td><input type=\"checkbox\" name=\"module_num[]\" value=".$sql_row['id'].">".$sql_row['id']."</td>";
		}
	}
	$i++;
}
echo "</tr></table>";

?>
</div>
<div class='row'>
<div class='form-group col-lg-2'>
 <?php
	echo "<input type=\"hidden\" value=\"$mini_order_ref\" name=\"mini_order_ref\">";	
	echo "<input type=\"submit\" class='btn btn-primary' style='margin-top: 20px' value=\"submit\" name=\"submit\">";	
?>
</div>
</div>


</form>


<?php
if(isset($_POST['submit']))
{
	
	$style_code=$_POST['style_id'];
	$mini_order_ref=$_POST['mini_order_ref'];
	$mini_order_num=$_POST['mini_order_num'];
	$color_code1=$_POST['color_code'];
	
	$schedule_code=$_POST['sch_id'];
	$module=$_POST['module_num'];
	$next_min=$mini_order_num+1;
	$pre_min=$mini_order_num-1;
	$check_allocation= echo_title("$brandix_bts.tbl_miniorder_data","count(planned_module)","planned_module>0 and mini_order_ref='".$mini_order_ref."' and mini_order_num",$mini_order_num,$link);	
	$check_next_min= echo_title("$brandix_bts.tbl_miniorder_data","mini_order_num","mini_order_ref='".$mini_order_ref."' and mini_order_num",$next_min,$link);
	$check_pre_min= echo_title("$brandix_bts.tbl_miniorder_data","mini_order_num","mini_order_ref='".$mini_order_ref."' and mini_order_num",$pre_min,$link);
	$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_code,$link);
	$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_code,$link);
	//echo $color_code."<br>";
	if($color_code1[0]=='Z')
	{
		$mini_order_query="select color,size,sum(quantity) as qnty,count(bundle_number) as bundle_count,tbl_orders_size_ref.size_name,tbl_orders_size_ref.id as size_id from $brandix_bts.tbl_miniorder_data left join $brandix_bts.tbl_orders_size_ref on tbl_orders_size_ref.id=tbl_miniorder_data.size 
		where mini_order_num=$mini_order_num and mini_order_ref=$mini_order_ref group by color,size";
		$mini_order_result=mysqli_query($link, $mini_order_query) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$color_code='Z';
	}
	else
	{
		for($i=0;$i<sizeof($color_code1);$i++)
		{
			$color_code2.="'".substr(trim($color_code1[$i]),-1)."',";
		}
		$color_code=rtrim($color_code2,",");
		//echo $color_code."<br>";
		$mini_order_query="select color,size,sum(quantity) as qnty,count(bundle_number) as bundle_count,tbl_orders_size_ref.size_name,tbl_orders_size_ref.id as size_id from $brandix_bts.tbl_miniorder_data left join tbl_orders_size_ref on tbl_orders_size_ref.id=tbl_miniorder_data.size 
		where mini_order_num=$mini_order_num and mini_order_ref=$mini_order_ref and SUBSTRING(TRIM(color), -1) IN (".$color_code.") group by color,size";
		$mini_order_result=mysqli_query($link, $mini_order_query) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	//echo $mini_order_query."<br>";
	
	echo "<h3>Style 	:".$style."Schedule 	:".$schedule."</h3>";
	echo "<h3>Mini Order Number=".$mini_order_num."</h3>";
	
	echo "<p>";
	$url1 = getFullUrl($_GET['r'],'bundle_allocation.php','N');
	if($check_pre_min != '')
	{

		echo "<a class='btn btn-primary' href=\"$url1&color_code=$color_code&style_id=$style_code&sch_id=$schedule_code&mini_order_num=$pre_min&mini_order_ref=$mini_order_ref&ops=previous&las_min=$mini_order_num\">Previous Miniorder </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	if($check_next_min != '')
	{
		echo "<a class='btn btn-primary' href=\"$url1&color_code=$color_code&style_id=$style_code&sch_id=$schedule_code&mini_order_num=$next_min&mini_order_ref=$mini_order_ref&ops=next&las_min=$mini_order_num\">Next Miniorder</a>";
	}
	if($check_allocation>0)
	{
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Allocation Completed</p>";
	}
	else
	{
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Allocation Pending</p>";
	}
	
	
	$mini_order_rows=mysqli_num_rows($mini_order_result);
	if($mini_order_result>0)
	{
		$url2 = getFullUrl($_GET['r'],'bundle_alloc_save.php','N');
		
		echo '<form name="input" method="post" action="'.$url2.'" onsubmit=" return check_val1();">';
		echo "<div class='table-responsive'><table border='1' class='table table-bordered'>";
		
		echo "<tr><th>S.No</th><th>Color</th><th>Size Name</th><th>Quantity</th><th>No.Of Bundles</th>";
		for($i=0;$i<sizeof($module);$i++)
		{
			echo "<th>Module-".$module[$i]."</th>";
			$code.= $module[$i]."-";
		}
		//$code.= substr($code_tmp, 0, -1);
		echo "<th>Total</th></tr>";
		echo '<input type="hidden" name="style_id" value="'.$style_code.'">';
		echo '<input type="hidden" name="schedule" value="'.$schedule_code.'">';
		echo '<input type="hidden" name="mini_order_num" value="'.$mini_order_num.'">';
		echo '<input type="hidden" name="mini_order_ref" value="'.$mini_order_ref.'">';
		echo '<input type="hidden" name="lines_selected" value="'.$code.'">';
		echo '<input type="hidden" name="color_code" value="'.$color_code.'">';
		$sno=1;
		$lines_count=sizeof($module);
		$bundle_tot=0;$total_qty_cum=0;
		$alloc_bund=0;
		while($m=mysqli_fetch_array($mini_order_result))
		{
			//get size title
			$color=$m["color"];
			$size_id=$m['size_id'];
			$bundle_count=$m['bundle_count'];
			//echo $color."</br>";
			$size_title_query="select size_title from $brandix_bts.tbl_orders_sizes_master where order_col_des='$color' and ref_size_name=$size_id and parent_id in(select id from $brandix_bts.tbl_orders_master where ref_product_style=$style_code and product_schedule='$schedule') limit 0,1";
			$size_title_result=mysqli_query($link, $size_title_query) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($m1= mysqli_fetch_array($size_title_result))
			{
				$size_title=$m1['size_title'];
			}
			
			echo "<tr id='row".$sno."'><td>".$sno."</td>";
			echo "<td><input type='hidden' id='color[".$sno."]' size='35' style='width: 200px;'  name='color[".$sno."]' value='".$color."'readonly>".$color."</td>"; 
			echo "<td><input type='hidden' id='size_title[".$sno."]' name='size_title[".$sno."]' value=".$size_title." readonly>".$size_title."</td>"; 
			echo "<input type='hidden' id='size_id[".$sno."]' name='size_id[".$sno."]' value=".$m['size_id']." readonly>"; 
			echo "<td><input type='hidden' id='quantity[".$sno."]' name='quantity[".$sno."]' value=".$m['qnty']." readonly>".$m['qnty']."</td>"; 
			echo "<td><input type='hidden' id='bundles_count[".$sno."]' name='bundles_count[".$sno."]' value=".$bundle_count." readonly>".$bundle_count."</td>";
			
			$total=0;
			$bundle_tot+=$bundle_count;
			for($i=0;$i<sizeof($module);$i++)
			{
				$mod_val=echo_title("$brandix_bts.tbl_miniorder_data","count(planned_module)","mini_ordeR_ref=\"$mini_order_ref\" and mini_order_num=\"$mini_order_num\" and color=\"$color\" and size=\"$size_id\" and planned_module",$module[$i],$link);
				if($mod_val==0)
				{
					$mod_value=0;
					$quantity=0;
				}
				else
				{
					$mod_value=$mod_val;
					$quantity= echo_title("$brandix_bts.tbl_miniorder_data","sum(quantity)","color='".$color."' and planned_module='".$module[$i]."' and size='".$size_id."' and mini_order_ref='".$mini_order_ref."' and mini_order_num",$mini_order_num,$link);
				}
				$sol_co=substr(trim($color),-1);
				$d_id=$sno.$module[$i].$i;
				echo "<td width=\"18%\"><div id=\"left\" style = \"float:left; width: 50%;\">".$sol_co."".$size_title."".$module[$i]."</div>
				<div id=\"left\" style = \"float:left; width: 20%;\">
				<input size=\"1\" align=\"right\" type='text' class='form-control' id='mod[".$sno."][".$i."]' name='mod[".$sno."][".$i."]' value='".$mod_value."'  
				onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value='0';}\"
				onchange='validate_bundles(this.value,$sno,$i,$lines_count,$mini_order_rows);'
				onkeypress='return validateQty(event);'	
				onkeyup='count_qty(this.value,$d_id,$mini_order_num,$mini_order_ref,$sno,$module[$i],$lines_count,$i);validate_bundles(this.value,$sno,$i,$lines_count,$mini_order_rows);'></div>
				<div id=\"left\" style = \"float:left; width: 25%;\">
				<input type=\"text\" class='form-control' readonly size=\"1\" value=\"$quantity\" id=\"$d_id\" name=\"$d_id\">
				</td>";
				
				$total+=$mod_value;
				$total_qty[$i]+=$quantity;
				
			}
			
			echo "<td><input class='form-control' type='text' id='total[".$sno."]' name='total[".$sno."]' value='".$total."' readonly></td>";
			$sno++;
			echo "</tr>";
			
			
		}
		//$total_qty_min_c=array_sum($total_qty);
		echo "<tr><input type='hidden' id='total_cols' name='total_cols' value='".$sno."' readonly><td colspan=\"5\">Total</td>";
		for($i=0;$i<sizeof($total_qty);$i++)
		{
			$total_qty_min_c+=$total_qty[$i];
			echo "<td><input type='text' class='form-control' id='mod_tot[".$i."]' name='mod_tot[".$i."]' value='".$total_qty[$i]."' readonly></td>";
		}
		
		echo "<td><input type='text' class='form-control' id='mini_total' value='".$total_qty_min_c."' readonly></td>";
		//echo "<td><input type='text' name='mod_tot_cum' value='".$total_qty_cum."' readonly></td>";
		echo "</tr>";
		$data_sym="$";
		$File = $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'module.php',0,'R');
		$fh = fopen($File, 'w') or die("can't open file");
		$stringData = "<?php ".$data_sym."style=\"".$style_code."\"; ".$data_sym."color_code=\"".$color_code."\"; ".$data_sym."schedule=\"".$schedule_code."\"; ".$data_sym."last_min=\"".$mini_order_num."\"; ".$data_sym."mini_order_ref=\"".$mini_order_ref."\"; ".$data_sym."module=\"".$code."\"; ?>";
		fwrite($fh, $stringData);
		fclose($fh);
		echo "<tr><input type='hidden' id='tot_cnt' name='tot_cnt' value=".$sno." ></tr>"; 
		echo "<tr><input type='hidden' id='bundle_tot' name='bundle_tot' value=".$bundle_tot." > </tr>"; 
		echo "</table></div>";
			 
		if($check_allocation>0)
		{
			//echo "<input type=\"submit\" id=\"submit\" name=\"update\" value=\"update\" >";
		}
		else
		{
			//echo "<input type=\"submit\" id=\"submit\" name=\"save\" value=\"Save\">";
		}	
		
		echo '</form>';
	}
	
}
if(isset($_GET['ops']))
{
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'module.php',0,'R'));
	
	$bundle_tot=0;
	$alloc_bund=0;
	$style_code=$style;
	$color_code1=$_GET['color_code'];
	$mini_order_ref=$mini_order_ref;
	$mini_order_num=$_GET['mini_order_num'];
	$mini_order_num_las=$last_min;
	$main_min=$alloc_min;
	$next_min=$mini_order_num+1;
	$pre_min=$mini_order_num-1;
	$schedule_code=$schedule;
	$module=explode("-",$module);
	$check_allocation= echo_title("$brandix_bts.tbl_miniorder_data","count(planned_module)","mini_order_ref='".$mini_order_ref."' and mini_order_num",$mini_order_num,$link);
	$check_next_min= echo_title("$brandix_bts.tbl_miniorder_data","mini_order_num","mini_order_ref='".$mini_order_ref."' and mini_order_num",$next_min,$link);
	$check_pre_min= echo_title("$brandix_bts.tbl_miniorder_data","mini_order_num","mini_order_ref='".$mini_order_ref."' and mini_order_num",$pre_min,$link);
	
	$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_code,$link);
	$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_code,$link);
	if($color_code1=='Z')
	{
		$mini_order_query="select color,size,sum(quantity) as qnty,count(bundle_number) as bundle_count,tbl_orders_size_ref.size_name,tbl_orders_size_ref.id as size_id from $brandix_bts.tbl_miniorder_data left join $brandix_bts.tbl_orders_size_ref on tbl_orders_size_ref.id=tbl_miniorder_data.size 
		where mini_order_num=$mini_order_num and mini_order_ref=$mini_order_ref group by color,size";
		$mini_order_result=mysqli_query($link, $mini_order_query) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$color_code='Z';
	}
	else
	{
		//$color_code1=explode(",",$_GET['color_code']);
		$color_code=$color_code1;
		$mini_order_query="select color,size,sum(quantity) as qnty,count(bundle_number) as bundle_count,tbl_orders_size_ref.size_name,tbl_orders_size_ref.id as size_id from $brandix_bts.tbl_miniorder_data left join tbl_orders_size_ref on tbl_orders_size_ref.id=tbl_miniorder_data.size 
		where mini_order_num=$mini_order_num and mini_order_ref=$mini_order_ref and SUBSTRING(TRIM(color), -1) IN (".$color_code1.") group by color,size";
		$mini_order_result=mysqli_query($link, $mini_order_query) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	//echo $mini_order_query."<br>";
	echo "<h3>Style 	:".$style."Schedule 	:".$schedule."</h3>";
	echo "<h3>Mini Order Number=".$mini_order_num."</h3>";
	$url1 = getFullUrl($_GET['r'],'bundle_allocation.php','N');
	
	if($check_pre_min != '')
	{
		echo "<p><a class='btn btn-primary' href=\"$url1&color_code=$color_code&style_id=$style_code&sch_id=$schedule_code&mini_order_num=$pre_min&mini_order_ref=$mini_order_ref&ops=previous&las_min=$mini_order_num_las\">Previous Miniorder </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	if($check_next_min != '')
	{
		echo "<a class='btn btn-primary' href=\"$url1&color_code=$color_code&style_id=$style_code&sch_id=$schedule_code&mini_order_num=$next_min&mini_order_ref=$mini_order_ref&ops=next&las_min=$mini_order_num_las\">Next Miniorder</a>";
	}
	if($check_allocation>0)
	{
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Allocation Completed</p>";
	}
	else
	{
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Allocation Pending</p>";
	}
		
	$total_qty=array();
	$mini_order_rows=mysqli_num_rows($mini_order_result);
	if($mini_order_result>0)
	{
		$url2 = getFullUrl($_GET['r'],'bundle_alloc_save.php','N');
		
		echo '<form name="input" method="post" action="'.$url2.'" onsubmit=" return check_val1();">';

		echo "<div class='table-responsive'><table border='1' class='table table-bordered'>";
			
		echo "<tr><th>S.No</th><th>Color</th><th>Size Name</th><th>Quantity</th><th>No.Of Bundles</th>";
		for($i=0;$i<sizeof($module)-1;$i++)
		{
			echo "<th>Module-".$module[$i]."</th>";
			$code.= $module[$i]."-";
			//$i++;
		}
		//$code.= substr($code_tmp, 0, -1);
		echo "<th>Total</th></tr>";	
		echo '<input type="hidden" name="style_id" value="'.$style_code.'">';
		echo '<input type="hidden" name="schedule" value="'.$schedule_code.'">';
		echo '<input type="hidden" name="mini_order_num" value="'.$mini_order_num.'">';
		echo '<input type="hidden" name="mini_order_ref" value="'.$mini_order_ref.'">';
		echo '<input type="hidden" name="lines_selected" value="'.$code.'">';
		echo '<input type="hidden" name="color_code" value="'.$color_code.'">';
		
		$sno=1;
		$bundle_tot=0;
		$lines_count=sizeof($module)-1;
		//$lines_count=sizeof($module);
		while($m=mysqli_fetch_array($mini_order_result))
		{
			//get size title
			$color=$m["color"];
			$size_id=$m['size_id'];
			$bundle_count=$m['bundle_count'];
			//echo $color."</br>";
			$size_title_query="select size_title from $brandix_bts.tbl_orders_sizes_master where order_col_des='$color' and ref_size_name=$size_id and parent_id in(select id from $brandix_bts.tbl_orders_master where ref_product_style=$style_code and product_schedule='$schedule') limit 0,1";
			$size_title_result=mysqli_query($link, $size_title_query) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($m1= mysqli_fetch_array($size_title_result))
			{
				$size_title=$m1['size_title'];
			}
			
			echo "<tr id='row".$sno."'><td>".$sno."</td>";
			echo "<td><input type='hidden' id='color[".$sno."]' size='35' style='width: 200px;'  name='color[".$sno."]' value='".$color."'readonly>$color</td>"; 
			echo "<td><input type='hidden' id='size_title[".$sno."]' name='size_title[".$sno."]' value=".$size_title." readonly>$size_title</td>"; 
			echo "<input type='hidden' id='size_id[".$sno."]' name='size_id[".$sno."]' value=".$m['size_id']." readonly>"; 
			echo "<td><input type='hidden' id='quantity[".$sno."]' name='quantity[".$sno."]' value=".$m['qnty']." readonly>".$m['qnty']."</td>"; 
			echo "<td><input type='hidden' id='bundles_count[".$sno."]' name='bundles_count[".$sno."]' value=".$bundle_count." readonly>$bundle_count</td>";
			//$j=1;
			$total=0;$check_sum_bundle=0;
			$bundle_tot+=$bundle_count;
			for($i=0;$i<sizeof($module)-1;$i++)
			{
				//$line_id=$module[$i];
				$mod_val=echo_title("$brandix_bts.tbl_miniorder_data","count(planned_module)","mini_order_ref=\"$mini_order_ref\" and mini_order_num=\"$mini_order_num_las\" and color=\"$color\" and size=\"$size_id\" and planned_module",$module[$i],$link);
				
				if($mod_val==0)
				{
					$mod_value=0;
					$quantity=0;
				}
				else
				{
					$mod_value=$mod_val;
					$sql="update $brandix_bts.tbl_miniorder_data set planned_module=$module[$i] where color='".$color."' and size=$size_id and mini_order_num=$mini_order_num and mini_order_ref=$mini_order_ref and (planned_module=0 or planned_module is NULL) order by bundle_number limit $mod_val";	
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
					$quantity= echo_title("$brandix_bts.tbl_miniorder_data","sum(quantity)","color='".$color."' and planned_module='".$module[$i]."' and size='".$size_id."' and mini_order_ref='".$mini_order_ref."' and mini_order_num",$mini_order_num,$link);
					$mod_value= echo_title("$brandix_bts.tbl_miniorder_data","count(bundle_number)","color='".$color."' and planned_module='".$module[$i]."' and size='".$size_id."' and mini_order_ref='".$mini_order_ref."' and mini_order_num",$mini_order_num,$link);
					$check_sum_bundle+=$mod_value;
				}
				$sol_co=substr(trim($color),-1);
				$d_id=$sno.$module[$i].$i;
				echo "<td width=\"18%\"><div id=\"left\" style = \"float:left; width: 50%;\">".$sol_co."".$size_title."".$module[$i]."</div>
				<div id=\"left\" style = \"float:left; width: 20%;\">
				<input size=\"1\" align=\"right\" type='text' class='form-control' id='mod[".$sno."][".$i."]' name='mod[".$sno."][".$i."]' value='".$mod_value."'  
				onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value='0';}\"
				onchange='validate_bundles(this.value,$sno,$i,$lines_count,$mini_order_rows);'
				onkeypress='return validateQty(event);'	
				onkeyup='count_qty(this.value,$d_id,$mini_order_num,$mini_order_ref,$sno,$module[$i],$lines_count,$i);validate_bundles(this.value,$sno,$i,$lines_count,$mini_order_rows);'></div>
				<div id=\"left\" style = \"float:left; width: 25%;\">
				<input type=\"text\" class='form-control' readonly size=\"1\" value=\"$quantity\" id=\"$d_id\" name=\"$d_id\">
				</td>";
				
				$total+=$mod_value;
				$total_qty[$i]+=$quantity;
				
			}
			if($check_sum_bundle>0)
			{
				if($bundle_count==$check_sum_bundle)
				{
					echo "<script> back_color(".$sno.",1);</script>";
				}
				else if($bundle_count>$check_sum_bundle)
				{
					echo "<script> back_color(".$sno.",2);</script>";
				}
				else if($bundle_count<$check_sum_bundle)
				{
					echo "<script> back_color(".$sno.",3);</script>";	
				}
			}
			echo "<td><input type='text' class='form-control' id='total[".$sno."]' name='total[".$sno."]' value='".$total."' readonly></td>";
			$sno++;
			echo "</tr>";
			
			
		}
		//$total_qty_min_c=array_sum($total_qty);
		echo "<tr><input type='hidden' id='total_cols' name='total_cols' value='".$sno."' readonly><td colspan=\"5\">Total</td>";
		for($i=0;$i<sizeof($total_qty);$i++)
		{
			$total_qty_min_c+=$total_qty[$i];
			echo "<td><input type='text' class='form-control' id='mod_tot[".$i."]' name='mod_tot[".$i."]' value='".$total_qty[$i]."' readonly></td>";
		}
		
		echo "<td><input type='text' class='form-control' id='mini_total' value='".$total_qty_min_c."' readonly></td>";
		echo "</tr>";
		$data_sym="$";
		$File = $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'module.php',0,'R');
		$fh = fopen($File, 'w') or die("can't open file");
		$stringData = "<?php ".$data_sym."style=\"".$style_code."\"; ".$data_sym."color_code=\"".$color_code."\"; ".$data_sym."schedule=\"".$schedule_code."\"; ".$data_sym."last_min=\"".$mini_order_num_las."\"; ".$data_sym."mini_order_ref=\"".$mini_order_ref."\"; ".$data_sym."module=\"".$code."\"; ?>";
		fwrite($fh, $stringData);
		fclose($fh);
		echo "</table></div>";
		echo "<input type='hidden' id='tot_cnt' name='tot_cnt' value=".$sno." readonly>"; 
		echo "<input type='hidden' id='bundle_tot' name='bundle_tot' value=".$bundle_tot." readonly>"; 
		if($check_allocation>0)
		{
			//echo "<input type=\"submit\" id=\"submit\" name=\"update\" value=\"update\" >";
		}
		else
		{
			//echo "<input type=\"submit\" id=\"submit\" name=\"save\" value=\"Save\" >";
		}	
		echo '</form>';
	}
}
?> 
</div>
</div>

<style>

#table1 {
  display: inline-table;
  width: 100%;
}


div#table_div {
    width: 30%;
}
#test{
margin-left:8%;
margin-bottom:2%;
}
</style>
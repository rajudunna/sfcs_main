<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'order_status_buffer.php',0,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");
// $view_access=user_acl("SFCS_0043",$username,1,$group_id_sfcs); 
?>
<?php
error_reporting(0);
set_time_limit(6000000);
?>
<html>
<head>

<style type="text/css">
#reset_example1{
	width : 50px;
	color : #ec971f;
	margin-top : 10px;
	margin-left : 0px;
	margin-bottom:15pt;
}
div.scroll {
height: 75px;
width: auto;
overflow: auto;
border: 0px solid #666;
background-color:white;
color:black;
padding-left: 5px;
padding-right: 5px;
}
</style>


<SCRIPT>

function SetAllCheckBoxes(FormName, FieldName, CheckValue)
{
	if(!document.forms[FormName])
		return;
	var objCheckBoxes = document.forms[FormName].elements[FieldName];
	if(!objCheckBoxes)
		return;
	var countCheckBoxes = objCheckBoxes.length;
	if(!countCheckBoxes)
		objCheckBoxes.checked = CheckValue;
	else
		// set the check value for all check boxes
		for(var i = 0; i < countCheckBoxes; i++)
			objCheckBoxes[i].checked = CheckValue;
}
</SCRIPT>

<script>

function checkall()
{
	SetAllCheckBoxes('test', 'cpo[]', true);
	SetAllCheckBoxes('test', 'buyer_div[]', true);
	SetAllCheckBoxes('test', 'style[]', true);
	SetAllCheckBoxes('test', 'style_id[]', true);
	SetAllCheckBoxes('test', 'schedule[]', true);
	SetAllCheckBoxes('test', 'color[]', true);
}

function uncheckall()
{
	SetAllCheckBoxes('test', 'cpo[]', false);
	SetAllCheckBoxes('test', 'buyer_div[]', false);
	SetAllCheckBoxes('test', 'style[]', false);
	SetAllCheckBoxes('test', 'style_id[]', false);
	SetAllCheckBoxes('test', 'schedule[]', false);
	SetAllCheckBoxes('test', 'color[]', false);	
}

</script>
<!--<link rel="stylesheet" type="text/css" media="all" href="<?= getFullURLLevel($_GET['r'],'common/js/jsdatepick-calendar/jsDatePick_ltr.min.css',1,'R'); ?>" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'reports/jsdatepick-calendar/jsDatePick.min.1.3.js',0,'R'); ?>"></script>-->
<script type="text/javascript">
	window.onload = function()
	{
		new JsDatePick({
			useMode:2,
			target:"demo1",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"demo2",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
<script language="javascript" type="text/javascript" src="<?= '../'.getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R') ?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<link rel="stylesheet" href="<?= '../'.getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R') ?>" type="text/css" media="all" />
<!--<link href="<?= '../'.getFullURLLevel($_GET['r'],'common/css/table_style.css',3,'R') ?>" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?= '../'.getFullURL($_GET['r'],'jquery-1.3.2.js','R') ?>" ></script>
<link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',3,'R'); ?>" rel="stylesheet" type="text/css" />-->
<script type="text/javascript" src="<?= '../'.getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R') ?>" ></script>


</head>

<div class='panel panel-primary' style='height: 434px;'><div class='panel-heading'>Order Status Report</div><div class='panel-body'>
<form method="POST" name="test" action="?r=<?php echo $_GET['r'];?>">
<?php
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
	$cpo=$_POST['cpo'];
	$buyer_div=$_POST['buyer_div'];
	$style_id=$_POST['style_id'];
	$date_filter=$_POST['date_filter'];
	$from_date=$_POST['from_date'];
	$to_date=$_POST['to_date'];
	
//NEW

$cpo_code='';
	for($i=0;$i<sizeof($cpo);$i++)
	{
		$cpo_code='"'.$cpo[$i].'"'.', '.$cpo_code;	
	}
	
	
	$buyer_div_code="";
	for($i=0;$i<sizeof($buyer_div);$i++)
	{
		$buyer_div_code='"'.$buyer_div[$i].'"'.", ".$buyer_div_code;	
		
	}

	$style_code="";
	for($i=0;$i<sizeof($style);$i++)
	{
		$style_code="'".$style[$i]."'".", ".$style_code;	
	}
	
	$style_id_code="";
	for($i=0;$i<sizeof($style_id);$i++)
	{
		$style_id_code="'".$style_id[$i]."'".", ".$style_id_code;	
	}
	
	
	$schedule_code="";
	for($i=0;$i<sizeof($schedule);$i++)
	{
		$schedule_code="'".$schedule[$i]."'".", ".$schedule_code;
	}
	
	$color_code="";
	for($i=0;$i<sizeof($color);$i++)
	{
		$color_code="'".$color[$i]."'".", ".$color_code;
	}

	
	$criteria="";
	
	if(strlen($style_code)>2)
	{
		$criteria=$criteria." and style in (".substr($style_code,0,-2).")";
	}
	
	if(strlen($schedule_code)>2)
	{
		$criteria=$criteria." and schedule in (".substr($schedule_code,0,-2).")";
	}
	
	if(strlen($color_code)>2)
	{
		$criteria=$criteria." and color in (".substr($color_code,0,-2).")";
	}
	
	if(strlen($style_id_code)>2)
	{
		$criteria=$criteria." and style_id in (".substr($style_id_code,0,-2).")";
	}
	
	if(strlen($cpo_code)>2)
	{
		$criteria=$criteria.' and CPO in ('.substr($cpo_code,0,-2).')';
	}
	
	if(strlen($buyer_div_code)>2)
	{
		$criteria=$criteria." and buyer_div in (".substr($buyer_div_code,0,-2).")";
	}
	
	if(strlen(substr($criteria,4))>2)
	{
		$criteria=" where ".substr($criteria,4)." ";
	}

//NEW



	
	echo "<div class='table-responsive' id='main_content'><table class='table table-bordered table-striped'>";
	echo "<tr class='tblheading'>";
	echo "<td bgcolor=\"#CCFFFF\">CPO (".sizeof($cpo).")</td>";
	echo "<td bgcolor=\"#CCFFFF\">Buyer Division (".sizeof($buyer_div).")</td>";
	echo "<td bgcolor=\"#CCFFFF\">Style (".sizeof($style).")</td>";
	echo "<td bgcolor=\"#CCFFFF\">User Style ID (".sizeof($style_id).")</td>";
	echo "<td bgcolor=\"#CCFFFF\">Schedule (".sizeof($schedule).")</td>";
	echo "<td bgcolor=\"#CCFFFF\">Color (".sizeof($color).")</td>";
	echo "<td bgcolor=\"#CCFFFF\">ExFactory Filter</td>";
	echo "</tr>";
	
	echo "<tr>";
		echo "<td>";
	echo '<div class="scroll">';

	$sql="select distinct CPO from $bai_pro2.order_status_buffer $criteria order by CPO";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
	$count = mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$check=0;
		for($i=0;$i<sizeof($cpo);$i++)
		{
			if(!(strcmp(trim($sql_row['CPO']),trim($cpo[$i]))))
			{
				echo '<input type="checkbox" name="cpo[]" value="'.$sql_row['CPO'].'" checked >'.$sql_row['CPO'].'<br>';
				$check=1;
			}
		}
		if($check==0)
		{
			echo '<input type="checkbox" name="cpo[]" value="'.$sql_row['CPO'].'">'.$sql_row['CPO'].'<br>';
		}
	}

	echo "</div>";
	echo "</td>";
	
	echo "<td>";
	echo '<div  class="scroll">';
	
	
	$sql="select distinct buyer_div from $bai_pro2.order_status_buffer $criteria order by buyer_div";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$check=0;
		for($i=0;$i<sizeof($buyer_div);$i++)
		{
			if(!(strcmp(trim($sql_row['buyer_div']),trim($buyer_div[$i]))))
			{
				echo '<input type="checkbox" name="buyer_div[]" value="'.$sql_row['buyer_div'].'"  checked>'.$sql_row['buyer_div'].'<br>';
				$check=1;
			}
		}
		if($check==0)
		{
			echo '<input type="checkbox" name="buyer_div[]" value="'.$sql_row['buyer_div'].'" >'.$sql_row['buyer_div'].'<br>';
		}
	
	}
	echo "</div>";
	echo "</td>";
	
	echo "<td>";
	echo '<div  class="scroll">';
	$sql="select distinct style from $bai_pro2.order_status_buffer $criteria order by style";
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$check=0;
		for($i=0;$i<sizeof($style);$i++)
		{
			if(!(strcmp(trim($sql_row['style']),trim($style[$i]))))
			{
				echo '<input type="checkbox" name="style[]" value="'.$sql_row['style'].'" checked>'.$sql_row['style'].'<br>';
				$check=1;
			}
		}
		if($check==0)
		{
			echo '<input type="checkbox" name="style[]" value="'.$sql_row['style'].'" >'.$sql_row['style'].'<br>';
		}
	}
	echo "</div>";
	echo "</td>";
	
	
	echo "<td>";
	echo '<div  class="scroll">';
	$sql="select distinct style_id from $bai_pro2.order_status_buffer $criteria order by style_id";
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$check=0;
		for($i=0;$i<sizeof($style_id);$i++)
		{
			if(!(strcmp(trim($sql_row['style_id']),trim($style_id[$i]))))
			{
				echo '<input type="checkbox" name="style_id[]" value="'.$sql_row['style_id'].'"  checked>'.$sql_row['style_id'].'<br>';
				$check=1;
			}
		}
		if($check==0)
		{
			echo '<input type="checkbox" name="style_id[]" value="'.$sql_row['style_id'].'" >'.$sql_row['style_id'].'<br>';
		}
	}
	echo "</div>";
	echo "</td>";
	
	
		echo "<td>";
	echo '<div  class="scroll">';
	$sql="select distinct (schedule*1) as sch_no from $bai_pro2.order_status_buffer $criteria order by schedule";
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$check=0;
		for($i=0;$i<sizeof($schedule);$i++)
		{
			if(!(strcmp(trim($sql_row['sch_no']),trim($schedule[$i]))))
			{
				echo '<input type="checkbox" name="schedule[]" value="'.$sql_row['sch_no'].'"  checked>'.$sql_row['sch_no'].'<br>';
				$check=1;
			}
		}
		if($check==0)
		{
			echo '<input type="checkbox" name="schedule[]" value="'.$sql_row['sch_no'].'" >'.$sql_row['sch_no'].'<br>';
		}
	}
	echo "</div>";
	echo "</td>";
	
		
	
	echo "<td>";
	echo '<div  class="scroll">';
	$sql="select distinct color from $bai_pro2.order_status_buffer $criteria order by color";
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$check=0;
		for($i=0;$i<sizeof($color);$i++)
		{
			if(!(strcmp(trim($sql_row['color']),trim($color[$i]))))
			{
				echo '<input type="checkbox" name="color[]" value="'.$sql_row['color'].'"  checked>'.$sql_row['color'].'<br>';
				$check=1;
			}
		}
		if($check==0)
		{
			echo '<input type="checkbox" name="color[]" value="'.$sql_row['color'].'" >'.$sql_row['color'].'<br>';
		}
	}
	echo "</div>";
	echo "</td>";
	
	echo "<td>";
		echo 'From: <input type="text" data-toggle="datepicker" name="from_date" value="';if($from_date==""){ echo date("Y-m-d"); } else { echo $from_date; } echo '"><br/>';
		echo 'To: <input type="text" data-toggle="datepicker" name="to_date" value="';if($to_date==""){ echo date("Y-m-d"); } else { echo $to_date; } echo '"><br/>';
	echo "</td>";
	echo "</tr>";
	
	
	
	echo "<tr>";
	echo "<td>";
	echo '<a href="#" onclick="SetAllCheckBoxes(\'test\', \'cpo[]\', true);">ON</a> | ';
	echo '<a href="#" onclick="SetAllCheckBoxes(\'test\', \'cpo[]\', false);">OFF</a>';
	echo "</td>";
	
	echo "<td>";
	echo '<a href="#" onclick="SetAllCheckBoxes(\'test\', \'buyer_div[]\', true);">ON</a> | ';
	echo '<a href="#" onclick="SetAllCheckBoxes(\'test\', \'buyer_div[]\', false);">OFF</a>';
	echo "</td>";
	
	
	echo "<td>";
	echo '<a href="#" onclick="SetAllCheckBoxes(\'test\', \'style[]\', true);">ON</a> | ';
	echo '<a href="#" onclick="SetAllCheckBoxes(\'test\', \'style[]\', false);">OFF</a>';
	echo "</td>";
	
	echo "<td>";
	echo '<a href="#" onclick="SetAllCheckBoxes(\'test\', \'style_id[]\', true);">ON</a> | ';
	echo '<a href="#" onclick="SetAllCheckBoxes(\'test\', \'style_id[]\', false);">OFF</a>';
	echo "</td>";
	
	echo "<td>";
	echo '<a href="#" onclick="SetAllCheckBoxes(\'test\', \'schedule[]\', true);">ON</a> | ';
	echo '<a href="#" onclick="SetAllCheckBoxes(\'test\', \'schedule[]\', false);">OFF</a>';
	echo "</td>";
	
	echo "<td>";
	echo '<a href="#" onclick="SetAllCheckBoxes(\'test\', \'color[]\', true);">ON</a> | ';
	echo '<a href="#" onclick="SetAllCheckBoxes(\'test\', \'color[]\', false);">OFF</a>';
	echo "</td>";
	
	if($date_filter==1)
	{
		echo '<td>Ex. Fact. Filter:<input type="checkbox" name="date_filter" value="1" checked></td>';
	}
	else
	{
		echo '<td>Ex. Fact. Filter:<input type="checkbox" name="date_filter" value="1"></td>';
	}
	
	echo "</tr>";
	
	echo "</table></div><br>";
	echo '<span id="msg" style="display:none;"><b><font color="red">Please Wait...</font></b></span>';
	echo "<input type=submit id=\"submit1\" name=\"submit1\" class='btn btn-primary' value=\"Filter\" onclick=\"document.getElementById('submit1').style.display='none'; document.getElementById('msg').style.display='';\">"; 
	echo '<div class="pull-right"><a href="#" onclick="checkall();">Check All</a> | ';
	echo '<a href="#" onclick="uncheckall();">Uncheck All</a> | ';
	echo "<a href='?r=".$_GET['r']."'>Clear Filter</a></div>";
?>

</form>

<?php

	if($count == 0){
			echo "<div class=' col-sm-12'><p class='alert alert-danger'>No Data Found</p></div><script>$('#main_content').hide();</script>";
		}

if(isset($_POST['submit1']))
{
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
	$cpo=$_POST['cpo'];
	$buyer_div=$_POST['buyer_div'];
	$style_id=$_POST['style_id'];
	$date_filter=$_POST['date_filter'];
	$from_date=$_POST['from_date'];
	// $from_date= date("Y-m-d", strtotime($_POST['from_date']));
	$to_date=$_POST['to_date'];
	// $to_date=date("Y-m-d", strtotime($_POST['to_date']));
	// if (empty($style) or empty($schedule) or empty($color) or empty($cpo) or empty($buyer_div) or empty($style_id)) {
	// 	echo '<div class="alert alert-danger">
	// 		  <strong>Warning!</strong> Please Select atleast one Category
	// 		</div>';
	// } else {
	// 	echo "Something";
	// }
	
	$cpo_code='';
	for($i=0;$i<sizeof($cpo);$i++)
	{
		$cpo_code='"'.$cpo[$i].'"'.', '.$cpo_code;	
	}
	//echo " and style in (".substr($style_code,0,-2).")";
	
	$buyer_div_code="";
	for($i=0;$i<sizeof($buyer_div);$i++)
	{
		//$buyer_div_code="'".$buyer_div[$i]."'".", ".$buyer_div_code;
		$buyer_div_code='"'.$buyer_div[$i].'"'.", ".$buyer_div_code; //2011-08-04 issue	
	}

	
	$style_code="";
	for($i=0;$i<sizeof($style);$i++)
	{
		$style_code="'".$style[$i]."'".", ".$style_code;	
	}
	
	$style_id_code="";
	for($i=0;$i<sizeof($style_id);$i++)
	{
		$style_id_code="'".$style_id[$i]."'".", ".$style_id_code;	
	}
	
	
	$schedule_code="";
	for($i=0;$i<sizeof($schedule);$i++)
	{
		$schedule_code="'".$schedule[$i]."'".", ".$schedule_code;
	}

	
	$color_code="";
	for($i=0;$i<sizeof($color);$i++)
	{
		$color_code="'".$color[$i]."'".", ".$color_code;
	}

	
	$criteria="";
	
	if(strlen($style_code)>2)
	{
		$criteria=$criteria." and style in (".substr($style_code,0,-2).")";
	}
	
	if(strlen($schedule_code)>2)
	{
		$criteria=$criteria." and schedule in (".substr($schedule_code,0,-2).")";
	}
	
	if(strlen($color_code)>2)
	{
		$criteria=$criteria." and color in (".substr($color_code,0,-2).")";
	}
	
	if(strlen($style_id_code)>2)
	{
		$criteria=$criteria." and style_id in (".substr($style_id_code,0,-2).")";
	}
	
	if(strlen($cpo_code)>2)
	{
		$criteria=$criteria.' and CPO in ('.substr($cpo_code,0,-2).')';
	}
	
	if(strlen($buyer_div_code)>2)
	{
		$criteria=$criteria." and buyer_div in (".substr($buyer_div_code,0,-2).")";
	}
	
	if($date_filter==1)
	{
		$criteria.=" and exf_date between \"$from_date\" and \"$to_date\"";
	}
	
	$order_status_buffer="temp_pool_db.".$username.date("YmdHis")."_"."order_status_buffer";
	
	$sql="create TEMPORARY table $order_status_buffer ENGINE = MyISAM select * from $bai_pro2.order_status_buffer";
	$newwww = $sql;
	mysqli_query($link, $sql) or exit("Sql Error1z".mysqli_error($GLOBALS["___mysqli_ston"]));

	$sql1="delete from $bai_pro2.order_status_buffer";
	mysqli_query($link, $sql1) or exit("Sql Error2z".mysqli_error($GLOBALS["___mysqli_ston"]));

	$sql1="insert into $bai_pro2.order_status_buffer (cust_order,CPO,buyer_div,style,style_id,schedule,color,exf_date,ssc_code,order_qty) select Cust_order,CPO,buyer_div,style_no,style_id,schedule_no,color,exfact_date,ssc_code,order_qty from $bai_pro2.shipment_plan_summ";
	mysqli_query($link, $sql1) or exit("Sql Error3z".mysqli_error($GLOBALS["___mysqli_ston"]));

	
	$ssc_code_filter="temp_pool_db.".$username.date("YmdHis")."_"."ssc_code_filter";
	
	$sql="create TEMPORARY table $ssc_code_filter ENGINE = MyISAM select * from $bai_pro2.ssc_code_filter";
	mysqli_query($link, $sql) or exit("Sql Error4z".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="delete from  $bai_pro2.ssc_code_filter";
	mysqli_query($link, $sql) or exit("Sql Error5z".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	
		
	if(strlen(substr($criteria,4))>2)
	{
		$sql='';
		$sql="select distinct ssc_code from $bai_pro2.order_status_buffer where ".substr($criteria,4);
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$sql1="insert ignore into  $bai_pro2.ssc_code_filter(ssc_code) values(\"".$sql_row['ssc_code']."\")";
			mysqli_query($link, $sql1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}

	echo '<form action="'."../".getFullURL($_GET['r'],"export_excel1.php",'R').'" method ="post" > 
	<input type="hidden" name="csv_123" id="csv_123">
	<input class="pull-right btn btn-info" type="submit" id="excel" value="Export to Excel" onclick="getCSVData()">
	</form>';
			
			

	echo "<div class='table-responsive' style=\"visibility:hidden;\"><table id=\"table1\"  class=\" table table-bordered\"><thead>";
	echo "<tr class='info'>";
	echo "<th>Customer Order</th>";
	echo "<th>MPO</th>";	
	echo "<th>CPO</th>";
	echo "<th>Buyer Division</th>";
	echo "<th>Style</th>";
	echo "<th>User Def. Style</th>";
	echo "<th>Schedule</th>";
	echo "<th>Color</th>";
	echo "<th>Ex-Factory Date</th>";
	echo "<th>Order Qty</th>";
	echo "<th>Cut Qty</th>";
	echo "<th>%</th>";
	echo "<th>Sewing In Qty</th>";
	echo "<th>%</th>";
	echo "<th>Sewing Out Qty</th>";
	echo "<th>%</th>";
	echo "<th>Pack Qty</th>";
	echo "<th>%</th>";
	echo "<th>Ship Qty</th>";
	echo "<th>%</th>";
	echo "</tr></thead><tbody>";

	$sql11="select distinct ssc_code from  $bai_pro2.ssc_code_filter";
	// echo $sql11;
	$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row11=mysqli_fetch_array($sql_result11))
	{
	
		$cut_qty=0;
		$sewing_in=0;
		$sewing_out=0;
		$pack_qty=0;
		$ship_qty=0;
		
		
		$ssc_code=$sql_row11['ssc_code'];
		
		$cut_qty_today=0;
		$sewing_in_today=0;
		$sewing_out_today=0;
		$pack_qty_today=0;
		$ship_qty_today=0;

		$cust_order="";
		$cpo="";
		$mpo="";
		$buyer_div="";
		$style_no="";
		$schedule_no="";
		$color="";
		$exfact_date="";
		$order_qty=0;
		
		$style_id="";

	
	
		$sql="select * from $bai_pro2.style_status_summ where ssc_code=\"$ssc_code\"";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error11aa".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
		} 
		
		$sql1="select act_cut,act_in,output,act_fg,act_ship from $bai_pro3.bai_orders_db_confirm where order_tid=\"$ssc_code\"";
		// echo $sql1."<br>";

		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$cut_qty=$sql_row1['act_cut'];
			$sewing_in=$sql_row1['act_in'];
			$sewing_out=$sql_row1['output'];
			$pack_qty=$sql_row1['act_fg'];
			$ship_qty=$sql_row1['act_ship'];
		
			
			//Taking from live
			
			//TO Extract Old Data
			if($cut_qty==0)
			{
				$cut_qty=$sql_row['cut_qty'];
			}
			if($sewing_in==0)
			{
				$sewing_in=$sql_row['sewing_in'];
			}
			if($sewing_out==0)
			{
				$sewing_out=$sql_row['sewing_out'];
			}
			if($pack_qty==0)
			{
				$pack_qty=$sql_row['pack_qty'];
			}
			if($ship_qty==0)
			{
				$ship_qty=$sql_row['ship_qty'];
			}
			//To Extract Old Data
		
			
			
			$style_no=$sql_row['style'];
			$schedule_no=$sql_row['sch_no'];
			$color=$sql_row['color'];
			

			$sql1="select Cust_order,CPO,buyer_div,style,schedule,color,exf_date,order_qty,style_id from $bai_pro2.order_status_buffer  where ssc_code=\"$ssc_code\"";
			// echo $sql1;
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result1_count=mysqli_num_rows($sql_result1);
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				
				
				
				$cust_order=$sql_row1['Cust_order'];
				$cpo=$sql_row1['CPO'];
				$mpo=$sql_row1['MPO'];
				$buyer_div=$sql_row1['buyer_div'];
				$style_no=$sql_row1['style'];
				$schedule_no=$sql_row1['schedule'];
				$color=$sql_row1['color'];
				$exfact_date=$sql_row1['exf_date'];
				$order_qty=$sql_row1['order_qty'];
				
				$style_id=$sql_row1['style_id'];
			
			
			}
			
			
			
			echo "<tr>";
			
			echo "<td>$cust_order</td>";
			echo "<td>$mpo</td>";
			echo "<td>$cpo</td>";
			echo "<td>$buyer_div</td>";
			echo "<td>$style_no</td>";
			echo "<td>$style_id</td>";
			echo "<td>$schedule_no</td>";
			echo "<td>$color</td>";
			echo "<td>$exfact_date</td>";
			echo "<td>$order_qty</td>";
			echo "<td>$cut_qty</td>";
			if($order_qty>0)
			{
				echo "<td>".round(($cut_qty/$order_qty)*100,0)."%</td>";
			}
			else
			{
				echo "<td>0%</td>";
			}

			echo  "<td>$sewing_in</td>";

			if($order_qty>0)
			{
				echo "<td>".round(($sewing_in/$order_qty)*100,0)."%</td>";
			}
			else
			{
				echo "<td>0%</td>";
			}

			echo  "<td>$sewing_out</td>";

			if($order_qty>0)
			{
				echo "<td>".round(($sewing_out/$order_qty)*100,0)."%</td>";
			}
			else
			{
				echo "<td>0%</td>";
			}

			echo  "<td>$pack_qty</td>";

			if($order_qty>0)
			{
				echo "<td>".round(($pack_qty/$order_qty)*100,0)."%</td>";
			}
			else
			{
				echo "<td>0%</td>";
			}

			echo  "<td>$ship_qty</td>";

			if($order_qty>0)
			{
				echo "<td>".round(($ship_qty/$order_qty)*100,0)."%</td>";
			}
			else
			{
				echo "<td>0%</td>";
			}

			echo "</tr>";
		}
    


	}
	echo "</tbody></table></div>"; 
	if($sql_result1_count==0){
		echo"<style>#table1{display:none;}</style>";
		echo"<style>#excel{display:none;}</style>";
	}
	
}

?>	

<script language="javascript">
function getCSVData(){
 var csv_value=$('#table1').table2CSV({delivery:'value'});
 $("#csv_123").val(csv_value);	
}
//<![CDATA[
	$('#reset_table1').addClass('btn btn-warning');
	var table6_Props = 	{
							rows_counter: true,
							btn_reset: true,
							// btn_reset_text: "Clear",
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "table1",table6_Props );
	$(document).ready(function(){
		$('#reset_table1').addClass('btn btn-warning btn-xs');
	});
	//]]>
</script>

</div></div>
</html>


	














<head>
 <?php 
 error_reporting(0);
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R'));
 $view_access=user_acl("SFCS_0025",$username,1,$group_id_sfcs); 
 ?>
<LINK href="<?= getFullURLLevel($_GET['r'],'style.css',1,'R'); ?>" rel="stylesheet" type="text/css">
<!-- <script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/datetimepicker_css.js',2,'R'); ?>"></script> -->
<!-- <link href="<?= getFullURLLevel($_GET['r'],'styles/sfcs_styles.css',4,'R'); ?>" rel="stylesheet" type="text/css" /></head> -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/actb.js',4,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/tablefilter.js',4,'R'); ?>"></script>


<body>

<div class="panel panel-primary">
<div class="panel-heading">COD Report</div>
<div class="panel-body">
<!--<div id="page_heading"><span style="float"><h3>COD Report</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>-->

<form name="test" method="post" action="index.php?r=<?php echo $_GET['r']; ?>">
<div class="col-sm-3">
From Date: <input type="text" data-toggle='datepicker' class="form-control" name="fdate" size="8" id="demo1" value="<?php  if(isset($_POST['fdate'])) { echo $_POST['fdate']; } else { echo date("Y-m-d"); } ?>" >
 </div>
 <div class="col-sm-3">
 To Date: <input type="text" data-toggle='datepicker' class="form-control" name="tdate" size="8" id="demo2" value="<?php  if(isset($_POST['tdate'])) { echo $_POST['tdate']; } else { echo date("Y-m-d"); } ?>" >
 </div>
<?php 
$sql="SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";

$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$buyer_code[]=$sql_row["buyer_div"];
	$buyer_name[]=$sql_row["buyer_name"];
}

?>
			
<div class="col-sm-3">	
Buyer Division: <select name="view_div" id="view_div" class="form-control">

	<option value='ALL' <?php if($division=="ALL"){ echo "selected"; } ?> >All</option>
<?php
	for($i=0;$i<sizeof($buyer_name);$i++)
	{
		if($buyer_name[$i]==$division) 
		{ 
			echo "<option value=\"".($buyer_name[$i])."\" selected>".$buyer_code[$i]."</option>";	
		}
		else
		{
			echo "<option value=\"".($buyer_name[$i])."\"  >".$buyer_code[$i]."</option>";			
		}
	}
?>
</select>
</div>





<!-- echo 'Buyer Division: <select name="view_div" id="view_div" >';
if($_POST['view_div']=="ALL") { echo "<option value=\"ALL\" selected>All</option>"; } else { echo "<option value=\"ALL\">All</option>"; }
if($_POST['view_div']=="'P','K'") { echo "<option value=\"'P','K'\" selected>Pink</option>"; } else { echo "<option value=\"'P','K'\">Pink</option>"; }
if($_POST['view_div']=="'L','O','G'") { echo "<option value=\"'L','O','G'\" selected>Logo</option>"; } else { echo "<option value=\"'L','O','G'\">Logo</option>"; }
if($_POST['view_div']=="'M'") { echo "<option value=\"'M'\" selected>M&S</option>"; } else { echo "<option value=\"'M'\">M&S</option>"; }
echo '</select>'; -->
</br>
<div class="col-sm-3">
<input type="submit" name="submit" value="Show" onclick='return verify_date()' class="btn btn-primary"></div>
</form>

<?php

if(isset($_POST['submit']))
{
	$fdate=$_POST['fdate'];
	$tdate=$_POST['tdate'];
	
	// $buyer_div="";
	// if($_POST['view_div']!="ALL")
	// {
	// 	$buyer_div=" and left(style,1) in (\"".$_POST['view_div']."\")";
	// }
	if($_POST["view_div"]!='ALL' && $_POST["view_div"]!='')
	{
		//echo "Buyer=".urldecode($_GET["view_div"])."<br>";
		$buyer_division=urldecode($_POST["view_div"]);
		//echo '"'.str_replace(",",'","',$buyer_division).'"'."<br>";
		$buyer_division_ref='"'.str_replace(",",'","',$buyer_division).'"';
		$buyer_div="and schedule in (select order_del_no from $bai_pro3.bai_orders_db where order_div in (".$buyer_division_ref."))";
	}
	else {
		 $buyer_div='';
	}
	
	$sql="select * from $bai_kpi.delivery_delays_track where ex_fact between \"$fdate\" and \"$tdate\" $buyer_div";
	// echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$count_res = mysqli_num_rows($sql_result);
	if($count_res >0){
		echo "<hr><div class=\"table-responsive\"><table class=\"table table-bordered\" id='table_one'>";
		echo "<tr style='background-color:#6995d6;color:white'>";
		echo "<th>Status</th>";
		echo "<th>Style</th>";
		echo "<th>Schedule</th>";
		echo "<th>Color</th>";
		echo "<th>Order Quantity</th>";
		echo "<th>RM</th>";
		echo "<th>Cut</th>";
		echo "<th>Input</th>";
		echo "<th>Input Time</th>";
		echo "<th>Sec1</th>";
		echo "<th>Sec2</th>";
		echo "<th>Sec3</th>";
		echo "<th>Sec4</th>";
		echo "<th>Sec5</th>";
		echo "<th>Sec6</th>";
		echo "<th>Sewing Time</th>";
		echo "<th>FG Time</th>";
		echo "</tr>";
		while($sql_row=mysqli_fetch_array($sql_result))
	{
		$status=$sql_row['status'];
		
		switch($status)
		{
			case 0:
			{
				$status="RM";
				break;
			}
			case 6:
			{
				$status="RM";
				break;
			}
			case 5:
			{
				$status="Cutting";
				break;
			}
			case 4:
			{
				$status="Sewing";
				break;
			}
			case 3:
			{
				$status="Packing";
				break;
			}
		}
		
		$ref_id=$sql_row['track_id'];
		
		$sql1="select actu_sec1, actu_sec2, actu_sec3, actu_sec4, actu_sec5, actu_sec6,act_cut,act_in from $bai_pro4.week_delivery_plan where ref_id=$ref_id";
		// echo $sql1;
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$sec1=$sql_row1['actu_sec1'];
			$sec2=$sql_row1['actu_sec2'];
			$sec3=$sql_row1['actu_sec3'];
			$sec4=$sql_row1['actu_sec4'];
			$sec5=$sql_row1['actu_sec5'];
			$sec6=$sql_row1['actu_sec6'];
			$cut=$sql_row1['act_cut'];
			$in=$sql_row1['act_in'];
			
		}
		
		echo "<tr>";
		echo "<td>".$status."</td>";
		echo "<td>".$sql_row['style']."</td>";
		echo "<td>".$sql_row['schedule']."</td>";
		echo "<td>".$sql_row['color']."</td>";
		echo "<td>".$sql_row['order_qty']."</td>";
		echo "<td>";
		if($sql_row['rm']>0) { echo $sql_row['rm']-($sql_row['order_qty']-$cut); } else { echo "0"; }
		echo "</td>";
		echo "<td>".abs($cut-$sql_row['cut'])."</td>";
		echo "<td>".abs($in-$sql_row['input'])."</td>";
		echo "<td>".$sql_row['input_time']."</td>";
		echo "<td>".abs($sec1-$sql_row['sec1'])."</td>";
		echo "<td>".abs($sec2-$sql_row['sec2'])."</td>";
		echo "<td>".abs($sec3-$sql_row['sec3'])."</td>";
		echo "<td>".abs($sec4-$sql_row['sec4'])."</td>";
		echo "<td>".abs($sec5-$sql_row['sec5'])."</td>";
		echo "<td>".abs($sec6-$sql_row['sec6'])."</td>";
		echo "<td>".$sql_row['sewing_time']."</td>";
		echo "<td>".$sql_row['fg_time']."</td>";
		echo "</tr>";
	}
	echo "</table></div>";
	}	else{
		echo "<hr><div class='alert alert-danger'>No Data Found..</div>";
	}
	
}
?>
</div></div>
</body>
<script >
function verify_date()
{
	var val1 = $('#demo1').val();
	var val2 = $('#demo2').val();
	// d1 = new Date(val1);
	// d2 = new Date(val2);
	if(val1 > val2){
		sweetAlert('Start Date Should  be less than End Date','','warning');
		return false;
	}
	else
	{
	    return true;
	}
}

var table2_Props = 	{					
					// col_1: "select",
					// col_2: "select",
					// col_3: "select",
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
</script>

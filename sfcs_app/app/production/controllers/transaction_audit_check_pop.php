<?php  include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/functions.php',3,'R'));   ?>
<?php
//Date 2013-11-25/Ticket#100078/ Added Carton Track and AOD details
//08-09-2016/removed user_acl in the page
?>
<html>
<head>
<title>POP: Transaction Audit Log</title>
<style type="text/css" media="screen">
@import "<?= getFullURLLevel($_GET['r'],'common/js/filtergrid.css',3,'R');?>";
</style>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/actb.js',3,'R');?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/tablefilter.js',3,'R');?>"></script>


<script>
function popitup(url) {

newwindow=window.open(url,'name','scrollbars=1,menubar=1,resizable=1,location=0,toolbar=0');
if (window.focus) {newwindow.focus();}
return false;
}
</script>

<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R');?>"></script>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',1,'R'); ?>" type="text/css" media="all" />

<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

</head>


<body>

<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 
 ?>
 <div class="panel panel-primary" style="height:130px;">
<div class="panel-heading" style="height:40px;"><span style="float: left"><h3 style="margin-top: -2px;">Quick Transaction Audit</h3></span></div>
<?php
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	$shift=$_POST['shift'];
	$module=$_POST['module'];
	
?>

<form name="text" method="post" action="<?= getFullURLLevel($_GET['r'],'transaction_audit_check_pop.php',0,'N'); ?>" style="padding-top: 11px;">
<div class="col-md-2">
Select Schedule : <input type="text" class="form-control" name="schedule" value="<?php echo $_POST['schedule']; ?>" size="10"> 
</div>
<input type="submit" value="submit" name="submit" class="btn btn-success" style="margin-top: 19px;">
</form>
</div>

<?php
if(isset($_POST['submit']))
{
	$schedule=$_POST['schedule'];
	echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color=\"red\">Please wait while preparing report...</font></h1></center></div>";
	
	ob_end_flush();
	flush();
	usleep(10);
	
	//Date 2013-11-25/Ticket#100078/ Added Carton Track and AOD details
echo "<h2>Production Status</h2>";
$url1=getFullURLLevel($_GET['r'],'transaction_audit_schedule.php',0,'R');
echo "<br/><h3><a href=\"$url1?schedule=$schedule\" onclick=\"return popitup("."'"."$url1?schedule=$schedule"."'".")\" class='btn btn-success' style=\"margin-top: -35px;\">Production Status</a></h3><br/>";

	//if($username=="kirang")
	{
		include("transaction_audit_recon_check.php");
	}

//echo "<div>";
echo "<div class=\"panel panel-primary\"><div class=\"panel-heading\"><h2>Plan Board Transaction Log</h2></div>";
echo "<table id=\"table10\" border=1 class='table table-bordered'>";
echo "<tr><th>Docket ID</th><th width=\"150\">What</th><th>Who</th><th>When</th></tr>";


//$sql="select * from $bai_pro3.plan_dashboard_change_log where doc_no in (select doc_no from $bai_pro3.order_cat_doc_mk_mix where order_del_no=\"$schedule\")";
$sql="select * from $bai_pro3.jobs_movement_track where doc_no in (select doc_no from $bai_pro3.order_cat_doc_mk_mix where order_del_no=\"$schedule\")";
//echo $sql;
mysqli_query($link,$sql) or exit("Sql Error14".mysqli_error());
$sql_result=mysqli_query($link,$sql) or exit("Sql Error15".mysqli_error());
while($sql_row=mysqli_fetch_array($sql_result))
{
	
		echo "<tr>";

		echo "<td>".$sql_row['doc_no']."</td>";
		echo "<td>".$sql_row['from_module']." - ".$sql_row['to_module']."</td>";
		echo "<td>".$sql_row['username']."</td>";
		echo "<td>".$sql_row['log_time']."</td>";
		echo "</tr>";
}


echo "</table>";
echo "</div>";
?>

<?php

	
//echo "<div>";
echo "<div class='table-responsive'><div class=\"panel panel-primary\" style=\"width:2000px\"><div class=\"panel-heading\"><h2>BAI Log</h2></div>";
echo "<table id=\"table1\" border=1 class='table table-bordered'>";
echo "<tr><th>Date</th><th>Module</th><th>Section</th><th>Shift</th><th>User Style</th><th>Movex Style</th><th>Schedule</th><th>Color</th><th>Job No</th><th>DocketNo</th><th>Qty</th><th>SMV</th><th>NOP</th><th>XS</th><th>S</th><th>M</th><th>L</th><th>XL</th><th>XXL</th><th>XXXL</th><th>s06</th><th>s08</th><th>s10</th><th>s12</th><th>s14</th><th>s16</th><th>s18</th><th>s20</th><th>s22</th><th>s24</th><th>s26</th><th>s28</th><th>s30</th></tr>";


$sql="select tid,bac_no,bac_sec,bac_date,bac_shift,sum(bac_Qty) as \"bac_Qty\",bac_lastup,bac_style,ims_doc_no,ims_tid,ims_table_name,log_time,smv,nop, sum(size_xs) as \"size_xs\", sum(size_s) as \"size_s\", sum(size_m) as \"size_m\", sum(size_l) as \"size_l\", sum(size_xl) as \"size_xl\", sum(size_xxl) as \"size_xxl\", sum(size_xxxl) as \"size_xxxl\", sum(size_s06) as \"size_s06\",sum(size_s08) as \"size_s08\", sum(size_s10) as \"size_s10\", sum(size_s12) as \"size_s12\", sum(size_s14) as \"size_s14\", sum(size_s16) as \"size_s16\", sum(size_s18) as \"size_s18\", sum(size_s20) as \"size_s20\", sum(size_s22) as \"size_s22\", sum(size_s24) as \"size_s24\", sum(size_s26) as \"size_s26\", sum(size_s28) as \"size_s28\",sum(size_s30) as \"size_s30\" from $bai_pro.bai_log where delivery=\"$schedule\" group by tid order by ims_doc_no";
mysqli_query($link,$sql) or exit("Sql Error1".mysqli_error());
$sql_result=mysqli_query($link,$sql) or exit("Sql Error2".mysqli_error());
while($sql_row=mysqli_fetch_array($sql_result))
{
	$tid=$sql_row['tid'];
	$module=$sql_row['bac_no'];
	$section=$sql_row['bac_sec'];
	$date=$sql_row['bac_date'];
	$shift=$sql_row['bac_shift'];
	$qty=$sql_row['bac_Qty'];
	$lastup=$sql_row['bac_lastup'];
	$userstyle=$sql_row['bac_style'];
	$doc_no=$sql_row['ims_doc_no'];
	$ims_tid=$sql_row['ims_tid'];
	$ims_table_name=$sql_row['ims_table_name'];
	$log_time=$sql_row['log_time'];
	$smv=$sql_row['smv'];
	$nop=$sql_row['nop'];
	
	$xs=$sql_row['size_xs'];
	$s=$sql_row['size_s'];
	$m=$sql_row['size_m'];
	$l=$sql_row['size_l'];
	$xl=$sql_row['size_xl'];
	$xxl=$sql_row['size_xxl'];
	$xxxl=$sql_row['size_xxxl'];
	$s06=$sql_row['size_s06'];
	$s08=$sql_row['size_s08'];
	$s10=$sql_row['size_s10'];
	$s12=$sql_row['size_s12'];
	$s14=$sql_row['size_s14'];
	$s16=$sql_row['size_s16'];
	$s18=$sql_row['size_s18'];
	$s20=$sql_row['size_s20'];
	$s22=$sql_row['size_s22'];
	$s24=$sql_row['size_s24'];
	$s26=$sql_row['size_s26'];
	$s28=$sql_row['size_s28'];
	$s30=$sql_row['size_s30'];

	
		
			$sql1="select * from $bai_pro3.plandoc_stat_log where doc_no=$doc_no";
			//echo $sql1;
			mysqli_query($link,$sql1) or exit("Sql Error3".mysqli_error());
			$sql_result1=mysqli_query($link,$sql1) or exit("Sql Error4".mysqli_error());
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$order_tid=$sql_row1['order_tid'];
				$cutno=$sql_row1['acutno'];
				$cat_ref=$sql_row1["cat_ref"];
			}
			
			$sql1="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
			mysqli_query($link,$sql1) or exit("Sql Error5".mysqli_error());
			$sql_result1=mysqli_query($link,$sql1) or exit("Sql Error6".mysqli_error());
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$style=$sql_row1['order_style_no'];
				$schedule=$sql_row1['order_del_no'];
				$color=$sql_row1['order_col_des'];
				$color_code=$sql_row1['color_code'];
				$$carton_id_new_create=$sql_row1["carton_id"];
				$tran_order_tid=$sql_row1["order_tid"];
				
			}
		
		$bgcolor="";	
		if($smv==0 and $nop==0)
		{
			$bgcolor="RED";
		}
				
		echo "<tr bgcolor=\"$bgcolor\">";
		
		//echo "<td>$tid</td>";
		echo "<td>$date</td>";
		echo "<td>$module</td>";
		echo "<td>$section</td>";
		echo "<td>$shift</td>";
		
		//echo "<td>$lastup</td>";
		//echo "<td>$log_time</td>";
		/*if($qty>=0)
		{
			echo "<td><a href=\"delete_transaction.php?tid=$tid&ims_tid=$ims_tid\">Delete Entry</a></td>";
		}
		else
		{
			echo "<td>Edit</td>";
		} */
		
		echo "<td>$userstyle</td>";
		echo "<td>$style</td>";
		echo "<td>$schedule</td>";
		echo "<td>$color</td>";
		echo "<td>".chr($color_code).leading_zeros($cutno,3)."</td>";
		echo "<td>$doc_no</td>";
		echo "<td>$qty</td>";
		echo "<td>".$smv."</td>";
		echo "<td>".$nop."</td>";
		
		echo "<td>$xs</td>";
		echo "<td>$s</td>";
		echo "<td>$m</td>";
		echo "<td>$l</td>";
		echo "<td>$xl</td>";
		echo "<td>$xxl</td>";
		echo "<td>$xxxl</td>";
		 echo "<td>$s06</td>";
		  echo "<td>$s08</td>";
		  echo "<td>$s10</td>";
		  echo "<td>$s12</td>";
		  echo "<td>$s14</td>";
		  echo "<td>$s16</td>";
		  echo "<td>$s18</td>";
		  echo "<td>$s20</td>";
		  echo "<td>$s22</td>";
		  echo "<td>$s24</td>";
		  echo "<td>$s26</td>";
		  echo "<td>$s28</td>";
		   echo "<td>$s30</td>";

		

		echo "</tr>";
}

echo '<tr><td>Output Total:</td><td id="table1Tot1" style="background-color:#FFFFCC; color:red;"></td></tr>';

echo "</table>";
echo"</div>";
echo"</div>";
echo"</br>";

?>

<script language="javascript" type="text/javascript">
//<![CDATA[
	var totRowIndex = tf_Tag(tf_Id('table1'),"tr").length;  
	var fnsFilters = {
	
		rows_counter: true,  
	    sort_select: true,
		on_change: true,
		display_all_text: " [ Show all ] ",
		loader: true,
		loader_text: "Filtering data...",
		btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear",
	    col_operation: { 
						id: ["table1Tot1"],
						 col: [10],  
						operation: ["sum"],
						 decimal_precision: [1],
						write_method: ["innerHTML"] ,
						exclude_row: [totRowIndex],  
                         decimal_precision: [1,0] 

					},
		rows_always_visible: [totRowIndex]  
							
	
		
	};
	var tf7 = setFilterGrid("table1", fnsFilters);
	 setFilterGrid("table1");
	setFilterGrid( "table10" );
//]]>
</script>
<?php

echo "<div class='table-responsive'><div class=\"panel panel-primary\" style=\"width:1500px;\"><div class=\"panel-heading\" ><h2>IMS Log</h2></div>";

echo "<table id=\"table111\" border=1 class=\"table table-bordered\">";
echo "<tr><th>Input Date</th><th>Layplan ID</th><th>Dockete</th><th>Module</th><th>Shift</th><th>Size</th><th>Input Qty</th><th>Output Qty</th><th>Status</th><th>Bai Log Ref</th><th>Last Update</th><th>Remarks</th><th>Style</th><th>Schedule</th><th>Color</th><th>IMS Tid</th><th>Random Track</th></tr>";

$sql="select * from $bai_pro3.ims_log where ims_schedule=\"$schedule\"";
mysqli_query($link,$sql) or exit("Sql Error7".mysqli_error());
$sql_result=mysqli_query($link,$sql) or exit("Sql Error7".mysqli_error());
$count=mysqli_num_rows($sql_result); 
while($sql_row=mysqli_fetch_array($sql_result))
{
$ims_date=$sql_row['ims_date'];
$ims_cid=$sql_row['ims_cid'];
$ims_doc_no=$sql_row['ims_doc_no'];
$ims_mod_no=$sql_row['ims_mod_no'];
$ims_shift=$sql_row['ims_shift'];
$ims_size=$sql_row['ims_size'];
$ims_qty=$sql_row['ims_qty'];
$ims_pro_qty=$sql_row['ims_pro_qty'];
$ims_status=$sql_row['ims_status'];
$bai_pro_ref=$sql_row['bai_pro_ref'];
$ims_log_date=$sql_row['ims_log_date'];
$ims_remarks=$sql_row['ims_remarks'];
$ims_style=$sql_row['ims_style'];
$ims_schedule=$sql_row['ims_schedule'];
$ims_color=$sql_row['ims_color'];
$tid=$sql_row['tid'];
$rand_track=$sql_row['rand_track'];
$size1=str_replace("a_","",$sql_row['ims_size']);
		$size2=str_replace("s","",$size1);
		$sql_size = "select * from $bai_pro3.bai_orders_db_confirm where order_style_no='".$sql_row['ims_style']."' and order_del_no='".$schedule."' and order_col_des='".$sql_row['ims_color']."'";
			
		$sql_size_result =mysqli_query($link,$sql_size) or exit("Sql Error123".mysqli_error());
		while($sql_row1=mysqli_fetch_array($sql_size_result)) {
		for($s=0;$s<sizeof($count);$s++)
			{
				
				if($sql_row1["title_size_s".$size2.""]<>'')
				{
					$s_tit=$sql_row1["title_size_s".$size2.""];
				}	
				

echo "<tr><td>".$sql_row['ims_date']."</td><td>".$sql_row['ims_cid']."</td><td>".$sql_row['ims_doc_no']."</td><td>".$sql_row['ims_mod_no']."</td><td>".$sql_row['ims_shift']."</td><td>".$s_tit."</td><td>".$sql_row['ims_qty']."</td><td>".$sql_row['ims_pro_qty']."</td><td>".$sql_row['ims_status']."</td><td>".$sql_row['bai_pro_ref']."</td><td>".$sql_row['ims_log_date']."</td><td>".$sql_row['ims_remarks']."</td><td>".$sql_row['ims_style']."</td><td>".$sql_row['ims_schedule']."</td><td>".$sql_row['ims_color']."</td><td>".$sql_row['tid']."</td><td>".$sql_row['rand_track']."</td></tr>";
			}
		}
}

$sql="select * from $bai_pro3.ims_log_backup where ims_schedule=\"$schedule\" order by ims_mod_no";
mysqli_query($link,$sql) or exit("Sql Error8".mysqli_error());
$sql_result=mysqli_query($link,$sql) or exit("Sql Error9".mysqli_error());
$count1=mysqli_num_rows($sql_result); 
while($sql_row=mysqli_fetch_array($sql_result))
{
$ims_date=$sql_row['ims_date'];
$ims_cid=$sql_row['ims_cid'];
$ims_doc_no=$sql_row['ims_doc_no'];
$ims_mod_no=$sql_row['ims_mod_no'];
$ims_shift=$sql_row['ims_shift'];
$ims_size=$sql_row['ims_size'];
$ims_qty=$sql_row['ims_qty'];
$ims_pro_qty=$sql_row['ims_pro_qty'];
$ims_status=$sql_row['ims_status'];
$bai_pro_ref=$sql_row['bai_pro_ref'];
$ims_log_date=$sql_row['ims_log_date'];
$ims_remarks=$sql_row['ims_remarks'];
$ims_style=$sql_row['ims_style'];
$ims_schedule=$sql_row['ims_schedule'];
$ims_color=$sql_row['ims_color'];
$tid=$sql_row['tid'];
$rand_track=$sql_row['rand_track'];
$size3=str_replace("a_","",$sql_row['ims_size']);
$size4=str_replace("s","",$size3);
$sql_size = "select * from $bai_pro3.bai_orders_db_confirm where order_style_no='".$sql_row['ims_style']."' and order_del_no='".$schedule."' and order_col_des='".$sql_row['ims_color']."'";
			
		$sql_size_result =mysqli_query($link,$sql_size) or exit("Sql Error123".mysqli_error());
		while($sql_row1=mysqli_fetch_array($sql_size_result)) {
		for($s=0;$s<sizeof($count1);$s++)
			{
				
				if($sql_row1["title_size_s".$size4.""]<>'')
				{
					$s_tit=$sql_row1["title_size_s".$size4.""];
				}	
				
echo "<tr><td>".$sql_row['ims_date']."</td><td>".$sql_row['ims_cid']."</td><td>".$sql_row['ims_doc_no']."</td><td>".$sql_row['ims_mod_no']."</td><td>".$sql_row['ims_shift']."</td><td>".$s_tit."</td><td>".$sql_row['ims_qty']."</td><td>".$sql_row['ims_pro_qty']."</td><td>".$sql_row['ims_status']."</td><td>".$sql_row['bai_pro_ref']."</td><td>".$sql_row['ims_log_date']."</td><td>".$sql_row['ims_remarks']."</td><td>".$sql_row['ims_style']."</td><td>".$sql_row['ims_schedule']."</td><td>".$sql_row['ims_color']."</td><td>".$sql_row['tid']."</td><td>".$sql_row['rand_track']."</td></tr>";
			}
		}
}
echo '<tr><td>Input Total:</td><td id="table111Tot1" style="background-color:#FFFFCC; color:red;"></td><td>Output Total:</td><td id="table111Tot2" style="background-color:#FFFFCC; color:red;"></td></tr>';
echo "</table>";
echo"</div>";
echo"</div>";
echo "</br>";

?>
<script language="javascript" type="text/javascript">
//<![CDATA[
	//setFilterGrid( "table111" );
var fnsFilters = {
	
	rows_counter: true,
	sort_select: true,
		on_change: true,
		display_all_text: " [ Show all ] ",
		loader_text: "Filtering data...",  
	loader: true,
	loader_text: "Filtering data...",
	btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear",
	col_operation: { 
						id: ["table111Tot1","table111Tot2"],
						 col: [6,7],  
						operation: ["sum","sum"],
						 decimal_precision: [1,1],
						write_method: ["innerHTML","innerHTML"] 
					},
	rows_always_visible: [grabTag(grabEBI('table111'),"tr").length]
							
	
		
	};
	
	 setFilterGrid("table111");
//]]>
</script>

<?php

echo "</table>";

echo "<div class=\"panel panel-primary\"><div class=\"panel-heading\"><h2>Packing Log</h2></div>";

echo "<table id=\"table1111\" border=1 class=\"table table-bordered\">";
echo "<tr><th>Docket</th><th>Docket Ref</th><th>TID</th><th>Size</th><th>Remarks</th><th>Status</th><th>Last Updated</th><th>Carton Act Qty</th><th>Style</th><th>Schedule</th><th>Color</th></tr>";
$packing_tid_list=array();
$sql="select * from $bai_pro3.packing_summary where order_del_no=\"$schedule\" order by size_code,carton_act_qty desc,tid";
mysqli_query($link,$sql) or exit("Sql Error10".mysqli_error());
$sql_result=mysqli_query($link,$sql) or exit("Sql Error11".mysqli_error());
$count2=mysqli_num_rows($sql_result); 
while($sql_row=mysqli_fetch_array($sql_result))
{

$doc_no=$sql_row['doc_no'];
$doc_no_ref=$sql_row['doc_no_ref'];
$tid=$sql_row['tid'];
$packing_tid_list[]=$sql_row['tid'];
$size_code=$sql_row['size_code'];
$remarks=$sql_row['remarks'];
$status=$sql_row['status'];
$lastup=$sql_row['lastup'];
$container=$sql_row['container'];
$disp_carton_no=$sql_row['disp_carton_no'];
$disp_id=$sql_row['disp_id'];
$carton_act_qty=$sql_row['carton_act_qty'];
$audit_status=$sql_row['audit_status'];
$order_style_no=$sql_row['order_style_no'];
$order_del_no=$sql_row['order_del_no'];
$order_col_des=$sql_row['order_col_des'];
$size5=str_replace("a_","",$sql_row['size_code']);
$size6=str_replace("s","",$size5);
$sql_size = "select * from $bai_pro3.bai_orders_db_confirm where order_style_no='".$sql_row['order_style_no']."' and order_del_no='".$schedule."' and order_col_des='".$sql_row['order_col_des']."'";
			
		$sql_size_result =mysqli_query($link,$sql_size) or exit("Sql Error123".mysqli_error());
		while($sql_row1=mysqli_fetch_array($sql_size_result)) {
		for($s=0;$s<sizeof($count1);$s++)
			{
				
				if($sql_row1["title_size_s".$size6.""]<>'')
				{
					$s_tit=$sql_row1["title_size_s".$size6.""];
				}	
echo "<tr><td>".$sql_row['doc_no']."</td><td>".$sql_row['doc_no_ref']."</td><td>".$sql_row['tid']."</td><td>".$s_tit."</td><td>".$sql_row['remarks']."</td><td>".(strlen($sql_row['status'])==0?"Pending":$sql_row['status'])."</td><td>".$sql_row['lastup']."</td><td>".$sql_row['carton_act_qty']."</td><td>".$sql_row['order_style_no']."</td><td>".$sql_row['order_del_no']."</td><td>".$sql_row['order_col_des']."</td>
</tr>";
			}
		}
}
echo '<tr><td>Total:</td><td id="table1111Tot1" style="background-color:#FFFFCC; color:red;"></td></tr>';
echo "</table>";
echo "</div>";

if($username=="kirang")
{
	echo implode($packing_tid_list,",");
}

?>


<script language="javascript" type="text/javascript">
//<![CDATA[
	setFilterGrid( "table1111" );

var fnsFilters = {
	
	rows_counter: true,
	sort_select: true,
		on_change: true,
		display_all_text: " [ Show all ] ",
		loader_text: "Filtering data...",  
	loader: true,
	loader_text: "Filtering data...",
	btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear",
	col_operation: { 
						id: ["table1111Tot1"],
						 col: [7],  
						operation: ["sum"],
						 decimal_precision: [1],
						write_method: ["innerHTML"] 
					},
	rows_always_visible: [grabTag(grabEBI('table1111'),"tr").length]
							
	
		
	};
	
	 setFilterGrid("table1111",fnsFilters);
//]]>
</script>

<?php
//Date 2013-11-25/Ticket#100078/ Added Carton Track and AOD details
echo "<h2>Packing Check List</h2>";
$url2=getFullURLLevel($_GET['r'],'packing_check_list.php',0,'R');
echo "<br/><h3><a href=\"$url2?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create\" onclick=\"return popitup("."'"."$url2?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create"."'".")\" class=\"btn btn-success\" style=\"margin-top: -35px;\">Carton Track</a></h3><br/>";

?>



<?php
//Date 2013-11-25/Ticket#100078/ Added Carton Track and AOD details
echo "<div class='table-responsive'><div class=\"panel panel-primary\" style=\"width:1500px;\"><div class=\"panel-heading\"><h2>AOD Details</h2></div>";
echo "<table id=\"table11111\" border=1 class=\"table table-bordered\">";
echo "<tr><th>order tid</th><th>update</th><th>remarks</th><th>status</th><th>style</th><th>schedule</th><th>xs</th><th>s</th><th>m</th><th>l</th><th>xl</th><th>xxl</th><th>xxxl</th><th>s06</th><th>s08</th><th>s10</th><th>s12</th><th>s14</th><th>s16</th><th>s18</th><th>s20</th><th>s22</th><th>s24</th><th>s26</th><th>s28</th><th>s30</th><th>tid</th><th>cartons</th><th>AOD no</th><th>lastup</th><th>Total QTY</th></tr>";
$sql="select * from $bai_pro3.ship_stat_log where ship_schedule=$schedule";
mysqli_query($link,$sql) or exit("Sql Erro12r".mysqli_error());
$sql_result=mysqli_query($link,$sql) or exit("Sql Error13".mysqli_error());
while($sql_row=mysqli_fetch_array($sql_result))
{
	echo "<tr><td>".$sql_row["ship_order_tid"]."</td>
<td>".$sql_row["ship_up_date"]."</td>
<td>".$sql_row["ship_remarks"]."</td>
<td>".$sql_row["ship_status"]."</td>
<td>".$sql_row["ship_style"]."</td>
<td>".$sql_row["ship_schedule"]."</td>
<td>".$sql_row["ship_s_xs"]."</td>
<td>".$sql_row["ship_s_s"]."</td>
<td>".$sql_row["ship_s_m"]."</td>
<td>".$sql_row["ship_s_l"]."</td>
<td>".$sql_row["ship_s_xl"]."</td>
<td>".$sql_row["ship_s_xxl"]."</td>
<td>".$sql_row["ship_s_xxxl"]."</td>
<td>".$sql_row["ship_s_s06"]."</td>
<td>".$sql_row["ship_s_s08"]."</td>
<td>".$sql_row["ship_s_s10"]."</td>
<td>".$sql_row["ship_s_s12"]."</td>
<td>".$sql_row["ship_s_s14"]."</td>
<td>".$sql_row["ship_s_s16"]."</td>
<td>".$sql_row["ship_s_s18"]."</td>
<td>".$sql_row["ship_s_s20"]."</td>
<td>".$sql_row["ship_s_s22"]."</td>
<td>".$sql_row["ship_s_s24"]."</td>
<td>".$sql_row["ship_s_s26"]."</td>
<td>".$sql_row["ship_s_s28"]."</td>
<td>".$sql_row["ship_s_s30"]."</td>
<td>".$sql_row["ship_tid"]."</td>
<td>".$sql_row["ship_cartons"]."</td>
<td>".$sql_row["disp_note_no"]."</td>
<td>".$sql_row["last_up"]."</td>
<td>".($sql_row["ship_s_xs"]+$sql_row["ship_s_s"]+$sql_row["ship_s_m"]+$sql_row["ship_s_l"]+$sql_row["ship_s_xl"]+$sql_row["ship_s_xxl"]+$sql_row["ship_s_xxxl"]+$sql_row["ship_s_s06"]+$sql_row["ship_s_s08"]+$sql_row["ship_s_s10"]+$sql_row["ship_s_s12"]+$sql_row["ship_s_s14"]+$sql_row["ship_s_s16"]+$sql_row["ship_s_s18"]+$sql_row["ship_s_s20"]+$sql_row["ship_s_s22"]+$sql_row["ship_s_s24"]+$sql_row["ship_s_s26"]+$sql_row["ship_s_s28"]+$sql_row["ship_s_s30"])."</td></tr>";

}
echo "</table>";
echo "</div>";
echo "</div>";
?>
<script language="javascript" type="text/javascript">
//<![CDATA[
	setFilterGrid( "table11111" );
//]]>
</script>
<?php


}
?>
<script>
	document.getElementById("msg").style.display="none";		
</script>


</body>
</html>

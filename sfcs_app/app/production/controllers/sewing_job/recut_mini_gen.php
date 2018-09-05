<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.min.js',4,'R')?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/datetimepicker_css.js',4,'R')?>"></script>
<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/style.css',4,'R')?>">
<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/table.css',4,'R')?>">

<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',4,'R')?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',4,'R')?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/filtergrid.css',4,'R')?>"></script>


<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="panel panel-primary">
<div class="panel-heading">Mini Order Generation</div>
<div class="panel-body">
<?php
set_time_limit(30000000);
// include("dbconf.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'session_track.php',0,'R'));
// include("session_track.php");
$style_id=$_GET['style'];	
$order_id=$_GET['schedule'];
$color=$_GET['col'];
$doc_num=$_GET['doc'];
$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link);
$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$order_id,$link);	
if($status == '')
{
	$min_ord_ref_id=echo_title("$brandix_bts.tbl_min_ord_ref","id","ref_product_style='".$style_id."' and ref_crt_schedule",$order_id,$link);
	$data_sym="$";
	$File = "session_track.php";
	$fh = fopen($File, 'w') or die("can't open file");
	$stringData = "<?php ".$data_sym."status=\"".$min_ord_ref_id."\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh); 
	//$mini_order_ref=356;
	$date_time=date('Y-m-d h:i:sa'); 
	
	$sizesMasterQuery="select id,upper(size_name) as size_name from $brandix_bts.tbl_orders_size_ref order by size_name";
	//echo $sizesMasterQuery;exit;
	$result=mysqli_query($link, $sizesMasterQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($s=mysqli_fetch_array($result))
	{
		if($s['size_name']=='S01')
		   {
			$s01_id=$s['id'];
		   }
		if($s['size_name']=='S02')
		   {
			$s02_id=$s['id'];
		   }
		if($s['size_name']=='S03')
		   {
			$s03_id=$s['id'];
		   }
		if($s['size_name']=='S04')
		   {
			$s04_id=$s['id'];
		   }
		if($s['size_name']=='S05')
		   {
			$s05_id=$s['id'];
		   }
		if($s['size_name']=='S06')
		   {
			$s06_id=$s['id'];
		   }
		if($s['size_name']=='S07')
		   {
			$s07_id=$s['id'];
		   }
		if($s['size_name']=='S08')
		   {
			$s08_id=$s['id'];
		   }
		if($s['size_name']=='S09')
		   {
			$s09_id=$s['id'];
		   }
		if($s['size_name']=='S10')
		   {
			$s10_id=$s['id'];
		   }
		if($s['size_name']=='S11')
		   {
			$s11_id=$s['id'];
		   }
		if($s['size_name']=='S12')
		   {
			$s12_id=$s['id'];
		   }
		if($s['size_name']=='S13')
		   {
			$s13_id=$s['id'];
		   }
		if($s['size_name']=='S14')
		   {
			$s14_id=$s['id'];
		   }
		if($s['size_name']=='S15')
		   {
			$s15_id=$s['id'];
		   }
		if($s['size_name']=='S16')
		   {
			$s16_id=$s['id'];
		   }
		if($s['size_name']=='S17')
		   {
			$s17_id=$s['id'];
		   }
		if($s['size_name']=='S18')
		   {
			$s18_id=$s['id'];
		   }
		if($s['size_name']=='S19')
		   {
			$s19_id=$s['id'];
		   }
		if($s['size_name']=='S20')
		   {
			$s20_id=$s['id'];
		   }
		if($s['size_name']=='S21')
		   {
			$s21_id=$s['id'];
		   }
		if($s['size_name']=='S22')
		   {
			$s22_id=$s['id'];
		   }
		if($s['size_name']=='S23')
		   {
			$s23_id=$s['id'];
		   }
		if($s['size_name']=='S24')
		   {
			$s24_id=$s['id'];
		   }
		if($s['size_name']=='S25')
		   {
			$s25_id=$s['id'];
		   }
		if($s['size_name']=='S26')
		   {
			$s26_id=$s['id'];
		   }
		if($s['size_name']=='S27')
		   {
			$s27_id=$s['id'];
		   }
		if($s['size_name']=='S28')
		   {
			$s28_id=$s['id'];
		   }
		if($s['size_name']=='S29')
		   {
			$s29_id=$s['id'];
		   }
		if($s['size_name']=='S30')
		   {
			$s30_id=$s['id'];
		   }
		if($s['size_name']=='S31')
		   {
			$s31_id=$s['id'];
		   }
		if($s['size_name']=='S32')
		   {
			$s32_id=$s['id'];
		   }
		if($s['size_name']=='S33')
		   {
			$s33_id=$s['id'];
		   }
		if($s['size_name']=='S34')
		   {
			$s34_id=$s['id'];
		   }
		if($s['size_name']=='S35')
		   {
			$s35_id=$s['id'];
		   }
		if($s['size_name']=='S36')
		   {
			$s36_id=$s['id'];
		   }
		if($s['size_name']=='S37')
		   {
			$s37_id=$s['id'];
		   }
		if($s['size_name']=='S38')
		   {
			$s38_id=$s['id'];
		   }
		if($s['size_name']=='S39')
		   {
			$s39_id=$s['id'];
		   }
		if($s['size_name']=='S40')
		   {
			$s40_id=$s['id'];
		   }
		if($s['size_name']=='S41')
		   {
			$s41_id=$s['id'];
		   }
		if($s['size_name']=='S42')
		   {
			$s42_id=$s['id'];
		   }
		if($s['size_name']=='S43')
		   {
			$s43_id=$s['id'];
		   }
		if($s['size_name']=='S44')
		   {
			$s44_id=$s['id'];
		   }
		if($s['size_name']=='S45')
		   {
			$s45_id=$s['id'];
		   }
		if($s['size_name']=='S46')
		   {
			$s46_id=$s['id'];
		   }
		if($s['size_name']=='S47')
		   {
			$s47_id=$s['id'];
		   }
		if($s['size_name']=='S48')
		   {
			$s48_id=$s['id'];
		   }
		if($s['size_name']=='S49')
		   {
			$s49_id=$s['id'];
		   }
		if($s['size_name']=='S50')
		   {
			$s50_id=$s['id'];
		   }
	}
	
	$sql="select * from $brandix_bts.view_extra_recut where doc_no='".$doc_num."' and order_style_no='".$style."' and order_del_no='".$schedule."' and order_col_des='".$color."'";
	//echo $sql."<br>";
	echo "<table class='table table-bordered'>";
	echo "<tr><th>Mini Order</th><th>Cut Number</th><th>Color</th><th>Size</th><th>Bundle Number</th><th>Bundle Quantity</th><th>Docket Number</th></tr>";
	$result=mysqli_query($link, $sql) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($l=mysqli_fetch_array($result))
	{
		$doc_num=$l['doc_no'];
		$cut_num=$l['acutno'];
		//$tid=$l['tid'];
		$cut_status=$l['act_cut_status'];
		$planned_module=$l['plan_module'];
		if($planned_module==NULL)
		{
			$planned_module=0;
		}
		$request_time=$l['rm_date'];
		$issued_time=$l['date'];
		$planned_plies=$l['p_plies'];
		$actual_plies=$l['a_plies'];
		$plan_date=$l['date'];
		$cat_ref=$l['cat_ref'];
		$mk_ref=$l['mk_ref'];
		$cuttable_ref=$l['cuttable_ref'];
		$product_schedule=$l['order_del_no'];
		$color_code=$l['order_col_des'];
		$style_code=$l['order_style_no'];
		$col_code=$l['color_code'];
		$insertLayPlanQuery="INSERT ignore INTO $brandix_bts.tbl_cut_master(doc_num,ref_order_num,cut_num,cut_status,planned_module,issued_time,planned_plies,actual_plies,plan_date,style_id,product_schedule,cat_ref,cuttable_ref,mk_ref,col_code) VALUES 
		('$doc_num',$order_id,$cut_num,'$cut_status','$planned_module','$issued_time',$planned_plies,$planned_plies,'$plan_date',$style_id,'$product_schedule',$cat_ref,$cuttable_ref,$mk_ref,$col_code)";
		//echo $insertLayPlanQuery."</br>";
		$result2=mysqli_query($link, $insertLayPlanQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$layplan_id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
		if($layplan_id>0)
		{	
			if($l['a_s01']>0)
			{
				$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s01_id.",".$l['a_s01'].")";
				$result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			if($l['a_s02']>0)
			{
				$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s02_id.",".$l['a_s02'].")";
				$result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s03']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s03_id.",".$l['a_s03'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s04']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s04_id.",".$l['a_s04'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s05']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s05_id.",".$l['a_s05'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s06']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s06_id.",".$l['a_s06'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s07']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s07_id.",".$l['a_s07'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s08']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s08_id.",".$l['a_s08'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s09']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s09_id.",".$l['a_s09'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s10']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s10_id.",".$l['a_s10'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s11']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s11_id.",".$l['a_s11'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s12']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s12_id.",".$l['a_s12'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s13']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s13_id.",".$l['a_s13'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s14']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s14_id.",".$l['a_s14'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s15']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s15_id.",".$l['a_s15'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s16']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s16_id.",".$l['a_s16'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s17']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s17_id.",".$l['a_s17'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s18']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s18_id.",".$l['a_s18'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s19']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s19_id.",".$l['a_s19'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s20']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s20_id.",".$l['a_s20'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s21']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s21_id.",".$l['a_s21'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s22']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s22_id.",".$l['a_s22'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s23']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s23_id.",".$l['a_s23'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s24']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s24_id.",".$l['a_s24'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s25']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s25_id.",".$l['a_s25'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s26']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s26_id.",".$l['a_s26'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s27']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s27_id.",".$l['a_s27'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s28']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s28_id.",".$l['a_s28'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s29']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s29_id.",".$l['a_s29'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s30']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s30_id.",".$l['a_s30'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s31']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s31_id.",".$l['a_s31'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s32']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s32_id.",".$l['a_s32'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s33']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s33_id.",".$l['a_s33'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s34']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s34_id.",".$l['a_s34'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s35']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s35_id.",".$l['a_s35'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s36']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s36_id.",".$l['a_s36'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s37']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s37_id.",".$l['a_s37'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s38']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s38_id.",".$l['a_s38'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s39']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s39_id.",".$l['a_s39'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s40']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s40_id.",".$l['a_s40'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s41']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s41_id.",".$l['a_s41'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s42']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s42_id.",".$l['a_s42'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s43']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s43_id.",".$l['a_s43'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s44']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s44_id.",".$l['a_s44'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s45']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s45_id.",".$l['a_s45'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s46']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s46_id.",".$l['a_s46'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s47']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s47_id.",".$l['a_s47'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s48']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s48_id.",".$l['a_s48'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s49']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s49_id.",".$l['a_s49'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			if($l['a_s50']>0)
			{
			 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s50_id.",".$l['a_s50'].")";
			 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			
			//get the last bundle number in mini order data
			$sql3="select max(bundle_number)+1 as bundle from $brandix_bts.tbl_miniorder_data";
			//echo $sql3."<br>";
			$result3=mysqli_query($link, $sql3) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rows3=mysqli_fetch_array($result3))
			{
				$bundle_number=$rows3['bundle'];
			}
			
			$layplan_Query1="SELECT cut_sizes.ref_size_name AS size_id,cut_master.cut_num,cut_sizes.id,`cut_master`.`planned_plies`,cut_master.actual_plies, cut_sizes.quantity,cut_master.actual_plies*cut_sizes.quantity AS total_cut_quantity,cut_master.doc_num AS docket_number FROM $brandix_bts.tbl_cut_master AS cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master AS cut_sizes ON cut_master.id=cut_sizes.parent_id WHERE cut_master.id='$layplan_id' group by cut_sizes.ref_size_name";
			// echo $layplan_Query1."</br>";
			$result4=mysqli_query($link, $layplan_Query1) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$layplan_result1=mysqli_num_rows($result4);
			if($layplan_result1>0)
			{
				$sno=echo_title("$brandix_bts.tbl_miniorder_data","max(mini_order_num)+1","mini_order_ref",$min_ord_ref_id,$link);
				while($l=mysqli_fetch_array($result4))
				{
					$size=$l['size_id'];
					$docket_number=$l['docket_number'];
					//$bundle_quantity=$l['actual_plies'];
					$bundle_quantity=$l['quantity']*$l['planned_plies'];
					$input_job_no=echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_del_no",$schedule,$link);
					$size_tit=echo_title("$brandix_bts.tbl_orders_sizes_master","LOWER(size_title)","ref_size_name='$size' and parent_id",$order_id,$link);
					$destination=echo_title("$bai_pro3.bai_orders_db_confirm","UPPER(destination)","order_del_no=\"".$schedule."\" and order_col_des",$color_code,$link);
					$packing_mode=echo_title("$bai_pro3.packing_summary_input","packing_mode","order_del_no=\"".$schedule."\" and order_col_des",$color_code,$link);
					$size_code_ref=echo_title("$brandix_bts.tbl_orders_size_ref","LOWER(size_name)","id",$size,$link);
					$doc_numb=str_replace('R', '', "$docket_number");
					$rand=$schedule.date("ymd").$input_job_no;
					
					echo "<tr><td>".$sno."</td><td>".$cut_num."</td><td>".$color_code."</td><td>".$size."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$l['docket_number']."</td></tr>";
					$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".date("Y-m-d h:i:s")."','".$min_ord_ref_id."','".$sno."','".$cut_num."','".$color_code."','".$size."','".$bundle_number."','".$bundle_quantity."','".$l['docket_number']."','".$sno."')";
					$result5=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$bundle_number++;

					$sql1="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,doc_type) values(\"".$doc_numb."\",\"".$size_tit."\",\"".$bundle_quantity."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$packing_mode."\",\"".$size_code_ref."\",'R')";	

					$result5=mysqli_query($link, $sql1) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		}
	}
	//$mini_order_ref=$_GET['id'];
	$data_sym="$";
	$File = "session_track.php";
	$fh = fopen($File, 'w') or die("can't open file");
	$stringData = "<?php ".$data_sym."status=\"\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh);	
	echo "</table>";
	$recut_mini_create=getFullURLLevel($_GET['r'],'recut_mini_create.php',0,'N');
	echo "<script>swal('Sewing Jobs Successfully Generated for Re-Cut Docket - $docket_number','','success');</script></br>";
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",3000); function Redirect() {  location.href = \"$recut_mini_create\"; }</script>";
}
else
{
	echo "<script>swal('Another User Generating Mini orders','Please try again','warning');</script>";
	//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",180); function Redirect() {  location.href = \"recut_mini_create.php\"; }</script>";
}


//--------------------------------------------- MO Filling Logic.. --------------------------------------------------------
	$style  = $_GET['style'];
	$schedule = $_GET['schedule'];
	$color  = $_GET['col'];
	$doc_no = $_GET['doc'];

	//getting the op_codes with sewing
	$op_code_query  ="SELECT category,group_concat(operation_code) as codes FROM $brandix_bts.tbl_orders_ops_ref 
					 WHERE default_operation='Yes' and trim(category) = 'sewing' ";
	$op_code_result = mysqli_query($link, $op_code_query) or exit("No Operation Found for Cutting");
	while($row=mysqli_fetch_array($result1216)) 
	{
		$op_codes  = $row['codes'];
		$op_name[] = $row['operation_name'];		
	}

	


	//getting the sizes to format s,m,l 
	$recut_sizes = "Select distinct(old_size) as size From $bai_pro3.pac_stat_log_input_job where doc_no = $doc_no ";
	$recut_size_result = mysqli_query($link,$recut_sizes)  or exit('Mo Operation Code Retrieval Error');
	while($row = mysqli_fetch_array($recut_size_result)){
		$old_sizes[] = $row['size'];
	}

	foreach($old_sizes as $size){
		$size_query = "select title_size_$size From $bai_pro3.bai_orders_db_confirm where TRIM(order_del_no)='$schedule' 
					and TRIM(order_style_no) = '$style' and TRIM(order_col_des) = '$color'";
		$size_result = mysqli_query($link,$size_query) or exit('Mo Operation Saving  Error');;
		while($row = mysqli_fetch_array($size_result)){
			$new_sizes[$size] = $row["title_size_$size"];
			$old_sizes1[ $row["title_size_$size"]] = $size;
		}				  
	}

//getting mos related to style and schedule
	foreach($old_sizes as $size){
		$mo_no_query = "SELECT mo.mo_no as mo_no,mo.mo_quantity as mo_quantity,SUM(bundle_quantity) as bundle_quantity,
						SUM(good_quantity) as good_quantity,SUM(rejected_quantity) as rejected_quantity
						LEFT JOIN $bai_pro3.mo_operation_quantities mop ON mo.mo_no = mop.mo_no  
						FROM $bai_pro3.mo_details mo 
						WHERE TRIM(size)='".strtoupper($new_sizes[$size])."' and schedule='$schedule' and TRIM(color)='$color' 
						and mop.op_code = 15
						group by mop.mo_no order by mo.mo_no*1"; 
		$mo_no_result  = mysqli_query($link,$mo_no_query);
		$mo_no_result2 = $mo_no_result;   
		while($row = mysqli_fetch_array($mo_no_result)){
			// if($row['op_desc'] == 'recut' )
			// 	continue;
			//$mos[] = $row['mo_no'];	
			if($row['bundle_quantity'] >= $row['good_quantity'] && $row['rejected_quantity']==0)	
				continue;
			if($row['rejected_quantity'] == 0)
				$mos[$row['mo_no']] = $row['mo_quantity'] - $row['bundle_quantity'];
			else	
				$mos[$row['mo_no']] = $row['mo_quantity'] - $row['bundle_quantity'] + $row['rejected_quantity'];
		}
		foreach($mos as $mo_no){
			//checking the mo operations exist or not
			$op_codes_query = "SELECT OperationNumber,OperationDescription FROM $bai_pro3.schedule_oprations_master 
						WHERE OperationNumber in ($op_codes) and MONumber='$mo_no' order by OperationNumber*1"; 
			$op_code_result = mysqli_query($link, $op_codes_query) or exit('Mo Operation Code Retrieval Error');
			while($row = mysqli_fetch_array($op_code_result)){
				$op_code = $row['OperationNumber']; 
				$op_desc[$op_code] = $row['OperationDescription'];
			} 
		}
		if(sizeof($mos) > 0){
			if(sizeof($mos) == 1){
				foreach($mos as $mo_no){
					//getting the recut sewing details for each size 
					$recut_jobs_details = "Select carton_act_qty,old_size,doc_no,input_job_no_random  
										From $bai_pro3.pac_stat_log_input_job where doc_no = $doc_no order by size_code 
										and size_code = '$size'";
					$recut_jobs_result = mysqli_query($link,$recut_jobs_details);
					while($row = mysqli_fetch_array($recut_jobs_result)){
						//need to get bundle number
						$bundle_no = '';
						$cart_qty = $row['carton_act_qty'];
						$input_job_no = $row['input_job_no'];
						$input_job_random = $row['input_job_random'];
						$insert_query = "Insert into bai_pro3.mo_operation_quantities(`date_time`, `mo_no`,`doc_no`,`bundle_no`,
										`bundle_quantity`, `op_code`, `op_desc`,`input_job_no`,`input_job_random`) values
										('".date('Y-m-d H:i:s')."','".$mo_no."','$doc_no','$bundle_no','$cart_qty','$op_code','$op_desc','$input_job_no','$input_job_random')";
					}		
				}
			}else{
				$recut_jobs_details = "Select carton_act_qty,old_size,doc_no,input_job_no_random  
					From $bai_pro3.pac_stat_log_input_job where doc_no = $doc_no order by size_code 
					and size_code = '$size'";
				$recut_jobs_result = mysqli_query($link,$recut_jobs_details);
				while($row = mysqli_fetch_array($recut_jobs_result)){
					//need to get bundle number
					$bundle_no = '';
					$qty = $row['carton_act_qty'];
					$input_job_no = $row['input_job_no'];
					$input_job_random = $row['input_job_random'];
				
					foreach($mos as $mo_no => $rem_cpcty){
						if($rem_cpcty == 0)
							continue;
						if($qty > $rem_cpcty){
							$qty = $qty - $rem_cpcty;
							if($qty>0){
								foreach($ops as $op_code=>$op_desc){
									$insert_query = "Insert into bai_pro3.mo_operation_quantities(`date_time`, `mo_no`,`doc_no`,`bundle_no`, `bundle_quantity`, `op_code`, `op_desc`,`input_job_no`,`input_job_random`) values
									('".date('Y-m-d H:i:s')."','".$mo_no."','$doc_no','$bundle_no','$rem_cpcty','$op_code',
									'$op_desc','$input_job_no','$input_job_random')";
									mysqli_query($link,$insert_query);
								}
								$mos[$mono] = 0;
								//break;
							}
						}else{
							foreach($ops as $op_code=>$op_desc){
								$insert_query = "Insert into bai_pro3.mo_operation_quantities(`date_time`, `mo_no`,`doc_no`,`bundle_no`, `bundle_quantity`, `op_code`, `op_desc`,`input_job_no`,`input_job_random`) values
								('".date('Y-m-d H:i:s')."','".$mo_no."','$doc_no','$bundle_no','$qty','$op_code',
								'$op_desc','$input_job_no','$input_job_random')";
								mysqli_query($link,$insert_query);
							}
							$qty = $rem_cpcty - $qty;
							$mos[$mono] = $qty;
							break;
						}	
					}
					//inserting the all the excess qty's to the last mo's within the size
					foreach($ops as $op_code=>$op_desc){
						$insert_query = "Insert into bai_pro3.mo_operation_quantities(`date_time`, `mo_no`,`doc_no`,`bundle_no`,
									    `bundle_quantity`, `op_code`, `op_desc`,`input_job_no`,`input_job_random`) values
										('".date('Y-m-d H:i:s')."','".$mo_no."','$doc_no','$bundle_no','$qty','$op_code',
										'$op_desc','$input_job_no','$input_job_random')";
						mysqli_query($link,$insert_query);
					}	
				}
			}
		}else{
			//Nothing to enter into MO
		}	
	}		   




/*
							cpcty    			qty				
					1002	20/15/10/4/0		5/		j1	s
					1003	20/19/9/			5/		j2	s
					1004	15/9/				6/		j3	s
												5/1/	j4	s
												10/		j5	s
												15		j6	s
												15		j7	s

					qty = 15 - 9 = 6
				*/


//----------------------------------------------- MO Filling Ends ---------------------------------------------------------
?>
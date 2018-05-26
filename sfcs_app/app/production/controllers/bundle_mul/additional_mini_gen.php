<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.min.js',4,'R')?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/datetimepicker_css.js',4,'R')?>"></script>
<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/style.css',4,'R')?>">
<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/table.css',4,'R')?>">
<!---<style type="text/css">
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
body{ 
	/* margin:15px; padding:15px; border:1px solid #666; */
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
}
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
</style>--->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',4,'R')?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',4,'R')?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/filtergrid.css',4,'R')?>"></script>


<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="panel panel-primary">
<div class="panel-heading">Mini Order Generation-Additional Cut</div>
<div class="panel-body">
<!---<div id="page_heading"><span style="float: left"><h3>Mini Order Generation-Additional Cut</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>--->
<?php
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
set_time_limit(30000000);
// include("dbconf.php");
include("session_track.php");
$style_id=$_GET['style_id'];	
$order_id=$_GET['sch_id'];
$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link);
$schedule = $_GET['schedule'];
if($status == '')
{
	$min_ord_ref_id=echo_title("$brandix_bts.tbl_min_ord_ref","id","ref_product_style='".$style_id."' and ref_crt_schedule",$order_id,$link);
	echo $min_ord_ref_id."<br>";
	$data_sym="$";
	$File = "session_track.php";
	$fh = fopen($File, 'w') or die("can't open file");
	$stringData = "<?php ".$data_sym."status=\"".$min_ord_ref_id."\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh); 
	$date_time=date('Y-m-d h:i:sa'); 
	
	$sizesMasterQuery="select id,upper(size_name) as size_name from $brandix_bts.tbl_orders_size_ref order by size_name";
	//echo $sizesMasterQuery;exit;
	$result=mysqli_query($link, $sizesMasterQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($result))
	{
		while($s=mysqli_fetch_array($result))
		{
			if($s['size_name']=='S')
			{
				$s_id=$s['id'];
			}
			if($s['size_name']=='M')
			{
				$m_id=$s['id'];
			}
			if($s['size_name']=='L')
			{
				$l_id=$s['id'];
			}
			if($s['size_name']=='XS')
			{
				$xs_id=$s['id'];
			}
			if($s['size_name']=='XL')
			{
				$xl_id=$s['id'];
			}if($s['size_name']=='XXL')
			{
				$xxl_id=$s['id'];
			}
			if($s['size_name']=='XXXL')
			{
				$xxxl_id=$s['id'];
			}
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
	}
	else
	{
		echo "<script>swal('Sorry No sizes found in masters','Please add sizes first','warning');</script>";;
	}
	
	
	$query11="select * from $brandix_bts.view_extra_cut where order_del_no=".$schedule."";
	//echo $style_id."---".$schedule."---".$schedule_id."<br>";
	$layPlanResult=mysqli_query($link, $query11) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

	
	//check whether normal mini order generated or not
	$bundles=echo_title("$brandix_bts.tbl_miniorder_data","count(*)","mini_ordeR_ref",$min_ord_ref_id,$link);
	
	//echo $min_ord_ref_id."---".$bundles."<br>";exit();
	if($bundles > 0 && $min_ord_ref_id>0)
	{
		
		$sql12="select max(bundle_number)+1 as bundle from $brandix_bts.tbl_miniorder_data";
		$result12=mysqli_query($link, $sql12) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row12=mysqli_fetch_array($result12))
		{
			$bundle_number=$row12['bundle'];
		}
		echo "<table class='table table-bordered'>";
		echo "<tr><th>Mini Order</th><th>Cut Number</th><th>Color</th><th>Size</th><th>Bundle Number</th><th>Bundle Quantity</th><th>Docket Number</th></tr>";
	
		while($l=mysqli_fetch_array($layPlanResult))
		{
			$lastMini_order=echo_title("brandix_bts.tbl_miniorder_data","max(mini_order_num)+1","mini_order_ref",$min_ord_ref_id,$link);
			$doc_num=$l['doc_no'];
			$cut_num=$l['acutno'];
			//$tid=$l['tid'];
			$cut_status=$l['act_cut_status'];
			$planned_module=$l['plan_module'];
			if($planned_module==NULL)
			{
				$planned_module=0;
			}
			$col_code=$l['color_code'];
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
			$style_code=$l['style_id'];
			
			$insertLayPlanQuery="INSERT ignore INTO $brandix_bts.tbl_cut_master(doc_num,ref_order_num,cut_num,cut_status,planned_module,issued_time,planned_plies,actual_plies,plan_date,style_id,product_schedule,cat_ref,cuttable_ref,mk_ref,col_code) VALUES 
			('$doc_num',$order_id,$cut_num,'$cut_status','$planned_module','$issued_time',$planned_plies,$actual_plies,'$plan_date',$style_id,'$product_schedule',$cat_ref,$cuttable_ref,$mk_ref,$col_code)";
			//echo $insertLayPlanQuery."</br>";
			$result2=mysqli_query($link, $insertLayPlanQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$layplan_id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
			//echo $layplan_id;
			if($layplan_id>0)
			{
				//Insert data into layplan reference table (tbl_cut_size_master)
				if($l['p_xs']>0)
				{
					$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$xs_id.",".$l['p_xs'].")";
					$result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					//echo $insertLayplanItemsQuery."</br>";
				}
				if($l['p_s']>0)
				{
					$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s_id.",".$l['p_s'].")";
					$result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					
				}
				// previously at the time of syncing for medium size will update the ratio large
				if($l['p_m']>0)
				{
					$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$m_id.",".$l['p_m'].")";
					$result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					
				}
				if($l['p_l']>0)
				{
					$insertLayplanItemsQuery="INSERT INTO tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$l_id.",".$l['p_l'].")";
					$result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					
				}
				if($l['p_xl']>0)
				{
					$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$xl_id.",".$l['p_xl'].")";
					$result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					
				}
				if($l['p_xxl']>0)
				{
					$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$xxl_id.",".$l['p_xxl'].")";
					$result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					
				}
				if($l['p_xxxl']>0)
				{
					$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$xxxl_id.",".$l['p_xxxl'].")";
					$result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					
				}
				if($l['p_s01']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s01_id.",".$l['p_s01'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s02']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s02_id.",".$l['p_s02'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s03']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s03_id.",".$l['p_s03'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s04']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s04_id.",".$l['p_s04'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s05']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s05_id.",".$l['p_s05'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s06']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s06_id.",".$l['p_s06'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s07']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s07_id.",".$l['p_s07'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s08']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s08_id.",".$l['p_s08'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s09']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s09_id.",".$l['p_s09'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s10']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s10_id.",".$l['p_s10'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s11']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s11_id.",".$l['p_s11'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s12']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s12_id.",".$l['p_s12'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s13']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s13_id.",".$l['p_s13'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s14']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s14_id.",".$l['p_s14'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s15']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s15_id.",".$l['p_s15'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s16']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s16_id.",".$l['p_s16'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s17']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s17_id.",".$l['p_s17'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s18']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s18_id.",".$l['p_s18'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s19']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s19_id.",".$l['p_s19'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s20']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s20_id.",".$l['p_s20'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s21']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s21_id.",".$l['p_s21'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s22']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s22_id.",".$l['p_s22'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s23']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s23_id.",".$l['p_s23'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s24']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s24_id.",".$l['p_s24'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s25']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s25_id.",".$l['p_s25'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s26']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s26_id.",".$l['p_s26'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s27']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s27_id.",".$l['p_s27'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s28']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s28_id.",".$l['p_s28'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s29']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s29_id.",".$l['p_s29'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s30']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s30_id.",".$l['p_s30'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s31']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s31_id.",".$l['p_s31'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s32']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s32_id.",".$l['p_s32'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s33']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s33_id.",".$l['p_s33'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s34']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s34_id.",".$l['p_s34'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s35']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s35_id.",".$l['p_s35'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s36']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s36_id.",".$l['p_s36'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s37']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s37_id.",".$l['p_s37'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s38']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s38_id.",".$l['p_s38'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s39']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s39_id.",".$l['p_s39'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s40']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s40_id.",".$l['p_s40'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s41']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s41_id.",".$l['p_s41'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s42']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s42_id.",".$l['p_s42'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s43']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s43_id.",".$l['p_s43'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s44']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s44_id.",".$l['p_s44'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s45']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s45_id.",".$l['p_s45'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s46']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s46_id.",".$l['p_s46'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s47']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s47_id.",".$l['p_s47'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s48']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s48_id.",".$l['p_s48'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s49']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s49_id.",".$l['p_s49'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
				if($l['p_s50']>0)
					{
					 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s50_id.",".$l['p_s50'].")";
					 $result3=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }

				
				$layplan_Query1="SELECT cut_sizes.ref_size_name AS size_id,cut_master.cut_num,cut_sizes.id,`cut_master`.`planned_plies`,
				cut_sizes.quantity,cut_master.planned_plies*cut_sizes.quantity AS total_cut_quantity,cut_master.doc_num AS docket_number
				FROM $brandix_bts.tbl_cut_master AS cut_master LEFT JOIN tbl_cut_size_master cut_sizes ON cut_master.id=cut_sizes.parent_id
				WHERE cut_master.id='".$layplan_id."'";
				$result5=mysqli_query($link, $layplan_Query1) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($result5)>0)
				{
					while($l=mysqli_fetch_array($result5))
					{
						$size=$l['size_id'];
						$bundle_quantity=$l['planned_plies'];
						$bundles_count=$l['quantity'];
						for($i=0;$i<$bundles_count;$i++)
						{
							echo "<tr><td>".$lastMini_order."</td><td>".$l['cut_num']."</td><td>".$color_code."</td><td>".$size."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$l['docket_number']."</td></tr>";
							$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".date("Y-m-d h:i:s")."' ,'".$min_ord_ref_id."','".$lastMini_order."','".$cut_num."','".$color_code."','".$size."','".$bundle_number."','".$bundle_quantity."','".$l['docket_number']."','".$lastMini_order."')";
							$result6=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
							$bundle_number++;
						}
					}
					
				}
				//echo "<div class='alert alert-success' style='text-align:center; font-size: 20px;'>Bundles generated Successfully!!!!</div>";
				//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",400); function Redirect() {  location.href='../operations/additional-cut/'; }</script>";
			}
			else
			{
				echo "<div class='alert alert-danger' style='text-align:center; font-size: 20px;'>Already Bundles generated</div>";
				//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",400); function Redirect() {  location.href='../operations/additional-cut/'; }</script>";
			}
	
		}//sync completed in cut master and cut sizes masters
		
		echo "</table>";
		//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",400); function Redirect() {  location.href='../operations/additional-cut/'; }</script>";
	}
	else
	{
		echo "<div class='alert alert-danger' style='text-align:center; font-size: 20px;'>Normal Mini orders not yet generated.</div>";
				//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",400); function Redirect() {  location.href='../operations/additional-cut/'; }</script>";
	}
	//$mini_order_ref=$_GET['id'];
	$data_sym="$";
	$File = "session_track.php";
	$fh = fopen($File, 'w') or die("can't open file");
	$stringData = "<?php ".$data_sym."status=\"\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
	//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",180); function Redirect() {  location.href = \"additional_mini_create.php\"; }</script>";
}
else
{
	echo "<script>swal('Another User Generating Mini orders','Please try again','warning');</script>";
	$url=getFullURLLevel($_GET['r'],'additional_mini_create.php',0,'N');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",180); function Redirect() {  location.href = \"$url\"; }</script>";
}	
?>
</body>
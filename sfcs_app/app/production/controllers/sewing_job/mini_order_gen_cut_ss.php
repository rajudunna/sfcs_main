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
</style>

<body>
<div class="panel panel-primary">
<div class="panel-heading">Sewing Job Generation</div>
<div class="panel-body">
<!--<div id="page_heading"><span style="float"><h3>Sewing Job Generation</h3></span><span style="float: right"><b></b>&nbsp;</span></div>-->
<?php
set_time_limit(30000000);
// include("dbconf.php");
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
$mini_order_ref=$_GET["id"];
$packing_mode=$_GET["mode"];
	$style_ori=$_GET['style'];
	$schedule_ori=$_GET['schedule'];
$id_array=array();
if ($packing_mode=='4') {
  echo "<h2>Single Color & Multi Size (Non Ratio Pack) Carton Method</h2>";
}else {
  echo "<h2>Single Color & Single Size Carton Method</h2>";
}
// echo $packing_mode.'<br>';
$sql="select * from $brandix_bts.tbl_min_ord_ref where id=$mini_order_ref";
//echo $sql."<br>";
$result=mysqli_query($link, $sql) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($result))
{
	$carton_qty=$row['carton_quantity'];
	$schedule_id=$row['ref_crt_schedule'];
	$style_id=$row['ref_product_style'];
	$max_bundle_qnty=$row['max_bundle_qnty'];
	$mix_bund_per_size=$row['miximum_bundles_per_size'];
	$mini_order_qnty=$row['mini_order_qnty'];
	$carton_method=$row['carton_method'];
}

$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link);
$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
$carton_id = echo_title("$brandix_bts.tbl_carton_ref","id","ref_order_num",$schedule_id,$link);
$id=$carton_id;

$input_job_limit=$max_bundle_qnty;

$sql1="select id from $brandix_bts.tbl_miniorder_data where mini_order_ref=".$mini_order_ref." AND mini_order_num > 0";
$result1=mysqli_query($link, $sql1) or die("Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row1=mysqli_fetch_array($result1))
{
	$id_array[]=$row1["id"];
}

// $sql2="INSERT INTO $brandix_bts.tbl_miniorder_data (date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,bundle_status) SELECT date_time,mini_order_ref,mini_order_num,cut_num,color,size,MIN(bundle_number),SUM(quantity),docket_number,bundle_status FROM tbl_miniorder_data WHERE mini_order_ref=".$mini_order_ref." AND mini_order_num > 0 GROUP BY cut_num,size order by cut_num*1 asc,size*1 asc";
// //echo $schedule_id."-".$schedule."-".$sql2."<br>";
// mysqli_query($link, $sql2) or die("Error2".mysqli_error($GLOBALS["___mysqli_ston"]));

// $sql3="delete FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$mini_order_ref." AND id in (".implode(",",$id_array).")";
// mysqli_query($link, $sql3) or die("Error3".mysqli_error($GLOBALS["___mysqli_ston"]));

$input_job_no=0;

// echo "<div class=\"table-responsive\"><table class='table table-striped table-bordered'>";
$sql1="select cut_num from $brandix_bts.tbl_miniorder_data where mini_order_ref=".$mini_order_ref." AND mini_order_num > 0 group by cut_num order by cut_num*1 asc";
$result1=mysqli_query($link, $sql1) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// echo "<thead><tr><td>Cut Number</td><td>Size Code</td><td>Size</td><td>Input Job Limit</td><td>Total Quantity</td><td>Input Job Number</td></tr></thead>";
while($row1=mysqli_fetch_array($result1))
{
	$cut_num=$row1["cut_num"];
	$temp_qty=array();
	$quantity_cut_cum=0;
	//$input_job_no=$input_job_no+1;
	$sql="select cut_num,color,size,quantity,docket_number from $brandix_bts.tbl_miniorder_data where mini_order_ref=".$mini_order_ref." AND mini_order_num > 0 and cut_num=$cut_num order by cut_num*1 asc,quantity*1 desc,size*1 asc";
	$result=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($row=mysqli_fetch_array($result))
	{
		$quantity=$row["quantity"];
		$size_color_qty=$row["quantity"];
		$docket_number=$row["docket_number"];
		$color_code=$row["color"];

		$size_code_ref=echo_title("$brandix_bts.tbl_orders_size_ref","LOWER(size_name)","id",$row["size"],$link);
		$size_code=echo_title("$bai_pro3.bai_orders_db_confirm","LOWER(title_size_".$size_code_ref.")","order_del_no=\"".$schedule."\" and order_col_des",$color_code,$link);
		$destination=echo_title("$bai_pro3.bai_orders_db","UPPER(destination)","order_del_no=\"".$schedule."\" and order_col_des",$color_code,$link);

		if($row["quantity"] >= $input_job_limit)
		{
			//echo "1=".$row["quantity"]."<br>";
			do
			{
				$quantity=$quantity-$input_job_limit;
				$input_job_no=$input_job_no+1;
				// echo "<tr><td>".$row["cut_num"]."</td><td>".$size_code."</td><td>".$row["size"]."</td><td>".$input_job_limit."</td><td>".$quantity."</td><td>".$input_job_no."</td></tr>";
				$rand=$schedule.date("ymdH").$input_job_no;
				$sql1="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_code."\",\"".$input_job_limit."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$packing_mode."\",\"".$size_code_ref."\")";
				// echo $sql1."<br>";
				mysqli_query($link, $sql1) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));

			}while($quantity>=$input_job_limit);
			if($quantity > 0)
			{
				$temp_qty[]=$row["cut_num"]."$".$size_code."$".$row["size"]."$".$quantity."$".$quantity."$".$docket_number."$".$destination;
			}
		}
		else
		{
			//echo "2=".$row["quantity"]."<br>";
			$temp_qty[]=$row["cut_num"]."$".$size_code."$".$row["size"]."$".$quantity."$".$quantity."$".$docket_number."$".$destination;
		}
	}
	$input_job_no=$input_job_no+1;
	for($i=0;$i<sizeof($temp_qty);$i++)
	{
		$temp_qty_ref=$temp_qty[$i];
		//$input_job_no=$input_job_no+1;
		$temp_qty_ref_explode=explode("$",$temp_qty_ref);
		$quantity_cut_cum=$quantity_cut_cum+$temp_qty_ref_explode[3];
		//echo "2.1=".$i."=".$temp_qty_ref_explode[0]." / ".$temp_qty_ref_explode[3]." / ".$quantity_cut_cum."<br>";
		$quantity_cut_cum_per=round(($quantity_cut_cum-$input_job_limit)*100/$quantity_cut_cum,2);
		//echo "2.2=".$i."=".$temp_qty_ref_explode[0]." / ".$temp_qty_ref_explode[3]." / ".$quantity_cut_cum." / ".$quantity_cut_cum_per."<br>";
		// echo "2.3=".$i."=".$temp_qty_ref_explode[3]." / ".$quantity_cut_cum." / ".$input_job_limit."<br>";
		if($quantity_cut_cum>=$input_job_limit)
		{
			if($quantity_cut_cum_per > 15)
			{
				$input_job_no=$input_job_no+1;
				// echo "3.1=".$temp_qty_ref_explode[3]." / ".$quantity_cut_cum." / ".$input_job_limit." / ".$input_job_no."<br>";
				$quantity_cut_cum=$quantity_cut_cum-$temp_qty_ref_explode[3];
				// echo "3.2=".$temp_qty_ref_explode[3]." / ".$quantity_cut_cum." / ".$input_job_limit." / ".$input_job_no."<br>";
			}
		}
		else
		{
			$input_job_no=$input_job_no;
		}
		// echo "2.4=".$i."=".$temp_qty_ref_explode[3]." / ".$quantity_cut_cum." / ".$input_job_limit."<br>";
		// echo "<tr><td>".$temp_qty_ref_explode[0]."</td><td>".$temp_qty_ref_explode[1]."</td><td>".$temp_qty_ref_explode[2]."</td><td>".$temp_qty_ref_explode[3]."</td><td>".$temp_qty_ref_explode[4]."</td><td>".$input_job_no." / ".$quantity_cut_cum." / Per=".$quantity_cut_cum_per." / ".$input_job_limit."</td></tr>";
		$rand=$schedule.date("ymdH").$input_job_no;
		$sql1="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$temp_qty_ref_explode[5]."\",\"".$temp_qty_ref_explode[1]."\",\"".$temp_qty_ref_explode[3]."\",\"".$input_job_no."\",\"".$rand."\",\"".$temp_qty_ref_explode[6]."\",\"".$packing_mode."\",\"".$size_code_ref."\")";
		// echo $sql1."<br>";
		mysqli_query($link, $sql1) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	}

	reset($temp_qty);
}

$i1=0;
$sql1="select distinct input_job_no as input_job_no FROM $bai_pro3.pac_stat_log_input_job WHERE doc_no IN (SELECT doc_no FROM $bai_pro3.plandoc_stat_log WHERE order_tid LIKE \"% ".$schedule."%\") order by input_job_no*1";
//echo $sql1."<br>";
$result1=mysqli_query($link, $sql1) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$btn_url = getFullURLLevel($_GET['r'],'sewing_job_create.php',0,'N');
while($row1=mysqli_fetch_array($result1))
{
	$i1=$i1+1;
	// echo $row1["input_job_no"]." = ".$i1."<br>";
	$sql2="update $bai_pro3.pac_stat_log_input_job set input_job_no=".$i1.",input_job_no_random=CONCAT(input_job_no_random,".$i1.") where input_job_no=".$row1["input_job_no"]." and doc_no in (SELECT doc_no FROM $bai_pro3.plandoc_stat_log WHERE order_tid LIKE \"% ".$schedule."%\")";
	//echo $sql2."<br>";
	mysqli_query($link, $sql2) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}
	// header("Location:http://bebnet:8080/projects/beta/production_planning/input_job_mix_ch.php");
// echo("<script>location.href = 'input_job_mix_ch.php?schedule=$schedule&style=$style';</script>");
// echo "<br><br><div class='alert alert-success'>Data Saved Successfully</div>";
echo "<script>sweetAlert('Data Saved Successfully','','success')</script>";
// echo '<a href='.$btn_url.' class="btn disable-btn btn-primary">Click Here to Back</a>';
echo "<script>
			setTimeout(redirect(),5000);
			function redirect(){
		        location.href = '".$btn_url."&style=$style_ori&schedule=$schedule_ori';
			}</script>";
// echo "</table></div>";
?>
</div></div>
</body>

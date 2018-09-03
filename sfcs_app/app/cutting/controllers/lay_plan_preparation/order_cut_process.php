<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>

<?php
// var_dump($_POST);
if(isset($_POST['tran_order_tid']))
{
$in_s01=$_POST['in_s01'];
$in_s02=$_POST['in_s02'];
$in_s03=$_POST['in_s03'];
$in_s04=$_POST['in_s04'];
$in_s05=$_POST['in_s05'];
$in_s06=$_POST['in_s06'];
$in_s07=$_POST['in_s07'];
$in_s08=$_POST['in_s08'];
$in_s09=$_POST['in_s09'];
$in_s10=$_POST['in_s10'];
$in_s11=$_POST['in_s11'];
$in_s12=$_POST['in_s12'];
$in_s13=$_POST['in_s13'];
$in_s14=$_POST['in_s14'];
$in_s15=$_POST['in_s15'];
$in_s16=$_POST['in_s16'];
$in_s17=$_POST['in_s17'];
$in_s18=$_POST['in_s18'];
$in_s19=$_POST['in_s19'];
$in_s20=$_POST['in_s20'];
$in_s21=$_POST['in_s21'];
$in_s22=$_POST['in_s22'];
$in_s23=$_POST['in_s23'];
$in_s24=$_POST['in_s24'];
$in_s25=$_POST['in_s25'];
$in_s26=$_POST['in_s26'];
$in_s27=$_POST['in_s27'];
$in_s28=$_POST['in_s28'];
$in_s29=$_POST['in_s29'];
$in_s30=$_POST['in_s30'];
$in_s31=$_POST['in_s31'];
$in_s32=$_POST['in_s32'];
$in_s33=$_POST['in_s33'];
$in_s34=$_POST['in_s34'];
$in_s35=$_POST['in_s35'];
$in_s36=$_POST['in_s36'];
$in_s37=$_POST['in_s37'];
$in_s38=$_POST['in_s38'];
$in_s39=$_POST['in_s39'];
$in_s40=$_POST['in_s40'];
$in_s41=$_POST['in_s41'];
$in_s42=$_POST['in_s42'];
$in_s43=$_POST['in_s43'];
$in_s44=$_POST['in_s44'];
$in_s45=$_POST['in_s45'];
$in_s46=$_POST['in_s46'];
$in_s47=$_POST['in_s47'];
$in_s48=$_POST['in_s48'];
$in_s49=$_POST['in_s49'];
$in_s50=$_POST['in_s50'];


	$tran_order_tid=$_POST['tran_order_tid'];
	$check_id=$_POST['check_id'];
	//$remarks=$_POST['remarks'];
	$remarks="NIL";
	$cuttable_percent=$_POST['cuttable_percent'];
	$cuttable_wastage=$_POST['cuttable_wastage']/100;
	//echo $cuttable_wastage;exit;


	$sql="insert ignore into $bai_pro3.cuttable_stat_log (order_tid, date,cuttable_s_s01, cuttable_s_s02, cuttable_s_s03, cuttable_s_s04, cuttable_s_s05, cuttable_s_s06, cuttable_s_s07, cuttable_s_s08, cuttable_s_s09, cuttable_s_s10, cuttable_s_s11, cuttable_s_s12, cuttable_s_s13, cuttable_s_s14, cuttable_s_s15, cuttable_s_s16, cuttable_s_s17, cuttable_s_s18, cuttable_s_s19, cuttable_s_s20, cuttable_s_s21, cuttable_s_s22, cuttable_s_s23, cuttable_s_s24, cuttable_s_s25, cuttable_s_s26, cuttable_s_s27, cuttable_s_s28, cuttable_s_s29, cuttable_s_s30, cuttable_s_s31, cuttable_s_s32, cuttable_s_s33, cuttable_s_s34, cuttable_s_s35, cuttable_s_s36, cuttable_s_s37, cuttable_s_s38, cuttable_s_s39, cuttable_s_s40, cuttable_s_s41, cuttable_s_s42, cuttable_s_s43, cuttable_s_s44, cuttable_s_s45, cuttable_s_s46, cuttable_s_s47, cuttable_s_s48, cuttable_s_s49, cuttable_s_s50, remarks, cat_id, cuttable_percent,cuttable_wastage ) values(\"$tran_order_tid\", '".date("Y-m-d")."','$in_s01' ,'$in_s02' ,'$in_s03' ,'$in_s04' ,'$in_s05' ,'$in_s06' ,'$in_s07' ,'$in_s08' ,'$in_s09' ,'$in_s10' ,'$in_s11' ,'$in_s12' ,'$in_s13' ,'$in_s14' ,'$in_s15' ,'$in_s16' ,'$in_s17' ,'$in_s18' ,'$in_s19' ,'$in_s20' ,'$in_s21' ,'$in_s22' ,'$in_s23' ,'$in_s24' ,'$in_s25' ,'$in_s26' ,'$in_s27' ,'$in_s28' ,'$in_s29' ,'$in_s30' ,'$in_s31' ,'$in_s32' ,'$in_s33' ,'$in_s34' ,'$in_s35' ,'$in_s36' ,'$in_s37' ,'$in_s38' ,'$in_s39' ,'$in_s40' ,'$in_s41' ,'$in_s42' ,'$in_s43' ,'$in_s44' ,'$in_s45' ,'$in_s46' ,'$in_s47' ,'$in_s48' ,'$in_s49' ,'$in_s50' ,\"$remarks\", '$check_id', '$cuttable_percent' ,'$cuttable_wastage')";
	// echo $sql."<br>";
	// die();
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	
		
	//$location="Location: report.php?tran_order_tid=$o_id";
		
	//header( $location );

		
	$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\"";
	//echo $sql;
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
	$color=$sql_row['order_col_des'];
	$style=$sql_row['order_style_no'];
	$schedule=$sql_row['order_del_no'];

}
// echo getFullURLLevel($_GET['r'], "main_interface.php", "1", "N");
	echo "<script type=\"text/javascript\">
			sweetAlert('Success','Cuttable Quantities Updated Successfully...','success');
			setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=".$color."&style=".$style."&schedule=".$schedule."\"; }
		</script>";
	
}


?>

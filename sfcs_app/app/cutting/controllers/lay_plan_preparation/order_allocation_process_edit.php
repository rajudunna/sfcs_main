<?php include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>

<?php

if(isset($_POST['Update']))
{

	$ratio=$_POST['ratio'];
	$plies=$_POST['plies'];
	//$cutnos=$_POST['cutnos'];
	$cutnos=0;
	
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
	$cat_id=$_POST['cat_id'];
	$remarks=$_POST['remarks'];
	//$remarks="NIL";
	$pliespercut=$_POST['pliespercut'];
	$ref_id=$_POST['ref_id'];

	

$sql="update $bai_pro3.allocate_stat_log set plies=$plies, cut_count=$cutnos, pliespercut=$pliespercut, allocate_s01='$in_s01',allocate_s02='$in_s02',allocate_s03='$in_s03',allocate_s04='$in_s04',allocate_s05='$in_s05',allocate_s06='$in_s06',allocate_s07='$in_s07',allocate_s08='$in_s08',allocate_s09='$in_s09',allocate_s10='$in_s10',allocate_s11='$in_s11',allocate_s12='$in_s12',allocate_s13='$in_s13',allocate_s14='$in_s14',allocate_s15='$in_s15',allocate_s16='$in_s16',allocate_s17='$in_s17',allocate_s18='$in_s18',allocate_s19='$in_s19',allocate_s20='$in_s20',allocate_s21='$in_s21',allocate_s22='$in_s22',allocate_s23='$in_s23',allocate_s24='$in_s24',allocate_s25='$in_s25',allocate_s26='$in_s26',allocate_s27='$in_s27',allocate_s28='$in_s28',allocate_s29='$in_s29',allocate_s30='$in_s30',allocate_s31='$in_s31',allocate_s32='$in_s32',allocate_s33='$in_s33',allocate_s34='$in_s34',allocate_s35='$in_s35',allocate_s36='$in_s36',allocate_s37='$in_s37',allocate_s38='$in_s38',allocate_s39='$in_s39',allocate_s40='$in_s40',allocate_s41='$in_s41',allocate_s42='$in_s42',allocate_s43='$in_s43',allocate_s44='$in_s44',allocate_s45='$in_s45',allocate_s46='$in_s46',allocate_s47='$in_s47',allocate_s48='$in_s48',allocate_s49='$in_s49',allocate_s50='$in_s50', remarks=\"$remarks\" where tid=$ref_id";

mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 

		$sql="update $bai_pro3.allocate_stat_log set mk_status=1 where tid=$ref_id";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	
$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
	$color=$sql_row['order_col_des'];
	$style=$sql_row['order_style_no'];
	$schedule=$sql_row['order_del_no'];
	

}
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  
		sweetAlert('Successfully Updated','','success');	
		location.href = \"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=$color&style=$style&schedule=$schedule\"; }</script>";
}


?>
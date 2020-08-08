<style>
	#loading-image
	{
		position:fixed;
		top:0px;
		right:0px;
		width:100%;
		height:100%;
		background-color:#666;
		/* background-image:url('ajax-loader.gif'); */
		background-repeat:no-repeat;
		background-position:center;
		z-index:10000000;
		opacity: 0.4;
		filter: alpha(opacity=40); /* For IE8 and earlier */
	}
</style>

<div class="ajax-loader" id="loading-image">
    <center><img src='<?= getFullURLLevel($_GET['r'],'common/images/ajax-loader.gif',2,'R'); ?>' class="img-responsive" style="padding-top: 250px"/></center>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/php/functions.php',4,'R'));?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/mo_filling.php',4,'R'));?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',4,'R'));?>
<?php
$tran_order_tid=order_tid_decode($_GET['tran_order_tid']);
$mk_ref=$_GET['mkref'];
$allocate_ref=$_GET['allocate_ref'];
$cat_ref2=$_GET['cat_ref'];
$color=color_decode($_GET['color']);
$schedule=$_GET['schedule'];

$sql4="select * from $bai_pro3.plandoc_stat_log where order_tid='$tran_order_tid' and cat_ref='$cat_ref2' and allocate_ref='$allocate_ref'";
$sql_result1=mysqli_query($link, $sql4) or exit($sql."Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result1_res=mysqli_num_rows($sql_result1);

$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
	$style=$sql_row['order_style_no'];
}

$sql12="SELECT id FROM bai_pro3.`maker_details` where parent_id=".$allocate_ref." order by id limit 1";
$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result12)>0){
	while($sql_row12=mysqli_fetch_array($sql_result12))
	{
		$mk_id=$sql_row12['id'];
	}
}else{
	$mk_id=0;
}

{
if($sql_result1_res==0){

function get_val($table_name,$field,$compare,$key,$link)
{
    $sql="select $field as result from $table_name where $compare='$key'";
    $sql_result=mysqli_query($link, $sql) or exit($sql."Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row=mysqli_fetch_array($sql_result))
    {
        return $sql_row['result'];
    }
    ((mysqli_free_result($sql_result) || (is_object($sql_result) && (get_class($sql_result) == "mysqli_result"))) ? true : false);
}
?>

<script type="text/javascript">
function popitup(url) {
    newwindow=window.open(url,'name','scrollbars=1,menubar=1,resizable=1,location=0,toolbar=0');
    if (window.focus) {newwindow.focus()}
    return false;
}
</script>

<h3><font face="verdana" color="green">Please wait <br> Docket is Generating...</font></h3>
<?php

$tran_order_tid=order_tid_decode($_GET['tran_order_tid']);
$mk_ref=$_GET['mkref'];
$allocate_ref=$_GET['allocate_ref'];
$cat_ref2=$_GET['cat_ref'];
$date=date("Y-m-d", mktime(0,0,0,date("m") ,date("d"),date("Y")));

$sql="select * from $bai_pro3.allocate_stat_log where order_tid=\"$tran_order_tid\" and tid=$allocate_ref and mk_status!=9";
//echo $sql."<br>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

while($sql_row=mysqli_fetch_array($sql_result))
{

	$s01 = $sql_row['allocate_s01'];
	$s02 = $sql_row['allocate_s02'];
	$s03 = $sql_row['allocate_s03'];
	$s04 = $sql_row['allocate_s04'];
	$s05 = $sql_row['allocate_s05'];
	$s06 = $sql_row['allocate_s06'];
	$s07 = $sql_row['allocate_s07'];
	$s08 = $sql_row['allocate_s08'];
	$s09 = $sql_row['allocate_s09'];
	$s10 = $sql_row['allocate_s10'];
	$s11 = $sql_row['allocate_s11'];
	$s12 = $sql_row['allocate_s12'];
	$s13 = $sql_row['allocate_s13'];
	$s14 = $sql_row['allocate_s14'];
	$s15 = $sql_row['allocate_s15'];
	$s16 = $sql_row['allocate_s16'];
	$s17 = $sql_row['allocate_s17'];
	$s18 = $sql_row['allocate_s18'];
	$s19 = $sql_row['allocate_s19'];
	$s20 = $sql_row['allocate_s20'];
	$s21 = $sql_row['allocate_s21'];
	$s22 = $sql_row['allocate_s22'];
	$s23 = $sql_row['allocate_s23'];
	$s24 = $sql_row['allocate_s24'];
	$s25 = $sql_row['allocate_s25'];
	$s26 = $sql_row['allocate_s26'];
	$s27 = $sql_row['allocate_s27'];
	$s28 = $sql_row['allocate_s28'];
	$s29 = $sql_row['allocate_s29'];
	$s30 = $sql_row['allocate_s30'];
	$s31 = $sql_row['allocate_s31'];
	$s32 = $sql_row['allocate_s32'];
	$s33 = $sql_row['allocate_s33'];
	$s34 = $sql_row['allocate_s34'];
	$s35 = $sql_row['allocate_s35'];
	$s36 = $sql_row['allocate_s36'];
	$s37 = $sql_row['allocate_s37'];
	$s38 = $sql_row['allocate_s38'];
	$s39 = $sql_row['allocate_s39'];
	$s40 = $sql_row['allocate_s40'];
	$s41 = $sql_row['allocate_s41'];
	$s42 = $sql_row['allocate_s42'];
	$s43 = $sql_row['allocate_s43'];
	$s44 = $sql_row['allocate_s44'];
	$s45 = $sql_row['allocate_s45'];
	$s46 = $sql_row['allocate_s46'];
	$s47 = $sql_row['allocate_s47'];
	$s48 = $sql_row['allocate_s48'];
	$s49 = $sql_row['allocate_s49'];
	$s50 = $sql_row['allocate_s50'];

	$plies=$sql_row['plies'];
	$pliespercut=$sql_row['pliespercut'];
	$ratio=$sql_row['ratio'];
	$remarks=$sql_row['remarks'];

	$cat_ref=$sql_row['cat_ref'];
	$cuttable_ref=$sql_row['cuttable_ref'];

	$count=0;

	$sql2="select count(pcutdocid) as \"count\" from $bai_pro3.plandoc_stat_log where order_tid=\"$tran_order_tid\" and cat_ref=$cat_ref";
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$count=$sql_row2['count'];
	}

	if($count==NULL)
	{
		$count=0;
	}

	$temp=$plies;
	//BLocking for the clubbing dockets
	$oj_query = "SELECT order_joins FROM bai_pro3.bai_orders_db WHERE order_tid = '$tran_order_tid'";
	$oj_result = mysqli_query($link,$oj_query);
	while($row=mysqli_fetch_array($oj_result)){
		$oj = $row['order_joins'];
	}

	if($oj == 1)
		$call_flag = 0;
	else
		$call_flag = 1;
	do
	{
		if($temp>=$pliespercut)
		{
			$pliescut=$pliespercut;
		}
		else
		{
			$pliescut=$temp;
		}	
		
		$count=$count+1;
		$pcutdocid=$tran_order_tid."/".$allocate_ref."/".$count;

		$sql2="insert into $bai_pro3.plandoc_stat_log(pcutdocid, date, cat_ref, cuttable_ref, allocate_ref, mk_ref, order_tid, pcutno, ratio, p_s01, p_s02, p_s03, p_s04, p_s05, p_s06, p_s07, p_s08, p_s09, p_s10, p_s11, p_s12, p_s13, p_s14, p_s15, p_s16, p_s17, p_s18, p_s19, p_s20, p_s21, p_s22, p_s23, p_s24, p_s25, p_s26, p_s27, p_s28, p_s29, p_s30, p_s31, p_s32, p_s33, p_s34, p_s35, p_s36, p_s37, p_s38, p_s39, p_s40, p_s41, p_s42, p_s43, p_s44, p_s45, p_s46, p_s47, p_s48, p_s49, p_s50, p_plies, acutno, a_s01, a_s02, a_s03, a_s04, a_s05, a_s06, a_s07, a_s08, a_s09, a_s10, a_s11, a_s12, a_s13, a_s14, a_s15, a_s16, a_s17, a_s18, a_s19, a_s20, a_s21, a_s22, a_s23, a_s24, a_s25, a_s26, a_s27, a_s28, a_s29, a_s30, a_s31, a_s32, a_s33, a_s34, a_s35, a_s36, a_s37, a_s38, a_s39, a_s40, a_s41, a_s42, a_s43, a_s44, a_s45, a_s46, a_s47, a_s48, a_s49, a_s50,  a_plies, remarks, mk_ref_id) values (\"$pcutdocid\", \"$date\", $cat_ref, $cuttable_ref, $allocate_ref, $mk_ref, \"$tran_order_tid\", $count, $ratio, $s01, $s02, $s03, $s04, $s05, $s06, $s07, $s08, $s09, $s10, $s11, $s12, $s13, $s14, $s15, $s16, $s17, $s18, $s19, $s20, $s21, $s22, $s23, $s24, $s25, $s26, $s27, $s28, $s29, $s30, $s31, $s32, $s33, $s34, $s35, $s36, $s37, $s38, $s39, $s40, $s41, $s42, $s43, $s44, $s45, $s46, $s47, $s48, $s49, $s50, $pliescut, $count, $s01, $s02, $s03, $s04, $s05, $s06, $s07, $s08, $s09, $s10, $s11, $s12, $s13, $s14, $s15, $s16, $s17, $s18, $s19, $s20, $s21, $s22, $s23, $s24, $s25, $s26, $s27, $s28, $s29, $s30, $s31, $s32, $s33, $s34, $s35, $s36, $s37, $s38, $s39, $s40, $s41, $s42, $s43, $s44, $s45, $s46, $s47, $s48, $s49, $s50, $pliescut, \"$remarks\", $mk_id)";

		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$temp=$temp-$pliespercut;

		$docket_no = mysqli_insert_id($link);
		$cat_query = "SELECT category from $bai_pro3.cat_stat_log where tid='$cat_ref' and category in ($in_categories)";
		$cat_result = mysqli_query($link,$cat_query);
		if(mysqli_num_rows($cat_result) > 0){
			if($docket_no > 0 && $call_flag > 0){
				$insert_bundle_creation_data = doc_size_wise_bundle_insertion($docket_no);
				if($insert_bundle_creation_data){
				}
				$docket_no = '';
			}
		}
	}while($temp>0);

}

//// For back Redirection
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

$sql="select order_del_no from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

if($sql_num_check==0)
{
    $sql="insert into $bai_pro3.bai_orders_db_confirm select * from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\"";
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
 }

$order_joins_check="SELECT order_joins FROM $bai_pro3.`bai_orders_db_confirm` WHERE order_tid='".$tran_order_tid."'";
$order_joins_result=mysqli_query($link, $order_joins_check) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($order_joins_result))
{
    $order_joins=$sql_row['order_joins'];
}
//Encoding order_tid
$main_tran_order_tid=order_tid_encode($tran_order_tid);
//Encoding color
$main_color = color_encode($color);
$main_style = style_encode($style);

if ($order_joins>'0' or $order_joins>0) {
 echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
        function Redirect() {
            sweetAlert('Successfully Generated','','success');
            location.href = \"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=$main_color&style=$main_style&schedule=$schedule\";
            }
        </script>";
  
} else {
    echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
            function Redirect() {
                location.href = \"".getFullURLLevel($_GET['r'], 'orders_sync.php',0,'N')."&order_tid=$main_tran_order_tid&color=$main_color&style=$main_style&schedule=$schedule\";
                }
            </script>";
 }

}
else{
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
	//Encoding order_tid
	$main_tran_order_tid=order_tid_encode($tran_order_tid);
	//Encoding color
	$main_color = color_encode($color);
	$main_style = style_encode($style);
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
		function Redirect() {
			sweetAlert('Dockets Already Generated','','warning');
			location.href = \"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=$main_color&style=$main_style&schedule=$schedule\";
			}
		</script>";

}
}

((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res);
?>
</div>
</div>



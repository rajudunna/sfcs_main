<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
<?php
$cat_id = $_GET['cat_id'];
$check_id=$_GET['check_id'];
$tran_order_tid=$_GET['tran_order_tid'];

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

$sql = "select * from $bai_pro3.`allocate_stat_log` where cat_ref=".$cat_id;
// echo $sql.'<br/>';
$sql_result = mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result)>0)
{
    while($sql_row=mysqli_fetch_array($sql_result)) 
    {
        $order_tid = $sql_row['order_tid'];
        $ratio=$sql_row['ratio'];
        $cutnos=$sql_row['cut_count'];
        $in_s01=$sql_row['allocate_s01'];
        $in_s02=$sql_row['allocate_s02'];
        $in_s03=$sql_row['allocate_s03'];
        $in_s04=$sql_row['allocate_s04'];
        $in_s05=$sql_row['allocate_s05'];
        $in_s06=$sql_row['allocate_s06'];
        $in_s07=$sql_row['allocate_s07'];
        $in_s08=$sql_row['allocate_s08'];
        $in_s09=$sql_row['allocate_s09'];
        $in_s10=$sql_row['allocate_s10'];
        $in_s11=$sql_row['allocate_s11'];
        $in_s12=$sql_row['allocate_s12'];
        $in_s13=$sql_row['allocate_s13'];
        $in_s14=$sql_row['allocate_s14'];
        $in_s15=$sql_row['allocate_s15'];
        $in_s16=$sql_row['allocate_s16'];
        $in_s17=$sql_row['allocate_s17'];
        $in_s18=$sql_row['allocate_s18'];
        $in_s19=$sql_row['allocate_s19'];
        $in_s20=$sql_row['allocate_s20'];
        $in_s21=$sql_row['allocate_s21'];
        $in_s22=$sql_row['allocate_s22'];
        $in_s23=$sql_row['allocate_s23'];
        $in_s24=$sql_row['allocate_s24'];
        $in_s25=$sql_row['allocate_s25'];
        $in_s26=$sql_row['allocate_s26'];
        $in_s27=$sql_row['allocate_s27'];
        $in_s28=$sql_row['allocate_s28'];
        $in_s29=$sql_row['allocate_s29'];
        $in_s30=$sql_row['allocate_s30'];
        $in_s31=$sql_row['allocate_s31'];
        $in_s32=$sql_row['allocate_s32'];
        $in_s33=$sql_row['allocate_s33'];
        $in_s34=$sql_row['allocate_s34'];
        $in_s35=$sql_row['allocate_s35'];
        $in_s36=$sql_row['allocate_s36'];
        $in_s37=$sql_row['allocate_s37'];
        $in_s38=$sql_row['allocate_s38'];
        $in_s39=$sql_row['allocate_s39'];
        $in_s40=$sql_row['allocate_s40'];
        $in_s41=$sql_row['allocate_s41'];
        $in_s42=$sql_row['allocate_s42'];
        $in_s43=$sql_row['allocate_s43'];
        $in_s44=$sql_row['allocate_s44'];
        $in_s45=$sql_row['allocate_s45'];
        $in_s46=$sql_row['allocate_s46'];
        $in_s47=$sql_row['allocate_s47'];
        $in_s48=$sql_row['allocate_s48'];
        $in_s49=$sql_row['allocate_s49'];
        $in_s50=$sql_row['allocate_s50'];
        $plies=$sql_row['plies'];
        $remarks=$sql_row['remarks'];
        $pliespercut=$sql_row['pliespercut'];
        $ii=0;
        $sql1 = "select * from $bai_pro3.cat_stat_log where order_tid in (select order_tid from $bai_pro3.`allocate_stat_log` where cat_ref=$cat_id)";
        // echo $sql1.'<br/>';
        $sql_result1 = mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        $cnt_num=mysqli_num_rows($sql_result1);
        // echo $cnt_num."<br>";
        $total_rows=$cnt_num-1;
        while($sql_row1=mysqli_fetch_array($sql_result1))
        {
            // echo $sql_row1['tid']."<br>";
            if($sql_row1['tid']!=$cat_id) 
            {
                $sql4 = "select * from $bai_pro3.`allocate_stat_log` where cat_ref=".$sql_row1['tid'];
                $sql_result4 = mysqli_query($link, $sql4) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                 $num_cnt=mysqli_num_rows($sql_result4);
                if($num_cnt == 0)
                {
                    $ii++;
                    $sql3 = "select tid as ct from $bai_pro3.cuttable_stat_log where cat_id=".$sql_row1['tid'];
                    // echo $sql3.'<br/>';
                    $sql_result3 = mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($sql_row3=mysqli_fetch_array($sql_result3)) {
                        $ct = $sql_row3['ct'];
                        $sql31="insert into $bai_pro3.allocate_stat_log (cat_ref, cuttable_ref, order_tid, ratio, cut_count, allocate_s01, allocate_s02, allocate_s03, allocate_s04, allocate_s05, allocate_s06, allocate_s07, allocate_s08, allocate_s09, allocate_s10, allocate_s11, allocate_s12, allocate_s13, allocate_s14, allocate_s15, allocate_s16, allocate_s17, allocate_s18, allocate_s19, allocate_s20, allocate_s21, allocate_s22, allocate_s23, allocate_s24, allocate_s25, allocate_s26, allocate_s27, allocate_s28, allocate_s29, allocate_s30, allocate_s31, allocate_s32, allocate_s33, allocate_s34, allocate_s35, allocate_s36, allocate_s37, allocate_s38, allocate_s39, allocate_s40, allocate_s41, allocate_s42, allocate_s43, allocate_s44, allocate_s45, allocate_s46, allocate_s47, allocate_s48, allocate_s49, allocate_s50, plies, remarks, pliespercut ) values (".$sql_row1['tid'].", ".$ct.", '$tran_order_tid', '$ratio', '$cutnos', '$in_s01' ,'$in_s02' ,'$in_s03' ,'$in_s04' ,'$in_s05' ,'$in_s06' ,'$in_s07' ,'$in_s08' ,'$in_s09' ,'$in_s10' ,'$in_s11' ,'$in_s12' ,'$in_s13' ,'$in_s14' ,'$in_s15' ,'$in_s16' ,'$in_s17' ,'$in_s18' ,'$in_s19' ,'$in_s20' ,'$in_s21' ,'$in_s22' ,'$in_s23' ,'$in_s24' ,'$in_s25' ,'$in_s26' ,'$in_s27' ,'$in_s28' ,'$in_s29' ,'$in_s30' ,'$in_s31' ,'$in_s32' ,'$in_s33' ,'$in_s34' ,'$in_s35' ,'$in_s36' ,'$in_s37' ,'$in_s38' ,'$in_s39' ,'$in_s40' ,'$in_s41' ,'$in_s42' ,'$in_s43' ,'$in_s44' ,'$in_s45' ,'$in_s46' ,'$in_s47' ,'$in_s48' ,'$in_s49' ,'$in_s50', '$plies', \"$remarks\", '$pliespercut')";
                        $sql_result32 = mysqli_query($link, $sql31) or exit("Error in inserting".mysqli_error($GLOBALS["___mysqli_ston"]));
                        // echo $sql31.'<br/>';
                    }
                    
                }
            }
        
        }
    }
}

if($ii >0){
    echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect(){
    			sweetAlert('Copied Successfully','','success');	 
   			 location.href = \"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=$color&style=$style&schedule=$schedule\"; }</script>";
}else{
    echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect(){
 				sweetAlert('Already Allocated ','','error');	 
                  location.href = \"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=$color&style=$style&schedule=$schedule\"; }</script>";
}
                  
?>
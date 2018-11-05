<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/php/functions.php',4,'R'));?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/mo_filling.php',4,'R'));?>
<?php
$tran_order_tid=$_GET['tran_order_tid'];
$mk_ref=$_GET['mkref'];
$allocate_ref=$_GET['allocate_ref'];
$cat_ref2=$_GET['cat_ref'];
$color=$_GET['color'];
$schedule=$_GET['schedule'];

$sql4="select * from $bai_pro3.plandoc_stat_log where order_tid='$tran_order_tid' and cat_ref='$cat_ref2' and allocate_ref='$allocate_ref' and mk_ref='$mk_ref'";
$sql_result1=mysqli_query($link, $sql4) or exit($sql."Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result1_res=mysqli_num_rows($sql_result1);

$sql5="select COUNT(*) FROM mo_details WHERE SCHEDULE='$schedule' AND color='$color'";
$sql_result5=mysqli_query($link, $sql5) or exit($sql."Sql Error-echo_2<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result5_res=mysqli_num_rows($sql_result5);

if($sql_result1_res==0 && $sql_result5_res>0){

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

$tran_order_tid=$_GET['tran_order_tid'];
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
    // New Change 2010-05-18 (on testing)

    //while($temp>=$pliespercut)
    while($temp>=$pliespercut)
    {
        $count=$count+1;
        $pcutdocid=$tran_order_tid."/".$allocate_ref."/".$count;

        $sql2="insert into $bai_pro3.plandoc_stat_log(pcutdocid, date, cat_ref, cuttable_ref, allocate_ref, mk_ref, order_tid, pcutno, ratio, p_s01, p_s02, p_s03, p_s04, p_s05, p_s06, p_s07, p_s08, p_s09, p_s10, p_s11, p_s12, p_s13, p_s14, p_s15, p_s16, p_s17, p_s18, p_s19, p_s20, p_s21, p_s22, p_s23, p_s24, p_s25, p_s26, p_s27, p_s28, p_s29, p_s30, p_s31, p_s32, p_s33, p_s34, p_s35, p_s36, p_s37, p_s38, p_s39, p_s40, p_s41, p_s42, p_s43, p_s44, p_s45, p_s46, p_s47, p_s48, p_s49, p_s50, p_plies, acutno, a_s01, a_s02, a_s03, a_s04, a_s05, a_s06, a_s07, a_s08, a_s09, a_s10, a_s11, a_s12, a_s13, a_s14, a_s15, a_s16, a_s17, a_s18, a_s19, a_s20, a_s21, a_s22, a_s23, a_s24, a_s25, a_s26, a_s27, a_s28, a_s29, a_s30, a_s31, a_s32, a_s33, a_s34, a_s35, a_s36, a_s37, a_s38, a_s39, a_s40, a_s41, a_s42, a_s43, a_s44, a_s45, a_s46, a_s47, a_s48, a_s49, a_s50, a_plies, remarks) values (\"$pcutdocid\", \"$date\", $cat_ref, $cuttable_ref, $allocate_ref, $mk_ref, \"$tran_order_tid\", $count, $ratio, $s01, $s02, $s03, $s04, $s05, $s06, $s07, $s08, $s09, $s10, $s11, $s12, $s13, $s14, $s15, $s16, $s17, $s18, $s19, $s20, $s21, $s22, $s23, $s24, $s25, $s26, $s27, $s28, $s29, $s30, $s31, $s32, $s33, $s34, $s35, $s36, $s37, $s38, $s39, $s40, $s41, $s42, $s43, $s44, $s45, $s46, $s47, $s48, $s49, $s50, $pliespercut, $count, $s01, $s02, $s03, $s04, $s05, $s06, $s07, $s08, $s09, $s10, $s11, $s12, $s13, $s14, $s15, $s16, $s17, $s18, $s19, $s20, $s21, $s22, $s23, $s24, $s25, $s26, $s27, $s28, $s29, $s30, $s31, $s32, $s33, $s34, $s35, $s36, $s37, $s38, $s39, $s40, $s41, $s42, $s43, $s44, $s45, $s46, $s47, $s48, $s49, $s50, $pliespercut, \"$remarks\" )";

        mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        //echo "</br>temp>=pliescut :".$sql2."</br>";
        $temp=$temp-$pliespercut;

        
        $docket_no = mysqli_insert_id($link);
        if($docket_no > 0){
            $insert_bundle_creation_data = doc_size_wise_bundle_insertion($docket_no);
            if($insert_bundle_creation_data){
                //Data inserted successfully
            }
            $docket_no = '';
        }

    
    }

    if($temp>0)
    {
        $count=$count+1;
        $pcutdocid=$tran_order_tid."/".$allocate_ref."/".$count;

        $sql2="insert into $bai_pro3.plandoc_stat_log(pcutdocid, date, cat_ref, cuttable_ref, allocate_ref, mk_ref, order_tid, pcutno, ratio, p_s01, p_s02, p_s03, p_s04, p_s05, p_s06, p_s07, p_s08, p_s09, p_s10, p_s11, p_s12, p_s13, p_s14, p_s15, p_s16, p_s17, p_s18, p_s19, p_s20, p_s21, p_s22, p_s23, p_s24, p_s25, p_s26, p_s27, p_s28, p_s29, p_s30, p_s31, p_s32, p_s33, p_s34, p_s35, p_s36, p_s37, p_s38, p_s39, p_s40, p_s41, p_s42, p_s43, p_s44, p_s45, p_s46, p_s47, p_s48, p_s49, p_s50, p_plies, a_s01, a_s02, a_s03, a_s04, a_s05, a_s06, a_s07, a_s08, a_s09, a_s10, a_s11, a_s12, a_s13, a_s14, a_s15, a_s16, a_s17, a_s18, a_s19, a_s20, a_s21, a_s22, a_s23, a_s24, a_s25, a_s26, a_s27, a_s28, a_s29, a_s30, a_s31, a_s32, a_s33, a_s34, a_s35, a_s36, a_s37, a_s38, a_s39, a_s40, a_s41, a_s42, a_s43, a_s44, a_s45, a_s46, a_s47, a_s48, a_s49, a_s50, a_plies, acutno, remarks) values (\"$pcutdocid\", \"$date\", $cat_ref, $cuttable_ref, $allocate_ref, $mk_ref, \"$tran_order_tid\", $count, $ratio, $s01, $s02, $s03, $s04, $s05, $s06, $s07, $s08, $s09, $s10, $s11, $s12, $s13, $s14, $s15, $s16, $s17, $s18, $s19, $s20, $s21, $s22, $s23, $s24, $s25, $s26, $s27, $s28, $s29, $s30, $s31, $s32, $s33, $s34, $s35, $s36, $s37, $s38, $s39, $s40, $s41, $s42, $s43, $s44, $s45, $s46, $s47, $s48, $s49, $s50, $temp, $s01, $s02, $s03, $s04, $s05, $s06, $s07, $s08, $s09, $s10, $s11, $s12, $s13, $s14, $s15, $s16, $s17, $s18, $s19, $s20, $s21, $s22, $s23, $s24, $s25, $s26, $s27, $s28, $s29, $s30, $s31, $s32, $s33, $s34, $s35, $s36, $s37, $s38, $s39, $s40, $s41, $s42, $s43, $s44, $s45, $s46, $s47, $s48, $s49, $s50, $temp, $count, \"$remarks\" ) ";
     //echo "</br>temp>0: ".$sql2."</br>";
        mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        // NEW 20100528
        $temp=0;

        //getting docket number
        $docket_no = mysqli_insert_id($link);
        if($docket_no > 0){
            $insert_bundle_creation_data = doc_size_wise_bundle_insertion($docket_no);
            if($insert_bundle_creation_data){
                //Data inserted successfully
            }
            $docket_no = '';
        }
    }

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
/////////////////////////////

//$sql="update allocate_stat_log set mk_status=9 where tid=$allocate_ref";
//mysql_query($sql,$link) or exit("Sql Error".mysql_error());


//Order details will transfer to confirmation table soon after the first docket generated. This is to facilitate required information to all teams.

$sql="select order_del_no from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

if($sql_num_check==0)
{
    $sql="insert ignore into $bai_pro3.bai_orders_db_confirm select * from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\"";
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    //$sql_num_confirm=mysql_num_rows($sql_result);
}

    //echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() { location.href = \"../main_interface.php?color=$color&style=$style&schedule=$schedule\"; }</script>";


$sql23="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$tran_order_tid\" and cat_ref=\"$cat_ref\" order by acutno";
$sql_result23=mysqli_query($link, $sql23) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row23=mysqli_fetch_array($sql_result23))
{
    $doc_no=$sql_row23['doc_no'];
    $cut_no=$sql_row23['acutno'];
}

// Mo club details
// Operation wise MO wise data details dumping
// $schedule_no=array();
// $color_no=array();

// $connect = odbc_connect($serverName, $uid, $pwd);
// $sch_check="J".$schedule;
// $check_club = get_val("bai_pro3.bai_orders_db_confirm","count(*)","order_joins",$sch_check,$link);
// if($check_club>0)
// {
//  $sql="select * from bai_orders_db_confirm where order_joins=\"$sch_check\"";
//  $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
//  while($sql_row=mysqli_fetch_array($sql_result))
//  {
//      $color_no[]=$sql_row['order_col_des'];
//      $schedule_no[]=$sql_row['order_del_no'];
//  }
// }
// else
// {
//  $sql="select * from bai_orders_db_confirm where order_tid=\"$tran_order_tid\" group by order_del_no,order_col_des";
//  $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
//  while($sql_row=mysqli_fetch_array($sql_result))
//  {
//      $color_no[]=$sql_row['order_col_des'];
//      $schedule_no[]=$sql_row['order_del_no'];
//  }
// }
// //echo sizeof($color_no)."--".sizeof($schedule_no)."<br>";

// for($k=0;$k<sizeof($schedule_no);$k++)
// {
//  $sql112="select * from bai_pro3.bai_orders_db_confirm_mo where order_del_no='".$schedule_no[$k]."' and order_col_des='".$color_no[$k]."'";
//  //  echo $sql112."<br>";
//  $sql_result112=mysqli_query($link, $sql112) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
//  if(mysqli_num_rows($sql_result112)==0)
//  {
//      $tsql="SELECT
//      [BELMasterUAT].[m3].[MO].Style,
//      [BELMasterUAT].[m3].[MOOperation].ScheduleNumber,
//      [BELMasterUAT].[m3].[StyleMaster].ColorId,
//      [BELMasterUAT].[m3].[ColorMaster].Description,
//      [BELMasterUAT].[m3].[StyleMaster].SizeId,
//      [BELMasterUAT].[m3].[StyleMaster].ZFeature,
//      [BELMasterUAT].[m3].[StyleMaster].ZFeatureId,
//      [BELMasterUAT].[m3].[MOOperation].MONumber,
//      [BELMasterUAT].[m3].[MOOperation].SMV,
//      [BELMasterUAT].[m3].[MOOperation].OperationDescription,
//      [BELMasterUAT].[m3].[MOOperation].OperationNumber,
//      [BELMasterUAT].[m3].[StyleMaster].SequenceNoForSorting,
//      [BELMasterUAT].[m3].[MO].OrderQty,
//      [BELMasterUAT].[m3].[MO].COId,
//      [BELMasterUAT].[m3].[StyleMaster].Description
//      FROM [BELMasterUAT].[m3].[MOOperation]
//      INNER JOIN [BELMasterUAT].[m3].[MO] ON [BELMasterUAT].[m3].[MO].MONumber=[BELMasterUAT].[m3].[MOOperation].MONumber
//      INNER JOIN [BELMasterUAT].[m3].[StyleMaster] ON [BELMasterUAT].[m3].[StyleMaster].SKU=[BELMasterUAT].[m3].[MOOperation].SKU
//      INNER JOIN [BELMasterUAT].[m3].[ColorMaster] ON [BELMasterUAT].[m3].[ColorMaster].ColorId=[BELMasterUAT].[m3].[StyleMaster].ColorId
//      WHERE ScheduleNumber=".$schedule_no[$k]." and [BELMasterUAT].[m3].[ColorMaster].Description='".$color_no[$k]."'
//      ORDER BY [BELMasterUAT].[m3].[StyleMaster].SequenceNoForSorting,[BELMasterUAT].[m3].[StyleMaster].ZFeatureId,
//      [BELMasterUAT].[m3].[MOOperation].MONumber,[BELMasterUAT].[m3].[MOOperation].OperationNumber*1";
//      //  echo $tsql."<br>";
//      $ii=1;$temp_size='';$old_Mo_tmp=0;$i=1;
//      $result = odbc_exec($connect, $tsql);
//      while(odbc_fetch_row($result))
//      {
//          $Style=odbc_result($result,1);
//          $ScheduleNumber=odbc_result($result,2);
//          $ColorId=str_replace('"',"",odbc_result($result,4));
//          $Description=odbc_result($result,4);
//          $sizeidold=odbc_result($result,5);
//          $ZFeature=odbc_result($result,6);
//          $ZFeatureId=odbc_result($result,7);
//          $MONumber=odbc_result($result,8);
//          $SMV=odbc_result($result,9);
//          $OperationDescription=odbc_result($result,10);
//          $OperationNumber=odbc_result($result,11);
//          $SequenceNoForSorting=odbc_result($result,12);
//          $mo_qty=odbc_result($result,13);
//          $co_no=odbc_result($result,14);
//          $SizeId=odbc_result($result,15);
//          $desti_n=odbc_result($result,6);
//          $sfcs_size_code='';
//          $sql2="select * from bai_pro3.bai_orders_db_confirm where order_del_no='".$ScheduleNumber."' and order_col_des='".$ColorId."'";
//          //echo $sql."<br>";
//          $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
//          while($sql_row=mysqli_fetch_array($sql_result2))
//          {
//              for($j=0;$j<sizeof($sizes_array);$j++)
//              {
//                  if(trim($sql_row["title_size_".$sizes_array[$j].""]) == trim($SizeId))
//                  {
//                      $sfcs_size_code=$sizes_array[$j];
//                  }
//              }
//          }
//          $sfcs_ops=get_val("m3_bulk_ops_rep_db.m3_operation_master","sfcsm3operation","m3operationid",$OperationNumber,$link);

//          $sql12="INSERT INTO `bai_pro3`.`bai_orders_db_confirm_mo` (`order_style_no`, `order_del_no`, `order_col_des`, `sfcs_size`, `m_size`, `mo_qty`, `sfcs_ops`, `m_ops`, `zfeature_desc`, `mo_number`, `destination`, `zfeature`, `co_no`)
//          VALUES('".$Style."','".$ScheduleNumber."','".$ColorId."','".$sfcs_size_code."','".$SizeId."','".$mo_qty."','".$sfcs_ops."','".$OperationNumber."','".$ZFeature."','".$MONumber."','".$desti_n."','".$ZFeatureId."','".$co_no."')";
//          $sql_result12=mysqli_query($link, $sql12) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
//          if($old_Mo_tmp<>$MONumber && $ii==2)
//          {
//              $sql13="update bai_pro3.bai_orders_db_confirm_mo set order_no='".$i."' where mo_number='".$old_Mo_tmp."'";
//              $sql_result13=mysqli_query($link, $sql13) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
//              $i++;
//          }
//          $ii=2;
//          $temp_size=$SizeId;
//          $old_Mo_tmp=$MONumber;
//      }
//      $sql21="update bai_pro3.bai_orders_db_confirm_mo set order_no='".$i."' where mo_number='".$MONumber."'";
//      $sql_result21=mysqli_query($link, $sql21) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));


//  }
// }
//echo "<div class='panel panel-primary'><div class='panel-body'>";
$order_joins_check="SELECT order_joins FROM $bai_pro3.`bai_orders_db_confirm` WHERE order_tid='".$tran_order_tid."'";
$order_joins_result=mysqli_query($link, $order_joins_check) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($order_joins_result))
{
    $order_joins=$sql_row['order_joins'];
}
if ($order_joins>'0' or $order_joins>0) {
 echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
        function Redirect() {
            sweetAlert('Successfully Generated','','success');
            location.href = \"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=$color&style=$style&schedule=$schedule\";
            }
        </script>";
        
    // echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
            // function Redirect() {
                // location.href = \"".getFullURLLevel($_GET['r'], 'production/controllers/sewing_job/sewing_job_mo_fill.php',3,'N')."&order_tid=$tran_order_tid&process_name=cutting&filename=layplan\";
                // }
            // </script>";      
} else {
    echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
            function Redirect() {
                location.href = \"".getFullURLLevel($_GET['r'], 'orders_sync.php',0,'N')."&order_tid=$tran_order_tid&color=$color&style=$style&schedule=$schedule\";
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
    echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
        function Redirect() {
            sweetAlert('Dockets Already Generated','','warning');
            location.href = \"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=$color&style=$style&schedule=$schedule\";
            }
        </script>";

}
    
//echo "<a href=\"".getFullURLLevel($_GET['r'], "main_interface.php", "1", "N")."&color=$color&style=$style&schedule=$schedule\" class='btn btn-warning btn-sm'>Click here to Go Back</a>";

// echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";


//$path="".getFullURLLevel($_GET['r'], "new_doc_gen/Book3_print.php", "1", "R")."?order_tid=$tran_order_tid&cat_ref=$cat_ref&doc_id=$doc_no&cut_no=$cut_no";
//echo "<td><a href=\"$path\" onclick=\"return popitup("."'".$path."')\" class='btn btn-info btn-sm'>Click Here to View Cutting Docket</a></td>";


((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res);
?>
</div>
</div>

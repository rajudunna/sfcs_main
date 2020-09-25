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
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config_ajax.php',4,'R')); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/php/functions.php',4,'R'));?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/mo_filling.php',4,'R'));?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',4,'R')); ?>
<?php

    function mofillingforrecutreplace($qty,$bcd_id)
    {
        include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
        //retreaving next operation of 15 for that style and color
        $selcting_qry = "SELECT bcd.style,mapped_color,operation_id,bundle_number,operation_order,`ops_sequence` FROM 
        $brandix_bts.bundle_creation_data bcd LEFT JOIN $brandix_bts.tbl_orders_ops_ref ops ON ops.operation_code=bcd.operation_id 
        LEFT JOIN $brandix_bts.tbl_style_ops_master ts ON ts.operation_code=bcd.operation_id AND ts.`style` = bcd.`style` AND ts.`color` = bcd.`mapped_color`
        WHERE bcd.id = $bcd_id";
        //echo $selcting_qry.'</br>';
        $result_selcting_qry=mysqli_query($link, $selcting_qry) or die("selcting_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($ops_row=mysqli_fetch_array($result_selcting_qry)) 
        {
            $style = $ops_row['style'];
            $color = $ops_row['mapped_color'];
            $operation_id = $ops_row['operation_id'];
            $bundle_number = $ops_row['bundle_number'];
            $category_act = $ops_row['category'];
            $ops_seq = $ops_row['ops_sequence'];
            $ops_order = $ops_row['operation_order'];
        }
        if($operation_id != 15)
        {
            $category=["'Send PF'","'Receive PF'"];
            if(in_array($category_act,$category))
            {
                $emb_cut_check_flag = 1;
            }
            if($emb_cut_check_flag)
            {
                $operation_mapping_qry = "SELECT tm.operation_code,tr.operation_name FROM `$brandix_bts`.`tbl_style_ops_master` tm 
                LEFT JOIN `$brandix_bts`.`tbl_orders_ops_ref` tr ON tr.operation_code = tm.`operation_code`
                WHERE style = '$style' AND color = '$color'
                AND category IN (".implode(',',$category).")";
            }
            else
            {
                $operation_mapping_qry = "SELECT tm.operation_code,tr.operation_name,operation_order,ops_sequence FROM `$brandix_bts`.`tbl_style_ops_master` tm 
                LEFT JOIN `$brandix_bts`.`tbl_orders_ops_ref` tr ON tr.operation_code = tm.`operation_code`
                WHERE style = '$style' AND color = '$color'
                AND category NOT IN (".implode(',',$category).") AND tm.operation_code NOT IN (10,200,15) AND CAST(operation_order AS CHAR) <= '$ops_order' 
                AND ops_sequence = '$ops_seq'
                ORDER BY operation_order";
            }
            //echo $operation_mapping_qry.'</br>';
            $result_operation_mapping_qry=mysqli_query($link, $operation_mapping_qry) or die("Mo Details not available.".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($ops_row=mysqli_fetch_array($result_operation_mapping_qry)) 
            {
                $op_codes[] = $ops_row['operation_code'];
            }
            //var_dump($op_codes).'</br>';
            $multiple_mos_tot_qty = $qty;
            $moq_qry = "SELECT id,mo_no,ref_no,op_code,bundle_quantity,SUM(bundle_quantity)AS bundle_quantity,SUM(good_quantity)AS good_quantity,
            SUM(rejected_quantity)AS rejected_quantity,(SUM(rejected_quantity)-(SUM(bundle_quantity)-bundle_quantity))AS rem FROM 
            $bai_pro3.`mo_operation_quantites` 
            WHERE ref_no=$bundle_number AND op_code=$operation_id GROUP BY mo_no,ref_no,op_code 
            ORDER BY id";
            //echo $moq_qry.'</br>';
            $moq_qry_res = $link->query($moq_qry);
            while($row_moq = $moq_qry_res->fetch_assoc()) 
            {
                $max_mo_no = $row_moq['mo_no'];
                $bundle_quantity_mo = $row_moq['rem'] - $array_mos[$max_mo_no];
                if($bundle_quantity_mo < $multiple_mos_tot_qty)
                {
          
                    $multiple_mos_tot_qty = $multiple_mos_tot_qty - $bundle_quantity_mo;
                    $to_add_mo = $bundle_quantity_mo;
                    $array_mos[$max_mo_no]  = $bundle_quantity_mo;
                }
                else
                {
                    $to_add_mo = $multiple_mos_tot_qty;
                    $array_mos[$max_mo_no]  = $multiple_mos_tot_qty;
                    $multiple_mos_tot_qty = 0;
                }
                if($to_add_mo > 0)
                {
                    //insert qry
                    foreach($op_codes as $key=>$value)
                    {
                        $updae_moq_qry="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`, `bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$max_mo_no."', '".$bundle_number."','".$to_add_mo."', '$value', 'Cutting')";
                        mysqli_query($link,$updae_moq_qry) or exit("Whille inserting recut to moq".mysqli_error($GLOBALS["___mysqli_ston"]));
                    }
                }
            }
    
        }
    }

$tran_order_tid=order_tid_decode($_GET['tran_order_tid']);
$mk_ref=$_GET['mkref'];
$allocate_ref=$_GET['allocate_ref'];
$cat_ref2=$_GET['cat_ref'];
$color=color_decode($_GET['color']);
$schedule=$_GET['schedule'];
$serial_no=$_GET['serial_no'];
$sql44="select marker_details_id as marker_details_id from $bai_pro3.maker_stat_log where tid='$mk_ref'";
$sql_result144=mysqli_query($link, $sql44) or exit($sql."Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row144=mysqli_fetch_array($sql_result144))
{
	$marker_details_id =$sql_row144['marker_details_id'];
}
$sql4="select * from $bai_pro3.plandoc_stat_log where order_tid='$tran_order_tid' and cat_ref='$cat_ref2' and allocate_ref='$allocate_ref' and mk_ref='$mk_ref'";
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

if($sql_result1_res==0){
    ?>
    <h3><font face="verdana" color="green">Please wait <br> Docket is Generating...</font></h3>
    <?php
    $tran_order_tid=order_tid_decode($_GET['tran_order_tid']);
    $mk_ref=$_GET['mkref'];
    $allocate_ref=$_GET['allocate_ref'];
    $cat_ref2=$_GET['cat_ref'];
    $date=date("Y-m-d", mktime(0,0,0,date("m") ,date("d"),date("Y")));


    $sql="select * from $bai_pro3.allocate_stat_log where order_tid=\"$tran_order_tid\" and tid=$allocate_ref and mk_status!=9 and recut_lay_plan='yes'";
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
        // for($s=0;$s<sizeof($sizes_array);$s++)
        // {
        //     if($sql_row["allocate_".$sizes_array[$s].""]<>'')
        //     {
        //         $s_tit[$sizes_array[$s]]=$sql_row['plies']*$sql_row["allocate_".$sizes_array[$s].""];
        //     }	
        // }
      
        $plies=$sql_row['plies'];
        $pliespercut=$sql_row['pliespercut'];
        $ratio=$sql_row['ratio'];
        $remarks='Recut';

        $cat_ref=$sql_row['cat_ref'];
        $cuttable_ref=$sql_row['cuttable_ref'];

        $count=0;
        $temp=$plies;
        $sql2="select MAX(pcutno) as \"count\" from $bai_pro3.plandoc_stat_log where order_tid=\"$tran_order_tid\" and cat_ref=$cat_ref";
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
        while($temp>=$pliespercut)
	    {
            $count=$count+1;
            $pcutdocid=$tran_order_tid."/".$allocate_ref."/".$count;

            $sql2="insert into $bai_pro3.plandoc_stat_log(pcutdocid, date, cat_ref, cuttable_ref, allocate_ref, mk_ref, order_tid, pcutno, ratio, p_s01, p_s02, p_s03, p_s04, p_s05, p_s06, p_s07, p_s08, p_s09, p_s10, p_s11, p_s12, p_s13, p_s14, p_s15, p_s16, p_s17, p_s18, p_s19, p_s20, p_s21, p_s22, p_s23, p_s24, p_s25, p_s26, p_s27, p_s28, p_s29, p_s30, p_s31, p_s32, p_s33, p_s34, p_s35, p_s36, p_s37, p_s38, p_s39, p_s40, p_s41, p_s42, p_s43, p_s44, p_s45, p_s46, p_s47, p_s48, p_s49, p_s50, p_plies, acutno, a_s01, a_s02, a_s03, a_s04, a_s05, a_s06, a_s07, a_s08, a_s09, a_s10, a_s11, a_s12, a_s13, a_s14, a_s15, a_s16, a_s17, a_s18, a_s19, a_s20, a_s21, a_s22, a_s23, a_s24, a_s25, a_s26, a_s27, a_s28, a_s29, a_s30, a_s31, a_s32, a_s33, a_s34, a_s35, a_s36, a_s37, a_s38, a_s39, a_s40, a_s41, a_s42, a_s43, a_s44, a_s45, a_s46, a_s47, a_s48, a_s49, a_s50,  a_plies, remarks,mk_ref_id) values (\"$pcutdocid\", \"$date\", $cat_ref, $cuttable_ref, $allocate_ref, $mk_ref, \"$tran_order_tid\", $count, $ratio, $s01, $s02, $s03, $s04, $s05, $s06, $s07, $s08, $s09, $s10, $s11, $s12, $s13, $s14, $s15, $s16, $s17, $s18, $s19, $s20, $s21, $s22, $s23, $s24, $s25, $s26, $s27, $s28, $s29, $s30, $s31, $s32, $s33, $s34, $s35, $s36, $s37, $s38, $s39, $s40, $s41, $s42, $s43, $s44, $s45, $s46, $s47, $s48, $s49, $s50, $pliespercut, $count, $s01, $s02, $s03, $s04, $s05, $s06, $s07, $s08, $s09, $s10, $s11, $s12, $s13, $s14, $s15, $s16, $s17, $s18, $s19, $s20, $s21, $s22, $s23, $s24, $s25, $s26, $s27, $s28, $s29, $s30, $s31, $s32, $s33, $s34, $s35, $s36, $s37, $s38, $s39, $s40, $s41, $s42, $s43, $s44, $s45, $s46, $s47, $s48, $s49, $s50, $pliespercut, \"$remarks\" , '$marker_details_id')";

            mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            

            $docket_no = mysqli_insert_id($link);
            $category_new = "SELECT category FROM `$bai_pro3`.`cat_stat_log` where tid in (select cat_ref from  `$bai_pro3`.`plandoc_stat_log` where doc_no=$docket_no)";
            $category_new_res = $link->query($category_new);
            while($category_new_res1 = $category_new_res->fetch_assoc()) 
            {
                $cty =$category_new_res1['category'];
            }

            $sql_recut_v2="insert into $bai_pro3.recut_v2 (pcutdocid, date, cat_ref, cuttable_ref, allocate_ref, mk_ref, order_tid,pcutno, ratio, p_s01, p_s02, p_s03, p_s04, p_s05, p_s06, p_s07, p_s08, p_s09, p_s10, p_s11, p_s12, p_s13, p_s14, p_s15, p_s16, p_s17, p_s18, p_s19, p_s20, p_s21, p_s22, p_s23, p_s24, p_s25, p_s26, p_s27, p_s28, p_s29, p_s30, p_s31, p_s32, p_s33, p_s34, p_s35, p_s36, p_s37, p_s38, p_s39, p_s40, p_s41, p_s42, p_s43, p_s44, p_s45, p_s46, p_s47, p_s48, p_s49, p_s50, p_plies, acutno, a_s01, a_s02, a_s03, a_s04, a_s05, a_s06, a_s07, a_s08, a_s09, a_s10, a_s11, a_s12, a_s13, a_s14, a_s15, a_s16, a_s17, a_s18, a_s19, a_s20, a_s21, a_s22, a_s23, a_s24, a_s25, a_s26, a_s27, a_s28, a_s29, a_s30, a_s31, a_s32, a_s33, a_s34, a_s35, a_s36, a_s37, a_s38, a_s39, a_s40, a_s41, a_s42, a_s43, a_s44, a_s45, a_s46, a_s47, a_s48, a_s49, a_s50,  a_plies,doc_no, remarks) values (\"$pcutdocid\", \"$date\", $cat_ref, $cuttable_ref, $allocate_ref, $mk_ref, \"$tran_order_tid\",$count, $ratio, $s01, $s02, $s03, $s04, $s05, $s06, $s07, $s08, $s09, $s10, $s11, $s12, $s13, $s14, $s15, $s16, $s17, $s18, $s19, $s20, $s21, $s22, $s23, $s24, $s25, $s26, $s27, $s28, $s29, $s30, $s31, $s32, $s33, $s34, $s35, $s36, $s37, $s38, $s39, $s40, $s41, $s42, $s43, $s44, $s45, $s46, $s47, $s48, $s49, $s50, $pliespercut, $count, $s01, $s02, $s03, $s04, $s05, $s06, $s07, $s08, $s09, $s10, $s11, $s12, $s13, $s14, $s15, $s16, $s17, $s18, $s19, $s20, $s21, $s22, $s23, $s24, $s25, $s26, $s27, $s28, $s29, $s30, $s31, $s32, $s33, $s34, $s35, $s36, $s37, $s38, $s39, $s40, $s41, $s42, $s43, $s44, $s45, $s46, $s47, $s48, $s49, $s50, $pliespercut,$docket_no,'$cty')";
            mysqli_query($link,$sql_recut_v2) or exit("While inserting into the recut v2".mysqli_error($GLOBALS["___mysqli_ston"]));

            $temp=$temp-$pliespercut;

            //checking for body/front categories #1907 enabled for all categories
            $cat_query = "SELECT category from $bai_pro3.cat_stat_log where tid='$cat_ref' and category in ($in_categories)";
            $cat_result = mysqli_query($link,$cat_query);
            if(mysqli_num_rows($cat_result) > 0){
                if($docket_no > 0){
                    $insert_bundle_creation_data = doc_size_wise_bundle_insertion($docket_no);
                    if($insert_bundle_creation_data){
                        // Data inserted successfully
                    }
                    // $docket_no = '';
                }
            } 
            $plndoc_qry = "select * from  `$bai_pro3`.`plandoc_stat_log` where doc_no=$docket_no";
            // echo $plndoc_qry.'plndoc_qry sizes<br/>';
            $plndoc_qry_res = mysqli_query($link,$plndoc_qry);
            while($plndoc_qry_res_row=mysqli_fetch_array($plndoc_qry_res))
            {
                for($p=0;$p<sizeof($sizes_array);$p++)
                {
                    // var_dump($plndoc_qry_res_row['a_plies'].'$s_tit<br/>');
                    if($plndoc_qry_res_row["a_".$sizes_array[$p].""] >0)
                    {
                        $s_tit[$sizes_array[$p]]=$plndoc_qry_res_row['a_plies']*$plndoc_qry_res_row["a_".$sizes_array[$p].""];
                        // var_dump($s_tit[$sizes_array[$p]].'$s_tit<br/>');

                    }	
                }
            }
            // var_dump($s_tit.'$s_tit<br/>');
            $lay_plan_recut_track="SELECT * FROM `bai_pro3`.`lay_plan_recut_track` WHERE allocated_id='$cuttable_ref' AND cat_ref=$cat_ref";
            // echo $lay_plan_recut_track."<br>";
            $lay_plan_recut_track_res = mysqli_query($link,$lay_plan_recut_track);
            if(mysqli_num_rows($lay_plan_recut_track_res) > 0)
            {
                while($lay_plan_recut_track_row=mysqli_fetch_array($lay_plan_recut_track_res))
                {
                    $act_id=$lay_plan_recut_track_row['bcd_id'];
                    $cat_ref=$lay_plan_recut_track_row['cat_ref'];
                    $idsss=$lay_plan_recut_track_row['id'];

                
                        $retreaving_bcd_data = "SELECT * FROM `$brandix_bts`.`bundle_creation_data` WHERE id IN ($act_id) ORDER BY barcode_sequence";
                        // echo $retreaving_bcd_data."<br>";

                        $retreaving_bcd_data_res = $link->query($retreaving_bcd_data);
                        while($row_bcd = $retreaving_bcd_data_res->fetch_assoc()) 
                        {
                            $to_add_mo = 0;
                            $bcd_act_id = $row_bcd['id'];
                            $bundle_number = $row_bcd['bundle_number'];
                            $operation_id = $row_bcd['operation_id'];
                            $size_id = $row_bcd['size_id'];
                            $retreaving_rej_qty = "SELECT * FROM `$bai_pro3`.`lay_plan_recut_track` where bcd_id = $bcd_act_id  AND cat_ref=$cat_ref and id in ($idsss)";
                            // echo $retreaving_rej_qty."<br>";
                            $retreaving_rej_qty_res = $link->query($retreaving_rej_qty);
                            while($child_details = $retreaving_rej_qty_res->fetch_assoc()) 
                            {
                                // echo "recut_raised_qty----".$child_details['recut_raised_qty']."<br>";
                                // echo "recut_allocated_qty----".$child_details['recut_allocated_qty']."<br>";
                                $size_id22=$child_details['size_id'];
                                $recut_allowing_qty = $s_tit[$size_id22];
                                $actual_allowing_to_recut = $child_details['recut_raised_qty']-$child_details['recut_allocated_qty'];
                            }
                            // echo "size_id22----".$size_id22."<br>";
                            // echo "recut_allowing_qty----".$recut_allowing_qty."<br>";
                            // echo "actual_allowing_to_recut----".$actual_allowing_to_recut."<br>";

                                if($actual_allowing_to_recut < $recut_allowing_qty)
                                {
                                    
                                    $to_add = $actual_allowing_to_recut;
                                    $recut_allowing_qty = $recut_allowing_qty - $actual_allowing_to_recut;
                                    $s_tit[$size_id22]= $s_tit[$size_id22]-$to_add;
                                }
                                else
                                {
                                    $to_add = $recut_allowing_qty;
                                    $recut_allowing_qty = 0;
                                    $s_tit[$size_id22]= $to_add-$s_tit[$size_id22];
                                }
                            // echo "to_add----".$to_add."<br>";
                            
                            if($to_add > 0)
                            {
                                $inserting_into_recut_v2_child = "INSERT INTO `$bai_pro3`.`recut_v2_child` (`parent_id`,`bcd_id`,`operation_id`,`rejected_qty`,`recut_qty`,`recut_reported_qty`,`issued_qty`,`size_id`)
                                VALUES($docket_no,$bcd_act_id,$operation_id,$to_add,$to_add,0,0,'$size_id')";
                                mysqli_query($link,$inserting_into_recut_v2_child) or exit("While inserting into the recut v2 child".mysqli_error($GLOBALS["___mysqli_ston"]));
                                // echo $inserting_into_recut_v2_child."inserting_into_recut_v2_child<br>";

                                //retreaving bundle_number of recut docket from bcd and inserting into moq
                                $retreaving_qry="select bundle_number from $brandix_bts.bundle_creation_data where docket_number='$docket_no' and operation_id ='15' and size_id = '$size_id'";
                                $retreaving_qry_res = $link->query($retreaving_qry);
                                while($row_bcd_recut = $retreaving_qry_res->fetch_assoc()) 
                                {
                                    $bundle_number_recut = $row_bcd_recut['bundle_number'];
                                }
                                if(strtolower($cty) == 'body' || strtolower($cty) == 'front')
                                {
                                    $multiple_mos_tot_qty = $to_add;
                                    $array_mos = array();
                                    //retreaving mo_number which is related to that bcd_act_id
                                    $moq_qry = "SELECT mo_no,bundle_quantity,`rejected_quantity` FROM $bai_pro3.`mo_operation_quantites` WHERE ref_no=$bundle_number AND op_code=$operation_id AND `rejected_quantity`>0 ORDER BY mo_no";
                                    // echo $moq_qry.'</br>';
                                    // die();
                                    $moq_qry_res = $link->query($moq_qry);
                                    while($row_moq = $moq_qry_res->fetch_assoc()) 
                                    {
                                        $max_mo_no = $row_moq['mo_no'];
                                        // echo $r/ow_moq['rejected_quantity'].'-'.$array_mos[$max_mo_no].'</br>';
                                        $bundle_quantity_mo = $row_moq['rejected_quantity'] - $array_mos[$max_mo_no];
                                        // echo $bundle_quantity_mo.'-'.$multiple_mos_tot_qty.'</br>';
                                        if($bundle_quantity_mo < $multiple_mos_tot_qty)
                                        {
                                            $multiple_mos_tot_qty = $multiple_mos_tot_qty - $bundle_quantity_mo;
                                            $to_add_mo = $bundle_quantity_mo;
                                            $array_mos[$max_mo_no]  = $bundle_quantity_mo;
                                        }
                                        else
                                        {
                                            $to_add_mo = $multiple_mos_tot_qty;
                                            $array_mos[$max_mo_no]  = $multiple_mos_tot_qty;
                                            $multiple_mos_tot_qty = 0;
                                        }
                                        // echo $to_add_mo.'to_add_mo</br>';
                                        if($to_add_mo > 0)
                                        {
                                            $checking_moq_qry = "SELECT * FROM $bai_pro3.mo_operation_quantites WHERE ref_no = $bundle_number_recut AND op_code = 15";
                                            // echo $checking_moq_qry.'</br>';
                                            $checking_moq_qry_res = $link->query($checking_moq_qry);
                                            if(mysqli_num_rows($checking_moq_qry_res) > 0)
                                            {
                                                //update qry
                                                while($row_moq_bcd = $checking_moq_qry_res->fetch_assoc()) 
                                                {
                                                    $id_moq = $row_moq_bcd['id'];
                                                }
                                                $updae_moq_qry = "update $bai_pro3.mo_operation_quantites set bundle_quantity = bundle_quantity+$to_add_mo where id=$id_moq";
                                            }
                                            else
                                            {
                                                //insert qry
                                                $updae_moq_qry="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`, `bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$max_mo_no."', '".$bundle_number_recut."','".$to_add_mo."', '15', 'Cutting')";
                                            }
                                            // echo $updae_moq_qry.'</br>';
                                            mysqli_query($link,$updae_moq_qry) or exit("Whille inserting recut to moq".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        }
                                    }
                                    $update_rejection_log_child = "update $bai_pro3.rejection_log_child set recut_qty = recut_qty+$to_add where bcd_id = $bcd_act_id";
                                    // echo $update_rejection_log_child."<br>";
                                    mysqli_query($link,$update_rejection_log_child) or exit("While updating rejection log child".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $to_add_mo += $to_add;
                                    $update_rejection_log = "update $bai_pro3.rejections_log set recut_qty = recut_qty+$to_add,remaining_qty = remaining_qty - $to_add where style = '$style' and schedule = '$schedule' and color = '$color'";
                                    // echo $update_rejection_log."<br>";

                                    mysqli_query($link,$update_rejection_log) or exit("While updating rejection log".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    
                                    // echo $to_add_mo."<br>";
                                    // echo $bcd_act_id."<br>";
                                    $mo_changes11 = mofillingforrecutreplace($to_add_mo,$bcd_act_id);
                                }
                                $update_lay_plan_recut_track = "update $bai_pro3.lay_plan_recut_track set recut_allocated_qty = recut_allocated_qty+$to_add,remaining_qty = remaining_qty-$to_add  where bcd_id = $bcd_act_id and cat_ref=$cat_ref and id in ($idsss)";
                                // echo $update_lay_plan_recut_track."<br>";
                                mysqli_query($link,$update_lay_plan_recut_track) or exit("While updating lay_plan_recut_track".mysqli_error($GLOBALS["___mysqli_ston"]));
                            }
                        }
                    
                }

            }       
                
            //// For back Redirection
            $sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\"";
            $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            $sql_num_check=mysqli_num_rows($sql_result);
        
            while($sql_row=mysqli_fetch_array($sql_result))
            {
                $color=$sql_row['order_col_des'];
                $style=$sql_row['order_style_no'];
                $schedule=$sql_row['order_del_no'];
            }
            $codes='2';
            $status='';
            $module=0;
        
        
            $qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.recut_v2 WHERE doc_no = '$docket_no' ";
            $result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
            while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
            {
                for ($i=0; $i < sizeof($sizes_array); $i++)
                { 
                    if ($row['a_'.$sizes_array[$i]] > 0)
                    {
                        $cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]] * $row['a_plies'];
                        $size[] = $sizes_array[$i];
                    }
                }
            }
            for($j=0;$j<sizeof($size);$j++)
            {
        
                $qty_act = $cut_done_qty[$size[$j]];
                $sql1234="insert into $bai_pro3.bai_qms_db (qms_style,qms_schedule,qms_color,log_date,qms_size,qms_qty,qms_tran_type,remarks) values (\"$style\",\"$schedule\",\"$color\",\"".date("Y-m-d")."\",\"".$size[$j]."\",".($qty_act).",9,\"$module-".$docket_no."\")";
                // echo $sql1234.'bai_qms_db<br/>';
                mysqli_query($link, $sql1234) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
                
            }
            $hostname=explode(".",gethostbyaddr($_SERVER['REMOTE_ADDR']));
            $sql4312="insert into $bai_pro3.recut_track(doc_no,username,sys_name,log_time,level,status) values(\"".$docket_no."\",\"".$username."\",\"".$hostname[0]."\",\"".date("Y-m-d H:i:s")."\",\"".$codes."\",\"".$status."\")";
            // echo $sql4312.'recut_track<br/>';

            mysqli_query($link, $sql4312) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        }

        while($temp>0)
	    {
            $count=$count+1;
            $pcutdocid=$tran_order_tid."/".$allocate_ref."/".$count;

            $sql2="insert into $bai_pro3.plandoc_stat_log(pcutdocid, date, cat_ref, cuttable_ref, allocate_ref, mk_ref, order_tid, pcutno, ratio, p_s01, p_s02, p_s03, p_s04, p_s05, p_s06, p_s07, p_s08, p_s09, p_s10, p_s11, p_s12, p_s13, p_s14, p_s15, p_s16, p_s17, p_s18, p_s19, p_s20, p_s21, p_s22, p_s23, p_s24, p_s25, p_s26, p_s27, p_s28, p_s29, p_s30, p_s31, p_s32, p_s33, p_s34, p_s35, p_s36, p_s37, p_s38, p_s39, p_s40, p_s41, p_s42, p_s43, p_s44, p_s45, p_s46, p_s47, p_s48, p_s49, p_s50, p_plies, acutno, a_s01, a_s02, a_s03, a_s04, a_s05, a_s06, a_s07, a_s08, a_s09, a_s10, a_s11, a_s12, a_s13, a_s14, a_s15, a_s16, a_s17, a_s18, a_s19, a_s20, a_s21, a_s22, a_s23, a_s24, a_s25, a_s26, a_s27, a_s28, a_s29, a_s30, a_s31, a_s32, a_s33, a_s34, a_s35, a_s36, a_s37, a_s38, a_s39, a_s40, a_s41, a_s42, a_s43, a_s44, a_s45, a_s46, a_s47, a_s48, a_s49, a_s50,  a_plies, remarks,mk_ref_id) values (\"$pcutdocid\", \"$date\", $cat_ref, $cuttable_ref, $allocate_ref, $mk_ref, \"$tran_order_tid\", $count, $ratio, $s01, $s02, $s03, $s04, $s05, $s06, $s07, $s08, $s09, $s10, $s11, $s12, $s13, $s14, $s15, $s16, $s17, $s18, $s19, $s20, $s21, $s22, $s23, $s24, $s25, $s26, $s27, $s28, $s29, $s30, $s31, $s32, $s33, $s34, $s35, $s36, $s37, $s38, $s39, $s40, $s41, $s42, $s43, $s44, $s45, $s46, $s47, $s48, $s49, $s50, $temp, $count, $s01, $s02, $s03, $s04, $s05, $s06, $s07, $s08, $s09, $s10, $s11, $s12, $s13, $s14, $s15, $s16, $s17, $s18, $s19, $s20, $s21, $s22, $s23, $s24, $s25, $s26, $s27, $s28, $s29, $s30, $s31, $s32, $s33, $s34, $s35, $s36, $s37, $s38, $s39, $s40, $s41, $s42, $s43, $s44, $s45, $s46, $s47, $s48, $s49, $s50, $temp, \"$remarks\" , '$marker_details_id')";

            mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            

            $docket_no = mysqli_insert_id($link);
            $category_new = "SELECT category FROM `$bai_pro3`.`cat_stat_log` where tid in (select cat_ref from  `$bai_pro3`.`plandoc_stat_log` where doc_no=$docket_no)";
            $category_new_res = $link->query($category_new);
            while($category_new_res1 = $category_new_res->fetch_assoc()) 
            {
                $cty =$category_new_res1['category'];
            }

            $sql_recut_v2="insert into $bai_pro3.recut_v2 (pcutdocid, date, cat_ref, cuttable_ref, allocate_ref, mk_ref, order_tid,pcutno, ratio, p_s01, p_s02, p_s03, p_s04, p_s05, p_s06, p_s07, p_s08, p_s09, p_s10, p_s11, p_s12, p_s13, p_s14, p_s15, p_s16, p_s17, p_s18, p_s19, p_s20, p_s21, p_s22, p_s23, p_s24, p_s25, p_s26, p_s27, p_s28, p_s29, p_s30, p_s31, p_s32, p_s33, p_s34, p_s35, p_s36, p_s37, p_s38, p_s39, p_s40, p_s41, p_s42, p_s43, p_s44, p_s45, p_s46, p_s47, p_s48, p_s49, p_s50, p_plies, acutno, a_s01, a_s02, a_s03, a_s04, a_s05, a_s06, a_s07, a_s08, a_s09, a_s10, a_s11, a_s12, a_s13, a_s14, a_s15, a_s16, a_s17, a_s18, a_s19, a_s20, a_s21, a_s22, a_s23, a_s24, a_s25, a_s26, a_s27, a_s28, a_s29, a_s30, a_s31, a_s32, a_s33, a_s34, a_s35, a_s36, a_s37, a_s38, a_s39, a_s40, a_s41, a_s42, a_s43, a_s44, a_s45, a_s46, a_s47, a_s48, a_s49, a_s50,  a_plies,doc_no, remarks) values (\"$pcutdocid\", \"$date\", $cat_ref, $cuttable_ref, $allocate_ref, $mk_ref, \"$tran_order_tid\",$count, $ratio, $s01, $s02, $s03, $s04, $s05, $s06, $s07, $s08, $s09, $s10, $s11, $s12, $s13, $s14, $s15, $s16, $s17, $s18, $s19, $s20, $s21, $s22, $s23, $s24, $s25, $s26, $s27, $s28, $s29, $s30, $s31, $s32, $s33, $s34, $s35, $s36, $s37, $s38, $s39, $s40, $s41, $s42, $s43, $s44, $s45, $s46, $s47, $s48, $s49, $s50, $temp, $count, $s01, $s02, $s03, $s04, $s05, $s06, $s07, $s08, $s09, $s10, $s11, $s12, $s13, $s14, $s15, $s16, $s17, $s18, $s19, $s20, $s21, $s22, $s23, $s24, $s25, $s26, $s27, $s28, $s29, $s30, $s31, $s32, $s33, $s34, $s35, $s36, $s37, $s38, $s39, $s40, $s41, $s42, $s43, $s44, $s45, $s46, $s47, $s48, $s49, $s50, $temp,$docket_no,'$cty')";
            mysqli_query($link,$sql_recut_v2) or exit("While inserting into the recut v2".mysqli_error($GLOBALS["___mysqli_ston"]));
            $temp=0;
            $cat_query = "SELECT category from $bai_pro3.cat_stat_log where tid='$cat_ref' and category in ($in_categories)";
            $cat_result = mysqli_query($link,$cat_query);
            if(mysqli_num_rows($cat_result) > 0){
                if($docket_no > 0){
                    $insert_bundle_creation_data = doc_size_wise_bundle_insertion($docket_no);
                    if($insert_bundle_creation_data){
                        // Data inserted successfully
                    }
                    // $docket_no = '';
                }
            }
            $plndoc_qry = "select * from  `$bai_pro3`.`plandoc_stat_log` where doc_no=$docket_no";
            // echo $plndoc_qry.'plndoc_qry sizes<br/>';
            $plndoc_qry_res = mysqli_query($link,$plndoc_qry);
            while($plndoc_qry_res_row=mysqli_fetch_array($plndoc_qry_res))
            {
                for($p=0;$p<sizeof($sizes_array);$p++)
                {
                    // var_dump($plndoc_qry_res_row['a_plies'].'$s_tit<br/>');
                    if($plndoc_qry_res_row["a_".$sizes_array[$p].""] >0)
                    {
                        $s_tit[$sizes_array[$p]]=$plndoc_qry_res_row['a_plies']*$plndoc_qry_res_row["a_".$sizes_array[$p].""];
                        // var_dump($s_tit[$sizes_array[$p]].'$s_tit<br/>');

                    }	
                }
            }
            $lay_plan_recut_track="SELECT * FROM `bai_pro3`.`lay_plan_recut_track` WHERE allocated_id='$cuttable_ref' AND cat_ref=$cat_ref";
            $lay_plan_recut_track_res = mysqli_query($link,$lay_plan_recut_track);
            if(mysqli_num_rows($lay_plan_recut_track_res) > 0)
            {
                while($lay_plan_recut_track_row=mysqli_fetch_array($lay_plan_recut_track_res))
                {
                    $act_id=$lay_plan_recut_track_row['bcd_id'];
                    $cat_ref=$lay_plan_recut_track_row['cat_ref'];
                    $idsss=$lay_plan_recut_track_row['id'];
                
                        $retreaving_bcd_data = "SELECT * FROM `$brandix_bts`.`bundle_creation_data` WHERE id IN ($act_id) ORDER BY barcode_sequence";

                        $retreaving_bcd_data_res = $link->query($retreaving_bcd_data);
                        while($row_bcd = $retreaving_bcd_data_res->fetch_assoc()) 
                        {
                            $to_add_mo = 0;
                            $bcd_act_id = $row_bcd['id'];
                            $bundle_number = $row_bcd['bundle_number'];
                            $operation_id = $row_bcd['operation_id'];
                            $size_id = $row_bcd['size_id'];
                            $retreaving_rej_qty = "SELECT * FROM `$bai_pro3`.`lay_plan_recut_track` where bcd_id = $bcd_act_id  AND cat_ref=$cat_ref and id in ($idsss)";
                            // echo $retreaving_rej_qty."<br>";
                            $retreaving_rej_qty_res = $link->query($retreaving_rej_qty);
                            while($child_details = $retreaving_rej_qty_res->fetch_assoc()) 
                            {
                                // echo "recut_raised_qty----".$child_details['recut_raised_qty']."<br>";
                                // echo "recut_allocated_qty----".$child_details['recut_allocated_qty']."<br>";
                                $size_id22=$child_details['size_id'];
                                $recut_allowing_qty = $s_tit[$size_id22];
                                $actual_allowing_to_recut = $child_details['recut_raised_qty']-$child_details['recut_allocated_qty'];
                            }
                            // echo "size_id22----".$size_id22."<br>";
                            // echo "recut_allowing_qty----".$recut_allowing_qty."<br>";
                            // echo "actual_allowing_to_recut----".$actual_allowing_to_recut."<br>";

                                if($actual_allowing_to_recut < $recut_allowing_qty)
                                {
                                    
                                    $to_add = $actual_allowing_to_recut;
                                    $recut_allowing_qty = $recut_allowing_qty - $actual_allowing_to_recut;
                                    $s_tit[$size_id22]= $s_tit[$size_id22]-$to_add;
                                }
                                else
                                {
                                    $to_add = $recut_allowing_qty;
                                    $recut_allowing_qty = 0;
                                    $s_tit[$size_id22]= $to_add-$s_tit[$size_id22];
                                }
                            // echo "to_add next----".$to_add."<br>";
                            if($to_add > 0)
                            {
                                $inserting_into_recut_v2_child = "INSERT INTO `$bai_pro3`.`recut_v2_child` (`parent_id`,`bcd_id`,`operation_id`,`rejected_qty`,`recut_qty`,`recut_reported_qty`,`issued_qty`,`size_id`)
                                VALUES($docket_no,$bcd_act_id,$operation_id,$to_add,$to_add,0,0,'$size_id')";
                                mysqli_query($link,$inserting_into_recut_v2_child) or exit("While inserting into the recut v2 child".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    // echo $inserting_into_recut_v2_child."<br>";

                                //retreaving bundle_number of recut docket from bcd and inserting into moq
                                $retreaving_qry="select bundle_number from $brandix_bts.bundle_creation_data where docket_number='$docket_no' and operation_id ='15' and size_id = '$size_id'";
                                $retreaving_qry_res = $link->query($retreaving_qry);
                                while($row_bcd_recut = $retreaving_qry_res->fetch_assoc()) 
                                {
                                    $bundle_number_recut = $row_bcd_recut['bundle_number'];
                                }
                                if(strtolower($cty) == 'body' || strtolower($cty) == 'front')
                                {
                                    $multiple_mos_tot_qty = $to_add;
                                    $array_mos = array();
                                    //retreaving mo_number which is related to that bcd_act_id
                                    $moq_qry = "SELECT mo_no,bundle_quantity,`rejected_quantity` FROM $bai_pro3.`mo_operation_quantites` WHERE ref_no=$bundle_number AND op_code=$operation_id AND `rejected_quantity`>0 ORDER BY mo_no";
                                    // echo $moq_qry.'</br>';
                                    // die();
                                    $moq_qry_res = $link->query($moq_qry);
                                    while($row_moq = $moq_qry_res->fetch_assoc()) 
                                    {
                                        $max_mo_no = $row_moq['mo_no'];
                                        // echo $row_moq['rejected_quantity'].'-'.$array_mos[$max_mo_no].'</br>';
                                        $bundle_quantity_mo = $row_moq['rejected_quantity'] - $array_mos[$max_mo_no];
                                        // echo $bundle_quantity_mo.'-'.$multiple_mos_tot_qty.'</br>';
                                        if($bundle_quantity_mo < $multiple_mos_tot_qty)
                                        {
                                            $multiple_mos_tot_qty = $multiple_mos_tot_qty - $bundle_quantity_mo;
                                            $to_add_mo = $bundle_quantity_mo;
                                            $array_mos[$max_mo_no]  = $bundle_quantity_mo;
                                        }
                                        else
                                        {
                                            $to_add_mo = $multiple_mos_tot_qty;
                                            $array_mos[$max_mo_no]  = $multiple_mos_tot_qty;
                                            $multiple_mos_tot_qty = 0;
                                        }
                                        // echo $to_add_mo.'</br>';
                                        if($to_add_mo > 0)
                                        {
                                            $checking_moq_qry = "SELECT * FROM $bai_pro3.mo_operation_quantites WHERE ref_no = $bundle_number_recut AND op_code = 15";
                                            // echo $checking_moq_qry.'</br>';
                                            $checking_moq_qry_res = $link->query($checking_moq_qry);
                                            if(mysqli_num_rows($checking_moq_qry_res) > 0)
                                            {
                                                //update qry
                                                while($row_moq_bcd = $checking_moq_qry_res->fetch_assoc()) 
                                                {
                                                    $id_moq = $row_moq_bcd['id'];
                                                }
                                                $updae_moq_qry = "update $bai_pro3.mo_operation_quantites set bundle_quantity = bundle_quantity+$to_add_mo where id=$id_moq";
                                            }
                                            else
                                            {
                                                //insert qry
                                                $updae_moq_qry="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`, `bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$max_mo_no."', '".$bundle_number_recut."','".$to_add_mo."', '15', 'Cutting')";
                                            }
                                            // echo $updae_moq_qry.'</br>';
                                            mysqli_query($link,$updae_moq_qry) or exit("Whille inserting recut to moq".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        }
                                    }
                                    $update_rejection_log_child = "update $bai_pro3.rejection_log_child set recut_qty = recut_qty+$to_add where bcd_id = $bcd_act_id";
                                    // echo $update_rejection_log_child."<br>";
                                    mysqli_query($link,$update_rejection_log_child) or exit("While updating rejection log child".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $to_add_mo += $to_add;
                                    $update_rejection_log = "update $bai_pro3.rejections_log set recut_qty = recut_qty+$to_add,remaining_qty = remaining_qty - $to_add where style = '$style' and schedule = '$schedule' and color = '$color'";
                                    // echo $update_rejection_log."<br>";

                                    mysqli_query($link,$update_rejection_log) or exit("While updating rejection log".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    
                                    // echo $to_add_mo."<br>";
                                    // echo $bcd_act_id."<br>";
                                    $mo_changes11 = mofillingforrecutreplace($to_add_mo,$bcd_act_id);
                                }
                                $update_lay_plan_recut_track = "update $bai_pro3.lay_plan_recut_track set recut_allocated_qty = recut_allocated_qty+$to_add,remaining_qty = remaining_qty-$to_add  where bcd_id = $bcd_act_id and cat_ref=$cat_ref and id in ($idsss)";
                                // echo $update_lay_plan_recut_track."<br>";
                                mysqli_query($link,$update_lay_plan_recut_track) or exit("While updating lay_plan_recut_track".mysqli_error($GLOBALS["___mysqli_ston"]));
                            }
                        }
                    
                }

            }       
                
            //// For back Redirection
            $sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\"";
            $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            $sql_num_check=mysqli_num_rows($sql_result);
        
            while($sql_row=mysqli_fetch_array($sql_result))
            {
                $color=$sql_row['order_col_des'];
                $style=$sql_row['order_style_no'];
                $schedule=$sql_row['order_del_no'];
            }
            $codes='2';
            $status='';
            $module=0;
        
        
            $qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.recut_v2 WHERE doc_no = '$docket_no' ";
            $result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
            while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
            {
                for ($i=0; $i < sizeof($sizes_array); $i++)
                { 
                    if ($row['a_'.$sizes_array[$i]] > 0)
                    {
                        $cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]] * $row['a_plies'];
                        $size[] = $sizes_array[$i];
                    }
                }
            }
            for($j=0;$j<sizeof($size);$j++)
            {
        
                $qty_act = $cut_done_qty[$size[$j]];
                $sql1234="insert into $bai_pro3.bai_qms_db (qms_style,qms_schedule,qms_color,log_date,qms_size,qms_qty,qms_tran_type,remarks) values (\"$style\",\"$schedule\",\"$color\",\"".date("Y-m-d")."\",\"".$size[$j]."\",".($qty_act).",9,\"$module-".$docket_no."\")";
                mysqli_query($link, $sql1234) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
                // echo $sql1234."bai_qms_db<br/>";
                
            }
            $hostname=explode(".",gethostbyaddr($_SERVER['REMOTE_ADDR']));
            $sql4312="insert into $bai_pro3.recut_track(doc_no,username,sys_name,log_time,level,status) values(\"".$docket_no."\",\"".$username."\",\"".$hostname[0]."\",\"".date("Y-m-d H:i:s")."\",\"".$codes."\",\"".$status."\")";
            // echo $sql4312."recut_track<br/>";
            mysqli_query($link, $sql4312) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        }
    }
    //To get Encoded Color & style
    $main_style = style_encode($style);
    $main_color = color_encode($color);
    
    echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
        function Redirect() {
            sweetAlert('Successfully Generated','','success');
            location.href = \"".getFullURLLevel($_GET['r'], "recut_lay_plan.php", "0", "N")."&color=$main_color&style=$main_style&schedule=$schedule&serial_no=$serial_no\";
            }
        </script>";
   

}
else
{
    $sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\"";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);

	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$color=$sql_row['order_col_des'];
		$style=$sql_row['order_style_no'];
		$schedule=$sql_row['order_del_no'];
	}
    //To get Encoded Color & style
    $main_style = style_encode($style);
    $main_color = color_encode($color);
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
		function Redirect() {
			sweetAlert('Dockets Already Generated','','warning');
			location.href = \"".getFullURLLevel($_GET['r'], "recut_lay_plan.php", "0", "N")."&color=$main_color&style=$main_style&schedule=$schedule\";
			}
		</script>";
}
((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res);
?>
</div>
</div>

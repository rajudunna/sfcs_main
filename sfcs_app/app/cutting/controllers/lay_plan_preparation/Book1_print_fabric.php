
<?php 
//ob_start(); 
?> 

<?php include('../../../../common/config/config.php'); ?>
<?php include('../../../../common/config/functions.php'); ?> 
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>

<?php 

    $order_tid=$_GET['order_tid'];  
    $cat_ref=$_GET['cat_ref']; 
    $cat_new = $_GET['category_new']; 
    $clubbing = $_GET['clubbing']; 
    //Excess Cut Qty
    $excess_cut_qty = $_GET['excess_cut'];
    //first table
    $divide1=20;
    //second table
    $divide = 15;

    $sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql_num_check=mysqli_num_rows($sql_result);
    while($sql_row=mysqli_fetch_array($sql_result))
    {
        $style=$sql_row['order_style_no']; //Style
        $color=$sql_row['order_col_des']; //color
        $division=$sql_row['order_div'];
        $delivery=$sql_row['order_del_no']; //Schedule
        $pono=$sql_row['order_po_no']; //po
        $color_code=$sql_row['color_code']; //Color Code
        $orderno=$sql_row['order_no']; 
        $o_s01=$sql_row['order_s_s01'];
        $o_s02=$sql_row['order_s_s02'];
        $o_s03=$sql_row['order_s_s03'];
        $o_s04=$sql_row['order_s_s04'];
        $o_s05=$sql_row['order_s_s05'];
        $o_s06=$sql_row['order_s_s06'];
        $o_s07=$sql_row['order_s_s07'];
        $o_s08=$sql_row['order_s_s08'];
        $o_s09=$sql_row['order_s_s09'];
        $o_s10=$sql_row['order_s_s10'];
        $o_s11=$sql_row['order_s_s11'];
        $o_s12=$sql_row['order_s_s12'];
        $o_s13=$sql_row['order_s_s13'];
        $o_s14=$sql_row['order_s_s14'];
        $o_s15=$sql_row['order_s_s15'];
        $o_s16=$sql_row['order_s_s16'];
        $o_s17=$sql_row['order_s_s17'];
        $o_s18=$sql_row['order_s_s18'];
        $o_s19=$sql_row['order_s_s19'];
        $o_s20=$sql_row['order_s_s20'];
        $o_s21=$sql_row['order_s_s21'];
        $o_s22=$sql_row['order_s_s22'];
        $o_s23=$sql_row['order_s_s23'];
        $o_s24=$sql_row['order_s_s24'];
        $o_s25=$sql_row['order_s_s25'];
        $o_s26=$sql_row['order_s_s26'];
        $o_s27=$sql_row['order_s_s27'];
        $o_s28=$sql_row['order_s_s28'];
        $o_s29=$sql_row['order_s_s29'];
        $o_s30=$sql_row['order_s_s30'];
        $o_s31=$sql_row['order_s_s31'];
        $o_s32=$sql_row['order_s_s32'];
        $o_s33=$sql_row['order_s_s33'];
        $o_s34=$sql_row['order_s_s34'];
        $o_s35=$sql_row['order_s_s35'];
        $o_s36=$sql_row['order_s_s36'];
        $o_s37=$sql_row['order_s_s37'];
        $o_s38=$sql_row['order_s_s38'];
        $o_s39=$sql_row['order_s_s39'];
        $o_s40=$sql_row['order_s_s40'];
        $o_s41=$sql_row['order_s_s41'];
        $o_s42=$sql_row['order_s_s42'];
        $o_s43=$sql_row['order_s_s43'];
        $o_s44=$sql_row['order_s_s44'];
        $o_s45=$sql_row['order_s_s45'];
        $o_s46=$sql_row['order_s_s46'];
        $o_s47=$sql_row['order_s_s47'];
        $o_s48=$sql_row['order_s_s48'];
        $o_s49=$sql_row['order_s_s49'];
        $o_s50=$sql_row['order_s_s50'];

        $order_total=$o_s01+$o_s02+$o_s03+$o_s04+$o_s05+$o_s06+$o_s07+$o_s08+$o_s09+$o_s10+$o_s11+$o_s12+$o_s13+$o_s14+$o_s15+$o_s16+$o_s17+$o_s18+$o_s19+$o_s20+$o_s21+$o_s22+$o_s23+$o_s24+$o_s25+$o_s26+$o_s27+$o_s28+$o_s29+$o_s30+$o_s31+$o_s32+$o_s33+$o_s34+$o_s35+$o_s36+$o_s37+$o_s38+$o_s39+$o_s40+$o_s41+$o_s42+$o_s43+$o_s44+$o_s45+$o_s46+$o_s47+$o_s48+$o_s49+$o_s50;

            for($s=0;$s<sizeof($sizes_code);$s++)
            {
                $o_s[$sizes_code[$s]]=$sql_row["order_s_s".$sizes_code[$s].""];
            }
            for($s=0;$s<sizeof($sizes_code);$s++)
            {
                if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
                {
                    $s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
                }
            }
        }
?> 

<?php 
   
    $sql="select COALESCE(binding_consumption,0) as \"binding_consumption\" from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and tid=$cat_ref";
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row=mysqli_fetch_array($sql_result)) 
    { 
        $binding_consumption = $sql_row['binding_consumption'];
    } 
     
    // embellishment start 
    $sql="select order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\""; 
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row=mysqli_fetch_array($sql_result)) 
    { 
    $emb_a=$sql_row['order_embl_a']; 
    $emb_b=$sql_row['order_embl_b']; 
    $emb_c=$sql_row['order_embl_c']; 
    $emb_d=$sql_row['order_embl_d']; 
    $emb_e=$sql_row['order_embl_e']; 
    $emb_f=$sql_row['order_embl_f']; 
    } 

    // embellishment end 
     
    $sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\""; 
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    $sql_num_confirm=mysqli_num_rows($sql_result); 

    if($sql_num_confirm>0) 
    { 
        $sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\""; 
    } 
    else 
    { 
        $sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\""; 
    } 
    $o_s=array(); 
    $old_s=array(); 
    $size=array(); 
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row=mysqli_fetch_array($sql_result)) 
    { 
        $style=$sql_row['order_style_no']; //Style 
        $color=$sql_row['order_col_des']; //color 
        $division=$sql_row['order_div']; 
        $delivery=$sql_row['order_del_no']; //Schedule 
        $pono=$sql_row['order_po_no']; //po 
        $color_code=$sql_row['color_code']; //Color Code 
        $orderno=$sql_row['order_no'];  
        $order_amend=$sql_row['order_no']; 
        $cono=$sql_row['co_no']; 
        
        for($s=0;$s<sizeof($sizes_array);$s++) 
        { 

        $o_s[$s]=$sql_row["order_s_".$sizes_array[$s].""]; 
        } 


        $order_total = array_sum($o_s); 
        if($orderno=="1") 
        { 
        
        for($s=0;$s<sizeof($sizes_array);$s++) 
        { 
        $old_s[$s]=$sql_row["old_order_s_".$sizes_array[$s].""]; 
        } 

        $old_order_total = array_sum($old_s); 
        } 
        else 
        { 
        
        for($s=0;$s<sizeof($sizes_array);$s++) 
        { 
        
        $old_s[$s]=$sql_row["old_order_s_".$sizes_array[$s].""]; 
        } 

        $old_order_total = array_sum($old_s); 
        } 
        
        for($s=0;$s<sizeof($sizes_array);$s++) 
        { 
        if($sql_row["title_size_".$sizes_array[$s].""]<>'') 
        { 
            $s_tit[$sizes_code[$s]]=$sql_row["title_size_".$sizes_array[$s].""]; 
        } 
        }     

        $flag = $sql_row['title_flag']; 
        
        $order_date=$sql_row['order_date']; 
        $order_joins=$sql_row['order_joins']; 
    } 

    $join_s08=0; 
    $join_s10=0; 
    $join_schedule=""; 
    $join_check=0; 
    if($order_joins!="0") 
    { 
        $sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_joins\""; 
        mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_row=mysqli_fetch_array($sql_result)) 
        { 
        $join_s08=$sql_row['order_s_s08']; 
        $join_s10=$sql_row['order_s_s10']; 
        $join_schedule=$sql_row['order_del_no'].chr($sql_row['color_code']); 
        } 
        $join_check=1; 
    } 

     
    $sql="select * from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and tid=$cat_ref"; 
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    $sql_num_=mysqli_num_rows($sql_result); 
    while($sql_row=mysqli_fetch_array($sql_result)) 
    { 
        $cid=$sql_row['tid']; 
        $category=$sql_row['category']; 
        $gmtway=$sql_row['gmtway']; 
        $fab_des=$sql_row['fab_des']; 
        $body_yy=$sql_row['catyy']; 
        $waist_yy=$sql_row['Waist_yy']; 
        $leg_yy=$sql_row['Leg_yy']; 
        $purwidth=$sql_row['purwidth']; 
        $compo_no=$sql_row['compo_no']; 
        $strip_match=$sql_row['strip_match']; 
        $gusset_sep=$sql_row['gusset_sep']; 
        $patt_ver=$sql_row['patt_ver']; 
        $col_des=$sql_row['col_des']; 
    } 

    $sql="select * from $bai_pro3.cuttable_stat_log where cat_id=$cid and order_tid=\"$order_tid\""; 
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row=mysqli_fetch_array($sql_result)) 
    { 
        $excess=$sql_row['cuttable_percent']; 
    } 

    $sql="select sum(allocate_s01*plies) as \"cuttable_s_s01\",sum(allocate_s02*plies) as \"cuttable_s_s02\",sum(allocate_s03*plies) as \"cuttable_s_s03\",sum(allocate_s04*plies) as \"cuttable_s_s04\",sum(allocate_s05*plies) as \"cuttable_s_s05\",sum(allocate_s06*plies) as \"cuttable_s_s06\",sum(allocate_s07*plies) as \"cuttable_s_s07\",sum(allocate_s08*plies) as \"cuttable_s_s08\",sum(allocate_s09*plies) as \"cuttable_s_s09\",sum(allocate_s10*plies) as \"cuttable_s_s10\",sum(allocate_s11*plies) as \"cuttable_s_s11\",sum(allocate_s12*plies) as \"cuttable_s_s12\",sum(allocate_s13*plies) as \"cuttable_s_s13\",sum(allocate_s14*plies) as \"cuttable_s_s14\",sum(allocate_s15*plies) as \"cuttable_s_s15\",sum(allocate_s16*plies) as \"cuttable_s_s16\",sum(allocate_s17*plies) as \"cuttable_s_s17\",sum(allocate_s18*plies) as \"cuttable_s_s18\",sum(allocate_s19*plies) as \"cuttable_s_s19\",sum(allocate_s20*plies) as \"cuttable_s_s20\",sum(allocate_s21*plies) as \"cuttable_s_s21\",sum(allocate_s22*plies) as \"cuttable_s_s22\",sum(allocate_s23*plies) as \"cuttable_s_s23\",sum(allocate_s24*plies) as \"cuttable_s_s24\",sum(allocate_s25*plies) as \"cuttable_s_s25\",sum(allocate_s26*plies) as \"cuttable_s_s26\",sum(allocate_s27*plies) as \"cuttable_s_s27\",sum(allocate_s28*plies) as \"cuttable_s_s28\",sum(allocate_s29*plies) as \"cuttable_s_s29\",sum(allocate_s30*plies) as \"cuttable_s_s30\",sum(allocate_s31*plies) as \"cuttable_s_s31\",sum(allocate_s32*plies) as \"cuttable_s_s32\",sum(allocate_s33*plies) as \"cuttable_s_s33\",sum(allocate_s34*plies) as \"cuttable_s_s34\",sum(allocate_s35*plies) as \"cuttable_s_s35\",sum(allocate_s36*plies) as \"cuttable_s_s36\",sum(allocate_s37*plies) as \"cuttable_s_s37\",sum(allocate_s38*plies) as \"cuttable_s_s38\",sum(allocate_s39*plies) as \"cuttable_s_s39\",sum(allocate_s40*plies) as \"cuttable_s_s40\",sum(allocate_s41*plies) as \"cuttable_s_s41\",sum(allocate_s42*plies) as \"cuttable_s_s42\",sum(allocate_s43*plies) as \"cuttable_s_s43\",sum(allocate_s44*plies) as \"cuttable_s_s44\",sum(allocate_s45*plies) as \"cuttable_s_s45\",sum(allocate_s46*plies) as \"cuttable_s_s46\",sum(allocate_s47*plies) as \"cuttable_s_s47\",sum(allocate_s48*plies) as \"cuttable_s_s48\",sum(allocate_s49*plies) as \"cuttable_s_s49\",sum(allocate_s50*plies) as \"cuttable_s_s50\" from $bai_pro3.allocate_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and recut_lay_plan='no'";
    $c_s=array(); 
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row=mysqli_fetch_array($sql_result)) 
    { 
        
        for($s=0;$s<sizeof($sizes_code);$s++) 
        { 
        if($sql_row["cuttable_s_s".$sizes_code[$s].""]>0) 
        { 
        $c_s[$s]=$sql_row["cuttable_s_s".$sizes_code[$s].""]; 
        } 
        } 

        $cuttable_total = array_sum($c_s); 
    } 


    $newyy=0; 
    $new_order_qty=0; 
    $sql2="select mk_ref,p_plies,cat_ref,allocate_ref from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref  and allocate_ref>0"; 
    mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row2=mysqli_fetch_array($sql_result2)) 
    { 
     
    $new_plies=$sql_row2['p_plies']; 
    $mk_ref=$sql_row2['mk_ref']; 
    //$sql22="select mklength from maker_stat_log where tid=$mk_ref"; 
    $sql22="select marker_length as mklength from $bai_pro3.marker_ref_matrix where marker_width=$purwidth and cat_ref=".$sql_row2['cat_ref']." and allocate_ref=".$sql_row2['allocate_ref']; 
    //echo $sql22; 
    mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    $sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row22=mysqli_fetch_array($sql_result22)) 
    { 
    $mk_new_length=$sql_row22['mklength']; 
    } 
    $newyy=$newyy+($mk_new_length*$new_plies); 
    } 
     
    $sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\""; 
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    $sql_num_confirm=mysqli_num_rows($sql_result); 
     
    if($sql_num_confirm>0) 
    { 
    $sql2="select (order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50) as \"sum\" from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\""; 
    } 
    else 
    { 
    $sql2="select (order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50) as \"sum\" from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\""; 
    } 
    mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row2=mysqli_fetch_array($sql_result2)) 
    { 
    $new_order_qty=$sql_row2['sum']; 
    } 
     

    if($orderno=="1") 
    { 
     
    $newyy2=$old_order_total>0 ? $newyy/$old_order_total : 0; 
    } 
    else 
    { 
     
    $newyy2=$new_order_qty>0 ? $newyy/$new_order_qty : 0; 
    } 
     
     
     
    $savings_new=round((($body_yy-$newyy2)/$body_yy)*100,1); 

?> 

<html xmlns:o="urn:schemas-microsoft-com:office:office" 
xmlns:x="urn:schemas-microsoft-com:office:excel" 
xmlns="http://www.w3.org/TR/REC-html40"> 

    <head> 

        <title>CUT PLAN VIEW</title> 
        <meta http-equiv=Content-Type content="text/html; charset=windows-1252"> 
        <meta name=ProgId content=Excel.Sheet> 
        <meta name=Generator content="Microsoft Excel 14"> 
        <link rel=File-List href="CUT_PLAN_NEW_files/filelist.xml"> 
        <style id="CUT_PLAN_NEW_13019_Styles"> 
            <!--table 
                {mso-displayed-decimal-separator:"\."; 
                mso-displayed-thousand-separator:"\,";} 
            .xl6513019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:general; 
            vertical-align:bottom; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl6613019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:bottom; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl6713019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:right; 
            vertical-align:bottom; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl6813019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:700; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:bottom; 
            border:.5pt solid windowtext; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl6913019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:bottom; 
            border-top:.5pt solid windowtext; 
            border-right:.5pt solid windowtext; 
            border-bottom:.5pt solid windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl6913019a 
            {padding-top:2px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            height:35pt;
            width:120pt;
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:bottom; 
            border-top:.5pt solid windowtext; 
            border-right:.5pt solid windowtext; 
            border-bottom:.5pt solid windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl6913019b 
            {padding-top:2px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            height:35pt;
            width:120pt;
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:bottom; 
            border-top:.5pt solid windowtext; 
            border-right:.5pt solid windowtext; 
            border-bottom:.5pt solid windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl7013019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:700; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:bottom; 
            border-top:.5pt solid windowtext; 
            border-right:.5pt solid windowtext; 
            border-bottom:.5pt solid windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl7113019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:700; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:bottom; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl7213019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:8.0pt; 
            font-weight:700; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:general; 
            vertical-align:bottom; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:normal;} 
            .xl7313019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:0; 
            text-align:general; 
            vertical-align:bottom; 
            border-top:none; 
            border-right:.5pt solid windowtext; 
            border-bottom:.5pt solid windowtext; 
            border-left:.5pt solid windowtext; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl7413019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:Arial, sans-serif; 
            mso-font-charset:0; 
            mso-number-format:0; 
            text-align:general; 
            vertical-align:bottom; 
            border-top:none; 
            border-right:.5pt solid windowtext; 
            border-bottom:.5pt solid windowtext; 
            border-left:.5pt solid windowtext; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl7513019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:Arial, sans-serif; 
            mso-font-charset:0; 
            mso-number-format:0; 
            text-align:general; 
            vertical-align:bottom; 
            border-top:none; 
            border-right:.5pt solid windowtext; 
            border-bottom:.5pt solid windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl7613019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:bottom; 
            border-top:none; 
            border-right:.5pt solid windowtext; 
            border-bottom:.5pt solid windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl7713019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:"\#\,\#\#0"; 
            text-align:center; 
            vertical-align:bottom; 
            border-top:none; 
            border-right:.5pt solid windowtext; 
            border-bottom:.5pt solid windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl7813019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:"\#\,\#\#0"; 
            text-align:center; 
            vertical-align:bottom; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl7913019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:8.0pt; 
            font-weight:700; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:left; 
            vertical-align:middle; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:normal;} 
            .xl8013019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:0; 
            text-align:center; 
            vertical-align:middle; 
            border:.5pt solid windowtext; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl8113019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:0; 
            text-align:center; 
            vertical-align:middle; 
            border-top:.5pt solid windowtext; 
            border-right:.5pt solid windowtext; 
            border-bottom:.5pt solid windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl8213019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:0; 
            text-align:center; 
            vertical-align:middle; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl8313019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:bottom; 
            background:white; 
            mso-pattern:black none; 
            white-space:nowrap;} 
            .xl8413019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:700; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:bottom; 
            border-top:none; 
            border-right:.5pt solid windowtext; 
            border-bottom:.5pt solid windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl8513019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:general; 
            vertical-align:bottom; 
            background:white; 
            mso-pattern:black none; 
            white-space:nowrap;} 
            .xl8613019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:middle; 
            border-top:none; 
            border-right:.5pt solid windowtext; 
            border-bottom:.5pt solid windowtext; 
            border-left:.5pt solid windowtext; 
            background:white; 
            mso-pattern:black none; 
            white-space:nowrap;} 
            .xl8713019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:middle; 
            border-top:none; 
            border-right:.5pt solid windowtext; 
            border-bottom:.5pt solid windowtext; 
            
            background:white; 
            mso-pattern:black none; 
            white-space:nowrap;} 
            .xl8813019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:bottom; 
            border-top:none; 
            border-right:none; 
            border-bottom:.5pt hairline windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl8913019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:bottom; 
            border-top:none; 
            border-right:.5pt solid windowtext; 
            border-bottom:.5pt solid windowtext; 
            border-left:.5pt solid windowtext; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl9013019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:middle; 
            border-top:none; 
            border-right:.5pt solid windowtext; 
            border-bottom:2.0pt double windowtext; 
            border-left:none; 
            background:white; 
            mso-pattern:black none; 
            white-space:nowrap;} 
            .xl9113019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:0%; 
            text-align:center; 
            vertical-align:bottom; 
            border-top:none; 
            border-right:none; 
            border-bottom:2.0pt double windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl9213019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:middle; 
            border-top:.5pt solid windowtext; 
            border-right:.5pt solid windowtext; 
            border-bottom:.5pt solid windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl9313019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:general; 
            vertical-align:bottom; 
            border-top:none; 
            border-right:.5pt solid windowtext; 
            border-bottom:.5pt solid windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl9413019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:black; 
            font-size:10.0pt; 
            font-weight:700; 
            font-style:normal; 
            text-decoration:none; 
            font-family:Arial, sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:bottom; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl9513019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:14.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:underline; 
            text-underline-style:single; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:middle; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl9613019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:left; 
            vertical-align:bottom; 
            border-top:none; 
            border-right:none; 
            border-bottom:.5pt solid windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl9713019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:left; 
            vertical-align:bottom; 
            border-top:.5pt solid windowtext; 
            border-right:none; 
            border-bottom:.5pt solid windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl9813019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:700; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:right; 
            vertical-align:bottom; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl9913019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:700; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:right; 
            vertical-align:bottom; 
            border-top:none; 
            border-right:.5pt solid black; 
            border-bottom:none; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl10013019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:700; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:middle; 
            border-top:.5pt solid windowtext; 
            border-right:.5pt solid windowtext; 
            border-bottom:none; 
            border-left:.5pt solid windowtext; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl10113019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:700; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:middle; 
            border-top:none; 
            border-right:.5pt solid windowtext; 
            border-bottom:.5pt solid black; 
            border-left:.5pt solid windowtext; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl10213019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:700; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:bottom; 
            border-top:.5pt solid windowtext; 
            border-right:none; 
            border-bottom:.5pt solid windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl10313019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:700; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:bottom; 
            border-top:.5pt solid windowtext; 
            border-right:none; 
            border-bottom:.5pt solid windowtext; 
            border-left:.5pt solid windowtext; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl10413019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:700; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:bottom; 
            border-top:.5pt solid windowtext; 
            border-right:.5pt solid black; 
            border-bottom:.5pt solid windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl10513019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:700; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:middle; 
            border-top:.5pt solid windowtext; 
            border-right:.5pt solid windowtext; 
            border-bottom:none; 
            border-left:.5pt solid windowtext; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:normal;} 
            .xl10613019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:700; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:middle; 
            border-top:none; 
            border-right:.5pt solid windowtext; 
            border-bottom:.5pt solid black; 
            border-left:.5pt solid windowtext; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:normal;} 
            .xl10713019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:middle; 
            border-top:.5pt solid windowtext; 
            border-right:none; 
            border-bottom:.5pt solid windowtext; 
            border-left:.5pt solid windowtext; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl10813019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:middle; 
            border-top:.5pt solid windowtext; 
            border-right:.5pt solid black; 
            border-bottom:.5pt solid windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl10913019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:middle; 
            border-top:.5pt solid windowtext; 
            border-right:none; 
            border-bottom:.5pt solid windowtext; 
            border-left:.5pt solid black; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl11013019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:bottom; 
            border-top:.5pt solid windowtext; 
            border-right:none; 
            border-bottom:.5pt solid windowtext; 
            border-left:.5pt solid windowtext; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl11113019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:bottom; 
            border-top:.5pt solid windowtext; 
            border-right:.5pt solid black; 
            border-bottom:.5pt solid windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl11213019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:center; 
            vertical-align:bottom; 
            border-top:.5pt solid windowtext; 
            border-right:none; 
            border-bottom:.5pt solid windowtext; 
            border-left:.5pt solid black; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl11313019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:400; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:general; 
            vertical-align:bottom; 
            border:.5pt solid windowtext; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl11413019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:700; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:general; 
            vertical-align:bottom; 
            border-top:.5pt solid windowtext; 
            border-right:none; 
            border-bottom:.5pt solid windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl11513019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:700; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:general; 
            vertical-align:bottom; 
            border-top:.5pt solid windowtext; 
            border-right:none; 
            border-bottom:.5pt solid windowtext; 
            border-left:.5pt solid black; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            .xl11613019 
            {padding-top:1px; 
            padding-right:1px; 
            padding-left:1px; 
            mso-ignore:padding; 
            color:windowtext; 
            font-size:10.0pt; 
            font-weight:700; 
            font-style:normal; 
            text-decoration:none; 
            font-family:"Trebuchet MS", sans-serif; 
            mso-font-charset:0; 
            mso-number-format:General; 
            text-align:general; 
            vertical-align:bottom; 
            border-top:.5pt solid windowtext; 
            border-right:.5pt solid black; 
            border-bottom:.5pt solid windowtext; 
            border-left:none; 
            mso-background-source:auto; 
            mso-pattern:auto; 
            white-space:nowrap;} 
            --> 
            body{ 
                zoom:80%; 
            } 

        </style> 

        <style type="text/css">
            @page
            {
                size: landscape;
                margin: 0cm;
            }
        </style>

        <style>

            @media print {
            @page { margin: 0; }
            @page narrow {size: 9in 11in}
            @page rotated {size: landscape}
            DIV {page: narrow}
            TABLE {page: rotated}
            #non-printable { display: none; }
            #printable { display: block; }
            #logo { display: block; }
            body { zoom:63%;}
            #ad{ display:none;}
            #leftbar{ display:none;}
            #CUT_PLAN_NEW_13019{ width:57%; margin-left:20px;}
            }
        </style>

        <script>

            function printpr()
            {
                var OLECMDID = 7;
                /* OLECMDID values:
                * 6 - print
                * 7 - print preview
                * 1 - open window
                * 4 - Save As
                */
                document.getElementById('button_print').style.display = 'none';
                var PROMPT = 1; // 2 DONTPROMPTUSER
                var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
                document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
                //WebBrowser1.ExecWB(OLECMDID, PROMPT);
                //WebBrowser1.outerHTML = "";
                window.print();
                document.getElementById('button_print').style.display = 'inline';
            }

        </script>

    </head> 

    <body onload="printpr();"> 

        <input type="button" class='col-sm-1 btn btn-warning' id='button_print' onclick='printpr()' value='Print'>
    
<div id="CUT_PLAN_NEW_13019" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=1757 style="border-collapse: collapse;width:1000px"> 
 <td colspan=6 rowspan=3 class=xl8217319x valign="top" align="left"><img src="/sfcs_app/common/images/logo.png" width="200" height="60"></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7832599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl1532599></td>
 </tr>
 <tr class=xl6513019 height=20 style='mso-height-source:userset;height:10.0pt'> 
  <td height=20 class=xl6513019 style='height:10.0pt'></td> 
  <td colspan=8 rowspan=3 class=xl6613019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6713019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
 </tr> 
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6432599></td>
</tr>
 <tr class=xl6513019 height=20 style='mso-height-source:userset;height:10.0pt'> 
  <td height=20 class=xl6513019 style='height:10.0pt'></td> 
  <td class=xl6513019></td> 
  <td colspan=1 class=xl9813019 style='border-right:.5pt solid black'>File No</td> 
  <td class=xl6913019a></td>
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td colspan=9 class=xl9813019 style='border-right:.5pt solid black'>Verified By </td> 
  <td class=xl6913019b></td>
  <td class=xl6713019></td> 
 </tr> 
 <tr class=xl6513019 height=20 style='mso-height-source:userset;height:10.0pt'> 
  <td height=20 class=xl6513019 style='height:10.0pt'></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6713019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
 </tr> 
 <tr class=xl6513019 height=9 style='mso-height-source:userset;height:6.75pt'> 
  <td height=9 class=xl6513019 style='height:6.75pt'></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6713019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
 </tr> 
 <tr class=xl6513019 height=33 style='mso-height-source:userset;height:24.75pt'> 
  <td height=33 class=xl6513019 style='height:24.75pt'></td> 
  <td colspan=27 class=xl9513019 style='font-size:28px'>Fabric Docket Issue Plan<span style='mso-spacerun:yes'></span></td> 
  <td class=xl6513019></td> 
 </tr> 

 <tr height=60></tr>


 <tr class=xl6513019 height=20 style='mso-height-source:userset;height:10.0pt'> 
  <td height=30 class=xl6513019 style='height:30pt'></td> 
  <td class=xl6713019>Style : </td> 
  <td colspan=6 class=xl9613019><?php echo $style; ?></td> 
  <!-- <td class=xl6613019></td>  -->
  <td colspan=1 class=xl6713019>Category : </td> 
  <td colspan=10 class=xl9613019><?php echo $category; ?></td> 
  <td class=xl6513019></td> 
 
  <td colspan=2 class=xl6713019>Date : </td> 
  <td colspan=3 class=xl9613019><?php echo $order_date; ?></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6713019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
 </tr> 
 
 <tr class=xl6513019 height=30 style='mso-height-source:userset;height:30pt'> 
  <td height=20 class=xl6513019 style='height:10.0pt'></td> 
  <td class=xl6713019>Sch No : </td> 
  <td colspan=6 class=xl9713019><?php echo $delivery.chr($color_code); ?></td> 
  <!-- <td class=xl6613019></td>  -->
  <td colspan=1 class=xl6713019>Fab Description : </td> 
  <td colspan=10 class=xl9713019><?php echo $fab_des; ?></td> 
  <td class=xl6513019></td> 

  <td colspan=2 class=xl6713019>PO / CO : </td> 
  <td colspan=3 class=xl9713019><?php echo $pono."/".$cono; ?></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6713019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
 </tr> 
 <tr class=xl6513019 height=30 style='mso-height-source:userset;height:30pt'> 
  <td height=20 class=xl6513019 style='height:10.0pt'></td> 
  <!-- 
  <td class=xl6713019>Color :</td> 
  <td colspan=3 class=xl9713019><?php echo $color." / ".$col_des; ?></td> 
  <td class=xl6613019></td> 
  <td colspan=3 class=xl6713019><span style='mso-spacerun:yes'></span>Fab 
  Code:</td> 
  --> 
  <td class=xl6713019>Color :</td> 
  <td colspan=6 class=xl9713019><?php echo $color." / ".$col_des; ?></td> 
  <td colspan=1 class=xl6713019><span style='mso-spacerun:yes'>Fab</span> 
  Code : </td> 
  <td colspan=10 class=xl9713019><?php echo $compo_no; ?></td> 
  <td class=xl6513019></td> 

  <td colspan=2 class=xl6713019>Assortment:</td> 
  <td colspan=3 class=xl9713019>&nbsp;</td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
  <td class=xl6713019></td> 
  <td class=xl6513019></td> 
  <td class=xl6513019></td> 
 </tr> 
<tr height=40></tr>
<tr class=xl6513019 height=11 style='mso-height-source:userset;height:8.25pt'> 
  <td height=11 class=xl6513019 style='height:8.25pt'></td> 
  <?php for($i=0;$i<32;$i++) echo "<td class=xl6613019></td>"; ?> 
 </tr> 
 <tr class=xl6513019 height=11 style='mso-height-source:userset;height:8.25pt'> 
  <td height=11 class=xl6513019 style='height:8.25pt'></td> 
  <?php for($i=0;$i<32;$i++) echo "<td class=xl6613019></td>"; ?> 
 </tr> 
 
        <!-- middle body code --> 
        <tr> 
            <td class=xl6613019></td> 
            <td class=xl6513019></td> 
            <td class=xl6613019></td> 
            <td colspan=2  class=xl6813019><?php echo $category; ?></td> 
            <td class=xl6613019></td> 
            <!-- <td class=xl6613019></td>  -->
            <td colspan=3 class=xl9813019 style='border-right:.5pt solid black'>Savings %</td> 
            <td colspan=2  class=xl7013019><?php echo $savings_new; ?>%</td> 
            <td class=xl6613019></td> 
            <!-- <td class=xl6613019></td>  -->
            <td colspan=3 class=xl9813019 style='border-right:.5pt solid black'>One Gmt 
            One Way</td> 
            <td colspan=2 class=xl6913019><?php echo $gmtway; ?></td> 
            <td colspan=2></td>
            <!-- <td colspan=2></td> -->
            <td colspan=4 class=xl9813019 style='border-right:.5pt solid black'>Binding Consumption</td> 
            <td class=xl6913019><?php echo $binding_consumption; ?></td> 
            <td class=xl6613019></td> 
        </tr> 
        <tr> 
            <td colspan=3 class=xl9813019 style='border-right:.5pt solid black'>Consumption</td> 
            <td colspan=2  class=xl7613019><?php echo $body_yy; ?></td> 
            <td class=xl6613019></td> 
            <!-- <td class=xl6613019></td>  -->
            <td colspan=3 class=xl9813019 style='border-right:.5pt solid black'>CAD 
            Consumption</td> 
            <td colspan=2 class=xl7613019><?php echo round($newyy2,4); ?></td> 
            <td class=xl6513019></td> 
            <!-- <td class=xl6613019></td>  -->
            <td colspan=3 class=xl9813019 style='border-right:.5pt solid black'>Strip 
            Matching</td> 
            <td colspan=2 class=xl7613019><?php echo $strip_match; ?></td> 
            <td class=xl6613019></td> 
            <td class=xl6513019></td> 
        </tr> 
        <tr> 
            <td colspan=3 class=xl9813019 style='border-right:.5pt solid black'>Material 
            Allowed</td> 
            <td colspan=2 class=xl7713019><?php echo round(($order_total*$body_yy),0); ?></td> 
            <td class=xl6613019></td> 
            <!-- <td class=xl6613019></td>  -->
            <td colspan=3 class=xl9813019 style='border-right:.5pt solid black'>Used 
            <?php $fab_uom ?></td> 
            <td colspan=2 class=xl7713019><?php echo round($newyy,0); ?></td> 
            <td class=xl6513019></td> 
            <!-- <td class=xl6613019></td>  -->
            <td colspan=3 class=xl9813019 style='border-right:.5pt solid black'>Gusset 
            Sep</td> 
            <td colspan=2 class=xl7713019><?php echo $gusset_sep; ?></td> 
            <td class=xl7813019></td> 
            <td class=xl6513019></td> 
        </tr> 
        <tr> 
            <?php for($i=0;$i<12;$i++) echo "<td class=xl6613019></td>"; ?> 
            <td colspan=3 class=xl9813019 style='border-right:.5pt solid black'>Pattern 
            Version</td> 
            <td colspan=2 class=xl7713019><?php echo $patt_ver; ?></td> 
            <td class=xl6613019></td> 
            <td class=xl6513019></td> 
        </tr> 

        <!-- end --> 

        <tr class=xl6513019 height=11 style='mso-height-source:userset;height:8.25pt'> 
            <td height=11 class=xl6513019 style='height:8.25pt'></td> 
            <?php for($i=0;$i<32;$i++) echo "<td class=xl6613019></td>"; ?> 
        </tr> 

        <tr class=xl6513019 height=11 style='mso-height-source:userset;height:8.25pt'> 
            <td height=11 class=xl6513019 style='height:8.25pt'></td> 
            <?php for($i=0;$i<32;$i++) echo "<td class=xl6613019></td>"; ?> 
        </tr> 


        <tr height=23 style='mso-height-source:userset;height:17.25pt'><td></td></tr>
            
        <?php 
            //echo "Test---".sizeof($c_s)."<br>"; 
            if(sizeof($s_tit)<20) 
            { 

        ?> 

        <tr class=xl6613019 height=23 style='mso-height-source:userset;height:17.25pt'> 
            <td height=23 class=xl6613019 style='height:17.25pt'></td> 
            <td  colspan=2 class=xl6613019></td> 
                        <?php 
                        
                            for($s=0;$s<sizeof($s_tit);$s++) 
                            { 
                                echo "<td class=xl6813019>".$s_tit[$sizes_code[$s]]."</td>"; 
                            } 
                            
                        ?> 
            <td class=xl7013019>Total</td> 
        </tr> 

        <?php 
            //Getting sample details here  By SK-05-07-2018 == Start
            $samples_qry="select * from $bai_pro3.sp_sample_order_db where order_tid='$order_tid' order by sizes_ref";
            $samples_qry_result=mysqli_query($link, $samples_qry) or exit("Sample query details".mysqli_error($GLOBALS["___mysqli_ston"]));
            $num_rows_samples = mysqli_num_rows($samples_qry_result);
            if($num_rows_samples >0){
                $samples_total = 0;	   
        ?>
        
        <tr class=xl6513019 height=21 style='mso-height-source:userset;height:15.75pt'> 
            <td height=21 class=xl6513019 style='height:15.75pt'></td> 
            <td colspan=2 class=xl7213019 width=70 style='width:53pt'>Samples Qty<span 
            style='mso-spacerun:yes'></span></td> 
                
            <?php
                
                while($samples_data=mysqli_fetch_array($samples_qry_result))
                {
                    $samples_total+=$samples_data['input_qty'];
                    $samples_size_arry[] =$samples_data['sizes_ref'];
                    $samples_input_qty_arry[] =$samples_data['input_qty'];
                }    
                for($s=0;$s<sizeof($s_tit);$s++) 
                { 
                    $size_code = 's'.$sizes_code[$s];
                    $flg = 0;
                    for($ss=0;$ss<sizeof($samples_size_arry);$ss++)
                    {
                        if($size_code == $samples_size_arry[$ss]){
                            echo "<td class=xl7413019>".$samples_input_qty_arry[$ss]."</td>";
                            $flg = 1;
                        }			
                    }	
                    if($flg == 0){
                        echo "<td class=xl7413019><strong>-</strong></td>";
                    }      
                } 
                echo "<td class=xl7413019>".$samples_total."</td>";
                }
            ?>

        </tr>

        <tr class=xl6513019 height=21 style='mso-height-source:userset;height:5.75pt'> 
            <td height=21 class=xl6513019 style='height:15.75pt'></td> 
            <td colspan=2 class=xl7213019 width=150 style='width:53pt'>Order Qty<span 
            style='mso-spacerun:yes'></span></td> 
            <?php 
                if($order_amend=="1") 
                { 
                    for($i=0;$i<sizeof($s_tit);$i++) 
                    { 
                    if($i==0) 
                    { 
                    echo "<td class=xl7413019>".$old_s[$i]."</td>"; 
                    } 
                    else 
                    { 
                    echo "<td class=xl7513019>".$old_s[$i]."</td>"; 
                    }     
                    } 
                 
                    echo "<td class=xl7513019> $old_order_total</td>"; 
                } 
                else 
                { 
                    for($i=0;$i<sizeof($s_tit);$i++) 
                    { 
                        if($i==0) 
                        { 
                            echo "<td class=xl7413019>".$o_s[$i]."</td>"; 
                        } 
                        else 
                        { 
                            echo "<td class=xl7513019>".$o_s[$i]."</td>"; 
                        }     
                    } 
                
                    
                   
                    echo "<td class=xl7513019> $order_total</td>"; 
                } 
            ?> 
        
        </tr> 

        <tr class=xl6513019 height=21 style='mso-height-source:userset;height:15.75pt'> 
            <td height=21 class=xl6513019 style='height:15.75pt'></td> 
            
            <?php 

                if($order_amend=="1") 
                { 
                    echo "<td  colspan=2  class=xl7213019 width=150 style='width:53pt'>Extra Ship</td>"; 
                    
                    //echo "Test-2".sizeof($c_s)."<br>"; 
                    for($i=0;$i<sizeof($s_tit);$i++) 
                    { 
                    //echo $i."-".$i."--".$c_s[$i]."<br>"; 
                    echo "<td class=xl6813019 style='text-align:left'>".$o_s[$i]."</td>"; 
                    } 
                    echo "<td class=xl7513019> $order_total</td>"; 

                } 
                else 
                { 
                    echo "<td  colspan=2  class=xl7213019 width=150 style='width:53pt'>( $excess%)</td>"; 
                    //echo "Test".sizeof($c_s)."<br>"; 
                    for($i=0;$i<sizeof($s_tit);$i++) 
                    { 
                        //echo $i."-".$c_s[$i]."<br>"; 
                        echo "<td class=xl7313019>".$c_s[$i]."</td>"; 
                    } 
                    /*echo "<td class=xl7313019> $c_s06</td> 
                    <td class=xl7513019> $c_s08</td> 
                    <td class=xl7513019> $c_s10</td> 
                    <td class=xl7513019> $c_s12</td> 
                    <td class=xl7513019> $c_s14</td> 
                    <td class=xl7513019> $c_s16</td> 
                    <td class=xl7513019> $c_s18</td> 
                    <td class=xl7513019> $c_s20</td> 
                    <td class=xl7513019> $c_s22</td> 
                    <td class=xl7513019> $c_s24</td> 
                    <td class=xl7513019> $c_s26</td> 
                    <td class=xl7513019> $c_s28</td> 
                    <td class=xl7513019> $c_s30</td>";*/ 
                    echo "<td class=xl7513019> $cuttable_total</td>"; 
                } 
            ?> 
        
        </tr> 

        <tr class=xl6513019 height=20 style='mso-height-source:userset;height:10.0pt'> 
            <td height=20 class=xl6513019 style='height:10.0pt'></td> 
            <td  colspan=2 class=xl7213019 width=150 style='width:53pt'>(<?php echo "Excess ".$excess; ?>%)</td> 
            <?php  
                for($i=0;$i<sizeof($s_tit);$i++) 
                { 
                    echo "<td class=xl7313019>".($c_s[$i]-$o_s[$i])."</td>"; 
                } 
            ?> 
            <td class=xl7513019><?php echo ($cuttable_total-$order_total) ?></td> 
        </tr> 


        <?php 
            } 
            else 
            { 
                $temp_len1 = 0;
                if(sizeof($sizes_code)>13)
                {
                ?>
                <tr class=xl6613019 height=23 style='mso-height-source:userset;height:17.25pt'> 
                    <td height=23 class=xl6613019 style='height:17.25pt'></td> 
                    <td class=xl6613019></td>
                    <?php 
                        if($flag == 1) 
                        { 
                            $total_size = sizeof($s_tit);
                            for($s=0;$s<$total_size;$s++) 
                            { 
                                echo "<td class=xl6813019>".$s_tit[$sizes_code[$s]]."</td>"; 
                                if(($s+1) % $divide1 == 0){
                                    $temp_len = $s+1;
                                    echo "</tr><tr class=xl6513019 height=21 style='mso-height-source:userset;height:15.75pt'> 
                                    <td height=21 class=xl6513019 style='height:15.75pt'></td> 
                                    <td class=xl7213019 width=70 style='width:53pt'>Order Qty<span 
                                    style='mso-spacerun:yes'></span></td>";
                                    for($i=$temp_len1;$i<$temp_len;$i++){
                                        echo "<td class=xl7413019>".$o_s[$i]."</td>";
                                    }
                                    echo "</tr><tr class=xl6513019 height=21 style='mso-height-source:userset;height:15.75pt'> 
                                    <td height=21 class=xl6513019 style='height:15.75pt'></td>";
                                    if($order_amend=="1") 
                                    { 
                                        echo "<td class=xl7213019 width=70 style='width:53pt'>Extra Ship</td>"; 
                                        for($i=$temp_len1;$i<$temp_len;$i++)
                                        { 
                                            echo "<td class=xl6813019>".$o_s[$i]."</td>"; 
                                        } 
                                    } 
                                    else 
                                    { 
                                        echo "<td class=xl7213019 width=70 style='width:53pt'>( $excess%)</td>"; 
                                        for($i=$temp_len1;$i<$temp_len;$i++)
                                        { 
                                            echo "<td class=xl7313019>".$c_s[$i]."</td>"; 
                                        } 
                                    }
                                    echo "</tr>";

                                    echo "<tr class=xl6513019 height=20 style='mso-height-source:userset;height:10.0pt'> 
                                    <td height=20 class=xl6513019 style='height:10.0pt'></td> 
                                    <td class=xl7213019 width=70 style='width:53pt'>(Excess ".$excess." %)</td> ";
                                    for($i=$temp_len1;$i<$temp_len;$i++)
                                        { 
                                            echo "<td class=xl7313019>".($c_s[$i]-$o_s[$i])."</td>"; 
                                        } 
                                    echo "</tr>";
                                    echo "<tr class=xl6513019 height=12 style='mso-height-source:userset;height:9.0pt'> 
                                        <td height=12 class=xl6513019 style='height:9.0pt'></td> 
                                        <td class=xl7213019 width=70 style='width:53pt'></td> 
                                        <td class=xl6513019></td> 
                                        <td class=xl6513019></td> 
                                        <td class=xl6513019></td> 
                                        <td class=xl6513019></td> 
                                        <td class=xl6513019></td> 
                                        <td class=xl6513019></td> 
                                        <td class=xl6513019></td> 
                                        <td class=xl6513019></td> 
                                        <td class=xl6513019></td> 
                                        <td class=xl6513019></td> 
                                        <td class=xl6513019></td> 
                                        <td class=xl6513019></td> 
                                        <td class=xl6513019></td> 
                                        <td class=xl6513019></td> 
                                        <td class=xl6613019></td> 
                                        <td class=xl6613019></td> 
                                        <td class=xl6513019></td> 
                                        <td class=xl6513019></td> 
                                        <td class=xl6513019></td> 
                                        <td class=xl6613019></td> 
                                        <td class=xl6613019></td> 
                                        <td class=xl6613019></td> 
                                        <td class=xl7113019></td> 
                                        <td class=xl7113019></td> 
                                        <td class=xl6613019></td> 
                                        <td class=xl6613019></td> 
                                        <td class=xl6613019></td> 
                                        <td class=xl6613019></td> 
                                        <td class=xl6613019></td> 
                                        <td class=xl6613019></td> 
                                        <td class=xl6513019></td> 
                                        <td class=xl6513019></td> 
                                    </tr> ";
                                    echo "<tr class=xl6613019 height=23 style='mso-height-source:userset;height:17.25pt'> 
                                    <td height=23 class=xl6613019 style='height:17.25pt'></td> 
                                    <td class=xl6613019></td>";
                                    $temp_len1=$temp_len;


                                }
                                    // echo "</tr>";
                            } 
                            if($s==$total_size){
                                $temp_len = $s+1;
                                // echo $temp_len.'length';
                                echo "<td class=xl7013019>Total</td></tr><tr class=xl6513019 height=21 style='mso-height-source:userset;height:15.75pt'> 
                                <td height=21 class=xl6513019 style='height:15.75pt'></td> 
                                <td class=xl7213019 width=70 style='width:53pt'>Order Qty<span 
                                style='mso-spacerun:yes'></span></td>";
                                for($j=$temp_len1;$j<$temp_len-1;$j++){
                                    echo "<td class=xl7413019>".$o_s[$j]."</td>";
                                }
                                echo "<td class=xl7513019> $order_total</td>";
                                echo "</tr><tr class=xl6513019 height=21 style='mso-height-source:userset;height:15.75pt'> 
                                <td height=21 class=xl6513019 style='height:15.75pt'></td>";
                                if($order_amend=="1") 
                                { 
                                    echo "<td class=xl7213019 width=70 style='width:53pt'>Extra Ship</td>"; 
                                    for($j=$temp_len1;$j<$temp_len-1;$j++)
                                    { 
                                        echo "<td class=xl6813019>".$o_s[$j]."</td>"; 
                                    } 
                                } 
                                else 
                                { 
                                    echo "<td class=xl7213019 width=70 style='width:53pt'>( $excess%)</td>"; 
                                    for($j=$temp_len1;$j<$temp_len-1;$j++)
                                    { 
                                        echo "<td class=xl7313019>".$c_s[$j]."</td>"; 
                                    } 
                                }
                                echo "<td class=xl7513019> $cuttable_total</td>";
                                echo "</tr>";

                                echo "<tr class=xl6513019 height=20 style='mso-height-source:userset;height:10.0pt'> 
                                <td height=20 class=xl6513019 style='height:10.0pt'></td> 
                                <td class=xl7213019 width=70 style='width:53pt'>(Excess ".$excess." %)</td> ";
                                for($j=$temp_len1;$j<$temp_len-1;$j++)
                                    { 
                                        echo "<td class=xl7313019>".($c_s[$j]-$o_s[$j])."</td>"; 
                                    }
                                echo "<td class=xl7513019>".($cuttable_total-$order_total)."</td>";
                                echo "</tr>";
                                echo "<tr class=xl6513019 height=12 style='mso-height-source:userset;height:9.0pt'> 
                                    <td height=12 class=xl6513019 style='height:9.0pt'></td> 
                                    <td class=xl7213019 width=70 style='width:53pt'></td> 
                                    <td class=xl6513019></td> 
                                    <td class=xl6513019></td> 
                                    <td class=xl6513019></td> 
                                    <td class=xl6513019></td> 
                                    <td class=xl6513019></td> 
                                    <td class=xl6513019></td> 
                                    <td class=xl6513019></td> 
                                    <td class=xl6513019></td> 
                                    <td class=xl6513019></td> 
                                    <td class=xl6513019></td> 
                                    <td class=xl6513019></td> 
                                    <td class=xl6513019></td> 
                                    <td class=xl6513019></td> 
                                    <td class=xl6513019></td> 
                                    <td class=xl6613019></td> 
                                    <td class=xl6613019></td> 
                                    <td class=xl6513019></td> 
                                    <td class=xl6513019></td> 
                                    <td class=xl6513019></td> 
                                    <td class=xl6613019></td> 
                                    <td class=xl6613019></td> 
                                    <td class=xl6613019></td> 
                                    <td class=xl7113019></td> 
                                    <td class=xl7113019></td> 
                                    <td class=xl6613019></td> 
                                    <td class=xl6613019></td> 
                                    <td class=xl6613019></td> 
                                    <td class=xl6613019></td> 
                                    <td class=xl6613019></td> 
                                    <td class=xl6613019></td> 
                                    <td class=xl6513019></td> 
                                    <td class=xl6513019></td> 
                                </tr> ";
                                $temp_len1=$temp_len;

                            }
                        } 
                    }
                    ?> 
                </tr>
        <?php 
            } 
        ?> 

             

                    <!-- 2nd table end --> 
                        <!-- <tr class=xl6513019 height=20 style='mso-height-source:userset;height:10.0pt'> 
                        <td height=20 class=xl6513019 style='height:10.0pt'></td> 
                        <td class=xl7913019 width=70 style='width:53pt'>Floorsets</td> 
                    <td class=xl8013019>&nbsp;</td> 

                <?php 

                    if($join_check==1) 
                    { 
                        echo "<td class=xl8113019>$join_s08</td>"; 
                        echo "<td class=xl8113019 style='border-left:none'>$join_s10</td>"; 
                        echo "<td class=xl8113019 style='border-left:none'>SCH#</td>"; 
                        echo "<td class=xl8113019 style='border-left:none'>$join_schedule</td>"; 
                    } 
                    else 
                    { 
                        echo "<td class=xl8113019>&nbsp;</td>"; 
                        echo "<td class=xl8113019 style='border-left:none'>&nbsp;</td>"; 
                        echo "<td class=xl8113019 style='border-left:none'>&nbsp;</td>"; 
                        echo "<td class=xl8113019 style='border-left:none'>&nbsp;</td>"; 
                    } 
                    
                ?> 

                
                <?php 
                
                    //   if(strlen($remarks_x)>0) 
                    //   { 
                    //       echo "<td colspan='31' class=xl6513019 colspan=15 align=left><strong>Remarks: $remarks_x</strong></td>"; 
                    //   } 
                    //   else 
                    //   { 
                    //       echo "<td class='xl6513019' colspan=2 align=left></td>"; 
                    //   } 


                    if(($emb_a+$emb_b+$emb_c+$emb_d+$emb_e+$emb_f)>0)  
                    { 
                        
                        $emb_stat=0; 
                        $emb_title=""; 
                        if($emb_a>0 or $emb_b>0) 
                        { 
                        $emb_title="Panel Form"; 
                        $emb_stat=1; 
                        } 
                        if($emb_c>0 or $emb_d>0) 
                        { 
                        $emb_title="Semi Garment Form"; 
                        $emb_stat=1; 
                        } 
                        if($emb_e>0 or $emb_f>0) 
                        { 
                        $emb_title="Garment Form"; 
                        $emb_stat=1; 
                        } 
                        
                        echo "<td class=xl6513019 colspan=5><strong>EMB: $emb_title</strong></td>"; 
                    } 
                    else 
                    { 
                        echo "<td class=xl6513019></td>"; 
                    } 
                    
                ?>  

                </tr>--> 


                <?php 
                $colspan1 = $divide+1;
                $s_count=0;
                $temp_len1=0;
                $total_ratio1=0; 
                $total_temp_values=0; 
                $temp_sum=0; 
                $total_size = sizeof($s_tit);
                // $total_size = 34;
                if($total_size<15){
                    $colspan1=(sizeof($s_tit)+1);
                    $vol=2;
                }
                else {
                    $colspan1 = $divide+1;
                    $vol=1;
                }
                ?>
               
               <?php
                if($vol==1){
                ?>
                <tr class=xl6613019 height=20 style='mso-height-source:userset;height:10.0pt'> 
                    <td height=20 class=xl6613019 style='height:10.0pt'></td> 
                    <td rowspan=2 class=xl10013019 style='border-bottom:.5pt solid black'>Cut No</td> 
                    <td colspan=<?php echo ($colspan1);?> class=xl10313019 style='border-right:.5pt solid black; 
                    border-left:none'>Plies</td> 
                </tr>
                <tr class=xl6613019 height=20 style='mso-height-source:userset;height:10.0pt'> 
                    <td height=20 class=xl6613019 style='height:10.0pt'></td> 
                    <td style='border-right:.5pt solid black;border-bottom:.5pt solid black;font-size:18px;font-weight:bold;' class='cat'>Category</td> 
                        <?php 
                            if($flag == 1) 
                            { 
                                for($s=0;$s<$total_size;$s++) 
                                { 
                                    // if($s_tit[$sizes_code[$s]]<>'') 
                                    { 
                                        $s_count=$s_count+1; 
                                        echo "<td class=xl8413019>".$s_tit[$sizes_code[$s]]."</td>"; 
                                    } 
                                    if(($s+1) % $divide == 0){
                                        $temp_len = $s+1;
                                        echo "</tr>";
                                        $a_s01_tot=0;
                                        $a_s02_tot=0;
                                        $a_s03_tot=0;
                                        $a_s04_tot=0;
                                        $a_s05_tot=0;
                                        $a_s06_tot=0;
                                        $a_s07_tot=0;
                                        $a_s08_tot=0;
                                        $a_s09_tot=0;
                                        $a_s10_tot=0;
                                        $a_s11_tot=0;
                                        $a_s12_tot=0;
                                        $a_s13_tot=0;
                                        $a_s14_tot=0;
                                        $a_s15_tot=0;
                                        $a_s16_tot=0;
                                        $a_s17_tot=0;
                                        $a_s18_tot=0;
                                        $a_s19_tot=0;
                                        $a_s20_tot=0;
                                        $a_s21_tot=0;
                                        $a_s22_tot=0;
                                        $a_s23_tot=0;
                                        $a_s24_tot=0;
                                        $a_s25_tot=0;
                                        $a_s26_tot=0;
                                        $a_s27_tot=0;
                                        $a_s28_tot=0;
                                        $a_s29_tot=0;
                                        $a_s30_tot=0;
                                        $a_s31_tot=0;
                                        $a_s32_tot=0;
                                        $a_s33_tot=0;
                                        $a_s34_tot=0;
                                        $a_s35_tot=0;
                                        $a_s36_tot=0;
                                        $a_s37_tot=0;
                                        $a_s38_tot=0;
                                        $a_s39_tot=0;
                                        $a_s40_tot=0;
                                        $a_s41_tot=0;
                                        $a_s42_tot=0;
                                        $a_s43_tot=0;
                                        $a_s44_tot=0;
                                        $a_s45_tot=0;
                                        $a_s46_tot=0;
                                        $a_s47_tot=0;
                                        $a_s48_tot=0;
                                        $a_s49_tot=0;
                                        $a_s50_tot=0;
                                        $sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Pilot\"  order by acutno"; 
                                        mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                        $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                        $sql_num_=mysqli_num_rows($sql_result); 

                                        while($sql_row=mysqli_fetch_array($sql_result)) 
                                        {
                                            $a_s01=$sql_row['a_s01'];
                                            $a_s02=$sql_row['a_s02'];
                                            $a_s03=$sql_row['a_s03'];
                                            $a_s04=$sql_row['a_s04'];
                                            $a_s05=$sql_row['a_s05'];
                                            $a_s06=$sql_row['a_s06'];
                                            $a_s07=$sql_row['a_s07'];
                                            $a_s08=$sql_row['a_s08'];
                                            $a_s09=$sql_row['a_s09'];
                                            $a_s10=$sql_row['a_s10'];
                                            $a_s11=$sql_row['a_s11'];
                                            $a_s12=$sql_row['a_s12'];
                                            $a_s13=$sql_row['a_s13'];
                                            $a_s14=$sql_row['a_s14'];
                                            $a_s15=$sql_row['a_s15'];
                                            $a_s16=$sql_row['a_s16'];
                                            $a_s17=$sql_row['a_s17'];
                                            $a_s18=$sql_row['a_s18'];
                                            $a_s19=$sql_row['a_s19'];
                                            $a_s20=$sql_row['a_s20'];
                                            $a_s21=$sql_row['a_s21'];
                                            $a_s22=$sql_row['a_s22'];
                                            $a_s23=$sql_row['a_s23'];
                                            $a_s24=$sql_row['a_s24'];
                                            $a_s25=$sql_row['a_s25'];
                                            $a_s26=$sql_row['a_s26'];
                                            $a_s27=$sql_row['a_s27'];
                                            $a_s28=$sql_row['a_s28'];
                                            $a_s29=$sql_row['a_s29'];
                                            $a_s30=$sql_row['a_s30'];
                                            $a_s31=$sql_row['a_s31'];
                                            $a_s32=$sql_row['a_s32'];
                                            $a_s33=$sql_row['a_s33'];
                                            $a_s34=$sql_row['a_s34'];
                                            $a_s35=$sql_row['a_s35'];
                                            $a_s36=$sql_row['a_s36'];
                                            $a_s37=$sql_row['a_s37'];
                                            $a_s38=$sql_row['a_s38'];
                                            $a_s39=$sql_row['a_s39'];
                                            $a_s40=$sql_row['a_s40'];
                                            $a_s41=$sql_row['a_s41'];
                                            $a_s42=$sql_row['a_s42'];
                                            $a_s43=$sql_row['a_s43'];
                                            $a_s44=$sql_row['a_s44'];
                                            $a_s45=$sql_row['a_s45'];
                                            $a_s46=$sql_row['a_s46'];
                                            $a_s47=$sql_row['a_s47'];
                                            $a_s48=$sql_row['a_s48'];
                                            $a_s49=$sql_row['a_s49'];
                                            $a_s50=$sql_row['a_s50'];

                                            $plies=$sql_row['p_plies']; 

                                            echo "<tr class=xl6613019 height=20 style='mso-height-source:userset;height:10.0pt'><td height=20 class=xl6613019 style='height:10.0pt'></td><td height=20 class=xl8613019 style='height:10.0pt'></td>"; 
                                                echo "<td class=xl8613019>Pilot</td>"; 
                                            for($i=$temp_len1+1;$i<=$temp_len;$i++) {
                                                $num_padded = sprintf("%02d", $i);
                                                $var1=$sql_row['a_s'.$num_padded];
                                                echo "<td class=xl8713019>".$var1.'-'.$i."</td>"; 
                                            }
                                            echo "</tr>";
                                        }
                                        for($m=0;$m<$total_size;$m++) 
                                        { 
                                            $code="ex_s".$sizes_code[$m]; 
                                            $$code=($c_s[$m]-$o_s[$m]); 
                                        }
                                        if($excess_cut_qty == 1)
                                        {					   
                                            $sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" order by acutno*1"; 
                                        }
                                        else
                                        {
                                            $sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" order by acutno desc";
                                        } 
                                        mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                        $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                        $sql_num_=mysqli_num_rows($sql_result); 
                                        $cut_status=1;
                                        $cuts=array();
                                        $pliess=array();
                                        $qty=array();
                                        $ratio=array();
                                        while($sql_row=mysqli_fetch_array($sql_result)) 
                                        { 
                                            $cuts[]=$sql_row['acutno'];
                                            $pliess[$sql_row['acutno']]=$sql_row['p_plies'];
                                            $cutno=$sql_row['acutno']; 
                                            $plies=$sql_row['p_plies']; 
                                            $docketno=$sql_row['doc_no']; 
                                            $docketdate=$sql_row['date']; 
                                            $mk_ref=$sql_row['mk_ref']; 
                                            for($ii=0;$ii<$total_size;$ii++)
                                            {							
                                                $temp_code="a_".$sizes_array[$ii];
                                                $$temp_code=$sql_row["a_".$sizes_array[$ii].""];	
                                                $temp_code1="ex_".$sizes_array[$ii];
                                                if($$temp_code1>0)
                                                {
                                                    if(($$temp_code*$plies)<$$temp_code1)
                                                    {
                                                        $ratio[$sql_row['acutno']][$sizes_array[$ii]]=$$temp_code;
                                                        $qty[$sql_row['acutno']][$sizes_array[$ii]]=0;
                                                        $$temp_code1=$$temp_code1-($$temp_code*$plies);
                                                    }
                                                    else
                                                    {
                                                        $ratio[$sql_row['acutno']][$sizes_array[$ii]]=$$temp_code;
                                                        $qty[$sql_row['acutno']][$sizes_array[$ii]]=($$temp_code*$plies)-$$temp_code1;
                                                        $$temp_code1=0;
                                                    }
                                                }
                                                else
                                                {
                                                    $ratio[$sql_row['acutno']][$sizes_array[$ii]]=$$temp_code;
                                                    $qty[$sql_row['acutno']][$sizes_array[$ii]]=$$temp_code*$plies;
                                                }	
                                            }
                                        }
                                        echo "<tr class=xl6613019 height=20 ; style='mso-height-source:userset;height:10.0pt' > <td></td>
                                        ";
                                        echo "<td class=xl8613019 style='width: 77px; text-align: center; margin:0; padding:0; height:100%;'>".chr($color_code)."000"."</td>"; 
                                        echo"<td class=xl8613019 style='text-align: center;'>Ratio</td>";
                                        $total=0; 
                                        for($j=$temp_len1;$j<$temp_len;$j++) 
                                        {    
                                            $array_val=${'ex_'.$sizes_array[$j]}; 
                                            echo "<td class=xl8713019 style='text-align: center;'><div style='width: 116px;text-align: center; float: right; height:100%;'>0</div></td>"; 
                                            $total+=$array_val; 
                                        }
                                        echo "</tr>";
                                        sort($cuts);
                                        // var_dump(sizeof($cuts)).'sizeof($cuts)';
                                        for($k=0;$k<sizeof($cuts);$k++)
                                        {
                                            error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
                                            echo "<tr class=xl6613019 height=20 style='mso-height-source:userset;height:10.0pt'><td height=20 class=xl6613019 style='height:10.0pt'></td>"; 
                                            echo "<td class=xl8613019 style='width: 77px; text-align: center; margin:0; padding:0; height:100%;'>".chr($color_code).leading_zeros($cuts[$k], 3)."</td>"; 
                                            echo"<td class=xl8613019 style='text-align: center;'>Ratio</td>"; 
                                            for($n=$temp_len1;$n<$temp_len;$n++) 
                                            {    
                                                echo "<td class=xl8713019 style='text-align: center;'><div style='width: 116px;text-align: center; float: right; height:100%;'>".$ratio[$cuts[$k]][$sizes_array[$n]]."";     
                                                echo "</div></td>"; 
                                                $total_ratio1=$total_ratio1+$ratio[$cuts[$k]][$sizes_array[$n]]; 
                                                $temp_sum=$temp_sum+$qty[$cuts[$k]][$sizes_array[$n]]; 
                                                $total_temp_values=$total_temp_values+$qty[$cuts[$k]][$sizes_array[$n]];                 
                                            }						
                                            echo "</tr>"; 
                                            // $total_temp_values=0;												
                                        } 
                                        
                                        if(($total_size-$temp_len)>$divide){
                                            $colspan1=$divide+1;
                                        } else {
                                            $colspan1=$total_size-$temp_len+1;
                                        }
                                        echo "<tr class=xl6513019 height=20 style='mso-height-source:userset;height:10.0pt'> 
                                        <td height=20 class=xl6513019 style='height:10.0pt'></td> 
                                        </tr>";
                                        echo "<tr class=xl6613019 height=20 style='mso-height-source:userset;height:10.0pt'> 
                                        <td height=20 class=xl6613019 style='height:10.0pt'></td> 
                                        <td rowspan=2 class=xl10013019 style='border-bottom:.5pt solid black'>Cut No</td> 
                                        <td colspan=$colspan1; class=xl10313019 style='border-right:.5pt solid black; 
                                        border-left:none'>Plies</td>";
                                        if($colspan1<=$divide){
                                            echo "<td rowspan=2 class=xl10013019 style='border-bottom:.5pt solid black'>Plies</td>
                                            <td colspan=10 class=xl10313019 style='border-right:.5pt solid black; border-left:none'>RM Details</td>";
                                        } 
                                        echo "</tr>";
                                        
                                        echo "<td></td><td style='border-right:.5pt solid black;border-bottom:.5pt solid black;font-size:18px;font-weight:bold;' class='cat'>Category</td>";
                                        $temp_len1=$temp_len;
                                        $s_count=0;
                                    }
                                    if($s+1==$total_size) {
                                        // if(($s_count+3) >= $divide) {
                                        //     echo "</tr><tr>";
                                        // }
                                        // else 
                                        {
                                            echo "<td class=xl8413019>Requested Qty</td> 
                                            <td class=xl8413019>Issued Qty</td> 
                                            <td class=xl8413019>DATE</td> 
                                            <td class=xl8413019>TIME</td>
                                            <td class=xl8413019>SEC</td>
                                            <td class=xl8413019>PICKING LIST NO</td>
                                            <td class=xl8413019>DEL NO</td>
                                            <td class=xl8413019>ISSUED BY</td>
                                            <td class=xl8413019>RECEIVED BY</td>
                                            <td class=xl8413019>REMARKS/<br/>Roll No's</td>";
                                            echo "</tr>";
                                            $sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Pilot\"  order by acutno"; 
                                            mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                            $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                            while($sql_row=mysqli_fetch_array($sql_result)) 
                                            {
                                                $a_s01=$sql_row['a_s01'];
                                                $a_s02=$sql_row['a_s02'];
                                                $a_s03=$sql_row['a_s03'];
                                                $a_s04=$sql_row['a_s04'];
                                                $a_s05=$sql_row['a_s05'];
                                                $a_s06=$sql_row['a_s06'];
                                                $a_s07=$sql_row['a_s07'];
                                                $a_s08=$sql_row['a_s08'];
                                                $a_s09=$sql_row['a_s09'];
                                                $a_s10=$sql_row['a_s10'];
                                                $a_s11=$sql_row['a_s11'];
                                                $a_s12=$sql_row['a_s12'];
                                                $a_s13=$sql_row['a_s13'];
                                                $a_s14=$sql_row['a_s14'];
                                                $a_s15=$sql_row['a_s15'];
                                                $a_s16=$sql_row['a_s16'];
                                                $a_s17=$sql_row['a_s17'];
                                                $a_s18=$sql_row['a_s18'];
                                                $a_s19=$sql_row['a_s19'];
                                                $a_s20=$sql_row['a_s20'];
                                                $a_s21=$sql_row['a_s21'];
                                                $a_s22=$sql_row['a_s22'];
                                                $a_s23=$sql_row['a_s23'];
                                                $a_s24=$sql_row['a_s24'];
                                                $a_s25=$sql_row['a_s25'];
                                                $a_s26=$sql_row['a_s26'];
                                                $a_s27=$sql_row['a_s27'];
                                                $a_s28=$sql_row['a_s28'];
                                                $a_s29=$sql_row['a_s29'];
                                                $a_s30=$sql_row['a_s30'];
                                                $a_s31=$sql_row['a_s31'];
                                                $a_s32=$sql_row['a_s32'];
                                                $a_s33=$sql_row['a_s33'];
                                                $a_s34=$sql_row['a_s34'];
                                                $a_s35=$sql_row['a_s35'];
                                                $a_s36=$sql_row['a_s36'];
                                                $a_s37=$sql_row['a_s37'];
                                                $a_s38=$sql_row['a_s38'];
                                                $a_s39=$sql_row['a_s39'];
                                                $a_s40=$sql_row['a_s40'];
                                                $a_s41=$sql_row['a_s41'];
                                                $a_s42=$sql_row['a_s42'];
                                                $a_s43=$sql_row['a_s43'];
                                                $a_s44=$sql_row['a_s44'];
                                                $a_s45=$sql_row['a_s45'];
                                                $a_s46=$sql_row['a_s46'];
                                                $a_s47=$sql_row['a_s47'];
                                                $a_s48=$sql_row['a_s48'];
                                                $a_s49=$sql_row['a_s49'];
                                                $a_s50=$sql_row['a_s50'];

                                                $plies=$sql_row['p_plies']; 
                                                
                                                echo "<tr class=xl6613019 height=20 style='mso-height-source:userset;height:10.0pt'><td height=20 class=xl6613019 style='height:10.0pt'></td><td height=20 class=xl8613019 style='height:10.0pt'></td>"; 
                                                echo "<td class=xl8613019>Pilot</td>"; 
                                                for($i=$temp_len1+1;$i<=$total_size;$i++) {
                                                    $num_padded = sprintf("%02d", $i);
                                                    $var1=$sql_row['a_s'.$num_padded];
                                                    echo "<td class=xl8713019>".$var1."</td>"; 
                                                }
                                                echo "<td height=20 class=xl8613019 style='height:10.0pt'></td>";
                                                echo "<td height=20 class=xl8613019 style='height:10.0pt'></td>";
                                                echo "<td height=20 class=xl8613019 style='height:10.0pt'></td>";
                                                echo "<td height=20 class=xl8613019 style='height:10.0pt'></td>";
                                                echo "<td height=20 class=xl8613019 style='height:10.0pt'></td>";
                                                echo "<td height=20 class=xl8613019 style='height:10.0pt'></td>";
                                                echo "<td height=20 class=xl8613019 style='height:10.0pt'></td>";
                                                echo "<td height=20 class=xl8613019 style='height:10.0pt'></td>";
                                                echo "<td height=20 class=xl8613019 style='height:10.0pt'></td>";
                                                echo "<td height=20 class=xl8613019 style='height:10.0pt'></td>";
                                                echo "<td height=20 class=xl8613019 style='height:10.0pt'></td>";
                                                echo "</tr>";
                                            }
                                            if($cut_status == 1)
                                                {
                                                    $cut_status=0;
                                                    for($i=$temp_len1;$i<$total_size;$i++) 
                                                    { 
                                                        $code="ex_s".$sizes_code[$s]; 
                                                        $$code=($c_s[$s]-$o_s[$s]); 
                                                    }							
                                                    echo "<tr class=xl6613019 height=20 ; style='mso-height-source:userset;height:10.0pt' > 
                                                            <td height=20 class=xl6613019 style='height:10.0pt'></td>"; 
                                                    echo "<td class=xl8613019 style='width: 77px; text-align: center; margin:0; padding:0; height:100%;'>".chr($color_code)."000"."</td>"; 
                                                    echo"<td class=xl8613019 style='text-align: center;'>Ratio</td>"; 
                                                        for($i=$temp_len1;$i<$total_size;$i++) 
                                                        {    
                                                            $array_val=${'ex_'.$sizes_array[$s]}; 
                                                            echo "<td class=xl8713019 style='text-align: center;'><div style='width: 116px;text-align: center; float: right; height:100%;'>0</div></td>"; 
                                                            $total+=$array_val; 
                                                        } 
                                                    echo "<td class=xl8713019>0</td>"; 
                                                    // echo "<td class=xl8713019 style='text-align: center;'><div style='width: 116px;text-align: center; float: right; height:100%;margin-bottom:-10pt;'>0</div></td>"; 

                                                    echo "<td class=xl8713019></td>"; 
                                                    echo "<td class=xl8713019></td>"; 
                                                    echo "<td class=xl8713019></td>"; 
                                                    echo "<td class=xl8713019></td>"; 
                                                    echo "<td class=xl8713019></td>"; 
                                                    echo "<td class=xl8713019></td>"; 
                                                    echo "<td class=xl8713019></td>"; 
                                                    echo "<td class=xl8713019></td>"; 
                                                    echo "<td class=xl8713019></td>"; 
                                                    echo "<td class=xl8713019></td>"; 
                                                    echo "</tr>"; 
                                                }

                                                // sort($cuts);
                                                for($k=0;$k<sizeof($cuts);$k++)
                                                {
                                                    error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
                                                    echo "<tr class=xl6613019 height=20 style='mso-height-source:userset;height:10.0pt'><td height=20 class=xl6613019 style='height:10.0pt'></td>"; 
                                                    echo "<td class=xl8613019 style='width: 116px; text-align: center; margin:0; padding:0; height:100%;'>".chr($color_code).leading_zeros($cuts[$k], 3)."</td>"; 
                                                    echo"<td class=xl8613019 style='text-align: center;'>Ratio</td>"; 
                                                    for($i=$temp_len1;$i<$total_size;$i++) 
                                                    {    
                                                        echo "<td class=xl8713019 style='text-align: center;'><div style='width: 116px;text-align: center; float: right; height:100%;'>".$ratio[$cuts[$k]][$sizes_array[$s]]."";     
                                                        echo "</div></td>"; 
                                                        $total_ratio1=$total_ratio1+$ratio[$cuts[$k]][$sizes_array[$s]]; 
                                                        $temp_sum=$temp_sum+$qty[$cuts[$k]][$sizes_array[$s]]; 
                                                    }						
                                                    echo "<td class=xl8713019>".$pliess[$cuts[$k]]."</td>"; 
                                                    // echo "<td class=xl8713019 style='text-align: center;'><div style='width: 116px;text-align: center; float: right; height:100%;margin-bottom:-10pt;'>".$total_ratio1."</div><div style='width: 116px;text-align: center; float: right; height:100%;border-top: 1px solid black;border-top: 1px solid black;margin-top:10pt;'>".$temp_sum."</div></td>"; 
                                                    echo "<td class=xl8713019></td>"; 
                                                    echo "<td class=xl8713019></td>"; 
                                                    echo "<td class=xl8713019></td>"; 
                                                    echo "<td class=xl8713019></td>"; 
                                                    echo "<td class=xl8713019></td>"; 
                                                    echo "<td class=xl8713019></td>"; 
                                                    echo "<td class=xl8713019></td>"; 
                                                    echo "<td class=xl8713019></td>"; 
                                                    echo "<td class=xl8713019></td>"; 
                                                    echo "<td class=xl8713019></td>"; 
                                                    echo "</tr>"; 
                                                    
                                                    $total_temp_values=0;												
                                                }
                                            }
                                    }
                            
                                } 
                                
                            } 
                        ?> 
                </tr>
                <?php
                }
                else {
                    ?>
                    <tr class=xl6613019 height=20 style='mso-height-source:userset;height:15.0pt'> 
                    <td height=20 class=xl6613019 style='height:15.0pt'></td> 
                    </tr>
                    <tr class=xl6613019 height=20 style='mso-height-source:userset;height:15.0pt'> 
                    <td height=20 class=xl6613019 style='height:15.0pt'></td> 
                    <td rowspan=2 class=xl10013019 style='border-bottom:.5pt solid black'>Cut No</td> 
                    <td colspan=<?php echo sizeof($s_tit)+1 ;?> class=xl10313019 style='border-right:.5pt solid black; 
                    border-left:none'>Plies</td> 
                    <td rowspan=2 class=xl10013019 style='border-bottom:.5pt solid black'>Plies</td> 
                    <td colspan=10 class=xl10313019 style='border-right:.5pt solid black; border-left:none'>RM Details</td> 
                </tr> 

                <tr class=xl6613019 height=20 style='mso-height-source:userset;height:15.0pt'> 
                    
                    <td height=20 class=xl6613019 style='height:15.0pt'></td> 
                    <td style='border-right:.5pt solid black;border-bottom:.5pt solid black;font-size:18px' class='cat'>Category</td> 
                        
                        <?php 

                            /*This is for size headers*/ 
                            if($flag == 1) 
                            { 
                                $s_count=0; 
                                for($s=0;$s<sizeof($s_tit);$s++) 
                                { 
                                    if($s_tit[$sizes_code[$s]]<>'') 
                                    { 
                                        $s_count=$s_count+1; 
                        
                                        echo "<td class=xl8413019>".$s_tit[$sizes_code[$s]]."</td>"; 
                                    } 
                            
                                } 
                                for($i_count=1;$i_count<=(sizeof($s_tit)-$s_count);$i_count++) 
                                { 
                                    echo "<td class=xl8413019></td>"; 
                                } 
                        ?> 
                            

                        <?php 
                            } 
                         ?>

                     <td class=xl8413019>Requested Qty</td> 
                    <td class=xl8413019>Issued Qty</td> 
                    <td class=xl8413019>DATE</td> 
                    <td class=xl8413019>TIME</td>
                    <td class=xl8413019>SEC</td>
                    <td class=xl8413019>PICKING LIST NO</td>
                    <td class=xl8413019>DEL NO</td>
                    <td class=xl8413019>ISSUED BY</td>
                    <td class=xl8413019>RECEIVED BY</td>
                    <td class=xl8413019>REMARKS/Roll No's</td>

                    <?php 

                    $a_s01_tot=0; 
                    $a_s02_tot=0; 
                    $a_s03_tot=0; 
                    $a_s04_tot=0; 
                    $a_s05_tot=0; 
                    $a_s06_tot=0; 
                    $a_s07_tot=0; 
                    $a_s08_tot=0; 
                    $a_s09_tot=0; 
                    $a_s10_tot=0; 
                    $a_s11_tot=0; 
                    $a_s12_tot=0; 
                    $a_s13_tot=0; 
                    $a_s14_tot=0; 


                    $sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Pilot\"  order by acutno"; 
                    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    $sql_num_=mysqli_num_rows($sql_result); 

                    while($sql_row=mysqli_fetch_array($sql_result)) 
                    { 
                        $a_s01=$sql_row['a_s01']; 
                        $a_s02=$sql_row['a_s02']; 
                        $a_s03=$sql_row['a_s03']; 
                        $a_s04=$sql_row['a_s04']; 
                        $a_s05=$sql_row['a_s05']; 
                        $a_s06=$sql_row['a_s06']; 
                        $a_s07=$sql_row['a_s07']; 
                        $a_s08=$sql_row['a_s08']; 
                        $a_s09=$sql_row['a_s09']; 
                        $a_s10=$sql_row['a_s10']; 
                        $a_s11=$sql_row['a_s11']; 
                        $a_s12=$sql_row['a_s12']; 
                        $a_s13=$sql_row['a_s13']; 
                        $a_s14=$sql_row['a_s14']; 

                        $cutno=$sql_row['acutno']; 
                        $plies=$sql_row['p_plies']; 
                        $docketno=$sql_row['doc_no']; 
                        $docketdate=$sql_row['date']; 
                        $mk_ref=$sql_row['mk_ref']; 
                        
                        $a_s01_tot=$a_s01_tot+($a_s01*$plies); 
                        $a_s02_tot=$a_s02_tot+($a_s02*$plies); 
                        $a_s03_tot=$a_s03_tot+($a_s03*$plies); 
                        $a_s04_tot=$a_s04_tot+($a_s04*$plies); 
                        $a_s05_tot=$a_s05_tot+($a_s05*$plies); 
                        $a_s06_tot=$a_s06_tot+($a_s06*$plies); 
                        $a_s07_tot=$a_s07_tot+($a_s07*$plies); 
                        $a_s08_tot=$a_s08_tot+($a_s08*$plies); 
                        $a_s09_tot=$a_s09_tot+($a_s09*$plies); 
                        $a_s10_tot=$a_s10_tot+($a_s10*$plies); 
                        $a_s11_tot=$a_s11_tot+($a_s11*$plies); 
                        $a_s12_tot=$a_s12_tot+($a_s12*$plies); 
                        $a_s13_tot=$a_s13_tot+($a_s13*$plies); 
                        $a_s14_tot=$a_s14_tot+($a_s14*$plies); 

                        $plies_tot=$plies_tot+$plies; 
                        
                        echo "<tr class=xl6613019 height=20 style='mso-height-source:userset;height:15.0pt'> 
                            <td height=20 class=xl6613019 style='height:15.0pt'></td>"; 
                            echo "<td class=xl8613019>Pilot</td>"; 
                            echo "<td class=xl8713019>".$a_s01."</td>"; 
                            echo "<td class=xl8713019>".$a_s02."</td>"; 
                            echo "<td class=xl8713019>".$a_s03."</td>"; 
                            echo "<td class=xl8713019>".$a_s04."</td>"; 
                            echo "<td class=xl8713019>".$a_s05."</td>"; 
                            echo "<td class=xl8713019>".$a_s06."</td>"; 
                            echo "<td class=xl8713019>".$a_s07."</td>"; 
                            echo "<td class=xl8713019>".$a_s08."</td>"; 
                            echo "<td class=xl8713019>".$a_s09."</td>"; 
                            echo "<td class=xl8713019>".$a_s10."</td>"; 
                            echo "<td class=xl8713019>".$a_s11."</td>"; 
                            echo "<td class=xl8713019>".$a_s12."</td>"; 
                            echo "<td class=xl8713019>".$a_s13."</td>"; 
                            echo "<td class=xl8713019>".$plies."</td>"; 
                            echo "<td class=xl8713019></td>"; 
                            echo "<td class=xl8713019></td>"; 
                            echo "<td class=xl8713019></td>"; 
                            echo "<td class=xl8713019>".($a_s01*$plies)."</td>"; 
                            echo "<td class=xl8713019>".($a_s02*$plies)."</td>"; 
                            echo "<td class=xl8713019>".($a_s03*$plies)."</td>"; 
                            echo "<td class=xl8713019>".($a_s04*$plies)."</td>"; 
                            echo "<td class=xl8713019>".($a_s05*$plies)."</td>"; 
                            echo "<td class=xl8713019>".($a_s06*$plies)."</td>"; 
                            echo "<td class=xl8713019>".($a_s07*$plies)."</td>"; 
                            echo "<td class=xl8713019>".($a_s08*$plies)."</td>"; 
                            echo "<td class=xl8713019>".($a_s09*$plies)."</td>"; 
                            echo "<td class=xl8713019>".($a_s10*$plies)."</td>"; 
                            echo "<td class=xl8713019>".($a_s11*$plies)."</td>"; 
                            echo "<td class=xl8713019>".($a_s12*$plies)."</td>"; 
                            echo "<td class=xl8713019>".($a_s13*$plies)."</td>"; 
                            echo "<td class=xl8713019>".($a_s14*$plies)."</td>"; 

                            echo "<td class=xl8713019>".(($a_s01*$plies)+($a_s02*$plies)+($a_s03*$plies)+($a_s04*$plies)+($a_s05*$plies)+($a_s06*$plies)+($a_s07*$plies)+($a_s08*$plies)+($a_s09*$plies)+($a_s10*$plies)+($a_s11*$plies)+($a_s12*$plies)+($a_s13*$plies)+($a_s14*$plies))."</td>"; 
                            echo "<td class=xl8513019>&nbsp;</td>"; 
                        echo "</tr>"; 

                    } 

                    $a_s01_tot=0; 
                    $a_s02_tot=0; 
                    $a_s03_tot=0; 
                    $a_s04_tot=0; 
                    $a_s05_tot=0; 
                    $a_s06_tot=0; 
                    $a_s07_tot=0; 
                    $a_s08_tot=0; 
                    $a_s09_tot=0; 
                    $a_s10_tot=0; 
                    $a_s11_tot=0; 
                    $a_s12_tot=0; 
                    $a_s13_tot=0; 
                    $a_s14_tot=0; 

                    $plies_tot=0; 
                        
                    $ex_s01_tot=0; 
                    $ex_s02_tot=0; 
                    $ex_s03_tot=0; 
                    $ex_s04_tot=0; 
                    $ex_s05_tot=0; 
                    $ex_s06_tot=0; 
                    $ex_s07_tot=0; 
                    $ex_s08_tot=0; 
                    $ex_s09_tot=0; 
                    $ex_s10_tot=0; 
                    $ex_s11_tot=0; 
                    $ex_s12_tot=0; 
                    $ex_s13_tot=0; 
                    $ex_s14_tot=0; 
                                
                    for($s=0;$s<sizeof($s_tit);$s++) 
                    { 
                        $code="ex_s".$sizes_code[$s]; 
                        $$code=($c_s[$s]-$o_s[$s]); 
                    }
                    $cuts=array();
                    if($excess_cut_qty == 1)
                    {					   
                        $sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" order by acutno*1"; 
                    }
                    else
                    {
                    $sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" order by acutno desc";
                    } 
                    //echo $sql;
                    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    $sql_num_=mysqli_num_rows($sql_result); 
                    $cut_status=1;
                    $cuts=array();
                    $pliess=array();
                    $qty=array();
                    $ratio=array();
                    while($sql_row=mysqli_fetch_array($sql_result)) 
                    { 
                        $cuts[]=$sql_row['acutno'];
                        $pliess[$sql_row['acutno']]=$sql_row['p_plies'];
                        $cutno=$sql_row['acutno']; 
                        $plies=$sql_row['p_plies']; 
                        $docketno=$sql_row['doc_no']; 
                        $docketdate=$sql_row['date']; 
                        $mk_ref=$sql_row['mk_ref']; 
                        for($ii=0;$ii<sizeof($s_tit);$ii++)
                        {							
                            $temp_code="a_".$sizes_array[$ii];
                            $$temp_code=$sql_row["a_".$sizes_array[$ii].""];	
                            $temp_code1="ex_".$sizes_array[$ii];
                            if($$temp_code1>0)
                            {
                                if(($$temp_code*$plies)<$$temp_code1)
                                {
                                    $ratio[$sql_row['acutno']][$sizes_array[$ii]]=$$temp_code;
                                    $qty[$sql_row['acutno']][$sizes_array[$ii]]=0;
                                    $$temp_code1=$$temp_code1-($$temp_code*$plies);
                                }
                                else
                                {
                                    $ratio[$sql_row['acutno']][$sizes_array[$ii]]=$$temp_code;
                                    $qty[$sql_row['acutno']][$sizes_array[$ii]]=($$temp_code*$plies)-$$temp_code1;
                                    $$temp_code1=0;
                                }
                            }
                            else
                            {
                                $ratio[$sql_row['acutno']][$sizes_array[$ii]]=$$temp_code;
                                $qty[$sql_row['acutno']][$sizes_array[$ii]]=$$temp_code*$plies;
                            }	
                        }
                    }
                    if($cut_status == 1)
                    {
                        $cut_status=0;
                        for($s=0;$s<sizeof($s_tit);$s++) 
                        { 
                            $code="ex_s".$sizes_code[$s]; 
                            $$code=($c_s[$s]-$o_s[$s]); 
                        }							
                        echo "<tr class=xl6613019 height=20 ; style='mso-height-source:userset;height:15.0pt' > 
                                <td height=20 class=xl6613019 style='height:15.0pt'></td>"; 
                        echo "<td class=xl8613019 style='width: 77px; text-align: center; margin:0; padding:0; height:100%;'>".chr($color_code)."000"."</td>"; 
                        echo"<td class=xl8613019 style='text-align: center;'>Ratio</td>"; 
                            $total=0; 
                            for($s=0;$s<sizeof($s_tit);$s++) 
                            {    
                                $array_val=${'ex_'.$sizes_array[$s]};
                                echo "<td class=xl8713019 style='text-align: center;'><div style='width: 116px;text-align: center; float: right; height:100%;'>0</div></td>";
                                // echo "<td class=xl8713019 style='text-align: center;'>0<div style='width: 77px;text-align: center; float: right; height:100%;border-top: 1px solid black;'>$array_val</div></td>"; 
                                $total+=$array_val; 
                            } 
                        echo "<td class=xl8713019>0</td>"; 
                        // echo "<td class=xl8713019 style='text-align: center;'><div style='width: 116px;text-align: center; float: right; height:100%;'>0</div></td>";
                        // echo "<td class=xl8713019 style='text-align: center;'>0<div style='width: 77px;text-align: center; float: right; height:100%;border-top: 1px solid black;'>$total</div></td>"; 

                        echo "<td class=xl8713019></td>"; 
                        echo "<td class=xl8713019></td>"; 
                        echo "<td class=xl8713019></td>"; 
                        echo "<td class=xl8713019></td>"; 
                        echo "<td class=xl8713019></td>"; 
                        echo "<td class=xl8713019></td>"; 
                        echo "<td class=xl8713019></td>"; 
                        echo "<td class=xl8713019></td>"; 
                        echo "<td class=xl8713019></td>"; 
                        echo "<td class=xl8713019></td>"; 
                        echo "</tr>"; 
                    }
                    sort($cuts);
                    for($k=0;$k<sizeof($cuts);$k++)
                    {
                        error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
                        echo "<tr class=xl6613019 height=20 style='mso-height-source:userset;height:15.0pt'><td height=20 class=xl6613019 style='height:15.0pt'></td>"; 
                        echo "<td class=xl8613019 style='width: 77px; text-align: center; margin:0; padding:0; height:100%;'>".chr($color_code).leading_zeros($cuts[$k], 3)."</td>"; 
                        echo"<td class=xl8613019 style='text-align: center;'>Ratio</td>"; 
                    
                        $total_ratio1=0; 
                        $total_temp_values=0; 
                        $temp_sum=0; 
                        for($s=0;$s<sizeof($s_tit);$s++) 
                        {    
                            // echo "<td class=xl8713019 style='text-align: center;'>".$ratio[$cuts[$k]][$sizes_array[$s]]."<div style='width: 77px;text-align: center; float: right; height:100%;border-top: 1px solid black;'>".$qty[$cuts[$k]][$sizes_array[$s]]."";     
                            // echo "</div></td>"; 
                            echo "<td class=xl8713019 style='text-align: center;'><div style='width: 116px;text-align: center; float: right; height:100%;'>".$ratio[$cuts[$k]][$sizes_array[$s]]."</div></td>";
                            $total_ratio1=$total_ratio1+$ratio[$cuts[$k]][$sizes_array[$s]]; 
                            $temp_sum=$temp_sum+$qty[$cuts[$k]][$sizes_array[$s]]; 
                            $total_temp_values=$total_temp_values+$qty[$cuts[$k]][$sizes_array[$s]];                 
                        }						
                        echo "<td class=xl8713019>".$pliess[$cuts[$k]]."</td>"; 
                        // echo "<td class=xl8713019 style='text-align: center;'><div style='width: 116px;text-align: center; float: right; height:100%;'>".$total_ratio1."</div></td>";

                        // echo "<td class=xl8713019 style='text-align: center;'>".$total_ratio1."<div style='width: 77px; float: right;text-align: center; height:100%;border-top: 1px solid black;' >".$temp_sum."</div></td>"; 
                        echo "<td class=xl8713019></td>"; 
                        echo "<td class=xl8713019></td>"; 
                        echo "<td class=xl8713019></td>"; 
                        echo "<td class=xl8713019></td>"; 
                        echo "<td class=xl8713019></td>"; 
                        echo "<td class=xl8713019></td>"; 
                        echo "<td class=xl8713019></td>"; 
                        echo "<td class=xl8713019></td>"; 
                        echo "<td class=xl8713019></td>"; 
                        echo "<td class=xl8713019></td>"; 
                        echo "</tr>"; 
                        
                        $total_temp_values=0;												
                    } 

                    ?>


                    <tr class=xl6513019 height=22 style='mso-height-source:userset;height:16.5pt'> 
                    <td height=22 class=xl6513019 style='height:16.5pt'></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    </tr> 

                    <tr class=xl6513019 height=21 style='mso-height-source:userset;height:15.75pt'> 
                    <td height=21 class=xl6513019 style='height:15.75pt'></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl8513019>&nbsp;</td> 
                    <td class=xl6513019></td> 
                    </tr> 
                    
                </tr>
                <?php
                }
                ?>
                
                <tr class=xl6513019 height=20 style='mso-height-source:userset;height:10.0pt'> 
                    <td height=20 class=xl6513019 style='height:10.0pt'></td> 
                </tr>
                <!-- <tr class=xl6513019 height=20 style='mso-height-source:userset;height:10.0pt'> 
                    <td height=20 class=xl6513019 style='height:10.0pt'></td> 
                </tr> -->
                <!-- <tr class=xl6513019 height=20 style='mso-height-source:userset;height:10.0pt'> 
                    <td height=20 class=xl6513019 style='height:10.0pt'></td> 
                    <th rowspan=2 class=xl10513019 width=70 style='border-bottom:.5pt solid black; 
                    width:53pt'>Recon.</th> 
                    <th class=xl10713019 style='border-right:.5pt solid black; 
                    border-left:none'>Section</th> 
                    <th class=xl10913019 style='border-right:.5pt solid black; 
                    border-left:none'>Date<br/>Completed</th> 
                    <th class=xl10913019 style='border-right:.5pt solid black; 
                    border-left:none'>Fabric<br/>Recived</th> 
                    <th class=xl10913019 style='border-right:.5pt solid black; 
                    border-left:none'>Cut Qty</th> 
                    <th class=xl10913019 style='border-right:.5pt solid black; 
                    border-left:none'>Re-Cut Qty</th> 
                    <th class=xl10913019 style='border-right:.5pt solid black; 
                    border-left:none'>Act YY</th> 
                    <th class=xl9213019>CAD YY</th> 
                    <th class=xl10713019 style='border-right:.5pt solid black; 
                    border-left:none'>Act Saving</th> 
                    <th class=xl10913019 style='border-right:.5pt solid black; 
                    border-left:none'>Shortage</th> 
                    <th class=xl10913019 style='border-right:.5pt solid black; 
                    border-left:none'>Deficit <br/>/ Surplus</th> 
                    <th class=xl10913019 style='border-right:.5pt solid black; 
                    border-left:none'>Reconsilation</th> 
                    <th class=xl9213019>Sign</th> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                </tr>  -->
                
                <!-- <tr class=xl6513019 height=30 style='mso-height-source:userset;height:30pt'>  -->
                    <!-- <td height=20 class=xl6513019 style='height:10.0pt'></td> 

                    <td class=xl10713019 style='border-right:.5pt solid black; 
                    border-left:none'></td> 
                    <td class=xl10913019 style='border-right:.5pt solid black; 
                    border-left:none'> </td> 
                    <td class=xl10913019 style='border-right:.5pt solid black; 
                    border-left:none'> </td> 
                    <td class=xl10913019 style='border-right:.5pt solid black; 
                    border-left:none'> </td> 
                    <td class=xl10913019 style='border-right:.5pt solid black; 
                    border-left:none'></td> 
                    <td class=xl10913019 style='border-right:.5pt solid black; 
                    border-left:none'> </td> 
                    <td class=xl9213019> </td> 
                    <td class=xl10713019 style='border-right:.5pt solid black; 
                    border-left:none'> </td> 
                    <td class=xl10913019 style='border-right:.5pt solid black; 
                    border-left:none'></td> 
                    <td class=xl10913019 style='border-right:.5pt solid black; 
                    border-left:none'> </td> 
                    <td class=xl10913019 style='border-right:.5pt solid black; 
                    border-left:none'></td>  -->
                    <!-- <td class=xl9213019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    </tr> -->
                    <tr height=21 style='height:85.75pt'>
                    <td colspan=18 style='text-align:right'><u><strong>Quality Authorisation</strong></u></td>
                    </tr>
                    <tr height=21 style='height:15.75pt'>
                    <td colspan=18 style='text-align:right'><u><strong>Cutting Supervisor Authorization</strong></u></td>
                    </tr>
                    <tr height=21 style='height:15.75pt'> 
                    <td height=21 class=xl6513019 style='height:15.75pt'></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    <td class=xl6613019></td> 
                    
                    <!-- <td class=xl6613019><strong><u><br/><br/><br/><br/><u><strong>Quality Authorisation</strong></u><br/><br/><br/><br/> -->
                    <!-- <br/>Cutting Supervisor Authorization</u></strong></td>  -->
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                    <td class=xl6513019></td> 
                </tr> 

                <![if supportMisalignedColumns]> 
                
                <tr height=0 style='display:none'> 
                    <td width=13 style='width:10pt'></td> 
                    <td width=70 style='width:53pt'></td> 
                    <td width=53 style='width:40pt'></td> 
                    <td width=53 style='width:40pt'></td> 
                    <td width=53 style='width:40pt'></td> 
                    <td width=53 style='width:40pt'></td> 
                    <td width=53 style='width:40pt'></td> 
                    <td width=53 style='width:40pt'></td> 
                    <td width=53 style='width:40pt'></td> 
                    <td width=52 style='width:39pt'></td> 
                    <td width=52 style='width:39pt'></td> 
                    <td width=52 style='width:39pt'></td> 
                    <td width=51 style='width:38pt'></td> 
                    <td width=51 style='width:38pt'></td> 
                    <td width=61 style='width:46pt'></td> 
                    <td width=67 style='width:50pt'></td> 
                    <td width=51 style='width:38pt'></td> 
                    <td width=48 style='width:36pt'></td> 
                    <td width=58 style='width:44pt'></td> 
                    <td width=48 style='width:36pt'></td> 
                    <td width=58 style='width:44pt'></td> 
                    <td width=61 style='width:46pt'></td> 
                    <td width=48 style='width:36pt'></td> 
                    <td width=48 style='width:36pt'></td> 
                    <td width=48 style='width:36pt'></td> 
                    <td width=45 style='width:34pt'></td> 
                    <td width=45 style='width:34pt'></td> 
                    <td width=51 style='width:38pt'></td> 
                    <td width=55 style='width:41pt'></td> 
                    <td width=45 style='width:34pt'></td> 
                    <td width=64 style='width:48pt'></td> 
                    <td width=64 style='width:48pt'></td> 
                    <td width=64 style='width:48pt'></td> 
                    <td width=16 style='width:12pt'></td> 
                </tr>

                <![endif]> 
            
            </table> 

        </div> 

        <!-----------------------------> 
        <!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD--> 
        <!-----------------------------> 

    </body> 


</html> 


<?php 

    $sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\""; 
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    $sql_num_check=mysqli_num_rows($sql_result); 

    if($sql_num_check==0) 
    { 
        $sql="insert ignore into $bai_pro3.bai_orders_db_confirm select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\""; 
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        //$sql_num_confirm=mysql_num_rows($sql_result); 
    } 
    //$context = stream_context_create(array('http'=>array('ignore_errors'=>true))); 
    //$contents = file_get_contents($actual_link, FALSE, $context); 
    //echo $contents; 
    



    //$printdata = ob_end_clean(); 




    //$printUrl = ""; 

    /* $mpdf=new mPDF();  
    var_dump($printdata); 
    exit; */ 
    // include("../../RM_Projects/BAI_RM_PJ1/mpdf50/mpdf.php"); 
    //$mpdf=new mPDF(); 
    //$html = "Hello world"; 

    //$mpdf->charset_in='UTF-8'; 
    //$mpdf->WriteHTML($html); 
    //$mpdf->Output(); 
    //exit; 

?> 

<style>
	
    .xl1532599,.xl6432599,.xl6532599,.xl6632599,.xl6732599,.xl6832599,.xl6932599,.xl7032599,.xl7132599,
	.xl7232599,.xl7332599,.xl7432599,.xl7532599,.xl7632599,.xl7732599,.xl7832599,.xl7932599,.xl8032599,.xl8132599,
	.xl8232599,.xl8332599,.xl8432599,.xl8532599,.xl8632599,.xl8732599,.xl8832599,.xl8932599,.xl9032599,.xl9132599,
	.xl9232599,.xl9332599,.xl9432599,.xl9532599,.xl9632599,.xl9732599,.xl9832599,.xl6713019,
    .xl9613019,.xl9713019,.xl7013019,.xl6813019,.xl9813019,.xl7613019,.xl6913019,.xl7613019,.xl7713019,.xl7213019,
    .xl7413019,.xl7513019,.xl7313019,.xl6713019,.xl10713019,.xl10913019,.xl10513019,.xl9213019{
		font-size : 22px;
	}
    .xl10013019,.xl10313019,.xl8413019,.xl8613019,.xl8713019,.cat{
        font-size : 20px;
    }
	*{
		font-size : 22px;
	}
    td,th {
        /* min-width:5pt; */
        text-align:center;
        font-weight:bold;

    }
    .xl10913019,.xl10713019,.xl9213019,.cat{
        font-weight:bold;
    }
table { page-break-after:auto,page-break-inside:avoid; }
  tr    { page-break-inside:avoid; page-break-after:auto }
  td    { page-break-inside:avoid; }
  thead { display:table-header-group }
  tfoot { display:table-footer-group }
</style>

<script>
$(document).ready(function(){
	$("table tbody th, table tbody td").wrapInner("<div></div>");
});
</script>
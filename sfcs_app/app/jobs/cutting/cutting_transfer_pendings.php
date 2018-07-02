<!DOCTYPE html>
<html>
<head>  
<?php 
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');

$cache_date="Cutting_2_1Room_Transfer_Pendings"; 
$cachefile = $cache_date."html"; 

/* if (file_exists($cachefile)) { 

    include($cachefile); 

    exit; 

} */ 
ob_start(); 

?> 
<title>Cut to 1% Transfer Pendings</title> 
<style> 

table tr 
{ 
    border: 1px solid black; 
    text-align: right; 
    white-space:nowrap;  
} 

table td 
{ 
    border: 1px solid black; 
    text-align: right; 
white-space:nowrap;  
} 

table th 
{ 
    border: 1px solid black; 
    text-align: center; 
        background-color:#29759C; 
    color: WHITE; 
white-space:nowrap;  
    padding-left: 5px; 
    padding-right: 5px; 
} 

.total 
{ 
    border: 1px solid black; 
    text-align: center; 
        background-color: ORANGE; 
    color: WHITE; 
white-space:nowrap;  
    padding-left: 5px; 
    padding-right: 5px; 
} 


table{ 
    white-space:nowrap;  
    border-collapse:collapse; 
    font-size:12px; 
    background-color: white; 
} 


} 

} 
</style> 

<script> 
    /** 
 *  jQuery ColumnFilter Plugin 
 *  @requires jQuery v1.2.6 or greater 
 *  http://hernan.amiune.com/labs 
 * 
 *  Copyright (c)  Hernan Amiune (hernan.amiune.com) 
 *  Licensed under MIT license: 
 *  http://www.opensource.org/licenses/mit-license.php 
 *  
 *  Version: 1.1 
 */ 

(function($) { 
    $.fn.columnfilter = function(options) { 

        var defaults = {}; 

        var options = $.extend(defaults, options); 

        return this.each(function(index) { 

            var $table = $(this); 
                 
            $table.find("th.filter").each(function() { 
                //create a select list for each filter column 
                var i = 0; 
                var $select = $('<select class="selectfilter" multiple></select>'); 
                var $this = $(this); 
                var colindex = $this.parent().children().index($this) + 1; 
                var dictionary = []; 
                $table.find("tr td:nth-child(" + colindex + ")").each(function() { 
                    var text = $(this).text(); 
                    dictionary[text] = true; 
                }); 
                var colkeys = []; 
                for (i in dictionary) colkeys.push(i); 
                colkeys.sort(); 
                $select.append('<option value="All" selected>All</option>'); 
                for (i=0; i<colkeys.length; i++) { 
                    if(colkeys[i] === "indexOf")continue; //weird stuff happens in ie and chrome, firefox is awesome 
                    if(colkeys[i]!="") 
                        $select.append('<option value="' + colkeys[i] + '">' + colkeys[i] + '</option>'); 
                } 
                $(this).append("<br/>"); 
                $(this).append($select); 

                //bind change function to each select filter 
                $select.change(function() { 

                    //create an array of the filters selected values 
                    var colIndexes = []; 
                    var selectedOptions = []; 
                    $table.find(".selectfilter").each(function() { 
                        $this = $(this); 
                        var $parent = $(this).parent(); 
                        colIndexes.push($parent.parent().children().index($parent)+1); 
                        //selectedOptions.push($this.children(":selected").text()); 
                        var test=""; 
                        $this.children(":selected").each(function(x, selected) { 
                        test += $(selected).text() + " "; 
                        }); 
                        selectedOptions.push(test); 
                        //alert(test); 
                    }); 
                     
                    //To calculate Total 
                    var col1=0; 
                    var col2=0; 
                    var col3=0; 
                    var col4=0; 
                    var col5=0; 
                    var col6=0; 
                    var col7=0; 
                    var col8=0; 
                    var col9=0; 
                     
                    //show or hide the corresponding rows 
                    $table.find("tr").each(function(rowindex) { 
                        if (rowindex > 0) { 
                            var rowok = true; 
                            for (i = 0; i < colIndexes.length;  i++) { 
                             
                                text = $(this).find("td:nth-child(" + colIndexes[i] + ")").text()+" "; 
                                     
                               // if (selectedOptions[i] != "All " && text != selectedOptions[i] && selectedOptions[i].indexOf(text)>0) rowok = false; 
                                 if (selectedOptions[i] != "All " && selectedOptions[i].indexOf(text)<0) rowok = false; 
                                //if (selectedOptions[i] != "All " && text != selectedOptions[i]) rowok = false; 
                            } 
                             
                            if (rowok === true)  
                            { $(this).show();  
                                 
                                //To Calculate Total 
                                if(!isNaN(parseFloat($(this).find("td:nth-child(6)").html()))) 
                                col1 += parseFloat($(this).find("td:nth-child(6)").html()); 
                                $("#col1").html(col1); 
                                 
                                if(!isNaN(parseFloat($(this).find("td:nth-child(7)").html()))) 
                                col2 += parseFloat($(this).find("td:nth-child(7)").html()); 
                                $("#col2").html(col2); 
                                 
                                if(!isNaN(parseFloat($(this).find("td:nth-child(8)").html()))) 
                                col3 += parseFloat($(this).find("td:nth-child(8)").html()); 
                                $("#col3").html(col3); 
                                 
                         
                            } 
                            else 
                            { 
                                $(this).hide(); 
                            } 
                     
                        } 
                         
                    }); 
                }); 
                 
            }); 
        }); 
    }  

})(jQuery); 

    </script> 

<script type="text/javascript"> 
$(document).ready(function() { 
     
    $("table").columnfilter(); 

     
}); 
</script> 

</head> 
<body> 
<div class="panel panel-primary">
<div class="panel-heading">Cutting to 1% Room Transfer Pendings</div> 
<div class="panel-body">

<?php 
    echo "<h3><span class='label label-primary'>LU:".date("Y-m-d H-i-s")."</span></h3>"; 
    echo "<div class='table-responsive'><table class='table table-bordered'>"; 
    echo "<tr> 
    <th colspan=6 class=\"total\">Total</th> 
    <th id=\"col1\" class=\"total\" >0</th> 
    <th id=\"col2\" class=\"total\" >0</th> 
    <th id=\"col3\" class=\"total\" >0</th> 

</tr>"; 
     
    echo "<tr> 
    <th>Style</th> 
    <th class=\"filter\">Schedule</th> 
    <th>Color</th> 
    <th class=\"filter\">Ex-Factory Date</th> 
    <th class=\"filter\">Size</th> 
    <th class=\"filter\">EMB Status</th> 
    <th>Excess Panels</th> 
    <th>Received</th> 
    <th>Balance</th> 
</tr>"; 
     
    $temp_schedule=0; 
    $temp_color=0; 
     
    $sql="select * from $bai_pro3.zero_module_trans"; 
    //echo $sql; 
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row=mysqli_fetch_array($sql_result)) 
    { 
        $style=$sql_row['ims_style']; 
        $schedule=$sql_row['ims_schedule']; 
        $color=$sql_row['ims_color']; 
        $size=$sql_row['size']; 
        $qty=$sql_row['ims_qty']; 
         
        $recut_docs=array(); 
        $qty_req_sizes=array(); 
        $qty_act_sizes=array(); 
        $qty_req=array(); 
        $qty_actual=array(); 
         
        $sizes_db=array("XS","S","M","L","XL","XXL","XXXL","s01","s02","s03","s04","s05","s06","s07","s08","s09","s10","s11","s12","s13","s14","s15","s16","s17","s18" 
,"s19","s20","s21","s22","s23","s24","s25","s26","s27","s28","s29","s30","s31","s32","s33","s34","s35","s36","s37","s38","s39","s40","s41","s42","s43","s44","s45","s46" 
,"s47","s48","s49","s50"); 
         
        if($temp_schedule!=$schedule and strcmp($temp_color,trim($color))) 
        { 
            $order_qtys=array(); 
            $order_date=""; 
            $sql1="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"".$style."\" and order_del_no=\"".$schedule."\" and order_col_des=\"".$color."\""; 
            //echo $sql1."<br/>"; 
            $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_row1=mysqli_fetch_array($sql_result1)) 
            { 
                $order_qtys[]=$sql_row1['order_s_xs']; 
                $order_qtys[]=$sql_row1['order_s_s']; 
                $order_qtys[]=$sql_row1['order_s_m']; 
                $order_qtys[]=$sql_row1['order_s_l']; 
                $order_qtys[]=$sql_row1['order_s_xl']; 
                $order_qtys[]=$sql_row1['order_s_xxl']; 
                $order_qtys[]=$sql_row1['order_s_xxxl']; 
                $order_qtys[]=$sql_row1['order_s_s01']; 
                $order_qtys[]=$sql_row1['order_s_s02']; 
                $order_qtys[]=$sql_row1['order_s_s03']; 
                $order_qtys[]=$sql_row1['order_s_s04']; 
                $order_qtys[]=$sql_row1['order_s_s05']; 
                $order_qtys[]=$sql_row1['order_s_s06']; 
                $order_qtys[]=$sql_row1['order_s_s07']; 
                $order_qtys[]=$sql_row1['order_s_s08']; 
                $order_qtys[]=$sql_row1['order_s_s09']; 
                $order_qtys[]=$sql_row1['order_s_s10']; 
                $order_qtys[]=$sql_row1['order_s_s11']; 
                $order_qtys[]=$sql_row1['order_s_s12']; 
                $order_qtys[]=$sql_row1['order_s_s13']; 
                $order_qtys[]=$sql_row1['order_s_s14']; 
                $order_qtys[]=$sql_row1['order_s_s15']; 
                $order_qtys[]=$sql_row1['order_s_s16']; 
                $order_qtys[]=$sql_row1['order_s_s17']; 
                $order_qtys[]=$sql_row1['order_s_s18']; 
                $order_qtys[]=$sql_row1['order_s_s19']; 
                $order_qtys[]=$sql_row1['order_s_s20']; 
                $order_qtys[]=$sql_row1['order_s_s21']; 
                $order_qtys[]=$sql_row1['order_s_s22']; 
                $order_qtys[]=$sql_row1['order_s_s23']; 
                $order_qtys[]=$sql_row1['order_s_s24']; 
                $order_qtys[]=$sql_row1['order_s_s25']; 
                $order_qtys[]=$sql_row1['order_s_s26']; 
                $order_qtys[]=$sql_row1['order_s_s27']; 
                $order_qtys[]=$sql_row1['order_s_s28']; 
                $order_qtys[]=$sql_row1['order_s_s29']; 
                $order_qtys[]=$sql_row1['order_s_s30']; 
                $order_qtys[]=$sql_row1['order_s_s31']; 
                $order_qtys[]=$sql_row1['order_s_s32']; 
                $order_qtys[]=$sql_row1['order_s_s33']; 
                $order_qtys[]=$sql_row1['order_s_s34']; 
                $order_qtys[]=$sql_row1['order_s_s35']; 
                $order_qtys[]=$sql_row1['order_s_s36']; 
                $order_qtys[]=$sql_row1['order_s_s37']; 
                $order_qtys[]=$sql_row1['order_s_s38']; 
                $order_qtys[]=$sql_row1['order_s_s39']; 
                $order_qtys[]=$sql_row1['order_s_s40']; 
                $order_qtys[]=$sql_row1['order_s_s41']; 
                $order_qtys[]=$sql_row1['order_s_s42']; 
                $order_qtys[]=$sql_row1['order_s_s43']; 
                $order_qtys[]=$sql_row1['order_s_s44']; 
                $order_qtys[]=$sql_row1['order_s_s45']; 
                $order_qtys[]=$sql_row1['order_s_s46']; 
                $order_qtys[]=$sql_row1['order_s_s47']; 
                $order_qtys[]=$sql_row1['order_s_s48']; 
                $order_qtys[]=$sql_row1['order_s_s49']; 
                $order_qtys[]=$sql_row1['order_s_s50']; 

                $order_tid=$sql_row1['order_tid']; 
                //$schedule=$sql_row1['order_del_no']; 
                //$color=$sql_row1['order_col_des']; 
                $emb_a=$sql_row1['order_embl_a']; 
                $emb_b=$sql_row1['order_embl_b']; 
                $emb_c=$sql_row1['order_embl_c']; 
                $emb_d=$sql_row1['order_embl_d']; 
                $emb_e=$sql_row1['order_embl_e']; 
                $emb_f=$sql_row1['order_embl_f']; 
                 
                $order_date=$sql_row1['order_date']; 
            } 
             
            $act_cut_new_db=array(); 
            $sql1="select coalesce(sum(a_xs*a_plies),0) as \"a_xs\", coalesce(sum(a_s*a_plies),0) as \"a_s\", coalesce(sum(a_m*a_plies),0) as \"a_m\", coalesce(sum(a_l*a_plies),0) as \"a_l\", coalesce(sum(a_xl*a_plies),0) as \"a_xl\", coalesce(sum(a_xxl*a_plies),0) as \"a_xxl\", coalesce(sum(a_xxxl*a_plies),0) as \"a_xxxl\", coalesce(sum(a_s01*a_plies),0) as \"a_s01\", coalesce(sum(a_s02*a_plies),0) as \"a_s02\", coalesce(sum(a_s03*a_plies),0) as \"a_s03\", coalesce(sum(a_s04*a_plies),0) as \"a_s04\", coalesce(sum(a_s05*a_plies),0) as \"a_s05\", coalesce(sum(a_s06*a_plies),0) as \"a_s06\", coalesce(sum(a_s07*a_plies),0) as \"a_s07\", coalesce(sum(a_s08*a_plies),0) as \"a_s08\", coalesce(sum(a_s09*a_plies),0) as \"a_s09\", coalesce(sum(a_s10*a_plies),0) as \"a_s10\", coalesce(sum(a_s11*a_plies),0) as \"a_s11\", coalesce(sum(a_s12*a_plies),0) as \"a_s12\", coalesce(sum(a_s13*a_plies),0) as \"a_s13\", coalesce(sum(a_s14*a_plies),0) as \"a_s14\", coalesce(sum(a_s15*a_plies),0) as \"a_s15\", coalesce(sum(a_s16*a_plies),0) as \"a_s16\", coalesce(sum(a_s17*a_plies),0) as \"a_s17\", coalesce(sum(a_s18*a_plies),0) as \"a_s18\", coalesce(sum(a_s19*a_plies),0) as \"a_s19\", coalesce(sum(a_s20*a_plies),0) as \"a_s20\", coalesce(sum(a_s21*a_plies),0) as \"a_s21\", coalesce(sum(a_s22*a_plies),0) as \"a_s22\", coalesce(sum(a_s23*a_plies),0) as \"a_s23\", coalesce(sum(a_s24*a_plies),0) as \"a_s24\", coalesce(sum(a_s25*a_plies),0) as \"a_s25\", coalesce(sum(a_s26*a_plies),0) as \"a_s26\", coalesce(sum(a_s27*a_plies),0) as \"a_s27\", coalesce(sum(a_s28*a_plies),0) as \"a_s28\", coalesce(sum(a_s29*a_plies),0) as \"a_s29\", coalesce(sum(a_s30*a_plies),0) as \"a_s30\", coalesce(sum(a_s31*a_plies),0) as \"a_s31\", coalesce(sum(a_s32*a_plies),0) as \"a_s32\", coalesce(sum(a_s33*a_plies),0) as \"a_s33\", coalesce(sum(a_s34*a_plies),0) as \"a_s34\", coalesce(sum(a_s35*a_plies),0) as \"a_s35\", coalesce(sum(a_s36*a_plies),0) as \"a_s36\", coalesce(sum(a_s37*a_plies),0) as \"a_s37\", coalesce(sum(a_s38*a_plies),0) as \"a_s38\", coalesce(sum(a_s39*a_plies),0) as \"a_s39\", coalesce(sum(a_s40*a_plies),0) as \"a_s40\", coalesce(sum(a_s41*a_plies),0) as \"a_s41\", coalesce(sum(a_s42*a_plies),0) as \"a_s42\", coalesce(sum(a_s43*a_plies),0) as \"a_s43\", coalesce(sum(a_s44*a_plies),0) as \"a_s44\", coalesce(sum(a_s45*a_plies),0) as \"a_s45\", coalesce(sum(a_s46*a_plies),0) as \"a_s46\", coalesce(sum(a_s47*a_plies),0) as \"a_s47\", coalesce(sum(a_s48*a_plies),0) as \"a_s48\", coalesce(sum(a_s49*a_plies),0) as \"a_s49\", coalesce(sum(a_s50*a_plies),0) as \"a_s50\"
 from $bai_pro3.order_cat_doc_mix where order_tid=\"$order_tid\" and category in (\"Body\",\"Front\") and act_cut_status=\"DONE\""; 
            //echo $sql1."<br/>"; 
            $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_row2=mysqli_fetch_array($sql_result1)) 
            { 
                $act_cut_new_db[]=$sql_row2['a_xs']; 
                $act_cut_new_db[]=$sql_row2['a_s']; 
                $act_cut_new_db[]=$sql_row2['a_m']; 
                $act_cut_new_db[]=$sql_row2['a_l']; 
                $act_cut_new_db[]=$sql_row2['a_xl']; 
                $act_cut_new_db[]=$sql_row2['a_xxl']; 
                $act_cut_new_db[]=$sql_row2['a_xxxl']; 
                $act_cut_new_db[]=$sql_row2['a_s01']; 
                $act_cut_new_db[]=$sql_row2['a_s02']; 
                $act_cut_new_db[]=$sql_row2['a_s03']; 
                $act_cut_new_db[]=$sql_row2['a_s04']; 
                $act_cut_new_db[]=$sql_row2['a_s05']; 
                $act_cut_new_db[]=$sql_row2['a_s06']; 
                $act_cut_new_db[]=$sql_row2['a_s07']; 
                $act_cut_new_db[]=$sql_row2['a_s08']; 
                $act_cut_new_db[]=$sql_row2['a_s09']; 
                $act_cut_new_db[]=$sql_row2['a_s10']; 
                $act_cut_new_db[]=$sql_row2['a_s11']; 
                $act_cut_new_db[]=$sql_row2['a_s12']; 
                $act_cut_new_db[]=$sql_row2['a_s13']; 
                $act_cut_new_db[]=$sql_row2['a_s14']; 
                $act_cut_new_db[]=$sql_row2['a_s15']; 
                $act_cut_new_db[]=$sql_row2['a_s16']; 
                $act_cut_new_db[]=$sql_row2['a_s17']; 
                $act_cut_new_db[]=$sql_row2['a_s18']; 
                $act_cut_new_db[]=$sql_row2['a_s19']; 
                $act_cut_new_db[]=$sql_row2['a_s20']; 
                $act_cut_new_db[]=$sql_row2['a_s21']; 
                $act_cut_new_db[]=$sql_row2['a_s22']; 
                $act_cut_new_db[]=$sql_row2['a_s23']; 
                $act_cut_new_db[]=$sql_row2['a_s24']; 
                $act_cut_new_db[]=$sql_row2['a_s25']; 
                $act_cut_new_db[]=$sql_row2['a_s26']; 
                $act_cut_new_db[]=$sql_row2['a_s27']; 
                $act_cut_new_db[]=$sql_row2['a_s28']; 
                $act_cut_new_db[]=$sql_row2['a_s29']; 
                $act_cut_new_db[]=$sql_row2['a_s30']; 
                $act_cut_new_db[]=$sql_row2['a_s31']; 
                $act_cut_new_db[]=$sql_row2['a_s32']; 
                $act_cut_new_db[]=$sql_row2['a_s33']; 
                $act_cut_new_db[]=$sql_row2['a_s34']; 
                $act_cut_new_db[]=$sql_row2['a_s35']; 
                $act_cut_new_db[]=$sql_row2['a_s36']; 
                $act_cut_new_db[]=$sql_row2['a_s37']; 
                $act_cut_new_db[]=$sql_row2['a_s38']; 
                $act_cut_new_db[]=$sql_row2['a_s39']; 
                $act_cut_new_db[]=$sql_row2['a_s40']; 
                $act_cut_new_db[]=$sql_row2['a_s41']; 
                $act_cut_new_db[]=$sql_row2['a_s42']; 
                $act_cut_new_db[]=$sql_row2['a_s43']; 
                $act_cut_new_db[]=$sql_row2['a_s44']; 
                $act_cut_new_db[]=$sql_row2['a_s45']; 
                $act_cut_new_db[]=$sql_row2['a_s46']; 
                $act_cut_new_db[]=$sql_row2['a_s47']; 
                $act_cut_new_db[]=$sql_row2['a_s48']; 
                $act_cut_new_db[]=$sql_row2['a_s49']; 
                $act_cut_new_db[]=$sql_row2['a_s50']; 

            } 
            $temp_schedule=$schedule; 
            $temp_color=trim($color); 
             
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
        } 
        $qty=$act_cut_new_db[array_search($size,$sizes_db)]-$order_qtys[array_search($size,$sizes_db)]; 
        //echo $qty."<br/>"; 
     
        $sql1="select doc_no from $bai_pro3.recut_v2_summary where order_tid in (select order_tid from $bai_pro3.bai_orders_db_confirm where order_style_no=\"".$style."\" and order_del_no=\"".$schedule."\" and order_col_des=\"".$color."\") and date>\"2011-10-26\""; 
    //echo $sql1."<br/>"; 
        $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_row1=mysqli_fetch_array($sql_result1)) 
        { 
            $recut_docs[]=$sql_row1['doc_no']; 
        } 
         
        if(sizeof($recut_docs)>0) 
        { 
            $sql1="select sum(qms_qty) as \"qms_qty\",qms_tran_type,qms_size,SUBSTRING_INDEX(remarks,'-',1) as \"module\" from $bai_pro3.bai_qms_db where qms_style=\"".$style."\" and qms_schedule=\"".$schedule."\" and qms_color=\"".$color."\" and qms_tran_type in (6,9) and SUBSTRING_INDEX(remarks,'-',-1) in (".implode(",",$recut_docs).") and qms_qty>0  group by concat(qms_size,qms_tran_type) order by log_date,SUBSTRING_INDEX(remarks,'-',1)"; 
        //echo $sql1."<br/>"; 
            $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_row1=mysqli_fetch_array($sql_result1)) 
            { 
                if($sql_row1['qms_tran_type']==6) 
                { 
                    $qty_req_sizes[]=$sql_row1['qms_size']; 
                    $qty_req[]=$sql_row1['qms_qty']; 
                } 
                if($sql_row1['qms_tran_type']==9) 
                { 
                    $qty_act_sizes[]=$sql_row1['qms_size']; 
                    $qty_actual[]=$sql_row1['qms_qty']; 
                } 
            } 
        }  
         
        $sql1="select good_panels from $bai_pro3.bai_qms_day_report where qms_style=\"".$style."\" and qms_schedule=\"".$schedule."\" and qms_color=\"".$color."\" and qms_size=\"$size\""; 
    //echo $sql1."<br/>"; 
        $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_row1=mysqli_fetch_array($sql_result1)) 
        { 
            $good_panels=$sql_row1['good_panels']; 
        } 
         
         
         
         
        if(($qty+($qty_actual[array_search($size,$qty_act_sizes)]-$qty_req[array_search($size,$qty_req_sizes)]))>$good_panels and strlen($order_date)>0) 
        { 
            echo "<tr>"; 
            echo "<td>".$sql_row['ims_style']."</td>"; 
            echo "<td>".$sql_row['ims_schedule']."</td>"; 
            echo "<td>".$sql_row['ims_color']."</td>"; 
            echo "<td>".$order_date."</td>"; 
            echo "<td>".$size."</td>"; 
            echo "<td>$emb_title</td>"; 
            echo "<td>".($qty+($qty_actual[array_search($size,$qty_act_sizes)]-$qty_req[array_search($size,$qty_req_sizes)]))."</td>"; 
            echo "<td>".$good_panels."</td>"; 
            echo "<td>".(($qty+($qty_actual[array_search($size,$qty_act_sizes)]-$qty_req[array_search($size,$qty_req_sizes)]))-$good_panels)."</td>"; 
            echo "</tr>";
        }
        else
        {
            echo "<tr><td>No data found</td></tr>";
        }
         
    }         
echo "</table></div>"; 

?> 

<?php 

$cachefile = $path."/cutting/reports/".$cache_date.".html"; 
// open the cache file "cache/home.html" for writing 
$fp = fopen($cachefile, 'w'); 
// save the contents of output buffer to the file 
fwrite($fp, ob_get_contents()); 
// close the file 
fclose($fp); 
// Send the output to the browser 
ob_end_flush(); 

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
echo "<br>"."Execution took ".$duration." milliseconds.";
?>
</div></div>
</body> 
</html> 

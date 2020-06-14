<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/php/functions.php',4,'R'));?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',4,'R'));?>
<?php

$html = '';
$tabledata = '';
$sizes_reference="";
$cuttable_sum=0;
$style=style_decode($_GET['style']);
$schedule=$_GET['schedule'];
$color=color_decode($_GET['color']);
$serial_no=$_GET['serial_no'];
//To get Encoded Color & style
$main_style = style_encode($style);
$main_color = color_encode($color);

echo "<a class=\"btn btn-warning btn-xs\" href=\"".getFullURLLevel($_GET['r'], "recut_layplan_request.php", "0", "N")."&color=$main_color&style=$main_style&schedule=$schedule\"><i class=\"fas fa-arrow-left\"></i>&nbsp; Click here to Go Back</a>";
// echo "<a class=\"btn btn-xs btn-warning\" href=\"".getFullURLLevel($_GET['r'], "recut_layplan_request.php", "0", "N")."\"><i class=\"fas fa-arrow-left\"></i>&nbsp; Click here to Go Back</a>";

$qry_order_tid = "SELECT order_tid FROM `$bai_pro3`.`bai_orders_db` WHERE order_style_no = '$style' AND order_del_no ='$schedule' AND order_col_des = '$color'";
// echo $qry_order_tid;die();
$res_qry_order_tid = $link->query($qry_order_tid);
while($row_row_row = $res_qry_order_tid->fetch_assoc()) 
{
    $order_tid = $row_row_row['order_tid'];
}
// $sql111="select * from $bai_pro3.cuttable_stat_log_recut where order_tid=\"$order_tid\" and serial_no=$serial_no";	
// // echo $sql111;
// $sql_result111=mysqli_query($link, $sql111) or exit("Sql Error111".mysqli_error($GLOBALS["___mysqli_ston"]));
// if(mysqli_num_rows($sql_result111)>0){

$html .= "<div class='panel panel-primary'>
<div class='panel-heading'>Recut Layplan</div>
<div class='panel-body'>";

$html .= "<div class='row'><div class='col-md-4'><b>Style :</b> ".$style."</div><div class='col-md-4'><b>Schedule :</b> ".$schedule."</div><div class='col-md-4'><b>Color :</b> ".$color."</div></div><br/>";
$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result)>0)
{
    $sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";	
    $ord_tbl_name="$bai_pro3.bai_orders_db_confirm";
}
else
{
    $sql="select * from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";	
    $ord_tbl_name="$bai_pro3.bai_orders_db";
}
$sql_result=mysqli_query($link, $sql) or exit("Sql Error-0".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
    $tran_order_tid=$sql_row['order_tid'];
    $order_no=$sql_row['order_no'];
    $n_o_total = 0;
    $o_total = 0;
    if($order_no>0)
    {
        for($s=0;$s<sizeof($sizes_code);$s++)
        {
            $sizes_reference .= $sql_row["title_size_s".$sizes_code[$s].""].",";
            $n_s[$sizes_code[$s]]=$sql_row["old_order_s_s".$sizes_code[$s].""];
            $n_o_total += $sql_row["old_order_s_".$sizes_code[$s].""].",";
            $o_total += $sql_row["order_s_".$sizes_code[$s].""].",";
        }
    }
}

$sizes_reference=rtrim($sizes_reference,",");
$sql_cat="select * from $bai_pro3.cat_stat_log where order_tid=\"$tran_order_tid\" and category in ($in_categories)";
$sql_result_cat=mysqli_query($link, $sql_cat) or exit("Sql Error555".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row_cat=mysqli_fetch_array($sql_result_cat))
{
    $cat_ref_id=$sql_row_cat['tid'];
}
$o_total = 0;
$sql1="select * from $ord_tbl_name where order_tid=\"$tran_order_tid\"";
$sql_result=mysqli_query($link, $sql1) or exit("Sql Error55".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result))
{
    for($s=0;$s<sizeof($sizes_code);$s++)
    {
        if($sql_row1["title_size_s".$sizes_code[$s].""]<>'')
        {
            $s_tit[$sizes_code[$s]]=$sql_row1["title_size_s".$sizes_code[$s].""];
        }	
    }
    $sql1_recut="select sum(cuttable_s_s01) as \"s01\", sum(cuttable_s_s02) as \"s02\", sum(cuttable_s_s03) as \"s03\", sum(cuttable_s_s04) as \"s04\", sum(cuttable_s_s05) as \"s05\", sum(cuttable_s_s06) as \"s06\", sum(cuttable_s_s07) as \"s07\", sum(cuttable_s_s08) as \"s08\", sum(cuttable_s_s09) as \"s09\", sum(cuttable_s_s10) as \"s10\", sum(cuttable_s_s11) as \"s11\", sum(cuttable_s_s12) as \"s12\", sum(cuttable_s_s13) as \"s13\", sum(cuttable_s_s14) as \"s14\", sum(cuttable_s_s15) as \"s15\", sum(cuttable_s_s16) as \"s16\", sum(cuttable_s_s17) as \"s17\", sum(cuttable_s_s18) as \"s18\", sum(cuttable_s_s19) as \"s19\", sum(cuttable_s_s20) as \"s20\", sum(cuttable_s_s21) as \"s21\", sum(cuttable_s_s22) as \"s22\", sum(cuttable_s_s23) as \"s23\", sum(cuttable_s_s24) as \"s24\", sum(cuttable_s_s25) as \"s25\", sum(cuttable_s_s26) as \"s26\", sum(cuttable_s_s27) as \"s27\", sum(cuttable_s_s28) as \"s28\", sum(cuttable_s_s29) as \"s29\", sum(cuttable_s_s30) as \"s30\", sum(cuttable_s_s31) as \"s31\", sum(cuttable_s_s32) as \"s32\", sum(cuttable_s_s33) as \"s33\", sum(cuttable_s_s34) as \"s34\", sum(cuttable_s_s35) as \"s35\", sum(cuttable_s_s36) as \"s36\", sum(cuttable_s_s37) as \"s37\", sum(cuttable_s_s38) as \"s38\", sum(cuttable_s_s39) as \"s39\", sum(cuttable_s_s40) as \"s40\", sum(cuttable_s_s41) as \"s41\", sum(cuttable_s_s42) as \"s42\", sum(cuttable_s_s43) as \"s43\", sum(cuttable_s_s44) as \"s44\", sum(cuttable_s_s45) as \"s45\", sum(cuttable_s_s46) as \"s46\", sum(cuttable_s_s47) as \"s47\", sum(cuttable_s_s48) as \"s48\", sum(cuttable_s_s49) as \"s49\", sum(cuttable_s_s50) as \"s50\"  from $bai_pro3.cuttable_stat_log_recut  where order_tid=\"$tran_order_tid\" and cat_id=$cat_ref_id and serial_no=$serial_no group by cat_id";
   
    $sql1_res_recut=mysqli_query($link, $sql1_recut) or exit("Sql Error255".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row1_recut=mysqli_fetch_array($sql1_res_recut))
    {
        for($s=0;$s<sizeof($sizes_code);$s++)
        {
            $s_ord[$s]=$sql_row1_recut["s".$sizes_code[$s].""];
            $o_total += $sql_row1_recut["s".$sizes_code[$s]];
        }
    }
    
    $flag = $sql_row1['title_flag'];
}


$html .= "<table class=\"table table-bordered\">";
$html .= "<thead><tr><th class=\"column-title\" style='width:190px;'>Sizes</th>";
for($s=0;$s<sizeof($s_tit);$s++)
{
    $html .= "<th class=\"column-title\">".$s_tit[$sizes_code[$s]]."</th>";
}
$html .= "<th class=\"title\">Total</th>";
$html .= "</tr></thead>";
$html .= "<tr ><th class=\"heading2\">Quantity</th>";
for($s=0;$s<sizeof($s_tit);$s++)
{
    $html .= "<td class=\"sizes\">".$s_ord[$s]."</td>";

}

$html .= "<td class=\"sizes\">".$o_total."</td></tr>";
$html .= "</table>";

$sql="select *,COALESCE(binding_consumption,0) AS binding_con from $bai_pro3.cat_stat_log where order_tid IN (SELECT order_tid FROM $bai_pro3.bai_orders_db WHERE order_del_no ='$schedule')";
$cats_ids=array();
$sql_result=mysqli_query($link, $sql) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
    if($sql_row['category']<>'')
    {
        if(trim($tran_order_tid)==trim($sql_row['order_tid']))
        {
            $cats_ids[]=$sql_row['tid'];
        }
    }
}
//Encoding order_tid
$main_tran_order_tid=order_tid_encode($tran_order_tid);
$allocate_table = " <div class=\"row col-md-12\">
                            <div class=\"panel panel-info\">
                            <div class=\"panel-heading\" style=\"text-align:center;\">
                                <a data-toggle=\"collapse\" href=\"#Allocation\"><strong><b>Allocation</b></strong></a>
                            </div>
                            <div id=\"Allocation\" class=\"panel-collapse collapse-in collapse in\" aria-expanded=\"true\">
                            <div class=\"panel-body\">
                                <table class = 'col-sm-12 table-bordered table-striped table-condensed cf'>
                                    <thead>
                                    <tr>
                                        <th class=\"column-title\"><center>Category</center></th><th class=\"column-title\"><center>Cuttable</center></th>
                                        <th class=\"column-title\"><center>Allocated</center></center></th><th class=\"column-title\"><center>Excess /Shortage </center></th>
                                        <th class=\"column-title\"><center>Controls</center></th><th><center>Action</center></th>
                                    </tr>
                                    </thead><tbody>";
foreach($cats_ids as $key=>$value)
{
    $sql="select * from $bai_pro3.cuttable_stat_log_recut where order_tid=\"$tran_order_tid\" and cat_id=$value and serial_no=$serial_no order by tid";
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    while($sql_row=mysqli_fetch_array($sql_result))
    {
        $cat_id=$sql_row['cat_id'];
        $cuttable_ref=$sql_row['tid'];
        $serial_no=$sql_row['serial_no'];
        $cuttable_sum=0;
	    $total_allocated=0;

        $sql2="select * from $bai_pro3.cat_stat_log where tid=$cat_id order by catyy DESC";
        $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($sql_row2=mysqli_fetch_array($sql_result2))
        {
            $category_new=$sql_row2['category'];
            for($s=0;$s<sizeof($sizes_code);$s++)
            {
                $cuttable_sum += $sql_row["cuttable_s_s".$sizes_code[$s]];
            }
        }

        $sql2="select ((allocate_s01+allocate_s02+allocate_s03+allocate_s04+allocate_s05+allocate_s06+allocate_s07+allocate_s08+allocate_s09+allocate_s10+allocate_s11+allocate_s12+allocate_s13+allocate_s14+allocate_s15+allocate_s16+allocate_s17+allocate_s18+allocate_s19+allocate_s20+allocate_s21+allocate_s22+allocate_s23+allocate_s24+allocate_s25+allocate_s26+allocate_s27+allocate_s28+allocate_s29+allocate_s30+allocate_s31+allocate_s32+allocate_s33+allocate_s34+allocate_s35+allocate_s36+allocate_s37+allocate_s38+allocate_s39+allocate_s40+allocate_s41+allocate_s42+allocate_s43+allocate_s44+allocate_s45+allocate_s46+allocate_s47+allocate_s48+allocate_s49+allocate_s50)*plies) as \"total\" from $bai_pro3.allocate_stat_log left join cat_stat_log on  allocate_stat_log.order_tid=cat_stat_log.order_tid where allocate_stat_log.order_tid=\"$tran_order_tid\" and allocate_stat_log.cuttable_ref='$cuttable_ref' and cat_stat_log.category in ($in_categories) and allocate_stat_log.recut_lay_plan='yes' and serial_no=$serial_no ";
        $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $sql_num_check2=mysqli_num_rows($sql_result2);
        while($sql_row2=mysqli_fetch_array($sql_result2))
        {
            $total_allocated=$total_allocated+$sql_row2['total'];
        }
        

        $allocate_table .= "<tr>";
        // $allocate_table .= "<td class=\"  \"><center>".$category_new."&nbsp;<span class=\"fas fa-external-link-alt\" style=\"cursor: pointer;\" data-toggle=\"tooltip\" title=\"Click Here To Get Category wise Ratio Details\" onclick=\"return popup("."'".$path44."'".")\"></span></center></td>";
        $allocate_table .= "<td class=\"  \"><center>".$category_new."</center></td>";
        $allocate_table .= "<td class=\"  \"><center>".$cuttable_sum."</center></td>";
        $allocate_table .= "<td class=\"  \"><center>".$total_allocated."</center></td>";
        $total_cuttable_qty=$total_allocated-$cuttable_sum;
        if($total_cuttable_qty<0)
        {
            $allocate_table .= "<td class=\"  \" style='background-color:#f8d7da'><center>".$total_cuttable_qty."</center></td>";
        }
        else
        {
            $allocate_table .= "<td class=\"b1\" style='background-color:#4cff4c'><center>".$total_cuttable_qty."</center></td>";
        }
        $allocate_table .= "<td class=\"  \"><center><a class=\"btn btn-xs btn-info\" href=\"".getFullURL($_GET['r'], "order_allocation_form2.php", "N")."&tran_order_tid=$main_tran_order_tid&check_id=$cuttable_ref&cat_id=$cat_id&total_cuttable_qty=$total_cuttable_qty&serial_no=$serial_no\">Add Ratios</a></center></td>";

        $pliespercut=0;
        $sql15="select * from bai_pro3.allocate_stat_log where cat_ref=$cat_id and recut_lay_plan='yes' and serial_no=$serial_no";
        $sql_result15=mysqli_query($link, $sql15) or exit("Sql Error32".mysqli_error($GLOBALS["___mysqli_ston"]));
        $cut_count = mysqli_num_rows($sql_result15);
        while($sql_row15=mysqli_fetch_array($sql_result15))
        {
            $pliespercut+=$sql_row15['pliespercut'];
        }

        $sql16="select * from bai_pro3.cuttable_stat_log_recut where order_tid=\"$tran_order_tid\" and serial_no=$serial_no";
        $sql_result16=mysqli_query($link, $sql16) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        $cut_count1 = mysqli_num_rows($sql_result16);
        $copy_status = 0;
        if($total_allocated>0){
            $copy_status = 1;
        }
        if(($cut_count>=1 && $cut_count1>1)&& $copy_status != 0) {
            if(($cut_count==$cut_count1)&&($cut_count<0)&&($cuttable_sum>$pliespercut)){
                $allocate_table .= "<td class=\"  \"><center><a class='btn btn-info btn-xs' disabled>Copy to Other</a></center></td>";
            }
            else {
                $allocate_table .= "<td class=\"  \"><center><a class='btn btn-info btn-xs'  href=\"".getFullURL($_GET['r'], "save_categories.php", "N")."&tran_order_tid=$main_tran_order_tid&check_id=$cuttable_ref&cat_id=$cat_id&total_cuttable_qty=$total_cuttable_qty&total_allocated=$total_allocated&serial_no=$serial_no\">Copy to Other</a></center></td>";
            }
        }
        else {
            $allocate_table .= "<td class=\"  \"><center><a class='btn btn-info btn-xs' disabled>Copy to Other</a></center></td>";
        }

       
        $allocate_table .= "</tr>";
        

    }
}
$allocate_table .= "</tbody></table>
                </div>
            </div>
        </div></div><br/>";
$ratios_table = "<div class=\"row col-md-12\">
                    <div class=\"panel panel-info\">
                    <div class=\"panel-heading\" style=\"text-align:center;\">
                        <a data-toggle=\"collapse\" href=\"#Ratios\"><strong><b>Ratios</b></strong></a>
                    </div>
                    <div id=\"Ratios\" class=\"panel-collapse collapse-in collapse in\" aria-expanded=\"true\">
                        <div class=\"panel-body\">";

if($flag== 1)
{
	$ratios_table .=  "<div class=\"table-responsive\"><table class=\"table table-bordered\"><thead><tr><th class=\"column-title\"><center>Ratio</center></th><th class=\"column-title\"><center>Category</center></th><th class=\"column-title\"><center>Total Plies</center></th><th class=\"column-title\"><center>Max Plies/Cut</center></th>";
	for($s=0;$s<sizeof($s_tit);$s++)
	{
		$ratios_table .=  " <th class=\"column-title\"><center>".$s_tit[$sizes_code[$s]]."</center></th>";
	}
	$ratios_table .=  "<th class=\"column-title\"><center>Ratio Total</center></th><th class=\"column-title\"><center>Controls</center></th></tr></thead><tbody>";
}
else
{
	$ratios_table .=  "<div class=\"table-responsive\"><table class=\"table table-bordered\"><center><thead><tr><th class=\"column-title\"><center>Ratio#</center></th><th class=\"column-title\"><center>Category</center></th><th class=\"column-title\"><center>Total Plies</center></th>
	<th class=\"column-title\"><center>01</center></th><th class=\"column-title\"><center>02</center></th><th class=\"column-title\"><center>03</center></th><th class=\"column-title\"><center>04</center></th><th class=\"column-title\"><center>05</center></th><th class=\"column-title\"><center>06</center></th><th class=\"column-title\"><center>07</center></th><th class=\"column-title\"><center>08</center></th><th class=\"column-title\"><center>09</center></th><th class=\"column-title\"><center>10</center></th><th class=\"column-title\"><center>11</center></th><th class=\"column-title\"><center>12</center></th><th class=\"column-title\"><center>13</center></th><th class=\"column-title\"><center>14</center></th><th class=\"column-title\"><center>15</center></th><th class=\"column-title\"><center>16</center></th><th class=\"column-title\"><center>17</center></th><th class=\"column-title\"><center>18</center></th><th class=\"column-title\"><center>19</center></th><th class=\"column-title\"><center>20</center></th><th class=\"column-title\"><center>21</center></th><th class=\"column-title\"><center>22</center></th><th class=\"column-title\"><center>23</center></th><th class=\"column-title\"><center>24</center></th><th class=\"column-title\"><center>25</center></th><th class=\"column-title\"><center>26</center></th><th class=\"column-title\"><center>27</center></th><th class=\"column-title\"><center>28</center></th><th class=\"column-title\"><center>29</center></th><th class=\"column-title\"><center>30</center></th><th class=\"column-title\"><center>31</center></th><th class=\"column-title\"><center>32</center></th><th class=\"column-title\"><center>33</center></th><th class=\"column-title\"><center>34</center></th><th class=\"column-title\"><center>35</center></th><th class=\"column-title\"><center>36</center></th><th class=\"column-title\"><center>37</center></th><th class=\"column-title\"><center>38</center></th><th class=\"column-title\"><center>39</center></th><th class=\"column-title\"><center>40</center></th><th class=\"column-title\"><center>41</center></th><th class=\"column-title\"><center>42</center></th><th class=\"column-title\"><center>43</center></th><th class=\"column-title\"><center>44</center></th><th class=\"column-title\"><center>45</center></th><th class=\"column-title\"><center>46</center></th><th class=\"column-title\"><center>47</center></th><th class=\"column-title\"><center>48</center></th><th class=\"column-title\"><center>49</center></th><th class=\"column-title\"><center>50</center></th>
	<th class=\"column-title\"><center>Ratio Total</center></th><th class=\"column-title\"><center>Controls</center></th><th class=\"column-title\"><center>Current Status</center></th><th class=\"column-title\"><center>Remarks</center></th></tr></thead><tbody>";
}
$used_fabric =0;
//Encoding order_tid
$main_tran_order_tid=order_tid_encode($tran_order_tid);
foreach($cats_ids as $key=>$value)
{
			
	$tot_size=array();
	$sql="select * from $bai_pro3.allocate_stat_log where order_tid=\"$tran_order_tid\" and cat_ref=$value  and recut_lay_plan='yes' and serial_no=$serial_no order by tid";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// echo $sql;z
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
    $temp = 0;
    
    while($sql_row=mysqli_fetch_array($sql_result))
    { 
		$mk_status=$sql_row['mk_status'];
		
		$check_id=$sql_row['cuttable_ref'];
		$ratios_table .=  "<tr>";
		// echo "<td class=\"  \"><center>".$sql_row['tid']."</center></td>";
		//echo "<td class=\" \"><center>".$check_id."</center></td>";
		$ratios_table .= "<td class=\"  \"><center>".$sql_row['ratio']."</center></td>";	
		$cat_ref=$sql_row['cat_ref'];
		$sql2="select *,COALESCE(binding_consumption,0) AS binding_con from $bai_pro3.cat_stat_log where tid=$cat_ref order by catyy ";
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$cat_yy=$sql_row2['catyy'];
			$category=$sql_row2['category'];
			$mo_status=$sql_row2['mo_status'];
			$binding_consumption=$sql_row2['binding_con'];		
		}
		$ratios_table .= "<td class=\"  \"><center>".$category."</center></td>";
		$ratios_table .= "<td class=\"  \"><center>".$sql_row['plies']."</td><td class=\"  \"><center>".$sql_row['pliespercut']."</center></td>";
		$tot=0;
		for($s=0;$s<sizeof($s_tit);$s++)
		{
			$ratios_table .= "<td class=\"  \"><center>".$sql_row["allocate_s".$sizes_code[$s].""]."</center></td>";
			$tot+=$sql_row["allocate_s".$sizes_code[$s].""];
			$tot_size[$s_tit[$sizes_code[$s]]] = (int)$tot_size[$s_tit[$sizes_code[$s]]]+((int)$sql_row['plies']*(int)$sql_row["allocate_s".$sizes_code[$s].""]);
		}
		$used_yards[$category][$sql_row['ratio']] = $sql_row['plies'] * $tot * $binding_consumption;
		$ratios_table .= "<td class=\"  \"><center>".$tot."</center></td>";
		if($sql_row['mk_status']==9)
		{
			$ratios_table .= "<td class=\"  \"><center>Lay Plan Prepared</center></td>";
		}
		else
		{
			$ratios_table .= "<td class=\"  \"><center>";
			$sql21="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$tran_order_tid\" and allocate_ref='".$sql_row['tid']."'";
			$sql_result21=mysqli_query($link, $sql21) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result21)==0)
			{
				$ratios_table .= "<a class=\"btn btn-xs btn-info\" href=\"".getFullURL($_GET['r'], "order_allocation_form2_edit.php", "N")."&check_id=".$check_id."&tran_order_tid=".$main_tran_order_tid."&cat_id=".$cat_id."&ref_id=".$sql_row['tid']."&serial_no=$serial_no\">Edit</a>";
			}
			else
			{
				$mk_status=9;
				$ratios_table .= "Lay Plan Prepared";

			}
			$ratios_table .= "</center></td>";
		}
		
		// $sql3 ="select * from $bai_pro3.sp_sample_order_db where order_tid='$tran_order_tid'";
		// $sql_result3=mysqli_query($link, $sql3) or exit("Sql Error e".mysqli_error($GLOBALS["___mysqli_ston"]));
		// while($sql_row3=mysqli_fetch_array($sql_result3))
	    // {
		//     $input_qty[$sql_row3['size']] = $sql_row3['input_qty'];		
	    // }			
		$ratios_table .= "</tr>";
		$allc_ref = $sql_row['tid'];
		$sql2="select * from $bai_pro3.maker_stat_log where allocate_ref=$allc_ref and cuttable_ref > 0 and recut_lay_plan='yes'";
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error323".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{		
			$used_fabric+=$sql_row2['mklength'] * $sql_row['plies'];	
        }
        $temp = 1;
    }	
    if($temp == 1){

        $ratios_table .= "<tr><td colspan=3> Total Planned Quantity</center><td>";
        for($s=0;$s<sizeof($s_tit);$s++)
        {
            if ($tot_size[$s_tit[$sizes_code[$s]]] >= 0)
            {
                $ratios_table .= "<td class=\"  \" style='background-color:#4cff4c'><center>".$tot_size[$s_tit[$sizes_code[$s]]] ."</center></td>";
            }
            else
            {
                $ratios_table .= "<td class=\"b1\" style='background-color:#f8d7da'><center>".$tot_size[$s_tit[$sizes_code[$s]]]."</center></td>";
            }
        }	
        $ratios_table .= "<td class=\"  \"><center></center></td><td class=\"  \"><center></center></td><tdclass=\"  \"><center></center></td></tr>";
        $ratios_table .= "<tr><td colspan=3>Excess / Less <td>";
        for($s=0;$s<sizeof($s_tit);$s++)
        {
            
            if($input_qty[$s_tit[$sizes_code[$s]]]=='')
            {
                $input_qty[$s_tit[$sizes_code[$s]]]=0;
            }
            if ($tot_size[$s_tit[$sizes_code[$s]]]-($input_qty[$s_tit[$sizes_code[$s]]]+$s_ord[$s]) >= 0)
            {
                $ratios_table .= "<td class=\"  \" style='background-color:#4cff4c'><center>".($tot_size[$s_tit[$sizes_code[$s]]]-($input_qty[$s_tit[$sizes_code[$s]]]+$s_ord[$s]))."</center></td>";
            }
            else
            {
                $ratios_table .= "<td class=\"b1\" style='background-color:#f8d7da'><center>".($tot_size[$s_tit[$sizes_code[$s]]]-($input_qty[$s_tit[$sizes_code[$s]]]+$s_ord[$s]))."</center></td>";
            }
        }
        unset($tot_size);
        unset($input_qty);		
        $ratios_table .= "<td class=\"  \"><center></center></td><td class=\"  \"><center></center></td></tr>";
    }

}
$ratios_table .= "</tbody></table>
                </div>
                </div>
                </div></div>";

$marker_table = "<div class=\"row col-md-12\">
                <div class=\"panel panel-info\">
                <div class=\"panel-heading\" style=\"text-align:center;\">
                    <a data-toggle=\"collapse\" href=\"#Marker\"><strong><b>Marker</b></strong></a>
                </div>
                <div id=\"Marker\" class=\"panel-collapse collapse-in collapse in\" aria-expanded=\"true\">
                    <div class=\"panel-body\">
                        <div style=\"overflow-x:auto;\">
                            
                        <table  class=\"table table-bordered\" style=\"overflow-x:auto;\">
                        <thead>
                            <tr>
                                <th class=\"word-wrap\"><center>Ratio Ref</center></th>
                                <th class=\"column-title\"><center>Category</center></th>
                                <th class=\"word-wrap\"><center>Lay Length</center></th><th class=\"word-wrap\"><center>Marker EFF%</center></th>
                                <th class=\"column-title\"><center>Version</center></th><th class=\"column-title\"><center>Controls</center></th>
                                <th class=\"word-wrap\"><center>Delete Control</center></th>
                            </tr>
                        </thead><tbody>";
                        
if($order_no == "1"){
    $orderqty = $n_o_total;
}else{
    $orderqty = $o_total;
}
$total_fabric_req = $cat_yy * $orderqty;
$overall_savings = round(((($total_fabric_req-$used_fabric)/$total_fabric_req)*100),0);
$overall_cad_consumption = round($used_fabric/$orderqty,4);
$dummy = 0;
$tran_order_tid1=$tran_order_tid;
$doc_generated_ids=array();
foreach($cats_ids as $key=>$value)
{
    $get_cat_ref_query="SELECT cat_ref,tid,cuttable_ref,mk_status,remarks FROM $bai_pro3.allocate_stat_log WHERE order_tid=\"$tran_order_tid1\" and serial_no=$serial_no and cat_ref=$value and recut_lay_plan='yes' ORDER BY tid";
    $cat_ref_result=mysqli_query($link, $get_cat_ref_query) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($cat_row=mysqli_fetch_array($cat_ref_result))
    {
        $doc_generated_ids[]=$cat_row['tid'];
        $grand_tot_used_fab = 0;
        $grand_tot_used_binding = 0;
        // $sql="select * from $bai_pro3.allocate_stat_log where order_tid=\"$tran_order_tid1\" and cat_ref=".$cat_row['cat_ref']." and recut_lay_plan='yes' and serial_no=$serial_no ORDER BY ratio";
        // $sql_result=mysqli_query($link, $sql) or exit("Sql Error111".mysqli_error($GLOBALS["___mysqli_ston"]));
        // while($sql_row=mysqli_fetch_array($sql_result))
        // {
            $cat_ref1=$cat_row['cat_ref'];
            $cuttable_ref1=$cat_row['cuttable_ref'];
            $allocate_ref1=$cat_row['tid'];
            $mk_status1=$cat_row['mk_status'];
            $remarks1=$cat_row['remarks'];
                
            $mklength1=0;
            $mkeff1=0;
            $mk_ref1=0;

            $sql2="select * from $bai_pro3.maker_stat_log where allocate_ref=$allocate_ref1 and cuttable_ref > 0";
            $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($sql_row2=mysqli_fetch_array($sql_result2))
            {
                $mklength1=$sql_row2['mklength'];
                $mkeff1=$sql_row2['mkeff'];
                $mk_ref1=$sql_row2['tid'];
                $mk_remarks1=$sql_row2['remarks'];
                $mk_version=$sql_row2['mk_ver'];
                $remark1=$sql_row2['remark1'];
                $remark2=$sql_row2['remark2'];
                $remark3=$sql_row2['remark3'];
                $remark4=$sql_row2['remark4'];
        
            }

            $sql2="select *,COALESCE(binding_consumption,0) AS binding_con from $bai_pro3.cat_stat_log where tid=$cat_ref1 order by lastup";
            $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($sql_row2=mysqli_fetch_array($sql_result2))
            {
                $cat_yy1=$sql_row2['catyy'];
                $category1=$sql_row2['category'];
                $binding_consumption=$sql_row2['binding_con'];
            }

            $sql2="select * from $bai_pro3.allocate_stat_log where tid=$allocate_ref1  and recut_lay_plan='yes' and serial_no=$serial_no";
            $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error1116".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($sql_row2=mysqli_fetch_array($sql_result2))
            {
                $ratio=$sql_row2['ratio'];
            }
            $marker_table .=  "
            <tr class=\"  \">";
                //$marker_table .=  "<td class=\"  \"><center>".$mk_ref1."</center></td>";
                $marker_table .=  "<td class=\"  \"><center>".$ratio."</center></td>";
                $marker_table .=  "<td class=\"  \"><center>".$category1."</center></td>";
                // $marker_table .=  "<td class=\"  \"><center>".$sql_row['tid']."</center></td>";
                // $marker_table .=  "<td class=\"  \"><center>".$sql_row['cat_ref']."</center></td>";
                // $marker_table .=  "<td class=\"  \"><center>".$cuttable_ref1."</center></td>";
                $marker_table .=  "<td class=\"  \"><center>".$mklength1."</center></td>";
                
                $marker_table .=  "<td class=\"  \"><center>".$mkeff1."</center></td>";
                $marker_table .=  "<td class=\"  \"><center>".$mk_version."</center></td>";

                if($mk_ref1==0)
                {
                    $marker_table .=  "<td class=\"  \"><center><a class=\"btn btn-xs btn-primary\" href=\"".getFullURL($_GET['r'], "order_makers_form2.php", "N")."&tran_order_tid=$main_tran_order_tid&cat_ref=$cat_ref1&cuttable_ref=$cuttable_ref1&allocate_ref=$allocate_ref1&serial_no=$serial_no\">Create</a>";
                }
                else
                {
                    $marker_table .= "<td class=\"  \"><center>Updated</center></td>";
                }	
                $sql21="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$tran_order_tid1\" and mk_ref=$mk_ref1 and remarks='Recut' and mk_ref_id!=''";
                // echo $sql21;    
                $sql_result21=mysqli_query($link, $sql21) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                if(mysqli_num_rows($sql_result21)==0)
                {
                    $dummy++;
                    $marker_table .=  "<td class=\"  \"><center><a id='delete_form$dummy' class=\"btn btn-xs btn-danger confirm-submit\" href=\"".getFullURL($_GET['r'], "delete_id.php", "N")."&tran_order_tid=$main_tran_order_tid&cat_ref=$cat_ref1&cuttable_ref=$cuttable_ref1&allocate_ref=$allocate_ref1&mk_ref=$mk_ref1&serial_no=$serial_no\">Delete</a>";
                }
                else
                {
                    $marker_table .=  "<td class=\"word-wrap\"><center>Lay plan Prepared";		
                }	
                
                $sql2="select * from $bai_pro3.allocate_stat_log where order_tid=\"$tran_order_tid1\" and tid=$allocate_ref1  and serial_no=$serial_no and recut_lay_plan='yes' ";
                $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($sql_row2=mysqli_fetch_array($sql_result2))
                {	
                    if($sql_row2['pliespercut']>0)
                    {			
                        $cutcount1=ceil($sql_row2['plies']/$sql_row2['pliespercut']);
                    }
                            
                    // $totalplies1=$sql_row2['allocate_s01']+$sql_row2['allocate_s02']+$sql_row2['allocate_s03']+$sql_row2['allocate_s04']+$sql_row2['allocate_s05']+$sql_row2['allocate_s06']+$sql_row2['allocate_s07']+$sql_row2['allocate_s08']+$sql_row2['allocate_s09']+$sql_row2['allocate_s10']+$sql_row2['allocate_s11']+$sql_row2['allocate_s12']+$sql_row2['allocate_s13']+$sql_row2['allocate_s14']+$sql_row2['allocate_s15']+$sql_row2['allocate_s16']+$sql_row2['allocate_s17']+$sql_row2['allocate_s18']+$sql_row2['allocate_s19']+$sql_row2['allocate_s20']+$sql_row2['allocate_s21']+$sql_row2['allocate_s22']+$sql_row2['allocate_s23']+$sql_row2['allocate_s24']+$sql_row2['allocate_s25']+$sql_row2['allocate_s26']+$sql_row2['allocate_s27']+$sql_row2['allocate_s28']+$sql_row2['allocate_s29']+$sql_row2['allocate_s30']+$sql_row2['allocate_s31']+$sql_row2['allocate_s32']+$sql_row2['allocate_s33']+$sql_row2['allocate_s34']+$sql_row2['allocate_s35']+$sql_row2['allocate_s36']+$sql_row2['allocate_s37']+$sql_row2['allocate_s38']+$sql_row2['allocate_s39']+$sql_row2['allocate_s40']+$sql_row2['allocate_s41']+$sql_row2['allocate_s42']+$sql_row2['allocate_s43']+$sql_row2['allocate_s44']+$sql_row2['allocate_s45']+$sql_row2['allocate_s46']+$sql_row2['allocate_s47']+$sql_row2['allocate_s48']+$sql_row2['allocate_s49']+$sql_row2['allocate_s50'];
                    $totalplies1=$sql_row2['plies'];

                    $ratiotot=0;
                    for($s=0;$s<sizeof($s_tit);$s++)
                    {
                        $ratiotot+=$sql_row["allocate_s".$sizes_code[$s].""];
                    }
                }
                
                $cad_consumption = $mklength1/$ratiotot;
                $realYY = $cat_yy1-$binding_consumption;
                $usedFabric = $mklength1*$totalplies1;
                if($cat_yy1>0 and $totalplies1>0)
                {
                    $savings1=round((($realYY-$cad_consumption)/$realYY)*100,0);
                }
                else
                {
                    $savings1=0;
                }
                // $marker_table .=  "<td class=\"  \"><center>".$savings1."%</center></td>";
                // $marker_table .=  "<td class=\"  \"><center>".round($cad_consumption,4)."</center></td>";
                // $marker_table .=  "<td class=\"  \"><center>".round($usedFabric,2)."</center></td>";
                // $marker_table .=  "<td class=\"  \"><center>".$used_yards[$category1][$ratio]."</center></td>";

                $grand_tot_used_fab = $grand_tot_used_fab + round($usedFabric,2);
                $grand_tot_used_binding = $grand_tot_used_binding + $used_yards[$category1][$ratio];
                    
                // switch ($mk_status1)
                // {
                //     case 1:
                //     {
                //         $marker_table .=  "<td class=\"  \"><center>NEW</center></td>";
                //         break;
                //     }
                        
                //     case 2:
                //     {
                //         $marker_table .=  "<td class=\"  \"><center>VERIFIED</center></td>";
                //         break;
                //     }
                        
                //     case 3:
                //     {
                //         $marker_table .=  "<td class=\"  \"><center>REVISE</center></td>";
                //         break;
                //     }
                //     case 9:
                //     {
                //         $marker_table .=  "<td class=\"  \"><center>Docket Generated</center></td>";
                //         break;
                //     }
                //     default:
                //     {
                //         $marker_table .=  "<td class=\"  \"><center>NEW</center></td>";
                //         break;
                //     }
                // }

                // $marker_table .=  "<td class=\"word-wrap\"><center>".$mk_remarks1."</center></td>";
                // $marker_table .=  "<td class=\"word-wrap\"><center>".$remark1."</center></td>";
                // $marker_table .=  "<td class=\"word-wrap\"><center>".$remark2."</center></td>";
                // $marker_table .=  "<td class=\"word-wrap\"><center>".$remark3."</center></td>";
                // $marker_table .=  "<td class=\"word-wrap\"><center>".$remark4."</center></td>";
                $marker_table .=  "
            </tr>";
        // }
        // $marker_table .=  "<tr style='background-color: yellow;'><td colspan=3><center><b>Total ($category1) </b></center></td><td><center><b>$grand_tot_used_fab</b></center></td><td><center><b>$grand_tot_used_binding</b></center></td><td colspan=6></td></tr>";
    }
}
$marker_table .= "</tbody></table>
                        </div>
                    </div>
                </div>
            </div></div>";

$docket_creation ="
<div class=\"col-sm-12 row\">
	<div class = \"panel panel-info\">
		<div class=\"panel-heading\" style=\"text-align:center;\">
				<a data-toggle=\"collapse\" href=\"#docket_creation\"><strong><b>Docket Creation / Edit</b></strong></a>
			</div>
			<div id=\"docket_creation\" class=\"panel-collapse collapse-in collapse in\" aria-expanded=\"true\">
                <div class=\"panel-body\">";
 

$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result)>0)
{
	$ord_tbl_name="bai_orders_db_confirm";	
}
else{
	$ord_tbl_name="bai_orders_db";		
}


$docket_creation .= "<div><table class=\"table table-bordered\">";

$docket_creation .= "<thead><tr><th class=\"column-title \"><center>Category</center></th><th class=\"column-title \"><center>Total Cut</center></th><th class=\"column-title \"><center>Ratio Ref</center></th><th class=\"column-title \"><center>MO Status</center></th><th class=\"column-title \"><center>Control</center></th></tr></thead>";
if(sizeof($doc_generated_ids) > 0){
    $doc_generated_ids=implode(",",$doc_generated_ids);
    $sql="select * from $bai_pro3.maker_stat_log where order_tid=\"$tran_order_tid\" and allocate_ref in ($doc_generated_ids) and recut_lay_plan='yes' order by allocate_ref";

    $sql_result=mysqli_query($link, $sql) or exit("Sql Error777".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql_num_check=mysqli_num_rows($sql_result);
    while($sql_row=mysqli_fetch_array($sql_result))
    {
        $mkref=$sql_row['tid'];
        $docket_creation .= "<tr>";
        // <td class=\"  \"><center>".$mkref."</center></td>";
        $allocate_ref=$sql_row['allocate_ref'];
        $cutcount=0;
        $mklength=$sql_row['mklength'];
        $cat_ref=$sql_row['cat_ref'];
        
        $sql2="select * from $bai_pro3.cat_stat_log where tid=$cat_ref order by catyy DESC";
        $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($sql_row2=mysqli_fetch_array($sql_result2))
        {
                $cat_yy=$sql_row2['catyy'];
                $category=$sql_row2['category'];
                $mo_status=$sql_row2['mo_status'];
        }

        $docket_creation .= "<td class=\"  \"><center>".$category."</center></td>";
        
        $sql2="select * from $bai_pro3.allocate_stat_log where order_tid=\"$tran_order_tid\"   and recut_lay_plan='yes' and serial_no=$serial_no and tid=$allocate_ref";
        $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error32".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($sql_row2=mysqli_fetch_array($sql_result2))
        {
            $ratio=$sql_row2['ratio'];
            if($sql_row2['pliespercut']>0)
            {			
                $cutcount=ceil($sql_row2['plies']/$sql_row2['pliespercut']);
            }
            $docket_creation .= "<td class=\"  \"><center>".$cutcount."</center></td>";
            $docket_creation .= "<td class=\"  \"><center>".$ratio."</center></td>";
            
            $totalplies=$sql_row2['allocate_s01']+$sql_row2['allocate_s02']+$sql_row2['allocate_s03']+$sql_row2['allocate_s04']+$sql_row2['allocate_s05']+$sql_row2['allocate_s06']+$sql_row2['allocate_s07']+$sql_row2['allocate_s08']+$sql_row2['allocate_s09']+$sql_row2['allocate_s10']+$sql_row2['allocate_s11']+$sql_row2['allocate_s12']+$sql_row2['allocate_s13']+$sql_row2['allocate_s14']+$sql_row2['allocate_s15']+$sql_row2['allocate_s16']+$sql_row2['allocate_s17']+$sql_row2['allocate_s18']+$sql_row2['allocate_s19']+$sql_row2['allocate_s20']+$sql_row2['allocate_s21']+$sql_row2['allocate_s22']+$sql_row2['allocate_s23']+$sql_row2['allocate_s24']+$sql_row2['allocate_s25']+$sql_row2['allocate_s26']+$sql_row2['allocate_s27']+$sql_row2['allocate_s28']+$sql_row2['allocate_s29']+$sql_row2['allocate_s30']+$sql_row2['allocate_s31']+$sql_row2['allocate_s32']+$sql_row2['allocate_s33']+$sql_row2['allocate_s34']+$sql_row2['allocate_s35']+$sql_row2['allocate_s36']+$sql_row2['allocate_s37']+$sql_row2['allocate_s38']+$sql_row2['allocate_s39']+$sql_row2['allocate_s40']+$sql_row2['allocate_s41']+$sql_row2['allocate_s42']+$sql_row2['allocate_s43']+$sql_row2['allocate_s44']+$sql_row2['allocate_s45']+$sql_row2['allocate_s46']+$sql_row2['allocate_s47']+$sql_row2['allocate_s48']+$sql_row2['allocate_s49']+$sql_row2['allocate_s50'];
            $remarks=$sql_row2['remarks'];

            $ratiotot=0;
            for($s=0;$s<sizeof($s_tit);$s++)
            {
                $ratiotot+=$sql_row2["allocate_s".$sizes_code[$s].""];
            }
        }

        if($mo_status=="Y")
        {
            $docket_creation .= "<td class=\"  \" align='center'><span class='label label-success'>YES</span></td>";
        }
        else
        {
            $docket_creation .= "<td class=\"  \" align='center'><span class='label label-danger'>NO</span></td>";
        }
        

        $sql2="select count(pcutdocid) as \"count\" from $bai_pro3.plandoc_stat_log where order_tid=\"$tran_order_tid\" and allocate_ref=$allocate_ref ";
        $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($sql_row2=mysqli_fetch_array($sql_result2))
        {
            if($sql_row2['count']==0 && $mo_status=="Y" && $cutcount>0 && $totalplies>0)
            {
                $docket_creation .= "<td class=\"  \"><center><a class=\"btn btn-xs btn-primary\" href=\"".getFullURL($_GET['r'], "recut_doc_gen_form.php", "N")."&tran_order_tid=$main_tran_order_tid&mkref=$mkref&allocate_ref=$allocate_ref&cat_ref=$cat_ref&color=$main_color&schedule=$schedule&serial_no=$serial_no\">Generate</a></center></td>";
            }
            else
            {
                $docket_creation .= "<td ><center><span class='label label-info'>Docket Generated</span></center></td>";	
            }
        }
        
        
        $cad_consumption = $mklength/$ratiotot;
        $realYY = $cat_yy-$bind_con;

        if($totalplies>0 and $cat_yy>0)
        {
            $savings=round((($realYY-$cad_consumption)/$realYY)*100,0);		
        }
        
        $docket_creation .= "</tr>";
    }
}

$docket_creation .= "</table></div></div>
</div>
</div>
</div>";

$html .= $allocate_table;
$html .= $ratios_table;
$html .= $marker_table;
$html .= $docket_creation;

$html .= "</div></div>";
echo $html;
// }  else {
//     echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",2000); function Redirect(){
//         sweetAlert('Recut is not Yet Raised','','error');	 
//         location.href = \"".getFullURLLevel($_GET['r'], "recut_dashboard_view.php", "0", "N")."\"; }</script>";
// }
?>
<script>

function popup(Site)
{
	window.open(Site,'PopupName','toolbar=no,statusbar=yes,menubar=yes,location=no,scrollbars=yes,resizable=yes,width=775,height=700');
}
</script>
<style>
.word-wrap {
		word-wrap: break-word; 
		white-space: normal !important; 
    }
    .no-wrap {
        white-space: nowrap;
    }
    .fixed {
        table-layout: fixed;
    }
</style>
<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	$view_access=user_acl("SFCS_0245",$username,1,$group_id_sfcs); 
?>

<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',4,'R'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',4,'R'); ?>"></script>

<style>
table {	
	text-align:center;
	font-size:12px;
	width:100%;
	padding: 1em 1em 1em 1em;
	color:black;
}
th{
	background-color:#29759c;
	color:white;
	text-align:center;
}
</style>
<div class="panel panel-primary">
<div class="panel-heading">Cutting WIP</div>
<div class="panel-body">

<?php

echo "<div class='table-responsive'><table class='table table-bordered' id='table2'><thead><tr><th>Buyer Division</th><th>Style</th><th>CO</th><th>Schedule</th><th>Color</th><th>Cutting Wip</th><th>EX-Factory</th></tr><thead>";

$sql="select order_tid,group_concat(doc_no) as doc_no,SUM((a_xs+a_s+a_m+a_l+a_xl+a_xxl+a_xxxl+a_s01+a_s02+a_s03+a_s04+a_s05+a_s06+a_s07+a_s08+a_s09+a_s10+a_s11+a_s12+a_s13+a_s14+a_s15+a_s16+a_s17+a_s18+a_s19+a_s20+a_s21+a_s22+a_s23+a_s24+a_s25+a_s26+a_s27+a_s28+a_s29+a_s30+a_s31+a_s32+a_s33+a_s34+a_s35+a_s36+a_s37+a_s38+a_s39+a_s40+a_s41+a_s42+a_s43+a_s44+a_s45+a_s46+a_s47+a_s48+a_s49+a_s50)*a_plies) AS pcs from $bai_pro3.order_cat_doc_mk_mix where act_cut_status='DONE'and date >= '2015-01-01' and act_cut_issue_status!='DONE' and category in ('Body','Front') group by order_tid order by doc_no";
$result=mysqli_query($link, $sql) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($result))
{
	$order_tid=$row["order_tid"];
	$sql1="select co_no from $bai_pro3.bai_orders_db where order_tid=\"".$order_tid."\"";
	$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$co_no=$row1["co_no"];
	}	


	$sql1="select order_div,order_style_no,order_del_no,order_col_des,order_date from $bai_pro3.bai_orders_db_confirm where order_tid=\"".$order_tid."\"";
	$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($result1)==0)
	{
		$sql1="select order_div,order_style_no,order_del_no,order_col_des,order_date from $bai_pro3.bai_orders_db_confirm_archive where order_tid=\"".$order_tid."\"";
	}
	$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$buyer=$row1["order_div"];
		$order_style_no=$row1["order_style_no"];
		$order_del_no=$row1["order_del_no"];
		$order_col_des=$row1["order_col_des"];
		$order_date=$row1["order_date"];
	}	
	$dockets=$row["doc_no"];
	$total3=$row["pcs"];
	
	$sql1="select * from $bai_pro3.ims_log where ims_doc_no in (".$dockets.")";
	$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($result1) > 0)
	{	
		$sql12="select sum(ims_qty) as input1 from $bai_pro3.ims_log where ims_doc_no in (".$dockets.")";
		$result12=mysqli_query($link, $sql12) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row12=mysqli_fetch_array($result12))
		{
			$input1=$row12["input1"];
		}
	}
	else
	{
		$input1=0;
	}
	
	$sql2="select * from $bai_pro3.ims_log_backup where ims_doc_no in (".$dockets.")";
	$result2=mysqli_query($link, $sql2) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($result2) > 0)
	{	
		$sql22="select sum(ims_qty) as input2 from $bai_pro3.ims_log_backup where ims_doc_no in (".$dockets.")";
		$result22=mysqli_query($link, $sql22) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row22=mysqli_fetch_array($result22))
		{
			$input2=$row22["input2"];
		}
	}
	else
	{
		$input2=0;
	}
	
	if(($total3-($input1+$input2)) > 0)
	{
	echo "<tr>";
	echo "<td>".$buyer."</td>";
	echo "<td>".$order_style_no."</td>";
	echo "<td>".$co_no."</td>";
	echo "<td>".$order_del_no."</td>";
	echo "<td>".$order_col_des."</td>";
	echo "<td>".($total3-($input1+$input2))."</td>";
	echo "<td>".$order_date."</td>";
	echo "</tr>";
	}
}
echo "</table></div>";

?>
</div></div>

<script language="javascript" type="text/javascript">
//<![CDATA[
	$('#reset_table2').addClass('btn btn-warning');
	var table6_Props = 	{
							rows_counter: true,
							btn_reset: true,
							btn_reset_text: "Clear",
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "table2",table6_Props );
	$('#reset_table2').addClass('btn btn-warning btn-xs');
//]]>
</script>
</div>

<?php include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
<?php include('../'.getFullURLLevel($_GET['r'],'/common/php/functions.php',4,'R')); ?>


<!-- <meta http-equiv="cache-control" content="no-cache">
<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{
	margin:15px; padding:15px; border:1px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:88%;
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	border:1px solid #ccc;
}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; border:2px outset #f4f4f4; margin:2px; }
th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; }

</style> -->
<script language="javascript" type="text/javascript" src="<?= getFullURL($_GET['r'],'../../../../common/js/actb.js','R');?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURL($_GET['r'],'../../../../common/js/tablefilter.js','R');?>"></script>

<Link rel='alternate' media='print' href=null>
<Script Language=JavaScript>

function setPrintPage(prnThis){

prnDoc = document.getElementsByTagName('link');
prnDoc[0].setAttribute('href', prnThis);
window.print();
}

</Script>
<!-- <?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/master/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?> -->

<div class="panel panel-primary">
<div class="panel-heading">CAD Job Priority</div>
<div class="panel-body">

<?php include("../".getFullURLLevel($_GET['r'],'/common/config/menu_content.php',4,'R')); ?>
<?php

$sql="select * from $bai_pro3.allocate_stat_log where mk_status is NULL OR mk_status in (1,2,3) and (pliespercut+allocate_xs+allocate_s+allocate_m+allocate_l+allocate_xl+allocate_xxl+allocate_xxxl+plies+allocate_s01+allocate_s02+allocate_s03+allocate_s04+allocate_s05+allocate_s06+allocate_s07+allocate_s08+allocate_s09+allocate_s10+allocate_s11+allocate_s12+allocate_s13+allocate_s14+allocate_s15+allocate_s16+allocate_s17+allocate_s18+allocate_s19+allocate_s20+allocate_s21+allocate_s22+allocate_s23+allocate_s24+allocate_s25+allocate_s26+allocate_s27+allocate_s28+allocate_s29+allocate_s30+allocate_s31+allocate_s32+allocate_s33+allocate_s34+allocate_s35+allocate_s36+allocate_s37+allocate_s38+allocate_s39+allocate_s40+allocate_s41+allocate_s42+allocate_s43+allocate_s44+allocate_s45+allocate_s46+allocate_s47+allocate_s48+allocate_s49+allocate_s50)>0 order by mk_status";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

echo "<div class='table-responsive'><table id=\"table1\" border=1 class=\"table table-bordered\">";
echo "<tr class='danger'><th>Style</th><th>Schedule</th><th>Color</th><th>Category</th><th>Status</th><th>MO STATUS</th><th>Controls</th></tr>";

while($sql_row=mysqli_fetch_array($sql_result))
{
	$allocate_tid=$sql_row['tid'];
	$mk_status=$sql_row['mk_status'];
	$order_tid=$sql_row['order_tid'];
	$cat_ref=$sql_row['cat_ref'];

	$sql33="select * from $bai_pro3.maker_stat_log where allocate_ref=$allocate_tid";
	mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row33=mysqli_fetch_array($sql_result33))
	{
		$maker_tid=$sql_row33['tid'];
	}
	
	$sql33="select * from $bai_pro3.cat_stat_log where tid=$cat_ref";
	mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row33=mysqli_fetch_array($sql_result33))
	{
		$category=$sql_row33['category'];
		$mo_status=$sql_row33['mo_status'];
	}
	
	
		$sql2="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check2=mysqli_num_rows($sql_result2);

		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$color=$sql_row2['order_col_des'];
			$style=$sql_row2['order_style_no'];
			$schedule=$sql_row2['order_del_no'];
			$customer=$sql_row2['order_div'];
			$customer_div=$sql_row2['order_div'];
			$flag=$sql_row2['title_flag'];
		}

	if(!($maker_tid>0))
	{
		$maker_tid=0;
	}
	
	$mk_msg="NEW";
	if($mk_status==1)
	{
		$mk_msg="NEW";
	}
	else
	{
		if($mk_status==2)
		{
			$mk_msg="Verified";
		}
		else
		if($mk_status==3)
		{
			$mk_msg="Revise";
		}
	}
	

	echo "<tr>";
	//echo "<td>$maker_tid</td>";
	echo "<td>$style</td>";
	echo "<td>$schedule</td>";
	echo "<td>$color</td>";
	echo "<td>$category</td>";
	echo "<td>$mk_msg</td>";
	echo "<td>$mo_status</td>";
	
	$customer=substr($customer,0,((strlen($customer)-2)*-1));
	
	$url = getFullURLLevel($_GET['r'],'lay_plan_preparation/main_interface.php',1,'N');
	if($customer!="VS")
	{
		if(strpos($customer_div,"- Men")) //NEW Implementation for M&S as Men Wear having size codes different. 20110428
		{
			if($flag==1)
			{
				echo "<td><a href=\"$url&color=$color&style=$style&schedule=$schedule\" class='btn btn-info btn-sm'>GO</a></td>";
			}
			else
			{
				echo "<td><a href=\"$url&color=$color&style=$style&schedule=$schedule\" class='btn btn-info btn-sm'>GO</a></td>";
			}
		}
		else
		{
				echo "<td><a href=\"$url&color=$color&style=$style&schedule=$schedule\" class='btn btn-info btn-sm'>GO</a></td>";
		}
		
	}
	else if($customer=="CK")
	{
		if($flag==0)
		{
			echo "<td><a href=\"$url&color=$color&style=$style&schedule=$schedule\" class='btn btn-info btn-sm'>GO</a></td>";
		}
		else
		{
			echo "<td><a href=\"$url&color=$color&style=$style&schedule=$schedule\" class='btn btn-info btn-sm'>GO</a></td>";
		}
	}
	else
	{
		echo "<td><a href=\"$url&color=$color&style=$style&schedule=$schedule\" class='btn btn-info btn-sm'>GO</a></td>";
	}
	
	
	echo "</tr>";

}

echo "</table></div>";
?>
<script language="javascript" type="text/javascript">
//<![CDATA[
//var MyTableFilter = {  exact_match: true }

//setFilterGrid( "table1");

var table3Filters = {
		btn: true,
		col_0: "select",
		col_1: "select",
		col_2: "select",
		col_3: "select",
		col_4: "select",
		col_5: "select",

		exact_match: true,
		alternate_rows: true,
		loader: true,
		loader_text: "Filtering data...",
		loader: true,
		btn_reset_text: "Clear",
		display_all_text: "Display all rows",
		btn_text: ">"
	}
	setFilterGrid("table1",table3Filters);


//]]>
</script>
</div>
</div>

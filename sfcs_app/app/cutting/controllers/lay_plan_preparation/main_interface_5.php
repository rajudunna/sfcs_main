<head>
	<style>
		th
		{
			white-space: nowrap;
		}
		td
		{
			white-space: nowrap;
		}
	</style>
</head>
<?php

$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result)>0)
{
	$ord_tbl_name="$bai_pro3.bai_orders_db_confirm";	
}
else{
	$ord_tbl_name="$bai_pro3.bai_orders_db";		
}
$tran_order_tid1=$tran_order_tid;
$sql="select * from $bai_pro3.allocate_stat_log where order_tid=\"$tran_order_tid1\" order by tid";
// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

echo "<div class=\"table-responsive\"><table class=\"table table-bordered\">
	  <thead><tr><th class=\"column-title\"><center>Marker Ref</center></th>
		  <th class=\"column-title\"><center>Category</center></th><th class=\"column-title\"><center>TID</center></th>
		  <th class=\"column-title\"><center>Cat_ID</center></th><th class=\"column-title\"><center>Allocate_REF</center></th>
		  <th class=\"column-title\"><center>Marker Length</center></th><th class=\"column-title\"><center>Marker EFF%</center></th>
		  <th class=\"column-title\"><center>Version</center></th><th class=\"column-title\"><center>Controls</center></th>
		  <th class=\"column-title\"><center>Delete Control</center></th>
		  <th class=\"column-title\"><center>Overall Saving</center></th>
		  <th class=\"column-title\"><center>CAD Consumption</center></th>
		  <th class=\"column-title\"><center>Used Meters</center></th><th class=\"column-title\"><center>Current Status</center></th><th class=\"column-title\"><center>Remarks</center></th></tr></thead>";

while($sql_row=mysqli_fetch_array($sql_result))
{

	$cat_ref1=$sql_row['cat_ref'];
	$cuttable_ref1=$sql_row['cuttable_ref'];
	$allocate_ref1=$sql_row['tid'];
	$mk_status1=$sql_row['mk_status'];
	$remarks1=$sql_row['remarks'];
		
	$mklength1=0;
	$mkeff1=0;
	$mk_ref1=0;

	$sql2="select * from $bai_pro3.maker_stat_log where allocate_ref=$allocate_ref1 and cuttable_ref > 0";

	// mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$mklength1=$sql_row2['mklength'];
		$mkeff1=$sql_row2['mkeff'];
		$mk_ref1=$sql_row2['tid'];
		$mk_remarks1=$sql_row2['remarks'];
		$mk_version=$sql_row2['mk_ver'];
	}

	// echo $mk_version;
	$sql2="select * from $bai_pro3.cat_stat_log where tid=$cat_ref1 order by catyy DESC";
	// mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
			$cat_yy1=$sql_row2['catyy'];
			$category1=$sql_row2['category'];
	}

	echo "<tr class=\"  \">";
	echo "<td class=\"  \"><center>".$mk_ref1."</center></td>";
	echo "<td class=\"  \"><center>".$category1."</center></td>";
	echo "<td class=\"  \"><center>".$sql_row['tid']."</center></td>";
	echo "<td class=\"  \"><center>".$sql_row['cat_ref']."</center></td>";
	echo "<td class=\"  \"><center>".$cuttable_ref1."</center></td>";
	echo "<td class=\"  \"><center>".$mklength1."</center></td>";
	
	echo "<td class=\"  \"><center>".$mkeff1."</center></td>";
	echo "<td class=\"  \"><center>".$mk_version."</center></td>";

	if($mk_ref1==0)
	{
		echo "<td class=\"  \"><center><a class=\"btn btn-xs btn-primary\" href=\"".getFullURL($_GET['r'], "order_makers_form2.php", "N")."&tran_order_tid=$tran_order_tid1&cat_ref=$cat_ref1&cuttable_ref=$cuttable_ref1&allocate_ref=$allocate_ref1\">Create</a>";

echo " | <a class=\"btn btn-xs btn-warning\" href=\"".getFullURL($_GET['r'], "revise_process.php", "N")."&tran_order_tid=$tran_order_tid1&allocate_ref=$allocate_ref1\">Revise</a></center></td>";



	}
	else
	{
		if($mk_status1==9)
		{
			//echo "<td class=\"b1\">Docket Generation Completed</td>";
			//Changed to allow pilot to update pilot details even after the docket generation. - KK 2012-05-03
			
			echo "<td class=\"  \"><center>
					<a class=\"btn btn-xs btn-info\" href=\"".getFullURL($_GET['r'], "order_makers_form2_edit.php", "N")."&tran_order_tid=$tran_order_tid1&cat_ref=$cat_ref1&cuttable_ref=$cuttable_ref1&allocate_ref=$allocate_ref1&mk_ref=$mk_ref1&lock_status=1\">Edit</a>";

		}
		else{
				echo "<td class=\"  \"><center><a class=\"btn btn-xs btn-info\" href=\"".getFullURL($_GET['r'], "order_makers_form2_edit.php", "N")."&tran_order_tid=$tran_order_tid1&cat_ref=$cat_ref1&cuttable_ref=$cuttable_ref1&allocate_ref=$allocate_ref1&mk_ref=$mk_ref1\">Edit</a>";

				echo " | <a id='revise_form' class=\"btn btn-xs btn-warning\" href=\"".getFullURL($_GET['r'], "revise_process.php", "N")."&tran_order_tid=$tran_order_tid1&allocate_ref=$allocate_ref1\">Revise</a></center></td>";
		}
	}	
	$sql21="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$tran_order_tid1\" and mk_ref=$mk_ref1 ";
	$sql_result21=mysqli_query($link, $sql21) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result21)==0)
	{
		echo "<td class=\"  \"><center><a id='delete_form' class=\"btn btn-xs btn-danger confirm-submit\" href=\"".getFullURL($_GET['r'], "delete_id.php", "N")."&tran_order_tid=$tran_order_tid1&cat_ref=$cat_ref1&cuttable_ref=$cuttable_ref1&allocate_ref=$allocate_ref1&mk_ref=$mk_ref1\">Delete</a>";
	}
	else
	{
		echo "<td class=\"  \"><center>Lay plan Prepared";		
	}	
	
		$sql2="select * from $bai_pro3.allocate_stat_log where order_tid=\"$tran_order_tid1\" and tid=$allocate_ref1 ";
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		
		if($sql_row2['pliespercut']>0)
		{			
			$cutcount1=ceil($sql_row2['plies']/$sql_row2['pliespercut']);
		}
				
		$totalplies1=$sql_row2['allocate_s01']+$sql_row2['allocate_s02']+$sql_row2['allocate_s03']+$sql_row2['allocate_s04']+$sql_row2['allocate_s05']+$sql_row2['allocate_s06']+$sql_row2['allocate_s07']+$sql_row2['allocate_s08']+$sql_row2['allocate_s09']+$sql_row2['allocate_s10']+$sql_row2['allocate_s11']+$sql_row2['allocate_s12']+$sql_row2['allocate_s13']+$sql_row2['allocate_s14']+$sql_row2['allocate_s15']+$sql_row2['allocate_s16']+$sql_row2['allocate_s17']+$sql_row2['allocate_s18']+$sql_row2['allocate_s19']+$sql_row2['allocate_s20']+$sql_row2['allocate_s21']+$sql_row2['allocate_s22']+$sql_row2['allocate_s23']+$sql_row2['allocate_s24']+$sql_row2['allocate_s25']+$sql_row2['allocate_s26']+$sql_row2['allocate_s27']+$sql_row2['allocate_s28']+$sql_row2['allocate_s29']+$sql_row2['allocate_s30']+$sql_row2['allocate_s31']+$sql_row2['allocate_s32']+$sql_row2['allocate_s33']+$sql_row2['allocate_s34']+$sql_row2['allocate_s35']+$sql_row2['allocate_s36']+$sql_row2['allocate_s37']+$sql_row2['allocate_s38']+$sql_row2['allocate_s39']+$sql_row2['allocate_s40']+$sql_row2['allocate_s41']+$sql_row2['allocate_s42']+$sql_row2['allocate_s43']+$sql_row2['allocate_s44']+$sql_row2['allocate_s45']+$sql_row2['allocate_s46']+$sql_row2['allocate_s47']+$sql_row2['allocate_s48']+$sql_row2['allocate_s49']+$sql_row2['allocate_s50'];

	}
	
	
	//$savings=round(((($mklength/$totalplies)-$cat_yy)/$cat_yy)*100,0);
	//$savings=round(((($mklength/$totalplies)-$cat_yy)/$cat_yy),0);
	if($cat_yy1>0 and $totalplies1>0)
	{
		$savings1=round((($cat_yy1-($mklength1/$totalplies1))/$cat_yy1)*100,0);
	}
	else
	{
		$savings1=0;
	}
	
	//echo "<td class=\"b1\">".$savings."%</td>";
	
	/* NEW 2010-05-22 */
	
	$newyy1=0;
	$new_order_qty1=0;
	$sql2="select * from $bai_pro3.maker_stat_log where order_tid=\"$tran_order_tid1\" and cat_ref=$cat_ref1 and cuttable_ref > 0";
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$mk_new_length1=$sql_row2['mklength'];
		$new_allocate_ref1=$sql_row2['allocate_ref'];
		
		$sql22="select * from $bai_pro3.allocate_stat_log where tid=$new_allocate_ref1";
		mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row22=mysqli_fetch_array($sql_result22))
		{
			$new_plies1=$sql_row22['plies'];
		}
		// echo "1=".$newyy1."=".$mk_new_length1."-".$new_plies1."<br>";
		$newyy1=$newyy1+($mk_new_length1*$new_plies1);
		// echo "2=".$newyy1."=".$mk_new_length1."-".$new_plies1."<br>";
	}
	//With Binding Consumption logic - SK - Starts
	$newyy21=$newyy1;
	
	$sql21="select order_no from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid1\"";
	mysqli_query($link, $sql21) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result21=mysqli_query($link, $sql21) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row21=mysqli_fetch_array($sql_result21))
	{
		$order_no1=$sql_row21['order_no'];
	}
	
	//if excess 1% 
	
	if($order_no1 == "1")
	{
		$sql2="select (old_order_s_s01+old_order_s_s02+old_order_s_s03+old_order_s_s04+old_order_s_s05+old_order_s_s06+old_order_s_s07+old_order_s_s08+old_order_s_s09+old_order_s_s10+old_order_s_s11+old_order_s_s12+old_order_s_s13+old_order_s_s14+old_order_s_s15+old_order_s_s16+old_order_s_s17+old_order_s_s18+old_order_s_s19+old_order_s_s20+old_order_s_s21+old_order_s_s22+old_order_s_s23+old_order_s_s24+old_order_s_s25+old_order_s_s26+old_order_s_s27+old_order_s_s28+old_order_s_s29+old_order_s_s30+old_order_s_s31+old_order_s_s32+old_order_s_s33+old_order_s_s34+old_order_s_s35+old_order_s_s36+old_order_s_s37+old_order_s_s38+old_order_s_s39+old_order_s_s40+old_order_s_s41+old_order_s_s42+old_order_s_s43+old_order_s_s44+old_order_s_s45+old_order_s_s46+old_order_s_s47+old_order_s_s48+old_order_s_s49+old_order_s_s50) as \"sum\" from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid1\"";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$new_order_qty1=$sql_row2['sum'];
		}
	}
	
	else
	{
		$sql2="select (old_order_s_s01+old_order_s_s02+old_order_s_s03+old_order_s_s04+old_order_s_s05+old_order_s_s06+old_order_s_s07+old_order_s_s08+old_order_s_s09+old_order_s_s10+old_order_s_s11+old_order_s_s12+old_order_s_s13+old_order_s_s14+old_order_s_s15+old_order_s_s16+old_order_s_s17+old_order_s_s18+old_order_s_s19+old_order_s_s20+old_order_s_s21+old_order_s_s22+old_order_s_s23+old_order_s_s24+old_order_s_s25+old_order_s_s26+old_order_s_s27+old_order_s_s28+old_order_s_s29+old_order_s_s30+old_order_s_s31+old_order_s_s32+old_order_s_s33+old_order_s_s34+old_order_s_s35+old_order_s_s36+old_order_s_s37+old_order_s_s38+old_order_s_s39+old_order_s_s40+old_order_s_s41+old_order_s_s42+old_order_s_s43+old_order_s_s44+old_order_s_s45+old_order_s_s46+old_order_s_s47+old_order_s_s48+old_order_s_s49+old_order_s_s50) as \"sum\" from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid1\"";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$new_order_qty1=$sql_row2['sum'];
		}
	}
	
	//Binding Consumption / YY Calculation //20151016-KIRANG-Imported Binding inclusive concept.
	
	$sql2="select COALESCE(binding_con,0) as \"binding_con\" from $bai_pro3.bai_orders_db_remarks where order_tid=\"$tran_order_tid1\"";
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$bind_con1=$sql_row2['binding_con'];
	}
	//echo "3=".$newyy1."=".$new_order_qty1."-".$bind_con1."<br>";
	$newyy1+=($new_order_qty1*$bind_con1);
	//echo "4=".$newyy1."=".$new_order_qty1."-".$bind_con1."<br>";
	//Binding Consumption / YY Calculation //20151016-KIRANG-Imported Binding inclusive concept.
	if($new_order_qty1 >0){
		//echo "5=".$newyy1."=".$new_order_qty1."<br>";
		$newyy1=$newyy1/$new_order_qty1;
		//echo "6=".$newyy1."=".$new_order_qty1."<br>";
	}
	
	//Binding Consumption logic - SK - Ends
	
	$sql2="select (order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50) as \"sum\" from $ord_tbl_name where order_tid=\"$tran_order_tid\"";
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$new_order_qty1=$sql_row2['sum'];
	}
	
	//echo $newyy1."-".$new_order_qty1."<br>";
	//$newyy1=$newyy1/$new_order_qty1;
	if($cat_yy1 > 0)
		$savings_new1=round((($cat_yy1-$newyy1)/$cat_yy1)*100,2);
	
	echo "<td class=\"  \"><center>".$savings_new1."%</center></td>";
	echo "<td class=\"  \"><center>".round($newyy1,4)."</center></td>";
	echo "<td class=\"  \"><center>".round($newyy21,0)."</center></td>";
	/* NEW 2010-05-22 */
	
	switch ($mk_status1)
	{
		case 1:
		{
			echo "<td class=\"  \"><center>NEW</center></td>";
			break;
		}
			
		case 2:
		{
			echo "<td class=\"  \"><center>VERIFIED</center></td>";
			break;
		}
			
		case 3:
		{
			echo "<td class=\"  \"><center>REVISE</center></td>";
			break;
		}
		case 9:
		{
			echo "<td class=\"  \"><center>Docket Generated</center></td>";
			break;
		}
		default:
		{
			echo "<td class=\"  \"><center>NEW</center></td>";
			break;
		}
			
	}

echo "<td class=\"  \"><center>".$mk_remarks1."</center></td>";
	echo "</tr>";
}
echo "</table></div>";

?>

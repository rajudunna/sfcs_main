<?php 

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');  
?>
<?php
//Date 2013-11-25/Ticket#100078/ Added Carton Track and AOD details
?>
<html>

<style>
body
{
	font-family:calibri;
	font-size:12px;
}

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
    	background-color: #29759c;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}


}

}
</style>

<body>
<?php 


$schedule=$_GET['schedule'];
?>
<div id="page_heading"><span style="float: left"><h3>Production Status - <?php echo $schedule;  ?></h3></span></div>


<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); 
{
	
	
	echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color=\"red\">Please wait while preparing report...</font></h1></center></div>";
	
	ob_end_flush();
	flush();
	usleep(10);
	
	

	
$sql="select * from $bai_pro3.bai_orders_db_confirm where order_del_no='$schedule'";
mysqli_query($link,$sql) or exit("Sql Error1".mysqli_error());
$sql_result=mysqli_query($link,$sql) or exit("Sql Error2".mysqli_error());
$count_val1=0;
while($sql_row=mysqli_fetch_array($sql_result))
{
	$color=$sql_row['order_col_des'];
	for($s=0;$s<sizeof($sizes_code);$s++)
	{
		if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
		{
			$count_val1++;
			$s_tit=$sql_row["title_size_s".$sizes_code[$s].""];
			
			
		}	
	}
	echo "<table id=\"table1\" border=1 class=\"mytable\" style=\"width:1000px\">";
echo "<tr><th>$color</th><th colspan=\"$count_val1\">Extra Shippable Quantities</th><th style=\"background-color:red;\">&nbsp;</th><th colspan=\"$count_val1\" style=\"background-color:black;\">Order Quantities</th></tr>";

echo "<tr><th>Description</th>";
for($s=0;$s<sizeof($sizes_code);$s++)
	{
		if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
		{
			
			$s_tit=$sql_row["title_size_s".$sizes_code[$s].""];
			echo " <th>".$sql_row["title_size_s".$sizes_code[$s].""]."</th>";
			
		}	
	}
echo"<th style=\"background-color:red;\">&nbsp;</th>";
for($s=0;$s<sizeof($sizes_code);$s++)
	{
		if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
		{
			
			$s_tit=$sql_row["title_size_s".$sizes_code[$s].""];
			echo " <th>".$sql_row["title_size_s".$sizes_code[$s].""]."</th>";
			
		}	
	}	
echo"</tr>";
	
	// $order_xs=$sql_row['order_s_xs'];
	// $order_s=$sql_row['order_s_s'];
	// $order_m=$sql_row['order_s_m'];
	// $order_l=$sql_row['order_s_l'];
	// $order_xl=$sql_row['order_s_xl'];
	// $order_xxl=$sql_row['order_s_xxl'];
	// $order_xxxl=$sql_row['order_s_xxxl'];
	// $order_s06=$sql_row['order_s_s06'];
	// $order_s08=$sql_row['order_s_s08'];
	// $order_s10=$sql_row['order_s_s10'];
	// $order_s12=$sql_row['order_s_s12'];
	// $order_s14=$sql_row['order_s_s14'];
	// $order_s16=$sql_row['order_s_s16'];
	// $order_s18=$sql_row['order_s_s18'];
	// $order_s20=$sql_row['order_s_s20'];
	// $order_s22=$sql_row['order_s_s22'];
	// $order_s24=$sql_row['order_s_s24'];
	// $order_s26=$sql_row['order_s_s26'];
	// $order_s28=$sql_row['order_s_s28'];
	// $order_s30=$sql_row['order_s_s30'];
	
	// $old_order_xs=$sql_row['old_order_s_xs'];
	// $old_order_s=$sql_row['old_order_s_s'];
	// $old_order_m=$sql_row['old_order_s_m'];
	// $old_order_l=$sql_row['old_order_s_l'];
	// $old_order_xl=$sql_row['old_order_s_xl'];
	// $old_order_xxl=$sql_row['old_order_s_xxl'];
	// $old_order_xxxl=$sql_row['old_order_s_xxxl'];
	// $old_order_s06=$sql_row['old_order_s_s06'];
	// $old_order_s08=$sql_row['old_order_s_s08'];
	// $old_order_s10=$sql_row['old_order_s_s10'];
	// $old_order_s12=$sql_row['old_order_s_s12'];
	// $old_order_s14=$sql_row['old_order_s_s14'];
	// $old_order_s16=$sql_row['old_order_s_s16'];
	// $old_order_s18=$sql_row['old_order_s_s18'];
	// $old_order_s20=$sql_row['old_order_s_s20'];
	// $old_order_s22=$sql_row['old_order_s_s22'];
	// $old_order_s24=$sql_row['old_order_s_s24'];
	// $old_order_s26=$sql_row['old_order_s_s26'];
	// $old_order_s28=$sql_row['old_order_s_s28'];
	// $old_order_s30=$sql_row['old_order_s_s30'];


	
				
		echo "<tr>";
		echo "<td style='text-align:center;'>Order Quantities</td>";
		// echo "<td>$order_xs</td>
		// <td>$order_s</td>
		// <td>$order_m</td>
		// <td>$order_l</td>
		// <td>$order_xl</td>
		// <td>$order_xxl</td>
		// <td>$order_xxxl</td>
		// <td>$order_s06</td>
		// <td>$order_s08</td>
		// <td>$order_s10</td>
		// <td>$order_s12</td>
		// <td>$order_s14</td>
		// <td>$order_s16</td>
		// <td>$order_s18</td>
		// <td>$order_s20</td>
		// <td>$order_s22</td>
		// <td>$order_s24</td>
		// <td>$order_s26</td>
		// <td>$order_s28</td>
		// <td>$order_s30</td>
		for($s=0;$s<$count_val1;$s++){
			echo "<td style='text-align:center;'>".$sql_row["order_s_s".$sizes_code[$s].""]."</td>";
			
			
		}

		echo"<td style=\"background-color:red;\"></td>";

		for($s=0;$s<$count_val1;$s++){
			echo "<td style='text-align:center;'>".$sql_row["old_order_s_s".$sizes_code[$s].""]."</td>";
			
		}
		
		echo "</tr>";
		
		
		
		echo "<tr>";
		echo "<td style='text-align:center;'>Output Quantities</td>";
		$sql1="select sum(size_xs) as \"size_xs\", sum(size_s) as \"size_s\", sum(size_m) as \"size_m\", sum(size_l) as \"size_l\", sum(size_xl) as \"size_xl\", sum(size_xxl) as \"size_xxl\", sum(size_xxxl) as \"size_xxxl\", sum(size_s06) as \"size_s06\",sum(size_s08) as \"size_s08\", sum(size_s10) as \"size_s10\", sum(size_s12) as \"size_s12\", sum(size_s14) as \"size_s14\", sum(size_s16) as \"size_s16\", sum(size_s18) as \"size_s18\", sum(size_s20) as \"size_s20\", sum(size_s22) as \"size_s22\", sum(size_s24) as \"size_s24\", sum(size_s26) as \"size_s26\", sum(size_s28) as \"size_s28\",sum(size_s30) as \"size_s30\",sum(size_s31) as \"size_s31\",sum(size_s32) as \"size_s32\",sum(size_s33) as \"size_s33\",sum(size_s34) as \"size_s34\",sum(size_s35) as \"size_s35\",sum(size_s36) as \"size_s36\",sum(size_s37) as \"size_s37\",sum(size_s38) as \"size_s38\",sum(size_s39) as \"size_s39\",sum(size_s40) as \"size_s40\",sum(size_s41) as \"size_s41\",sum(size_s42) as \"size_s42\",sum(size_s43) as \"size_s43\",sum(size_s44) as \"size_s44\",sum(size_s45) as \"size_s45\",sum(size_s46) as \"size_s46\",sum(size_s47) as \"size_s47\",sum(size_s48) as \"size_s48\",sum(size_s49) as \"size_s49\",sum(size_s50) as \"size_s50\"  from $bai_pro.bai_log_buf where delivery='$schedule' and color='$color'";
			mysqli_query($link,$sql1) or exit("Sql Error3".mysqli_error());
			$sql_result1=mysqli_query($link,$sql1) or exit("Sql Error4".mysqli_error());
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				for($s=0;$s<$count_val1;$s++){
					echo "<td style='text-align:center;'>".$sql_row1["size_s".$sizes_code[$s].""]."</td>";
				}
				echo"<td style=\"background-color:red;\"></td>";
		
				for($s=0;$s<$count_val1;$s++){
					echo "<td style='text-align:center;'>".$sql_row1["size_s".$sizes_code[$s].""]."</td>";
				}

			
		
		
		echo "</tr>";
		
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td style='text-align:center;'>Balance Quantities</td>";
		
		// echo "<td class=\"colorme\">".($order_xs-$xs)."</td>
		// <td class=\"colorme\">".($order_s-$s)."</td>
		// <td class=\"colorme\">".($order_m-$m)."</td>
		// <td class=\"colorme\">".($order_l-$l)."</td>
		// <td class=\"colorme\">".($order_xl-$xl)."</td>
		// <td class=\"colorme\">".($order_xxl-$xxl)."</td>
		// <td class=\"colorme\">".($order_xxxl-$xxxl)."</td>
		// <td class=\"colorme\">".($order_s06-$s06)."</td>
		// <td class=\"colorme\">".($order_s08-$s08)."</td>
		// <td class=\"colorme\">".($order_s10-$s10)."</td>
		// <td class=\"colorme\">".($order_s12-$s12)."</td>
		// <td class=\"colorme\">".($order_s14-$s14)."</td>
		// <td class=\"colorme\">".($order_s16-$s16)."</td>
		// <td class=\"colorme\">".($order_s18-$s18)."</td>
		// <td class=\"colorme\">".($order_s20-$s20)."</td>
		// <td class=\"colorme\">".($order_s22-$s22)."</td>
		// <td class=\"colorme\">".($order_s24-$s24)."</td>
		// <td class=\"colorme\">".($order_s26-$s26)."</td>
		// <td class=\"colorme\">".($order_s28-$s28)."</td>
		// <td class=\"colorme\">".($order_s30-$s30)."</td>
		for($s=0;$s<$count_val1;$s++){
			echo "<td style='text-align:center;'>".($sql_row["order_s_s".$sizes_code[$s].""]-$sql_row1["size_s".$sizes_code[$s].""])."</td>";
			//echo ($sql_row["order_s_s".$sizes_code[$s].""]-$sql_row1["size_s".$sizes_code[$s].""]);
			
			
		}
	
		echo"<td style=\"background-color:red;\"></td>";
		for($s=0;$s<$count_val1;$s++){
			echo "<td style='text-align:center;'>".($sql_row["old_order_s_s".$sizes_code[$s].""]-$sql_row1["size_s".$sizes_code[$s].""])."</td>";
			//echo ($sql_row["order_s_s".$sizes_code[$s].""]-$sql_row1["size_s".$sizes_code[$s].""]);
			
			
		}
	}
		// <td class=\"colorme\">".($old_order_xs-$xs)."</td>
		// <td class=\"colorme\">".($old_order_s-$s)."</td>
		// <td class=\"colorme\">".($old_order_m-$m)."</td>
		// <td class=\"colorme\">".($old_order_l-$l)."</td>
		// <td class=\"colorme\">".($old_order_xl-$xl)."</td>
		// <td class=\"colorme\">".($old_order_xxl-$xxl)."</td>
		// <td class=\"colorme\">".($old_order_xxxl-$xxxl)."</td>
		// <td class=\"colorme\">".($old_order_s06-$s06)."</td>
		// <td class=\"colorme\">".($old_order_s08-$s08)."</td>
		// <td class=\"colorme\">".($old_order_s10-$s10)."</td>
		// <td class=\"colorme\">".($old_order_s12-$s12)."</td>
		// <td class=\"colorme\">".($old_order_s14-$s14)."</td>
		// <td class=\"colorme\">".($old_order_s16-$s16)."</td>
		// <td class=\"colorme\">".($old_order_s18-$s18)."</td>
		// <td class=\"colorme\">".($old_order_s20-$s20)."</td>
		// <td class=\"colorme\">".($old_order_s22-$s22)."</td>
		// <td class=\"colorme\">".($old_order_s24-$s24)."</td>
		// <td class=\"colorme\">".($old_order_s26-$s26)."</td>
		// <td class=\"colorme\">".($old_order_s28-$s28)."</td>
		// <td class=\"colorme\">".($old_order_s30-$s30)."</td>
		
		echo "</tr>";
		$count_val1=0;
		echo "</table>";

}
}



?>


<script>
	document.getElementById("msg").style.display="none";	
	
	$(function() {
	$('.colorme').each(function() {

	if (Number($(this).text())>0) 
	$(this).css('backgroundColor', 'red');
	});
	});

</script>


</body>
</html>

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
	



$sql="select * from $bai_pro3.bai_orders_db_confirm where order_del_no=$schedule";
mysqli_query($link,$sql) or exit("Sql Error".mysqli_error());
$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysqli_error());
while($sql_row=mysqli_fetch_array($sql_result))
{
	$color=$sql_row['order_col_des'];
	
	echo "<table id=\"table1\" border=1 class=\"mytable\">";
echo "<tr><th>$color</th><th colspan=\"20\">Extra Shippable Quantities</th><th style=\"background-color:red;\">&nbsp;</th><th colspan=\"20\" style=\"background-color:black;\">Order Quantities</th></tr>";

echo "<tr><th>Description</th><th>XS</th><th>S</th><th>M</th><th>L</th><th>XL</th><th>XXL</th><th>XXXL</th><th>s06</th><th>s08</th><th>s10</th><th>s12</th><th>s14</th><th>s16</th><th>s18</th><th>s20</th><th>s22</th><th>s24</th><th>s26</th><th>s28</th><th>s30</th>
<th style=\"background-color:red;\">&nbsp;</th>
<th style=\"background-color:black;\">XS</th><th style=\"background-color:black;\">S</th><th style=\"background-color:black;\">M</th><th style=\"background-color:black;\">L</th><th style=\"background-color:black;\">XL</th><th style=\"background-color:black;\">XXL</th><th style=\"background-color:black;\">XXXL</th><th style=\"background-color:black;\">s06</th><th style=\"background-color:black;\">s08</th><th style=\"background-color:black;\">s10</th><th style=\"background-color:black;\">s12</th><th style=\"background-color:black;\">s14</th><th style=\"background-color:black;\">s16</th><th style=\"background-color:black;\">s18</th><th style=\"background-color:black;\">s20</th><th style=\"background-color:black;\">s22</th><th style=\"background-color:black;\">s24</th><th style=\"background-color:black;\">s26</th><th style=\"background-color:black;\">s28</th><th style=\"background-color:black;\">s30</th>	
</tr>";
	
	$order_xs=$sql_row['order_s_xs'];
	$order_s=$sql_row['order_s_s'];
	$order_m=$sql_row['order_s_m'];
	$order_l=$sql_row['order_s_l'];
	$order_xl=$sql_row['order_s_xl'];
	$order_xxl=$sql_row['order_s_xxl'];
	$order_xxxl=$sql_row['order_s_xxxl'];
	$order_s06=$sql_row['order_s_s06'];
	$order_s08=$sql_row['order_s_s08'];
	$order_s10=$sql_row['order_s_s10'];
	$order_s12=$sql_row['order_s_s12'];
	$order_s14=$sql_row['order_s_s14'];
	$order_s16=$sql_row['order_s_s16'];
	$order_s18=$sql_row['order_s_s18'];
	$order_s20=$sql_row['order_s_s20'];
	$order_s22=$sql_row['order_s_s22'];
	$order_s24=$sql_row['order_s_s24'];
	$order_s26=$sql_row['order_s_s26'];
	$order_s28=$sql_row['order_s_s28'];
	$order_s30=$sql_row['order_s_s30'];
	
	$old_order_xs=$sql_row['old_order_s_xs'];
	$old_order_s=$sql_row['old_order_s_s'];
	$old_order_m=$sql_row['old_order_s_m'];
	$old_order_l=$sql_row['old_order_s_l'];
	$old_order_xl=$sql_row['old_order_s_xl'];
	$old_order_xxl=$sql_row['old_order_s_xxl'];
	$old_order_xxxl=$sql_row['old_order_s_xxxl'];
	$old_order_s06=$sql_row['old_order_s_s06'];
	$old_order_s08=$sql_row['old_order_s_s08'];
	$old_order_s10=$sql_row['old_order_s_s10'];
	$old_order_s12=$sql_row['old_order_s_s12'];
	$old_order_s14=$sql_row['old_order_s_s14'];
	$old_order_s16=$sql_row['old_order_s_s16'];
	$old_order_s18=$sql_row['old_order_s_s18'];
	$old_order_s20=$sql_row['old_order_s_s20'];
	$old_order_s22=$sql_row['old_order_s_s22'];
	$old_order_s24=$sql_row['old_order_s_s24'];
	$old_order_s26=$sql_row['old_order_s_s26'];
	$old_order_s28=$sql_row['old_order_s_s28'];
	$old_order_s30=$sql_row['old_order_s_s30'];


		
		
			$sql1="select sum(size_xs) as size_xs,sum(size_s) as size_s,sum(size_m) as size_m,sum(size_l) as size_l,sum(size_xl) as size_xl,sum(size_xxl) as size_xxl,sum(size_xxxl) as size_xxxl,sum(size_s06) as size_s06,sum(size_s08) as size_s08,sum(size_s10) as size_s10,sum(size_s12) as size_s12,sum(size_s14) as size_s14,sum(size_s16) as size_s16,sum(size_s18) as size_s18,sum(size_s20) as size_s20,sum(size_s22) as size_s22,sum(size_s24) as size_s24,sum(size_s26) as size_s26,sum(size_s28) as size_s28,sum(size_s30) as size_s30 from $bai_pro.bai_log_buf where delivery=$schedule and color='$color'";
			//echo $sql1;
			mysqli_query($link,$sql1) or exit("Sql Error".mysqli_error());
			$sql_result1=mysqli_query($link,$sql1) or exit("Sql Error".mysqli_error());
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$xs=$sql_row1['size_xs'];
				$s=$sql_row1['size_s'];
				$m=$sql_row1['size_m'];
				$l=$sql_row1['size_l'];
				$xl=$sql_row1['size_xl'];
				$xxl=$sql_row1['size_xxl'];
				$xxxl=$sql_row1['size_xxxl'];
				$s06=$sql_row1['size_s06'];
				$s08=$sql_row1['size_s08'];
				$s10=$sql_row1['size_s10'];
				$s12=$sql_row1['size_s12'];
				$s14=$sql_row1['size_s14'];
				$s16=$sql_row1['size_s16'];
				$s18=$sql_row1['size_s18'];
				$s20=$sql_row1['size_s20'];
				$s22=$sql_row1['size_s22'];
				$s24=$sql_row1['size_s24'];
				$s26=$sql_row1['size_s26'];
				$s28=$sql_row1['size_s28'];
				$s30=$sql_row1['size_s30'];

			}
			
			
				
		echo "<tr>";
		echo "<td>Order Quantities</td>";
		echo "<td>$order_xs</td>
		<td>$order_s</td>
		<td>$order_m</td>
		<td>$order_l</td>
		<td>$order_xl</td>
		<td>$order_xxl</td>
		<td>$order_xxxl</td>
		<td>$order_s06</td>
		<td>$order_s08</td>
		<td>$order_s10</td>
		<td>$order_s12</td>
		<td>$order_s14</td>
		<td>$order_s16</td>
		<td>$order_s18</td>
		<td>$order_s20</td>
		<td>$order_s22</td>
		<td>$order_s24</td>
		<td>$order_s26</td>
		<td>$order_s28</td>
		<td>$order_s30</td>

		<td style=\"background-color:red;\"></td>

		<td>$old_order_xs</td>
		<td>$old_order_s</td>
		<td>$old_order_m</td>
		<td>$old_order_l</td>
		<td>$old_order_xl</td>
		<td>$old_order_xxl</td>
		<td>$old_order_xxxl</td>
		<td>$old_order_s06</td>
		<td>$old_order_s08</td>
		<td>$old_order_s10</td>
		<td>$old_order_s12</td>
		<td>$old_order_s14</td>
		<td>$old_order_s16</td>
		<td>$old_order_s18</td>
		<td>$old_order_s20</td>
		<td>$old_order_s22</td>
		<td>$old_order_s24</td>
		<td>$old_order_s26</td>
		<td>$old_order_s28</td>
		<td>$old_order_s30</td>
		";
		echo "</tr>";
		
		
		
		echo "<tr>";
		echo "<td>Output Quantities</td>";
		echo "<td>$xs</td>
		<td>$s</td>
		<td>$m</td>
		<td>$l</td>
		<td>$xl</td>
		<td>$xxl</td>
		<td>$xxxl</td>
		<td>$s06</td>
		<td>$s08</td>
		<td>$s10</td>
		<td>$s12</td>
		<td>$s14</td>
		<td>$s16</td>
		<td>$s18</td>
		<td>$s20</td>
		<td>$s22</td>
		<td>$s24</td>
		<td>$s26</td>
		<td>$s28</td>
		<td>$s30</td>
		
		<td style=\"background-color:red;\"></td>

		<td>$xs</td>
		<td>$s</td>
		<td>$m</td>
		<td>$l</td>
		<td>$xl</td>
		<td>$xxl</td>
		<td>$xxxl</td>
		<td>$s06</td>
		<td>$s08</td>
		<td>$s10</td>
		<td>$s12</td>
		<td>$s14</td>
		<td>$s16</td>
		<td>$s18</td>
		<td>$s20</td>
		<td>$s22</td>
		<td>$s24</td>
		<td>$s26</td>
		<td>$s28</td>
		<td>$s30</td>
		";
		echo "</tr>";
		
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Balance Quantities</td>";
		
		echo "<td class=\"colorme\">".($order_xs-$xs)."</td>
		<td class=\"colorme\">".($order_s-$s)."</td>
		<td class=\"colorme\">".($order_m-$m)."</td>
		<td class=\"colorme\">".($order_l-$l)."</td>
		<td class=\"colorme\">".($order_xl-$xl)."</td>
		<td class=\"colorme\">".($order_xxl-$xxl)."</td>
		<td class=\"colorme\">".($order_xxxl-$xxxl)."</td>
		<td class=\"colorme\">".($order_s06-$s06)."</td>
		<td class=\"colorme\">".($order_s08-$s08)."</td>
		<td class=\"colorme\">".($order_s10-$s10)."</td>
		<td class=\"colorme\">".($order_s12-$s12)."</td>
		<td class=\"colorme\">".($order_s14-$s14)."</td>
		<td class=\"colorme\">".($order_s16-$s16)."</td>
		<td class=\"colorme\">".($order_s18-$s18)."</td>
		<td class=\"colorme\">".($order_s20-$s20)."</td>
		<td class=\"colorme\">".($order_s22-$s22)."</td>
		<td class=\"colorme\">".($order_s24-$s24)."</td>
		<td class=\"colorme\">".($order_s26-$s26)."</td>
		<td class=\"colorme\">".($order_s28-$s28)."</td>
		<td class=\"colorme\">".($order_s30-$s30)."</td>
		
		<td style=\"background-color:red;\"></td>

		<td class=\"colorme\">".($old_order_xs-$xs)."</td>
		<td class=\"colorme\">".($old_order_s-$s)."</td>
		<td class=\"colorme\">".($old_order_m-$m)."</td>
		<td class=\"colorme\">".($old_order_l-$l)."</td>
		<td class=\"colorme\">".($old_order_xl-$xl)."</td>
		<td class=\"colorme\">".($old_order_xxl-$xxl)."</td>
		<td class=\"colorme\">".($old_order_xxxl-$xxxl)."</td>
		<td class=\"colorme\">".($old_order_s06-$s06)."</td>
		<td class=\"colorme\">".($old_order_s08-$s08)."</td>
		<td class=\"colorme\">".($old_order_s10-$s10)."</td>
		<td class=\"colorme\">".($old_order_s12-$s12)."</td>
		<td class=\"colorme\">".($old_order_s14-$s14)."</td>
		<td class=\"colorme\">".($old_order_s16-$s16)."</td>
		<td class=\"colorme\">".($old_order_s18-$s18)."</td>
		<td class=\"colorme\">".($old_order_s20-$s20)."</td>
		<td class=\"colorme\">".($old_order_s22-$s22)."</td>
		<td class=\"colorme\">".($old_order_s24-$s24)."</td>
		<td class=\"colorme\">".($old_order_s26-$s26)."</td>
		<td class=\"colorme\">".($old_order_s28-$s28)."</td>
		<td class=\"colorme\">".($old_order_s30-$s30)."</td>
		";
		echo "</tr>";
		
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

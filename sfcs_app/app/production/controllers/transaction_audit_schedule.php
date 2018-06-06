<?php
//Date 2013-11-25/Ticket#100078/ Added Carton Track and AOD details
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/ims_size.php',3,'R'));
?>
<html>
<head>
<title>Production Status Check</title>
<style type="text/css" media="screen">
/*@import "../TableFilter_EN/filtergrid.css";
</style>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'/common/js/TableFilter_EN/tablefilter.js',3,'R');?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'/common/js/TableFilter_EN/actb.js',3,'R');?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'/common/js/jquery.min.js',3,'R');?>"></script>
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
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'/common/js/dropdowntabs.js',3,'R');?>"></script>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'/common/css/ddcolortabs.css',3,'R');?>" type="text/css" media="all" />


</head>


<body>


<div id="page_heading"><span style="float: left"><h3>Production Status - <?php echo $schedule;  ?></h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>


<?php

{
	
	
	echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color=\"red\">Please wait while preparing report...</font></h1></center></div>";
	
	ob_end_flush();
	flush();
	usleep(10);
	



$sql="select * from $bai_pro3.bai_orders_db_confirm where order_del_no=$schedule";
//echo $sql;
mysqli_query($link, $sql) or exit("No Data Found".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
			$color=$sql_row['order_col_des'];
			$size01 = $sql_row['title_size_s01'];
			$size02 = $sql_row['title_size_s02'];
			$size03 = $sql_row['title_size_s03'];
			$size04 = $sql_row['title_size_s04'];
			$size05 = $sql_row['title_size_s05'];
			$size06 = $sql_row['title_size_s06'];
			$size07 = $sql_row['title_size_s07'];
			$size08 = $sql_row['title_size_s08'];
			$size09 = $sql_row['title_size_s09'];
			$size10 = $sql_row['title_size_s10'];
			$size11 = $sql_row['title_size_s11'];
			$size12 = $sql_row['title_size_s12'];
			$size13 = $sql_row['title_size_s13'];
			$size14 = $sql_row['title_size_s14'];
			$size15 = $sql_row['title_size_s15'];
			$size16 = $sql_row['title_size_s16'];
			$size17 = $sql_row['title_size_s17'];
			$size18 = $sql_row['title_size_s18'];
			$size19 = $sql_row['title_size_s19'];
			$size20 = $sql_row['title_size_s20'];
			$size21 = $sql_row['title_size_s21'];
			$size22 = $sql_row['title_size_s22'];
			$size23 = $sql_row['title_size_s23'];
			$size24 = $sql_row['title_size_s24'];
			$size25 = $sql_row['title_size_s25'];
			$size26 = $sql_row['title_size_s26'];
			$size27 = $sql_row['title_size_s27'];
			$size28 = $sql_row['title_size_s28'];
			$size29 = $sql_row['title_size_s29'];
			$size30 = $sql_row['title_size_s30'];
			$size31 = $sql_row['title_size_s31'];
			$size32 = $sql_row['title_size_s32'];
			$size33 = $sql_row['title_size_s33'];
			$size34 = $sql_row['title_size_s34'];
			$size35 = $sql_row['title_size_s35'];
			$size36 = $sql_row['title_size_s36'];
			$size37 = $sql_row['title_size_s37'];
			$size38 = $sql_row['title_size_s38'];
			$size39 = $sql_row['title_size_s39'];
			$size40 = $sql_row['title_size_s40'];
			$size41 = $sql_row['title_size_s41'];
			$size42 = $sql_row['title_size_s42'];
			$size43 = $sql_row['title_size_s43'];
			$size44 = $sql_row['title_size_s44'];
			$size45 = $sql_row['title_size_s45'];
			$size46 = $sql_row['title_size_s46'];
			$size47 = $sql_row['title_size_s47'];
			$size48 = $sql_row['title_size_s48'];
			$size49 = $sql_row['title_size_s49'];
			$size50 = $sql_row['title_size_s50'];
	
	echo "<table id=\"table1\" border=1 class=\"mytable\">";
echo "<tr><th>$color</th><th colspan=\"50\">Extra Shippable Quantities</th><th style=\"background-color:red;\">&nbsp;</th><th colspan=\"50\" style=\"background-color:black;\">Order Quantities</th></tr>";

echo "<tr><th>Description</th><th>$size01</th><th>$size02</th><th>$size03</th><th>$size04</th><th>$size05</th><th>$size06</th><th>$size07</th><th>$size08</th><th>$size09</th><th>$size10</th><th>$size11</th><th>$size12</th><th>$size13</th><th>$size14</th><th>$size15</th><th>$size16</th><th>$size17</th><th>$size18</th><th>$size19</th><th>$size20</th><th>$size21</th><th>$size22</th><th>$size23</th><th>$size24</th><th>$size25</th><th>$size26</th><th>$size27</th><th>$size28</th><th>$size29</th><th>$size30</th><th>$size31</th><th>$size32</th><th>$size33</th><th>$size34</th><th>$size35</th><th>$size36</th><th>$size37</th><th>$size38</th><th>$size39</th><th>$size40</th><th>$size41</th><th>$size42</th><th>$size43</th><th>$size44</th><th>$size45</th><th>$size46</th><th>$size47</th><th>$size48</th><th>$size49</th><th>$size50</th>
<th style=\"background-color:red;\">&nbsp;</th>
<th style=\"background-color:black;\">$size01</th>
<th style=\"background-color:black;\">$size02</th>
<th style=\"background-color:black;\">$size03</th>
<th style=\"background-color:black;\">$size04</th>
<th style=\"background-color:black;\">$size05</th>
<th style=\"background-color:black;\">$size06</th>
<th style=\"background-color:black;\">$size07</th>
<th style=\"background-color:black;\">$size08</th>
<th style=\"background-color:black;\">$size09</th>
<th style=\"background-color:black;\">$size10</th>
<th style=\"background-color:black;\">$size11</th>
<th style=\"background-color:black;\">$size12</th>
<th style=\"background-color:black;\">$size13</th>
<th style=\"background-color:black;\">$size14</th>
<th style=\"background-color:black;\">$size15</th>
<th style=\"background-color:black;\">$size16</th>
<th style=\"background-color:black;\">$size17</th>
<th style=\"background-color:black;\">$size18</th>
<th style=\"background-color:black;\">$size19</th>
<th style=\"background-color:black;\">$size20</th>
<th style=\"background-color:black;\">$size21</th>
<th style=\"background-color:black;\">$size22</th>
<th style=\"background-color:black;\">$size23</th>
<th style=\"background-color:black;\">$size24</th>
<th style=\"background-color:black;\">$size25</th>
<th style=\"background-color:black;\">$size26</th>
<th style=\"background-color:black;\">$size27</th>
<th style=\"background-color:black;\">$size28</th>
<th style=\"background-color:black;\">$size29</th>
<th style=\"background-color:black;\">$size30</th>
<th style=\"background-color:black;\">$size31</th>
<th style=\"background-color:black;\">$size32</th>
<th style=\"background-color:black;\">$size33</th>
<th style=\"background-color:black;\">$size34</th>
<th style=\"background-color:black;\">$size35</th>
<th style=\"background-color:black;\">$size36</th>
<th style=\"background-color:black;\">$size37</th>
<th style=\"background-color:black;\">$size38</th>
<th style=\"background-color:black;\">$size39</th>
<th style=\"background-color:black;\">$size40</th>
<th style=\"background-color:black;\">$size41</th>
<th style=\"background-color:black;\">$size42</th>
<th style=\"background-color:black;\">$size43</th>
<th style=\"background-color:black;\">$size44</th>
<th style=\"background-color:black;\">$size45</th>
<th style=\"background-color:black;\">$size46</th>
<th style=\"background-color:black;\">$size47</th>
<th style=\"background-color:black;\">$size48</th>
<th style=\"background-color:black;\">$size49</th>
<th style=\"background-color:black;\">$size50</th>

</tr>";
	
	$order_xs=$sql_row['order_s_xs'];
	$order_s=$sql_row['order_s_s'];
	$order_m=$sql_row['order_s_m'];
	$order_l=$sql_row['order_s_l'];
	$order_xl=$sql_row['order_s_xl'];
	$order_xxl=$sql_row['order_s_xxl'];
	$order_xxxl=$sql_row['order_s_xxxl'];
	
	$order_s01=$sql_row['order_s_s01'];
$order_s02=$sql_row['order_s_s02'];
$order_s03=$sql_row['order_s_s03'];
$order_s04=$sql_row['order_s_s04'];
$order_s05=$sql_row['order_s_s05'];
$order_s06=$sql_row['order_s_s06'];
$order_s07=$sql_row['order_s_s07'];
$order_s08=$sql_row['order_s_s08'];
$order_s09=$sql_row['order_s_s09'];
$order_s10=$sql_row['order_s_s10'];
$order_s11=$sql_row['order_s_s11'];
$order_s12=$sql_row['order_s_s12'];
$order_s13=$sql_row['order_s_s13'];
$order_s14=$sql_row['order_s_s14'];
$order_s15=$sql_row['order_s_s15'];
$order_s16=$sql_row['order_s_s16'];
$order_s17=$sql_row['order_s_s17'];
$order_s18=$sql_row['order_s_s18'];
$order_s19=$sql_row['order_s_s19'];
$order_s20=$sql_row['order_s_s20'];
$order_s21=$sql_row['order_s_s21'];
$order_s22=$sql_row['order_s_s22'];
$order_s23=$sql_row['order_s_s23'];
$order_s24=$sql_row['order_s_s24'];
$order_s25=$sql_row['order_s_s25'];
$order_s26=$sql_row['order_s_s26'];
$order_s27=$sql_row['order_s_s27'];
$order_s28=$sql_row['order_s_s28'];
$order_s29=$sql_row['order_s_s29'];
$order_s30=$sql_row['order_s_s30'];
$order_s31=$sql_row['order_s_s31'];
$order_s32=$sql_row['order_s_s32'];
$order_s33=$sql_row['order_s_s33'];
$order_s34=$sql_row['order_s_s34'];
$order_s35=$sql_row['order_s_s35'];
$order_s36=$sql_row['order_s_s36'];
$order_s37=$sql_row['order_s_s37'];
$order_s38=$sql_row['order_s_s38'];
$order_s39=$sql_row['order_s_s39'];
$order_s40=$sql_row['order_s_s40'];
$order_s41=$sql_row['order_s_s41'];
$order_s42=$sql_row['order_s_s42'];
$order_s43=$sql_row['order_s_s43'];
$order_s44=$sql_row['order_s_s44'];
$order_s45=$sql_row['order_s_s45'];
$order_s46=$sql_row['order_s_s46'];
$order_s47=$sql_row['order_s_s47'];
$order_s48=$sql_row['order_s_s48'];
$order_s49=$sql_row['order_s_s49'];
$order_s50=$sql_row['order_s_s50'];

	
	$old_order_xs=$sql_row['old_order_s_xs'];
	$old_order_s=$sql_row['old_order_s_s'];
	$old_order_m=$sql_row['old_order_s_m'];
	$old_order_l=$sql_row['old_order_s_l'];
	$old_order_xl=$sql_row['old_order_s_xl'];
	$old_order_xxl=$sql_row['old_order_s_xxl'];
	$old_order_xxxl=$sql_row['old_order_s_xxxl'];
	$old_order_s01=$sql_row['old_order_s_s01'];
	$old_order_s02=$sql_row['old_order_s_s02'];
	$old_order_s03=$sql_row['old_order_s_s03'];
	$old_order_s04=$sql_row['old_order_s_s04'];
	$old_order_s05=$sql_row['old_order_s_s05'];
	$old_order_s06=$sql_row['old_order_s_s06'];
	$old_order_s07=$sql_row['old_order_s_s07'];
	$old_order_s08=$sql_row['old_order_s_s08'];
	$old_order_s09=$sql_row['old_order_s_s09'];
	$old_order_s10=$sql_row['old_order_s_s10'];
	$old_order_s11=$sql_row['old_order_s_s11'];
	$old_order_s12=$sql_row['old_order_s_s12'];
	$old_order_s13=$sql_row['old_order_s_s13'];
	$old_order_s14=$sql_row['old_order_s_s14'];
	$old_order_s15=$sql_row['old_order_s_s15'];
	$old_order_s16=$sql_row['old_order_s_s16'];
	$old_order_s17=$sql_row['old_order_s_s17'];
	$old_order_s18=$sql_row['old_order_s_s18'];
	$old_order_s19=$sql_row['old_order_s_s19'];
	$old_order_s20=$sql_row['old_order_s_s20'];
	$old_order_s21=$sql_row['old_order_s_s21'];
	$old_order_s22=$sql_row['old_order_s_s22'];
	$old_order_s23=$sql_row['old_order_s_s23'];
	$old_order_s24=$sql_row['old_order_s_s24'];
	$old_order_s25=$sql_row['old_order_s_s25'];
	$old_order_s26=$sql_row['old_order_s_s26'];
	$old_order_s27=$sql_row['old_order_s_s27'];
	$old_order_s28=$sql_row['old_order_s_s28'];
	$old_order_s29=$sql_row['old_order_s_s29'];
	$old_order_s30=$sql_row['old_order_s_s30'];
	$old_order_s31=$sql_row['old_order_s_s31'];
	$old_order_s32=$sql_row['old_order_s_s32'];
	$old_order_s33=$sql_row['old_order_s_s33'];
	$old_order_s34=$sql_row['old_order_s_s34'];
	$old_order_s35=$sql_row['old_order_s_s35'];
	$old_order_s36=$sql_row['old_order_s_s36'];
	$old_order_s37=$sql_row['old_order_s_s37'];
	$old_order_s38=$sql_row['old_order_s_s38'];
	$old_order_s39=$sql_row['old_order_s_s39'];
	$old_order_s40=$sql_row['old_order_s_s40'];
	$old_order_s41=$sql_row['old_order_s_s41'];
	$old_order_s42=$sql_row['old_order_s_s42'];
	$old_order_s43=$sql_row['old_order_s_s43'];
	$old_order_s44=$sql_row['old_order_s_s44'];
	$old_order_s45=$sql_row['old_order_s_s45'];
	$old_order_s46=$sql_row['old_order_s_s46'];
	$old_order_s47=$sql_row['old_order_s_s47'];
	$old_order_s48=$sql_row['old_order_s_s48'];
	$old_order_s49=$sql_row['old_order_s_s49'];
	$old_order_s50=$sql_row['old_order_s_s50'];



		
		
			$sql1="select sum(size_xs) as size_xs,sum(size_s) as size_s,sum(size_m) as size_m,sum(size_l) as size_l,sum(size_xl) as size_xl,sum(size_xxl) as size_xxl,sum(size_xxxl) as size_xxxl, sum(size_s01) as \"size_s01\", sum(size_s02) as \"size_s02\", sum(size_s03) as \"size_s03\", sum(size_s04) as \"size_s04\", sum(size_s05) as \"size_s05\", sum(size_s06) as \"size_s06\", sum(size_s07) as \"size_s07\", sum(size_s08) as \"size_s08\", sum(size_s09) as \"size_s09\", sum(size_s10) as \"size_s10\", sum(size_s11) as \"size_s11\", sum(size_s12) as \"size_s12\", sum(size_s13) as \"size_s13\", sum(size_s14) as \"size_s14\", sum(size_s15) as \"size_s15\", sum(size_s16) as \"size_s16\", sum(size_s17) as \"size_s17\", sum(size_s18) as \"size_s18\", sum(size_s19) as \"size_s19\", sum(size_s20) as \"size_s20\", sum(size_s21) as \"size_s21\", sum(size_s22) as \"size_s22\", sum(size_s23) as \"size_s23\", sum(size_s24) as \"size_s24\", sum(size_s25) as \"size_s25\", sum(size_s26) as \"size_s26\", sum(size_s27) as \"size_s27\", sum(size_s28) as \"size_s28\", sum(size_s29) as \"size_s29\", sum(size_s30) as \"size_s30\", sum(size_s31) as \"size_s31\", sum(size_s32) as \"size_s32\", sum(size_s33) as \"size_s33\", sum(size_s34) as \"size_s34\", sum(size_s35) as \"size_s35\", sum(size_s36) as \"size_s36\", sum(size_s37) as \"size_s37\", sum(size_s38) as \"size_s38\", sum(size_s39) as \"size_s39\", sum(size_s40) as \"size_s40\", sum(size_s41) as \"size_s41\", sum(size_s42) as \"size_s42\", sum(size_s43) as \"size_s43\", sum(size_s44) as \"size_s44\", sum(size_s45) as \"size_s45\", sum(size_s46) as \"size_s46\", sum(size_s47) as \"size_s47\", sum(size_s48) as \"size_s48\", sum(size_s49) as \"size_s49\", sum(size_s50) as \"size_s50\"
 from $bai_pro.bai_log_buf where delivery=$schedule and color='$color'";
			//echo $sql1;
			mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$xs=$sql_row1['size_xs'];
				$s=$sql_row1['size_s'];
				$m=$sql_row1['size_m'];
				$l=$sql_row1['size_l'];
				$xl=$sql_row1['size_xl'];
				$xxl=$sql_row1['size_xxl'];
				$xxxl=$sql_row1['size_xxxl'];
				$s01=$sql_row1['size_s01'];
				$s02=$sql_row1['size_s02'];
				$s03=$sql_row1['size_s03'];
				$s04=$sql_row1['size_s04'];
				$s05=$sql_row1['size_s05'];
				$s06=$sql_row1['size_s06'];
				$s07=$sql_row1['size_s07'];
				$s08=$sql_row1['size_s08'];
				$s09=$sql_row1['size_s09'];
				$s10=$sql_row1['size_s10'];
				$s11=$sql_row1['size_s11'];
				$s12=$sql_row1['size_s12'];
				$s13=$sql_row1['size_s13'];
				$s14=$sql_row1['size_s14'];
				$s15=$sql_row1['size_s15'];
				$s16=$sql_row1['size_s16'];
				$s17=$sql_row1['size_s17'];
				$s18=$sql_row1['size_s18'];
				$s19=$sql_row1['size_s19'];
				$s20=$sql_row1['size_s20'];
				$s21=$sql_row1['size_s21'];
				$s22=$sql_row1['size_s22'];
				$s23=$sql_row1['size_s23'];
				$s24=$sql_row1['size_s24'];
				$s25=$sql_row1['size_s25'];
				$s26=$sql_row1['size_s26'];
				$s27=$sql_row1['size_s27'];
				$s28=$sql_row1['size_s28'];
				$s29=$sql_row1['size_s29'];
				$s30=$sql_row1['size_s30'];
				$s31=$sql_row1['size_s31'];
				$s32=$sql_row1['size_s32'];
				$s33=$sql_row1['size_s33'];
				$s34=$sql_row1['size_s34'];
				$s35=$sql_row1['size_s35'];
				$s36=$sql_row1['size_s36'];
				$s37=$sql_row1['size_s37'];
				$s38=$sql_row1['size_s38'];
				$s39=$sql_row1['size_s39'];
				$s40=$sql_row1['size_s40'];
				$s41=$sql_row1['size_s41'];
				$s42=$sql_row1['size_s42'];
				$s43=$sql_row1['size_s43'];
				$s44=$sql_row1['size_s44'];
				$s45=$sql_row1['size_s45'];
				$s46=$sql_row1['size_s46'];
				$s47=$sql_row1['size_s47'];
				$s48=$sql_row1['size_s48'];
				$s49=$sql_row1['size_s49'];
				$s50=$sql_row1['size_s50'];

			}
			
			
				
		echo "<tr>";
		echo "<td>Order Quantities</td>";
		echo "<td>$order_s01</td>
<td>$order_s02</td>
<td>$order_s03</td>
<td>$order_s04</td>
<td>$order_s05</td>
<td>$order_s06</td>
<td>$order_s07</td>
<td>$order_s08</td>
<td>$order_s09</td>
<td>$order_s10</td>
<td>$order_s11</td>
<td>$order_s12</td>
<td>$order_s13</td>
<td>$order_s14</td>
<td>$order_s15</td>
<td>$order_s16</td>
<td>$order_s17</td>
<td>$order_s18</td>
<td>$order_s19</td>
<td>$order_s20</td>
<td>$order_s21</td>
<td>$order_s22</td>
<td>$order_s23</td>
<td>$order_s24</td>
<td>$order_s25</td>
<td>$order_s26</td>
<td>$order_s27</td>
<td>$order_s28</td>
<td>$order_s29</td>
<td>$order_s30</td>
<td>$order_s31</td>
<td>$order_s32</td>
<td>$order_s33</td>
<td>$order_s34</td>
<td>$order_s35</td>
<td>$order_s36</td>
<td>$order_s37</td>
<td>$order_s38</td>
<td>$order_s39</td>
<td>$order_s40</td>
<td>$order_s41</td>
<td>$order_s42</td>
<td>$order_s43</td>
<td>$order_s44</td>
<td>$order_s45</td>
<td>$order_s46</td>
<td>$order_s47</td>
<td>$order_s48</td>
<td>$order_s49</td>
<td>$order_s50</td>


		<td style=\"background-color:red;\"></td>
		<td>$old_order_s01</td>
<td>$old_order_s02</td>
<td>$old_order_s03</td>
<td>$old_order_s04</td>
<td>$old_order_s05</td>
<td>$old_order_s06</td>
<td>$old_order_s07</td>
<td>$old_order_s08</td>
<td>$old_order_s09</td>
<td>$old_order_s10</td>
<td>$old_order_s11</td>
<td>$old_order_s12</td>
<td>$old_order_s13</td>
<td>$old_order_s14</td>
<td>$old_order_s15</td>
<td>$old_order_s16</td>
<td>$old_order_s17</td>
<td>$old_order_s18</td>
<td>$old_order_s19</td>
<td>$old_order_s20</td>
<td>$old_order_s21</td>
<td>$old_order_s22</td>
<td>$old_order_s23</td>
<td>$old_order_s24</td>
<td>$old_order_s25</td>
<td>$old_order_s26</td>
<td>$old_order_s27</td>
<td>$old_order_s28</td>
<td>$old_order_s29</td>
<td>$old_order_s30</td>
<td>$old_order_s31</td>
<td>$old_order_s32</td>
<td>$old_order_s33</td>
<td>$old_order_s34</td>
<td>$old_order_s35</td>
<td>$old_order_s36</td>
<td>$old_order_s37</td>
<td>$old_order_s38</td>
<td>$old_order_s39</td>
<td>$old_order_s40</td>
<td>$old_order_s41</td>
<td>$old_order_s42</td>
<td>$old_order_s43</td>
<td>$old_order_s44</td>
<td>$old_order_s45</td>
<td>$old_order_s46</td>
<td>$old_order_s47</td>
<td>$old_order_s48</td>
<td>$old_order_s49</td>
<td>$old_order_s50</td>

		";
		echo "</tr>";
		
		
		
		echo "<tr>";
		echo "<td>Output Quantities</td>";
		echo "<td>$s01</td>
		<td>$s02</td>
		<td>$s03</td>
		<td>$s04</td>
		<td>$s05</td>
		<td>$s06</td>
		<td>$s07</td>
		<td>$s08</td>
		<td>$s09</td>
		<td>$s10</td>
		<td>$s11</td>
		<td>$s12</td>
		<td>$s13</td>
		<td>$s14</td>
		<td>$s15</td>
		<td>$s16</td>
		<td>$s17</td>
		<td>$s18</td>
		<td>$s19</td>
		<td>$s20</td>
		<td>$s21</td>
		<td>$s22</td>
		<td>$s23</td>
		<td>$s24</td>
		<td>$s25</td>
		<td>$s26</td>
		<td>$s27</td>
		<td>$s28</td>
		<td>$s29</td>
		<td>$s30</td>
		<td>$s31</td>
		<td>$s32</td>
		<td>$s33</td>
		<td>$s34</td>
		<td>$s35</td>
		<td>$s36</td>
		<td>$s37</td>
		<td>$s38</td>
		<td>$s39</td>
		<td>$s40</td>
		<td>$s41</td>
		<td>$s42</td>
		<td>$s43</td>
		<td>$s44</td>
		<td>$s45</td>
		<td>$s46</td>
		<td>$s47</td>
		<td>$s48</td>
		<td>$s49</td>
		<td>$s50</td>

		
		<td style=\"background-color:red;\"></td>

		<td>$s01</td>
		<td>$s02</td>
		<td>$s03</td>
		<td>$s04</td>
		<td>$s05</td>
		<td>$s06</td>
		<td>$s07</td>
		<td>$s08</td>
		<td>$s09</td>
		<td>$s10</td>
		<td>$s11</td>
		<td>$s12</td>
		<td>$s13</td>
		<td>$s14</td>
		<td>$s15</td>
		<td>$s16</td>
		<td>$s17</td>
		<td>$s18</td>
		<td>$s19</td>
		<td>$s20</td>
		<td>$s21</td>
		<td>$s22</td>
		<td>$s23</td>
		<td>$s24</td>
		<td>$s25</td>
		<td>$s26</td>
		<td>$s27</td>
		<td>$s28</td>
		<td>$s29</td>
		<td>$s30</td>
		<td>$s31</td>
		<td>$s32</td>
		<td>$s33</td>
		<td>$s34</td>
		<td>$s35</td>
		<td>$s36</td>
		<td>$s37</td>
		<td>$s38</td>
		<td>$s39</td>
		<td>$s40</td>
		<td>$s41</td>
		<td>$s42</td>
		<td>$s43</td>
		<td>$s44</td>
		<td>$s45</td>
		<td>$s46</td>
		<td>$s47</td>
		<td>$s48</td>
		<td>$s49</td>
		<td>$s50</td>
		";
		echo "</tr>";
		
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Balance Quantities</td>";
		
		echo "<td class=\"colorme\">".($order_s01-$s01)."</td>
		<td class=\"colorme\">".($order_s02-$s02)."</td>
		<td class=\"colorme\">".($order_s03-$s03)."</td>
		<td class=\"colorme\">".($order_s04-$s04)."</td>
		<td class=\"colorme\">".($order_s05-$s05)."</td>
		<td class=\"colorme\">".($order_s06-$s06)."</td>
		<td class=\"colorme\">".($order_s07-$s07)."</td>
		<td class=\"colorme\">".($order_s08-$s08)."</td>
		<td class=\"colorme\">".($order_s09-$s09)."</td>
		<td class=\"colorme\">".($order_s10-$s10)."</td>
		<td class=\"colorme\">".($order_s11-$s11)."</td>
		<td class=\"colorme\">".($order_s12-$s12)."</td>
		<td class=\"colorme\">".($order_s13-$s13)."</td>
		<td class=\"colorme\">".($order_s14-$s14)."</td>
		<td class=\"colorme\">".($order_s15-$s15)."</td>
		<td class=\"colorme\">".($order_s16-$s16)."</td>
		<td class=\"colorme\">".($order_s17-$s17)."</td>
		<td class=\"colorme\">".($order_s18-$s18)."</td>
		<td class=\"colorme\">".($order_s19-$s19)."</td>
		<td class=\"colorme\">".($order_s20-$s20)."</td>
		<td class=\"colorme\">".($order_s21-$s21)."</td>
		<td class=\"colorme\">".($order_s22-$s22)."</td>
		<td class=\"colorme\">".($order_s23-$s23)."</td>
		<td class=\"colorme\">".($order_s24-$s24)."</td>
		<td class=\"colorme\">".($order_s25-$s25)."</td>
		<td class=\"colorme\">".($order_s26-$s26)."</td>
		<td class=\"colorme\">".($order_s27-$s27)."</td>
		<td class=\"colorme\">".($order_s28-$s28)."</td>
		<td class=\"colorme\">".($order_s29-$s29)."</td>
		<td class=\"colorme\">".($order_s30-$s30)."</td>
		<td class=\"colorme\">".($order_s31-$s31)."</td>
		<td class=\"colorme\">".($order_s32-$s32)."</td>
		<td class=\"colorme\">".($order_s33-$s33)."</td>
		<td class=\"colorme\">".($order_s34-$s34)."</td>
		<td class=\"colorme\">".($order_s35-$s35)."</td>
		<td class=\"colorme\">".($order_s36-$s36)."</td>
		<td class=\"colorme\">".($order_s37-$s37)."</td>
		<td class=\"colorme\">".($order_s38-$s38)."</td>
		<td class=\"colorme\">".($order_s39-$s39)."</td>
		<td class=\"colorme\">".($order_s40-$s40)."</td>
		<td class=\"colorme\">".($order_s41-$s41)."</td>
		<td class=\"colorme\">".($order_s42-$s42)."</td>
		<td class=\"colorme\">".($order_s43-$s43)."</td>
		<td class=\"colorme\">".($order_s44-$s44)."</td>
		<td class=\"colorme\">".($order_s45-$s45)."</td>
		<td class=\"colorme\">".($order_s46-$s46)."</td>
		<td class=\"colorme\">".($order_s47-$s47)."</td>
		<td class=\"colorme\">".($order_s48-$s48)."</td>
		<td class=\"colorme\">".($order_s49-$s49)."</td>
		<td class=\"colorme\">".($order_s50-$s50)."</td>

		
		<td style=\"background-color:red;\"></td>

		
		<td class=\"colorme\">".($old_order_s01-$s01)."</td>
		<td class=\"colorme\">".($old_order_s02-$s02)."</td>
		<td class=\"colorme\">".($old_order_s03-$s03)."</td>
		<td class=\"colorme\">".($old_order_s04-$s04)."</td>
		<td class=\"colorme\">".($old_order_s05-$s05)."</td>
		<td class=\"colorme\">".($old_order_s06-$s06)."</td>
		<td class=\"colorme\">".($old_order_s07-$s07)."</td>
		<td class=\"colorme\">".($old_order_s08-$s08)."</td>
		<td class=\"colorme\">".($old_order_s09-$s09)."</td>
		<td class=\"colorme\">".($old_order_s10-$s10)."</td>
		<td class=\"colorme\">".($old_order_s11-$s11)."</td>
		<td class=\"colorme\">".($old_order_s12-$s12)."</td>
		<td class=\"colorme\">".($old_order_s13-$s13)."</td>
		<td class=\"colorme\">".($old_order_s14-$s14)."</td>
		<td class=\"colorme\">".($old_order_s15-$s15)."</td>
		<td class=\"colorme\">".($old_order_s16-$s16)."</td>
		<td class=\"colorme\">".($old_order_s17-$s17)."</td>
		<td class=\"colorme\">".($old_order_s18-$s18)."</td>
		<td class=\"colorme\">".($old_order_s19-$s19)."</td>
		<td class=\"colorme\">".($old_order_s20-$s20)."</td>
		<td class=\"colorme\">".($old_order_s21-$s21)."</td>
		<td class=\"colorme\">".($old_order_s22-$s22)."</td>
		<td class=\"colorme\">".($old_order_s23-$s23)."</td>
		<td class=\"colorme\">".($old_order_s24-$s24)."</td>
		<td class=\"colorme\">".($old_order_s25-$s25)."</td>
		<td class=\"colorme\">".($old_order_s26-$s26)."</td>
		<td class=\"colorme\">".($old_order_s27-$s27)."</td>
		<td class=\"colorme\">".($old_order_s28-$s28)."</td>
		<td class=\"colorme\">".($old_order_s29-$s29)."</td>
		<td class=\"colorme\">".($old_order_s30-$s30)."</td>
		<td class=\"colorme\">".($old_order_s31-$s31)."</td>
		<td class=\"colorme\">".($old_order_s32-$s32)."</td>
		<td class=\"colorme\">".($old_order_s33-$s33)."</td>
		<td class=\"colorme\">".($old_order_s34-$s34)."</td>
		<td class=\"colorme\">".($old_order_s35-$s35)."</td>
		<td class=\"colorme\">".($old_order_s36-$s36)."</td>
		<td class=\"colorme\">".($old_order_s37-$s37)."</td>
		<td class=\"colorme\">".($old_order_s38-$s38)."</td>
		<td class=\"colorme\">".($old_order_s39-$s39)."</td>
		<td class=\"colorme\">".($old_order_s40-$s40)."</td>
		<td class=\"colorme\">".($old_order_s41-$s41)."</td>
		<td class=\"colorme\">".($old_order_s42-$s42)."</td>
		<td class=\"colorme\">".($old_order_s43-$s43)."</td>
		<td class=\"colorme\">".($old_order_s44-$s44)."</td>
		<td class=\"colorme\">".($old_order_s45-$s45)."</td>
		<td class=\"colorme\">".($old_order_s46-$s46)."</td>
		<td class=\"colorme\">".($old_order_s47-$s47)."</td>
		<td class=\"colorme\">".($old_order_s48-$s48)."</td>
		<td class=\"colorme\">".($old_order_s49-$s49)."</td>
		<td class=\"colorme\">".($old_order_s50-$s50)."</td>
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

<?php include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
<?php include('../'.getFullURLLevel($_GET['r'],'/common/config/functions.php',4,'R'));?>

<!-- <?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?> -->
<script>
/*function popitup(url) {
newwindow=window.open(url,'name','scrollbars=1,menubar=1,resizable=1,location=0,toolbar=0');
if (window.focus) {newwindow.focus()}
return false;
}*/
</script>

<script>
function popitup(url) {
	var password=prompt("Please enter password","");
	if (password == "Bai@#")
	{
		newwindow=window.open(url,'name','scrollbars=1,menubar=1,resizable=1,location=0,toolbar=0');
		if (window.focus) {newwindow.focus()}
	}
	return false;
}

function popitup_new(url) {

newwindow=window.open(url,'name','scrollbars=1,menubar=1,resizable=1,location=0,toolbar=0');
if (window.focus) {newwindow.focus()}
return false;
}
</script>


<!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->
<?php include("../".getFullURLLevel($_GET['r'],'/common/config/header_scripts.php',4,'R'));?>

<div class="panel panel-primary">

<div class="panel-heading">Cut Docket View</div>
<div class="panel-body">
<?php //include("../menu_content.php"); ?>


<?php

$tran_order_tid=$_GET['order_tid'];
$cat_id=$_GET['cat_ref'];
$date=date("Y-m-d", mktime(0,0,0,date("m") ,date("d"),date("Y")));

// Review Sheets

$rev_check="F";
$sql="select * from $bai_pro3.cat_stat_log where order_tid=\"$tran_order_tid\" and tid=$cat_id";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$category=$sql_row['category'];
	$clubbing=$sql_row['clubbing'];
}

if($category=="Body" || $category=="Front")
{
	$rev_check="T";
}


$count=0;
$sql1="select count(*) as \"count\" from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\" and order_div like \"%DIM%\"";
mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$count=$sql_row1['count'];
}

// Review sheets

$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_confirm=mysqli_num_rows($sql_result);

if($sql_num_confirm>0)
{
	$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
}
else
{
	$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\"";
}
mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
	$color_back=$sql_row['order_col_des'];
		$style_back=$sql_row['order_style_no'];
		$schedule_back=$sql_row['order_del_no'];
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
	for($s=0;$s<sizeof($sizes_code);$s++)
	{
		if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
		{
			$s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
		}	
	}
	$flag = $sql_row['title_flag'];

}


$sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$tran_order_tid\" and cat_ref=$cat_id order by acutno";

mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
echo "<a class=\"btn btn-xs btn-warning\" href=\"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=$color_back&style=$style_back&schedule=$schedule_back\"><<<<< Click here to Go Back</a>";
echo "<br><br>";
echo "<table class=\"table table-bordered\">";

if($flag == 1)
{
	echo "<thead><tr class='tblheading'><th>Docket ID</th><th>Cut Number</th>";
	for($s=0;$s<sizeof($s_tit);$s++)
	{
		echo "<th>".$s_tit[$sizes_code[$s]]."</th>";
		
	}
	
	echo "<th>Plies</th><th>Controls</th>";
}
else
{
	echo "<tr class='tblheading'><th>Docket ID</th><th>CUTNO</th><th>01</th><th>02</th><th>03</th><th>04</th><th>05</th><th>06</th><th>07</th><th>08</th><th>09</th><th>10</th><th>11</th><th>12</th><th>13</th><th>14</th><th>15</th><th>16</th><th>17</th><th>18</th><th>19</th><th>20</th><th>21</th><th>22</th><th>23</th><th>24</th><th>25</th><th>26</th><th>27</th><th>28</th><th>29</th><th>30</th><th>31</th><th>32</th><th>33</th><th>34</th><th>35</th><th>36</th><th>37</th><th>38</th><th>39</th><th>40</th><th>41</th><th>42</th><th>43</th><th>44</th><th>45</th><th>46</th><th>47</th><th>48</th><th>49</th><th>50</th><th>PLIES</th><th>Controls</th>";
}



// if($rev_check=="T") { echo "<th>Review Sheets</th>";}
echo "</tr></thead>";

while($sql_row=mysqli_fetch_array($sql_result))
{
	$pcutdocid=$sql_row['doc_no'];
	$pcutno=$sql_row['acutno'];
	
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
	$a_plies=$sql_row['p_plies']; //20110911
	$remarks=$sql_row['remarks'];
	
$sql33="select * from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\"";
mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row33=mysqli_fetch_array($sql_result33))
{
$color_code=$sql_row33['color_code']; //Color Code
}

	echo "<tr>";
	echo "<td>".leading_zeros($pcutdocid,9)."</td>";
	if($remarks=="Normal")
	{
		echo "<td>".chr($color_code).leading_zeros($pcutno,3)."</td>";
	}
	else
	{
		if($remarks="Pilot")
		{
			echo "<td>Pilot</td>";
		}
	}
	for($s=0;$s<sizeof($s_tit);$s++)
	{
		$code="a_s".$sizes_code[$s];
		//echo "<th>".$s_tit[$sizes_code[$s]]."</th>";
		echo "<td>".$$code."</td>";
	}
	/*
	echo "<td>".$a_s02."</td>";
	echo "<td>".$a_s03."</td>";
	echo "<td>".$a_s04."</td>";
	echo "<td>".$a_s05."</td>";
	echo "<td>".$a_s06."</td>";
	echo "<td>".$a_s07."</td>";
	echo "<td>".$a_s08."</td>";
	echo "<td>".$a_s09."</td>";
	echo "<td>".$a_s10."</td>";
	echo "<td>".$a_s11."</td>";
	echo "<td>".$a_s12."</td>";
	echo "<td>".$a_s13."</td>";
	echo "<td>".$a_s14."</td>";
	echo "<td>".$a_s15."</td>";
	echo "<td>".$a_s16."</td>";
	echo "<td>".$a_s17."</td>";
	echo "<td>".$a_s18."</td>";
	echo "<td>".$a_s19."</td>";
	echo "<td>".$a_s20."</td>";
	echo "<td>".$a_s21."</td>";
	echo "<td>".$a_s22."</td>";
	echo "<td>".$a_s23."</td>";
	echo "<td>".$a_s24."</td>";
	echo "<td>".$a_s25."</td>";
	echo "<td>".$a_s26."</td>";
	echo "<td>".$a_s27."</td>";
	echo "<td>".$a_s28."</td>";
	echo "<td>".$a_s29."</td>";
	echo "<td>".$a_s30."</td>";
	echo "<td>".$a_s31."</td>";
	echo "<td>".$a_s32."</td>";
	echo "<td>".$a_s33."</td>";
	echo "<td>".$a_s34."</td>";
	echo "<td>".$a_s35."</td>";
	echo "<td>".$a_s36."</td>";
	echo "<td>".$a_s37."</td>";
	echo "<td>".$a_s38."</td>";
	echo "<td>".$a_s39."</td>";
	echo "<td>".$a_s40."</td>";
	echo "<td>".$a_s41."</td>";
	echo "<td>".$a_s42."</td>";
	echo "<td>".$a_s43."</td>";
	echo "<td>".$a_s44."</td>";
	echo "<td>".$a_s45."</td>";
	echo "<td>".$a_s46."</td>";
	echo "<td>".$a_s47."</td>";
	echo "<td>".$a_s48."</td>";
	echo "<td>".$a_s49."</td>";
	echo "<td>".$a_s50."</td>";
	*/
	echo "<td>".$a_plies."</td>";
	
	$path="".getFullURLLevel($_GET['r'], "Book3_print.php", "0", "R")."?order_tid=$tran_order_tid&cat_ref=$cat_id&doc_id=$pcutdocid&cut_no=$pcutno";
	if($clubbing>0)
	{
		$path="".getFullURLLevel($_GET['r'], "color_club_docket_print.php", "0", "R")."?order_tid=$tran_order_tid&cat_ref=$cat_id&doc_id=$pcutdocid&cat_title=$category&clubbing=$clubbing&cut_no=$pcutno";
	}
	
	echo "<td><a class=\"btn btn-xs btn-info\" href=\"$path\"\">View</a></td>";
	
	// if($rev_check=="T" && $count==0)
	// {
	// 	echo "<td><a class=\"btn btn-xs btn-warning\" href=\"".getFullURL($_GET['r'], "review/Print_Doc_new2.php", "R")."?&order_tid=$tran_order_tid&doc_no=$pcutdocid&cut_no=$pcutno\" onclick=\"return popitup_new("."'"."".getFullURL($_GET['r'], "review/Print_Doc_new2.php", "R")."?&order_tid=".$tran_order_tid."&doc_no=".$pcutdocid."&cut_no=".$pcutno."'".")\">Review Print</a></td>";
	// }
	// else
	// {
	// 	if($rev_check=="T") {echo "<td><a class=\"btn btn-xs btn-warning\" href=\"".getFullURL($_GET['r'], "review/Print_Doc_new2_dim.php", "N")."?order_tid=$tran_order_tid&doc_no=$pcutdocid&cut_no=$pcutno\" onclick=\"return popitup_new("."'"."".getFullURL($_GET['r'], "review/Print_Doc_new2_dim.php", "R")."?&order_tid=".$tran_order_tid."&doc_no=".$pcutdocid."&cut_no=".$pcutno."'".")\">DIM Print</a></td>"; }
	// }
	
	echo "</tr>";

}

echo "</table>";
?>

</div></div>

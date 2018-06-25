<!--
SFCS_PRO_Quality_Rej_Update
-->
<!DOCTYPE html>
<html>
<head>
</head>

<?php  

$start_timestamp = microtime(true);
ob_start();
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');

$reasons=array("Miss Yarn","Fabric Holes","Slub","Foreign Yarn","Stain Mark","Color Shade","Panel Un-Even","Stain Mark","Strip Match","Cut Dmg","Stain Mark","Heat Seal","M ment Out","Shape Out","Emb Defects");

?>



<script type="text/javascript" src="/sfcs_app/common/js/jquery.min.js" ></script>

<script type="text/javascript" src="/sfcs_app/common/js/tablefilter.js" ></script>

<script src="jquery.columnmanager/jquery.columnmanager.js"></script>
<link rel="stylesheet" type="text/css" href="jquery.columnmanager/clickmenu.css" />
<script src="jquery.columnmanager/jquery.clickmenu.pack.js"></script>
<style>
/* #page_heading
{
    	width: 100%;
	height: 25px;
    	color: WHITE;
    	background-color: #29759c;
    	z-index: -999;
    	font-family:Arial;
    	font-size:15px;  
    	margin-bottom: 10px;
}

#page_heading h3
{
	vertical-align: middle;
	margin-left: 15px;
	margin-bottom: 0;	
	padding: 0px;
}

#page_heading img
{
	margin-top: 2px;
    	margin-right: 15px;
}

body
{
	background-color: #EEEEEE;
	font-family:arial;
}

.tblheading th
{
	background-color:#29759C;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
	background-color: white;
}


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
height:35px;
}

table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: #29759C;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}






.BG {
background-image:url(Diag.gif);
background-repeat:no-repeat;/*dont know if you want this to repeat, ur choice.*/
} */

</style>


<body>
<div class="panel panel-primary">
<div class="panel-heading">Critical Rejection Report</div>
<div class="panel-body">

<?php
$sdate=time();
while((date("N",$sdate))!=1) {
$sdate=$sdate-(60*60*24); // define monday
}
$edate=$sdate+(60*60*24*5); // define sunday 
$sdate=date("Y-m-d",$sdate);
$edate=date("Y-m-d",$edate);



//echo '<div id="page_heading"><span><h3>Critical Rejection Report</h3></span></div>';


 $minrej_per="0.4%"; // FOR ENTER THE REJECTION PERCENTAGE.
 echo "<h4><span class='label label-primary'>Rejection Percentage - Above ". $minrej_per." Period From&nbsp;".$sdate."&nbsp;&nbsp;To&nbsp;&nbsp;".$edate."</span></h4>"; 
 echo "<h4><span class='label label-warning'>".date("Y-m-d H:i:s")."</span></h4>";
     	 
	$choice=1;
		
	echo "<div class=\"table-responsive\"> <table class=\"table table-bordered\">";
	echo "<tr class='tblheading' >
	<th rowspan=3>Ex factory date</th>
	<th rowspan=3>Schedule</th>
	<th rowspan=3>Style</th>
	<th rowspan=3>Color</th>
	<th rowspan=3>Order Qty</th>
	<th rowspan=3>Sewing Out</th>
	<th rowspan=3 width=45>Reject<br/> Out</th>
	<th colspan=8>Fabric</th>
	<th colspan=3>Cutting</th>
	<th colspan=11>Sewing</th>
	<th colspan=3>Machine Damages</th>
	<th colspan=8>Embellishment</th>
</tr>";


echo "<tr>
	<th width=45>Miss</th>	<th width=45>Fabric </th>	<th width=45>Slub</th>	<th width=45 >Foreign </th>	<th width=45>Stain </th>	<th width=45>Color </th> <th width=45> Heat </th> <th width=45> Trim </th>	<th width=45 >Panel</th> <th  width=45>Stain</th>		<th width=45>Strip</th>	<th width=45>Cut</th> <th  width=45>Heat</th>	<th  width=45> M'ment </th>  <th  width=45> Un </th> <th width=45>Shape </th>	<th width=45>Shape</th>	<th width=45 >Shape </th>	<th width=45>Stain </th>	<th width=45>With</th> <th width=45>Trim</th>  <th width=45>Sewing</th>  <th width=45>Cut</th>   <th width=45>Slip</th>  <th width=45>Oil</th> <th width=45>Others</th>  <th width=45>Foil</th>  <th width=45>Embroidery</th> <th width=45>Print</th>  <th width=45>Sequence</th>  <th width=45>Bead</th>  <th width=45>Dye</th>  <th width=45>Wash</th>

</tr>";

echo "<tr>
	<th>Yarn</th>	<th>Holes</th>	<th></th>	<th>Yarn</th>	<th>Mark </th>	<th>Shade</th> <th> seal </th> <th></th>	<th>Un-Even</th> <th>Mark</th>		<th>Match</th>	<th>Dmg</th> <th>Seal</th> <th>out</th>	 <th>Even</th><th>OutLeg </th>	<th>Outwaist</th>	<th>Out</th>	<th>Mark </th>	<th>OutLabel</th> <th>Shortage</th> <th>Excess</th> <th>Holes</th> <th>Stitch's</th> <th>Marks</th> <th>EMB</th> <th>Defects</th> <th></th>  <th></th> <th></th><th></th><th></th><th></th>

</tr>";


$sql="select distinct concat(schedule_no,color),schedule_no,style,color,ex_factory_date_new from $bai_pro4.week_delivery_plan_ref where schedule_no is not null and ex_factory_date_new between \"$sdate\" and \"$edate\" order by ex_factory_date_new desc ";
	// echo $sql;
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sch_db_grand=array();
	$sty_db_grand=array();
	$sch_color=array();
	$ex_fact_date=array();
	
	
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$sch_db_grand[]=$sql_row['schedule_no'];
		$sty_db_grand[]=$sql_row['style'];
	    $sch_color[]=$sql_row['color'];
		$ex_fact_date[]=$sql_row['ex_factory_date_new'];
	}
	for($j=0;$j<sizeof($sty_db_grand);$j++)
	{ 
		
		$grand_vals=array();
		for($i=0;$i<33;$i++) { $grand_vals[$i]=0; }
		$grand_output=0;
		$grand_rejections=0;

		if(sizeof(explode(",",$sch_db_grand[$j]))==1)
		{
			$sql1="select sum(bac_Qty) as \"qty\",delivery,size,bac_no,color from $bai_pro.bai_log_view where delivery in ($sch_db_grand[$j]) and color=\"$sch_color[$j]\" and length(size)>0 group by delivery,color,size";
		}
			
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$sw_out=$sql_row1['qty'];	
			$sch_db=$sql_row1['delivery'];
			$size=$sql_row1['size'];
			$mod=$sql_row1['bac_no'];	
			$color=$sql_row1['color'];
			$qms_qty=0;
			$ref1="";
			
			if($choice==1)
			{
				$sql="select qms_size,qms_style,qms_schedule,qms_color,substring_index(substring_index(remarks,\"-\",2),\"-\",-1) as \"shift\",log_date,group_concat(ref1,\"$\") as \"ref1\",coalesce(sum(qms_qty),0) as \"qms_qty\" from $bai_pro3.bai_qms_db where substring_index(substring_index(remarks,\"-\",2),\"-\",-1) in (\"A\",\"B\") and qms_size=\"$size\" and qms_tran_type=3 and qms_schedule in ($sch_db) group by qms_style,qms_schedule,qms_color,qms_size order by qms_style,qms_schedule,qms_color,qms_size";
			}
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$qms_qty=$sql_row['qms_qty'];
				$ref1=$sql_row['ref1'];	
			}

			if($choice==1)
			{
				$sql11="select * from bai_pro3.bai_orders_db_confirm where order_del_no=\"".$sch_db."\" ";
				$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row11=mysqli_fetch_array($sql_result11))
				{
					$style=$sql_row11['order_style_no'];
					$schedule=$sql_row11['order_del_no'];
					$size_xs=$sql_row11['order_s_xs'];
					$size_s=$sql_row11['order_s_s'];
					$size_m=$sql_row11['order_s_m'];
					$size_l=$sql_row11['order_s_l'];
					$size_xl=$sql_row11['order_s_xl'];
					$size_xxl=$sql_row11['order_s_xxl'];
					$size_xxxl=$sql_row11['order_s_xxxl'];
					$size_s01=$sql_row11['order_s_s01'];
					$size_s02=$sql_row11['order_s_s02'];
					$size_s03=$sql_row11['order_s_s03'];
					$size_s04=$sql_row11['order_s_s04'];
					$size_s05=$sql_row11['order_s_s05'];
					$size_s06=$sql_row11['order_s_s06'];
					$size_s07=$sql_row11['order_s_s07'];
					$size_s08=$sql_row11['order_s_s08'];
					$size_s09=$sql_row11['order_s_s09'];
					$size_s10=$sql_row11['order_s_s10'];
					$size_s11=$sql_row11['order_s_s11'];
					$size_s12=$sql_row11['order_s_s12'];
					$size_s13=$sql_row11['order_s_s13'];
					$size_s14=$sql_row11['order_s_s14'];
					$size_s15=$sql_row11['order_s_s15'];
					$size_s16=$sql_row11['order_s_s16'];
					$size_s17=$sql_row11['order_s_s17'];
					$size_s18=$sql_row11['order_s_s18'];
					$size_s19=$sql_row11['order_s_s19'];
					$size_s20=$sql_row11['order_s_s20'];
					$size_s21=$sql_row11['order_s_s21'];
					$size_s22=$sql_row11['order_s_s22'];
					$size_s23=$sql_row11['order_s_s23'];
					$size_s24=$sql_row11['order_s_s24'];
					$size_s25=$sql_row11['order_s_s25'];
					$size_s26=$sql_row11['order_s_s26'];
					$size_s27=$sql_row11['order_s_s27'];
					$size_s28=$sql_row11['order_s_s28'];
					$size_s29=$sql_row11['order_s_s29'];
					$size_s30=$sql_row11['order_s_s30'];
					$size_s31=$sql_row11['order_s_s31'];
					$size_s32=$sql_row11['order_s_s32'];
					$size_s33=$sql_row11['order_s_s33'];
					$size_s34=$sql_row11['order_s_s34'];
					$size_s35=$sql_row11['order_s_s35'];
					$size_s36=$sql_row11['order_s_s36'];
					$size_s37=$sql_row11['order_s_s37'];
					$size_s38=$sql_row11['order_s_s38'];
					$size_s39=$sql_row11['order_s_s39'];
					$size_s40=$sql_row11['order_s_s40'];
					$size_s41=$sql_row11['order_s_s41'];
					$size_s42=$sql_row11['order_s_s42'];
					$size_s43=$sql_row11['order_s_s43'];
					$size_s44=$sql_row11['order_s_s44'];
					$size_s45=$sql_row11['order_s_s45'];
					$size_s46=$sql_row11['order_s_s46'];
					$size_s47=$sql_row11['order_s_s47'];
					$size_s48=$sql_row11['order_s_s48'];
					$size_s49=$sql_row11['order_s_s49'];
					$size_s50=$sql_row11['order_s_s50'];
				}
			}
			$order_qty=$size_xs+$size_s+$size_m+$size_l+$size_xl+$size_xxl+$size_xxxl+$size_s01+$size_s02+$size_s03+$size_s04+$size_s05+$size_s06+$size_s07+$size_s08+$size_s09+$size_s10+$size_s11+$size_s12+$size_s13+$size_s14+$size_s15+$size_s16+$size_s17+$size_s18+$size_s19+$size_s20+$size_s21+$size_s22+$size_s23+$size_s24+$size_s25+$size_s26+$size_s27+$size_s28+$size_s29+$size_s30+$size_s31+$size_s32+$size_s33+$size_s34+$size_s35+$size_s36+$size_s37+$size_s38+$size_s39+$size_s40+$size_s41+$size_s42+$size_s43+$size_s44+$size_s45+$size_s46+$size_s47+$size_s48+$size_s49+$size_s50;
			
			$span3='</p>';
			$span4='</p></p>';
			$vals=array();
			$rej_val=array(0,1,2,3,4,5,15,16,6,7,8,9,11,12,17,18,19,13,10,20,21,22,23,24,25,14,26,27,28,29,30,31,32);
			for($i=0;$i<33;$i++) {	$vals[$i]=0;	}
			
			$temp=array();
			$temp=explode("$",str_replace(",","$",$ref1));
			
			for($i=0;$i<sizeof($temp);$i++)
			{
			$span1='<p style="text-align: left;">';
			$span2='<p style="padding-left:20px; margin-top:-20px; position:relative; ">';
				if(strlen($temp[$i])>0)
				{
					$temp2=array();
					$temp2=explode("-",$temp[$i]);
					$x=$temp2[0];
					$vals[$x]+=$temp2[1];
					$grand_vals[$x]+=$temp2[1];
				}
			}
			$grand_output+=$sw_out;
			$grand_rejections+=$qms_qty;
		}
		if($grand_output>0)
		{
			$rej_per=round(($grand_rejections/$grand_output)*100,1)."%"."</br>";
			if($rej_per >= $minrej_per)
			{
				// for  total values of rejections
				
				echo "<tr bgcolor=white rowspan=2>";
				echo "<td rowspan=2>".$ex_fact_date[$j]."</td>";
				echo "<td rowspan=2>".$schedule."</td>";
				echo "<td rowspan=2>".$style."</td>";
				echo "<td rowspan=2>".$color."</td>";	
				echo "<td rowspan=2>".$order_qty."</td>";
				echo "<td rowspan=2>".$grand_output."</td>";
				echo "<td rowspan=2 class=\"BG\">$span1".$grand_rejections."$span3"; 
				if($grand_output>0)
				{
					echo $rej_per;	 
				}
				echo "$span3</td>";
				
				for($i=0;$i<33;$i++) {	
					if($i<8)
					{
						$bgcolor=" bgcolor=white";
					}
					
					if($i>7 and $i<11)
					{
						$bgcolor=" bgcolor=white";
					}
					if($i>10 and $i<22)
					{
							$bgcolor=" bgcolor=white";
					}
					if($i>21 and $i<25)
					{
						$bgcolor=" bgcolor=white";
					}
					if($i>24)
					{
							$bgcolor=" bgcolor=white";
					}
				/*	if($i<6)
					{
						$bgcolor=" bgcolor=white ";
					}
					if($i>5 and $i<9)
					{
						$bgcolor=" bgcolor=white";
					}
					if($i>8 and $i<14)
					{
						$bgcolor=" bgcolor=white";
					}
					if($i>13)
					{
						$bgcolor=" bgcolor=white";
					}*/
				//BG Color
					
				echo "<td class=\"BG\" $bgcolor>$span1".$grand_vals[$rej_val[$i]]."$span3$span2"; if($grand_output>0) { echo round(($grand_vals[$rej_val[$i]]/$grand_output)*100,1)."%"; } echo "$span3</td>";
				
				//echo "<td>".$vals[$i]."</td>";	
				}
				echo "</tr>";
				

				// for grand total values of rejections
				echo "<tr>";
				$bgcolor=" bgcolor=white";
				
				echo "<td class=\"BG\" $bgcolor colspan=8>$span1".($grand_vals[0]+$grand_vals[1]+$grand_vals[2]+$grand_vals[3]+$grand_vals[4]+$grand_vals[5]+$grand_vals[15]+$grand_vals[16])."$span3$span2"; if($grand_output>0) { echo round((($grand_vals[0]+$grand_vals[1]+$grand_vals[2]+$grand_vals[3]+$grand_vals[4]+$grand_vals[5]+$grand_vals[15]+$grand_vals[16])/$grand_output)*100,1)."%"; } echo "$span3</td>";

				$bgcolor=" bgcolor=white";
				
				echo "<td class=\"BG\" $bgcolor colspan=3>$span1".($grand_vals[6]+$grand_vals[7]+$grand_vals[8])."$span3$span2"; if($grand_output>0) { echo round((($grand_vals[6]+$grand_vals[7]+$grand_vals[8])/$grand_output)*100,1)."%"; } echo "$span3</td>";

				$bgcolor=" bgcolor=white";
				
				echo "<td class=\"BG\" $bgcolor colspan=11>$span1".($grand_vals[9]+$grand_vals[11]+$grand_vals[12]+$grand_vals[17]+$grand_vals[18]+$grand_vals[19]+$grand_vals[13]+$grand_vals[10]+$grand_vals[20]+$grand_vals[21]+$grand_vals[22])."$span3$span2"; if($grand_output>0) { echo round((($grand_vals[9]+$grand_vals[11]+$grand_vals[12]+$grand_vals[17]+$grand_vals[18]+$grand_vals[19]+$grand_vals[13]+$grand_vals[10]+$grand_vals[20]+$grand_vals[21]+$grand_vals[22])/$grand_output)*100,1)."%"; } echo "$span3</td>";
			
				$bgcolor=" bgcolor=white";
				
				echo "<td class=\"BG\" $bgcolor colspan=3>$span1".($grand_vals[23]+$grand_vals[24]+$grand_vals[25])."$span3$span2"; if($grand_output>0) { echo round((($grand_vals[23]+$grand_vals[24]+$grand_vals[25])/$grand_output)*100,1)."%"; } echo "$span3</td>";
				
				
				$bgcolor=" bgcolor=white";
				
				echo "<td class=\"BG\" $bgcolor colspan=8>$span1".($grand_vals[14]+$grand_vals[26]+$grand_vals[27]+$grand_vals[28]+$grand_vals[29]+$grand_vals[30]+$grand_vals[31]+$grand_vals[32])."$span3$span2"; if($grand_output>0) { echo round((($grand_vals[14]+$grand_vals[26]+$grand_vals[27]+$grand_vals[28]+$grand_vals[29]+$grand_vals[30]+$grand_vals[31]+$grand_vals[32])/$grand_output)*100,1)."%"; } echo "$span3</td>";
				echo "</tr>";
			}
		}
	}
echo "</table></div>";

echo "<h2><span class='label label-primary'>Summary of Details</span></h2>";

echo '<div class="table-responsive"> <table id="tableone" cellspacing="0" class="mytable table table-bordered">';
	echo "<tr class='tblheading' >
	<th  class='filter'>Ex_factory</th>
	<th  class='filter'>Schedule</th>
	<th  class='filter'>Style</th>
	<th  class='filter'>Color</th>
	
	<th  class='filter'>Section</th>
	<th  class='filter'>Module</th>
	<th  class='filter'>Order <br/> Qty</th>
	<th  class='filter'>Sewing <br/> Out</th>
	<th  class='filter'>Rejection <br/> Out</th>
	<th  class='filter'>Rej %</th>
	<th  class='filter'>Fabric <br/> Damages</th>
	<th  class='filter'> % </th>
	<th  class='filter'>Cutting <br/> Damages</th>
	<th  class='filter'> % </th>
	<th  class='filter'>Sewing <br/> Damages</th>
	<th  class='filter'> % </th>
	<th  class='filter'>Machine <br/> Damages</th>
	<th  class='filter'> % </th>
	<th  class='filter'>Embl <br/> Damages</th>
	<th  class='filter'> % </th> </tr>";
  
	$sql="select distinct concat(schedule_no,color),schedule_no,style,color,ex_factory_date_new from $bai_pro4.week_delivery_plan_ref where schedule_no is not null and ex_factory_date_new between \"$sdate\" and \"$edate\" order by ex_factory_date_new desc ";
    //echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sch_db_grand=array();
	$sty_db_grand=array();
	$sch_color=array();
	$ex_fact_date=array();
	
	
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$sch_db_grand[]=$sql_row['schedule_no'];
		$sty_db_grand[]=$sql_row['style'];
	    $sch_color[]=$sql_row['color'];
		$ex_fact_date[]=$sql_row['ex_factory_date_new'];
		
		
	}
	
	for($j=0;$j<sizeof($sty_db_grand);$j++)
	{
		
	$grand_vals=array();
	for($i=0;$i<33;$i++) {$grand_vals[$i]=0;}
	$grand_output=0;
	$grand_rejections=0;

		if(sizeof(explode(",",$sch_db_grand[$j]))==1)
		{
		$sql1="select sum(bac_Qty) as \"qty\",delivery,size,group_concat(distinct(bac_no)) as bac_no,color from $bai_pro.bai_log_view where length(size)>0 and delivery in ($sch_db_grand[$j]) and color=\"$sch_color[$j]\" and length(size)>0 group by delivery,color,size";
		}
			
		//echo "<br/>inner part: ".$sql1;
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
		$sw_out=$sql_row1['qty'];	
		$sch_db=$sql_row1['delivery'];
		$size=$sql_row1['size'];
		$mod=$sql_row1['bac_no'];	
		$color=$sql_row1['color'];
		$qms_qty=0;
		$ref1="";
		$module=0;
		$qms_size="";
		
if($choice==1)
{
/*
	$sql="select qms_size,qms_style,qms_schedule,qms_color,substring_index(substring_index(remarks,\"-\",2),\"-\",-1) as 
	\"shift\",substring_index(substring_index(remarks,\"-\",1),\"-\",-1) as \"module\",log_date,group_concat(ref1,\"$\") as \"ref1\",
	coalesce(sum(qms_qty),0) as \"qms_qty\" from bai_qms_db where substring_index(substring_index(remarks,\"-\",2),\"-\",-1) in (\"A\",\"B\") 
	and qms_size=\"$size\" and qms_tran_type=3 and qms_schedule in ($sch_db) group by qms_style,qms_schedule,qms_color,qms_size 
	order by qms_style,qms_schedule,qms_color,qms_size";
*/
	$sql="select qms_size,qms_style,qms_schedule,qms_color,substring_index(substring_index(remarks,\"-\",2),\"-\",-1) as \"shift\",
substring_index(substring_index(remarks,\"-\",1),\"-\",-1) as \"module\",log_date,group_concat(ref1,\"$\") as \"ref1\",
coalesce(sum(qms_qty),0) as \"qms_qty\" ,section_id
from $bai_pro3.bai_qms_db a join bai_pro3.plan_modules b on substring_index(substring_index(a.remarks,\"-\",1),\"-\",-1)=b.module_id 
where substring_index(substring_index(remarks,\"-\",2),\"-\",-1) in (\"A\",\"B\") and qms_size=\"$size\" and 
qms_tran_type=3 and qms_schedule in (".$sch_db.") group by qms_style,qms_schedule,qms_color,qms_size order by qms_style,qms_schedule,qms_color,qms_size
";
	
	
	
}


//	echo " <br>".$sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$qms_qty=$sql_row['qms_qty'];
		$ref1=$sql_row['ref1'];	
		$module=$sql_row['module'];
		$qms_size=$sql_row['qms_size'];
		$section=$sql_row['section_id'];
		
	}
	
//	echo "<br/>".$module;
	
		//to avoid shoiwng module as 0 or 'ENP' taking the module number from bai_log
		if ((!(is_numeric($module))) or $module==0) 
		{
			$module=$mod;
			
		//	echo "<br/> module".$module;
			
		}
		/*
		$section_modules=array();
		$section=0;
		$sql_section="SELECT sec_mods,sec_id FROM bai_pro3.sections_db where sec_mods like '%".$module."%' and sec_id!=0 and sec_id!=-1";
		
		//echo "<br/>".$sql_section."<br/>";
		
		$sql_result_section=mysql_query($sql_section,$link) or exit("Sql Error".mysql_error());
		while($sql_row_section=mysql_fetch_array($sql_result_section))
		{
			$sec_mods=$sql_row_section['sec_mods'];
			$sec_id=$sql_row_section['sec_id'];
			
			$section_modules=explode(",",$sec_mods);
			
			for($i=0;$i<sizeof($section_modules);$i++)
			{
				if($section_modules[$i]==$module)
				{
					$section=$sec_id;	
				}
				
			}
			
		}
		*/
		
		if($choice==1)
		{
			$sql11="select * from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$sch_db."\" ";
			//echo $sql11;
			$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row11=mysqli_fetch_array($sql_result11))
			{
				$style=$sql_row11['order_style_no'];
				$schedule=$sql_row11['order_del_no'];
				$size_xs=$sql_row11['order_s_xs'];
				$size_s=$sql_row11['order_s_s'];
				$size_m=$sql_row11['order_s_m'];
				$size_l=$sql_row11['order_s_l'];
				$size_xl=$sql_row11['order_s_xl'];
				$size_xxl=$sql_row11['order_s_xxl'];
				$size_xxxl=$sql_row11['order_s_xxxl'];
				$size_s01=$sql_row11['order_s_s01'];
				$size_s02=$sql_row11['order_s_s02'];
				$size_s03=$sql_row11['order_s_s03'];
				$size_s04=$sql_row11['order_s_s04'];
				$size_s05=$sql_row11['order_s_s05'];
				$size_s06=$sql_row11['order_s_s06'];
				$size_s07=$sql_row11['order_s_s07'];
				$size_s08=$sql_row11['order_s_s08'];
				$size_s09=$sql_row11['order_s_s09'];
				$size_s10=$sql_row11['order_s_s10'];
				$size_s11=$sql_row11['order_s_s11'];
				$size_s12=$sql_row11['order_s_s12'];
				$size_s13=$sql_row11['order_s_s13'];
				$size_s14=$sql_row11['order_s_s14'];
				$size_s15=$sql_row11['order_s_s15'];
				$size_s16=$sql_row11['order_s_s16'];
				$size_s17=$sql_row11['order_s_s17'];
				$size_s18=$sql_row11['order_s_s18'];
				$size_s19=$sql_row11['order_s_s19'];
				$size_s20=$sql_row11['order_s_s20'];
				$size_s21=$sql_row11['order_s_s21'];
				$size_s22=$sql_row11['order_s_s22'];
				$size_s23=$sql_row11['order_s_s23'];
				$size_s24=$sql_row11['order_s_s24'];
				$size_s25=$sql_row11['order_s_s25'];
				$size_s26=$sql_row11['order_s_s26'];
				$size_s27=$sql_row11['order_s_s27'];
				$size_s28=$sql_row11['order_s_s28'];
				$size_s29=$sql_row11['order_s_s29'];
				$size_s30=$sql_row11['order_s_s30'];
				$size_s31=$sql_row11['order_s_s31'];
				$size_s32=$sql_row11['order_s_s32'];
				$size_s33=$sql_row11['order_s_s33'];
				$size_s34=$sql_row11['order_s_s34'];
				$size_s35=$sql_row11['order_s_s35'];
				$size_s36=$sql_row11['order_s_s36'];
				$size_s37=$sql_row11['order_s_s37'];
				$size_s38=$sql_row11['order_s_s38'];
				$size_s39=$sql_row11['order_s_s39'];
				$size_s40=$sql_row11['order_s_s40'];
				$size_s41=$sql_row11['order_s_s41'];
				$size_s42=$sql_row11['order_s_s42'];
				$size_s43=$sql_row11['order_s_s43'];
				$size_s44=$sql_row11['order_s_s44'];
				$size_s45=$sql_row11['order_s_s45'];
				$size_s46=$sql_row11['order_s_s46'];
				$size_s47=$sql_row11['order_s_s47'];
				$size_s48=$sql_row11['order_s_s48'];
				$size_s49=$sql_row11['order_s_s49'];
				$size_s50=$sql_row11['order_s_s50'];
	
			}
		}
		$order_qty=$size_xs+$size_s+$size_m+$size_l+$size_xl+$size_xxl+$size_xxxl+$size_s01+$size_s02+$size_s03+$size_s04+$size_s05+$size_s06+$size_s07+$size_s08+$size_s09+$size_s10+$size_s11+$size_s12+$size_s13+$size_s14+$size_s15+$size_s16+$size_s17+$size_s18+$size_s19+$size_s20+$size_s21+$size_s22+$size_s23+$size_s24+$size_s25+$size_s26+$size_s27+$size_s28+$size_s29+$size_s30+$size_s31+$size_s32+$size_s33+$size_s34+$size_s35+$size_s36+$size_s37+$size_s38+$size_s39+$size_s40+$size_s41+$size_s42+$size_s43+$size_s44+$size_s45+$size_s46+$size_s47+$size_s48+$size_s49+$size_s50;
		
		
		
		$span1='<p style="text-align: left;">';
		$span2='<p style="padding-left:20px; margin-top:-20px; position:relative; ">';
		$span3='</p>';
		$span4='</p></p>';
		
		$vals=array();
		$rej_val=array(0,1,2,3,4,5,15,16,6,7,8,9,11,12,17,18,19,13,10,20,21,22,23,24,25,14,26,27,28,29,30,31,32);
		for($i=0;$i<33;$i++) {	$vals[$i]=0;	}
		
		$temp=array();
		$temp=explode("$",str_replace(",","$",$ref1));
		
		for($i=0;$i<sizeof($temp);$i++)
		{
			if(strlen($temp[$i])>0)
			{
				$temp2=array();
				$temp2=explode("-",$temp[$i]);
				$x=$temp2[0];
				$vals[$x]+=$temp2[1];
				$grand_vals[$x]+=$temp2[1];
			}
		}
		$grand_output+=$sw_out;
		$grand_rejections+=$qms_qty;
}

 if($grand_output>0)
 {
  $rej_per=round(($grand_rejections/$grand_output)*100,1)."%"."</br>";

     if($rej_per >= $minrej_per)
	 
	 {
	 	
	 
// for  total values of rejections
	$array_val=array('exfact'=>$ex_fact_date[$j],'schedule'=>$schedule,'style'=>$style,'colour'=>$color,'orderqty'=>$order_qty,'grandoutput'=>$grand_output,'grdrej'=>$grand_rejections,'rejper'=>$rej_per,'module'=>$module,'section'=>$section);
	//echo $array_val['exfact']."&nbsp;".$array_val['schedule'];
	
	echo "<tr bgcolor=white style=align:center;>";
		echo "<td style='text-align: center;' >".$array_val['exfact']."</td>";
		echo "<td style='text-align: center;'>".$array_val['schedule']."</td>";
		echo "<td style='text-align: center;'>".$array_val['style']."</td>";
		echo "<td style='text-align: center;'>".$array_val['colour']."</td>";
		
		echo "<td style='text-align: center;'>".$array_val['section']."</td>";
		echo "<td style='text-align: center;'>".$array_val['module']."</td>";	
		echo "<td style='text-align: center;'>".$array_val['orderqty']."</td>";
	    echo "<td style='text-align: center;'>".$array_val['grandoutput']."</td>";
	    echo "<td style='text-align: center;'>".$array_val['grdrej']."</td>";
	    echo "<td style='text-align: center;'>".$array_val['rejper']."</td>";	 
		echo "<td style='text-align: center;'>".($grand_vals[0]+$grand_vals[1]+$grand_vals[2]+$grand_vals[3]+$grand_vals[4]+$grand_vals[5]+$grand_vals[15]+$grand_vals[16])."</td>";
	  	echo "<td style='text-align: center;'>".round((($grand_vals[0]+$grand_vals[1]+$grand_vals[2]+$grand_vals[3]+$grand_vals[4]+$grand_vals[5]+$grand_vals[15]+$grand_vals[16])/$grand_output)*100,1)."%</td>";
		
		echo "<td style='text-align: center;'>".($grand_vals[6]+$grand_vals[7]+$grand_vals[8])."</td>";
		echo "<td style='text-align: center;'>".round((($grand_vals[6]+$grand_vals[7]+$grand_vals[8])/$grand_output)*100,1)."%</td>";

		echo "<td style='text-align: center;'>".($grand_vals[9]+$grand_vals[11]+$grand_vals[12]+$grand_vals[17]+$grand_vals[18]+$grand_vals[19]+$grand_vals[13]+$grand_vals[10]+$grand_vals[20]+$grand_vals[21]+$grand_vals[22])."</td>";
		echo "<td style='text-align: center;'>".round((($grand_vals[9]+$grand_vals[11]+$grand_vals[12]+$grand_vals[17]+$grand_vals[18]+$grand_vals[19]+$grand_vals[13]+$grand_vals[10]+$grand_vals[20]+$grand_vals[21]+$grand_vals[22])/$grand_output)*100,1)."%</td>";
		
		echo "<td style='text-align: center;'>".($grand_vals[23]+$grand_vals[24]+$grand_vals[25])."</td>";
		echo "<td style='text-align: center;'>".round((($grand_vals[23]+$grand_vals[24]+$grand_vals[25])/$grand_output)*100,1)."%</td>";
		
	    echo "<td style='text-align: center;'>".($grand_vals[14]+$grand_vals[26]+$grand_vals[27]+$grand_vals[28]+$grand_vals[29]+$grand_vals[30]+$grand_vals[31]+$grand_vals[32])."$span3$span2"."</td>";
		echo "<td style='text-align: center;'>".round((($grand_vals[14]+$grand_vals[26]+$grand_vals[27]+$grand_vals[28]+$grand_vals[29]+$grand_vals[30]+$grand_vals[31]+$grand_vals[32])/$grand_output)*100,1)."%</td>";
		echo "</tr>";
	}
	}
	}
echo "</table></div>";	
	?>
	<script language="javascript" type="text/javascript">
//<![CDATA[
var table2Filters = {
		btn: true,
		loader: true,
		loader_text: "Filtering data...",
		sort_select: true,
		exact_match: true,
		rows_counter: true,
		btn_reset: true
		
	}
	setFilterGrid("tableone",0,table2Filters);
	
//]]>
</script>
<?php
$cache_date="critical_rejection_report";
$cachefile = $path."/quality/reports/".$cache_date.'.htm';
// saving captured output to file
file_put_contents($cachefile, ob_get_contents());
// end buffering and displaying page
ob_end_flush();

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
echo "Execution took ".$duration." milliseconds.";
?>

</div></div>

</body>
</html>
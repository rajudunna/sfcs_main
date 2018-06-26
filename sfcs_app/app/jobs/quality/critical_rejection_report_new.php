<!--
SFCS_PRO_Quality_Rej_Update_Size_wise
-->
<html>
<head>
<?php  
$start_timestamp = microtime(true);
// Start output buffering
ob_start();
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');

set_time_limit(1600000);

// $reasons=array("Miss Yarn","Fabric Holes","Slub","Foreign Yarn","Stain Mark","Color Shade","Panel Un-Even","Stain Mark","Strip Match","Cut Dmg","Stain Mark","Heat Seal","M ment Out","Shape Out","Emb Defects");

?>

<script>
       
</script>
<script type="text/javascript" src="/sfcs_app/common/js/jquery.min.js" ></script>

<script type="text/javascript" src="/sfcs_app/common/js/tablefilter.js" ></script>

<script src="jquery.columnmanager/jquery.columnmanager.js"></script>
<link rel="stylesheet" type="text/css" href="jquery.columnmanager/clickmenu.css" />
<script src="jquery.columnmanager/jquery.clickmenu.pack.js"></script>
<style>
/* @import "TableFilter_EN/filtergrid.css";    
#page_heading
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
background-repeat:no-repeat;/*dont know if you want this to repeat, ur choice.
} */



</style>
<script type="text/javascript" src="datetimepicker_css.js"></script>

</head>
<body>
	<div class='panel panel-primary'>
	<div class="panel-heading">Critical Rejection Report</div>
	<div class='panel-body'>
<?php
$sdate=time();
while((date("N",$sdate))!=1) {
$sdate=$sdate-(60*60*24); // define monday
}
$edate=$sdate+(60*60*24*5); // define sunday 

//$edate=$sdate+(60*60*24*1);

// $sdate=date("Y-m-d",$sdate);
// $edate=date("Y-m-d",$edate);

// $sdate=date("2017-09-01",$sdate);
// $edate=date("2017-09-07",$edate);


$minrej_per="0.4%"; // FOR ENTER THE REJECTION PERCENTAGE.

 echo "<div><h4><span class='label label-primary'>Rejection Percentage - Above ".$minrej_per." Period From&nbsp;".$sdate."&nbsp;&nbsp;To&nbsp;&nbsp;".$edate."</span></h4>"; 
 echo "<h4><span class='label label-primary'>".date("Y-m-d H:i:s")."</span></h4></div>";
 
     
	 
	$choice=1;
			
echo "<h4><span class='label label-warning'>Summary of Details</span></h4>";

echo '<table id="tableone" cellspacing="0" class="mytable table table-bordered">';
	echo "<tr class='tblheading' >
	<th  class='filter'>Ex_factory</th>
	<th  class='filter'>Schedule</th>
	<th  class='filter'>Style</th>
	<th  class='filter'>Color</th>
	<th  class='filter'>Size</th>
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
	
	//echo "<br/>".$sql."<br/>";
	
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
		$section=0;
		
if($choice==1)
{
	$sql="select qms_size,qms_style,qms_schedule,qms_color,substring_index(substring_index(remarks,\"-\",2),\"-\",-1) as \"shift\",
substring_index(substring_index(remarks,\"-\",1),\"-\",-1) as \"module\",log_date,group_concat(ref1,\"$\") as \"ref1\",
coalesce(sum(qms_qty),0) as \"qms_qty\" ,section_id
from $bai_pro3.bai_qms_db a join bai_pro3.plan_modules b on substring_index(substring_index(a.remarks,\"-\",1),\"-\",-1)=b.module_id 
where substring_index(substring_index(remarks,\"-\",2),\"-\",-1) in (\"A\",\"B\") and qms_size=\"$size\" and 
qms_tran_type=3 and qms_schedule in (".$sch_db.") group by qms_style,qms_schedule,qms_color,qms_size order by qms_style,qms_schedule,qms_color,qms_size
";
}

	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$qms_qty=$sql_row['qms_qty'];
		$ref1=$sql_row['ref1'];	
		$module=$sql_row['module'];
		$qms_size=$sql_row['qms_size'];
		
		$qms_schedule=$sql_row['qms_schedule'];
		
		$section=$sql_row['section_id'];
		
		//echo "<br/><br/>REF<br/>".$ref1."<br/>";
		
	}
		
		if ((!(is_numeric($module))) or $module==0) 
		{
			$module=$mod;
			
			//echo "<br/> module".$module;
			
		}
		
		//echo "<br/> qms schedule ".$qms_schedule."<br/>size of module".sizeof(explode(",",$module))."<br/>";
		

		if($choice==1)
		{
			$sql11="select order_style_no,order_del_no,order_s_".$size." as order_size_qty from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$sch_db."\" ";
			//echo $sql11;
			$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row11=mysqli_fetch_array($sql_result11))
			{
				$style=$sql_row11['order_style_no'];
				$schedule=$sql_row11['order_del_no'];
				$order_size_qty=$sql_row11['order_size_qty'];
	
			}
		}
		
		$order_qty=$order_size_qty;
		
		$span1='<p style="text-align: left;">';
		$span2='<p style="padding-left:20px; margin-top:-20px; position:relative; ">';
		$span3='</p>';
		$span4='</p></p>';
		
		$vals=array();
		$rej_val=array(0,1,2,3,4,5,15,16,6,7,8,9,11,12,17,18,19,13,10,20,21,22,23,24,25,14,26,27,28,29,30,31,32);
		for($i=0;$i<33;$i++) {	$vals[$i]=0; $grand_vals[$i]=0;	}
		
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
				
				//echo "<br/>".$x."----".$vals[$x]."------".$grand_vals[$x]."<br/>";
				
				}						
			}
			//$grand_output+=$sw_out;
			//$grand_rejections+=$qms_qty;
		
		$grand_output=$sw_out;
		$grand_rejections=$qms_qty;
		

		   		if($grand_output>0)
		 		{
		    		 $rej_per=round(($grand_rejections/$grand_output)*100,1)."%"."</br>";

		     		if($rej_per >= $minrej_per) 
					 {
	 	
	 
// for  total values of rejections
	$array_val=array('exfact'=>$ex_fact_date[$j],'schedule'=>$schedule,'style'=>$style,'colour'=>$color,'orderqty'=>$order_qty,'grandoutput'=>$grand_output,'grdrej'=>$grand_rejections,'rejper'=>$rej_per,'module'=>$module,'section'=>$section,'size'=>$qms_size);
	//echo $array_val['exfact']."&nbsp;".$array_val['schedule'];
	
	echo "<tr bgcolor=white style=align:center;>";
		echo "<td style='text-align: center;' >".$array_val['exfact']."</td>";
		echo "<td style='text-align: center;'>".$array_val['schedule']."</td>";
		echo "<td style='text-align: center;'>".$array_val['style']."</td>";
		echo "<td style='text-align: center;'>".$array_val['colour']."</td>";
		echo "<td style='text-align: center;'>".$array_val['size']."</td>";	
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
	}
echo "</table>";	
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
$cache_date="critical_rejection_report_new";
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



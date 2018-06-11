
<?php
$start_date_w=time();

while((date("N",$start_date_w))!=1) {
$start_date_w=$start_date_w-(60*60*24); // define monday
}
$end_date_w=$start_date_w+(60*60*24*6); // define sunday

//echo date("Y-m-d",$end_date_w)."<br/>";
//echo date("Y-m-d",$start_date_w);
$start_date_w=date("Y-m-d",$start_date_w);
$end_date_w=date("Y-m-d",$end_date_w);

    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
// $dns_adr="http://".$_SERVER['HTTP_HOST'];
$rurl = getFullURLLevel($_GET['r'],'Dash_Board_new.php',0,'N');
?>
<html>
<head>
<!-- <meta http-equiv="refresh" content="300" > -->
<!-- $_SERVER['host'] -->
<meta http-equiv="refresh" content="10; url=<?php echo $rurl; ?>" >

<style>

table,th
{
	background-color: #000000;
	color: yellow;
	border-bottom: 5px solid white;
	border-top: 5px solid white;
	padding: 5px;
	white-space:nowrap;
	border-collapse:collapse;
	text-align:center;
	font-family:Calibri;
	font-size:120%;
}

table,td
{
	background-color: blue;
	color: white;
	border-bottom: 5px solid white;
	border-top: 5px solid white;

	padding-right: 5px;
	white-space:nowrap;
	border-collapse:collapse;
	text-align: center;
	font-family:Calibri;
	font-size:120%;

}

table,td.completed
{
	background-color: red;
	color: white;
	border-bottom: 5px solid white;
	border-top: 5px solid white;

	padding-right: 5px;
	white-space:nowrap;
	border-collapse:collapse;
	text-align: center;
	font-family:Calibri;
	font-size:120%;

}



table,tr
{
	background-color: #000000;
	color: BLACK;
	border-bottom: 5px solid white;
	border-top: 5px solid white;
	padding: 1px;
	white-space:nowrap;
	border-collapse:collapse;
	font-family:Calibri;
	font-size:120%;

}

table
{
	white-space:nowrap;
	border-collapse:collapse;
	width:100%;
	font-family:Calibri;
	font-size:120%;

}

font
{

	font-family:Calibri;

}

#otherdiv2 thead
{
	visibility:hidden;
}


</style>

<style>
iframe {
	height: auto;
	width: 200px;
	border: 0;
	overflow:auto;
		}
</style>

<title>Weekly Delivery Plan</title>



</head>



<body>


<?php


	$sql="select count(*) as \"count\", sum(if(priority=1,1,0)) as \"c_fca\", sum(if(priority=2,1,0)) as \"c_fg\", sum(if(priority=-1,1,0)) as \"sent\", sum(if(priority=3,1,0)) as \"c_sw\", sum(if(priority=3,1,0)) as \"c_pack\" from $bai_pro4.week_delivery_plan_ref where ex_factory_date_new between \"$start_date_w\" and \"$end_date_w\" ";
//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$c_fca=$sql_row['c_fca'];
		$c_fg=$sql_row['c_fg'];
		$c_sw=$sql_row['c_sw'];
		$count=$sql_row['count'];
		$sent_count=$sql_row['sent'];
		$c_pack=$sql_row['c_pack'];
	}

	//echo "<table>";
	//echo "<tr><td valign=\"top\"><img src=\"".$dns_adr3."/projects/beta/visionair/speed_dels/pace.jpg\" width=\"120\" height=\"50\"></td><td>";

	$table_head1 = "<table>";
	$table_head1.= "<thead>";
	$table_head1.= "<tr ><td colspan=11><center><u><strong>Weekly Delivery Plan</strong></u></center></td></tr>";
	//$table_head1.= "<tr ><th colspan=2>Orders  : $count</th><th colspan=2>Sewing : ".($c_sw+$c_fg+$c_fca)."</th><th colspan=2>FG : ".($c_fg+$c_fca)."</th><th colspan=2>FCA : $c_fca</th><th colspan=2>Shipped : $sent_count</th></tr>";

$table_head1.= "<tr><th colspan=2>Orders  : $count</th><th colspan=2>Packing : ".($c_pack+$c_fg+$c_fca+$sent_count)."</th><th colspan=2>FG : ".($c_fg+$c_fca+$sent_count)."</th><th colspan=2>FCA : ".($c_fca+$sent_count)."</th><th colspan=2>Shipped : $sent_count</th></tr>";

	$table_head1.= "<tr ><th>Status</th><th>Style</th><th>Schedule</th><th>Order</th><th>Cut</th><th>Input</th><th>Output</th>";
	//echo "<th>Plan/Hrs</th><th>Act/Hrs</th>";
	$table_head1.= "<th>FG Qty</th><th>FCA</th><th>MCA</th><th>Cartons</th>";
	//echo "<th>Fabric</th><th>Elastic</th><th>Label</th><th>Thread</th></tr>";
	$table_head1.= "</thead>";

	$table_head2 = "<table>";
	$table_head2.= "<thead>";
	$table_head2.= "<tr><td colspan=11><center><u><strong>Weekly Delivery Plan</strong></u></center></td></tr>";
	$table_head2.= "<tr ><th colspan=2>Orders  : $count</th><th colspan=3>Sewing : ".($c_sw+$c_fg+$c_fca)."</th><th colspan=3>FG : ".($c_fg+$c_fca)."</th><th colspan=3>FCA : $c_fca</th></tr>";

	$table_head2.= "<tr ><th>Status</th><th>Style</th><th>Schedule</th><th>Order</th><th>Cut</th><th>Input</th><th>Output</th>";
	//echo "<th>Plan/Hrs</th><th>Act/Hrs</th>";
	$table_head2.= "<th>FG Qty</th><th>FCA</th><th>MCA</th><th>Cartons</th>";
	//echo "<th>Fabric</th><th>Elastic</th><th>Label</th><th>Thread</th></tr>";
	$table_head2.= "</thead>";


	$table= "<tbody>";

	$grand_order=0;
	$grand_cut=0;
	$grand_input=0;
	$grand_output=0;
	$grand_plan=0;
	$grand_variance=0;
	$grand_fca=0;
	$grand_internal_audited=0;
	$grand_fg=0;
	$grand_carts=0;


	$sql="select * from $bai_pro4.week_delivery_plan_ref where ex_factory_date_new between \"$start_date_w\" and \"$end_date_w\" order by priority,ex_factory_date_new";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{

		$priority=$sql_row['priority'];
		$style=$sql_row['style'];
		$schedule=$sql_row['schedule_no'];
		$cut=$sql_row['act_cut'];
		$in=$sql_row['act_in'];
		$out=$sql_row['output'];
		$pendingcarts=$sql_row['cart_pending'];
		//$ex_factory_date=$sql_row['ex_factory_date'];
		//$rev_exfactory=$sql_row['rev_exfactory'];

		$ex_factory_date=$sql_row['ex_factory_date_new'];
		$rev_exfactory=$sql_row['ex_factory_date_new'];

		//NEW ORDER QTY TRACK
/*
		$sql1="select * from bai_pro4.shipfast_sum where shipment_plan_id=".$sql_row['ship_tid'];
		$sql_result1=mysql_query($sql1,$link2) or exit("Sql Error".mysql_error());
		while($sql_row1=mysql_fetch_array($sql_result1))
		{
			$size_xs1=$sql_row1['size_xs'];
			$size_s1=$sql_row1['size_s'];
			$size_m1=$sql_row1['size_m'];
			$size_l1=$sql_row1['size_l'];
			$size_xl1=$sql_row1['size_xl'];
			$size_xxl1=$sql_row1['size_xxl'];
			$size_xxxl1=$sql_row1['size_xxxl'];
			$size_s061=$sql_row1['size_s06'];
			$size_s081=$sql_row1['size_s08'];
			$size_s101=$sql_row1['size_s10'];
			$size_s121=$sql_row1['size_s12'];
			$size_s141=$sql_row1['size_s14'];
			$size_s161=$sql_row1['size_s16'];
			$size_s181=$sql_row1['size_s18'];
			$size_s201=$sql_row1['size_s20'];
			$size_s221=$sql_row1['size_s22'];
			$size_s241=$sql_row1['size_s24'];
			$size_s261=$sql_row1['size_s26'];
			$size_s281=$sql_row1['size_s28'];
			$size_s301=$sql_row1['size_s30'];

		}
		$order=$size_xs1+$size_s1+$size_m1+$size_l1+$size_xl1+$size_xxl1+$size_xxxl1+$size_s061+$size_s081+$size_s101+$size_s121+$size_s141+$size_s161+$size_s181+$size_s201+$size_s221+$size_s241+$size_s261+$size_s281+$size_s301; */
		//NEW ORDER QTY TRACK

		$order=$sql_row['ord_qty_new'];

		$fcamca=$sql_row['act_mca'];
		$fgqty=$sql_row['act_fg'];

		$internal_audited=$sql_row['act_fca'];


		$status="NIL";
		if($cut==0)
		{
			$status="RM";
		}
		else
		{
			if($cut>0 and $in==0)
			{
				$status="Cutting";
			}
			else
			{
				if($in>0)
				{
					$status="Sewing";
				}
			}
		}
		if($out>=$fgqty and $out>0 and $fgqty>=$order) //due to excess percentage of shipment over order qty
		{
			$status="FG";
		}
		if($out>=$order and $out>0 and $fgqty<$order)
		{
			$status="Packing";
		}

		//DISPATCH

			$sql1="select ship_qty from $bai_pro2.style_status_summ where sch_no=\"$schedule\"";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$ship_qty=$sql_row1['ship_qty'];
			}

			if($status=="FG" and $fgqty>=$ship_qty and $ship_qty>=$order)
			{
				$status="M3 Dispatched";
			}

			if($priority==-1 and $status=="FG")
			{
				$status="Shipped";
			}
		//DISPATCH

		if($out>=$order)
		{
			$plan=$order;
		}

		//new configure
		$add_front="";
		$add_back="";
		$col="yellow";
		$comple_class="";
		if($out>=$fgqty and $out>0 and $fgqty==$order)
		{
			if($ex_factory_date==date("Y-m-d") or $rev_exfactory==date("Y-m-d"))
			{

				$add_front="<font color=\"#66FF33\"><strong>";
				$add_back="</strong></font>";
				$col="#66FF33";
				$comple_class="class=\"completed\"";
			}
			else
			{

				$add_front="<font color=\"#66FF33\"><strong>";
				$add_back="</strong></font>";
				$col="#66FF33";
				//$comple_class="class=\"completed\"";
			}

		}

		if($ex_factory_date==date("Y-m-d") or $rev_exfactory==date("Y-m-d"))
		{

				$comple_class="class=\"completed\"";
		}
		//new configure

		$table.= "<tr><td $comple_class>$add_front$status</td><td>$add_front $style</a>$add_back</td><td>$add_front$schedule$add_back</td><td>$add_front$order$add_back</td><td>$add_front$cut$add_back</td><td>$add_front$in$add_back</td><td>$add_front$out$add_back</td>";


		$col="#66FF33";
		//echo "<td>$plan_tgt</td><td>$speed_act</td>";
		//echo "<td>".($plan)."</td><td>".($out-$plan)."</td>";
		if($out==$fgqty and $out>0 and $fgqty==$order)
		{
			$table.= "<td><font color=\"$col\"><strong>".$fgqty."</strong></font></td>";
		}
		else
		{
			$table.= "<td>".$fgqty."</td>";
		}

		$table.= "<td>$add_front$internal_audited$add_back</td><td>$add_front$fcamca$add_back</td><td>$add_front$pendingcarts$add_back</td></tr>";
		//echo "<td>$fabric</td><td>$elastic</td><td>$label</td><td>$thread</td></tr>";

		$grand_order+=$order;
		$grand_cut+=$cut;
		$grand_input+=$in;
		$grand_output+=$out;
		$grand_plan+=$plan;
		$grand_variance+=($out-$plan);
		$grand_carts+=$pendingcarts;
		$grand_fca+=$fcamca;
		$grand_fg+=$fgqty;
		$grand_internal_audited+=$internal_audited;
	}

	$table.= "<tr><td colspan=3 style=\"border-top:1px solid white; text-align:left;\">Grand Total</td><td  style=\"border-top:1px solid white;\">$grand_order</td><td  style=\"border-top:1px solid white;\">$grand_cut</td><td  style=\"border-top:1px solid white;\">$grand_input</td><td  style=\"border-top:1px solid white;\">$grand_output</td>";
//echo "<td  style=\"border-top:1px solid white;\">$grand_plan</td><td  style=\"border-top:1px solid white;\">$grand_variance</td>";
$table.= "<td  style=\"border-top:1px solid white;\">$grand_fg</td>";
$table.= "<td  style=\"border-top:1px solid white;\">$grand_internal_audited</td><td  style=\"border-top:1px solid white;\">$grand_fca</td><td  style=\"border-top:1px solid white;\">$grand_carts</td>";
$table.= "</tr>";

	$table.= "</tbody>";
	$table.= "</table>";


	//echo "</td><td valign=\"bottom\">";
	//echo "<font color=\"yellow\" size=\"1\"><a href=\"$dns_adr2/projects/Beta/visionair/speed_dels/mate_table_edit/index.php\" style=\"text-decoration:none; color:yellow;\">Last Updated at:<br/>$lastup</a></font>";

	//echo "</td></tr></table>";



?>


<div id="otherdiv1" style="height:140px; display:block;  overflow: hidden;">
<?php  echo $table_head1.$table ?>
</div>

<div id="otherdiv2" style=" display:block;  overflow: hidden;">
<?php
echo "<script type=\"text/javascript\">
/*
Cross browser Marquee II- © Dynamic Drive (www.dynamicdrive.com)
For full source code, 100's more DHTML scripts, and TOS, visit http://www.dynamicdrive.com
Modified by jscheuer1 for continuous content. Credit MUST stay intact for use
*/

//Specify the marquee's width (in pixels)
var marqueewidth=\"100%\"
//Specify the marquee's height

var screenHeight = screen.height;
var browserToolBarHeight = 400;
var contentH = screenHeight - (browserToolBarHeight) + \"px\";


var marqueeheight=contentH
//Specify the marquee's marquee speed (larger is faster 1-10)
var marqueespeed=1
//Specify initial pause before scrolling in milliseconds
var initPause=1000
//Specify start with Full(1)or Empty(0) Marquee
var full=1
//Pause marquee onMousever (0=no. 1=yes)?
var pauseit=1
//Specify Break characters for IE as the two iterations
//of the marquee, if text, will be too close together in IE
var iebreak='<p></p>'

//Specify the marquee's content
//Keep all content on ONE line, and backslash any single quotations (ie: that\'s great):

var marqueecontent='".$table_head2.$table."'


////NO NEED TO EDIT BELOW THIS LINE////////////
var copyspeed=marqueespeed
var pausespeed=(pauseit==0)? copyspeed: 0
var iedom=document.all||document.getElementById
var actualheight=''
var cross_marquee, cross_marquee2, ns_marquee

function populate(){
if (iedom){
var lb=document.getElementById&&!document.all? '' : iebreak
cross_marquee=document.getElementById? document.getElementById(\"iemarquee\") : document.all.iemarquee
cross_marquee2=document.getElementById? document.getElementById(\"iemarquee2\") : document.all.iemarquee2
cross_marquee.style.top=(full==1)? '8px' : parseInt(marqueeheight)+8+\"px\"
cross_marquee2.innerHTML=cross_marquee.innerHTML=marqueecontent+lb
actualheight=cross_marquee.offsetHeight
cross_marquee2.style.top=(parseInt(cross_marquee.style.top)+actualheight+8)+\"px\" //indicates following #1
}
else if (document.layers){
ns_marquee=document.ns_marquee.document.ns_marquee2
ns_marquee.top=parseInt(marqueeheight)+8
ns_marquee.document.write(marqueecontent)
ns_marquee.document.close()
actualheight=ns_marquee.document.height
}
setTimeout('lefttime=setInterval(\"scrollmarquee()\",20)',initPause)
}
window.onload=populate

function scrollmarquee(){

if (iedom){
if (parseInt(cross_marquee.style.top)<(actualheight*(-1)+8))
cross_marquee.style.top=(parseInt(cross_marquee2.style.top)+actualheight+8)+\"px\"
if (parseInt(cross_marquee2.style.top)<(actualheight*(-1)+8))
cross_marquee2.style.top=(parseInt(cross_marquee.style.top)+actualheight+8)+\"px\"
cross_marquee2.style.top=parseInt(cross_marquee2.style.top)-copyspeed+\"px\"
cross_marquee.style.top=parseInt(cross_marquee.style.top)-copyspeed+\"px\"
}

else if (document.layers){
if (ns_marquee.top>(actualheight*(-1)+8))
ns_marquee.top-=copyspeed
else
ns_marquee.top=parseInt(marqueeheight)+8
}
}

if (iedom||document.layers){
with (document){
if (iedom){
write('<div style=\"position:relative;width:'+marqueewidth+';height:'+marqueeheight+';overflow:hidden\" onMouseover=\"copyspeed=pausespeed\" onMouseout=\"copyspeed=marqueespeed\">')
write('<div id=\"iemarquee\" style=\"position:absolute;left:0px;top:0px;width:100%; font-size:\">')
write('</div><div id=\"iemarquee2\" style=\"position:absolute;left:0px;top:0px;width:100%;z-index:100;background:white;\">')
write('</div></div>')

}
else if (document.layers){
write('<ilayer width='+marqueewidth+' height='+marqueeheight+' name=\"ns_marquee\">')
write('<layer name=\"ns_marquee2\" width='+marqueewidth+' height='+marqueeheight+' left=0 top=0 onMouseover=\"copyspeed=pausespeed\" onMouseout=\"copyspeed=marqueespeed\"></layer>')
write('</ilayer>')
}
}
}
</script>";
?>
<?php  //echo $table ?>
</div>



<script type="text/javascript">
//<![CDATA[

var screenHeight = screen.height;
var browserToolBarHeight = 400;

//alert(screenHeight);

var contentH = screenHeight - (browserToolBarHeight) + "px";
document.getElementById('otherdiv2').style.height = contentH;
//alert(contentH);
//]]>
</script>



</body>
</html>

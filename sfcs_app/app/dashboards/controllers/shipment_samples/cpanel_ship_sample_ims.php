<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
$view_access=user_acl("SFCS_0241",$username,1,$group_id_sfcs); 
set_time_limit(2000);


//To find time days difference between two dates

function dateDiff($start, $end) {

$start_ts = strtotime($start);

$end_ts = strtotime($end);

$diff = $end_ts - $start_ts;

return round($diff / 86400);

}

function dateDiffsql($link,$start,$end)
{
  include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	$sql="select distinct bac_date from $bai_pro.bai_log_buf where bac_date<='$start' and bac_date>='$end'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	return mysqli_num_rows($sql_result);
}

?>

<?php
$double_modules=array();
?>



<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.corner.js',2,'R') ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/progressbar.js',2,'R') ?>"></script>

	<style>
	#progressBar {
		width: 140px;
		height: 15px;
		border: 1px solid #060000;
		background-color: #f80701;
	}

	#progressBar div {
		height: 100%;
		color: #000000;
		text-align: right;
		line-height: 15px; /* same as #progressBar height if we want text middle aligned */
		width: 0;
		background-image: url(pbar-ani.gif);
		background-color: #2ffc03;
	}
	</style>

<body>

<div class="panel panel-primary">
<div class="panel-heading">Input Management System (Sample & Shipment Sample) - Production WIP Dashboard</div>
<div class="panel-body">

<?php

if(isset($_GET['cust_view']))
{
	$cust_view=$_GET['cust_view'];
}
else
{
	$cust_view="ALL";
}

?>

<?php
//echo "<font color=yellow>Refresh Rate: 120 Sec.</font>";

$sql="select max(ims_log_date) as \"lastup\" from $bai_pro3.ims_log";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	//echo "Last Update at: ".$sql_row['lastup']."<br/>";
}


$sqlx="SELECT section_display_name,section_head AS sec_head,ims_priority_boxs,GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` LEFT JOIN $bai_pro3.sections_master ON module_master.section=sections_master.sec_name GROUP BY section ORDER BY section + 0";
// echo $sqlx.'<br/>';
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$section=$sql_rowx['sec_id'];
	$section_head=$sql_rowx['sec_head'];
	$section_mods=$sql_rowx['sec_mods'];
  $priority_limit=$sql_rowx['ims_priority_boxes'];
  $section_display_name=$sql_rowx['section_display_name'];
  

//echo '<div style="border: 3px coral solid; width: 200px; height: 1200px; float: left; margin: 10px; padding: 10px; overflow: scroll;">';
echo '<div style="background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 10px; padding: 30px;">';
echo "<p>";
	
$jump_section2 = getFullURLLevel($_GET['r'],'IMS/sec_rep.php',1,'R');  
echo "<a href='".$jump_section2."?section=$section' onclick=\"Popup=window.open('".$jump_section2."?section=$section"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><font style=\"font-size:24px;color:#000000;\"><b>$section_display_name</b></a>";
//echo "<br/><div id=\"progressBar\" class=\"progressBar$section\"><div></div></div>";
echo "<table>";

$mods=array();
$mods=explode(",",$section_mods);



$tot_boxes_section=0;
$more_than_3days=0;
	
for($x=0;$x<sizeof($mods);$x++)
{
	//NEW for showing all modules
	
	//$module=$sql_row['module'];
	$module=$mods[$x];
	
	if(!in_array($module,$double_modules))
	{
		
		$iu_module_highlight="";
    if($iu_modules){
		  if(in_array($module,$iu_modules)){
			    $iu_module_highlight="bgcolor=\"$iu_module_highlight_color\"";
		  }
    }
	$jump_url = getFullURLLevel($_GET['r'],'IMS/mod_rep.php',1,'R');
	echo "<tr class=\"bottom\">";
	echo "<td $iu_module_highlight style='width=10px'><font class=\"fontnn\" color=Black >
        <a  href='".$jump_url."?module=$module&section_id=$section&imsremark=1' 
           onclick=\"Popup=window.open('".$jump_url."?module=$module&section_id=$section&imsremark=1','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); 
          if (window.focus) {
            Popup.focus()
          } 
          return false;\">$module</a>
        </font></td>";
	
	// echo "<td class=\"bottom\"></td>";
	echo "<td class='bottom1'>";
	
	$wip_qty=0;
	
	
	$sql1="SELECT distinct rand_track,ims_remarks FROM $bai_pro3.ims_log WHERE ims_mod_no=$module AND ims_status <> \"DONE\" AND ims_remarks in ('SHIPMENT_SAMPLE','SAMPLE') order by tid";
//	echo $sql1;
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result1);
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$rand_track=$sql_row1['rand_track'];
		$ims_remarks=$sql_row1['ims_remarks'];
		//NEW
		
		$sql11="select req_date from $bai_pro3.ims_exceptions where ims_rand_track=$rand_track";
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error$sql11".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rand_check=mysqli_num_rows($sql_result11);
		while($sql_row11=mysqli_fetch_array($sql_result11))
		{
			$end_time=$sql_row11['req_date'];
		}
		
		$blink_start_tag="";
		$blink_end_tag="";
		
		if($rand_check>0)
		{
			
			if(strtotime($end_time)<strtotime((date("Y-m-d H:i:s"))))
			{
				$image1 = getFullURL($_GET['r'],'common/images/Clock.png',2,'R');
				$blink_start_tag="<blink><span style=\"position:absolute; margin-top: -10px;  margin-left: -10px; color:white;\"><img src='".$image1."'/></span>";
				$blink_end_tag="</blink>";
				//$blink_start_tag="";
				//$blink_end_tag="";
			}
		}
		
		
		//NEW
		
		$sql11="SELECT ims_doc_no, sum(ims_qty-ims_pro_qty) as \"wip\",ims_schedule as sch,ims_color as col,ims_date,ims_style,ims_remarks FROM $bai_pro3.ims_log WHERE ims_mod_no=$module AND ims_status <> \"DONE\" and rand_track=$rand_track";
		//echo $sql11;
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error$sql11".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row11=mysqli_fetch_array($sql_result11))
		{
			$ims_doc_no=$sql_row11['ims_doc_no'];
			$wip_qty+=$sql_row11['wip'];
			$schedule_no=$sql_row11['sch'];
			$color_name=$sql_row11["col"];
			$ims_date=$sql_row11["ims_date"];
			$ims_style=$sql_row11["ims_style"];
			$job_wip=$sql_row11["wip"];
			$tot_boxes_section+=1;
			$ims_remarks=$sql_row11['ims_remarks'];
		}
		

		if($ims_remarks=="SAMPLE")
		{
			//$add_css="class=\"blink\"";
			$add_css="class=\"\"";
		}
		if($ims_remarks=="SHIPMENT_SAMPLE")
		{
			$add_css=" class=\"\"";			
		}
		
		$title="$ims_remarks  Style:$ims_style\nSchedule:$schedule_no\nColor:$color_name\nWIP:$job_wip\nRejections:$rej_perc\nExfactory:$ex_factory\nAGE:".abs(dateDiffsql($link,date("Y-m-d"),$ims_date));
		
		
		//if($cust_view=="ALL")
		if($ims_remarks=="SHIPMENT_SAMPLE")
		{
			  $image_url1 = getFullURLLevel($_GET['r'],'common/images/active.gif',2,'R');
				$image="<img src='$image_url1' border=0/>";
		}
		else
		{
			$image_url2 = getFullURLLevel($_GET['r'],'common/images/down.gif',2,'R');
				$image="<img src='$image_url2' border=0/>";
			
		}
			// revised

    $jump_url2 = getFullURL($_GET['r'],'pop.php','N');
			echo "<div id='$ids' $add_css  title='$title' >
            <a href='".$jump_url2."&module=$module&doc_ref=$ims_doc_no&rand_track=$rand_track' 
            onclick=\"Popup=window.open('".$jump_url2."&module=$module&doc_ref=$ims_doc_no&rand_track=$rand_track"."','Popup','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$image $blink_start_tag$blink_end_tag</a></div>    ";	
	

	}
	
	
	$diff=$priority_limit-$sql_num_check;
	
	//Special Request Blocks

	echo "</td>";
	
	echo "<td class=\"bottom\"></td>";
	echo "<td class=\"bottom\"></td>";
	
	
	
	echo "</tr>";
}	
}

echo "</table>";
echo "</p>";
echo '</div>';

//Validation Added to avoid division by zero error
if($tot_boxes_section>0)
{
	echo "<script>
		progressBar(".round(((($tot_boxes_section)-$more_than_3days)/($tot_boxes_section))*100,0).", $('.progressBar$section'));
	</script>";
}


}




?>
<div style="clear: both;"> </div>

<!-- To blink sample input entries-->
<script>
	
	function blink(selector){
	$(selector).fadeOut('slow', function(){
	    $(this).fadeIn('slow', function(){
	        blink(this);
	    });
	});
	}
	    
	blink('.blink');
</script>
<script>
function redirect_view()
{
	//x=document.getElementById('view_cat').value;
	y=document.getElementById('cust_view').value;
	//window.location = "pps_dashboard_v2.php?view=2&view_cat="+x+"&view_div="+y;
	//window.location = "cpanel_main_v2.php?cust_view="+y;
	window.location = "cpanel_ship_sample_ims.php?cust_view="+y;
}
</script>


<SCRIPT>
<!--
function doBlink() {
	var blink = document.all.tags("BLINK")
	for (var i=0; i<blink.length; i++)
		blink[i].style.visibility = blink[i].style.visibility == "" ? "hidden" : "" 
}

function startBlink() {
	if (document.all)
		setInterval("doBlink()",1000)
}
window.onload = startBlink;
// -->
</SCRIPT>

<script language="JavaScript">
<!--
//	var message="Function Disabled!";
// 	function clickIE4(){
// 		if (event.button==2){
// 			alert(message);
// 			return false;
// 		}
// 	}

// function clickNS4(e){
// if (document.layers||document.getElementById&&!document.all){
// if (e.which==2||e.which==3){
// alert(message);
// return false;
// }
// }
// }

// if (document.layers){
// document.captureEvents(Event.MOUSEDOWN);
// document.onmousedown=clickNS4;
// }
// else if (document.all&&!document.getElementById){
// document.onmousedown=clickIE4;
// }

// document.oncontextmenu=new Function("alert(message);return false")

</script>

<style>


body
{
	background-color:#EEEEEE;
	color: #000000;
	font-family: Arial;
	width: 100%;
	
}
a {text-decoration: none; color:#000000;}

table
{
	border-collapse:collapse;
}
.new td
{
	border: 1px solid #000000;
	white-space:nowrap;
	border-collapse:collapse;
}
td{
	white-space: nowrap;
    /* text-overflow: ellipsis; */
    overflow: hidden;
}
.new th
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
}

.bottom
{
	border-bottom: 1px solid #000000;
	padding-bottom: 6px;
	padding-right: 50px;
	padding-top: 5px;
}
.bottom1
{
	padding-bottom: 10px;
	padding-right: 50px;
	padding-top: 10px;
	
	
}


.fontn a { display: block; height: 20px; padding: 5px; background-color:blue; text-decoration:none; color: #000000; font-family: Arial; font-size:12px; } 

.fontn a:hover { display: block; height: 20px; padding: 5px; background-color:green; font-family: Arial; font-size:12px;}

.fontnn a { color: #000000; font-family: Arial; font-size:12px; } 


a{
	text-decoration:none;
	color: white;
}
#active {
  width:20px;
  height:20px;
  background-color: #00FF11;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

#active a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#active a:hover {
  text-decoration:none;
  background-color: #00FF11;
}

#down {
  width:20px;
  height:20px;
  background-color: #FF0000;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}



#down a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
  text-align:center;
}

#floorset {
  width:20px;
  height:20px;
  background-color: #ff00ff;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}



#floorset a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
  text-align:center;
}



#yash {
  width:20px;
  height:20px;
  background-color: #c0c0c0;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}



#yash a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
  text-align:center;
}

#down a:hover {
  text-decoration:none;
  background-color: #FF0000;
}

#speed {
  width:20px;
  height:20px;
  background-color: #0080ff;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}



#speed a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
  text-align:center;
}

#speed a:hover {
  text-decoration:none;
  background-color: #0080ff;
}


#wait {
  width:20px;
  height:20px;
  background-color: #FFFF00;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

#wait a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#wait a:hover {
  text-decoration:none;
  background-color: #FFFF00;
}

a{
	text-decoration:none;
	color: white;
}

.white {
  width:20px;
  height:20px;
  background-color: #ffffff;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.white a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.white a:hover {
  text-decoration:none;
  background-color: #ffffff;
}


.red {
  width:20px;
  height:20px;
  background-color: #ff0000;
  display:block;
  float: left;
  margin: 2px;
  border: 1px solid black;
}

.red a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.red a:hover {
  text-decoration:none;
  background-color: #ff0000;
}

.green {
  width:20px;
  height:20px;
  background-color: #00ff00;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.green a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.green a:hover {
  text-decoration:none;
  background-color: #00ff00;
}

.yellow {
  width:20px;
  height:20px;
  background-color: #ffff00;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.yellow a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.yellow a:hover {
  text-decoration:none;
  background-color: #ffff00;
}


.pink {
  width:20px;
  height:20px;
  background-color: #ff00ff;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.pink a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.pink a:hover {
  text-decoration:none;
  background-color: #ff00ff;
}

.orange {
  width:20px;
  height:20px;
  background-color: #991144;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.orange a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.orange a:hover {
  text-decoration:none;
  background-color: #991144;
}

.blue {
  width:20px;
  height:20px;
  background-color: #15a5f2;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.blue a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
border: 1px solid black;
}

.blue a:hover {
  text-decoration:none;
  background-color: #15a5f2;
}


.yash {
  width:20px;
  height:20px;
  background-color: #999999;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.yash a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.yash a:hover {
  text-decoration:none;
  background-color: #999999;
}

.black {
  width:20px;
  height:20px;
  background-color: black;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.black a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}
.black a:hover {
  text-decoration:none;
  background-color: black;
}


#page_heading img{
    margin-top: 2px;
    margin-right: 15px;
}

<?php

//More than 3 days (T), Quality 0.8% above (T), <=Today Exfactory (T)
//class color codes
$css_type=array(".",".",".",".",".",".",".","#","#","#","#","#","#");
$cc_codes=array("red","green","yellow","pink","orange","blue","yash","active","down","floorset","yash","speed","wait");
//class color
$cc_col_codes=array("#ff0000","#00ff00","#ffff00","#ff00ff","#991144","#15a5f2","#999999","#00FF11","#FF0000","#ff00ff","#c0c0c0","#0080ff","#FFFF00");
//class alternative coverage
$cc_col_cov_code_ltr=array("F,F,T","F,T,F","F,T,T","T,F,F","T,F,T","T,T,F");
$boolcode=array("FFT","FTF","FTT","TFF","TFT","TTF");

for($j=0;$j<sizeof($cc_codes);$j++)
{
	for($i=0;$i<sizeof($boolcode);$i++)
	{
		$temp=explode(",",$cc_col_cov_code_ltr[$i]);

		echo $css_type[$j].$cc_codes[$j]."-".$boolcode[$i]." {
	  width: 0px;
	  height: 0px;
	  display:block;
	  float: left;
	  margin: 2px;
	  border-left: 10px solid ".($temp[0]=="F"?$cc_col_codes[$j]:"black")."; 
	  border-top: 10px solid ".($temp[1]=="F"?$cc_col_codes[$j]:"#DDDDDD").";
	  border-right: 10px solid ".($temp[2]=="F"?$cc_col_codes[$j]:"black").";
	  border-bottom: 10px solid ".$cc_col_codes[$j].";
	} \n";	

		unset($temp);

	}
}

?>


</style>

<?php
((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res);

?>
</div></div>
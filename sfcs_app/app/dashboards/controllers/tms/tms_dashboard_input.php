<?php
$double_modules=array();
$dashboard_name="TMS";
?>

<?php
set_time_limit(200000);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php

    echo '<META HTTP-EQUIV="refresh" content="120">';   
?>

<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<?php
    $username=getrbac_user()['uname'];

?>

<script>

function redirect_priority()
{
    y=document.getElementById('view_div').value;
    a=document.getElementById('view_priority').value;
    window.location = "<?= getFullURL($_GET['r'],'tms_dashboard_input.php','N')?>&view=2&view_div="+encodeURIComponent(y)+"&view_priority="+a;
}
function redirect_view()
{
    y=document.getElementById('view_div').value;
    a=document.getElementById('view_priority').value;
    window.location = "<?= getFullURL($_GET['r'],'tms_dashboard_input.php','N')?>&view=2&view_div="+encodeURIComponent(y)+"&view_priority="+a;
}

function redirect_dash()
{
    y=document.getElementById('view_div').value;
    a=document.getElementById('view_priority').value;
    window.location = "<?= getFullURL($_GET['r'],'tms_dashboard_input.php','N')?>&view=2&view_div="+encodeURIComponent(y)+"&view_priority="+a;
}


</script>



<script>
function blink_new(x)
{
    $("div[id='SJ"+x+"']").each(function() {
    
    $(this).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
    }); 
}

function blink_new3(x)
{
    $("div[id='S"+x+"']").each(function() {
    
    $(this).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
    }); 
}


function blink_new1(x)
{
    
    obj="#"+x;
    
    if ( $(obj).length ) 
    {
        $(obj).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
    }
}

function blink_new_priority(x)
{
    var temp=x.split(",");
    
    for(i=0;i<x.length;i++)
    {
        blink_new1(temp[i]);
    }
}

</script>


<style>
body
{
    background-color:#eeeeee;
    color: #000000;
    font-family: Trebuchet MS;
}
a {text-decoration: none;}

table
{
    border-collapse:collapse;
}
.new td
{
    border: 1px solid red;
    white-space:nowrap;
    border-collapse:collapse;
}

.new th
{
    border: 1px solid red;
    white-space:nowrap;
    border-collapse:collapse;
}

.bottom th,td
{
     border-bottom: 1px solid #000000; 
    padding-bottom: 5px;
    padding-top: 5px;
}


.fontn a { display: block; height: 20px; padding: 5px; background-color:blue; text-decoration:none; color: #000000; font-family: Arial; font-size:12px; } 

.fontn a:hover { display: block; height: 20px; padding: 5px; background-color:green; font-family: Arial; font-size:12px;}

.fontnn a { color: #000000; font-family: Arial; font-size:12px; } 



a{
    text-decoration:none;
    color: #000000;
}

.gloss-pink{
    background : #FF7FFF;
    color : #000;
    width:20px;
  height:20px;
    font-weight : bold;
  display:block;
    text-align : center;
  float: left;
  margin: 2px;
    border: 1px solid black;
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

.lgreen {
  width:20px;
  height:20px;
  background-color: #00ff00;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
 
 }

.lgreen a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
 
}

.lgreen a:hover {
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

/* .orange {
  width:20px;
  height:20px;
  background-color: #991144;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
} */
/*Below option added due to partially issued before we dont have this option by r@m*/
.orange {
  width:20px;
  height:20px;
  background-color: #eda11e;
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

.brown {
  width:20px;
  height:20px;
  background-color: #333333;
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

</style>

<SCRIPT>
// <!--
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

</head>

<body>
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_v2.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/enums.php');
include('functions_tms.php');
$plant_code=$_SESSION['plantCode'];
$username=$_SESSION['userName'];

?>
<div class="panel panel-primary">
<div class="panel-heading"><strong>Sewing Trims Status Dashboard</strong></div>
<div class="panel-body">
    <div class="form-inline">
        <div class="form-group">
            <?php
                echo 'Sewing Job Track: <input type="text" class="form-control integer" onkeyup="blink_new(this.value)" size="10">&nbsp;&nbsp;';
            ?>
        </div>
        <div class="form-group">
            <?php
                echo 'Schedule Track: <input type="text" class="form-control integer" onkeyup="blink_new3(this.value)" size="10"> &nbsp;&nbsp;';
            ?>
        </div>
<div class="form-group">        
<?php
// Ticket #424781 Disply buyer division from the database level plan_module table
// echo '&nbsp;&nbsp;Buyer Division :
// <select name="view_div" id="view_div" class="form-control" onchange="redirect_view()">';
// echo "<option value=\"ALL\" selected >ALL</option>";
// // $sqly="select distinct(buyer_div) from plan_modules";
// $sqly="SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";
// //echo $sqly."<br>";

// // mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// $sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// while($sql_rowy=mysqli_fetch_array($sql_resulty))
// {
//     $buyer_div=$sql_rowy['buyer_div'];
//     $buyer_name=$sql_rowy['buyer_name'];

//     if(urldecode($_GET["view_div"])=="$buyer_name") 
//     {
//         echo "<option value=\"".$buyer_name."\" selected>".$buyer_div."</option>";  
//     } 
//     else 
//     {
//         echo "<option value=\"".$buyer_name."\" >".$buyer_div."</option>"; 
//     }
// }

echo '</select>';
echo '&nbsp;&nbsp;&nbsp;Priorities:<select name="view_priority" class="form-control" id="view_priority" onchange="redirect_priority()">';
if($_GET['view_priority']=="4") { echo '<option value="4" selected>4</option>'; } else { echo '<option value="4">4</option>'; }
if($_GET['view_priority']=="6") { echo '<option value="6" selected>6</option>'; } else { echo '<option value="6">6</option>'; }
if($_GET['view_priority']=="8") { echo '<option value="8" selected>8</option>'; } else { echo '<option value="8">8</option>'; }
echo '</select>';

if(isset($_GET['view_priority']))
{
    $priority_limit=$_GET['view_priority'];
}
else
{
    $priority_limit=4;
}
echo '</div>';
echo "</font>";
?>
</div>
</div>
<?php
//For blinking priorties as per the section module wips
$bindex=0;
$blink_docs=array();

/**
 * Get Setions for department type 'SEWING' and plant code
*/
$departments=getSectionByDeptTypeSewing($plant_code);
foreach($departments as $department)
{
  $section=$department['sectionId'];
  $section_display_name= $department['sectionName'];

	$url_path = getFullURLLevel($_GET['r'],'board_update_V2_input.php',0,'R');
	echo '<div style="background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 10px; padding: 10px;height:100%;" class="hide_table">';
	echo "<p>";
	echo "<table>";
	
	echo "<tr><th colspan=2><h2><a href=\"javascript:void(0)\" onclick=\"Popup=window.open('$url_path?section_no=$section&uname=$username&plant_code=$plant_code"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=880,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$section_display_name</a></h2></th></th></tr>";
	
	//For Section level blinking
	$blink_minimum=0;
  /**
   * get workstations for plant code and section id
  */
  //For Section level blinking
  $blink_minimum=0;
  $sectionId=$department['sectionId'];
  $workstationsArray=getWorkstationsForSectionId($plant_code, $sectionId);

	foreach($workstationsArray as $workstations)
	{
			$module=$workstations['workstationCode'];
			$work_id=$workstations['workstationId'];
			$module1=$workstations['workstationLabel'];
			$blink_check=0;
			echo "<tr class=\"bottom\">";
			echo "<td class=\"bottom\"><strong><a href=\"javascript:void(0)\" 
				if (window.focus) {Popup.focus()} return false;\"><font class=\"fontnn\" color=black >$module</font></a></strong></td><td>";
			$y=0;   

			$show_block = calculateJobsCount($work_id,$plant_code);
			if($show_block > 0){
					echo "<div style='float:left;'>         
								<a href='#'><div  class='gloss-pink' style='float:left;'><b>$show_block</b></div></a>
								</div>";
			}
			/*
				function to get planned jobs from workstation
				@params:work_id,plant_code,type(sewing,cutjob,embjob)
				@returns:job_number,task_header_id
			*/
			$tasktype=TaskTypeEnum::SEWINGJOB;
			$result_planned_jobs=getPlannedJobs($work_id,$tasktype,$plant_code);
			$job_number=$result_planned_jobs['job_number'];
			$task_header_id=$result_planned_jobs['task_header_id'];
			foreach($job_number as $jm_sew_id=>$sew_num)
			{
				if($y==$priority_limit)
				{
						break;
				}               
				//To get taskjobs_id
				$task_jobs_id = [];
				$qry_get_task_job="SELECT task_jobs_id FROM $tms.task_jobs WHERE task_job_reference='$jm_sew_id' AND plant_code='$plant_code' AND task_type='$tasktype'";
				// echo $qry_get_task_job;
				$qry_get_task_job_result = mysqli_query($link_new, $qry_get_task_job) or exit("Sql Error at qry_get_task_job" . mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($row21 = mysqli_fetch_array($qry_get_task_job_result)) {
					$task_jobs_id[] = $row21['task_jobs_id'];
					$task_job_id = $row21['task_jobs_id'];
				}
						//TO GET STYLE AND COLOR FROM TASK ATTRIBUTES USING TASK JOB ID
				$job_detail_attributes = [];
				$qry_toget_style_sch = "SELECT * FROM $tms.task_attributes where task_jobs_id in ('".implode("','" , $task_jobs_id)."') and plant_code='$plant_code'";
				$qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("Sql Error at toget_style_sch" . mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {
						$job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
				}
				
				$style = $job_detail_attributes[$sewing_job_attributes['style']];
				$color = $job_detail_attributes[$sewing_job_attributes['color']];
				$schedule = $job_detail_attributes[$sewing_job_attributes['schedule']];
				$sewingjobno = $job_detail_attributes[$sewing_job_attributes['sewingjobno']]; 
				$cono = $job_detail_attributes[$sewing_job_attributes['cono']];  
						
				//to get qty from jm job lines
				$toget_qty_qry="SELECT sum(quantity) as qty from $pps.jm_job_bundles where jm_jg_header_id ='$jm_sew_id' and plant_code='$plant_code'";
				$toget_qty_qry_result=mysqli_query($link_new, $toget_qty_qry) or exit("Sql Error at toget_style_sch".mysqli_error($GLOBALS["___mysqli_ston"]));
				$toget_qty=mysqli_num_rows($toget_qty_qry_result);
				if($toget_qty>0){
					while($toget_qty_det=mysqli_fetch_array($toget_qty_qry_result))
					{
						$sew_qty = $toget_qty_det['qty'];
					}
				}
				//qry to get trim status
				$get_trims_status="SELECT trim_status FROM $tms.job_trims WHERE task_job_id ='$task_job_id'";
				$get_trims_status_result = mysqli_query($link_new, $get_trims_status) or exit("Sql Error at get_trims_status" . mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($row2 = mysqli_fetch_array($get_trims_status_result)) {
								$trim_status=$row2['trim_status'];
				}
				if($trim_status == TrimStatusEnum::OPEN)
				{
					$id="yash";
				}
				else if($trim_status == TrimStatusEnum::PREPARINGMATERIAL)
				{
					$id="yellow";
				}else if($trim_status == TrimStatusEnum::MATERIALREADYFORPRODUCTION)
				{
									$id="blue"; 
				}else if($trim_status == TrimStatusEnum::PARTIALISSUED)
				{
									$id="orange";
				}else if($trim_status == TrimStatusEnum::ISSUED)
				{
									$id="pink"; 
				}
				$title=str_pad("Style:".$style,80)."<br>".str_pad("Co No:".$cono,80)."<br>".str_pad("Schedule:".$schedule,80)."<br>".str_pad("Colors:".$color,80)."<br>".str_pad("Job_No:".$sewingjobno,80)."<br>".str_pad("Job Qty:".$sew_qty,80);
				$issued_status=TrimStatusEnum::ISSUED;
				if($trim_status != $issued_status)
				{
					echo "<a href=\"../".getFullURL($_GET['r'],'trims_status_update_input.php','R')."?jobno=$sewingjobno&style=$style&schedule=$schedule&module=$work_id&section=$section&doc_no=$sewingjobno&plant_code=$plant_code&username=$username&jm_jg_header_id=$jm_sew_id&color=$color'\" onclick=\"Popup=window.open('/sfcs_app/app/dashboards/controllers/tms/trims_status_update_input.php?jobno=$sewingjobno&style=$style&schedule=$schedule&module=$work_id&section=$section&doc_no=$sewingjobno&plant_code=$plant_code&username=$username&jm_jg_header_id=$jm_sew_id&color=$color','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\" data-title=\"$title\" rel='tooltip'><div id=\"S$schedule\" style=\"float:left;\"><div id=\"SJ$sewingjobno\" style=\"float:left;\"><div id=\"$sewingjobno\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id\" ><font style=\"color:black;\">$letter</font></div></div></div></a>";
					$y++;
				}  
			           
			}
			for($j=$y+1;$j<=$priority_limit;$j++)
			{
					echo "<div id=\"$schedule\" style=\"float:left;\"><div id=\"$sewingjobno\" style=\"float:left;\"><div id=\"$sewingjobno\" class=\"white\" style=\"font-size:12px; text-align:center; color:white\"><a href='#'></a></div></div></div>";
			}
			
			echo "</td>";
			echo "</tr>";
	}
	//Blinking at section level
	$bindex++;

	echo "</table>";
	echo "</p>";
	echo '</div>';

}

echo "<script>";
echo "blink_new_priority('".implode(",",$blink_docs)."');";
echo "</script>";
    
?>
<div style="clear: both;"> </div>
<?php
include('include_legends_tms.php');
?>
<br/>   
</body>
</html> 


<script>
$(document).ready(function() {
$('a[rel=tooltip]').mouseover(function(e) {
  
  var tip = $(this).attr('data-title');  
  $(this).attr('data-title','');
  $(this).append('<div id="tooltip"><div class="tipHeader"></div><div class="tipBody">' + tip + '</div><div class="tipFooter"></div></div>');   
  
}).mousemove(function(e) {


  console.log('y = '+e.pageY+' : '+e.view.parent.pageYOffset);
  console.log(e);


  $('#tooltip').css('top',$(this).offset.top-$(window).scrollTop());
  $('#tooltip').css('left',$(this).offset.left - 255 );
   $('#tooltip').css('margin-left','10px' );
   $('#tooltip').css('text-align','left' );
   $('#tooltip').css('margin-top','10px' );
   $('#tooltip').css('position', 'absolute' );
   $('#tooltip').css('z-index', '999999' );
}).mouseout(function() {

  $(this).attr('data-title',$('.tipBody').html());
  $(this).children('div#tooltip').remove();
  
});

});
</script>
<style>
.tooltip {
    
    outline: none;
    cursor: auto; 
    text-decoration: none;
    position: relative;
    color:#333;
    
  }
  .tooltip  {
    margin-left: -1500em;
    position: absolute;
    
  }
  .tooltip:hover  {
    border-radius: 5px 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; 
    box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.1); -webkit-box-shadow: 5px 5px rgba(0, 0, 0, 0.1); -moz-box-shadow: 5px 5px rgba(0, 0, 0, 0.1);
    font-family: Calibri, Tahoma, Geneva, sans-serif;
    position: absolute; 
    left: 0em; top: 0em; z-index: 99;
    margin-left: -100px; width: 150px;
    margin-top: -100px;
    


  }
  .tooltip:hover img {
    border: 0; 
    margin: -10px 0 0 -55px;
    float: left; position: absolute;
  }
  .tooltip:hover em {
    font-family: Candara, Tahoma, Geneva, sans-serif; font-size: 1.2em; font-weight: bold;
    display: block; padding: 0.2em 0 0.6em 0;
  }
 
  

  /* Tooltip */
.red-tooltip + .tooltip > .tooltip-inner {
background-color: black;
width:350px;
}
#tooltip {
position:absolute;
z-index:9999;
color:#fff;
font-size:12px;
width:220px;
pointer-events: none; 

}

#tooltip .tipHeader {
height:8px;
/*background:url('<?= getFullURL($_GET['r'],'common/images/tipHeader.gif',2,'R');?>') no-repeat;*/
font-size:0px;
}


#tooltip .tipBody {
background-color:#000;
padding:5px 5px 5px 15px;
}

#tooltip .tipFooter {
 height:8px;
 /*background:url('<?= getFullURL($_GET['r'],'common/images/tipFooter.gif',2,'R');?>') no-repeat;*/
}

</style>

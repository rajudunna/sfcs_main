<!--
Change Log:

2014-12-03 / kirang / Service Request #268415 : Added new rejection details In report level 

2015-02-04 / kirang / Service Request #241090 / Added the Machine damages to correct the data accuracy. 

2015-12-26/ kirang / Service Request #96478845 / Separated the Sewing Excess,Trim Shortage categories from fabric group and displaying rejections details individually for Sewing Excess,Trim Shortage.

-->
<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
//include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
 
//$view_access=user_acl("SFCS_0056",$username,1,$group_id_sfcs); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php   

//$reasons=array("Miss Yarn","Fabric Holes","Slub","Foreign Yarn","Stain Mark","Color Shade","Panel Un-Even","Stain Mark","Strip Match","Cut Dmg","Stain Mark","Heat Seal","M ment Out","Shape Out","Emb Defects");
$reasons=array("Miss Yarn","Fabric Holes","Slub","F.Yarn","Stain Mark","Color Shade","Heat Seal","Trim","Panel Un-Even","Stain Mark","Strip Match","Cut Damage","Heat Seal","M' ment Out","Un Even","Shape Out Leg","Shape Out waist","Shape Out","Stain Mark","With out Label","Trim shortage","Sewing Excess","Cut Holes","Slip Stitch’s","Oil Marks","Others EMB","Foil Defects","Embroidery","Print","Sequence","Bead","Dye","wash");

//list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2);
/* $username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=$username_list[1];

$authorized=array("kirang","bainet","baiadmn");
$url=getFullURL($_GET['r'],'restricted.php','N');

if(!in_array($authorized,$has_perm))
{
	header("Location:$url");
}



*/
?>
<style type="text/css">

td{
	color : #000;
}
#leftcolumn{
float:left;
width:45%;
height: 400px;
border: 3px solid black;
padding: 5px;
padding-left: 8px;
overflow:scroll;
}

#leftcolumn a{
padding: 3px 1px;
display: block;
width: 100%;
text-decoration: none;
font-weight: bold;
border-bottom: 1px solid gray;
}

#leftcolumn a:hover{
//background-color: #FFFF80;
}

#rightcolumn{
float:left;
width:550px;
min-height: 400px;
border: 3px solid black;
margin-left: 10px;
padding: 5px;
padding-bottom: 8px;
}

* html #rightcolumn{ /*IE only style*/
height: 400px;
}
</style>


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
    	background-color: BLUE;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
	background-color: white;
}


.BG {
background-image:url(Diag.gif);
background-repeat:no-repeat;/*dont know if you want this to repeat, ur choice.*/
}
</style>


<script type="text/javascript">

/***********************************************
* Dynamic Ajax Content- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

var loadedobjects=""
var rootdomain="http://"+window.location.hostname

function verify_date(e){
	var from = document.getElementById('demo1').value;
	var to =   document.getElementById('demo2').value;
	if(from > to){
		sweetAlert('From date should not be greater than To Date','','warning');
		e.preventDefault();
		return false;
	}
	return true;
}

function ajaxpage(url, containerid){
	document.getElementById(containerid).innerHTML="<h3>Please Wait While Loading Content</h3>"
	var page_request = false
	if (window.XMLHttpRequest) // if Mozilla, Safari etc
	page_request = new XMLHttpRequest()
	else if (window.ActiveXObject){ // if IE
	try {
	page_request = new ActiveXObject("Msxml2.XMLHTTP")
	} 
	catch (e){
	try{
	page_request = new ActiveXObject("Microsoft.XMLHTTP")
	}
	catch (e){}
	}
	}
	else
	return false
	page_request.onreadystatechange=function(){
	loadpage(page_request, containerid)
	}
	page_request.open('GET', url, true)
	page_request.send(null)
}

function loadpage(page_request, containerid){
	if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1))
	document.getElementById(containerid).innerHTML=page_request.responseText
}

function loadobjs(){
	if (!document.getElementById)
	return
	for (i=0; i<arguments.length; i++){
	var file=arguments[i]
	var fileref=""
	if (loadedobjects.indexOf(file)==-1){ //Check to see if this object has not already been added to page before proceeding
	if (file.indexOf(".js")!=-1){ //If object is a js file
	fileref=document.createElement('script')
	fileref.setAttribute("type","text/javascript");
	fileref.setAttribute("src", file);
	}
	else if (file.indexOf(".css")!=-1){ //If object is a css file
	fileref=document.createElement("link")
	fileref.setAttribute("rel", "stylesheet");
	fileref.setAttribute("type", "text/css");
	fileref.setAttribute("href", file);
	}
	}
	if (fileref!=""){
	document.getElementsByTagName("head").item(0).appendChild(fileref)
	loadedobjects+=file+" " //Remember this object as being already added to page
	}
	}
}

</script>
<link href="<?= getFullURLLevel($_GET['r'],'styles/sfcs_styles.css',4,'R'); ?>" rel="stylesheet" type="text/css" />
	<div class="panel panel-primary">
		<div class="panel-heading">Rejection Summary Report</div>
			<div class="panel-body">
				<!--<div id="page_heading"><span ><h3>Rejection Summary Report</h3></span></div>-->
				<form name="input" method="post" action="<?php echo getFullURL($_GET['r'],'rep4.php','N'); ?>">
				<div class='col-sm-2'>
					<label>Start Date</label>
					<input id="demo1" class='form-control' ype="text" data-toggle='datepicker' name="sdate" size="8" value="<?php if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>" > 
				</div>
				<div class='col-sm-2'>
					<label>End Date</label>	
					<input id="demo2" class='form-control' type="text" data-toggle='datepicker' size="8" name="edate" value="<?php if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>" >
				</div>
				<div class='col-sm-2'>
		        Team: <select name="team" class="form-control">
				<?php 
				for ($i=0; $i < sizeof($shifts_array); $i++) {?>
				<option <?php echo 'value="'.$shifts_array[$i].'"'; if($shift==$shifts_array[$i]){ echo "selected";} ?>><?php echo $shifts_array[$i] ?></option>
				<?php }
				?>
				</select></div>
				<div class='col-sm-1'>
					<br/><br/>
					<input type="radio" name="choice" value="1" <?php if($_POST['choice']==1) { echo "checked";} else { echo "checked"; }?> >Section
				</div>
				<div class='col-sm-1'>	
					<br/><br/>
					<input type="radio" name="choice" value="2" <?php if($_POST['choice']==2) { echo "checked";}?>>Style
				</div>
				<div class='col-sm-2'>
					<label></label><br/>
					<input type="submit" class="btn btn-success" onclick='return verify_date(event)' name="search" id="search" value="Show" >
				</div>
				</form><br><br>
<?php

if(isset($_POST['search']))
{
	echo '<div id="leftcolumn">';
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	$choice=$_POST['choice'];
	$team=$_POST['team'];
	//Section
	if($choice==1)
	{
		echo "<div class=\"table-responsive\" ><table class='table table-bordered'>";
		echo "<tr class='tblheading'>";
		echo "<th>Section</th>";
		echo "<th>Output</th>";
		echo "<th>Rework</th>";
		echo "<th>%</th>";
		echo "<th>Rejection</th>";
		echo "<th>%</th>";
	
		echo "</tr>";
		$fab_tot=0;
		$cut_tot=0;
		$sew_tot=0;
		$emb_tot=0;
		$out_tot=0;
		$qms_tot=0;
		$rework_tot=0;
		$sew_exces_tot=0;
		$trim_tot=0;
		$mac_tot=0;
		$sql="select sum(act_out) as \"output\", sum(rework_qty) as \"rework\", group_concat(distinct module) as \"module\",section from $bai_pro.grand_rep where section in (1,2,3,4,5,6,7,8) and date between \"$sdate\" and \"$edate\" and shift in ($team) group by section";
		//echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			echo "<tr>";
			echo "<td><a class='btn btn-warning' href=\"javascript:ajaxpage('".getFullURL($_GET['r'],'rep4_pop.php','R')."?sdate=$sdate&edate=$edate&section=".$sql_row['section']."&team=".str_replace("'",'*',$team)."', 'rightcolumn');\">".$sql_row['section']."</a></td>";
			echo "<td>".$sql_row['output']."</td>";
			$qms_qty=0;
			
			$vals=array();
			for($i=0;$i<33;$i++) {	$vals[$i]=0;	}
			
					
			$sql1="select ref1, qms_qty from $bai_pro3.bai_qms_db where qms_tran_type=3 and substring_index(remarks,\"-\",1) in (".$sql_row['module'].") and log_date between \"$sdate\" and \"$edate\" and substring_index(substring_index(remarks,\"-\",2),\"-\",-1) in ($team)";
			
			
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$temp=array();
				$temp=explode("$",str_replace(",","$",$sql_row1['ref1']));
				
				for($i=0;$i<sizeof($temp);$i++)
				{
					if(strlen($temp[$i])>0)
					{
						$temp2=array();
						$temp2=explode("-",$temp[$i]);
						$x=$temp2[0];
						$vals[$x]+=$temp2[1];
					}
				}
				//$qms_tot= $qms_tot + $sql_row1['qms_qty'];
				
				unset($temp);
				unset($temp2);
			}
			$fab_tot+= $vals[0]+$vals[1]+$vals[2]+$vals[3]+$vals[4]+$vals[5]+$vals[15]+$vals[16];
			$cut_tot+= $vals[6]+$vals[7]+$vals[8];
			$sew_tot+= $vals[9]+$vals[11]+$vals[12]+$vals[17]+$vals[18]+$vals[19]+$vals[13]+$vals[10];
			$trim_tot= $trim_tot + ($vals[21]+$vals[20]);
			$sew_exces_tot= $sew_exces_tot + ($vals[22]);
			$emb_tot+= $vals[14]+$vals[26]+$vals[27]+$vals[28]+$vals[29]+$vals[30]+$vals[31]+$vals[32];
			$mac_tot+= $vals[23]+$vals[24]+$vals[25];
			//$qms_qty= $vals[9]+$vals[11]+$vals[12]+$vals[17]+$vals[18]+$vals[19]+$vals[13]+$vals[10]+$vals[20]+$vals[21]+$vals[22];
			$qms_qty = $vals[0]+$vals[1]+$vals[2]+$vals[3]+$vals[4]+$vals[5]+$vals[15]+$vals[16]+$vals[6]+$vals[7]+$vals[8]+$vals[9]+$vals[11]+$vals[12]+$vals[17]+$vals[18]+$vals[19]+$vals[13]+$vals[10]+$vals[20]+$vals[21]+$vals[22]+$vals[14]+$vals[26]+$vals[27]+$vals[28]+$vals[29]+$vals[30]+$vals[31]+$vals[32]+$vals[23]+$vals[24]+$vals[25];
			//$qms_qty=array_sum($vals);
			unset($vals);
			
			$out_tot = $out_tot + $sql_row['output'];
			$rework_tot=$rework_tot+$sql_row['rework'];
			echo "<td>".$sql_row['rework']."</td>";
			if($sql_row['output']>0)
			{
				echo "<td>".round(($sql_row['rework']/$sql_row['output'])*100,2)."%</td>";
			}
			else
			{
				echo "<td>0%</td>";
			}
			echo "<td>".$qms_qty."</td>";
			if($sql_row['output']>0)
			{
				echo "<td>".round(($qms_qty/$sql_row['output'])*100,2)."%</td>";
			}
			else
			{
				echo "<td>0%</td>";
			}
			
			echo "</tr>";
		} 
		$qms_tot= $sew_tot+$fab_tot+$cut_tot+$emb_tot+$mac_tot+$sew_exces_tot+$trim_tot;
		//echo $qms_tot1;
		
		$bgcolor="#99EEEE";
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Sewing</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$sew_tot</td>";
		
		if($out_tot>0)
		{
			echo "<td>".round(($sew_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		
		echo "</tr>";
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Fabric</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$fab_tot</td>";
		
		if($out_tot>0)
		{
			echo "<td>".round(($fab_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		
		echo "</tr>";
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Cutting</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$cut_tot</td>";
		
		if($out_tot>0)
		{
			echo "<td>".round(($cut_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		
		echo "</tr>";
		
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Embellishment</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$emb_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($emb_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		

		echo "</tr>";
		
		echo "</tr>";
		
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Machine</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$mac_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($mac_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		

		echo "</tr>";
		
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Sewing Excess</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$sew_exces_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($sew_exces_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}

		echo "</tr>";
		
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Trim Shortage</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$trim_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($trim_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}

		echo "</tr>";
		
		echo "<tr bgcolor=\"yellow\">";
		echo "<td>Grand Total</td>";
		echo "<td>$out_tot</td>";
		echo "<td>  $rework_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($rework_tot/$out_tot)*100,2)."</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		echo "<td>$qms_tot</td>";
		//echo $qms_tot;
		if($out_tot>0)
		{
			echo "<td>".round(($qms_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		
		echo "</tr>";

		echo "</table></div>";
		echo '</div><div id="rightcolumn" style="overflow: auto"><h3>Choose a Section to load.</h3></div>
		<div style="clear: left; margin-bottom: 1em"></div>';
	}
	//Style
	if($choice==2)
	{
		echo "<div class=\"table-responsive\"><table class='table table-bordered'>";
		echo "<tr class='tblheading'>";
		echo "<th>Style</th>";
		echo "<th>Output</th>";
		echo "<th>Rework</th>";
		echo "<th>%</th>";
		echo "<th>Rejection</th>";
		echo "<th>%</th>";
		echo "</tr>";
		$fab_tot=0;
		$cut_tot=0;
		$sew_tot=0;
		$emb_tot=0;
		$out_tot=0;
		$qms_tot=0;
		$rework_tot=0;
		$sql="select sum(bac_qty) as \"output\", group_concat(distinct delivery) as \"delivery\",bac_style from $bai_pro.bai_log where bac_date between \"$sdate\" and \"$edate\" and bac_shift in ($team) group by bac_style order by bac_style+1";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			echo "<tr>";
			echo "<td><a class='btn btn-warning' href=\"javascript:ajaxpage('".getFullURL($_GET['r'],'rep4_pop.php','R')."?sdate=$sdate&edate=$edate&style=".$sql_row['bac_style']."&delivery=".$sql_row['delivery']."&team=".str_replace("'",'*',$team)."', 'rightcolumn');\">".$sql_row['bac_style']."</a></td>";
			echo "<td>".$sql_row['output']."</td>";
			$qms_qty=0;
			
			$vals=array();
			for($i=0;$i<33;$i++) {	$vals[$i]=0;	}
				
			$sql1="select ref1, qms_qty from $bai_pro3.bai_qms_db where qms_tran_type=3 and qms_schedule in (".$sql_row['delivery'].") and log_date between \"$sdate\" and \"$edate\" and substring_index(remarks,\"-\",1)>0 and substring_index(substring_index(remarks,\"-\",2),\"-\",-1) in ($team)";
			//echo $sql1."<br/>";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$temp=array();
				$temp=explode("$",str_replace(",","$",$sql_row1['ref1']));
				
				for($i=0;$i<sizeof($temp);$i++)
				{
					if(strlen($temp[$i])>0)
					{
						$temp2=array();
						$temp2=explode("-",$temp[$i]);
						$x=$temp2[0];
						$vals[$x]+=$temp2[1];
					}
				}
				//$qms_tot= $qms_tot + $sql_row1['qms_qty'];
				unset($temp);
				unset($temp2);
			}
			
			$fab_tot+= $vals[0]+$vals[1]+$vals[2]+$vals[3]+$vals[4]+$vals[5]+$vals[15]+$vals[16];
			$cut_tot+= $vals[6]+$vals[7]+$vals[8];
			$sew_tot+= $vals[9]+$vals[11]+$vals[12]+$vals[17]+$vals[18]+$vals[19]+$vals[13]+$vals[10]+$vals[20]+$vals[21]+$vals[22];
			
			$emb_tot+= $vals[14]+$vals[26]+$vals[27]+$vals[28]+$vals[29]+$vals[30]+$vals[31]+$vals[32];
			$qms_qty= $vals[9]+$vals[11]+$vals[12]+$vals[17]+$vals[18]+$vals[19]+$vals[13]+$vals[10]+$vals[20]+$vals[21]+$vals[22];

			
			//$qms_qty=array_sum($vals);
			unset($vals);
			
			$rework=0;
			$sql1="select sum(bac_qty) as \"rework\" from $bai_pro.bai_quality_log where delivery in (".$sql_row['delivery'].") and bac_date between \"$sdate\" and \"$edate\" and bac_shift in ($team)";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$rework=$sql_row1['rework'];
				$rework_tot= $rework_tot + $rework;
			}
			
			$out_tot = $out_tot + $sql_row['output'];
			
			echo "<td>".$rework."</td>";
			if($sql_row['output']>0)
			{
				echo "<td>".round(($rework/$sql_row['output'])*100,2)."%</td>";
			}
			else
			{
				echo "<td>0%</td>";
			}
			
			echo "<td>".$qms_qty."</td>";
			if($sql_row['output']>0)
			{
				echo "<td>".round(($qms_qty/$sql_row['output'])*100,2)."%</td>";
			}
			else
			{
				echo "<td>0%</td>";
			}
			echo "</tr>";
		} 
		$qms_tot= $sew_tot+$fab_tot+$cut_tot+$emb_tot;
		$bgcolor="#99EEEE";
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Sewing</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$sew_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($sew_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		
		echo "</tr>";
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Fabric</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$fab_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($fab_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		
		echo "</tr>";
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Cutting</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$cut_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($cut_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		
		echo "</tr>";
		
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Embellishment</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$emb_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($emb_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		

		echo "</tr>";
		echo "<tr bgcolor=\"yellow\">";
		echo "<td>Grand Total</td>";
		echo "<td>$out_tot</td>";
		
		echo "<td>$rework_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($rework_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		
		
		echo "<td>$qms_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($qms_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		
		echo "</tr>";
		echo "</table></div>";
		
		echo '</div><div id="rightcolumn"><h3>Choose a Style to load.</h3></div>
		<div style="clear: left; margin-bottom: 1em"></div>';
	}


}


?>
</div></div>
</div>


<?php 
//Redirected TEMP.
//header("Location: Hourly_Eff_test.php"); ?>

<!--
Ticket#915423Date:2014-01-23/Task:Added Hourly Efficiency tag in Hourly Production Dashboard
Ticket #892171/Date: 2014-06-16 / Task : Getting Wrong Values at Factory level In Hourly Efficiency Report
CR# 123 / 2014-09-05 / KiranG: Added color code indicators for more visibility.
CR# 194 / 2014-09-24 / kirang: Modify the color code for Act eff% .
CR# 217 /2014-11-06/ kirang: Take the operators count and clock hours count through HRMS
-->
<title>Hourly Efficiency Report</title>
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<link rel="stylesheet" href="../../../../common/css/styles/bootstrap.min.css">
<script language="javascript" type="text/javascript" src="../datetimepicker_css.js"></script>
<link rel="stylesheet" href="style.css" type="text/css" media="all" />

<style>
@media print {
@page narrow {size: 11in 9in}
@page rotated {size: landscape}
DIV {page: narrow}
TABLE {page: rotated}
#non-printable { display: none; }
#printable { 
display: block; 
padding-left:20px; }
#logo { display: block; }
body {
zoom:75%; 
}
}

th{
	color:white;
}

@media screen{
#logo { display: none; }
}
</style>

<script>
function displayStatus(){
  var w = window.open("","_status","width=300,height=200");
  w.document.write('<html><head><title>Status</title><style type="text/css">body{font:bold 14px Verdana;color:red}</style></head><body>Uploading...Please wait.</body></html>');
  w.document.close();
  w.focus();
}

function hideStatus(){
  var w = window.open("","_status"); //get handle of existing popup
  if (w && !w.closed) w.close(); //close it
}



</script>

   <script language="javascript" type="text/javascript">
    function showHideDiv()
    {
        var divstyle = new String();
        divstyle = document.getElementById("loading").style.display;
        if(divstyle.toLowerCase()=="" || divstyle == "")
        {
            document.getElementById("loading").style.display = "none";
        }
        else
        {
            document.getElementById("loading").style.display = "";
		}
    }
    </script>   
	
	<script>
function printpr()
{
var OLECMDID = 7;
/* OLECMDID values:
* 6 - print
* 7 - print preview
* 1 - open window
* 4 - Save As
*/
var PROMPT = 1; // 2 DONTPROMPTUSER
var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
WebBrowser1.ExecWB(OLECMDID, PROMPT);
WebBrowser1.outerHTML = "";
}
</script>
<body onload="showHideDiv()">
<div class="panel panel-primary">
<div class="panel-heading">Hourly Efficiency Report</div>
<div class="table-responsive">
<div class="panel-body">
<div id="non-printable">
<!-- <a href="#" onClick="print(); return false;">click here to print this page</a> -->
<?php 

// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'dbconf2.php',1,'R'));
include("../../../../common/config/config.php");
error_reporting(0);
 
$secstyles=1;
$sections_string=$_GET['sec_x'];
$date=date("Y-m-d");
$option1=1;
$shift_1=substr($shift_det[0],0,1);
$shift_2=substr($shift_det[1],0,1);

// $database1="bai_hr_database";
// $user1="bainet";
// $password1="bainet";
// $host1="baidbsrv05";

// $link1= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host1, $user1, $password1)) or die("Could not connect: ".mysqli_error($GLOBALS["___mysqli_ston"]));
// mysqli_select_db($link1, $database1) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));
$cur_hr=date('H');
// $date=date("Y-m-d");
//$prev_date= date('Y-m-d', strtotime("-1 day",strtotime($date)));
// $prev_em_att_year_db="bai_hr_tna_em_".date("y",strtotime($date)).date("y",strtotime($date)); 
// $sql="SELECT * FROM $prev_em_att_year_db.`calendar` WHERE DATE='".$date."'";
// $sql_result=mysqli_query($link1, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// while($sql_row=mysqli_fetch_array($sql_result))
// {
	// $team_tmp=substr($sql_row['remarks'],0,1);
	// $shift_det=explode("$",$sql_row['remarks']);
	// $shift_1=substr($shift_det[0],0,1);
	// $shift_2=substr($shift_det[1],0,1);
	//$shift_1_h=substr($shift_det[0],0,1);
	//$shift_2_h=substr($shift_det[1],0,1);
// }

if($cur_hr<'14')
{
	if($team_tmp=='A')
	{
		$team='"A"';
	}
	else
	{
		$team='"B"';
	}
}
else
{
	$team='"A", "B"';
}

//echo $team."<br>";

$hour_filter=array("6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21");

?>

<div id="printable">
  
<?php


//if(isset($_POST['submit']))
{

/* Function BEGINING */
 function TimeCvt ($time, $format)   {

      if (ereg ("[0-9]{1,2}:[0-9]{2}:[0-9]{2}<wbr />", $time))   {
        $has_seconds = TRUE;
      }
      else   {
        $has_seconds = FALSE;
      }

      if ($format == 0)   {         //  24 to 12 hr convert
        $time = trim ($time);

        if ($has_seconds == TRUE)   {
          $RetStr = date("g", strtotime($time));
        }
        else   {
          $RetStr = date("g", strtotime($time));
        }
      }
      elseif ($format == 1)   {     // 12 to 24 hr convert
       $time = trim ($time);

        if ($has_seconds == TRUE)   {
          $RetStr = date("H:i:s", strtotime($time));
        }
       else   {
          $RetStr = date("H:i", strtotime($time));
        }
     }
      return $RetStr;
   }
   
   //Time filter
   
   if(in_array("6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21",$hour_filter))
   {
   		$time_query=" and hour(bac_lastup) in (6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21) ";
   }
   else
   {
   		$time_query=" and hour(bac_lastup) in (".implode(",",$hour_filter).") ";
   }
   
   
  
   
  /* Function END */
// $sections=array(1,2,3,4,5,6);
$sections_string=$_POST['section'];
 $sections=$_GET['sec_x'];
 $sections_group=$_GET['sec_x'];
 
	      $date=date("Y-m-d");
		 //  $date='2017-04-14';
	
/*
   // NEW BUFFER Table Selection
   $table_name="bai_log";
    $sql="select count(*) as \"row_count\" from bai_log_buf where bac_date=\"$date\"";
	mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
      while($sql_row=mysql_fetch_array($sql_result))
	{
		$row_count=$sql_row['row_count'];
	}

if($row_count>1 or $date==date("Y-m-d"))
{
	$table_name="bai_log_buf";
	//$table_name="bai_log";
}

if($table_name=="bai_log")
{
	 $sql="truncate bai_log_buf_temp";
	mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	
	$sql="insert into bai_log_buf_temp select * from bai_log where bac_date=\"$date\"";
	mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	
	$table_name="bai_log_buf_temp";
}

*/

//Table namespace
$pro_mod="temp_pool_db.".$username.date("YmdHis")."_"."pro_mod";
$pro_plan="temp_pool_db.".$username.date("YmdHis")."_"."pro_plan";
$grand_rep="temp_pool_db.".$username.date("YmdHis")."_"."grand_rep";
$pro_style="temp_pool_db.".$username.date("YmdHis")."_"."pro_style";
$table_name="temp_pool_db.".$username.date("YmdHis")."_"."bai_log";

$sql="create TEMPORARY table $pro_mod ENGINE = MyISAM select * from bai_pro.pro_mod where mod_date='$date'";
mysqli_query($link, $sql) or exit("Sql Error1z1".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="create TEMPORARY table $pro_plan ENGINE = MyISAM select * from bai_pro.pro_plan where date='$date'";
mysqli_query($link, $sql) or exit("Sql Error1z2".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="create TEMPORARY table $grand_rep ENGINE = MyISAM select * from bai_pro.grand_rep where date='$date'";
mysqli_query($link, $sql) or exit("Sql Error1z3".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="create TEMPORARY table $pro_style ENGINE = MyISAM select * from bai_pro.pro_style where date='$date'";
mysqli_query($link, $sql) or exit("Sql Error1z4".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="create TEMPORARY table $table_name ENGINE = MyISAM select * from bai_pro.bai_log where bac_date='$date'";
mysqli_query($link, $sql) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"]));


if($option1!=1)
{

$h1=array();
$h2=array();
$headers=array();
$i=0;

   $sql="select distinct(Hour(bac_lastup)) as \"time\" from $table_name where bac_date=\"$date\" and bac_shift in ($team) $time_query order by hour(bac_lastup)";
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
      while($sql_row=mysqli_fetch_array($sql_result))
	{
		$h1[$i]=$sql_row['time'];
		$h2[$i]=$sql_row['time'];
		$timestr=$sql_row['time'].":0:0";
		$headers[$i]=TimeCvt($timestr,0);
		$i=$i+1;
	}

echo "<table id=\"info\" class=\"table table-bordered\">";
echo "<tr><th style='background-color:#29759C; color: white; '>Section</th><th style='background-color:#29759C;'>Head</th>";

for($i=0;$i<sizeof($headers);$i++)
{
echo "<th style='background-color:#29759C;'>".$headers[$i]."-".($headers[$i]+1)."</th>"; 
}

echo "<th style='background-color:#29759C;'>Total</th><th style='background-color:#29759C;'>Hours</th>
<th style='background-color:#29759C;'>Plan EFF%</th>
<th style='background-color:#29759C;'>Plan Pro.</th>
<th style='background-color:#29759C;'>CLH</th>
<th style='background-color:#29759C;'>SAH</th>
<th style='background-color:#29759C;'>Act. EFF%</th>
<th style='background-color:#29759C;'>Balance Pcs.</th>
<th style='background-color:#29759C;'>Act.Pcs/Hr</th>
<th style='background-color:#29759C;'>Req.Pcs/Hr</th>
</tr>";

// echo "</table>";

}

for ($j=0;$j<sizeof($sections);$j++)
{
/*new 20100320 */
 /*new 20100320 */       $sec=$sections[$j];

/*new 20100320 */		// $sec=$_POST['section'];



/* $date=date("Y-m-d", mktime(0,0,0,date("m") ,date("d"),date("Y")));  */

/* $sec=5; */

/* $date=date("Y-m-d", mktime(0,0,0,date("m") ,date("d"),date("Y"))); */

 /* $date = date("Y-m-d", $sdate);
echo $sdate; */

/* $h1=array(1,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21);
$h2=array(6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,24); */
$h1=array();
$h2=array();
$headers=array();
$i=0;

   $sql="select distinct(Hour(bac_lastup)) as \"time\" from $table_name where bac_date=\"$date\" and bac_shift in ($team) and bac_sec in ($sections_group) $time_query order by hour(bac_lastup)";
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
      while($sql_row=mysqli_fetch_array($sql_result))
	{
		$h1[$i]=$sql_row['time'];
		$h2[$i]=$sql_row['time'];
		$timestr=$sql_row['time'].":0:0";
		$headers[$i]=TimeCvt($timestr,0);
		$i=$i+1;
	}

    /* Headings */
     $sec_head="";
    $sql="select * from $bai_pro.pro_sec_db where sec_no=$sec";
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
	    $sec_head=$sql_row['sec_head'];
	}
	$sql="select mod_style, mod_no from $pro_mod where mod_sec=$sec and mod_date=\"$date\" order by mod_no*1";
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($option1==1){  echo "<table id=\"info\" class=\"table table-bordered\">"; }


if($option1==1){    echo "<tr><td colspan=4 style='background-color:#29759C; color: white;'>Section -".$sec." (".$sec_head.")</td></tr>"; } 
if($option1==1){	echo "<tr><th style='background-color:#29759C;'>M#</th><th style='background-color:#29759C;'>NOP</th><th style='background-color:#29759C;'>Style DB</th><th style='background-color:#29759C;'>Del DB</th>"; }

for($i=0;$i<sizeof($headers);$i++)
{
if($option1==1){	echo "<th style='background-color:#29759C;'>".$headers[$i]."-".($headers[$i]+1)."</th>"; }
}

if($option1==1){ echo "<th style='background-color:#29759C;'>Total</th><th style='background-color:#29759C;'>Hours</th>
<th style='background-color:#29759C;'>Plan EFF%</th>
<th style='background-color:#29759C;'>Plan Pro.</th>
<th style='background-color:#29759C;'>CLH</th>
<th style='background-color:#29759C;'>Plan SAH/Hr</th>
<th style='background-color:#29759C;'>Act SAH</th>
<th style='background-color:#29759C;'>Act. EFF%</th>
<th style='background-color:#29759C;'>Balance Pcs.</th>
<th style='background-color:#29759C;'>Act. Pcs/Hr</th>
<th style='background-color:#29759C;'>Req. Pcs/Hr</th>
</tr>"; }

		$peff_a_total=0;

		$peff_g_total=0;
		$ppro_a_total=0;

		$ppro_g_total=0;
		$clha_total=0;

		$clhg_total=0;
		$stha_total=0;

		$sthg_total=0;
		$effa_total=0;

		$effg_total=0;

		$avgpcstotal=0;
		$hourlytargettotal=0;
		$psth_array=array();

	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$mod=$sql_row['mod_no'];
		$style=$sql_row['mod_style'];
		$delno=$sql_row['delivery'];
		$deldb="";
		$tot_del=0;
		$sql2="select distinct delivery from $table_name where bac_style<>'0' and bac_date=\"$date\" and bac_no=$mod $time_query";
		//echo $sql2."<br>";
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo $mod."--".mysql_num_rows($sql_result2)."<br>";
		
		
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$deldb=$deldb." ".$sql_row2['delivery'];
			$tot_del+=$sql_row2['delivery'];
		}
		if($tot_del>0)
		{

		$styledb="";
		$stylecount=0;
		
		$sql2="select count(distinct bac_style) as \"count\" from $table_name where bac_date=\"$date\" and bac_no=$mod  $time_query";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$stylecount=$sql_row2['count'];
		}

		if($stylecount>1)
		{
			$sql2="select distinct bac_style from $table_name where bac_style<>'0' and bac_date=\"$date\" and bac_no=$mod  $time_query";
			
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$styledb=$styledb.$sql_row2['bac_style']."/";
			}
			$styledb=substr_replace($styledb ,"",-1);
		}
		else
		{
			$sql2="select distinct bac_style from $table_name where bac_style<>'0' and bac_date=\"$date\" and bac_no=$mod  $time_query";
			
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$styledb=$styledb.$sql_row2['bac_style'];
			}
		}



if($option1==1){		echo "<tr><td>".$mod."</td>"; }

$max=0;
		$sql2="select bac_style, couple,smv,nop, sum(bac_qty) as \"qty\" from $table_name where bac_date=\"$date\" and bac_no=$mod and  bac_shift in ($team) $time_query group by bac_style";

		//echo $sql2;
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			if($sql_row2['qty']>=$max)
			{
				$couple=$sql_row2['couple'];
				$style_code_new=$sql_row2['bac_style'];
				$max=$sql_row2['qty'];
				$smv=$sql_row2['smv'];
				//$nop=$sql_row2['nop'];
			}
		}

				//NEW
				$sqlx="select * from $pro_plan where mod_no=$mod and date=\"$date\"";
				
				$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_rowx=mysqli_fetch_array($sql_resultx))
				{
					$couple=$sql_rowx['couple'];
					$fix_nop=$sql_rowx['fix_nop'];
				}
				
				if(($couple-1)==0)
				{
					$couple="";
				}
				else
				{
					$couple=$couple-1;
				}
				
				//NOP
				
				$max=0;
				$sql2="select smv,nop, styles, buyer, days, act_out from $grand_rep where module=$mod and date=\"".$date."\" ";
				//echo $sql2;
				
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					if($sql_row2['act_out']>$max)
					{
						$max=$sql_row2['act_out'];
						$smv=$sql_row2['smv'];
						//$nop=round($sql_row2['nop'],0);
					}
					else
					{
						$smv=$sql_row2['smv'];
						//$nop=round($sql_row2['nop'],0);
					}
				}
				
				$sqlx="select nop$couple as \"nop\", smv$couple as \"smv\" from $pro_style where style=\"$style_code_new\" and date=\"$date\"";
				//echo $sqlx."<br/>";
				
				$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_rowx=mysqli_fetch_array($sql_resultx))
				{
					//$smv=$sql_rowx['smv'];
					$style_col=$sql_rowx['nop'];
				}
				//NEW
	//$style_col=$nop;

		$gtotal=0;
		$atotal=0;
		
		$psth=0;
		$sql_sth="select sum(plan_sth) as psth from $grand_rep where date=\"$date\" and module=$mod and shift in ($team)";
		//echo $sql_sth."<br>";
		$sql_result_sth=mysqli_query($link, $sql_sth) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowx=mysqli_fetch_array($sql_result_sth))
		{
			$psth_array[]=$sql_rowx["psth"];
			$psth=$sql_rowx["psth"];
			//echo $psth."<br>";
		}

// SECTION A

	$stha=0;
	$clha=0;
	$effa=0;
	$hoursa=0;

	$sql2="select count(distinct hour(bac_lastup)) as \"hoursa\" from $table_name where bac_date=\"$date\" and bac_shift in ($team) and bac_no=$mod $time_query order by bac_lastup";

/* NEWC 	$sql2="select count(distinct hour(bac_lastup)) as \"hoursa\" from bai_log_buf where bac_date=\"$date\" and bac_shift in ($team) and bac_no=$mod and hour(bac_lastup) in (14,15,16,17,18,19,20,21)";
 */
	//echo $sql2."<br>";
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$hoursa=$sql_row2['hoursa'];
	}

	if($hoursa==4 && ($sec==4) )
	{
		$hoursa=$hoursa;	

	}
	else
	{
		if($hoursa>3)
		{
			$hoursa=$hoursa+0.5-1;	
		}
	}


	if($hoursa==11.5 && ($sec==4) )
	{
		$hoursa=$hoursa;	

	}
	else
	{
		if($hoursa>7.5)
		{
			$hoursa=$hoursa+0.5-1;
		}
	}
	$sql2="select sum(bac_Qty) as \"total\",smv, sum((bac_qty*smv)/60) as \"stha\" from $table_name where bac_date=\"$date\" and bac_shift in ($team) and bac_no=$mod $time_query group by bac_no";
	//echo $sql2;
	
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$total22=$sql_row2['total'];
		$smv_sth=$sql_row2['smv'];
		$stha=$sql_row2['stha'];
		//$stha=$total22*$smv_sth/60;
	}

	$check=0;
	$total=0;$max=0;
		$sql2="select bac_style, couple,nop,smv, sum(bac_qty) as \"qty\" from $table_name where bac_date=\"$date\" and bac_no=$mod and  bac_shift in ($team) $time_query group by bac_style";
		//echo $sql2;
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			if($sql_row2['qty']>=$max)
			{
				$couple=$sql_row2['couple'];
				$style_code_new=$sql_row2['bac_style'];
				$max=$sql_row2['qty'];
				$smv=$sql_row2['smv'];
				//$nop=$sql_row2['nop'];
			}
		}
		
			$sql_nop="select (present+jumper) as avail,absent from $bai_pro.pro_attendance where date=\"$date\" and module=\"$mod\" and shift='A'"; 
			$sql_result_nop=mysqli_query($link, $sql_nop) or exit("Sql Error-<br>".$sql_nop."<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result_nop) > 0)
			{
				while($sql_row_nop=mysqli_fetch_array($sql_result_nop))
				{
					$nop1=$sql_row_nop["avail"]-$sql_row_nop["absent"];
				}
			}
			else
			{
				$nop1=0;
			}
			
			//$hoursaa=0;
			//$hoursab=0;
			$var1="hoursa".strtolower($shift_1);
			$var2="hoursa".strtolower($shift_2);
			$sql2a="select count(distinct hour(bac_lastup)) as \"hoursa\" from $table_name where bac_date=\"$date\" and hour(bac_lastup)<'14'  and bac_shift='".$shift_1."' and bac_no=$mod $time_query";
			$sql_result2a=mysqli_query($link, $sql2a) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2a=mysqli_fetch_array($sql_result2a))
			{
				$$var1=$sql_row2a['hoursa'];
				//echo $sql_row2b['hoursa']."<br>";
			}
			//echo "A=".$hoursaa."<br>";
			// if($hoursaa==4 && ($sec==4) )	{
				// $hoursaa=$hoursaa;	
			// }
			// else{
				if($hoursaa>3)
				{
					$hoursaa=$hoursaa+0.5-1;	
				}
			//}

			$clhaa=$nop1*$hoursaa;

			//echo "A2=".$clhaa."-A1=".$hoursaa."<br>";	
				
			$sql_nop1="select (present+jumper) as avail,absent from $bai_pro.pro_attendance where date=\"$date\" and module=\"$mod\" and shift='B'"; 
			$sql_result_nop1=mysqli_query($link, $sql_nop1) or exit("Sql Error-<br>".$sql_nop1."<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result_nop1) > 0)
			{
				while($sql_row_nop1=mysqli_fetch_array($sql_result_nop1))
				{
					$nop2=$sql_row_nop1["avail"]-$sql_row_nop1["absent"];
				}
			}
			else
			{
				$nop2=0;
			}
			
			//$hoursab=0;
	
			$sql2b="select count(distinct hour(bac_lastup)) as \"hoursa\" from $table_name where bac_date=\"$date\" and hour(bac_lastup)>='14' and bac_shift='".$shift_2."' and bac_no=$mod $time_query";
			//echo $sql2b."<br>";
			$sql_result2b=mysqli_query($link, $sql2b) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2b=mysqli_fetch_array($sql_result2b))
			{
				$$var2=$sql_row2b['hoursa'];
				//echo $sql_row2b['hoursa']."<br>";
			}

			// if($hoursab==4 && ($sec==4))	
			// {
				// $hoursab=$hoursab;	
			// }
			// else
			// {
				// 
				if($hoursab>3)
				{
					$hoursab=$hoursab+0.5-1;	
				}
			//}
			
			$clhab=$nop2*$hoursab;
			
			//echo "B2=".$clhab."-B1=".$hoursab."<br>";	
			 // if($cur_hr<'14')
			 // {
				 // if($team_tmp=='A')
				 // {
					 // $hoursa=$$var1;
				 // }
				 // else
				 // {
					 // $hoursa=$hoursab;
				 // }
			 // }
			 // else
			 // {
			//$hoursa=0;
			$hoursa=$hoursaa+$hoursab;	
			 //}
			
			//echo "--Test<br>";
			$clha=$clhaa+$clhab;
			
			$nop=$nop1+$nop2;
		
		if($option1==1){		//echo "<td>".$style_col."</td>"; 

		echo "<td>".$nop."</td>"; 
		echo "<td>".$styledb."</td>"; 
		echo "<td>".$deldb."</td>";
}		
		for($i=0; $i<sizeof($h1); $i++)
		{

		$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" and bac_no=$mod  $time_query and  Hour(bac_lastup) between $h1[$i] and $h2[$i]";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$sum=$sql_row2['sum'];
			if($sum==0)
			{
				$sum=0;
			if($option1==1){	echo "<td bgcolor=\"red\"></td>"; }

			}
			else
			{
			if($option1==1){	echo "<td bgcolor=\"YELLOW\">".$sum."</td>"; }
				$gtotal=$gtotal+$sum;
			}
		}
		}
		
		$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" and bac_no=$mod and  bac_shift in ($team) $time_query";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$sum=$sql_row2['sum'];
			if($sum==0)
			{
				$sum=0;
			if($option1==1){	echo "<td bgcolor\"red\"></td>"; }
			}
			else
			{
			if($option1==1){ echo "<td>".$sum."</td>"; }
			}
		}
		$atotal=$sum;

		//$clha=$nop*$hoursa;



	if($clha>0)
	{
		$effa=$stha/$clha;
	}





/* PLAN EFF, PRO */

	$peff_a=0;

	$ppro_a=0;

//Change 20110411

	$sql2="select avg(plan_eff) as \"plan_eff\", sum(plan_pro) as \"plan_pro\" from $pro_plan where date=\"$date\" and shift in ($team) and mod_no=$mod";
	
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$peff_a=$sql_row2['plan_eff'];
		$ppro_a=$sql_row2['plan_pro'];
	}




if($option1==1){

		echo "<td>".$hoursa."</td>";



		echo "<td>".round($peff_a,2)."%</td>";


}
		$work_hours=15;
		if(date("h") < 15)
		{
			$work_hours=7.5;
		}		
		$plan_sah_hr=round(($psth*$hoursa/$work_hours),0);
		$sah_per=round(($stha*100/$plan_sah_hr),0);
		$plan_sah_hr_total=$plan_sah_hr_total+$plan_sah_hr;
		if($sah_per < 90)
		{
			$color_per="#ff0915";
		}
		elseif(90 <= $sah_per && $sah_per < 100)
		{
			$color_per="#fc9625";
		}
		else
		{
			$color_per="#1cfe0a";
		}
		
		$peff_a_total=$peff_a_total+$peff_a;

		$peff_g_total=$peff_a_total;

if($option1==1){		echo "<td>".round($ppro_a,0)."</td>"; }



		$ppro_a_total=$ppro_a_total+$ppro_a;

		$ppro_g_total=$ppro_a_total;

if($option1==1){		echo "<td>".round($clha,0)."</td>"; }


		$clha_total=$clha_total+$clha;

		$clhg_total=$clha_total;

if($option1==1){//echo "<td>".round($plan_sah_hr)."-".round($psth)."-".$hoursa."</td>";		
echo "<td>".round($plan_sah_hr)."</td>";
echo "<td>".round($stha,0)."</td>"; }


		$stha_total=$stha_total+round($stha,2);
  $sthg_total=$stha_total;
  
  
  	$act_eff=round((round(($effa)*100,0)/$peff_a)*100,2);
	$color="";
	if(round(($effa)*100,0)>=70)
	{
		$color="#1cfe0a";
	}
	elseif(round(($effa)*100,0)>=60 and round(($effa)*100,0)<70)
	{
		$color="YELLOW";
	}
	else
	{
		$color="#ff0915";
	}
	


if($option1==1){		echo "<td bgcolor=\"$color\">".round(($effa*100),0)."%</td>"; }


		$effa_total=$effa_total+round(($effa*100),2);

		$effg_total=$effa_total;



if($option1==1){        echo "<td>".round(($atotal-$ppro_a),0)."</td>"; }
if($hoursa>0)
{
	$avgperhour=$atotal/$hoursa;
}
else
{
	$avgperhour=$atotal;
}

if($option1==1){ echo "<td>".round($avgperhour,0)."</td>"; }

/* NEW 20100318 */
	
	if($cur_hr<14)
	{
		$qty=round(($ppro_a-$atotal),0);
		$hoursnw=8-$hoursa;
		//echo $qty."<br>";
		if($hoursnw==0)
		{
			$exp_pcs_hr=round($qty,0);
		}
		else
		{
			$exp_pcs_hr=round($qty,0)/round($hoursnw,0);
		}		
	}
	else
	{
		$qty=round(($ppro_a-$atotal),0);
		//echo $qty."<br>";
		$hoursnw=16-$hoursa;
		$exp_pcs_hr=round($qty,0)/round($hoursnw,0);
		//$exp_pcs_hr=round(($atotal-$ppro_a),0);
		
	}
	$expect_qty=$expect_qty+$exp_pcs_hr;
	

	
if($option1==1){	 echo "<td>".round($exp_pcs_hr,0)."</td>"; }

	$avgpcstotal=$avgpcstotal+$avgperhour;
		$hourlytargettotal=$hourlytargettotal+$exp_pcs_hr;


	}
}
























if($option1==1){ 	echo "<tr class=\"total\"><td colspan=4>Total</td>"; } else { echo "<tr class=\"total\"><td rowspan=4>".$sec."</td><td>Total</td>";  }

		$total=0;
		$atotal=0;

		for($i=0; $i<sizeof($h1); $i++)
		{

		$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" $time_query and bac_sec=$sec and Hour(bac_lastup) between $h1[$i] and $h2[$i]";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$sum=$sql_row2['sum'];
			if($sum==0)
			{
				$sum=0;
				echo "<td bgcolor=\"red\"></td>";

			}
			else
			{
				echo "<td>".$sum."</td>";
			}

		}
		}




		$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" and bac_sec=$sec and  bac_shift in ($team) $time_query";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$sum=$sql_row2['sum'];
			$atotal=$atotal+$sum;
		}

		$total=$atotal;



/* NEW */
	$pclha=0;
	$pstha=0;
 	$nop=0;
	$smv=0;
	//$phours=7.5;
		$peff_a_total=0;


	$sql="select mod_no from $pro_mod where mod_sec=$sec and mod_date=\"$date\"";
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row=mysqli_fetch_array($sql_result))
	{

		$mod=$sql_row['mod_no'];

$sql2="select act_hours from $pro_plan where date=\"$date\" and mod_no=$mod and shift in ($team)";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$phours=$sql_row2['act_hours'];

		}
//A-Plan

$max=0;

		$sql2="select bac_style, couple,nop,smv, sum(bac_qty) as \"qty\" from $table_name where bac_date=\"$date\" and bac_no=$mod and  bac_shift in ($team) $time_query group by bac_style";
		//echo $sql2;
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			if($sql_row2['qty']>=$max)
			{
				$couple=$sql_row2['couple'];
				$style_code_new=$sql_row2['bac_style'];
				$max=$sql_row2['qty'];
				$smv=$sql_row2['smv'];
				//$nop=$sql_row2['nop'];
			}
		}




		$sql2="select plan_pro,act_hours from $pro_plan where date=\"$date\" and mod_no=$mod and shift in ($team)";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$plan_pro=$sql_row2['plan_pro'];
			$phours=$sql_row2['act_hours'];
		}

		$pclha=$pclha+($phours*$nop);
		$pstha=$pstha+($plan_pro*$smv)/60;

		//echo ($phours*$nop)."<br/>";




	}




		$sql2="select count(distinct hour(bac_lastup)) as \"hoursa\" from $table_name where bac_date=\"$date\" and bac_shift in ($team) and bac_sec=$sec $time_query order by bac_lastup";
		//echO $sql2;
	
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$hoursa=$sql_row2['hoursa'];
	}
	if($hoursa==4 && ($sec==4) )
	{
		$hoursa=$hoursa;	

	}
	else
	{
		if($hoursa>3)
		{
			$hoursa=$hoursa+0.5-1;
			//echo $hoursa;
		}
	}

	if($hoursa==11.5 && ($sec==4) )
	{
		$hoursa=$hoursa;	
	}
	else
	{
		if($hoursa>7.5)
		{
			$hoursa=$hoursa+0.5-1;
			//echo "Hurs =".$hoursa;
		}
	}

/* 20100226 */
		echo "<td rowspan=4>".$atotal."</td>";
        echo "<td rowspan=4>".$hoursa."</td>";




$peffresulta=0;
$sql21="select avg(plan_eff) as \"plan_eff\" from $pro_plan where sec_no='".$sec."' and date=\"$date\" and shift in ($team)";
	//echo $sql21."<br>";
$sql_result21=mysqli_query($link, $sql21) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));

while($sql_row21=mysqli_fetch_array($sql_result21))
{
	$peffresulta=round($sql_row21['plan_eff'],0,2);
	//$ppro_a=$sql_row2['plan_pro'];
}
if($plan_sah_hr_total>0 && $clha_total>0)
{
	//$peffresulta=(round(($plan_sah_hr_total/$clha_total),2)*100);
}
//echo $ppro_a_total."--".$pclha."<br>";


		echo "<td rowspan=4>".$peffresulta."%</td>";


		echo "<td rowspan=4>".round($ppro_a_total,0)."</td>";


		echo "<td rowspan=4>".$clha_total."</td>";
		$clha_total_new+=$clha_total; //Change 20100819
		echo "<td rowspan=4>".round($plan_sah_hr_total,0)."</td>";
		$sah_per_fac=round(($stha_total*100/$plan_sah_hr_total),0);
		if($sah_per_fac < 90)
		{
			$color_per_fac="#ff0915";
		}
		elseif(90 <= $sah_per_fac && $sah_per_fac < 100)
		{
			$color_per_fac="#fc9625";
		}
		else
		{
			$color_per_fac="#1cfe0a";
		}
		echo "<td rowspan=4>".round($stha_total,0)."</td>";
		$plan_sah_hr_total=0;


$xa=0;
$xb=0;
if($clha_total>0)
{
	$xa=round(($stha_total/$clha_total)*100,2);
}

if($xa>=70)
{
	$color_per_fac1="#1cfe0a";
}
elseif($xa>=60 and $xa<70)
{
	$color_per_fac1="YELLOW";
}
else
{
	$color_per_fac1="#ff0915";
}


//echo "<td rowspan=4 ><font size=30 color=\"$color_per_fac1\">&#8226;</font><br/>".round($xa,0)."%</td>";
echo "<td rowspan=4 style='background-color:$color_per_fac1; color:black; font-weight:bold;' >".round($xa,0)."%</td>";



  echo "<td  rowspan=4>".round(($atotal-$ppro_a_total),0)."</td>";

   echo "<td  rowspan=4>".round($avgpcstotal,0)."</td>";

/* 20100318 */

// if((7.5-$hoursa)>0)
	// {
	// echo "<td  rowspan=4>".round($hourlytargettotal,0)."</td>";

	// }
	// else
	// {
		  // echo "<td  rowspan=4>".round(($atotal-$ppro_a_total),0)."</td>";
	// }

echo "<td  rowspan=4>".round($expect_qty,0)."</td>";



/* STH */

if($option1==1){ 		echo "<tr class=\"total\"><td colspan=4>HOURLY SAH</td>"; } else {  echo "<tr class=\"total\"><td>HOURLY SAH</td>"; }


		for($i=0; $i<sizeof($h1); $i++)
		{

			$sth=0;

	$sql2="select sum((bac_qty*smv)/60) as \"sth\" from $table_name where bac_date=\"$date\" $time_query and bac_sec=$sec and Hour(bac_lastup) between $h1[$i] and $h2[$i]";
	
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$sth=$sql_row2['sth'];
	}



		echo "<td>".round($sth,0)."</td>";
		}

/* EFF */





if($option1==1) {		echo "<tr class=\"total\"><td colspan=4>HLY EFF%</td>"; } else { echo "<tr class=\"total\"><td>HLY EFF%</td>";   }


		for($i=0; $i<sizeof($h1); $i++)
		{


			$eff=0;

/* NEW20100219 */
			$minutes=60;

			if(($h1[$i]==9 or $h1[$i]==17) and ($sec==1 or $sec==2 or  $sec==3 or $sec==6))
			{
					$minutes=30;
			}
			else
			{
				$minutes=60;
			}
			
			if(($h1[$i]==10 or $h1[$i]==18) and ($sec==4))
			{
					$minutes=30;
			}

			
	
			//echo $h1[$i]."-".$sec."-".$minutes;
/* NEW20100219 */

//IMS	$sql2="select sum(($table_name.bac_qty*$pro_style.smv)/($pro_style.nop*".$minutes.")*100) as \"eff\" from $table_name,$pro_style where $table_name.bac_date=\"$date\" and $pro_style.date=\"$date\" and $table_name.bac_sec=$sec and $table_name.bac_style=$pro_style.style and Hour($table_name.bac_lastup) between $h1[$i] and $h2[$i]";

$sql2="select sum((bac_qty*smv)/(nop*".$minutes.")*100) as \"eff\" from $table_name where bac_date=\"$date\" $time_query and bac_sec=$sec and Hour(bac_lastup) between $h1[$i] and $h2[$i]";

	
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$eff=$sql_row2['eff'];
	}



/* NEW20100219 */
	$sql2="select count(distinct bac_no) as \"noofmodsb\" from $table_name where bac_date=\"$date\" $time_query and Hour(bac_lastup) between $h1[$i] and $h2[$i] and bac_sec=$sec";
	
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$noofmodsb=$sql_row2['noofmodsb'];
	}

$noofmods=$noofmodsb;
/* NEW20100219 */

if($noofmods>0)
{
	echo "<td>".round((round($eff,2)/$noofmods),0)."%</td>";
}
else
{
		echo "<td>0</td>";
}

}

/* AVG p per hour */

if($option1==1) {		echo "<tr class=\"total\"><td colspan=4>AVG-Pcs/HR</td>"; } else { echo "<tr class=\"total\"><td>AVG-Pcs/HR</td>";   }

		$total=0;
		$btotal=0;

		for($i=0; $i<sizeof($h1); $i++)
		{

		$sum=0;
		$count=0;

		$sql2="select bac_qty from $table_name where bac_date=\"$date\" $time_query and bac_sec=$sec and Hour(bac_lastup) between $h1[$i] and $h2[$i]";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			if($sql_row2['bac_qty']>0)
				$count=$count+1;

		}


		$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" $time_query and bac_sec=$sec and Hour(bac_lastup) between $h1[$i] and $h2[$i]";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$sum=$sql_row2['sum'];
			if($sum==0)
			{
				$sum=0;
				echo "<td bgcolor=\"RED\"></td>";

			}
			else
			{
				if($count>0)
				{
					echo "<td>".round(($sum/$count),0)."</td>";
				}
				else
				{
					echo "<td>".round(($sum),0)."</td>";
				}
			}

		}
		}
		echo "</tr>";


/*		echo "</table>"; */


















echo "<br/>";








     if($secstyles==1 && sizeof($sections)==1)
     {

/* Stylewise Report */

$sdate=$date;


/*	echo "<table id=\"info\">"; */

	echo "<tr style='background-color:#29759C;'><th style='background-color:#29759C;'>Style Code</th><th style='background-color:#29759C;'>SMV</th><th style='background-color:#29759C;'>Oprs</th><th style='background-color:#29759C;'>Mod Count</th>";

for($i=0;$i<sizeof($headers);$i++)
{
	echo "<th style='background-color:#29759C;'>".$headers[$i]."-".($headers[$i]+1)."</th>";
}


echo "<th style='background-color:#29759C;'>Total</th><th style='background-color:#29759C;'>Plan Pcs</th><th style='background-color:#29759C;'>Balance Pcs</th><th style='background-color:#29759C;'>Avg. Pcs/Hr</th><th style='background-color:#29759C;'>Hr Tgt.</th><th style='background-color:#29759C;'>Avg. Pcs<br/>Hr/Mod</th><th style='background-color:#29759C;'>Hr Tgt./Mod.</th></tr>";
$avgpcshrsum=0;
$planpcsgrand=0;
$balancepcs=0;
$exp_pcs_hr_total=0;
	 $avgperhour2_sum=0;
	 $exp_pcs_hr2_sum=0;

	//$sql="select distinct bac_style,smv,nop from $table_name where bac_date=\"$date\" and bac_sec=$sec and bac_shift in ($team)";
	$sql="select bac_style,smv,nop from $table_name where bac_date=\"$date\" $time_query and bac_sec=$sec and bac_style<>'0' and bac_shift in ($team) group by bac_style";
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$mod_style=$sql_row['bac_style'];
		echo "<tr><td>".$mod_style."</td>";

		$sql2="select nop,smv from $pro_style where style=\"$mod_style\" and date=\"$date\"";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			//echo "<td>".$sql_row2['smv']."</td>";
			//echo "<td>".$sql_row2['nop']."</td>";
		}
		
		//SMV NOP directo from log
		echo "<td>".$sql_row['smv']."</td>";
		echo "<td>".$sql_row['nop']."</td>";

		//SMV NOP directo from log		
		
		$count=0;
		$sql2="select count(distinct bac_no) as \"count\",group_concat(distinct bac_no) as module from $table_name where bac_date=\"$date\" $time_query and bac_sec=$sec and bac_style=\"$mod_style\" and bac_shift in ($team)";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$count=$sql_row2['count'];
			$module=$sql_row2['module'];
			echo "<td>".$count."</td>";
		}


		$total=0;

		for($i=0; $i<sizeof($h1); $i++)
		{

		$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$sdate\" and bac_style=\"$mod_style\" $time_query and Hour(bac_lastup) between $h1[$i] and $h2[$i] and bac_sec=$sec and bac_shift in ($team)";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$sum=$sql_row2['sum'];
			if($sum==0)
			{
				$sum=0;
				echo "<td bgcolor=\"red\"></td>";

			}
			else
			{
				echo "<td bgcolor=\"YELLOW\">".$sum."</td>";
				$total=$total+$sum;
			}
		}

		}
		echo "<td>".$total."</td>";





	$plan_pcs=0;

	/*$sql2="select mod_no from $pro_mod where mod_sec=$sec and mod_date=\"$date\" and mod_style=\"$mod_style\"";
	
	$sql_result2=mysql_query($sql2,$link) or exit("Sql Error".mysql_error());

	while($sql_row2=mysql_fetch_array($sql_result2))
	{
		$mod_no=$sql_row2['mod_no'];
*/
		$sql22="select plan_pro from $pro_plan where date=\"$date\" and mod_no in ($module) and shift in ($team)";
		
		$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($sql_row22=mysqli_fetch_array($sql_result22))
		{
			$plan_pcs=$plan_pcs+$sql_row22['plan_pro'];
		}
/*

	}
	
*/	
	$planpcsgrand=$planpcsgrand+$plan_pcs;

	echo "<td>".round($plan_pcs,0)."</td>";

	$balancepcs=$balancepcs+($plan_pcs-$total);
	echo "<td>".(round($plan_pcs,0)-$total)."</td>";



/////

	$avgperhour=0;
		$avgperhour2=0;
$count2=0;
	$sql2="select count(distinct bac_no) as \"count\", sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" $time_query and bac_sec=$sec and bac_style=\"$mod_style\"  and bac_shift in ($team)";
	
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));


	while($sql_row2=mysqli_fetch_array($sql_result2))
	{

		if(($hoursa+$hoursb)>0)
		{
///		$avgperhour=round(($sql_row2['sum']/$sql_row2['count']/($hoursa)),0);
		$avgperhour2=round(($sql_row2['sum']/$sql_row2['count']/($hoursa)),0);
		$avgperhour=round(($sql_row2['sum']/($hoursa)),0);
		$count2=$sql_row2['count'];
		echo "<td>".$avgperhour."</td>";
		}
		else
		{
		echo "<td>0</td>";
		}

	}
	$avgpcshrsum=$avgpcshrsum+$avgperhour;
/////
     $exp_pcs_hr=0;
        $exp_pcs_hr2=0;

	if((7.5-$hoursa)>0)
	{
//		$exp_pcs_hr=(($plan_pcs)-(($avgperhour*$hoursa)*$count))/(7.5-$hoursa);
       $exp_pcs_hr=($plan_pcs-$total)/(7.5-$hoursa);
       $exp_pcs_hr2=(($plan_pcs-$total)/(7.5-$hoursa))/$count2;
	}
	else
	{
		$exp_pcs_hr=($total-$plan_pcs);
		$exp_pcs_hr2=($total-$plan_pcs)/$count2;
	}

	echo "<td>".round($exp_pcs_hr,0)."</td>";
	$exp_pcs_hr_total=$exp_pcs_hr_total+$exp_pcs_hr;
    echo "<td>".round($avgperhour2,0)."</td>";
	echo "<td>".round($exp_pcs_hr2,0)."</td>";
	 $avgperhour2_sum=$avgperhour2_sum+$avgperhour2;
	 $exp_pcs_hr2_sum=$exp_pcs_hr2_sum+$exp_pcs_hr2;
echo "</tr>";
	}




		echo "<tr class=\"total\"><td>Total</td><td></td><td></td><td></td>";

		$total=0;

		for($i=0; $i<sizeof($h1); $i++)
		{

		$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$sdate\" $time_query and Hour(bac_lastup) between $h1[$i] and $h2[$i] and bac_sec=$sec and bac_shift in ($team)";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$sum=$sql_row2['sum'];
			if($sum==0)
			{
				$sum=0;
				echo "<td bgcolor=\"RED\"></td>";

			}
			else
			{
				echo "<td>".$sum."</td>";
				$total=$total+$sum;
			}
		}

		}
		echo "<td>".$total."</td>";

		echo "<td>".round($planpcsgrand,0)."</td>";
		echo "<td>".round($balancepcs,0)."</td>";
		echo "<td>".$avgpcshrsum."</td>";
		echo "<td>".round($exp_pcs_hr_total,0)."</td>";

			 echo "<td>".round($avgperhour2_sum,0)."</td>";
	 echo "<td>".round($exp_pcs_hr2_sum)."</td>";
	echo "<tr>";
// echo "</table>";
     }

} /* NEW */








/* NEW 20100321 */



if($option1!=1 && sizeof($sections)>1)
{
/*new 20100320 */
 /*new 20100320 */       $sec=$sections[$j];

/*new 20100320 */		// $sec=$_POST['section'];



/* $date=date("Y-m-d", mktime(0,0,0,date("m") ,date("d"),date("Y")));  */

/* $sec=5; */

/* $date=date("Y-m-d", mktime(0,0,0,date("m") ,date("d"),date("Y"))); */

 /* $date = date("Y-m-d", $sdate);
echo $sdate; */

/* $h1=array(1,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21);
$h2=array(6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,24); */
$h1=array();
$h2=array();
$headers=array();
$i=0;

   $sql="select distinct(Hour(bac_lastup)) as \"time\" from $table_name where bac_date=\"$date\" and bac_shift in ($team) $time_query order by bac_lastup";
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
      while($sql_row=mysqli_fetch_array($sql_result))
	{
		$h1[$i]=$sql_row['time'];
		$h2[$i]=$sql_row['time'];
		$timestr=$sql_row['time'].":0:0";
		$headers[$i]=TimeCvt($timestr,0);
		$i=$i+1;
	}

   




	$sql="select mod_style, mod_no from $pro_mod where mod_sec in ($sections_group) and mod_date=\"$date\" order by mod_no";
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));


		$peff_a_total=0;

		$peff_g_total=0;
		$ppro_a_total=0;

		$ppro_g_total=0;
		$clha_total=0;

		$clhg_total=0;
		$stha_total=0;

		$sthg_total=0;
		$effa_total=0;

		$effg_total=0;

		$avgpcstotal=0;
		$hourlytargettotal=0;


	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$mod=$sql_row['mod_no'];
		$style=$sql_row['mod_style'];
		$delno=$sql_row['delivery'];
		$deldb="";

		$sql2="select distinct delivery from $table_name where bac_date=\"$date\" and bac_no=$mod $time_query";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$deldb=$deldb." ".$sql_row2['delivery'];
		}


		$styledb="";

		$sql2="select distinct bac_style from $table_name where bac_date=\"$date\" and bac_no=$mod  $time_query";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$styledb=$styledb." ".$sql_row2['bac_style'];
		}



	

$style_col="";
	$sql2="select nop from $pro_style where style=\"$style\" and date=\"$date\"";
	
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$style_col=$sql_row2['nop'];
	}




		$gtotal=0;
		$atotal=0;



	for($i=0; $i<sizeof($h1); $i++)
		{

		$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" and bac_no=$mod $time_query and Hour(bac_lastup) between $h1[$i] and $h2[$i]";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$sum=$sql_row2['sum'];
			if($sum==0)
			{
				$sum=0;
	

			}
			else
			{
				$gtotal=$gtotal+$sum;
			}
		}
		}


		$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" and bac_no=$mod  $time_query and bac_shift in ($team)";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$sum=$sql_row2['sum'];
			if($sum==0)
			{
				$sum=0;

			}
			else
			{

			}
		}
		$atotal=$sum;






// SECTION A

	$stha=0;
	$clha=0;
	$effa=0;
	$hoursa=0;

	$sql2="select count(distinct hour(bac_lastup)) as \"hoursa\" from $table_name where bac_date=\"$date\" $time_query and bac_shift in ($team) and bac_no=$mod order by bac_lastup";

/* NEWC 	$sql2="select count(distinct hour(bac_lastup)) as \"hoursa\" from bai_log_buf where bac_date=\"$date\" and bac_shift in ($team) and bac_no=$mod and hour(bac_lastup) in (14,15,16,17,18,19,20,21)";
 */
	
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$hoursa=$sql_row2['hoursa'];
	}
if($hoursa==4 && ($sec==4) )
	{
		$hoursa=$hoursa;	

	}
	else
	{

	if($hoursa>3)
	{
		$hoursa=$hoursa+0.5-1;
	}
}

if($hoursa==11.5 && ($sec==4) )
	{
		$hoursa=$hoursa;	

	}
	else
	{

	if($hoursa>7.5)
	{
		$hoursa=$hoursa+0.5-1;
	}
}

	$sql2="select sum(bac_Qty) as \"total\", sum((bac_qty*smv)/60) as \"stha\" from $table_name where bac_date=\"$date\" $time_query and bac_shift in ($team) and bac_no=$mod group by bac_no";
	
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$total22=$sql_row2['total'];
		$stha=$sql_row2['stha'];
	}

	$check=0;
	$total=0;

$max=0;
		$sql2="select bac_style, couple,smv,nop, sum(bac_qty) as \"qty\" from $table_name where bac_date=\"$date\" and bac_no=$mod $time_query and  bac_shift in ($team) group by bac_style";
		//echo $sql2;
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			if($sql_row2['qty']>=$max)
			{
				$couple=$sql_row2['couple'];
				$style_code_new=$sql_row2['bac_style'];
				$max=$sql_row2['qty'];
				$smv=$sql_row2['smv'];
					//$nop=$sql_row2['nop'];
			}
		}


		$clha=$nop*	$hoursa;



	if($clha>0)
	{
		$effa=$stha/$clha;
	}





/* PLAN EFF, PRO */

	$peff_a=0;

	$ppro_a=0;


	$sql2="select plan_eff, plan_pro from $pro_plan where date=\"$date\" and shift in ($team) and mod_no=$mod";
	
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$peff_a=$sql_row2['plan_eff'];
		$ppro_a=$sql_row2['plan_pro'];
	}






	


		$peff_a_total=$peff_a_total+$peff_a;

		$peff_g_total=$peff_a_total;

	


		$ppro_a_total=$ppro_a_total+$ppro_a;

		$ppro_g_total=$ppro_a_total;

	


		$clha_total=$clha_total+$clha;

		$clhg_total=$clha_total;




		$stha_total=$stha_total+round($stha,2);
  $sthg_total=$stha_total;


	


		$effa_total=$effa_total+round(($effa*100),2);

		$effg_total=$effa_total;



  
if($hoursa>0)
{
$avgperhour=$atotal/$hoursa;
}
else
{
	$avgperhour=$atotal;
}



/* NEW 20100318 */
	if((7.5-$hoursa)>0)
	{
		$exp_pcs_hr=(round($ppro_a,0)-(($avgperhour*$hoursa)))/(7.5-$hoursa);
	}
	else
	{
		$exp_pcs_hr=round(($atotal-$ppro_a),0);
	}


	$avgpcstotal=$avgpcstotal+$avgperhour;
		$hourlytargettotal=$hourlytargettotal+$exp_pcs_hr;


	}

























		echo "<tr class=\"total\"><td rowspan=4>Factory</td><td>Total</td>";

		$total=0;
		$atotal=0;

		for($i=0; $i<sizeof($h1); $i++)
		{

		$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" $time_query and bac_sec in ($sections_group) and Hour(bac_lastup) between $h1[$i] and $h2[$i]";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$sum=$sql_row2['sum'];
			if($sum==0)
			{
				$sum=0;
				echo "<td bgcolor=\"red\"></td>";

			}
			else
			{
				echo "<td>".$sum."</td>";
			}

		}
		}




		$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" and bac_sec in ($sections_group)  $time_query and bac_shift in ($team)";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$sum=$sql_row2['sum'];
			$atotal=$atotal+$sum;
		}

		$total=$atotal;



/* NEW */
	$pclha=0;
	$pstha=0;
 $nop=0;
$smv=0;
	//$phours=7.5;
		$peff_a_total=0;


	$sql="select mod_no from $pro_mod where mod_sec in ($sections_group) and mod_date=\"$date\"";
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row=mysqli_fetch_array($sql_result))
	{

		$mod=$sql_row['mod_no'];


//A-Plan

$sql2="select act_hours from $pro_plan where date=\"$date\" and mod_no=$mod and shift in ($team)";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$phours=$sql_row2['act_hours'];

		}


$max=0;
		$sql2="select bac_style, couple,smv,nop, sum(bac_qty) as \"qty\" from $table_name where bac_date=\"$date\" and bac_no=$mod $time_query and bac_shift in ($team) group by bac_style";
		//echo $sql2;
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			if($sql_row2['qty']>=$max)
			{
				$couple=$sql_row2['couple'];
				$style_code_new=$sql_row2['bac_style'];
				$max=$sql_row2['qty'];
				$smv=$sql_row2['smv'];
					//$nop=$sql_row2['nop'];
			}
		}

			$sql_nop="select (present+jumper) as avail,absent from $bai_pro.pro_attendance where date=\"$date\" and module=\"$mod\" and shift='A'"; 
			$sql_result_nop=mysqli_query($link, $sql_nop) or exit("Sql Error-<br>".$sql_nop."<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result_nop) > 0)
			{
				while($sql_row_nop=mysqli_fetch_array($sql_result_nop))
				{
					$nop1=$sql_row_nop["avail"]-$sql_row_nop["absent"];
				}
			}
			else
			{
				$nop1=0;
			}
			
			$hoursaa=0;

			$sql2a="select count(distinct hour(bac_lastup)) as \"hoursa\" from $table_name where bac_date=\"$date\" and bac_shift in (\"A\") and bac_no=$mod $time_query";
			$sql_result2a=mysqli_query($link, $sql2a) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2a=mysqli_fetch_array($sql_result2a))
			{
				$hoursaa=$sql_row2a['hoursa'];
			}
			//echo "A=".$hoursaa."<br>";
			if($hoursaa==4 && ($sec==4) )	{
				$hoursaa=$hoursaa;	
			}
			else{
				if($hoursaa>3){
					$hoursaa=$hoursaa+0.5-1;	
				}
			}

			$clhaa=$nop1*$hoursaa;

			//echo "A2=".$clhaa."-A1=".$hoursaa."<br>";	
				
			$sql_nop1="select (present+jumper) as avail,absent from $bai_pro.pro_attendance where date=\"$date\" and module=\"$mod\" and shift='B'"; 
			$sql_result_nop1=mysqli_query($link, $sql_nop1) or exit("Sql Error-<br>".$sql_nop1."<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result_nop1) > 0)
			{
				while($sql_row_nop1=mysqli_fetch_array($sql_result_nop1))
				{
					$nop2=$sql_row_nop1["avail"]-$sql_row_nop1["absent"];
				}
			}
			else
			{
				$nop2=0;
			}
			
			$hoursab=0;

			$sql2b="select count(distinct hour(bac_lastup)) as \"hoursa\" from $table_name where bac_date=\"$date\" and bac_shift in (\"B\") and bac_no=$mod $time_query";
			$sql_result2b=mysqli_query($link, $sql2b) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2b=mysqli_fetch_array($sql_result2b))
			{
				$hoursab=$sql_row2b['hoursa'];
			}

			if($hoursab==4 && ($sec==4) )	{
				$hoursab=$hoursab;	
			}
			else{
				if($hoursab>3){
					$hoursab=$hoursab+0.5-1;	
				}
			}
			
			$clhab=$nop2*$hoursab;
			
			//echo "B2=".$clhab."-B1=".$hoursab."<br>";	
			
			$hoursa=$hoursaa+$hoursab;
			
			$clha=$clhaa+$clhab;
			
			$nop=$nop1+$nop2;


		$sql2="select plan_pro from $pro_plan where date=\"$date\" and mod_no=$mod and shift in ($team)";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$plan_pro=$sql_row2['plan_pro'];
		}

		$pclha=$pclha+($phours*$nop);
		$pstha=$pstha+($plan_pro*$smv)/60;
	}

/* 20100226 */
		echo "<td rowspan=4>".$atotal."</td>";
        echo "<td rowspan=4>".$hoursa."</td>";

$peffresulta=0;

if($ppro_a_total>0 && $pclha>0)
{
	$peffresulta=(round(($pstha/$pclha),2)*100);
}



		echo "<td rowspan=4>".$peffresulta."%</td>";


		echo "<td rowspan=4>".round($ppro_a_total,0)."</td>";


		echo "<td rowspan=4>".$clha_total_new."</td>"; //Change 20100819


		echo "<td rowspan=4>".round($stha_total,0)."</td>";



$xa=0;
$xb=0;
if($clha_total>0)
{
	$xa=round(($stha_total/$clha_total_new)*100,2); //Change 20100819
}




if($xa>=70)
{
	$color_per_fac2="#1cfe0a";
}
elseif($xa>=60 and $xa<70)
{
	$color_per_fac2="YELLOW";
}
else
{
	$color_per_fac2="#ff0915";
}



//echo "<td rowspan=4 bgcolor=\"$color_per_fac2\">".round($xa,0)."%</td>";
//echo "<td rowspan=4 ><font size=30 color=\"$color_per_fac2\">&#8226;</font><br/>".round($xa,0)."%</td>";

echo "<td rowspan=4 style='background-color:$color_per_fac2; color:black; font-weight:bold;' >".round($xa,0)."%</td>";




  echo "<td  rowspan=4>".round(($atotal-$ppro_a_total),0)."</td>";

   echo "<td  rowspan=4>".round($avgpcstotal,0)."</td>";

/* 20100318 */

if((7.5-$hoursa)>0)
	{
	echo "<td  rowspan=4>".round($hourlytargettotal,0)."</td>";

	}
	else
	{
		  echo "<td  rowspan=4>".round(($atotal-$ppro_a_total),0)."</td>";
	}





/* STH */

		echo "<tr class=\"total\"><td>HOURLY SAH</td>";


		for($i=0; $i<sizeof($h1); $i++)
		{

			$sth=0;

	$sql2="select sum((bac_qty*smv)/60) as \"sth\" from $table_name where bac_date=\"$date\" $time_query and bac_sec in ($sections_group) and Hour(bac_lastup) between $h1[$i] and $h2[$i]";
	
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$sth=$sql_row2['sth'];
	}



		echo "<td>".round($sth,0)."</td>";
		}

/* EFF */





		echo "<tr class=\"total\"><td>HLY EFF%</td>";


		for($i=0; $i<sizeof($h1); $i++)
		{


			$eff=0;

/* NEW20100219 */
$minutes=60;

			if(($h1[$i]==9 or $h1[$i]==17) and ($sec==1 or $sec==2 or  $sec==3 or $sec==6))
			{
					$minutes=30;
			}
			else
			{
				$minutes=60;
			}
			
			if(($h1[$i]==10 or $h1[$i]==18) and ($sec==4))
			{
					$minutes=30;
			}
			//echo $minutes;
/* NEW20100219 */

//IMS	$sql2="select sum(($table_name.bac_qty*$pro_style.smv)/($pro_style.nop*".$minutes.")*100) as \"eff\" from $table_name,$pro_style where $table_name.bac_date=\"$date\" and $pro_style.date=\"$date\" and $table_name.bac_sec in ($sections_group) and $table_name.bac_style=$pro_style.style and Hour($table_name.bac_lastup) between $h1[$i] and $h2[$i]";

$sql2="select sum((bac_qty*smv)/(nop*".$minutes.")*100) as \"eff\" from $table_name where bac_date=\"$date\" $time_query and bac_sec in ($sections_group) and Hour(bac_lastup) between $h1[$i] and $h2[$i]";

	
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$eff=$sql_row2['eff'];
	}



/* NEW20100219 */
	$sql2="select count(distinct bac_no) as \"noofmodsb\" from $table_name where bac_date=\"$date\" $time_query and Hour(bac_lastup) between $h1[$i] and $h2[$i] and bac_sec in ($sections_group)";
	
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$noofmodsb=$sql_row2['noofmodsb'];
	}

$noofmods=$noofmodsb;
/* NEW20100219 */

if($noofmods>0)
{
	echo "<td>".round((round($eff,2)/$noofmods),0)."%</td>";
}
else
{
		echo "<td>0</td>";
}

}

/* AVG p per hour */

		echo "<tr class=\"total\"><td>AVG-Pcs/HR</td>";

		$total=0;
		$btotal=0;

		for($i=0; $i<sizeof($h1); $i++)
		{

		$sum=0;
		$count=0;

		$sql2="select bac_qty from $table_name where bac_date=\"$date\" and bac_sec in ($sections_group) $time_query and Hour(bac_lastup) between $h1[$i] and $h2[$i]";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			if($sql_row2['bac_qty']>0)
				$count=$count+1;

		}


		$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" $time_query and bac_sec in ($sections_group) and Hour(bac_lastup) between $h1[$i] and $h2[$i]";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$sum=$sql_row2['sum'];
			if($sum==0)
			{
				$sum=0;
				echo "<td bgcolor=\"red\"></td>";

			}
			else
			{
				if($count>0)
				{
					echo "<td>".round(($sum/$count),0)."</td>";
				}
				else
				{
					echo "<td>".round(($sum),0)."</td>";
				}
			}

		}
		}
		echo "</tr>";


/*		echo "</table>"; */






echo "<br/>";


} /* NEW */














/* NEW 20100321 */





















/* Factroy */

     if(sizeof($sections)>1 && $secstyles==1)
     {

/* Stylewise Report */

$sdate=$date;

 $style_summ_head="";

   $sql="select * from unit_db where unit_members=\"$sections\"";
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row=mysqli_fetch_array($sql_result))
	{
        $style_summ_head=$sql_row['unit_id'];

	}
	echo "<table id=\"info\" class=\"table table-bordered\">";
     echo "<tr><td>Style Summary ".$style_summ_head."</td></tr>";
	echo "<tr><th>Style Code</th><th>SMV</th><th>Oprs</th><th>Mod Count</th>";

for($i=0;$i<sizeof($headers);$i++)
{
	echo "<th>".$headers[$i]."-".($headers[$i]+1)."</th>";
}


echo "<th>Total</th><th>Plan Pcs</th><th>Balance Pcs</th><th>Avg. Pcs/Hr</th><th>Hr Tgt.</th><th>Avg. Pcs<br/>Hr/Mod</th><th>Hr Tgt./Mod.</th></tr>";
$avgpcshrsum=0;
$planpcsgrand=0;
$balancepcs=0;
$exp_pcs_hr_total=0;
	 $avgperhour2_sum=0;
	 $exp_pcs_hr2_sum=0;

	//$sql="select distinct bac_style,smv,nop from $table_name where bac_date=\"$date\" and bac_sec in ($sections_group) and bac_shift in ($team)";
	$sql="select bac_style,smv,nop from $table_name where bac_date=\"$date\" $time_query and bac_sec in ($sections_group) and bac_shift in ($team) group by bac_style";
	echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$mod_style=$sql_row['bac_style'];
		echo "<tr><td>".$mod_style."</td>";

		$sql2="select nop,smv from $pro_style where style=\"$mod_style\" and date=\"$date\"";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			//echo "<td>".$sql_row2['smv']."</td>";
			//echo "<td>".$sql_row2['nop']."</td>";
		}
		
		//SMV and NOP from direct table
		echo "<td>".$sql_row['smv']."</td>";
		echo "<td>".$sql_row['nop']."</td>";
		
		//SMV and NOP from direct table
		
		$count=0;
		$sql2="select count(distinct bac_no) as \"count\" from $table_name where bac_date=\"$date\" $time_query and bac_sec in ($sections_group) and bac_style=\"$mod_style\" and bac_shift in ($team)";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$count=$sql_row2['count'];
			echo "<td>".$count."</td>";
		}


		$total=0;

		for($i=0; $i<sizeof($h1); $i++)
		{

		$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$sdate\" and bac_style=\"$mod_style\" $time_query and Hour(bac_lastup) between $h1[$i] and $h2[$i] and bac_sec in ($sections_group) and bac_shift in ($team)";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$sum=$sql_row2['sum'];
			if($sum==0)
			{
				$sum=0;
				echo "<td bgcolor=\"red\"></td>";

			}
			else
			{
				echo "<td bgcolor=\"YELLOW\">".$sum."</td>";
				$total=$total+$sum;
			}
		}

		}
		echo "<td>".$total."</td>";





	$plan_pcs=0;

	$sql2="select mod_no from $pro_mod where mod_sec in ($sections_group) and mod_date=\"$date\" and mod_style=\"$mod_style\"";
	
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$mod_no=$sql_row2['mod_no'];

		$sql22="select plan_pro from $pro_plan where date=\"$date\" and mod_no=$mod_no and shift in ($team)";
		
		$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($sql_row22=mysqli_fetch_array($sql_result22))
		{
			$plan_pcs=$plan_pcs+$sql_row22['plan_pro'];
		}


	}
	$planpcsgrand=$planpcsgrand+$plan_pcs;

	echo "<td>".round($plan_pcs,0)."</td>";

	$balancepcs=$balancepcs+($plan_pcs-$total);
	echo "<td>".(round($plan_pcs,0)-$total)."</td>";



/////

	$avgperhour=0;
		$avgperhour2=0;
$count2=0;
	$sql2="select count(distinct bac_no) as \"count\", sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" and bac_sec in ($sections_group) and bac_style=\"$mod_style\"  and bac_shift in ($team) $time_query";
	
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));


	while($sql_row2=mysqli_fetch_array($sql_result2))
	{

		if(($hoursa+$hoursb)>0)
		{
///		$avgperhour=round(($sql_row2['sum']/$sql_row2['count']/($hoursa)),0);
		$avgperhour2=round(($sql_row2['sum']/$sql_row2['count']/($hoursa)),0);
		$avgperhour=round(($sql_row2['sum']/($hoursa)),0);
		$count2=$sql_row2['count'];
		echo "<td>".$avgperhour."</td>";
		}
		else
		{
		echo "<td>0</td>";
		}

	}
	$avgpcshrsum=$avgpcshrsum+$avgperhour;
/////
     $exp_pcs_hr=0;
        $exp_pcs_hr2=0;

	if((7.5-$hoursa)>0)
	{
//		$exp_pcs_hr=(($plan_pcs)-(($avgperhour*$hoursa)*$count))/(7.5-$hoursa);
       $exp_pcs_hr=($plan_pcs-$total)/(7.5-$hoursa);
       $exp_pcs_hr2=(($plan_pcs-$total)/(7.5-$hoursa))/$count2;
	}
	else
	{
		$exp_pcs_hr=($total-$plan_pcs);
		$exp_pcs_hr2=($total-$plan_pcs)/$count2;
	}

	echo "<td>".round($exp_pcs_hr,0)."</td>";
	$exp_pcs_hr_total=$exp_pcs_hr_total+$exp_pcs_hr;
    echo "<td>".round($avgperhour2,0)."</td>";
	echo "<td>".round($exp_pcs_hr2,0)."</td>";
	 $avgperhour2_sum=$avgperhour2_sum+$avgperhour2;
	 $exp_pcs_hr2_sum=$exp_pcs_hr2_sum+$exp_pcs_hr2;
echo "</tr>";
	}




		echo "<tr class=\"total\"><td>Total</td><td></td><td></td><td></td>";

		$total=0;

		for($i=0; $i<sizeof($h1); $i++)
		{

		$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$sdate\" and Hour(bac_lastup) between $h1[$i] and $h2[$i] and bac_sec in ($sections_group) and bac_shift in ($team) $time_query";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$sum=$sql_row2['sum'];
			if($sum==0)
			{
				$sum=0;
				echo "<td bgcolor=\"red\"></td>";

			}
			else
			{
				echo "<td>".$sum."</td>";
				$total=$total+$sum;
			}
		}

		}
		echo "<td>".$total."</td>";

		echo "<td>".round($planpcsgrand,0)."</td>";
		echo "<td>".round($balancepcs,0)."</td>";
		echo "<td>".$avgpcshrsum."</td>";
		echo "<td>".round($exp_pcs_hr_total,0)."</td>";

			 echo "<td>".round($avgperhour2_sum,0)."</td>";
	 echo "<td>".round($exp_pcs_hr2_sum)."</td>";
	echo "<tr>";
echo "</table>";
     }
	
}


?>
</div>


</div></div></div>
</body>



<?php ((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res); ?>

<?php
// include($_SERVER['DOCUMENT_ROOT']."server/user_acl_v1.php");
// include($_SERVER['DOCUMENT_ROOT']."server/group_def.php");
// $view_access=user_acl("SFCS_0134",$username,1,$group_id_sfcs); 
//Ticket #528200 / kirang/ Need to change the factory capacity factor in update level

//Change Request # 138 / 2014-07-29/Working Days & SAH Required Calculation Formulas Changes in SAH Report 

//2015-06-02 / kirang / service request #121226 / Section Wise Plan SAH update interface access

?>
<html>
<head>
<style>
table.calendar    { border-left:1px solid #999; }
tr.calendar-row  {  }
td.calendar-day  { min-height:10px; font-size:11px; position:relative; } * html div.calendar-day { height:5px; }
td.calendar-day:hover  { background:#eceff5; }
td.calendar-day-np  { background:#eee; min-height:5px; } * html div.calendar-day-np { height:5px; }
td.calendar-day-head { background:#29759C; font-weight:bold; text-align:center; width:10px; padding:5px; border-bottom:1px solid #999; border-top:1px solid #999; border-right:1px solid #999; color: white;}
div.day-number    { background:#ffffff; padding:1px; color:#000000; font-weight:bold; float:right; margin:0px 60px 0 0; /*margin:-0px -0px 0 0;*/ width:1px; text-align:center; }
/* shared */
td.calendar-day, td.calendar-day-np { width:5px; padding:5px; border-bottom:1px solid #999; border-right:1px solid #999; }
</style>
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>	
</head>
<body>
<?php 
set_time_limit(6000000);
include '..'.getFullURL($_GET['r'],"data.php",'R'); 
// include('data.php');
include '..'.getFullURL($_GET['r'],"header.php",'R');
// include('header.php');
?>
<div class="panel panel-primary">
	 <div class="panel-heading">Monthly SAH and Working Days Updation Form :<?php echo "&nbsp"; echo "<b>"; echo date("M")."-".date("Y");echo "</b>";?></div>
		<div class="panel-body">
<!-- <div id="page_heading"><span style="float: left"><h3>Monthly SAH and Working Days Updation Form : </h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>
<h3><?php echo "&nbsp"; echo "<b>"; echo date("M")."-".date("Y");echo "</b>";?></h3> -->
<form name="form1" method="post" action="<?=getFullURL($_GET['r'],'monthly_sah_update.php','N')?>">
<?php

  $month=date("m");
  //$month=7;
  $year=date("Y");

  // include '..'.getFullURL($_GET['r'],"data.php",'R');
  include('data.php');
  /* draw table */
  $calendar = '<table  cellpadding="0" cellspacing="0" class="calendar">';

  /* table headings */
  $headings = array('Sun','Mon','Tue','Wed','Thur','Fri','Sat');
  $calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

  /* days and weeks vars now ... */
  $running_day = date('w',mktime(0,0,0,$month,1,$year));
  $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
  $days_in_this_week = 1;
  $day_counter = 0;
  $dates_array = array();

  /* row for week one */
  $calendar.= '<tr class="calendar-row">';

  /* print "blank" days until the first of the current week */
  for($x = 0; $x < $running_day; $x++):
    $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
    $days_in_this_week++;
  endfor;
  
  $calendar.= '<input type="hidden" name="nod" value="'.$days_in_month.'" />';
  /* keep going with days.... */
  for($list_day = 1; $list_day <= $days_in_month; $list_day++):
	// $days_count=str_pad($list_day,2,'0',STR_PAD_LEFT);
	// $day_checks=date("Y-m")."-".$days_count;
	// echo $day_checks."</br>";
	// var_dump($date1)."</br>";
	if(in_array($list_day,$date1))
	{	
		$status="checked=yes";
	}
	else
	{
		$status="";
	}

    $calendar.= '<td class="calendar-day">';
      /* add in the day number */
      $calendar.= '<div class="day-number"><input type="checkbox" '.$status.' name="'.$list_day.'" value="'.$list_day.'" />'.$list_day.'</div>';
		//echo $list_day;
      /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
      //$calendar.= str_repeat('<p>&nbsp;</p>',2);
      
    $calendar.= '</td>';
    if($running_day == 6):
      $calendar.= '</tr>';
      if(($day_counter+1) != $days_in_month):
        $calendar.= '<tr class="calendar-row">';
      endif;
      $running_day = -1;
      $days_in_this_week = 0;
    endif;
    $days_in_this_week++; $running_day++; $day_counter++;
  endfor;

  /* finish the rest of the days in the week */
  if($days_in_this_week < 8):
    for($x = 1; $x <= (8 - $days_in_this_week); $x++):
      $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
    endfor;
  endif;

  /* final row */
  $calendar.= '</tr></table>';
  
  $calendar1 = '<table  cellpadding="0" cellspacing="0" class="calendar">';

  /* table headings */
  $headings = array('Sun','Mon','Tue','Wed','Thur','Fri','Sat');
  $calendar1.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

  /* days and weeks vars now ... */
  $running_day = date('w',mktime(0,0,0,$month,1,$year));
  $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
  $days_in_this_week = 1;
  $day_counter = 0;
  $dates_array = array();

  /* row for week one */
  $calendar1.= '<tr class="calendar-row">';

  /* print "blank" days until the first of the current week */
  for($x = 0; $x < $running_day; $x++):
    $calendar1.= '<td class="calendar-day-np">&nbsp;</td>';
    $days_in_this_week++;
  endfor;
  
  $calendar1.= '<input type="hidden" name="nod" value="'.$days_in_month.'" />';

  /* keep going with days.... */
  for($list_day = 1; $list_day <= $days_in_month; $list_day++):
	// $days_count=str_pad($list_day,2,'0',STR_PAD_LEFT);
	// $day_checks=date("Y-m")."-".$days_count;
	if(in_array($list_day,$half_date1))
	{
		$status="checked=yes";
	}
	else
	{
		$status="";
	}
  	
    $calendar1.= '<td class="calendar-day">';
      /* add in the day number */
      $calendar1.= '<div class="day-number"><input type="checkbox" '.$status.' name="half_'.$list_day.'" value="'.$list_day.'" />'.$list_day.'</div>';
		//echo $list_day;
      /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
      //$calendar.= str_repeat('<p>&nbsp;</p>',2);
      
    $calendar1.= '</td>';
    if($running_day == 6):
      $calendar1.= '</tr>';
      if(($day_counter+1) != $days_in_month):
        $calendar1.= '<tr class="calendar-row">';
      endif;
      $running_day = -1;
      $days_in_this_week = 0;
    endif;
    $days_in_this_week++; $running_day++; $day_counter++;
  endfor;

  /* finish the rest of the days in the week */
  if($days_in_this_week < 8):
    for($x = 1; $x <= (8 - $days_in_this_week); $x++):
      $calendar1.= '<td class="calendar-day-np">&nbsp;</td>';
    endfor;
  endif;

  /* final row */
  $calendar1.= '</tr></table>';

  $calendar2= '<br/><table style="background-color: #EEEEEE;"><tr><th class=xl636519>Monthly FAC Capacity SAH</th><th>:</th><td><input type="textbox" name="facmsh" style="border=1px solid #999999;" size="8" onkeypress="return IsNumeric(event);" value="'.$fac_plan_sah.'"/></td></tr>';
	
   $calendar2.= '<tr><th class=xl636519>Monthly FAC SAH</th><th>:</th><td><input type="textbox" name="msh" style="border=1px solid #999999;" size="8" onkeypress="return IsNumeric(event);" value="'.$fac_plan.'"/></td></tr>';
  $calendar2.= '<tr><th class=xl636519>Monthly VS SAH</th><th>:</th><td><input type="textbox" name="vssah" onkeypress="return IsNumeric(event);" style="border=1px solid #999999;" size="8" value="'.$vs_plan.'"/></td></tr>';
  
  $calendar2.= '<tr><th class=xl636519>Monthly MS SAH</th><th>:</th><td><input type="textbox" name="mssah" onkeypress="return IsNumeric(event);" style="border=1px solid #999999;" size="8" value="'.$ms_plan.'"/></td></tr>';
  
  //2015-06-02 / kirang / service request #121226 / Section Wise Plan SAH update interface access  
  $section_array=array();
  $sql_hods="select sec_id from bai_pro3.sections_db where sec_id > 0";
  //echo "</br>SQL : ".$sql_hods."</br>";
  $sql_result_hod=mysqli_query($con,$sql_hods) or die("Error".$sql_hods."-".mysqli_error($GLOBALS["___mysqli_ston"]));
  while($row_hods=mysqli_fetch_array($sql_result_hod))
  {
		$section_array[]=$row_hods["sec_id"];
		$sql12="SELECT section_display_name FROM $bai_pro3.sections_master WHERE sec_name=".$row_hods["sec_id"];
		$result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row12=mysqli_fetch_array($result12))
		{
			$section_display_name=$sql_row12["section_display_name"];
		}
		$calendar2.='<tr><th class=xl636519>'.$section_display_name.'</th><th>:</th><td><input type="textbox" name="section_'.$row_hods["sec_id"].'" style="border=1px solid #999999;" onkeypress="return IsNumeric(event);" size="8" value="'.$plan_sah_mod[($row_hods["sec_id"]-1)].'"/></td></tr>';
  } 
  $calendar2.= '<br/></table><table><tr><td><br/><input type="submit" value="Save" name="submit" class="btn btn-primary"></td></tr></table>';

  echo "<table>";	
  echo "<tr><td><h3><u><b>Working Days</b></u></h3></td><td></td><td><h3><u><b>Half Days</b></u></h3></td></tr>";
  echo "<tr><td>".$calendar."</td><td style='width:40px;'></td><td>".$calendar1."</td></tr>";
  echo "<tr><td>".$calendar2."</td></tr></table>";
	echo  '<span id="error" style="color: Red; display: none"></span>';

?>
</form>
<?php
if(isset($_POST["submit"]))
{
	for($i=1;$i<=31;$i++)
	{
		if(!empty($_POST[$i]))
		{
			$date_value[]=$_POST[$i];
			//echo "Working Day = ".$_POST[$i]."<br>";
		}
		
		if(!empty($_POST["half_".$i.""]))
		{
			$half_date_value[]=$_POST["half_".$i.""];
			//echo "Half Day = ".$_POST["half_".$i.""]."<br>";
		}
		else
		{
			$half_date_value[]=NULL;
		}
	}
	
	//2015-06-02 / kirang / service request #121226 / Section Wise Plan SAH update interface access
	for($i2=0;$i2<sizeof($section_array);$i2++)
	{
		if($i2==0)
		{
			$plan_sah_mod="'".($section_array[$i2]-1)."'=>'".$_POST["section_".$section_array[$i2]]."'";
			$plan_sah_mod_ref="".$_POST["section_".$section_array[$i2]]."";
		}
		else
		{
			$plan_sah_mod.=",'".($section_array[$i2]-1)."'=>'".$_POST["section_".$section_array[$i2]]."'";
			$plan_sah_mod_ref.=",".$_POST["section_".$section_array[$i2]]."";
		}		
	}
	
	//echo $plan_sah_mod_ref."<br>";
	
	$fac_sah=$_POST['facmsh'];
	$plan_value=$_POST['msh'];
	$vs_value=$_POST['vssah'];
	$ms_value=$_POST['mssah'];
	$data_sym="$";
	$year=date("Y");
	$month=date("m");
	
	$plan_fac=$plan_value;
	
	$dates_all=array();
	
	//echo sizeof($date_value)."<br>";
	
	for($i=0;$i<sizeof($date_value);$i++)
	{	
		//echo "</br>".$date_value[$i]."</br>";
		if($date_value[$i]<10)
		{
			$dates_all[]="\"".$year."-".$month."-0".$date_value[$i]."\"";
		}
		else
		{
			$dates_all[]="\"".$year."-".$month."-".$date_value[$i]."\"";
		}
		
	}
	
	$all_dates=implode(",",$dates_all);

	$half_dates_all=array();
	
	if(sizeof($half_date_value) > 0)
	{
		for($i=0;$i<sizeof($half_date_value);$i++)
		{	
			echo $half_date_value[$i];
			if($half_date_value[$i] > 0)
			{		
				if($half_date_value[$i]<10)
				{
					$half_dates_all[]="\"".$year."-".$month."-0".$half_date_value[$i]."\"";
				}
				else
				{
					$half_dates_all[]="\"".$year."-".$month."-".$half_date_value[$i]."\"";
				}
			}
			else
			{
				$half_dates_all[]=0;
			}			
		}
		$half_all_dates=implode(",",$half_dates_all);
		
		$half_dates_all1=array();
		for($i=0;$i<sizeof($half_date_value);$i++)
		{
			if($half_date_value[$i] > 0)
			{
				$half_dates_all1[]="\"".$half_date_value[$i]."\"";
			}
			else
			{
				$half_dates_all1[]="\"0\"";
			}
		}
		$half_all_dates1=implode(",",$half_dates_all1);	
	}
	else
	{
		$half_all_dates="";
		$half_all_dates1="";
	}
	
	
	$dates_all1=array();
	for($i=0;$i<sizeof($date_value);$i++)
	{
		$dates_all1[]="\"".$date_value[$i]."\"";
	}
	$all_dates1=implode(",",$dates_all1);
	
	//2015-06-02 / kirang / service request #121226 / Section Wise Plan SAH update interface access
	$File = '../'.getFullURL($_GET['r'],"data.php",'R');
	//echo $File;exit;
	$fh = fopen($File, 'w') or die("can't open file");
	$stringData = "<?php ".$data_sym."date=array(".$all_dates."); ".$data_sym."half_date=array(".$half_all_dates."); ".$data_sym."date1=array(".$all_dates1."); ".$data_sym."half_date1=array(".$half_all_dates1."); ".$data_sym."fac_plan=\"".$plan_fac."\"; ".$data_sym."vs_plan=\"".$vs_value."\"; ".$data_sym."ms_plan=\"".$ms_value."\"; ".$data_sym."fac_plan_sah=\"".$fac_sah."\"; ".$data_sym."plan_sah_mod=array(".$plan_sah_mod."); ?>";
	fwrite($fh, $stringData);
	fclose($fh);	
	
	//$note_file="sah_log.txt";
	
	echo "<script>sweetAlert('ok','data Updated successfully','success')</script>";
	$url=getFullURL($_GET['r'],"monthly_sah_update.php",'N');
	 echo "<script type='text/javascript'>";
			 echo "setTimeout('Redirect()',0);";
			 echo "var url='".$url."';";
			 echo "function Redirect(){location.href=url;}</script>";
	//header("Location:$dns_adr3/");
}
?>
</div>
</div>
</body>
</html>

	<script type="text/javascript">
							var specialKeys = new Array();
							specialKeys.push(8); //Backspace
							function IsNumeric(e) {
								var keyCode = e.which ? e.which : e.keyCode
								var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
								document.getElementById("error").style.display = ret ? "none" : sweetAlert({title:"Please Enter only Numerics"});
								return ret;
							}
						</script>
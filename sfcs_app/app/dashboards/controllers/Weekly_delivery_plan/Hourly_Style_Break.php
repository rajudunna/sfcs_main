<html>
<head>
<title>POP - Style Breakup</title>
<style>
body
{
	font-family:calibri;
	font-size:12px;
}
table th
{
	border: 1px solid black;
	text-align: center;
    background-color: #003366;
	color: WHITE;
	white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}
td {
    background-color: GREY;
	color: black;
	text-align: center;
}


</style>
</head>

<body>

<?php
    include("..".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
?>

<div class="panel panel-primary"><div class="panel-heading">Hourly Style Breakup</div><div class="panel-body">


<?php 
// $bai_log_table_name=" $bai_pro2.bai_log_buf ";
$styles=$_GET['styles'];
$date=date("Y-m-d");
$schedule=$_GET['schedule'];

$sql="select style_id from $bai_pro2.movex_styles where movex_style like \"%".$styles."%\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$styles=$sql_row['style_id'];
}
//echo $styles;

echo "<span style='background-color:orange;color:blue;font-size:19px;'><bold>Report Date: ".$date.'</bold></span>';

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
   
   
/* Function END */
// $sections=array(1,2,3,4,5,6);




$i=0;

$sql="select distinct(Hour(bac_lastup)) as \"time\" from $bai_pro.bai_log_buf where bac_date=\"$date\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$hoursa=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$timestr=$sql_row['time'].":0:0";
	$h[$i]=TimeCvt($timestr,0);
	$headers[$i]=date("H",strtotime($timestr));
	$i=$i+1;
}

echo "<br/><br/><div class='col-md-12' style='max-height:600px;overflow-y:scroll;'><table class='table'><tr>";
echo "<th>Style</th>";
echo "<th>Section</th>";
echo "<th>Module No</th>";

for($i=0;$i<sizeof($h);$i++)
{
	echo "<th>".$h[$i]."-".($h[$i]+1)."</th>"; 
}

echo "<th>Total</th>";
echo "<th>Avg/Mod</th>";
echo "<th>Avg/Sec</th>";
echo "<th>Avg/Style</th>";
echo "<th>Grand</th>";
echo "</tr>";


// Style Break Start
	$row_bg_col=1;

	$style=$styles;
	
		$module_count=0;
		$sql2="select distinct(bac_no) as \"module\" from $bai_pro.bai_log_buf where bac_date=\"$date\" and bac_style=\"$style\" and delivery=$schedule order by bac_no";
		
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$module_count=mysqli_num_rows($sql_result2); 
		//echo $module_count."<br/>";
	
	$style_check=0;

	
		if($row_bg_col==1)
		{
			//$bg_color1="#6699FF";
			//$bg_color2="#66CCFF";
			$bg_color1="#FFCC66";
			$bg_color2="#FFFF99";
			$row_bg_col=0;	
		}
		else
		{
			//$bg_color1="#FF99FF";
			//$bg_color2="#FFCCFF";
			$bg_color1="#99CC33";
			$bg_color2="#CCFF99";
			$row_bg_col=1;	
		}
	
	$sql="select distinct(bac_sec) as \"section\" from $bai_pro.bai_log_buf where bac_date=\"$date\" and bac_style=\"$style\" and delivery=$schedule order by bac_sec";
	
//echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$section=$sql_row['section'];
		
		$sql2="select distinct distinct(bac_no) as \"module\" from $bai_pro.bai_log_buf where bac_date=\"$date\" and bac_style=\"$style\" and bac_sec=\"$section\" and delivery=$schedule order by bac_no";
		
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$section_count=mysqli_num_rows($sql_result2); 
		//echo $module_count;
		
		//NEW
		
		$sql11="select distinct(Hour(bac_lastup)) as \"time\" from $bai_pro.bai_log_buf where bac_date=\"$date\" and bac_sec=$section";
		
		mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$hoursa=mysqli_num_rows($sql_result11);

		if($hoursa==4 && ($section==3 || $section==4) )
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
		if($hoursa==11.5 && ($section==3 || $section==4) )
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
		//NEW
		


		$section_check=0;
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$module=$sql_row2['module'];
			
			echo "<tr bgcolor=\"$bg_color1\">";
					
			if($style_check==0)
			{
				echo "<td rowspan=$module_count >$style</td>";
				$style_check=1;
			}				
			
			if($section_check==0)
			{
				echo "<td rowspan=$section_count>$section</td>";
				$section_check=1;
			}
			
			echo "<td>$module</td>";
			
			$module_sum=0;
			for ($j=0;$j<sizeof($headers);$j++)
			{
				$qty=0;
				$sql3="select sum(bac_qty) as \"qty\" from $bai_pro.bai_log_buf where bac_date=\"$date\" and bac_style=\"$style\" and bac_sec=\"$section\" and bac_no=$module and delivery=$schedule and Hour(bac_lastup)=$headers[$j]";
				mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row3=mysqli_fetch_array($sql_result3))
				{
					$qty=$sql_row3['qty'];
					echo "<td bgcolor=\"$bg_color2\">$qty</td>";
					$module_sum=$module_sum+$qty;			
				}
			}
			echo "<td>$module_sum</td>";
			echo "<td>".round(($module_sum/$hoursa),0)."</td>";
			
			//NEW
				$sec_qty=0;
				$sql3="select sum(bac_qty) as \"sec_qty\" from $bai_pro.bai_log_buf where bac_date=\"$date\" and bac_style=\"$style\" and delivery=$schedule and bac_sec=\"$section\"";
				mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row3=mysqli_fetch_array($sql_result3))
				{
					$sec_qty=$sql_row3['sec_qty'];
				}
				
				if($section_check==1)
				{
					echo "<td rowspan=$section_count>".round((($sec_qty/$section_count)/$hoursa),0)."</td>";
					$section_check=2;
				}
				
			//NEW	
			
			//NEW
				$style_qty=0;
				$sql3="select sum(bac_qty) as \"style_qty\" from $bai_pro.bai_log_buf where bac_date=\"$date\" and delivery=$schedule and bac_style=\"$style\"";
				mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row3=mysqli_fetch_array($sql_result3))
				{
					$style_qty=$sql_row3['style_qty'];
				}
				
				if($style_check==1)
				{
					echo "<td rowspan=$module_count>".round((($style_qty/$module_count)/$hoursa),0)."</td>";
					echo "<td rowspan=$module_count>".$style_qty."</td>";
					$style_check=2;
				}
				
			//NEW
			
			echo "</tr>";
		}
	}
	echo "</table></div>";


// Style Break End

// END




?>
</div>
</div>
</body>
</html>


<?php ((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res); ?>
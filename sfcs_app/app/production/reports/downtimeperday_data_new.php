<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- <html> -->
<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
<title>Down Time Report</title>

<!--IMPORT CSS STYLE SHEET FOR APPLYING FORMATING SETTINGS-->
<link rel="stylesheet" type="text/css" href="<?= getFullURL($_GET['r'],'test.css','R')?>" />


<div class="panel panel-primary">
<div class="panel-heading">Style And Department Wise Down Time Report</div>
<div class="panel-body">
<?php

    include("..".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include("..".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
error_reporting(0);

echo "<form action=".getFullURL($_GET['r'],'downtimeperday_data_new.php','N')." method=\"post\" id=\"non-printable\">
<div class='row'>
	<div class='col-md-3'>
		<label>Start Date</label>
		<input type=\"text\" data-toggle='datepicker' name=\"dat\" size=\"8\" value=".$_POST['dat']." class=\"form-control\" />
	</div>
	<div class='col-md-3'>
		<label>End Date</label>
		<input type=\"text\" data-toggle='datepicker' name=\"dat1\" size=\"8\" value=".$_POST['dat1']." class=\"form-control\" />
	</div>
	<div class='col-md-3'>
		<label>Select Team</label>
		<select name=\"team\" class=\"form-control\">
			<option value='\"A\"'>A</option>
			<option value='\"B\"'>B</option>
			<option value='\"A\", \"B\"'>All</option>
		</select>
	</div>
	<div class='col-md-3'>
		<input type=\"submit\" value=\"Show\" class=\"btn btn-primary\" style=\"margin-top:22px;\"/>
	</div>
</div>
</form>";

$start=$_POST['dat'];
$end=$_POST['dat1'];
$shift=$_POST['team'];

echo "<hr><div class='table-responsive'><table class='table table-bordered'>
      <tr>
  			 <th colspan='11' style='background-color:#29759C;color:white;'>DAILY LOST TIME REPORT</th>
 			 <th colspan='15' style='background-color:#29759C;color:white;'>Start Date : ".$start." End Date : ".$end." Shift : ".$shift."</th>
 	  </tr>
      <tr>
   		    <th rowspan='2' style='background-color:#29759C;color:white;'>TeamNo</th>
			<th rowspan='2' style='background-color:#29759C;color:white;'>Actual Styles</th>";
			//<th rowspan='2'>Down Time Styles</th>
		    //<th rowspan='2'>Style</th>
   			echo "<th style='background-color:#29759C;color:white;' colspan='24'>Type Of Delay</th>
  	  </tr>
      <tr>";
		
	  $sql="select dep_name from $bai_pro.down_deps order by dep_id+0";
	  //echo $sql;
	  mysqli_query($link, $sql) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
      $row=mysqli_query($link, $sql) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	  while($rows=mysqli_fetch_array($row))
	  {
	   	 $dep[]=$rows['dep_name'];
		 echo "<th style='background-color:#29759C;color:white;'>".$rows['dep_name']."</th>";
	  }
	   
			echo "<th style='background-color:#29759C;color:white;'>Total</th>";
  	 echo "</tr>";
    
	 $sql1="select * from $bai_pro.pro_sec_db";
	 //echo $sql1;
	 mysqli_query($link, $sql1) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
     $row1=mysqli_query($link, $sql1) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	 while($rows1=mysqli_fetch_array($row1))
	 {
	 	$sec[]=$rows1["sec_no"];
		$sec_head[]=$rows1["sec_head"];
	 }
	 
	 //echo "sec = ".sizeof($sec)." Sec head =".sizeof($sec_head)."<br>";
	 /*for($i=0;$i<sizeof($sec);$i++)
	 {
	 	echo " Sec = ".$sec[$i]."  Sec Head = ".$sec_head[$i]."<br><br>";
	 }
	 */
	 for($i=0;$i<sizeof($sec);$i++)
	 {
	 	echo "<tr>";
		echo "<th colspan=\"26\"> Section - ".$sec[$i]."<br>  Sec Head - ".$sec_head[$i]."</th>";
		echo "</tr>";
		$sql2="select distinct module from $bai_pro.grand_rep where section=\"$sec[$i]\" and shift in ($shift) and date between \"$start\" and \"$end\" order by module+0";
		//echo $sql2;
		//echo "select distinct module from $bai_pro.grand_rep where section=\"$sec[$i]\" and shift in ($shift) order by module+0";
		mysqli_query($link, $sql2) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	    $row2=mysqli_query($link, $sql2) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rows2=mysqli_fetch_array($row2))
		{
			echo "<tr>";
			echo "<th>".$rows2["module"]."</th>";
			
			//actual runned styles in module
			$sql3="select distinct styles from $bai_pro.grand_rep where module=\"$rows2[module]\" and section=\"$sec[$i]\" and shift in ($shift) and date between \"$start\" and \"$end\"";
			//echo $sql3;
			mysqli_query($link, $sql3) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $row3=mysqli_query($link, $sql3) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rows_count=mysqli_num_rows($row3);
			//echo "ROWS = ".$rows_count;
			if($rows_count > 0)
			{
				while($rows3=mysqli_fetch_array($row3))
				{
				   $style[]=$rows3["styles"];
				   $styles=implode(",",$style);
				   //echo "<th>".$styles."</th>";	
				   $styles_all[]=$styles;
				   $styles="";
				   $style=$styles;
				}
			}
			else
			{
				   $style="0";
				   $styles=implode(",",$style);
				   //echo "<th>".$styles."</th>";	
				   $styles_all[]=$styles;
				   $styles="";
				   $style=$styles;
			}
			
			$styles_new=implode(",",$styles_all);
			$styles_explode=explode(",",$styles_new);
			$result = array_unique($styles_explode);
			$styles_implode=implode(",",$result);
			//print_r($result);
			echo "<th>".$styles_implode."</th>";	
			$styles_all="";
			
			//down time styles in module
			/*$sql4="select style,MOD_NO from $bai_pro.down_log where section=\"$sec[$i]\" and mod_no=\"$rows2[module]\" and shift in ($shift) and date between \"$start\" and \"$end\"";

            $sql4="SELECT style,mod_no FROM $bai_pro.down_log WHERE section=\"$sec[$i]\" AND mod_no=\"$rows2[module]\" AND shift IN (\"A\",\"B\") AND DATE BETWEEN \"2011-06-20\" AND \"2011-06-30\"";
			mysql_query($sql4,$con) or exit("Error".mysql_error());
		    $row4=mysql_query($sql4,$con) or exit("Error".mysql_error());
			while($rows4=mysql_fetch_array($row4))
			{
			   	$down_style[]=$rows4["style"];
				$down_styles=implode(",",$down_style);
				$down_styles_all[]=$down_styles;
				$down_styles="";
				$down_style=$down_styles;
			}			
			
			$down_styles_new=implode(",",$down_styles_all);
			echo "<th>".$down_styles_new."</th>";
			$down_styles_all="";*/
			
			for($j=0;$j<sizeof($dep);$j++)
			{
				$sql4="select dep_id from $bai_pro.down_deps where dep_name=\"$dep[$j]\"";
			  	mysqli_query($link, $sql4) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		      	$row4=mysqli_query($link, $sql4) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			  	while($rows4=mysqli_fetch_array($row4))
			  	{				
					$dep_id=$rows4["dep_id"];
					$sql5="select sum(dtime) from $bai_pro.down_log where department=\"$dep_id\" and date between \"$start\" and \"$end\" and section=\"$sec[$i]\" and mod_no=\"$rows2[module]\" and shift in ($shift)";
					//echo $sql5."<br>";
				  	mysqli_query($link, $sql5) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			      	$row5=mysqli_query($link, $sql5) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				  	while($rows5=mysqli_fetch_array($row5))
				  	{
						echo "<td>".round($rows5["sum(dtime)"]/60,0)."</td>";
					}
				}
			}
			
			$sql6="select sum(dtime) from $bai_pro.down_log where date between \"$start\" and \"$end\" and section=\"$sec[$i]\" and mod_no=\"$rows2[module]\" and shift in ($shift)";
				//echo $sql6."<br>";
			mysqli_query($link, $sql6) or exit("Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $row6=mysqli_query($link, $sql6) or exit("Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rows6=mysqli_fetch_array($row6))
			{
				echo "<td>".round($rows6["sum(dtime)"]/60,0)."</td>";
			}	
			echo "</tr>";
		}
		echo "<tr>";		
		echo "<th colspan=\"2\">section $sec[$i] Total</th>";
		for($j=0;$j<sizeof($dep);$j++)
			{
				$sql7="select dep_id from $bai_pro.down_deps where dep_name=\"$dep[$j]\"";
			  	mysqli_query($link, $sql7) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		      	$row7=mysqli_query($link, $sql7) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			  	while($rows7=mysqli_fetch_array($row7))
			  	{				
					$dep_id=$rows7["dep_id"];
					$sql8="select sum(dtime) from $bai_pro.down_log where department=\"$dep_id\" and date between \"$start\" and \"$end\" and section=\"$sec[$i]\" and shift in ($shift)";
					//echo $sql8."<br>";
				  	mysqli_query($link, $sql8) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			      	$row8=mysqli_query($link, $sql8) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				  	while($rows8=mysqli_fetch_array($row8))
				  	{
						echo "<td bgcolor=\"#00ffff\">".round($rows8["sum(dtime)"]/60,0)."</td>";
					}
				}
			}	
			
			$sql9="select sum(dtime) from $bai_pro.down_log where date between \"$start\" and \"$end\" and section=\"$sec[$i]\" and shift in ($shift)";
					//echo $sql9."<br>";
			mysqli_query($link, $sql9) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$row9=mysqli_query($link, $sql9) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rows9=mysqli_fetch_array($row9))
			{
				echo "<td bgcolor=\"#00ffff\">".round($rows9["sum(dtime)"]/60,0)."</td>";
			}		
			
			echo "</tr>";
		
	 }
            echo "<tr>";
			
			echo "<th colspan=\"2\">Factory Total</th>";
			
			for($j=0;$j<sizeof($dep);$j++)
			{
				$sql11="select dep_id from $bai_pro.down_deps where dep_name=\"$dep[$j]\"";
			  	mysqli_query($link, $sql11) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		      	$row11=mysqli_query($link, $sql11) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			  	while($rows11=mysqli_fetch_array($row11))
			  	{				
					$dep_id=$rows11["dep_id"];
					$sql12="select sum(dtime) from $bai_pro.down_log where department=\"$dep_id\" and date between \"$start\" and \"$end\" and shift in ($shift)";
					//echo $sql12."<br>";
				  	mysqli_query($link, $sql12) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			      	$row12=mysqli_query($link, $sql12) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				  	while($rows12=mysqli_fetch_array($row12))
				  	{
						echo "<th>".round($rows12["sum(dtime)"]/60,0)."</th>";
					}
				}
			}	
			
			$sql10="select sum(dtime) from $bai_pro.down_log where date between \"$start\" and \"$end\" and shift in ($shift)";
			//echo $sql10."<br>";
			mysqli_query($link, $sql10) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$row10=mysqli_query($link, $sql10) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rows10=mysqli_fetch_array($row10))
			{
				echo "<th>".round($rows10["sum(dtime)"]/60,0)."</th>";
			}		
			
			echo "</tr>";

echo "</table></div>";
 
?>
</div>
</div>
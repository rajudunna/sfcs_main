
<?php 
include("..".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include("..".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
include("..".getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R'));
 $view_access=user_acl("SFCS_0027",$username,1,$group_id_sfcs); 
?>


<!-- <LINK href="../style.css" rel="stylesheet" type="text/css"> -->
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/datetimepicker_css.js',2,'R'); ?>"></script>
<!-- <?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?> -->

<div class="panel panel-primary">
<div class="panel-heading">Sewing Performance Report</div>
<div class="panel-body">
<form name="test" method="post" action="<?php echo '?r='.$_GET['r']; ?>">
<div class="row">
	<div class="col-md-3 form-group">
<label>From Date: </label><input type="text" class="form-control" data-toggle='datepicker' name="fdate" size="8" id="demo1" value="<?php  if(isset($_POST['fdate'])) { echo $_POST['fdate']; } else { echo date("Y-m-d"); } ?>" >
</div>
<div class="col-md-3 form-group">
<label>To Date: </label><input type="text" name="tdate" class="form-control" data-toggle='datepicker' size="8" id="demo2" value="<?php  if(isset($_POST['tdate'])) { echo $_POST['tdate']; } else { echo date("Y-m-d"); } ?>" >
</div>
<div class="col-md-3 form-group">
<label>Section: </label><select name="sec" class="form-control">
 		 	<option value="1,2,3,4,5,6">All</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
		 </select>
		 </div>
<div class="col-md-3 form-group">
<input type="submit" name="submit" value="Show" class="btn btn-primary" style="margin-top:22px;">
</div>
</div>
</form>

<?php

if(isset($_POST['submit']))
{
	$fdate=$_POST['fdate'];
	$tdate=$_POST['tdate'];
	$section=$_POST['sec'];
	//echo $section."<br>";
	
	$sections=explode(",",$section);
	//echo "Size = ".sizeof($sections);
	
	echo "<hr/><table class=\"table table-bordered\">";
	echo "<tr style='background-color:#6995d6;color:white'>";
	echo "<th></th>";
	for($i=0;$i<sizeof($sections);$i++)
	{
		echo "<th>Section - ".$sections[$i]."</th>";
	}
	echo "</tr>";
	
	echo "<tr>";
	echo "<th>Plan Eff</th>";	
	
	for($i=0;$i<sizeof($sections);$i++)
	{
		$sql="select SUM(IF(parameter=\"A4001\",VALUE,0)) as plan_sah,SUM(IF(parameter=\"A3001\",VALUE,0)) as plan_clh from $bai_kpi.kpi_tracking where title in (".$sections[$i].") and rep_date between \"".$fdate."\" and \"".$tdate."\" ";
		//echo $sql;
		$result=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result))
		{
			if($row["plan_clh"]==0)
			{
				echo "<td>0%</td>";
			}
			else
			{
				echo "<td>".round($row["plan_sah"]*100/$row["plan_clh"],0)."%</td>";
			}
			
		}
	}
	
	echo "</tr>";
	
	echo "<tr>";
	echo "<th>Actual Eff</th>";	
	
	for($i=0;$i<sizeof($sections);$i++)
	{
		$sql="select SUM(IF(parameter=\"A4002\",VALUE,0)) as act_sah,SUM(IF(parameter=\"A3002\",VALUE,0)) as act_clh,SUM(IF(parameter=\"A3001\",VALUE,0)) as plan_clh from $bai_kpi.kpi_tracking where title in (".$sections[$i].") and rep_date between \"".$fdate."\" and \"".$tdate."\" ";
		//echo $sql;
		$result=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result))
		{
			if($row["plan_clh"] == 0)
			{
				echo "<td>0%</td>";
			}
			else
			{
				echo "<td>".round($row["act_sah"]*100/$row["plan_clh"],0)."%</td>";
			}
		}
	}
	
	echo "</tr>";
	
	echo "<tr bgcolor=\"#c0c0c0\">";
	echo "<th>Achievement</th>";	
	
	for($i=0;$i<sizeof($sections);$i++)
	{
		$sql="select SUM(IF(parameter=\"A4001\",VALUE,0)) as plan_sah,SUM(IF(parameter=\"A3001\",VALUE,0)) as plan_clh,SUM(IF(parameter=\"A4002\",VALUE,0)) as act_sah,SUM(IF(parameter=\"A3002\",VALUE,0)) as act_clh from $bai_kpi.kpi_tracking where title in (".$sections[$i].") and rep_date between \"".$fdate."\" and \"".$tdate."\" ";
		//echo $sql;
		$result=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result))
		{
			if($row["plan_clh"] == 0)
			{
				$act_eff=0;
			}
			else
			{
				$act_eff=round($row["act_sah"]/$row["plan_clh"],2);
			}
		
			if($row["plan_clh"] == 0)
			{
				$plan_eff=0;
			}
			else
			{
				$plan_eff=round($row["plan_sah"]/$row["plan_clh"],2);
			}
			
			if($plan_eff == 0)
			{
				echo "<td>0%</td>";
			}
			else
			{
				echo "<td>".round(($act_eff/$plan_eff)*100,0)."%</td>";
			}			
		}
	}
	
	echo "</tr>";
	
	
	echo "<tr>";
	echo "<th>Plan SAH</th>";	
	
	for($i=0;$i<sizeof($sections);$i++)
	{
		$sql="select SUM(IF(parameter=\"A4001\",VALUE,0)) as plan_sah from $bai_kpi.kpi_tracking where title in (".$sections[$i].") and rep_date between \"".$fdate."\" and \"".$tdate."\" ";
		//echo $sql;
		$result=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result))
		{
			echo "<td>".round($row["plan_sah"],0)."</td>";
		}
	}
	
	echo "</tr>";
	echo "<tr>";
	echo "<th>Actual SAH</th>";	
	
	for($i=0;$i<sizeof($sections);$i++)
	{
		$sql="select SUM(IF(parameter=\"A4002\",VALUE,0)) as act_sah from $bai_kpi.kpi_tracking where title in (".$sections[$i].") and rep_date between \"".$fdate."\" and \"".$tdate."\" ";
		//echo $sql;
		$result=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result))
		{
			echo "<td>".round($row["act_sah"],0)."</td>";
		}
	}
	
	echo "</tr>";
	
	echo "<tr bgcolor=\"#c0c0c0\">";
	echo "<th>Achievement</th>";	
	
	for($i=0;$i<sizeof($sections);$i++)
	{
		$sql="select SUM(IF(parameter=\"A4001\",VALUE,0)) as plan_sah,SUM(IF(parameter=\"A4002\",VALUE,0)) as act_sah from $bai_kpi.kpi_tracking where title in (".$sections[$i].") and rep_date between \"".$fdate."\" and \"".$tdate."\" ";
		//echo $sql;
		$result=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result))
		{
			if($row["plan_sah"] == 0)
			{
				echo "<td>0%</td>";
			}
			else
			{
				echo "<td>".round(($row["act_sah"]/$row["plan_sah"])*100,0)."%</td>";
			}
			
		}
	}
	
	echo "</tr>";
	
	echo "<tr>";
	echo "<th>Rework Pcs</th>";	
	
	$output=array();
	for($i=0;$i<sizeof($sections);$i++)
	{
		$sql="select SUM(IF(parameter=\"A5001\",VALUE,0)) as rework from $bai_kpi.kpi_tracking where title in (".$sections[$i].") and rep_date between \"".$fdate."\" and \"".$tdate."\" ";
		//echo $sql;
		$result=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result))
		{
			$rework=$row["rework"];
		}
		
		$output[$i]=0;
		$sql1="select SUM(act_out) as output from $bai_pro.grand_rep where section in (".$sections[$i].") and date between \"".$fdate."\" and \"".$tdate."\" ";
		//echo $sql;
		$result1=mysqli_query($link, $sql1) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row1=mysqli_fetch_array($result1))
		{
			$output[$i]=$row1["output"];
		}
		
		if($output[$i] == 0)
		{
			echo "<td>0%</td>";
		}
		else
		{
			$rework_per=round(($rework/$output[$i])*100,2);		
			echo "<td>".$rework_per."%</td>";
		}		
	}
	
	echo "</tr>";
	
	echo "<tr>";
	echo "<th>Rejection Pcs</th>";	
	
	for($i=0;$i<sizeof($sections);$i++)
	{
		$sql="select SUM(IF(parameter=\"A5002\",VALUE,0)) as rejections from $bai_kpi.kpi_tracking where title in (".$sections[$i].") and rep_date between \"".$fdate."\" and \"".$tdate."\" ";
		//echo $sql;
		$result=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result))
		{
			$rejections=$row["rejections"];
		}
		
		if($output[$i] == 0)
		{
			echo "<td>0%</td>";
		}
		else
		{
			$rework_per=round(($rejections/$output[$i])*100,2);		
			echo "<td>".$rework_per."%</td>";
		}
		
	}
	
	echo "</tr>";
	
	echo "<tr>";
	echo "<th>First Hour Achievement</th>";	
	
	for($i=0;$i<sizeof($sections);$i++)
	{
		$sql="select SUM(IF(parameter=\"A6001\",VALUE,0)) as first_hr_sah,SUM(IF(parameter=\"A6003\",VALUE,0)) as first_hr_clh,SUM(IF(parameter=\"A3001\",VALUE,0)) as plan_clh,SUM(IF(parameter=\"A4001\",VALUE,0)) as plan_sah from $bai_kpi.kpi_tracking where title in (".$sections[$i].") and rep_date between \"".$fdate."\" and \"".$tdate."\" ";
		//echo $sql;
		$result=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result))
		{
			if($row["first_hr_clh"] == 0)
			{
				$first=0;
			}
			else
			{
				$first=round(($row["first_hr_sah"]/$row["first_hr_clh"])*100,2);
			}
			
			if($row["plan_clh"] == 0)
			{
				$total=0;
			}
			else
			{
				$total=round(($row["plan_sah"]/$row["plan_clh"])*100,2);
			}
			
			
			if($total==0)
			{
				echo "<td>0%</td>";
			}
			else
			{
				echo "<td>".round(($first/$total)*100,0)."%</td>";
			}
			
		}
	}
	
	echo "</tr>";
	
	echo "<tr>";
	echo "<th>Sewing WIP</th>";	
	
	for($i=0;$i<sizeof($sections);$i++)
	{
		$sql="select SUM(IF(parameter=\"A2001\",VALUE,0)) as wip from $bai_kpi.kpi_tracking where title in (".$sections[$i].") and rep_date between \"".$fdate."\" and \"".$tdate."\" ";
		//echo $sql;
		$result=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result))
		{
			$wip=$row["wip"];
		}
		
		echo "<td>".round($wip,0)."</td>";
		
	}
	
	echo "</tr>";
	
	echo "<tr>";
	echo "<th>Reporting</th>";	
	
	for($i=0;$i<sizeof($sections);$i++)
	{
		$sql="select SUM(IF(parameter=\"A6002\",VALUE,0)) as fall,SUM(IF(parameter=\"A4002\",VALUE,0)) as act_sah from $bai_kpi.kpi_tracking where title in (".$sections[$i].") and rep_date between \"".$fdate."\" and \"".$tdate."\" ";
		//echo $sql;
		$result=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result))
		{
			$fall=$row["fall"];
			$act_sah=$row["act_sah"];
		}
		
		if($act_sah==0)
		{
			echo "<td>0</td>";
		}
		else
		{
			echo "<td>".(100-round(($fall/$act_sah)*100,0))."%</td>";
		}	
	}
	
	echo "</tr>";
	echo "</table>";
	
}
?>
</div>
</div>
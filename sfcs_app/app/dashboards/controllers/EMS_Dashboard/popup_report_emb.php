<?php include("../dbconf.php"); ?>
<?php include("functions.php"); 
$section_no=$_GET['section_no'];
?>

<html>
<head>

<!-- Loading Page -->

<script type="text/javascript">
(function()
{	
  if (window.addEventListener)
  {
    window.addEventListener("load", hide_loading_screen, false);    
  }
  else
  {
    window.attachEvent("onload", hide_loading_screen);
  }
})();

function display_loading_screen()
{
  document.getElementById("loading_screen").style.display = 'block';
}

function hide_loading_screen()
{
  document.getElementById("loading_screen").style.display = 'none';
}

</script>

<style type="text/css">
#loading_screen
{  
  display: none;
  position: absolute;
  left: 0px;
  top: 0px;
  height: 100%;
  width: 100%;
  background-color: black;
  color: white;  
  text-align: center;
  padding-top: 100px;
}
</style>

<!--Loading End -->

<link rel="stylesheet" type="text/css" href="page_style.css" />
<title>Carton Pending Report</title>

<style>


body
{
	font-family: Century Gothic;
	font-size: 12px;
}
table{
	font-size:12px;
}
</style>





</head>
<body>

<!-- Loading begining -->
<div id="loading_screen">
    <h1>Loading...</h1> 
   <h3>Please Wait...</h3> 

</div>

<script type="text/javascript"> 
display_loading_screen();
</script>

<!-- Loading End -->

<?php
echo "<h2>Carton Pending List - Embellishment</h2>";
echo "<table>";
echo "<tr><th>Module</th><th>Style</th><th>Schedule</th><th>Color</th><th>Job</th><th>Carton ID</th><th>Size</th><th>Carton Qty</th><th>Completed on</th><th>Executed Modules</th></tr>";


	
		$sql1="SELECT * FROM emb_garment_carton_pendings ORDER BY ims_schedule";
		//echo $sql1."<br>";
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result1);
		$check=0;
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			echo "<tr class=\"$row_color\">";
			if($check==0)
			{
				echo "<td rowspan=$sql_num_check>$module</td>";
				$check=1;
			}
			
			
			$sql11="SELECT group_concat(distinct ims_mod_no order by ims_mod_no) as \"bac_no\" FROM ims_log_backup where ims_mod_no<>0 and ims_schedule=".$sql_row1['ims_schedule'];
			mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row11=mysqli_fetch_array($sql_result11))
			{
				$modules_list=$sql_row11['bac_no'];	
			}
			
			$sql11="select acutno,color_code from live_pro_table_ref2 where doc_no=".$sql_row1['doc_no'];
			$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row11=mysqli_fetch_array($sql_result11))
			{
				$job=chr($sql_row11['color_code']).leading_zeros($sql_row11['acutno'],3);
			}
			
			echo "<td>$sql_row1[ims_style]</td><td>$sql_row1[ims_schedule]</td><td>$sql_row1[ims_color]</td><td>$job</td><td>$sql_row1[tid]</td><td>$sql_row1[size_code]</td><td>$sql_row1[carton_act_qty]</td><td>$sql_row1[ims_log_date]</td><td>$modules_list</td>";
			echo "</tr>";

		}
		
		if($row_color=="test")
		{
			$row_color="test1";
		}
		else
		{
			$row_color="test";
		}

?>
</body>
</html>
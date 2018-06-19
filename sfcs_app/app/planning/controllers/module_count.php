<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
	
	// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");
	$view_access=user_acl("SFCS_0133",$username,1,$group_id_sfcs); 
?>

<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R'); ?>"></script>
<!-- <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R'); ?>" type="text/css" media="all" /> -->

<!-- <link href="<?= getFullURLLevel($_GET['r'],'common/css/table_style.css',3,'R'); ?>" rel="stylesheet" type="text/css" /> -->
<!-- <?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>	 -->


<div class="panel panel-primary">
<div class="panel-heading">Module Count Update Panel - Style Analysis Report (Balance Sheet)</div>
<div class="panel-body">


<?php
$url=getFullURLLevel($_GET['r'],'get_mod_count.php',0,'N');
echo "<a href=\"$url\"><button class='btn btn-success btn-xm'>Update from LIVE</button></a> <font color=\"WHITE\">|</font> ";
echo "</br>";



 echo "<div class='col-sm-12' style=\"float: left;overflow-x:scroll;max-height:600px;width:parent\"  >";

	echo "<table class='table table-bordered'>";
	echo "<tr><th>User Defined Style</th><th>Mod Count</th><th>Controls</th><th>Style DB</th></tr>";
	$sql="select distinct style_id from $bai_pro2.movex_styles order by mod_count DESC";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$style_id=$sql_row['style_id'];
		$mod_count=0;
		
		$sql2="select max(mod_count) as \"mod_count\" from $bai_pro2.movex_styles where style_id=\"$style_id\" order by style_id ASC";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$mod_count=$sql_row2['mod_count'];
		}
		
		$style_db="";
		
		$sql2="select distinct movex_style from $bai_pro2.movex_styles where style_id=\"$style_id\"";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$style_db=$sql_row2['movex_style'].", ".$style_db;
		}
		$url1=getFullURLLevel($_GET['r'],'editform_2.php',0,'N');
		echo "<tr>";
		echo "<td>$style_id</td>";
		echo "<td>$mod_count</td>";
		echo "<td><a href=\"$url1&style_id=$style_id&mod_count=$mod_count\"><button class='btn btn-success btn-xs'>EDIT</button></a></td>";
		echo "<td>".rtrim($style_db,', ')."</td>";
		echo "</tr>";
	}
	
	echo "</table>";



echo "</div>"; 
?>
</div>
</div>
</div>



<style>
table {
	color:black;
	font-size:12px;
	font-weight:bold;
}
th {
	background-color:#FF0000;
	color:white;
	text-align:center;
}
</style>
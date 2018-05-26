<?php
// include("dbconf2.php");
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");

$view_access=user_acl("SFCS_0136",$username,1,$group_id_sfcs); 
$authorized=user_acl("SFCS_0136",$username,7,$group_id_sfcs);
?>
<?php

	set_time_limit(2000);
?>

			  
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R'); ?>"></script>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R'); ?>" type="text/css" media="all" />

<!-- <link href="<?= getFullURLLevel($_GET['r'],'common/css/table_style.css',3,'R'); ?>" rel="stylesheet" type="text/css" /> -->
<!-- <link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',3,'R'); ?>" rel="stylesheet" type="text/css" /> -->

<div class="panel panel-primary">
<div class="panel-heading">Style Group Settings</div>
<div class="panel-body">

<?php

$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);



echo "<div class='col-sm-12' style=\"float: left;overflow-x:scroll;max-height:600px;width:parent\"  >";
	echo "<table class='table table-bordered'>";
	echo "<tr class='tblheading'><th>Movex Style</th><th>User Defined Style</th><th>Buyer Style</th>";
	
	// if(in_array(strtolower($username),$authorized))
	{
	echo "<th>Controls</th>";
	}
	echo "</tr>";
	$sql="select * from $bai_pro2.movex_styles order by style_id ASC";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$style=$sql_row['movex_style'];
		$style_id=$sql_row['style_id'];
		$mod_count=$sql_row['mod_count'];
		$buyer_id=$sql_row['buyer_id'];
		echo "<tr>";
		echo "<td>$style</td>";
		echo "<td>$style_id</td>";
	    echo "<td>$buyer_id</td>";
		// if(in_array(strtolower($username),$authorized))
		{	
			if($style_id==NULL)
			{
				$url=getFullURL($_GET['r'],'inputform.php','N');
				echo "<td><a href=\"$url&style=$style\"><button class='btn btn-primary btn-xs'>Create</button></a></td>";
			}
			else
			{
				$url=getFullURL($_GET['r'],'editform.php','N');
				echo "<td><a href=\"$url&style=$style&mod_count=$mod_count&buyer_id=$buyer_id\"><button class='btn btn-success btn-xs'>Edit</button></a></td>";
			}
		}
		echo "</tr>";
	}
	
	echo "</table>";
echo "</div>";


?>
</div>
</div>
</div>



	
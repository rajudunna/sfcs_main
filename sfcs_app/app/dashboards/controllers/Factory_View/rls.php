<?php

if(isset($_GET['sec_x']))
{
	$sections_db=array($_GET['sec_x']);
}

for($i=0;$i<sizeof($sections_db);$i++)
{
	$section_id=$sections_db[$i];
	
	$id_new="green";
	$count_rls=0;
	
	$sqlx="select round((sum(rework_qty)/sum(act_out))*100,2) as reworkpnt from $bai_pro.grand_rep where date='".date("Y-m-d")."' and section=$section_id";
	mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_rowx=mysqli_fetch_array($sql_resultx))
	{
		$count_rls=$sql_rowx['reworkpnt'];		
	}
	
	//echo $count_rls."<br/>";
	if($count_rls>2)
	{
		$id_new="red";
		//echo "<td><div id=\"$id_new\"><a href=\"#\"></a></div></td>";
	}
	else
	{
		if($count_rls<=2 and $count_rls>=1)
		{
			$id_new="yellow";
			//echo "<td><div id=\"$id_new\"><a href=\"#\"></a></div></td>";
		}
		else
		{
			$id_new="green";
			//echo "<td><div id=\"$id_new\"><a href=\"#\"></a></div></td>";
		}
	}
	// $url_rls = getFullURLLevel($_GET['r'],'Beta/Reports/rework_dashboard/index.php',2,'N');
	// echo "<td><div id=\"$id_new\"><a href=\"$url_rls&sec_x=$section_id&rand=".rand()."\"></a></div></td>";
	echo "<td><div id=\"$id_new\"><a href=\"http://".$_SERVER['HTTP_HOST']."/sfcs_app/app/dashboards/controllers/Factory_View/section_rls_live.php?sec_x=$section_id&rand=".rand()."\" target='_blank'></a></div></td>";

}
			

?>
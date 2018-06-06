<link rel="stylesheet" href="../../../../common/css/bootstrap.min.css">
<?php
// include("dbconf.php");
include ("../../../../common/config/config.php");
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/user_acl_v1.php");
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/server/user_acl_v1.php',3,'R'));
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/server/group_def.php',3,'R'));
// $view_access=user_acl("SFCS_0202",$username,1,$group_id_sfcs);
?>


<?php
// Start the buffering //
ob_start();
?>		
<div class="container">
	<div class="table-responsive">
		<div class="panel panel-primary">
			 <div class="panel-heading"> Factory Dashboard (LIVE)</div>
				<div class="panel-body">
					<table align="center" class="table table-bordered">

					<?php
					$sections_db=array();

					$sqlx="select sec_id from $bai_pro3.sections_db where sec_id>0";
					$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_rowx=mysqli_fetch_array($sql_resultx))
					{
						$sections_db[]=$sql_rowx['sec_id'];
					}
					//echo "<tr><th colspan=7 valign=\"middle\"><h1><font color=yellow>Factory View</font></h1></th></tr>";
					echo " <thead><tr><th>Performance / Section</th>";
					for($i=0;$i<sizeof($sections_db);$i++)
					{			
						$url=getFullURLLevel($_GET['r'],'Factory_View/plant_dash_board_v2.php',1,'R');			
						echo "<th><a href='$url?sec_x=".$sections_db[$i]."' target='_blank'>".$sections_db[$i]."</a></th>";
					}
					echo "</tr> </thead>";
					?>
							
					<tbody>
							<tr><td class="heading">Plan/RM (IPS)</td><?php include("pps.php"); ?></tr>



							<tr><td class="heading">Work In Progress (IMS)</td><?php include("ims.php"); ?></tr>


							<tr><td class="heading" >Rework (RLS) </td><?php include("rls.php"); ?></tr>

							<tr><td class="heading" >FG Controlling (LMS) </td><?php include("lms.php"); ?></tr>



							<tr><td class="heading" >SAH Generation (LIVE) </td><?php include("live.php"); ?></tr>


							<!--<tr><td class="heading" >Absenteeism (LIVE HR) </td><?php include("live_hr.php"); ?></tr>-->
					</tbody>
					
					</table>
				</div>
			</div>
		</div>
</div>

<?php
// Get the content that is in the buffer and put it in your file //
file_put_contents('factory_kpi.php', ob_get_contents());
?>






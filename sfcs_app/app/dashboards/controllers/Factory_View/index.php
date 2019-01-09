<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    $view_access=user_acl("SFCS_0245",$username,1,$group_id_sfcs);
?>


<?php
// Start the buffering //
ob_start();
$legend=getFullURLLevel($_GET['r'],'factory_view.htm',0,'R');
?>		
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/styles.css',2,'R')?>">
<div class="container">
		<div class="panel panel-primary">
			 <div class="panel-heading"> Factory View for Production KPI <a href='<?php echo $legend; ?>' target="_blank" class='btn btn-success pull-right'>?</a></div>
				<div class="panel-body">
					<div class="table-responsive">
                      <table align="center" class="table table-bordered">
                     <?php
					$sections_db=array();
					$sqlx="SELECT GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` GROUP BY section ORDER BY section + 0";
					$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_rowx=mysqli_fetch_array($sql_resultx))
					{
						$sections_db[]=$sql_rowx['sec_id'];
					}
					//echo "<tr><th colspan=7 valign=\"middle\"><h1><font color=yellow>Factory View</font></h1></th></tr>";
					echo " <thead><tr><th>Performance / Section</th>";
					$basepath = getBASE($_GET['r'])['base'];
					$s = explode('/',$basepath);
					unset($s[count($s)-1]);
					$s1 = implode('/',$s);
					for($i=0;$i<sizeof($sections_db);$i++)
					{
						// getFullURL($_GET['r'],'production_kpi/plant_dash_board_v2.php','N');
						
						echo "<th><a href='".getFullURLLevel($_GET['r'],'factory_view.php',0,'N')."&sec_x=".$sections_db[$i]."' target='_blank'>".$sections_db[$i]."</a></th>";
					}
					echo "</tr> </thead>";
					?>
							
					<tbody>
							<tr><td class="heading">Plan/RM (IPS)</td><?php include("pps.php"); ?></tr>



							<tr><td class="heading">Work In Progress (IMS)</td><?php include("ims.php"); ?></tr>


							<tr><td class="heading" >Rework (RLS) </td><?php include("rls.php"); ?></tr>

							<tr><td class="heading" >FG Controlling (LMS) </td><?php include("lms.php"); ?></tr>



							<tr><td class="heading" >SAH Generation (LIVE) </td><?php include("live.php"); ?></tr>


							<!-- <tr><td class="heading" >Absenteeism (LIVE HR) </td><?php include("live_hr.php") ?></tr> -->
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






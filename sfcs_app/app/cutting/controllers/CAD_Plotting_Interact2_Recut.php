<!--
kirang/2014-05-10/Ticket #100144
create the interface for recut plot job priority.
-->
<?php 
	// include("../dbconf.php"); 
	include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R')); 
?>

<?php
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php"); 
$view_access=user_acl("SFCS_0096",$username,1,$group_id_sfcs);
	//require_once('../phplogin/auth2.php');
	//Ticket # 118925 : Changed displayed widith from type (int) to (float
?>

<style>
th,td { color : #000; }
</style>


<?php
// include("../dbconf.php");
if(isset($_GET['doc_no']))
{
	//$sql="update plandoc_stat_log set lastup=\"".date("Y-m-d")."\" where doc_no=".$_GET['doc_no'];
	//mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	
	echo "<h3>Please prepare marker for below width and confirm.</h3>";
	
	$sql="select mk_ref,cat_ref,allocate_ref from $bai_pro3.recut_v2 where doc_no=".$_GET['doc_no'];
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$mk_ref=$sql_row['mk_ref'];
		$cat_ref=$sql_row['cat_ref'];
		$allocate_ref=$sql_row['allocate_ref'];
	}
	$min_width=0;
	$sql="select roll_width as width from $bai_rm_pj1.fabric_cad_allocation where doc_no=".$_GET['doc_no']."";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1x=mysqli_fetch_array($sql_result))
	{
			
			$system_width=(float)$sql_row1x['width'];
					
			if($min_width==0)
			{
				$min_width=$system_width;
			}		
			else
			{
				if($system_width<$min_width)
				{
					$min_width=$system_width;
				}	
			}
	}
	
	if(mysqli_num_rows($sql_result)==0 or $system_width==NULL)
	{
		echo "<form name='test' method='post' action='index.php?r=".$_GET['r']."'>";
		echo " No Rolls are avilalbe, Please clear from the pending tasks. <input type='submit' name='clear' value='Update'>";
		echo "<input type='hidden' name='doc_ref' value='".$_GET['doc_no']."'>";
		echo "</form>";
	}
	else
	{
		echo "<form name='test' method='post' action='inde.php?r=".$_GET['r']."'>";
		echo "Enter New Length for $min_width width: <input type='text' name='mk_lenght' value=''> <input type='submit' name='submit' value='Update'>";
		echo "<input type='hidden' name='cat_ref' value='$cat_ref'><input type='hidden' name='allocate_ref' value='$allocate_ref'><input type='hidden' name='p_width' value='$min_width'><input type='hidden' name='mk_ref' value='$mk_ref'><input type='hidden' name='doc_ref' value='".$_GET['doc_no']."'>";
		echo "</form>";
		
	}
	
	
	/* echo "<form name='test' method='post' action='".$_SERVER['PHP_SELF']."'>";
	echo "<table>";
	echo "<tr><th>Roll ID</th><th>Roll Width</th><th>Plies</th><th>MK Length</th></tr>";
	$sql="select * from bai_rm_pj1.fabric_cad_allocation where doc_no=".$_GET['doc_no']." and doc_type='normal'";
	$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	while($sql_row=mysql_fetch_array($sql_result))
	{
		echo "<tr>";
		
		
		echo "</tr>";
	}
	echo "</table>";
	echo "</form>"; */
}

if(isset($_POST['submit']))
{
	
	$mk_length=$_POST['mk_length'];
	$mk_ref=$_POST['mk_ref'];
	$doc_ref=$_POST['doc_ref'];
	$p_width=$_POST['p_width'];
	$cat_ref=$_POST['cat_ref'];
	$allocate_ref=$_POST['allocate_ref'];
	
	
	$sql="insert into $bai_pro3.maker_stat_log(DATE,cat_ref,cuttable_ref,allocate_ref,order_tid,mklength,mkeff,lastup,remarks,mk_ver) select DATE,cat_ref,cuttable_ref,allocate_ref,order_tid,mklength,mkeff,lastup,remarks,mk_ver from bai_pro3.maker_stat_log where tid='$mk_ref'";
	mysqli_query($link, $sql) or exit("Sql Error1x".mysqli_error($GLOBALS["___mysqli_ston"]));
	$ilast_id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
	
	$allo_c=array();
	$sql="select cat_patt_ver,style_id,order_tid,p_xs,p_s,p_m,p_l,p_xl,p_xxl,p_xxxl,p_s01,p_s02,p_s03,p_s04,p_s05,p_s06,p_s07,p_s08,p_s09,p_s10,p_s11,p_s12,p_s13,p_s14,p_s15,p_s16,p_s17,p_s18,p_s19,p_s20,p_s21,p_s22,p_s23,p_s24,p_s25,p_s26,p_s27,p_s28,p_s29,p_s30,p_s31,p_s32,p_s33,p_s34,p_s35,p_s36,p_s37,p_s38,p_s39,p_s40,p_s41,p_s42,p_s43,p_s44,p_s45,p_s46,p_s47,p_s48,p_s49,p_s50 from $bai_pro3.order_cat_doc_mk_mix where doc_no=\"".$doc_ref."\"";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$buyer_code=substr($sql_row['order_tid'],0,1);
		$style_code=$sql_row['style_id'];
		
		$allo_c[]="xs=".$sql_row['p_xs'];
		$allo_c[]="s=".$sql_row['p_s'];
		$allo_c[]="m=".$sql_row['p_m'];
		$allo_c[]="l=".$sql_row['p_l'];
		$allo_c[]="xl=".$sql_row['p_xl'];
		$allo_c[]="xxl=".$sql_row['p_xxl'];
		$allo_c[]="xxxl=".$sql_row['p_xxxl'];
		$allo_c[]="s01=".$sql_row['p_s01'];
		$allo_c[]="s02=".$sql_row['p_s02'];
		$allo_c[]="s03=".$sql_row['p_s03'];
		$allo_c[]="s04=".$sql_row['p_s04'];
		$allo_c[]="s05=".$sql_row['p_s05'];
		$allo_c[]="s06=".$sql_row['p_s06'];
		$allo_c[]="s07=".$sql_row['p_s07'];
		$allo_c[]="s08=".$sql_row['p_s08'];
		$allo_c[]="s09=".$sql_row['p_s09'];
		$allo_c[]="s10=".$sql_row['p_s10'];
		$allo_c[]="s11=".$sql_row['p_s11'];
		$allo_c[]="s12=".$sql_row['p_s12'];
		$allo_c[]="s13=".$sql_row['p_s13'];
		$allo_c[]="s14=".$sql_row['p_s14'];
		$allo_c[]="s15=".$sql_row['p_s15'];
		$allo_c[]="s16=".$sql_row['p_s16'];
		$allo_c[]="s17=".$sql_row['p_s17'];
		$allo_c[]="s18=".$sql_row['p_s18'];
		$allo_c[]="s19=".$sql_row['p_s19'];
		$allo_c[]="s20=".$sql_row['p_s20'];
		$allo_c[]="s21=".$sql_row['p_s21'];
		$allo_c[]="s22=".$sql_row['p_s22'];
		$allo_c[]="s23=".$sql_row['p_s23'];
		$allo_c[]="s24=".$sql_row['p_s24'];
		$allo_c[]="s25=".$sql_row['p_s25'];
		$allo_c[]="s26=".$sql_row['p_s26'];
		$allo_c[]="s27=".$sql_row['p_s27'];
		$allo_c[]="s28=".$sql_row['p_s28'];
		$allo_c[]="s29=".$sql_row['p_s29'];
		$allo_c[]="s30=".$sql_row['p_s30'];
		$allo_c[]="s31=".$sql_row['p_s31'];
		$allo_c[]="s32=".$sql_row['p_s32'];
		$allo_c[]="s33=".$sql_row['p_s33'];
		$allo_c[]="s34=".$sql_row['p_s34'];
		$allo_c[]="s35=".$sql_row['p_s35'];
		$allo_c[]="s36=".$sql_row['p_s36'];
		$allo_c[]="s37=".$sql_row['p_s37'];
		$allo_c[]="s38=".$sql_row['p_s38'];
		$allo_c[]="s39=".$sql_row['p_s39'];
		$allo_c[]="s40=".$sql_row['p_s40'];
		$allo_c[]="s41=".$sql_row['p_s41'];
		$allo_c[]="s42=".$sql_row['p_s42'];
		$allo_c[]="s43=".$sql_row['p_s43'];
		$allo_c[]="s44=".$sql_row['p_s44'];
		$allo_c[]="s45=".$sql_row['p_s45'];
		$allo_c[]="s46=".$sql_row['p_s46'];
		$allo_c[]="s47=".$sql_row['p_s47'];
		$allo_c[]="s48=".$sql_row['p_s48'];
		$allo_c[]="s49=".$sql_row['p_s49'];
		$allo_c[]="s50=".$sql_row['p_s50'];
		$pat_ver=$sql_row['cat_patt_ver']; //Taken default category pattern version for marker version
	}
	
	
	//Updating New Marker Refere in Matrix for new marker reference
	$sql="insert ignore into $bai_pro3.marker_ref_matrix(marker_ref_tid) values ('".$ilast_id."-".$p_width."')";
	mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="update $bai_pro3.marker_ref_matrix set marker_ref='$ilast_id', marker_width='".$p_width."', marker_length='".$mk_length."',cat_ref=$cat_ref,allocate_ref=$allocate_ref, style_code='$style_code', buyer_code='$buyer_code',pat_ver='$pat_ver', ".implode(",",$allo_c)." where marker_ref_tid='".$ilast_id."-".$p_width."'";
	mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	//Updating New Marker Refere in Matrix for existing reference (to avoid existing issues)
	$sql="insert ignore into $bai_pro3.marker_ref_matrix(marker_ref_tid) values ('".$mk_ref."-".$p_width."')";
	mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="update $bai_pro3.marker_ref_matrix set marker_ref='$mk_ref', marker_width='".$p_width."', marker_length='".$mk_length."',cat_ref=$cat_ref,allocate_ref=$allocate_ref, style_code='$style_code', buyer_code='$buyer_code',pat_ver='$pat_ver', ".implode(",",$allo_c)." where marker_ref_tid='".$mk_ref."-".$p_width."'";
	mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	
	$sql="update $bai_pro3.maker_stat_log set mklength=$mk_length where tid='$ilast_id'";
	//echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error1x6".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="update $bai_pro3.recut_v2 set lastup=\"".date("Y-m-d")."\", mk_ref=$ilast_id where doc_no=".$doc_ref;
	mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
	
}

if(isset($_POST['clear']))
{
	$sql="update $bai_pro3.recut_v2 set lastup=\"".date("Y-m-d")."\" where doc_no=".$_POST['doc_ref'];
	mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
}
?>

<meta http-equiv="refresh" content="60"> 
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R')); 
?>

<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/actb.js',3,'R');?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/tablefilter.js',3,'R');?>"></script>

<Link rel='alternate' media='print' href=null>
<Script Language=JavaScript>

function setPrintPage(prnThis){

prnDoc = document.getElementsByTagName('link');
prnDoc[0].setAttribute('href', prnThis);
window.print();
}

</Script>
<!--<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />	-->

<?php 
// include("../menu_content.php");
 ?>
<!--<div id="page_heading"><span style="float: left"><h3>Marker Plot Jobs Track Panel</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>-->

<?php
$doc_refs=array();
$date_yest=date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-2, date("Y")));
/*$sql2="select distinct doc_ref as doc_ref from fabric_priorities where date(issued_time)=\"0000-00-00\" or date(issued_time) > \"".$date_yest."\" group by doc_ref_club";
$sql_result2=mysql_query($sql2,$link) or exit("Sql Error".mysql_error());
while($sql_row2=mysql_fetch_array($sql_result2))
{
	$doc_refs[]=$sql_row2["doc_ref"];	
}

*/
$sql1="select acutno,order_tid,print_status,cat_ref,allocate_ref,mk_ref,doc_no, plan_lot_ref,cat_ref,order_tid,p_xs as xs,p_s as s,p_m as m,p_l as l,p_xl as xl,p_xxl as xxl,p_xxxl as xxxl from $bai_pro3.recut_v2 where length(plan_lot_ref)>0 and lastup>\"0000-00-00 00:00:00\" and act_cut_status<>\"DONE\" and fabric_status=5 and print_status>='2014-04-21' and cut_inp_temp is null and remarks in (\"Body\",\"Front\")";	
// echo $sql1;
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error dd".mysqli_error($GLOBALS["___mysqli_ston"]));

echo "<div class=\"panel panel-primary\">
<div class=\"panel-heading\">Marker Plot Jobs Track Panel</div><div class=\"panel-body\">";

echo "<div class='col-sm-12' style='max-height:600px;overflow-x:scroll;overflow-y:scroll'>";
echo "<table id=\"table1\" border=1 class=\"table table-bordered\">";
echo "<tr class='danger'><th>Docket ID</th><th>Buyer Code</th><th>Docket Print Date</th><th>New Width</th><th>Controls</th></tr>";

while($sql_row1=mysqli_fetch_array($sql_result1))
{

	$doc_no=$sql_row1['doc_no'];
	$style_code=substr($sql_row1['order_tid'],0,1);
	$cat_ref=$sql_row1['cat_ref'];
	$marker_ref=$sql_row1['mk_ref'];
	$allocate_ref=$sql_row1['allocate_ref'];
	$cutno=$sql_row1["acutno"];
	$sql="select purwidth,clubbing,category from $bai_pro3.cat_stat_log where tid=$cat_ref";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{		
		$pur_ver_width=$sql_row['purwidth'];
		$clubbing=$sql_row["clubbing"];	
		$category=$sql_row["category"];
	}
	
	$buyer_code=substr($sql_row1['order_tid'],0,1);
	//echo "buyer_code=".$buyer_code."<br/>";
	$print_date=$sql_row1['print_status'];
	//echo "print date=".$print_date."<br/>";
	
	
	$mns_status=$sql_row1['xs']+$sql_row1['s']+$sql_row1['m']+$sql_row1['l']+$sql_row1['xl']+$sql_row1['xxl']+$sql_row1['xxxl'];
	 // echo getFullURLLevel($_GET['r'],'/new_doc_gen/Book3_print_recut.php',1,'N');
	// $path="../../cut_plan_new/new_doc_gen/Book3_print_recut.php?";
	$path=getFullURLLevel($_GET['r'],'Book3_print_recut.php',0,'N');
	 // echo getFullURLLevel($_GET['r'],'new_doc_gen/color_club_docket_print.php',1,'N');
	if($style_code!="P" or $style_code!="K" or $style_code!="L" or $style_code!="O")
	{
		if($mns_status>0)
		{
			// $path="../../cut_plan_new/new_doc_gen/Book3_print_recut.php?";  // For M&S Men Briefs
			$path=getFullURLLevel($_GET['r'],'Book3_print_recut.php',0,'N');
			if($clubbing==1)
			{
				// $path=getFullURLLevel($_GET['r'],'/new_doc_gen/color_club_docket_print.php',1,'N');
				$path=getFullURLLevel($_GET['r'],'color_club_docket_print.php',0,'N')."&cat_title=$category&clubbing=$clubbing&cut_no=$cutno";
			}
		}
		else
		{
			$path= getFullURLLevel($_GET['r'],'Book3_print_recut.php',0,'N');
			// $path="../../cut_plan_new_ms/new_doc_gen/Book3_print_recut.php?"; // FOR M&S Ladies Briefs
			if($clubbing==1)
			{
				// $path="../../cut_plan_new/new_doc_gen/color_club_docket_print.php?cat_title=$category&clubbing=$clubbing&cut_no=$cutno";
				$path=getFullURLLevel($_GET['r'],'color_club_docket_print.php',0,'N')."&cat_title=$category&clubbing=$clubbing&cut_no=$cutno";
			}
		}		
	}
	// $path= getFullURLLevel($_GET['r'],'new_doc_gen/color_club_docket_print.php',1,'N');
	
	$tab= "<tbody><tr><td><a href=\"$path&order_tid=".$sql_row1['order_tid']."&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."&cat_title=$category&clubbing=$clubbing&cut_no=1\" onclick=\"Popup1=window.open('$path&order_tid=".$sql_row1['order_tid']."&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">".$sql_row1['doc_no']."</td>";
	
	$tab.= "<td>$buyer_code</td>";
	$tab.= "<td>$print_date</td>";

//echo "<td>".str_replace(";","<br/>",$sql_row['plan_lot_ref'])."</td>";

//echo "<td><a href=\"cad_plotting_interact.php?doc_no=".$sql_row['doc_no']."\">Completed</td>";

	//$sql="update plandoc_stat_log set lastup=\"".date("Y-m-d")."\" where doc_no=".$_GET['doc_no'];
	//mysql_query($sql,$link) or exit("Sql Error".mysql_error());
		
	$sql="select mk_ref from $bai_pro3.recut_v2 where doc_no=".$doc_no;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$mk_ref=$sql_row['mk_ref'];
	}
	$min_width=0;
	$sql="select roll_width as width from $bai_rm_pj1.fabric_cad_allocation where doc_no=".$doc_no." and doc_type=\"normal\"";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1x=mysqli_fetch_array($sql_result))
	{
			
			$system_width=(float)$sql_row1x['width'];
					
			if($min_width==0)
			{
				$min_width=$system_width;
			}		
			else
			{
				if($system_width<$min_width)
				{
					$min_width=$system_width;
				}	
			}
	}
	// echo $doc_no;
	
	if($_GET['doc_selected']==$doc_no)
	{
		// echo $_GET['doc_selected'];
		//if(mysql_num_rows($sql_result)==0 or $system_width==NULL){
			$rdurl = getFullURL($_GET['r'],'CAD_Plotting_Interact2_Recut.php','N');
	        // echo $rdurl;
			echo $tab;
			echo "<td>N/A</td><td><form name='test' method='POST' action=".$rdurl.">";
			echo " <input type='submit' class=\"btn btn-primary\" name='clear' value='Clear & Update'>";
			echo "<input type='hidden' name='doc_ref' value='".$doc_no."' style='color:red;'>";
			echo "</form></td>";
			
echo "</tr>";
		
	}
	else
	{
		//if(mysql_num_rows($sql_result)==0 or $system_width==NULL)
		{
			echo $tab;
			if($pur_ver_width == $system_width)
			{
				// getFullURL($_GET['r'],'cad_plotting_interact2_Recut','N');
				//echo "<td>N/A</td><td><a href=\"cad_plotting_interact2.php?doc_selected=".$doc_no."\">Edit-".$pur_ver_width."-".$system_width."</a></td>";
				echo "<td>N/A</td><td><a href=".getFullURL($_GET['r'],'CAD_Plotting_Interact2_Recut.php','N')."&doc_selected=".$doc_no.">Edit</a></td>";
			}
			else
			{
				//echo "<td>N/A</td><td style=\"background-color:red;\"><a href=\"cad_plotting_interact2.php?doc_selected=".$doc_no."\">Edit-".$pur_ver_width."-".$system_width."</a></td>";			
				echo "<td>N/A</td><td><a class=\"btn btn-primary\" href=".getFullURL($_GET['r'],'cad_plotting_interact2_Recut.php','N')."&doc_selected=".$doc_no.">Edit</a></td>";
			}
			//echo "<td>N/A</td><td><a href=\"cad_plotting_interact2.php?doc_selected=".$doc_no."\">Edit-".$min_width."-".$system_width."</a></td>";
			
echo "</tr></tobdy>";
		}

	}
}

echo "</table></div>";
?>

	</div><!-- panel body -- >
</div><!-- panel -->
</div>
</div>

<script language="javascript" type="text/javascript">
//<![CDATA[
//var MyTableFilter = {  exact_match: true }

//setFilterGrid( "table1");

var table3Filters = {
		btn: true,
		exact_match: true,
		alternate_rows: true,
		loader: true,
		loader_text: "Filtering data...",
		loader: true,
		btn_reset_text: "Clear",
		display_all_text: "Display all rows",
		btn_text: ">"
	}
	setFilterGrid("table1",table3Filters);


//]]>
</script>
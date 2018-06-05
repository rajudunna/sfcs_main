<?php include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
<?php
include('../'.getFullURLLevel($_GET['r'],'/common/config/user_acl_v1.php',4,'R'));
include('../'.getFullURLLevel($_GET['r'],'/common/php/functions.php',4,'R'));
?>
<script type="text/javascript">
jQuery(document).ready(function($){
   $('#mk_length').keypress(function (e) {
       var regex = new RegExp("^[0-9.\]+$");
       var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
       if (regex.test(str)) {
           return true;
       }
       e.preventDefault();
       return false;
   });
});


</script>




<script type="text/javascript">
function pop_check(){
var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";

for (var i = 0; i < document.input2.lot_no.value.length; i++) {
   if (iChars.indexOf(document.input2.lot_no.value.charAt(i)) != -1) {
      sweetAlert('Please Enter Valid Batch Number','','warning')
       return false;
   }

}
}
</script>

<?php 

if(isset($_GET['doc_no']))
{
	//$sql="update plandoc_stat_log set lastup=\"".date("Y-m-d")."\" where doc_no=".$_GET['doc_no'];
	//mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	
	echo "<h3>Please prepare marker for below width and confirm.</h3>";
	
	$sql="select mk_ref,cat_ref,allocate_ref from $bai_pro3.plandoc_stat_log where doc_no=".$_GET['doc_no'];
	
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
		echo "<form name='test' method='post' action='".getFullURL($_GET['r'],'CAD_Plotting_Interact.php','N')."'>";
		echo " No Rolls are avilalbe, Please clear from the pending tasks. <input type='submit' name='clear' value='Update' class='btn btn-primary btn-sm'>";
		echo "<input type='hidden' name='doc_ref' value='".$_GET['doc_no']."' class='form-control'>";
		echo "</form>";
	}
	else
	{
		echo "<form name='test' method='post' action='".getFullURL($_GET['r'],'CAD_Plotting_Interact.php','N')."' class='form-inline'>";
		echo "<div class='form-group'><label>Enter New Lenght for $min_width width:</label>&nbsp;&nbsp;<input type='text' name='mk_lenght' value=''></div></div> <input type='submit' name='submit' value='Update' class='btn btn-primary btn-sm'>";
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
	if($mk_length == '')
	{
		$flag = 1;
		//$hurl = getFullURLLevel($_GET['r'],'cad_plotting_interact.php',0,'N');
		//header('location:'.$hurl);
	}
	else
	{
		$mk_ref=$_POST['mk_ref'];
	$doc_ref=$_POST['doc_ref'];
	$p_width=$_POST['p_width'];
	$cat_ref=$_POST['cat_ref'];
	$allocate_ref=$_POST['allocate_ref'];
	
	
	$sql="insert into $bai_pro3.maker_stat_log(DATE,cat_ref,cuttable_ref,allocate_ref,order_tid,mklength,mkeff,lastup,remarks,mk_ver) select DATE,cat_ref,cuttable_ref,allocate_ref,order_tid,mklength,mkeff,lastup,remarks,mk_ver from $bai_pro3.maker_stat_log where tid='$mk_ref'";
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
	
	//$sql="update bai_pro3.plandoc_stat_log set lastup=\"".date("Y-m-d")."\", mk_ref=$ilast_id where doc_no=".$doc_ref;
	$sql="update $bai_pro3.plandoc_stat_log set mk_ref=$ilast_id where doc_no=".$doc_ref;
	mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));

		
	}	
}

if(isset($_POST['clear']))
{
	$sql="update $plandoc_stat_log set lastup=\"".date("Y-m-d")."\" where doc_no=".$_POST['doc_ref'];
	mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
}
?>

<!-- <html>
<head>
<meta http-equiv="refresh" content="60">  -->
<?php include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'header_scripts.php',1,'R')); ?>

<!-- <link href="style.css" rel="stylesheet" type="text/css" />

<meta http-equiv="cache-control" content="no-cache">
<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{
	margin:15px; padding:15px; border:1px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:88%;
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	border:1px solid #ccc;
}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; border:2px outset #f4f4f4; margin:2px; }
th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; }

</style> 
<script language="javascript" type="text/javascript" src="<?= getFullURL($_GET['r'],'../../../../common/js/actb.js','R');?>">
<script language="javascript" type="text/javascript" src="<?= getFullURL($_GET['r'],'../../../../common/js/tablefilter.js','R');?>"></script>
-->

<Link rel='alternate' media='print' href=null>
<Script Language=JavaScript>

function setPrintPage(prnThis){

prnDoc = document.getElementsByTagName('link');
prnDoc[0].setAttribute('href', prnThis);
window.print();
}

</Script>
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>	

<?php //include("../menu_content.php"); ?>
<div class="panel panel-primary">
<div class="panel-heading">Marker Plot Jobs Track Panel (Marker Length)</div>
<div class="panel-body">
<?php
$flag;$display; 
if($flag == 1)
{
	$display='block';
	//$sql_message = 'Please Enter Valid Lenght.';
}
else
{
	$display = 'none';
}
?>
<div class="alert alert-danger" style="display:<?php echo $display;?>;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<strong>Info! </strong><span class="sql_message">Please Enter Valid Length.</span>
</div>
<?php

$sql1="select fabric_status,order_tid,print_status,cat_ref,allocate_ref,doc_no, plan_lot_ref,cat_ref,order_tid
      from $bai_pro3.plandoc_stat_log 
       where LENGTH(plan_lot_ref)>0 and lastup='0000-00-00 00:00:00' and act_cut_status<>'DONE'";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
//echo mysqli_num_rows($sql_result1);
echo "<div class='col-sm-12' style='max-height:600px;overflow-x:scroll;overflow-y:scroll'>";
echo "<table id=\"table1\" border=1 class=\"table table-bordered\">";
echo "<tr class='info'><th>Docket ID</th><th>Buyer Code</th><th>Docket Print Date</th><th>New Width</th><th>Controls</th></tr>";
while($sql_row1=mysqli_fetch_array($sql_result1))
{
   // var_dump($sql_row1);
	$doc_no=$sql_row1['doc_no'];
	$style_code=substr($sql_row1['order_tid'],0,1);
	$cat_ref=$sql_row1['cat_ref'];
	$allocate_ref=$sql_row1['allocate_ref'];
	
	$buyer_code=substr($sql_row1['order_tid'],0,1);
	$print_date=$sql_row1['print_status'];
	$fabric_status=$sql_row1['fabric_status'];
	
	$path = getFullURLLevel($_GET['r'],'Book3_print.php',0,'N');
	$tab= "<tr><td><a href=\"$path&order_tid=".$sql_row1['order_tid']."&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."\" onclick=\"Popup1=window.open('$path&order_tid=".$sql_row1['order_tid']."&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\" class=\"btn btn-warning btn-xs\"><i class='fa fa-print'></i>".$sql_row1['doc_no']."</td>";
	
	$tab.= "<td>$buyer_code</td>";
	$tab.= "<td>$print_date</td>";
		
	$sql="select mk_ref,act_cut_status,order_tid,cat_ref from $bai_pro3.plandoc_stat_log where doc_no=".$doc_no;
    //echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    //echo 'test-1 : '.mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$mk_ref=$sql_row['mk_ref'];
		$act_cut_status=$sql_row['act_cut_status'];
		$cat_ref=$sql_row['cat_ref'];
		$order_tid=$sql_row['order_tid'];
	}
	
	$sql="select purwidth,category from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and tid=$cat_ref";
    //echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    //echo 'test-2 : '.mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$purwidth=(float)$sql_row['purwidth'];
		$category=$sql_row['category'];
	}
	
	$min_width=0;
	$sql="select roll_width as width from $bai_rm_pj1.fabric_cad_allocation where doc_no='$doc_no' and doc_type=\"normal\"";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    //echo 'test-3 : '.mysqli_num_rows($sql_result);
	while($sql_row1x=mysqli_fetch_array($sql_result))
	{
		$system_width=(float)$sql_row1x['width'];
		//$min_width=$system_width;		
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
	
	
	
	if($_GET['doc_selected']==$doc_no)
	{
		if(mysqli_num_rows($sql_result)==0 or $system_width==NULL)
		{
			
		}
		else
		{
			echo $tab;
			echo "<td>$min_width</td><td><form name='test' class='form-inline' method='post' action='".getFullURL($_GET['r'],'CAD_Plotting_Interact.php','N')."'>";
			echo "<div class='form-group'><div class='col-md-6'><label>Length: </label>&nbsp;&nbsp;<input type='text' name='mk_length' id='mk_length' value='' size=5 class='form-control' /></div></div><input type='submit' name='submit' value='Update' class='btn btn-primary btn-sm'>";
			echo "<input type='hidden' name='p_width' value='$min_width'><input type='hidden' name='mk_ref' value='$mk_ref'><input type='hidden' name='doc_ref' value='".$doc_no."'><input type='hidden' name='cat_ref' value='".$cat_ref."'><input type='hidden' name='allocate_ref' value='".$allocate_ref."'>";
			echo "</form></td>";
			echo "</tr>";
		}
	}
	else
	{
		if((mysqli_num_rows($sql_result)==0 or $system_width==NULL ))
		{
			echo "</tr>";
		}
		else
		{
			if($min_width!=$purwidth  and $fabric_status==5 and ($category!="Binding Secondary" and $category!="Body Binding" and $category!="Binding" and $category!="Gusset"))
			{
				echo $tab;
				$url = getFullURL($_GET['r'],'cad_plotting_interact.php','N');
				echo "<td>$min_width</td><td><a href=\"$url&doc_selected=".$doc_no."\" class=\"btn btn-success btn-xs\"><i class='fa fa-edit'></i>  Edit</a></td>";			
				echo "</tr>";	
			}
		}
	}
	
	//echo $tab;
	
	

}

echo "</table></div>";
?>

	</div><!-- panel body -- >
</div><!-- panel -->
</div>
</div>
<script language="javascript" type="text/javascript">
// $(document).ready(function() 
// {
// 	//$("#flt2_table1").datepicker();
//    var table3Filters = 
//    {
// 		btn: true,
// 		exact_match: true,
// 		alternate_rows: true,
// 		loader: true,
// 		loader_text: "Filtering data...",
// 		loader: true,
// 		btn_reset_text: "Clear",
// 		display_all_text: "Display all rows",
// 		btn_text: "Submit"
// 	}
// 	setFilterGrid("table1",table3Filters);
	
// 	$('#flt2_table1').on('keypress',function(e){
// 	//alert();
// 	var k = e.which;
// 	console.log(k);
// 	//if( (k < 65 && k > 91) || (k < 96 && k > 123) || (k < 45)){
// 	if((k<58 && k>46) || k==45 || k==13)
// 	{
		
// 	}
// 	else
// 	{
// 			sweetAlert('Alphabets not allowed','','warning');
// 			$('#flt2_table1').val('');
// 	}
	
// 	})
	
// 	})
// 	$('#flt1_table1').on('keypress',function(e){
// 	//alert();
// 	var k = e.which;
// 	console.log(k);
// 	//if( (k < 65 && k > 91) || (k < 96 && k > 123) || (k < 45)){
// 	if((k>64 && k>91) || (k>96 && k<123) || k==13)
// 	{
		
// 	// }
// 	// else
// 	// {
// 	// 	sweetAlert('Alphabets not allowed','','warning');
// 	// 	$('#flt1_table1').val('');
// 	// }
	
// 	// })
	
// })

setFilterGrid("table1");
$('#flt0_table1,#flt3_table1').on('keypress',function(e){
//alert();
	var k = e.which;
	console.log(k);
	if((k<58 && k>46)|| k==13)
	{
		
	}
	else
	{
	    sweetAlert('Only Numbers are Allowed','','warning');
		$('#flt0_table1').val('');
	}
});
$('#flt1_table1,#flt3_table1').on('keypress',function(e){
//alert();
	var k = e.which;
	console.log(k);
	if((k<58 && k>46)|| k==13)
	{
		 sweetAlert('Only Alphabets are Allowed','','warning');
		$('#flt1_table1').val('');
	}
	else
	{
	  
	}
});

$('#flt2_table1').datepicker({dateFormat: 'yy-dd-mm'});
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

$(document).ready(function(){
    $("#flt2_table1").change(function(){
		var date = $("#flt2_table1").val()
		var updated_format =  formatDate(date) ;
		$("#flt2_table1").val(updated_format);
    });
	$("#flt4_table1").hide();
});

</script>

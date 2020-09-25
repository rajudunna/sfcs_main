<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_dashboard.php');
$path="".getFullURLLevel($_GET['r'], "barcode_new.php", "0", "r")."";
$path2="".getFullURLLevel($_GET['r'], "barcode2_1.php", "0", "r")."";

$url_r = $_GET['r'];
$has_permission=haspermission($url_r);
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); ?>

<script>

//<form name="test" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">

function firstbox()
{
	window.location.href ="<?= 'index.php?r='.$_GET['r']; ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))
}

function secondbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))+"&schedule="+document.test.schedule.value;
	window.location.href = uriVal;
}

function thirdbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))+"&schedule="+document.test.schedule.value+"&color="+window.btoa(unescape(encodeURIComponent(document.test.color.value)));
	window.location.href = uriVal;
}
$(document).ready(function() {
	$('#schedule').on('click',function(e){
		var style = $('#style').val();
		if(style == null){
			sweetAlert('Please Select Style','','warning');
		}
	});
	$('#color').on('click',function(e){
		var style = $('#style').val();
		var schedule = $('#schedule').val();
		if(style == null && schedule == null){
			sweetAlert('Please Select Style and Schedule','','warning');
		}
		else if(schedule == null){
			sweetAlert('Please Select Schedule','','warning');
			document.getElementById("submit").disabled = true;
		}
		else {
			document.getElementById("submit").disabled = false;
		}
	});
});

</script>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<?php
	//include("menu_content.php");
	$style=style_decode($_GET['style']);
	$schedule=$_GET['schedule']; 
    $color=color_decode($_GET['color']);
    if(isset($_POST['submit']))
    {
        $style=$_POST['style'];
        $color=$_POST['color'];
        $schedule=$_POST['schedule'];
    }
	else
	{
		$style=style_decode($_GET['style']);
		$schedule=$_GET['schedule']; 
		$color=color_decode($_GET['color']);
	}
?>

<div class = "panel panel-primary">
<div class = "panel-heading">Embellishment Barcode Print</div>
<div class = "panel-body">
<form name="test" action="?r=<?php echo $_GET['r']; ?>" method="post">
<?php
include('dbconf.php');
//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	//$sql="select distinct order_style_no from bai_orders_db where left(order_style_no,1) in (".$global_style_codes.")";	
	$sql="SELECT order_style_no FROM $bai_pro3.emb_bundles AS eb LEFT JOIN $bai_pro3.`plandoc_stat_log` AS pd ON pd.`doc_no`=eb.`doc_no` 
LEFT JOIN $bai_pro3.`bai_orders_db_confirm` AS bd ON pd.`order_tid`=bd.`order_tid` GROUP BY order_style_no";	
//}

$sql_result=mysqli_query($link, $sql) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));

echo "<div class=\"row\"><div class=\"col-sm-3\"><label>Select Style:</label><select class='form-control' name=\"style\"  id=\"style\" onchange=\"firstbox();\" id='style'>";

echo "<option value='' disabled selected>Please Select</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

	if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
	{
		echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
	}

}
echo "  </select>
	</div>";
?>

<?php

echo "<div class='col-sm-3'><label>Select Schedule:</label> 
	  <select class='form-control' name=\"schedule\" id=\"schedule\" onchange=\"secondbox();\" id='schedule'>";

	$sql="SELECT order_del_no FROM $bai_pro3.emb_bundles AS eb LEFT JOIN $bai_pro3.`plandoc_stat_log` AS pd ON pd.`doc_no`=eb.`doc_no` 
LEFT JOIN $bai_pro3.`bai_orders_db_confirm` AS bd ON pd.`order_tid`=bd.`order_tid` where order_style_no='".$style."' GROUP BY order_del_no";	

$sql_result=mysqli_query($link, $sql) or exit("Sql Error--2".mysqli_error($GLOBALS["___mysqli_ston"]));

echo "<option value='' disabled selected>Please Select</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{
	if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule)){
			echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
		}
	else{
		echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
	}
}

echo "	</select>
	 </div>";
?>

<?php

echo "<div class='col-sm-3'><label>Select Color:</label><select class='form-control' name=\"color\" onchange=\"thirdbox();\" id='color'>";

	$sql="select distinct order_col_des from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_joins<'4'";

$sql_result=mysqli_query($link, $sql) or exit("Sql Error--4".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value='' disabled selected>Please Select</option>";
	
while($sql_row=mysqli_fetch_array($sql_result))
{
	if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color)){
		echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
	}else{
		echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
	}
}

echo "</select>
	</div>";

$sql="select order_tid from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des='$color'";
// echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$order_tid=$sql_row['order_tid'];
}



$sql="select mo_status from $bai_pro3.cat_stat_log where order_tid='$order_tid'";
// echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$mo_status=$sql_row['mo_status'];
}

	echo "<div class='col-sm-3' style='padding-top:23px;'>"; 
			
	echo "<input class='btn btn-success' type=\"submit\" value=\"Submit\" name=\"submit\" id='submit'>
		  </div>";	


echo "</div>";
?>

</form>

<hr/>

<?php
if(isset($_POST['submit']))
{

	//include($_SERVER['DOCUMENT_ROOT'].$base_path.'/dbconf.php');
	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	$url1=getFullURL($_GET['r'],'release.php','N');
	//Encoded style and color
	$main_style = style_encode($style);
	$color = color_encode($color);
	
	$sql="select * from $bai_pro3.bai_orders_db_confirm  where order_style_no='".$style."' and order_del_no='".$schedule."' and order_col_des='".$color."'";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql_num_check=mysqli_num_rows($sql_result);
    while($sql_row=mysqli_fetch_array($sql_result))
	{
        $orde_tid=$sql_row['order_tid'];
        for($s=0;$s<sizeof($sizes_code);$s++)
        {
            if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
            {
                $s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
                $s_code[]=$sizes_code[$s];
            }	
        }
    }
    echo "<div class='col-sm-12 table-responsive'><table width='100%' class='table table-bordered info'><thead><tr><th>Cut No</th><th>Docket No</th>";
  
    for($s=0;$s<sizeof($s_tit);$s++)
        {
            echo "<th>".$s_tit[$sizes_code[$s]]."</th>";
            
        }
        echo "<th>Plies</th><th>Emb barcode 4*2</th><th>Emb barcode2*1</th></tr></thead>";
       
       
        $sql="select *,bund.doc_no as docno from $bai_pro3.emb_bundles as bund left join $bai_pro3.order_cat_doc_mk_mix as mix on bund.doc_no=mix.doc_no where order_tid='".$orde_tid."' and category in ($in_categories) group by bund.doc_no";
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        $sql_num_check=mysqli_num_rows($sql_result);
		if($sql_num_check>0)
		{
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$seq=array();
				$sql12="select report_seq from $bai_pro3.emb_bundles where doc_no=".$sql_row['docno']." group by report_seq";
				$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row12=mysqli_fetch_array($sql_result12))
				{
					$seq[]=$sql_row12['report_seq'];
				}
				
				$rowspan=sizeof($seq);
				
				echo "<tr><td rowspan=$rowspan>".chr($sql_row['color_code']).leading_zeros($sql_row['acutno'],3)."</td><td rowspan=$rowspan>".$sql_row['docno']."</td>"; 
				for($s=0;$s<sizeof($s_tit);$s++)
				{
					echo "<td rowspan=$rowspan>".$sql_row["p_s".$sizes_code[$s].""]."</td>";
				}
				echo "<td rowspan=$rowspan>".$sql_row["a_plies"]."</td>";
				for($i=0;$i<sizeof($seq);$i++)
				{
					$get_print_status_qry="select print_status from $bai_pro3.emb_bundles where doc_no=".$sql_row['docno']." and report_seq=".$seq[$i]."";
					$sql_result123=mysqli_query($link, $get_print_status_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row123=mysqli_fetch_array($sql_result123))
					{
						$printstat=$sql_row123['print_status'];
					}
					if($i==0)
					{
						if($printstat==0 || $printstat=='')
						{
							echo "<td><a href=\"$path?doc_no=".$sql_row['docno']."&repseqid=".$seq[$i]."&id=0\" onclick=\"Popup1=window.open('$path?doc_no=".$sql_row['docno']."&repseqid=".$seq[$i]."&id=0','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\" class='btn btn-sm btn-primary'>Print with 4*2 </a></td>";
						
							echo "<td><a href=\"$path2?doc_no=".$sql_row['docno']."&repseqid=".$seq[$i]."&id=0\" onclick=\"Popup1=window.open('$path2?doc_no=".$sql_row['docno']."&repseqid=".$seq[$i]."&id=0','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\" class='btn btn-sm btn-primary'>Print with 2*1</a></td>";			   
							echo "</tr>";
						}
						else
						{
							echo "<td>Print Done</td>";
							echo "<td>Print Done</td>";
							if(in_array($authorized,$has_permission))
							{
								echo "<td><a href='$url1&doc_no=".$sql_row['docno']."&repseqid=".$seq[$i]."&style=".$main_style."&schedule=".$schedule."&color=".$main_color."' class='btn btn-danger btn-xs'>Release</a></td>";		
							}
							echo "</tr>";						
						}
													
						
					}
					else
					{
						echo "<tr>";
						if($printstat==0 || $printstat=='')
						{
						echo "<td><a href=\"$path?doc_no=".$sql_row['docno']."&repseqid=".$seq[$i]."&id=0\" onclick=\"Popup1=window.open('$path?doc_no=".$sql_row['docno']."&repseqid=".$seq[$i]."&id=0','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\" class='btn btn-sm btn-primary'>Print with 4*2</a></td>";
						
						echo "<td><a href=\"$path2?doc_no=".$sql_row['docno']."&repseqid=".$seq[$i]."&id=0\" onclick=\"Popup1=window.open('$path2?doc_no=".$sql_row['docno']."&repseqid=".$seq[$i]."&id=0','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\" class='btn btn-sm btn-primary'>Print with 2*1</a></td>";
						}
						else
						{
							echo "<td>Print Done</td>";
							echo "<td>Print Done</td>";
							if(in_array($authorized,$has_permission))
							{
								echo "<td><a href='$url1&doc_no=".$sql_row['docno']."&repseqid=".$seq[$i]."&style=".$main_style."&schedule=".$schedule."&color=".$main_color."' class='btn btn-danger btn-xs'>Release</a></td>";	
							}
							echo "</tr>";						
						}						
						echo "</tr>";
					}
				}
				
				
				
				
				unset($seq);
			}
		}
	
	echo "</table></div>";
	
}
if(isset($_GET['style']) && isset($_GET['schedule']) && isset($_GET['color']))
{

	//include($_SERVER['DOCUMENT_ROOT'].$base_path.'/dbconf.php');
	$style=style_decode($_GET['style']);
	$color=color_decode($_GET['color']);
	$schedule=$_GET['schedule'];
	$url1=getFullURL($_GET['r'],'release.php','N');
	//Encoded style and color
	$main_style = style_encode($style);
	$color = color_encode($color);
	
	$sql="select * from $bai_pro3.bai_orders_db_confirm  where order_style_no='".$style."' and order_del_no='".$schedule."' and order_col_des='".$color."'";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql_num_check=mysqli_num_rows($sql_result);
    while($sql_row=mysqli_fetch_array($sql_result))
	{
        $orde_tid=$sql_row['order_tid'];
        for($s=0;$s<sizeof($sizes_code);$s++)
        {
            if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
            {
                $s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
                $s_code[]=$sizes_code[$s];
            }	
        }
    }
    echo "<div class='col-sm-12 table-responsive'><table width='100%' class='table table-bordered info'><thead><tr><th>Cut No</th><th>Docket No</th>";
  
    for($s=0;$s<sizeof($s_tit);$s++)
        {
            echo "<th>".$s_tit[$sizes_code[$s]]."</th>";
            
        }
        echo "<th>Plies</th><th>Emb barcode 4*2</th><th>Emb barcode2*1</th></tr></thead>";
       
       
        $sql="select *,bund.doc_no as docno from $bai_pro3.emb_bundles as bund left join $bai_pro3.order_cat_doc_mk_mix as mix on bund.doc_no=mix.doc_no where order_tid='".$orde_tid."' and category in ($in_categories) group by bund.doc_no";
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        $sql_num_check=mysqli_num_rows($sql_result);
		if($sql_num_check>0)
		{
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$seq=array();
				$sql12="select report_seq from $bai_pro3.emb_bundles where doc_no=".$sql_row['docno']." group by report_seq";
				$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row12=mysqli_fetch_array($sql_result12))
				{
					$seq[]=$sql_row12['report_seq'];
				}
				
				$rowspan=sizeof($seq);
				
				echo "<tr><td rowspan=$rowspan>".chr($sql_row['color_code']).leading_zeros($sql_row['acutno'],3)."</td><td rowspan=$rowspan>".$sql_row['docno']."</td>"; 
				for($s=0;$s<sizeof($s_tit);$s++)
				{
					echo "<td rowspan=$rowspan>".$sql_row["p_s".$sizes_code[$s].""]."</td>";
				}
				echo "<td rowspan=$rowspan>".$sql_row["a_plies"]."</td>";
				for($i=0;$i<sizeof($seq);$i++)
				{
					$get_print_status_qry="select print_status from $bai_pro3.emb_bundles where doc_no=".$sql_row['docno']." and report_seq=".$seq[$i]."";
					$sql_result123=mysqli_query($link, $get_print_status_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row123=mysqli_fetch_array($sql_result123))
					{
						$printstat=$sql_row123['print_status'];
					}
					if($i==0)
					{
						if($printstat==0 || $printstat=='')
						{
							echo "<td><a href=\"$path?doc_no=".$sql_row['docno']."&repseqid=".$seq[$i]."&id=0\" onclick=\"Popup1=window.open('$path?doc_no=".$sql_row['docno']."&repseqid=".$seq[$i]."&id=0','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\" class='btn btn-sm btn-primary'>Print with 4*2 </a></td>";
						
							echo "<td><a href=\"$path2?doc_no=".$sql_row['docno']."&repseqid=".$seq[$i]."&id=0\" onclick=\"Popup1=window.open('$path2?doc_no=".$sql_row['docno']."&repseqid=".$seq[$i]."&id=0','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\" class='btn btn-sm btn-primary'>Print with 2*1</a></td>";			   
							echo "</tr>";
						}
						else
						{
							echo "<td>Print Done</td>";
							echo "<td>Print Done</td>";
							if(in_array($authorized,$has_permission))
							{
								echo "<td><a href='$url1&doc_no=".$sql_row['docno']."&repseqid=".$seq[$i]."&style=".$main_style."&schedule=".$schedule."&color=".$main_color."' class='btn btn-danger btn-xs'>Release</a></td>";		
							}
							echo "</tr>";						
						}
													
						
					}
					else
					{
						echo "<tr>";
						if($printstat==0 || $printstat=='')
						{
						echo "<td><a href=\"$path?doc_no=".$sql_row['docno']."&repseqid=".$seq[$i]."&id=0\" onclick=\"Popup1=window.open('$path?doc_no=".$sql_row['docno']."&repseqid=".$seq[$i]."&id=0','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\" class='btn btn-sm btn-primary'>Print with 4*2</a></td>";
						
						echo "<td><a href=\"$path2?doc_no=".$sql_row['docno']."&repseqid=".$seq[$i]."&id=0\" onclick=\"Popup1=window.open('$path2?doc_no=".$sql_row['docno']."&repseqid=".$seq[$i]."&id=0','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\" class='btn btn-sm btn-primary'>Print with 2*1</a></td>";
						}
						else
						{
							echo "<td>Print Done</td>";
							echo "<td>Print Done</td>";
							if(in_array($authorized,$has_permission))
							{
								echo "<td><a href='$url1&doc_no=".$sql_row['docno']."&repseqid=".$seq[$i]."&style=".$main_style."&schedule=".$schedule."&color=".$main_color."' class='btn btn-danger btn-xs'>Release</a></td>";	
							}
							echo "</tr>";						
						}						
						echo "</tr>";
					}
				}
				
				
				
				
				unset($seq);
			}
		}
	
	echo "</table></div>";
	
}
	
   ?> 
   </div>
   </div>
   </div>
   </div>
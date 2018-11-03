<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));?> 
<?php  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R')); 	  
$view_access=user_acl("SFCS_0092",$username,1,$group_id_sfcs); 
?> 
<?php 
// include("header_scripts.php");  
?> 

<script> 

function firstbox() 
{ 
    window.location.href ="<?= getFullURLLevel($_GET['r'],'schedule_mix_bek.php',0,'N'); ?>&style="+document.test.style.value 
} 

</script> 
<!--<link href="style.css" rel="stylesheet" type="text/css" /> -->
<?php 
// echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?> 
 

<SCRIPT> 

function SetAllCheckBoxes(FormName, FieldName, CheckValue) 
{ 
    if(!document.forms[FormName]) 
        return; 
    var objCheckBoxes = document.forms[FormName].elements[FieldName]; 
    if(!objCheckBoxes) 
        return; 
    var countCheckBoxes = objCheckBoxes.length; 
    if(!countCheckBoxes) 
        objCheckBoxes.checked = CheckValue; 
    else 
        // set the check value for all check boxes 
        for(var i = 0; i < countCheckBoxes; i++) 
            objCheckBoxes[i].checked = CheckValue; 
} 

	function fill_up()
	{
	
		var sourceid=document.getElementById('sourceid').value;
		var source=document.getElementById('source').value;
		if(sourceid=='' || source=='')
		{
			sweetAlert('Please Fill The Mandatory Fields','','warning');
			return false;
		}
		else
		{
			return true;
		}

	}
function check_all()
{
	var style=document.getElementById('style').value;
	var sch=document.getElementById('schedule').value;
	//var color=document.getElementById('color').value;
	if(style=='NIL' || sch=='NIL')
	{
		sweetAlert('Please Select Schedule','','warning');
		return false;
	}
	else
	{
		return true;
	}
}
function check_sch()
{
	var style=document.getElementById('style').value;
	if(style=='NIL' )
	{
		sweetAlert('Please Select Style First','','warning');
		return false;
	}
	else
	{
		return true;
	}

}
function check_sch_sty()
{
	var style=document.getElementById('style').value;
	var sch=document.getElementById('schedule').value;
	if(style=='NIL' )
	{
		sweetAlert('Please Enter Style First','','warning');
		return false;
	}
	else if(sch=='NIL')
	{
		sweetAlert('Please Enter Schedule ','','warning');
		return false;
	}
	else
	{
		return true;
	}
	

}
</SCRIPT> 
</head> 

<body> 
<div class="panel panel-primary">
<div class="panel-heading">Schedule Clubbing Panel - Ratio Pack</div>
<div class="panel-body">
<div>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/menu_content.php',4,'R')); ?>
<?php 
error_reporting(E_ERROR | E_PARSE);

$style=$_GET['style']; 
$schedule=$_GET['schedule'];  
//$color=$_GET['color']; 
//$po=$_GET['po']; 

if(isset($_POST['submit'])) 
{ 
    $style=$_POST['style']; 
    $schedule=$_POST['schedule'];  
   // $color=$_POST['color']; 
    //$po=$_POST['po']; 
} 

//echo $style.$schedule.$color; 
?> 
<!--<div id="page_heading"><span style="float"><h3>Schedule Mix Panel (PO Level)</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div> -->

<form name="test" action="#" method="post"> 
<?php 

echo "<div class=\"row\"><div class=\"col-sm-3\"><label>Select Style: </label><select name=\"style\" id=\"style\" class=\"form-control\" onchange=\"firstbox();\" >"; 

$sql="select distinct order_style_no from $bai_pro3.bai_orders_db"; 

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
$sql_num_check=mysqli_num_rows($sql_result); 

echo "<option value=\"NIL\" selected>Select</option>"; 
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

echo "</select></div>"; 
?> 

<?php 

echo "<div class=\"col-sm-3\"><label>Select Schedule: </label><select name=\"schedule\" id=\"schedule\" class=\"form-control\" onchange=\"thirdbox();\" >"; 
$sql="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style\""; 

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
$sql_num_check=mysqli_num_rows($sql_result); 

echo "<option value=\"NIL\" selected>Select</option>"; 
     
while($sql_row=mysqli_fetch_array($sql_result)) 
{ 

if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule)) 
{ 
    echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>"; 
} 
else 
{ 
    echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>"; 
} 

} 


echo "</select></div></br>"; 

// echo "</select>"; 

    echo "<div class=\"col-sm-3\"><input type=\"submit\" class=\"btn btn-primary\" value=\"submit\" name=\"submit\" onclick='return check_all();'></div>";     
?> 

</div></br>
</form> 


<?php 
if(isset($_POST['submit'])) 
{ 
    $style=$_POST['style']; 
    $schedule=$_POST['schedule']; 
    
    if ($style=='NIL' or $schedule=='NIL') 
	{
        echo "Please Fill All Details";
    } 
	else 
	{
        $exfact=$_POST['schedule']; 
        $style_input=$_POST['style']; 
      
        $size_array=array(); 
        $orginal_size_array=array(); 
        for($q=0;$q<sizeof($sizes_array);$q++) 
        { 
            $sql6="select order_del_no,sum(order_s_".$sizes_array[$q].") as order_qty,title_size_".$sizes_array[$q]." as size from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" group by order_col_des order by order_col_des*1"; 
            $result6=mysqli_query($link, $sql6) or die("Error3 = ".$sql6.mysqli_error($GLOBALS["___mysqli_ston"])); 
			//echo $sql6."<br>";
            while($row6=mysqli_fetch_array($result6)) 
            {     
                if($row6["order_qty"] > 0) 
                { 
                    if(!in_array($sizes_array[$q],$size_array)) 
                    { 
                        $size_array[]=$sizes_array[$q]; 
					}     
                    if(!in_array($row6["size"],$orginal_size_array)) 
                    { 
                        $orginal_size_array[]=$row6["size"]; 
                    } 
                } 
            } 
        } 
        sort(array_unique($orginal_size_array));
		sort(array_unique($size_array));
		if(sizeof($orginal_size_array)<>sizeof($size_array))
		{
			for($qq=0;$qq<sizeof($sizes_array);$qq++)
			{
				if(sizeof($orginal_size_array)<>sizeof($size_array))
				{
					if(!in_array($sizes_array[$qq],$size_array))
					{
						$size_array[]=$sizes_array[$qq];
					}
				}
			}	
		}
		$unique_orginal_sizes=implode(",",$orginal_size_array);
		$unique_sizes=implode(",",$size_array); 
        $unique_orginal_sizes_explode=explode(",",$unique_orginal_sizes); 
        $unique_sizes_explode=explode(",",$unique_sizes); 
       
	    $size_type=1; 
        echo '<form name="testnew" action="#" method="post">'; 
        if(sizeof($unique_sizes_explode)>0) 
        { 
            echo "<table class=\"table table-bordered\">"; 
            echo "<tr>"; 
            echo "<th>Select</th>"; 
            echo "<th>Style</th>"; 
            echo "<th>Schedule</th>"; 
            echo "<th>Color</th>"; 
            for($q=0;$q<sizeof($unique_orginal_sizes_explode);$q++) 
			{ 
				echo "<th>".$unique_orginal_sizes_explode[$q]."</th>"; 
			}     
            echo "<th>Total</th>"; 
            echo "</tr>"; 
			
            $sql="select * from $bai_pro3.bai_orders_db where order_joins not in (1,2) and order_style_no=\"$style\" and order_del_no=\"$schedule\" order by order_col_des"; 
			//echo $sql."<br>";
            $test_count=0; 
            $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_row=mysqli_fetch_array($sql_result)) 
            { 
                for($s=0;$s<sizeof($sizes_code);$s++)
				{
					$o_s[$sizes_code[$s]]=$sql_row["order_s_s".$sizes_code[$s].""];
				}
				$order_total=0;
                $order_total=array_sum($o_s); 
				unset($o_s);
				//echo $order_total."----<br>";
				
                $schedule=$sql_row['order_del_no']; 
                $color=$sql_row['order_col_des']; 
				$sql4="delete FROM $bai_pro3.`orders_club_schedule` where order_del_no=".$schedule." and order_col_des='".$color."'"; 
                $result4=mysqli_query($link, $sql4) or die("Error3 = ".$sql4.mysqli_error($GLOBALS["___mysqli_ston"])); 				
                $order_tid=$sql_row['order_tid']; 
                $schedule_array[]=$schedule; 
                $col_arry[]=$color; 
                $style=$sql_row['order_style_no']; 
                $order_joins=$sql_row['order_joins']; 
                echo "<tr>"; 
                if($order_total>0) 
                { 
                    $sql41="select * FROM $bai_pro3.`plandoc_stat_log` where order_tid='".$order_tid."'"; 
                    $result41=mysqli_query($link, $sql41) or die("Error3 = ".$sql4.mysqli_error($GLOBALS["___mysqli_ston"])); 
                    if(mysqli_num_rows($result41)==0) 
                    { 
                        if($order_joins=="0") 
                        { 
                            echo "<td><input type=\"checkbox\" name=\"col[]\" value=\"$color\" checked></td>"; 
                            $test_count=$test_count+1; 
                        } 
                        else 
                        { 
                            echo "<td>Color-".$order_joins."</td>"; 
                        } 
                    } 
                    else 
                    { 
					   	echo "<td>Lay Plan Prepared</td>";
					} 
                } 
                else 
                { 
                    echo "<td></td>"; 
                } 
				$order_joins=0;
                echo "<td>$style</td>"; 
                echo "<td>$schedule</td>"; 
                echo "<td>$color</td>"; 
				$row_ref=array(); 
				//echo sizeof($unique_orginal_sizes_explode)."<br>";
				for($q1=0;$q1<sizeof($unique_orginal_sizes_explode);$q1++) 
				{    
					$size_code_or=$unique_orginal_sizes_explode[$q1]; 
					$in=0;
					for($q2=0;$q2<sizeof($unique_sizes_explode);$q2++) 
					{ 
						$sql61="select sum(order_s_".$unique_sizes_explode[$q2].") as order_qty,title_size_".$unique_sizes_explode[$q2]." as size,destination from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_col_des=\"$color\" and order_del_no=\"".$schedule."\"";     
						$result61=mysqli_query($link, $sql61) or die("Error3 = ".$sql61.mysqli_error($GLOBALS["___mysqli_ston"])); 
						while($row61=mysqli_fetch_array($result61)) 
						{     
							$size_code=$row61["size"]; 
							$size_code_ref_val=$unique_sizes_explode[$q2]; 
							$destination=$row61["destination"];							
							if($size_code == $size_code_or) 
							{ 
								$in=1;
								echo "<td>".$row61["order_qty"]."</td>"; 
								//if($row61["order_qty"] > 0) 
								//{ 
									$row_ref[]=$row61["order_qty"].""; 
								//}
								//else
								//{
								//	$row_ref[]=0; 	
								//}									
							}     
						}                                         
					}
					if($in==0)
					{
						echo "<td>0</td>"; 
						$row_ref[]=0;
					}						
				} 
				$sql3="insert into $bai_pro3.orders_club_schedule(order_del_no,order_col_des,destination,size_code,orginal_size_code,order_qty) values(\"".$schedule."\",\"".$color."\",\"".$destination."\",\"".$unique_orginal_sizes."\",\"".$unique_sizes."\",\"".implode(",",$row_ref)."\")"; 
                //echo $sql3."<br>"; 
                mysqli_query($link, $sql3) or die("Error3 = ".$sql3.mysqli_error($GLOBALS["___mysqli_ston"])); 
                echo "<td>$order_total</td>"; 
                echo "</tr>"; 
            } 
            echo "</table>"; 
			echo '<input type="hidden" name="style" value="'.$style.'">'; 
            echo '<input type="hidden" name="schedules" value="'.$schedule.'">'; 
            echo '<input type="hidden" name="exfact" value="'.$exfact.'">'; 
            echo '<input type="hidden" name="po" value="'.$po.'">'; 
			//echo "Test";	
            echo "<br>"; 
            echo "<br>"; 
                     
            $sql452="select * from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$schedule."\" and order_joins in (1,2)";
            $sql_result452=mysqli_query($link, $sql452) or die("Error".$sql452.mysqli_error($GLOBALS["___mysqli_ston"])); 
            if(mysqli_num_rows($sql_result452)>0) 
            { 
			    echo "<h3>Clubbed Schedule Details</h3>"; 
			    while($sql_row452=mysqli_fetch_array($sql_result452)) 
                { 
                    echo "<table class=\"table table-bordered\"><tr><th>Style </th><th>Schedule No</th><th>New Color</th><th> Original Colours</th>"; 
                    for($kl=0;$kl<sizeof($sizes_array);$kl++) 
                    { 
                        if($sql_row452["title_size_".$sizes_array[$kl].""]<>'') 
                        { 
                            $sizes_code_tmp[]=$sizes_array[$kl]; 
                            echo "<th>".$sql_row452["title_size_".$sizes_array[$kl].""]."</th>"; 
                        }             
                    } 
                    echo "</tr>"; 
					$order_joinss=substr($sql_row452["order_col_des"],-1);
                    echo "<tr><td>".$sql_row452["order_style_no"]."</td><td>".$sql_row452["order_del_no"]."</td><td>".$sql_row452["order_col_des"]."</td>"; 
                    $sql453="select order_col_des as org_col  from $bai_pro3.bai_orders_db_confirm where order_joins='".$order_joinss."' and order_del_no=\"".$schedule."\""; 
					//echo $sql453."<br>";
					$old_colors = array();
                    $sql_result453=mysqli_query($link, $sql453) or die("Error6.7".$sql452.mysqli_error($GLOBALS["___mysqli_ston"])); 
                    while($sql_row453=mysqli_fetch_array($sql_result453)) 
                    {    
                    	$old_colors[] = $sql_row453["org_col"];
                    }
                    echo '<td>';
                    for ($i=0; $i < sizeof($old_colors); $i++) { 
                    	echo $old_colors[$i].'<br>';
                    }
                    echo "</td>"; 
                     
                    for($kll=0;$kll<sizeof($sizes_code_tmp);$kll++) 
                    { 
                        echo "<td>".$sql_row452["order_s_".$sizes_code_tmp[$kll].""]."</td>"; 
					} 
                    unset($sizes_code_tmp); 
                    echo "</tr>"; 
                    echo "</table>"; 
                    echo "<br>"; 
                } 
            } 
            if($test_count>=1) 
            { 
                echo "<input type=\"submit\" class='btn btn-success' value=\"Confirm\" name=\"fix\"  id=\"confirm\" onclick=\"document.getElementById('confirm').style.display='none'; document.getElementById('msg1').style.display='';\"/>"; 
                echo "<span id=\"msg1\" style=\"display:none;\"><h5>Please Wait data is processing...!<h5></span>"; 
            }             
            echo '</form>'; 
			
        } 
        else 
        { 
            echo "<h3>Still Order quantity not updated</h3>"; 
        }
		
    }   
	
} 
?> 

<?php 

if(isset($_POST['fix'])) 
{ 
    $selected=$_POST['col']; 
	$schedule=$_POST['schedules'];
	$style=$_POST['style'];
	
    $size_array1=array(); 
    $orginal_size_array1=array(); 
    $schedule_array=array(); 
	$schedule_array=explode(",",implode(",",$selected));
	$sql62="select * from $bai_pro3.orders_club_schedule where order_del_no=\"$schedule\" and order_col_des in (".implode(",",$selected).") limit 1";
	$result62=mysqli_query($link, $sql62) or die("Error3 = ".$sql62.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row62=mysqli_fetch_array($result62))
	{				
		$unique_orginal_sizes1=$row62["size_code"];
		$unique_sizes1=$row62["orginal_size_code"];
	}
	$unique_orginal_sizes_explode1=explode(",",$unique_orginal_sizes1);
	$unique_sizes_explode1=explode(",",$unique_sizes1);
    if(sizeof($selected)>1) 
    { 
		$sql23="select max(order_joins) as maxorder from $bai_pro3.bai_orders_db where order_del_no=\"$schedule\" "; 
        $sql_result23=mysqli_query($link, $sql23) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_row23=mysqli_fetch_array($sql_result23)) 
        { 
            $maxorder=$sql_row23['maxorder']; 
        }
		if($maxorder==0)
		{
			$maxorder=4;		
		}
		else
		{
			$maxorder=$maxorder+1;			
		}
        
		$sql19="delete from $bai_pro3.bai_orders_db_club where order_col_des in ('".implode("','",$selected)."') and order_del_no=\"$schedule\"";
        mysqli_query($link, $sql19) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"])); 
			
		$sql19="insert ignore into $bai_pro3.bai_orders_db_club select * from bai_orders_db where order_col_des in ('".implode("','",$selected)."') and order_del_no=\"$schedule\"";
        mysqli_query($link, $sql19) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"])); 
		
        $cols="Color-".$maxorder.""; 
        // $sql="select * from cat_stat_log where order_tid='".$order_tid."'"; 
        //echo $sql."<br><br>"; 
        // $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        // if(mysqli_num_rows($sql_result)>0) 
        // { 
            $sql1="insert ignore into $bai_pro3.bai_orders_db_confirm select * from $bai_pro3.bai_orders_db where order_col_des in ('".implode("','",$selected)."') and order_del_no=\"$schedule\"";
			mysqli_query($link, $sql1) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"])); 
			 
			$sql17="SELECT order_tid,COUNT(*) AS cnt FROM $bai_pro3.cat_stat_log WHERE order_tid IN (SELECT order_tid FROM bai_orders_db WHERE order_col_des IN 
			('".implode("','",$selected)."') AND order_del_no='$schedule') GROUP BY order_tid ORDER BY cnt DESC LIMIT 1"; 
			$sql_result17=mysqli_query($link, $sql17) or exit("Sql Error C".mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($sql_row17=mysqli_fetch_array($sql_result17)) 
			{ 
				$order_tid=$sql_row17['order_tid'];
				$sql11="SELECT * from $bai_pro3.bai_orders_db where order_tid='$order_tid'"; 
				//echo $sql."<br><br>"; 
				$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error B".mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($sql_row11=mysqli_fetch_array($sql_result11)) 
				{ 
					$order_col_dess=$sql_row11['order_col_des'];
					$new_color_code=$sql_row11['color_code'];
				}
			}
			$sql="select * from $bai_pro3.cat_stat_log where order_tid='".$order_tid."'"; 
			// echo $sql."<br><br>"; 
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error A".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result)) 
			{ 
				//echo $tid."<br>"; 
				$tid=str_replace($order_col_dess,$cols,$sql_row['order_tid']); 
				$tid2=str_replace($order_col_dess,$cols,$sql_row['order_tid2']); 
				$com_no=$sql_row['compo_no']; 
				$sql1="insert ignore into $bai_pro3.cat_stat_log (order_tid,order_tid2,catyy,fab_des,col_des,mo_status,compo_no) values (\"".$tid."\",\"".$tid2."\",".$sql_row['catyy'].",\"".$sql_row['fab_des']."\",\"".$sql_row['col_des']."\",\"Y\",\"$com_no\")"; 
				mysqli_query($link, $sql1) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));         
			} 
		if(mysqli_num_rows($sql_result)>0) 
        {
			$sql1="insert ignore into $bai_pro3.bai_orders_db(order_tid,order_date,order_upload_date,order_last_mod_date,order_last_upload_date,order_div,order_style_no,order_del_no,order_col_des,order_col_code,order_cat_stat,order_cut_stat,order_ratio_stat,order_cad_stat,order_stat,Order_remarks,order_po_no,order_no,color_code,order_joins,packing_method,style_id,carton_id,carton_print_status,ft_status,st_status,pt_status,trim_cards,trim_status,fsp_time_line,fsp_last_up,order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f,order_embl_g,order_embl_h,destination,zfeature,co_no) select \"".$style.$schedule.$cols."\",order_date,order_upload_date,order_last_mod_date,order_last_upload_date,order_div,order_style_no,order_del_no,'$cols',order_col_code,order_cat_stat,order_cut_stat,order_ratio_stat,order_cad_stat,order_stat,Order_remarks,order_po_no,order_no,$new_color_code,1,packing_method,style_id,carton_id,carton_print_status,ft_status,st_status,pt_status,trim_cards,trim_status,fsp_time_line,fsp_last_up,order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f,order_embl_g,order_embl_h,destination,zfeature,co_no from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\""; 
            //echo $sql1."<br><br>"; 
            mysqli_query($link, $sql1) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"])); 
             
            $sql1="update $bai_pro3.bai_orders_db set order_joins='J".$maxorder."' where order_col_des in ('".implode("','",$selected)."') and order_del_no=\"$schedule\""; 
            mysqli_query($link, $sql1) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"])); 
            //echo "<br>1-1=".$sql1."<br><br>"; 
            
            $sql1="insert ignore into $bai_pro3.bai_orders_db_confirm(order_tid,order_date,order_upload_date,order_last_mod_date,order_last_upload_date,order_div,order_style_no,order_del_no,order_col_des,order_col_code,order_cat_stat,order_cut_stat,order_ratio_stat,order_cad_stat,order_stat,Order_remarks,order_po_no,order_no,color_code,order_joins,packing_method,style_id,carton_id,carton_print_status,ft_status,st_status,pt_status,trim_cards,trim_status,fsp_time_line,fsp_last_up,order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f,order_embl_g,order_embl_h,destination,zfeature,co_no) select \"".$style.$schedule.$cols."\",order_date,order_upload_date,order_last_mod_date,order_last_upload_date,order_div,order_style_no,order_del_no,'$cols',order_col_code,order_cat_stat,order_cut_stat,order_ratio_stat,order_cad_stat,order_stat,Order_remarks,order_po_no,order_no,$new_color_code,1,packing_method,style_id,carton_id,carton_print_status,ft_status,st_status,pt_status,trim_cards,trim_status,fsp_time_line,fsp_last_up,order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f,order_embl_g,order_embl_h,destination,zfeature,co_no from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\""; 
            mysqli_query($link, $sql1) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"])); 
            //echo "2=".$sql1."<br><br>"; 
         
            $sql1="update $bai_pro3.bai_orders_db_confirm set order_joins='J".$maxorder."' where order_col_des in ('".implode("','",$selected)."') and order_del_no=\"$schedule\""; 
            mysqli_query($link, $sql1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"])); 
            //echo "<br>2-1=".$sql1."<br><br>"; 
           
            for($q11=0;$q11<sizeof($unique_orginal_sizes_explode1);$q11++) 
            {     
				$size_code_or1=$unique_orginal_sizes_explode1[$q11]; 
                for($q21=0;$q21<sizeof($unique_sizes_explode1);$q21++) 
                { 
                    
					//echo $unique_orginal_sizes_explode1[$q11]."----".$unique_sizes_explode1[$q21]."<br>";
					$sql611="select sum(order_s_".$unique_sizes_explode1[$q21].") as order_qty,title_size_".$unique_sizes_explode1[$q21]." as size, order_del_no,order_col_des from $bai_pro3.bai_orders_db where order_col_des in ('".implode("','",$selected)."') and order_del_no=\"$schedule\" group by order_col_des";     
                   // echo "<br>Query".$q11."-".$q21."=".$sql611."<br>"; 
                    $result611=mysqli_query($link, $sql611) or die("Error3 = ".$sql611.mysqli_error($GLOBALS["___mysqli_ston"])); 
                    while($row611=mysqli_fetch_array($result611)) 
                    {     
                        //echo $row611["order_col_des"]."---".$unique_sizes_explode1[$q21]."<br>";
						$size_code1=$row611["size"]; 
                        if($size_code1 == $size_code_or1) 
                        { 
                            $sql12="update $bai_pro3.bai_orders_db set order_s_".$unique_sizes_explode1[$q11]."=order_s_".$unique_sizes_explode1[$q11]."+".$row611["order_qty"].",old_order_s_".$unique_sizes_explode1[$q11]."=old_order_s_".$unique_sizes_explode1[$q11]."+".$row611["order_qty"].",title_size_".$unique_sizes_explode1[$q11]."=\"".$unique_orginal_sizes_explode1[$q11]."\",title_flag=1  where order_col_des='$cols' and order_del_no='$schedule'"; 
                            mysqli_query($link, $sql12) or die("Error112 = ".$sql12.mysqli_error($GLOBALS["___mysqli_ston"])); 
                            //echo "<br>S-1=".$sql12."<br>";     
                            $sql121="update $bai_pro3.bai_orders_db_confirm set order_s_".$unique_sizes_explode1[$q11]."=order_s_".$unique_sizes_explode1[$q11]."+".$row611["order_qty"].",old_order_s_".$unique_sizes_explode1[$q11]."=old_order_s_".$unique_sizes_explode1[$q11]."+".$row611["order_qty"].",title_size_".$unique_sizes_explode1[$q11]."=\"".$unique_orginal_sizes_explode1[$q11]."\",title_flag=1  where order_col_des='$cols' and order_del_no='$schedule'"; 
                            mysqli_query($link, $sql121) or die("Error112 = ".$sql121.mysqli_error($GLOBALS["___mysqli_ston"])); 
                            //echo "<br>S-2=".$sql121."<br>";                                 
                            // $sql123="update bai_orders_db_confirm set order_s_".$unique_sizes_explode1[$q11]."=".$row611["order_qty"].",old_order_s_".$unique_sizes_explode1[$q11]."=".$row611["order_qty"].",title_size_".$unique_sizes_explode1[$q11]."=\"".$unique_orginal_sizes_explode1[$q11]."\",title_flag=1  where order_del_no=".$row611["order_del_no"]." and order_col_des='".$row611["order_col_des"]."'"; 
							//echo "<br>S-3=".$sql123."<br>"; 
                            // mysqli_query($link, $sql123) or die("Error123 = ".$sql123.mysqli_error($GLOBALS["___mysqli_ston"]));  
							// $sql1234="update bai_orders_db set order_s_".$unique_sizes_explode1[$q11]."=".$row611["order_qty"].",old_order_s_".$unique_sizes_explode1[$q11]."=".$row611["order_qty"].",title_size_".$unique_sizes_explode1[$q11]."=\"".$unique_orginal_sizes_explode1[$q11]."\",title_flag=1  where order_del_no=".$row611["order_del_no"]." and order_col_des='".$row611["order_col_des"]."'"; 
                            // mysqli_query($link, $sql1234) or die("Error123 = ".$sql123.mysqli_error($GLOBALS["___mysqli_ston"]));
                            // echo "<br>S-3=".$sql1234."<br>"; 
                            $falg1=1; 
                        }     
                    }                                         
                } 
                 
            } 
			// echo "<table class='table table-bordered'><tr><th>Style	</th><th>Schedule No</th><th>New Colour</th></tr>"; 
			// echo "<tr><td>".$style."</td><td>".$schedule."</td><td>".$cols."</td></tr></table>";
            // echo "<h2>Style: $style</h2>"; 
            // echo "<h2>Schedule: $schedule</h2>"; 
            // echo "<h2>New Colour: $cols</h2>"; 
			echo "<script type=\"text/javascript\"> 
						sweetAlert('Clubbing Successfully Done','','success');
					</script>";	
            // echo "<h2>Successfully Completed.</h2>";     
             
            $sql451="select * from $bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."' and order_col_des=\"".$cols."\""; 
            $sql_result451=mysqli_query($link, $sql451) or die("Error963".$sql451.mysqli_error($GLOBALS["___mysqli_ston"])); 
            if(mysqli_num_rows($sql_result451)>0) 
            { 
                while($sql_row451=mysqli_fetch_array($sql_result451)) 
                { 
                    echo "<table class='table table-bordered'><tr><th>Style	</th><th>Schedule No</th><th>New Colour</th><th>Original Colours</th>"; 
                    for($kk=0;$kk<sizeof($sizes_array);$kk++) 
                    { 
                        if($sql_row451["title_size_".$sizes_array[$kk].""]<>'') 
                        { 
                            $sizes_code_tmp[]=$sizes_array[$kk]; 
                            echo "<th>".$sql_row451["title_size_".$sizes_array[$kk].""]."</th>"; 
                        }             
                    } 
                    echo "</tr>"; 
                    $old_colors1 = array();
                    echo "<tr><td>".$sql_row451["order_style_no"]."</td><td>".$sql_row451["order_del_no"]."</td><td>".$sql_row451["order_col_des"]."</td>"; 
                    $sql457="select order_col_des as order_col from $bai_pro3.bai_orders_db_confirm where order_joins='J".$maxorder."' and order_col_des in ('".implode("','",$selected)."')"; 
                    $sql_result457=mysqli_query($link, $sql457) or die("Error47".$sql457.mysqli_error($GLOBALS["___mysqli_ston"])); 
                    while($sql_row457=mysqli_fetch_array($sql_result457)) 
                    {      
                    	$old_colors1[] = $sql_row457["order_col"];   
                        // echo "<td>".$sql_row457["order_col"]."</td>"; 
                    }
                    echo '<td>';
                    for ($i=0; $i < sizeof($old_colors1); $i++) { 
                    	echo $old_colors1[$i].'<br>';
                    }
                    echo "</td>"; 
                    for($kkk=0;$kkk<sizeof($sizes_code_tmp);$kkk++) 
                    { 
                        echo "<td>".$sql_row451["order_s_".$sizes_code_tmp[$kkk].""]."</td>"; 
                    } 
					echo "</tr>"; 
                    echo "</table>"; 
                    echo "<br>"; 
                } 
            } 
             
        }                                                                                                 
        else 
        { 
            // echo "<h2>Please upload order status for selected schedules.</h2>";
            echo "<script type=\"text/javascript\"> 
                        sweetAlert('Please upload order status for selected schedules.','','error');
                    </script>"; 
        }

        $sql45="select * from $bai_pro3.orders_club_schedule where order_col_des in ('".implode("','",$selected)."') and order_del_no=\"$schedule\""; 
        //echo $sql45."<br>"; 
        $sql_result45=mysqli_query($link, $sql45) or die("Error14".$sql45.mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_row45=mysqli_fetch_array($sql_result45)) 
        { 
            $order_del_no_ref=$sql_row45["order_del_no"]; 
            $size_code_ref=$sql_row45["size_code"]; 
            $original_size_code_ref=$sql_row45["orginal_size_code"]; 
            $order_col_des_ref=$sql_row45["order_col_des"]; 
            $destination_ref=$sql_row45["destination"]; 
            $order_qty_ref=$sql_row45["order_qty"]; 
             
            $original_size_code_ref_explode=explode(",",$original_size_code_ref); 
            $order_qty_ref_explode=explode(",",$order_qty_ref); 
            $size_code_ref_explode=explode(",",$size_code_ref); 
             
            for($i1=0;$i1<sizeof($original_size_code_ref_explode);$i1++) 
            { 
                //echo $original_size_code_ref_explode[$i1]."<br>"; 
                $sql46="update $bai_pro3.bai_orders_db set order_s_".$original_size_code_ref_explode[$i1]."='".$order_qty_ref_explode[$i1]."',old_order_s_".$original_size_code_ref_explode[$i1]."='".$order_qty_ref_explode[$i1]."',title_size_".$original_size_code_ref_explode[$i1]."=\"".$size_code_ref_explode[$i1]."\" where order_del_no=\"".$order_del_no_ref."\" and order_col_des=\"".$order_col_des_ref."\" and destination=\"".$destination_ref."\""; 
                //echo $sql46."<br>"; 
                mysqli_query($link, $sql46) or die("Error1111".$sql46.mysqli_error($GLOBALS["___mysqli_ston"])); 
                 
                $sql47="update $bai_pro3.bai_orders_db_confirm set order_s_".$original_size_code_ref_explode[$i1]."='".$order_qty_ref_explode[$i1]."',old_order_s_".$original_size_code_ref_explode[$i1]."='".$order_qty_ref_explode[$i1]."',title_size_".$original_size_code_ref_explode[$i1]."=\"".$size_code_ref_explode[$i1]."\" where order_del_no=\"".$order_del_no_ref."\" and order_col_des=\"".$order_col_des_ref."\" and destination=\"".$destination_ref."\""; 
                //echo $sql47."<br>"; 
               mysqli_query($link, $sql47) or die("Error11".$sql47.mysqli_error($GLOBALS["___mysqli_ston"])); 
            } 
             
        } 
    } 
    else 
    { 
        // echo "Please select more than one schedule for clubbing."; 
        echo "<script type=\"text/javascript\"> 
                        sweetAlert('You cannot proceed Schedule Clubbing with One Colour.','','warning');
                    </script>"; 
    }      
     
} 

?>
</div></div></div>
 </body>


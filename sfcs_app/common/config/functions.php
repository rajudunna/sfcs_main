<?php
function echo_title($table_name,$field,$compare,$key,$link)
{
	//GLOBAL $menu_table_name;
	//GLOBAL $link;
	$sql="select $field as result from $table_name where $compare='$key'";
	// echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit($sql."Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		return $sql_row['result'];
	}
	((mysqli_free_result($sql_result) || (is_object($sql_result) && (get_class($sql_result) == "mysqli_result"))) ? true : false);
}

function get_sewing_job_prefix($field,$prefix_table,$pack_summ_input,$schedule,$color,$sewing_job_no,$link)
{
	$sql="SELECT $field as result FROM $prefix_table WHERE type_of_sewing IN (SELECT DISTINCT type_of_sewing FROM $pack_summ_input WHERE order_del_no='$schedule' AND input_job_no='$sewing_job_no')";
	//echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit($sql."Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$prefix = $sql_row['result'];
	}
	if ($prefix == '')
	{
		$prefix='J';
	}
	if ($field == 'prefix') {
		return $prefix.leading_zeros($sewing_job_no,3);
	} else {
		return $prefix;
	}
	((mysqli_free_result($sql_result) || (is_object($sql_result) && (get_class($sql_result) == "mysqli_result"))) ? true : false);
}

function echo_title_1($table_name,$field,$compare,$key,$link)
{
	//GLOBAL $menu_table_name;
	//GLOBAL $link;
	$sql="select $field as result from $table_name where $compare in ($key)";
	//echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit($sql."Sql Error-echo_2<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		return $sql_row['result'];
	}
	((mysqli_free_result($sql_result) || (is_object($sql_result) && (get_class($sql_result) == "mysqli_result"))) ? true : false);
}

function leading_zeros($value, $places)
{
	$leading='';
	if(is_numeric($value))
	{
	    for($x = 1; $x <= $places; $x++)
	    {
	        $ceiling = pow(10, $x);
	        if($value < $ceiling)
	        {
	            $zeros = $places - $x;
	            for($y = 1; $y <= $zeros; $y++)
	            {
	                $leading .= "0";
	            }
	        $x = $places + 1;
	        }
	    }
	    $output = $leading . $value;
	}
	else{
	    $output = $value;
	}
	return $output;
}

function ims_sizes($order_tid,$ims_schedule,$ims_style,$ims_color,$ims_size2,$link)
{
	include('config.php');
	$ims = substr($ims_size2,1);

	if($ims>=01 && $ims<=50)
	{
		
		if($order_tid=='')
		{
			$sql23="select title_size_$ims_size2 as size_val,title_flag from $bai_pro3.bai_orders_db_confirm where order_style_no='$ims_style' and order_del_no='$ims_schedule' and order_col_des='$ims_color'";
		}
		else
		{
			$sql23="select title_size_$ims_size2 as size_val,title_flag from $bai_pro3.bai_orders_db_confirm where order_tid='$order_tid'";
		}
		//echo $sql23."<br>";
		$sql_result=mysqli_query($link, $sql23) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
				$size_val=$sql_row['size_val'];
				$flag = $sql_row['title_flag'];
	    }
			
		if($flag==1)
		{	
			return $size_val;
		}
		else
		{
			return $ims_size2;
		}		
	}
	else
	{
		return $ims_size2;
	}
					
}


function get_percentage ( $total, $analized )
{
		$check= @round ( $analized / ( $total / 100 ),2);
		if($check>=100)
		{
			return "<font color=GREEN>".$check . "%"."</font>";
		}
		else
		{
			return "<font color=RED>".$check . "%"."</font>";
		}
}


function stat_check($x_stat)
{

	if($x_stat != "Completed")
	{
		return "<font color=RED>PENDING</font>";
	}
	else
	{
		return "<font color=GREEN>COMPLETED</font>";
	}
}

function get_stat($x, $y)
{

	if($y>=$x)
	{
		return "<font color=GREEN>COMPLETED</font>";
	}
	else
	{
		return "<font color=RED>PENDING</font>";
	}
}

function stat_check2($x_stat)
{

	if($x_stat != "Completed")
	{
		return "<font color=RED>PENDING</font>";
	}
	else
	{
		return "<font color=GREEN>CONFIRM</font>";
	}
}

function div_by_zero($arg)
{
	$arg1=1;
	if($arg==0 or $arg=='0' or $arg=='')
	{
		$arg1=1;
	}
	else
	{
		$arg1=$arg;
	}
	return $arg1;
}

function partial_cut_color($doc_no,$link)
{
	
	// start for partial Cutting 
	$sql12="select p_plies,a_plies from bai_pro3.plandoc_stat_log where doc_no in('$doc_no')";
	$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".$sql12.mysqli_error($GLOBALS["___mysqli_ston"]));
	$input_count=mysqli_num_rows($sql_result12);
	while($sql_row11=mysqli_fetch_array($sql_result12))
	{
		$p_plies=$sql_row11['p_plies'];
		$a_plies=$sql_row11['a_plies'];
	}
	//echo "<br/>actual plies= ".$p_plies;
	//echo "cutting Plies=".$a_plies;
	
	$avil_plies= $p_plies - $a_plies;
	// echo "availabale plies =".$avil_plies; 
	if($avil_plies > 0)
	{
		$id="orange";
	} 
		
	// for input qty	
		
	$sql2="SELECT (p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies as qty FROM plandoc_stat_log WHERE doc_no=$doc_no";	
	$result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row2=mysqli_fetch_array($result2))
	{
		$cutting_total=$row2["qty"];
	}

	if($cutting_total>0 )
	{
		
		//KIRANG added ims_mod_no>=0
		$sql13="select sum(ims_qty)as sum_ims_qty from bai_pro3.ims_log where ims_doc_no in('$doc_no') and ims_mod_no>0";
		$sql_result13=mysqli_query($link, $sql13) or exit("Sql Error".$sql13.mysqli_error($GLOBALS["___mysqli_ston"]));
		$input_count=mysqli_num_rows($sql_result13);
		while($sql_row13=mysqli_fetch_array($sql_result13))
		{
			$ims_qty=$sql_row13['sum_ims_qty'];
		}
		
		$sql14="select sum(ims_qty)as sum_ims_bac_qty from bai_pro3.ims_log_backup where ims_doc_no in('$doc_no') and ims_mod_no>0";
		$sql_result14=mysqli_query($link, $sql14) or exit("Sql Error".$sql13.mysqli_error($GLOBALS["___mysqli_ston"]));
		$input_count=mysqli_num_rows($sql_result14);
		while($sql_row14=mysqli_fetch_array($sql_result14))
		{
			$ims_bac_qty=$sql_row14['sum_ims_bac_qty'];
		}
		
		$total_input_qty=$ims_qty+$ims_bac_qty;
		
		if( ($cutting_total - $total_input_qty > 0 ) && $total_input_qty>0 )
		{
			$id="orange";
		}
	}		
	return $id;	
			
	// close for partial cutting
}

function check_style($string)
{
	$check=0;
	for ($index=0;$index<strlen($string);$index++) {
    	if(isNumber($string[$index]))
		{
			$nums .= $string[$index];
		}
     	else    
		{
			$chars .= $string[$index];
			$check=$check+1;
			if($check==2)
			{
				break;
			}
		}
       		
			
	}
	//echo "Chars: -$chars-<br>Nums: -$nums-";
	return $nums;
}

function isNumber($c) {
    return preg_match('/[0-9]/', $c);
}

echo "<script language=\"javascript\" type=\"text/javascript\">
        function popitup(url) {
            newwindow=window.open(url,"."'"."name"."'".",'"."scrollbars=1,menubar=1,resizable=1,location=0,toolbar=0"."'".");
            if (window.focus) {newwindow.focus()}
            return false;
        }
        function popitup2(url) {
            newwindow=window.open(url,"."'"."name"."'".",'"."scrollbars=1,menubar=1,resizable=1,location=0,toolbar=0"."'".");
            if (window.focus) {newwindow.focus()}
            return false;
        }
    </script>";
?>
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

function ims_sizes($order_tid,$ims_schedule,$ims_style,$ims_color,$ims_size2,$link11)
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
		$sql_result=mysqli_query($link11, $sql23) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
				$size_val=$sql_row['size_val'];
				$flag = $sql_row['title_flag'];
	    }
			
		if($flag==1){
			return $size_val;
		}else{
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
?>


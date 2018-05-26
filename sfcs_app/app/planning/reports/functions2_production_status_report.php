<?php

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

function leading_zeros($value, $places){
// Function written by Marcus L. Griswold (vujsa)
// Can be found at http://www.handyphp.com
// Do not remove this header!

    if(is_numeric($value)){
        for($x = 1; $x <= $places; $x++){
            $ceiling = pow(10, $x);
            if($value < $ceiling){
                $zeros = $places - $x;
                for($y = 1; $y <= $zeros; $y++){
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
?>
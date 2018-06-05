<?php
//Mail Functions include
include("mail_functions_sch.php");

//PF Numbers
function show_pf_number($pf_no){
	return leading_zeros($pf_no,7);
}

//Count number of occurance of element in array
function array_count_values_of($value, $array) {
    $counts = array_count_values($array);
    return $counts[$value];
}

//To check minimum date
function min_val($x,$y){
	if($x=="0000-00-00" and $y=="0000-00-00"){
		return "0000-00-00";
	} 
	else {
		if($x!="0000-00-00" and $x<$y){
			return $x;
		}
		else {
			if($y!="0000-00-00" and $y<$x){
				return $y;
			}
			else
			{
				return $x;
			}
		}
	}
}

function echo_title($table_name,$field,$compare,$key,$link)
{
	$sql="select $field as result from $table_name where $compare='$key'";
	//echo "<br>".$sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error-echo_1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		return $sql_row['result'];
	}
	((mysqli_free_result($sql_result) || (is_object($sql_result) && (get_class($sql_result) == "mysqli_result"))) ? true : false);
}

function echo_title_test($table_name,$field,$compare,$key,$link)
{
	$sql="select $field as result from $table_name where $compare='$key'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error-echo-test".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		return $sql_row['result'];
	}
	((mysqli_free_result($sql_result) || (is_object($sql_result) && (get_class($sql_result) == "mysqli_result"))) ? true : false);
}


function echo_title2($table_name,$field,$compare,$key,$link)
{
	$sql="select $field as result from $table_name where $compare in ('$key')";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error-echo-2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		return $sql_row['result'];
	}
	((mysqli_free_result($sql_result) || (is_object($sql_result) && (get_class($sql_result) == "mysqli_result"))) ? true : false);
}

function echo_title3($table_name,$field,$compare,$link)
{
	$sql="select $field as result from $table_name where $compare";
	//echo $sql;
	global $username;
	if($username=="kirang"){
	//echo $sql;	
	}
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error echo-3".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		return $sql_row['result'];
	}
	((mysqli_free_result($sql_result) || (is_object($sql_result) && (get_class($sql_result) == "mysqli_result"))) ? true : false);
}

//Leave Register Update function
function update_leave_register($tran_id,$ld_open_balance,$ld_carried,$ld_utilized,$ld_adjusted,$link,$multiplier)
{
	$db_code=date("y").date("y");
	$month_code=date("m");
	$sql="insert ignore into bai_hr_tna_em_$db_code.leave_balance_register(tran_id) values ('$tran_id')";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_affected_rows($link)>0)
	{
		$sql="update bai_hr_tna_em_$db_code.leave_balance_register,bai_hr_database.emp_leave_balances_log
		set leave_balance_register.w_pid_ref=emp_leave_balances_log.w_pid_ref,
		leave_balance_register.emp_id_ref=emp_leave_balances_log.emp_id_ref,
		leave_balance_register.leave_type=emp_leave_balances_log.leave_type
		where emp_leave_balances_log.tran_id='$tran_id' and leave_balance_register.tran_id='$tran_id'";
		//echo $sql;
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	$sql="update bai_hr_tna_em_$db_code.leave_balance_register set
	open_balance=open_balance+".($ld_open_balance*$multiplier).",
	carried_$month_code=carried_$month_code+".($ld_carried*$multiplier).",
	utilized_$month_code=utilized_$month_code+".($ld_utilized*$multiplier).",
	adjusted_$month_code=adjusted_$month_code+".($ld_adjusted*$multiplier)."
	where tran_id='$tran_id'";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}

//To extract date between two given dates
function getDaysInBetween($start, $end) {
 // Vars
 $day = 86400; // Day in seconds
 $format = 'Y-m-d'; // Output format (see PHP date funciton)
 $sTime = strtotime($start); // Start as time
 $eTime = strtotime($end); // End as time
 $numDays = round(($eTime - $sTime) / $day) + 1;
 $days = array();

 // Get days
 for ($d = 0; $d < $numDays; $d++) {
  $days[] = date($format, ($sTime + ($d * $day)));
 }

 // Return days
 return $days;
} 

//To leading zeros
function leading_zeros($value, $places){
// Function written by Marcus L. Griswold (vujsa)
// Can be found at http://www.handyphp.com
// Do not remove this header!
	$leading="";
    if(is_numeric($value)){
		$value=ltrim($value,'0');
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

//To find time days difference between two dates

function dateDiff($start, $end) {

$start_ts = strtotime($start);

$end_ts = strtotime($end);

$diff = $end_ts - $start_ts;

return round($diff / 86400);

}

function findexts ($filename) 
 { 
 $filename = strtolower($filename) ; 
 $exts = split("[/\\.]", $filename) ; 
 $n = count($exts)-1; 
 $exts = $exts[$n]; 
 return $exts; 
 }
 
 
 //To return skill results
 function skill_table_addon($key,$link)
 {
	$skills=array();
	$skills['A']=0;
	$skills['B']=0;
	$skills['C']=0;
	
	$sql="select sum(if(test_criteria='A',1,0)) as 'A', sum(if(test_criteria='B',1,0)) as 'B', sum(if(test_criteria='C',1,0)) as 'C' from emp_skill_test_track left join test_reference on emp_skill_test_track.test_pid_ref=test_reference.test_pid where w_pid_ref='$key'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$skills['A']=($sql_row['A']>0?$sql_row['A']:"");
		$skills['B']=($sql_row['B']>0?$sql_row['B']:"");
		$skills['C']=($sql_row['C']>0?$sql_row['C']:"");
	}
	return $skills;
	((mysqli_free_result($sql_result) || (is_object($sql_result) && (get_class($sql_result) == "mysqli_result"))) ? true : false);
 }
 
 //To mask attendance codes as per user requirements
 function attn_code_mast($code){
 	switch($code){
		case 'px':{
			return 'a';
			break;
		}
		case 'x':{
			return 'p';
			break;
		}
		
		case 'PE':{
			return 'EW';
			break;
		}
		
		default:{
			return $code;
		}
	}
 }

?>
 
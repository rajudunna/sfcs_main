
<?php
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
include($include_path.'\sfcs_app\common\config\m3_api_call.php');

$obj1 = new get_api_call();	
$url="http://eka-mvxsod-01.brandixlk.org:22105/m3api-rest/execute/PMS100MI/SelOperations?CONO=200&FACI=Q01&MFNO=7512409&PRNO=M05083AB%20%20%200190";
$result = $obj1->getCurlRequest($url);	
$decoded = json_decode($result,true);

// var_dump($decoded);
$selected_arr = ['OPDS','MFNO','PLG1','PITI','OPNO','MAQT','SCQT'];
$name_values = array_column($decoded['MIRecord'], 'NameValue');
foreach ($name_values as $key => $value) 
{
    foreach ($value as $key1 => $value1) 
    {
        if(in_array($value1['Name'] , $selected_arr)) {
            $all_data_array[$value1['Name']][] = $value1['Value'];
        }
    }
}

echo "<br>";
echo "<br>";

echo "<br>";


foreach($all_data_array as $key => $value){
    $test[$key]=implode(",",$all_data_array[$key]);
    $test1[$key]=$all_data_array[$key];
}


 var_dump($test1);
 echo "</br>";
      $req_fields = ['MAQT','SCQT'];
      //$sql="select ".implode(",",$req_fields)." from mo_operation_quantites where op_code in(". $test["OPNO"].") and mo_no in (". $test["MFNO"].")";
	  $sql="select good_quantity as MAQT,rejected_quantity as SCQT from mo_operation_quantites where op_code in(". $test["OPNO"].") and mo_no in (". $test["MFNO"].")";
      echo $sql."<br>";
            $result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($row=mysqli_fetch_array($result))
            {
                //$result_value=$row;
				foreach($req_fields as $key => $value)
				    $new_array[$value][] = $row[$value];
            }
			var_dump($new_array);
			foreach($test1 as $key=>$value){
				$arr1 = [];
				$arr2 = [];
				if($key == 'MAQT' || $key == 'SCQT'){
			    foreach($value as $key1=>$value1){
					//echo $key.' = '.$value1.'<br/>';
					$arr1[] = $value1;
				}
				foreach($new_array[$key] as $key2 => $value2){
				    //echo $key.' Raj = '.$value2.'<br/>';
					$arr2[] = $value2;
				}
				$common1[$key] = array_diff($arr1,$arr2);
				$common2[$key] = array_diff($arr2,$arr1);
				}
			}
			
			echo "<br>";
            var_dump($arr2);		
			echo "<br>";
			echo "<table>";
			foreach($common1 as $key3=>$value3){
				echo "<tr><td>$key3</td><td>";
				foreach($value3 as $key4 => $value4){
					echo "$value4 | ";
				}
				echo "</td></tr>";
				echo "</table>";
			}
			echo "<table>";
			echo "<br/>";
			foreach($common2 as $key5=>$value5){
				echo "<tr><td>$key5</td><td>";
				foreach($value5 as $key6 => $value6){
					echo "$value6 | ";
				}
				var_dump($value6);
				echo "</td></tr>";
				echo "</table>";
			}
			
			
		
			
           

?>
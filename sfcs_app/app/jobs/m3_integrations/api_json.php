
<?php
error_reporting(0);
$host = "192.168.0.110:3326"; 
$user = "baiall"; 
$pass = "baiall"; 
$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $pass)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link,'bai_pro3') or die("Error in selecting the database:");
$service_url = 'http://localhost:81/sfcs_app/app/jobs/integrations/json_m3.php';
$curl = curl_init($service_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$curl_response = curl_exec($curl);
if ($curl_response === false) {
    $info = curl_getinfo($curl);
    curl_close($curl);
    die('error occured during curl exec. Additioanl info: ' . var_export($info));
}
// var_dump($curl_response);
// die();
curl_close($curl);
$decoded = json_decode(($curl_response),true);
// var_dump($decoded);
//$selected_arr = ['OPDS', 'MFNO', 'PLG1' , 'PITI' , 'OPNO' , 'MAQT', 'SCQT'];
$selected_arr = [ 'MFNO'  , 'OPNO' , 'MAQT', 'SCQT'];
foreach ($decoded as $key => $value) {
    foreach ($value['NameValue'] as $key1 => $value1) {
        if(in_array($value1['Name'] , $selected_arr)) 
        {
            $name[$value1['Name']][$key]= $value1['Value'];
 
        }

    }

}

foreach($name as $key => $value)
{
    $test[$key]=implode(",",$name[$key]);
    $test1[$key]=$name[$key];

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
<?php
	$start_timestamp = microtime(true);
	error_reporting(0);
    $include_path=getenv('config_job_path');
	include($include_path.'\sfcs_app\common\config\config_jobs.php');
	include($include_path.'\sfcs_app\common\config\rest_api_calls.php');
    $details=[];
    $arr1 = [];
    $arr2 = [];
    $cono='200';
    $faci='EKG';
    $selected_arr = ['OPDS','MFNO','PLG1','PITI','OPNO','MAQT','SCQT'];
    $date = date('Y-m-d');
    $sql_mo="SELECT  mo_no,product_sku FROM $bai_pro3.mo_details  where mo_no in (select distinct mo_no from $bai_pro3.m3_transactions where DATE(date_time)='$date') group by mo_no,product_sku";
    // echo $sql_mo;
    $result_mo=mysqli_query($link, $sql_mo) or exit("Sql Error mo".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row_mo=mysqli_fetch_array($result_mo))
    {
        $mo_nos[]=$row_mo['mo_no'];
        $pr_nos[]=$row_mo['product_sku'];
    }
    // $mo_nos = ['7512409','1991686','1991678'];
    // $pr_nos = ['M05083AB%20%20%200190','ASL18SF8%20%20%200026','ACZ06SF8%20%20%200006'];
    foreach($mo_nos as $key=>$monos)
    {
        $start = microtime(true);
        $obj1 = new get_api_call(); 
        $url="http://eka-mvxsod-01.brandixlk.org:22105/m3api-rest/execute/PMS100MI/SelOperations?CONO=".$cono."&FACI=".$faci."&MFNO=".trim($monos)."&PRNO=".trim($pr_nos[$key]);
        $url1 = str_replace(' ', '%20', $url);
        // echo $url1."<br>";
        $end = microtime(true);
        $dur = $end - $start;
        print("API call Execution takes ".$dur." seconds")."\n";
        $result = $obj1->getCurlAuthRequest($url1);  
        $decoded = json_decode($result,true);
        // var_dump($decoded);
        if($decoded['@type'])
        {
		    continue;
		}
        $name_values = array_column($decoded['MIRecord'], 'NameValue');
        foreach ($name_values as $key => $value) 
        {
            foreach ($value as $key1 => $value1) 
            {
				if(in_array($value1['Name'] , $selected_arr)) 
				{
                    $kk = trim($value1['Name']);
                    $all_data_array[$kk][] = trim($value1['Value']);
                }
            }
        }
        foreach($all_data_array as $key => $value)
        {
            $test[$key]=implode(",",$all_data_array[$key]);
            $test1[$key]=$all_data_array[$key];
        }
        unset($all_data_array);
        if(sizeof($test1) >0)
        {
            $req_fields = ['MAQT','SCQT'];
            
            $sql="select good_quantity as MAQT,rejected_quantity as SCQT,mo_no as MONO,op_code as OPNO from $bai_pro3.mo_operation_quantites where op_code in(". $test["OPNO"].") and mo_no in (". $test["MFNO"].")";
            // echo $sql;
        
            $result=mysqli_query($link, $sql) or 
                    exit("Sql Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($row=mysqli_fetch_array($result))
            {
                foreach($req_fields as $key => $value)
                    $new_array[$value][] = $row[$value];
            }
            
        
            foreach($test1 as $key=>$value)
            {
                if($key == 'MAQT' || $key == 'SCQT')
                {
                   foreach($value as $key1=>$value1)
                   {
                   
                     $arr1[$test1['MFNO'][$key1]][$key][$test1['OPNO'][$key1]] = $value1;
                  
                  }
                  foreach($new_array[$key] as $key2 => $value2)
                  {
                    $arr2[] = $value2;
                  }
                }
            }
            $mf_nos[] = $test1['MFNO'][0];
            $details[$test1['MFNO'][0]] = $arr1;
            unset($arr1);
        }
   
    }
    $message='<html> 
    <head> 
    <style type="text/css"> 
    body 
    { 
        background-color: WHITE; 
        font-size: 10pt; 
        color: BLACK; 
        font-style: normal; 
        font-family: Trebuchet MS; 
        text-decoration: none; 
    } 
    
    th 
    { 
        color: black; 
    border: 1px solid #660000; 
        padding: 5px; 
    white-space:nowrap;  
    
    } 
    
    td 
    { 
        background-color: WHITE; 
        color: BLACK; 
    border: 1px solid #660000; 
        padding: 1px; 
    white-space:nowrap;  
    } 
    table 
    { 
    border-collapse:collapse; 
    white-space:nowrap;  
    } 
    </style> 
    </head> 
    <body>'; 
    $message .="Dear all, <br/> Please find the  M3 Quantities and SFCS Quantities";
    $message.= "<h2>M3 Quantities and SFCS Quantities</h2>"; 
    $message.= "<table border=1><tr>
    <th>Sno</th>
    <th>MO NO</th>
    <th>Operation Code</th>
    <th>Style</th>
    <th>Schedule</th>
	<th>Color</th>
    <th>Size</th>
    <th>M3 Good Quantity</th>
    <th>M3 Rejected Quantity</th>
    <th>SFCS Good Quantity</th>
    <th>SFCS Rejected Quantity</th>
    </tr>";
    if(sizeof($details))
    {
        $sno=0;
        $sql1="select sum(good_quantity) as good_quantity,sum(rejected_quantity) as rejected_quantity,mo_no,op_code,input_job_random from $bai_pro3.mo_operation_quantites where mo_no in (".implode(',',$mf_nos).") 
            and  op_code in (". $test["OPNO"].") group by mo_no,op_code";
        // echo $sql1;
        $result1=mysqli_query($link, $sql1) or exit("Sql Error 2".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($row=mysqli_fetch_array($result1))
        {
            $sql12 = "select style,schedule,group_concat(color) as color,group_concat(size) as size from $bai_pro3.mo_details where mo_no ='".$row['mo_no']."'";
            // echo $sql12;
            $result12 = mysqli_query($link,$sql12);
            while($row12=mysqli_fetch_array($result12))
            {
                $style=$row12['style'];
                $schedule=$row12['schedule'];
                $color=$row12['color']; 
                $size=$row12['size'];   
            }
            $mono = $row['mo_no'];
            $opcode = $row['op_code'];
            $m3_good = $details[$mono][$mono]['MAQT'][trim($opcode)];
            $m3_rej = $details[$mono][$mono]['SCQT'][trim($opcode)];
            $sfcs_good = $row['good_quantity'];
            $sfcs_rej = $row['rejected_quantity'];
            if($m3_good == $sfcs_good && $m3_rej == $sfcs_rej )
            {

            }
            else
            {
                $message.= "<tr>
                <td>".++$sno."</td>
                <td>".$mono."</td>
                <td>".$opcode."</td>
                <td>".$style."</td>
                <td>".$schedule."</td>
                <td>".$color."</td>
                <td>".$size."</td>
                <td>".$m3_good."</td>
                <td>".$m3_rej."</td>
                <td>".$sfcs_good."</td>
                <td>".$sfcs_rej."</td>
                </tr>";
            }
        }
    }

    $message.= "</table><br/><br/>Message Sent Via:".$plant_name."</body> 
    </html>";
    echo $message;
    $to  ="saiyateesh@gmail.com,"; 
    // subject 
    $subject = 'M3 Quantities and SFCS Quantities'; 
    // To send HTML mail, the Content-type header must be set 
    $headers  = 'MIME-Version: 1.0' . "\r\n"; 
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
    // $headers .= 'From: BEKSFCS Alert <yateesh603@gmail.com>'. "\r\n";
    $headers .= "From: ".$header_name." <".$header_mail.">". "\r\n";
  
    // Mail it 
    if($sno >0){
        if(mail($to, $subject, $message, $headers)) 
        { 
            print("mail sent successfully")."\n"; 
        }
    }else{
            print("mail not send due to no Mismatches")."\n"; 

    }
    $end_timestamp = microtime(true);
    $duration = $end_timestamp - $start_timestamp;
    print("Execution took ".$duration." seconds.");
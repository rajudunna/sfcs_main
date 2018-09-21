<?php
	$start_timestamp = microtime(true);
    $include_path=getenv('config_job_path');
	include( $include_path.'\sfcs_app\common\config\config_jobs.php');
    include( $include_path.'\sfcs_app\common\config\rest_api_calls.php');

    $mo_details = [];
    $overall_details = [];
    $from_date = date('Y-m-d');
    $to_date = date('Y-m-d');
    
    $sql_mo="SELECT  mo_no,product_sku,style,schedule,color,size,mo_quantity FROM $bai_pro3.mo_details  where mo_no in (select distinct mo_no from $bai_pro3.m3_transactions where DATE(date_time)>='$from_date' and DATE(date_time)<='$to_date') group by mo_no,product_sku";
    $result_mo=mysqli_query($link, $sql_mo) or exit("Sql Error mo".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row_mo=mysqli_fetch_array($result_mo))
    {
        $mo_details[]=['mo_no'=>$row_mo['mo_no'],'product_sku'=>$row_mo['product_sku'],'style'=>$row_mo['style'],'schedule'=>$row_mo['schedule'],'color'=>$row_mo['color'],'size'=>$row_mo['size'],'mo_quantity'=>$row_mo['mo_quantity']];
    }
    //looping MONO's array
    foreach($mo_details as $key=>$details)
    {    

        //calling the API
        $url=$api_hostname .":".$api_port_no."/m3api-rest/execute/PMS100MI/SelOperations;returncols=MFNO,OPNO,OPDS,MAQT,SCQT?CONO=".$company_no ."&FACI=".$facility_code."&MFNO=".$details['mo_no']."&PRNO=".$details['product_sku'];     
        $url1 = str_replace(' ', '%20', $url);
        $result = $obj->getCurlAuthRequest($url1);      
        $decoded = json_decode($result,true); 
        //getting the Namevalue pair from MIRecord       
        $name_values = array_column($decoded['MIRecord'], 'NameValue');
        foreach ($name_values as $key => $value) 
        {
            //getting the Name and values from name values array
            $data = array_column($value, 'Value','Name');

            //getting sum of operation code wise data from SFCS table
            $sql="select sum(good_quantity) as MAQT,sum(rejected_quantity)  as SCQT,op_code as OPNO  from $bai_pro3.mo_operation_quantites where mo_no=".$data['MFNO']." and op_code=".$data['OPNO'];
            $results_mop=mysqli_query($link, $sql) or exit("Sql Error mo operation quantites".mysqli_error($GLOBALS["___mysqli_ston"]));

            while($row = mysqli_fetch_array($results_mop)){
                $flag = true;
                if((float)$data['MAQT'] != (float)$row['MAQT']){
                    $flag = false;
                }
                if((float)$data['SCQT'] != (float)$row['SCQT']){
                    $flag = false;
                }

                if($flag == false){
                    $overall_details[] = ['MFNO'=>$data['MFNO'],'OPNO'=>$data['OPNO'],'OPDS'=>$data['OPDS'],'M3_MAQT'=>$data['MAQT'],'M3_SCQT'=>$data['SCQT'],'SFCS_MAQT'=>$row['MAQT'],'SFCS_SCQT'=>$row['SCQT'],'style'=>$details['style'],'schedule'=>$details['schedule'],'color'=>$details['color'],'size'=>$details['size'],'M3_MOQTY'=>$details['mo_quantity']];
                }
            }
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
    $message .="Dear User,";
    $message.= "<h2>Day end validation report</h2>"; 
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
    <th>MO Quantity</th>
    </tr>";
    if(count($overall_details)>0){
        foreach($overall_details as $key=>$data){
            $message.= "<tr>
            <td>".$key."</td>
            <td>".$data['MFNO']."</td>
            <td>".$data['OPNO']."</td>
            <td>".$data['style']."</td>
            <td>".$data['schedule']."</td>
            <td>".$data['color']."</td>
            <td>".$data['size']."</td>
            <td>".$data['M3_MAQT']."</td>
            <td>".$data['M3_SCQT']."</td>
            <td>".$data['SFCS_MAQT']."</td>
            <td>".$data['SFCS_SCQT']."</td>
            <td>".$data['M3_MOQTY']."</td>
            </tr>";
        }
    }else{
        $message.= "<tr>
            <td colspan=12><center>No records found<center></td>
            </tr>";
    }
    $message.= "</table><br/><br/>Message Sent Via:".$plant_name."</body> 
    </html>";
    echo $message;
    $to  ="satishkalla@schemaxtech.com"; 
    // subject 
    $subject = 'M3 Quantities and SFCS Quantities'; 
    // To send HTML mail, the Content-type header must be set 
    $headers  = 'MIME-Version: 1.0' . "\r\n"; 
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
    // $headers .= 'From: BEKSFCS Alert <yateesh603@gmail.com>'. "\r\n";
    $headers .= "From: ".$header_name." <".$header_mail.">". "\r\n";
  
    // Mail it 
    if(count($overall_details)>0){
        if(mail($to, $subject, $message, $headers)) 
        { 
            print("Email Sent Successfully")."\n"; 
        }else{
            print("Email Sent Failed")."\n"; 
        }
    }
    
    $end_timestamp = microtime(true);
    $duration = $end_timestamp - $start_timestamp;
    print("Execution took ".$duration." seconds.");
<?php
include('../../../common/config/config.php');
include('../../../common/config/m3_api_calls.php');
$store_data = [];
$get_details="select order_style_no,order_del_no,order_col_des from bai_pro3.bai_orders_db_confirm WHERE order_style_no='JJA012S9' AND order_del_no=549217 AND order_col_des = '69 - NAVY BOTTOM              '";
$result=mysqli_query($link, $get_details) or exit("error at getting style and shedule and color details".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row = mysqli_fetch_array($result))
{
    $details = [];
    $details['style'] = $row['order_style_no'];
    $details['schedule'] = $row['order_del_no'];
    $details['color'] = $row['order_col_des'];
    array_push($store_data,$details);
}

//looping the data to send it in API
foreach($store_data as $data){
    $url  = 'http://gd-app-01/rmd/api/ScheduleStatus?style='.$data['style'].'&schedule='.$data['schedule'].'&color='.$data['color'];	
	$url = str_replace(" ", '%20', $url);	
    $result = $obj->getCurlRequest($url);	
	$resultObj = json_decode($result);
	
	$style = $resultObj[0]->Style;
	$schedule = $resultObj[0]->Schedule;
	$color = $resultObj[0]->ColorDescription;
	
	$fabHigherStatus = $resultObj[0]->FabHigherStatus;
	$sTRIMHigherStatus = $resultObj[0]->STRIMHigherStatus;
	$pTRIMHigherStatus = $resultObj[0]->PTRIMHigherStatus;
		
	$ft_status=null;
    if(in_array($fabHigherStatus,array(10,11,13)))
    {
        $ft_status=1;
    }
    else
    {
        $ft_status=0;
    }
    
    $st_status=null;
    if(in_array($sTRIMHigherStatus,array(10,11,13)))
    {
        $st_status=1;
    }
    else
    {
        $st_status=0;
    }
    
    $pt_status=null;
    if(in_array($pTRIMHigherStatus,array(10,11,13)))
    {
        $pt_status=1;
    }
    else
    {
        $pt_status=0;
    }    
	
	
    $sql1="update bai_pro3.bai_orders_db set ft_status=$ft_status,st_status=$st_status,pt_status=$pt_status where order_style_no='".$style."' and order_del_no='".$schedule."' and order_col_des='".$color."'";
	//echo $sql1."<br/>";
    mysqli_query($link,$sql1)or exit("Error updating bai_order_db".mysqli_error($GLOBALS["___mysqli_ston"])); 
    
    $sql2="update bai_pro3.bai_orders_db_confirm set ft_status=$ft_status,st_status=$st_status,pt_status=$pt_status where order_style_no='".$style."' and order_del_no='".$schedule."' and order_col_des='".$color."'";
	//echo $sql2."<br/>";
    mysqli_query($link,$sql2)or exit("Error updating bai_order_db_confirm".mysqli_error($GLOBALS["___mysqli_ston"])); 
}



?>
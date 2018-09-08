<?php
/*
	=========== Create By Chandu =============
	Created at : 08-09-2018
	Updated at : 08-09-2018
	Input : Call SOAP URL.
	Output : Save the response in mo_details table in m3_inputs database.
*/
	include($_SERVER['DOCUMENT_ROOT'].'/template/dbconf.php');
	error_reporting(E_ALL);
	//var_dump($link_ui);
	$headerbody = array("user"=>$conf_tool->get('api-user-name'),"password"=>$conf_tool->get('api-password'),"company"=>"200");
	$header = new SOAPHeader("http://lawson.com/ws/credentials", "lws", $headerbody);
	$soap_client = new SoapClient( $conf_tool->get('api-host-name').":22105/lws-ws/lwsdev/SFCS?wsdl",array("login" => $conf_tool->get('api-user-name'),"password" => $conf_tool->get('api-password')));
	$soap_client->__setSoapHeaders($header);
	try{
		$to = date('Ymd',  strtotime('+3 month'));
		$from = date('Ymd',  strtotime('-1 month'));
		$result2 = $soap_client->MOData(array('Facility'=>$conf_tool->get('plantcode'),'FromDate'=>$from,'ToDate'=>$to));
		$i=1;
		echo "From Date:<b>".date('Y-m-d',strtotime($from))."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To date:<b>".date('Y-m-d',strtotime($to))."</b><br/>";
		echo "<table>";
		echo "<tr><th>S.NO</th><th>MONUMBER</th><th>MOQTY</th><th>STARTDATE</th><th>VPO</th><th>COLORNAME</th><th>COLOURDESC</th><th>SIZENAME</th><th>SIZEDESC</th><th>ZNAME</th><th>ZDESC</th><th>SCHEDULE</th><th>STYLE</th><th>PRODUCT</th><th>PRDNAME</th><th>PRDDESC</th><th>REFERENCEORDER</th><th>REFORDLINE</th><th>MOSTS</th><th>MAXOPERATIONSTS</th><th>COPLANDELDATE</th><th>COREQUESTEDDELDATE</th></tr>";
		foreach(($result2->new1Collection)->new1Item as $value){
			echo "<tr>";
				echo "<td>".$i++."</td>";
				echo "<td>".$value->MONUMBER."</td>";
				echo "<td>".$value->MOQTY."</td>";
				echo "<td>".$value->STARTDATE."</td>";
				echo "<td>".$value->VPO."</td>";
				echo "<td>".$value->COLORNAME."</td>";
				echo "<td>".$value->COLOURDESC."</td>";
				echo "<td>".$value->SIZENAME."</td>";
				echo "<td>".$value->SIZEDESC."</td>";
				echo "<td>".$value->ZNAME."</td>";
				echo "<td>".$value->ZDESC."</td>";
				echo "<td>".$value->SCHEDULE."</td>";
				echo "<td>".$value->STYLE."</td>";
				echo "<td>".$value->PRODUCT."</td>";
				echo "<td>".$value->PRDNAME."</td>";
				echo "<td>".$value->PRDDESC."</td>";
				echo "<td>".$value->REFERENCEORDER."</td>";
				echo "<td>".$value->REFORDLINE."</td>";
				echo "<td>".$value->MOSTS."</td>";
				echo "<td>".$value->MAXOPERATIONSTS."</td>";
				echo "<td>".$value->COPLANDELDATE."</td>";
				echo "<td>".$value->COREQUESTEDDELDATE."</td>";
			echo "</tr>";
			$ins_qry = "
			INSERT IGNORE INTO `m3_inputs`.`mo_details` 
            (`MONUMBER`, `MOQTY`, `STARTDATE`, `VPO`, `COLORNAME`, `COLOURDESC`, `SIZENAME`, `SIZEDESC`, `ZNAME`, `ZDESC`, `SCHEDULE`, `STYLE`, `PRODUCT`, `PRDNAME`, `PRDDESC`, `REFERENCEORDER`, `REFORDLINE`, `MOSTS`, `MAXOPERATIONSTS`, `COPLANDELDATE`, `COREQUESTEDDELDATE`) VALUES ('".$value->MONUMBER."','".$value->MOQTY."','".date('Y-m-d',strtotime($value->STARTDATE))."','".$value->VPO."','".$value->COLORNAME."','".$value->COLOURDESC."','".$value->SIZENAME."','".$value->SIZEDESC."','".$value->ZNAME."','".$value->ZDESC."','".$value->SCHEDULE."','".$value->STYLE."','".$value->PRODUCT."','".$value->PRDNAME."','".$value->PRDDESC."','".$value->REFERENCEORDER."','".$value->REFORDLINE."','".$value->MOSTS."','".$value->MAXOPERATIONSTS."','".date('Y-m-d',strtotime($value->COPLANDELDATE))."','".date('Y-m-d',strtotime($value->COREQUESTEDDELDATE))."')
        ";
       // echo $ins_qry;
        $result_time = mysqli_query($link_ui, $ins_qry) or exit("Sql Error update downtime log".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		echo "</table>";

	}
	catch(Exception $e){
		var_dump($e->getMessage());
	}
?>
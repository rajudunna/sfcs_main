<?php

function m3_alloc_qty($style,$schedule,$component)
{
$connect = odbc_connect("$driver_name;Server=$server;Database=$database;",$userid,$passwrd);
$inp_1=$style;
$inp_2=$schedule;
$inp_3=$component;

$allc_qty=0;
$issued_qty=0;

$query = "StyleWiseMatrialRequirment_Macro '$inp_1'";
$result = odbc_exec($connect, $query);
while(odbc_fetch_row($result))
{ 
	if(trim(odbc_result($result, 4))==$schedule and trim(odbc_result($result, 8))==$component)
	{
		$allc_qty+=odbc_result($result, 12);
		$issued_qty+=(odbc_result($result, 13)+odbc_result($result, 14));

	}
	
}

$returns=array();
$returns['allocated']=$allc_qty;
$returns['issued']=$issued_qty;

odbc_close($connect);

return $returns;
unset($returns);
} 
?>
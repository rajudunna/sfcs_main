<?php
if(isset($_GET['inputObj']))
{
    $inputObj = $_GET['inputObj'];
    if($inputObj != '')
    {
        reportBundle($inputObj);
    }
}

function reportBundle($inputObj){
    echo '{
    "status": "Scanned Successfully",
    "internalMessage": "All partial or full qty updated as good qty",
    "data": [
			{
				"style": "XYZ123",
				"size": "S",
				"fgColor": "Colour",
				"goodQty": "50",
				"rejectedQty": "0",
				"bundleNumber": "12345",
				"operation": "100"
			}
		]
	}';
}
?>
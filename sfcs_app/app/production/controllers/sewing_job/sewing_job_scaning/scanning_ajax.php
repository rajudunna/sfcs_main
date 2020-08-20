<?php
if(isset($_GET['inputObj']))
{
    $inputObj = $_GET['inputObj'];
    if($inputObj != '')
    {
        getJobDetails($inputObj);
    }
}
function getJobDetails($inputObj)
{
    echo '{
        "style": "XYZ123",
        "fgColors": ["blue"],
        "schedules": [123456],
        "sizeQuantities": [
            {
                "docketNo": [123,233,1233],
                "fgcolor": ["a","b"],
                "size": "S",
                "eligibleQuantity": 1232,
                "resourceId": "2",
                "status": "Cut Qty Not Done",
                "inputJobQty": "4",
                "operationWiseQuantity": [{
                    "operationCode": "100",
                    "quantity": 20
                },{
                    "operationCode": "130",
                    "quantity": 15
                }],
                "cumilativeReportedQty": 0,
                "rejectedQty": 2
            },
            {
                "docketNo": [198],
                "fgcolor": ["a"],
                "size": "XL",
                "eligibleQuantity": 500,
                "resourceId": "3",
                "status": "Scanning Pending",
                "inputJobQty": "100",
                "operationWiseQuantity": [{
                    "operationCode": "100",
                    "quantity": 50
                },{
                    "operationCode": "130",
                    "quantity": 40
                }],
                "cumilativeReportedQty": 0,
                "rejectedQty": 0
            }
        ]
    }';
}

if(isset($_GET['saveInputJob']))
{
    $saveInputJob = $_GET['saveInputJob'];
    if($saveInputJob != '')
    {
        saveInputJob($saveInputJob);
    }
}

function saveInputJob($saveInputJob){
    
}

?>

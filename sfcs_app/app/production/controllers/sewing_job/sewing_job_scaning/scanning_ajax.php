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

if(isset($_GET['reportData']))
{
    $reportData = $_GET['reportData'];
    if($reportData != '')
    {
        reportData($reportData);
    }
}

if(isset($_GET['reverseObj']))
{
    $reverseObj = $_GET['reverseObj'];
    if($reverseObj != '')
    {
        getReverseDetails($reverseObj);
    }
}
function getReverseDetails($reverseObj)
{
    echo '{
        "status": "true",
        "internalMessage": "text",
        "data": [{
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
                        "operationCode": "100",
                        "cumilativeReportedQty": 0,
                        "rejectedQty": 2
                    },
                    {
                        "docketNo": [198],
                        "fgcolor": ["a"],
                        "size": "XL",
                        "eligibleQuantity": 500,
                        "resourceId": "2",
                        "status": "Scanning Pending",
                        "operationCode": "100",
                        "inputJobQty": "100",
                        "cumilativeReportedQty": 0,
                        "rejectedQty": 0
                    }]
                }
                ]
            }';
}
function reportData($reportData){
    echo '{
        "transactionsData" : [{
            "jobNo": "12",
            "bundleNo": "1",
            "fgColor": "blue",
            "size": "x",
            "reportedQty": "10",
            "rejectedQty": "0"
        },{
            "jobNo": "12",
            "bundleNo": "2",
            "fgColor": "blue",
            "size": "xs",
            "reportedQty": "20",
            "rejectedQty": "5"
        }]
    }';
}

if(isset($_GET['rejectReportData']))
{
    $rejectReportData = $_GET['rejectReportData'];
    if($rejectReportData != '')
    {
        rejectReportData($rejectReportData);
    }
}

function rejectReportData($rejectReportData){
    echo '{
        "status": "true",
        "internalMessage": "Sewing Job Sucessfully Reversed."
            }';
}

?>

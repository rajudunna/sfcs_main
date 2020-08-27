<?php
if(isset($_GET['inputObj']))
{
    $inputObj = $_GET['inputObj'];
    if($inputObj != '')
    {
        getSJNumbers($inputObj);
    }
}
// outobj={
//     sewingJobNumbers=string;
// }
function getSJNumbers($inputObj)
{
    echo '{
            "sewingJobNumbers" : ["SJ01","SJ02","SJ03","SJ04","SJ05"]
        }';
        
}

if(isset($_GET['sjObj']))
{
    $sjObj = $_GET['sjObj'];
    if($sjObj != '')
    {
        getTableData($sjObj);
    }
}

function getTableData($sjObj)
{
    echo '{
            "Outobj" : {
                "style" : "ABC123",
                "SCHEDULE" : "323232",
                "color" : "blue",
                "jobNo" : "SJ212",
                "jobQty" : "50",
                "bundle" :[
                    {
                        "bundleNo" : "B123",
                        "size" : "XL",
                        "qty" : "50"
                    },
                    {
                        "bundleNo" : "B133",
                        "size" : "XS",
                        "qty" : "500"
                    },
                    {
                        "bundleNo" : "B223",
                        "size" : "S",
                        "qty" : "250"
                    }
                ]
            }
        }';
        
}

?>
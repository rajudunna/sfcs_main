<?php 

$week_qty=array(); 
$week_no=array(); 

$sql1="SELECT distinct supplier as supplier FROM $bai_pro3.bai_qms_db_reason_track WHERE qms_reason in (".$reasons_list_ref.") ".$suppliers_list_ref_query." and log_date between \"".$sdate."\" and \"".$edate."\" GROUP BY supplier order by supplier";
//echo $sql1."<br>";  
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 

while($sql_row1=mysqli_fetch_array($sql_result1)) 
{ 
    $supplier_name[]=$sql_row1["supplier"]; 
} 
// var_dump($supplier_name); 
if(sizeof($supplier_name) > 0){ 
    $week_implode1="'".implode("','",$supplier_name)."'"; 
} 
//echo $week_implode1."<br>"; 

$ix=0; 

//echo implode(",",$reason_code)."-".implode(",",$reasons_list)."<br>"; 
if(implode(",",$reason_code)==implode(",",$reasons_list)) 
{ 
    $reasons_list=array(); 
    for($j12=0;$j12<sizeof($reason_desc);$j12++) 
    {     
        $reasons_list[]=$reason_code[$j12]; 
        $reasons_list2[]=$reason_code[$j12]; 
    } 
     
    $reasons_list[]=implode(",",$reasons_list); 
} 
//echo "<br>".implode(",",$reasons_list); 
for($j121=0;$j121<sizeof($reasons_list);$j121++) 
{     
    $qty_total1=array(); 
    for($i121=0;$i121<sizeof($supplier_name);$i121++) 
    {     
        $sql111="SELECT * FROM $bai_pro3.bai_qms_db_reason_track WHERE qms_reason in (".$reasons_list[$j121].") and supplier=\"".$supplier_name[$i121]."\" and log_date between \"".$sdate."\" and \"".$edate."\""; 
        //echo $sql111."<br>"; 
        $qty1=0;             
        $sql_result111=mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        if(mysqli_num_rows($sql_result111) > 0) 
        { 
            while($sql_row111=mysqli_fetch_array($sql_result111)) 
            {     
                $qty1=$qty1+$sql_row111["qms_qty"]; 
            } 
            //$qty_total1[]=$qty1; 
            if($rejval==1) 
            { 
                $qty_total1[]=$qty1; 
            } 
            else 
            { 
                $qty_total1[]=round(($qty1*100)/$output,2); 
            } 
        } 
        else 
        { 
            $qty1=0; 
            $qty_total1[]=$qty1; 
        } 
    } 
     
    if($j121==0) 
    { 
        //echo "Note=".$j121."-".$reasons_list[$j121]."-".implode(",",$reasons_list)."-".(sizeof($reasons_list)-1)."<br>"; 
        $series_ref11="{name: '".($reason_desc[$j121])."',data: [".implode(",",$qty_total1)."]}"; 
    } 
    else 
    { 
        //echo "<br>1"; 
        //echo "Note=".$j121."-".$reasons_list[$j121]."-".implode(",",$reasons_list)."-".(sizeof($reasons_list)-1)."<br>"; 
        if(implode(",",$reason_code)!=implode(",",$reasons_list)) 
        { 
            if($reasons_list[$j121]!=implode(",",$reasons_list2)) 
            {     
                //echo $reason_desc[$j121]."<br>2"; 
                $series_ref11.=",{name: '".($reason_desc[$j121])."',data: [".implode(",",$qty_total1)."]}"; 
            } 
            else 
            { 
                //echo "Note=".$j121."-".(sizeof($reasons_list)-1)."<br>"; 
                if($j121==(sizeof($reasons_list)-1)) 
                { 
                    $series_ref11.=",{name: 'All',data: [".implode(",",$qty_total1)."]}"; 
                } 
                else 
                { 
                    $series_ref11.=",{name: '".($reason_desc[$j121])."',data: [".implode(",",$qty_total1)."]}"; 
                } 
            } 
        } 
        else 
        { 
            if($reasons_list[$j121]!=implode(",",$reasons_list)) 
            {     
                //echo $reasons_list[$j121]."-".$reason_desc[$j121]."<br>"; 
                $series_ref11.=",{name: '".($reason_desc[$j121])."',data: [".implode(",",$qty_total1)."]}"; 
            }         
            else 
            { 
                //echo "Note=".$j121."-".(sizeof($reasons_list)-1)."<br>"; 
                if($j121==(sizeof($reasons_list)-1)) 
                { 
                    $series_ref11.=",{name: 'All',data: [".implode(",",$qty_total1)."]}"; 
                } 
                else 
                { 
                    $series_ref11.=",{name: '".($reason_desc[$j121])."',data: [".implode(",",$qty_total1)."]}"; 
                } 
            } 
        }             
    } 
}     

//echo $series_ref11; 
     
echo "<br><br><br><script type=\"text/javascript\"> 
$(function () { 
    var chart; 
    $(document).ready(function() { 
        chart = new Highcharts.Chart({ 
            chart: { 
                renderTo: 'containerx1', 
                borderColor: '#000000', 
                borderWidth: 3, 
                spacingBottom: 55, 
                type: '".$mode_ref."', 
                style: { 
                        fontWeight: 'bold', 
                        color: '#000000', 
                        connectorColor: '#000000', 
                        fontSize: '15px' 
                    } 
            }, 
            title: { 
                align: 'left', 
                text: 'Supplier And Reason Wise Chart ".$add_string."' 
            }, 
            xAxis: { 
                categories: [".$week_implode1."], 
                title: { 
                    text: '".$period_ref."' 
                } 
            }, 
            yAxis: { 
                min: 0, 
                title: { 
                    text: 'Rejection Qty' 
                } 
            }, 
            exporting: { 
            enabled: false 
            }, 
            legend: { 
                align: 'center', 
                layout: 'horizontal', 
                x: 105, 
                verticalAlign: 'bottom', 
                y: 40, 
                floating: true, 
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white', 
                borderColor: '#CCC', 
                borderWidth: 1, 
                shadow: false 
            }, 
            tooltip: { 
                formatter: function() { 
                    return '<b>'+ this.x +'</b><br/>'+ 
                        this.series.name +': '+ this.y +'<br/>'+ 
                        'Total: '+ this.point.stackTotal; 
                } 
            }, 
            plotOptions: {             
              '".$mode_ref."': { 
               pointPadding: 0.0, 
               borderWidth: 2, 
                    dataLabels: { 
                        enabled: true 
                        "; 
                        if($rejval==2) 
                        { 
                        echo ", 
                        formatter: function() { 
                        return this.y +'%'; 
                        }"; 
                        } 
                        echo " 
                    } 
                } 
            }, 
            series: [".$series_ref11."] 
        }); 
    }); 
     
}); 
</script> 

<div class=\"table-repsonsive\">
<div id=\"containerx1\" style=\"width: 1200px; height: 600px; margin: 0 auto\"></div></div>"; 



?> 
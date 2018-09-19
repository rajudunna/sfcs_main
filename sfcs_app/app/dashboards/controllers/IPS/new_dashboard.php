<?php
    //==================== IPS Dashboard ========================
    /* ==========================================================
                      Created By: Chandu
    Input & output: get section details and send ajax call to server and display it in sections div
    Created at: 19-09-2018
    Updated at: 19-09-2018 
    ============================================================ */
    $v_r = explode('/',base64_decode($_GET['r']));
    array_pop($v_r);
    $url = "http://".$_SERVER['HTTP_HOST'].implode('/',$v_r)."/ips_dashboard.php";
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    $sec_result = mysqli_query($link, "SELECT DISTINCT sec_id FROM $bai_pro3.sections_db WHERE sec_id>0") or exit("Sec qry".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sections = mysqli_fetch_all($sec_result,MYSQLI_ASSOC);
    echo "<script>var sec_ids = '".implode(',',array_column($sections, 'sec_id'))."';</script>";
    echo "<div class='panel panel-primary'>
            <div class='panel-heading'><h3 class='panel-title'>IPS Dashboard</h3></div>
            <div class='panel-body'>
            <div class='col-sm-12'>";
    foreach($sections as $sec){
        echo "<div class='col-sm-3'>
            <div class='panel panel-success'>
                <div class='panel-heading'><h4 class='text-center panel-title'>SECTION - ".$sec['sec_id']."</h4></div>
                <div class='panel-body sec-box'>
                    <div class='loading-block' id='sec-load-".$sec['sec_id']."' style='display:block'></div>
                    <div id='sec-".$sec['sec_id']."'>

                    </div>
                </div>
            </div>
        </div>";
    }
    echo "</div></div></div>";
?>

<script>
jQuery( document ).ready(function() {
    call_server();
});

function call_server(){
    var sec_id_ar = sec_ids.split(',');
    for(var i=0;i<sec_id_ar.length;i++){
        $.ajax({
            url: "<?= $url ?>?sec="+sec_id_ar[i]
        }).done(function(data) {
            var r_data = JSON.parse(data) ;
            $('#sec-'+r_data.sec).html(r_data.data);
            $('#sec-load-'+r_data.sec).css('display','none');
        });
    }
}
</script>
<style>
.sec-box{
    min-height:100px;
}
.loading-block{
    border: 10px solid #f3f3f3; 
    border-top: 10px solid #156b0a; 
    border-radius: 50%;
    width: 70px;
    height: 70px;
    animation: spin 2s linear infinite;
    margin : 0 auto;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

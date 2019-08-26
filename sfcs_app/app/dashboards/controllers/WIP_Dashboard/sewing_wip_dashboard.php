

<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); 
    $url = getFullURLLevel($_GET['r'],'wip_dashboard_data.php',0,'R');
  $RELOAD_TIME = (int)$wip_refresh_time;
    $dashboard_name="WIP";
    // $sections_query = "Select sec_id from $bai_pro3.sections_db where sec_id > 0";
    $sections_query = "SELECT section_display_name,section_head AS sec_head,ims_priority_boxs,GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` LEFT JOIN $bai_pro3.sections_master ON module_master.section=sections_master.sec_name WHERE section>0 GROUP BY section ORDER BY section + 0";
    $sections_result = mysqli_query($link,$sections_query);
    while($row = mysqli_fetch_array($sections_result)){
        $sections[] = $row['sec_id'];
    }
    $sections_str = implode(',',$sections);
?>


<div class='row'>
    <div class='panel panel-primary'>
        <div class='panel-heading'>
            <b>WIP DASHBOARD</b>
            <p class='pull-right'>Auto-Refresh : <?= $RELOAD_TIME ?> mins </p>
        </div>
        <div class='panel-body'>
            <div class='row'>
                <div class='col-sm-2'>
                    <label for='operations'>Sewing Operations</label>
                    <select class='form-control'  name='operations' id='operations'>
                        <option value='0' selected disabled>Please Select</option>
                       <?php
                        $get_count = "select count(*) as cnt from $brandix_bts.tbl_orders_ops_ref where category ='sewing'";
                       
                        $sql_count_result=mysqli_query($link, $get_count) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($sql_count=mysqli_fetch_array($sql_count_result)) 
                        {
                          $cnt=$sql_count['cnt'];
                        }
                        $get_operations ="select operation_code from $brandix_bts.tbl_orders_ops_ref where category ='sewing' limit 1,$cnt"; 
                        $result=mysqli_query($link,$get_operations);
                        while ($test = mysqli_fetch_array($result))
                        {
                         echo '<option value="'.$test['operation_code'].'">'.$test['operation_code'].'</option>';
                        } 
                       ?>
                    </select>
                </div>
                <div class='col-sm-1'>
                    <label for='submit'><br/></label><br/>
                    <input class='btn btn-success btn-sm' type='button' value='submit' onclick='load_data()' name='submit'>
                </div>
            </div><hr>
            
        <?php
            foreach($sections as $section)
            {
                $id1 = "sec-load-$section";
                $id2 = "sec-$section";

                $sqlx1="SELECT section_display_name FROM $bai_pro3.sections_master WHERE sec_name=$section";
                $sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
                {
                    $section_display_name=$sql_rowx1['section_display_name'];
                }
        ?>    
                <div class='section_div' style='width:25vw;float:left;padding:5px'>
                    <div class='panel panel-success'>
                        <div class='panel-body sec-box'>
                            <center><span class='section-heading'><b><?= $section_display_name; ?></b></span></center>
                            <span style='height:50px'>&nbsp;</span>
                            <div class='loading-block' id='<?= $id1 ?>' style='display:block'></div>
                            <div id='<?= $id2 ?>'>

                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        ?>
            <!-- <div class='row'></div>


            <div class='row'>
                <hr/>
                <div class='l-div col-sm-3'>
                    <span class="b-block gloss-red" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 
                    <span class='l-text'> - Line WIP &le; 216</span>
                </div>
                <div class='l-div col-sm-3'>
                    <span class="b-block gloss-green" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 
                    <span class='l-text'> - Line WIP &ge; 217 && &le; 750</span>
                </div>
                <div class='l-div col-sm-3'>
                    <span class="b-block gloss-black" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 
                    <span class='l-text'> - Line WIP &ge; 751</span>
                </div>
            </div> -->
        </div>
    </div>
</div>

<script>
    var sections_str = '<?= $sections_str ?>';
    var sections = sections_str.split(',');


    function load_data(){
        console.log();
        for(var i=0;i<sections.length;i++){
            call_ajax(sections[i],false);
        }
    }

    function call_ajax(section,sync_type){
        console.log(section);
        var operations = $('#operations').val();
           
        $('#sec-load-'+section).css('display','block');
        $('#sec-'+section).html('');
        $.ajax({
            url: "<?= $url ?>?section="+section+"&operations="+operations
        }).done(function(data) {
            console.log("Response Came");
            try{
                var sec_data = JSON.parse(data) ;
                $('#sec-'+section).html(sec_data.data);
                $('body').append(sec_data.java_scripts);
                $('#sec-load-'+section).css('display','none');
                $('[data-toggle="tooltip"]').tooltip(); 

                if(sync_type){
                    var ind = sections.indexOf(section);
                    if(sections[ind+1]){ 
                        call_ajax(sections[ind+1],true);
                    }
                }
            }catch(err){
                if(sync_type){
                    $('#sec-'+section).html('<b>couldn\'t fetch the data.It will automatically refresh in <?= $RELOAD_TIME ?> mins</b>');
                    $('#sec-load-'+section).css('display','none');
                    if(sync_type){
                        var ind = sections.indexOf(section);
                        if(sections[ind+1]){
                            call_ajax(sections[ind+1],true);
                        }
                    }
                }
            }
        }).fail(function(){
            if(sync_type){
                $('#sec-'+section).html('<b>Network Error.It will automatically refresh in <?= $RELOAD_TIME ?> mins.</b>');
                $('#sec-load-'+section).css('display','none');
                var ind = sec_id_ar.indexOf(section);
                if(sections[ind+1]){
                    call_ajax(sections[ind+1],true);
                }
            }
        });
    }


    

</script>


<style>
    hr{
        border-bottom : 1px solid black;
    }
    .panel-body{
        background : #efefef;
    }
    .section-heading{
        color : #000;
        font-size : 16px;
        font-weight : 15px;
    }
    .sec-box{
        min-height:100px;
        overflow : hidden;
        background : #fffffd;
        border : 1px solid #111;
    }

    .ims-wip{
        background : #FFAA00;
        background : #D00B7C;
        width : parent;
        height : 35px;
        color : #fff;
        font-size : 12px;
        font-weight : 8px;
        padding : 3px;
        opacity : 1;
        border : 1px solid #aaa;
        border-radius : 4px;
    }    
     .cut-wip{
        //background : #D00B7C;
        width : parent;
        height : 35px;
        color : #fff;
        padding : 3px;
        font-size : 12px;
        font-weight : 8px;
        opacity : 1;
        border : 1px solid #aaa;
        border-radius : 4px;
    }
    .pending-wip{
        background : #0055FF;
        width : parent;
        height : 35px;
        color : #000;
        font-size : 12px;
        font-weight : 8px;
        padding : 3px;
        opacity : 1;
        border : 1px solid #aaa;
        border-radius : 2px;
    }
    .wip-text{
        font-size : 12px;
        color : #3c3c3c;
    }
    .mod-no{
        color : #000;
        font-weight : 10px;
        padding : 5px;
    }
    .mod-td{
        min-width : 40px;
    }
    .wip-td{
        min-width : 80px;    
    }
    .cut-td{
        width    : auto;
        margin : 0;
    }
    .block{
        color      : #000;
        min-width  : 25px;
        min-height : 25px;
        padding    : 2px;
    }
    .cut-block{
        width  : 25px;
        height : 25px;
        border : 1px solid #000;
    }
    .l-div{
        min-height : 40px;
    }
    .l-block{
        min-width : 25px;
        min-height : 25px;
        border : 1px solid #3c3c3c;
    }
    /* .l-text{
        color : #444;
        font-weight : bold;
    } */
    .b-block{
        border : 1px solid #3c3c3c;
    }
    .green{
        background : green;
    }
    .lgreen {
        background : #59ff05;
    }
    .orange{
        background : #FF8000;
    }
    .yellow{
        background : #ffff00;
    }
    .pink{
        background : pink;
    }
    .blue{
        background : #15a5f2;
    }
    .yash{
        background: #999999;
    }
    .red{
        background : #ff0000;
    }
    .gloss-red{
        background : #ff0000;
        opacity    : 1; 
    }
    .gloss-green{
        background : #008000;
        opacity    : 1;
    }
    .gloss-black{
        background : #111;
        opacity    : 1;
    }
    .gloss-purple{
        background : #D00B7C;
        opacity    : 1;
    }
  
    table{
        width : auto;
        max-width : 500px; 
    }
    tr{
        border-bottom : 1px dashed #c5c5c5;
        width : parent;
        display : block;
        line-height : 1px;
    }
    td{
        width : auto;
        line-height : 1px;
        white-space: nowrap;
    }
    a{
        text-decoration : none;
        color : #000;
    }
    a:hover{
        cursor : pointer;
    }
    v{
        color : #fff;
        text-align : left; 
        display : block;
        font-size : 11px;
    }
    c{
        color : #FFFF55;
        text-align : left;   
    }
    //Tool tip break
    .tooltip-inner {
        max-width: 500px;
        white-space: nowrap;
        margin:0;
        padding:0;
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

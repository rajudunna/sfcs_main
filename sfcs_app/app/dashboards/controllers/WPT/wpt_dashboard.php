

<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); 
    $url = getFullURLLevel($_GET['r'],'wpt_dashboard_data.php',0,'R');
    $sections_query = "Select sec_id from $bai_pro3.sections_db where sec_id > 0";
    $sections_result = mysqli_query($link,$sections_query);
    while($row = mysqli_fetch_array($sections_result)){
        $sections[] = $row['sec_id'];
    }
    $sections_str = implode(',',$sections);
?>



<div class='row'>
    <div class='panel panel-primary'>
        <div class='panel-heading'>
            <b>WPT DASHBOARD</b>
        </div>
        <div class='panel-body'>
            <div class='row'>
                <div class='col-sm-3'>
                    <label for='blocks'>No of Blocks per Section</label>
                    <select class='form-control'  name='blocks' id='blocks' >
                        <option value selected disabled>Schedules Per Sec</option>
                        <option value='4' >4</option>
                        <option value='8' >8</option>
                        <option value='12'>12</option>
                        <option value='16'>16</option>
                    </select>
                    <!-- <input class='form-control' type='text' name='blocks' id='blocks' class='integer' 
                        placeholder='No Of Blocks Per Section'> -->
                </div>
                <div class='col-sm-1'>
                    <label for='submit'><br/></label><br/>
                    <input class='btn btn-success btn-sm' type='button' value='submit' onclick='change_widths()' name='submit'>
                </div>
            </div><hr>
            
        <?php
            foreach($sections as $section)
            {
                $id1 = "sec-load-$section";
                $id2 = "sec-$section";
        ?>    
                <div class='section_div' style='width:35.9vw;float:left;padding:5px'>
                    <div class='panel panel-success'>
                        <div class='panel-body sec-box'>
                            <center><span class='section-heading'><b>SECTION - <?= $section ?></b></span></center>
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
            <div class='row'></div>
            <div class='row'>
            <hr/>
                <div class='l-div col-sm-4'>
                    <span class="l-block yellow" >&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <span class='l-text'>Fabric Issued to Cutting Module</span>
                </div>
                <div class='l-div col-sm-4'>
                    <span class="l-block green" >&nbsp;&nbsp;&nbsp;&nbsp;</span> 
                    <span class='l-text'>Material Requested</span>
                </div>
                <div class='l-div col-sm-4'>
                    <span class="l-block lgreen" >&nbsp;&nbsp;&nbsp;&nbsp;</span> 
                    <span class='l-text'>Material Available and Not Requested</span>
                </div>
                <div class='l-div col-sm-4'>   
                    <span class="l-block red" >&nbsp;&nbsp;&nbsp;&nbsp;</span> 
                    <span class='l-text'>Material Not Available and Not Requested</span>
                </div>
                <div class='l-div col-sm-4'>
                    <span class="l-block yash" >&nbsp;&nbsp;&nbsp;&nbsp;</span> 
                    <span class='l-text'>Material Status Not Updated in FSP</span>
                </div>
                <div class='l-div col-sm-4'>
                    <span class="l-block pink" >&nbsp;&nbsp;&nbsp;&nbsp;</span> 
                    <span class='l-text'>Ready To Issue</span>
                </div>
                <div class='l-div col-sm-4'>
                    <span class="l-block orange" >&nbsp;&nbsp;&nbsp;&nbsp;</span> 
                    <span class='l-text'>Cutting Partially Done</span>
                </div>
                <div class='l-div col-sm-4'>
                    <span class="l-block blue" >&nbsp;&nbsp;&nbsp;&nbsp;</span> 
                    <span class='l-text'>Cut Completed But Not Issued To Module</span>
                </div>
            </div>
            <div class='row'>
            <hr/>
                <div class='l-div col-sm-4'>
                    <span class="b-block ims-wip" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 
                    <span class='l-text'> - IMS WIP</span>
                </div>
                <div class='l-div col-sm-4'>
                    <span class="b-block pending-wip" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 
                    <span class='l-text'> - CUT REPORTED BUT NOT ISSUED </span>
                </div>
                <!-- <div class='l-div col-sm-4'>
                    <span class="b-block cut-wip" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 
                    <span class='l-text'> - CUT WIP</span>
                </div> -->
            </div>
        </div>
    </div>
</div>

<script>
    var sections_str = '<?= $sections_str ?>';
    var sections = sections_str.split(',');
    var bw = 100;
    $(document).ready(function(){
        load_data();
        $('[data-toggle="tooltip"]').tooltip(); 
    });

    setInterval(function() {
        call_ajax(sections[0],true);
    }, 120000); 


    function load_data(){
        for(var i=0;i<sections.length;i++){
            call_ajax(sections[i],false);
        }
    }

    function call_ajax(section,sync_type){
        console.log(section);
        var blocks = $('#blocks').val();
        if(blocks == '')
            blocks = 4;
        $('#sec-load-'+section).css('display','block');
        $('#sec-'+section).html('');
        $.ajax({
            url: "<?= $url ?>?section="+section+"&blocks="+blocks
        }).done(function(data) {
            console.log("Response Came");
            try{
                var sec_data = JSON.parse(data) ;
                $('#sec-'+section).html(sec_data.data);
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
                    $('#sec-'+section).html('<b>couldn\'t fetch the data.It will automatically refresh in 2 mins</b>');
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
                $('#sec-'+section).html('<b>Network Error.It will automatically refresh in 2 mins.</b>');
                $('#sec-load-'+section).css('display','none');
                var ind = sec_id_ar.indexOf(section);
                if(sections[ind+1]){
                    call_ajax(sections[ind+1],true);
                }
            }
        });
    }
    
    function change_widths(){
        load_data();
        var b = Number($('#blocks').val());
        var w = b*bw + 100;   
        if(Number(w) > 1200)
            w = 900;
        if(b == 8)
            w = 4*bw + 100;        
        $('.section_div').css({"width":w+"px"});
    }
</script>


<style>
    hr{
        border-bottom : 1px solid black;
    }
    .section-heading{
        color : #000;
        font-size : 16px;
        font-weight : 15px;
    }
    .sec-box{
        min-height:200px;
        overflow : hidden;
        background : #f9f9f9;
    }

    .ims-wip{
        background : #FFAA00;
        background : #FF00D4;
        width : parent;
        height : 35px;
        color : #fff;
        font-size : 12px;
        font-weight : 8px;
        padding : 3px;
        opacity : 1;
        border : 1px solid #aaa;
        border-radius : 3px;
    }
    .cut-wip{
        background : #00FF00;
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
        min-width : 85px;    
    }
    .cut-td{
        min-width  : 1200px;
        width : auto;
    }
    .block{
        color : #000;
        overflow : hidden;
        min-width  : 200px;
        min-height : 40px;
        font-size : 12px;
        padding : 3px;
        border : 1px solid #aaa;
        border-radius : 3px;
    }
    .cut-block{
        min-width : 100px;
        padding : 2px;
    }
    .l-div{
        min-height : 40px;
    }
    .l-block{
        min-width : 25px;
        min-height : 25px;
        border : 1px solid #3c3c3c;
    }
    .l-text{
        color : #444;
        font-weight : bold;
    }
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
  

    table{
        width : auto;
        max-width : 500px; 
    }
    tr{
        border-bottom : 1px dashed #c5c5c5;
        width : parent;
        display : block;
    }
    td{
        width : auto;
    }
    a{
        text-decoration : none;
        color : #000;
    }

    //Tool tip break
    .tooltip-inner {
        white-space: pre-line;
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

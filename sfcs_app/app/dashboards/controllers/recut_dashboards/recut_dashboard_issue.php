<?php
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');

    $html_data = '';
    $modal_data = '';
    $counter = 0;
    $break_me_at = 8;
   
    $cuts     = [15];
    $embs     = [60,70];
    $sewing   = [100,129,130,900];
    $all_op_codes = [$cuts,$embs,$sewing];

    $table_begin="<table class='table table-bordered'>
                    <thead>
                        <tr class='info'><th>Operation Code</th><th>Size</th>
                            <th>Rejected Qty</th><th>Replaced Qty</th><th>Recut Raised Qty</th>
                        </tr>
                    </thead>
                    <tbody>";
    $table_end  = "</tbody></table>";                    

    $blocks_query  = "SELECT group_concat(id) as ids,SUM(qty) as raised,SUM(reported_qty) as reported,
                    parent_id as doc_no,qms_style as style,
                    qms_schedule as schedule,qms_color as color,SUM(qms_qty) as rejected_qty 
                    FROM bai_pro3.recut_v2_child rc 
                    LEFT JOIN bai_pro3.bai_qms_db qms ON rc.doc_no = qms.doc_no
                    WHERE STATUS = 0 and qms_tran_type = 3
                    group by parent_id,parent_id";               
    $blocks_result = mysqli_query($link,$blocks_query) or exit('Rejections Log Data Retreival Error');        
    while($row = mysqli_fetch_array($blocks_result)){
        $counter++;
        $modal_body_data = '';
        $style   = $row['style'];
        $schedule= $row['schedule'];
        $color   = $row['color'];
        $rejected_qty = $row['rejected_qty'];
        $docket_number = $row['doc_no'];
        $to_post_ids = $row['ids'];

        $raised   = $row['raised'];
        $reported = $row['reported'];

        if($raised < $reported)
            $status_color = 'orange';
        else if($reported == 0)
            $status_color = 'red';
        else if($reported >= $raised)
            $status_color = 'green';    
            

        if($counter == $break_me_at){
            $html_data.='&nbsp;&nbsp;&nbsp;&nbsp;</span><br/><br/><br/><br/>';
            $counter = 1 ;
        }

        $tool_tip_text ="<p style=\"width : 500px\">
                            <v><c>Style</c> : $style</v>
                            <v><c>Schedule No</c> : $schedule</v>
                            <v><c>Colors</c> : $color</v>
                            <v><c>Docket No</c> : $docket_number</v>
                            <v><c>Rejected Qty</c> : $rejected_qty</v>
                            <v><c>Recut Reported Qty</c> : $reported</v>
                        </p>";

        $html_data.="<span class='block'>
                        <span class='inner-block $schedule $style'>
                            <span class='mytooltip'>
                                <a rel='tooltip' data-toggle='tooltip' data-placement='top' data-title='$tool_tip_text'
                                onclick='open_modal(this)' data-html='true' id='$schedule' class='$status_color'>
                                &nbsp;&nbsp;&nbsp;
                                </a>
                            </span>
                        </span>
                    </span>";
        
        //getting the operation and size wise data for POPUP
        $details_query = "SELECT operation_id,size,
                          SUM(qty) AS recut_raised
                          SUM(reported_qty) AS reported
                          FROM $bai_pro3.recut_v2_child
                          WHERE parent_id = $docket_number
                          AND status = 0
                          GROUP BY operation_id,size
                          ORDER BY operation_id,qms_size";
        //echo $details_query.'<br/>';                  
        $details_result = mysqli_query($link,$details_query) or exit('Unable to get rejections from qms db');
        while($rowq = mysqli_fetch_array($details_result)){
            $op_code = $rowq['operation_id'];
            $size    = $rowq['qms_size'];
            $size = getSize($style,$schedule,$color,$size);
            $qop_codes[$op_code]            = $op_code;
            $qsize_details[$op_code][]      = $size; 
            $qqty_details_rec[$op_code][$size]= $rowq['recut_raised'];
            $qqty_details_rej[$op_code][$size]= $rowq['reported'];
            $qqty_details_bal[$op_code][$size]= $rowq['recut_raised'] - $rowq['reported'];
        }
       
        //var_dump($qop_codes);
        //$modal_body_data.=$details_query;
        foreach($all_op_codes as $category){
            $inner_counter = 0;
            $flag = 0;
            foreach($category as $op_code){
                if($qop_codes[$op_code] != '')
                    if($inner_counter == 0){
                        $modal_body_data.= $table_begin;
                        $flag = 1;
                        $inner_counter = 1;
                    }
                if($qsize_details[$op_code] != ''){
                    foreach($qsize_details[$op_code] as $size)
                        $modal_body_data.= "<tr><td>$op_code</td><td>".$size."</td>
                                                <td>".$qqty_details_rej[$op_code][$size]."</td>
                                                <td>".$qqty_details_rep[$op_code][$size]."</td>
                                                <td>".$qqty_details_rec[$op_code][$size]."</td>
                                        </tr>";
                }
            }
            if($flag){
                $modal_body_data.= $table_end."<br/>";
            }
        }
        
        $modal_data .= "<div class='modal fade' id='modal$schedule' tabindex='-1'
                         aria-hidden='true'>
                        <div class='modal-dialog  modal-lg' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <b>Module Wise Rejection Details</b>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    <div class='col-sm-12'>
                                        <div class='col-sm-4'>
                                            <b class='label'>Style : </b><d>$style</d>
                                        </div>
                                        <div class='col-sm-4'>
                                            <b class='label'>Schedule : </b><d>$schedule</d>
                                        </div>
                                        <div class='col-sm-4'>    
                                            <b class='label'>Color : </b><d>$color</d>
                                        </div>
                                        <br/>
                                        <hr/>
                                    </div>
    
                                    <div class='col-sm-3'></div>
                                    <div class='col-sm-6'>
                                    $modal_body_data
                                    </div>
                                </div>
                                <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                </div>
                            </div>
                        </div>
                    </div>";

        unset($qop_codes);
        unset($qsize_details);
        unset($qqty_details_rej);
        unset($qqty_details_rep);
        unset($qqty_details_rec);

    }

    function getSize($style,$schedule,$color,$size){
        global $link;
        global $bai_pro3;

        $size_query = "SELECT title_size_$size as size from $bai_pro3.bai_orders_db where order_style_no = '$style' 
                       and order_del_no='$schedule' and order_col_des='$color'";
        $size_result = mysqli_query($link,$size_query);
        $row = mysqli_fetch_array($size_result);
        $size = $row['size'];     
        return $size;          
    }
?>

<div class='row'>
    <div class='panel panel-primary'>
        <div class='panel-heading'>
            <b>RECUT DASHBOARD - View</b>
        </div>
        <div class='panel-body'>
            <div class='row'>
                <div class='col-sm-2'>
                    <label for='blocks'>Style Track</label>
                    <input type='text' class='form-control alpha' place-holder='Enter Style' id='style'>
                </div>
                <div class='col-sm-2'>
                    <label for='blocks'>Schedule Track</label>
                    <input type='text' class='form-control integer' place-holder='Enter Schedule' id='schedule'>
                </div>
            </div><hr>

            <div class='container'>
            <br/><br/>
                <div class='col-sm-12'>
                    <?php echo $html_data;echo $modal_data; ?>
                    &nbsp;&nbsp;&nbsp;
                </div>
            </div>
            <div class='row'></div>
        </div>
    </div>
</div>


<style>
    .container{
        border : 1px solid #e5e5e5;
        border-radius : 3px;
        min-height : 500px;
    }
    .block{
        color  : #000;
        background : #fff;
        padding : 7px;
        font-size : 10px; 
    }
    .inner-block{
        height : 120px;
        
        border-radius : 0px;
        //padding : 3px;
    }
    .label{
        color : #2D2D2D;
        font-size : 0px;
    }
    d{
        font-size : 15px;
    }
    .red{
        background : #E20D0D;
    }
    .orange{
        background : #FF8000;
    }
    .green{
        background : #27A727;
    }

    @-webkit-keyframes blinker {
        from { opacity: 1.0; }
        to { opacity: 0.0; }
    }
    .blink{
        text-decoration: blink;
        -webkit-animation-name: blinker;
        -webkit-animation-duration: 0.5s;
        -webkit-animation-iteration-count:infinite;
        -webkit-animation-timing-function:ease-in-out;
        -webkit-animation-direction: alternate;
    }
    .modal{
        width : auto;
    }
    .modal-body{
	    max-height: calc(100vh - 200px);
	    overflow-y: auto;
	}
	.modal{
	 	opacity : 0.1;
	}
	.modal-header{
		background : #0D8DE2;
		color : #fff;
	}
    .modal-lg{
        width : 1200px;
    }
    .modal-content{
        height : 650px;
    }
    .modal-body{
        height : 600px;
    }
    .block a{
        color : #fff;
        padding : 10px;
        height : 100px;
        font-weight : bold;
        border : 1px solid #3c3c3c;
    }
    a:hover{
        cursor : pointer;
        text-decoration : none;
    }
    v{
        color : #fff;
        text-align : left; 
        display : block;
        font-size : 12px;
    }
    c{
        color : #FFFF55;
        text-align : left;   
    }

    //Tool tip break
    .tooltip{
        width : 150px;
    }
    .tooltip-inner {
        max-width: 300px;
        white-space: nowrap;
        margin:0;
        padding:5px;
    }
</style>


<script>
    $('#style').on('keyup',function(){
        $('#schedule').val('');
        $('.blink').removeClass('blink');
        var style = $(this).val();
        $('.'+style).addClass('blink');
    });
    
    $('#schedule').on('keyup',function(){
        $('#style').val('');
        $('.blink').removeClass('blink');
        var schedule = $(this).val();
        $('.'+schedule).addClass('blink');
    });

    function open_modal(t){
        var id = t.id;
        $('#modal'+id).modal({
            show: 'true'
        });
    }
</script>
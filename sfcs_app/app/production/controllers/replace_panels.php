<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    $style='';$schedule='';$color='';
?>
<style>
.ajax-loader {
  visibility: hidden;
  background-color: inherit;
  position: absolute;
  width: 100%;
  height:100%;
  transition: 1s;
}

.ajax-loader img {
  position: relative;
  top:10%;
  left:40%;
}
</style>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">Replace Panels </div>
        <div class="panel-body">
            <div class="row">
                <form id="rep_panels" action="index.php?r=<?= $_GET['r']; ?>" method="POST">
                    <div class="col-sm-3">
                        <input type="text" id="ijob" name="job_no" placeholder="Enter Input Job Number" onchange="getmodnos()" value="" class="form-control integer" required>
                    </div>
                    <div class="col-sm-3" id="modiv">
                        <select class='form-control' name="mod_no" id="mod_id" required>
                            <option value="">Please Select Module</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <input type="submit" id="submit" name="submit" class="btn btn-primary">
                    </div>
                </form>
                <hr>
                <div class="ajax-loader">
                    <img src="<?= getFullurlLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>" class="img-responsive" />
                </div>
            </div>
            <?php
            if(isset($_POST['submit']))
            {       
                    $job_no = $_POST['job_no'];
                    $mod_no = $_POST['mod_no'];
                    $render_data = array();
                    echo "<div> <button  class='btn btn-success' id='replace_id'>Replace</button></div><form><table class='table table-bordered'><thead><tr><th>Style</th><th>Schedule</th><th>Color</th><th>Size</th><th>Good</th><th>Reject</th><th>Replace Qty</th><th>Action</th></tr><thead>";

                    $get_details_qry = "select DISTINCT qms_style,qms_schedule,qms_color,qms_size from $bai_pro3.bai_qms_db where input_job_no='$job_no' and remarks like '%$mod_no%'";
                    
                    $res_details_qry =mysqli_query($link,$get_details_qry);
                    $ai = 0;
                    while($result1 = mysqli_fetch_array($res_details_qry))
                    {
                        $render_data[$ai]['style'] = $result1['qms_style'];
                        $render_data[$ai]['schedule'] = $result1['qms_schedule'];
                        $render_data[$ai]['color'] = $result1['qms_color'];
                        $render_data[$ai]['size'] = $result1['qms_size'];
                        $ai++;
                    }
                    // var_dump($render_data);
                    $i=0;
                    foreach($render_data as $data_ary){
                        $panel_qry = "
                        SELECT qms_style,qms_schedule,qms_color,qms_size,SUM(g_qms_qty) AS g_qms_qty,SUM(r_qms_qty) AS r_qms_qty,GROUP_CONCAT(doc_no) AS doc_no,qms_tran_type, GROUP_CONCAT(shift) AS shift, 
                        GROUP_CONCAT(operation_id) AS operation_id,GROUP_CONCAT(bundle_no) AS bundle_no  FROM ((SELECT qms_style,qms_schedule,qms_color,qms_size,SUM(qms_qty) AS g_qms_qty,0 AS r_qms_qty,NULL AS doc_no,qms_tran_type, NULL AS shift, 
                        '' AS operation_id,NULL AS bundle_no 
                        FROM bai_pro3.bai_qms_db WHERE qms_style='".$data_ary['style']."' 
                        AND qms_schedule='".$data_ary['schedule']."' AND qms_color = '".$data_ary['color']."' AND qms_size = '".$data_ary['size']."' AND qms_tran_type=1 
                        GROUP BY qms_size,qms_tran_type ORDER BY qms_size,qms_color,qms_tran_type ) UNION ALL (
                        SELECT qms_style,qms_schedule,qms_color,qms_size,0 AS g_qms_qty,SUM(qms_qty) AS r_qms_qty,doc_no,qms_tran_type, SUBSTRING_INDEX(SUBSTRING_INDEX(remarks, '-', -2),'-',1) AS shift, 
                        operation_id,bundle_no 
                        FROM bai_pro3.bai_qms_db WHERE qms_style='".$data_ary['style']."' 
                        AND qms_schedule='".$data_ary['schedule']."' AND qms_color = '".$data_ary['color']."' AND qms_size = '".$data_ary['size']."' AND qms_tran_type=3
                        GROUP BY qms_size,qms_tran_type ORDER BY qms_size,qms_color,qms_tran_type
                        )) AS tab GROUP BY qms_style,qms_schedule,qms_color,qms_size
                        ";
                  //echo $panel_qry."<br>";
                 //die();
                    $previous_size = '';
                    $count =0;
                    $res_qry =mysqli_query($link,$panel_qry);
                    echo "<tbody>";
                   
                        while($result1 = mysqli_fetch_assoc($res_qry))
                        {
                            
                            $style = $result1['qms_style']; 
                            $schedule = $result1['qms_schedule'];$color = $result1['qms_color'];
                            $size = $result1['qms_size'];
                            $good = $result1['g_qms_qty'];
                            // $good=0;
                            $rej = $result1['r_qms_qty'];
                            $doc_no = $result1['doc_no'];
                            $shift = $result1['shift'];
                            $operation = $result1['operation_id'];
                            $operation =explode(',',$operation);
                            $operation = $operation[1];
                            $bundle_no = $result1['bundle_no'];

                            echo "<tr><td>$style</td><td>$schedule</td><td>$color</td>
                                    <td>$size</td>";
                                    if($good>0){
                                        echo " <td>$good</td>";
                                    }else{
                                        $good=0;
                                        echo "<td>$good</td>";
                                    }
                                    if($rej>0){
                                        echo "<td>$rej</td>";
                                    }else{
                                        $rej=0;
                                        echo "<td>$rej</td>";
                                    }
                                   
                                if( $good>0 ){
                                    if($good>=$rej){
                                        echo "   <td><input type='text' id='rep_$i' name='replace_$i' class='form-control' value = '$rej'></td>";
                                    }else{
                                        echo "   <td><input type='text' id='rep_$i' name='replace_$i' class='form-control' value = '$good'></td>";
                                    }
                                    echo"  <td>
                                    <input type='hidden' id='siz_$i' name='size_$i' value='$size'>
                                    <input type='hidden' id='gud_$i' name='gud_$i' value='$good'>
                                    <input type='hidden' id='rej_$i' name='gud_$i' value='$rej'>
                                    <input type='hidden' id='doc_$i' name='doc_$i' value='$doc_no'>
                                    <input type='hidden' id='shift_$i' name='shift_$i' value='$shift'>
                                    <input type='hidden' id='opid$i' name='opid$i' value='$operation'>
                                    <input type='hidden' id='bundle_$i' name='bun_$i' value='$bundle_no'>
                                    <input type='hidden' id='color_$i' name='color_$i' value='$color'>
                                    <input type='checkbox' id='$i' name='che_$i' value=''>

                                    </td>
                                  </tr>";
                                 
                                }else{
                                    echo "   <td><input type='text' id='rep_$i' name='replace_$i' class='form-control' value = '0' readonly></td><td></td>";
                                }
                                $i = $i+1;

                        }
                        
                    }
                    echo "</tbody>";  
                }
            ?>
                 </table>
           </form>
        </div>
    </div>
</div>



<script>

function getmodnos()
{
    var job_value = $('#ijob').val();
    
    if(job_value!=''){
   
        $.ajax({
                url: '<?= getFullURLLevel($_GET['r'],'replace_ajax.php',0,'R'); ?>',
				data:{
                 'input_job':job_value
                 },
				method:'POST',
                dataType: 'JSON',
				success:function(res){
                    var len = res.length;
                    if(len>0){
                        for(var i=0;i<len;i++){
                             var options = "<option value='"+res[i]+"' >"+res[i]+"</option>";
                             $("#mod_id").append(options);
                            }
                        }else{
                                swal({title:'No Modules Assigned For this Input Job Number',text:'',icon:'warning',button:'OK'});
                                $('#ijob').val('');
                        }
					}
			});
    }else{
        swal('Please Enter Input Job Number');
    }
  
}

 $('input[type="text"]').change(function(){
    var input_id= $(this).attr('id');
    var rep_value = $('#'+input_id).val();
    var base_id = input_id.substr(input_id.indexOf("_") + 1);
    var rej_value = $('#rej_'+base_id).val();
    var gud_value = $('#gud_'+base_id).val();
    // console.log(rep_value);
        if(parseInt(rep_value) > parseInt(gud_value)){
            swal('Can not Replace More than The Good quantity');
            $('#'+input_id).val('0');
        }
        else if(parseInt(rep_value) > parseInt(rej_value)){
            swal('Can not Replace More than The Rejected quantity');
            $('#'+input_id).val('0');
        }
 });

$('#mod_id').click(function(){
    if($('#ijob').val() === ''){
        swal('Please Enter Input Job Number','','warning');
    }
});

    $('#replace_id').click(function(){

        var replace_values =  []; 
        var sizes = [];
        var doc_nos = [];
        var shifts = [];
        var ops = [];
        var bundle = [];
        var color = [];
	    var count =0;   
        $("input[type='checkbox']").each(function() { 
            if($(this).prop('checked') == true){
                count++;
                var check_id= $(this).attr('id');
                if(parseInt($('#rep_'+check_id).val())>0 ){
                    sizes.push($('#siz_'+check_id).val());
                    doc_nos.push($('#doc_'+check_id).val());
                    shifts.push($('#shift_'+check_id).val());
                    ops.push($('#opid'+check_id).val());
                    replace_values.push($('#rep_'+check_id).val());
                    bundle.push($('#bundle_'+check_id).val());
                    color.push($('#color_'+check_id).val());
                }
                // else{
                    // alert('In Checked quantity, Rejection Quantity is less than zero');
                    // return false;
                // }
               
                console.log('size'+sizes);console.log('docno'+doc_nos);
                console.log('shift'+shifts);console.log('opid'+ops);
                console.log('bundle'+bundle);
                console.log('color'+color);
            }
	    });

        if(count>0){
                swal({
                title: "Are you sure?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '<?= getFullURLLevel($_GET['r'],'replace_ajax.php',0,'R'); ?>',
                        data:{
                        'style':'<?= $style; ?>',
                        'color':color,
                        'schedule':'<?= $schedule; ?>',
                        'size':sizes,
                        'job_no':'<?= $job_no; ?>',
                        'mod_no':'<?= $mod_no; ?>',
                        'shifts':shifts,
                        'docs':doc_nos,
                        'operations':ops,
                        'bundles':bundle,
                        'rep_qty': replace_values
                        },
                        method:'POST',
                        success:function(res){
                            $('.ajax-loader').css("visibility", "visible");
                            if(res){
                                $('.ajax-loader').css("visibility", "hidden");
                                swal("Replaced Successfully", {
                                    icon: "success",
                                });
                                $('.ajax-loader').css("visibility", "none");
                                location.reload();
                            }
                            
                        }
                    });
                } else {
                    swal("Your Process is cancelled!");
                    }
                });
        }else{
            swal('Please check atleast one action!');
        }

    });
</script>
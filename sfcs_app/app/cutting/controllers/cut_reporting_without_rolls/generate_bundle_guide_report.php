<?php
 $generated_bundle_url = getFullURLLevel($_GET['r'],'get_generated_bundle_guide_data.php',0,'R');
?>
<div class='panel panel-primary'>
    <div class='panel-heading'>
        <b>Generated Bundle guide Report</b>
    </div>

    <div class='panel-body'> 
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <label>Schedule</label>
               <input type="text" name="schedule" id="schedule" class="form-control"> 
            </div>
            <div class="col-sm-3">
                <label>Docket</label>
                <input type="text" name="docket" id="docket" class="form-control"> 
             </div>
             <div class="col-sm-3">
                 <label></label>
                <input type="submit" name="submit" class="btn btn-sm btn-primary form-control" onclick="getdetails()" id="submit"> 
             </div>
        </div>
    </div>
    <br/><br/><br/>
    <div class='col-sm-12' id = "generated_bundle_guide">
                    <div class="table-responsive">
                    <table class='table table-bordered' >
                    <thead>
                        <tr class='info'>
                            <th>S. No</th>
                            <th>Docket No.</th>
                            <th>Size</th>
                            <th>Bundle No.</th>
                            <th>Shade Bundle No.</th>
                            <th>Shade</th>
                            <th>Bundle Start No.</th>
                            <th>Bundle End No.</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody id='enablerolls' >
                       
                    </tbody>
                </table>    
           </div>
        </div>

        <div class='col-sm-12' id = "not_found">
                    <h4 style="color:red;">~~~~Not Found~~~~</h4>
        </div>
    </div>
  
</div>

<script>

$('#generated_bundle_guide').css({'display':'none'});
$('#not_found').css({'display':'none'});
function getdetails()
{
    var schedule=$('#schedule').val();
    var docket=$('#docket').val();
    $('#generated_bundle_guide').css({'display':'none'});
    $('#enablerolls').html('');
    $('#not_found').css({'display':'none'});

             var form_data = {
                        doc_no:docket,
                        schedule:schedule
                    };    
                $.ajax({
                    url  : '<?= $generated_bundle_url?>',
                    type : 'POST',
                    data : form_data
                }).done(function(res){
                   if(res)
                   {
                    var data = $.parseJSON(res);
                   }
                   else{
                    var data = [];
                   }
                    
                        var noofrolls=data.length;
                        var i;
                        var sno=1;
                        var notdisplay=0;
                                        try
                                        {
                                            if(noofrolls>0)
                                            {
                                                for(i=0;i<noofrolls;i++)
                                                {
                                                        row = $('<tr><td id='+i+'>'+sno+'</td><td>'+data[i]['doc_no']+'</td><td>'+data[i]['size']+'</td><td>'+data[i]['bundle_no']+'</td><td>'+data[i]['shade_bundle']+'</td><td></td><td>'+data[i]['bundle_start']+'</td><td>'+data[i]['bundle_end']+'</td><td></td></tr>'); //create row
                                                        $('#enablerolls').append(row);
                                                        sno++;
                                                }
                                            $('#generated_bundle_guide').css({'display':'block'});
                                            }
                                            else
                                            {
                                                $('#not_found').css({'display':'block'}); 
                                            }
                                        }catch(e){
                                        
                                        }
                }).fail(function(res){
                
                });
}
</script>
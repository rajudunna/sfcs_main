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
                <div class="col-sm-2">
                    <label>Style</label>
                <input type="text" name="Style" id="Style" class="form-control"> 
                </div>
                <div class="col-sm-2">
                    <label>Schedule</label>
                <input type="text" name="schedule" id="schedule" class="form-control"> 
                </div>
                <div class="col-sm-2">
                    <label>Color</label>
                <input type="text" name="color" id="color" class="form-control"> 
                </div>
                <div class="col-sm-3">
                    <label></label>
                    <input type="submit" name="submit" class="btn btn-sm btn-primary form-control" onclick="getdetails()" id="submit"> 
                </div>
            </div>
    </div>
    <br/><br/>
    <div class='col-sm-12' id = "generated_bundle_guide">
            <div class="table-responsive">
                    <table class="table">
                    <thead>
                        <tr class='info'>
                            <th>S. No</th>
                            <th>Docket No.</th>
                            <th>Action</th>
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



    <div class='col-sm-12' id = "generated_bundle_guide_print">
            <div class="table-responsive">
                    <table border=1 class="table table-bordered">
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
                        </tr>
                    </thead>
                    <tbody id='enablerollsprint' >
                       
                    </tbody>
                </table>    
           </div>
        </div>
    </div>
  
</div>

<script>

$('#generated_bundle_guide').css({'display':'none'});
$('#generated_bundle_guide_print').css({'display':'none'});

$('#not_found').css({'display':'none'});
function getdetails()
{   
    var style=$('#style').val();
    var schedule=$('#schedule').val();
    var color=$('#color').val();
    var docket=$('#docket').val();
    $('#generated_bundle_guide').css({'display':'none'});
    $('#enablerolls').html('');
    $('#not_found').css({'display':'none'});

             var form_data = {
                        schedule:schedule,
                        style:style,
                        color:color,
                    };    
                $.ajax({
                    url  : '<?= $generated_bundle_url.'?action=docketdetails.'?>',
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
                                                        row = $('<tr><td id='+i+'>'+sno+'</td><td>'+data[i]['doc_no']+'</td><td><input type="button" class="btn btn-sm btn-primary" value="Print" onclick="printdetails('+data[i]['doc_no']+')"></td></tr>'); //create row
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

function printdetails(doc_no)
{
    
                $.ajax({
                    url  : '<?= $generated_bundle_url.'?action=printdetails.' ?>',
                    type : 'POST',
                    data : {doc_no:doc_no}
                }).done(function(res){
                    
                    
                   if(res)
                   {
                    result=$.parseJSON(res);
                    var data = result.response_data;
                    var ratioslist=result.ratios_list;
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
                                                // $.each( ratioslist, function( index, value ){
                                                    
                                                // });
                                              //  $("#generated_bundle_guide_print").append("<div>Style :"+data[0]['schedule']+"</div>");
                                               // $("#generated_bundle_guide_print").html("<div>Style :"+data[0]['schedule']+"</div>");

                                                for(i=0;i<noofrolls;i++)
                                                {
                                                        row = $('<tr><td id='+i+'>'+sno+'</td><td>'+data[i]['doc_no']+'</td><td>'+data[i]['size']+'</td><td>'+data[i]['bundle_no']+'</td><td>'+data[i]['shade_bundle']+'</td><td></td><td>'+data[i]['bundle_start']+'</td><td>'+data[i]['bundle_end']+'</td></tr>'); //create row
                                                        $('#enablerollsprint').append(row);
                                                        sno++;
                                                }
                                            $('#generated_bundle_guide_print').css({'display':'block'}); 
                                            printDiv();
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



function printDiv() 
{
  var divToPrint=document.getElementById('generated_bundle_guide_print');

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);
  $('#generated_bundle_guide_print').css({'display':'none'});
  $('#enablerollsprint').html('');
  $('#not_found').css({'display':'none'}); 
}
</script>
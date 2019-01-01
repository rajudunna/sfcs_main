


<?php
    include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
    include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions.php");
    $url = getFullURLLevel($_GET['r'],'ips_transfer_ajax.php',0,'R');
    
    $sqlx="select * from $bai_pro3.module_master order by module_name*1";
    $sql_resultx=mysqli_query($link, $sqlx) or exit("NO sections availabel");
    while($sql_rowx=mysqli_fetch_array($sql_resultx))
    {
        $modules[]=$sql_rowx['module_name']; 
    }
?>

<script type="text/javascript">
    var ijob_array = [];
    var module = 0;
    var to_module = 0;
    function checkedMe(t){
        ijob = $('#job_'+(t.id)).val();
        if(t.checked == true){
            ijob_array.push(ijob);
            console.log(ijob_array);
        }else{
            ijob_array.pop(ijob);
            console.log(ijob_array);
        }

        if(ijob_array.length > 0)
           $('#submit_button').show();
        else 
           $('#submit_button').hide();
              
    }


    function getdata(var flag=0){
      delete ijob_array;
      $('#loading-image').show();
      $('#submit_button').hide();
      module = $("#module").val();
      $.ajax({
            type: "GET",
            url: '<?= $url ?>?get_data=1&module='+module,
            success: function(response) 
            {
                var data = $.parseJSON(response);
                console.log(data);
                $('#dynamic_table1').show();
                document.getElementById('dynamic_table').innerHTML = data.table;
                $('#show_to_module').show();
                $('#loading-image').hide();
                if(data.records == '0'){
                    if(flag != '1')
                    swal('No Jobs For Transfer','','warning');
                    document.getElementById('dynamic_table').innerHTML = '';
                    document.getElementById('show_to_module').style.display = "none";
                }
            }
        });
    }
    function clear_data(){
       getdata();
    }
    function post_data(){
        to_module = $("#to_module").val();
        module = $("#module").val();
        if(to_module == null)
            return swal('select Module');
        else{
            data = {'jobs':ijob_array};
            $.ajax({
                type: "POST",
                data:data,
                url: '<?= $url ?>?save_data&to_module='+to_module+'&module='+module,
                success: function(response) 
                {
                    var res = $.parseJSON(response);
                    if(res.saved == '1')
                        swal('Module Transferred Successfully','','success');
                    else
                        swal('Error In Module Transfer','','error');

                    getdata(1);
                }
            });
        }

        console.log(data);
    }
    
    function toggle(source) {
        checkboxes = document.getElementsByClassName('boxes');
        for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
            checkedMe(checkboxes[i]);
        }
    }
</script>

<html>
<head>
    <title>Job Transfer</title>
</head>
<body>
    <div class="container-fluid">
        <div class="panel panel-primary">
            <div class="panel-heading">Ips Jobs Transfer</div>
                <div class="panel-body">
                    <div class='row'>
                        <div class="form-inline col-sm-10">
                           
                            <label><font size="2">Module: </font></label>
                            <select  name="module" class="form-control" id="module">
                                <option value="" disabled selected>Select Module</option>
                                <?php
                                    foreach($modules as $module)
                                        echo "<option value='$module'>$module</option>"
                                ?>
                            </select>
                       
                        <input type="button"  class="btn btn-success" value="Submit" onclick="getdata()"> 
                        </div>
                    </div>

                    <div class="ajax-loader" id="loading-image" style="margin-left: 486px;margin-top: 35px;border-radius: -80px;width: 88px;display : none">
                          <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
                    </div>

                   <!--  <div class='panel-heading'>Styles Report</div> -->
                    <div style='overflow-y:scroll' class='col-sm-12' id="dynamic_table">
                
                    </div>   
                    <div class='row' id='show_to_module' style='display:none'> 
                        <div class="col-sm-1">
                            <label>To Module:</label>
                        </div>
                        <div class="col-sm-2">                            
                            <select  name="to_module" class="form-control" id="to_module">
                            <option value="" disabled selected>Select Module</option>
                            <?php
                                foreach($modules as $module)
                                    echo "<option value='$module'>$module</option>"
                            ?>
                        </select>
                        </div>
                        <div class="col-sm-3" id='submit_button' style='display:none'>   
                            <label><br/></label>
                            <input type="button"  class="btn btn-success" value="Transfer" onclick="post_data()">
                            <input type="button"  class="btn btn-success" value="Cancel" onclick="clear_data()"> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
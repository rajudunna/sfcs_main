     <?php
    if(isset($_REQUEST['rowid']))
    {
        $id=$_REQUEST['rowid'];
        $module=$_REQUEST['module_name'];
        $description=$_REQUEST['module_description'];
        $block_priorities =$_REQUEST['block_priorities'];
        $mapped_cut_table =$_REQUEST['mapped_cut_table'];
        $section=$_REQUEST['section'];
        $status=$_REQUEST['status'];
        $module_color=$_REQUEST['module_color'];
        
        $module_label=$_REQUEST['module_label'];
        $mapped_cut_table = $_REQUEST['mapped_cut_table'];
       
    }else
    {
        $id=0;
    }
    $action_url = getFullURL($_GET['r'],'save_module.php','N'); 
    ?>
    <div class='panel panel-primary'>
    <div class='panel-heading'>
        <b>Modules</b>
    </div>
    <div class='panel-body'>

            <form action="<?= $action_url ?>" id="formentry" class="form-horizontal" role="form" method="POST" data-parsley-validate novalidate>
                <input type='hidden' id='id' name='id' value="<?php echo $id; ?>" >
                <input type='hidden' id='sec1' name='sec1' value="<?php echo $section; ?>" >
                <div class="container-fluid shadow">
                    <div class="row">
                        <div id="valErr" class="row viewerror clearfix hidden">
                            <div class="alert alert-danger">Oops! Seems there are some errors..</div>
                        </div>
                        <div id="valOk" class="row viewerror clearfix hidden">
                            <div class="alert alert-success">Yay! ..</div>
                        </div>

                        
                                    <div class="row">
                                        <div class="col-md-12"><div class="row">
                                            
                                                    
                        
                <div class="col-md-4">
                <div class="form-group">
                <label class="control-label control-label-left col-sm-3" for="module">Module</label>
                <div class="controls col-sm-9">
                <?php if($module!=''){   
               echo" <input id='module' type='text' class='form-control k-textbox float' data-role='text' placeholder='Module' name='module' readonly value='$module' required='required' data-parsley-errors-container='#errId1'><span id='errId1' class='error'></span></div>";
                }
                else{
                    echo" <input id='module' type='text' class='form-control k-textbox float' data-role='text' placeholder='Module' name='module' value='$module' required='required' data-parsley-errors-container='#errId1'><span id='errId1' class='error'></span></div>";

                }
                ?>
                </div>
                </div>
                        
                <div class="col-md-4">
                <div class="form-group">
                <label class="control-label control-label-left col-sm-3" for="module" id="required">Section</label>
                <div class="controls col-sm-9">
                 
   <?php 
   include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
   $conn=$link;
        echo "<select id='sections' class='form-control' data-role='select'  name='sections'  data-parsley-errors-container='#errId2' required>";
        
        echo "<option value='Please Select'  disabled selected>Please Select</option><br/>\r\n";
        $query = "SELECT * FROM $bai_pro3.sections_master";
        $result = $conn->query($query);
        while($row = $result->fetch_assoc()) 
        {
            $operation_id=$row['id'];
            $sec_name=$row['sec_name'];
            
            $section_display_name=$row['section_display_name'];
            if($section == $sec_name){
                echo "<option value='".$sec_name."' selected>$section_display_name</option>";

            }else{
                echo "<option value='".$sec_name."'>$section_display_name</option>";

            }


            
        }
        echo "</select>";
    ?>      </div>
                </div>
                </div>          
        
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label control-label-left col-sm-3" for="description">Block Priorities</label>
                <div class="controls col-sm-9">
                    <input type="text" name="block_priorities" id="block_priorities" value="<?= $block_priorities; ?>" class="form-control integer" required>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label control-label-left col-sm-3" for="description">Module Description</label>
                <div class="controls col-sm-9">
                    <textarea id="description" type="text" class="form-control k-textbox" data-role="text" placeholder="Module Description" name="description" data-parsley-errors-container="#errId1"><?php echo htmlspecialchars($description); ?></textarea><span id="errId1" class="error"></span>
                </div>
            </div>
        </div>
        <div class="col-md-4"><div class="form-group">
                <label class="control-label control-label-left col-sm-3" for="table_status">Status</label>
                <div class="controls col-sm-9">
                    
                <select id="table_status" class="form-control" data-role="select" selected="selected" name="table_status" data-parsley-errors-container="#errId2">
          <?php
                if($status=='In-Active'){
                    
                echo '<option value="1">Active</option>';
                    echo '<option value="2" selected>In-Active</option>';
                    
                }else{
                    
                    
                        echo '<option value="1" selected>Active</option>';
                    echo '<option value="2">In-Active</option>';
                    
                    
                }
                
                ?>
  
        </select><span id="errId2" class="error"></span></div>
                
        </div></div>
        <div class="col-md-4"><div class="form-group">
                <label class="control-label control-label-left col-sm-3" for="description">Module Color</label>
                <div class="controls col-sm-9">
                <div id="cp2" class="input-group colorpicker-component"> 
                    <input type="text" value="<?= ($module_color)?$module_color: "#ffffff"; ?>" class="form-control" readonly="true" name="module_color"/> 
                    <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
                
        </div></div>
        <div class="col-md-4"><div class="form-group">
                <label class="control-label control-label-left col-sm-3" for="description">Module Label</label>
                <div class="controls col-sm-9">
                <input type="text" class="form-control" name="module_label" value="<?= $module_label; ?>"><span id="errId1" class="error"></span>
                </div>
                
        </div></div>
        
            
    <div class="col-md-4"><div class="form-group">
            <label class="control-label control-label-left col-sm-3" for="table_status">Cut Table</label>
            <div class="controls col-sm-9">
                <select class="form-control" name="mapped_cut_table" id="mapped_cut_table">
                    <option value="">Please Select</option>
                    <?php 
                        $get_cut_table_qury = "SELECT tbl_name FROM bai_pro3.`tbl_cutting_table` WHERE status='active';";
                        $get_cut_table_result = mysqli_query( $link, $get_cut_table_qury);
                        while ($row = mysqli_fetch_array($get_cut_table_result))
                        {
                            if ($mapped_cut_table == $row['tbl_name'])
                            {
                                $selected = 'selected';
                            }
                            else
                            {
                                $selected = '';
                            }
                            
                            echo "<option value='".$row['tbl_name']."' $selected>".$row['tbl_name']."</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
    </div>

    <div class="col-md-4" style="visibility:hidden;"><div class="form-group">
       
       <div class='input-group date' id='datetimepicker11' >
           <input type='text' class="form-control" name='datetimepicker11'/>
           <span class="input-group-addon">
               <span class="glyphicon glyphicon-calendar">
               </span>
           </span>
       </div>
   </div>
</div>
            
    <script type="text/javascript">
        $('#cp2').colorpicker();
    </script>
    <script>
        $(function () {
            $('#datetimepicker11').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                daysOfWeekDisabled: [0, 6]
            });
        });
    </script>
    <div class="col-md-4">
        <div class="form-group" style="margin-top: 0px;">
            <button id="btn_save" type="submit" class="btn btn-primary" name="btn_save">Save</button>
        </div>
    </div>
</div></div>
                                    </div>
                                
                    </div>
                </div>
            </form>
        </div>
    </div>
    
<?php include('view_modules.php'); ?>

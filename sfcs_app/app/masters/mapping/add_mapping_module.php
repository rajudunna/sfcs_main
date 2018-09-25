

<!DOCTYPE html>
<html lang="en">
<head>
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>


    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
   
	<?php include('/template/header.php'); ?>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Fav and touch icons -->
	<script>
		
	function checkAll()
{
     var checkboxes = document.getElementsByTagName('input'), val = null;    
     for (var i = 0; i < checkboxes.length; i++)
     {
         if (checkboxes[i].type == 'checkbox')
         {
             if (val === null) val = checkboxes[i].checked;
             checkboxes[i].checked = val;
			// alert(checkboxes[i].checked);
         }
     }
 }
	</script>
	<style type="text/css">
		td
		{
			width: 30;
		}
	</style>
</head>

<body>
     <?php
    /* if(isset($_REQUEST['rowid']))
    {
        $id=$_REQUEST['rowid'];
        $module=$_REQUEST['module_name'];
        $description=$_REQUEST['module_description'];
        $status=$_REQUEST['status'];
    }else
    {
        $id=0;
    } */
    $action_url = getFullURL($_GET['r'],'save_mapping_modules.php','N'); 
    ?>
    <div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Mapping</b>
	</div>
	<div class='panel-body'>

            <form action="<?= $action_url ?>" id="formentry" class="form-horizontal" role="form" method="POST" data-parsley-validate novalidate>
                <input type='hidden' id='id' name='id' value="<?php echo $id; ?>" >
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
			    <label class="control-label control-label-left col-sm-3" for="module" id="required">Section</label>
			    <div class="controls col-sm-9">
                 
   <?php 
   include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
   $conn=$link;
		echo "<select id='section' class='form-control' data-role='select'  name='section' data-parsley-errors-container='#errId2'>";
		echo "<option value='Please Select'>Please Select</option><br/>\r\n";
		$query = "SELECT sec_id,sec_head FROM $bai_pro3.`sections_db` order by sec_head";
		$result = $conn->query($query);
		while($row = $result->fetch_assoc()) 
		{
			$sec_head=$row['sec_head'];
			$sec_id=$row['sec_id'];
			echo "<option value='".$sec_id."' ".$selected.">$sec_head</option>";
		}
		echo "</select>";
	?>      </div>
				</div>
				</div>
							
						
							
							
							
			<div class="col-md-4">				
			<div class="form-group">
			<input type='checkbox' name='chkl' onClick='checkAll()'/>Select All</input>
			    <label class="control-label control-label-left col-sm-3" for="module" id="required">Module</label>
			    
                 
   <?php 
		 $query1 = "SELECT id,module_name FROM $bai_pro3.`module_master` order by module_name asc";
		 $result1 = $conn->query($query1) or die($conn->error);
		 echo "<div class='col-md-8'><div><table id = 'modules_tbl' <table id='modules_tbl' style='width: 545px;'>";

		 $cnt = 0;
		 $col_cnt = 0;
		 $num_rows = mysqli_num_rows($result1);
		 $table_cols = floor($num_rows / 10);
		 $table_exp_cells = floor($num_rows % 10);
		 
		 $result_cols = $table_cols+$table_exp_cells;
		 // if($table_exp_cells == 0)
		 // {
			 // $result_cols = $table_cols;
		 // }
		 // else
		 // {
			 // $result_cols = $table_cols++;
		 // }
		 ?>
		 <script type="text/javascript">
		 loadTbl();
		function loadTbl()
		{
			
			var i = 0;
			var j = 0;
			var row ;
			var table = document.getElementById('modules_tbl');
			var cell;

			for(i = 0; i < 10; i++)
			{
				row = table.insertRow(i);
				for(j = 0; j < <?php echo $result_cols?>; j++)
				{
					cell = row.insertCell(j);
				}
			}
		}
		 </script>
		 <?php
			while($row1 = $result1->fetch_assoc())
			{
				if($cnt == 10)
				{
					$cnt = 0;
					$col_cnt++;
					$val = "<input type='checkbox' id='chkl' name='chkl[]' value='".$row1['id']."'>".$row1['module_name']."</input>";
					?>
					<script>
						insertTableCell("<?php echo $val?>", <?php echo $cnt?>, <?php echo $col_cnt?>);
						function insertTableCell(val, rw, col)
						{
							
							 var value_obt = val;
							 var res_row = rw;
							 var res_col = col;
							 var table2 = document.getElementById('modules_tbl');
							 table2.rows[res_row].cells[res_col].innerHTML = value_obt;
						}
					</script>
					<?php
				}
				else
				{
					$val = "<input type='checkbox' id='chkl' name='chkl[]' value='".$row1['id']."'>".$row1['module_name']."</input>";
					?>
					<script>
						insertTableCell("<?php echo $val?>", <?php echo $cnt?>, <?php echo $col_cnt?>);
						function insertTableCell(val, rw, col)
						{
							
							 var value_obt = val;
							 var res_row = rw;
							 var res_col = col;
							 var table2 = document.getElementById('modules_tbl');
							 table2.rows[res_row].cells[res_col].innerHTML = value_obt;
						}
					</script>
					<?php
				}
				$cnt++;
			}
			echo "</table></div></div>";
	?>     
				
				</div>
				</div>
				
	
		    <div class="col-md-4" style="visibility:hidden;"><div class="form-group">
       
            <div class='input-group date'  >
                <input type='text' class="form-control" name='datetimepicker11' id='datetimepicker11'/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar">
                    </span>
                </span>
            </div>
        </div>
    </div>
    <script>
        $(function () {
			// alert();
            $('#datetimepicker11').datetimepicker({
				format: 'YYYY-MM-DD HH:mm:ss',
                daysOfWeekDisabled: [0, 6]
            });
        });
    </script>					
							
							
		<div class="col-md-4" style="margin-left: 2px;"><div class="form-group" style="margin-top: 0px;">
			    
			    
                
		<button id="btn_save" type="submit" class="btn btn-primary btn-lg" name="btn_save">Save</button></div></div></div></div>
                                    </div>
                                


                    </div>
                </div>
            </form>
        </div>
    </div>
    
<?php include('view_mapping_modules.php'); ?>

<style>
label#required:after {content: " *"; color: red;}

</style>
	 

	</body>
</html>
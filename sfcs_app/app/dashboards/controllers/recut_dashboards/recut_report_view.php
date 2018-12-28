<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
?>
<style id="Book4_5113_Styles">
th{ color : black;}
td{ color : black;}
.black{
	text-align : right;
	font-weight : bold;
	color : #000;
}
</style>
<script type='text/javascript'>
function show_pop1(){
	if($('#style').val() == 'NIL' )
		sweetAlert('Please select the following in ORDER','STYLE -> SCHEDULE -> COLOR -> CATEGORY','warning');
}
function show_pop2(){
	if($('#schedule').val() == 'NIL' )
		sweetAlert('Please select the following in ORDER','STYLE -> SCHEDULE -> COLOR -> CATEGORY','warning');
}
function show_pop3(){
	if($('#color').val() == 'NIL' )
		sweetAlert('Please select the following in ORDER','STYLE -> SCHEDULE -> COLOR -> CATEGORY','warning');
}

function firstbox()
{
	window.location.href ="<?php echo 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value;
}


function secondbox()
{
	window.location.href ="<?php echo 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value
}
function thirdbox()
{
	window.location.href ="<?php echo 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
}
function fourthbox()
{
	window.location.href ="<?php echo 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&category="+document.test.category.value
}
</script>

<?php 
$url3 = $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R');
include("$url3"); 
?>

<?php 
// $url4 =  $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'menu_content.php',2,'R');
// include("$url4"); 
?>

<?php
$style=$_GET['style'];
$schedule=$_GET['schedule']; 
$color=$_GET['color'];
$category=$_GET['category'];

if(isset($_POST['style']))
{
	$style=$_POST['style'];
}

if(isset($_POST['schedule']))
{
	$schedule=$_POST['schedule'];
}

if(isset($_POST['color']))
{
	$color=$_POST['color'];
}

if(isset($_POST['category']))
{
	$category=$_POST['category'];
}
?>

<div class='panel panel-primary'>
	<div class="panel-heading">
		<b>Recut Issue Details</b>
	</div>
	<div class="panel-body">
		<form method="post" name="test" action="?r=<?= $_GET['r'] ?>">
			<div class="col-sm-2 form-group">
				<label for='style'>Select Style</label>
				<select class='form-control' name='style' id='style' onchange='firstbox()'>
				<?php
					echo "<option value=\"NIL\" selected>Select Style</option>";
					//$sql="select distinct order_style_no from bai_orders_db";
					$sql="SELECT DISTINCT style as order_style_no FROM bai_pro3.`rejections_log`";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_result);

					while($sql_row=mysqli_fetch_array($sql_result))
					{
						if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
						{
							echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
						}
						else
						{
							echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
						}
					}
				echo "</select>";
				?>	
			</div>
			<div class="col-sm-2 form-group">
				<label for='schedule'>Select Schedule</label>
				<select class='form-control' name='schedule' id='schedule' onclick='show_pop1()' onchange='secondbox();' >
				<?php
					echo "<option value=\"NIL\" selected>Select Schedule</option>";	
					//$sql="select distinct order_del_no from bai_orders_db where order_style_no=\"$style\"";
                    $sql="select distinct schedule as order_del_no from $bai_pro3.rejections_log where style =\"$style\"";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_result);

					while($sql_row=mysqli_fetch_array($sql_result))
					{
						if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule))
						{
							echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
						}
						else
						{
							echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
						}
					}
					echo "</select>";
				?>
			</div>	
			<div class="col-sm-2 form-group" >
				<label for='color'>Select Color:</label>
				<select class='form-control' name='color' id='color' onclick='show_pop2()' onchange='thirdbox();' >
				<?php
					//$sql="select distinct order_col_des from bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
					$sql="select distinct color as order_col_des from $bai_pro3.rejections_log where  style=\"$style\" and schedule=\"$schedule\"";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_result);
					echo "<option value=\"All\" selected>All</option>";
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color))
						{
							echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
						}
						else
						{
							echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
						}
					}
                echo "</select>";
            ?>
            </div>
            </br>
            <div class="col-sm-2 form-group">
            <?php
                echo "<input class='btn btn-success' type=\"submit\" value=\"Get Details\" name=\"submit\">";
            ?>
            </div>
		</form>
    </div>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header">Recut Detailed View
                <button type="button" class="close btn btn-danger btn-sm pull-right"  id = "cancel" data-dismiss="modal">Cancel</button>
            </div>
            <div class="modal-body" id='main-content'>
                <div class="ajax-loader" class="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;display:none;">
                                <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal1" role="dialog">
    <form action="index.php?r=<?php echo $_GET['r']?>" name= "approve" method="post" id="approve" onsubmit='return validationfunction();'>
        <div class="modal-dialog" style="width: 80%;  height: 100%;">
            <div class="modal-content">
                <div class="modal-header">Markers view
                <button type="button" class="btn btn-danger" value="Close" id = "cancel" data-dismiss="modal" style="float: right;">Close</button>
                </div>
                <div id='pre'>
                    <div class="modal-body">
                        <div class='panel-body' id="dynamic_table_panel">
                            <div class="ajax-loader" class="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;display:none;">
                                        <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
                            </div>
                            <div id ="dynamic_table1"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
if(isset($_POST['submit']))
{
    $style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
    ?><div class='row'>
        <div class='panel panel-primary'>
            <div class='panel-heading'>
                <b>Re Cut Issue Dashboard</b>
            </div>
            <div class='panel-body'>
            <table class = 'col-sm-12 table-bordered table-striped table-condensed' id='myTable'><thead><th>S.No</th><th>Recut Docket Number</th><th>Style</th><th>Schedule</th><th>Color</th><th>Rejected quantity</th><th>Recut Raised Quantity</th><th>Recut Reported Quantity</th><th>Issued Quantity</th><th>Remaining Quantity</th><th>View</th><th>Markers</th>
                </thead>
                <?php  
				$s_no = 1;
				if($color == 'All')
				{
					$blocks_query  = "SELECT SUM(rejected_qty)as rejected_qty,parent_id as doc_no,SUM(recut_qty)as recut_qty,SUM(recut_reported_qty) as recut_reported_qty,SUM(issued_qty)as issued_qty,r.`mk_ref`,b.`style_id`AS style,b.`order_col_des` AS color,b.`order_del_no` as schedule,fabric_status
					FROM `bai_pro3`.`recut_v2_child` rc 
					LEFT JOIN bai_pro3.`recut_v2` r ON r.doc_no = rc.`parent_id`
					LEFT JOIN bai_pro3.`bai_orders_db` b ON b.order_tid = r.`order_tid`
					where style_id='$style' and order_del_no='$schedule'
					GROUP BY parent_id";
				}
				else
				{
					$blocks_query  = "SELECT SUM(rejected_qty)as rejected_qty,parent_id as doc_no,SUM(recut_qty)as recut_qty,SUM(recut_reported_qty) as recut_reported_qty,SUM(issued_qty)as issued_qty,r.`mk_ref`,b.`style_id`AS style,b.`order_col_des` AS color,b.`order_del_no` as schedule,fabric_status
					FROM `bai_pro3`.`recut_v2_child` rc 
					LEFT JOIN bai_pro3.`recut_v2` r ON r.doc_no = rc.`parent_id`
					LEFT JOIN bai_pro3.`bai_orders_db` b ON b.order_tid = r.`order_tid`
					where style_id='$style' and order_del_no='$schedule' and order_col_des='$color'
					GROUP BY parent_id";
				}
                // echo $blocks_query;
				$blocks_result = mysqli_query($link,$blocks_query) or exit('Rejections Log Data Retreival Error'); 
				if($blocks_result->num_rows > 0)
            	{       
					while($row = mysqli_fetch_array($blocks_result))
					{
						$id = $row['doc_no'];
						echo "<tr><td>$s_no</td>";
						echo "<td>".$row['doc_no']."</td>";
						echo "<td>".$row['style']."</td>";
						echo "<td>".$row['schedule']."</td>";
						echo "<td>".$row['color']."</td>";
						echo "<td>".$row['rejected_qty']."</td>";
						echo "<td>".$row['recut_qty']."</td>";
						echo "<td>".$row['recut_reported_qty']."</td>";
						echo "<td>".$row['issued_qty']."</td>";
						echo "<td>".$rem_qty."</td>";
						echo "<td><button type='button'class='btn btn-primary' onclick='viewrecutdetails(".$id.")'>View</button></td>";
						echo "<td><button type='button'class='btn btn-success' onclick='viewmarkerdetails(".$id.",2)'>Marker View</button></td>";
						echo "</tr>";
						$s_no++;
					}
				}
				else
				{
					echo "<tr><td colspan='12' style='color:red;text-align: center;'><b>No Details Found!!!</b></td></tr>";
				}
                ?>
                </table>
            </div>
        </div>
   </div>
<?php
}
?>
<script>
function viewrecutdetails(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $('.loading-image').show();
    $('#myModal').modal('toggle');
    $.ajax({

			type: "POST",
			url: function_text+"?recut_doc_id="+id,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('main-content').innerHTML = response;
                $('.loading-image').hide();
            }

    });

}
function viewmarkerdetails(id,flag)
{
    $('#myModal1').modal('toggle');
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    var id_array = [id,flag];
    $('.loading-image').show();
    $.ajax({

			type: "POST",
			url: function_text+"?markers_view_docket="+id_array,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('dynamic_table1').innerHTML = response;
                $('.loading-image').hide();
               
            }

    });

}
</script>

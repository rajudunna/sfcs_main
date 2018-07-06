<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
<title>Generate bundles</title>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />

-->
<link rel="stylesheet" href="cssjs/bootstrap.min.css">
<link rel="stylesheet" href="cssjs/select2.min.css">
<link rel="stylesheet" href="cssjs/font-awesome.min.css">
<script type="text/javascript" src="cssjs/jquery.min.js"></script>
<script type="text/javascript" src="cssjs/select2.min.js"></script>
<script src="cssjs/bootstrap.min.js"></script>
<script>
    var url1 = '<?= getFullUrl($_GET['r'],'form.php','N'); ?>';
    function reload_style(){
        console.log('welcome');
        var style_id=document.getElementById('style_id').value;
        window.location.href =url1+"&style_id="+style_id
    }
	function reload_schedule(){
        var schedule_num=document.getElementById('schedule_id').value;
		var style_id=document.getElementById('style_id').value;
        window.location.href =url1+"&style_id="+style_id+"&schedule="+schedule_num
    }
	function reload_color(){
		var style_id=document.getElementById('style_id').value;
        var schedule_num=document.getElementById('schedule_id').value;
		var color_num=document.getElementById('color_id').value;
        window.location.href =url1+"&style_id="+style_id+"&schedule="+schedule_num+"&color="+encodeURI(color_num)
    }
	function reload_cut(){
		var style_id=document.getElementById('style_id').value;
        var schedule_num=document.getElementById('schedule_id').value;
		var color_num=document.getElementById('color_id').value;
		var cut_num=document.getElementById('cut_id').value;
        window.location.href =url1+"&style_id="+style_id+"&schedule="+schedule_num+"&color="+encodeURI(color_num)+"&cut="+cut_num
    }
</script> 
<style type="text/css">
    .bs-example{
    	margin: 20px;
    }

</style>
</head>
<body>
	<?php
		error_reporting(0);
		// include("dbconf.php");
		// include("..".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include("..".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
$has_permission=haspermission($_GET['r']);
		

		//include("generate_bundles.php");
		/*getting style codes*/
		$style_codes="SELECT DISTINCT trim(order_style_no) as order_style_no FROM $bai_pro3.bai_orders_db_confirm";
		$style_result=mysqli_query($link,$style_codes);
		//echo "Style rows :".mysqli_num_rows($style_result)."</br>";

			$style=$_GET['style_id'];
			//echo "style : ".$style."</br>";
			$schedule=$_GET['schedule'];
			//echo "schedule : ".$schedule."</br>";
			$color=$_GET['color'];
		//echo "color : ".$color."</br>";
		
		/*getting schedule codes*/
		if($style!=''){
			$schedule_codes="select distinct trim(order_del_no) as order_del_no from $bai_pro3.bai_orders_db_confirm where trim(order_style_no)='$style'";
		}else{
			$schedule_codes="select distinct trim(order_del_no) as order_del_no from $bai_pro3.bai_orders_db_confirm";
		}
		$schedule_result=mysqli_query($link,$schedule_codes);
		//echo "Schedule rows :".mysqli_num_rows($schedule_result)."</br>";
		
		/*getting color codes*/
		if(($style != '')&&($schedule != '')){
			$color_codes="select distinct trim(order_col_des) as order_col_des from $bai_pro3.bai_orders_db_confirm where trim(order_style_no)='$style' and trim(order_del_no)='$schedule'";
		}else{
			$color_codes="select distinct trim(order_col_des) as order_col_des from $bai_pro3.bai_orders_db_confirm";
		}
		//echo "Color Qry :".$color_codes."</br>";
		$color_result=mysqli_query($link,$color_codes);
		//echo "Color rows :".mysqli_num_rows($color_result)."</br>";
		
		/*getting cut no's */
		if(($style != '')&&($schedule != '')&&($color != '')){
			
			//$ordertid_qry="select distinct trim(order_tid) as order_tid from $bai_pro3.bai_orders_db_confirm where trim(order_style_no)='$style' and trim(order_del_no)='$schedule' and trim(order_col_des)='$color'";
			
			// $pcutno_qry="SELECT distinct TRIM(pcutno) as pcutno FROM $bai_pro3.plandoc_stat_log WHERE order_tid in (SELECT order_tid FROM $bai_pro3.bai_orders_db_confirm WHERE TRIM(order_style_no)='$style' AND TRIM(order_del_no)='$schedule' AND TRIM(order_col_des)='$color') and cat_ref in (select tid from $bai_pro3.cat_stat_log where order_tid in (SELECT order_tid FROM $bai_pro3.bai_orders_db_confirm WHERE TRIM(order_style_no)='$style' AND TRIM(order_del_no)='$schedule' AND TRIM(order_col_des)='$color') and category in ('Body','Front'))";
			$pcutno_qry="SELECT doc_no,pcutno,category FROM $bai_pro3.order_cat_doc_mix WHERE TRIM(order_style_no)='$style' AND TRIM(order_del_no)='$schedule' AND TRIM(order_col_des)='$color' and category in ($in_categories)";
			$pcutno_result=mysqli_query($link,$pcutno_qry);

		}
		// echo $pcutno_qry;
		// die();
		// echo "pcutno_qry :".$pcutno_qry."</br>";
		//echo "cut result rows :".mysqli_num_rows($pcutno_result)."</br>";
		//$pcutno_result_row = mysqli_fetch_assoc($pcutno_result);
		//echo "Order tid : ".$ordertid_row['order_tid']."</br>";
		
		/*getting all parameters through docket no*/
		if(isset($_GET['docket_no'])){
			
			$docket_num=$_GET['docket_no'];
			echo "Getting Docket : ".$docket_num;
			
			/*Getting parameters through plandoc statlog*/
			$plandocstat_qry="SELECT TRIM(bai_orders_db_confirm.order_style_no) AS order_style_no,TRIM(bai_orders_db_confirm.order_del_no) AS order_del_no,TRIM(bai_orders_db_confirm.order_col_des) as order_col_des,TRIM(plandoc_stat_log.pcutno) AS pcutno FROM $bai_pro3.bai_orders_db_confirm LEFT JOIN $bai_pro3.plandoc_stat_log ON TRIM(bai_orders_db_confirm.order_tid)=TRIM(plandoc_stat_log.order_tid) WHERE TRIM(plandoc_stat_log.doc_no)=$docket_num";
			echo "Plandoc qry : ".$plandocstat_qry."</br>";
			$plandocstat_result=mysqli_query($link,$plandocstat_qry);
			echo "Docket rows :".mysqli_num_rows($plandocstat_result)."</br>";
			//$pcutno_result_row = mysqli_fetch_assoc($pcutno_result);
			if (mysqli_num_rows($plandocstat_result)>0){
			  while($styles = mysqli_fetch_array($plandocstat_result)) {
				 echo  "bdsjdshj".$styles->order_style_no;
				 
			  }
			}
		}
		
		
		//This is only for sending values for generate bundles through function calling
		if((isset($_GET['style_id'])) AND (isset($_GET['schedule_id'])) AND (isset($_GET['color_id'])) AND (isset($_GET['cut_id']))){
			// echo "Style : ".$_GET['style_id']." - Schedule : ".$_GET['schedule_id']." - Color : ".$_GET['color_id']." - Cut : ".$_GET['cut_id'];
				if(($_GET['style_id'] !='') AND ($_GET['schedule_id'] !='') AND ($_GET['color_id'] !='') AND ($_GET['cut_id'] !='')){
					$style=$_GET['style_id'];
					$schedule=$_GET['schedule_id'];
					$color=$_GET['color_id'];
					$cut_num=$_GET['cut_id'];
					
					$validate_qry="SELECT act_cut_status FROM $bai_pro3.plandoc_stat_log WHERE order_tid=(SELECT order_tid FROM $bai_pro3.bai_orders_db_confirm WHERE order_style_no='$style' AND order_del_no='$schedule' AND order_col_des='$color') and pcutno='$cut_num'";
					
					$validate_qry_result=mysqli_query($link,$validate_qry);
					while($cut_status_res = mysqli_fetch_array($validate_qry_result)){
							$cut_status=$cut_status_res['act_cut_status'];
						}
					//validating cut qty done or not
					if($cut_status!='DONE'){
						
						echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color='red'>Cut Quantity Not Updated for this selection</font></h1></center></div>";
						echo "<div id=\"msg\"><a href='/ff/projects/beta/bundle_track/sewing_orders/form.php'><center><br/><br/><br/><h3><font color='blue'>Back to Previous Screen</font></h3></center></a></div>";
						exit;
					
					}else{
						include('generate_bundles.php');
						generate_bundles($style,$schedule,$color,$cut_num);
						
					}
					
				}else{
					echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color='red'>Please Select All Fields</font></h1></center></div>";
					echo "<div id=\"msg\"><a href='/ff/projects/beta/rm_projects/bai_rm_pj1/insert_v1.php'><center><br/><br/><br/><h3><font color='blue'>Back to Stock In Screen</font></h3></center></a></div>";
				}	
		}
	   
	?>

	<div class="bs-example">
		<div class='container'>
	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Generate Bundles Here :</strong></div>
		<div class="panel-body">
	</div>

	<div class="bs-example">
		<form class="form-inline" action="getting_values.php" method="GET">
		<!--<form class="form-inline"  method="GET">-->
			<div class="form-group">
			<font color = 'black'><b>Style  :  </b></font>
				
				<?php
					echo '<select class="form-control selectpicker" id="style_id" name="style_id" onchange="reload_style();" data-live-search="true">
					<option value="">Please Select</option>';
					if(mysqli_num_rows($style_result)>0){
						while($styles = mysqli_fetch_array($style_result)) {
							$style_number=$styles['order_style_no'];
						   // $style_id=$style_number;
							if(trim($style_number)==$_GET['style_id']){
							   echo "<option value=".$style_number." selected>".$style_number."</option>";
							}else{
								echo "<option value=".$style_number.">".$style_number."</option>";
							}
						}
					}else{
						echo "No Styles Found";
					}
					echo "</select>";
				   
				?>
			</div>
			<div class="form-group">
				<font color = 'black'><b>Schedule :  </b></font>
				<?php
					echo '<select class="form-control selectpicker" id="schedule_id" name="schedule_id" onchange="reload_schedule();" data-live-search="true">
					      <option value="">Please Select</option>';
					if(mysqli_num_rows($schedule_result)>0){
						while($styles = mysqli_fetch_array($schedule_result)) {
							$schedule_number=$styles['order_del_no'];
						   // $style_id=$style_number;
							if(trim($schedule_number)==$_GET['schedule']){
							   echo "<option value=".$schedule_number." selected>".$schedule_number."</option>";
							}else{
								echo "<option value=".$schedule_number.">".$schedule_number."</option>";
							}
						}
						if(isset($_GET['schedule'])){
									$redirect_check1=1;
								}else{
									$redirect_check1=0;
								}
							if(mysqli_num_rows($schedule_result)==1 && $redirect_check1==0){
								echo "<script>reload_schedule();</script>";
							}
					}else{
						echo "No Styles Found";
					}
					echo "</select>";
				?>
			</div>
			<div class="form-group">
				<font color = 'black'><b>Color  : </b></font>
				<!--<input type="text" class="form-control" id="color_id" name="color_id" required>-->
				<?php
					echo '<select class="form-control selectpicker" id="color_id" name="color_id" onchange="reload_color();" data-live-search="true">
					      <option value="">Please Select</option>';
					if(mysqli_num_rows($color_result)>0){
						while($colors = mysqli_fetch_array($color_result)) {
							$color_number=$colors['order_col_des'];
						   // $style_id=$style_number;
							if(trim($color_number)==$_GET['color']){
							   echo "<option value='".$color_number."' selected>".$color_number."</option>";
							}else{
								echo "<option value='".$color_number."'>".$color_number."</option>";
							}
						}
						if(isset($_GET['color'])){
								$redirect_check=1;
							}else{
								$redirect_check=0;
							}
						if(mysqli_num_rows($color_result)==1 && $redirect_check==0){
							echo "<script>reload_color();</script>";
						}
					}else{
						echo "No Styles Found";
					}
					echo "</select>";
				?>
			</div>
			<div class="form-group" >
				<font color = 'black'><b>Cut No's  : </b></font>
				<!--<input type="text" class="form-control" id="color_id" name="color_id" required>-->
				<?php
					echo '<select class="form-control selectpicker" id="cut_id" name="cut_id" onchange="reload_cut();" data-live-search="true">
					<option value="">Please Select</option>';
					if(mysqli_num_rows($pcutno_result)>0){
						while($colors = mysqli_fetch_array($pcutno_result)) {
							$cut_number=$colors['pcutno'];
						   // $style_id=$style_number;
							if(trim($cut_number)==$_GET['cut']){
							   echo "<option value=".$cut_number." selected>".$cut_number."</option>";
							}else{
								echo "<option value=".$cut_number.">".$cut_number."</option>";
							}
						}
					}else{
						echo "No Cut no's Found";
					}
					echo "</select>";
				?>
				
			</div>
			<?php if(in_array($authorized,$has_permission))
					{ ?><button type="submit" class="btn btn-primary" style="margin-bottom: -17px;">Submit</button>
				<?php } ?>
				
		</form>
		<br>
	</div>


	<!--<div class="bs-example">
		<h4> OR </h4>
	</div>

	<div class="bs-example">
		<form class="form-inline" action="form.php" method="GET">
			Enter Docket No : 
				<input type="text" class="form-control" id="docket_no" name="docket_no" placeholder="Docket No" required>
				<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>-->	
</body>
</html>                            
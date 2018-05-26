<html>
<div class="ajax-loader" id="process">
		<img src='ajax-loader.gif' class="img-responsive" />
	</div>
</html>
<style>
#process{
	color:red;
}
</style>

<?php
		
		//This is only for sending values for generate bundles through functin calling
		error_reporting(0);
		if((isset($_GET['style_id'])) AND (isset($_GET['schedule_id'])) AND (isset($_GET['color_id'])) AND (isset($_GET['cut_id']))){
			//echo "Style : ".$_GET['style_id']." - Schedule : ".$_GET['schedule_id']." - Color : ".$_GET['color_id']." - Cut : ".$_GET['cut_id'];
			$style=$_GET['style_id'];
			$schedule=$_GET['schedule_id'];
			$color=$_GET['color_id'];
			//echo $color."</br>";
			$cut_num=$_GET['cut_id'];
			include('generate_bundles.php');
			echo "<script>document.getElementById('process').style.display='none';</script>";
			generate_bundles($style,$schedule,$color,$cut_num); 
			
		}else{
			header('/ff/projects/beta/bundle_track/sewing_orders/form.php');
		}
?>	
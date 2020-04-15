<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/php/functions.php',4,'R')); ?>
<?php  ?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/header_scripts.php',4,'R'));?>

<script type="text/javascript" >
	function dodisable()
	{
		enableButton();
		document.input.order_tid.style.visibility="hidden"; 
		document.input.cat_tid.style.visibility="hidden"; 
	}

	function verify_nums(t,e){
		if(e.keyCode == 8 || e.keyCode == 9){
				return;
			}

		var c = /^[0-9]+$/;
		var id = t.id;
		var qty = document.getElementById(id);

		if( !(qty.value.match(c)) && qty.value!=null){
			//sweetAlert('Please Enter Only Numbers','','warning');
			qty.value = qty.value.replace(/[^0-9]/g,'');
			qty.value = 0;
			return false;
		}
	}

	function verify_spec(e)
	{
		var pver = document.getElementById('patt_ver').value;
		document.getElementById('patt_ver').value = pver.replace('"','').replace("'","");
		return true;
	}

	function enableButton() 
	{
		if(document.getElementById('option').checked)
		{
			document.getElementById('update').disabled='';
		} 
		else 
		{
			document.getElementById('update').disabled='true';
		}
	}
</script>

<!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->



<body onload="javascript:dodisable();">
<?php 
if(isset($_GET['cat_tid']))
{
	$cat_tid=$_GET['cat_tid'];
	$get_color=$_GET['color'];
	$get_style=$_GET['style'];
	$get_schedule=$_GET['schedule'];
	// echo "Cat Tid = ".$cat_tid.'<br>';

	$colors_array = array();	$array1= array();	$array2= array();
	$sql="select order_tid from $bai_pro3.cat_stat_log where tid='$cat_tid'";
	// echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$sql="select order_del_no,order_style_no,order_col_des from $bai_pro3.bai_orders_db where order_tid='".$sql_row['order_tid']."'";
		// echo $sql."<br>";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$color=$sql_row['order_col_des'];
			$style=$sql_row['order_style_no'];
			$schedule=$sql_row['order_del_no'];
		}
	}

	$sql_colors="select order_col_des from $bai_pro3.bai_orders_db where order_del_no = '$schedule' and order_style_no = '$style' and order_joins = 0";
	// echo $sql_colors.';<br>';
	$result3 = mysqli_query($link,$sql_colors) or exit("Unable to get the color codes");
	while($row = mysqli_fetch_array($result3))
	{
		$colors_array[] = $row['order_col_des'];
	}

	if (count($colors_array) > 0)
	{
		foreach($colors_array as $key=>$color_value )
		{
			$ops_master_sql = "select operation_code as operation_code FROM $brandix_bts.tbl_style_ops_master where style='$style' and color='$color_value' and default_operration='yes' group by operation_code";
			// echo $ops_master_sql;
			$result2_ops_master_sql = mysqli_query($link,$ops_master_sql)
								or exit("Error Occured : Unable to get the Operation Codes");
			while($row_result2_ops_master_sql = mysqli_fetch_array($result2_ops_master_sql))
			{
				$array1[] = $row_result2_ops_master_sql['operation_code'];
			}
			
			$sql1 = "select OperationNumber FROM $bai_pro3.schedule_oprations_master where Style='$style' and Description ='$color_value' and ScheduleNumber='$schedule' group by OperationNumber";
			// echo $sql."<br>";
			$result1 = mysqli_query($link,$sql1)  
				or exit("Error Occured : Unable to get the Operation Codes");;
		
			while($row = mysqli_fetch_array($result1))
			{
				$array2[] = $row['OperationNumber'];
			}

			if(sizeof($array1) == 0 || sizeof($array2) == 0){
				echo "<script>swal('Operations Doesnt exist','Please Check the backend Job','danger');</script>";
				echo "<script>setTimeout(function() {
						location.href = \"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=$get_color&style=$get_style&schedule=$get_schedule\";
						},3000);
					</script>";
				exit();
			}

			$compare12 = array_diff($array1,$array2);
			$compare21 = array_diff($array2,$array1);
			if(count($compare12) > 0 || count($compare21) > 0)
			{
				echo "<script>swal('Operation codes does not match','','warning');</script>";
				$url = getFullUrlLevel($_GET['r'],'test.php',0,'N');
				echo "<script>setTimeout(function() {
						location.href = \"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=$get_color&style=$get_style&schedule=$get_schedule\";
						},3000);
					</script>";
				exit();
			}
			$mo_query = "SELECT * from $bai_pro3.mo_details where schedule='$schedule' and 
						color='$color_value'  and style='$style' limit 1";
			$mo_result = mysqli_query($link,$mo_query);	
			if(!mysqli_num_rows($mo_result) > 0){
				echo "<script>swal('MO Details Does not Exist','','warning');</script>";
				echo "<script>setTimeout(function() {
						location.href = \"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=$get_color&style=$get_style&schedule=$get_schedule\";
						},3000);
					</script>";
				exit();
			}		
		}
	}
}
echo "<div class=\"col-md-8\"><a class=\"btn btn-xs btn-warning\" href=\"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=$get_color&style=$get_style&schedule=$get_schedule\"><i class=\"fas fa-arrow-left\"></i>&nbsp; Click here to Go Back</a></div></br></br>"; ?>
<div class="panel panel-primary">
<div class="panel-heading">Order Category Classification FORM</div>
<div class="panel-body">

<form method="post" name="input" action="<?php echo getFullURL($_GET['r'], "order_cat_edit_form.php", "N"); ?>">
	<?php
		echo "<input type=\"hidden\" class=\"form-control\" name=\"get_style\" value=\"".$get_style."\">";
		echo "<input type=\"hidden\" class=\"form-control\" name=\"get_schedule\" value=\"".$get_schedule."\">";
		echo "<input type=\"hidden\" class=\"form-control\" name=\"get_color\" value=\"".$get_color."\">";

		$sql="select * from $bai_pro3.cat_stat_log where tid=\"$cat_tid\"";
		//echo "Cat Stat Log : ".$sql."</br>";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);

		while($sql_row=mysqli_fetch_array($sql_result))
		{
			//echo "<div class=\"col-sm-12\">";
			echo "<input type=\"hidden\" class=\"form-control\" name=\"order_tid\" value=\"".$sql_row['order_tid']."\">"; 
			echo "<input type=\"hidden\" class=\"form-control\" name=\"cat_tid\" value=\"".$cat_tid."\">";
			echo "<input type=\"hidden\" class=\"form-control\" name=\"col_des\" value=\"".$sql_row['col_des']."\">";
			//echo "</div>";

			echo "<div class=\"table-responsive\"><table class=\"table table-striped jambo_table bulk_action\"><tbody>";
			echo "<tr><th class=\"column-title\" style=\"color: #000000;\">Fab Code</th><td class=\"  \">:</td><div class=\"col-md-4\"><td class=\"  \">".$sql_row['compo_no']."</div></td>";
			echo "<tr><th class=\"column-title\" style=\"color: #000000;\">Fab Description</th><td class=\"  \">:</td><div class=\"col-md-4\"><td class=\"  \">".$sql_row['fab_des']."</div></td>";
			echo "<tr><th class=\"column-title\" style=\"color: #000000;\">Consumption</th><td class=\"  \">:</td><div class=\"col-md-4\"><td class=\"  \"><input type=\"hidden\" class=\"form-control\" name=\"consumption\" id=\"consumption\" value=\"".$sql_row['catyy']."\">".$sql_row['catyy']."</div></td>";
			echo "<tr><th class=\"column-title\" style=\"color: #000000;\">Date</th><td class=\"  \">:</td><td class=\"  \"><div class=\"col-md-4\"><INPUT class=\"form-control\" type=\"text\" data-toggle='datepicker' required name=\"in_date\" value=";if($sql_row['date']=="0000-00-00"){echo date("Y-m-d");}else{echo $sql_row['date'];} 
			echo "></div></td>";
			$sql4="select * from $bai_pro3.tbl_category where status='1'";
			$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			echo "<tr><th class=\"column-title\" style=\"color: #000000;\">Category</th><td class=\"  \">:</td><td class=\"  \"><div class=\"col-md-4\"><select class=\"form-control\" required name=\"in_cat\" id=\"in_cat\">";
			while($sql_row4=mysqli_fetch_array($sql_result4))
			{
				if($sql_row['category']==$sql_row4['cat_name'])
				{
					$select="selected";
				}		
				echo "<option value='".$sql_row4['cat_name']."' $select >".$sql_row4['cat_name']."</option>";
				$select="";
			}
			
			echo "</select></div></td></tr>";

			echo "<tr><th class=\"column-title\" style=\"color: #000000;\">Pur Width</th><td class=\"  \">:</td><td class=\"  \"><div class=\"col-md-4\"><input class=\"form-control float\" required type=\"text\"  name=\"in_width\" id='in_width' value=\"".$sql_row['purwidth']."\"></div></td></tr>";
			echo "<tr><th class=\"column-title\" style=\"color: #000000;\">Pattern Ver</th><td class=\"  \">:</td><td class=\"  \">
			<div class=\"col-md-4\">
			<input class='form-control' onkeyup=\"return verify_spec(event)\"  type=\"text\"  name=\"patt_ver\" id='patt_ver' value=\"".$sql_row['patt_ver']."\"  required >
			</div></td></tr>";
			echo "<tr><th class=\"column-title\" style=\"color: #000000;\">Binding Consumption</th><td class=\"  \">:</td><td class=\"  \">
			<div class=\"col-md-4\">
			<input class='form-control float' type=\"text\" name=\"binding_consumption\" id=\"binding_consumption\"  value=\"".$sql_row['binding_consumption']."\"  required >
			</div><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id=\"seperate_docket\"><input type=\"checkbox\" name=\"seperate_docket\" id=\"seperate_doc\" value='1'>Generate Separate Docket For Binding</span></td></tr>";

			echo "<tr><th class=\"column-title\" style=\"color: #000000;\">Gmt Way</th><td class=\"  \">:</td><td class=\"  \"><div class=\"col-md-4\"><select class=\"form-control\" name=\"gmt_way\">";
			echo "<option value=\"N\""; if($sql_row['gmtway']=='N'){ echo "selected"; } echo ">All Gmt One Way</option>";
			echo "<option value=\"Y\""; if($sql_row['gmtway']=='Y'){ echo "selected"; } echo ">One Gmt One Way</option>";
			echo "</select></div></td></tr>";

			echo "<tr><th class=\"column-title\" style=\"color: #000000;\">Strip Match</th><td class=\"  \">:</td><td><div class=\"col-md-4\"><select class=\"form-control\" name=\"strip_match\">";
			echo "<option value=\"N\""; if($sql_row['strip_match']=='N'){ echo "selected"; } echo ">NO</option>";
			echo "<option value=\"Y\""; if($sql_row['strip_match']=='Y'){ echo "selected"; } echo ">YES</option>";
			echo "</select></div></td></tr>";

			echo "<tr><th class=\"column-title\" style=\"color: #000000;\">Gusset Seperation</th><td class=\"  \">:</td><td><div class=\"col-md-4\"><select class=\"form-control\" name=\"guess_sep\">";
			echo "<option value=\"N\""; if($sql_row['gusset_sep']=='N'){ echo "selected"; } echo ">NO</option>";
			echo "<option value=\"Y\""; if($sql_row['gusset_sep']=='Y'){ echo "selected"; } echo ">YES</option>";
			echo "</select></div></td></tr>";

			/* echo "<tr><td>Remarks</td><td>:</td><td> <INPUT type=\"text\" name=\"remarks\" value=\"".$sql_row['remarks']."\"></td></tr>"; */

			echo "</tbody></table></div>";
			//echo "<center><input class=\"form-check-input\" type=\"checkbox\" name=\"option\"  id=\"option\" onclick=\"javascript:enableButton();\">Enable";
			echo "&nbsp;&nbsp;&nbsp;<INPUT class=\"btn btn-sm btn-primary\" onclick='return verify()' TYPE = \"submit\" id='update'  Name = \"Update\" VALUE = \"Update\"></center>";
		}

	?>
</form>

<?php
	if(isset($_POST['Update']))
	{
		$get_color=$_POST['get_color'];
		$get_schedule=$_POST['get_schedule'];
		$get_style=$_POST['get_style'];
		$tran_order_tid=$_POST['order_tid'];
		$in_cat=$_POST['in_cat'];
		if($_POST['seperate_docket'] == '1') {
			$seperate_docket = 'Yes';
		} else {
			$seperate_docket = 'No';
		}

		// var_dump($_POST);die();

		$cat_exist = verify_category($tran_order_tid,$in_cat);
		if($cat_exist == 1)
		{
			echo "<script>swal('The Category Cant Be Updated','','error')</script>";
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=$get_color&style=$get_style&schedule=$get_schedule\"; }</script>";
			exit();
		}

		$in_date=$_POST['in_date'];
		$in_width=$_POST['in_width'];
		$binding_consumption=$_POST['binding_consumption'];
		
		$patt_ver=$_POST['patt_ver'];
		$gmt_way=$_POST['gmt_way'];
		$strip_match=$_POST['strip_match'];
		$guess_sep=$_POST['guess_sep'];
		$remarks=$_POST['remarks'];
		$cat_tid=$_POST['cat_tid'];
		$col_des = $_POST['col_des'];
		$validation_query_cat = "select order_tid from $bai_pro3.cat_stat_log where tid = '$cat_tid'";
		$validation_result = mysqli_query($link, $validation_query_cat) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$result_validation_query_cat = mysqli_fetch_row($validation_result);
		$order_tid_result = $result_validation_query_cat[0];
		$sql =  "select tid,category from $bai_pro3.cat_stat_log where order_tid = '$order_tid_result'";
		$validation_sql = mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		$sql1 =  "select category from $bai_pro3.cat_stat_log where tid = '$cat_tid'";
		$validation_sql1 = mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_row1=mysqli_fetch_row($validation_sql1);
		$flag=1;
		$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\"";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);

		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$color=$sql_row['order_col_des'];
			$style=$sql_row['order_style_no'];
			$schedule=$sql_row['order_del_no'];
		}
		if($sql_row1[0] != $in_cat){
			while($sql_row=mysqli_fetch_array($validation_sql))
			{
				$cat= $sql_row['category'];
				if($cat == $in_cat)
				{
					//echo "<script>swal('Category Already selected. Please Select Other.','','warning');</script>";
					echo "<script>swal('Category Already selected. Please Select Other.')
					.then((value) => {
							location.href = '".getFullURLLevel($_GET['r'], "order_cat_edit_form.php", "0", "N")."&cat_tid=".$cat_tid."&style=".$get_style."&schedule=".$get_schedule."&color=".$get_color."'; 
					});
					</script>";
					$flag=0;
					//die();
				}
			}
		}	
		if($flag==1)
		{
			$lupdate=date("Y-m-d H:i:s");
			$sqlx="select * from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and  category=\"$in_cat\"";
			$resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_rows=mysqli_num_rows($resultx);
			if($num_rows >0)
			{
				echo "<script>swal('Mentioned \"$in_cat\" Category Already Updated ','','warning')</script>";
			}
			else
			{
				$sql="update $bai_pro3.cat_stat_log set date=\"$in_date\", category=\"$in_cat\", purwidth=$in_width, patt_ver=\"$patt_ver\", gmtway=\"$gmt_way\",binding_consumption=\"$binding_consumption\",seperate_docket=\"$seperate_docket\", strip_match=\"$strip_match\", gusset_sep=\"$guess_sep\", remarks=\"$remarks\", lastup=\"$lupdate\" where tid=$cat_tid";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		//To auto confirm orders based on initial operation to avoid size mixup.
		$order_tid=$tran_order_tid;
		$sql="select order_del_no from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
		//echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);
		//echo $sql_num_check;
		if($sql_num_check==0)
		{
			$sql="insert into $bai_pro3.bai_orders_db_confirm select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
			// echo $sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			//$sql_num_confirm=mysql_num_rows($sql_result);
		}
		if($flag == 1)
		{
			echo "<script>swal('Order category Updated Successfully','','success')</script>";
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=$get_color&style=$get_style&schedule=$get_schedule\"; }</script>";
		}
	}
?>

<?php
	//function to check for FRONT/BODY category only for a 
	function verify_category($order_tid,$in_cat){
		global $link;
		global $bai_pro3;
		global $in_categories;
		$cats = explode(',',str_replace('"','',$in_categories));
		if(in_array(strtoupper($in_cat),$cats)){
			$order_tid_query = "SELECT category from $bai_pro3.cat_stat_log where order_tid='$order_tid' and category IN ($in_categories)";
			$order_tid_result = mysqli_query($link,$order_tid_query);
			while($row = mysqli_fetch_array($order_tid_result)){
				$category[] = $row['category'];
			}
			if(count($category) == 0)
				return 0;
			foreach($category as $cat){
				if( !(strtolower($cat) == strtolower($in_cat)) )
					return 1;
			}
		}
		return 0;
	}
?>
</div>
</div>
</div>

<script>
	function verify(){
		var v = document.getElementById('in_width').value;
		var d = document.getElementById('seperate_doc').checked;
		var d_val = document.getElementById('binding_consumption').value;
		
		if(Number(v) <= 0){
			sweetAlert('Pur Width cannot be zero','','warning');
			return false;
		}
		var pat = document.getElementById('patt_ver');

		if( pat.value ==null || pat.value == 0){
			sweetAlert('Please Enter Valid Pattern Version','','warning');
			//pat.value = 0;
			return false;		
		}
		else if(d == true && d_val == 0)
		{
			sweetAlert('Please Enter Valid Binding Consuption','','warning');
			//pat.value = 0;
			return false;
		}
		
		//return false;
		return true;
	}

	$(document).ready(function(){
		$('#in_cat').on('change',function(){
			var category = $("#in_cat option:selected").val();
			
			// if(category == 'Body' || category == 'Front'){
				$("#seperate_docket").show();
			// }
			// else{
				// $("#seperate_docket").hide();
			// }

		});
		$('#binding_consumption').on('change',function(){
			var consumption = $("#consumption").val();
			var binding_consumption = $("#binding_consumption").val();
			if(binding_consumption > consumption){
				// $("#binding_consumption").val()= '';
				document.getElementById('binding_consumption').value = '';
				// alert($("#binding_consumption").val());

				sweetAlert('Binding Consumption Should be less than Consumption '+consumption,'','warning');

			}
		});
	});

</script>
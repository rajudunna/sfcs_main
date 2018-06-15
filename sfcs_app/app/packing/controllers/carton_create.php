<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R') );  ?>
<?php //include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'functions.php',1,'R')); This file is included but not at all used?>
<?php //include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'menu_content.php',1,'R')); This file is included but not at all used?>

<div class="panel panel-primary">
	<div class="panel-heading"><b>Carton Qty Create</b></div>
	<div class="panel-body">
		<form name="input" method="post" action="?r=<?= $_GET['r']; ?>">
			<table class='table table-bordered'>
				<tr>
					<?php
						echo "<td>Style: </td>";
						echo "<td>";
						echo "<select name=\"style\" id='style' onchange='style_change()' class='form-control'>";
						echo "<option value=''>Select Style</option>";
						//echo $_GET['style']."--<br>";
						//Changed on 2013-06-17 8:43 PM - Kirang
						$sql="select order_style_no,style_id from $bai_pro3.bai_orders_db_confirm group by order_style_no ";
						//$sql="select distinct style_id from bai_pro2.movex_styles order by style_id";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result);
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","", $_GET['style']))
							//if($sql_row['order_style_no']==$_GET['order_style_no'])
								echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
							else
								echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
						}
						echo "</select></td>";
					?>
	
					<?php
						if(isset($_GET['style']) && $_GET['style']){
							$sql1="select distinct order_del_no from $bai_pro3.bai_orders_db_confirm where order_style_no='".$_GET['style']."' order by order_del_no";
							//echo $sql1;die();
							mysqli_query($link, $sql1) or exit("Sql Error schedule".mysqli_error($GLOBALS["___mysqli_ston"]));
							$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error schedule".mysqli_error($GLOBALS["___mysqli_ston"]));
							$sql_num_check1=mysqli_num_rows($sql_result1);
							$schedule_apd = '';
							while($sql_row1=mysqli_fetch_array($sql_result1))
							{
								if($_GET['schedule']==$sql_row1['order_del_no'])
									$schedule_apd.="<option value=\"".$sql_row1['order_del_no']."\" selected>".$sql_row1['order_del_no']."</option>";
								else
									$schedule_apd.="<option value=\"".$sql_row1['order_del_no']."\">".$sql_row1['order_del_no']."</option>";
							}
						
					?>
					<td>&nbsp;&nbsp;Schedule: </td>
					<td>
						<select name='schedule' id='schedule' onchange='schedule_change()' class='form-control'>
							<option value=''>Select Schedule</option>
							<?php echo $schedule_apd; ?>
						</select>
					</td>
					<?php } ?>
	
				</tr>
			</table>

			<?php
			if(isset($_GET['schedule']) && isset($_GET['style']) && $_GET['schedule']!='' && $_GET['style']!=''){
				
				$sql1="select count(*) as cnt,id from $bai_pro3.carton_qty_chart where user_style = '".$_GET['style']."' and user_schedule = '".$_GET['schedule']."'";
			//mysql_query($sql1,$link) or exit("Sql Error1".mysql_error());
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check1=mysqli_num_rows($sql_result1);
			
				while($sql_row1=mysqli_fetch_array($sql_result1))
				{
					$id = $sql_row1['id'];
					$rowcont=$sql_row1['cnt'];
				}
				if($rowcont>0)
				{
					$url = getFullURL($_GET['r'],'carton_edit.php','N').'&id='.$id;
					header('Location:'.$url);					
					exit();
				}
				
				$sql2="select * from $bai_pro3.bai_orders_db_confirm where order_del_no='".$_GET['schedule']."' and order_style_no='".$_GET['style']."' order by order_del_no desc limit 0,1";
				//echo $sql2;
				//mysqli_query($link, $sql2) or exit("Sql Error sizes".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error sizes".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check2=mysqli_num_rows($sql_result2);
				echo "<div class='table-responsive'  style='overflow-y:scroll;max-height:600px;'>";
				echo '<br><table class="table table-hover table-bordered integer">';
				echo "<tr><thead><th>Pack Quantity</th><th>Pack Method</th>";
			/*echo "<th>s01</th><th>s02</th><th>s03</th><th>s04</th><th>s05</th><th>s06</th><th>s07</th><th>s08</th><th>s09</th><th>s10</th><th>s11</th><th>s12</th><th>s13</th><th>s14</th><th>s15</th><th>s16</th><th>s17</th><th>s18</th><th>s19</th><th>s20</th><th>s21</th><th>s22</th><th>s23</th><th>s24</th><th>s25</th><th>s26</th><th>s27</th><th>s28</th><th>s29</th><th>s30</th><th>s31</th><th>s32</th><th>s33</th><th>s34</th><th>s35</th><th>s36</th><th>s37</th><th>s38</th><th>s39</th><th>s40</th><th>s41</th><th>s42</th><th>s43</th><th>s44</th><th>s45</th><th>s46</th><th>s47</th><th>s48</th><th>s49</th><th>s50</th>";*/ 
				$sizes = array();
				$sizes_qty = array();
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					for($i=1;$i<=50;$i++){
						$hds = str_pad($i, 2, "0", STR_PAD_LEFT);
						$sizes_qty[] = $sql_row2['order_s_s'.$hds];
						$sizes[] = $sql_row2['title_size_s'.$hds];
					}
				}
				//var_dump($sizes_qty);
				//var_dump($sizes);
				foreach($sizes as $val){
					if($val!=''){
						echo "<th>".$val."</th>";
					}					
				}
				echo "<th>Status</th><th>Track Label Qty</th><th>SRP Qty</th>";
			echo "</thead></tr>";

			echo "<tr>";
			/*echo "<td>";
			echo "<select name=\"style\">";
			echo "<option value=\"0\"></option>";

			//Changed on 2013-06-17 8:43 PM - Kirang
			$sql="select distinct style_id from bai_orders_db_confirm order by style_id";
			//$sql="select distinct style_id from bai_pro2.movex_styles order by style_id";
			mysql_query($sql,$link) or exit("Sql Error".mysql_error());
			$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
			$sql_num_check=mysql_num_rows($sql_result);
			while($sql_row=mysql_fetch_array($sql_result))
			{
				echo "<option value=\"".$sql_row['style_id']."\">".$sql_row['style_id']."</option>";
			}
			echo "</select></td>";*/

			//echo "<td>";
			// echo "<select name=\"buyer\">";
			// echo "<option value=\"0\">Please Select</option>";
			// $sql="SELECT * FROM bai_pro2.buyer_codes";
			// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			// $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			// while($sql_row=mysqli_fetch_array($sql_result))
			// {
			// 	echo "<option value=\"".$sql_row['buyer_code']."\">".$sql_row['buyer_name']."</option>";
			// }
			// echo "<option value=\"Y\">Lidil</option>";
			// echo "<option value=\"M-T14\">M&S-T14</option>";
			// echo "<option value=\"M-T61\">M&S-T61</option>";
			// echo "<option value=\"M-T32\">M&S-T32</option>";
			// echo "<option value=\"H&M\">H&M</option>";
			// echo "<option value=\"S\">VS</option>";
			// echo "<option value=\"N\">Nayomi</option>";
			// echo "<option value=\"U\">Loungerie</option>";
			// echo "<option value=\"Q\">PVH</option>";
			//echo "</select></td>";

			echo "<td>";
			echo "<input type=\"text\"  class='form-control alpha' size=\"10\" value=\"\" name=\"pack\" id='pack'></td>";
			echo "<td><select name=\"pack_methods\" id=\"pack_methods\" class='form-control'>";
			echo "<option value=\"\">Select Pack Method</option>";
			foreach($pack_methods as $P => $pack_method){				
				echo "<option value='$P'>$pack_method</option>";
			}
			echo "</select></td>";

			/*echo "<td><input type=\"text\" size=3 name=\"s01\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s02\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s03\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s04\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s05\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s06\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s07\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s08\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s09\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s10\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s11\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s12\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s13\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s14\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s15\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s16\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s17\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s18\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s19\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s20\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s21\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s22\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s23\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s24\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s25\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s26\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s27\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s28\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s29\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s30\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s31\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s32\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s33\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s34\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s35\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s36\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s37\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s38\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s39\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s40\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s41\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s42\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s43\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s44\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s45\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s46\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s47\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s48\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s49\" value=\"0\"></td><td><input type=\"text\" size=3 name=\"s50\" value=\"0\"></td>";*/
			$j=0;
			//$count = 0;
					for($i=0;$i<=50;$i++){
						$hds = 's'.str_pad($i, 2, "0", STR_PAD_LEFT);						
						$sz_qty = $sizes_qty[$j];				
						if($sizes[$i]!=''){
							$id_count++;
							if($sz_qty>0){
								echo "<td><input type=\"text\" class='form-control float' size=3 name='".$hds."' value=\"0\"  id=\"size$id_count\"  required  onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value=0;}\" onchange='validating_mul(\"$id_count\")'></td>";
							}else{
								echo "<td><input type=\"text\" class='form-control float' required size=3 name='".$hds."' value=\"0\" id=\"size$id_count\" onchange='validating_mul(\"$id_count\")'></td>";
							}
							$count++;
							
						}
						$j++;
						
					}
			echo "<td>";
			echo "<input type='hidden' id='count' value='".$id_count."'>";
			echo "<select name=\"status\" id=\"status\" class='form-control'>";
			echo "<option value=\"\">Select Status</option>";
			echo "<option value=\"0\">Active</option>";
			echo "<option value=\"1\">In-Active</option>";
			echo "</select></td>";

			echo "<td><input type=\"text\" class='form-control float' size=3 name=\"track_qty\" id='track_qty'  required value=\"0\"></td>";
			echo "<td><input type=\"text\" class='form-control float' size=3 name=\"srp_qty\" id='srp_qty'  required value=\"0\"></td>";
			echo "</tr>";
			echo "</table></div><br>";
			?>
			<input type="submit" name="submit" value="submit"  onclick="return check_pack();" class="btn btn-success" style="margin-top: 18px;\">

		</form>

		<?php } ?>
		
		<?php
		if(isset($_POST['submit']))
		{
			$schedule=$_POST['schedule'];
			$style=$_POST['style'];
			$buyer=$_POST['buyer'];
			$pack=$_POST['pack'];
			$status=$_POST['status'];
			$pack_methods=$_POST['pack_methods'];
			$xs=$sql_row['xs'];
			
		$xs=(isset($_POST['xs']))?$_POST['xs']:0;
		$s=(isset($_POST['s']))?$_POST['s']:0;
		$m=(isset($_POST['m']))?$_POST['m']:0;
		$l=(isset($_POST['l']))?$_POST['l']:0;
		$xl=(isset($_POST['xl']))?$_POST['xl']:0;
		$xxl=(isset($_POST['xxl']))?$_POST['xxl']:0;
		$xxxl=(isset($_POST['xxxl']))?$_POST['xxxl']:0;
		$s00=(isset($_POST['s00']))?$_POST['s00']:0;
		$s01=(isset($_POST['s01']))?$_POST['s01']:0;
		$s02=(isset($_POST['s02']))?$_POST['s02']:0;
		$s03=(isset($_POST['s03']))?$_POST['s03']:0;
		$s04=(isset($_POST['s04']))?$_POST['s04']:0;
		$s05=(isset($_POST['s05']))?$_POST['s05']:0;
		$s06=(isset($_POST['s06']))?$_POST['s06']:0;
		$s07=(isset($_POST['s07']))?$_POST['s07']:0;
		$s08=(isset($_POST['s08']))?$_POST['s08']:0;
		$s09=(isset($_POST['s09']))?$_POST['s09']:0;
		$s10=(isset($_POST['s10']))?$_POST['s10']:0;
		$s11=(isset($_POST['s11']))?$_POST['s11']:0;
		$s12=(isset($_POST['s12']))?$_POST['s12']:0;
		$s13=(isset($_POST['s13']))?$_POST['s13']:0;
		$s14=(isset($_POST['s14']))?$_POST['s14']:0;
		$s15=(isset($_POST['s15']))?$_POST['s15']:0;
		$s16=(isset($_POST['s16']))?$_POST['s16']:0;
		$s17=(isset($_POST['s17']))?$_POST['s17']:0;
		$s18=(isset($_POST['s18']))?$_POST['s18']:0;
		$s19=(isset($_POST['s19']))?$_POST['s19']:0;
		$s20=(isset($_POST['s20']))?$_POST['s20']:0;
		$s21=(isset($_POST['s21']))?$_POST['s21']:0;
		$s22=(isset($_POST['s22']))?$_POST['s22']:0;
		$s23=(isset($_POST['s23']))?$_POST['s23']:0;
		$s24=(isset($_POST['s24']))?$_POST['s24']:0;
		$s25=(isset($_POST['s25']))?$_POST['s25']:0;
		$s26=(isset($_POST['s26']))?$_POST['s26']:0;
		$s27=(isset($_POST['s27']))?$_POST['s27']:0;
		$s28=(isset($_POST['s28']))?$_POST['s28']:0;
		$s29=(isset($_POST['s29']))?$_POST['s29']:0;
		$s30=(isset($_POST['s30']))?$_POST['s30']:0;
		$s31=(isset($_POST['s31']))?$_POST['s31']:0;
		$s32=(isset($_POST['s32']))?$_POST['s32']:0;
		$s33=(isset($_POST['s33']))?$_POST['s33']:0;
		$s34=(isset($_POST['s34']))?$_POST['s34']:0;
		$s35=(isset($_POST['s35']))?$_POST['s35']:0;
		$s36=(isset($_POST['s36']))?$_POST['s36']:0;
		$s37=(isset($_POST['s37']))?$_POST['s37']:0;
		$s38=(isset($_POST['s38']))?$_POST['s38']:0;
		$s39=(isset($_POST['s39']))?$_POST['s39']:0;
		$s40=(isset($_POST['s40']))?$_POST['s40']:0;
		$s41=(isset($_POST['s41']))?$_POST['s41']:0;
		$s42=(isset($_POST['s42']))?$_POST['s42']:0;
		$s43=(isset($_POST['s43']))?$_POST['s43']:0;
		$s44=(isset($_POST['s44']))?$_POST['s44']:0;
		$s45=(isset($_POST['s45']))?$_POST['s45']:0;
		$s46=(isset($_POST['s46']))?$_POST['s46']:0;
		$s47=(isset($_POST['s47']))?$_POST['s47']:0;
		$s48=(isset($_POST['s48']))?$_POST['s48']:0;
		$s49=(isset($_POST['s49']))?$_POST['s49']:0;
		$s50=(isset($_POST['s50']))?$_POST['s50']:0;



		$track_qty=$_POST['track_qty'];
		$srp_qty=$_POST['srp_qty'];
			// switch($buyer)
			// {
			// 	case "Y":
			// 	{
			// 		$buyer_name="Lidil";
			// 		break;
			// 	}
			// 	case "S":
			// 	{
			// 		$buyer_name="VS";
			// 		break;
			// 	}
				
			// 	case "M-T14":
			// 	{
			// 		$buyer_name="M&S-T14";
			// 		break;
			// 	}
			// 	case "M-T61":
			// 	{
			// 		$buyer_name="M&S-T61";
			// 		break;
			// 	}
			// 	case "M-T32":
			// 	{
			// 		$buyer_name="M&S-T32";
			// 		break;
			// 	}
			// 	case "CK":
			// 	{
			// 		$buyer_name="CK";
			// 		break;
			// 	}
			// 	case "H&M":
			// 	{
			// 		$buyer_name="H&M";
			// 		break;
			// 	}
			// 	case "N":
			// 	{
			// 		$buyer_name="Nayomi";
			// 		break;
			// 	}
			// 	case "U":
			// 	{
			// 		$buyer_name="Loungerie";
			// 		break;
			// 	}
				
			// 	default:
			// 	{
			// 		$buyer_name="";
			// 		break;
			// 	}
			// }
			
			$date=date("y-m-d");
			$sql="select * from $bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."' and order_style_no='".$style."'";
			$result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row=mysqli_fetch_array($result))
			{
				$style_id=$row['style_id'];
			}
			//\"$buyer_name\",\"$buyer\"
			$sql="insert into carton_qty_chart(user_schedule,user_style,packing_method,pack_methods,s01,s02,s03,s04,s05,s06,s07,s08,s09,s10,s11,s12,s13,s14,s15,s16,s17,s18,s19,s20,s21,s22,s23,s24,s25,s26,s27,s28,s29,s30,s31,s32,s33,s34,s35,s36,s37,s38,s39,s40,s41,s42,s43,s44,s45,s46,s47,s48,s49,s50,date,status,track_qty,srp_qty) 
				  values 
				  (\"$schedule\",\"$style_id\",\"$pack\",\"$pack_methods\",'$s00','$s01','$s02','$s03','$s04','$s05','$s06','$s07','$s08','$s09','$s10','$s11','$s12','$s13','$s14','$s15','$s16','$s17','$s18','$s19','$s20','$s21','$s22','$s23','$s24','$s25','$s26','$s27','$s28','$s29','$s30','$s31','$s32','$s33','$s34','$s35','$s36','$s37','$s38','$s39','$s40','$s41','$s42','$s43','$s44','$s45','$s46','$s47','$s48','$s49',\"$date\",$status,$track_qty,$srp_qty)";
			
			mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$path = getFullURL($_GET['r'],'carton_updates.php','N');
			$path = $path.'&message=100';
			echo "<script type=\"text/javascript\"> 
					setTimeout(\"Redirect()\",0); 
					function Redirect() {  
						sweetAlert('Carton Quantities Updated Successfully','','success');
						location.href = '$path'; 
					}
				</script>";
		}

		?>
	</div>
</div>

<script>
	function style_change(){

		var path = '<?= getFullURL($_GET['r'],'carton_create.php','N'); ?>';

		var style=document.getElementById('style').value;
		if(style != ''){
			window.location = path+"&style="+style;
		}else{
			window.location = path;
		}
		
	}
	function schedule_change(){
		var path = '<?= getFullURL($_GET['r'],'carton_create.php','N'); ?>';
		var schedule=document.getElementById('schedule').value;
		var style=document.getElementById('style').value;
		if(schedule != '' && style!=''){
			window.location = path+"&schedule="+schedule+"&style="+style;
		}else if(style != ''){
			window.location = path+"&style="+style;
		}else{
			window.location = path;
		}	
	}

	function verify_num(t,e){
		if(e.keyCode==8)
		{
			return ;
		}
		var c = /^[0-9]+$/;
		var id = t.id;
		var qty = document.getElementById(id);
		if( !(qty.value.match(c)) ){
			sweetAlert('Please Enter Only Numbers','','warning');
			qty.value = '';
			return false;
		}
	}
	function verify_char(t){
		var c = /^[0-9	a-zA-Z ]*$/;
		var id = t.id;
		var qty = document.getElementById(id);
		if( !(qty.value.match(c)) ){
			sweetAlert('Please Enter Only Alpha Numeric','','warning');
			qty.value = '';
			return false;
		}
	}

	function check_pack()
	{
		var count = document.getElementById('count').value;
		var qty = document.getElementById('pack').value;
		var status = document.getElementById('status').value;
		var tot_qty = 0;
		for(var i=1; i<=count; i++)
		{
			var variable = "size"+i;
			var qty_cnt = document.getElementById(variable).value;
			tot_qty += Number(qty_cnt);
		}
		if(Number(tot_qty) <= 0)
		{
			sweetAlert("Please enter atleast one size quantity","","warning");
			//swal('Please Enter Any size quantity','','warning');
			return false;
		}	
		if(qty == '')
		{
			sweetAlert('Please Enter Pack method','','warning');
			return false;

		}
		else if(status== '')
		{
			sweetAlert('Please select Status','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}
	// function validating_mul(id)
	// {
	// 	var pre = 'size'+id;
	// 	var pre_element = document.getElementById(pre).value;
	// 	var pack_method = document.getElementById('pack').value;
	// 	if(pack_method == '')
	// 	{
	// 		sweetAlert("","Please enter pack method First.","warning");
	// 		document.getElementById(pre).value = 0;
	// 	}
	// 	var reminder = Number(pack_method) % Number(pre_element);
	// 	if(reminder != 0)
	// 	{
	// 		sweetAlert("","Quantity should be multiples of Pack Method.","warning");
	// 		document.getElementById(pre).value = 0;
	// 	}
	// }
</script>
<?php

/*list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2);
$authorized=array("muralim","duminduw","rajanaa","kranthic","kirang");
if(!(in_array(strtolower($username),$authorized)))
{
	header("Location:restrict.php");
}*/

include("../".getFullURLLevel($_GET['r'],'common/config/config.php', 3,'R'));

include("../".getFullURLLevel($_GET['r'], "common/config/user_acl_v1.php", 3, "R"));
include("../".getFullURLLevel($_GET['r'], "common/config/group_def.php", 3, "R"));
// $view_access=user_acl("SFCS_0122",$username,1,$group_id_sfcs); 
include("../".getFullURLLevel($_GET['r'], "common/config/ims_size.php", 3, "R"));
// include(getFullURL($_GET['r'],'header_script.php','R')); 

?>

<style>
td,th{
	color : #000;
}
.black{
	color : #000;
}
</style>
<script>
	function firstbox()
	{
		window.location.href ="<?php echo 'index.php?r='.$_GET['r'] ?>&style="+document.test.style.value
	}

	function secondbox()
	{
		window.location.href ="<?php echo 'index.php?r='.$_GET['r'] ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value
	}

	function thirdbox()
	{
		window.location.href ="<?php echo 'index.php?r='.$_GET['r'] ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
	}
	function negative(){
		var element = document.getElementById('crts');
		var cartons = element.value;
		if(isNaN(cartons) || cartons < 0){
			sweetAlert('Cartons should not be negative','','warning');
			element.value = 0;
		}
	}
</script>
<?php
$style=$_GET['style'];
$schedule=$_GET['schedule']; 
$color=$_GET['color'];
?>

<div class="panel panel-primary">
	<div class="panel-heading">
		<span style="float"><b>Reserve For Dispatch</b></span>
	</div>
	<div class="panel-body">
		<form id="test" name="test" action="<?php echo '?r='.$_GET['r']; ?>" method="POST">
			<div class="col-sm-3 form-group">
				<label for="style">Select Style:</label>
				<select class='form-control' name='style' onchange='firstbox();'>
					<?php				
					$sql="select distinct order_style_no from $bai_pro3.bai_orders_db_confirm where left(order_style_no,1) in ('Q','W','E','R','T','Y','U','I','O','P','A','S','D','F','G','H','J','K','L','Z','X','C','V','B','N','M') order by order_style_no";	
					echo $sql;
					mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_result);
					echo "<option value=\"NIL\" selected>NIL</option>";
						while($sql_row=mysqli_fetch_array($sql_result)){
							if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
							{
								echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
							}else{
								echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
							}
						}
					?>
				</select>
			</div>
			<div class="col-sm-3 form-group">
				<label for="schedule">Select Schedule:</label>
				<select class='form-control' name='schedule' onchange='secondbox();'>
					<?php
					$sql="select distinct order_del_no from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" order by order_del_no";
					//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
					//{
						//$sql="select distinct order_del_no from plan_doc_summ where order_style_no=\"$style\"";	
					//}
					mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_result);
					echo "<option value=\"NIL\" selected>NIL</option>";
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule))
						{
							echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
						}else{
							echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
						}

					}
					?>
				</select>
			</div>	
			<?php
				$sql1="select count(order_col_des) as col_cnt from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
				//	echo "query=".$sql1;
				mysqli_query($link, $sql1) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_result1);
					while($sql_row1=mysqli_fetch_array($sql_result1))
					{
						$color_count=$sql_row1['col_cnt'];
					}
			?>
			<div class="col-sm-3 form-group">
				<label for="color">Select Color:</label>
				<select class='form-control' name='color' onchange='thirdbox();'>
					<?php
						$sql="select distinct order_col_des from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
						//}
						mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result);

						echo "<option value=\"NIL\" selected>NIL</option>";
						if($color_count>'1')
						{
					?>
							<option value="0" <?php if($color=="0") { echo "selected"; } ?>>ALL</option>
					<?php
						}	
							
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color))
							{
								echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
							}else{
								echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
							}
						}
					?>
				</select>
			</div>
			<div class="col-sm-1 form-group">
				<?php
					if($sql_num_check>0){
						echo "<input type='hidden' name='style_x' value='$style'>";
						echo "<input type='hidden' name='schedule_x' value='$schedule'>";
						echo "<input type='hidden' name='color_x' value='$color'>";
						echo "<br><input class='btn btn-success' type='submit' name='submit' value='Show'><br><br>";
					}
				?>
			</div>
		</form>
<?php

// $ship_xs=0;
// $ship_s=0;
// $ship_m=0;
// $ship_l=0;
// $ship_xl=0;
// $ship_xxl=0;
// $ship_xxxl=0;
// $ship_s01=0;
// $ship_s02=0;
// $ship_s03=0;
// $ship_s04=0;
// $ship_s05=0;
// $ship_s06=0;
// $ship_s07=0;
// $ship_s08=0;
// $ship_s09=0;
// $ship_s10=0;
// $ship_s11=0;
// $ship_s12=0;
// $ship_s13=0;
// $ship_s14=0;
// $ship_s15=0;
// $ship_s16=0;
// $ship_s17=0;
// $ship_s18=0;
// $ship_s19=0;
// $ship_s20=0;
// $ship_s21=0;
// $ship_s22=0;
// $ship_s23=0;
// $ship_s24=0;
// $ship_s25=0;
// $ship_s26=0;
// $ship_s27=0;
// $ship_s28=0;
// $ship_s29=0;
// $ship_s30=0;
// $ship_s31=0;
// $ship_s32=0;
// $ship_s33=0;
// $ship_s34=0;
// $ship_s35=0;
// $ship_s36=0;
// $ship_s37=0;
// $ship_s38=0;
// $ship_s39=0;
// $ship_s40=0;
// $ship_s41=0;
// $ship_s42=0;
// $ship_s43=0;
// $ship_s44=0;
// $ship_s45=0;
// $ship_s46=0;
// $ship_s47=0;
// $ship_s48=0;
// $ship_s49=0;
// $ship_s50=0;
for($i=1;$i<=50;$i++){
	$ship_s[$i] = 0;
}
$x=0;
$sql="select * from $bai_pro3.ship_stat_log where ship_status=1 order by ship_schedule";
mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
$count = mysqli_num_rows(mysqli_query($link, $sql));

$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
if($count){
$form_submit1 = getFullURL($_GET['r'],'dc_prepare.php','N');
echo "<div class='col-sm-12' id='tdiv'>";
echo "<font color='black' size=4><b>Reserved to Ship</b></font>";
echo "<form name='prepare' method='post' action=$form_submit1 >";
echo "<div class='row' style='max-height:600px;overflow-x:scroll;overflow-y:scroll' >";
echo "<table class='table table-bordered table-responsive'>
		<tr class='danger'>
			<th>Select</th><th>Style</th><th>Schedule</th><th>Color</th><th>Total Pcs </th><th>Total Cartons</th><th>Remarks</th><th>Controls</th><th>Size</th>";
			//echo "<th>XS</th><th>S</th><th>M</th><th>L</th><th>XL</th><th>XXL</th><th>XXXL</th>";
// for($i=1;$i<=50;$i++){
// 	echo "<th>s$i</th>";
// }
echo "</tr>";

	while($sql_row=mysqli_fetch_array($sql_result))
{
	// $ship_xs=$sql_row['ship_s_xs'];
	// $ship_s=$sql_row['ship_s_s'];
	// $ship_m=$sql_row['ship_s_m'];
	// $ship_l=$sql_row['ship_s_l'];
	// $ship_xl=$sql_row['ship_s_xl'];
	// $ship_xxl=$sql_row['ship_s_xxl'];
	// $ship_xxxl=$sql_row['ship_s_xxxl'];

	for($i=1;$i<=count($ship_s);$i++){
		if($i<=9){
			$ship_s[$i] = $sql_row['ship_s_s0'.$i];
		}else{
			$ship_s[$i] = $sql_row['ship_s_s'.$i];
		}		
	}
	//var_dump($ship_s);
	// $ship_s01=$sql_row['ship_s_s01'];
	// $ship_s02=$sql_row['ship_s_s02'];
	// $ship_s03=$sql_row['ship_s_s03'];
	// $ship_s04=$sql_row['ship_s_s04'];
	// $ship_s05=$sql_row['ship_s_s05'];
	// $ship_s06=$sql_row['ship_s_s06'];
	// $ship_s07=$sql_row['ship_s_s07'];
	// $ship_s08=$sql_row['ship_s_s08'];
	// $ship_s09=$sql_row['ship_s_s09'];
	// $ship_s10=$sql_row['ship_s_s10'];
	// $ship_s11=$sql_row['ship_s_s11'];
	// $ship_s12=$sql_row['ship_s_s12'];
	// $ship_s13=$sql_row['ship_s_s13'];
	// $ship_s14=$sql_row['ship_s_s14'];
	// $ship_s15=$sql_row['ship_s_s15'];
	// $ship_s16=$sql_row['ship_s_s16'];
	// $ship_s17=$sql_row['ship_s_s17'];
	// $ship_s18=$sql_row['ship_s_s18'];
	// $ship_s19=$sql_row['ship_s_s19'];
	// $ship_s20=$sql_row['ship_s_s20'];
	// $ship_s21=$sql_row['ship_s_s21'];
	// $ship_s22=$sql_row['ship_s_s22'];
	// $ship_s23=$sql_row['ship_s_s23'];
	// $ship_s24=$sql_row['ship_s_s24'];
	// $ship_s25=$sql_row['ship_s_s25'];
	// $ship_s26=$sql_row['ship_s_s26'];
	// $ship_s27=$sql_row['ship_s_s27'];
	// $ship_s28=$sql_row['ship_s_s28'];
	// $ship_s29=$sql_row['ship_s_s29'];
	// $ship_s30=$sql_row['ship_s_s30'];
	// $ship_s31=$sql_row['ship_s_s31'];
	// $ship_s32=$sql_row['ship_s_s32'];
	// $ship_s33=$sql_row['ship_s_s33'];
	// $ship_s34=$sql_row['ship_s_s34'];
	// $ship_s35=$sql_row['ship_s_s35'];
	// $ship_s36=$sql_row['ship_s_s36'];
	// $ship_s37=$sql_row['ship_s_s37'];
	// $ship_s38=$sql_row['ship_s_s38'];
	// $ship_s39=$sql_row['ship_s_s39'];
	// $ship_s40=$sql_row['ship_s_s40'];
	// $ship_s41=$sql_row['ship_s_s41'];
	// $ship_s42=$sql_row['ship_s_s42'];
	// $ship_s43=$sql_row['ship_s_s43'];
	// $ship_s44=$sql_row['ship_s_s44'];
	// $ship_s45=$sql_row['ship_s_s45'];
	// $ship_s46=$sql_row['ship_s_s46'];
	// $ship_s47=$sql_row['ship_s_s47'];
	// $ship_s48=$sql_row['ship_s_s48'];
	// $ship_s49=$sql_row['ship_s_s49'];
	// $ship_s50=$sql_row['ship_s_s50'];

	
	$ship_style=$sql_row['ship_style'];
	$ship_schedule=$sql_row['ship_schedule'];
	$ship_color=$sql_row['ship_color'];
	$ship_cartons=$sql_row['ship_cartons'];
	$ship_remarks=$sql_row['ship_remarks'];
	
	$total_pcs = 0;
	for($i=1;$i<=count($ship_s);$i++){
		if($ship_s[$i]!=0){			
			$total_pcs+=$ship_s[$i];
		}
	}
	// echo $total_pcs;
	// die();
	//$total_pcs=$ship_xs+$ship_s+$ship_m+$ship_l+$ship_xl+$ship_xxl+$ship_xxxl+$ship_s01+$ship_s02+$ship_s03+$ship_s04+$ship_s05+$ship_s06+$ship_s07+$ship_s08+$ship_s09+$ship_s10+$ship_s11+$ship_s12+$ship_s13+$ship_s14+$ship_s15+$ship_s16+$ship_s17+$ship_s18+$ship_s19+$ship_s20+$ship_s21+$ship_s22+$ship_s23+$ship_s24+$ship_s25+$ship_s26+$ship_s27+$ship_s28+$ship_s29+$ship_s30+$ship_s31+$ship_s32+$ship_s33+$ship_s34+$ship_s35+$ship_s36+$ship_s37+$ship_s38+$ship_s39+$ship_s40+$ship_s41+$ship_s42+$ship_s43+$ship_s44+$ship_s45+$ship_s46+$ship_s47+$ship_s48+$ship_s49+$ship_s50;

	//echo "<tr><td><input type=\"checkbox\" value=\"1\" name=\"sel[$x]\"><input type=\"hidden\" name=\"ship_id[$x]\" value=\"".$sql_row['ship_tid']."\"></td>";
	echo "<tr><td><input type=\"checkbox\" value=\"".$sql_row['ship_tid']."\" id='chk' onchange='check_clicked()' name=\"sel[$x]\"></td>";
	echo "<td>$ship_style</td>";
	echo "<td>$ship_schedule</td>";
	echo "<td>$ship_color</td>";
	echo "<td>$total_pcs</td>";
	echo "<td>$ship_cartons</td>";
	echo "<td>$ship_remarks</td>";
	$unset_url = getFullURL($_GET['r'],'unset.php','N').'&ship_tid='.$sql_row['ship_tid'];
	//$unset_url = 'index.php?r='.$_GET['r'].'&ship_tid='.$sql_row['ship_tid'];
	echo "<td><a class='btn btn-xs btn-info' href='$unset_url'>Un-Set</a></td>";
	for($i=1;$i<=count($ship_s);$i++){
		if($ship_s[$i] !=0){
			$key1 = 's'.str_pad($i, 2, "0", STR_PAD_LEFT);
			$get_color = "SELECT title_size_".$key1." FROM $bai_pro3.bai_orders_db_confirm WHERE order_del_no='".$ship_schedule."' LIMIT 1";			
			$sql_color=mysqli_query($link, $get_color);
			$sql_num_check1=mysqli_num_rows($sql_color);
			if($sql_num_check1>0){				
				$color_des=mysqli_fetch_array($sql_color);				
				$sizek=$color_des[0];				
			}else{				
				$sizek="empty";
			}		
			echo "<td>".$ship_s[$i]."<b>(".$sizek.")<br/></td>";
		}
	}
// 	echo "<td>$ship_xs</td><td>$ship_s</td><td>$ship_m</td><td>$ship_l</td><td>$ship_xl</td><td>$ship_xxl</td><td>$ship_xxxl</td><td>$ship_s01</td>
// <td>$ship_s02</td>
// <td>$ship_s03</td>
// <td>$ship_s04</td>
// <td>$ship_s05</td>
// <td>$ship_s06</td>
// <td>$ship_s07</td>
// <td>$ship_s08</td>
// <td>$ship_s09</td>
// <td>$ship_s10</td>
// <td>$ship_s11</td>
// <td>$ship_s12</td>
// <td>$ship_s13</td>
// <td>$ship_s14</td>
// <td>$ship_s15</td>
// <td>$ship_s16</td>
// <td>$ship_s17</td>
// <td>$ship_s18</td>
// <td>$ship_s19</td>
// <td>$ship_s20</td>
// <td>$ship_s21</td>
// <td>$ship_s22</td>
// <td>$ship_s23</td>
// <td>$ship_s24</td>
// <td>$ship_s25</td>
// <td>$ship_s26</td>
// <td>$ship_s27</td>
// <td>$ship_s28</td>
// <td>$ship_s29</td>
// <td>$ship_s30</td>
// <td>$ship_s31</td>
// <td>$ship_s32</td>
// <td>$ship_s33</td>
// <td>$ship_s34</td>
// <td>$ship_s35</td>
// <td>$ship_s36</td>
// <td>$ship_s37</td>
// <td>$ship_s38</td>
// <td>$ship_s39</td>
// <td>$ship_s40</td>
// <td>$ship_s41</td>
// <td>$ship_s42</td>
// <td>$ship_s43</td>
// <td>$ship_s44</td>
// <td>$ship_s45</td>
// <td>$ship_s46</td>
// <td>$ship_s47</td>
// <td>$ship_s48</td>
// <td>$ship_s49</td>
// <td>$ship_s50</td>
// ";

	echo "</tr>";
	$x++;
	
}
echo "</table></div>";
echo "<br><input class='btn btn-primary btn-sm' id='prepare' type='submit' name='prepare' value='Prepare Dispatch' disabled>";
}else{
	//echo "<div class='alert alert-danger'>No Data Found</div>";
}
// if(mysqli_num_rows($sql_result) < 1 )
	// echo "<div class='text-danger'><h3>No Data Found</h3></div>";


echo "</form></div></div>";

?>


<?php
if(isset($_POST['submit']))
{
	$style_x=$_POST['style_x'];
	$schedule_x=$_POST['schedule_x'];
	$color_x=$_POST['color_x'];

	echo "<div style='padding-left:2%; padding-right:2%;'><div class='panel panel-info'>";
	echo "<div class='panel-heading'><span><strong>Style :$style_x</strong></span> <span style='margin-left:5%;'><strong>Schedule :$schedule_x</strong><span>";
	if($color_x!='0'){
		echo "<span style='margin-left:5%;'><strong>Color :$color_x</strong><span></div>";
	}

	$order_xs=0;
	$order_s=0;
	$order_m=0;
	$order_l=0;
	$order_xl=0;
	$order_xxl=0;
	$order_xxxl=0;
	$order_s01=0;
	$order_s02=0;
	$order_s03=0;
	$order_s04=0;
	$order_s05=0;
	$order_s06=0;
	$order_s07=0;
	$order_s08=0;
	$order_s09=0;
	$order_s10=0;
	$order_s11=0;
	$order_s12=0;
	$order_s13=0;
	$order_s14=0;
	$order_s15=0;
	$order_s16=0;
	$order_s17=0;
	$order_s18=0;
	$order_s19=0;
	$order_s20=0;
	$order_s21=0;
	$order_s22=0;
	$order_s23=0;
	$order_s24=0;
	$order_s25=0;
	$order_s26=0;
	$order_s27=0;
	$order_s28=0;
	$order_s29=0;
	$order_s30=0;
	$order_s31=0;
	$order_s32=0;
	$order_s33=0;
	$order_s34=0;
	$order_s35=0;
	$order_s36=0;
	$order_s37=0;
	$order_s38=0;
	$order_s39=0;
	$order_s40=0;
	$order_s41=0;
	$order_s42=0;
	$order_s43=0;
	$order_s44=0;
	$order_s45=0;
	$order_s46=0;
	$order_s47=0;
	$order_s48=0;
	$order_s49=0;
	$order_s50=0;


if($color_x=='0')
{
$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style_x\" and order_del_no=\"$schedule_x\"";	
}	

else
{
$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style_x\" and order_del_no=\"$schedule_x\" and order_col_des=\"$color_x\"";	
}
	mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
				
		$style_no=$sql_row['order_style_no'];
		$schedule_no=$sql_row['order_del_no'];
		$color_no=$sql_row['order_col_des'];
		
		$order_xs+=$sql_row['order_s_xs'];
		$order_s+=$sql_row['order_s_s'];
		$order_m+=$sql_row['order_s_m'];
		$order_l+=$sql_row['order_s_l'];
		$order_xl+=$sql_row['order_s_xl'];
		$order_xxl+=$sql_row['order_s_xxl'];
		$order_xxxl+=$sql_row['order_s_xxxl'];
		
		$order_s01+=$sql_row['order_s_s01'];
		$order_s02+=$sql_row['order_s_s02'];
		$order_s03+=$sql_row['order_s_s03'];
		$order_s04+=$sql_row['order_s_s04'];
		$order_s05+=$sql_row['order_s_s05'];
		$order_s06+=$sql_row['order_s_s06'];
		$order_s07+=$sql_row['order_s_s07'];
		$order_s08+=$sql_row['order_s_s08'];
		$order_s09+=$sql_row['order_s_s09'];
		$order_s10+=$sql_row['order_s_s10'];
		$order_s11+=$sql_row['order_s_s11'];
		$order_s12+=$sql_row['order_s_s12'];
		$order_s13+=$sql_row['order_s_s13'];
		$order_s14+=$sql_row['order_s_s14'];
		$order_s15+=$sql_row['order_s_s15'];
		$order_s16+=$sql_row['order_s_s16'];
		$order_s17+=$sql_row['order_s_s17'];
		$order_s18+=$sql_row['order_s_s18'];
		$order_s19+=$sql_row['order_s_s19'];
		$order_s20+=$sql_row['order_s_s20'];
		$order_s21+=$sql_row['order_s_s21'];
		$order_s22+=$sql_row['order_s_s22'];
		$order_s23+=$sql_row['order_s_s23'];
		$order_s24+=$sql_row['order_s_s24'];
		$order_s25+=$sql_row['order_s_s25'];
		$order_s26+=$sql_row['order_s_s26'];
		$order_s27+=$sql_row['order_s_s27'];
		$order_s28+=$sql_row['order_s_s28'];
		$order_s29+=$sql_row['order_s_s29'];
		$order_s30+=$sql_row['order_s_s30'];
		$order_s31+=$sql_row['order_s_s31'];
		$order_s32+=$sql_row['order_s_s32'];
		$order_s33+=$sql_row['order_s_s33'];
		$order_s34+=$sql_row['order_s_s34'];
		$order_s35+=$sql_row['order_s_s35'];
		$order_s36+=$sql_row['order_s_s36'];
		$order_s37+=$sql_row['order_s_s37'];
		$order_s38+=$sql_row['order_s_s38'];
		$order_s39+=$sql_row['order_s_s39'];
		$order_s40+=$sql_row['order_s_s40'];
		$order_s41+=$sql_row['order_s_s41'];
		$order_s42+=$sql_row['order_s_s42'];
		$order_s43+=$sql_row['order_s_s43'];
		$order_s44+=$sql_row['order_s_s44'];
		$order_s45+=$sql_row['order_s_s45'];
		$order_s46+=$sql_row['order_s_s46'];
		$order_s47+=$sql_row['order_s_s47'];
		$order_s48+=$sql_row['order_s_s48'];
		$order_s49+=$sql_row['order_s_s49'];
		$order_s50+=$sql_row['order_s_s50'];

	}
	
	$fg_xs=0;
	$fg_s=0;
	$fg_m=0;
	$fg_l=0;
	$fg_xl=0;
	$fg_xxl=0;
	$fg_xxxl=0;
	$fg_s01=0;
	$fg_s02=0;
	$fg_s03=0;
	$fg_s04=0;
	$fg_s05=0;
	$fg_s06=0;
	$fg_s07=0;
	$fg_s08=0;
	$fg_s09=0;
	$fg_s10=0;
	$fg_s11=0;
	$fg_s12=0;
	$fg_s13=0;
	$fg_s14=0;
	$fg_s15=0;
	$fg_s16=0;
	$fg_s17=0;
	$fg_s18=0;
	$fg_s19=0;
	$fg_s20=0;
	$fg_s21=0;
	$fg_s22=0;
	$fg_s23=0;
	$fg_s24=0;
	$fg_s25=0;
	$fg_s26=0;
	$fg_s27=0;
	$fg_s28=0;
	$fg_s29=0;
	$fg_s30=0;
	$fg_s31=0;
	$fg_s32=0;
	$fg_s33=0;
	$fg_s34=0;
	$fg_s35=0;
	$fg_s36=0;
	$fg_s37=0;
	$fg_s38=0;
	$fg_s39=0;
	$fg_s40=0;
	$fg_s41=0;
	$fg_s42=0;
	$fg_s43=0;
	$fg_s44=0;
	$fg_s45=0;
	$fg_s46=0;
	$fg_s47=0;
	$fg_s48=0;
	$fg_s49=0;
	$fg_s50=0;


if($color_x=='0')
{
	$sql="select SUM(IF(size_code=\"xs\",carton_act_qty,0)) AS \"xs\", SUM(IF(size_code=\"s\",carton_act_qty,0)) AS \"s\", SUM(IF(size_code=\"m\",carton_act_qty,0)) AS \"m\", SUM(IF(size_code=\"l\",carton_act_qty,0)) AS \"l\", SUM(IF(size_code=\"xl\",carton_act_qty,0)) AS \"xl\", SUM(IF(size_code=\"xxl\",carton_act_qty,0)) AS \"xxl\", SUM(IF(size_code=\"xxxl\",carton_act_qty,0)) AS \"xxxl\"
,SUM(IF(size_code=\"s01\",carton_act_qty,0)) AS \"s01\",SUM(IF(size_code=\"s02\",carton_act_qty,0)) AS \"s02\",SUM(IF(size_code=\"s03\",carton_act_qty,0)) AS \"s03\"
, SUM(IF(size_code=\"s04\",carton_act_qty,0)) AS \"s04\",SUM(IF(size_code=\"s05\",carton_act_qty,0)) AS \"s05\",SUM(IF(size_code=\"s06\",carton_act_qty,0)) AS \"s06\"
, SUM(IF(size_code=\"s07\",carton_act_qty,0)) AS \"s07\", SUM(IF(size_code=\"s08\",carton_act_qty,0)) AS \"s08\", SUM(IF(size_code=\"s09\",carton_act_qty,0)) AS \"s09\"
, SUM(IF(size_code=\"s10\",carton_act_qty,0)) AS \"s10\", SUM(IF(size_code=\"s11\",carton_act_qty,0)) AS \"s11\", SUM(IF(size_code=\"s12\",carton_act_qty,0)) AS \"s12\"
, SUM(IF(size_code=\"s13\",carton_act_qty,0)) AS \"s13\", SUM(IF(size_code=\"s14\",carton_act_qty,0)) AS \"s14\", SUM(IF(size_code=\"s15\",carton_act_qty,0)) AS \"s15\"
, SUM(IF(size_code=\"s16\",carton_act_qty,0)) AS \"s16\", SUM(IF(size_code=\"s17\",carton_act_qty,0)) AS \"s17\", SUM(IF(size_code=\"s18\",carton_act_qty,0)) AS \"s18\"
, SUM(IF(size_code=\"s19\",carton_act_qty,0)) AS \"s19\", SUM(IF(size_code=\"s20\",carton_act_qty,0)) AS \"s20\", SUM(IF(size_code=\"s21\",carton_act_qty,0)) AS \"s21\"
, SUM(IF(size_code=\"s22\",carton_act_qty,0)) AS \"s22\", SUM(IF(size_code=\"s23\",carton_act_qty,0)) AS \"s23\", SUM(IF(size_code=\"s24\",carton_act_qty,0)) AS \"s24\"
, SUM(IF(size_code=\"s25\",carton_act_qty,0)) AS \"s25\", SUM(IF(size_code=\"s26\",carton_act_qty,0)) AS \"s26\", SUM(IF(size_code=\"s27\",carton_act_qty,0)) AS \"s27\"
, SUM(IF(size_code=\"s28\",carton_act_qty,0)) AS \"s28\", SUM(IF(size_code=\"s29\",carton_act_qty,0)) AS \"s29\", SUM(IF(size_code=\"s30\",carton_act_qty,0)) AS \"s30\"
, SUM(IF(size_code=\"s31\",carton_act_qty,0)) AS \"s31\", SUM(IF(size_code=\"s32\",carton_act_qty,0)) AS \"s32\", SUM(IF(size_code=\"s33\",carton_act_qty,0)) AS \"s33\"
, SUM(IF(size_code=\"s34\",carton_act_qty,0)) AS \"s34\", SUM(IF(size_code=\"s35\",carton_act_qty,0)) AS \"s35\", SUM(IF(size_code=\"s36\",carton_act_qty,0)) AS \"s36\"
, SUM(IF(size_code=\"s37\",carton_act_qty,0)) AS \"s37\", SUM(IF(size_code=\"s38\",carton_act_qty,0)) AS \"s38\", SUM(IF(size_code=\"s39\",carton_act_qty,0)) AS \"s39\"
, SUM(IF(size_code=\"s40\",carton_act_qty,0)) AS \"s40\", SUM(IF(size_code=\"s41\",carton_act_qty,0)) AS \"s41\", SUM(IF(size_code=\"s42\",carton_act_qty,0)) AS \"s42\"
, SUM(IF(size_code=\"s43\",carton_act_qty,0)) AS \"s43\", SUM(IF(size_code=\"s44\",carton_act_qty,0)) AS \"s44\", SUM(IF(size_code=\"s45\",carton_act_qty,0)) AS \"s45\"
, SUM(IF(size_code=\"s46\",carton_act_qty,0)) AS \"s46\", SUM(IF(size_code=\"s47\",carton_act_qty,0)) AS \"s47\", SUM(IF(size_code=\"s48\",carton_act_qty,0)) AS \"s48\"
, SUM(IF(size_code=\"s49\",carton_act_qty,0)) AS \"s49\", SUM(IF(size_code=\"s50\",carton_act_qty,0)) AS \"s50\" from $bai_pro3.packing_summary where order_style_no=\"$style_x\" and order_del_no=\"$schedule_x\" and status=\"DONE\"";
}
else
{
	$sql="select SUM(IF(size_code=\"xs\",carton_act_qty,0)) AS \"xs\", SUM(IF(size_code=\"s\",carton_act_qty,0)) AS \"s\", SUM(IF(size_code=\"m\",carton_act_qty,0)) AS \"m\", SUM(IF(size_code=\"l\",carton_act_qty,0)) AS \"l\", SUM(IF(size_code=\"xl\",carton_act_qty,0)) AS \"xl\", SUM(IF(size_code=\"xxl\",carton_act_qty,0)) AS \"xxl\", SUM(IF(size_code=\"xxxl\",carton_act_qty,0)) AS \"xxxl\",SUM(IF(size_code=\"s01\",carton_act_qty,0)) AS \"s01\",SUM(IF(size_code=\"s02\",carton_act_qty,0)) AS \"s02\",SUM(IF(size_code=\"s03\",carton_act_qty,0)) AS \"s03\"
, SUM(IF(size_code=\"s04\",carton_act_qty,0)) AS \"s04\",SUM(IF(size_code=\"s05\",carton_act_qty,0)) AS \"s05\",SUM(IF(size_code=\"s06\",carton_act_qty,0)) AS \"s06\"
, SUM(IF(size_code=\"s07\",carton_act_qty,0)) AS \"s07\", SUM(IF(size_code=\"s08\",carton_act_qty,0)) AS \"s08\", SUM(IF(size_code=\"s09\",carton_act_qty,0)) AS \"s09\"
, SUM(IF(size_code=\"s10\",carton_act_qty,0)) AS \"s10\", SUM(IF(size_code=\"s11\",carton_act_qty,0)) AS \"s11\", SUM(IF(size_code=\"s12\",carton_act_qty,0)) AS \"s12\"
, SUM(IF(size_code=\"s13\",carton_act_qty,0)) AS \"s13\", SUM(IF(size_code=\"s14\",carton_act_qty,0)) AS \"s14\", SUM(IF(size_code=\"s15\",carton_act_qty,0)) AS \"s15\"
, SUM(IF(size_code=\"s16\",carton_act_qty,0)) AS \"s16\", SUM(IF(size_code=\"s17\",carton_act_qty,0)) AS \"s17\", SUM(IF(size_code=\"s18\",carton_act_qty,0)) AS \"s18\"
, SUM(IF(size_code=\"s19\",carton_act_qty,0)) AS \"s19\", SUM(IF(size_code=\"s20\",carton_act_qty,0)) AS \"s20\", SUM(IF(size_code=\"s21\",carton_act_qty,0)) AS \"s21\"
, SUM(IF(size_code=\"s22\",carton_act_qty,0)) AS \"s22\", SUM(IF(size_code=\"s23\",carton_act_qty,0)) AS \"s23\", SUM(IF(size_code=\"s24\",carton_act_qty,0)) AS \"s24\"
, SUM(IF(size_code=\"s25\",carton_act_qty,0)) AS \"s25\", SUM(IF(size_code=\"s26\",carton_act_qty,0)) AS \"s26\", SUM(IF(size_code=\"s27\",carton_act_qty,0)) AS \"s27\"
, SUM(IF(size_code=\"s28\",carton_act_qty,0)) AS \"s28\", SUM(IF(size_code=\"s29\",carton_act_qty,0)) AS \"s29\", SUM(IF(size_code=\"s30\",carton_act_qty,0)) AS \"s30\"
, SUM(IF(size_code=\"s31\",carton_act_qty,0)) AS \"s31\", SUM(IF(size_code=\"s32\",carton_act_qty,0)) AS \"s32\", SUM(IF(size_code=\"s33\",carton_act_qty,0)) AS \"s33\"
, SUM(IF(size_code=\"s34\",carton_act_qty,0)) AS \"s34\", SUM(IF(size_code=\"s35\",carton_act_qty,0)) AS \"s35\", SUM(IF(size_code=\"s36\",carton_act_qty,0)) AS \"s36\"
, SUM(IF(size_code=\"s37\",carton_act_qty,0)) AS \"s37\", SUM(IF(size_code=\"s38\",carton_act_qty,0)) AS \"s38\", SUM(IF(size_code=\"s39\",carton_act_qty,0)) AS \"s39\"
, SUM(IF(size_code=\"s40\",carton_act_qty,0)) AS \"s40\", SUM(IF(size_code=\"s41\",carton_act_qty,0)) AS \"s41\", SUM(IF(size_code=\"s42\",carton_act_qty,0)) AS \"s42\"
, SUM(IF(size_code=\"s43\",carton_act_qty,0)) AS \"s43\", SUM(IF(size_code=\"s44\",carton_act_qty,0)) AS \"s44\", SUM(IF(size_code=\"s45\",carton_act_qty,0)) AS \"s45\"
, SUM(IF(size_code=\"s46\",carton_act_qty,0)) AS \"s46\", SUM(IF(size_code=\"s47\",carton_act_qty,0)) AS \"s47\", SUM(IF(size_code=\"s48\",carton_act_qty,0)) AS \"s48\"
, SUM(IF(size_code=\"s49\",carton_act_qty,0)) AS \"s49\", SUM(IF(size_code=\"s50\",carton_act_qty,0)) AS \"s50\"
 from $bai_pro3.packing_summary where order_style_no=\"$style_x\" and order_del_no=\"$schedule_x\" and order_col_des=\"$color_x\" and status=\"DONE\"";
}
//echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$fg_xs+=$sql_row['xs'];
		$fg_s+=$sql_row['s'];
		$fg_m+=$sql_row['m'];
		$fg_l+=$sql_row['l'];
		$fg_xl+=$sql_row['xl'];
		$fg_xxl+=$sql_row['xxl'];
		$fg_xxxl+=$sql_row['xxxl'];
		
		$fg_s01+=$sql_row['s01'];
		$fg_s02+=$sql_row['s02'];
		$fg_s03+=$sql_row['s03'];
		$fg_s04+=$sql_row['s04'];
		$fg_s05+=$sql_row['s05'];
		$fg_s06+=$sql_row['s06'];
		$fg_s07+=$sql_row['s07'];
		$fg_s08+=$sql_row['s08'];
		$fg_s09+=$sql_row['s09'];
		$fg_s10+=$sql_row['s10'];
		$fg_s11+=$sql_row['s11'];
		$fg_s12+=$sql_row['s12'];
		$fg_s13+=$sql_row['s13'];
		$fg_s14+=$sql_row['s14'];
		$fg_s15+=$sql_row['s15'];
		$fg_s16+=$sql_row['s16'];
		$fg_s17+=$sql_row['s17'];
		$fg_s18+=$sql_row['s18'];
		$fg_s19+=$sql_row['s19'];
		$fg_s20+=$sql_row['s20'];
		$fg_s21+=$sql_row['s21'];
		$fg_s22+=$sql_row['s22'];
		$fg_s23+=$sql_row['s23'];
		$fg_s24+=$sql_row['s24'];
		$fg_s25+=$sql_row['s25'];
		$fg_s26+=$sql_row['s26'];
		$fg_s27+=$sql_row['s27'];
		$fg_s28+=$sql_row['s28'];
		$fg_s29+=$sql_row['s29'];
		$fg_s30+=$sql_row['s30'];
		$fg_s31+=$sql_row['s31'];
		$fg_s32+=$sql_row['s32'];
		$fg_s33+=$sql_row['s33'];
		$fg_s34+=$sql_row['s34'];
		$fg_s35+=$sql_row['s35'];
		$fg_s36+=$sql_row['s36'];
		$fg_s37+=$sql_row['s37'];
		$fg_s38+=$sql_row['s38'];
		$fg_s39+=$sql_row['s39'];
		$fg_s40+=$sql_row['s40'];
		$fg_s41+=$sql_row['s41'];
		$fg_s42+=$sql_row['s42'];
		$fg_s43+=$sql_row['s43'];
		$fg_s44+=$sql_row['s44'];
		$fg_s45+=$sql_row['s45'];
		$fg_s46+=$sql_row['s46'];
		$fg_s47+=$sql_row['s47'];
		$fg_s48+=$sql_row['s48'];
		$fg_s49+=$sql_row['s49'];
		$fg_s50+=$sql_row['s50'];

	}
	
	$pass_xs=0;
	$pass_s=0;
	$pass_m=0;
	$pass_l=0;
	$pass_xl=0;
	$pass_xxl=0;
	$pass_xxxl=0;
	$pass_s01=0;
	$pass_s02=0;
	$pass_s03=0;
	$pass_s04=0;
	$pass_s05=0;
	$pass_s06=0;
	$pass_s07=0;
	$pass_s08=0;
	$pass_s09=0;
	$pass_s10=0;
	$pass_s11=0;
	$pass_s12=0;
	$pass_s13=0;
	$pass_s14=0;
	$pass_s15=0;
	$pass_s16=0;
	$pass_s17=0;
	$pass_s18=0;
	$pass_s19=0;
	$pass_s20=0;
	$pass_s21=0;
	$pass_s22=0;
	$pass_s23=0;
	$pass_s24=0;
	$pass_s25=0;
	$pass_s26=0;
	$pass_s27=0;
	$pass_s28=0;
	$pass_s29=0;
	$pass_s30=0;
	$pass_s31=0;
	$pass_s32=0;
	$pass_s33=0;
	$pass_s34=0;
	$pass_s35=0;
	$pass_s36=0;
	$pass_s37=0;
	$pass_s38=0;
	$pass_s39=0;
	$pass_s40=0;
	$pass_s41=0;
	$pass_s42=0;
	$pass_s43=0;
	$pass_s44=0;
	$pass_s45=0;
	$pass_s46=0;
	$pass_s47=0;
	$pass_s48=0;
	$pass_s49=0;
	$pass_s50=0;

	$fail_xs=0;
	$fail_s=0;
	$fail_m=0;
	$fail_l=0;
	$fail_xl=0;
	$fail_xxl=0;
	$fail_xxxl=0;
	$fail_s01=0;
	$fail_s02=0;
	$fail_s03=0;
	$fail_s04=0;
	$fail_s05=0;
	$fail_s06=0;
	$fail_s07=0;
	$fail_s08=0;
	$fail_s09=0;
	$fail_s10=0;
	$fail_s11=0;
	$fail_s12=0;
	$fail_s13=0;
	$fail_s14=0;
	$fail_s15=0;
	$fail_s16=0;
	$fail_s17=0;
	$fail_s18=0;
	$fail_s19=0;
	$fail_s20=0;
	$fail_s21=0;
	$fail_s22=0;
	$fail_s23=0;
	$fail_s24=0;
	$fail_s25=0;
	$fail_s26=0;
	$fail_s27=0;
	$fail_s28=0;
	$fail_s29=0;
	$fail_s30=0;
	$fail_s31=0;
	$fail_s32=0;
	$fail_s33=0;
	$fail_s34=0;
	$fail_s35=0;
	$fail_s36=0;
	$fail_s37=0;
	$fail_s38=0;
	$fail_s39=0;
	$fail_s40=0;
	$fail_s41=0;
	$fail_s42=0;
	$fail_s43=0;
	$fail_s44=0;
	$fail_s45=0;
	$fail_s46=0;
	$fail_s47=0;
	$fail_s48=0;
	$fail_s49=0;
	$fail_s50=0;


	//$sql="select  SUM(IF(size=\"xs\" and tran_type=1,pcs,0)) as \"pass_xs\", SUM(IF(size=\"s\" and tran_type=1,pcs,0)) as \"pass_s\", SUM(IF(size=\"m\" and tran_type=1,pcs,0)) as \"pass_m\", SUM(IF(size=\"l\" and tran_type=1,pcs,0)) as \"pass_l\", SUM(IF(size=\"xl\" and tran_type=1,pcs,0)) as \"pass_xl\", SUM(IF(size=\"xxl\" and tran_type=1,pcs,0)) as \"pass_xxl\", SUM(IF(size=\"xxxl\" and tran_type=1,pcs,0)) as \"pass_xxxl\", SUM(IF(size=\"s06\" and tran_type=1,pcs,0)) as \"pass_s06\", SUM(IF(size=\"s08\" and tran_type=1,pcs,0)) as \"pass_s08\", SUM(IF(size=\"s10\" and tran_type=1,pcs,0)) as \"pass_s10\", SUM(IF(size=\"s12\" and tran_type=1,pcs,0)) as \"pass_s12\", SUM(IF(size=\"s14\" and tran_type=1,pcs,0)) as \"pass_s14\", SUM(IF(size=\"s16\" and tran_type=1,pcs,0)) as \"pass_s16\", SUM(IF(size=\"s18\" and tran_type=1,pcs,0)) as \"pass_s18\", SUM(IF(size=\"s20\" and tran_type=1,pcs,0)) as \"pass_s20\", SUM(IF(size=\"s22\" and tran_type=1,pcs,0)) as \"pass_s22\", SUM(IF(size=\"s24\" and tran_type=1,pcs,0)) as \"pass_s24\", SUM(IF(size=\"s26\" and tran_type=1,pcs,0)) as \"pass_s26\", SUM(IF(size=\"s28\" and tran_type=1,pcs,0)) as \"pass_s28\", SUM(IF(size=\"s30\" and tran_type=1,pcs,0)) as \"pass_s30\", SUM(IF(size=\"xs\" and tran_type=2,pcs,0)) as \"fail_xs\", SUM(IF(size=\"s\" and tran_type=2,pcs,0)) as \"fail_s\", SUM(IF(size=\"m\" and tran_type=2,pcs,0)) as \"fail_m\", SUM(IF(size=\"l\" and tran_type=2,pcs,0)) as \"fail_l\", SUM(IF(size=\"xl\" and tran_type=2,pcs,0)) as \"fail_xl\", SUM(IF(size=\"xxl\" and tran_type=2,pcs,0)) as \"fail_xxl\", SUM(IF(size=\"xxxl\" and tran_type=2,pcs,0)) as \"fail_xxxl\", SUM(IF(size=\"s06\" and tran_type=2,pcs,0)) as \"fail_s06\", SUM(IF(size=\"s08\" and tran_type=2,pcs,0)) as \"fail_s08\", SUM(IF(size=\"s10\" and tran_type=2,pcs,0)) as \"fail_s10\", SUM(IF(size=\"s12\" and tran_type=2,pcs,0)) as \"fail_s12\", SUM(IF(size=\"s14\" and tran_type=2,pcs,0)) as \"fail_s14\", SUM(IF(size=\"s16\" and tran_type=2,pcs,0)) as \"fail_s16\", SUM(IF(size=\"s18\" and tran_type=2,pcs,0)) as \"fail_s18\", SUM(IF(size=\"s20\" and tran_type=2,pcs,0)) as \"fail_s20\", SUM(IF(size=\"s22\" and tran_type=2,pcs,0)) as \"fail_s22\", SUM(IF(size=\"s24\" and tran_type=2,pcs,0)) as \"fail_s24\", SUM(IF(size=\"s26\" and tran_type=2,pcs,0)) as \"fail_s26\", SUM(IF(size=\"s28\" and tran_type=2,pcs,0)) as \"fail_s28\", SUM(IF(size=\"s30\" and tran_type=2,pcs,0)) as \"fail_s30\" from audit_fail_db where style=\"$style_x\" and schedule=\"$schedule_x\"";

//New query to allocate orders after FCA and insted of MCA
if($color_x=='0')
{

$sql="select  SUM(IF(size=\"xs\" and tran_type=1,pcs,0)) as \"pass_xs\", SUM(IF(size=\"s\" and tran_type=1,pcs,0)) as \"pass_s\", SUM(IF(size=\"m\" and tran_type=1,pcs,0)) as \"pass_m\", SUM(IF(size=\"l\" and tran_type=1,pcs,0)) as \"pass_l\", SUM(IF(size=\"xl\" and tran_type=1,pcs,0)) as \"pass_xl\", SUM(IF(size=\"xxl\" and tran_type=1,pcs,0)) as \"pass_xxl\", SUM(IF(size=\"xxxl\" and tran_type=1,pcs,0)) as \"pass_xxxl\", SUM(IF(size=\"s01\" and tran_type=1,pcs,0)) as \"pass_s01\", SUM(IF(size=\"s02\" and tran_type=1,pcs,0)) as \"pass_s02\", SUM(IF(size=\"s03\" and tran_type=1,pcs,0)) as \"pass_s03\"
, SUM(IF(size=\"s04\" and tran_type=1,pcs,0)) as \"pass_s04\", SUM(IF(size=\"s05\" and tran_type=1,pcs,0)) as \"pass_s05\", SUM(IF(size=\"s06\" and tran_type=1,pcs,0)) as \"pass_s06\", SUM(IF(size=\"s07\" and tran_type=1,pcs,0)) as \"pass_s07\", SUM(IF(size=\"s08\" and tran_type=1,pcs,0)) as \"pass_s08\"
, SUM(IF(size=\"s09\" and tran_type=1,pcs,0)) as \"pass_s09\", SUM(IF(size=\"s10\" and tran_type=1,pcs,0)) as \"pass_s10\", SUM(IF(size=\"s11\" and tran_type=1,pcs,0)) as \"pass_s11\", SUM(IF(size=\"s12\" and tran_type=1,pcs,0)) as \"pass_s12\", SUM(IF(size=\"s13\" and tran_type=1,pcs,0)) as \"pass_s13\"
, SUM(IF(size=\"s14\" and tran_type=1,pcs,0)) as \"pass_s14\", SUM(IF(size=\"s15\" and tran_type=1,pcs,0)) as \"pass_s15\", SUM(IF(size=\"s16\" and tran_type=1,pcs,0)) as \"pass_s16\", SUM(IF(size=\"s17\" and tran_type=1,pcs,0)) as \"pass_s17\", SUM(IF(size=\"s18\" and tran_type=1,pcs,0)) as \"pass_s18\"
, SUM(IF(size=\"s19\" and tran_type=1,pcs,0)) as \"pass_s19\", SUM(IF(size=\"s20\" and tran_type=1,pcs,0)) as \"pass_s20\", SUM(IF(size=\"s21\" and tran_type=1,pcs,0)) as \"pass_s21\", SUM(IF(size=\"s22\" and tran_type=1,pcs,0)) as \"pass_s22\", SUM(IF(size=\"s23\" and tran_type=1,pcs,0)) as \"pass_s23\"
, SUM(IF(size=\"s24\" and tran_type=1,pcs,0)) as \"pass_s24\", SUM(IF(size=\"s25\" and tran_type=1,pcs,0)) as \"pass_s25\", SUM(IF(size=\"s26\" and tran_type=1,pcs,0)) as \"pass_s26\", SUM(IF(size=\"s27\" and tran_type=1,pcs,0)) as \"pass_s27\", SUM(IF(size=\"s28\" and tran_type=1,pcs,0)) as \"pass_s28\", SUM(IF(size=\"s29\" and tran_type=1,pcs,0)) as \"pass_s29\", SUM(IF(size=\"s30\" and tran_type=1,pcs,0)) as \"pass_s30\", SUM(IF(size=\"s31\" and tran_type=1,pcs,0)) as \"pass_s31\", SUM(IF(size=\"s32\" and tran_type=1,pcs,0)) as \"pass_s32\", SUM(IF(size=\"s33\" and tran_type=1,pcs,0)) as \"pass_s33\", SUM(IF(size=\"s34\" and tran_type=1,pcs,0)) as \"pass_s34\", SUM(IF(size=\"s35\" and tran_type=1,pcs,0)) as \"pass_s35\", SUM(IF(size=\"s36\" and tran_type=1,pcs,0)) as \"pass_s36\", SUM(IF(size=\"s37\" and tran_type=1,pcs,0)) as \"pass_s37\", SUM(IF(size=\"s38\" and tran_type=1,pcs,0)) as \"pass_s38\", SUM(IF(size=\"s39\" and tran_type=1,pcs,0)) as \"pass_s39\", SUM(IF(size=\"s40\" and tran_type=1,pcs,0)) as \"pass_s40\", SUM(IF(size=\"s41\" and tran_type=1,pcs,0)) as \"pass_s41\", SUM(IF(size=\"s42\" and tran_type=1,pcs,0)) as \"pass_s42\", SUM(IF(size=\"s43\" and tran_type=1,pcs,0)) as \"pass_s43\", SUM(IF(size=\"s44\" and tran_type=1,pcs,0)) as \"pass_s44\"
, SUM(IF(size=\"s45\" and tran_type=1,pcs,0)) as \"pass_s45\", SUM(IF(size=\"s46\" and tran_type=1,pcs,0)) as \"pass_s46\", SUM(IF(size=\"s47\" and tran_type=1,pcs,0)) as \"pass_s47\", SUM(IF(size=\"s48\" and tran_type=1,pcs,0)) as \"pass_s48\", SUM(IF(size=\"s49\" and tran_type=1,pcs,0)) as \"pass_s49\"
, SUM(IF(size=\"s50\" and tran_type=1,pcs,0)) as \"pass_s50\", SUM(IF(size=\"xs\" and tran_type=2,pcs,0)) as \"fail_xs\", SUM(IF(size=\"s\" and tran_type=2,pcs,0)) as \"fail_s\", SUM(IF(size=\"m\" and tran_type=2,pcs,0)) as \"fail_m\", SUM(IF(size=\"l\" and tran_type=2,pcs,0)) as \"fail_l\", SUM(IF(size=\"xl\" and tran_type=2,pcs,0)) as \"fail_xl\", SUM(IF(size=\"xxl\" and tran_type=2,pcs,0)) as \"fail_xxl\", SUM(IF(size=\"xxxl\" and tran_type=2,pcs,0)) as \"fail_xxxl\", SUM(IF(size=\"s01\" and tran_type=2,pcs,0)) as \"fail_s01\", SUM(IF(size=\"s02\" and tran_type=2,pcs,0)) as \"fail_s02\", SUM(IF(size=\"s03\" and tran_type=2,pcs,0)) as \"fail_s03\", SUM(IF(size=\"s04\" and tran_type=2,pcs,0)) as \"fail_s04\", SUM(IF(size=\"s05\" and tran_type=2,pcs,0)) as \"fail_s05\", SUM(IF(size=\"s06\" and tran_type=2,pcs,0)) as \"fail_s06\", SUM(IF(size=\"s07\" and tran_type=2,pcs,0)) as \"fail_s07\", SUM(IF(size=\"s08\" and tran_type=2,pcs,0)) as \"fail_s08\"
, SUM(IF(size=\"s09\" and tran_type=2,pcs,0)) as \"fail_s09\", SUM(IF(size=\"s10\" and tran_type=2,pcs,0)) as \"fail_s10\", SUM(IF(size=\"s11\" and tran_type=2,pcs,0)) as \"fail_s11\", SUM(IF(size=\"s12\" and tran_type=2,pcs,0)) as \"fail_s12\", SUM(IF(size=\"s13\" and tran_type=2,pcs,0)) as \"fail_s13\"
, SUM(IF(size=\"s14\" and tran_type=2,pcs,0)) as \"fail_s14\", SUM(IF(size=\"s15\" and tran_type=2,pcs,0)) as \"fail_s15\", SUM(IF(size=\"s16\" and tran_type=2,pcs,0)) as \"fail_s16\", SUM(IF(size=\"s17\" and tran_type=2,pcs,0)) as \"fail_s17\", SUM(IF(size=\"s18\" and tran_type=2,pcs,0)) as \"fail_s18\"
, SUM(IF(size=\"s19\" and tran_type=2,pcs,0)) as \"fail_s19\", SUM(IF(size=\"s20\" and tran_type=2,pcs,0)) as \"fail_s20\", SUM(IF(size=\"s21\" and tran_type=2,pcs,0)) as \"fail_s21\", SUM(IF(size=\"s22\" and tran_type=2,pcs,0)) as \"fail_s22\", SUM(IF(size=\"s23\" and tran_type=2,pcs,0)) as \"fail_s23\"
, SUM(IF(size=\"s24\" and tran_type=2,pcs,0)) as \"fail_s24\", SUM(IF(size=\"s25\" and tran_type=2,pcs,0)) as \"fail_s25\", SUM(IF(size=\"s26\" and tran_type=2,pcs,0)) as \"fail_s26\", SUM(IF(size=\"s27\" and tran_type=2,pcs,0)) as \"fail_s27\", SUM(IF(size=\"s28\" and tran_type=2,pcs,0)) as \"fail_s28\"
, SUM(IF(size=\"s29\" and tran_type=2,pcs,0)) as \"fail_s29\", SUM(IF(size=\"s30\" and tran_type=2,pcs,0)) as \"fail_s30\", SUM(IF(size=\"s31\" and tran_type=2,pcs,0)) as \"fail_s31\", SUM(IF(size=\"s32\" and tran_type=2,pcs,0)) as \"fail_s32\", SUM(IF(size=\"s33\" and tran_type=2,pcs,0)) as \"fail_s33\"
, SUM(IF(size=\"s34\" and tran_type=2,pcs,0)) as \"fail_s34\", SUM(IF(size=\"s35\" and tran_type=2,pcs,0)) as \"fail_s35\", SUM(IF(size=\"s36\" and tran_type=2,pcs,0)) as \"fail_s36\", SUM(IF(size=\"s37\" and tran_type=2,pcs,0)) as \"fail_s37\", SUM(IF(size=\"s38\" and tran_type=2,pcs,0)) as \"fail_s38\"
, SUM(IF(size=\"s39\" and tran_type=2,pcs,0)) as \"fail_s39\", SUM(IF(size=\"s40\" and tran_type=2,pcs,0)) as \"fail_s40\", SUM(IF(size=\"s41\" and tran_type=2,pcs,0)) as \"fail_s41\", SUM(IF(size=\"s42\" and tran_type=2,pcs,0)) as \"fail_s42\", SUM(IF(size=\"s43\" and tran_type=2,pcs,0)) as \"fail_s43\"
, SUM(IF(size=\"s44\" and tran_type=2,pcs,0)) as \"fail_s44\", SUM(IF(size=\"s45\" and tran_type=2,pcs,0)) as \"fail_s45\", SUM(IF(size=\"s46\" and tran_type=2,pcs,0)) as \"fail_s46\", SUM(IF(size=\"s47\" and tran_type=2,pcs,0)) as \"fail_s47\", SUM(IF(size=\"s48\" and tran_type=2,pcs,0)) as \"fail_s48\"
, SUM(IF(size=\"s49\" and tran_type=2,pcs,0)) as \"fail_s49\", SUM(IF(size=\"s50\" and tran_type=2,pcs,0)) as \"fail_s50\" from $bai_pro3.fca_audit_fail_db where style=\"$style_x\" and schedule=\"$schedule_x\"";
}
else
{
	$sql="select  SUM(IF(size=\"xs\" and tran_type=1,pcs,0)) as \"pass_xs\", SUM(IF(size=\"s\" and tran_type=1,pcs,0)) as \"pass_s\", SUM(IF(size=\"m\" and tran_type=1,pcs,0)) as \"pass_m\", SUM(IF(size=\"l\" and tran_type=1,pcs,0)) as \"pass_l\", SUM(IF(size=\"xl\" and tran_type=1,pcs,0)) as \"pass_xl\", SUM(IF(size=\"xxl\" and tran_type=1,pcs,0)) as \"pass_xxl\", SUM(IF(size=\"xxxl\" and tran_type=1,pcs,0)) as \"pass_xxxl\", SUM(IF(size=\"s01\" and tran_type=1,pcs,0)) as \"pass_s01\", SUM(IF(size=\"s02\" and tran_type=1,pcs,0)) as \"pass_s02\", SUM(IF(size=\"s03\" and tran_type=1,pcs,0)) as \"pass_s03\"
, SUM(IF(size=\"s04\" and tran_type=1,pcs,0)) as \"pass_s04\", SUM(IF(size=\"s05\" and tran_type=1,pcs,0)) as \"pass_s05\", SUM(IF(size=\"s06\" and tran_type=1,pcs,0)) as \"pass_s06\", SUM(IF(size=\"s07\" and tran_type=1,pcs,0)) as \"pass_s07\", SUM(IF(size=\"s08\" and tran_type=1,pcs,0)) as \"pass_s08\"
, SUM(IF(size=\"s09\" and tran_type=1,pcs,0)) as \"pass_s09\", SUM(IF(size=\"s10\" and tran_type=1,pcs,0)) as \"pass_s10\", SUM(IF(size=\"s11\" and tran_type=1,pcs,0)) as \"pass_s11\", SUM(IF(size=\"s12\" and tran_type=1,pcs,0)) as \"pass_s12\", SUM(IF(size=\"s13\" and tran_type=1,pcs,0)) as \"pass_s13\"
, SUM(IF(size=\"s14\" and tran_type=1,pcs,0)) as \"pass_s14\", SUM(IF(size=\"s15\" and tran_type=1,pcs,0)) as \"pass_s15\", SUM(IF(size=\"s16\" and tran_type=1,pcs,0)) as \"pass_s16\", SUM(IF(size=\"s17\" and tran_type=1,pcs,0)) as \"pass_s17\", SUM(IF(size=\"s18\" and tran_type=1,pcs,0)) as \"pass_s18\"
, SUM(IF(size=\"s19\" and tran_type=1,pcs,0)) as \"pass_s19\", SUM(IF(size=\"s20\" and tran_type=1,pcs,0)) as \"pass_s20\", SUM(IF(size=\"s21\" and tran_type=1,pcs,0)) as \"pass_s21\", SUM(IF(size=\"s22\" and tran_type=1,pcs,0)) as \"pass_s22\", SUM(IF(size=\"s23\" and tran_type=1,pcs,0)) as \"pass_s23\"
, SUM(IF(size=\"s24\" and tran_type=1,pcs,0)) as \"pass_s24\", SUM(IF(size=\"s25\" and tran_type=1,pcs,0)) as \"pass_s25\", SUM(IF(size=\"s26\" and tran_type=1,pcs,0)) as \"pass_s26\", SUM(IF(size=\"s27\" and tran_type=1,pcs,0)) as \"pass_s27\", SUM(IF(size=\"s28\" and tran_type=1,pcs,0)) as \"pass_s28\", SUM(IF(size=\"s29\" and tran_type=1,pcs,0)) as \"pass_s29\", SUM(IF(size=\"s30\" and tran_type=1,pcs,0)) as \"pass_s30\", SUM(IF(size=\"s31\" and tran_type=1,pcs,0)) as \"pass_s31\", SUM(IF(size=\"s32\" and tran_type=1,pcs,0)) as \"pass_s32\", SUM(IF(size=\"s33\" and tran_type=1,pcs,0)) as \"pass_s33\", SUM(IF(size=\"s34\" and tran_type=1,pcs,0)) as \"pass_s34\", SUM(IF(size=\"s35\" and tran_type=1,pcs,0)) as \"pass_s35\", SUM(IF(size=\"s36\" and tran_type=1,pcs,0)) as \"pass_s36\", SUM(IF(size=\"s37\" and tran_type=1,pcs,0)) as \"pass_s37\", SUM(IF(size=\"s38\" and tran_type=1,pcs,0)) as \"pass_s38\", SUM(IF(size=\"s39\" and tran_type=1,pcs,0)) as \"pass_s39\", SUM(IF(size=\"s40\" and tran_type=1,pcs,0)) as \"pass_s40\", SUM(IF(size=\"s41\" and tran_type=1,pcs,0)) as \"pass_s41\", SUM(IF(size=\"s42\" and tran_type=1,pcs,0)) as \"pass_s42\", SUM(IF(size=\"s43\" and tran_type=1,pcs,0)) as \"pass_s43\", SUM(IF(size=\"s44\" and tran_type=1,pcs,0)) as \"pass_s44\"
, SUM(IF(size=\"s45\" and tran_type=1,pcs,0)) as \"pass_s45\", SUM(IF(size=\"s46\" and tran_type=1,pcs,0)) as \"pass_s46\", SUM(IF(size=\"s47\" and tran_type=1,pcs,0)) as \"pass_s47\", SUM(IF(size=\"s48\" and tran_type=1,pcs,0)) as \"pass_s48\", SUM(IF(size=\"s49\" and tran_type=1,pcs,0)) as \"pass_s49\"
, SUM(IF(size=\"s50\" and tran_type=1,pcs,0)) as \"pass_s50\", SUM(IF(size=\"xs\" and tran_type=2,pcs,0)) as \"fail_xs\", SUM(IF(size=\"s\" and tran_type=2,pcs,0)) as \"fail_s\", SUM(IF(size=\"m\" and tran_type=2,pcs,0)) as \"fail_m\", SUM(IF(size=\"l\" and tran_type=2,pcs,0)) as \"fail_l\", SUM(IF(size=\"xl\" and tran_type=2,pcs,0)) as \"fail_xl\", SUM(IF(size=\"xxl\" and tran_type=2,pcs,0)) as \"fail_xxl\", SUM(IF(size=\"xxxl\" and tran_type=2,pcs,0)) as \"fail_xxxl\", SUM(IF(size=\"s01\" and tran_type=2,pcs,0)) as \"fail_s01\", SUM(IF(size=\"s02\" and tran_type=2,pcs,0)) as \"fail_s02\", SUM(IF(size=\"s03\" and tran_type=2,pcs,0)) as \"fail_s03\", SUM(IF(size=\"s04\" and tran_type=2,pcs,0)) as \"fail_s04\", SUM(IF(size=\"s05\" and tran_type=2,pcs,0)) as \"fail_s05\", SUM(IF(size=\"s06\" and tran_type=2,pcs,0)) as \"fail_s06\", SUM(IF(size=\"s07\" and tran_type=2,pcs,0)) as \"fail_s07\", SUM(IF(size=\"s08\" and tran_type=2,pcs,0)) as \"fail_s08\"
, SUM(IF(size=\"s09\" and tran_type=2,pcs,0)) as \"fail_s09\", SUM(IF(size=\"s10\" and tran_type=2,pcs,0)) as \"fail_s10\", SUM(IF(size=\"s11\" and tran_type=2,pcs,0)) as \"fail_s11\", SUM(IF(size=\"s12\" and tran_type=2,pcs,0)) as \"fail_s12\", SUM(IF(size=\"s13\" and tran_type=2,pcs,0)) as \"fail_s13\"
, SUM(IF(size=\"s14\" and tran_type=2,pcs,0)) as \"fail_s14\", SUM(IF(size=\"s15\" and tran_type=2,pcs,0)) as \"fail_s15\", SUM(IF(size=\"s16\" and tran_type=2,pcs,0)) as \"fail_s16\", SUM(IF(size=\"s17\" and tran_type=2,pcs,0)) as \"fail_s17\", SUM(IF(size=\"s18\" and tran_type=2,pcs,0)) as \"fail_s18\"
, SUM(IF(size=\"s19\" and tran_type=2,pcs,0)) as \"fail_s19\", SUM(IF(size=\"s20\" and tran_type=2,pcs,0)) as \"fail_s20\", SUM(IF(size=\"s21\" and tran_type=2,pcs,0)) as \"fail_s21\", SUM(IF(size=\"s22\" and tran_type=2,pcs,0)) as \"fail_s22\", SUM(IF(size=\"s23\" and tran_type=2,pcs,0)) as \"fail_s23\"
, SUM(IF(size=\"s24\" and tran_type=2,pcs,0)) as \"fail_s24\", SUM(IF(size=\"s25\" and tran_type=2,pcs,0)) as \"fail_s25\", SUM(IF(size=\"s26\" and tran_type=2,pcs,0)) as \"fail_s26\", SUM(IF(size=\"s27\" and tran_type=2,pcs,0)) as \"fail_s27\", SUM(IF(size=\"s28\" and tran_type=2,pcs,0)) as \"fail_s28\"
, SUM(IF(size=\"s29\" and tran_type=2,pcs,0)) as \"fail_s29\", SUM(IF(size=\"s30\" and tran_type=2,pcs,0)) as \"fail_s30\", SUM(IF(size=\"s31\" and tran_type=2,pcs,0)) as \"fail_s31\", SUM(IF(size=\"s32\" and tran_type=2,pcs,0)) as \"fail_s32\", SUM(IF(size=\"s33\" and tran_type=2,pcs,0)) as \"fail_s33\"
, SUM(IF(size=\"s34\" and tran_type=2,pcs,0)) as \"fail_s34\", SUM(IF(size=\"s35\" and tran_type=2,pcs,0)) as \"fail_s35\", SUM(IF(size=\"s36\" and tran_type=2,pcs,0)) as \"fail_s36\", SUM(IF(size=\"s37\" and tran_type=2,pcs,0)) as \"fail_s37\", SUM(IF(size=\"s38\" and tran_type=2,pcs,0)) as \"fail_s38\"
, SUM(IF(size=\"s39\" and tran_type=2,pcs,0)) as \"fail_s39\", SUM(IF(size=\"s40\" and tran_type=2,pcs,0)) as \"fail_s40\", SUM(IF(size=\"s41\" and tran_type=2,pcs,0)) as \"fail_s41\", SUM(IF(size=\"s42\" and tran_type=2,pcs,0)) as \"fail_s42\", SUM(IF(size=\"s43\" and tran_type=2,pcs,0)) as \"fail_s43\"
, SUM(IF(size=\"s44\" and tran_type=2,pcs,0)) as \"fail_s44\", SUM(IF(size=\"s45\" and tran_type=2,pcs,0)) as \"fail_s45\", SUM(IF(size=\"s46\" and tran_type=2,pcs,0)) as \"fail_s46\", SUM(IF(size=\"s47\" and tran_type=2,pcs,0)) as \"fail_s47\", SUM(IF(size=\"s48\" and tran_type=2,pcs,0)) as \"fail_s48\"
, SUM(IF(size=\"s49\" and tran_type=2,pcs,0)) as \"fail_s49\", SUM(IF(size=\"s50\" and tran_type=2,pcs,0)) as \"fail_s50\" from $bai_pro3.fca_audit_fail_db where style=\"$style_x\" and schedule=\"$schedule_x\" and color=\"$color_x\"";
}
	mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$pass_xs=$sql_row['pass_xs'];
		$pass_s=$sql_row['pass_s'];
		$pass_m=$sql_row['pass_m'];
		$pass_l=$sql_row['pass_l'];
		$pass_xl=$sql_row['pass_xl'];
		$pass_xxl=$sql_row['pass_xxl'];
		$pass_xxxl=$sql_row['pass_xxxl'];
		
		$pass_s01=$sql_row['pass_s01'];
		$pass_s02=$sql_row['pass_s02'];
		$pass_s03=$sql_row['pass_s03'];
		$pass_s04=$sql_row['pass_s04'];
		$pass_s05=$sql_row['pass_s05'];
		$pass_s06=$sql_row['pass_s06'];
		$pass_s07=$sql_row['pass_s07'];
		$pass_s08=$sql_row['pass_s08'];
		$pass_s09=$sql_row['pass_s09'];
		$pass_s10=$sql_row['pass_s10'];
		$pass_s11=$sql_row['pass_s11'];
		$pass_s12=$sql_row['pass_s12'];
		$pass_s13=$sql_row['pass_s13'];
		$pass_s14=$sql_row['pass_s14'];
		$pass_s15=$sql_row['pass_s15'];
		$pass_s16=$sql_row['pass_s16'];
		$pass_s17=$sql_row['pass_s17'];
		$pass_s18=$sql_row['pass_s18'];
		$pass_s19=$sql_row['pass_s19'];
		$pass_s20=$sql_row['pass_s20'];
		$pass_s21=$sql_row['pass_s21'];
		$pass_s22=$sql_row['pass_s22'];
		$pass_s23=$sql_row['pass_s23'];
		$pass_s24=$sql_row['pass_s24'];
		$pass_s25=$sql_row['pass_s25'];
		$pass_s26=$sql_row['pass_s26'];
		$pass_s27=$sql_row['pass_s27'];
		$pass_s28=$sql_row['pass_s28'];
		$pass_s29=$sql_row['pass_s29'];
		$pass_s30=$sql_row['pass_s30'];
		$pass_s31=$sql_row['pass_s31'];
		$pass_s32=$sql_row['pass_s32'];
		$pass_s33=$sql_row['pass_s33'];
		$pass_s34=$sql_row['pass_s34'];
		$pass_s35=$sql_row['pass_s35'];
		$pass_s36=$sql_row['pass_s36'];
		$pass_s37=$sql_row['pass_s37'];
		$pass_s38=$sql_row['pass_s38'];
		$pass_s39=$sql_row['pass_s39'];
		$pass_s40=$sql_row['pass_s40'];
		$pass_s41=$sql_row['pass_s41'];
		$pass_s42=$sql_row['pass_s42'];
		$pass_s43=$sql_row['pass_s43'];
		$pass_s44=$sql_row['pass_s44'];
		$pass_s45=$sql_row['pass_s45'];
		$pass_s46=$sql_row['pass_s46'];
		$pass_s47=$sql_row['pass_s47'];
		$pass_s48=$sql_row['pass_s48'];
		$pass_s49=$sql_row['pass_s49'];
		$pass_s50=$sql_row['pass_s50'];

		
		$fail_xs=$sql_row['fail_xs'];
		$fail_s=$sql_row['fail_s'];
		$fail_m=$sql_row['fail_m'];
		$fail_l=$sql_row['fail_l'];
		$fail_xl=$sql_row['fail_xl'];
		$fail_xxl=$sql_row['fail_xxl'];
		$fail_xxxl=$sql_row['fail_xxxl'];
		
		$fail_s01=$sql_row['fail_s01'];
		$fail_s02=$sql_row['fail_s02'];
		$fail_s03=$sql_row['fail_s03'];
		$fail_s04=$sql_row['fail_s04'];
		$fail_s05=$sql_row['fail_s05'];
		$fail_s06=$sql_row['fail_s06'];
		$fail_s07=$sql_row['fail_s07'];
		$fail_s08=$sql_row['fail_s08'];
		$fail_s09=$sql_row['fail_s09'];
		$fail_s10=$sql_row['fail_s10'];
		$fail_s11=$sql_row['fail_s11'];
		$fail_s12=$sql_row['fail_s12'];
		$fail_s13=$sql_row['fail_s13'];
		$fail_s14=$sql_row['fail_s14'];
		$fail_s15=$sql_row['fail_s15'];
		$fail_s16=$sql_row['fail_s16'];
		$fail_s17=$sql_row['fail_s17'];
		$fail_s18=$sql_row['fail_s18'];
		$fail_s19=$sql_row['fail_s19'];
		$fail_s20=$sql_row['fail_s20'];
		$fail_s21=$sql_row['fail_s21'];
		$fail_s22=$sql_row['fail_s22'];
		$fail_s23=$sql_row['fail_s23'];
		$fail_s24=$sql_row['fail_s24'];
		$fail_s25=$sql_row['fail_s25'];
		$fail_s26=$sql_row['fail_s26'];
		$fail_s27=$sql_row['fail_s27'];
		$fail_s28=$sql_row['fail_s28'];
		$fail_s29=$sql_row['fail_s29'];
		$fail_s30=$sql_row['fail_s30'];
		$fail_s31=$sql_row['fail_s31'];
		$fail_s32=$sql_row['fail_s32'];
		$fail_s33=$sql_row['fail_s33'];
		$fail_s34=$sql_row['fail_s34'];
		$fail_s35=$sql_row['fail_s35'];
		$fail_s36=$sql_row['fail_s36'];
		$fail_s37=$sql_row['fail_s37'];
		$fail_s38=$sql_row['fail_s38'];
		$fail_s39=$sql_row['fail_s39'];
		$fail_s40=$sql_row['fail_s40'];
		$fail_s41=$sql_row['fail_s41'];
		$fail_s42=$sql_row['fail_s42'];
		$fail_s43=$sql_row['fail_s43'];
		$fail_s44=$sql_row['fail_s44'];
		$fail_s45=$sql_row['fail_s45'];
		$fail_s46=$sql_row['fail_s46'];
		$fail_s47=$sql_row['fail_s47'];
		$fail_s48=$sql_row['fail_s48'];
		$fail_s49=$sql_row['fail_s49'];
		$fail_s50=$sql_row['fail_s50'];

	}
	
	$ship_xs=0;
	$ship_s=0;
	$ship_m=0;
	$ship_l=0;
	$ship_xl=0;
	$ship_xxl=0;
	$ship_xxxl=0;
	$ship_s01=0;
	$ship_s02=0;
	$ship_s03=0;
	$ship_s04=0;
	$ship_s05=0;
	$ship_s06=0;
	$ship_s07=0;
	$ship_s08=0;
	$ship_s09=0;
	$ship_s10=0;
	$ship_s11=0;
	$ship_s12=0;
	$ship_s13=0;
	$ship_s14=0;
	$ship_s15=0;
	$ship_s16=0;
	$ship_s17=0;
	$ship_s18=0;
	$ship_s19=0;
	$ship_s20=0;
	$ship_s21=0;
	$ship_s22=0;
	$ship_s23=0;
	$ship_s24=0;
	$ship_s25=0;
	$ship_s26=0;
	$ship_s27=0;
	$ship_s28=0;
	$ship_s29=0;
	$ship_s30=0;
	$ship_s31=0;
	$ship_s32=0;
	$ship_s33=0;
	$ship_s34=0;
	$ship_s35=0;
	$ship_s36=0;
	$ship_s37=0;
	$ship_s38=0;
	$ship_s39=0;
	$ship_s40=0;
	$ship_s41=0;
	$ship_s42=0;
	$ship_s43=0;
	$ship_s44=0;
	$ship_s45=0;
	$ship_s46=0;
	$ship_s47=0;
	$ship_s48=0;
	$ship_s49=0;
	$ship_s50=0;


	if($color_x=='0'){
		$sql="select * from $bai_pro3.ship_stat_log where ship_style=\"$style_x\" and ship_schedule=\"$schedule_x\"";
	}
	else{
		$sql="select * from $bai_pro3.ship_stat_log where ship_style=\"$style_x\" and ship_schedule=\"$schedule_x\" and ship_color=\"$color_x\"";
	}
	mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$ship_xs+=$sql_row['ship_s_xs'];
		$ship_s+=$sql_row['ship_s_s'];
		$ship_m+=$sql_row['ship_s_m'];
		$ship_l+=$sql_row['ship_s_l'];
		$ship_xl+=$sql_row['ship_s_xl'];
		$ship_xxl+=$sql_row['ship_s_xxl'];
		$ship_xxxl+=$sql_row['ship_s_xxxl'];
		
		$ship_s01+=$sql_row['ship_s_s01'];
		$ship_s02+=$sql_row['ship_s_s02'];
		$ship_s03+=$sql_row['ship_s_s03'];
		$ship_s04+=$sql_row['ship_s_s04'];
		$ship_s05+=$sql_row['ship_s_s05'];
		$ship_s06+=$sql_row['ship_s_s06'];
		$ship_s07+=$sql_row['ship_s_s07'];
		$ship_s08+=$sql_row['ship_s_s08'];
		$ship_s09+=$sql_row['ship_s_s09'];
		$ship_s10+=$sql_row['ship_s_s10'];
		$ship_s11+=$sql_row['ship_s_s11'];
		$ship_s12+=$sql_row['ship_s_s12'];
		$ship_s13+=$sql_row['ship_s_s13'];
		$ship_s14+=$sql_row['ship_s_s14'];
		$ship_s15+=$sql_row['ship_s_s15'];
		$ship_s16+=$sql_row['ship_s_s16'];
		$ship_s17+=$sql_row['ship_s_s17'];
		$ship_s18+=$sql_row['ship_s_s18'];
		$ship_s19+=$sql_row['ship_s_s19'];
		$ship_s20+=$sql_row['ship_s_s20'];
		$ship_s21+=$sql_row['ship_s_s21'];
		$ship_s22+=$sql_row['ship_s_s22'];
		$ship_s23+=$sql_row['ship_s_s23'];
		$ship_s24+=$sql_row['ship_s_s24'];
		$ship_s25+=$sql_row['ship_s_s25'];
		$ship_s26+=$sql_row['ship_s_s26'];
		$ship_s27+=$sql_row['ship_s_s27'];
		$ship_s28+=$sql_row['ship_s_s28'];
		$ship_s29+=$sql_row['ship_s_s29'];
		$ship_s30+=$sql_row['ship_s_s30'];
		$ship_s31+=$sql_row['ship_s_s31'];
		$ship_s32+=$sql_row['ship_s_s32'];
		$ship_s33+=$sql_row['ship_s_s33'];
		$ship_s34+=$sql_row['ship_s_s34'];
		$ship_s35+=$sql_row['ship_s_s35'];
		$ship_s36+=$sql_row['ship_s_s36'];
		$ship_s37+=$sql_row['ship_s_s37'];
		$ship_s38+=$sql_row['ship_s_s38'];
		$ship_s39+=$sql_row['ship_s_s39'];
		$ship_s40+=$sql_row['ship_s_s40'];
		$ship_s41+=$sql_row['ship_s_s41'];
		$ship_s42+=$sql_row['ship_s_s42'];
		$ship_s43+=$sql_row['ship_s_s43'];
		$ship_s44+=$sql_row['ship_s_s44'];
		$ship_s45+=$sql_row['ship_s_s45'];
		$ship_s46+=$sql_row['ship_s_s46'];
		$ship_s47+=$sql_row['ship_s_s47'];
		$ship_s48+=$sql_row['ship_s_s48'];
		$ship_s49+=$sql_row['ship_s_s49'];
		$ship_s50+=$sql_row['ship_s_s50'];

	}
	
$sizes=array("XS","S","M","L","XL","XXL","XXXL","s01","s02","s03","s04","s05","s06","s07","s08","s09","s10","s11","s12","s13","s14","s15","s16","s17","s18","s19","s20","s21","s22","s23","s24","s25","s26","s27","s28","s29","s30","s31","s32","s33","s34","s35","s36","s37","s38","s39","s40","s41","s42","s43","s44","s45","s46","s47","s48","s49","s50");

$order_qtys=array($order_xs,$order_s,$order_m,$order_l,$order_xl,$order_xxl,$order_xxxl,$order_s01,$order_s02,$order_s03,$order_s04,$order_s05,$order_s06,$order_s07,$order_s08,$order_s09,$order_s10,$order_s11,$order_s12,$order_s13,$order_s14,$order_s15,$order_s16,$order_s17,$order_s18,$order_s19,$order_s20,$order_s21,$order_s22
,$order_s23,$order_s24,$order_s25,$order_s26,$order_s27,$order_s28,$order_s29,$order_s30,$order_s31,$order_s32,$order_s33,$order_s34,$order_s35,$order_s36,$order_s37
,$order_s38,$order_s39,$order_s40,$order_s41,$order_s42,$order_s43,$order_s44,$order_s45,$order_s46,$order_s47,$order_s48,$order_s49,$order_s50);

$tot_order_qty=array_sum($order_qtys);

$fg_qtys=array($fg_xs,$fg_s,$fg_m,$fg_l,$fg_xl,$fg_xxl,$fg_xxxl,$fg_s01,$fg_s02,$fg_s03,$fg_s04,$fg_s05,$fg_s06,$fg_s07,$fg_s08,$fg_s09,$fg_s10,$fg_s11,$fg_s12,$fg_s13,$fg_s14,$fg_s15,$fg_s16,$fg_s17,$fg_s18,$fg_s19,$fg_s20,$fg_s21,$fg_s22,$fg_s23,$fg_s24,$fg_s25,$fg_s26,$fg_s27,$fg_s28,$fg_s29,$fg_s30,$fg_s31,$fg_s32
,$fg_s33,$fg_s34,$fg_s35,$fg_s36,$fg_s37,$fg_s38,$fg_s39,$fg_s40,$fg_s41,$fg_s42,$fg_s43,$fg_s44,$fg_s45,$fg_s46,$fg_s47,$fg_s48,$fg_s49,$fg_s50);

$tot_fg_qty=array_sum($fg_qtys);

$pass_qtys=array($pass_xs,$pass_s,$pass_m,$pass_l,$pass_xl,$pass_xxl,$pass_xxxl,$pass_s01,$pass_s02,$pass_s03,$pass_s04,$pass_s05,$pass_s06,$pass_s07,$pass_s08,$pass_s09,$pass_s10,$pass_s11,$pass_s12,$pass_s13,$pass_s14,$pass_s15,$pass_s16,$pass_s17,$pass_s18,$pass_s19,$pass_s20,$pass_s21,$pass_s22,$pass_s23,$pass_s24
,$pass_s25,$pass_s26,$pass_s27,$pass_s28,$pass_s29,$pass_s30,$pass_s31,$pass_s32,$pass_s33,$pass_s34,$pass_s35,$pass_s36,$pass_s37,$pass_s38,$pass_s39,$pass_s40
,$pass_s41,$pass_s42,$pass_s43,$pass_s44,$pass_s45,$pass_s46,$pass_s47,$pass_s48,$pass_s49,$pass_s50);

$tot_pass_qty=array_sum($pass_qtys);

$fail_qtys=array($fail_xs,$fail_s,$fail_m,$fail_l,$fail_xl,$fail_xxl,$fail_xxxl,$fail_s01,$fail_s02,$fail_s03,$fail_s04,$fail_s05,$fail_s06,$fail_s07,$fail_s08,$fail_s09,$fail_s10,$fail_s11,$fail_s12,$fail_s13,$fail_s14,$fail_s15,$fail_s16,$fail_s17,$fail_s18,$fail_s19,$fail_s20,$fail_s21,$fail_s22,$fail_s23,$fail_s24
,$fail_s25,$fail_s26,$fail_s27,$fail_s28,$fail_s29,$fail_s30,$fail_s31,$fail_s32,$fail_s33,$fail_s34,$fail_s35,$fail_s36,$fail_s37,$fail_s38,$fail_s39,$fail_s40
,$fail_s41,$fail_s42,$fail_s43,$fail_s44,$fail_s45,$fail_s46,$fail_s47,$fail_s48,$fail_s49,$fail_s50);

$tot_fail_qty=array_sum($fail_qtys);

$ship_qtys=array($ship_xs,$ship_s,$ship_m,$ship_l,$ship_xl,$ship_xxl,$ship_xxxl,$ship_s01,$ship_s02,$ship_s03,$ship_s04,$ship_s05,$ship_s06,$ship_s07,$ship_s08
,$ship_s09,$ship_s10,$ship_s11,$ship_s12,$ship_s13,$ship_s14,$ship_s15,$ship_s16,$ship_s17,$ship_s18,$ship_s19,$ship_s20,$ship_s21,$ship_s22,$ship_s23,$ship_s24
,$ship_s25,$ship_s26,$ship_s27,$ship_s28,$ship_s29,$ship_s30,$ship_s31,$ship_s32,$ship_s33,$ship_s34,$ship_s35,$ship_s36,$ship_s37,$ship_s38,$ship_s39,$ship_s40
,$ship_s41,$ship_s42,$ship_s43,$ship_s44,$ship_s45,$ship_s46,$ship_s47,$ship_s48,$ship_s49,$ship_s50);

$tot_ship_qty=array_sum($ship_qtys);

$url = getFullURL($_GET['r'],'reserve.php','N');
echo "<div class='panel-body'>";
echo "<form name='apply' method='post' action='$url' enctype='multipart/form data'>";
echo "<div class='table-responsive' style='max-height:600px;overflow-x:scroll;overflow-y:scroll'><table class='table table-bordered'>";
echo "<tr class='success'><th>Size</th><th>Order Qty</th><th>FG Qty</th><th>Ship/Resr. Qty</th><th>Available to Ship Qty</th><th>Enter Ship Qty</th></tr>";
$size_value=array();
$x=0;
for($i=0;$i<sizeof($order_qtys);$i++)
{
	if($order_qtys[$i]>0)
	{
		//Error Correction
		if($pass_qtys[$i]>$order_qtys[$i])
		{
			$pass_qtys[$i]=$order_qtys[$i];
		}
		//Error Correction
	
		//$available_qty=$pass_qtys[$i]-$ship_qtys[$i];
		$available_qty=$fg_qtys[$i]-$ship_qtys[$i];
		
		$size_value[$i]=ims_sizes('',$schedule_no,$style_no,$color_no,strtoupper($sizes[$i]),$link);
		
		echo "<tr><td>".$size_value[$i]."</td><td>".$order_qtys[$i]."</td><td>".$fg_qtys[$i]."</td><td>".$ship_qtys[$i]."</td><td>".$available_qty."</td>";
		if($available_qty>0)
		{
			echo "<td><input type='text' class='integer' name=\"qty[$x]\" id=\"qty\" value=\"$available_qty\" 
			      onkeyup='validateshipqty()'><input type=\"hidden\" name=\"size[$x]\" value=\"".$sizes[$i]."\"></td>";
			$x++;
		}
		else
		{
			echo "<td>N/A</td>";
			
		}
		echo "</tr>";
	}
}

echo "<tr class='warning'><th>Total</th><th>$tot_order_qty</th><th>$tot_fg_qty</th><th>$tot_ship_qty</th><th>".($tot_pass_qty-$tot_ship_qty)."</th><th></th></tr>";

echo "</table>";

if($x>0)
{
	if($color_x=='0')
    {
	$sql="select container,group_concat(tid) as \"label_id\", count(*) as \"count\" from $bai_pro3.packing_summary where order_style_no=\"$style_x\" and order_del_no=\"$schedule_x\" group by container";
	}
	else
	{
	$sql="select container,group_concat(tid) as \"label_id\", count(*) as \"count\" from $bai_pro3.packing_summary where order_style_no=\"$style_x\" and order_del_no=\"$schedule_x\" and order_col_des=\"$color_x\" group by container";
	}
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
	$total=0;
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$count=$sql_row['count'];
		if($sql_row['container']!=1)
		{
			$count=1;
		}
	$total+=$count;
	}
	echo "<div class='col-sm-6 black'>Total Cartons as per Packing List :</div>
		  <div class='col-sm-6'><b class='text-danger'>$total</b></div><br><br>";
	echo "<input type='hidden' name='style_new' value='$style_x'>
		  <input type='hidden' name='schedule_new' value='$schedule_x'>
		  <input type='hidden' name='color_new' value='$color_x'>";
	echo "<div class='col-sm-6 black'>Enter no of Cartons:</div>
		  <div class='col-sm-6'><input onkeyup='negative()' type='number' id='crts' name='crts' value='0' size='5'></div><br><br>";
	echo "<div class='col-sm-6 black'>Remarks :</div>
		  <div class='col-sm-6'> <input type='text' name='rmks' value='' ></div><br>";
	echo "<input class='btn btn-primary' type='submit' name='hold' value='Reserve'>";
	echo "</div>";
}
echo "</form></div>
</div>
</div>";	

}
?> 

	</div>	
</div>
</div>


<script>
    var checkboxes = $("input[type='checkbox']");
    submitButt = $("input[type='submit']");
    
	checkboxes.click(function() {
        submitButt.attr("disabled", !checkboxes.is(":checked"));
    });	
</script>

<script>
function validateshipqty()
{
var availqty='<?php echo $available_qty; ?>';
var shipqty=document.getElementById('qty').value;

if(shipqty>availqty)
{
sweetAlert("You cant enter ship qty more than available qty","","warning");
document.getElementById('qty').value='<?php echo $available_qty; ?>';
}
}
</script>








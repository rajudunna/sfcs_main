
<style>
	th,td
	{
		color : #000;
	}
	.left
	{
		color : #000;
		font-weight : bold;
	}
	b
	{
		padding-bottom : 5px;
	}
</style>

<script>
	function check_validate()
	{
		var seal=document.getElementById("seal").value;
		var vehicle=document.getElementById("vehicle").value;
		if( seal.length==0 || vehicle.length==0 )
		{
			sweetAlert("Please Fill The Vehicle and Seal Number Details..","","warning");
			document.getElementById("submit").disabled=true;
		}	
		else
		{				
			document.getElementById("submit").disabled=false;
		} 
	}  

	function validate_data1(e)
	{
		var k;
		var veh_num = document.getElementById('no');
		document.all ? k = e.keyCode : k = e.which;
		if( !((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57))  )
		{
			sweetAlert('Special Characters not allowed','','warning');
			veh_num.value = '';
			document.getElementById("submit").disabled=true;
		}
	}       
</script>
<div class='panel panel-primary'>
		<div class='panel-heading'>
			<b>Dispatch Control Panel</b>
		</div>
		<div class='panel-body'>		
			<form name="input" method="post" action="<?php echo '?r='.$_GET['r']; ?>">
				<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php', 3,'R'));
					if(isset($_POST['prepare']));
					if(1)
					{
						$sel=$_POST['sel'];
						
						if(sizeof($sel)>0)
						{
							$grand_pcs=0;
							$grand_carts=0;
							echo "<br/>
								<div class='col-sm-6'>
								<h2>Details:</h2>
								<table class='table table-bordered table-xs'>
									<tr class='danger'>
											<th>Style</th>
											<th>Schedule</th>
											<th>Total Pcs</th>
											<th>Total Cartons</th>
											<th>Size</th>
											<th>Quantity</th>
									</tr>";
							
							$sql="select ship_style,ship_schedule,ship_color,coalesce(sum(ship_cartons),0) as \"ship_cartons\", coalesce(sum(ship_s_xs),0) as \"ship_s_xs\",coalesce(sum(ship_s_s),0) as \"ship_s_s\",coalesce(sum(ship_s_m),0) as \"ship_s_m\",coalesce(sum(ship_s_l),0) as \"ship_s_l\",coalesce(sum(ship_s_xl),0) as \"ship_s_xl\",coalesce(sum(ship_s_xxl),0) as \"ship_s_xxl\",coalesce(sum(ship_s_xxxl),0) as \"ship_s_xxxl\",coalesce(sum(ship_s_s01),0) as \"ship_s_s01\"
								,coalesce(sum(ship_s_s02),0) as \"ship_s_s02\",coalesce(sum(ship_s_s03),0) as \"ship_s_s03\",coalesce(sum(ship_s_s04),0) as \"ship_s_s04\",coalesce(sum(ship_s_s05),0) as \"ship_s_s05\",coalesce(sum(ship_s_s06),0) as \"ship_s_s06\",coalesce(sum(ship_s_s07),0) as \"ship_s_s07\",coalesce(sum(ship_s_s08),0) as \"ship_s_s08\",coalesce(sum(ship_s_s09),0) as \"ship_s_s09\",coalesce(sum(ship_s_s10),0) as \"ship_s_s10\",coalesce(sum(ship_s_s11),0) as \"ship_s_s11\",coalesce(sum(ship_s_s12),0) as \"ship_s_s12\",coalesce(sum(ship_s_s13),0) as \"ship_s_s13\",coalesce(sum(ship_s_s14),0) as \"ship_s_s14\",coalesce(sum(ship_s_s15),0) as \"ship_s_s15\",coalesce(sum(ship_s_s16),0) as \"ship_s_s16\",coalesce(sum(ship_s_s17),0) as \"ship_s_s17\",coalesce(sum(ship_s_s18),0) as \"ship_s_s18\",coalesce(sum(ship_s_s19),0) as \"ship_s_s19\",coalesce(sum(ship_s_s20),0) as \"ship_s_s20\",coalesce(sum(ship_s_s21),0) as \"ship_s_s21\",coalesce(sum(ship_s_s22),0) as \"ship_s_s22\",coalesce(sum(ship_s_s23),0) as \"ship_s_s23\",coalesce(sum(ship_s_s24),0) as \"ship_s_s24\",coalesce(sum(ship_s_s25),0) as \"ship_s_s25\",coalesce(sum(ship_s_s26),0) as \"ship_s_s26\",coalesce(sum(ship_s_s27),0) as \"ship_s_s27\",coalesce(sum(ship_s_s28),0) as \"ship_s_s28\",coalesce(sum(ship_s_s29),0) as \"ship_s_s29\",coalesce(sum(ship_s_s30),0) as \"ship_s_s30\",coalesce(sum(ship_s_s31),0) as \"ship_s_s31\",coalesce(sum(ship_s_s32),0) as \"ship_s_s32\",coalesce(sum(ship_s_s33),0) as \"ship_s_s33\",coalesce(sum(ship_s_s34),0) as \"ship_s_s34\",coalesce(sum(ship_s_s35),0) as \"ship_s_s35\",coalesce(sum(ship_s_s36),0) as \"ship_s_s36\",coalesce(sum(ship_s_s37),0) as \"ship_s_s37\",coalesce(sum(ship_s_s38),0) as \"ship_s_s38\",coalesce(sum(ship_s_s39),0) as \"ship_s_s39\",coalesce(sum(ship_s_s40),0) as \"ship_s_s40\",coalesce(sum(ship_s_s41),0) as \"ship_s_s41\",coalesce(sum(ship_s_s42),0) as \"ship_s_s42\",coalesce(sum(ship_s_s43),0) as \"ship_s_s43\",coalesce(sum(ship_s_s44),0) as \"ship_s_s44\",coalesce(sum(ship_s_s45),0) as \"ship_s_s45\",coalesce(sum(ship_s_s46),0) as \"ship_s_s46\",coalesce(sum(ship_s_s47),0) as \"ship_s_s47\",coalesce(sum(ship_s_s48),0) as \"ship_s_s48\",coalesce(sum(ship_s_s49),0) as \"ship_s_s49\",coalesce(sum(ship_s_s50),0) as \"ship_s_s50\" from $bai_pro3.ship_stat_log where ship_status=1 and ship_tid in (".implode(",",$sel).") group by ship_schedule order by ship_schedule";
							// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							// echo $sql."<br>";
							$sql_result=mysqli_query($link, $sql) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
							$num_sch=mysqli_num_rows($sql_result);
							while($sql_row=mysqli_fetch_array($sql_result))
							{
								// Deprecated
								$ship_xs=$sql_row['ship_s_xs'];
								$ship_s=$sql_row['ship_s_s'];
								$ship_m=$sql_row['ship_s_m'];
								$ship_l=$sql_row['ship_s_l'];
								$ship_xl=$sql_row['ship_s_xl'];
								$ship_xxl=$sql_row['ship_s_xxl'];
								$ship_xxxl=$sql_row['ship_s_xxxl'];
								// Deprecated
								
								// Sizes
								$ship_s01=$sql_row['ship_s_s01'];
								$ship_s02=$sql_row['ship_s_s02'];
								$ship_s03=$sql_row['ship_s_s03'];
								$ship_s04=$sql_row['ship_s_s04'];
								$ship_s05=$sql_row['ship_s_s05'];
								$ship_s06=$sql_row['ship_s_s06'];
								$ship_s07=$sql_row['ship_s_s07'];
								$ship_s08=$sql_row['ship_s_s08'];
								$ship_s09=$sql_row['ship_s_s09'];
								$ship_s10=$sql_row['ship_s_s10'];
								$ship_s11=$sql_row['ship_s_s11'];
								$ship_s12=$sql_row['ship_s_s12'];
								$ship_s13=$sql_row['ship_s_s13'];
								$ship_s14=$sql_row['ship_s_s14'];
								$ship_s15=$sql_row['ship_s_s15'];
								$ship_s16=$sql_row['ship_s_s16'];
								$ship_s17=$sql_row['ship_s_s17'];
								$ship_s18=$sql_row['ship_s_s18'];
								$ship_s19=$sql_row['ship_s_s19'];
								$ship_s20=$sql_row['ship_s_s20'];
								$ship_s21=$sql_row['ship_s_s21'];
								$ship_s22=$sql_row['ship_s_s22'];
								$ship_s23=$sql_row['ship_s_s23'];
								$ship_s24=$sql_row['ship_s_s24'];
								$ship_s25=$sql_row['ship_s_s25'];
								$ship_s26=$sql_row['ship_s_s26'];
								$ship_s27=$sql_row['ship_s_s27'];
								$ship_s28=$sql_row['ship_s_s28'];
								$ship_s29=$sql_row['ship_s_s29'];
								$ship_s30=$sql_row['ship_s_s30'];
								$ship_s31=$sql_row['ship_s_s31'];
								$ship_s32=$sql_row['ship_s_s32'];
								$ship_s33=$sql_row['ship_s_s33'];
								$ship_s34=$sql_row['ship_s_s34'];
								$ship_s35=$sql_row['ship_s_s35'];
								$ship_s36=$sql_row['ship_s_s36'];
								$ship_s37=$sql_row['ship_s_s37'];
								$ship_s38=$sql_row['ship_s_s38'];
								$ship_s39=$sql_row['ship_s_s39'];
								$ship_s40=$sql_row['ship_s_s40'];
								$ship_s41=$sql_row['ship_s_s41'];
								$ship_s42=$sql_row['ship_s_s42'];
								$ship_s43=$sql_row['ship_s_s43'];
								$ship_s44=$sql_row['ship_s_s44'];
								$ship_s45=$sql_row['ship_s_s45'];
								$ship_s46=$sql_row['ship_s_s46'];
								$ship_s47=$sql_row['ship_s_s47'];
								$ship_s48=$sql_row['ship_s_s48'];
								$ship_s49=$sql_row['ship_s_s49'];
								$ship_s50=$sql_row['ship_s_s50'];

								
								$ship_style=$sql_row['ship_style'];
								$ship_schedule=$sql_row['ship_schedule'];
								$ship_color=$sql_row['ship_color'];
								$ship_cartons=$sql_row['ship_cartons'];
								
								$grand_carts+=$ship_cartons;
								
								$sizes = array($ship_s01, $ship_s02, $ship_s03, $ship_s04, $ship_s05, $ship_s06, $ship_s07, $ship_s08, $ship_s09, $ship_s10, $ship_s11, $ship_s12, $ship_s13, $ship_s14, $ship_s15, $ship_s16, $ship_s17, $ship_s18, $ship_s19, $ship_s20, $ship_s21, $ship_s22, $ship_s23, $ship_s24, $ship_s25, $ship_s26, $ship_s27, $ship_s28, $ship_s29, $ship_s30, $ship_s31, $ship_s32, $ship_s33, $ship_s34, $ship_s35, $ship_s36, $ship_s37, $ship_s38, $ship_s39, $ship_s40, $ship_s41, $ship_s42, $ship_s43, $ship_s44, $ship_s45, $ship_s46, $ship_s47, $ship_s48, $ship_s49, $ship_s50);

								// $title_sizes = array('ship_s01', 'ship_s02', 'ship_s03', 'ship_s04', 'ship_s05', 'ship_s06', 'ship_s07', 'ship_s08', 'ship_s09', 'ship_s10', 'ship_s11', 'ship_s12', 'ship_s13', 'ship_s14', 'ship_s15', 'ship_s16', 'ship_s17', 'ship_s18', 'ship_s19', 'ship_s20', 'ship_s21', 'ship_s22', 'ship_s23', 'ship_s24', 'ship_s25', 'ship_s26', 'ship_s27', 'ship_s28', 'ship_s29', 'ship_s30', 'ship_s31', 'ship_s32', 'ship_s33', 'ship_s34', 'ship_s35', 'ship_s36', 'ship_s37', 'ship_s38', 'ship_s39', 'ship_s40', 'ship_s41', 'ship_s42', 'ship_s43', 'ship_s44', 'ship_s45', 'ship_s46', 'ship_s47', 'title_size_s48', 'title_size_s49', 'title_size_s50');
								
								$sizes_array=array('s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50');
											
								
								$filtered_sizes = array_filter($sizes);

								$total_pcs=$ship_xs+$ship_s+$ship_m+$ship_l+$ship_xl+$ship_xxl+$ship_xxxl+$ship_s01+$ship_s02+$ship_s03+$ship_s04+$ship_s05+$ship_s06+$ship_s07+$ship_s08+$ship_s09+$ship_s10+$ship_s11+$ship_s12+$ship_s13+$ship_s14+$ship_s15+$ship_s16+$ship_s17+$ship_s18+$ship_s19+$ship_s20+$ship_s21+$ship_s22+$ship_s23+$ship_s24+$ship_s25+$ship_s26+$ship_s27+$ship_s28+$ship_s29+$ship_s30+$ship_s31+$ship_s32+$ship_s33+$ship_s34+$ship_s35+$ship_s36+$ship_s37+$ship_s38+$ship_s39+$ship_s40+$ship_s41+$ship_s42+$ship_s43+$ship_s44+$ship_s45+$ship_s46+$ship_s47+$ship_s48+$ship_s49+$ship_s50;

								$grand_pcs+=$total_pcs;

								foreach($filtered_sizes as $key => $value){
									$sizes_info="select title_size_".$sizes_array[$key]." from bai_orders_db_confirm where order_style_no='".$ship_style."' and order_del_no=".$ship_schedule." and trim(order_col_des)='".$ship_color."'";
									$sizes_info_result=mysqli_query($link, $sizes_info);
									$sizes_info_details = mysqli_fetch_row($sizes_info_result);
									echo "<tr>";
									echo "<td>$ship_style</td>";
									echo "<td>$ship_schedule</td>";
									echo "<td>$total_pcs</td>";
									echo "<td>$ship_cartons</td>";
									echo "<td>$sizes_info_details[0]</td>
									<td>$value</td>";
									echo "</tr>";
								}
							}
							echo "</table></div>";
							echo "<div class='col-sm-offset-1 col-sm-7'>";
							echo "<h2>Summary:</h2>";
							echo "<div class='row'>";
							echo "<div class='col-sm-4 left'>Total Pieces<b>:</b></div><div class='col-sm-4 left'>$grand_pcs</div><br><br>";
							echo "<div class='col-sm-4 left'>Total Cartons<b>:</b></div><div class='col-sm-4 left'>$grand_carts</div><br><br>";
							echo "<div class='col-sm-4 left'>Total Schedules<b>:</b></div><div class='col-sm-4 left'>$num_sch</div><br><br>";
							echo "</div>";
							echo "<div class='row'>";
							echo "<div class='col-sm-4 left'>Party<b>:</b></div>
									<div class='col-sm-4'>
										<select class='form-control' name='party'>";
								$sql="select * from $bai_pro3.party_db order by order_no";
								$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row=mysqli_fetch_array($sql_result))
								{
									echo "<option value=\"".$sql_row['pid']."\">".$sql_row['party_name']."-".$sql_row['location']."</option>";
								}
							echo "</select>
								</div>
							</div><br>";
							echo "<div class='row'>";
							echo "<div class='col-sm-4 left'>Vehicle No<b>:</b></div><div class='col-sm-4 left'><input class='form-control alpha' type='text' name='vehicle' id='vehicle' ></div></div>";
							echo "<br><div class='row'><div class='col-sm-4 left'>Seal No<b>:</b></div><div class='col-sm-4 left'><input class='form-control alpha' type='text' id='seal' name='seal' onkeyup='javascript:return validate_data1(event);'></div><br>";
							echo "</div><br>";	
							/*
							echo "<div class='row'>
									<div class='col-sm-4 left'>Mode : </div>
									<div class='col-sm-4'>
										<select class='form-control' name='mode'>
											<option>nil</option>";
											$sql="select * from transport_modes";
											$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
											while($sql_row=mysqli_fetch_array($sql_result))
											{
												echo "<option value='".$sql_row['sno']."'>".$sql_row['transport_mode']."</option>";
											}
										echo "</select>
									</div>
								</div>";
								*/
							echo "<div class='row'>
									<div class='col-sm-4 left'>Mode<b>:</b></div>
									<div class='col-sm-4'>
										<select class='form-control' name='mode'>
											<option value='1'>Air</option>
											<option value='2'>Sea</option>
											<option value='3'>Road</option>
											<option value='4'>Courier</option>
										</select>
									</div>
								</div><br>";	
							echo "<div class='row'>
									<div class='col-sm-4 left'>Remarks<b>:</b></div>
									<div class='col-sm-4'>
										<select class='form-control' name='remarks'>
											<option value='Cartons'>Cartons</option>
											<option value='Packs'>Packs</option>
										</select>
									</div>
								</div><br>";

							echo "<input type='hidden' name='ship_id' value='".implode(",",$sel)."'>";
							echo "<div class='row'>
									<div class='col-sm-6 left'>
											<div class='col-sm-1'><input type='checkbox' name='validate' onclick='check_validate()' ></div>
											<div class='col-sm-4'><input class='btn btn-danger' type='submit' name='submit' id='submit' value='Confirm & Prepare Dispatch Note' disabled='disabled' onclick='check_validate()'></div>
									</div>
								</div>";
			
						}
					}
				?>
			</form>
	</div><!-- closing panel-body -->
</div><!--closing panel -->


<?php
if(isset($_POST['submit']))
{
	$ship_id=$_POST['ship_id'];
	$party=$_POST['party'];
	$vehicle=$_POST['vehicle'];
	$mode=$_POST['mode'];
	$date=date("Y-m-d");
	$seal=$_POST['seal'];
	$remarks=$_POST['remarks'];
	
	$jump_url2 = getFullURL($_GET['r'],'test.php','N');
	$jump_url1 = getFullURL($_GET['r'],'dispatch_db.php','N');
	if($seal!='' && $vehicle!='')
	{
		$sql="insert into $bai_pro3.disp_db set create_date=\"$date\", party=\"$party\", vehicle_no=\"$vehicle\", mode=\"$mode\", status=1, seal_no=\"$seal\", remarks=\"$remarks\", prepared_by=USER(), prepared_time=NOW()";
		mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$iLastID=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
		
		$sql="update $bai_pro3.ship_stat_log set disp_note_no=$iLastID, ship_status=2 where ship_tid in ($ship_id)";
		mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		echo "<script type='text/javascript'> setTimeout('Redirect()',0); function Redirect() {  location.href = '$jump_url1'; }</script>"; 
	}
	else
	{
		echo "<h2 style='color:Red;' >Vehicle or Seal Number not entered for this Dispatch Note.</h2>";
		echo "<script type='text/javascript'> setTimeout('Redirect()',1500); function Redirect() {  location.href = '$jump_url2'; }</script>"; 
	}
}


?>

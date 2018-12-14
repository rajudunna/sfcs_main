<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R') );  ?>

<?php 
	$id = $_GET['id'];
	$in_size = $_GET['in_size'];
?>



<div class="panel panel-primary">
	<div class="panel-heading"><b>Carton Qty Edit</b></div>
	<div class="panel-body">
		<form name="input" method="post" action="?r=<?php echo $_GET['r']; ?>">

		<?php
		$sql="select * from $bai_pro3.carton_qty_chart where id=$id";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$style=$sql_row['user_style'];
			$buyer=$sql_row['buyer_identity'];
			$pack=$sql_row['packing_method'];
		    $schedule = $sql_row['user_schedule'];
			$p_method=$sql_row['pack_methods'];
			$xs=$sql_row['xs'];
			$s=$sql_row['s'];
			$m=$sql_row['m'];
			$l=$sql_row['l'];
			$xl=$sql_row['xl'];
			$xxl=$sql_row['xxl'];
			$xxxl=$sql_row['xxxl'];
			$s01=$sql_row['s01'];
			$s02=$sql_row['s02'];
			$s03=$sql_row['s03'];
			$s04=$sql_row['s04'];
			$s05=$sql_row['s05'];
			$s06=$sql_row['s06'];
			$s07=$sql_row['s07'];
			$s08=$sql_row['s08'];
			$s09=$sql_row['s09'];
			$s10=$sql_row['s10'];
			$s11=$sql_row['s11'];
			$s12=$sql_row['s12'];
			$s13=$sql_row['s13'];
			$s14=$sql_row['s14'];
			$s15=$sql_row['s15'];
			$s16=$sql_row['s16'];
			$s17=$sql_row['s17'];
			$s18=$sql_row['s18'];
			$s19=$sql_row['s19'];
			$s20=$sql_row['s20'];
			$s21=$sql_row['s21'];
			$s22=$sql_row['s22'];
			$s23=$sql_row['s23'];
			$s24=$sql_row['s24'];
			$s25=$sql_row['s25'];
			$s26=$sql_row['s26'];
			$s27=$sql_row['s27'];
			$s28=$sql_row['s28'];
			$s29=$sql_row['s29'];
			$s30=$sql_row['s30'];
			$s31=$sql_row['s31'];
			$s32=$sql_row['s32'];
			$s33=$sql_row['s33'];
			$s34=$sql_row['s34'];
			$s35=$sql_row['s35'];
			$s36=$sql_row['s36'];
			$s37=$sql_row['s37'];
			$s38=$sql_row['s38'];
			$s39=$sql_row['s39'];
			$s40=$sql_row['s40'];
			$s41=$sql_row['s41'];
			$s42=$sql_row['s42'];
			$s43=$sql_row['s43'];
			$s44=$sql_row['s44'];
			$s45=$sql_row['s45'];
			$s46=$sql_row['s46'];
			$s47=$sql_row['s47'];
			$s48=$sql_row['s48'];
			$s49=$sql_row['s49'];
			$s50=$sql_row['s50'];

			$track_qty=$sql_row['track_qty'];
			$status=$sql_row['status'];
			$srp_qty=$sql_row['srp_qty'];
			$sql2="select * from $bai_pro3.bai_orders_db where order_del_no='".$schedule."' and style_id='".$style."' order by order_del_no desc limit 0,1";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error sizes".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check2=mysqli_num_rows($sql_result2);
			if($sql_num_check2 > 0 )
			{
				while($row2=mysqli_fetch_array($sql_result2))
				{
					for($i=0;$i<50;$i++)
					{
						$key1 = 'title_size_s'.str_pad($i+1, 2, "0", STR_PAD_LEFT);
						$size[$i] = $row2[$key1];
					}
				}
			}
			else
			{
			  for($i=0;$i<50;$i++)
					{
						$key1 = 's'.str_pad($i+1, 2, "0", STR_PAD_LEFT);
						$size[$i] = $key1;
					}	
			}
		}

		echo '<div class="table-responsive" style="overflow-y:scroll;max-height:600px;">';
		echo '<table id="table1" class="table table-hover table-bordered">';
		echo "<tr class='danger'><th>Style</th><th>Schedule</th><th>Pack Quantity</th><th>Pack Method</th>";
		for($i=0;$i<50;$i++)
		{
			if($in_size != ''){
				if($size[$i] !='' && $size[$i] == "$in_size"){
					echo "<th>".$size[$i]."</th>";
				}
			}else{
				if($size[$i] !=''){
					echo "<th>".$size[$i]."</th>";
				}
			}
			
		}
		echo "<th>Status</th><th>Track Label Qty</th><th>SRP Qty</th></tr>";
		echo "<tr>";
		echo "<td>";
		echo "$style<select name=\"style\" style=\"display:none;\">";
		echo "<option value=\"\"></option>";
		//Changed on 2013-06-17 8:43 PM - Kirang
		$sql="select distinct style_id from $bai_pro3.bai_orders_db_confirm  order by style_id";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			if($sql_row['style_id']==$style)
			{
				echo "<option value=\"".$sql_row['style_id']."\" selected>".$sql_row['style_id']."</option>";
			}
			else
			{
				echo "<option value=\"".$sql_row['style_id']."\">".$sql_row['style_id']."</option>";
			}
		}
		echo "</select></td>";
		echo "<td>" .$schedule. "</td>";

		echo "<td>";
		echo "<input type=\"text\" class='integer' size=\"10\" value=\"$pack\" class=\"alpha\" name=\"pack\"> </td>";
		echo "<td><select name=\"pack_methods\" id=\"pack_methods\" class='form-control'>";
		echo "<option value=\"\">Select Pack Method</option>";
		foreach($pack_methods as $pack_method){				
			echo "<option value='$pack_method'";if(strtolower($pack_method) === strtolower($p_method)){echo "selected";} echo ">$pack_method</option>";
		}
		echo "</select></td>";


		for($i=0;$i<50;$i++)
		{	
			if($in_size != ''){
				if($size[$i] !='' && $size[$i] == "$in_size"){	
					$val = 's'.str_pad($i+1,2, "0", STR_PAD_LEFT);
					echo "<td><input  type=\"text\" size=3 class=\"integer\"  name=".$val." value=".$$val."></td>";		
				}
			}else{
				if($size[$i] !=''){	
					$val = 's'.str_pad($i+1,2, "0", STR_PAD_LEFT);
					echo "<td><input  type=\"text\" size=3 class=\"integer\"  name=".$val." value=".$$val."></td>";		
				}
			}
			
		}

		echo "<td>";
		echo "<select name=\"status\">";
		echo "<option value=\"0\"></option>";
		echo "<option value=\"0\"";  if($status==0) { echo "selected"; } echo " >Active</option>";
		echo "<option value=\"1\"";  if($status==1) { echo "selected"; } echo " >In-Active</option>";
		echo "</select></td>";
		echo "<td><input type=\"text\" size=3 class=\"float\" name=\"track_qty\" value=\"$track_qty\"></td>";
		echo "<td><input type=\"text\" size=3 class=\"float\" name=\"srp_qty\" value=\"$srp_qty\"></td>";
		echo "</tr>";

		echo "</table></div><br/>";
		?>
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<input type="submit" name="submit" value="submit" class="btn btn-success">
		</form>
	</div>
</div>

<?php
if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$buyer=$_POST['buyer'];
	$pack=$_POST['pack'];
	$status=$_POST['status'];
	$pack_methods=$_POST['pack_methods'];
	$id=$_POST['id'];

	$xs=0;
	$s=0;
	$m=0;
	$l=0;
	$xl=0;
	$xxl=0;
	$xxxl=0;
	$sql="select * from $bai_pro3.carton_qty_chart where id=$id";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$s01=(isset($_POST['s01']))?$_POST['s01']:$sql_row['s01'];
		$s02=(isset($_POST['s02']))?$_POST['s02']:$sql_row['s02'];
		$s03=(isset($_POST['s03']))?$_POST['s03']:$sql_row['s03'];	
		$s04=(isset($_POST['s04']))?$_POST['s04']:$sql_row['s04'];
		$s05=(isset($_POST['s05']))?$_POST['s05']:$sql_row['s05'];
		$s06=(isset($_POST['s06']))?$_POST['s06']:$sql_row['s06'];
		$s07=(isset($_POST['s07']))?$_POST['s07']:$sql_row['s07'];
		$s08=(isset($_POST['s08']))?$_POST['s08']:$sql_row['s08'];
		$s09=(isset($_POST['s09']))?$_POST['s09']:$sql_row['s09'];
		$s10=(isset($_POST['s10']))?$_POST['s10']:$sql_row['s10'];
		$s11=(isset($_POST['s11']))?$_POST['s11']:$sql_row['s11'];
		$s12=(isset($_POST['s12']))?$_POST['s12']:$sql_row['s12'];
		$s13=(isset($_POST['s13']))?$_POST['s13']:$sql_row['s13'];
		$s14=(isset($_POST['s14']))?$_POST['s14']:$sql_row['s14'];
		$s15=(isset($_POST['s15']))?$_POST['s15']:$sql_row['s15'];
		$s16=(isset($_POST['s16']))?$_POST['s16']:$sql_row['s16'];
		$s17=(isset($_POST['s17']))?$_POST['s17']:$sql_row['s17'];
		$s18=(isset($_POST['s18']))?$_POST['s18']:$sql_row['s18'];
		$s19=(isset($_POST['s19']))?$_POST['s19']:$sql_row['s19'];
		$s20=(isset($_POST['s20']))?$_POST['s20']:$sql_row['s20'];
		$s21=(isset($_POST['s21']))?$_POST['s21']:$sql_row['s21'];
		$s22=(isset($_POST['s22']))?$_POST['s22']:$sql_row['s22'];
		$s23=(isset($_POST['s23']))?$_POST['s23']:$sql_row['s23'];
		$s24=(isset($_POST['s24']))?$_POST['s24']:$sql_row['s24'];
		$s25=(isset($_POST['s25']))?$_POST['s25']:$sql_row['s25'];
		$s26=(isset($_POST['s26']))?$_POST['s26']:$sql_row['s26'];
		$s27=(isset($_POST['s27']))?$_POST['s27']:$sql_row['s27'];
		$s28=(isset($_POST['s28']))?$_POST['s28']:$sql_row['s28'];
		$s29=(isset($_POST['s29']))?$_POST['s29']:$sql_row['s29'];
		$s30=(isset($_POST['s30']))?$_POST['s30']:$sql_row['s30'];
		$s31=(isset($_POST['s31']))?$_POST['s31']:$sql_row['s31'];
		$s32=(isset($_POST['s32']))?$_POST['s32']:$sql_row['s32'];
		$s33=(isset($_POST['s33']))?$_POST['s33']:$sql_row['s33'];
		$s34=(isset($_POST['s34']))?$_POST['s34']:$sql_row['s34'];
		$s35=(isset($_POST['s35']))?$_POST['s35']:$sql_row['s35'];
		$s36=(isset($_POST['s36']))?$_POST['s36']:$sql_row['s36'];
		$s37=(isset($_POST['s37']))?$_POST['s37']:$sql_row['s37'];
		$s38=(isset($_POST['s38']))?$_POST['s38']:$sql_row['s38'];
		$s39=(isset($_POST['s39']))?$_POST['s39']:$sql_row['s39'];
		$s40=(isset($_POST['s40']))?$_POST['s40']:$sql_row['s40'];
		$s41=(isset($_POST['s41']))?$_POST['s41']:$sql_row['s41'];
		$s42=(isset($_POST['s42']))?$_POST['s42']:$sql_row['s42'];
		$s43=(isset($_POST['s43']))?$_POST['s43']:$sql_row['s43'];
		$s44=(isset($_POST['s44']))?$_POST['s44']:$sql_row['s44'];
		$s45=(isset($_POST['s45']))?$_POST['s45']:$sql_row['s45'];
		$s46=(isset($_POST['s46']))?$_POST['s46']:$sql_row['s46'];
		$s47=(isset($_POST['s47']))?$_POST['s47']:$sql_row['s47'];
		$s48=(isset($_POST['s48']))?$_POST['s48']:$sql_row['s48'];
		$s49=(isset($_POST['s49']))?$_POST['s49']:$sql_row['s49'];
		$s50=(isset($_POST['s50']))?$_POST['s50']:$sql_row['s50'];

	}


	$track_qty=$_POST['track_qty'];
	$srp_qty=$_POST['srp_qty'];
		
	
	$date=date("Y-m-d");
	$sql="update carton_qty_chart set user_style=\"$style\",buyer_identity=\"$buyer\",packing_method=\"$pack\",pack_methods=\"$pack_methods\",xs=$xs,s=$s,m=$m,l=$l,xl=$xl,xxl=$xxl,xxxl=$xxxl,s01='$s01',s02='$s02',s03='$s03',s04='$s04',s05='$s05',s06='$s06',s07='$s07',s08='$s08',s09='$s09',s10='$s10',s11='$s11',s12='$s12',s13='$s13',s14='$s14',s15='$s15',s16='$s16',s17='$s17',s18='$s18',s19='$s19',s20='$s20',s21='$s21',s22='$s22',s23='$s23',s24='$s24',s25='$s25',s26='$s26',s27='$s27',s28='$s28',s29='$s29',s30='$s30',s31='$s31',s32='$s32',s33='$s33',s34='$s34',s35='$s35',s36='$s36',s37='$s37',s38='$s38',s39='$s39',s40='$s40',s41='$s41',s42='$s42',s43='$s43',s44='$s44',s45='$s45',s46='$s46',s47='$s47',s48='$s48',s49='$s49',s50='$s50',date=\"$date\",status=$status,track_qty=$track_qty,srp_qty=$srp_qty where id=$id";
	
	mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$path = getFullURL($_GET['r'],'carton_updates.php','N');
	echo "<script type=\"text/javascript\"> 
			setTimeout(\"Redirect()\",0); 
			sweetAlert('Carton Quantities Updated Successfully','','success');
			function Redirect() {  
				location.href = '$path'; 
			}
		</script>";
}

?>
<!--
Ticket# 575423: 2014-02-08/Kirang: Added Color Filter Clause for multi color order qty amendments.

-->
<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
$order_quantity_mail=$conf1->get('order_quantity_mail');

?>
<script>

function firstbox()
{
	window.location.href ="index.php?r=<?php echo $_GET['r'] ?>"+"&style="+document.test.style.value;
}

function secondbox()
{
		window.location.href ="index.php?r=<?php echo $_GET['r'] ?>"+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value	
}
function check_style()
{

	var style=document.getElementById('style').value;
	if(style=='')
	{
		sweetAlert('Please Select Style First','','warning');
		return false;
	}
	else
	{
		return true;
	}
}
function check_style_sch()
{
	var style=document.getElementById('style').value;
	var sch=document.getElementById('schedule').value;

	if(style=='')
	{
		sweetAlert('Please Select Style First','','warning');
		return false;
	}
	else if(sch=='')
	{
		sweetAlert('Please Select schedule','','warning');
		return false;
	
	}
	else
	{
		return true;
	}
}	
</script>
<div class="panel panel-primary">
<div class="panel-heading">Order Qty Update (Schedule Wise) </div>
<div class"panel-body">
<?php
$style=$_GET['style'];
$schedule=$_GET['schedule']; 
?>
<form name="test" action="index.php?r=<?php echo $_GET['r']; ?>" method="post">
<div class="form-group">
<?php
echo "<div class=\"col-sm-12\"><div class=\"row\"><div class=\"col-sm-3\">
	  <label for='style'>Select Style:</label> 
	  <select class =\"form-control\" name=\"style\" id=\"style\"  onchange=\"firstbox();\" >";

$sql="select distinct order_style_no from $bai_pro3.bai_orders_db";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value='' selected>NIL</option>";
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
echo "</div>";
echo "<div class=\"col-sm-3\">
      <label for='schedule'>Select Schedule:</label> 
      <select class=\"form-control\" name=\"schedule\" id=\"schedule\"onclick=\"return check_style();\"  onchange=\"secondbox();\" >";
$sql_result='';
if($style){
$sql="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style\"";	

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
}
echo "<option value='' selected>NIL</option>";
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
echo "</div>";
echo "<div class=\"col-sm-1\">
		<label for='submit'><br/></label>
		<button type=\"submit\" onclick=\"return check_style_sch();\"  class=\" form-control btn btn-success\" name=\"submit\">Show</button></div>";	
echo "</div></div>";
?>

</div>
</form>
<br><br>
<form action='#' method='post' name='f3'>
<?php
error_reporting(0);
if(isset($_POST['submit']))
{
	$row_count = 0;
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	if($style == '' || $style == 'NIL' || $schedule =='' || $schedule == 'NIL' ){
		echo "<script>sweetAlert('Please Select Style & Schedule','','info');</script>";
		
	}else{	
		$qry = "select count(order_del_no) from $bai_pro3.bai_orders_db where order_del_no=\"$schedule\"";
		$sql=mysqli_query($link,$qry);

		while($row=mysqli_fetch_array($sql))
		{
			$count=$row["count(order_del_no)"];
		}
		$qry1 = "select count(order_del_no) from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\"";
		$sql1=mysqli_query($link,$qry1);	
		while($row1=mysqli_fetch_array($sql1))
		{
			$count1=$row1["count(order_del_no)"];
		}    
		echo "<div class='col-sm-12'>";
		$already_updated_query = "select * from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\" ";
		$already_updated_result=mysqli_query($link,$already_updated_query);
		if(mysqli_num_rows($already_updated_result) > 0){
			while($row = mysqli_fetch_array($already_updated_result)){
				$counter++;
				if($counter%2 == 0){
					echo '<br>';
				}
				if($row['order_no'] != 1){
					echo "<span> 
						<font size=2><b>' COLOR : <span style='color:#05dd0'>".$row['order_col_des']." '</span></b></font> 
						</span>&nbsp;&nbsp;";
				}else{
					echo "<span>
						<font size=2><b>' COLOR : <span style='color:#dd0505'>".$row['order_col_des']." '</span></b></font> 
						</font></span>&nbsp;&nbsp;";
				}
			}
			if($counter > 0){
				echo "<br/><span><font size=2 color='#0505ee'><b>
				* You cannot update order quantities for above colors as<br/>
				1.The order quantities are alredy updated for those colors (OR)<br/>
				2.The Category for the above colors is already Updated
				</font></span><br/>";
			}
		}else{
			echo "<div class='row'><span class='alert alert-success'>Order Quantities Not Yet Updated </span></div><br/>";
		}
		echo "</div>";
		if($count1 > 0){
			echo "<div class=\"col-sm-12\"><h4 align=left style='color:red;'>
				<span class=\"label label-warning\">Order Quantity already Updated.Please try with different Color or schedule</span></h4></div>";         
			echo "<div class=\"row\">";
			echo "<div class=\"col-sm-4\">";
			echo "<div class=\"col-sm-12\">";
			echo "<div class=\"table-responsive\">";
			echo "<table class='table table-bordered'>";
			echo "<tr>";
			echo "<th class=''>Style</th>";
			echo "<td class=\"  \">$style</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<th class=''>Schedule</th>";
			echo "<td class=\"  \">$schedule</td>";
			echo "</tr>";
			echo "</table>";
			echo "</div></div></div></div>";

			echo "<div class=\"col-sm-12\">";
			echo "<div class=\"table-responsive\">";		
			echo "<table class=\"table table-striped table-bordered\">";
			echo "<thead><tr class='info'>
					<th><center>Color</center></th>
					<th><center>Size</center></th>
					<th><center>New Order Quantity</center></th>
					<th><center>Old Order Quantity</center></th>
					<th><center>Order Qty Difference</center></th>
					</tr>
				</thead><tbody>";
			$qry3= "select * from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\"";
			$sql2=mysqli_query($link,$qry3);
			while($row2=mysqli_fetch_array($sql2))
			{	
				$flag = $row2['title_flag'];
				for($i = 1; $i<=50; $i++){				
					if($i<10){
						$a = 's0'.$i.'_old';
						$b = 's0'.$i;
						$c = 'size0'.$i;
						$d = 's0'.$i.'_dif';
						$$a=$row2['old_order_s_s0'.$i];
						$$b=$row2['order_s_s0'.$i];
						$$c=$row2['title_size_s0'.$i];					
						$$d=$$b-$$a;
					}else{
						$a = 's'.$i.'_old';
						$b = 's'.$i;
						$c = 'size'.$i;
						$d = 's'.$i.'_dif';
						$$a==$row2['old_order_s_s'.$i];
						$$b=$row2['order_s_s'.$i];
						$$c=$row2['title_size_s'.$i];
						$$d=$$b-$$a;
					}			
					if($flag == 0)
					{	
						if($i<10){
							$e = 'size0'.$i;
							$$e = 1; $$e = sprintf("%02d", $$e);
						}else{						
							$$e = $i;
						}
					}		
						
					if($$c != null && $$b != null && $$a != null)
					{
						echo "<tr><td><center>".$row2['order_col_des']."</center></td><td><center>".$$c."</center></td><td><center>".$$b."</center></td><td><center>".$$a."</center></td><td><center>".$$d."</center></td></tr>";
					}						
				}
			}
			echo "</tbody></table></div></div><br>";
		}
		else
		{			
			echo "<div class=\"row\">";
			echo "<div class=\"col-sm-4\">";
			echo "<div class=\"col-sm-12\">";
			echo "<table class=\"table table-striped jambo_table bulk_action\">";
			echo "<tr>";
			echo "<th class=\"column-title\">Style</th>";
			echo "<td class=\"  \">$style</td>";
			echo "</tr>";		
			echo "<tr>";
			echo "<th class=\"column-title\">Schedule</th>";
			echo "<td class=\"  \">$schedule</td>";
			echo "</tr>";		
			echo "<tr>
			<th class=\"column-title\">Excess %</th>
			<td class=\"  \"><input type=\"textbox\" style='border=\"0px\"' class=\"form-control input-sm float\" id=\"ext\"  name=\"ext\" value=\"0\" size=\"4\" onchange=\"calculateExcess()\"></td></tr>";		
			echo "</table></div>";		
			echo "</div>";
			echo "</div>";	
			echo "<input type=\"submit\" value=\"Update\" name=\"update\" id='update_btn' class=\"btn btn-success pull-right\">";	
			echo "<div class=\"col-sm-12\"><div class=\"table-responsive\"><table class=\"table table-bordered\">";
			echo "<thead><tr class=\"info\"><th><center>Color</center></th><th><center>Size</center></th><th><center>Current Order Quantity</center></th><th><center>Old Order Quantity</center></th><th><center>Size Excess %</center></th><th><center>New Order Quantity</center></th></tr><thead><tbody>";
			
			$qry4= "select * from $bai_pro3.bai_orders_db where order_del_no=\"$schedule\"";		
			$sql2=mysqli_query($link,$qry4);
			$num_rows = mysqli_num_rows($sql2);
			echo '<input type="hidden" id="rowscount" name="rowscount" value='.$num_rows.'>';
			echo "<input type=\"hidden\" name='sty' value=\"$style\">";
			echo "<input type=\"hidden\" name='sch' value=\"$schedule\">";
			$cnt = 0;
			while($row2=mysqli_fetch_array($sql2))
			{
				$flag = $row2['title_flag'];				
				echo '<input type="hidden" name="color'.$cnt.'" value='.$row2['order_col_des'].'>';
				$j =11;
				for($i = 1; $i<=50; $i++){				
					if($i<10){
						$a = 's0'.$i.'_old';
						$b = 's0'.$i;
						$c = 'size0'.$i;
						$d = 's0'.$i.'_dif';
						$old = 'old_order_s_s0'.$i;
						$ord = 'order_s_s0'.$i;
						$title = 'title_size_s0'.$i;
						$$a=$row2[$old];
						$$b=$row2[$ord];
						$$c=$row2[$title];					
						$$d=$$b-$$a;
					}else if($i>=10){
						$a = 's'.$i.'_old';
						$b = 's'.$i;
						$c = 'size'.$i;
						$d = 's'.$i.'_dif';
						$old = 'old_order_s_s'.$i;
						$ord = 'order_s_s'.$i;
						$title = 'title_size_s'.$i;
						$$a=$row2[$old];
						$$b=$row2[$ord];
						$$c=$row2[$title];
						$$d=$$b-$$a;
					}			
					if($flag == 0)
					{	
						if($i<10){
							$e = 'size0'.$i;
							$$e = 1; $$e = sprintf("%02d", $$e);
						}else{						
							$$e = $i;
						}
					}			
					echo '<input type="hidden" name="s0'.$j.$cnt.'" value='.$$b.'>';
					$x=$i;
					$i = sprintf("%02d",$x);
					$y =$j;
					$j = sprintf("%03d",$y);				
					if($$c != null && $$b != null && $$a != null)
					{
						$flag1 = ($$b == 0)?'readonly':'';	
						$row_count++;				
						echo "<tr>
								<td><center>".$row2['order_col_des']."</center></td>
								<td><center>".$$c."</center></td>
								<td><center>".$$b."</center></td>
								<td><center>".$$a."</center></td>
								<td><center><input type=\"text\" style='border=\"0px\"' name=\"s".$i."ext".$cnt."\" value=\"0\" size=\"4\" class=\"form-control input-sm float\" onKeyUp=\"
								if(event.keyCode == 9) 
										return; 
								else if(document.f3.s".$i."ext".$cnt.".value.length == 0 || document.f3.s".$i."ext".$cnt.".value.length == '' )
									document.f3.s".$i.$cnt.".value = parseInt(document.f3.s".$j.$cnt.".value)+parseInt(document.f3.s".$j.$cnt.".value*document.f3.ext.value/100);
								else
									document.f3.s".$i.$cnt.".value = parseInt(document.f3.s".$j.$cnt.".value)+parseInt(document.f3.s".$j.$cnt.".value*document.f3.s".$i."ext".$cnt.".value/100);\"></center></td>
								<td><center><input class=\"form-control input-sm\" type=\"text\" readonly style='border=\"0px\"' $flag1 onkeypress=\"return isNum(event)\" id=\"s".$i.$cnt."\" name=\"s".$i.$cnt."\" value=".$$b."></center></td></tr>";
					}
					$j = $j+10;		
				}
				$cnt++;
			}
			
			echo "</tbody></table></div></div>";			
			if($row_count == 0){
				echo "<script>document.getElementById('update_btn').disabled = true;</script>";
			}
		}
	}
}
?> 
</form>
</div>
</div>
</div>
<?php
if(isset($_POST["update"])){
	$sty=$_POST["sty"];
	$sch=$_POST["sch"];
	$ext=$_POST["ext"];
	$rowcnt = $_POST['rowscount'];
	if($rowcnt > 0){
		for($i=0;$i<$rowcnt;$i++){
			$color = $_POST['color'.$i];
			$k=11;
			$old = [];
			$new = [];
			for($j=1;$j<=50;$j++){
				if($j<10){
					$old[]=($_POST["s0".$k.$i])?$_POST["s0".$k.$i]:0;
					$new[]=($_POST["s0".$j.$i])?$_POST["s0".$j.$i]:0;
				}else if($j>=10){
					$old[]=($_POST["s".$k.$i])?$_POST["s".$k.$i]:0;
					$new[]=($_POST["s".$j.$i])?$_POST["s".$j.$i]:0;
				}
				$k+=10;
			}

			$update="update $bai_pro3.bai_orders_db set order_no=\"1\",old_order_s_s01=\"$old[0]\",old_order_s_s02=\"$old[1]\",old_order_s_s03=\"$old[2]\",old_order_s_s04=\"$old[3]\",old_order_s_s05=\"$old[4]\",old_order_s_s06=\"$old[5]\",old_order_s_s07=\"$old[6]\",old_order_s_s08=\"$old[7]\",old_order_s_s09=\"$old[8]\",old_order_s_s10=\"$old[9]\",old_order_s_s11=\"$old[10]\",old_order_s_s12=\"$old[11]\",old_order_s_s13=\"$old[12]\",old_order_s_s14=\"$old[13]\",old_order_s_s15=\"$old[14]\",old_order_s_s16=\"$old[15]\",old_order_s_s17=\"$old[16]\",old_order_s_s18=\"$old[17]\",old_order_s_s19=\"$old[18]\",old_order_s_s20=\"$old[19]\",old_order_s_s21=\"$old[20]\",old_order_s_s22=\"$old[21]\",old_order_s_s23=\"$old[22]\",old_order_s_s24=\"$old[23]\",old_order_s_s25=\"$old[24]\",old_order_s_s26=\"$old[25]\",old_order_s_s27=\"$old[26]\",old_order_s_s28=\"$old[27]\",old_order_s_s29=\"$old[28]\",old_order_s_s30=\"$old[29]\",old_order_s_s31=\"$old[30]\",old_order_s_s32=\"$old[31]\",old_order_s_s33=\"$old[32]\",old_order_s_s34=\"$old[33]\",old_order_s_s35=\"$old[34]\",old_order_s_s36=\"$old[35]\",old_order_s_s37=\"$old[36]\",old_order_s_s38=\"$old[37]\",old_order_s_s39=\"$old[38]\",old_order_s_s40=\"$old[39]\",old_order_s_s41=\"$old[40]\",old_order_s_s42=\"$old[41]\",old_order_s_s43=\"$old[42]\",old_order_s_s44=\"$old[43]\",old_order_s_s45=\"$old[44]\",old_order_s_s46=\"$old[45]\",old_order_s_s47=\"$old[46]\",old_order_s_s48=\"$old[47]\",old_order_s_s49=\"$old[48]\",old_order_s_s50=\"$old[49]\",order_s_s01=\"$new[0]\",order_s_s02=\"$new[1]\",order_s_s03=\"$new[2]\",order_s_s04=\"$new[3]\",order_s_s05=\"$new[4]\",order_s_s06=\"$new[5]\",order_s_s07=\"$new[6]\",order_s_s08=\"$new[7]\",order_s_s09=\"$new[8]\",order_s_s10=\"$new[9]\",order_s_s11=\"$new[10]\",order_s_s12=\"$new[11]\",order_s_s13=\"$new[12]\",order_s_s14=\"$new[13]\",order_s_s15=\"$new[14]\",order_s_s16=\"$new[15]\",order_s_s17=\"$new[16]\",order_s_s18=\"$new[17]\",order_s_s19=\"$new[18]\",order_s_s20=\"$new[19]\",order_s_s21=\"$new[20]\",order_s_s22=\"$new[21]\",order_s_s23=\"$new[22]\",order_s_s24=\"$new[23]\",order_s_s25=\"$new[24]\",order_s_s26=\"$new[25]\",order_s_s27=\"$new[26]\",order_s_s28=\"$new[27]\",order_s_s29=\"$new[28]\",order_s_s30=\"$new[29]\",order_s_s31=\"$new[30]\",order_s_s32=\"$new[31]\",order_s_s33=\"$new[32]\",order_s_s34=\"$new[33]\",order_s_s35=\"$new[34]\",order_s_s36=\"$new[35]\",order_s_s37=\"$new[36]\",order_s_s38=\"$new[37]\",order_s_s39=\"$new[38]\",order_s_s40=\"$new[39]\",order_s_s41=\"$new[40]\",order_s_s42=\"$new[41]\",order_s_s43=\"$new[42]\",order_s_s44=\"$new[43]\",order_s_s45=\"$new[44]\",order_s_s46=\"$new[45]\",order_s_s47=\"$new[46]\",order_s_s48=\"$new[47]\",order_s_s49=\"$new[48]\",order_s_s50=\"$new[49]\" where order_style_no=\"$sty\" and order_del_no=\"$sch\" and order_col_des=\"$color\" and order_no <> 1";

			if(!mysqli_query($link, $update))
			{
				echo "<div class=\"col-sm-12 alert-danger\"><h2><span class=\"label label-default\">Order quantities already updated!</span></h2></div>";
			}
			else
			{
				$insert="insert ignore into $bai_pro3.bai_orders_db_confirm (select * from bai_orders_db where order_style_no=\"$sty\" and order_del_no=\"$sch\" and order_col_des=\"$color\" and order_no = 1 )";
				if(!mysqli_query($link, $insert))
				{			
					echo "<script>sweetAlert('Order Quantity Update Failed','','warning');</script>";
				}
				else
				{			
					echo "<script>sweetAlert('Order Quantity Updated Successfully','','success');</script>";
				}		
			}
		}
	}else{
		echo "<div class='row'><span class='alert alert-error'>There are no colors for the style and schedule</span></div><br/>";
	}
}
?>
<script>
function calculateExcess(){
	var rowscount = document.getElementById('rowscount').value;
	for(var i=0;i<rowscount;i++){
		var k= 11;
		for(var j=1;j<=50;j++){
			if(i<10){
				var ex = document.getElementsByName('s0'+k+i)[0].value;
				if(ex!=0){
					var nameid = 's0'+j+i;
					document.getElementById(nameid).value=Math.round(parseInt(ex)+parseFloat(ex*document.f3.ext.value/100));
				}
			}else{
				var ex = document.getElementsByName('s'+k+i)[0].value;
				if(ex!=0){
					var nameid = 's'+j+i;
					document.getElementById(nameid).value=Math.round(parseInt(ex)+parseFloat(ex*document.f3.ext.value/100));
				}				
			}
			k+=10;			
		}
	}		
}
</script>
</div>
</div>
</div>

<?php	
	$email_header="<html><head><style>
		body
		{
			font-family: Trebuchet MS;
			font-size: 12px;
		}
		
		table
		{
		border-collapse:collapse;
		white-space:nowrap;
		tr.total
		{
		font-weight: bold;
		white-space:nowrap; 
		}
		
		table
		{
		border-collapse:collapse;
		white-space:nowrap;
		font-size: 12pt; 
		}
		}
		
		th
		{
			background-color: RED;
			color: WHITE;
		border: 1px solid #660000;
			padding: 10px;
		white-space:nowrap; 
		
		}
		
		td
		{
			background-color: WHITE;
			color: BLACK;
		border: 1px solid #660000;
			padding: 1px;
		white-space:nowrap; 
		}
		
		td.date
		{
			background-color: WHITE;
			color: BLACK;
		border: 1px solid #660000;
			padding: 5px;
		white-space:nowrap;
		text-align:center;
		}
		
		
		td.style
		{
			background-color: YELLOW;
			color: BLACK;
		border: 1px solid #660000;
			padding: 2px;
		white-space:nowrap; 
		font-weight: bold;
		}
		</style></head><body>";
	$email_footer="</body></html>";
	
	
	function send_email1($from, $to, $bcc, $subject1, $message1)
	{
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: BAI-PRO <".$from.">\r\n";
		$headers .= "Reply-To: ".$from."\r\n";
		$headers .= "Return-Path: ".$from."\r\n";
		//$headers .= "CC: ".$cc."\r\n"
		$headers .= "BCC: ".$to."\r\n";
						
		if (mail($to,$subject1,$message1,$headers) ) 
		{  		
			echo "<h2 align='center'>Email Successfully sent</h2>";	
		} 
		else 
	    {				
			echo "<h2 align='center'>Email could not be sent</h2>";			
		}									
	}
					
	$subject1 = $plant_alert_code."Order Quantity Amendments of $sch on ".date("Y-m-d H:i:s")."";
																	
	$message1 =$email_header;
									
	$message1 .= "Dear All,</BR></BR> Sunny added ".$ext."% extra quantity to $sch schedule Order Qty.<br><br> ";
	
	$message1 .= "<table><tr><th>Size</th><th>New Order Qty</th><th>Old Order Qty</th></tr><tr><td>XS</td><td>$xs_new</td><td>$xs_old</td></tr><tr><td>S</td><td>$s_new</td><td>$s_old</td></tr><tr><td>M</td><td>$m_new</td><td>$m_old</td><tr><td>L</td><td>$l_new</td><td>$l_old</td></tr><tr><td>XL</td><td>$xl_new</td><td>$xl_old</td></tr><tr><td>XXL</td><td>$xxl_new</td><td>$xxl_old</td></tr><tr><td>XXXL</td><td>$xxxl_new</td><td>$xxxl_old</td></tr></table>";
											
	
	
										
	$message1 .=$email_footer;		
											
	send_email1("baiict@brandix.com",$order_quantity_mail,"",$subject1,$message1);
?>

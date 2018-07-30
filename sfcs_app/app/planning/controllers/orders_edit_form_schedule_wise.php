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
<form action="index.php?r=<?php echo $_GET['r']?>" method="post" name="f3">
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
	if($count1 > 0)
	{
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
		$cnt = 0;
		while($row2=mysqli_fetch_array($sql2))
		{
			$flag = $row2['title_flag'];
			$j =11;
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
?> 
</form> 
</div>
</div>
</div>
<script>
function calculateExcess(){
	var rowscount = document.getElementById('rowscount').value;
	for(var i=0;i<2;i++){
		var k= 11;
		for(var j=1;j<=50;j++){
			if(i<10){
				var ex = document.getElementsByName('s0'+k+i)[0].value;
				var nameid = 's0'+j+i;
				document.getElementById(nameid).value=Math.round(parseInt(ex)+parseFloat(ex*document.f3.ext.value/100));
			}else{
				var ex = document.getElementsByName('s'+k+i)[0].value;
				var nameid = 's'+j+i;
				document.getElementById(nameid).value=Math.round(parseInt(ex)+parseFloat(ex*document.f3.ext.value/100));
			}
			k+=10;			
		}
	}
	
		// document.f3.s01ext.value=0;
		// document.f3.s02ext.value=0;
		// document.f3.s03ext.value=0;
		// document.f3.s04ext.value=0;
		// document.f3.s05ext.value=0;
		// document.f3.s06ext.value=0;
		// document.f3.s07ext.value=0;
		// document.f3.s08ext.value=0;
		// document.f3.s09ext.value=0;
		// document.f3.s10ext.value=0;
		// document.f3.s11ext.value=0;
		// document.f3.s12ext.value=0;
		// document.f3.s13ext.value=0;
		// document.f3.s14ext.value=0;
		// document.f3.s15ext.value=0;
		// document.f3.s16ext.value=0;
		// document.f3.s17ext.value=0;
		// document.f3.s18ext.value=0;
		// document.f3.s19ext.value=0;
		// document.f3.s20ext.value=0;
		// document.f3.s21ext.value=0;
		// document.f3.s22ext.value=0;
		// document.f3.s23ext.value=0;
		// document.f3.s24ext.value=0;
		// document.f3.s25ext.value=0;
		// document.f3.s26ext.value=0;
		// document.f3.s27ext.value=0;
		// document.f3.s28ext.value=0;
		// document.f3.s29ext.value=0;
		// document.f3.s30ext.value=0;
		// document.f3.s31ext.value=0;
		// document.f3.s32ext.value=0;
		// document.f3.s33ext.value=0;
		// document.f3.s34ext.value=0;
		// document.f3.s35ext.value=0;
		// document.f3.s36ext.value=0;
		// document.f3.s37ext.value=0;
		// document.f3.s38ext.value=0;
		// document.f3.s39ext.value=0;
		// document.f3.s40ext.value=0;
		// document.f3.s41ext.value=0;
		// document.f3.s42ext.value=0;
		// document.f3.s43ext.value=0;
		// document.f3.s44ext.value=0;
		// document.f3.s45ext.value=0;
		// document.f3.s46ext.value=0;
		// document.f3.s47ext.value=0;
		// document.f3.s48ext.value=0;
		// document.f3.s49ext.value=0;
		// document.f3.s50ext.value=0;
		// document.f3.xsext.value=0;
		// document.f3.sext.value=0;
		// document.f3.mext.value=0;
		// document.f3.lext.value=0;
		// document.f3.xlext.value=0;
		// document.f3.xxlext.value=0;
		// document.f3.xxxlext.value=0;
}
</script>
<?php
if(isset($_POST["update"]))
{
	echo "Hi";
}
?>
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
}

?>

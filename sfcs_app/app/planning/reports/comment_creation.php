<?php
 // require_once('../../Connections/conn.php');
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $theValue) : ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $theValue) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<script type="text/javascript" src="<?= getFullURL($_GET['r'],'js/jquery.js','R')?>"></script>

<script type="text/javascript">
	$(document).ready(function(){	

		if (!$.browser.opera) {
    
			// select element styling
			$('select.select').each(function(){
				var title = $(this).attr('title');
				if( $('option:selected', this).val() != ''  ) title = $('option:selected',this).text();
				$(this)
					.css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
					.after('<span class="select">' + title + '</span>')
					.change(function(){
						val = $('option:selected',this).text();
						$(this).next().text(val);
						})
			});

		};
		
	});
</script>
<script>

function firstbox()
{
	window.location.href ="index.php?r=<?= $_GET['r'] ?>&style="+document.test.style.value
}

function secondbox()
{
	window.location.href ="index.php?r=<?= $_GET['r'] ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value
}

function thirdbox()
{
	window.location.href ="index.php?r=<?= $_GET['r'] ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
}
</script>

 <script>
		function myFunction(aa,bb,cc)
		{
			var aa=aa;
			var bb=bb;
			var cc=cc;
		var x;
		var r=confirm("Are You Sure???");
		if (r==true)
		  {
		  // window.location = "http://beknet:8080/projects/back_end/doc_delet/test.php?aa="+aa+"&bb="+bb+"&cc="+cc+""
		  }
		else
		  {
		   //window.location = "http://beknet:8080/projects/back_end/doc_delet/test.php?aa="+aa+"&bb="+bb+"&cc="+cc+""
		   return true;
		  }
		
		}
		</script>

<link href="<?= getFullURL($_GET['r'],'style_sheet.css','R')?>" rel="stylesheet" type="text/css" media="all" />
<?php 
// include("dbconf.php"); 
// include($_SERVER['DOCUMENT_ROOT'].getFullURL($_GET['r'],'dbconf.php','R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
$weekly_plan_status_mail=$conf1->get('weekly_plan_status_mail');

$query_rs_user_validate = "SELECT tbl_user_auth.username FROM bai_pro3.tbl_user_auth WHERE tbl_user_auth.user_type='sadmin' and tbl_user_auth.active_flag='1' and tbl_user_auth.username='$username' ";
$rs_user_validate = mysqli_query( $link, $query_rs_user_validate) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$row_rs_user_validate = mysqli_fetch_assoc($rs_user_validate);
$totalRows_rs_user_validate = mysqli_num_rows($rs_user_validate);


if(strtolower(trim($username))!=strtolower(trim($row_rs_user_validate['username'])))
{
	$message= '<html><head><style type="text/css">

	body
	{
		font-family: arial;
		font-size:12px;
		color:black;
	}
	
	
	
	</style></head><body>';


	$message_f= $message_sent_via;
	$message_f.="</body></html>";
	$dms=$message."Dear User,<br/><br/>".$username." try to access Docket Delete Interface.<br/><br/>".$message_f;
	$to= $weekly_plan_status_mail;


	$subject = 'Try to Access Docket Delete  Interface';	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "To: $to". "\r\n";
	

	$headers .= 'From: Try to Access Docket Delete  Interface '. "\r\n";
	
	mail($to, $subject, $dms, $headers);
	
	
	
	header("Location:restricted.php");
}
?>

<link rel="stylesheet" href="examples/css/sample.css" />
<!---<script src="js/jquery/jquery-1.8.2.min.js"></script>--->
<!-- <msdropdown> -->
<link rel="stylesheet" type="text/css" href="<?= getFullURL($_GET['r'],'css/msdropdown/dd.css','R')?>" />
<script src="<?= getFullURL($_GET['r'],'js/msdropdown/jquery.dd.min.js','R')?>"></script>
<!-- </msdropdown> -->

<link rel="stylesheet" type="text/css" href="<?= getFullURL($_GET['r'],'css/msdropdown/skin2.css','R')?>" />
<link rel="stylesheet" type="text/css" href="<?= getFullURL($_GET['r'],'css/msdropdown/flags.css','R')?>" />


<div class="panel panel-primary">
<div class="panel-heading">Comment for Schedule</div>
<div class="panel-body">


<body style="height:auto;">

<?php //include("menu_content.php"); ?>
<?php
$style=$_GET['style'];
$schedule=$_GET['schedule']; 
$color=$_GET['color'];

//echo $style.$schedule.$color;
?>
<div class="headeing_outer">
  
    <h1 align="left" ><span style="font-size:36px;">C</span>omment for Schedule</h1>
    
</div>
    
<div style="margin-left:100px;width:960px;color:#333;margin-top:30px;">
    
    <form name="test" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">
      <table width="960px">
        <tr>
          <td width="208"> Select Style :<br />
<div>
            <select name="style" onchange="firstbox();"   class="drop_style" style="margin-top:3px;" >
              <?php


	$sql="select distinct order_style_no from bai_pro3.bai_orders_db where order_del_no NOT IN('0','')";	

mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
?>
	<option value="NIL" selected>NIL</option>
<?php
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
{
?>	
              <option value="<?php echo $sql_row['order_style_no']; ?>" selected><?php echo $sql_row['order_style_no']; ?></option>
<?php              
}
else
{
?>	
              <option value="<?php echo $sql_row['order_style_no']; ?>"><?php echo $sql_row['order_style_no']; ?></option>
<?php              
}

}
?>
            </select></div></td>
          <td width="211"> Select Schedule :<br />
<div><select name="schedule" onchange="secondbox();" style="margin-top:3px;"  class="drop_style"   >
<?php              
//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_del_no, order_joins from bai_orders_db where order_style_no=\"$style\" AND order_joins IN (\"0\",\"2\") and order_del_no NOT IN('0','')";	
//}
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
?>
<option value="NIL" selected>NIL</option>
<?php
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



?>
          </select></div></td>

        </tr>
      </table>
    </form>
    </div>
    
    

<div class="main_div" style="margin-top:20px;" >


<?php


if(isset($_POST['submit2']))
{
	
	$sql33="delete from bai_pro3.ims_log where tid=$tid";
				//echo $sql33;
	mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	$sql33="update bai_pro3.plandoc_stat_log set act_cut_issue_status=\"\" where doc_no=$doc_no";
	mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
}


if((isset($schedule)) and (isset($style))  )
{
	if(($schedule!="NIL") and ($style!="NIL") ){
	$x=0;

	$sql="select DISTINCT (order_del_no),order_div,order_po_no,order_date from bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" ";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$order_tid=$sql_row['order_tid'];
		$customer=$sql_row['order_div'];
		$customer_div=trim($sql_row['order_div']);
		$po_no=$sql_row['order_po_no'];
		$order_date=$sql_row['order_date'];
		$joined="0";    //  Zero mean not joined  , one is joined schedule
		if(substr($sql_row['order_joins'],0,1)=="J")
		{
			$schedule=substr($sql_row['order_joins'],1);
			$joined="1";
		}
		
	
		?>
<div class="headeing_outer">
  
    <h1 align="left" style="font-size:20px;" ><span style="font-size:30px;">S</span>elected Schedule Details</h1>
    
</div>
	<div class="main_div2" style="height:100px;" >
    
	<table align="left" style="border-radius:5px;border-collapse:separate;">
        <tr>
            <td width="100px"  class="schedule_detail_td_header">Schedule</td>
            
            <td   class="td schedule_detail_td"><?php echo $schedule; ?></td> 
            <td width="100px"></td>
            <td width="100px" class="schedule_detail_td_header">Division</td>
            
            <td bgcolor="#e1e1e1"  class="td schedule_detail_td"><?php echo $customer; ?></td>
        </tr>
        <tr>
            <td width="100px" class="schedule_detail_td_header" >Style</td>
           
            <td   class="td schedule_detail_td"><?php echo $style;?></td> 
            <td width="100px"></td>
            <td width="100px" class="schedule_detail_td_header">PO No</td>
            
            <td bgcolor="#e1e1e1"  class="td schedule_detail_td"><?php echo $po_no;?></td>
        </tr>
        <tr>
        	<td width="100px" class="schedule_detail_td_header">Color</td>
            
            <td bgcolor="#e1e1e1"  class="td schedule_detail_td"><?php //echo $color;?></td>
            <td width="100px"></td>
            <td width="100px" class="schedule_detail_td_header">Ex.Factory Date</td>
            <td bgcolor="#e1e1e1"  class="td schedule_detail_td"><?php echo $order_date; ?></td>
        </tr>
    </table>
	</div>
    
    
    <div class="headeing_outer" style="margin-top:20px;">
  
    <h1 align="left" style="font-size:20px;" ><span style="font-size:30px;">C</span>omment</h1>
    
</div>
    <div class="main_div2" style="margin-top:5px;display:block;">
	<form action="<?php getFullURL($_GET['r'],'insert_comment.php','N')?>" method="post" >
    
    
    <input name="sch" type="hidden" value="<?php echo $schedule; ?>" />
	<?php   $username_list=explode('\\',$_SERVER['REMOTE_USER']);
			$username=strtolower($username_list[1]);
			
			$sql1="SELECT * FROM bai_pro3.tbl_comment WHERE sch_no='$schedule'";
			$res=mysqli_query($link, $sql1);
			
			if($sql_row=mysqli_fetch_array($res)){
			$ped=$sql_row['possible_ex'];
			$cd=$sql_row['comp_date'];
			$cmt=$sql_row['sch_cmnt'];
			}
			else{
			$ped=$order_date;
			$cd=$order_date;
			$cmt="";
			}
			
			
						
	if($username != "dineshp"){	  ?>		
	Possible Ex-Fac Date : <input name="ped" type="text" value="<?php echo $ped; ?>" />
	
	<?php   }if($username != "harshanak"){ ?>
	
	Completion Date : <input name="cd" type="text" value="<?php echo $cd; ?>"  />
	<?php  } ?>
	<br><br><br>
	<div style="display:none;">
	FCA : <select name='fca'>
		  <option value="">Select</option>
		    <option value="PASS">PASS</option>
			<option value="FAIL">FAIL</option>
		  </select>
	
	CIF : <select name='cif'>
		  <option value="">Select</option>
		    <option value="Approved">Approved</option>
			<option value="Not Approved">Not Approved</option>
		  </select>
	
	Dispatch : <select name='dispatch'>
		  <option value="">Select</option>
		    <option value="Pending">Pending</option>
			<option value="Done">Done</option>
		  </select>
	</div>
	<br><br><br>

    <textarea name="cmnt" id="cmnt" class="schedule_detail_td" style="height:200px;width:600px;padding:10px;"><?php echo $cmt;   ?></textarea>
    <input name="" type="image" src="<?= getFullURL($_GET['r'],'images/save.png','R');?>" width="128" height="128"  border="0" style="margin-bottom:40px;" />
    
	
	<?php
}
	?>
	
<?php 
} }
   ?> 
   




<script>
function createByJson() {
	var jsonData = [					
					{description:'Choos your payment gateway', value:'', text:'Payment Gateway'},					
					{image:'images/msdropdown/icons/Amex-56.png', description:'My life. My card...', value:'amex', text:'Amex'},
					{image:'images/msdropdown/icons/Discover-56.png', description:'It pays to Discover...', value:'Discover', text:'Discover'},
					{image:'images/msdropdown/icons/Mastercard-56.png', title:'For everything else...', description:'For everything else...', value:'Mastercard', text:'Mastercard'},
					{image:'images/msdropdown/icons/Cash-56.png', description:'Sorry not available...', value:'cash', text:'Cash on devlivery', disabled:true},
					{image:'images/msdropdown/icons/Visa-56.png', description:'All you need...', value:'Visa', text:'Visa'},
					{image:'images/msdropdown/icons/Paypal-56.png', description:'Pay and get paid...', value:'Paypal', text:'Paypal'}
					];
	$("#byjson").msDropDown({byJson:{data:jsonData, name:'payments2'}}).data("dd");
}
$(document).ready(function(e) {		
	//no use
	try {
		var pages = $("#pages").msDropdown({on:{change:function(data, ui) {
												var val = data.value;
												if(val!="")
													window.location = val;
											}}}).data("dd");

		var pagename = document.location.pathname.toString();
		pagename = pagename.split("/");
		pages.setIndexByValue(pagename[pagename.length-1]);
		$("#ver").html(msBeautify.version.msDropdown);
	} catch(e) {
		//console.log(e);	
	}
	
	$("#ver").html(msBeautify.version.msDropdown);
		
	//convert
	$("select").msDropdown();
	createByJson();
	$("#tech").data("dd");
});
function showValue(h) {
	console.log(h.name, h.value);
}
$("#tech").change(function() {
	console.log("by jquery: ", this.value);
})
//
</script>

</body>

</div>
</div>
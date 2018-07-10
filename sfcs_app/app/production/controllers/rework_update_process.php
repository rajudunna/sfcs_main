<!--
Core Module:In this interface output updating process will be done.

Deascription:In this interface output updating process will be done.

Changes Log:

Kirang/20150307 added validation to avoid additional output.
-->

<?php $process_the_auto_process=0; //1-Yes ; 0-No; ?>
	<title>Rework Update</title>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',1,'R'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/check.js',1,'R'); ?>"></script>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/js/ddcolortabs.css',1,'R'); ?>" type="text/css" media="all" />

<script type="text/javascript" language="javascript">
    window.onload = function () {
        noBack();
    }
    window.history.forward();
    function noBack() {
        window.history.forward();
    }
</script>

 <script language="JavaScript">

        var version = navigator.appVersion;

        function showKeyCode(e) {
            var keycode = (window.event) ? event.keyCode : e.keyCode;

            if ((version.indexOf('MSIE') != -1)) {
                if (keycode == 116) {
                    event.keyCode = 0;
                    event.returnValue = false;
                    return false;
                }
            }
            else {
                if (keycode == 116) {
                    return false;
                }
            }
        }

    </script>
    
<body onpageshow="if (event.persisted) noBack();" onkeydown="return showKeyCode(event)">

<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
//To validate the output entries
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));	
?>

<div id="wait" ><h2><font color="red">Please wait while processing the data...</font></h2></div>
<?php

//S:To avoid Duplicate Entry - 20150511 Kirang
session_start();

//Retrieve the value of the hidden field
$form_secret = isset($_POST["form_secret"])?$_POST["form_secret"]:'';

unset($_SESSION["form_secret"]);

if(isset($_POST['date']))
{
	// echo "ok";
	$dat=$_POST['date'];
	$temp_dat=$_POST['date'];
	$zone=$_POST['zone_base'];
	$msh=$_POST['shift'];
	$mno_x=$_POST['module'];
	$mst_x=$_POST['style'];
	$temp_style_x=$_POST['style'];
	
	$m3_style=$_POST['m3_style']; //M3 bulk OR updates
	
	
	$mqt_x=$_POST['qty'];
	$rework_qty=$_POST['rework_qty']; //rework
	$sta_x=$_POST['stat'];
	$rem_x=$_POST['remarks'];
	$schedule_x=$_POST['schedule'];
	$color_x=$_POST['color'];
	$doc_no_x=$_POST['cut'];
	$size_x=$_POST['size'];
	$tid_x=$_POST['tid'];
	$csnb_code_x=$_POST['csnb_code'];
	$note="";
	
	$usr_msg="The following entries are failed to update due to M3 system validations:<br/><table border=1><tr><th>Module</th><th>Schedule</th><th>Color</th><th>Size</th><th>Quantity</th></tr>";
	
	for($x=0;$x<sizeof($mno_x);$x++)
	{	
		// echo "<script>alert('into for loop');</script>";		
		//Validation to calcuate clock hours
		if($mqt_x[0]=="")
		{
			$mqt_x[0]=0;
		}
		
		// if($mqt_x[$x]>=0 and $mqt_x[$x]!="" and is_numeric($mqt_x[$x]))
		{					
			$mno=$mno_x[$x];
			$mst=$mst_x[$x];
			$temp_style=$mst_x[$x];
			$mqt=$mqt_x[$x];
			$rew_qty=$rework_qty[$x]; //rework
			$sta=$sta_x[$x];
			$rem=$rem_x[$x];
			$schedule=$schedule_x[$x];
			$color=$color_x[$x];
			$doc_no=$doc_no_x[$x];
			
			$m3_style_code=$m3_style[$x]; //M3 bulk OR updates
			
			$size=$size_x[$x];
			$tid=$tid_x[$x];
			
			$csnb_code=$csnb_code_x[$x];
			$csnb=array();
			$csnb=explode("^",$csnb_code);
			
			$note.=$doc_no."-".$mqt."<br/>";
			
			if($zone>0)
			{
				$dat=date("Y-m-d", strtotime($dat))." ".$zone.":00:00";
			}
		
			//$sec=$_POST['section'];
			
			$words=explode("*",$size);
			$size=substr($words[0],2);
			$identity=$words[1];
			
			$ldate=date("Y-m-d H:i:s");
			
			$words = explode(' ', $dat);
			$first_word = $words[0];
			$code=$first_word."-".$mno; 
		
			//Added validation to accept zero values for clocking. -kirang 2015-09-03
			if($mqt==0)
			{
				$ret_val='TRUE';
			}
			else
			{
				$ret_val=output_validation('SOT',$schedule,$color,$size,$mqt,$tid,$username);
			}
			// echo "<script>alert('till return value if condition');</script>";
			//Validations
			if($ret_val=='TRUE')
			{		
				$mst=$temp_style;
				$couple=$csnb[0];
				$smv=$csnb[1];
				$nop=$csnb[2];
				$buyer=$csnb[3];
				$sec=$csnb[4];
				$dat=date('Y-m-d');
				// echo "<script>alert('till rework if condition');</script>";
				//REWORK
				if($rew_qty>=0 and $rew_qty!="")
				{
					// echo "<script>alert('till insert query');</script>";
					$sql="insert into $bai_pro.bai_quality_log (bac_no, bac_sec, bac_qty, bac_lastup, bac_date, bac_shift, bac_style, bac_remarks,  log_time, color, buyer, delivery, loguser) values (\"$mno\", \"$sec\", \"$rew_qty\", \"$dat\", \"$dat\", \"$msh\", \"$mst\", \"$rem\",  \"$ldate\",  \"$color\", \"$buyer\", \"$schedule\",USER())"; 
					// echo $sql."<br/>";
					// die();
					$note.=$sql."<br/>";
					mysqli_query($link, $sql) or exit("Sql Error5$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
					// echo "<script>alert('query executed');</script>";
				}
				$flag=1;
			}
			else
			{
				$usr_msg.="<tr><td>$mno</td><td>$schedule</td><td>$color</td><td>$size</td><td>$mqt</td></tr>";
			}
			//Validations					
		}//condition			
	} //LOOP
	$back_url = getFullURLLevel($_GET['r'],'rework_update.php',0,'N');
	echo "<script>document.getElementById('wait').style.visibility='hidden';</script>";
	echo "<h2><font color=green>Data Saved Successfully!!</font></h2>";
	echo "<a href= '$back_url' class='btn btn-primary'>Click Here to go back</a>";

	echo '<script type="text/javascript">
            function Redirect() {
               window.location="'.$back_url.'";
            }
            
            document.write("You will be redirected back in 5 sec.");
            setTimeout("Redirect()", 5000);
      </script>';
		
	$usr_msg.="</table>";
	if ($flag!=1) {
	 	echo $usr_msg;
	} 

 
	// header("Location: ims_close.php?usr_msg=$usr_msg");
	
	// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",10000); function Redirect() {  window.close(); }</script>";
}
?>



<?php ((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res); ?>
<?php ((is_null($___mysqli_res = mysqli_close($link11))) ? false : $___mysqli_res); ?>
<?php ((is_null($___mysqli_res = mysqli_close($link22))) ? false : $___mysqli_res); ?>

</body>
</html>
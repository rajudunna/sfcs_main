<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
?>

<script>
function check1(x,y)
{
	if(x<0 || x=="")
	{
		alert("Please enter correct value");
		return 1010;
	}
	if(x>y)
	{
		alert("Please enter correct value");
		return 1010;
	}
}

function check2(x,y)
{
	if(x<0 || x=="")
	{
		alert("Please enter correct value");
		return 1010;
	}
}
function isNum(evt)
{
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) 
	{
        return false;
    }
    return true;
}
</script>
<style>
body
{
	font-family:arial;
	font-size:14px;
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align:center;
	vertical-align:top;
white-space:nowrap; 
}

table th
{
	border: 1px solid black;
	text-align: center;
	/*background-color: BLUE;*/
	color: BLACK;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:14px;
}


</style>

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

<?php 
//include($_SERVER['DOCUMENT_ROOT']."/sfcs/M3_Bulk_OR/ims_size.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

 ?>

<body onpageshow="if (event.persisted) noBack();" onkeydown="return showKeyCode(event)">

<div class="panel panel-primary"><div class="panel-heading">Recut / Sample Request Form</div><div class="panel-body">

<?php
if(isset($_POST['request']))
{
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
	$module=$_POST['module'];
	$order_tid=$_POST['order_tid'];
	$cat=$_POST['cat'];
	$size=$_POST['size'];
	$sizes_titles=$_POST['sizes_titles'];
	$qty=$_POST['qty'];
	$doc_no = $_POST['doc_no'];
	$old_size = $_POST['old_size'];
	$ops_code = $_POST['ops_code'];
	//$user=$_POST['user'];
	$open_access=$_POST['open_access'];
	$qty_act = array();
	$size_act = array();
//$size_act = $size;
	//$qty_act = $qty;
	// var_dump($size);
	if(sizeof($cat)>0)
	{
		for($i=0;$i<sizeof($cat);$i++)
		{
			$count=0;
			
			$temp=array();
			$temp=explode("-",$cat[$i]);
			
			$sql="select doc_no from $bai_pro3.recut_v2 where order_tid=\"$order_tid\" and cat_ref=\"".$temp[0]."\"";		
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$count=mysqli_num_rows($sql_result);
			$count=$count+1;
				$size = array_unique($size);
				foreach($size as $key=>$value)
				{
					for($qty_i = 0; $qty_i < sizeof($qty[$value]); $qty_i++)
					{
						$qty2[$value] += $qty[$value][$qty_i];
						$qty_act[] = $qty[$value][$qty_i];
						$size_act[] = $value;
					}
				}
				foreach($qty2 as $qty2_key => $qty2_value)
				{
					$size_string .= $qty2_key.',';
					$qty_string .= $qty2_value.',';

				}
				$size_string = rtrim($size_string,",");
				$qty_string = rtrim($qty_string,",");
				$size_string2=str_replace("p_","a_",$size_string);
				if(array_sum($qty2)>0)
				{
					$sql="insert into $bai_pro3.recut_v2 (date,cat_ref,order_tid,pcutno,acutno,plan_module,remarks,$size_string,$size_string2) values (\"".date("Y-m-d")."\",".$temp[0].",\"$order_tid\",$count,$count,\"$module\",\"".$temp[1]."\",".$qty_string.",$qty_string)";
					//echo $sql.'</br>';
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$iLastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
					//var_dump($size_act);
					$size = array();
					foreach($size_act as $key => $value)
					{
						$doc_no_sub = substr($doc_no[$key], 0, 1);
						if($doc_no_sub == 'D' || $doc_no_sub == 'R')
						{
							$doc_no[$key] = substr($doc_no[$key], 1);
						}
						if($ops_code[$key] == '')
						{
							$ops_code[$key] = '15';
						}
						$qty_actual = $qty_act[$key];
						$size_actual = substr($size_act[$key], 2);
						$size[]=$size_actual;
						$qty[] = $qty_actual;
						$insert_qry = "INSERT INTO `recut_v2_child` (`parent_id`,`doc_no`,`size`,`qty`,`operation_id`) VALUE ($iLastid,'$doc_no[$key]','$size_actual',$qty_actual,$ops_code[$key])";	
						// echo $insert_qry.'</br>';
						$sql_result=mysqli_query($link, $insert_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}
			// die();
				
				if($temp[1]=="Body" or $temp[1]=="Front")
				{
					if($open_access!=1)
					{
						$qms_size=array();$qms_sizes=array();
						$qms_qty=array();
						$qms_doc = array();
						$sql="select qms_size,SUM(IF((qms_tran_type = 2),qms_qty,0)) AS \"replaced\",  SUM(IF((qms_tran_type = 3),qms_qty,0)) AS \"rejected\",  SUM(IF((qms_tran_type = 6),qms_qty,0)) AS \"recut_raised\",doc_no,operation_id from $bai_pro3.bai_qms_db where qms_style=\"$style\" and qms_schedule=\"$schedule\" and qms_color=\"$color\" and SUBSTRING_INDEX(remarks,\"-\",1)=\"$module\" group by qms_size";
						// echo $sql.'</br>';
						//echo "Hello";
							$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row=mysqli_fetch_array($sql_result))
							{
							$replaced=$sql_row['replaced'];
							//echo "Replace=".$replaced;
							$rejected=$sql_row['rejected'];
							$recut_raised=$sql_row['recut_raised'];
							$bal=$rejected-$replaced-$recut_raised;
							//echo "<br>bal=".$bal;
							if($bal>0)
							{
								$qms_size[]=$sql_row['qms_size'];
								$qms_doc[]=$sql_row['doc_no'];
								//echo "<br>".$sql_row['qms_size'];
								$qms_qty[]=$bal;
							}
						}
					}
					
					//var_dump($size);
					for($j=0;$j<sizeof($size);$j++)
					{
						if($open_access==1)
						{
							if($qty[$j]>0)
							{
								$sql="insert into $bai_pro3.bai_qms_db (qms_style,qms_schedule,qms_color,log_date,qms_size,qms_qty,qms_tran_type,remarks,ref1) values (\"$style\",\"$schedule\",\"$color\",\"".date("Y-m-d")."\",\"".$size[$j]."\",".$qty[$j].",6,\"$module-$iLastid\",\"$username\")";
								//echo $sql.'</br>';
								$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
						}
						else
						{
							if($qty[$j]>0 and $qms_qty[array_search(str_replace("p_","",$size[$j]),$qms_size)]>0 and $qms_qty[array_search(str_replace("p_","",$size[$j]),$qms_size)]>=$qty[$j])
							{
								$sql="insert into $bai_pro3.bai_qms_db (qms_style,qms_schedule,qms_color,log_date,qms_size,qms_qty,qms_tran_type,remarks,ref1) values (\"$style\",\"$schedule\",\"$color\",\"".date("Y-m-d")."\",\"".$size[$j]."\",".$qty[$j].",6,\"$module-$iLastid\",\"$username\")";
								//echo $sql.'</br>';
								$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
						}
						
					}
				}
		}
		
		//die();
		echo "<h2><font color=\"green\"><b>Successfully Completed.</b></font></h2>";
		// echo "<script>swal('Successfully Completed','','success');</script>";
	}
	else
	{
		echo "<h2><font color=\"red\"><b>No Categories were selected.</b></font></h2>";
	}
	$url=getFullURLLevel($_GET['r'],'search_test.php',0,'N');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"$url\"; }</script>";
	// header("Location:$url");
	// exit();
	
}


?>

<?php //include("../menu_content.php"); ?>
<?php

if(isset($_POST['search']))
{
	$style=$_POST['style'];
	$schedule=$_POST['schedule']; 
	$color=$_POST['color'];
	$module=$_POST['module'];
}
else
{
	$style=$_GET['style'];
	$schedule=$_GET['schedule']; 
	$color=$_GET['color'];
}

//echo $style.$schedule.$color;
?>

<?php

if(isset($_POST['search']))
{
	$style=$_POST['style'];
	$schedule=$_POST['schedule']; 
	$color=$_POST['color'];
	$module=$_POST['module'];
	$order_tid=$_POST['order_tid'];
	// start special request
	$user=$_POST['user'];	
	//$user='sfcsproject1';	
	$chk = 0;
	if(strlen($user)>0)
	{
		$chk = 1;
	} 
	else
	{
		$chk = 0;
	}
	// end special request
	$open_access=0;
	
	$sql="select * from $bai_pro3.sections_db ";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$user=$sql_row['sec_head'];
	}
	if(mysqli_num_rows($sql_result)>0)
	{
		$open_access=1;
	}
	
	?>
	<br/><br/><br/><form method="post" name="input" action="<?php echo getFullURL($_GET['r'], "search_test_process.php", "N");?>" autocomplete="off">
	<?php
	//echo "<form method=\"post\" name=\"input\" action=\"process.php\">";
	echo "<input type=\"hidden\" name=\"r\" value=".$_GET['r'].">";
	echo "<input type=\"hidden\" name=\"style\" value=\"$style\">";
	echo "<input type=\"hidden\" name=\"schedule\" value=\"$schedule\">";
	echo "<input type=\"hidden\" name=\"color\" value=\"$color\">";
	echo "<input type=\"hidden\" name=\"order_tid\" value=\"$order_tid\">";
	echo "<input type=\"hidden\" name=\"module\" value=\"$module\">";
	echo "<input type=\"hidden\" name=\"user\" value=\"$user\">";
	echo "<input type=\"hidden\" name=\"open_access\" value=\"$open_access\">";
	
	
	$categories="";
	$sql="select tid,category from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and length(category)>0";
	//echo $sql;
	$y=0;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$categories.="<input type=\"checkbox\" name=\"cat[]\" id='cat_$y' value=\"".$sql_row['tid']."-".$sql_row['category']."\">".$sql_row['category']."<br/>";
		$y=$y+1;
	}
	
	// echo $open_access.'-';
	// echo $chk.'</br>';
	if($open_access==$chk)  // if condition true specila else default.
	{
		// Special block
		$qms_size=array();$qms_sizes=array();
		$qms_qty=array();
		$qms_doc=array();
		$qms_ops=array();
		
		$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
				$size01 = $sql_row['title_size_s01'];
				$size02 = $sql_row['title_size_s02'];
				$size03 = $sql_row['title_size_s03'];
				$size04 = $sql_row['title_size_s04'];
				$size05 = $sql_row['title_size_s05'];
				$size06 = $sql_row['title_size_s06'];
				$size07 = $sql_row['title_size_s07'];
				$size08 = $sql_row['title_size_s08'];
				$size09 = $sql_row['title_size_s09'];
				$size10 = $sql_row['title_size_s10'];
				$size11 = $sql_row['title_size_s11'];
				$size12 = $sql_row['title_size_s12'];
				$size13 = $sql_row['title_size_s13'];
				$size14 = $sql_row['title_size_s14'];
				$size15 = $sql_row['title_size_s15'];
				$size16 = $sql_row['title_size_s16'];
				$size17 = $sql_row['title_size_s17'];
				$size18 = $sql_row['title_size_s18'];
				$size19 = $sql_row['title_size_s19'];
				$size20 = $sql_row['title_size_s20'];
				$size21 = $sql_row['title_size_s21'];
				$size22 = $sql_row['title_size_s22'];
				$size23 = $sql_row['title_size_s23'];
				$size24 = $sql_row['title_size_s24'];
				$size25 = $sql_row['title_size_s25'];
				$size26 = $sql_row['title_size_s26'];
				$size27 = $sql_row['title_size_s27'];
				$size28 = $sql_row['title_size_s28'];
				$size29 = $sql_row['title_size_s29'];
				$size30 = $sql_row['title_size_s30'];
				$size31 = $sql_row['title_size_s31'];
				$size32 = $sql_row['title_size_s32'];
				$size33 = $sql_row['title_size_s33'];
				$size34 = $sql_row['title_size_s34'];
				$size35 = $sql_row['title_size_s35'];
				$size36 = $sql_row['title_size_s36'];
				$size37 = $sql_row['title_size_s37'];
				$size38 = $sql_row['title_size_s38'];
				$size39 = $sql_row['title_size_s39'];
				$size40 = $sql_row['title_size_s40'];
				$size41 = $sql_row['title_size_s41'];
				$size42 = $sql_row['title_size_s42'];
				$size43 = $sql_row['title_size_s43'];
				$size44 = $sql_row['title_size_s44'];
				$size45 = $sql_row['title_size_s45'];
				$size46 = $sql_row['title_size_s46'];
				$size47 = $sql_row['title_size_s47'];
				$size48 = $sql_row['title_size_s48'];
				$size49 = $sql_row['title_size_s49'];
				$size50 = $sql_row['title_size_s50'];

							
				if($sql_row['order_s_xs']>0) { $qms_size[]='xs';$qms_sizes[]='xs'; $qms_qty[]=0; }
				if($sql_row['order_s_s']>0) { $qms_size[]='s'; $qms_sizes[]='s'; $qms_qty[]=0; }
				if($sql_row['order_s_m']>0) { $qms_size[]='m'; $qms_sizes[]='m';$qms_qty[]=0; }
				if($sql_row['order_s_l']>0) { $qms_size[]='l'; $qms_sizes[]='l';$qms_qty[]=0; }
				if($sql_row['order_s_xl']>0) { $qms_size[]='xl'; $qms_sizes[]='xl';$qms_qty[]=0; }
				if($sql_row['order_s_xxl']>0) { $qms_size[]='xxl'; $qms_sizes[]='xxl';$qms_qty[]=0; }
				if($sql_row['order_s_xxxl']>0) { $qms_size[]='xxxl'; $qms_sizes[]='xxxl'; $qms_qty[]=0; }
				if($sql_row['order_s_s01']>0) { $qms_size[]='s01'; $qms_sizes[]=$size01; $qms_qty[]=0; }
				if($sql_row['order_s_s02']>0) { $qms_size[]='s02'; $qms_sizes[]=$size02; $qms_qty[]=0; }
				if($sql_row['order_s_s03']>0) { $qms_size[]='s03'; $qms_sizes[]=$size03; $qms_qty[]=0; }
				if($sql_row['order_s_s04']>0) { $qms_size[]='s04'; $qms_sizes[]=$size04; $qms_qty[]=0; }
				if($sql_row['order_s_s05']>0) { $qms_size[]='s05'; $qms_sizes[]=$size05; $qms_qty[]=0; }
				if($sql_row['order_s_s06']>0) { $qms_size[]='s06'; $qms_sizes[]=$size06; $qms_qty[]=0; }
				if($sql_row['order_s_s07']>0) { $qms_size[]='s07'; $qms_sizes[]=$size07; $qms_qty[]=0; }
				if($sql_row['order_s_s08']>0) { $qms_size[]='s08'; $qms_sizes[]=$size08; $qms_qty[]=0; }
				if($sql_row['order_s_s09']>0) { $qms_size[]='s09'; $qms_sizes[]=$size09; $qms_qty[]=0; }
				if($sql_row['order_s_s10']>0) { $qms_size[]='s10'; $qms_sizes[]=$size10; $qms_qty[]=0; }
				if($sql_row['order_s_s11']>0) { $qms_size[]='s11'; $qms_sizes[]=$size11; $qms_qty[]=0; }
				if($sql_row['order_s_s12']>0) { $qms_size[]='s12'; $qms_sizes[]=$size12; $qms_qty[]=0; }
				if($sql_row['order_s_s13']>0) { $qms_size[]='s13'; $qms_sizes[]=$size13; $qms_qty[]=0; }
				if($sql_row['order_s_s14']>0) { $qms_size[]='s14'; $qms_sizes[]=$size14; $qms_qty[]=0; }
				if($sql_row['order_s_s15']>0) { $qms_size[]='s15'; $qms_sizes[]=$size15; $qms_qty[]=0; }
				if($sql_row['order_s_s16']>0) { $qms_size[]='s16'; $qms_sizes[]=$size16; $qms_qty[]=0; }
				if($sql_row['order_s_s17']>0) { $qms_size[]='s17'; $qms_sizes[]=$size17; $qms_qty[]=0; }
				if($sql_row['order_s_s18']>0) { $qms_size[]='s18'; $qms_sizes[]=$size18; $qms_qty[]=0; }
				if($sql_row['order_s_s19']>0) { $qms_size[]='s19'; $qms_sizes[]=$size19; $qms_qty[]=0; }
				if($sql_row['order_s_s20']>0) { $qms_size[]='s20'; $qms_sizes[]=$size20; $qms_qty[]=0; }
				if($sql_row['order_s_s21']>0) { $qms_size[]='s21'; $qms_sizes[]=$size21; $qms_qty[]=0; }
				if($sql_row['order_s_s22']>0) { $qms_size[]='s22'; $qms_sizes[]=$size22; $qms_qty[]=0; }
				if($sql_row['order_s_s23']>0) { $qms_size[]='s23'; $qms_sizes[]=$size23; $qms_qty[]=0; }
				if($sql_row['order_s_s24']>0) { $qms_size[]='s24'; $qms_sizes[]=$size24; $qms_qty[]=0; }
				if($sql_row['order_s_s25']>0) { $qms_size[]='s25'; $qms_sizes[]=$size25; $qms_qty[]=0; }
				if($sql_row['order_s_s26']>0) { $qms_size[]='s26'; $qms_sizes[]=$size26; $qms_qty[]=0; }
				if($sql_row['order_s_s27']>0) { $qms_size[]='s27'; $qms_sizes[]=$size27; $qms_qty[]=0; }
				if($sql_row['order_s_s28']>0) { $qms_size[]='s28'; $qms_sizes[]=$size28; $qms_qty[]=0; }
				if($sql_row['order_s_s29']>0) { $qms_size[]='s29'; $qms_sizes[]=$size29; $qms_qty[]=0; }
				if($sql_row['order_s_s30']>0) { $qms_size[]='s30'; $qms_sizes[]=$size30; $qms_qty[]=0; }
				if($sql_row['order_s_s31']>0) { $qms_size[]='s31'; $qms_sizes[]=$size31; $qms_qty[]=0; }
				if($sql_row['order_s_s32']>0) { $qms_size[]='s32'; $qms_sizes[]=$size32; $qms_qty[]=0; }
				if($sql_row['order_s_s33']>0) { $qms_size[]='s33'; $qms_sizes[]=$size33; $qms_qty[]=0; }
				if($sql_row['order_s_s34']>0) { $qms_size[]='s34'; $qms_sizes[]=$size34; $qms_qty[]=0; }
				if($sql_row['order_s_s35']>0) { $qms_size[]='s35'; $qms_sizes[]=$size35; $qms_qty[]=0; }
				if($sql_row['order_s_s36']>0) { $qms_size[]='s36'; $qms_sizes[]=$size36; $qms_qty[]=0; }
				if($sql_row['order_s_s37']>0) { $qms_size[]='s37'; $qms_sizes[]=$size37; $qms_qty[]=0; }
				if($sql_row['order_s_s38']>0) { $qms_size[]='s38'; $qms_sizes[]=$size38; $qms_qty[]=0; }
				if($sql_row['order_s_s39']>0) { $qms_size[]='s39'; $qms_sizes[]=$size39; $qms_qty[]=0; }
				if($sql_row['order_s_s40']>0) { $qms_size[]='s40'; $qms_sizes[]=$size40; $qms_qty[]=0; }
				if($sql_row['order_s_s41']>0) { $qms_size[]='s41'; $qms_sizes[]=$size41; $qms_qty[]=0; }
				if($sql_row['order_s_s42']>0) { $qms_size[]='s42'; $qms_sizes[]=$size42; $qms_qty[]=0; }
				if($sql_row['order_s_s43']>0) { $qms_size[]='s43'; $qms_sizes[]=$size43; $qms_qty[]=0; }
				if($sql_row['order_s_s44']>0) { $qms_size[]='s44'; $qms_sizes[]=$size44; $qms_qty[]=0; }
				if($sql_row['order_s_s45']>0) { $qms_size[]='s45'; $qms_sizes[]=$size45; $qms_qty[]=0; }
				if($sql_row['order_s_s46']>0) { $qms_size[]='s46'; $qms_sizes[]=$size46; $qms_qty[]=0; }
				if($sql_row['order_s_s47']>0) { $qms_size[]='s47'; $qms_sizes[]=$size47; $qms_qty[]=0; }
				if($sql_row['order_s_s48']>0) { $qms_size[]='s48'; $qms_sizes[]=$size48; $qms_qty[]=0; }
				if($sql_row['order_s_s49']>0) { $qms_size[]='s49'; $qms_sizes[]=$size49; $qms_qty[]=0; }
				if($sql_row['order_s_s50']>0) { $qms_size[]='s50'; $qms_sizes[]=$size50; $qms_qty[]=0; }

				
		}
		
		for($i=0;$i<sizeof($qms_size);$i++)
		{
			$sql="select qms_size,SUM(IF((qms_tran_type = 2),qms_qty,0)) AS \"replaced\",  SUM(IF((qms_tran_type = 3),qms_qty,0)) AS \"rejected\",  SUM(IF((qms_tran_type = 6),qms_qty,0)) AS \"recut_raised\",doc_no,operation_id from $bai_pro3.bai_qms_db where qms_style=\"$style\" and qms_schedule=\"$schedule\" and qms_color=\"$color\" and SUBSTRING_INDEX(remarks,\"-\",1)=\"$module\" and qms_size=\"".$qms_size[$i]."\" group by qms_size";
//echo $sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$replaced=$sql_row['replaced'];
				$rejected=$sql_row['rejected'];
				$recut_raised=$sql_row['recut_raised'];
				$bal=$rejected-$replaced-$recut_raised;
				if($bal>0)
				{
					$qms_qty[$i]=$bal;
					$qms_doc[$i] = $sql_row['doc_no'];
					$qms_ops[$i] = $sql_row['operation_id'];
					//echo "1bal =".$bal;
				}
			}
			
		}
		
	}
	else
	{

		$qms_size=array();$qms_sizes=array();
		$qms_qty=array();
		$qms_doc = array();
		$qms_ops = array();
		$sql="select qms_size,SUM(IF((qms_tran_type = 2),qms_qty,0)) AS \"replaced\",  SUM(IF((qms_tran_type = 3),qms_qty,0)) AS \"rejected\",  SUM(IF((qms_tran_type = 6),qms_qty,0)) AS \"recut_raised\",doc_no,operation_id from $bai_pro3.bai_qms_db where qms_style=\"$style\" and qms_schedule=\"$schedule\" and qms_color=\"$color\" and SUBSTRING_INDEX(remarks,\"-\",1)=\"$module\" group by qms_size";
		// echo $sql;
		//echo "Hello";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$replaced=$sql_row['replaced'];
			//echo "Replace=".$replaced;
			$rejected=$sql_row['rejected'];
			$recut_raised=$sql_row['recut_raised'];
			$bal=$rejected-$replaced-$recut_raised;
			//echo "<br>2i bal=".$bal;
			if($bal>0)
			{
				$qms_size[]=$sql_row['qms_size'];
				$qms_sizes[]=ims_sizes($order_tid,$schedule,$style,$color,$sql_row['qms_size'],$link);
				//echo "<br>".$sql_row['qms_size'];
				$qms_qty[]=$bal;
				$qms_doc[] = $sql_row['doc_no'];
				$qms_ops[] = $sql_row['operation_id'];
			}
		}
		
		if($module=="TOP")
		{				
			$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
			//echo $sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{	
				$size01 = $sql_row['title_size_s01'];
				$size02 = $sql_row['title_size_s02'];
				$size03 = $sql_row['title_size_s03'];
				$size04 = $sql_row['title_size_s04'];
				$size05 = $sql_row['title_size_s05'];
				$size06 = $sql_row['title_size_s06'];
				$size07 = $sql_row['title_size_s07'];
				$size08 = $sql_row['title_size_s08'];
				$size09 = $sql_row['title_size_s09'];
				$size10 = $sql_row['title_size_s10'];
				$size11 = $sql_row['title_size_s11'];
				$size12 = $sql_row['title_size_s12'];
				$size13 = $sql_row['title_size_s13'];
				$size14 = $sql_row['title_size_s14'];
				$size15 = $sql_row['title_size_s15'];
				$size16 = $sql_row['title_size_s16'];
				$size17 = $sql_row['title_size_s17'];
				$size18 = $sql_row['title_size_s18'];
				$size19 = $sql_row['title_size_s19'];
				$size20 = $sql_row['title_size_s20'];
				$size21 = $sql_row['title_size_s21'];
				$size22 = $sql_row['title_size_s22'];
				$size23 = $sql_row['title_size_s23'];
				$size24 = $sql_row['title_size_s24'];
				$size25 = $sql_row['title_size_s25'];
				$size26 = $sql_row['title_size_s26'];
				$size27 = $sql_row['title_size_s27'];
				$size28 = $sql_row['title_size_s28'];
				$size29 = $sql_row['title_size_s29'];
				$size30 = $sql_row['title_size_s30'];
				$size31 = $sql_row['title_size_s31'];
				$size32 = $sql_row['title_size_s32'];
				$size33 = $sql_row['title_size_s33'];
				$size34 = $sql_row['title_size_s34'];
				$size35 = $sql_row['title_size_s35'];
				$size36 = $sql_row['title_size_s36'];
				$size37 = $sql_row['title_size_s37'];
				$size38 = $sql_row['title_size_s38'];
				$size39 = $sql_row['title_size_s39'];
				$size40 = $sql_row['title_size_s40'];
				$size41 = $sql_row['title_size_s41'];
				$size42 = $sql_row['title_size_s42'];
				$size43 = $sql_row['title_size_s43'];
				$size44 = $sql_row['title_size_s44'];
				$size45 = $sql_row['title_size_s45'];
				$size46 = $sql_row['title_size_s46'];
				$size47 = $sql_row['title_size_s47'];
				$size48 = $sql_row['title_size_s48'];
				$size49 = $sql_row['title_size_s49'];
				$size50 = $sql_row['title_size_s50'];

				if($sql_row['order_s_xs']>0) { $qms_size[]='xs';$qms_sizes[]='xs'; $qms_qty[]=0; }
				if($sql_row['order_s_s']>0) { $qms_size[]='s'; $qms_sizes[]='s'; $qms_qty[]=0; }
				if($sql_row['order_s_m']>0) { $qms_size[]='m'; $qms_sizes[]='m';$qms_qty[]=0; }
				if($sql_row['order_s_l']>0) { $qms_size[]='l'; $qms_sizes[]='l';$qms_qty[]=0; }
				if($sql_row['order_s_xl']>0) { $qms_size[]='xl'; $qms_sizes[]='xl';$qms_qty[]=0; }
				if($sql_row['order_s_xxl']>0) { $qms_size[]='xxl'; $qms_sizes[]='xxl';$qms_qty[]=0; }
				if($sql_row['order_s_xxxl']>0) { $qms_size[]='xxxl'; $qms_sizes[]='xxxl'; $qms_qty[]=0; }
				if($sql_row['order_s_s01']>0) { $qms_size[]='s01'; $qms_sizes[]=$size01; $qms_qty[]=0; }
				if($sql_row['order_s_s02']>0) { $qms_size[]='s02'; $qms_sizes[]=$size02; $qms_qty[]=0; }
				if($sql_row['order_s_s03']>0) { $qms_size[]='s03'; $qms_sizes[]=$size03; $qms_qty[]=0; }
				if($sql_row['order_s_s04']>0) { $qms_size[]='s04'; $qms_sizes[]=$size04; $qms_qty[]=0; }
				if($sql_row['order_s_s05']>0) { $qms_size[]='s05'; $qms_sizes[]=$size05; $qms_qty[]=0; }
				if($sql_row['order_s_s06']>0) { $qms_size[]='s06'; $qms_sizes[]=$size06; $qms_qty[]=0; }
				if($sql_row['order_s_s07']>0) { $qms_size[]='s07'; $qms_sizes[]=$size07; $qms_qty[]=0; }
				if($sql_row['order_s_s08']>0) { $qms_size[]='s08'; $qms_sizes[]=$size08; $qms_qty[]=0; }
				if($sql_row['order_s_s09']>0) { $qms_size[]='s09'; $qms_sizes[]=$size09; $qms_qty[]=0; }
				if($sql_row['order_s_s10']>0) { $qms_size[]='s10'; $qms_sizes[]=$size10; $qms_qty[]=0; }
				if($sql_row['order_s_s11']>0) { $qms_size[]='s11'; $qms_sizes[]=$size11; $qms_qty[]=0; }
				if($sql_row['order_s_s12']>0) { $qms_size[]='s12'; $qms_sizes[]=$size12; $qms_qty[]=0; }
				if($sql_row['order_s_s13']>0) { $qms_size[]='s13'; $qms_sizes[]=$size13; $qms_qty[]=0; }
				if($sql_row['order_s_s14']>0) { $qms_size[]='s14'; $qms_sizes[]=$size14; $qms_qty[]=0; }
				if($sql_row['order_s_s15']>0) { $qms_size[]='s15'; $qms_sizes[]=$size15; $qms_qty[]=0; }
				if($sql_row['order_s_s16']>0) { $qms_size[]='s16'; $qms_sizes[]=$size16; $qms_qty[]=0; }
				if($sql_row['order_s_s17']>0) { $qms_size[]='s17'; $qms_sizes[]=$size17; $qms_qty[]=0; }
				if($sql_row['order_s_s18']>0) { $qms_size[]='s18'; $qms_sizes[]=$size18; $qms_qty[]=0; }
				if($sql_row['order_s_s19']>0) { $qms_size[]='s19'; $qms_sizes[]=$size19; $qms_qty[]=0; }
				if($sql_row['order_s_s20']>0) { $qms_size[]='s20'; $qms_sizes[]=$size20; $qms_qty[]=0; }
				if($sql_row['order_s_s21']>0) { $qms_size[]='s21'; $qms_sizes[]=$size21; $qms_qty[]=0; }
				if($sql_row['order_s_s22']>0) { $qms_size[]='s22'; $qms_sizes[]=$size22; $qms_qty[]=0; }
				if($sql_row['order_s_s23']>0) { $qms_size[]='s23'; $qms_sizes[]=$size23; $qms_qty[]=0; }
				if($sql_row['order_s_s24']>0) { $qms_size[]='s24'; $qms_sizes[]=$size24; $qms_qty[]=0; }
				if($sql_row['order_s_s25']>0) { $qms_size[]='s25'; $qms_sizes[]=$size25; $qms_qty[]=0; }
				if($sql_row['order_s_s26']>0) { $qms_size[]='s26'; $qms_sizes[]=$size26; $qms_qty[]=0; }
				if($sql_row['order_s_s27']>0) { $qms_size[]='s27'; $qms_sizes[]=$size27; $qms_qty[]=0; }
				if($sql_row['order_s_s28']>0) { $qms_size[]='s28'; $qms_sizes[]=$size28; $qms_qty[]=0; }
				if($sql_row['order_s_s29']>0) { $qms_size[]='s29'; $qms_sizes[]=$size29; $qms_qty[]=0; }
				if($sql_row['order_s_s30']>0) { $qms_size[]='s30'; $qms_sizes[]=$size30; $qms_qty[]=0; }
				if($sql_row['order_s_s31']>0) { $qms_size[]='s31'; $qms_sizes[]=$size31; $qms_qty[]=0; }
				if($sql_row['order_s_s32']>0) { $qms_size[]='s32'; $qms_sizes[]=$size32; $qms_qty[]=0; }
				if($sql_row['order_s_s33']>0) { $qms_size[]='s33'; $qms_sizes[]=$size33; $qms_qty[]=0; }
				if($sql_row['order_s_s34']>0) { $qms_size[]='s34'; $qms_sizes[]=$size34; $qms_qty[]=0; }
				if($sql_row['order_s_s35']>0) { $qms_size[]='s35'; $qms_sizes[]=$size35; $qms_qty[]=0; }
				if($sql_row['order_s_s36']>0) { $qms_size[]='s36'; $qms_sizes[]=$size36; $qms_qty[]=0; }
				if($sql_row['order_s_s37']>0) { $qms_size[]='s37'; $qms_sizes[]=$size37; $qms_qty[]=0; }
				if($sql_row['order_s_s38']>0) { $qms_size[]='s38'; $qms_sizes[]=$size38; $qms_qty[]=0; }
				if($sql_row['order_s_s39']>0) { $qms_size[]='s39'; $qms_sizes[]=$size39; $qms_qty[]=0; }
				if($sql_row['order_s_s40']>0) { $qms_size[]='s40'; $qms_sizes[]=$size40; $qms_qty[]=0; }
				if($sql_row['order_s_s41']>0) { $qms_size[]='s41'; $qms_sizes[]=$size41; $qms_qty[]=0; }
				if($sql_row['order_s_s42']>0) { $qms_size[]='s42'; $qms_sizes[]=$size42; $qms_qty[]=0; }
				if($sql_row['order_s_s43']>0) { $qms_size[]='s43'; $qms_sizes[]=$size43; $qms_qty[]=0; }
				if($sql_row['order_s_s44']>0) { $qms_size[]='s44'; $qms_sizes[]=$size44; $qms_qty[]=0; }
				if($sql_row['order_s_s45']>0) { $qms_size[]='s45'; $qms_sizes[]=$size45; $qms_qty[]=0; }
				if($sql_row['order_s_s46']>0) { $qms_size[]='s46'; $qms_sizes[]=$size46; $qms_qty[]=0; }
				if($sql_row['order_s_s47']>0) { $qms_size[]='s47'; $qms_sizes[]=$size47; $qms_qty[]=0; }
				if($sql_row['order_s_s48']>0) { $qms_size[]='s48'; $qms_sizes[]=$size48; $qms_qty[]=0; }
				if($sql_row['order_s_s49']>0) { $qms_size[]='s49'; $qms_sizes[]=$size49; $qms_qty[]=0; }
				if($sql_row['order_s_s50']>0) { $qms_size[]='s50'; $qms_sizes[]=$size50; $qms_qty[]=0; }

		
			}
		}
	}
	//echo "<br>".sizeof($qms_size)."-".$bal;
	$x1=0;
	$i=1;
	// var_dump($qms_qty);
	if(sizeof($qms_size)>0)
	{
		$table="<table class='table table-bordered'><tr><th>Docket</th><th>Size</th><th>Recut Quantity</th></tr>";
		for($i=0;$i<sizeof($qms_size);$i++)
		{
			$table.= "<tr><input type='hidden' name='doc_no[]' value=".$qms_doc[$i].">
			<input type='hidden' name='ops_code[]' value=".$qms_ops[$i]."><input type='hidden' name='old_size[]' value=".$qms_size[$i]."><td>".$qms_doc[$i]."</td><td><input type=\"hidden\" name=\"size[]\" value=\"p_".$qms_size[$i]."\">".$qms_sizes[$i]."</td>";
			
			if($open_access==$chk || $module=="TOP" )
			{
				$validate_1="onchange=\"check2(this.value,".$qms_qty[$i].")\"";
			}
			else
			{
				$validate_1="onchange=\"if(check1(this.value,".$qms_qty[$i].")==1010) { this.value=".$qms_qty[$i]."; }\"";
			}
			$table.= "<td style 'text-align:center'><div class='row'><div class='col-md-3'><input type=\"text\" class='form-control' name=\"qty[p_$qms_size[$i]][]\" id='qty_$i' value =\"".$qms_qty[$i]."\" size=\"5\" onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value=0;}\" autocomplete=\"off\" onkeypress=\"return isNum(event)\" $validate_1></div></td></tr>";
			$x1 = $x1+1;
		}
		$table.="</table><div id=\"button1\">
		<input type='hidden' id='count' value='$x1'>
		<span id=\"msg\" style=\"display:none;\">Please Wait...</span>
		<div class='col-md-2'><br/>
		<input type=\"submit\" value=\"Create Request\" class='btn btn-success' name=\"request\" id=\"request\" onsubmit=\"document.getElementById('request').style.display='none'; document.getElementById('msg').style.display='';\" onclick ='return check_reasons($y)'>
		<br/></br></div><br/></div>";
		//echo $table;
	}
	echo "<div style='overflow:auto;max-height:800px;'>
	<table class='table table-bordered table-striped'>
	<tr>
	<td>Style</td>
	<td style='text-align:center;'>:</td>
	<td>$style</td>
	</tr>
	
	<tr>
	<td>Schedule</td>
	<td style='text-align:center;'>:</td>
	<td>$schedule</td>
	</tr>
	
	<tr>
	<td>Color</td>
	<td style='text-align:center;'>:</td>
	<td>$color</td>
	</tr>
	
	<tr>
	<td>Module</td>
	<td style='text-align:center;'>:</td>
	<td>$module</td>
	</tr>
	
	<tr>
	<td>Category</td>
	<td style='text-align:center;'>:</td>
	<td>$categories</td>
	</tr>
	
	<tr>
	<td>NRP</td>
	<td style='text-align:center;'>:</td>
	<td>$table</td>
	</tr>

	</table></div>";
}
?>
</form>
</div>
</div>
</body>
<style>
table {
	color:black;
}
th{
	bacground:color:#286090;
	color:white;
	text-weight:bold;
	text-align:center;
}
td{
	text-align:center;
}
</style>
<script>
	function check_reasons(cat_count){
		var count = document.getElementById('count').value;
		var total = 0;
		var val;
		for(var i = 0;i<parseInt(count);i++){
			val = parseFloat(document.getElementById('qty_'+i).value);
			if(val == " "){
				val = 0;
			}else{
				val = val;
			}
			total+= val;
		}
		var check_val = [];
		// alert(total);
		if(total == 0){
			sweetAlert('NRP should be greater than ZERO','','warning');
			return false;
		}else{
			for(var j =0; j<Number(cat_count);j++){
				var chk = document.getElementById('cat_'+j);
				if(chk.checked){
					check_val[j] = document.getElementById('cat_'+j).checked;
				}
			}
			if(check_val.length == 0){
				sweetAlert('Please Select atleast one category','','warning');
				return false;			
			}
		}
		return true;
	}
</script>
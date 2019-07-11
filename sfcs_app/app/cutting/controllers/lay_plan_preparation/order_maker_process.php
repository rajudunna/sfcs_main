
<!--
Change Log:
1. CR: 193 / kirang / 2014-2-19 :  Add the validation for User Style ID. if User Style ID was not available for that schedule, then CAD team need to check with the Planning Team.
2. Service Request #716897/ kirang / 2015-5-16:  Add the User Style ID and Packing Method validations at Cut Plan generation 
-->

<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>

<?php
$log_date=date("Y-m-d"); 
$log_time=date("Y-m-d H:i:s");

if(isset($_POST['update']))
{

	$cat_ref=$_POST['cat_ref'];
	$tran_order_tid=$_POST['tran_order_tid'];
	$cuttable_ref=$_POST['cuttable_ref'];
	$allocate_ref=$_POST['allocate_ref'];

		$tran_order_tid=$_POST['tran_order_tid'];
		$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
		// echo "<br/>Sql=".$sql;
		// die();
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$color=$sql_row['order_col_des'];
			$style=$sql_row['order_style_no'];
			$schedule=$sql_row['order_del_no'];
			$style_code=$sql_row['style_id'];
			$pack_method=$sql_row['packing_method'];
			$buyer_code=substr($style,0,1);
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
			$title_flag = $sql_row['title_flag'];
		}
		if($style_code=="")
		{
				echo "<script type=\"text/javascript\"> 
						sweetAlert('Error','User Style ID was not available for this schedule, Please check with the Planning Team.','error');
						setTimeout(\"Redirect()\",2000); 
						function Redirect() {  
							location.href = \"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=$color&style=$style&schedule=$schedule\"; 
						}
					</script>";
		}
		else if($pack_method=="")
		{
				echo "<script type=\"text/javascript\"> 
						sweetAlert('Error','Packing Method was not available for this schedule, Please update the Shipment Plan for this schedule.','error');
						setTimeout(\"Redirect()\",2000); function Redirect() {  
							location.href = \"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=$color&style=$style&schedule=$schedule\"; 
						}
					</script>";
		}
		else
		{
		$cat_ref=$_POST['cat_ref'];
		$tran_order_tid=$_POST['tran_order_tid'];
		$cuttable_ref=$_POST['cuttable_ref'];
		$allocate_ref=$_POST['allocate_ref'];
		$remarks=$_POST['remarks'];
		$in_mklength=$_POST['in_mklength']; //
		$in_mkeff=$_POST['in_mkeff'];
		$in_mkver=$_POST['in_mkver'];
		$in_pwidth=$_POST['in_pwidth']; //
		$remarks1=$_POST['remark1'];
		$remarks2=$_POST['remark2'];
		$remarks3=$_POST['remark3'];
		$remarks4=$_POST['remark4'];
		if($in_mkeff == '')
		{
		    $in_mkeff = 0;
		}
		
		if(strlen(trim($in_mkver))>=1) //System will not update, if no data is not available
		{

				$sql="insert ignore into $bai_pro3.maker_stat_log (date, cat_ref, cuttable_ref, allocate_ref, order_tid, mklength, mkeff, remarks, mk_ver, lastup,remark1,remark2,remark3,remark4) values(\"$log_date\",$cat_ref, $cuttable_ref, $allocate_ref, \"$tran_order_tid\", ".$in_mklength[0].", $in_mkeff, \"$remarks\", \"$in_mkver\",\"$log_time\",\"$remarks1\",\"$remarks2\",\"$remarks3\",\"$remarks4\")";
			
			//echo $sql;
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$iLastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
				
				$sql="update $bai_pro3.allocate_stat_log set mk_status=2 where tid=$allocate_ref";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				
				$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\"";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$color=$sql_row['order_col_des'];
					$style=$sql_row['order_style_no'];
					$schedule=$sql_row['order_del_no'];
					$style_code=$sql_row['style_id'];
					$buyer_code=substr($style,0,1);
				}
				
				$allo_c=array();
				$sql="select * from $bai_pro3.allocate_stat_log where tid=$allocate_ref";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$allo_c[]="xs=".$sql_row['allocate_xs'];
					$allo_c[]="s=".$sql_row['allocate_s'];
					$allo_c[]="m=".$sql_row['allocate_m'];
					$allo_c[]="l=".$sql_row['allocate_l'];
					$allo_c[]="xl=".$sql_row['allocate_xl'];
					$allo_c[]="xxl=".$sql_row['allocate_xxl'];
					$allo_c[]="xxxl=".$sql_row['allocate_xxxl'];
					$allo_c[]="s01=".$sql_row['allocate_s01'];
					$allo_c[]="s02=".$sql_row['allocate_s02'];
					$allo_c[]="s03=".$sql_row['allocate_s03'];
					$allo_c[]="s04=".$sql_row['allocate_s04'];
					$allo_c[]="s05=".$sql_row['allocate_s05'];
					$allo_c[]="s06=".$sql_row['allocate_s06'];
					$allo_c[]="s07=".$sql_row['allocate_s07'];
					$allo_c[]="s08=".$sql_row['allocate_s08'];
					$allo_c[]="s09=".$sql_row['allocate_s09'];
					$allo_c[]="s10=".$sql_row['allocate_s10'];
					$allo_c[]="s11=".$sql_row['allocate_s11'];
					$allo_c[]="s12=".$sql_row['allocate_s12'];
					$allo_c[]="s13=".$sql_row['allocate_s13'];
					$allo_c[]="s14=".$sql_row['allocate_s14'];
					$allo_c[]="s15=".$sql_row['allocate_s15'];
					$allo_c[]="s16=".$sql_row['allocate_s16'];
					$allo_c[]="s17=".$sql_row['allocate_s17'];
					$allo_c[]="s18=".$sql_row['allocate_s18'];
					$allo_c[]="s19=".$sql_row['allocate_s19'];
					$allo_c[]="s20=".$sql_row['allocate_s20'];
					$allo_c[]="s21=".$sql_row['allocate_s21'];
					$allo_c[]="s22=".$sql_row['allocate_s22'];
					$allo_c[]="s23=".$sql_row['allocate_s23'];
					$allo_c[]="s24=".$sql_row['allocate_s24'];
					$allo_c[]="s25=".$sql_row['allocate_s25'];
					$allo_c[]="s26=".$sql_row['allocate_s26'];
					$allo_c[]="s27=".$sql_row['allocate_s27'];
					$allo_c[]="s28=".$sql_row['allocate_s28'];
					$allo_c[]="s29=".$sql_row['allocate_s29'];
					$allo_c[]="s30=".$sql_row['allocate_s30'];
					$allo_c[]="s31=".$sql_row['allocate_s31'];
					$allo_c[]="s32=".$sql_row['allocate_s32'];
					$allo_c[]="s33=".$sql_row['allocate_s33'];
					$allo_c[]="s34=".$sql_row['allocate_s34'];
					$allo_c[]="s35=".$sql_row['allocate_s35'];
					$allo_c[]="s36=".$sql_row['allocate_s36'];
					$allo_c[]="s37=".$sql_row['allocate_s37'];
					$allo_c[]="s38=".$sql_row['allocate_s38'];
					$allo_c[]="s39=".$sql_row['allocate_s39'];
					$allo_c[]="s40=".$sql_row['allocate_s40'];
					$allo_c[]="s41=".$sql_row['allocate_s41'];
					$allo_c[]="s42=".$sql_row['allocate_s42'];
					$allo_c[]="s43=".$sql_row['allocate_s43'];
					$allo_c[]="s44=".$sql_row['allocate_s44'];
					$allo_c[]="s45=".$sql_row['allocate_s45'];
					$allo_c[]="s46=".$sql_row['allocate_s46'];
					$allo_c[]="s47=".$sql_row['allocate_s47'];
					$allo_c[]="s48=".$sql_row['allocate_s48'];
					$allo_c[]="s49=".$sql_row['allocate_s49'];
					$allo_c[]="s50=".$sql_row['allocate_s50'];
				}
				for($i=0;$i<sizeof($in_mklength);$i++)
				{
					if(strlen($in_pwidth[$i])>0 and $in_pwidth[$i]!="")
					{
						$sql="insert ignore into $bai_pro3.marker_ref_matrix(marker_ref_tid) values ('".$iLastid."-".$in_pwidth[$i]."')";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						//echo "<br/>".$sql;
						$sql="update $bai_pro3.marker_ref_matrix set marker_ref='$iLastid', marker_width='".$in_pwidth[$i]."', marker_length='".$in_mklength[$i]."',cat_ref=$cat_ref,allocate_ref=$allocate_ref,pat_ver='$in_mkver',style_code='$style_code',buyer_code='$buyer_code',title_size_s01=\"$size01\" , title_size_s02=\"$size02\" , title_size_s03=\"$size03\" , title_size_s04=\"$size04\" , title_size_s05=\"$size05\" , title_size_s06=\"$size06\" , title_size_s07=\"$size07\" , title_size_s08=\"$size08\" , title_size_s09=\"$size09\" , title_size_s10=\"$size10\" , title_size_s11=\"$size11\" , title_size_s12=\"$size12\" , title_size_s13=\"$size13\" , title_size_s14=\"$size14\" , title_size_s15=\"$size15\" , title_size_s16=\"$size16\" , title_size_s17=\"$size17\" , title_size_s18=\"$size18\" , title_size_s19=\"$size19\" , title_size_s20=\"$size20\" , title_size_s21=\"$size21\" , title_size_s22=\"$size22\" , title_size_s23=\"$size23\" , title_size_s24=\"$size24\" , title_size_s25=\"$size25\" , title_size_s26=\"$size26\" , title_size_s27=\"$size27\" , title_size_s28=\"$size28\" , title_size_s29=\"$size29\" , title_size_s30=\"$size30\" , title_size_s31=\"$size31\" , title_size_s32=\"$size32\" , title_size_s33=\"$size33\" , title_size_s34=\"$size34\" , title_size_s35=\"$size35\" , title_size_s36=\"$size36\" , title_size_s37=\"$size37\" , title_size_s38=\"$size38\" , title_size_s39=\"$size39\" , title_size_s40=\"$size40\" , title_size_s41=\"$size41\" , title_size_s42=\"$size42\" , title_size_s43=\"$size43\" , title_size_s44=\"$size44\" , title_size_s45=\"$size45\" , title_size_s46=\"$size46\" , title_size_s47=\"$size47\" , title_size_s48=\"$size48\" , title_size_s49=\"$size49\" , title_size_s50=\"$size50\",title_flag=\"$title_flag\", ".implode(",",$allo_c)." where marker_ref_tid='".$iLastid."-".$in_pwidth[$i]."'";
						//echo "<br/>".$sql;
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {   sweetAlert('Successfully Updated','','success'); location.href = \"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=$color&style=$style&schedule=$schedule\"; }</script>";
		}else{
			//echo "<h2 class='label label-danger'>Marker Version is not available.</h2>";
			echo "<script type='text/javascript'>
					sweetAlert('Error','Marker Version is not available.','error');
					setTimeout('Redirect()',2000);
					function Redirect(){
							location.href='".getFullURL($_GET['r'], "order_makers_form2.php", "N")."&tran_order_tid=$tran_order_tid&cat_ref=$cat_ref&cuttable_ref=$cuttable_ref&allocate_ref=$allocate_ref';
					}                                     
					</script>";	
		}
	}
}

?>

<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
error_reporting(0);

if(isset($_POST))
{
	
	$reason_array=array("HIGH PTS","FALL OUT","SKEW/BOWING","WIRC SHADING","GSM","OTHERS","OFF SHADE","HAND FEEL","LENGTH","WIDTH","Test Report");

	$bai1_rec=array_column($_POST['dataset'], 'bai1_rec');
	$weekno=array_column($_POST['dataset'], 'weekno');
	$pkg_no=array_column($_POST['dataset'], 'pkg_no');
	$invoice=array_column($_POST['dataset'], 'invoice');
	$srdfs=array_column($_POST['dataset'], 'srdfs');
	$srtfs=array_column($_POST['dataset'], 'srtfs');
	$srdfsw=array_column($_POST['dataset'], 'srdfsw');
	$insp_date=array_column($_POST['dataset'], 'insp_date');
	$reldat=array_column($_POST['dataset'], 'reldat');
	$unique_id=array_column($_POST['dataset'], 'unique_id');
	$grn_date=array_column($_POST['dataset'], 'grn_date');
	$entdate=array_column($_POST['dataset'], 'entdate');
	$buyer=array_column($_POST['dataset'], 'buyer');
	$item=array_column($_POST['dataset'], 'item');
	$lots_ref=array_column($_POST['dataset'], 'lots_ref');
	$po_ref=array_column($_POST['dataset'], 'po_ref');
	$supplier_name=array_column($_POST['dataset'], 'supplier_name');
	$quality=array_column($_POST['dataset'], 'quality');
	$rms=array_column($_POST['dataset'], 'rms');
	$const=array_column($_POST['dataset'], 'const');
	$compo=array_column($_POST['dataset'], 'compo');
	$color_ref=array_column($_POST['dataset'], 'color_ref');
	$syp=array_column($_POST['dataset'], 'syp');
	$batch_ref=array_column($_POST['dataset'], 'batch_ref');
	$rolls_count=array_column($_POST['dataset'], 'rolls_count');
	$tktlen=array_column($_POST['dataset'], 'tktlen');
	$ctexlen=array_column($_POST['dataset'], 'ctexlen');
	$lenper=array_column($_POST['dataset'], 'lenper');
	$qty_insp=array_column($_POST['dataset'], 'qty_insp');
	$qty_insp_act=array_column($_POST['dataset'], 'qty_insp_act');
	$inches=array_column($_POST['dataset'], 'inches');
	$pur_width_ref=array_column($_POST['dataset'], 'pur_width_ref');
	$act_width_ref=array_column($_POST['dataset'], 'act_width_ref');
	$pur_gsm=array_column($_POST['dataset'], 'pur_gsm');
	$act_gsm=array_column($_POST['dataset'], 'act_gsm');
	$consumption=array_column($_POST['dataset'], 'consumption');
	$pts=array_column($_POST['dataset'], 'pts');
	$fallout=array_column($_POST['dataset'], 'fallout');
	$defects=array_column($_POST['dataset'], 'defects');
	$skew_cat_ref=array_column($_POST['dataset'], 'skew_cat_ref');
	$skew=array_column($_POST['dataset'], 'skew');
	$shrink_l=array_column($_POST['dataset'], 'shrink_l');
	$shrink_w=array_column($_POST['dataset'], 'shrink_w');
	$sup_test_rep=array_column($_POST['dataset'], 'sup_test_rep');
	$inspec_per_rep=array_column($_POST['dataset'], 'inspec_per_rep');
	$cc_rep=array_column($_POST['dataset'], 'cc_rep');
	$com_ref1=array_column($_POST['dataset'], 'com_ref1');
	$reason_qty=array_column($_POST['dataset'], 'reason_qty');
	$reason_name=array_column($_POST['dataset'], 'reason_name');
	$reason_ref_explode_ex=array_column($_POST['dataset'], 'reason_ref_explode_ex');
	$status=array_column($_POST['dataset'], 'status');
	$status_f=array_column($_POST['dataset'], 'status_f');
	$impact=array_column($_POST['dataset'], 'impact');
	$month_ref=array_column($_POST['dataset'], 'month_ref');
	$fab_tech=array_column($_POST['dataset'], 'fab_tech');
	$host_name=str_replace(".brandixlk.org","",gethostbyaddr($_SERVER['REMOTE_ADDR']));

	
	$updated_rows=0;
	// var_dump($reason_name);
	// die();

	for($i=0;$i<sizeof($reason_name);$i++)
	{
		$count=sizeof($reason_name);
		$string_include1="";
		$string_include2="";
		
		for($i1=0;$i1<2;$i1++)
	    {
			$string_include1.="'".$reason_name[$i][0][$i1]."','".$reason_ref_explode_ex[$i][0][$i1]."',";
		}
		
		for($i2=0;$i2<11;$i2++)
	    {
			$string_include2.="'".$status[$i][0][$i2]."',";
		}
		
		$sql11="select * from $bai_rm_pj1.supplier_performance_track where tid='".trim($batch_ref[$i])."-".$month_ref[$i]."'";
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error4".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo $sql11;
		if(mysqli_num_rows($sql_result11) > 0)
		{
			while($row11=mysqli_fetch_array($sql_result11))
			{
				$log_time_ref_v1=$row11["log_time"];
			}
		}
		else
		{
			$log_time_ref_v1="0000-00-00 00:00:00";
		}
		
		//echo "Lengths=".strlen($srdfs[$i])."<br>".strlen($srtfs[$i])."<br>".strlen($srdfsw[$i])."<br>".strlen($reldat[$i])." <br> ".strlen($quality[$i])."<br>".strlen($rms[$i]) ."<br>".strlen($const[$i]) ." <br> ".strlen($syp[$i])."<br>".strlen($qty_insp_act[$i])."<br>".strlen($defects[$i])."<br>".strlen($skew_cat_ref[$i]) ."<br>".strlen($sup_test_rep[$i])."<br>".strlen($inspec_per_rep[$i])."<br>".strlen($cc_rep[$i])."<br>".strlen($fab_tech[$i]);
		
		$reported_date=date("Y-m-d H:i:s");
		if(strlen($srdfs[$i]) > 0 && strlen($srtfs[$i]) > 0 && strlen($srdfsw[$i]) > 0 && strlen($reldat[$i]) > 0 && strlen($quality[$i]) > 0 && strlen($rms[$i]) > 0 && strlen($const[$i]) > 0 && strlen($syp[$i]) > 0 && strlen($qty_insp_act[$i]) > 0 && strlen($defects[$i]) > 0 && strlen($skew_cat_ref[$i]) > 0 && strlen($sup_test_rep[$i]) > 0 && strlen($inspec_per_rep[$i]) > 0 && strlen($cc_rep[$i]) > 0 && strlen($fab_tech[$i]) > 0)
		{
			$reported_date=date("Y-m-d H:i:s");
			if($log_time_ref_v1!="0000-00-00 00:00:00")
			{
				$reported_date=$log_time_ref_v1;
			}
		}
		else
		{
			$reported_date="0000-00-00 00:00:00";
		}
	
		$sql="insert into $bai_rm_pj1.supplier_performance_track(tid,bai1_rec,weekno,pkg_no,invoice,srdfs,srtfs,srdfsw,insp_date,reldat,unique_id,grn_date,entdate,buyer,item, lots_ref,po_ref,	supplier_name,quality,rms,const,compo,color_ref,syp,batch_ref,rolls_count,tktlen,ctexlen,lenper,qty_insp,qty_insp_act, inches,pur_width_ref,act_width_ref,pur_gsm,act_gsm,consumption,pts,fallout,defects,skew_cat_ref,skew,shrink_l,shrink_w,sup_test_rep,inspec_per_rep,cc_rep, com_ref1,reason_qty,reason_name,reason_ref_explode_ex,reason_name1,reason_ref_explode_ex1,  fab_tech,high_pts,fall_out,skew_bowing,wirc_shading,gsm,others,off_shade,hand_feel,length,width,test_report,status_f,impact,log_time) values('".trim($batch_ref[$i])."-".$month_ref[$i]."','".$bai1_rec[$i]."','".$weekno[$i]."','".$pkg_no[$i]."','".$invoice[$i]."','".$srdfs[$i]."','".$srtfs[$i]."','".$srdfsw[$i]."','".$insp_date[$i]."','".$reldat[$i]."','".$unique_id[$i]."','".$grn_date[$i]."','".$entdate[$i]."','".$buyer[$i]."','".$item[$i]."','".$lots_ref[$i]."','".$po_ref[$i]."','".$supplier_name[$i]."','".$quality[$i]."','".$rms[$i]."','".$const[$i]."','".$compo[$i]."','".$color_ref[$i]."','".$syp[$i]."','".$batch_ref[$i]."','".$rolls_count[$i]."','".$tktlen[$i]."','".$ctexlen[$i]."','".$lenper[$i]."','".$qty_insp[$i]."','".$qty_insp_act[$i]."','".$inches[$i]."','".$pur_width_ref[$i]."','".$act_width_ref[$i]."','".$pur_gsm[$i]."','".$act_gsm[$i]."','".$consumption[$i]."','".$pts[$i]."','".$fallout[$i]."','".$defects[$i]."','".$skew_cat_ref[$i]."','".$skew[$i]."','".$shrink_l[$i]."','".$shrink_w[$i]."','".$sup_test_rep[$i]."','".$inspec_per_rep[$i]."','".$cc_rep[$i]."','".$com_ref1[$i]."','".$reason_qty[$i]."',".$string_include1."'".$fab_tech[$i]."',".$string_include2."'".$status_f[$i]."','".$impact[$i]."','".$reported_date."')";	
		//echo $sql."<br>";
		$sql1s="insert into $bai_rm_pj1.supplier_performance_track_log(tid,bai1_rec,weekno,pkg_no,invoice,srdfs,srtfs,srdfsw,insp_date,reldat,unique_id,grn_date,entdate,buyer, item,lots_ref,po_ref,supplier_name,quality,rms,const,compo,color_ref,syp,batch_ref,rolls_count,tktlen,ctexlen,lenper,qty_insp,qty_insp_act,inches, pur_width_ref,act_width_ref,pur_gsm,act_gsm,consumption,pts,fallout,defects,skew_cat_ref,skew,shrink_l,shrink_w,sup_test_rep,inspec_per_rep,cc_rep, com_ref1, reason_qty,reason_name,reason_ref_explode_ex,reason_name1,reason_ref_explode_ex1,fab_tech, high_pts, fall_out, skew_bowing, wirc_shading,gsm,others, off_shade,hand_feel,length,width,test_report,status_f,impact,host_name,user_name,log_time) values('".trim($batch_ref[$i])."-".$month_ref[$i]."','".$bai1_rec[$i]."','".$weekno[$i]."','".$pkg_no[$i]."','".$invoice[$i]."','".$srdfs[$i]."','".$srtfs[$i]."','".$srdfsw[$i]."','".$insp_date[$i]."','".$reldat[$i]."','".$unique_id[$i]."','".$grn_date[$i]."','".$entdate[$i]."','".$buyer[$i]."','".$item[$i]."','".$lots_ref[$i]."','".$po_ref[$i]."','".$supplier_name[$i]."','".$quality[$i]."','".$rms[$i]."','".$const[$i]."','".$compo[$i]."','".$color_ref[$i]."','".$syp[$i]."','".$batch_ref[$i]."','".$rolls_count[$i]."','".$tktlen[$i]."','".$ctexlen[$i]."','".$lenper[$i]."','".$qty_insp[$i]."','".$qty_insp_act[$i]."','".$inches[$i]."','".$pur_width_ref[$i]."','".$act_width_ref[$i]."','".$pur_gsm[$i]."','".$act_gsm[$i]."','".$consumption[$i]."','".$pts[$i]."','".$fallout[$i]."','".$defects[$i]."','".$skew_cat_ref[$i]."','".$skew[$i]."','".$shrink_l[$i]."','".$shrink_w[$i]."','".$sup_test_rep[$i]."','".$inspec_per_rep[$i]."','".$cc_rep[$i]."','".$com_ref1[$i]."','".$reason_qty[$i]."',".$string_include1."'".$fab_tech[$i]."',".$string_include2."'".$status_f[$i]."','".$impact[$i]."','".$host_name."','".$username."','".date("Y-m-d H:i:s")."')";	
		$sql_rest_log = mysqli_query($link, $sql1s) or exit("Sql Error4s".$sql1s.mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo $sql1s."<br>";
		if($sql_rest_log>0)
		{
				$count_update=$updated_rows++;
		}
		$sql1="select * from $bai_rm_pj1.supplier_performance_track where tid='".trim($batch_ref[$i])."-".$month_ref[$i]."'";
		//echo $sql1."<br>";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error4".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
		
		if(mysqli_num_rows($sql_result1) >0)
		{
			$sql2="delete from $bai_rm_pj1.supplier_performance_track where tid='".trim($batch_ref[$i])."-".$month_ref[$i]."'";
			// echo $sql2;
			mysqli_query($link, $sql2) or exit("Sql Error1".$sql2.mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result5=mysqli_query($link, $sql);
		}
		else
		{
			$sql_result5=mysqli_query($link, $sql) ;
			if($sql_result5>0){
			}
		}
		if($sql_result5>0)
		{
			if(strlen($srdfs[$i]) > 0 && strlen($srtfs[$i]) > 0 && strlen($srdfsw[$i]) > 0 && strlen($reldat[$i]) > 0 && strlen($quality[$i]) > 0 && strlen($rms[$i]) > 0 && strlen($const[$i]) > 0 && strlen($syp[$i]) > 0 && strlen($qty_insp_act[$i]) > 0 && strlen($defects[$i]) > 0 && strlen($skew_cat_ref[$i]) > 0 && strlen($sup_test_rep[$i]) > 0 && strlen($inspec_per_rep[$i]) > 0 && strlen($cc_rep[$i]) > 0 && strlen($fab_tech[$i]) > 0)
			{
				$alert_check="updated";
				// $count_update=$updated_rows++;
			}
		// $total_rows_updated=$updated_rows;
	
		}
	}
	echo $count_update+1;
	//  echo "<script>sweetAlert('\"$total_rows_updated\" Records Updated Successfully','','success');</script>";
	// 	  echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"".getFullURLLevel($_GET['r'],"reports/supplier_perf_v2_report.php",1, "N")."\"; }</script>";

}

?>

<?php
ini_set('max_execution_time', 5000);
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 

if(isset($_POST['update']))
{

	$reason_array=array("HIGH PTS","FALL OUT","SKEW/BOWING","WIRC SHADING","GSM","OTHERS","OFF SHADE","HAND FEEL","LENGTH","WIDTH","Test Report");

	$bai1_rec=$_POST["bai1_rec"];
	$weekno=$_POST["weekno"];
	$pkg_no=$_POST["pkg_no"];
	//echo $pkg_no;
	
	$invoice=$_POST["invoice"];
	$srdfs=$_POST["srdfs"];
	$srtfs=$_POST["srtfs"];
	$srdfsw=$_POST["srdfsw"];
	$insp_date=$_POST["insp_date"];
	$reldat=$_POST["reldat"];
	$unique_id=$_POST["unique_id"];
	$grn_date=$_POST["grn_date"];
	$entdate=$_POST["entdate"];
	$buyer=$_POST["buyer"];
	$item=$_POST["item"];
	$lots_ref=$_POST["lots_ref"];
	$po_ref=$_POST["po_ref"];
	$supplier_name=$_POST["supplier_name"];
	$quality=$_POST["quality"];
	$rms=$_POST["rms"];
	$const=$_POST["const"];
	$compo=$_POST["compo"];
	//echo $compo."<br>";
	$color_ref=$_POST["color_ref"];
	$syp=$_POST["syp"];
	$batch_ref=$_POST["batch_ref"];
	$rolls_count=$_POST["rolls_count"];
	$tktlen=$_POST["tktlen"];
	$ctexlen=$_POST["ctexlen"];
	$lenper=$_POST["lenper"];
	$qty_insp=$_POST["qty_insp"];
	$qty_insp_act=$_POST["qty_insp_act"];
	//$len_qty=$_POST["len_qty"];
	$inches=$_POST["inches"];
	$pur_width_ref=$_POST["pur_width_ref"];
	$act_width_ref=$_POST["act_width_ref"];
	$pur_gsm=$_POST["pur_gsm"];
	$act_gsm=$_POST["act_gsm"];
	$consumption=$_POST["consumption"];
	$pts=$_POST["pts"];
	$fallout=$_POST["fallout"];
	$defects=$_POST["defects"];
	$skew_cat_ref=$_POST["skew_cat_ref"];
	$skew=$_POST["skew"];
	$shrink_l=$_POST["shrink_l"];
	$shrink_w=$_POST["shrink_w"];
	$sup_test_rep=$_POST["sup_test_rep"];
	$inspec_per_rep=$_POST["inspec_per_rep"];
	$cc_rep=$_POST["cc_rep"];
	$com_ref1=$_POST["com_ref1"];
	$reason_qty=$_POST["reason_qty"];
	$reason_name=$_POST["reason_name"];
	$reason_ref_explode_ex=$_POST["reason_ref_explode_ex"];
	$status=$_POST["status"];
	$status_f=$_POST["status_f"];
	$impact=$_POST["impact"];
	$month_ref=$_POST["month"];
	$fab_tech=$_POST["fab_tech"];
	$host_name=str_replace(".brandixlk.org","",gethostbyaddr($_SERVER['REMOTE_ADDR']));

	for($i=1;$i<=sizeof($reason_name);$i++)
	{
		for($i1=0;$i1<2;$i1++)
	    {
			//echo $i."-".$i1."=".$reason_name[$i][$i1]."-";
			//echo $reason_ref_explode_ex[$i][$i1]."<br>";
		}
	}

	for($i=1;$i<=sizeof($reason_name);$i++)
	{
		//echo $batch_ref[$i]."<br>";
		for($i1=0;$i1<11;$i1++)
	    {
		//echo $i."-".$i1."=".$reason_array[$i1]."-".$status[$i][$i1]."<br>";
		}
	}

	for($i=1;$i<=sizeof($reason_name);$i++)
	{
		$string_include1="";
		$string_include2="";
		
		for($i1=0;$i1<2;$i1++)
	    {
			$string_include1.="'".$reason_name[$i][$i1]."','".$reason_ref_explode_ex[$i][$i1]."',";
		}
		
		for($i2=0;$i2<11;$i2++)
	    {
			$string_include2.="'".$status[$i][$i2]."',";
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
		mysqli_query($link, $sql1s) or exit("Sql Error4s".$sql1s.mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo $sql1s."<br>";

		$sql1="select * from $bai_rm_pj1.supplier_performance_track where tid='".trim($batch_ref[$i])."-".$month_ref[$i]."'";
		// echo $sql1."<br>";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error4".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
		
		if(mysqli_num_rows($sql_result1) > 0)
		{
			
			$sql2="delete from $bai_rm_pj1.supplier_performance_track where tid='".trim($batch_ref[$i])."-".$month_ref[$i]."'";
		
			mysqli_query($link, $sql2) or exit("Sql Error1".$sql2.mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result5=mysqli_query($link, $sql) or exit("Sql Error3".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
			
		
		}
		else
		{
			
			mysqli_query($link, $sql) or exit("Sql Error3".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
			
		}	
	
		 echo "<script>sweetAlert('Success!','Successfully Updated','success');</script>";
		

echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"".getFullURLLevel($_GET['r'],"reports/supplier_perf_v2_report.php",1, "N")."\"; }</script>";	
	}
	

}

?>
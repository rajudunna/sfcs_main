$_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
$view_access=user_acl("SFCS_0299",$username,1,$group_id_sfcs);
$users=user_acl("SFCS_0299",$username,43,$group_id_sfcs);
?>
<?php
if((in_array($username,$users)))
{
	//echo "Names Exit";
}
else
{	
	//header("Location:restrict.php?group_docs=".$_GET['group_docs']);
}


if(isset($_POST['submit'])) 
{ 
	$doc_no=$_POST['doc'];
} 
else
{
	$doc_no=$_GET["doc_no"];
}	
?>
<!--
<style type="text/css" media="screen">
	
	body{ 
	margin:15px; padding:15px; border:0px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:12px; 
	}
	a {
		margin:0px; padding:0px;
	}
	caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
	pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
	.mytable1{
		font-size:12px;
	}
	th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
	td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;}
</style>-->
<script>
function check(x)
{
	//alert(x);
	var org_qty=document.getElementById("org_qty_" + x).value;
	var brk_qty=document.getElementById("brk_qty_" + x).value;
	
	if(parseInt(org_qty) < parseInt(brk_qty))
	{
		// alert(x+"-"+org_qty+"-"+brk_qty);
		alert("You Cannot Split More Than the Original Quantity");
		document.getElementById("brk_qty_" + x).value=0;
	}
}
</script>
<!--<link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',3,'R'); ?>" rel="stylesheet" type="text/css" />-->
<div class="panel panel-primary">
	<div class="panel-heading">Recut Request Breakdown</div>
		<div class="panel-body">
				<form action="index.php?r=<?= $_GET['r']; ?>" method="POST" name="apply">
					<div class="row">
							<div class="col-sm-3">
								<label>Enter Recut No :</label>
								<input type="text" size=6 id="doc" class="form-control" name="doc" value="<?php echo $doc_no; ?>">
							</div></br>
							<div class="col-sm-3">
								<input type="submit" value="submit" name="submit" id="submit" class="btn btn-primary" onclick="document.getElementById('submit').style.display='none'; document.getElementById('msg1').style.display='';">
							</div>
							<span id="msg1\" style="display:none;"><h5>Please Wait...!<h5></span>
					</div>	
				</form>
		
<?php

if(isset($_POST["submit"]))
{
	$doc_no=$_POST["doc"];
	$sql1="select order_tid,mk_ref,remarks from $bai_pro3.recut_v2 where doc_no=\"".$doc_no."\"";
	$i=0;
	$sql_result1=mysqli_query($link,$sql1) or exit("Sql Error21".mysql_error());
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$order_tid=$sql_row1["order_tid"];
		$mk_ref=$sql_row1["mk_ref"];
		$remarks_cat=$sql_row1["remarks"];
	}
	if($remarks_cat=='Body' || $remarks_cat=='Front')
	{
		if($mk_ref==0)
		{
	//	$sizes_array=array("s06","s08","s10","s12","s14","s16","s18","s20","s22","s24","s26","s28","s30"); 
		$size_ref="";	
		$rurl = "index.php?r=".$_GET['r'];
		
		echo "<hr><br><form action=\"$rurl\" method=\"POST\" name=\"recut\">";
		echo "<input type=\"hidden\" id=\"doc_no\" name=\"doc_no\" value=".$doc_no.">";
		echo "<table class=\"table table-bordered\" cellpadding=0 cellspacing=0>";
		echo "<tr><th>Size</th><th>Qty</th><th>Split Qty</th></tr>";
		$x1=0;
		for($i1=0;$i1<sizeof($sizes_array);$i1++)
		{
			
			$sql1="select sum(a_".$sizes_array[$i1].") as qty from $bai_pro3.recut_v2 where doc_no=\"".$doc_no."\"";
			//echo $sql1."<br>";
			$sql_result1=mysqli_query($link,$sql1) or exit("Sql Error21".mysql_error());
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$orginal_qty=$sql_row1["qty"];
			}
			
			$sql11="select sum(a_".$sizes_array[$i1].") as qty from $bai_pro3.recut_v2 where pcutdocid=\"".$doc_no."\"";
			//echo $sql1."<br>";
			$sql_result11=mysqli_query($link,$sql11) or exit("Sql Error21".mysql_error());
			while($sql_row11=mysqli_fetch_array($sql_result11))
			{
				$split_qty=$sql_row11["qty"];
			}
			
			//$orginal_qty=$orginal_qty-$split_qty;
			
			$sql21="select title_size_".$sizes_array[$i1]." as size from $bai_pro3.bai_orders_db_confirm where order_tid=\"".$order_tid."\"";
		//	echo $sql21."<br>";
			$sql_result21=mysqli_query($link,$sql21) or exit("Sql Error21".mysql_error());
			while($sql_row21=mysqli_fetch_array($sql_result21))
			{
				$size_val=$sql_row21['size'];
				if(strtolower(trim($size_val))<>'')
				{
					$size_ref=$sizes_array[$i1];
					echo "<tr>";
					//echo "<td>".$sizes_array[$i1]."</td>";
					echo "<td><input type=\"hidden\" size=5 id=\"size_".$i1."\" name=\"size[".$i1."]\" value=\"".$sizes_array[$i1]."\">".$size_val."</td>";
					echo "<td><input type=\"hidden\" size=5 id=\"org_qty_".$i1."\" name=\"org_qty[".$i1."]\" value=\"".$orginal_qty."\">".$orginal_qty."</td>";
					echo "<td><input type=\"text\" size=5 id=\"brk_qty_".$i1."\" name=\"brk_qty[".$i1."]\" onkeyup=\"check($i1)\" value=\"\"></td>";
					echo "</tr>";
					$x1=$x1+1;
				}
			}
			//echo strlen($size_val)."----".$orginal_qty."<br>";
			//if(strlen($size_val) <> && $orginal_qty > 0)
			//{
				
			//}
		}
		echo "<tr><td align=\"right\" colspan=3><input type=\"hidden\" id=\"count\" name=\"count\" value=\"$x1\"><input type=\"submit\" id=\"split\" name=\"split\" class=\"btn btn-success\" onclick ='return check_reasons($i)' value=\"Split\"></td></tr>";
		
		
		echo "</table>";
		echo "</form>";
		}
		else
		{
			echo "<h2>Marker Already Prepared For This Recut.Hence System Will Not Allow To Split The Quantity.</h2>";
		}
	}
	else
	{
		echo "<h2>Please provide the Body or Front Docket to split the Quiantity.</h2>";
	}
}

?>

<?php
	if(isset($_POST['split'])) 
	{ 
		$doc_no=$_POST['doc_no'];
		$count=$_POST['count'];
		$size=$_POST['size'];
		$org_qty=$_POST["org_qty"];
		$brk_qty=$_POST["brk_qty"];
		//echo $doc_no."-".$count."<br><br>";
		$cat_ref_new=array();
		$doc_ref_new=array();
		$doc_ref_cat=array();
	
		$sql1="select date,cat_ref,cuttable_ref,allocate_ref,mk_ref,order_tid,pcutno,acutno,remarks,plan_module from bai_pro3.recut_v2 where doc_no=\"".$doc_no."\"";
		// echo $sql1."<br><br>";
		$sql_result1=mysqli_query($link,$sql1) or exit("Sql Error211".mysql_error());
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$date=$sql_row1["date"];
			$cat_ref=$sql_row1["cat_ref"];
			$cuttable_ref=$sql_row1["cuttable_ref"];
			$allocate_ref=$sql_row1["allocate_ref"];
			$mk_ref=$sql_row1["mk_ref"];
			$order_tid=$sql_row1["order_tid"];
			$pcutno=$sql_row1["pcutno"];
			$acutno=$sql_row1["acutno"];
			$cut_no_ref=$sql_row1["acutno"];
			$remarks=$sql_row1["remarks"];
			$plan_module=$sql_row1["plan_module"];
		}
		$sql1="select max(pcutno) as cutno from $bai_pro3.recut_v2 where order_tid=\"".$order_tid."\"";
		//echo $sql1."<br><br>";
		$sql_result1=mysqli_query($link,$sql1) or exit("Sql Error212".mysql_error());
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$cutno=$sql_row1["cutno"];
		}
		$sql2="select * from $bai_pro3.bai_orders_db where order_tid=\"".$order_tid."\"";
		//echo $sql2."<br><br>";
		$sql_result2=mysqli_query($link,$sql2) or exit("Sql Error213".mysql_error());
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$order_style_no=$sql_row2["order_style_no"];
			$order_del_no=$sql_row2["order_del_no"];
			$order_col_des=$sql_row2["order_col_des"];
		}
		
		$sql3="select qms_style,qms_Schedule,qms_color,log_date,log_time,remarks,SUBSTRING_INDEX(remarks,'-',1) as module from $bai_pro3.bai_qms_db where qms_schedule=\"".$order_del_no."\" and qms_color=\"".$order_col_des."\" and qms_tran_type=6 and SUBSTRING_INDEX(remarks,'-',-1)=\"".$doc_no."\" limit 1";
		//echo $sql3."<br><br>";
		$sql_result3=mysqli_query($link,$sql3) or exit("Sql Error214".mysql_error());
		while($sql_row3=mysqli_fetch_array($sql_result3))
		{
			$qms_style_no=$sql_row3["qms_style"];
			$qms_del_no=$sql_row3["qms_Schedule"];
			$qms_col_des=$sql_row3["qms_color"];
			$log_date=$sql_row3["log_date"];
			$log_time=$sql_row3["log_time"];
			$qms_remarks=$sql_row3["remarks"];
			$module=$sql_row3["module"];
		}
		
		$pcutno=$cutno+1;
		$acutno=$cutno+1;
			
		$sql1241="SELECT $bai_pro3.recut_v2.cat_ref,$bai_pro3.recut_v2.doc_no,$bai_pro3.cat_stat_log.category,$bai_pro3.cat_stat_log.category from $bai_pro3.recut_v2 left join $bai_pro3.cat_stat_log on $bai_pro3.recut_v2.cat_ref=$bai_pro3.cat_stat_log.tid where $bai_pro3.recut_v2.order_tid='".$order_tid."' and bai_pro3.recut_v2.acutno='".$cut_no_ref."'";
		//echo $sql124."<br>";
		$sql_result241=mysqli_query($link,$sql1241) or exit($sql124."--Sql Error215".mysql_error());
		//echo sizeof($sql_result241)."<br>";
		while($sql_row24=mysqli_fetch_array($sql_result241))
		{
			$cat_ref_new[]=$sql_row24['cat_ref'];
			$doc_ref_new[]=$sql_row24['doc_no'];
			$doc_ref_cat[]=$sql_row24['category'];
		}
		
		$sizes_ref=array();
		$sizes_refp=array();
		for($i2=0;$i2<=$count;$i2++)
		{
			//echo $size[$i2]."-".$org_qty[$i2]."-".$brk_qty[$i2]."<br><br>";
			if($brk_qty[$i2] > 0)
			{
				$sizes_ref[]="a_".$size[$i2]."";
				$qtys_ref[]=$brk_qty[$i2];
				$sizes_refp[]="p_".$size[$i2]."";
				//$qtys_ref[]=$brk_qty[$i2];
				for($i4=0;$i4<sizeof($doc_ref_new);$i4++)
				{
					$sql22="update $bai_pro3.recut_v2 set a_".$size[$i2]."=a_".$size[$i2]."-".$brk_qty[$i2].",p_".$size[$i2]."=p_".$size[$i2]."-".$brk_qty[$i2]." where doc_no='".$doc_ref_new[$i4]."'";
					//echo $sql22."<br><br>";
					mysqli_query($link,$sql22) or exit("Sql Error=".$sql22."-".mysql_error());
				}
				$sql23="update $bai_pro3.bai_qms_db set qms_qty=qms_qty-".$brk_qty[$i2]." where qms_schedule=\"".$order_del_no."\" and qms_color=\"".$order_col_des."\" and qms_tran_type=6 and SUBSTRING_INDEX(remarks,'-',-1)=\"".$doc_no."\" and qms_size=\"".$size[$i2]."\"";
				//echo $sql23."<br><br>";
				mysqli_query($link,$sql23) or exit("Sql Error=".$sql23."-".mysql_error());
			}
		}
				
		for($i5=0;$i5<sizeof($doc_ref_new);$i5++)
		{
			$sql="insert into $bai_pro3.recut_v2 (date,cat_ref,cuttable_ref,allocate_ref,mk_ref,order_tid,pcutno,acutno,remarks,plan_module,pcutdocid,".implode(",",$sizes_ref).",".implode(",",$sizes_refp).") value(\"".$date."\",'".$cat_ref_new[$i5]."',$cuttable_ref,$allocate_ref,$mk_ref,\"".$order_tid."\",$pcutno,$acutno,\"".$doc_ref_cat[$i5]."\",\"".$plan_module."\",'".$doc_ref_new[$i5]."',".implode(",",$qtys_ref).",".implode(",",$qtys_ref).")";
			// echo $sql."<br><br>";
			mysqli_query($link,$sql) or exit("Sql Error=".$sql."-".mysql_error());
		}
		
		echo "<script>sweetAlert('Successfully Updated','','success');</script>";
		$iLastid=mysql_insert_id($$link);
		for($i3=0;$i3<=$count;$i3++)
		{
			echo $size[$i3]."-".$org_qty[$i3]."-".$brk_qty[$i3]."<br><br>";
			if($brk_qty[$i3] > 0)
			{
				$sql24="insert into $bai_pro3.bai_qms_db (qms_style, qms_schedule, qms_color, log_date, log_time, qms_size, qms_qty, qms_tran_type, remarks) values(\"".$qms_style_no."\",\"".$qms_del_no."\",\"".$qms_col_des."\",\"".$log_date."\",\"".date("Y-m-d H:i:s")."\",\"".$size[$i3]."\",\"".$brk_qty[$i3]."\",\"6\",\"".$module."-".$iLastid."\")";
				echo $sql24."<br><br>";
				mysql_query($link,$sql24) or exit("Sql Error=".$sql24."-".mysql_error());
			}
		}
		
		
		
	} 
?>

</div>
</div>
<script>
function check_reasons(count){
	var count = document.getElementById('count').value;
		var total = 0;
		var val;
		for(var i = 0;i<parseInt(count);i++){
				val = document.getElementById('brk_qty_'+i).value;
				if(val == ''){
					val = 0;
				}else{
					val = val;
				}
				total += parseFloat(val);
				
		}	
		if(total == 0){
			sweetAlert('Split Qty should be greater than ZERO.','','warning');
			return false;
		}
		return true;
}

</script>























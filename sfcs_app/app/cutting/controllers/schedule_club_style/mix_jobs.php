
<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));	  
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));	  
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/bundle_filling.php',4,'R'));	  
	?> 
#loading-image{
  position:fixed;
  top:0px;
  right:0px;
  width:100%;
  height:100%;
  background-color:#666;
  /* background-image:url('ajax-loader.gif'); */
  background-repeat:no-repeat;
  background-position:center;
  z-index:10000000;
  opacity: 0.4;
  filter: alpha(opacity=40); /* For IE8 and earlier */
}



<script>
	function firstbox()
	{
		window.location.href ="<?= getFullURLLevel($_GET['r'],'mix_jobs.php',0,'N'); ?>&style="+document.test.style.value
	}

	function secondbox()
	{
		window.location.href ="<?= getFullURLLevel($_GET['r'],'mix_jobs.php',0,'N'); ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value
	}

	function thirdbox()
	{
		window.location.href ="<?= getFullURLLevel($_GET['r'],'mix_jobs.php',0,'N'); ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
	}
	
	function check_all()
	{
		var style=document.getElementById('style').value;
		var sch=document.getElementById('schedule').value;
		var color=document.getElementById('color').value;
		if(style=='' || sch=='' || color=='')
		{
			sweetAlert('Please Enter style ,Schedule and Color','','warning');
			return false;
		}
		else
		{
			document.getElementById("loading-image").style.display = "block";
			return true;
		}
	}
</script>

<div class="ajax-loader" id="loading-image" style="display: none">
    <center><img src='<?= getFullURLLevel($_GET['r'],'common/images/ajax-loader.gif',2,'R'); ?>' class="img-responsive" style="padding-top: 250px"/></center>
</div>


<div class="panel panel-primary">
	<div class="panel-heading">Schedule Club Splitting (Schedule Level)</div>
	<div class="panel-body">
	<form name="test" method="post" action="<?php getFullURLLevel($_GET['r'],'mix_jobs.php',0,'R') ?>">
	<?php
		$style=$_GET['style'];
		$schedule=$_GET['schedule']; 
		$color=$_GET['color'];
		$po=$_GET['po'];

		if(isset($_POST['submit']))
		{
			$style=$_POST['style'];
			$schedule=$_POST['schedule']; 
			$color=$_POST['color'];
			$po=$_POST['po'];
		}

		echo "<div class='row'><div class='col-md-3'>";
		echo "Select Style: <select name=\"style\"  id=\"style\" class=\"form-control\" onchange=\"firstbox();\" required>";
		//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
		//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
		//{
			$sql="select distinct order_style_no from $bai_pro3.bai_orders_db_confirm where order_tid in (select order_tid from $bai_pro3.plandoc_stat_log) and $order_joins_in_1";	
		//}
		$sql_result=mysqli_query($link, $sql) or exit(message_sql());
		$sql_num_check=mysqli_num_rows($sql_result);
		echo "<option value=''>Please Select</option>";
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
		echo "</select></div>";

	?>


	<?php
		echo"<div class='col-md-3'>";
		echo "Select Schedule: <select name=\"schedule\"  id=\"schedule\" class=\"form-control\" onchange=\"secondbox();\" required>";

		//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
		//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
		//{
			$sql="select distinct order_del_no from $bai_pro3.bai_orders_db_confirm where order_tid in (select order_tid from $bai_pro3.plandoc_stat_log) and length(order_del_no)>7 and order_style_no=\"$style\" and $order_joins_in_1 order by order_date";	
		//}
		// echo "working".$sql;
		$sql_result=mysqli_query($link, $sql) or exit(message_sql());
		$sql_num_check=mysqli_num_rows($sql_result);
		echo "<option value=''>Please Select</option>";
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
		echo "</select></div>";

		echo"<div class='col-md-3'>";
		echo "Select Color: <select name=\"color\" class=\"form-control\"  id=\"color\" onchange=\"thirdbox();\" required>";
		$sql="select distinct order_col_des from $bai_pro3.bai_orders_db_confirm where order_tid in (select order_tid from $bai_pro3.plandoc_stat_log) and order_style_no=\"$style\" and order_del_no=\"$schedule\" and $order_joins_in_1";
		//}
		$sql_result=mysqli_query($link, $sql) or exit(message_sql());
		$sql_num_check=mysqli_num_rows($sql_result);
		echo "<option value=''>Please Select</option>";			
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color))
			{
				echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
			}
			else
			{
				echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
			}
		}
		echo "</select></div>		<br>";
		echo"<div class='col-md-3'>
				<input type=\"submit\" onclick='return check_all();' class='btn btn-success' value=\"Segregate\" name=\"submit\"  id=\"Segregate\" />
			</div>";
	?>

	</div>
</form>
</div>
</div>

<?php

if(isset($_POST['submit']) && short_shipment_status($_POST['style'],$_POST['schedule'],$link))
{
	mysqli_begin_transaction($link);
	try{
		function message_sql()
		{ 
			echo "<script>swal('Splitting not completed......please split again','','warning');</script>";
		}

	echo '<script type="text/javascript">document.getElementById("loading-image").style.display = "block";</script>';
	$order_sch=$_POST['schedule'];
	$orders_join='J'.$order_sch;	
    $style=$_POST['style']; 
    $color=$_POST['color'];
	$cat_id_ref=array();
	$order_id_ref=array();
	$doc_det=array();
	$pend_order=array();
	$pend_order_type=array();
	$pending_cat_ref=array();
	$pending_cat_order=array();
	$pend_order_ref=array();
	$pending_cat_ref_type=array();
	$ready_cat_ref=array();
	$ready_cat_order=array();
	$ready_cat_ref_type=array();
	$o_s=array();	
	$o_s_t=array();
	
	$table_tag=" $bai_pro3.bai_orders_db_club_confirm";	
	$sql47="select * from  $bai_pro3.bai_orders_db_confirm where order_del_no='$order_sch' and order_col_des='".$color."'"; 
	$sql_result47=mysqli_query( $link, $sql47) or exit(message_sql()); 
	while($sql_row47=mysqli_fetch_array($sql_result47)) 
	{ 
		$ord_tid=$sql_row47['order_tid'];
		for($s=0;$s<sizeof($sizes_array);$s++)
		{
			if($sql_row47["title_size_".$sizes_array[$s].""]<>'')
			{
				$o_s[$sizes_array[$s]]=$sql_row47["order_s_".$sizes_array[$s].""];
				$o_s_t[$sizes_array[$s]]=$sql_row47["title_size_".$sizes_array[$s].""];
			}
		}	
	}
 	
	$sql4="select * from $bai_pro3.cat_stat_log where order_tid='".$ord_tid."' and category<>''"; 
	$sql_result4=mysqli_query( $link, $sql4) or exit(message_sql());
	while($sql_row4=mysqli_fetch_array($sql_result4)) 
	{
		$cat_id_ref[]=$sql_row4["tid"];	
		$order_id_ref[]=$sql_row4["order_tid"];
		$cat_type[]=$sql_row4["category"];
	}
	
	for($ii=0;$ii<sizeof($cat_id_ref);$ii++)
	{
		$sql41="select * from $bai_pro3.plandoc_stat_log where cat_ref=".$cat_id_ref[$ii]." and order_tid='".$order_id_ref[$ii]."' "; 
		$sql_result41=mysqli_query( $link, $sql41) or exit(message_sql());
		if(mysqli_num_rows($sql_result41)>0)
		{
			while($sql_row41=mysqli_fetch_array($sql_result41)) 
			{
				for($s=0;$s<sizeof($o_s_t);$s++)
				{
					if($sql_row41["p_".$sizes_array[$s].""]>0)
					{
						$tot_com[$sizes_array[$s]]+=$sql_row41["p_".$sizes_array[$s].""]*$sql_row41["p_plies"];
					}					
				}
				$doc_det[]=$sql_row41["doc_no"];	
			}
			$status=0;
			for($s=0;$s<sizeof($o_s_t);$s++)
			{
				if($o_s[$sizes_array[$s]]>0)
				{
					if($o_s[$sizes_array[$s]]>$tot_com[$sizes_array[$s]])
					{
						$status=1;
					}
				}
			}
			//Validate for splitting eligible or not.
			if($status==1)
			{
				$pending_cat_ref[]=$cat_id_ref[$ii];
				$pending_cat_order[]=$order_id_ref[$ii];
				$pending_cat_ref_type[]=$cat_type[$ii];
			}
			else
			{
				$ready_cat_ref[]=$cat_id_ref[$ii];
				$ready_cat_order[]=$order_id_ref[$ii];
				$ready_cat_ref_type[]=$cat_type[$ii];
			}	
		}
		else
		{
			//Lay Plan not Done still.
			$pend_order_ref[]=$cat_id_ref[$ii];				
			$pend_order[]=$order_id_ref[$ii];				
			$pend_order_type[]=$cat_type[$ii];				
		}
	}
	if(sizeof($ready_cat_ref)>0 &&(sizeof($cat_id_ref)==sizeof($ready_cat_ref))) 	
	{
	    $sql2="truncate $bai_pro3.mix_temp_desti"; 
        mysqli_query( $link, $sql2) or exit(message_sql()); 

        $sql3="truncate $bai_pro3.mix_temp_source"; 
        mysqli_query( $link, $sql3) or exit(message_sql()); 
		for($l=0;$l<sizeof($ready_cat_ref);$l++)
		{
			$sql416="select * from $bai_pro3.plandoc_stat_log where cat_ref=".$ready_cat_ref[$l]." and  order_tid='".$ready_cat_order[$l]."' and org_doc_no=0"; 
			$sql_result416=mysqli_query( $link, $sql416) or exit(message_sql());
			if(mysqli_num_rows($sql_result416)>0)
			{				
				$sql5="select tid,order_tid from $bai_pro3.cat_stat_log where tid=".$ready_cat_ref[$l]."";			
				$sql_result5=mysqli_query( $link, $sql5) or exit(message_sql()); 
				while($sql_row=mysqli_fetch_array($sql_result5)) 
				{ 
					$cat_ref=$ready_cat_ref[$l]; 
					$order_tid=$ready_cat_order[$l]; 
					$sql13="select sum(allocate_s01*plies) as cuttable_s_s01,sum(allocate_s02*plies) as cuttable_s_s02,sum(allocate_s03*plies) as cuttable_s_s03,sum(allocate_s04*plies) as cuttable_s_s04,sum(allocate_s05*plies) as cuttable_s_s05,sum(allocate_s06*plies) as cuttable_s_s06,sum(allocate_s07*plies) as cuttable_s_s07,sum(allocate_s08*plies) as cuttable_s_s08,sum(allocate_s09*plies) as cuttable_s_s09,sum(allocate_s10*plies) as cuttable_s_s10,sum(allocate_s11*plies) as cuttable_s_s11,sum(allocate_s12*plies) as cuttable_s_s12,sum(allocate_s13*plies) as cuttable_s_s13,sum(allocate_s14*plies) as cuttable_s_s14,sum(allocate_s15*plies) as cuttable_s_s15,sum(allocate_s16*plies) as cuttable_s_s16,sum(allocate_s17*plies) as cuttable_s_s17,sum(allocate_s18*plies) as cuttable_s_s18,sum(allocate_s19*plies) as cuttable_s_s19,sum(allocate_s20*plies) as cuttable_s_s20,sum(allocate_s21*plies) as cuttable_s_s21,sum(allocate_s22*plies) as cuttable_s_s22,sum(allocate_s23*plies) as cuttable_s_s23,sum(allocate_s24*plies) as cuttable_s_s24,sum(allocate_s25*plies) as cuttable_s_s25,sum(allocate_s26*plies) as cuttable_s_s26,sum(allocate_s27*plies) as cuttable_s_s27,sum(allocate_s28*plies) as cuttable_s_s28,sum(allocate_s29*plies) as cuttable_s_s29,sum(allocate_s30*plies) as cuttable_s_s30,sum(allocate_s31*plies) as cuttable_s_s31,sum(allocate_s32*plies) as cuttable_s_s32,sum(allocate_s33*plies) as cuttable_s_s33,sum(allocate_s34*plies) as cuttable_s_s34,sum(allocate_s35*plies) as cuttable_s_s35,sum(allocate_s36*plies) as cuttable_s_s36,sum(allocate_s37*plies) as cuttable_s_s37,sum(allocate_s38*plies) as cuttable_s_s38,sum(allocate_s39*plies) as cuttable_s_s39,sum(allocate_s40*plies) as cuttable_s_s40,sum(allocate_s41*plies) as cuttable_s_s41,sum(allocate_s42*plies) as cuttable_s_s42,sum(allocate_s43*plies) as cuttable_s_s43,sum(allocate_s44*plies) as cuttable_s_s44,sum(allocate_s45*plies) as cuttable_s_s45,sum(allocate_s46*plies) as cuttable_s_s46,sum(allocate_s47*plies) as cuttable_s_s47,sum(allocate_s48*plies) as cuttable_s_s48,sum(allocate_s49*plies) as cuttable_s_s49,sum(allocate_s50*plies) as cuttable_s_s50 from $bai_pro3.allocate_stat_log where order_tid='".$order_tid."' and cat_ref=".$cat_ref."";
					$c_s=array(); 			
					$sql_result13=mysqli_query( $link, $sql13) or exit(message_sql()); 
					while($sql_row1=mysqli_fetch_array($sql_result13)) 
					{ 
						for($s=0;$s<sizeof($o_s_t);$s++)
						{
							$c_s[$sizes_array[$s]]=$sql_row1["cuttable_s_".$sizes_array[$s].""];
						}	
					}
					
					$ex_qty=array(); 
					$ex_s=array(); 
					for($s=0;$s<sizeof($o_s_t);$s++)
					{
						$ex_s[$sizes_array[$s]]=$c_s[$sizes_array[$s]]-$o_s[$sizes_array[$s]];
					}
					
					$tot_qty=array(); 
					$cut_exs_query = "SELECT excess_cut_qty from $bai_pro3.excess_cuts_log where schedule_no='$order_sch' and color='$color'";
					$cut_exs_result = mysqli_query($link,$cut_exs_query);	
					if(mysqli_num_rows($cut_exs_result) > 0)
					{
						$row_exs = mysqli_fetch_array($cut_exs_result);
						if($row_exs['excess_cut_qty'] == 1)
							$sql6="select * from $bai_pro3.plandoc_stat_log where cat_ref=".$cat_ref." and order_tid='".$order_tid."' and remarks='Normal' order by acutno";
						else
							$sql6="select * from $bai_pro3.plandoc_stat_log where cat_ref=".$cat_ref." and order_tid='".$order_tid."' and remarks='Normal' order by acutno DESC";
					}
					else
					{
						$sql6="select * from $bai_pro3.plandoc_stat_log where cat_ref=".$cat_ref." and order_tid='".$order_tid."' and remarks='Normal' order by acutno";
					}
					echo $sql6."<br>";
					$docket_details=array();
					$sql_result16=mysqli_query( $link, $sql6) or exit(message_sql()); 
					while($sql_row1=mysqli_fetch_array($sql_result16)) 
					{ 
						$docket_details[]=$sql_row1['doc_no'];
						$doc_no=$sql_row1['doc_no']; 
						$cut_ref=$sql_row1['cuttable_ref']; 
						$mk_ref=$sql_row1['mk_ref']; 
						$p_plies=$sql_row1["p_plies"]; 
						 
						$qts=array(); 
						$qts_ex=array(); 
						$qts_ex_val=array(); 
						$qts_ex_size=array(); 
						$plies=$sql_row1['p_plies']; 
						$cutno=$sql_row1['pcutno'];
					
						for($i=0;$i<sizeof($o_s_t);$i++) 
						{ 
							$size_new_code="p_".$sizes_array[$i]; 
							if(($sql_row1[$size_new_code]*$plies)<$ex_s[$sizes_array[$i]]) 
							{ 
								$qts[$sizes_array[$i]]=0; 
								$ex_s[$sizes_array[$i]]=$ex_s[$sizes_array[$i]]-$sql_row1[$size_new_code]*$plies; 
								$qts_ex_size[$sizes_array[$i]]=$size_new_code; 
								$qts_ex_val[$sizes_array[$i]]=$sql_row1[$size_new_code]*$plies; 
							} 
							else 
							{ 
								if($ex_s[$sizes_array[$i]] > 0) 
								{ 
									$qts[$sizes_array[$i]]=($sql_row1[$size_new_code]*$plies)-$ex_s[$sizes_array[$i]]; 
									$qts_ex_val[$sizes_array[$i]]=$ex_s[$sizes_array[$i]]; 
									$qts_ex_size[$sizes_array[$i]]=$size_new_code; 
									$ex_s[$sizes_array[$i]]=0; 
								} 
								else 
								{ 
									$qts[$sizes_array[$i]]=($sql_row1[$size_new_code]*$plies); 
								} 
							}							 
						}
						
						for($ii=0;$ii<sizeof($o_s_t);$ii++) 
						{ 
							if($qts[$sizes_array[$ii]]>0) 
							{ 
								$sql7="insert into $bai_pro3.mix_temp_source (doc_no,cat_ref,cutt_ref,mk_ref,size,qty,plies,cutno) values ($doc_no,$cat_ref,$cut_ref,$mk_ref,'".$sizes_array[$ii]."',".$qts[$sizes_array[$ii]].",".$plies.",".$cutno.")"; 
								 mysqli_query( $link, $sql7) or exit(message_sql()); 
							} 
						} 
						
						for($kk=0;$kk<sizeof($o_s_t);$kk++) 
						{ 
							if($qts_ex_val[$sizes_array[$kk]]>0) 
							{ 
								$sql71="insert into $bai_pro3.mix_temp_source (doc_no,cat_ref,cutt_ref,mk_ref,size,qty,plies,cutno,type) values ($doc_no,$cat_ref,$cut_ref,$mk_ref,'".str_replace("p_","",$qts_ex_size[$sizes_array[$kk]])."',".$qts_ex_val[$sizes_array[$kk]].",".$plies.",".$cutno.",1)";
								mysqli_query( $link, $sql71) or exit(message_sql()); 
							} 
						}
					}
					
					for($i=0;$i<sizeof($o_s_t);$i++) 
					{ 
						$sql92="select order_tid, order_del_no, order_col_des, order_s_".$sizes_array[$i]." as ord_qty,destination,order_style_no from $bai_pro3.bai_orders_db_club_confirm where order_joins='".$orders_join."' and order_s_".$sizes_array[$i].">0 order by order_date*1";
						$sql_result192=mysqli_query( $link, $sql92) or exit(message_sql()); 
						while($sql_row192=mysqli_fetch_array($sql_result192)) 
						{								
							$order_del_no=$sql_row192['order_del_no'];
							$order_tid1=$sql_row192["order_tid"];
							$order_col=$sql_row192["order_col_des"];
							$destination_id_new=$sql_row192["destination"];
							$req_qty=$sql_row192['ord_qty'];
							$sql14="select * from $bai_pro3.mix_temp_source where size='".$sizes_array[$i]."' and qty>0 and cat_ref=".$cat_ref." and type=0 group by doc_no order by doc_no*1"; 
							$sql_result114=mysqli_query( $link, $sql14) or exit(message_sql()); 
							if(mysqli_num_rows($sql_result114)>0)
							{
								while($sql_row11=mysqli_fetch_array($sql_result114)) 
								{ 
									$doc_no=$sql_row11['doc_no']; 
									$cut_ref=$sql_row11['cutt_ref']; 
									$mk_ref=$sql_row11['mk_ref']; 
									$cat_ref=$sql_row11['cat_ref']; 
									$plies_ref=$sql_row11['plies']; 
									$available=$sql_row11['qty'];
									$cutno=$sql_row11['cutno'];
									if($req_qty>$available)
									{
										$update_value=0;
										if($req_qty > 0)
										{
											$sqlx3="insert into $bai_pro3.mix_temp_desti(allo_new_ref,cat_ref,cutt_ref,mk_ref,size,qty,order_tid,order_del_no,order_col_des,destination,plies,doc_no,cutno) values ($doc_no,$cat_ref,$cut_ref,$mk_ref,'".$sizes_array[$i]."',$available,'".$order_tid1."','".$order_del_no."','".$order_col."','".$destination_id_new."',$plies_ref,$doc_no,$cutno)"; 
											mysqli_query($link, $sqlx3) or exit(message_sql());
											
											$sqlx4="update $bai_pro3.mix_temp_source set qty=$update_value where doc_no=$doc_no and size='".$sizes_array[$i]."' and type=0";
											mysqli_query($link, $sqlx4) or exit(message_sql());
											$req_qty=$req_qty-$available;
										}										
									}
									else
									{
										$update_value=$available-$req_qty;
										if($req_qty > 0)
										{
											$sqlx3="insert into $bai_pro3.mix_temp_desti(allo_new_ref,cat_ref,cutt_ref,mk_ref,size,qty,order_tid,order_del_no,order_col_des,destination,plies,doc_no,cutno) values ($doc_no,$cat_ref,$cut_ref,$mk_ref,'".$sizes_array[$i]."',$req_qty,'".$order_tid1."','".$order_del_no."','".$order_col."','".$destination_id_new."',$plies_ref,$doc_no,$cutno)";
											mysqli_query($link, $sqlx3) or exit(message_sql());
											$sqlx7="update $bai_pro3.mix_temp_source set qty=$update_value where doc_no=$doc_no and size='".$sizes_array[$i]."' and type=0";
											mysqli_query($link, $sqlx7) or exit(message_sql());
											$req_qty=0;
										}										
									}			
								}
							}
						}
					}
					// Excess Pieces Segregation
					unset($colrs);
					unset($col_tot);
					unset($order_tids);
					unset($destination_id_new);
					unset($val);
					for($i=0;$i<sizeof($o_s_t);$i++) 
					{ 
						$available=array();
						$dels=array();
						$colrsnew=array();
						$del_qty=array();
						$order_tids=array();
						$destination_id_new=array();
						$cutno=array();
						$cut_ref=array();
						$mk_ref=array();
						$doc_no=array();
						$plies_ref=array();
						$docs=array();
						$pend=0;
						$tot_split=0;$req_qty=0;
						$eligble=0;
						$sql9="select order_tid, order_del_no, order_col_des, order_s_".$sizes_array[$i]." as ord_qty,destination from $bai_pro3.bai_orders_db_club_confirm where order_joins='".$orders_join."' and order_s_".$sizes_array[$i].">0 group by order_del_no order by order_del_no*1";
						$sql_result19=mysqli_query( $link, $sql9) or exit(message_sql()); 
						$tot_col=mysqli_num_rows($sql_result19);
						while($sql_row19=mysqli_fetch_array($sql_result19)) 
						{
							$dels[]=$sql_row19["order_del_no"];
							$colrsnew[$sql_row19["order_del_no"]]=$sql_row19["order_col_des"];
							$del_qty[$sql_row19["order_del_no"]]=$sql_row19['ord_qty'];
							$order_tids[$sql_row19["order_del_no"]]=$sql_row19["order_tid"];
							$destination_id_new[$sql_row19["order_del_no"]]=$sql_row19['destination'];
							$req_qty=$req_qty+$sql_row19['ord_qty'];
						}	
						$max_del=max($dels);
						$sql14="select * from $bai_pro3.mix_temp_source where size='".$sizes_array[$i]."' and qty>0 and cat_ref=$cat_ref and type=1 group by doc_no order by doc_no*1";
						$sql_result114=mysqli_query( $link, $sql14) or exit(message_sql()); 
						if(mysqli_num_rows($sql_result114)>0)
						{
							while($sql_row11=mysqli_fetch_array($sql_result114)) 
							{
								$available[$sql_row11['doc_no']][$sizes_array[$i]]=$sql_row11['qty'];
								$cutno[$sql_row11['doc_no']][$sizes_array[$i]]=$sql_row11['cutno'];
								$doc_no[$sql_row11['doc_no']][$sizes_array[$i]]=$sql_row11['doc_no']; 
								$cut_ref[$sql_row11['doc_no']][$sizes_array[$i]]=$sql_row11['cutt_ref']; 
								$mk_ref[$sql_row11['doc_no']][$sizes_array[$i]]=$sql_row11['mk_ref']; 
								$plies_ref[$sql_row11['doc_no']][$sizes_array[$i]]=$sql_row11['plies'];
								$tot_qty_exces=	$tot_qty_exces+$sql_row11['qty'];
								$docs[]=$sql_row11['doc_no'];
							}
							$docs=array_values(array_unique($docs));	
						}						
						for($j=0;$j<sizeof($dels);$j++)
						{
							$eligble=floor(($del_qty[$dels[$j]]/$req_qty)*$tot_qty_exces);
							if($eligble>0)
							{
								for($jj=0;$jj<sizeof($docs);$jj++)
								{
									do
									{	
										if($eligble<=$available[$docs[$jj]][$sizes_array[$i]])
										{
											$sqlx3="insert into $bai_pro3.mix_temp_desti(allo_new_ref,cat_ref,cutt_ref,mk_ref,size,qty,order_tid,order_col_des,order_del_no,destination,plies,doc_no,cutno,type) values (".$docs[$jj].",".$cat_ref.",".$cut_ref[$docs[$jj]][$sizes_array[$i]].",".$mk_ref[$docs[$jj]][$sizes_array[$i]].",'".$sizes_array[$i]."',".$eligble.",'".$order_tids[$dels[$j]]."','".$colrsnew[$dels[$j]]."','".$dels[$j]."','".$destination_id_new[$dels[$j]]."',".$plies_ref[$docs[$jj]][$sizes_array[$i]].",".$docs[$jj].",".$cutno[$docs[$jj]][$sizes_array[$i]].",1)"; 
											mysqli_query( $link, $sqlx3) or exit(message_sql());	
											$sqlx71="update $bai_pro3.mix_temp_source set qty=0 where doc_no=".$docs[$jj]." and size='".$sizes_array[$i]."' and type=1";
											mysqli_query($link, $sqlx71) or exit(message_sql());
											$available[$docs[$jj]][$sizes_array[$i]]=$available[$docs[$jj]][$sizes_array[$i]]-$eligble;
											$eligble=0;
										}
										else
										{
											$sqlx3="insert into $bai_pro3.mix_temp_desti(allo_new_ref,cat_ref,cutt_ref,mk_ref,size,qty,order_tid,order_col_des,order_del_no,destination,plies,doc_no,cutno,type) values (".$docs[$jj].",".$cat_ref.",".$cut_ref[$docs[$jj]][$sizes_array[$i]].",".$mk_ref[$docs[$jj]][$sizes_array[$i]].",'".$sizes_array[$i]."',".$available[$docs[$jj]][$sizes_array[$i]].",'".$order_tids[$dels[$j]]."','".$colrsnew[$dels[$j]]."','".$dels[$j]."','".$destination_id_new[$dels[$j]]."',".$plies_ref[$docs[$jj]][$sizes_array[$i]].",".$docs[$jj].",".$cutno[$docs[$jj]][$sizes_array[$i]].",1)"; 
											mysqli_query( $link, $sqlx3) or exit(message_sql());	
											$sqlx71="update $bai_pro3.mix_temp_source set qty=0 where doc_no=".$docs[$jj]." and size='".$sizes_array[$i]."' and type=1";
											mysqli_query($link, $sqlx71) or exit(message_sql());
											$eligble=$eligble-$available[$docs[$jj]][$sizes_array[$i]];
											$available[$docs[$jj]][$sizes_array[$i]]=0;	
										}										
									}while($eligble>0 && $available[$docs[$jj]][$sizes_array[$i]]>0);									
								}								
							}
						}
						for($jj=0;$jj<sizeof($docs);$jj++)
						{
							if($available[$docs[$jj]][$sizes_array[$i]]>0)
							{	
								$sqlx31="insert into $bai_pro3.mix_temp_desti(allo_new_ref,cat_ref,cutt_ref,mk_ref,size,qty,order_tid,order_col_des,order_del_no,destination,plies,doc_no,cutno,type) values (".$docs[$jj].",".$cat_ref.",".$cut_ref[$docs[$jj]][$sizes_array[$i]].",".$mk_ref[$docs[$jj]][$sizes_array[$i]].",'".$sizes_array[$i]."',".$available[$docs[$jj]][$sizes_array[$i]].",'".$order_tids[$max_del]."','".$colrsnew[$max_del]."','".$max_del."','".$destination_id_new[$max_del]."',".$plies_ref[$docs[$jj]][$sizes_array[$i]].",".$docs[$jj].",".$cutno[$docs[$jj]][$sizes_array[$i]].",1)"; 
								mysqli_query($link, $sqlx31) or exit(message_sql());	
								$sqlx71="update $bai_pro3.mix_temp_source set qty=0 where doc_no=".$docs[$jj]." and size='".$sizes_array[$i]."' and type=1";
								mysqli_query($link, $sqlx71) or exit(message_sql());	
								$available[$docs[$jj]][$sizes_array[$i]]=0;												
							}									
						}								
						$tot_qty_exces=0;	
						unset($available);
						unset($dels);
						unset($colrsnew);
						unset($del_qty);
						unset($order_tids);
						unset($destination_id_new);
						unset($mk_ref);
						unset($doc_no);
						unset($cutno);
						unset($plies_ref);
						unset($docs);						
					}														
				}
							
				$size_p=array();
				$size_q=array();
				// Sample Checking
				for($j=0;$j<sizeof($ready_cat_ref);$j++)
				{
					$sql471="select order_tid,order_del_no,order_col_des from $bai_pro3.bai_orders_db_confirm where order_joins='$orders_join'"; 
					$sql_result471=mysqli_query( $link, $sql471) or exit(message_sql()); 
					while($sql_row471=mysqli_fetch_array($sql_result471)) 
					{ 
						$sql472="select * from $bai_pro3.sp_sample_order_db where order_tid='".$sql_row471['order_tid']."'"; 
						$sql_result472=mysqli_query( $link, $sql472) or exit(message_sql());
						if(mysqli_num_rows($sql_result472)>0)
						{						
							while($sql_row472=mysqli_fetch_array($sql_result472)) 
							{
								$qty=$sql_row472['input_qty'];
								$sql12="SELECT * FROM $bai_pro3.`mix_temp_desti` where size='".$sql_row472['sizes_ref']."' and cat_ref=".$ready_cat_ref[$j]."  and type=1 order by doc_no*1"; 
								$sql_result12=mysqli_query( $link, $sql12) or exit(message_sql()); 
								while($sql_row1x12=mysqli_fetch_array($sql_result12)) 
								{
									if($qty>0)
									{
										if($qty>$sql_row1x12['qty'])
										{
											$update_sql="UPDATE $bai_pro3.`mix_temp_desti` SET `order_tid` = '".$sql_row471['order_tid']."' , `order_del_no` = '".$sql_row471['order_del_no']."' , `order_col_des` = '".$sql_row471['order_col_des']."' WHERE `mix_tid` = ".$sql_row1x12['mix_tid']."";
											mysqli_query( $link, $update_sql) or exit(message_sql());									
											$qty=$qty-$sql_row1x12['qty'];
										}
										else
										{
											$insert_sql="INSERT INTO $bai_pro3.`mix_temp_desti` (`allo_new_ref`, `cat_ref`, `cutt_ref`, `mk_ref`, `size`, `qty`, `order_tid`, `order_del_no`, `order_col_des`, `destination`, `plies`, `doc_no`, `cutno`) select allo_new_ref,cat_ref,cutt_ref,mk_ref,size,".$qty.",'".$sql_row471['order_tid']."','".$sql_row471['order_del_no']."','".$sql_row471['order_col_des']."',destination,plies,doc_no,cutno from $bai_pro3.`mix_temp_desti` where `mix_tid` = ".$sql_row1x12['mix_tid']."";
											mysqli_query( $link, $insert_sql) or exit(message_sql());
											$update_sql1="UPDATE $bai_pro3.`mix_temp_desti` SET qty=(qty-$qty) WHERE `mix_tid` = ".$sql_row1x12['mix_tid']."";
											mysqli_query( $link, $update_sql1) or exit(message_sql());
											$qty=0;
										}
									}
								}
							}
						}
					}
				}
				$cnt=0;
				$sql47221="SELECT cat_ref,order_tid,doc_no,COUNT(*) AS cnt,GROUP_CONCAT(mix_tid) AS tids,SUM(qty) as qunty FROM $bai_pro3.`mix_temp_desti` WHERE type=1 GROUP BY cat_ref,order_tid,doc_no,size HAVING cnt>1 ORDER BY doc_no*1"; 
				$sql_result47212=mysqli_query( $link, $sql47221) or exit(message_sql());
				if(mysqli_num_rows($sql_result47212)>0)
				{
					while($sql_row1123=mysqli_fetch_array($sql_result47212)) 
					{ 
						$cnt=$sql_row1123['cnt']-1;
						$update_sqls="UPDATE $bai_pro3.`mix_temp_desti` SET qty=".$sql_row1123['qunty']." WHERE `mix_tid` in (".$sql_row1123['tids'].")";
						mysqli_query( $link, $update_sqls) or exit(message_sql());
						$delete_sqls="DELETE from $bai_pro3.`mix_temp_desti` WHERE `mix_tid` in (".$sql_row1123['tids'].") limit $cnt";
						mysqli_query( $link, $delete_sqls) or exit(message_sql());
					}
				}
				
				// Calling to Fill the Plan_cut_bundle
				for($k=0;$k<sizeof($docket_details);$k++)
				{
					plan_cut_bundle_gen_club($docket_details[$k],$style,$color);
				}
				
				/*				
				//Executing Docket Creation & Updation
				$sql1="SELECT cutno,order_col_des,order_del_no,order_tid,doc_no,GROUP_CONCAT(size ORDER BY size) as size,GROUP_CONCAT(qty ORDER BY size) as  ratio,cat_ref,plies FROM $bai_pro3.`mix_temp_desti` where cat_ref='".$cat_ref."' and type=0 GROUP BY order_tid,doc_no order by doc_no*1"; 
				$sql_result1=mysqli_query( $link, $sql1) or exit(message_sql()); 
				while($sql_row1x=mysqli_fetch_array($sql_result1)) 
				{ 
					$size_p=explode(",",$sql_row1x['size']);
					$size_q=explode(",",$sql_row1x['ratio']);
					
					if(array_sum($size_q)>0)
					{
						$sqlx351="insert into $bai_pro3.plandoc_stat_log (date,cat_ref,cuttable_ref,allocate_ref,mk_ref,order_tid,pcutno,acutno,p_plies,a_plies,destination,org_doc_no,org_plies,ratio,remarks,pcutdocid,p_s01,p_s02,p_s03,p_s04,p_s05,p_s06,p_s07,p_s08,p_s09,p_s10,p_s11,p_s12,p_s13,p_s14,p_s15,p_s16,p_s17,p_s18,p_s19,p_s20,p_s21,p_s22,p_s23,p_s24,p_s25,p_s26,p_s27,p_s28,p_s29,p_s30,p_s31,p_s32,p_s33,p_s34,p_s35,p_s36,p_s37,p_s38,p_s39,p_s40,p_s41,p_s42,p_s43,p_s44,p_s45,p_s46,p_s47,p_s48,p_s49,p_s50) select date,cat_ref,cuttable_ref,allocate_ref,mk_ref,'".$sql_row1x['order_tid']."','".$sql_row1x['cutno']."','".$sql_row1x['cutno']."',1,1,'".$sql_row1x['destination']."','".$sql_row1x['doc_no']."','".$sql_row1x['plies']."',ratio,remarks,pcutdocid,0,0,0,0,0,0,0,0,0,0,0,0, 
						0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 
						from plandoc_stat_log where cat_ref='$cat_ref' and doc_no='".$sql_row1x['doc_no']."'";
						$sql_result351=mysqli_query( $link, $sqlx351) or exit(message_sql());
						$docn=mysqli_insert_id($link);						
						for($j=0;$j<sizeof($size_p);$j++)
						{
							if($size_q[$j]>0)
							{
								$sql471="update $bai_pro3.plandoc_stat_log set p_".$size_p[$j]."='".$size_q[$j]."' where doc_no='$docn'"; 
								$sql_result471=mysqli_query( $link, $sql471) or exit(message_sql()); 
								 
								$sql4712="update $bai_pro3.mix_temp_desti set qty='0' where doc_no='".$sql_row1x['doc_no']."' and size='".$size_p[$j]."' and order_tid='".$sql_row1x['order_tid']."'"; 
								$sql_result4712=mysqli_query( $link, $sql4712) or exit(message_sql()); 
							}	
						}
					}
					unset($size_p);
					unset($size_q);
				}
				
				//Executing Docket Creation & Updation // Extra peices
				$sql16="SELECT cutno,order_col_des,order_del_no,order_tid,doc_no,GROUP_CONCAT(size ORDER BY size) as size,GROUP_CONCAT(qty ORDER BY size) as  ratio,cat_ref,plies FROM $bai_pro3.`mix_temp_desti` where cat_ref=".$cat_ref." and type=1 GROUP BY order_tid,doc_no order by doc_no*1"; 
				$sql_result16=mysqli_query( $link, $sql16) or exit(message_sql()); 
				while($sql_row1=mysqli_fetch_array($sql_result16)) 
				{ 
					$sqlx1="select * from $bai_pro3.plandoc_stat_log where org_doc_no='".$sql_row1['doc_no']."' and order_tid='".$sql_row1['order_tid']."'"; 
					$sql_resultx1=mysqli_query($link, $sqlx1) or exit(message_sql()); 
					if(mysqli_num_rows($sql_resultx1)>0)
					{
						while($sql_rowx12=mysqli_fetch_array($sql_resultx1)) 
						{
							$docn=$sql_rowx12['doc_no'];
						}
						$size_p=explode(",",$sql_row1['size']);
						$size_q=explode(",",$sql_row1['ratio']);
						for($j=0;$j<sizeof($size_p);$j++)
						{
							if($size_q[$j]>0)
							{
								$sql471="update $bai_pro3.plandoc_stat_log set ".$size_p[$j]."=($size_p[$j]+$size_q[$j]) where doc_no='$docn'";
								mysqli_query($link, $sql471) or exit(message_sql()); 
								$sql4712="update $bai_pro3.mix_temp_desti set qty='0' where doc_no='".$sql_row1['doc_no']."' and size='".$size_p[$j]."' and order_tid='".$sql_row1['order_tid']."'"; 
								$sql_result4712=mysqli_query($link, $sql4712) or exit(message_sql()); 
							}
						}
					}
					else
					{
						$sqlx351="insert into $bai_pro3.plandoc_stat_log (date,cat_ref,cuttable_ref,allocate_ref,mk_ref,order_tid,pcutno,acutno,p_plies,a_plies,destination,org_doc_no,org_plies,ratio,remarks,pcutdocid,p_s01,p_s02,p_s03,p_s04,p_s05,p_s06,p_s07,p_s08,p_s09,p_s10,p_s11,p_s12,p_s13,p_s14,p_s15,p_s16,p_s17,p_s18,p_s19,p_s20,p_s21,p_s22,p_s23,p_s24,p_s25,p_s26,p_s27,p_s28,p_s29,p_s30,p_s31,p_s32,p_s33,p_s34,p_s35,p_s36,p_s37,p_s38,p_s39,p_s40,p_s41,p_s42,p_s43,p_s44,p_s45,p_s46,p_s47,p_s48,p_s49,p_s50) select date,cat_ref,cuttable_ref,allocate_ref,mk_ref,'".$sql_row1['order_tid']."','".$sql_row1['cutno']."','".$sql_row1['cutno']."',1,1,'".$sql_row1['destination']."','".$sql_row1['doc_no']."','".$sql_row1['plies']."',ratio,remarks,pcutdocid,0,0,0,0,0,0,0,0,0,0,0,0, 
						0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 
						from $bai_pro3.plandoc_stat_log where cat_ref='$cat_ref' and order_tid='".$order_tid."' and doc_no='".$sql_row1['doc_no']."'";
						$sql_result351=mysqli_query($link, $sqlx351) or exit(message_sql()); 
						$docn=mysqli_insert_id($link);
						$size_p=explode(",",$sql_row1['size']);
						$size_q=explode(",",$sql_row1['ratio']);
						for($j=0;$j<sizeof($size_p);$j++)
						{
							if($size_q[$j]>0)
							{
								$sql471="update $bai_pro3.plandoc_stat_log set ".$size_p[$j]."='".$size_q[$j]."' where doc_no='$docn'"; 
								$sql_result471=mysqli_query($link, $sql471) or exit(message_sql()); 
								 
								$sql4712="update $bai_pro3.mix_temp_desti set qty='0' where doc_no='".$sql_row1['doc_no']."' and size='".$size_p[$j]."' and order_tid='".$sql_row1['order_tid']."'"; 
								$sql_result4712=mysqli_query($link, $sql4712) or exit(message_sql()); 
							}	
						}
					}
					unset($size_p);
					unset($size_q);
				}
				*/
				$sqly32="update $bai_pro3.plandoc_stat_log set org_doc_no=1 where doc_no in (select doc_no from $bai_pro3.mix_temp_desti where cat_ref='".$cat_ref."')"; 
				mysqli_query( $link, $sqly32) or exit(message_sql()); 
				
				
				//Allocation Stat Log allocation
				$sql12="SELECT cutt_ref,order_del_no,order_col_des,order_tid,GROUP_CONCAT(distinct doc_no) as docs FROM $bai_pro3.`mix_temp_desti` where cat_ref=".$cat_ref." GROUP BY order_tid,ratio order by order_tid*1"; 
				$sql_result1=mysqli_query( $link, $sql12) or exit(message_sql()); 
				while($sql_row1=mysqli_fetch_array($sql_result1)) 
				{ 
					$cut_ref=$sql_row1['cutt_ref'];
					$order=$sql_row1['order_tid'];
					$docslist=$sql_row1['docs'];
					$sqla="INSERT INTO `$bai_pro3`.`allocate_stat_log` (`date`, `cat_ref`, `cuttable_ref`, `order_tid`, `ratio`, `cut_count`, `pliespercut`, `allocate_xs`, `allocate_s`, `allocate_m`, `allocate_l`, `allocate_xl`, `allocate_xxl`, `allocate_xxxl`, `plies`, `lastup`, `remarks`, `mk_status`, `allocate_s01`, `allocate_s02`, `allocate_s03`, `allocate_s04`, `allocate_s05`, `allocate_s06`, `allocate_s07`, `allocate_s08`, `allocate_s09`, `allocate_s10`, `allocate_s11`, `allocate_s12`, `allocate_s13`, `allocate_s14`, `allocate_s15`, `allocate_s16`, `allocate_s17`, `allocate_s18`, `allocate_s19`, `allocate_s20`, `allocate_s21`, `allocate_s22`, `allocate_s23`, `allocate_s24`, `allocate_s25`, `allocate_s26`, `allocate_s27`, `allocate_s28`, `allocate_s29`, `allocate_s30`, `allocate_s31`, `allocate_s32`, `allocate_s33`, `allocate_s34`, `allocate_s35`, `allocate_s36`, `allocate_s37`, `allocate_s38`, `allocate_s39`, `allocate_s40`, `allocate_s41`, `allocate_s42`, `allocate_s43`, `allocate_s44`, `allocate_s45`, `allocate_s46`, `allocate_s47`, `allocate_s48`, `allocate_s49`, `allocate_s50`) VALUES ('".date("Y-m-d")."', '".$cat_ref."', '".$cut_ref."', '".$order."', '1', '0', '1', '0', '0', '0', '0', '0', '0', '0', '1', '0000-00-00 00:00:00', 'Normal', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0')"; 
					$sql_resulta=mysqli_query( $link, $sqla) or exit(message_sql());
					$allo_ref=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
					$sql32="select sum(p_s01*p_plies) as s01,sum(p_s02*p_plies) as s02,sum(p_s03*p_plies) as s03,sum(p_s04*p_plies) as s04,sum(p_s05*p_plies) as s05,sum(p_s06*p_plies) as s06,sum(p_s07*p_plies) as s07,sum(p_s08*p_plies) as s08,sum(p_s09*p_plies) as s09,sum(p_s10*p_plies) as s10,sum(p_s11*p_plies) as s11,sum(p_s12*p_plies) as s12,sum(p_s13*p_plies) as s13,sum(p_s14*p_plies) as s14,sum(p_s15*p_plies) as s15,sum(p_s16*p_plies) as s16,sum(p_s17*p_plies) as s17,sum(p_s18*p_plies) as s18,sum(p_s19*p_plies) as s19,sum(p_s20*p_plies) as s20,sum(p_s21*p_plies) as s21,sum(p_s22*p_plies) as s22,sum(p_s23*p_plies) as s23,sum(p_s24*p_plies) as s24,sum(p_s25*p_plies) as s25,sum(p_s26*p_plies) as s26,sum(p_s27*p_plies) as s27,sum(p_s28*p_plies) as s28,sum(p_s29*p_plies) as s29,sum(p_s30*p_plies) as s30,sum(p_s31*p_plies) as s31,sum(p_s32*p_plies) as s32,sum(p_s33*p_plies) as s33,sum(p_s34*p_plies) as s34,sum(p_s35*p_plies) as s35,sum(p_s36*p_plies) as s36,sum(p_s37*p_plies) as s37,sum(p_s38*p_plies) as s38,sum(p_s39*p_plies) as s39,sum(p_s40*p_plies) as s40,sum(p_s41*p_plies) as s41,sum(p_s42*p_plies) as s42,sum(p_s43*p_plies) as s43,sum(p_s44*p_plies) as s44,sum(p_s45*p_plies) as s45,sum(p_s46*p_plies) as s46,sum(p_s47*p_plies) as s47,sum(p_s48*p_plies) as s48,sum(p_s49*p_plies) as s49,sum(p_s50*p_plies) as s50 from $bai_pro3.plandoc_stat_log where org_doc_no in (".$docslist.") and order_tid='".$order."'";
					$sql_resultx32=mysqli_query( $link, $sql32) or exit(message_sql()); 
					while($sql_rowx32=mysqli_fetch_array($sql_resultx32)) 
					{
						for($ik=0;$ik<sizeof($sizes_array);$ik++)
						{
							if($sql_rowx32[$sizes_array[$ik]]>0)
							{
								$sqly="update $bai_pro3.allocate_stat_log set allocate_".$sizes_array[$ik]."='".$sql_rowx32[$sizes_array[$ik]]."' where tid='".$allo_ref."'"; 
								mysqli_query( $link, $sqly) or exit(message_sql());
							}
						}	
					}
					$sqly="update $bai_pro3.plandoc_stat_log set allocate_ref='".$allo_ref."' where order_tid='".$order."' and org_doc_no in (".$docslist.")"; 
					mysqli_query( $link, $sqly) or exit(message_sql()); 
				}
				
				//Cat Stat log allocation	
				$sqlx65="select * from $bai_pro3.cat_stat_log where tid=$cat_ref"; 
				$sql_resultx65=mysqli_query( $link, $sqlx65) or exit(message_sql()); 
				while($sql_rowx=mysqli_fetch_array($sql_resultx65)) 
				{ 
					$sql1="SELECT order_del_no,order_col_des,order_tid FROM $bai_pro3.`mix_temp_desti` WHERE cat_ref=".$cat_ref." GROUP BY order_tid ORDER BY order_tid*1"; 
					$sql_result1=mysqli_query( $link, $sql1) or exit(message_sql()); 
					while($sql_row1=mysqli_fetch_array($sql_result1)) 
					{ 
						$tid_new_n=str_replace($order_sch,$sql_row1["order_del_no"],$sql_rowx['order_tid2']);
						$sqlz="select * from $bai_pro3.cat_stat_log where order_tid='".$sql_row1["order_tid"]."' and order_tid2='".$tid_new_n."'";
						$sql_resultz=mysqli_query($link, $sqlz) or exit(message_sql());
						
						while($sql_rowz=mysqli_fetch_array($sql_resultz))
						{
							$tid=$sql_rowz['tid'];
							$order_tid_sub=$sql_rowz['order_tid'];
						}
						$sqly="update $bai_pro3.allocate_stat_log set cat_ref=".$tid." where order_tid='".$order_tid_sub."' and cat_ref=".$cat_ref.""; 
						mysqli_query($link, $sqly) or exit(message_sql());
						
						$sqly="update $bai_pro3.plandoc_stat_log set cat_ref=$tid where order_tid='$order_tid_sub' and cat_ref=".$cat_ref."";
						mysqli_query($link, $sqly) or exit(message_sql());
						
						$sqly="update $bai_pro3.cat_stat_log set category='".$sql_rowx['category']."',purwidth='".$sql_rowx['purwidth']."',gmtway='".$sql_rowx['gmtway']."',date='".$sql_rowx['date']."',lastup='".$sql_rowx['lastup']."',strip_match='".$sql_rowx['strip_match']."',gusset_sep='".$sql_rowx['gusset_sep']."',patt_ver='".$sql_rowx['patt_ver'].
						"',binding_consumption='".$sql_rowx['binding_consumption']."' where tid=$tid and order_tid2='".$tid_new_n."'";
						mysqli_query($link, $sqly) or exit(message_sql()); 			   
					}
				}
				
				if(sizeof($cat_id_ref)==sizeof($ready_cat_ref))
				{				
					$sqlx="update $bai_pro3.bai_orders_db set order_joins='2' where order_del_no='$order_sch' and order_col_des='".$color."'"; 
					mysqli_query( $link, $sqlx) or exit(message_sql()); 
					 
					$sqlx="update $bai_pro3.bai_orders_db_confirm set order_joins='2' where order_del_no='$order_sch' and order_col_des='".$color."'"; 
					mysqli_query( $link, $sqlx) or exit(message_sql()); 
				}
				
				if(sizeof($pending_cat_ref)>0)
				{
					echo '<script type="text/javascript">document.getElementById("loading-image").style.display = "none";</script>';
					echo " <div class='alert alert-warning alert-dismissible'> Below categories need to complete Lay plan for Full Order.<br>";
					for($iiij=0;$iiij<sizeof($pending_cat_ref);$iiij++)
					{
						echo "Order Id ===> ".$pending_cat_order[$iiij]." / Category ===> ".$pending_cat_ref_type[$iiij]."<br>";
					}
					echo "</div>";
				}		
				echo "<br><br>";
				if(sizeof($pend_order)>0)
				{
					echo '<script type="text/javascript">document.getElementById("loading-image").style.display = "none";</script>';
					echo " <div class='alert alert-info alert-dismissible'> For Below categories still Lay plan not started.<br>";
					for($iiik=0;$iiik<sizeof($pend_order);$iiik++)
					{
						echo "Order Id ===> ".$pend_order[$iiik]." / Category ===> ".$pend_order_type[$iiik]."<br>";
					}
					echo "</div>";
				}				
			}			
		}		
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
		function Redirect() {
			location.href = \"".getFullURLLevel($_GET['r'], 'orders_sync.php',1,'N')."&color=$color&style=$style&schedule=$order_sch&club_status=2\";
			}
		</script>";		
	} 
	else 
	{ 		
		echo "</div>";	
		if(sizeof($pending_cat_ref)>0)
		{
			echo '<script type="text/javascript">document.getElementById("loading-image").style.display = "none";</script>';
			echo " <div class='alert alert-warning alert-dismissible'> Below categories need to complete Lay plan for Full Order.<br>";
			for($iiij=0;$iiij<sizeof($pending_cat_ref);$iiij++)
			{
				echo "Order Id ===> ".$pending_cat_order[$iiij]." / Category ===> ".$pending_cat_ref_type[$iiij]."<br>";
			}
			echo "</div>";
		}		
		echo "<br><br>";
		if(sizeof($pend_order)>0)
		{
			echo '<script type="text/javascript">document.getElementById("loading-image").style.display = "none";</script>';
			echo " <div class='alert alert-info alert-dismissible'> For Below categories still Lay plan not started.<br>";
			for($iiik=0;$iiik<sizeof($pend_order);$iiik++)
			{
				echo "Order Id ===> ".$pend_order[$iiik]." / Category ===> ".$pend_order_type[$iiik]."<br>";
			}
			echo "</div>";
		}	
	} 
	mysqli_commit($link);
}
	catch(Exception $e)
	{
		mysqli_rollback($link);
	}
}
?>
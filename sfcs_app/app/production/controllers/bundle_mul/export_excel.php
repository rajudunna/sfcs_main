
<?php
error_reporting(0);
include("dbconf.php");

if($_GET['flag']=='mini_orders')
{

	$style_code=$_GET['style'];
	$schedule=$_GET['schedule'];
	$miniwise_qnty=0;
	$table='';	
	$minisizes_sum=array();
	$sizes_sum=array();
	$stylecode = echo_title("brandix_bts.tbl_orders_style_ref","product_style","id",$style_code,$link);
	//getting schedule
	$schedule_result = echo_title("brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
	//getting carton qty
	$qry_cartonqty_result = echo_title("brandix_bts.tbl_carton_ref","carton_tot_quantity","style_code",$style_code,$link);
	//$table.= $qry_cartonsizes."</br>";
	$sql121="select zfeature from bai_pro3.bai_orders_db where order_del_no=".$schedule_result." ";
	$sql_result121=mysqli_query($link, $sql121) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row121=mysqli_fetch_array($sql_result121))
	{
		$c_block=$row121['zfeature'];
	}
	$sql="select group_concat(distinct(ref_size_name) order by ref_size_name) as size_id,group_concat(distinct(size_title) order by ref_size_name) as size_name from tbl_orders_sizes_master where parent_id in (SELECT id FROM `tbl_orders_master` WHERE ref_product_style =$style_code and `product_schedule`=$schedule_result) ORDER BY `ref_size_name` ASC";
	//$table.= $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($sql_result))
	{
		$max_size=$row['size_id'];
		$size_title=$row['size_name'];
	}
	$sizesarray=explode(",",$max_size);
	$sizesnames_array=explode(",",$size_title);
	
	$val= sizeof($sizesarray)+2;
	$val1=round($val/2);
	$val2=$val-$val1;
				//echo '<div style="background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin-left: 1.5%;margin-right: 0.5%;margin-bottom:3%; padding: 5px;">';
				
				$table.= "<div id='test'><table width=\"80%\" height=\"75\" border=\"1px\">";
				$table.= "<tr><th colspan=".$val." ><center><b>Orders</b></center></th></tr>";
				$table.= "<tr><th colspan=".$val1.">Style :<b>".$stylecode."</b></th><th colspan=".$val2.">Schedule :<b>".$schedule_result."</b><br></b>Country Block :<b>".$c_block."</b></th></tr>";
				$table.= "<tr><th>Color</th>";
				for($i=0;$i<sizeof($sizesarray);$i++)
				{		
					if($sizesnames_array[$i] !='')
					{	
						$table.= "<th><u>".$sizesnames_array[$i]."</u></th>";
					}
					else
					{	
						$table.= "<th><u>".$get_siz_nam."</u></th>";
					}
				}
				$table.= "<th>Total</th></tr>";
				$sql = "SELECT md.order_col_des as color,sum(md.order_quantity) as Qnty,";
				for($i=0;$i<sizeof($sizesarray);$i++)
				{
					$temp_array[]=" sum(if(ref_size_name='".$sizesarray[$i]."',md.order_quantity,0)) as size".$sizesarray[$i]."_qty ";
				
				}
				$sql.=implode(",",$temp_array);
				$sql.=" FROM `tbl_orders_sizes_master` md where parent_id in (SELECT id FROM `tbl_orders_master` WHERE ref_product_style =$style_code and `product_schedule`=$schedule_result)";
				$sql1=$sql." group by color order by color ASC";
				//echo $sql1."</br>";
				$sql_result12=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row2=mysqli_fetch_array($sql_result12))
				{
					$table.= "<tr>";
					$table.= "<td>".$row2['color']."</td>";
					$cnt=0;
					for($j=0;$j<sizeof($sizesarray);$j++)
					{
						if($sizesnames_array[$j]!='')
						{
							$qry_vallidate_size2="select id,ref_size_name from tbl_orders_sizes_master where parent_id in (SELECT id FROM `tbl_orders_master` WHERE ref_product_style =$style_code and `product_schedule`=$schedule_result) and order_col_des='".$row2['color']."' and size_title='".$sizesnames_array[$j]."'";
							$sql_result22=mysqli_query($link, $qry_vallidate_size2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
							//echo $qry_vallidate_size2."<br>";
							while($row22=mysqli_fetch_array($sql_result22))
							{
								$cnt=$row22['id'];
								$size_id_n=$row22['ref_size_name'];
							}
							
							if((0<$cnt) || ($cnt!=''))
							{		
								$table.= "<td>".$row2['size'.$size_id_n.'_qty']."</td>";
							}
							else
							{
								$table.= "<td>0</td>";
							}
							//$minisizes_sum[$i]+=$r['size'.$size_id_n.'_qty'];
						}
						else
						{
							$table.= "<td>".$row2['size'.$sizesarray[$j].'_qty']."</td>";
							//$minisizes_sum[$i]+=$r['size'.$sizesarray[$i].'_qty'];
						}
					$cnt=0;	
					}
					$table.= "<td>".$row2['Qnty']."</td>";
					$table.= "</tr>";
					
				}	
						
				
				$table.= "</table></div>";
				
	$temp_array=array();
	$miniord_ref = echo_title("brandix_bts.tbl_min_ord_ref","group_concat(id)","ref_product_style=$style_code and ref_crt_schedule",$schedule,$link);
	$rowcount = "SELECT md.docket_number,md.mini_order_ref,md.mini_order_num,md.color,sum(md.quantity) as Qnty,";
	for($i=0;$i<sizeof($sizesarray);$i++)
	{
		$temp_array[]=" sum(if(size='".$sizesarray[$i]."',md.quantity,0)) as size".$sizesarray[$i]."_qty ";
	}
	$rowcount.=implode(",",$temp_array);
	$rowcount.=" FROM `tbl_miniorder_data` md where `mini_order_ref` in($miniord_ref)";
	$rowcount1=$rowcount." group by md.color,md.mini_order_num order by md.mini_order_num,md.color ASC";
		
	//$table.= $rowcount1."<br>";
	$last_min = echo_title("brandix_bts.tbl_miniorder_data","max(mini_order_num)","mini_order_ref ",$miniord_ref,$link);
	$color_cnt = echo_title("brandix_bts.tbl_miniorder_data","count(distinct color)"," mini_order_num=".$last_min." and mini_order_ref ",$miniord_ref,$link);
	$sql_result1=mysqli_query($link, $rowcount1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$count=mysqli_num_rows($sql_result1);
	if($count>0)
	{
		//$table.= "<table  width=\"100%\" style=\"background-color: #F2F2F2 ;\">";
		$old_miniorder=0;
		$miniorder_count=0;
		$miniorder_old=0;
		$tot_qnty=0;
		//$test=1;
		$temp=1;
		$col=0;
		while($r=mysqli_fetch_array($sql_result1))
		{
			$miniorder=$r['mini_order_num'];
			//$table.= $miniorder_count."--".$temp."<br>";
			$tp=$r['docket_number'];
			$type_d=substr($tp,0,1);
			//echo $type_d."<br>";
			if($type_d == 'R')
			{
				$name='-Recut';
			}
			else
			{
				$name='';
			}
			if(($miniorder_count==0) && $temp==1)
			{
				//$table.= "<tr><td>";
			}
			//$id=$r['id'];
			if($old_miniorder!=0)
			{	
				if($miniorder!=$old_miniorder)
				{	
					//$size_total=$sizes_sum[$i];
					$table.="<tr><td><b>Total Cartons : <u>".round($miniwise_qnty/$qry_cartonqty_result,2)."</u></b></td>";
					for($i=0;$i<=sizeof($sizesarray)-1;$i++)
					{		
						$table.="<td><b><u>".$minisizes_sum[$i]."</u></b></td>";
						$minisizes_sum[$i]=0;
					}
					$table.="<td><b><u>".$miniwise_qnty."</u></b></td>";
					$table.="</tr>";
					
					$minisizes_sum[$i]=0;
					$miniwise_qnty=0;
					$miniorder_count++;
					
					$table.= "</table>";
					//$table.= "</td><td>";
					//$table.= "</p>";
					$table.= "</div>";
					$col=0;
					
				}
			
			}
			
			if($miniorder!=$old_miniorder)
			{
				$table.= '<div id="rk_test" style="background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 5px; padding: 5px;">';
				$table.= "<table width=\"400\" height=\"75\" border=\"1px\" id='rk'>";
				$table.= "<tr><td colspan=6  ><center><h3 style=\"background-color: #A9BCF5 ;\">Mini order No:".$miniorder.$name."</h3></center></td></tr>";
				$table.= "<tr><th>Color</th>";
				for($i=0;$i<sizeof($sizesarray);$i++)
				{		
					if($sizesnames_array[$i] !='')
					{	
						$table.= "<th><u>".$sizesnames_array[$i]."</u></th>";
					}
					else
					{	
						$get_siz_nam=echo_title("brandix_bts.tbl_orders_size_ref","size_name","id",$sizesarray[$i],$link);
						$table.= "<th><u>".$get_siz_nam."</u></th>";
					}
				}
				$table.= "<th>Total</th>";
				$table.= "</tr>";
			}
			$table.="<tr><td>".$r['color']."</td>";
			$col++;
			$cnt=0;
			for($i=0;$i<sizeof($sizesarray);$i++)
			{
				if($sizesnames_array[$i]!='')
				{
					$qry_vallidate_size="select id,ref_size_name from tbl_orders_sizes_master where parent_id in (SELECT id FROM `tbl_orders_master` WHERE ref_product_style =$style_code and `product_schedule`=$schedule_result) and order_col_des='".$r['color']."' and size_title='".$sizesnames_array[$i]."'";
					$sql_result2=mysqli_query($link, $qry_vallidate_size) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					//$table.= $qry_vallidate_size."</br>";
					while($row2=mysqli_fetch_array($sql_result2))
					{
						$cnt=$row2['id'];
						$size_id_n=$row2['ref_size_name'];
					}
					if((0<$cnt) || ($cnt!=''))
					{		
						$table.= "<td>".$r['size'.$size_id_n.'_qty']."</td>";
					}
					else
					{
						$table.= "<td>0</td>";
					}
					$minisizes_sum[$i]+=$r['size'.$size_id_n.'_qty'];
				}
				else
				{
					$table.= "<td>".$r['size'.$sizesarray[$i].'_qty']."</td>";
					$minisizes_sum[$i]+=$r['size'.$sizesarray[$i].'_qty'];
				}
				$sizes_sum[$i]+=$r['size'.$sizesarray[$i].'_qty'];
				$cnt=0;
			}
			$table.= "<td><b>".$r['Qnty']."</b></td>";
			$table.= "</tr>";
			$temp++;
			$old_miniorder=$miniorder;
			$tot_qnty=$tot_qnty+$r['Qnty'];
			$miniwise_qnty+=$r['Qnty'];
			//echo $old_miniorder."--".$last_min."--".$color_cnt."--".$col."<br>";
			if(($old_miniorder==$last_min) && ($color_cnt==$col))
			{
				//echo $color_cnt."--".$col+1;
				$table.= "<td><b><u>Total Cartons :".round($miniwise_qnty/$qry_cartonqty_result,2)."</u></b></td>";
				for($i=0;$i<=sizeof($sizesarray)-1;$i++)
				{		
					$table.= "<td><b><u>".$minisizes_sum[$i]."</u></b></td>";
					$minisizes_sum[$i]=0;
				}
				 $table.= "<td><b><u>".$miniwise_qnty."</u></b></td>";
				$table.= "</tr>";
				
				//$minisizes_sum[$i]=0;
				//$miniwise_qnty=0;
				//$miniorder_count++;
				
				$table.= "</table>";
				//echo "</td><td>";
				//echo "</p>";
				$table.= "</div>";
			}
			
			
			if($miniorder_count==3)
			{
				//$table.= "check";
				//$table.= "</tr>";
				//$table.= "</tr>";
				$miniorder_count=0;
				$temp=1;
			}
		}
		
		
	}
	//$table.= "</table>";

}	
if($_GET['flag']=='bundle_alloc')
{
	$style_code=$_GET['style'];
	$schedule=$_GET['schedule'];
	$miniord_ref = echo_title("brandix_bts.tbl_min_ord_ref","group_concat(id)","ref_product_style=$style_code and ref_crt_schedule",$schedule,$link);
	$bundles = echo_title("brandix_bts.tbl_miniorder_data","count(bundle_number)","mini_order_ref",$miniord_ref,$link);
	
	$stylecode = echo_title("brandix_bts.tbl_orders_style_ref","product_style","id",$style_code,$link);
	//getting schedule
	$schedule_result = echo_title("brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
	$c_block = echo_title("bai_pro3.bai_orders_db_confirm","zfeature","order_del_no",$schedule_result,$link);
	$carton_ref = echo_title("brandix_bts.tbl_carton_ref","id","ref_order_num",$schedule,$link);
	//echo $carton_ref."<br>";
	//getting carton qty
	$sql_cart="SELECT parent_id,color,GROUP_CONCAT(ref_size_name ORDER BY ref_size_name SEPARATOR \"-\" ) AS sizes,GROUP_CONCAT(quantity SEPARATOR \"-\") as ratio FROM tbl_carton_size_ref WHERE parent_id IN ($carton_ref) GROUP BY color";
	//echo $sql_cart."<br>";
	$sql_result1=mysqli_query($link, $sql_cart) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($sql_result1))
	{
		$col_ratio[$row1['color']]=$row1['ratio'];
	}
	$sql2="SELECT order_col_des AS color,COUNT(ref_size_name) AS cnt,GROUP_CONCAT(ref_size_name ORDER BY ref_size_name) AS size_code,GROUP_CONCAT(size_title ORDER BY ref_size_name) AS size_title FROM brandix_bts.tbl_orders_sizes_master WHERE parent_id in (".$schedule.") GROUP BY parent_id,order_col_des ORDER BY cnt DESC LIMIT 1";
	//echo $sql."<br>";
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row2=mysqli_fetch_array($sql_result2))
	{	
		$size_tit=$row2['size_title'];
		$size_code=$row2['size_code'];
	}
	$sizes_tit=explode(",",$size_tit);
	$sizes_code=explode(",",$size_code);
	
	for($i=0;$i<sizeof($sizes_code);$i++)
	{		
		$query.= "sum(if(size = '".$sizes_code[$i]."',quantity,0)) as size$sizes_code[$i],";
	}
	
	$sql1="select distinct mini_order_num from brandix_bts.tbl_miniorder_data where mini_order_ref=".$miniord_ref." and planned_module!=''";
	//echo $sql1."<br>";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	while($row1=mysqli_fetch_array($sql_result1))
	{		
		$total=0;$total1=0;
		$val1=sizeof($sizes_code);
		$query_n=substr($query,0,-1);
		$sql2="select planned_module,color,$query_n from brandix_bts.tbl_miniorder_data where mini_ordeR_ref=".$miniord_ref." and mini_order_num='".$row1['mini_order_num']."' group by planned_module,color";
		//echo $sql2."<br>";
		//exit;
		$sql_result=mysqli_query($link, $sql2) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$table.= "<table width=\"100%\" height=\"75\" border=\"1px\">";
		//echo "<tr><th><center><b>Orders</b></center></th></tr>";
		$table.= "<tr><th>Style :<b>".$stylecode."</b></th><th>Schedule :<b>".$schedule_result."</b>/<b>".$c_block."</b></th><th>Mini order :<b>".$row1['mini_order_num']."</b></th><th colspan=$val1>Sizes</th><th rowspan=2>Total</th></tr>";
		$table.= "<tr><th>Line No</b></th>";
		$table.= "<th>Color</th>";
		$table.= "<th>Carton ratio</th>";
		
		for($i=0;$i<sizeof($sizes_code);$i++)
		{		
			//echo "<th><u>size_tit[".$col[$i]."][".$size_codes[$i]."].</u></th>";
			$table.= "<th><u>".$sizes_tit[$i]."</u></th>";
		}
		$table.= "</tr>";
		while($row2=mysqli_fetch_array($sql_result))
		{	
			$total=0;
			$table.= "<td>".$row2['planned_module']."</td>";
			$table.= "<td>".$row2['color']."</td>";
			$table.= "<td>'".$col_ratio[$row2['color']]."'</td>";
			for($j=0;$j<sizeof($sizes_code);$j++)
			{
				$val="size".$sizes_code[$j];
				$table.= "<td>".$row2[$val]."</td>";
				$total+=$row2['size'.$sizes_code[$j]];
			}
			//$total[]=$total;
			$table.= "<td>".$total."</td>";
			$table.= "</tr>";
				
		}
		$table.= "<tr><td colspan=3>Total</td>";
		$sql3="select planned_module,color,$query_n from brandix_bts.tbl_miniorder_data where mini_ordeR_ref=".$miniord_ref." and mini_order_num='".$row1['mini_order_num']."'";
		$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row3=mysqli_fetch_array($sql_result3))
		{
			for($j=0;$j<sizeof($sizes_code);$j++)
			{
				$val="size".$sizes_code[$j];
				$table.= "<td>".$row3[$val]."</td>";
				$total1+=$row3[$val];
			}
			$table.= "<td>".$total1."</td><tr>";
		
		}
		$table.= "<tr></tr>";
	}	
	
	
	

}
$table.= "</table>";
		

		header("Content-type: application/x-msdownload"); 
		# replace excelfile.xls with whatever you want the filename to default to
		if($_GET['flag']=='bundle_alloc')
		{
			header("Content-Disposition: attachment; filename=Bundle_Allocation_".trim($stylecode)."_".trim($schedule_result).".xls");
		}
		elseif($_GET['flag']=='scanned_qty') 
		{
			header("Content-Disposition: attachment; filename=scanned_quantity.xls");
		}
		elseif($_GET['flag']=='mini_orders') 
		{
			header("Content-Disposition: attachment; filename=Mini_orders_".trim($stylecode)."_".trim($schedule_result).".xls");
		}		
		header("Pragma: no-cache");
		//header("Expires: 0");
		echo $table;
		?>
<style>

#rk {
  display: inline-table;
  width: 100%;
}
div#rk_test {
    width: 30%;
}
</style>

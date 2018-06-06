<?php 
// include("../../../packing/dbconf2.php"); 
// include("../../../packing/functions.php"); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
?>	

<?php
set_time_limit("5000000");

if($_GET['ops']==1)
{
	$mini_order_id=$_GET['mini_order_num'];
	$mini_order_ref_id=$_GET['mini_order_ref'];
	?>
	<?php


	$html = '<html><head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style>
	body {font-family: arial;
		font-size: 20px;
	}

	.new_td
	{
		font-size:20px;
	}

	.new_td2
	{
		font-size:22px;
		font-weight: bold;
	}

	.new_td3
	{
		font-size:22px;
		font-weight: bold;
	}
	.new_td4
	{
		font-size:22px;
		font-weight: bold;
	}

	table
	{
		margin-left:auto;
		margin-right:auto;
		margin-top:auto;
		margin-bottom:auto;
	}
	@page {
	margin-top: 10px; 

	}

	</style>
	</head>
	<body>';

	$operation_id=array();
	$operation_code=array();
	
	$sql="SELECT $brandix_bts.tbl_min_ord_ref.ref_crt_schedule AS sch_id FROM $brandix_bts.`tbl_miniorder_data` AS tbl_miniorder_data 
	LEFT JOIN $brandix_bts.tbl_min_ord_ref AS tbl_min_ord_ref ON tbl_min_ord_ref.id=tbl_miniorder_data.mini_order_ref 
	where $brandix_bts.tbl_miniorder_data.mini_order_ref='".$mini_order_ref_id."' group by sch_id";
	$sql_result=mysql_query($sql,$link) or exit("Sql Error--2".mysql_error());
	while($rowval=mysql_fetch_array($sql_result))
	{
		$sch_id=$rowval['sch_id'];
		//$split_qty=$rowval['split_qty'];
	}
	
	$sql="SELECT * FROM $brandix_bts.tbl_orders_master WHERE id='".$sch_id."'";
	$sql_result=mysql_query($sql,$link) or exit("Sql Error--2".mysql_error());
	while($rowval=mysql_fetch_array($sql_result))
	{
		$emb_stat=$rowval['emb_status'];
	}
	
	//$emb_stat=1;
	if($emb_stat==1)
	{
		$sql1="select * from $brandix_bts.tbl_orders_ops_ref where default_operation='YES' and id <5 order by ops_order*1";
		$sql2="select * from $brandix_bts.tbl_orders_ops_ref where default_operation='YES' and id >5 order by ops_order*1";
		$sql_result2=mysql_query($sql2,$link) or exit("Sql Error--1".mysql_error());
		while($row21=mysql_fetch_array($sql_result2))
		{
			$operation_id1[]=$row21['id'];
			$operation_code1[]=$row21['operation_code'];
		}
	}
	else if($emb_stat==0)
	{
		$sql1="select * from $brandix_bts.tbl_orders_ops_ref where default_operation='YES' and id in (1,2,3,4) order by ops_order*1";
	}
	else if($emb_stat==2)
	{
		$sql1="select * from $brandix_bts.tbl_orders_ops_ref where default_operation='YES' and id not in (6,7) order by ops_order*1";
	}	
	$sql_result1=mysql_query($sql1,$link) or exit("Sql Error--1".mysql_error());
	while($row1=mysql_fetch_array($sql_result1))
	{
		$operation_id[]=$row1['id'];
		$operation_code[]=$row1['operation_code'];
	}
	
	$sql="SELECT $brandix_bts.tbl_orders_style_ref.id AS style_id,$brandix_bts.tbl_orders_style_ref.product_style,$brandix_bts.tbl_orders_master.product_schedule,
	 $brandix_bts.tbl_miniorder_data.id,$brandix_bts.tbl_miniorder_data.mini_order_ref, $brandix_bts.tbl_miniorder_data.mini_order_num,
	 $brandix_bts.tbl_miniorder_data.bundle_number AS bundle,$brandix_bts.tbl_miniorder_data.cut_num,$brandix_bts.tbl_miniorder_data.color,
	 $brandix_bts.tbl_miniorder_data.color AS color_code,$brandix_bts.tbl_orders_sizes_master.size_title, $brandix_bts.sizes.size_name AS size,
	 $brandix_bts.sizes.id AS size_id,$brandix_bts.tbl_cut_master.col_code as col_code,$brandix_bts.tbl_miniorder_data.bundle_number,$brandix_bts.tbl_miniorder_data.quantity AS quantity,
	 $brandix_bts.tbl_miniorder_data.docket_number AS docket_number,$brandix_bts.tbl_miniorder_data.split_shade as shade_val FROM $brandix_bts.`tbl_miniorder_data` AS tbl_miniorder_data 
	 LEFT JOIN $brandix_bts.tbl_orders_size_ref sizes ON sizes.id=$brandix_bts.tbl_miniorder_data.size 
	 LEFT JOIN $brandix_bts.tbl_min_ord_ref AS tbl_min_ord_ref ON tbl_min_ord_ref.id=$brandix_bts.tbl_miniorder_data.mini_order_ref 
	 LEFT JOIN $brandix_bts.`tbl_orders_master` AS tbl_orders_master ON `tbl_orders_master`.`id`=$brandix_bts.tbl_min_ord_ref.ref_crt_schedule 
	 LEFT JOIN $brandix_bts.tbl_orders_style_ref AS tbl_orders_style_ref ON tbl_orders_style_ref.id=$brandix_bts.tbl_min_ord_ref.ref_product_style 
	 LEFT JOIN $brandix_bts.tbl_cut_master ON $brandix_bts.tbl_miniorder_data.docket_number=$brandix_bts.tbl_cut_master.doc_num 
	LEFT JOIN $brandix_bts.`tbl_orders_sizes_master` AS tbl_orders_sizes_master ON `tbl_orders_master`.`id`=$brandix_bts.tbl_orders_sizes_master.parent_id AND tbl_miniorder_data.color=$brandix_bts.tbl_orders_sizes_master.order_col_des AND tbl_miniorder_data.size=$brandix_bts.tbl_orders_sizes_master.ref_size_name
	where $brandix_bts.tbl_miniorder_data.mini_order_num=".$mini_order_id." and $brandix_bts.tbl_miniorder_data.mini_order_ref='".$mini_order_ref_id."' 
	 group by $brandix_bts.tbl_miniorder_data.bundle_number order by $brandix_bts.tbl_miniorder_data.id*1 ";
	//echo $sql."<br>";
	$sql_result=mysql_query($sql,$link) or exit("Sql Error--1".mysql_error());
	while($row2=mysql_fetch_array($sql_result))
	{	
		$style_id=$row2['style_id'];
		$style=$row2['product_style'];
		$schedule=$row2['product_schedule'];
		$color=$row2['color'];
		$cut_code1=$row2['cut_num'];
		$shade = $row2['shade_val'];
		//$cut_code=$row2['size_title'];
		$color_code=$row2['col_code'];
		//$cut_code="A001";
		$cut_code=chr($color_code).leading_zeros($cut_code1, 3);
		
		if($emb_stat==1)
		{
			$html.= '<table class="table table-bordered"><tr><td><table class="table table-bordered"><tr><td>Min No: </td><td>'.$row2['mini_order_num'].'</td>
			<td >Stab here: </td><td colspan=2><img src="round.jpg" style="width:40px;height:40px;"></td></tr>';
			$html.= '<tr><td>Color:</td><td colspan=3 class="new_td2">'.$row2['color'].'</td></tr>';
			$html.= '<tr><td>Style:</td><td class="new_td3">'.$style.'</td><td>Schedule:</td><td class="new_td3">'.$schedule.'</td></tr>';
			$html.= '<tr><td colspan=4> Size :<b class="new_td4">'.$row2['size_title'].'</b>&nbsp;Cut :<b>'.$cut_code.'</b>&nbsp;Qty :<b>'.$row2['quantity'].'</b>&nbsp;S# :<b>'.$shade.'</b>&nbsp;</td></tr>';
			$html.='</table></td>
			<td width="37px" text-rotate="90" align="center">'.str_pad($row2['bundle'],7,"0",STR_PAD_LEFT).'</td></tr></table>';
			$html.='<pagebreak/>';
			
			for($jj=0;$jj<sizeof($operation_id1);$jj++)
			{
				$i=$operation_id1[$jj];
				$ops=$operation_code1[$jj];
				$barcode_value =str_pad($row2['bundle'],7,"0",STR_PAD_LEFT)."-".str_pad($i,2,"0",STR_PAD_LEFT);
				$html.= '<table class="table table-bordered"><tr><td><table class="table table-bordered"><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39"/ height="0.80" size="1.3" text="1"></td></tr>';
				//$html.= '<table><tr><td><table><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39" height="0.80" size="1.3" text="1"></td></tr>';
				$html.= '<tr><td colspan=4>S:<b>'.$style.'</b>#S:<b>'.$schedule.'</b>#B:<b>'.$row2['bundle'].'</b></td></tr>';
				//$html.= '<tr><td>Style: </td><td><b>'.$style.'</b></td><td>Schedule :</td><td><b>'.$schedule.'</b> </td></tr>';
				$html.= '<tr><td colspan=4>Cut#<b>'.$cut_code.'</b> size#<b>'.$row2['size_title'].'</b> Qty#<b>'.$row2['quantity'].'</b>Op# <b>'.$ops.'</b></td></tr>';
				//$html.= '<tr><td>Color</td><td class="new_td" colspan="4"><b>'.$color.'</b></td><td>M-'.$mini_order_id.'</td></tr></table></td><td width="37px" text-rotate="90" align="center">'.$barcode_value.'</td></tr></table>';
				$html.= '<tr><td colspan="4">Col# <b>'.substr($color,0,20).'</b></tr></table></td><td width="37px" text-rotate="90" align="center"><b>'.$barcode_value.'</b></td></tr></table>';
				$html.='<pagebreak/>';
				
			}	
		
		}
		
		$html.= '<table class="table table-bordered"><tr><td><table class="table table-bordered"><tr><td>Min No: </td><td>'.$row2['mini_order_num'].'</td>
		<td >Stab here: </td><td colspan=2><img src="round.jpg" style="width:40px;height:40px;"></td></tr>';
		$html.= '<tr><td>Color:</td><td colspan=3 class="new_td2">'.$row2['color'].'</td></tr>';
		$html.= '<tr><td>Style:</td><td class="new_td3">'.$style.'</td><td>Schedule:</td><td class="new_td3">'.$schedule.'</td></tr>';
		$html.= '<tr><td colspan=4> Size :<b class="new_td4">'.$row2['size_title'].'</b>&nbsp;Cut :<b>'.$cut_code.'</b>&nbsp;Qty :<b>'.$row2['quantity'].'</b>&nbsp;S# :<b>'.$shade.'</b>&nbsp;</td></tr>';
		
		$html.='</table></td>
		<td width="37px" text-rotate="90" align="center">'.str_pad($row2['bundle'],7,"0",STR_PAD_LEFT).'</td></tr></table>';
		$html.='<pagebreak/>';
		
		for($ii=0;$ii<sizeof($operation_id);$ii++)
		{
			$i=$operation_id[$ii];
			$ops=$operation_code[$ii];
			if($i==3)
			{
				$barcode_value =str_pad($row2['bundle'],7,"0",STR_PAD_LEFT)."-".str_pad($i,2,"0",STR_PAD_LEFT);
				$html.= '<table class="table table-bordered"><tr><td><table class="table table-bordered"><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39"/ height="0.80" size="1.3" text="1"></td></tr>';
				//$html.= '<table><tr><td><table><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39" height="0.80" size="1.3" text="1"></td></tr>';
				$html.= '<tr><td colspan=4>S:<b>'.$style.'</b>#S:<b>'.$schedule.'</b>#B:<b>'.$row2['bundle'].'</b></td></tr>';
				$html.= '<tr><td colspan=4>Cut#<b>'.$cut_code.'</b> size#<b>'.$row2['size_title'].'</b> Qty#<b>'.$row2['quantity'].'</b>Op# <b>'.$ops.'</b></td></tr>';
				//$html.= '<tr><td colspan=4>Cut#<b>'.$cut_code.'</b> size#<b>'.$row2['size_title'].'</b> Qty#<b>'.$row2['quantity'].'</b> Op : <b>'.$ops.'</b>PR # <img src="box_1.jpg" style="width:30px;height:30px;"></td></tr>';
				//$html.= '<tr><td>Color</td><td class="new_td" colspan="4"><b>'.$color.'</b></td><td>M-'.$mini_order_id.'</td></tr></table></td><td width="37px" text-rotate="90" align="center">'.$barcode_value.'</td></tr></table>';
				$html.= '<tr><td colspan="3">Col# <b>'.substr($color,0,20).'</b></td><td>PR # <img src="box_1.jpg" style="width:30px;height:30px;"></b></td></tr></table></td><td width="37px" text-rotate="90" align="center"><b>'.$barcode_value.'</b></td></tr></table>';
				$html.='<pagebreak/>';
			}
			elseif($i==4)
			{
				$barcode_value =str_pad($row2['bundle'],7,"0",STR_PAD_LEFT)."-".str_pad($i,2,"0",STR_PAD_LEFT);
				$html.= '<table class="table table-bordered"><tr><td><table class="table table-bordered"><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39"/ height="0.80" size="1.3" text="1"></td></tr>';
				//$html.= '<table><tr><td><table><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39" height="0.80" size="1.3" text="1"></td></tr>';
				$html.= '<tr><td colspan=4>S:<b>'.$style.'</b>#S:<b>'.$schedule.'</b>#B:<b>'.$row2['bundle'].'</b></td></tr>';
				$html.= '<tr><td colspan=4>Cut#<b>'.$cut_code.'</b> size#<b>'.$row2['size_title'].'</b> Qty#<b>'.$row2['quantity'].'</b>Op# <b>'.$ops.'</b></td></tr>';
				//$html.= '<tr><td colspan=4>Cut#<b>'.$cut_code.'</b> size#<b>'.$row2['size_title'].'</b> Qty#<b>'.$row2['quantity'].'</b> Op : <b>'.$ops.'</b>PR # <img src="box_1.jpg" style="width:30px;height:30px;"></td></tr>';
				//$html.= '<tr><td>Color</td><td class="new_td" colspan="4"><b>'.$color.'</b></td><td>M-'.$mini_order_id.'</td></tr></table></td><td width="37px" text-rotate="90" align="center">'.$barcode_value.'</td></tr></table>';
				$html.= '<tr><td colspan="3">Col# <b>'.substr($color,0,20).'</b></td><td>GR # <img src="box_1.jpg" style="width:30px;height:30px;"></b></td></tr></table></td><td width="37px" text-rotate="90" align="center"><b>'.$barcode_value.'</b></td></tr></table>';
				$html.='<pagebreak/>';
				
					
			}
			else
			{
				$barcode_value =str_pad($row2['bundle'],7,"0",STR_PAD_LEFT)."-".str_pad($i,2,"0",STR_PAD_LEFT);
				$html.= '<table class="table table-bordered"><tr><td><table class="table table-bordered"><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39"/ height="0.80" size="1.3" text="1"></td></tr>';
				//$html.= '<table><tr><td><table><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39" height="0.80" size="1.3" text="1"></td></tr>';
				$html.= '<tr><td colspan=4>S:<b>'.$style.'</b>#S:<b>'.$schedule.'</b>#B:<b>'.$row2['bundle'].'</b></td></tr>';
				//$html.= '<tr><td>Style: </td><td><b>'.$style.'</b></td><td>Schedule :</td><td><b>'.$schedule.'</b> </td></tr>';
				$html.= '<tr><td colspan=4>Cut#<b>'.$cut_code.'</b> size#<b>'.$row2['size_title'].'</b> Qty#<b>'.$row2['quantity'].'</b>Op# <b>'.$ops.'</b></td></tr>';
				//$html.= '<tr><td>Color</td><td class="new_td" colspan="4"><b>'.$color.'</b></td><td>M-'.$mini_order_id.'</td></tr></table></td><td width="37px" text-rotate="90" align="center">'.$barcode_value.'</td></tr></table>';
				$html.= '<tr><td colspan="4">Col# <b>'.substr($color,0,20).'</b></tr></table></td><td width="37px" text-rotate="90" align="center"><b>'.$barcode_value.'</b></td></tr></table>';
				$html.='<pagebreak/>';
			}
		}
			
	}
	$html.='</body></html>';
	$sql="update $brandix_bts.tbl_miniorder_data set mini_order_status=1 where mini_order_num=".$mini_order_id." and mini_order_ref='".$mini_order_ref_id."'";
	$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
}
if($_GET['ops']==2)
{
	$mini_order_num=$_GET['mini_order_num'];
	//$mini_order_ref_id=$_GET['mini_order_ref'];
	$doc_no=$_GET['doc_no'];
	$cut_code1=$_GET['cut_num'];
	$table_name="$bai_pro3.plandoc_stat_log";
	$sql11="select * from $table_name where org_doc_no='".$doc_no."'";
	$sql_result11=mysql_query($sql11,$link) or exit("Sql Error21".mysql_error());
	while($row1=mysql_fetch_array($sql_result11))
	{
		$doc_id[]=$row1['doc_no'];
		
	}
	
		
	?>
	<?php


	$html = '<html><head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style>
	body {font-family: arial;
		font-size: 20px;
	}

	.new_td
	{
		font-size:20px;
	}

	.new_td2
	{
		font-size:22px;
		font-weight: bold;
	}

	.new_td3
	{
		font-size:22px;
		font-weight: bold;
	}

	table
	{
		margin-left:auto;
		margin-right:auto;
		margin-top:auto;
		margin-bottom:auto;
	}
	@page {
	margin-top: 10px; 

	}

	</style>
	</head>
	<body>';

	$operation_id=array();
	$operation_code=array();
	//$table="bai_pro3.plandoc_stat_log"
	
	$sql="SELECT * from $brandix_bts.tbl_cut_master WHERE doc_num='".$doc_no."'";
	$sql_result=mysql_query($sql,$link) or exit("Sql Error--22".mysql_error());
	while($rowval=mysql_fetch_array($sql_result))
	{
		$sch_id=$rowval['ref_order_num'];
		$color_code=$rowval['col_code'];
		$cut_code1=$rowval['cut_num'];
		//$split_qty=$rowval['split_qty'];
	}
	
	
	$sql="SELECT * FROM $brandix_bts.tbl_orders_master WHERE id='".$sch_id."'";
	$sql_result=mysql_query($sql,$link) or exit("Sql Error--23".mysql_error());
	while($rowval=mysql_fetch_array($sql_result))
	{
		$emb_stat=$rowval['emb_status'];
	}
	
	//$emb_stat=1;
	if($emb_stat==1)
	{
		$sql1="select * from $brandix_bts.tbl_orders_ops_ref where default_operation='YES' and id <5 order by ops_order*1";
		$sql2="select * from $brandix_bts.tbl_orders_ops_ref where default_operation='YES' and id >5 order by ops_order*1";
		$sql_result2=mysql_query($sql2,$link) or exit("Sql Error--1".mysql_error());
		while($row21=mysql_fetch_array($sql_result2))
		{
			$operation_id1[]=$row21['id'];
			$operation_code1[]=$row21['operation_code'];
		}
	}
	else if($emb_stat==0)
	{
		$sql1="select * from $brandix_bts.tbl_orders_ops_ref where default_operation='YES' and id in (1,2,3,4) order by ops_order*1";
	}
	else if($emb_stat==2)
	{
		$sql1="select * from $brandix_bts.tbl_orders_ops_ref where default_operation='YES' and id not in (6,7) order by ops_order*1";
	}	
	$sql_result1=mysql_query($sql1,$link) or exit("Sql Error--1".mysql_error());
	while($row1=mysql_fetch_array($sql_result1))
	{
		$operation_id[]=$row1['id'];
		$operation_code[]=$row1['operation_code'];
	}
	
	$sql_result1=mysql_query($sql1,$link) or exit("Sql Error--1".mysql_error());
	while($row1=mysql_fetch_array($sql_result1))
	{
		$operation_id[]=$row1['id'];
		$operation_code[]=$row1['operation_code'];
	}
	//for($j=0;$j<sizeof($doc_no);$j++)
	//{
		$sql="SELECT $brandix_bts.tbl_orders_style_ref.id AS style_id,$brandix_bts.tbl_orders_style_ref.product_style,$brandix_bts.tbl_orders_master.product_schedule,
		 $brandix_bts.tbl_miniorder_data.id,$brandix_bts.tbl_miniorder_data.mini_order_ref, $brandix_bts.tbl_miniorder_data.mini_order_num,
		 $brandix_bts.tbl_miniorder_data.bundle_number AS bundle,$brandix_bts.tbl_miniorder_data.cut_num,$brandix_bts.tbl_miniorder_data.color,
		 $brandix_bts.tbl_miniorder_data.color AS color_codes,$brandix_bts.tbl_orders_sizes_master.size_title, $brandix_bts.sizes.size_name AS size,
		 $brandix_bts.sizes.id AS size_id,$brandix_bts.tbl_cut_master.col_code as col_code,$brandix_bts.tbl_miniorder_data.bundle_number,$brandix_bts.tbl_miniorder_data.quantity AS quantity,
		 $brandix_bts.tbl_miniorder_data.docket_number AS docket_number,$brandix_bts.tbl_miniorder_data.split_shade as shade_val FROM $brandix_bts.`tbl_miniorder_data` AS tbl_miniorder_data 
		 LEFT JOIN $brandix_bts.tbl_orders_size_ref sizes ON sizes.id=$brandix_bts.tbl_miniorder_data.size 
		 LEFT JOIN $brandix_bts.tbl_min_ord_ref AS tbl_min_ord_ref ON tbl_min_ord_ref.id=$brandix_bts.tbl_miniorder_data.mini_order_ref 
		 LEFT JOIN $brandix_bts.`tbl_orders_master` AS tbl_orders_master ON `tbl_orders_master`.`id`=$brandix_bts.tbl_min_ord_ref.ref_crt_schedule 
		 LEFT JOIN $brandix_bts.tbl_orders_style_ref AS tbl_orders_style_ref ON tbl_orders_style_ref.id=$brandix_bts.tbl_min_ord_ref.ref_product_style 
		 LEFT JOIN $brandix_bts.tbl_cut_master ON $brandix_bts.tbl_miniorder_data.docket_number=$brandix_bts.tbl_cut_master.doc_num 
		LEFT JOIN $brandix_bts.`tbl_orders_sizes_master` AS tbl_orders_sizes_master ON `tbl_orders_master`.`id`=$brandix_bts.tbl_orders_sizes_master.parent_id AND tbl_miniorder_data.color=$brandix_bts.tbl_orders_sizes_master.order_col_des AND tbl_miniorder_data.size=$brandix_bts.tbl_orders_sizes_master.ref_size_name
		where $brandix_bts.tbl_miniorder_data.docket_number in (".implode(",",$doc_id).") group by $brandix_bts.tbl_miniorder_data.bundle_number order by $brandix_bts.tbl_miniorder_data.id*1";
		//echo $sql."<br>";
		$sql_result=mysql_query($sql,$link) or exit("Sql Error--1".mysql_error());
		while($row2=mysql_fetch_array($sql_result))
		{	
			$style_id=$row2['style_id'];
			$style=$row2['product_style'];
			$schedule=$row2['product_schedule'];
			$color=$row2['color'];
			$shade=$row2['shade_val'];
			
			$cut_code=chr($color_code).leading_zeros($cut_code1, 3);
			if($emb_stat==1)
			{
				$html.= '<table class="table table-bordered"><tr><td><table class="table table-bordered"><tr><td>Min No: </td><td>'.$row2['mini_order_num'].'</td>
				<td >Stab here: </td><td colspan=2><img src="round.jpg" style="width:40px;height:40px;"></td></tr>';
				$html.= '<tr><td>Color:</td><td colspan=3 class="new_td2">'.$row2['color'].'</td></tr>';
				$html.= '<tr><td>Style:</td><td class="new_td3">'.$style.'</td><td>Schedule:</td><td class="new_td3">'.$schedule.'</td></tr>';
			/*	$html.= '<tr><td> Size :</td><td class="new_td3"><b>'.$row2['size_title'].'</b></td><td>Cut :<b>'.$cut_code.'</b></td><td>Qty :<b>'.$row2['quantity'].'</b></td></tr>';
			*/
				$html.= '<tr><td colspan=4> Size :<b class="new_td4">'.$row2['size_title'].'</b>&nbsp;Cut :<b>'.$cut_code.'</b>&nbsp;Qty :<b>'.$row2['quantity'].'</b>&nbsp;S# :<b>'.$shade.'</b>&nbsp;</td></tr>';
				$html.='</table></td>
				<td width="37px" text-rotate="90" align="center">'.str_pad($row2['bundle'],7,"0",STR_PAD_LEFT).'</td></tr></table>';
				$html.='<pagebreak/>';
				
				for($jj=0;$jj<sizeof($operation_id1);$jj++)
				{
					$i=$operation_id1[$jj];
					$ops=$operation_code1[$jj];
					$barcode_value =str_pad($row2['bundle'],7,"0",STR_PAD_LEFT)."-".str_pad($i,2,"0",STR_PAD_LEFT);
					$html.= '<table class="table table-bordered"><tr><td><table class="table table-bordered"><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39"/ height="0.80" size="1.3" text="1"></td></tr>';
					//$html.= '<table><tr><td><table><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39" height="0.80" size="1.3" text="1"></td></tr>';
					$html.= '<tr><td colspan=4>S:<b>'.$style.'</b>#S:<b>'.$schedule.'</b>#B:<b>'.$row2['bundle'].'</b></td></tr>';
					//$html.= '<tr><td>Style: </td><td><b>'.$style.'</b></td><td>Schedule :</td><td><b>'.$schedule.'</b> </td></tr>';
					$html.= '<tr><td colspan=4>Cut#<b>'.$cut_code.'</b> size#<b>'.$row2['size_title'].'</b> Qty#<b>'.$row2['quantity'].'</b>Op# <b>'.$ops.'</b></td></tr>';
					//$html.= '<tr><td>Color</td><td class="new_td" colspan="4"><b>'.$color.'</b></td><td>M-'.$mini_order_id.'</td></tr></table></td><td width="37px" text-rotate="90" align="center">'.$barcode_value.'</td></tr></table>';
					$html.= '<tr><td colspan="4">Col# <b>'.substr($color,0,20).'</b></tr></table></td><td width="37px" text-rotate="90" align="center"><b>'.$barcode_value.'</b></td></tr></table>';
					$html.='<pagebreak/>';
					
				}
			
			}
		
			$html.= '<table class="table table-bordered"><tr><td><table class="table table-bordered"><tr><td>Min No: </td><td>'.$row2['mini_order_num'].'</td>
			<td >Stab here: </td><td colspan=2><img src="round.jpg" style="width:40px;height:40px;"></td></tr>';
			$html.= '<tr><td>Color:</td><td colspan=3 class="new_td2">'.$row2['color'].'</td></tr>';
			$html.= '<tr><td>Style:</td><td class="new_td3">'.$style.'</td><td>Schedule:</td><td class="new_td3">'.$schedule.'</td></tr>';
			// $html.= '<tr><td> Size :</td><td class="new_td3"><b>'.$row2['size_title'].'</b></td><td>Cut :<b>'.$cut_code.'</b></td><td>Qty :<b>'.$row2['quantity'].'</b></td></tr>';
			$html.= '<tr><td colspan=4> Size :<b class="new_td4">'.$row2['size_title'].'</b>&nbsp;Cut :<b>'.$cut_code.'</b>&nbsp;Qty :<b>'.$row2['quantity'].'</b>&nbsp;S# :<b>'.$shade.'</b>&nbsp;</td></tr>';
			$html.='</table></td>
			<td width="37px" text-rotate="90" align="center">'.str_pad($row2['bundle'],7,"0",STR_PAD_LEFT).'</td></tr></table>';
			$html.='<pagebreak/>';
			
			for($ii=0;$ii<sizeof($operation_id);$ii++)
			{
				$i=$operation_id[$ii];
				$ops=$operation_code[$ii];
				if($i==3)
				{
					$barcode_value =str_pad($row2['bundle'],7,"0",STR_PAD_LEFT)."-".str_pad($i,2,"0",STR_PAD_LEFT);
					$html.= '<table class="table table-bordered"><tr><td><table class="table table-bordered"><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39"/ height="0.80" size="1.3" text="1"></td></tr>';
					//$html.= '<table><tr><td><table><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39" height="0.80" size="1.3" text="1"></td></tr>';
					$html.= '<tr><td colspan=4>S:<b>'.$style.'</b>#S:<b>'.$schedule.'</b>#B:<b>'.$row2['bundle'].'</b></td></tr>';
					$html.= '<tr><td colspan=4>Cut#<b>'.$cut_code.'</b> size#<b>'.$row2['size_title'].'</b> Qty#<b>'.$row2['quantity'].'</b>Op# <b>'.$ops.'</b></td></tr>';
					//$html.= '<tr><td colspan=4>Cut#<b>'.$cut_code.'</b> size#<b>'.$row2['size_title'].'</b> Qty#<b>'.$row2['quantity'].'</b> Op : <b>'.$ops.'</b>PR # <img src="box_1.jpg" style="width:30px;height:30px;"></td></tr>';
					//$html.= '<tr><td>Color</td><td class="new_td" colspan="4"><b>'.$color.'</b></td><td>M-'.$mini_order_id.'</td></tr></table></td><td width="37px" text-rotate="90" align="center">'.$barcode_value.'</td></tr></table>';
					$html.= '<tr><td colspan="3">Col# <b>'.substr($color,0,20).'</b></td><td>PR # <img src="box_1.jpg" style="width:30px;height:30px;"></b></td></tr></table></td><td width="37px" text-rotate="90" align="center"><b>'.$barcode_value.'</b></td></tr></table>';
					$html.='<pagebreak/>';
				}
				elseif($i==4)
				{
					$barcode_value =str_pad($row2['bundle'],7,"0",STR_PAD_LEFT)."-".str_pad($i,2,"0",STR_PAD_LEFT);
					$html.= '<table class="table table-bordered"><tr><td><table class="table table-bordered"><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39"/ height="0.80" size="1.3" text="1"></td></tr>';
					//$html.= '<table><tr><td><table><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39" height="0.80" size="1.3" text="1"></td></tr>';
					$html.= '<tr><td colspan=4>S:<b>'.$style.'</b>#S:<b>'.$schedule.'</b>#B:<b>'.$row2['bundle'].'</b></td></tr>';
					$html.= '<tr><td colspan=4>Cut#<b>'.$cut_code.'</b> size#<b>'.$row2['size_title'].'</b> Qty#<b>'.$row2['quantity'].'</b>Op# <b>'.$ops.'</b></td></tr>';
					//$html.= '<tr><td colspan=4>Cut#<b>'.$cut_code.'</b> size#<b>'.$row2['size_title'].'</b> Qty#<b>'.$row2['quantity'].'</b> Op : <b>'.$ops.'</b>PR # <img src="box_1.jpg" style="width:30px;height:30px;"></td></tr>';
					//$html.= '<tr><td>Color</td><td class="new_td" colspan="4"><b>'.$color.'</b></td><td>M-'.$mini_order_id.'</td></tr></table></td><td width="37px" text-rotate="90" align="center">'.$barcode_value.'</td></tr></table>';
					$html.= '<tr><td colspan="3">Col# <b>'.substr($color,0,20).'</b></td><td>GR # <img src="box_1.jpg" style="width:30px;height:30px;"></b></td></tr></table></td><td width="37px" text-rotate="90" align="center"><b>'.$barcode_value.'</b></td></tr></table>';
					$html.='<pagebreak/>';
					
						
				}
				else
				{
					$barcode_value =str_pad($row2['bundle'],7,"0",STR_PAD_LEFT)."-".str_pad($i,2,"0",STR_PAD_LEFT);
					$html.= '<table class="table table-bordered"><tr><td><table class="table table-bordered"><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39"/ height="0.80" size="1.3" text="1"></td></tr>';
					//$html.= '<table><tr><td><table><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39" height="0.80" size="1.3" text="1"></td></tr>';
					$html.= '<tr><td colspan=4>S:<b>'.$style.'</b>#S:<b>'.$schedule.'</b>#B:<b>'.$row2['bundle'].'</b></td></tr>';
					//$html.= '<tr><td>Style: </td><td><b>'.$style.'</b></td><td>Schedule :</td><td><b>'.$schedule.'</b> </td></tr>';
					$html.= '<tr><td colspan=4>Cut#<b>'.$cut_code.'</b> size#<b>'.$row2['size_title'].'</b> Qty#<b>'.$row2['quantity'].'</b>Op# <b>'.$ops.'</b></td></tr>';
					//$html.= '<tr><td>Color</td><td class="new_td" colspan="4"><b>'.$color.'</b></td><td>M-'.$mini_order_id.'</td></tr></table></td><td width="37px" text-rotate="90" align="center">'.$barcode_value.'</td></tr></table>';
					$html.= '<tr><td colspan="4">Col# <b>'.substr($color,0,20).'</b></tr></table></td><td width="37px" text-rotate="90" align="center"><b>'.$barcode_value.'</b></td></tr></table>';
					$html.='<pagebreak/>';
				}
			}
				
		}
		$html.='</body></html>';
		$sql="update $brandix_bts.tbl_miniorder_data set mini_order_status=1 where docket_number in (".implode(",",$doc_id).")";
		//echo $sql."<br>";
		$sql_result=mysql_query($sql,$link) or exit("Sql Error--1".mysql_error());
}
if($_GET['ops']==3)
{
	$bundle_id=$_GET['bundle'];
	
	$html = '<html><head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style>
	body {font-family: arial;
		font-size: 20px;
	}

	.new_td
	{
		font-size:20px;
	}

	.new_td2
	{
		font-size:22px;
		font-weight: bold;
	}

	.new_td3
	{
		font-size:22px;
		font-weight: bold;
	}

	table
	{
		margin-left:auto;
		margin-right:auto;
		margin-top:auto;
		margin-bottom:auto;
	}
	@page {
	margin-top: 10px; 

	}

	</style>
	</head>
	<body>';
	
	 $sql="SELECT $brandix_bts.tbl_orders_style_ref.id AS style_id,$brandix_bts.tbl_orders_style_ref.product_style,$brandix_bts.tbl_orders_master.product_schedule,
$brandix_bts.tbl_miniorder_data.id,$brandix_bts.tbl_miniorder_data.mini_order_ref, $brandix_bts.tbl_miniorder_data.mini_order_num,
$brandix_bts.tbl_miniorder_data.bundle_number AS bundle,$brandix_bts.tbl_miniorder_data.cut_num,$brandix_bts.tbl_miniorder_data.color,
$brandix_bts.tbl_miniorder_data.color AS color_code,$brandix_bts.tbl_orders_sizes_master.size_title, $brandix_bts.sizes.size_name AS size,
$brandix_bts.sizes.id AS size_id,$brandix_bts.tbl_miniorder_data.bundle_number,$brandix_bts.tbl_miniorder_data.quantity AS quantity,
$brandix_bts.tbl_miniorder_data.docket_number AS docket_number, $brandix_bts.tbl_miniorder_data.split_shade AS shade_val FROM $brandix_bts.`tbl_miniorder_data` AS tbl_miniorder_data 
LEFT JOIN $brandix_bts.tbl_orders_size_ref sizes ON sizes.id=$brandix_bts.tbl_miniorder_data.size 
LEFT JOIN $brandix_bts.tbl_min_ord_ref AS tbl_min_ord_ref ON tbl_min_ord_ref.id=$brandix_bts.tbl_miniorder_data.mini_order_ref 
LEFT JOIN $brandix_bts.`tbl_orders_master` AS tbl_orders_master ON `tbl_orders_master`.`id`=$brandix_bts.tbl_min_ord_ref.ref_crt_schedule 
LEFT JOIN $brandix_bts.tbl_orders_style_ref AS tbl_orders_style_ref ON tbl_orders_style_ref.id=$brandix_bts.tbl_min_ord_ref.ref_product_style 
LEFT JOIN $brandix_bts.`tbl_orders_sizes_master` AS tbl_orders_sizes_master ON `tbl_orders_master`.`id`=$brandix_bts.tbl_orders_sizes_master.parent_id AND tbl_miniorder_data.color=$brandix_bts.tbl_orders_sizes_master.order_col_des AND tbl_miniorder_data.size=$brandix_bts.tbl_orders_sizes_master.ref_size_name
WHERE $brandix_bts.tbl_miniorder_data.bundle_number='".$bundle_id."' group by $brandix_bts.tbl_miniorder_data.bundle_number";
		//echo $sql."<br>";
	$sql_result=mysql_query($sql,$link) or exit("Sql Error--1".mysql_error());
	while($row2=mysql_fetch_array($sql_result))
	{	
		$style_id=$row2['style_id'];
		$style=$row2['product_style'];
		$schedule=$row2['product_schedule'];
		$color=$row2['color'];
		$shade=$row2['shade_val'];
		$cut_code=$row2['cut_num'];
		
		$sql="SELECT * FROM $brandix_bts.tbl_orders_master WHERE product_schedule='".$schedule."'";
		$sql_result=mysql_query($sql,$link) or exit("Sql Error--2".mysql_error());
		while($rowval=mysql_fetch_array($sql_result))
		{
			$emb_stat=$rowval['emb_status'];
		}
		
		
		if($emb_stat==1)
		{
			$bundle_ops="SELECT $brandix_bts.bundle_transactions_20_repeat.operation_id as ops_id FROM $brandix_bts.tbl_orders_ops_ref LEFT JOIN $brandix_bts.bundle_transactions_20_repeat ON 
				$brandix_bts.tbl_orders_ops_ref.id=$brandix_bts.bundle_transactions_20_repeat.operation_id
				WHERE $brandix_bts.bundle_transactions_20_repeat.bundle_id='".$bundle_id."' AND 
				$brandix_bts.tbl_orders_ops_ref.default_operation='YES' AND $brandix_bts.tbl_orders_ops_ref.id<=7 ORDER BY $brandix_bts.tbl_orders_ops_ref.ops_order*1 DESC limit 1";
		$sql_result1=mysql_query($bundle_ops,$link) or exit("Sql Error--2".mysql_error());
			if(mysql_num_rows($sql_result1)>0)
			{
				while($row11=mysql_fetch_array($sql_result1))
				{
					$val=$row11['ops_id'];
					$sql11="SELECT  ops_order as ops_ids FROM $brandix_bts.tbl_orders_ops_ref where id='".$val."' and id<=7 order by ops_order*1";
					$sql_result11=mysql_query($sql11,$link) or exit("Sql Error--2".mysql_error());
					while($row111=mysql_fetch_array($sql_result11))
					{
						$val=$row111['ops_ids'];
					}
				}
				//$sql1="select * from brandix_bts.tbl_orders_ops_ref where default_operation='YES' and ops_order>'".$val."' order by ops_order*1";
				$sql1="select * from $brandix_bts.tbl_orders_ops_ref where default_operation='YES' order by ops_order*1";
			}
			else
			{
				$sql1="select * from $brandix_bts.tbl_orders_ops_ref where default_operation='YES' order by ops_order*1";	
			}
		}
		else if($emb_stat==0)
		{
			$bundle_ops="SELECT $brandix_bts.bundle_transactions_20_repeat.operation_id as ops_id FROM $brandix_bts.tbl_orders_ops_ref LEFT JOIN $brandix_bts.bundle_transactions_20_repeat ON 
				$brandix_bts.tbl_orders_ops_ref.id=$brandix_bts.bundle_transactions_20_repeat.operation_id
				WHERE $brandix_bts.bundle_transactions_20_repeat.bundle_id='".$bundle_id."' AND 
				$brandix_bts.tbl_orders_ops_ref.default_operation='YES' AND $brandix_bts.tbl_orders_ops_ref.id<5 ORDER BY $brandix_bts.tbl_orders_ops_ref.ops_order*1 DESC limit 1";
		$sql_result1=mysql_query($bundle_ops,$link) or exit("Sql Error--2".mysql_error());
			if(mysql_num_rows($sql_result1)>0)
			{
				while($row11=mysql_fetch_array($sql_result1))
				{
					$val=$row11['ops_id'];
				}
				$sql1="select * from $brandix_bts.tbl_orders_ops_ref where default_operation='YES' and id>'".$val."' and id<5 order by ops_order*1";
				//$sql1="select * from brandix_bts.tbl_orders_ops_ref where default_operation='YES' order by ops_order*1";
			}
			else
			{
				$sql1="select * from $brandix_bts.tbl_orders_ops_ref where default_operation='YES' order by ops_order*1";	
			}
		}	
		else if($emb_stat==2)
		{
			$bundle_ops="SELECT $brandix_bts.bundle_transactions_20_repeat.operation_id as ops_id FROM $brandix_bts.tbl_orders_ops_ref LEFT JOIN $brandix_bts.bundle_transactions_20_repeat ON 
				$brandix_bts.tbl_orders_ops_ref.id=$brandix_bts.bundle_transactions_20_repeat.operation_id
				WHERE $brandix_bts.bundle_transactions_20_repeat.bundle_id='".$bundle_id."' AND 
				$brandix_bts.tbl_orders_ops_ref.default_operation='YES' AND $brandix_bts.tbl_orders_ops_ref.id not in (6,7) ORDER BY $brandix_bts.tbl_orders_ops_ref.ops_order*1 DESC limit 1";
		$sql_result1=mysql_query($bundle_ops,$link) or exit("Sql Error--2".mysql_error());
			if(mysql_num_rows($sql_result1)>0)
			{
				$val1=$row11['ops_id'];
				$sql11="SELECT ops_order as ops_ids FROM $brandix_bts.tbl_orders_ops_ref where id='".$val1."' and id not in (6,7) order by ops_order*1";
				$sql_result11=mysql_query($sql11,$link) or exit("Sql Error--2".mysql_error());
				while($row111=mysql_fetch_array($sql_result11))
				{
					$val=$row111['ops_ids'];
				}
				$sql1="select * from $brandix_bts.tbl_orders_ops_ref where default_operation='YES' and ops_order>'".$val."' and id not in (6,7) order by ops_order*1";
				//$sql1="select * from brandix_bts.tbl_orders_ops_ref where default_operation='YES' order by ops_order*1";
			}
			else
			{
				$sql1="select * from $brandix_bts.tbl_orders_ops_ref where default_operation='YES' order by ops_order*1";	
			}
		}	
		$html.= '<table class="table table-bordered"><tr><td><table class="table table-bordered"><tr><td>Min No: </td><td>'.$row2['mini_order_num'].'</td>
		<td >Stab here: </td><td colspan=2><img src="round.jpg" style="width:40px;height:40px;"></td></tr>';
		$html.= '<tr><td>Color:</td><td colspan=3 class="new_td2">'.$row2['color'].'</td></tr>';
		$html.= '<tr><td>Style:</td><td class="new_td3">'.$style.'</td><td>Schedule:</td><td class="new_td3">'.$schedule.'</td></tr>';
		// $html.= '<tr><td> Size :</td><td class="new_td3"><b>'.$row2['size_title'].'</b></td><td>Cut :<b>'.$cut_code.'</b></td><td>Qty :<b>'.$row2['quantity'].'</b></td></tr>';
		$html.= '<tr><td colspan=4> Size :<b class="new_td4">'.$row2['size_title'].'</b>&nbsp;Cut :<b>'.$cut_code.'</b>&nbsp;Qty :<b>'.$row2['quantity'].'</b>&nbsp;S# :<b>'.$shade.'</b>&nbsp;</td></tr>';
		$html.='</table></td>
		<td width="37px" text-rotate="90" align="center">'.str_pad($row2['bundle'],7,"0",STR_PAD_LEFT).'</td></tr></table>';
		$html.='<pagebreak/>';
		
		$code='';
		$sql_result11=mysql_query($sql1,$link) or exit("Sql Error--1".mysql_error());
		while($row1=mysql_fetch_array($sql_result11))
		{
			$i=$row1['id'];
			$ops=$row1['operation_code'];
			if($i==3)
			{
				$barcode_value =str_pad($row2['bundle'],7,"0",STR_PAD_LEFT)."-".str_pad($i,2,"0",STR_PAD_LEFT);
				$html.= '<table class="table table-bordered"><tr><td><table class="table table-bordered"><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39"/ height="0.80" size="1.3" text="1"></td></tr>';
				//$html.= '<table><tr><td><table><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39" height="0.80" size="1.3" text="1"></td></tr>';
				$html.= '<tr><td colspan=4>S:<b>'.$style.'</b>#S:<b>'.$schedule.'</b>#B:<b>'.$row2['bundle'].'</b></td></tr>';
				$html.= '<tr><td colspan=4>Cut#<b>'.$cut_code.'</b> size#<b>'.$row2['size_title'].'</b> Qty#<b>'.$row2['quantity'].'</b>Op# <b>'.$ops.'</b></td></tr>';
				//$html.= '<tr><td colspan=4>Cut#<b>'.$cut_code.'</b> size#<b>'.$row2['size_title'].'</b> Qty#<b>'.$row2['quantity'].'</b> Op : <b>'.$ops.'</b>PR # <img src="box_1.jpg" style="width:30px;height:30px;"></td></tr>';
				//$html.= '<tr><td>Color</td><td class="new_td" colspan="4"><b>'.$color.'</b></td><td>M-'.$mini_order_id.'</td></tr></table></td><td width="37px" text-rotate="90" align="center">'.$barcode_value.'</td></tr></table>';
				$html.= '<tr><td colspan="3">Col# <b>'.substr($color,0,20).'</b></td><td>PR # <img src="box_1.jpg" style="width:30px;height:30px;"></b></td></tr></table></td><td width="37px" text-rotate="90" align="center"><b>'.$barcode_value.'</b></td></tr></table>';
				$html.='<pagebreak/>';
			}
			elseif($i==4)
			{
				$barcode_value =str_pad($row2['bundle'],7,"0",STR_PAD_LEFT)."-".str_pad($i,2,"0",STR_PAD_LEFT);
				$html.= '<table class="table table-bordered"><tr><td><table class="table table-bordered"><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39"/ height="0.80" size="1.3" text="1"></td></tr>';
				//$html.= '<table><tr><td><table><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39" height="0.80" size="1.3" text="1"></td></tr>';
				$html.= '<tr><td colspan=4>S:<b>'.$style.'</b>#S:<b>'.$schedule.'</b>#B:<b>'.$row2['bundle'].'</b></td></tr>';
				$html.= '<tr><td colspan=4>Cut#<b>'.$cut_code.'</b> size#<b>'.$row2['size_title'].'</b> Qty#<b>'.$row2['quantity'].'</b>Op# <b>'.$ops.'</b></td></tr>';
				//$html.= '<tr><td colspan=4>Cut#<b>'.$cut_code.'</b> size#<b>'.$row2['size_title'].'</b> Qty#<b>'.$row2['quantity'].'</b> Op : <b>'.$ops.'</b>PR # <img src="box_1.jpg" style="width:30px;height:30px;"></td></tr>';
				//$html.= '<tr><td>Color</td><td class="new_td" colspan="4"><b>'.$color.'</b></td><td>M-'.$mini_order_id.'</td></tr></table></td><td width="37px" text-rotate="90" align="center">'.$barcode_value.'</td></tr></table>';
				$html.= '<tr><td colspan="3">Col# <b>'.substr($color,0,20).'</b></td><td>GR # <img src="box_1.jpg" style="width:30px;height:30px;"></b></td></tr></table></td><td width="37px" text-rotate="90" align="center"><b>'.$barcode_value.'</b></td></tr></table>';
				$html.='<pagebreak/>';
			}
			else
			{
				$barcode_value =str_pad($row2['bundle'],7,"0",STR_PAD_LEFT)."-".str_pad($i,2,"0",STR_PAD_LEFT);
				$html.= '<table class="table table-bordered"><tr><td><table class="table table-bordered"><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39"/ height="0.80" size="1.3" text="1"></td></tr>';
				//$html.= '<table><tr><td><table><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39" height="0.80" size="1.3" text="1"></td></tr>';
				$html.= '<tr><td colspan=4>S:<b>'.$style.'</b>#S:<b>'.$schedule.'</b>#B:<b>'.$row2['bundle'].'</b></td></tr>';
				//$html.= '<tr><td>Style: </td><td><b>'.$style.'</b></td><td>Schedule :</td><td><b>'.$schedule.'</b> </td></tr>';
				$html.= '<tr><td colspan=4>Cut#<b>'.$cut_code.'</b> size#<b>'.$row2['size_title'].'</b> Qty#<b>'.$row2['quantity'].'</b>Op# <b>'.$ops.'</b></td></tr>';
				//$html.= '<tr><td>Color</td><td class="new_td" colspan="4"><b>'.$color.'</b></td><td>M-'.$mini_order_id.'</td></tr></table></td><td width="37px" text-rotate="90" align="center">'.$barcode_value.'</td></tr></table>';
				$html.= '<tr><td colspan="4">Col# <b>'.substr($color,0,20).'</b></td></tr></table></td><td width="37px" text-rotate="90" align="center"><b>'.$barcode_value.'</b></td></tr></table>';
				$html.='<pagebreak/>';
			}
			
			
		}

	}
	$html.='</body></html>';
}


//==============================================================
//==============================================================
include("mpdf.php");

$mpdf=new mPDF('',array(63.3,25.0),0,'',0,0,0,0,0,0,'P'); 
$mpdf->WriteHTML($html);
$mpdf->Output(); 

exit;

?>
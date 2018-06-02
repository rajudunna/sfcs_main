<?php
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
//configuration files
function know_my_config($input)
{
	switch ($input)
	{
		case "facility":
		{
			return 'Q01';
			break;
		}
		case "mysqlhost":
		{
			return '192.168.0.110:3323';
			break;
		}
		case "mysqlun":
		{
			return 'baiall';
			break;
		}
		case "mysqlpass":
		{
			return 'baiall';
			break;
		}
		case "mssqldns":
		{
			return 'BAINET_INTRANET_NEW';
			break;
		}
		case "mssqlun":
		{
			return 'sa';
			break;
		}
		case "mssqlpass":
		{
			return 'Brandix@7';
			break;
		}
	}
	
}

//To return MDM result monumber, opnumber
function mssql_mdm_value($query)
{
	echo "Start=".date("Y-m-d H:i:s");
	echo "\n asd$query";
	/*$connect = odbc_connect(know_my_config('mssqldns'), know_my_config('mssqlun'), know_my_config('mssqlpass'));
	$query = $query;
	echo $query;
	$result = odbc_exec($connect, $query);
	

	while(odbc_fetch_row($result))
	{ 
		//When M3 offline comment this
		$retval=odbc_result($result, 1);
	}
	
	odbc_close($connect); 
	//$retval=0;
	echo "End=".date("Y-m-d H:i:s");
	return  $retval; */
	
}


function mssql_mdm_value_sfcs_mo($sfcs_schedule,$m3_color_code,$m3_size_code,$query)
{
	$link_secure_m3or=construct_connection();
	
	$retval=0;

	$sql="select m3_mo_no from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule=$sfcs_schedule and sfcs_color='$m3_color_code' and sfcs_size='$m3_size_code' and m3_mo_no>0 and m3_op_des<>'MRN_RE01' limit 1";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$retval=$sql_row['m3_mo_no'];
		
	}
	
	if($retval==0)
	{
		$sql1="select order_mo_no from m3_bulk_ops_rep_db.order_status_tbl where order_del_no=$sfcs_schedule and order_col_des='$m3_color_code' and order_size='".know_m3_size_code($sfcs_schedule,$m3_size_code,$m3_color_code)."' and order_mo_no>0 limit 1";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$retval=$sql_row1['order_mo_no'];			
		}
	}
	
	
	if($retval==0)
	{
		$retval= mssql_mdm_value($query);
	}	
	
	return $retval;
	
}

function mssql_mdm_value_sfcs_smv($sfcs_schedule,$m3_color_code,$m3_size_code,$query)
{
	$link_secure_m3or=construct_connection();
	
	$retval=0;

	$sql="select smv from bai_pro3.bai_orders_db_confirm where order_del_no='$sfcs_schedule' and order_col_des='$m3_color_code'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$retval=$sql_row['smv'];
		
	}
	
	if($retval==0)
	{
		$retval= mssql_mdm_value($query);
	}	
	
	return $retval;
	
}

function leading_zeros($value, $places){
// Function written by Marcus L. Griswold (vujsa)
// Can be found at http://www.handyphp.com
// Do not remove this header!

    if(is_numeric($value)){
        for($x = 1; $x <= $places; $x++){
            $ceiling = pow(10, $x);
            if($value < $ceiling){
                $zeros = $places - $x;
                for($y = 1; $y <= $zeros; $y++){
                    $leading .= "0";
                }
            $x = $places + 1;
            }
        }
        $output = $leading . $value;
    }
    else{
        $output = $value;
    }
    return $output;
}

//To know job number
function know_sfcs_job_no($doc_no)
{
	$link_secure_m3or=construct_connection();
	

	$sql="SELECT acutno, color_code FROM bai_pro3.order_cat_doc_mix WHERE doc_no=$doc_no";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error1a".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		return chr($sql_row['color_code']).leading_zeros($sql_row['acutno'], 3);
		
	}	
	
	
}

//To Extract M3 relevant Color Code
function m3_color_code($sfcs_color)
{
	$keystr="";
	if(strpos($sfcs_color,"==="))
	{
		$keystr="===";
	}
	if(strpos($sfcs_color,"***"))
	{
		$keystr="***";
	}

	if($keystr=="***" or $keystr=="===")
	{
		return next(explode($keystr,$sfcs_color));
	}
	else
	{
		return $sfcs_color;
	}
}


//To know the M3 relevant size code from SFCS
function know_m3_size_code($schedule,$sfcs_size,$sfcs_color)
{
	$link_secure_m3or=construct_connection();
	
	
	$sql="SELECT order_div,title_flag,title_size_$sfcs_size as sizecode FROM bai_pro3.bai_orders_db_confirm WHERE order_del_no=$schedule and order_col_des='$sfcs_color' and order_s_$sfcs_size>0 LIMIT 1";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2a $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$buyer_div=$sql_row['order_div'];
		$title_flag=$sql_row['title_flag'];
		$sizecode=$sql_row['sizecode'];
	}	
	
	if($title_flag==0)
	{
		$sql="SELECT $sfcs_size as size FROM bai_pro3.tbl_size_lable WHERE buyer_devision=\"$buyer_div\"";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error3a$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$retval=strtoupper($sql_row['size']);
			
		}
	}
	else
	{
		$retval=strtoupper($sizecode);
	}
		
	
	//@mysql_close($link_secure_m3or);
	return $retval;
}

//To check order status (1 - OK, 0 - NOK)
function know_order_status($schedule,$color,$sfcs_size,$link)
{
	$link_secure_m3or=$link;
	
	$sql="SELECT order_stat FROM bai_pro3.bai_orders_db_confirm WHERE order_del_no='$schedule' AND order_stat=''";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	if(mysqli_num_rows($sql_result)==0)
	{
		$sql="SELECT order_stat FROM m3_bulk_ops_rep_db.order_status_tbl WHERE order_del_no='$schedule' AND order_col_des='$color' AND order_size='".know_m3_size_code($schedule,$sfcs_size,$color)."'  AND order_stat=''";
		//echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	return $sql_result;
}

//To construct local mysql connection
function construct_connection()
{
	//$_SESSION['intra_user_name']="";
	$server_soft=$_SERVER['SERVER_SOFTWARE'];
	
	if(substr($server_soft,0,13)=="Apache/2.2.22")
	{
		$username_list=explode('\\',$_SERVER['REMOTE_USER']);
		$username=strtolower($username_list[1]);
		//$_SESSION['intra_user_name']=$username;
	}
	else
	{
		list($domain,$username) = explode('[\]',$_SERVER['AUTH_USER'],2);
		$username=strtolower($username);
		//$_SESSION['intra_user_name']=$username;
	}
	
	$host_adr_m3or=know_my_config('mysqlhost');
	$host_adr_un_m3or=know_my_config('mysqlun');
	$host_adr_pw_m3or=know_my_config('mysqlpass');
	
	$database_secure_m3or="m3_bulk_ops_rep_db";
	
	
	$link_secure_m3or= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host_adr_m3or, $host_adr_un_m3or, $host_adr_pw_m3or)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
	//mysql_select_db($database_secure,$link_secure) or die("Error in selecting the database:".mysql_error());
	// mysqli_select_db($link, $m3_bulk_ops_rep_db) or die();
	
	return $link_secure_m3or;
}

function m3_bulk_or_fn($sfcs_date ,$sfcs_style ,$sfcs_schedule ,$sfcs_color ,$sfcs_size ,$sfcs_doc_no ,$sfcs_qty ,$sfcs_reason ,$sfcs_job_no ,$sfcs_mod_no ,$sfcs_shift ,$m3_op_des)
{
	

	$link_secure_m3or=construct_connection();
	
	$sql="select * from bai_ict.bai_login_db where lower(user_login)='$username' and status=0";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error4a".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		
	}	
	
	//@mysql_close($link_secure_m3or);
}

//Validation to avoid output entries 
function output_validation_old($operation,$schedule,$color,$size,$reported_qty,$tid_ref,$username)
{
	$link_secure_m3or=construct_connection();
	
	/*
	1) (old+new Output) Should not be exceed input quantity (Only Module Input excluding EXCESS, SAMPLE, EMB) AND
	2) (input qty+recut input+replaced) <= (Old Reported Output qty+new reported output qty+rejected+sample+good garments)
	3) Point2: Input which includes everything from IMS.

	*/
	//Output
	$output=0;
	$sql="select sum(size_$size) as output from bai_pro.bai_log_buf where delivery=$schedule and color='$color'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error5a".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$output=$sql_row['output'];
	}	
	$output+=$reported_qty;
	
	//Module Input
	$module_input=0;
	$total_input=0;
	$sql="select sum(if(ims_mod_no>0 and ims_remarks not in ('EXCESS','EMB','SAMPLE','SHIPMENT_SAMPLE'),ims_qty,0)) as module_input, sum(ims_qty) as total_input from bai_pro3.ims_log where ims_schedule=$schedule and ims_color='$color' and ims_size='a_$size'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error6a".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$module_input=$sql_row['module_input'];
		$total_input=$sql_row['total_input'];
	}
	$sql="select  sum(if(ims_mod_no>0 and ims_remarks not in ('EXCESS','EMB','SAMPLE','SHIPMENT_SAMPLE'),ims_qty,0)) as module_input, sum(ims_qty) as total_input from bai_pro3.ims_log_backup where ims_schedule=$schedule and ims_color='$color' and ims_size='a_$size'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error7a".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$module_input+=$sql_row['module_input'];
		$total_input+=$sql_row['total_input'];
	}
	
	//Quality Details
	$rejected=0;
	$sample=0;
	$good_garments=0;
	$replaced=0;
	
	$sql="select sum(if(qms_tran_type=3,qms_qty,0)) as rejected, sum(if(qms_tran_type=4,qms_qty,0)) as sample, sum(if(qms_tran_type=5,qms_qty,0)) as good_garments, sum(if(qms_tran_type=2,qms_qty,0)) as replaced from bai_pro3.bai_qms_db where qms_schedule=$schedule and qms_color='$color' and qms_size='$size'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error8a".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$rejected=$sql_row['rejected'];
		$sample=$sql_row['sample'];;
		$good_garments=$sql_row['good_garments'];
		$replaced=$sql_row['replaced'];
	}
	
	$sql="select sum(if(qms_tran_type=3,qms_qty,0)) as rejected, sum(if(qms_tran_type=4,qms_qty,0)) as sample, sum(if(qms_tran_type=5,qms_qty,0)) as good_garments, sum(if(qms_tran_type=2,qms_qty,0)) as replaced from bai_pro3.bai_qms_db_archive where qms_schedule=$schedule and qms_color='$color' and qms_size='$size'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error9a".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$rejected+=$sql_row['rejected'];
		$sample+=$sql_row['sample'];;
		$good_garments+=$sql_row['good_garments'];
		$replaced+=$sql_row['replaced'];
	}
	
	//Recut Input Quantity
	$recut_input=0;
	
	$sql="select COALESCE(SUM(a_$size*a_plies),0) as recut_input from bai_pro3.recut_v2 where order_tid=(select order_tid from bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."' and order_col_des='".$color."') and remarks in ('Body','Front') and cut_inp_temp=1";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error10a".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$recut_input=$sql_row['recut_input'];	
	}
	
	
	$line_input=0;
	$line_output=0;
	$sql="select ims_qty,ims_pro_qty from bai_pro3.ims_log where ims_schedule=$schedule and ims_color='$color' and ims_size='a_$size' and tid=$tid_ref";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error11a".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$line_input=$sql_row['ims_qty'];	
		$line_output=$sql_row['ims_pro_qty'];
	}
	$line_output+=$reported_qty;
	
	/*
	echo "<hr>Schedule:".$schedule."<br/>";
	echo "Color:".$color."<br/>";
	echo "Tid:".$tid_ref."<br/>";
	echo "Size:".$size."<br/>";
	echo "Output:".$output."<br/>";
	echo "Module Input:".$module_input."<br/>";
	echo "Total Input:".$total_input."<br/>";
	echo "Recut Input:".$recut_input."<br/>";
	echo "Replaced:".$replaced."<br/>";
	echo "Rejected:".$rejected."<br/>";
	echo "Sample:".$sample."<br/>";
	echo "Good Garments:".$good_garments."<br/>";
	echo "Reported:".$reported_qty."<br/>";
	echo "Line Input:".$line_input."<br/>";
	echo "Line Output:".$line_output."<br/>";
	*/
	
	$sql="select sum(order_embl_a+order_embl_b) as emb_panel from bai_pro3.bai_orders_db where order_del_no=$schedule";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error12a".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$emb_panel=$sql_row['emb_panel'];
	}
	
	//sewing output will track without rejection.
	$sql="select COALESCE(sum(sfcs_qty),0) as sfcs_qty from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='$size' and m3_op_des in ('SOT') and sfcs_reason<>'' and sfcs_status<>90";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error13a".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$input_rejected=$sql_row['sfcs_qty'];	
	}

	if($emb_panel>0)
	{
		$total_input=$module_input;
		$rejected=$input_rejected;
	}
	
	/* Disabled to bring central control
	$sql="SELECT order_stat FROM bai_pro3.bai_orders_db_confirm WHERE order_del_no='$schedule' AND order_stat=''";
	//echo $sql;
	$sql_result=mysql_query($sql,$link_secure_m3or) or exit("Sql Error".mysql_error()); */
	$sql_result=know_order_status($schedule,$color,$size,$link_secure_m3or);
	if(mysqli_num_rows($sql_result)>0)
	{
	
		if( ($line_input>=$line_output) and ($output<=$module_input) and (($total_input+$recut_input+$replaced)>=($output+$rejected+$sample+$good_garments)))
		{
			return 'TRUE';
		}
		else
		{
			return 'FALSE';
		}
		
	}
	else
	{
		return 'FALSE';
	}	
	
	//@mysql_close($link_secure_m3or);
}

/*Testing 
$link_secure_m3or=construct_connection();
$sql="select *,SUBSTRING_INDEX(ims_size,'_',-1) as size_new from bai_pro3.ims_log where ims_date>'2015-02-01' limit 20";
$sql_result=mysql_query($sql,$link_secure_m3or) or exit("Sql Error".mysql_error());
while($sql_row=mysql_fetch_array($sql_result))
{
	echo output_validation('SOUT',$sql_row['ims_schedule'],$sql_row['ims_color'],$sql_row['size_new'],($sql_row['ims_qty']-$sql_row['ims_pro_qty']),$sql_row['tid']);
}
//@mysql_close($link_secure_m3or);
*/

//echo output_validation('SOUT',253517,'INPANT1596 C001 31EA          ','s',1,564030,'kirang');


//M3 Output Validation
function output_validation($operation,$schedule,$color,$size,$reported_qty,$tid_ref,$username)
{
	$link_secure_m3or=construct_connection();
	
	$sfcs_qty=0;
	
	$sql="select COALESCE(sum(sfcs_qty),0) as sfcs_qty from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='$size' and m3_op_des='$operation' and sfcs_status<>90";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error14a".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$sfcs_qty=$sql_row['sfcs_qty'];	
	}
	
	//New validation to check the previous operaiton - KiraG 2015-10-09
	$tot_sin=0;
	$sql="select COALESCE(sum(sfcs_qty),0) as sfcs_qty from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='$size' and m3_op_des='SIN' and sfcs_status<>90";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$tot_sin=$sql_row['sfcs_qty'];
	}
	
	//Module Input
	$module_input=0;
	$total_input=0;
	//Disabled due to eliminate excess input from total input -kk 20150602 $sql="select sum(if(ims_mod_no>0 and ims_remarks not in ('EXCESS','EMB','SAMPLE','SHIPMENT_SAMPLE'),ims_qty,0)) as module_input, sum(ims_qty) as total_input from bai_pro3.ims_log where ims_schedule=$schedule and ims_color='$color' and ims_size='a_$size'";
	$sql="select sum(if(ims_mod_no>0 and ims_remarks not in ('EXCESS','EMB','SAMPLE','SHIPMENT_SAMPLE'),ims_qty,0)) as module_input, sum(if(ims_mod_no=0,0,ims_qty)) as total_input from bai_pro3.ims_log where ims_schedule=$schedule and ims_color='$color' and ims_size='a_$size'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$module_input=$sql_row['module_input'];
		$total_input=$sql_row['total_input'];
	}
	//Disabled due to eliminate excess input from total input -kk 20150602 $sql="select  sum(if(ims_mod_no>0 and ims_remarks not in ('EXCESS','EMB','SAMPLE','SHIPMENT_SAMPLE'),ims_qty,0)) as module_input, sum(ims_qty) as total_input from bai_pro3.ims_log_backup where ims_schedule=$schedule and ims_color='$color' and ims_size='a_$size'";
	$sql="select  sum(if(ims_mod_no>0 and ims_remarks not in ('EXCESS','EMB','SAMPLE','SHIPMENT_SAMPLE'),ims_qty,0)) as module_input, sum(if(ims_mod_no=0,0,ims_qty)) as total_input from bai_pro3.ims_log_backup where ims_schedule=$schedule and ims_color='$color' and ims_size='a_$size'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$module_input+=$sql_row['module_input'];
		$total_input+=$sql_row['total_input'];
	}
	
	//Recut Input Quantity
	$recut_input=0;
	
	$sql="select COALESCE(SUM(a_$size*a_plies),0) as recut_input from bai_pro3.recut_v2 where order_tid=(select order_tid from bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."' and order_col_des='".$color."') and remarks in ('Body','Front') and cut_inp_temp=1";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$recut_input=$sql_row['recut_input'];	
	}
	
	$replaced=0;
	//Replaced Qty
	$sql="select COALESCE(sum(if(qms_tran_type=2,qms_qty,0)),0) as replaced from bai_pro3.bai_qms_db where qms_schedule=$schedule and qms_color='$color' and qms_size='$size'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$replaced=$sql_row['replaced'];
	}
	
	//Samples input to be considered.
	$sample_qty=0;
	$sql="select COALESCE(sum(ims_qty),0) as ims_qty from bai_pro3.ims_log where ims_schedule='$schedule' and ims_color='$color' and ims_size='a_$size' and ims_remarks in ('SAMPLE','SHIPMENT_SAMPLE')";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$sample_qty=$sql_row['ims_qty'];	
	}
	
	/* Disabled to bring central control
	$sql="SELECT order_stat FROM bai_pro3.bai_orders_db_confirm WHERE order_del_no='$schedule' AND order_stat=''";
	//echo $sql;
	$sql_result=mysql_query($sql,$link_secure_m3or) or exit("Sql Error".mysql_error()); */
	$sql_result=know_order_status($schedule,$color,$size,$link_secure_m3or);
	if(mysqli_num_rows($sql_result)>0)
	{
		//New validation to check the previous operaiton - KiraG 2015-10-09
		if(($total_input+$recut_input+$replaced)>=($sfcs_qty+$reported_qty+$sample_qty)  and $tot_sin>=($sfcs_qty+$reported_qty+$sample_qty))
		{
			return "TRUE";
		}
		else
		{
			return "FALSE";
		}
	}
	else
	{
		return 'FALSE';
	}
	
}

//M3 Carton Pack Validation
function m3_cpk_validation($operation,$prevoperation,$schedule,$color,$size,$reportqty)
{
	$link_secure_m3or=construct_connection();
	
	$sfcs_qty=0;
	$prev_sfcs_qty=0;
			
	$sql="select COALESCE(sum(sfcs_qty),0) as sfcs_qty, COALESCE(sum(if(sfcs_reason='',sfcs_qty,0)),0) as sfcs_qty_filtered from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='$size' and m3_op_des='$operation' and sfcs_status<>90";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$sfcs_qty=$sql_row['sfcs_qty'];	
		$sfcs_qty_filtered=$sql_row['sfcs_qty_filtered'];	
	}
	
	$sql="select COALESCE(sum(sfcs_qty),0) as sfcs_qty, COALESCE(sum(if(sfcs_reason='',sfcs_qty,0)),0) as sfcs_qty_filtered from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='$size' and m3_op_des='$prevoperation' and sfcs_status<>90";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$prev_sfcs_qty=$sql_row['sfcs_qty'];	
		$prev_sfcs_qty_filtered=$sql_row['sfcs_qty_filtered'];	
	}
	
	/* Disabled to bring central control
	$sql="SELECT order_stat FROM bai_pro3.bai_orders_db_confirm WHERE order_del_no='$schedule' AND order_stat=''";
	//echo $sql;
	$sql_result=mysql_query($sql,$link_secure_m3or) or exit("Sql Error".mysql_error()); */
	$sql_result=know_order_status($schedule,$color,$size,$link_secure_m3or);
	if(mysqli_num_rows($sql_result)>0)
	{
		
		if($prev_sfcs_qty>=($sfcs_qty+$reportqty) and $prev_sfcs_qty_filtered>=($sfcs_qty_filtered+$reportqty))
		{
			return 'TRUE';
		}
		else
		{
			return 'FALSE';
		}	
	}
	else
	{
		return 'FALSE';
	}
}

function m3_cpk_validation_multi_color($operation,$prevoperation,$schedule,$color,$cartonid,$reportqty)
{
	$link_secure_m3or=construct_connection();
	$size_code_ref=array();
	$sql1="select distinct size_code as size from bai_pro3.pac_stat_log where doc_no_ref=\"".$cartonid."\""; 
	//echo $sql1."<br>";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		//echo "val=".know_m3_size_code($schedule,$sql_row1["size"],$color);	
		//$size_code_ref[]="'".know_m3_size_code($schedule,$sql_row1["size"],$color)."'";	
		$size_code_ref[]="'".$sql_row1["size"]."'";			
	}
	$size_code_ref_val=implode(",",$size_code_ref);
	//echo "value=".$size_code_ref_val."<br>";
	$sfcs_qty=0;
	$prev_sfcs_qty=0;
			
	$sql="select COALESCE(sum(sfcs_qty),0) as sfcs_qty, COALESCE(sum(if(sfcs_reason='',sfcs_qty,0)),0) as sfcs_qty_filtered from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size in (".$size_code_ref_val.") and m3_op_des='$operation' and sfcs_status<>90";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$sfcs_qty=$sql_row['sfcs_qty'];	
		$sfcs_qty_filtered=$sql_row['sfcs_qty_filtered'];	
	}
	
	$sql="select COALESCE(sum(sfcs_qty),0) as sfcs_qty, COALESCE(sum(if(sfcs_reason='',sfcs_qty,0)),0) as sfcs_qty_filtered from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size in (".$size_code_ref_val.") and m3_op_des='$prevoperation' and sfcs_status<>90";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$prev_sfcs_qty=$sql_row['sfcs_qty'];	
		$prev_sfcs_qty_filtered=$sql_row['sfcs_qty_filtered'];	
	}
	//echo "f=".$prev_sfcs_qty.">=(".$sfcs_qty."+".$reportqty.") and ".$prev_sfcs_qty_filtered.">=(".$sfcs_qty_filtered."+".$reportqty."<br>";
	/* Disabled to bring central control
	$sql="SELECT order_stat FROM bai_pro3.bai_orders_db_confirm WHERE order_del_no='$schedule' AND order_stat=''";
	//echo $sql;
	$sql_result=mysql_query($sql,$link_secure_m3or) or exit("Sql Error".mysql_error()); */
	$sql_result=know_order_status($schedule,$color,$size,$link_secure_m3or);
	if(mysqli_num_rows($sql_result)>0)
	{
		
		if($prev_sfcs_qty>=($sfcs_qty+$reportqty) and $prev_sfcs_qty_filtered>=($sfcs_qty_filtered+$reportqty))
		{
			return 'TRUE';
		}
		else
		{
			return 'FALSE';
		}	
	}
	else
	{
		return 'FALSE';
	}
}

//Considering Rejection.
function m3_emb_validation($operation,$prevoperation,$schedule,$color,$size,$reportqty)
{
	$link_secure_m3or=construct_connection();
	
	$sfcs_qty=0;
	$prev_sfcs_qty=0;
			
	$sql="select COALESCE(sum(sfcs_qty),0) as sfcs_qty from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='$size' and m3_op_des='$operation' and sfcs_status<>90";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$sfcs_qty=$sql_row['sfcs_qty'];	
	}
	
	$sql="select COALESCE(sum(sfcs_qty),0) as sfcs_qty from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='$size' and m3_op_des='$prevoperation' and sfcs_status<>90";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$prev_sfcs_qty=$sql_row['sfcs_qty'];	
	}
	
	/* Disabled to bring central control
	$sql="SELECT order_stat FROM bai_pro3.bai_orders_db_confirm WHERE order_del_no='$schedule' AND order_stat=''";
	//echo $sql;
	$sql_result=mysql_query($sql,$link_secure_m3or) or exit("Sql Error".mysql_error()); */
	$sql_result=know_order_status($schedule,$color,$size,$link_secure_m3or);
	if(mysqli_num_rows($sql_result)>0)
	{
	
		if($prev_sfcs_qty>=($sfcs_qty+$reportqty))
		{
			return 'TRUE';
		}
		else
		{
			return 'FALSE';
		}	
	}
	else
	{
		return 'FALSE';
	}
}


//New function to handle M3 based validations
function rejection_validation_m3($operation,$schedule,$color,$size,$reported_qty,$tid_ref,$username)
{
	$link_secure_m3or=construct_connection();
	
	/*
	1) (old+new Output) Should not be exceed input quantity (Only Module Input excluding EXCESS, SAMPLE, EMB) AND
	2) (input qty+recut input+replaced) <= (Old Reported Output qty+new reported output qty+rejected+sample+good garments)
	3) Point2: Input which includes everything from IMS.

	*/
	
	//Module Input
	$module_input=0;
	$total_input=0;
	//Disabled due to eliminate excess input from total input -kk 20150602 $sql="select sum(if(ims_mod_no>0 and ims_remarks not in ('EXCESS','EMB','SAMPLE','SHIPMENT_SAMPLE'),ims_qty,0)) as module_input, sum(ims_qty) as total_input from bai_pro3.ims_log where ims_schedule=$schedule and ims_color='$color' and ims_size='a_$size'";
	$sql="select sum(if(ims_mod_no>0 and ims_remarks not in ('EXCESS','EMB','SAMPLE','SHIPMENT_SAMPLE'),ims_qty,0)) as module_input, sum(if(ims_mod_no=0,0,ims_qty)) as total_input from bai_pro3.ims_log where ims_schedule=$schedule and ims_color='$color' and ims_size='a_$size'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$module_input=$sql_row['module_input'];
		$total_input=$sql_row['total_input'];
	}
	//Disabled due to eliminate excess input from total input -kk 20150602 $sql="select  sum(if(ims_mod_no>0 and ims_remarks not in ('EXCESS','EMB','SAMPLE','SHIPMENT_SAMPLE'),ims_qty,0)) as module_input, sum(ims_qty) as total_input from bai_pro3.ims_log_backup where ims_schedule=$schedule and ims_color='$color' and ims_size='a_$size'";
	$sql="select  sum(if(ims_mod_no>0 and ims_remarks not in ('EXCESS','EMB','SAMPLE','SHIPMENT_SAMPLE'),ims_qty,0)) as module_input, sum(if(ims_mod_no=0,0,ims_qty)) as total_input from bai_pro3.ims_log_backup where ims_schedule=$schedule and ims_color='$color' and ims_size='a_$size'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$module_input+=$sql_row['module_input'];
		$total_input+=$sql_row['total_input'];
	}
	
	//Recut Input Quantity
	$recut_input=0;
	
	$sql="select COALESCE(SUM(a_$size*a_plies),0) as recut_input from bai_pro3.recut_v2 where order_tid=(select order_tid from bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."' and order_col_des='".$color."') and remarks in ('Body','Front') and cut_inp_temp=1";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$recut_input=$sql_row['recut_input'];	
	}
	
	
	//Recut Input Quantity
	$recut=0;
	
	$sql="select COALESCE(SUM(a_$size*a_plies),0) as recut_input from bai_pro3.recut_v2 where order_tid=(select order_tid from bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."' and order_col_des='".$color."') and remarks in ('Body','Front') and act_cut_status='DONE'";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$recut=$sql_row['recut_input'];	
	}
	
	
	//Recut Input Quantity
	$cut_qty=0;
	
	$sql="select COALESCE(SUM(a_$size*a_plies),0) as cut_qty from bai_pro3.order_cat_doc_mk_mix where order_del_no='".$schedule."' and order_col_des='".$color."' and category in ('Body','Front') and act_cut_status='DONE'";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$cut_qty=$sql_row['cut_qty'];	
	}
	
	
	//Output
	$output=0;
	$sql="select sum(size_$size) as output from bai_pro.bai_log_buf where delivery=$schedule and color='$color'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$output=$sql_row['output'];
	}	
	
	$replaced=0;
	//Replaced Qty
	$sql="select COALESCE(sum(if(qms_tran_type=2,qms_qty,0)),0) as replaced from bai_pro3.bai_qms_db where qms_schedule=$schedule and qms_color='$color' and qms_size='$size'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$replaced=$sql_row['replaced'];
	}
	
	//////////////////////
	$return_value='FALSE';
	
	
	switch($operation)
	{
		case 'SOT':
		{
			
			$sfcs_qty=0;
			$input_rejected=0;
			
			$sql="select COALESCE(sum(sfcs_qty),0) as sfcs_qty from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='$size' and m3_op_des='SOT' and sfcs_status<>90";
			//echo $sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$sfcs_qty=$sql_row['sfcs_qty'];	
			}
			
			/* Disabled due to eliminate excess input from total input -kk 20150602
			$sql="select COALESCE(sum(sfcs_qty),0) as sfcs_qty from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='$size' and m3_op_des in ('SIN','PR') and sfcs_reason<>'' and sfcs_status<>90";
			//echo $sql;
			$sql_result=mysql_query($sql,$link_secure_m3or) or exit("Sql Error".mysql_error());
			while($sql_row=mysql_fetch_array($sql_result))
			{
				$input_rejected=$sql_row['sfcs_qty'];	
			}
			*/
			
			//Samples input to be considered.
			$sample_qty=0;
			$sql="select COALESCE(sum(ims_qty),0) as ims_qty from bai_pro3.ims_log where ims_schedule='$schedule' and ims_color='$color' and ims_size='a_$size' and ims_remarks in ('SAMPLE','SHIPMENT_SAMPLE')";
			//echo $sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$sample_qty=$sql_row['ims_qty'];	
			}
			
			/*
			$sql="select COALESCE(sum(ims_qty),0) as ims_qty from bai_pro3.ims_log_backup where ims_schedule='$schedule' and ims_color='$color' and ims_size='a_$size' and ims_remarks='SAMPLE'";
			//echo $sql;
			$sql_result=mysql_query($sql,$link_secure_m3or) or exit("Sql Error".mysql_error());
			while($sql_row=mysql_fetch_array($sql_result))
			{
				$sample_qty+=$sql_row['ims_qty'];	
			}
			*/
			
			if((($total_input+$recut_input+$replaced)-$input_rejected)>=($sfcs_qty+$reported_qty+$sample_qty))
			{
				$return_value='TRUE';
			}
			
			break;
		}
		
		case 'SAMPLE':
		{
			
			$sfcs_qty=0;
			$input_rejected=0;
			
			$sql="select COALESCE(sum(sfcs_qty),0) as sfcs_qty from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='$size' and m3_op_des='SOT' and sfcs_status<>90";
			//echo $sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$sfcs_qty=$sql_row['sfcs_qty'];	
			}
			
			//Samples input to be considered.
			$sample_qty=0;
			/*$sql="select COALESCE(sum(ims_qty),0) as ims_qty from bai_pro3.ims_log where ims_schedule='$schedule' and ims_color='$color' and ims_size='a_$size' and ims_remarks='SAMPLE'";
			//echo $sql;
			$sql_result=mysql_query($sql,$link_secure_m3or) or exit("Sql Error".mysql_error());
			while($sql_row=mysql_fetch_array($sql_result))
			{
				$sample_qty=$sql_row['ims_qty'];	
			}*/
			
			
			/* Disabled due to eliminate excess input from total input -kk 20150602
			$sql="select COALESCE(sum(sfcs_qty),0) as sfcs_qty from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='$size' and m3_op_des in ('SIN','PR') and sfcs_reason<>'' and sfcs_status<>90";
			//echo $sql;
			$sql_result=mysql_query($sql,$link_secure_m3or) or exit("Sql Error".mysql_error());
			while($sql_row=mysql_fetch_array($sql_result))
			{
				$input_rejected=$sql_row['sfcs_qty'];	
			}
			*/
			
			if((($total_input+$recut_input+$replaced)-$input_rejected)>=($sfcs_qty+$reported_qty+$sample_qty))
			{
				$return_value='TRUE';
			}
			
			break;
		}
		
		case 'SIN':
		{
			
			$sfcs_qty=0;
			$input_rejected=0;
			
			$sql="select COALESCE(sum(sfcs_qty),0) as sfcs_qty from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='$size' and m3_op_des='SIN'  and sfcs_status<>90";
			//echo $sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$sfcs_qty=$sql_row['sfcs_qty'];	
			}
			
			if(($cut_qty+$recut)>=($sfcs_qty+$reported_qty))
			{
				$return_value='TRUE';
			}
			
			break;
		}
		
		case 'PR':
		{
			
			$sfcs_qty=0;
			$input_rejected=0;
			
			$sql="select COALESCE(sum(sfcs_qty),0) as sfcs_qty from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='$size' and m3_op_des='PR'  and sfcs_status<>90";
			//echo $sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$sfcs_qty=$sql_row['sfcs_qty'];	
			}
			
			if(($cut_qty+$recut)>=($sfcs_qty+$reported_qty))
			{
				$return_value='TRUE';
			}
			
			break;
		}
		
		case 'CPK':
		{
			
			$sfcs_qty=0;
			$input_rejected=0;
			
			$sql="select COALESCE(sum(sfcs_qty),0) as sfcs_qty from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='$size' and m3_op_des='CPK'  and sfcs_status<>90";
			//echo $sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$sfcs_qty=$sql_row['sfcs_qty'];	
			}
			
			if($output>=($sfcs_qty+$reported_qty))
			{
				$return_value='TRUE';
			}
			
			break;
		}
		
		case 'ASPR':
		{
			return m3_emb_validation('ASPR','ASPS',$schedule,$color,$size,$reported_qty);
			
			break;
		}
		
		default:
		{
			$return_value='FALSE';
		}
	}
	
	/* Disabled to bring central control
	$sql="SELECT order_stat FROM bai_pro3.bai_orders_db_confirm WHERE order_del_no='$schedule' AND order_stat=''";
	//echo $sql;
	$sql_result=mysql_query($sql,$link_secure_m3or) or exit("Sql Error".mysql_error()); */
	$sql_result=know_order_status($schedule,$color,$size,$link_secure_m3or);
	if(mysqli_num_rows($sql_result)>0)
	{
		return $return_value;	
	}
	else
	{
		return 'FALSE';
	}	
	//@mysql_close($link_secure_m3or);
}



//Validation to avoid rejection entries 
function rejection_validation($operation,$schedule,$color,$size,$reported_qty,$tid_ref,$username)
{
	if($operation=="REJ")
	{
		
	
		$link_secure_m3or=construct_connection();
		
		/*
		1) (old+new Output) Should not be exceed input quantity (Only Module Input excluding EXCESS, SAMPLE, EMB) AND
		2) (input qty+recut input+replaced) <= (Old Reported Output qty+new reported output qty+rejected+sample+good garments)
		3) Point2: Input which includes everything from IMS.

		*/
		
		//Output
		$output=0;
		$sql="select COALESCE(sum(size_$size),0) as output from bai_pro.bai_log_buf where delivery=$schedule and color='$color'";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$output=$sql_row['output'];
		}	
		
		//Quality Details
		$rejected=0;
		$sample=0;
		$good_garments=0;
		$replaced=0;
		
		$sql="select sum(if(qms_tran_type=3,qms_qty,0)) as rejected, sum(if(qms_tran_type=4,qms_qty,0)) as sample, sum(if(qms_tran_type=5,qms_qty,0)) as good_garments, sum(if(qms_tran_type=2,qms_qty,0)) as replaced from bai_pro3.bai_qms_db where qms_schedule=$schedule and qms_color='$color' and qms_size='$size'";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$rejected=$sql_row['rejected'];
			$sample=$sql_row['sample'];;
			$good_garments=$sql_row['good_garments'];
			$replaced=$sql_row['replaced'];
		}
		
		$sql="select sum(if(qms_tran_type=3,qms_qty,0)) as rejected, sum(if(qms_tran_type=4,qms_qty,0)) as sample, sum(if(qms_tran_type=5,qms_qty,0)) as good_garments, sum(if(qms_tran_type=2,qms_qty,0)) as replaced from bai_pro3.bai_qms_db_archive where qms_schedule=$schedule and qms_color='$color' and qms_size='$size'";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$rejected+=$sql_row['rejected'];
			$sample+=$sql_row['sample'];;
			$good_garments+=$sql_row['good_garments'];
			$replaced+=$sql_row['replaced'];
		}
		
		$rejected+=$reported_qty;
		
		//Recut Input Quantity
		$recut_input=0;
		
		$sql="select COALESCE(SUM(a_$size*a_plies),0) as recut_input from bai_pro3.recut_v2 where order_tid=(select order_tid from bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."' and order_col_des='".$color."') and remarks in ('Body','Front') and act_cut_status='DONE'";
		//echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$recut_input=$sql_row['recut_input'];	
		}
		
		
		//Recut Input Quantity
		$cut_qty=0;
		
		$sql="select COALESCE(SUM(a_$size*a_plies),0) as cut_qty from bai_pro3.order_cat_doc_mk_mix where order_del_no='".$schedule."' and order_col_des='".$color."' and category in ('Body','Front') and act_cut_status='DONE'";
		//echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$cut_qty=$sql_row['cut_qty'];	
		}
		
		/*
		echo "<hr>Schedule:".$schedule."<br/>";
		echo "Color:".$color."<br/>";
		echo "Tid:".$tid_ref."<br/>";
		echo "Size:".$size."<br/>";
		echo "Output:".$output."<br/>";
		echo "Module Input:".$module_input."<br/>";
		echo "Total Input:".$total_input."<br/>";
		echo "Recut Input:".$recut_input."<br/>";
		echo "Replaced:".$replaced."<br/>";
		echo "Rejected:".$rejected."<br/>";
		echo "Sample:".$sample."<br/>";
		echo "Good Garments:".$good_garments."<br/>";
		echo "Reported:".$reported_qty."<br/>";
		echo "Line Input:".$line_input."<br/>";
		echo "Line Output:".$line_output."<br/>";
		*/
		
		/* Disabled to bring central control
		$sql="SELECT order_stat FROM bai_pro3.bai_orders_db_confirm WHERE order_del_no='$schedule' AND order_stat=''";
		//echo $sql;
		$sql_result=mysql_query($sql,$link_secure_m3or) or exit("Sql Error".mysql_error()); */
		$sql_result=know_order_status($schedule,$color,$size,$link_secure_m3or);
		if(mysqli_num_rows($sql_result)>0)
		{
		
			if((($cut_qty+$recut_input)>=($output+$rejected+$sample+$good_garments)))
			{
				return 'TRUE';
			}
			else
			{
				return 'FALSE';
			}
		}
		else
		{
			return 'FALSE';
		}
		
		//@mysql_close($link_secure_m3or);
	}
	else
	{
		/* Disabled to bring central control
		$sql="SELECT order_stat FROM bai_pro3.bai_orders_db_confirm WHERE order_del_no='$schedule' AND order_stat=''";
		//echo $sql;
		$sql_result=mysql_query($sql,$link_secure_m3or) or exit("Sql Error".mysql_error()); */
		$sql_result=know_order_status($schedule,$color,$size,$link_secure_m3or);
		if(mysqli_num_rows($sql_result)>0)
		{
			return 'TRUE'; //SKIP Call
		}
		else
		{
			return 'FALSE';
		}
	}
}



?>



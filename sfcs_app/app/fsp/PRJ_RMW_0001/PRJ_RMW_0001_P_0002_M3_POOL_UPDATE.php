<?php

$log_id=$_GET['log_id'];
$date_limit=$_GET['date_limit'];
$wh_filter=array();
$wh_filter=explode(",",$_GET['wh_filter']);

echo date("YmdHis");
$connect_m3 = odbc_connect("bcimovsms01_bai", "BAIMacroReaders", "BAI@macrosm3");
$connect = odbc_connect("BAINET_INTRANET_NEW", "sa", "Brandix@7");

$connect_new = odbc_connect("BAINET_INTRANET", "sa", "Brandix@7");



//To track completed log
$query = "IF OBJECT_ID(N'[DBS_RMW_0001].[dbo].[T_0001_009_TEMP_UNQ_STYLES]', N'U') IS NULL CREATE TABLE [DBS_RMW_0001].[dbo].[T_0001_009_TEMP_UNQ_STYLES] ( style varchar(30), status int)";
//echo $query;
odbc_exec($connect_new, $query);

$query = "truncate table [DBS_RMW_0001].[dbo].[T_0001_009_TEMP_UNQ_STYLES]";
//echo $query;
odbc_exec($connect_new, $query);

$query = "insert into [DBS_RMW_0001].[dbo].[T_0001_009_TEMP_UNQ_STYLES] (style,status) select distinct style, 0 as status FROM [DBS_RMW_0001].[dbo].[V_0001_0001_FRPLAN_POOL] where (prod_status=0 or prod_status is null) and production_date<='".$date_limit."'";
//echo $query;
odbc_exec($connect_new, $query);
			
			

$query = "select distinct style, 0 as status FROM [DBS_RMW_0001].[dbo].[V_0001_0001_FRPLAN_POOL] where (prod_status=0 or prod_status is null) and production_date<='".$date_limit."'";


//$query = "select distinct style,status FROM [DBS_RMW_0001].[dbo].[T_0001_009_TEMP_UNQ_STYLES] where status=2";

echo $query."<br>";
$result = odbc_exec($connect_new, $query);
$unique_styles=array();
while(odbc_fetch_row($result))
{ 
	//When M3 offline comment this
	$unique_styles[]=odbc_result($result, 1); 
}

$process_styles=array();
$completed_styles=array();
$process_styles=array_diff($unique_styles,$completed_styles);
do{
	
	for($i=0;$i<sizeof($process_styles);$i++)
	{
		$query = "TFR_BEL_BAI_STYLE_WISE_RM_INDIA_REQUIREMENT_NEW '".$process_styles[$i]."', '', ''";
		$result = odbc_exec($connect, $query);
		
		if(odbc_num_rows($result)==0)
		{
			$query = "TFR_BEL_BAI_STYLE_WISE_RM_INDIA_REQUIREMENT '".$process_styles[$i]."', '', ''";
			$result = odbc_exec($connect_m3, $query);
		}
		while(odbc_fetch_row($result))
		{
			
			if(in_array(odbc_result($result, 14),$wh_filter))
			{
				//M3 PROC_GROUP is FSP PROD_GROUP due to existing fix structure
				//M3 PROD_GROUP is FSP PROC_GROUP
				
				$query = "INSERT INTO [DBS_RMW_0001].[dbo].[T_0001_001_M3BOMPOOL] ([IDNO],[PURCH_WH],[STYLE],[GMT_COLOUR],[GMT_SIZE],[GMT_ZFEATURE],[PROC_GRP],[PROD_GRP],[MATERIAL_ITEM],[ITEM_DESCRIPTION],[MAT_COLOUR],[MAT_SIZE],[MAT_Z],[WAREHOUSE],[LTYPE],[CO],[CO_QTY],[SCHEDULE],[PCD],[DELDATE],[CONSUMPTION],[PRICE],[UOM],[WASTAGE],[REQUIRED_],[ISSUED],[BAL_TO_ISSUE],[PO_NO],[PO_DATE],[XMILL_DATE],[PO_QTY],[P_UOM],[EXP_QTY],[PL_IH_DATE],[SUPPLIER],[MODE],[ARRIVAL_DATE],[TTYPE],[STOCKDATE],[SEQ],[TR_QTY],[PROJECTED_BALANCE]) VALUES ("."'".odbc_result($result, 1)."',"."'".odbc_result($result, 2)."',"."'".odbc_result($result, 3)."',"."'".odbc_result($result, 4)."',"."'".odbc_result($result, 5)."',"."'".odbc_result($result, 6)."',"."'".odbc_result($result, 7)."',"."'".odbc_result($result, 8)."',"."'".odbc_result($result, 9)."',"."'".odbc_result($result, 10)."',"."'".odbc_result($result, 11)."',"."'".odbc_result($result, 12)."',"."'".odbc_result($result, 13)."',"."'".odbc_result($result, 14)."',"."'".odbc_result($result, 15)."',"."'".odbc_result($result, 16)."',"."'".odbc_result($result, 17)."',"."'".odbc_result($result, 18)."',"."'".odbc_result($result, 19)."',"."'".odbc_result($result, 20)."',"."'".odbc_result($result, 21)."',"."'".odbc_result($result, 22)."',"."'".odbc_result($result, 23)."',"."'".odbc_result($result, 24)."',"."'".odbc_result($result, 25)."',"."'".odbc_result($result, 26)."',"."'".odbc_result($result, 27)."',"."'".odbc_result($result, 28)."',"."'".odbc_result($result, 29)."',"."'".odbc_result($result, 30)."',"."'".odbc_result($result, 31)."',"."'".odbc_result($result, 32)."',"."'".odbc_result($result, 33)."',"."'".odbc_result($result, 34)."',"."'".odbc_result($result, 35)."',"."'".odbc_result($result, 36)."',"."'".odbc_result($result, 37)."',"."'".odbc_result($result, 38)."',"."'".odbc_result($result, 39)."',"."'".odbc_result($result, 40)."',"."'".odbc_result($result, 41)."',"."'".odbc_result($result, 42)."'".")";
				echo $query."<br>";
				odbc_exec($connect_new, $query);
			}
		}
		$completed_styles[]=$process_styles[$i];
		
		//To track completed styles
		$query = "update [DBS_RMW_0001].[dbo].[T_0001_009_TEMP_UNQ_STYLES] set status=1 where [DBS_RMW_0001].[dbo].TRIM(style)=[DBS_RMW_0001].[dbo].trim('".$process_styles[$i]."')";
//echo $query;
		odbc_exec($connect_new, $query);
	}
	
	unset($process_styles);
	$process_styles=array_diff($unique_styles,$completed_styles);
}while(sizeof($process_styles)!=0);


/*
//To Backup M3 Data
$query = "delete from [DBS_RMW_0001].[dbo].T_0001_001_M3BOMPOOL_BACKUP where style in (select distinct style from [DBS_RMW_0001].[dbo].T_0001_001_M3BOMPOOL)";

//echo $query;
odbc_exec($connect_new, $query);


$query = "insert into [DBS_RMW_0001].[dbo].T_0001_001_M3BOMPOOL_BACKUP select * from [DBS_RMW_0001].[dbo].T_0001_001_M3BOMPOOL where SCHEDULE>0";

//echo $query;
odbc_exec($connect_new, $query);

$query = "delete from [DBS_RMW_0001].[dbo].[T_0001_001_M3BOMPOOL_BACKUP] where [style] not in (SELECT distinct [style] FROM [DBS_RMW_0001].[dbo].[T_0001_002_FRPLAN])";

//echo $query;
odbc_exec($connect_new, $query);

	$query = "truncate table [DBS_RMW_0001].[dbo].[T_0001_001_M3BOMPOOL_STOCK_BACKUP]";
	odbc_exec($connect_new, $query);
	$query = "insert into [DBS_RMW_0001].[dbo].[T_0001_001_M3BOMPOOL_STOCK_BACKUP] select * from [DBS_RMW_0001].[dbo].[T_0001_001_M3BOMPOOL_STOCK]";
	odbc_exec($connect_new, $query);


$query = "truncate table [DBS_RMW_0001].[dbo].[T_0001_001_M3BOMPOOL_STOCK]";

//echo $query;
odbc_exec($connect_new, $query);

$query = "insert into [DBS_RMW_0001].[dbo].[T_0001_001_M3BOMPOOL_STOCK] ([code],[PURCH_WH],[LTYPE],[MATERIAL_ITEM],[ITEM_DESCRIPTION],[PROC_GRP],[MAT_COLOUR],[MAT_SIZE],[WAREHOUSE],[PRICE],[UOM],[PO_NO],[PO_DATE],[XMILL_DATE],[PO_QTY],[P_UOM],[EXP_QTY],[PL_IH_DATE],[SUPPLIER],[MODE],[ARRIVAL_DATE],[STOCKDATE],[SEQ],[TR_QTY]) select distinct (cast([MATERIAL_ITEM] as varchar)+cast([WAREHOUSE] as varchar)+cast([SEQ] as varchar)+cast([TR_QTY] as varchar)) as code,[PURCH_WH],[LTYPE],[MATERIAL_ITEM],[ITEM_DESCRIPTION],[PROC_GRP],[MAT_COLOUR],[MAT_SIZE],[WAREHOUSE],[PRICE],[UOM],[PO_NO],[PO_DATE],[XMILL_DATE],[PO_QTY],[P_UOM],[EXP_QTY],[PL_IH_DATE],[SUPPLIER],[MODE],[ARRIVAL_DATE],[STOCKDATE],[SEQ],[TR_QTY] from [DBS_RMW_0001].[dbo].[T_0001_001_M3BOMPOOL] where SEQ>0";

//echo $query;
odbc_exec($connect_new, $query);
*/


$query = "update [DBS_RMW_0001].[dbo].[T_0001_010_EXE_LOG] set end_time='".date("Y-m-d H:i:s")."' where log_id='".$log_id."'";

//echo $query;
odbc_exec($connect_new, $query);

//To track completed styles
$query = "drop table [DBS_RMW_0001].[dbo].[T_0001_009_TEMP_UNQ_STYLES]";
//echo $query;
odbc_exec($connect_new, $query);



odbc_close($connect); 	
odbc_close($connect_new); 

echo date("YmdHis");

//echo "<script> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
?> 
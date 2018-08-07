
<?php

include('dbconf.php');

/*
M3 Status Code Reference.

Id	Name	Description
1	No PO	No PO
2	POP	POP
3	Unapproved	Unapproved
4	PO Created	PO Created
5	Confirmed	Confirmed
6	Transport Notified 	Transport Notified 
7	Received 	Received 
8	Inspection	Inspection
9	Stock(PWH)	Stock(PWH)
10	Stock(MWH)	Stock(MWH)
11	Exempted	Exempted
12	Issued	Issued
13	Auto Exempted	Auto Exempted
14	Reject	Reject





*/
	// $test="select * from bai_rm_pj1.store_in";
	// $sql_barcode=mysqli_query($link, $test) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// while($barcode_rslt = mysqli_fetch_array($sql_barcode))
	// {
	// 	echo "test</br>";
	// }

	$folders_list=array("input");
	//var_dump($folders_list);
	//echo $folders_list[0];
	$folder_status=array(40);
	
	for($i=0;$i<sizeof($folders_list);$i++)
	{
		//$files=glob("./".$folders_list[$i]."/*_$facility_code"."_*.csv");
		//modified the file path from _* due to change in APID 2017-05-06 KiranG
		$files=glob("./".$folders_list[$i]."/RM_Dashboard.csv");
		//echo "./".$folders_list[$i]."/$facility_code"."_"."*.csv";
		//var_dump($files);
		foreach($files as $filepath)
		{
			//echo basename($filepath);
			$filename=basename($filepath);
			
			
				$handle=fopen($filepath,"r");
				//echo $handle."</br>";
				$i=0;
				while(($data1=fgetcsv($handle,1000,","))!==FALSE)
				{	
					if($i>0){
						
						//var_dump($data);
						$data = explode("\t",$data1[0]);
						//var_dump($data);
						//echo "Data : ".$data[2]."</br>";
						$ft_status=null;
						if(in_array($data[6],array(10,11,13)))
						{
							$ft_status=1;
						}
						else
						{
							$ft_status=0;
						}
						
						$st_status=null;
						if(in_array($data[8],array(10,11,13)))
						{
							$st_status=1;
						}
						else
						{
							$st_status=0;
						}
						
						$pt_status=null;
						if(in_array($data[10],array(10,11,13)))
						{
							$pt_status=1;
						}
						else
						{
							$pt_status=0;
						}
						
						$sql1="update bai_pro3.bai_orders_db set ft_status=$ft_status,st_status=$st_status,pt_status=$pt_status where order_del_no='".$data[1]."' and order_col_des='".$data[2]."'";
						echo "Orders DB: ".$sql1."<br/>";
						mysqli_query($sql1,$link) or exit("Sql Error".mysql_error());
						
						$sql2="update bai_pro3.bai_orders_db_confirm set ft_status=$ft_status,st_status=$st_status,pt_status=$pt_status where order_del_no='".$data[1]."' and order_col_des='".$data[2]."'";
						echo "Orders DB Confirm: ".$sql1."<br/>";
						mysqli_query($sql2,$link) or exit("Sql Error".mysql_error());
					
					}
					
					$i++;
				}
				
				
				fclose($handle);
			
		}
	}
	

	echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";


//@mysql_close($link_secure_m3or);
//@mysql_close($link_secure_m3or_update);
?>

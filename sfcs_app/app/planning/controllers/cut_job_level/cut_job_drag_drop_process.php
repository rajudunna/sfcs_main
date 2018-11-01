<?php


	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'functions.php',1,'R')); 	
	$userName = getrbac_user()['uname'];
	$list=$_POST['listOfItems'];
	//echo $list;
	$list_db=array();
	$list_db=explode(";",$list);
	
	$x=1;
	
	for($i=0;$i<sizeof($list_db);$i++)
	{
		$items=array();
		$items=explode("|",$list_db[$i]);
		//module-doc_no
		
		if($items[0]=="allItems")
		{
	         
			$sql1="DELETE from $bai_pro3.cutting_table_plan where doc_no=".$items[1];
			// echo "<br>1=".$sql1."<br>";
			mysqli_query($link,$sql1) or exit("Sql Error6".mysqli_error());
			
		}
		else
		{
			
                $sql12="select * from $bai_pro3.cutting_table_plan where doc_no='$items[1]'";
                //echo $sql12;

				$resultr112=mysqli_query($link, $sql12) or exit("Sql Error5 == ".$sql12.' == '.mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($resultr112)==0)
				{
		            $sql12="select * from $bai_pro3.tbl_cutting_table where tbl_id='$items[0]' and status='active'";
					$resultr112=mysqli_query($link, $sql12) or exit("Sql Error5 == ".$sql12.' == '.mysqli_error($GLOBALS["___mysqli_ston"]));
					//echo $sql12;
					while($sql_row12=mysqli_fetch_array($resultr112))
					{
						$tbl_id=$sql_row12["tbl_id"];
					}
					$insert_log_query="INSERT INTO $bai_pro3.cutting_table_plan (doc_no,priority,dashboard_ref,cutting_tbl_id,doc_no_ref,username, log_time) VALUES('".$items[1]."', '".$x."','CUT','".$tbl_id."',  '".$items[1]."','".$userName."', NOW())";
					 //echo $insert_log_query."<br>";
					mysqli_query($link, $insert_log_query) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
				}			
			$x++;
				
		}
    }
		
		
	$url1 = getFullURLLevel($_GET['r'],'dashboards/controllers/Cut_table_dashboard/cut_table_dashboard_cutting.php',3,'N');
		
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url1\"; }</script>";

?>
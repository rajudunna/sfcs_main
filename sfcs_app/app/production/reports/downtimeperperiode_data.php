

<!--IMPORT CSS STYLE SHEET FOR APPLYING FORMATING SETTINGS-->
<!--<link rel="stylesheet" type="text/css" href="test.css" />-->
<style>
.tblheading
	{
	color: #fff;
    background-color: #337ab7;
    border-color: #337ab7;
	}
/* td{
	border-color: black;
}	
table
{
	border-color: black;
	
}
tr
{
	border-color: black;
} */
</style>


<?php

$sdat=$_GET["sdat"];
$edat=$_GET["edat"];

// include"header.php";
// include"downtimeperperiode.php";

 include("..".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].getFullURL($_GET['r'],'downtimeperperiode.php','R'));

echo "<div class='panel panel-primary'>";
echo "<div class='panel-body'>";
echo "<center><h2 align='center' class='label label-warning'><b>Department DownTime For Dates between (".$sdat." to ".$edat.")</b></h2><hr/></center>";
echo "<div class='table-responsive'>";
echo "<table class='table table-bordered'>
	      <tr class='tblheading'>
		   <th >DepName</th>";
		   
		   $date1=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT DISTINCT DATE FROM $bai_pro.grand_rep WHERE DATE BETWEEN '$sdat' AND '$edat' ORDER BY DATE"); 
		   while($rr=mysqli_fetch_array($date1))
		   {
		   	 echo "<th >".$rr['DATE']."</th>";
		   }	 
		      
		   echo "<th>Total</th>";	  
		   echo "</tr>";	   
		  

  		   $sql1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from $database.$table");          
		  
		   while($rows=mysqli_fetch_array($sql1))
		   {    
		   	 	 echo "<tr>";
				 echo "<th>".$rows['dep_name']."</th>";
				 
				 $date2=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT DISTINCT date FROM $bai_pro.grand_rep WHERE date BETWEEN '$sdat' AND '$edat' order by date"); 
			  	
				 while($rrr=mysqli_fetch_array($date2))
			  	 {			   		
					$t=$rrr['date'];
					
					$date4=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT sum(dtime) FROM $bai_pro.down_log WHERE department=".$rows['dep_id']." and date='$t'"); 

                    while($result=mysqli_fetch_array($date4))
				 	{			    
					       if($result['sum(dtime)'] == 0)
				        	{
								echo "<td>".round($result['sum(dtime)']/60,0)."</td>";
							}
							else
							{
								echo "<td bgcolor='#ccddff'>".round($result['sum(dtime)']/60,0)."</td>";					
							}						  
					}				
							 
			  	 }
				 
				 $date66=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT sum(dtime) FROM $bai_pro.down_log WHERE department=".$rows['dep_id']." and date BETWEEN '$sdat' AND '$edat' order by date"); 

                 while($resultrt=mysqli_fetch_array($date66))
				 {			    
				      echo "<td>".round($resultrt['sum(dtime)']/60,0)."</td>";				  
				 }		 
				      
				 echo "</tr>";	
				 
		   }  
		    
		   echo "<tr>";
		   echo "<th>Total Lost Time</th>";   
		   
		   $date2=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT DISTINCT date FROM $bai_pro.grand_rep WHERE date BETWEEN '$sdat' AND '$edat' order by date"); 
			  	
		   while($rrr=mysqli_fetch_array($date2))
		   {			   		
			    $t=$rrr['date'];
					
				$date4=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT sum(dtime) FROM $bai_pro.down_log WHERE date='$t'"); 

                while($result=mysqli_fetch_array($date4))
				{			    
					   echo "<td>".round($result['sum(dtime)']/60,0)."</td>";				  
			    }			 
		   }
				 	
		         $date66=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT sum(dtime) FROM $bai_pro.down_log where date BETWEEN '$sdat' AND '$edat' order by date"); 

                 while($resultrt=mysqli_fetch_array($date66))
				 {			    
				      echo "<td>".round($resultrt['sum(dtime)']/60,0)."</td>";				  
				 }			 			 
		  
		         echo "</tr>";
		  		  
		         echo "<tr>";		  
		         echo "<th>Clock Hours</th>";
		   
				 $date2=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT DISTINCT date FROM $bai_pro.grand_rep WHERE date BETWEEN '$sdat' AND '$edat' order by date"); 
			  	
				 while($rrr=mysqli_fetch_array($date2))
			  	 {			   		
					$t=$rrr['date'];
					
					$date4=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT sum(plan_clh) FROM $bai_pro.grand_rep WHERE date='$t'"); 

                    while($result=mysqli_fetch_array($date4))
				 	{			    
					   echo "<td>".round($result['sum(plan_clh)'],0)."</td>";				  
					}			 
			  	 }	
				
				 $date66=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT sum(plan_clh) FROM $bai_pro.grand_rep where date BETWEEN '$sdat' AND '$edat' order by date"); 

                 while($resultrt=mysqli_fetch_array($date66))
				 {			    
				     echo "<td>".round($resultrt['sum(plan_clh)'],0)."</td>";				  
			     }			 			 
		  
		         echo "</tr>";
		
		         echo "<tr>";
		         echo "<th>TOTAL LOST TIME %</th>";		
		
		         $date2=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT DISTINCT date FROM $bai_pro.grand_rep WHERE date BETWEEN '$sdat' AND '$edat' order by date"); 
			  	
				 while($rrr=mysqli_fetch_array($date2))
			  	 {		
					 $t=$rrr['date'];
					
					 $date4=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT sum(dtime) FROM $bai_pro.down_log WHERE date='$t'"); 

                     while($result=mysqli_fetch_array($date4))
				 	 {			    
					   $tt=round($result['sum(dtime)'],0);				  
					 }	
					 
					 $date5=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT sum(plan_clh) FROM $bai_pro.grand_rep WHERE date='$t'"); 
 
                     while($result5=mysqli_fetch_array($date5))
				 	 {			    
					   $cc=round($result5['sum(plan_clh)'],0);				  
					 }
					 
					 if($tt != 0 && $cc !=0)	
				     {
						 echo "<td>".round(($tt/$cc),2)."%</td>";			
					 }
					 else
					 {
					 	echo "<td>0</td>";	
					 }						    			 
			  	 }
				 
				 $date67=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT sum(dtime) FROM $bai_pro.down_log where date BETWEEN '$sdat' AND '$edat' order by date"); 

                 while($resultxxr=mysqli_fetch_array($date67))
				 {			    
				     $tz=round($resultxxr['sum(dtime)']/60,0);				  
			     }		
				 
				 $date68=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT sum(plan_clh) FROM $bai_pro.grand_rep where date BETWEEN '$sdat' AND '$edat' order by date"); 

                 while($resultxx=mysqli_fetch_array($date68))
				 {			    
				     $tf=round($resultxx['sum(plan_clh)']/60,0);				  
			     }
				 
				 if($tz != 0 && $tf !=0)
				 {
				 	echo "<td>".round(($tf/$tz)*100,0)."%</td>";
				 }
				 else
				 {
				 	echo "<td>0</td>";	
				 }				 
				  
		         echo "</tr>";
			  
echo "</table>";
echo "</div>";
echo "</div>";
echo "</div>";
?>

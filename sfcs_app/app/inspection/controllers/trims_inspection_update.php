<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R')); 
$Page_Id='SFCS_0051';
?>
<div class="panel panel-primary">
	 <div class="panel-heading">Trims Inspection Update</div>
		<div class="panel-body">
			<form method="post" class="form-horizontal form-label-left" name="input2" action="?r=<?php 		echo $_GET['r']; ?>">
			
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" >
								Enter Lot No: <span class="required"></span>
					</label>
					<div class="col-md-4 col-sm-4 col-xs-12">
						<input class="form-control input-sm integer" required type="text" class='integer' id="course" name="lot_no1"> 
					</div>
					 <input  class="btn btn-primary" type="submit" name="submit1" value="Search">
				</div>
			</form>
		
<?php
			if(isset($_POST['submit1']))
			{
				$lot_no1=$_POST['lot_no1'];
				$sql="select batch_no as 'batch_num' from $bai_rm_pj1.sticker_report where lot_no=\"".trim($lot_no1)."\" 
					and product_group <> 'Fabric' ";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$batch_no=$sql_row['batch_num'];
				}
				if (mysqli_num_rows($sql_result) == 0) 
				{
					echo '<br><div class="alert alert-danger">
									<strong> Invalid Lot Number </strong>
							</div>';
				}
				else
				{
					$url = getURL(getBASE($_GET['r'])['base'].'/C_Tex_Interface_V7.php')['url'];
					echo "<script type='text/javascript'>";
					echo "setTimeout('Redirect()',0);";
					echo "var url='".$url."&batch_no=".urlencode($batch_no)."&lot_ref=".urlencode($lot_no1)."';";
					echo "function Redirect(){location.href=url;}</script>";
				}
				
			}
?>
		</div>
</div>

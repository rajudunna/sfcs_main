<script type="text/javascript">
	function validateQty(event) 
	{
		event = (event) ? event : window.event;
		var charCode = (event.which) ? event.which : event.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}
</script>

<?php

		echo'<div class="panel panel-primary">
			<div class="panel-heading"><b>Update RM Receiving (Stock IN)</b></div>
            <div class="panel-body">
            	<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<form method="post" name="inputx" action="'.getURL(getBASE($_GET['r'])['path'])['url'].'">
								<div class="col-md-8">
									<label>Receiving / Lot #:</label>
									<input type="text" id="course" name="lot_no" class="form-control integer" required />
								</div>
								<div class="col-md-4">
									<input type="submit" name="submit" value="Search" class="btn btn-success" style="margin-top: 22px;" >
								</div>
							</form>
						</div>
						<div class="col-sm-6">
							<form method="post" name="testx" action="'. getFullURL($_GET['r'],'quick_insert_v1.php','N').'">
								<div class="col-md-8">
										<label>Invoice/Batch/PO #:</label> 
										<input type="text" name="reference" value="" class="form-control alpha" required />
								</div>
								<div class="col-md-4">
										<input type="submit" value="Search" name="submit" class="btn btn-success" style="margin-top: 22px;">
								</div>
							</form>
						</div>
					</div>
				</div><br/>
			';

// echo "<input type='button' value='Hide' id='sh' class='pull-right btn btn-sm btn-danger'>";
// $sql1="select * from sticker_report";
// //echo $sql1;
//  $main_result1 = mysqli_query($link, $sql1) or exit("Sql Error_8: ".mysqli_error($GLOBALS["___mysqli_ston"]));
// if(mysqli_num_rows($main_result1)>0)
// 	{
// 		echo "<div id='box' class='col-sm-12' style='overflow:scroll;max-height:700px;'>";		
// 		echo '<hr>
// 				 <table id="table1" class="table table-bordered table-responsive">
// 				 <tr><th>Receiving #</th><th>Item</th><th>Item Name</th>
// 					 <th>Item Description</th><th>Invoice #</th><th>PO #</th><th>Qty</th><th>Labeled</th><th>Lot#</th>
// 					 <th>Batch #</th><th>Product</th><th>PKG No</th><th>GRN Date</th>
// 				 </tr>';
		
// 		while($sql_row2=mysqli_fetch_array($main_result1))
// 		{
			
// 			$sql="select coalesce(sum(qty_rec),0) as \"in\" from store_in where lot_no=\"".$sql_row2['lot_no']."\"";
// 			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// 			while($sql_row=mysqli_fetch_array($sql_result))
// 			{
// 				$in=$sql_row['in'];
// 			}
// 			$url =  getFullURL($_GET['r'],'insert_v1.php','N');
// 			echo "<tr><td><a href=\"$url&lot_no=".$sql_row2['lot_no']."\" class=\"btn btn-info btn-xs\">".$sql_row2['rec_no']."</a></td><td>".$sql_row2['item']."</td><td>".$sql_row2['item_name']."</td>
// 				  <td>".rtrim($sql_row2['item_desc'],'/ ')."</td><td>".$sql_row2['inv_no']."</td><td>".$sql_row2['po_no']."</td><td>".$sql_row2['rec_qty']."</td><td>$in</td>";
// 			echo "<td>".$sql_row2['lot_no']."</td><td>".$sql_row2['batch_no']."</td><td>".$sql_row2['product_group']."</td><td>".$sql_row2['pkg_no']."</td><td>".$sql_row2['grn_date']."</td>";
			

// 			echo "</tr>";

// 		}
// 		// echo '<tr class="bottom danger">
// 		// 	<td>Total:</td>
// 		// 	<td></td><td></td><td></td><td></td><td></td>
// 		// 	<td id="table1Tot1" style="background-color:#FFFFCC;"></td>
// 		// 	<td></td><td></td><td></td><td></td><td></td><td></td>
// 		// 	</tr>';
			
// 		echo "</table>";
// 		echo "</div>";
// 		// echo '</form>';
// 	}


// // echo
// ?>

 <script>
// 	$('#sh').on('click',function(){
// 		if($(this).val()=='Show'){
//             $('#box').show();
//             $('#sh').removeClass('btn-info');
// 	        $('#sh').addClass('btn-danger');
// 	        $('#sh').val('Hide');
// 		}else{
// 	        $('#box').hide();
// 	        $('#sh').removeClass('btn-danger');
// 	        $('#sh').addClass('btn-info');
// 	        $('#sh').val('Show');
//         }
// 	});
// </script>
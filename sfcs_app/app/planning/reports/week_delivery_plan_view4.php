<?php
ini_set('max_execution_time',0);
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/M3_BULK_OR/ims_size.php"); 

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'dbweeklyreport_conf.php',1,'R'));

// $view_access=user_acl("SFCS_0040",$username,1,$group_id_sfcs);
// var_dump($sizes_array);
$has_perm=haspermission($_GET['r']);
?>

<?php
$start_date_w=time();

while((date("N",$start_date_w))!=1) {
$start_date_w=$start_date_w-(60*60*24); // define monday
}
$end_date_w=$start_date_w+(60*60*24*6); // define sunday 

//echo date("Y-m-d",$end_date_w)."<br/>";
//echo date("Y-m-d",$start_date_w);
$start_date_w=date("Y-m-d",$start_date_w);
$end_date_w=date("Y-m-d",$end_date_w);
?>


<!-- <script src = "http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.2.4.js"></script> -->

<!-- <script src="<?= '../'.getFullURL($_GET['r'],'jquery.columnmanager/jquery.min.js','R') ?>"></script>
<script src="<?= getFullURL($_GET['r'],'table2CSV.js','R') ?>"></script>
<script src="<?= getFullURL($_GET['r'],'jquery.columnmanager/jquery.columnmanager.js','R') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?= getFullURL($_GET['r'],'jquery.columnmanager/clickmenu.css','R') ?>" />
<script src="<?= getFullURL($_GET['r'],'jquery.columnmanager/jquery.clickmenu.pack.js','R') ?>"></script> -->
<style>

.toggleview li{
	float:left;
	padding: 10px;
	
	margin:2px;
}
#tableone thead.Fixed
{
     position: absolute; 
}
thead {
    background: #337ab7 !important;
    color: white !important;
}

</style>


<!-- Filter -->
<!-- <script>
	/**
 *  jQuery ColumnFilter Plugin
 *  @requires jQuery v1.2.6 or greater
 *  http://hernan.amiune.com/labs
 *
 *  Copyright (c)  Hernan Amiune (hernan.amiune.com)
 *  Licensed under MIT license:
 *  http://www.opensource.org/licenses/mit-license.php
 * 
 *  Version: 1.1
 	*/
jQuery.noConflict();

(function($) {
    $.fn.columnfilter = function(options) {

        var defaults = {};

        var options = $.extend(defaults, options);

        return this.each(function(index) {
        	
            var $table = jQuery(this);
            $table.find("th.filter").each(function() {
                //create a select list for each filter column
                var i = 0;
                var $select = $('<select class="selectfilter" multiple></select>');
                var $this = jQuery(this);
                var colindex = $this.parent().children().index($this) + 1;
                var dictionary = [];
                $table.find("tr td:nth-child(" + colindex + ")").each(function() {
                    var text = jQuery(this).text();
                    //alert(text);
                    dictionary[text] = true;
                });
                var colkeys = [];
                for (i in dictionary) colkeys.push(i);
                colkeys.sort();
                $select.append('<option value="All" selected>All</option>');
				var eliminate="$family associate clean combine contains each empty erase every extend filter flatten forEach getLast getRandom hexToRgb hsbToRgb include link map rgbToHex rgbToHsb some toJSON "; // To eliminate jquery error
//var eliminate="$family associate"; // To eliminate jquery error
                for (i=0; i<colkeys.length; i++) {
                    if(colkeys[i] === "indexOf")continue; //weird stuff happens in ie and chrome, firefox is awesome
					
					if(!eliminate.contains(colkeys[i]))
					//eliminate += colkeys[i] + " ";
					//$("#ages").html(eliminate);
                    $select.append('<option value="' + colkeys[i] + '">' + colkeys[i] + '</option>');
                }
                jQuery(this).append("<br/>");
                jQuery(this).append($select);

                //bind change function to each select filter
                $select.change(function() {

                    //create an array of the filters selected values
                    var colIndexes = [];
                    var selectedOptions = [];
                    $table.find(".selectfilter").each(function() {
                        $this = jQuery(this);
                        var $parent = jQuery(this).parent();
                        colIndexes.push($parent.parent().children().index($parent)+1);
                        //selectedOptions.push($this.children(":selected").text());
						var test="";
						$this.children(":selected").each(function(x, selected) {
						test += $(selected).text() + " ";
						});
						selectedOptions.push(test);
						//alert(test);
                    });
					

                    //show or hide the corresponding rows
                    $table.find("tr").each(function(rowindex) {
                        if (rowindex > 0) {
                            var rowok = true;
                            for (i = 0; i < colIndexes.length;  i++) {
                                text = jQuery(this).find("td:nth-child(" + colIndexes[i] + ")").text()+" ";
									
							   // if (selectedOptions[i] != "All " && text != selectedOptions[i] && selectedOptions[i].indexOf(text)>0) rowok = false;
								 if (selectedOptions[i] != "All " && selectedOptions[i].indexOf(text)<0) rowok = false;
								//if (selectedOptions[i] != "All " && text != selectedOptions[i]) rowok = false;
                            }
                            if (rowok === true) $(this).show();
                            else jQuery(this).hide();
                        }
                    });

                });
            });

        });

    } 
})(jQuery);
	</script> -->

<!-- Filter -->

<!-- <script>

jQuery(document).ready(function()
{
	
	jQuery('#tableone').columnManager({listTargetID:'targetone', onClass: 'simpleon', offClass: 'simpleoff'});
	jQuery("table").columnfilter();

});
</script>	 -->
	

<style>
/* body
{
	font-family:calibri;
	font-size:12px;
} */

/* table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align: right;
white-space:nowrap; 
}

table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: #29759C;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
} */
th{
	color:black;
}
table{
	/* white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px; */
	margin:0px;
}
div.target {
    margin: 0px 0 0 0px;
    width: auto;
}
div.target ul{
	border: 0px solid gray;
}

</style>

<!-- <?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?> -->


<!-- <script type="text/javascript" src="<?= '../'.getFullURL($_GET['r'],'moo1.2.js','R') ?>"></script> -->

<!-- <script type="text/javascript">
		//once the dom is ready
		window.addEvent('domready', function() {
			//find the editable areas
			$$('.editable').each(function(el) {
				//add double-click and blur events
				el.addEvent('dblclick',function() {
					//store "before" message
					var before = el.get('html').trim();
					//erase current
					el.set('html','');
					//replace current text/content with input or textarea element
					if(el.hasClass('textarea'))
					{
						var input = new Element('textarea', { 'class':'box', 'text':before });
					}
					else
					{
						var input = new Element('input', { 'class':'box', 'value':before });
						//blur input when they press "Enter"
						input.addEvent('keydown', function(e) { if(e.key == 'enter') { this.fireEvent('blur'); } });
					}
					input.inject(el).select();
					//add blur event to input
					input.addEvent('blur', function() {
						//get value, place it in original element
						val = input.get('value').trim();
						el.set('text',val).addClass(val != '' ? '' : 'editable-empty');
						
						//save respective record
						var url = 'week_delivery_plan_edit_process.php?id=' + el.get('rel') + '&content=' + el.get('text');
						var request = new Request({
							url:url,
							method:'get',
							onRequest: function() {
								
								//alert('Successfully Updated.');
							}
						}).send();
					});
				});
			});
		});
	</script> -->







<!-- <div id="ages"></div> -->
<?php
?>

<?php

if(isset($_GET['division']))
{
	$division=$_GET['division'];
}
else
{
	$division=$_POST['division'];
}
$pending=$_POST['pending'];

?>
<div class='panel panel-primary'><div class='panel-heading'>Delivery Failure Report</div><div class='panel-body'>
<!--<div id="page_heading"><span style="float: left"><h3>Internal Critical Delivery Status Report Done</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>-->
<form method="post" name="input" action="?r=<?php echo $_GET['r']; ?>">


  <?php
			  
				
$sql="SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$buyer_code[]=$sql_row["buyer_div"];
	$buyer_name[]=$sql_row["buyer_name"];
}

?>
<div class="row">			
	<div class="col-md-3">			
		<label>Buyer Division: </label>
		<select name="division" class="form-control">

			<option value='All' <?php if($division=="All"){ echo "selected"; } ?> >All</option>
		<?php
			for($i=0;$i<sizeof($buyer_name);$i++)
			{
				if($buyer_name[$i]==$division) 
				{ 
					echo "<option value=\"".($buyer_name[$i])."\" selected>".$buyer_code[$i]."</option>";	
				}
				else
				{
					echo "<option value=\"".($buyer_name[$i])."\"  >".$buyer_code[$i]."</option>";			
				}
			}
		?>
		</select>
	</div>
	<input type="submit" class='btn btn-primary disable-btn' value="Show" name="submit" style="margin-top:22px;">
</div>
</form>

<?php 



// $sizes_array=array('xs','s','m','l','xl','xxl','xxl','s06','s08','s10','s12','s14','s16','s18','s20','s22','s24','s26','s28','s30');
if(isset($_POST['submit']) or isset($_GET['division']))
{
	echo "<hr/>";
	if(isset($_GET['division']))
	{
		$division=$_GET['division'];
	}
	else
	{
		$division=$_POST['division'];
	}
	
	$pending=$_POST['pending'];
	
	
	$query="where ex_factory_date_new >\"2011-10-01\" and priority<>-1";
	if($division!="All")
	{
		$query="where MID(buyer_division,1, 2)=\"$division\" and ex_factory_date_new >\"2011-10-01\" and priority<>-1";
	}
//  echo '<div id="targetone" name="targetone" class="target col-sm-12 toggleview">toggle columns:</div>';
 // echo "<div class='row'><div class='panel panel-success'><div class='panel-heading'>hi</div><div class='panel-body'></div></div>";

echo '
 <div class="table-responsive col-sm-12"><table id="tableone" name="tableone" class="table table-bordered"><thead>';



if($division=="All" )
{
//echo '<thead>';
//echo '<tr><td colspan=13>Shipment Details</td><td colspan=20> Sizes</td><td colspan=7>Shipment Details</td><td colspan=2>Sec1</td><td colspan=2>Sec2</td>	<td colspan=2>Sec3</td>		<td colspan=2>Sec4</td>		<td colspan=2>Sec5</td>		<td colspan=2>Sec6</td>	<td $highlight></td></tr>';

echo '<tr>
<th>S. No</th>	<th class="filter">Buyer Division</th>	<th class="filter">MPO</th>	<th class="filter">CPO</th>	<th>Customer Order No</th>	<th>Z-Feature</th><th class="filter">Style No.</th>	<th class="filter">Schedule No.</th>	<th>Colour</th>	<th>Order Total</th><th>Actual Total</th><th class="filter">Current Status</th><th>Total</th>	';

// echo '<th>XS</th>	<th>S</th>	<th>M</th>	<th>L</th>	<th>XL</th>	<th>XXL</th>	<th>XXXL</th>	<th>S06</th><th>S08</th>	<th>S10</th>	<th>S12</th>	<th>S14</th>	<th>S16</th>	<th>S18</th>	<th>S20</th>	<th>S22</th>	<th>S24</th>	<th>S26</th>	<th>S28</th><th>S30</th>';
echo '<th>Sizes</th><th>Quantity</th>';
}
else
{
	

if(substr($division,0,2)=="M&")
{
	

//echo '<thead>';
//echo '<tr><td colspan=13>Shipment Details</td><td colspan=20> Sizes</td><td colspan=7>Shipment Details</td><td colspan=2>Sec1</td><td colspan=2>Sec2</td>	<td colspan=2>Sec3</td>		<td colspan=2>Sec4</td>		<td colspan=2>Sec5</td>		<td colspan=2>Sec6</td>	<td $highlight></td></tr>';

echo '<tr>
<th>S. No</th>	<th class="filter">Buyer Division</th>	<th class="filter">MPO</th>	<th class="filter">CPO</th>	<th>Customer Order No</th>	<th>Z-Feature</th><th class="filter">Style No.</th>	<th class="filter">Schedule No.</th>	<th>Colour</th>	<th>Order Total</th><th>Actual Total</th><th class="filter">Current Status</th><th>Total</th>	';

// echo '<th>S06</th><th>S08</th>	<th>S10</th>	<th>S12</th>	<th>S14</th>	<th>S16</th>	<th>S18</th>	<th>S20</th>	<th>S22</th>	<th>S24</th>	<th>S26</th>	<th>S28</th><th>S30</th>';
echo '<th>Sizes</th><th>Quantity</th>';
}
else
{
//echo '<thead>';
//echo '<tr><td colspan=13>Shipment Details</td><td colspan=7> Sizes</td><td colspan=7>Shipment Details</td><td colspan=2>Sec1</td><td colspan=2>Sec2</td>		<td colspan=2>Sec3</td>		<td colspan=2>Sec4</td>		<td colspan=2>Sec5</td>		<td colspan=2>Sec6</td>	<td $highlight></td></tr>';

echo '<tr>
<th>S. No</th>	<th class="filter">Buyer Division</th>	<th class="filter">MPO</th>	<th class="filter">CPO</th>	<th>Customer Order No</th>	<th>Z-Feature</th><th class="filter">Style No.</th>	<th class="filter">Schedule No.</th>	<th>Colour</th>	<th>Order Total</th><th>Actual Total</th><th class="filter">Current Status</th><th>Total</th>	';
	// echo '<th>XS</th>	<th>S</th>	<th>M</th>	<th>L</th>	<th>XL</th>	<th>XXL</th>	<th>XXXL</th>';
	echo '<th>Sizes</th><th>Quantity</th>';
}
}

echo '<th class="filter">Ex Factory</th><th class="filter">Rev. Ex-Factory</th>	<th class="filter">Mode</th><th class="filter">Rev. Mode</th>	<th class="filter">Packing Method</th>	<th>Plan End Date</th>	<th class="filter">Exe. Sections</th><th>Embellishment</th><th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th><th>Planning Remarks</th><th>Production Remarks</th><th>Commitments</th></tr>';
echo '</thead><tbody>';



$x=1;
//$sql="select * from week_delivery_plan where shipment_plan_id in (select ship_tid from week_delivery_plan_ref $query)";
$sql="select * from $bai_pro4.week_delivery_plan where ref_id in (select ref_id from $bai_pro4.week_delivery_plan_ref $query) limit 50";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
$edit_ref=$sql_row['ref_id'];
//$x=$edit_ref;
$shipment_plan_id=$sql_row['shipment_plan_id'];
$fastreact_plan_id=$sql_row['fastreact_plan_id'];
$size_xs=$sql_row['size_xs'];
$size_s=$sql_row['size_s'];
$size_m=$sql_row['size_m'];
$size_l=$sql_row['size_l'];
$size_xl=$sql_row['size_xl'];
$size_xxl=$sql_row['size_xxl'];
$size_xxxl=$sql_row['size_xxxl'];
$size_s06=$sql_row['size_s06'];
$size_s08=$sql_row['size_s08'];
$size_s10=$sql_row['size_s10'];
$size_s12=$sql_row['size_s12'];
$size_s14=$sql_row['size_s14'];
$size_s16=$sql_row['size_s16'];
$size_s18=$sql_row['size_s18'];
$size_s20=$sql_row['size_s20'];
$size_s22=$sql_row['size_s22'];
$size_s24=$sql_row['size_s24'];
$size_s26=$sql_row['size_s26'];
$size_s28=$sql_row['size_s28'];
$size_s30=$sql_row['size_s30'];
$plan_start_date=$sql_row['plan_start_date'];
$plan_comp_date=$sql_row['plan_comp_date'];
$size_comp_xs=$sql_row['size_comp_xs'];
$size_comp_s=$sql_row['size_comp_s'];
$size_comp_m=$sql_row['size_comp_m'];
$size_comp_l=$sql_row['size_comp_l'];
$size_comp_xl=$sql_row['size_comp_xl'];
$size_comp_xxl=$sql_row['size_comp_xxl'];
$size_comp_xxxl=$sql_row['size_comp_xxxl'];
$size_comp_s06=$sql_row['size_comp_s06'];
$size_comp_s08=$sql_row['size_comp_s08'];
$size_comp_s10=$sql_row['size_comp_s10'];
$size_comp_s12=$sql_row['size_comp_s12'];
$size_comp_s14=$sql_row['size_comp_s14'];
$size_comp_s16=$sql_row['size_comp_s16'];
$size_comp_s18=$sql_row['size_comp_s18'];
$size_comp_s20=$sql_row['size_comp_s20'];
$size_comp_s22=$sql_row['size_comp_s22'];
$size_comp_s24=$sql_row['size_comp_s24'];
$size_comp_s26=$sql_row['size_comp_s26'];
$size_comp_s28=$sql_row['size_comp_s28'];
$size_comp_s30=$sql_row['size_comp_s30'];
$plan_sec1=$sql_row['plan_sec1'];
$plan_sec2=$sql_row['plan_sec2'];
$plan_sec3=$sql_row['plan_sec3'];
$plan_sec4=$sql_row['plan_sec4'];
$plan_sec5=$sql_row['plan_sec5'];
$plan_sec6=$sql_row['plan_sec6'];
$plan_sec7=$sql_row['plan_sec7'];
$plan_sec8=$sql_row['plan_sec8'];
$plan_sec9=$sql_row['plan_sec9'];
$actu_sec1=$sql_row['actu_sec1'];
$actu_sec2=$sql_row['actu_sec2'];
$actu_sec3=$sql_row['actu_sec3'];
$actu_sec4=$sql_row['actu_sec4'];
$actu_sec5=$sql_row['actu_sec5'];
$actu_sec6=$sql_row['actu_sec6'];
$actu_sec7=$sql_row['actu_sec7'];
$actu_sec8=$sql_row['actu_sec8'];
$actu_sec9=$sql_row['actu_sec9'];
$tid=$sql_row['tid'];
$r_tid=$sql_row['ref_id'];
$remarks=array();
$remarks=explode("^",$sql_row['remarks']);
foreach ($sizes_array as $key => $value) {
	$size_values['title_size_'.$value] = $sql_row['size_'.$value];
}
$size_values = array_filter($size_values);
// var_dump($size_values);
// die();
//TEMP Enabled
$embl_tag=$sql_row['rev_emb_status'];
$rev_ex_factory_date=$sql_row['rev_exfactory']; 
$rev_mode=$sql_row['rev_mode']; 
if($rev_ex_factory_date=="0000-00-00")
{
	$rev_ex_factory_date="";
}

$executed_sec=array();
if($actu_sec1>0 or $plan_sec1>0){$executed_sec[]="1";}
if($actu_sec2>0 or $plan_sec2>0){$executed_sec[]="2";}
if($actu_sec3>0 or $plan_sec3>0){$executed_sec[]="3";}
if($actu_sec4>0 or $plan_sec4>0){$executed_sec[]="4";}
if($actu_sec5>0 or $plan_sec5>0){$executed_sec[]="5";}
if($actu_sec6>0 or $plan_sec6>0){$executed_sec[]="6";}

//$order_total=$size_xs+$size_s+$size_m+$size_l+$size_xl+$size_xxl+$size_xxxl+$size_s06+$size_s08+$size_s10+$size_s12+$size_s14+$size_s16+$size_s18+$size_s20+$size_s22+$size_s24+$size_s26+$size_s28+$size_s30;
$actu_total=$size_xs+$size_s+$size_m+$size_l+$size_xl+$size_xxl+$size_xxxl+$size_s06+$size_s08+$size_s10+$size_s12+$size_s14+$size_s16+$size_s18+$size_s20+$size_s22+$size_s24+$size_s26+$size_s28+$size_s30;
$plan_total=$actu_sec1+$actu_sec2+$actu_sec3+$actu_sec4+$actu_sec5+$actu_sec6+$actu_sec7+$actu_sec8+$actu_sec9;





$order_total=0;

$sql1="select * from $bai_pro4.shipment_plan_ref where ship_tid=$shipment_plan_id";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$order_no=$sql_row1['order_no'];
	$delivery_no=$sql_row1['delivery_no'];
	$del_status=$sql_row1['del_status'];
	$mpo=trim($sql_row1['mpo']);
	$cpo=trim($sql_row1['cpo']);
	$buyer=trim($sql_row1['buyer']);
	$product=$sql_row1['product'];
	$buyer_division=trim($sql_row1['buyer_division']);
	$style=trim($sql_row1['style']);
	$schedule_no=$sql_row1['schedule_no'];
	$color=$sql_row1['color'];
	$size=$sql_row1['size'];
	$z_feature=$sql_row1['z_feature'];
	$ord_qty=$sql_row1['ord_qty'];
	//$order_total=$sql_row1['ord_qty_new'];
	
	//$ex_factory_date=$sql_row1['ex_factory_date']; //TEMP Disabled due to M3 Issue
	$mode=$sql_row1['mode'];
	$destination=$sql_row1['destination'];
	$packing_method=$sql_row1['packing_method'];
	$fob_price_per_piece=$sql_row1['fob_price_per_piece'];
	$cm_value=$sql_row1['cm_value'];
	$ssc_code=$sql_row1['ssc_code'];
	$ship_tid=$sql_row1['ship_tid'];
	$week_code=$sql_row1['week_code'];
	$status=$sql_row1['status'];

	$size_sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no = '".$style."' and order_del_no = '".$schedule_no."' and order_col_des = '".$color."'";
	// echo $size_sql;
	// mysqli_query($link, $size_sql) or exit("Size Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result_size=mysqli_query($link, $size_sql) or exit("Size Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result_size))
	{
		foreach ($size_values as $key => $value) {
			$size_and_values[$sql_row[$key]] = $value;
		}
	}
	// var_dump($size_and_values);
	
	//TEMP Disabled due to M3 Issue
	//$embl_tag=embl_check($sql_row1['order_embl_a'].$sql_row1['order_embl_b'].$sql_row1['order_embl_c'].$sql_row1['order_embl_d'].$sql_row1['order_embl_e'].$sql_row1['order_embl_f'].$sql_row1['order_embl_g'].$sql_row1['order_embl_h']);
}

//EMB stat 20111201

if(date("Y-m-d")>"2011-12-11")
{
	$embl_tag="";
	$sql1="select order_embl_a,order_embl_e from $bai_pro3.bai_orders_db where order_del_no=\"$schedule_no\"";
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		if($sql_row1['order_embl_a']==1)
		{
			$embl_tag="Panle Form*";
		}
		if($sql_row1['order_embl_e']==1)
		{
			$embl_tag="Garment Form*";
		}
	}
}

//EMB stat

$order_total=$sql_row['original_order_qty'];



//Status
{

$sql1="select * from $bai_pro4.week_delivery_plan_ref  where ship_tid=$shipment_plan_id";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
$priority=$sql_row1['priority'];
$cut=$sql_row1['act_cut'];
$in=$sql_row1['act_in'];
$out=$sql_row1['output'];
$pendingcarts=$sql_row1['cart_pending'];
$order=$sql_row1['ord_qty_new'];
$fcamca=$sql_row1['act_mca'];
$fgqty=$sql_row1['act_fg'];
$internal_audited=$sql_row1['act_fca'];
$ex_factory_date=$sql_row1['ex_factory_date'];
}


$status="NIL";
if($cut==0)
{
	$status="RM";
}
else
{
	if($cut>0 and $in==0)
	{
		$status="Cutting";
	}
	else
	{
		if($in>0)
		{
			$status="Sewing";
		}
	}
}
if($out>=$fgqty and $out>0 and $fgqty>=$order)  //due to excess percentage of shipment over order qty
{
	$status="FG";
}
if($out>=$order and $out>0 and $fgqty<$order)
{
	$status="Packing";
}

if($status=="FG" and $internal_audited>=$fgqty)
{
	$status="FCA";
}

//DISPATCH

	$sql1="select ship_qty from $bai_pro2.style_status_summ where sch_no=\"$schedule_no\"";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$ship_qty=$sql_row1['ship_qty'];
	}
	
	if($status=="FG" and $fgqty>=$ship_qty and $ship_qty>=$order)
	{
		$status="Dispatched";
	}
	
	//echo $ship_tid."-".$schedule_no."-".$status."-".$priority."-".$cut."-".$in."-".$out."-".$pendingcarts."-".$order."-".$fcamca."-".$fgqty."-".$$internal_audited."<br/>";
//DISPATCH
}

//Status

//NEW ORDER QTY TRACK
/*
$sql1="select * from shipfast_sum where shipment_plan_id=$shipment_plan_id";
$sql_result1=mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
while($sql_row1=mysql_fetch_array($sql_result1))
{
	$size_xs1=$sql_row1['size_xs'];
	$size_s1=$sql_row1['size_s'];
	$size_m1=$sql_row1['size_m'];
	$size_l1=$sql_row1['size_l'];
	$size_xl1=$sql_row1['size_xl'];
	$size_xxl1=$sql_row1['size_xxl'];
	$size_xxxl1=$sql_row1['size_xxxl'];
	$size_s061=$sql_row1['size_s06'];
	$size_s081=$sql_row1['size_s08'];
	$size_s101=$sql_row1['size_s10'];
	$size_s121=$sql_row1['size_s12'];
	$size_s141=$sql_row1['size_s14'];
	$size_s161=$sql_row1['size_s16'];
	$size_s181=$sql_row1['size_s18'];
	$size_s201=$sql_row1['size_s20'];
	$size_s221=$sql_row1['size_s22'];
	$size_s241=$sql_row1['size_s24'];
	$size_s261=$sql_row1['size_s26'];
	$size_s281=$sql_row1['size_s28'];
	$size_s301=$sql_row1['size_s30'];
	
}
$order_total=$size_xs1+$size_s1+$size_m1+$size_l1+$size_xl1+$size_xxl1+$size_xxxl1+$size_s061+$size_s081+$size_s101+$size_s121+$size_s141+$size_s161+$size_s181+$size_s201+$size_s221+$size_s241+$size_s261+$size_s281+$size_s301; */
//NEW ORDER QTY TRACK


//Restricted Editing for Packing Team

// $username_list=explode('\\',$_SERVER['REMOTE_USER']);
// $username=$username_list[1];
//$authorized=array("muralim","kirang","sureshn","sasidharch","edwinr","lilanku"); //For Packing
// $authorized2=array("muralim","kirang","baiuser");

if(strtolower($remarks[0])=="hold")
{
	$highlight=" bgcolor=\"red\" ";
}
else
{
	if(strtolower($remarks[0])=="$")
	{
		$highlight=" bgcolor=\"green\" ";
	}
	else
	{
		if(strtolower($remarks[0])=="short")
		{
			$highlight=" bgcolor=\"yellow\" ";
		}
		else
		{
			$highlight="";
		}
	}
}

/*
if($order_total!=$actu_total)
{
	$highlight=" bgcolor=\"yellow\" ";
}
*/


//Allowed only Packing team and timings to update between 8-10 and 4-6
if((in_array($authorizeLevel_1,$has_perm)) and ((date("H")<=10 and date("H")>=8) or (date("H")<=18 and date("H")>=16)))
{
	
	$edit_rem="<td class=\"editable\" rel=\"B$edit_ref\">".$remarks[1]."</td>";
}
else
{
	//$edit_rem="<td $highlight>".$remarks[1]."</td>";
	$edit_rem="<td $highlight>".$remarks[1]."</td>";
}


if(!(in_array($authorizeLevel_2,$has_perm)))
{
	$edit_rem2="<td $highlight>".$remarks[2]."</td>";
}
else
{
	//$edit_rem="<td $highlight>".$remarks[1]."</td>";
	$edit_rem2="<td class=\"editable\" rel=\"C$edit_ref\">".$remarks[2]."</td>";
}
//Restricted Editing for Packing Team
if($pending==1)
{
	if($order_total>$actu_total)
	{


		if($division=="All" )
		{
			echo "<tr><td $highlight> $x  </td>	<td $highlight>$buyer_division</td>	<td $highlight>$mpo</td>	<td $highlight>$cpo</td>	<td $highlight>$order_no</td>	<td $highlight>$z_feature</td><td $highlight>$style</td>	<td $highlight>$schedule_no</td>	<td $highlight>$color</td>	<td $highlight>$order_total</td><td $highlight>$plan_total</td><td $highlight>$status</td><td $highlight>$actu_total</td>	<td $highlight>$size_xs</td>	<td $highlight>$size_s</td>	<td $highlight>$size_m</td>	<td $highlight>$size_l</td>	<td $highlight>$size_xl</td>	<td $highlight>$size_xxl</td>	<td $highlight>$size_xxxl</td><td $highlight>$size_s06</td><td $highlight>$size_s08</td>	<td $highlight>$size_s10</td>	<td $highlight>$size_s12</td>	<td $highlight>$size_s14</td>	<td $highlight>$size_s16</td>	<td $highlight>$size_s18</td>	<td $highlight>$size_s20</td>	<td $highlight>$size_s22</td>	<td $highlight>$size_s24</td>	<td $highlight>$size_s26</td>	<td $highlight>$size_s28</td><td $highlight>$size_s30</td><td $highlight>$ex_factory_date</td><td $highlight>$rev_ex_factory_date</td>	<td $highlight>$mode</td><td $highlight>$rev_mode</td>	<td $highlight>$packing_method</td>	<td $highlight>$plan_comp_date</td><td $highlight>".implode(",",$executed_sec)."</td><td $highlight>$embl_tag</td>	<td $highlight>$plan_sec1</td>	<td $highlight>$actu_sec1</td>	<td $highlight>$plan_sec2</td>	<td $highlight>$actu_sec2</td>	<td $highlight>$plan_sec3</td>	<td $highlight>$actu_sec3</td>	<td $highlight>$plan_sec4</td>	<td $highlight>$actu_sec4</td>	<td $highlight>$plan_sec5</td>	<td $highlight>$actu_sec5</td>	<td $highlight>$plan_sec6</td>	<td $highlight>$actu_sec6</td>	<td $highlight>".$remarks[0]."</td>".$edit_rem.$edit_rem2."</tr>";
		}
		else
		{
			
		
		if($division=="M&" )
		{
		echo "<tr><td $highlight> $x  </td>	<td $highlight>$buyer_division</td>	<td $highlight>$mpo</td>	<td $highlight>$cpo</td>	<td $highlight>$order_no</td>	<td $highlight>$z_feature</td><td $highlight>$style</td>	<td $highlight>$schedule_no</td>	<td $highlight>$color</td>	<td $highlight>$order_total</td><td $highlight>$plan_total</td><td $highlight>$status</td><td $highlight>$actu_total</td><td $highlight>$size_s06</td><td $highlight>$size_s08</td>	<td $highlight>$size_s10</td>	<td $highlight>$size_s12</td>	<td $highlight>$size_s14</td>	<td $highlight>$size_s16</td>	<td $highlight>$size_s18</td>	<td $highlight>$size_s20</td>	<td $highlight>$size_s22</td>	<td $highlight>$size_s24</td>	<td $highlight>$size_s26</td>	<td $highlight>$size_s28</td><td $highlight>$size_s30</td>	<td $highlight>$ex_factory_date</td><td $highlight>$rev_ex_factory_date</td>	<td $highlight>$mode</td><td $highlight>$rev_mode</td>	<td $highlight>$packing_method</td>	<td $highlight>$plan_comp_date</td><td $highlight>".implode(",",$executed_sec)."</td><td $highlight>$embl_tag</td>	<td $highlight>$plan_sec1</td>	<td $highlight>$actu_sec1</td>	<td $highlight>$plan_sec2</td>	<td $highlight>$actu_sec2</td>	<td $highlight>$plan_sec3</td>	<td $highlight>$actu_sec3</td>	<td $highlight>$plan_sec4</td>	<td $highlight>$actu_sec4</td>	<td $highlight>$plan_sec5</td>	<td $highlight>$actu_sec5</td>	<td $highlight>$plan_sec6</td>	<td $highlight>$actu_sec6</td>	<td $highlight>".$remarks[0]."</td>".$edit_rem.$edit_rem2."</tr>";
		}
		else
		{
			echo "<tr><td $highlight>  $x</td>	<td $highlight>$buyer_division</td>	<td $highlight>$mpo</td>	<td $highlight>$cpo</td>	<td $highlight>$order_no</td>	<td $highlight>$z_feature</td><td $highlight>$style</td>	<td $highlight>$schedule_no</td>	<td $highlight>$color</td>	<td $highlight>$order_total</td><td $highlight>$plan_total</td><td $highlight>$status</td><td $highlight>$actu_total</td><td $highlight>$size_xs</td>	<td $highlight>$size_s</td>	<td $highlight>$size_m</td>	<td $highlight>$size_l</td>	<td $highlight>$size_xl</td>	<td $highlight>$size_xxl</td>	<td $highlight>$size_xxxl</td>	<td $highlight>$ex_factory_date</td><td $highlight>$rev_ex_factory_date</td>	<td $highlight>$mode</td><td $highlight>$rev_mode</td>	<td $highlight>$packing_method</td>	<td $highlight>$plan_comp_date</td><td $highlight>".implode(",",$executed_sec)."</td><td $highlight>$embl_tag</td>	<td $highlight>$plan_sec1</td>	<td $highlight>$actu_sec1</td>	<td $highlight>$plan_sec2</td>	<td $highlight>$actu_sec2</td>	<td $highlight>$plan_sec3</td>	<td $highlight>$actu_sec3</td>	<td $highlight>$plan_sec4</td>	<td $highlight>$actu_sec4</td>	<td $highlight>$plan_sec5</td>	<td $highlight>$actu_sec5</td>	<td $highlight>$plan_sec6</td>	<td $highlight>$actu_sec6</td>	<td $highlight>".$remarks[0]."</td>".$edit_rem.$edit_rem2."</tr>";
		}
		}
	}
}
else
{
		if($division=="All" )
		{
			
			// for($i=0;$i<13;$i++){
				// $size_val= ${'size_'.$sizes_array[$i]};
				// $title_size=${'title_size_'.$sizes_array[$i]};
				// if($title_size==''){
				// 	$title_size=$sizes_array[$i];
				// }
			if(count($size_and_values) > 0){
				foreach ($size_and_values as $fin_size => $fin_qty) {
					// if($size_val>0){
						echo "<tr ><td $highlight> $x  </td>	<td $highlight>$buyer_division</td>	<td $highlight>$mpo</td>	<td $highlight>$cpo</td>	<td $highlight>$order_no</td>	<td $highlight>$z_feature</td><td $highlight>$style</td>	<td $highlight>$schedule_no</td>	<td $highlight>$color</td>	<td $highlight>$order_total</td><td $highlight>$plan_total</td><td $highlight>$status</td><td $highlight>$actu_total</td>	<td>".strtoupper($fin_size)."</td><td>$fin_qty</td>	<td $highlight>$ex_factory_date</td><td $highlight>$rev_ex_factory_date</td>	<td $highlight>$mode</td><td $highlight>$rev_mode</td>	<td $highlight>$packing_method</td>	<td $highlight>$plan_comp_date</td><td $highlight>".implode(",",$executed_sec)."</td><td $highlight>$embl_tag</td>	<td $highlight>$plan_sec1</td>	<td $highlight>$actu_sec1</td>	<td $highlight>$plan_sec2</td>	<td $highlight>$actu_sec2</td>	<td $highlight>$plan_sec3</td>	<td $highlight>$actu_sec3</td>	<td $highlight>$plan_sec4</td>	<td $highlight>$actu_sec4</td>	<td $highlight>$plan_sec5</td>	<td $highlight>$actu_sec5</td>	<td $highlight>$plan_sec6</td>	<td $highlight>$actu_sec6</td>	<td $highlight>".$remarks[0]."</td>".$edit_rem.$edit_rem2."</tr>";
						$x+=1;
					// }
				}
			}
		}
		else
		{
			if($division=="M&" )
			{
				// for($i=0;$i<13;$i++){
				// 	$size_val= ${'size_'.$sizes_array[$i]};
				// 	$title_size=${'title_size_'.$sizes_array[$i]};
				// 	if($title_size==''){
				// 		$title_size=$sizes_array[$i];
				// 	}
				// 	if($size_val>0){
				foreach ($size_and_values as $fin_size => $fin_qty) 
				{
					echo "<tr><td $highlight> $x  </td>	<td $highlight>$buyer_division</td>	<td $highlight>$mpo</td>	<td $highlight>$cpo</td>	<td $highlight>$order_no</td>	<td $highlight>$z_feature</td><td $highlight>$style</td>	<td $highlight>$schedule_no</td>	<td $highlight>$color</td>	<td $highlight>$order_total</td><td $highlight>$plan_total</td><td $highlight>$status</td><td $highlight>$actu_total</td>	<td $highlight>$ex_factory_date</td><td $highlight>$rev_ex_factory_date</td>	<td $highlight>$mode</td><td $highlight>$rev_mode</td>	<td $highlight>$packing_method</td>	<td $highlight>$plan_comp_date</td><td $highlight>".implode(",",$executed_sec)."</td><td $highlight>$embl_tag</td>	<td $highlight>$plan_sec1</td>	<td $highlight>$actu_sec1</td>	<td $highlight>$plan_sec2</td>	<td $highlight>$actu_sec2</td>	<td $highlight>$plan_sec3</td>	<td $highlight>$actu_sec3</td>	<td $highlight>$plan_sec4</td>	<td $highlight>$actu_sec4</td>	<td $highlight>$plan_sec5</td>	<td $highlight>$actu_sec5</td>	<td $highlight>$plan_sec6</td>	<td $highlight>$actu_sec6</td><td>".strtoupper($fin_size)."</td><td>$fin_qty</td><td $highlight>".$remarks[0]."</td>".$edit_rem.$edit_rem2."</tr>";
					$x+=1;
				}
			}
			else
			{
				// for($i=0;$i<13;$i++){
				// $size_val= ${'size_'.$sizes_array[$i]};
				// $title_size=${'title_size_'.$sizes_array[$i]};
				// if($title_size==''){
				// $title_size=$sizes_array[$i];
				// }
				// if($size_val>0){
				foreach ($size_and_values as $fin_size => $fin_qty) 
				{
				echo "<tr><td $highlight> $x  </td>	<td $highlight>$buyer_division</td>	<td $highlight>$mpo</td>	<td $highlight>$cpo</td>	<td $highlight>$order_no</td>	<td $highlight>$z_feature</td><td $highlight>$style</td>	<td $highlight>$schedule_no</td>	<td $highlight>$color</td>	<td $highlight>$order_total</td><td $highlight>$plan_total</td><td $highlight>$status</td><td $highlight>$actu_total</td><td>".strtoupper($title_size)."</td><td>$size_val</td>	<td $highlight>$ex_factory_date</td><td $highlight>$rev_ex_factory_date</td>	<td $highlight>$mode</td><td $highlight>$rev_mode</td>	<td $highlight>$packing_method</td>	<td $highlight>$plan_comp_date</td><td $highlight>".implode(",",$executed_sec)."</td><td $highlight>$embl_tag</td>	<td $highlight>$plan_sec1</td>	<td $highlight>$actu_sec1</td>	<td $highlight>$plan_sec2</td>	<td $highlight>$actu_sec2</td>	<td $highlight>$plan_sec3</td>	<td $highlight>$actu_sec3</td>	<td $highlight>$plan_sec4</td>	<td $highlight>$actu_sec4</td>	<td $highlight>$plan_sec5</td>	<td $highlight>$actu_sec5</td>	<td $highlight>$plan_sec6</td>	<td $highlight>$actu_sec6</td>	<td $highlight>".$remarks[0]."</td>".$edit_rem.$edit_rem2."</tr>";
				$x+=1;
			
				}
			}
		}
}


// $x+=1;


}

echo '</tbody>';
echo '</table></div></div></div>';

// echo "<script>
// function getCSVData(){
//  var csv_value=jQuery('#tableone').table2CSV({delivery:'value'});
//  jQuery(\"#csv_text\").val(csv_value);	
// }
// </script>";


}
?>


<!-- <script language="javascript">
jQuery(function() {
    var table = jQuery("#tableone");

    jQuery(window).scroll(function() {
        var windowTop = jQuery(window).scrollTop();

        if (windowTop > table.offset().top) {
            jQuery("thead", table).addClass("Fixed").css("top", windowTop);
        }
        else {
            jQuery("thead", table).removeClass("Fixed");
        }
    });
});

</script> -->

</div >
</div></div>



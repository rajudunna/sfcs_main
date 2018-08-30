<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');   ?>
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>
<link rel="stylesheet" href="../../../common/css/bootstrap.min.css">
<title>QMS - POP Report</title>
<style>
td,th{color : #000;}
</style>

<script>
(function($) {
    $.fn.columnfilter = function(options) {

        var defaults = {};

        var options = $.extend(defaults, options);

        return this.each(function(index) {

            var $table = $(this);
				
            $table.find("th.filter").each(function() {
                //create a select list for each filter column
                var i = 0;
				var $select = $('<select class="selectfilter" multiple></select>');
                var $this = $(this);
                var colindex = $this.parent().children().index($this) + 1;
                var dictionary = [];
                $table.find("tr td:nth-child(" + colindex + ")").each(function() {
                    var text = $(this).text();
                    dictionary[text] = true;
                });
                var colkeys = [];
                for (i in dictionary) colkeys.push(i);
                colkeys.sort();
                $select.append('<option value="All" selected>All</option>');
                for (i=0; i<colkeys.length; i++) {
                    if(colkeys[i] === "indexOf")continue; //weird stuff happens in ie and chrome, firefox is awesome
					if(colkeys[i]!="")
						$select.append('<option value="' + colkeys[i] + '">' + colkeys[i] + '</option>');
                }
                $(this).append("<br/>");
                $(this).append($select);

                //bind change function to each select filter
                $select.change(function() {

                    //create an array of the filters selected values
                    var colIndexes = [];
                    var selectedOptions = [];
                    $table.find(".selectfilter").each(function() {
                        $this = $(this);
                        var $parent = $(this).parent();
                        colIndexes.push($parent.parent().children().index($parent)+1);
                        //selectedOptions.push($this.children(":selected").text());
						var test="";
						$this.children(":selected").each(function(x, selected) {
						test += $(selected).text() + " ";
						});
						selectedOptions.push(test);
						//alert(test);
                    });
					
					//To calculate Total
					var col1=0;
					var col2=0;
					var col3=0;
					var col4=0;
					var col5=0;
					var col6=0;
					var col7=0;
					var col8=0;
					var col9=0;
					
                    //show or hide the corresponding rows
                    $table.find("tr").each(function(rowindex) {
						if (rowindex > 0) {
						    var rowok = true;
                            for (i = 0; i < colIndexes.length;  i++) {
							
                                text = $(this).find("td:nth-child(" + colIndexes[i] + ")").text()+" ";
									
							   // if (selectedOptions[i] != "All " && text != selectedOptions[i] && selectedOptions[i].indexOf(text)>0) rowok = false;
								 if (selectedOptions[i] != "All " && selectedOptions[i].indexOf(text)<0) rowok = false;
								//if (selectedOptions[i] != "All " && text != selectedOptions[i]) rowok = false;
                            }
							
                            if (rowok === true) 
							{ $(this).show(); 
								
								//To Calculate Total
								if(!isNaN(parseFloat($(this).find("td:nth-child(7)").html())))
								col1 += parseFloat($(this).find("td:nth-child(7)").html());
								$("#col1").html(col1);
								
								if(!isNaN(parseFloat($(this).find("td:nth-child(8)").html())))
								col2 += parseFloat($(this).find("td:nth-child(8)").html());
								$("#col2").html(col2);
								
								if(!isNaN(parseFloat($(this).find("td:nth-child(9)").html())))
								col3 += parseFloat($(this).find("td:nth-child(9)").html());
								$("#col3").html(col3);
								
								if(!isNaN(parseFloat($(this).find("td:nth-child(10)").html())))
								col4 += parseFloat($(this).find("td:nth-child(10)").html());
								$("#col4").html(col4);
								
								if(!isNaN(parseFloat($(this).find("td:nth-child(11)").html())))
								col5 += parseFloat($(this).find("td:nth-child(11)").html());
								$("#col5").html(col5);
								
								if(!isNaN(parseFloat($(this).find("td:nth-child(12)").html())))
								col6 += parseFloat($(this).find("td:nth-child(12)").html());
								$("#col6").html(col6);
								
								if(!isNaN(parseFloat($(this).find("td:nth-child(13)").html())))
								col7 += parseFloat($(this).find("td:nth-child(13)").html());
								$("#col7").html(col7);
								
								if(!isNaN(parseFloat($(this).find("td:nth-child(14)").html())))
								col8 += parseFloat($(this).find("td:nth-child(14)").html());
								$("#col8").html(col8);
								
								if(!isNaN(parseFloat($(this).find("td:nth-child(15)").html())))
								col9 += parseFloat($(this).find("td:nth-child(15)").html());
								$("#col9").html(col9);
							}
                            else
							{
								$(this).hide();
							}
					
                        }
						
                    });
				});
				
            });
        });
    } 

})(jQuery);
</script>

<script type="text/javascript">
$(document).ready(function() {
	$("table").columnfilter();
});
</script>




<div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>QMS-Transation Log</b>
	</div>
	<div class='panel-body'>
		<?php
			if(isset($_GET['style']))
			{
				$order_qtys=array();
				
				$sizes_db=array('xs','s','m','l','xl','xxl','xxxl','s01','s02','s03','s04','s05','s06','s07','s08','s09','s10',
								's11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25',
								's26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40',
								's41','s42','s43','s44','s45','s46','s47','s48','s49','s50');
				
				$sql1="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"".$_GET['style']."\" and order_del_no=\"".$_GET['schedule']."\" and order_col_des=\"".$_GET['color']."\"";
			//echo $sql1;
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1=mysqli_fetch_array($sql_result1))
				{
					$order_qtys[]=$sql_row1['order_s_xs'];
					$order_qtys[]=$sql_row1['order_s_s'];
					$order_qtys[]=$sql_row1['order_s_m'];
					$order_qtys[]=$sql_row1['order_s_l'];
					$order_qtys[]=$sql_row1['order_s_xl'];
					$order_qtys[]=$sql_row1['order_s_xxl'];
					$order_qtys[]=$sql_row1['order_s_xxxl'];
					$order_qtys[]=$sql_row1['order_s_s01'];
					$order_qtys[]=$sql_row1['order_s_s02'];
					$order_qtys[]=$sql_row1['order_s_s03'];
					$order_qtys[]=$sql_row1['order_s_s04'];
					$order_qtys[]=$sql_row1['order_s_s05'];
					$order_qtys[]=$sql_row1['order_s_s06'];
					$order_qtys[]=$sql_row1['order_s_s07'];
					$order_qtys[]=$sql_row1['order_s_s08'];
					$order_qtys[]=$sql_row1['order_s_s09'];
					$order_qtys[]=$sql_row1['order_s_s10'];
					$order_qtys[]=$sql_row1['order_s_s11'];
					$order_qtys[]=$sql_row1['order_s_s12'];
					$order_qtys[]=$sql_row1['order_s_s13'];
					$order_qtys[]=$sql_row1['order_s_s14'];
					$order_qtys[]=$sql_row1['order_s_s15'];
					$order_qtys[]=$sql_row1['order_s_s16'];
					$order_qtys[]=$sql_row1['order_s_s17'];
					$order_qtys[]=$sql_row1['order_s_s18'];
					$order_qtys[]=$sql_row1['order_s_s19'];
					$order_qtys[]=$sql_row1['order_s_s20'];
					$order_qtys[]=$sql_row1['order_s_s21'];
					$order_qtys[]=$sql_row1['order_s_s22'];
					$order_qtys[]=$sql_row1['order_s_s23'];
					$order_qtys[]=$sql_row1['order_s_s24'];
					$order_qtys[]=$sql_row1['order_s_s25'];
					$order_qtys[]=$sql_row1['order_s_s26'];
					$order_qtys[]=$sql_row1['order_s_s27'];
					$order_qtys[]=$sql_row1['order_s_s28'];
					$order_qtys[]=$sql_row1['order_s_s29'];
					$order_qtys[]=$sql_row1['order_s_s30'];
					$order_qtys[]=$sql_row1['order_s_s31'];
					$order_qtys[]=$sql_row1['order_s_s32'];
					$order_qtys[]=$sql_row1['order_s_s33'];
					$order_qtys[]=$sql_row1['order_s_s34'];
					$order_qtys[]=$sql_row1['order_s_s35'];
					$order_qtys[]=$sql_row1['order_s_s36'];
					$order_qtys[]=$sql_row1['order_s_s37'];
					$order_qtys[]=$sql_row1['order_s_s38'];
					$order_qtys[]=$sql_row1['order_s_s39'];
					$order_qtys[]=$sql_row1['order_s_s40'];
					$order_qtys[]=$sql_row1['order_s_s41'];
					$order_qtys[]=$sql_row1['order_s_s42'];
					$order_qtys[]=$sql_row1['order_s_s43'];
					$order_qtys[]=$sql_row1['order_s_s44'];
					$order_qtys[]=$sql_row1['order_s_s45'];
					$order_qtys[]=$sql_row1['order_s_s46'];
					$order_qtys[]=$sql_row1['order_s_s47'];
					$order_qtys[]=$sql_row1['order_s_s48'];
					$order_qtys[]=$sql_row1['order_s_s49'];
					$order_qtys[]=$sql_row1['order_s_s50'];
					$order_tid=$sql_row1['order_tid'];
					$schedule=$sql_row1['order_del_no'];
					$color=$sql_row1['order_col_des'];
				}
				
				$act_cut_new_db=array();
				$sql1="select coalesce(sum(a_xs*a_plies),0) as \"a_xs\", coalesce(sum(a_s*a_plies),0) as \"a_s\", 
						coalesce(sum(a_m*a_plies),0) as \"a_m\", coalesce(sum(a_l*a_plies),0) as \"a_l\", 
						coalesce(sum(a_xl*a_plies),0) as \"a_xl\", coalesce(sum(a_xxl*a_plies),0) as \"a_xxl\", 
						coalesce(sum(a_xxxl*a_plies),0) as \"a_xxxl\", coalesce(sum(a_s01*a_plies),0) as \"a_s01\",
						coalesce(sum(a_s02*a_plies),0) as \"a_s02\",coalesce(sum(a_s03*a_plies),0) as \"a_s03\",
						coalesce(sum(a_s04*a_plies),0) as \"a_s04\",coalesce(sum(a_s05*a_plies),0) as \"a_s05\",
						coalesce(sum(a_s06*a_plies),0) as \"a_s06\",coalesce(sum(a_s07*a_plies),0) as \"a_s07\",
						coalesce(sum(a_s08*a_plies),0) as \"a_s08\",coalesce(sum(a_s09*a_plies),0) as \"a_s09\",
						coalesce(sum(a_s10*a_plies),0) as \"a_s10\",coalesce(sum(a_s11*a_plies),0) as \"a_s11\",
						coalesce(sum(a_s12*a_plies),0) as \"a_s12\",coalesce(sum(a_s13*a_plies),0) as \"a_s13\",
						coalesce(sum(a_s14*a_plies),0) as \"a_s14\",coalesce(sum(a_s15*a_plies),0) as \"a_s15\",
						coalesce(sum(a_s16*a_plies),0) as \"a_s16\",coalesce(sum(a_s17*a_plies),0) as \"a_s17\",
						coalesce(sum(a_s18*a_plies),0) as \"a_s18\",coalesce(sum(a_s19*a_plies),0) as \"a_s19\",
						coalesce(sum(a_s20*a_plies),0) as \"a_s20\",coalesce(sum(a_s21*a_plies),0) as \"a_s21\",
						coalesce(sum(a_s22*a_plies),0) as \"a_s22\",coalesce(sum(a_s23*a_plies),0) as \"a_s23\",
						coalesce(sum(a_s24*a_plies),0) as \"a_s24\",coalesce(sum(a_s25*a_plies),0) as \"a_s25\",
						coalesce(sum(a_s26*a_plies),0) as \"a_s26\",coalesce(sum(a_s27*a_plies),0) as \"a_s27\",
						coalesce(sum(a_s28*a_plies),0) as \"a_s28\",coalesce(sum(a_s29*a_plies),0) as \"a_s29\",
						coalesce(sum(a_s30*a_plies),0) as \"a_s30\",coalesce(sum(a_s31*a_plies),0) as \"a_s31\",
						coalesce(sum(a_s32*a_plies),0) as \"a_s32\",coalesce(sum(a_s33*a_plies),0) as \"a_s33\",
						coalesce(sum(a_s34*a_plies),0) as \"a_s34\",coalesce(sum(a_s35*a_plies),0) as \"a_s35\",
						coalesce(sum(a_s36*a_plies),0) as \"a_s36\",coalesce(sum(a_s37*a_plies),0) as \"a_s37\",
						coalesce(sum(a_s38*a_plies),0) as \"a_s38\",coalesce(sum(a_s39*a_plies),0) as \"a_s39\",
						coalesce(sum(a_s40*a_plies),0) as \"a_s40\",coalesce(sum(a_s41*a_plies),0) as \"a_s41\",
						coalesce(sum(a_s42*a_plies),0) as \"a_s42\",coalesce(sum(a_s43*a_plies),0) as \"a_s43\",
						coalesce(sum(a_s44*a_plies),0) as \"a_s44\",coalesce(sum(a_s45*a_plies),0) as \"a_s45\",
						coalesce(sum(a_s46*a_plies),0) as \"a_s46\",coalesce(sum(a_s47*a_plies),0) as \"a_s47\",
						coalesce(sum(a_s48*a_plies),0) as \"a_s48\",coalesce(sum(a_s49*a_plies),0) as \"a_s49\",
						coalesce(sum(a_s50*a_plies),0) as \"a_s50\" 
						from $bai_pro3.order_cat_doc_mix where order_tid=\"$order_tid\" and category in ($in_categories) 
						and act_cut_status=\"DONE\"";

				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result1))
				{
					$act_cut_new_db[]=$sql_row2['a_xs'];
					$act_cut_new_db[]=$sql_row2['a_s'];
					$act_cut_new_db[]=$sql_row2['a_m'];
					$act_cut_new_db[]=$sql_row2['a_l'];
					$act_cut_new_db[]=$sql_row2['a_xl'];
					$act_cut_new_db[]=$sql_row2['a_xxl'];
					$act_cut_new_db[]=$sql_row2['a_xxxl'];
					$act_cut_new_db[]=$sql_row2['a_s01'];
					$act_cut_new_db[]=$sql_row2['a_s02'];
					$act_cut_new_db[]=$sql_row2['a_s03'];
					$act_cut_new_db[]=$sql_row2['a_s04'];
					$act_cut_new_db[]=$sql_row2['a_s05'];
					$act_cut_new_db[]=$sql_row2['a_s06'];
					$act_cut_new_db[]=$sql_row2['a_s07'];
					$act_cut_new_db[]=$sql_row2['a_s08'];
					$act_cut_new_db[]=$sql_row2['a_s09'];
					$act_cut_new_db[]=$sql_row2['a_s10'];
					$act_cut_new_db[]=$sql_row2['a_s11'];
					$act_cut_new_db[]=$sql_row2['a_s12'];
					$act_cut_new_db[]=$sql_row2['a_s13'];
					$act_cut_new_db[]=$sql_row2['a_s14'];
					$act_cut_new_db[]=$sql_row2['a_s15'];
					$act_cut_new_db[]=$sql_row2['a_s16'];
					$act_cut_new_db[]=$sql_row2['a_s17'];
					$act_cut_new_db[]=$sql_row2['a_s18'];
					$act_cut_new_db[]=$sql_row2['a_s19'];
					$act_cut_new_db[]=$sql_row2['a_s20'];
					$act_cut_new_db[]=$sql_row2['a_s21'];
					$act_cut_new_db[]=$sql_row2['a_s22'];
					$act_cut_new_db[]=$sql_row2['a_s23'];
					$act_cut_new_db[]=$sql_row2['a_s24'];
					$act_cut_new_db[]=$sql_row2['a_s25'];
					$act_cut_new_db[]=$sql_row2['a_s26'];
					$act_cut_new_db[]=$sql_row2['a_s27'];
					$act_cut_new_db[]=$sql_row2['a_s28'];
					$act_cut_new_db[]=$sql_row2['a_s29'];
					$act_cut_new_db[]=$sql_row2['a_s30'];
					$act_cut_new_db[]=$sql_row2['a_s31'];
					$act_cut_new_db[]=$sql_row2['a_s32'];
					$act_cut_new_db[]=$sql_row2['a_s33'];
					$act_cut_new_db[]=$sql_row2['a_s34'];
					$act_cut_new_db[]=$sql_row2['a_s35'];
					$act_cut_new_db[]=$sql_row2['a_s36'];
					$act_cut_new_db[]=$sql_row2['a_s37'];
					$act_cut_new_db[]=$sql_row2['a_s38'];
					$act_cut_new_db[]=$sql_row2['a_s39'];
					$act_cut_new_db[]=$sql_row2['a_s40'];
					$act_cut_new_db[]=$sql_row2['a_s41'];
					$act_cut_new_db[]=$sql_row2['a_s42'];
					$act_cut_new_db[]=$sql_row2['a_s43'];
					$act_cut_new_db[]=$sql_row2['a_s44'];
					$act_cut_new_db[]=$sql_row2['a_s45'];
					$act_cut_new_db[]=$sql_row2['a_s46'];
					$act_cut_new_db[]=$sql_row2['a_s47'];
					$act_cut_new_db[]=$sql_row2['a_s48'];
					$act_cut_new_db[]=$sql_row2['a_s49'];
					$act_cut_new_db[]=$sql_row2['a_s50'];
				}
				
				$recut_qty_db=array();
				$recut_req_db=array();
				
				
				
				$sql1="select coalesce(sum(a_xs*a_plies),0) as \"a_xs\", coalesce(sum(a_s*a_plies),0) as \"a_s\", 
				coalesce(sum(a_m*a_plies),0) as \"a_m\", coalesce(sum(a_l*a_plies),0) as \"a_l\", 
				coalesce(sum(a_xl*a_plies),0) as \"a_xl\", coalesce(sum(a_xxl*a_plies),0) as \"a_xxl\", 
				coalesce(sum(a_xxxl*a_plies),0) as \"a_xxxl\", coalesce(sum(a_s01*a_plies),0) as \"a_s01\",
				coalesce(sum(a_s02*a_plies),0) as \"a_s02\",coalesce(sum(a_s03*a_plies),0) as \"a_s03\",
				coalesce(sum(a_s04*a_plies),0) as \"a_s04\",coalesce(sum(a_s05*a_plies),0) as \"a_s05\",
				coalesce(sum(a_s06*a_plies),0) as \"a_s06\",coalesce(sum(a_s07*a_plies),0) as \"a_s07\",
				coalesce(sum(a_s08*a_plies),0) as \"a_s08\",coalesce(sum(a_s09*a_plies),0) as \"a_s09\",coalesce(sum(a_s10*a_plies),0) as \"a_s10\",
				coalesce(sum(a_s11*a_plies),0) as \"a_s11\",coalesce(sum(a_s12*a_plies),0) as \"a_s12\",coalesce(sum(a_s13*a_plies),0) as \"a_s13\",
				coalesce(sum(a_s14*a_plies),0) as \"a_s14\",coalesce(sum(a_s15*a_plies),0) as \"a_s15\",coalesce(sum(a_s16*a_plies),0) as \"a_s16\",
				coalesce(sum(a_s17*a_plies),0) as \"a_s17\",coalesce(sum(a_s18*a_plies),0) as \"a_s18\",coalesce(sum(a_s19*a_plies),0) as \"a_s19\",
				coalesce(sum(a_s20*a_plies),0) as \"a_s20\",coalesce(sum(a_s21*a_plies),0) as \"a_s21\",coalesce(sum(a_s22*a_plies),0) as \"a_s22\",
				coalesce(sum(a_s23*a_plies),0) as \"a_s23\",coalesce(sum(a_s24*a_plies),0) as \"a_s24\",coalesce(sum(a_s25*a_plies),0) as \"a_s25\",
				coalesce(sum(a_s26*a_plies),0) as \"a_s26\",coalesce(sum(a_s27*a_plies),0) as \"a_s27\",coalesce(sum(a_s28*a_plies),0) as \"a_s28\",
				coalesce(sum(a_s29*a_plies),0) as \"a_s29\",coalesce(sum(a_s30*a_plies),0) as \"a_s30\",coalesce(sum(a_s31*a_plies),0) as \"a_s31\",
				coalesce(sum(a_s32*a_plies),0) as \"a_s32\",coalesce(sum(a_s33*a_plies),0) as \"a_s33\",coalesce(sum(a_s34*a_plies),0) as \"a_s34\",
				coalesce(sum(a_s35*a_plies),0) as \"a_s35\",coalesce(sum(a_s36*a_plies),0) as \"a_s36\",coalesce(sum(a_s37*a_plies),0) as \"a_s37\",
				coalesce(sum(a_s38*a_plies),0) as \"a_s38\",coalesce(sum(a_s39*a_plies),0) as \"a_s39\",coalesce(sum(a_s40*a_plies),0) as \"a_s40\",
				coalesce(sum(a_s41*a_plies),0) as \"a_s41\",coalesce(sum(a_s42*a_plies),0) as \"a_s42\",coalesce(sum(a_s43*a_plies),0) as \"a_s43\",
				coalesce(sum(a_s44*a_plies),0) as \"a_s44\",coalesce(sum(a_s45*a_plies),0) as \"a_s45\",coalesce(sum(a_s46*a_plies),0) as \"a_s46\",
				coalesce(sum(a_s47*a_plies),0) as \"a_s47\",coalesce(sum(a_s48*a_plies),0) as \"a_s48\",coalesce(sum(a_s49*a_plies),0) as \"a_s49\",
				coalesce(sum(a_s50*a_plies),0) as \"a_s50\",coalesce(sum(p_xs),0) as \"p_xs\", coalesce(sum(p_s),0) as \"p_s\", 
				coalesce(sum(p_m),0) as \"p_m\", coalesce(sum(p_l),0) as \"p_l\", coalesce(sum(p_xl),0) as \"p_xl\", coalesce(sum(p_xxl),0) as \"p_xxl\", 
				coalesce(sum(p_xxxl),0) as \"p_xxxl\", coalesce(sum(p_s01),0) as \"p_s01\",coalesce(sum(p_s02),0) as \"p_s02\",coalesce(sum(p_s03),0) as \"p_s03\",
				coalesce(sum(p_s04),0) as \"p_s04\",coalesce(sum(p_s05),0) as \"p_s05\",coalesce(sum(p_s06),0) as \"p_s06\",coalesce(sum(p_s07),0) as \"p_s07\",
				coalesce(sum(p_s08),0) as \"p_s08\",coalesce(sum(p_s09),0) as \"p_s09\",coalesce(sum(p_s10),0) as \"p_s10\",coalesce(sum(p_s11),0) as \"p_s11\",
				coalesce(sum(p_s12),0) as \"p_s12\",coalesce(sum(p_s13),0) as \"p_s13\",coalesce(sum(p_s14),0) as \"p_s14\",coalesce(sum(p_s15),0) as \"p_s15\",
				coalesce(sum(p_s16),0) as \"p_s16\",coalesce(sum(p_s17),0) as \"p_s17\",coalesce(sum(p_s18),0) as \"p_s18\",coalesce(sum(p_s19),0) as \"p_s19\",
				coalesce(sum(p_s20),0) as \"p_s20\",coalesce(sum(p_s21),0) as \"p_s21\",coalesce(sum(p_s22),0) as \"p_s22\",coalesce(sum(p_s23),0) as \"p_s23\",
				coalesce(sum(p_s24),0) as \"p_s24\",coalesce(sum(p_s25),0) as \"p_s25\",coalesce(sum(p_s26),0) as \"p_s26\",coalesce(sum(p_s27),0) as \"p_s27\",
				coalesce(sum(p_s28),0) as \"p_s28\",coalesce(sum(p_s29),0) as \"p_s29\",coalesce(sum(p_s30),0) as \"p_s30\",coalesce(sum(p_s31),0) as \"p_s31\",
				coalesce(sum(p_s32),0) as \"p_s32\",coalesce(sum(p_s33),0) as \"p_s33\",coalesce(sum(p_s34),0) as \"p_s34\",coalesce(sum(p_s35),0) as \"p_s35\",
				coalesce(sum(p_s36),0) as \"p_s36\",coalesce(sum(p_s37),0) as \"p_s37\",coalesce(sum(p_s38),0) as \"p_s38\",coalesce(sum(p_s39),0) as \"p_s39\",
				coalesce(sum(p_s40),0) as \"p_s40\",coalesce(sum(p_s41),0) as \"p_s41\",coalesce(sum(p_s42),0) as \"p_s42\",coalesce(sum(p_s43),0) as \"p_s43\",
				coalesce(sum(p_s44),0) as \"p_s44\",coalesce(sum(p_s45),0) as \"p_s45\",coalesce(sum(p_s46),0) as \"p_s46\",coalesce(sum(p_s47),0) as \"p_s47\",
				coalesce(sum(p_s48),0) as \"p_s48\",coalesce(sum(p_s49),0) as \"p_s49\",coalesce(sum(p_s50),0) as \"p_s50\" 
				from $bai_pro3.recut_v2_summary where order_tid=\"$order_tid\"";
				//echo $sql1;

				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result1))
				{
					$recut_qty_db[]=$sql_row2['a_xs'];
					$recut_qty_db[]=$sql_row2['a_s'];
					$recut_qty_db[]=$sql_row2['a_m'];
					$recut_qty_db[]=$sql_row2['a_l'];
					$recut_qty_db[]=$sql_row2['a_xl'];
					$recut_qty_db[]=$sql_row2['a_xxl'];
					$recut_qty_db[]=$sql_row2['a_xxxl'];
					$recut_qty_db[]=$sql_row2['a_s01'];
					$recut_qty_db[]=$sql_row2['a_s02'];
					$recut_qty_db[]=$sql_row2['a_s03'];
					$recut_qty_db[]=$sql_row2['a_s04'];
					$recut_qty_db[]=$sql_row2['a_s05'];
					$recut_qty_db[]=$sql_row2['a_s06'];
					$recut_qty_db[]=$sql_row2['a_s07'];
					$recut_qty_db[]=$sql_row2['a_s08'];
					$recut_qty_db[]=$sql_row2['a_s09'];
					$recut_qty_db[]=$sql_row2['a_s10'];
					$recut_qty_db[]=$sql_row2['a_s11'];
					$recut_qty_db[]=$sql_row2['a_s12'];
					$recut_qty_db[]=$sql_row2['a_s13'];
					$recut_qty_db[]=$sql_row2['a_s14'];
					$recut_qty_db[]=$sql_row2['a_s15'];
					$recut_qty_db[]=$sql_row2['a_s16'];
					$recut_qty_db[]=$sql_row2['a_s17'];
					$recut_qty_db[]=$sql_row2['a_s18'];
					$recut_qty_db[]=$sql_row2['a_s19'];
					$recut_qty_db[]=$sql_row2['a_s20'];
					$recut_qty_db[]=$sql_row2['a_s21'];
					$recut_qty_db[]=$sql_row2['a_s22'];
					$recut_qty_db[]=$sql_row2['a_s23'];
					$recut_qty_db[]=$sql_row2['a_s24'];
					$recut_qty_db[]=$sql_row2['a_s25'];
					$recut_qty_db[]=$sql_row2['a_s26'];
					$recut_qty_db[]=$sql_row2['a_s27'];
					$recut_qty_db[]=$sql_row2['a_s28'];
					$recut_qty_db[]=$sql_row2['a_s29'];
					$recut_qty_db[]=$sql_row2['a_s30'];
					$recut_qty_db[]=$sql_row2['a_s31'];
					$recut_qty_db[]=$sql_row2['a_s32'];
					$recut_qty_db[]=$sql_row2['a_s33'];
					$recut_qty_db[]=$sql_row2['a_s34'];
					$recut_qty_db[]=$sql_row2['a_s35'];
					$recut_qty_db[]=$sql_row2['a_s36'];
					$recut_qty_db[]=$sql_row2['a_s37'];
					$recut_qty_db[]=$sql_row2['a_s38'];
					$recut_qty_db[]=$sql_row2['a_s39'];
					$recut_qty_db[]=$sql_row2['a_s40'];
					$recut_qty_db[]=$sql_row2['a_s41'];
					$recut_qty_db[]=$sql_row2['a_s42'];
					$recut_qty_db[]=$sql_row2['a_s43'];
					$recut_qty_db[]=$sql_row2['a_s44'];
					$recut_qty_db[]=$sql_row2['a_s45'];
					$recut_qty_db[]=$sql_row2['a_s46'];
					$recut_qty_db[]=$sql_row2['a_s47'];
					$recut_qty_db[]=$sql_row2['a_s48'];
					$recut_qty_db[]=$sql_row2['a_s49'];
					$recut_qty_db[]=$sql_row2['a_s50'];

					
					$recut_req_db[]=$sql_row2['p_xs'];
					$recut_req_db[]=$sql_row2['p_s'];
					$recut_req_db[]=$sql_row2['p_m'];
					$recut_req_db[]=$sql_row2['p_l'];
					$recut_req_db[]=$sql_row2['p_xl'];
					$recut_req_db[]=$sql_row2['p_xxl'];
					$recut_req_db[]=$sql_row2['p_xxxl'];
					$recut_req_db[]=$sql_row2['p_s01'];
					$recut_req_db[]=$sql_row2['p_s02'];
					$recut_req_db[]=$sql_row2['p_s03'];
					$recut_req_db[]=$sql_row2['p_s04'];
					$recut_req_db[]=$sql_row2['p_s05'];
					$recut_req_db[]=$sql_row2['p_s06'];
					$recut_req_db[]=$sql_row2['p_s07'];
					$recut_req_db[]=$sql_row2['p_s08'];
					$recut_req_db[]=$sql_row2['p_s09'];
					$recut_req_db[]=$sql_row2['p_s10'];
					$recut_req_db[]=$sql_row2['p_s11'];
					$recut_req_db[]=$sql_row2['p_s12'];
					$recut_req_db[]=$sql_row2['p_s13'];
					$recut_req_db[]=$sql_row2['p_s14'];
					$recut_req_db[]=$sql_row2['p_s15'];
					$recut_req_db[]=$sql_row2['p_s16'];
					$recut_req_db[]=$sql_row2['p_s17'];
					$recut_req_db[]=$sql_row2['p_s18'];
					$recut_req_db[]=$sql_row2['p_s19'];
					$recut_req_db[]=$sql_row2['p_s20'];
					$recut_req_db[]=$sql_row2['p_s21'];
					$recut_req_db[]=$sql_row2['p_s22'];
					$recut_req_db[]=$sql_row2['p_s23'];
					$recut_req_db[]=$sql_row2['p_s24'];
					$recut_req_db[]=$sql_row2['p_s25'];
					$recut_req_db[]=$sql_row2['p_s26'];
					$recut_req_db[]=$sql_row2['p_s27'];
					$recut_req_db[]=$sql_row2['p_s28'];
					$recut_req_db[]=$sql_row2['p_s29'];
					$recut_req_db[]=$sql_row2['p_s30'];
					$recut_req_db[]=$sql_row2['p_s31'];
					$recut_req_db[]=$sql_row2['p_s32'];
					$recut_req_db[]=$sql_row2['p_s33'];
					$recut_req_db[]=$sql_row2['p_s34'];
					$recut_req_db[]=$sql_row2['p_s35'];
					$recut_req_db[]=$sql_row2['p_s36'];
					$recut_req_db[]=$sql_row2['p_s37'];
					$recut_req_db[]=$sql_row2['p_s38'];
					$recut_req_db[]=$sql_row2['p_s39'];
					$recut_req_db[]=$sql_row2['p_s40'];
					$recut_req_db[]=$sql_row2['p_s41'];
					$recut_req_db[]=$sql_row2['p_s42'];
					$recut_req_db[]=$sql_row2['p_s43'];
					$recut_req_db[]=$sql_row2['p_s44'];
					$recut_req_db[]=$sql_row2['p_s45'];
					$recut_req_db[]=$sql_row2['p_s46'];
					$recut_req_db[]=$sql_row2['p_s47'];
					$recut_req_db[]=$sql_row2['p_s48'];
					$recut_req_db[]=$sql_row2['p_s49'];
					$recut_req_db[]=$sql_row2['p_s50'];
				}
				
				echo "<h2><b>Order and Cut Details</b></h2>";
				echo "<div class='table-responsive' style='max-height:600px;overflow:auto;'>";
				echo "<table class='table table-sm table-bordered table-responsive' style='max-height:600px;overflow-x:scroll;overflow-y:scroll'>";
				echo "<tr><th>Size</th><th>Order Qty</th><th>Cut Qty</th><th>Recut Qty</th><th>Excess Cut Qty</th></tr>";
				for($i=0;$i<sizeof($order_qtys);$i++)
				{
					if($order_qtys[$i]>0)
					{
						echo "<tr>";
						echo "<td>".$sizes_db[$i]."</td>";
						echo "<td>".$order_qtys[$i]."</td>";
						echo "<td>".$act_cut_new_db[$i]."</td>";
						echo "<td>".$recut_qty_db[$i]."</td>";
						echo "<td>".(($act_cut_new_db[$i]+$recut_qty_db[$i])-$order_qtys[$i])."</td>";
						echo "</tr>";
					}
				}
				echo "</table>"; 
				
				echo "<h2><b>Transaction Log</b></h2>";
				
				echo "<table class='table table-sm table-bordered table-responsive' style='max-height:600px;overflow:auto>";
				
				echo "<tr class='info'>
					<th colspan=6 class=\"total\">Total</th>
					<th id=\"col1\" class=\"total\" >0</th>
					<th id=\"col2\" class=\"total\" >0</th>
					<th id=\"col3\" class=\"total\" >0</th>
					<th id=\"col4\" class=\"total\" >0</th>
					<th id=\"col5\" class=\"total\" >0</th>
					<th id=\"col6\" class=\"total\" >0</th>
					<th id=\"col7\" class=\"total\" >0</th>
					<th id=\"col8\" class=\"total\" >0</th>
					<th id=\"col9\" class=\"total\" >0</th>
				</tr>";
				
				echo "<tr class='danger'>
					<th class=\"filter\" style='width : 100px'>Log Date</th>
					<th class=\"filter\">Module</th>
					<th>Style</th>
					<th>Schedule</th>
					<th>Color</th>
					<th class=\"filter\">Size</th>
					<th>Good Panels</th>
					<th>Rejected</th>
					<th>Replaced</th>
					<th>Recut Req.</th>
					<th>Recut Act.</th>
					<th>Sample Received</th>
					<th>Sample Sent</th>
					<th>O.R. (Garments)</th>
					<th>Destroyed</th>
				</tr>";
				
				$sql="select * from $bai_pro3.bai_qms_pop_report where qms_style=\"".$_GET['style']."\" and qms_schedule=\"".$_GET['schedule']."\" and qms_color=\"".$_GET['color']."\" order by log_date,module";
			//echo $sql;
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					echo "<tr>";
					echo "<td>".$sql_row['log_date']."</td>";
					echo "<td>".str_pad($sql_row['module'],2,"0",STR_PAD_LEFT)."</td>";
					echo "<td>".$sql_row['qms_style']."</td>";
					echo "<td>".$sql_row['qms_schedule']."</td>";
					echo "<td>".$sql_row['qms_color']."</td>";
					echo "<td>".$sql_row['qms_size']."</td>";
					echo "<td>".$sql_row['good_panels']."</td>";
					echo "<td>".$sql_row['rejected']."</td>";
					echo "<td>".$sql_row['replaced']."</td>";
					echo "<td>0</td>";
					echo "<td>0</td>";	
					echo "<td>".$sql_row['sample_room']."</td>";
					echo "<td>".$sql_row['sent_to_customer']."</td>";
					echo "<td>".$sql_row['good_garments']."</td>";
					echo "<td>".$sql_row['disposed']."</td>";
					echo "</tr>";
				} 
				
				$recut_docs=array();
				
				$sql="select doc_no from $bai_pro3.recut_v2_summary where order_tid in (select order_tid 
					from $bai_pro3.bai_orders_db_confirm where order_style_no=\"".$_GET['style']."\" and order_del_no=\"".$_GET['schedule']."\" and order_col_des=\"".$_GET['color']."\")";
			//echo $sql."<br/>";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$recut_docs[]=$sql_row['doc_no'];
				}
				
				if(sizeof($recut_docs)>0)
				{
					$sql="select *,SUBSTRING_INDEX(remarks,'-',1) as \"module\" from $bai_pro3.bai_qms_db where qms_style=\"".$_GET['style']."\" and qms_schedule=\"".$_GET['schedule']."\" and qms_color=\"".$_GET['color']."\" and qms_tran_type in (6,9) and SUBSTRING_INDEX(remarks,'-',-1) in (".implode(",",$recut_docs).") order by log_date,SUBSTRING_INDEX(remarks,'-',1)";
				//cho $sql."<br/>";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						echo "<tr>";
						echo "<td>".$sql_row['log_date']."</td>";
						echo "<td>".str_pad($sql_row['module'],2,"0",STR_PAD_LEFT)."</td>";
						echo "<td>".$sql_row['qms_style']."</td>";
						echo "<td>".$sql_row['qms_schedule']."</td>";
						echo "<td>".$sql_row['qms_color']."</td>";
						echo "<td>".$sql_row['qms_size']."</td>";
						echo "<td>0</td>";
						echo "<td>0</td>";
						echo "<td>0</td>";
						if($sql_row['qms_tran_type']==6)
						{
							echo "<td>".$sql_row['qms_qty']."</td>";
						}
						else
						{
							echo "<td>0</td>";
						}
						if($sql_row['qms_tran_type']==9)
						{
							echo "<td>".$sql_row['qms_qty']."</td>";
						}
						else
						{
							echo "<td>0</td>";
						}
						echo "<td>0</td>";
						echo "<td>0</td>";
						echo "<td>0</td>";
						echo "<td>0</td>";
						echo "</tr>";
					}
				}
				
			}
			echo "</table>
			</div>";
		?>
	</div>
</div>
</div>


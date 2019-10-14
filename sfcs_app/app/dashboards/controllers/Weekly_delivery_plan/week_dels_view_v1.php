<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/db_hosts.php");
// include("dbconf.php");
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/user_acl_v1.php");
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");
$view_access=user_acl("SFCS_0198",$username,1,$group_id_sfcs);
?>
<?php
//This interface is with additional feature to filter buyer division/exfactory/Status
$start_date_w=time();
while((date("N",$start_date_w))!=1)
{
	$start_date_w=$start_date_w-(60*60*24); // define monday
}
$end_date_w=$start_date_w+(60*60*24*6); // define sunday
//echo date("Y-m-d",$end_date_w).   "<br/>";
//echo date("Y-m-d",$start_date_w);

$start_date_w=date("Y-m-d",$start_date_w);
$end_date_w=date("Y-m-d",$end_date_w);
?>
<html>
<head>
<style>

#otherdiv2 table,th
{
    background-color: #003366;
    color: yellow;
    border-bottom: 5px solid white;
    border-top: 5px solid white;
    padding: 5px;
    white-space:nowrap;
    border-collapse:collapse;
    text-align:center;
    font-family:Calibri;
    font-size:110%;

}

#otherdiv2 table,td
{
    background-color: grey;
    color: white;
    border-bottom: 5px solid white;
    border-top: 5px solid white;

    padding-right: 5px;
    white-space:nowrap;
    border-collapse:collapse;
    text-align: center;
    font-family:Calibri;
    font-size:110%;

}

#otherdiv2 table,td.completed
{
    background-color: red;
    color: white;
    border-bottom: 5px solid white;
    border-top: 5px solid white;

    padding-right: 5px;
    white-space:nowrap;
    border-collapse:collapse;
    text-align: center;
    font-family:Calibri;
    font-size:110%;

}

#otherdiv2 table,tr
{
    background-color: #000000;
    color: #003366;
    border-bottom: 5px solid white;
    border-top: 5px solid white;
    padding: 1px;
    white-space:nowrap;
    border-collapse:collapse;
    font-family:Calibri;
    font-size:110%;

}

#otherdiv2 table
{
    white-space:nowrap;
    border-collapse:collapse;
    width:100%;
	border:1px solid #ccc;
    font-family:Calibri;
    font-size:110%;

}

#otherdiv2 font
{
    font-family:Calibri;
}


/* body
{
    font-family:Calibri;
} */


</style>

<style>
iframe {
    height: auto;
    width: 200px;
    border: 0;
    overflow:auto;
        }
</style>

<script>

function redirect_view()
{
    var x=document.filter.view_div.value;
    var y=document.filter.ex_fact.value;
    // var z=document.filter.status.value;
    // window.location = "index.php?r=<?= $_GET['r'] ?>&view_div="+encodeURIComponent(x)+"&ex_fact="+y+"&status="+z;
	window.location = "index.php?r=<?= $_GET['r'] ?>&view_div="+encodeURIComponent(x)+"&ex_fact="+y+"&status="+z;
}

</script>

<?php
$Hourly_Style_Break = getFullURL($_GET['r'],'Hourly_Style_Break.php','N');
?>
<div class="panel panel-primary"><div class="panel-heading">Weekly Delivery Plan</div><div class="panel-body">
<div id="otherdiv2">
<?php
    //Filter Code
    $query_add="";
	
	if($_GET["view_div"]!='ALL' && $_GET["view_div"]!='')
	{
		//echo "Buyer=".urldecode($_GET["view_div"])."<br>";
		$buyer_division=urldecode($_GET["view_div"]);
		// echo '"'.str_replace(",",'","',$buyer_division).'"'."<br>";
		$buyer_division_ref='"'.str_replace(",",'","',$buyer_division).'"';
		$order_div_ref="and buyer_division in (".$buyer_division_ref.")";
	}
	else {
		 $order_div_ref='';
	}	
	
    if(isset($_GET['ex_fact']) and $_GET['view_div']!="ALL")
    {
        $query_add.=$order_div_ref;
    }

    if(isset($_GET['ex_fact']) and  $_GET['ex_fact']!="ALL")
    {
        $query_add.=" and ex_factory_date_new="."'".$_GET['ex_fact']."'";
    }

    if(isset($_GET['status']) and $_GET['status']!="ALL")
    {
        $query_add.=" and priority in (".$_GET['status'].")";
    }
    // $sql ='SELECT GROUP_CONCAT(DISTINCT ex_factory_date_new) AS ex_factory, COUNT(*) AS "count", SUM(IF(priority=1,1,0)) AS "c_fca", SUM(IF(priority=-1,1,0)) AS "sent", SUM(IF(priority=2,1,0)) AS "c_fg", SUM(IF(priority=3,1,0)) AS "c_sw", SUM(IF(priority=3,1,0)) AS "c_pack" FROM bai_pro4.week_delivery_plan_ref WHERE ex_factory_date_new BETWEEN "2017-03-19" AND "2018-02-05" ';
    $sql="select group_concat(distinct ex_factory_date_new ORDER BY ex_factory_date_new ASC) as ex_factory, count(*) as \"count\", sum(if(priority=1,1,0)) as \"c_fca\", sum(if(priority=-1,1,0)) as \"sent\", sum(if(priority=2,1,0)) as \"c_fg\", sum(if(priority=3,1,0)) as \"c_sw\", sum(if(priority=3,1,0)) as \"c_pack\" from $bai_pro4.week_delivery_plan_ref  where ex_factory_date_new between \"$start_date_w\" and \"$end_date_w\" $query_add";
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error4=".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row=mysqli_fetch_array($sql_result))
    {
        $c_fca=$sql_row['c_fca'];
        $c_fg=$sql_row['c_fg'];
        $c_sw=$sql_row['c_sw'];
        $count=$sql_row['count'];
        $sent_count=$sql_row['sent'];
        $c_pack=$sql_row['c_pack'];
        //$ex_factory=$sql_row['ex_factory'];
    }

    $sql="select group_concat(distinct ex_factory_date_new ORDER BY ex_factory_date_new ASC) as ex_factory from $bai_pro4.week_delivery_plan_ref  where ex_factory_date_new between \"$start_date_w\" and \"$end_date_w\" ";
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error5=".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row=mysqli_fetch_array($sql_result))
    {
        $ex_factory=$sql_row['ex_factory'];
    }

		$buyer_query="SELECT * FROM $bai_pro2.buyer_codes WHERE STATUS=1 order by buyer_name";
		$buyers=mysqli_query($link, $buyer_query) or exit("Sql Error6=".mysqli_error($GLOBALS["___mysqli_ston"]));
    ?>
    <form name="filter" method="post">
    <div class="row"><div class='col-md-2' style='margin-left:1.2em;'><br/><label><h4><bold>Quick Filter : </bold></h4></label></div>
		<div class='col-md-2'><label>Buyer Division</label>
        <?php
        //Filter Form
        echo '<select name="view_div" id="view_div" onchange="redirect_view()" class="form-control" style="background-color:#66DDFF;">';
        if($_GET['view_div']=="ALL") { echo '<option value="ALL" selected>All</option>'; } else { echo '<option value="ALL">All</option>'; }
        while ($sql_row=mysqli_fetch_array($buyers))
        {
            if($_GET['view_div']==$sql_row["buyer_name"]) { echo '<option value="'.$sql_row["buyer_name"].'" selected>'.$sql_row["buyer_name"].'</option>'; } else { echo '<option value="'.$sql_row["buyer_name"].'">'.$sql_row["buyer_name"].'</option>'; }
        }


        echo '</select>';
        ?>
        </div>
		<div class='col-md-2'><label>Ex-Factory</label>
        <?php
        echo '<select name="ex_fact" id="ex_fact" onchange="redirect_view()" class="form-control" style="background-color:#FFDDFF;">';
        $temp=array();
        $temp=explode(",",$ex_factory);
        if($_GET['ex_fact']=="ALL") { echo '<option value="ALL" selected>All</option>'; } else { echo '<option value="ALL">All</option>'; }
        for($i=0;$i<sizeof($temp);$i++)
        {
            if($_GET['ex_fact']==$temp[$i]) { echo '<option value="'.$temp[$i].'" selected>'.$temp[$i].'</option>'; } else { echo '<option value="'.$temp[$i].'">'.$temp[$i].'</option>'; }
        }
            echo '</select>';
        ?>
        </div>       
        </div>
        </form>
    <?php
    if($sql_result != NULL){
    ?>
    <div class='col-md-12' style='max-height:600px;overflow-y:scroll;'>
    <table class="table-responsive">
    <?php
    echo "<tr><th colspan=4>Orders  : $count</th><th colspan=2>Packing : ".($c_pack+$c_fg+$c_fca+$sent_count)."</th><th colspan=2>FG : ".($c_fg+$c_fca+$sent_count)."</th><th colspan=2>FCA : ".($c_fca+$sent_count)."</th><th colspan=3>Shipped : $sent_count</th></tr>";
    echo "<tr><th>Status</th><th>Style</th><th>Schedule</th><th>Color</th><th>Size</th><th>Order</th><th>Cut</th><th>Input</th><th>Output</th>";
    echo "<th>FG Qty</th><th>FCA</th><th>Ex-Fac</th><th>Cartons</th>";

    $grand_order=0;
    $grand_cut=0;
    $grand_input=0;
    $grand_output=0;
    $grand_plan=0;
    $grand_variance=0;
    $grand_fca=0;
    $grand_internal_audited=0;
    $grand_fg=0;
    $grand_carts=0;


    $sql="select * from $bai_pro4.week_delivery_plan_ref  where ex_factory_date_new between \"$start_date_w\" and \"$end_date_w\" $query_add AND schedule_no > 0 order by priority,ex_factory_date_new,style,schedule_no,color";
    // $sql="select * from bai_pro4.week_delivery_plan_ref where ex_factory_date_new between '".'2017-03-19'."' and '".'2018-03-05'."' $query_add order by priority,ex_factory_date_new,style,schedule_no,color";
	// echo $sql."<br>";
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row=mysqli_fetch_array($sql_result))
    {
        $ref_id=$sql_row['ref_id'];
        $ship_tids=$sql_row['ship_tid'];
        $priority=$sql_row['priority'];
        $style=$sql_row['style'];
        $schedule=$sql_row['schedule_no'];
        $color=$sql_row['color'];
        $cut=$sql_row['act_cut'];
        $in=$sql_row['act_in'];
        $out=$sql_row['output'];
        $pendingcarts=$sql_row['cart_pending'];
		$size=$sql_row['size'];
        //$ex_factory_date=$sql_row['ex_factory_date'];
        //$rev_exfactory=$sql_row['rev_exfactory'];

        $ex_factory_date=$sql_row['ex_factory_date_new'];
        $rev_exfactory=$sql_row['ex_factory_date_new'];

        $order=$sql_row['ord_qty_new'];

        $fcamca=$sql_row['act_mca'];
        $fgqty=$sql_row['act_fg'];

        $internal_audited=$sql_row['act_fca'];


        $status="NIL";

        switch($priority)
        {
            case 0:
            {
                $status="RM";
                break;
            }
            case 6:
            {
                $status="RM";
                break;
            }
            case 5:
            {
                $status="Cutting";
                break;
            }
            case 4:
            {
                $status="Sewing";
                break;
            }
            case 3:
            {
                $status="Packing";
                break;
            }
            case 2:
            {
                $status="FG";
                break;
            }
            case 1:
            {
                $status="FCA";
                break;
            }
            case -1:
            {
                $status="Shipped";
                break;
            }
        }

        $sql2="SELECT remarks FROM $bai_pro4.week_delivery_plan WHERE ref_id=\"".$ref_id."\"";
        $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2=".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($sql_row2=mysqli_fetch_array($sql_result2))
        {
            $remarks=$sql_row2["remarks"];
        }

        $remarks_plan=explode("^",$remarks);

        if(strtolower($remarks_plan[0]) == "hold")
        {
            $status="Hold";
        }

        $sql22="SELECT sum(pcs) as pcs FROM $bai_pro3.fca_audit_fail_db WHERE schedule=\"".$schedule."\"";
        $sql_result22=mysqli_query($link, $sql22) or exit("Sql Error3=".mysqli_error($GLOBALS["___mysqli_ston"]));
        $count_fca=mysqli_num_rows($sql_result22);
        while($sql_row22=mysqli_fetch_array($sql_result22))
        {
            $pcs=$sql_row22["pcs"];
        }
        if($pcs < 0)
        {
            $status="AQL";
        }


        if($out>=$order)
        {
            $plan=$order;
        }

        //new configure
        $add_front="";
        $add_back="";
        $col="yellow";
        $comple_class="";
        if($out>=$fgqty and $out>0 and $fgqty==$order)
        {
            if($ex_factory_date==date("Y-m-d") or $rev_exfactory==date("Y-m-d"))
            {

                $add_front="<font color=\"#66FF33\"><strong>";
                $add_back="</strong></font>";
                $col="#66FF33";
                $comple_class="class=\"completed\"";
            }
            else
            {

                $add_front="<font color=\"#66FF33\"><strong>";
                $add_back="</strong></font>";
                $col="#66FF33";
                //$comple_class="class=\"completed\"";
            }
        }

        if($ex_factory_date==date("Y-m-d") or $rev_exfactory==date("Y-m-d"))
        {
            $comple_class="class=\"completed\"";
        }
        //new configure

        echo "<tr><td $comple_class>$status</td>
        <td>$add_front
        <a href='index.php?r=$Hourly_Style_Break&styles=$style&schedule=$schedule' 
            onclick=\"Popup=window.open('$Hourly_Style_Break&styles=$style&schedule=$schedule',
            'Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=200, top=23'); 
            if (window.focus){
                Popup.focus()
            } 
            return false;\" 
            style=\"text-decoration:none; color:$col;\">$style</a>$add_back</td>
        <td>$add_front$schedule$add_back</td><td>$add_front$color$add_back</td><td>$add_front$size$add_back</td><td>$add_front$order$add_back</td><td>$add_front$cut$add_back</td><td>$add_front$in$add_back</td><td>$add_front$out$add_back</td>";


        $col="#66FF33";
        //echo "<td>$plan_tgt</td><td>$speed_act</td>";
        //echo "<td>".($plan)."</td><td>".($out-$plan)."</td>";
        if($out==$fgqty and $out>0 and $fgqty==$order)
        {
            echo "<td><font color=\"$col\"><strong>".$fgqty."</strong></font></td>";
        }
        else
        {
            echo "<td>".$fgqty."</td>";
        }

        //echo "<td>$add_front$internal_audited$add_back</td><td>$add_front".$fcamca."$add_back</td><td>$add_front$pendingcarts$add_back</td></tr>";
        echo "<td>$add_front$internal_audited$add_back</td><td>$add_front".date("m/d",strtotime($ex_factory_date))."$add_back</td><td>$add_front$pendingcarts$add_back</td></tr>";
        //echo "<td>$fabric</td><td>$elastic</td><td>$label</td><td>$thread</td></tr>";

        $grand_order+=$order;
        $grand_cut+=$cut;
        $grand_input+=$in;
        $grand_output+=$out;
        $grand_plan+=$plan;
        $grand_variance+=($out-$plan);
        $grand_carts+=$pendingcarts;
        $grand_fca+=$fcamca;
        $grand_fg+=$fgqty;
        $grand_internal_audited+=$internal_audited;
    }

    echo "<tr><td colspan=5 style=\"border-top:1px solid white; text-align:left;\">Grand Total</td><td  style=\"border-top:1px solid white;\">$grand_order</td><td  style=\"border-top:1px solid white;\">$grand_cut</td><td  style=\"border-top:1px solid white;\">$grand_input</td><td  style=\"border-top:1px solid white;\">$grand_output</td>";
//echo "<td  style=\"border-top:1px solid white;\">$grand_plan</td><td  style=\"border-top:1px solid white;\">$grand_variance</td>";
echo "<td  style=\"border-top:1px solid white;\">$grand_fg</td>";
echo "<td  style=\"border-top:1px solid white;\">$grand_internal_audited</td><td  style=\"border-top:1px solid white;\">$grand_fca</td><td  style=\"border-top:1px solid white;\">$grand_carts</td>";
echo "</tr>";
    echo "</table></div>";
    }
    else {
        echo "<br/><br/><br/><div class='panel panel-default'><span style='color:RED;font-size:25px;'><center><b>No Data Found!</b></center></span></div>";
    }
//echo "<script> document.getElementById('a001').innerHTML=\"test\"; </script>";

    //echo "</td><td valign=\"bottom\">";
    //echo "<font color=\"yellow\" size=\"1\"><a href=\"$dns_adr2/projects/Beta/visionair/speed_dels/mate_table_edit/index.php\" style=\"text-decoration:none; color:yellow;\">Last Updated at:<br/>$lastup</a></font>";

    //echo "</td></tr></table>";

?>
</div>

<script type="text/javascript">
//<![CDATA[

var screenHeight = screen.height;
var browserToolBarHeight = 220;

var contentH = screenHeight - (browserToolBarHeight) + "px";
document.getElementById('otherdiv2').style.height = contentH;

//]]>
</script>
</html>
</head>
</div></div>
</div>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>HTML Table Filter Generator v1.6 - Examples</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{ 
	margin:15px; padding:15px; border:1px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	border:1px solid #ccc;
}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; border:2px outset #f4f4f4; margin:2px; }
th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; }

</style>
<script language="javascript" type="text/javascript" src="actb.js"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="tablefilter.js"></script>
</head>

<body>

<h2><a name="tbl6" id="tbl6"></a>TABLE 6</h2>
<p>Set paging, enable loader, set rows counter and reset button</p>
<form name="test" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<table id="table6" class="mytable" >
	<tr>
		<th>World Regions</th>
		<th>Population ( 2007 Est.)</th>
		<th>Population % of World</th>
		<th>Internet Usage, Latest Data</th>
		<th>% Population ( Penetration )</th>
		<th>Usage % of World</th>
		<th>Usage Growth 2000-2007</th>
	</tr>
	<tr>
		<td>Africa</td>
		<td>933,448,292</td>
		<td>14.2 %</td>
		<td>32,765,700</td>
		<td>3.5 %</td>
		<td>3.0 %</td>
		<td><input type="text" name="vals[]"></td>
	</tr>
	<tr>
		<td>Asia</td>
		<td>3,712,527,624</td>
		<td>56.5 %</td>
		<td>389,392,288</td>
		<td>10.5 %</td>
		<td>35.6 %</td>
		<td><input type="text" name="vals[]"></td>
	</tr>
	<tr>
		<td>Europe</td>
		<td>809,624,686</td>
		<td>12.3 %</td>
		<td>312,722,892</td>
		<td>38.6 %</td>
		<td>28.6 %</td>
		<td><input type="text" name="vals[]"></td>
	</tr>
	<tr>
		<td>Middle	East</td>
		<td>193,452,727</td>
		<td>2.9 %</td>
		<td>19,382,400</td>
		<td>10.0 %</td>
		<td>1.8 %</td>
		<td><input type="text" name="vals[]"></td>
	</tr>
	<tr>
		<td>North America</td>
		<td>334,538,018</td>
		<td>5.1 %</td>
		<td>232,057,067</td>
		<td>69.4 %</td>
		<td>21.2 %</td>
		<td><input type="text" name="vals[]"></td>
	</tr>
	<tr>
		<td>Latin America / Caribbean</td>
		<td>556,606,627</td>
		<td>8.5 %</td>
		<td>88,778,986</td>
		<td>16.0 %</td>
		<td>8.1 %</td>
		<td><input type="text" name="vals[]"></td>
	</tr>
	<tr>
		<td>Oceania / Australia</td>
		<td>34,468,443</td>
		<td>0.5 %</td>
		<td>18,430,359</td>
		<td>53.5 %</td>
		<td>1.7 %</td>
		<td><input type="text" name="vals[]"></td>
	</tr>
</table>
<input type="submit" name="submit" value="submit">
</form>
<pre><code>
&lt;script language=&quot;javascript&quot; type=&quot;text/javascript&quot;&gt;
//&lt;![CDATA[
	var table6_Props = 	{
					paging: true,
					paging_length: 3,
					rows_counter: true,
					btn_reset: true,
					loader: true,
					loader_text: &quot;Filtering data...&quot;
				};
	setFilterGrid( &quot;table6&quot;,table6_Props );
//]]&gt;
&lt;/script&gt;</code></pre>
<script language="javascript" type="text/javascript">
//<![CDATA[
	var table6_Props = 	{
							paging: true,
							paging_length: 3,
							rows_counter: true,
							btn_reset: true,
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "table6",table6_Props );
//]]>
</script>

</body>
</html>


<?php

if(isset($_POST['submit']))
{
	$vals=$_POST['vals'];
	
	for($i=0;$i<sizeof($vals);$i++)
	{
		echo $vals[$i]."<br/>";
		
	}
}


?>
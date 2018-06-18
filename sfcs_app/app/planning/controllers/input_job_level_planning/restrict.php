<?php
// include("dbconf.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
$group_docs=$_GET['group_docs'];

echo "<h2>You are not authorised to use this page.</h2><Br/><Br/>";

echo "<h2>Update Fabric Location</h2>";
echo '<form name="test" method="post" action"'.$_SERVER['PHP_SELF'].'">';
echo '<input type="hidden" name="group_docs" value="'.$group_docs.'">';

echo '<select name="location">';

echo "<option value='F-1'>F-1</option>";
echo "<option value='F-2'>F-2</option>";
echo "<option value='F-3'>F-3</option>";
echo "<option value='F-4'>F-4</option>";
echo "<option value='F-5'>F-5</option>";
echo "<option value='F-6'>F-6</option>";
echo "<option value='F-7'>F-7</option>";
echo "<option value='F-8'>F-8</option>";
echo "<option value='F-9'>F-9</option>";
echo "<option value='F-10'>F-10</option>";
echo "<option value='F-11'>F-11</option>";
echo "<option value='F-12'>F-12</option>";
echo "<option value='F-13'>F-13</option>";
echo "<option value='F-14'>F-14</option>";
echo "<option value='F-15'>F-15</option>";
echo "<option value='F-16'>F-16</option>";
echo "<option value='F-17'>F-17</option>";
echo "<option value='F-18'>F-18</option>";
echo "<option value='F-19'>F-19</option>";
echo "<option value='F-20'>F-20</option>";
echo "<option value='F-21'>F-21</option>";
echo "<option value='F-22'>F-22</option>";
echo "<option value='F-23'>F-23</option>";
echo "<option value='F-24'>F-24</option>";
echo "<option value='F-25'>F-25</option>";
echo "<option value='F-26'>F-26</option>";
echo "<option value='F-27'>F-27</option>";
echo "<option value='F-28'>F-28</option>";
echo "<option value='F-29'>F-29</option>";
echo "<option value='F-30'>F-30</option>";
echo "<option value='F-31'>F-31</option>";
echo "<option value='F-32'>F-32</option>";
echo "<option value='F-33'>F-33</option>";
echo "<option value='F-34'>F-34</option>";
echo "<option value='F-35'>F-35</option>";
echo "<option value='F-36'>F-36</option>";
echo "<option value='F-37'>F-37</option>";
echo "<option value='F-38'>F-38</option>";
echo "<option value='F-39'>F-39</option>";
echo "<option value='F-40'>F-40</option>";
echo "<option value='F-41'>F-41</option>";
echo "<option value='F-42'>F-42</option>";
echo "<option value='F-43'>F-43</option>";
echo "<option value='F-44'>F-44</option>";
echo "<option value='F-45'>F-45</option>";
echo "<option value='F-46'>F-46</option>";
echo "<option value='F-47'>F-47</option>";
echo "<option value='F-48'>F-48</option>";
echo "<option value='F-49'>F-49</option>";
echo "<option value='F-50'>F-50</option>";
echo "<option value='F-51'>F-51</option>";
echo "<option value='F-52'>F-52</option>";
echo "<option value='F-53'>F-53</option>";
echo "<option value='F-54'>F-54</option>";
echo "<option value='F-55'>F-55</option>";
echo "<option value='F-56'>F-56</option>";
echo "<option value='F-57'>F-57</option>";
echo "<option value='F-58'>F-58</option>";
echo "<option value='F-59'>F-59</option>";
echo "<option value='F-60'>F-60</option>";
echo "<option value='F-61'>F-61</option>";
echo "<option value='F-62'>F-62</option>";
echo "<option value='F-63'>F-63</option>";
echo "<option value='F-64'>F-64</option>";
echo "<option value='F-65'>F-65</option>";
echo "<option value='F-66'>F-66</option>";
echo "<option value='F-67'>F-67</option>";
echo "<option value='F-68'>F-68</option>";
echo "<option value='F-69'>F-69</option>";
echo "<option value='F-70'>F-70</option>";
echo "<option value='F-71'>F-71</option>";
echo "<option value='F-72'>F-72</option>";
echo "<option value='F-73'>F-73</option>";
echo "<option value='F-74'>F-74</option>";


echo '</select>';

echo '<input type="submit" name="submit" value="Update Fabric Location">';
echo '</form>';
//echo "<h2>You are not authorised to use this page.</h2>";


if(isset($_POST['submit']))
{
	echo "Please Wait....";
	
	$group_docs=$_POST['group_docs'];
	$location=$_POST['location'];
	
	$sql1="update plandoc_stat_log set plan_lot_ref=concat(plan_lot_ref,'$','$location') where doc_no in ($group_docs)";
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	echo "<script type=\"text/javascript\"> window.close(); </script>";
	
}

?>
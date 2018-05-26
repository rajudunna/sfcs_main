
<div class="panel panel-primary">
<div class="panel-heading">CTPAT</div>
<div class="panel-body">
<a class='btn btn-primary pull-right' href="<?php echo getFullURLLevel($_GET['r'],'index.php',0,'N')   ?> ">Upload</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a class='btn btn-warning pull-right' href="<?php echo getFullURLLevel($_GET['r'],'main.php',0,'N')  ?> ">View</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
	//if(in_array($username,$edit_users))
	{
?>
		<a class='btn btn-warning pull-right' href="<?php echo getFullURLLevel($_GET['r'],'edit.php',0,'N'); ?> ">Edit</a>
<?php
	}
?>
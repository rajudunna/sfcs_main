
<!-- <style>
body{
	font-family: "calibri";
}
</style> -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/css/dropdowntabs.js',3,'R'); ?>"></script>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R'); ?>" type="text/css" media="all" />
<!-- <link rel="stylesheet" href="../table_style.css" type="text/css" media="all" /> -->

<?php 
// include(getFullURLLevel($_GET['r'],'dbConfig.php',0,'R')); ?>

<?php 
session_start();
?>

<div class="panel panel-primary">
<div class="panel-heading">Upload FR Plan</div>
<div class="panel-body">

<form action="<?= getFullURL($_GET['r'],'importData.php','N'); ?>" method="post" enctype="multipart/form-data" id="importFrm"> 
<div class="row">
	<div class='col-md-3'>
	<label>Choose File Location: </label><input type="file" name="file" class="form-control" accept=".xlsx,.csv" size="25" value="" required/><br><br>
	<label class="label label-danger">Note :</label>&nbsp;<label class="label label-primary">Upload only .csv format files.</label>
	</div>
	<div class='col-md-3'>
	<input type="submit" class="btn btn-success" name="importSubmit" value="Import" style="margin-top: 22px;">
	</div> 
</div>
</form>

</div>
</div>

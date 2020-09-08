<script src="<?= getFullURLLevel($_GET['r'],'common/js/jquery-2.1.3.min.js',3,'R'); ?>"></script>
  <script src="<?= getFullURLLevel($_GET['r'],'common/js/sweetalert-dev.js',3,'R'); ?>"></script>
  <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/sweetalert.css',3,'R'); ?>">
<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$docno=$_GET['doc_no'];
$repseq=$_GET['repseqid'];
$style=$_GET['style'];
$schedule=$_GET['schedule'];
$color=$_GET['color'];
$url1=getFullURL($_GET['r'],'emb_barcode_bulk_print.php','N').'&style='.$style.'&schedule='.$schedule.'&color='.$color;

$update_psl_query = "UPDATE $pps.emb_bundles set print_status=0,updated_user='$username',updated_at=NOW() where doc_no=".$docno." and report_seq=".$repseq."";  
$update_result = mysqli_query($link,$update_psl_query) or exit('Query Error');

echo"<script>setTimeout(function () { 
		swal({
			title: 'Barcodes Released successfully.',
			type: 'success',
			confirmButtonText: 'OK'
		},
		function(isConfirm){
			if (isConfirm) {
			window.location.href = \"$url1\";
			}
		}); }, 100);</script>";
	echo "<script>window.location.href = \"$url1\"</script>";
				
?>
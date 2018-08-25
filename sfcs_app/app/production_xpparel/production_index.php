<div class="row">
<div class="col-lg-12">

<div class="btn-group" role="group">
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Operations
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a href="?r=<?= base64_encode('/sfcs_app/app/production/controllers/sewing_job/sewing_job_scaning/bundle_operations.php'); ?>"  myattribute="production_body" id="scanning">Mapping</a></li>
        <li><a href="?r=<?= base64_encode('/sfcs_app/app/production/controllers/sewing_job/sewing_job_scaning/pre_input_job_scanning.php'); ?>" myattribute="production_body" id="scanning">Scanning</a></li>
    </ul>
</div>

<div class="btn-group pull-right" role="group" aria-label="..." myattribute="production_body">
    <div class='pull-left' style='padding-top:7px'><font style='font-size:15px'>WorkArea :&nbsp</label></div>
    <a href="?r=L3NmY3NfYXBwL2FwcC9kYXNoYm9hcmRzL2NvbnRyb2xsZXJzL0lQUy90bXNfZGFzaGJvYXJkX2lucHV0X3YyMi5waHANCg==&modal=yes" class="btn btn-default" myattribute="production_body" id="sewing">Sewing</a>
    <div class="btn-group" role="group">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cutting<span class="caret"></span></button><ul class="dropdown-menu"><li><a href="?r=L3NmY3NfYXBwL2FwcC9kYXNoYm9hcmRzL2NvbnRyb2xsZXJzL2Nwcy9mYWJfcHJpb3JpdHlfZGFzaGJvYXJkLnBocA==&modal=yes" myattribute="production_body" id="cut">Cut</a></li><li><a href="?r=<?= base64_encode('/sfcs_app/app/dashboards/controllers/RTS/fab_pps_recut_dashboard_v4.php').'&modal=yes';?>" myattribute="production_body" id="recut">Re-Cut</a></li></ul></div>
    <div class="btn-group" role="group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Material<span class="caret"></span></button><ul class="dropdown-menu"><li><a href="?r=L3NmY3NfYXBwL2FwcC9kYXNoYm9hcmRzL2NvbnRyb2xsZXJzL3Rtcy90bXNfZGFzaGJvYXJkX2lucHV0LnBocA==&modal=yes" myattribute="production_body" id="trims">Trims</a></li><li><a href="?r=L3NmY3NfYXBwL2FwcC9kYXNoYm9hcmRzL2NvbnRyb2xsZXJzL3Jtcy9mYWJfcHBzX2Rhc2hib2FyZF92Mi5waHA=&modal=yes" myattribute="production_body" id="fabric">Fabric</a></li></ul></div>

</div>

</div>
</div>

<div class="row">
<div class="col-lg-12" id="production_body">
</div>
</div>
<style>
.select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #d2d6de;
    border-radius: 0px;
}
.select2-container .select2-selection--single {
    height: 35px;
}
</style>

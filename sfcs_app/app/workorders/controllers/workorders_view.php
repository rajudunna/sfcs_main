
<script>

	$( document ).ready(function() {

		var style = "<?= $_GET["style"] ?>";
		var schedule = "<?= $_GET["schedule"] ?>";

		var loadurl = '/sfcs_app/app/workorders/controllers/lots_tab.php';
		var targ = '#tab_1';

		$.get(loadurl,{ style: style, schedule: schedule}, function(data) {
			$(targ).html(data);
			if(localStorage.getItem("style")===null) {
					localStorage.style = style;
			}

			if(localStorage.getItem("schedule")===null) {
					localStorage.schedule = schedule;
			}
		});
		$(this).tab('show')

		$('[data-toggle="tab"]:first').click();
	});

	// $('[data-toggle="model"]').click(function(e) {

	// 	e.preventDefault();

	// 	var style = "<?= $_GET["style"] ?>";
	// 	var schedule = "<?= $_GET["schedule"] ?>";

	// 	var loadurl = $(this).attr('href')
	// 	var targ = $(this).attr('data-target')
	// 	$.get(loadurl,{ style: style, schedule: schedule}, function(data) {
	// 		$(targ).html(data)
	// 	});
	// 	$(this).tab('show')
		
	// });

	$(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {

		e.preventDefault();

		var style = "<?= $_GET["style"] ?>";
		var schedule = "<?= $_GET["schedule"] ?>";

		var loadurl = $(this).attr('href')
		var targ = $(this).attr('data-target')
		$.get(loadurl,{ style: style, schedule: schedule}, function(data) {
			$(targ).html(data);
			if(localStorage.getItem("style")===null) {
					localStorage.style = style;
			}

			if(localStorage.getItem("schedule")===null) {
					localStorage.schedule = schedule;
			}
		});
		$(this).tab('show')

	});

</script>

<div class="row">
	<div class="col-md-9 col-sm-9 col-lg-9">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><a href="#" >#WO-001</a></h3>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-5">
						<b>Material Status</b>
						&nbsp;&nbsp;
						<div class="btn-group btn-breadcrumb">
				            <a href="" class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
				            <a href="" class="btn btn-default">Receive</a>
				            <a href="" class="btn btn-default">Inspect</a>
							<a href="" class="btn btn-default">Ready</a>
				        </div>
					</div>
					<div class="col-md-7">
						<b>Production Status</b>
						&nbsp;&nbsp;
						<div class="btn-group btn-breadcrumb">
				            <a href="" class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
				            <a href="" class="btn btn-default">LayPlan</a>
				            <a href="" class="btn btn-default">Next Activity</a>
							<a href="" class="btn btn-default">Then Activity</a>
				        </div>
					</div>
				</div>
				<br>

				<!-- Ajax Tab Section -->
				<div class="nav-tabs-custom">

					<ul class="nav nav-tabs" id="myTab">
						<li class="active tab"><a href="/sfcs_app/app/workorders/controllers/lots_tab.php" data-target='#tab_1' data-toggle="tab">LOTS</a></li>
						<li class="tab"><a href="/sfcs_app/app/workorders/controllers/wo_info_tab.php" data-target='#tab_2' data-toggle="tab">WO Info</a></li>
						<li class="tab"><a href="/sfcs_app/app/workorders/controllers/supplier_claim_tab.php" data-target='#tab_3' data-toggle="tab">Supplier Cliams</a></li>
						<li class="tab"><a href="/sfcs_app/app/workorders/controllers/dockets_tab.php" data-target='#tab_4' data-toggle="tab">Dockets</a></li>
						<li class="tab"><a href="/sfcs_app/app/workorders/controllers/jobs_tab.php" data-target='#tab_5' data-toggle="tab">Jobs</a></li>
						<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
					</ul>

		      <div class="tab-content">

						<div class="tab-pane active" id="tab_1"></div>
				
						<div class="tab-pane" id="tab_2"></div>
						
						<div class="tab-pane" id="tab_3"></div>

						<div class="tab-pane" id="tab_4"></div>
										
						<div class="tab-pane" id="tab_5"></div>

					</div>
		             
		  	</div>
		      
			</div>
		</div>
	</div>
	
	<?php
		$sidemenus = [
			'Workorders' => [
				'Add Excess Quantity(By color | By Schedule)',
				'Add Sample Quantity',
				'Clubbing(by color | by Schedule)',
				'Manage Layplan',
				
			],
			'Pre Production' => [
				'Manage Packing List [delete]',
				'Check-In Cartons',
				'Audit [delete]',
			],
			'Quality' => [
				'Reserve for dispatch',
				'Security Checkout',
				'Destroy',
			],
		];
	?>
	<div class="col-md-3 col-lg-3 col-sm-3">
		<div class="box box-info" >
            <div class="box-header with-border">
              <h3 class="box-title">Work Orders</h3>

              <div class="box-tools" id="ic">
                <button type="button" class="btn btn-box-tool" data-toggle="collapse"  data-target="#box1"><i class="fa fa-minus" id='icc'></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding accordion-body collapse in" id='box1'>
              <ul class="nav nav-pills nav-stacked">
				<li class="">
					<div class="col-md-12" id="divid_1" style="padding: 12px;">
						<img src="/images/stack-overflow.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
						<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;">Add Excess Quantity</p>
						<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;">
						( <a href="<?= '?r='.base64_encode('/sfcs_app/app/planning/controllers/orders_edit_form.php') ?>" name="Add Excess Quantity BY Color" onclick="modal('','',this.name)">By Color</a> | <a href="<?= '?r='.base64_encode('/sfcs_app/app/planning/controllers/orders_edit_form_schedule_wise.php') ?>" onclick="modal('','',this.name)" name="Add Excess Quantity BY Schedule">By Schedule</a> )
						</p>
					</div>
				</li>
				<li class="">
					<div class="col-md-12" id="divid_2" style="padding: 12px;">
						<img src="/images/sigma.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
						<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;"><a href="<?= '?r='.base64_encode('/sfcs_app/app/quality/controllers/ship_sample_input.php') ?>" name="Add Sample Quantity" onclick="modal('','',this.name)">Add Sample Quantity</a></p>
						<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;color: #888;">Where the sample qty is added here</p>
					</div>
				</li>
				<li class="">
					<div class="col-md-12" id="divid_3" style="padding: 12px;">
						<img src="/images/merge.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
						<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;">Clubbing</p>
						<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;">
						( <a href="<?= '?r='.base64_encode('/sfcs_app/app/cutting/controllers/color_clubbing/test.php') ?>"  name="Clubbing By Color" onclick="modal('','',this.name)">By Color</a> | <b>By Schedule</b> : <a href="<?= '?r='.base64_encode('/sfcs_app/app/cutting/controllers/schedule_club_style/mix_schedules.php') ?>" onclick="modal('','',this.name)" name="Schedule Mix">Mix</a> | <a href="<?= '?r='.base64_encode('/sfcs_app/app/cutting/controllers/schedule_club_style/mix_jobs.php') ?>" onclick="modal('','',this.name)" name="Schedule Mix Split">Mix Split</a> | <a href="<?= '?r='.base64_encode('/sfcs_app/app/cutting/controllers/schedule_club_style/mix_schedules_delete.php') ?>" onclick="modal('','',this.name)" name="Schedule Mix Delete">Mix Delete</a> | <a href="<?= '?r='.base64_encode('/sfcs_app/app/cutting/controllers/schedule_club_style/mix_jobs_delete.php') ?>" onclick="modal('','',this.name)" name="Schedule Mix Split Delete">Mix Split Delete</a> ) 
						</p>
					</div>
				</li>
				<li class="">
					<div class="col-md-12" id="divid_4" style="padding: 12px;">
						<img src="/images/rug.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
						<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;"><a href="<?= '?r='.base64_encode('/sfcs_app/app/cutting/controllers/lay_plan_preparation/test.php') ?>" onclick="modal('','',this.name)" name="Manage Layplan">Manage Layplan</a></p>
						<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;color: #888;">How the fabric is cutted into  ratios here</p>
					</div>
				</li>
				<li class="">
					<div class="col-md-12" id="divid_1" style="padding: 12px;">
						<img src="/images/scissors.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
						<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;">Cut Reporting</p>
						<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;">
						( <a href="<?= '?r='.base64_encode('/sfcs_app/app/cutting/controllers/cut_qty_reporting_withrolls/doc_track_panel.php') ?>" name="Cut Quantity Reporting With Roll" onclick="modal('','',this.name)">With Roll</a> | <a href="<?= '?r='.base64_encode('/sfcs_app/app/cutting/controllers/cut_qty_reporting_withoutrolls/doc_track_panel_cut.php') ?>" onclick="modal('','',this.name)" name="Cut Quantity Reporting Without Roll">Without Roll</a> )
						</p>
					</div>
				</li>
              </ul>
            </div>
        </div>
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Pre Production</h3>
              <div class="box-tools" id=ic1>
                <button type="button"  class="btn btn-box-tool"  data-toggle="collapse" data-target="#box2" ><i class="fa fa-minus" id="icc1"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding accordion-body collapse in" id='box2'>
                <ul class="nav nav-pills nav-stacked">
					<li class="">
						<div class="col-md-12" id="divid_5" style="padding: 12px;">
							<img src="/images/order.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
							<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;">Manage Packing List</p>
							<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;">
							( <a href="<?= '?r='.base64_encode('/sfcs_app/app/packing/controllers/pac_gen_sewing_job.php') ?>" name="Packing List Generation" onclick="modal('','',this.name)">Generation</a> | <a href="<?= '?r='.base64_encode('/sfcs_app/app/production/controllers/sewing_job/packing_ratio.php') ?>" name="Packing List Generation" onclick="modal('','',this.name)">Packing Ratio</a> | <a href="<?= '?r='.base64_encode('/sfcs_app/app/production/controllers/sewing_job/delete_sewing_jobs.php') ?>" onclick="modal('','',this.name)" name="Packing List Delete">Delete</a> | <a href="<?= '?r='.base64_encode('/sfcs_app/app/packing/controllers/partial_breakup.php') ?>" onclick="modal('','',this.name)" name="Split Lables">Split Lables</a> )
							</p>
						</div>
					</li>
					<li class="">
						<div class="col-md-12" id="divid_6" style="padding: 12px;">
							<img src="/images/check-in.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
							<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;"><a href="<?= '?r='.base64_encode('/sfcs_app/app/packing/controllers/packing_check_point_handover_select.php') ?>" onclick="modal('','',this.name)" name="Check-In Cartons">Check-In Cartons</a></p>
							<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;color: #888;">stored packing material will be deleted</p>
						</div>
					</li>
					<li class="">
						<div class="col-md-12" id="divid_7" style="padding: 12px;">
							<img src="/images/cart.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
							<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;"><a href="<?= '?r='.base64_encode('/sfcs_app/app/quality/controllers/pending.php') ?>" onclick="modal('','',this.name)" name="Audit [delete]">Audit [delete]</a></p>
							<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;color: #888;">How the fabric is cutted into  ratios here</p>
						</div>
					</li>
					<li class="">
						<div class="col-md-12" id="divid_7" style="padding: 12px;">
							<img src="/images/sewing-machine.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
							<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;">Sewing</p>
							<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;color: #888;">( <a href="<?= '?r='.base64_encode('/sfcs_app/app/production/controllers/sewing_job/sewing_job_create_original.php') ?>" onclick="modal('','',this.name)" name="Sewing Generation">Generation</a> | <a href="<?= '?r='.base64_encode('/sfcs_app/app/planning/controllers/input_job_level_planning/cut_jobs_loading.php') ?>" onclick="modal('','',this.name)" name="Input Job Level Planning">Input Job Level Planning</a> )</p>
						</div>
					</li>
          		</ul>
            </div>
        </div>
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Quality</h3>
              <div class="box-tools" id="ic2">
                <button type="button" class="btn btn-box-tool" data-toggle="collapse" data-target="#box3"><i class="fa fa-minus"  id="icc2"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding accordion-body collapse in" id='box3' >
              <ul class="nav nav-pills nav-stacked">
				<li class="">
					<div class="col-md-12" id="divid_8" style="padding: 12px;">
						<img src="/images/shipped.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
						<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;"><a href="<?= '?r='.base64_encode('/sfcs_app/app/packing/controllers/test.php') ?>" onclick="modal('','',this.name)" name="Reserve for dispatch">Reserve for dispatch</a></p>
						<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;color: #888;">stored packing material will be deleted</p>
					</div>
				</li>
				<li class="">
					<div class="col-md-12" id="divid_9" style="padding: 12px;">
						<img src="/images/check-out.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
						<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;"><a href="<?= '?r='.base64_encode('/sfcs_app/app/logistics/controllers/security_check.php') ?>" onclick="modal('','',this.name)" name="Security Checkout">Security Checkout</a></p>
						<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;color: #888;">stored packing material will be deleted</p>
					</div>
				</li>
				<li class="">
					<div class="col-md-12" id="divid_10" style="padding: 12px;">
						<img src="/images/employee.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
						<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;">Destroy</p>
						<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;">
						( <a href="<?= '?r='.base64_encode('/sfcs_app/app/surplus/controllers/location_map.php') ?>" name="Location Map" onclick="modal('','',this.name)">Location Map</a> | <a href="<?= '?r='.base64_encode('/sfcs_app/app/surplus/controllers/location_update.php') ?>" onclick="modal('','',this.name)" name="Update Location">Update Location</a> | <a href="<?= '?r='.base64_encode('/sfcs_app/app/surplus/controllers/reserve_for_destroy_panel.php') ?>" onclick="modal('','',this.name)" name="Reserve for Audit/Internal Destroy">Reserve for Audit/Internal Destroy</a> | <a href="<?= '?r='.base64_encode('/sfcs_app/app/surplus/controllers/confirm_destroy_internal.php') ?>" onclick="modal('','',this.name)" name="Confirm Destroy (Internal)">Confirm Destroy (Internal)</a> | <a href="<?= '?r='.base64_encode('/sfcs_app/app/surplus/controllers/confirm_destroy.php') ?>" onclick="modal('','',this.name)" name="Confirm Destroy (Offered)">Confirm Destroy (Offered)</a>)
						</p>
					</div>
				</li>
              </ul>
            </div>
        </div>
	</div>
</div>

<style type="text/css">
.box .nav-stacked>li>div {
    border-bottom: 1px solid #f4f4f4;
    margin: 0;
}

.active_div {
		border-left:solid;
		border-left-color: #00c0ef;
}

.btn-default{
	background-color: #fff;
}
.btn-breadcrumb .btn:not(:last-child):after {
  content: " ";
  display: block;
  width: 0;
  height: 0;
  border-top: 17px solid transparent;
  border-bottom: 17px solid transparent;
  border-left: 10px solid white;
  position: absolute;
  top: 50%;
  margin-top: -17px;
  left: 100%;
  z-index: 3;
}
.btn-breadcrumb .btn:not(:last-child):before {
  content: " ";
  display: block;
  width: 0;
  height: 0;
  border-top: 17px solid transparent;
  border-bottom: 17px solid transparent;
  border-left: 10px solid rgb(173, 173, 173);
  position: absolute;
  top: 50%;
  margin-top: -17px;
  margin-left: 1px;
  left: 100%;
  z-index: 3;
}
.btn-breadcrumb .btn {
  padding:6px 12px 6px 24px;
}
.btn-breadcrumb .btn:first-child {
  padding:6px 6px 6px 10px;
}
.btn-breadcrumb .btn:last-child {
  padding:6px 18px 6px 24px;
}
.btn-breadcrumb .btn.btn-default:not(:last-child):after {
  border-left: 10px solid #fff;
}
.btn-breadcrumb .btn.btn-default:not(:last-child):before {
  border-left: 10px solid #ccc;
}
.btn-breadcrumb .btn.btn-default:hover:not(:last-child):after {
  border-left: 10px solid #ebebeb;
}
.btn-breadcrumb .btn.btn-default:hover:not(:last-child):before {
  border-left: 10px solid #adadad;
} 
</style>
<script>
	$(document).ready(function () { 
			$('#ic').click(function () {
					$('#icc').toggleClass('fa-minus fa-plus');
			});
			$('#ic1').click(function () {
					$('#icc1').toggleClass('fa-minus fa-plus');
			});
			$('#ic2').click(function () {
					$('#icc2').toggleClass('fa-minus fa-plus');
			});
	});
</script>

<script>
// $('a').click(function(){

  // var pid = 'parentNode';
  // var div_id = this.parentNode.id;
  // if(div_id!=''){
	  // $(".col-md-12").removeClass('active_div');
	  // $("#"+div_id).addClass("active_div");
  // }else{
	  // var div_id_child = this.parentNode.parentNode.id;
	  // if(div_id_child!=''){
		  // $(".col-md-12").removeClass('active_div');
		  // $("#"+div_id_child).addClass("active_div");
	  // }
  // }
	
// });
$('a').click(function(){
	var $main = $(this).closest('.col-md-12');
	$(".col-md-12").removeClass('active_div');
	$("#"+$main.attr('id')).addClass("active_div");
});
</script>








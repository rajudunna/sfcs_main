<div class="row">
	<div class="col-md-9 col-sm-9 col-lg-9">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">#WO-001</h3>
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
				<div class="nav-tabs-custom">
		            <ul class="nav nav-tabs">
		              <li class="active"><a href="#tab_1" data-toggle="tab">LOTS</a></li>
		              <li><a href="#tab_2" data-toggle="tab">WO Info</a></li>
		              <li><a href="#tab_3" data-toggle="tab">Supplier Cliams</a></li>
		              <li><a href="#tab_3" data-toggle="tab">Dockets</a></li>
		              <li><a href="#tab_3" data-toggle="tab">Jobs</a></li>
		              <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
		            </ul>
		            <div class="tab-content">
		              <div class="tab-pane active" id="tab_1">
		                <b>How to use:</b>

		                <p>Exactly like the original bootstrap tabs except you should use
		                  the custom wrapper <code>.nav-tabs-custom</code> to achieve this style.</p>
		                A wonderful serenity has taken possession of my entire soul,
		                like these sweet mornings of spring which I enjoy with my whole heart.
		                I am alone, and feel the charm of existence in this spot,
		                which was created for the bliss of souls like mine. I am so happy,
		                my dear friend, so absorbed in the exquisite sense of mere tranquil existence,
		                that I neglect my talents. I should be incapable of drawing a single stroke
		                at the present moment; and yet I feel that I never was a greater artist than now.
		              </div>
		              <!-- /.tab-pane -->
		              <div class="tab-pane" id="tab_2">
		                The European languages are members of the same family. Their separate existence is a myth.
		                For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
		                in their grammar, their pronunciation and their most common words. Everyone realizes why a
		                new common language would be desirable: one could refuse to pay expensive translators. To
		                achieve this, it would be necessary to have uniform grammar, pronunciation and more common
		                words. If several languages coalesce, the grammar of the resulting language is more simple
		                and regular than that of the individual languages.
		              </div>
		              <!-- /.tab-pane -->
		              <div class="tab-pane" id="tab_3">
		                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
		                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
		                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
		                It has survived not only five centuries, but also the leap into electronic typesetting,
		                remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
		                sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
		                like Aldus PageMaker including versions of Lorem Ipsum.
		              </div>
		              <!-- /.tab-pane -->
		            </div>
		        <!-- /.tab-content -->
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
		<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Work Orders</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
				<li class="">
					<div clas="col-md-6" style="padding: 12px;">
						<img src="/images/stack-overflow.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
						<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;">Add Excess Quantity</p>
						<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;">
						( <a href="#" onclick="modal('','',this.name)" name="Add Excess Quantity BY Color">By Color</a> | <a href="#" onclick="modal('','',this.name)" name="Add Excess Quantity BY Schedule">By Schedule</a> )
						</p>
					</div>
				</li>
				<li class="">
					<div clas="col-md-6" style="padding: 12px;">
						<img src="/images/sigma.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
						<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;"><a href="#" onclick="modal('','',this.name)" name="Add Sample Quantity">Add Sample Quantity</a></p>
						<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;color: #888;">Where the sample qty is added here</p>
					</div>
				</li>
				<li class="">
					<div clas="col-md-6" style="padding: 12px;">
						<img src="/images/merge.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
						<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;">Clubbing</p>
						<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;">
						( <a href="#" onclick="modal('','',this.name)" name="Clubbing By Color">By Color</a> | <a href="#" onclick="modal('','',this.name)" name="Clubbing By Schedule">By Schedule</a> )
						</p>
					</div>
				</li>
				<li class="">
					<div clas="col-md-6" style="padding: 12px;">
						<img src="/images/rug.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
						<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;"><a href="#" onclick="modal('','',this.name)" name="Manage Layplan<">Manage Layplan</a></p>
						<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;color: #888;">How the fabric is cutted into  ratios here</p>
					</div>
				</li>
              </ul>
            </div>
        </div>
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Pre Production</h3>
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
				<li class="">
					<div clas="col-md-6" style="padding: 12px;">
						<img src="/images/order.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
						<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;"><a href="#" onclick="modal('','',this.name)" name="Manage Packing List [delete]">Manage Packing List [delete]</a></p>
						<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;color: #888;">stored packing material will be deleted</p>
					</div>
				</li>
				<li class="">
					<div clas="col-md-6" style="padding: 12px;">
						<img src="/images/check-in.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
						<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;"><a href="#" onclick="modal('','',this.name)" name="Check-In Cartons">Check-In Cartons</a></p>
						<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;color: #888;">stored packing material will be deleted</p>
					</div>
				</li>
				<li class="">
					<div clas="col-md-6" style="padding: 12px;">
						<img src="/images/cart.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
						<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;"><a href="#" onclick="modal('','',this.name)" name="Audit [delete]">Audit [delete]</a></p>
						<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;color: #888;">How the fabric is cutted into  ratios here</p>
					</div>
				</li>
              </ul>
            </div>
        </div>
              <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Quality</h3>
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
				<li class="">
					<div clas="col-md-6" style="padding: 12px;">
						<img src="/images/shipped.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
						<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;"><a href="#" onclick="modal('','',this.name)" name="Reserve for dispatch">Reserve for dispatch</a></p>
						<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;color: #888;">stored packing material will be deleted</p>
					</div>
				</li>
				<li class="">
					<div clas="col-md-6" style="padding: 12px;">
						<img src="/images/check-out.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
						<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;"><a href="#" onclick="modal('','',this.name)" name="Security Checkout">Security Checkout</a></p>
						<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;color: #888;">stored packing material will be deleted</p>
					</div>
				</li>
				<li class="">
					<div clas="col-md-6" style="padding: 12px;">
						<img src="/images/employee.png" style="float: left;border: 1px solid;border-radius: 35px;width: 45px;opacity: 0.7;">
						<p style="padding-left: 58px;font-size: 16px;margin: 0 0 0px;"><a href="#" onclick="modal('','',this.name)" name="Destroy">Destroy</a></p>
						<p style="padding-left: 58px;margin: 0 0 0px;font-size: 13px;color: #888;">How the fabric is cutted into  ratios here</p>
					</div>
				</li>
              </ul>
            </div>
        </div>
	</div>
</div>
<style type="text/css">

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
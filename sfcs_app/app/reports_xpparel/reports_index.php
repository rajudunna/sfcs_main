<style>
h5{
    font-size:15px !important;
}
</style>
<div class="container-fluid">
    <div class = "row">
        <div class = "col-md-9" id = 'report_body'>
        </div>
        <div class="col-md-3 pull-right">
            <div class="box box-info ">
                <div class="box-header with-border">  
                    <h5 class="box-title">Inspection</h5>

                    <div class="box-tools" id = 'insp_b'>
                        <button type="button" class="btn btn-box-tool" data-toggle="collapse"  data-target="#incpection_col"><i class="fa fa-plus" id = 'insp'></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding accordion-body collapse out" id='incpection_col'>
                    <ul class="nav nav-pills nav-stacked">
                      <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/inspection/reports/C_Tex_Index_view.php').'&type=inspection'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Inspection Report</a></li>
                      <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/inspection/reports/Supplier_Claim_Log_Form.php').'&type=inspection'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Supplier Claim Log</a></li>
                      <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/inspection/reports/supplier_perf_v2_report.php').'&type=inspection'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Supplier Performance Report</a></li>
                    </ul>
                </div>
            </div>
            <div class="box box-info ">
                <div class="box-header with-border">  
                    <h5 class="box-title">Cutting</h5>

                    <div class="box-tools" id = 'cut_b'>
                      <button type="button" class="btn btn-box-tool" data-toggle="collapse"  data-target="#cutting_col"><i class="fa fa-plus" id = 'cut'></i>
                      </button>
                    </div>
                </div>
                <div class="box-body no-padding accordion-body collapse out" id='cutting_col'>
                      <ul class="nav nav-pills nav-stacked">
                        <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/cutting/reports/cad_saving_details_style.php').'&type=cutting'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;CAD Saving Report - Style</a></li>
                        <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/cutting/reports/cad_saving_details_V2.php').'&type=cutting'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;CAD Saving Details - Exfactory</a></li>
                        <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/cutting/reports/cad_saving_details_V3.php').'&type=cutting'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;CAD Saving Details - Schedule</a></li>
                        <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/cutting/reports/cr_view.php').'&type=cutting'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Consumption Report</a></li>
                        <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/cutting/reports/csr_view_V2.php').'&type=cutting'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Cutting Status Report</a></li>
                        <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/cutting/reports/isr_view_v1.php').'&type=cutting'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Input Status Report</a></li>
                        <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/cutting/reports/recut_details.php').'&type=cutting'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Recut Details report</a></li>
                        <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/cutting/reports/ssrcd_view.php').'&type=cutting'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Style Status Report - Cut Details</a></li>
                        <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/cutting/reports/ssrfd_view.php').'&type=cutting'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Style Status Report - Fabric Details</a></li>
                        <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/cutting/reports/rms_pending.php').'&type=cutting'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;RMS Requisition Report</a></li>
                      </ul>
                </div>
            </div>
            <div class="box box-info ">
              <div class="box-header with-border">  
                  <h5 class="box-title">Planning</h5>

                  <div class="box-tools" id = 'plan_b'>
                      <button type="button" class="btn btn-box-tool" data-toggle="collapse"  data-target="#planning_col"><i class="fa fa-plus" id = 'plan'></i>
                      </button>
                  </div>
              </div>
              <div class="box-body no-padding accordion-body collapse out" id='planning_col'>
                  <ul class="nav nav-pills nav-stacked">
                      <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/planning/reports/week_delivery_plan_view3_V2.php').'&type=planning';?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Weekly Delivery Report</a></li>
                      <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/planning/reports/week_delivery_plan_view4.php').'&type=planning'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Delivery Failure Report</a></li>
                      <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/planning/reports/orders_summary_report.php').'&type=planning'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Orders Summary Report</a></li>
                  </ul>
              </div>
            </div>
            <div class="box box-info ">
                <div class="box-header with-border">  
                      <h5 class="box-title">Sewing</h5>

                      <div class="box-tools" id = 'sew_b'>
                        <button type="button" class="btn btn-box-tool" data-toggle="collapse"  data-target="#sewing_col"><i class="fa fa-plus" id = 'sew'></i>
                        </button>
                      </div>
                </div>
                <div class="box-body no-padding accordion-body collapse out" id='sewing_col'>
                    <ul class="nav nav-pills nav-stacked">
                      <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/production/reports/daily_sah_report_V5.php').'&type=sewing'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Daily SAH Report</a></li>
                      <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/production/reports/Hourly_Eff_test.php').'&type=sewing'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Hourly Efficiency</a></li>
                      <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/planning/reports/transaction_log_new.php').'&type=sewing'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Production Status Report (Sewing Out)</a></li>
                      <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/production/reports/job_summary_view.php').'&type=sewing'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Schedule wise Job Reconciliation Reports</a></li>
                    </ul>
                </div>
            </div>
            <div class="box box-info ">
                <div class="box-header with-border">  
                    <h5 class="box-title">Quality</h5>

                    <div class="box-tools" id = 'qual_b'>
                      <button type="button" class="btn btn-box-tool" data-toggle="collapse"  data-target="#quality_col"><i class="fa fa-plus" id = 'qual'></i>
                      </button>
                    </div>
                </div>
                <div class="box-body no-padding accordion-body collapse out" id='quality_col'>
                    <ul class="nav nav-pills nav-stacked">
                      <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/quality/reports/critical_rejection_report.htm').'&type=quality'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Critical Rejection Report - Above 0.4%</a></li>
                      <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/quality/reports/rep1.php').'&type=quality'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Daily Rejection Analysis</a></li>
                      <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/quality/reports/rep22.php').'&type=quality'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Daily Rejection Detail Report - Module Level</a></li>
                      <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/quality/reports/fca_fails.php').'&type=quality'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;FCA Failed Log Status</a></li>
                      <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/quality/reports/day_summary_report.php').'&type=quality'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Quality Journal</a></li>
                      <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/quality/reports/rep12.php').'&type=quality'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Surplus Stock Report</a></li>
                    </ul>
                </div>
            </div>
            <div class="box box-info ">
                <div class="box-header with-border">  
                    <h5 class="box-title">Supply Chain</h5>

                    <div class="box-tools" id = 'sup_chain_b'>
                        <button type="button" class="btn btn-box-tool" data-toggle="collapse"  data-target="#supply_chain_col"><i class="fa fa-plus" id = 'sup_chain'></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding accordion-body collapse out" id='supply_chain_col'>
                    <ul class="nav nav-pills nav-stacked">
                    <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/warehouse/reports/mrn_form_log.php').'&type=supplychain'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;(AMT) MRN Transaction Log</a></li>
                    <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/warehouse/reports/report_new.html').'&type=supplychain'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;RM Stock Report</a></li>
                    <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/warehouse/reports/fab_iss_track_details_V4.php').'&type=supplychain'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Fabric Issued Track</a></li>
                    </ul>
                </div>
            </div>
            <div class="box box-info ">
                <div class="box-header with-border">  
                    <h5 class="box-title">KPI</h5>
                    <div class="box-tools" id = 'kpi_b'>
                        <button type="button" class="btn btn-box-tool" data-toggle="collapse"  data-target="#kpi_col"><i class="fa fa-plus" id = 'kpi'></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding accordion-body collapse out" id='kpi_col'>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/production/reports/kpi/lost_time_capture.php').'&type=kpi'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Lost Hour Capturing Report</a></li>
                        <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/production/reports/kpi/lost_time_summary.php').'&type=kpi'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Lost Hour Summary Report</a></li>
                    </ul>
                </div>
            </div>
            <div class="box box-info ">
                <div class="box-header with-border">  
                    <h5 class="box-title">Financial Reconciliation Reports</h5>
                    <div class="box-tools" id = 'frr_b'>
                        <button type="button" class="btn btn-box-tool" data-toggle="collapse"  data-target="#fin_col"><i class="fa fa-plus" id = 'frr'></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding accordion-body collapse out" id='fin_col'>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/production/reports/wip_reports/cutting_wip.php').'&type=financial'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Cutting WIP</a></li>
                        <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/production/reports/wip_reports/emb_garment_wip.php').'&type=financial'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Embellishment Garment WIP</a></li>
                        <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/production/reports/wip_reports/emb_panel_wip.php').'&type=financial'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Embellishment Panel WIP</a></li>
                        <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/production/reports/wip_reports/fabric_wip.php').'&type=financial'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Fabric WIP</a></li>
                        <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/production/reports/wip_reports/fg_wip.php').'&type=financial'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;FG WIP</a></li>
                        <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/production/reports/wip_reports/packing_wip_report.php').'&type=financial'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Packing WIP</a></li>
                        <li><a href="<?= '?r='.base64_encode('/sfcs_app/app/production/reports/wip_reports/sewing_wip.php').'&type=financial'; ?>" myattribute='report_body'><i class="fa fa-circle-o"></i>&nbsp;Sewing WIP</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function ()
  {
      $('#cut_b').click(function()
      {
          $('#cut').toggleClass('fa-minus fa-plus');
      });

      $('#insp_b').click(function()
      {
          $('#insp').toggleClass('fa-minus fa-plus');
      });

      $('#plan_b').click(function()
      {
          $('#plan').toggleClass('fa-minus fa-plus');
      });

      $('#sew_b').click(function()
      {
          $('#sew').toggleClass('fa-minus fa-plus');
      });

      $('#qual_b').click(function()
      {
          $('#qual').toggleClass('fa-minus fa-plus');
      });

      $('#sup_chain_b').click(function()
      {
          $('#sup_chain').toggleClass('fa-minus fa-plus');
      });

      $('#kpi_b').click(function()
      {
          $('#kpi').toggleClass('fa-minus fa-plus');
      });

      $('#frr_b').click(function()
      {
          $('#frr').toggleClass('fa-minus fa-plus');
      });
  });
</script>
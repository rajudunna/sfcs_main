
  <!-- /.box-header -->

  <div class="box-header"><div class="col-md-12"><h4><b>Workorders List</b><a href="" class="btn btn-info btn-sm" style="float: right;border-radius: 16px;"><img src="/images/controls.png" ></a><input type="text" name="search" class="form-control" placeholder="Search" style="width:200px;float:right;border-radius: 16px;margin-right: 15px;"></h4></div></div>
  <div class="box-body">
    <?php for($i=0; $i<30; $i++){ ?>
      <a href="?r=<?= base64_encode('/sfcs_app/app/workorders/controllers/workorders_view.php');?>" myattribute="body">
        <div class="col-lg-2 col-md-2 col-sm-2">
          <div class="box box-solid">
            <div class="box-body">
              <div class="col-md-3">
                <span><b>#00<?= $i+1; ?></b></span><br>
                STYLE00<?= $i+1; ?>/SCH00<?= $i+1; ?>
              </div>
            </div>
          </div>
        </div>
      </a>
    <?php } ?>
    <div class="col-md-12">
      <ul class="pagination pull-right">
        <li class="disabled"><a href="#">&laquo;</a></li>
        <li class="active"><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        <li><a href="#">&raquo;</a></li>
      </ul>
    </div>
  </div>



<style type="text/css">
  .box:hover {
    box-shadow: 0 0 11px rgba(33,33,33,.2); 
  }
</style>

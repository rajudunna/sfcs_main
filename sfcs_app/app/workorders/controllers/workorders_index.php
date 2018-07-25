<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Workorders List</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table class="table table-bordered">
      <tr>
        <th style="width: 10px">#</th>
        <th>Workorder NO</th>
        <th>Style</th>
        <th style="width: 40px">Schedule</th>
        <th style="width: 40px">Color</th>
        <th style="width: 40px">Status</th>
        <th style="width: 40px">Action</th>
      </tr>
      <?php for($i=0; $i < 8; $i++){?>
        <tr>
          <td><?= $i+1;?></td>
          <td>1012</td>
          <td>FRONT</td>
          <td>26526</td>
          <td>BLACK</td>
          <td>PREPARED</td>
          <td><a href="?r=L3NmY3NfYXBwL2FwcC93b3Jrb3JkZXJzL2NvbnRyb2xsZXJzL3dvcmtvcmRlcnNfdmlldy5waHA=" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a></td>
        </tr>
      <?php } ?>
    </table>
  </div>
  <!-- /.box-body -->
  <div class="box-footer clearfix">
    <ul class="pagination pagination-sm no-margin pull-right">
      <li><a href="#">&laquo;</a></li>
      <li><a href="#">1</a></li>
      <li><a href="#">2</a></li>
      <li><a href="#">3</a></li>
      <li><a href="#">&raquo;</a></li>
    </ul>
  </div>
</div>
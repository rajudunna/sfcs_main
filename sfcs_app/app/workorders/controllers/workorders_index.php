
  <!-- /.box-header -->
  <?php   
     include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
  ?>

  <?php
  session_start();
  $start = 0;
  $offset = 24;
  unset($_SESSION['filter']);
  if(isset($_GET['limit'])){
    $offset = $_SESSION['limit'] = $_GET['limit'] > 0 ? $_GET['limit']  : $offset;
  }

  if(isset($_GET['paginate'])){
    $page = $_GET['page'] - 1;
    $start =  $page * $offset;
  }
  
  $filter ='';
  if(isset($_GET['filter'])){
    $filter = $_SESSION['filter'] = trim($_GET['filter']);
  }
  $from = $start;
  $details_query = "select * from bai_pro3.bai_orders_db WHERE order_del_no LIKE '%$filter%' OR
                    order_style_no like '%$filter%' LIMIT $offset OFFSET $start";
  $total_rows_q = "select count(*) as count from  bai_pro3.bai_orders_db WHERE order_del_no LIKE '%$filter%' OR 
                    order_style_no like '%$filter%'";
  //echo $details_query;
  $details_result = mysqli_query($link,$details_query); 
  $total_rows = mysqli_query($link,$total_rows_q);
  while($row = mysqli_fetch_array($total_rows)){
    $total = $row['count']; 
  }
  
  ?>
  <div class="box-header">
    <div class="col-md-12">
      <h4><b>Workorders List</b>
       
      </h4>
    </div>
  </div>
  <div class="box-body">
    
    <div class='col-sm-12'>
      <label for='limit' class='pull-left' style='padding-top:3px'>Show Records :</label>
      <div class='col-sm-2'>
        <select name='limit' id='limit' onchange='loadData(this)' class='form-control input-sm' style='border-radius : 5px'>
          <option value='24'>Choose Records Count Here</option>
          <option value='50'  <?= $_GET['limit']==50 ? 'selected' : '' ?> >50</option>
          <option value='100' <?= $_GET['limit']==100 ? 'selected' : '' ?>>100</option>
          <option value='200' <?= $_GET['limit']==200 ? 'selected' : '' ?>>200</option>
        </select>
      </div>
      <a href="" class="btn btn-info btn-sm" style="float: right;border-radius: 16px;">
          <img src="/images/controls.png" >
      </a>
      <input type="text" id='search' name="search" onkeypress='filter(this,event)' class="form-control" placeholder="Search Style (or) Schedule" 
             style="width:200px;float:right;border-radius: 16px;margin-right: 15px;"
             value="<?= isset($_GET['filter']) ? $_GET['filter'] : ''; ?> ">
    </div><br/><br/><br/>
    
    <?php 
      $action = base64_encode("/sfcs_app/app/workorders/controllers/workorders_view.php");
      while($row = mysqli_fetch_array($details_result)){
        $row_count++;
    ?>
        <a href='?r=<?= $action."&style=".$row['order_style_no']."&schedule=".$row['order_del_no']; ?>' myattribute="body">
          <div class="col-lg-2 col-md-2 col-sm-2">
            <div class="box box-solid">
              <div class="box-body">
                <div class="col-md-3">
                  <span><b>#00<?= $start++ + 1; ?></b></span><br>
                  <span style='color:#0088dd'><?= $row['order_style_no']; ?></span>
                  <span style='color:#0088dd'><?= $row['order_del_no']; ?></span>
                  <span><?php ?></span>
                </div>
              </div>
            </div>
          </div>
        </a>
    <?php } 
    if($row_count == 0){
      ?>
      <div class='col-sm-12'>
        <div class='col-sm-offset-4 col-sm-3'>
          <div class='box'><div class='box-body'><center><span style='color:#fe0012'>No Data Found</span></center></div></div>
        </div><br/><br/>
      </div>
      <div class='col-sm-12'>
        <div class='col-sm-offset-4 col-sm-3'>
          <center>
            <a class='btn btn-info btn-sm' href='?r="<?= $_GET['r'] ?>&pagination=1&page=1&filter=' myattribute='body'>
            << Back</a>
          </center>
        </div>
      </div>
      
    <?php
      } ?>
    <div class='col-sm-12'>
      <div class='col-sm-4'>
        <b><?php echo "Showing <span class='blue'>".($from)."</span> to <span class='blue'>".($start)."</span> 
                       of $total Records"; ?></b>
      </div>
      <div class="col-md-8">
      <?php
          //paginate(0,total_records,rows per page,max-page icons,pagination url)
          echo paginate(0,$total,$offset,8,$_GET['r']);
      ?>
      </div>
    </div>
  </div>


  <?php

    function paginate($start,$end,$size,$size_length,$url){
        $url = $_GET['r'];
        $pages = ceil(($end-$start)/$size);
        if($page = $_GET['page']){
          $highlight = $page;
          $page = $page == 0 ? 1 : $page-3; 
        }else{
          $page = 1;
        }
        //stopping -ve pages
        if($page >= $pages-8){
          $page = $pages-$size_length+1;
        }
        if($page > $pages || $page <= 0 || $page == 2){
          $page = 1;
        }

        //limiting pages to available size
        if($pages < $size_length)
          $size_length = $pages;

        //printing pages 
        $html = "<ul class='pagination pull-right'>
                  <li><a href='?r=".$url."&paginate=1&limit=".$_SESSION['limit']."&page=".($page)."
                        &filter=".$_SESSION['filter']."' myattribute='body'>
                      &laquo;</a></li>"; 
        for($i=1;$i<=$size_length;$i++){
          $html.= "<li><a id='page$page' href='?r=".$url."&paginate=1&limit=".$_SESSION['limit']."$limit&page=".$page."
                        &filter=".$_SESSION['filter']."' myattribute='body'>$page</a></li>";
          $start += $size;
          $page++;
        }
        $html .= "<li><a href='?r=".$url."&paginate=1&limit=".$_SESSION['limit']."&page=".($page-1)."
                              &filter=".$_SESSION['filter']."' myattribute='body'>
                    &raquo;</a></li>";
        $html .= "</ul>";

        echo "<script>
                $(document).ready(function(){
                  $('#page$highlight').css({'background':'#2088ff'});
                });            
              </script>"; 
              
        if($pages > 0)
          return $html;
        else
          return '';  
    }
  ?>

<style type="text/css">
    .box:hover {
      box-shadow: 0 0 11px rgba(33,33,33,.2); 
    }
    .blue{
      color : #1252ff;
    }
</style>


<script>  

  $(document).ready(function(){
     $('#search').val(null);
  });
  
  function filter(t,e){
    if(e.keyCode == 13){
      var filter_code = t.value;
      var limit = document.getElementById('limit').value;
      var ajax_url ="<?= 'index.php?r='.$_GET['r']; ?>&limit="+limit+"&filter="+filter_code;
      //console.log(ajax_url);
      Ajaxify(ajax_url,'body');
    }
  }

  function loadData(t){
    var limit = t.value;
    var filter = document.getElementById('search').value;
    //console.log(limit);
    var ajax_url ="<?= 'index.php?r='.$_GET['r']; ?>&limit="+limit+"&filter="+filter;;
    Ajaxify(ajax_url,'body');
  }
</script>







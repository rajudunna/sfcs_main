<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<?php
include('../helper.php');
?>
<h2> User Access Form </h2>
<?php
  if(isset($_GET['st'])){
      if($_GET['st'] == 'approve'){
        echo "<div class='alert alert-success'>You have access..</div>";
      }else{
        echo "<div class='alert alert-danger'>Access Restrected..</div>";
      }
  }
?>
<form  method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="form-group">
      <label for="email">Enter R Value:</label>
      <input type="textarea" class="form-control" id="url" placeholder="Enter R Value" name="url">
    </div>
    
    <button type="submit" class="btn btn-warning">Submit</button>
  </form>
<div class='col-sm-12'>
<?php if (isset($_GET["url"]))  { 
  echo "<div class='col-sm-6'>";
    echo "<h3>All Permissions List:</h3>";
    $perm = haspermission($_GET["url"]);
    echo "<ul>";
    foreach($perm as $v){
        echo "<li>".$v."</li>";
    }
    echo "</ul>";
  echo "</div>";
  echo "<div class='col-sm-6'>";
  $url_view = in_array('1',$perm) ? 'test.php?st=approve' : 'test.php?st=reject';
  $url_update = in_array('2',$perm) ? 'test.php?st=approve' : 'test.php?st=reject';
  $url_del = in_array('3',$perm) ? 'test.php?st=approve' : 'test.php?st=reject';
  $url_app = in_array('5',$perm) ? 'test.php?st=approve' : 'test.php?st=reject';
  echo "<a class='btn btn-primary col-sm-2' href=".$url_view.">View</a><b class='col-sm-1'></b>
  <a class='btn btn-info col-sm-2' href=".$url_update.">Update</a> <b class='col-sm-1'></b>
  <a class='btn btn-danger col-sm-2' href=".$url_del.">Deleate</a> <b class='col-sm-1'></b>
  <a class='btn btn-warning col-sm-2' href=".$url_app.">Approve</a> ";
  echo "</div>";
 }
?>
</div>


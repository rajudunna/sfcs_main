<?php
session_start();
?>
<!DOCTYPE html>
<html ng-app="configManager">

<head>
    <link rel="stylesheet" type="text/css" href="assets/css/app.css">
    <link rel="stylesheet" type="text/css" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.1/jquery.rateyo.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <title>Configuration Builder</title>
    <?php
        if(isset($_SESSION['dbstatus'])){
            echo '<script> dbstatus = "'.$_SESSION['dbstatus'].'" </script>';
            unset($_SESSION['dbstatus']);
        }

        if($_GET["instanceURL"]){
            $url = $_GET["instanceURL"];
            if(filter_var($url, FILTER_VALIDATE_URL)){
                echo '<script> var instanceURL = "'.$url.'" </script>';
            }else{
                header('Location: index.php');
            }
        }else{
            header('Location: index.php');
        }
    ?>
</head>
<body>
    <div class="content">
        <h1>Application Confr</h1>

        <h5>Fields Configuration Information</h5>
        <form action="" id="form-builder-steps">
            <ul id="tabs">
            <li><a href="#step-1">step 1</a></li>
            <li id="add-step-tab"><a href="#new-step">+ step</a></li>
            </ul>
            <div id="step-1" class="fb-editor"></div>
            <div id="new-step"></div>
        </form>
        <div class="save-all-wrap">
            <button id="save-all" type="button" class="btn btn-primary">Save <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAEu0lEQVRYR8WXe0xbVRzHv+ecWwoUqMNtkM3FmTEek23IiM7HwCyLGokozBEmmuJilsAUYYkZ8R+r/2CMuoFI1GWbDmbigxnMYnRmMdMlZpEJSHltiaPqeE1es+XR3nuOuR2F3va25bFk97+ec36/7+f3OI8S3OaP3GZ9LB5AgGxtr1wDmSSD8BWeAAQdo1Tqbc18p3+xAS0YIP1SRRrl2A+OfDByt56QAvRRiNMAO9qR9V7PQmDCAmxtq1yrKPxdKmjRQhx61nAIQsnnEvhrl7KODISyCwmQ0VKRywVpAMHNVC/+GyGEF7dvq/khmGlQgC0tlRZwfhyU0sXrzltwQCFEWDq2HTml50cXwBM5F98uV9wrqEIw4Mn2rMNn/SECADw1n+GdlFHzciL3txWCjwoFm2zba4Z85wIANrdUfkGAwlspPp8JctKW9b4lKIBnqwnStVzxBMmMIXki0A0Xghp4Stt9tVe8k5oMpF+sqKeMlC4H4MX4ndh9x3ZUDTTCNvVXgCui8MPtD9QcDAQQIJt/K/+XUBa/VABV/IX4bI/5lHCh6topdEzbNe4Uzoc7769JCABQm0/I+OdWiHt9DMoTsNhr4RaKxi2j8urWzA+uq4NzJUi/WJFLGTmzFADfyL32E24nKmz1sMc4AKLtdeZSdrU+VHtOA3DvLwcOsaiIt/UA0qPWQQigc/rvgOlg4uWtdeiTxsDiIgNs+JS7wrajrkYLcL6smpmMVf6rt0SuR/Xa5zwAh/obNBB64uNuJ15trcNVwxik2EBx1T93zrxpy6m3aktwrsxKzcY3fAEyotajek0xjMTgGZ7krjmIUOJ9hnGwWGPQasrjk6937fq4WgOw6exLz0vxsQ2+VnvMD6J01eMaRyrEz84uPBGboRn3Rh4s7b6LXf2OZ3vyjjZpAJK/Lkk13mXuJtL83SOPTqIofgfKkp4K2ZuqePnvdbAb9Gvuayxkjplr/224vPv4nxqAR3+yStfFkJPFRUbMGQgB17ADexNycCApTxdiMeKqA/f41FT3hcQYWK1cA6D+2Pjdvu+jVpu1OZ+FKErIxstJT2vT7nKgvPVD2CNC13w+IGBm+EZzb+6xZ7xjmg26scmSa1wZc4aa5pPgWaiTifE58TGwIN3unzLucEEZdT7WXfDpj7oAsFppWqbdZkg0p4H6XZSzEMWJOdi7bufiIldjUDhmBm+0Xc47kQkCoQ+glqHJki1FG85Lq2IDn8yzEHHcCGeMCLnV/KN3DzqEcM083FNw8lffOd0XUerpkmpiiqiS7jTpQvBpN2iUX5lC7BN5xAnudL/VU3BCc84ENOGcjy/3sFTJ1EgiDUXSShOIfzlCbsr5STXt8sgk+LSrsfePeyzezg+bAXWBui0HRq/WgtFSw4po0OgIn6srDIFQj1sX5IkpCEXU9sqOgyj8SnslzroI+78g5RtLoZBRSyNZAjMZQaMNIBLTJVAPGWXSBU+3y8oAI+KVnvzPPCdesC8sgGqY0rwvFlwphUL2g2IDYeQmhLc0XEC4FQguwMGvMLBPmBz1UWdhvSNctRYE4HOQkNTmknQhyCOASCaCeF5PgohRCPRSsAvd+cc6fbfZrQUI520J8/8D09nzMMwzuZQAAAAASUVORK5CYII=" alt="save"></button>
        </div>

        <div class="row"> <hr/> </div>
        <h5>Database Configuration information</h5>
        <div class="panel panel-default" ng-controller="dbController">
            <div class="panel-body">
                <form action="<?= $url ?>/savedatabase.php" method="post" enctype="multipart/form-data" >
                    <table class="table">
                        <tr> 
                            <th>SQL Type</th>
                            <th>SQL File</th>
                            <th>Database Title</th>
                            <th>Description</th>
                            <th> <a href="javascript:void(0)" ng-click="add()" ><img src="assets/images/add.png" alt="Add"></a> </th>
                        </tr>
                        <tr ng-repeat="database in databases">
                            <td>
                                <select class="form-control" ng-model="database.sql_type" name="sql_type[]">
                                    <option value="mysql">MySQL</option>
                                    <option value="mssql">MS SQL</option>
                                </select> 
                            </td>
                            <td> <input ng-model="database.sql_file" name = "sql_file[]" type="file" accept=".sql" placeholder="Give SQL file" /> </td>
                            <td> <input class="form-control" ng-change="removeSpace($index)" ng-model="database.sql_title" name = "sql_title[]" type="text" placeholder="Title" /> </td>
                            <td> <input class="form-control" ng-model="database.sql_description" name = "sql_description[]" type="text" placeholder="Description" /> </td>
                            <td> <a href="javascript:void(0)" ng-click="remove(database)"><img src="assets/images/delete.png" alt="Delete"></a> </td>
                        </tr>
                        <tr>
                            <td colspan="4"><button type="submit" class="btn btn-primary ">Save Databases Information <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAEu0lEQVRYR8WXe0xbVRzHv+ecWwoUqMNtkM3FmTEek23IiM7HwCyLGokozBEmmuJilsAUYYkZ8R+r/2CMuoFI1GWbDmbigxnMYnRmMdMlZpEJSHltiaPqeE1es+XR3nuOuR2F3va25bFk97+ec36/7+f3OI8S3OaP3GZ9LB5AgGxtr1wDmSSD8BWeAAQdo1Tqbc18p3+xAS0YIP1SRRrl2A+OfDByt56QAvRRiNMAO9qR9V7PQmDCAmxtq1yrKPxdKmjRQhx61nAIQsnnEvhrl7KODISyCwmQ0VKRywVpAMHNVC/+GyGEF7dvq/khmGlQgC0tlRZwfhyU0sXrzltwQCFEWDq2HTml50cXwBM5F98uV9wrqEIw4Mn2rMNn/SECADw1n+GdlFHzciL3txWCjwoFm2zba4Z85wIANrdUfkGAwlspPp8JctKW9b4lKIBnqwnStVzxBMmMIXki0A0Xghp4Stt9tVe8k5oMpF+sqKeMlC4H4MX4ndh9x3ZUDTTCNvVXgCui8MPtD9QcDAQQIJt/K/+XUBa/VABV/IX4bI/5lHCh6topdEzbNe4Uzoc7769JCABQm0/I+OdWiHt9DMoTsNhr4RaKxi2j8urWzA+uq4NzJUi/WJFLGTmzFADfyL32E24nKmz1sMc4AKLtdeZSdrU+VHtOA3DvLwcOsaiIt/UA0qPWQQigc/rvgOlg4uWtdeiTxsDiIgNs+JS7wrajrkYLcL6smpmMVf6rt0SuR/Xa5zwAh/obNBB64uNuJ15trcNVwxik2EBx1T93zrxpy6m3aktwrsxKzcY3fAEyotajek0xjMTgGZ7krjmIUOJ9hnGwWGPQasrjk6937fq4WgOw6exLz0vxsQ2+VnvMD6J01eMaRyrEz84uPBGboRn3Rh4s7b6LXf2OZ3vyjjZpAJK/Lkk13mXuJtL83SOPTqIofgfKkp4K2ZuqePnvdbAb9Gvuayxkjplr/224vPv4nxqAR3+yStfFkJPFRUbMGQgB17ADexNycCApTxdiMeKqA/f41FT3hcQYWK1cA6D+2Pjdvu+jVpu1OZ+FKErIxstJT2vT7nKgvPVD2CNC13w+IGBm+EZzb+6xZ7xjmg26scmSa1wZc4aa5pPgWaiTifE58TGwIN3unzLucEEZdT7WXfDpj7oAsFppWqbdZkg0p4H6XZSzEMWJOdi7bufiIldjUDhmBm+0Xc47kQkCoQ+glqHJki1FG85Lq2IDn8yzEHHcCGeMCLnV/KN3DzqEcM083FNw8lffOd0XUerpkmpiiqiS7jTpQvBpN2iUX5lC7BN5xAnudL/VU3BCc84ENOGcjy/3sFTJ1EgiDUXSShOIfzlCbsr5STXt8sgk+LSrsfePeyzezg+bAXWBui0HRq/WgtFSw4po0OgIn6srDIFQj1sX5IkpCEXU9sqOgyj8SnslzroI+78g5RtLoZBRSyNZAjMZQaMNIBLTJVAPGWXSBU+3y8oAI+KVnvzPPCdesC8sgGqY0rwvFlwphUL2g2IDYeQmhLc0XEC4FQguwMGvMLBPmBz1UWdhvSNctRYE4HOQkNTmknQhyCOASCaCeF5PgohRCPRSsAvd+cc6fbfZrQUI520J8/8D09nzMMwzuZQAAAAASUVORK5CYII=" alt="save all"></button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    
    <!-- The actual snackbar -->
    <div id="snackbar">Some text some message..</div>

    <script src="assets/js/vendor.js"></script>
    <script src="assets/js/form-builder.min.js"></script>
    <script src="assets/js/form-render.min.js"></script>
    <script src="assets/js/jquery.rateyo.min.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/angular.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/ng-app.js"></script>
</body>
</html>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Carton Club</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <?php
        include '../../../../common/config/config.php';
    ?>
    <style>
        #sortable1{
            height: 150px;
            overflow-y: auto;
        }
        #sortable2 {
            height: 250px;
        }
        #sortable1, #sortable2 {
            border: 1px solid black;
            width: 1000px;
            min-height: 20px;
            list-style-type: none;
            margin: 0;
            padding: 5px 0 0 0;
            float: left;
            margin-right: 10px;
        }
        #sortable1 li, #sortable2 li {
            margin: 0 5px 5px 5px;
            padding: 5px;
            font-size: 1.2em;
            width: 120px;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#sortable1, #sortable2" ).sortable({
                connectWith: ".connectedSortable"
            }).disableSelection();
        });
    </script>
</head>
<body>
    <div class="container-fluid">
        <div class="panel panel-primary">
            <div class="panel-heading"> Carton Clubbing</div>
            <div class="panel-body">
                <form class="form-inline" action="#" method="POST">
                    <input type="hidden" id="search-type" name="search-type" value="">
                    <?php
                        $carton_no = array();
                        $get_cartons = "select DISTINCT carton_no from bai_pro3.pac_stat_log where schedule=558815;";
                        $carton_result=mysqli_query($link, $get_cartons) or die("Error"); 
                        while($row=mysqli_fetch_array($carton_result)) 
                        {
                            $carton_no[]=$row['carton_no'];
                        }

                    ?>
                    <ul id="sortable1" class="connectedSortable">
                        <?php
                            for ($i=0; $i < sizeof($carton_no); $i++)
                            { 
                                echo "<li class='btn btn-warning' value='".$carton_no[$i]."'>Carton - $carton_no[$i]</li>";
                            }
                        ?>
                    </ul>
                    <br><br>
                    <br><br>
                    <br><br>
                    <br><br>
                    <br><br>
                    <ul id="sortable2" class="connectedSortable">

                    </ul>
                    <br><br>
                    <br><br>
                    <input type="button" name="save" id="save" value="Club" class="btn btn-success" onclick="test();">
                </form>
               
            </div>
        </div>
    </div>
</body>
</html>
 <script type="text/javascript">
    function test()
    {
        var cart = "";
        var listItems = document.querySelectorAll('#sortable2 li');
        for (let i = 0; i < listItems.length; i++)
        {
            console.log(listItems[i].value);
            cart += listItems[i].value+',';
        }
        alert(cart);
    }
</script>
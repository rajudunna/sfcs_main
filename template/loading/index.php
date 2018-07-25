<!DOCTYPE html>
<html>

    <head>
    
        <meta charset="UTF-8">
        <title>Loading</title>
        <link rel="stylesheet" href="loading.css">
        <script type="text/javascript" src="loading.js"></script>
       
    </head>

    <body>
        
        <!-- Use This Division Only -->

        <div id="overlay" style="display:none;"> 
            <br>&nbsp;&nbsp;&nbsp;<button onclick="myLoadStop()">Stop</button>
            <div id="load1" class="circle" style="display:none;"></div>
            <div id="load2" class="circle" style="display:none;"></div>
            <div id="load3" class="circle" style="display:none;"></div>
            <div id="load4" class="circle" style="display:none;"></div>
            <div id="load5" class="circle" style="display:none;"></div>
        </div>
       
        <!-- This Division Only For Testing-->

        <div style="padding-top:50px;width:400px;margin:auto">
            <button onclick="myLoad1()">Load 1</button>
            <button onclick="myLoad2()">Load 2</button>
            <button onclick="myLoad3()">Load 3</button>
            <button onclick="myLoad4()">Load 4</button>
            <button onclick="myLoad5()">Load 5</button>
        </div><br>

    
    </body>

</html>
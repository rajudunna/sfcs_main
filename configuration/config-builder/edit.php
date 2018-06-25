<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="assets/css/app.css">
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/jquery.rateyo.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/jquery-ui.css">
    <title>Configuration Builder</title>
</head>
<body>
    <div class="content">
        <h1>Application Confr <small>(Trial-Version)</small></h1>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" >
            
        </div>
        <button id="save-all" type="button" class="btn btn-primary">Save <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAEu0lEQVRYR8WXe0xbVRzHv+ecWwoUqMNtkM3FmTEek23IiM7HwCyLGokozBEmmuJilsAUYYkZ8R+r/2CMuoFI1GWbDmbigxnMYnRmMdMlZpEJSHltiaPqeE1es+XR3nuOuR2F3va25bFk97+ec36/7+f3OI8S3OaP3GZ9LB5AgGxtr1wDmSSD8BWeAAQdo1Tqbc18p3+xAS0YIP1SRRrl2A+OfDByt56QAvRRiNMAO9qR9V7PQmDCAmxtq1yrKPxdKmjRQhx61nAIQsnnEvhrl7KODISyCwmQ0VKRywVpAMHNVC/+GyGEF7dvq/khmGlQgC0tlRZwfhyU0sXrzltwQCFEWDq2HTml50cXwBM5F98uV9wrqEIw4Mn2rMNn/SECADw1n+GdlFHzciL3txWCjwoFm2zba4Z85wIANrdUfkGAwlspPp8JctKW9b4lKIBnqwnStVzxBMmMIXki0A0Xghp4Stt9tVe8k5oMpF+sqKeMlC4H4MX4ndh9x3ZUDTTCNvVXgCui8MPtD9QcDAQQIJt/K/+XUBa/VABV/IX4bI/5lHCh6topdEzbNe4Uzoc7769JCABQm0/I+OdWiHt9DMoTsNhr4RaKxi2j8urWzA+uq4NzJUi/WJFLGTmzFADfyL32E24nKmz1sMc4AKLtdeZSdrU+VHtOA3DvLwcOsaiIt/UA0qPWQQigc/rvgOlg4uWtdeiTxsDiIgNs+JS7wrajrkYLcL6smpmMVf6rt0SuR/Xa5zwAh/obNBB64uNuJ15trcNVwxik2EBx1T93zrxpy6m3aktwrsxKzcY3fAEyotajek0xjMTgGZ7krjmIUOJ9hnGwWGPQasrjk6937fq4WgOw6exLz0vxsQ2+VnvMD6J01eMaRyrEz84uPBGboRn3Rh4s7b6LXf2OZ3vyjjZpAJK/Lkk13mXuJtL83SOPTqIofgfKkp4K2ZuqePnvdbAb9Gvuayxkjplr/224vPv4nxqAR3+yStfFkJPFRUbMGQgB17ADexNycCApTxdiMeKqA/f41FT3hcQYWK1cA6D+2Pjdvu+jVpu1OZ+FKErIxstJT2vT7nKgvPVD2CNC13w+IGBm+EZzb+6xZ7xjmg26scmSa1wZc4aa5pPgWaiTifE58TGwIN3unzLucEEZdT7WXfDpj7oAsFppWqbdZkg0p4H6XZSzEMWJOdi7bufiIldjUDhmBm+0Xc47kQkCoQ+glqHJki1FG85Lq2IDn8yzEHHcCGeMCLnV/KN3DzqEcM083FNw8lffOd0XUerpkmpiiqiS7jTpQvBpN2iUX5lC7BN5xAnudL/VU3BCc84ENOGcjy/3sFTJ1EgiDUXSShOIfzlCbsr5STXt8sgk+LSrsfePeyzezg+bAXWBui0HRq/WgtFSw4po0OgIn6srDIFQj1sX5IkpCEXU9sqOgyj8SnslzroI+78g5RtLoZBRSyNZAjMZQaMNIBLTJVAPGWXSBU+3y8oAI+KVnvzPPCdesC8sgGqY0rwvFlwphUL2g2IDYeQmhLc0XEC4FQguwMGvMLBPmBz1UWdhvSNctRYE4HOQkNTmknQhyCOASCaCeF5PgohRCPRSsAvd+cc6fbfZrQUI520J8/8D09nzMMwzuZQAAAAASUVORK5CYII=" alt="save"></button>
    </div>
    <div id="snackbar">Application Confr (Trial-Version)</div>

    <script src="assets/js/vendor.js"></script>
    <script src="assets/js/form-builder.min.js"></script>
    <script src="assets/js/form-render.min.js"></script>
    <script src="assets/js/jquery.rateyo.min.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/angular.min.js"></script>
    <script src="assets/js/edit.js"></script>
</body>
</html>
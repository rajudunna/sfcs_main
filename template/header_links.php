 <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="template/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="template/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="template/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="template/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="template/dist/css/skins/_all-skins.min.css">
    <!-- Morris chart -->
    <!-- jvectormap -->
    <link rel="stylesheet" href="template/bower_components/jvectormap/jquery-jvectormap.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="template/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="template/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="template/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <link rel="stylesheet" href="assets/vendors/select2/dist/css/select2.min.css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
     
     <!-- Loading Event -->

    <style type="text/css">

      #overlay {
          position: fixed;
          display: none;
          width: 100%;
          height: 100%;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: rgba(255, 255, 255, 0.85);
          z-index: 2;
          cursor: pointer;
      }

      #load1 {
          position: absolute;
          top: 50%;
          left: 50%;
          font-size: 50px;
          color: white;
          transform: translate(-50%,-50%);
          background-image: url(<?php echo "http://". $_SERVER['SERVER_NAME']?>/template/loading/gifs/1.gif);
          background-size: cover;
          background-position: center;
          border: 6px solid white;
      }

      #load2 {
          position: absolute;
          top: 50%;
          left: 50%;
          font-size: 50px;
          color: white;
          transform: translate(-50%,-50%);
          background-image: url(<?php echo "http://". $_SERVER['SERVER_NAME']?>/template/loading/gifs/2.gif);
          background-size: cover;
          background-position: center;
          border: 6px solid white;
      }

      #load3 {
          position: absolute;
          top: 50%;
          left: 50%;
          font-size: 50px;
          color: white;
          transform: translate(-50%,-50%);
          background-image: url(<?php echo "http://". $_SERVER['SERVER_NAME']?>/template/loading/gifs/3.gif);
          background-size: cover;
          background-position: center;
          border: 6px solid white;
      }

      #load4 {
          position: absolute;
          top: 50%;
          left: 50%;
          font-size: 50px;
          color: white;
          transform: translate(-50%,-50%);
          background-image: url(<?php echo "http://". $_SERVER['SERVER_NAME']?>/template/loading/gifs/4.gif);
          background-size: 400%;
          background-position: center;
          border: 6px solid white;
      }

      #load5 {
          position: absolute;
          top: 50%;
          left: 50%;
          font-size: 50px;
          color: white;
          transform: translate(-50%,-50%);
          background-image: url(<?php echo "http://". $_SERVER['SERVER_NAME']?>/template/loading/gifs/5.gif);
          background-size: 200%;
          background-position: center;
          border: 6px solid white;
      }

      .circle {
          position:fixed;
          height: 100px;
          width: 100px;
          display: table-cell;
          text-align: center;
          vertical-align: middle;
          border-radius: 50%;
          background: white;
          background-color: white;
          animation: ripple 0.7s linear infinite;   
      }

      @keyframes ripple {
          0% {
              box-shadow: 0 0 0 0 rgba(221, 221, 221, 0.3), 0 0 0 1em rgba(227, 227, 227, 0.3), 0 0 0 3em rgba(235, 235, 235, 0.3), 0 0 0 5em rgba(255, 255, 255, 0.3);
          }
          100% {
              box-shadow: 0 0 0 1em rgba(253, 253, 253, 0.3), 0 0 0 3em rgba(231, 231, 231, 0.3), 0 0 0 5em rgba(249, 249, 249, 0.3), 0 0 0 8em rgba(101, 255, 120, 0);
          }
      }


    </style>
        
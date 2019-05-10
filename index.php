<!DOCTYPE html>
<html lang="es">
  <head>
  <!-- Meta data -->
  <?php include_once("sections/meta.php"); ?>

  <!-- Títol i Favicons -->
  <title>Julia G Naranjo</title>
  <link rel="shortcut icon" href="img/favicons/favicon.ico">

  <!-- CSS basics -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <!--<link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">-->
  <!-- CSS custom -->
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/responsive.css">
  <!-- Google Fonts -->
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto">
  <!-- Scripts custom -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="js/script.js" type="text/javascript"></script>
</head>


<body class="index">
<!-- Google Analytics -->
<?php include_once("sections/analyticstracking.php"); ?>

<!-- Header -->
<div class="content">
  <div class="index-manifest">Julia Naranjo is a creative copywriter based in <span>Barcelona</span>. Currently at <span>DDB</span>.</div>
  
  <hr>
  <div class="footer-menu">
    <span class="footer-title">&#8594;  Select Work</span>
    <ul class="<?php if(isset($_GET['for'])){echo 'hidden';}else{echo '';}?>">
      <?php
        require("conexiones/conexion.php");
        $client = $database->select("work", ["name","client","type","url"], ["type" => "work"]);
        $clients = array();
        foreach($client as $data){
          array_push($clients,$data['client']);
        }
        $grupos = array_unique($clients);
        foreach($grupos as $data){
          echo '<li><a href="?for='.$data.'">'.$data.'</a></li>';
        }
        ?>
    </ul>
    <ul class="<?php if(isset($_GET['for'])){echo '';}else{echo 'hidden';}?>">
      <?php
        $work = $database->select("work", ["name","client","type","url"], ["client" => $_GET['for']]);
        foreach($work as $data){
          echo '<li><a href="work.php?was='.$data['url'].'">'.$data['name'].'</a></li>';
        }
        ?>
    </ul>
  </div>

  <div class="footer-menu">
    <span class="footer-title">&#8594;  Academic Work</span>
    <ul>
      <?php
        $academic = $database->select("work", ["name","client","type","url"], ["type" => "academic"]);
        foreach($academic as $data){
          echo '<li><a href="work.php?was='.$data['url'].'">'.$data['name'].'</a></li>';
        }
        ?>
    </ul>
  </div>

  <div class="footer-menu">
    <span class="footer-title">&#8594; Contact</span>
    <ul>
      <li>
        <script>
          enlace_correo()
        </script>
    </ul>
  </div>
</div>


<!-- JavaScripts basics -->
<!-- JavaScripts custom -->
<!-- Scripts custom -->

</body>
</html>
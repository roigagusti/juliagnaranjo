<?php
// Redirecció a HTTPS
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
  <!-- Meta data -->
  <?php include_once("sections/meta.php"); ?>

  <!-- Títol i Favicons -->
  <title>Julia González Naranjo</title>
  <link rel="shortcut icon" href="img/favicons/favicon.ico">

  <!-- CSS basics -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <!-- CSS custom -->
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/responsive.css">
  <!-- Google Fonts -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto">
  <!-- Scripts custom -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="js/script.js" type="text/javascript"></script>
</head>

<body class="index">
<!-- Google Analytics -->
<?php include_once("sections/analyticstracking.php"); ?>

<!-- Header -->
<div class="content">
  <div class="index-manifest">Julia is a creative copywriter based in <span>Barcelona</span></div>
  
  <hr>
  <div class="footer-menu">
    <!-- Títol en funció de si es principal o és subtitol amb possibilitat d'anar enrere -->
    <span class="footer-title"><?php if(isset($_GET['for'])){echo '<a href="index.php">&#8592; Selected Work</a>';}else{echo '&#8594; Selected Work';} ?></span>

    <!-- Menú inicial amb tots els CLIENTS llistats -->
    <ul class="<?php if(isset($_GET['for'])){echo 'hidden';}else{echo '';}?>">
      <?php
      require("conexiones/conexion.php");
      $client = $database->select("work", ["name","marca","type","url"], ["type" => "work", "ORDER" => ["ordre" => "ASC"]]);
      $clients = array();
      foreach($client as $data){
        array_push($clients,$data['marca']);
      }
      $grupos = array_unique($clients);

      function contar_repeticions($array, $valor) {
          $contadores = array_count_values($array);
          return $contadores[$valor];
      }

      foreach($grupos as $data){
        if(contar_repeticions($clients, $data)>1){
          echo '<li><a href="?for='.strtolower($data).'">'.$data.'</a></li>';
        }else{
          echo '<li><a href="work.php?was='.strtolower($data).'">'.$data.'</a></li>';
        };
      }
      ?>
    </ul>

    <!-- SubMenú amb els PROJECTES llistats de cada CLIENT -->
    <ul class="<?php if(isset($_GET['for'])){echo '';}else{echo 'hidden';}?>">
      <?php
        $work = $database->select("work", ["ordre","name","marca","grupo","type","url"], ["marca" => $_GET['for'], "ORDER" => ["ordre" => "ASC"]]);
        foreach($work as $data){
          echo '<li><a href="work.php?was='.$data['url'].'&from='.$_GET['for'].'">'.$data['grupo'].' | '.$data['name'].'</a></li>';
        }
      ?>
    </ul>
  </div>

  <div class="footer-menu <?php if(isset($_GET['for'])){echo 'hidden';} ?>">
    <span class="footer-title"><?php if(isset($_GET['in'])){echo '<a href="index.php">&#8592; Profesor invitado</a>';}else{echo '&#8594; Profesor invitado';} ?></span>

    <ul class="<?php if(isset($_GET['in'])){echo 'hidden';}else{echo '';}?>">
      <?php
        $academic = $database->select("work", ["name","marca","type","url"], ["type" => "academic"]);
        foreach($academic as $data){
          echo '<li><a href="?in='.$data['url'].'">'.$data['name'].'</a></li>';
        }
        /*$academicproject = $database->select("work", ["name","marca","type","url"], ["type" => "academic-project"]);
        foreach($academicproject as $data){
          echo '<li><a href="work.php?was='.$data['url'].'">'.$data['name'].'</a></li>';
        }*/
      ?>
    </ul>
    <ul class="<?php if(isset($_GET['in'])){echo 'profesor" style="max-width:460px; text-align:justify;';}else{echo 'hidden';}?>">
      <?php
        $talks = $database->select("work", ["title","description","url"], ["url" => $_GET['in']]);
        foreach($talks as $talk){
          echo '<li>'.$talk['title'].'<br><i>'.$talk['description'].'</i></a></li>';
        }
      ?>
    </ul>
  </div>

  <div class="footer-menu <?php if(isset($_GET['for'])){echo 'hidden';} ?>">
    <span class="footer-title">&#8594; Contact</span>
    <ul>
      <li><a href="//www.linkedin.com/in/julia-gnarajo" target="_blank">Julia G Naranjo</a></li>
      <li>
        <script>
          enlace_correo()
        </script>
      </li>
    </ul>
  </div>
</div>

<!-- JavaScripts basics -->
<!-- JavaScripts custom -->
<!-- Scripts custom -->
</body>
</html>
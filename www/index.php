<?php
include_once('conexiones/classes.php');
include_once('conexiones/private.php');

// Redirecció a HTTPS
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
  exit;
}
function linkedin(){
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"/></svg>';
    return $svg;
}
$main_url = 'https://api.notion.com/v1/databases/'.$mainDB.'/query';
$main_reponse = api($main_url,"POST",$token);
$main = analisiMain($main_reponse);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
  <!-- Meta data -->
  <?php include_once("sections/meta.php"); ?>

  <!-- Títol i Favicons -->
  <title>Julia Naranjo</title>
  <link rel="shortcut icon" target="_blank" href="img/favicons/favicon.ico">

  <!-- CSS basics -->
  <link rel="stylesheet" target="_blank" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- CSS custom -->
  <link rel="stylesheet" type="text/css" target="_blank" href="css/style.css">
  <link rel="stylesheet" type="text/css" target="_blank" href="css/responsive.css">
  <!-- Google Fonts -->
  <link rel="stylesheet" type="text/css" target="_blank" href="https://fonts.googleapis.com/css?family=Roboto">
  <!-- Scripts custom -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="js/script.js" type="text/javascript"></script>
</head>

<body>
    <!-- Google Analytics -->
    <?php include_once("sections/analyticstracking.php"); ?>

    <div class="content" id="top">
        <section class="header">
            <div class="row">
                <div class="col-md-12 nav-right say-hello">
                    <a class="button" href="https://www.linkedin.com/in/julia-gnaranjo/" target="_blank">
                        <?php echo $main->contact;?>
                    </a>
                </div>
            </div>
        </section>
        <!-- Presentació -->
        <section class="presentacio">
            <div class="text-present">
                <?php echo $main->title;?> <span class="pampallugues"> </span>
            </div>
            <div class="divertimento-circle">
                <svg class="circle-text" viewBox="0 0 100 100" width="100" height="100">
                    <defs>
                        <path id="circle" d="M 50, 50 m -37, 0 a 37,37 0 1,1 74,0 a 37,37 0 1,1 -74,0"/>
                    </defs>
                    <text>
                        <textPath xlink:href="#circle">
                        <?php echo $main->basedin;?>
                        </textPath>
                    </text>
                </svg>
            </div>
            <div class="link-experience">
                <a class="scroll-link button" href="#"><?php echo $main->experience;?></a>
                <a class="projects-link button" href="/projects.php"><?php echo $main->projects;?></a>
            </div>
        </section>

        <div id="experience-main">
            <!-- Loader -->
            <div class="text-center">
                <div class="spinner-border spinner-border-sm loader" role="status"></div>
                <div class="loading-text">Charging my experience</div>
            </div>
        </div>
    </div>

    <section class="footer-index">
        <a class="start-again button" href="#"><?php echo $main->up;?></a>
    </section>

<!-- JavaScripts basics -->
<!-- JavaScripts custom -->
<script type="text/javascript">
$(document).ready(function(){
    $('#experience-main').load('sections/experience.php');
});
</script>
<!-- Scripts custom -->
</body>
</html>
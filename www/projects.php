<?php
include_once('conexiones/classes.php');
include_once('conexiones/private.php');

// Redirecció a HTTPS
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
  exit;
}
function img($url){
  $text = '<img src="'.$url.'" alt="img">';
  return $text;
}
function vimeo($url){
  $text = '<div class="video-vimeo" style="padding:56.25% 0 0 0;position:relative;">';
  $text .= '<div class="thumbnail-vimeo" style="background: transparent url(https://i.vimeocdn.com/video/'.$url.'_640.jpg) center center no-repeat;background-size: cover;"></div>';
  $text .= '<div class="video-opac"></div>';
  $text .= '<div class="play-video"></div>';
  $text .= '<iframe src="https://player.vimeo.com/video/'.$url.'?title=0&byline=0&portrait=0&amp;loop=1" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
  $text .= '</div>';
  $text .= '<script src="https://player.vimeo.com/api/player.js"></script>';
  return $text;
}
function youtube($url){
  $text = '<iframe id="youtube" src="https://www.youtube-nocookie.com/embed/'.$url.'?controls=0&showinfo=0" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
  return $text;
}
function linkedin(){
  $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"/></svg>';
  return $svg;
}
function showProject($project){
  if(strpos($_SERVER['HTTP_HOST'], 'juliagnaranjo') != false){
    # si el domini conté juliagnaranjo és true (no false)
    if($project->confidencialidad == 'Hide'){
      $show = 0;
    }else{
      $show = 1;
    }
  }else{
    $show = 1;
  }
  if($show == 1){
    switch ($project->contentType) {
      case 'Image':
        $img = 'img/'.$project->url;
        $media = img($img);
        break;
      case 'Youtube':
        $media = youtube($project->url);
        break;
      case 'Vimeo':
        $media = vimeo($project->url);
        break;
      default:
        $media = '';
        break;
    }
    if($project->brand != Null){
      $brand = '. '.$project->brand;
    }else{
      $brand = '';
    }
    echo $media;
    echo '<div class="work-description">';
    echo "<span>".$project->title.$brand.".</span> ".$project->description;
    echo '</div>';
  }
}
$json = json_encode(filter("Status","select","equals","Active"));
$url = 'https://api.notion.com/v1/databases/'.$projectsDB.'/query';
$reponse = api($url,"POST",$token,$json);
$projects = analisiProjecte($reponse); 
?>
<!DOCTYPE html>
<html lang="es">
  <head>
  <!-- Meta data -->
  <?php include_once("sections/meta.php"); ?>

  <!-- Títol i Favicons -->
  <title>Julia Naranjo. Work</title>
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

    <div class="content">
      <section class="header-projects">
        <div class="row">
          <div class="col-md-2 nav-left"><a href="/">← Back</a></div>
          <div class="col-md-8 nav-center">
            <span class="logo-pampallugues">Julia Naranjo </span>
          </div>
          <div class="col-md-2 nav-right say-hello">
            <a class="button" href="https://www.linkedin.com/in/julia-gnaranjo/" target="_blank">Say hello</a>
            <!--<a href="https://www.linkedin.com/in/julia-gnaranjo/" target="_blank">
              <php echo linkedin();?>
            </a>-->
          </div>
        </div>
      </section>
      <!-- Projects -->
      <section class="projects dashboard">
        <div class="work left">
          <?php
          foreach($projects as $project){
              if($project->column == "Left"){
                showProject($project);
              }
          }
          ?>

        </div>

        <div class="work right">
          <?php
          foreach($projects as $project){
              if($project->column == "Right"){ 
                  showProject($project);
              }
          }
          ?>
        </div>
    </div>

    <section class="footer"></section>

<!-- JavaScripts basics -->
<!-- JavaScripts custom -->
<!-- Scripts custom -->
</body>
</html>
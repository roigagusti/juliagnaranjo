<?php
// Redirecció a HTTPS
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
  exit;
}
require("conexiones/conexion.php");

$datas = $database->select("work", ["id","title","client","marca","agency","year","executive","director","copywriter","art","description","url"], ["url" => $_GET['was']]);

foreach($datas as $data){
?>

<!DOCTYPE html>
<html lang="es">
  <head>
  <!-- Meta data -->
  <?php include_once("sections/meta.php") ?>

  <!-- Títol i Favicons -->
  <title><?php echo $data['marca']." | ".$data['title']; ?></title>
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


<body>
<!-- Google Analytics -->
<?php include_once("sections/analyticstracking.php") ?>

<!-- Header -->
<header>
    <span class="footer-title"><?php if(isset($_GET['from'])){echo '<a href="index.php?for='.$_GET['from'].'">';}else{echo '<a href="index.php">';} ?>&#8592;</a></span>
</header>

<div class="work">
  <div class="project_media" data-elementresizer="true" data-resize-parent="true">

    <?php
    $media = $database->select("files", ["id","name","type","work-id","mida","url"], ["work-id" => $data['id'], "ORDER" => ["orden" => "ASC"]]);
    $i=1;
    $m=0;
    foreach($media as $file){
      switch ($file['mida']) {
        case "grande":
          $style='style="max-height:10000px;"';
        break;
        case "mitad":
          //$style='style="max-width: 45% !important;"';
        break;
        default:
          $style='';
        break;
      }
      switch ($file['type']) {
        case "Youtube":
        if($m != 0){if($arxiu != $file['type']){echo '<hr style="clear:both;height: 0px;">';}}
        $m+=1;
        $arxiu = $file['type'];
          echo  '<div class="video-responsive">
                  <div class="thumbnail-youtube-'.$i.'" style="background: transparent url(https://img.youtube.com/vi/'.$file['url'].'/maxresdefault.jpg) center center no-repeat;background-size: cover;"></div>
                  <div class="video-opac-'.$i.'"></div>
                  <div class="play-video '.$i.'"></div>
                  <iframe id="youtube-'.$i.'" src="https://www.youtube-nocookie.com/embed/'.$file['url'].'?controls=0&showinfo=0" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>';
          $i+=1;
          break;
        case "Video":
        if($m != 0){if($arxiu != $file['type']){echo '<hr style="clear:both;height: 0px;">';}}
        $m+=1;
        $arxiu = $file['type'];
          echo  '<div class="photo-responsive">
                  <video src="'.$file['url'].'" controls></video>
                </div>';
          break;
        case "Vimeo":
        if($m != 0){if($arxiu != $file['type']){echo '<hr style="clear:both;height: 0px;">';}}
        $m+=1;
        $arxiu = $file['type'];
          echo  '<div style="padding:56.25% 0 0 0;position:relative;">
                  <div class="thumbnail-vimeo" style="background: transparent url(https://i.vimeocdn.com/video/'.$file['url'].'_640.jpg) center center no-repeat;background-size: cover;"></div>
                  <div class="video-opac"></div>
                  <div class="play-video"></div>
                  <iframe src="https://player.vimeo.com/video/'.$file['url'].'?title=0&byline=0&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                </div>
                <script src="https://player.vimeo.com/api/player.js"></script>';
          break;
        case "Imagen":
        if($m != 0){if($arxiu != $file['type']){echo '<hr style="clear:both;height: 0px;">';}}
        $m+=1;
        $arxiu = $file['type'];
          echo  '<div class="photo-responsive">
                  <img src="'.$file['url'].'" '.$style.'/>
                </div>';
          break;
        default:
          echo "";
      }}
    ?>
  </div>

  <div class="project_content">
    <?php if($data['title'] != ""){ echo "<strong>Title:</strong> ".$data['title']."<br>"; }
    if($data['client'] != ""){ echo "<strong>Client:</strong> ".$data['client']."<br>"; }
    if($data['agency'] != ""){ echo "<strong>Agency:</strong> ".$data['agency']."<br>"; }
    if($data['year'] != ""){ echo "<strong>Year:</strong> ".$data['year']."<br>"; }

    if($data['title'] != "" || $data['client'] != "" || $data['agency'] != "" || $data['year'] != ""){ ?><br><?php }

    if($data['executive'] != ""){ echo "<strong>Executive Creative Director:</strong> ".$data['executive']."<br>"; }
    if($data['director'] != ""){ echo "<strong>Creative Director:</strong> ".$data['director']."<br>"; }
    if($data['copywriter'] != ""){ echo "<strong>Copywriter:</strong> ".$data['copywriter']."<br>"; }
    if($data['art'] != ""){ echo "<strong>Art Direction:</strong> ".$data['art']."<br>"; } 

    if($data['executive'] != "" || $data['director'] != "" || $data['copywriter'] != "" || $data['art'] != ""){ ?><br><br><?php }

    if($data['description'] != ""){ echo '<div class="work-description">'.$data['description']."</div><br>"; }?>
  </div>
</div>

<div class="footer">
</div>

<?php } ?>
<!-- JavaScripts basics -->
<!-- JavaScripts custom -->
<script>
$(function(){
  $('.play-video').on("click", function () {
    $(this).addClass("hidden");
    if(this.classList.contains('1')){
      $(".thumbnail-youtube-1").fadeTo(800, 0);
      $("#youtube-1")[0].src += "&autoplay=1";
      setTimeout(function(){
        $('.thumbnail-youtube-1').addClass("hidden");
        $('.video-opac-1').addClass("hidden");
      }, 900);
    };
    if(this.classList.contains('2')){
      $(".thumbnail-youtube-2").fadeTo(800, 0);
      $("#youtube-2")[0].src += "&autoplay=1";
      setTimeout(function(){
        $('.thumbnail-youtube-2').addClass("hidden");
        $('.video-opac-2').addClass("hidden");
      }, 900);
    };
    if(this.classList.contains('3')){
      $(".thumbnail-youtube-3").fadeTo(800, 0);
      $("#youtube-3")[0].src += "&autoplay=1";
      setTimeout(function(){
        $('.thumbnail-youtube-3').addClass("hidden");
        $('.video-opac-3').addClass("hidden");
      }, 900);
    };
    if(this.classList.contains('4')){
      $(".thumbnail-youtube-4").fadeTo(800, 0);
      $("#youtube-4")[0].src += "&autoplay=1";
      setTimeout(function(){
        $('.thumbnail-youtube-4').addClass("hidden");
        $('.video-opac-4').addClass("hidden");
      }, 900);
    };
    if(this.classList.contains('5')){
      $(".thumbnail-youtube-5").fadeTo(800, 0);
      $("#youtube-5")[0].src += "&autoplay=1";
      setTimeout(function(){
        $('.thumbnail-youtube-5').addClass("hidden");
        $('.video-opac-5').addClass("hidden");
      }, 900);
    };
    });
  }); 
</script>
<!-- Scripts custom -->
</body>
</html>
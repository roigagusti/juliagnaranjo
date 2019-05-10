<?php
require("conexiones/conexion.php");

$datas = $database->select("work", ["id","title","client","agency","year","executive","director","copywriter","art","description","url"], ["url" => $_GET['was']]);

foreach($datas as $data){
?>

<!DOCTYPE html>
<html lang="es">
  <head>
  <!-- Meta data -->
  <?php include_once("sections/meta.php") ?>

  <!-- Títol i Favicons -->
  <title>Work | Julia G Naranjo</title>
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


<body >
<!-- Google Analytics -->
<?php include_once("sections/analyticstracking.php") ?>

<!-- Header -->
<header>
    <span class="footer-title"><a href="//www.juliagnaranjo.com">&#8592;</a></span>
</header>

<div class="work">

  <div class="project_media" data-elementresizer="true" data-resize-parent="true">
    <?php
    $media = $database->select("files", ["name","type","work-id","url"], ["work-id" => $data['id'], "ORDER" => ["orden" => "ASC"]]);

    foreach($media as $file){
      switch ($file['type']) {
        case "Youtube":
          echo  '<div class="video-responsive">
                  <iframe src="https://www.youtube-nocookie.com/embed/'.$file['url'].'?controls=0&showinfo=0" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>';
          break;
        case "Video":
          echo  '<div class="photo-responsive">
                  <video src="'.$file['url'].'" controls></video>
                </div>';
          break;
        case "Imagen":
          echo  '<div class="photo-responsive">
                  <img src="'.$file['url'].'" />
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
    if($data['art'] != ""){ echo "<strong>Art Direction:</strong> ".$data['art']."<br>"; } ?>
  </div>
</div>

<hr class="work">

<div class="footer">
</div>

<?php } ?>
<!-- JavaScripts basics -->
<!-- JavaScripts custom -->
<!-- Scripts custom -->

</body>
</html>
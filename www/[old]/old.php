<?php
// Redirecció a HTTPS
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
  exit;
}
function linkedin(){
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"/></svg>';
    return $svg;
  }
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
  <link rel="stylesheet" type="text/css" target="_blank" href="css/style_v02.css">
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
        <section class="header">
            <div class="row">
                <div class="col-md-12 nav-right">
                    <a href="https://www.linkedin.com/in/julia-gnaranjo/" target="_blank">
                    <?php echo linkedin();?>
                    </a>
                </div>
            </div>
        </section>
        <!-- Presentació -->
        <section class="presentacio">
            <div class="left-blocked-20">
                Hello,<br>
                I’m Julia a Brand & Content designer at Accenture Song in Barcelona.
            </div>
            <div class="left-blocked-20 link-experience">
                <a class="scroll-link" href="#">See my experience</a>
                <a class="projects-link" href="/projects.php">Selected projects</a>
            </div>
        </section>

        <!-- Projects -->
        <section class="projects">
            <div class="work left">
                <div class="projects-title" id="see-experience">
                    <span class="morado">Work experience</span>
                </div>

                <div id="accenture" class="project">
                    <div class="project-title">
                        Brand Content Strategist
                    </div>
                    <div class="project-subtitle">
                        Accenture Song | Actually
                    </div>
                    <div class="project-description">
                    </div>
                    <ul class="project-tasks">
                        <li>Interpret and create the values, personality, vision and mission throughout the brand digital narrative.</li>
                        <li>Lead content strategist in product design with focus on how to serve the audience with and optimal user expererience.</li>
                        <li>Use audience research and analyze data to drive content placement.</li>
                    </ul>
                    <div class="project-brands">
                        <a class="brand-link">Movistar</a>
                        <a class="brand-link">MANGO</a>
                        <a class="brand-link">El Corte Inglés</a>
                        <a class="brand-link">(...)</a>
                    </div>
                </div>

                <div id="marta-marin" class="project">
                    <div class="project-title">
                        Brand Content Strategist freelance
                    </div>
                    <div class="project-subtitle">
                        MM Studio | 2016-2021
                    </div>
                    <div class="project-description">
                    </div>
                    <ul class="project-tasks">
                        <li>Define creative territory and concept for fashion brands.</li>
                        <li>Design innovative approaches that express the heart and soul of a brand through a consistent voice.</li>
                        <li>Trends report.</li>
                    </ul>
                    <div class="project-brands">
                        <a class="brand-link">Carolina Herrera</a>
                        <a class="brand-link">Mandarin Oriental</a>
                        <a class="brand-link">Puig</a>
                        <a class="brand-link">Acid House</a>
                    </div>
                </div>

                <div id="ddb" class="project">
                    <div class="project-title">
                        Creative Copywriter
                    </div>
                    <div class="project-subtitle">
                        <a target="_blank" href="https://ddb.es/trabajos.html" alt="DDB trabajos">DDB</a> Barcelona | 2017-2020
                    </div>
                    <div class="project-description">
                    </div>
                    <div class="project-brands">
                        <a class="brand-link">Audi</a>
                    </div>                    
                </div>

                <div id="soon-in-tokio" class="project">
                    <div class="project-title">
                        Creative Copywriter
                    </div>
                    <div class="project-subtitle">
                        <a target="_blank" href="https://www.soonintokyo.com" alt="Soon in Tokio trabajos">Soon in Tokyo</a> Barcelona | 2016-2017
                    </div>
                    <div class="project-description">
                    </div>
                    <div class="project-brands">
                        <a class="brand-link">Reebok</a>
                        <a class="brand-link">Boboli</a>
                        <a class="brand-link">Swatch</a>
                    </div>
                </div>

                <div id="havas" class="project">
                    <div class="project-title">
                        Creative Copywriter
                    </div>
                    <div class="project-subtitle">
                        <a target="_blank" href="https://havascreative.com" alt="Havas Creative trabajos">Havas Creative</a> Barcelona | 2015-2016
                    </div>
                    <div class="project-description">
                    </div>
                </div>
            </div>

            <div class="work right">
                <div class="projects-title responsive-title" class="project">
                    <span class="morado">Professional proactivities</span>
                </div>

                <div id="song-is-female" class="project">
                    <div class="project-title">
                        Founder of 'Song is female'
                    </div>
                    <div class="project-subtitle">
                        Accenture | Actually
                    </div>
                    <div class="project-description">
                        I lead 'Song is Female', a feminist culture initiative in Accenture Song Europe, that aims to design a more sustainable 
                        and equal future with a focus on women's culture, design and life experiences.
                    </div>
                </div>
                
                <div id="elisava-talks" class="project">
                    <div class="project-title">
                        Content designer of Accenture Life Trends
                    </div>
                    <div class="project-subtitle">
                        Accenture | 2022
                    </div>
                    <div class="project-description">
                        I research, connect and write ideas and trends for  Accenture trend report outlines emerging trends.
                    </div>
                </div>
                
                <div id="puig-sessions" class="project">
                    <div class="project-title">
                        Sense of Luxury: session to inspire
                    </div>
                    <div class="project-subtitle">
                        Puig | 2019
                    </div>
                    <div class="project-description">
                        Inspirational workshop sessions based on how to design a luxury narrative through luxury culture, temporality and new desires.
                    </div>
                </div>
                
                <div id="tool-kit-creativo" class="project">
                    <div class="project-title">
                        Tool Kit Creativo
                    </div>
                    <div class="project-subtitle">
                        Elisava | 2018
                    </div>
                    <div class="project-description">
                        The <a target="_blank" href="https://www.elisava.net/es/proyectos/toolkit-creativo" alt="Tool kit creativo in the Elisava website">Creative Toolkit</a> 
                        is a method specific to ELISAVA's Postgraduate in Advertising Design and Creativity with which you will learn the key principles of 
                        advertising ideation, strengthen your resources and create projects in a professional and effective way.
                    </div>
                </div>
            </div>
        </section>

        <!-- Education -->
        <section class="education">
            <div class="learning left">
                <div class="learnings-title">
                    <span class="morado">Education</span>
                </div>

                <div id="stef-silva" class="project">
                    <div class="project-title">
                        Designing futures
                    </div>
                    <div class="project-subtitle">
                        Stef Silva | 2022
                    </div>
                    <div class="project-description">
                    </div>
                </div>

                <div id="master-elisava" class="project">
                    <div class="project-title">
                        Master of Strategic and Creative Brand Communication
                    </div>
                    <div class="project-subtitle">
                        Elisava, Pompeu Fabra. Barcelona | 2016-2017
                    </div>
                    <div class="project-description">
                    </div>
                </div>

                <div id="design-thinking" class="project">
                    <div class="project-title">
                        Design Thinking - 3rd European Creativity Festival
                    </div>
                    <div class="project-subtitle">
                        Elisava, Pompeu Fabra. Barcelona | 2016
                    </div>
                    <div class="project-description">
                    </div>
                </div>

                <div id="bachelor" class="project">
                    <div class="project-title">
                        Bachelor in Advertising
                    </div>
                    <div class="project-subtitle">
                        University of Seville | 2010-2014
                    </div>
                    <div class="project-description">
                    </div>
                </div>
            </div>

            <div class="teaching right">
                <div class="learnings-title" class="project">
                    <span class="morado">Teaching experience</span>
                </div>

                <div id="teaching-blanquerna" class="project">
                    <div class="project-title">
                        Lecturer at Fashion Communication Master
                    </div>
                    <div class="project-subtitle">
                        Ramon Llul University. Barcelona | Actually
                    </div>
                    <div class="project-description">
                    </div>
                </div>
                
                <div id="teaching-elisava" class="project">
                    <div class="project-title">
                        Lecturer at Advertising and Creativity Postgrade
                    </div>
                    <div class="project-subtitle">
                        Elisava, Pompeu Fabra. Barcelona | 2019-2020
                    </div>
                    <div class="project-description">
                    </div>
                </div>
                
                <div id="teaching-shifta" class="project">
                    <div class="project-title">
                        Lecturer at Storytelling Audiovisual
                    </div>
                    <div class="project-subtitle">
                        Shifta, Elisava. Barcelona | 2019
                    </div>
                    <div class="project-description">
                    </div>
                </div>
            </div>
        </section>
    </div>

    <section class="footer"></section>

<!-- JavaScripts basics -->
<!-- JavaScripts custom -->
<!-- Scripts custom -->
</body>
</html>
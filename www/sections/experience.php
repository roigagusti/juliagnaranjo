<?php
include_once('../conexiones/classes.php');
include_once('../conexiones/private.php');


function showProject($project){
    if($project->end == Null){
        $project->end = "Actually";
    }
    echo '<div class="project">';
        echo '<div class="project-title">';
            echo '<span>'.$project->title.'</span>';
        echo '</div>';
        echo '<div class="project-subtitle">';
        if($project->start == $project->end){
            $project_date = $project->start;
        }else{
            $project_date = $project->start.'-'.$project->end;
        }
        if($project->where == ''){
            echo $project_date;
        }else{
            echo $project->where.' | '.$project_date;
        }
        echo '</div>';
        echo '<div class="project-description">';
            echo $project->description;
        echo '</div>';
        echo '<ul class="project-tasks">';
            echo $project->tasks;
        echo '</ul>';
        echo '<div class="project-url">';
        echo '<a href="'.$project->url.'" target="_blank">'.$project->urlbeauty.'</a>';
        echo '</div>';
        echo '<div class="project-brands">';
        echo '</div>';
    echo '</div>';
}
$main_url = 'https://api.notion.com/v1/databases/'.$mainDB.'/query';
$main_reponse = api($main_url,"POST",$token);
$main = analisiMain($main_reponse);
$json = json_encode(filter("Status","select","equals","Active"));
$experience_url = 'https://api.notion.com/v1/databases/'.$experienceDB.'/query';
$experience_reponse = api($experience_url,"POST",$token,$json);
$experiences = analisiExperience($experience_reponse);
?>

<div id="experience-main">
    <!-- Experience -->
    <section class="experience">
        <div class="row">
            <div class="col-md-6 work-experience">
                <div class="row">
                    <div class="col-md-4 experience-title" id="see-experience">
                        <?php echo $main->experience_title_1;?>
                    </div>
                    <div class="col-md-8">

                    <?php
                    foreach($experiences as $experience){
                        if($experience->type == "Work experience"){ 
                            showProject($experience);
                        }
                    }
                    ?>

                    </div>
                </div>
            </div>
            <div class="col-md-6 pro-activities">
                <div class="row">
                    <div class="col-md-4 experience-title">
                        <?php echo $main->experience_title_2;?>
                    </div>
                    <div class="col-md-8">

                    <?php
                    foreach($experiences as $experience){
                        if($experience->type == "Pro activities"){   
                            showProject($experience);
                        }
                    }
                    ?>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Learning -->
    <section class="learning">
        <div class="row">
            <div class="col-md-6 work-experience">
                <div class="row">
                    <div class="col-md-4 experience-title" id="see-experience">
                        <?php echo $main->experience_title_3;?>
                    </div>
                    <div class="col-md-8">

                    <?php
                    foreach($experiences as $experience){
                        if($experience->type == "Education"){   
                            showProject($experience);
                        }
                    }
                    ?>

                    </div>
                </div>
            </div>
            <div class="col-md-6 pro-activities">
                <div class="row">
                    <div class="col-md-4 experience-title">
                        <?php echo $main->experience_title_4;?>
                    </div>
                    <div class="col-md-8">

                    <?php
                    foreach($experiences as $experience){
                        if($experience->type == "Teaching"){ 
                            showProject($experience);
                        }
                    }
                    ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
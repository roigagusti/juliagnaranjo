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
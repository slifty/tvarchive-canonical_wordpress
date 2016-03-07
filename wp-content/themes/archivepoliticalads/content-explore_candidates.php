<div class="row">
    <div class="col-md-12">
        <div id="explore-candidates-title" class="explore-subtitle-row">
            <h3>Candidates</h3>
            <p>Browse ads by candidate</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="explore-candidates-content" class="explore-content-row">
            <div id="explore-candidates-slider" class="explore-list explore-slider">
            <?php
                $candidates = get_candidates();
                foreach($candidates as $candidate) {
                    ?>
                    <a href="<?php bloginfo('url'); ?>/browse/?q=<?php echo(urlencode("candidate:\"".$candidate['name']."\""));?>">
                        <div class="explore-item item">
                            <div class="explore-wrapper">
                                <div class="explore-label"><?php echo($candidate['name']); ?></div>
                                <div class="explore-count"><?php echo($candidate['count']); ?>  Ad<?php echo($candidate['count']==1?"":"s");?></div>
                            </div>
                            <div class="explore-image">
                                <img src="https://archive.org/services/img/<?php echo(preg_replace('/[^\d\w]/','',$candidate['name'])); ?>" />
                            </div>
                        </div>
                    </a>
                    <?php
                }
            ?>
            </div>
        </div>
    </div>
</div>


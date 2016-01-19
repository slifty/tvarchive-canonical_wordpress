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
                    <a href="<?php bloginfo('url'); ?>/browse/?q=<?php echo(urlencode("candidate:\"".$candidate."\""));?>">
                        <div class="explore-item item">
                                <div class="explore-wrapper">
                                    <div class="explore-label"><?php echo($candidate); ?></div>
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


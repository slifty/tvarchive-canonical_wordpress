<div class="row">
    <div class="col-md-12">
        <div id="explore-sponsors-title" class="explore-subtitle-row">
            <h3>Sponsors</h3>
            <p>Browse ads by sponsor</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="explore-sponsors-content" class="explore-content-row">
            <div id="explore-sponsors-slider" class="explore-list explore-slider">
            <?php
                $sponsors = get_sponsors();
                foreach($sponsors as $sponsor) {
                    if($sponsor == "")
                        continue;
                    ?>
                    <a href="<?php bloginfo('url'); ?>/browse/?q=<?php echo(urlencode("sponsor:\"".$sponsor."\""));?>">
                        <div class="explore-item item">
                                <div class="explore-wrapper">
                                    <div class="explore-label"><?php echo($sponsor); ?></div>
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

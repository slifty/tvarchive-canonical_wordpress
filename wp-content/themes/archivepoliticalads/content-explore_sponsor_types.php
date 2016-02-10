<div class="row">
    <div class="col-md-12">
        <div id="explore-sponsor_types-title" class="explore-subtitle-row">
            <h3>Sponsor Types</h3>
            <p>Browse ads by sponsor type</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="explore-sponsor_types-content" class="explore-content-row">
            <div id="explore-sponsor_types-slider" class="explore-list explore-slider">
            <?php
                $sponsor_types = get_sponsor_types();
                foreach($sponsor_types as $sponsor_type) {
                    ?>
                    <a href="<?php bloginfo('url'); ?>/browse/?q=<?php echo(urlencode("sponsor_type:\"".$sponsor_type['name']."\""));?>">
                        <div class="explore-item item">
                            <div class="explore-wrapper">
                                <div class="explore-label"><?php echo(get_sponsor_type_value($sponsor_type['name'])); ?></div>
                                <div class="explore-count"><?php echo($sponsor_type['count']); ?> Ad<?php echo($sponsor_type['count']==1?"":"s");?></div>
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

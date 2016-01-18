<div class="row">
    <div class="col-md-12">
        <div id="explore-sponsors-title" class="explore-subtitle-row">
            <h3 class="hidden-xs hidden-sm">Sponsors</h3>
            <p>Browse ads by sponsor</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="explore-sponsors-content" class="explore-content-row">
            <div id="explore-sponsors-slider" class="explore-list owl-demo">
            <?php
                $sponsors = get_sponsors();
                foreach($sponsors as $sponsor) {
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

<script type="text/javascript">
    $(function() {
        var explore_slider = $("#explore-sponsors-slider");
        explore_slider.owlCarousel({
          itemsCustom : [
            [0, 2],
            [500, 4],
            [750, 4],
            [1000, 4],
            [1250, 5],
            [1500, 6]
          ]
        });
    });
</script>

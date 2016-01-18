<div class="row">
    <div class="col-md-12">
        <div id="explore-candidates-title" class="explore-subtitle-row">
            <h3 class="hidden-xs hidden-sm">Candidates</h3>
            <p>Browse ads by candidate</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="explore-candidates-content" class="explore-content-row">
            <div id="explore-candidates-slider" class="explore-list owl-demo">
            <?php
                $candidates = get_candidates();
                foreach($candidates as $candidate) {
                    ?>
                    <a href="<?php bloginfo('url'); ?>/browse/?q=<?php echo(urlencode("candidate:".$candidate));?>">
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
<script type="text/javascript">
    $(function() {
        var explore_slider = $("#explore-candidates-slider");
        explore_slider.owlCarousel({
          itemsCustom : [
            [0, 2],
            [500, 2],
            [750, 3],
            [1000, 4],
            [1250, 5],
            [1500, 6]
          ]
        });
    });
</script>


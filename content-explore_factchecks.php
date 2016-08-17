<div class="row">
    <div class="col-md-12">
        <div id="explore-factchecks-title" class="explore-subtitle-row text-center">
            <h3>Fact or Source Checked Ads</h3>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div id="explore-factchecks-content" class="explore-content-row text-center">

            <?php
                // Get a list of ads with references
                $ads = PoliticalAdArchiveAd::get_ads_with_references();
                if(sizeof($ads) > 0) {
                    ?>
                    <div id="factchecked-ads">
                        <?php
                            foreach($ads as $ad) {
                                ?>
                                <div class="factchecked-ad">
                                    <div class="embed"><a href="<?php echo(get_permalink($ad->wp_id)); ?>"><img src="//archive.org/serve/<?php echo($ad->archive_id); ?>/format=Thumbnail"/></div>
                                    <div class="sponsor"><a href="<?php echo(get_permalink($ad->wp_id)); ?>"><?php echo(implode(", ", $ad->sponsor_names)); ?></a></div>
                                    <div class="sponsor-type">Sponsor Type: <?php echo(implode(", ", $ad->sponsor_types)); ?></div>
                                    <div class="candidates">Candidates: <?php echo(implode(", ", $ad->candidate_names)); ?></div>
                                </div>
                                <?php
                            }
                        ?>
                    </div>
                    <script type="text/javascript">
                        $('#factchecked-ads').slick({
                          infinite: true,
                          slidesToShow: 5,
                          slidesToScroll: 5,
                          responsive: [
                            {
                              breakpoint: 1024,
                              settings: {
                                slidesToShow: 4,
                                slidesToScroll: 4,
                                infinite: true
                              }
                            },
                            {
                              breakpoint: 800,
                              settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
                                infinite: true
                              }
                            },
                            {
                              breakpoint: 480,
                              settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
                                infinite: true,
                                arrows: false,
                                swipeToSlide: true
                              }
                            }
                          ],
                          // prevArrow: "<div class='slick-prev'>&lsaquo;</div>",
                          // nextArrow: "<div class='slick-next'>&rsaquo;</div>"
                        });
                    </script>
                    <?php
                } else {
                    ?>
                    <div id="factchecked-ads">
                        <div class="no-ads">Right now we have no fact checks registered, check back soon!</div>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>
</div>

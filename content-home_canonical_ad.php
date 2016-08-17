<?php
    $featured_ad = get_field('featured_ad', 'option');
    if( $featured_ad ) {
        global $post;
        $post = $featured_ad;
        setup_postdata($featured_ad);
        $post_id = get_the_ID();
        $ad = new PoliticalAdArchiveAd($post_id);
        ?>
        <div class="row">
            <div class="col-md-12 hidden-xs hidden-sm">
                <div class="row">
                    <div id="ad-embed" class="col-md-12">
                        <iframe id="ad-embed-iframe" frameborder="0" width="100%" height="auto" allowfullscreen src="<?php echo($ad->embed_url);?>&nolinks=1" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-lg-3 p-l-0 p-r-0">
                        <div id="ad-sponsor_home" class="ad-info_home">
                            <div class="cell-label cell-label_home">Sponsor</div>
                            <div class="cell-value ad-sponsor_content">
                                <?php foreach ($ad->sponsors as $sponsor) { ?>
                                    <a class="ad-sponsor_link" href="<?php bloginfo('url'); ?>/browse?sponsor_filter=<?php echo(urlencode($sponsor->name));?>">
                                        <?php echo ($sponsor->name);?>
                                    </a>
                                <?php }; ?>
                            </div>
                        </div>
                        <div id="ad-candidate_home" class="ad-info_home">
                            <div class="cell-label cell-label_home">Candidate</div>
                            <div class="cell-value ad-candidate_content">
                                <?php foreach ($ad->candidates as $candidate) { ?>
                                    <a class="ad-sponsor_link" href="<?php bloginfo('url'); ?>/browse?candidate_filter=<?php echo(urlencode($candidate->name));?>">
                                        <?php echo($candidate->name);?> (<?php echo($candidate->affiliation);?>)
                                    </a>
                                <?php }; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-lg-9 p-l-0 p-r-0">
                        <div id="ad-note_home" class="ad-note_home">
                            <div class="cell-label cell-label_home">Note</div>
                            <div class="cell-multiline-value ad-note_content">
                                <?php echo substr($ad->notes, 0, 400).'&hellip;';?>
                                <a href="<?php the_permalink(); ?>">READ MORE</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    wp_reset_postdata();
?>

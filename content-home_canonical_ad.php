<?php
    $featured_ad = get_field('featured_ad', 'option');
    if( $featured_ad ) {
        global $post;
        $post = $featured_ad;
        setup_postdata($featured_ad);
        $post_id = get_the_ID();
        $post_metadata = get_fields($post_id);
        $ad_embed_url = $post_metadata['embed_url'];
        $ad_notes = $post_metadata['ad_notes'];
        $ad_id = $post_metadata['archive_id'];
        $ad_sponsors = $post_metadata['ad_sponsors'];
        $ad_candidates = $post_metadata['ad_candidates'];
        $ad_type = $post_metadata['ad_type'];
        $ad_message = $post_metadata['ad_message'];
        $ad_air_count = $post_metadata['air_count'];
        $ad_market_count = $post_metadata['market_count'];
        $ad_network_count = $post_metadata['network_count'];
        $ad_first_seen = $post_metadata['first_seen'];
        $ad_last_seen = $post_metadata['last_seen'];

        ?>
        <div class="row">
            <!-- <a href="<?php the_permalink(); ?>"><h2 class="ad-title_home">Featured Political Ad</h2></a> -->
            <div class="col-md-12 hidden-xs hidden-sm">
                <div class="row">
                    <div id="ad-embed" class="col-md-12">
                        <iframe id="ad-embed-iframe" frameborder="0" width="100%" height="auto" allowfullscreen src="<?php echo($ad_embed_url);?>" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 p-l-0 p-r-0">
                        <div id="ad-sponsor_home" class="ad-info_home">
                            <div class="cell-label cell-label_home">Sponsor</div>
                            <div class="cell-value ad-sponsor_content">
                                <?php foreach ($ad_sponsors as $key => $value) { ?>
                                    <a class="ad-sponsor_link" href="<?php bloginfo('url'); ?>/browse/?q=<?php echo(urlencode("sponsor:\"".$ad_sponsors[$key]['ad_sponsor']."\""));?>">
                                        <?php echo ($ad_sponsors[$key]['ad_sponsor']);?></a>
                                <?php }; ?>
                            </div>
                        </div>
                        <div id="ad-candidate_home" class="ad-info_home">
                            <div class="cell-label cell-label_home">Candidate</div>
                            <div class="cell-value ad-candidate_content">
                                <?php foreach ($ad_candidates as $key => $value) { ?>
                                    <a class="ad-sponsor_link" href="<?php bloginfo('url'); ?>/browse/?q=<?php echo(urlencode("sponsor:\"".$ad_candidates[$key]['ad_candidate']."\""));?>">
                                        <?php echo ($ad_candidates[$key]['ad_candidate']);?></a>
                                <?php }; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 p-l-0 p-r-0">
                        <div id="ad-note_home" class="ad-note_home">
                            <div class="cell-label cell-label_home">Note</div>
                            <div class="cell-multiline-value ad-note_content">
                                <?php echo substr($ad_notes, 0, 400).'&hellip;';?>
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

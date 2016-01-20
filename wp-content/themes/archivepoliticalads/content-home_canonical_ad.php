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
            <a href="<?php the_permalink(); ?>"><h2 class="ad-title_home">Featured Political Ad</h2></a>
            <div class="col-md-12 hidden-xs hidden-sm">
                <div class="row">
                    <div id="ad-embed" class="col-md-12">
                        <iframe id="ad-embed-iframe" frameborder="0" width="100%" height="auto" allowfullscreen src="<?php echo($ad_embed_url);?>" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
                    </div>
                </div>
                <div id="ad-note_home" class="ad-note_home">
                    <div class="cell-label cell-label_home">Note</div>
                    <div class="cell-multiline-value ad-note_content">
                        <?php echo($ad_notes);?>
                        <a href="<?php the_permalink(); ?>">READ MORE</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    wp_reset_postdata();
?>

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
            <div id="ad-embed" class="col-md-12">
                <iframe id="ad-embed-iframe" frameborder="0" width="100%" height="auto" allowfullscreen src="<?php echo($ad_embed_url);?>" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 separator-right">
                <div class="row separator-bottom">
                    <div class="col-md-3">
                        <div id="ad-sponsor" class="">
                            <div class="cell-label cell-label_home">Sponsor<?php echo(sizeof($ad_sponsors)==1?'':'s'); ?>
                            </div>
                            <div class="cell-value cell-value_home">
                                <?php echo(generate_sponsors_string($ad_sponsors));?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div id="ad-candidate" class="">
                            <div class="cell-label cell-label_home">Candidate<?php echo(sizeof($ad_candidates)==1?'':'s'); ?>
                            </div>
                            <div class="cell-value cell-value_home">
                                <?php echo(generate_candidates_string($ad_candidates)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="">
                    <div id="ad-note_home" class="ad-note_home">
                        <div class="cell-label cell-label_home">Note</div>
                        <div class="cell-multiline-value">
                            <?php echo($ad_notes);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
    wp_reset_postdata();
?>

<?php
    $featured_ad = get_field('featured_ad', 'option');
    if( $featured_ad ) {
        global $post;
        $post = $featured_ad;
        setup_postdata($featured_ad);
        $post_id = get_the_ID();
        $political_ad = new PoliticalAdArchiveAd($post_id);
        $ad_notes = $political_ad->notes;
        $transcript = $political_ad->transcript;
        $archive_id = $political_ad->archive_id;
        $ad_sponsor_names = $political_ad->sponsor_names;
        $ad_sponsor_types = $political_ad->sponsor_types;
        $ad_candidate_names = $political_ad->candidate_names;
        $ad_subjects = $political_ad->subjects;
        $ad_type = $political_ad->type;
        $ad_message = $political_ad->message;
        $ad_air_count = $political_ad->air_count;
        $ad_market_count = $political_ad->market_count;
        $ad_network_count = $political_ad->network_count;
        $ad_first_seen = $political_ad->first_seen;
        $ad_last_seen = $political_ad->last_seen;

        // Create sponsor links
        foreach($ad_sponsor_names as $index => $sponsor_name) {
            $ad_sponsor_names[$index] = "<a href='".get_bloginfo('url')."/browse/?sponsor_filter=".urlencode($sponsor_name)."'>".$sponsor_name."</a>";
        }

        // Create sponsor type links
        foreach($ad_sponsor_types as $index => $sponsor_type) {
            $ad_sponsor_types[$index] = "<a href='".get_bloginfo('url')."/browse/?sponsor_type_filter=".urlencode($sponsor_type)."''>".$sponsor_type."</a>";
        }
        // Create candidate links
        foreach($ad_candidate_names as $index => $ad_candidate) {
            $ad_candidate_names[$index] = "<a href='".get_bloginfo('url')."/browse/?candidate_filter=".urlencode($ad_candidate)."''>".$ad_candidate."</a>";
        }

        // Create subject links
        foreach($ad_subjects as $index => $ad_subject) {
            $ad_subjects[$index] = "<a href='".get_bloginfo('url')."/browse/?subject_filter=".urlencode($ad_subject)."''>".$ad_subject."</a>";
        }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div id="ad-embed" class="col-md-12">
                        <iframe id="ad-embed-iframe" frameborder="0" width="100%" height="auto" allowfullscreen src="<?php echo($political_ad->embed_url);?>&nolinks=1" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-5 col-lg-3 p-l-0 p-r-0">
                        <div id="ad-sponsor_home" class="ad-info_home col-sm-6 col-md-12">
                            <div class="cell-label cell-label_home">Sponsor</div>
                            <div class="cell-value ad-sponsor_content">
                                <?php echo(implode(', ', $ad_sponsor_names)); ?>
                            </div>
                        </div>
                        <div id="ad-candidate_home" class="ad-info_home col-sm-6 col-md-12">
                            <div class="cell-label cell-label_home">Candidate</div>
                            <div class="cell-value ad-candidate_content">
                                <?php echo(implode(', ', $ad_candidate_names)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7 col-lg-9 p-l-0 p-r-0">
                        <div id="ad-note_home" class="ad-note_home">
                            <div class="cell-label cell-label_home">Note</div>
                            <div class="cell-multiline-value ad-note_content">
                                <?php echo substr($ad_notes, 0, 400).'&hellip;';?>
                                <a href="ad/<?php echo($archive_id);?>">READ MORE</a>
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

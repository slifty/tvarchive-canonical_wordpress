<?php get_header(); ?>

    <main>
    <?php
        // Start the loop.
        while ( have_posts() )
        {
            the_post();
            $post_id = get_the_ID();
            $post_metadata = get_fields();

            $ad_embed_url = $post_metadata['embed_url'];
            $ad_notes = array_key_exists('ad_notes', $post_metadata)?$post_metadata['ad_notes']:'';
            $archive_id = array_key_exists('archive_id', $post_metadata)?$post_metadata['archive_id']:'';
            $ad_sponsors = array_key_exists('ad_sponsors', $post_metadata)?$post_metadata['ad_sponsors']:array();
            $ad_candidates = array_key_exists('ad_candidates', $post_metadata)?$post_metadata['ad_candidates']:array();
            $ad_subjects = array_key_exists('ad_subjects', $post_metadata)?$post_metadata['ad_subjects']:array();
            $ad_type = array_key_exists('ad_type', $post_metadata)?$post_metadata['ad_type']:'';
            $ad_message = array_key_exists('ad_message', $post_metadata)?$post_metadata['ad_message']:'';
            $ad_air_count = array_key_exists('air_count', $post_metadata)?$post_metadata['air_count']:0;
            $ad_market_count = array_key_exists('market_count', $post_metadata)?$post_metadata['market_count']:0;
            $ad_network_count = array_key_exists('network_count', $post_metadata)?$post_metadata['network_count']:0;
            $ad_first_seen = (array_key_exists('first_seen', $post_metadata)&&$post_metadata['first_seen'])?$post_metadata['first_seen']:'--';
            $ad_last_seen = (array_key_exists('last_seen', $post_metadata)&&$post_metadata['last_seen'])?$post_metadata['last_seen']:'--';

            // Create sponsor links
            $ad_sponsor_names = extract_sponsor_names($ad_sponsors);
            foreach($ad_sponsor_names as $index => $sponsor_name) {
                $ad_sponsor_names[$index] = "<a href='".get_bloginfo('url')."/browse/?q=".urlencode("sponsor:\"".$sponsor_name."\"")."'>".$sponsor_name."</a>";
            }

            // Create sponsor type links
            $ad_sponsor_types = extract_sponsor_types($ad_sponsors);
            foreach($ad_sponsor_types as $index => $sponsor_type) {
                $ad_sponsor_types[$index] = "<a href='".get_bloginfo('url')."/browse/?q=".urlencode("sponsor_type:\"".$sponsor_type."\"")."''>".get_sponsor_type_value($sponsor_type)."</a>";
            }
            // Create candidate links
            foreach($ad_candidates as $index => $ad_candidate) {
                $ad_candidates[$index] = "<a href='".get_bloginfo('url')."/browse/?q=".urlencode("candidate:\"".$ad_candidate['ad_candidate']."\"")."''>".$ad_candidate['ad_candidate']."</a>";
            }
            // Create subject links
            foreach($ad_subjects as $index => $ad_subject) {
                $ad_subjects[$index] = "<a href='".get_bloginfo('url')."/browse/?q=".urlencode("subject:\"".$ad_subject['ad_subject']."\"")."''>".$ad_subject['ad_subject']."</a>";
            }
            ?>

            <div id="ad-embed" class="row">
                <iframe id="ad-embed-iframe" class="col-xs-12" frameborder="0" allowfullscreen src="<?php echo($ad_embed_url);?>" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
            </div>

            <div id="about-ad-header" class="header-row row">
                <div class="col-xs-12">
                    <h1>About This Ad</h1>
                </div>
            </div>

            <div class="row about-ad-row">
                <div id="ad-sponsor" class="cell xs-last sm-last col-xs-12 col-md-6">
                    <div class="cell-label">Sponsor<?php echo(sizeof($ad_sponsor_names)==1?'':'s'); ?>
                    </div>
                    <div class="cell-value">
                        <?php echo(implode(', ', $ad_sponsor_names)); ?>
                    </div>
                </div>
                <div id="ad-sponsor" class="cell last col-xs-12 col-md-6">
                    <div class="cell-label">Sponsor Type<?php echo(sizeof($ad_sponsor_types)==1?'':'s'); ?>
                    </div>
                    <div class="cell-value">
                        <?php echo(implode(', ', $ad_sponsor_types)); ?>
                    </div>
                </div>
            </div>
            <div class="row about-ad-row">
                <div id="ad-candidate" class="cell last col-xs-12">
                    <div class="cell-label">Candidate<?php echo(sizeof($ad_candidates)==1?'':'s'); ?>
                    </div>
                    <div class="cell-value">
                        <?php echo(implode(', ', $ad_candidates)); ?>
                    </div>
                </div>
            </div>

            <div class="row about-ad-row">
                <div id="ad-candidate" class="cell last col-xs-12">
                    <div class="cell-label">Subject<?php echo(sizeof($ad_subjects)==1?'':'s'); ?>
                    </div>
                    <div class="cell-value">
                        <?php echo(implode(', ', $ad_subjects)); ?>
                    </div>
                </div>
            </div>

            <?php if($ad_notes) { ?>
            <div class="row about-ad-row">
                <div id="ad-note" class="last cell col-xs-12">
                    <div class="cell-label">Note</div>
                    <div class="cell-multiline-value">
                        <?php echo($ad_notes);?>
                    </div>
                </div>
            </div>
            <?php } ?>

            <div class="row about-ad-row">
                <div id="ad-air-count" class="cell xs-last col-xs-12 col-sm-4 col-lg-2">
                    <div class="cell-label">Air Count</div>
                    <div class="cell-value">
                        <?php echo($ad_air_count);?>
                    </div>
                </div>
                <div id="ad-market-count" class="cell xs-last col-xs-12 col-sm-4 col-lg-3">
                    <div class="cell-label">Markets Aired In</div>
                    <div class="cell-value cell-value_alt">
                        <?php echo($ad_market_count);?>
                    </div>
                </div>
                <div id="ad-network-count" class="cell xs-last sm-last md-last col-xs-12 col-sm-4 col-lg-3">
                    <div class="cell-label">Networks Aired On</div>
                    <div class="cell-value cell-value_alt">
                        <?php echo($ad_network_count);?>
                    </div>
                </div>
                <div id="ad-first-aired" class="cell xs-last col-xs-12 col-sm-6 col-lg-2">
                    <div class="cell-label">First Aired On</div>
                    <div class="cell-value cell-value_alt">
                        <?php echo($ad_first_seen);?>
                    </div>
                </div>
                <div id="ad-last-aired" class="last cell col-xs-12 col-sm-6 col-lg-2">
                    <div class="cell-label">Last Aired On</div>
                    <div class="cell-value cell-value_alt">
                        <?php echo($ad_last_seen);?>
                    </div>
                </div>
            </div>
            <div class="row last about-ad-row">
                <div id="ad-learn" class="cell last col-xs-12">
                    <div class="cell-label">Learn More About This Ad On Archive.org</div>
                    <div class="cell-value"><a href="http://www.archive.org/details/<?php echo($archive_id);?>">www.archive.org/details/<?php echo($archive_id);?></a></div>
                </div>
            </div>

            <div id="download-header" class="header-row row">
                <div class="col-lg-12">
                    <h1>Download</h1>
                </div>
            </div>

            <div class="row download-row">
                <div class="col-lg-12">
                    <div id="download-about" class="cell last">
                        <div class="cell-label">About the Dataset</div>
                        <div class="cell-multiline-value"><?php echo(get_field('about_the_data', 'options')); ?></div>
                    </div>
                </div>
            </div>
            <div class="row last download-row">
                <div class="col-xs-12">
                    <form method="get" action="<?php bloginfo('url'); ?>/export" target="_blank">
                        <input type="hidden" name="q" value="archive_id:'<?php echo($archive_id); ?>'" />
                        <input type="submit" id="download-data-button" class="button" value="Download CSV" />
                    </form>
                </div>
            </div>

            <?php
                $references = get_field('references');
                if(is_array($references)
                && sizeof($references) > 0) {
                    ?>
                    <div id="reference-gallery-header" class="header-row row">
                        <div class="col-lg-12">
                            <h1>REFERENCE GALLERY</h1>
                        </div>
                    </div>
                    <div id="reference-gallery-content" class="row">
                    <?php
                        // If there is only one item, that's a special case
                        foreach($references as $index => $reference) {
                            if($index % 4 == 0) // wide, first row
                            {
                                ?>
                                <div class="row">
                                    <div class="col-md-<?php echo((sizeof($references) - $index > 3)?"7":"12");?>">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="reference first-reference">
                                                    <a href="<?php echo($reference['reference_link']); ?>" target="_blank"><h3 class="reference-title"><?php echo($reference['reference_title']); ?></h3></a>
                                                    <div class="reference-date"><?php echo($reference['reference_date']); ?> </div>
                                                    <div class="reference-image"><a href="<?php echo($reference['reference_link']); ?>" target="_blank"><img src='<?php echo($reference['reference_image']);?>' /></a></div>
                                                    <div class="reference-description"><?php echo($reference['reference_excerpt']); ?></div>
                                                    <div class="reference-logo"><a href="<?php echo($reference['reference_link']); ?>" target="_blank"><img src='<?php echo($reference['reference_logo']);?>' /></a></div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                $cleanup = "
                                    </div>
                                </div>";
                            }
                            if($index % 4 == 1) // row2, col1
                            {
                                ?>
                                        <div class="row">
                                            <div class="col-md-6 col-xs-12">
                                                <div class="reference second-reference">
                                                    <a href="<?php echo($reference['reference_link']); ?>" target="_blank"><h3 class="reference-title"><?php echo($reference['reference_title']); ?></h3></a>
                                                    <div class="reference-date"><?php echo($reference['reference_date']); ?> </div>
                                                    <div class="reference-image"><a href="<?php echo($reference['reference_link']); ?>" target="_blank"><img src='<?php echo($reference['reference_image']);?>' /></a></div>
                                                    <div class="reference-description"><?php echo($reference['reference_excerpt']); ?></div>
                                                    <div class="reference-logo"><a href="<?php echo($reference['reference_link']); ?>" target="_blank"><img src='<?php echo($reference['reference_logo']);?>' /></a></div>
                                                </div>
                                            </div>
                                <?php
                                $cleanup = "
                                        </div>
                                    </div>
                                </div>";

                            }
                            if($index % 4 == 2) // small, second row
                            {
                                ?>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="reference third-reference">
                                                    <div class="reference-image"><a href="<?php echo($reference['reference_link']); ?>" target="_blank"><img src='<?php echo($reference['reference_image']);?>' /></a></div>
                                                    <a href="<?php echo($reference['reference_link']); ?>" target="_blank"><h3 class="reference-title"><?php echo($reference['reference_title']); ?></h3></a>
                                                    <div class="reference-date"><?php echo($reference['reference_date']); ?> </div>
                                                    <div class="reference-description"><?php echo($reference['reference_excerpt']); ?></div>
                                                    <div class="reference-logo"><a href="<?php echo($reference['reference_link']); ?>" target="_blank"><img src='<?php echo($reference['reference_logo']);?>' /></a></div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                $cleanup = "
                                    </div>
                                </div>";
                            }
                            if($index % 4 == 3) // small, second row
                            {
                                ?>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="reference fourth-reference">
                                            <a href="<?php echo($reference['reference_link']); ?>" target="_blank"><h3 class="reference-title"><?php echo($reference['reference_title']); ?></h3></a>
                                            <div class="reference-date"><?php echo($reference['reference_date']); ?> </div>
                                            <div class="reference-image"><a href="<?php echo($reference['reference_link']); ?>" target="_blank"><img src='<?php echo($reference['reference_image']);?>' /></a></div>
                                            <div class="reference-description"><?php echo($reference['reference_excerpt']); ?></div>
                                            <div class="reference-logo"><a href="<?php echo($reference['reference_link']); ?>" target="_blank"><img src='<?php echo($reference['reference_logo']);?>' /></a></div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                $cleanup = " ";
                            }
                        }
                        echo($cleanup);
                    ?>
                    </div>
                    <?php
                }
            }
        ?>
    </main>
    <?php get_footer(); ?>

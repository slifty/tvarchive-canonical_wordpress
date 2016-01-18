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
            ?>

            <div id="ad-embed" class="row">
                <iframe id="ad-embed-iframe" class="col-lg-12" frameborder="0" allowfullscreen src="<?php echo($ad_embed_url);?>" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
            </div>

            <div id="about-ad-header" class="header-row row">
                <div class="col-lg-12">
                    <h1>About This Ad</h1>
                </div>
            </div>

            <div class="row about-ad-row">
                <div id="ad-sponsor" class="first cell">
                    <div class="cell-label">Sponsor<?php echo(sizeof($ad_sponsors)==1?'':'s'); ?>
                    </div>
                    <div class="cell-value">
                        <?php echo(generate_sponsors_string($ad_sponsors));?>
                    </div>
                </div>
                <div id="ad-candidate" class="cell">
                    <div class="cell-label">Candidate<?php echo(sizeof($ad_candidates)==1?'':'s'); ?>
                    </div>
                    <div class="cell-value">
                        <?php echo(generate_candidates_string($ad_candidates)); ?>
                    </div>
                </div>
                <div id="ad-type" class="cell">
                    <div class="cell-label">Ad Type</div>
                    <div class="cell-value">
                        <?php echo($ad_type);?>
                    </div>
                </div>
                <div id="ad-message" class="last cell">
                    <div class="cell-label">Message</div>
                    <div class="cell-value">
                        <?php echo(generate_message_string($ad_message));?>
                    </div>
                </div>
            </div>

            <?php if($ad_notes) { ?>
            <div class="row about-ad-row">
                <div id="ad-note" class="first last cell">
                    <div class="cell-label">Note</div>
                    <div class="cell-multiline-value">
                        <?php echo($ad_notes);?>
                    </div>
                </div>
            </div>
            <?php } ?>

            <div class="row about-ad-row">
                <div id="ad-air-count" class="first cell">
                    <div class="cell-label">Number of Times Aired</div>
                    <div class="cell-value">
                        <?php echo($ad_air_count);?>
                    </div>
                </div>
                <div id="ad-market-count" class="cell">
                    <div class="cell-label">Markets Aired In</div>
                    <div class="cell-value cell-value_alt">
                        <?php echo($ad_market_count);?>
                    </div>
                </div>
                <div id="ad-network-count" class="cell">
                    <div class="cell-label">Networks Aired On</div>
                    <div class="cell-value cell-value_alt">
                        <?php echo($ad_network_count);?>
                    </div>
                </div>
                <div id="ad-first-aired" class="cell">
                    <div class="cell-label">This Ad First Aired On</div>
                    <div class="cell-value cell-value_alt">
                        <?php echo($ad_first_seen);?>
                    </div>
                </div>
                <div id="ad-last-aired" class="last cell">
                    <div class="cell-label">This Ad Last Aired On</div>
                    <div class="cell-value cell-value_alt">
                        <?php echo($ad_last_seen);?>
                    </div>
                </div>
            </div>

            <div class="row last about-ad-row">
                <div id="ad-learn" class="cell first last">
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
                    <div id="download-about" class="cell first last">
                        <div class="cell-label">About the Dataset</div>
                        <div class="cell-multiline-value">Gumbo beet greens corn soko endive gumbo gourd. Parsley shallot courgette tatsoi pea sprouts fava bean collard greens dandelion okra wakame tomato. Dandelion cucumber earthnut pea peanut soko zucchini. Turnip greens yarrow ricebean rutabaga endive cauliflower sea lettuce kohlrabi amaranth water spinach avocado daikon napa cabbage asparagus winter purslane kale. </div>
                    </div>
                </div>
            </div>
            <div class="row download-row">
                <div id="download-data" class="cell first last col-lg-12">
                    <div class="cell-label">Download Data About this Ad</div>
                </div>
            </div>
            <div class="row download-row">
                <div class="col-lg-12">
                    <form method="get" action="<?php bloginfo('url'); ?>/export" target="_blank">
                        <div class="row download-row last">
                            <div class="col-xs-offset-9 col-xs-3">

                                <input type="hidden" name="q" value="archive_id:'<?php echo($archive_id); ?>'" />
                                <input type="submit" id="download-data-button" class="button" value="Download CSV" />
                            </div>
                        </div>
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
                    }
                ?>
            </div>
            <?php
        }
    ?>
    </main>
    <?php get_footer(); ?>

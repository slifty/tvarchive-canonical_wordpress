<?php get_header(); ?>

    <main>
        <?php
// Start the loop.
while ( have_posts() ) : the_post();
	$post_id = get_the_ID();
	$post_metadata = get_fields();
	
	$ad_embed_url = $post_metadata['embed_url'];
	$ad_notes = $post_metadata['notes'];
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
                    <div class="cell-label">Sponsor
                        <?php echo(sizeof($ad_sponsors)==1?'':'s'); ?>
                    </div>
                    <div class="cell-value">
                        <?php echo(generate_sponsors_string($ad_sponsors));?>
                    </div>
                </div>
                <div id="ad-candidate" class="cell">
                    <div class="cell-label">Candidate
                        <?php echo(sizeof($ad_candidates)==1?'':'s'); ?>
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
                        <?php echo($ad_message);?>
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
                            <div class="cell-value">
                                <?php echo($ad_market_count);?>
                            </div>
                        </div>
                        <div id="ad-network-count" class="cell">
                            <div class="cell-label">Networks Aired On</div>
                            <div class="cell-value">
                                <?php echo($ad_network_count);?>
                            </div>
                        </div>
                        <div id="ad-first-aired" class="cell">
                            <div class="cell-label">This Ad First Aired On</div>
                            <div class="cell-value">
                                <?php echo($ad_first_seen);?>
                            </div>
                        </div>
                        <div id="ad-last-aired" class="last cell">
                            <div class="cell-label">This Ad Last Aired On</div>
                            <div class="cell-value">
                                <?php echo($ad_last_seen);?>
                            </div>
                        </div>
                    </div>

                    <div class="row last about-ad-row">
                        <div id="ad-learn" class="cell first last">
                            <div class="cell-label">Learn More About This Ad On Archive.org</div>
                            <div class="cell-value"><a href="http://www.archive.org/details/<?php echo($ad_id);?>">www.archive.org/details/<?php echo($ad_id);?></a></div>
                        </div>
                    </div>

                    <div id="download-header" class="header-row row">
                        <div class="col-lg-12">
                            <h1>Download</h1>
                        </div>
                    </div>

                    <div class="row download-row">
                        <div id="download-about" class="cell first last">
                            <div class="cell-label">About the Dataset</div>
                            <div class="cell-multiline-value">Gumbo beet greens corn soko endive gumbo gourd. Parsley shallot courgette tatsoi pea sprouts fava bean collard greens dandelion okra wakame tomato. Dandelion cucumber earthnut pea peanut soko zucchini. Turnip greens yarrow ricebean rutabaga endive cauliflower sea lettuce kohlrabi amaranth water spinach avocado daikon napa cabbage asparagus winter purslane kale. </div>
                        </div>
                    </div>

                    <div id="download-subheader" class="subheader-row row">
                        <div class="col-lg-12">
                            <h2>Download Data About this Ad</h2>
                        </div>
                    </div>

                    <div class="row download-row">
                        <div id="download-data" class="cell first last">
                            <div class="cell-label">Download Data About this Ad</div>

                            <div class="cell-multiline-value">Choose the fields you would like included below:</div>
                        </div>
                    </div>
                    <?php get_template_part('content', 'download_data'); ?>


                        <?php
// End the loop.
endwhile;
?>

    </main>
    <?php get_footer(); ?>

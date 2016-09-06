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

            <div id="ad-embed" class="row">
                <iframe id="ad-embed-iframe" class="col-xs-12" frameborder="0" allowfullscreen src="<?php echo($ad_embed_url);?>&nolinks=1" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
            </div>

            <div id="about-ad-header" class="row guttered-row">
                <div class="col-xs-12">
                    <h2 class="section-header">About This Ad</h2>
                </div>
            </div>

            <?php if($transcript) { ?>
            <div class="row about-ad-row">
                <div id="ad-note" class="last cell col-xs-12">
                    <div class="cell-label">Transcript</div>
                    <div class="cell-multiline-value">
                        <?php echo($transcript);?>
                    </div>
                </div>
            </div>
            <?php } ?>

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
                    <div class="cell-label">Candidate<?php echo(sizeof($ad_candidate_names)==1?'':'s'); ?>
                    </div>
                    <div class="cell-value">
                        <?php echo(implode(', ', $ad_candidate_names)); ?>
                    </div>
                </div>
            </div>

            <?php if(sizeof($ad_subjects) > 0) { ?>
            <div class="row about-ad-row">
                <div id="ad-candidate" class="cell last col-xs-12">
                    <div class="cell-label">Subject<?php echo(sizeof($ad_subjects)==1?'':'s'); ?>
                    </div>
                    <div class="cell-value">
                        <?php echo(implode(', ', $ad_subjects)); ?>
                    </div>
                </div>
            </div>
            <?php } ?>

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

            <?php if($ad_air_count > 0) { ?>
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
            <?php } ?>


            <div class="row about-ad-row">
                <div id="ad-embed-code" class="last cell col-xs-12 col-sm-12 col-lg-12">
                    <div class="cell-label">Embed Code</div>
                    <div class="cell-value cell-value_alt">
                        <textarea disabled><iframe src="https://archive.org/embed/<?php echo($archive_id);?>" width="640" height="480" frameborder="0" webkitallowfullscreen="true" mozallowfullscreen="true" allowfullscreen></iframe></textarea>
                    </div>
                </div>
            </div>
            <div class="row last about-ad-row">
                <div id="ad-learn" class="cell last col-xs-12">
                    <div class="cell-label">Learn More About This Ad On Archive.org</div>
                    <div class="cell-value"><a href="http://archive.org/details/<?php echo($archive_id);?>">archive.org/details/<?php echo($archive_id);?></a></div>
                </div>
            </div>


            <?php if($ad_air_count > 0) { ?>

            <div id="visualization-header" class="header-row hidden-xs hidden-sm row guttered-row">
                <div class="col-xs-12">
                    <h2 class="section-header">Where This Ad Aired</h2>
                </div>
            </div>

            <div id="visualization-row" class="page-content-row hidden-xs hidden-sm row">
                <div class="col-xs-12">
                    <div id="market-visualization"></div>
                    <script type="text/javascript">
                        $(function() {
                            var start_time = new Date("<?php echo($ad_first_seen);?>");
                            var end_time = new Date("<?php echo($ad_last_seen);?>");
                            start_time.setTime(start_time.getTime() - 24*60*60*1000);
                            end_time.setTime(end_time.getTime() + 24*60*60*1000);
                            var color = d3.scale.category20();

                            var eventDropsChart = d3.chart.eventDrops()
                                .start(start_time)
                                .end(end_time)
                                .minScale(1)
                                .eventLineColor(function (datum, index) {
                                    return color(index);
                                })
                                .tickFormat([
                                  ["", function(d) { return d.getMilliseconds(); }],
                                  ["", function(d) { return d.getSeconds(); }],
                                  ["", function(d) { return d.getMinutes(); }],
                                  ["", function(d) { return d.getHours(); }],
                                  ["%b %d", function(d) { return d.getDay() && d.getDate() != 1; }],
                                  ["%b %d", function(d) { return d.getDate() != 1; }],
                                  ["%b %d", function(d) { return d.getMonth(); }],
                                  ["", function() { return true; }]
                                ]);
                            $.ajax({
                                'url': '<?php bloginfo('url'); ?>/api/v1/ad_instances?archive_id=<?php echo(urlencode($archive_id)); ?>',
                                'method': 'GET',
                            })
                            .done(function(ad_instances) {

                                // Cluster instances by market + network
                                var buckets = {};
                                for(var x in ad_instances) {
                                    var ad_instance = ad_instances[x];
                                    var ad_bucket = ad_instance['location'].slice(0, -5);
                                    if(!(ad_bucket in buckets)) {
                                        buckets[ad_bucket] = [];
                                    }
                                    // Create a date
                                    var t = ad_instance['start_time'].split(/[- :]/);
                                    var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
                                    buckets[ad_bucket].push(d);
                                }

                                // Create data objects from the clusters
                                var data = [];
                                for (var property in buckets) {
                                    if (buckets.hasOwnProperty(property)) {
                                        data.push({
                                            name: property.substring(0, 18) + (property.length > 18?"...":""),
                                            dates: buckets[property]
                                        });
                                    }
                                }

                                // Sort in terms of state
                                data.sort(function(a,b) {
                                    var split_a = a.name.split(",");
                                    var split_b = b.name.split(",");

                                    // Get the state
                                    if (split_a[1] > split_b[1]) {
                                        return 1;
                                    }
                                    if (split_a[1] < split_b[1]) {
                                        return -1;
                                    }

                                    // Same state, sort by city
                                    if (split_a[0] > split_b[0]) {
                                        return 1;
                                    }
                                    if (split_a[0] < split_b[0]) {
                                        return -1;
                                    }

                                    // a must be equal to b
                                    return 0;
                                })

                                var chart = d3.select('#market-visualization')
                                  .datum(data)
                                  .call(eventDropsChart);

                                d3.select($('rect.zoom')[0]).on('.zoom', null);
                            });
                        });
                    </script>
                </div>
            </div>
            <?php } ?>

            <?php if($ad_air_count > 0) { ?>
            <div id="download-header" class="row guttered-row">
                <div class="col-lg-12">
                    <h2 class="section-header">Download</h2>
                </div>
            </div>

            <div class="row download-row">
                <div class="col-xs-12">
                    <div id="download-about" class="cell last">
                        <div class="cell-label">About the Dataset</div>
                        <div class="cell-multiline-value"><?php echo(get_field('about_the_data', 'options')); ?></div>
                    </div>
                </div>
            </div>
            <div class="row last download-row">
                <div class="col-xs-12">
                    <form method="get" action="<?php bloginfo('url'); ?>/api/v1/ad_instances" target="_blank">
                        <input type="hidden" name="archive_id" value="<?php echo($archive_id); ?>" />
                        <input type="hidden" name="output" value="csv" />
                        <input type="submit" id="download-data-button" class="btn primary data-download__button" value="Download Data About This Ad" />
                    </form>
                </div>
            </div>
            <?php } ?>

            <?php
                $references = get_field('references');
                if(is_array($references)
                && sizeof($references) > 0) {
                    ?>
                    <div id="reference-gallery-header" class="row guttered-row">
                        <div class="col-lg-12">
                            <h2 class="section-header">REFERENCE GALLERY</h2>
                        </div>
                    </div>
                    <div id="reference-gallery-content" class="row guttered-row">
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
                                                    <div class="reference-description"><?php echo($reference['reference_excerpt']); ?> <a href="<?php echo($reference['reference_link']); ?>" target="_blank">READ MORE</a></div>
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
                                                    <div class="reference-description"><?php echo($reference['reference_excerpt']); ?> <a href="<?php echo($reference['reference_link']); ?>" target="_blank">READ MORE</a></div>
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
                                                    <div class="reference-description"><?php echo($reference['reference_excerpt']); ?> <a href="<?php echo($reference['reference_link']); ?>" target="_blank">READ MORE</a></div>
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
                                            <div class="reference-description"><?php echo($reference['reference_excerpt']); ?> <a href="<?php echo($reference['reference_link']); ?>" target="_blank">READ MORE</a></div>
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

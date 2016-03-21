<?php
/*
    Template Name: Browse
*/
?>
<?php get_header(); ?>
<div id="browse-header" class="row">
    <div class="col-md-12 col-lg-12">
        <div class="row page-header-row">
            <div class="col-sm-8 col-md-6">
                <h1 id="browse-header-title" class="section-header">Search</h1>
                <p id="browse-header-description">Search and Explore the Political TV Ad Archive</p>
            </div>
        </div>
        <div id="browse-header-search" class="row page-header-row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <?php get_search_form(); ?>
            </div>
        </div>
        <?php
            $facet_candidates = get_metadata_names(get_candidates());
            $facet_sponsors = get_metadata_names(get_sponsors());
            $facet_sponsor_types = get_metadata_names(get_sponsor_types());
            $facet_messages = get_metadata_names(get_messages());
            $facet_markets = get_metadata_names(get_markets());
            $facet_channels = get_metadata_names(get_channels());
            $facet_programs = get_metadata_names(get_programs());
            $facet_ad_types = get_metadata_names(get_ad_types());

            // Alphabetical order
            sort($facet_candidates);
            sort($facet_sponsors);
            sort($facet_sponsor_types);
            sort($facet_messages);
            sort($facet_markets);
            sort($facet_channels);
            sort($facet_programs);
            sort($facet_ad_types);

            if(array_key_exists('q', $_GET)
            && trim($_GET['q']) != '') {
                $pagination_index = get_query_var('paged', 0);
                $query = $_GET['q'];
                $parsed_query = parse_political_ad_query($query);
            } else {
                $parsed_query = parse_political_ad_query("");
            }

            // Extract the values
            $candidate_values = array();
            $sponsor_values = array();
            $sponsor_type_values = array();
            $message_values = array();
            $market_values = array();
            $channel_values = array();
            $program_values = array();
            $ad_type_values = array();

            foreach($parsed_query['candidate'] as $item) {
                $candidate_values[] = $item['value'];
            }

            foreach($parsed_query['sponsor'] as $item) {
                $sponsor_values[] = $item['value'];
            }

            foreach($parsed_query['sponsor_type'] as $item) {
                $sponsor_type_values[] = $item['value'];
            }

            foreach($parsed_query['message'] as $item) {
                $message_values[] = $item['value'];
            }

            foreach($parsed_query['market'] as $item) {
                $market_values[] = $item['value'];
            }

            foreach($parsed_query['network'] as $item) {
                $channel_values[] = $item['value'];
            }

            foreach($parsed_query['program'] as $item) {
                $program_values[] = $item['value'];
            }

            foreach($parsed_query['type'] as $item) {
                $ad_type_values[] = $item['value'];
            }

            // autocomplete assumes the last value ends in a comma so, add an empty item
            $candidate_values[] = '';
            $sponsor_values[] = '';
            $sponsor_type_values[] = '';
            $message_values[] = '';
            $market_values[] = '';
            $channel_values[] = '';
            $program_values[] = '';
            $ad_type_values[] = '';

        ?>
        <div id="browse-header-advanced" class="row page-header-row" style="display:none;">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <form id="advanced-search-form" action="<?php bloginfo('url'); ?>/browse">
                    <div id="advanced-facets">
                        <ul>
                            <li>
                                <div class="advanced-facet-title">Candidate</div>
                                <div class="advanced-facet-value"><input type="text" id="candidate-facet" value="<?php echo(implode(', ', $candidate_values)); ?>" /></div>
                            </li>
                            <li>
                                <div class="advanced-facet-title">Sponsor</div>
                                <div class="advanced-facet-value"><input type="text" id="sponsor-facet" value="<?php echo(implode(', ', $sponsor_values)); ?>" /></div>
                            </li>
                            <li>
                                <div class="advanced-facet-title">Sponsor Type</div>
                                <div class="advanced-facet-value"><input type="text" id="sponsor-type-facet" value="<?php echo(implode(', ', $sponsor_type_values)); ?>" /></div>
                            </li>
                            <li>
                                <div class="advanced-facet-title">Message</div>
                                <div class="advanced-facet-value"><input type="text" id="message-facet" value="<?php echo(implode(', ', $message_values)); ?>" /></div>
                            </li>
                            <li>
                                <div class="advanced-facet-title">Market</div>
                                <div class="advanced-facet-value"><input type="text" id="market-facet" value="<?php echo(implode(', ', $market_values)); ?>" /></div>
                            </li>
                            <li>
                                <div class="advanced-facet-title">Channel</div>
                                <div class="advanced-facet-value"><input type="text" id="channel-facet" value="<?php echo(implode(', ', $channel_values)); ?>" /></div>
                            </li>
                            <li>
                                <div class="advanced-facet-title">Program</div>
                                <div class="advanced-facet-value"><input type="text" id="program-facet" value="<?php echo(implode(', ', $program_values)); ?>" /></div>
                            </li>
                            <li>
                                <div class="advanced-facet-title">Ad Type</div>
                                <div class="advanced-facet-value"><input type="text" id="ad-type-facet" value="<?php echo(implode(', ', $ad_type_values)); ?>" /></div>
                            </li>
                        </ul>
                    </div>
                    <div id="advanced-dates">

                    </div>
                    <input type="hidden" id="advanced-search-value" name="q" value="" />
                </form>
            </div>
        </div>
        <script type="text/javascript">
            var facetCandidates = ["<?php echo(implode('","', $facet_candidates)); ?>"];
            var facetSponsors = ["<?php echo(implode('","', $facet_sponsors)); ?>"];
            var facetSponsorTypes = ["<?php echo(implode('","', $facet_sponsor_types)); ?>"];
            var facetMessages = ["<?php echo(implode('","', $facet_messages)); ?>"];
            var facetMarkets = ["<?php echo(implode('","', $facet_markets)); ?>"];
            var facetChannels = ["<?php echo(implode('","', $facet_channels)); ?>"];
            var facetPrograms = ["<?php echo(implode('","', $facet_programs)); ?>"];
            var facetAdTypes = ["<?php echo(implode('","', $facet_ad_types)); ?>"];

            function split( val ) {
              return val.split( /,\s*/ );
            }
            function extractLast( term ) {
              return split( term ).pop();
            }

            function preparedAutoComplete( object, list) {
                object
                .bind( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB &&
                        $( this ).autocomplete( "instance" ).menu.active ) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                    minLength: 0,
                    source: function( request, response ) {
                      // delegate back to autocomplete, but extract the last term
                      response( $.ui.autocomplete.filter(
                        list, extractLast( request.term ) ) );
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function( event, ui ) {
                        var original = this.value;
                        var terms = split( this.value );
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push( ui.item.value );
                        // add placeholder to get the comma-and-space at the end
                        terms.push( "" );
                        this.value = terms.join( ", " );

                        // Were any changes made?
                        if(original == this.value)
                            return true;

                        return false;
                    }
                });
            }

            function populateAdvancedQuery() {
                var queryComponents = [];

                var candidates = $("#candidate-facet").val().split(",");
                var sponsors = $("#sponsor-facet").val().split(",");
                var sponsorTypes = $("#sponsor-type-facet").val().split(",");
                var messages = $("#message-facet").val().split(",");
                var markets = $("#market-facet").val().split(",");
                var channels = $("#channel-facet").val().split(",");
                var programs = $("#program-facet").val().split(",");
                var ad_types = $("#ad-type-facet").val().split(",");

                for (var index in candidates) {
                    var value = candidates[index];
                    if(value.trim() != "") {
                        queryComponents.push('candidate:"' + value.trim() + '"');
                    }
                }

                for (var index in sponsors) {
                    var value = sponsors[index];
                    if(value.trim() != "") {
                        queryComponents.push('sponsor:"' + value.trim() + '"');
                    }
                }

                for (var index in sponsorTypes) {
                    var value = sponsorTypes[index];
                    if(value.trim() != "") {
                        queryComponents.push('sponsor_type:"' + value.trim() + '"');
                    }
                }

                for (var index in messages) {
                    var value = messages[index];
                    if(value.trim() != "") {
                        queryComponents.push('message:"' + value.trim() + '"');
                    }
                }

                for (var index in markets) {
                    var value = markets[index];
                    if(value.trim() != "") {
                        queryComponents.push('market:"' + value.trim() + '"');
                    }
                }

                for (var index in channels) {
                    var value = channels[index];
                    if(value.trim() != "") {
                        queryComponents.push('channel:"' + value.trim() + '"');
                    }
                }

                for (var index in programs) {
                    var value = programs[index];
                    if(value.trim() != "") {
                        queryComponents.push('program:"' + value.trim() + '"');
                    }
                }

                for (var index in ad_types) {
                    var value = ad_types[index];
                    if(value.trim() != "") {
                        queryComponents.push('type:"' + value.trim() + '"');
                    }
                }

                var queryString = queryComponents.join(" OR ");
                $("#advanced-search-value").val(queryString);
            }

            $('form').each(function() {
                $(this).find('input').keypress(function(e) {
                    // Enter pressed?
                    if(e.which == 10 || e.which == 13) {
                        populateAdvancedQuery();
                        this.form.submit();
                    }
                });
            });

            $(function() {
                preparedAutoComplete($("#candidate-facet"), facetCandidates);
                preparedAutoComplete($("#sponsor-facet"), facetSponsors);
                preparedAutoComplete($("#sponsor-type-facet"), facetSponsorTypes);
                preparedAutoComplete($("#message-facet"), facetMessages);
                preparedAutoComplete($("#market-facet"), facetMarkets);
                preparedAutoComplete($("#channel-facet"), facetChannels);
                preparedAutoComplete($("#program-facet"), facetPrograms);
                preparedAutoComplete($("#ad-type-facet"), facetAdTypes);

                // Parse results on submit
                $("#advanced-search-form").submit(function() {
                    populateAdvancedQuery();
                });
            });
        </script>

        <div id="browse-header-toggle" class="row page-header-row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div id="search-toggle"></div>
            </div>
        </div>

        <script type="text/javascript">
            $(function() {
                var searchToggle = $("#search-toggle");
                searchToggle.text("Advanced Search");
                isBasic = true;
                searchToggle.click(function() {
                    if(isBasic) {
                        $("#browse-header-advanced").show();
                        $("#browse-header-search").hide();
                        searchToggle.text("Basic Search");
                        isBasic = false;
                    } else {
                        $("#browse-header-search").show();
                        $("#browse-header-advanced").hide();
                        searchToggle.text("Advanced Search");
                        isBasic = true;
                    }
                });
            });
        </script>
    </div>
</div>


<div id="browse-content" class="page-content">
<?php
    if(array_key_exists('q', $_GET)
    && trim($_GET['q']) != '') {
        $pagination_index = get_query_var('paged', 0);
        $query = $_GET['q'];
        $sort = array_key_exists('order', $_GET)?$_GET['order']:'count';
        $args= array(
            'posts_per_page' => 4,
            'paged' => $pagination_index,
        );

        switch($sort) {
            case 'date':
                $args['orderby'] = 'post_date';
                $args['order'] = 'DESC';
                break;
            case 'count':
            default:
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = 'air_count';
                $args['order'] = 'DESC';
        }

        $wp_query = search_political_ads($query, $args);

        ?>
        <div class="row page-content-row">
            <div class="col-sm-6 col-xs-12" id="search-results-total">
                <?php echo($wp_query->found_posts);?> Result<?php echo($wp_query->found_posts==1?'':'s'); ?> Found
            </div>
            <div class="col-sm-6 hidden-xs" id="search-results-sort-block">
                Order By:
                <select id="search-results-sort">
                    <option value="count" <?php echo(($sort == "count")?"selected":""); ?>>Air Count</option>
                    <option value="date" <?php echo(($sort == "date")?"selected":""); ?>>Date Added</option>
                </select>
                <script type="text/javascript">
                    $(function() {
                        $("#search-results-sort").change(function() {
                            var sort = $("#search-results-sort").val();
                            $("#search-form-order").val(sort);
                            $("#search-form").submit();
                        });
                    })
                </script>
            </div>
        </div>
        <div id="search-results">
        <?php
            while($wp_query->have_posts()) {
                $wp_query->the_post();
                $post_metadata = get_fields();
                $date_created = get_the_date('n/j/y, g:i A');
                $ad_notes = array_key_exists('ad_notes', $post_metadata)?$post_metadata['ad_notes']:'';
                $archive_id = array_key_exists('archive_id', $post_metadata)?$post_metadata['archive_id']:'';
                $ad_sponsors = (array_key_exists('ad_sponsors', $post_metadata) && $post_metadata['ad_sponsors'])?$post_metadata['ad_sponsors']:array();
                $ad_candidates = (array_key_exists('ad_candidates', $post_metadata) && $post_metadata['ad_candidates'])?$post_metadata['ad_candidates']:array();
                $ad_subjects = (array_key_exists('ad_subjects', $post_metadata) && $post_metadata['ad_subjects'])?$post_metadata['ad_subjects']:array();
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
                    $ad_sponsor_names[$index] = $sponsor_name;
                }

                // Create sponsor type links
                $ad_sponsor_types = extract_sponsor_types($ad_sponsors);
                foreach($ad_sponsor_types as $index => $sponsor_type) {
                    $ad_sponsor_types[$index] = get_sponsor_type_value($sponsor_type);
                }
                // Create candidate links
                foreach($ad_candidates as $index => $ad_candidate) {
                    $ad_candidates[$index] = $ad_candidate['ad_candidate'];
                }

                // Create subject links
                foreach($ad_subjects as $index => $ad_subject) {
                    $ad_subjects[$index] = $ad_subject['ad_subject'];
                }

                ?>
                <div class="row page-content-row political-ad">
                    <div>
                        <div class="col-xs-12 col-sm-6 col-lg-3">
                            <div class="embed">
                                <iframe frameborder="0" allowfullscreen src="<?php echo($post_metadata['embed_url']);?>&nolinks=1" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-lg-9">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="title">
                                        <a href="<?php the_permalink(); ?>"><?php echo(implode(", ", $ad_candidates)); ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class=" col-sm-12">
                                    <div class="sponsors">
                                        <span class="browse-label">Ingested:</span>
                                        <?php echo($date_created); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class=" col-sm-12">
                                    <div class="sponsors">
                                        <span class="browse-label">Sponsor<?php if(sizeof($ad_sponsors) != 1) { echo("s"); }?>: </span>
                                        <?php echo(implode(", ", $ad_sponsor_names)); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class=" col-sm-12">
                                    <div class="sponsors">
                                        <span class="browse-label">Sponsor Type<?php if(sizeof($ad_sponsors) != 1) { echo("s"); }?>: </span>
                                        <?php echo(implode(", ", $ad_sponsor_types)); ?>
                                    </div>
                                </div>
                            </div>
                            <?php if(sizeof($ad_subjects) > 0) { ?>
                            <div class="row">
                                <div class=" col-sm-12">
                                    <div class="sponsors">
                                        <span class="browse-label">Subject<?php if(sizeof($ad_subjects) != 1) { echo("s"); }?>: </span>
                                        <?php echo(implode(", ", $ad_subjects)); ?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="row">
                                <div class=" col-sm-12">
                                    <div class="sponsors">
                                        <span class="browse-label">Air Count: </span>
                                        <?php echo($ad_air_count); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
        }
        ?>

        <div class="row page-content-row">
            <div class="col-xs-12 col-sm-6 col-lg-9 col-sm-offset-7 col-lg-offset-3">
                <div id="next" class="post-navigation-button"><?php next_posts_link( 'Page '.(max($pagination_index,1) + 1)." &gt;" ); ?></div>
                <div id="prev" class="post-navigation-button"><?php previous_posts_link( '&lt; Page '.($pagination_index - 1) ); ?></div>
            </div>
        </div>

        <?php
    } else {
        ?>
        <?php get_template_part('content', 'explore_candidates'); ?>
        <?php get_template_part('content', 'explore_sponsors'); ?>
        <?php get_template_part('content', 'explore_sponsor_types'); ?>
        <?php
    }
?>
</div>
<?php get_footer(); ?>

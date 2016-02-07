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
    </div>
</div>

<div id="browse-content" class="page-content">
<?php
    if(array_key_exists('q', $_GET)
    && trim($_GET['q']) != '') {
        $pagination_index = get_query_var('paged', 0);
        $query = $_GET['q'];
        $args= array(
            'posts_per_page' => 4,
            'paged' => $pagination_index
        );

        $wp_query = search_political_ads($query, $args);

        ?>
        <div id="search-results-total" class="row page-content-row">
            <div class="col-xs-12">
                <?php echo($wp_query->found_posts);?> Result<?php echo($wp_query->found_posts==1?'':'s'); ?> Found
            </div>
        </div>
        <div id="search-results">
        <?php
            while($wp_query->have_posts()) {
                $wp_query->the_post();
                $post_metadata = get_fields();
                $date_created = get_the_date('n/j/y');
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
                                        <a href="<?php the_permalink(); ?>"><?php echo(implode(", ", $ad_candidates)); ?> - <?php echo(($ad_first_seen == "--")?$date_created:$ad_first_seen); ?></a>
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

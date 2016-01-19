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
            <div class="col-xs-12 col-sm-10 col-md-10">
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
</div>

<div id="browse-content" class="page-content">
<?php
    if(array_key_exists('q', $_GET)
    && trim($_GET['q']) != '') {
        $pagination_index = get_query_var('page', 0);
        $query = $_GET['q'];
        $wp_query = search_political_ads($query);

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
                $metadata = get_fields();
                ?>
                <div class="row page-content-row political-ad">
                    <div>
                        <div class="col-xs-12 col-sm-6 col-lg-3">
                            <div class="embed">
                                <iframe frameborder="0" allowfullscreen src="<?php echo($metadata['embed_url']);?>" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-lg-9">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="title">
                                        <a href="<?php the_permalink(); ?>" target="_blank">
                                            <?php the_title(); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class=" col-sm-12">
                                    <div class="sponsors">
                                        <span class="browse-label">Sponsor<?php if(sizeof($metadata['ad_sponsors']) != 1) { echo("s"); }?>: </span>
                                        <?php echo(generate_sponsors_string($metadata['ad_sponsors'])); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <class="candidates">
                                        <span class="browse-label">Candidate<?php if(sizeof($metadata['ad_candidates']) != 1) { echo("s"); }?>: </span>
                                        <?php  echo(generate_candidates_string($metadata['ad_candidates'])); ?>
                                    </class="candidates">
                                </div>
                            </div>
                            <div class="row">
                                <div class="hidden-xs col-sm-12">
                                    <div class="cell-multiline-value">
                                       <?php echo($metadata['ad_notes']);?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
        }
    } else {
        ?>
        <?php get_template_part('content', 'explore_candidates'); ?>
        <?php get_template_part('content', 'explore_sponsors'); ?>
        <?php get_template_part('content', 'explore_sponsor_types'); ?>
        <?php
      // TODO: sorry no results lulz
    }
?>
</div>
<?php get_footer(); ?>

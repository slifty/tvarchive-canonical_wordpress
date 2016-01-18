<?php get_header(); ?>
    <div id="home-header" class="row">
        <div id="home-header-content">
            <div id="home-header-introduction">
                <div id="home-header-title" class="col-xs-12">
                    <?php the_field('home_header', 'option'); ?>
                </div>

                <div id="home-header-explanation" class="col-xs-12 col-md-12 ">
                    <?php the_field('home_description', 'option'); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="home-header-search">
            <div class="col-xs-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 home-header-search-formfield">
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>


    <div  id="home-feature-section" class="row">
        <div  class="col-xs-12 col-sm-12 col-md-4">
            <?php get_template_part('content', 'home_blog_posts'); ?>
        </div>
        <div id="ad-embed_home" class="hidden-xs hidden-sm col-md-8">
            <?php get_template_part('content', 'home_canonical_ad'); ?>
        </div>

    </div>

    <div id="home-explore-header" class="row header-row">
        <div class="col-xs-12 col-md-12">
            <h1>Explore the Collection</h1>
        </div>
    </div>
    <div id="home-explore-section">
        <?php get_template_part('content', 'candidates'); ?>
        <?php get_template_part('content', 'sponsors'); ?>
    </div>

    <?php get_footer(); ?>

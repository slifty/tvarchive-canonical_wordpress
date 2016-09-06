<?php get_header(); ?>
    <div id="home-header-section" class="row guttered-row">
        <div id="home-header-content">
            <div id="home-header-introduction">
                <div class="col-md-12 col-lg-4">
                    <h1 id="home-header-title">Political ads broadcast <span class="total-airing-count">175,515 times</span> over <span class="total-market-count">23 markets</span></h1>
                </div>
                <div id="home-header-explanation" class="col-md-12 col-lg-8">
                    <?php the_field('home_description', 'option'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row guttered-row">
        <div class="col-xs-12">
            <hr />
        </div>
    </div>

    <div class="row">
        <div id="home-market-map-section">
            <div class="col-xs-12">
                <?php get_template_part('content', 'home_market_map'); ?>
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


    <div id="home-feature-section" class="row guttered-row">
        <div class="col-xs-12 col-sm-12 col-md-4">
            <?php get_template_part('content', 'home_blog_posts'); ?>
        </div>
        <div id="ad-embed_home" class="col-md-8 col-sm-12">
            <?php get_template_part('content', 'home_canonical_ad'); ?>
        </div>
    </div>
    <div id="home-explore-header" class="row guttered-row">
        <div class="col-xs-12 col-md-12">
            <h2 class="section-header">Explore the Collection</h2>
        </div>
    </div>
    <div id="home-explore-facts-section" class="row guttered-row">
      <div class="col-xs-12 col-md-12">
        <br />
        <?php get_template_part('content', 'explore_factchecks'); ?>
      </div>
    </div>
    <?php get_footer(); ?>

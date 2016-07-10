<?php get_header(); ?>
    <div id="home-header-section" class="row">
        <div id="home-header-content">
            <div id="home-header-introduction">
                <div id="home-header-title" class="col-sm-12 col-md-4">
                    <h1>Political ads broadcast <span class="total-airing-count">175,515 times</span> over <span class="total-market-count">23 markets</span></h1>
                </div>
                <div id="home-header-explanation" class="col-sm-12 col-md-8">
                    <?php the_field('home_description', 'option'); ?>
                </div>
            </div>
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


    <div  id="home-feature-section" class="row">
        <div  class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
            <?php get_template_part('content', 'home_blog_posts'); ?>
        </div>
        <div id="ad-embed_home" class="hidden-xs hidden-sm hidden-md col-lg-8">
            <?php get_template_part('content', 'home_canonical_ad'); ?>
        </div>

    </div>

    <div id="home-explore-header" class="row header-row">
        <div class="col-xs-12 col-md-12">
            <h1>Explore the Collection</h1>
        </div>
    </div>
    <div id="home-explore-tabs" class="row explore-tab-row">
      <div class="col-xs-12 col-md-12">
        <ul class="nav nav-tabs" id="explore-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#candidates" aria-controls="candidates" role="tab" data-toggle="tab">By Candidate</a></li>
          <li role="presentation"><a href="#sponsors" aria-controls="sponsors" role="tab" data-toggle="tab">By Sponsor</a></li>
          <li role="presentation"><a href="#sponsorTypes" aria-controls="sponsorTypes" role="tab" data-toggle="tab">By Sponsor Type</a></li>
        </ul>
      </div>
    </div>
    <div id="home-explore-section" class="row">
      <div class="col-xs-12 col-md-12">
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="candidates">
            <?php get_template_part('content', 'explore_candidates'); ?>
          </div>
          <div role="tabpanel" class="tab-pane" id="sponsors">
            <?php get_template_part('content', 'explore_sponsors'); ?>
          </div>
          <div role="tabpanel" class="tab-pane" id="sponsorTypes">
            <?php get_template_part('content', 'explore_sponsor_types'); ?>
          </div>
        </div>
      </div>
    </div>

    <?php get_footer(); ?>

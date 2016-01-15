<?php get_header(); ?>
    <div id="home-header" class="row">
        <div id="home-header-content">
            <div id="home-header-introduction">
                <div id="home-header-title" class="col-xs-12">
                    Call to action it’s action packed
                </div>

                <div id="home-header-explanation" class="col-xs-12 col-md-12 ">
                    <p>Gumbo beet greens corn soko endive gumbo gourd. Parsley shallot courgette tatsoi pea sprouts fava bean collard greens dandelion okra wakame tomato. Dandelion cucumber earthnut pea peanut soko zucchini.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end home header-->
    <div class="row">
        <div id="home-header-search">
            <div class="col-xs-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 home-header-search-formfield">
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
    <!-- end searchr-->

<div  id="home-feature-section" class="row">
	<div  class="col-xs-12 col-sm-12 col-md-4">
        <?php get_template_part('content', 'home_blog_posts'); ?>
	</div>
    <div id="ad-embed_home" class="hidden-xs hidden-sm col-md-8">
        <?php get_template_part('content', 'home_canonical_ad'); ?>
    </div>
    
</div>
    <!-- end home feature-->

    <div id="home-explore-header" class="row header-row">
        <div class="col-xs-12 col-md-12">
            <h1>Explore the Collection</h1>
        </div>
    </div>
    <div id="home-explore-section">

        <?php get_template_part('content', 'sponsors'); ?>
            <?php get_template_part('content', 'canidates'); ?>

    </div>

    <?php get_footer(); ?>

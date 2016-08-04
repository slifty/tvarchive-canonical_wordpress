<?php
/*
    Template Name: Market Map
*/
?>
<?php get_header(); ?>
    <div id="market-map-header" class="row page-header-row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <h1 id="market-map-header-title" class="section-header">Market Map</h1>
            <p id="market-map-header-description">Browse Political TV Ads by Broadcast Market</p>
        </div>
    </div>
    <div id="market-map-header-section" class="row">
        <div class="col-xs-12 col-md-6 col-md-push-3">
            <div id="market-map-title">
                <h1>Political ads broadcast <br><span class="total-airing-count"></span> over <span class="total-market-count"></span></h1>
            </div>
            <p>Pea horseradish azuki bean lettuce avocado asparagus okra. Kohlrabi radish okra azuki bean corn fava bean mustard tigernut jicama green bean celtuce collard greens avocado quandong fennel gumbo black-eyed pea. Grape silver beet watercress potato tigernut corn groundnut. </p>
        </div>
    </div>
    <div class="row">
        <div id="market-map-section">
            <div class="col-xs-12">
                <?php get_template_part('content', 'home_market_map'); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="most-aired-ads-section">
            <div class="col-xs-12">
                <?php get_template_part('content', 'market_map_ads'); ?>
            </div>
        </div>
    </div>


    <?php get_footer(); ?>

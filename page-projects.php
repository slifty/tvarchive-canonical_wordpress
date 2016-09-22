<?php
/*
    Template Name: Projects
*/
?>
<?php get_header(); ?>

<div id="download-header" class="row page-header-row guttered-row">
    <div class="col-xs-12 col-sm-6 col-md-6">
        <h1 id="data-header-title" class="section-header">2016 Presidential Debates</h1>
        <p id="data-header-description">Giving the public tools to track and analyze debates</p>
    </div>
</div>

<div id="data-content" class="page-content">


    <div class="row guttered-row" style="padding-bottom: 40px;">
        <div class="col-xs-12 col-md-12">
            <div><?php echo(get_field('project_about')); ?></div>
        </div>
    </div>


    <div class="row debate-header guttered-row">
        <div class="col-xs-12 col-md-12">
            <h2 class="section-header">Watch the Debates</h2>
        </div>
    </div>

    <div id="debate-embed" class="row">
        <iframe id="ad-embed-iframe" class="col-xs-12" frameborder="0" allowfullscreen src="<?php echo($ad_embed_url);?>&nolinks=1" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
    </div>

    <div class="row debate-header guttered-row">
        <div class="col-xs-12">
            <h2 class="section-header">Download the Data</h2>
        </div>
    </div>

    <div class="row guttered-row" style="padding-top: 40px;padding-bottom: 20px;">
        <div class="col-xs-12">
            <p>Download data on news coverage of debates.</p>
        </div>
    </div>

    <div class="row guttered-row">
        <div class="col-xs-12">
            <div class="data-download-group-container">
                <h2 class="debate-title">First Debate: September 26, 2016</h2>
                <div class="row">
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="" class="btn primary data-download__button" target="_blank">Raw Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="" class="btn primary data-download__button" target="_blank">Frequency Timeline</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="" class="btn primary data-download__button" target="_blank">Summarized Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--    End Main Page Content-->

</div>

<?php get_footer(); ?>

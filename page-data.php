<?php
/*
    Template Name: Data
*/
?>
<?php get_header(); ?>

<div id="download-header" class="row page-header-row">
    <div class="col-xs-12 col-sm-6 col-md-6">
        <h1 id="download-header-title" class="section-header">Data Download</h1>
        <p id="download-header-description">Put the Archive to Work</p>
    </div>
</div>

<div id="data-content" class="page-content">
    <div id="download-content" class="">
        <div class="row page-content-row">
            <div class="col-xs-12 col-md-12">
                <h2>About the Dataset</h2>
                <div><?php echo(get_field('about_the_data', 'options')); ?></div>
            </div>
        </div>

        <div class="row page-content-row">
            <div class="col-xs-12 col-md-12">
                <form method="get" action="<?php bloginfo('url'); ?>/instance_export" target="_blank">
                    <div class="download-btn">
                        <input type="submit" id="download-data-button" class="button" value="Download details of ad airings on TV" />
                    </div>
                </form>
            </div>
        </div>
        <div class="row page-content-row">
            <div class="col-xs-12 col-md-12">
                <form method="get" action="<?php bloginfo('url'); ?>/ad_export" target="_blank">
                    <div class="download-btn">
                        <input type="submit" id="download-data-button" class="button" value="Download list of unique ads archived" />
                    </div>
                </form>
            </div>
        </div>

        <?php
            $wide_cells = get_field('wide_data_cells');
            if(is_array($wide_cells)) {
                foreach($wide_cells as $cell) {
                    ?>
                    <div class="row page-content-row">
                        <div class="col-xs-12 col-lg-12">
                            <h2><?php echo($cell['cell_header']); ?></h2>
                            <div><?php echo($cell['cell_content']); ?></div>
                        </div>
                    </div>
                    <?php
                }
            }

        ?>
    </div>
    <!--    End Main Page Content-->

</div>

<?php get_footer(); ?>

<?php
/*
    Template Name: About
*/
?><?php get_header(); ?>

<?php print_r(get_sponsor_metadata()); die(); ?>

<div id="about-header" class="row page-header-row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
        <h1 id="about-header-title" class="section-header">About</h1>
        <p id="about-header-description">About the Political Ad Library and T.V. News</p>
    </div>
</div>
<div id="about-content" class="page-content">
    <?php
        $wide_cells = get_field('wide_about_cells');
        $narrow_cells = get_field('narrow_about_cells');

        if(is_array($wide_cells)) {
            foreach($wide_cells as $cell) {
                ?>
                <div class="row page-content-row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h2><?php echo($cell['cell_header']); ?></h2>
                        <div><?php echo($cell['cell_content']); ?></div>
                    </div>
                </div>
                <?php
            }
        }

        if(is_array($narrow_cells)) {
            $cleanup = "";
            foreach($narrow_cells as $index => $cell) {
                if($index % 3 == 0) {
                    ?>
                    <div class="row page-content-row">
                    <?php
                    $cleanup = "</div>";
                }
                ?>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <h2><?php echo($cell['cell_header']); ?></h2>
                    <div><?php echo($cell['cell_content']); ?></div>
                </div>
                <?php
                if($index %3 == 2) {
                    ?>
                    </div>
                    <?php
                    $cleanup = "";
                }
            }
            echo($cleanup);
        }
    ?>
</div>

<?php get_footer(); ?>

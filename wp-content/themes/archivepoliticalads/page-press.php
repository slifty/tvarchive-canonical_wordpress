<?php
/*
    Template Name: Press
*/
?><?php get_header(); ?>

<div id="press-header" class="row page-header-row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
        <h1 id="press-header-title" class="section-header">Press</h1>
        <p id="press-header-description">Explore news that is using our data</p>
    </div>
</div>
<div id="press-list" class="page-content">

    <div class="row page-content-row">
        <div class="col-xs-12">
            <h2>Press Mentions</h2>
            <ul id="press-mentions">
                <?php
                    $articles = get_field('articles');
                    if(is_array($articles)) {
                        foreach($articles as $article) {
                            ?>
                            <li class="article"><a href="<?php echo($article['link']); ?>" target="_blank" class="title"><?php echo($article['headline']); ?></a> - <span class="source"><?php echo($article['source']); ?></span> <span class="date">(<?php echo($article['publication_date']); ?>)</span></li>
                            <?php
                        }
                    }
                ?>
            </ul>
        </div>
    </div>

</div>

<div id="press-subheader" class="row page-subheader-row">
    <div class="col-lg-6">
        <h2>Visualization Gallery</h2>
    </div>
</div>

<div id="press-gallery" class="page-content">
    <div class="row page-content-row">
        <?php
            $articles = get_field('articles');
            if(is_array($articles)) {
                foreach($articles as $article) {
                    if(array_key_exists('visualization', $article)
                    && $article['visualization']) {
                        ?>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                            <div class="press-visualization">
                                <a href="<?php echo($article['link']); ?>" target="_blank"><img src="<?php echo($article['visualization']['url']); ?>" /></a>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
        ?>
    </div>
</div>


<?php get_footer(); ?>

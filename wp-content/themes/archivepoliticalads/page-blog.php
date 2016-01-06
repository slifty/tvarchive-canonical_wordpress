<?php 
/* 
Template Name: Blog Page
*/
?>
    <?php get_header(); ?>

        <div id="blog-header" class="row page-header-row">
            <div class="col-xs-12 col-lg-6 ">
                <h1 id="blog-header-title" class="section-header">Blog</h1>
                <p id="blog-header-description">Dispatches from the TV News Team</p>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-8  blog-main">

                <?php
            $pagination_index = get_query_var('page', 0);

            $args = array(
                'posts_per_page'   => 4,
                'offset'           => $pagination_index * 3);

            $posts = get_posts($args);
                if ( sizeof($posts) > 0 ) {
            $has_more = false;
                if(sizeof($posts) == 4) {
            $has_more = true;
                array_pop($posts);
            }

            $blog_permalink = get_permalink();
                foreach ($posts as $post){
                    setup_postdata( $post );
        ?>

                    <div class="post">
                        <h2 class="post-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                        <p class="post-date">
                            <?php the_time('F j, Y'); ?>
                        </p>
                        <?php if( get_the_post_thumbnail() ) : ?>
                            <div class="img-container thumbnail">
                                <?php the_post_thumbnail('thumbnail', array( 'class' => 'post-img' ) ); ?>
                            </div>
                            <?php endif; ?>
                                <div class="post-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                                <div class="post-more"><a href="<?php the_permalink();?>">Read More</a></div>
                    </div>
                    <!-- /.blog-post -->

                    <?php
                    }
                ?>


                        <!-- /pagination -->
                        <div id="post-navigation" class="row">
                            <div id="prev" class="col-xs-12 col-md-2 post-navigation-button">

                                <?php
                        if($pagination_index > 0) {
                    ?>
                                    <a href="<?php echo($blog_permalink.($pagination_index - 1));?>">Previous</a>
                                    <?php
                            }
                        ?>
                            </div>
                            <div id="next" class="col-xs-12 col-md-offset-4 col-md-2 post-navigation-button">
                                <?php
                    if($has_more) { ?>
                                    <a href="<?php echo($blog_permalink.($pagination_index + 1));?>">Next</a>
                                    <?php } ?>
                            </div>
                        </div>
                        <!-- /end pagination -->
                        <?php
                } else {
                        // If no content, let the user know
                    ?>
                            There aren't any posts yet.
                            <?php
                      };
                ?>
            </div>
            <!-- /.blog-main -->

            <!-- /start sidebar -->
            <div class="col-xs-12 col-sm-4  blog-sidebar hidden-xs">
                <div class="sidebar-module sidebar-module-inset">
                    <div class="sidebar-module">
                        <?php get_sidebar( ); ?>
                    </div>
                </div>
            </div>
            <!-- /end sidebar -->

        </div>
        <!-- /.row -->

        <?php get_footer(); ?>

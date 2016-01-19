<div class="row">
    <?php
        $featured_posts = get_field('featured_posts', 'option');
        foreach($featured_posts as $featured_post) {
            global $post;
            $post = $featured_post;
            setup_postdata($featured_post);
            ?>
            <div class="post_home col-xs-12 col-sm-12 col-md-4 col-lg-12">
                <div class="post_home_inner">
                    <h2 class="post-title_home"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <p class="post-date">
                        <?php the_time('F j, Y'); ?>
                    </p>
                    <?php
                        if( get_the_post_thumbnail() ) {
                            $src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'frontpage-thumb' );
                            ?>
                            <div class="img-fluid">
                                <img src="<?php echo($src[0]);?>" class="post-img_home"/>
                            </div>
                            <?php
                        }
                        remove_filter('the_excerpt', 'wpautop');
                    ?>
                    <p class="post-excerpt">
                        <?php the_excerpt(); ?>
                    </p>
                </div>
            </div>

            <?php
        }
        wp_reset_postdata();
    ?>
</div>

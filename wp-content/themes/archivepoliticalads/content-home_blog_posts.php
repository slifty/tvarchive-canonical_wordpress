<?php
    $featured_posts = get_field('featured_posts', 'option');
    foreach($featured_posts as $featured_post) {
        global $post;
        $post = $featured_post;
        setup_postdata($featured_post);
        ?>
        <div class="post_home">
            <h2 class="post-title_home"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <p class="post-date">
                <?php the_time('F j, Y'); ?>
            </p>
            <?php
                if( get_the_post_thumbnail() ) {
                    ?>
                    <div class="img-fluid post-img_home">
                        <?php the_post_thumbnail( 'frontpage-thumb', array( 'class' => 'post-img_home' ) ); ?>
                    </div>
                    <?php
                }
                remove_filter('the_excerpt', 'wpautop');
            ?>
            <p class="post-excerpt">
                <?php the_excerpt(); ?>
            </p>
        </div>

        <?php
    }
    wp_reset_postdata();
?>

<?php 
$num_posts = ( is_front_page() ) ? 1 : -1;
    $args = array(
    'post_type' => 'post',
    'posts_per_page' => $num_posts
    );
$query = new WP_Query( $args );
?>

    <?php if( $query->have_posts() ) : while( $query->have_posts() ) : $query->the_post(); ?>
        <div class="post post_home">
            <h2 class="post-title_home"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <p class="post-date">
                <?php the_time('F j, Y'); ?>
            </p>
            <?php if( get_the_post_thumbnail() ) : ?>
                <div>
                    <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'post-img_home' ) ); ?>
                </div>
                <?php endif; ?>
                    <?php remove_filter('the_excerpt', 'wpautop'); ?>
                        <p class="post-excerpt">
                            <?php the_excerpt(); ?>
                        </p>
        </div>

        <?php endwhile; endif; wp_reset_postdata(); ?>

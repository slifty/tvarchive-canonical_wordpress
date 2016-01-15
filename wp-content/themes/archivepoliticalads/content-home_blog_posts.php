<?php 
$num_posts = ( is_front_page() ) ? 3 : -1;
    $args = array(
    'post_type' => 'post',
    'cat' => 'featured',
    'posts_per_page' => $num_posts
    );
$query = new WP_Query( $args );
?>

    <?php if( $query->have_posts() ) : while( $query->have_posts() ) : $query->the_post(); ?>
        <div class="post_home">
            <h2 class="post-title_home"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <p class="post-date">
                <?php the_time('F j, Y'); ?>
            </p>
            <?php if( get_the_post_thumbnail() ) : ?>
                <div class="img-fluid post-img_home">
                    <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'post-img_home' ) ); ?>
                </div>
                <?php endif; ?>
                    <?php remove_filter('the_excerpt', 'wpautop'); ?>
                        <p class="post-excerpt">
                            <?php the_excerpt(); ?>
                        </p>
        </div>



<!--

        <div class="home-feature-section_post col-xs-12 col-sm-4 col-md-4">
         
        </div>
        <div class="home-feature-section_post col-xs-12 col-sm-4 hidden-md hidden-lg">
           
        </div>
        <div class="home-feature-section_post col-xs-12 col-sm-4  hidden-md hidden-lg">
            
        </div>
-->

        <?php endwhile; endif; wp_reset_postdata(); ?>

<?php
/**
 * The Footer Sidebar
 *
 */

if ( ! is_active_sidebar( 'sidebar-3' ) ) {
	return;
}
?>

    <div id="supplementary">
        <div id="footer-sidebar" class="footer-sidebar widget-area" role="complementary">
        	<h3>Recent Blog Posts</h3>
            <?php
				$postslist = get_posts('numberposts=2&order=ASC&orderby=title');
				foreach ($postslist as $post) :
				setup_postdata($post);
				?>
				<div class="footer-recent-post_title">
				<a id="footer-sidebar-link" href="<?php the_permalink();?>"><?php the_title(); ?></a>
				</div>
				<div class="footer-recent-post_date">
				<?php the_date(); ?>
				</div>
				<div class="footer-recent-post_excerpt">
				<?php the_excerpt(); ?>
				</div>
			<?php endforeach; ?>
        </div>
        
        <!-- #footer-sidebar -->
    </div> 
    <!-- #supplementary -->

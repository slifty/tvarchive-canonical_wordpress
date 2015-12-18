<?php get_header(); ?>

<div id="blog-header" class="row page-header-row">
	<div class="col-lg-6">
		<h1 id="blog-header-title" class="section-header">Blog</h1>
		<p id="blog-header-description">Dispatches from the TV News Team</p>
	</div>
</div>

<div id="blog-content" class="page-content">
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
				<div class="row">
					<div class="col-lg-12">
						<div class="post">
							<div class="post-title"><h2><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2></div>
							<div class="post-date"><?php the_time('F j, Y'); ?></div>
							<div class="post-excerpt"><?php the_excerpt(); ?></div>
							<div class="post-more"><a href="<?php the_permalink();?>">Read More</a></div>
						</div>
					</div>
				</div>
				<?php
			}
			?>
			<div id="post-navigation" class="row">
				<div id="prev" class="col-lg-2 post-navigation-button">
					<?php
					if($pagination_index > 0) {
						?>
						<a href="<?php echo($blog_permalink.($pagination_index - 1));?>">Previous</a>
						<?php
					}
					?>
				</div>
				<div id="next" class="col-lg-offset-8 col-lg-2 post-navigation-button">
					<?php
					if($has_more) {
						?>
						<a href="<?php echo($blog_permalink.($pagination_index + 1));?>">Next</a>
						<?php
					}
					?>
				</div>
			</div>
			<?php
		} else {
			// If no content, let the user know
			?>
			There aren't any posts yet.
			<?php
		};
	?>
</div>

<?php get_footer(); ?>

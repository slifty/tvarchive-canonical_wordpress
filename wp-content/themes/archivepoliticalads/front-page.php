<?php get_header(); ?>

<div id="home-header">
	<div id="home-header-content">
		<div id="home-header-introduction">
			<div id="home-header-title">
				Call to action it’s action packed
			</div>
			<div id="home-header-explanation">
				Gumbo beet greens corn soko endive gumbo gourd. Parsley shallot courgette tatsoi pea sprouts fava bean collard greens dandelion okra wakame tomato. Dandelion cucumber earthnut pea peanut soko zucchini.
			</div>
		</div>
		<div id="home-header-search">
			<div class="col-sm-8 col-sm-offset-2"><?php get_search_form('YOLO'); ?></div>
		</div>
	</div>
</div>

<div id="home-blog-section" class="row">
	<div class="col-lg-12">
		
	</div>
</div>
<div id="home-explore-header" class="row header-row">
	<div class="col-lg-12">
		<h1>Explore the Collection</h1>
	</div>
</div>
<div id="home-explore-section">
	<?php get_template_part('explore'); ?>
</div>

<?php get_footer(); ?>

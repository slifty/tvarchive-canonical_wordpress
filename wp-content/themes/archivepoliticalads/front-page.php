<?php

get_header(); ?>

<div id="home-header">
	<div id="home-header-content">
		<div id="home-header-introduction">
			<div class="row">
				<div id="home-header-title" class="col-lg-5">
					Call to action it’s action packed
				</div>
			</div>
			<div class="row">
				<div id="home-header-explanation" class="col-lg-6">
					Gumbo beet greens corn soko endive gumbo gourd. Parsley shallot courgette tatsoi pea sprouts fava bean collard greens dandelion okra wakame tomato. Dandelion cucumber earthnut pea peanut soko zucchini.
				</div>
			</div>
		</div>
		<div id="home-header-search">
			<div class="col-sm-8 col-sm-offset-2"><?php get_search_form('YOLO'); ?></div>
		</div>
	</div>
</div>
<div id="home-blog-section" class="row">
	<div class="col-sm-12">
		Blog posts will go here
	</div>
</div>
<div id="home-explore-header" class="row header-row">
	<h1>Explore the Collection</h1>
</div>
<div id="home-explore-section">
	<?php get_template_part('explore'); ?>
</div>

<?php get_footer(); ?>

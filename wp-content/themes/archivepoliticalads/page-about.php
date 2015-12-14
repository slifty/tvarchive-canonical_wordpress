<?php get_header(); ?>

<div id="about-header">
	<div class="row">
		<h1 id="about-header-title" class="col-lg-12">About</h1>
	</div>
	<div class="row">
		<p id="about-header-description" class="col-lg-12">About the Political Ad Library and T.V. News</p>
	</div>
</div>

<div id="about-content">
	<div class="row">
		<div class="col-lg-12">
			<h2><?php echo(get_field('about_header')); ?></h2>
			<p><?php echo(get_field('about_header_content')); ?></p>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4">
			<h2><?php echo(get_field('about_subheader_1')); ?></h2>
			<p><?php echo(get_field('about_subheader_1_content')); ?></p>
		</div>
		<div class="col-lg-4">
			<h2><?php echo(get_field('about_subheader_2')); ?></h2>
			<p><?php echo(get_field('about_subheader_2_content')); ?></p>
		</div>
		<div class="col-lg-4">
			<h2><?php echo(get_field('about_subheader_3')); ?></h2>
			<p><?php echo(get_field('about_subheader_3_content')); ?></p>
		</div>
	</div>
</div>

<?php get_footer(); ?>

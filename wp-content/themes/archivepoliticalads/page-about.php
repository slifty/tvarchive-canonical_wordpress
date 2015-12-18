<?php get_header(); ?>

<div id="about-header" class="row page-header-row">
	<div class="col-lg-6">
		<h1 id="about-header-title" class="section-header">About</h1>
		<p id="about-header-description">About the Political Ad Library and T.V. News</p>
	</div>
</div>

<div id="about-content" class="page-content">
	<div class="row page-content-row">
		<div class="col-lg-12">
			<h2><?php echo(get_field('about_header')); ?></h2>
			<p><?php echo(get_field('about_header_content')); ?></p>
		</div>
	</div>
	<div class="row page-content-row">
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

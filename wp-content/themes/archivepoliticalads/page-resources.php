<?php get_header(); ?>

<div id="resources-header">
	<div class="row">
		<h1 id="resources-header-title" class="col-lg-12">Resources</h1>
	</div>
	<div class="row">
		<p id="resources-header-description" class="col-lg-12">Our partners and additional scholarly resources</p>
	</div>
</div>

<div id="partners-content">
	<div id="partners-logos" class="row">
		<div class="col-lg-12">
			<ul>
				<?php 
					$partners = get_field('partners');
					if(sizeof($partners) == 0)
					{

					}
					else
					{
						foreach($partners as $partner)
						{
							?>
							<li><img src='<?php echo($partner['partner_logo']['url']);?>' /></li>
							<?php
						}
					}
				?>
			</ul>
			<h2>Our Partners</h2>
			<p><?php echo(get_field('partners_description')); ?></p>
		</div>
	</div>
</div>
<div id="resources-content">
	<?php 
		$resources = get_field('resources');
		if(sizeof($resources) > 0)
		{
			$resource = array_shift($resources);
			?>
			<div class="row" id="featured-resource">
				<div class="col-lg-12">
					<h2 class="resource-name"><?php echo($resource['resource_name']); ?></h2>
					<p class="resource-description"><?php echo($resource['resource_description']); ?></p>
					<img src='<?php echo($resource['resource_image']['url']);?>' class="resource-image"/>
					<div class="resource-link"><a href="<?php echo($resource['resource_link']); ?>" target="_blank">Link</a></div>
				</div>
			</div>
			<?php
		}

		while(sizeof($resources) > 0)
		{
			?>
			<div class="row">
			<?php
				for($x = 0; $x < 3; $x++)
				{
					if(sizeof($resources) == 0)
						continue;
					$resource = array_shift($resources);
					?>
					<div class="col-lg-4">
						<h2 class="resource-name"><?php echo($resource['resource_name']); ?></h2>
						<p class="resource-description"><?php echo($resource['resource_description']); ?></p>
						<img src='<?php echo($resource['resource_image']['url']);?>' class="resource-image"/>
						<div class="resource-link"><a href="<?php echo($resource['resource_link']); ?>" target="_blank">Link</a></div>
					</div>
					<?php
				}
			?>
			</div>
			<?php
		}
	?>
</div>

<?php get_footer(); ?>

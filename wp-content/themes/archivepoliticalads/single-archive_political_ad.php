<?php get_header(); ?>

<main>
<?php
// Start the loop.
while ( have_posts() ) : the_post();
	$post_id = get_the_ID();
	$post_metadata = get_ad_metadata($post_id);

	$ad_embed_url = $post_metadata['embed_url'];
	$ad_notes = $post_metadata['notes'];
	$ad_id = $post_metadata['ad_id'];
	$ad_sponsor = $post_metadata['ad_sponsor'];
	$ad_candidate = $post_metadata['ad_candidate'];
	$ad_type = $post_metadata['ad_type'];
	$ad_race = $post_metadata['ad_race'];
	$ad_message = $post_metadata['ad_message'];
	$ad_air_count = $post_metadata['ad_air_count'];
	$ad_market_count = $post_metadata['ad_market_count'];
	$ad_network_count = $post_metadata['ad_network_count'];
	$ad_first_seen = $post_metadata['ad_first_seen'];
	$ad_last_seen = $post_metadata['ad_last_seen'];

	?>

	<div id="ad-embed" class="row">
		<iframe id="ad-embed-iframe" class="col-lg-12" frameborder="0" allowfullscreen src="<?php echo($ad_embed_url);?>" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
	</div>

	<div id="about-ad-header" class="header-row row">
		<div class="col-lg-12">
			<h1>About This Ad</h1>
		</div>
	</div>

	<div class="row about-ad-row">
		<div id="ad-sponsor" class="first cell">
			<div class="cell-label">Sponsor</div>
			<div class="cell-value"><?php echo($ad_sponsor);?></div>
		</div>
		<div id="ad-candidate" class="cell">
			<div class="cell-label">Candidate</div>
			<div class="cell-value"><?php echo($ad_candidate);?></div>
		</div>
		<div id="ad-type" class="cell">
			<div class="cell-label">Ad Type</div>
			<div class="cell-value"><?php echo($ad_type);?></div>
		</div>
		<div id="ad-race" class="cell">
			<div class="cell-label">Race</div>
			<div class="cell-value"><?php echo($ad_race);?></div>
		</div>
		<div id="ad-message" class="last cell">
			<div class="cell-label">Message</div>
			<div class="cell-value"><?php echo($ad_message);?></div>
		</div>
	</div>

	<div class="row about-ad-row">
		<div id="ad-note" class="first last cell">
			<div class="cell-label">Note</div>
			<div class="cell-multiline-value"><?php echo($ad_notes);?></div>
		</div>
	</div>

	<div class="row about-ad-row">
		<div id="ad-air-count" class="first cell">
			<div class="cell-label">Number of Times Aired</div>
			<div class="cell-value"><?php echo($ad_air_count);?></div>
		</div>
		<div id="ad-market-count" class="cell">
			<div class="cell-label">Markets Aired In</div>
			<div class="cell-value"><?php echo($ad_market_count);?></div>
		</div>
		<div id="ad-network-count" class="cell">
			<div class="cell-label">Networks Aired On</div>
			<div class="cell-value"><?php echo($ad_network_count);?></div>
		</div>
		<div id="ad-first-aired" class="cell">
			<div class="cell-label">This Ad First Aired On</div>
			<div class="cell-value"><?php echo($ad_first_seen);?></div>
		</div>
		<div id="ad-last-aired" class="last cell">
			<div class="cell-label">This Ad Last Aired On</div>
			<div class="cell-value"><?php echo($ad_last_seen);?></div>
		</div>
	</div>

	<div class="row last about-ad-row">
		<div id="ad-learn" class="cell first last">
			<div class="cell-label">Learn More About This Ad On Archive.org</div>
			<div class="cell-value"><a href="http://www.archive.org/details/<?php echo($ad_id);?>">www.archive.org/details/<?php echo($ad_id);?></a></div>
		</div>
	</div>

	<div id="download-header" class="header-row row">
		<div class="col-lg-12">
			<h1>Download</h1>
		</div>
	</div>

	<div class="row download-row">
		<div id="download-about" class="cell first last">
			<div class="cell-label">About the Dataset</div>
			<div class="cell-multiline-value">Gumbo beet greens corn soko endive gumbo gourd. Parsley shallot courgette tatsoi pea sprouts fava bean collard greens dandelion okra wakame tomato. Dandelion cucumber earthnut pea peanut soko zucchini. Turnip greens yarrow ricebean rutabaga endive cauliflower sea lettuce kohlrabi amaranth water spinach avocado daikon napa cabbage asparagus winter purslane kale. </div>
		</div>
	</div>

	<div id="download-subheader" class="subheader-row row">
		<div class="col-lg-12">
			<h2>Download Data About this Ad</h2>
		</div>
	</div>

	<div class="row download-row">
		<div id="download-data" class="cell first last">
			<div class="cell-label">Download Data About this Ad</div>
			<div class="cell-multiline-value">Choose the fields you would like included below:</div>
		</div>
	</div>
	<form method="get" action="<?php bloginfo('url'); ?>/export" target="_blank">
		<div class="row download-row">
			<div class="col-lg-4">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="data_include[]" value="location" checked="checked"> Location Data
					</label>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="data_include[]" value="date" checked="checked"> Date Data
					</label>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="data_include[]" value="notes" checked="checked"> Notes
					</label>
				</div>
			</div>
		</div>
		<div class="row download-row">
			<div class="col-lg-4">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="data_include[]" value="station" checked="checked"> Station Information
					</label>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="data_include[]" value="time" checked="checked"> Time Data
					</label>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="data_include[]" value="metadata" checked="checked"> Item Metadata
					</label>
				</div>
			</div>
		</div>
		<div class="row download-row last">
			<div class="col-xs-offset-9 col-xs-3">

				<input type="hidden" name="ad_identifier" value="<?php echo($ad_id); ?>" />
				<input type="submit" id="download-data-button" class="button" value="Download CSV" />
			</div>
		</div>
	</form>


	<?php
// End the loop.
endwhile;
?>

</main>
<?php get_footer(); ?>

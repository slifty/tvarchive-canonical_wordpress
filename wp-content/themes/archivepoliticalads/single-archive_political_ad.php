<?php get_header(); ?>

<main>
<?php
// Start the loop.
while ( have_posts() ) : the_post();
	$post_id = get_the_ID();
	$ad_embed_url = get_post_meta( $post_id, '_archive_ad_embed_url', true );
	$ad_notes = get_post_meta( $post_id, '_archive_ad_notes', true );
	$ad_id = get_post_meta( $post_id, '_archive_ad_id', true );
	$ad_sponsor = get_post_meta( $post_id, '_archive_ad_sponsor', true );
	$ad_candidate = get_post_meta( $post_id, '_archive_ad_candidate', true );
	$ad_type = get_post_meta( $post_id, '_archive_ad_type', true );
	$ad_race = get_post_meta( $post_id, '_archive_ad_race', true );
	$ad_message = get_post_meta( $post_id, '_archive_ad_message', true );
	$ad_air_count = get_post_meta( $post_id, '_archive_ad_air_count', true );
	$ad_market_count = get_post_meta( $post_id, '_archive_ad_market_count', true );
	$ad_network_count = get_post_meta( $post_id, '_archive_ad_network_count', true );
	$ad_first_seen = get_post_meta( $post_id, '_archive_ad_first_seen', true );
	$ad_last_seen = get_post_meta( $post_id, '_archive_ad_last_seen', true );

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
	<form>
		<div class="row download-row">
			<div class="col-lg-4">
				<div class="checkbox">
					<label>
						<input type="checkbox"> Location Data
					</label>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="checkbox">
					<label>
						<input type="checkbox"> Date Data
					</label>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="checkbox">
					<label>
						<input type="checkbox"> Notes
					</label>
				</div>
			</div>
		</div>
		<div class="row download-row">
			<div class="col-lg-4">
				<div class="checkbox">
					<label>
						<input type="checkbox"> Station Information
					</label>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="checkbox">
					<label>
						<input type="checkbox"> Time Data
					</label>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="checkbox">
					<label>
						<input type="checkbox"> Item Metadata
					</label>
				</div>
			</div>
		</div>
		<div class="row download-row last">
			<div class="col-xs-offset-9 col-xs-3">
				<div id="download-data-button" class="button">
					Download CSV
				</div>
			</div>
		</div>
	</form>


	<?php
// End the loop.
endwhile;
?>

</main>
<?php get_footer(); ?>

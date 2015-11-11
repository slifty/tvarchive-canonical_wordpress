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

	<div class="row">
		<div id="about-ad-header" class="col-lg-12">
			About This Ad
		</div>
	</div>

	<div class="row about-ad-row">
		<div id="ad-sponsor" class="first about-ad-cell">
			<div class="about-ad-label">Sponsor</div>
			<div class="about-ad-value"><?php echo($ad_sponsor);?></div>
		</div>
		<div id="ad-candidate" class="about-ad-cell">
			<div class="about-ad-label">Candidate</div>
			<div class="about-ad-value"><?php echo($ad_candidate);?></div>
		</div>
		<div id="ad-type" class="about-ad-cell">
			<div class="about-ad-label">Ad Type</div>
			<div class="about-ad-value"><?php echo($ad_type);?></div>
		</div>
		<div id="ad-race" class="about-ad-cell">
			<div class="about-ad-label">Race</div>
			<div class="about-ad-value"><?php echo($ad_race);?></div>
		</div>
		<div id="ad-message" class="last about-ad-cell">
			<div class="about-ad-label">Message</div>
			<div class="about-ad-value"><?php echo($ad_message);?></div>
		</div>
	</div>

	<div class="row about-ad-row">
		<div id="ad-note" class="first last about-ad-cell">
			<div class="about-ad-label">Note</div>
			<div class="about-ad-value"><?php echo($ad_notes);?></div>
		</div>
	</div>

	<div class="row about-ad-row">
		<div id="ad-air-count" class="first about-ad-cell">
			<div class="about-ad-label">Number of Times Aired</div>
			<div class="about-ad-value"><?php echo($ad_air_count);?></div>
		</div>
		<div id="ad-market-count" class="about-ad-cell">
			<div class="about-ad-label">Markets Aired In</div>
			<div class="about-ad-value"><?php echo($ad_market_count);?></div>
		</div>
		<div id="ad-network-count" class="about-ad-cell">
			<div class="about-ad-label">Networks Aired On</div>
			<div class="about-ad-value"><?php echo($ad_network_count);?></div>
		</div>
		<div id="ad-first-aired" class="about-ad-cell">
			<div class="about-ad-label">This Ad First Aired On</div>
			<div class="about-ad-value"><?php echo($ad_first_seen);?></div>
		</div>
		<div id="ad-last-aired" class="last about-ad-cell">
			<div class="about-ad-label">This Ad Last Aired On</div>
			<div class="about-ad-value"><?php echo($ad_last_seen);?></div>
		</div>
	</div>

	<div class="row last about-ad-row">
		<div id="ad-learn" class="first last about-ad-cell">
			<div class="about-ad-label">Learn More About This Ad On Archive.org</div>
			<div class="about-ad-value"><a href="http://www.archive.org/details/<?php echo($ad_id);?>">www.archive.org/details/<?php echo($ad_id);?></a></div>
		</div>
	</div>
	<?php
// End the loop.
endwhile;
?>

</main>
<?php get_footer(); ?>

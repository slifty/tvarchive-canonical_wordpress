
<script type="text/javascript">

$(function() {
	$('.explore-list').owlCarousel({
		loop:true,
		responsive:{
			0:{
				items:1
			},
			600:{
				items:3
			},
			1000:{
				items:5
			}
		}
	})
});

</script>

<div id="explore-sponsors-title" class="row explore-subtitle-row">
	<div class="col-lg-12">
		<h3>Sponsors</h3>
		<p>Browse ads by sponsor</p>
	</div>
</div>

<div id="explore-sponsors-content" class="row explore-content-row">
	<div class="col-lg-12">
		<div class="explore-list">
			<?php
				// Get a list of sponsors
				$sponsors = get_sponsors();
				foreach($sponsors as $sponsor) {
					?>
					<div class="explore-item">
						<div class="explore-wrapper">
							<div class="explore-label"><?php echo($sponsor);?></div>	
						</div>
					</div>
					<?php
				}
			?>
		</div>
	</div>
</div>

<div id="explore-candidates-title" class="row explore-subtitle-row">
	<div class="col-lg-12">
		<h3>Candidates</h3>
		<p>Browse ads by candidate</p>
	</div>
</div>

<div id="explore-candidates-content" class="row explore-content-row">
	<div class="col-lg-12">
		<div class="explore-list">
			<?php
				// Get a list of sponsors
				$candidates = get_candidates();
				foreach($candidates as $candidate) {
					?>
					<div class="explore-item">
						<div class="explore-wrapper">
							<div class="explore-label"><?php echo($candidate);?></div>
						</div>
					</div>
					<?php
				}
			?>
		</div>
	</div>
</div>

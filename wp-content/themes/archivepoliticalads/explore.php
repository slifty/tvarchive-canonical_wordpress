<div id="explore-sponsors-title" class="row explore-subtitle-row">
	<div class="col-lg-12">
		<h3>Sponsors</h3>
		<p>Browse ads by sponsor</p>
	</div>
</div>

<div id="explore-sponsors-content" class="row explore-content-row">
	<?php
		// Get a list of sponsors
		$sponsors = get_sponsors();
	?>
</div>

<div id="explore-candidates-title" class="row explore-subtitle-row">
	<div class="col-lg-12">
		<h3>Candidates</h3>
		<p>Browse ads by candidate</p>
	</div>
</div>

<div id="explore-candidates-content" class="row explore-content-row">
	<?php
		// Get a list of sponsors
		$sponsors = get_candidates();
	?>
</div>

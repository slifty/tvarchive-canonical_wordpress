
<?php
	$past_query = htmlentities(stripslashes(array_key_exists('q',$_GET)?$_GET['q']:''));
?>
<form id="search-form" action="<?php bloginfo('url'); ?>/browse">
	<input type="text" name="q" id="search-text" value="<?php echo($past_query); ?>" placeholder="search for a sponsor, candidate or keyword" />
    <input type="hidden" id="search-form-order" name="order" value="count" />
</form>

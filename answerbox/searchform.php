<?php
/**
 * The template for displaying search form
 *
 * @package qa-guidable
 */
?>

<form class="navbar-form navbar-left" action="<?php ap_link_to('search'); ?>">
	<div class="form-group">
		<input type="text" name="s" class="form-control" value="<?php echo get_search_query(); ?>" id="s" placeholder="<?php _e('Search for question & answer') ?>">
	</div>	
	<button type="submit" class="btn i-search"></button>
</form>
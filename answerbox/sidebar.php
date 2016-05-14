<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package qa-guidable
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area col-md-3" role="complementary">
	<div class="side_banner">
		<a href="http://guidable.co/" target="_blank">
			<img src="<?php bloginfo('template_url' ); ?>/images/guidable_banner.jpg" alt="Guidable" class="img-responsive">
		</a>
	</div>
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->

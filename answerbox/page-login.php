<?php
/**
 * The template for displaying login pages.
 *
 * @package qa-guidable
 */

get_header(); ?>
<div class="container">
	<div class="row">
		<div id="primary" class="content-area col-md-12">
			<main id="main" class="site-main" role="main">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div>
</div>
<?php get_footer(); ?>

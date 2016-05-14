<?php
/*
Template Name: members
*/
if( ! is_user_logged_in() ){
	    auth_redirect();
	}
	?>
<?php get_header(); ?>

	<article>
				<main id="main" class="site-main" role="main">

					<?php while ( have_posts() ) : the_post(); ?>
						<?php the_content() ?>

					<?php endwhile; // end of the loop. ?>

				</main>
		</article>
<?php get_footer(); ?>

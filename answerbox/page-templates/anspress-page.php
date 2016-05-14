<?php
/**
 * Template Name: AnsPress page
 * The template for displaying all AnsPress pages
 * @package qa-guidable
 */

get_header(); ?>
	<div class="container">
		<div class="row">
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">

					<?php while ( have_posts() ) : the_post(); ?>
						<header class="entry-header">
							<h1 class="entry-title"><?php the_title(); ?></h1>
						</header>
						<?php the_content() ?>

					<?php endwhile; // end of the loop. ?>

				</main>
			</div>
		</div>
	</div>
<?php get_footer(); ?>

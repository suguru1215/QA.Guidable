<?php
/**
 * @package qa-guidable
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
	<div class="post-info pull-left">
		<a class="url fn n user-avatar" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
		</a>
		<span class="comment-number"><?php comments_number( __('0 Comment', 'ab'), __('1 Comment', 'ab'), __('% Comments', 'ab') ); ?></span>
		<?php if ( 'post' == get_post_type() ) : ?>
			<?php ab_posted_on(); ?>
		<?php endif; ?>
		<?php
			$categories_list = get_the_category_list( __( ', ', 'ab' ) );
			if ( $categories_list && ab_categorized_blog() ) {
				echo '<h3>'.__('Posted under', 'ab').'</h3>';
				echo '<div class="post-categories">'. $categories_list .'</div>';
			}

			$tags_list = get_the_tag_list( '', '' );
			if ( $tags_list ) {
				echo '<h3>'.__('Tagged', 'ab').'</h3>';
				echo '<div class="post-tags">'. $tags_list.'</div>';
			}
		?>
	</div>
	<div class="no-overflow">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
		<div class="entry-content">
			<?php
				/* translators: %s: Name of current post */
				the_content( sprintf(
					__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'ab' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );
			?>

			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'ab' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
	</div>
	<footer class="entry-footer">
		<?php //ab_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
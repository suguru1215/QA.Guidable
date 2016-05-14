<div id="buddypress" class="have-cover">
	<?php ab_user_cover(false, 'big') ?>
	<div class="container">
		<?php bp_get_template_part( 'members/single/nav' ) ?>
		<div id="item-body" role="main">
			<div class="row">
				<div class="<?php echo is_active_sidebar( 'bp_activity_single' ) ? 'col-md-8' : 'col-md-12' ?>">
					<?php do_action( 'template_notices' ); ?>
					<div class="activity no-ajax" role="main">
						<?php if ( bp_has_activities( 'display_comments=threaded&show_hidden=true&include=' . bp_current_action() ) ) : ?>

							<ul id="activity-stream" class="activity-list item-list activity-single">
							<?php while ( bp_activities() ) : bp_the_activity(); ?>

								<?php bp_get_template_part( 'activity/entry' ); ?>

							<?php endwhile; ?>
							</ul>

						<?php endif; ?>
					</div>
				</div>
				<?php if(is_active_sidebar( 'bp_activity_single' )): ?>
					<div class="col-md-4">
						<?php dynamic_sidebar( 'bp_activity_single' ); ?>				
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
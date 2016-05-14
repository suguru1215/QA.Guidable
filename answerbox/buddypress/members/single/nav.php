<div id="item-nav">
	<div class="main-user-nav no-ajax" id="object-nav" role="navigation">
		<div id="item-header-avatar" class="avatar-circular">
			<div class="circular-progress" data-width="3" data-color="#fc623c4" data-pct="<?php ab_user_percentage_to_next_level(bp_get_member_user_id()) ?>"></div>
			<a href="<?php bp_displayed_user_link(); ?>">				
				<?php bp_displayed_user_avatar( 'type=full' ); ?>
				<?php echo '<span class="user-level-number">'.ab_get_current_level_key().'</span>'; ?>
			</a>
		</div><!-- #item-header-avatar -->
		<?php if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>
			<h2 class="user-nicename">@<?php bp_displayed_user_mentionname(); ?></h2>
		<?php endif; ?>
		<span class="user-current-level"><?php echo ab_get_user_level_name(bp_displayed_user_id()); ?></span>
		<ul class="nav">
			<?php bp_get_displayed_user_nav(); ?>
			<?php do_action( 'bp_member_options_nav' ); ?>
		</ul>
	</div>
</div><!-- #item-nav -->

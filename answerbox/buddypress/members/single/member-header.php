<?php

/**
 * BuddyPress - Users Header
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>
<?php do_action( 'bp_before_member_header' ); ?>
<div id="item-header-content">
	<div id="item-buttons" class="clearfix">
		<?php do_action( 'bp_member_header_actions' ); ?>
	</div><!-- #item-buttons -->
	<div class="last-activity">
		<?php echo '<span class="user-status '. (ab_is_user_online(bp_displayed_user_id()) ? 'online' : 'offline' ) .'">'. (ab_is_user_online(bp_displayed_user_id()) ? __('online', 'ab') : __('offline', 'ab') ) .'</span>'; ?>
		<?php bp_last_activity( bp_displayed_user_id() ); ?>
	</div>

	<?php do_action( 'bp_before_member_header_meta' ); ?>

	<div id="item-meta" class="user-item-meta">
		<?php $latest_update = bp_get_activity_latest_update( bp_displayed_user_id() ); ?>
		<?php if ( bp_is_active( 'activity' ) && $latest_update ) : ?>

			<div id="latest-update">
				<i class="i-status"></i>
				<div class="no-overflow">
					<?php echo $latest_update; ?>
				</div>
			</div>

		<?php endif; ?>
		<?php
		/***
		 * If you'd like to show specific profile fields here use:
		 * bp_member_profile_data( 'field=About Me' ); -- Pass the name of the field
		 */
		 do_action( 'bp_profile_header_meta' );

		 ?>

	</div><!-- #item-meta -->

</div><!-- #item-header-content -->

<?php do_action( 'bp_after_member_header' ); ?>

<?php do_action( 'template_notices' ); ?>
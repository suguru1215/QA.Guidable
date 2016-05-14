<form action="" method="post" id="notifications-bulk-management">
	<table class="notifications">
		<thead>
			<tr>
				<th class="icon"></th>
				<th><input id="select-all-notifications" title="<?php _e( 'Select all', 'buddypress' ); ?>" type="checkbox"></th>
				<th class="title"><?php _e( 'Notification', 'buddypress' ); ?></th>
				<th class="date"><?php _e( 'Date Received', 'buddypress' ); ?></th>
				<th class="actions"><?php _e( 'Actions',    'buddypress' ); ?></th>
			</tr>
		</thead>

		<tbody>

			<?php while ( bp_the_notifications() ) : bp_the_notification(); ?>
				<tr>
					<td></td>
					<td class="notifications-cb"><input id="<?php bp_the_notification_id(); ?>" type="checkbox" name="notifications[]" value="<?php bp_the_notification_id(); ?>" class="notification-check"></td>
					<td class="notifications-desc">
						<a href="<?php echo bp_core_get_user_domain(bp_get_the_notification_secondary_item_id()); ?>" class="notifications-avatar"><?php echo bp_core_fetch_avatar(array('item_id' => bp_get_the_notification_secondary_item_id(), 'height' => '25', 'width' => '25')); ?></a>
						<?php bp_the_notification_description(); ?>
					</td>
					<td class="notifications-date"><?php bp_the_notification_time_since();   ?></td>
					<td class="notifications-actions"><?php bp_the_notification_action_links(); ?></td>
				</tr>

			<?php endwhile; ?>

		</tbody>
	</table>

	<div class="notifications-options-nav">
		<?php bp_notifications_bulk_management_dropdown(); ?>
	</div><!-- .notifications-options-nav -->

	<?php wp_nonce_field( 'notifications_bulk_nonce', 'notifications_bulk_nonce' ); ?>
</form>

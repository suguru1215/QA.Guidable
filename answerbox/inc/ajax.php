<?php
/**
 * AnswerBox ajax methods
 */

class AB_Ajax{
	public function __construct(){
		add_action('wp_ajax_load_user_notifications', array($this, 'load_user_notifications'));
	}

	public function load_user_notifications(){
		if(!is_user_logged_in()){
			return;
			die();
		}
		$user_domain = bp_core_get_user_domain(get_current_user_id());
		$notification_count = bp_notifications_get_unread_notification_count( get_current_user_id() );
		$notifications = bp_notifications_get_notifications_for_user( bp_loggedin_user_id(), 'object' );
		?>
			<li class="user-dd-notification-head">
				<?php printf(__('Notifications %s', 'ab'), '<i>'.$notification_count.'</i>'); ?>
				<a class="pull-right" href="<?php echo $user_domain ?>notifications"><?php _e('view all') ?></a>
			</li>
		<?php
		if(count($notifications) > 0){
					
			foreach ( $notifications as $noti ) : 
				if(strpos($noti->component_action, 'new_answer') !== false)
					$icon = 'i-new_answer';

				elseif(strpos($noti->component_action, 'new_comment') !== false)
					$icon = 'i-new_comment';

				else
					$icon = 'i-'.$noti->component_action;

				?>
				<li>
					<a class="user-dd-notification-item" href="<?php echo $noti->href; ?>">
						<span class="pull-left user-dd-notification-icon <?php echo $icon; ?>"></span>
						<span class="user-dd-notification-avatar pull-right"><?php echo get_avatar($noti->secondary_item_id, 30); ?></span>
						<div class="no-overflow">
							<span class="user-dd-notification-content"><?php echo $noti->content; ?></span>	
							<span class="user-dd-notification-time"><?php printf(__('%s ago', 'ab'), ap_human_time($noti->date_notified, false));  ?></span>
						</div>
					</a>
				</li>

				<?php 
			endforeach;
		}else{
			?>
			<li class="user-dd-notification-noitem">
				<?php _e('All clear! no unread notification', 'ab'); ?>
			</li>
			<?php
		}

		die();
	}
}
new AB_Ajax();
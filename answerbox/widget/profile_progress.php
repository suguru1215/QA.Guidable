<?php
/**
 * Register user profile progress widget
 *
 * Display a message with the progress bar, which encourage users to complete their profile fields.
 */
class AB_Profile_Progress extends WP_Widget {

	public function AB_Profile_Progress() {
		// Instantiate the parent object
		parent::__construct( false, '(AnswerBox) Profile Progress', array( 'description' => __('Display a message with the progress bar, which encourage users to complete their profile fields.','ab')) );
	}

	public function widget( $args, $instance ) {
		if(!bp_is_my_profile())
			return;

		$percentage = ab_profile_progress(get_current_user_id());

		if($percentage != '100'){
			?>
			<div class="userwid-progress widget">
				<div class="userwid-progress-title"><?php printf(__('Your profile is %s complete', 'ab'), $percentage.'%') ?></div>
				<div class="userwid-progress-svg profile-progress" data-pct="<?php echo $percentage ?>"></div>					
				<a href="<?php echo bp_core_get_user_domain(get_current_user_id()); ?>profile/edit" class="btn btn-default btn-xs"><?php _e('Complete profile', 'ab'); ?></a>
			</div>		
			<?php
		}
	}
}

function ab_profile_progress_register_widgets() {
	register_widget( 'AB_Profile_Progress' );
}

add_action( 'widgets_init', 'ab_profile_progress_register_widgets' );
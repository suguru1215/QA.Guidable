<?php
/**
 * Register user reputation widget
 */
class AB_User_Reputation extends WP_Widget {

	public function AB_User_Reputation() {
		// Instantiate the parent object
		parent::__construct( false, '(AnswerBox) User reputation', array( 'description' => __('Shows user reputation card. This widget can only be used in buddypress page.','ab')) );
	}

	public function widget( $args, $instance ) {
		$number = $instance['number'];
		?>
		<div class="userwid-rep widget">						
			<div class="userwid-rep-card">
				<?php ab_reputation_badge(bp_displayed_user_id(), '#aaa', 5); ?>
				<span class="reputation-bar"><?php echo ap_get_user_28_days_reputation(bp_displayed_user_id()); ?></span>
			</div>
			<div class="userwid-rep-list">
				<?php $reputation = ap_get_all_reputation(bp_displayed_user_id(), $number); ?>
				<?php if($reputation): ?>
					<?php foreach($reputation as $rep): ?>
						<div class="userwid-rep-item clearfix">
							<span class="userwid-rep-point<?php echo $rep->apmeta_value < 0 ? ' lost': ''; ?>"><?php echo $rep->apmeta_value; ?></span>
							<div class="no-overflow">
								<span class="userwid-rep-info"><?php echo ap_get_reputation_info($rep); ?></span>
								<span class="userwid-rep-time"><?php echo ap_human_time($rep->apmeta_date, false); ?></span>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>		
		<?php

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$number 		= 4;		
		if ( isset( $instance[ 'number' ] ) ) 
			$number = $instance[ 'number' ];
			
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Show', 'ap' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>">
		</p>
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : 4;

		return $instance;
	}
}

function ab_user_reputation_register_widgets() {
	register_widget( 'AB_User_Reputation' );
}

add_action( 'widgets_init', 'ab_user_reputation_register_widgets' );
<?php
class AB_Site_Stats extends WP_Widget {

	public function AB_Site_Stats() {
		// Instantiate the parent object
		parent::__construct( false, '(AnswerBox) Site stats' );
	}

	public function widget( $args, $instance ) {
		$title 			= apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		?>
		<div class="site-stats">
			<div class="stats-item">
				<i class="apicon-question"></i>
				<?php printf(__('%d Questions', 'ab'), ap_total_published_questions()); ?>
			</div>
			<div class="stats-item">
				<i class="apicon-answer"></i>
				<?php printf(__('%d Questions solved', 'ab'), ap_total_solved_questions()); ?>
			</div>
			<div class="stats-item">
				<i class="i-answer"></i>
				<?php $answers = ap_total_posts_count('answer'); ?>
				<?php printf(__('%d Total answers', 'ab'), $answers->publish); ?>
			</div>					
			<div class="stats-item">
				<i class="i-user"></i>
				<?php $users = count_users(); ?>
				<?php printf(__('%d Total users', 'ab'), $users['total_users']); ?>
			</div>
		</div>
		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Site stats', 'ap' );
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}

function AB_Site_Stats_register_widgets() {
	register_widget( 'AB_Site_Stats' );
}

add_action( 'widgets_init', 'AB_Site_Stats_register_widgets' );
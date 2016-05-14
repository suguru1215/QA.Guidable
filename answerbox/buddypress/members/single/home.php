<div id="buddypress" class="have-cover">
	<?php ab_user_cover(false, 'big') ?>
	<?php do_action( 'bp_before_member_home_content' ); ?>
	<div class="container">		
		<?php bp_get_template_part( 'members/single/nav' ) ?>
		<div id="item-body" role="main">
			<div class="row">
				<div class="<?php echo is_active_sidebar( 'bp_members_'.bp_current_component() ) ? 'col-md-8' : 'col-md-12'; ?>">
					<?php do_action( 'bp_before_member_body' );
					if ( bp_is_user_activity() || !bp_current_component() ) :
						bp_get_template_part( 'members/single/activity' );

					elseif ( bp_is_user_blogs() ) :
						bp_get_template_part( 'members/single/blogs'    );

					elseif ( bp_is_user_friends() ) :
						bp_get_template_part( 'members/single/friends'  );

					elseif ( bp_is_user_groups() ) :
						bp_get_template_part( 'members/single/groups'   );

					elseif ( bp_is_user_messages() ) :
						bp_get_template_part( 'members/single/messages' );

					elseif ( bp_is_user_profile() ) :
						bp_get_template_part( 'members/single/profile'  );

					elseif ( bp_is_user_forums() ) :
						bp_get_template_part( 'members/single/forums'   );

					elseif ( bp_is_user_notifications() ) :
						bp_get_template_part( 'members/single/notifications' );

					elseif ( bp_is_user_settings() ) :
						bp_get_template_part( 'members/single/settings' );

					elseif ( bp_current_component() == 'reputation' ) :
						bp_get_template_part( 'members/single/reputation' );

					elseif ( bp_current_component() == 'questions' ) :
						bp_get_template_part( 'members/single/questions' );

					elseif ( bp_current_component() == 'answers' ) :
						bp_get_template_part( 'members/single/answers' );

					// If nothing sticks, load a generic template
					else :
						bp_get_template_part( 'members/single/plugins'  );

					endif;
					do_action( 'bp_after_member_body' ); ?>
				</div>
				<?php if(is_active_sidebar( 'bp_members_'.bp_current_component() )): ?>
					<div class="col-md-4">
						<?php dynamic_sidebar( 'bp_members_'.bp_current_component() );	?>				
					</div>
				<?php endif; ?>
			</div>
		</div><!-- #item-body -->
		<?php do_action( 'bp_after_member_home_content' ); ?>
	</div>
</div><!-- #buddypress -->

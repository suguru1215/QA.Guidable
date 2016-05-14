<?php do_action( 'bp_before_directory_activity' ); ?>
<div class="container">
<div class="row">
<div class="col-md-8">
	<div id="buddypress">
		<div class="entry-header clearfix">
			<h1 class="entry-title pull-left"><?php _e('Activity', 'ab') ?></h1>			

			<div class="item-list-tabs activity-sorting no-ajax pull-right" id="subnav" role="navigation">
				<ul>
					<li class="feed pull-right"><a href="<?php bp_sitewide_activity_feed_link(); ?>" title="<?php esc_attr_e( 'RSS Feed', 'buddypress' ); ?>"><i class="i-rss"></i></a></li>

					<?php do_action( 'bp_activity_syndication_options' ); ?>

					<li id="activity-filter-select pull-right" class="last">
						<label for="activity-filter-by"><?php _e( 'Show:', 'buddypress' ); ?></label>
						<select id="activity-filter-by">
							<option value="-1"><?php _e( '&mdash; Everything &mdash;', 'buddypress' ); ?></option>

							<?php bp_activity_show_filters(); ?>

							<?php do_action( 'bp_activity_filter_options' ); ?>

						</select>
					</li>
				</ul>
			</div><!-- .item-list-tabs -->
			<div class="dropdown activity-type-dropdown pull-right" role="navigation">
				<button class="btn btn-default dropdown-toggle" type="button" id="activity-type-dropdown" data-toggle="dropdown" aria-expanded="true">
					<span class="i-sort-amount-asc"></span>
					<i class="caret"></i>								
				</button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="activity-type-dropdown">
					<?php do_action( 'bp_before_activity_type_tab_all' ); ?>

					<li class="selected" id="activity-all"><a href="<?php bp_activity_directory_permalink(); ?>" title="<?php esc_attr_e( 'The public activity for everyone on this site.', 'buddypress' ); ?>"><?php printf( __( '<span>%s</span>All Members', 'buddypress' ), bp_get_total_member_count() ); ?></a></li>

					<?php if ( is_user_logged_in() ) : ?>

						<?php do_action( 'bp_before_activity_type_tab_friends' ); ?>

						<?php if ( bp_is_active( 'friends' ) ) : ?>

							<?php if ( bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>

								<li id="activity-friends"><a href="<?php echo bp_loggedin_user_domain() . bp_get_activity_slug() . '/' . bp_get_friends_slug() . '/'; ?>" title="<?php esc_attr_e( 'The activity of my friends only.', 'buddypress' ); ?>"><?php printf( __( '<span>%s</span>My Friends', 'buddypress' ), bp_get_total_friend_count( bp_loggedin_user_id() ) ); ?></a></li>

							<?php endif; ?>

						<?php endif; ?>

						<?php do_action( 'bp_before_activity_type_tab_groups' ); ?>

						<?php if ( bp_is_active( 'groups' ) ) : ?>

							<?php if ( bp_get_total_group_count_for_user( bp_loggedin_user_id() ) ) : ?>

								<li id="activity-groups"><a href="<?php echo bp_loggedin_user_domain() . bp_get_activity_slug() . '/' . bp_get_groups_slug() . '/'; ?>" title="<?php esc_attr_e( 'The activity of groups I am a member of.', 'buddypress' ); ?>"><?php printf( __( '<span>%s</span>My Groups', 'buddypress' ), bp_get_total_group_count_for_user( bp_loggedin_user_id() ) ); ?></a></li>

							<?php endif; ?>

						<?php endif; ?>

						<?php do_action( 'bp_before_activity_type_tab_favorites' ); ?>

						<?php if ( bp_get_total_favorite_count_for_user( bp_loggedin_user_id() ) ) : ?>

							<li id="activity-favorites"><a href="<?php echo bp_loggedin_user_domain() . bp_get_activity_slug() . '/favorites/'; ?>" title="<?php esc_attr_e( "The activity I've marked as a favorite.", 'buddypress' ); ?>"><?php printf( __( '<span>%s</span>My Favorites', 'buddypress' ), bp_get_total_favorite_count_for_user( bp_loggedin_user_id() ) ); ?></a></li>

						<?php endif; ?>

						<?php if ( bp_activity_do_mentions() ) : ?>

							<?php do_action( 'bp_before_activity_type_tab_mentions' ); ?>

							<li id="activity-mentions"><a href="<?php echo bp_loggedin_user_domain() . bp_get_activity_slug() . '/mentions/'; ?>" title="<?php esc_attr_e( 'Activity that I have been mentioned in.', 'buddypress' ); ?>"><?php _e( 'Mentions', 'buddypress' ); ?><?php if ( bp_get_total_mention_count_for_user( bp_loggedin_user_id() ) ) : ?> <span><?php printf( _nx( '%s new', '%s new', bp_get_total_mention_count_for_user( bp_loggedin_user_id() ), 'Number of new activity mentions', 'buddypress' ), bp_get_total_mention_count_for_user( bp_loggedin_user_id() ) ); ?></span><?php endif; ?></a></li>

						<?php endif; ?>

					<?php endif; ?>

					<?php do_action( 'bp_activity_type_tabs' ); ?>
				</ul>
			</div>
		</div>

		<?php do_action( 'bp_before_directory_activity_content' ); ?>

		<?php if ( is_user_logged_in() ) : ?>

			<?php bp_get_template_part( 'activity/post-form' ); ?>

		<?php endif; ?>

		<?php do_action( 'template_notices' ); ?>	
		

		<?php do_action( 'bp_before_directory_activity_list' ); ?>

		<div class="activity" role="main">

			<?php bp_get_template_part( 'activity/activity-loop' ); ?>

		</div><!-- .activity -->

		<?php do_action( 'bp_after_directory_activity_list' ); ?>

		<?php do_action( 'bp_directory_activity_content' ); ?>

		<?php do_action( 'bp_after_directory_activity_content' ); ?>

		<?php do_action( 'bp_after_directory_activity' ); ?>

	</div>
	</div>
	<div class="col-md-4">
		<?php dynamic_sidebar( 'activity-sidebar' ); ?>
	</div>
</div>
</div>

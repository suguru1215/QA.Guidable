<?php

/**
 * BuddyPress - Members Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter()
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php do_action( 'bp_before_members_loop' ); ?>

<?php if ( bp_has_members( bp_ajax_querystring( 'members' ) ) ) : ?>

	<div id="pag-top" class="pagination">

		<div class="pag-count" id="member-dir-count-top">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-top">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

	<?php do_action( 'bp_before_directory_members_list' ); ?>

	<ul id="members-list" class="item-list clearfix" role="main">

	<?php while ( bp_members() ) : bp_the_member(); ?>
		<li>
			<div class="item-memeber">
				<?php ab_user_cover(bp_get_member_user_id()) ?>

				<div class="avatar-circular small">					
					<div class="circular-progress" data-width="4" data-color="#FCB03C" data-pct="<?php ab_user_percentage_to_next_level(bp_get_member_user_id()) ?>"></div>
					<a href="<?php bp_member_permalink(); ?>">				
						<?php bp_member_avatar('type=full'); ?>
						<?php echo '<span class="user-level-number">'.ab_get_current_level_key(bp_get_member_user_id()).'</span>'; ?>
					</a>
				</div>				
				<div class="item clerfix">
					<div class="item-title">
						<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
					</div>

					<div class="item-meta"><span class="activity"><?php bp_member_last_active(); ?></span></div>

					<?php do_action( 'bp_directory_members_item' ); ?>
				</div>
				<div class="item-memeber-inner">
					<div class="actions clearfix">
						<?php do_action( 'bp_directory_members_actions' ); ?>
					</div>
				</div>		
				<div class="memeber-footer clearfix">
					<a href="<?php echo bp_core_get_user_domain(bp_get_member_user_id()).'reputation' ?>"><?php echo ap_get_reputation(bp_get_member_user_id(), true); ?><i>Rep.</i></a>
					<a href="<?php echo bp_core_get_user_domain(bp_get_member_user_id()).'friends' ?>"><?php echo friends_get_friend_count_for_user(bp_get_member_user_id()); ?><i>Friends</i></a>
				</div>
				<div class="clear"></div>
			</div>
		</li>

	<?php endwhile; ?>

	</ul>

	<?php do_action( 'bp_after_directory_members_list' ); ?>

	<?php bp_member_hidden_fields(); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="member-dir-count-bottom">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-bottom">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( "Sorry, no members were found.", 'buddypress' ); ?></p>
	</div>

<?php endif; ?>

<?php do_action( 'bp_after_members_loop' ); ?>

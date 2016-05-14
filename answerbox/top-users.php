<?php
if(is_array($ab_users) && !empty($ab_users))
	foreach ($ab_users as $user) {
		$link = ap_user_link($user->ID);
		echo '<div class="top-users-item clearfix">';
		ap_follow_button($user->ID);
		echo '<a href="'.$link.'" class="top-users-avatar">'.get_avatar($user->ID, $avatar_size).'</a>';
		//echo bp_add_friend_button($user->ID);
		echo '<div class="no-overflow">';
		echo '<a href="'.$link.'" class="top-users-name">'.$user->data->display_name;
		echo '</a>';
		echo sprintf(__('%s reputation', 'ap'), '<span class="top-users-rep">'.ap_get_reputation($user->ID, true).'</span>');
		echo '</div>';
		echo '</div>';
	}
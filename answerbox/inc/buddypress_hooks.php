<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package answerbox
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function ab_add_icon_class_in_nav() {
	global $bp;

	$bp->bp_nav['activity']['name'] = '<i class="i-heartbeat"></i>'.$bp->bp_nav['activity']['name'];
	$bp->bp_nav['profile']['name'] = '<i class="i-user"></i>'.$bp->bp_nav['profile']['name'];
	$bp->bp_nav['notifications']['name'] = '<i class="i-bell"></i>'.$bp->bp_nav['notifications']['name'];
	$bp->bp_nav['reputation']['name'] = '<i class="i-rep"></i>'.$bp->bp_nav['reputation']['name'];
	$bp->bp_nav['questions']['name'] = '<i class="i-question"></i>'.$bp->bp_nav['questions']['name'];
	$bp->bp_nav['answers']['name'] = '<i class="i-answer"></i>'.$bp->bp_nav['answers']['name'];
	$bp->bp_nav['messages']['name'] = '<i class="i-message"></i>'.$bp->bp_nav['messages']['name'];
	
	if(isset($bp->bp_nav['friends']))
		$bp->bp_nav['friends']['name'] = '<i class="i-friend"></i>'.$bp->bp_nav['friends']['name'];
	
	if(isset($bp->bp_nav['groups']))
		$bp->bp_nav['groups']['name'] = '<i class="i-group"></i>'.$bp->bp_nav['groups']['name'];

	$bp->bp_nav['settings']['name'] = '<i class="i-gear"></i>'.$bp->bp_nav['settings']['name'];
}
add_action( 'wp', 'ab_add_icon_class_in_nav' );

/**
 * Add default avtar string in avatar url so that image can easily replaced
 * @param  string $url
 * @return string
 */
function ab_add_default_avatar( $url ){
	return 'AB_DEFAULT_AVATAR';
}
add_filter( 'bp_core_mysteryman_src', 'ab_add_default_avatar' );

/**
 * Replace image if mystery man avatar is selected
 * @param  string $img    
 * @param  array $params
 * @return string         
 */
function ab_bp_core_fetch_avatar($img, $params){
	if(strrpos($img, 'AB_DEFAULT_AVATAR') !== false){		
		switch ( $params['object'] ) {

			case 'blog'  :
				$item_name = get_blog_option( $params['item_id'], 'blogname' );
				break;

			case 'group' :
				$item_name = bp_get_group_name( groups_get_group( array( 'group_id' => $params['item_id'] ) ) );
				break;

			case 'user'  :
			default :
				$item_name = bp_core_get_user_displayname( $params['item_id'] );
				break;
		}
		return '<img alt="' . esc_attr( $params['alt'] ) . '" title="'.substr( $item_name, 0, 2).'" height="' . esc_attr($params['height']) . '" width="' . esc_attr($params['width']) . '" class="'.esc_attr($params['class']).' '.esc_attr($params['class']).'-'.esc_attr($params['height']).' ab-dynamic-avatar">';
	}

	return $img;
}
add_filter( 'bp_core_fetch_avatar', 'ab_bp_core_fetch_avatar', 1, 2 );

function ab_filter_friend_button($button){

	if($button['id'] == 'not_friends'){
		$button['link_text'] = '<i class="i-add-friend"></i> <span>'.__('Friend').'</span>';
		$button['link_class'] = $button['link_class'].' btn btn-primary';
	}
	else{
		$button['link_text'] = '<i class="i-unfriend"></i> <span>'.__('Unfriend').'</span>';
		$button['link_class'] = $button['link_class'].' btn btn-default';
	}

	return $button;
}
add_filter( 'bp_get_add_friend_button', 'ab_filter_friend_button' );

function ab_upload_cover(){
	if(!is_user_logged_in()){
		return; die();
	}

	if(wp_verify_nonce( $_POST['__nonce'], 'cover_upload' )){
		
		$attach_id 		= ab_image_upload_handle();
		$fullsize_path 	= get_attached_file( $attach_id );

		$image = wp_get_image_editor( $fullsize_path ); // Return an implementation that extends <tt>WP_Image_Editor</tt>

		if ( ! is_wp_error( $image ) ) {
		    $image->set_quality( 99 );
		    $image->resize( 911, false, true );
		    $image->save( $fullsize_path );
		}

		$userid 		= get_current_user_id();
		$previous_cover = get_user_meta($userid, '__cover', true);

		wp_delete_attachment( $previous_cover, true );

		update_user_meta($userid, '__cover', $attach_id);

		$result = array('status' => true, 'message' => __('Cover uploaded successfully.', 'ap'), 'image' => 'url('.ab_get_user_cover($userid).')');

		do_action('ab_after_cover_upload', $userid, $attach_id);
	}else{
		$result = array('status' => false, 'message' => __('Unable to upload cover.', 'ap'));
	}
	die(json_encode($result));
}
add_action( 'wp_ajax_ab_upload_cover', 'ab_upload_cover' );

function save_cover_position(){
	if(!is_user_logged_in()){
		return; die();
	}

	if(!wp_verify_nonce( $_POST['__nonce'], 'cover_upload_pos' )){
		return; die();
	}

	update_user_meta( get_current_user_id(), '__cover_pos', sanitize_text_field($_POST['pos']) );

	die();

}
add_action( 'wp_ajax_save_cover_position', 'save_cover_position' );


function ab_bp_get_the_notification_mark_unread_link($retval){
	return str_replace('">', '"><i class="i-mail"></i>', $retval);
}
add_filter( 'bp_get_the_notification_mark_unread_link', 'ab_bp_get_the_notification_mark_unread_link' );

function ab_bp_get_the_notification_mark_read_link($retval){
	return str_replace('">', '"><i class="i-mail-read"></i>', $retval);
}
add_filter( 'bp_get_the_notification_mark_read_link', 'ab_bp_get_the_notification_mark_read_link' );

function ab_bp_get_the_notification_delete_link($retval){
	return str_replace('">', '"><i class="i-trash"></i>', $retval);
}
add_filter( 'bp_get_the_notification_delete_link', 'ab_bp_get_the_notification_delete_link' );
<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package answerbox
 */

if ( ! function_exists( 'the_posts_navigation' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_posts_navigation() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation posts-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php _e( 'Posts navigation', 'ab' ); ?></h2>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( 'Older posts', 'ab' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'ab' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'the_post_navigation' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_post_navigation() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php _e( 'Post navigation', 'ab' ); ?></h2>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', '%title' );
				next_post_link( '<div class="nav-next">%link</div>', '%title' );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'ab_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function ab_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( human_time_diff( get_the_date('U'), current_time('U') )  ),
		esc_attr( get_the_modified_date( 'c' )  ),
		esc_html( human_time_diff( get_the_modified_date( 'U' ), current_time('U') ) )
	);

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	$byline = sprintf(
		_x( 'by %s', 'post author', 'ab' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . sprintf(__('%s ago', 'ab'), $posted_on) . '</span><span class="byline"> ' . $byline . '</span>';

}
endif;

if ( ! function_exists( 'ab_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function ab_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'ab' ) );
		if ( $categories_list && ab_categorized_blog() ) {
			printf( '<span class="cat-links">' . __( 'Posted in %1$s', 'ab' ) . '</span>', $categories_list );
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'ab' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . __( 'Tagged %1$s', 'ab' ) . '</span>', $tags_list );
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'ab' ), __( '1 Comment', 'ab' ), __( '% Comments', 'ab' ) );
		echo '</span>';
	}

	edit_post_link( __( 'Edit', 'ab' ), '<span class="edit-link">', '</span>' );
}
endif;

if ( ! function_exists( 'the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function the_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( __( 'Category: %s', 'ab' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( __( 'Tag: %s', 'ab' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( __( 'Author: %s', 'ab' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( __( 'Year: %s', 'ab' ), get_the_date( _x( 'Y', 'yearly archives date format', 'ab' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( __( 'Month: %s', 'ab' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'ab' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( __( 'Day: %s', 'ab' ), get_the_date( _x( 'F j, Y', 'daily archives date format', 'ab' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = _x( 'Asides', 'post format archive title', 'ab' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = _x( 'Galleries', 'post format archive title', 'ab' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = _x( 'Images', 'post format archive title', 'ab' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = _x( 'Videos', 'post format archive title', 'ab' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = _x( 'Quotes', 'post format archive title', 'ab' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = _x( 'Links', 'post format archive title', 'ab' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = _x( 'Statuses', 'post format archive title', 'ab' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = _x( 'Audio', 'post format archive title', 'ab' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = _x( 'Chats', 'post format archive title', 'ab' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( __( 'Archives: %s', 'ab' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( __( '%1$s: %2$s', 'ab' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = __( 'Archives', 'ab' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;
	}
}
endif;

if ( ! function_exists( 'the_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function ab_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'ab_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'ab_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so ab_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so ab_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in ab_categorized_blog.
 */
function ab_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'ab_categories' );
}
add_action( 'edit_category', 'ab_category_transient_flusher' );
add_action( 'save_post',     'ab_category_transient_flusher' );


if ( ! function_exists( 'ab_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own ab_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Boilerstrap 1.0
 */
function ab_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'ab' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'ab' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo '<a href="'. get_author_posts_url() .'" class="user-avatar pull-left">'. get_avatar( $comment, 44 ) .'</a>';
					printf( '<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'ab' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'ab' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'ab' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'ab' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'ab' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

function ab_profile_progress($user_id = false){

	if(!$user_id)
		$user_id = bp_displayed_user_id();

	global $wpdb;

	$count = wp_cache_get( 'count_xprofile_fields', 'ab_count' );

	if($count === false){

		$query = 'select COUNT(*) from '. $wpdb->prefix .'bp_xprofile_fields';

		$count = $wpdb->get_var($query);

		wp_cache_add( 'count_xprofile_fields', $count, 'ab_count' );
	}

	$user_count_field = wp_cache_get( 'count_xprofile_fields_user_'.$user_id, 'ab_count' );

	if($user_count_field === false){

		$query = $wpdb->prepare('SELECT count(*) FROM '. $wpdb->prefix .'bp_xprofile_data WHERE user_id = %d', $user_id);

		$user_count_field = $wpdb->get_var($query);

		wp_cache_add('count_xprofile_fields_user_'.$user_id, $user_count_field, 'ab_count' );
	}

    return number_format( ($user_count_field / $count) * 100 ) ;   
}

function ab_cover_upload_form(){
	if(bp_displayed_user_id() == get_current_user_id()){
		?>
		<form method="post" action="#" enctype="multipart/form-data" data-action="cover_upload" class="cover-upload">
			<div class="btn">
				<span title="<?php _e('Select image to upload', 'ap'); ?>" class="i-camera"></span>
				<input type="file" name="image" class="cover-upload-input" data-action="cover-upload-field">
			</div>
			<input type='hidden' value='<?php echo wp_create_nonce( 'cover_upload' ); ?>' name='__nonce' />
			<input type="hidden" name="action" id="action" value="ab_upload_cover">
		</form>
		<div class="cover-reposition">
			<button type="button" id="enable-cover-drag" class="i-move btn cover-reposition-drag" title="<?php _e('Reposition cover image', 'ap') ?>"></button>
			<button type="button" id="enable-cover-drag-done" class="i-check btn cover-reposition-done" title="<?php _e('Reposition done', 'ap') ?>"></button>
			<button type="button" id="enable-cover-drag-cancel" class="i-close btn cover-reposition-cancel" title="<?php _e('Cancel reposition', 'ap') ?>"></button>
		</div>
		<?php
	}
}

function ab_user_cover($user_id = false, $size = 'small'){
	if(!$user_id)
		$user_id = bp_displayed_user_id();

	$pos = get_user_meta( $user_id, '__cover_pos', true );

	if($size == 'small'){
		$y = explode(' ', $pos);
		$pos = '0 '. ((int)$y[1] - ((int)$y[1] * .56)) .'px';
	}

	$image = ab_get_user_cover( $user_id );

	echo '<div id="main-cover" data-cont="cover" class="user-cover '.$size.(strlen($image) == 0 ? ' no-cover' : '' ).'" style="background-image:url('.ab_get_user_cover( $user_id ).');background-repeat:no-repeat; background-position:'.$pos.'" data-posnonce="'.wp_create_nonce( 'cover_upload_pos' ).'" data-id="'.bp_core_get_user_displayname($user_id).'">';

	if( $size == 'big')
		ab_cover_upload_form();

	echo '</div>';
}


function ab_is_user_online( $user_id = false ) {
	if(!$user_id)
		$user_id = bp_get_member_user_id() ;

	$current = current_time( 'mysql' );
	$last_activity = bp_get_user_last_activity( bp_displayed_user_id() );

	if ( $last_activity ) {

		$diff =  strtotime( $current ) - strtotime( $last_activity ); 

	    if ( $diff < 300 )
	    	return true;
	    
	    return false;

	}
}

function ab_get_top_users($number = 10){
	$user_a = array(
		'number'    	=> $number,
		'ap_query'  	=> 'sort_points',
		'meta_key'		=> 'ap_reputation',
		'orderby' 		=> 'meta_value'
	);
	// The Query
	$query = new WP_User_Query( $user_a );
	return $query->results;
}

function ab_image_upload_handle(){
	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php');
	if ($_FILES) {
		foreach ($_FILES as $file => $array) {
			if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
				echo "upload error : " . $_FILES[$file]['error'];
				die();
			}
			return media_handle_upload( $file, 0 );
		}
	}
}

function ab_get_user_cover($userid = false){
	if($userid === false)
		$userid = bp_displayed_user_id();

	$image_a = wp_get_attachment_image_src( get_user_meta($userid, '__cover', true), 'full');

	return $image_a[0];
}

function ab_loading_svg($size = 30, $color = '#4bc576'){
	?>
	<svg class="svg-animate-sq" width='<?php echo $size; ?>px' height='<?php echo $size; ?>px' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="uil-squares">
		<rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect>
		<rect x="15" y="15" width="20" height="20" fill="#f7f7f7" class="sq">
			<animate attributeName="fill" from="#f7f7f7" to="<?php echo $color; ?>" repeatCount="indefinite" dur="1s" begin="0.0s" values="<?php echo $color; ?>;<?php echo $color; ?>;#f7f7f7;#f7f7f7" keyTimes="0;0.1;0.2;1"></animate>
		</rect>
		<rect x="40" y="15" width="20" height="20" fill="#f7f7f7" class="sq">
			<animate attributeName="fill" from="#f7f7f7" to="<?php echo $color; ?>" repeatCount="indefinite" dur="1s" begin="0.125s" values="<?php echo $color; ?>;<?php echo $color; ?>;#f7f7f7;#f7f7f7" keyTimes="0;0.1;0.2;1"></animate>
		</rect>
		<rect x="65" y="15" width="20" height="20" fill="#f7f7f7" class="sq">
			<animate attributeName="fill" from="#f7f7f7" to="<?php echo $color; ?>" repeatCount="indefinite" dur="1s" begin="0.25s" values="<?php echo $color; ?>;<?php echo $color; ?>;#f7f7f7;#f7f7f7" keyTimes="0;0.1;0.2;1"></animate>
		</rect>
		<rect x="15" y="40" width="20" height="20" fill="#f7f7f7" class="sq">
			<animate attributeName="fill" from="#f7f7f7" to="<?php echo $color; ?>" repeatCount="indefinite" dur="1s" begin="0.875s" values="<?php echo $color; ?>;<?php echo $color; ?>;#f7f7f7;#f7f7f7" keyTimes="0;0.1;0.2;1"></animate>
		</rect>
		<rect x="65" y="40" width="20" height="20" fill="#f7f7f7" class="sq">
			<animate attributeName="fill" from="#f7f7f7" to="<?php echo $color; ?>" repeatCount="indefinite" dur="1s" begin="0.375" values="<?php echo $color; ?>;<?php echo $color; ?>;#f7f7f7;#f7f7f7" keyTimes="0;0.1;0.2;1"></animate>
		</rect>
		<rect x="15" y="65" width="20" height="20" fill="#f7f7f7" class="sq">
			<animate attributeName="fill" from="#f7f7f7" to="<?php echo $color; ?>" repeatCount="indefinite" dur="1s" begin="0.75s" values="<?php echo $color; ?>;<?php echo $color; ?>;#f7f7f7;#f7f7f7" keyTimes="0;0.1;0.2;1"></animate>
		</rect>
		<rect x="40" y="65" width="20" height="20" fill="#f7f7f7" class="sq">
			<animate attributeName="fill" from="#f7f7f7" to="<?php echo $color; ?>" repeatCount="indefinite" dur="1s" begin="0.625s" values="<?php echo $color; ?>;<?php echo $color; ?>;#f7f7f7;#f7f7f7" keyTimes="0;0.1;0.2;1"></animate>
		</rect>
		<rect x="65" y="65" width="20" height="20" fill="#f7f7f7" class="sq">
			<animate attributeName="fill" from="#f7f7f7" to="<?php echo $color; ?>" repeatCount="indefinite" dur="1s" begin="0.5s" values="<?php echo $color; ?>;<?php echo $color; ?>;#f7f7f7;#f7f7f7" keyTimes="0;0.1;0.2;1"></animate>
		</rect>
	</svg>
	<?php
}

function ap_get_user_28_days_reputation($user_id, $format = 'string'){
	global $wpdb;
	$current_time = current_time('mysql');
	$query = $wpdb->prepare("SELECT sum(v.apmeta_value) as points, DAY(v.apmeta_date) as day FROM ".$wpdb->prefix."ap_meta v WHERE v.apmeta_type='reputation' AND v.apmeta_userid = %d AND v.apmeta_date BETWEEN %s - INTERVAL 28 DAY AND %s group by DAY(v.apmeta_date)", $user_id, $current_time, $current_time);

	$key = md5($query);

	$result = wp_cache_get( $key, 'ap');

	if($result === false){
		$result = $wpdb->get_results($query);
		wp_cache_set( $key, $result, 'ap' );
	}
	
	$days = array();
	
	for ($i=0; $i<30; $i++)
	{
	    $days[date("d", strtotime($i." days ago"))] = 0;
	}

	if($result)
		foreach ($result as $reputation) {
			$days[$reputation->day]  = $reputation->points;
		}

	if($format == 'string')
		return implode(',', $days);
	
	elseif($format == 'object')
		return (object) $days;

	return $days;
}
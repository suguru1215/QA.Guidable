<?php
/**
 * qa-guidable functions and definitions
 *
 * @package qa-guidable
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'ab_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ab_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on qa-guidable, use a find and replace
	 * to change 'ab' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'ab', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'ab' ),
		'footer' => __( 'Footer Menu', 'ab' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'ab_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // ab_setup
add_action( 'after_setup_theme', 'ab_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function ab_widgets_init() {
	$positions = array(
		array('sidebar-1', __( 'Sidebar', 'ab' )),
		array('ap_category_sidebar', __( 'Question category', 'ab' )),
		array('ap_tag_sidebar', __( 'Question tag', 'ab' )),
		array('ap_ask_sidebar', __( 'Ask page', 'ab' )),
		array('activity-sidebar', __( 'Activity page', 'ab' )),
		array('members-sidebar', __( 'Members page', 'ab' )),
	);
	foreach($positions as $p){
		register_sidebar( array(
			'name'          => $p[1],
			'id'            => $p[0],
			'description'   => @$p[2],
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		) );
	}
}
add_action( 'widgets_init', 'ab_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ab_scripts() {
	wp_enqueue_style( 'ab-style', get_stylesheet_uri() );

	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.css' );
	wp_enqueue_style( 'ab-icon-css', get_template_directory_uri() . '/css/fonts/style.css' );
	wp_enqueue_style( 'ab-theme-css', get_template_directory_uri() . '/css/theme.css' );
	wp_enqueue_style( 'Varela-Round-font', 'http://fonts.googleapis.com/css?family=Varela+Round' );
	wp_enqueue_style( 'ab-anspress-css', get_template_directory_uri() . '/css/anspress.css' );

	//wp_enqueue_script( 'jquery-ui-core' );
	//wp_enqueue_script( 'jquery-ui-draggable' );
	wp_enqueue_script( 'jquery-form', array('jquery'), false, true );
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'), '20120206', true );
	wp_enqueue_script( 'ab-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'ab-initial', get_template_directory_uri() . '/js/initial.min.js', array(), '20120206', true );
	wp_enqueue_script( 'ab-progressbar', get_template_directory_uri() . '/js/progressbar.min.js', array(), '20120206', true );
	wp_enqueue_script( 'ab-jquery.peity', get_template_directory_uri() . '/js/jquery.peity.min.js', array(), '20120206', true );
	wp_enqueue_script( 'ab-js', get_template_directory_uri() . '/js/qa-guidable.js', array(), '20120206', true );
	wp_enqueue_script( 'ab-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ab_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load bootstrap nav walker calss
 */
require get_template_directory() . '/inc/bootstrap_navwalker.php';

require get_template_directory() . '/inc/ajax.php';
require get_template_directory() . '/inc/anspress_hooks.php';
require get_template_directory() . '/inc/user_level.php';
require get_template_directory() . '/widget/top_users.php';
require get_template_directory() . '/widget/user_reputation.php';
require get_template_directory() . '/widget/profile_progress.php';
require get_template_directory() . '/widget/site_stats.php';

add_action('show_admin_bar', '__return_false' );

function my_ap_user_link($links){

    if(is_user_logged_in()){
        $links['logout'] = array( 'slug' => 'logout', 'title' => __('Logout'), 'link' => wp_logout_url( ), 'order' => 100, 'show_in_menu' => false, 'public' => true, 'class' => 'apicon-x');
    }

    return $links;
}
add_filter( 'ap_user_menu', 'my_ap_user_link' );

/*
  get_the_modified_time()の結果がget_the_time()より古い場合はget_the_time()を返す。
  同じ場合はnullをかえす。
  それ以外はget_the_modified_time()をかえす。
*/

function get_mtime($format) {
    $mtime = get_the_modified_time('M j, Y');
    $ptime = get_the_time('M j, Y');
    if ($ptime > $mtime) {
        return get_the_time($format);
    } elseif ($ptime === $mtime) {
        return null;
    } else {
        return get_the_modified_time($format);
    }
}

function my_function_admin_bar($content) {
  return ( current_user_can("administrator") ) ? $content : false;
}
add_filter( 'show_admin_bar' , 'my_function_admin_bar');

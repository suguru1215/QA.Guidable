<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package qa-guidable
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="shortcut icon" type="image/x-icon" href="<?php bloginfo('template_url' ); ?>/images/favicon-16x16.ico">
	<link rel="shortcut icon" type="image/x-icon" href="<?php bloginfo('template_url' ); ?>/images/favicon-32x32.ico">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">
		<header id="masthead" class="site-header" role="banner">
			<div class="container">
			<nav id="primary-navigation" class="primary-navigation navbar navbar-default" role="navigation">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header site-description">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="site-title navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" title="<?php bloginfo( 'name' ); ?>">
						<img src="<?php bloginfo('template_url' ); ?>/images/logo.png" alt="logo" />
						</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="main-navbar-collapse">
					<?php do_action('ab_navbar'); ?>
					<?php get_search_form( ); ?>
					<?php if(function_exists('ap_link_to')): ?>
						<a href="<?php ap_link_to('ask'); ?> " class="btn btn-default welcome-btn-sign"><?php _e('Ask Question', 'ab') ?></a>
					<?php endif; ?>
					<ul class="nav navbar-nav navbar-right">
						<?php if(!is_user_logged_in()): ?>
					        <li class="dropdown login-dd">
					        	<a class="btn-login" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="i-locked"></i></a>
					        	<ul class="dropdown-menu">
					        		<?php get_template_part( 'parts/login' ); ?>
					        	</ul>
					        </li>
				    	<?php endif; ?>
				    </ul>
				    <?php
					wp_nav_menu( array(
						'theme_location' 	=> 'primary',
						'menu_id' 			=> 'primary-menu',
						'container' 		=> false,
						'menu_class'        => 'nav navbar-nav ap-pull',
						'fallback_cb' 		=> 'wp_bootstrap_navwalker::fallback',
						'walker' 			=> new wp_bootstrap_navwalker()
						)
					);
					?>
				</div><!-- /.navbar-collapse -->
			</nav>
			</div>
		</header><!-- #masthead -->

		<div id="content" class="site-content">

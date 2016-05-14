<?php
/**
 * Show login signup in header
 *
 * @package qa-guidable
 */
?>
<!-- start login-signup section -->
<div id="login-signup" class="login-signup clearfix">
	<div class="social-login-c clearfix">
		<h4><?php _e('Log in using', 'ab'); ?></h4>
		<?php do_action( 'wordpress_social_login' ); ?>
	</div>
	<div class="login-c clearfix">
		<h4><?php _e('Login', 'ab'); ?></h4>
		<?php
			$form = wp_login_form(array('echo' => false));
			$form = str_replace('login-username', 'login-username form-group', $form);
			$form = str_replace('login-password', 'login-password form-group', $form);
			$form = str_replace('login-remember', 'login-submit form-group', $form);
			$form = str_replace('button-primary', 'btn btn-success', $form);
			$form = str_replace('</p>
			<p class="login-submit">', '', $form);
			$form = str_replace('<p', '<div', $form);
			$form = str_replace('</p>', '</div>', $form);
			$form = str_replace('class="input"', 'class="form-control"', $form);
			$form = str_replace('id="user_login"', 'id="user_login" placeholder="'.__('Enter your username', 'ab').'"', $form);
			$form = str_replace('id="user_pass"', 'id="user_pass" placeholder="'.__('Enter your password', 'ab').'"', $form);
			echo $form;
		?>
		<div class="login-form-links">
 			<a href="<?php echo home_url(); ?>/register/">Register</a> |
 			<a href="<?php echo home_url(); ?>/login/?action=lostpassword"> Rest password</a>
 		</div>
	</div>
</div>
<!-- end login-signup section -->

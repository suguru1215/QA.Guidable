<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package answerbox
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
			<div class="site-info pull-left">
				&copy; 2016 <a href="http://guidable.co/">Guidable</a> All Rights Reserved.
			</div><!-- .site-info -->
			<div class="pull-right">
				<?php
				wp_nav_menu( array(
					'theme_location' 	=> 'footer',
					'menu_id' 			=> 'footer-menu',
					'menu_class'        => 'nav navbar-nav',
					'fallback_cb' 		=> 'wp_bootstrap_navwalker::fallback',
					'walker' 			=> new wp_bootstrap_navwalker()
					)
				);
				?>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '230119050672156',
      xfbml      : true,
      version    : 'v2.5'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

</body>
</html>

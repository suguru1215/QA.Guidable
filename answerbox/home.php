<?php
/**
 * The template for displaying frontpage.
 *
 * @package qa-guidable
 */

get_header(); ?>
	<div class="welcome">
		<h1 class="entry-title"><?php _e('<span>Ask to Guidable.</span>Post your questions and get answers.', 'ab') ?></h1>
	</div>
	<div class="container">
		<div class="home-blocks">
			<div class="row">
				<div class="col-md-9">
					<div class="top_step">
					<div class="top_step__title">
						<h2>Ask Qetions</h2>
					</div>
					<div class="row">
					<div class="col-md-4 col-sm-4">
						<div class="step-content">
						<h4>STEP 1</h4>
						<div class="step-box">
						<p>Registrate our service with only Email address.</p>
						<div class="img-block">
						<img src="<?php bloginfo('template_url' ); ?>/images/user-with-message.png" alt="" class="img-responsive">
						</div>
						</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<div class="step-content">
						<h4>STEP 2</h4>
						<div class="step-box">
						<p>Write your question about Japan.</p>
						<div class="img-block">
						<img src="<?php bloginfo('template_url' ); ?>/images/computer.png" alt="" class="img-responsive">
						</div>
						</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<div class="step-content">
						<h4>STEP 3</h4>
						<div class="step-box">
						<p>Get answer from users and team Guidable.</p>
						<div class="img-block">
						<img src="<?php bloginfo('template_url' ); ?>/images/social.png" alt="" class="img-responsive">
						</div>
						</div>
						</div>
					</div>
					</div>
					</div>
					<div class="row">
					<div class="box">
					  <div class="arrow-down">
					    <div class="left"></div>
					    <div class="right"></div>
					  </div>
					</div>
					</div>
					<div class="row">
						<a href="http://qa.guidable.co/questions/ask/" id="top_ask_btn" class="btn btn-default welcome-btn-sign">Ask Question</a>
					</div>
				<?php echo do_shortcode('[anspress]'); ?>
				</div>
				<div class="col-md-3">
				<div class="side_banner">
					<a href="http://guidable.co/" target="_blank">
						<img src="<?php bloginfo('template_url' ); ?>/images/guidable_banner.jpg" alt="Guidable" class="img-responsive">
					</a>
				</div>
					<?php dynamic_sidebar( 'sidebar-1' ); ?>
				</div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>

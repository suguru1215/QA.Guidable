<?php
/**
 * AnsPress reputation page
 * @package BuddyPress
 * @subpackage bp-legacy
 */
?>

<?php do_action( 'bp_before_member_plugin_template' ); ?>
<div class="bp-reputation">
	<h3 class="bp-entry-title"><?php do_action( 'bp_template_title' ); ?></h3>
	<div class="bp-reputation-chart row">
		<div class="bp-reputation-count col-md-3">
			<?php ab_reputation_badge(bp_displayed_user_id(), '#eee', '5'); ?>
		</div>
		<div class="col-md-9">
			<span class="reputation-big-bar"><?php echo ap_get_user_28_days_reputation(bp_displayed_user_id()); ?></span>
		</div>
	</div>
	<?php do_action( 'bp_template_content' ); ?>
</div>
<?php do_action( 'bp_after_member_plugin_template' ); ?>

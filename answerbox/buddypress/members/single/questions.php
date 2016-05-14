<?php
/**
 * AnsPress questions page
 * @package BuddyPress
 * @subpackage bp-legacy
 */
?>

<?php do_action( 'bp_before_member_plugin_template' ); ?>
<div class="bp-questions">
	<h3 class="bp-entry-title"><?php do_action( 'bp_template_title' ); ?></h3>
	<?php do_action( 'bp_template_content' ); ?>
</div>
<?php do_action( 'bp_after_member_plugin_template' ); ?>

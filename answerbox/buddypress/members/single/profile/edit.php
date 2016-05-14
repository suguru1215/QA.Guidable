<?php do_action( 'bp_before_profile_edit_content' );

if ( bp_has_profile( 'profile_group_id=' . bp_get_current_profile_group_id() ) ) :
	while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

<form action="<?php bp_the_profile_group_edit_form_action(); ?>" method="post" id="profile-edit-form" class="standard-form <?php bp_the_profile_group_slug(); ?>">

	<?php do_action( 'bp_before_profile_field_content' ); ?>		
		<?php if ( bp_profile_has_multiple_groups() ) : ?>
			<ul class="button-nav profile-edit-nav clearfix">
				<?php bp_profile_group_tabs(); ?>
			</ul>
		<?php endif ;?>

		<div class="profile-edit-fields">
			<h4 class="profile-edit-group-ttile"><?php printf( __( "Editing %s Group", "ab" ), bp_get_the_profile_group_name() ); ?></h4>
			<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

				<div<?php bp_field_css_class( 'editfield' ); ?>>

					<?php
					$field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );
					$field_type->edit_field_html();

					do_action( 'bp_custom_profile_edit_fields_pre_visibility' );
					?>

					<?php do_action( 'bp_custom_profile_edit_fields' ); ?>

					<p class="description"><?php bp_the_profile_field_description(); ?></p>

					<?php if ( bp_current_user_can( 'bp_xprofile_change_field_visibility' ) ) : ?>
						<div class="dropdown field-visibility-control">
							<a href="#" class="toggle-dropdown" aria-expanded="false" role="button" data-toggle="dropdown"><span class="current-visibility-level"><?php printf(__('This field can be seen by %s', 'ab'), bp_get_the_profile_field_visibility_level_label()); ?></span><i class="i-gear"></i></a>
							<div class="dropdown-menu">
								<?php bp_profile_visibility_radio_buttons() ?>
							</div>
						</div>

					<?php else : ?>
						<div class="field-visibility-settings-notoggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
							<?php printf(__('This field can be seen by %s', 'ab'), bp_get_the_profile_field_visibility_level_label()); ?>
						</div>
					<?php endif ?>
				</div>

			<?php endwhile; ?>

		<?php do_action( 'bp_after_profile_field_content' ); ?>

		<div class="submit">
			<input type="submit" name="profile-group-edit-submit" id="profile-group-edit-submit" value="<?php esc_attr_e( 'Save Changes', 'buddypress' ); ?> " class="btn" />
		</div>

		<input type="hidden" name="field_ids" id="field_ids" value="<?php bp_the_profile_field_ids(); ?>" />

		<?php wp_nonce_field( 'bp_xprofile_edit' ); ?>
	</div>
</form>

<?php endwhile; endif; ?>

<?php do_action( 'bp_after_profile_edit_content' ); ?>

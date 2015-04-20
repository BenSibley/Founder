<?php

/* create theme options page */
function ct_founder_register_theme_page(){
	add_theme_page( 'Founder Dashboard', 'Founder Dashboard', 'edit_theme_options', 'founder-options', 'ct_founder_options_content', 'ct_founder_options_content');
}
add_action( 'admin_menu', 'ct_founder_register_theme_page' );

/* callback used to add content to options page */
function ct_founder_options_content(){
	?>
	<div id="founder-dashboard-wrap" class="wrap">
		<h2><?php _e('Founder Dashboard', 'founder'); ?></h2>
		<?php hybrid_do_atomic( 'theme_options_before' ); ?>
		<div class="content content-customization">
			<h3><?php _e('Customization', 'founder'); ?></h3>
			<p><?php _e('Click the "Customize" link in your menu, or use the button below to get started customizing Founder', 'founder'); ?>.</p>
			<p>
				<a class="button-primary" href="<?php echo admin_url('customize.php'); ?>"><?php _e('Use Customizer', 'founder') ?></a>
			</p>
		</div>
		<div class="content content-support">
			<h3><?php _e('Support', 'founder'); ?></h3>
			<p><?php _e("You can find the knowledgebase, changelog, support forum, and more in the Founder Support Center", "founder"); ?>.</p>
			<p>
				<a target="_blank" class="button-primary" href="https://www.competethemes.com/documentation/founder-support-center/"><?php _e('Visit Support Center', 'founder'); ?></a>
			</p>
		</div>
		<div class="content content-premium-upgrade">
			<h3><?php _e('Upgrade to Founder Pro', 'founder'); ?></h3>
			<p><?php _e('Founder Pro is the premium upgrade for Founder. It has custom colors, new layouts, background images, and more', 'founder'); ?>...</p>
			<p>
				<a target="_blank" class="button-primary" href="https://www.competethemes.com/founder-pro/"><?php _e('See Full Feature List', 'founder'); ?></a>
			</p>
		</div>
		<div class="content content-resources">
			<h3><?php _e('WordPress Resources', 'founder'); ?></h3>
			<p><?php _e('Save time and money searching for WordPress products by following our recommendations', 'founder'); ?>.</p>
			<p>
				<a target="_blank" class="button-primary" href="https://www.competethemes.com/wordpress-resources/"><?php _e('View Resources', 'founder'); ?></a>
			</p>
		</div>
		<div class="content content-delete-settings">
			<h3><?php _e('Reset Customizer Settings', 'founder'); ?></h3>
			<p>
				<?php
				$url = admin_url('customize.php');
				$text = sprintf( __( '<strong>Warning:</strong> Clicking this button will erase your current settings in the <a href="%s">Customizer</a>', 'founder' ), esc_url( $url ) );
				echo $text . ".";
				?>
			</p>
			<form method="post">
				<input type="hidden" name="founder_reset_customizer" value="founder_reset_customizer_settings" />
				<p>
					<?php wp_nonce_field( 'founder_reset_customizer_nonce', 'founder_reset_customizer_nonce' ); ?>
					<?php submit_button( __( 'Reset Customizer Settings', 'founder' ), 'delete', 'delete', false ); ?>
				</p>
			</form>
		</div>
		<?php hybrid_do_atomic( 'theme_options_after' ); ?>
	</div>
<?php } ?>

<?php

function ct_founder_register_theme_page() {
	add_theme_page( __( 'Founder Dashboard', 'founder' ), __( 'Founder Dashboard', 'founder' ), 'edit_theme_options', 'founder-options', 'ct_founder_options_content', 'ct_founder_options_content' );
}
add_action( 'admin_menu', 'ct_founder_register_theme_page' );

function ct_founder_options_content() {

	$customizer_url = add_query_arg(
		array(
			'url'    => site_url(),
			'return' => add_query_arg( 'page', 'founder-options', admin_url( 'themes.php' ) )
		),
		admin_url( 'customize.php' )
	);
	$support_url = 'https://www.competethemes.com/documentation/founder-support-center/';
	?>
	<div id="founder-dashboard-wrap" class="wrap">
		<h2><?php _e( 'Founder Dashboard', 'founder' ); ?></h2>
		<?php do_action( 'theme_options_before' ); ?>
		<div class="content-boxes">
			<div class="content content-support">
				<h3><?php _e( 'Get Started', 'founder' ); ?></h3>
				<p><?php _e( "Not sure where to start? The <strong>Founder Getting Started Guide</strong> will take you step-by-step through every feature in Founder.", "founder" ); ?></p>
				<p>
					<a target="_blank" class="button-primary"
					   href="https://www.competethemes.com/help/getting-started-founder/"><?php _e( 'View Guide', 'founder' ); ?></a>
				</p>
			</div>
			<?php if ( !function_exists( 'ct_founder_pro_init' ) ) : ?>
				<div class="content content-premium-upgrade">
					<h3><?php _e( 'Founder Pro Plugin', 'founder' ); ?></h3>
					<p><?php _e( 'Download the Founder Pro plugin and unlock custom colors, featured sliders, header images, and more', 'founder' ); ?>...</p>
					<p>
						<a target="_blank" class="button-primary"
						   href="https://www.competethemes.com/founder-pro/"><?php _e( 'See Full Feature List', 'founder' ); ?></a>
					</p>
				</div>
			<?php endif; ?>
			<div class="content content-review">
				<h3><?php _e( 'Leave a Review', 'founder' ); ?></h3>
				<p><?php _e( 'Help others find Founder by leaving a review on wordpress.org.', 'founder' ); ?></p>
				<a target="_blank" class="button-primary" href="https://wordpress.org/support/theme/founder/reviews/"><?php _e( 'Leave a Review', 'founder' ); ?></a>
			</div>
			<div class="content content-delete-settings">
				<h3><?php _e( 'Reset Customizer Settings', 'founder' ); ?></h3>
				<p>
					<?php printf( __( "<strong>Warning:</strong> Clicking this button will erase the Founder theme's current settings in the <a href='%s'>Customizer</a>.", 'founder' ), esc_url( $customizer_url ) ); ?>
				</p>
				<form method="post">
					<input type="hidden" name="founder_reset_customizer" value="founder_reset_customizer_settings"/>
					<p>
						<?php wp_nonce_field( 'founder_reset_customizer_nonce', 'founder_reset_customizer_nonce' ); ?>
						<?php submit_button( __( 'Reset Customizer Settings', 'founder' ), 'delete', 'delete', false ); ?>
					</p>
				</form>
			</div>
		</div>
		<?php do_action( 'theme_options_after' ); ?>
	</div>
<?php }
<?php

/* Add customizer panels, sections, settings, and controls */
add_action( 'customize_register', 'ct_founder_add_customizer_content' );

function ct_founder_add_customizer_content( $wp_customize ) {

	/***** Reorder default sections *****/

	$wp_customize->get_section('title_tagline')->priority     = 1;
	$wp_customize->get_section('static_front_page')->priority = 5;
	$wp_customize->get_section('static_front_page')->title = __('Front Page', 'founder');

	/***** Add PostMessage Support *****/
	
	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	/***** Add Custom Controls *****/

	// create url input control
	class ct_founder_url_input_control extends WP_Customize_Control {
		// create new type called 'url'
		public $type = 'url';
		// the content to be output in the Customizer
		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<input type="url" <?php $this->link(); ?> value="<?php echo esc_url_raw( $this->value() ); ?>" />
			</label>
		<?php
		}
	}

	// number input control
	class ct_founder_number_input_control extends WP_Customize_Control {
		public $type = 'number';

		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<input type="number" <?php $this->link(); ?> value="<?php echo $this->value(); ?>" />
			</label>
		<?php
		}
	}

	// create multi-checkbox/select control
	class ct_founder_multi_checkbox_control extends WP_Customize_Control {
		public $type = 'multi-checkbox';

		public function render_content() {

			if ( empty( $this->choices ) )
				return;
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<select id="comment-display-control" <?php $this->link(); ?> multiple="multiple" style="height: 100%;">
					<?php
					foreach ( $this->choices as $value => $label ) {
						$selected = ( in_array( $value, $this->value() ) ) ? selected( 1, 1, false ) : '';
						echo '<option value="' . esc_attr( $value ) . '"' . $selected . '>' . $label . '</option>';
					}
					?>
				</select>
			</label>
		<?php }
	}

	// create textarea control
	class ct_founder_textarea_control extends WP_Customize_Control {
		public $type = 'textarea';

		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<textarea rows="8" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
		<?php
		}
	}
	/* Ad Controls */
	class founder_description_header_image_control extends WP_Customize_Control {

		public function render_content() {
			$link = 'https://www.competethemes.com/founder-pro/';
			echo "<p>" . sprintf( __('Activate the <a target="_blank" href="%s">Founder Pro Plugin</a> for advanced header image functionality.', 'founder'), $link ) . "</p>";
		}
	}
	class founder_description_color_control extends WP_Customize_Control {

		public function render_content() {
			$link = 'https://www.competethemes.com/founder-pro/';
			echo "<p>" . sprintf( __('Activate the <a target="_blank" href="%s">Founder Pro Plugin</a> to change your colors.', 'founder'), $link ) . "</p>";
		}
	}
	class founder_description_font_control extends WP_Customize_Control {

		public function render_content() {
			$link = 'https://www.competethemes.com/founder-pro/';
			echo "<p>" . sprintf( __('Activate the <a target="_blank" href="%s">Founder Pro Plugin</a> to change your font.', 'founder'), $link ) . "</p>";
		}
	}
	class founder_description_display_control_control extends WP_Customize_Control {

		public function render_content() {
			$link = 'https://www.competethemes.com/founder-pro/';
			echo "<p>" . sprintf( __('Activate the <a target="_blank" href="%s">Founder Pro Plugin</a> to get hide/show controls.', 'founder'), $link ) . "</p>";
		}
	}
	class founder_description_footer_text_control extends WP_Customize_Control {

		public function render_content() {
			$link = 'https://www.competethemes.com/founder-pro/';
			echo "<p>" . sprintf( __('Activate the <a target="_blank" href="%s">Founder Pro Plugin</a> to customize the footer text.', 'founder'), $link ) . "</p>";
		}
	}

	/***** Logo Upload *****/

	// section
	$wp_customize->add_section( 'ct_founder_logo_upload', array(
		'title'      => __( 'Logo', 'founder' ),
		'priority'   => 30,
		'capability' => 'edit_theme_options'
	) );
	// setting
	$wp_customize->add_setting( 'logo_upload', array(
		'default'           => '',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw'
	) );
	// control
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize, 'logo_image', array(
			'label'    => __( 'Upload custom logo.', 'founder' ),
			'section'  => 'ct_founder_logo_upload',
			'settings' => 'logo_upload',
		)
	) );

	/***** Social Media Icons *****/

	// get the social sites array
	$social_sites = ct_founder_social_array();

	// set a priority used to order the social sites
	$priority = 5;

	// section
	$wp_customize->add_section( 'ct_founder_social_media_icons', array(
		'title'       => __('Social Media Icons', 'founder'),
		'priority'    => 35,
		'description' => __('Add the URL for each of your social profiles.', 'founder')
	) );

	// create a setting and control for each social site
	foreach( $social_sites as $social_site => $value ) {
		// if email icon
		if( $social_site == 'email' ) {
			// setting
			$wp_customize->add_setting( "$social_site", array(
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'ct_founder_sanitize_email'
			) );
			// control
			$wp_customize->add_control( $social_site, array(
				'label'   => __('Email Address:', 'founder' ),
				'section' => 'ct_founder_social_media_icons',
				'priority'=> $priority,
			) );
		} else {

			$label = ucfirst( $social_site );

			if ( $social_site == 'google-plus' ) {
				$label = 'Google Plus';
			} elseif ( $social_site == 'rss' ) {
				$label = 'RSS';
			} elseif ( $social_site == 'soundcloud' ) {
				$label = 'SoundCloud';
			} elseif ( $social_site == 'slideshare' ) {
				$label = 'SlideShare';
			} elseif ( $social_site == 'codepen' ) {
				$label = 'CodePen';
			} elseif ( $social_site == 'stumbleupon' ) {
				$label = 'StumbleUpon';
			} elseif ( $social_site == 'deviantart' ) {
				$label = 'DeviantArt';
			} elseif ( $social_site == 'hacker-news' ) {
				$label = 'Hacker News';
			} elseif ( $social_site == 'whatsapp' ) {
				$label = 'WhatsApp';
			} elseif ( $social_site == 'qq' ) {
				$label = 'QQ';
			} elseif ( $social_site == 'vk' ) {
				$label = 'VK';
			} elseif ( $social_site == 'wechat' ) {
				$label = 'WeChat';
			} elseif ( $social_site == 'tencent-weibo' ) {
				$label = 'Tencent Weibo';
			}

			// setting
			$wp_customize->add_setting( $social_site, array(
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw'
			) );
			// control
			$wp_customize->add_control( new ct_founder_url_input_control(
				$wp_customize, $social_site, array(
					'label'    => $label,
					'section'  => 'ct_founder_social_media_icons',
					'priority' => $priority,
				)
			) );
		}
		// increment the priority for next site
		$priority = $priority + 5;
	}

	/***** Blog *****/

	// section
	$wp_customize->add_section( 'founder_blog', array(
		'title'      => __( 'Blog', 'founder' ),
		'priority'   => 45,
		'capability' => 'edit_theme_options'
	) );
	// setting
	$wp_customize->add_setting( 'full_post', array(
		'default'           => 'no',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'ct_founder_sanitize_yes_no_settings',
	) );
	// control
	$wp_customize->add_control( 'full_post', array(
		'label'          => __( 'Show full posts on blog?', 'founder' ),
		'section'        => 'founder_blog',
		'settings'       => 'full_post',
		'type'           => 'radio',
		'choices'        => array(
			'yes'   => __('Yes', 'founder'),
			'no'  => __('No', 'founder'),
		)
	) );
	// setting
	$wp_customize->add_setting( 'excerpt_length', array(
		'default'           => '25',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
	) );
	// control
	$wp_customize->add_control( new ct_founder_number_input_control(
		$wp_customize, 'excerpt_length', array(
			'label'          => __( 'Excerpt length', 'founder' ),
			'section'        => 'founder_blog',
			'settings'       => 'excerpt_length',
			'type'           => 'number',
		)
	) );

	/***** Comment Display *****/

	// section
	$wp_customize->add_section( 'ct_founder_comments_display', array(
		'title'      => __( 'Comment Display', 'founder' ),
		'priority'   => 65,
		'capability' => 'edit_theme_options'
	) );
	// setting
	$wp_customize->add_setting( 'comments_display', array(
		'default'           => array('post','page','attachment','none'),
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'ct_founder_sanitize_comments_setting',
	) );
	// control
	$wp_customize->add_control( new ct_founder_Multi_Checkbox_Control(
		$wp_customize, 'comments_display', array(
			'label'          => __( 'Show comments on:', 'founder' ),
			'section'        => 'ct_founder_comments_display',
			'settings'       => 'comments_display',
			'type'           => 'multi-checkbox',
			'choices'        => array(
				'post'   => __('Posts', 'founder'),
				'page'  => __('Pages', 'founder'),
				'attachment'  => __('Attachments', 'founder'),
				'none'  => __('Do not show', 'founder')
			)
		)
	) );

	/***** Custom CSS *****/

	// section
	$wp_customize->add_section( 'founder_custom_css', array(
		'title'      => __( 'Custom CSS', 'founder' ),
		'priority'   => 70,
		'capability' => 'edit_theme_options'
	) );
	// setting
	$wp_customize->add_setting( 'custom_css', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'wp_filter_nohtml_kses',
	) );
	// control
	$wp_customize->add_control( new ct_founder_textarea_control(
		$wp_customize, 'custom_css', array(
			'label'          => __( 'Add Custom CSS Here:', 'founder' ),
			'section'        => 'founder_custom_css',
			'settings'       => 'custom_css',
		)
	) );

	/*
	 * PRO only sections
	 */

	/***** Header Image *****/

	// section
	$wp_customize->add_section( 'founder_header_image', array(
		'title'      => __( 'Header Image', 'founder' ),
		'priority'   => 35,
		'capability' => 'edit_theme_options'
	) );
	// setting
	$wp_customize->add_setting( 'header_image_ad', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
	) );
	// control
	$wp_customize->add_control( new founder_description_header_image_control(
		$wp_customize, 'header_image_ad', array(
			'section'        => 'founder_header_image',
			'settings'       => 'header_image_ad'
		)
	) );

	/***** Colors *****/

	// section
	$wp_customize->add_section( 'founder_colors', array(
		'title'      => __( 'Colors', 'founder' ),
		'priority'   => 50,
		'capability' => 'edit_theme_options'
	) );
	// setting
	$wp_customize->add_setting( 'colors_ad', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
	) );
	// control
	$wp_customize->add_control( new founder_description_color_control(
		$wp_customize, 'colors_ad', array(
			'section'        => 'founder_colors',
			'settings'       => 'colors_ad'
		)
	) );

	/***** Fonts *****/

	// section
	$wp_customize->add_section( 'founder_font', array(
		'title'      => __( 'Font', 'founder' ),
		'priority'   => 40,
		'capability' => 'edit_theme_options'
	) );
	// setting
	$wp_customize->add_setting( 'font_ad', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
	) );
	// control
	$wp_customize->add_control( new founder_description_font_control(
		$wp_customize, 'font_ad', array(
			'section'        => 'founder_font',
			'settings'       => 'font_ad'
		)
	) );

	/***** Display Control *****/

	// section
	$wp_customize->add_section( 'founder_display_control', array(
		'title'      => __( 'Display Controls', 'founder' ),
		'priority'   => 70,
		'capability' => 'edit_theme_options'
	) );
	// setting
	$wp_customize->add_setting( 'display_control_ad', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
	) );
	// control
	$wp_customize->add_control( new founder_description_display_control_control(
		$wp_customize, 'display_control_ad', array(
			'section'        => 'founder_display_control',
			'settings'       => 'display_control_ad'
		)
	) );

	/***** Footer Text *****/

	// section
	$wp_customize->add_section( 'founder_footer_text', array(
		'title'      => __( 'Footer Text', 'founder' ),
		'priority'   => 85,
		'capability' => 'edit_theme_options'
	) );
	// setting
	$wp_customize->add_setting( 'footer_text_ad', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
	) );
	// control
	$wp_customize->add_control( new founder_description_footer_text_control(
		$wp_customize, 'footer_text_ad', array(
			'section'        => 'founder_footer_text',
			'settings'       => 'footer_text_ad'
		)
	) );
}

/***** Custom Sanitization Functions *****/

/*
 * Sanitize settings with show/hide as options
 * Used in: search bar
 */
function ct_founder_sanitize_all_show_hide_settings($input){
	// create array of valid values
	$valid = array(
		'show' => __('Show', 'founder'),
		'hide' => __('Hide', 'founder')
	);
	// if returned data is in array use it, else return nothing
	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

/*
 * sanitize email address
 * Used in: Social Media Icons
 */
function ct_founder_sanitize_email( $input ) {

	return sanitize_email( $input );
}

// sanitize comment display multi-check
function ct_founder_sanitize_comments_setting($input){

	// valid data
	$valid = array(
		'post'   => __('Posts', 'founder'),
		'page'  => __('Pages', 'founder'),
		'attachment'  => __('Attachments', 'founder'),
		'none'  => __('Do not show', 'founder')
	);

	// loop through array
	foreach( $input as $selection ) {

		// if it's in the valid data, return it
		if ( array_key_exists( $selection, $valid ) ) {
			return $input;
		} else {
			return '';
		}
	}
}

// sanitize yes/no settings
function ct_founder_sanitize_yes_no_settings($input){

	$valid = array(
		'yes'   => __('Yes', 'founder'),
		'no'  => __('No', 'founder'),
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

/***** Helper Functions *****/

function ct_founder_customize_preview_js() {

	$content = "<script>jQuery('#customize-info').prepend('<div class=\"upgrades-ad\"><a href=\"https://www.competethemes.com/founder-pro/\" target=\"_blank\">View the Founder Pro Plugin <span>&rarr;</span></a></div>')</script>";
	echo apply_filters('ct_founder_customizer_ad', $content);
}
add_action('customize_controls_print_footer_scripts', 'ct_founder_customize_preview_js');
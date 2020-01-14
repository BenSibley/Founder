<?php

/* Add customizer panels, sections, settings, and controls */
add_action( 'customize_register', 'ct_founder_add_customizer_content' );

function ct_founder_add_customizer_content( $wp_customize ) {

	/***** Reorder default sections *****/

	$wp_customize->get_section( 'title_tagline' )->priority = 2;

	// check if exists in case user has no pages
	if ( is_object( $wp_customize->get_section( 'static_front_page' ) ) ) {
		$wp_customize->get_section( 'static_front_page' )->priority = 5;
	}

	/***** Add PostMessage Support *****/

	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	/***** Add Custom Controls *****/
	// create multi-checkbox/select control
	class ct_founder_multi_checkbox_control extends WP_Customize_Control {
		public $type = 'multi-checkbox';

		public function render_content() {

			if ( empty( $this->choices ) ) {
				return;
			}
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

	/***** Logo Upload *****/

	// section
	$wp_customize->add_section( 'ct_founder_logo_upload', array(
		'title'    => __( 'Logo', 'founder' ),
		'priority' => 30
	) );
	// setting
	$wp_customize->add_setting( 'logo_upload', array(
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage'
	) );
	// control
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize, 'logo_image', array(
			'label'    => __( 'Upload custom logo.', 'founder' ),
			'section'  => 'ct_founder_logo_upload',
			'settings' => 'logo_upload'
		)
	) );

	/***** Social Media Icons *****/

	// get the social sites array
	$social_sites = ct_founder_social_array();

	// set a priority used to order the social sites
	$priority = 5;

	// section
	$wp_customize->add_section( 'ct_founder_social_media_icons', array(
		'title'       => __( 'Social Media Icons', 'founder' ),
		'priority'    => 35,
		'description' => __( 'Add the URL for each of your social profiles.', 'founder' )
	) );

	// create a setting and control for each social site
	foreach ( $social_sites as $social_site => $value ) {
		// if email icon
		if ( $social_site == 'email' ) {
			// setting
			$wp_customize->add_setting( $social_site, array(
				'sanitize_callback' => 'ct_founder_sanitize_email',
				'transport'         => 'postMessage'
			) );
			// control
			$wp_customize->add_control( $social_site, array(
				'label'    => __( 'Email Address', 'founder' ),
				'section'  => 'ct_founder_social_media_icons',
				'priority' => $priority,
			) );
		} else if ( $social_site == 'phone' ) {
			// setting
			$wp_customize->add_setting( $social_site, array(
				'sanitize_callback' => 'ct_founder_sanitize_phone',
				'transport'         => 'postMessage'
			) );
			// control
			$wp_customize->add_control( $social_site, array(
				'label'    => __( 'Phone', 'founder' ),
				'section'     => 'ct_founder_social_media_icons',
				'priority'    => $priority,
				'type'        => 'text'
			) );
		} else {

			$label = ucfirst( $social_site );

			if ( $social_site == 'google-plus' ) {
				$label = __('Google Plus', 'founder');
			} elseif ( $social_site == 'rss' ) {
				$label = __('RSS', 'founder');
			} elseif ( $social_site == 'soundcloud' ) {
				$label = __('SoundCloud', 'founder');
			} elseif ( $social_site == 'slideshare' ) {
				$label = __('SlideShare', 'founder');
			} elseif ( $social_site == 'codepen' ) {
				$label = __('CodePen', 'founder');
			} elseif ( $social_site == 'stumbleupon' ) {
				$label = __('StumbleUpon', 'founder');
			} elseif ( $social_site == 'deviantart' ) {
				$label = __('DeviantArt', 'founder');
			} elseif ( $social_site == 'hacker-news' ) {
				$label = __('Hacker News', 'founder');
			} elseif ( $social_site == 'google-wallet' ) {
				$label = __('Google Wallet', 'founder');
			} elseif ( $social_site == 'whatsapp' ) {
				$label = __('WhatsApp', 'founder');
			} elseif ( $social_site == 'qq' ) {
				$label = __('QQ', 'founder');
			} elseif ( $social_site == 'vk' ) {
				$label = __('VK', 'founder');
			} elseif ( $social_site == 'ok-ru' ) {
				$label = __('OK.ru', 'founder');
			} elseif ( $social_site == 'wechat' ) {
				$label = __('WeChat', 'founder');
			} elseif ( $social_site == 'tencent-weibo' ) {
				$label = __('Tencent Weibo', 'founder');
			} elseif ( $social_site == 'paypal' ) {
				$label = __('PayPal', 'founder');
			} elseif ( $social_site == 'stack-overflow' ) {
				$label = __('Stack Overflow', 'founder');
			} elseif ( $social_site == 'artstation' ) {
				$label = __('ArtStation', 'founder');
			} elseif ( $social_site == 'email-form' ) {
				$label = __('Contact Form', 'founder');
			}

			if ( $social_site == 'skype' ) {
				// setting
				$wp_customize->add_setting( $social_site, array(
					'sanitize_callback' => 'ct_founder_sanitize_skype',
					'transport'         => 'postMessage'
				) );
				// control
				$wp_customize->add_control( $social_site, array(
					'type'        => 'url',
					'label'       => $label,
					'description' => sprintf( __( 'Accepts Skype link protocol (<a href="%s" target="_blank">learn more</a>)', 'founder' ), 'https://www.competethemes.com/blog/skype-links-wordpress/' ),
					'section'     => 'ct_founder_social_media_icons',
					'priority'    => $priority
				) );
			} else {
				// setting
				$wp_customize->add_setting( $social_site, array(
					'sanitize_callback' => 'esc_url_raw',
					'transport'         => 'postMessage'
				) );
				// control
				$wp_customize->add_control( $social_site, array(
					'type'     => 'url',
					'label'    => $label,
					'section'  => 'ct_founder_social_media_icons',
					'priority' => $priority
				) );
			}
		}
		// increment the priority for next site
		$priority = $priority + 5;
	}

	/***** Search Bar *****/

	// section
	$wp_customize->add_section( 'founder_search_bar', array(
		'title'    => __( 'Search Bar', 'founder' ),
		'priority' => 37
	) );
	// setting
	$wp_customize->add_setting( 'search_bar', array(
		'default'           => 'hide',
		'sanitize_callback' => 'ct_founder_sanitize_all_show_hide_settings'
	) );
	// control
	$wp_customize->add_control( 'search_bar', array(
		'type'    => 'radio',
		'label'   => __( 'Show search bar at top of site?', 'founder' ),
		'section' => 'founder_search_bar',
		'setting' => 'search_bar',
		'choices' => array(
			'show' => __( 'Show', 'founder' ),
			'hide' => __( 'Hide', 'founder' )
		),
	) );

	/***** Blog *****/

	// section
	$wp_customize->add_section( 'founder_blog', array(
		'title'    => __( 'Blog', 'founder' ),
		'priority' => 45
	) );
	// setting
	$wp_customize->add_setting( 'full_post', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_founder_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'full_post', array(
		'label'    => __( 'Show full posts on blog?', 'founder' ),
		'section'  => 'founder_blog',
		'settings' => 'full_post',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'founder' ),
			'no'  => __( 'No', 'founder' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'excerpt_length', array(
		'default'           => '25',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( 'excerpt_length', array(
		'label'    => __( 'Excerpt word count', 'founder' ),
		'section'  => 'founder_blog',
		'settings' => 'excerpt_length',
		'type'     => 'number'
	) );
	// Read More text - setting
	$wp_customize->add_setting( 'read_more_text', array(
		'default'           => __( 'Continue reading', 'founder' ),
		'sanitize_callback' => 'ct_founder_sanitize_text'
	) );
	// Read More text - control
	$wp_customize->add_control( 'read_more_text', array(
		'label'    => __( 'Read More button text', 'founder' ),
		'section'  => 'founder_blog',
		'settings' => 'read_more_text',
		'type'     => 'text'
	) );

	/***** Comment Display *****/

	// section
	$wp_customize->add_section( 'ct_founder_comments_display', array(
		'title'    => __( 'Comment Display', 'founder' ),
		'priority' => 65
	) );
	// setting
	$wp_customize->add_setting( 'comments_display', array(
		'default'           => array( 'post', 'page', 'attachment', 'none' ),
		'sanitize_callback' => 'ct_founder_sanitize_comments_setting'
	) );
	// control
	$wp_customize->add_control( new ct_founder_Multi_Checkbox_Control(
		$wp_customize, 'comments_display', array(
			'label'    => __( 'Show comments on:', 'founder' ),
			'section'  => 'ct_founder_comments_display',
			'settings' => 'comments_display',
			'type'     => 'multi-checkbox',
			'choices'  => array(
				'post'       => __( 'Posts', 'founder' ),
				'page'       => __( 'Pages', 'founder' ),
				'attachment' => __( 'Attachments', 'founder' ),
				'none'       => __( 'Do not show', 'founder' )
			)
		)
	) );

	/***** Scroll-to-stop Arrow  *****/

	// section
	$wp_customize->add_section( 'ct_founder_scroll_to_stop', array(
		'title'    => __( 'Scroll-to-Top Arrow', 'founder' ),
		'priority' => 68
	) );
	// setting - scroll-to-top arrow
	$wp_customize->add_setting( 'scroll_to_top', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_founder_sanitize_yes_no_settings'
	) );
	// control - scroll-to-top arrow
	$wp_customize->add_control( 'scroll_to_top', array(
		'label'    => __( 'Display Scroll-to-top arrow?', 'founder' ),
		'section'  => 'ct_founder_scroll_to_stop',
		'settings' => 'scroll_to_top',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'founder' ),
			'no'  => __( 'No', 'founder' )
		)
	) );

	/***** Additional Options  *****/

	// section
	$wp_customize->add_section( 'ct_founder_additional_options', array(
		'title'    => __( 'Additional Options', 'founder' ),
		'priority' => 75
	) );
	// setting - last updated
	$wp_customize->add_setting( 'last_updated', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_founder_sanitize_yes_no_settings'
	) );
	// control - last updated
	$wp_customize->add_control( 'last_updated', array(
		'label'    => __( 'Display the date each post was last updated?', 'founder' ),
		'section'  => 'ct_founder_additional_options',
		'settings' => 'last_updated',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'founder' ),
			'no'  => __( 'No', 'founder' )
		)
	) );

	/***** Custom CSS *****/

	if ( function_exists( 'wp_update_custom_css_post' ) ) {
		// Migrate any existing theme CSS to the core option added in WordPress 4.7.
		$css = get_theme_mod( 'custom_css' );
		if ( $css ) {
			$core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
			$return = wp_update_custom_css_post( $core_css . $css );
			if ( ! is_wp_error( $return ) ) {
				// Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
				remove_theme_mod( 'custom_css' );
			}
		}
	} else {
		// section
		$wp_customize->add_section( 'founder_custom_css', array(
			'title'    => __( 'Custom CSS', 'founder' ),
			'priority' => 80
		) );
		// setting
		$wp_customize->add_setting( 'custom_css', array(
			'sanitize_callback' => 'ct_founder_sanitize_css',
			'transport'         => 'postMessage'
		) );
		// control
		$wp_customize->add_control( 'custom_css', array(
			'label'    => __( 'Add Custom CSS Here:', 'founder' ),
			'section'  => 'founder_custom_css',
			'settings' => 'custom_css',
			'type'     => 'textarea'
		) );
	}
}

/***** Custom Sanitization Functions *****/

/*
 * Sanitize settings with show/hide as options
 * Used in: search bar
 */
function ct_founder_sanitize_all_show_hide_settings( $input ) {

	$valid = array(
		'show' => __( 'Show', 'founder' ),
		'hide' => __( 'Hide', 'founder' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

/*
 * sanitize email address
 * Used in: Social Media Icons
 */
function ct_founder_sanitize_email( $input ) {
	return sanitize_email( $input );
}

// sanitize comment display multi-check
function ct_founder_sanitize_comments_setting( $input ) {

	$valid = array(
		'post'       => __( 'Posts', 'founder' ),
		'page'       => __( 'Pages', 'founder' ),
		'attachment' => __( 'Attachments', 'founder' ),
		'none'       => __( 'Do not show', 'founder' )
	);

	foreach ( $input as $selection ) {

		return array_key_exists( $selection, $valid ) ? $input : '';
	}
}

// sanitize yes/no settings
function ct_founder_sanitize_yes_no_settings( $input ) {

	$valid = array(
		'yes' => __( 'Yes', 'founder' ),
		'no'  => __( 'No', 'founder' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_founder_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

function ct_founder_sanitize_skype( $input ) {
	return esc_url_raw( $input, array( 'http', 'https', 'skype' ) );
}

function ct_founder_sanitize_css( $css ) {
	$css = wp_kses( $css, array( '\'', '\"' ) );
	$css = str_replace( '&gt;', '>', $css );

	return $css;
}

function ct_founder_sanitize_phone( $input ) {
	if ( $input != '' ) {
		return esc_url_raw( 'tel:' . $input, array( 'tel' ) );
	} else {
		return '';
	}
}

function ct_founder_customize_preview_js() {
	if ( !function_exists( 'ct_founder_pro_init' ) ) {
		$url = 'https://www.competethemes.com/founder-pro/?utm_source=wp-dashboard&utm_medium=Customizer&utm_campaign=Founder%20Pro%20-%20Customizer';
		$content = "<script>jQuery('#customize-info').prepend('<div class=\"upgrades-ad\"><a href=\"". $url ."\" target=\"_blank\">Customize Colors with Founder Pro <span>&rarr;</span></a></div>')</script>";
		echo apply_filters('ct_founder_customizer_ad', $content);
	}
}
add_action('customize_controls_print_footer_scripts', 'ct_founder_customize_preview_js');
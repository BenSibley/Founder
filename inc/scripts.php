<?php

// Front-end
function ct_founder_load_scripts_styles() {

	$font_args = array(
		'family' => urlencode( 'Noto Sans:400,700,400i' ),
		'display' => 'swap',
		'subset' => urlencode( 'latin,latin-ext' )
	);
	$fonts_url = add_query_arg( $font_args, '//fonts.googleapis.com/css' );
	
	wp_enqueue_style( 'ct-founder-google-fonts', $fonts_url );

	wp_enqueue_script( 'ct-founder-js', get_template_directory_uri() . '/js/build/production.min.js', array( 'jquery' ), '', true );
	wp_localize_script( 'ct-founder-js', 'ct_founder_objectL10n', array(
		'openMenu'     => esc_html__( 'open menu', 'founder' ),
		'closeMenu'    => esc_html__( 'close menu', 'founder' ),
		'openSidebar'  => esc_html__( 'open sidebar','founder' ),
		'closeSidebar' => esc_html__( 'close sidebar', 'founder' )
	) );

	wp_enqueue_style( 'ct-founder-font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/all.min.css' );

	wp_enqueue_style( 'ct-founder-style', get_stylesheet_uri() );

	// enqueue comment-reply script only on posts & pages with comments open ( included in WP core )
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/* Load Polyfills */

	// HTML5 shiv
	wp_enqueue_script( 'ct-founder-html5-shiv', get_template_directory_uri() . '/js/build/html5shiv.min.js' );

	// respond.js - media query support
	wp_enqueue_script( 'ct-founder-respond', get_template_directory_uri() . '/js/build/respond.min.js', '', '', true );

	// prevent fatal error on < WP 4.2 (load files unconditionally instead)
	if ( function_exists( 'wp_script_add_data' ) ) {
		wp_script_add_data( 'ct-founder-html5-shiv', 'conditional', 'IE 8' );
		wp_script_add_data( 'ct-founder-respond', 'conditional', 'IE 8' );
	}
}
add_action( 'wp_enqueue_scripts', 'ct_founder_load_scripts_styles' );

// Back-end
function ct_founder_enqueue_admin_styles( $hook ) {

	if ( $hook == 'appearance_page_founder-options' ) {
		wp_enqueue_style( 'ct-founder-admin-styles', get_template_directory_uri() . '/styles/admin.min.css' );
	}
	if ( $hook == 'post.php' || $hook == 'post-new.php' ) {

		$font_args = array(
			'family' => urlencode( 'Noto Sans:400,700,400i' ),
			'subset' => urlencode( 'latin,latin-ext' )
		);
		$fonts_url = add_query_arg( $font_args, '//fonts.googleapis.com/css' );
	
		wp_enqueue_style( 'ct-founder-google-fonts', $fonts_url );
	}
}
add_action( 'admin_enqueue_scripts', 'ct_founder_enqueue_admin_styles' );

// Customizer
function ct_founder_enqueue_customizer_scripts() {
	wp_enqueue_style( 'ct-founder-customizer-styles', get_template_directory_uri() . '/styles/customizer.min.css' );
	wp_enqueue_script( 'ct-founder-customizer-js', get_template_directory_uri() . '/js/build/customizer.min.js', array( 'jquery' ), '', true );
}
add_action( 'customize_controls_enqueue_scripts', 'ct_founder_enqueue_customizer_scripts' );

/*
 * Script for live updating with customizer options. Has to be loaded separately on customize_preview_init hook
 * transport => postMessage
 */
function ct_founder_enqueue_customizer_post_message_scripts() {
	wp_enqueue_script( 'ct-founder-customizer-post-message-js', get_template_directory_uri() . '/js/build/postMessage.min.js', array( 'jquery' ), '', true );

}
add_action( 'customize_preview_init', 'ct_founder_enqueue_customizer_post_message_scripts' );
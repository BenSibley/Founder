<!DOCTYPE html>

<!--[if IE 8 ]><html class="ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]><html class="ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->

<head>

	<!--[if IE 8 ]>
	<script src="<?php echo get_template_directory_uri() . 'js/build/html5shiv.min.js'; ?>"></script>
	<![endif]-->

    <?php wp_head(); ?>

</head>

<body id="<?php print get_stylesheet(); ?>" <?php body_class(); ?>>
<?php hybrid_do_atomic( 'body_top' ); ?>
	<!--skip to content link-->
	<a class="skip-content" href="#main"><?php _e('Skip to content', 'founder'); ?> &rarr;</a>

	<div id="overflow-container" class="overflow-container">
		<div id="max-width" class="max-width">
		<?php hybrid_do_atomic( 'before_header' ); ?>
		<header class="site-header" id="site-header" role="banner">
			<div id="title-container" class="title-container">
				<?php get_template_part('logo')  ?>
				<?php if ( get_bloginfo( 'description' ) ) {
					echo '<p class="tagline">' . get_bloginfo( 'description' ) .'</p>';
				} ?>
			</div>
			<button id="toggle-navigation" class="toggle-navigation" name="toggle-navigation" aria-expanded="false">
				<span class="screen-reader-text"><?php _e('open menu', 'founder'); ?></span>
				<i class="fa fa-bars" title="<?php _e('primary menu icon', 'founder'); ?>"></i>
			</button>
			<div id="menu-primary-container" class="menu-primary-container">
				<?php get_template_part( 'menu', 'primary' ); ?>
				<?php ct_founder_social_icons_output( 'header' ); ?>
			</div>
		</header>
		<?php hybrid_do_atomic( 'after_header' ); ?>
		<?php get_sidebar( 'primary' ); ?>
		<?php hybrid_do_atomic( 'before_main' ); ?>
		<section id="main" class="main" role="main">
			<?php hybrid_do_atomic( 'main_top' ); ?>
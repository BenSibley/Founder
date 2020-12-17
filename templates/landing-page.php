<?php
/*
** Template Name: Landing Page without Header
*/
?>
<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>
	<?php wp_head(); ?>
</head>

<body id="<?php print get_stylesheet(); ?>" <?php body_class(); ?>>
<a class="skip-content" href="#main"><?php _e( 'Skip to content', 'founder' ); ?> &rarr;</a>
	<div id="overflow-container" class="overflow-container">
		<div id="max-width" class="max-width">
            <section id="main" class="main" role="main">
                <div id="loop-container" class="loop-container">
                    <?php
                    if ( have_posts() ) :
                        while ( have_posts() ) :
                            the_post(); ?>
                            <div <?php post_class(); ?>>
                                <article>
                                    <div class="post-content">
                                        <?php the_content(); ?>
                                    </div>
                                </article>
                            </div>
                        <?php endwhile;
                    endif; ?>
                </div>
            </section><!-- .main -->
        </div>
    </div><!-- .overflow-container -->
<?php wp_footer(); ?>

</body>
</html>
<?php get_header();

get_template_part( 'content/archive-header' ); ?>

<div id="loop-container" class="loop-container">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			ct_founder_get_content_template();
		endwhile;
	endif;
	?>
</div>

<?php

the_posts_pagination( array(
	'prev_text' => __( 'Previous', 'founder' ),
	'next_text' => __( 'Next', 'founder' )
) );

get_footer();
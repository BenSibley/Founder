<?php
/*
** Template Name: Landing Page with Header
*/
get_header(); ?>
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
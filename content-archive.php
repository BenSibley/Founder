<div <?php post_class(); ?>>
	<article>
		<div class='post-header'>
			<h1 class='post-title'><?php the_title(); ?></h1>
			<?php get_template_part('content/post-meta'); ?>
		</div>
		<?php ct_founder_featured_image(); ?>
		<div class="post-content">
			<?php ct_founder_excerpt(); ?>
			<?php get_template_part('content/comments-link'); ?>
		</div>
	</article>
</div>
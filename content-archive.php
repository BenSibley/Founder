<div <?php post_class(); ?>>
	<?php hybrid_do_atomic( 'archive_post_before' ); ?>
	<article>
		<div class='post-header'>
			<?php hybrid_do_atomic( 'sticky_post_status' ); ?>
			<h2 class='post-title'>
				<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
			</h2>
			<?php get_template_part('content/post-meta'); ?>
		</div>
		<?php ct_founder_featured_image(); ?>
		<div class="post-content">
			<?php ct_founder_excerpt(); ?>
			<?php get_template_part('content/comments-link'); ?>
		</div>
	</article>
	<?php hybrid_do_atomic( 'archive_post_after' ); ?>
</div>
<span class="post-comments">
	<i class="fas fa-comment" title="<?php esc_attr_e( 'comment icon', 'founder' ); ?>"></i>
	<?php
	if ( ! comments_open() && get_comments_number() < 1 ) :
		comments_number( esc_html__( 'Comments closed', 'founder' ), esc_html__( 'One Comment', 'founder' ), esc_html_x( '% Comments', 'noun: 5 comments', 'founder' ) );
	else :
		echo '<a href="' . esc_url( get_comments_link() ) . '">';
		comments_number( esc_html__( 'Leave a Comment', 'founder' ), esc_html__( 'One Comment', 'founder' ), esc_html_x( '% Comments', 'noun: 5 comments', 'founder' ) );
		echo '</a>';
	endif;
	?>
</span>
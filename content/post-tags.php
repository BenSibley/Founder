<?php
$tags = get_the_tags( $post->ID );
$output = '';
if($tags){
	foreach($tags as $tag) {
		$output .= '<li><a href="'.get_tag_link( $tag->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts tagged %s", 'founder' ), $tag->name ) ) . '">'.$tag->name.'</a></li>';
	}
} 
?>

<div class="post-tags">
	<span><?php _e('Tagged in', 'founder') ?> </span>
	<ul>
		<?php echo $output; ?>
	</ul>
</div> 
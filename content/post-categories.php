<?php

// get the post categories
$categories = get_the_category($post->ID);

// comma-separate posts
$separator = ' ';

// create output variable
$output = '';

// if there are categories for the post
if($categories){

	echo '<p class="post-categories">';
		echo '<span>' . __("Published in", "founder") . ' </span>';
		foreach($categories as $category) {
			$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", 'founder' ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
		}
		echo trim($output, $separator);
	echo "</p>";
}
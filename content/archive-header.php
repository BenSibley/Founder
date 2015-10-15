<?php
/* Category header */
if( is_category() ){ ?>
	<div class='archive-header'>
		<i class="fa fa-folder-open" title="<?php _e('archive icon', 'founder'); ?>"></i>
		<h2>
			<span><?php _e('Category archive for:', 'founder'); ?></span>
			<?php single_cat_title(); ?>
		</h2>
		<?php if ( category_description() ) echo category_description(); ?>
	</div>
<?php
}
/* Tag header */
elseif( is_tag() ){ ?>
	<div class='archive-header'>
		<i class="fa fa-tag" title="<?php _e('tag icon', 'founder'); ?>"></i>
		<h2>
			<span><?php _e('Tag archive for:', 'founder'); ?></span>
			<?php single_tag_title(); ?>
		</h2>
		<?php if ( tag_description() ) echo tag_description(); ?>
	</div>
<?php
}
/* Author header */
elseif( is_author() ){ ?>
	<div class='archive-header'>
		<i class="fa fa-user" title="<?php _e('author icon', 'founder'); ?>"></i>
		<h2>
			<span><?php _e('Author archive for:', 'founder'); ?></span>
			<?php the_author_meta( 'display_name' ); ?>
		</h2>
		<?php if ( get_the_author_meta( 'description' ) ) echo '<p>' . get_the_author_meta( 'description' ) . '</p>'; ?>
	</div>
<?php
}
/* Date header */
elseif( is_date() ){ ?>
	<div class='archive-header'>
		<i class="fa fa-calendar" title="<?php _e('calendar icon', 'founder'); ?>"></i>
		<h2>
			<span><?php _e('Date archive for:', 'founder'); ?></span>
			<?php single_month_title(' '); ?>
		</h2>
	</div>
<?php
}
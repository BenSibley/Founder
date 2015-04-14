<?php
$date = date_i18n( get_option( 'date_format' ), strtotime( get_the_date() ) );
$author = get_the_author();
?>

<div id="post-meta" class="post-meta">
	<p>
		Published <span class="post-date"><?php echo $date; ?></span> by <span class="post-author"><?php echo $author; ?></span>
	</p>
</div>
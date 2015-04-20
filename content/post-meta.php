<?php
$date = date_i18n( get_option( 'date_format' ), strtotime( get_the_date() ) );
$author = get_the_author();
?>

<div id="post-meta" class="post-meta">
	<p>
		<?php printf( __('Published %1$s by %2$s', 'founder'), $date, $author ); ?>
	</p>
</div>
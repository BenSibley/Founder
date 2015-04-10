<?php if ( is_active_sidebar( 'primary' ) ) : ?>

    <aside class="sidebar sidebar-primary" id="sidebar-primary" role="complementary">

        <?php dynamic_sidebar( 'primary' ); ?>

    </aside><!-- #sidebar-primary -->

	<button id="toggle-sidebar" class="toggle-sidebar">
		<i class="fa fa-angle-down"></i>
	</button>

<?php endif; ?>
<?php if ( is_active_sidebar( 'primary' ) ) : ?>

    <aside class="sidebar sidebar-primary" id="sidebar-primary" role="complementary">

	    <div class="sidebar-primary-content">
            <?php dynamic_sidebar( 'primary' ); ?>
	    </div>

	    <button id="toggle-sidebar" class="toggle-sidebar">
		    <i class="fa fa-angle-down"></i>
	    </button>

    </aside><!-- #sidebar-primary -->

<?php endif; ?>
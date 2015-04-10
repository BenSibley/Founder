<?php if ( is_active_sidebar( 'primary' ) ) : ?>

    <aside class="sidebar sidebar-primary" id="sidebar-primary" role="complementary">

	    <button id="toggle-sidebar" class="toggle-sidebar">
		    <i class="fa fa-angle-down"></i>
	    </button>

	    <div id="sidebar-primary-content" class="sidebar-primary-content">
		    <div id="sidebar-primary-widgets" class="sidebar-primary-widgets">
                <?php dynamic_sidebar( 'primary' ); ?>
		    </div>
	    </div>

    </aside><!-- #sidebar-primary -->

<?php endif; ?>
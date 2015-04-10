<?php if ( is_active_sidebar( 'primary' ) ) : ?>

    <aside class="sidebar sidebar-primary" id="sidebar-primary" role="complementary">

	    <button id="toggle-sidebar" class="toggle-sidebar">
		    <i class="fa fa-angle-down"></i>
	    </button>

	    <div class="sidebar-primary-content">
            <?php dynamic_sidebar( 'primary' ); ?>
	    </div>

    </aside><!-- #sidebar-primary -->

<?php endif; ?>
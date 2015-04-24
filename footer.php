<?php hybrid_do_atomic( 'main_bottom' ); ?>
</section> <!-- .main -->

<footer class="site-footer" role="contentinfo">
	<?php hybrid_do_atomic( 'footer_top' ); ?>
    <span>
        <?php
            $site_url = 'https://www.competethemes.com/founder/';
            $footer_text = sprintf( __( '<a href="%s">Founder WordPress Theme</a> by Compete Themes.', 'founder' ), esc_url( $site_url ) );
            echo $footer_text;
        ?>
    </span>
</footer>
</div>
</div><!-- .overflow-container -->

<?php wp_footer(); ?>

<!--[if IE 8 ]>
<script src="<?php echo trailingslashit( get_template_directory_uri() ) . 'js/build/respond.min.js'; ?>"></script>
<![endif]-->

<?php hybrid_do_atomic( 'body_bottom' ); ?>
</body>
</html>
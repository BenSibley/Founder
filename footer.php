<?php hybrid_do_atomic( 'main_bottom' ); ?>
</section> <!-- .main -->

<footer class="site-footer" role="contentinfo">
	<?php hybrid_do_atomic( 'footer_top' ); ?>
    <span>
        <?php
            $site_url = 'https://www.competethemes.com/founder/';
            $footer_text = sprintf( __( '<a href="%s">Founder WordPress Theme</a> by Compete Themes.', 'founder' ), esc_url( $site_url ) );
            $footer_text = apply_filters( 'ct_founder_footer_text', $footer_text );
            echo $footer_text;
        ?>
    </span>
</footer>
</div>
</div><!-- .overflow-container -->

<?php hybrid_do_atomic( 'body_bottom' ); ?>

<?php wp_footer(); ?>

</body>
</html>
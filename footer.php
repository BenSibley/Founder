<?php do_action( 'main_bottom' ); ?>
</section><!-- .main -->

<footer id="site-footer" class="site-footer" role="contentinfo">
	<?php do_action( 'footer_top' ); ?>
	<span>
        <?php
        $footer_text = sprintf( __( '<a href="%s">Founder WordPress Theme</a> by Compete Themes.', 'founder' ), 'https://www.competethemes.com/founder/' );
        $footer_text = apply_filters( 'ct_founder_footer_text', $footer_text );
        echo wp_kses_post( $footer_text );
        ?>
    </span>
</footer>
</div>
</div><!-- .overflow-container -->

<?php do_action( 'body_bottom' ); ?>

<?php wp_footer(); ?>

</body>
</html>
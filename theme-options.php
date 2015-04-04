<?php

/* create theme options page */
function ct_founder_register_theme_page(){
add_theme_page( 'founder Dashboard', 'Founder Dashboard', 'edit_theme_options', 'founder-options', 'ct_founder_options_content', 'ct_founder_options_content');
}
add_action( 'admin_menu', 'ct_founder_register_theme_page' );

/* callback used to add content to options page */
function ct_founder_options_content(){
    ?>
    <div id="founder-dashboard-wrap" class="wrap">
        <h2><?php _e('founder Dashboard', 'founder'); ?></h2>
        <div class="content content-customization">
            <h3><?php _e('Customization', 'founder'); ?></h3>
            <p><?php _e('Click the "Customize" link in your menu, or use the button below to get started customizing founder', 'founder'); ?>.</p>
            <p>
                <a class="button-primary" href="customize.php"><?php _e('Use Customizer', 'founder') ?></a>
            </p>
        </div>
        <div class="content content-support">
	        <h3><?php _e('Support', 'founder'); ?></h3>
            <p><?php _e("You can find the knowledgebase, changelog, support forum, and more in the founder Support Center", "founder"); ?>.</p>
            <p>
                <a target="_blank" class="button-primary" href="http://www.competethemes.com/documentation/founder-support-center/"><?php _e('Visit Support Center', 'founder'); ?></a>
            </p>
        </div>
        <div class="content content-premium-upgrade">
            <h3><?php _e('Upgrade to founder Plus ($29)', 'founder'); ?></h3>
            <p><?php _e('founder Plus is the premium version of founder. By upgrading to founder Plus, you get:', 'founder'); ?></p>
            <ul>
                <li><?php _e('Custom colors', 'founder'); ?></li>
                <li><?php _e('Background images & textures', 'founder'); ?></li>
                <li><?php _e('New layouts', 'founder'); ?></li>
                <li><?php _e('and much more&#8230;', 'founder'); ?></li>
            </ul>
            <p>
                <a target="_blank" class="button-primary" href="https://www.competethemes.com/founder-plus/"><?php _e('See Full Feature List', 'founder'); ?></a>
            </p>
        </div>
    </div>
<?php } ?>

<?php

//----------------------------------------------------------------------------------
//	Include all required files
//----------------------------------------------------------------------------------
require_once(trailingslashit(get_template_directory()) . 'theme-options.php');
require_once(trailingslashit(get_template_directory()) . 'inc/customizer.php');
require_once(trailingslashit(get_template_directory()) . 'inc/deprecated.php');
require_once(trailingslashit(get_template_directory()) . 'inc/last-updated-meta-box.php');
require_once(trailingslashit(get_template_directory()) . 'inc/scripts.php');
// TGMP
require_once(trailingslashit(get_template_directory()) . 'tgm/class-tgm-plugin-activation.php');

function ct_founder_register_required_plugins()
{
    $plugins = array(

        array(
            'name'      => 'Independent Analytics',
            'slug'      => 'independent-analytics',
            'required'  => false,
        ),
    );

    $config = array(
        'id'           => 'ct-founder',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '',
        'is_automatic' => false,
        'message'      => '',
        'strings'      => array(
            'page_title'                      => __('Install Recommended Plugins', 'founder'),
            'menu_title'                      => __('Recommended Plugins', 'founder'),
            'notice_can_install_recommended'     => _n_noop(
                'The makers of the Founder theme now recommend installing Independent Analytics, their new plugin for visitor tracking: %1$s.',
                'The makers of the Founder theme now recommend installing Independent Analytics, their new plugin for visitor tracking: %1$s.',
                'founder'
            ),
        )
    );

    tgmpa($plugins, $config);
}
add_action('tgmpa_register', 'ct_founder_register_required_plugins');

if (! function_exists(('ct_founder_set_content_width'))) {
    function ct_founder_set_content_width()
    {
        if (! isset($content_width)) {
            $content_width = 700;
        }
    }
}
add_action('after_setup_theme', 'ct_founder_set_content_width', 0);

if (! function_exists(('ct_founder_theme_setup'))) {
    function ct_founder_theme_setup()
    {
        add_theme_support('post-thumbnails');
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption'
        ));
        add_theme_support('infinite-scroll', array(
            'container' => 'loop-container',
            'footer'    => 'overflow-container',
            'render'    => 'ct_founder_infinite_scroll_render'
        ));
        // Add WooCommerce support
        add_theme_support('woocommerce');
        // Support WooCommerce image gallery features
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');

        // Gutenberg - wide & full images
        add_theme_support('align-wide');

        // Gutenberg - add support for editor styles
        add_theme_support('editor-styles');

        // Gutenberg - modify the font sizes
        add_theme_support('editor-font-sizes', array(
            array(
                    'name' => __('small', 'founder'),
                    'shortName' => __('S', 'founder'),
                    'size' => 11,
                    'slug' => 'small'
            ),
            array(
                    'name' => __('regular', 'founder'),
                    'shortName' => __('M', 'founder'),
                    'size' => 16,
                    'slug' => 'regular'
            ),
            array(
                    'name' => __('large', 'founder'),
                    'shortName' => __('L', 'founder'),
                    'size' => 24,
                    'slug' => 'large'
            ),
            array(
                    'name' => __('larger', 'founder'),
                    'shortName' => __('XL', 'founder'),
                    'size' => 36,
                    'slug' => 'larger'
            )
    ));

        load_theme_textdomain('founder', get_template_directory() . '/languages');

        register_nav_menus(array(
            'primary' => esc_html__('Primary', 'founder')
        ));
    }
}
add_action('after_setup_theme', 'ct_founder_theme_setup', 10);

//-----------------------------------------------------------------------------
// Load custom stylesheet for the post editor
//-----------------------------------------------------------------------------
if (! function_exists('ct_founder_add_editor_styles')) {
    function ct_founder_add_editor_styles()
    {
        add_editor_style('styles/editor-style.css');
    }
}
add_action('admin_init', 'ct_founder_add_editor_styles');

if (! function_exists(('ct_founder_register_widget_areas'))) {
    function ct_founder_register_widget_areas()
    {
        register_sidebar(array(
            'name'          => esc_html__('Primary Sidebar', 'founder'),
            'id'            => 'primary',
            'description'   => esc_html__('Widgets in this area will be shown in the sidebar.', 'founder'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>'
        ));
    }
}
add_action('widgets_init', 'ct_founder_register_widget_areas');

if (! function_exists(('ct_founder_customize_comments'))) {
    function ct_founder_customize_comments($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        global $post; ?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-author">
				<?php
                echo get_avatar(get_comment_author_email(), 36, '', get_comment_author()); ?>
				<span class="author-name"><?php comment_author_link(); ?></span>
			</div>
			<div class="comment-content">
				<?php if ($comment->comment_approved == '0') : ?>
					<em><?php esc_html_e('Your comment is awaiting moderation.', 'founder') ?></em>
					<br/>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div>
			<div class="comment-footer">
				<span class="comment-date"><?php comment_date(); ?></span>
				<?php comment_reply_link(array_merge($args, array(
                    // translators: verb: reply to this comment
                    'reply_text' => esc_html__('Reply', 'founder'),
                    'depth'      => $depth,
                    'max_depth'  => $args['max_depth']
                ))); ?>
				<?php
                // translators: verb: edit to this comment
                edit_comment_link(esc_html__('Edit', 'founder')); ?>
			</div>
		</article>
		<?php
    }
}

if (! function_exists('ct_founder_update_fields')) {
    function ct_founder_update_fields($fields)
    {
        $commenter = wp_get_current_commenter();
        $req       = get_option('require_name_email');
        $label     = $req ? '*' : ' ' . esc_html__('(optional)', 'founder');
        $aria_req  = $req ? "aria-required='true'" : '';

        $fields['author'] =
            '<p class="comment-form-author">
	            <label for="author">' . esc_html__("Name", "founder") . $label . '</label>
	            <input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) .
            '" size="30" ' . $aria_req . ' />
	        </p>';

        $fields['email'] =
            '<p class="comment-form-email">
	            <label for="email">' . esc_html__("Email", "founder") . $label . '</label>
	            <input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) .
            '" size="30" ' . $aria_req . ' />
	        </p>';

        $fields['url'] =
            '<p class="comment-form-url">
	            <label for="url">' . esc_html__("Website", "founder") . '</label>
	            <input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) .
            '" size="30" />
	            </p>';

        return $fields;
    }
}
add_filter('comment_form_default_fields', 'ct_founder_update_fields');

if (! function_exists('ct_founder_update_comment_field')) {
    function ct_founder_update_comment_field($comment_field)
    {

        // don't filter the WooCommerce review form
        if (function_exists('is_woocommerce')) {
            if (is_woocommerce()) {
                return $comment_field;
            }
        }

        $comment_field =
            '<p class="comment-form-comment">
	            <label for="comment">' . esc_html__("Comment", "founder") . '</label>
	            <textarea required id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
	        </p>';

        return $comment_field;
    }
}
add_filter('comment_form_field_comment', 'ct_founder_update_comment_field', 7);

if (! function_exists('ct_founder_remove_comments_notes_after')) {
    function ct_founder_remove_comments_notes_after($defaults)
    {
        $defaults['comment_notes_after'] = '';
        return $defaults;
    }
}
add_action('comment_form_defaults', 'ct_founder_remove_comments_notes_after');

if (! function_exists('ct_founder_filter_read_more_link')) {
    function ct_founder_filter_read_more_link($custom = false)
    {
        if (is_feed()) {
            return;
        }
        global $post;
        $ismore             = strpos($post->post_content, '<!--more-->');
        $read_more_text     = get_theme_mod('read_more_text');
        $new_excerpt_length = get_theme_mod('excerpt_length');
        $excerpt_more       = ($new_excerpt_length === 0) ? '' : '&#8230;';
        $output = '';

        // add ellipsis for automatic excerpts
        if (empty($ismore) && $custom !== true) {
            $output .= $excerpt_more;
        }
        // Because i18n text cannot be stored in a variable
        if (empty($read_more_text)) {
            $output .= '<div class="more-link-wrapper"><a class="more-link" href="' . esc_url(get_permalink()) . '">' . esc_html__('Continue reading', 'founder') . '<span class="screen-reader-text">' . esc_html(get_the_title()) . '</span></a></div>';
        } else {
            $output .= '<div class="more-link-wrapper"><a class="more-link" href="' . esc_url(get_permalink()) . '">' . esc_html($read_more_text) . '<span class="screen-reader-text">' . esc_html(get_the_title()) . '</span></a></div>';
        }
        return $output;
    }
}
add_filter('the_content_more_link', 'ct_founder_filter_read_more_link'); // more tags
add_filter('excerpt_more', 'ct_founder_filter_read_more_link', 10); // automatic excerpts

// handle manual excerpts
if (! function_exists('ct_founder_filter_manual_excerpts')) {
    function ct_founder_filter_manual_excerpts($excerpt)
    {
        $excerpt_more = '';
        if (has_excerpt()) {
            $excerpt_more = ct_founder_filter_read_more_link(true);
        }
        return $excerpt . $excerpt_more;
    }
}
add_filter('get_the_excerpt', 'ct_founder_filter_manual_excerpts');

if (! function_exists('ct_founder_excerpt')) {
    function ct_founder_excerpt()
    {
        global $post;
        $show_full_post = get_theme_mod('full_post');
        $ismore         = strpos($post->post_content, '<!--more-->');

        if ($show_full_post === 'yes' || $ismore) {
            the_content();
        } else {
            the_excerpt();
        }
    }
}

if (! function_exists('ct_founder_custom_excerpt_length')) {
    function ct_founder_custom_excerpt_length($length)
    {
        $new_excerpt_length = get_theme_mod('excerpt_length');

        if (! empty($new_excerpt_length) && $new_excerpt_length != 25) {
            return $new_excerpt_length;
        } elseif ($new_excerpt_length === 0) {
            return 0;
        } else {
            return 25;
        }
    }
}
add_filter('excerpt_length', 'ct_founder_custom_excerpt_length', 99);

if (! function_exists('ct_founder_remove_more_link_scroll')) {
    function ct_founder_remove_more_link_scroll($link)
    {
        $link = preg_replace('|#more-[0-9]+|', '', $link);
        return $link;
    }
}
add_filter('the_content_more_link', 'ct_founder_remove_more_link_scroll');

// Yoast OG description has "Continue readingTitle of the Post" due to its use of get_the_excerpt(). This fixes that.
function ct_founder_update_yoast_og_description($ogdesc)
{
    $read_more_text = get_theme_mod('read_more_text');
    if (empty($read_more_text)) {
        $read_more_text = esc_html__('Continue reading', 'founder');
    }
    $ogdesc = substr($ogdesc, 0, strpos($ogdesc, $read_more_text));

    return $ogdesc;
}
add_filter('wpseo_opengraph_desc', 'ct_founder_update_yoast_og_description');

if (! function_exists('ct_founder_featured_image')) {
    function ct_founder_featured_image()
    {
        global $post;
        $featured_image = '';

        if (has_post_thumbnail($post->ID)) {
            if (is_singular()) {
                $featured_image = '<div class="featured-image">' . get_the_post_thumbnail($post->ID, 'full') . '</div>';
                if (get_theme_mod('featured_image_captions') == 'yes') {
                    $caption = get_post(get_post_thumbnail_id())->post_excerpt;
                    if (!empty($caption)) {
                        $featured_image .= '<div class="caption">' . wp_kses_post($caption) . '</div>';
                    }
                }
            } else {
                $featured_image = '<div class="featured-image"><a href="' . esc_url(get_permalink()) . '">' . get_the_title() . get_the_post_thumbnail($post->ID, 'full') . '</a></div>';
            }
        }

        $featured_image = apply_filters('ct_founder_featured_image', $featured_image);

        if ($featured_image) {
            echo $featured_image;
        }
    }
}

if (! function_exists('ct_founder_social_array')) {
    function ct_founder_social_array()
    {
        $social_sites = array(
            'twitter'       => 'founder_twitter_profile',
            'facebook'      => 'founder_facebook_profile',
            'instagram'     => 'founder_instagram_profile',
            'linkedin'      => 'founder_linkedin_profile',
            'pinterest'     => 'founder_pinterest_profile',
            'youtube'       => 'founder_youtube_profile',
            'rss'           => 'founder_rss_profile',
            'email'         => 'founder_email_profile',
            'phone'         => 'founder_phone_profile',
            'email-form'    => 'founder_email_form_profile',
            'amazon'        => 'founder_amazon_profile',
            'artstation'    => 'founder_artstation_profile',
            'bandcamp'      => 'founder_bandcamp_profile',
            'behance'       => 'founder_behance_profile',
            'bitbucket'     => 'founder_bitbucket_profile',
            'codepen'       => 'founder_codepen_profile',
            'delicious'     => 'founder_delicious_profile',
            'deviantart'    => 'founder_deviantart_profile',
            'digg'          => 'founder_digg_profile',
            'discord'		=> 'founder_discord_profile',
            'dribbble'      => 'founder_dribbble_profile',
            'etsy'          => 'founder_etsy_profile',
            'flickr'        => 'founder_flickr_profile',
            'foursquare'    => 'founder_foursquare_profile',
            'github'        => 'founder_github_profile',
            'goodreads'   	=> 'founder_goodreads_profile',
            'google-wallet' => 'founder_google-wallet_profile',
            'hacker-news'   => 'founder_hacker-news_profile',
            'mastodon'      => 'founder_mastodon_profile',
            'medium'        => 'founder_medium_profile',
            'meetup'        => 'founder_meetup_profile',
            'mixcloud'      => 'founder_mixcloud_profile',
            'ok-ru'			=> 'founder_ok_ru_profile',
            'orcid'			=> 'founder_orcid_profile',
            'patreon'       => 'founder_patreon_profile',
            'paypal'        => 'founder_paypal_profile',
            'pocket'       	=> 'founder_pocket_profile',
            'podcast'       => 'founder_podcast_profile',
            'qq'            => 'founder_qq_profile',
            'quora'         => 'founder_quora_profile',
            'ravelry'       => 'founder_ravelry_profile',
            'reddit'        => 'founder_reddit_profile',
            'researchgate'  => 'founder_researchgate_profile',
            'skype'         => 'founder_skype_profile',
            'slack'         => 'founder_slack_profile',
            'slideshare'    => 'founder_slideshare_profile',
            'snapchat'      => 'founder_snapchat_profile',
            'soundcloud'    => 'founder_soundcloud_profile',
            'spotify'       => 'founder_spotify_profile',
            'stack-overflow' => 'founder_stack_overflow_profile',
            'steam'         => 'founder_steam_profile',
            'strava'        => 'founder_strava_profile',
            'stumbleupon'   => 'founder_stumbleupon_profile',
            'telegram'      => 'founder_telegram_profile',
            'tencent-weibo' => 'founder_tencent_weibo_profile',
            'tumblr'        => 'founder_tumblr_profile',
            'twitch'        => 'founder_twitch_profile',
            'untappd'       => 'founder_untappd_profile',
            'vimeo'         => 'founder_vimeo_profile',
            'vine'          => 'founder_vine_profile',
            'vk'            => 'founder_vk_profile',
            'wechat'        => 'founder_wechat_profile',
            'weibo'         => 'founder_weibo_profile',
            'whatsapp'      => 'founder_whatsapp_profile',
            'xing'          => 'founder_xing_profile',
            'yahoo'         => 'founder_yahoo_profile',
            'yelp'          => 'founder_yelp_profile',
            '500px'         => 'founder_500px_profile',
            'social_icon_custom_1' => 'social_icon_custom_1_profile',
            'social_icon_custom_2' => 'social_icon_custom_2_profile',
            'social_icon_custom_3' => 'social_icon_custom_3_profile'
        );

        return apply_filters('ct_founder_filter_social_sites', $social_sites);
    }
}

if (! function_exists('ct_founder_social_icons_output')) {
    function ct_founder_social_icons_output()
    {
        $social_sites = ct_founder_social_array();
        $square_icons = array(
            'vimeo',
            'youtube',
            'pinterest',
            'rss',
            'reddit',
            'tumblr',
            'steam',
            'xing',
            'github',
            'google-plus',
            'behance',
            'facebook'
        );

        // store the site name and url
        foreach ($social_sites as $social_site => $profile) {
            if (strlen(get_theme_mod($social_site)) > 0) {
                $active_sites[ $social_site ] = $social_site;
            }
        }

        if (! empty($active_sites)) {
            echo "<ul class='social-media-icons'>";

            foreach ($active_sites as $key => $active_site) {

                // get the square or plain class
                if (in_array($active_site, $square_icons)) {
                    if ($active_site == 'rss') {
                        $class = 'fas fa-rss-square';
                    } else {
                        $class = 'fab fa-' . esc_attr($active_site) . '-square';
                    }
                } elseif ($active_site == 'ok-ru') {
                    $class = 'fab fa-odnoklassniki';
                } elseif ($active_site == 'email-form') {
                    $class = 'far fa-envelope';
                } elseif ($active_site == 'podcast') {
                    $class = 'fas fa-podcast';
                } elseif ($active_site == 'wechat') {
                    $class = 'fab fa-weixin';
                } elseif ($active_site == 'pocket') {
                    $class = 'fab fa-get-pocket';
                } elseif ($active_site == 'phone') {
                    $class = 'fas fa-phone';
                } elseif ($active_site == 'twitter') {
                    $class = 'fab fa-square-x-twitter';
                }  else {
                    $class = 'fab fa-' . esc_attr($active_site);
                }

                if ($active_site == 'email') {
                    $email = antispambot(is_email(get_theme_mod($key))); ?>
						<li>
							<a class="email" target="_blank"
							   href="mailto:<?php echo $email; ?>" aria-label="<?php echo esc_attr__('email', 'founder') . ' ' . $email; ?>">
								<i class="fas fa-envelope" title="<?php esc_attr_e('email', 'founder'); ?>"></i>
								<span class="screen-reader-text"><?php esc_html_e('email', 'founder'); ?></span>
							</a>
						</li>
					<?php
                } elseif ($active_site == 'skype') { ?>
                    <li>
                        <a class="<?php echo esc_attr($active_site); ?>" target="_blank"
                            href="<?php echo esc_url(get_theme_mod($key), array( 'http', 'https', 'skype' )); ?>" aria-label="<?php esc_attr_e($active_site); ?>">
                            <i class="<?php echo esc_attr($class); ?>" title="<?php echo esc_attr($active_site); ?>"></i>
                            <span class="screen-reader-text"><?php echo esc_html($active_site); ?></span>
                        </a>
                    </li>
                <?php } elseif ($active_site == 'phone') { ?>
                    <li>
                        <a class="<?php echo esc_attr($active_site); ?>" target="_blank"
                                href="<?php echo esc_url(get_theme_mod($active_site), array( 'tel' )); ?>" aria-label="<?php echo esc_html__('Call', 'founder') . ' ' . esc_attr($active_site); ?>">
                            <i class="<?php echo esc_attr($class); ?>"></i>
                            <span class="screen-reader-text"><?php echo esc_html($active_site);  ?></span>
                        </a>
                    </li>
                <?php } elseif ($active_site == 'social_icon_custom_1' || $active_site == 'social_icon_custom_2' || $active_site == 'social_icon_custom_3') { ?>
                    <li>
                        <a class="<?php echo esc_attr($active_site); ?> custom-icon" target="_blank"
                            href="<?php echo esc_url(get_theme_mod($key)); ?>" aria-label="<?php esc_attr_e($active_site); ?>">
                            <img class="icon" src="<?php echo esc_url(get_theme_mod($active_site . '_image')); ?>" style="width: <?php echo absint(get_theme_mod($active_site . '_size', '20')); ?>px;" />
                            <span class="screen-reader-text"><?php echo esc_html($active_site); ?></span>
                        </a>
                    </li>
                <?php } else { ?>
                    <li>
                        <a class="<?php echo esc_attr($active_site); ?>" target="_blank"
                            href="<?php echo esc_url(get_theme_mod($key)); ?>" aria-label="<?php esc_attr_e($active_site); ?>"
                            <?php if ($active_site == 'mastodon') {
                                echo 'rel="me"';
                            } ?>>
                            <i class="<?php echo esc_attr($class); ?>" title="<?php echo esc_attr($active_site); ?>"></i>
                            <span class="screen-reader-text"><?php echo esc_html($active_site); ?></span>
                        </a>
                    </li>
                    <?php
                }
            }
            echo "</ul>";
        }
    }
}

/*
 * WP will apply the ".menu-primary-items" class & id to the containing <div> instead of <ul>
 * making styling difficult and confusing. Using this wrapper to add a unique class to make styling easier.
 */
if (! function_exists(('ct_founder_wp_page_menu'))) {
    function ct_founder_wp_page_menu()
    {
        wp_page_menu(
            array(
                "menu_class" => "menu-unset",
                "depth"      => - 1
            )
        );
    }
}

if (! function_exists(('ct_founder_nav_dropdown_buttons'))) {
    function ct_founder_nav_dropdown_buttons($item_output, $item, $depth, $args)
    {
        if ($args->theme_location == 'primary') {
            if (in_array('menu-item-has-children', $item->classes) || in_array('page_item_has_children', $item->classes)) {
                $item_output = str_replace($args->link_after . '</a>', $args->link_after . '</a><button class="toggle-dropdown" aria-expanded="false" name="toggle-dropdown"><span class="screen-reader-text">' . esc_html__("open menu", "founder") . '</span><i class="fas fa-angle-down"></i></button>', $item_output);
            }
        }

        return $item_output;
    }
}
add_filter('walker_nav_menu_start_el', 'ct_founder_nav_dropdown_buttons', 10, 4);

if (! function_exists(('ct_founder_sticky_post_marker'))) {
    function ct_founder_sticky_post_marker()
    {

        // sticky_post_status only included in content-archive, so it will only show on the blog
        if (is_sticky() && !is_archive() && !is_search()) {
            echo '<div class="sticky-status"><span>' . esc_html__("Featured Post", "founder") . '</span></div>';
        }
    }
}
add_action('sticky_post_status', 'ct_founder_sticky_post_marker');

if (! function_exists(('ct_founder_reset_customizer_options'))) {
    function ct_founder_reset_customizer_options()
    {
        if (empty($_POST['founder_reset_customizer']) || 'founder_reset_customizer_settings' !== $_POST['founder_reset_customizer']) {
            return;
        }

        if (! wp_verify_nonce($_POST['founder_reset_customizer_nonce'], 'founder_reset_customizer_nonce')) {
            return;
        }

        if (! current_user_can('edit_theme_options')) {
            return;
        }

        $mods_array = array(
            'logo_upload',
            'search_bar',
            'full_post',
            'excerpt_length',
            'read_more_text',
            'comments_display',
            'custom_css'
        );

        $social_sites = ct_founder_social_array();

        // add social site settings to mods array
        foreach ($social_sites as $social_site => $value) {
            $mods_array[] = $social_site;
        }

        $mods_array = apply_filters('ct_founder_mods_to_remove', $mods_array);

        foreach ($mods_array as $theme_mod) {
            remove_theme_mod($theme_mod);
        }

        $redirect = admin_url('themes.php?page=founder-options');
        $redirect = add_query_arg('founder_status', 'deleted', $redirect);

        // safely redirect
        wp_safe_redirect($redirect);
        exit;
    }
}
add_action('admin_init', 'ct_founder_reset_customizer_options');

if (! function_exists(('ct_founder_delete_settings_notice'))) {
    function ct_founder_delete_settings_notice()
    {
        if (isset($_GET['founder_status'])) {
            if ($_GET['founder_status'] == 'deleted') {
                ?>
				<div class="updated">
					<p><?php esc_html_e('Customizer settings deleted.', 'founder'); ?></p>
				</div>
				<?php
            }
        }
    }
}
add_action('admin_notices', 'ct_founder_delete_settings_notice');

if (! function_exists(('ct_founder_body_class'))) {
    function ct_founder_body_class($classes)
    {
        global $post;
        $full_post = get_theme_mod('full_post');

        if ($full_post == 'yes') {
            $classes[] = 'full-post';
        }

        // add all historic singular classes
        if (is_singular()) {
            $classes[] = 'singular';
            if (is_singular('page')) {
                $classes[] = 'singular-page';
                $classes[] = 'singular-page-' . $post->ID;
            } elseif (is_singular('post')) {
                $classes[] = 'singular-post';
                $classes[] = 'singular-post-' . $post->ID;
            } elseif (is_singular('attachment')) {
                $classes[] = 'singular-attachment';
                $classes[] = 'singular-attachment-' . $post->ID;
            }
        }

        return $classes;
    }
}
add_filter('body_class', 'ct_founder_body_class');

if (! function_exists(('ct_founder_post_class'))) {
    function ct_founder_post_class($classes)
    {
        $classes[] = 'entry';

        return $classes;
    }
}
add_filter('post_class', 'ct_founder_post_class');

if (! function_exists(('ct_founder_custom_css_output'))) {
    function ct_founder_custom_css_output()
    {
        if (function_exists('wp_get_custom_css')) {
            $custom_css = wp_get_custom_css();
        } else {
            $custom_css = get_theme_mod('custom_css');
        }

        if ($custom_css) {
            $custom_css = ct_founder_sanitize_css($custom_css);
            wp_add_inline_style('ct-founder-style', $custom_css);
            wp_add_inline_style('ct-founder-style-rtl', $custom_css);
        }
    }
}
add_action('wp_enqueue_scripts', 'ct_founder_custom_css_output', 20);

if (! function_exists(('ct_founder_add_meta_elements'))) {
    function ct_founder_add_meta_elements()
    {
        $meta_elements = '';

        $meta_elements .= sprintf('<meta charset="%s" />' . "\n", esc_attr(get_bloginfo('charset')));
        $meta_elements .= '<meta name="viewport" content="width=device-width, initial-scale=1" />' . "\n";

        $theme    = wp_get_theme(get_template());
        $template = sprintf('<meta name="template" content="%s %s" />' . "\n", esc_attr($theme->get('Name')), esc_attr($theme->get('Version')));
        $meta_elements .= $template;

        echo $meta_elements;
    }
}
add_action('wp_head', 'ct_founder_add_meta_elements', 1);

if (! function_exists(('ct_founder_infinite_scroll_render'))) {
    function ct_founder_infinite_scroll_render()
    {
        while (have_posts()) {
            the_post();
            get_template_part('content', 'archive');
        }
    }
}

if (! function_exists('ct_founder_get_content_template')) {
    function ct_founder_get_content_template()
    {

        // Get bbpress.php for all bbpress pages
        if (function_exists('is_bbpress')) {
            if (is_bbpress()) {
                get_template_part('content/bbpress');
                return;
            }
        }
        if (is_home() || is_archive()) {
            get_template_part('content-archive', get_post_type());
        } else {
            get_template_part('content', get_post_type());
        }
    }
}

// allow skype URIs to be used
if (! function_exists(('ct_founder_allow_skype_protocol'))) {
    function ct_founder_allow_skype_protocol($protocols)
    {
        $protocols[] = 'skype';

        return $protocols;
    }
}
add_filter('kses_allowed_protocols', 'ct_founder_allow_skype_protocol');

//----------------------------------------------------------------------------------
// Add paragraph tags for author bio displayed in content/archive-header.php.
// the_archive_description includes paragraph tags for tag and category descriptions, but not the author bio.
//----------------------------------------------------------------------------------
if (! function_exists('ct_founder_modify_archive_descriptions')) {
    function ct_founder_modify_archive_descriptions($description)
    {
        if (is_author()) {
            $description = wpautop($description);
        }
        return $description;
    }
}
add_filter('get_the_archive_description', 'ct_founder_modify_archive_descriptions');

//----------------------------------------------------------------------------------
// Output the markup for the optional scroll-to-top arrow
//----------------------------------------------------------------------------------
function ct_founder_scroll_to_top_arrow()
{
    $setting = get_theme_mod('scroll_to_top');

    if ($setting == 'yes') {
        echo '<button id="scroll-to-top" class="scroll-to-top" aria-label="' . esc_attr__("Scroll to the top", "founder") . '"><span class="screen-reader-text">' . esc_html__('Scroll to the top', 'founder') . '</span><i class="fas fa-arrow-up"></i></button>';
    }
}
add_action('body_bottom', 'ct_founder_scroll_to_top_arrow');

//----------------------------------------------------------------------------------
// Output the "Last Updated" date on posts
//----------------------------------------------------------------------------------
function ct_founder_output_last_updated_date()
{
    global $post;

    if (get_the_modified_date() != get_the_date()) {
        $updated_post = get_post_meta($post->ID, 'ct_founder_last_updated', true);
        $updated_customizer = get_theme_mod('last_updated');
        if (
            ($updated_customizer == 'yes' && ($updated_post != 'no'))
            || $updated_post == 'yes'
        ) {
            echo '<p class="last-updated">' . __("Last updated on", "founder") . ' ' . get_the_modified_date() . ' </p>';
        }
    }
}

//----------------------------------------------------------------------------------
// Output standard post pagination
//----------------------------------------------------------------------------------
if (! function_exists(('ct_founder_pagination'))) {
    function ct_founder_pagination()
    {
        // Never output pagination on bbpress pages
        if (function_exists('is_bbpress')) {
            if (is_bbpress()) {
                return;
            }
        }
        // Output pagination if Jetpack not installed, otherwise check if infinite scroll is active before outputting
        if (!class_exists('Jetpack')) {
            the_posts_pagination(array(
        'prev_text' => esc_html__('Previous', 'founder'),
        'next_text' => esc_html__('Next', 'founder')
      ));
        } elseif (!Jetpack::is_module_active('infinite-scroll')) {
            the_posts_pagination(array(
        'prev_text' => esc_html__('Previous', 'founder'),
        'next_text' => esc_html__('Next', 'founder')
      ));
        }
    }
}

//----------------------------------------------------------------------------------
// Add support for Elementor headers & footers
//----------------------------------------------------------------------------------
function ct_founder_register_elementor_locations($elementor_theme_manager)
{
    $elementor_theme_manager->register_location('header');
    $elementor_theme_manager->register_location('footer');
}
add_action('elementor/theme/register_locations', 'ct_founder_register_elementor_locations');

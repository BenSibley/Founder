( function( $ ) {

    /*
     * Functions for utilizing the postMessage transport setting
     */

    var panel = $('html', window.parent.document);
    var body = $('body');
    var siteTitle = $('#site-title');
    var tagline = $( '.tagline' );

    // Site title
    wp.customize( 'blogname', function( value ) {
        value.bind( function( to ) {
            // if there is a logo, don't replace it
            if( siteTitle.find('img').length == 0 ) {
                siteTitle.children('a').text( to );
            }
        } );
    } );
    // Tagline
    wp.customize( 'blogdescription', function( value ) {
        value.bind( function( to ) {
            if ( tagline.length == 0 ) {
                $('#title-container').append('<p class="tagline"></p>');
            }
            tagline.text( to );
        } );
    } );

    // Logo
    wp.customize( 'logo_upload', function( value ) {
        value.bind( function( to ) {
            var link = siteTitle.children('a');
            if ( to != '' ) {
                link.html('<img class="logo" src="' + to + '" />');
            } else {
                link.html( panel.find('#customize-control-blogname').find('input').val() );
            }
        } );
    } );

    // Social Media Icons

    // get all controls for social sites
    // 4.7 changed the markup of the Customizer, so check if new markup being used first
    var socialSites = panel.find('#sub-accordion-section-ct_founder_social_media_icons').find('.customize-control-title');
    var WPVersion = 4.7;
    if ( socialSites.length == false ) {
        socialSites = panel.find('#accordion-section-ct_founder_social_media_icons').find('.customize-control-title');
        WPVersion = 4.6;
    }

    // instantiate array
    var socialSitesArray = [];

    // create array from social site controls
    socialSites.each( function() {
        socialSitesArray.push( $(this).text() );
    });

    // for each social site
    $.each( socialSitesArray, function(index, name) {

        // replace spaces with hyphens, and convert to lowercase
        var site = name.replace(/\s+/g, '-').toLowerCase();

        // convert email-address to email
        if ( site === 'email-address') site = 'email';
        if ( site === 'contact-form') site = 'email-form';
        if ( site === 'ok.ru') site = 'ok-ru';

        // icons that should use a special square icon
        var squareIcons = ['twitter', 'vimeo', 'youtube', 'pinterest', 'rss', 'reddit', 'tumblr', 'steam', 'xing', 'github', 'google-plus', 'behance', 'facebook'];

        // when a social site value is updated
        wp.customize( site, function (value) {
            value.bind(function (to) {

                // relocate the social media icons list
                var socialMediaIcons = $('.social-media-icons');

                // if it doesn't exist, add it
                if( !socialMediaIcons.length ) {
                    $('#menu-primary-container').append('<ul class="social-media-icons"></ul>');
                    var socialMediaIcons = $('.social-media-icons');
                }

                // empty the social icons list
                socialMediaIcons.empty();

                // replace all at once to preserve order
                var selector = panel.find('#sub-accordion-section-ct_founder_social_media_icons').find('input');
                if ( WPVersion != 4.7 ) {
                    selector = panel.find('#accordion-section-ct_founder_social_media_icons').find('input')
                }
                selector.each(function() {

                    // if the icon has a URL
                    if( $(this).val().length > 0 ) {

                        // get the name of the site
                        var siteName = $(this).attr('data-customize-setting-link');

                        // get class based on presence in squareicons list
                        if ( $.inArray( siteName, squareIcons ) > -1 ) {
                            if ( siteName == 'rss') {
                                var siteClass = 'fas fa-rss-square';
                            } else {
                                var siteClass = 'fab fa-' + siteName + '-square';
                            }
                        } else if ( siteName == 'ok-ru') {
                            var siteClass = 'fab fa-odnoklassniki';
                        } else if ( siteName == 'podcast') {
                            var siteClass = 'fas fa-podcast';
                        } else if ( siteName == 'wechat') {
                            var siteClass = 'fab fa-weixin';
                        } else if ( siteName == 'pocket') {
                            var siteClass = 'fab fa-get-pocket';
                        } else if ( siteName == 'phone') {
                            var siteClass = 'fas fa-phone';
                        } else {
                            var siteClass = 'fab fa-' + siteName;
                        }

                        // output the content for the icon
                        if( siteName == 'email' ) {
                            socialMediaIcons.append( '<li><a target="_blank" href="mailto:' + $(this).val() + '"><i class="fas fa-envelope"></i></a></li>' );
                        }
                        else if( siteName == 'email-form' ) {
                            socialMediaIcons.append('<li><a class="' + siteName + '" target="_blank" href="' + $(this).val() + '"><i class="far fa-envelope"></i></a></li>');
                        }
                        else {
                            socialMediaIcons.append('<li><a class="' + siteName + '" target="_blank" href="' + $(this).val() + '"><i class="' + siteClass + '"></i></a></li>');
                        }
                    }
                });
            });
        });
    });

} )( jQuery );
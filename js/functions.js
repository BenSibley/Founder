jQuery(document).ready(function($){

    var body = $('body');
    var siteHeader = $('#site-header');
    var titleContainer = $('#title-container');
    var toggleNavigation = $('#toggle-navigation');
    var menuPrimaryContainer = $('#menu-primary-container');
    var menuPrimary = $('#menu-primary');
    var menuPrimaryItems = $('#menu-primary-items');
    var toggleDropdown = $('.toggle-dropdown');
    var toggleSidebar = $('#toggle-sidebar');
    var sidebarPrimary = $('#sidebar-primary');
    var sidebarPrimaryContent = $('#sidebar-primary-content');
    var sidebarWidgets = $('#sidebar-primary-widgets');
    var socialMediaIcons = siteHeader.find('.social-media-icons');
    var menuLink = $('.menu-item').children('a');

    // add fitvids to all vids in posts/pages
    $('.post').fitVids();

    // centers 2nd tier menus with their parent menu items
    centerDropdownMenus();

    // put menu into new line if touching social icons
    socialIconAdjustment();

    // make links and inputs inaccessible to keyboards unless sidebar is open
    sidebarKeyboardNav();

    // turn aria-hidden on/off for primary menu based on current screen width
    menuPrimaryContainerARIA();

    $(window).resize(function(){
        centerDropdownMenus();
        socialIconAdjustment();
        sidebarHeightResize();
        menuPrimaryContainerARIA();
    });

    toggleNavigation.on('click', openPrimaryMenu);

    function openPrimaryMenu() {

        if( menuPrimaryContainer.hasClass('open') ) {
            menuPrimaryContainer.removeClass('open');
            $(this).removeClass('open');

            // change screen reader text
            $(this).children('span').text(objectL10n.openMenu);

            // change aria expanded
            $(this).attr('aria-expanded', 'false');

            // change aria hidden
            menuPrimaryContainer.attr('aria-hidden', 'true');

        } else {
            menuPrimaryContainer.addClass('open');
            $(this).addClass('open');

            // change screen reader text
            $(this).children('span').text(objectL10n.closeMenu);

            // change aria expanded
            $(this).attr('aria-expanded', 'true');

            // change aria hidden
            menuPrimaryContainer.attr('aria-hidden', 'false');
        }
    }

    // display the dropdown menus
    toggleDropdown.on('click', openDropdownMenu);

    function openDropdownMenu() {

        // get the buttons parent (li)
        var menuItem = $(this).parent();

        // if already opened
        if( menuItem.hasClass('open') ) {

            // remove open class
            menuItem.removeClass('open');

            // change screen reader text
            $(this).children('span').text(objectL10n.openMenu);

            // change aria text
            $(this).attr('aria-expanded', 'false');
        } else {

            // add class to open the menu
            menuItem.addClass('open');

            // change screen reader text
            $(this).children('span').text(objectL10n.closeMenu);

            // change aria text
            $(this).attr('aria-expanded', 'true');
        }
    }

    // display the sidebar
    toggleSidebar.on('click', openSidebar);

    function openSidebar() {

        if( sidebarPrimary.hasClass('open') ) {
            sidebarPrimary.removeClass('open');

            // if viewport is lower than top of sidebar, scroll up that distance
            var viewportTop = $(window).scrollTop();
            var sidebarTop = sidebarPrimary.offset().top;

            // if visitor has scrolled down so top of sidebar is out of view
            if( viewportTop > sidebarTop  ) {
                var distance = sidebarTop - 24;
                if( $(window).width() > 899 ) {
                    $('html, body').animate({scrollTop: distance}, 200);
                } else {
                    $('html, body').scrollTop(distance);
                }

            }

            // change screen reader text
            $(this).children('span').text(objectL10n.openSidebar);

            // change aria expanded
            $(this).attr('aria-expanded', 'false');

            // change aria hidden
            sidebarPrimaryContent.attr('aria-hidden', 'true');

            if( $(window).width() > 899 ) {
                sidebarPrimaryContent.css('max-height', '' );
            }

            // remove access to links/inputs in sidebar
            sidebarKeyboardNav();

        } else {
            sidebarPrimary.addClass('open');

            // change screen reader text
            $(this).children('span').text(objectL10n.closeSidebar);

            // change aria expanded
            $(this).attr('aria-expanded', 'true');

            // change aria hidden
            sidebarPrimaryContent.attr('aria-hidden', 'false');

            if( $(window).width() > 899 ) {
                sidebarPrimaryContent.css('max-height', sidebarWidgets.outerHeight() );
            }

            // provide access to links/inputs in sidebar
            sidebarKeyboardNav();
        }
    }
    // if screen is resized while sidebar is open, update max-height to keep widgets
    // from being cut-off. Only necessary b/c of animation (can't do max-height: none;)
    function sidebarHeightResize() {

        if( sidebarPrimary.hasClass('open') && $(window).width() > 899 ) {
            sidebarPrimaryContent.css('max-height', sidebarWidgets.outerHeight() );
        } else {
            sidebarPrimaryContent.css('max-height', '');
        }
    }

    // centers 2nd tier menus with their parent menu items
    function centerDropdownMenus() {

        if( $(window).width() > 899 ) {

            var parentMenuItemsTier2 = menuPrimaryItems.children('.menu-item-has-children');

            parentMenuItemsTier2.each(function(){
                var parentWidth = $(this).width();
                var childWidth = $(this).children('ul').outerWidth();
                if( childWidth > parentWidth ) {
                    var difference = childWidth - parentWidth;
                    difference = difference / 2;
                    if( body.hasClass('rtl') ) {
                        $(this).children('ul').css('right', -difference);
                    } else {
                        $(this).children('ul').css('left', -difference);
                    }
                }
            });

            var parentMenuItemsTier3 = menuPrimaryItems.find('ul ul');

            parentMenuItemsTier3.each(function(){
                var height = $(this).outerHeight();
                height = height / 2;
                var parentLink = $(this).parent().children('a');
                var parentLinkHeight = parentLink.height();
                parentLinkHeight = parentLinkHeight / 2;
                // added one px b/c always off by a bit
                $(this).css('top', -height + parentLinkHeight + 1);
            });
        } else {
            if( body.hasClass('rtl') ) {
                menuPrimaryItems.find('ul').css({
                    'right': '',
                    'top' : ''
                });
            } else {
                menuPrimaryItems.find('ul').css({
                    'left': '',
                    'top' : ''
                });
            }
        }
    }

    // if menu doesn't fit next to social icons, move to next line
    function socialIconAdjustment(){

        // if at non-mobile menu width and social icons exist
        if( $(window).width() > 899 && socialMediaIcons.length > 0 ) {

            // get the width of all the header elements
            var space = siteHeader.width();
            var titleWidth = titleContainer.width() + parseInt(titleContainer.css('margin-right'));
            var menuWidth = menuPrimary.width();
            var iconsWidth = socialMediaIcons.width();

            // is there enough space? (24 extra space between menu and icons)
            if( space - titleWidth - menuWidth - iconsWidth - 24 < 0 ) {
                menuPrimaryContainer.css('display', 'block');
            } else {
                menuPrimaryContainer.css('display', 'inline-block');
            }
        } else {
            menuPrimaryContainer.css('display', '');
        }
    }

    /* allow keyboard access/visibility for dropdown menu items */
    menuLink.focus(function(){
        $(this).parents('ul').addClass('focused');
    });
    menuLink.focusout(function(){
        $(this).parents('ul').removeClass('focused');
    });

    // make links and inputs inaccessible to keyboards unless sidebar is open
    function sidebarKeyboardNav() {

        if( sidebarPrimary.hasClass('open') ) {
            sidebarPrimaryContent.find('a, input').each(function(){
                $(this).attr('tabindex', '0');
            });
        } else {
            sidebarPrimaryContent.find('a, input').each(function(){
                $(this).attr('tabindex', '-1');
            });
        }
    }

    function menuPrimaryContainerARIA(){

        if( $(window).width() > 899 ) {
            menuPrimaryContainer.attr('aria-hidden', 'false');
        } else {
            if( !menuPrimaryContainer.hasClass('open') ) {
                menuPrimaryContainer.attr('aria-hidden', 'true');
            }
        }
    }
});

/* fix for skip-to-content link bug in Chrome & IE9 */
window.addEventListener("hashchange", function(event) {

    var element = document.getElementById(location.hash.substring(1));

    if (element) {

        if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
            element.tabIndex = -1;
        }

        element.focus();
    }

}, false);
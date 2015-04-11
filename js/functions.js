jQuery(document).ready(function($){

    var toggleNavigation = $('#toggle-navigation');
    var menuPrimaryContainer = $('#menu-primary-container');
    var menuPrimary = $('#menu-primary');
    var menuPrimaryItems = $('#menu-primary-items');
    var toggleDropdown = $('.toggle-dropdown');
    var toggleSidebar = $('#toggle-sidebar');
    var sidebarPrimary = $('#sidebar-primary');
    var sidebarPrimaryContent = $('#sidebar-primary-content');
    var sidebarWidgets = $('#sidebar-primary-widgets');

    // centers 2nd tier menus with their parent menu items
    centerDropdownMenus();

    toggleNavigation.on('click', openPrimaryMenu);

    function openPrimaryMenu() {

        if( menuPrimaryContainer.hasClass('open') ) {
            menuPrimaryContainer.removeClass('open');
            $(this).removeClass('open');
        } else {
            menuPrimaryContainer.addClass('open');
            $(this).addClass('open');
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
            $(this).children('span').text('open child menu');

            // change aria text
            $(this).attr('aria-expanded', 'false');
        } else {

            // add class to open the menu
            menuItem.addClass('open');

            // change screen reader text
            $(this).children('span').text('close child menu');

            // change aria text
            $(this).attr('aria-expanded', 'true');
        }
    }

    // display the sidebar
    toggleSidebar.on('click', openSidebar);

    function openSidebar() {

        if( sidebarPrimary.hasClass('open') ) {
            sidebarPrimary.removeClass('open');

            if( $(window).width() > 899 ) {
                sidebarPrimaryContent.css('max-height', '' );
            }
        } else {
            sidebarPrimary.addClass('open');

            if( $(window).width() > 899 ) {
                sidebarPrimaryContent.css('max-height', sidebarWidgets.outerHeight() );
            }
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
                    $(this).children('ul').css('left', -difference);
                }
            });

            var parentMenuItemsTier3 = menuPrimaryItems.find('ul ul');

            parentMenuItemsTier3.each(function(){
                var height = $(this).outerHeight();
                height = height / 2;
                var parentLink = $(this).parent().children('a');
                var parentLinkHeight = parentLink.height();
                parentLinkHeight = parentLinkHeight / 2;
                $(this).css('top', -height + parentLinkHeight);
            });
        }
    }
});
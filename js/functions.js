jQuery(document).ready(function($){

    var toggleNavigation = $('#toggle-navigation');
    var menuPrimary = $('#menu-primary');
    var toggleDropdown = $('.toggle-dropdown');

    // centers 2nd tier menus with their parent menu items
    centerDropdownMenus();

    toggleNavigation.on('click', openPrimaryMenu);

    function openPrimaryMenu() {

        if( menuPrimary.hasClass('open') ) {
            menuPrimary.removeClass('open');
            $(this).removeClass('open');
        } else {
            menuPrimary.addClass('open');
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

    // centers 2nd tier menus with their parent menu items
    function centerDropdownMenus() {

        if( $(window).width() > 899 ) {

            var parentMenuItems = $('#menu-primary-items').find('.menu-item-has-children');

            parentMenuItems.each(function(){
                var parentWidth = $(this).width();
                var childWidth = $(this).children('ul').outerWidth();
                if( childWidth > parentWidth ) {
                    var difference = childWidth - parentWidth;
                    difference = difference / 2;
                    $(this).children('ul').css('left', -difference);
                }
            });
        }
    }
});
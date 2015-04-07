jQuery(document).ready(function($){


    var toggleNavigation = $('#toggle-navigation');
    var menuPrimary = $('#menu-primary');
    var toggleDropdown = $('.toggle-dropdown');

    toggleNavigation.on('click', openPrimaryMenu);

    function openPrimaryMenu() {

        if( menuPrimary.hasClass('open') ) {
            menuPrimary.removeClass('open');
        } else {
            menuPrimary.addClass('open');
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
});
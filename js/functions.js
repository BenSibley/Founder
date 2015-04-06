jQuery(document).ready(function($){


    var toggleNavigation = $('#toggle-navigation');
    var menuPrimary = $('#menu-primary');

    toggleNavigation.on('click', openPrimaryMenu);

    function openPrimaryMenu() {

        if( menuPrimary.hasClass('open') ) {
            menuPrimary.removeClass('open');
        } else {
            menuPrimary.addClass('open');
        }
    }
});
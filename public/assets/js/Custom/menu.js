/**
 * Created by Nico on 29/08/2015.
 */


(function(){

    var menu = menu || {};

    menu.menuActive = null;

    $('.navbar-nav a').click(function(){

        if(menu.menuActive)
            menu.menuActive.removeClass('active');

        menu.menuActive =  $(this).parent();

        menu.menuActive.addClass('active');

    })

});



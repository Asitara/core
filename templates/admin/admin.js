$(document).ready(function(){
    console.log();
    // prüfe und richte ggf. wrapper, section, ... höhe aus
    // wenn controlPanel -> personalArea.height() != default_height
    $(window).scroll(function(){
        //----
        // default ist das menü fest zum body/wrapper
        // prüfe mit JS ob menü über fensterhöhe geht
        // wenn ja lass normal und registriere mit .scroll() ob menu-bottom reached
        // sonst posi:fixed mit einem empty berreich bis fenster bottom
    });
    
    
    // re-posi the .mainmenu .sub_menu ;; so it'll be copy of .mainmenu design
    // the width calculating is still a lil bit buggy
//
// var pos_admin  = $('#adminmenu .menu-content').width();
// var pos_window = $(window).width();
//
//
// mainmenu_pos_sub_menus();
// $(window).resize(function(){
//     mainmenu_pos_sub_menus();
// });
//
// function mainmenu_pos_sub_menus(){
//     $('#mainmenu .mainmenu .sub-menu').each(function(){
//         $(this).prop('style', 'display:block;');
//         var relative_pos = $(this).offsetParent().offset().left;
//         $(this).prop('style', false);
//
//         var new_pos = (-Math.abs(relative_pos)) + pos_admin;
//
//         $(this).css('width', pos_window+'px');
//         $(this).css('left', new_pos+'px');
//     });
// }
    
    
    // DEBUGGING
    $('ul.adminmenu').addClass('menu-content').removeClass('adminmenu');
});

function test_localstorage(){
    var testKey = 'test';
    
    try {
        localStorage.setItem(testKey, '1');
        localStorage.removeItem(testKey);
        return true;
        
    }catch(error){
        return false;
    }
}
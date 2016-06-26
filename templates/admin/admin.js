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
});
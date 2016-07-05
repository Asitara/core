// Runtime Error Handler
window.onerror = function(msg, file, line, col, trace){
    acp_error_handler({'msg':msg, 'file':file, 'line':line, 'col':col, 'trace':trace});
}
function acp_error_handler(obj_error = {'msg':''}){
    var error_count     = 0;
    var return_string   = '';
    
    if(obj_error.msg.length > 0){
        if($('#debug-console .issues').data('js-error') == null){
            $('#debug-console .issues').attr('data-js-error', 0).data('js-error', 0);
        }
    }
    
    $.each($('#debug-console .issues').data(), function(key){
        var value = this;
        var match = key.match(/([a-z]+)Error/);
        
        if(match != null && value >= 0){
            if(match[1] == 'js'){ value++; $('#debug-console .issues').attr('data-js-error', value).data('js-error', value); }
            
            return_string += '<span class="error-type" data-type="'+match[1]+'">'+value+'</span>';
            error_count += value;
        }
        if(error_count > 0){
            $('#debug-console .issues').html(error_count+' Issues: '+return_string);
        }
    });
}

var localstorage_test = (test_localstorage());
var acp_mainmenu = localStorage.getItem('acp_mainmenu');
var acp_console = sessionStorage.getItem('acp_console');

$(document).ready(function(){
    // acp_console
    if(acp_console == 'open' || (acp_console === null && $('#debug-console > button').data('handle') == 'close')) acp_console_handle('open', false);
    
    // mainmenu - open/close -
    if(acp_mainmenu === null || acp_mainmenu == 'close' || acp_mainmenu == false){
        acp_mainmenu_handle('close', 0);
    }
    
    $('#personalAreaMenuButton').click(function(){
        if(acp_mainmenu == 'open')  { acp_mainmenu_handle('close'); }
        else                        { acp_mainmenu_handle('open');  }
    });
    
    // mainmenu - skew style -
    $('#mainmenu .mainmenu > li > a').each(function(){
        $(this).html('<span><span>'+$(this).html()+'</span></span>');
    });
    $('#mainmenu .mainmenu').addClass('skew');
    
    
    //NOTE: maybe we don't need it anymore
    // footer position
    // setInterval(function(){
    //     if($('#wrapper').height() > $('#controlPanel').height()){
    //         if(!$('#footer').hasClass('max-size')) $('#footer').addClass('max-size');
    //     }else{
    //         if($('#footer').hasClass('max-size')) $('#footer').removeClass('max-size');
    //     }
    // }, 3000);
    
    acp_error_handler();
});

function acp_mainmenu_handle(handle, duration = 1000){
    if(handle == 'open'){
        $('#mainmenu').slideDown({easing: 'easeOutBounce', duration: duration});
        acp_mainmenu = 'open';
        
    }else{
        $('#mainmenu').slideUp({easing: 'easeOutBounce', duration: duration});
        acp_mainmenu = 'close';
    }
    if(localstorage_test) localStorage.setItem('acp_mainmenu', acp_mainmenu);
}

function acp_adminmenu_handle(){
    if( $('#adminmenu').hasClass('menu-closed')){
        $('#adminmenu').removeClass('menu-closed');
        // $('#adminmenu .menu-indicator').hide();
        $('#adminmenu .menu-content').show("slide", { direction: "left" }, 2000, function(){
            //TODO: maybe lets add via sessionStorage (last opened sub-menu) which we save at hiding
        });
        
    }else{
        // $('#adminmenu').addClass('menu-closed');
        $('#adminmenu .menu-content').hide("slide", { direction: "left" }, 2000, function(){
            $('#adminmenu .menu-content > li > a').each(function(){
                if( $(this).hasClass('open')) $(this).removeClass('open');
            });
            $('#adminmenu .menu-indicator').css('height', $('#wrapper').height()+'px');
            $('#adminmenu').addClass('menu-closed');
            // $('#adminmenu .menu-indicator').show();
        });
    }
}

function acp_console_handle(handle, scroll = false){
    if(handle == 'open'){
        acp_console = 'open';
        $('#debug-console > button').data('handle', 'close');
        $('#debug-console .console').slideDown( (scroll)? 1000 : 0 );
        
    }else{
        acp_console = 'close';
        $('#debug-console > button').data('handle', 'open');
        $('#debug-console .console').slideUp( (scroll)? 1000 : 0 );
    }
    if(localstorage_test) sessionStorage.setItem('acp_console', acp_console);
}

function test_localstorage(){
    try {
        localStorage.setItem('test', '1');
        localStorage.removeItem('test');
        return true;
        
    }catch(error){
        return false;
    }
}
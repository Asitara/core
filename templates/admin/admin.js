var localstorage_test = (test_localstorage());
var acp_mainmenu = localStorage.getItem('acp_mainmenu');
var acp_console = sessionStorage.getItem('acp_console');

$(document).ready(function(){
    
    // DEBUGGING
    $('ul.adminmenu').addClass('menu-content').removeClass('adminmenu');
    
    
    
    
    
    // acp_console
    if(acp_console == 'open') acp_console_handle('open', false);
    
    
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
    
    
    //TODO: uncomment it -- only for debugging disabled
    // footer position
    // setInterval(function(){
    //     if($('#wrapper').height() > $('#controlPanel').height()){
    //         if(!$('#footer').hasClass('max-size')) $('#footer').addClass('max-size');
    //     }else{
    //         if($('#footer').hasClass('max-size')) $('#footer').removeClass('max-size');
    //     }
    // }, 3000);
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

//TODO: need to rewrite, still buggy == inconsistent
function acp_console_handle(handle, scroll = false){
    if(handle == 'open'){
        $('#debug-console .console').slideDown(400, function(){
            // $('#debug-console').addClass('open');
            
            
            if(scroll) $('html, body').animate({ scrollTop: $(document).height() }, 1000);
        });
        $('#debug-console > button').attr('data-handle', 'close');
        acp_console = 'open';
    }else{
        $('#debug-console .console').slideUp(400, function(){
            
        });
        $('#debug-console > button').attr('data-handle', 'open');
        acp_console = 'close';
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
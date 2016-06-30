var localstorage_test = (test_localstorage());
var acp_mainmenu = localStorage.getItem('acp_mainmenu');

$(document).ready(function(){
    
    // DEBUGGING
    $('ul.adminmenu').addClass('menu-content').removeClass('adminmenu');
    
    // SKEW mainmenu
    $('#mainmenu .mainmenu li > a').each(function(){
        // lese den inneren html teil aus
        // lege um diesen teil einen wrapper
        // ersetze nun den inneren teil mit den neu erzeugten wrapper+inner
        
        // add .skew klasse und anshließend können wir
        // a.skew { display: block; transform: skew(45deg); }
        // a.skew > span { display: inline-block; transform: skew(-45deg); }
    });
    
    ////////////////////////////////////////////////////////////////////////////////
    
    
    // mainmenu - open/close -
    if(acp_mainmenu === null || acp_mainmenu == 'close' || acp_mainmenu == false){
        acp_mainmenu_handle('close', 0);
    }
    
    $('#personalAreaMenuButton').click(function(){
        if(acp_mainmenu == 'open'){
            acp_mainmenu_handle('close');
        }else{
            acp_mainmenu_handle('open');
        }
    });
    
    // mainmenu - skew style -
    $('#mainmenu .mainmenu > li > a').each(function(){
        $(this).html('<span><span>'+$(this).html()+'</span></span>');
    });
    $('#mainmenu .mainmenu').addClass('skew');
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

function test_localstorage(){
    try {
        localStorage.setItem('test', '1');
        localStorage.removeItem('test');
        return true;
        
    }catch(error){
        return false;
    }
}
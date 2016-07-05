// ACP: Error Handler
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


// Global Vars
var localstorage_test   = (test_localstorage());
var acp_mainmenu        = (localstorage_test)? localStorage.getItem('acp_mainmenu') : null;
var acp_console         = (localstorage_test)? sessionStorage.getItem('acp_console') : null;
var mcp_saved           = (localstorage_test)? localStorage.getItem('mcp_'+mmocms_userid) : "";
var favicon;

$(document).ready(function(){
    if(mmocms_header_type == 'full'){
        user_clock();
        
        // User: Open Dialog
        $( ".openLoginModal" ).on('click', function() {
            $( "#dialog-login" ).dialog( "open" );
        });
        
        // User: Toggle Tooltip
        $('.tooltip-trigger').on('click', function(event){
            event.preventDefault();
            var mytooltip = $(this).data('tooltip');
            $("#"+mytooltip).show('fast');
            $(document).on('click', function(event) {
                var count = $(event.target).parents('.'+mytooltip+'-container').length;
                if (count == 0){
                    $("#"+mytooltip).hide('fast');
                }
            });
        });
        
        // User: DoubleClick Event Handler
        $('.user-tooltip-trigger').on('dblclick', function(event){
            $("#user-tooltip").hide('fast');
            window.location=mmocms_controller_path+"Settings"+mmocms_seo_extension+mmocms_sid;
        });
        $('.admin-tooltip-trigger').on('dblclick', function(event){
            $("#admin-tooltip").hide('fast');
            window.location=mmocms_root_path+"admin"+mmocms_sid;
        });
        
        // User: My Chars Points
        $('.mychars-points-tooltip .char').on('click', function(){
            $(this).parent().parent().children('tr').removeClass("active");
            $(this).parent().addClass("active");
            var current = $(this).parent().find('.current').html();
            var icons = $(this).parent().find('.icons').html();
            $(".mychars-points-target").html(icons + " "+current);
            var id = $(this).parent().attr('id');
            if(test_localstorage()) localStorage.setItem('mcp_'+mmocms_userid, id);
        });
        if (mcp_saved && mcp_saved != "" && $('#'+mcp_saved).find('.current').html() != undefined){
            $('#'+mcp_saved).addClass("active");
            var current = $('#'+mcp_saved).find('.current').html();
            var icons = $('#'+mcp_saved).find('.icons').html();
            $(".mychars-points-target").html(icons + " "+current);
        }else{
            $('.mychars-points-tooltip .main').addClass("active");
            var current = $('.mychars-points-tooltip .main').find('.current').html();
            var icons = $('.mychars-points-tooltip .main').find('.icons').html();
            $(".mychars-points-target").html(icons + " "+current);
        }
        
        
        // ACP: EQdkp+ Console Handler
        if(acp_console == 'open' || (acp_console === null && $('#debug-console > button').data('handle') == 'close')) acp_console_handle('open', false);
        
        // ACP: Main Menu Handler
        if(acp_mainmenu === null || acp_mainmenu == 'close' || acp_mainmenu == false){
            acp_mainmenu_handle('close', 0);
        }
        $('#personalAreaMenuButton').click(function(){
            if(acp_mainmenu == 'open')  { acp_mainmenu_handle('close'); }
            else                        { acp_mainmenu_handle('open');  }
        });
        
        // ACP: Style addition (to skew mainmenu items)
        $('#mainmenu .mainmenu > li > a').each(function(){
            $(this).html('<span><span>'+$(this).html()+'</span></span>');
        });
        $('#mainmenu .mainmenu').addClass('skew');
        
        
        // Notify: Event Handler
        $('.notification-tooltip-trigger').on('click', function(event){
            $(".notification-tooltip").hide('fast');
            $("#notification-tooltip-all").show('fast');
            notification_show_only('all');
            var classList = $(this).attr('class').split(/\s+/);
            for (var i = 0; i < classList.length; i++) {
               if (classList[i] === 'notification-bubble-red' || classList[i] === 'notification-bubble-yellow' || classList[i] === 'notification-bubble-green') {
                 notification_show_only(classList[i]);
                 break;
               }
            }
            $(document).on('click', function(event) {
                var count = $(event.target).parents('.notification-tooltip-container').length;
                if (count == 0 && (!$(event.target).hasClass('notification-markasread')) ){
                    $(".notification-tooltip").hide('fast');
                }
            });
        });
        $('.notification-content').on('click', '.notification-markasread', function() {
            var ids = $(this).parent().parent().data('ids');
            $(this).parent().parent().remove();
            recalculate_notification_bubbles();
            $.get(mmocms_controller_path+"Notifications"+mmocms_seo_extension+mmocms_sid+"&markread&ids="+ids);
        });
        $('.notification-filter').on('click', function(event){
            if ($(this).hasClass('filtered')){
                //Show all of this
                if ($(this).hasClass('notification-bubble-green')) $('.notification-content ul li.prio_0').show();
                if ($(this).hasClass('notification-bubble-yellow')) $('.notification-content ul li.prio_1').show();
                if ($(this).hasClass('notification-bubble-red')) $('.notification-content ul li.prio_2').show();
                $(this).removeClass('filtered');
            } else {
                //hide all of this
                if ($(this).hasClass('notification-bubble-green')) $('.notification-content ul li.prio_0').hide();
                if ($(this).hasClass('notification-bubble-yellow')) $('.notification-content ul li.prio_1').hide();
                if ($(this).hasClass('notification-bubble-red')) $('.notification-content ul li.prio_2').hide();
                $(this).addClass('filtered');
            }
        });
        
        // Notify: Update Notify List in 5 Minutes
        window.setTimeout("notification_update()", 1000*60*5);
        
        
        // ACP: Init Error Handler
        acp_error_handler();
    }
});

// ACP: Toggle Main Menu
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

// ACP: Toggle Admin Menu
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

// ACP: Toggle EQdkp+ Console
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


// Notify: Favicon Changer
function notification_favicon(red, yellow, green){
	if (typeof favicon === 'undefined') return;
	
	if (red > 0) {
		favicon.badge(red, {bgColor: '#d00', type: 'rectangle'});
		return;
	}
	if (yellow > 0) {
		favicon.badge(yellow, {bgColor: '#F89406', type: 'rectangle'});
		return;
	}
	if (green > 0) {
		favicon.badge(green, {bgColor: '#468847', type: 'rectangle'});
		return;
	}
	favicon.reset();
}

// Notify: Filter Notify List
function notification_show_only(name){
	if (name === 'all'){
		$('.notification-filter').removeClass('filtered');
		$('.notification-content ul li.prio_0, .notification-content ul li.prio_1, .notification-content ul li.prio_2').show();
	} else {
		$('.notification-content ul li.prio_0, .notification-content ul li.prio_1, .notification-content ul li.prio_2').hide();
		$('.notification-filter').addClass('filtered');
		$('.'+name+'.notification-filter').removeClass('filtered');
		if (name === 'notification-bubble-green') $('.notification-content ul li.prio_0').show();
		if (name === 'notification-bubble-yellow') $('.notification-content ul li.prio_1').show();
		if (name === 'notification-bubble-red') $('.notification-content ul li.prio_2').show();
	}
}

// Notify: Update Notify List (all 5 minutes)
function notification_update(){
	$.get(mmocms_controller_path+"Notifications"+mmocms_seo_extension+mmocms_sid+"&load", function(data){
		$('.notification-content ul').html(data);
		recalculate_notification_bubbles();
	});
	window.setTimeout("notification_update()", 1000*60*5);
}


// User Clock
function user_clock(){
	var mydate = mymoment.format(user_clock_format);
	$('.user_time').html(mydate);
	mymoment.add(1, 's');
	window.setTimeout("user_clock()", 1000);
}

// LocalStorage test
function test_localstorage(){
    try {
        localStorage.setItem('test', '1');
        localStorage.removeItem('test');
        return true;
        
    }catch(error){
        return false;
    }
}
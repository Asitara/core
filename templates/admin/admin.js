
// Global Vars
var localstorage_test   = (test_localstorage());
var acp_adminmenu		= (localstorage_test)? JSON.parse(localStorage.getItem('acp_adminmenu')) : null;
var acp_mainmenu		= (localstorage_test)? localStorage.getItem('acp_mainmenu') : null;
var acp_console			= (localstorage_test)? sessionStorage.getItem('acp_console') : null;
var mcp_saved			= (localstorage_test)? localStorage.getItem('mcp_'+mmocms_userid) : null;
var favicon;

$(document).ready(function(){
	if(mmocms_header_type == 'full'){
		user_clock();
		
		// ACP: Style addition (to move breadcrumb)
		$('#controlPanel .breadcrumb-container').html( $('#wrapper .breadcrumb-container').html() );
		$('#wrapper .breadcrumb-container').remove();
		
		// ACP: Adminmenu Handler
		if(acp_adminmenu === null){
			acp_adminmenu = {'state':1,'sub_menu':null};
			if(localstorage_test) localStorage.setItem('acp_adminmenu', JSON.stringify(acp_adminmenu));
		}
		switch(true){
			case (acp_adminmenu.state == 2 && acp_adminmenu.sub_menu !== null):
				$('#adminmenu .adminmenu > li[data-category="'+acp_adminmenu.sub_menu+'"]').addClass('open');
				$('#adminmenu .sub-menu-content .sub-menu[data-category="'+acp_adminmenu.sub_menu+'"]').addClass('open');
				$('#adminmenu .sub-menu-content').show(0);
				$('#adminmenu').data('state', 2).attr('data-state', 2);
				break;
			case (acp_adminmenu.state == 0):
				$('#adminmenu .menu-content').hide(0);
				$('#adminmenu').data('state', 0).attr('data-state', 0);
				break;
		}
		$('#adminmenu .adminmenu > li > a').on('click', function(event){
			event.preventDefault()
			
			self			= this;
			open_category	= $(this).parent().data('category');
			close_category	= ($('#adminmenu .sub-menu-content .sub-menu.open').length > 0)? $('#adminmenu .sub-menu-content .sub-menu.open').data('category') : null;
			
			if( $('#adminmenu .sub-menu-content .sub-menu[data-category="'+open_category+'"]').hasClass('open') ){
				acp_adminmenu = {'state':1,'sub_menu':null};
				$('#adminmenu .sub-menu-content').hide('slide', {direction: 'left'}, 500, function(){
					$('#adminmenu .sub-menu-content .sub-menu[data-category="'+open_category+'"]').removeClass('open');
					$(self).parent().removeClass('open');
					$('#adminmenu').data('state', 1).attr('data-state', 1);
				});
			}else if( close_category !== null ){
				acp_adminmenu = {'state':2,'sub_menu':open_category};
				$('#adminmenu .sub-menu-content').hide('slide', {direction: 'left'}, 500, function(){
					$('#adminmenu .sub-menu-content .sub-menu.open').removeClass('open');
					$('#adminmenu .adminmenu > li[data-category="'+close_category+'"]').removeClass('open');
					$('#adminmenu').data('state', 1).attr('data-state', 1);
					
					$('#adminmenu .sub-menu-content .sub-menu[data-category="'+open_category+'"]').addClass('open');
					$('#adminmenu .sub-menu-content').show('slide', {direction: 'left'}, 500, function(){
						$(self).parent().addClass('open');
						$('#adminmenu').data('state', 2).attr('data-state', 2);
					});
				});
			}else{
				acp_adminmenu = {'state':2,'sub_menu':open_category};
				$('#adminmenu .sub-menu-content .sub-menu[data-category="'+open_category+'"]').addClass('open');
				$('#adminmenu .sub-menu-content').show('slide', {direction: 'left'}, 500, function(){
					$(self).parent().addClass('open');
					$('#adminmenu').data('state', 2).attr('data-state', 2);
				});
			}
			if(localstorage_test) localStorage.setItem('acp_adminmenu', JSON.stringify(acp_adminmenu));
		});
		$('#adminmenu .sub-menu-content .sub-menu .fav-link').on('click', function(event){
			event.preventDefault();
			var fav_link	= $(this);
			var fav_state	= $(this).data('favorite');
			if(fav_state == '...') return;
			
			fav_link.data('favorite', '...').attr('data-favorite', '...');
			
			$.post('manage_exportsssssss.php'+mmocms_sid+'&run_husten_process', {
				'husten_key_1': 'value_1',
			}).done(function(response){
				fav_state = (fav_state == false)? 'true' : 'false';
			}).always(function(){
				fav_link.data('favorite', fav_state).attr('data-favorite', fav_state);
			});
			return;
		});
		
		// ACP: Style addition (to skew mainmenu items)
		$('#mainmenu .mainmenu > li > a').each(function(){
			$(this).html('<span><span>'+$(this).html()+'</span></span>');
		});
		$('#mainmenu .mainmenu').addClass('skew');
		
		// ACP: Mainmenu Handler
		if(acp_mainmenu === null || acp_mainmenu == 'close' || acp_mainmenu == false){
			acp_mainmenu_toggle('close', 0);
		}
		$('#personalAreaMenuButton').on('click', function(){
			if(acp_mainmenu == 'open')  { acp_mainmenu_toggle('close'); }
			else						{ acp_mainmenu_toggle('open');  }
		});
		
		// ACP: Style addition (to count the issues)
		acp_issues_counter();
		
		// ACP: EQdkp+ Console Handler
		if(acp_console == 'open' || (acp_console === null && $('#debug-console > button').data('handle') == 'close')) acp_console_toggle('open', false);
		
		
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
		if(mcp_saved && mcp_saved != "" && $('#'+mcp_saved).find('.current').html() != undefined){
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
	}
});

// ACP: Toggle Mainmenu
function acp_mainmenu_toggle(handle, duration = 1000){
	if(handle == 'open'){
		$('#mainmenu').slideDown({easing: 'easeOutBounce', duration: duration});
		acp_mainmenu = 'open';
		
	}else{
		$('#mainmenu').slideUp({easing: 'easeOutBounce', duration: duration});
		acp_mainmenu = 'close';
	}
	if(localstorage_test) localStorage.setItem('acp_mainmenu', acp_mainmenu);
}

// ACP: Toggle Adminmenu
function acp_adminmenu_toggle(){
	var state = $('#adminmenu').data('state');
	acp_adminmenu.sub_menu = ($('#adminmenu .sub-menu-content .sub-menu.open').length > 0)? $('#adminmenu .sub-menu-content .sub-menu.open').data('category') : null;
	
	switch(state){
		case 2:
			acp_adminmenu.state = 0;
			$('#adminmenu .sub-menu-content').hide('slide', {direction: 'left'}, 500, function(){
				$('#adminmenu').data('state', 1).attr('data-state', 1);
				$('#adminmenu .menu-content').hide('slide', {direction: 'left'}, 500, function(){
					$('#adminmenu').data('state', 0).attr('data-state', 0);
					// $('#adminmenu .menu-indicator').slideDown(500);
				});
			});
			break;
		case 1:
			acp_adminmenu.state = 0;
			$('#adminmenu .menu-content').hide('slide', {direction: 'left'}, 500, function(){
				$('#adminmenu').data('state', 0).attr('data-state', 0);
				// $('#adminmenu .menu-indicator').slideDown(500);
			});
			break;
		case 0:
			acp_adminmenu.state = (acp_adminmenu.sub_menu !== null)? 2 : 1;
			$('#adminmenu').data('state', 1).attr('data-state', 1);
			$('#adminmenu .menu-content').show('slide', {direction: 'left'}, 500, function(){
				if( acp_adminmenu.sub_menu !== null ){
					$('#adminmenu').data('state', 2).attr('data-state', 2);
					$('#adminmenu .sub-menu-content').show('slide', {direction: 'left'}, 500);
				}
			});
			break;
	}
	if(localstorage_test) localStorage.setItem('acp_adminmenu', JSON.stringify(acp_adminmenu));
}

// ACP: Toggle EQdkp+ Console
function acp_console_toggle(handle, scroll = false){
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

// ACP: Console Issues Counter
function acp_issues_counter(){
	var error_count		= 0;
	var return_string	= '';
	
	$.each($('#debug-console .issues').data(), function(key){
		var value	= this;
		var match	= key.match(/([a-z]+)Error/);
	
		if(match != null && value >= 0){
			return_string += '<span class="error-type" data-type="'+match[1]+'">'+value+'</span>';
			error_count += value;
		}
		if(error_count > 0){
			$('#debug-console .issues').html(error_count+' Issues: '+return_string);
		}
	});
}


// Notify: Favicon Changer
function notification_favicon(red, yellow, green){
	if (typeof favicon === 'undefined') return;
	
	switch(true){
		case (red > 0):	 favicon.badge(red, {bgColor: '#D00', type: 'rectangle'});	   return;
		case (yellow > 0):  favicon.badge(yellow, {bgColor: '#F89406', type: 'rectangle'}); return;
		case (green > 0):   favicon.badge(green, {bgColor: '#468847', type: 'rectangle'});  return;
		default:			favicon.reset();
	}
	return;
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
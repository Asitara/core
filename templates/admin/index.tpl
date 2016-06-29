<!-- IF S_NO_HEADER_FOOTER -->
{GBL_CONTENT_BODY}
<!-- ELSE -->
<!DOCTYPE html>
<html lang="{L_XML_LANG}">
	<head>
		<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=9" /><![endif]-->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="{META_KEYWORDS}" />
		<meta name="description" content="{META_DESCRIPTION}" />
		<meta name="author" content="{GUILD_TAG}" />
		<!-- IF S_REPONSIVE -->
		<meta name="viewport" content="width=device-width,initial-scale=1.0" />
		<!-- ENDIF -->
		{META}
		{LINK}
		<title>{PAGE_TITLE}</title>
		{CSS_FILES}
		{JS_FILES}
		<link rel="shortcut icon" href="{EQDKP_ROOT_PATH}templates/admin/images/favicon.png" type="image/png" />
		<link rel="icon" href="{EQDKP_ROOT_PATH}templates/admin/images/favicon.png" type="image/x-icon" />
		<link rel="apple-touch-icon" href="{EQDKP_ROOT_PATH}templates/admin/images/apple-touch-icon.png" />
		{RSS_FEEDS}
		<!-- LISTENER head -->
		<style type="text/css">
			{CSS_CODE}
		</style>
		
		<script type="text/javascript">
			//<![CDATA[
			{JS_CODE}
			//]]>
		</script>
	</head>
	<body id="top" class="<!-- IF S_REPONSIVE -->responsive <!-- ENDIF --><!-- IF not S_NORMAL_HEADER -->simple-header<!-- ENDIF --> {BROWSER_CLASS}">
		<!-- LISTENER body_top -->
		
		{STATIC_HTMLCODE}
		
		<header id="controlPanel">
			<div id="personalArea">
				<div class="personalAreaInnerLeft">
					<div id="personalAreaUser">
						<!-- IF not S_LOGGED_IN -->
						<ul>
							<li><a href="{EQDKP_CONTROLLER_PATH}Login{SEO_EXTENSION}{SID}" class="openLoginModal" onclick="return false;"><i class="fa fa-sign-in fa-lg"></i> {L_login}</a></li>
							<!-- IF U_REGISTER != "" --><li>{U_REGISTER}</li><!-- ENDIF -->
							
							<li>
								<div class="langswitch-tooltip-container">
									<a href="#" class="langswitch-tooltip-trigger tooltip-trigger" data-tooltip="langswitch-tooltip">{USER_LANGUAGE_NAME}</a>
									<ul class="dropdown-menu langswitch-tooltip" role="menu" id="langswitch-tooltip">
										<!-- BEGIN languageswitcher_row -->
										<li><a href="{languageswitcher_row.LINK}">{languageswitcher_row.LANGNAME}</a></li>
										<!-- END languageswitcher_row -->
									</ul>
								</div>
							</li>
							
							<!-- BEGIN personal_area_addition -->
							<li>{personal_area_addition.TEXT}</li>
							<!-- END personal_area_addition -->
						</ul>
						<!-- ELSE -->
						<ul>
							<li>
								<div class="user-tooltip-container">
									<a href="{EQDKP_CONTROLLER_PATH}Settings{SEO_EXTENSION}{SID}" class="user-tooltip-trigger tooltip-trigger" data-tooltip="user-tooltip"><span class="user-avatar user-avatar-border user-avatar-smallest"><img src="{USER_AVATAR}" alt="{USER_NAME}"/></span> <span class="hiddenSmartphone">{USER_NAME}<!-- IF USER_IS_AWAY --> <i class="fa fa-suitcase fa-lg"></i><!-- ENDIF --></span></a>
									<ul class="dropdown-menu user-tooltip" role="menu" id="user-tooltip">
										<li>
											<a href="{U_USER_PROFILE}">
												<div class="user-tooltip-avatar">
													<img src="{USER_AVATAR}" alt="{USER_NAME}"/>
												</div>
												<div class="user-tooltip-name">
													<span class="bold">{USER_NAME}</span><br />
														{L_my_profile}
												</div>
											</a>
										</li>
										<li class="tooltip-divider"></li>
										<!-- BEGIN user_tooltip_addition -->
										<li class="{user_tooltip_addition.CLASS}">{user_tooltip_addition.TEXT}</li>
										<!-- END user_tooltip_addition -->
										<!-- IF USER_IS_AWAY -->
										<li class="user_tooltip_awaymode"><a href="{EQDKP_CONTROLLER_PATH}Settings{SEO_EXTENSION}{SID}#fragment-calendar"><i class="fa fa-suitcase fa-lg"></i> {L_calendar_user_is_away}</a></li>
										<!-- ENDIF -->
										<li><a href="{EQDKP_CONTROLLER_PATH}Settings{SEO_EXTENSION}{SID}"><i class="fa fa-cog fa-lg"></i> {L_settings}</a></li>
										<li><a href="{U_LOGOUT}"><i class="fa fa-sign-out fa-lg"></i> {L_logout}</a></li>
									</ul>
								</div>
							</li>
							<!-- IF S_ADMIN -->
							<li>
								<div class="admin-tooltip-container">
									<a href="{EQDKP_ROOT_PATH}admin/{SID}" class="admin-tooltip-trigger tooltip-trigger" data-tooltip="admin-tooltip"><i class="fa fa-cog fa-lg"></i> <span class="hiddenSmartphone">{L_menu_admin_panel}</span></a>
									<ul class="dropdown-menu admin-tooltip" role="menu" id="admin-tooltip">
										<li><a href="{EQDKP_ROOT_PATH}admin/{SID}"><i class="fa fa-cog fa-lg"></i> {L_menu_admin_panel}</a></li>
										<li class="tooltip-divider"></li>
										<div class="nav-header floatLeft">{L_favorits}</div>
										<div class="nav-header floatRight hand" title="{L_settings}"><i class="fa fa-cog fa-lg" onclick="window.location='{EQDKP_ROOT_PATH}admin/manage_menus.php{SID}&tab=1'"></i></div>
										<!-- BEGIN admin_tooltip -->
										<li><a href="{EQDKP_ROOT_PATH}{admin_tooltip.LINK}"><i class="fa {admin_tooltip.ICON} fa-lg"></i> {admin_tooltip.TEXT}</a></li>
										<!-- END admin_tooltip -->
									</ul>
								</div>
								<!-- ENDIF -->
								
								<!-- IF U_CHARACTERS != "" --><li><a href="{U_CHARACTERS}"><i class="fa fa-group fa-lg"></i> <span class="hiddenSmartphone">{L_menu_members}</span></a></li><!-- ENDIF -->
								
								<!-- IF S_MYCHARS_POINTS and U_CHARACTERS != "" -->
									<li class="hiddenSmartphone">
										<div class="mychars-points-tooltip-container">
										<a class="mychars-points-tooltip-trigger tooltip-trigger" data-tooltip="mychars-points-tooltip"><i class="fa fa-trophy fa-lg"></i> <span class="mychars-points-target"></span></a>
										<ul class="dropdown-menu mychars-points-tooltip" role="menu" id="mychars-points-tooltip"><li>
											<table>
											<!-- BEGIN mychars_points -->
												<tr <!-- IF mychars_points.IS_MAIN -->class="main"<!-- ENDIF --> id="mcp{mychars_points.ID}">
													<td class="nowrap char hand"><span class="icons">{mychars_points.CHARICON}</span> {mychars_points.CHARNAME}</td>
													<td>{mychars_points.POOLNAME}</td>
													<td class="nowrap current">{mychars_points.CURRENT}</td>
													<td><a href="{mychars_points.CHARLINK}"><i class="fa fa-external-link fa-lg"></i></a></td>
												</tr>
											<!-- END mychars_points -->
											</table></li>
										</ul>
									</div>
									</li>
								<!-- ENDIF -->
								
								<li>
									<div class="notification-tooltip-container">
										<a class="notification-tooltip-trigger"><i class="fa fa-bell fa-lg"></i> <span class="hiddenSmartphone">{L_notifications}</span></a>
										<span class="notification-tooltip-trigger bubble-red notification-bubble-red hand" <!-- IF NOTIFICATION_COUNT_RED == 0 -->style="display:none;"<!-- ENDIF --> >{NOTIFICATION_COUNT_RED}</span>
										<span class="notification-tooltip-trigger bubble-yellow notification-bubble-yellow hand" <!-- IF NOTIFICATION_COUNT_YELLOW == 0 -->style="display:none;"<!-- ENDIF -->>{NOTIFICATION_COUNT_YELLOW}</span>
										<span class="notification-tooltip-trigger bubble-green notification-bubble-green hand" <!-- IF NOTIFICATION_COUNT_GREEN == 0 -->style="display:none;"<!-- ENDIF -->>{NOTIFICATION_COUNT_GREEN}</span>
										<ul class="dropdown-menu notification-tooltip" role="menu" id="notification-tooltip-all">
											<li class="notification-action-bar">
												<div class="floatLeft">
													<span class="bubble-red notification-bubble-red notification-filter hand" <!-- IF NOTIFICATION_COUNT_RED == 0 -->style="display:none;"<!-- ENDIF --> >{NOTIFICATION_COUNT_RED}</span>
													<span class="bubble-yellow notification-bubble-yellow notification-filter hand" <!-- IF NOTIFICATION_COUNT_YELLOW == 0 -->style="display:none;"<!-- ENDIF -->>{NOTIFICATION_COUNT_YELLOW}</span>
													<span class="bubble-green notification-bubble-green notification-filter hand" <!-- IF NOTIFICATION_COUNT_GREEN == 0 -->style="display:none;"<!-- ENDIF -->>{NOTIFICATION_COUNT_GREEN}</span>
												</div>
													
												<div class="floatRight">
													<span class="hand notification-mark-all-read">{L_mark_all_as_read}</span> &bull; <span class="hand" onclick="window.location='{EQDKP_CONTROLLER_PATH}Settings{SEO_EXTENSION}{SID}#fragment-notifications'"><i class="fa fa-cog fa-lg"></i></span>
												</div>
												
												<div class="clear"></div>
											</li>
											<li class="tooltip-divider"></li>
											<li class="notification-content">
												<ul>{NOTIFICATIONS}</ul>
											</li>
											<li class="tooltip-divider"></li>
											<li class="notification-action-bar-btm"> <span class="hand" onclick="window.location='{EQDKP_CONTROLLER_PATH}Notifications{SEO_EXTENSION}{SID}'">{L_show_all}</span></li>
										</ul>
									</div>
								</li>
								
								
								<!-- IF S_SEARCH -->
								<li class="hiddenDesktop"><a href="{EQDKP_CONTROLLER_PATH}Search{SEO_EXTENSION}{SID}"><i class="fa fa-search"></i></a></li>
								<!-- ENDIF -->
								<!-- BEGIN personal_area_addition -->
								<li>{personal_area_addition.TEXT}</li>
								<!-- END personal_area_addition -->
							</ul>
						<!-- ENDIF -->
					</div>
				</div>
				<div class="personalAreaInnerRight">
					<div id="personalAreaTime" class="hiddenSmartphone">
						<ul>
							<li class="personalAreaTime"><i class="fa fa-clock-o fa-lg"></i> <span class="user_time">{USER_TIME}</span></li>
							<!-- IF S_SEARCH -->
							<li>
								<form method="post" action="{EQDKP_CONTROLLER_PATH}Search{SEO_EXTENSION}{SID}" id="search_form">
									<input name="svalue" size="20" maxlength="30" class="input search" id="loginarea_search" type="text" value="{L_search}..."/>
									<button type="submit" class="search_button" value="" title="{L_search_do}">
										<i class="fa fa-search fa-lg"></i>
									</button>
								</form>
							</li>
							<!-- ENDIF -->
						</ul>
					</div>
					<div id="personalAreaMenuButton" class="fa fa-gitlab"></div>
				</div>
				<div class="clear"></div>
			</div> <!-- close personalArea -->
			
			<!-- TODO: check if we need this sub-class because dynamic personalArea height & JQ re-height menus -->
			<div class="controlPanelMenus">
				<div id="mainmenu">
					{MAIN_MENU} <!-- TODO: <responsive> check how to set the mobile_main_menu var -->
				</div>
				
				<div id="adminmenu">
					<div class="menu-header">
						<a href=""><img src="{EQDKP_ROOT_PATH}templates/admin/images/logo.svg" /></a></li>
						<a href=""><i class="fa fa-gitlab"></i></a>
					</div>
					
					{ADMIN_MENU}
				</div>
			</div>
		</header>
		
		
		
		
		
		
		<section style="text-align:center;">
			-- CONTENT --
		</section>
		
		<footer style="text-align:center;">
			-- FOOTER --
		</footer>
	</body>
</html>
<!-- ENDIF -->

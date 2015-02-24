<?php
/**
* Primary Hooks/Filters for ccBill.
*
* Copyright: © 2009-2011
* {@link http://www.optimizepress.com/ optimizePress, Inc.}
* ( coded in the USA )
*
* This WordPress plugin ( optimizeMember Pro ) is comprised of two parts:
*
* o (1) Its PHP code is licensed under the GPL license, as is WordPress.
* 	You should have received a copy of the GNU General Public License,
* 	along with this software. In the main directory, see: /licensing/
* 	If not, see: {@link http://www.gnu.org/licenses/}.
*
* o (2) All other parts of ( optimizeMember Pro ); including, but not limited to:
* 	the CSS code, some JavaScript code, images, and design;
* 	are licensed according to the license purchased.
* 	See: {@link http://www.optimizepress.com/prices/}
*
* Unless you have our prior written consent, you must NOT directly or indirectly license,
* sub-license, sell, resell, or provide for free; part (2) of the optimizeMember Pro Module;
* or make an offer to do any of these things. All of these things are strictly
* prohibited with part (2) of the optimizeMember Pro Module.
*
* Your purchase of optimizeMember Pro includes free lifetime upgrades via optimizeMember.com
* ( i.e. new features, bug fixes, updates, improvements ); along with full access
* to our video tutorial library: {@link http://www.optimizepress.com/videos/}
*
* @package optimizeMember\ccBill
* @since 1.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/*
Add the plugin Actions/Filters here.
*/
add_action ("init", "c_ws_plugin__optimizemember_pro_ccbill_return::ccbill_return", 1);
add_action ("init", "c_ws_plugin__optimizemember_pro_ccbill_notify::ccbill_notify", 1);
/**/
add_filter ("ws_plugin__optimizemember_during_constants_c", "c_ws_plugin__optimizemember_pro_ccbill_constants::ccbill_constants", 10, 2);
/**/
add_action ("ws_plugin__optimizemember_after_auto_eot_system", "c_ws_plugin__optimizemember_pro_ccbill_datalink::ccbill_datalink");
/**/
add_action ("ws_plugin__optimizemember_during_css", "c_ws_plugin__optimizemember_pro_ccbill_css_js::ccbill_css");
add_action ("ws_plugin__optimizemember_during_js_w_globals", "c_ws_plugin__optimizemember_pro_ccbill_css_js::ccbill_js_w_globals");
add_action ("ws_plugin__optimizemember_during_menu_pages_js", "c_ws_plugin__optimizemember_pro_ccbill_admin_css_js::ccbill_menu_pages_js");
/**/
add_filter ("ws_plugin__optimizemember_during_add_admin_options_add_divider_4", "c_ws_plugin__optimizemember_pro_ccbill_menu_pages::ccbill_admin_options", 10, 2);
/**/
add_action ("ws_plugin__optimizemember_during_scripting_page_during_left_sections_during_list_of_api_constants", "c_ws_plugin__optimizemember_pro_ccbill_menu_pages::ccbill_scripting_page_api_constants");
add_action ("ws_plugin__optimizemember_during_scripting_page_during_left_sections_during_list_of_api_constants_farm", "c_ws_plugin__optimizemember_pro_ccbill_menu_pages::ccbill_scripting_page_api_constants");
?>
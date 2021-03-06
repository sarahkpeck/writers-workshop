<?php
/**
* Return Templates ( introduced by optimizeMember Pro ).
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
* @package optimizeMember\Return_Templates
* @since 110720
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__optimizemember_pro_return_templates"))
	{
		/**
		* Return Templates ( introduced by optimizeMember Pro ).
		*
		* @package optimizeMember\Return_Templates
		* @since 110720
		*/
		class c_ws_plugin__optimizemember_pro_return_templates
			{
				/**
				* Applies custom Return Template Headers.
				*
				* @package optimizeMember\Return_Templates
				* @since 110720
				*
				* @attaches-to ``add_filter("ws_plugin__optimizemember_return_template_header");``
				*
				* @param str $default_header The default header *( i.e. HTML code )*, passed through by the Filter.
				* @param array $vars An array of defined variables, passed through by the Filter.
				* @return str A custom Return Template Header, if configured, else the ``$default_header``.
				*/
				public static function return_template_header ($default_header = FALSE, $vars = FALSE)
					{
						if (!empty ($GLOBALS["WS_PLUGIN__"]["optimizemember"]["o"]["pro_" . $vars["template"] . "_return_template_header"]))
							{
								$code = $GLOBALS["WS_PLUGIN__"]["optimizemember"]["o"]["pro_" . $vars["template"] . "_return_template_header"];
								$code = (!is_multisite () || !c_ws_plugin__optimizemember_utils_conds::is_multisite_farm () || is_main_site ()) ? c_ws_plugin__optimizemember_utilities::evl ($code) : $code;
								return ($custom_header = $code);
							}
						/**/
						return $default_header;
					}
			}
	}
?>
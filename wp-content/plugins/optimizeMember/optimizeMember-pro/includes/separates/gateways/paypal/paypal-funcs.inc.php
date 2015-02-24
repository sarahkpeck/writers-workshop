<?php
/**
* Loads functions created for PayPal.
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
* @package optimizeMember\PayPal
* @since 1.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/*
Include all functions that came with this Payment Gateway.
*/
if (is_dir ($ws_plugin__optimizemember_pro_temp_dir = dirname (dirname (dirname (dirname (__FILE__)))) . "/functions/separates/gateways/paypal"))
	foreach (scandir ($ws_plugin__optimizemember_pro_temp_dir) as $ws_plugin__optimizemember_pro_temp_s) /* Scan all files in this directory. */
		if (preg_match ("/\.php$/", $ws_plugin__optimizemember_pro_temp_s) && preg_match ("/^paypal-/i", $ws_plugin__optimizemember_pro_temp_s))
			include_once $ws_plugin__optimizemember_pro_temp_dir . "/" . $ws_plugin__optimizemember_pro_temp_s;
/**/
unset ($ws_plugin__optimizemember_pro_temp_dir, $ws_plugin__optimizemember_pro_temp_s);
?>
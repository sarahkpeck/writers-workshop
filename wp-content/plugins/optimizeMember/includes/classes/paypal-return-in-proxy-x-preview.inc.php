<?php
/**
* optimizeMember's PayPal Auto-Return/PDT handler ( inner processing routine ).
*
* Copyright: © 2009-2011
* {@link http://www.optimizepress.com/ optimizePress, Inc.}
* ( coded in the USA )
*
* Released under the terms of the GNU General Public License.
* You should have received a copy of the GNU General Public License,
* along with this software. In the main directory, see: /licensing/
* If not, see: {@link http://www.gnu.org/licenses/}.
*
* @package optimizeMember\PayPal
* @since 110720
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__optimizemember_paypal_return_in_proxy_x_preview"))
	{
		/**
		* optimizeMember's PayPal Auto-Return/PDT handler ( inner processing routine ).
		*
		* @package optimizeMember\PayPal
		* @since 110720
		*/
		class c_ws_plugin__optimizemember_paypal_return_in_proxy_x_preview
			{
				/**
				* optimizeMember's PayPal Auto-Return/PDT handler ( inner processing routine ).
				*
				* @package optimizeMember\PayPal
				* @since 110720
				*
				* @param array $vars Required. An array of defined variables passed by {@link optimizeMember\PayPal\c_ws_plugin__optimizemember_paypal_return_in::paypal_return()}.
				* @return array|bool The original ``$paypal`` array passed in ( extracted ) from ``$vars``, or false when conditions do NOT apply.
				*/
				public static function cp ($vars = array ()) /* Conditional phase for ``c_ws_plugin__optimizemember_paypal_notify_in::paypal_notify()``. */
					{
						extract($vars); /* Extract all vars passed in from: ``c_ws_plugin__optimizemember_paypal_notify_in::paypal_notify()``. */
						/**/
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__optimizemember_during_paypal_return_before_explicit_x_preview", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$paypal["optimizemember_log"][] = "Test preview of Return Page `proxy_use`: ( `x_preview` ).";
						/**/
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__optimizemember_during_paypal_return_during_explicit_x_preview", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if ($custom_success_redirection) /* Using a custom success redirection URL? */
							$paypal["optimizemember_log"][] = "Redirecting Customer to a custom URL on success: " . $custom_success_redirection . ". Test preview of Return Page `proxy_use`: ( `x_preview` ).";
						else /* Else we use the default redirection URL for this scenario, which is the Home Page. */
							$paypal["optimizemember_log"][] = "Redirecting Customer to the Home Page. Test preview of Return Page `proxy_use`: ( `x_preview` ).";
						/**/
						echo c_ws_plugin__optimizemember_return_templates::return_template ($paypal["subscr_gateway"],/**/
						sprintf (_x ('<strong>Thank you! ( this is a preview, no action necessary ).</strong><br /><br />* Note: each of your Customers are returned back to your site immediately after they complete checkout. This Return Page displays a message and instructions for the Customer. optimizeMember may change the message and instructions dynamically, based on what the Customer is actually doing <em>( i.e. based on the type of transaction that is taking place )</em>.<br /><br /><em>* With <a href="%s" target="_blank">optimizeMember Pro</a> installed, it is possible to customize this Return Page in various ways.</em>', "s2member-front", "s2member"), esc_attr (c_ws_plugin__optimizemember_readmes::parse_readme_value ("Pro Module / Prices"))),/**/
						_x ("Continue ( Click Here )", "s2member-front", "s2member"), (($custom_success_redirection) ? $custom_success_redirection : home_url ("/")));
						/**/
						eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__optimizemember_during_paypal_return_after_explicit_x_preview", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						return apply_filters ("c_ws_plugin__optimizemember_paypal_return_in_proxy_x_preview", $paypal, get_defined_vars ());
					}
			}
	}
?>
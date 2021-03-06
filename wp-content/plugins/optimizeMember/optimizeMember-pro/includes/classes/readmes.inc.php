<?php
/**
* Handles readme parsing.
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
* @package optimizeMember\Readmes
* @since 1.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__optimizemember_pro_readmes"))
	{
		/**
		* Handles Readme parsing.
		*
		* @package optimizeMember\Readmes
		* @since 1.5
		*/
		class c_ws_plugin__optimizemember_pro_readmes
			{
				/**
				* Handles readme parsing.
				*
				* @package optimizeMember\Readmes
				* @since 1.5
				*
				* @param str $specific_path Optional. Path to a specific readme file to parse. Defaults to that of the software itself.
				* 	When/if a readme-dev.txt file is available, that will be used instead of the default readme.txt.
				* @param str $specific_section Optional. The title of a specific section to parse, instead of the entire file.
				* @param bool $_blank_targets Optional. Defaults to true. If false, no target attribute is used.
				* @param bool $process_wp_syntax Optional. Defaults to false.
				* 	If true, and WP Syntax is installed; it will be used to parse code samples.
				* @return str Parsed readme file, or a parsed readme file section; based on parameter configuration.
				*/
				public static function parse_readme ($specific_path = FALSE, $specific_section = FALSE, $_blank_targets = TRUE, $process_wp_syntax = FALSE)
					{
						if (!($path = $specific_path)) /* Was a specific path passed in? */
							{
								$path = dirname (dirname (dirname (__FILE__))) . "/readme.txt";
								$dev_path = dirname (dirname (dirname (__FILE__))) . "/readme-dev.txt";
								$path = (file_exists ($dev_path)) ? $dev_path : $path;
							}
						/**/
						return c_ws_plugin__optimizemember_readmes::parse_readme ($path, $specific_section, $_blank_targets, $process_wp_syntax);
					}
				/**
				* Parses readme specification keys.
				*
				* @package optimizeMember\Readmes
				* @since 1.5
				*
				* @param str $key A key *( within the specs section )*.
				* @param str $specific_path Optional. Path to a specific readme file to parse. Defaults to that of the software itself.
				* 	When/if a readme-dev.txt file is available, that will be used instead of the default readme.txt.
				* @return str|bool The value of the key, else false if not found.
				*/
				public static function parse_readme_value ($key = FALSE, $specific_path = FALSE)
					{
						if (!($path = $specific_path)) /* Was a specific path passed in? */
							{
								$path = dirname (dirname (dirname (__FILE__))) . "/readme.txt";
								$dev_path = dirname (dirname (dirname (__FILE__))) . "/readme-dev.txt";
								$path = (file_exists ($dev_path)) ? $dev_path : $path;
							}
						/**/
						return c_ws_plugin__optimizemember_readmes::parse_readme_value ($key, $path);
					}
			}
	}
?>
<?php

/**
 * Show system status, compatibility issues and provide users with ability to copy data to clipboard
 */
class OptimizePress_Sections_System_Status
{
    protected $sections;
    protected $plugins;
    protected $environment;
    protected $theme;

    /**
     * Initialize sections
     * @return array
     */
    public function sections()
    {
        if (!isset($this->sections)) {
            $sections = array(
                'environment'   => array(
                    'title'     => __('Environment', OP_SN),
                    'action'    => array($this, 'loadEnvironment'),
                ),
                'plugins'       => array(
                    'title'     => __('Plugins', OP_SN),
                    'action'    => array($this, 'loadPlugins'),
                ),
            );

            if (OP_TYPE === 'plugin') {
                $sections['theme'] = array(
                    'title'     => __('Theme', OP_SN),
                    'action'    => array($this, 'loadTheme'),
                );
            }

            $this->sections = apply_filters('op_edit_sections_system_status', $sections);
        }

        return $this->sections;
    }

    /**
     * Return active and installed plugins
     * @return array
     */
    protected function getPluginRows()
    {
        if (!isset($this->plugins)) {
            $installedPlugins   = get_plugins();
            $data               = array();

            if (count($installedPlugins) > 0) {
                foreach ($installedPlugins as $pluginId => $plugin) {
                    if (is_plugin_active($pluginId)) {
                        $key = 'active';
                    } else {
                        $key = 'inactive';
                    }

                    $data[$key]['formatted'][]  = sprintf('<a target="_blank" href="%1$s">%2$s</a> by %3$s, version %4$s', $plugin['PluginURI'], $plugin['Name'], $plugin['Author'], $plugin['Version']);
                    $data[$key]['raw'][]        = "\t" . sprintf('%1$s by %2$s, version %3$s', $plugin['Name'], $plugin['Author'], $plugin['Version']);
                }

                if (isset($data['active'])) {
                    $this->plugins['active'] = array(
                        'status'        => 'ok',
                        'label'         => __('Active', OP_SN),
                        'message'       => implode('<br>', $data['active']['formatted']),
                        'raw_message'   => "\n" . implode("\n", $data['active']['raw']) . "\n",
                    );
                }

                if (isset($data['inactive'])) {
                    $this->plugins['inactive'] = array(
                        'status'        => 'ok',
                        'label'         => __('Inactive', OP_SN),
                        'message'       => implode('<br>', $data['inactive']['formatted']),
                        'raw_message'   => "\n" . implode("\n", $data['inactive']['raw']) . "\n",
                    );
                }
            } else {
                $this->plugins = array();
            }
        }

        return $this->plugins;
    }

    /**
     * Output plugins through "items" template sectino
     * @return void
     */
    public function loadPlugins()
    {
        echo op_load_section('items', array('items' => $this->getPluginRows(), 'open' => false, 'section' => 'plugins', 'label' => __('Plugins', OP_SN)), 'system_status');
    }

    /**
     * Return environment data
     * @return array
     */
    protected function getEnvironmentRows()
    {
        if (!isset($this->environment)) {
            global $wpdb, $wp_version;

            $items['home_url'] = array(
                'status'        => 'ok',
                'label'         => __('Home URL', OP_SN),
                'message'       => home_url(),
            );
            $items['site_url'] = array(
                'status'        => 'ok',
                'label'         => __('Site URL', OP_SN),
                'message'       => site_url(),
            );
            if (version_compare($wp_version, '3.5', '<')) {
                $items['wp_version'] = array(
                    'status'    => 'warning',
                    'label'     => __('WP Version', OP_SN),
                    'message'   => sprintf(__('Your WordPress version (%s) is lower than recommended (%s).', OP_SN), $wp_version, '3.5'),
                );
            } else {
                $items['wp_version'] = array(
                    'status'    => 'ok',
                    'label'     => __('WP Version', OP_SN),
                    'message'   => $wp_version,
                );
            }
            $items['wp_multisite'] = array(
                'status'        => 'ok',
                'label'         => __('WP Multisite Enabled', OP_SN),
                'message'       => is_multisite() ? __('Yes', OP_SN) : __('No', OP_SN),
            );

            // Server settings
            $items['web_server'] = array(
                'status'        => 'ok',
                'label'         => __('Web Server', OP_SN),
                'message'       => esc_html($_SERVER['SERVER_SOFTWARE']),
            );
            if (version_compare(PHP_VERSION, '5.3', '<')) {
                $items['php_version'] = array(
                    'label'     => __('PHP Version', OP_SN),
                    'status'    => 'warning',
                    'message'   => sprintf(__('Your PHP version (%s) is lower than recommended (%s).', OP_SN), PHP_VERSION, '5.3'),
                );
            } else {
                $items['php_version'] = array(
                    'label'     => __('PHP Version', OP_SN),
                    'status'    => 'ok',
                    'message'   => PHP_VERSION,
                );
            }
            if (version_compare($wpdb->db_version(), '5.0', '<')) {
                $items['mysql_version'] = array(
                    'label'     => __('MySQL Version', OP_SN),
                    'status'    => 'error',
                    'message'   => sprintf(__('Your MySQL version (%s) is lower than required (%s).', OP_SN), $wpdb->db_version(), '5.0'),
                );
            } else {
                $items['mysql_version'] = array(
                    'label'     => __('MySQL Version', OP_SN),
                    'status'    => 'ok',
                    'message'   => $wpdb->db_version(),
                );
            }
            $items['suhosin_installed'] = array(
                'label'     => __('Suhosin Installed', OP_SN),
                'status'    => 'ok',
                'message'   => extension_loaded('suhosin') ? __('Yes', OP_SN) : __('No', OP_SN),
            );

            $inputVars = ini_get('max_input_vars');
            if ($inputVars < 3000) {
                $items['input_vars'] = array(
                    'label'     => __('Max Input Vars', OP_SN),
                    'status'    => 'info',
                    'message'   => sprintf(__('Your "max_input_vars" setting is set to %s. If you plan to have pages with a large number of elements on it, you should raise this setting to at least %s.', OP_SN), $inputVars ?: 1000, 3000),
                );
            } else {
                $items['input_vars'] = array(
                    'label'     => __('Max Input Vars', OP_SN),
                    'status'    => 'ok',
                    'message'   => $inputVars,
                );
            }

            $executionTime = ini_get('max_execution_time');
            if ($executionTime < 60) {
                $items['execution_time'] = array(
                    'label'     => __('Max Execution Time', OP_SN),
                    'status'    => 'info',
                    'message'   => sprintf(__('Your "max_execution_time" setting (%s) is lower than recommended (%s).', OP_SN), $executionTime ?: 30, 60),
                );
            } else {
                $items['execution_time'] = array(
                    'label'     => __('Max. Execution Time', OP_SN),
                    'status'    => 'ok',
                    'message'   => $executionTime,
                );
            }

            // $postMaxSize = wp_convert_hr_to_bytes(ini_get('post_max_size')) / 1024 / 1024;
            // if ($postMaxSize < 32) {
            //     $items['post_size'] = array(
            //         'label'     => __('PHP POST Max Size', OP_SN),
            //         'status'    => 'ok',
            //         'message' => sprintf(__('Your PHP POST max size (%sMB) is lower than recommended (%sMB).', OP_SN), $postMaxSize, 32),
            //     );
            // } else {
            //     $items['post_size'] = array(
            //         'label'     => __('PHP POST Max Size', OP_SN),
            //         'status'    => 'ok',
            //         'message'   => $postMaxSize . 'MB',
            //     );
            // }

            $memoryLimit = wp_convert_hr_to_bytes(ini_get('memory_limit')) / 1024 / 1024;
            if ($memoryLimit < 64) {
                $items['memory'] = array(
                    'label'     => __('PHP Memory Limit', OP_SN),
                    'status'    => 'warning',
                    'message'   => sprintf(__('Your PHP memory limit (%sMB) is lower than recommended (%sMB)', OP_SN), $memoryLimit, 64),
                );
            } else {
                $items['memory'] = array(
                    'label'     => __('PHP Memory Limit', OP_SN),
                    'status'    => 'ok',
                    'message'   => $memoryLimit . 'MB',
                );
            }

            // WordPress settings
            $wpMemoryLimit = wp_convert_hr_to_bytes(WP_MEMORY_LIMIT) / 1024 / 1024;
            if ($wpMemoryLimit < 64) {
                $items['wp_memory'] = array(
                    'label'     => __('WP Memory Limit', OP_SN),
                    'status'    => 'warning',
                    'message'   => sprintf(__('Your WP memory limit (%sMB) is lower than recommended (%sMB)', OP_SN), $wpMemoryLimit, 64),
                );
            } else {
                $items['wp_memory'] = array(
                    'label'     => __('WP Memory Limit', OP_SN),
                    'status'    => 'ok',
                    'message'   => $wpMemoryLimit . 'MB',
                );
            }

            $uploadLimit = wp_max_upload_size() / 1024 / 1024;
            if ($uploadLimit < 32) {
                $items['upload_limit'] = array(
                    'label'     => __('WP Max Upload Size', OP_SN),
                    'status' => 'warning',
                    'message' => sprintf(__('Your WP upload limit (%sMB) is lower than recommended (%sMB).', OP_SN), $uploadLimit, 32),
                );
            } else {
                $items['upload_limit'] = array(
                    'label'     => __('WP Max Upload Size', OP_SN),
                    'status' => 'ok',
                    'message' => $uploadLimit . 'MB',
                );
            }
            // Transfer protocols (curl, streams)
            $http = new Wp_Http();
            if (false === $http->_get_first_available_transport(array())) {
                $items['transfer'] = array(
                    'label'     => __('WP Transport Protocols', OP_SN),
                    'status' => 'error',
                    'message' => __('There are no transport protocols (curl, streams) that are capable of handling the requests.', OP_SN),
                );
            } else {
                $items['transfer'] = array(
                    'label'     => __('WP Transport Protocols', OP_SN),
                    'status' => 'ok',
                    'message' => __('Transfer protocols (curl, streams) are in order.', OP_SN),
                );
            }
            if ('' === $permalinkStructure = get_option('permalink_structure', '')) {
                $items['permalink'] = array(
                    'label'     => __('Permalink Structure', OP_SN),
                    'status' => 'error',
                    'message' => sprintf(__('Permalink structure must not be set to "default" for OptimizePress to work correctly. Please change the <a href="%s">setting</a>.', OP_SN), admin_url('options-permalink.php')),
                );
            } else {
                $items['permalink'] = array(
                    'label'     => __('Permalink Structure', OP_SN),
                    'status' => 'ok',
                    'message' => __('Permalink structure is in order.', OP_SN),
                );
            }

            // OptimizePress special params
            $items['op_type'] = array(
                'label'     => __('OptimizePress Type', OP_SN),
                'status'    => 'ok',
                'message'   => OP_TYPE
            );
            $items['op_version'] = array(
                'label'     => __('OptimizePress Version', OP_SN),
                'status'    => 'ok',
                'message'   => OP_VERSION
            );

            if (false === $opCheck = get_transient('op_system_status_check')) {
                $opCheck = array(
                    'ping'          => op_sl_ping(),
                    'eligibility'   => op_sl_eligible(),
                );
                set_transient('op_system_status_check', $opCheck, MINUTE_IN_SECONDS * 5);
            }

            if (true !== $opCheck['ping']) {
                $items['op_sl'] = array(
                    'label'     => __('OptimizePress Outgoing Connection', OP_SN),
                    'status' => 'error',
                    'message' => __('Unable to connect to OptimizePress Security & Licensing service.', OP_SN),
                );
            } else {
                $items['op_sl'] = array(
                    'label'     => __('OptimizePress Outgoing Connection', OP_SN),
                    'status' => 'ok',
                    'message' => __('Connection OK.', OP_SN),
                );
            }

            if (true !== $opCheck['eligibility']) {
                $items['op_eligibility'] = array(
                    'label'     => __('OptimizePress Updates', OP_SN),
                    'status'    => 'warning',
                    'message'   => sprintf(__('You are not eligible for new updates. You can prolong your subscription <a href="%s" target="_blank">here</a>.', OP_SN), 'http://optimizepress.com/updates-renewal/'),
                );
            } else {
                $items['op_eligibility'] = array(
                    'label'     => __('OptimizePress Updates', OP_SN),
                    'status'    => 'ok',
                    'message'   => __('Eligible for new updates.', OP_SN),
                );
            }

            $this->environment = $items;
        }


        return $this->environment;
    }

    /**
     * Ouptut environment data through "items" template
     * @return void
     */
    public function loadEnvironment()
    {
        echo op_load_section('items', array('items' => $this->getEnvironmentRows(), 'open' => true, 'section' => 'environment', 'label' => __('Environment', OP_SN)), 'system_status');
    }

    /**
     * Return theme data
     * @return array
     */
    protected function getThemeRows()
    {
        if (!isset($this->theme)) {
            $activeTheme    = wp_get_theme();
            $this->theme    = array(
                'theme_name'    => array(
                    'status'    => 'ok',
                    'label'     => __('Theme Name', OP_SN),
                    'message'   => $activeTheme->Name,
                ),
                'theme_version' => array(
                    'status'    => 'ok',
                    'label'     => __('Theme Version', OP_SN),
                    'message'   => $activeTheme->Version,
                ),
                'theme_author_uri'  => array(
                    'status'    => 'ok',
                    'label'     => __('Theme Author URL', OP_SN),
                    'message'   => $activeTheme->{'Author URI'},
                ),
            );
        }

        return $this->theme;
    }

    /**
     * Output theme data
     * @return void
     */
    public function loadTheme()
    {
        echo op_load_section('items', array('items' => $this->getThemeRows(), 'open' => false, 'section' => 'theme', 'label' => __('Theme', OP_SN)), 'system_status');
    }
}
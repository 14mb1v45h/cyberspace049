<?php

namespace 14mb1v45h\MalwareScanner\Admin;

use 14mb1v45h\MalwareScanner\Core\Helper;

class AdminPage {

    /**
     * Register admin menu, submenu and enqueue admin assets.
     */
    public function register() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);  // Enqueue assets here
    }
    
    /**
     * Add the admin menu and submenu pages.
     */
    public function add_admin_menu() {
        add_menu_page(
            'Malware Scanner',
            'Malware Scanner',
            'manage_options',
            'malware-scanner',
            [$this, 'render_main_page'],
            'dashicons-shield'
        );

        add_submenu_page(
            'malware-scanner',
            'Scan',
            'Scan',
            'manage_options',
            'malware-scanner-scanner',
            [$this, 'render_scanner_page']
        );

        add_submenu_page(
            'malware-scanner',
            'Yara Rules',
            'Yara Rules',
            'manage_options',
            'malware-scanner-yara-rules',
            [$this, 'render_yara_rules_page']
        );

        add_submenu_page(
            'malware-scanner',
            'Help',
            'Help',
            'manage_options',
            'malware-scanner-help',
            [$this, 'render_help_page']
        );

        add_submenu_page(
            'malware-scanner',
            'Settings',
            'Settings',
            'manage_options',
            'malware-scanner-settings',
            [$this, 'render_settings_page']
        );
    }

   /**
     * Enqueue CSS, JS, and Dashicons for the admin pages.
     */
    function enqueue_admin_assets() {
        // Enqueue Admin CSS
        wp_enqueue_style(
            'malware-scanner-admin-css',  // Handle
            plugin_dir_url(__FILE__) . 'assets/css/admin-styles.css',  // Path to CSS file
            [],  // Dependencies
            '1.0'  // Version
        );

        // Enqueue Admin JS
        wp_enqueue_script(
            'malware-scanner-admin-js',  // Handle
            plugin_dir_url(__FILE__) . 'assets/js/admin-scripts.js',  // Path to JS file
            ['jquery', 'chart-js'],  // Dependencies (jQuery, Chart.js)
            '1.0',  // Version
            true  // Load in footer
        );

        // Enqueue Dashicons (already loaded in the admin, but for completeness)
        wp_enqueue_style('dashicons');
    }

    /**
     * Function to render the dashboard overview page
     */
    public function render_main_page() {
        // Fetch the necessary data for the main dashboard
        $last_scan_date    = $this->get_last_scan_date();
        $files_scanned     = $this->get_files_scanned();
        $threats_detected  = $this->get_threats_detected();
        $threats_resolved  = $this->get_threats_resolved();
        $vulnerabilities_found = 0;  // Placeholder for now
        $next_scan_date    = $this->get_next_scan_date();
        $scan_frequency    = $this->get_scan_frequency();
        $recent_logs       = $this->get_recent_logs();
        $php_version       = phpversion();  // Get PHP version
        $wp_version        = get_bloginfo('version');  // Get WordPress version
        $active_yara_rules = $this->get_active_yara_rules();

        // Include the view to display these metrics
        include plugin_dir_path(__FILE__) . 'views/main.php';  // Corrected path to 'views'
    }

    // Placeholder methods to fetch data for the main page
    private function get_last_scan_date() { return '2024-09-18'; }
    private function get_files_scanned() { return 120; }
    private function get_threats_detected() { return 5; }
    private function get_threats_resolved() { return 4; }
    private function get_next_scan_date() { return '2024-09-20'; }
    private function get_scan_frequency() { return 'Daily'; }
    private function get_recent_logs() {
        return [
            ['date' => '2024-09-18', 'event' => 'Scan completed', 'details' => 'No issues detected'],
            ['date' => '2024-09-17', 'event' => 'Threat detected', 'details' => 'Malicious file found'],
            ['date' => '2024-09-16', 'event' => 'Threat resolved', 'details' => 'File was cleaned up'],
        ];
    }
    private function get_active_yara_rules() { return 25; }

    /**
     * Render the Scanner page content.
     */
    public function render_scanner_page() {
        include plugin_dir_path(__FILE__) . 'views/scanner.php';
    }

    /**
     * Render the Yara Rules page content.
     */
    public function render_yara_rules_page() {
        include plugin_dir_path(__FILE__) . 'views/yara_rules.php';
    }

    /**
     * Render the Schedule page content.
     */
    public function render_help_page() {
        include plugin_dir_path(__FILE__) . 'views/help.php';
    }

    /**
     * Render the Settings page content.
     */
    public function render_settings_page() {
        include plugin_dir_path(__FILE__) . 'views/settings.php';
    }
}

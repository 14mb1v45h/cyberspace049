<?php

namespace 14mb1v45h\MalwareScanner\Core;

class Activator {

    /**
     * Code to run during plugin activation.
     */
    public static function activate() {
        // Set default options for the plugin if they don't exist
        if (!get_option('malware_scanner_settings')) {
            $default_settings = [
                'scan_frequency' => 'weekly', // Default scan frequency
            ];
            update_option('malware_scanner_settings', $default_settings);
        }

        // Create a custom database table for logging scan results, if necessary
        self::create_scan_logs_table();

        // Schedule a cron job for malware scanning based on the selected frequency
        if (!wp_next_scheduled('malware_scanner_cron_job')) {
            wp_schedule_event(time(), 'weekly', 'malware_scanner_cron_job');
        }
    }

    /**
     * Create a custom database table to store scan logs.
     */
    private static function create_scan_logs_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'malware_scan_logs';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            scan_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            scan_result text NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
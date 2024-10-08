<?php

namespace 14mb1v45h\MalwareScanner\Core;

class Helper {

    /**
     * Format file sizes in a human-readable format.
     *
     * @param int $bytes The file size in bytes.
     * @param int $decimals The number of decimal places to show.
     *
     * @return string The formatted file size (e.g., '1.2 MB').
     */
    public static function format_file_size($bytes, $decimals = 2) {
        $size = ['B', 'KB', 'MB', 'GB', 'TB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . $size[$factor];
    }

    /**
     * Sanitize input data.
     *
     * @param string|array $data The data to sanitize.
     *
     * @return string|array The sanitized data.
     */
    public static function sanitize_input($data) {
        if (is_array($data)) {
            return array_map('sanitize_text_field', $data);
        }
        return sanitize_text_field($data);
    }

    /**
     * Check if the current user has the required capability.
     *
     * @param string $capability The capability to check (e.g., 'manage_options').
     *
     * @return bool True if the user has the required capability, false otherwise.
     */
    public static function user_has_capability($capability) {
        return current_user_can($capability);
    }

    /**
     * Retrieve the current plugin version from the main plugin file.
     *
     * @return string The plugin version.
     */
    public static function get_plugin_version() {
        if (!function_exists('get_plugin_data')) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }
        $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/malware-scanner/malware-scanner.php');
        return isset($plugin_data['Version']) ? $plugin_data['Version'] : '1.0.0';
    }

    /**
     * Generate a unique scan ID for logging or reference purposes.
     *
     * @return string The unique scan ID.
     */
    public static function generate_scan_id() {
        return uniqid('mscan_', true);
    }

    /**
     * Get the current time in MySQL format.
     *
     * @return string The current time in MySQL datetime format.
     */
    public static function get_current_time() {
        return current_time('mysql');
    }
}
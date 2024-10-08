<?php

namespace 14mb1v45h\MalwareScanner\Core;

class Deactivator {

    /**
     * Code to run during plugin deactivation.
     */
    public static function deactivate() {
        // Unschedule the malware scanner cron job
        $timestamp = wp_next_scheduled('malware_scanner_cron_job');
        if ($timestamp) {
            wp_unschedule_event($timestamp, 'malware_scanner_cron_job');
        }
        
        // (Optional) Clean up plugin-related data or options, if necessary
        // Uncomment the line below to remove the plugin settings on deactivation
        // delete_option('malware_scanner_settings');
    }
}
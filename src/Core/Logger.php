<?php

namespace 14mb1v45h\MalwareScanner\Core;

class Logger {

    /**
     * Write log messages to a specific log file.
     *
     * @param string $message The log message to write.
     * @param string $type The log type (e.g., 'info', 'error', 'warning').
     */
    public static function log( $message, $type = 'info' ) {
        $upload_dir = wp_upload_dir();
        $log_dir = $upload_dir['basedir'] . '/malware-scanner-logs';

        // Check if the logs directory exists, create it if not
        if ( !file_exists( $log_dir ) ) {
            wp_mkdir_p( $log_dir );
        }

        $log_file = $log_dir . '/malware-scanner.log';
        $timestamp = date('Y-m-d H:i:s');
        $formatted_message = sprintf("[%s] [%s]: %s", $timestamp, strtoupper($type), $message) . PHP_EOL;

        // Write the message to the log file
        error_log($formatted_message, 3, $log_file);
    }

    /**
     * Log information messages.
     *
     * @param string $message The log message.
     */
    public static function info( $message ) {
        self::log($message, 'info');
    }

    /**
     * Log warning messages.
     *
     * @param string $message The log message.
     */
    public static function warning( $message ) {
        self::log($message, 'warning');
    }

    /**
     * Log error messages.
     *
     * @param string $message The log message.
     */
    public static function error( $message ) {
        self::log($message, 'error');
    }
}
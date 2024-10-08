<?php

namespace 14mb1v45h\MalwareScanner\Core;

use 14mb1v45h\MalwareScanner\Core\Logger;

class Scanner {

    /**
     * Run the malware scan using Yara rules.
     *
     * @return void
     */
    public static function run_scan() {
        Logger::info('Malware scan initiated.');

        try {
            // Define the path where Yara rules are stored
            $yara_rules_path = plugin_dir_path(__FILE__) . '../../rules/malware_rules.yar';

            // Define the directory to scan (e.g., the wp-content directory)
            $scan_directory = WP_CONTENT_DIR;

            // Run the Yara scan
            $scan_results = self::execute_yara_scan($yara_rules_path, $scan_directory);

            // Process the results
            self::process_scan_results($scan_results);

            Logger::info('Malware scan completed successfully.');
        } catch (\Exception $e) {
            Logger::error('Error during malware scan: ' . $e->getMessage());
        }
    }

    /**
     * Execute the Yara scan.
     *
     * @param string $yara_rules_path The path to the Yara rules file.
     * @param string $scan_directory The directory to scan for malware.
     *
     * @return array The scan results.
     */
    private static function execute_yara_scan($yara_rules_path, $scan_directory) {
        // This is a mock function. You would replace this with actual Yara integration code.
        // Example Yara command execution via CLI (requires Yara CLI to be installed on the server).
        $command = sprintf('yara -r %s %s', escapeshellarg($yara_rules_path), escapeshellarg($scan_directory));

        // Execute the command
        $output = [];
        $return_var = null;
        exec($command, $output, $return_var);

        if ($return_var !== 0) {
            throw new \Exception('Yara scan failed with exit code ' . $return_var);
        }

        return $output;
    }

    /**
     * Process the results of the malware scan.
     *
     * @param array $scan_results The scan results from the Yara scan.
     * 
     * @return void
     */
    private static function process_scan_results($scan_results) {
        if (empty($scan_results)) {
            Logger::info('No malware detected.');
        } else {
            // Save results to the database or log them
            global $wpdb;
            $table_name = $wpdb->prefix . 'malware_scan_logs';

            foreach ($scan_results as $result) {
                $wpdb->insert(
                    $table_name,
                    [
                        'scan_date' => current_time('mysql'),
                        'scan_result' => $result,
                    ]
                );
                Logger::info('Malware detected: ' . $result);
            }
        }
    }
}
<?php

namespace 14mb1v45h\MalwareScanner\Core;

use 14mb1v45h\MalwareScanner\Core\Logger;

class YaraIntegration {

    /**
     * Path to the Yara rules file.
     *
     * @var string
     */
    private $yara_rules_path;

    /**
     * Constructor to set up the Yara rules path.
     *
     * @param string $rules_path The path to the Yara rules file.
     */
    public function __construct($rules_path) {
        $this->yara_rules_path = $rules_path;
    }

    /**
     * Run the Yara scan on a specified directory.
     *
     * @param string $directory The directory to scan for malware.
     * 
     * @return array The scan results.
     * @throws \Exception If the scan fails.
     */
    public function scan_directory($directory) {
        Logger::info('Starting Yara scan on directory: ' . $directory);

        // Validate Yara rules file
        if (!file_exists($this->yara_rules_path)) {
            throw new \Exception('Yara rules file not found: ' . $this->yara_rules_path);
        }

        // Validate scan directory
        if (!is_dir($directory)) {
            throw new \Exception('Invalid directory to scan: ' . $directory);
        }

        // Execute Yara scan command
        $command = sprintf('yara -r %s %s', escapeshellarg($this->yara_rules_path), escapeshellarg($directory));
        $output = [];
        $return_var = null;

        exec($command, $output, $return_var);

        // Check if the Yara scan was successful
        if ($return_var !== 0) {
            Logger::error('Yara scan failed with exit code: ' . $return_var);
            throw new \Exception('Yara scan failed. Exit code: ' . $return_var);
        }

        Logger::info('Yara scan completed successfully.');

        return $output;
    }

    /**
     * Run the Yara scan on a specific file.
     *
     * @param string $file_path The file path to scan for malware.
     * 
     * @return array The scan results.
     * @throws \Exception If the scan fails.
     */
    public function scan_file($file_path) {
        Logger::info('Starting Yara scan on file: ' . $file_path);

        // Validate Yara rules file
        if (!file_exists($this->yara_rules_path)) {
            throw new \Exception('Yara rules file not found: ' . $this->yara_rules_path);
        }

        // Validate file path
        if (!file_exists($file_path)) {
            throw new \Exception('Invalid file to scan: ' . $file_path);
        }

        // Execute Yara scan command
        $command = sprintf('yara %s %s', escapeshellarg($this->yara_rules_path), escapeshellarg($file_path));
        $output = [];
        $return_var = null;

        exec($command, $output, $return_var);

        // Check if the Yara scan was successful
        if ($return_var !== 0) {
            Logger::error('Yara scan on file failed with exit code: ' . $return_var);
            throw new \Exception('Yara scan failed on file. Exit code: ' . $return_var);
        }

        Logger::info('Yara scan on file completed successfully.');

        return $output;
    }
}
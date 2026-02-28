<?php

/**
 * System configuration manager
 * - Loads and validates environment variables
 * - Defines global constants for system settings
 * - Manages security rules and external service configs
 */

require_once __DIR__ . '/vendor/autoload.php';

try {
    // Load environment variables
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // Validate required fields
    $dotenv->required([
        'SITE_NAME',
        'SITE_DESCRIPTION',
        'SITE_URL'
    ])->notEmpty();

    // Core system settings
    define('SITE_NAME', $_ENV['SITE_NAME']);
    define('SITE_DESCRIPTION', $_ENV['SITE_DESCRIPTION']);
    define('SITE_URL', $_ENV['SITE_URL']);
    define('CLEANUP_DAYS', $_ENV['CLEANUP_DAYS'] ?? 0);
    
    // Optional settings with defaults
    define('DNS_SERVERS', $_ENV['DNS_SERVERS'] ?? '1.1.1.1, 8.8.8.8');
    define('VERIFY_SSL', isset($_ENV['VERIFY_SSL']) ? filter_var($_ENV['VERIFY_SSL'], FILTER_VALIDATE_BOOLEAN) : true);
    define('DISABLE_CACHE', isset($_ENV['DISABLE_CACHE']) ? filter_var($_ENV['DISABLE_CACHE'], FILTER_VALIDATE_BOOLEAN) : false);
    define('SELENIUM_HOST', $_ENV['SELENIUM_HOST'] ?? 'localhost:4444');
    define('CACHE_DIR', __DIR__ . '/cache');
    define('LANGUAGE', $_ENV['LANGUAGE'] ?? 'pt-br');

    // Logging configuration
    define('LOG_LEVEL', $_ENV['LOG_LEVEL'] ?? 'WARNING'); // DEBUG, INFO, WARNING, ERROR, CRITICAL
    define('LOG_DAYS_TO_KEEP', 7);

    // S3 cache configuration
    define('S3_CACHE_ENABLED', isset($_ENV['S3_CACHE_ENABLED']) ? filter_var($_ENV['S3_CACHE_ENABLED'], FILTER_VALIDATE_BOOLEAN) : false);
    
    if (S3_CACHE_ENABLED) {
        $dotenv->required([
            'S3_ACCESS_KEY',
            'S3_SECRET_KEY',
            'S3_BUCKET'
        ])->notEmpty();

        define('S3_ACCESS_KEY', $_ENV['S3_ACCESS_KEY']);
        define('S3_SECRET_KEY', $_ENV['S3_SECRET_KEY']);
        define('S3_BUCKET', $_ENV['S3_BUCKET']);
        define('S3_REGION', $_ENV['S3_REGION'] ?? 'us-east-1');
        define('S3_FOLDER', $_ENV['S3_FOLDER'] ?? 'cache/');
        define('S3_ACL', $_ENV['S3_ACL'] ?? 'private');
        define('S3_ENDPOINT', $_ENV['S3_ENDPOINT'] ?? null);
    }

    // Load security rules
    define('BLOCKED_DOMAINS', require __DIR__ . '/data/blocked_domains.php');
    define('DOMAIN_RULES', require __DIR__ . '/data/domain_rules.php');
    define('GLOBAL_RULES', require __DIR__ . '/data/global_rules.php');
    
    // Load DMCA domains from JSON file
    $dmcaDomainsFile = __DIR__ . '/cache/dmca_domains.json';
    if (file_exists($dmcaDomainsFile)) {
        $dmcaDomainsJson = file_get_contents($dmcaDomainsFile);
        $dmcaDomains = json_decode($dmcaDomainsJson, true);
        define('DMCA_DOMAINS', is_array($dmcaDomains) ? $dmcaDomains : []);
    } else {
        define('DMCA_DOMAINS', []);
    }

} catch (Dotenv\Exception\ValidationException $e) {
    die('Environment Error: ' . $e->getMessage());
} catch (Exception $e) {
    die('Configuration Error: ' . $e->getMessage());
}

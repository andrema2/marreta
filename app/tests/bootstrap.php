<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

if (!defined('DNS_SERVERS')) {
    define('DNS_SERVERS', '1.1.1.1,8.8.8.8');
}

if (!defined('CACHE_DIR')) {
    define('CACHE_DIR', __DIR__ . '/../cache');
}

if (!defined('DISABLE_CACHE')) {
    define('DISABLE_CACHE', true);
}

if (!defined('VERIFY_SSL')) {
    define('VERIFY_SSL', true);
}

if (!defined('S3_CACHE_ENABLED')) {
    define('S3_CACHE_ENABLED', false);
}

if (!defined('SITE_URL')) {
    define('SITE_URL', 'https://marreta.test');
}

if (!defined('LOG_LEVEL')) {
    define('LOG_LEVEL', 'INFO');
}

if (!defined('GLOBAL_RULES')) {
    define('GLOBAL_RULES', require __DIR__ . '/../data/global_rules.php');
}

if (!defined('DOMAIN_RULES')) {
    define('DOMAIN_RULES', require __DIR__ . '/../data/domain_rules.php');
}

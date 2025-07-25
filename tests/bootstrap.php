<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

new Dotenv()
    ->bootEnv(dirname(__DIR__) . '/.env');

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}

$phpqaPhpunitAutoload = '/tools/.composer/vendor-bin/phpunit/vendor/autoload.php';
if (file_exists($phpqaPhpunitAutoload)) {
    require_once $phpqaPhpunitAutoload;
}

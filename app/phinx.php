<?php

declare(strict_types=1);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);

if(file_exists(__DIR__ . '/.env')){
    $dotenv->load();
}

$dotenv->required([
    'DB_HOST',
    'DB_PORT',
    'DB_NAME',
    'DB_USER',
    'DB_PASS',
    'DB_CHARSET'
]);

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/database/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/database/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_environment' => 'mysql',
        'mysql' => [
            'adapter' => 'mysql',
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'name' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'pass' => $_ENV['DB_PASS'],
            'charset' => $_ENV['DB_CHARSET'],
            'collation' => 'utf8_unicode_ci'
        ],
    ],
    'version_order' => 'creation'
];

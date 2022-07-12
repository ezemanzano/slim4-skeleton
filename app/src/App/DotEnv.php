<?php

declare(strict_types=1);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');

if (file_exists(__DIR__ . '/../../.env')) {
    $dotenv->load();
}

$dotenv->required([
    'DB_HOST',
    'DB_PORT',
    'DB_NAME',
    'DB_USER',
    'DB_PASS',
]);
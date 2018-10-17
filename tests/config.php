<?php

use yii\db;

$dbType = getenv('DB_TYPE') ?: 'pgsql';
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbName = getenv('DB_NAME') ?: 'spi';

$dsn = "{$dbType}:host={$dbHost};dbname={$dbName}";

return [
    'id' => 'yii2-advanced-package',
    'basePath' => dirname(__DIR__),
    'components' => [
        'db' => [
            'class' => db\Connection::class,
            'dsn' => $dsn,
            'username' => getenv('DB_USER') ?: 'postgres',
            'password' => getenv('DB_PASS') ?: '',
        ],
    ],
];

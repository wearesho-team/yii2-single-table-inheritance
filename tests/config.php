<?php

use yii\db;

$dbType = getenv('DB_TYPE');
$host = getenv('DB_HOST');
$name = getenv("DB_NAME");
$port = getenv("DB_PORT");
$dsn = "{$dbType}:host={$host};dbname={$name};port={$port}";

return [
    'id' => 'yii2-advanced-package',
    'basePath' => dirname(__DIR__),
    'components' => [
        'db' => [
            'class' => db\Connection::class,
            'dsn' => $dsn,
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD') ?: '',
        ],
    ],
];

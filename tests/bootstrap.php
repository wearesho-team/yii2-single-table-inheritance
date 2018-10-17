<?php

if (file_exists(dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env')) {
    $dotEnv = new \Dotenv\Dotenv(dirname(__DIR__));
    $dotEnv->load();
}

Yii::setAlias('@Wearesho/Yii/SingleTableInheritance', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src');
Yii::setAlias('@Wearesho/Yii/SingleTableInheritance/Tests', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'tests');
Yii::setAlias('@configFile', __DIR__ . DIRECTORY_SEPARATOR . 'config.php');
